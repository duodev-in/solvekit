import { formatMoney } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { findIngredient, ingredient, kn, measure, parseAmount, toGrams, VOLUME, WEIGHT } from '../food/kitchen.js';
import { parseRows } from '../rows-editor.js';
import { tidyVolume } from './fd-convert.js';

/**
 * Tea, coffee and drinks: brew ratios, cold brew, caffeine in the body, coffee costs and footprint, tea brewing,
 * alcohol by volume, dilution, priming sugar, sulfite (SO₂) additions, Brix and gravity, and chilling drinks.
 */
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
const FLOZ = VOLUME.floz_us.ml;
const cToF = (c) => (c * 9) / 5 + 32;

// Drinks with caffeine: the USDA entry and a usual serving (fl oz, or grams for dry items).
export const DRINKS = {
    coffee: { name: 'Brewed coffee', key: 'coffee', floz: 8 },
    espresso: { name: 'Espresso (single shot)', key: 'espresso', floz: 1 },
    instant: { name: 'Instant coffee (1 tsp)', key: 'coffee_instant', grams: 2 },
    tea_black: { name: 'Black tea', key: 'tea_black', floz: 8 },
    tea_green: { name: 'Green tea', key: 'tea_green', floz: 8 },
    cola: { name: 'Cola', key: 'cola', floz: 12 },
    energy: { name: 'Energy drink (Red Bull)', key: 'energy_drink', grams: 258 },
    chocolate: { name: 'Dark chocolate (1 oz)', key: 'choc_dark', grams: 28.35 },
};

/** Grams of a drink serving: fluid ounces × the USDA density, or the stated grams. */
function servingGrams(drink, row, floz) {
    if (drink.grams) {
        return drink.grams * (Number.isFinite(floz) && floz > 0 && drink.floz ? floz / drink.floz : 1);
    }

    return (Number.isFinite(floz) && floz > 0 ? floz : drink.floz) * FLOZ * (row.cup / VOLUME.cup_us.ml);
}

export function drinkCaffeine(config, key, floz) {
    const drink = DRINKS[key];
    const row = ingredient(config, drink.key);

    return ((row.per100.caffeine ?? 0) * servingGrams(drink, row, floz)) / 100;
}

const findDrink = (text) => {
    const query = String(text ?? '').toLowerCase();

    return Object.entries(DRINKS).find(([key, d]) => key === query || d.name.toLowerCase() === query)?.[0]
        ?? Object.entries(DRINKS).find(([, d]) => d.name.toLowerCase().split(/[^a-z]+/).some((w) => w.length > 3 && query.includes(w)))?.[0] ?? null;
};

const clock = (minutes) => {
    const m = ((Math.round(minutes) % 1440) + 1440) % 1440;

    return `${String(Math.floor(m / 60)).padStart(2, '0')}:${String(m % 60).padStart(2, '0')}`;
};
const parseClock = (text) => {
    const match = String(text ?? '').trim().match(/^(\d{1,2}):?(\d{2})?\s*(am|pm)?$/i);

    if (!match) {
        return NaN;
    }

    let hours = Number(match[1]) % 24;

    if (match[3]) {
        hours = (hours % 12) + (match[3].toLowerCase() === 'pm' ? 12 : 0);
    }

    return hours * 60 + Number(match[2] ?? 0);
};

/**
 * Caffeine remaining at a time from doses taken earlier: each dose decays by half every half-life (absorption taken as immediate).
 */
export function caffeineAt(doses, minutes, halfLife) {
    return doses.filter((d) => d.at <= minutes).reduce((sum, d) => sum + d.mg * 0.5 ** ((minutes - d.at) / 60 / halfLife), 0);
}

// Coffee brew ratios (water : coffee by weight) for strong, medium and mild cups; espresso is dose : yield.
const METHODS = {
    drip: { name: 'a drip machine', ratios: [15, 17, 18] },
    pourover: { name: 'a pour-over (V60, Chemex)', ratios: [15, 16, 17] },
    french: { name: 'a French press', ratios: [12, 14, 16] },
    aeropress: { name: 'an AeroPress', ratios: [11, 14, 16] },
    moka: { name: 'a moka pot', ratios: [7, 8, 10] },
    espresso: { name: 'Espresso', ratios: [1.5, 2, 2.5] },
};
const STRENGTH = { strong: 0, medium: 1, mild: 2 };

