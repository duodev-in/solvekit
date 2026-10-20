import { defineTools } from '../engines/formula.js';
import { airViscosity, standardAtmosphere, waterDensity, waterViscosity } from '../physics/air.js';
import { bisect, D, handlersFor, K, num, pw } from '../physics/core.js';

/**
 * Fluid mechanics: pressure, buoyancy, pipe and channel flow, drag and compressible flow.
 */
const g0 = K.g0;
const fluid = (ctx, key) => ctx.c.data.physics.fluids[key];
const FLUID = (def = 'water') => ['Fluid', 'select', 'data:fluids', def];
const customFluid = { rho: ['Fluid density', 'density', 'kgm3', 1000], mu: ['Dynamic viscosity', 'viscosity', 'cp', 1] };
/** Density and viscosity of the chosen fluid at 20 °C, or the typed values. */
const fluidProps = (x, ctx) => (x.fluid === 'custom' ? [x.rho, x.mu] : [fluid(ctx, x.fluid).density, fluid(ctx, x.fluid).mu]);
const fluidShow = (extra = {}) => ({ rho: 'fluid:custom', mu: 'fluid:custom', ...extra });
const fluidWhen = (extra = {}) => ({ rho: (x) => x.fluid === 'custom', mu: (x) => x.fluid === 'custom', ...extra });

/** Darcy friction factor: laminar 64/Re, else Colebrook–White iterated from Swamee–Jain. */
export function friction(Re, rel) {
    if (Re < 2300) {
        return 64 / Re;
    }

    let f = 0.25 / Math.log10(rel / 3.7 + 5.74 / Re ** 0.9) ** 2;

    for (let k = 0; k < 50; k += 1) {
        const next = (-2 * Math.log10(rel / 3.7 + 2.51 / (Re * Math.sqrt(f)))) ** -2;

        if (Math.abs(next - f) < 1e-14) {
            return next;
        }

        f = next;
    }

    return f;
}

const regime = (Re) => (Re < 2300 ? 'Laminar' : Re < 4000 ? 'Transitional (unpredictable)' : 'Turbulent');

/** Wetted area and perimeter of a channel section at depth y. */
function channel(x) {
    const y = x.y;

    switch (x.shape) {
        case 'rect': return { A: x.b * y, P: x.b + 2 * y, T: x.b };
        case 'trap': return { A: (x.b + x.z * y) * y, P: x.b + 2 * y * Math.sqrt(1 + x.z * x.z), T: x.b + 2 * x.z * y };
        case 'tri': return { A: x.z * y * y, P: 2 * y * Math.sqrt(1 + x.z * x.z), T: 2 * x.z * y };
        default: {
            const r = x.d / 2;
            const yy = Math.min(y, x.d);
            const th = 2 * Math.acos((r - yy) / r);

            return { A: (r * r * (th - Math.sin(th))) / 2, P: r * th, T: 2 * Math.sqrt(Math.max(0, yy * (x.d - yy))) };
        }
    }
}

const CHANNEL_INPUTS = { shape: ['Channel', 'select', { rect: 'Rectangular', trap: 'Trapezoidal', tri: 'Triangular (V)', circle: 'Circular pipe, part full' }, 'trap'], b: ['Bottom width', 'length', 'm', 2], z: ['Side slope (horizontal per 1 vertical)', null, null, 1.5, 0], d: ['Pipe diameter', 'length', 'm', 1], y: ['Water depth', 'length', 'm', 0.8] };
const CHANNEL_SHOW = { b: 'shape:rect,trap', z: 'shape:trap,tri', d: 'shape:circle' };
const CHANNEL_WHEN = { b: (x) => ['rect', 'trap'].includes(x.shape), z: (x) => ['trap', 'tri'].includes(x.shape), d: (x) => x.shape === 'circle' };
const DRAG_SHAPES = { plate: ['Flat plate facing the wind (square)', 1.17], long_plate: ['Long flat plate or sign', 1.98], cylinder: ['Long cylinder (pole)', 1.2], sphere: ['Sphere', 0.47], cube: ['Cube', 1.05], person: ['Standing person', 1.0], car: ['Car (typical)', 0.3], custom: ['Other (enter C_d)', null] };
const SHAPE_OPTIONS = Object.fromEntries(Object.entries(DRAG_SHAPES).map(([k, v]) => [k, v[0]]));

