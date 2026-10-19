import { standardAtmosphere, waterBoilingPoint } from '../chemistry/thermo.js';
import { formatMoney } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { findIngredient, ingredient, kn, measure, parseAmount, toGrams, VOLUME, WEIGHT } from '../food/kitchen.js';
import { parseRows } from '../rows-editor.js';
import { scaleRecipe, tidyVolume } from './fd-convert.js';

/**
 * Desserts, baking and pizza: baker's percentages, sourdough, cakes, pancakes, ice cream mix balance, chocolate,
 * donuts, self-rising flour, high-altitude adjustments, candy stages and pizza dough, sizes and parties.
 */
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
const g = (grams) => `${kn(grams)} g`;
const cToF = (c) => (c * 9) / 5 + 32;

/**
 * Water boiling point (°C) at an altitude in metres, from the ICAO standard atmosphere and the IAPWS saturation curve.
 */
export function boilingPointAt(meters) {
    return waterBoilingPoint(standardAtmosphere(Math.min(Math.max(meters, -500), 10000))) - 273.15;
}

/** Rows of "name<TAB>number" from a rows editor. */
const namedRows = (text) => parseRows(text).map(([name, value]) => ({ name: name ?? '', value: parseAmount(value) })).filter((row) => row.name && Number.isFinite(row.value));

// Water carried by liquids that count toward dough hydration (USDA water content: whole milk 88%, egg 76%).
const WATER_SHARE = [[/water/i, 1], [/buttermilk/i, 0.9], [/milk/i, 0.88], [/egg/i, 0.76]];
const waterShare = (name) => WATER_SHARE.find(([pattern]) => pattern.test(name))?.[1] ?? 0;
const isFlour = (name) => /flour|semolina|meal\b/i.test(name);

/**
 * Baker's percentages: every ingredient as a share of the total flour weight (flour = 100%).
 */
export function bakersTable(rows, flourGrams) {
    return rows.map((row) => ({ ...row, grams: (flourGrams * row.value) / 100 }));
}

/**
 * Sourdough formula: water, starter and salt from flour weight and percentages (of the flour you add), with the
 * flour and water inside the starter counted for the true hydration.
 */
export function sourdough({ flour, hydration, starter, starterHydration, salt }) {
    const starterGrams = (flour * starter) / 100;
    const starterFlour = starterGrams / (1 + starterHydration / 100);
    const starterWater = starterGrams - starterFlour;
    const water = (flour * hydration) / 100;

    return {
        water,
        starter: starterGrams,
        salt: (flour * salt) / 100,
        starterFlour,
        starterWater,
        trueHydration: (water + starterWater) / (flour + starterFlour),
        total: flour + water + starterGrams + (flour * salt) / 100,
    };
}

// Wilton chart sizes (round and square, inches) → [party, wedding] servings; other sizes scale by area.
function chartServings(cakes, shape, size, kind) {
    const table = cakes[shape];
    const index = kind === 'wedding' ? 1 : 0;

    if (table[String(size)]) {
        return { servings: table[String(size)][index], basis: 'Wilton chart' };
    }

    const area = (s) => (shape === 'round' ? (Math.PI * s * s) / 4 : s * s);
    const nearest = Object.keys(table).map(Number).reduce((best, s) => (Math.abs(s - size) < Math.abs(best - size) ? s : best));

    return { servings: Math.floor((table[String(nearest)][index] * area(size)) / area(nearest)), basis: `scaled by area from the ${nearest} in chart size` };
}

const STYLES = {
    neapolitan: { name: 'Neapolitan', tf: 0.078, hydration: 62, salt: 2.8, yeast: 0.15, oil: 0, sugar: 0, note: '24–48 h rise; bake at 800–900 °F (430–480 °C) in a pizza oven' },
    newyork: { name: 'New York', tf: 0.085, hydration: 63, salt: 2, yeast: 0.4, oil: 2, sugar: 1, note: 'Cold rise 24–72 h; bake at 500–550 °F (260–290 °C) on a stone or steel' },
    pan: { name: 'Pan (Detroit or Sicilian)', tf: 0.13, hydration: 70, salt: 2, yeast: 0.5, oil: 3, sugar: 1, note: 'Rise in the oiled pan; bake at 475–500 °F (245–260 °C)' },
    thin: { name: 'Thin and crispy', tf: 0.07, hydration: 55, salt: 1.8, yeast: 0.4, oil: 4, sugar: 1, note: 'Roll thin and dock; bake at 475–500 °F (245–260 °C)' },
};
const YEAST_FACTOR = { instant: 1, active: 1.25, fresh: 3 };