/**
 * Brix to specific gravity (standard approximation used in brewing) and back.
 */
export const brixToSg = (brix) => 1 + brix / (258.6 - (brix / 258.2) * 227.1);
export const sgToBrix = (sg) => ((182.4601 * sg - 775.6821) * sg + 1262.7794) * sg - 669.5622;
/** Plato from SG (ASBC cubic). */
export const sgToPlato = (sg) => -616.868 + 1111.14 * sg - 630.272 * sg ** 2 + 135.997 * sg ** 3;

/**
 * Alcohol by volume from original and final gravity: the standard homebrew formula and the more accurate one for strong beers and wines.
 */
export function abv(og, fg) {
    return { standard: (og - fg) * 131.25, alternate: ((76.08 * (og - fg)) / (1.775 - og)) * (fg / 0.794) };
}

/** Final gravity from refractometer readings (Brix) before and after fermentation: Sean Terrill's cubic, wort correction 1.04. */
export function terrillFg(brixStart, brixEnd, wcf = 1.04) {
    const i = brixStart / wcf;
    const f = brixEnd / wcf;

    return 1 - 0.0044993 * i + 0.0117741 * f + 0.000275806 * i ** 2 - 0.00127169 * f ** 2 - 0.00000727999 * i ** 3 + 0.0000632929 * f ** 3;
}

/** CO₂ (volumes) left in beer after fermentation at its highest temperature (°F). */
export const residualCo2 = (f) => 3.0378 - 0.050062 * f + 0.00026555 * f ** 2;

/** Free SO₂ (mg/L) that gives a molecular SO₂ level at a wine pH (pKa 1.81). */
export const freeSo2For = (molecular, ph) => molecular * (1 + 10 ** (ph - 1.81));

// Potassium metabisulfite is 57.6% SO₂ by weight.
const KMS_SO2 = 0.576;

// Chilling a drink: time constants (minutes) for Newton's law of cooling, by container and method; approximate.
const CHILL = {
    can: { name: '12 oz aluminium can', tau: 1 },
    bottle: { name: '12 oz glass bottle', tau: 1.3 },
    wine: { name: '750 ml wine bottle', tau: 1.8 },
    pet: { name: '2 L plastic bottle', tau: 3.2 },
};
const METHOD_TAU = { fridge: { name: 'Refrigerator', tau: 73, temp: 3 }, freezer: { name: 'Freezer', tau: 70, temp: -18 }, ice: { name: 'Ice water (stirred now and then)', tau: 6, temp: 0 } };

const TEA = {
    black: { name: 'Black tea', grams: 2.5, tsp: 2.5, temp: [95, 100], time: [3, 5], caffeine: 'tea_black' },
    green: { name: 'Green tea', grams: 2.5, tsp: 2, temp: [75, 80], time: [2, 3], caffeine: 'tea_green' },
    white: { name: 'White tea', grams: 3, tsp: 1.5, temp: [75, 85], time: [4, 5], caffeine: null },
    oolong: { name: 'Oolong', grams: 3, tsp: 3, temp: [85, 95], time: [3, 5], caffeine: null },
    herbal: { name: 'Herbal (tisane)', grams: 2.5, tsp: 1.5, temp: [100, 100], time: [5, 7], caffeine: 'none' },
    rooibos: { name: 'Rooibos', grams: 2.5, tsp: 2.5, temp: [100, 100], time: [5, 7], caffeine: 'none' },
};

