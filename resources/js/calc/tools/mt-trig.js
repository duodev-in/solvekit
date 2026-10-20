import { defineTools } from '../engines/formula.js';
import { evalReal, parse, ParseError, variables } from '../math/expr.js';
import { practice } from '../math/practice.js';
import { arc } from '../math/shapes.js';
import { f, fail, need, R, result } from '../math/util.js';
import { surd } from './mt-coord.js';

/**
 * Trigonometry: the six functions with exact unit-circle values (multiples of 15°, 18° and 22.5°), inverse
 * functions with principal values, cofunctions, double and half angles, power reduction, sum and difference
 * formulas, identity checking (numerical, at many angles), phase shift, the unit circle and a trig expression evaluator.
 */
const { PI, sin, cos, tan, asin, acos, atan, abs, sqrt } = Math;
const D = PI / 180;

/** Exact first-quadrant values keyed by the reference angle in degrees. */
const SIN = { 0: '0', 15: '(√6 − √2)/4', 18: '(√5 − 1)/4', 22.5: '√(2 − √2)/2', 30: '1/2', 36: '√(10 − 2√5)/4', 45: '√2/2', 54: '(√5 + 1)/4', 60: '√3/2', 67.5: '√(2 + √2)/2', 72: '√(10 + 2√5)/4', 75: '(√6 + √2)/4', 90: '1' };
const TAN = { 0: '0', 15: '2 − √3', 18: '√(25 − 10√5)/5', 22.5: '√2 − 1', 30: '√3/3', 36: '√(5 − 2√5)', 45: '1', 54: '√(25 + 10√5)/5', 60: '√3', 67.5: '√2 + 1', 72: '√(5 + 2√5)', 75: '2 + √3', 90: null };
const CSC = { 0: null, 15: '√6 + √2', 18: '√5 + 1', 22.5: '√(4 + 2√2)', 30: '2', 36: '√(50 + 10√5)/5', 45: '√2', 54: '√5 − 1', 60: '2√3/3', 67.5: '√(4 − 2√2)', 72: '√(50 − 10√5)/5', 75: '√6 − √2', 90: '1' };
const KEYS = Object.keys(SIN).map(Number);
const BASE = { sin: (k) => SIN[k], cos: (k) => SIN[90 - k], tan: (k) => TAN[k], cot: (k) => TAN[90 - k], csc: (k) => CSC[k], sec: (k) => CSC[90 - k] };
const FN = { sin: (x) => sin(x), cos: (x) => cos(x), tan: (x) => tan(x), csc: (x) => 1 / sin(x), sec: (x) => 1 / cos(x), cot: (x) => cos(x) / sin(x) };
const NAMES = ['sin', 'cos', 'tan', 'csc', 'sec', 'cot'];

export const norm360 = (d) => {
    const r = ((d % 360) + 360) % 360;

    return abs(r - 360) < 1e-9 ? 0 : r;
};

const refAngle = (r) => (r <= 90 ? r : r <= 180 ? 180 - r : r <= 270 ? r - 180 : 360 - r);
const keyOf = (ref) => KEYS.find((k) => abs(k - ref) < 1e-9);

/** sin and cos of an angle in degrees, exact zeros on the axes. */
function sc(deg) {
    const r = norm360(deg);
    const s = [0, 180].includes(r) ? 0 : r === 90 ? 1 : r === 270 ? -1 : sin(r * D);
    const c = [90, 270].includes(r) ? 0 : r === 0 ? 1 : r === 180 ? -1 : cos(r * D);

    return [s, c, r];
}

/** Numeric value of a function at an angle in degrees (NaN when undefined). */
export function trigValue(fn, deg) {
    const [s, c] = sc(deg);
    const v = { sin: s, cos: c, tan: c === 0 ? NaN : s / c, cot: s === 0 ? NaN : c / s, csc: s === 0 ? NaN : 1 / s, sec: c === 0 ? NaN : 1 / c }[fn];

    return v;
}

