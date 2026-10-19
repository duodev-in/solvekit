import { defineTools } from '../engines/formula.js';
import { findIngredient, fromGrams, ingredient, isVolume, isWeight, kn, lineGrams, measure, parseAmount, parseUnit, STICK_G, toGrams, unitShort, VOLUME, WEIGHT } from '../food/kitchen.js';
import { parseRows } from '../rows-editor.js';

/**
 * Cooking converters: cups, spoons and weights by ingredient (USDA densities), butter, pasta and rice yields,
 * herbs, garlic, yeast, oil and butter swaps, cake pans, oven temperatures, air fryers and recipe scaling.
 */
const ok = (...values) => values.every(Number.isFinite);
const cToF = (c) => (c * 9) / 5 + 32;
const fToC = (f) => ((f - 32) * 5) / 9;

/** Equivalents of a weight of one ingredient in the common units, as grid rows. */
function equivalents(grams, row) {
    const units = ['g', 'oz', 'lb', 'kg', 'cup_us', 'cup_metric', 'cup_label', 'cup_uk', 'tbsp_us', 'tbsp_metric', 'tbsp_au', 'tsp_us', 'ml'];

    return units
        .filter((unit) => isWeight(unit) || Number.isFinite(row?.cup))
        .map((unit) => ({ header: (VOLUME[unit] ?? WEIGHT[unit]).label, cells: [isVolume(unit) ? measure(fromGrams(grams, unit, row), unit) : `${kn(fromGrams(grams, unit, row))} ${unitShort(unit)}`] }));
}

// A page's fixed unit ('cup', 'tbsp', 'tsp') takes the cup or spoon standard chosen on the page.
const resolve = (unit, i) => ({ cup: i.standard || 'cup_us', tbsp: i.standard || 'tbsp_us', tsp: i.standard || 'tsp_us' })[unit] ?? unit;

function convertOutcome(i, c) {
    const row = ingredient(c, i.ingredient);

    if (!row) {
        return { empty: 'Choose an ingredient.' };
    }

    if (!ok(i.amount) || i.amount < 0) {
        return { empty: 'Enter the amount.' };
    }

    const from = resolve(c.from ?? i.from, i);
    const to = resolve(c.to ?? i.to, i);

    if ((isVolume(from) || isVolume(to)) && !Number.isFinite(row.cup)) {
        return { error: `${row.name} is not measured by volume in the USDA table; use weights.` };
    }

    const grams = toGrams(i.amount, from, row);
    const result = fromGrams(grams, to, row);
    const fromText = isVolume(from) ? measure(i.amount, from) : `${kn(i.amount)} ${unitShort(from)}`;
    const toText = isVolume(to) ? measure(result, to) : `${kn(result)} ${unitShort(to)}`;
    // The reverse rate reads best as one of the larger unit in the smaller one.
    const perTo = fromGrams(toGrams(1, to, row), from, row);
    const reverse = perTo >= 1 ? `1 ${unitShort(to)} = ${kn(perTo)} ${unitShort(from)}` : `1 ${unitShort(from)} = ${kn(1 / perTo)} ${unitShort(to)}`;

    return {
        value: kn(result),
        unit: unitShort(to) + (result >= 1.005 && /cup$/.test(unitShort(to)) ? 's' : ''),
        label: `${row.name}`,
        sub: `${fromText} of ${row.name.toLowerCase()} = ${toText}`,
        rows: {
            grams: `${kn(grams)} g`,
            ounces: `${kn(grams / WEIGHT.oz.g)} oz`,
            cups: Number.isFinite(row.cup) ? measure(grams / row.cup, 'cup_us') : 'Not measured by volume',
            tbsp: Number.isFinite(row.cup) ? measure((grams / row.cup) * 16, 'tbsp_us') : '—',
            reverse,
            density: Number.isFinite(row.cup) ? `${kn(row.cup)} g per US cup (USDA: ${row.measure})` : 'Weight only',
        },
        grids: { equivalents: { columns: ['Unit', row.name], rows: equivalents(grams, row) } },
    };
}

