import { fromBase, toBase } from '../engines/units.js';
import { fmt } from '../math/rational.js';
import { physicsPractice } from './practice.js';

/**
 * Shared engine of the Physics section.
 *
 * A tool is a definition in one of the `tools/ph-*.js` tables:
 *   law:  { type: 'law', vars: { name: [label, family, unit, value] }, solve: { name: (v) => SI value },
 *           forms: { name: 'rearranged formula' }, eq, rows?: { key: label | [label, family] }, extra?: (v) => rows, check?: (v) => message }
 *         The page picks which quantity to solve for; every other value is read in its own unit.
 *   calc: { type: 'calc', inputs: { name: [label, family, unit, value] | [label, 'select', options, default] | [label, null, null, value] },
 *           out: family, outUnit, label, rows: { key: label | [label, family] }, run: (v, ctx) => outcome }
 *
 * Inputs arrive from the page in the unit table's base unit (config/units.php). Physics works in SI, so
 * the three tables whose base is not SI are adjusted here: mass (g → kg), volume (L → m³) and
 * temperature (°C → K). Results are shown in the unit picked for them, with SI and common alternatives in the rows.
 */

/** CODATA 2018 recommended values; c, h, e, k and Nₐ are exact by the 2019 SI definitions. */
export const K = {
    c: 299792458,
    h: 6.62607015e-34,
    hbar: 6.62607015e-34 / (2 * Math.PI),
    e: 1.602176634e-19,
    k: 1.380649e-23,
    NA: 6.02214076e23,
    R: 6.02214076e23 * 1.380649e-23,
    G: 6.6743e-11,
    g0: 9.80665,
    me: 9.1093837015e-31,
    mp: 1.67262192369e-27,
    mn: 1.67492749804e-27,
    u: 1.6605390666e-27,
    eps0: 8.8541878128e-12,
    mu0: 1.25663706212e-6,
    sigma: 5.670374419e-8,
    wien: 2.897771955e-3,
    a0: 5.29177210903e-11,
    Rinf: 10973731.56816,
    alpha: 7.2973525693e-3,
    muB: 9.2740100783e-24,
    atm: 101325,
    au: 149597870700,
    ly: 299792458 * 365.25 * 86400,
    pc: (648000 / Math.PI) * 149597870700,
    Msun: 1.98847e30,
    Rsun: 6.957e8,
    Lsun: 3.828e26,
    Mearth: 5.9722e24,
    Rearth: 6.371e6,
    GMearth: 3.986004418e14,
    GMsun: 1.32712440018e20,
};

const SI_FIX = {
    mass: [1e-3, 0],
    volume: [1e-3, 0],
    temperature: [1, 273.15],
};

/** Base value from the page → SI. */
export function toSI(family, base) {
    const fix = SI_FIX[FAMILY_TABLE[family] ?? family];

    return fix ? base * fix[0] + fix[1] : base;
}

/** SI value → the unit table's base. */
export function fromSI(family, si) {
    const fix = SI_FIX[FAMILY_TABLE[family] ?? family];

    return fix ? (si - fix[1]) / fix[0] : si;
}

/**
 * Page families map to unit tables in config/units.php ("p_length" uses the length table with a physics
 * choice of units). Filled from the generator's table so the two never disagree.
 */
export const FAMILY_TABLE = {};