/** Exact text of fn(deg), "undefined", or null when the angle is not in the table. */
export function exactTrig(fn, deg) {
    const value = trigValue(fn, deg);

    if (Number.isNaN(value)) {
        return 'undefined';
    }

    const key = keyOf(refAngle(sc(deg)[2]));

    if (key === undefined) {
        return null;
    }

    const base = BASE[fn](key);

    if (base === null || base === undefined) {
        return null;
    }

    if (abs(value) < 1e-15 || base === '0') {
        return '0';
    }

    if (value > 0) {
        return base;
    }

    return base.includes(' ') && !base.startsWith('(') ? `−(${base})` : `−${base}`;
}

/** Angle from the angle + angle_unit fields, in degrees. */
function readAngle(i, name = 'angle') {
    const x = Number(i[name]);
    const unit = i[`${name}_unit`] ?? 'deg';

    return Number.isFinite(x) ? (unit === 'rad' ? x / D : unit === 'pi' ? x * 180 : x) : NaN;
}

/** "π/6" style text for an angle in degrees, or radians as a decimal. */
export function piText(deg) {
    const q = R.div(R.fromNumber(Number(deg.toPrecision(12))), R.Q(180));

    if (q.d > 720n) {
        return `${f(deg * D, 12)}`;
    }

    if (R.isZero(q)) {
        return '0';
    }

    const top = R.babs(q.n) === 1n ? (q.n < 0n ? '−' : '') : R.fmt(q.n);

    return `${top}π${q.d === 1n ? '' : `/${q.d}`}`;
}

const angleText = (deg) => `${f(deg, 12)}° = ${piText(deg)} rad`;
const both = (fn, deg) => {
    const e = exactTrig(fn, deg);
    const v = trigValue(fn, deg);

    if (e === 'undefined') {
        return 'Undefined';
    }

    return e && !/^−?\d+$/.test(e) && e !== '1/2' && e !== '−1/2' ? `${e} ≈ ${f(v, 12)}` : e ?? f(v, 14);
};

function quadrantOf(r) {
    if ([0, 90, 180, 270].includes(r)) {
        return `On an axis (${r}°)`;
    }

    return `Quadrant ${['I', 'II', 'III', 'IV'][Math.floor(r / 90)]}`;
}

function allSix(deg) {
    return Object.fromEntries(NAMES.map((n) => [n, both(n, deg)]));
}

function unitCirclePlot(deg) {
    const [s, c] = sc(deg);
    const r = norm360(deg);

    return { kind: 'diagram', shapes: [{ points: arc(0, 0, 1), muted: true }, { points: [[-1.25, 0], [1.25, 0]], muted: true }, { points: [[0, -1.25], [0, 1.25]], muted: true }, { points: [[0, 0], [c, s]] }, { points: [[c, 0], [c, s]], muted: true, dashed: true }, { points: arc(0, 0, 0.22, 0, r * D, 36), muted: true }], dots: [[c, s]], labels: [{ x: c * 1.18, y: s * 1.18 + (s >= 0 ? 0.05 : -0.05), text: `(${f(c, 4)}, ${f(s, 4)})` }] };
}

/** Rational p/q or ±√(p/q) recognised from a decimal, for the expression evaluator. */
function recognise(x) {
    const rational = (y) => {
        let [h0, h1, k0, k1] = [0, 1, 1, 0];
        let z = y;

        for (let n = 0; n < 30; n += 1) {
            const a = Math.floor(z);
            [h0, h1] = [h1, a * h1 + h0];
            [k0, k1] = [k1, a * k1 + k0];

            if (k1 > 100000) {
                return null;
            }

            if (abs(h1 / k1 - y) < 1e-11 * Math.max(1, abs(y))) {
                return [h1, k1];
            }

            z = 1 / (z - a);

            if (!Number.isFinite(z)) {
                break;
            }
        }

        return abs(h1 / k1 - y) < 1e-11 * Math.max(1, abs(y)) ? [h1, k1] : null;
    };
    const r = rational(abs(x));

    if (r && r[1] <= 1000) {
        return `${x < 0 ? '−' : ''}${r[1] === 1 ? r[0] : `${r[0]}/${r[1]}`}`;
    }

    const sq = rational(x * x);

    if (sq && sq[1] <= 1000 && sq[0] <= 1e6) {
        return `${x < 0 ? '−' : ''}${surd(R.Q(sq[0], sq[1]))}`;
    }

    return null;
}

