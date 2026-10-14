import assert from 'node:assert/strict';
import test from 'node:test';
import { formatNumber, formatScientific, parseNumber } from '../format.js';

test('auto keeps up to seven significant digits and groups thousands', () => {
    assert.equal(formatNumber(82.02099737532808), '82.021');
    assert.equal(formatNumber(0.015534279805933), '0.01553428');
    assert.equal(formatNumber(25000), '25,000');
});

test('fixed decimals pad to the requested places', () => {
    assert.equal(formatNumber(3.048, 2), '3.05');
    assert.equal(formatNumber(2, 4), '2.0000');
});

test('very large and very small values switch to scientific notation', () => {
    assert.equal(formatNumber(9460730472580800), '9.4607 × 10¹⁵');
    assert.equal(formatNumber(2.5e-7), '2.5 × 10⁻⁷');
    assert.equal(formatScientific(-1.5e21), '-1.5 × 10²¹');
});

test('a value rounded away by fixed decimals is not shown as zero', () => {
    assert.equal(formatNumber(0.0004, 2), '4 × 10⁻⁴');
});

test('non-finite values show a dash', () => {
    assert.equal(formatNumber(Number.NaN), '—');
    assert.equal(formatNumber(Infinity), '—');
});

test('parseNumber rejects empty and malformed input', () => {
    assert.ok(Number.isNaN(parseNumber('')));
    assert.ok(Number.isNaN(parseNumber('12abc')));
    assert.equal(parseNumber(' 1,250.5 '), 1250.5);
    assert.equal(parseNumber('2e3'), 2000);
});
