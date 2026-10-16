import assert from 'node:assert/strict';
import test from 'node:test';
import { plainFormat } from '../engines/formula.js';
import { adultWeight, catHumanAge, catLifeStage, dogHumanAge, epigeneticAge, felineBodyFat, handlers as pets, restingEnergy } from '../tools/pets.js';

const close = (actual, expected, tolerance) => assert.ok(Math.abs(actual - expected) <= tolerance, `${actual} ≠ ${expected}`);
const f = plainFormat;
const LB = 453.59237;
const IN = 0.0254;

test('dog age chart and epigenetic clock', () => {
    assert.equal(dogHumanAge(1, 'small'), 15);
    assert.equal(dogHumanAge(5, 'medium'), 36);
    assert.equal(dogHumanAge(8, 'giant'), 64);
    close(dogHumanAge(1.5, 'large'), 19.5, 1e-9);
    close(epigeneticAge(1), 31, 1e-12);
    close(epigeneticAge(Math.E), 47, 1e-9);
});

test('cat age chart and AAHA life stages', () => {
    assert.equal(catHumanAge(1), 15);
    assert.equal(catHumanAge(2), 24);
    assert.equal(catHumanAge(10), 56);
    assert.equal(catLifeStage(0.5), 'Kitten');
    assert.equal(catLifeStage(8), 'Mature adult');
    assert.equal(catLifeStage(12), 'Senior');
});

test('RER = 70 × kg^0.75', () => {
    close(restingEnergy(10), 393.6, 0.1);
    const outcome = pets.dog_nutrition({ weight: 10000, stage: 'neutered' }, {}, f);
    assert.equal(outcome.value, '630');
    assert.equal(pets.cat_calories({ weight: 4000, stage: 'neutered' }, {}, f).value, '238');
});

test('dog food grams and cups', () => {
    const outcome = pets.dog_food({ weight: 10000, stage: 'neutered', kcal_kg: 3600, kcal_cup: 360, meals: 2, bag: 7000 }, {}, f);
    assert.equal(outcome.value, '175');
    assert.match(outcome.rows.cups, /^1\.75 cups/);
    assert.equal(outcome.rows.bag, 'About 40 days');
});

test('ideal weight from body condition score', () => {
    const outcome = pets.dog_ideal_weight({ weight_unit: 'kg', weight: 36, bcs: 7 }, {}, f);
    assert.equal(outcome.value, '30');
    assert.equal(outcome.rows.change, 'Lose about 6 kg');
});

test('raw food split', () => {
    const outcome = pets.raw_food({ weight: 20000, percent: 2.5, ratio: 'pmr' }, {}, f);
    assert.equal(outcome.value, '500');
    assert.equal(outcome.rows.muscle, '400 g (80%)');
});

test('crate and harness sizes', () => {
    assert.equal(pets.dog_crate({ length: 26 * IN, height: 22 * IN }, {}, f).value, '36 in (L)');
    assert.equal(pets.harness({ chest: 24 * IN }, {}, f).value, 'M');
});

test('heat cycle dates', () => {
    const outcome = pets.heat_cycle({ date: '2026-01-01', size: 'medium' }, {}, f);
    assert.equal(outcome.value, 'Fri, Jul 3, 2026');
});

test('puppy and kitten growth estimates', () => {
    close(adultWeight(12, 16, 'medium'), 12 / 0.41, 1e-9);
    close(adultWeight(3, 24, 'cat'), 6, 1e-9);
});

test('feline body fat from rib cage and leg', () => {
    close(felineBodyFat(38, 12), 33.66, 0.01);
});

test('quality of life total and threshold', () => {
    const scores = { hurt: 5, hunger: 5, hydration: 5, hygiene: 5, happiness: 5, mobility: 5, more_good: 5 };
    const outcome = pets.quality_of_life(scores, {}, f);
    assert.equal(outcome.value, '35');
    assert.match(outcome.sub, /talk with your vet/);
});

test('life expectancy by breed or weight', () => {
    const data = { labrador: { name: 'Labrador Retriever', range: [11, 14] } };
    assert.equal(pets.dog_lifespan({ breed: 'labrador', age: 4, weight: NaN }, { data }, f).value, '11–14');
    assert.equal(pets.dog_lifespan({ breed: 'mixed', age: NaN, weight: 25 * LB }, { data }, f).value, '10–14');
});

test('cat water and food', () => {
    const water = pets.cat_water({ weight: 4000, wet: 100, moisture: 80 }, {}, f);
    assert.equal(water.value, '200');
    assert.match(water.rows.drink, /^120 mL/);
    assert.ok(pets.cat_food({ weight: 4000, stage: 'neutered', wet_share: 100, kcal_can: 80, kcal_cup: NaN, meals: 2 }, {}, f).value.startsWith('2.97 cans'));
});
