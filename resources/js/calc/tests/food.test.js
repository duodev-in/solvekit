import assert from 'node:assert/strict';
import { execSync } from 'node:child_process';
import test from 'node:test';
import { setCurrency } from '../currency.js';
import { plainFormat } from '../engines/formula.js';
import { findIngredient, fraction, lineGrams, measure, parseAmount, parseUnit, toGrams } from '../food/kitchen.js';
import { bakersTable, boilingPointAt, handlers as bake, iceCreamMix, sourdough } from '../tools/fd-bake.js';
import { handlers as convert, scaleRecipe } from '../tools/fd-convert.js';
import { abv, brixToSg, caffeineAt, freeSo2For, handlers as drinks, residualCo2, sgToBrix, terrillFg } from '../tools/fd-drinks.js';
import { handlers as nutrition, nutritionTotals } from '../tools/fd-nutrition.js';
import { handlers as other, williamsSeconds } from '../tools/fd-other.js';
import { hamRow, turkeyRoastHours, turkeyThaw } from '../tools/fd-party.js';

const DATA = JSON.parse(execSync(`php -r 'echo json_encode(require "config/food_data.php");'`, { maxBuffer: 1e8 }).toString());
const config = (extra = {}) => ({ data: DATA, ...extra });
const close = (actual, expected, tolerance) => assert.ok(Math.abs(Number(actual) - expected) <= tolerance, `${actual} ≠ ${expected}`);
const number = (text) => Number(String(text).replace(/[^0-9.−-]/g, '').replace('−', '-'));

test('kitchen measures: amounts, units, fractions and USDA densities', () => {
    assert.deepEqual(['2', '1 1/2', '1½', '¾', '3/4', 'abc', '1/0'].map(parseAmount), [2, 1.5, 1.5, 0.75, 0.75, NaN, NaN]);
    assert.deepEqual(['cups', 'Tbsp', 'T', 't', 'g', 'fl oz', '', 'packet'].map(parseUnit), ['cup_us', 'tbsp_us', 'tbsp_us', 'tsp_us', 'g', 'floz_us', '', 'packet']);
    assert.equal(fraction(1.32), '1⅓');
    assert.equal(fraction(0.07), null);
    assert.equal(measure(0.5, 'tbsp_us'), '½ tbsp');
    assert.equal(measure(1.32, 'cup_us'), '1⅓ cups (1.32)');
    close(toGrams(1, 'cup_us', DATA.ingredients.flour_ap), 125, 1e-9);
    close(toGrams(250, 'ml', DATA.ingredients.water), 250.4, 0.1);
    close(lineGrams(2, '', DATA.ingredients.egg), 100, 1e-9);
    close(lineGrams(1, 'stick', DATA.ingredients.butter), 113.4, 1e-9);
    assert.equal(findIngredient(config(), 'parmesan cheese').key, 'parmesan');
    assert.equal(findIngredient(config(), 'basmati rice').key, 'rice_white');
    assert.equal(findIngredient(config(), 'garlic cloves').key, 'garlic');
    assert.equal(findIngredient(config(), 'brown rice').key, 'rice_brown');
});

test('cooking converters', () => {
    const f = plainFormat;
    assert.equal(convert.convert({ amount: 250, ingredient: 'flour_ap', standard: 'cup_us' }, config({ from: 'g', to: 'cup' }), f).value, '2');
    assert.equal(convert.convert({ amount: 1, ingredient: 'sugar', standard: 'cup_us' }, config({ from: 'lb', to: 'cup' }), f).value, '2.27');
    const stick = convert.butter({ amount: 1, unit: 'stick' });
    assert.equal(stick.value, '113');
    assert.equal(stick.rows.tbsp, '8 tbsp');
    assert.equal(convert.oven({ temp: 350, scale: 'f' }).value, '177');
    assert.equal(convert.oven({ temp: 6, scale: 'gas' }).value, '400');
    assert.equal(convert.yeast({ amount: 1, unit: 'packet', from: 'active', to: 'instant' }).value, '5.78');
    assert.equal(convert.rice_cooked({ amount: 1, unit: 'cup_us', type: 'long' }, config()).value, '3¼ cups');
    close(convert.cake_pan({ units: 'in', from_shape: 'round', from_d: 8, from_depth: 2, to_shape: 'rectangle', to_l: 9, to_w: 13, to_depth: 2, recipe: '' }, config()).value.replace(' ×', ''), 2.33, 0.01);
    const lines = scaleRecipe('1\tcup\tAll-purpose flour\n3\tlarge\tEgg (whole, raw)\n1\ttsp\tTable salt', 0.5, config());
    assert.deepEqual(lines.map((line) => line.text), ['½ cup', '1.5 large', '½ tsp']);
});

