import { defineTools } from '../engines/formula.js';
import { D, handlersFor, K, num, pw } from '../physics/core.js';
import { eng, engList, vipr } from '../physics/circuits.js';
import { ellipticE, ellipticK } from '../physics/util.js';

/**
 * Electronics and circuits: passive networks, converters, filters, semiconductors and wiring.
 */
const SQ3 = Math.sqrt(3);
const TAU = 2 * Math.PI;
const VT = (T) => (K.k * T) / K.e;

/** IEC 60062 colour code: digit, multiplier exponent, tolerance (%), temperature coefficient (ppm/K). */
const COLOURS = {
    black: [0, 0, null, 250], brown: [1, 1, 1, 100], red: [2, 2, 2, 50], orange: [3, 3, 0.05, 15], yellow: [4, 4, 0.02, 25], green: [5, 5, 0.5, 20],
    blue: [6, 6, 0.25, 10], violet: [7, 7, 0.1, 5], grey: [8, 8, 0.01, 1], white: [9, 9, null, null], gold: [null, -1, 5, null], silver: [null, -2, 10, null], none: [null, null, 20, null],
};
const NAMES = Object.fromEntries(Object.keys(COLOURS).map((k) => [k, k[0].toUpperCase() + k.slice(1)]));
const DIGITS = Object.fromEntries(Object.entries(NAMES).filter(([k]) => COLOURS[k][0] !== null));
const MULTS = Object.fromEntries(Object.entries(NAMES).filter(([k]) => COLOURS[k][1] !== null && !['grey', 'white'].includes(k)));
const TOLS = Object.fromEntries(Object.entries(NAMES).filter(([k]) => COLOURS[k][2] !== null));
const TEMPCOS = Object.fromEntries(Object.entries(NAMES).filter(([k]) => COLOURS[k][3] !== null));

/** NEC 240.6(A) standard ampere ratings for fuses and inverse-time breakers. */
const BREAKERS = [15, 20, 25, 30, 35, 40, 45, 50, 60, 70, 80, 90, 100, 110, 125, 150, 175, 200, 225, 250, 300, 350, 400, 450, 500, 600, 700, 800, 1000, 1200, 1600, 2000, 2500, 3000, 4000, 5000, 6000];
/** ANSI/IEEE C57.12 standard distribution transformer ratings (kVA). */
const XFMR = { single: [1, 1.5, 2, 3, 5, 7.5, 10, 15, 25, 37.5, 50, 75, 100, 167, 250, 333, 500], three: [3, 6, 9, 15, 30, 45, 75, 112.5, 150, 225, 300, 500, 750, 1000, 1500, 2000, 2500, 3750, 5000] };
const AWG_SIZES = Object.fromEntries([-3, -2, -1, 0, ...Array.from({ length: 40 }, (_, k) => k + 1)].map((n) => [String(n), n < 0 ? `${'0'.repeat(1 - n)} (${1 - n}/0)` : n === 0 ? '0 (1/0)' : String(n)]));
/** Imperial Standard Wire Gauge (BS 3737), diameters in inches. */
const SWG = { '7/0': 0.5, '6/0': 0.464, '5/0': 0.432, '4/0': 0.4, '3/0': 0.372, '2/0': 0.348, '0': 0.324, 1: 0.3, 2: 0.276, 3: 0.252, 4: 0.232, 5: 0.212, 6: 0.192, 7: 0.176, 8: 0.16, 9: 0.144, 10: 0.128, 11: 0.116, 12: 0.104, 13: 0.092, 14: 0.08, 15: 0.072, 16: 0.064, 17: 0.056, 18: 0.048, 19: 0.04, 20: 0.036, 21: 0.032, 22: 0.028, 23: 0.024, 24: 0.022, 25: 0.02, 26: 0.018, 27: 0.0164, 28: 0.0148, 29: 0.0136, 30: 0.0124, 31: 0.0116, 32: 0.0108, 33: 0.01, 34: 0.0092, 35: 0.0084, 36: 0.0076, 37: 0.0068, 38: 0.006, 39: 0.0052, 40: 0.0048 };
const METRIC = [0.5, 0.75, 1, 1.5, 2.5, 4, 6, 10, 16, 25, 35, 50, 70, 95, 120, 150, 185, 240, 300];
const awgD = (n) => 0.127e-3 * 92 ** ((36 - n) / 39);
const UNIT_SCALE = { pf: 1e-12, nf: 1e-9, uf: 1e-6, mf: 1e-3, f: 1, nh: 1e-9, uh: 1e-6, mh: 1e-3, h: 1, ohm: 1, kohm: 1e3, megohm: 1e6 };
const C_UNITS = { pf: 'pF', nf: 'nF', uf: 'µF', mf: 'mF', f: 'F' };
const L_UNITS = { nh: 'nH', uh: 'µH', mh: 'mH', h: 'H' };
const R_UNITS = { ohm: 'Ω', kohm: 'kΩ', megohm: 'MΩ' };

/** A list tool: values typed in a unit (k, M, µ … suffixes allowed), combined by `combine`. */
function listTool({ label, unit, units, def, sample, combine, formula, sub }) {
    return {
        type: 'calc',
        inputs: { list: [`Values (comma or line separated; suffixes such as 4.7k, 100n allowed)`, 'textarea', null, sample], unit: ['Plain numbers are in', 'select', units, def] },
        label,
        rows: { count: 'Number of components', range: 'Smallest and largest' },
        run: (x) => {
            const v = engList(x.list, UNIT_SCALE[x.unit]);

            if (!v) {
                return { empty: 'Enter the component values.' };
            }

            const total = combine(v);

            return { value: eng(total, unit), sub: sub?.(v, total) ?? formula, rows: { count: String(v.length), range: `${eng(Math.min(...v), unit)} to ${eng(Math.max(...v), unit)}` }, steps: [formula, ...v.map((c, k) => `#${k + 1}: ${eng(c, unit)}`), `Total = ${eng(total, unit)}`] };
        },
    };
}

/** First-order RC/RL filter with its Bode plot. */
function filter(kind) {
    const low = kind === 'low';

    return {
        type: 'calc',
        inputs: { type: ['Filter', 'select', { rc: 'RC', rl: 'RL' }, 'rc'], R: ['Resistance', 'resistance', 'kohm', 1.6], C: ['Capacitance', 'capacitance', 'nf', 100], L: ['Inductance', 'inductance', 'mh', 10], order: ['Order (identical buffered stages)', 'select', { 1: 'First order', 2: 'Second order (two stages)', 3: 'Third order (three stages)' }, '1'], f: ['Test frequency (optional)', 'frequency_hz', 'khz', 5] },
        show: { C: 'type:rc', L: 'type:rl' },
        when: { C: (x) => x.type === 'rc', L: (x) => x.type === 'rl' },
        optional: ['f'],
        out: 'frequency_hz',
        outUnit: 'hz',
        label: 'Cutoff frequency (−3 dB, one stage)',
        rows: { gain: 'Gain at the test frequency', phase: 'Phase at the test frequency', slope: 'Roll-off', overall: 'Overall −3 dB point' },
        plots: [['bode', 'Magnitude response']],
        run: (x) => {
            const fc = x.type === 'rc' ? 1 / (TAU * x.R * x.C) : x.R / (TAU * x.L);
            const n = Number(x.order);
            const g = (f) => {
                const r = f / fc;

                return (low ? 1 / Math.sqrt(1 + r * r) : r / Math.sqrt(1 + r * r)) ** n;
            };
            const series = Array.from({ length: 121 }, (_, k) => {
                const f = fc * 10 ** (-2 + (4 * k) / 120);

                return [Math.log10(f), 20 * Math.log10(g(f))];
            });
            const overall = fc * (low ? Math.sqrt(2 ** (1 / n) - 1) : 1 / Math.sqrt(2 ** (1 / n) - 1));

            return { value: fc, sub: `${low ? 'Passes below' : 'Passes above'} ${eng(fc, 'Hz')}`, rows: { gain: Number.isFinite(x.f) ? `${num(20 * Math.log10(g(x.f)), 4)} dB (${num(g(x.f), 4)} ×)` : 'Enter a frequency', phase: Number.isFinite(x.f) ? `${num((low ? -1 : 1) * n * (low ? Math.atan(x.f / fc) : Math.atan(fc / x.f)) / D, 4)}°` : 'Enter a frequency', slope: `${20 * n} dB per decade (${6 * n} dB per octave)`, overall: eng(overall, 'Hz') }, steps: [x.type === 'rc' ? 'f_c = 1 ÷ 2πRC' : 'f_c = R ÷ 2πL', `= ${num(fc)} Hz`, n > 1 ? `Cascading ${n} buffered stages moves the overall −3 dB point to ${eng(overall, 'Hz')}` : 'Single stage'], plots: { bode: { series, axes: true, xLabel: 'log₁₀ frequency (Hz)', yLabel: 'Gain (dB)' } } };
        },
    };
}

/** Step response of an RC or RL circuit. */
function stepResponse(kind) {
    const rc = kind === 'rc';

    return {
        type: 'calc',
        inputs: { R: ['Resistance', 'resistance', rc ? 'kohm' : 'ohm', rc ? 10 : 100], X: rc ? ['Capacitance', 'capacitance', 'uf', 100] : ['Inductance', 'inductance', 'mh', 500], V: ['Source voltage', 'voltage', 'v', 12], mode: ['Response', 'select', { charge: rc ? 'Charging' : 'Switch on (current rises)', discharge: rc ? 'Discharging' : 'Switch off (current decays)' }, 'charge'], t: ['At time', 'short_time', 's', 1] },
        out: rc ? 'voltage' : 'current',
        outUnit: rc ? 'v' : 'ma',
        label: rc ? 'Capacitor voltage at that time' : 'Current at that time',
        rows: { tau: 'Time constant τ', five: '99.3% reached after 5τ', fc: 'Cutoff frequency', energy: 'Energy stored when full' },
        plots: [['curve', 'Response over 5 time constants']],
        run: (x) => {
            const tau = rc ? x.R * x.X : x.X / x.R;
            const full = rc ? x.V : x.V / x.R;
            const at = (t) => (x.mode === 'charge' ? full * (1 - Math.exp(-t / tau)) : full * Math.exp(-t / tau));
            const series = Array.from({ length: 101 }, (_, k) => [(5 * tau * k) / 100, at((5 * tau * k) / 100) * (rc ? 1 : 1000)]);

            return { value: at(x.t), sub: `τ = ${eng(tau, 's')}`, rows: { tau: eng(tau, 's'), five: eng(5 * tau, 's'), fc: eng(1 / (TAU * tau), 'Hz'), energy: `${num(rc ? 0.5 * x.X * x.V ** 2 : 0.5 * x.X * full ** 2)} J` }, steps: [rc ? 'τ = RC' : 'τ = L ÷ R', x.mode === 'charge' ? (rc ? 'V(t) = V₀(1 − e^(−t/τ))' : 'I(t) = (V/R)(1 − e^(−t/τ))') : (rc ? 'V(t) = V₀e^(−t/τ)' : 'I(t) = (V/R)e^(−t/τ)'), `At t = ${eng(x.t, 's')}: ${rc ? `${num(at(x.t))} V` : `${num(at(x.t) * 1000)} mA`}`], plots: { curve: { series, axes: true, xLabel: 'Time (s)', yLabel: rc ? 'Voltage (V)' : 'Current (mA)' } } };
        },
    };
}

/** Converter inputs shared by buck, boost and buck-boost. */
const CONV = { Vin: ['Input voltage', 'voltage', 'v', 12], Vout: ['Output voltage (magnitude)', 'voltage', 'v', 5], Iout: ['Output current', 'current', 'a', 2], fs: ['Switching frequency', 'frequency_hz', 'khz', 500], ripple: ['Inductor ripple (% of inductor current)', null, null, 30, 0], dv: ['Output voltage ripple', 'voltage', 'mv', 20], eff: ['Efficiency (%)', null, null, 90, 0] };
const convRows = { D: 'Duty cycle', L: 'Minimum inductance', C: 'Minimum output capacitance', Ipk: 'Peak inductor current', IL: 'Average inductor current' };

