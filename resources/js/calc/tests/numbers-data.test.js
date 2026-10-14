import assert from 'node:assert/strict';
import test from 'node:test';
import { groupDigits, integerDigits } from '../engines/number-scale.js';
import { bitLength, conversionSteps, groupFromRight, parseRadix, toRadix } from '../engines/radix.js';
import { downloadSeconds, formatDuration } from '../tools/mbps-calculator.js';
import { fromRoman, toRoman } from '../tools/roman.js';
import { isoWeek, zonedToEpoch, zoneOffsetMinutes } from '../tools/unix-time.js';

test('digit grouping follows Western and Indian conventions', () => {
    assert.equal(groupDigits(25000000, 'western'), '25,000,000');
    assert.equal(groupDigits(25000000, 'indian'), '2,50,00,000');
    assert.equal(integerDigits(1e9), 10);
    assert.equal(integerDigits(0.5), 1);
});

test('radix conversion is exact beyond 2^53', () => {
    const big = parseRadix('1'.repeat(80), 2);
    assert.equal(toRadix(big, 16), 'FFFFFFFFFFFFFFFFFFFF');
    assert.equal(parseRadix('9007199254740993', 10).toString(), '9007199254740993');
    assert.equal(bitLength(255n), 8);
});

test('radix input is validated per base', () => {
    assert.equal(parseRadix('102', 2), null);
    assert.equal(parseRadix('0xFF', 16), 255n);
    assert.equal(parseRadix('1111 0000', 2), 240n);
    assert.equal(parseRadix('-17', 8), -15n);
    assert.equal(parseRadix('1.5', 10), null);
});

test('grouping and worked steps', () => {
    assert.equal(groupFromRight('101101', 4), '10 1101');
    assert.equal(groupFromRight('1234567', 3, ','), '1,234,567');
    assert.deepEqual(conversionSteps(13n, 10, 2).slice(0, 2), ['13 ÷ 2 = 6 remainder 1', '6 ÷ 2 = 3 remainder 0']);
});

test('roman numerals round-trip and reject non-standard forms', () => {
    assert.equal(toRoman(2026).numeral, 'MMXXVI');
    assert.equal(toRoman(3999).numeral, 'MMMCMXCIX');
    assert.equal(fromRoman('mcmxcix').value, 1999);
    assert.equal(fromRoman('IIII'), null);
    assert.equal(fromRoman('VX'), null);
    assert.equal(fromRoman('IC'), null);
});

test('download time divides bits by effective speed', () => {
    assert.equal(downloadSeconds(1e9, 100e6, 1), 80);
    assert.equal(formatDuration(3725), '1 h 2 min 5 s');
});

test('date to Unix respects the chosen zone and daylight saving', () => {
    assert.equal(zonedToEpoch({ year: 2026, month: 1, day: 1 }, 'UTC'), Date.UTC(2026, 0, 1));
    assert.equal(new Date(zonedToEpoch({ year: 2026, month: 7, day: 1, hour: 12 }, 'America/New_York')).toISOString(), '2026-07-01T16:00:00.000Z');
    assert.equal(new Date(zonedToEpoch({ year: 2026, month: 1, day: 1, hour: 12 }, 'America/New_York')).toISOString(), '2026-01-01T17:00:00.000Z');
    assert.equal(zoneOffsetMinutes(Date.UTC(2026, 0, 1), 'Asia/Kolkata'), 330);
    assert.equal(isoWeek(new Date(Date.UTC(2026, 0, 1))), 1);
});
