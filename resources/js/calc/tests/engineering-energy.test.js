import assert from 'node:assert/strict';
import test from 'node:test';
import { convertUnit } from '../engines/units.js';
import { levels, toWatts } from '../tools/dbm-to-watts.js';
import { work } from '../tools/nm-to-joules.js';
import { orificeFlow } from '../tools/psi-to-gpm.js';
import { reactivePower, solve } from '../tools/rms-to-watts.js';
import { powerWatts } from '../tools/torque-to-hp.js';

const close = (actual, expected, tolerance = 1e-9) => assert.ok(Math.abs(actual - expected) <= tolerance, `${actual} ≠ ${expected}`);
const mpgUs = { factor: 1.609344 / 3.785411784 };
const l100km = { factor: 100, inverse: true };
const celsius = { factor: 1 };
const fahrenheit = { factor: 5 / 9, offset: -32 };

test('inverse units: 30 US mpg is 7.84 L/100 km and back', () => {
    close(convertUnit(30, mpgUs, l100km), 7.840486, 1e-6);
    close(convertUnit(convertUnit(30, mpgUs, l100km), l100km, mpgUs), 30);
});

test('offset units: 212 °F is 100 °C and -40 is the same on both scales', () => {
    close(convertUnit(212, fahrenheit, celsius), 100);
    close(convertUnit(-40, celsius, fahrenheit), -40);
});

test('torque and speed give power; 5252 rpm makes hp equal lbf·ft', () => {
    const lbfFt = 1.3558179483314004;
    close(powerWatts(300 * lbfFt, 5252) / 745.6998715822702, 300, 0.05);
});

test('orifice flow matches the 29.84 gpm rule of thumb', () => {
    const { flow } = orificeFlow(6894.757293168361, 0.0254, 1);
    close(flow / (3.785411784e-3 / 60), 29.85, 0.02);
});

test('dBm and watts round-trip; 0 dBu is 0.7746 V', () => {
    close(toWatts(30, 'dbm', 50), 1);
    close(levels(1, 50).dbm, 30);
    close(Math.sqrt(toWatts(0, 'dbu', 600) * 600), 0.7745966692, 1e-9);
    close(levels(toWatts(4, 'dbu', 600), 600).dbu, 4);
});

test('RMS solver keeps power factor 0 and never returns NaN reactive power', () => {
    assert.equal(solve('vi', { voltage: 120, current: 8, powerFactor: 0 }).power, 0);
    const result = solve('vr', { voltage: 230, resistance: 53 });
    assert.ok(!Number.isNaN(reactivePower(result.apparent, result.power)));
    assert.equal(reactivePower(1, 1 + 1e-15), 0);
});

test('work is torque times angle in radians', () => {
    close(work(1, 2 * Math.PI), 6.283185307);
});
