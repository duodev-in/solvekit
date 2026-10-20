import assert from 'node:assert/strict';
import test from 'node:test';
import { dewPoint, psychro, satPressure, standardAtmosphere, waterDensity, waterVapourPressure, wetBulb } from '../physics/air.js';
import { engList, parseEng } from '../physics/circuits.js';
import { K } from '../physics/core.js';
import { TOPICS } from '../physics/practice.js';
import { sunPosition, sunTimes } from '../physics/sun.js';
import { ellipticE, ellipticK } from '../physics/util.js';
import { handlers as astro } from '../tools/ph-astro.js';
import { handlers as elec } from '../tools/ph-elec.js';
import { handlers as em } from '../tools/ph-em.js';
import { friction, handlers as fluid } from '../tools/ph-fluid.js';
import { handlers as mach } from '../tools/ph-mach.js';
import { handlers as mat } from '../tools/ph-mat.js';
import { handlers as mech, suvatSolve } from '../tools/ph-mech.js';
import { handlers as quantum } from '../tools/ph-quantum.js';
import { handlers as thermo } from '../tools/ph-thermo.js';
import { handlers as wave } from '../tools/ph-wave.js';

/**
 * Inputs are in each unit table's base (mass in g, volume in L, temperature in °C, the rest SI) and the
 * config carries no unit tables, so results come back as plain SI numbers.
 */
const num = (text) => Number(String(text).replace(/,/g, '').replace('−', '-').replace(/ × 10([⁻⁰¹²³⁴⁵⁶⁷⁸⁹]+)/, (_, e) => `e${[...e].map((ch) => '⁰¹²³⁴⁵⁶⁷⁸⁹'.indexOf(ch) === -1 ? '-' : '⁰¹²³⁴⁵⁶⁷⁸⁹'.indexOf(ch)).join('')}`).replace(/[^0-9.eE+-]/g, ''));
/** Results may be formatted text such as "3,892.61" or "6.5647 × 10⁻⁷". */
const close = (actual, expected, tolerance) => assert.ok(Math.abs((typeof actual === 'string' ? num(actual) : actual) - expected) <= tolerance, `${actual} ≠ ${expected}`);
const data = {
    units: {},
    physics: {
        bodies: { earth: { name: 'Earth', gm: 398600.435436, radius: 6371.0084 }, moon: { name: 'Moon', gm: 4902.800118, radius: 1737.4 }, mars: { name: 'Mars', gm: 42828.375214, radius: 3389.5 }, sun: { name: 'Sun', gm: 132712440041.94, radius: 695700 } },
        refractive: { air: { name: 'Air', n: 1.000277 }, water: { name: 'Water', n: 1.333 }, bk7: { name: 'Crown glass', n: 1.5168 } },
        nuclides: { fe56: { name: 'Iron-56', Z: 26, A: 56, mass: 55.93493554 }, he4: { name: 'Helium-4', Z: 2, A: 4, mass: 4.00260325413 } },
        gases: { methane: { name: 'Methane', molar: 16.043, gamma: 1.304, d: 380, tc: 190.56, pc: 4.599, omega: 0.011 } },
        roughness: { steel: { name: 'Steel', e: 0.045 } },
        fluids: { water: { name: 'Water', density: 998.2, mu: 1.002e-3, cp: 4182, k: 0.598 } },
    },
};
const run = (handler, inputs, extra = {}) => handler(inputs, { data, ...extra });

test('special functions and numerics', () => {
    close(ellipticK(0), Math.PI / 2, 1e-15);
    close(ellipticK(0.5), 1.8540746773013719, 1e-14);
    close(ellipticE(0.5), 1.3506438810476755, 1e-14);
    close(friction(1e5, 0.0009), 0.02183, 2e-5);
    close(friction(1000, 0.001), 0.064, 1e-12);
    assert.equal(parseEng('4k7'), 4700);
    assert.equal(parseEng('2R2'), 2.2);
    close(parseEng('100n'), 1e-7, 1e-20);
    assert.deepEqual(engList('1k, 2.2k\n470'), [1000, 2200, 470]);
});

test('kinematics and dynamics', () => {
    const r = suvatSolve('uat', { u: 0, a: 2, t: 10 });
    assert.equal(r.s, 100);
    assert.equal(r.v, 20);
    close(run(mech.projectile, { v: 20, angle: Math.PI / 4, h: 0, g: 9.80665 }).value, 40.789, 1e-3);
    close(run(mech.newton2, { solve: 'a', F: 10, m: 2000 }).value, 5, 1e-12);
    // 10° amplitude lengthens a 1 m pendulum's period by 0.19%.
    close(run(mech.simple_pendulum, { L: 1, g: 9.80665, a0: (10 * Math.PI) / 180 }).value, 2.01024, 1e-5);
    close(run(mech.rolling_incline, { shape: 'sphere', angle: (15 * Math.PI) / 180, L: 5 }).value, 4.25789, 1e-5);
});

test('optics and acoustics', () => {
    close(run(wave.snell, { m1: 'air', m2: 'water', t1: Math.PI / 6 }).value, 0.38459, 1e-4);
    close(run(wave.speed_sound, { med: 'air', T: 20 }, { data: { ...data, physics: { sound_media: { air: { name: 'Air', gamma: 1.4, molar: 28.9647 } } } } }).value, 343.235, 1e-3);
    close(num(run(wave.thin_film, { n1: 1.38, t: 99.64e-9, ns: 1.52, n0: 1, lambda: 550e-9 }).value), 1.2601, 1e-3);
});

