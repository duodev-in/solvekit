import { practice } from '../math/practice.js';
import { fmt as f } from '../math/rational.js';

/**
 * Practice questions for the Physics pages that replaced the old quizzes. Question n always gives the same
 * question; answers are accepted within the stated rounding.
 */
const pick = (r, list) => list[Math.floor(r() * list.length)];
const int = (r, lo, hi) => lo + Math.floor(r() * (hi - lo + 1));
const G = 9.81;

export const TOPICS = {
    netForce: (r) => {
        const kind = pick(r, ['line', 'line', 'right', 'accel']);

        if (kind === 'line') {
            const a = int(r, 5, 60);
            const b = int(r, 5, 60);

            return { q: `A box is pushed right with ${a} N and left with ${b} N. What is the net force in N (positive = right)?`, a: a - b, tol: 0, unit: 'N', work: [`ΣF = ${a} − ${b} = ${a - b} N`, a === b ? 'Balanced: no acceleration' : `Direction: ${a > b ? 'right' : 'left'}`] };
        }

        if (kind === 'right') {
            const [x, y, z] = pick(r, [[3, 4, 5], [6, 8, 10], [5, 12, 13], [9, 12, 15], [8, 15, 17], [12, 16, 20]]);
            const k = int(r, 1, 5);

            return { q: `Forces of ${x * k} N east and ${y * k} N north act on a puck. What is the size of the net force in N?`, a: z * k, tol: 0, unit: 'N', work: [`|F| = √(${x * k}² + ${y * k}²) = √${(z * k) ** 2} = ${z * k} N`] };
        }

        const m = int(r, 2, 20);
        const push = int(r, 20, 120);
        const fric = int(r, 5, push - 5);

        return { q: `A ${m} kg crate is pushed with ${push} N against ${fric} N of friction. What is its acceleration in m/s² (to 2 decimal places)?`, a: (push - fric) / m, tol: 0.006, unit: 'm/s²', work: [`ΣF = ${push} − ${fric} = ${push - fric} N`, `a = ΣF ÷ m = ${push - fric} ÷ ${m} ≈ ${f((push - fric) / m, 6)} m/s²`] };
    },

    potentialEnergy: (r) => {
        const kind = pick(r, ['energy', 'energy', 'height', 'mass']);
        const m = int(r, 1, 50);
        const h = int(r, 1, 40);
        const E = m * G * h;

        if (kind === 'energy') {
            return { q: `A ${m} kg object is lifted ${h} m (g = 9.81 m/s²). How much potential energy does it gain, in J (to 1 decimal place)?`, a: E, tol: 0.06, unit: 'J', work: [`E = mgh = ${m} × 9.81 × ${h} = ${f(E, 8)} J`] };
        }

        if (kind === 'height') {
            return { q: `A ${m} kg object has ${f(E, 8)} J of potential energy (g = 9.81 m/s²). How high is it in m?`, a: h, tol: 0.006, unit: 'm', work: [`h = E ÷ mg = ${f(E, 8)} ÷ (${m} × 9.81) = ${h} m`] };
        }

        return { q: `An object ${h} m up has ${f(E, 8)} J of potential energy (g = 9.81 m/s²). What is its mass in kg?`, a: m, tol: 0.006, unit: 'kg', work: [`m = E ÷ gh = ${f(E, 8)} ÷ (9.81 × ${h}) = ${m} kg`] };
    },

    frequency: (r) => {
        const kind = pick(r, ['f', 'T', 'wave', 'omega']);

        if (kind === 'f') {
            const T = pick(r, [0.5, 0.25, 0.2, 0.1, 0.05, 0.02, 0.01, 0.004, 0.002, 2, 4]);

            return { q: `A wave has a period of ${T} s. What is its frequency in Hz?`, a: 1 / T, tol: 1e-6, unit: 'Hz', work: [`f = 1 ÷ T = 1 ÷ ${T} = ${f(1 / T, 8)} Hz`] };
        }

        if (kind === 'T') {
            const fr = pick(r, [2, 4, 5, 10, 20, 25, 50, 100, 200, 250, 500, 1000]);

            return { q: `A signal has a frequency of ${fr} Hz. What is its period in s?`, a: 1 / fr, tol: 1e-9, unit: 's', work: [`T = 1 ÷ f = 1 ÷ ${fr} = ${f(1 / fr, 8)} s`] };
        }

        if (kind === 'wave') {
            const v = pick(r, [340, 343, 1480, 300]);
            const lambda = pick(r, [0.5, 1, 2, 4, 0.25, 0.1]);

            return { q: `A wave travels at ${v} m/s with a wavelength of ${lambda} m. What is its frequency in Hz?`, a: v / lambda, tol: 0.006, unit: 'Hz', work: [`f = v ÷ λ = ${v} ÷ ${lambda} = ${f(v / lambda, 8)} Hz`] };
        }

        const fr = int(r, 1, 60);

        return { q: `Something oscillates at ${fr} Hz. What is its angular frequency in rad/s (to 2 decimal places)?`, a: 2 * Math.PI * fr, tol: 0.006, unit: 'rad/s', work: [`ω = 2πf = 2π × ${fr} ≈ ${f(2 * Math.PI * fr, 8)} rad/s`] };
    },

    bendAllowance: (r) => {
        const angle = pick(r, [30, 45, 60, 90, 90, 120, 135]);
        const R = pick(r, [1, 1.5, 2, 3, 4, 5, 6]);
        const t = pick(r, [0.8, 1, 1.5, 2, 2.5, 3]);
        const k = pick(r, [0.33, 0.4, 0.42, 0.44, 0.5]);
        const ba = (Math.PI / 180) * angle * (R + k * t);

        return { q: `Sheet ${t} mm thick is bent ${angle}° with a ${R} mm inside radius and K-factor ${k}. What is the bend allowance in mm (to 2 decimal places)?`, a: ba, tol: 0.006, unit: 'mm', work: [`θ = ${angle}° = ${f((Math.PI / 180) * angle, 6)} rad`, `BA = θ(R + Kt) = ${f((Math.PI / 180) * angle, 6)} × (${R} + ${k} × ${t})`, `≈ ${f(ba, 6)} mm`] };
    },

    electricalPower: (r) => {
        const kind = pick(r, ['VI', 'IR', 'VR', 'PV']);
        const V = pick(r, [5, 9, 12, 24, 120, 230]);
        const R = pick(r, [2, 4, 5, 8, 10, 20, 50, 100]);
        const I = int(r, 1, 10);

        if (kind === 'VI') {
            return { q: `A device draws ${I} A from a ${V} V supply. What power does it use, in W?`, a: V * I, tol: 0, unit: 'W', work: [`P = V × I = ${V} × ${I} = ${V * I} W`] };
        }

        if (kind === 'IR') {
            return { q: `A current of ${I} A flows through a ${R} Ω resistor. What power does it dissipate, in W?`, a: I * I * R, tol: 0, unit: 'W', work: [`P = I²R = ${I}² × ${R} = ${I * I * R} W`] };
        }

        if (kind === 'VR') {
            return { q: `A ${R} Ω heater is connected to ${V} V. What power does it use, in W (to 1 decimal place)?`, a: (V * V) / R, tol: 0.06, unit: 'W', work: [`P = V² ÷ R = ${V}² ÷ ${R} = ${f((V * V) / R, 8)} W`] };
        }

        const P = V * I;

        return { q: `A ${P} W appliance runs on ${V} V. What current does it draw, in A?`, a: I, tol: 0.006, unit: 'A', work: [`I = P ÷ V = ${P} ÷ ${V} = ${I} A`] };
    },

    powerFactor: (r) => {
        const kind = pick(r, ['ps', 'pq', 'angle']);

        if (kind === 'ps') {
            const S = pick(r, [5, 8, 10, 12, 20, 25, 50]);
            const pf = pick(r, [0.6, 0.7, 0.75, 0.8, 0.85, 0.9, 0.95]);

            return { q: `A load uses ${f(S * pf, 6)} kW of real power and ${S} kVA of apparent power. What is its power factor (to 2 decimal places)?`, a: pf, tol: 0.006, unit: '', work: [`PF = P ÷ S = ${f(S * pf, 6)} ÷ ${S} = ${pf}`] };
        }

        if (kind === 'pq') {
            const [p, q, s] = pick(r, [[3, 4, 5], [4, 3, 5], [8, 6, 10], [12, 5, 13], [15, 8, 17], [24, 7, 25]]);

            return { q: `A motor takes ${p} kW and ${q} kVAR. What is its power factor (to 2 decimal places)?`, a: p / s, tol: 0.006, unit: '', work: [`S = √(P² + Q²) = √(${p * p} + ${q * q}) = ${s} kVA`, `PF = P ÷ S = ${p} ÷ ${s} = ${f(p / s, 6)}`] };
        }

        const deg = pick(r, [0, 25.84, 31.79, 36.87, 45, 53.13, 60]);

        return { q: `Current lags voltage by ${deg}°. What is the power factor (to 2 decimal places)?`, a: Math.cos((deg * Math.PI) / 180), tol: 0.006, unit: '', work: [`PF = cos φ = cos ${deg}° = ${f(Math.cos((deg * Math.PI) / 180), 6)}`] };
    },

    dunk: (r) => {
        const reach = int(r, 215, 250);
        const jump = int(r, 40, 95);
        const kind = pick(r, ['above', 'need']);

        if (kind === 'above') {
            return { q: `Your standing reach is ${reach} cm and your vertical jump is ${jump} cm. How many cm above a 305 cm rim can you reach (negative if below)?`, a: reach + jump - 305, tol: 0, unit: 'cm', work: [`Top of reach = ${reach} + ${jump} = ${reach + jump} cm`, `Above the rim: ${reach + jump} − 305 = ${reach + jump - 305} cm`] };
        }

        return { q: `Your standing reach is ${reach} cm. What vertical jump in cm do you need to reach 15 cm above a 305 cm rim?`, a: 320 - reach, tol: 0, unit: 'cm', work: [`Target height = 305 + 15 = 320 cm`, `Jump needed = 320 − ${reach} = ${320 - reach} cm`] };
    },
};

/** Physics practice mode: same runner as Math, with the physics questions. */
export const physicsPractice = (topic, i) => practice(topic, i, TOPICS);
