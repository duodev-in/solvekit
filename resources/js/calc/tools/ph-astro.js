import { defineTools } from '../engines/formula.js';
import { D, handlersFor, K, num, pw } from '../physics/core.js';
import { simpson } from '../physics/util.js';

/**
 * Astronomy, astrophysics and relativity.
 */
const c = K.c;
const g0 = K.g0;
const MPC = 3.0856775814913673e22;
const GYR = 365.25 * 86400 * 1e9;
const MSUN = 1.98841e30;
const body = (ctx, key) => ctx.c.data.physics.bodies[key];
const GM = (b) => b.gm * 1e9;
const R = (b) => b.radius * 1e3;
const gamma = (v) => 1 / Math.sqrt(1 - (v / c) ** 2);
const BODY = (def = 'earth', fixed = false) => ['Body', 'select', fixed ? 'data:bodies:fixed' : 'data:bodies', def];
/** GM (m³/s²) and radius (m) of the chosen body or the typed mass and radius. */
const gmR = (x, ctx) => (x.body === 'custom' ? [K.G * x.M, x.R] : [GM(body(ctx, x.body)), R(body(ctx, x.body))]);
const customBody = { M: ['Mass', 'astro_mass', 'mearth', 1], R: ['Radius', 'astronomical', 'km', 6371] };
const customShow = { M: 'body:custom', R: 'body:custom' };
const customWhen = { M: (x) => x.body === 'custom', R: (x) => x.body === 'custom' };
const fmtTime = (s) => (Math.abs(s) < 120 ? `${num(s)} s` : Math.abs(s) < 7200 ? `${num(s / 60)} min` : Math.abs(s) < 172800 ? `${num(s / 3600)} h` : Math.abs(s) < 2 * 365.25 * 86400 ? `${num(s / 86400)} days` : `${num(s / (365.25 * 86400))} years`);

/** Flat ΛCDM: dimensionless Hubble rate E(a), comoving distance (m), age at scale factor a (s). */
function cosmology(H0, Om) {
    const Or = 4.15e-5 / (H0 / 100) ** 2;
    const OL = 1 - Om - Or;
    const H = (H0 * 1000) / MPC;
    const E = (a) => Math.sqrt(Or / a ** 4 + Om / a ** 3 + OL);
    const comoving = (z) => (c / H) * simpson((a) => 1 / Math.sqrt(Or + Om * a + OL * a ** 4), 1 / (1 + z), 1, 2000);
    const age = (a) => (1 / H) * simpson((u) => (u === 0 ? 0 : (2 * u) / (u * u * E(u * u))), 0, Math.sqrt(a), 4000);

    return { H, E, comoving, age, Or, OL };
}

const PLANETS = { mercury: 'Mercury', venus: 'Venus', earth: 'Earth', mars: 'Mars', jupiter: 'Jupiter', saturn: 'Saturn', uranus: 'Uranus', neptune: 'Neptune', custom: 'Other (enter the period)' };
const DRAKE_PRESETS = {
    custom: 'Your own values',
    pessimistic: 'Pessimistic',
    middle: 'Middle of the road',
    optimistic: 'Optimistic',
};
const DRAKE_VALUES = { pessimistic: [1.5, 0.9, 0.1, 0.001, 0.001, 0.1, 1000], middle: [1.5, 1, 0.4, 0.1, 0.1, 0.2, 10000], optimistic: [3, 1, 1, 1, 0.5, 0.5, 1e6] };
const DRAKE_INPUTS = {
    preset: ['Values', 'select', DRAKE_PRESETS, 'middle'],
    Rs: ['R*: new stars per year in the Milky Way', null, null, 1.5, 0],
    fp: ['f_p: share of stars with planets', null, null, 1, 0],
    ne: ['n_e: habitable planets per such system', null, null, 0.4, 0],
    fl: ['f_l: share that develop life', null, null, 0.1, 0],
    fi: ['f_i: share that develop intelligence', null, null, 0.1, 0],
    fc: ['f_c: share that communicate', null, null, 0.2, 0],
    L: ['L: years a civilisation communicates', null, null, 10000, 0],
};
const DRAKE_KEYS = ['Rs', 'fp', 'ne', 'fl', 'fi', 'fc', 'L'];
const drakeShow = Object.fromEntries(DRAKE_KEYS.map((k) => [k, 'preset:custom']));
const drakeWhen = Object.fromEntries(DRAKE_KEYS.map((k) => [k, (x) => x.preset === 'custom']));
const drakeN = (x) => (x.preset === 'custom' ? DRAKE_KEYS.map((k) => x[k]) : DRAKE_VALUES[x.preset]).reduce((a, b) => a * b, 1);
const DESTINATIONS = { proxima: ['Proxima Centauri (4.2465 ly)', 4.2465], barnard: ['Barnard’s Star (5.96 ly)', 5.96], sirius: ['Sirius (8.6 ly)', 8.60], trappist: ['TRAPPIST-1 (40.7 ly)', 40.66], vega: ['Vega (25 ly)', 25.04], centre: ['Galactic centre (26,670 ly)', 26670], andromeda: ['Andromeda Galaxy (2.5 million ly)', 2.5e6] };

/** Flip-and-burn trip at proper acceleration a over distance d (m): ship time, Earth time, peak speed. */
function flipBurn(d, a) {
    const k = 1 + (a * d) / (2 * c * c);
    const tau = (2 * c / a) * Math.acosh(k);
    const t = (2 * c / a) * Math.sqrt(k * k - 1);

    return { tau, t, vmax: c * Math.tanh((a * tau) / (2 * c)), gmax: k };
}