/** Kitchen-friendly volume: the largest of cup (from ¼), tablespoon (from 1) or teaspoon. */
export function tidyVolume(ml) {
    if (ml >= VOLUME.cup_us.ml / 4 - 0.5) {
        return measure(ml / VOLUME.cup_us.ml, 'cup_us');
    }

    if (ml >= VOLUME.tbsp_us.ml - 0.2) {
        return measure(ml / VOLUME.tbsp_us.ml, 'tbsp_us');
    }

    return measure(ml / VOLUME.tsp_us.ml, 'tsp_us');
}

/**
 * Scales recipe lines (amount, unit, ingredient) by a factor. Volumes are rewritten in the handiest spoon or cup,
 * eggs and other pieces are rounded to the nearest half, and weights in grams come from the USDA table when known.
 */
export function scaleRecipe(text, factor, config) {
    return parseRows(text)
        .map(([amountText, unitText, name]) => ({ amount: parseAmount(amountText), amountText: amountText ?? '', unitText: unitText ?? '', unit: parseUnit(unitText), name: name ?? '' }))
        .filter((line) => Number.isFinite(line.amount) && line.amount > 0)
        .map((line) => {
            const match = findIngredient(config, line.name);
            const scaled = line.amount * factor;
            let text;

            if (line.unit !== null && isVolume(line.unit)) {
                text = tidyVolume(scaled * VOLUME[line.unit].ml);
            } else if (line.unit !== null && isWeight(line.unit)) {
                text = `${kn(scaled)} ${unitShort(line.unit)}`;
            } else if (line.unit === 'stick') {
                text = measure(scaled, 'stick');
            } else {
                // Pieces (eggs, cloves): halves are the smallest practical step.
                const rounded = Math.max(0.5, Math.round(scaled * 2) / 2);
                text = `${kn(rounded)}${line.unitText ? ` ${line.unitText}` : ''}${Math.abs(rounded - scaled) > 0.01 ? ` (exactly ${kn(scaled)})` : ''}`;
            }

            const grams = match ? lineGrams(scaled, line.unit, match.row) : NaN;

            return { ...line, scaled, text, grams, match };
        });
}

function recipeGrid(lines) {
    return {
        columns: ['Original', 'Scaled', 'Weight'],
        rows: lines.map((line) => ({
            header: line.name || '—',
            cells: [`${line.amountText} ${line.unitText}`.trim(), line.text, Number.isFinite(line.grams) ? `${kn(line.grams)} g` : '—'],
        })),
    };
}

// Cake pans: volume = area × depth (in³); Bundt and tube pans by their capacity in cups.
const IN3_ML = 16.387064;

function panVolume(i, side) {
    const shape = i[`${side}_shape`];
    const scale = i.units === 'cm' ? 1 / 2.54 : 1;
    const depth = i[`${side}_depth`] * scale;

    if (shape === 'bundt') {
        return ok(i[`${side}_cups`]) && i[`${side}_cups`] > 0 ? { ml: i[`${side}_cups`] * VOLUME.cup_us.ml, area: NaN } : null;
    }

    const area = shape === 'round' ? (Math.PI * (i[`${side}_d`] * scale) ** 2) / 4 : shape === 'square' ? (i[`${side}_d`] * scale) ** 2 : i[`${side}_l`] * scale * i[`${side}_w`] * scale;

    return ok(area, depth) && area > 0 && depth > 0 ? { ml: area * depth * IN3_ML, area } : null;
}

const GAS = [[0.25, 225, 110, 'Very cool'], [0.5, 250, 120, 'Very cool'], [1, 275, 140, 'Cool'], [2, 300, 150, 'Cool'], [3, 325, 160, 'Warm'], [4, 350, 180, 'Moderate'],
    [5, 375, 190, 'Moderately hot'], [6, 400, 200, 'Hot'], [7, 425, 220, 'Hot'], [8, 450, 230, 'Very hot'], [9, 475, 240, 'Very hot']];
const gasText = (mark) => (mark === 0.25 ? '¼' : mark === 0.5 ? '½' : String(mark));

