import assert from 'node:assert/strict';
import test from 'node:test';
import { plainFormat } from '../engines/formula.js';
import { aquariumLiters, chirpsToFahrenheit, handlers as animals, horseWeight, humanEquivalent, lifeStage } from '../tools/animals.js';
import { addDays, daysBetween, formatDate, handlers as gestation, lengthFor, parseDate } from '../tools/gestation.js';
import { annualisedMortality, binCubicFeet, cattleWeight, handlers as livestock } from '../tools/livestock.js';

const close = (actual, expected, tolerance) => assert.ok(Math.abs(actual - expected) <= tolerance, `${actual} ≠ ${expected}`);
const f = plainFormat;
const IN = 0.0254;
const FT = 0.3048;
const LB = 453.59237;

const SPECIES = {
    dog: { name: 'Dog', event: 'Whelping', days: 63, min: 58, max: 68, ovulation: { days: 63, min: 62, max: 64 }, milestones: [[25, 'Ultrasound'], [45, 'X-ray']] },
    horse: { name: 'Horse', event: 'Foaling', days: 340, min: 320, max: 370, milestones: [] },
};

test('dates are parsed as UTC calendar days', () => {
    assert.equal(parseDate('2026-02-30'), null);
    assert.equal(parseDate('soon'), null);
    assert.equal(formatDate(addDays(parseDate('2026-01-01'), 63)), 'Thu, Mar 5, 2026');
    assert.equal(daysBetween(parseDate('2026-03-01'), parseDate('2026-03-31')), 30);
});

test('dog due date and ovulation window', () => {
    const outcome = gestation.gestation({ date: '2026-01-01', basis: 'breeding' }, { data: SPECIES, today: '2026-01-31' }, f);
    assert.equal(outcome.value, 'Thu, Mar 5, 2026');
    assert.equal(outcome.rows.earliest, 'Sat, Feb 28, 2026');
    assert.equal(outcome.rows.latest, 'Tue, Mar 10, 2026');
    assert.match(outcome.sub, /^Day 30 of about 63 · 33 days to go/);
    assert.equal(outcome.lists.timeline.find((row) => row.highlight).label, 'Day 45 · X-ray');
    assert.deepEqual([lengthFor(SPECIES.dog, 'ovulation').min, lengthFor(SPECIES.dog, 'ovulation').max], [62, 64]);
});

test('pregnancy past the normal range is flagged', () => {
    const outcome = gestation.gestation({ species: 'horse', date: '2025-01-01' }, { data: SPECIES, today: '2026-01-20' }, f);
    assert.match(outcome.sub, /past the normal range/);
    assert.ok(gestation.gestation({ species: 'horse', date: '' }, { data: SPECIES }, f).empty);
});

test('human-equivalent ages and life stages', () => {
    close(humanEquivalent(3, 6), 40, 1e-12);
    assert.equal(lifeStage(0.05), 'Juvenile');
    assert.equal(lifeStage(0.5), 'Adult');
    assert.equal(lifeStage(0.9), 'Senior');
    const outcome = animals.lifespan_age({ age: 6, age_unit: 'months' }, { data: { gp: { name: 'Guinea pig', years: 6, range: '5–7' } } }, f);
    assert.equal(outcome.value, '7');
});

test('Dolbear\'s law: 160 chirps a minute is 80 °F', () => {
    assert.equal(chirpsToFahrenheit(160, 'snowy'), 80);
    assert.equal(chirpsToFahrenheit(150, 'field'), 75);
});

test('dry matter: 10% protein at 78% moisture is 45.45% DM', () => {
    const outcome = animals.dry_matter({ nutrient: 10, moisture: 78, nutrient_b: 26, moisture_b: 10 }, {}, f);
    close(Number(outcome.value), 45.4545, 1e-3);
    assert.match(outcome.rows.compare, /^First food is higher/);
});

test('horse and cattle tape formulas', () => {
    close(horseWeight(72, 64), 1005.4, 0.1);
    close(cattleWeight(75, 65), 1218.75, 1e-9);
    assert.equal(livestock.cattle_weight({ girth: 75 * IN, length: 65 * IN }, {}, f).value, '1,219');
});

test('aquarium volumes', () => {
    close(aquariumLiters('rectangle', { length: 36 * IN, width: 18 * IN, height: 16 * IN }) / 3.785411784, 44.88, 0.01);
    close(aquariumLiters('cylinder', { diameter: 1, height: 1 }), 785.398, 0.001);
});

test('turtle tank: two 6-inch turtles need 90 gallons', () => {
    const outcome = animals.turtle_tank({ shell: 6 * IN, turtles: 2 }, {}, f);
    assert.equal(outcome.value, '90');
    assert.equal(outcome.rows.standard, '90 gal tank');
});

test('rabbit enclosure: RWAF minimum passes, a hutch does not', () => {
    assert.match(animals.rabbit_enclosure({ rabbits: 2, length: 3, width: 2, height: 1 }, {}, f).sub, /Meets/);
    assert.match(animals.rabbit_enclosure({ rabbits: 2, length: 4 * FT, width: 2 * FT, height: 2 * FT }, {}, f).sub, /Below/);
});

test('rat cage: 36 × 24 × 36 in holds 9 rats', () => {
    assert.equal(animals.rat_cage({ width: 36 * IN, depth: 24 * IN, height: 36 * IN }, {}, f).value, '9');
});

test('grain bin: 30 × 24 ft level full is about 13,632 bushels', () => {
    close(binCubicFeet(30, 24) / 1.2445, 13631.6, 0.1);
    const outcome = livestock.grain_bin({ grain: 'corn', diameter: 30 * FT, eave: 24 * FT, peak: 0 }, { data: { corn: { name: 'Corn', lb: 56 } } }, f);
    assert.equal(outcome.value, '13,632');
});

test('stocking rate, AUM and hay', () => {
    const stocking = livestock.stocking_rate({ acres: 40, forage: 3000, utilisation: 30, weight: 1200 * LB, days: 120 }, {}, f);
    assert.equal(stocking.value, '9');
    assert.equal(livestock.aum({ head: 50, weight: 1200 * LB, months: 5 }, {}, f).value, '300');
    const hay = livestock.hay({ head: 1, weight: 1000 * LB, days: 100, bale: 50 * LB, waste: 0, price: NaN }, {}, f);
    assert.equal(hay.value, '57');
});

test('daily gain, feed conversion and mortality', () => {
    assert.equal(livestock.adg({ unit: 'lb', start: 550, end: 760, days: 100, target: 900 }, {}, f).value, '2.1');
    assert.equal(livestock.fcr({ feed: 1200, gain: 400, price: NaN }, {}, f).value, '3');
    close(annualisedMortality(0.03, 365), 0.03, 1e-12);
});

test('fence cost adds wire, posts and gates', () => {
    const outcome = livestock.fence_cost({ perimeter: 1200 * FT, strands: 4, spacing: 12 * FT, wire_price: 0.05, post_price: 10, gates: 1, gate_price: 150, labour: NaN }, {}, f);
    assert.equal(outcome.value, '$1,400');
});
