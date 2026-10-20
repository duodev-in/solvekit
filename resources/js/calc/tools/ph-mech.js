import { defineTools } from '../engines/formula.js';
import { D, handlersFor, K, num, pw } from '../physics/core.js';
import { ellipticK } from '../physics/util.js';

/**
 * Mechanics: kinematics, dynamics, statics, energy and rotational motion.
 */
const g0 = K.g0;
const OMEGA_EARTH = 7.2921159e-5;

/** Drag-free trajectory from height h; returns flight time to the ground at height `land`, and points. */
function flight(v, angle, h, g, land = 0, n = 80) {
    const vx = v * Math.cos(angle);
    const vy = v * Math.sin(angle);
    const disc = vy * vy + 2 * g * (h - land);
    const T = disc >= 0 ? (vy + Math.sqrt(disc)) / g : NaN;
    const points = Number.isFinite(T) ? Array.from({ length: n + 1 }, (_, k) => {
        const t = (T * k) / n;

        return [vx * t, h + vy * t - 0.5 * g * t * t];
    }) : [];

    return { T, vx, vy, points, H: h + (vy > 0 ? (vy * vy) / (2 * g) : 0) };
}

/** Projectile pages share one calculation; `want` picks the headline. */
function projectile(want, extraInputs = {}) {
    const flat = want === 'horizontal';

    return {
        type: 'calc',
        inputs: { v: ['Launch speed', 'speed', 'ms', 20], ...(flat ? {} : { angle: ['Launch angle', 'angle', 'deg', 45] }), h: ['Launch height', 'length', 'm', flat ? 10 : 0], g: ['Gravity', 'acceleration', 'ms2', 9.80665], ...extraInputs },
        out: want === 'time' ? 'time' : want === 'height' ? 'length' : 'length',
        outUnit: want === 'time' ? 's' : 'm',
        label: { range: 'Range', horizontal: 'Range', time: 'Time of flight', height: 'Maximum height', all: 'Range' }[want],
        rows: { range: ['Range', 'length'], time: ['Time of flight', 'time'], height: ['Maximum height', 'length'], impact: ['Impact speed', 'speed'], impactAngle: 'Impact angle below horizontal', best: 'Angle for the longest range from this height' },
        plots: [['trajectory', 'Trajectory']],
        run: (v) => {
            const angle = flat ? 0 : v.angle;

            if (!(v.v > 0) || !(v.g > 0) || v.h < 0) {
                return { error: 'Speed and gravity must be positive and the launch height at least 0.' };
            }

            const f = flight(v.v, angle, v.h, v.g);
            const range = f.vx * f.T;
            const vyEnd = f.vy - v.g * f.T;
            const best = Math.atan(v.v / Math.sqrt(v.v * v.v + 2 * v.g * v.h)) / D;
            const value = { range, horizontal: range, all: range, time: f.T, height: f.H }[want];

            return {
                value,
                sub: want === 'time' ? `Range ${num(range)} m` : want === 'height' ? `Reached after ${num(Math.max(f.vy, 0) / v.g)} s` : `Time of flight ${num(f.T)} s, peak ${num(f.H)} m`,
                rows: { range: [range, 'length'], time: [f.T, 'time'], height: [f.H, 'length'], impact: [Math.hypot(f.vx, vyEnd), 'speed'], impactAngle: `${num(Math.atan2(-vyEnd, f.vx) / D)}°`, best: `${num(best)}°` },
                steps: [`vₓ = v cos θ = ${num(f.vx)} m/s, v_y = v sin θ = ${num(f.vy)} m/s`, `Time of flight t = (v_y + √(v_y² + 2gh)) ÷ g = ${num(f.T)} s`, `Range R = vₓ t = ${num(range)} m`, `Maximum height H = h + v_y² ÷ 2g = ${num(f.H)} m`],
                plots: { trajectory: { series: f.points, axes: true, xLabel: 'Distance (m)', yLabel: 'Height (m)' } },
            };
        },
    };
}

/** Constant-acceleration (SUVAT) solver from any three of s, u, v, a, t. */
export function suvatSolve(known, x) {
    const { s, u, v, a, t } = x;
    const r = { s, u, v, a, t };

    switch (known) {
        case 'uat': r.v = u + a * t; r.s = u * t + 0.5 * a * t * t; break;
        case 'uvt': r.a = (v - u) / t; r.s = ((u + v) / 2) * t; break;
        case 'uva': r.t = (v - u) / a; r.s = (v * v - u * u) / (2 * a); break;
        case 'vat': r.u = v - a * t; r.s = v * t - 0.5 * a * t * t; break;
        case 'sut': r.a = (2 * (s - u * t)) / (t * t); r.v = (2 * s) / t - u; break;
        case 'svt': r.u = (2 * s) / t - v; r.a = (2 * (v * t - s)) / (t * t); break;
        case 'suv': r.t = (2 * s) / (u + v); r.a = (v * v - u * u) / (2 * s); break;
        case 'sua': r.v = Math.sqrt(u * u + 2 * a * s); r.t = a === 0 ? s / u : (r.v - u) / a; break;
        case 'sva': r.u = Math.sqrt(v * v - 2 * a * s); r.t = a === 0 ? s / v : (v - r.u) / a; break;
        case 'sat': r.u = s / t - 0.5 * a * t; r.v = r.u + a * t; break;
        default: return null;
    }

    return r;
}

const SUVAT_KNOWN = { uat: 'u, a and t', uvt: 'u, v and t', uva: 'u, v and a', vat: 'v, a and t', sut: 's, u and t', svt: 's, v and t', suv: 's, u and v', sua: 's, u and a', sva: 's, v and a', sat: 's, a and t' };
const SUVAT_FAMILY = { s: ['length', 'm'], u: ['speed', 'ms'], v: ['speed', 'ms'], a: ['acceleration', 'ms2'], t: ['time', 's'] };
const SUVAT_LABEL = { s: 'Displacement s', u: 'Initial velocity u', v: 'Final velocity v', a: 'Acceleration a', t: 'Time t' };

function suvat(want, known = 'uat') {
    const inputs = { known: ['I know', 'select', SUVAT_KNOWN, known] };
    const show = {};
    const defaults = { s: 100, u: 0, v: 20, a: 2, t: 10 };
    ['s', 'u', 'v', 'a', 't'].forEach((n) => {
        inputs[n] = [SUVAT_LABEL[n], SUVAT_FAMILY[n][0], SUVAT_FAMILY[n][1], defaults[n]];
        show[n] = `known:${Object.keys(SUVAT_KNOWN).filter((k) => k.includes(n)).join(',')}`;
    });

    return {
        type: 'calc',
        inputs,
        show,
        when: Object.fromEntries(['s', 'u', 'v', 'a', 't'].map((n) => [n, (x) => x.known.includes(n)])),
        out: SUVAT_FAMILY[want][0],
        outUnit: SUVAT_FAMILY[want][1],
        label: SUVAT_LABEL[want],
        rows: { s: ['Displacement s', 'length'], u: ['Initial velocity u', 'speed'], v: ['Final velocity v', 'speed'], a: ['Acceleration a', 'acceleration'], t: ['Time t', 'time'], avg: ['Average velocity', 'speed'] },
        run: (x) => {
            const r = suvatSolve(x.known, x);

            if (!r || !['s', 'u', 'v', 'a', 't'].every((n) => Number.isFinite(r[n]))) {
                return { error: 'These values have no real solution (for example a negative time or a square root of a negative number).' };
            }

            if (r.t < 0) {
                return { error: 'The time comes out negative: check the signs of the velocities and the acceleration.' };
            }

            const used = { uat: ['v = u + at', 's = ut + ½at²'], uvt: ['a = (v − u) ÷ t', 's = ½(u + v)t'], uva: ['t = (v − u) ÷ a', 's = (v² − u²) ÷ 2a'], vat: ['u = v − at', 's = vt − ½at²'], sut: ['a = 2(s − ut) ÷ t²', 'v = 2s ÷ t − u'], svt: ['u = 2s ÷ t − v', 'a = 2(vt − s) ÷ t²'], suv: ['t = 2s ÷ (u + v)', 'a = (v² − u²) ÷ 2s'], sua: ['v = √(u² + 2as)', 't = (v − u) ÷ a'], sva: ['u = √(v² − 2as)', 't = (v − u) ÷ a'], sat: ['u = s ÷ t − ½at', 'v = u + at'] }[x.known];

            return {
                value: r[want],
                sub: `s = ${num(r.s)} m, u = ${num(r.u)} m/s, v = ${num(r.v)} m/s, a = ${num(r.a)} m/s², t = ${num(r.t)} s`,
                rows: { s: [r.s, 'length'], u: [r.u, 'speed'], v: [r.v, 'speed'], a: [r.a, 'acceleration'], t: [r.t, 'time'], avg: [r.t ? r.s / r.t : (r.u + r.v) / 2, 'speed'] },
                steps: [`Known: ${SUVAT_KNOWN[x.known]}`, ...used, `s = ${num(r.s)} m, u = ${num(r.u)} m/s, v = ${num(r.v)} m/s, a = ${num(r.a)} m/s², t = ${num(r.t)} s`],
            };
        },
    };
}

/** Shapes for mass moments of inertia: I = k × m × r² (with their own dimensions). */
const MOI = {
    rod_c: ['Thin rod about its centre', (v) => (v.m * v.L * v.L) / 12],
    rod_e: ['Thin rod about one end', (v) => (v.m * v.L * v.L) / 3],
    disc: ['Solid disc or cylinder about its axis', (v) => 0.5 * v.m * v.r * v.r],
    ring: ['Thin ring or hoop about its axis', (v) => v.m * v.r * v.r],
    tube: ['Thick-walled tube about its axis', (v) => 0.5 * v.m * (v.r * v.r + v.ri * v.ri)],
    sphere: ['Solid sphere', (v) => 0.4 * v.m * v.r * v.r],
    shell: ['Thin spherical shell', (v) => (2 / 3) * v.m * v.r * v.r],
    cyl_d: ['Solid cylinder about a diameter through its centre', (v) => v.m * (3 * v.r * v.r + v.L * v.L) / 12],
    plate: ['Rectangular plate about its centre (perpendicular axis)', (v) => (v.m * (v.L * v.L + v.w * v.w)) / 12],
    cone: ['Solid cone about its axis', (v) => 0.3 * v.m * v.r * v.r],
};
const ROLL_K = { slide: ['Sliding block (no rolling)', 0], ring: ['Ring or hoop', 1], tube: ['Thin-walled tube', 1], disc: ['Solid disc or cylinder', 0.5], sphere: ['Solid sphere', 0.4], shell: ['Hollow sphere', 2 / 3] };

/** Cosine and sine of degrees, exactly 0 at right angles (so 90° gives 0, not 6 × 10⁻¹⁷). */
const cosd = (a) => (Math.abs(Math.cos(a * D)) < 1e-12 ? 0 : Math.cos(a * D));
const sind = (a) => (Math.abs(Math.sin(a * D)) < 1e-12 ? 0 : Math.sin(a * D));

/** Vectors typed "magnitude, direction" one per line. */
function readVectors(text) {
    const rows = String(text ?? '').split(/\n|;/).map((l) => l.trim()).filter(Boolean).map((l) => l.split(/[,\s]+/).map(Number));

    return rows.length && rows.every((r) => r.length === 2 && r.every(Number.isFinite)) ? rows : null;
}

const ROADS = { dry: ['Dry asphalt (μ ≈ 0.7)', 0.7], wet: ['Wet asphalt (μ ≈ 0.4)', 0.4], gravel: ['Gravel (μ ≈ 0.35)', 0.35], snow: ['Packed snow (μ ≈ 0.2)', 0.2], ice: ['Ice (μ ≈ 0.1)', 0.1] };
const bodyG = (data, key) => {
    const b = data?.physics?.bodies?.[key];

    return b ? (b.gm * 1e9) / (b.radius * 1e3) ** 2 : NaN;
};