const TEMPER = {
    dark: { name: 'Dark', melt: [45, 50], cool: [27, 28], work: [31, 32] },
    milk: { name: 'Milk', melt: [40, 45], cool: [26, 27], work: [29, 30] },
    white: { name: 'White', melt: [40, 45], cool: [25, 26], work: [28, 29] },
};
// Ganache chocolate : cream by weight, by use and chocolate (pastry convention; milk and white need more chocolate as they hold less cocoa solids).
const GANACHE = {
    glaze: { name: 'Glaze or drip', dark: 1, milk: 2, white: 2.5 },
    frosting: { name: 'Frosting or filling', dark: 1.5, milk: 2.5, white: 3 },
    truffles: { name: 'Truffles (rolled)', dark: 2, milk: 3, white: 3.5 },
};

// Ice cream: POD (sweetness) and PAC (freezing-point depression) per gram of sugar, relative to sucrose.
const SUGAR_POWER = { sugar: [1, 1], sugar_brown_packed: [1, 1], sugar_brown_loose: [1, 1], sugar_powdered: [1, 1], maple_syrup: [1, 1], honey: [1.3, 1.9], corn_syrup: [0.5, 0.8] };
const LACTOSE = [0.16, 1];

/**
 * Ice cream mix composition (% of the mix): fat, milk solids-not-fat, added sugars, total solids, POD and PAC.
 * Dairy sugars are lactose (part of MSNF); sweetened condensed milk is split into lactose and added sucrose.
 */
export function iceCreamMix(lines) {
    const totals = { mass: 0, fat: 0, msnf: 0, sugars: 0, solids: 0, pod: 0, pac: 0 };

    lines.forEach(({ row, key, grams }) => {
        const p = row.per100;
        const solids = (100 - (p.water ?? 0)) / 100 * grams;
        const fat = (p.fat ?? 0) / 100 * grams;
        let sugars = 0;
        let msnf = 0;
        let lactose = 0;

        if (row.group === 'dairy' && key === 'condensed_milk') {
            lactose = (0.545 / 0.455) * (solids - fat - (p.sugar / 100) * grams);
            msnf = lactose / 0.545;
            sugars = (p.sugar / 100) * grams - lactose;
        } else if (row.group === 'dairy') {
            msnf = solids - fat;
            lactose = (p.sugar / 100) * grams;
        } else if (SUGAR_POWER[key]) {
            sugars = (p.sugar / 100) * grams;
        }

        const power = SUGAR_POWER[key] ?? [1, 1];
        totals.mass += grams;
        totals.fat += fat;
        totals.msnf += msnf;
        totals.sugars += sugars;
        totals.solids += solids;
        totals.pod += sugars * power[0] + lactose * LACTOSE[0];
        totals.pac += sugars * power[1] + lactose * LACTOSE[1];
    });

    const share = (value) => (100 * value) / totals.mass;

    return { mass: totals.mass, fat: share(totals.fat), msnf: share(totals.msnf), sugars: share(totals.sugars), solids: share(totals.solids), pod: share(totals.pod), pac: share(totals.pac) };
}

const range = (value, [low, high]) => (value < low ? 'low' : value > high ? 'high' : 'in range');

const PANCAKES = '1 1/2\tcup\tAll-purpose flour\n3 1/2\ttsp\tBaking powder\n1\ttbsp\tGranulated sugar\n1/4\ttsp\tTable salt\n1 1/4\tcup\tWhole milk\n1\tlarge\tEgg (whole, raw)\n3\ttbsp\tButter (salted)';

