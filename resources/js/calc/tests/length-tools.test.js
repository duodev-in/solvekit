import assert from 'node:assert/strict';
import test from 'node:test';
import { feetInchesToMetric } from '../tools/feet-inches.js';
import { formatHeight, splitFeetInches } from '../tools/height-in-inches.js';
import { formatFraction, toFraction } from '../tools/inches-to-fraction.js';
import { micronsForMesh, nearbySieves, nearestSieve } from '../tools/mesh-to-micron.js';
import { pixelsToInches } from '../tools/pixels-to-inches.js';

test('feet and inches carry extra inches into feet', () => {
    const result = feetInchesToMetric(4, 18);
    assert.equal(result.totalInches, 66);
    assert.equal(result.normalisedFeet, 5);
    assert.equal(result.normalisedInches, 6);
    assert.ok(Math.abs(result.centimeters - 167.64) < 1e-9);
});

test('height never reads as 12 inches', () => {
    assert.deepEqual(splitFeetInches(71.96), { feet: 6, inches: 0 });
    assert.equal(formatHeight(69), '5′ 9″');
});

test('fractions only use power-of-two denominators and are reduced', () => {
    assert.equal(formatFraction(toFraction(0.333, 16)), '5/16″');
    assert.equal(formatFraction(toFraction(2.75, 16)), '2 3/4″');
    assert.equal(formatFraction(toFraction(0.625, 64)), '5/8″');
    assert.equal(formatFraction(toFraction(3, 8)), '3″');
    assert.equal(formatFraction(toFraction(-1.5, 4)), '−1 1/2″');
});

test('fraction rounding error is reported', () => {
    assert.ok(Math.abs(toFraction(0.333, 4).error - (0.25 - 0.333)) < 1e-12);
    assert.equal(toFraction(0.5, 2).error, 0);
});

test('standard sieves use the ASTM E11 table, others the estimate', () => {
    assert.deepEqual(micronsForMesh(200), { microns: 75, standard: true });
    assert.deepEqual(micronsForMesh(149), { microns: 100, standard: false });
    assert.deepEqual(nearestSieve(47), [325, 45]);
});

test('nearby sieves always returns a full window', () => {
    assert.equal(nearbySieves(4).length, 12);
    assert.equal(nearbySieves(635).length, 12);
    assert.ok(nearbySieves(200).some(([mesh]) => mesh === 200));
});

test('pixels to inches divides by resolution', () => {
    assert.equal(pixelsToInches(3000, 300), 10);
});