function ratioOutcome(i, c, ratio, methodName) {
    let coffee;
    let water;

    if (i.known === 'water') {
        water = i.amount;
        coffee = water / ratio;
    } else {
        coffee = i.amount;
        water = coffee * ratio;
    }

    if (!ok(coffee, water) || coffee <= 0) {
        return { empty: 'Enter the amount of coffee or water.' };
    }

    const espresso = methodName === 'Espresso';

    return {
        value: `${kn(coffee)} g`,
        label: espresso ? 'Coffee dose' : 'Ground coffee',
        sub: espresso ? `${kn(coffee)} g in, ${kn(water)} g out (1 : ${kn(ratio)})` : `${kn(water)} ml of water at 1 : ${kn(ratio)}${methodName ? ` in ${methodName}` : ''}`,
        rows: {
            water: espresso ? `${kn(water)} g of espresso in the cup` : `${kn(water)} ml (${tidyVolume(water)})`,
            ratio: `1 : ${kn(ratio)} (${kn(1000 / ratio)} g per litre)`,
            scoops: `${kn(coffee / 10)} coffee scoops (2 tbsp, about 10 g each)`,
            tbsp: `${kn(coffee / 5)} tablespoons of ground coffee`,
            brewed: espresso ? 'Espresso yield is by weight' : `About ${kn(water - 2 * coffee)} ml brewed (grounds hold about 2 ml per gram)`,
        },
    };
}