export const handlers = {
    bakers: (i, c) => {
        const rows = namedRows(i.recipe);

        if (!rows.length) {
            return { empty: 'Add ingredients with their percentages or weights.' };
        }

        let flour;
        let table;

        if (i.mode === 'weights') {
            flour = rows.filter((row) => isFlour(row.name)).reduce((sum, row) => sum + row.value, 0);

            if (flour <= 0) {
                return { error: 'Include at least one flour row (its name must contain “flour”).' };
            }

            table = rows.map((row) => ({ ...row, percent: (100 * row.value) / flour, grams: row.value }));
        } else {
            if (!ok(i.flour) || i.flour <= 0) {
                return { empty: 'Enter the flour weight.' };
            }

            flour = i.flour;
            table = [{ name: 'Flour', percent: 100, grams: flour }, ...bakersTable(rows, flour).map((row) => ({ ...row, percent: row.value }))];
        }

        const total = table.reduce((sum, row) => sum + row.grams, 0);
        const water = table.reduce((sum, row) => sum + row.grams * waterShare(row.name), 0);
        const percentTotal = table.reduce((sum, row) => sum + row.percent, 0);

        return {
            value: g(total),
            label: 'Total dough',
            sub: `${kn(flour)} g flour, hydration ${kn((100 * water) / flour)}%`,
            rows: { flour: g(flour), hydration: `${kn((100 * water) / flour)}% (water, and milk and eggs by their water content)`, percent: `${kn(percentTotal)}%`, pieces: ok(i.pieces) && i.pieces > 0 ? `${kn(i.pieces)} pieces of ${g(total / i.pieces)}` : '—' },
            grids: { formula: { columns: ['Baker\'s %', 'Grams'], rows: table.map((row) => ({ header: row.name, cells: [`${kn(row.percent)}%`, g(row.grams)] })) } },
        };
    },

    sourdough: (i) => {
        const percents = { hydration: i.hydration, starter: i.starter, starterHydration: i.starter_hydration, salt: i.salt };

        if (!ok(...Object.values(percents))) {
            return { empty: 'Enter hydration, starter, starter hydration and salt.' };
        }

        const per = 1 + (i.hydration + i.starter + i.salt) / 100;
        const flour = i.mode === 'dough' ? (i.loaves * i.loaf) / per : i.flour;

        if (!ok(flour) || flour <= 0) {
            return { empty: i.mode === 'dough' ? 'Enter the number of loaves and their weight.' : 'Enter the flour weight.' };
        }

        const f = sourdough({ flour, ...percents });
        const parts = (i.build || '1:5:5').split(/[:/ ]+/).map(Number);
        const [seed, buildFlour, buildWater] = parts.length === 3 && parts.every((x) => x > 0) ? parts : [1, 5, 5];
        const unit = f.starter / (seed + buildFlour + buildWater);

        return {
            value: g(f.water),
            label: 'Water to add',
            sub: `${g(flour)} flour, ${g(f.starter)} starter, ${g(f.salt)} salt; total ${g(f.total)}`,
            rows: {
                flour: g(flour),
                starter: g(f.starter),
                salt: g(f.salt),
                trueHydration: `${kn(100 * f.trueHydration)}% (counting the starter's ${g(f.starterFlour)} flour and ${g(f.starterWater)} water)`,
                total: g(f.total),
                levain: `${g(unit * seed)} starter + ${g(unit * buildFlour)} flour + ${g(unit * buildWater)} water (${seed}:${buildFlour}:${buildWater}), 4–12 h before mixing`,
            },
        };
    },

    cake_price: (i) => {
        const items = parseRows(i.costs).map(([name, cost]) => ({ name, cost: parseAmount(cost) })).filter((row) => Number.isFinite(row.cost));
        const ingredients = items.reduce((sum, row) => sum + row.cost, 0);
        const labor = or0(i.hours) * or0(i.rate);
        const base = ingredients + labor + or0(i.packaging);
        const overhead = (base * or0(i.overhead)) / 100;
        const cost = base + overhead;

        if (cost <= 0) {
            return { empty: 'Add ingredient costs and your time.' };
        }

        const margin = or0(i.margin) / 100;

        if (margin >= 1) {
            return { error: 'The profit margin must be under 100%.' };
        }

        const price = cost / (1 - margin);
        const servings = ok(i.servings) && i.servings > 0 ? i.servings : NaN;

        return {
            value: formatMoney(price),
            label: 'Price to charge',
            sub: `Cost ${formatMoney(cost)} + profit ${formatMoney(price - cost)} (${kn(100 * margin)}% margin)`,
            rows: {
                ingredients: formatMoney(ingredients),
                labor: `${formatMoney(labor)} (${kn(or0(i.hours))} h × ${formatMoney(or0(i.rate))})`,
                overhead: formatMoney(overhead),
                cost: formatMoney(cost),
                perServing: Number.isFinite(servings) ? `${formatMoney(price / servings)} a serving (cost ${formatMoney(cost / servings)})` : 'Enter servings',
                markup: `${kn((100 * (price - cost)) / cost)}% markup on cost`,
            },
        };
    },

    cake_serving: (i, c) => {
        const cakes = c.data.cakes;
        const kind = i.kind === 'wedding' ? 'wedding' : 'party';
        const slice = cakes.slice_in2[kind];

        if (i.shape === 'sheet') {
            if (!ok(i.length, i.width) || i.length <= 0 || i.width <= 0) {
                return { empty: 'Enter the sheet cake size.' };
            }

            const servings = Math.floor((i.length * i.width) / slice);

            return {
                value: String(servings),
                unit: 'servings',
                label: `${kind === 'wedding' ? 'Wedding' : 'Party'} servings`,
                sub: `${kn(i.length)} × ${kn(i.width)} in sheet, ${kind === 'wedding' ? '1 × 2 in' : '1½ × 2 in'} slices (by area)`,
                rows: { slice: kind === 'wedding' ? '1 × 2 in, two layers' : '1½ × 2 in, two layers', basis: 'Sheet area ÷ slice area', other: `${Math.floor((i.length * i.width) / cakes.slice_in2[kind === 'wedding' ? 'party' : 'wedding'])} ${kind === 'wedding' ? 'party' : 'wedding'} servings` },
            };
        }

        const tiers = String(i.tiers ?? '').split(/[,\s]+/).map(Number).filter((x) => x > 0);

        if (!tiers.length) {
            return { empty: 'Enter the tier sizes in inches.' };
        }

        const shape = i.shape === 'square' ? 'square' : 'round';
        const each = tiers.map((size) => ({ size, ...chartServings(cakes, shape, size, kind), other: chartServings(cakes, shape, size, kind === 'wedding' ? 'party' : 'wedding').servings }));
        const total = each.reduce((sum, tier) => sum + tier.servings, 0);

        return {
            value: String(total),
            unit: 'servings',
            label: `${kind === 'wedding' ? 'Wedding' : 'Party'} servings`,
            sub: `${tiers.length} ${shape} tier${tiers.length > 1 ? 's' : ''}: ${tiers.map((t) => `${kn(t)} in`).join(', ')}`,
            rows: { slice: kind === 'wedding' ? '1 × 2 in, two layers 4 in tall' : '1½ × 2 in, two layers 4 in tall', basis: each.every((t) => t.basis === 'Wilton chart') ? 'Wilton serving chart' : 'Wilton chart, scaled by area for other sizes', other: `${each.reduce((sum, t) => sum + t.other, 0)} ${kind === 'wedding' ? 'party' : 'wedding'} servings` },
            grids: { tiers: { columns: ['Servings', 'Basis'], rows: each.map((t) => ({ header: `${kn(t.size)} in ${shape}`, cells: [String(t.servings), t.basis] })) } },
        };
    },

    chocolate: (i) => {
        const type = TEMPER[i.type] ? i.type : 'dark';

        if (i.mode === 'temper') {
            const t = TEMPER[type];
            const both = ([a, b]) => `${a}–${b} °C (${kn(Math.round(cToF(a)))}–${kn(Math.round(cToF(b)))} °F)`;

            return {
                value: `${t.work[0]}–${t.work[1]} °C`,
                label: `Working temperature, ${t.name.toLowerCase()} chocolate`,
                sub: `${kn(Math.round(cToF(t.work[0])))}–${kn(Math.round(cToF(t.work[1])))} °F`,
                rows: { melt: both(t.melt), cool: both(t.cool), work: both(t.work), seed: ok(i.weight) && i.weight > 0 ? `Seed method: melt ${g(i.weight * 0.75)}, stir in ${g(i.weight * 0.25)} chopped tempered chocolate` : 'Seed method: melt ¾, stir in ¼ chopped' },
            };
        }

        if (!ok(i.weight) || i.weight <= 0) {
            return { empty: 'Enter the chocolate weight.' };
        }

        if (i.mode === 'blend') {
            const [a, b, target] = [i.cocoa_a, i.cocoa_b, i.target];

            if (!ok(a, b, target) || a === b || target < Math.min(a, b) || target > Math.max(a, b)) {
                return { error: 'The target cocoa % must lie between the two chocolates.' };
            }

            const share = (target - b) / (a - b);

            return {
                value: g(i.weight * share),
                label: `${kn(a)}% chocolate`,
                sub: `+ ${g(i.weight * (1 - share))} of ${kn(b)}% chocolate = ${g(i.weight)} at ${kn(target)}%`,
                rows: { first: g(i.weight * share), second: g(i.weight * (1 - share)), shares: `${kn(100 * share)}% : ${kn(100 * (1 - share))}%` },
            };
        }

        const use = GANACHE[i.use] ?? GANACHE.frosting;
        const ratio = use[type];
        const cream = i.weight / ratio;

        return {
            value: g(cream),
            label: 'Heavy cream',
            sub: `${use.name}: ${kn(ratio)} : 1 chocolate to cream for ${TEMPER[type].name.toLowerCase()} chocolate`,
            rows: { cream: `${g(cream)} (${tidyVolume(cream / 1.006)})`, ratio: `${kn(ratio)} : 1 by weight`, total: g(i.weight + cream), method: 'Heat the cream to a simmer, pour over chopped chocolate, wait 2 minutes, stir from the centre' },
        };
    },

    donut: (i) => {
        if (!ok(i.count, i.outer, i.hole, i.thickness) || i.count <= 0 || i.outer <= i.hole) {
            return { empty: 'Enter the number and size of donuts (outer larger than the hole).' };
        }

        const cm = i.units === 'cm' ? 1 : 2.54;
        const volume = (Math.PI / 4) * ((i.outer * cm) ** 2 - (i.hole * cm) ** 2) * i.thickness * cm;
        // Yeast dough is about 1.1 g/cm³; re-rolling scraps loses about 10%.
        const each = volume * 1.1;
        const dough = each * i.count * 1.1;
        // Base dough: flour 100, milk 55, eggs 20, sugar 12, butter 12, salt 1.5, instant yeast 1.5 (baker's %).
        const flour = dough / 2.02;
        const oil = (Math.PI / 4) * (or0(i.pot) * cm) ** 2 * 2.5 * 2.54 / 1000;

        return {
            value: g(dough),
            label: 'Dough needed',
            sub: `${kn(i.count)} donuts of about ${g(each)} each (with 10% for scraps)`,
            rows: {
                each: g(each),
                flour: `${g(flour)} (${measure(flour / 125, 'cup_us')})`,
                rest: `Milk ${g(flour * 0.55)}, eggs ${g(flour * 0.2)}, sugar ${g(flour * 0.12)}, butter ${g(flour * 0.12)}, salt ${g(flour * 0.015)}, instant yeast ${g(flour * 0.015)}`,
                oil: or0(i.pot) > 0 ? `${kn(oil)} L for 2½ in (6 cm) of oil, fried at 350–360 °F (175–180 °C)` : 'Enter the pot diameter',
            },
        };
    },

    ice_cream: (i, c) => {
        const lines = parseRows(i.mix).map(([name, grams]) => ({ found: findIngredient(c, name), grams: parseAmount(grams), name })).filter((line) => line.found && Number.isFinite(line.grams) && line.grams > 0)
            .map((line) => ({ row: line.found.row, key: line.found.key, grams: line.grams, name: line.name }));

        if (!lines.length) {
            return { empty: 'Add ingredients with their weights in grams.' };
        }

        const mix = iceCreamMix(lines);
        // Composition targets from ice cream technology texts; POD and PAC are shown for comparing recipes, without a target.
        const target = { fat: [10, 16], msnf: [9, 12], sugars: [12, 18], solids: [36, 42] };
        const status = (key) => range(mix[key], target[key]);
        const off = Object.keys(target).filter((key) => status(key) !== 'in range');

        return {
            value: `${kn(mix.solids)}%`,
            label: 'Total solids',
            sub: off.length ? `Outside the usual range: ${off.map((key) => `${key === 'msnf' ? 'MSNF' : key} ${status(key)}`).join(', ')}` : 'Fat, milk solids, sugars and solids are all within the usual ranges',
            rows: {
                fat: `${kn(mix.fat)}% (10–16%: ${status('fat')})`,
                msnf: `${kn(mix.msnf)}% (9–12%: ${status('msnf')})`,
                sugars: `${kn(mix.sugars)}% (12–18%: ${status('sugars')})`,
                solids: `${kn(mix.solids)}% (36–42%: ${status('solids')})`,
                pod: `${kn(mix.pod)} (sweetness; sucrose alone at the same weight scores its own percentage)`,
                pac: `${kn(mix.pac)} (antifreeze power; higher is softer straight from the freezer)`,
                mass: g(mix.mass),
            },
            grids: { lines: { columns: ['Grams', 'Fat', 'Water'], rows: lines.map((line) => ({ header: line.row.name, cells: [g(line.grams), g((line.grams * line.row.per100.fat) / 100), g((line.grams * (line.row.per100.water ?? 0)) / 100)] })) } },
        };
    },

    pancake_recipe: (i, c) => {
        const count = i.mode === 'servings' ? i.servings * 3 : i.count;

        if (!ok(count) || count <= 0) {
            return { empty: 'Enter the number of pancakes or servings.' };
        }

        // The base recipe makes about 8 four-inch pancakes from ¼ cup of batter each.
        const factor = count / 8;
        const lines = scaleRecipe(PANCAKES, factor, c);

        return {
            value: `${kn(count)}`,
            unit: 'pancakes',
            label: 'Recipe for',
            sub: `${kn(factor)} × the base recipe (8 four-inch pancakes, ¼ cup batter each)`,
            rows: { batter: tidyVolume(count * VOLUME.cup_us.ml / 4), servings: `${kn(count / 3)} servings of 3`, griddle: 'Medium heat, 375 °F (190 °C) griddle; flip when bubbles pop and edges look dry' },
            grids: { recipe: { columns: ['Amount', 'Weight'], rows: lines.map((line) => ({ header: line.name, cells: [line.text, Number.isFinite(line.grams) ? g(line.grams) : '—'] })) } },
        };
    },

    pancake_count: (i) => {
        const ml = i.batter * 1000;

        if (!ok(ml, i.diameter, i.thickness) || ml <= 0 || i.diameter <= 0 || i.thickness <= 0) {
            return { empty: 'Enter the batter, pancake size and thickness.' };
        }

        // Batter rises about 1.4× on the griddle: ¼ cup makes a 4 in pancake about ⅜ in (1 cm) thick.
        const per = (Math.PI / 4) * (i.diameter * 100) ** 2 * (i.thickness * 100) / 1.4;
        const count = Math.floor(ml / per);

        return {
            value: String(count),
            unit: 'pancakes',
            label: 'Pancakes',
            sub: `${kn(per)} ml of batter (about ${tidyVolume(per).replace(/ \(.*\)$/, '')}) for each ${kn(i.diameter * 100)} cm pancake`,
            rows: { per: `${kn(per)} ml, about ${tidyVolume(per).replace(/ \(.*\)$/, '')}`, leftover: `${kn(ml - count * per)} ml left over`, servings: `${kn(count / 3)} servings of 3` },
        };
    },

    self_rising: (i, c) => {
        if (!ok(i.amount) || i.amount <= 0) {
            return { empty: 'Enter the amount of self-rising flour.' };
        }

        const flourRow = ingredient(c, 'flour_ap');
        const cups = i.unit === 'g' ? i.amount / flourRow.cup : i.unit === 'oz' ? (i.amount * WEIGHT.oz.g) / flourRow.cup : i.amount;
        const bp = cups * 1.5;
        const salt = cups * 0.25;

        return {
            value: measure(cups, 'cup_us'),
            label: 'All-purpose flour',
            sub: `+ ${measure(bp, 'tsp_us')} baking powder + ${measure(salt, 'tsp_us')} salt`,
            rows: {
                flour: `${measure(cups, 'cup_us')} (${g(cups * flourRow.cup)})`,
                bp: `${measure(bp, 'tsp_us')} (${g(toGrams(bp, 'tsp_us', ingredient(c, 'baking_powder')))})`,
                salt: `${measure(salt, 'tsp_us')} (${g(toGrams(salt, 'tsp_us', ingredient(c, 'salt')))})`,
                note: 'Whisk well; use within a few weeks, as baking powder weakens',
            },
        };
    },

    altitude_bake: (i) => {
        if (!ok(i.altitude)) {
            return { empty: 'Enter your altitude.' };
        }

        const feet = i.altitude / 0.3048;
        const boil = boilingPointAt(i.altitude);
        // Colorado State University Extension high-altitude table: per teaspoon of baking powder, per cup of sugar and of liquid.
        const band = feet < 3000 ? null : feet < 5000 ? { name: '3,000 ft', bp: [1 / 8, 1 / 8], sugar: [0, 1], liquid: [1, 2] }
            : feet < 7000 ? { name: '5,000 ft', bp: [1 / 8, 1 / 4], sugar: [0, 2], liquid: [2, 4] } : { name: '7,000 ft and above', bp: [1 / 4, 1 / 4], sugar: [1, 3], liquid: [3, 4] };
        const mid = ([a, b]) => (a + b) / 2;

        if (!band) {
            return { value: 'No change', label: 'Below 3,000 ft', sub: `Water boils at ${kn(boil)} °C (${kn(cToF(boil))} °F); most recipes need no adjustment`, rows: { boil: `${kn(cToF(boil))} °F (${kn(boil)} °C)`, bp: 'No change', sugar: 'No change', liquid: 'No change', oven: 'No change' } };
        }

        const bp = ok(i.bp) ? Math.max(0, i.bp - i.bp * mid(band.bp)) : NaN;
        const sugarTbsp = ok(i.sugar) ? i.sugar * 16 - i.sugar * mid(band.sugar) : NaN;
        const liquidTbsp = ok(i.liquid) ? i.liquid * 16 + i.liquid * mid(band.liquid) : NaN;
        const ovenF = ok(i.oven) ? cToF(i.oven) + 20 : NaN;

        return {
            value: Number.isFinite(ovenF) ? `${kn(Math.round(ovenF / 5) * 5)} °F` : band.name,
            label: 'Adjusted oven temperature',
            sub: `At ${kn(Math.round(feet))} ft water boils at ${kn(cToF(boil))} °F (${kn(boil)} °C); ${band.name} adjustments`,
            rows: {
                boil: `${kn(cToF(boil))} °F (${kn(boil)} °C)`,
                bp: Number.isFinite(bp) ? `${measure(bp, 'tsp_us')} (cut ${measure(band.bp[0], 'tsp_us')}${band.bp[1] !== band.bp[0] ? `–${measure(band.bp[1], 'tsp_us')}` : ''} per tsp)` : 'Enter baking powder',
                sugar: Number.isFinite(sugarTbsp) ? `${measure(sugarTbsp / 16, 'cup_us')} (cut ${band.sugar[0]}–${band.sugar[1]} tbsp per cup)` : 'Enter sugar',
                liquid: Number.isFinite(liquidTbsp) ? `${measure(liquidTbsp / 16, 'cup_us')} (add ${band.liquid[0]}–${band.liquid[1]} tbsp per cup)` : 'Enter liquid',
                oven: Number.isFinite(ovenF) ? `${kn(Math.round(ovenF / 5) * 5)} °F (${kn(Math.round(((Math.round(ovenF / 5) * 5 - 32) * 5) / 9))} °C): 15–25 °F hotter, bake 5–8 min less per 30 min` : 'Raise 15–25 °F',
            },
        };
    },

    candy: (i, c) => {
        const altitude = or0(i.altitude);
        const boil = boilingPointAt(altitude);
        // Measured against the same model at sea level, so 0 ft gives no change.
        const dropF = cToF(boilingPointAt(0)) - cToF(boil);
        const stages = c.data.candy;
        const stage = stages.find((s) => s[0] === i.stage) ?? stages[1];

        return {
            value: `${kn(stage[2] - dropF)}–${kn(stage[3] - dropF)} °F`,
            label: `${stage[1]} at your altitude`,
            sub: `${kn((((stage[2] - dropF) - 32) * 5) / 9)}–${kn((((stage[3] - dropF) - 32) * 5) / 9)} °C; water boils at ${kn(cToF(boil))} °F${dropF < 0.05 ? ', as at sea level' : `, ${kn(dropF)} °F below sea level`}`,
            rows: { sea: `${stage[2]}–${stage[3]} °F at sea level`, test: stage[4], uses: stage[5], drop: dropF < 0.05 ? 'None at sea level' : `${kn(dropF)} °F lower than at sea level` },
            grids: { stages: { columns: ['Sea level °F', 'Your altitude °F', '°C'], rows: stages.map((s) => ({ header: s[1], cells: [`${s[2]}–${s[3]}`, `${kn(s[2] - dropF)}–${kn(s[3] - dropF)}`, `${kn(((s[2] - dropF - 32) * 5) / 9)}–${kn(((s[3] - dropF - 32) * 5) / 9)}`], highlight: s === stage })) } },
        };
    },

    pizza_dough: (i) => {
        const style = STYLES[i.style] ?? STYLES.newyork;

        if (!ok(i.count, i.size) || i.count <= 0 || i.size <= 0) {
            return { empty: 'Enter the number and size of pizzas.' };
        }

        const inches = i.units === 'cm' ? i.size / 2.54 : i.size;
        const ball = (Math.PI / 4) * inches ** 2 * style.tf * WEIGHT.oz.g;
        const hydration = ok(i.hydration) ? i.hydration : style.hydration;
        const yeastPct = style.yeast * (YEAST_FACTOR[i.yeast] ?? 1);
        const percent = 100 + hydration + style.salt + yeastPct + style.oil + style.sugar;
        // 2% extra for dough left in the bowl.
        const total = ball * i.count * 1.02;
        const flour = (total * 100) / percent;
        const part = (pct) => (flour * pct) / 100;

        return {
            value: g(ball),
            label: 'Dough ball',
            sub: `${kn(i.count)} × ${kn(i.size)} ${i.units === 'cm' ? 'cm' : 'in'} ${style.name}: ${g(total)} of dough in all`,
            rows: {
                flour: g(flour), water: `${g(part(hydration))} (${kn(hydration)}%)`, salt: `${g(part(style.salt))} (${kn(style.salt)}%)`,
                yeast: `${g(part(yeastPct))} ${i.yeast === 'fresh' ? 'fresh' : i.yeast === 'active' ? 'active dry' : 'instant'} yeast (${kn(yeastPct)}%)`,
                oil: style.oil ? `${g(part(style.oil))} (${style.oil}%)` : 'None', sugar: style.sugar ? `${g(part(style.sugar))} (${style.sugar}%)` : 'None', bake: style.note,
            },
        };
    },

    pizza_party: (i) => {
        let adultSlices = or0(i.adult_slices) || 3;
        let kidSlices = or0(i.kid_slices) || 2;

        if (i.mode === 'guided') {
            const appetite = { light: 0.75, normal: 1, hungry: 1.35 }[i.appetite] ?? 1;
            const meal = i.meal === 'snack' ? 0.6 : 1;
            const sides = i.sides ? 0.8 : 1;
            adultSlices = 3 * appetite * meal * sides;
            kidSlices = 2 * appetite * meal * sides;
        }

        const people = or0(i.adults) + or0(i.kids);

        if (people <= 0) {
            return { empty: 'Enter the number of guests.' };
        }

        const slices = Math.ceil(or0(i.adults) * adultSlices + or0(i.kids) * kidSlices);
        const perPizza = { '10': 6, '12': 8, '14': 8, '16': 10, '18': 12 }[i.size] ?? 8;
        const pizzas = Math.ceil((slices * (1 + or0(i.extra) / 100)) / perPizza);

        return {
            value: String(pizzas),
            unit: pizzas === 1 ? 'pizza' : 'pizzas',
            label: `${i.size ?? '14'} in pizzas to order`,
            sub: `${kn(slices)} slices for ${kn(people)} guests (${perPizza} slices a pizza)`,
            rows: {
                slices: `${kn(adultSlices)} per adult, ${kn(kidSlices)} per child`,
                total: `${kn(pizzas * perPizza)} slices ordered (${kn(pizzas * perPizza - slices)} spare)`,
                cost: ok(i.price) && i.price > 0 ? `${formatMoney(pizzas * i.price)} (${formatMoney((pizzas * i.price) / people)} a guest)` : 'Enter a price per pizza',
                tip: 'Order about a third cheese, plus your most popular topping; add one gluten-free or vegetarian pizza for larger groups',
            },
        };
    },

    pizza_size: (i) => {
        if (i.mode === 'compare') {
            if (!ok(i.small, i.large) || i.small <= 0 || i.large <= 0) {
                return { empty: 'Enter both pizza sizes.' };
            }

            const ratio = (i.large / i.small) ** 2;

            return {
                value: kn(ratio),
                unit: `× ${kn(i.small)} in`,
                label: `Pizzas equal to one ${kn(i.large)} in`,
                sub: `A ${kn(i.large)} in pizza has ${kn(ratio)} times the area of a ${kn(i.small)} in pizza`,
                rows: { small: `${kn((Math.PI / 4) * i.small ** 2)} in²`, large: `${kn((Math.PI / 4) * i.large ** 2)} in²`, fair: ok(i.small_price) && i.small_price > 0 ? `Same value at ${formatMoney(i.small_price * ratio)} for the ${kn(i.large)} in` : 'Enter the small price for a fair large price' },
            };
        }

        const pizzas = parseRows(i.pizzas).map(([size, width, price, count]) => ({ size: parseAmount(size), width: parseAmount(width), price: parseAmount(price), count: parseAmount(count) || 1 }))
            .filter((p) => p.size > 0 && p.price > 0).map((p) => {
                const area = (Number.isFinite(p.width) && p.width > 0 ? p.size * p.width : (Math.PI / 4) * p.size ** 2) * p.count;

                return { ...p, area, per: (p.price * p.count) / area, label: `${p.count > 1 ? `${kn(p.count)} × ` : ''}${Number.isFinite(p.width) && p.width > 0 ? `${kn(p.size)} × ${kn(p.width)} in` : `${kn(p.size)} in`}` };
            });

        if (!pizzas.length) {
            return { empty: 'Add pizzas with a size and price.' };
        }

        const best = pizzas.reduce((a, b) => (b.per < a.per ? b : a));

        return {
            value: best.label,
            label: 'Best value',
            sub: `${formatMoney(best.per * 100)} per 100 in² (${formatMoney(best.per * 100 / 6.4516)} per 100 cm²)`,
            rows: { best: `${formatMoney(best.price * best.count)} for ${kn(best.area)} in²`, worst: (() => { const w = pizzas.reduce((a, b) => (b.per > a.per ? b : a)); return `${w.label}: ${kn(w.per / best.per)} × the price per area`; })(), area: `${kn(pizzas.reduce((sum, p) => sum + p.area, 0))} in² in all` },
            grids: { pizzas: { columns: ['Area', 'Price', 'Per 100 in²'], rows: pizzas.map((p) => ({ header: p.label, cells: [`${kn(p.area)} in²`, formatMoney(p.price * p.count), formatMoney(p.per * 100)], highlight: p === best })) } },
        };
    },
};

export default defineTools(handlers);