test('materials, machines and fluids', () => {
    close(run(mat.bend_allowance, { angle: Math.PI / 2, R: 0.003, t: 0.002, k: 0.33 }).value, 5.74911e-3, 1e-8);
    close(num(run(mat.binding_energy ?? quantum.binding_energy, { nuc: 'fe56' }).value), 8.79036, 1e-4);
    close(run(mach.npsh, { liquid: 'water', T: 20, Ps: 101325, z: -3, hf: 0.5 }).value, 6.6119, 1e-3);
    close(waterVapourPressure(373.15), 101418, 2);
    close(waterDensity(4), 999.97, 0.01);
    close(run(fluid.oblique_shock, { M1: 2, theta: (10 * Math.PI) / 180, gamma: 1.4 }).value, (39.3139 * Math.PI) / 180, 1e-5);
    close(num(run(fluid.prandtl_meyer, { M1: 2, theta: (10 * Math.PI) / 180, gamma: 1.4 }).value), 2.3849, 1e-4);
});

test('moist air and the standard atmosphere match ASHRAE and US 1976 tables', () => {
    close(satPressure(298.15), 3169.9, 1);
    const s = psychro(298.15, 0.5 * satPressure(298.15), 101325);
    close(s.dew - 273.15, 13.86, 0.02);
    close(s.wet - 273.15, 17.89, 0.03);
    close(s.h, 50.32, 0.05);
    close(dewPoint(satPressure(283.15)), 283.15, 1e-6);
    close(wetBulb(303.15, 0.0133, 101325) - 273.15, 22.0, 0.1);
    close(standardAtmosphere(5000).P, 54048, 5);
    // 11 km geopotential (the tropopause) is 11,019 m geometric.
    close(standardAtmosphere(11019.1).T, 216.65, 0.01);
});

test('astronomy, astrophysics and relativity', () => {
    close(run(astro.hohmann, { body: 'earth', r1: 6678000, r2: 42164000 }).value, 3892.6, 1);
    // Flat ΛCDM with Planck 2018 parameters: the universe is 13.79 billion years old.
    close(Number.parseFloat(run(astro.universe_expansion, { z: 0, H0: 67.4, Om: 0.315 }).value), 13.79, 0.01);
    close(run(astro.schwarzschild, { M: 1.98841e30 }).value, 2953.3, 0.5);
    close(num(run(astro.grav_time_dilation, { body: 'earth', h1: 0, h2: 20200000 }).value), 45.72, 0.05);
    close(run(astro.velocity_addition, { v: 0.6 * K.c, w: 0.7 * K.c }).value, 0.915493 * K.c, 1000);
});

test('electromagnetism and electronics', () => {
    close(run(em.electrical_power, { pair: 'VI', V: 12, I: 2 }).value, 24, 1e-12);
    close(run(elec.ohms_law, { pair: 'VR', V: 12, R: 6 }).value, 2, 1e-12);
    close(run(elec.solenoid_inductance, { N: 100, l: 0.05, d: 0.02, mur: 1 }).value, 6.71017e-5, 1e-9);
    assert.equal(run(elec.resistor_colour, { bands: '4', b1: 'yellow', b2: 'violet', mult: 'red', tol: 'gold' }).value, '4.7 kΩ');
    close(run(elec.capacitor_code, { code: '104K' }).value, 1e-7, 1e-15);
    assert.equal(run(elec.breaker, { mode: 'W', P: 3000, V: 240, phase: 'single', cont: 'yes' }).value, '20 A');
});

test('thermodynamics', () => {
    close(num(run(thermo.compressibility, { gas: 'methane', P: 1e7, T: 25 }).value), 0.8298, 1e-3);
    close(run(thermo.lmtd, { flow: 'counter', Thi: 90, Tho: 50, Tci: 20, Tco: 40 }).value, 39.1523, 1e-3);
    // Wind chill −10 °C in 30 km/h wind is −19.5 °C (Environment Canada table); results are in kelvin.
    close(run(thermo.wind_chill, { T: -10, v: 30 / 3.6 }).value, 273.15 - 19.52, 0.01);
});

test('quantum mechanics and the sun', () => {
    close(run(quantum.hydrogen_levels, { n1: 2, n2: 3, Z: 1, reduced: 'h' }).value, 656.47e-9, 0.02e-9);
    close(num(run(quantum.binding_energy, { nuc: 'he4' }).value), 7.0739, 1e-3);
    const p = sunTimes(40, -105.25, 2010, 6, 21);
    close(p.rise.t - 6, 5.53, 0.03);
    close(p.set.t - 6, 20.55, 0.03);
    const pos = sunPosition(40, -105.25, 2010, 6, 21, 19.05);
    close(pos.elevation, 73.4, 0.2);
});

test('practice questions are reproducible and solvable', () => {
    const seeded = (seed) => {
        let a = seed;

        return () => {
            a = (a * 16807) % 2147483647;

            return a / 2147483647;
        };
    };

    for (const topic of Object.keys(TOPICS)) {
        const first = TOPICS[topic](seeded(7));
        const again = TOPICS[topic](seeded(7));
        assert.equal(first.q, again.q, topic);
        assert.ok(Number.isFinite(first.a), topic);
        assert.ok(first.work.length > 0, topic);
    }
});