export const handlers = {
    trig_fn: (i, c) => {
        const fn = c.fn ?? i.fn ?? 'sin';
        const deg = readAngle(i);

        if (!Number.isFinite(deg)) {
            return need('Enter an angle.');
        }

        const r = norm360(deg);
        const rows = { ...allSix(deg), quadrant: quadrantOf(r), reference: `${f(refAngle(r), 12)}°`, angle: angleText(deg) };

        if (fn === 'all') {
            return result(`sin ${both('sin', deg)}, cos ${both('cos', deg)}`, `Trig functions of ${f(deg, 10)}°`, { sub: `tan ${both('tan', deg)}`, rows, steps: NAMES.map((n) => `${n} ${f(deg, 10)}° = ${both(n, deg)}`), plots: { diagram: unitCirclePlot(deg) } });
        }

        const e = exactTrig(fn, deg);
        const v = trigValue(fn, deg);
        const steps = [`Angle ${angleText(deg)}, ${quadrantOf(r)}`, `Reference angle ${f(refAngle(r), 12)}°`];

        if (e === 'undefined') {
            steps.push(`${fn} ${f(deg, 10)}° is undefined (division by zero)`);

            return result('Undefined', `${fn}(${f(deg, 10)}°)`, { sub: fn === 'tan' || fn === 'sec' ? 'cos θ = 0 here' : 'sin θ = 0 here', rows, steps, plots: { diagram: unitCirclePlot(deg) } });
        }

        steps.push(e ? `Exact value from the unit circle: ${e}` : 'Not a standard angle: the decimal value is computed', `${fn}(${f(deg, 10)}°) = ${f(v, 15)}`);

        return result(e && !/^−?\d+$/.test(e) ? e : f(v, 14), `${fn}(${f(deg, 10)}°)`, { sub: e && !/^−?\d+$/.test(e) ? `≈ ${f(v, 14)}` : `${quadrantOf(r)}, reference angle ${f(refAngle(r), 10)}°`, rows, steps, plots: { diagram: unitCirclePlot(deg) } });
    },

    inverse: (i, c) => {
        const fn = c.fn ?? i.fn ?? 'asin';
        const text = String(i.x ?? '').trim();
        let x;

        try {
            x = text ? evalReal(parse(text)) : NaN;
        } catch (e) {
            if (e instanceof ParseError) {
                return fail(e.message);
            }

            throw e;
        }

        if (!Number.isFinite(x)) {
            return need('Enter a value such as 0.5, √3/2 or 1/3.');
        }

        const domain = { asin: abs(x) <= 1, acos: abs(x) <= 1, atan: true, acot: true, acsc: abs(x) >= 1, asec: abs(x) >= 1 }[fn];

        if (!domain) {
            return fail(fn === 'asin' || fn === 'acos' ? `${fn} needs a value between −1 and 1 (sine and cosine never leave that range).` : `${fn} needs |x| ≥ 1.`);
        }

        const clampv = (y) => Math.min(1, Math.max(-1, y));
        const rad = { asin: asin(clampv(x)), acos: acos(clampv(x)), atan: atan(x), acot: x === 0 ? PI / 2 : x > 0 ? atan(1 / x) : PI + atan(1 / x), acsc: asin(clampv(1 / x)), asec: acos(clampv(1 / x)) }[fn];
        const deg = rad / D;
        const forward = { asin: 'sin', acos: 'cos', atan: 'tan', acot: 'cot', acsc: 'csc', asec: 'sec' }[fn];
        const exactHit = KEYS.some((k) => abs(abs(deg) - k) < 1e-9 || abs(abs(deg) - (180 - k)) < 1e-9);
        const range = { asin: '[−90°, 90°]', acos: '[0°, 180°]', atan: '(−90°, 90°)', acot: '(0°, 180°)', acsc: '[−90°, 0) ∪ (0, 90°]', asec: '[0, 90°) ∪ (90°, 180°]' }[fn];
        const general = { asin: `θ = ${f(deg, 10)}° + 360°k or ${f(180 - deg, 10)}° + 360°k`, acos: `θ = ±${f(deg, 10)}° + 360°k`, atan: `θ = ${f(deg, 10)}° + 180°k`, acot: `θ = ${f(deg, 10)}° + 180°k`, acsc: `θ = ${f(deg, 10)}° + 360°k or ${f(180 - deg, 10)}° + 360°k`, asec: `θ = ±${f(deg, 10)}° + 360°k` }[fn];
        const value = exactHit ? `${f(deg, 12)}° = ${piText(deg)}` : `${f(deg, 12)}°`;

        return result(value, `${fn}(${text})`, { sub: `${f(rad, 14)} rad; principal range ${range}`, rows: { degrees: `${f(deg, 14)}°`, radians: `${f(rad, 14)} rad${exactHit ? ` = ${piText(deg)}` : ''}`, check: `${forward}(${f(deg, 10)}°) = ${both(forward, deg)}`, general, range }, steps: [`x = ${text} = ${f(x, 15)}`, `${fn}(x) is the angle in ${range} whose ${forward} is x`, `= ${f(deg, 14)}° = ${f(rad, 14)} rad${exactHit ? ` = ${piText(deg)}` : ''}`] });
    },

    cofunction: (i) => {
        const deg = readAngle(i);

        if (!Number.isFinite(deg)) {
            return need('Enter an angle.');
        }

        const co = 90 - deg;
        const pairs = [['sin', 'cos'], ['cos', 'sin'], ['tan', 'cot'], ['cot', 'tan'], ['sec', 'csc'], ['csc', 'sec']];

        return result(`sin ${f(deg, 10)}° = cos ${f(co, 10)}°`, 'Cofunction identities', { sub: `Complement 90° − θ = ${f(co, 12)}°`, rows: Object.fromEntries(pairs.map(([a, b]) => [a, `${a} ${f(deg, 10)}° = ${b} ${f(co, 10)}° = ${both(a, deg)}`])), steps: ['Cofunctions of complementary angles are equal: sin θ = cos(90° − θ), tan θ = cot(90° − θ), sec θ = csc(90° − θ)', `90° − ${f(deg, 10)}° = ${f(co, 12)}°`, `In radians: π/2 − θ = ${piText(co)}`] });
    },

    double: (i, c) => {
        const deg = readAngle(i);

        if (!Number.isFinite(deg)) {
            return need('Enter an angle θ.');
        }

        const want = c.want ?? 'sin';
        const two = 2 * deg;
        const rows = { sin: `sin 2θ = 2 sin θ cos θ = ${both('sin', two)}`, cos: `cos 2θ = cos²θ − sin²θ = 2cos²θ − 1 = 1 − 2sin²θ = ${both('cos', two)}`, tan: `tan 2θ = 2 tan θ ÷ (1 − tan²θ) = ${both('tan', two)}`, given: `θ = ${angleText(deg)}: sin θ = ${both('sin', deg)}, cos θ = ${both('cos', deg)}` };
        const label = { sin: 'sin 2θ', cos: 'cos 2θ', tan: 'tan 2θ' }[want];
        const e = exactTrig(want, two);
        const v = trigValue(want, two);

        return result(e === 'undefined' ? 'Undefined' : e ?? f(v, 14), label, { sub: e && e !== 'undefined' && !/^−?\d+$/.test(e) ? `≈ ${f(v, 14)}; 2θ = ${f(two, 10)}°` : `2θ = ${f(two, 10)}°`, rows, steps: [`2θ = ${f(two, 12)}°`, want === 'sin' ? `sin 2θ = 2 sin θ cos θ = 2 × ${f(trigValue('sin', deg), 12)} × ${f(trigValue('cos', deg), 12)}` : want === 'cos' ? `cos 2θ = 1 − 2sin²θ = 1 − 2 × ${f(trigValue('sin', deg), 12)}²` : `tan 2θ = 2 tan θ ÷ (1 − tan²θ)`, `= ${e ?? f(v, 14)}`] });
    },

    half: (i) => {
        const deg = readAngle(i);

        if (!Number.isFinite(deg)) {
            return need('Enter an angle θ.');
        }

        const h = deg / 2;
        const [, cth] = sc(deg);
        const sign = (fn) => (trigValue(fn, h) < 0 ? '−' : '+');

        return result(both('sin', h), `sin(θ/2), θ/2 = ${f(h, 10)}°`, { sub: `cos(θ/2) = ${both('cos', h)}`, rows: { sin: `sin(θ/2) = ${sign('sin')}√((1 − cos θ) ÷ 2) = ${both('sin', h)}`, cos: `cos(θ/2) = ${sign('cos')}√((1 + cos θ) ÷ 2) = ${both('cos', h)}`, tan: `tan(θ/2) = sin θ ÷ (1 + cos θ) = ${both('tan', h)}`, given: `cos θ = ${both('cos', deg)}; θ/2 lies in ${quadrantOf(norm360(h))}` }, steps: [`θ/2 = ${f(h, 12)}°, in ${quadrantOf(norm360(h))}, which fixes the signs`, `sin(θ/2) = ±√((1 − cos θ) ÷ 2) = ${sign('sin')}√((1 − ${f(cth, 12)}) ÷ 2) = ${f(trigValue('sin', h), 14)}`, `cos(θ/2) = ±√((1 + cos θ) ÷ 2) = ${f(trigValue('cos', h), 14)}`] });
    },

    power_reduce: (i) => {
        const deg = readAngle(i);

        if (!Number.isFinite(deg)) {
            return need('Enter an angle θ.');
        }

        const [s, c0] = sc(deg);
        const c2 = trigValue('cos', 2 * deg);
        const e2 = exactTrig('cos', 2 * deg);

        return result(f(s * s, 14), 'sin²θ = (1 − cos 2θ) ÷ 2', { sub: `cos²θ = ${f(c0 * c0, 14)}`, rows: { sin2: `sin²θ = (1 − cos 2θ) ÷ 2 = (1 − ${e2 ?? f(c2, 12)}) ÷ 2 = ${f(s * s, 14)}`, cos2: `cos²θ = (1 + cos 2θ) ÷ 2 = ${f(c0 * c0, 14)}`, tan2: c0 === 0 ? 'tan²θ is undefined' : `tan²θ = (1 − cos 2θ) ÷ (1 + cos 2θ) = ${f((s * s) / (c0 * c0), 14)}`, sin4: `sin⁴θ = (3 − 4 cos 2θ + cos 4θ) ÷ 8 = ${f(s ** 4, 14)}; cos⁴θ = (3 + 4 cos 2θ + cos 4θ) ÷ 8 = ${f(c0 ** 4, 14)}` }, steps: ['Power-reducing formulas come from cos 2θ = 1 − 2sin²θ = 2cos²θ − 1', `cos 2θ = cos ${f(2 * deg, 10)}° = ${e2 ?? f(c2, 14)}`, `sin²θ = (1 − cos 2θ) ÷ 2 = ${f(s * s, 14)}`] });
    },

    sum_diff: (i, c) => {
        const a = readAngle(i, 'alpha');
        const b = readAngle({ beta: i.beta, beta_unit: i.alpha_unit }, 'beta');
        const op = i.op ?? '+';

        if (!Number.isFinite(a) || !Number.isFinite(b)) {
            return need('Enter both angles.');
        }

        const s = op === '+' ? a + b : a - b;
        const sg = op === '+' ? '+' : '−';
        const sgr = op === '+' ? '−' : '+';
        const want = c.want ?? 'sin';
        const rows = {
            sin: `sin(α ${sg} β) = sin α cos β ${sg} cos α sin β = ${both('sin', s)}`,
            cos: `cos(α ${sg} β) = cos α cos β ${sgr} sin α sin β = ${both('cos', s)}`,
            tan: `tan(α ${sg} β) = (tan α ${sg} tan β) ÷ (1 ${sgr} tan α tan β) = ${both('tan', s)}`,
            parts: `sin α = ${both('sin', a)}, cos α = ${both('cos', a)}, sin β = ${both('sin', b)}, cos β = ${both('cos', b)}`,
        };
        const e = exactTrig(want, s);

        return result(e === 'undefined' ? 'Undefined' : e ?? f(trigValue(want, s), 14), `${want}(${f(a, 10)}° ${sg} ${f(b, 10)}°)`, { sub: `= ${want} ${f(s, 10)}°${e && e !== 'undefined' && !/^−?\d+$/.test(e) ? ` ≈ ${f(trigValue(want, s), 14)}` : ''}`, rows, steps: [want === 'sin' ? `sin(α ${sg} β) = sin α cos β ${sg} cos α sin β` : want === 'cos' ? `cos(α ${sg} β) = cos α cos β ${sgr} sin α sin β` : `tan(α ${sg} β) = (tan α ${sg} tan β) ÷ (1 ${sgr} tan α tan β)`, want === 'sin' ? `= (${both('sin', a)})(${both('cos', b)}) ${sg} (${both('cos', a)})(${both('sin', b)})` : want === 'cos' ? `= (${both('cos', a)})(${both('cos', b)}) ${sgr} (${both('sin', a)})(${both('sin', b)})` : `with tan α = ${both('tan', a)}, tan β = ${both('tan', b)}`, `= ${e ?? f(trigValue(want, s), 14)}`] });
    },

    identity: (i) => {
        const text = String(i.identity ?? '').trim();
        const degrees = (i.angle_mode ?? 'rad') === 'deg';

        if (!text) {
            return need('Type an identity such as sin(x)^2 + cos(x)^2 = 1.');
        }

        let tree;

        try {
            tree = parse(text.replace(/θ/g, 'x').replace(/α/g, 'a').replace(/β/g, 'b'));
        } catch (e) {
            if (e instanceof ParseError) {
                return fail(e.message);
            }

            throw e;
        }

        if (tree.t !== 'rel' || tree.ops.length !== 1 || tree.ops[0] !== '=') {
            return fail('Type one equation with a single = sign.');
        }

        const vars = [...variables(tree)];

        if (vars.length > 3) {
            return fail('Use at most three variables.');
        }

        // Deterministic spread of test values (avoiding special angles where both sides may coincide by accident).
        const tests = Array.from({ length: 24 }, (_, k) => vars.map((_, j) => (degrees ? 1 : D) * (13.7 + 37.3 * k + 71.9 * j + 3.1 * k * j)));
        let checked = 0;
        let worst = 0;
        let counter = null;

        for (const vals of tests) {
            const env = Object.fromEntries(vars.map((n, j) => [n, vals[j]]));
            const L = evalReal(tree.parts[0], env, { degrees });
            const Rv = evalReal(tree.parts[1], env, { degrees });

            if (!Number.isFinite(L) || !Number.isFinite(Rv) || abs(L) > 1e8 || abs(Rv) > 1e8) {
                continue;
            }

            checked += 1;
            const err = abs(L - Rv) / Math.max(1, abs(L), abs(Rv));
            worst = Math.max(worst, err);

            if (err > 1e-9 && !counter) {
                counter = { env, L, Rv };
            }
        }

        if (checked < 5) {
            return fail('The expression is undefined at most test angles; check the brackets and functions.');
        }

        const unit = degrees ? '°' : ' rad';

        if (counter) {
            return result('Not an identity', 'Check', { sub: `Fails at ${Object.entries(counter.env).map(([n, v]) => `${n} = ${f(v, 6)}${unit}`).join(', ')}: left ${f(counter.L, 10)}, right ${f(counter.Rv, 10)}`, rows: { tested: `${checked} values`, worst: `Largest relative difference ${f(worst, 6)}`, pythagorean: 'sin²x + cos²x = 1, 1 + tan²x = sec²x, 1 + cot²x = csc²x', angles: 'sin 2x = 2 sin x cos x, cos 2x = cos²x − sin²x, sin(a ± b) = sin a cos b ± cos a sin b' }, steps: [`Left side − right side at ${Object.entries(counter.env).map(([n, v]) => `${n} = ${f(v, 8)}${unit}`).join(', ')}: ${f(counter.L - counter.Rv, 12)}`, 'A single counterexample proves the equation is not an identity'] });
        }

        return result('Identity holds', 'Check', { sub: `Both sides agree at all ${checked} test values (to 12 significant digits)`, rows: { tested: `${checked} values of ${vars.join(', ') || 'no variable'}`, worst: `Largest relative difference ${f(worst, 3)}`, pythagorean: 'sin²x + cos²x = 1, 1 + tan²x = sec²x, 1 + cot²x = csc²x', angles: 'sin 2x = 2 sin x cos x, cos 2x = cos²x − sin²x, sin(a ± b) = sin a cos b ± cos a sin b' }, steps: ['Both sides were evaluated at many unrelated angles', `Largest relative difference: ${f(worst, 3)}`, 'Agreement everywhere strongly indicates an identity; a symbolic proof uses the standard identities listed'] });
    },

    phase_shift: (i) => {
        const [A, B, C, Dv] = [i.a, i.b, i.c, i.d].map(Number);
        const fn = i.fn ?? 'sin';

        if (![A, B, C, Dv].every(Number.isFinite) || B === 0 || A === 0) {
            return need('Enter A and B (not 0), C and D.');
        }

        const period = (fn === 'tan' ? PI : 2 * PI) / abs(B);
        const shift = C / B;
        const series = Array.from({ length: 241 }, (_, k) => {
            const x = shift - period * 0.25 + (2.5 * period * k) / 240;
            const arg = B * x - C;
            const y = A * (fn === 'sin' ? sin(arg) : fn === 'cos' ? cos(arg) : tan(arg)) + Dv;

            return [x, fn === 'tan' && abs(y - Dv) > 10 * abs(A) ? NaN : y];
        });
        const dir = shift > 0 ? 'right' : shift < 0 ? 'left' : 'none';

        return result(f(shift, 12), 'Phase shift', { sub: dir === 'none' ? 'No horizontal shift' : `${f(abs(shift), 12)} to the ${dir}`, rows: { amplitude: fn === 'tan' ? `None (vertical stretch ${f(abs(A), 12)})` : f(abs(A), 12), period: `${f(period, 12)} (= ${fn === 'tan' ? 'π' : '2π'} ÷ |B|)`, shift: `C ÷ B = ${f(shift, 12)} (${dir === 'none' ? 'none' : dir})`, vertical: `${f(Dv, 12)} (midline y = ${f(Dv, 12)})`, range: fn === 'tan' ? 'All real numbers' : `[${f(Dv - abs(A), 12)}, ${f(Dv + abs(A), 12)}]`, frequency: `${f(1 / period, 12)} cycles per unit` }, steps: [`y = A ${fn}(Bx − C) + D = ${f(A)} ${fn}(${f(B)}x − ${f(C)}) + ${f(Dv)}`, `Rewrite as ${f(A)} ${fn}(${f(B)}(x − ${f(shift, 10)})) + ${f(Dv)}`, `Phase shift C ÷ B = ${f(shift, 12)}, period ${fn === 'tan' ? 'π' : '2π'} ÷ |B| = ${f(period, 12)}`], plots: { graph: { series, axes: true, xLabel: 'x (radians)', yLabel: 'y' } } });
    },

    unit_circle: (i, c) => {
        const deg = readAngle(i);

        if (!Number.isFinite(deg)) {
            return need('Enter an angle.');
        }

        const r = norm360(deg);
        const rows = { ...allSix(deg), point: `(${both('cos', deg)}, ${both('sin', deg)})`, quadrant: quadrantOf(r), reference: `${f(refAngle(r), 12)}°`, angle: angleText(deg) };
        const exactKnown = exactTrig('sin', deg) !== null;

        if (c.want === 'exact') {
            return result(exactKnown ? `sin = ${exactTrig('sin', deg)}, cos = ${exactTrig('cos', deg)}` : 'No simple exact form', `Exact values at ${f(deg, 10)}°`, { sub: exactKnown ? `tan = ${exactTrig('tan', deg)}` : 'Exact forms exist for multiples of 15°, 18° and 22.5°', rows, steps: [`Reference angle ${f(refAngle(r), 12)}° in ${quadrantOf(r)}`, 'Signs: All Students Take Calculus (I all positive, II sin, III tan, IV cos)', ...NAMES.map((n) => `${n} = ${both(n, deg)}`)], plots: { diagram: unitCirclePlot(deg) } });
        }

        return result(`(${exactTrig('cos', deg) ?? f(trigValue('cos', deg), 10)}, ${exactTrig('sin', deg) ?? f(trigValue('sin', deg), 10)})`, 'Point on the unit circle (cos θ, sin θ)', { sub: `${angleText(deg)}; ${quadrantOf(r)}`, rows, steps: [`Coterminal angle ${f(r, 12)}°, reference angle ${f(refAngle(r), 12)}°`, `x = cos θ = ${both('cos', deg)}`, `y = sin θ = ${both('sin', deg)}`], plots: { diagram: unitCirclePlot(deg) } });
    },

    expression: (i, c) => {
        if (c.practice && i.mode === 'practice') {
            return practice(c.practice, i);
        }

        const text = String(i.expr ?? '').trim();
        const degrees = (i.angle_mode ?? 'deg') === 'deg';

        if (!text) {
            return need('Type an expression such as sin(30) + cos(60)^2.');
        }

        let value;

        try {
            const tree = parse(text);

            if ([...variables(tree)].length) {
                return fail('Use numbers only (no variables); use the identity checker for expressions in x.');
            }

            value = evalReal(tree, {}, { degrees });
        } catch (e) {
            if (e instanceof ParseError) {
                return fail(e.message);
            }

            throw e;
        }

        if (!Number.isFinite(value)) {
            return fail('The expression is undefined (for example tan 90° or a division by zero).');
        }

        const exact = recognise(value);

        return result(exact && exact !== f(value, 14) ? exact : f(value, 14), 'Value', { sub: exact && !/^−?\d+$/.test(exact) ? `≈ ${f(value, 15)}` : `Angles in ${degrees ? 'degrees' : 'radians'}`, rows: { decimal: f(value, 15), exact: exact ?? 'No simple exact form found', mode: degrees ? 'Degrees' : 'Radians', scientific: value.toExponential(12).replace('e', ' × 10^').replace('-', '−') }, steps: [`Evaluate ${text} with angles in ${degrees ? 'degrees' : 'radians'}`, `= ${f(value, 15)}`, exact ? `Recognised exactly as ${exact}` : 'No exact rational or square-root form within the search limits'] });
    },
};

export default defineTools(handlers);