test('baking: baker\'s maths, sourdough, ice cream, altitude and candy', () => {
    assert.deepEqual(bakersTable([{ name: 'Water', value: 65 }], 500).map((row) => row.grams), [325]);
    const loaf = sourdough({ flour: 500, hydration: 75, starter: 20, starterHydration: 100, salt: 2 });
    close(loaf.water, 375, 1e-9);
    close(loaf.trueHydration, 425 / 550, 1e-9);
    close(boilingPointAt(0), 99.97, 0.05);
    close(boilingPointAt(5280 * 0.3048), 94.6, 0.2);
    assert.equal(bake.pizza_dough({ count: 4, size: 12, units: 'in', style: 'neapolitan', hydration: NaN, yeast: 'instant' }).value, '250 g');
    const mix = iceCreamMix(['milk', 'cream_heavy', 'sugar', 'egg_yolk', 'milk_powder'].map((key, k) => ({ key, row: DATA.ingredients[key], grams: [500, 300, 150, 80, 30][k] })));
    close(mix.fat, 13.8, 0.1);
    close(mix.solids, 38.1, 0.1);
    const candy = bake.candy({ stage: 'soft_ball', altitude: 1524 }, config());
    assert.match(candy.value, /^22[56]–23[01] °F$/);
    assert.match(bake.altitude_bake({ altitude: 600 }).value, /No change/);
});

test('drinks: ABV, Brix, carbonation, sulfite and caffeine', () => {
    close(abv(1.05, 1.01).standard, 5.25, 1e-9);
    close(brixToSg(21), 1.087, 0.001);
    close(sgToBrix(1.05), 12.4, 0.05);
    close(terrillFg(12.4, 6.2), 1.012, 0.001);
    close(residualCo2(68), 0.86, 0.01);
    close(freeSo2For(0.8, 3.4), 31.9, 0.1);
    close(number(drinks.priming({ volume: 5 * 3.785411784, co2: 2.4, temp: 20, sugar: 'corn' }).value), 117, 1);
    close(caffeineAt([{ at: 0, mg: 100 }], 300, 5), 50, 1e-9);
    assert.equal(drinks.dilution({ volume: 750, unit: 'ml', abv: 60, target: 40 }).value, '375 ml');
    assert.equal(drinks.coffee_ratio({ mode: 'ratio', known: 'water', amount: 500, ratio: 16 }, config()).value, '31.3 g');
    assert.match(drinks.chill({ container: 'can', method: 'fridge', start: 22, target: 5, ambient: 3 }).value, /h|min/);
});

test('USDA turkey and ham charts', () => {
    assert.deepEqual(turkeyRoastHours(DATA.turkey, 14, false), [3, 3.75]);
    assert.deepEqual(turkeyRoastHours(DATA.turkey, 14, true), [3.5, 4]);
    assert.equal(turkeyRoastHours(DATA.turkey, 30, false), null);
    assert.deepEqual(turkeyThaw(DATA.turkey, 16, 'fridge'), { low: 3.2, high: 4, unit: 'days' });
    assert.deepEqual(turkeyThaw(DATA.turkey, 16, 'water'), { low: 8, high: 8, unit: 'h' });
    assert.deepEqual(hamRow(DATA.ham, 'fully_cooked', 'slices, half, or spiral cut').min_per_lb, [10, 18]);
});

test('food safety, eggs, curing and storage', () => {
    // Williams' worked example: a 57 g egg from the fridge to a runny 63 °C yolk takes about 4½ minutes.
    close(williamsSeconds(57, 4, 100, 63) / 60, 4.5, 0.1);
    const cure = other.curing({ meat: 5 * 453.59237, product: 'bacon_dry', ppm: NaN, salt: 2.5, sugar: 1.5 });
    assert.equal(cure.value, '7.26 g');
    assert.ok(other.curing({ meat: 1000, product: 'bacon_wet', ppm: 150, salt: 2, sugar: 1 }).error);
    const poultry = other.safe_temp({ food: '3' }, config());
    assert.equal(poultry.value, '165 °F');
    const chicken = other.storage({ food: '407', place: 'freezer', state: 'unopened', stored: '2026-10-19' }, config());
    assert.match(chicken.value, /Oct 19, 2027/);
    assert.equal(other.steak({ thickness: 0.0254, doneness: 'mediumrare', method: 'grill' }).value, '5 min');
});

test('nutrition and costs', () => {
    const { totals } = nutritionTotals('100\tg\tWhole milk\n1\tcup\tGranulated sugar', config());
    close(totals.kcal, 61 + 387 * 2, 0.5);
    const salad = nutrition.nutrition({ items: '2\tcup\tRomaine lettuce (shredded)', servings: 1, weight: 70 }, config({ label: 'Salad calories' }));
    assert.equal(salad.label, 'Salad calories');
    setCurrency('INR');
    const cost = nutrition.recipe_cost({ items: 'Rice\t120\t1000\t500\nDal\t140\t1000\t250', servings: 4, extra: 0, margin: 0 });
    assert.equal(cost.value, '₹23.75');
    setCurrency('USD');
    const water = nutrition.quarantine({ adults: 2, kids: 2, days: 14, adult_kcal: 2000, kid_kcal: 1400, pets: 0 }, config());
    assert.match(water.rows.water, /^56 gallons/);
});
