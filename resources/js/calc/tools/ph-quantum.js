import { defineTools } from '../engines/formula.js';
import { D, handlersFor, K, num, pw } from '../physics/core.js';
import { clock, sunPosition, sunTimes } from '../physics/sun.js';

/**
 * Quantum mechanics and home experiments.
 */
const c = K.c;
const h = K.h;
const hbar = K.hbar;
const eV = K.e;
const RY = 13.605693122994;
const MN = 1.00866491595;
const MH = 1.00782503224;
const U_MEV = 931.49410242;
const PARTICLE = { electron: ['Electron', K.me], proton: ['Proton', K.mp], neutron: ['Neutron', K.mn], muon: ['Muon', 1.883531627e-28], custom: ['Other (enter the mass)'] };
const PARTICLE_OPTIONS = Object.fromEntries(Object.entries(PARTICLE).map(([k, v]) => [k, v[0]]));
const massOf = (x) => (x.particle === 'custom' ? x.m : PARTICLE[x.particle][1]);
const SERIES = { 1: 'Lyman (ultraviolet)', 2: 'Balmer (visible)', 3: 'Paschen (infrared)', 4: 'Brackett (infrared)', 5: 'Pfund (infrared)', 6: 'Humphreys (infrared)' };
const BAND = (l) => (l < 1e-11 ? 'Gamma rays' : l < 1e-8 ? 'X-rays' : l < 380e-9 ? 'Ultraviolet' : l < 450e-9 ? 'Violet' : l < 495e-9 ? 'Blue' : l < 570e-9 ? 'Green' : l < 590e-9 ? 'Yellow' : l < 620e-9 ? 'Orange' : l < 750e-9 ? 'Red' : l < 1e-3 ? 'Infrared' : l < 1 ? 'Microwave' : 'Radio');

/** "2026-06-21" → [y, m, d] or null. */
const ymd = (s) => {
    const m = String(s ?? '').match(/^(\d{4})-(\d{2})-(\d{2})$/);

    return m ? [Number(m[1]), Number(m[2]), Number(m[3])] : null;
};
/** "13:45" → hours. */
const hm = (s) => {
    const m = String(s ?? '').match(/^(\d{1,2}):(\d{2})/);

    return m ? Number(m[1]) + Number(m[2]) / 60 : NaN;
};
const PLACE = { lat: ['Latitude (° north, negative for south)', null, null, 28.6139], lon: ['Longitude (° east, negative for west)', null, null, 77.209], tz: ['UTC offset of local time (hours)', null, null, 5.5], date: ['Date', 'date', null, '2026-06-21'] };