// Yeast: fresh : active dry : instant ≈ 1 : 0.4 : 0.33 by weight. A ¼ oz (7 g) packet holds 2¼ tsp; a fresh cake is 0.6 oz (17 g).
const YEAST = { fresh: { name: 'Fresh (compressed) yeast', factor: 1 }, active: { name: 'Active dry yeast', factor: 0.4 }, instant: { name: 'Instant (rapid-rise) yeast', factor: 0.33 } };
const DRY_TSP_G = 7 / 2.25;

function yeastGrams(amount, unit, type) {
    const per = { g: 1, oz: WEIGHT.oz.g, tsp: type === 'fresh' ? NaN : DRY_TSP_G, tbsp: type === 'fresh' ? NaN : DRY_TSP_G * 3, packet: type === 'fresh' ? NaN : 7, cake: type === 'fresh' ? 17 : NaN }[unit];

    return amount * per;
}

// Rice by type: USDA raw and cooked entries, and water per cup of rice (USA Rice Federation and package directions).
const RICE = {
    long: { name: 'White long-grain', raw: 'rice_white', cooked: 'rice_white_cooked', water: 2 },
    medium: { name: 'White medium-grain', raw: 'rice_medium', cooked: 'rice_medium_cooked', water: 1.5 },
    short: { name: 'White short-grain (sushi)', raw: 'rice_short', cooked: 'rice_short_cooked', water: 1.25 },
    basmati: { name: 'Basmati (white long-grain values)', raw: 'rice_white', cooked: 'rice_white_cooked', water: 1.5 },
    jasmine: { name: 'Jasmine (white long-grain values)', raw: 'rice_white', cooked: 'rice_white_cooked', water: 1.25 },
    brown: { name: 'Brown long-grain', raw: 'rice_brown', cooked: 'rice_brown_cooked', water: 2.25 },
    parboiled: { name: 'Parboiled (converted)', raw: 'rice_parboiled', cooked: 'rice_parboiled_cooked', water: 2.25 },
    wild: { name: 'Wild rice', raw: 'rice_wild', cooked: 'rice_wild_cooked', water: 3 },
};

/** Cooked-to-dry weight ratio from USDA energy density (a grain gains water, not calories, as it cooks). */
export const yieldRatio = (raw, cooked) => raw.per100.kcal / cooked.per100.kcal;

export { RICE };