/** Preferred display units for rows: [SI-ish, imperial or common alternative]. */
const PREF = {
    length: ['m', 'ft'], mass: ['kg', 'lb'], time: ['s'], speed: ['ms', 'mph'], acceleration: ['ms2', 'g0'], force: ['n', 'lbf'], energy: ['j', 'kwh'],
    power: ['w', 'hp'], pressure: ['pa', 'psi'], torque: ['nm', 'lbfft'], area: ['m2', 'ft2'], volume: ['m3', 'gal_us'], density: ['kgm3', 'lbft3'],
    temperature: ['c', 'f'], temperature_difference: ['k', 'f'], momentum: ['kgms'], angular_momentum: ['kgm2s'], angular_speed: ['rads', 'rpm'],
    angular_acceleration: ['rads2'], stiffness: ['npm', 'lbfpin'], rotational_stiffness: ['nmrad'], current: ['a'], voltage: ['v'], resistance: ['ohm'],
    inductance: ['h'], capacitance: ['f'], charge: ['c'], magnetic_field: ['t', 'gauss'], electric_field: ['vpm'], flow: ['m3s', 'gpm'], mass_flow: ['kgs', 'lbmin'],
    viscosity: ['pas', 'cp'], kinematic_viscosity: ['m2s', 'cst'], moment_of_inertia: ['kgm2', 'lbft2'], area_moment: ['m4', 'in4'], illuminance: ['lx', 'fc'],
    thermal_conductivity: ['wmk'], specific_heat: ['jkgk'], heat_transfer_coefficient: ['wm2k'], intensity: ['wm2'], resistivity: ['ohmm'],
    frequency_hz: ['hz'], particle_mass: ['kg', 'u'], particle_energy: ['j', 'ev'], short_time: ['s'], angle: ['deg', 'rad'], astronomical: ['km', 'ly'], astro_mass: ['kg', 'msun'],
};

/** Number text: 6 significant figures by default, × 10ⁿ outside 10⁻⁶…10¹⁵. */
export const num = (x, sig = 6) => fmt(Math.abs(x) < 1e-300 ? 0 : x, sig);

function unitOf(c, family, key) {
    const table = c.data?.units?.[FAMILY_TABLE[family] ?? family];

    return table?.[key] ?? null;
}

/** "9.80665 N" for an SI value shown in the given unit key of the family. */
export function inUnit(c, family, si, key, sig = 6) {
    const unit = unitOf(c, family, key);

    if (!unit) {
        return num(si, sig);
    }

    return `${num(fromBase(fromSI(family, si), unit), sig)} ${unit.symbol}`;
}

/** Metric steps tried (smallest first) so rows read "47.1 MPa" rather than "47,082,000 Pa". */
const SCALED = {
    pressure: ['pa', 'kpa', 'mpa', 'gpa'], length: ['nm', 'um', 'mm', 'm', 'km'], energy: ['j', 'kj', 'mj', 'gj'], power: ['milliwatt', 'w', 'kw', 'mw', 'gw'],
    force: ['millinewton', 'n', 'kn', 'meganewton'], frequency_hz: ['hz', 'khz', 'mhz', 'ghz', 'thz'], short_time: ['ns', 'us', 'ms', 's'],
    voltage: ['uv', 'mv', 'v', 'kv', 'megav'], current: ['na', 'ua', 'ma', 'a', 'ka'], resistance: ['mohm', 'ohm', 'kohm', 'megohm', 'gohm'], capacitance: ['af', 'ff', 'pf', 'nf', 'uf', 'mf', 'f'],
    inductance: ['nh', 'uh', 'mh', 'h'], charge: ['nc', 'uc', 'mc', 'c'], magnetic_field: ['nt', 'ut', 'mt', 't'], electric_field: ['vpm', 'kvpm', 'mvpm'],
};
const SCALED_ALT = { pressure: ['psi', 'ksi'], force: ['lbf', 'kip'], length: ['in', 'ft', 'mi'], astronomical: ['au', 'ly', 'pc', 'mpc'], astro_mass: ['mmoon', 'mearth', 'mjup', 'msun'] };

/** The largest metric step of the family in which |si| is at least 1 (or the first step). */
function scaledKey(c, family, si, steps = SCALED) {
    const table = FAMILY_TABLE[family] ?? family;
    const keys = (steps[table] ?? []).filter((k) => unitOf(c, family, k));

    if (!keys.length || !Number.isFinite(si) || si === 0) {
        return keys[keys.indexOf(PREF[table]?.[0])] ?? null;
    }

    let pick = keys[0];

    for (const key of keys) {
        if (Math.abs(fromBase(fromSI(family, si), unitOf(c, family, key))) >= 1) {
            pick = key;
        }
    }

    return pick;
}

