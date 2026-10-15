/**
 * Dimensional analysis: parses a unit expression such as "kg*m/s^2" or "N·m" into exponents of
 * the seven SI base dimensions and names the quantity when it is a known one.
 */
export const BASE = ['M', 'L', 'T', 'I', 'Θ', 'N', 'J'];

const D = (M = 0, L = 0, T = 0, I = 0, Θ = 0, N = 0, J = 0) => [M, L, T, I, Θ, N, J];

export const UNITS = {
    kg: D(1), g: D(1), mg: D(1), lb: D(1), oz: D(1), t: D(1),
    m: D(0, 1), cm: D(0, 1), mm: D(0, 1), km: D(0, 1), in: D(0, 1), ft: D(0, 1), yd: D(0, 1), mi: D(0, 1),
    s: D(0, 0, 1), ms: D(0, 0, 1), min: D(0, 0, 1), h: D(0, 0, 1), day: D(0, 0, 1),
    A: D(0, 0, 0, 1), mA: D(0, 0, 0, 1),
    K: D(0, 0, 0, 0, 1),
    mol: D(0, 0, 0, 0, 0, 1),
    cd: D(0, 0, 0, 0, 0, 0, 1),
    L: D(0, 3), mL: D(0, 3), gal: D(0, 3),
    N: D(1, 1, -2), kN: D(1, 1, -2), lbf: D(1, 1, -2), dyn: D(1, 1, -2),
    J: D(1, 2, -2), kJ: D(1, 2, -2), cal: D(1, 2, -2), kcal: D(1, 2, -2), eV: D(1, 2, -2), Wh: D(1, 2, -2), kWh: D(1, 2, -2), BTU: D(1, 2, -2), erg: D(1, 2, -2),
    W: D(1, 2, -3), kW: D(1, 2, -3), hp: D(1, 2, -3),
    Pa: D(1, -1, -2), kPa: D(1, -1, -2), bar: D(1, -1, -2), atm: D(1, -1, -2), psi: D(1, -1, -2),
    Hz: D(0, 0, -1),
    C: D(0, 0, 1, 1),
    V: D(1, 2, -3, -1),
    Ω: D(1, 2, -3, -2), ohm: D(1, 2, -3, -2),
    F: D(-1, -2, 4, 2),
    H: D(1, 2, -2, -2),
    T: D(1, 0, -2, -1),
    Wb: D(1, 2, -2, -1),
};

export const QUANTITIES = [
    ['Dimensionless', D()], ['Mass', D(1)], ['Length', D(0, 1)], ['Time', D(0, 0, 1)], ['Electric current', D(0, 0, 0, 1)],
    ['Temperature', D(0, 0, 0, 0, 1)], ['Amount of substance', D(0, 0, 0, 0, 0, 1)], ['Luminous intensity', D(0, 0, 0, 0, 0, 0, 1)],
    ['Area', D(0, 2)], ['Volume', D(0, 3)], ['Speed', D(0, 1, -1)], ['Acceleration', D(0, 1, -2)], ['Frequency', D(0, 0, -1)],
    ['Force', D(1, 1, -2)], ['Energy, work or torque', D(1, 2, -2)], ['Power', D(1, 2, -3)], ['Pressure or stress', D(1, -1, -2)],
    ['Momentum', D(1, 1, -1)], ['Density', D(1, -3)], ['Electric charge', D(0, 0, 1, 1)], ['Voltage', D(1, 2, -3, -1)],
    ['Resistance', D(1, 2, -3, -2)], ['Capacitance', D(-1, -2, 4, 2)], ['Magnetic flux density', D(1, 0, -2, -1)],
    ['Dynamic viscosity', D(1, -1, -1)], ['Kinematic viscosity', D(0, 2, -1)], ['Molar concentration', D(0, -3, 0, 0, 0, 1)],
];

const SUPERSCRIPTS = { '⁰': '0', '¹': '1', '²': '2', '³': '3', '⁴': '4', '⁵': '5', '⁶': '6', '⁷': '7', '⁸': '8', '⁹': '9', '⁻': '-' };

/**
 * Returns { exponents } or { error } for an expression like "50 kg·m/s²".
 */
export function analyse(expression) {
    let text = String(expression).trim().replace(/[⁰¹²³⁴⁵⁶⁷⁸⁹⁻]+/g, (match) => `^${[...match].map((char) => SUPERSCRIPTS[char]).join('')}`);
    text = text.replace(/^[-+]?[\d.,]+(e[-+]?\d+)?\s*/i, '').replace(/[·×]/g, '*').replace(/\s+/g, '*');

    if (text === '') {
        return { error: 'Enter a unit or an expression such as kg·m/s².' };
    }

    const exponents = D();
    let sign = 1;
    const tokens = text.split(/([*/])/).filter((token) => token !== '');

    for (const token of tokens) {
        if (token === '*') {
            continue;
        }

        if (token === '/') {
            sign = -1;
            continue;
        }

        const match = token.match(/^([A-Za-zΩ]+)(?:\^(-?\d+))?$/);

        if (!match || !UNITS[match[1]]) {
            return { error: `Unrecognised unit “${token}”. Use SI symbols such as kg, m, s, N, J, W, Pa, V or common ones like ft, lb, h.` };
        }

        const power = Number(match[2] ?? 1) * sign;
        UNITS[match[1]].forEach((exponent, index) => {
            exponents[index] += exponent * power;
        });
    }

    return { exponents };
}

export function formula(exponents) {
    const parts = exponents.map((exponent, index) => (exponent === 0 ? '' : exponent === 1 ? BASE[index] : `${BASE[index]}${String(exponent).replace(/[-\d]/g, (char) => (char === '-' ? '⁻' : '⁰¹²³⁴⁵⁶⁷⁸⁹'[char]))}`)).filter(Boolean);

    return parts.length ? `[${parts.join(' ')}]` : '[1]';
}

export function quantityName(exponents) {
    return QUANTITIES.find(([, dims]) => dims.every((value, index) => value === exponents[index]))?.[0] ?? null;
}

export default function dimensionalAnalysis(ctx) {
    ctx.onUpdate(() => {
        const text = ctx.field('value').value;

        if (text.trim() === '') {
            ctx.clearResult('Enter a unit or an expression such as kg·m/s².');

            return;
        }

        const { exponents, error } = analyse(text);

        if (error) {
            ctx.showError(error);

            return;
        }

        const name = quantityName(exponents);
        ctx.showResult({ value: formula(exponents), unit: '', label: 'Dimensions', sub: name ? `This is ${name.toLowerCase()}.` : 'Not one of the common named quantities.' });
        BASE.forEach((symbol, index) => ctx.setRow(`d${index}`, String(exponents[index])));
        ctx.setRow('quantity', name ?? 'Unnamed');
        ctx.setRow('dimensionless', exponents.every((value) => value === 0) ? 'Yes' : 'No');
    });
}
