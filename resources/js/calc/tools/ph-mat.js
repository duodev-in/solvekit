import { defineTools } from '../engines/formula.js';
import { D, handlersFor, K, num, pw } from '../physics/core.js';

/**
 * Materials and continuum mechanics: stress, strain, elastic constants, hardness, columns and sections.
 */
const g0 = K.g0;
const mat = (x, ctx) => ctx.c.data.physics.materials[x.mat];
/** E (Pa) of the chosen material, or the typed value. */
const youngOf = (x, ctx) => (x.mat === 'custom' ? x.E : mat(x, ctx).E * 1e9);
const MAT = { mat: ['Material', 'select', 'data:materials', 'a36'] };

/** Column sections: area, least second moment and the extreme-fibre distance. */
const SECTION_OPTIONS = { round: 'Solid round bar', tube: 'Round tube', rect: 'Solid rectangle', box: 'Square hollow section', given: 'I and A known' };
const SECTION_INPUTS = { section: ['Section', 'select', SECTION_OPTIONS, 'tube'], sd: ['Outer diameter or width', 'length', 'mm', 60], st: ['Wall thickness', 'length', 'mm', 4], sb: ['Width b', 'length', 'mm', 50], sh: ['Depth h', 'length', 'mm', 100], sI: ['Least second moment I', 'area_moment', 'cm4', 30], sA: ['Area A', 'area', 'cm2', 7] };
const SECTION_SHOW = { sd: 'section:round,tube,box', st: 'section:tube,box', sb: 'section:rect', sh: 'section:rect', sI: 'section:given', sA: 'section:given' };
const SECTION_WHEN = { sd: (x) => ['round', 'tube', 'box'].includes(x.section), st: (x) => ['tube', 'box'].includes(x.section), sb: (x) => x.section === 'rect', sh: (x) => x.section === 'rect', sI: (x) => x.section === 'given', sA: (x) => x.section === 'given' };

function section(x) {
    switch (x.section) {
        case 'round': return { A: (Math.PI * x.sd ** 2) / 4, I: (Math.PI * x.sd ** 4) / 64 };
        case 'tube': {
            const di = x.sd - 2 * x.st;

            return di < 0 ? null : { A: (Math.PI * (x.sd ** 2 - di ** 2)) / 4, I: (Math.PI * (x.sd ** 4 - di ** 4)) / 64 };
        }
        case 'box': {
            const bi = x.sd - 2 * x.st;

            return bi < 0 ? null : { A: x.sd ** 2 - bi ** 2, I: (x.sd ** 4 - bi ** 4) / 12 };
        }
        case 'rect': return { A: x.sb * x.sh, I: (Math.max(x.sb, x.sh) * Math.min(x.sb, x.sh) ** 3) / 12 };
        default: return { A: x.sA, I: x.sI };
    }
}

const ENDS = { pp: ['Pinned–pinned (K = 1)', 1], ff: ['Fixed–fixed (K = 0.5)', 0.5], fp: ['Fixed–pinned (K = 0.7)', 0.699], fc: ['Fixed–free, a flagpole (K = 2)', 2] };
const ENDS_OPTIONS = Object.fromEntries(Object.entries(ENDS).map(([k, v]) => [k, v[0]]));

/** Plane stress → principal stresses, angle and maximum shear. */
function principal(sx, sy, txy) {
    const c = (sx + sy) / 2;
    const R = Math.hypot((sx - sy) / 2, txy);

    return { c, R, s1: c + R, s2: c - R, tp: 0.5 * Math.atan2(2 * txy, sx - sy) };
}

const AWG = Object.fromEntries([-3, -2, -1, 0, ...Array.from({ length: 40 }, (_, k) => k + 1)].map((n) => [String(n), n < 0 ? `${'0'.repeat(1 - n)} (${-n + 1}/0)` : n === 0 ? '0 (1/0)' : String(n)]));
const awgDiameter = (n) => 0.127e-3 * 92 ** ((36 - n) / 39);

const SHAPES_GOLD = { ring: 'Ring band', bar: 'Bar or sheet', wire: 'Wire or cylinder', sphere: 'Bead or sphere', volume: 'Known volume' };

const ELASTIC_PAIRS = { Enu: 'E and ν', EG: 'E and G', EK: 'E and K', Gnu: 'G and ν', Knu: 'K and ν', KG: 'K and G', lG: 'λ and G' };