export const handlers = {
    convert: convertOutcome,
    measure: convertOutcome,

    butter: (i) => {
        if (!ok(i.amount) || i.amount < 0) {
            return { empty: 'Enter an amount of butter.' };
        }

        // A cup is two 4 oz sticks (226.8 g; USDA 227 g), so a stick is exactly 8 tablespoons.
        const CUP = STICK_G * 2;
        const per = { stick: STICK_G, cup_us: CUP, tbsp_us: CUP / 16, tsp_us: CUP / 48, g: 1, kg: 1000, oz: WEIGHT.oz.g, lb: WEIGHT.lb.g, block250: 250, pack100: 100, pack500: 500 }[i.unit];
        const grams = i.amount * per;

        return {
            value: kn(grams),
            unit: 'g',
            label: 'Butter',
            sub: `${measure(grams / STICK_G, 'stick')} = ${measure(grams / CUP, 'cup_us')} = ${kn(grams / WEIGHT.oz.g)} oz`,
            rows: {
                sticks: measure(grams / STICK_G, 'stick'),
                cups: measure(grams / CUP, 'cup_us'),
                tbsp: measure(grams / (CUP / 16), 'tbsp_us'),
                ounces: `${kn(grams / WEIGHT.oz.g)} oz`,
                pounds: `${kn(grams / WEIGHT.lb.g)} lb`,
                blocks: `${kn(grams / 250)} × 250 g block`,
            },
            grids: {
                equivalents: {
                    columns: ['Unit', 'Amount'],
                    rows: [['US sticks (½ cup, about 113 g)', measure(grams / STICK_G, 'stick')], ['US cups', measure(grams / CUP, 'cup_us')], ['Tablespoons', measure(grams / (CUP / 16), 'tbsp_us')], ['Teaspoons', measure(grams / (CUP / 48), 'tsp_us')],
                        ['Grams', `${kn(grams)} g`], ['Ounces', `${kn(grams / WEIGHT.oz.g)} oz`], ['Pounds', `${kn(grams / WEIGHT.lb.g)} lb`], ['250 g blocks (Europe, UK, Australia)', kn(grams / 250)], ['100 g packs (India and others)', kn(grams / 100)]]
                        .map(([header, cell]) => ({ header, cells: [cell] })),
                },
            },
        };
    },

    pasta: (i, c) => {
        const dry = i.mode === 'servings' ? i.servings * 56 : i.dry;

        if (!ok(dry) || dry <= 0) {
            return { empty: i.mode === 'servings' ? 'Enter the number of servings.' : 'Enter the dry pasta weight.' };
        }

        const shape = { spaghetti: ['Spaghetti and long pasta', null, 124], elbows: ['Elbow macaroni', 'pasta_elbows', 120], penne: ['Penne', 'pasta_penne', 120], rotini: ['Rotini', 'pasta_rotini', 120], farfalle: ['Farfalle (bow ties)', 'pasta_farfalle', 120] }[i.shape ?? 'spaghetti'];
        const ratio = yieldRatio(ingredient(c, 'pasta_elbows'), ingredient(c, 'pasta_cooked'));
        const cooked = dry * ratio;
        const dryCup = shape[1] ? ingredient(c, shape[1]).cup : NaN;

        return {
            value: kn(cooked),
            unit: 'g cooked',
            label: 'Cooked pasta',
            sub: `${kn(dry)} g (${kn(dry / WEIGHT.oz.g)} oz) dry ${shape[0].toLowerCase()} → about ${measure(cooked / shape[2], 'cup_us')} cooked`,
            rows: {
                cups: measure(cooked / shape[2], 'cup_us'),
                ounces: `${kn(cooked / WEIGHT.oz.g)} oz cooked`,
                servings: `${kn(dry / 56)} (56 g / 2 oz dry each)`,
                dryCups: Number.isFinite(dryCup) ? `${measure(dry / dryCup, 'cup_us')} dry` : 'Long pasta is measured by weight',
                ratio: `${kn(ratio)} × the dry weight`,
                water: `${kn(dry / 100)} L (about 1 L per 100 g, 4 quarts per pound)`,
            },
        };
    },

    herbs: (i) => {
        if (!ok(i.amount) || i.amount <= 0) {
            return { empty: 'Enter the amount of herbs.' };
        }

        const toDried = i.direction !== 'to_fresh';
        const ml = i.amount * VOLUME[i.unit].ml;
        const result = toDried ? ml / 3 : ml * 3;

        return {
            value: tidyVolume(result),
            label: toDried ? 'Dried herbs' : 'Fresh herbs',
            sub: `${measure(i.amount, i.unit)} ${toDried ? 'fresh' : 'dried'} ≈ ${tidyVolume(result)} ${toDried ? 'dried' : 'fresh'} (3 : 1)`,
            rows: {
                tsp: measure(result / VOLUME.tsp_us.ml, 'tsp_us'),
                tbsp: measure(result / VOLUME.tbsp_us.ml, 'tbsp_us'),
                ground: toDried ? `${tidyVolume(result / 2)} if ground (about half the dried leaves)` : 'Use leaves, not ground, for the fresh swap',
                rule: '1 tbsp fresh = 1 tsp dried',
            },
        };
    },

    garlic: (i) => {
        if (!ok(i.amount) || i.amount <= 0) {
            return { empty: 'Enter an amount.' };
        }

        // Per medium clove (3 g, USDA): 1 tsp minced fresh, ½ tsp jarred minced, ¼ tsp granulated, ⅛ tsp powder, ½ tsp garlic salt.
        const perClove = { clove: 1, minced: 1, jarred: 0.5, granulated: 0.25, powder: 0.125, salt: 0.5 };
        const cloves = i.amount / perClove[i.from];
        const tsp = (key) => measure(cloves * perClove[key], 'tsp_us');

        return {
            value: kn(cloves),
            unit: cloves === 1 ? 'clove' : 'cloves',
            label: 'Fresh garlic',
            sub: `About ${kn(cloves * 3)} g of peeled garlic`,
            rows: { minced: tsp('minced'), jarred: tsp('jarred'), granulated: tsp('granulated'), powder: tsp('powder'), salt: `${tsp('salt')} (cut other salt by ${measure(cloves * 0.375, 'tsp_us')})` },
        };
    },

    oil_butter: (i, c) => {
        if (!ok(i.amount) || i.amount <= 0) {
            return { empty: 'Enter the amount.' };
        }

        const butter = ingredient(c, 'butter');
        const oil = ingredient(c, 'oil_vegetable');
        const toOil = i.direction !== 'to_butter';
        const ml = isVolume(i.unit) ? i.amount * VOLUME[i.unit].ml : NaN;
        const grams = isWeight(i.unit) ? i.amount * WEIGHT[i.unit].g : toGrams(i.amount, i.unit, toOil ? butter : oil);
        const fat = butter.per100.fat / 100;
        // Kitchen rule: ¾ cup oil for 1 cup butter. Same-fat swap: butter weight × fat fraction of oil.
        const resultMl = toOil ? (Number.isFinite(ml) ? ml : grams / butter.cup * VOLUME.cup_us.ml) * 0.75 : (Number.isFinite(ml) ? ml : grams / oil.cup * VOLUME.cup_us.ml) / 0.75;
        const sameFatG = toOil ? grams * fat : grams / fat;
        const water = toOil ? grams * 0.1587 : NaN;

        return {
            value: tidyVolume(resultMl),
            label: toOil ? 'Oil to use' : 'Butter to use',
            sub: toOil ? `For ${isVolume(i.unit) ? measure(i.amount, i.unit) : `${kn(i.amount)} ${unitShort(i.unit)}`} butter (kitchen rule: ¾ as much oil)` : 'Kitchen rule: 1⅓ times as much butter as oil',
            rows: {
                weight: `${kn(toOil ? resultMl * (oil.cup / VOLUME.cup_us.ml) : resultMl * (butter.cup / VOLUME.cup_us.ml))} g`,
                sameFat: `${kn(sameFatG)} g ${toOil ? 'oil' : 'butter'} (${tidyVolume(sameFatG / (toOil ? oil : butter).cup * VOLUME.cup_us.ml)})`,
                water: toOil ? `${kn(water)} g (${tidyVolume(water)}) of water or milk, for the water in butter` : 'Butter adds about 16% water; reduce other liquid slightly',
                fat: `Butter ${kn(butter.per100.fat)}% fat, oil 100% (USDA)`,
            },
        };
    },

    rice_cooked: (i, c) => {
        const type = RICE[i.type] ?? RICE.long;
        const raw = ingredient(c, type.raw);
        const cooked = ingredient(c, type.cooked);

        if (!ok(i.amount) || i.amount <= 0) {
            return { empty: 'Enter the amount of uncooked rice.' };
        }

        const dryG = toGrams(i.amount, i.unit, raw);
        const dryCups = dryG / raw.cup;
        const cookedG = dryG * yieldRatio(raw, cooked);

        return {
            value: measure(cookedG / cooked.cup, 'cup_us').replace(/ \(.*\)$/, ''),
            label: 'Cooked rice',
            sub: `${measure(dryCups, 'cup_us')} (${kn(dryG)} g) uncooked ${type.name.toLowerCase()} → ${kn(cookedG)} g cooked`,
            rows: {
                grams: `${kn(cookedG)} g (${kn(cookedG / WEIGHT.oz.g)} oz)`,
                water: `${measure(dryCups * type.water, 'cup_us')} (${kn(dryCups * type.water * VOLUME.cup_us.ml)} ml) for the stovetop`,
                ratio: `1 : ${kn(type.water)} by volume`,
                servings: `${kn(cookedG / cooked.cup / 0.5)} half-cup servings (1 MyPlate ounce-equivalent each)`,
                yield: `${kn(yieldRatio(raw, cooked))} × the dry weight (USDA)`,
            },
        };
    },

    yeast: (i) => {
        const from = YEAST[i.from] ? i.from : 'active';

        if (!ok(i.amount) || i.amount <= 0) {
            return { empty: 'Enter the amount of yeast.' };
        }

        const grams = yeastGrams(i.amount, i.unit, from);

        if (!Number.isFinite(grams)) {
            return { error: from === 'fresh' ? 'Measure fresh yeast by weight or in cakes.' : 'Dry yeast comes in packets, not cakes.' };
        }

        const freshG = grams / YEAST[from].factor;
        const to = YEAST[i.to] ? i.to : 'instant';
        const out = (type) => freshG * YEAST[type].factor;
        const count = (n, word) => `${kn(n)} ${word}${Math.abs(n - 1) < 0.005 ? '' : 's'}`;
        const describe = (type) => (type === 'fresh' ? `${kn(out(type))} g (${count(out(type) / 17, 'cake')} of 0.6 oz)` : `${kn(out(type))} g = ${measure(out(type) / DRY_TSP_G, 'tsp_us')} = ${count(out(type) / 7, 'packet')}`);

        return {
            value: kn(out(to)),
            unit: 'g',
            label: YEAST[to].name,
            sub: describe(to),
            rows: { fresh: describe('fresh'), active: describe('active'), instant: describe('instant') },
        };
    },

    cake_pan: (i, c) => {
        const from = panVolume(i, 'from');
        const to = panVolume(i, 'to');

        if (!from || !to) {
            return { empty: 'Enter the size of both pans.' };
        }

        const factor = to.ml / from.ml;
        const lines = scaleRecipe(i.recipe, factor, c);
        const areaText = (pan) => (Number.isFinite(pan.area) ? `${kn(i.units === 'cm' ? pan.area * 6.4516 : pan.area)} ${i.units === 'cm' ? 'cm²' : 'in²'}` : 'Bundt or tube pan');

        return {
            value: `${kn(factor)} ×`,
            label: 'Recipe multiplier',
            sub: factor > 1 ? `The new pan holds ${kn(factor)} times as much: multiply every ingredient by ${kn(factor)}` : `The new pan holds ${kn(factor)} of the original: multiply every ingredient by ${kn(factor)}`,
            rows: {
                original: `${areaText(from)}, ${measure(from.ml / VOLUME.cup_us.ml, 'cup_us')}`,
                new: `${areaText(to)}, ${measure(to.ml / VOLUME.cup_us.ml, 'cup_us')}`,
                eggs: `${kn(2 * factor)} eggs for a 2-egg recipe (round to the nearest half)`,
                time: Number.isFinite(from.area) && Number.isFinite(to.area) && Math.abs(i.to_depth / i.from_depth - 1) > 0.1 ? (i.to_depth > i.from_depth ? 'Deeper batter: bake longer, perhaps 25 °F (15 °C) lower' : 'Shallower batter: check 5–10 minutes early') : 'Same temperature; start checking 5–10 minutes before the original time',
            },
            grids: lines.length ? { recipe: recipeGrid(lines) } : { recipe: { columns: ['Original', 'Scaled', 'Weight'], rows: [] } },
        };
    },

    scaler: (i, c) => {
        const factor = i.mode === 'factor' ? i.factor : i.to_servings / i.from_servings;

        if (!ok(factor) || factor <= 0) {
            return { empty: i.mode === 'factor' ? 'Enter the multiplier.' : 'Enter the original and new servings.' };
        }

        const lines = scaleRecipe(i.recipe, factor, c);

        if (!lines.length) {
            return { empty: 'Add ingredients: amount, unit and name.' };
        }

        const weighed = lines.filter((line) => Number.isFinite(line.grams));
        const unknown = lines.filter((line) => !line.match).map((line) => line.name).filter(Boolean);

        return {
            value: `${kn(factor)} ×`,
            label: 'Scale factor',
            sub: i.mode === 'factor' ? `${lines.length} ingredients multiplied by ${kn(factor)}` : `From ${kn(i.from_servings)} to ${kn(i.to_servings)} servings`,
            rows: {
                lines: String(lines.length),
                weight: weighed.length ? `${kn(weighed.reduce((sum, line) => sum + line.grams, 0))} g for ${weighed.length} of ${lines.length} ingredients` : 'No weights found',
                unknown: unknown.length ? `Not in the table: ${unknown.join(', ')}` : 'All ingredients matched',
                tip: 'Leavening, salt and spices can be scaled a little less for very large batches; baking time changes with pan depth, not with the factor',
            },
            grids: { recipe: recipeGrid(lines) },
        };
    },

    oven: (i) => {
        if (!ok(i.temp)) {
            return { empty: 'Enter a temperature.' };
        }

        let c;

        if (i.scale === 'gas') {
            const row = GAS.find((g) => g[0] === i.temp);

            if (!row && !(i.temp >= 1 && i.temp <= 10)) {
                return { error: 'Gas marks run from ¼ to 9 (or 10).' };
            }

            c = row ? fToC(row[1]) : fToC(250 + 25 * i.temp);
        } else {
            c = i.scale === 'f' ? fToC(i.temp) : i.scale === 'fan' ? i.temp + 20 : i.temp;
        }

        const f = cToF(c);
        const nearest = GAS.reduce((best, g) => (Math.abs(g[1] - f) < Math.abs(best[1] - f) ? g : best));
        const gasMark = f >= 275 ? (f - 250) / 25 : null;

        return {
            value: i.scale === 'f' ? kn(Math.round(c)) : kn(Math.round(f)),
            unit: i.scale === 'f' ? '°C' : '°F',
            label: i.scale === 'f' ? 'Celsius' : 'Fahrenheit',
            sub: `${kn(Math.round(f))} °F = ${kn(Math.round(c))} °C = ${kn(Math.round(c - 20))} °C fan = gas mark ${gasText(nearest[0])}${Math.abs(nearest[1] - f) > 8 ? ' (nearest)' : ''}`,
            rows: {
                f: `${kn(Math.round(f))} °F`,
                c: `${kn(Math.round(c))} °C`,
                fan: `${kn(Math.round(c - 20))} °C (about 20 °C lower)`,
                gas: gasMark !== null && gasMark <= 10 ? `${kn(Math.round(gasMark * 2) / 2)} (nearest mark ${gasText(nearest[0])})` : `Nearest mark ${gasText(nearest[0])}`,
                heat: nearest[3],
            },
            grids: {
                table: { columns: ['°F', '°C', 'Fan °C', 'Heat'], rows: GAS.map((g) => ({ header: `Gas ${gasText(g[0])}`, cells: [String(g[1]), String(g[2]), String(g[2] - 20), g[3]], highlight: g === nearest })) },
            },
        };
    },

    air_fryer: (i) => {
        if (!ok(i.temp, i.time) || i.time <= 0) {
            return { empty: 'Enter the oven temperature and time.' };
        }

        const drop = ok(i.drop) ? i.drop : 25;
        const cut = ok(i.cut) ? i.cut : 20;
        const f = cToF(i.temp) - drop;
        const capped = Math.min(f, 400);
        const minutes = i.time * (1 - cut / 100);

        return {
            value: `${kn(Math.round(capped))} °F`,
            label: 'Air fryer temperature',
            sub: `${kn(Math.round(fToC(capped)))} °C for about ${kn(Math.round(minutes))} minutes`,
            rows: {
                c: `${kn(Math.round(fToC(capped)))} °C`,
                time: `${kn(Math.round(minutes))} min (from ${kn(i.time)} min in the oven)`,
                flip: `Shake or turn at about ${kn(Math.round(minutes / 2))} min`,
                check: `Start checking at ${kn(Math.max(1, Math.round(minutes * 0.8)))} min`,
                limit: f > 400 ? 'Most air fryers top out at 400 °F (200 °C): used the maximum' : 'Within the usual 400 °F (200 °C) limit',
            },
        };
    },
};

export default defineTools(handlers);