/** An SI value in its family's preferred unit, with the common alternative in brackets. */
export function show(c, family, si, sig = 6) {
    if (!family) {
        return num(si, sig);
    }

    const [preferred, second] = PREF[FAMILY_TABLE[family] ?? family] ?? [];
    const first = scaledKey(c, family, si) ?? preferred;
    const a = first ? inUnit(c, family, si, first, sig) : num(si, sig);

    const alt = second ? (SCALED_ALT[FAMILY_TABLE[family] ?? family] ? scaledKey(c, family, si, SCALED_ALT) : second) : null;

    return alt && unitOf(c, family, alt) ? `${a} (${inUnit(c, family, si, alt, sig)})` : a;
}

/** Field kinds read as text rather than numbers. */
const STRING_FIELDS = ['select', 'text', 'textarea', 'date', 'clock'];

const valid = (x) => typeof x === 'number' && Number.isFinite(x);

/** Reads a definition's inputs into SI (selects and text as they are). */
function readValues(spec, i) {
    const v = {};

    for (const [name, field] of Object.entries(spec)) {
        const [, family] = field;

        if (STRING_FIELDS.includes(family)) {
            v[name] = i[name] ?? field[3];
        } else if (family) {
            v[name] = valid(i[name]) ? toSI(family, i[name]) : NaN;
        } else {
            v[name] = typeof i[name] === 'number' ? i[name] : Number(i[name]);
        }
    }

    return v;
}

/** Solve-for-any law. */
export function runLaw(def, i, c) {
    const names = Object.keys(def.vars);
    const unknown = c.solve ?? (names.includes(i.solve) ? i.solve : def.default ?? names[0]);
    const v = readValues(def.vars, i);
    const known = names.filter((n) => n !== unknown && !(def.optional ?? []).includes(n));
    const missing = known.filter((n) => !valid(v[n]));

    if (missing.length) {
        return { empty: `Enter ${missing.map((n) => def.vars[n][0].toLowerCase()).join(', ')}.` };
    }

    const problem = def.check?.(v, unknown);

    if (problem) {
        return { error: problem };
    }

    const x = def.solve[unknown](v);

    if (!valid(x)) {
        return { error: def.noSolution ?? 'These values have no physical solution. Check them and their units.' };
    }

    v[unknown] = x;
    const [label, family] = def.vars[unknown];
    const outKey = i[`out_${unknown}`] ?? def.vars[unknown][2];
    const outUnit = family ? unitOf(c, family, outKey) : null;
    const value = outUnit ? fromBase(fromSI(family, x), outUnit) : x;
    const given = known.map((n) => `${def.vars[n][0]} = ${def.vars[n][1] ? show(c, def.vars[n][1], v[n]) : num(v[n])}`);
    const extra = def.extra?.(v, c) ?? {};
    const rows = {
        formula: def.forms?.[unknown] ?? def.eq,
        si: family ? show(c, family, x, 8) : num(x, 8),
        ...Object.fromEntries(Object.entries(extra).map(([k, r]) => [k, rowText(c, r)])),
    };

    return {
        value: num(value, 6),
        unit: outUnit?.symbol ?? '',
        label,
        sub: def.sub?.(v, c) ?? (def.forms?.[unknown] ?? def.eq),
        rows,
        texts: { steps: [`Given: ${given.join(', ')}`, def.eq, ...(def.forms?.[unknown] && def.forms[unknown] !== def.eq ? [def.forms[unknown]] : []), `${label} = ${family ? show(c, family, x, 8) : num(x, 8)}`, ...(def.steps?.(v, c) ?? [])].join('\n') },
        ...(def.plot ? { plots: def.plot(v, c) } : {}),
    };
}

/** A row value: text, or [SI number, family]. */
function rowText(c, r) {
    if (Array.isArray(r)) {
        return show(c, r[1], r[0], r[2] ?? 6);
    }

    return typeof r === 'number' ? num(r) : r;
}

