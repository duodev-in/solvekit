import assert from 'node:assert/strict';
import test from 'node:test';
import { kitchenFraction } from '../engines/units.js';
import { massFromVolume, volumeFromMass } from '../engines/substance.js';
import { boxVolumeLiters } from '../tools/box-volume.js';
import { dropsToMilliliters } from '../tools/drops.js';
import { gramsToStone, poundsOuncesToGrams } from '../tools/pounds-ounces.js';

const close = (actual, expected, tolerance = 1e-9) => assert.ok(Math.abs(actual - expected) <= tolerance, `${actual} ≠ ${expected}`);

test('kitchen fractions use quarters and thirds only', () => {
    assert.equal(kitchenFraction(1.5), '1 ½');
    assert.equal(kitchenFraction(0.333), '⅓');
    assert.equal(kitchenFraction(2.98), '3');
    assert.equal(kitchenFraction(0.75), '¾');
    assert.equal(kitchenFraction(1.42), null);
    assert.equal(kitchenFraction(0.01), null);
});

test('a US gallon of water weighs about 8.33 lb at 20 °C', () => {
    const grams = massFromVolume(3.785411784, 0.9982);
    close(grams / 453.59237, 8.3304, 1e-4);
});

test('volume from mass is the inverse of mass from volume', () => {
    close(volumeFromMass(massFromVolume(2.5, 1.42), 1.42), 2.5);
});

test('a US pint of honey weighs about 1.48 lb', () => {
    close(massFromVolume(0.473176473, 1.42) / 453.59237, 1.4813, 1e-4);
});

test('box volume multiplies the three sides', () => {
    close(boxVolumeLiters([2, 1.5, 1]), 3000);
    close(boxVolumeLiters([10 * 0.3048, 8 * 0.3048, 4 * 0.3048]) / 28.316846592, 320, 1e-9);
});

test('drops divide by the drop factor', () => {
    assert.equal(dropsToMilliliters(30, 20), 1.5);
    assert.equal(dropsToMilliliters(60, 60), 1);
});

test('pounds and ounces convert exactly', () => {
    close(poundsOuncesToGrams(7, 8), 3401.942775);
    assert.deepEqual(gramsToStone(poundsOuncesToGrams(160, 0)), { stone: 11, pounds: 6 });
});