export const TOOLS = {
    boost: {
        type: 'calc',
        inputs: { ...CONV, Vin: ['Input voltage', 'voltage', 'v', 5], Vout: ['Output voltage', 'voltage', 'v', 12], Iout: ['Output current', 'current', 'a', 1] },
        label: 'Duty cycle',
        rows: convRows,
        run: (x) => {
            if (!(x.Vout > x.Vin)) {
                return { error: 'A boost converter needs the output above the input.' };
            }

            const D = 1 - (x.Vin * (x.eff / 100)) / x.Vout;
            const IL = x.Iout / (1 - D);
            const dI = (x.ripple / 100) * IL;
            const L = (x.Vin * D) / (dI * x.fs);
            const C = (x.Iout * D) / (x.fs * x.dv);

            return { value: `${num(D * 100, 4)}%`, sub: `L ≥ ${eng(L, 'H')}, C ≥ ${eng(C, 'F')}`, rows: { D: num(D, 4), L: eng(L, 'H'), C: eng(C, 'F'), Ipk: eng(IL + dI / 2, 'A'), IL: eng(IL, 'A') }, steps: ['Continuous conduction: D = 1 − V_in η ÷ V_out', 'L = V_in D ÷ (ΔI f_s), C = I_out D ÷ (f_s ΔV)', 'Add margin and pick an inductor rated for the peak current; ESR adds to the ripple'] };
        },
    },
    breaker: {
        type: 'calc',
        inputs: { mode: ['Load given as', 'select', { A: 'Current', W: 'Power' }, 'W'], I: ['Load current', 'current', 'a', 16], P: ['Load power', 'power', 'w', 3000], V: ['Voltage', 'voltage', 'v', 240], phase: ['Supply', 'select', { single: 'Single phase', three: 'Three phase' }, 'single'], cont: ['Continuous load (3 h or more)', 'select', { yes: 'Yes', no: 'No' }, 'yes'] },
        show: { I: 'mode:A', P: 'mode:W' },
        when: { I: (x) => x.mode === 'A', P: (x) => x.mode === 'W' },
        label: 'Breaker size',
        rows: { I: 'Load current', need: 'Minimum rating', note: 'Note' },
        run: (x) => {
            const I = x.mode === 'A' ? x.I : x.P / (x.V * (x.phase === 'three' ? SQ3 : 1));
            const need = x.cont === 'yes' ? 1.25 * I : I;
            const size = BREAKERS.find((b) => b >= need - 1e-9);

            return { value: size ? `${size} A` : 'Above 6,000 A', sub: `Minimum ${num(need, 4)} A${x.cont === 'yes' ? ' (125% of a continuous load)' : ''}`, rows: { I: `${num(I, 4)} A`, need: `${num(need, 4)} A`, note: 'Sizing per NEC 210.20(A) and standard ratings in NEC 240.6(A). The wire must be rated for the breaker; local codes may differ, so confirm with an electrician' }, steps: [x.mode === 'W' ? `I = P ÷ ${x.phase === 'three' ? '(√3 V)' : 'V'} = ${num(I)} A` : `I = ${num(I)} A`, x.cont === 'yes' ? `Continuous load × 1.25 = ${num(need)} A` : 'Non-continuous: no extra factor', `Next standard size: ${size} A`] };
        },
    },
    bridge_rectifier: {
        type: 'calc',
        inputs: { Vac: ['Transformer secondary (RMS)', 'voltage', 'v', 12], f: ['Mains frequency', 'frequency_hz', 'hz', 50], Vf: ['Diode forward drop (each)', 'voltage', 'v', 0.7], I: ['Load current', 'current', 'a', 1], C: ['Smoothing capacitor', 'capacitance', 'uf', 4700] },
        out: 'voltage',
        outUnit: 'v',
        label: 'Average DC output',
        rows: { pk: ['Peak output', 'voltage'], ripple: ['Ripple (peak to peak)', 'voltage'], piv: ['Diode reverse voltage (PIV)', 'voltage'], Cfor: 'Capacitor for 1 V ripple' },
        plots: [['wave', 'Output voltage (two cycles)']],
        run: (x) => {
            const pk = Math.SQRT2 * x.Vac - 2 * x.Vf;
            const dv = x.I / (2 * x.f * x.C);
            const T = 1 / x.f;
            const series = Array.from({ length: 201 }, (_, k) => {
                const t = (2 * T * k) / 200;
                const rect = Math.max(0, Math.abs(Math.SQRT2 * x.Vac * Math.sin(TAU * x.f * t)) - 2 * x.Vf);
                const since = ((((t - T / 4) % (T / 2)) + T / 2) % (T / 2)) / (T / 2);
                const decay = pk - dv * since;

                return [t * 1000, Math.max(rect, Math.min(pk, decay))];
            });

            return { value: pk - dv / 2, sub: `Ripple ${num(dv)} V peak to peak`, rows: { pk: [pk, 'voltage'], ripple: [dv, 'voltage'], piv: [Math.SQRT2 * x.Vac, 'voltage'], Cfor: eng(x.I / (2 * x.f * 1), 'F') }, steps: ['V_peak = √2 V_rms − 2V_f', `= ${num(pk)} V`, 'Full-wave ripple ΔV ≈ I ÷ (2fC)', `= ${num(dv)} V, average ≈ V_peak − ΔV/2`], plots: { wave: { series, axes: true, xLabel: 'Time (ms)', yLabel: 'Voltage (V)' } } };
        },
    },
    buck: {
        type: 'calc',
        inputs: CONV,
        label: 'Duty cycle',
        rows: convRows,
        run: (x) => {
            if (!(x.Vout < x.Vin)) {
                return { error: 'A buck converter needs the output below the input.' };
            }

            const D = x.Vout / (x.Vin * (x.eff / 100));
            const dI = (x.ripple / 100) * x.Iout;
            const L = (x.Vout * (x.Vin - x.Vout)) / (dI * x.fs * x.Vin);
            const C = dI / (8 * x.fs * x.dv);

            return { value: `${num(D * 100, 4)}%`, sub: `L ≥ ${eng(L, 'H')}, C ≥ ${eng(C, 'F')}`, rows: { D: num(D, 4), L: eng(L, 'H'), C: eng(C, 'F'), Ipk: eng(x.Iout + dI / 2, 'A'), IL: eng(x.Iout, 'A') }, steps: ['Continuous conduction: D = V_out ÷ (V_in η)', 'L = V_out(V_in − V_out) ÷ (ΔI f_s V_in)', 'C = ΔI ÷ (8 f_s ΔV) (ESR ignored)'] };
        },
    },
    cap_dropper: {
        type: 'calc',
        inputs: { Vac: ['Mains voltage (RMS)', 'voltage', 'v', 230], f: ['Frequency', 'frequency_hz', 'hz', 50], Vout: ['Output (Zener) voltage', 'voltage', 'v', 12], I: ['Load current', 'current', 'ma', 20] },
        out: 'capacitance',
        outUnit: 'uf',
        label: 'Dropping capacitor',
        rows: { X: 'Reactance', rating: 'Capacitor rating', bleed: 'Bleeder resistor', warn: 'Safety' },
        run: (x) => {
            const X = (x.Vac - x.Vout) / x.I;
            const C = 1 / (TAU * x.f * X);

            return { value: C, sub: `X_C = ${eng(X, 'Ω')}`, rows: { X: eng(X, 'Ω'), rating: 'X2 class, at least 275 V AC for 230 V mains', bleed: 'About 1 MΩ across the capacitor', warn: 'The whole circuit is at mains potential: no isolation. Use only in enclosed designs and never touch it while connected' }, steps: ['X_C ≈ (V_ac − V_out) ÷ I (half-wave Zener supply)', `C = 1 ÷ (2πf X_C) = ${eng(C, 'F')}`] };
        },
    },
    cap_charge_time: {
        type: 'calc',
        inputs: { R: ['Resistance', 'resistance', 'kohm', 10], C: ['Capacitance', 'capacitance', 'uf', 100], Vs: ['Supply voltage', 'voltage', 'v', 12], V0: ['Starting voltage', 'voltage', 'v', 0], Vt: ['Target voltage', 'voltage', 'v', 9] },
        out: 'short_time',
        outUnit: 's',
        label: 'Time to reach the target',
        rows: { tau: 'Time constant RC', share: 'Share of the way', five: 'Practically full (5RC)' },
        plots: [['curve', 'Charging curve']],
        run: (x) => {
            const tau = x.R * x.C;
            const frac = (x.Vt - x.V0) / (x.Vs - x.V0);

            if (!(frac > 0 && frac < 1)) {
                return { error: 'The target must lie between the starting voltage and the supply.' };
            }

            const t = -tau * Math.log(1 - frac);
            const series = Array.from({ length: 101 }, (_, k) => [(5 * tau * k) / 100, x.Vs - (x.Vs - x.V0) * Math.exp(-(5 * k) / 100)]);

            return { value: t, sub: `${num(t / tau, 4)} time constants`, rows: { tau: eng(tau, 's'), share: `${num(frac * 100, 4)}%`, five: eng(5 * tau, 's') }, steps: ['V(t) = V_s − (V_s − V₀)e^(−t/RC)', 't = −RC ln(1 − (V_t − V₀) ÷ (V_s − V₀))', `= ${eng(t, 's')}`], plots: { curve: { series, axes: true, xLabel: 'Time (s)', yLabel: 'Voltage (V)' } } };
        },
    },
    capacitor: pw({ vars: { Q: ['Charge', 'charge', 'uc', 1200], C: ['Capacitance', 'capacitance', 'uf', 100], V: ['Voltage', 'voltage', 'v', 12] }, out: 'Q', exp: { C: 1, V: 1 }, eq: 'Q = C V', forms: { Q: 'Q = CV', C: 'C = Q ÷ V', V: 'V = Q ÷ C' }, rows: { E: 'Energy stored' }, extra: (v) => ({ E: `${num(0.5 * v.C * v.V ** 2)} J` }) }),
    capacitor_energy: pw({ vars: { E: ['Energy stored', 'energy', 'j', 7.2], C: ['Capacitance', 'capacitance', 'uf', 100000], V: ['Voltage', 'voltage', 'v', 12] }, out: 'E', k: 0.5, exp: { C: 1, V: 2 }, eq: 'E = ½ C V²', forms: { E: 'E = ½CV²', C: 'C = 2E ÷ V²', V: 'V = √(2E ÷ C)' }, rows: { Q: 'Charge', wh: 'In watt-hours' }, extra: (v) => ({ Q: `${num(v.C * v.V)} C`, wh: `${num(v.E / 3600)} Wh` }) }),
    caps_series: listTool({ label: 'Total capacitance', unit: 'F', units: C_UNITS, def: 'uf', sample: '10, 22, 47', combine: (v) => 1 / v.reduce((a, b) => a + 1 / b, 0), formula: '1/C = Σ 1/Cᵢ', sub: (v, t) => `Smaller than the smallest (${eng(Math.min(...v), 'F')})` }),
    cap_size: {
        type: 'calc',
        inputs: { purpose: ['Purpose', 'select', { energy: 'Store an amount of energy', smooth: 'Smooth a rectified supply', holdup: 'Hold up a load for a time' }, 'smooth'], E: ['Energy', 'energy', 'j', 10], V: ['Voltage', 'voltage', 'v', 12], I: ['Load current', 'current', 'a', 1], f: ['Mains frequency', 'frequency_hz', 'hz', 50], rect: ['Rectifier', 'select', { full: 'Full wave', half: 'Half wave' }, 'full'], dv: ['Allowed ripple or droop', 'voltage', 'v', 1], P: ['Load power', 'power', 'w', 10], t: ['Hold-up time', 'short_time', 'ms', 20], Vmin: ['Minimum voltage the load accepts', 'voltage', 'v', 9] },
        show: { E: 'purpose:energy', I: 'purpose:smooth', f: 'purpose:smooth', rect: 'purpose:smooth', dv: 'purpose:smooth', P: 'purpose:holdup', t: 'purpose:holdup', Vmin: 'purpose:holdup' },
        when: { E: (x) => x.purpose === 'energy', I: (x) => x.purpose === 'smooth', f: (x) => x.purpose === 'smooth', dv: (x) => x.purpose === 'smooth', P: (x) => x.purpose === 'holdup', t: (x) => x.purpose === 'holdup', Vmin: (x) => x.purpose === 'holdup' },
        out: 'capacitance',
        outUnit: 'uf',
        label: 'Capacitance needed',
        rows: { rating: 'Voltage rating', note: 'Note' },
        run: (x) => {
            let C;
            let step;

            if (x.purpose === 'energy') {
                C = (2 * x.E) / (x.V * x.V);
                step = 'C = 2E ÷ V²';
            } else if (x.purpose === 'smooth') {
                C = x.I / ((x.rect === 'full' ? 2 : 1) * x.f * x.dv);
                step = `C = I ÷ (${x.rect === 'full' ? '2' : ''}f ΔV)`;
            } else {
                if (!(x.Vmin < x.V)) {
                    return { error: 'The minimum voltage must be below the starting voltage.' };
                }

                C = (2 * x.P * x.t) / (x.V * x.V - x.Vmin * x.Vmin);
                step = 'C = 2Pt ÷ (V² − V_min²)';
            }

            return { value: C, sub: step, rows: { rating: `At least ${num(Math.ceil(x.V * 1.5))} V (about 1.5 × the working voltage)`, note: 'Electrolytics are often −20% on capacitance: choose the next larger standard value' }, steps: [step, `= ${eng(C, 'F')}`] };
        },
    },
    crossover: {
        type: 'calc',
        inputs: { f: ['Crossover frequency', 'frequency_hz', 'hz', 2500], Rw: ['Woofer impedance', 'resistance', 'ohm', 8], Rt: ['Tweeter impedance', 'resistance', 'ohm', 8], type: ['Type', 'select', { first: 'First order (6 dB/octave)', bw2: 'Second-order Butterworth (12 dB/octave)', lr2: 'Second-order Linkwitz–Riley (12 dB/octave)' }, 'lr2'] },
        label: 'Crossover components',
        rows: { woofer: 'Woofer (low-pass)', tweeter: 'Tweeter (high-pass)', polarity: 'Tweeter polarity' },
        run: (x) => {
            const w = TAU * x.f;
            let woofer;
            let tweeter;

            if (x.type === 'first') {
                woofer = `Series L = ${eng(x.Rw / w, 'H')}`;
                tweeter = `Series C = ${eng(1 / (w * x.Rt), 'F')}`;
            } else {
                const [kl, kc] = x.type === 'bw2' ? [Math.SQRT2, 1 / Math.SQRT2] : [2, 0.5];
                woofer = `Series L = ${eng((kl * x.Rw) / w, 'H')}, shunt C = ${eng(kc / (w * x.Rw), 'F')}`;
                tweeter = `Series C = ${eng(kc / (w * x.Rt), 'F')}, shunt L = ${eng((kl * x.Rt) / w, 'H')}`;
            }

            return { value: x.type === 'first' ? 'First order' : x.type === 'bw2' ? 'Butterworth' : 'Linkwitz–Riley', sub: `Crossover at ${eng(x.f, 'Hz')} into resistive loads`, rows: { woofer, tweeter, polarity: x.type === 'first' ? 'Normal' : x.type === 'lr2' ? 'Reverse the tweeter (LR2 drivers are 180° apart)' : 'Reverse the tweeter for the flattest sum' }, steps: [x.type === 'first' ? 'L = R ÷ 2πf, C = 1 ÷ 2πfR' : x.type === 'bw2' ? 'Butterworth: L = √2R ÷ 2πf, C = 1 ÷ (2πf √2 R)' : 'Linkwitz–Riley: L = R ÷ πf, C = 1 ÷ (4πfR)', 'Real drivers are not resistors: an impedance (Zobel) network or measurement-based design gives better results'] };
        },
    },
    current_divider: {
        type: 'calc',
        inputs: { I: ['Total current', 'current', 'a', 1], list: ['Branch resistances in ohms (k and M allowed)', 'textarea', null, '100, 220, 470'] },
        label: 'Equivalent resistance',
        rows: { V: 'Voltage across the branches' },
        grids: [['branches', 'Current in each branch']],
        run: (x) => {
            const rs = engList(x.list);

            if (!rs) {
                return { empty: 'Enter the branch resistances.' };
            }

            const Rt = 1 / rs.reduce((a, b) => a + 1 / b, 0);

            return { value: eng(Rt, 'Ω'), sub: `V = ${eng(x.I * Rt, 'V')}`, rows: { V: eng(x.I * Rt, 'V') }, steps: ['Iₓ = I × R_T ÷ Rₓ', `R_T = ${eng(Rt, 'Ω')}`], grids: { branches: { columns: ['Current', 'Share', 'Power'], rows: rs.map((r) => ({ header: eng(r, 'Ω'), cells: [eng((x.I * Rt) / r, 'A'), `${num((Rt / r) * 100, 4)}%`, eng(((x.I * Rt) ** 2) / r, 'W')] })) } } };
        },
    },
    dipole_antenna: {
        type: 'calc',
        inputs: { f: ['Frequency', 'frequency_hz', 'mhz', 14.2], k: ['End-effect factor', null, null, 0.95, 0] },
        out: 'length',
        outUnit: 'm',
        label: 'Total dipole length',
        rows: { leg: ['Each leg', 'length'], free: ['Free-space half wavelength', 'length'], ft: 'In feet (468 ÷ f MHz)' },
        run: (x) => {
            const half = K.c / (2 * x.f);

            return { value: half * x.k, sub: `Each leg ${num((half * x.k) / 2)} m; trim for lowest SWR`, rows: { leg: [(half * x.k) / 2, 'length'], free: [half, 'length'], ft: `${num((half * x.k) / 0.3048)} ft` }, steps: ['L = k × c ÷ 2f', `= ${num(x.k)} × ${num(half)} m = ${num(half * x.k)} m`] };
        },
    },
    flyback: {
        type: 'calc',
        inputs: { Vin: ['Minimum input voltage', 'voltage', 'v', 100], Vout: ['Output voltage', 'voltage', 'v', 12], Vf: ['Output diode drop', 'voltage', 'v', 0.5], P: ['Output power', 'power', 'w', 24], fs: ['Switching frequency', 'frequency_hz', 'khz', 100], Dmax: ['Maximum duty cycle (%)', null, null, 45, 0], eff: ['Efficiency (%)', null, null, 85, 0] },
        label: 'Turns ratio Np : Ns',
        rows: { D: 'Duty cycle at minimum input', Lm: 'Magnetising inductance (boundary mode)', Ipk: 'Peak primary current', Vds: 'Switch voltage (before spike)' },
        run: (x) => {
            const D = x.Dmax / 100;
            const n = (x.Vin * D) / ((x.Vout + x.Vf) * (1 - D));
            const Pin = x.P / (x.eff / 100);
            const Lm = ((x.Vin * D) ** 2) / (2 * Pin * x.fs);
            const Ipk = (x.Vin * D) / (Lm * x.fs);

            return { value: `${num(n, 4)} : 1`, sub: `L_m ≤ ${eng(Lm, 'H')} for discontinuous mode`, rows: { D: `${num(D * 100, 4)}%`, Lm: eng(Lm, 'H'), Ipk: eng(Ipk, 'A'), Vds: `${num(x.Vin + n * (x.Vout + x.Vf))} V at minimum input; add leakage spike and the maximum input` }, steps: ['n = V_in D ÷ ((V_out + V_f)(1 − D))', 'Boundary mode: L_m = (V_in D)² ÷ (2 P_in f_s)', 'I_pk = V_in D ÷ (L_m f_s)', 'A starting point: transformer design and snubbers need detailed work'] };
        },
    },
    forward: {
        type: 'calc',
        inputs: { Vin: ['Input voltage', 'voltage', 'v', 48], Vout: ['Output voltage', 'voltage', 'v', 5], n: ['Turns ratio Np : Ns', null, null, 4, 0], Iout: ['Output current', 'current', 'a', 5], fs: ['Switching frequency', 'frequency_hz', 'khz', 200], ripple: ['Inductor ripple (%)', null, null, 30, 0] },
        label: 'Duty cycle',
        rows: { L: 'Output inductor', Vs: 'Secondary peak voltage', check: 'Reset check (1:1 reset winding)' },
        run: (x) => {
            const Vs = x.Vin / x.n;
            const D = x.Vout / Vs;
            const L = (x.Vout * (1 - D)) / ((x.ripple / 100) * x.Iout * x.fs);

            return { value: `${num(D * 100, 4)}%`, sub: `Output inductor ≥ ${eng(L, 'H')}`, rows: { L: eng(L, 'H'), Vs: `${num(Vs)} V`, check: D < 0.5 ? 'OK: below 50%' : 'Too high: the core cannot reset; lower the turns ratio' }, steps: ['V_out = D V_in (Ns ÷ Np)', `D = ${num(x.Vout)} ÷ ${num(Vs)} = ${num(D)}`, 'L = V_out(1 − D) ÷ (ΔI f_s)'] };
        },
    },
    generator: {
        type: 'calc',
        inputs: { phase: ['Supply', 'select', { single: 'Single phase', three: 'Three phase' }, 'three'], V: ['Voltage', 'voltage', 'v', 400], I: ['Current', 'current', 'a', 30], pf: ['Power factor', null, null, 0.8, 0], margin: ['Margin (%)', null, null, 25, 0] },
        label: 'Generator rating',
        rows: { kw: 'Real power', kva: 'Apparent power', size: 'Suggested size with margin' },
        run: (x) => {
            const S = (x.phase === 'three' ? SQ3 : 1) * x.V * x.I;

            return { value: num((S * x.pf) / 1000, 4) + ' kW', sub: `${num(S / 1000, 4)} kVA`, rows: { kw: `${num((S * x.pf) / 1000, 4)} kW`, kva: `${num(S / 1000, 4)} kVA`, size: `${num((S / 1000) * (1 + x.margin / 100), 4)} kVA (motor starting surges may need more)` }, steps: [x.phase === 'three' ? 'P = √3 V I PF' : 'P = V I PF', `= ${num(S * x.pf)} W`] };
        },
    },
    helical_coil: {
        type: 'calc',
        inputs: { D: ['Coil diameter (to the wire centre)', 'length', 'mm', 20], p: ['Pitch (rise per turn)', 'length', 'mm', 2], N: ['Turns', null, null, 10, 0] },
        out: 'length',
        outUnit: 'mm',
        label: 'Wire length',
        rows: { height: ['Coil height', 'length'], angle: 'Helix angle' },
        run: (x) => {
            const turn = Math.hypot(Math.PI * x.D, x.p);

            return { value: x.N * turn, sub: `${num(turn * 1000)} mm per turn`, rows: { height: [x.N * x.p, 'length'], angle: `${num(Math.atan(x.p / (Math.PI * x.D)) / D)}°` }, steps: ['L = N √((πD)² + p²)', `= ${num(x.N)} × ${num(turn * 1000)} mm = ${num(x.N * turn * 1000)} mm`] };
        },
    },
    high_pass: filter('high'),
    transformer: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { turns: 'Turns', ratio: 'Voltage ratio' }, 'turns'], N1: ['Primary turns', null, null, 500, 0], N2: ['Secondary turns', null, null, 25, 0], V1: ['Primary voltage', 'voltage', 'v', 230], V2: ['Secondary voltage (for the ratio)', 'voltage', 'v', 12], I2: ['Secondary current', 'current', 'a', 2] },
        show: { N1: 'mode:turns', N2: 'mode:turns', V2: 'mode:ratio' },
        when: { N1: (x) => x.mode === 'turns', N2: (x) => x.mode === 'turns', V2: (x) => x.mode === 'ratio' },
        out: 'voltage',
        outUnit: 'v',
        label: 'Secondary voltage',
        rows: { ratio: 'Turns ratio', I1: ['Primary current', 'current'], VA: 'Power (ideal)', Z: 'Impedance ratio' },
        run: (x) => {
            const a = x.mode === 'turns' ? x.N1 / x.N2 : x.V1 / x.V2;
            const V2 = x.V1 / a;

            return { value: V2, sub: `Ratio ${num(a, 5)} : 1 (${a > 1 ? 'step-down' : 'step-up'})`, rows: { ratio: `${num(a, 5)} : 1`, I1: [x.I2 / a, 'current'], VA: `${num(V2 * x.I2)} VA`, Z: `${num(a * a)} : 1` }, steps: ['V₁/V₂ = N₁/N₂ = I₂/I₁', `V₂ = ${num(x.V1)} ÷ ${num(a)} = ${num(V2)} V`, 'Ideal: no losses, no magnetising current'] };
        },
    },
    inductor_energy: pw({ vars: { E: ['Energy stored', 'energy', 'j', 0.05], L: ['Inductance', 'inductance', 'mh', 10], I: ['Current', 'current', 'a', 3.1623] }, out: 'E', k: 0.5, exp: { L: 1, I: 2 }, eq: 'E = ½ L I²', forms: { E: 'E = ½LI²', L: 'L = 2E ÷ I²', I: 'I = √(2E ÷ L)' } }),
    inductors_parallel: listTool({ label: 'Total inductance', unit: 'H', units: L_UNITS, def: 'mh', sample: '10, 22, 47', combine: (v) => 1 / v.reduce((a, b) => a + 1 / b, 0), formula: '1/L = Σ 1/Lᵢ (no mutual coupling)' }),
    inductors_series: {
        type: 'calc',
        inputs: { list: ['Inductances (comma or line separated; suffixes allowed)', 'textarea', null, '10, 22'], unit: ['Plain numbers are in', 'select', L_UNITS, 'mh'], M: ['Mutual inductance between two coils (optional)', 'inductance', 'mh', 0], aiding: ['Coupling', 'select', { aiding: 'Aiding (fields add)', opposing: 'Opposing' }, 'aiding'] },
        optional: ['M'],
        label: 'Total inductance',
        rows: { sum: 'Without coupling', k: 'Coupling coefficient (two coils)' },
        run: (x) => {
            const v = engList(x.list, UNIT_SCALE[x.unit]);

            if (!v) {
                return { empty: 'Enter the inductances.' };
            }

            const sum = v.reduce((a, b) => a + b, 0);
            const M = Number.isFinite(x.M) ? x.M : 0;
            const total = sum + (x.aiding === 'aiding' ? 2 : -2) * M;

            return { value: eng(total, 'H'), sub: M ? `L = ΣL ${x.aiding === 'aiding' ? '+' : '−'} 2M` : 'L = ΣLᵢ', rows: { sum: eng(sum, 'H'), k: v.length === 2 && M ? num(M / Math.sqrt(v[0] * v[1]), 4) : 'Two coils with M only' }, steps: ['L = ΣLᵢ ± 2M', `= ${eng(total, 'H')}`] };
        },
    },
    buck_boost: {
        type: 'calc',
        inputs: CONV,
        label: 'Duty cycle',
        rows: convRows,
        run: (x) => {
            const D = x.Vout / (x.Vin * (x.eff / 100) + x.Vout);
            const IL = x.Iout / (1 - D);
            const dI = (x.ripple / 100) * IL;
            const L = (x.Vin * D) / (dI * x.fs);
            const C = (x.Iout * D) / (x.fs * x.dv);

            return { value: `${num(D * 100, 4)}%`, sub: `Output −${num(x.Vout)} V; L ≥ ${eng(L, 'H')}`, rows: { D: num(D, 4), L: eng(L, 'H'), C: eng(C, 'F'), Ipk: eng(IL + dI / 2, 'A'), IL: eng(IL, 'A') }, steps: ['Inverting buck-boost, continuous conduction: |V_out| ÷ V_in = D ÷ (1 − D)', 'D = |V_out| ÷ (V_in η + |V_out|)', 'L = V_in D ÷ (ΔI f_s), C = I_out D ÷ (f_s ΔV)'] };
        },
    },
    jpole: {
        type: 'calc',
        inputs: { f: ['Frequency', 'frequency_hz', 'mhz', 146], vf: ['Velocity factor of the element', null, null, 0.95, 0] },
        out: 'length',
        outUnit: 'cm',
        label: 'Long element',
        rows: { radiator: ['Half-wave radiator section', 'length'], stub: ['Quarter-wave matching stub (short element)', 'length'], feed: ['Feed point above the shorted end (start, then adjust)', 'length'], gap: 'Element spacing' },
        run: (x) => {
            const l = K.c / x.f;
            const half = 0.5 * l * x.vf;
            const quarter = 0.25 * l * x.vf;

            return { value: half + quarter, sub: `Short element ${num(quarter * 100)} cm`, rows: { radiator: [half, 'length'], stub: [quarter, 'length'], feed: [0.05 * l, 'length'], gap: 'About 2–5 cm for VHF; keep it small compared with λ' }, steps: [`λ = c ÷ f = ${num(l * 100)} cm`, 'Long element = (λ/2 + λ/4) × VF, short element = λ/4 × VF', 'Feed tap near 5% of λ: slide it for lowest SWR'] };
        },
    },
    led_resistor: {
        type: 'calc',
        inputs: { Vs: ['Supply voltage', 'voltage', 'v', 5], led: ['LED colour', 'select', 'data:leds', 'red'], Vf: ['Forward voltage', 'voltage', 'v', 2], I: ['LED current', 'current', 'ma', 20], n: ['LEDs in series', null, null, 1, 1] },
        show: { Vf: 'led:custom' },
        when: { Vf: (x) => x.led === 'custom' },
        data: ['leds'],
        out: 'resistance',
        outUnit: 'ohm',
        label: 'Resistor value',
        rows: { e12: 'Next standard value (E12)', P: 'Resistor power', rating: 'Suggested rating', Pled: 'Power in each LED' },
        run: (x, ctx) => {
            const Vf = x.led === 'custom' ? x.Vf : ctx.c.data.physics.leds[x.led].vf;
            const drop = x.Vs - x.n * Vf;

            if (!(drop > 0)) {
                return { error: 'The supply is too low for that many LEDs in series.' };
            }

            const R = drop / x.I;
            const E12 = [1, 1.2, 1.5, 1.8, 2.2, 2.7, 3.3, 3.9, 4.7, 5.6, 6.8, 8.2];
            const dec = 10 ** Math.floor(Math.log10(R));
            const std = [...E12, 10].map((v) => v * dec).find((v) => v >= R - 1e-9);
            const P = drop * x.I;

            return { value: R, sub: `Use ${eng(std, 'Ω')} (E12) → ${num((drop / std) * 1000, 4)} mA`, rows: { e12: eng(std, 'Ω'), P: `${num(P * 1000, 4)} mW`, rating: P < 0.125 ? '⅛ W or more' : P < 0.25 ? '¼ W or more' : P < 0.5 ? '½ W or more' : `${num(Math.ceil(P * 2))} W or more`, Pled: `${num(Vf * x.I * 1000, 4)} mW` }, steps: ['R = (V_s − n V_f) ÷ I', `= (${num(x.Vs)} − ${num(x.n)} × ${num(Vf)}) ÷ ${num(x.I)} = ${num(R)} Ω`, 'Forward voltage is typical for the colour; check the data sheet'] };
        },
    },
    low_pass: filter('low'),
    wires_force: {
        type: 'calc',
        inputs: { I1: ['Current in wire 1', 'current', 'a', 10], I2: ['Current in wire 2', 'current', 'a', 10], d: ['Separation', 'length', 'cm', 1], L: ['Length', 'length', 'm', 1], dir: ['Currents flow', 'select', { same: 'The same way', opposite: 'Opposite ways' }, 'same'] },
        out: 'force',
        outUnit: 'millinewton',
        label: 'Force between the wires',
        rows: { per: 'Force per metre', kind: 'Effect' },
        run: (x) => {
            const F = (K.mu0 * x.I1 * x.I2 * x.L) / (TAU * x.d);

            return { value: F, sub: x.dir === 'same' ? 'Attraction' : 'Repulsion', rows: { per: `${num(F / x.L)} N/m`, kind: x.dir === 'same' ? 'Parallel currents attract' : 'Opposite currents repel' }, steps: ['F = μ₀I₁I₂L ÷ 2πd', `= ${num(F)} N`] };
        },
    },
    wire_force_field: {
        type: 'law',
        vars: { F: ['Force', 'force', 'n', 1], B: ['Magnetic field', 'magnetic_field', 't', 0.5], I: ['Current', 'current', 'a', 4], L: ['Length in the field', 'length', 'm', 0.5], theta: ['Angle between wire and field', 'angle', 'deg', 90] },
        default: 'F',
        eq: 'F = B I L sin θ',
        forms: { F: 'F = BIL sin θ', B: 'B = F ÷ (IL sin θ)', I: 'I = F ÷ (BL sin θ)', L: 'L = F ÷ (BI sin θ)', theta: 'θ = asin(F ÷ BIL)' },
        solve: { F: (v) => v.B * v.I * v.L * Math.sin(v.theta), B: (v) => v.F / (v.I * v.L * Math.sin(v.theta)), I: (v) => v.F / (v.B * v.L * Math.sin(v.theta)), L: (v) => v.F / (v.B * v.I * Math.sin(v.theta)), theta: (v) => Math.asin(v.F / (v.B * v.I * v.L)) },
        rows: { dir: 'Direction' },
        extra: () => ({ dir: 'Perpendicular to both the wire and the field (right-hand rule)' }),
    },
    mosfet: {
        type: 'calc',
        inputs: { type: ['Type', 'select', { n: 'n-channel (enhancement)', p: 'p-channel (enhancement), magnitudes' }, 'n'], Vgs: ['Gate–source voltage', 'voltage', 'v', 5], Vds: ['Drain–source voltage', 'voltage', 'v', 10], Vth: ['Threshold voltage', 'voltage', 'v', 2], k: ['Transconductance parameter k (mA/V²)', null, null, 20, 0], lambda: ['Channel-length modulation λ (1/V)', null, null, 0.01, 0] },
        out: 'current',
        outUnit: 'ma',
        label: 'Drain current',
        rows: { region: 'Region', gm: 'Transconductance g_m', rds: 'On-resistance (triode, small V_DS)' },
        run: (x) => {
            const k = x.k / 1000;
            const ov = x.Vgs - x.Vth;
            let Id;
            let region;

            if (ov <= 0) {
                [Id, region] = [0, 'Cut-off (V_GS ≤ V_th)'];
            } else if (x.Vds < ov) {
                [Id, region] = [k * (ov * x.Vds - (x.Vds ** 2) / 2), 'Triode (linear): V_DS < V_GS − V_th'];
            } else {
                [Id, region] = [(k / 2) * ov ** 2 * (1 + x.lambda * x.Vds), 'Saturation: V_DS ≥ V_GS − V_th'];
            }

            return { value: Id, sub: region, rows: { region, gm: ov > 0 ? `${num(k * ov * 1000)} mS` : '0', rds: ov > 0 ? `${num(1 / (k * ov))} Ω` : 'Off' }, steps: ['Square-law model (Shichman–Hodges), k = μC_ox W/L', 'Saturation: I_D = (k/2)(V_GS − V_th)²(1 + λV_DS)', 'Triode: I_D = k[(V_GS − V_th)V_DS − V_DS²/2]', 'Modern short-channel devices deviate: use the data sheet curves for design'] };
        },
    },
    mosfet_vth: {
        type: 'calc',
        inputs: { Na: ['Substrate doping N_A (cm⁻³)', null, null, 1e17, 0], tox: ['Gate oxide thickness', 'length', 'nm', 10], Vfb: ['Flat-band voltage', 'voltage', 'v', -0.9], Vsb: ['Source–body voltage', 'voltage', 'v', 0], T: ['Temperature', 'temperature', 'k', 300] },
        out: 'voltage',
        outUnit: 'v',
        label: 'Threshold voltage (n-channel)',
        rows: { phiF: 'Fermi potential φ_F', Cox: 'Oxide capacitance', gamma: 'Body-effect coefficient γ' },
        run: (x) => {
            const ni = 1e16 * (x.T / 300) ** 1.5 * Math.exp((-1.12 * K.e) / (2 * K.k * x.T) + (1.12 * K.e) / (2 * K.k * 300)) * 0.965;
            const Na = x.Na * 1e6;
            const phiF = VT(x.T) * Math.log(Na / ni);
            const Cox = (3.9 * K.eps0) / x.tox;
            const es = 11.7 * K.eps0;
            const gamma = Math.sqrt(2 * K.e * es * Na) / Cox;
            const Vth = x.Vfb + 2 * phiF + gamma * Math.sqrt(2 * phiF + x.Vsb);

            return { value: Vth, sub: `φ_F = ${num(phiF, 4)} V`, rows: { phiF: `${num(phiF, 4)} V`, Cox: `${num(Cox * 100, 4)} µF/cm²`, gamma: `${num(gamma, 4)} V^½` }, steps: ['V_th = V_FB + 2φ_F + γ√(2φ_F + V_SB)', 'φ_F = (kT/q) ln(N_A/nᵢ), C_ox = ε_ox ÷ t_ox, γ = √(2qε_Si N_A) ÷ C_ox', `nᵢ ≈ ${num(ni / 1e6)} cm⁻³ (silicon)`, `V_th = ${num(Vth)} V`] };
        },
    },
    timer555: {
        type: 'calc',
        inputs: { mode: ['Mode', 'select', { astable: 'Astable (oscillator)', mono: 'Monostable (one pulse)' }, 'astable'], R1: ['R1', 'resistance', 'kohm', 1], R2: ['R2', 'resistance', 'kohm', 10], R: ['R', 'resistance', 'kohm', 100], C: ['Capacitor', 'capacitance', 'uf', 10] },
        show: { R1: 'mode:astable', R2: 'mode:astable', R: 'mode:mono' },
        when: { R1: (x) => x.mode === 'astable', R2: (x) => x.mode === 'astable', R: (x) => x.mode === 'mono' },
        label: 'Frequency',
        rows: { high: 'Time high', low: 'Time low', duty: 'Duty cycle', period: 'Period' },
        plots: [['wave', 'Output waveform']],
        run: (x) => {
            if (x.mode === 'mono') {
                const t = Math.log(3) * x.R * x.C;

                return { value: eng(t, 's'), label: 'Pulse width', sub: 't = 1.1 RC', rows: { high: eng(t, 's'), low: 'Until the next trigger', duty: 'Not periodic', period: 'Not periodic' }, steps: ['t = ln 3 × RC ≈ 1.1RC', `= ${eng(t, 's')}`], plots: { wave: { series: [[0, 0], [0, 1], [t * 1000, 1], [t * 1000, 0], [t * 1500, 0]], axes: true, xLabel: 'Time (ms)', yLabel: 'Output' } } };
            }

            const th = Math.LN2 * (x.R1 + x.R2) * x.C;
            const tl = Math.LN2 * x.R2 * x.C;
            const T = th + tl;
            const series = [];

            for (let k = 0; k < 3; k += 1) {
                series.push([k * T * 1000, 0], [k * T * 1000, 1], [(k * T + th) * 1000, 1], [(k * T + th) * 1000, 0]);
            }

            series.push([3 * T * 1000, 0]);

            return { value: eng(1 / T, 'Hz'), sub: `Duty cycle ${num((th / T) * 100, 4)}%`, rows: { high: eng(th, 's'), low: eng(tl, 's'), duty: `${num((th / T) * 100, 4)}%`, period: eng(T, 's') }, steps: ['t_high = ln 2 (R1 + R2)C, t_low = ln 2 R2 C', 'f = 1 ÷ (ln 2 (R1 + 2R2)C) ≈ 1.44 ÷ ((R1 + 2R2)C)', `f = ${eng(1 / T, 'Hz')}`], plots: { wave: { series, axes: true, xLabel: 'Time (ms)', yLabel: 'Output' } } };
        },
    },
    noise_figure: {
        type: 'calc',
        inputs: { stages: ['Stages in order: gain dB, noise figure dB (one per line)', 'textarea', null, '20, 1.5\n10, 5\n30, 10'] },
        label: 'Cascaded noise figure',
        rows: { T: 'Equivalent noise temperature', G: 'Total gain', first: 'Share from the first stage' },
        run: (x) => {
            const st = String(x.stages).split(/\n|;/).map((l) => l.trim()).filter(Boolean).map((l) => l.split(/[,\s]+/).map(Number));

            if (!st.length || st.some((s) => s.length !== 2 || !s.every(Number.isFinite))) {
                return { empty: 'Type each stage as gain dB, noise figure dB.' };
            }

            let F = 0;
            let G = 1;
            const terms = st.map(([g, nf], k) => {
                const f = 10 ** (nf / 10);
                const term = k === 0 ? f : (f - 1) / G;
                G *= 10 ** (g / 10);

                return term;
            });
            F = terms.reduce((a, b) => a + b, 0);

            return { value: num(10 * Math.log10(F), 4), unit: 'dB', sub: `Noise factor ${num(F, 4)}`, rows: { T: `${num(290 * (F - 1), 4)} K`, G: `${num(10 * Math.log10(G), 4)} dB`, first: `${num((terms[0] / F) * 100, 4)}%` }, steps: ['Friis: F = F₁ + (F₂ − 1)/G₁ + (F₃ − 1)/(G₁G₂) + …', ...terms.map((t, k) => `Stage ${k + 1}: ${num(t)}`), `NF = 10 log₁₀ F = ${num(10 * Math.log10(F))} dB`] };
        },
    },
    ohms_law: vipr('I', 'VR'),
    caps_parallel: listTool({ label: 'Total capacitance', unit: 'F', units: C_UNITS, def: 'uf', sample: '10, 22, 47', combine: (v) => v.reduce((a, b) => a + b, 0), formula: 'C = ΣCᵢ' }),
    resistors_parallel: {
        type: 'calc',
        inputs: { mode: ['Find', 'select', { total: 'The total of several resistors', missing: 'The resistor to add for a target' }, 'total'], list: ['Resistors (comma or line separated; 4.7k, 1M allowed)', 'textarea', null, '100, 220, 470'], unit: ['Plain numbers are in', 'select', R_UNITS, 'ohm'], target: ['Target total', 'resistance', 'ohm', 50] },
        show: { target: 'mode:missing' },
        when: { target: (x) => x.mode === 'missing' },
        label: 'Equivalent resistance',
        rows: { cond: 'Total conductance', note: 'Check' },
        run: (x) => {
            const v = engList(x.list, UNIT_SCALE[x.unit]);

            if (!v) {
                return { empty: 'Enter the resistor values.' };
            }

            const G = v.reduce((a, b) => a + 1 / b, 0);

            if (x.mode === 'missing') {
                const need = 1 / (1 / x.target - G);

                return need > 0 ? { value: eng(need, 'Ω'), label: 'Resistor to add in parallel', sub: `Gives ${eng(x.target, 'Ω')} with the others`, rows: { cond: `${num(1 / x.target)} S`, note: 'Use the nearest standard value and check the result' }, steps: ['1/R_x = 1/R_target − Σ 1/Rᵢ', `R_x = ${eng(need, 'Ω')}`] } : { error: 'The resistors already in parallel are below the target: adding more only lowers it.' };
            }

            return { value: eng(1 / G, 'Ω'), sub: `Smaller than the smallest (${eng(Math.min(...v), 'Ω')})`, rows: { cond: `${num(G)} S`, note: v.length === 2 ? `Product over sum: ${eng((v[0] * v[1]) / (v[0] + v[1]), 'Ω')}` : `${v.length} resistors` }, steps: ['1/R = Σ 1/Rᵢ', `R = ${eng(1 / G, 'Ω')}`] };
        },
    },
    sipm_pde: {
        type: 'calc',
        inputs: { qe: ['Quantum efficiency (%)', null, null, 80, 0], ff: ['Fill factor (%)', null, null, 60, 0], pa: ['Avalanche trigger probability (%)', null, null, 90, 0] },
        label: 'Photon detection efficiency',
        rows: { lost: 'Largest loss' },
        run: (x) => {
            const pde = (x.qe / 100) * (x.ff / 100) * (x.pa / 100);
            const worst = [['quantum efficiency', x.qe], ['fill factor', x.ff], ['avalanche probability', x.pa]].sort((a, b) => a[1] - b[1])[0];

            return { value: `${num(pde * 100, 4)}%`, sub: 'PDE = QE × FF × P_a', rows: { lost: `${worst[0]} (${num(worst[1])}%)` }, steps: [`PDE = ${num(x.qe / 100)} × ${num(x.ff / 100)} × ${num(x.pa / 100)} = ${num(pde)}`] };
        },
    },
    rc_circuit: stepResponse('rc'),
    resistor_colour: {
        type: 'calc',
        inputs: { bands: ['Bands', 'select', { 4: '4 bands', 5: '5 bands', 6: '6 bands' }, '4'], b1: ['Band 1', 'select', DIGITS, 'yellow'], b2: ['Band 2', 'select', DIGITS, 'violet'], b3: ['Band 3 (digit)', 'select', DIGITS, 'black'], mult: ['Multiplier', 'select', MULTS, 'red'], tol: ['Tolerance', 'select', TOLS, 'gold'], tc: ['Temperature coefficient', 'select', TEMPCOS, 'brown'] },
        show: { b3: 'bands:5,6', tc: 'bands:6' },
        label: 'Resistance',
        rows: { range: 'Range with tolerance', tc: 'Temperature coefficient', code: 'Bands read' },
        run: (x) => {
            const five = x.bands !== '4';
            const digits = five ? `${COLOURS[x.b1][0]}${COLOURS[x.b2][0]}${COLOURS[x.b3][0]}` : `${COLOURS[x.b1][0]}${COLOURS[x.b2][0]}`;
            const R = Number(digits) * 10 ** COLOURS[x.mult][1];
            const tol = COLOURS[x.tol][2];

            return { value: eng(R, 'Ω'), sub: `±${num(tol)}%`, rows: { range: `${eng(R * (1 - tol / 100), 'Ω')} to ${eng(R * (1 + tol / 100), 'Ω')}`, tc: x.bands === '6' ? `${COLOURS[x.tc][3]} ppm/K` : 'Only on 6-band resistors', code: [x.b1, x.b2, ...(five ? [x.b3] : []), x.mult, x.tol, ...(x.bands === '6' ? [x.tc] : [])].map((c) => NAMES[c]).join(', ') }, steps: ['IEC 60062: digits, then the multiplier (power of ten), then tolerance', `${digits} × 10^${COLOURS[x.mult][1]} = ${eng(R, 'Ω')}`] };
        },
    },
    resistor_noise: {
        type: 'calc',
        inputs: { R: ['Resistance', 'resistance', 'kohm', 10], T: ['Temperature', 'temperature', 'c', 25], B: ['Bandwidth', 'frequency_hz', 'khz', 20] },
        out: 'voltage',
        outUnit: 'uv',
        label: 'Thermal noise voltage (RMS)',
        rows: { density: 'Noise density', I: 'Noise current', dbv: 'In dBV', P: 'Available noise power' },
        run: (x) => {
            const v = Math.sqrt(4 * K.k * x.T * x.R * x.B);

            return { value: v, sub: `${num((v / Math.sqrt(x.B)) * 1e9, 4)} nV/√Hz`, rows: { density: `${num((v / Math.sqrt(x.B)) * 1e9, 4)} nV/√Hz`, I: eng(v / x.R, 'A'), dbv: `${num(20 * Math.log10(v), 4)} dBV`, P: `${num(10 * Math.log10(K.k * x.T * x.B * 1000), 4)} dBm` }, steps: ['Johnson–Nyquist: v = √(4kTRB)', `= √(4 × 1.380649 × 10⁻²³ × ${num(x.T)} × ${num(x.R)} × ${num(x.B)}) = ${num(v * 1e6)} µV`] };
        },
    },
    resistor_drop: {
        type: 'calc',
        inputs: { Vs: ['Supply voltage', 'voltage', 'v', 12], list: ['Resistors in series, in ohms (k and M allowed)', 'textarea', null, '1k, 2.2k, 4.7k'] },
        label: 'Current',
        rows: { R: 'Total resistance' },
        grids: [['drops', 'Voltage across each resistor']],
        run: (x) => {
            const rs = engList(x.list);

            if (!rs) {
                return { empty: 'Enter the resistor values.' };
            }

            const Rt = rs.reduce((a, b) => a + b, 0);
            const I = x.Vs / Rt;

            return { value: eng(I, 'A'), sub: `${eng(Rt, 'Ω')} in series`, rows: { R: eng(Rt, 'Ω') }, steps: ['I = V ÷ ΣR, then Vᵢ = I Rᵢ', `I = ${num(x.Vs)} ÷ ${num(Rt)} = ${eng(I, 'A')}`], grids: { drops: { columns: ['Voltage', 'Share', 'Power'], rows: rs.map((r) => ({ header: eng(r, 'Ω'), cells: [eng(I * r, 'V'), `${num((r / Rt) * 100, 4)}%`, eng(I * I * r, 'W')] })) } } };
        },
    },
    resistor_wattage: vipr('P', 'IR'),
    resonant_frequency: pw({ vars: { f: ['Resonant frequency', 'frequency_hz', 'khz', 5.03292], L: ['Inductance', 'inductance', 'mh', 10], C: ['Capacitance', 'capacitance', 'nf', 100] }, out: 'f', k: 1 / TAU, exp: { L: -0.5, C: -0.5 }, eq: 'f = 1 ÷ (2π √(L C))', forms: { f: 'f = 1 ÷ 2π√(LC)', L: 'L = 1 ÷ ((2πf)² C)', C: 'C = 1 ÷ ((2πf)² L)' }, rows: { Z0: 'Characteristic impedance √(L/C)' }, extra: (v) => ({ Z0: `${num(Math.sqrt(v.L / v.C))} Ω` }) }),
    rlc_circuit: {
        type: 'calc',
        inputs: { kind: ['Connection', 'select', { series: 'Series RLC', parallel: 'Parallel RLC' }, 'series'], R: ['Resistance', 'resistance', 'ohm', 10], L: ['Inductance', 'inductance', 'mh', 10], C: ['Capacitance', 'capacitance', 'uf', 1] },
        out: 'frequency_hz',
        outUnit: 'hz',
        label: 'Resonant frequency',
        rows: { Q: 'Quality factor Q', bw: 'Bandwidth', zeta: 'Damping ratio ζ', type: 'Step response', fd: 'Damped ringing frequency' },
        run: (x) => {
            const w0 = 1 / Math.sqrt(x.L * x.C);
            const Q = x.kind === 'series' ? (1 / x.R) * Math.sqrt(x.L / x.C) : x.R * Math.sqrt(x.C / x.L);
            const zeta = 1 / (2 * Q);

            return { value: w0 / TAU, sub: `Q = ${num(Q, 4)}, bandwidth ${eng(w0 / TAU / Q, 'Hz')}`, rows: { Q: num(Q, 5), bw: eng(w0 / TAU / Q, 'Hz'), zeta: num(zeta, 4), type: zeta < 1 ? 'Underdamped (rings)' : zeta === 1 ? 'Critically damped' : 'Overdamped', fd: zeta < 1 ? eng((w0 * Math.sqrt(1 - zeta * zeta)) / TAU, 'Hz') : 'No ringing' }, steps: ['ω₀ = 1 ÷ √(LC)', x.kind === 'series' ? 'Q = (1/R)√(L/C)' : 'Q = R√(C/L)', `f₀ = ${eng(w0 / TAU, 'Hz')}, Q = ${num(Q)}, ζ = 1 ÷ 2Q = ${num(zeta)}`] };
        },
    },
    rlc_impedance: {
        type: 'calc',
        inputs: { kind: ['Connection', 'select', { series: 'Series', parallel: 'Parallel' }, 'series'], R: ['Resistance', 'resistance', 'ohm', 50], L: ['Inductance (0 if none)', 'inductance', 'mh', 10], C: ['Capacitance (0 if none)', 'capacitance', 'uf', 10], f: ['Frequency', 'frequency_hz', 'hz', 1000] },
        out: 'resistance',
        outUnit: 'ohm',
        label: 'Impedance magnitude',
        rows: { phase: 'Phase angle', rect: 'Rectangular form', XL: 'Inductive reactance', XC: 'Capacitive reactance', behaves: 'Behaves as' },
        run: (x) => {
            const w = TAU * x.f;
            const XL = w * x.L;
            const XC = x.C > 0 ? 1 / (w * x.C) : Infinity;
            let re;
            let im;

            if (x.kind === 'series') {
                [re, im] = [x.R, XL - (Number.isFinite(XC) ? XC : 0)];
            } else {
                const g = 1 / x.R;
                const b = (Number.isFinite(XC) ? 1 / XC : 0) - (XL > 0 ? 1 / XL : 0);
                const den = g * g + b * b;
                [re, im] = [g / den, -b / den];
            }

            return { value: Math.hypot(re, im), sub: `Phase ${num(Math.atan2(im, re) / D, 4)}°`, rows: { phase: `${num(Math.atan2(im, re) / D, 4)}°`, rect: `${num(re)} ${im >= 0 ? '+' : '−'} j${num(Math.abs(im))} Ω`, XL: `${num(XL)} Ω`, XC: Number.isFinite(XC) ? `${num(XC)} Ω` : 'No capacitor', behaves: Math.abs(im) < 1e-9 * Math.hypot(re, im) ? 'Resistive (at resonance)' : im > 0 ? 'Inductive' : 'Capacitive' }, steps: [x.kind === 'series' ? 'Z = R + j(X_L − X_C)' : '1/Z = 1/R + j(1/X_C − 1/X_L)', `|Z| = ${num(Math.hypot(re, im))} Ω`] };
        },
    },
    rms: {
        type: 'calc',
        inputs: { wave: ['Waveform', 'select', { sine: 'Sine', square: 'Square', triangle: 'Triangle', sawtooth: 'Sawtooth', half: 'Half-wave rectified sine', full: 'Full-wave rectified sine' }, 'sine'], given: ['Value given as', 'select', { peak: 'Peak', pp: 'Peak to peak' }, 'peak'], V: ['Voltage', 'voltage', 'v', 325] },
        out: 'voltage',
        outUnit: 'v',
        label: 'RMS voltage',
        rows: { avg: ['Average (rectified)', 'voltage'], crest: 'Crest factor', form: 'Form factor' },
        run: (x) => {
            const [rmsF, avgF] = { sine: [Math.SQRT1_2, 2 / Math.PI], square: [1, 1], triangle: [1 / SQ3, 0.5], sawtooth: [1 / SQ3, 0.5], half: [0.5, 1 / Math.PI], full: [Math.SQRT1_2, 2 / Math.PI] }[x.wave];
            const pk = x.given === 'pp' ? (['half', 'full'].includes(x.wave) ? x.V : x.V / 2) : x.V;

            return { value: pk * rmsF, sub: `V_peak = ${num(pk)} V`, rows: { avg: [pk * avgF, 'voltage'], crest: num(1 / rmsF, 5), form: num(rmsF / avgF, 5) }, steps: [`V_rms = V_peak × ${num(rmsF, 6)}`, `= ${num(pk)} × ${num(rmsF)} = ${num(pk * rmsF)} V`] };
        },
    },
    resistors_series: listTool({ label: 'Total resistance', unit: 'Ω', units: R_UNITS, def: 'ohm', sample: '100, 220, 4.7k', combine: (v) => v.reduce((a, b) => a + b, 0), formula: 'R = ΣRᵢ' }),
    shockley: {
        type: 'calc',
        inputs: { Is: ['Saturation current', 'current', 'na', 0.001], n: ['Ideality factor', null, null, 1, 1], T: ['Temperature', 'temperature', 'c', 25], V: ['Forward voltage', 'voltage', 'v', 0.6] },
        out: 'current',
        outUnit: 'ma',
        label: 'Diode current',
        rows: { VT: 'Thermal voltage kT/q', rd: 'Small-signal resistance', decade: 'Voltage per decade of current' },
        plots: [['iv', 'Current–voltage curve']],
        run: (x) => {
            const vt = VT(x.T);
            const I = x.Is * Math.expm1(x.V / (x.n * vt));
            const series = Array.from({ length: 81 }, (_, k) => {
                const v = (x.V * 1.15 * k) / 80;

                return [v, x.Is * Math.expm1(v / (x.n * vt)) * 1000];
            });

            return { value: I, sub: `V_T = ${num(vt * 1000, 4)} mV`, rows: { VT: `${num(vt * 1000, 4)} mV`, rd: I > 0 ? eng((x.n * vt) / (I + x.Is), 'Ω') : '∞', decade: `${num(x.n * vt * Math.LN10 * 1000, 4)} mV` }, steps: ['I = I_s(e^(V/nV_T) − 1), V_T = kT/q', `= ${num(I)} A`, 'Series resistance is ignored, so very high currents are overestimated'], plots: { iv: { series, axes: true, xLabel: 'Voltage (V)', yLabel: 'Current (mA)' } } };
        },
    },
    solenoid_inductance: {
        type: 'calc',
        inputs: { N: ['Turns', null, null, 100, 1], l: ['Coil length', 'length', 'cm', 5], d: ['Coil diameter (to the wire centre)', 'length', 'cm', 2], mur: ['Core relative permeability (1 for air)', null, null, 1, 0] },
        out: 'inductance',
        outUnit: 'uh',
        label: 'Inductance',
        rows: { ideal: ['Long-solenoid formula (no correction)', 'inductance'], K: 'Nagaoka coefficient', wheeler: ['Wheeler’s approximation', 'inductance'] },
        run: (x) => {
            const A = (Math.PI * x.d * x.d) / 4;
            const k2 = (x.d * x.d) / (x.d * x.d + x.l * x.l);
            const kp = Math.sqrt(1 - k2);
            const Kk = ellipticK(k2);
            const Ek = ellipticE(k2);
            const Kn = (4 / (3 * Math.PI * kp)) * ((kp * kp / k2) * (Kk - Ek) + Ek - Math.sqrt(k2));
            const ideal = (K.mu0 * x.mur * x.N * x.N * A) / x.l;
            const dIn = x.d / 0.0254;
            const lIn = x.l / 0.0254;
            const wheeler = ((dIn * dIn * x.N * x.N) / (18 * dIn + 40 * lIn)) * 1e-6 * x.mur;

            return { value: ideal * Kn, sub: `Nagaoka K = ${num(Kn, 5)}`, rows: { ideal: [ideal, 'inductance'], K: num(Kn, 6), wheeler: [wheeler, 'inductance'] }, steps: ['L = K μ₀μ_r N² A ÷ l (current sheet, exact Nagaoka coefficient from elliptic integrals)', `K = ${num(Kn)}, L = ${eng(ideal * Kn, 'H')}`, 'A core only multiplies L by μ_r if it fills a closed magnetic path; open rod cores give much less'] };
        },
    },
    solenoid_field: {
        type: 'calc',
        inputs: { N: ['Turns', null, null, 500, 1], l: ['Length', 'length', 'cm', 10], I: ['Current', 'current', 'a', 2], mur: ['Core relative permeability (1 for air)', null, null, 1, 0], d: ['Diameter (optional, for the finite-length correction)', 'length', 'cm', 2] },
        optional: ['d'],
        out: 'magnetic_field',
        outUnit: 'mt',
        label: 'Field inside (centre)',
        rows: { ideal: ['Ideal long solenoid μ₀nI', 'magnetic_field'], end: ['At each end (finite solenoid)', 'magnetic_field'], H: 'Field strength H' },
        run: (x) => {
            const n = x.N / x.l;
            const ideal = K.mu0 * x.mur * n * x.I;
            const finite = Number.isFinite(x.d) ? ideal * (x.l / Math.hypot(x.l, x.d)) : ideal;
            const end = Number.isFinite(x.d) ? ideal * 0.5 * (x.l / Math.hypot(x.l, x.d / 2)) : ideal / 2;

            return { value: finite, sub: `n = ${num(n)} turns per metre`, rows: { ideal: [ideal, 'magnetic_field'], end: [end, 'magnetic_field'], H: `${num(n * x.I)} A/m` }, steps: ['Long solenoid: B = μ₀μ_r n I', `= ${num(ideal * 1000)} mT`, 'Finite length (on axis, centre): B = μ₀nI × l ÷ √(l² + d²)'] };
        },
    },
    spherical_capacitor: {
        type: 'calc',
        inputs: { a: ['Inner radius', 'length', 'cm', 5], b: ['Outer radius', 'length', 'cm', 6], er: ['Relative permittivity', null, null, 1, 1] },
        out: 'capacitance',
        outUnit: 'pf',
        label: 'Capacitance',
        rows: { isolated: 'Isolated inner sphere alone' },
        run: (x) => {
            if (!(x.b > x.a)) {
                return { error: 'The outer radius must be larger.' };
            }

            const C = (4 * Math.PI * x.er * K.eps0 * x.a * x.b) / (x.b - x.a);

            return { value: C, sub: 'C = 4πε ab ÷ (b − a)', rows: { isolated: eng(4 * Math.PI * x.er * K.eps0 * x.a, 'F') }, steps: [`C = 4π × ${num(x.er)} × ε₀ × ${num(x.a)} × ${num(x.b)} ÷ ${num(x.b - x.a)} = ${eng(C, 'F')}`] };
        },
    },
    three_phase: {
        type: 'calc',
        inputs: { VL: ['Line voltage', 'voltage', 'v', 400], IL: ['Line current', 'current', 'a', 20], pf: ['Power factor', null, null, 0.85, 0], conn: ['Load connection', 'select', { star: 'Star (wye)', delta: 'Delta' }, 'star'] },
        out: 'power',
        outUnit: 'kw',
        label: 'Real power',
        rows: { S: 'Apparent power', Q: 'Reactive power', Vp: 'Phase voltage', Ip: 'Phase current' },
        run: (x) => {
            const S = SQ3 * x.VL * x.IL;
            const star = x.conn === 'star';

            return { value: S * x.pf, sub: `${num(S / 1000)} kVA`, rows: { S: `${num(S / 1000)} kVA`, Q: `${num((S * Math.sqrt(1 - x.pf ** 2)) / 1000)} kVAR`, Vp: `${num(star ? x.VL / SQ3 : x.VL)} V`, Ip: `${num(star ? x.IL : x.IL / SQ3)} A` }, steps: ['P = √3 V_L I_L PF', `= ${num(S * x.pf)} W`, star ? 'Star: V_phase = V_L ÷ √3, I_phase = I_L' : 'Delta: V_phase = V_L, I_phase = I_L ÷ √3'] };
        },
    },
    transformer_size: {
        type: 'calc',
        inputs: { phase: ['Supply', 'select', { single: 'Single phase', three: 'Three phase' }, 'three'], V: ['Load voltage', 'voltage', 'v', 400], I: ['Load current', 'current', 'a', 100], growth: ['Margin for growth (%)', null, null, 25, 0] },
        label: 'Standard transformer size',
        rows: { load: 'Load', need: 'With margin' },
        run: (x) => {
            const kva = ((x.phase === 'three' ? SQ3 : 1) * x.V * x.I) / 1000;
            const need = kva * (1 + x.growth / 100);
            const size = XFMR[x.phase].find((s) => s >= need);

            return { value: size ? `${size} kVA` : `Above ${XFMR[x.phase].at(-1)} kVA`, sub: `Load ${num(kva, 4)} kVA, ${num(need, 4)} kVA with margin`, rows: { load: `${num(kva, 4)} kVA`, need: `${num(need, 4)} kVA` }, steps: [x.phase === 'three' ? 'S = √3 V I' : 'S = V I', `= ${num(kva)} kVA × ${num(1 + x.growth / 100)} = ${num(need)} kVA`, 'Next standard rating (ANSI/IEEE C57.12); check harmonics and motor starting'] };
        },
    },
    transistor_bias: {
        type: 'calc',
        inputs: { type: ['Bias', 'select', { divider: 'Voltage divider', fixed: 'Fixed base resistor' }, 'divider'], Vcc: ['Supply V_CC', 'voltage', 'v', 12], R1: ['R1 (top of divider)', 'resistance', 'kohm', 47], R2: ['R2 (bottom of divider)', 'resistance', 'kohm', 10], Rb: ['Base resistor R_B', 'resistance', 'kohm', 470], Rc: ['Collector resistor R_C', 'resistance', 'kohm', 2.2], Re: ['Emitter resistor R_E', 'resistance', 'ohm', 470], beta: ['Current gain β', null, null, 150, 1], Vbe: ['V_BE', 'voltage', 'v', 0.7] },
        show: { R1: 'type:divider', R2: 'type:divider', Rb: 'type:fixed' },
        when: { R1: (x) => x.type === 'divider', R2: (x) => x.type === 'divider', Rb: (x) => x.type === 'fixed' },
        out: 'current',
        outUnit: 'ma',
        label: 'Collector current I_C',
        rows: { Vce: ['V_CE', 'voltage'], Ib: ['Base current', 'current'], Ve: ['Emitter voltage', 'voltage'], region: 'Operating region' },
        run: (x) => {
            const [Vth, Rth] = x.type === 'divider' ? [(x.Vcc * x.R2) / (x.R1 + x.R2), (x.R1 * x.R2) / (x.R1 + x.R2)] : [x.Vcc, x.Rb];
            const Ib = Math.max(0, (Vth - x.Vbe) / (Rth + (x.beta + 1) * x.Re));
            let Ic = x.beta * Ib;
            let Vce = x.Vcc - Ic * x.Rc - (Ic + Ib) * x.Re;
            let region = Ib === 0 ? 'Cut-off' : 'Active (good for amplifying)';

            if (Vce < 0.2 && Ib > 0) {
                Ic = (x.Vcc - 0.2) / (x.Rc + x.Re);
                Vce = 0.2;
                region = 'Saturated: β is not reached';
            }

            return { value: Ic, sub: `V_CE = ${num(Vce)} V (${region})`, rows: { Vce: [Vce, 'voltage'], Ib: [Ib, 'current'], Ve: [(Ic + Ib) * x.Re, 'voltage'], region }, steps: [x.type === 'divider' ? `Thevenin: V_th = ${num(Vth)} V, R_th = ${eng(Rth, 'Ω')}` : `V_th = V_CC, R_th = R_B`, 'I_B = (V_th − V_BE) ÷ (R_th + (β + 1)R_E)', `I_C = β I_B = ${eng(Ic, 'A')}`, 'V_CE = V_CC − I_C R_C − I_E R_E'] };
        },
    },
    voltage_divider: {
        type: 'law',
        vars: { Vout: ['Output voltage', 'voltage', 'v', 3.3], Vin: ['Input voltage', 'voltage', 'v', 5], R1: ['R1 (top)', 'resistance', 'kohm', 1.7], R2: ['R2 (bottom)', 'resistance', 'kohm', 3.3] },
        default: 'Vout',
        eq: 'V_out = V_in R₂ ÷ (R₁ + R₂)',
        forms: { Vout: 'V_out = V_in R₂ ÷ (R₁ + R₂)', Vin: 'V_in = V_out (R₁ + R₂) ÷ R₂', R1: 'R₁ = R₂(V_in − V_out) ÷ V_out', R2: 'R₂ = R₁V_out ÷ (V_in − V_out)' },
        solve: { Vout: (v) => (v.Vin * v.R2) / (v.R1 + v.R2), Vin: (v) => (v.Vout * (v.R1 + v.R2)) / v.R2, R1: (v) => (v.R2 * (v.Vin - v.Vout)) / v.Vout, R2: (v) => (v.R1 * v.Vout) / (v.Vin - v.Vout) },
        rows: { I: 'Divider current', ratio: 'Ratio' },
        extra: (v) => ({ I: eng(v.Vin / (v.R1 + v.R2), 'A'), ratio: num(v.R2 / (v.R1 + v.R2), 5) }),
        check: (v, unknown) => (['R1', 'R2'].includes(unknown) && !(v.Vout < v.Vin) ? 'The output must be below the input.' : null),
    },
    voltage_regulation: pw({ vars: { VR: ['Voltage regulation (fraction)', null, null, 0.05], Vnl: ['No-load voltage', 'voltage', 'v', 12.6], Vfl: ['Full-load voltage', 'voltage', 'v', 12] }, out: 'VR', exp: { Vnl: 1, Vfl: -1 }, k: 1, eq: 'VR = (V_nl − V_fl) ÷ V_fl', forms: { VR: 'VR = (V_nl − V_fl) ÷ V_fl', Vnl: 'V_nl = V_fl(1 + VR)', Vfl: 'V_fl = V_nl ÷ (1 + VR)' }, solve: { VR: (v) => (v.Vnl - v.Vfl) / v.Vfl, Vnl: (v) => v.Vfl * (1 + v.VR), Vfl: (v) => v.Vnl / (1 + v.VR) }, rows: { pct: 'As a percentage' }, extra: (v) => ({ pct: `${num(v.VR * 100, 4)}%` }) }),
    wheatstone: {
        type: 'calc',
        inputs: { mode: ['Find', 'select', { balance: 'The unknown resistor at balance', output: 'The output voltage for a given Rx' }, 'balance'], R1: ['R1', 'resistance', 'ohm', 100], R2: ['R2', 'resistance', 'ohm', 200], R3: ['R3', 'resistance', 'ohm', 150], Rx: ['Rx', 'resistance', 'ohm', 310], Vs: ['Excitation voltage', 'voltage', 'v', 5] },
        show: { Rx: 'mode:output', Vs: 'mode:output' },
        when: { Rx: (x) => x.mode === 'output', Vs: (x) => x.mode === 'output' },
        label: 'Result',
        rows: { ratio: 'Bridge ratio R2/R1', note: 'Arrangement' },
        run: (x) => {
            const note = 'R1 and R2 form one arm (R1 top), R3 and Rx the other (R3 top); output between the midpoints';

            if (x.mode === 'balance') {
                const Rx = (x.R2 * x.R3) / x.R1;

                return { value: eng(Rx, 'Ω'), label: 'Unknown resistance at balance', sub: 'Rx = R2 R3 ÷ R1', rows: { ratio: num(x.R2 / x.R1), note }, steps: ['Balance: R1/R2 = R3/Rx', `Rx = ${num(x.R2)} × ${num(x.R3)} ÷ ${num(x.R1)} = ${num(Rx)} Ω`] };
            }

            const Vo = x.Vs * (x.Rx / (x.R3 + x.Rx) - x.R2 / (x.R1 + x.R2));

            return { value: eng(Vo, 'V'), label: 'Bridge output voltage', sub: Math.abs(Vo) < 1e-12 ? 'Balanced' : 'Unbalanced', rows: { ratio: num(x.R2 / x.R1), note }, steps: ['V_out = V_s (Rx ÷ (R3 + Rx) − R2 ÷ (R1 + R2))', `= ${eng(Vo, 'V')}`] };
        },
    },
    wire_gauge: {
        type: 'calc',
        inputs: { system: ['Gauge system', 'select', { awg: 'AWG (American)', swg: 'SWG (British Imperial)', metric: 'Metric (mm²)' }, 'awg'], awg: ['AWG size', 'select', AWG_SIZES, '12'], swg: ['SWG size', 'select', Object.fromEntries(Object.keys(SWG).map((k) => [k, k])), '14'], mm2: ['Metric size', 'select', Object.fromEntries(METRIC.map((v) => [String(v), `${v} mm²`])), '2.5'] },
        show: { awg: 'system:awg', swg: 'system:swg', mm2: 'system:metric' },
        out: 'length',
        outUnit: 'mm',
        label: 'Diameter (solid conductor)',
        rows: { area: 'Cross-section area', kcmil: 'In kcmil', R: 'Copper resistance at 20 °C', nearest: 'Nearest AWG' },
        run: (x) => {
            const d = x.system === 'awg' ? awgD(Number(x.awg)) : x.system === 'swg' ? SWG[x.swg] * 0.0254 : Math.sqrt((4 * Number(x.mm2) * 1e-6) / Math.PI);
            const A = (Math.PI * d * d) / 4;
            const awg = 36 - 39 * Math.log(d / 0.127e-3) / Math.log(92);

            return { value: d, sub: `${num(A * 1e6, 4)} mm²`, rows: { area: `${num(A * 1e6, 4)} mm²`, kcmil: `${num(A / 5.067075e-10 / 1000, 4)} kcmil`, R: `${num((1.7241e-8 / A) * 1000, 4)} Ω/km (${num((1.7241e-8 / A) * 304.8, 4)} Ω per 1,000 ft)`, nearest: `${Math.round(awg) < 0 ? `${'0'.repeat(1 - Math.round(awg))}` : Math.round(awg)} (exact ${num(awg, 3)})` }, steps: [x.system === 'awg' ? 'AWG n: d = 0.127 mm × 92^((36 − n)/39) (ASTM B258)' : x.system === 'swg' ? 'SWG diameters from the 1883 Imperial Standard Wire Gauge table' : 'd = √(4A ÷ π)', `d = ${num(d * 1000)} mm, A = ${num(A * 1e6)} mm²`] };
        },
    },
    wire_resistance: {
        type: 'calc',
        inputs: { mat: ['Conductor', 'select', 'data:conductors', 'copper'], rho: ['Resistivity', 'resistivity', 'ohmm', 1.72e-8], alpha: ['Temperature coefficient (1/K)', null, null, 0.00393], size: ['Size given as', 'select', { awg: 'AWG', dia: 'Diameter', area: 'Area' }, 'area'], awg: ['AWG', 'select', AWG_SIZES, '12'], d: ['Diameter', 'length', 'mm', 1.5], A: ['Area', 'area', 'mm2', 2.5], L: ['Length', 'length', 'm', 50], T: ['Temperature', 'temperature', 'c', 20] },
        show: { rho: 'mat:custom', alpha: 'mat:custom', awg: 'size:awg', d: 'size:dia', A: 'size:area' },
        when: { rho: (x) => x.mat === 'custom', alpha: (x) => x.mat === 'custom', d: (x) => x.size === 'dia', A: (x) => x.size === 'area' },
        data: ['conductors'],
        out: 'resistance',
        outUnit: 'ohm',
        label: 'Resistance',
        rows: { at20: 'At 20 °C', loop: 'Round trip (two conductors)', perkm: 'Per kilometre' },
        run: (x, ctx) => {
            const m = ctx.c.data.physics.conductors[x.mat];
            const rho = x.mat === 'custom' ? x.rho : m.rho;
            const alpha = x.mat === 'custom' ? x.alpha : m.alpha;
            const A = x.size === 'area' ? x.A : x.size === 'dia' ? (Math.PI * x.d * x.d) / 4 : (Math.PI * awgD(Number(x.awg)) ** 2) / 4;
            const r20 = (rho * x.L) / A;
            const R = r20 * (1 + alpha * (x.T - 293.15));

            return { value: R, sub: `${eng(R / x.L * 1000, 'Ω')} per km`, rows: { at20: eng(r20, 'Ω'), loop: eng(2 * R, 'Ω'), perkm: eng((R / x.L) * 1000, 'Ω') }, steps: ['R = ρL ÷ A × (1 + α(T − 20 °C))', `ρ = ${num(rho)} Ω·m, A = ${num(A * 1e6)} mm²`, `R = ${eng(R, 'Ω')}`] };
        },
    },
    rl_circuit: stepResponse('rl'),
    opamp: {
        type: 'calc',
        inputs: { config: ['Configuration', 'select', { inverting: 'Inverting', noninverting: 'Non-inverting', difference: 'Difference (matched resistors)', summing: 'Inverting summer' }, 'noninverting'], Rf: ['Feedback resistor R_f', 'resistance', 'kohm', 10], Rin: ['Input (or ground) resistor', 'resistance', 'kohm', 1], Vin: ['Input voltage', 'voltage', 'v', 0.1], V2: ['Second input V₂ (difference)', 'voltage', 'v', 0.2], inputs: ['Summer inputs: voltage, resistor in kΩ (one per line)', 'textarea', null, '1, 10\n0.5, 20'], rail: ['Supply rail (±)', 'voltage', 'v', 12] },
        show: { Rin: 'config:inverting,noninverting,difference', Vin: 'config:inverting,noninverting,difference', V2: 'config:difference', inputs: 'config:summing' },
        when: { Rin: (x) => x.config !== 'summing', Vin: (x) => x.config !== 'summing', V2: (x) => x.config === 'difference' },
        out: 'voltage',
        outUnit: 'v',
        label: 'Output voltage',
        rows: { gain: 'Gain', db: 'Gain in dB', clip: 'Clipping' },
        run: (x) => {
            let gain;
            let Vo;

            if (x.config === 'summing') {
                const parts = String(x.inputs).split(/\n|;/).map((l) => l.trim()).filter(Boolean).map((l) => l.split(/[,\s]+/).map(Number));

                if (!parts.length || parts.some((p) => p.length !== 2 || !p.every(Number.isFinite))) {
                    return { empty: 'Type each input as voltage, resistor in kΩ.' };
                }

                Vo = -x.Rf * parts.reduce((s, [v, r]) => s + v / (r * 1000), 0);
                gain = parts.map(([, r]) => `−${num(x.Rf / (r * 1000))}`).join(', ');
            } else {
                const g = { inverting: -x.Rf / x.Rin, noninverting: 1 + x.Rf / x.Rin, difference: x.Rf / x.Rin }[x.config];
                Vo = x.config === 'difference' ? g * (x.V2 - x.Vin) : g * x.Vin;
                gain = num(g);
            }

            const clip = Math.abs(Vo) > x.rail;

            return { value: clip ? Math.sign(Vo) * x.rail : Vo, sub: clip ? 'Clipped at the supply rail' : `Gain ${gain}`, rows: { gain, db: x.config === 'summing' ? 'Per input' : `${num(20 * Math.log10(Math.abs(Number(gain))), 4)} dB`, clip: clip ? `Ideal output ${num(Vo)} V exceeds ±${num(x.rail)} V` : 'Within the rails' }, steps: [{ inverting: 'V_out = −(R_f/R_in) V_in', noninverting: 'V_out = (1 + R_f/R_g) V_in', difference: 'V_out = (R_f/R_in)(V₂ − V₁)', summing: 'V_out = −R_f Σ Vᵢ/Rᵢ' }[x.config], `= ${num(Vo)} V (ideal op-amp)`] };
        },
    },
    zener: {
        type: 'calc',
        inputs: { VsMin: ['Minimum supply voltage', 'voltage', 'v', 11], VsMax: ['Maximum supply voltage', 'voltage', 'v', 14], Vz: ['Zener voltage', 'voltage', 'v', 5.1], IL: ['Maximum load current', 'current', 'ma', 20], Izmin: ['Minimum Zener current', 'current', 'ma', 5] },
        out: 'resistance',
        outUnit: 'ohm',
        label: 'Series resistor (maximum)',
        rows: { Pz: 'Zener power (no load, maximum supply)', Pr: 'Resistor power (maximum supply)', rating: 'Suggested Zener rating' },
        run: (x) => {
            if (!(x.VsMin > x.Vz)) {
                return { error: 'The minimum supply must be above the Zener voltage.' };
            }

            const R = (x.VsMin - x.Vz) / (x.IL + x.Izmin);
            const Imax = (x.VsMax - x.Vz) / R;
            const Pz = x.Vz * Imax;

            return { value: R, sub: `Zener must handle ${num(Pz * 1000, 4)} mW with no load`, rows: { Pz: `${num(Pz * 1000, 4)} mW`, Pr: `${num(((x.VsMax - x.Vz) ** 2 / R) * 1000, 4)} mW`, rating: Pz < 0.25 ? '0.5 W' : Pz < 0.6 ? '1 W' : Pz < 2.5 ? '5 W' : 'Use a regulator IC instead' }, steps: ['R = (V_s,min − V_z) ÷ (I_L + I_z,min)', `= ${num(R)} Ω (use the next lower standard value)`, 'P_z = V_z (V_s,max − V_z) ÷ R'] };
        },
    },
    battery_life: {
        type: 'calc',
        inputs: { cap: ['Rated capacity (mAh)', null, null, 2000, 0], H: ['Rated discharge time (h)', null, null, 20, 0], mode: ['Load given as', 'select', { I: 'Current', P: 'Power' }, 'I'], I: ['Load current', 'current', 'ma', 200], P: ['Load power', 'power', 'w', 1], V: ['Battery voltage', 'voltage', 'v', 3.7], k: ['Peukert exponent (1 for lithium, 1.1–1.3 for lead-acid)', null, null, 1.05, 1], usable: ['Usable share (%)', null, null, 90, 0] },
        show: { I: 'mode:I', P: 'mode:P' },
        when: { I: (x) => x.mode === 'I', P: (x) => x.mode === 'P' },
        out: 'time',
        outUnit: 'h',
        label: 'Runtime',
        rows: { simple: 'Simple capacity ÷ current', eff: 'Effective capacity at this load' },
        run: (x) => {
            const I = (x.mode === 'I' ? x.I : x.P / x.V) * 1000;
            const C = x.cap * (x.usable / 100);
            const t = x.H * (C / (I * x.H)) ** x.k;

            return { value: t * 3600, sub: `${num(t, 4)} h (an estimate)`, rows: { simple: `${num(C / I, 4)} h`, eff: `${num(t * I, 4)} mAh` }, steps: ['Peukert: t = H (C ÷ (I H))^k', `= ${num(x.H)} × (${num(C)} ÷ (${num(I)} × ${num(x.H)}))^${num(x.k)} = ${num(t)} h`, 'Temperature, age and cut-off voltage also matter'] };
        },
    },
    capacitor_code: {
        type: 'calc',
        inputs: { code: ['Marking (e.g. 104, 472J, 4n7, 2.2u)', 'text', null, '104K'] },
        out: 'capacitance',
        outUnit: 'nf',
        label: 'Capacitance',
        rows: { pf: 'In pF', uf: 'In µF', tol: 'Tolerance' },
        run: (x) => {
            const s = String(x.code).trim().replace(/\s+/g, '');
            const tolMap = { B: '±0.1 pF', C: '±0.25 pF', D: '±0.5 pF', F: '±1%', G: '±2%', J: '±5%', K: '±10%', M: '±20%', Z: '+80% / −20%' };
            const tolLetter = /[BCDFGJKMZ]$/.test(s) && s.length > 1 ? s.at(-1) : '';
            const body = tolLetter ? s.slice(0, -1) : s;
            let pF;

            if (/^\d{3}$/.test(body)) {
                const exp = Number(body[2]);
                pF = Number(body.slice(0, 2)) * (exp === 8 ? 0.01 : exp === 9 ? 0.1 : 10 ** exp);
            } else if (/^\d{1,2}$/.test(body)) {
                pF = Number(body);
            } else {
                const m = body.match(/^(\d*)(?:\.(\d+))?([pnuµ])(\d*)$/i);

                if (!m || (m[2] && m[4])) {
                    return { error: 'Use a 3-digit code such as 104, or a value such as 4n7 or 2.2u.' };
                }

                pF = Number(`${m[1] || '0'}.${m[2] || m[4] || '0'}`) * { p: 1, n: 1e3, u: 1e6, µ: 1e6 }[m[3].toLowerCase()];
            }

            return { value: pF * 1e-12, sub: `${eng(pF * 1e-12, 'F')}${tolLetter ? `, ${tolMap[tolLetter]}` : ''}`, rows: { pf: `${num(pF)} pF`, uf: `${num(pF / 1e6)} µF`, tol: tolLetter ? `${tolLetter}: ${tolMap[tolLetter]}` : 'No tolerance letter' }, steps: ['EIA code: two digits then the number of zeros, in pF (8 → × 0.01, 9 → × 0.1)', 'RKM code: the letter (p, n, µ) marks the decimal point', `= ${num(pF)} pF`] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
