import { defineTools } from '../engines/formula.js';
import { D, handlersFor, K, num, pw } from '../physics/core.js';
import { eng, engList, vipr } from '../physics/circuits.js';

/**
 * Electromagnetism: charges, fields, magnetism, AC power and radio links.
 */
const ke = 1 / (4 * Math.PI * K.eps0);
const SQ3 = Math.sqrt(3);
const PARTICLES = { electron: ['Electron', -K.e, K.me], proton: ['Proton', K.e, K.mp], alpha: ['Alpha particle', 2 * K.e, 6.6446573357e-27], deuteron: ['Deuteron', K.e, 3.3435837724e-27], custom: ['Other'] };
const PARTICLE_INPUTS = { particle: ['Particle', 'select', Object.fromEntries(Object.entries(PARTICLES).map(([k, v]) => [k, v[0]])), 'electron'], q: ['Charge', 'charge', 'e', 1], m: ['Mass', 'particle_mass', 'u', 1] };
const PARTICLE_SHOW = { q: 'particle:custom', m: 'particle:custom' };
const PARTICLE_WHEN = { q: (x) => x.particle === 'custom', m: (x) => x.particle === 'custom' };
const qm = (x) => (x.particle === 'custom' ? [x.q, x.m] : PARTICLES[x.particle].slice(1));
const PHASES = { dc: 'DC', single: 'AC single phase', three: 'AC three phase (line-to-line voltage)' };

/** Point charges typed "q in µC, x, y" (metres), one per line. */
function readCharges(text) {
    const rows = String(text ?? '').split(/\n|;/).map((l) => l.trim()).filter(Boolean).map((l) => l.split(/[,\s]+/).map(Number));

    return rows.length && rows.every((r) => r.length === 3 && r.every(Number.isFinite)) ? rows.map(([q, x, y]) => [q * 1e-6, x, y]) : null;
}