/** Formula tool. */
export function runCalc(def, i, c) {
    const v = readValues(def.inputs, i);
    const required = Object.entries(def.inputs).filter(([name, f]) => !STRING_FIELDS.includes(f[1]) && !(def.optional ?? []).includes(name) && !(def.when && def.when[name] && !def.when[name](v)));
    const missing = required.filter(([name]) => !valid(v[name]));

    if (missing.length) {
        return { empty: `Enter ${missing.map(([, f]) => f[0].toLowerCase()).join(', ')}.` };
    }

    const out = def.run(v, { c, show: (family, si, sig) => show(c, family, si, sig), num });

    if (!out || out.empty || out.error) {
        return out ?? { empty: 'Enter the values.' };
    }

    let value = out.value;
    let unit = out.unit ?? '';

    if (typeof value === 'number') {
        if (!valid(value)) {
            return { error: def.noSolution ?? 'These values have no physical solution. Check them and their units.' };
        }

        const family = out.family ?? def.out;
        const key = i.out ?? def.outUnit;
        const u = family ? unitOf(c, family, key) : null;

        if (u) {
            unit = u.symbol;
            value = num(fromBase(fromSI(family, value), u), out.sig ?? 6);
        } else {
            value = num(value, out.sig ?? 6);
        }
    }

    const rows = Object.fromEntries(Object.entries(out.rows ?? {}).map(([k, r]) => [k, rowText(c, r)]));

    return { value, unit, label: out.label ?? def.label, sub: out.sub ?? '', rows, texts: { steps: (out.steps ?? []).join('\n') }, ...(out.plots ? { plots: out.plots } : {}), ...(out.grids ? { grids: out.grids } : {}) };
}

/**
 * A power law out = k × Π varᵢ^pᵢ, solvable for any quantity: x_j = (out ÷ (k Π others))^(1/p_j).
 * spec: { vars, out, k, exp: { name: power }, eq, forms?, rows?, extra?, check?, sub? }
 */
export function pw(spec) {
    const k = spec.k ?? 1;
    const names = Object.keys(spec.vars);
    const others = names.filter((n) => n !== spec.out);
    const prod = (v, skip) => others.filter((n) => n !== skip).reduce((acc, n) => acc * v[n] ** spec.exp[n], k);
    const solve = { [spec.out]: (v) => prod(v, null) };
    others.forEach((n) => {
        solve[n] = (v) => (v[spec.out] / prod(v, n)) ** (1 / spec.exp[n]);
    });

    return { type: 'law', default: spec.out, ...spec, solve: { ...solve, ...(spec.solve ?? {}) } };
}

/** Handlers for a table of definitions: one handler per tool key. */
export function handlersFor(table) {
    return Object.fromEntries(Object.entries(table).map(([key, def]) => [key, (i, c) => {
        if (c.practice && i.mode === 'practice') {
            return physicsPractice(c.practice, i);
        }

        return def.type === 'law' ? runLaw(def, i, c) : runCalc(def, i, c);
    }]));
}

/** Root of f on [lo, hi] by bisection (f(lo) and f(hi) must differ in sign). */
export function bisect(f, lo, hi, iterations = 200) {
    let a = lo;
    let b = hi;
    let fa = f(a);

    if (fa * f(b) > 0) {
        return NaN;
    }

    for (let k = 0; k < iterations; k += 1) {
        const m = (a + b) / 2;
        const fm = f(m);

        if (fa * fm <= 0) {
            b = m;
        } else {
            a = m;
            fa = fm;
        }
    }

    return (a + b) / 2;
}

/** Positive root of an increasing or decreasing f, searched over 10⁻³⁰…10³⁰ on a log scale. */
export function solvePositive(f) {
    const xs = Array.from({ length: 121 }, (_, k) => 10 ** (-30 + k / 2));

    for (let k = 0; k < xs.length - 1; k += 1) {
        if (f(xs[k]) * f(xs[k + 1]) <= 0) {
            return bisect(f, xs[k], xs[k + 1]);
        }
    }

    return NaN;
}

export const D = Math.PI / 180;