export const TOOLS = {
    // Kinematics ---------------------------------------------------------------------------------
    arrow_speed: {
        type: 'calc',
        inputs: { ibo: ['IBO speed rating', 'speed', 'fts', 320], draw: ['Draw length', 'length', 'in', 29], weight: ['Draw weight (lbf)', null, null, 70, 0], arrow: ['Arrow weight (grains)', null, null, 420, 0], extra: ['Extra weight on the string (grains)', null, null, 10, 0] },
        out: 'speed',
        outUnit: 'fts',
        label: 'Estimated arrow speed',
        rows: { ke: ['Kinetic energy', 'energy'], momentum: ['Momentum', 'momentum'], ratio: 'Arrow weight per pound of draw' },
        run: (v) => {
            const fps = v.ibo / 0.3048 - 10 * (30 - v.draw / 0.0254) - v.extra / 3 - Math.max(0, v.arrow - 5 * v.weight) / 3;
            const ms = fps * 0.3048;
            const kg = v.arrow * 6.479891e-5;

            if (!(fps > 0)) {
                return { error: 'The adjustments leave no speed; check the rating and arrow weight.' };
            }

            return { value: ms, sub: 'Rule-of-thumb adjustment from the IBO rating (an estimate; a chronograph measures the real speed)', rows: { ke: [0.5 * kg * ms * ms, 'energy'], momentum: [kg * ms, 'momentum'], ratio: `${num(v.arrow / v.weight)} grains per lb` }, steps: ['IBO ratings are measured at 30 in draw, 70 lb and a 350-grain (5 gr/lb) arrow', `− 10 ft/s per inch under 30 in: ${num(10 * (30 - v.draw / 0.0254))} ft/s`, `− 1 ft/s per 3 grains on the string: ${num(v.extra / 3)} ft/s`, `− 1 ft/s per 3 grains above 5 gr/lb: ${num(Math.max(0, v.arrow - 5 * v.weight) / 3)} ft/s`, `≈ ${num(fps)} ft/s`] };
        },
    },
    ballistic_coefficient: {
        type: 'calc',
        inputs: { m: ['Bullet mass', 'mass', 'gr', 168], d: ['Bullet diameter', 'length', 'in', 0.308], i: ['Form factor i (G1; about 0.5–0.6 for boat-tail match bullets)', null, null, 0.55, 0] },
        label: 'Ballistic coefficient (G1)',
        rows: { sd: 'Sectional density', si: 'In SI units' },
        run: (v) => {
            const lb = v.m / 0.45359237;
            const inch = v.d / 0.0254;
            const sd = lb / (inch * inch);
            const bc = sd / v.i;

            return { value: bc, unit: 'lb/in²', sub: `Sectional density ${num(sd, 4)} lb/in²`, rows: { sd: `${num(sd, 5)} lb/in²`, si: `${num(bc * 703.0696, 5)} kg/m²` }, steps: ['SD = m ÷ d² (pounds and inches)', `= ${num(lb)} ÷ ${num(inch)}² = ${num(sd)}`, `BC = SD ÷ i = ${num(bc)}`] };
        },
    },
    car_jump: {
        type: 'calc',
        inputs: { v: ['Speed at the ramp', 'speed', 'kmh', 80], angle: ['Ramp angle', 'angle', 'deg', 15], h: ['Ramp lip height', 'length', 'm', 1], land: ['Landing height', 'length', 'm', 0] },
        out: 'length',
        outUnit: 'm',
        label: 'Jump distance',
        rows: { time: ['Air time', 'time'], peak: ['Peak height', 'length'], impact: ['Landing speed', 'speed'] },
        plots: [['trajectory', 'Trajectory']],
        run: (v) => {
            const f = flight(v.v, v.angle, v.h, g0, v.land);

            if (!Number.isFinite(f.T)) {
                return { error: 'The car never reaches that landing height.' };
            }

            const vyEnd = f.vy - g0 * f.T;

            return { value: f.vx * f.T, sub: `Air time ${num(f.T)} s (no air resistance)`, rows: { time: [f.T, 'time'], peak: [f.H, 'length'], impact: [Math.hypot(f.vx, vyEnd), 'speed'] }, steps: [`vₓ = ${num(f.vx)} m/s, v_y = ${num(f.vy)} m/s`, `Lands when h + v_y t − ½gt² = landing height: t = ${num(f.T)} s`, `Distance = vₓ t = ${num(f.vx * f.T)} m`], plots: { trajectory: { series: f.points, axes: true, xLabel: 'Distance (m)', yLabel: 'Height (m)' } } };
        },
    },
    momentum_conservation: {
        type: 'law',
        vars: { m1: ['Mass 1', 'mass', 'kg', 2], u1: ['Velocity 1 before', 'speed', 'ms', 3], m2: ['Mass 2', 'mass', 'kg', 1], u2: ['Velocity 2 before', 'speed', 'ms', -1], v1: ['Velocity 1 after', 'speed', 'ms', 0.5], v2: ['Velocity 2 after', 'speed', 'ms', 4] },
        default: 'v2',
        eq: 'm₁u₁ + m₂u₂ = m₁v₁ + m₂v₂',
        forms: { v2: 'v₂ = (m₁u₁ + m₂u₂ − m₁v₁) ÷ m₂', v1: 'v₁ = (m₁u₁ + m₂u₂ − m₂v₂) ÷ m₁', u1: 'u₁ = (m₁v₁ + m₂v₂ − m₂u₂) ÷ m₁', u2: 'u₂ = (m₁v₁ + m₂v₂ − m₁u₁) ÷ m₂', m1: 'm₁ = m₂(v₂ − u₂) ÷ (u₁ − v₁)', m2: 'm₂ = m₁(u₁ − v₁) ÷ (v₂ − u₂)' },
        solve: {
            v2: (v) => (v.m1 * v.u1 + v.m2 * v.u2 - v.m1 * v.v1) / v.m2,
            v1: (v) => (v.m1 * v.u1 + v.m2 * v.u2 - v.m2 * v.v2) / v.m1,
            u1: (v) => (v.m1 * v.v1 + v.m2 * v.v2 - v.m2 * v.u2) / v.m1,
            u2: (v) => (v.m1 * v.v1 + v.m2 * v.v2 - v.m1 * v.u1) / v.m2,
            m1: (v) => (v.m2 * (v.v2 - v.u2)) / (v.u1 - v.v1),
            m2: (v) => (v.m1 * (v.u1 - v.v1)) / (v.v2 - v.u2),
        },
        rows: { p: ['Total momentum', 'momentum'], ke: 'Kinetic energy before → after', type: 'Collision type' },
        extra: (v) => {
            const before = 0.5 * v.m1 * v.u1 ** 2 + 0.5 * v.m2 * v.u2 ** 2;
            const after = 0.5 * v.m1 * v.v1 ** 2 + 0.5 * v.m2 * v.v2 ** 2;
            const lost = before - after;

            return { p: [v.m1 * v.u1 + v.m2 * v.u2, 'momentum'], ke: `${num(before)} J → ${num(after)} J`, type: Math.abs(lost) < 1e-9 * Math.max(before, 1) ? 'Elastic (no energy lost)' : lost > 0 ? `Inelastic: ${num((lost / before) * 100)}% of the kinetic energy lost` : 'Energy gained: an explosion or push, or check the values' };
        },
    },
    suvat: suvat('s'),
    displacement: suvat('s'),
    velocity_suvat: suvat('v', 'uat'),
    free_fall: {
        type: 'calc',
        inputs: { known: ['I know', 'select', { h: 'The height', t: 'The fall time', v: 'The impact speed' }, 'h'], h: ['Height', 'length', 'm', 20], t: ['Fall time', 'time', 's', 2], v: ['Impact speed', 'speed', 'ms', 20], g: ['Gravity', 'acceleration', 'ms2', 9.80665] },
        show: { h: 'known:h', t: 'known:t', v: 'known:v' },
        when: { h: (x) => x.known === 'h', t: (x) => x.known === 't', v: (x) => x.known === 'v' },
        out: 'time',
        outUnit: 's',
        label: 'Fall time',
        rows: { h: ['Height', 'length'], t: ['Fall time', 'time'], v: ['Impact speed', 'speed'], energy: 'Energy per kilogram', first: 'Distance fallen in each second' },
        run: (x) => {
            const g = x.g;
            const t = x.known === 't' ? x.t : x.known === 'h' ? Math.sqrt((2 * x.h) / g) : x.v / g;
            const h = 0.5 * g * t * t;
            const v = g * t;

            if (!(t > 0)) {
                return { error: 'Enter a positive value.' };
            }

            return { value: t, sub: `Hits at ${num(v)} m/s (${num(v * 3.6)} km/h), no air resistance`, rows: { h: [h, 'length'], t: [t, 'time'], v: [v, 'speed'], energy: `${num(g * h)} J/kg`, first: Array.from({ length: Math.min(5, Math.ceil(t)) }, (_, k) => `${k + 1} s: ${num(0.5 * g * ((k + 1) ** 2 - k ** 2))} m`).join(', ') }, steps: ['h = ½gt², v = gt', `t = ${num(t)} s, h = ${num(h)} m, v = ${num(v)} m/s`] };
        },
    },
    free_fall_drag: {
        type: 'calc',
        inputs: { m: ['Mass', 'mass', 'kg', 80], cd: ['Drag coefficient', null, null, 1.0, 0], area: ['Frontal area', 'area', 'm2', 0.7], rho: ['Air density', 'density', 'kgm3', 1.225], h: ['Height', 'length', 'm', 1000], g: ['Gravity', 'acceleration', 'ms2', 9.80665] },
        out: 'time',
        outUnit: 's',
        label: 'Fall time with air resistance',
        rows: { vt: ['Terminal velocity', 'speed'], impact: ['Impact speed', 'speed'], noDrag: 'Without air resistance', t95: ['Time to reach 95% of terminal speed', 'time'] },
        plots: [['speed', 'Speed over time']],
        run: (x) => {
            const vt = Math.sqrt((2 * x.m * x.g) / (x.rho * x.cd * x.area));
            const t = (vt / x.g) * Math.acosh(Math.exp((x.g * x.h) / (vt * vt)));
            const v = vt * Math.tanh((x.g * t) / vt);
            const t0 = Math.sqrt((2 * x.h) / x.g);
            const series = Array.from({ length: 81 }, (_, k) => [(t * k) / 80, vt * Math.tanh((x.g * ((t * k) / 80)) / vt)]);

            return { value: t, sub: `Impact at ${num(v)} m/s; terminal velocity ${num(vt)} m/s`, rows: { vt: [vt, 'speed'], impact: [v, 'speed'], noDrag: `${num(t0)} s and ${num(x.g * t0)} m/s`, t95: [(vt / x.g) * Math.atanh(0.95), 'time'] }, steps: ['Quadratic drag F = ½ρC_dAv²', `Terminal velocity v_t = √(2mg ÷ ρC_dA) = ${num(vt)} m/s`, `Fall time t = (v_t ÷ g) arcosh(e^(gh/v_t²)) = ${num(t)} s`, `Impact speed v = v_t tanh(gt ÷ v_t) = ${num(v)} m/s`], plots: { speed: { series, extra: [series.map(([tt]) => [tt, Math.min(x.g * tt, x.g * t0)])], axes: true, xLabel: 'Time (s)', yLabel: 'Speed (m/s)' } } };
        },
    },
    friction: pw({ vars: { F: ['Friction force', 'force', 'n', 39.2], mu: ['Coefficient of friction μ', null, null, 0.4], N: ['Normal force', 'force', 'n', 98.0665] }, out: 'F', exp: { mu: 1, N: 1 }, eq: 'F = μ N', forms: { F: 'F = μN', mu: 'μ = F ÷ N', N: 'N = F ÷ μ' }, rows: { mass: ['Mass resting on a level surface', 'mass'] }, extra: (v) => ({ mass: [v.N / g0, 'mass'] }) }),
    ground_speed: {
        type: 'calc',
        inputs: { tas: ['True airspeed', 'speed', 'knot', 120], heading: ['Heading', 'angle', 'deg', 90], wind: ['Wind speed', 'speed', 'knot', 20], from: ['Wind from (direction)', 'angle', 'deg', 45] },
        out: 'speed',
        outUnit: 'knot',
        label: 'Ground speed',
        rows: { track: 'Track over the ground', drift: 'Drift angle', head: ['Headwind component', 'speed'], cross: ['Crosswind component', 'speed'] },
        run: (x) => {
            const ax = x.tas * Math.sin(x.heading);
            const ay = x.tas * Math.cos(x.heading);
            const wx = -x.wind * Math.sin(x.from);
            const wy = -x.wind * Math.cos(x.from);
            const gs = Math.hypot(ax + wx, ay + wy);
            const track = ((Math.atan2(ax + wx, ay + wy) / D) + 360) % 360;
            const rel = x.from - x.heading;

            return { value: gs, sub: `Track ${num(track, 4)}°`, rows: { track: `${num(track, 5)}°`, drift: `${num(((track - x.heading / D + 540) % 360) - 180, 4)}°`, head: [x.wind * Math.cos(rel), 'speed'], cross: [x.wind * Math.sin(rel), 'speed'] }, steps: ['Ground velocity = air velocity + wind velocity (vectors)', `Air: (${num(ax)}, ${num(ay)}) m/s east/north; wind: (${num(wx)}, ${num(wy)}) m/s`, `Ground speed ${num(gs)} m/s, track ${num(track)}°`] };
        },
    },
    projectile: projectile('all'),
    projectile_range: projectile('range'),
    projectile_horizontal: projectile('horizontal'),
    projectile_time: projectile('time'),
    projectile_height: projectile('height'),
    impulse: {
        type: 'law',
        vars: { F: ['Average force', 'force', 'n', 500], t: ['Contact time', 'short_time', 'ms', 20], m: ['Mass', 'mass', 'kg', 0.45], dv: ['Change in velocity', 'speed', 'ms', 22.2222] },
        default: 'F',
        eq: 'J = F Δt = m Δv',
        forms: { F: 'F = m Δv ÷ Δt', t: 'Δt = m Δv ÷ F', m: 'm = F Δt ÷ Δv', dv: 'Δv = F Δt ÷ m' },
        solve: { F: (v) => (v.m * v.dv) / v.t, t: (v) => (v.m * v.dv) / v.F, m: (v) => (v.F * v.t) / v.dv, dv: (v) => (v.F * v.t) / v.m },
        rows: { J: ['Impulse (change in momentum)', 'momentum'] },
        extra: (v) => ({ J: [v.F * v.t, 'momentum'] }),
    },
    inclined_plane: {
        type: 'calc',
        inputs: { m: ['Mass', 'mass', 'kg', 10], angle: ['Slope angle', 'angle', 'deg', 30], mu: ['Coefficient of friction μ', null, null, 0.2, 0], g: ['Gravity', 'acceleration', 'ms2', 9.80665] },
        out: 'acceleration',
        outUnit: 'ms2',
        label: 'Acceleration down the slope',
        rows: { parallel: ['Weight along the slope', 'force'], normal: ['Normal force', 'force'], friction: ['Maximum friction', 'force'], slides: 'Does it slide?', limit: 'Steepest angle it can rest on' },
        run: (x) => {
            const W = x.m * x.g;
            const par = W * Math.sin(x.angle);
            const N = W * Math.cos(x.angle);
            const slides = par > x.mu * N;
            const a = slides ? x.g * (Math.sin(x.angle) - x.mu * Math.cos(x.angle)) : 0;

            return { value: a, sub: slides ? 'It slides down' : 'Friction holds it still', rows: { parallel: [par, 'force'], normal: [N, 'force'], friction: [x.mu * N, 'force'], slides: slides ? 'Yes' : 'No: tan θ ≤ μ', limit: `${num(Math.atan(x.mu) / D)}°` }, steps: [`Along the slope: mg sin θ = ${num(par)} N`, `Normal force: N = mg cos θ = ${num(N)} N`, `Friction up to μN = ${num(x.mu * N)} N`, slides ? `a = g(sin θ − μ cos θ) = ${num(a)} m/s²` : 'mg sin θ ≤ μN, so a = 0'] };
        },
    },
    accel_magnitude: {
        type: 'calc',
        inputs: { ax: ['aₓ', 'acceleration', 'ms2', 3], ay: ['a_y', 'acceleration', 'ms2', 4], az: ['a_z', 'acceleration', 'ms2', 0] },
        out: 'acceleration',
        outUnit: 'ms2',
        label: 'Magnitude of acceleration',
        rows: { g: 'In g', dir: 'Direction in the x–y plane', elev: 'Angle above the x–y plane' },
        run: (x) => {
            const a = Math.hypot(x.ax, x.ay, x.az);

            return { value: a, sub: `${num(a / g0)} g`, rows: { g: `${num(a / g0)} g`, dir: `${num(Math.atan2(x.ay, x.ax) / D)}° from the x-axis`, elev: `${num(Math.atan2(x.az, Math.hypot(x.ax, x.ay)) / D)}°` }, steps: [`|a| = √(aₓ² + a_y² + a_z²) = √(${num(x.ax)}² + ${num(x.ay)}² + ${num(x.az)}²) = ${num(a)} m/s²`] };
        },
    },
    moa: {
        type: 'calc',
        inputs: { angle: ['Angle', 'angle', 'arcmin', 1], d: ['Distance to target', 'length', 'yd', 100] },
        out: 'length',
        outUnit: 'in',
        label: 'Size at that distance',
        rows: { moa: 'In MOA', mil: 'In milliradians (MIL)', clicks: 'Quarter-MOA clicks', ipm: 'One MOA at this distance' },
        run: (x) => {
            const size = x.d * Math.tan(x.angle);

            return { value: size, sub: `${num(x.angle / (D / 60))} MOA = ${num(x.angle * 1000)} mil`, rows: { moa: `${num(x.angle / (D / 60))} MOA`, mil: `${num(x.angle * 1000)} mil`, clicks: `${num(x.angle / (D / 60) / 0.25, 4)} clicks`, ipm: `${num((x.d * Math.tan(D / 60)) / 0.0254)} in` }, steps: ['1 MOA = 1/60 of a degree; 1 mil = 1/1000 radian', `size = d × tan θ = ${num(x.d)} m × tan(${num(x.angle / D)}°) = ${num(size)} m`] };
        },
    },
    momentum: pw({ vars: { p: ['Momentum', 'momentum', 'kgms', 30], m: ['Mass', 'mass', 'kg', 10], v: ['Velocity', 'speed', 'ms', 3] }, out: 'p', exp: { m: 1, v: 1 }, eq: 'p = m × v', forms: { p: 'p = mv', m: 'm = p ÷ v', v: 'v = p ÷ m' }, rows: { ke: ['Kinetic energy', 'energy'] }, extra: (v) => ({ ke: [0.5 * v.m * v.v ** 2, 'energy'] }) }),
    muzzle_velocity: pw({ vars: { E: ['Muzzle energy', 'energy', 'ftlbf', 2700], m: ['Bullet mass', 'mass', 'gr', 150], v: ['Muzzle velocity', 'speed', 'fts', 2820] }, out: 'E', k: 0.5, exp: { m: 1, v: 2 }, default: 'v', eq: 'E = ½ m v²', forms: { E: 'E = ½mv²', m: 'm = 2E ÷ v²', v: 'v = √(2E ÷ m)' }, rows: { momentum: ['Momentum', 'momentum'] }, extra: (v) => ({ momentum: [v.m * v.v, 'momentum'] }) }),
    polar_moi: {
        type: 'calc',
        inputs: { shape: ['Section', 'select', { solid: 'Solid round shaft', hollow: 'Hollow round tube', rect: 'Solid rectangle (torsion constant)' }, 'solid'], d: ['Outer diameter (or width b)', 'length', 'mm', 50], di: ['Inner diameter', 'length', 'mm', 40], h: ['Height h (rectangle)', 'length', 'mm', 20], T: ['Torque (optional)', 'torque', 'nm', 500] },
        show: { di: 'shape:hollow', h: 'shape:rect' },
        when: { di: (x) => x.shape === 'hollow', h: (x) => x.shape === 'rect' },
        optional: ['T'],
        out: 'area_moment',
        outUnit: 'mm4',
        label: 'Polar moment of inertia J',
        rows: { zp: 'Torsional section modulus', tau: 'Maximum shear stress at that torque' },
        run: (x) => {
            let J;
                if (x.shape === 'rect') {
                const [b, h] = [Math.max(x.d, x.h), Math.min(x.d, x.h)];
                J = b * h ** 3 * (1 / 3 - 0.21 * (h / b) * (1 - h ** 4 / (12 * b ** 4)));
                const zt = (b * b * h * h) / (3 * b + 1.8 * h);

                return { value: J, sub: 'Torsion constant of a solid rectangle (Roark, within about 1%)', rows: { zp: `${num(zt)} m³`, tau: Number.isFinite(x.T) ? `${num(x.T / zt / 1e6)} MPa (at the middle of the long side)` : 'Enter a torque' }, steps: ['J ≈ bh³ [⅓ − 0.21 (h/b)(1 − h⁴ ÷ 12b⁴)], b ≥ h', `J = ${num(J)} m⁴`, ...(Number.isFinite(x.T) ? [`τ_max = T(3b + 1.8h) ÷ b²h² = ${num(x.T / zt / 1e6)} MPa`] : [])] };
            }

            if (x.shape === 'hollow' && !(x.di < x.d)) {
                return { error: 'The inner diameter must be smaller than the outer one.' };
            }

            J = (Math.PI / 32) * (x.d ** 4 - (x.shape === 'hollow' ? x.di ** 4 : 0));
            const c = x.d / 2;

            return { value: J, sub: `Torsional section modulus ${num(J / c)} m³`, rows: { zp: `${num(J / c)} m³`, tau: Number.isFinite(x.T) ? `${num((x.T * c) / J / 1e6)} MPa` : 'Enter a torque' }, steps: [x.shape === 'hollow' ? 'J = π(D⁴ − d⁴) ÷ 32' : 'J = πD⁴ ÷ 32', `J = ${num(J)} m⁴`, ...(Number.isFinite(x.T) ? [`τ = Tr ÷ J = ${num((x.T * c) / J / 1e6)} MPa`] : [])] };
        },
    },
    quarter_mile: {
        type: 'calc',
        inputs: { w: ['Vehicle weight (with driver)', 'mass', 'lb', 3500], p: ['Engine power', 'power', 'hp', 400] },
        out: 'time',
        outUnit: 's',
        label: 'Quarter-mile elapsed time',
        rows: { trap: ['Trap speed', 'speed'], eighth: ['Eighth-mile time (≈ 0.6385 × ET)', 'time'], ratio: 'Weight per horsepower' },
        run: (x) => {
            const lb = x.w / 0.45359237;
            const hp = x.p / 745.69987158;
            const et = 5.825 * (lb / hp) ** (1 / 3);
            const mph = 234 * (hp / lb) ** (1 / 3);

            return { value: et, sub: `Trap speed about ${num(mph, 4)} mph (Hale formulas, an estimate)`, rows: { trap: [mph * 0.44704, 'speed'], eighth: [et * 0.6385, 'time'], ratio: `${num(lb / hp, 4)} lb/hp` }, steps: ['Hale: ET = 5.825 (W ÷ hp)^(1/3)', `= 5.825 × (${num(lb)} ÷ ${num(hp)})^(1/3) = ${num(et)} s`, `Trap speed = 234 (hp ÷ W)^(1/3) = ${num(mph)} mph`] };
        },
    },
    resultant_velocity: {
        type: 'calc',
        inputs: { vectors: ['Velocities: speed, direction in degrees (one per line, in the unit below)', 'textarea', null, '10, 0\n5, 90'], unit: ['Speed unit', 'select', { ms: 'm/s', kmh: 'km/h', mph: 'mph', knot: 'knots' }, 'ms'] },
        label: 'Resultant velocity',
        rows: { dir: 'Direction', comps: 'Components (x, y)' },
        plots: [['vectors', 'Vector diagram']],
        run: (x) => {
            const rows = readVectors(x.vectors);

            if (!rows) {
                return { empty: 'Type each velocity as speed, direction (degrees from the x-axis), one per line.' };
            }

            const vx = rows.reduce((s, [m, a]) => s + m * cosd(a), 0);
            const vy = rows.reduce((s, [m, a]) => s + m * sind(a), 0);
            const mag = Math.hypot(vx, vy);
            const unit = { ms: 'm/s', kmh: 'km/h', mph: 'mph', knot: 'knots' }[x.unit];
            let px = 0;
            let py = 0;
            const shapes = rows.map(([m, a]) => {
                const start = [px, py];
                px += m * cosd(a);
                py += m * sind(a);

                return { points: [start, [px, py]], muted: true };
            });

            return { value: num(mag), unit, sub: `Direction ${num(Math.atan2(vy, vx) / D)}° from the x-axis`, rows: { dir: `${num(Math.atan2(vy, vx) / D)}°`, comps: `(${num(vx)}, ${num(vy)}) ${unit}` }, steps: ['Add the components of every vector', `Σx = ${num(vx)}, Σy = ${num(vy)}`, `|v| = √(Σx² + Σy²) = ${num(mag)} ${unit}`], plots: { vectors: { kind: 'diagram', shapes: [...shapes, { points: [[0, 0], [vx, vy]] }], dots: [[0, 0], [vx, vy]] } } };
        },
    },
    rolling_resistance: {
        type: 'calc',
        inputs: { crr: ['Rolling resistance coefficient C_rr', null, null, 0.01, 0], m: ['Mass', 'mass', 'kg', 1500], angle: ['Slope', 'angle', 'deg', 0], v: ['Speed (for power)', 'speed', 'kmh', 100] },
        optional: ['v'],
        out: 'force',
        outUnit: 'n',
        label: 'Rolling resistance force',
        rows: { power: ['Power to overcome it', 'power'], typical: 'Typical C_rr' },
        run: (x) => {
            const F = x.crr * x.m * g0 * Math.cos(x.angle);

            return { value: F, sub: `C_rr × N = ${num(x.crr)} × ${num(x.m * g0 * Math.cos(x.angle))} N`, rows: { power: Number.isFinite(x.v) ? [F * x.v, 'power'] : 'Enter a speed', typical: 'Car tyre on asphalt 0.010–0.015; bicycle 0.004–0.008; train wheel 0.001–0.002' }, steps: ['F = C_rr × m g cos θ', `= ${num(F)} N`, ...(Number.isFinite(x.v) ? [`P = F v = ${num(F * x.v)} W`] : [])] };
        },
    },
    sled: {
        type: 'calc',
        inputs: { h: ['Hill height', 'length', 'm', 15], angle: ['Slope angle', 'angle', 'deg', 20], mu: ['Friction coefficient μ (snow ≈ 0.05)', null, null, 0.05, 0], m: ['Rider and sled mass', 'mass', 'kg', 60] },
        out: 'speed',
        outUnit: 'kmh',
        label: 'Speed at the bottom',
        rows: { time: ['Time on the slope', 'time'], runout: ['Run-out distance on the flat', 'length'], length: ['Slope length', 'length'], lost: ['Energy lost to friction', 'energy'] },
        run: (x) => {
            const L = x.h / Math.sin(x.angle);
            const a = g0 * (Math.sin(x.angle) - x.mu * Math.cos(x.angle));

            if (!(a > 0)) {
                return { error: 'Friction is too high for this slope: the sled does not start sliding.' };
            }

            const v = Math.sqrt(2 * a * L);

            return { value: v, sub: `After ${num(Math.sqrt((2 * L) / a))} s on a ${num(L)} m slope`, rows: { time: [Math.sqrt((2 * L) / a), 'time'], runout: [x.mu > 0 ? (v * v) / (2 * x.mu * g0) : Infinity, 'length'], length: [L, 'length'], lost: [x.m * g0 * x.mu * Math.cos(x.angle) * L, 'energy'] }, steps: [`Slope length L = h ÷ sin θ = ${num(L)} m`, `a = g(sin θ − μ cos θ) = ${num(a)} m/s²`, `v = √(2aL) = ${num(v)} m/s`, `Run-out on the flat: v² ÷ 2μg = ${num((v * v) / (2 * x.mu * g0))} m`] };
        },
    },
    terminal_velocity: pw({ vars: { v: ['Terminal velocity', 'speed', 'ms', 53.5], m: ['Mass', 'mass', 'kg', 75], g: ['Gravity', 'acceleration', 'ms2', 9.80665], rho: ['Fluid density', 'density', 'kgm3', 1.225], cd: ['Drag coefficient', null, null, 1.0], A: ['Frontal area', 'area', 'm2', 0.42] }, out: 'v', k: Math.SQRT2, exp: { m: 0.5, g: 0.5, rho: -0.5, cd: -0.5, A: -0.5 }, eq: 'v = √(2mg ÷ ρC_dA)', forms: { v: 'v = √(2mg ÷ ρC_dA)', m: 'm = ρC_dAv² ÷ 2g', A: 'A = 2mg ÷ ρC_dv²', cd: 'C_d = 2mg ÷ ρAv²', rho: 'ρ = 2mg ÷ C_dAv²', g: 'g = ρC_dAv² ÷ 2m' }, rows: { t95: ['Time to reach 95% of it', 'time'] }, extra: (v) => ({ t95: [(v.v / v.g) * Math.atanh(0.95), 'time'] }) }),
    trajectory: {
        ...projectile('all', { drag: ['Air resistance', 'select', { off: 'Ignore', on: 'Include (quadratic drag)' }, 'off'], m: ['Mass', 'mass', 'kg', 0.145], cd: ['Drag coefficient', null, null, 0.35, 0], area: ['Cross-section area', 'area', 'cm2', 42] }),
        show: { m: 'drag:on', cd: 'drag:on', area: 'drag:on' },
        when: { m: (x) => x.drag === 'on', cd: (x) => x.drag === 'on', area: (x) => x.drag === 'on' },
        run: (x) => {
            const base = projectile('all').run(x);

            if (x.drag !== 'on' || base.error) {
                return base;
            }

            // RK4 with F = −½ρC_dA|v|v, ρ = 1.225 kg/m³.
            const k = (0.5 * 1.225 * x.cd * x.area) / x.m;
            let [px, py, vx, vy] = [0, x.h, x.v * Math.cos(x.angle), x.v * Math.sin(x.angle)];
            const dt = 0.002;
            const pts = [[px, py]];
            let t = 0;
            let peak = py;
            const deriv = (s) => {
                const sp = Math.hypot(s[2], s[3]);

                return [s[2], s[3], -k * sp * s[2], -x.g - k * sp * s[3]];
            };

            while (py >= 0 && t < 600) {
                const s = [px, py, vx, vy];
                const k1 = deriv(s);
                const k2 = deriv(s.map((q, j) => q + (dt / 2) * k1[j]));
                const k3 = deriv(s.map((q, j) => q + (dt / 2) * k2[j]));
                const k4 = deriv(s.map((q, j) => q + dt * k3[j]));
                [px, py, vx, vy] = s.map((q, j) => q + (dt / 6) * (k1[j] + 2 * k2[j] + 2 * k3[j] + k4[j]));
                t += dt;
                peak = Math.max(peak, py);

                if (Math.round(t / dt) % 25 === 0) {
                    pts.push([px, py]);
                }
            }

            pts.push([px, Math.max(py, 0)]);

            return { ...base, value: px, sub: `With drag: range ${num(px)} m, flight ${num(t)} s (drag-free ${num(base.rows.range[0])} m)`, rows: { ...base.rows, range: [px, 'length'], time: [t, 'time'], height: [peak, 'length'], impact: [Math.hypot(vx, vy), 'speed'], impactAngle: `${num(Math.atan2(-vy, vx) / D)}°` }, steps: [...base.steps, 'Air resistance: RK4 integration of a = −g ŷ − (ρC_dA ÷ 2m)|v|v with ρ = 1.225 kg/m³', `Range with drag ${num(px)} m`], plots: { trajectory: { series: pts, extra: [base.plots.trajectory.series], axes: true, xLabel: 'Distance (m)', yLabel: 'Height (m)' } } };
        },
    },
    velocity: pw({ vars: { v: ['Average velocity', 'speed', 'kmh', 60], d: ['Distance', 'length', 'km', 120], t: ['Time', 'time', 'h', 2] }, out: 'v', exp: { d: 1, t: -1 }, eq: 'v = d ÷ t', forms: { v: 'v = d ÷ t', d: 'd = v × t', t: 't = d ÷ v' } }),
    relative_velocity: {
        type: 'calc',
        inputs: { va: ['Speed of A', 'speed', 'kmh', 60], da: ['Direction of A', 'angle', 'deg', 0], vb: ['Speed of B', 'speed', 'kmh', 80], db: ['Direction of B', 'angle', 'deg', 90] },
        out: 'speed',
        outUnit: 'kmh',
        label: 'Speed of A relative to B',
        rows: { dir: 'Direction of A as seen from B', ba: 'B relative to A' },
        run: (x) => {
            const rx = x.va * Math.cos(x.da) - x.vb * Math.cos(x.db);
            const ry = x.va * Math.sin(x.da) - x.vb * Math.sin(x.db);
            const r = Math.hypot(rx, ry);

            return { value: r, sub: `Direction ${num(Math.atan2(ry, rx) / D)}°`, rows: { dir: `${num(Math.atan2(ry, rx) / D)}° from the reference direction`, ba: `Same speed, opposite direction (${num((Math.atan2(-ry, -rx) / D + 360) % 360)}°)` }, steps: ['v_AB = v_A − v_B (as vectors)', `= (${num(rx)}, ${num(ry)}) m/s`, `|v_AB| = ${num(r)} m/s`] };
        },
    },
    motion_graphs: {
        type: 'calc',
        inputs: { u: ['Initial velocity', 'speed', 'ms', 0], segments: ['Segments: duration (s), acceleration (m/s²) per line', 'textarea', null, '5, 2\n10, 0\n4, -2.5'] },
        out: 'length',
        outUnit: 'm',
        label: 'Final displacement',
        rows: { v: ['Final velocity', 'speed'], dist: ['Distance travelled', 'length'], time: ['Total time', 'time'], vmax: ['Top speed', 'speed'] },
        plots: [['velocity', 'Velocity–time graph'], ['position', 'Position–time graph']],
        run: (x) => {
            const segs = String(x.segments).split(/\n|;/).map((l) => l.trim()).filter(Boolean).map((l) => l.split(/[,\s]+/).map(Number));

            if (!segs.length || segs.some((s) => s.length !== 2 || !s.every(Number.isFinite) || s[0] <= 0)) {
                return { empty: 'Type each segment as duration, acceleration on its own line.' };
            }

            let t = 0;
            let v = x.u;
            let s = 0;
            let dist = 0;
            let vmax = Math.abs(v);
            const vel = [[0, v]];
            const pos = [[0, 0]];

            segs.forEach(([dur, a]) => {
                const n = 40;

                for (let k = 1; k <= n; k += 1) {
                    const dt = dur / n;
                    const v0 = v;
                    v += a * dt;
                    const ds = ((v0 + v) / 2) * dt;
                    s += ds;
                    dist += v0 * v >= 0 ? Math.abs(ds) : (v0 * v0 + v * v) / (2 * Math.abs(a));
                    t += dt;
                    vmax = Math.max(vmax, Math.abs(v));
                    vel.push([t, v]);
                    pos.push([t, s]);
                }
            });

            return { value: s, sub: `Final velocity ${num(v)} m/s after ${num(t)} s`, rows: { v: [v, 'speed'], dist: [dist, 'length'], time: [t, 'time'], vmax: [vmax, 'speed'] }, steps: segs.map(([dur, a], k) => `Segment ${k + 1}: ${num(dur)} s at ${num(a)} m/s²`).concat([`Displacement = area under the velocity graph = ${num(s)} m`]), plots: { velocity: { series: vel, axes: true, xLabel: 'Time (s)', yLabel: 'Velocity (m/s)' }, position: { series: pos, axes: true, xLabel: 'Time (s)', yLabel: 'Position (m)' } } };
        },
    },

    // Dynamics -----------------------------------------------------------------------------------
    newton2: pw({ vars: { F: ['Force', 'force', 'n', 10], m: ['Mass', 'mass', 'kg', 2], a: ['Acceleration', 'acceleration', 'ms2', 5] }, out: 'F', exp: { m: 1, a: 1 }, eq: 'F = m × a', forms: { F: 'F = m × a', m: 'm = F ÷ a', a: 'a = F ÷ m' }, rows: { weight: ['Weight of the mass on Earth', 'force'], g: 'Acceleration in g' }, extra: (v) => ({ weight: [v.m * g0, 'force'], g: `${num(v.a / g0)} g` }) }),
    acceleration: pw({ vars: { a: ['Acceleration', 'acceleration', 'ms2', 2.7778], dv: ['Change in velocity', 'speed', 'kmh', 100], t: ['Time', 'time', 's', 10] }, out: 'a', exp: { dv: 1, t: -1 }, eq: 'a = Δv ÷ t', forms: { a: 'a = Δv ÷ t', dv: 'Δv = a t', t: 't = Δv ÷ a' }, rows: { g: 'In g', dist: ['Distance covered from rest', 'length'] }, extra: (v) => ({ g: `${num(v.a / g0)} g`, dist: [0.5 * v.a * v.t ** 2, 'length'] }) }),
    banking: {
        type: 'law',
        vars: { theta: ['Banking angle', 'angle', 'deg', 15], v: ['Speed', 'speed', 'kmh', 80], r: ['Curve radius', 'length', 'm', 189], g: ['Gravity', 'acceleration', 'ms2', 9.80665] },
        default: 'theta',
        eq: 'tan θ = v² ÷ (r g)',
        forms: { theta: 'θ = atan(v² ÷ rg)', v: 'v = √(rg tan θ)', r: 'r = v² ÷ (g tan θ)', g: 'g = v² ÷ (r tan θ)' },
        solve: { theta: (v) => Math.atan((v.v * v.v) / (v.r * v.g)), v: (v) => Math.sqrt(v.r * v.g * Math.tan(v.theta)), r: (v) => (v.v * v.v) / (v.g * Math.tan(v.theta)), g: (v) => (v.v * v.v) / (v.r * Math.tan(v.theta)) },
        rows: { lateral: 'Sideways acceleration without banking', vmax: 'Maximum speed with tyre friction μ = 0.7' },
        extra: (v) => {
            const mu = 0.7;
            const t = Math.tan(v.theta);
            const vmax = Math.sqrt((v.r * v.g * (t + mu)) / (1 - mu * t));

            return { lateral: `${num((v.v * v.v) / v.r / g0)} g`, vmax: mu * t < 1 ? `${num(vmax * 3.6)} km/h` : 'No limit from sliding' };
        },
    },
    car_crash: {
        type: 'calc',
        inputs: { m: ['Mass of the person (or car)', 'mass', 'kg', 75], v: ['Impact speed', 'speed', 'kmh', 50], d: ['Stopping distance (crumple zone, belt stretch)', 'length', 'cm', 50] },
        out: 'force',
        outUnit: 'kn',
        label: 'Average impact force',
        rows: { g: 'Average deceleration', time: ['Duration of the impact', 'short_time'], energy: ['Kinetic energy', 'energy'], fall: ['Equivalent fall height', 'length'] },
        run: (x) => {
            const E = 0.5 * x.m * x.v * x.v;
            const F = E / x.d;
            const a = (x.v * x.v) / (2 * x.d);

            return { value: F, sub: `${num(a / g0)} g average deceleration`, rows: { g: `${num(a / g0)} g`, time: [(2 * x.d) / x.v, 'short_time'], energy: [E, 'energy'], fall: [(x.v * x.v) / (2 * g0), 'length'] }, steps: ['Work–energy theorem: F d = ½mv²', `F = ${num(E)} J ÷ ${num(x.d)} m = ${num(F)} N`, `a = v² ÷ 2d = ${num(a)} m/s² = ${num(a / g0)} g`, 'A seat belt and crumple zone lengthen d, which lowers the force'] };
        },
    },
    gravitational_force: pw({ vars: { F: ['Gravitational force', 'force', 'n', 1.98e20], m1: ['Mass 1', 'mass', 'kg', 5.9722e24], m2: ['Mass 2', 'mass', 'kg', 7.342e22], r: ['Distance between centres', 'length', 'km', 384400] }, out: 'F', k: K.G, exp: { m1: 1, m2: 1, r: -2 }, eq: 'F = G m₁ m₂ ÷ r²', forms: { F: 'F = Gm₁m₂ ÷ r²', m1: 'm₁ = Fr² ÷ Gm₂', m2: 'm₂ = Fr² ÷ Gm₁', r: 'r = √(Gm₁m₂ ÷ F)' }, rows: { field: 'Field of mass 1 at that distance' }, extra: (v) => ({ field: `${num((K.G * v.m1) / v.r ** 2)} m/s²` }) }),
    hooke: pw({ vars: { F: ['Spring force', 'force', 'n', 50], k: ['Spring constant', 'stiffness', 'npm', 500], x: ['Extension or compression', 'length', 'cm', 10] }, out: 'F', exp: { k: 1, x: 1 }, eq: 'F = k x', forms: { F: 'F = kx', k: 'k = F ÷ x', x: 'x = F ÷ k' }, rows: { energy: ['Elastic energy stored', 'energy'] }, extra: (v) => ({ energy: [0.5 * v.k * v.x ** 2, 'energy'] }) }),
    kg_newtons: {
        type: 'calc',
        inputs: { m: ['Mass', 'mass', 'kg', 1], body: ['Gravity of', 'select', { standard: 'Earth (standard g₀ = 9.80665 m/s²)', moon: 'Moon', mars: 'Mars', jupiter: 'Jupiter', custom: 'Custom' }, 'standard'], g: ['Custom gravity', 'acceleration', 'ms2', 9.81] },
        show: { g: 'body:custom' },
        when: { g: (x) => x.body === 'custom' },
        data: ['bodies'],
        out: 'force',
        outUnit: 'n',
        label: 'Weight',
        rows: { lbf: ['In pound-force', 'force'], kgf: 'In kilogram-force', g: 'Gravity used' },
        run: (x, ctx) => {
            const g = x.body === 'standard' ? g0 : x.body === 'custom' ? x.g : bodyG(ctx.c.data, x.body);
            const W = x.m * g;

            return { value: W, sub: `W = m g with g = ${num(g)} m/s²`, rows: { lbf: [W, 'force'], kgf: `${num(W / g0)} kgf`, g: `${num(g)} m/s²` }, steps: ['W = m × g', `= ${num(x.m)} kg × ${num(g)} m/s² = ${num(W)} N`] };
        },
    },
    newton3: {
        type: 'calc',
        inputs: { m1: ['Mass of body A', 'mass', 'kg', 70], a1: ['Acceleration of A', 'acceleration', 'ms2', 0.5], m2: ['Mass of body B', 'mass', 'kg', 35] },
        out: 'acceleration',
        outUnit: 'ms2',
        label: 'Acceleration of B',
        rows: { F: ['Force on each (equal and opposite)', 'force'] },
        run: (x) => {
            const F = x.m1 * x.a1;

            return { value: F / x.m2, sub: `Both feel ${num(F)} N in opposite directions`, rows: { F: [F, 'force'] }, steps: ['F_AB = −F_BA', `F = m_A a_A = ${num(F)} N`, `a_B = F ÷ m_B = ${num(F / x.m2)} m/s² (opposite direction)`] };
        },
    },
    normal_force: {
        type: 'calc',
        inputs: { m: ['Mass', 'mass', 'kg', 10], angle: ['Surface slope', 'angle', 'deg', 0], F: ['Extra applied force', 'force', 'n', 0], phi: ['Angle of that force above the surface', 'angle', 'deg', 0], a: ['Upward acceleration (lift)', 'acceleration', 'ms2', 0] },
        out: 'force',
        outUnit: 'n',
        label: 'Normal force',
        rows: { weight: ['Weight', 'force'], ratio: 'Normal force ÷ weight' },
        run: (x) => {
            const N = x.m * (g0 + x.a) * Math.cos(x.angle) - x.F * Math.sin(x.phi);

            if (N < 0) {
                return { error: 'The pull lifts the object off the surface (the normal force would be negative).' };
            }

            return { value: N, sub: `${num(N / (x.m * g0))} × the weight`, rows: { weight: [x.m * g0, 'force'], ratio: num(N / (x.m * g0)) }, steps: ['N = m(g + a) cos θ − F sin φ', `= ${num(x.m)} × ${num(g0 + x.a)} × cos ${num(x.angle / D)}° − ${num(x.F)} × sin ${num(x.phi / D)}° = ${num(N)} N`] };
        },
    },
    net_force: {
        type: 'calc',
        inputs: { forces: ['Forces: magnitude in newtons, direction in degrees (one per line)', 'textarea', null, '50, 0\n30, 90\n20, 210'], m: ['Mass (optional, for acceleration)', 'mass', 'kg', 10] },
        optional: ['m'],
        out: 'force',
        outUnit: 'n',
        label: 'Net force',
        rows: { dir: 'Direction', comps: 'Components (x, y)', a: ['Acceleration', 'acceleration'] },
        plots: [['vectors', 'Force diagram']],
        run: (x) => {
            const rows = readVectors(x.forces);

            if (!rows) {
                return { empty: 'Type each force as magnitude, direction in degrees, one per line.' };
            }

            const fx = rows.reduce((s, [m, a]) => s + m * cosd(a), 0);
            const fy = rows.reduce((s, [m, a]) => s + m * sind(a), 0);
            const F = Math.hypot(fx, fy);

            return { value: F, sub: `Direction ${num(Math.atan2(fy, fx) / D)}°`, rows: { dir: `${num(Math.atan2(fy, fx) / D)}°`, comps: `(${num(fx)}, ${num(fy)}) N`, a: Number.isFinite(x.m) && x.m > 0 ? [F / x.m, 'acceleration'] : 'Enter a mass' }, steps: ['Resolve each force: Fₓ = F cos θ, F_y = F sin θ', ...rows.map(([m, a]) => `${num(m)} N at ${num(a)}°: (${num(m * cosd(a))}, ${num(m * sind(a))})`), `ΣF = (${num(fx)}, ${num(fy)}) N, |ΣF| = ${num(F)} N`], plots: { vectors: { kind: 'diagram', shapes: [...rows.map(([m, a]) => ({ points: [[0, 0], [m * cosd(a), m * sind(a)]], muted: true })), { points: [[0, 0], [fx, fy]] }], dots: [[fx, fy]] } } };
        },
    },
    stopping_distance: {
        type: 'calc',
        inputs: { v: ['Speed', 'speed', 'kmh', 100], tr: ['Reaction time', 'time', 's', 1.5], road: ['Road surface', 'select', Object.fromEntries(Object.entries(ROADS).map(([k, r]) => [k, r[0]])), 'dry'], grade: ['Downhill slope (%)', null, null, 0] },
        out: 'length',
        outUnit: 'm',
        label: 'Stopping distance',
        rows: { react: ['Reaction distance', 'length'], brake: ['Braking distance', 'length'], time: ['Total time to stop', 'time'], decel: 'Braking deceleration' },
        run: (x) => {
            const mu = ROADS[x.road][1];
            const th = Math.atan(x.grade / 100);
            const a = g0 * (mu * Math.cos(th) - Math.sin(th));

            if (!(a > 0)) {
                return { error: 'On this slope the brakes cannot stop the car (friction is too low).' };
            }

            const react = x.v * x.tr;
            const brake = (x.v * x.v) / (2 * a);

            return { value: react + brake, sub: `${num(react)} m thinking + ${num(brake)} m braking`, rows: { react: [react, 'length'], brake: [brake, 'length'], time: [x.tr + x.v / a, 'time'], decel: `${num(a)} m/s² (${num(a / g0)} g)` }, steps: [`Reaction distance = v t = ${num(react)} m`, `Braking distance = v² ÷ 2g(μ cos θ − sin θ) = ${num(brake)} m`, `Total ${num(react + brake)} m (an idealised estimate; tyres, brakes and ABS vary)`] };
        },
    },
    tension: {
        type: 'calc',
        inputs: { setup: ['Set-up', 'select', { hang: 'Mass on one vertical rope (with acceleration)', two: 'Mass held by two angled ropes' }, 'two'], m: ['Mass', 'mass', 'kg', 10], a: ['Upward acceleration', 'acceleration', 'ms2', 0], t1: ['Rope 1 angle above horizontal', 'angle', 'deg', 30], t2: ['Rope 2 angle above horizontal', 'angle', 'deg', 45] },
        show: { a: 'setup:hang', t1: 'setup:two', t2: 'setup:two' },
        when: { a: (x) => x.setup === 'hang', t1: (x) => x.setup === 'two', t2: (x) => x.setup === 'two' },
        out: 'force',
        outUnit: 'n',
        label: 'Tension',
        rows: { T1: ['Tension in rope 1', 'force'], T2: ['Tension in rope 2', 'force'], W: ['Weight', 'force'] },
        run: (x) => {
            const W = x.m * g0;

            if (x.setup === 'hang') {
                const T = x.m * (g0 + x.a);

                return { value: T, sub: 'T = m(g + a)', rows: { T1: [T, 'force'], T2: 'Not used', W: [W, 'force'] }, steps: [`T = m(g + a) = ${num(x.m)} × ${num(g0 + x.a)} = ${num(T)} N`] };
            }

            const s = Math.sin(x.t1 + x.t2);
            const T1 = (W * Math.cos(x.t2)) / s;
            const T2 = (W * Math.cos(x.t1)) / s;

            return { value: Math.max(T1, T2), sub: `T₁ = ${num(T1)} N, T₂ = ${num(T2)} N`, rows: { T1: [T1, 'force'], T2: [T2, 'force'], W: [W, 'force'] }, steps: ['Horizontal: T₁ cos θ₁ = T₂ cos θ₂; vertical: T₁ sin θ₁ + T₂ sin θ₂ = W', `T₁ = W cos θ₂ ÷ sin(θ₁ + θ₂) = ${num(T1)} N`, `T₂ = W cos θ₁ ÷ sin(θ₁ + θ₂) = ${num(T2)} N`] };
        },
    },
    atwood: {
        type: 'calc',
        inputs: { m1: ['Heavier mass m₁', 'mass', 'kg', 3], m2: ['Lighter mass m₂', 'mass', 'kg', 2], I: ['Pulley moment of inertia (0 for ideal)', 'moment_of_inertia', 'kgm2', 0], r: ['Pulley radius', 'length', 'cm', 10], d: ['Distance moved', 'length', 'm', 1] },
        out: 'acceleration',
        outUnit: 'ms2',
        label: 'Acceleration',
        rows: { T1: ['Tension on the m₁ side', 'force'], T2: ['Tension on the m₂ side', 'force'], v: ['Speed after that distance', 'speed'], t: ['Time to move it', 'time'] },
        run: (x) => {
            const a = ((x.m1 - x.m2) * g0) / (x.m1 + x.m2 + x.I / (x.r * x.r));

            return { value: a, sub: a >= 0 ? 'm₁ moves down' : 'm₂ moves down', rows: { T1: [x.m1 * (g0 - a), 'force'], T2: [x.m2 * (g0 + a), 'force'], v: [Math.sqrt(2 * Math.abs(a) * x.d), 'speed'], t: [Math.sqrt((2 * x.d) / Math.abs(a)), 'time'] }, steps: ['a = (m₁ − m₂)g ÷ (m₁ + m₂ + I/r²)', `= ${num(a)} m/s²`, `T₁ = m₁(g − a) = ${num(x.m1 * (g0 - a))} N, T₂ = m₂(g + a) = ${num(x.m2 * (g0 + a))} N`] };
        },
    },
    elastic_collision: {
        type: 'calc',
        inputs: { m1: ['Mass 1', 'mass', 'kg', 1], u1: ['Velocity 1', 'speed', 'ms', 4], m2: ['Mass 2', 'mass', 'kg', 3], u2: ['Velocity 2', 'speed', 'ms', 0] },
        out: 'speed',
        outUnit: 'ms',
        label: 'Final velocity of body 1',
        rows: { v2: ['Final velocity of body 2', 'speed'], p: 'Momentum before and after', ke: 'Kinetic energy before and after' },
        run: (x) => {
            const M = x.m1 + x.m2;
            const v1 = ((x.m1 - x.m2) * x.u1 + 2 * x.m2 * x.u2) / M;
            const v2 = ((x.m2 - x.m1) * x.u2 + 2 * x.m1 * x.u1) / M;
            const ke = 0.5 * x.m1 * x.u1 ** 2 + 0.5 * x.m2 * x.u2 ** 2;

            return { value: v1, sub: `Body 2 leaves at ${num(v2)} m/s`, rows: { v2: [v2, 'speed'], p: `${num(x.m1 * x.u1 + x.m2 * x.u2)} kg·m/s, unchanged`, ke: `${num(ke)} J, unchanged` }, steps: ['v₁ = ((m₁ − m₂)u₁ + 2m₂u₂) ÷ (m₁ + m₂)', `= ${num(v1)} m/s`, 'v₂ = ((m₂ − m₁)u₂ + 2m₁u₁) ÷ (m₁ + m₂)', `= ${num(v2)} m/s`] };
        },
    },
    inelastic_collision: {
        type: 'calc',
        inputs: { m1: ['Mass 1', 'mass', 'kg', 1000], u1: ['Velocity 1', 'speed', 'ms', 15], m2: ['Mass 2', 'mass', 'kg', 1500], u2: ['Velocity 2', 'speed', 'ms', 0], e: ['Coefficient of restitution e (0 = they stick)', null, null, 0, 0] },
        out: 'speed',
        outUnit: 'ms',
        label: 'Final velocity of body 1',
        rows: { v2: ['Final velocity of body 2', 'speed'], lost: ['Kinetic energy lost', 'energy'], share: 'Share of energy lost' },
        run: (x) => {
            if (x.e > 1) {
                return { error: 'e cannot exceed 1 (that would create energy).' };
            }

            const M = x.m1 + x.m2;
            const p = x.m1 * x.u1 + x.m2 * x.u2;
            const v1 = (p - x.m2 * x.e * (x.u1 - x.u2)) / M;
            const v2 = (p + x.m1 * x.e * (x.u1 - x.u2)) / M;
            const before = 0.5 * x.m1 * x.u1 ** 2 + 0.5 * x.m2 * x.u2 ** 2;
            const after = 0.5 * x.m1 * v1 ** 2 + 0.5 * x.m2 * v2 ** 2;

            return { value: v1, sub: x.e === 0 ? 'Perfectly inelastic: they move together' : `Body 2 leaves at ${num(v2)} m/s`, rows: { v2: [v2, 'speed'], lost: [before - after, 'energy'], share: `${num(((before - after) / before) * 100)}%` }, steps: ['Momentum is conserved; e = (v₂ − v₁) ÷ (u₁ − u₂)', `v₁ = ${num(v1)} m/s, v₂ = ${num(v2)} m/s`, `Energy lost: ${num(before - after)} J`] };
        },
    },
    restitution: {
        type: 'calc',
        inputs: { h1: ['Drop height', 'length', 'cm', 100], h2: ['Bounce height', 'length', 'cm', 64] },
        label: 'Coefficient of restitution e',
        rows: { bounces: 'Next bounce heights', total: ['Total distance travelled (all bounces)', 'length'], energy: 'Energy kept per bounce' },
        run: (x) => {
            if (!(x.h2 <= x.h1)) {
                return { error: 'The bounce cannot be higher than the drop.' };
            }

            const e = Math.sqrt(x.h2 / x.h1);

            return { value: num(e, 5), sub: `${num(e * e * 100)}% of the energy kept per bounce`, rows: { bounces: Array.from({ length: 4 }, (_, k) => `${num((x.h1 * e ** (2 * (k + 1))) * 100, 4)} cm`).join(', '), total: [x.h1 + (2 * x.h1 * e * e) / (1 - e * e), 'length'], energy: `${num(e * e * 100)}%` }, steps: ['e = v_after ÷ v_before = √(h₂ ÷ h₁)', `= √(${num(x.h2)} ÷ ${num(x.h1)}) = ${num(e)}`] };
        },
    },

    // Statics ------------------------------------------------------------------------------------
    car_com: {
        type: 'calc',
        inputs: { L: ['Wheelbase', 'length', 'in', 106], wf: ['Front axle weight (level)', 'mass', 'lb', 1800], wr: ['Rear axle weight (level)', 'mass', 'lb', 1400], H: ['Height the rear is raised', 'length', 'in', 10], wf2: ['Front axle weight (rear raised)', 'mass', 'lb', 1850], r: ['Tyre radius (axle height)', 'length', 'in', 12] },
        out: 'length',
        outUnit: 'in',
        label: 'Centre of mass height',
        rows: { x: ['Distance behind the front axle', 'length'], split: 'Front/rear weight split' },
        run: (x) => {
            const W = x.wf + x.wr;
            const theta = Math.asin(x.H / x.L);
            const h = x.r + (x.L * (x.wf2 - x.wf)) / (W * Math.tan(theta));

            return { value: h, sub: `${num((x.wf / W) * 100, 4)}% of the weight on the front`, rows: { x: [(x.wr * x.L) / W, 'length'], split: `${num((x.wf / W) * 100, 4)}% / ${num((x.wr / W) * 100, 4)}%` }, steps: ['Longitudinal: x = W_rear L ÷ W', `Raise angle θ = asin(H ÷ L) = ${num(theta / D)}°`, 'Height h = r + L(W_front,raised − W_front) ÷ (W tan θ)', `= ${num(h)} m`] };
        },
    },
    psi: pw({ vars: { P: ['Pressure', 'pressure', 'psi', 50], F: ['Force', 'force', 'lbf', 500], A: ['Area', 'area', 'in2', 10] }, out: 'P', exp: { F: 1, A: -1 }, eq: 'P = F ÷ A', forms: { P: 'P = F ÷ A', F: 'F = P A', A: 'A = F ÷ P' } }),
    pressure: pw({ vars: { P: ['Pressure', 'pressure', 'kpa', 50], F: ['Force', 'force', 'n', 500], A: ['Area', 'area', 'cm2', 100] }, out: 'P', exp: { F: 1, A: -1 }, eq: 'P = F ÷ A', forms: { P: 'P = F ÷ A', F: 'F = P A', A: 'A = F ÷ P' } }),
    reduced_mass: {
        type: 'calc',
        inputs: { m1: ['Mass 1', 'particle_mass', 'u', 1.00782503207], m2: ['Mass 2', 'particle_mass', 'u', 34.968852682] },
        out: 'particle_mass',
        outUnit: 'u',
        label: 'Reduced mass μ',
        rows: { kg: 'In kilograms', ratio: 'μ ÷ smaller mass' },
        run: (x) => {
            const mu = (x.m1 * x.m2) / (x.m1 + x.m2);

            return { value: mu, sub: 'μ = m₁m₂ ÷ (m₁ + m₂)', rows: { kg: `${num(mu)} kg`, ratio: num(mu / Math.min(x.m1, x.m2)) }, steps: [`μ = ${num(x.m1)} × ${num(x.m2)} ÷ (${num(x.m1)} + ${num(x.m2)}) kg = ${num(mu)} kg`] };
        },
    },
    weight_planets: {
        type: 'calc',
        inputs: { m: ['Your mass (or Earth weight in kg or lb)', 'mass', 'kg', 70] },
        data: ['bodies'],
        out: 'force',
        outUnit: 'n',
        label: 'Weight on Earth',
        rows: { moon: 'Moon', mars: 'Mars', jupiter: 'Jupiter', table: 'Every body (as Earth-kilograms on a bathroom scale)' },
        grids: [['planets', 'Weight on each body']],
        run: (x, ctx) => {
            const bodies = ctx.c.data.physics.bodies;
            const gE = bodyG(ctx.c.data, 'earth');
            const list = Object.entries(bodies).map(([k, b]) => [b.name, bodyG(ctx.c.data, k)]);

            return { value: x.m * gE, sub: 'Scale readings in kg are your Earth mass × g_body ÷ g_Earth', rows: { moon: `${num((x.m * bodyG(ctx.c.data, 'moon')) / gE, 4)} kg-weight`, mars: `${num((x.m * bodyG(ctx.c.data, 'mars')) / gE, 4)} kg-weight`, jupiter: `${num((x.m * bodyG(ctx.c.data, 'jupiter')) / gE, 4)} kg-weight`, table: list.map(([n, g]) => `${n} ${num((x.m * g) / gE, 4)}`).join(', ') }, steps: ['W = m × g, with g = GM ÷ r² at each body\'s mean radius (NASA/JPL)', ...list.map(([n, g]) => `${n}: g = ${num(g, 4)} m/s² → ${num(x.m * g, 5)} N`)], grids: { planets: { columns: ['Gravity (m/s²)', 'Weight (N)', 'Scale reading (kg)'], rows: list.map(([n, g]) => ({ header: n, cells: [num(g, 4), num(x.m * g, 5), num((x.m * g) / gE, 4)] })) } } };
        },
    },
    moments: {
        type: 'calc',
        inputs: { forces: ['Forces: force in N, distance from the pivot in m (positive = anticlockwise)', 'textarea', null, '200, -1.5\n100, 2'], d: ['Where the balancing force acts (distance)', 'length', 'm', 1] },
        out: 'force',
        outUnit: 'n',
        label: 'Force needed to balance',
        rows: { net: 'Net moment now', dir: 'Direction of the balancing force' },
        run: (x) => {
            const rows = readVectors(x.forces);

            if (!rows) {
                return { empty: 'Type each force as force, distance on its own line.' };
            }

            const M = rows.reduce((s, [f, d]) => s + f * d, 0);
            const F = -M / x.d;

            return { value: Math.abs(F), sub: `Net moment ${num(M)} N·m (${M > 0 ? 'anticlockwise' : M < 0 ? 'clockwise' : 'balanced'})`, rows: { net: `${num(M)} N·m`, dir: F >= 0 ? 'Same sense as a positive force' : 'Opposite to a positive force' }, steps: ['Σ moments = Σ F × d', ...rows.map(([f, d]) => `${num(f)} N × ${num(d)} m = ${num(f * d)} N·m`), `Balance: F × ${num(x.d)} m = ${num(-M)} N·m → F = ${num(F)} N`] };
        },
    },

    // Energy, work and power ---------------------------------------------------------------------
    bullet_energy: {
        type: 'calc',
        inputs: { m: ['Bullet weight', 'mass', 'gr', 150], v: ['Velocity', 'speed', 'fts', 2820], d: ['Bullet diameter (for TKO)', 'length', 'in', 0.308] },
        optional: ['d'],
        out: 'energy',
        outUnit: 'ftlbf',
        label: 'Muzzle energy',
        rows: { joules: ['In joules', 'energy'], momentum: ['Momentum', 'momentum'], tko: 'Taylor knock-out factor' },
        run: (x) => {
            const E = 0.5 * x.m * x.v * x.v;
            const gr = x.m / 6.479891e-5;
            const fps = x.v / 0.3048;

            return { value: E, sub: `${num(E)} J`, rows: { joules: [E, 'energy'], momentum: [x.m * x.v, 'momentum'], tko: Number.isFinite(x.d) ? num((gr * fps * (x.d / 0.0254)) / 7000, 4) : 'Enter a diameter' }, steps: ['E = ½mv²', `= ½ × ${num(x.m)} kg × (${num(x.v)} m/s)² = ${num(E)} J`] };
        },
    },
    fpe: {
        type: 'calc',
        inputs: { m: ['Projectile weight', 'mass', 'gr', 14.3], v: ['Velocity', 'speed', 'fts', 900] },
        out: 'energy',
        outUnit: 'ftlbf',
        label: 'Energy',
        rows: { joules: ['In joules', 'energy'] },
        run: (x) => ({ value: 0.5 * x.m * x.v * x.v, sub: 'FPE = grains × (ft/s)² ÷ 450,240', rows: { joules: [0.5 * x.m * x.v * x.v, 'energy'] }, steps: ['FPE = m v² ÷ 450,240 (m in grains, v in ft/s)', `= ${num(x.m / 6.479891e-5)} × ${num(x.v / 0.3048)}² ÷ 450,240 = ${num((x.m / 6.479891e-5) * (x.v / 0.3048) ** 2 / 450240)} ft·lbf`] }),
    },
    eirp: {
        type: 'calc',
        inputs: { p: ['Transmitter power (dBm)', null, null, 30], loss: ['Cable and connector loss (dB)', null, null, 2, 0], gain: ['Antenna gain (dBi)', null, null, 12] },
        label: 'EIRP',
        rows: { watts: 'In watts', dbw: 'In dBW', erp: 'ERP (relative to a dipole)' },
        run: (x) => {
            const e = x.p - x.loss + x.gain;

            return { value: num(e, 5), unit: 'dBm', sub: `${num(10 ** ((e - 30) / 10))} W`, rows: { watts: `${num(10 ** ((e - 30) / 10))} W`, dbw: `${num(e - 30, 5)} dBW`, erp: `${num(e - 2.15, 5)} dBm (${num(10 ** ((e - 2.15 - 30) / 10))} W)` }, steps: ['EIRP = P − L + G (decibels)', `= ${num(x.p)} − ${num(x.loss)} + ${num(x.gain)} = ${num(e)} dBm`] };
        },
    },
    elastic_pe: pw({ vars: { E: ['Elastic potential energy', 'energy', 'j', 2.5], k: ['Spring constant', 'stiffness', 'npm', 500], x: ['Extension or compression', 'length', 'cm', 10] }, out: 'E', k: 0.5, exp: { k: 1, x: 2 }, eq: 'E = ½ k x²', forms: { E: 'E = ½kx²', k: 'k = 2E ÷ x²', x: 'x = √(2E ÷ k)' }, rows: { F: ['Force at that extension', 'force'] }, extra: (v) => ({ F: [v.k * v.x, 'force'] }) }),
    impact_energy: {
        type: 'calc',
        inputs: { m: ['Mass', 'mass', 'kg', 5], mode: ['I know', 'select', { v: 'The impact speed', h: 'The drop height' }, 'h'], v: ['Impact speed', 'speed', 'ms', 10], h: ['Drop height', 'length', 'm', 2], d: ['Stopping distance', 'length', 'cm', 1] },
        show: { v: 'mode:v', h: 'mode:h' },
        when: { v: (x) => x.mode === 'v', h: (x) => x.mode === 'h' },
        out: 'energy',
        outUnit: 'j',
        label: 'Impact energy',
        rows: { F: ['Average impact force', 'force'], g: 'Average deceleration', speed: ['Impact speed', 'speed'] },
        run: (x) => {
            const v = x.mode === 'v' ? x.v : Math.sqrt(2 * g0 * x.h);
            const E = 0.5 * x.m * v * v;

            return { value: E, sub: `Average force ${num(E / x.d)} N over ${num(x.d * 100)} cm`, rows: { F: [E / x.d, 'force'], g: `${num((v * v) / (2 * x.d) / g0)} g`, speed: [v, 'speed'] }, steps: [x.mode === 'h' ? `v = √(2gh) = ${num(v)} m/s` : `v = ${num(v)} m/s`, `E = ½mv² = ${num(E)} J`, `F = E ÷ d = ${num(E / x.d)} N`] };
        },
    },
    kinetic_energy: pw({ vars: { E: ['Kinetic energy', 'energy', 'j', 1000], m: ['Mass', 'mass', 'kg', 20], v: ['Speed', 'speed', 'ms', 10] }, out: 'E', k: 0.5, exp: { m: 1, v: 2 }, eq: 'E = ½ m v²', forms: { E: 'E = ½mv²', m: 'm = 2E ÷ v²', v: 'v = √(2E ÷ m)' }, rows: { p: ['Momentum', 'momentum'], drop: ['Drop height that gives this speed', 'length'] }, extra: (v) => ({ p: [v.m * v.v, 'momentum'], drop: [(v.v * v.v) / (2 * g0), 'length'] }) }),
    potential_energy: pw({ vars: { E: ['Potential energy', 'energy', 'j', 981], m: ['Mass', 'mass', 'kg', 10], h: ['Height', 'length', 'm', 10], g: ['Gravity', 'acceleration', 'ms2', 9.80665] }, out: 'E', exp: { m: 1, h: 1, g: 1 }, eq: 'E = m g h', forms: { E: 'E = mgh', m: 'm = E ÷ gh', h: 'h = E ÷ mg', g: 'g = E ÷ mh' }, rows: { v: ['Speed if dropped from that height', 'speed'] }, extra: (v) => ({ v: [Math.sqrt(2 * v.g * v.h), 'speed'] }) }),
    power_weight: {
        type: 'calc',
        inputs: { p: ['Power', 'power', 'hp', 300], m: ['Mass', 'mass', 'kg', 1500] },
        label: 'Power-to-weight ratio',
        rows: { hpton: 'Horsepower per metric ton', lbhp: 'Pounds per horsepower', compare: 'For comparison' },
        run: (x) => ({ value: num(x.p / x.m), unit: 'W/kg', sub: `${num(x.p / 745.7 / (x.m / 1000))} hp per tonne`, rows: { hpton: `${num(x.p / 745.7 / (x.m / 1000))} hp/t`, lbhp: `${num(x.m / 0.45359237 / (x.p / 745.7))} lb/hp`, compare: 'Family car ≈ 70 W/kg, sports car ≈ 200 W/kg, F1 car ≈ 1,000 W/kg, pro cyclist ≈ 6 W/kg (of body weight) for an hour' }, steps: [`Ratio = P ÷ m = ${num(x.p)} W ÷ ${num(x.m)} kg = ${num(x.p / x.m)} W/kg`] }),
    },
    recoil: {
        type: 'calc',
        inputs: { mb: ['Bullet weight', 'mass', 'gr', 150], vb: ['Muzzle velocity', 'speed', 'fts', 2800], mp: ['Powder charge', 'mass', 'gr', 50], mg: ['Firearm weight', 'mass', 'lb', 8], vp: ['Powder gas velocity (SAAMI)', 'speed', 'fts', 4000] },
        out: 'energy',
        outUnit: 'ftlbf',
        label: 'Recoil energy',
        rows: { v: ['Recoil velocity', 'speed'], impulse: ['Recoil impulse', 'momentum'] },
        run: (x) => {
            const p = x.mb * x.vb + x.mp * x.vp;
            const v = p / x.mg;

            return { value: 0.5 * x.mg * v * v, sub: `Recoil velocity ${num(v / 0.3048)} ft/s (an estimate)`, rows: { v: [v, 'speed'], impulse: [p, 'momentum'] }, steps: ['Momentum balance: m_gun v_gun = m_bullet v_bullet + m_powder v_gas', `v_gun = ${num(p)} ÷ ${num(x.mg)} = ${num(v)} m/s`, `E = ½ m_gun v² = ${num(0.5 * x.mg * v * v)} J`] };
        },
    },
    snr: {
        type: 'calc',
        inputs: { kind: ['Values are', 'select', { power: 'Powers (same unit)', voltage: 'Voltages or amplitudes (same unit)', db: 'Levels in dB (dBm, dBV …)' }, 'power'], s: ['Signal', null, null, 100], n: ['Noise', null, null, 1], bw: ['Bandwidth (optional, for capacity)', 'frequency_hz', 'mhz', 20] },
        optional: ['bw'],
        label: 'Signal-to-noise ratio',
        rows: { linear: 'Linear power ratio', capacity: 'Shannon capacity' },
        run: (x) => {
            const db = x.kind === 'db' ? x.s - x.n : x.kind === 'voltage' ? 20 * Math.log10(x.s / x.n) : 10 * Math.log10(x.s / x.n);
            const lin = 10 ** (db / 10);

            if (!Number.isFinite(db)) {
                return { error: 'Signal and noise must be positive.' };
            }

            return { value: num(db, 5), unit: 'dB', sub: `Power ratio ${num(lin)}`, rows: { linear: num(lin), capacity: Number.isFinite(x.bw) ? `${num((x.bw * Math.log2(1 + lin)) / 1e6)} Mbit/s` : 'Enter a bandwidth' }, steps: [x.kind === 'voltage' ? 'SNR = 20 log₁₀(V_s ÷ V_n)' : x.kind === 'db' ? 'SNR = L_s − L_n' : 'SNR = 10 log₁₀(P_s ÷ P_n)', `= ${num(db)} dB`, ...(Number.isFinite(x.bw) ? [`C = B log₂(1 + SNR) = ${num(x.bw * Math.log2(1 + lin))} bit/s`] : [])] };
        },
    },
    tnt: {
        type: 'calc',
        inputs: { E: ['Energy', 'energy', 'gj', 4.184] },
        label: 'TNT equivalent',
        rows: { kg: 'In kilograms of TNT', kt: 'In kilotons', compare: 'Compared with' },
        run: (x) => {
            const t = x.E / 4.184e9;

            return { value: num(t), unit: 't TNT', sub: '1 tonne of TNT = 4.184 GJ (by definition)', rows: { kg: `${num(t * 1000)} kg`, kt: `${num(t / 1000)} kt`, compare: `${num(t / 15000)} × the Hiroshima bomb (≈ 15 kt); ${num(x.E / 3.6e6)} kWh` }, steps: [`${num(x.E)} J ÷ 4.184 × 10⁹ J/t = ${num(t)} t`] };
        },
    },
    work: {
        type: 'law',
        vars: { W: ['Work done', 'energy', 'j', 433], F: ['Force', 'force', 'n', 50], d: ['Distance', 'length', 'm', 10], theta: ['Angle between force and motion', 'angle', 'deg', 30] },
        default: 'W',
        eq: 'W = F d cos θ',
        forms: { W: 'W = Fd cos θ', F: 'F = W ÷ (d cos θ)', d: 'd = W ÷ (F cos θ)', theta: 'θ = acos(W ÷ Fd)' },
        solve: { W: (v) => v.F * v.d * Math.cos(v.theta), F: (v) => v.W / (v.d * Math.cos(v.theta)), d: (v) => v.W / (v.F * Math.cos(v.theta)), theta: (v) => Math.acos(v.W / (v.F * v.d)) },
        rows: { along: ['Force component along the motion', 'force'] },
        extra: (v) => ({ along: [v.F * Math.cos(v.theta), 'force'] }),
    },
    work_power: pw({ vars: { P: ['Power', 'power', 'w', 250], W: ['Work (energy)', 'energy', 'kj', 15], t: ['Time', 'time', 'min', 1] }, out: 'P', exp: { W: 1, t: -1 }, eq: 'P = W ÷ t', forms: { P: 'P = W ÷ t', W: 'W = P t', t: 't = W ÷ P' }, rows: { kwh: 'Energy per hour at that power' }, extra: (v) => ({ kwh: `${num(v.P / 1000)} kWh` }) }),
    mech_energy: {
        type: 'calc',
        inputs: { m: ['Mass', 'mass', 'kg', 500], h: ['Height', 'length', 'm', 40], v: ['Speed', 'speed', 'ms', 5], h2: ['Another height (speed there)', 'length', 'm', 10] },
        optional: ['h2'],
        out: 'energy',
        outUnit: 'kj',
        label: 'Total mechanical energy',
        rows: { ke: ['Kinetic energy', 'energy'], pe: ['Potential energy', 'energy'], v2: ['Speed at the other height (no friction)', 'speed'] },
        run: (x) => {
            const ke = 0.5 * x.m * x.v * x.v;
            const pe = x.m * g0 * x.h;
            const v2s = x.v * x.v + 2 * g0 * (x.h - x.h2);

            return { value: ke + pe, sub: `${num(ke)} J kinetic + ${num(pe)} J potential`, rows: { ke: [ke, 'energy'], pe: [pe, 'energy'], v2: Number.isFinite(x.h2) ? (v2s >= 0 ? [Math.sqrt(v2s), 'speed'] : 'Not enough energy to get there') : 'Enter a height' }, steps: ['E = ½mv² + mgh', `= ${num(ke)} + ${num(pe)} = ${num(ke + pe)} J`, 'Without friction E stays the same: v₂ = √(v² + 2g(h − h₂))'] };
        },
    },

    // Rotational and periodic motion -------------------------------------------------------------
    ang_accel: pw({ vars: { a: ['Angular acceleration', 'angular_acceleration', 'rads2', 10.472], dw: ['Change in angular velocity', 'angular_speed', 'rpm', 1000], t: ['Time', 'time', 's', 10] }, out: 'a', exp: { dw: 1, t: -1 }, eq: 'α = Δω ÷ t', forms: { a: 'α = Δω ÷ t', dw: 'Δω = α t', t: 't = Δω ÷ α' }, rows: { turns: 'Turns made while speeding up from rest' }, extra: (v) => ({ turns: num((0.5 * v.a * v.t * v.t) / (2 * Math.PI)) }) }),
    ang_disp: {
        type: 'law',
        vars: { th: ['Angular displacement', 'angle', 'rad', 31.4159], w0: ['Initial angular velocity', 'angular_speed', 'rads', 1], a: ['Angular acceleration', 'angular_acceleration', 'rads2', 0.428], t: ['Time', 'time', 's', 10] },
        default: 'th',
        eq: 'θ = ω₀t + ½αt²',
        forms: { th: 'θ = ω₀t + ½αt²', w0: 'ω₀ = (θ − ½αt²) ÷ t', a: 'α = 2(θ − ω₀t) ÷ t²', t: 't = (−ω₀ + √(ω₀² + 2αθ)) ÷ α' },
        solve: { th: (v) => v.w0 * v.t + 0.5 * v.a * v.t * v.t, w0: (v) => (v.th - 0.5 * v.a * v.t * v.t) / v.t, a: (v) => (2 * (v.th - v.w0 * v.t)) / (v.t * v.t), t: (v) => (v.a === 0 ? v.th / v.w0 : (-v.w0 + Math.sqrt(v.w0 * v.w0 + 2 * v.a * v.th)) / v.a) },
        rows: { turns: 'Revolutions', w: ['Final angular velocity', 'angular_speed'] },
        extra: (v) => ({ turns: num(v.th / (2 * Math.PI)), w: [v.w0 + v.a * v.t, 'angular_speed'] }),
    },
    ang_freq: pw({ vars: { w: ['Angular frequency ω', 'angular_speed', 'rads', 314.159], f: ['Frequency f', 'frequency_hz', 'hz', 50] }, out: 'w', k: 2 * Math.PI, exp: { f: 1 }, eq: 'ω = 2π f', forms: { w: 'ω = 2πf', f: 'f = ω ÷ 2π' }, rows: { T: ['Period', 'short_time'] }, extra: (v) => ({ T: [1 / v.f, 'short_time'] }) }),
    ang_momentum: pw({ vars: { L: ['Angular momentum', 'angular_momentum', 'kgm2s', 6.2832], I: ['Moment of inertia', 'moment_of_inertia', 'kgm2', 2], w: ['Angular velocity', 'angular_speed', 'rpm', 30] }, out: 'L', exp: { I: 1, w: 1 }, eq: 'L = I ω', forms: { L: 'L = Iω', I: 'I = L ÷ ω', w: 'ω = L ÷ I' }, rows: { ke: ['Rotational kinetic energy', 'energy'] }, extra: (v) => ({ ke: [0.5 * v.I * v.w * v.w, 'energy'] }) }),
    ang_velocity: pw({ vars: { w: ['Angular velocity', 'angular_speed', 'rads', 3.14159], th: ['Angle turned', 'angle', 'deg', 360], t: ['Time', 'time', 's', 2] }, out: 'w', exp: { th: 1, t: -1 }, eq: 'ω = θ ÷ t', forms: { w: 'ω = θ ÷ t', th: 'θ = ω t', t: 't = θ ÷ ω' }, rows: { rpm: 'In rpm', speed: 'Rim speed at 1 m radius' }, extra: (v) => ({ rpm: `${num((v.w * 60) / (2 * Math.PI))} rpm`, speed: `${num(v.w)} m/s` }) }),
    centrifugal: pw({ vars: { F: ['Centrifugal force', 'force', 'n', 1096.6], m: ['Mass', 'mass', 'kg', 1], w: ['Angular velocity', 'angular_speed', 'rpm', 1000], r: ['Radius', 'length', 'cm', 10] }, out: 'F', exp: { m: 1, w: 2, r: 1 }, eq: 'F = m ω² r', forms: { F: 'F = mω²r', m: 'm = F ÷ ω²r', w: 'ω = √(F ÷ mr)', r: 'r = F ÷ mω²' }, rows: { g: 'In g', v: ['Rim speed', 'speed'] }, extra: (v) => ({ g: `${num((v.w * v.w * v.r) / g0)} g`, v: [v.w * v.r, 'speed'] }) }),
    centrifuge: pw({ vars: { rcf: ['Relative centrifugal force (× g)', null, null, 11180], w: ['Rotor speed', 'angular_speed', 'rpm', 10000], r: ['Rotor radius', 'length', 'cm', 10] }, out: 'rcf', k: 1 / g0, exp: { w: 2, r: 1 }, eq: 'RCF = ω² r ÷ g', forms: { rcf: 'RCF = ω²r ÷ g = 1.118 × 10⁻⁵ r(cm) rpm²', w: 'ω = √(RCF g ÷ r)', r: 'r = RCF g ÷ ω²' } }),
    centripetal: pw({ vars: { F: ['Centripetal force', 'force', 'n', 1000], m: ['Mass', 'mass', 'kg', 1000], v: ['Speed', 'speed', 'kmh', 36], r: ['Radius', 'length', 'm', 100] }, out: 'F', exp: { m: 1, v: 2, r: -1 }, eq: 'F = m v² ÷ r', forms: { F: 'F = mv² ÷ r', m: 'm = Fr ÷ v²', v: 'v = √(Fr ÷ m)', r: 'r = mv² ÷ F' }, rows: { a: 'Centripetal acceleration', T: ['Time for one lap', 'time'] }, extra: (v) => ({ a: `${num((v.v * v.v) / v.r)} m/s² (${num((v.v * v.v) / v.r / g0)} g)`, T: [(2 * Math.PI * v.r) / v.v, 'time'] }) }),
    circular: {
        type: 'calc',
        inputs: { r: ['Radius', 'length', 'm', 2], known: ['I know', 'select', { v: 'The speed', T: 'The period', n: 'The rotation rate' }, 'n'], v: ['Speed', 'speed', 'ms', 5], T: ['Period', 'time', 's', 2], n: ['Rotation rate', 'angular_speed', 'rpm', 30] },
        show: { v: 'known:v', T: 'known:T', n: 'known:n' },
        when: { v: (x) => x.known === 'v', T: (x) => x.known === 'T', n: (x) => x.known === 'n' },
        out: 'speed',
        outUnit: 'ms',
        label: 'Speed',
        rows: { w: ['Angular velocity', 'angular_speed'], T: ['Period', 'time'], f: 'Frequency', a: ['Centripetal acceleration', 'acceleration'] },
        run: (x) => {
            const w = x.known === 'v' ? x.v / x.r : x.known === 'T' ? (2 * Math.PI) / x.T : x.n;
            const v = w * x.r;

            return { value: v, sub: `${num(w)} rad/s, ${num((v * v) / x.r)} m/s²`, rows: { w: [w, 'angular_speed'], T: [(2 * Math.PI) / w, 'time'], f: `${num(w / (2 * Math.PI))} Hz`, a: [(v * v) / x.r, 'acceleration'] }, steps: ['v = ωr, T = 2π ÷ ω, a = v² ÷ r', `ω = ${num(w)} rad/s, v = ${num(v)} m/s`] };
        },
    },
    coriolis: {
        type: 'calc',
        inputs: { v: ['Speed', 'speed', 'ms', 800], lat: ['Latitude', 'angle', 'deg', 45], d: ['Distance travelled', 'length', 'km', 1] },
        out: 'acceleration',
        outUnit: 'ms2',
        label: 'Coriolis acceleration',
        rows: { defl: ['Sideways deflection over that distance', 'length'], dir: 'Direction' },
        run: (x) => {
            const a = 2 * OMEGA_EARTH * x.v * Math.sin(x.lat);
            const t = x.d / x.v;

            return { value: a, sub: `Deflection ${num(0.5 * a * t * t)} m over ${num(x.d / 1000)} km`, rows: { defl: [0.5 * a * t * t, 'length'], dir: x.lat >= 0 ? 'To the right in the northern hemisphere' : 'To the left in the southern hemisphere' }, steps: [`a = 2Ωv sin φ, Ω = 7.2921 × 10⁻⁵ rad/s`, `= ${num(a)} m/s² (horizontal motion)`, `Deflection ≈ ½at² with t = d ÷ v = ${num(t)} s: ${num(0.5 * a * t * t)} m`] };
        },
    },
    damping_ratio: {
        type: 'calc',
        inputs: { m: ['Mass', 'mass', 'kg', 1], k: ['Spring constant', 'stiffness', 'npm', 100], c: ['Damping coefficient (N·s/m)', null, null, 4, 0] },
        label: 'Damping ratio ζ',
        rows: { type: 'Behaviour', wn: 'Natural frequency', wd: 'Damped frequency', q: 'Quality factor Q', cc: 'Critical damping coefficient' },
        run: (x) => {
            const cc = 2 * Math.sqrt(x.k * x.m);
            const z = x.c / cc;
            const wn = Math.sqrt(x.k / x.m);

            return { value: num(z, 5), sub: z < 1 ? 'Underdamped: it oscillates as it decays' : z === 1 ? 'Critically damped' : 'Overdamped: no oscillation', rows: { type: z < 1 ? 'Underdamped' : Math.abs(z - 1) < 1e-9 ? 'Critically damped' : 'Overdamped', wn: `${num(wn)} rad/s (${num(wn / (2 * Math.PI))} Hz)`, wd: z < 1 ? `${num(wn * Math.sqrt(1 - z * z))} rad/s` : 'None (no oscillation)', q: z > 0 ? num(1 / (2 * z)) : '∞', cc: `${num(cc)} N·s/m` }, steps: ['c_c = 2√(km)', `= ${num(cc)} N·s/m`, `ζ = c ÷ c_c = ${num(z)}`] };
        },
    },
    flywheel: {
        type: 'calc',
        inputs: { shape: ['Flywheel', 'select', { disc: 'Solid disc', rim: 'Thin rim (ring)', thick: 'Thick ring' }, 'disc'], m: ['Mass', 'mass', 'kg', 100], r: ['Outer radius', 'length', 'm', 0.5], ri: ['Inner radius', 'length', 'm', 0.3], w: ['Speed', 'angular_speed', 'rpm', 3000] },
        show: { ri: 'shape:thick' },
        when: { ri: (x) => x.shape === 'thick' },
        out: 'energy',
        outUnit: 'kj',
        label: 'Stored energy',
        rows: { kwh: 'In kWh', I: ['Moment of inertia', 'moment_of_inertia'], rim: ['Rim speed', 'speed'], density: 'Energy per kilogram' },
        run: (x) => {
            const I = x.shape === 'disc' ? 0.5 * x.m * x.r * x.r : x.shape === 'rim' ? x.m * x.r * x.r : 0.5 * x.m * (x.r * x.r + x.ri * x.ri);
            const E = 0.5 * I * x.w * x.w;

            return { value: E, sub: `${num(E / 3.6e6)} kWh`, rows: { kwh: `${num(E / 3.6e6)} kWh`, I: [I, 'moment_of_inertia'], rim: [x.w * x.r, 'speed'], density: `${num(E / x.m / 1000)} kJ/kg (rim speed limits this: steel ≈ 50 kJ/kg)` }, steps: ['E = ½Iω²', `I = ${num(I)} kg·m², ω = ${num(x.w)} rad/s`, `E = ${num(E)} J`] };
        },
    },
    frequency: pw({ vars: { f: ['Frequency', 'frequency_hz', 'hz', 50], T: ['Period', 'short_time', 'ms', 20] }, out: 'f', exp: { T: -1 }, eq: 'f = 1 ÷ T', forms: { f: 'f = 1 ÷ T', T: 'T = 1 ÷ f' }, rows: { w: ['Angular frequency', 'angular_speed'], lambda: ['Wavelength of sound at this frequency (343 m/s)', 'length'] }, extra: (v) => ({ w: [2 * Math.PI * v.f, 'angular_speed'], lambda: [343 / v.f, 'length'] }) }),
    harmonic_wave: {
        type: 'calc',
        inputs: { A: ['Amplitude', 'length', 'cm', 5], lambda: ['Wavelength', 'length', 'm', 2], f: ['Frequency', 'frequency_hz', 'hz', 3], phi: ['Phase', 'angle', 'deg', 0], x: ['Position x', 'length', 'm', 0.5], t: ['Time t', 'time', 's', 0.1] },
        out: 'length',
        outUnit: 'cm',
        label: 'Displacement y(x, t)',
        rows: { v: ['Wave speed', 'speed'], k: 'Wave number', w: 'Angular frequency', vy: ['Particle velocity at that point', 'speed'] },
        plots: [['wave', 'Wave at time t']],
        run: (x) => {
            const k = (2 * Math.PI) / x.lambda;
            const w = 2 * Math.PI * x.f;
            const y = x.A * Math.sin(k * x.x - w * x.t + x.phi);
            const series = Array.from({ length: 121 }, (_, n) => {
                const xx = (2 * x.lambda * n) / 120;

                return [xx, x.A * Math.sin(k * xx - w * x.t + x.phi) * 100];
            });

            return { value: y, sub: `Wave speed ${num(x.lambda * x.f)} m/s`, rows: { v: [x.lambda * x.f, 'speed'], k: `${num(k)} rad/m`, w: `${num(w)} rad/s`, vy: [-x.A * w * Math.cos(k * x.x - w * x.t + x.phi), 'speed'] }, steps: ['y = A sin(kx − ωt + φ)', `k = 2π ÷ λ = ${num(k)} rad/m, ω = 2πf = ${num(w)} rad/s`, `y = ${num(y * 100)} cm`], plots: { wave: { series, axes: true, xLabel: 'x (m)', yLabel: 'y (cm)' } } };
        },
    },
    pendulum_ke: {
        type: 'calc',
        inputs: { m: ['Bob mass', 'mass', 'kg', 1], L: ['Length', 'length', 'm', 1], a0: ['Release angle', 'angle', 'deg', 30], a: ['Current angle', 'angle', 'deg', 0] },
        out: 'energy',
        outUnit: 'j',
        label: 'Kinetic energy',
        rows: { v: ['Speed', 'speed'], vmax: ['Maximum speed (at the bottom)', 'speed'], pe: ['Potential energy above the lowest point', 'energy'] },
        run: (x) => {
            if (Math.abs(x.a) > Math.abs(x.a0)) {
                return { error: 'The pendulum never swings past its release angle.' };
            }

            const ke = x.m * g0 * x.L * (Math.cos(x.a) - Math.cos(x.a0));

            return { value: ke, sub: `Speed ${num(Math.sqrt((2 * ke) / x.m))} m/s`, rows: { v: [Math.sqrt((2 * ke) / x.m), 'speed'], vmax: [Math.sqrt(2 * g0 * x.L * (1 - Math.cos(x.a0))), 'speed'], pe: [x.m * g0 * x.L * (1 - Math.cos(x.a)), 'energy'] }, steps: ['KE = mgL(cos θ − cos θ₀)', `= ${num(ke)} J`] };
        },
    },
    mass_moi: {
        type: 'calc',
        inputs: { shape: ['Shape and axis', 'select', Object.fromEntries(Object.entries(MOI).map(([k, s]) => [k, s[0]])), 'disc'], m: ['Mass', 'mass', 'kg', 10], r: ['Radius (outer)', 'length', 'cm', 20], ri: ['Inner radius', 'length', 'cm', 15], L: ['Length', 'length', 'cm', 100], w: ['Width', 'length', 'cm', 50], d: ['Shift the axis by (parallel axis)', 'length', 'cm', 0] },
        show: { r: 'shape:disc,ring,tube,sphere,shell,cyl_d,cone', ri: 'shape:tube', L: 'shape:rod_c,rod_e,cyl_d,plate', w: 'shape:plate' },
        when: { r: (x) => ['disc', 'ring', 'tube', 'sphere', 'shell', 'cyl_d', 'cone'].includes(x.shape), ri: (x) => x.shape === 'tube', L: (x) => ['rod_c', 'rod_e', 'cyl_d', 'plate'].includes(x.shape), w: (x) => x.shape === 'plate' },
        optional: ['d'],
        out: 'moment_of_inertia',
        outUnit: 'kgm2',
        label: 'Mass moment of inertia',
        rows: { k: ['Radius of gyration', 'length'], shifted: ['About the shifted axis', 'moment_of_inertia'] },
        run: (x) => {
            const I = MOI[x.shape][1](x);
            const d = Number.isFinite(x.d) ? x.d : 0;

            return { value: I, sub: MOI[x.shape][0], rows: { k: [Math.sqrt(I / x.m), 'length'], shifted: [I + x.m * d * d, 'moment_of_inertia'] }, steps: [`${MOI[x.shape][0]}: I = ${num(I)} kg·m²`, `Parallel axis: I = I_cm + md² = ${num(I + x.m * d * d)} kg·m²`] };
        },
    },
    physical_pendulum: pw({ vars: { T: ['Period', 'time', 's', 1.6], I: ['Moment of inertia about the pivot', 'moment_of_inertia', 'kgm2', 0.333], m: ['Mass', 'mass', 'kg', 1], d: ['Pivot to centre of mass', 'length', 'm', 0.5], g: ['Gravity', 'acceleration', 'ms2', 9.80665] }, out: 'T', k: 2 * Math.PI, exp: { I: 0.5, m: -0.5, d: -0.5, g: -0.5 }, eq: 'T = 2π √(I ÷ m g d)', forms: { T: 'T = 2π√(I ÷ mgd)', I: 'I = mgd(T ÷ 2π)²', m: 'm = I ÷ gd(T ÷ 2π)²', d: 'd = I ÷ mg(T ÷ 2π)²', g: 'g = I ÷ md(T ÷ 2π)²' }, rows: { Leq: ['Equivalent simple pendulum length', 'length'] }, extra: (v) => ({ Leq: [v.I / (v.m * v.d), 'length'] }) }),
    rot_ke: pw({ vars: { E: ['Rotational kinetic energy', 'energy', 'j', 1096.6], I: ['Moment of inertia', 'moment_of_inertia', 'kgm2', 0.2], w: ['Angular velocity', 'angular_speed', 'rpm', 1000] }, out: 'E', k: 0.5, exp: { I: 1, w: 2 }, eq: 'E = ½ I ω²', forms: { E: 'E = ½Iω²', I: 'I = 2E ÷ ω²', w: 'ω = √(2E ÷ I)' }, rows: { L: ['Angular momentum', 'angular_momentum'] }, extra: (v) => ({ L: [v.I * v.w, 'angular_momentum'] }) }),
    rot_stiffness: pw({ vars: { k: ['Rotational stiffness', 'rotational_stiffness', 'nmrad', 5729.6], M: ['Torque (moment)', 'torque', 'nm', 100], th: ['Rotation', 'angle', 'deg', 1] }, out: 'k', exp: { M: 1, th: -1 }, eq: 'k = M ÷ θ', forms: { k: 'k = M ÷ θ', M: 'M = kθ', th: 'θ = M ÷ k' } }),
    shm: {
        type: 'calc',
        inputs: { A: ['Amplitude', 'length', 'cm', 10], f: ['Frequency', 'frequency_hz', 'hz', 2], phi: ['Phase', 'angle', 'deg', 0], t: ['Time', 'time', 's', 0.1] },
        out: 'length',
        outUnit: 'cm',
        label: 'Position x(t)',
        rows: { v: ['Velocity', 'speed'], a: ['Acceleration', 'acceleration'], vmax: ['Maximum speed', 'speed'], amax: ['Maximum acceleration', 'acceleration'], T: ['Period', 'time'] },
        plots: [['motion', 'Position over two periods']],
        run: (x) => {
            const w = 2 * Math.PI * x.f;
            const arg = w * x.t + x.phi;
            const series = Array.from({ length: 121 }, (_, n) => {
                const tt = (2 * n) / (120 * x.f);

                return [tt, x.A * Math.cos(w * tt + x.phi) * 100];
            });

            return { value: x.A * Math.cos(arg), sub: `v = ${num(-x.A * w * Math.sin(arg))} m/s`, rows: { v: [-x.A * w * Math.sin(arg), 'speed'], a: [-x.A * w * w * Math.cos(arg), 'acceleration'], vmax: [x.A * w, 'speed'], amax: [x.A * w * w, 'acceleration'], T: [1 / x.f, 'time'] }, steps: ['x = A cos(ωt + φ), v = −Aω sin(ωt + φ), a = −ω²x', `ω = 2πf = ${num(w)} rad/s`], plots: { motion: { series, axes: true, xLabel: 'Time (s)', yLabel: 'x (cm)' } } };
        },
    },
    simple_pendulum: {
        type: 'calc',
        inputs: { L: ['Length', 'length', 'm', 1], g: ['Gravity', 'acceleration', 'ms2', 9.80665], a0: ['Amplitude (release angle)', 'angle', 'deg', 10] },
        out: 'time',
        outUnit: 's',
        label: 'Period',
        rows: { small: ['Small-angle period 2π√(L/g)', 'time'], f: 'Frequency', error: 'Error of the small-angle formula', second: ['Length for a 2 s period (seconds pendulum)', 'length'] },
        run: (x) => {
            const T0 = 2 * Math.PI * Math.sqrt(x.L / x.g);
            const T = 4 * Math.sqrt(x.L / x.g) * ellipticK(Math.sin(x.a0 / 2) ** 2);

            return { value: T, sub: `Small-angle formula gives ${num(T0)} s`, rows: { small: [T0, 'time'], f: `${num(1 / T)} Hz`, error: `${num(((T - T0) / T) * 100, 3)}%`, second: [x.g / Math.PI ** 2, 'length'] }, steps: ['Exact period T = 4√(L/g) K(sin²(θ₀/2)), K = complete elliptic integral', `T = ${num(T)} s; small-angle 2π√(L/g) = ${num(T0)} s`] };
        },
    },
    torque: {
        type: 'law',
        vars: { tau: ['Torque', 'torque', 'nm', 50], r: ['Lever arm', 'length', 'cm', 50], F: ['Force', 'force', 'n', 100], theta: ['Angle between arm and force', 'angle', 'deg', 90] },
        default: 'tau',
        eq: 'τ = r F sin θ',
        forms: { tau: 'τ = rF sin θ', r: 'r = τ ÷ (F sin θ)', F: 'F = τ ÷ (r sin θ)', theta: 'θ = asin(τ ÷ rF)' },
        solve: { tau: (v) => v.r * v.F * Math.sin(v.theta), r: (v) => v.tau / (v.F * Math.sin(v.theta)), F: (v) => v.tau / (v.r * Math.sin(v.theta)), theta: (v) => Math.asin(v.tau / (v.r * v.F)) },
        rows: { power: 'Power at 1,000 rpm' },
        extra: (v) => ({ power: `${num((v.tau * 1000 * 2 * Math.PI) / 60 / 1000)} kW` }),
    },
    wavelength: pw({ vars: { lambda: ['Wavelength', 'length', 'm', 0.686], v: ['Wave speed', 'speed', 'ms', 343], f: ['Frequency', 'frequency_hz', 'hz', 500] }, out: 'lambda', exp: { v: 1, f: -1 }, eq: 'λ = v ÷ f', forms: { lambda: 'λ = v ÷ f', v: 'v = λf', f: 'f = v ÷ λ' }, rows: { T: ['Period', 'short_time'] }, extra: (v) => ({ T: [1 / v.f, 'short_time'] }) }),
    conical_pendulum: {
        type: 'calc',
        inputs: { L: ['String length', 'length', 'm', 1], angle: ['Angle from vertical', 'angle', 'deg', 30], m: ['Bob mass', 'mass', 'kg', 0.5], g: ['Gravity', 'acceleration', 'ms2', 9.80665] },
        out: 'time',
        outUnit: 's',
        label: 'Period',
        rows: { v: ['Speed', 'speed'], r: ['Circle radius', 'length'], T: ['String tension', 'force'] },
        run: (x) => {
            const T = 2 * Math.PI * Math.sqrt((x.L * Math.cos(x.angle)) / x.g);
            const r = x.L * Math.sin(x.angle);

            return { value: T, sub: `Speed ${num((2 * Math.PI * r) / T)} m/s`, rows: { v: [(2 * Math.PI * r) / T, 'speed'], r: [r, 'length'], T: [(x.m * x.g) / Math.cos(x.angle), 'force'] }, steps: ['T = 2π√(L cos θ ÷ g)', `= ${num(T)} s`, `Tension = mg ÷ cos θ = ${num((x.m * x.g) / Math.cos(x.angle))} N`] };
        },
    },
    rolling_incline: {
        type: 'calc',
        inputs: { shape: ['Object', 'select', Object.fromEntries(Object.entries(ROLL_K).map(([k, r]) => [k, r[0]])), 'sphere'], angle: ['Slope angle', 'angle', 'deg', 15], L: ['Slope length', 'length', 'm', 5] },
        out: 'speed',
        outUnit: 'ms',
        label: 'Speed at the bottom',
        rows: { a: ['Acceleration', 'acceleration'], t: ['Time to roll down', 'time'], race: 'Order in a race (fastest first)' },
        run: (x) => {
            const k = ROLL_K[x.shape][1];
            const a = (g0 * Math.sin(x.angle)) / (1 + k);
            const order = Object.values(ROLL_K).sort((p, q) => p[1] - q[1]).map((p) => p[0]).join(' → ');

            return { value: Math.sqrt(2 * a * x.L), sub: `a = g sin θ ÷ (1 + I/mr²) with I/mr² = ${num(k, 4)}`, rows: { a: [a, 'acceleration'], t: [Math.sqrt((2 * x.L) / a), 'time'], race: order }, steps: ['a = g sin θ ÷ (1 + I/mr²)', `= ${num(a)} m/s²`, `v = √(2aL) = ${num(Math.sqrt(2 * a * x.L))} m/s, independent of mass and radius`] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