export const TOOLS = {
    e_field_accel: {
        type: 'calc',
        inputs: { ...PARTICLE_INPUTS, E: ['Electric field', 'electric_field', 'kvpm', 1] },
        show: PARTICLE_SHOW,
        when: PARTICLE_WHEN,
        out: 'acceleration',
        outUnit: 'ms2',
        label: 'Acceleration',
        rows: { F: ['Force', 'force'], g: 'Compared with gravity', t: 'Time to reach 1% of light speed from rest' },
        run: (x) => {
            const [q, m] = qm(x);
            const a = (Math.abs(q) * x.E) / m;

            return { value: a, sub: `${num(a / K.g0)} g, ${q < 0 ? 'against' : 'along'} the field`, rows: { F: [Math.abs(q) * x.E, 'force'], g: `${num(a / K.g0)} × g`, t: `${num((0.01 * K.c) / a)} s` }, steps: ['a = qE ÷ m', `= ${num(Math.abs(q))} C × ${num(x.E)} V/m ÷ ${num(m)} kg = ${num(a)} m/s²`] };
        },
    },
    ac_wattage: {
        type: 'calc',
        inputs: { phase: ['Supply', 'select', { single: 'Single phase', three: 'Three phase (line-to-line voltage)' }, 'single'], V: ['Voltage', 'voltage', 'v', 230], I: ['Current', 'current', 'a', 10], pf: ['Power factor', null, null, 0.9, 0] },
        out: 'power',
        outUnit: 'kw',
        label: 'Real power',
        rows: { S: 'Apparent power', Q: 'Reactive power', angle: 'Phase angle' },
        run: (x) => {
            const k = x.phase === 'three' ? SQ3 : 1;
            const S = k * x.V * x.I;

            if (!(x.pf >= 0 && x.pf <= 1)) {
                return { error: 'The power factor must be between 0 and 1.' };
            }

            return { value: S * x.pf, sub: `${num(S / 1000)} kVA apparent`, rows: { S: `${num(S / 1000)} kVA`, Q: `${num((S * Math.sqrt(1 - x.pf ** 2)) / 1000)} kVAR`, angle: `${num(Math.acos(x.pf) / D)}°` }, steps: [x.phase === 'three' ? 'P = √3 V_L I_L × PF' : 'P = V I × PF', `= ${num(S * x.pf)} W`] };
        },
    },
    capacitance: {
        type: 'calc',
        inputs: { geom: ['Geometry', 'select', { plates: 'Parallel plates', coax: 'Coaxial cylinders (cable)', spheres: 'Concentric spheres', sphere: 'Isolated sphere' }, 'plates'], A: ['Plate area', 'area', 'cm2', 100], d: ['Gap', 'length', 'mm', 1], a: ['Inner radius', 'length', 'mm', 0.5], b: ['Outer radius', 'length', 'mm', 1.75], L: ['Length', 'length', 'm', 1], diel: ['Dielectric', 'select', 'data:dielectrics', 'air'], er: ['Relative permittivity', null, null, 4, 1] },
        show: { A: 'geom:plates', d: 'geom:plates', a: 'geom:coax,spheres,sphere', b: 'geom:coax,spheres', L: 'geom:coax', er: 'diel:custom' },
        when: { A: (x) => x.geom === 'plates', d: (x) => x.geom === 'plates', a: (x) => x.geom !== 'plates', b: (x) => ['coax', 'spheres'].includes(x.geom), L: (x) => x.geom === 'coax', er: (x) => x.diel === 'custom' },
        data: ['dielectrics'],
        out: 'capacitance',
        outUnit: 'pf',
        label: 'Capacitance',
        rows: { er: 'Relative permittivity used', perm: 'Per metre (cable)' },
        run: (x, ctx) => {
            const er = x.diel === 'custom' ? x.er : ctx.c.data.physics.dielectrics[x.diel].er;
            const e = er * K.eps0;
            let C;

            if (['coax', 'spheres'].includes(x.geom) && !(x.b > x.a)) {
                return { error: 'The outer radius must be larger than the inner one.' };
            }

            if (x.geom === 'plates') {
                C = (e * x.A) / x.d;
            } else if (x.geom === 'coax') {
                C = (2 * Math.PI * e * x.L) / Math.log(x.b / x.a);
            } else if (x.geom === 'spheres') {
                C = (4 * Math.PI * e * x.a * x.b) / (x.b - x.a);
            } else {
                C = 4 * Math.PI * e * x.a;
            }

            const formula = { plates: 'C = ε₀ε_r A ÷ d', coax: 'C = 2πε₀ε_r L ÷ ln(b/a)', spheres: 'C = 4πε₀ε_r ab ÷ (b − a)', sphere: 'C = 4πε₀ε_r a' }[x.geom];

            return { value: C, sub: formula, rows: { er: num(er), perm: x.geom === 'coax' ? `${eng(C / x.L, 'F/m')}` : 'Only for cables' }, steps: [formula, `ε_r = ${num(er)}`, `C = ${eng(C, 'F')}`, 'Fringing fields at the edges are ignored'] };
        },
    },
    capacitive_reactance: pw({ vars: { X: ['Capacitive reactance', 'resistance', 'ohm', 31.831], f: ['Frequency', 'frequency_hz', 'hz', 50], C: ['Capacitance', 'capacitance', 'uf', 100] }, out: 'X', k: 1 / (2 * Math.PI), exp: { f: -1, C: -1 }, eq: 'X_C = 1 ÷ (2π f C)', forms: { X: 'X_C = 1 ÷ 2πfC', f: 'f = 1 ÷ 2πX_C C', C: 'C = 1 ÷ 2πfX_C' }, rows: { I: 'Current at 230 V' }, extra: (v) => ({ I: `${num(230 / v.X)} A` }) }),
    conductivity: {
        type: 'calc',
        inputs: { mode: ['Convert', 'select', { rho: 'Resistivity to conductivity', sigma: 'Conductivity to resistivity', material: 'Look up a material' }, 'rho'], rho: ['Resistivity', 'resistivity', 'ohmm', 1.7241e-8], sigma: ['Conductivity (S/m)', null, null, 5.8e7, 0], mat: ['Material', 'select', 'data:conductors:fixed', 'copper'] },
        show: { rho: 'mode:rho', sigma: 'mode:sigma', mat: 'mode:material' },
        when: { rho: (x) => x.mode === 'rho', sigma: (x) => x.mode === 'sigma' },
        data: ['conductors'],
        label: 'Conductivity',
        rows: { rho: ['Resistivity', 'resistivity'], iacs: 'Compared with annealed copper (% IACS)', ms: 'In MS/m' },
        run: (x, ctx) => {
            const rho = x.mode === 'rho' ? x.rho : x.mode === 'sigma' ? 1 / x.sigma : ctx.c.data.physics.conductors[x.mat].rho;

            return { value: num(1 / rho), unit: 'S/m', sub: `ρ = ${num(rho)} Ω·m`, rows: { rho: [rho, 'resistivity'], iacs: `${num((1.7241e-8 / rho) * 100, 4)}%`, ms: `${num(1 / rho / 1e6)} MS/m` }, steps: ['σ = 1 ÷ ρ', `= 1 ÷ ${num(rho)} = ${num(1 / rho)} S/m`] };
        },
    },
    coulomb: {
        type: 'law',
        vars: { F: ['Force (positive = repulsive)', 'force', 'n', 8.98755], q1: ['Charge 1', 'charge', 'uc', 10], q2: ['Charge 2', 'charge', 'uc', 10], r: ['Distance', 'length', 'cm', 10] },
        default: 'F',
        eq: 'F = k q₁ q₂ ÷ r²',
        forms: { F: 'F = kq₁q₂ ÷ r²', q1: 'q₁ = Fr² ÷ kq₂', q2: 'q₂ = Fr² ÷ kq₁', r: 'r = √(kq₁q₂ ÷ F)' },
        solve: { F: (v) => (ke * v.q1 * v.q2) / v.r ** 2, q1: (v) => (v.F * v.r ** 2) / (ke * v.q2), q2: (v) => (v.F * v.r ** 2) / (ke * v.q1), r: (v) => Math.sqrt((ke * v.q1 * v.q2) / v.F) },
        rows: { kind: 'Interaction', k: 'Coulomb constant k' },
        extra: (v) => ({ kind: v.q1 * v.q2 > 0 ? 'Repulsive (like charges)' : 'Attractive (opposite charges)', k: `${num(ke)} N·m²/C²` }),
        noSolution: 'No solution: for the distance, the force must have the same sign as q₁q₂.',
    },
    cutoff: {
        type: 'calc',
        inputs: { kind: ['Circuit', 'select', { rc: 'RC', rl: 'RL', lc: 'LC (resonance)' }, 'rc'], R: ['Resistance', 'resistance', 'kohm', 1], C: ['Capacitance', 'capacitance', 'nf', 100], L: ['Inductance', 'inductance', 'mh', 10] },
        show: { R: 'kind:rc,rl', C: 'kind:rc,lc', L: 'kind:rl,lc' },
        when: { R: (x) => x.kind !== 'lc', C: (x) => x.kind !== 'rl', L: (x) => x.kind !== 'rc' },
        out: 'frequency_hz',
        outUnit: 'hz',
        label: 'Cutoff frequency',
        rows: { tau: 'Time constant', w: 'Angular frequency' },
        plots: [['bode', 'First-order low-pass response']],
        run: (x) => {
            const fc = x.kind === 'rc' ? 1 / (2 * Math.PI * x.R * x.C) : x.kind === 'rl' ? x.R / (2 * Math.PI * x.L) : 1 / (2 * Math.PI * Math.sqrt(x.L * x.C));
            const series = Array.from({ length: 121 }, (_, k) => {
                const f = fc * 10 ** (-2 + (4 * k) / 120);

                return [Math.log10(f), -10 * Math.log10(1 + (f / fc) ** 2)];
            });

            return { value: fc, sub: x.kind === 'lc' ? 'Resonant frequency' : '−3 dB point', rows: { tau: x.kind === 'lc' ? 'Not used' : eng(x.kind === 'rc' ? x.R * x.C : x.L / x.R, 's'), w: `${num(2 * Math.PI * fc)} rad/s` }, steps: [{ rc: 'f_c = 1 ÷ 2πRC', rl: 'f_c = R ÷ 2πL', lc: 'f₀ = 1 ÷ 2π√(LC)' }[x.kind], `= ${num(fc)} Hz`], plots: x.kind === 'lc' ? {} : { bode: { series, axes: true, xLabel: 'log₁₀ frequency (Hz)', yLabel: 'Gain (dB)' } } };
        },
    },
    cyclotron: {
        type: 'calc',
        inputs: { ...PARTICLE_INPUTS, B: ['Magnetic field', 'magnetic_field', 't', 1], v: ['Speed (optional, for the radius)', 'speed', 'kms', 1000] },
        show: PARTICLE_SHOW,
        when: PARTICLE_WHEN,
        optional: ['v'],
        out: 'frequency_hz',
        outUnit: 'ghz',
        label: 'Cyclotron frequency',
        rows: { w: 'Angular frequency', r: ['Orbit (Larmor) radius', 'length'], T: 'Period' },
        run: (x) => {
            const [q, m] = qm(x);
            const w = (Math.abs(q) * x.B) / m;

            return { value: w / (2 * Math.PI), sub: `ω = ${num(w)} rad/s (non-relativistic)`, rows: { w: `${num(w)} rad/s`, r: Number.isFinite(x.v) ? [x.v / w, 'length'] : 'Enter a speed', T: eng((2 * Math.PI) / w, 's') }, steps: ['f = qB ÷ 2πm', `= ${num(Math.abs(q))} × ${num(x.B)} ÷ (2π × ${num(m)}) = ${num(w / (2 * Math.PI))} Hz`, 'r = mv ÷ qB'] };
        },
    },
    debye: {
        type: 'calc',
        inputs: { kind: ['Medium', 'select', { plasma: 'Plasma', solution: 'Electrolyte solution' }, 'plasma'], Te: ['Electron temperature (eV)', null, null, 10, 0], ne: ['Electron density (per m³)', null, null, 1e18, 0], I: ['Ionic strength (mol/L)', null, null, 0.1, 0], er: ['Relative permittivity of the solvent', null, null, 78.5, 1], T: ['Temperature', 'temperature', 'c', 25] },
        show: { Te: 'kind:plasma', ne: 'kind:plasma', I: 'kind:solution', er: 'kind:solution', T: 'kind:solution' },
        when: { Te: (x) => x.kind === 'plasma', ne: (x) => x.kind === 'plasma', I: (x) => x.kind === 'solution', er: (x) => x.kind === 'solution', T: (x) => x.kind === 'solution' },
        out: 'length',
        outUnit: 'um',
        label: 'Debye length',
        rows: { ND: 'Particles in a Debye sphere', note: 'Meaning' },
        run: (x) => {
            if (x.kind === 'plasma') {
                const kT = x.Te * K.e;
                const L = Math.sqrt((K.eps0 * kT) / (x.ne * K.e * K.e));
                const ND = (4 / 3) * Math.PI * x.ne * L ** 3;

                return { value: L, sub: `${num(ND)} electrons per Debye sphere`, rows: { ND: num(ND), note: ND > 1 ? 'Many particles per sphere: a proper plasma' : 'Fewer than one per sphere: not a collective plasma' }, steps: ['λ_D = √(ε₀kT_e ÷ n_e e²)', `= ${num(L)} m`] };
            }

            const L = Math.sqrt((x.er * K.eps0 * K.k * x.T) / (2 * K.NA * K.e * K.e * x.I * 1000));

            return { value: L, sub: `${num(L * 1e9)} nm`, rows: { ND: 'Not used for solutions', note: 'Charges are screened beyond about this distance' }, steps: ['λ_D = √(ε_rε₀kT ÷ 2N_A e² I)', `= ${num(L * 1e9)} nm (≈ 0.304 ÷ √I nm in water at 25 °C)`] };
        },
    },
    delta_wye: {
        type: 'calc',
        inputs: { dir: ['Convert', 'select', { dy: 'Delta (Δ) to wye (Y)', yd: 'Wye (Y) to delta (Δ)' }, 'dy'], a: ['R_a (Δ: between nodes 2–3; Y: arm at node 1)', 'resistance', 'ohm', 30], b: ['R_b (Δ: between nodes 1–3; Y: arm at node 2)', 'resistance', 'ohm', 60], c: ['R_c (Δ: between nodes 1–2; Y: arm at node 3)', 'resistance', 'ohm', 90] },
        label: 'Equivalent values',
        rows: { r1: 'First', r2: 'Second', r3: 'Third', check: 'Balanced case' },
        run: (x) => {
            if (x.dir === 'dy') {
                const s = x.a + x.b + x.c;
                const [r1, r2, r3] = [(x.b * x.c) / s, (x.a * x.c) / s, (x.a * x.b) / s];

                return { value: `${num(r1)}, ${num(r2)}, ${num(r3)} Ω`, sub: 'Wye arms at nodes 1, 2 and 3', rows: { r1: `R₁ = R_bR_c ÷ ΣR = ${num(r1)} Ω`, r2: `R₂ = R_aR_c ÷ ΣR = ${num(r2)} Ω`, r3: `R₃ = R_aR_b ÷ ΣR = ${num(r3)} Ω`, check: 'Equal deltas give R_Y = R_Δ ÷ 3' }, steps: ['Each wye arm = product of the two adjacent delta resistors ÷ sum of all three'] };
            }

            const p = x.a * x.b + x.b * x.c + x.c * x.a;
            const [ra, rb, rc] = [p / x.a, p / x.b, p / x.c];

            return { value: `${num(ra)}, ${num(rb)}, ${num(rc)} Ω`, sub: 'Delta resistors opposite nodes 1, 2 and 3', rows: { r1: `R_a = ΣR_iR_j ÷ R₁ = ${num(ra)} Ω`, r2: `R_b = ΣR_iR_j ÷ R₂ = ${num(rb)} Ω`, r3: `R_c = ΣR_iR_j ÷ R₃ = ${num(rc)} Ω`, check: 'Equal wyes give R_Δ = 3R_Y' }, steps: ['Each delta resistor = (sum of the pairwise products of the wye arms) ÷ the opposite arm'] };
        },
    },
    dipole_moment: {
        type: 'calc',
        inputs: { q: ['Charge magnitude', 'charge', 'e', 1], d: ['Separation', 'length', 'nm', 0.1], E: ['External field (optional, for torque)', 'electric_field', 'mvpm', 1] },
        optional: ['E'],
        label: 'Electric dipole moment',
        rows: { debye: 'In debye', torque: 'Maximum torque in that field', U: 'Energy range in that field' },
        run: (x) => {
            const p = x.q * x.d;

            return { value: num(p), unit: 'C·m', sub: `${num(p / 3.33564e-30, 5)} D`, rows: { debye: `${num(p / 3.33564e-30, 5)} D`, torque: Number.isFinite(x.E) ? `${num(p * x.E)} N·m` : 'Enter a field', U: Number.isFinite(x.E) ? `±${num(p * x.E)} J (−pE aligned, +pE anti-aligned)` : 'Enter a field' }, steps: ['p = q d', `= ${num(x.q)} C × ${num(x.d)} m = ${num(p)} C·m`, '1 debye = 3.33564 × 10⁻³⁰ C·m; water ≈ 1.85 D'] };
        },
    },
    drift_velocity: {
        type: 'calc',
        inputs: { I: ['Current', 'current', 'a', 10], d: ['Wire diameter', 'length', 'mm', 2.5], mat: ['Conductor', 'select', 'data:conductors:fixed', 'copper'] },
        data: ['conductors'],
        out: 'speed',
        outUnit: 'ms',
        label: 'Drift velocity',
        rows: { mmps: 'In mm per second', J: 'Current density', metre: 'Time to drift 1 m' },
        run: (x, ctx) => {
            const n = ctx.c.data.physics.conductors[x.mat].n;

            if (!n) {
                return { error: 'No free-electron density is listed for this material; choose copper, aluminium, silver or gold.' };
            }

            const A = (Math.PI * x.d * x.d) / 4;
            const v = x.I / (n * K.e * A);

            return { value: v, sub: `${num(v * 1000)} mm/s: signals travel near light speed, electrons crawl`, rows: { mmps: `${num(v * 1000)} mm/s`, J: `${num(x.I / A / 1e6)} A/mm²`, metre: `${num(1 / v / 60)} min` }, steps: ['v_d = I ÷ (n e A)', `n = ${num(n)} m⁻³, A = ${num(A * 1e6)} mm²`, `v_d = ${num(v)} m/s`] };
        },
    },
    electrical_power: vipr('P', 'VI'),
    electric_field: {
        type: 'calc',
        inputs: { mode: ['Source', 'select', { point: 'One point charge', many: 'Several point charges' }, 'point'], q: ['Charge', 'charge', 'nc', 10], r: ['Distance', 'length', 'cm', 10], list: ['Charges: q in µC, x, y in metres (one per line)', 'textarea', null, '1, 0, 0\n-1, 0.1, 0'], px: ['Point x (m)', null, null, 0.05], py: ['Point y (m)', null, null, 0.05] },
        show: { q: 'mode:point', r: 'mode:point', list: 'mode:many', px: 'mode:many', py: 'mode:many' },
        when: { q: (x) => x.mode === 'point', r: (x) => x.mode === 'point', px: (x) => x.mode === 'many', py: (x) => x.mode === 'many' },
        out: 'electric_field',
        outUnit: 'vpm',
        label: 'Electric field strength',
        rows: { dir: 'Direction', F: 'Force on a proton there' },
        run: (x) => {
            if (x.mode === 'point') {
                const E = (ke * Math.abs(x.q)) / x.r ** 2;

                return { value: E, sub: x.q >= 0 ? 'Pointing away from the charge' : 'Pointing towards the charge', rows: { dir: x.q >= 0 ? 'Radially outward' : 'Radially inward', F: `${num(E * K.e)} N` }, steps: ['E = kq ÷ r²', `= ${num(ke)} × ${num(x.q)} ÷ ${num(x.r)}² = ${num(E)} V/m`] };
            }

            const qs = readCharges(x.list);

            if (!qs) {
                return { empty: 'Type each charge as q (µC), x, y.' };
            }

            let ex = 0;
            let ey = 0;

            for (const [q, cx, cy] of qs) {
                const dx = x.px - cx;
                const dy = x.py - cy;
                const r = Math.hypot(dx, dy);

                if (r === 0) {
                    return { error: 'The point sits on a charge, where the field is infinite.' };
                }

                ex += (ke * q * dx) / r ** 3;
                ey += (ke * q * dy) / r ** 3;
            }

            const E = Math.hypot(ex, ey);

            return { value: E, sub: `Direction ${num(Math.atan2(ey, ex) / D)}°`, rows: { dir: `${num(Math.atan2(ey, ex) / D)}° from the x-axis; components (${num(ex)}, ${num(ey)}) V/m`, F: `${num(E * K.e)} N` }, steps: ['Superposition: E = Σ kqᵢ r̂ᵢ ÷ rᵢ²', `E = (${num(ex)}, ${num(ey)}) V/m`] };
        },
    },
    motor_torque: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { power: 'Output power', electrical: 'Voltage, current and efficiency' }, 'power'], P: ['Output power', 'power', 'kw', 7.5], V: ['Voltage', 'voltage', 'v', 400], I: ['Current', 'current', 'a', 14], phase: ['Supply', 'select', { dc: 'DC', single: 'Single phase', three: 'Three phase' }, 'three'], pf: ['Power factor', null, null, 0.85, 0], eff: ['Efficiency (%)', null, null, 90, 0], rpm: ['Speed (rpm)', null, null, 1450, 0] },
        show: { P: 'mode:power', V: 'mode:electrical', I: 'mode:electrical', phase: 'mode:electrical', pf: 'mode:electrical', eff: 'mode:electrical' },
        when: { P: (x) => x.mode === 'power', V: (x) => x.mode === 'electrical', I: (x) => x.mode === 'electrical', pf: (x) => x.mode === 'electrical', eff: (x) => x.mode === 'electrical' },
        out: 'torque',
        outUnit: 'nm',
        label: 'Torque',
        rows: { P: ['Mechanical power', 'power'], lbft: ['In lbf·ft', 'torque'] },
        run: (x) => {
            const P = x.mode === 'power' ? x.P : (x.phase === 'three' ? SQ3 : 1) * x.V * x.I * (x.phase === 'dc' ? 1 : x.pf) * (x.eff / 100);
            const T = P / ((x.rpm * 2 * Math.PI) / 60);

            return { value: T, sub: `${num(P / 1000)} kW at ${num(x.rpm)} rpm`, rows: { P: [P, 'power'], lbft: [T, 'torque'] }, steps: ['T = P ÷ ω, ω = 2π × rpm ÷ 60', `= ${num(P)} W ÷ ${num((x.rpm * 2 * Math.PI) / 60)} rad/s = ${num(T)} N·m`] };
        },
    },
    potential: {
        type: 'calc',
        inputs: { list: ['Charges: q in µC, x, y in metres (one per line)', 'textarea', null, '2, 0, 0\n-1, 0.3, 0'], px: ['Point x (m)', null, null, 0.1], py: ['Point y (m)', null, null, 0.1], q0: ['Test charge to bring there (optional)', 'charge', 'uc', 1] },
        optional: ['q0'],
        out: 'voltage',
        outUnit: 'kv',
        label: 'Electric potential',
        rows: { W: 'Work to bring the test charge from infinity', each: 'Contribution of each charge' },
        run: (x) => {
            const qs = readCharges(x.list);

            if (!qs) {
                return { empty: 'Type each charge as q (µC), x, y.' };
            }

            const parts = qs.map(([q, cx, cy]) => (ke * q) / Math.hypot(x.px - cx, x.py - cy));

            if (parts.some((v) => !Number.isFinite(v))) {
                return { error: 'The point sits on a charge.' };
            }

            const V = parts.reduce((a, b) => a + b, 0);

            return { value: V, sub: 'V = Σ kqᵢ ÷ rᵢ (zero at infinity)', rows: { W: Number.isFinite(x.q0) ? `${num(V * x.q0)} J` : 'Enter a test charge', each: parts.map((v) => `${num(v)} V`).join(', ') }, steps: ['V = Σ kqᵢ ÷ rᵢ', `= ${num(V)} V`] };
        },
    },
    field_energy: {
        type: 'calc',
        inputs: { E: ['Electric field', 'electric_field', 'kvpm', 100], B: ['Magnetic field', 'magnetic_field', 't', 1], er: ['Relative permittivity', null, null, 1, 1], mur: ['Relative permeability', null, null, 1, 1], V: ['Volume (optional)', 'volume', 'l', 1] },
        optional: ['V'],
        label: 'Energy density',
        rows: { uE: 'Electric part ½εE²', uB: 'Magnetic part B² ÷ 2μ', total: 'Energy in that volume' },
        run: (x) => {
            const uE = 0.5 * x.er * K.eps0 * x.E ** 2;
            const uB = (x.B ** 2) / (2 * x.mur * K.mu0);

            return { value: num(uE + uB), unit: 'J/m³', sub: 'Magnetic energy usually dominates in machines', rows: { uE: `${num(uE)} J/m³`, uB: `${num(uB)} J/m³`, total: Number.isFinite(x.V) ? `${num((uE + uB) * x.V)} J` : 'Enter a volume' }, steps: ['u = ½εE² + B² ÷ 2μ', `= ${num(uE)} + ${num(uB)} = ${num(uE + uB)} J/m³`] };
        },
    },
    excess_electrons: pw({ vars: { n: ['Number of excess electrons', null, null, 6.24151e12], Q: ['Charge (magnitude)', 'charge', 'uc', 1] }, out: 'n', k: 1 / K.e, exp: { Q: 1 }, eq: 'n = Q ÷ e', forms: { n: 'n = Q ÷ e', Q: 'Q = n e' }, rows: { mass: 'Mass of those electrons' }, extra: (v) => ({ mass: `${num(v.n * K.me)} kg` }) }),
    faraday: {
        type: 'law',
        vars: { emf: ['Induced EMF (magnitude)', 'voltage', 'v', 5], N: ['Turns', null, null, 100], dphi: ['Change in flux per turn (Wb)', null, null, 0.01], t: ['Time', 'time', 's', 0.2] },
        default: 'emf',
        eq: '|ε| = N ΔΦ ÷ Δt',
        forms: { emf: 'ε = NΔΦ ÷ Δt', N: 'N = εΔt ÷ ΔΦ', dphi: 'ΔΦ = εΔt ÷ N', t: 'Δt = NΔΦ ÷ ε' },
        solve: { emf: (v) => (v.N * v.dphi) / v.t, N: (v) => (v.emf * v.t) / v.dphi, dphi: (v) => (v.emf * v.t) / v.N, t: (v) => (v.N * v.dphi) / v.emf },
        rows: { lenz: 'Direction (Lenz’s law)' },
        extra: () => ({ lenz: 'The induced current opposes the change in flux that causes it' }),
    },
    fspl: {
        type: 'calc',
        inputs: { d: ['Distance', 'length', 'km', 1], f: ['Frequency', 'frequency_hz', 'ghz', 2.4], gt: ['Transmit antenna gain (dBi)', null, null, 0], gr: ['Receive antenna gain (dBi)', null, null, 0], pt: ['Transmit power (dBm, optional)', null, null, 20] },
        optional: ['pt'],
        label: 'Free-space path loss',
        rows: { pr: 'Received power', lambda: 'Wavelength', per: 'Extra loss per doubling of distance' },
        run: (x) => {
            const L = 20 * Math.log10((4 * Math.PI * x.d * x.f) / K.c) - x.gt - x.gr;

            return { value: num(L, 5), unit: 'dB', sub: 'Line of sight, no obstacles or fading', rows: { pr: Number.isFinite(x.pt) ? `${num(x.pt - L, 5)} dBm` : 'Enter a transmit power', lambda: `${num((K.c / x.f) * 100)} cm`, per: '6.02 dB' }, steps: ['FSPL = 20 log₁₀(4πdf ÷ c) − G_t − G_r', `= ${num(L)} dB`] };
        },
    },
    bandwidth: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { edges: 'Lower and upper frequencies', q: 'Centre frequency and Q' }, 'edges'], f1: ['Lower frequency', 'frequency_hz', 'mhz', 88], f2: ['Upper frequency', 'frequency_hz', 'mhz', 108], f0: ['Centre frequency', 'frequency_hz', 'mhz', 10.7], Q: ['Quality factor Q', null, null, 50, 0] },
        show: { f1: 'mode:edges', f2: 'mode:edges', f0: 'mode:q', Q: 'mode:q' },
        when: { f1: (x) => x.mode === 'edges', f2: (x) => x.mode === 'edges', f0: (x) => x.mode === 'q', Q: (x) => x.mode === 'q' },
        out: 'frequency_hz',
        outUnit: 'mhz',
        label: 'Bandwidth',
        rows: { centre: 'Centre frequency (geometric)', frac: 'Fractional bandwidth', Q: 'Q factor', octaves: 'Width in octaves' },
        run: (x) => {
            const [lo, hi] = x.mode === 'edges' ? [Math.min(x.f1, x.f2), Math.max(x.f1, x.f2)] : [x.f0 * (Math.sqrt(1 + 1 / (4 * x.Q * x.Q)) - 1 / (2 * x.Q)), x.f0 * (Math.sqrt(1 + 1 / (4 * x.Q * x.Q)) + 1 / (2 * x.Q))];
            const bw = hi - lo;
            const fc = Math.sqrt(lo * hi);

            return { value: bw, sub: `${num(lo)} to ${num(hi)} Hz`, rows: { centre: eng(fc, 'Hz'), frac: `${num((bw / fc) * 100, 4)}%`, Q: num(fc / bw, 4), octaves: num(Math.log2(hi / lo), 4) }, steps: ['BW = f₂ − f₁ = f₀ ÷ Q, f₀ = √(f₁f₂)', `= ${eng(bw, 'Hz')}`] };
        },
    },
    fresnel: {
        type: 'calc',
        inputs: { D: ['Link distance', 'length', 'km', 10], f: ['Frequency', 'frequency_hz', 'ghz', 5.8], d1: ['Obstacle distance from one end', 'length', 'km', 5], n: ['Zone number', null, null, 1, 1] },
        out: 'length',
        outUnit: 'm',
        label: 'Fresnel zone radius at the obstacle',
        rows: { clear: ['60% clearance needed', 'length'], max: ['Largest radius (mid-path)', 'length'], earth: ['Earth bulge there (k = 4/3)', 'length'] },
        run: (x) => {
            if (!(x.d1 > 0 && x.d1 < x.D)) {
                return { error: 'The obstacle must lie between the two ends.' };
            }

            const l = K.c / x.f;
            const d2 = x.D - x.d1;
            const r = Math.sqrt((x.n * l * x.d1 * d2) / x.D);

            return { value: r, sub: `Keep 60% (${num(0.6 * r)} m) clear for a good link`, rows: { clear: [0.6 * r, 'length'], max: [Math.sqrt((x.n * l * x.D) / 4), 'length'], earth: [(x.d1 * d2) / (2 * (4 / 3) * 6371000), 'length'] }, steps: ['r_n = √(nλd₁d₂ ÷ (d₁ + d₂))', `λ = ${num(l * 100)} cm, r = ${num(r)} m`] };
        },
    },
    gauss: {
        type: 'calc',
        inputs: { dist: ['Charge distribution', 'select', { point: 'Point charge (or outside a charged sphere)', line: 'Infinite line', plane: 'Infinite plane', ball: 'Uniformly charged solid sphere' }, 'line'], Q: ['Total charge', 'charge', 'nc', 10], lambda: ['Line charge density (nC/m)', null, null, 10], sigma: ['Surface charge density (nC/m²)', null, null, 10], Rb: ['Sphere radius', 'length', 'cm', 5], r: ['Distance from the centre or line', 'length', 'cm', 10] },
        show: { Q: 'dist:point,ball', lambda: 'dist:line', sigma: 'dist:plane', Rb: 'dist:ball', r: 'dist:point,line,ball' },
        when: { Q: (x) => ['point', 'ball'].includes(x.dist), lambda: (x) => x.dist === 'line', sigma: (x) => x.dist === 'plane', Rb: (x) => x.dist === 'ball', r: (x) => x.dist !== 'plane' },
        out: 'electric_field',
        outUnit: 'vpm',
        label: 'Electric field',
        rows: { surface: 'Gaussian surface used', enclosed: 'Charge enclosed' },
        run: (x) => {
            const e0 = K.eps0;
            let E;
            let surf;
            let enc;

            if (x.dist === 'point') {
                [E, surf, enc] = [x.Q / (4 * Math.PI * e0 * x.r ** 2), 'Sphere of radius r', `${num(x.Q * 1e9)} nC`];
            } else if (x.dist === 'line') {
                [E, surf, enc] = [(x.lambda * 1e-9) / (2 * Math.PI * e0 * x.r), 'Cylinder of radius r around the line', `${num(x.lambda)} nC per metre of length`];
            } else if (x.dist === 'plane') {
                [E, surf, enc] = [(x.sigma * 1e-9) / (2 * e0), 'Pillbox through the plane', `${num(x.sigma)} nC per m² of face`];
            } else {
                const inside = x.r < x.Rb;
                const q = inside ? x.Q * (x.r / x.Rb) ** 3 : x.Q;
                [E, surf, enc] = [q / (4 * Math.PI * e0 * x.r ** 2), `Sphere of radius r (${inside ? 'inside' : 'outside'} the ball)`, `${num(q * 1e9)} nC`];
            }

            return { value: Math.abs(E), sub: '∮E·dA = Q_enc ÷ ε₀', rows: { surface: surf, enclosed: enc }, steps: ['Gauss: flux through a closed surface = enclosed charge ÷ ε₀', `E = ${num(E)} V/m`] };
        },
    },
    hall: {
        type: 'law',
        vars: { RH: ['Hall coefficient (m³/C)', null, null, -7.37e-11], VH: ['Hall voltage', 'voltage', 'uv', -0.737], t: ['Sample thickness (along B)', 'length', 'mm', 1], I: ['Current', 'current', 'a', 10], B: ['Magnetic field', 'magnetic_field', 't', 1] },
        default: 'RH',
        eq: 'R_H = V_H t ÷ (I B)',
        forms: { RH: 'R_H = V_H t ÷ IB', VH: 'V_H = R_H IB ÷ t', t: 't = R_H IB ÷ V_H', I: 'I = V_H t ÷ R_H B', B: 'B = V_H t ÷ R_H I' },
        solve: { RH: (v) => (v.VH * v.t) / (v.I * v.B), VH: (v) => (v.RH * v.I * v.B) / v.t, t: (v) => (v.RH * v.I * v.B) / v.VH, I: (v) => (v.VH * v.t) / (v.RH * v.B), B: (v) => (v.VH * v.t) / (v.RH * v.I) },
        rows: { n: 'Carrier density 1 ÷ |R_H| e', type: 'Majority carriers' },
        extra: (v) => ({ n: `${num(1 / (Math.abs(v.RH) * K.e))} m⁻³`, type: v.RH < 0 ? 'Electrons (n-type)' : 'Holes (p-type)' }),
    },
    hp_amps: {
        type: 'calc',
        inputs: { hp: ['Motor power', 'power', 'hp', 10], V: ['Voltage', 'voltage', 'v', 460], phase: ['Supply', 'select', PHASES, 'three'], eff: ['Efficiency (%)', null, null, 90, 0], pf: ['Power factor', null, null, 0.85, 0] },
        out: 'current',
        outUnit: 'a',
        label: 'Full-load current',
        rows: { input: ['Electrical input power', 'power'], kva: 'Apparent power' },
        run: (x) => {
            const Pin = x.hp / (x.eff / 100);
            const I = x.phase === 'dc' ? Pin / x.V : x.phase === 'single' ? Pin / (x.V * x.pf) : Pin / (SQ3 * x.V * x.pf);

            return { value: I, sub: 'Estimate from power, efficiency and power factor; use nameplate or code tables for wiring', rows: { input: [Pin, 'power'], kva: `${num((x.phase === 'dc' ? Pin : Pin / x.pf) / 1000)} kVA` }, steps: [x.phase === 'three' ? 'I = P ÷ (√3 V η PF)' : x.phase === 'single' ? 'I = P ÷ (V η PF)' : 'I = P ÷ (V η)', `= ${num(I)} A (1 hp = 745.7 W)`] };
        },
    },
    inductive_reactance: pw({ vars: { X: ['Inductive reactance', 'resistance', 'ohm', 31.4159], f: ['Frequency', 'frequency_hz', 'hz', 50], L: ['Inductance', 'inductance', 'mh', 100] }, out: 'X', k: 2 * Math.PI, exp: { f: 1, L: 1 }, eq: 'X_L = 2π f L', forms: { X: 'X_L = 2πfL', f: 'f = X_L ÷ 2πL', L: 'L = X_L ÷ 2πf' } }),
    insertion_loss: {
        type: 'calc',
        inputs: { kind: ['Measured', 'select', { power: 'Power', voltage: 'Voltage (same impedance)', dbm: 'Levels in dBm' }, 'power'], without: ['Without the device', null, null, 10, 0], with: ['With the device', null, null, 8, 0] },
        label: 'Insertion loss',
        rows: { pass: 'Power passed', lost: 'Power lost' },
        run: (x) => {
            const il = x.kind === 'dbm' ? x.without - x.with : (x.kind === 'voltage' ? 20 : 10) * Math.log10(x.without / x.with);
            const pass = 10 ** (-il / 10);

            return { value: num(il, 5), unit: 'dB', sub: il < 0 ? 'Negative: the device adds gain' : `${num(pass * 100, 4)}% of the power passes`, rows: { pass: `${num(pass * 100, 4)}%`, lost: `${num((1 - pass) * 100, 4)}%` }, steps: [x.kind === 'voltage' ? 'IL = 20 log₁₀(V_without ÷ V_with)' : x.kind === 'dbm' ? 'IL = L_without − L_with' : 'IL = 10 log₁₀(P_without ÷ P_with)', `= ${num(il)} dB`] };
        },
    },
    internal_resistance: {
        type: 'calc',
        inputs: { emf: ['EMF (open-circuit voltage)', 'voltage', 'v', 12.6], V: ['Terminal voltage under load', 'voltage', 'v', 12.0], mode: ['Load given as', 'select', { I: 'Current', R: 'Resistance' }, 'I'], I: ['Load current', 'current', 'a', 10], R: ['Load resistance', 'resistance', 'ohm', 1.2] },
        show: { I: 'mode:I', R: 'mode:R' },
        when: { I: (x) => x.mode === 'I', R: (x) => x.mode === 'R' },
        out: 'resistance',
        outUnit: 'mohm',
        label: 'Internal resistance',
        rows: { Isc: ['Short-circuit current', 'current'], Pmax: 'Maximum power into a matched load', lost: 'Power wasted inside' },
        run: (x) => {
            const I = x.mode === 'I' ? x.I : x.V / x.R;
            const r = (x.emf - x.V) / I;

            if (!(r >= 0)) {
                return { error: 'The terminal voltage cannot exceed the EMF under load.' };
            }

            return { value: r, sub: `${num(r * 1000)} mΩ`, rows: { Isc: [x.emf / r, 'current'], Pmax: `${num(x.emf ** 2 / (4 * r))} W`, lost: `${num(I * I * r)} W at this load` }, steps: ['r = (ε − V) ÷ I', `= (${num(x.emf)} − ${num(x.V)}) ÷ ${num(I)} = ${num(r)} Ω`] };
        },
    },
    kva: {
        type: 'calc',
        inputs: { phase: ['Supply', 'select', { single: 'Single phase', three: 'Three phase (line-to-line voltage)' }, 'three'], V: ['Voltage', 'voltage', 'v', 400], I: ['Current', 'current', 'a', 50], pf: ['Power factor (for kW)', null, null, 0.8, 0] },
        label: 'Apparent power',
        rows: { kw: 'Real power', kvar: 'Reactive power' },
        run: (x) => {
            const S = (x.phase === 'three' ? SQ3 : 1) * x.V * x.I;

            return { value: num(S / 1000, 5), unit: 'kVA', sub: `${num((S * x.pf) / 1000)} kW at PF ${num(x.pf)}`, rows: { kw: `${num((S * x.pf) / 1000)} kW`, kvar: `${num((S * Math.sqrt(1 - x.pf ** 2)) / 1000)} kVAR` }, steps: [x.phase === 'three' ? 'S = √3 V_L I_L' : 'S = V I', `= ${num(S)} VA`] };
        },
    },
    lorentz_force: {
        type: 'calc',
        inputs: { q: ['Charge', 'charge', 'e', 1], vx: ['vₓ (m/s)', null, null, 1e5], vy: ['v_y (m/s)', null, null, 0], vz: ['v_z (m/s)', null, null, 0], Ex: ['Eₓ (V/m)', null, null, 0], Ey: ['E_y (V/m)', null, null, 0], Ez: ['E_z (V/m)', null, null, 0], Bx: ['Bₓ (T)', null, null, 0], By: ['B_y (T)', null, null, 0], Bz: ['B_z (T)', null, null, 0.5] },
        out: 'force',
        outUnit: 'n',
        label: 'Lorentz force magnitude',
        rows: { comps: 'Force components (x, y, z)', electric: 'Electric part qE', magnetic: 'Magnetic part q v × B' },
        run: (x) => {
            const cx = x.vy * x.Bz - x.vz * x.By;
            const cy = x.vz * x.Bx - x.vx * x.Bz;
            const cz = x.vx * x.By - x.vy * x.Bx;
            const F = [x.q * (x.Ex + cx), x.q * (x.Ey + cy), x.q * (x.Ez + cz)];

            return { value: Math.hypot(...F), sub: `(${F.map((v) => num(v, 4)).join(', ')}) N`, rows: { comps: `(${F.map((v) => num(v)).join(', ')}) N`, electric: `(${[x.Ex, x.Ey, x.Ez].map((v) => num(x.q * v)).join(', ')}) N`, magnetic: `(${[cx, cy, cz].map((v) => num(x.q * v)).join(', ')}) N` }, steps: ['F = q(E + v × B)', `v × B = (${num(cx)}, ${num(cy)}, ${num(cz)})`, `F = (${F.map((v) => num(v)).join(', ')}) N`] };
        },
    },
    magnetic_moment: {
        type: 'calc',
        inputs: { N: ['Turns', null, null, 100, 1], I: ['Current', 'current', 'a', 2], shape: ['Loop shape', 'select', { circle: 'Circle', rect: 'Rectangle' }, 'circle'], r: ['Loop radius', 'length', 'cm', 5], w: ['Width', 'length', 'cm', 5], h: ['Height', 'length', 'cm', 10], B: ['External field (optional)', 'magnetic_field', 'mt', 50] },
        show: { r: 'shape:circle', w: 'shape:rect', h: 'shape:rect' },
        when: { r: (x) => x.shape === 'circle', w: (x) => x.shape === 'rect', h: (x) => x.shape === 'rect' },
        optional: ['B'],
        label: 'Magnetic dipole moment',
        rows: { torque: 'Maximum torque in that field', centre: 'Field at the centre of a circular coil' },
        run: (x) => {
            const A = x.shape === 'circle' ? Math.PI * x.r * x.r : x.w * x.h;
            const mu = x.N * x.I * A;

            return { value: num(mu), unit: 'A·m²', sub: `Area ${num(A * 1e4)} cm²`, rows: { torque: Number.isFinite(x.B) ? `${num(mu * x.B)} N·m` : 'Enter a field', centre: x.shape === 'circle' ? `${num((K.mu0 * x.N * x.I) / (2 * x.r) * 1000)} mT` : 'Circular coils only' }, steps: ['μ = N I A', `= ${num(x.N)} × ${num(x.I)} × ${num(A)} = ${num(mu)} A·m²`, 'τ = μB sin θ'] };
        },
    },
    wire_field: pw({ vars: { B: ['Magnetic field', 'magnetic_field', 'ut', 20], I: ['Current', 'current', 'a', 10], r: ['Distance from the wire', 'length', 'cm', 10] }, out: 'B', k: K.mu0 / (2 * Math.PI), exp: { I: 1, r: -1 }, eq: 'B = μ₀ I ÷ (2π r)', forms: { B: 'B = μ₀I ÷ 2πr', I: 'I = 2πrB ÷ μ₀', r: 'r = μ₀I ÷ 2πB' }, rows: { earth: 'Compared with Earth’s field (≈ 50 µT)' }, extra: (v) => ({ earth: `${num((v.B / 50e-6) * 100, 4)}%` }) }),
    permeability: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { material: 'The material', mur: 'Relative permeability', BH: 'B and H' }, 'material'], mat: ['Material', 'select', 'data:permeability:fixed', 'ferrite'], mur: ['Relative permeability', null, null, 1000, 0], B: ['Flux density B', 'magnetic_field', 't', 1], H: ['Field strength H (A/m)', null, null, 400, 0] },
        show: { mat: 'mode:material', mur: 'mode:mur', B: 'mode:BH', H: 'mode:BH' },
        when: { mur: (x) => x.mode === 'mur', B: (x) => x.mode === 'BH', H: (x) => x.mode === 'BH' },
        data: ['permeability'],
        label: 'Permeability μ',
        rows: { mur: 'Relative permeability μ_r', chi: 'Magnetic susceptibility χ', kind: 'Type' },
        run: (x, ctx) => {
            const mu = x.mode === 'BH' ? x.B / x.H : (x.mode === 'mur' ? x.mur : ctx.c.data.physics.permeability[x.mat].mur) * K.mu0;
            const mur = mu / K.mu0;

            return { value: num(mu), unit: 'H/m', sub: `μ_r = ${num(mur)}`, rows: { mur: num(mur, 7), chi: num(mur - 1), kind: mur < 1 ? 'Diamagnetic' : mur < 1.01 ? 'Paramagnetic' : 'Ferromagnetic or ferrimagnetic' }, steps: [x.mode === 'BH' ? 'μ = B ÷ H' : 'μ = μ₀μ_r, μ₀ = 1.25663706 × 10⁻⁶ H/m', `= ${num(mu)} H/m`, 'Ferromagnetic values depend on the field and the grade'] };
        },
    },
    power_dissipation: {
        type: 'calc',
        inputs: { list: ['Resistors in ohms (k and M allowed)', 'textarea', null, '100, 220, 470'], wiring: ['Connected in', 'select', { series: 'Series', parallel: 'Parallel' }, 'series'], V: ['Supply voltage', 'voltage', 'v', 12] },
        label: 'Total power',
        rows: { R: 'Equivalent resistance', I: 'Supply current' },
        grids: [['each', 'Power in each resistor']],
        run: (x, ctx) => {
            const rs = engList(x.list);

            if (!rs) {
                return { empty: 'Enter the resistor values.' };
            }

            const series = x.wiring === 'series';
            const Rt = series ? rs.reduce((a, b) => a + b, 0) : 1 / rs.reduce((a, b) => a + 1 / b, 0);
            const I = x.V / Rt;
            const each = rs.map((r) => (series ? [I * r, I, I * I * r] : [x.V, x.V / r, (x.V * x.V) / r]));

            return { value: num(x.V * I), unit: 'W', sub: `${eng(Rt, 'Ω')} total, ${eng(I, 'A')}`, rows: { R: eng(Rt, 'Ω'), I: eng(I, 'A') }, steps: [series ? 'Series: same current, P = I²R' : 'Parallel: same voltage, P = V² ÷ R', `R_total = ${eng(Rt, 'Ω')}`], grids: { each: { columns: ['Voltage', 'Current', 'Power'], rows: rs.map((r, k) => ({ header: eng(r, 'Ω'), cells: [eng(each[k][0], 'V'), eng(each[k][1], 'A'), eng(each[k][2], 'W')] })) } } };
        },
    },
    power_factor: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { PS: 'Real and apparent power', PQ: 'Real and reactive power', angle: 'Phase angle' }, 'PS'], P: ['Real power (kW)', null, null, 8, 0], S: ['Apparent power (kVA)', null, null, 10, 0], Q: ['Reactive power (kVAR)', null, null, 6], phi: ['Phase angle', 'angle', 'deg', 36.87] },
        show: { P: 'mode:PS,PQ', S: 'mode:PS', Q: 'mode:PQ', phi: 'mode:angle' },
        when: { P: (x) => x.mode !== 'angle', S: (x) => x.mode === 'PS', Q: (x) => x.mode === 'PQ', phi: (x) => x.mode === 'angle' },
        label: 'Power factor',
        rows: { angle: 'Phase angle', Q: 'Reactive power per kW', kvar: 'Capacitor kVAR to reach PF 0.95 (per kW)' },
        run: (x) => {
            const pf = x.mode === 'PS' ? x.P / x.S : x.mode === 'PQ' ? x.P / Math.hypot(x.P, x.Q) : Math.cos(x.phi);

            if (!(pf > 0 && pf <= 1)) {
                return { error: 'Real power must be positive and no larger than the apparent power.' };
            }

            const phi = Math.acos(pf);

            return { value: num(pf, 4), sub: `${num(pf * 100, 4)}%`, rows: { angle: `${num(phi / D)}°`, Q: `${num(Math.tan(phi))} kVAR`, kvar: pf >= 0.95 ? 'Already at or above 0.95' : `${num(Math.tan(phi) - Math.tan(Math.acos(0.95)))} kVAR per kW` }, steps: ['PF = P ÷ S = cos φ', `= ${num(pf)}`] };
        },
    },
    skin_depth: {
        type: 'calc',
        inputs: { mat: ['Conductor', 'select', 'data:conductors', 'copper'], rho: ['Resistivity', 'resistivity', 'ohmm', 1.7e-8], mur: ['Relative permeability', null, null, 1, 0], f: ['Frequency', 'frequency_hz', 'mhz', 1] },
        show: { rho: 'mat:custom', mur: 'mat:custom' },
        when: { rho: (x) => x.mat === 'custom', mur: (x) => x.mat === 'custom' },
        data: ['conductors'],
        out: 'length',
        outUnit: 'um',
        label: 'Skin depth',
        rows: { rs: 'Surface resistance', at50: 'At 50 Hz' },
        run: (x, ctx) => {
            const m = ctx.c.data.physics.conductors[x.mat];
            const rho = x.mat === 'custom' ? x.rho : m.rho;
            const mur = x.mat === 'custom' ? x.mur : m.mu;
            const d = (f) => Math.sqrt((2 * rho) / (2 * Math.PI * f * K.mu0 * mur));

            return { value: d(x.f), sub: `Current flows mostly within ${num(d(x.f) * 1e6)} µm of the surface`, rows: { rs: `${num(rho / d(x.f) * 1000)} mΩ per square`, at50: `${num(d(50) * 1000)} mm` }, steps: ['δ = √(2ρ ÷ ωμ)', `= ${num(d(x.f))} m (good conductor)`] };
        },
    },
    volt_ev: {
        type: 'calc',
        inputs: { V: ['Voltage', 'voltage', 'v', 1000], z: ['Charge (in units of e)', null, null, 1] },
        label: 'Energy gained',
        rows: { J: 'In joules', kev: 'In keV' },
        run: (x) => ({ value: num(x.z * x.V), unit: 'eV', sub: `${num(x.z * x.V * K.e)} J`, rows: { J: `${num(x.z * x.V * K.e)} J`, kev: `${num((x.z * x.V) / 1000)} keV` }, steps: ['E = qV; a charge of z e through V volts gains zV electronvolts', `= ${num(x.z)} × ${num(x.V)} eV = ${num(x.z * x.V * K.e)} J`] }),
    },
    vswr: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { z: 'Load and line impedance', gamma: 'Reflection coefficient', rl: 'Return loss' }, 'z'], R: ['Load resistance', 'resistance', 'ohm', 75], X: ['Load reactance', 'resistance', 'ohm', 0], Z0: ['Line impedance', 'resistance', 'ohm', 50], g: ['|Γ|', null, null, 0.2, 0], rl: ['Return loss (dB)', null, null, 14, 0] },
        show: { R: 'mode:z', X: 'mode:z', Z0: 'mode:z', g: 'mode:gamma', rl: 'mode:rl' },
        when: { R: (x) => x.mode === 'z', X: (x) => x.mode === 'z', Z0: (x) => x.mode === 'z', g: (x) => x.mode === 'gamma', rl: (x) => x.mode === 'rl' },
        label: 'VSWR',
        rows: { gamma: 'Reflection coefficient |Γ|', rl: 'Return loss', mismatch: 'Mismatch loss', reflected: 'Reflected power' },
        run: (x) => {
            let g;

            if (x.mode === 'z') {
                const nr = x.R - x.Z0;
                const dr = x.R + x.Z0;
                g = Math.hypot(nr, x.X) / Math.hypot(dr, x.X);
            } else {
                g = x.mode === 'gamma' ? x.g : 10 ** (-x.rl / 20);
            }

            if (!(g < 1)) {
                return { error: '|Γ| must be below 1 (a total reflection gives infinite VSWR).' };
            }

            const s = (1 + g) / (1 - g);

            return { value: `${num(s, 4)} : 1`, sub: `${num(g * g * 100, 4)}% of the power reflected`, rows: { gamma: num(g, 5), rl: g > 0 ? `${num(-20 * Math.log10(g), 4)} dB` : '∞ dB', mismatch: `${num(-10 * Math.log10(1 - g * g), 4)} dB`, reflected: `${num(g * g * 100, 4)}%` }, steps: ['Γ = (Z_L − Z₀) ÷ (Z_L + Z₀)', `|Γ| = ${num(g)}`, `VSWR = (1 + |Γ|) ÷ (1 − |Γ|) = ${num(s)}`] };
        },
    },
    watt: vipr('P', 'VI'),
    watt_hour: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { pt: 'Power and time', mah: 'Battery capacity and voltage' }, 'pt'], P: ['Power', 'power', 'w', 60], t: ['Time', 'time', 'h', 5], mah: ['Capacity (mAh)', null, null, 5000, 0], V: ['Voltage', 'voltage', 'v', 3.7] },
        show: { P: 'mode:pt', t: 'mode:pt', mah: 'mode:mah', V: 'mode:mah' },
        when: { P: (x) => x.mode === 'pt', t: (x) => x.mode === 'pt', mah: (x) => x.mode === 'mah', V: (x) => x.mode === 'mah' },
        out: 'energy',
        outUnit: 'wh',
        label: 'Energy',
        rows: { kwh: 'In kWh', J: 'In joules', flight: 'Airline cabin limit (100 Wh)' },
        run: (x) => {
            const E = x.mode === 'pt' ? x.P * x.t : (x.mah / 1000) * x.V * 3600;

            return { value: E, sub: x.mode === 'pt' ? 'Wh = W × h' : 'Wh = mAh × V ÷ 1000', rows: { kwh: `${num(E / 3.6e6)} kWh`, J: `${num(E)} J`, flight: E / 3600 <= 100 ? 'Within the usual limit' : E / 3600 <= 160 ? 'Needs airline approval (100–160 Wh)' : 'Above 160 Wh: usually not allowed' }, steps: [`E = ${num(E / 3600)} Wh = ${num(E)} J`] };
        },
    },
    watts_amps: {
        type: 'calc',
        inputs: { P: ['Power', 'power', 'w', 2000], V: ['Voltage', 'voltage', 'v', 230], phase: ['Supply', 'select', PHASES, 'single'], pf: ['Power factor', null, null, 1, 0] },
        out: 'current',
        outUnit: 'a',
        label: 'Current',
        rows: { va: 'Apparent power' },
        run: (x) => {
            const I = x.phase === 'dc' ? x.P / x.V : x.phase === 'single' ? x.P / (x.V * x.pf) : x.P / (SQ3 * x.V * x.pf);

            return { value: I, sub: x.phase === 'three' ? 'Line current' : 'Current', rows: { va: `${num(x.phase === 'dc' ? x.P : x.P / x.pf)} VA` }, steps: [x.phase === 'three' ? 'I = P ÷ (√3 V_L PF)' : x.phase === 'single' ? 'I = P ÷ (V PF)' : 'I = P ÷ V', `= ${num(I)} A`] };
        },
    },
    watts_lux: {
        type: 'calc',
        inputs: { W: ['Lamp power', 'power', 'w', 100], lamp: ['Lamp type', 'select', 'data:lamps', 'led'], eff: ['Efficacy (lm/W)', null, null, 100, 0], A: ['Area lit', 'area', 'm2', 20], uf: ['Share of light reaching the area (%)', null, null, 60, 0] },
        show: { eff: 'lamp:custom' },
        when: { eff: (x) => x.lamp === 'custom' },
        data: ['lamps'],
        out: 'illuminance',
        outUnit: 'lx',
        label: 'Average illuminance',
        rows: { lm: 'Light output', fc: ['In foot-candles', 'illuminance'], need: 'Typical needs' },
        run: (x, ctx) => {
            const eff = x.lamp === 'custom' ? x.eff : ctx.c.data.physics.lamps[x.lamp].efficacy;
            const lm = x.W * eff;
            const E = (lm * (x.uf / 100)) / x.A;

            return { value: E, sub: `${num(lm)} lumens at ${num(eff)} lm/W (typical efficacy)`, rows: { lm: `${num(lm)} lm`, fc: [E, 'illuminance'], need: 'Living room 100–300 lx, kitchen and office 300–500 lx, workshop 500–1,000 lx' }, steps: ['Φ = P × efficacy', 'E = Φ × utilisation ÷ area', `= ${num(lm)} × ${num(x.uf / 100)} ÷ ${num(x.A)} = ${num(E)} lx`, 'An estimate: room colours, fittings and lamp quality change it'] };
        },
    },
    magnetic_flux: {
        type: 'law',
        vars: { phi: ['Magnetic flux (Wb)', null, null, 0.0433], B: ['Magnetic field', 'magnetic_field', 't', 0.5], A: ['Area', 'area', 'cm2', 1000], theta: ['Angle between field and normal', 'angle', 'deg', 30] },
        default: 'phi',
        eq: 'Φ = B A cos θ',
        forms: { phi: 'Φ = BA cos θ', B: 'B = Φ ÷ (A cos θ)', A: 'A = Φ ÷ (B cos θ)', theta: 'θ = acos(Φ ÷ BA)' },
        solve: { phi: (v) => v.B * v.A * Math.cos(v.theta), B: (v) => v.phi / (v.A * Math.cos(v.theta)), A: (v) => v.phi / (v.B * Math.cos(v.theta)), theta: (v) => Math.acos(v.phi / (v.B * v.A)) },
        rows: { mwb: 'In milliwebers', maxwell: 'In maxwells' },
        extra: (v) => ({ mwb: `${num(v.phi * 1000)} mWb`, maxwell: `${num(v.phi * 1e8)} Mx` }),
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