export const TOOLS = {
    angle_repose: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { pile: 'Pile height and radius', mu: 'The friction coefficient' }, 'pile'], h: ['Pile height', 'length', 'm', 2], r: ['Pile base radius', 'length', 'm', 3], mu: ['Coefficient of friction', null, null, 0.7, 0] },
        show: { h: 'mode:pile', r: 'mode:pile', mu: 'mode:mu' },
        when: { h: (x) => x.mode === 'pile', r: (x) => x.mode === 'pile', mu: (x) => x.mode === 'mu' },
        out: 'angle',
        outUnit: 'deg',
        label: 'Angle of repose',
        rows: { mu: 'Equivalent friction coefficient tan θ', vol: ['Volume of a conical pile', 'volume'], typical: 'Typical angles' },
        run: (x) => {
            const th = x.mode === 'pile' ? Math.atan(x.h / x.r) : Math.atan(x.mu);

            return { value: th, sub: `tan θ = ${num(Math.tan(th))}`, rows: { mu: num(Math.tan(th)), vol: x.mode === 'pile' ? [(Math.PI * x.r * x.r * x.h) / 3, 'volume'] : 'Enter the pile size', typical: 'Dry sand 30–35°, gravel 35–40°, wet clay 15–20°, grain 25–30°, snow 38°' }, steps: [x.mode === 'pile' ? `θ = atan(h ÷ r) = atan(${num(x.h)} ÷ ${num(x.r)})` : 'θ = atan μ', `= ${num(th / D)}°`] };
        },
    },
    angle_twist: {
        type: 'calc',
        inputs: { T: ['Torque', 'torque', 'nm', 500], L: ['Shaft length', 'length', 'm', 1], G: ['Shear modulus', 'pressure', 'gpa', 79.3], d: ['Outer diameter', 'length', 'mm', 40], di: ['Inner diameter (0 for solid)', 'length', 'mm', 0] },
        optional: ['di'],
        out: 'angle',
        outUnit: 'deg',
        label: 'Angle of twist',
        rows: { J: ['Polar moment J', 'area_moment'], tau: ['Maximum shear stress', 'pressure'], k: ['Torsional stiffness', 'rotational_stiffness'] },
        run: (x) => {
            const di = Number.isFinite(x.di) ? x.di : 0;
            const J = (Math.PI * (x.d ** 4 - di ** 4)) / 32;
            const phi = (x.T * x.L) / (x.G * J);

            return { value: phi, sub: `${num(phi)} rad`, rows: { J: [J, 'area_moment'], tau: [(x.T * x.d) / 2 / J, 'pressure'], k: [(x.G * J) / x.L, 'rotational_stiffness'] }, steps: ['φ = TL ÷ GJ, J = π(D⁴ − d⁴) ÷ 32', `J = ${num(J)} m⁴`, `φ = ${num(phi)} rad = ${num(phi / D)}°`, 'Steel G ≈ 79.3 GPa, aluminium ≈ 26 GPa'] };
        },
    },
    bend_allowance: {
        type: 'calc',
        inputs: { angle: ['Bend angle', 'angle', 'deg', 90], R: ['Inside bend radius', 'length', 'mm', 3], t: ['Material thickness', 'length', 'mm', 2], k: ['K-factor', null, null, 0.33, 0] },
        out: 'length',
        outUnit: 'mm',
        label: 'Bend allowance',
        rows: { ossb: ['Outside setback', 'length'], bd: ['Bend deduction', 'length'], neutral: ['Neutral axis radius', 'length'] },
        run: (x) => {
            const ba = x.angle * (x.R + x.k * x.t);
            const ossb = Math.tan(x.angle / 2) * (x.R + x.t);

            return { value: ba, sub: `Bend deduction ${num((2 * ossb - ba) * 1000)} mm`, rows: { ossb: [ossb, 'length'], bd: [2 * ossb - ba, 'length'], neutral: [x.R + x.k * x.t, 'length'] }, steps: ['BA = θ(R + Kt), θ in radians', `= ${num(x.angle)} × (${num(x.R * 1000)} + ${num(x.k)} × ${num(x.t * 1000)}) = ${num(ba * 1000)} mm`, `OSSB = tan(θ/2)(R + t) = ${num(ossb * 1000)} mm, BD = 2 OSSB − BA`] };
        },
    },
    brinell: {
        type: 'calc',
        inputs: { F: ['Test load', 'force', 'kgf', 3000], Db: ['Ball diameter', 'length', 'mm', 10], d: ['Mean indentation diameter', 'length', 'mm', 4] },
        label: 'Brinell hardness',
        rows: { uts: 'Approximate tensile strength (steels)', ratio: 'Indentation ratio d/D', valid: 'Validity' },
        run: (x) => {
            const Fk = x.F / g0;
            const Dm = x.Db * 1000;
            const dm = x.d * 1000;

            if (!(dm < Dm)) {
                return { error: 'The indentation must be smaller than the ball.' };
            }

            const hb = (2 * Fk) / (Math.PI * Dm * (Dm - Math.sqrt(Dm * Dm - dm * dm)));

            return { value: num(hb, 4), unit: 'HBW', sub: `${num(hb, 4)} HBW ${num(Dm)}/${num(Fk)}`, rows: { uts: `≈ ${num(3.45 * hb, 3)} MPa (rule of thumb UTS ≈ 3.45 × HB)`, ratio: num(dm / Dm, 3), valid: dm / Dm >= 0.24 && dm / Dm <= 0.6 ? 'Within 0.24–0.6 D (ISO 6506)' : 'Outside 0.24–0.6 D: choose another load' }, steps: ['HB = 2F ÷ (πD(D − √(D² − d²))), F in kgf, D and d in mm', `= 2 × ${num(Fk)} ÷ (π × ${num(Dm)} × (${num(Dm)} − √(${num(Dm * Dm)} − ${num(dm * dm)}))) = ${num(hb)}`] };
        },
    },
    buckling: {
        type: 'calc',
        inputs: { L: ['Column length', 'length', 'm', 3], ends: ['End conditions', 'select', ENDS_OPTIONS, 'pp'], ...MAT, E: ["Young's modulus", 'pressure', 'gpa', 200], sy: ['Yield strength (optional)', 'pressure', 'mpa', 250], ...SECTION_INPUTS },
        show: { E: 'mat:custom', sy: 'mat:custom', ...SECTION_SHOW },
        when: { E: (x) => x.mat === 'custom', ...SECTION_WHEN },
        optional: ['sy'],
        data: ['materials'],
        out: 'force',
        outUnit: 'kn',
        label: 'Euler critical load',
        rows: { sigma: ['Critical stress', 'pressure'], slender: 'Slenderness ratio KL/r', regime: 'Check', johnson: ['Johnson load (short columns)', 'force'] },
        run: (x, ctx) => {
            const s = section(x);

            if (!s || !(s.I > 0 && s.A > 0)) {
                return { error: 'Check the section: the wall is too thick or a value is missing.' };
            }

            const E = youngOf(x, ctx);
            const sy = x.mat === 'custom' ? x.sy : (mat(x, ctx).yield ?? NaN) * 1e6;
            const Ke = ENDS[x.ends][1];
            const Le = Ke * x.L;
            const P = (Math.PI ** 2 * E * s.I) / Le ** 2;
            const r = Math.sqrt(s.I / s.A);
            const lam = Le / r;
            const lamC = Number.isFinite(sy) ? Math.sqrt((2 * Math.PI ** 2 * E) / sy) : NaN;
            const johnson = Number.isFinite(sy) ? s.A * (sy - (sy * sy * lam * lam) / (4 * Math.PI ** 2 * E)) : NaN;
            const shortCol = Number.isFinite(lamC) && lam < lamC;

            return { value: shortCol ? johnson : P, label: shortCol ? 'Critical load (Johnson, short column)' : 'Euler critical load', sub: `KL/r = ${num(lam, 4)}${Number.isFinite(lamC) ? `, transition at ${num(lamC, 4)}` : ''}`, rows: { sigma: [(shortCol ? johnson : P) / s.A, 'pressure'], slender: num(lam, 4), regime: !Number.isFinite(lamC) ? 'Enter a yield strength to check against short-column failure' : shortCol ? 'Short column: Euler overestimates, Johnson used' : 'Long column: Euler applies', johnson: Number.isFinite(johnson) ? [johnson, 'force'] : 'Needs a yield strength' }, steps: [`Effective length KL = ${num(Ke)} × ${num(x.L)} = ${num(Le)} m`, `I = ${num(s.I)} m⁴, A = ${num(s.A)} m², r = √(I/A) = ${num(r * 1000)} mm`, `P_cr = π²EI ÷ (KL)² = ${num(P)} N`, 'No safety factor is applied'] };
        },
    },
    bulk_modulus: pw({ vars: { K: ['Bulk modulus', 'pressure', 'gpa', 2.2], dP: ['Pressure increase', 'pressure', 'mpa', 10], V: ['Original volume', 'volume', 'l', 1], dV: ['Volume decrease', 'volume', 'ml', 4.5455] }, out: 'K', exp: { dP: 1, V: 1, dV: -1 }, eq: 'K = −V ΔP ÷ ΔV', forms: { K: 'K = V ΔP ÷ (volume decrease)', dP: 'ΔP = K ΔV ÷ V', V: 'V = K ΔV ÷ ΔP', dV: 'ΔV = V ΔP ÷ K' }, rows: { comp: 'Compressibility 1/K', strain: 'Volumetric strain' }, extra: (v) => ({ comp: `${num(1 / v.K)} Pa⁻¹`, strain: `${num((v.dV / v.V) * 100)}%` }) }),
    copper_wire: {
        type: 'calc',
        inputs: { mode: ['Size given as', 'select', { awg: 'AWG gauge', dia: 'Diameter', area: 'Cross-section area' }, 'awg'], awg: ['AWG', 'select', AWG, '12'], d: ['Diameter', 'length', 'mm', 2.05], area: ['Area', 'area', 'mm2', 2.5], L: ['Length', 'length', 'm', 100], cores: ['Number of conductors', null, null, 1, 1] },
        show: { awg: 'mode:awg', d: 'mode:dia', area: 'mode:area' },
        when: { d: (x) => x.mode === 'dia', area: (x) => x.mode === 'area' },
        out: 'mass',
        outUnit: 'kg',
        label: 'Copper weight',
        rows: { area: 'Copper cross-section', dia: 'Diameter', R: 'Resistance at 20 °C (per conductor)', perm: 'Weight per metre' },
        run: (x) => {
            const d = x.mode === 'awg' ? awgDiameter(Number(x.awg)) : x.mode === 'dia' ? x.d : Math.sqrt((4 * x.area) / Math.PI);
            const A = (Math.PI * d * d) / 4;
            const m = 8960 * A * x.L * x.cores;

            return { value: m, sub: `${num(A * 1e6, 4)} mm² of copper, ${num(m / x.L * 1000, 4)} g/m`, rows: { area: `${num(A * 1e6, 4)} mm² (${num((A / 5.067075e-10) / 1000, 4)} kcmil)`, dia: `${num(d * 1000, 4)} mm (${num(d / 0.0254 * 1000, 4)} mil)`, R: `${num((1.724e-8 * x.L) / A, 4)} Ω (${num((1.724e-8 / A) * 1000, 4)} Ω/km)`, perm: `${num((8960 * A * x.cores) * 1000, 4)} g/m` }, steps: ['AWG n: d = 0.127 mm × 92^((36 − n)/39)', `m = ρ A L × conductors, ρ = 8,960 kg/m³ (annealed copper)`, `= ${num(m)} kg (copper only; insulation and stranding lay add more)`] };
        },
    },
    density: pw({ vars: { rho: ['Density', 'density', 'kgm3', 7850], m: ['Mass', 'mass', 'kg', 7.85], V: ['Volume', 'volume', 'l', 1] }, out: 'rho', exp: { m: 1, V: -1 }, eq: 'ρ = m ÷ V', forms: { rho: 'ρ = m ÷ V', m: 'm = ρV', V: 'V = m ÷ ρ' }, rows: { sg: 'Specific gravity' }, extra: (v) => ({ sg: num(v.rho / 999.972) }) }),
    elastic_constants: {
        type: 'calc',
        inputs: { pair: ['I know', 'select', ELASTIC_PAIRS, 'Enu'], E: ["Young's modulus E", 'pressure', 'gpa', 200], G: ['Shear modulus G', 'pressure', 'gpa', 79.3], Km: ['Bulk modulus K', 'pressure', 'gpa', 160], lam: ['Lamé λ', 'pressure', 'gpa', 115], nu: ["Poisson's ratio ν", null, null, 0.29] },
        show: { E: 'pair:Enu,EG,EK', G: 'pair:EG,Gnu,KG,lG', Km: 'pair:EK,Knu,KG', lam: 'pair:lG', nu: 'pair:Enu,Gnu,Knu' },
        when: { E: (x) => x.pair.startsWith('E'), G: (x) => x.pair.includes('G'), Km: (x) => x.pair.includes('K'), lam: (x) => x.pair === 'lG', nu: (x) => x.pair.includes('nu') },
        out: 'pressure',
        outUnit: 'gpa',
        label: "Young's modulus E",
        rows: { E: ["Young's modulus E", 'pressure'], G: ['Shear modulus G', 'pressure'], K: ['Bulk modulus K', 'pressure'], lam: ['Lamé λ', 'pressure'], M: ['P-wave modulus M', 'pressure'], nu: "Poisson's ratio ν" },
        run: (x) => {
            let E;
            let nu;

            switch (x.pair) {
                case 'Enu': [E, nu] = [x.E, x.nu]; break;
                case 'EG': [E, nu] = [x.E, x.E / (2 * x.G) - 1]; break;
                case 'EK': [E, nu] = [x.E, (3 * x.Km - x.E) / (6 * x.Km)]; break;
                case 'Gnu': [E, nu] = [2 * x.G * (1 + x.nu), x.nu]; break;
                case 'Knu': [E, nu] = [3 * x.Km * (1 - 2 * x.nu), x.nu]; break;
                case 'KG': [E, nu] = [(9 * x.Km * x.G) / (3 * x.Km + x.G), (3 * x.Km - 2 * x.G) / (2 * (3 * x.Km + x.G))]; break;
                default: [E, nu] = [(x.G * (3 * x.lam + 2 * x.G)) / (x.lam + x.G), x.lam / (2 * (x.lam + x.G))];
            }

            if (!(nu > -1 && nu < 0.5)) {
                return { error: 'These values give a Poisson’s ratio outside −1…0.5, which no stable isotropic material has.' };
            }

            const G = E / (2 * (1 + nu));
            const Km = E / (3 * (1 - 2 * nu));
            const lam = (E * nu) / ((1 + nu) * (1 - 2 * nu));

            return { value: E, sub: `ν = ${num(nu, 4)}`, rows: { E: [E, 'pressure'], G: [G, 'pressure'], K: [Km, 'pressure'], lam: [lam, 'pressure'], M: [lam + 2 * G, 'pressure'], nu: num(nu, 5) }, steps: [`From ${ELASTIC_PAIRS[x.pair]}: E = ${num(E / 1e9)} GPa, ν = ${num(nu)}`, 'G = E ÷ 2(1 + ν), K = E ÷ 3(1 − 2ν), λ = Eν ÷ (1 + ν)(1 − 2ν), M = λ + 2G'] };
        },
    },
    elongation: pw({ vars: { dL: ['Elongation', 'length', 'mm', 1.5], F: ['Axial force', 'force', 'kn', 100], L: ['Original length', 'length', 'm', 3], A: ['Cross-section area', 'area', 'mm2', 1000], E: ["Young's modulus", 'pressure', 'gpa', 200] }, out: 'dL', exp: { F: 1, L: 1, A: -1, E: -1 }, eq: 'δ = F L ÷ (A E)', forms: { dL: 'δ = FL ÷ AE', F: 'F = δAE ÷ L', L: 'L = δAE ÷ F', A: 'A = FL ÷ δE', E: 'E = FL ÷ δA' }, rows: { stress: ['Stress', 'pressure'], strain: 'Strain' }, extra: (v) => ({ stress: [v.F / v.A, 'pressure'], strain: `${num(v.dL / v.L)} (${num((v.dL / v.L) * 1e6)} µε)` }) }),
    factor_safety: {
        type: 'calc',
        inputs: { kind: ['Compare', 'select', { stress: 'Stresses', load: 'Loads' }, 'stress'], fail: ['Failure stress (yield or ultimate)', 'pressure', 'mpa', 250], actual: ['Working stress', 'pressure', 'mpa', 100], failL: ['Failure load', 'force', 'kn', 50], actualL: ['Working load', 'force', 'kn', 20] },
        show: { fail: 'kind:stress', actual: 'kind:stress', failL: 'kind:load', actualL: 'kind:load' },
        when: { fail: (x) => x.kind === 'stress', actual: (x) => x.kind === 'stress', failL: (x) => x.kind === 'load', actualL: (x) => x.kind === 'load' },
        label: 'Factor of safety',
        rows: { ms: 'Margin of safety (FoS − 1)', used: 'Share of capacity used', verdict: 'Assessment' },
        run: (x) => {
            const f = x.kind === 'stress' ? x.fail / x.actual : x.failL / x.actualL;

            return { value: num(f, 4), sub: `Margin of safety ${num(f - 1, 4)}`, rows: { ms: num(f - 1, 4), used: `${num(100 / f, 4)}%`, verdict: f < 1 ? 'Fails: the working value exceeds the capacity' : f < 1.5 ? 'Low: only for well-known loads and materials' : f < 3 ? 'Typical for static loads on ductile metals' : 'Conservative (common for lifting gear, brittle materials, uncertain loads)' }, steps: ['FoS = capacity ÷ demand', `= ${num(f)}`] };
        },
    },
    gold_weight: {
        type: 'calc',
        inputs: { karat: ['Gold', 'select', 'data:gold:fixed', 'k22'], shape: ['Shape', 'select', SHAPES_GOLD, 'ring'], d: ['Inner diameter (ring) or diameter', 'length', 'mm', 18], w: ['Band width or bar width', 'length', 'mm', 4], t: ['Thickness', 'length', 'mm', 1.5], L: ['Length', 'length', 'mm', 50], V: ['Volume', 'volume', 'ml', 1] },
        show: { d: 'shape:ring,wire,sphere', w: 'shape:ring,bar', t: 'shape:ring,bar', L: 'shape:bar,wire', V: 'shape:volume' },
        when: { d: (x) => ['ring', 'wire', 'sphere'].includes(x.shape), w: (x) => ['ring', 'bar'].includes(x.shape), t: (x) => ['ring', 'bar'].includes(x.shape), L: (x) => ['bar', 'wire'].includes(x.shape), V: (x) => x.shape === 'volume' },
        data: ['gold'],
        out: 'mass',
        outUnit: 'g',
        label: 'Weight',
        rows: { pure: ['Pure gold content', 'mass'], troy: 'In troy ounces', vol: 'Volume' },
        run: (x, ctx) => {
            const g = ctx.c.data.physics.gold[x.karat];
            const r = x.d / 2;
            const V = { ring: Math.PI * x.w * ((r + x.t) ** 2 - r * r), bar: x.w * x.t * x.L, wire: Math.PI * r * r * x.L, sphere: (4 / 3) * Math.PI * r ** 3, volume: x.V }[x.shape];
            const m = V * g.density;

            return { value: m, sub: `${g.name}, density ${num(g.density / 1000, 4)} g/cm³`, rows: { pure: [m * g.fraction, 'mass'], troy: `${num(m / 0.0311034768, 4)} ozt`, vol: `${num(V * 1e6, 4)} cm³` }, steps: [`V = ${num(V * 1e6)} cm³`, `m = ρV = ${num(g.density / 1000)} g/cm³ × ${num(V * 1e6)} cm³ = ${num(m * 1000)} g`, 'Typical yellow-gold densities; white and rose alloys differ by up to 5%'] };
        },
    },
    hoop_stress: {
        type: 'calc',
        inputs: { P: ['Internal pressure', 'pressure', 'bar', 10], d: ['Inner diameter', 'length', 'mm', 500], t: ['Wall thickness', 'length', 'mm', 5], sy: ['Allowable stress (optional)', 'pressure', 'mpa', 138] },
        optional: ['sy'],
        out: 'pressure',
        outUnit: 'mpa',
        label: 'Hoop stress (thin wall)',
        rows: { axial: ['Longitudinal stress (closed ends)', 'pressure'], lame: ['Exact inner-surface hoop stress (Lamé)', 'pressure'], ratio: 'Diameter ÷ thickness', fos: 'Utilisation' },
        run: (x) => {
            const ri = x.d / 2;
            const ro = ri + x.t;
            const hoop = (x.P * (ri + x.t / 2)) / x.t;
            const lame = (x.P * (ro * ro + ri * ri)) / (ro * ro - ri * ri);

            return { value: hoop, sub: x.d / x.t >= 20 ? 'Thin-wall formula valid (D/t ≥ 20)' : 'Thick wall: use the Lamé value', rows: { axial: [(x.P * ri * ri) / (ro * ro - ri * ri), 'pressure'], lame: [lame, 'pressure'], ratio: num(x.d / x.t, 4), fos: Number.isFinite(x.sy) ? `${num((Math.max(hoop, lame) / x.sy) * 100, 4)}% of the allowable` : 'Enter an allowable stress' }, steps: ['σ_h = P r_mean ÷ t', `= ${num(x.P / 1e6)} MPa × ${num((ri + x.t / 2) * 1000)} mm ÷ ${num(x.t * 1000)} mm = ${num(hoop / 1e6)} MPa`, `Lamé at the bore: P(r_o² + r_i²) ÷ (r_o² − r_i²) = ${num(lame / 1e6)} MPa`] };
        },
    },
    impact_test: {
        type: 'calc',
        inputs: { m: ['Pendulum mass', 'mass', 'kg', 20], L: ['Arm length (pivot to centre of mass)', 'length', 'm', 0.8], a: ['Release angle from the bottom', 'angle', 'deg', 150], b: ['Rise angle after breaking the specimen', 'angle', 'deg', 70], area: ['Specimen area under the notch (optional)', 'area', 'mm2', 80] },
        optional: ['area'],
        out: 'energy',
        outUnit: 'j',
        label: 'Absorbed energy',
        rows: { E0: ['Available energy', 'energy'], v: ['Impact speed', 'speed'], toughness: 'Impact strength' },
        run: (x) => {
            if (!(x.b <= x.a)) {
                return { error: 'The pendulum cannot rise higher than it was released.' };
            }

            const E = x.m * g0 * x.L * (Math.cos(x.b) - Math.cos(x.a));

            return { value: E, sub: `${num((E / (x.m * g0 * x.L * (1 - Math.cos(x.a)))) * 100, 4)}% of the available energy`, rows: { E0: [x.m * g0 * x.L * (1 - Math.cos(x.a)), 'energy'], v: [Math.sqrt(2 * g0 * x.L * (1 - Math.cos(x.a))), 'speed'], toughness: Number.isFinite(x.area) ? `${num(E / (x.area * 1e4))} J/cm²` : 'Enter the specimen area' }, steps: ['E = mgL(cos β − cos α), angles from the lowest position', `= ${num(x.m)} × 9.80665 × ${num(x.L)} × (cos ${num(x.b / D)}° − cos ${num(x.a / D)}°) = ${num(E)} J`, 'Friction and windage losses are ignored'] };
        },
    },
    intrinsic_carrier: {
        type: 'calc',
        inputs: { sc: ['Semiconductor', 'select', 'data:semiconductors', 'si'], T: ['Temperature', 'temperature', 'k', 300], eg: ['Band gap at this temperature (eV)', null, null, 1.12, 0], nc: ['N_c at 300 K (cm⁻³)', null, null, 2.8e19, 0], nv: ['N_v at 300 K (cm⁻³)', null, null, 1.04e19, 0] },
        show: { eg: 'sc:custom', nc: 'sc:custom', nv: 'sc:custom' },
        when: { eg: (x) => x.sc === 'custom', nc: (x) => x.sc === 'custom', nv: (x) => x.sc === 'custom' },
        data: ['semiconductors'],
        label: 'Intrinsic carrier concentration',
        rows: { eg: 'Band gap used', nc: 'Effective densities of states', resist: 'Intrinsic resistivity (silicon mobilities)' },
        run: (x, ctx) => {
            const s = x.sc === 'custom' ? null : ctx.c.data.physics.semiconductors[x.sc];
            const Eg = s ? s.eg0 - (s.alpha * x.T * x.T) / (x.T + s.beta) : x.eg;
            const scale = (x.T / 300) ** 1.5;
            const Nc = (s ? s.nc : x.nc) * scale;
            const Nv = (s ? s.nv : x.nv) * scale;
            const kT = (K.k * x.T) / K.e;
            const ni = Math.sqrt(Nc * Nv) * Math.exp(-Eg / (2 * kT));

            return { value: num(ni, 4), unit: 'cm⁻³', sub: `E_g = ${num(Eg, 4)} eV at ${num(x.T)} K`, rows: { eg: `${num(Eg, 4)} eV (Varshni)`, nc: `N_c = ${num(Nc, 4)}, N_v = ${num(Nv, 4)} cm⁻³`, resist: x.sc === 'si' ? `${num(1 / (ni * K.e * (1400 + 450)) / 100, 4)} kΩ·cm` : 'Only shown for silicon' }, steps: ['nᵢ = √(N_c N_v) e^(−E_g / 2kT), N ∝ T^1.5', `kT = ${num(kT)} eV`, `nᵢ = ${num(ni)} cm⁻³`, 'Textbook model: measured silicon nᵢ at 300 K is 9.65 × 10⁹ cm⁻³ (Altermatt 2003)'] };
        },
    },
    mohr: {
        type: 'calc',
        inputs: { sx: ['σx', 'pressure', 'mpa', 80], sy: ['σy', 'pressure', 'mpa', -40], txy: ['τxy', 'pressure', 'mpa', 30], th: ['Rotate the element by', 'angle', 'deg', 30] },
        out: 'pressure',
        outUnit: 'mpa',
        label: 'Major principal stress σ₁',
        rows: { s2: ['Minor principal stress σ₂', 'pressure'], tmax: ['Maximum in-plane shear', 'pressure'], tp: 'Principal angle θp', rot: 'Stresses on the rotated element' },
        plots: [['circle', "Mohr's circle"]],
        run: (x) => {
            const p = principal(x.sx, x.sy, x.txy);
            const c2 = Math.cos(2 * x.th);
            const s2 = Math.sin(2 * x.th);
            const sxr = p.c + ((x.sx - x.sy) / 2) * c2 + x.txy * s2;
            const syr = p.c - ((x.sx - x.sy) / 2) * c2 - x.txy * s2;
            const txr = -((x.sx - x.sy) / 2) * s2 + x.txy * c2;
            const M = 1e-6;
            const off = p.R * M * 0.12;
            const circle = Array.from({ length: 97 }, (_, k) => [(p.c + p.R * Math.cos((k * 2 * Math.PI) / 96)) * M, p.R * Math.sin((k * 2 * Math.PI) / 96) * M]);

            return { value: p.s1, sub: `Centre ${num(p.c * M)} MPa, radius ${num(p.R * M)} MPa`, rows: { s2: [p.s2, 'pressure'], tmax: [p.R, 'pressure'], tp: `${num(p.tp / D)}° (counter-clockwise from x to σ₁)`, rot: `σx′ = ${num(sxr * M)}, σy′ = ${num(syr * M)}, τx′y′ = ${num(txr * M)} MPa` }, steps: ['Centre C = (σx + σy) ÷ 2, radius R = √(((σx − σy)/2)² + τxy²)', `C = ${num(p.c * M)} MPa, R = ${num(p.R * M)} MPa`, `σ₁,₂ = C ± R = ${num(p.s1 * M)}, ${num(p.s2 * M)} MPa`, `tan 2θp = 2τxy ÷ (σx − σy) → θp = ${num(p.tp / D)}°`], plots: { circle: { kind: 'diagram', shapes: [{ points: circle }, { points: [[x.sx * M, -x.txy * M], [x.sy * M, x.txy * M]], muted: true }, { points: [[Math.min(p.s2, 0) * M - p.R * M * 0.1, 0], [Math.max(p.s1, 0) * M + p.R * M * 0.1, 0]], muted: true }], dots: [[x.sx * M, -x.txy * M], [x.sy * M, x.txy * M], [p.s1 * M, 0], [p.s2 * M, 0]], labels: [{ x: x.sx * M, y: -x.txy * M - off, text: 'X' }, { x: x.sy * M, y: x.txy * M + off, text: 'Y' }, { x: p.s1 * M + off, y: off, text: 'σ₁' }, { x: p.s2 * M - off, y: off, text: 'σ₂' }] } } };
        },
    },
    natural_frequency: pw({ vars: { f: ['Natural frequency', 'frequency_hz', 'hz', 5.03292], k: ['Stiffness', 'stiffness', 'npm', 1000], m: ['Mass', 'mass', 'kg', 1] }, out: 'f', k: 1 / (2 * Math.PI), exp: { k: 0.5, m: -0.5 }, eq: 'f = (1 ÷ 2π) √(k ÷ m)', forms: { f: 'f = √(k/m) ÷ 2π', k: 'k = m(2πf)²', m: 'm = k ÷ (2πf)²' }, rows: { T: ['Period', 'short_time'], defl: ['Static deflection under gravity', 'length'], w: 'Angular frequency' }, extra: (v) => ({ T: [1 / v.f, 'short_time'], defl: [(v.m * g0) / v.k, 'length'], w: `${num(2 * Math.PI * v.f)} rad/s` }) }),
    number_density: {
        type: 'calc',
        inputs: { mode: ['Substance', 'select', { solid: 'Solid or liquid (density and molar mass)', gas: 'Ideal gas (pressure and temperature)' }, 'gas'], rho: ['Density', 'density', 'gcm3', 8.96], M: ['Molar mass (g/mol)', null, null, 63.546, 0], P: ['Pressure', 'pressure', 'atm', 1], T: ['Temperature', 'temperature', 'c', 0] },
        show: { rho: 'mode:solid', M: 'mode:solid', P: 'mode:gas', T: 'mode:gas' },
        when: { rho: (x) => x.mode === 'solid', M: (x) => x.mode === 'solid', P: (x) => x.mode === 'gas', T: (x) => x.mode === 'gas' },
        label: 'Number density',
        rows: { cm3: 'Per cubic centimetre', spacing: 'Mean spacing between particles', mol: 'Amount per cubic metre' },
        run: (x) => {
            const n = x.mode === 'gas' ? x.P / (K.k * x.T) : (x.rho * K.NA) / (x.M / 1000);

            return { value: num(n, 6), unit: 'm⁻³', sub: x.mode === 'gas' ? 'n = P ÷ kT' : 'n = ρNₐ ÷ M', rows: { cm3: `${num(n / 1e6, 6)} cm⁻³`, spacing: `${num(n ** (-1 / 3) * 1e9, 4)} nm`, mol: `${num(n / K.NA, 6)} mol/m³` }, steps: [x.mode === 'gas' ? `n = ${num(x.P)} Pa ÷ (1.380649 × 10⁻²³ × ${num(x.T)} K)` : `n = ${num(x.rho)} kg/m³ × 6.02214 × 10²³ ÷ ${num(x.M / 1000)} kg/mol`, `= ${num(n)} m⁻³`] };
        },
    },
    poisson: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { strain: 'The two strains', dims: 'Original and deformed dimensions' }, 'dims'], elat: ['Lateral strain', null, null, -0.0003], eax: ['Axial strain', null, null, 0.001], L0: ['Original length', 'length', 'mm', 100], L1: ['Stretched length', 'length', 'mm', 100.1], d0: ['Original width', 'length', 'mm', 10], d1: ['New width', 'length', 'mm', 9.997] },
        show: { elat: 'mode:strain', eax: 'mode:strain', L0: 'mode:dims', L1: 'mode:dims', d0: 'mode:dims', d1: 'mode:dims' },
        when: { elat: (x) => x.mode === 'strain', eax: (x) => x.mode === 'strain', L0: (x) => x.mode === 'dims', L1: (x) => x.mode === 'dims', d0: (x) => x.mode === 'dims', d1: (x) => x.mode === 'dims' },
        label: "Poisson's ratio ν",
        rows: { strains: 'Strains', typical: 'Typical values' },
        run: (x) => {
            const ea = x.mode === 'strain' ? x.eax : (x.L1 - x.L0) / x.L0;
            const el = x.mode === 'strain' ? x.elat : (x.d1 - x.d0) / x.d0;
            const nu = -el / ea;

            return { value: num(nu, 4), sub: nu < 0 ? 'Negative: an auxetic material' : nu > 0.5 ? 'Above 0.5 is impossible for an isotropic solid; check the values' : 'ν = −ε_lateral ÷ ε_axial', rows: { strains: `axial ${num(ea)}, lateral ${num(el)}`, typical: 'Rubber ≈ 0.5, metals 0.27–0.35, concrete ≈ 0.2, cork ≈ 0' }, steps: ['ν = −ε_lat ÷ ε_axial', `= −(${num(el)}) ÷ ${num(ea)} = ${num(nu)}`] };
        },
    },
    principal_stress: {
        type: 'calc',
        inputs: { sx: ['σx', 'pressure', 'mpa', 80], sy: ['σy', 'pressure', 'mpa', -40], txy: ['τxy', 'pressure', 'mpa', 30] },
        out: 'pressure',
        outUnit: 'mpa',
        label: 'Major principal stress σ₁',
        rows: { s2: ['Minor principal stress σ₂', 'pressure'], tmax: ['Maximum in-plane shear', 'pressure'], tabs: ['Absolute maximum shear (with σ₃ = 0)', 'pressure'], tp: 'Principal angle θp', vm: ['Von Mises stress', 'pressure'] },
        run: (x) => {
            const p = principal(x.sx, x.sy, x.txy);
            const tabs = Math.max(p.R, Math.abs(p.s1) / 2, Math.abs(p.s2) / 2);

            return { value: p.s1, sub: `σ₂ = ${num(p.s2 / 1e6)} MPa at θp = ${num(p.tp / D)}°`, rows: { s2: [p.s2, 'pressure'], tmax: [p.R, 'pressure'], tabs: [tabs, 'pressure'], tp: `${num(p.tp / D)}°`, vm: [Math.sqrt(p.s1 ** 2 - p.s1 * p.s2 + p.s2 ** 2), 'pressure'] }, steps: ['σ₁,₂ = (σx + σy)/2 ± √(((σx − σy)/2)² + τxy²)', `= ${num(p.c / 1e6)} ± ${num(p.R / 1e6)} MPa`, 'θp = ½ atan(2τxy ÷ (σx − σy))'] };
        },
    },
    section_modulus: {
        type: 'calc',
        inputs: { shape: ['Section', 'select', { rect: 'Rectangle', box: 'Rectangular hollow section', round: 'Solid round', tube: 'Round tube', ibeam: 'I-beam (symmetric)' }, 'ibeam'], b: ['Width b (flange width)', 'length', 'mm', 100], h: ['Depth h', 'length', 'mm', 200], t: ['Wall or flange thickness', 'length', 'mm', 8.5], tw: ['Web thickness', 'length', 'mm', 5.6], d: ['Outer diameter', 'length', 'mm', 60], di: ['Inner diameter', 'length', 'mm', 50] },
        show: { b: 'shape:rect,box,ibeam', h: 'shape:rect,box,ibeam', t: 'shape:box,ibeam', tw: 'shape:ibeam', d: 'shape:round,tube', di: 'shape:tube' },
        when: { b: (x) => ['rect', 'box', 'ibeam'].includes(x.shape), h: (x) => ['rect', 'box', 'ibeam'].includes(x.shape), t: (x) => ['box', 'ibeam'].includes(x.shape), tw: (x) => x.shape === 'ibeam', d: (x) => ['round', 'tube'].includes(x.shape), di: (x) => x.shape === 'tube' },
        out: 'area_moment',
        outUnit: 'cm4',
        label: 'Second moment of area I',
        rows: { S: 'Elastic section modulus S = I/c', Z: 'Plastic section modulus Z', shape: 'Shape factor Z/S', A: 'Area' },
        run: (x) => {
            let I;
            let Z;
            let c;
            let A;
            const { b, h, t, tw, d, di } = x;

            if (x.shape === 'rect') {
                [I, Z, c, A] = [(b * h ** 3) / 12, (b * h * h) / 4, h / 2, b * h];
            } else if (x.shape === 'box') {
                const bi = b - 2 * t;
                const hi = h - 2 * t;
                [I, Z, c, A] = [(b * h ** 3 - bi * hi ** 3) / 12, (b * h * h - bi * hi * hi) / 4, h / 2, b * h - bi * hi];
            } else if (x.shape === 'round') {
                [I, Z, c, A] = [(Math.PI * d ** 4) / 64, d ** 3 / 6, d / 2, (Math.PI * d * d) / 4];
            } else if (x.shape === 'tube') {
                [I, Z, c, A] = [(Math.PI * (d ** 4 - di ** 4)) / 64, (d ** 3 - di ** 3) / 6, d / 2, (Math.PI * (d * d - di * di)) / 4];
            } else {
                const hw = h - 2 * t;
                [I, Z, c, A] = [(b * h ** 3 - (b - tw) * hw ** 3) / 12, b * t * (h - t) + (tw * hw * hw) / 4, h / 2, 2 * b * t + tw * hw];
            }

            if (!(I > 0 && A > 0)) {
                return { error: 'Check the dimensions: the hollow part is larger than the section.' };
            }

            const S = I / c;

            return { value: I, sub: `S = ${num(S * 1e6)} cm³, Z = ${num(Z * 1e6)} cm³ (bending about the strong axis)`, rows: { S: `${num(S * 1e9)} mm³ = ${num(S * 1e6)} cm³ = ${num(S / 1.6387064e-5)} in³`, Z: `${num(Z * 1e6)} cm³ = ${num(Z / 1.6387064e-5)} in³`, shape: num(Z / S, 4), A: `${num(A * 1e6)} mm²` }, steps: [`I = ${num(I * 1e8)} cm⁴, c = ${num(c * 1000)} mm`, `S = I ÷ c = ${num(S * 1e6)} cm³`, `Z = ${num(Z * 1e6)} cm³ (first moments of the two halves)`, x.shape === 'ibeam' ? 'Root fillets of rolled sections are ignored, so tables give slightly higher values' : 'Exact for the idealised shape'] };
        },
    },
    shear_modulus: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { tg: 'Shear stress and strain', enu: "Young's modulus and Poisson's ratio" }, 'enu'], tau: ['Shear stress', 'pressure', 'mpa', 50], gamma: ['Shear strain (rad)', null, null, 0.00063], E: ["Young's modulus", 'pressure', 'gpa', 200], nu: ["Poisson's ratio", null, null, 0.29] },
        show: { tau: 'mode:tg', gamma: 'mode:tg', E: 'mode:enu', nu: 'mode:enu' },
        when: { tau: (x) => x.mode === 'tg', gamma: (x) => x.mode === 'tg', E: (x) => x.mode === 'enu', nu: (x) => x.mode === 'enu' },
        out: 'pressure',
        outUnit: 'gpa',
        label: 'Shear modulus G',
        rows: { typical: 'Typical values' },
        run: (x) => {
            const G = x.mode === 'tg' ? x.tau / x.gamma : x.E / (2 * (1 + x.nu));

            return { value: G, sub: x.mode === 'tg' ? 'G = τ ÷ γ' : 'G = E ÷ 2(1 + ν)', rows: { typical: 'Steel ≈ 79 GPa, aluminium ≈ 26 GPa, copper ≈ 44 GPa, rubber ≈ 0.0006 GPa' }, steps: [x.mode === 'tg' ? `G = ${num(x.tau / 1e6)} MPa ÷ ${num(x.gamma)} = ${num(G / 1e9)} GPa` : `G = ${num(x.E / 1e9)} ÷ (2 × ${num(1 + x.nu)}) = ${num(G / 1e9)} GPa`] };
        },
    },
    shear_strain: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { disp: 'Sideways displacement and height', stress: 'Shear stress and shear modulus' }, 'disp'], dx: ['Sideways displacement', 'length', 'mm', 0.5], h: ['Height', 'length', 'mm', 100], tau: ['Shear stress', 'pressure', 'mpa', 50], G: ['Shear modulus', 'pressure', 'gpa', 79.3] },
        show: { dx: 'mode:disp', h: 'mode:disp', tau: 'mode:stress', G: 'mode:stress' },
        when: { dx: (x) => x.mode === 'disp', h: (x) => x.mode === 'disp', tau: (x) => x.mode === 'stress', G: (x) => x.mode === 'stress' },
        label: 'Shear strain γ',
        rows: { deg: 'Angle of distortion', micro: 'In microstrain' },
        run: (x) => {
            const g = x.mode === 'disp' ? Math.atan(x.dx / x.h) : x.tau / x.G;

            return { value: num(g, 5), unit: 'rad', sub: `${num(g / D)}°`, rows: { deg: `${num(g / D)}°`, micro: `${num(g * 1e6)} µrad` }, steps: [x.mode === 'disp' ? 'γ = atan(Δx ÷ h) ≈ Δx ÷ h' : 'γ = τ ÷ G', `= ${num(g)} rad`] };
        },
    },
    shear_stress: {
        type: 'calc',
        inputs: { mode: ['Situation', 'select', { direct: 'Direct shear (bolt, pin): F ÷ A', torsion: 'Shaft in torsion: Tr ÷ J', beam_rect: 'Beam, rectangular section', beam_round: 'Beam, solid round section' }, 'direct'], F: ['Shear force', 'force', 'kn', 10], A: ['Shear area', 'area', 'mm2', 78.54], planes: ['Shear planes (2 for double shear)', null, null, 1, 1], T: ['Torque', 'torque', 'nm', 500], d: ['Diameter', 'length', 'mm', 40], b: ['Width', 'length', 'mm', 50], h: ['Depth', 'length', 'mm', 100] },
        show: { F: 'mode:direct,beam_rect,beam_round', A: 'mode:direct', planes: 'mode:direct', T: 'mode:torsion', d: 'mode:torsion,beam_round', b: 'mode:beam_rect', h: 'mode:beam_rect' },
        when: { F: (x) => x.mode !== 'torsion', A: (x) => x.mode === 'direct', planes: (x) => x.mode === 'direct', T: (x) => x.mode === 'torsion', d: (x) => ['torsion', 'beam_round'].includes(x.mode), b: (x) => x.mode === 'beam_rect', h: (x) => x.mode === 'beam_rect' },
        out: 'pressure',
        outUnit: 'mpa',
        label: 'Shear stress',
        rows: { avg: ['Average shear stress', 'pressure'], note: 'Where' },
        run: (x) => {
            if (x.mode === 'direct') {
                const t = x.F / (x.A * x.planes);

                return { value: t, sub: 'τ = F ÷ (nA)', rows: { avg: [t, 'pressure'], note: 'Average over the sheared area' }, steps: [`τ = ${num(x.F)} N ÷ (${num(x.planes)} × ${num(x.A * 1e6)} mm²) = ${num(t / 1e6)} MPa`] };
            }

            if (x.mode === 'torsion') {
                const J = (Math.PI * x.d ** 4) / 32;
                const t = (x.T * x.d) / 2 / J;

                return { value: t, sub: 'τ = Tr ÷ J = 16T ÷ πd³', rows: { avg: [t / (4 / 3), 'pressure'], note: 'Maximum at the outer surface' }, steps: [`τ = 16 × ${num(x.T)} ÷ (π × ${num(x.d)}³) = ${num(t / 1e6)} MPa`] };
            }

            const A = x.mode === 'beam_rect' ? x.b * x.h : (Math.PI * x.d * x.d) / 4;
            const k = x.mode === 'beam_rect' ? 1.5 : 4 / 3;

            return { value: (k * x.F) / A, sub: `τ_max = ${x.mode === 'beam_rect' ? '1.5' : '4/3'} V ÷ A (from τ = VQ ÷ It)`, rows: { avg: [x.F / A, 'pressure'], note: 'Maximum at the neutral axis' }, steps: [`A = ${num(A * 1e6)} mm²`, `τ_max = ${num(k)} × ${num(x.F)} ÷ ${num(A)} = ${num((k * x.F) / A / 1e6)} MPa`] };
        },
    },
    shear_wave: {
        type: 'calc',
        inputs: { mode: ['Material', 'select', { list: 'Pick a material', custom: 'Enter G and density' }, 'list'], mat: ['Material', 'select', 'data:materials:fixed', 'a36'], G: ['Shear modulus', 'pressure', 'gpa', 0.1], rho: ['Density', 'density', 'kgm3', 1900] },
        show: { mat: 'mode:list', G: 'mode:custom', rho: 'mode:custom' },
        when: { G: (x) => x.mode === 'custom', rho: (x) => x.mode === 'custom' },
        data: ['materials'],
        out: 'speed',
        outUnit: 'ms',
        label: 'Shear wave velocity',
        rows: { G: ['Shear modulus used', 'pressure'], soil: 'Soil classes (Vs30)' },
        run: (x, ctx) => {
            const m = mat(x, ctx);
            const G = x.mode === 'custom' ? x.G : (m.E * 1e9) / (2 * (1 + m.nu));
            const rho = x.mode === 'custom' ? x.rho : m.density;

            return { value: Math.sqrt(G / rho), sub: 'v_s = √(G ÷ ρ)', rows: { G: [G, 'pressure'], soil: 'Soft clay < 180 m/s, stiff soil 180–360, dense soil 360–760, rock > 760 (NEHRP site classes)' }, steps: [`v_s = √(${num(G)} ÷ ${num(rho)}) = ${num(Math.sqrt(G / rho))} m/s`] };
        },
    },
    slenderness: {
        type: 'calc',
        inputs: { L: ['Column length', 'length', 'm', 3], ends: ['End conditions', 'select', ENDS_OPTIONS, 'pp'], ...SECTION_INPUTS, E: ["Young's modulus (for the transition)", 'pressure', 'gpa', 200], sy: ['Yield strength (for the transition)', 'pressure', 'mpa', 250] },
        show: SECTION_SHOW,
        when: SECTION_WHEN,
        optional: ['E', 'sy'],
        label: 'Slenderness ratio',
        rows: { r: ['Radius of gyration', 'length'], lc: 'Transition slenderness √(2π²E ÷ σy)', kind: 'Column type' },
        run: (x) => {
            const s = section(x);

            if (!s) {
                return { error: 'The wall is too thick for that diameter.' };
            }

            const r = Math.sqrt(s.I / s.A);
            const lam = (ENDS[x.ends][1] * x.L) / r;
            const lc = Number.isFinite(x.E) && Number.isFinite(x.sy) ? Math.sqrt((2 * Math.PI ** 2 * x.E) / x.sy) : NaN;

            return { value: num(lam, 4), sub: `r = ${num(r * 1000)} mm`, rows: { r: [r, 'length'], lc: Number.isFinite(lc) ? num(lc, 4) : 'Enter E and yield strength', kind: Number.isFinite(lc) ? (lam > lc ? 'Long (Euler buckling governs)' : 'Intermediate or short (inelastic buckling, Johnson)') : lam > 120 ? 'Slender' : 'Stocky to intermediate' }, steps: ['λ = KL ÷ r, r = √(I ÷ A)', `= ${num(ENDS[x.ends][1])} × ${num(x.L)} ÷ ${num(r)} = ${num(lam)}`] };
        },
    },
    specific_gravity: {
        type: 'calc',
        inputs: { rho: ['Density', 'density', 'kgm3', 850], ref: ['Reference water', 'select', { t4: 'Water at 4 °C (999.972 kg/m³)', t60: 'Water at 60 °F / 15.6 °C (999.016 kg/m³)', t20: 'Water at 20 °C (998.207 kg/m³)' }, 't4'] },
        label: 'Specific gravity',
        rows: { api: 'API gravity (petroleum, 60 °F reference)', floats: 'In water' },
        run: (x) => {
            const ref = { t4: 999.972, t60: 999.016, t20: 998.207 }[x.ref];
            const sg = x.rho / ref;
            const sg60 = x.rho / 999.016;

            return { value: num(sg, 5), sub: `ρ ÷ ${num(ref)} kg/m³`, rows: { api: `${num(141.5 / sg60 - 131.5, 4)}°`, floats: sg < 1 ? 'Floats' : sg > 1 ? 'Sinks' : 'Neutral' }, steps: ['SG = ρ ÷ ρ_water', `= ${num(x.rho)} ÷ ${num(ref)} = ${num(sg)}`] };
        },
    },
    stiffness_matrix: {
        type: 'calc',
        inputs: { el: ['Element', 'select', { spring: 'Spring (1D, 2 DOF)', bar: 'Bar (axial, 2 DOF)', truss: '2D truss bar (4 DOF)', beam: 'Euler–Bernoulli beam (4 DOF)' }, 'truss'], k: ['Spring constant', 'stiffness', 'knpm', 100], E: ["Young's modulus", 'pressure', 'gpa', 200], A: ['Area', 'area', 'mm2', 500], I: ['Second moment I', 'area_moment', 'cm4', 500], L: ['Length', 'length', 'm', 2], angle: ['Angle from the x-axis', 'angle', 'deg', 30] },
        show: { k: 'el:spring', E: 'el:bar,truss,beam', A: 'el:bar,truss', I: 'el:beam', L: 'el:bar,truss,beam', angle: 'el:truss' },
        when: { k: (x) => x.el === 'spring', E: (x) => x.el !== 'spring', A: (x) => ['bar', 'truss'].includes(x.el), I: (x) => x.el === 'beam', L: (x) => x.el !== 'spring', angle: (x) => x.el === 'truss' },
        label: 'Element stiffness',
        rows: { dofs: 'Degrees of freedom', units: 'Units' },
        grids: [['K', 'Element stiffness matrix [k]']],
        run: (x) => {
            let kmat;
            let factor;
            let dofs;
            let unit = 'N/m';

            if (x.el === 'spring' || x.el === 'bar') {
                factor = x.el === 'spring' ? x.k : (x.E * x.A) / x.L;
                kmat = [[1, -1], [-1, 1]];
                dofs = ['u₁', 'u₂'];
            } else if (x.el === 'truss') {
                factor = (x.E * x.A) / x.L;
                const c = Math.cos(x.angle);
                const s = Math.sin(x.angle);
                const q = [[c * c, c * s], [c * s, s * s]];
                kmat = [0, 1, 2, 3].map((i) => [0, 1, 2, 3].map((j) => (i < 2) === (j < 2) ? q[i % 2][j % 2] : -q[i % 2][j % 2]));
                dofs = ['u₁', 'v₁', 'u₂', 'v₂'];
            } else {
                const L = x.L;
                factor = (x.E * x.I) / L ** 3;
                kmat = [[12, 6 * L, -12, 6 * L], [6 * L, 4 * L * L, -6 * L, 2 * L * L], [-12, -6 * L, 12, -6 * L], [6 * L, 2 * L * L, -6 * L, 4 * L * L]];
                dofs = ['v₁', 'θ₁', 'v₂', 'θ₂'];
                unit = 'N/m, N, N·m/rad (by position)';
            }

            const fmt = (v) => num(Math.abs(v * factor) < 1e-9 * Math.abs(factor) ? 0 : v * factor, 5);

            return { value: num(factor, 6), unit: x.el === 'beam' ? 'N/m (EI/L³)' : 'N/m', sub: x.el === 'beam' ? 'Common factor EI/L³' : 'Common factor (EA/L or k)', rows: { dofs: dofs.join(', '), units: unit }, steps: [...(x.el === 'truss' ? ['k = (EA/L) [[c², cs, −c², −cs], [cs, s², −cs, −s²], …]', 'c = cos θ, s = sin θ'] : [ x.el === 'beam' ? 'k = (EI/L³) [[12, 6L, −12, 6L], [6L, 4L², −6L, 2L²], …]' : 'k = factor × [[1, −1], [−1, 1]]']), `Factor = ${num(factor)}`], grids: { K: { columns: dofs, rows: kmat.map((row, i) => ({ header: dofs[i], cells: row.map(fmt) })) } } };
        },
    },
    stress: pw({ vars: { s: ['Normal stress', 'pressure', 'mpa', 100], F: ['Force', 'force', 'kn', 50], A: ['Cross-section area', 'area', 'mm2', 500] }, out: 's', exp: { F: 1, A: -1 }, eq: 'σ = F ÷ A', forms: { s: 'σ = F ÷ A', F: 'F = σA', A: 'A = F ÷ σ' } }),
    scf: {
        type: 'calc',
        inputs: { geom: ['Geometry', 'select', { hole: 'Circular hole in a plate under tension', ellipse: 'Elliptical hole in a wide plate (Inglis)' }, 'hole'], d: ['Hole diameter', 'length', 'mm', 10], W: ['Plate width', 'length', 'mm', 50], t: ['Plate thickness', 'length', 'mm', 5], F: ['Tension force (optional)', 'force', 'kn', 10], a: ['Semi-axis across the load', 'length', 'mm', 10], b: ['Semi-axis along the load', 'length', 'mm', 2] },
        show: { d: 'geom:hole', W: 'geom:hole', t: 'geom:hole', F: 'geom:hole', a: 'geom:ellipse', b: 'geom:ellipse' },
        when: { d: (x) => x.geom === 'hole', W: (x) => x.geom === 'hole', t: (x) => x.geom === 'hole', a: (x) => x.geom === 'ellipse', b: (x) => x.geom === 'ellipse' },
        optional: ['F'],
        label: 'Stress concentration factor Kt',
        rows: { nominal: 'Nominal (net-section) stress', peak: 'Peak stress at the edge of the hole' },
        run: (x) => {
            if (x.geom === 'ellipse') {
                const kt = 1 + (2 * x.a) / x.b;

                return { value: num(kt, 4), sub: 'Kt = 1 + 2a ÷ b', rows: { nominal: 'Far-field stress σ', peak: `${num(kt, 4)} σ` }, steps: ['Inglis (1913): σ_max = σ(1 + 2a/b), a across the load', `= ${num(kt)}`, 'A crack (b → 0) gives an unlimited Kt: use fracture mechanics instead'] };
            }

            const r = x.d / x.W;

            if (!(r > 0 && r < 1)) {
                return { error: 'The hole must be narrower than the plate.' };
            }

            const kt = 2 + 0.284 * (1 - r) - 0.6 * (1 - r) ** 2 + 1.32 * (1 - r) ** 3;
            const nom = Number.isFinite(x.F) ? x.F / ((x.W - x.d) * x.t) : NaN;

            return { value: num(kt, 4), sub: `d/W = ${num(r, 3)}, based on the net section`, rows: { nominal: Number.isFinite(nom) ? `${num(nom / 1e6)} MPa` : 'Enter a force', peak: Number.isFinite(nom) ? `${num((kt * nom) / 1e6)} MPa` : 'Enter a force' }, steps: ['Kt,net = 2 + 0.284(1 − d/W) − 0.600(1 − d/W)² + 1.32(1 − d/W)³ (Heywood fit to Howland; Peterson chart 4.1, valid 0 < d/W < 1)', `= ${num(kt)}`, 'Elastic value: ductile metals under static load yield locally and redistribute the peak'] };
        },
    },
    thermal_stress: {
        type: 'calc',
        inputs: { ...MAT, E: ["Young's modulus", 'pressure', 'gpa', 200], alpha: ['Expansion coefficient (10⁻⁶/K)', null, null, 12], dT: ['Temperature change', 'temperature_difference', 'k', 50], L: ['Length (for free expansion)', 'length', 'm', 10] },
        show: { E: 'mat:custom', alpha: 'mat:custom' },
        when: { E: (x) => x.mat === 'custom', alpha: (x) => x.mat === 'custom' },
        optional: ['L'],
        data: ['materials'],
        out: 'pressure',
        outUnit: 'mpa',
        label: 'Thermal stress (fully restrained)',
        rows: { free: ['Free expansion over that length', 'length'], strain: 'Thermal strain', yield: 'Compared with yield' },
        run: (x, ctx) => {
            const E = youngOf(x, ctx);
            const a = (x.mat === 'custom' ? x.alpha : mat(x, ctx).alpha) * 1e-6;
            const sy = x.mat === 'custom' ? NaN : (mat(x, ctx).yield ?? mat(x, ctx).uts) * 1e6;
            const s = E * a * x.dT;

            return { value: s, sub: x.dT > 0 ? 'Compression when heated' : 'Tension when cooled', rows: { free: Number.isFinite(x.L) ? [a * x.dT * x.L, 'length'] : 'Enter a length', strain: `${num(a * x.dT * 1e6)} µε`, yield: Number.isFinite(sy) ? `${num((Math.abs(s) / sy) * 100, 4)}% of ${mat(x, ctx).yield ? 'yield' : 'strength'}` : 'Enter a material' }, steps: ['σ = E α ΔT', `= ${num(E / 1e9)} GPa × ${num(a * 1e6)} × 10⁻⁶/K × ${num(x.dT)} K = ${num(s / 1e6)} MPa`] };
        },
    },
    torsional_constant: {
        type: 'calc',
        inputs: { shape: ['Section', 'select', { round: 'Solid round', tube: 'Round tube', rect: 'Solid rectangle', closed: 'Thin-walled closed section', open: 'Thin-walled open section (angle, channel, I)' }, 'rect'], d: ['Outer diameter', 'length', 'mm', 50], di: ['Inner diameter', 'length', 'mm', 40], a: ['Long side', 'length', 'mm', 100], b: ['Short side', 'length', 'mm', 20], Am: ['Area enclosed by the wall mid-line', 'area', 'mm2', 5000], per: ['Mid-line perimeter', 'length', 'mm', 300], tw: ['Wall thickness', 'length', 'mm', 3], segs: ['Open-section parts: length, thickness in mm (one per line)', 'textarea', null, '100, 8\n100, 8\n184, 5'] },
        show: { d: 'shape:round,tube', di: 'shape:tube', a: 'shape:rect', b: 'shape:rect', Am: 'shape:closed', per: 'shape:closed', tw: 'shape:closed', segs: 'shape:open' },
        when: { d: (x) => ['round', 'tube'].includes(x.shape), di: (x) => x.shape === 'tube', a: (x) => x.shape === 'rect', b: (x) => x.shape === 'rect', Am: (x) => x.shape === 'closed', per: (x) => x.shape === 'closed', tw: (x) => x.shape === 'closed' },
        out: 'area_moment',
        outUnit: 'mm4',
        label: 'Torsional constant J',
        rows: { method: 'Method' },
        run: (x) => {
            if (x.shape === 'round' || x.shape === 'tube') {
                const J = (Math.PI * (x.d ** 4 - (x.shape === 'tube' ? x.di ** 4 : 0))) / 32;

                return { value: J, sub: 'J = π(D⁴ − d⁴) ÷ 32', rows: { method: 'Exact (equal to the polar moment)' }, steps: [`J = ${num(J * 1e12)} mm⁴`] };
            }

            if (x.shape === 'rect') {
                const [a, b] = [Math.max(x.a, x.b), Math.min(x.a, x.b)];
                let sum = 0;

                for (let n = 1; n < 400; n += 2) {
                    sum += Math.tanh((n * Math.PI * a) / (2 * b)) / n ** 5;
                }

                const beta = (1 / 3) * (1 - ((192 / Math.PI ** 5) * (b / a)) * sum);
                const J = beta * a * b ** 3;

                return { value: J, sub: `β = ${num(beta, 5)} (a/b = ${num(a / b, 4)})`, rows: { method: 'Saint-Venant series, summed to convergence' }, steps: ['J = β a b³, β = ⅓[1 − (192/π⁵)(b/a) Σ tanh(nπa/2b) ÷ n⁵], n odd', `β = ${num(beta)}, J = ${num(J * 1e12)} mm⁴`] };
            }

            if (x.shape === 'closed') {
                const J = (4 * x.Am ** 2 * x.tw) / x.per;

                return { value: J, sub: 'Bredt: J = 4A²t ÷ perimeter', rows: { method: 'Thin-walled closed section (Bredt–Batho)' }, steps: [`J = 4 × ${num(x.Am * 1e6)}² × ${num(x.tw * 1000)} ÷ ${num(x.per * 1000)} = ${num(J * 1e12)} mm⁴`] };
            }

            const parts = String(x.segs).split(/\n|;/).map((l) => l.trim()).filter(Boolean).map((l) => l.split(/[,\s]+/).map(Number));

            if (!parts.length || parts.some((p) => p.length !== 2 || !p.every((v) => v > 0))) {
                return { empty: 'Type each flat part as length, thickness (mm), one per line.' };
            }

            const J = parts.reduce((s, [l, t]) => s + (l * t ** 3) / 3, 0) * 1e-12;

            return { value: J, sub: 'J ≈ Σ b t³ ÷ 3', rows: { method: 'Thin-walled open section (sum of thin rectangles); open sections are far weaker in torsion than closed ones' }, steps: parts.map(([l, t]) => `${num(l)} × ${num(t)}³ ÷ 3 = ${num((l * t ** 3) / 3)} mm⁴`).concat([`J = ${num(J * 1e12)} mm⁴`]) };
        },
    },
    torsional_stiffness: {
        type: 'calc',
        inputs: { G: ['Shear modulus', 'pressure', 'gpa', 79.3], d: ['Outer diameter', 'length', 'mm', 40], di: ['Inner diameter (0 for solid)', 'length', 'mm', 0], L: ['Length', 'length', 'm', 1] },
        optional: ['di'],
        out: 'rotational_stiffness',
        outUnit: 'nmrad',
        label: 'Torsional stiffness',
        rows: { perdeg: 'Per degree', J: ['Polar moment J', 'area_moment'] },
        run: (x) => {
            const J = (Math.PI * (x.d ** 4 - (Number.isFinite(x.di) ? x.di : 0) ** 4)) / 32;
            const k = (x.G * J) / x.L;

            return { value: k, sub: `${num(k * D)} N·m per degree`, rows: { perdeg: `${num(k * D)} N·m/°`, J: [J, 'area_moment'] }, steps: ['k = GJ ÷ L', `= ${num(x.G / 1e9)} GPa × ${num(J)} m⁴ ÷ ${num(x.L)} m = ${num(k)} N·m/rad`] };
        },
    },
    true_strain: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { lengths: 'Original and final lengths', eng: 'Engineering strain' }, 'lengths'], L0: ['Original length', 'length', 'mm', 50], L: ['Final length', 'length', 'mm', 60], e: ['Engineering strain', null, null, 0.2], s: ['Engineering stress (optional)', 'pressure', 'mpa', 400] },
        show: { L0: 'mode:lengths', L: 'mode:lengths', e: 'mode:eng' },
        when: { L0: (x) => x.mode === 'lengths', L: (x) => x.mode === 'lengths', e: (x) => x.mode === 'eng' },
        optional: ['s'],
        label: 'True strain',
        rows: { eng: 'Engineering strain', ts: 'True stress (constant volume)' },
        run: (x) => {
            const e = x.mode === 'lengths' ? (x.L - x.L0) / x.L0 : x.e;

            if (!(e > -1)) {
                return { error: 'The final length must be positive.' };
            }

            const et = Math.log(1 + e);

            return { value: num(et, 5), sub: `Engineering strain ${num(e, 5)}`, rows: { eng: num(e, 5), ts: Number.isFinite(x.s) ? `${num((x.s * (1 + e)) / 1e6)} MPa` : 'Enter an engineering stress' }, steps: ['ε_t = ln(L ÷ L₀) = ln(1 + ε)', `= ln(${num(1 + e)}) = ${num(et)}`, 'σ_t = σ(1 + ε), valid up to necking'] };
        },
    },
    vickers: {
        type: 'calc',
        inputs: { F: ['Test force', 'force', 'kgf', 10], d1: ['Diagonal 1', 'length', 'mm', 0.3], d2: ['Diagonal 2', 'length', 'mm', 0.31] },
        label: 'Vickers hardness',
        rows: { d: 'Mean diagonal', depth: 'Indentation depth', uts: 'Approximate tensile strength (steels)' },
        run: (x) => {
            const d = ((x.d1 + x.d2) / 2) * 1000;
            const hv = (1.8544 * (x.F / g0)) / (d * d);

            return { value: num(hv, 4), unit: 'HV', sub: `HV${num(x.F / g0, 3)}`, rows: { d: `${num(d, 4)} mm`, depth: `${num((d / 7) * 1000, 4)} µm`, uts: `≈ ${num(3.3 * hv, 3)} MPa (rule of thumb UTS ≈ 3.3 × HV)` }, steps: ['HV = 1.8544 F ÷ d², F in kgf, d in mm (136° pyramid)', `= 1.8544 × ${num(x.F / g0)} ÷ ${num(d)}² = ${num(hv)}`] };
        },
    },
    volume_mass: {
        type: 'calc',
        inputs: { sub: ['Material', 'select', 'data:densities', 'water'], rho: ['Density', 'density', 'kgm3', 1000], V: ['Volume', 'volume', 'l', 10] },
        show: { rho: 'sub:custom' },
        when: { rho: (x) => x.sub === 'custom' },
        data: ['densities'],
        out: 'mass',
        outUnit: 'kg',
        label: 'Mass',
        rows: { rho: ['Density used', 'density'], weight: ['Weight', 'force'] },
        run: (x, ctx) => {
            const rho = x.sub === 'custom' ? x.rho : ctx.c.data.physics.densities[x.sub].density;

            return { value: rho * x.V, sub: `ρ = ${num(rho)} kg/m³`, rows: { rho: [rho, 'density'], weight: [rho * x.V * g0, 'force'] }, steps: ['m = ρV', `= ${num(rho)} kg/m³ × ${num(x.V)} m³ = ${num(rho * x.V)} kg`] };
        },
    },
    von_mises: {
        type: 'calc',
        inputs: { mode: ['Stress state', 'select', { plane: 'Plane stress (σx, σy, τxy)', full: 'General 3D' }, 'plane'], sx: ['σx', 'pressure', 'mpa', 120], sy: ['σy', 'pressure', 'mpa', -50], sz: ['σz', 'pressure', 'mpa', 0], txy: ['τxy', 'pressure', 'mpa', 40], tyz: ['τyz', 'pressure', 'mpa', 0], tzx: ['τzx', 'pressure', 'mpa', 0], sy0: ['Yield strength (optional)', 'pressure', 'mpa', 250] },
        show: { sz: 'mode:full', tyz: 'mode:full', tzx: 'mode:full' },
        when: { sz: (x) => x.mode === 'full', tyz: (x) => x.mode === 'full', tzx: (x) => x.mode === 'full' },
        optional: ['sy0'],
        out: 'pressure',
        outUnit: 'mpa',
        label: 'Von Mises stress',
        rows: { fos: 'Factor of safety against yield', tresca: ['Tresca equivalent (2 τ_max)', 'pressure'] },
        run: (x) => {
            const sz = x.mode === 'full' ? x.sz : 0;
            const tyz = x.mode === 'full' ? x.tyz : 0;
            const tzx = x.mode === 'full' ? x.tzx : 0;
            const vm = Math.sqrt(0.5 * ((x.sx - x.sy) ** 2 + (x.sy - sz) ** 2 + (sz - x.sx) ** 2) + 3 * (x.txy ** 2 + tyz ** 2 + tzx ** 2));
            const p = principal(x.sx, x.sy, x.txy);
            const tresca = x.mode === 'plane' ? Math.max(p.s1, p.s2, 0) - Math.min(p.s1, p.s2, 0) : NaN;

            return { value: vm, sub: Number.isFinite(x.sy0) ? `Factor of safety ${num(x.sy0 / vm, 4)}` : 'Distortion-energy criterion', rows: { fos: Number.isFinite(x.sy0) ? `${num(x.sy0 / vm, 4)}${x.sy0 < vm ? ' (yields)' : ''}` : 'Enter a yield strength', tresca: Number.isFinite(tresca) ? [tresca, 'pressure'] : 'Shown for plane stress' }, steps: ['σ_vm = √(½[(σx − σy)² + (σy − σz)² + (σz − σx)²] + 3(τxy² + τyz² + τzx²))', `= ${num(vm / 1e6)} MPa`] };
        },
    },
    youngs_modulus: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { ss: 'Stress and strain', test: 'Force, area and lengths (tensile test)' }, 'test'], s: ['Stress', 'pressure', 'mpa', 200], e: ['Strain', null, null, 0.001], F: ['Force', 'force', 'kn', 20], A: ['Cross-section area', 'area', 'mm2', 100], L0: ['Original length', 'length', 'mm', 50], dL: ['Extension', 'length', 'mm', 0.05] },
        show: { s: 'mode:ss', e: 'mode:ss', F: 'mode:test', A: 'mode:test', L0: 'mode:test', dL: 'mode:test' },
        when: { s: (x) => x.mode === 'ss', e: (x) => x.mode === 'ss', F: (x) => x.mode === 'test', A: (x) => x.mode === 'test', L0: (x) => x.mode === 'test', dL: (x) => x.mode === 'test' },
        out: 'pressure',
        outUnit: 'gpa',
        label: "Young's modulus E",
        rows: { stress: ['Stress', 'pressure'], strain: 'Strain', like: 'Closest common material' },
        run: (x) => {
            const s = x.mode === 'ss' ? x.s : x.F / x.A;
            const e = x.mode === 'ss' ? x.e : x.dL / x.L0;
            const E = s / e;
            const list = [['rubber', 0.05], ['nylon', 2.9], ['oak (along the grain)', 11], ['concrete', 30], ['aluminium', 69], ['glass', 72], ['brass', 100], ['titanium', 114], ['copper', 117], ['steel', 200], ['tungsten', 411]];
            const like = list.reduce((a, b) => (Math.abs(Math.log(b[1] / (E / 1e9))) < Math.abs(Math.log(a[1] / (E / 1e9))) ? b : a));

            return { value: E, sub: `σ = ${num(s / 1e6)} MPa, ε = ${num(e)}`, rows: { stress: [s, 'pressure'], strain: num(e), like: `${like[0]} (≈ ${like[1]} GPa)` }, steps: ['E = σ ÷ ε', `= ${num(s)} Pa ÷ ${num(e)} = ${num(E / 1e9)} GPa`, 'Valid only in the linear elastic range'] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
