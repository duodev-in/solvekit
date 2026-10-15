import assert from 'node:assert/strict';
import test from 'node:test';
import { convertUnit, toBase } from '../engines/units.js';
import { amountInWords, numberToWords } from '../tools/cents-dollars.js';
import { meltValue } from '../tools/coins.js';
import { fromPx, toPx } from '../tools/css-units.js';
import { analyse, formula, quantityName } from '../tools/dimensional-analysis.js';
import { interpolate } from '../tools/hardness.js';
import { parse24, spoken, to12 } from '../tools/military-time.js';
import { clockForm, wordedForm } from '../tools/minutes-hours.js';
import { ppmFrom } from '../tools/ppm.js';
import { thermsFromCcf } from '../tools/ccf-therms.js';
import { nutrition } from '../tools/grams-calories.js';

const close = (actual, expected, tolerance = 1e-9) => assert.ok(Math.abs(actual - expected) <= tolerance, `${actual} ≠ ${expected}`);
const C = { factor: 1 };
const F = { factor: 5 / 9, offset: -32 };
const K = { factor: 1, offset: -273.15 };
const DE = { factor: -2 / 3, offset: -150 };
const RO = { factor: 40 / 21, offset: -7.5 };

test('temperature scales, including the reversed Delisle scale', () => {
    close(convertUnit(100, C, F), 212);
    close(convertUnit(0, K, C), -273.15);
    close(convertUnit(100, C, DE), 0);
    close(convertUnit(0, C, DE), 150);
    close(convertUnit(100, C, RO), 60);
    close(toBase(-500, F), (-500 - 32) * 5 / 9);
});

test('API gravity and Baumé use inverse units', () => {
    const water60F = 999.016;
    const api = { factor: 141.5 * water60F, inverse: true, offset: 131.5 };
    const heavy = { factor: 145 * water60F, inverse: true, offset: 145, scale: -1 };
    close(toBase(10, api), water60F);
    close(toBase(0, heavy), water60F);
    assert.ok(!Number.isFinite(toBase(145, heavy)));
});

test('clock form never shows :60', () => {
    assert.equal(clockForm(119.6), '2:00');
    assert.equal(clockForm(90), '1:30');
    assert.equal(wordedForm(61), '1 hour 1 minute');
    assert.equal(wordedForm(0), '0 minutes');
});

test('military time parsing and range checks', () => {
    assert.deepEqual(parse24('1430'), { hours: 14, minutes: 30, seconds: 0 });
    assert.equal(parse24('14:30:75'), null);
    assert.equal(parse24('2460'), null);
    assert.deepEqual(parse24('2400'), { hours: 24, minutes: 0, seconds: 0 });
    assert.equal(to12({ hours: 0, minutes: 5, seconds: 0 }), '12:05 AM');
    assert.equal(spoken({ hours: 8, minutes: 30 }), 'zero eight thirty hours');
});

test('hardness interpolation matches ASTM E140 rows', () => {
    const rows = [[60, 697, null, 81.2], [50, 513, 481, 75.9], [40, 392, 371, 70.4]];
    assert.equal(interpolate(rows, 0, 1, 60), 697);
    assert.equal(interpolate(rows, 0, 1, 55), 605);
    assert.equal(interpolate(rows, 0, 2, 60), null);
    assert.equal(interpolate(rows, 0, 1, 70), null);
    close(interpolate(rows, 1, 0, 513), 50);
});

test('coin melt value is not floored at face value', () => {
    const zincPenny = { mass: 2.5, metals: { zinc: 0.975, copper: 0.025 } };
    const value = meltValue(zincPenny, { zinc: 1.3, copper: 4.5, silver: 30, nickel: 7.5 });
    assert.ok(value < 0.01);
    const silverDime = { mass: 2.5, metals: { silver: 0.9, copper: 0.1 } };
    close(meltValue(silverDime, { silver: 31.1034768, copper: 0, nickel: 0, zinc: 0 }), 2.25);
});

test('amounts in words', () => {
    assert.equal(numberToWords(1234), 'one thousand two hundred thirty-four');
    assert.equal(amountInWords(123456, { major: 'dollar', majorPlural: 'dollars', minor: 'cent', minorPlural: 'cents' }), 'one thousand two hundred thirty-four dollars and fifty-six cents');
    assert.equal(amountInWords(101, { major: 'pound', majorPlural: 'pounds', minor: 'penny', minorPlural: 'pence' }), 'one pound and one penny');
});

test('css units round-trip and px to rem', () => {
    assert.equal(fromPx(24, 'rem', 16), 1.5);
    assert.equal(toPx(1, 'in', 16), 96);
    assert.equal(fromPx(16, 'pt', 16), 12);
});

test('ppm modes', () => {
    assert.equal(ppmFrom('percent', { percent: 1 }), 10000);
    assert.equal(ppmFrom('mass_mass', { solute: 50, solution: 2 }), 25);
    close(ppmFrom('molarity', { molarity: 0.01, molarMass: 58.44 }), 584.4);
    assert.equal(ppmFrom('dilution', { c1: 1000, v1: 50, v2: 500 }), 100);
});

test('dimensional analysis', () => {
    assert.deepEqual(analyse('kg*m/s^2').exponents, [1, 1, -2, 0, 0, 0, 0]);
    assert.equal(quantityName(analyse('N·m').exponents), 'Energy, work or torque');
    assert.equal(formula(analyse('50 m/s²').exponents), '[L T⁻²]');
    assert.ok(analyse('furlong').error);
    assert.equal(quantityName(analyse('V/A').exponents), 'Resistance');
});

test('ccf to therms and nutrition scaling', () => {
    close(thermsFromCcf(1, 1037), 1.037);
    assert.equal(nutrition({ kcal: 130, carbs: 28, protein: 2.7, fat: 0.3 }, 200).kcal, 260);
});