export const TOOLS = {
    api_gravity: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { sg: 'Specific gravity (60 °F)', rho: 'Density at 60 °F', api: 'API gravity' }, 'sg'], sg: ['Specific gravity', null, null, 0.85, 0], rho: ['Density', 'density', 'kgm3', 850], api: ['API gravity (°)', null, null, 35] },
        show: { sg: 'mode:sg', rho: 'mode:rho', api: 'mode:api' },
        when: { sg: (x) => x.mode === 'sg', rho: (x) => x.mode === 'rho', api: (x) => x.mode === 'api' },
        label: 'API gravity',
        rows: { sg: 'Specific gravity', rho: 'Density', grade: 'Grade' },
        run: (x) => {
            const sg = x.mode === 'sg' ? x.sg : x.mode === 'rho' ? x.rho / 999.016 : 141.5 / (x.api + 131.5);
            const api = 141.5 / sg - 131.5;

            return { value: `${num(api, 4)}°`, sub: `SG ${num(sg, 5)}`, rows: { sg: num(sg, 5), rho: `${num(sg * 999.016, 5)} kg/m³`, grade: api > 31.1 ? 'Light crude' : api > 22.3 ? 'Medium crude' : api > 10 ? 'Heavy crude' : 'Extra heavy (sinks in water)' }, steps: ['API = 141.5 ÷ SG − 131.5 (SG at 60 °F)', `= 141.5 ÷ ${num(sg)} − 131.5 = ${num(api)}°`] };
        },
    },
    archimedes: pw({ vars: { F: ['Buoyant force', 'force', 'n', 9.789], rho: ['Fluid density', 'density', 'kgm3', 998.2], V: ['Displaced volume', 'volume', 'l', 1], g: ['Gravity', 'acceleration', 'ms2', 9.80665] }, out: 'F', exp: { rho: 1, V: 1, g: 1 }, eq: 'F_b = ρ g V', forms: { F: 'F_b = ρgV', rho: 'ρ = F ÷ gV', V: 'V = F ÷ ρg', g: 'g = F ÷ ρV' }, rows: { mass: 'Mass that force could support' }, extra: (v) => ({ mass: `${num(v.F / g0)} kg` }) }),
    bernoulli: {
        type: 'law',
        vars: { P1: ['Pressure at point 1', 'pressure', 'kpa', 200], v1: ['Speed at point 1', 'speed', 'ms', 2], h1: ['Height of point 1', 'length', 'm', 0], P2: ['Pressure at point 2', 'pressure', 'kpa', 183.0], v2: ['Speed at point 2', 'speed', 'ms', 6], h2: ['Height of point 2', 'length', 'm', 0], rho: ['Density', 'density', 'kgm3', 1000] },
        default: 'P2',
        eq: 'P₁ + ½ρv₁² + ρgh₁ = P₂ + ½ρv₂² + ρgh₂',
        forms: { P2: 'P₂ = P₁ + ½ρ(v₁² − v₂²) + ρg(h₁ − h₂)', P1: 'P₁ = P₂ + ½ρ(v₂² − v₁²) + ρg(h₂ − h₁)', v2: 'v₂ = √(v₁² + 2(P₁ − P₂)/ρ + 2g(h₁ − h₂))', v1: 'v₁ = √(v₂² + 2(P₂ − P₁)/ρ + 2g(h₂ − h₁))', h2: 'h₂ = h₁ + (P₁ − P₂)/ρg + (v₁² − v₂²)/2g', h1: 'h₁ = h₂ + (P₂ − P₁)/ρg + (v₂² − v₁²)/2g', rho: 'ρ = (P₂ − P₁) ÷ (½(v₁² − v₂²) + g(h₁ − h₂))' },
        solve: {
            P2: (v) => v.P1 + 0.5 * v.rho * (v.v1 ** 2 - v.v2 ** 2) + v.rho * g0 * (v.h1 - v.h2),
            P1: (v) => v.P2 + 0.5 * v.rho * (v.v2 ** 2 - v.v1 ** 2) + v.rho * g0 * (v.h2 - v.h1),
            v2: (v) => Math.sqrt(v.v1 ** 2 + (2 * (v.P1 - v.P2)) / v.rho + 2 * g0 * (v.h1 - v.h2)),
            v1: (v) => Math.sqrt(v.v2 ** 2 + (2 * (v.P2 - v.P1)) / v.rho + 2 * g0 * (v.h2 - v.h1)),
            h2: (v) => v.h1 + (v.P1 - v.P2) / (v.rho * g0) + (v.v1 ** 2 - v.v2 ** 2) / (2 * g0),
            h1: (v) => v.h2 + (v.P2 - v.P1) / (v.rho * g0) + (v.v2 ** 2 - v.v1 ** 2) / (2 * g0),
            rho: (v) => (v.P2 - v.P1) / (0.5 * (v.v1 ** 2 - v.v2 ** 2) + g0 * (v.h1 - v.h2)),
        },
        rows: { head: 'Total head', dyn: 'Dynamic pressure at point 2' },
        extra: (v) => ({ head: `${num(v.P1 / (v.rho * g0) + v.v1 ** 2 / (2 * g0) + v.h1)} m`, dyn: `${num(0.5 * v.rho * v.v2 ** 2)} Pa` }),
    },
    broad_weir: {
        type: 'calc',
        inputs: { H: ['Head above the crest', 'length', 'm', 0.3], b: ['Crest width', 'length', 'm', 2], Cd: ['Discharge coefficient', null, null, 0.848, 0] },
        out: 'flow',
        outUnit: 'm3s',
        label: 'Flow rate',
        rows: { yc: ['Critical depth on the crest', 'length'], ls: 'In litres per second' },
        run: (x) => {
            const Q = x.Cd * x.b * Math.sqrt(g0) * ((2 / 3) * x.H) ** 1.5;

            return { value: Q, sub: `${num(Q * 1000)} L/s`, rows: { yc: [(2 / 3) * x.H, 'length'], ls: `${num(Q * 1000)} L/s` }, steps: ['Q = C_d b √g (2H/3)^1.5', `= ${num(x.Cd)} × ${num(x.b)} × √9.80665 × (${num((2 / 3) * x.H)})^1.5 = ${num(Q)} m³/s`, 'Approach velocity is ignored'] };
        },
    },
    buoyancy: {
        type: 'calc',
        inputs: { fluid: FLUID('water'), rho: customFluid.rho, V: ['Object volume', 'volume', 'l', 10], m: ['Object mass', 'mass', 'kg', 6] },
        show: { rho: 'fluid:custom' },
        when: { rho: (x) => x.fluid === 'custom' },
        data: ['fluids'],
        out: 'force',
        outUnit: 'n',
        label: 'Buoyant force when fully submerged',
        rows: { weight: ['Weight', 'force'], net: ['Net upward force when held under', 'force'], verdict: 'Floats?', sub: 'Share below the surface when floating' },
        run: (x, ctx) => {
            const [rho] = fluidProps(x, ctx);
            const Fb = rho * g0 * x.V;
            const W = x.m * g0;
            const dens = x.m / x.V;

            return { value: Fb, sub: dens < rho ? 'It floats' : dens > rho ? 'It sinks' : 'Neutrally buoyant', rows: { weight: [W, 'force'], net: [Fb - W, 'force'], verdict: dens < rho ? `Floats (object density ${num(dens)} kg/m³)` : `Sinks (object density ${num(dens)} kg/m³)`, sub: dens < rho ? `${num((dens / rho) * 100, 4)}%` : 'Fully submerged' }, steps: ['F_b = ρ_fluid g V', `= ${num(rho)} × 9.80665 × ${num(x.V)} = ${num(Fb)} N`, `Object density m/V = ${num(dens)} kg/m³ vs fluid ${num(rho)} kg/m³`] };
        },
    },
    discharge_coefficient: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { flows: 'Actual and theoretical flow', orifice: 'Measured flow through an orifice' }, 'orifice'], Qa: ['Actual flow', 'flow', 'lmin', 120], Qt: ['Theoretical flow', 'flow', 'lmin', 195], d: ['Orifice diameter', 'length', 'mm', 20], D: ['Pipe diameter (0 for a tank)', 'length', 'mm', 50], dP: ['Pressure difference', 'pressure', 'kpa', 50], rho: ['Fluid density', 'density', 'kgm3', 998] },
        show: { Qt: 'mode:flows', d: 'mode:orifice', D: 'mode:orifice', dP: 'mode:orifice', rho: 'mode:orifice' },
        when: { Qt: (x) => x.mode === 'flows', d: (x) => x.mode === 'orifice', D: (x) => x.mode === 'orifice', dP: (x) => x.mode === 'orifice', rho: (x) => x.mode === 'orifice' },
        label: 'Discharge coefficient C_d',
        rows: { Qt: 'Theoretical flow', typical: 'Typical values' },
        run: (x) => {
            const beta = x.D > 0 ? x.d / x.D : 0;
            const Qt = x.mode === 'flows' ? x.Qt : ((Math.PI * x.d * x.d) / 4) * Math.sqrt((2 * x.dP) / (x.rho * (1 - beta ** 4)));

            return { value: num(x.Qa / Qt, 4), sub: `Q_ideal = ${num(Qt * 60000)} L/min`, rows: { Qt: `${num(Qt * 60000)} L/min`, typical: 'Sharp-edged orifice ≈ 0.61, nozzle ≈ 0.96–0.99, venturi ≈ 0.98' }, steps: ['C_d = Q_actual ÷ Q_ideal', x.mode === 'orifice' ? 'Q_ideal = A √(2ΔP ÷ ρ(1 − β⁴))' : '', `C_d = ${num(x.Qa / Qt)}`].filter(Boolean) };
        },
    },
    cv_flow: {
        type: 'calc',
        inputs: { medium: ['Medium', 'select', { liquid: 'Liquid', gas: 'Gas' }, 'liquid'], Cv: ['Valve Cv', null, null, 5, 0], dP: ['Pressure drop', 'pressure', 'psi', 10], sg: ['Specific gravity (liquid: water = 1; gas: air = 1)', null, null, 1, 0], P1: ['Inlet pressure (absolute)', 'pressure', 'psi', 100], T: ['Gas temperature', 'temperature', 'f', 60] },
        show: { P1: 'medium:gas', T: 'medium:gas' },
        when: { P1: (x) => x.medium === 'gas', T: (x) => x.medium === 'gas' },
        label: 'Flow rate',
        rows: { si: 'In SI units', note: 'Flow state' },
        run: (x) => {
            const dp = x.dP / 6894.757;

            if (x.medium === 'liquid') {
                const gpm = x.Cv * Math.sqrt(dp / x.sg);

                return { value: num(gpm, 5), unit: 'US gpm', sub: `${num(gpm * 3.785411784, 5)} L/min`, rows: { si: `${num(gpm * 0.227125, 5)} m³/h`, note: 'Non-choked liquid flow' }, steps: ['Q = Cv √(ΔP ÷ SG), Q in US gpm, ΔP in psi', `= ${num(x.Cv)} × √(${num(dp)} ÷ ${num(x.sg)}) = ${num(gpm)} gpm`] };
            }

            const p1 = x.P1 / 6894.757;
            const T = x.T * 1.8;
            const choked = dp >= p1 / 2;
            const q = choked ? 0.471 * 22.67 * x.Cv * p1 * Math.sqrt(1 / (x.sg * T)) : 22.67 * x.Cv * p1 * (1 - (2 * dp) / (3 * p1)) * Math.sqrt(dp / (p1 * x.sg * T));

            return { value: num(q, 5), unit: 'SCFM', sub: choked ? 'Choked flow: more pressure drop adds no flow' : 'Sub-critical flow', rows: { si: `${num(q * 1.69901, 5)} Nm³/h (approx.)`, note: choked ? 'ΔP ≥ P₁/2' : 'ΔP < P₁/2' }, steps: ['Gas (Swagelok/ISA form): q = 22.67 Cv P₁(1 − 2ΔP/3P₁)√(ΔP ÷ (P₁ G T)), P in psia, T in °R', `q = ${num(q)} SCFM`] };
        },
    },
    cv_required: {
        type: 'calc',
        inputs: { Q: ['Flow rate', 'flow', 'gpm', 20], dP: ['Allowed pressure drop', 'pressure', 'psi', 10], sg: ['Specific gravity', null, null, 1, 0] },
        label: 'Required valve Cv',
        rows: { kv: 'Metric Kv', pick: 'Choose a valve with' },
        run: (x) => {
            const gpm = x.Q / 6.30901964e-5;
            const cv = gpm * Math.sqrt(x.sg / (x.dP / 6894.757));

            return { value: num(cv, 5), sub: `Kv ${num(cv / 1.156, 5)}`, rows: { kv: `${num(cv / 1.156, 5)} (m³/h at 1 bar)`, pick: `Cv of at least ${num(cv * 1.25, 3)} (25% margin) so it controls at 60–80% open` }, steps: ['Cv = Q √(SG ÷ ΔP) (ISA 75.01, liquid, non-choked)', `= ${num(gpm)} × √(${num(x.sg)} ÷ ${num(x.dP / 6894.757)}) = ${num(cv)}`, 'Kv = Cv ÷ 1.156'] };
        },
    },
    darcy_law: pw({ vars: { Q: ['Flow rate', 'flow', 'm3h', 0.36], K: ['Hydraulic conductivity (m/s)', null, null, 1e-4], A: ['Cross-section area', 'area', 'm2', 10], dh: ['Head difference', 'length', 'm', 2], L: ['Flow path length', 'length', 'm', 20] }, out: 'Q', exp: { K: 1, A: 1, dh: 1, L: -1 }, eq: 'Q = K A Δh ÷ L', forms: { Q: 'Q = KAΔh ÷ L', K: 'K = QL ÷ AΔh', A: 'A = QL ÷ KΔh', dh: 'Δh = QL ÷ KA', L: 'L = KAΔh ÷ Q' }, rows: { q: 'Darcy flux', i: 'Hydraulic gradient' }, extra: (v) => ({ q: `${num(v.Q / v.A)} m/s`, i: num(v.dh / v.L) }) }),
    darcy_weisbach: {
        type: 'calc',
        inputs: { Q: ['Flow rate', 'flow', 'lmin', 200], D: ['Inside diameter', 'length', 'mm', 50], L: ['Pipe length', 'length', 'm', 100], pipe: ['Pipe material', 'select', 'data:roughness', 'steel'], e: ['Roughness', 'length', 'mm', 0.045], fluid: FLUID('water'), ...customFluid },
        show: fluidShow({ e: 'pipe:custom' }),
        when: fluidWhen({ e: (x) => x.pipe === 'custom' }),
        data: ['roughness', 'fluids'],
        out: 'length',
        outUnit: 'm',
        label: 'Head loss',
        rows: { dP: ['Pressure drop', 'pressure'], v: ['Velocity', 'speed'], Re: 'Reynolds number', f: 'Darcy friction factor', regime: 'Flow regime' },
        run: (x, ctx) => {
            const [rho, mu] = fluidProps(x, ctx);
            const e = x.pipe === 'custom' ? x.e : ctx.c.data.physics.roughness[x.pipe].e / 1000;
            const A = (Math.PI * x.D * x.D) / 4;
            const v = x.Q / A;
            const Re = (rho * v * x.D) / mu;
            const f = friction(Re, e / x.D);
            const hf = f * (x.L / x.D) * (v * v) / (2 * g0);

            return { value: hf, sub: `ΔP = ${num((rho * g0 * hf) / 1000)} kPa`, rows: { dP: [rho * g0 * hf, 'pressure'], v: [v, 'speed'], Re: num(Re, 5), f: num(f, 5), regime: regime(Re) }, steps: ['h_f = f (L/D) v²/2g', `v = ${num(v)} m/s, Re = ${num(Re)}`, Re < 2300 ? 'Laminar: f = 64/Re' : `Colebrook–White: 1/√f = −2 log₁₀(ε/3.7D + 2.51/(Re√f)) → f = ${num(f)}`, `h_f = ${num(hf)} m`] };
        },
    },
    differential_pressure: {
        type: 'calc',
        inputs: { P1: ['Upstream pressure', 'pressure', 'kpa', 350], P2: ['Downstream pressure', 'pressure', 'kpa', 320] },
        out: 'pressure',
        outUnit: 'kpa',
        label: 'Differential pressure',
        rows: { water: 'As a column of water', psi: ['In psi', 'pressure'] },
        run: (x) => ({ value: x.P1 - x.P2, sub: x.P1 >= x.P2 ? 'Flow from 1 to 2' : 'Pressure rises from 1 to 2', rows: { water: `${num((x.P1 - x.P2) / (998.2 * g0))} m of water`, psi: [x.P1 - x.P2, 'pressure'] }, steps: ['ΔP = P₁ − P₂', `= ${num(x.P1)} − ${num(x.P2)} = ${num(x.P1 - x.P2)} Pa`] }),
    },
    drag: pw({ vars: { F: ['Drag force', 'force', 'n', 450], rho: ['Fluid density', 'density', 'kgm3', 1.225], v: ['Speed', 'speed', 'kmh', 100], Cd: ['Drag coefficient', null, null, 0.3], A: ['Frontal area', 'area', 'm2', 2.2] }, out: 'F', k: 0.5, exp: { rho: 1, v: 2, Cd: 1, A: 1 }, eq: 'F = ½ ρ v² C_d A', forms: { F: 'F = ½ρv²C_dA', rho: 'ρ = 2F ÷ v²C_dA', v: 'v = √(2F ÷ ρC_dA)', Cd: 'C_d = 2F ÷ ρv²A', A: 'A = 2F ÷ ρv²C_d' }, rows: { P: 'Power to overcome it', typical: 'Typical C_d' }, extra: (v) => ({ P: `${num((v.F * v.v) / 1000)} kW`, typical: 'Streamlined body 0.04, car 0.25–0.35, sphere 0.47, cyclist 0.9, flat plate 1.2–2.0' }) }),
    fan: {
        type: 'calc',
        inputs: { Q: ['Air flow', 'flow', 'm3h', 3000], dp: ['Fan pressure rise', 'pressure', 'pa', 400], eff: ['Fan efficiency (%)', null, null, 60, 0], n1: ['Current speed (rpm, for affinity laws)', null, null, 1450, 0], n2: ['New speed (rpm)', null, null, 1200, 0] },
        out: 'power',
        outUnit: 'w',
        label: 'Shaft power',
        rows: { air: ['Air power', 'power'], Q2: 'Flow at the new speed', p2: 'Pressure at the new speed', P2: 'Power at the new speed' },
        run: (x) => {
            const air = x.Q * x.dp;
            const shaft = air / (x.eff / 100);
            const r = x.n2 / x.n1;

            return { value: shaft, sub: `${num(air)} W of air power at ${num(x.eff)}% efficiency`, rows: { air: [air, 'power'], Q2: `${num(x.Q * r * 3600)} m³/h`, p2: `${num(x.dp * r * r)} Pa`, P2: `${num(shaft * r ** 3)} W` }, steps: ['P = QΔp ÷ η', 'Affinity laws: Q ∝ n, Δp ∝ n², P ∝ n³', `At ${num(x.n2)} rpm the power falls to ${num(r ** 3 * 100, 4)}%`] };
        },
    },
    flow_rate: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { velocity: 'Velocity and pipe diameter', volume: 'Volume and time' }, 'velocity'], v: ['Velocity', 'speed', 'ms', 1.5], D: ['Inside diameter', 'length', 'mm', 50], V: ['Volume collected', 'volume', 'l', 10], t: ['Time', 'time', 's', 30] },
        show: { v: 'mode:velocity', D: 'mode:velocity', V: 'mode:volume', t: 'mode:volume' },
        when: { v: (x) => x.mode === 'velocity', D: (x) => x.mode === 'velocity', V: (x) => x.mode === 'volume', t: (x) => x.mode === 'volume' },
        out: 'flow',
        outUnit: 'lmin',
        label: 'Flow rate',
        rows: { m3h: ['In m³/h', 'flow'], gpm: ['In US gpm', 'flow'], mass: 'Mass flow of water' },
        run: (x) => {
            const Q = x.mode === 'velocity' ? x.v * (Math.PI * x.D * x.D) / 4 : x.V / x.t;

            return { value: Q, sub: x.mode === 'velocity' ? 'Q = v × πD²/4' : 'Q = V ÷ t', rows: { m3h: [Q, 'flow'], gpm: [Q, 'flow'], mass: `${num(Q * 998.2)} kg/s` }, steps: [x.mode === 'velocity' ? `Q = ${num(x.v)} × π × ${num(x.D)}² ÷ 4` : `Q = ${num(x.V)} ÷ ${num(x.t)}`, `= ${num(Q)} m³/s`] };
        },
    },
    friction_factor: {
        type: 'calc',
        inputs: { Re: ['Reynolds number', null, null, 1e5, 0], rel: ['Relative roughness ε/D', null, null, 0.0009, 0] },
        label: 'Darcy friction factor',
        rows: { sj: 'Swamee–Jain (explicit)', haaland: 'Haaland (explicit)', fanning: 'Fanning friction factor (f/4)', regime: 'Regime' },
        run: (x) => {
            const f = friction(x.Re, x.rel);
            const sj = 0.25 / Math.log10(x.rel / 3.7 + 5.74 / x.Re ** 0.9) ** 2;
            const hl = (-1.8 * Math.log10((x.rel / 3.7) ** 1.11 + 6.9 / x.Re)) ** -2;

            return { value: num(f, 6), sub: x.Re < 2300 ? 'Laminar: 64/Re' : 'Colebrook–White, iterated', rows: { sj: x.Re >= 4000 ? num(sj, 6) : 'Turbulent flow only', haaland: x.Re >= 4000 ? num(hl, 6) : 'Turbulent flow only', fanning: num(f / 4, 6), regime: regime(x.Re) }, steps: [x.Re < 2300 ? `f = 64 ÷ ${num(x.Re)}` : '1/√f = −2 log₁₀(ε/3.7D + 2.51/(Re√f))', `f = ${num(f)}`] };
        },
    },
    friction_loss: {
        type: 'calc',
        inputs: { Q: ['Flow rate', 'flow', 'lmin', 200], D: ['Inside diameter', 'length', 'mm', 50], L: ['Pipe length', 'length', 'm', 50], pipe: ['Pipe material', 'select', 'data:roughness:fixed', 'pvc'], fluid: FLUID('water'), ...customFluid, el90: ['90° elbows (K = 0.9)', null, null, 4, 0], el45: ['45° elbows (K = 0.4)', null, null, 0, 0], tee: ['Tees, flow through branch (K = 1.8)', null, null, 1, 0], gate: ['Gate or ball valves, open (K = 0.2)', null, null, 2, 0], globe: ['Globe valves, open (K = 10)', null, null, 0, 0], check: ['Swing check valves (K = 2)', null, null, 1, 0], ends: ['Include entrance and exit (K = 0.5 + 1)', 'select', { yes: 'Yes', no: 'No' }, 'yes'] },
        show: fluidShow(),
        when: fluidWhen(),
        data: ['roughness', 'fluids'],
        out: 'length',
        outUnit: 'm',
        label: 'Total head loss',
        rows: { major: ['Pipe friction loss', 'length'], minor: ['Fittings loss', 'length'], K: 'Sum of K values', dP: ['Pressure drop', 'pressure'], v: ['Velocity', 'speed'] },
        run: (x, ctx) => {
            const [rho, mu] = fluidProps(x, ctx);
            const e = ctx.c.data.physics.roughness[x.pipe].e / 1000;
            const v = x.Q / ((Math.PI * x.D * x.D) / 4);
            const Re = (rho * v * x.D) / mu;
            const f = friction(Re, e / x.D);
            const hv = (v * v) / (2 * g0);
            const Ksum = 0.9 * x.el90 + 0.4 * x.el45 + 1.8 * x.tee + 0.2 * x.gate + 10 * x.globe + 2 * x.check + (x.ends === 'yes' ? 1.5 : 0);
            const major = f * (x.L / x.D) * hv;
            const minor = Ksum * hv;

            return { value: major + minor, sub: `${num(major)} m pipe + ${num(minor)} m fittings`, rows: { major: [major, 'length'], minor: [minor, 'length'], K: num(Ksum, 4), dP: [rho * g0 * (major + minor), 'pressure'], v: [v, 'speed'] }, steps: ['h = (f L/D + ΣK) v²/2g', `f = ${num(f)} (Re = ${num(Re)}), ΣK = ${num(Ksum)}`, 'K values are typical (Crane TP-410 order of magnitude); fitting design varies'] };
        },
    },
    froude: {
        type: 'calc',
        inputs: { v: ['Flow velocity', 'speed', 'ms', 3], L: ['Depth (or characteristic length)', 'length', 'm', 0.5] },
        label: 'Froude number',
        rows: { regime: 'Flow regime', c: 'Shallow-water wave speed √(gL)' },
        run: (x) => {
            const Fr = x.v / Math.sqrt(g0 * x.L);

            return { value: num(Fr, 5), sub: Fr < 1 ? 'Subcritical (tranquil)' : Fr > 1 ? 'Supercritical (rapid)' : 'Critical', rows: { regime: Fr < 1 ? 'Subcritical: waves can travel upstream' : 'Supercritical: disturbances are swept downstream', c: `${num(Math.sqrt(g0 * x.L))} m/s` }, steps: ['Fr = v ÷ √(gL)', `= ${num(x.v)} ÷ √(9.80665 × ${num(x.L)}) = ${num(Fr)}`] };
        },
    },
    hydraulic_conductivity: {
        type: 'calc',
        inputs: { test: ['Test', 'select', { constant: 'Constant-head permeameter', falling: 'Falling-head permeameter' }, 'constant'], V: ['Volume collected', 'volume', 'ml', 500], t: ['Time', 'time', 's', 300], L: ['Sample length', 'length', 'cm', 15], A: ['Sample area', 'area', 'cm2', 80], h: ['Head difference', 'length', 'cm', 50], a: ['Standpipe area', 'area', 'cm2', 1], h1: ['Starting head', 'length', 'cm', 100], h2: ['Final head', 'length', 'cm', 50] },
        show: { V: 'test:constant', h: 'test:constant', a: 'test:falling', h1: 'test:falling', h2: 'test:falling' },
        when: { V: (x) => x.test === 'constant', h: (x) => x.test === 'constant', a: (x) => x.test === 'falling', h1: (x) => x.test === 'falling', h2: (x) => x.test === 'falling' },
        label: 'Hydraulic conductivity K',
        rows: { cmps: 'In cm/s', md: 'In m/day', soil: 'Typical of' },
        run: (x) => {
            const K_ = x.test === 'constant' ? (x.V * x.L) / (x.A * x.h * x.t) : ((x.a * x.L) / (x.A * x.t)) * Math.log(x.h1 / x.h2);
            const soil = K_ > 1e-2 ? 'Clean gravel' : K_ > 1e-4 ? 'Clean sand or sand and gravel' : K_ > 1e-6 ? 'Fine or silty sand' : K_ > 1e-8 ? 'Silt, loess, glacial till' : 'Clay';

            return { value: num(K_), unit: 'm/s', sub: soil, rows: { cmps: `${num(K_ * 100)} cm/s`, md: `${num(K_ * 86400)} m/day`, soil }, steps: [x.test === 'constant' ? 'K = VL ÷ (A h t)' : 'K = (aL ÷ At) ln(h₁/h₂)', `= ${num(K_)} m/s`, 'Soil classes after Freeze & Cherry (1979)'] };
        },
    },
    hydraulic_gradient: pw({ vars: { i: ['Hydraulic gradient', null, null, 0.01], dh: ['Head difference', 'length', 'm', 2], L: ['Distance', 'length', 'm', 200] }, out: 'i', exp: { dh: 1, L: -1 }, eq: 'i = Δh ÷ L', forms: { i: 'i = Δh ÷ L', dh: 'Δh = iL', L: 'L = Δh ÷ i' }, rows: { pct: 'As a percentage' }, extra: (v) => ({ pct: `${num(v.i * 100)}%` }) }),
    hydraulic_jump: {
        type: 'calc',
        inputs: { y1: ['Upstream depth', 'length', 'm', 0.3], v1: ['Upstream velocity', 'speed', 'ms', 6] },
        out: 'length',
        outUnit: 'm',
        label: 'Downstream (sequent) depth',
        rows: { Fr: 'Upstream Froude number', loss: ['Energy (head) loss', 'length'], v2: ['Downstream velocity', 'speed'], type: 'Jump type', Lj: ['Approximate jump length', 'length'] },
        run: (x) => {
            const Fr = x.v1 / Math.sqrt(g0 * x.y1);

            if (!(Fr > 1)) {
                return { error: 'A hydraulic jump needs supercritical flow (Fr > 1) upstream.' };
            }

            const y2 = (x.y1 / 2) * (Math.sqrt(1 + 8 * Fr * Fr) - 1);
            const type = Fr < 1.7 ? 'Undular' : Fr < 2.5 ? 'Weak' : Fr < 4.5 ? 'Oscillating' : Fr < 9 ? 'Steady' : 'Strong';

            return { value: y2, sub: `Fr₁ = ${num(Fr, 4)} (${type.toLowerCase()} jump)`, rows: { Fr: num(Fr, 5), loss: [(y2 - x.y1) ** 3 / (4 * x.y1 * y2), 'length'], v2: [(x.v1 * x.y1) / y2, 'speed'], type, Lj: [6.1 * y2, 'length'] }, steps: ['y₂ = (y₁/2)(√(1 + 8Fr₁²) − 1) (rectangular channel)', `= ${num(y2)} m`, 'ΔE = (y₂ − y₁)³ ÷ (4y₁y₂)'] };
        },
    },
    hydraulic_pressure: pw({ vars: { P: ['Pressure', 'pressure', 'bar', 100], F: ['Force', 'force', 'kn', 31.17], A: ['Piston area', 'area', 'cm2', 31.17] }, out: 'P', exp: { F: 1, A: -1 }, eq: 'P = F ÷ A', forms: { P: 'P = F ÷ A', F: 'F = PA', A: 'A = F ÷ P' }, rows: { pascal: 'Pascal’s principle' }, extra: () => ({ pascal: 'The same pressure acts everywhere in the fluid: a piston 10× larger gives 10× the force' }) }),
    hydraulic_radius: {
        type: 'calc',
        inputs: CHANNEL_INPUTS,
        show: CHANNEL_SHOW,
        when: CHANNEL_WHEN,
        out: 'length',
        outUnit: 'm',
        label: 'Hydraulic radius',
        rows: { A: 'Flow area', P: ['Wetted perimeter', 'length'], D: ['Hydraulic depth A/T', 'length'], Dh: ['Hydraulic diameter 4A/P', 'length'] },
        run: (x) => {
            const c = channel(x);

            return { value: c.A / c.P, sub: `A = ${num(c.A)} m², P = ${num(c.P)} m`, rows: { A: `${num(c.A)} m²`, P: [c.P, 'length'], D: [c.T > 0 ? c.A / c.T : NaN, 'length'], Dh: [(4 * c.A) / c.P, 'length'] }, steps: ['R_h = A ÷ P (flow area over wetted perimeter)', `= ${num(c.A)} ÷ ${num(c.P)} = ${num(c.A / c.P)} m`] };
        },
    },
    hydrostatic: {
        type: 'calc',
        inputs: { h: ['Depth', 'length', 'm', 10], fluid: FLUID('water'), rho: customFluid.rho, P0: ['Surface pressure', 'pressure', 'kpa', 101.325] },
        show: { rho: 'fluid:custom' },
        when: { rho: (x) => x.fluid === 'custom' },
        data: ['fluids'],
        out: 'pressure',
        outUnit: 'kpa',
        label: 'Absolute pressure',
        rows: { gauge: ['Gauge pressure ρgh', 'pressure'], atm: 'In atmospheres' },
        run: (x, ctx) => {
            const [rho] = fluidProps(x, ctx);
            const gauge = rho * g0 * x.h;

            return { value: x.P0 + gauge, sub: `Gauge ${num(gauge / 1000)} kPa`, rows: { gauge: [gauge, 'pressure'], atm: `${num((x.P0 + gauge) / 101325)} atm` }, steps: ['P = P₀ + ρgh', `= ${num(x.P0)} + ${num(rho)} × 9.80665 × ${num(x.h)} = ${num(x.P0 + gauge)} Pa`] };
        },
    },
    knudsen: {
        type: 'calc',
        inputs: { gas: ['Gas', 'select', 'data:gases', 'air'], d: ['Molecular diameter', 'length', 'nm', 0.365], P: ['Pressure', 'pressure', 'pa', 101325], T: ['Temperature', 'temperature', 'c', 20], L: ['Characteristic length', 'length', 'um', 1] },
        show: { d: 'gas:custom' },
        when: { d: (x) => x.gas === 'custom' },
        data: ['gases'],
        label: 'Knudsen number',
        rows: { lambda: 'Mean free path', regime: 'Flow regime' },
        run: (x, ctx) => {
            const d = x.gas === 'custom' ? x.d : ctx.c.data.physics.gases[x.gas].d * 1e-12;
            const lambda = (K.k * x.T) / (Math.SQRT2 * Math.PI * d * d * x.P);
            const Kn = lambda / x.L;

            return { value: num(Kn), sub: `λ = ${num(lambda * 1e9)} nm`, rows: { lambda: `${num(lambda * 1e9)} nm`, regime: Kn < 0.01 ? 'Continuum (normal fluid mechanics)' : Kn < 0.1 ? 'Slip flow' : Kn < 10 ? 'Transitional' : 'Free molecular' }, steps: ['λ = kT ÷ (√2 π d² P)', 'Kn = λ ÷ L', `= ${num(Kn)}`] };
        },
    },
    lift_coefficient: pw({ vars: { CL: ['Lift coefficient', null, null, 0.4], L: ['Lift', 'force', 'n', 10787], rho: ['Air density', 'density', 'kgm3', 1.225], v: ['Speed', 'speed', 'knot', 100], S: ['Wing area', 'area', 'm2', 16.2] }, out: 'CL', k: 2, exp: { L: 1, rho: -1, v: -2, S: -1 }, eq: 'C_L = 2L ÷ (ρ v² S)', forms: { CL: 'C_L = 2L ÷ ρv²S', L: 'L = ½ρv²SC_L', rho: 'ρ = 2L ÷ v²SC_L', v: 'v = √(2L ÷ ρSC_L)', S: 'S = 2L ÷ ρv²C_L' }, rows: { mass: 'Mass that lift supports' }, extra: (v) => ({ mass: `${num(v.L / g0)} kg` }) }),
    mach: {
        type: 'calc',
        inputs: { v: ['Speed', 'speed', 'kmh', 900], mode: ['Air temperature from', 'select', { T: 'A temperature', alt: 'Standard atmosphere at an altitude' }, 'alt'], T: ['Temperature', 'temperature', 'c', 15], alt: ['Altitude', 'length', 'm', 11000], gamma: ['Ratio of specific heats γ', null, null, 1.4, 1], M: ['Molar mass (g/mol)', null, null, 28.9647, 0] },
        show: { T: 'mode:T', alt: 'mode:alt' },
        when: { T: (x) => x.mode === 'T', alt: (x) => x.mode === 'alt' },
        label: 'Mach number',
        rows: { a: 'Speed of sound', regime: 'Regime' },
        run: (x) => {
            const T = x.mode === 'T' ? x.T : standardAtmosphere(x.alt).T;
            const a = Math.sqrt((x.gamma * K.R * T) / (x.M / 1000));
            const M = x.v / a;

            return { value: num(M, 4), sub: `Speed of sound ${num(a)} m/s at ${num(T - 273.15)} °C`, rows: { a: `${num(a)} m/s (${num(a * 3.6)} km/h)`, regime: M < 0.8 ? 'Subsonic' : M < 1.2 ? 'Transonic' : M < 5 ? 'Supersonic' : 'Hypersonic' }, steps: ['a = √(γRT ÷ M)', `= ${num(a)} m/s`, `Ma = v ÷ a = ${num(M)}`] };
        },
    },
    magnus: {
        type: 'calc',
        inputs: { r: ['Ball radius', 'length', 'cm', 3.66], v: ['Speed', 'speed', 'ms', 40], spin: ['Spin', 'angular_speed', 'rpm', 2000], rho: ['Air density', 'density', 'kgm3', 1.225], m: ['Ball mass (optional)', 'mass', 'g', 145] },
        optional: ['m'],
        out: 'force',
        outUnit: 'n',
        label: 'Magnus force',
        rows: { S: 'Spin parameter rω/v', CL: 'Lift coefficient used', a: 'Sideways acceleration', defl: 'Deflection over 18 m (pitching distance)' },
        run: (x) => {
            const S = (x.r * x.spin) / x.v;
            const CL = S < 0.1 ? 1.5 * S : 0.09 + 0.6 * S;
            const F = 0.5 * x.rho * CL * Math.PI * x.r * x.r * x.v * x.v;
            const a = Number.isFinite(x.m) ? F / x.m : NaN;
            const t = 18.44 / x.v;

            return { value: F, sub: `C_L ≈ ${num(CL, 3)} at spin parameter ${num(S, 3)}`, rows: { S: num(S, 4), CL: num(CL, 4), a: Number.isFinite(a) ? `${num(a)} m/s² (${num(a / g0)} g)` : 'Enter a mass', defl: Number.isFinite(a) ? `${num(0.5 * a * t * t * 100)} cm` : 'Enter a mass' }, steps: ['F = ½ρC_L A v², A = πr²', 'C_L from the baseball fit of Sawicki, Hubbard & Stronge (2003): 1.5S for S < 0.1, else 0.09 + 0.6S', `F = ${num(F)} N (an estimate: seams and surface change it)`] };
        },
    },
    manometer: {
        type: 'calc',
        inputs: { gauge: ['Manometer fluid', 'select', { water: 'Water (998 kg/m³)', mercury: 'Mercury (13,534 kg/m³)', oil: 'Red gauge oil (SG 0.826)', custom: 'Other' }, 'water'], rhom: ['Manometer fluid density', 'density', 'kgm3', 1000], proc: ['Process fluid above it', 'select', { air: 'Air or gas (ignored)', water: 'Water', custom: 'Other' }, 'air'], rhof: ['Process fluid density', 'density', 'kgm3', 998], h: ['Height difference', 'length', 'mm', 100] },
        show: { rhom: 'gauge:custom', rhof: 'proc:custom' },
        when: { rhom: (x) => x.gauge === 'custom', rhof: (x) => x.proc === 'custom' },
        out: 'pressure',
        outUnit: 'pa',
        label: 'Pressure difference',
        rows: { kpa: ['In kPa', 'pressure'], inh2o: 'In inches of water' },
        run: (x) => {
            const rm = { water: 998.2, mercury: 13534, oil: 826, custom: x.rhom }[x.gauge];
            const rf = { air: 0, water: 998.2, custom: x.rhof }[x.proc];
            const dp = (rm - rf) * g0 * x.h;

            return { value: dp, sub: `(ρ_m − ρ_f) g h with ρ_m = ${num(rm)} kg/m³`, rows: { kpa: [dp, 'pressure'], inh2o: `${num(dp / 249.0889)} in H₂O` }, steps: ['ΔP = (ρ_m − ρ_f) g h', `= (${num(rm)} − ${num(rf)}) × 9.80665 × ${num(x.h)} = ${num(dp)} Pa`] };
        },
    },
    moisture_content: {
        type: 'calc',
        inputs: { wet: ['Wet mass', 'mass', 'g', 120], dry: ['Oven-dry mass', 'mass', 'g', 100] },
        label: 'Moisture content (dry basis)',
        rows: { wetb: 'Wet basis', water: ['Water mass', 'mass'] },
        run: (x) => {
            if (!(x.wet >= x.dry)) {
                return { error: 'The wet mass must be at least the dry mass.' };
            }

            const db = (x.wet - x.dry) / x.dry;

            return { value: `${num(db * 100, 4)}%`, sub: `Wet basis ${num(((x.wet - x.dry) / x.wet) * 100, 4)}%`, rows: { wetb: `${num(((x.wet - x.dry) / x.wet) * 100, 4)}%`, water: [x.wet - x.dry, 'mass'] }, steps: ['Dry basis (soil, wood): MC = (m_wet − m_dry) ÷ m_dry', 'Wet basis (food, grain): MC = (m_wet − m_dry) ÷ m_wet', `= ${num(db * 100)}% dry basis`] };
        },
    },
    oblique_shock: {
        type: 'calc',
        inputs: { M1: ['Upstream Mach number', null, null, 2, 1], theta: ['Wedge (deflection) angle', 'angle', 'deg', 10], gamma: ['γ', null, null, 1.4, 1] },
        out: 'angle',
        outUnit: 'deg',
        label: 'Shock angle β (weak shock)',
        rows: { M2: 'Downstream Mach number', p: 'Pressure ratio p₂/p₁', rho: 'Density ratio', T: 'Temperature ratio', max: 'Largest deflection for an attached shock', p0: 'Stagnation pressure ratio' },
        run: (x) => {
            const g = x.gamma;
            const M = x.M1;
            const tanTheta = (b) => (2 / Math.tan(b)) * ((M * M * Math.sin(b) ** 2 - 1) / (M * M * (g + Math.cos(2 * b)) + 2));
            const mu = Math.asin(1 / M);
            let bmax = mu;
            let tmax = 0;

            for (let k = 0; k <= 2000; k += 1) {
                const b = mu + ((Math.PI / 2 - mu) * k) / 2000;
                const t = Math.atan(tanTheta(b));

                if (t > tmax) {
                    [tmax, bmax] = [t, b];
                }
            }

            if (x.theta > tmax) {
                return { error: `The shock detaches: the largest deflection at Mach ${num(M)} is ${num(tmax / D, 4)}°.` };
            }

            const beta = bisect((b) => Math.atan(tanTheta(b)) - x.theta, mu + 1e-12, bmax);
            const Mn1 = M * Math.sin(beta);
            const Mn2 = Math.sqrt((1 + ((g - 1) / 2) * Mn1 ** 2) / (g * Mn1 ** 2 - (g - 1) / 2));
            const M2 = Mn2 / Math.sin(beta - x.theta);
            const pr = 1 + ((2 * g) / (g + 1)) * (Mn1 ** 2 - 1);
            const rr = ((g + 1) * Mn1 ** 2) / ((g - 1) * Mn1 ** 2 + 2);
            const p0 = rr ** (g / (g - 1)) * (1 / pr) ** (1 / (g - 1));

            return { value: beta, sub: `M₂ = ${num(M2, 4)}`, rows: { M2: num(M2, 5), p: num(pr, 5), rho: num(rr, 5), T: num(pr / rr, 5), max: `${num(tmax / D, 4)}°`, p0: num(p0, 5) }, steps: ['θ–β–M: tan θ = 2 cot β (M² sin²β − 1) ÷ (M²(γ + cos 2β) + 2), solved for the weak β', `β = ${num(beta / D)}°, Mn₁ = ${num(Mn1)}`, 'Normal-shock relations on Mn₁ give the jumps'] };
        },
    },
    open_channel: {
        type: 'calc',
        inputs: { ...CHANNEL_INPUTS, lining: ['Lining', 'select', 'data:manning', 'concrete_finished'], n: ['Manning n', null, null, 0.013, 0], S: ['Bed slope (m per m)', null, null, 0.001, 0] },
        show: { ...CHANNEL_SHOW, n: 'lining:custom' },
        when: { ...CHANNEL_WHEN, n: (x) => x.lining === 'custom' },
        data: ['manning'],
        out: 'flow',
        outUnit: 'm3s',
        label: 'Flow rate (Manning)',
        rows: { v: ['Mean velocity', 'speed'], R: ['Hydraulic radius', 'length'], Fr: 'Froude number', n: 'Manning n used' },
        run: (x, ctx) => {
            const n = x.lining === 'custom' ? x.n : ctx.c.data.physics.manning[x.lining].n;
            const c = channel(x);
            const R = c.A / c.P;
            const v = (1 / n) * R ** (2 / 3) * Math.sqrt(x.S);
            const Fr = c.T > 0 ? v / Math.sqrt(g0 * (c.A / c.T)) : NaN;

            return { value: v * c.A, sub: `v = ${num(v)} m/s`, rows: { v: [v, 'speed'], R: [R, 'length'], Fr: `${num(Fr, 4)} (${Fr < 1 ? 'subcritical' : 'supercritical'})`, n: num(n, 3) }, steps: ['Manning: v = (1/n) R^(2/3) S^(1/2), Q = vA', `A = ${num(c.A)} m², R = ${num(R)} m`, `Q = ${num(v * c.A)} m³/s`] };
        },
    },
    orifice: {
        type: 'calc',
        inputs: { d: ['Orifice diameter', 'length', 'mm', 25], D: ['Pipe diameter', 'length', 'mm', 50], dP: ['Pressure difference', 'pressure', 'kpa', 20], rho: ['Fluid density', 'density', 'kgm3', 998], Cd: ['Discharge coefficient', null, null, 0.61, 0] },
        out: 'flow',
        outUnit: 'lmin',
        label: 'Flow rate',
        rows: { beta: 'Diameter ratio β', v: ['Velocity in the orifice', 'speed'], m: 'Mass flow' },
        run: (x) => {
            const beta = x.d / x.D;

            if (!(beta < 1)) {
                return { error: 'The orifice must be smaller than the pipe.' };
            }

            const A = (Math.PI * x.d * x.d) / 4;
            const Q = x.Cd * A * Math.sqrt((2 * x.dP) / (x.rho * (1 - beta ** 4)));

            return { value: Q, sub: `β = ${num(beta, 3)}`, rows: { beta: num(beta, 4), v: [Q / A, 'speed'], m: `${num(Q * x.rho)} kg/s` }, steps: ['Q = C_d A √(2ΔP ÷ ρ(1 − β⁴))', `= ${num(x.Cd)} × ${num(A)} × √(2 × ${num(x.dP)} ÷ (${num(x.rho)} × ${num(1 - beta ** 4)})) = ${num(Q)} m³/s`, 'Incompressible fluid; ISO 5167 adds Reynolds and expansibility corrections'] };
        },
    },
    pipe_flow: {
        type: 'calc',
        inputs: { dP: ['Available pressure drop', 'pressure', 'kpa', 50], D: ['Inside diameter', 'length', 'mm', 50], L: ['Pipe length', 'length', 'm', 100], pipe: ['Pipe material', 'select', 'data:roughness:fixed', 'steel'], fluid: FLUID('water'), ...customFluid },
        show: fluidShow(),
        when: fluidWhen(),
        data: ['roughness', 'fluids'],
        out: 'flow',
        outUnit: 'lmin',
        label: 'Flow rate',
        rows: { v: ['Velocity', 'speed'], Re: 'Reynolds number', f: 'Friction factor' },
        run: (x, ctx) => {
            const [rho, mu] = fluidProps(x, ctx);
            const e = ctx.c.data.physics.roughness[x.pipe].e / 1000;
            const A = (Math.PI * x.D * x.D) / 4;
            const dpFor = (v) => {
                const Re = (rho * v * x.D) / mu;

                return friction(Re, e / x.D) * (x.L / x.D) * 0.5 * rho * v * v;
            };
            const v = bisect((vv) => dpFor(vv) - x.dP, 1e-9, 1000);
            const Re = (rho * v * x.D) / mu;

            return { value: v * A, sub: `v = ${num(v)} m/s`, rows: { v: [v, 'speed'], Re: `${num(Re)} (${regime(Re).toLowerCase()})`, f: num(friction(Re, e / x.D), 5) }, steps: ['Darcy–Weisbach ΔP = f (L/D) ½ρv², with f from Colebrook', 'Solved for v by bisection', `Q = vA = ${num(v * A)} m³/s`] };
        },
    },
    pipe_velocity: {
        type: 'calc',
        inputs: { Q: ['Flow rate', 'flow', 'lmin', 200], D: ['Inside diameter', 'length', 'mm', 50] },
        out: 'speed',
        outUnit: 'ms',
        label: 'Velocity',
        rows: { guide: 'Typical design range', area: 'Flow area' },
        run: (x) => {
            const A = (Math.PI * x.D * x.D) / 4;
            const v = x.Q / A;

            return { value: v, sub: v > 3 ? 'High: noisy, erosive, high losses' : v < 0.5 ? 'Low: sediment may settle' : 'Within the usual range', rows: { guide: 'Water supply 0.5–2.5 m/s; pump suction 0.6–1.5 m/s; discharge 1.5–3 m/s', area: `${num(A * 1e6)} mm²` }, steps: ['v = Q ÷ A, A = πD²/4', `= ${num(x.Q)} ÷ ${num(A)} = ${num(v)} m/s`] };
        },
    },
    pneumatic_cylinder: {
        type: 'calc',
        inputs: { P: ['Supply pressure (gauge)', 'pressure', 'bar', 6], bore: ['Bore', 'length', 'mm', 50], rod: ['Rod diameter', 'length', 'mm', 20], action: ['Action', 'select', { double: 'Double acting', single: 'Single acting (spring return)' }, 'double'], spring: ['Spring force at full stroke', 'force', 'n', 80], stroke: ['Stroke (for air use)', 'length', 'mm', 100], eff: ['Efficiency (friction) %', null, null, 90, 0] },
        show: { spring: 'action:single' },
        when: { spring: (x) => x.action === 'single' },
        out: 'force',
        outUnit: 'n',
        label: 'Extend (push) force',
        rows: { pull: ['Retract (pull) force', 'force'], air: 'Free air used per cycle', kg: 'Push as a mass' },
        run: (x) => {
            const A = (Math.PI * x.bore ** 2) / 4;
            const a = A - (Math.PI * x.rod ** 2) / 4;
            const e = x.eff / 100;
            const push = x.P * A * e - (x.action === 'single' ? x.spring : 0);
            const pull = x.action === 'double' ? x.P * a * e : x.spring;
            const air = ((x.P + 101325) / 101325) * (A + (x.action === 'double' ? a : 0)) * x.stroke;

            return { value: push, sub: `Pull ${num(pull)} N`, rows: { pull: [pull, 'force'], air: `${num(air * 1000)} L`, kg: `${num(push / g0)} kg` }, steps: ['F = P × A × efficiency', `Push = ${num(x.P)} × ${num(A)} × ${num(e)}${x.action === 'single' ? ` − spring ${num(x.spring)}` : ''} = ${num(push)} N`] };
        },
    },
    poise_stokes: {
        type: 'calc',
        inputs: { mode: ['Convert', 'select', { dyn: 'Dynamic → kinematic', kin: 'Kinematic → dynamic' }, 'dyn'], mu: ['Dynamic viscosity', 'viscosity', 'cp', 1], nu: ['Kinematic viscosity', 'kinematic_viscosity', 'cst', 1], rho: ['Density', 'density', 'kgm3', 998.2] },
        show: { mu: 'mode:dyn', nu: 'mode:kin' },
        when: { mu: (x) => x.mode === 'dyn', nu: (x) => x.mode === 'kin' },
        label: 'Result',
        rows: { mu: ['Dynamic viscosity', 'viscosity'], nu: ['Kinematic viscosity', 'kinematic_viscosity'] },
        run: (x) => {
            const mu = x.mode === 'dyn' ? x.mu : x.nu * x.rho;
            const nu = mu / x.rho;

            return { value: x.mode === 'dyn' ? `${num(nu * 1e6)} cSt` : `${num(mu * 1000)} cP`, sub: 'ν = μ ÷ ρ', rows: { mu: [mu, 'viscosity'], nu: [nu, 'kinematic_viscosity'] }, steps: ['ν = μ ÷ ρ; 1 P = 0.1 Pa·s, 1 St = 10⁻⁴ m²/s', `μ = ${num(mu)} Pa·s, ν = ${num(nu)} m²/s`] };
        },
    },
    poiseuille: pw({ vars: { Q: ['Flow rate', 'flow', 'lmin', 1.5708], dP: ['Pressure drop', 'pressure', 'kpa', 8], r: ['Tube radius', 'length', 'mm', 1], mu: ['Viscosity', 'viscosity', 'cp', 1], L: ['Length', 'length', 'm', 0.1] }, out: 'Q', k: Math.PI / 8, exp: { dP: 1, r: 4, mu: -1, L: -1 }, eq: 'Q = π r⁴ ΔP ÷ (8 μ L)', forms: { Q: 'Q = πr⁴ΔP ÷ 8μL', dP: 'ΔP = 8μLQ ÷ πr⁴', r: 'r = (8μLQ ÷ πΔP)^(1/4)', mu: 'μ = πr⁴ΔP ÷ 8LQ', L: 'L = πr⁴ΔP ÷ 8μQ' }, rows: { v: 'Mean velocity', note: 'Validity' }, extra: (v) => ({ v: `${num(v.Q / (Math.PI * v.r * v.r))} m/s`, note: 'Laminar flow only (Re below about 2,300)' }) }),
    porosity: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { volumes: 'Pore and bulk volume', densities: 'Bulk and grain density' }, 'densities'], Vp: ['Pore volume', 'volume', 'ml', 30], Vb: ['Bulk volume', 'volume', 'ml', 100], rb: ['Bulk (dry) density', 'density', 'gcm3', 1.6], rg: ['Grain density', 'density', 'gcm3', 2.65], d: ['Mean grain diameter (for permeability)', 'length', 'mm', 0.3] },
        show: { Vp: 'mode:volumes', Vb: 'mode:volumes', rb: 'mode:densities', rg: 'mode:densities' },
        when: { Vp: (x) => x.mode === 'volumes', Vb: (x) => x.mode === 'volumes', rb: (x) => x.mode === 'densities', rg: (x) => x.mode === 'densities' },
        label: 'Porosity',
        rows: { e: 'Void ratio', k: 'Permeability (Kozeny–Carman)', darcy: 'In darcys', K: 'Hydraulic conductivity for water at 20 °C' },
        run: (x) => {
            const phi = x.mode === 'volumes' ? x.Vp / x.Vb : 1 - x.rb / x.rg;
            const k = (x.d * x.d * phi ** 3) / (180 * (1 - phi) ** 2);

            return { value: `${num(phi * 100, 4)}%`, sub: `Void ratio ${num(phi / (1 - phi), 4)}`, rows: { e: num(phi / (1 - phi), 4), k: `${num(k)} m²`, darcy: `${num(k / 9.869233e-13)} D`, K: `${num((k * 998.2 * g0) / 1.002e-3)} m/s` }, steps: ['φ = V_pores ÷ V_bulk = 1 − ρ_bulk ÷ ρ_grain', 'Kozeny–Carman: k = d² φ³ ÷ (180 (1 − φ)²), for well-sorted spherical grains (an estimate)', `k = ${num(k)} m²`] };
        },
    },
    lb_per_min: {
        type: 'calc',
        inputs: { Q: ['Air flow (actual)', 'flow', 'cfm', 500], P: ['Absolute pressure', 'pressure', 'psi', 14.696], T: ['Temperature', 'temperature', 'f', 70], M: ['Molar mass (g/mol)', null, null, 28.9647, 0] },
        out: 'mass_flow',
        outUnit: 'lbmin',
        label: 'Mass flow',
        rows: { rho: ['Gas density', 'density'], kgh: ['In kg/h', 'mass_flow'] },
        run: (x) => {
            const rho = (x.P * (x.M / 1000)) / (K.R * x.T);

            return { value: rho * x.Q, sub: `ρ = ${num(rho)} kg/m³`, rows: { rho: [rho, 'density'], kgh: [rho * x.Q, 'mass_flow'] }, steps: ['ṁ = ρQ, ρ = PM ÷ RT (ideal gas)', `= ${num(rho)} × ${num(x.Q)} = ${num(rho * x.Q)} kg/s`] };
        },
    },
    prandtl_meyer: {
        type: 'calc',
        inputs: { M1: ['Upstream Mach number', null, null, 2, 1], theta: ['Turning angle', 'angle', 'deg', 10], gamma: ['γ', null, null, 1.4, 1] },
        label: 'Downstream Mach number',
        rows: { nu1: 'Prandtl–Meyer angle upstream', nu2: 'Prandtl–Meyer angle downstream', p: 'Pressure ratio p₂/p₁', T: 'Temperature ratio', max: 'Largest possible turn' },
        run: (x) => {
            const g = x.gamma;
            const nu = (M) => Math.sqrt((g + 1) / (g - 1)) * Math.atan(Math.sqrt(((g - 1) / (g + 1)) * (M * M - 1))) - Math.atan(Math.sqrt(M * M - 1));
            const numax = (Math.PI / 2) * (Math.sqrt((g + 1) / (g - 1)) - 1);
            const nu2 = nu(x.M1) + x.theta;

            if (!(x.M1 >= 1)) {
                return { error: 'Prandtl–Meyer expansion needs supersonic flow (M ≥ 1).' };
            }

            if (nu2 >= numax) {
                return { error: `Too large: the flow can turn at most ${num((numax - nu(x.M1)) / D, 4)}° before reaching vacuum.` };
            }

            const M2 = bisect((M) => nu(M) - nu2, 1, 1000);
            const t = (M) => 1 + ((g - 1) / 2) * M * M;

            return { value: num(M2, 5), sub: `ν: ${num(nu(x.M1) / D, 4)}° → ${num(nu2 / D, 4)}°`, rows: { nu1: `${num(nu(x.M1) / D, 5)}°`, nu2: `${num(nu2 / D, 5)}°`, p: num((t(x.M1) / t(M2)) ** (g / (g - 1)), 5), T: num(t(x.M1) / t(M2), 5), max: `${num((numax - nu(x.M1)) / D, 4)}°` }, steps: ['ν(M) = √((γ+1)/(γ−1)) atan √((γ−1)(M²−1)/(γ+1)) − atan √(M²−1)', 'ν₂ = ν₁ + θ, solved for M₂', 'Isentropic: p₂/p₁ = (T₂/T₁)^(γ/(γ−1))'] };
        },
    },
    prandtl: {
        type: 'calc',
        inputs: { fluid: FLUID('water'), mu: ['Dynamic viscosity', 'viscosity', 'cp', 1], cp: ['Specific heat', 'specific_heat', 'jkgk', 4182], k: ['Thermal conductivity', 'thermal_conductivity', 'wmk', 0.6] },
        show: { mu: 'fluid:custom', cp: 'fluid:custom', k: 'fluid:custom' },
        when: { mu: (x) => x.fluid === 'custom', cp: (x) => x.fluid === 'custom', k: (x) => x.fluid === 'custom' },
        data: ['fluids'],
        label: 'Prandtl number',
        rows: { meaning: 'Meaning', props: 'Properties used' },
        run: (x, ctx) => {
            const f = x.fluid === 'custom' ? { mu: x.mu, cp: x.cp, k: x.k } : fluid(ctx, x.fluid);
            const Pr = (f.cp * f.mu) / f.k;

            return { value: num(Pr, 4), sub: Pr < 1 ? 'Heat diffuses faster than momentum' : 'Momentum diffuses faster than heat', rows: { meaning: 'Ratio of momentum diffusivity to thermal diffusivity', props: `μ = ${num(f.mu)} Pa·s, c_p = ${num(f.cp)} J/(kg·K), k = ${num(f.k)} W/(m·K) (20 °C)` }, steps: ['Pr = c_p μ ÷ k', `= ${num(f.cp)} × ${num(f.mu)} ÷ ${num(f.k)} = ${num(Pr)}`] };
        },
    },
    reynolds: {
        type: 'calc',
        inputs: { v: ['Velocity', 'speed', 'ms', 1], L: ['Characteristic length (pipe diameter)', 'length', 'mm', 50], fluid: FLUID('water'), ...customFluid },
        show: fluidShow(),
        when: fluidWhen(),
        data: ['fluids'],
        label: 'Reynolds number',
        rows: { regime: 'Pipe flow regime', nu: 'Kinematic viscosity used' },
        run: (x, ctx) => {
            const [rho, mu] = fluidProps(x, ctx);
            const Re = (rho * x.v * x.L) / mu;

            return { value: num(Re, 5), sub: regime(Re), rows: { regime: `${regime(Re)} (pipe: laminar below 2,300, turbulent above about 4,000)`, nu: `${num((mu / rho) * 1e6)} mm²/s` }, steps: ['Re = ρvL ÷ μ', `= ${num(rho)} × ${num(x.v)} × ${num(x.L)} ÷ ${num(mu)} = ${num(Re)}`] };
        },
    },
    stokes: {
        type: 'calc',
        inputs: { r: ['Particle radius', 'length', 'um', 25], rhop: ['Particle density', 'density', 'kgm3', 2650], fluid: FLUID('water'), ...customFluid },
        show: fluidShow(),
        when: fluidWhen(),
        data: ['fluids'],
        out: 'speed',
        outUnit: 'cms',
        label: 'Settling velocity',
        rows: { Re: 'Particle Reynolds number', valid: 'Stokes law valid?', t1: 'Time to settle 1 m', F: 'Drag force at that speed' },
        run: (x, ctx) => {
            const [rho, mu] = fluidProps(x, ctx);
            const v = (2 * (x.rhop - rho) * g0 * x.r * x.r) / (9 * mu);
            const Re = (rho * Math.abs(v) * 2 * x.r) / mu;

            return { value: v, sub: v < 0 ? 'Negative: the particle rises' : `Re = ${num(Re, 3)}`, rows: { Re: num(Re, 4), valid: Re < 1 ? 'Yes (Re < 1)' : 'No: Re > 1, the real speed is lower', t1: `${num(1 / Math.abs(v))} s`, F: `${num(6 * Math.PI * mu * x.r * Math.abs(v))} N` }, steps: ['v = 2(ρ_p − ρ_f) g r² ÷ 9μ', `= ${num(v)} m/s`] };
        },
    },
    water_density: {
        type: 'calc',
        inputs: { T: ['Water temperature', 'temperature', 'c', 20] },
        out: 'density',
        outUnit: 'kgm3',
        label: 'Density of pure water',
        rows: { sv: 'Specific volume', vs4: 'Compared with 4 °C', sea: 'Typical sea water (35 ‰)' },
        run: (x) => {
            const t = x.T - 273.15;

            if (!(t >= 0 && t <= 150)) {
                return { error: 'This formula covers liquid water from 0 to 150 °C.' };
            }

            const rho = waterDensity(t);

            return { value: rho, sub: 'Kell (1975), 1 atm', rows: { sv: `${num(1 / rho * 1000, 6)} L/kg`, vs4: `${num((rho / waterDensity(3.98) - 1) * 100, 4)}%`, sea: 'About 1,025 kg/m³ at the surface' }, steps: ['Kell: ρ = (999.84 + 16.945t − …) ÷ (1 + 0.016898t)', `ρ(${num(t)} °C) = ${num(rho)} kg/m³`, 'Pure water is densest at 3.98 °C'] };
        },
    },
    water_depth_pressure: {
        type: 'calc',
        inputs: { h: ['Depth', 'length', 'm', 10], water: ['Water', 'select', { fresh: 'Fresh (998 kg/m³)', sea: 'Sea (1,025 kg/m³)' }, 'sea'], P0: ['Air pressure at the surface', 'pressure', 'kpa', 101.325] },
        out: 'pressure',
        outUnit: 'bar',
        label: 'Absolute pressure',
        rows: { gauge: ['Gauge pressure', 'pressure'], atm: 'In atmospheres', psi: ['In psi', 'pressure'] },
        run: (x) => {
            const rho = x.water === 'sea' ? 1025 : 998.2;
            const gauge = rho * g0 * x.h;

            return { value: x.P0 + gauge, sub: `${num((x.P0 + gauge) / 101325, 4)} atm absolute`, rows: { gauge: [gauge, 'pressure'], atm: `${num((x.P0 + gauge) / 101325, 4)} atm (about 1 atm per 10 m of sea water)`, psi: [x.P0 + gauge, 'pressure'] }, steps: ['P = P_atm + ρgh', `= ${num(x.P0)} + ${num(rho)} × 9.80665 × ${num(x.h)} = ${num(x.P0 + gauge)} Pa`] };
        },
    },
    water_viscosity: {
        type: 'calc',
        inputs: { T: ['Water temperature', 'temperature', 'c', 20] },
        out: 'viscosity',
        outUnit: 'mpas',
        label: 'Dynamic viscosity',
        rows: { nu: ['Kinematic viscosity', 'kinematic_viscosity'], rho: 'Density used' },
        run: (x) => {
            const t = x.T - 273.15;

            if (!(t >= 0 && t <= 150)) {
                return { error: 'This range covers liquid water from 0 to 150 °C.' };
            }

            const mu = waterViscosity(x.T);
            const rho = waterDensity(t);

            return { value: mu, sub: 'Within about 2.5% (Vogel equation)', rows: { nu: [mu / rho, 'kinematic_viscosity'], rho: `${num(rho)} kg/m³` }, steps: ['μ = 2.414 × 10⁻⁵ × 10^(247.8 ÷ (T − 140)) Pa·s, T in K', `= ${num(mu * 1000)} mPa·s`] };
        },
    },
    wind_correction: {
        type: 'calc',
        inputs: { tas: ['True airspeed', 'speed', 'knot', 120], course: ['Desired course', 'angle', 'deg', 90], wind: ['Wind speed', 'speed', 'knot', 20], from: ['Wind from', 'angle', 'deg', 45] },
        out: 'angle',
        outUnit: 'deg',
        label: 'Wind correction angle',
        rows: { heading: 'Heading to fly', gs: ['Ground speed', 'speed'], head: ['Headwind component', 'speed'], cross: ['Crosswind component', 'speed'] },
        run: (x) => {
            const rel = x.from - x.course;
            const s = (x.wind * Math.sin(rel)) / x.tas;

            if (Math.abs(s) > 1) {
                return { error: 'The crosswind is stronger than the airspeed: the course cannot be held.' };
            }

            const wca = Math.asin(s);
            const gs = x.tas * Math.cos(wca) - x.wind * Math.cos(rel);
            const hdg = (((x.course + wca) / D) % 360 + 360) % 360;

            return { value: wca, sub: `Heading ${num(hdg, 4)}°, ground speed ${num(gs / 0.514444, 4)} kn`, rows: { heading: `${num(hdg, 5)}°`, gs: [gs, 'speed'], head: [x.wind * Math.cos(rel), 'speed'], cross: [x.wind * Math.sin(rel), 'speed'] }, steps: ['WCA = asin(W sin(wind direction − course) ÷ TAS)', `= ${num(wca / D)}°`, 'GS = TAS cos(WCA) − W cos(wind direction − course)'] };
        },
    },
    wind_load: {
        type: 'calc',
        inputs: { v: ['Wind speed', 'speed', 'kmh', 100], A: ['Area facing the wind', 'area', 'm2', 2], shape: ['Shape', 'select', SHAPE_OPTIONS, 'plate'], Cd: ['Drag coefficient', null, null, 1.2, 0], rho: ['Air density', 'density', 'kgm3', 1.225] },
        show: { Cd: 'shape:custom' },
        when: { Cd: (x) => x.shape === 'custom' },
        out: 'force',
        outUnit: 'n',
        label: 'Wind force',
        rows: { q: ['Dynamic pressure ½ρv²', 'pressure'], kg: 'As a weight', note: 'Important' },
        run: (x) => {
            const Cd = x.shape === 'custom' ? x.Cd : DRAG_SHAPES[x.shape][1];
            const q = 0.5 * x.rho * x.v * x.v;

            return { value: q * Cd * x.A, sub: `C_d = ${num(Cd)}, dynamic pressure ${num(q)} Pa`, rows: { q: [q, 'pressure'], kg: `${num((q * Cd * x.A) / g0)} kg-force`, note: 'A physics estimate only, not a building-code design load: codes (ASCE 7, EN 1991-1-4) add gust, height, terrain and importance factors' }, steps: ['F = ½ρv²C_dA', `= ${num(q)} × ${num(Cd)} × ${num(x.A)} = ${num(q * Cd * x.A)} N`] };
        },
    },
    yplus: {
        type: 'calc',
        inputs: { U: ['Free-stream velocity', 'speed', 'ms', 20], L: ['Reference length', 'length', 'm', 1], yp: ['Target y+', null, null, 1, 0], fluid: FLUID('air'), ...customFluid },
        show: fluidShow(),
        when: fluidWhen(),
        data: ['fluids'],
        out: 'length',
        outUnit: 'mm',
        label: 'First cell height',
        rows: { Re: 'Reynolds number', cf: 'Skin friction coefficient', ut: 'Friction velocity', tw: 'Wall shear stress' },
        run: (x, ctx) => {
            const [rho, mu] = fluidProps(x, ctx);
            const Re = (rho * x.U * x.L) / mu;
            const cf = (2 * Math.log10(Re) - 0.65) ** -2.3;
            const tw = 0.5 * cf * rho * x.U * x.U;
            const ut = Math.sqrt(tw / rho);
            const y = (x.yp * mu) / (rho * ut);

            return { value: y, sub: `Re = ${num(Re, 4)}`, rows: { Re: num(Re, 5), cf: num(cf, 5), ut: `${num(ut)} m/s`, tw: `${num(tw)} Pa` }, steps: ['Flat-plate skin friction (Schlichting): c_f = (2 log₁₀ Re − 0.65)^(−2.3)', 'u_τ = √(τ_w ÷ ρ), y = y⁺ μ ÷ (ρ u_τ)', `y = ${num(y * 1000)} mm (an estimate for meshing; check y⁺ after the first run)`] };
        },
    },
    continuity: pw({ vars: { v2: ['Velocity at section 2', 'speed', 'ms', 4], v1: ['Velocity at section 1', 'speed', 'ms', 1], d1: ['Diameter at section 1', 'length', 'mm', 100], d2: ['Diameter at section 2', 'length', 'mm', 50] }, out: 'v2', exp: { v1: 1, d1: 2, d2: -2 }, eq: 'A₁v₁ = A₂v₂', forms: { v2: 'v₂ = v₁ (d₁/d₂)²', v1: 'v₁ = v₂ (d₂/d₁)²', d1: 'd₁ = d₂ √(v₂/v₁)', d2: 'd₂ = d₁ √(v₁/v₂)' }, rows: { Q: 'Flow rate' }, extra: (v) => ({ Q: `${num(v.v1 * Math.PI * v.d1 ** 2 / 4 * 60000)} L/min` }) }),
    venturi: {
        type: 'calc',
        inputs: { D1: ['Inlet diameter', 'length', 'mm', 100], D2: ['Throat diameter', 'length', 'mm', 50], dP: ['Pressure difference', 'pressure', 'kpa', 15], rho: ['Fluid density', 'density', 'kgm3', 998], Cd: ['Discharge coefficient', null, null, 0.98, 0] },
        out: 'flow',
        outUnit: 'lmin',
        label: 'Flow rate',
        rows: { v1: ['Inlet velocity', 'speed'], v2: ['Throat velocity', 'speed'], beta: 'Diameter ratio β' },
        run: (x) => {
            const beta = x.D2 / x.D1;
            const A2 = (Math.PI * x.D2 ** 2) / 4;
            const Q = x.Cd * A2 * Math.sqrt((2 * x.dP) / (x.rho * (1 - beta ** 4)));

            return { value: Q, sub: `Throat velocity ${num(Q / A2)} m/s`, rows: { v1: [Q / ((Math.PI * x.D1 ** 2) / 4), 'speed'], v2: [Q / A2, 'speed'], beta: num(beta, 4) }, steps: ['Bernoulli + continuity: Q = C_d A₂ √(2ΔP ÷ ρ(1 − β⁴))', `= ${num(Q)} m³/s`] };
        },
    },
    pitot: {
        type: 'calc',
        inputs: { mode: ['Reading', 'select', { dp: 'Dynamic pressure', mano: 'Water manometer height' }, 'dp'], dP: ['Dynamic pressure', 'pressure', 'pa', 245], h: ['Manometer height', 'length', 'mm', 25], rho: ['Fluid density', 'density', 'kgm3', 1.225] },
        show: { dP: 'mode:dp', h: 'mode:mano' },
        when: { dP: (x) => x.mode === 'dp', h: (x) => x.mode === 'mano' },
        out: 'speed',
        outUnit: 'ms',
        label: 'Flow speed',
        rows: { kmh: ['In km/h', 'speed'], q: 'Dynamic pressure used', note: 'Limit' },
        run: (x) => {
            const dp = x.mode === 'dp' ? x.dP : 998.2 * g0 * x.h;
            const v = Math.sqrt((2 * dp) / x.rho);

            return { value: v, sub: `From ${num(dp)} Pa`, rows: { kmh: [v, 'speed'], q: `${num(dp)} Pa`, note: v / 343 > 0.3 ? 'Above Mach 0.3: compressibility makes this read high' : 'Incompressible formula is fine' }, steps: ['v = √(2ΔP ÷ ρ)', `= √(2 × ${num(dp)} ÷ ${num(x.rho)}) = ${num(v)} m/s`] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