export const handlers = {
    coffee_ratio: (i, c) => {
        if (i.mode === 'ratio') {
            if (!ok(i.ratio) || i.ratio <= 0) {
                return { empty: 'Enter the ratio (for 1 : 16, enter 16).' };
            }

            return ratioOutcome(i, c, i.ratio, '');
        }

        const method = METHODS[i.method] ?? METHODS.drip;
        const ratio = method.ratios[STRENGTH[i.strength] ?? 1];

        if (i.method === 'espresso') {
            const dose = (i.shots ?? 1) * 9;

            return ratioOutcome({ known: 'coffee', amount: ok(dose) && dose > 0 ? dose : NaN }, c, ratio, 'Espresso');
        }

        const water = or0(i.cups) * or0(Number(i.cup_size)) * FLOZ;

        return ratioOutcome({ known: 'water', amount: water > 0 ? water : NaN }, c, ratio, method.name);
    },

    cold_brew: (i) => {
        const ratio = { strong: 4, concentrate: 5, ready: 8 }[i.style] ?? 5;
        const coffee = i.known === 'water' ? i.amount / ratio : i.amount;

        if (!ok(coffee) || coffee <= 0) {
            return { empty: 'Enter the coffee or water.' };
        }

        const water = coffee * ratio;
        // Wet grounds keep about 2 ml of water per gram of coffee.
        const yieldMl = water - 2 * coffee;
        const dilution = i.style === 'ready' ? 0 : or0(i.dilution);
        const drink = yieldMl * (1 + dilution);

        return {
            value: `${kn(coffee)} g`,
            label: 'Coarse ground coffee',
            sub: `${kn(water)} ml water (1 : ${ratio}) → about ${kn(yieldMl)} ml of ${i.style === 'ready' ? 'cold brew' : 'concentrate'}`,
            rows: {
                water: `${kn(water)} ml (${tidyVolume(water)})`,
                yield: `${kn(yieldMl)} ml after straining`,
                drink: i.style === 'ready' ? `${kn(drink)} ml, ready to drink` : `${kn(drink)} ml after diluting 1 : ${kn(dilution)} with water or milk`,
                servings: `${kn(drink / (8 * FLOZ))} servings of 8 fl oz over ice`,
                steep: '12–24 h in the fridge (or 12–18 h at room temperature), then strain; keeps about 1–2 weeks refrigerated',
            },
        };
    },

    coffee_cost: (i, c) => {
        const cupsYear = or0(i.cups) * or0(i.days) * 52;

        if (cupsYear <= 0) {
            return { empty: 'Enter cups a day and days a week.' };
        }

        const perCup = i.mode === 'home' ? (or0(i.bag_price) / Math.max(1, i.bag_grams)) * or0(i.grams_per_cup) + or0(i.extras) : or0(i.price);
        const caffeine = drinkCaffeine(c, i.brew ?? 'coffee', i.brew === 'espresso' ? 2 : Number(i.size));

        return {
            value: formatMoney(perCup * cupsYear),
            label: 'Coffee a year',
            sub: `${kn(cupsYear)} cups at ${formatMoney(perCup)} each`,
            rows: {
                month: formatMoney((perCup * cupsYear) / 12),
                perCup: formatMoney(perCup),
                beans: i.mode === 'home' ? `${kn((cupsYear * or0(i.grams_per_cup)) / 1000)} kg of coffee a year` : 'Bought by the cup',
                caffeine: `${kn(caffeine * or0(i.cups))} mg a day (FDA: up to 400 mg for most adults)`,
                tenYears: `${formatMoney(perCup * cupsYear * 10)} over 10 years`,
            },
        };
    },

    coffee_footprint: (i, c) => {
        const eco = c.data.eco;
        const cupsYear = or0(i.cups) * 365;

        if (cupsYear <= 0) {
            return { empty: 'Enter cups a day.' };
        }

        const beans = (cupsYear * or0(i.grams)) / 1000;
        const milkFactor = { none: 0, dairy: eco.milk.ghg, soy: eco.soy_milk.ghg }[i.milk] ?? 0;
        const milkL = (cupsYear * or0(i.milk_ml)) / 1000;
        const sugarKg = (cupsYear * or0(i.sugar) * 4.2) / 1000;
        const coffee = beans * eco.coffee.ghg;
        const milk = milkL * milkFactor;
        const sugar = sugarKg * eco.cane_sugar.ghg;
        const total = coffee + milk + sugar;

        return {
            value: `${kn(total)} kg`,
            unit: 'CO₂e a year',
            label: 'Footprint of your coffee',
            sub: `${kn((total * 1000) / cupsYear)} g CO₂e a cup (Poore & Nemecek 2018, farm to retail)`,
            rows: {
                coffee: `${kn(coffee)} kg (${kn(beans)} kg of coffee at ${kn(eco.coffee.ghg)} kg CO₂e/kg)`,
                milk: i.milk === 'none' ? 'No milk' : `${kn(milk)} kg (${kn(milkL)} L at ${kn(milkFactor)} kg CO₂e/L)`,
                sugar: `${kn(sugar)} kg`,
                share: total > 0 ? `Coffee ${kn((100 * coffee) / total)}%, milk ${kn((100 * milk) / total)}%` : '—',
                driving: `Like driving ${kn(total / 0.4)} miles in a typical car (EPA: about 400 g CO₂ a mile)`,
            },
        };
    },

    caffeine_curve: (i, c) => {
        const halfLife = ok(i.half_life) && i.half_life > 0 ? i.half_life : 5;
        const doses = parseRows(i.drinks).map(([time, drink, count]) => ({ at: parseClock(time), key: findDrink(drink), count: parseAmount(count) || 1, time, drink }))
            .filter((d) => Number.isFinite(d.at) && d.key).map((d) => ({ ...d, mg: drinkCaffeine(c, d.key) * d.count }))
            .sort((a, b) => a.at - b.at);

        if (!doses.length) {
            return { empty: 'Add drinks with a time (07:30) and a drink name.' };
        }

        const bed = parseClock(i.bedtime);
        const bedAt = Number.isFinite(bed) ? (bed < doses[0].at ? bed + 1440 : bed) : doses[doses.length - 1].at + 8 * 60;
        const atBed = caffeineAt(doses, bedAt, halfLife);
        const total = doses.reduce((sum, d) => sum + d.mg, 0);
        const peak = Math.max(...doses.map((d) => caffeineAt(doses, d.at, halfLife)));
        const last = doses[doses.length - 1].at;
        const below = (level) => {
            const now = caffeineAt(doses, last, halfLife);

            return now <= level ? last : last + Math.log2(now / level) * halfLife * 60;
        };
        const series = [];

        for (let m = doses[0].at; m <= Math.max(bedAt, last) + 120; m += 10) {
            series.push([m / 60, Math.round(caffeineAt(doses, m, halfLife))]);
        }

        const perKg = ok(i.weight) && i.weight > 0 ? peak / i.weight : NaN;

        return {
            value: `${kn(Math.round(atBed))} mg`,
            label: `Caffeine left at ${clock(bedAt)}`,
            sub: `${kn(Math.round(total))} mg taken today; half-life ${kn(halfLife)} h`,
            rows: {
                total: `${kn(Math.round(total))} mg (FDA: up to 400 mg a day for most healthy adults)`,
                peak: `${kn(Math.round(peak))} mg${Number.isFinite(perKg) ? ` (${kn(perKg)} mg/kg; EFSA: single doses up to 3 mg/kg are of no concern)` : ''}`,
                below100: peak <= 100 ? 'Never above 100 mg' : `Below 100 mg at ${clock(below(100))}`,
                below50: peak <= 50 ? 'Never above 50 mg' : `Below 50 mg at ${clock(below(50))}`,
            },
            grids: { drinks: { columns: ['Drink', 'Caffeine'], rows: doses.map((d) => ({ header: clock(d.at), cells: [`${d.count > 1 ? `${kn(d.count)} × ` : ''}${DRINKS[d.key].name}`, `${kn(Math.round(d.mg))} mg`] })) } },
            plots: { curve: { series, xLabel: 'Hour of the day', yLabel: 'Caffeine in the body (mg)', markers: [{ x: bedAt / 60, y: Math.round(atBed), label: 'Bedtime' }] } },
        };
    },

    healthy_coffee: (i, c) => {
        const sugarRow = ingredient(c, 'sugar');
        const lines = parseRows(i.drinks).map(([drink, size, milk, milkTbsp, sugarTsp, pumps]) => {
            const key = findDrink(drink);

            if (!key) {
                return null;
            }

            const d = DRINKS[key];
            const row = ingredient(c, d.key);
            const floz = parseAmount(size);
            const grams = servingGrams(d, row, floz);
            const milkMatch = milk && !/^(none|no|black|-)$/i.test(milk) ? findIngredient(c, milk) : null;
            const milkG = milkMatch ? toGrams(or0(parseAmount(milkTbsp)), 'tbsp_us', milkMatch.row) : 0;
            const sugarG = toGrams(or0(parseAmount(sugarTsp)), 'tsp_us', sugarRow);
            // A pump of coffee-shop syrup is about ¼ fl oz with 20 kcal and 5 g of sugar.
            const syrup = or0(parseAmount(pumps));
            const drinkSugar = ['cola', 'energy'].includes(key) ? (row.per100.sugar * grams) / 100 : 0;
            const kcal = (row.per100.kcal * grams) / 100 + (milkMatch ? (milkMatch.row.per100.kcal * milkG) / 100 : 0) + (sugarRow.per100.kcal * sugarG) / 100 + syrup * 20;

            return { name: d.name, caffeine: (row.per100.caffeine * grams) / 100, kcal, added: sugarG + syrup * 5 + drinkSugar, milk: milkMatch?.row.name };
        }).filter(Boolean);

        if (!lines.length) {
            return { empty: 'Add drinks (for example Brewed coffee, 12, Whole milk, 2, 1, 0).' };
        }

        const caffeine = lines.reduce((sum, l) => sum + l.caffeine, 0);
        const kcal = lines.reduce((sum, l) => sum + l.kcal, 0);
        const added = lines.reduce((sum, l) => sum + l.added, 0);
        const limit = i.sex === 'male' ? 36 : 25;

        return {
            value: `${kn(Math.round(caffeine))} mg`,
            label: 'Caffeine a day',
            sub: `${kn(Math.round(kcal))} kcal and ${kn(added)} g added sugar from ${lines.length} drinks`,
            rows: {
                caffeine: `${kn(Math.round(caffeine))} mg of 400 mg (FDA) — ${caffeine > 400 ? 'above' : 'within'} the guidance`,
                kcal: `${kn(Math.round(kcal))} kcal (${kn((100 * kcal) / 2000)}% of 2,000)`,
                sugar: `${kn(added)} g of ${limit} g (AHA daily limit for added sugar) — ${added > limit ? 'above' : 'within'}`,
                sugarKcal: `${kn(Math.round(added * 4))} kcal from added sugar (4 kcal a gram)`,
            },
            grids: { drinks: { columns: ['Caffeine', 'kcal', 'Added sugar'], rows: lines.map((l) => ({ header: l.name + (l.milk ? ` with ${l.milk.toLowerCase()}` : ''), cells: [`${kn(Math.round(l.caffeine))} mg`, kn(Math.round(l.kcal)), `${kn(l.added)} g`] })) } },
        };
    },

    tea: (i, c) => {
        const tea = TEA[i.type] ?? TEA.black;
        const water = or0(i.cups) * or0(Number(i.cup_size)) * FLOZ;

        if (water <= 0) {
            return { empty: 'Enter the cups and cup size.' };
        }

        const grams = (tea.grams * water) / 250;
        const caffeine = tea.caffeine === 'none' ? 'None (caffeine-free)' : tea.caffeine ? `About ${kn(Math.round(((ingredient(c, tea.caffeine).per100.caffeine * water) / 100) * (ingredient(c, tea.caffeine).cup / VOLUME.cup_us.ml)))} mg (USDA, brewed)` : 'Varies; usually between green and black tea';

        return {
            value: `${kn(grams)} g`,
            label: `${tea.name} leaves`,
            sub: `About ${measure(grams / tea.tsp, 'tsp_us')} for ${kn(water)} ml, at ${tea.temp[0] === tea.temp[1] ? `${tea.temp[0]} °C` : `${tea.temp[0]}–${tea.temp[1]} °C`} for ${tea.time[0]}–${tea.time[1]} min`,
            rows: {
                tsp: `${measure(grams / tea.tsp, 'tsp_us')}, at about ${kn(tea.tsp)} g a teaspoon of this tea`,
                temp: `${tea.temp[0] === tea.temp[1] ? `${tea.temp[0]} °C (${kn(cToF(tea.temp[0]))} °F)` : `${tea.temp[0]}–${tea.temp[1]} °C (${kn(Math.round(cToF(tea.temp[0])))}–${kn(Math.round(cToF(tea.temp[1])))} °F)`}`,
                time: `${tea.time[0]}–${tea.time[1]} minutes`,
                caffeine,
                iso: `ISO 3103 tasting brew: ${kn(water / 50)} g (2 g per 100 ml, 6 minutes)`,
            },
        };
    },

    abv: (i) => {
        let og = i.og;
        let fg = i.fg;

        if (i.mode === 'brix') {
            og = brixToSg(i.brix_start);
            fg = terrillFg(i.brix_start, i.brix_end);
        }

        if (!ok(og, fg) || og < 1 || fg < 0.98 || fg > og) {
            return { empty: i.mode === 'brix' ? 'Enter the Brix readings before and after fermentation.' : 'Enter the original and final gravity (final below original).' };
        }

        const a = abv(og, fg);
        const value = og > 1.07 ? a.alternate : a.standard;
        const abw = (0.79336 * value) / fg;
        const oe = sgToPlato(og);
        const ae = sgToPlato(fg);
        const re = 0.1808 * oe + 0.8192 * ae;
        // ASBC calories per 12 fl oz: (6.9 × ABW + 4.0 × (RE − 0.1)) × FG × 3.55.
        const kcal = (6.9 * abw + 4 * (re - 0.1)) * fg * 3.55;

        return {
            value: `${kn(value)}%`,
            label: 'Alcohol by volume',
            sub: `OG ${og.toFixed(3)} → FG ${fg.toFixed(3)}${og > 1.07 ? ' (high-gravity formula)' : ''}`,
            rows: {
                standard: `${kn(a.standard)}% ((OG − FG) × 131.25)`,
                alternate: `${kn(a.alternate)}% (for high gravity)`,
                abw: `${kn(abw)}%`,
                attenuation: `${kn((100 * (og - fg)) / (og - 1))}% apparent`,
                calories: `${kn(Math.round(kcal))} kcal per 12 fl oz (355 ml)`,
                gravity: i.mode === 'brix' ? `OG ${og.toFixed(3)}, FG ${fg.toFixed(3)} (Terrill, wort correction 1.04)` : `${kn(oe)} °P → ${kn(ae)} °P`,
            },
        };
    },

    dilution: (i) => {
        if (!ok(i.volume, i.abv, i.target) || i.volume <= 0 || i.target <= 0) {
            return { empty: 'Enter the volume, its strength and the target strength.' };
        }

        if (i.target >= i.abv) {
            return { error: 'The target must be weaker than the spirit (water can only dilute).' };
        }

        const final = (i.volume * i.abv) / i.target;
        const water = final - i.volume;
        const unit = i.unit === 'floz' ? 'fl oz' : i.unit === 'l' ? 'L' : 'ml';

        return {
            value: `${kn(water)} ${unit}`,
            label: 'Water to add',
            sub: `${kn(i.volume)} ${unit} at ${kn(i.abv)}% + ${kn(water)} ${unit} water = ${kn(final)} ${unit} at ${kn(i.target)}%`,
            rows: {
                final: `${kn(final)} ${unit} (before contraction)`,
                proof: `${kn(i.abv * 2)} → ${kn(i.target * 2)} US proof`,
                contraction: 'Ethanol and water shrink by up to about 4% when mixed, so the mix measures slightly less and a touch stronger; check with an alcoholmeter',
                alcohol: `${kn((i.volume * i.abv) / 100)} ${unit} of pure alcohol`,
            },
        };
    },

    chill: (i) => {
        const container = CHILL[i.container] ?? CHILL.can;
        const method = METHOD_TAU[i.method] ?? METHOD_TAU.fridge;
        const ambient = ok(i.ambient) && i.method !== 'ice' ? i.ambient : method.temp;

        if (!ok(i.start, i.target) || i.start <= i.target) {
            return { empty: 'Enter a start temperature above the target.' };
        }

        if (i.target <= ambient) {
            return { error: `The ${method.name.toLowerCase()} at ${kn(ambient)} °C cannot bring a drink to ${kn(i.target)} °C.` };
        }

        const tau = method.tau * container.tau;
        const minutes = tau * Math.log((i.start - ambient) / (i.target - ambient));
        const series = [];

        for (let t = 0; t <= minutes * 1.3; t += Math.max(1, minutes / 60)) {
            series.push([Math.round(t), Number(cToF(ambient + (i.start - ambient) * Math.exp(-t / tau)).toFixed(1))]);
        }

        return {
            value: minutes >= 90 ? `${kn(minutes / 60)} h` : `${kn(Math.round(minutes))} min`,
            label: 'Time to chill',
            sub: `${container.name} in the ${method.name.toLowerCase()}, ${kn(Math.round(cToF(i.start)))} °F → ${kn(Math.round(cToF(i.target)))} °F`,
            rows: {
                minutes: `${kn(Math.round(minutes))} minutes`,
                half: `${kn(Math.round(cToF((i.start + i.target) / 2)))} °F after ${kn(Math.round(tau * Math.log((i.start - ambient) / ((i.start + i.target) / 2 - ambient))))} min`,
                freezer: i.method === 'freezer' ? 'Set a timer: a can or bottle left too long can burst' : 'A freezer or a bucket of ice water is much faster',
                model: `Newton's law of cooling, time constant about ${kn(Math.round(tau))} min (approximate)`,
            },
            plots: { curve: { series, xLabel: 'Minutes', yLabel: 'Drink temperature (°F)', markers: [{ x: Math.round(minutes), y: Number(cToF(i.target).toFixed(1)), label: 'Ready' }] } },
        };
    },

    so2: (i) => {
        const liters = i.volume;
        const molecular = Number(i.molecular);

        if (!ok(liters, i.ph, molecular) || liters <= 0 || i.ph <= 0) {
            return { empty: 'Enter the wine volume, pH and target molecular SO₂.' };
        }

        const free = freeSo2For(molecular, i.ph);
        const add = Math.max(0, free - or0(i.current));
        const so2mg = add * liters;
        const kms = so2mg / KMS_SO2 / 1000;
        const tablet = ok(i.tablet) && i.tablet > 0 ? i.tablet : 0.44;

        return {
            value: `${kn(kms)} g`,
            label: 'Potassium metabisulfite to add',
            sub: `Raise free SO₂ from ${kn(or0(i.current))} to ${kn(free)} mg/L (${kn(add)} mg/L in ${kn(liters)} L)`,
            rows: {
                free: `${kn(free)} mg/L for ${kn(molecular)} mg/L molecular at pH ${kn(i.ph)}`,
                add: `${kn(add)} mg/L (${kn(so2mg)} mg SO₂)`,
                tablets: `${kn(kms / tablet)} Campden tablets of ${kn(tablet)} g`,
                solution: `${kn(so2mg / 57.6)} ml of 10% KMS solution (57.6 mg SO₂ per ml)`,
                note: free > 80 ? 'Above about 80 mg/L free SO₂ many people can smell it; lowering the pH needs less SO₂' : 'Add, stir gently and retest after a day',
            },
        };
    },

    sulfite: (i) => {
        const liters = i.volume;

        if (!ok(liters, i.ppm) || liters <= 0 || i.ppm <= 0) {
            return { empty: 'Enter the volume and the SO₂ level you want.' };
        }

        const so2mg = i.ppm * liters;
        const kms = so2mg / KMS_SO2 / 1000;
        const tablet = ok(i.tablet) && i.tablet > 0 ? i.tablet : 0.44;
        const sodium = so2mg / 0.674 / 1000;

        return {
            value: i.form === 'tablets' ? `${kn(kms / tablet)} tablets` : `${kn(kms)} g`,
            label: i.form === 'tablets' ? 'Campden tablets' : 'Potassium metabisulfite',
            sub: `${kn(i.ppm)} ppm (mg/L) SO₂ in ${kn(liters)} L = ${kn(so2mg)} mg of SO₂`,
            rows: {
                kms: `${kn(kms)} g potassium metabisulfite (57.6% SO₂); weigh it on a 0.01 g scale`,
                tablets: `${kn(kms / tablet)} Campden tablets of ${kn(tablet)} g (crush and dissolve)`,
                sodium: `${kn(sodium)} g sodium metabisulfite (67.4% SO₂), if that is what you have`,
                use: i.ppm >= 1000 ? 'Sanitising strength: rinse equipment, do not add to drinks' : 'Juice or must: wait 24 h before adding yeast; check the pH-based molecular level for finished wine',
            },
        };
    },

    priming: (i) => {
        const liters = i.volume;
        const fahrenheit = cToF(i.temp);

        if (!ok(liters, i.co2, fahrenheit) || liters <= 0 || i.co2 <= 0) {
            return { empty: 'Enter the beer volume, target carbonation and temperature.' };
        }

        const residual = residualCo2(fahrenheit);
        const needed = Math.max(0, i.co2 - residual);
        // Tinseth: 15.195 g of corn sugar per US gallon per volume of CO₂; table sugar about 91% of that.
        const corn = 15.195 * (liters / 3.785411784) * needed;
        const grams = i.sugar === 'table' ? corn * 0.91 : corn;

        return {
            value: `${kn(grams)} g`,
            label: i.sugar === 'table' ? 'Table sugar (sucrose)' : 'Corn sugar (dextrose)',
            sub: `${kn(needed)} volumes to add: ${kn(i.co2)} target − ${kn(residual)} already in the beer at ${kn(Math.round(fahrenheit))} °F`,
            rows: {
                ounces: `${kn(grams / WEIGHT.oz.g)} oz`,
                cups: i.sugar === 'table' ? `${measure(grams / 200, 'cup_us')} (USDA 200 g a cup)` : 'Weigh corn sugar; its volume varies with how it packs',
                residual: `${kn(residual)} volumes`,
                perBottle: `${kn(grams / (liters / 0.355))} g per 12 oz bottle if priming each bottle`,
            },
        };
    },

    brix: (i) => {
        if (!ok(i.value)) {
            return { empty: 'Enter a reading.' };
        }

        const sg = i.scale === 'sg' ? i.value : brixToSg(i.value);
        const brix = i.scale === 'sg' ? sgToBrix(i.value) : i.value;

        if (sg < 0.99 || sg > 1.2) {
            return { error: 'Readings run from about 0 to 45 °Bx (SG 1.000 to 1.200).' };
        }

        return {
            value: i.scale === 'sg' ? `${kn(brix)} °Bx` : sg.toFixed(3),
            label: i.scale === 'sg' ? 'Brix' : 'Specific gravity',
            sub: `SG ${sg.toFixed(3)} = ${kn(brix)} °Brix ≈ ${kn(sgToPlato(sg))} °Plato`,
            rows: {
                sg: sg.toFixed(3),
                brix: `${kn(brix)} °Bx (g sugar per 100 g of solution)`,
                plato: `${kn(sgToPlato(sg))} °P`,
                potential: `${kn(abv(sg, 1).standard)}% if fermented dry (to 1.000); ${kn(abv(sg, 1.01).standard)}% to 1.010`,
                sugar: `About ${kn(brix * sg * 10)} g of sugar per litre`,
            },
        };
    },
};

export default defineTools(handlers);