export const TOOLS = {
    // Quantum mechanics --------------------------------------------------------------------------
    bohr: {
        type: 'calc',
        inputs: { Z: ['Atomic number Z (hydrogen-like ion)', null, null, 1, 1], n: ['Level n', null, null, 1, 1] },
        out: 'length',
        outUnit: 'nm',
        label: 'Orbit radius',
        rows: { E: 'Energy', v: 'Electron speed', T: 'Orbital period', L: 'Angular momentum' },
        run: (x) => {
            const n = Math.round(x.n);
            const r = (n * n * K.a0) / x.Z;
            const v = (x.Z * K.alpha * c) / n;
            const E = (-RY * x.Z * x.Z) / (n * n);

            return { value: r, sub: `E = ${num(E, 5)} eV`, rows: { E: `${num(E, 6)} eV`, v: `${num(v)} m/s (${num(v / c, 4)} c)`, T: `${num((2 * Math.PI * r) / v)} s`, L: `${n}ħ` }, steps: ['r = n²a₀ ÷ Z, a₀ = 52.918 pm', 'E = −13.6057 eV × Z² ÷ n², v = Zαc ÷ n', `r = ${num(r * 1e12)} pm`, 'The Bohr model gets hydrogen’s energies right but not its orbital shapes'] };
        },
    },
    compton: {
        type: 'calc',
        inputs: { lambda: ['Incident wavelength', 'length', 'nm', 0.0709], theta: ['Scattering angle', 'angle', 'deg', 90] },
        out: 'length',
        outUnit: 'nm',
        label: 'Scattered wavelength',
        rows: { shift: 'Wavelength shift', E1: 'Incident photon energy', E2: 'Scattered photon energy', Ke: 'Electron recoil energy' },
        run: (x) => {
            const lc = h / (K.me * c);
            const dl = lc * (1 - Math.cos(x.theta));
            const l2 = x.lambda + dl;
            const E1 = (h * c) / x.lambda / eV;
            const E2 = (h * c) / l2 / eV;

            return { value: l2, sub: `Shift ${num(dl * 1e12)} pm`, rows: { shift: `${num(dl * 1e12)} pm`, E1: `${num(E1 / 1000)} keV`, E2: `${num(E2 / 1000)} keV`, Ke: `${num((E1 - E2) / 1000)} keV` }, steps: ['λ′ − λ = (h ÷ m_e c)(1 − cos θ), h/m_ec = 2.4263 pm', `= ${num(dl * 1e12)} pm`, `λ′ = ${num(l2 * 1e9)} nm`] };
        },
    },
    compton_wavelength: {
        type: 'calc',
        inputs: { particle: ['Particle', 'select', PARTICLE_OPTIONS, 'electron'], m: ['Mass', 'particle_mass', 'u', 1] },
        show: { m: 'particle:custom' },
        when: { m: (x) => x.particle === 'custom' },
        out: 'length',
        outUnit: 'nm',
        label: 'Compton wavelength',
        rows: { reduced: 'Reduced Compton wavelength ħ/mc', E: 'Rest energy' },
        run: (x) => {
            const m = massOf(x);
            const l = h / (m * c);

            return { value: l, sub: `${num(l * 1e12)} pm`, rows: { reduced: `${num((hbar / (m * c)) * 1e15)} fm`, E: `${num((m * c * c) / eV / 1e6)} MeV` }, steps: ['λ_C = h ÷ mc', `= ${num(l)} m`] };
        },
    },
    curie_constant: {
        type: 'calc',
        inputs: { n: ['Number density of magnetic ions (per m³)', null, null, 1e28, 0], J: ['Total angular momentum J', null, null, 3.5, 0], g: ['Landé g-factor', null, null, 2, 0] },
        label: 'Curie constant',
        rows: { peff: 'Effective moment', molar: 'Molar Curie constant (cgs)' },
        run: (x) => {
            const C = (x.n * K.mu0 * K.muB ** 2 * x.g ** 2 * x.J * (x.J + 1)) / (3 * K.k);
            const p = x.g * Math.sqrt(x.J * (x.J + 1));

            return { value: num(C), unit: 'K', sub: `p_eff = ${num(p, 4)} μ_B`, rows: { peff: `${num(p, 5)} μ_B`, molar: `${num((p * p) / 8, 4)} emu·K/mol (≈ p²/8)` }, steps: ['C = n μ₀ μ_B² g² J(J + 1) ÷ 3k (SI, dimensionless χ)', `= ${num(C)} K`] };
        },
    },
    fermi: {
        type: 'calc',
        inputs: { metal: ['Metal', 'select', 'data:metals', 'cu'], n: ['Electron density (per m³)', null, null, 8.47e28, 0] },
        show: { n: 'metal:custom' },
        when: { n: (x) => x.metal === 'custom' },
        data: ['metals'],
        out: 'particle_energy',
        outUnit: 'ev',
        label: 'Fermi energy',
        rows: { TF: 'Fermi temperature', vF: 'Fermi velocity', kF: 'Fermi wave number' },
        run: (x, ctx) => {
            const n = x.metal === 'custom' ? x.n : ctx.c.data.physics.metals[x.metal].n * 1e28;
            const kF = Math.cbrt(3 * Math.PI ** 2 * n);
            const EF = (hbar * kF) ** 2 / (2 * K.me);

            return { value: EF, sub: `T_F = ${num(EF / K.k)} K`, rows: { TF: `${num(EF / K.k)} K`, vF: `${num((hbar * kF) / K.me)} m/s`, kF: `${num(kF)} m⁻¹` }, steps: ['Free-electron model: E_F = (ħ²/2m)(3π²n)^(2/3)', `n = ${num(n)} m⁻³`, `E_F = ${num(EF / eV)} eV`] };
        },
    },
    light_frequency: pw({ vars: { f: ['Frequency', 'frequency_hz', 'thz', 545.077], lambda: ['Wavelength (vacuum)', 'length', 'nm', 550] }, out: 'f', k: c, exp: { lambda: -1 }, eq: 'f = c ÷ λ', forms: { f: 'f = c ÷ λ', lambda: 'λ = c ÷ f' }, rows: { E: 'Photon energy', band: 'Region of the spectrum' }, extra: (v) => ({ E: `${num((h * v.f) / eV)} eV`, band: BAND(v.lambda) }) }),
    heisenberg: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { x: 'Position uncertainty', p: 'Momentum uncertainty' }, 'x'], dx: ['Position uncertainty Δx', 'length', 'nm', 0.1], dp: ['Momentum uncertainty Δp', 'momentum', 'kgms', 1e-24], particle: ['Particle', 'select', PARTICLE_OPTIONS, 'electron'], m: ['Mass', 'particle_mass', 'u', 1] },
        show: { dx: 'mode:x', dp: 'mode:p', m: 'particle:custom' },
        when: { dx: (x) => x.mode === 'x', dp: (x) => x.mode === 'p', m: (x) => x.particle === 'custom' },
        label: 'Minimum uncertainty',
        rows: { dv: 'Velocity uncertainty', E: 'Kinetic energy scale (Δp)²/2m' },
        run: (x) => {
            const m = massOf(x);
            const other = (hbar / 2) / (x.mode === 'x' ? x.dx : x.dp);
            const dp = x.mode === 'x' ? other : x.dp;

            return { value: num(other), unit: x.mode === 'x' ? 'kg·m/s (Δp)' : 'm (Δx)', sub: 'Δx Δp ≥ ħ/2', rows: { dv: `${num(dp / m)} m/s`, E: `${num((dp * dp) / (2 * m) / eV)} eV` }, steps: ['Δx Δp ≥ ħ/2, ħ = 1.0546 × 10⁻³⁴ J·s', `Minimum ${x.mode === 'x' ? 'Δp' : 'Δx'} = ${num(other)}`] };
        },
    },
    hydrogen_levels: {
        type: 'calc',
        inputs: { n1: ['Lower level', null, null, 2, 1], n2: ['Upper level', null, null, 3, 1], Z: ['Nuclear charge Z', null, null, 1, 1], reduced: ['Nucleus', 'select', { h: 'Hydrogen (reduced-mass correction)', inf: 'Infinitely heavy (R∞)' }, 'h'] },
        out: 'length',
        outUnit: 'nm',
        label: 'Transition wavelength (vacuum)',
        rows: { E1: 'Energy of the lower level', E2: 'Energy of the upper level', dE: 'Photon energy', series: 'Series', band: 'Region' },
        run: (x) => {
            const [a, b] = [Math.min(Math.round(x.n1), Math.round(x.n2)), Math.max(Math.round(x.n1), Math.round(x.n2))];

            if (a === b) {
                return { error: 'Choose two different levels.' };
            }

            const ry = x.reduced === 'h' ? RY / (1 + K.me / K.mp) : RY;
            const E = (n) => (-ry * x.Z * x.Z) / (n * n);
            const dE = E(b) - E(a);
            const l = (h * c) / (dE * eV);

            return { value: l, sub: `${num(dE, 6)} eV photon`, rows: { E1: `${num(E(a), 6)} eV`, E2: `${num(E(b), 6)} eV`, dE: `${num(dE, 6)} eV`, series: SERIES[a] ?? `n = ${a}`, band: BAND(l) }, steps: [`E_n = −${num(ry, 7)} eV × Z² ÷ n²`, `ΔE = ${num(dE)} eV, λ = hc ÷ ΔE = ${num(l * 1e9)} nm`, 'Hα (3 → 2) in air is 656.28 nm; vacuum 656.47 nm'] };
        },
    },
    magnetic_moment_qm: {
        type: 'calc',
        inputs: { mode: ['Method', 'select', { spin: 'Spin only (unpaired electrons)', lsj: 'From L, S and J (Landé g)' }, 'spin'], n: ['Unpaired electrons', null, null, 5, 0], L: ['Orbital L', null, null, 3, 0], S: ['Spin S', null, null, 3.5, 0], J: ['Total J', null, null, 3.5, 0] },
        show: { n: 'mode:spin', L: 'mode:lsj', S: 'mode:lsj', J: 'mode:lsj' },
        when: { n: (x) => x.mode === 'spin', L: (x) => x.mode === 'lsj', S: (x) => x.mode === 'lsj', J: (x) => x.mode === 'lsj' },
        label: 'Effective magnetic moment',
        rows: { g: 'g-factor', si: 'In SI units' },
        run: (x) => {
            if (x.mode === 'spin') {
                const mu = Math.sqrt(x.n * (x.n + 2));

                return { value: num(mu, 5), unit: 'μ_B', sub: 'μ = √(n(n + 2)) μ_B', rows: { g: '2 (spin only)', si: `${num(mu * K.muB)} J/T` }, steps: ['Spin-only: μ = √(n(n + 2)) μ_B', `= ${num(mu)} μ_B`] };
            }

            const J = x.J;
            const g = J > 0 ? 1 + (J * (J + 1) + x.S * (x.S + 1) - x.L * (x.L + 1)) / (2 * J * (J + 1)) : 0;
            const mu = g * Math.sqrt(J * (J + 1));

            return { value: num(mu, 5), unit: 'μ_B', sub: `g_J = ${num(g, 5)}`, rows: { g: num(g, 5), si: `${num(mu * K.muB)} J/T` }, steps: ['g_J = 1 + [J(J+1) + S(S+1) − L(L+1)] ÷ 2J(J+1)', 'μ = g_J √(J(J + 1)) μ_B', `= ${num(mu)} μ_B`] };
        },
    },
    photoelectric: {
        type: 'calc',
        inputs: { lambda: ['Light wavelength', 'length', 'nm', 400], metal: ['Metal', 'select', 'data:work_functions', 'na'], phi: ['Work function (eV)', null, null, 2.3, 0] },
        show: { phi: 'metal:custom' },
        when: { phi: (x) => x.metal === 'custom' },
        data: ['work_functions'],
        out: 'particle_energy',
        outUnit: 'ev',
        label: 'Maximum kinetic energy of the electrons',
        rows: { photon: 'Photon energy', stop: 'Stopping voltage', cut: 'Threshold wavelength', v: 'Fastest electron speed' },
        run: (x, ctx) => {
            const phi = x.metal === 'custom' ? x.phi : ctx.c.data.physics.work_functions[x.metal].phi;
            const E = (h * c) / x.lambda / eV;
            const Kmax = E - phi;
            const cut = (h * c) / (phi * eV);

            if (Kmax <= 0) {
                return { value: 0, sub: `No electrons: photons (${num(E, 4)} eV) are below the work function (${num(phi)} eV)`, rows: { photon: `${num(E, 5)} eV`, stop: '0 V', cut: `${num(cut * 1e9)} nm`, v: 'None emitted' }, steps: ['K_max = hf − φ', `${num(E)} − ${num(phi)} < 0: no emission, however bright the light`] };
            }

            return { value: Kmax * eV, sub: `Stopping voltage ${num(Kmax, 4)} V`, rows: { photon: `${num(E, 5)} eV`, stop: `${num(Kmax, 5)} V`, cut: `${num(cut * 1e9)} nm`, v: `${num(Math.sqrt((2 * Kmax * eV) / K.me))} m/s` }, steps: ['K_max = hf − φ = hc/λ − φ', `= ${num(E)} − ${num(phi)} = ${num(Kmax)} eV`] };
        },
    },
    rydberg: {
        type: 'calc',
        inputs: { n1: ['Lower level n₁', null, null, 2, 1], n2: ['Upper level n₂', null, null, 3, 1], Z: ['Nuclear charge Z', null, null, 1, 1] },
        out: 'length',
        outUnit: 'nm',
        label: 'Wavelength (vacuum)',
        rows: { wn: 'Wavenumber', series: 'Series', limit: 'Series limit' },
        run: (x) => {
            const [a, b] = [Math.round(x.n1), Math.round(x.n2)];

            if (!(b > a)) {
                return { error: 'The upper level must be above the lower one.' };
            }

            const RH = K.Rinf / (1 + K.me / K.mp);
            const inv = RH * x.Z * x.Z * (1 / a ** 2 - 1 / b ** 2);

            return { value: 1 / inv, sub: SERIES[a] ?? `n₁ = ${a}`, rows: { wn: `${num(inv / 100)} cm⁻¹`, series: SERIES[a] ?? `n₁ = ${a}`, limit: `${num((a * a) / (RH * x.Z * x.Z) * 1e9)} nm` }, steps: ['1/λ = R_H Z² (1/n₁² − 1/n₂²), R_H = R∞ ÷ (1 + mₑ/mₚ) = 1.09678 × 10⁷ m⁻¹', `λ = ${num((1 / inv) * 1e9)} nm`] };
        },
    },
    stefan_boltzmann: pw({ vars: { P: ['Radiated power', 'power', 'w', 459.32], eps: ['Emissivity', null, null, 1], A: ['Area', 'area', 'm2', 1], T: ['Temperature', 'temperature', 'k', 300] }, out: 'P', k: K.sigma, exp: { eps: 1, A: 1, T: 4 }, eq: 'P = ε σ A T⁴', forms: { P: 'P = εσAT⁴', eps: 'ε = P ÷ σAT⁴', A: 'A = P ÷ εσT⁴', T: 'T = (P ÷ εσA)^(1/4)' }, rows: { flux: 'Radiant exitance' }, extra: (v) => ({ flux: `${num(v.P / v.A)} W/m²` }) }),
    wien: pw({ vars: { lambda: ['Peak wavelength', 'length', 'nm', 502.04], T: ['Temperature', 'temperature', 'k', 5772] }, out: 'lambda', k: K.wien, exp: { T: -1 }, eq: 'λ_max = b ÷ T', forms: { lambda: 'λ_max = b ÷ T', T: 'T = b ÷ λ_max' }, rows: { band: 'Region', b: 'Wien constant' }, extra: (v) => ({ band: BAND(v.lambda), b: '2.897772 × 10⁻³ m·K' }) }),
    particle_box: {
        type: 'calc',
        inputs: { L: ['Box length', 'length', 'nm', 1], particle: ['Particle', 'select', PARTICLE_OPTIONS, 'electron'], m: ['Mass', 'particle_mass', 'u', 1], n: ['Level n', null, null, 1, 1] },
        show: { m: 'particle:custom' },
        when: { m: (x) => x.particle === 'custom' },
        out: 'particle_energy',
        outUnit: 'ev',
        label: 'Energy of level n',
        rows: { E1: 'Ground state', levels: 'First five levels', gap: 'Photon for n → n − 1 (or 2 → 1)' },
        plots: [['psi', 'Probability density |ψ|² for level n']],
        run: (x) => {
            const m = massOf(x);
            const n = Math.round(x.n);
            const E = (k) => (k * k * h * h) / (8 * m * x.L * x.L);
            const lo = Math.max(1, n - 1);
            const hi = n > 1 ? n : 2;
            const gap = E(hi) - E(lo);
            const series = Array.from({ length: 201 }, (_, k) => {
                const xx = (x.L * k) / 200;

                return [xx * 1e9, (2 / x.L) * Math.sin((n * Math.PI * xx) / x.L) ** 2 * 1e-9];
            });

            return { value: E(n), sub: `${num(E(n) / eV)} eV`, rows: { E1: `${num(E(1) / eV)} eV`, levels: [1, 2, 3, 4, 5].map((k) => `${num(E(k) / eV, 4)}`).join(', ') + ' eV', gap: `${num(gap / eV)} eV, λ = ${num(((h * c) / gap) * 1e9)} nm` }, steps: ['E_n = n²h² ÷ 8mL²', `E₁ = ${num(E(1) / eV)} eV, E_${n} = ${num(E(n) / eV)} eV`], plots: { psi: { series, axes: true, xLabel: 'Position (nm)', yLabel: '|ψ|² (per nm)' } } };
        },
    },
    binding_energy: {
        type: 'calc',
        inputs: { nuc: ['Nuclide', 'select', 'data:nuclides', 'fe56'], Z: ['Protons Z', null, null, 26, 1], A: ['Mass number A', null, null, 56, 1], M: ['Atomic mass (u)', null, null, 55.93493554, 0] },
        show: { Z: 'nuc:custom', A: 'nuc:custom', M: 'nuc:custom' },
        when: { Z: (x) => x.nuc === 'custom', A: (x) => x.nuc === 'custom', M: (x) => x.nuc === 'custom' },
        data: ['nuclides'],
        label: 'Binding energy per nucleon',
        rows: { total: 'Total binding energy', defect: 'Mass defect', compare: 'Compared with iron-56 and nickel-62' },
        run: (x, ctx) => {
            const n = x.nuc === 'custom' ? { Z: x.Z, A: x.A, mass: x.M } : ctx.c.data.physics.nuclides[x.nuc];
            const defect = n.Z * MH + (n.A - n.Z) * MN - n.mass;
            const B = defect * U_MEV;

            if (!(n.A > n.Z)) {
                return { error: 'A nuclide needs at least as many nucleons as protons (A > Z for anything but ¹H).' };
            }

            return { value: num(B / n.A, 6), unit: 'MeV', sub: `Total ${num(B, 6)} MeV`, rows: { total: `${num(B, 7)} MeV`, defect: `${num(defect, 7)} u`, compare: 'Fe-56 8.790 MeV, Ni-62 8.795 MeV (the most tightly bound)' }, steps: ['Δm = Z m(¹H) + N mₙ − m(atom), using neutral-atom masses (AME2020)', `= ${num(n.Z)} × 1.007825 + ${num(n.A - n.Z)} × 1.008665 − ${num(n.mass)} = ${num(defect)} u`, `B = Δm × 931.494 MeV/u = ${num(B)} MeV`] };
        },
    },
    tunneling: {
        type: 'calc',
        inputs: { V0: ['Barrier height', 'particle_energy', 'ev', 10], a: ['Barrier width', 'length', 'nm', 0.5], E: ['Particle energy', 'particle_energy', 'ev', 5], particle: ['Particle', 'select', PARTICLE_OPTIONS, 'electron'], m: ['Mass', 'particle_mass', 'u', 1] },
        show: { m: 'particle:custom' },
        when: { m: (x) => x.particle === 'custom' },
        label: 'Transmission probability',
        rows: { R: 'Reflection probability', kappa: 'Decay constant κ', approx: 'Thick-barrier approximation 16(E/V)(1 − E/V)e^(−2κa)' },
        run: (x) => {
            const m = massOf(x);
            let T;
            let kappa = NaN;

            if (x.E < x.V0) {
                kappa = Math.sqrt(2 * m * (x.V0 - x.E)) / hbar;
                T = 1 / (1 + (x.V0 ** 2 * Math.sinh(kappa * x.a) ** 2) / (4 * x.E * (x.V0 - x.E)));
            } else if (x.E > x.V0) {
                const k2 = Math.sqrt(2 * m * (x.E - x.V0)) / hbar;
                T = 1 / (1 + (x.V0 ** 2 * Math.sin(k2 * x.a) ** 2) / (4 * x.E * (x.E - x.V0)));
            } else {
                T = 1 / (1 + (m * x.a * x.a * x.V0) / (2 * hbar * hbar));
            }

            const r = x.E / x.V0;

            return { value: num(T), sub: x.E < x.V0 ? 'Tunnelling through a classically forbidden barrier' : 'Above the barrier, yet some is still reflected', rows: { R: num(1 - T), kappa: Number.isFinite(kappa) ? `${num(kappa * 1e-9)} nm⁻¹` : 'Not used (E ≥ V₀)', approx: Number.isFinite(kappa) ? num(16 * r * (1 - r) * Math.exp(-2 * kappa * x.a)) : 'Only for E < V₀' }, steps: ['Rectangular barrier (exact): T = 1 ÷ (1 + V₀² sinh²(κa) ÷ 4E(V₀ − E)), κ = √(2m(V₀ − E))/ħ', `T = ${num(T)}`] };
        },
    },

    // Experiments --------------------------------------------------------------------------------
    buoyancy_experiment: {
        type: 'calc',
        inputs: { Wair: ['Scale reading in air', 'mass', 'g', 500], Wwater: ['Scale reading in water', 'mass', 'g', 315], rho: ['Water density', 'density', 'kgm3', 998.2] },
        out: 'density',
        outUnit: 'gcm3',
        label: 'Object density',
        rows: { V: 'Object volume', like: 'Close to' },
        run: (x) => {
            const loss = x.Wair - x.Wwater;

            if (!(loss > 0)) {
                return { error: 'The reading in water must be lower than in air.' };
            }

            const rho = (x.rho * x.Wair) / loss;
            const list = [['aluminium', 2.70], ['glass', 2.5], ['granite', 2.7], ['iron or steel', 7.85], ['copper', 8.96], ['brass', 8.5], ['lead', 11.34], ['silver', 10.49], ['gold', 19.32], ['concrete', 2.4]];
            const like = list.reduce((a, b) => (Math.abs(b[1] - rho / 1000) < Math.abs(a[1] - rho / 1000) ? b : a));

            return { value: rho, sub: `Volume ${num((loss / x.rho) * 1e6)} cm³`, rows: { V: `${num((loss / x.rho) * 1e6)} cm³`, like: `${like[0]} (${like[1]} g/cm³)` }, steps: ['Archimedes: apparent loss of weight = weight of water displaced', 'ρ = ρ_water × W_air ÷ (W_air − W_water)', `= ${num(rho)} kg/m³`] };
        },
    },
    flat_round: {
        type: 'calc',
        inputs: { h: ['Your eye height', 'length', 'm', 2], d: ['Distance to the object', 'length', 'km', 30], H: ['Object height', 'length', 'm', 100], refr: ['Refraction', 'select', { none: 'None', standard: 'Standard (k = 0.13)' }, 'standard'] },
        label: 'Hidden height on a round Earth',
        rows: { flat: 'On a flat Earth', visible: 'Visible part on a globe', horizon: 'Your horizon', angle: 'Angular height of the visible part' },
        run: (x) => {
            const R = 6371000 / (1 - (x.refr === 'standard' ? 0.13 : 0));
            const dh = Math.sqrt(x.h * (2 * R + x.h));
            const beyond = Math.max(0, x.d - dh);
            const hidden = Math.sqrt(beyond * beyond + R * R) - R;
            const visible = Math.max(0, x.H - hidden);

            return { value: `${num(hidden, 4)} m`, sub: hidden >= x.H ? 'The whole object is below the horizon on a globe' : `${num((hidden / x.H) * 100, 3)}% of it hidden`, rows: { flat: 'Nothing hidden: every object stays visible, just smaller', visible: `${num(visible, 4)} m`, horizon: `${num(dh / 1000, 4)} km`, angle: `${num((Math.atan(visible / x.d) / D) * 60, 3)}′` }, steps: [`Horizon distance √(h(2R + h)) = ${num(dh / 1000)} km (R_eff = ${num(R / 1000)} km)`, `Hidden = √(x² + R²) − R with x = ${num(beyond / 1000)} km beyond the horizon = ${num(hidden)} m`, 'Ships hull-down, distant skylines cut off at the base: observations match the globe'] };
        },
    },
    hair_diffraction: {
        type: 'calc',
        inputs: { lambda: ['Laser wavelength', 'length', 'nm', 650], L: ['Distance from hair to screen', 'length', 'm', 2], y: ['Spacing between dark fringes', 'length', 'mm', 18] },
        out: 'length',
        outUnit: 'um',
        label: 'Hair thickness',
        rows: { centre: ['Width of the central bright fringe', 'length'], typical: 'Typical hair' },
        run: (x) => {
            const d = (x.lambda * x.L) / x.y;

            return { value: d, sub: `${num(d * 1e6)} µm`, rows: { centre: [2 * x.y, 'length'], typical: 'Fine hair 17–50 µm, medium 50–90 µm, thick 90–180 µm' }, steps: ['Babinet: a hair diffracts like a slit of the same width', 'Dark fringes are spaced y = λL ÷ d (small angles)', `d = ${num(x.lambda * 1e9)} nm × ${num(x.L)} m ÷ ${num(x.y * 1000)} mm = ${num(d * 1e6)} µm`] };
        },
    },
    immersed_weight: {
        type: 'calc',
        inputs: { m: ['Object mass', 'mass', 'kg', 10], by: ['Size given by', 'select', { rho: 'Its density', V: 'Its volume' }, 'rho'], rho: ['Object density', 'density', 'kgm3', 2700], V: ['Object volume', 'volume', 'l', 3.7], fluid: ['Fluid density', 'density', 'kgm3', 998.2] },
        show: { rho: 'by:rho', V: 'by:V' },
        when: { rho: (x) => x.by === 'rho', V: (x) => x.by === 'V' },
        out: 'force',
        outUnit: 'n',
        label: 'Apparent weight in the fluid',
        rows: { kg: 'As a scale reading', Fb: ['Buoyant force', 'force'], lighter: 'Lighter by' },
        run: (x) => {
            const V = x.by === 'rho' ? x.m / x.rho : x.V;
            const Fb = x.fluid * K.g0 * V;
            const W = x.m * K.g0 - Fb;

            return { value: W, sub: W < 0 ? 'It floats (needs holding down)' : `Reads ${num(W / K.g0)} kg`, rows: { kg: `${num(W / K.g0)} kg`, Fb: [Fb, 'force'], lighter: `${num((Fb / (x.m * K.g0)) * 100, 4)}%` }, steps: ['W_apparent = mg − ρ_fluid g V', `= ${num(x.m * K.g0)} − ${num(Fb)} = ${num(W)} N`] };
        },
    },
    projectile_experiment: {
        type: 'calc',
        inputs: { h: ['Launch height above the landing point', 'length', 'm', 1], R: ['Measured range', 'length', 'm', 5], t: ['Measured flight time', 'time', 's', 0.8] },
        out: 'speed',
        outUnit: 'ms',
        label: 'Launch speed',
        rows: { angle: 'Launch angle', vx: ['Horizontal speed', 'speed'], vy: ['Vertical speed', 'speed'], peak: ['Peak height above launch', 'length'] },
        run: (x) => {
            const vx = x.R / x.t;
            const vy = (0.5 * K.g0 * x.t * x.t - x.h) / x.t;
            const v = Math.hypot(vx, vy);

            return { value: v, sub: `Angle ${num(Math.atan2(vy, vx) / D, 4)}°`, rows: { angle: `${num(Math.atan2(vy, vx) / D, 4)}°`, vx: [vx, 'speed'], vy: [vy, 'speed'], peak: [vy > 0 ? (vy * vy) / (2 * K.g0) : 0, 'length'] }, steps: ['vₓ = R ÷ t', 'v_y from h + v_y t − ½gt² = 0: v_y = (½gt² − h) ÷ t', `v = ${num(v)} m/s (air resistance ignored)`] };
        },
    },
    phone_projector: {
        type: 'calc',
        inputs: { f: ['Lens focal length', 'length', 'mm', 100], diag: ['Phone screen diagonal', 'length', 'in', 6.1], wall: ['Lens to wall distance', 'length', 'm', 2] },
        out: 'length',
        outUnit: 'in',
        label: 'Picture diagonal on the wall',
        rows: { phone: ['Phone to lens distance', 'length'], m: 'Magnification', bright: 'Brightness', flip: 'Orientation' },
        run: (x) => {
            if (!(x.wall > x.f)) {
                return { error: 'The wall must be farther from the lens than its focal length.' };
            }

            const o = (x.f * x.wall) / (x.wall - x.f);
            const m = x.wall / o;

            return { value: x.diag * m, sub: `Place the phone ${num(o * 100)} cm behind the lens`, rows: { phone: [o, 'length'], m: `${num(m)} ×`, bright: `Spread over ${num(m * m)} × the area: use a dark room`, flip: 'Upside down and mirrored: rotate the phone and turn on mirroring' }, steps: ['Thin lens: 1/f = 1/dₒ + 1/dᵢ', `dₒ = f dᵢ ÷ (dᵢ − f) = ${num(o * 1000)} mm`, `Magnification = dᵢ ÷ dₒ = ${num(m)}`] };
        },
    },
    sun_angle: {
        type: 'calc',
        inputs: { ...PLACE, time: ['Local time', 'clock', null, '12:00'] },
        out: 'angle',
        outUnit: 'deg',
        label: 'Sun elevation',
        rows: { az: 'Azimuth (from north, clockwise)', zen: 'Zenith angle', shadow: 'Shadow of a 1 m stick', decl: 'Solar declination', eot: 'Equation of time' },
        run: (x) => {
            const d = ymd(x.date);
            const t = hm(x.time);

            if (!d || !Number.isFinite(t) || !Number.isFinite(x.lat) || Math.abs(x.lat) > 90) {
                return { empty: 'Enter a valid latitude, longitude, date and time.' };
            }

            const p = sunPosition(x.lat, x.lon, d[0], d[1], d[2], t - x.tz);

            return { value: p.elevation * D, sub: p.elevation > 0 ? `Azimuth ${num(p.azimuth, 4)}°` : 'Below the horizon', rows: { az: `${num(p.azimuth, 5)}°`, zen: `${num(90 - p.elevation, 5)}°`, shadow: p.elevation > 0 ? `${num(1 / Math.tan(p.elevation * D), 4)} m` : 'No shadow (night)', decl: `${num(p.decl, 5)}°`, eot: `${num(p.eot, 4)} min` }, steps: ['NOAA solar position algorithm (Meeus): declination and equation of time from the date', `Hour angle ${num(p.ha, 5)}°, true elevation ${num(p.geometric, 5)}°, with refraction ${num(p.elevation, 5)}°`] };
        },
    },
    sunrise_sunset: {
        type: 'calc',
        inputs: PLACE,
        label: 'Sunrise',
        rows: { set: 'Sunset', noon: 'Solar noon', length: 'Day length', civil: 'Civil twilight (dawn – dusk)', noonAlt: 'Sun height at noon' },
        run: (x) => {
            const d = ymd(x.date);

            if (!d || !Number.isFinite(x.lat) || Math.abs(x.lat) > 90) {
                return { empty: 'Enter a valid latitude, longitude and date.' };
            }

            const t = sunTimes(x.lat, x.lon, d[0], d[1], d[2]);
            const civ = sunTimes(x.lat, x.lon, d[0], d[1], d[2], 96);
            const local = (u) => clock(u + x.tz);
            const noonAlt = 90 - Math.abs(x.lat - t.decl);

            if (t.rise.none) {
                return { value: t.rise.none === 'up' ? 'Midnight sun' : 'Polar night', sub: t.rise.none === 'up' ? 'The sun does not set today' : 'The sun does not rise today', rows: { set: 'None', noon: local(t.noon), length: t.rise.none === 'up' ? '24 h' : '0 h', civil: civ.rise.none ? 'None' : `${local(civ.rise.t)} – ${local(civ.set.t)}`, noonAlt: `${num(noonAlt, 4)}°` }, steps: ['NOAA algorithm: no sunrise or sunset at this latitude and date'] };
            }

            const len = t.set.t - t.rise.t;

            return { value: local(t.rise.t), sub: `Sunset ${local(t.set.t)}, ${clock(len).replace(':', ' h ')} min of daylight`, rows: { set: local(t.set.t), noon: local(t.noon), length: `${clock(len).replace(':', ' h ')} min`, civil: civ.rise.none ? 'Twilight all night' : `${local(civ.rise.t)} – ${local(civ.set.t)}`, noonAlt: `${num(noonAlt, 4)}°` }, steps: ['NOAA/Meeus algorithm; sunrise and sunset when the sun’s centre is 0.833° below the horizon (refraction plus the solar radius)', 'Times are for a flat sea-level horizon; hills and altitude shift them by minutes'] };
        },
    },
    pendulum_g: {
        type: 'calc',
        inputs: { L: ['Pendulum length (pivot to the centre of the bob)', 'length', 'm', 1], t: ['Time for the oscillations', 'time', 's', 20.07], N: ['Number of full oscillations timed', null, null, 10, 1], amp: ['Swing amplitude', 'angle', 'deg', 5] },
        out: 'acceleration',
        outUnit: 'ms2',
        label: 'Measured g',
        rows: { T: 'Period', small: 'Without the amplitude correction', error: 'Difference from standard g (9.80665)' },
        run: (x) => {
            const T = x.t / x.N;
            const T0 = T / (1 + (x.amp ** 2) / 16 + (11 * x.amp ** 4) / 3072);
            const g = (4 * Math.PI ** 2 * x.L) / (T0 * T0);
            const gs = (4 * Math.PI ** 2 * x.L) / (T * T);

            return { value: g, sub: `Period ${num(T, 5)} s`, rows: { T: `${num(T, 5)} s`, small: `${num(gs)} m/s²`, error: `${num(((g - K.g0) / K.g0) * 100, 3)}%` }, steps: ['T = t ÷ N, corrected to small swings: T₀ = T ÷ (1 + θ²/16 + 11θ⁴/3072)', 'g = 4π²L ÷ T₀²', `= ${num(g)} m/s²`, 'Time many swings and measure L to the bob’s centre for the best result'] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