export const TOOLS = {
    // Astronomy ----------------------------------------------------------------------------------
    alien_civilizations: {
        type: 'calc',
        inputs: { ...DRAKE_INPUTS, Rg: ['Galactic disc radius', 'astronomical', 'ly', 50000], H: ['Disc thickness', 'astronomical', 'ly', 1000] },
        show: drakeShow,
        when: drakeWhen,
        label: 'Civilisations communicating now',
        rows: { nearest: 'Typical distance to the nearest', round: 'Round-trip signal time to it', note: 'Caveat' },
        run: (x) => {
            const N = drakeN(x);
            const ly = K.ly;
            const V = Math.PI * (x.Rg / ly) ** 2 * (x.H / ly);
            const d = N >= 1 ? 0.554 * (V / N) ** (1 / 3) : NaN;

            return { value: num(N, 4), sub: N < 1 ? 'Fewer than one: we may be alone in the galaxy right now' : `Nearest about ${num(d, 3)} light years away`, rows: { nearest: N >= 1 ? `${num(d, 3)} ly` : 'Probably none in the galaxy', round: N >= 1 ? `${num(2 * d, 3)} years` : 'No neighbour to signal', note: 'Most factors are unknown by orders of magnitude: this explores assumptions, it does not predict' }, steps: ['N = R* × f_p × n_e × f_l × f_i × f_c × L', `= ${num(N)}`, 'Spread evenly through a disc, the nearest neighbour is about 0.554 (V ÷ N)^(1/3) away'] };
        },
    },
    delta_v: {
        type: 'calc',
        inputs: { mode: ['Engine given as', 'select', { isp: 'Specific impulse', ve: 'Exhaust velocity' }, 'isp'], isp: ['Specific impulse (s)', null, null, 311, 0], ve: ['Exhaust velocity', 'speed', 'kms', 3.05], m0: ['Wet mass (start)', 'mass', 't', 549], mf: ['Dry mass (end)', 'mass', 't', 140] },
        show: { isp: 'mode:isp', ve: 'mode:ve' },
        when: { isp: (x) => x.mode === 'isp', ve: (x) => x.mode === 've' },
        out: 'speed',
        outUnit: 'kms',
        label: 'Delta-v',
        rows: { ratio: 'Mass ratio m₀/m_f', prop: ['Propellant used', 'mass'], fraction: 'Propellant fraction' },
        run: (x) => {
            if (!(x.m0 > x.mf)) {
                return { error: 'The wet mass must be larger than the dry mass.' };
            }

            const ve = x.mode === 'isp' ? x.isp * g0 : x.ve;
            const dv = ve * Math.log(x.m0 / x.mf);

            return { value: dv, sub: `Exhaust velocity ${num(ve)} m/s`, rows: { ratio: num(x.m0 / x.mf, 4), prop: [x.m0 - x.mf, 'mass'], fraction: `${num((1 - x.mf / x.m0) * 100, 4)}%` }, steps: ['Δv = v_e ln(m₀ ÷ m_f), v_e = I_sp g₀', `= ${num(ve)} × ln(${num(x.m0 / x.mf)}) = ${num(dv)} m/s`, 'Ideal: gravity and drag losses (about 1.5–2 km/s to orbit) come on top'] };
        },
    },
    earth_orbit: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { h: 'The altitude', T: 'The period' }, 'h'], h: ['Altitude', 'astronomical', 'km', 420], T: ['Period', 'time', 'min', 92.7] },
        show: { h: 'mode:h', T: 'mode:T' },
        when: { h: (x) => x.mode === 'h', T: (x) => x.mode === 'T' },
        out: 'speed',
        outUnit: 'kms',
        label: 'Orbital speed',
        rows: { T: 'Period', h: ['Altitude', 'astronomical'], orbits: 'Orbits per day', g: 'Gravity at that height', esc: ['Escape velocity there', 'speed'] },
        run: (x) => {
            const mu = K.GMearth;
            const Re = 6378137;
            const r = x.mode === 'h' ? Re + x.h : Math.cbrt((mu * x.T * x.T) / (4 * Math.PI ** 2));

            if (!(r > Re)) {
                return { error: 'That orbit is inside the Earth.' };
            }

            const v = Math.sqrt(mu / r);
            const T = 2 * Math.PI * Math.sqrt(r ** 3 / mu);

            return { value: v, sub: `Period ${fmtTime(T)}`, rows: { T: fmtTime(T), h: [r - Re, 'astronomical'], orbits: num(86400 / T, 4), g: `${num(mu / (r * r))} m/s² (${num((mu / (r * r)) / g0 * 100, 3)}% of surface g)`, esc: [Math.sqrt(2) * v, 'speed'] }, steps: ['Circular orbit: v = √(GM ÷ r), T = 2π√(r³ ÷ GM)', `GM⊕ = 3.986004418 × 10¹⁴ m³/s², r = R⊕ + h = ${num(r / 1000)} km (equatorial radius 6,378.137 km)`, `v = ${num(v)} m/s, T = ${num(T)} s`] };
        },
    },
    escape_velocity: {
        type: 'calc',
        inputs: { body: BODY('earth'), ...customBody, h: ['Starting height above the surface', 'astronomical', 'km', 0] },
        show: customShow,
        when: customWhen,
        data: ['bodies'],
        out: 'speed',
        outUnit: 'kms',
        label: 'Escape velocity',
        rows: { orbit: ['Circular orbit speed there', 'speed'], g: 'Surface gravity' },
        run: (x, ctx) => {
            const [mu, r0] = gmR(x, ctx);
            const r = r0 + x.h;
            const v = Math.sqrt((2 * mu) / r);

            return { value: v, sub: `${num(v * 3.6)} km/h`, rows: { orbit: [v / Math.SQRT2, 'speed'], g: `${num(mu / (r0 * r0))} m/s²` }, steps: ['v_e = √(2GM ÷ r)', `= √(2 × ${num(mu)} ÷ ${num(r)}) = ${num(v)} m/s`, 'Ignores air drag and the body’s rotation'] };
        },
    },
    exoplanet: {
        type: 'calc',
        inputs: { Ms: ['Star mass', 'astro_mass', 'msun', 1], Rs: ['Star radius (in solar radii)', null, null, 1, 0], Mp: ['Planet mass', 'astro_mass', 'mearth', 1], Rp: ['Planet radius (in Earth radii)', null, null, 1, 0], P: ['Orbital period', 'time', 'day', 365.256], incl: ['Inclination', 'angle', 'deg', 90] },
        label: 'Transit depth',
        rows: { K: 'Radial-velocity amplitude of the star', a: ['Orbit size (semi-major axis)', 'astronomical'], dur: 'Transit duration (central transit)', prob: 'Chance a random orientation transits', astro: 'Star’s wobble (astrometric, at 10 pc)' },
        run: (x) => {
            const rs = x.Rs * K.Rsun;
            const rp = x.Rp * K.Rearth;
            const a = Math.cbrt((K.G * (x.Ms + x.Mp) * x.P * x.P) / (4 * Math.PI ** 2));
            const depth = (rp / rs) ** 2;
            const Kv = ((2 * Math.PI * K.G) / x.P) ** (1 / 3) * (x.Mp * Math.sin(x.incl)) / (x.Ms + x.Mp) ** (2 / 3);
            const dur = (x.P / Math.PI) * Math.asin(Math.min(1, (rs + rp) / a));
            const wobble = (x.Mp / (x.Ms + x.Mp)) * (a / K.au) / 10;

            return { value: num(depth * 1e6, 4), unit: 'ppm', sub: `${num(depth * 100, 4)}% dip; star moves ${num(Kv, 3)} m/s`, rows: { K: `${num(Kv, 4)} m/s`, a: [a, 'astronomical'], dur: fmtTime(dur), prob: `${num((rs / a) * 100, 3)}%`, astro: `${num(wobble * 1e6, 3)} µas` }, steps: ['Transit depth δ = (R_p ÷ R_*)²', `= ${num(depth)}`, 'K = (2πG ÷ P)^(1/3) M_p sin i ÷ (M_* + M_p)^(2/3) (circular orbit)', `= ${num(Kv)} m/s`] };
        },
    },
    hohmann: {
        type: 'calc',
        inputs: { body: BODY('earth', true), r1: ['Starting orbit radius (from the centre)', 'astronomical', 'km', 6678], r2: ['Target orbit radius', 'astronomical', 'km', 42164] },
        data: ['bodies'],
        out: 'speed',
        outUnit: 'kms',
        label: 'Total delta-v',
        rows: { dv1: ['First burn', 'speed'], dv2: ['Second burn', 'speed'], t: 'Transfer time', at: ['Transfer orbit semi-major axis', 'astronomical'] },
        run: (x, ctx) => {
            const mu = GM(body(ctx, x.body));
            const at = (x.r1 + x.r2) / 2;
            const v1 = Math.sqrt(mu / x.r1);
            const v2 = Math.sqrt(mu / x.r2);
            const dv1 = Math.abs(Math.sqrt(mu * (2 / x.r1 - 1 / at)) - v1);
            const dv2 = Math.abs(v2 - Math.sqrt(mu * (2 / x.r2 - 1 / at)));
            const t = Math.PI * Math.sqrt(at ** 3 / mu);

            return { value: dv1 + dv2, sub: `${num(dv1)} m/s then ${num(dv2)} m/s, ${fmtTime(t)} apart`, rows: { dv1: [dv1, 'speed'], dv2: [dv2, 'speed'], t: fmtTime(t), at: [at, 'astronomical'] }, steps: ['Vis-viva: v² = GM(2/r − 1/a)', `Transfer a = (r₁ + r₂) ÷ 2 = ${num(at / 1000)} km`, `Δv₁ = ${num(dv1)} m/s, Δv₂ = ${num(dv2)} m/s`, `Transfer time = π√(a³ ÷ GM) = ${fmtTime(t)}`] };
        },
    },
    rocket_equation: {
        type: 'law',
        vars: { dv: ['Delta-v', 'speed', 'kms', 9.4], ve: ['Exhaust velocity', 'speed', 'kms', 3.4], m0: ['Initial (wet) mass', 'mass', 't', 100], mf: ['Final (dry) mass', 'mass', 't', 6.326] },
        default: 'mf',
        eq: 'Δv = v_e ln(m₀ ÷ m_f)',
        forms: { dv: 'Δv = v_e ln(m₀/m_f)', ve: 'v_e = Δv ÷ ln(m₀/m_f)', m0: 'm₀ = m_f e^(Δv/v_e)', mf: 'm_f = m₀ e^(−Δv/v_e)' },
        solve: { dv: (v) => v.ve * Math.log(v.m0 / v.mf), ve: (v) => v.dv / Math.log(v.m0 / v.mf), m0: (v) => v.mf * Math.exp(v.dv / v.ve), mf: (v) => v.m0 * Math.exp(-v.dv / v.ve) },
        rows: { ratio: 'Mass ratio', prop: 'Propellant share of the starting mass', isp: 'Specific impulse' },
        extra: (v) => ({ ratio: num(v.m0 / v.mf, 4), prop: `${num((1 - v.mf / v.m0) * 100, 4)}%`, isp: `${num(v.ve / g0, 4)} s` }),
    },
    kepler3: {
        type: 'law',
        vars: { T: ['Orbital period', 'time', 'day', 365.256], a: ['Semi-major axis', 'astronomical', 'au', 1], M: ['Central mass', 'astro_mass', 'msun', 1], m: ['Orbiting mass (optional)', 'astro_mass', 'mearth', 1] },
        optional: ['m'],
        default: 'T',
        eq: 'T² = 4π² a³ ÷ G(M + m)',
        forms: { T: 'T = 2π√(a³ ÷ G(M + m))', a: 'a = ∛(G(M + m)T² ÷ 4π²)', M: 'M = 4π²a³ ÷ GT² − m', m: 'm = 4π²a³ ÷ GT² − M' },
        solve: {
            T: (v) => 2 * Math.PI * Math.sqrt(v.a ** 3 / (K.G * (v.M + (v.m || 0)))),
            a: (v) => Math.cbrt((K.G * (v.M + (v.m || 0)) * v.T ** 2) / (4 * Math.PI ** 2)),
            M: (v) => (4 * Math.PI ** 2 * v.a ** 3) / (K.G * v.T ** 2) - (v.m || 0),
            m: (v) => (4 * Math.PI ** 2 * v.a ** 3) / (K.G * v.T ** 2) - v.M,
        },
        rows: { years: 'Period in years', v: 'Mean orbital speed' },
        extra: (v) => ({ years: num(v.T / (365.25 * 86400)), v: `${num((2 * Math.PI * v.a) / v.T / 1000)} km/s` }),
    },
    orbital_period: {
        type: 'calc',
        inputs: { mode: ['Know', 'select', { mass: 'Semi-major axis and central mass', density: 'Central body density (grazing orbit)' }, 'mass'], a: ['Semi-major axis', 'astronomical', 'km', 384400], M: ['Central mass', 'astro_mass', 'mearth', 1], rho: ['Mean density', 'density', 'gcm3', 5.51] },
        show: { a: 'mode:mass', M: 'mode:mass', rho: 'mode:density' },
        when: { a: (x) => x.mode === 'mass', M: (x) => x.mode === 'mass', rho: (x) => x.mode === 'density' },
        out: 'time',
        outUnit: 'day',
        label: 'Orbital period',
        rows: { human: 'Readable', v: ['Mean orbital speed', 'speed'] },
        run: (x) => {
            const T = x.mode === 'density' ? Math.sqrt((3 * Math.PI) / (K.G * x.rho)) : 2 * Math.PI * Math.sqrt(x.a ** 3 / (K.G * x.M));

            return { value: T, sub: fmtTime(T), rows: { human: fmtTime(T), v: x.mode === 'mass' ? [(2 * Math.PI * x.a) / T, 'speed'] : 'Needs the orbit size' }, steps: [x.mode === 'density' ? 'Orbit just above the surface: T = √(3π ÷ Gρ), independent of size' : 'T = 2π√(a³ ÷ GM)', `T = ${num(T)} s`] };
        },
    },
    orbital_velocity: {
        type: 'calc',
        inputs: { body: BODY('earth', true), r: ['Current distance from the centre', 'astronomical', 'km', 6778], a: ['Semi-major axis (equal to the distance for a circle)', 'astronomical', 'km', 6778] },
        data: ['bodies'],
        out: 'speed',
        outUnit: 'kms',
        label: 'Orbital speed',
        rows: { circ: ['Circular speed at that distance', 'speed'], esc: ['Escape speed there', 'speed'], T: 'Period' },
        run: (x, ctx) => {
            const mu = GM(body(ctx, x.body));
            const v2 = mu * (2 / x.r - 1 / x.a);

            if (!(v2 >= 0) || x.r > 2 * x.a) {
                return { error: 'That distance is outside the orbit (r must be at most 2a).' };
            }

            return { value: Math.sqrt(v2), sub: 'Vis-viva: v² = GM(2/r − 1/a)', rows: { circ: [Math.sqrt(mu / x.r), 'speed'], esc: [Math.sqrt((2 * mu) / x.r), 'speed'], T: fmtTime(2 * Math.PI * Math.sqrt(x.a ** 3 / mu)) }, steps: [`v = √(${num(mu)} × (2/${num(x.r)} − 1/${num(x.a)})) = ${num(Math.sqrt(v2))} m/s`] };
        },
    },
    rocket_thrust: {
        type: 'calc',
        inputs: { mdot: ['Mass flow rate', 'mass_flow', 'kgs', 300], ve: ['Exhaust velocity', 'speed', 'ms', 2800], pe: ['Nozzle exit pressure', 'pressure', 'kpa', 70], pa: ['Ambient pressure', 'pressure', 'kpa', 101.325], Ae: ['Nozzle exit area', 'area', 'm2', 0.9] },
        out: 'force',
        outUnit: 'kn',
        label: 'Thrust',
        rows: { mom: ['Momentum thrust', 'force'], press: ['Pressure thrust', 'force'], isp: 'Effective specific impulse', vac: ['Thrust in vacuum', 'force'] },
        run: (x) => {
            const mom = x.mdot * x.ve;
            const press = (x.pe - x.pa) * x.Ae;
            const F = mom + press;

            return { value: F, sub: `I_sp ${num(F / (x.mdot * g0), 4)} s`, rows: { mom: [mom, 'force'], press: [press, 'force'], isp: `${num(F / (x.mdot * g0), 4)} s`, vac: [mom + x.pe * x.Ae, 'force'] }, steps: ['F = ṁv_e + (p_e − p_a)A_e', `= ${num(mom)} + ${num(press)} = ${num(F)} N`] };
        },
    },
    specific_impulse: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { thrust: 'Thrust and mass flow', ve: 'Effective exhaust velocity' }, 'thrust'], F: ['Thrust', 'force', 'kn', 845], mdot: ['Mass flow rate', 'mass_flow', 'kgs', 277], ve: ['Exhaust velocity', 'speed', 'ms', 2990] },
        show: { F: 'mode:thrust', mdot: 'mode:thrust', ve: 'mode:ve' },
        when: { F: (x) => x.mode === 'thrust', mdot: (x) => x.mode === 'thrust', ve: (x) => x.mode === 've' },
        label: 'Specific impulse',
        rows: { ve: 'Effective exhaust velocity', typical: 'Typical values' },
        run: (x) => {
            const ve = x.mode === 'thrust' ? x.F / x.mdot : x.ve;

            return { value: num(ve / g0, 5), unit: 's', sub: `v_e = ${num(ve)} m/s`, rows: { ve: `${num(ve)} m/s`, typical: 'Solid rocket 250–290 s, kerosene/LOX 300–350 s, hydrogen/LOX 380–450 s, ion thruster 1,500–5,000 s' }, steps: ['I_sp = F ÷ (ṁ g₀) = v_e ÷ g₀', `= ${num(ve)} ÷ 9.80665 = ${num(ve / g0)} s`] };
        },
    },
    synodic: {
        type: 'calc',
        inputs: { p1: ['First body', 'select', PLANETS, 'earth'], T1: ['First period', 'time', 'day', 365.256], p2: ['Second body', 'select', PLANETS, 'mars'], T2: ['Second period', 'time', 'day', 686.98] },
        show: { T1: 'p1:custom', T2: 'p2:custom' },
        when: { T1: (x) => x.p1 === 'custom', T2: (x) => x.p2 === 'custom' },
        data: ['bodies'],
        out: 'time',
        outUnit: 'day',
        label: 'Synodic period',
        rows: { human: 'Readable', periods: 'Sidereal periods used' },
        run: (x, ctx) => {
            const per = (p, T) => (p === 'custom' ? T : body(ctx, p).period_d * 86400);
            const a = per(x.p1, x.T1);
            const b = per(x.p2, x.T2);

            if (a === b) {
                return { error: 'Equal periods never line up again: the synodic period is infinite.' };
            }

            const S = 1 / Math.abs(1 / a - 1 / b);

            return { value: S, sub: fmtTime(S), rows: { human: fmtTime(S), periods: `${num(a / 86400)} and ${num(b / 86400)} days` }, steps: ['1/S = |1/T₁ − 1/T₂|', `S = ${num(S / 86400)} days`] };
        },
    },
    twr: {
        type: 'calc',
        inputs: { F: ['Thrust', 'force', 'kn', 7607], m: ['Mass', 'mass', 't', 549], body: ['Gravity of', 'select', { earth: 'Earth (9.80665 m/s²)', moon: 'Moon', mars: 'Mars', custom: 'Custom' }, 'earth'], g: ['Gravity', 'acceleration', 'ms2', 9.80665] },
        show: { g: 'body:custom' },
        when: { g: (x) => x.body === 'custom' },
        data: ['bodies'],
        label: 'Thrust-to-weight ratio',
        rows: { a: 'Initial upward acceleration', lift: 'Lifts off?' },
        run: (x, ctx) => {
            const g = x.body === 'earth' ? g0 : x.body === 'custom' ? x.g : GM(body(ctx, x.body)) / R(body(ctx, x.body)) ** 2;
            const twr = x.F / (x.m * g);

            return { value: num(twr, 4), sub: `Weight ${num(x.m * g / 1000)} kN`, rows: { a: `${num((twr - 1) * g)} m/s² (${num(twr - 1, 3)} g)`, lift: twr > 1 ? 'Yes' : 'No: thrust is less than the weight' }, steps: ['TWR = F ÷ (m g)', `= ${num(x.F)} ÷ (${num(x.m)} × ${num(g)}) = ${num(twr)}`] };
        },
    },
    ufo_travel: {
        type: 'calc',
        inputs: { dest: ['Destination', 'select', { ...Object.fromEntries(Object.entries(DESTINATIONS).map(([k, v]) => [k, v[0]])), custom: 'Other distance' }, 'proxima'], d: ['Distance', 'astronomical', 'ly', 10], mode: ['Travel', 'select', { speed: 'At a constant speed', accel: 'Accelerate, flip, decelerate' }, 'speed'], v: ['Cruise speed', 'speed', 'c', 0.5], a: ['Acceleration', 'acceleration', 'g0', 1] },
        show: { d: 'dest:custom', v: 'mode:speed', a: 'mode:accel' },
        when: { d: (x) => x.dest === 'custom', v: (x) => x.mode === 'speed', a: (x) => x.mode === 'accel' },
        label: 'Time on board',
        rows: { earth: 'Time on Earth', vmax: 'Top speed', gamma: 'Top Lorentz factor' },
        run: (x) => {
            const d = x.dest === 'custom' ? x.d : DESTINATIONS[x.dest][1] * K.ly;

            if (x.mode === 'speed') {
                if (!(x.v > 0 && x.v < c)) {
                    return { error: 'The speed must be between 0 and the speed of light.' };
                }

                const t = d / x.v;

                return { value: fmtTime(t / gamma(x.v)), sub: `Earth sees ${fmtTime(t)}`, rows: { earth: fmtTime(t), vmax: `${num(x.v / c)} c`, gamma: num(gamma(x.v)) }, steps: [`Earth time = d ÷ v = ${fmtTime(t)}`, `Ship time = Earth time ÷ γ, γ = ${num(gamma(x.v))}`, 'Ignores the time needed to speed up and slow down'] };
            }

            const f = flipBurn(d, x.a);

            return { value: fmtTime(f.tau), sub: `Earth sees ${fmtTime(f.t)}`, rows: { earth: fmtTime(f.t), vmax: `${num(f.vmax / c)} c`, gamma: num(f.gmax) }, steps: ['Half the way at proper acceleration a, then decelerate', 'τ = (2c/a) arcosh(1 + ad/2c²), t = (2c/a) √((1 + ad/2c²)² − 1)', `τ = ${fmtTime(f.tau)}, t = ${fmtTime(f.t)}`] };
        },
    },
    surface_gravity: {
        type: 'calc',
        inputs: { body: BODY('mars'), ...customBody },
        show: customShow,
        when: customWhen,
        data: ['bodies'],
        out: 'acceleration',
        outUnit: 'ms2',
        label: 'Surface gravity',
        rows: { g: 'Compared with Earth', jump: 'A 50 cm jump on Earth becomes', esc: ['Escape velocity', 'speed'] },
        run: (x, ctx) => {
            const [mu, r] = gmR(x, ctx);
            const g = mu / (r * r);

            return { value: g, sub: `${num(g / g0, 4)} × Earth’s standard gravity`, rows: { g: `${num(g / g0, 4)} g`, jump: `${num((0.5 * g0) / g, 3)} m`, esc: [Math.sqrt((2 * mu) / r), 'speed'] }, steps: ['g = GM ÷ r²', `= ${num(mu)} ÷ ${num(r)}² = ${num(g)} m/s²`, 'At the mean radius, without rotation'] };
        },
    },
    roche: {
        type: 'calc',
        inputs: { Rp: ['Primary radius', 'astronomical', 'km', 6371], rhoM: ['Primary density', 'density', 'gcm3', 5.51], rhom: ['Satellite density', 'density', 'gcm3', 3.34], kind: ['Satellite', 'select', { fluid: 'Fluid (held together by gravity only)', rigid: 'Rigid' }, 'fluid'] },
        out: 'astronomical',
        outUnit: 'km',
        label: 'Roche limit',
        rows: { radii: 'In primary radii', other: ['Other model', 'astronomical'] },
        run: (x) => {
            const q = Math.cbrt(x.rhoM / x.rhom);
            const fluid = 2.44 * x.Rp * q;
            const rigid = 1.26 * x.Rp * q;
            const d = x.kind === 'fluid' ? fluid : rigid;

            return { value: d, sub: `${num(d / x.Rp, 4)} primary radii`, rows: { radii: num(d / x.Rp, 4), other: [x.kind === 'fluid' ? rigid : fluid, 'astronomical'] }, steps: [x.kind === 'fluid' ? 'Fluid: d ≈ 2.44 R (ρ_M ÷ ρ_m)^(1/3)' : 'Rigid: d ≈ 1.26 R (ρ_M ÷ ρ_m)^(1/3)', `= ${num(d / 1000)} km`, 'Real moons lie between the two limits'] };
        },
    },
    hill_sphere: {
        type: 'calc',
        inputs: { M: ['Central mass', 'astro_mass', 'msun', 1], m: ['Orbiting body mass', 'astro_mass', 'mearth', 1], a: ['Semi-major axis', 'astronomical', 'au', 1], e: ['Eccentricity', null, null, 0.0167, 0] },
        out: 'astronomical',
        outUnit: 'km',
        label: 'Hill sphere radius',
        rows: { au: 'In AU', moons: 'Stable moons orbit within about' },
        run: (x) => {
            const r = x.a * (1 - x.e) * Math.cbrt(x.m / (3 * x.M));

            return { value: r, sub: `${num(r / K.au, 4)} AU`, rows: { au: `${num(r / K.au, 4)} AU`, moons: `½ to ⅓ of it: ${num(r / 3 / 1000, 3)}–${num(r / 2 / 1000, 3)} km` }, steps: ['r_H ≈ a(1 − e) ∛(m ÷ 3M)', `= ${num(r / 1000)} km`] };
        },
    },

    // Astrophysics -------------------------------------------------------------------------------
    bh_collision: {
        type: 'calc',
        inputs: { m1: ['First black hole mass', 'astro_mass', 'msun', 36], m2: ['Second black hole mass', 'astro_mass', 'msun', 29] },
        out: 'astro_mass',
        outUnit: 'msun',
        label: 'Final black hole mass',
        rows: { E: ['Energy radiated as gravitational waves', 'energy'], Em: 'Radiated mass-energy', spin: 'Final spin (dimensionless)', eta: 'Symmetric mass ratio η' },
        run: (x) => {
            const M = x.m1 + x.m2;
            const eta = (x.m1 * x.m2) / M ** 2;
            const frac = (1 - Math.sqrt(8 / 9)) * eta + 0.546 * eta * eta;
            const spin = 2 * Math.sqrt(3) * eta - 2.88 * eta * eta;

            return { value: M * (1 - frac), sub: `${num(frac * 100, 3)}% of the mass radiated as gravitational waves`, rows: { E: [frac * M * c * c, 'energy'], Em: `${num((frac * M) / MSUN, 3)} M☉`, spin: num(spin, 3), eta: num(eta, 4) }, steps: ['Non-spinning, quasi-circular merger (an estimate)', 'E_rad/M ≈ (1 − √(8/9))η + 0.546η² (test-particle limit plus a fit to numerical relativity at equal masses)', 'a_f ≈ 2√3 η − 2.88η²', 'Check: GW150914 (36 + 29 M☉) measured 62 M☉ and 3.0 M☉ radiated, spin 0.67'] };
        },
    },
    bh_temperature: {
        type: 'calc',
        inputs: { M: ['Black hole mass', 'astro_mass', 'msun', 1] },
        out: 'temperature',
        outUnit: 'k',
        label: 'Hawking temperature',
        rows: { rs: ['Schwarzschild radius', 'astronomical'], P: ['Hawking luminosity', 'power'], life: 'Evaporation time', cmb: 'Compared with the 2.725 K cosmic background' },
        run: (x) => {
            const T = (K.hbar * c ** 3) / (8 * Math.PI * K.G * x.M * K.k);
            const life = (5120 * Math.PI * K.G ** 2 * x.M ** 3) / (K.hbar * c ** 4);
            const P = (K.hbar * c ** 6) / (15360 * Math.PI * K.G ** 2 * x.M ** 2);

            return { value: T, sub: `Evaporates in ${num(life / (365.25 * 86400))} years`, rows: { rs: [(2 * K.G * x.M) / c ** 2, 'astronomical'], P: [P, 'power'], life: `${num(life / (365.25 * 86400))} years (${num(life)} s)`, cmb: T < 2.725 ? 'Colder: today it absorbs more than it emits and grows' : 'Hotter: it is evaporating' }, steps: ['T = ħc³ ÷ (8πGMk)', `= ${num(T)} K`, 'Evaporation time t = 5120πG²M³ ÷ (ħc⁴) (photons only, an idealisation)'] };
        },
    },
    drake: {
        type: 'calc',
        inputs: DRAKE_INPUTS,
        show: drakeShow,
        when: drakeWhen,
        label: 'Communicating civilisations in the Milky Way',
        rows: { values: 'Factors used', note: 'Caveat' },
        run: (x) => {
            const vals = x.preset === 'custom' ? DRAKE_KEYS.map((k) => x[k]) : DRAKE_VALUES[x.preset];
            const N = vals.reduce((a, b) => a * b, 1);

            return { value: num(N, 4), sub: N < 1 ? 'Fewer than one at any time' : 'Expected number at any one time', rows: { values: DRAKE_KEYS.map((k, i) => `${k} = ${num(vals[i])}`).join(', '), note: 'R* and f_p are now measured; the other factors are guesses spanning many orders of magnitude' }, steps: ['N = R* × f_p × n_e × f_l × f_i × f_c × L', `= ${vals.map((v) => num(v)).join(' × ')} = ${num(N)}`] };
        },
    },
    hubble_distance: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { z: 'Redshift z', v: 'Recession velocity' }, 'z'], z: ['Redshift z', null, null, 0.05, 0], v: ['Recession velocity', 'speed', 'kms', 15000], H0: ['Hubble constant (km/s/Mpc)', null, null, 67.4, 0], Om: ['Matter density Ωm', null, null, 0.315, 0] },
        show: { z: 'mode:z', v: 'mode:v' },
        when: { z: (x) => x.mode === 'z', v: (x) => x.mode === 'v' },
        out: 'astronomical',
        outUnit: 'ly',
        label: 'Comoving (proper, today) distance',
        rows: { simple: ['Simple Hubble law cz ÷ H₀', 'astronomical'], lum: ['Luminosity distance', 'astronomical'], mpc: 'In megaparsecs', lookback: 'Light travel time' },
        run: (x) => {
            const z = x.mode === 'z' ? x.z : x.v / c;
            const cos = cosmology(x.H0, x.Om);
            const dc = cos.comoving(z);
            const lookback = cos.age(1) - cos.age(1 / (1 + z));

            return { value: dc, sub: `${num(dc / MPC)} Mpc; light left ${num(lookback / GYR, 4)} billion years ago`, rows: { simple: [(c * z) / cos.H, 'astronomical'], lum: [dc * (1 + z), 'astronomical'], mpc: `${num(dc / MPC)} Mpc`, lookback: `${num(lookback / GYR, 4)} billion years` }, steps: ['Hubble law: v = H₀d (valid for z ≪ 1)', `Flat ΛCDM: d_C = (c/H₀) ∫ dz′ ÷ E(z′), H₀ = ${num(x.H0)}, Ωm = ${num(x.Om)}`, `d_C = ${num(dc / MPC)} Mpc`, ...(x.mode === 'v' ? ['z taken as v ÷ c'] : [])] };
        },
    },
    luminosity: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { rt: 'Radius and temperature', flux: 'Flux and distance' }, 'rt'], Rs: ['Radius (in solar radii)', null, null, 1, 0], T: ['Surface temperature', 'temperature', 'k', 5772], F: ['Measured flux', 'intensity', 'wm2', 1361], d: ['Distance', 'astronomical', 'au', 1] },
        show: { Rs: 'mode:rt', T: 'mode:rt', F: 'mode:flux', d: 'mode:flux' },
        when: { Rs: (x) => x.mode === 'rt', T: (x) => x.mode === 'rt', F: (x) => x.mode === 'flux', d: (x) => x.mode === 'flux' },
        out: 'power',
        outUnit: 'w',
        label: 'Luminosity',
        rows: { sun: 'In solar luminosities', mag: 'Absolute bolometric magnitude', peak: 'Peak wavelength' },
        run: (x) => {
            const L = x.mode === 'rt' ? 4 * Math.PI * (x.Rs * K.Rsun) ** 2 * K.sigma * x.T ** 4 : 4 * Math.PI * x.d ** 2 * x.F;

            return { value: L, sub: `${num(L / K.Lsun, 4)} L☉`, rows: { sun: `${num(L / K.Lsun, 4)} L☉`, mag: num(4.74 - 2.5 * Math.log10(L / K.Lsun), 4), peak: x.mode === 'rt' ? `${num((K.wien / x.T) * 1e9, 4)} nm` : 'Needs the temperature' }, steps: [x.mode === 'rt' ? 'L = 4πR²σT⁴' : 'L = 4πd²F', `= ${num(L)} W`, 'L☉ = 3.828 × 10²⁶ W (IAU nominal)'] };
        },
    },
    olbers: {
        type: 'calc',
        inputs: { n: ['Star density (stars per cubic parsec)', null, null, 0.1, 0], Rs: ['Typical star radius (solar radii)', null, null, 1, 0], age: ['Age of the universe (billion years)', null, null, 13.8, 0] },
        label: 'Share of the sky covered by stars',
        rows: { mfp: 'Distance a sightline travels before hitting a star', reach: 'How far we can see (light travel distance)', verdict: 'Why the sky is dark' },
        run: (x) => {
            const n = x.n / (K.pc ** 3);
            const sigma = Math.PI * (x.Rs * K.Rsun) ** 2;
            const mfp = 1 / (n * sigma);
            const reach = c * x.age * GYR;
            const cover = -Math.expm1(-reach / mfp);

            return { value: `${num(cover * 100, 3)}%`, sub: 'Even an infinite, eternal universe of stars needs about 10²³ light years of sightline', rows: { mfp: `${num(mfp / K.ly, 3)} light years`, reach: `${num(reach / K.ly, 3)} light years`, verdict: 'The universe has a finite age, so we see only a thin shell of starlight; expansion redshifts it further. Without those, every sightline would end on a star and the sky would blaze like the Sun' }, steps: ['Mean free path λ = 1 ÷ (nπR²)', `λ = ${num(mfp / K.ly)} ly`, 'Covered fraction = 1 − e^(−ct ÷ λ)', `= ${num(cover)}`] };
        },
    },
    parallax: pw({ vars: { d: ['Distance', 'astronomical', 'pc', 1.30197], p: ['Parallax angle', 'angle', 'arcsec', 0.768067] }, out: 'd', k: K.au, exp: { p: -1 }, eq: 'd = 1 ÷ p (parsecs and arcseconds)', forms: { d: 'd = 1 ÷ p', p: 'p = 1 ÷ d' }, rows: { ly: 'In light years', mas: 'Parallax in milliarcseconds' }, extra: (v) => ({ ly: `${num(v.d / K.ly)} ly`, mas: `${num(v.p / D * 3600 * 1000)} mas` }) }),
    radiation_pressure: {
        type: 'calc',
        inputs: { I: ['Intensity', 'intensity', 'wm2', 1361], surface: ['Surface', 'select', { absorb: 'Absorbing (black)', reflect: 'Perfectly reflecting', partial: 'Partly reflecting' }, 'reflect'], refl: ['Reflectivity (%)', null, null, 90, 0], angle: ['Angle from the surface normal', 'angle', 'deg', 0], A: ['Area (optional)', 'area', 'm2', 100] },
        show: { refl: 'surface:partial' },
        when: { refl: (x) => x.surface === 'partial' },
        optional: ['A'],
        label: 'Radiation pressure',
        rows: { F: ['Force on that area', 'force'], ua: 'Acceleration of a 1 kg sail of that area' },
        run: (x) => {
            const r = { absorb: 0, reflect: 1, partial: x.refl / 100 }[x.surface];
            const P = ((1 + r) * x.I * Math.cos(x.angle) ** 2) / c;

            return { value: num(P * 1e6), unit: 'µPa', sub: `${num(P)} Pa = ${num(P * 1e6)} µN/m²`, rows: { F: Number.isFinite(x.A) ? [P * x.A, 'force'] : 'Enter an area', ua: Number.isFinite(x.A) ? `${num(P * x.A)} m/s²` : 'Enter an area' }, steps: ['P = (1 + r) I cos²θ ÷ c (normal component; r = reflectivity)', `= ${num(1 + r)} × ${num(x.I)} × ${num(Math.cos(x.angle) ** 2)} ÷ c = ${num(P)} Pa`] };
        },
    },
    redshift: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { wl: 'Observed and emitted wavelengths', v: 'Velocity (relativistic Doppler)' }, 'wl'], obs: ['Observed wavelength', 'length', 'nm', 721.9], emit: ['Emitted (rest) wavelength', 'length', 'nm', 656.28], v: ['Velocity away from us', 'speed', 'kms', 30000] },
        show: { obs: 'mode:wl', emit: 'mode:wl', v: 'mode:v' },
        when: { obs: (x) => x.mode === 'wl', emit: (x) => x.mode === 'wl', v: (x) => x.mode === 'v' },
        label: 'Redshift z',
        rows: { v: 'Equivalent Doppler velocity', simple: 'Simple estimate cz', scale: 'Universe was smaller by' },
        run: (x) => {
            const z = x.mode === 'wl' ? x.obs / x.emit - 1 : Math.sqrt((1 + x.v / c) / (1 - x.v / c)) - 1;
            const v = (c * ((1 + z) ** 2 - 1)) / ((1 + z) ** 2 + 1);

            return { value: num(z, 5), sub: z < 0 ? 'Blueshift: approaching' : 'Redshift: receding', rows: { v: `${num(v / 1000)} km/s (${num(v / c, 4)} c)`, simple: `${num((c * z) / 1000)} km/s`, scale: `a factor of ${num(1 + z, 5)} (cosmological interpretation)` }, steps: ['1 + z = λ_obs ÷ λ_emit = √((1 + β) ÷ (1 − β))', `z = ${num(z)}`, 'For distant galaxies z comes from expansion, not motion: use the Hubble distance calculator'] };
        },
    },
    schwarzschild: {
        type: 'calc',
        inputs: { M: ['Mass', 'astro_mass', 'msun', 1] },
        out: 'astronomical',
        outUnit: 'km',
        label: 'Schwarzschild radius',
        rows: { photon: ['Photon sphere (1.5 r_s)', 'astronomical'], isco: ['Innermost stable orbit (3 r_s)', 'astronomical'], rho: 'Mean density inside r_s', tidal: 'Tidal stretch at r_s (per metre)' },
        run: (x) => {
            const rs = (2 * K.G * x.M) / c ** 2;

            return { value: rs, sub: `${num(rs)} m`, rows: { photon: [1.5 * rs, 'astronomical'], isco: [3 * rs, 'astronomical'], rho: `${num(x.M / ((4 / 3) * Math.PI * rs ** 3))} kg/m³`, tidal: `${num((2 * K.G * x.M) / rs ** 3)} m/s² per metre` }, steps: ['r_s = 2GM ÷ c²', `= 2 × ${num(K.G)} × ${num(x.M)} ÷ c² = ${num(rs)} m`] };
        },
    },
    universe_expansion: {
        type: 'calc',
        inputs: { z: ['Redshift z', null, null, 1, 0], H0: ['Hubble constant (km/s/Mpc)', null, null, 67.4, 0], Om: ['Matter density Ωm', null, null, 0.315, 0] },
        label: 'Age of the universe then',
        rows: { now: 'Age today', lookback: 'Light travel time', dc: ['Distance today (comoving)', 'astronomical'], vrec: 'Recession speed today', Hz: 'Hubble rate then', a: 'Scale factor then' },
        plots: [['scale', 'Scale factor over time']],
        run: (x) => {
            const cos = cosmology(x.H0, x.Om);
            const a = 1 / (1 + x.z);
            const tNow = cos.age(1);
            const tThen = cos.age(a);
            const dc = cos.comoving(x.z);
            const series = Array.from({ length: 61 }, (_, k) => {
                const aa = (k / 40) ** 1.5;

                return [cos.age(Math.max(aa, 1e-6)) / GYR, aa];
            });

            return { value: `${num(tThen / GYR, 4)} billion years`, sub: `Today ${num(tNow / GYR, 4)} billion years`, rows: { now: `${num(tNow / GYR, 4)} billion years`, lookback: `${num((tNow - tThen) / GYR, 4)} billion years`, dc: [dc, 'astronomical'], vrec: `${num((cos.H * dc) / 1000)} km/s (${num((cos.H * dc) / c, 4)} c)`, Hz: `${num(x.H0 * cos.E(a))} km/s/Mpc`, a: num(a, 4) }, steps: [`Flat ΛCDM: Ωm = ${num(x.Om)}, ΩΛ = ${num(cos.OL, 4)}, Ωr = ${num(cos.Or, 3)}`, 'Age at scale factor a: t = ∫₀ᵃ da′ ÷ (a′H(a′))', `t(z = ${num(x.z)}) = ${num(tThen / GYR)} Gyr`, 'Recession speed today = H₀ d (can exceed c: space itself expands)'], plots: { scale: { series, axes: true, xLabel: 'Time since the Big Bang (Gyr)', yLabel: 'Scale factor a' } } };
        },
    },
    magnitude: {
        type: 'law',
        vars: { m: ['Apparent magnitude m', null, null, -1.46], Mabs: ['Absolute magnitude M', null, null, 1.42], d: ['Distance', 'astronomical', 'pc', 2.64] },
        default: 'Mabs',
        eq: 'm − M = 5 log₁₀(d ÷ 10 pc)',
        forms: { m: 'm = M + 5 log₁₀(d/10 pc)', Mabs: 'M = m − 5 log₁₀(d/10 pc)', d: 'd = 10 pc × 10^((m − M)/5)' },
        solve: { m: (v) => v.Mabs + 5 * Math.log10(v.d / (10 * K.pc)), Mabs: (v) => v.m - 5 * Math.log10(v.d / (10 * K.pc)), d: (v) => 10 * K.pc * 10 ** ((v.m - v.Mabs) / 5) },
        rows: { mod: 'Distance modulus m − M', ratio: 'Brightness compared with the Sun at the same distance' },
        extra: (v) => ({ mod: num(v.m - v.Mabs, 4), ratio: `${num(10 ** ((4.83 - v.Mabs) / 2.5))} × (visual)` }),
    },

    // Relativity ---------------------------------------------------------------------------------
    barn_pole: {
        type: 'calc',
        inputs: { pole: ['Pole length (at rest)', 'length', 'm', 20], barn: ['Barn length (at rest)', 'length', 'm', 10], v: ['Speed', 'speed', 'c', 0.9] },
        label: 'In the barn’s frame, the pole is',
        rows: { pole: 'Pole length seen by the barn', barn: 'Barn length seen by the runner', fits: 'Fits with both doors shut?', runner: 'Runner’s view', resolution: 'Resolution' },
        run: (x) => {
            if (!(x.v > 0 && x.v < c)) {
                return { error: 'The speed must be between 0 and c.' };
            }

            const g = gamma(x.v);
            const lp = x.pole / g;
            const lb = x.barn / g;
            const fits = lp <= x.barn;
            const dt = (g * x.v * x.barn) / (c * c);

            return { value: `${num(lp, 4)} m long`, sub: `γ = ${num(g, 4)}`, rows: { pole: `${num(lp, 4)} m`, barn: `${num(lb, 4)} m`, fits: fits ? 'Yes, for an instant, in the barn frame' : 'No: it is too long even contracted', runner: `The barn is only ${num(lb, 4)} m, so the pole never fits; the exit door opens ${num(dt * 1e9)} ns before the entrance door shuts`, resolution: 'Events that are simultaneous in one frame are not in the other: both views are correct, and nothing contradicts' }, steps: ['Contracted pole L = L₀ ÷ γ', `γ = 1 ÷ √(1 − ${num(x.v / c)}²) = ${num(g)}`, `Pole ${num(lp)} m in a ${num(x.barn)} m barn`, 'In the pole frame the door events are separated by γvL_barn ÷ c²'] };
        },
    },
    bug_rivet: {
        type: 'calc',
        inputs: { shank: ['Rivet shank length (at rest)', 'length', 'cm', 1], hole: ['Hole depth to the bug (at rest)', 'length', 'cm', 1.2], v: ['Rivet speed', 'speed', 'c', 0.8] },
        label: 'Does the bug survive?',
        rows: { holeFrame: 'Hole frame', rivetFrame: 'Rivet frame', tip: 'How far the tip gets', resolution: 'Resolution' },
        run: (x) => {
            if (!(x.v > 0 && x.v < c)) {
                return { error: 'The speed must be between 0 and c.' };
            }

            const b = x.v / c;
            const g = gamma(x.v);
            const reach = x.shank * Math.sqrt((1 + b) / (1 - b));
            const dies = reach >= x.hole;

            return { value: dies ? 'No, it is squashed' : 'Yes, it survives', sub: `The tip reaches ${num(reach * 100, 4)} cm before the stop signal catches it`, rows: { holeFrame: `The shank is contracted to ${num((x.shank / g) * 100, 4)} cm, shorter than the hole`, rivetFrame: `The hole is contracted to ${num((x.hole / g) * 100, 4)} cm`, tip: `${num(reach * 100, 4)} cm (limit L√((1 + β)/(1 − β)))`, resolution: 'No body is rigid: the tip keeps moving until news of the head stopping reaches it at most at light speed. Both frames then agree on the outcome' }, steps: ['Tip travel with a light-speed stop signal: L_tip = L √((1 + β) ÷ (1 − β))', `= ${num(reach * 100)} cm vs a ${num(x.hole * 100)} cm hole`] };
        },
    },
    electron_speed: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { volts: 'Accelerating voltage', ke: 'Kinetic energy' }, 'volts'], V: ['Accelerating voltage', 'voltage', 'kv', 100], E: ['Kinetic energy', 'particle_energy', 'kev', 100] },
        show: { V: 'mode:volts', E: 'mode:ke' },
        when: { V: (x) => x.mode === 'volts', E: (x) => x.mode === 'ke' },
        out: 'speed',
        outUnit: 'c',
        label: 'Electron speed',
        rows: { kms: ['In km/s', 'speed'], gamma: 'Lorentz factor γ', classical: 'Classical (wrong at high energy)', lambda: 'De Broglie wavelength' },
        run: (x) => {
            const KE = x.mode === 'volts' ? K.e * x.V : x.E;
            const mc2 = K.me * c * c;
            const g = 1 + KE / mc2;
            const v = c * Math.sqrt(1 - 1 / (g * g));
            const p = g * K.me * v;

            return { value: v, sub: `γ = ${num(g)}`, rows: { kms: [v, 'speed'], gamma: num(g), classical: `${num(Math.sqrt((2 * KE) / K.me) / c)} c${Math.sqrt((2 * KE) / K.me) > c ? ' (faster than light: impossible)' : ''}`, lambda: `${num((K.h / p) * 1e12)} pm` }, steps: ['K = (γ − 1)mc², mc² = 511 keV', `γ = 1 + ${num(KE / K.e / 1000)} keV ÷ 510.999 keV = ${num(g)}`, `v = c√(1 − 1/γ²) = ${num(v / c)} c`] };
        },
    },
    emc2: pw({ vars: { E: ['Energy', 'energy', 'j', 8.98755e16], m: ['Mass', 'mass', 'kg', 1] }, out: 'E', k: c * c, exp: { m: 1 }, eq: 'E = m c²', forms: { E: 'E = mc²', m: 'm = E ÷ c²' }, rows: { tnt: 'TNT equivalent', kwh: 'In kilowatt-hours', homes: 'Years of an average home’s electricity (10,000 kWh/yr)' }, extra: (v) => ({ tnt: `${num(v.E / 4.184e12)} kt TNT`, kwh: `${num(v.E / 3.6e6)} kWh`, homes: num(v.E / 3.6e6 / 10000) }) }),
    grav_time_dilation: {
        type: 'calc',
        inputs: { body: BODY('earth'), ...customBody, h1: ['Lower clock height', 'astronomical', 'km', 0], h2: ['Higher clock height', 'astronomical', 'km', 20200] },
        show: customShow,
        when: customWhen,
        data: ['bodies'],
        label: 'Higher clock gains per day',
        rows: { ratio: 'Rate ratio (higher ÷ lower)', year: 'Per year', note: 'Note' },
        run: (x, ctx) => {
            const [mu, r0] = gmR(x, ctx);
            const rate = (h) => Math.sqrt(1 - (2 * mu) / (c * c * (r0 + h)));
            const ratio = rate(x.h2) / rate(x.h1);
            const day = (ratio - 1) * 86400;

            return { value: `${num(day * 1e6)} µs`, sub: `Fractional rate difference ${num(ratio - 1)}`, rows: { ratio: `1 + ${num(ratio - 1)}`, year: `${num(day * 365.25 * 1e3)} ms`, note: 'Gravity only: a moving clock also runs slow (for GPS, −7.2 µs/day from orbital speed, so +38.5 µs/day net)' }, steps: ['t = t₀ √(1 − 2GM ÷ rc²) (Schwarzschild)', `Ratio = ${num(ratio, 15)}`, `Gain per day = ${num(day * 1e6)} µs`] };
        },
    },
    length_contraction: {
        type: 'law',
        vars: { L: ['Contracted length', 'length', 'm', 43.589], L0: ['Proper length (at rest)', 'length', 'm', 100], v: ['Speed', 'speed', 'c', 0.9] },
        default: 'L',
        eq: 'L = L₀ √(1 − v²/c²)',
        forms: { L: 'L = L₀ ÷ γ', L0: 'L₀ = γL', v: 'v = c√(1 − (L/L₀)²)' },
        solve: { L: (v) => v.L0 * Math.sqrt(1 - (v.v / c) ** 2), L0: (v) => v.L / Math.sqrt(1 - (v.v / c) ** 2), v: (v) => c * Math.sqrt(1 - (v.L / v.L0) ** 2) },
        rows: { gamma: 'Lorentz factor γ' },
        extra: (v) => ({ gamma: num(gamma(v.v)) }),
        check: (v, unknown) => (unknown !== 'v' && !(v.v < c) ? 'The speed must be below the speed of light.' : null),
    },
    relativistic_ke: {
        type: 'calc',
        inputs: { m: ['Rest mass', 'particle_mass', 'kg', 1], v: ['Speed', 'speed', 'c', 0.8] },
        out: 'energy',
        outUnit: 'j',
        label: 'Relativistic kinetic energy',
        rows: { classical: ['Classical ½mv²', 'energy'], total: ['Total energy γmc²', 'energy'], gamma: 'Lorentz factor γ', ev: ['In electronvolts', 'particle_energy'] },
        run: (x) => {
            if (!(x.v < c)) {
                return { error: 'The speed must be below the speed of light.' };
            }

            const g = gamma(x.v);
            const ke = (g - 1) * x.m * c * c;

            return { value: ke, sub: `${num(ke / (0.5 * x.m * x.v * x.v), 4)} × the classical value`, rows: { classical: [0.5 * x.m * x.v * x.v, 'energy'], total: [g * x.m * c * c, 'energy'], gamma: num(g), ev: [ke, 'particle_energy'] }, steps: ['K = (γ − 1)mc²', `γ = ${num(g)}`, `K = ${num(ke)} J`] };
        },
    },
    space_travel: {
        type: 'calc',
        inputs: { d: ['Distance', 'astronomical', 'ly', 4.2465], a: ['Acceleration (and deceleration)', 'acceleration', 'g0', 1], ve: ['Exhaust speed (for fuel)', 'speed', 'c', 1] },
        label: 'Ship time',
        rows: { earth: 'Earth time', vmax: 'Top speed', ratio: 'Mass ratio needed (rocket equation)', fuel: 'Fuel per kilogram of payload' },
        run: (x) => {
            const f = flipBurn(x.d, x.a);
            const ratio = Math.exp((x.a * f.tau) / x.ve);

            return { value: fmtTime(f.tau), sub: `Earth time ${fmtTime(f.t)}, top speed ${num(f.vmax / c, 6)} c`, rows: { earth: fmtTime(f.t), vmax: `${num(f.vmax / c, 6)} c (γ = ${num(f.gmax)})`, ratio: `${num(ratio)} (accelerate and brake)`, fuel: `${num(ratio - 1)} kg` }, steps: ['Flip-and-burn at constant proper acceleration', `τ = (2c/a) arcosh(1 + ad/2c²) = ${fmtTime(f.tau)}`, `t = ${fmtTime(f.t)}`, 'Relativistic rocket: m₀/m_f = e^(aτ ÷ v_e) for the whole trip; v_e = c is a perfect photon rocket'] };
        },
    },
    time_dilation: {
        type: 'law',
        vars: { t: ['Dilated time (seen by the observer)', 'time', 'year', 2.29416], t0: ['Proper time (on the moving clock)', 'time', 'year', 1], v: ['Speed', 'speed', 'c', 0.9] },
        default: 't',
        eq: 'Δt = γ Δt₀',
        forms: { t: 'Δt = Δt₀ ÷ √(1 − v²/c²)', t0: 'Δt₀ = Δt √(1 − v²/c²)', v: 'v = c√(1 − (Δt₀/Δt)²)' },
        solve: { t: (v) => v.t0 * gamma(v.v), t0: (v) => v.t / gamma(v.v), v: (v) => c * Math.sqrt(1 - (v.t0 / v.t) ** 2) },
        rows: { gamma: 'Lorentz factor γ', diff: 'Difference' },
        extra: (v) => ({ gamma: num(gamma(v.v)), diff: fmtTime(v.t - v.t0) }),
        check: (v, unknown) => (unknown !== 'v' && !(v.v < c) ? 'The speed must be below the speed of light.' : null),
    },
    velocity_addition: {
        type: 'calc',
        inputs: { v: ['Speed of the frame (ship)', 'speed', 'c', 0.6], w: ['Speed of the object in that frame', 'speed', 'c', 0.7] },
        out: 'speed',
        outUnit: 'c',
        label: 'Combined speed',
        rows: { classical: 'Simple sum (wrong)', gamma: 'Lorentz factor of the result' },
        run: (x) => {
            if (!(Math.abs(x.v) < c && Math.abs(x.w) <= c)) {
                return { error: 'Speeds must not exceed c.' };
            }

            const u = (x.v + x.w) / (1 + (x.v * x.w) / (c * c));

            return { value: u, sub: `Not ${num((x.v + x.w) / c)} c: never faster than light`, rows: { classical: `${num((x.v + x.w) / c)} c`, gamma: Math.abs(u) < c ? num(gamma(u)) : '∞ (light)' }, steps: ['u = (v + w) ÷ (1 + vw/c²)', `= (${num(x.v / c)} + ${num(x.w / c)}) ÷ (1 + ${num((x.v * x.w) / (c * c))}) c = ${num(u / c)} c`] };
        },
    },
    lorentz: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { v: 'The speed', g: 'The Lorentz factor' }, 'v'], v: ['Speed', 'speed', 'c', 0.9], g: ['Lorentz factor γ', null, null, 2, 1] },
        show: { v: 'mode:v', g: 'mode:g' },
        when: { v: (x) => x.mode === 'v', g: (x) => x.mode === 'g' },
        label: 'Lorentz factor γ',
        rows: { v: 'Speed', beta: 'β = v/c', rapidity: 'Rapidity', contraction: 'Lengths shrink to' },
        run: (x) => {
            if (x.mode === 'v' && !(Math.abs(x.v) < c)) {
                return { error: 'The speed must be below the speed of light.' };
            }

            const g = x.mode === 'v' ? gamma(x.v) : x.g;
            const b = Math.sqrt(1 - 1 / (g * g));

            return { value: num(g, 8), sub: `β = ${num(b, 8)}`, rows: { v: `${num(b * c / 1000)} km/s`, beta: num(b, 10), rapidity: num(Math.atanh(b)), contraction: `${num(100 / g)}%` }, steps: ['γ = 1 ÷ √(1 − v²/c²)', `= ${num(g)}`] };
        },
    },
    relativistic_momentum: {
        type: 'calc',
        inputs: { m: ['Rest mass', 'particle_mass', 'kg', 1], v: ['Speed', 'speed', 'c', 0.8] },
        out: 'momentum',
        outUnit: 'kgms',
        label: 'Relativistic momentum',
        rows: { classical: ['Classical mv', 'momentum'], gamma: 'Lorentz factor γ', mevc: 'In MeV/c' },
        run: (x) => {
            if (!(x.v < c)) {
                return { error: 'The speed must be below the speed of light.' };
            }

            const p = gamma(x.v) * x.m * x.v;

            return { value: p, sub: `${num(gamma(x.v), 5)} × the classical value`, rows: { classical: [x.m * x.v, 'momentum'], gamma: num(gamma(x.v)), mevc: `${num((p * c) / (K.e * 1e6))} MeV/c` }, steps: ['p = γmv', `= ${num(gamma(x.v))} × ${num(x.m)} × ${num(x.v)} = ${num(p)} kg·m/s`] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
