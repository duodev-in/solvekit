import { num } from './core.js';

/**
 * Shared circuit helpers: engineering-notation lists and the V–I–R–P solver.
 */
const SUFFIX = { p: 1e-12, n: 1e-9, u: 1e-6, µ: 1e-6, m: 1e-3, k: 1e3, K: 1e3, M: 1e6, G: 1e9 };

/** "4.7k", "4k7", "220", "10u", "2R2" → number; plain numbers are multiplied by `scale`. */
export function parseEng(token, scale = 1) {
    const t = String(token).trim().replace(/Ω|ohms?|F|H$/gi, '');
    const rkm = t.match(/^(\d+)([pnuµmkKMGR])(\d+)$/);

    if (rkm) {
        return Number(`${rkm[1]}.${rkm[3]}`) * (rkm[2] === 'R' ? 1 : SUFFIX[rkm[2]]);
    }

    const m = t.match(/^([-+]?\d*\.?\d+(?:e[-+]?\d+)?)\s*([pnuµmkKMG])?$/i);

    if (!m) {
        return NaN;
    }

    return Number(m[1]) * (m[2] ? SUFFIX[m[2]] ?? SUFFIX[m[2].toLowerCase()] : scale);
}

/** A comma or line separated list of positive values in engineering notation, or null. */
export function engList(text, scale = 1) {
    const parts = String(text ?? '').split(/[\n,;]+/).map((s) => s.trim()).filter(Boolean);
    const values = parts.map((p) => parseEng(p, scale));

    return values.length && values.every((v) => Number.isFinite(v) && v > 0) ? values : null;
}

/** Engineering text for a value with a unit symbol: 4700 Ω → "4.7 kΩ". */
export function eng(value, unit, sig = 5) {
    if (!Number.isFinite(value) || value === 0) {
        return `${num(value, sig)} ${unit}`;
    }

    const steps = [[1e9, 'G'], [1e6, 'M'], [1e3, 'k'], [1, ''], [1e-3, 'm'], [1e-6, 'µ'], [1e-9, 'n'], [1e-12, 'p'], [1e-15, 'f']];
    const [f, p] = steps.find(([s]) => Math.abs(value) >= s) ?? steps[steps.length - 1];

    return `${num(value / f, sig)} ${p}${unit}`;
}

const PAIRS = { VI: 'Voltage and current', VR: 'Voltage and resistance', IR: 'Current and resistance', PV: 'Power and voltage', PI: 'Power and current', PR: 'Power and resistance' };

/** Ohm's law and power: any two of V, I, R, P give the other two. `want` picks the headline. */
export function vipr(want, pair = 'VI') {
    const label = { V: 'Voltage', I: 'Current', R: 'Resistance', P: 'Power' };
    const family = { V: ['voltage', 'v'], I: ['current', 'a'], R: ['resistance', 'ohm'], P: ['power', 'w'] };

    return {
        type: 'calc',
        inputs: { pair: ['I know', 'select', PAIRS, pair], V: ['Voltage', 'voltage', 'v', 12], I: ['Current', 'current', 'a', 2], R: ['Resistance', 'resistance', 'ohm', 6], P: ['Power', 'power', 'w', 24] },
        show: { V: 'pair:VI,VR,PV', I: 'pair:VI,IR,PI', R: 'pair:VR,IR,PR', P: 'pair:PV,PI,PR' },
        when: { V: (x) => x.pair.includes('V'), I: (x) => x.pair.includes('I'), R: (x) => x.pair.includes('R'), P: (x) => x.pair.includes('P') },
        out: family[want][0],
        outUnit: family[want][1],
        label: label[want],
        rows: { V: ['Voltage V', 'voltage'], I: ['Current I', 'current'], R: ['Resistance R', 'resistance'], P: ['Power P', 'power'] },
        run: (x) => {
            let { V, I, R, P } = x;

            switch (x.pair) {
                case 'VI': [R, P] = [V / I, V * I]; break;
                case 'VR': [I, P] = [V / R, (V * V) / R]; break;
                case 'IR': [V, P] = [I * R, I * I * R]; break;
                case 'PV': [I, R] = [P / V, (V * V) / P]; break;
                case 'PI': [V, R] = [P / I, P / (I * I)]; break;
                default: [V, I] = [Math.sqrt(P * R), Math.sqrt(P / R)];
            }

            const used = { VI: ['R = V ÷ I', 'P = V × I'], VR: ['I = V ÷ R', 'P = V² ÷ R'], IR: ['V = I × R', 'P = I² × R'], PV: ['I = P ÷ V', 'R = V² ÷ P'], PI: ['V = P ÷ I', 'R = P ÷ I²'], PR: ['V = √(PR)', 'I = √(P ÷ R)'] }[x.pair];

            return { value: { V, I, R, P }[want], sub: `V = ${num(V)} V, I = ${num(I)} A, R = ${num(R)} Ω, P = ${num(P)} W`, rows: { V: [V, 'voltage'], I: [I, 'current'], R: [R, 'resistance'], P: [P, 'power'] }, steps: ['Ohm’s law V = IR and power P = VI', ...used, `V = ${num(V)} V, I = ${num(I)} A, R = ${num(R)} Ω, P = ${num(P)} W`] };
        },
    };
}
