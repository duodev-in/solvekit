import assert from 'node:assert/strict';
import test from 'node:test';
import { convert, unitRatio } from '../engines/units.js';

const length = { m: { factor: 1 }, ft: { factor: 0.3048 }, mi: { factor: 1609.344 }, in: { factor: 0.0254 } };

test('converts through the base unit', () => {
    assert.equal(convert(1, length.mi.factor, length.m.factor), 1609.344);
    assert.ok(Math.abs(convert(25, length.m.factor, length.ft.factor) - 82.02099737532808) < 1e-12);
});

test('unit ratio is the value of one source unit in target units', () => {
    assert.ok(Math.abs(unitRatio(length, 'ft', 'in') - 12) < 1e-12);
});

test('converting there and back returns the input', () => {
    const there = convert(123.456, length.mi.factor, length.in.factor);
    assert.ok(Math.abs(convert(there, length.in.factor, length.mi.factor) - 123.456) < 1e-9);
});
