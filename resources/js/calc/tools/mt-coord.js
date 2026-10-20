import { defineTools } from '../engines/formula.js';
import { evalExact, evalReal, parse, ParseError, toPoly, variables } from '../math/expr.js';
import * as P from '../math/poly.js';
import { f, fail, need, q, R, result } from '../math/util.js';

/**
 * Coordinate geometry: distances, midpoints, slopes and every form of a line, intersections, planes and spheres,
 * vectors, polar/cylindrical/spherical coordinates, regression, interpolation, parabolas, polynomial graphs,
 * rotations, the catenary, the sigmoid and triangulation. Coordinates typed as text stay exact (fractions).
 */
const { PI, sqrt, sin, cos, tan, atan2, abs, hypot, exp, log, cosh, sinh, acos } = Math;
const D = PI / 180;
const t = (x) => R.toFraction(x);

/** Exact square root text of a non-negative rational: "5√2", "√13/2", or a decimal for huge values. */
export function surd(x) {
    if (R.isZero(x)) {
        return '0';
    }

    const num = x.n * x.d;
    const den = x.d;

    if (num > 10n ** 30n) {
        return f(sqrt(R.toNumber(x)), 12);
    }

    const [outside, inside] = P.simplifySqrt(num);
    const g = R.bgcd(outside, den);
    const o = outside / g;
    const dd = den / g;
    const head = inside === 1n ? `${o}` : `${o === 1n ? '' : o}√${inside}`;

    return dd === 1n ? head : `${head}/${dd}`;
}

const isExactRoot = (x) => !surd(x).includes('√');
/** "5√2 ≈ 7.0710678119" or "5" for exact roots. */
const surdBoth = (x) => (isExactRoot(x) ? surd(x) : `${surd(x)} ≈ ${f(sqrt(R.toNumber(x)), 12)}`);

/** Read numbers (exact when typed as fractions or decimals). */
function readQ(i, names) {
    const out = names.map((n) => q(i[n]));

    return out.some((v) => v === null) ? null : out;
}

/** A vector typed as "3, 4" or "(1, -2, 5)". */
function readVec(text) {
    const parts = String(text ?? '').replace(/[()<>⟨⟩[\]]/g, ' ').split(/[,;\s]+/).filter(Boolean);
    const v = parts.map((p) => q(p.replace('−', '-')));

    return v.length && v.every(Boolean) ? v : null;
}

/** Rows of exact points from a textarea. */
function readPoints(text, dims = 2) {
    const lines = String(text ?? '').split(/\n|;/).map((l) => l.trim()).filter(Boolean);
    const pts = lines.map((l) => readVec(l));

    return pts.every((p) => p && p.length === dims) ? pts : null;
}

const pt = (...xs) => `(${xs.map((x) => t(x)).join(', ')})`;

/** Linear equation in the given variables: { coef: [a, b, (c)], rhs } exact, from text such as "2x − 3y = 6" or "y = 2x + 1". */
export function readLinear(text, vars = ['x', 'y']) {
    let tree;

    try {
        tree = parse(text);
    } catch (e) {
        if (e instanceof ParseError) {
            return { error: e.message };
        }

        throw e;
    }

    const extra = [...variables(tree)].filter((n) => !vars.includes(n));

    if (extra.length) {
        return { error: `Use only ${vars.join(', ')} (found ${extra.join(', ')}).` };
    }

    const side = tree.t === 'rel' ? null : tree;
    const F = (vals) => {
        const env = Object.fromEntries(vars.map((n, k) => [n, R.Q(vals[k])]));

        if (side) {
            // "2x + 1" alone means y = 2x + 1 (or z = … in 3D).
            const last = vars[vars.length - 1];
            const lhs = env[last];
            const rhs = evalExact(side, env);

            return rhs && R.sub(lhs, rhs);
        }

        const a = evalExact(tree.parts[0], env);
        const b = evalExact(tree.parts[1], env);

        return a && b && R.sub(a, b);
    };
    const zero = F(vars.map(() => 0));

    if (!zero) {
        return { error: 'Use numbers and fractions only (no roots or functions) in the equation.' };
    }

    const coef = vars.map((_, k) => R.sub(F(vars.map((__, j) => (j === k ? 1 : 0))), zero));
    const test = F(vars.map((_, k) => 2 + 3 * k));
    const predicted = coef.reduce((s, c, k) => R.add(s, R.mul(c, R.Q(2 + 3 * k))), zero);

    if (!test || !R.eq(test, predicted)) {
        return { error: 'This is not a linear equation.' };
    }

    if (coef.every((c) => R.isZero(c))) {
        return { error: 'The equation has no x or y term.' };
    }

    return { coef, rhs: R.neg(zero) };
}

/** Integer-normalised standard form a x + b y = c. */
function normalise(coef, rhs) {
    const dens = [...coef, rhs].map((c) => c.d);
    const l = dens.reduce((m, d) => (m * d) / R.bgcd(m, d), 1n);
    let ints = [...coef, rhs].map((c) => (c.n * l) / c.d);
    const g = ints.reduce((m, v) => R.bgcd(m, v < 0n ? -v : v), 0n) || 1n;
    ints = ints.map((v) => v / g);
    const lead = ints.find((v) => v !== 0n);

    if (lead < 0n) {
        ints = ints.map((v) => -v);
    }

    return ints;
}

function standardText(ints, vars = ['x', 'y']) {
    const terms = vars.map((v, k) => [ints[k], v]).filter(([c]) => c !== 0n);
    const lhs = terms.map(([c, v], n) => `${n ? (c < 0n ? ' − ' : ' + ') : c < 0n ? '−' : ''}${(c < 0n ? -c : c) === 1n ? '' : (c < 0n ? -c : c)}${v}`).join('');

    return `${lhs} = ${ints[vars.length] < 0n ? `−${-ints[vars.length]}` : ints[vars.length]}`;
}

/** Coefficient text: "3", "−3", "(1/2)", "−(1/2)"; empty for 1 and "−" for −1. */
function coefText(m) {
    if (R.eq(m, R.ONE)) {
        return '';
    }

    if (R.eq(m, R.neg(R.ONE))) {
        return '−';
    }

    if (R.isInt(m)) {
        return t(m);
    }

    return R.sign(m) < 0 ? `−(${t(R.qabs(m))})` : `(${t(m)})`;
}

const bigText = (v) => (v < 0n ? `−${-v}` : `${v}`);

/** m and b as text in "y = mx + b". */
function slopeInterceptText(m, b) {
    const mText = R.isZero(m) ? '' : `${coefText(m)}x`;

    if (!mText) {
        return `y = ${t(b)}`;
    }

    return R.isZero(b) ? `y = ${mText}` : `y = ${mText} ${R.sign(b) < 0 ? '−' : '+'} ${t(R.qabs(b))}`;
}

/** All forms of the line a x + b y = c. */
function lineForms(coef, rhs, through = null) {
    const [a, b] = coef;
    const ints = normalise(coef, rhs);
    const standard = standardText(ints);

    if (R.isZero(b)) {
        const x0 = R.div(rhs, a);

        return { vertical: true, x0, standard, slopeIntercept: `x = ${t(x0)} (vertical, undefined slope)`, pointSlope: `x = ${t(x0)}`, slope: 'Undefined (vertical line)', yint: 'None (vertical line)', xint: t(x0), m: null, b: null, angle: 90 };
    }

    const m = R.neg(R.div(a, b));
    const b0 = R.div(rhs, b);
    const p = through ?? [R.ZERO, b0];
    const sh = (v, n) => (R.isZero(v) ? n : `(${n} ${R.sign(v) > 0 ? '−' : '+'} ${t(R.qabs(v))})`);
    const pointSlope = R.isZero(m) ? `y = ${t(p[1])}` : `${sh(p[1], 'y')} = ${coefText(m)}${sh(p[0], 'x')}`.replace(/^\((y.*?)\) =/, '$1 =');

    return { vertical: false, m, b: b0, standard, slopeIntercept: slopeInterceptText(m, b0), pointSlope, slope: t(m), yint: `(0, ${t(b0)})`, xint: R.isZero(m) ? (R.isZero(b0) ? 'Every x (the line is the x-axis)' : 'None (horizontal line)') : `(${t(R.div(R.neg(b0), m))}, 0)`, angle: Math.atan(R.toNumber(m)) / D };
}

/** A line plot spanning the given x range. */
function linePlot(lines, points = [], range = null) {
    const xs = points.map((p) => p[0]);
    const lo = range ? range[0] : Math.min(-5, ...xs) - 2;
    const hi = range ? range[1] : Math.max(5, ...xs) + 2;
    const series = lines.map((L) => (L.vertical ? [[R.toNumber(L.x0), lo], [R.toNumber(L.x0), hi]] : [[lo, R.toNumber(L.m) * lo + R.toNumber(L.b)], [hi, R.toNumber(L.m) * hi + R.toNumber(L.b)]]));
    const ys = series.flat().map((p) => p[1]).concat(points.map((p) => p[1]));
    const ylo = Math.max(Math.min(...ys), lo - (hi - lo));
    const yhi = Math.min(Math.max(...ys), hi + (hi - lo));
    const clip = (s) => s.map(([x, y]) => [x, Math.max(ylo, Math.min(yhi, y))]);

    return { series: clip(series[0] ?? []), extra: series.slice(1).map(clip), scatter: points, axes: true, xLabel: 'x', yLabel: 'y' };
}

function readLineInput(i, c) {
    const given = c.given ?? i.given ?? 'points';

    if (given === 'points') {
        const v = readQ(i, ['x1', 'y1', 'x2', 'y2']);

        if (!v) {
            return { empty: 'Enter both points (fractions allowed).' };
        }

        const [x1, y1, x2, y2] = v;

        if (R.eq(x1, x2) && R.eq(y1, y2)) {
            return { error: 'The two points are the same, so they do not fix a line.' };
        }

        // (y2 − y1)x − (x2 − x1)y = (y2 − y1)x1 − (x2 − x1)y1
        const a = R.sub(y2, y1);
        const b = R.neg(R.sub(x2, x1));

        return { coef: [a, b], rhs: R.add(R.mul(a, x1), R.mul(b, y1)), through: [x1, y1], points: [[x1, y1], [x2, y2]], steps: [`Slope m = (y₂ − y₁) ÷ (x₂ − x₁) = (${t(y2)} − ${t(y1)}) ÷ (${t(x2)} − ${t(x1)})${R.isZero(R.sub(x2, x1)) ? ': undefined (vertical line)' : ` = ${t(R.div(R.sub(y2, y1), R.sub(x2, x1)))}`}`] };
    }

    if (given === 'point_slope') {
        const v = readQ(i, ['x1', 'y1', 'm']);

        if (!v) {
            return { empty: 'Enter the point and the slope.' };
        }

        const [x1, y1, m] = v;

        return { coef: [R.neg(m), R.ONE], rhs: R.sub(y1, R.mul(m, x1)), through: [x1, y1], points: [[x1, y1]], steps: [`y − ${t(y1)} = ${t(m)}(x − ${t(x1)})`] };
    }

    if (given === 'slope_intercept') {
        const v = readQ(i, ['m', 'b']);

        if (!v) {
            return { empty: 'Enter the slope and the y-intercept.' };
        }

        return { coef: [R.neg(v[0]), R.ONE], rhs: v[1], points: [[R.ZERO, v[1]]], steps: [`y = mx + b with m = ${t(v[0])}, b = ${t(v[1])}`] };
    }

    const L = readLinear(String(i.eq ?? ''));

    if (L.error) {
        return String(i.eq ?? '').trim() ? { error: L.error } : { empty: 'Type the equation of the line.' };
    }

    return { ...L, points: [], steps: [`Rearranged: ${standardText(normalise(L.coef, L.rhs))}`] };
}

const points2 = (p) => p.map(([x, y]) => [R.toNumber(x), R.toNumber(y)]);

/** Linear least squares and correlation. */
function regression(pts) {
    const n = pts.length;
    const xs = pts.map((p) => p[0]);
    const ys = pts.map((p) => p[1]);
    const mx = xs.reduce((s, x) => s + x, 0) / n;
    const my = ys.reduce((s, y) => s + y, 0) / n;
    const sxx = xs.reduce((s, x) => s + (x - mx) ** 2, 0);
    const syy = ys.reduce((s, y) => s + (y - my) ** 2, 0);
    const sxy = xs.reduce((s, x, k) => s + (x - mx) * (ys[k] - my), 0);
    const m = sxy / sxx;
    const b = my - m * mx;
    const r = sxy / sqrt(sxx * syy);
    const sse = ys.reduce((s, y, k) => s + (y - (m * xs[k] + b)) ** 2, 0);

    return { n, mx, my, sxx, syy, sxy, m, b, r, r2: r * r, se: n > 2 ? sqrt(sse / (n - 2)) : NaN, sse };
}

/** Three-variable vectors and helpers. */
const dotQ = (u, v) => u.reduce((s, x, k) => R.add(s, R.mul(x, v[k])), R.ZERO);
const crossQ = (u, v) => [R.sub(R.mul(u[1], v[2]), R.mul(u[2], v[1])), R.sub(R.mul(u[2], v[0]), R.mul(u[0], v[2])), R.sub(R.mul(u[0], v[1]), R.mul(u[1], v[0]))];
const vecText = (v) => `⟨${v.map((x) => t(x)).join(', ')}⟩`;
const norm2 = (v) => dotQ(v, v);

export const handlers = {
    distance: (i, c) => {
        const metric = c.metric ?? 'euclid';
        let A;
        let B;

        if (c.mode === 'vector') {
            A = readVec(i.p);
            B = readVec(i.q);

            if (!A || !B || A.length !== B.length) {
                return need('Enter two points with the same number of coordinates, such as 1, 2, 3.');
            }
        } else {
            const names = c.dim === 3 ? ['x1', 'y1', 'z1', 'x2', 'y2', 'z2'] : ['x1', 'y1', 'x2', 'y2'];
            const v = readQ(i, names);

            if (!v) {
                return need('Enter the coordinates of both points (fractions allowed).');
            }

            const k = names.length / 2;
            A = v.slice(0, k);
            B = v.slice(k);
        }

        const diffs = A.map((a, k) => R.sub(B[k], a));
        const sq = diffs.reduce((s, d) => R.add(s, R.mul(d, d)), R.ZERO);
        const manhattan = diffs.reduce((s, d) => R.add(s, R.qabs(d)), R.ZERO);
        const cheb = diffs.reduce((m, d) => (R.cmp(R.qabs(d), m) > 0 ? R.qabs(d) : m), R.ZERO);
        const euclid = surdBoth(sq);
        const rows = { euclid, manhattan: t(manhattan), chebyshev: t(cheb), squared: t(sq), diffs: diffs.map((d) => t(d)).join(', ') };
        const plot = A.length === 2 ? { diagram: { kind: 'diagram', shapes: [{ points: [points2([A, B])[0], points2([A, B])[1]] }, { points: [points2([A])[0], [R.toNumber(B[0]), R.toNumber(A[1])], points2([B])[0]], muted: true, dashed: true }], dots: points2([A, B]), labels: [{ x: R.toNumber(A[0]), y: R.toNumber(A[1]) - 0.4, text: pt(...A) }, { x: R.toNumber(B[0]), y: R.toNumber(B[1]) + 0.4, text: pt(...B) }] } } : undefined;

        if (metric === 'manhattan') {
            return result(t(manhattan), 'Manhattan distance', { sub: `Σ|Δ| = ${diffs.map((d) => `|${t(d)}|`).join(' + ')}`, rows, steps: [`Differences: ${rows.diffs}`, `Manhattan (taxicab) distance = Σ|Δ| = ${t(manhattan)}`, `For comparison, Euclidean = ${euclid} and Chebyshev = max|Δ| = ${t(cheb)}`], plots: plot });
        }

        return result(surd(sq), 'Distance', { sub: isExactRoot(sq) ? `√${t(sq)}` : `≈ ${f(sqrt(R.toNumber(sq)), 12)}`, rows, steps: [`d = √(${diffs.map((d) => `(${t(d)})²`).join(' + ')})`, `= √${t(sq)}`, `= ${euclid}`], plots: plot });
    },

    midpoint: (i, c) => {
        if (c.mode === 'endpoint') {
            const v = readQ(i, ['x1', 'y1', 'mx', 'my']);

            if (!v) {
                return need('Enter the known endpoint and the midpoint.');
            }

            const [x1, y1, mx, my] = v;
            const x2 = R.sub(R.mul(R.Q(2), mx), x1);
            const y2 = R.sub(R.mul(R.Q(2), my), y1);

            return result(pt(x2, y2), 'Other endpoint', { sub: 'B = 2M − A', rows: { midpoint: pt(mx, my), length: surdBoth(R.add(R.mul(R.sub(x2, x1), R.sub(x2, x1)), R.mul(R.sub(y2, y1), R.sub(y2, y1)))), check: `((${t(x1)} + ${t(x2)}) ÷ 2, (${t(y1)} + ${t(y2)}) ÷ 2) = ${pt(mx, my)} ✓` }, steps: ['The midpoint is the average: M = (A + B) ÷ 2, so B = 2M − A', `x₂ = 2 × ${t(mx)} − ${t(x1)} = ${t(x2)}`, `y₂ = 2 × ${t(my)} − ${t(y1)} = ${t(y2)}`], plots: { diagram: { kind: 'diagram', shapes: [{ points: points2([[x1, y1], [x2, y2]]) }], dots: points2([[x1, y1], [mx, my], [x2, y2]]), labels: [{ x: R.toNumber(x1), y: R.toNumber(y1) - 0.5, text: 'A' }, { x: R.toNumber(mx), y: R.toNumber(my) - 0.5, text: 'M' }, { x: R.toNumber(x2), y: R.toNumber(y2) + 0.5, text: 'B' }] } } });
        }

        const v = readQ(i, ['x1', 'y1', 'x2', 'y2']);

        if (!v) {
            return need('Enter both endpoints (fractions allowed).');
        }

        const [x1, y1, x2, y2] = v;
        const mx = R.div(R.add(x1, x2), R.Q(2));
        const my = R.div(R.add(y1, y2), R.Q(2));
        const sq = R.add(R.mul(R.sub(x2, x1), R.sub(x2, x1)), R.mul(R.sub(y2, y1), R.sub(y2, y1)));

        return result(pt(mx, my), 'Midpoint', { sub: `Segment length ${surdBoth(sq)}`, rows: { midpoint: pt(mx, my), length: surdBoth(sq), check: `Half the segment: ${surdBoth(R.div(sq, R.Q(4)))}` }, steps: ['M = ((x₁ + x₂) ÷ 2, (y₁ + y₂) ÷ 2)', `= ((${t(x1)} + ${t(x2)}) ÷ 2, (${t(y1)} + ${t(y2)}) ÷ 2)`, `= ${pt(mx, my)}`], plots: { diagram: { kind: 'diagram', shapes: [{ points: points2([[x1, y1], [x2, y2]]) }], dots: points2([[x1, y1], [mx, my], [x2, y2]]), labels: [{ x: R.toNumber(mx), y: R.toNumber(my) + 0.5, text: `M${pt(mx, my)}` }] } } });
    },

    section: (i) => {
        const v = readQ(i, ['x1', 'y1', 'x2', 'y2', 'm', 'n']);

        if (!v) {
            return need('Enter both endpoints and the ratio m : n.');
        }

        const [x1, y1, x2, y2, m, n] = v;
        const external = i.kind === 'external';
        const denom = external ? R.sub(m, n) : R.add(m, n);

        if (R.isZero(denom) || R.sign(m) <= 0 || R.sign(n) <= 0) {
            return fail(external ? 'For an external division m and n must be positive and different.' : 'The ratio parts must be positive.');
        }

        const px = R.div(external ? R.sub(R.mul(m, x2), R.mul(n, x1)) : R.add(R.mul(m, x2), R.mul(n, x1)), denom);
        const py = R.div(external ? R.sub(R.mul(m, y2), R.mul(n, y1)) : R.add(R.mul(m, y2), R.mul(n, y1)), denom);

        return result(pt(px, py), 'Point P', { sub: `Divides AB ${external ? 'externally' : 'internally'} in the ratio ${t(m)} : ${t(n)}`, rows: { fraction: external ? 'Outside the segment' : `${t(R.div(m, R.add(m, n)))} of the way from A to B`, formula: external ? 'P = (mB − nA) ÷ (m − n)' : 'P = (mB + nA) ÷ (m + n)', check: `AP : PB = ${t(m)} : ${t(n)}` }, steps: [external ? 'External division: P = (m·B − n·A) ÷ (m − n)' : 'Section formula: P = (m·B + n·A) ÷ (m + n)', `x = (${t(m)} × ${t(x2)} ${external ? '−' : '+'} ${t(n)} × ${t(x1)}) ÷ ${t(denom)} = ${t(px)}`, `y = (${t(m)} × ${t(y2)} ${external ? '−' : '+'} ${t(n)} × ${t(y1)}) ÷ ${t(denom)} = ${t(py)}`], plots: { diagram: { kind: 'diagram', shapes: [{ points: points2([[x1, y1], [x2, y2]]) }, ...(external ? [{ points: points2([[x2, y2], [px, py]]), muted: true, dashed: true }] : [])], dots: points2([[x1, y1], [x2, y2], [px, py]]), labels: [{ x: R.toNumber(x1), y: R.toNumber(y1) - 0.5, text: 'A' }, { x: R.toNumber(x2), y: R.toNumber(y2) + 0.5, text: 'B' }, { x: R.toNumber(px) + 0.5, y: R.toNumber(py), text: 'P' }] } } });
    },

    slope: (i, c) => {
        let rise;
        let run;
        let pts = null;

        if ((c.given ?? i.given) === 'rise_run') {
            const v = readQ(i, ['rise', 'run']);

            if (!v) {
                return need('Enter the rise and the run.');
            }

            [rise, run] = v;
        } else {
            const v = readQ(i, ['x1', 'y1', 'x2', 'y2']);

            if (!v) {
                return need('Enter both points (fractions allowed).');
            }

            pts = [[v[0], v[1]], [v[2], v[3]]];
            rise = R.sub(v[3], v[1]);
            run = R.sub(v[2], v[0]);
        }

        if (R.isZero(run)) {
            return result('Undefined', 'Slope', { sub: 'Vertical line: the run is 0', rows: { slope: 'Undefined', angle: '90°', grade: 'Infinite', ratio: `${t(rise)} : 0`, equation: pts ? `x = ${t(pts[0][0])}` : 'x = constant', length: surdBoth(R.mul(rise, rise)) }, steps: ['m = rise ÷ run', `= ${t(rise)} ÷ 0, which is undefined`] });
        }

        const m = R.div(rise, run);
        const angle = Math.atan(R.toNumber(m)) / D;
        const L = pts ? lineForms([R.neg(rise), run], R.sub(R.mul(run, pts[0][1]), R.mul(rise, pts[0][0]))) : null;
        const want = c.want ?? 'slope';
        const rows = { slope: R.isInt(m) ? t(m) : `${t(m)} = ${f(R.toNumber(m), 10)}`, angle: `${f(angle, 10)}°`, grade: `${f(R.toNumber(m) * 100, 10)}%`, ratio: `${t(rise)} : ${t(run)}`, equation: L ? L.slopeIntercept : 'Enter points for the equation', length: surdBoth(R.add(R.mul(rise, rise), R.mul(run, run))) };
        const steps = ['m = rise ÷ run = (y₂ − y₁) ÷ (x₂ − x₁)', `= ${t(rise)} ÷ ${t(run)} = ${t(m)}`, `Angle = atan(m) = ${f(angle, 10)}°`, `Grade = m × 100% = ${f(R.toNumber(m) * 100, 10)}%`];
        const plots = { graph: pts ? linePlot([L], points2(pts)) : linePlot([{ vertical: false, m, b: R.ZERO }], [[0, 0], [R.toNumber(run), R.toNumber(rise)]]) };

        if (want === 'grade') {
            return result(f(R.toNumber(m) * 100, 10), 'Gradient (grade)', { unit: '%', sub: `Slope ${t(m)}, angle ${f(angle, 8)}°`, rows, steps, plots });
        }

        return result(t(m), 'Slope m', { sub: `${f(R.toNumber(m), 10)}; angle ${f(angle, 8)}°`, rows, steps, plots });
    },

    line: (i, c) => {
        const L0 = readLineInput(i, c);

        if (L0.empty) {
            return need(L0.empty);
        }

        if (L0.error) {
            return fail(L0.error);
        }

        const L = lineForms(L0.coef, L0.rhs, L0.through);
        const want = c.want ?? 'slopeIntercept';
        const labels = { slopeIntercept: 'Slope-intercept form', pointSlope: 'Point-slope form', standard: 'Standard form', yint: 'y-intercept', slope: 'Slope' };
        const rows = { slopeIntercept: L.slopeIntercept, pointSlope: L.pointSlope, standard: L.standard, slope: L.slope, yint: L.yint, xint: L.xint, angle: `${f(L.angle, 10)}°` };
        const steps = [...L0.steps];

        if (!L.vertical) {
            steps.push(`y-intercept b = ${t(L.b)}`, `Slope-intercept: ${L.slopeIntercept}`, `Standard form: ${L.standard}`);
        } else {
            steps.push(`Vertical line ${L.standard}`);
        }

        return result(rows[want], labels[want], { sub: want === 'slopeIntercept' ? `Slope ${L.slope}, y-intercept ${L.yint}` : L.slopeIntercept, rows, steps, plots: { graph: linePlot([L], points2(L0.points ?? [])) } });
    },

    parallel_perp: (i, c) => {
        const L = readLinear(String(i.eq ?? ''));
        const p = readQ(i, ['px', 'py']);

        if (L.error) {
            return String(i.eq ?? '').trim() ? fail(L.error) : need('Type the equation of the given line.');
        }

        if (!p) {
            return need('Enter the point the new line passes through.');
        }

        const [a, b] = L.coef;
        const perp = c.kind === 'perpendicular';
        // Parallel keeps (a, b); perpendicular uses (b, −a).
        const coef = perp ? [b, R.neg(a)] : [a, b];
        const rhs = R.add(R.mul(coef[0], p[0]), R.mul(coef[1], p[1]));
        const given = lineForms(L.coef, L.rhs);
        const out = lineForms(coef, rhs, p);
        const gapSq = perp ? null : R.div(R.mul(R.sub(rhs, L.rhs), R.sub(rhs, L.rhs)), R.add(R.mul(a, a), R.mul(b, b)));

        return result(out.slopeIntercept, perp ? 'Perpendicular line' : 'Parallel line', { sub: `Through ${pt(...p)}; slope ${out.slope}`, rows: { given: given.slopeIntercept, slopeIntercept: out.slopeIntercept, standard: out.standard, pointSlope: out.pointSlope, slope: perp ? `${out.slope} (negative reciprocal of ${given.slope})` : `${out.slope} (same as the given line)`, gap: perp ? `They meet at a right angle` : `Distance between the lines ${surdBoth(gapSq)}` }, steps: [`Given line: ${given.slopeIntercept}, slope ${given.slope}`, perp ? 'Perpendicular slopes multiply to −1: m⊥ = −1 ÷ m' : 'Parallel lines have the same slope', `Through ${pt(...p)}: ${out.pointSlope}`, `So ${out.slopeIntercept}`], plots: { graph: linePlot([given, out], points2([p])) } });
    },

    intersection: (i, c) => {
        const A = readLinear(String(i.eq1 ?? ''));
        const B = readLinear(String(i.eq2 ?? ''));

        if (A.error || B.error) {
            return String(i.eq1 ?? '').trim() && String(i.eq2 ?? '').trim() ? fail(A.error ?? B.error) : need('Type both line equations.');
        }

        const [a1, b1] = A.coef;
        const [a2, b2] = B.coef;
        const det = R.sub(R.mul(a1, b2), R.mul(a2, b1));
        const LA = lineForms(A.coef, A.rhs);
        const LB = lineForms(B.coef, B.rhs);
        const n1 = [R.toNumber(a1), R.toNumber(b1)];
        const n2 = [R.toNumber(a2), R.toNumber(b2)];
        const cosT = abs(n1[0] * n2[0] + n1[1] * n2[1]) / (hypot(...n1) * hypot(...n2));
        const acute = Math.acos(Math.min(1, cosT)) / D;
        const angleRow = `${f(acute, 10)}° (and ${f(180 - acute, 10)}°)`;

        if (c.want === 'angle') {
            const tanText = R.isZero(R.add(R.mul(a1, a2), R.mul(b1, b2))) ? 'Perpendicular' : `tan θ = |(m₁ − m₂) ÷ (1 + m₁m₂)| = ${f(tan(acute * D), 10)}`;

            return result(f(acute, 10), 'Acute angle between the lines', { unit: '°', sub: `Obtuse angle ${f(180 - acute, 10)}°`, rows: { lines: `${LA.slopeIntercept} and ${LB.slopeIntercept}`, angle: angleRow, relation: R.isZero(det) ? 'Parallel (0°)' : tanText, radians: `${f(acute * D, 12)} rad` }, steps: ['Normals n₁ = (a₁, b₁), n₂ = (a₂, b₂)', `cos θ = |n₁ · n₂| ÷ (|n₁||n₂|) = ${f(cosT, 12)}`, `θ = ${f(acute, 12)}°`], plots: { graph: linePlot([LA, LB]) } });
        }

        if (R.isZero(det)) {
            const same = R.isZero(R.sub(R.mul(a1, B.rhs), R.mul(a2, A.rhs))) && R.isZero(R.sub(R.mul(b1, B.rhs), R.mul(b2, A.rhs)));

            return result(same ? 'Same line' : 'No intersection', same ? 'Infinitely many points' : 'Parallel lines', { sub: same ? 'The equations describe the same line' : 'Equal slopes, different intercepts', rows: { point: same ? 'Every point of the line' : 'None', lines: `${LA.slopeIntercept} and ${LB.slopeIntercept}`, angle: '0°', relation: same ? 'Coincident' : 'Parallel' }, steps: ['The determinant a₁b₂ − a₂b₁ is 0, so the lines have the same slope'], plots: { graph: linePlot([LA, LB]) } });
        }

        const x = R.div(R.sub(R.mul(A.rhs, b2), R.mul(B.rhs, b1)), det);
        const y = R.div(R.sub(R.mul(a1, B.rhs), R.mul(a2, A.rhs)), det);

        return result(pt(x, y), 'Intersection point', { sub: `Angle between the lines ${f(acute, 8)}°`, rows: { point: pt(x, y), lines: `${LA.slopeIntercept} and ${LB.slopeIntercept}`, angle: angleRow, relation: R.isZero(R.add(R.mul(a1, a2), R.mul(b1, b2))) ? 'Perpendicular' : 'Crossing' }, steps: [`${LA.standard} and ${LB.standard}`, `Cramer: D = a₁b₂ − a₂b₁ = ${t(det)}`, `x = (c₁b₂ − c₂b₁) ÷ D = ${t(x)}`, `y = (a₁c₂ − a₂c₁) ÷ D = ${t(y)}`], plots: { graph: linePlot([LA, LB], points2([[x, y]])) } });
    },

    point_line: (i) => {
        const L = readLinear(String(i.eq ?? ''));
        const p = readQ(i, ['px', 'py']);

        if (L.error) {
            return String(i.eq ?? '').trim() ? fail(L.error) : need('Type the equation of the line.');
        }

        if (!p) {
            return need('Enter the point.');
        }

        const [a, b] = L.coef;
        const n2 = R.add(R.mul(a, a), R.mul(b, b));
        const s = R.sub(R.add(R.mul(a, p[0]), R.mul(b, p[1])), L.rhs);
        const dSq = R.div(R.mul(s, s), n2);
        const k = R.div(s, n2);
        const foot = [R.sub(p[0], R.mul(k, a)), R.sub(p[1], R.mul(k, b))];
        const LF = lineForms(L.coef, L.rhs);

        return result(surd(dSq), 'Distance from the point to the line', { sub: isExactRoot(dSq) ? LF.standard : `≈ ${f(sqrt(R.toNumber(dSq)), 12)}`, rows: { distance: surdBoth(dSq), foot: pt(...foot), line: `${LF.standard} (${LF.slopeIntercept})`, side: R.isZero(s) ? 'The point is on the line' : R.sign(s) > 0 ? 'On the side the normal (a, b) points to' : 'On the other side' }, steps: [`Line ${LF.standard}: a = ${t(a)}, b = ${t(b)}, c = ${t(L.rhs)}`, `d = |a x₀ + b y₀ − c| ÷ √(a² + b²) = |${t(s)}| ÷ √${t(n2)}`, `= ${surdBoth(dSq)}`, `Foot of the perpendicular: ${pt(...foot)}`], plots: { graph: { ...linePlot([LF], points2([p, foot])), extra: [points2([p, foot])] } } });
    },

    rate_change: (i) => {
        const text = String(i.fx ?? '').trim();
        const v = readQ(i, ['a', 'b']);

        if (!text || !v) {
            return need('Type f(x) and the interval a to b.');
        }

        const [a, b] = v;

        if (R.eq(a, b)) {
            return fail('a and b must be different.');
        }

        let tree;

        try {
            tree = parse(text.replace(/^f\(x\)\s*=/, ''));
        } catch (e) {
            if (e instanceof ParseError) {
                return fail(e.message);
            }

            throw e;
        }

        const fa = evalExact(tree, { x: a });
        const fb = evalExact(tree, { x: b });
        const na = evalReal(tree, { x: R.toNumber(a) });
        const nb = evalReal(tree, { x: R.toNumber(b) });

        if (!Number.isFinite(na) || !Number.isFinite(nb)) {
            return fail('f is undefined at one of the endpoints.');
        }

        const exact = fa && fb ? R.div(R.sub(fb, fa), R.sub(b, a)) : null;
        const value = exact ? t(exact) : f((nb - na) / (R.toNumber(b) - R.toNumber(a)), 12);
        const xs = Array.from({ length: 121 }, (_, k) => R.toNumber(a) - 1 + ((R.toNumber(b) - R.toNumber(a) + 2) * k) / 120);
        const series = xs.map((x) => [x, evalReal(tree, { x })]);

        return result(value, 'Average rate of change', { sub: `Slope of the secant from x = ${t(a)} to x = ${t(b)}`, rows: { fa: fa ? t(fa) : f(na, 12), fb: fb ? t(fb) : f(nb, 12), secant: exact ? slopeInterceptText(exact, R.sub(fa, R.mul(exact, a))) : `y = ${f((nb - na) / (R.toNumber(b) - R.toNumber(a)), 10)}(x − ${t(a)}) + ${f(na, 10)}`, decimal: f((nb - na) / (R.toNumber(b) - R.toNumber(a)), 12) }, steps: ['Average rate of change = (f(b) − f(a)) ÷ (b − a)', `f(${t(a)}) = ${fa ? t(fa) : f(na, 12)}, f(${t(b)}) = ${fb ? t(fb) : f(nb, 12)}`, `(${fb ? t(fb) : f(nb, 12)} − ${fa ? t(fa) : f(na, 12)}) ÷ (${t(b)} − ${t(a)}) = ${value}`], plots: { graph: { series, extra: [[[R.toNumber(a), na], [R.toNumber(b), nb]]], scatter: [[R.toNumber(a), na], [R.toNumber(b), nb]], axes: true, xLabel: 'x', yLabel: 'f(x)' } } });
    },

    interpolate: (i, c) => {
        if (c.kind === 'bilinear') {
            const [x1, x2, y1, y2, q11, q21, q12, q22, x, y] = [i.x1, i.x2, i.y1, i.y2, i.q11, i.q21, i.q12, i.q22, i.x, i.y].map(Number);

            if (![x1, x2, y1, y2, q11, q21, q12, q22, x, y].every(Number.isFinite)) {
                return need('Enter the grid corners, the four values and the point.');
            }

            if (x1 === x2 || y1 === y2) {
                return fail('The two x values (and the two y values) must differ.');
            }

            const r1 = ((x2 - x) * q11 + (x - x1) * q21) / (x2 - x1);
            const r2 = ((x2 - x) * q12 + (x - x1) * q22) / (x2 - x1);
            const p = ((y2 - y) * r1 + (y - y1) * r2) / (y2 - y1);
            const inside = x >= Math.min(x1, x2) && x <= Math.max(x1, x2) && y >= Math.min(y1, y2) && y <= Math.max(y1, y2);

            return result(f(p, 12), 'Interpolated value', { sub: inside ? 'Inside the grid cell' : 'Outside the cell: this is an extrapolation', rows: { r1: f(r1, 12), r2: f(r2, 12), weights: `${f(((x2 - x) * (y2 - y)) / ((x2 - x1) * (y2 - y1)), 8)}, ${f(((x - x1) * (y2 - y)) / ((x2 - x1) * (y2 - y1)), 8)}, ${f(((x2 - x) * (y - y1)) / ((x2 - x1) * (y2 - y1)), 8)}, ${f(((x - x1) * (y - y1)) / ((x2 - x1) * (y2 - y1)), 8)}` }, steps: [`Along x at y₁: R₁ = ((x₂ − x)Q₁₁ + (x − x₁)Q₂₁) ÷ (x₂ − x₁) = ${f(r1, 12)}`, `Along x at y₂: R₂ = ((x₂ − x)Q₁₂ + (x − x₁)Q₂₂) ÷ (x₂ − x₁) = ${f(r2, 12)}`, `Along y: P = ((y₂ − y)R₁ + (y − y₁)R₂) ÷ (y₂ − y₁) = ${f(p, 12)}`] });
        }

        const v = readQ(i, ['x1', 'y1', 'x2', 'y2', 'x']);

        if (!v) {
            return need('Enter the two known points and the x to interpolate at.');
        }

        const [x1, y1, x2, y2, x] = v;

        if (R.eq(x1, x2)) {
            return fail('The two x values must differ.');
        }

        const y = R.add(y1, R.div(R.mul(R.sub(x, x1), R.sub(y2, y1)), R.sub(x2, x1)));

        return result(R.isInt(y) ? t(y) : `${t(y)} = ${f(R.toNumber(y), 12)}`, 'Interpolated y', { sub: `y = y₁ + (x − x₁)(y₂ − y₁) ÷ (x₂ − x₁)`, rows: { slope: t(R.div(R.sub(y2, y1), R.sub(x2, x1))), fraction: `${t(R.div(R.sub(x, x1), R.sub(x2, x1)))} of the way from x₁ to x₂`, line: slopeInterceptText(R.div(R.sub(y2, y1), R.sub(x2, x1)), R.sub(y1, R.mul(R.div(R.sub(y2, y1), R.sub(x2, x1)), x1))), kind: R.cmp(R.mul(R.sub(x, x1), R.sub(x, x2)), R.ZERO) <= 0 ? 'Interpolation (between the points)' : 'Extrapolation (outside the points)' }, steps: [`Slope = (${t(y2)} − ${t(y1)}) ÷ (${t(x2)} − ${t(x1)}) = ${t(R.div(R.sub(y2, y1), R.sub(x2, x1)))}`, `y = ${t(y1)} + (${t(x)} − ${t(x1)}) × slope = ${t(y)}`], plots: { graph: { ...linePlot([lineForms([R.neg(R.sub(y2, y1)), R.sub(x2, x1)], R.sub(R.mul(R.sub(x2, x1), y1), R.mul(R.sub(y2, y1), x1)))], points2([[x1, y1], [x2, y2], [x, y]])) } } });
    },

    catenary: (i) => {
        const span = Number(i.span);
        const mode = i.given ?? 'sag';
        let a;

        if (!(span > 0)) {
            return need('Enter the span between the supports.');
        }

        const half = span / 2;

        if (mode === 'sag') {
            const sag = Number(i.sag);

            if (!(sag > 0)) {
                return need('Enter the sag.');
            }

            // Solve a(cosh(half/a) − 1) = sag for a (decreasing in a).
            let lo = 1e-9 * span;
            let hi = 1e12 * span;

            for (let k = 0; k < 300; k += 1) {
                const m = sqrt(lo * hi);

                if (m * (cosh(half / m) - 1) > sag) {
                    lo = m;
                } else {
                    hi = m;
                }
            }

            a = sqrt(lo * hi);
        } else if (mode === 'length') {
            const L = Number(i.length);

            if (!(L > span)) {
                return need('The cable must be longer than the span.');
            }

            let lo = 1e-9 * span;
            let hi = 1e12 * span;

            for (let k = 0; k < 300; k += 1) {
                const m = sqrt(lo * hi);

                if (2 * m * sinh(half / m) > L) {
                    lo = m;
                } else {
                    hi = m;
                }
            }

            a = sqrt(lo * hi);
        } else {
            a = Number(i.a);

            if (!(a > 0)) {
                return need('Enter the catenary parameter a.');
            }
        }

        const sag = a * (cosh(half / a) - 1);
        const length = 2 * a * sinh(half / a);
        const angle = Math.atan(sinh(half / a)) / D;
        const series = Array.from({ length: 81 }, (_, k) => {
            const x = -half + (span * k) / 80;

            return [x, a * (cosh(x / a) - 1)];
        });

        return result(f(sag, 10), 'Sag', { sub: `y = a cosh(x/a) with a = ${f(a, 10)}`, rows: { a: f(a, 12), length: f(length, 12), sag: f(sag, 12), angle: `${f(angle, 10)}° at each support`, tension: `Horizontal tension ÷ weight per length = a = ${f(a, 10)}; tension at the supports ÷ weight per length = a cosh(s/2a) = ${f(a * cosh(half / a), 10)}` }, steps: ['A hanging chain takes the shape y = a cosh(x/a), lowest point at x = 0', mode === 'sag' ? `Solve a(cosh(${f(half)}/a) − 1) = ${f(Number(i.sag))} numerically: a = ${f(a, 12)}` : mode === 'length' ? `Solve 2a sinh(${f(half)}/a) = ${f(Number(i.length))}: a = ${f(a, 12)}` : `a = ${f(a)}`, `Sag = a(cosh(s/2a) − 1) = ${f(sag, 12)}`, `Arc length = 2a sinh(s/2a) = ${f(length, 12)}`], plots: { graph: { series: series.map(([x, y]) => [x, y - sag]), axes: false, xLabel: 'x', yLabel: 'height below the supports' } } });
    },

    grid: (i) => {
        const pts = readPoints(i.points);

        if (!pts || !pts.length) {
            return need('Type points as x, y, one per line.');
        }

        const quadrant = ([x, y]) => {
            const sx = R.sign(x);
            const sy = R.sign(y);

            if (sx === 0 && sy === 0) {
                return 'origin';
            }

            if (sx === 0) {
                return 'y-axis';
            }

            if (sy === 0) {
                return 'x-axis';
            }

            return sx > 0 ? (sy > 0 ? 'Quadrant I' : 'Quadrant IV') : sy > 0 ? 'Quadrant II' : 'Quadrant III';
        };
        const list = pts.map((p) => `${pt(...p)}: ${quadrant(p)}`);
        const nums = points2(pts);
        const span = Math.max(1, ...nums.flat().map(abs)) * 1.2;
        let area = null;

        if (pts.length >= 3) {
            let s = R.ZERO;

            for (let k = 0; k < pts.length; k += 1) {
                const [x0, y0] = pts[k];
                const [x1, y1] = pts[(k + 1) % pts.length];
                s = R.add(s, R.sub(R.mul(x0, y1), R.mul(x1, y0)));
            }

            area = R.div(R.qabs(s), R.Q(2));
        }

        return result(`${pts.length} point${pts.length === 1 ? '' : 's'}`, 'Plotted points', { sub: list.slice(0, 3).join('; '), rows: { quadrants: list.join('; '), box: `x from ${f(Math.min(...nums.map((p) => p[0])))} to ${f(Math.max(...nums.map((p) => p[0])))}, y from ${f(Math.min(...nums.map((p) => p[1])))} to ${f(Math.max(...nums.map((p) => p[1])))}`, area: area ? `${t(area)} (polygon through the points in order)` : 'Enter three or more points for an area' }, steps: ['Quadrant I: x > 0, y > 0; II: x < 0, y > 0; III: x < 0, y < 0; IV: x > 0, y < 0', ...list], plots: { diagram: { kind: 'diagram', shapes: [{ points: [[-span, 0], [span, 0]], muted: true }, { points: [[0, -span], [0, span]], muted: true }, ...(pts.length >= 3 ? [{ points: [...nums, nums[0]], closed: true, dashed: true }] : [])], dots: nums, labels: nums.slice(0, 15).map(([x, y], k) => ({ x, y: y + span * 0.07, text: pt(...pts[k]) })) } } });
    },

    vector: (i, c) => {
        const op = c.op ?? i.op ?? 'add';
        const u = readVec(i.u);
        const v = ['add', 'sub', 'dot', 'cross', 'cosine', 'projection', 'angle', 'triple'].includes(op) ? readVec(i.v) : null;
        const w = op === 'triple' ? readVec(i.w) : null;
        const k = q(i.k ?? '1');

        if (!u) {
            return need('Enter the vector u, such as 3, 4 or 1, −2, 2.');
        }

        if (['add', 'sub', 'dot', 'cosine', 'projection', 'angle'].includes(op) && (!v || v.length !== u.length)) {
            return need('Enter v with the same number of components as u.');
        }

        if ((op === 'cross' || op === 'triple') && (u.length !== 3 || !v || v.length !== 3 || (op === 'triple' && (!w || w.length !== 3)))) {
            return need(op === 'triple' ? 'Enter three 3D vectors.' : 'The cross product needs two 3D vectors.');
        }

        const nu2 = norm2(u);
        const nu = surd(nu2);
        const rows = { u: `${vecText(u)}, |u| = ${surdBoth(nu2)}` };
        const steps = [];
        let value;
        let label;
        let sub = '';

        if (op === 'add' || op === 'sub') {
            const kk = k ?? R.ONE;
            const r = u.map((x, j) => (op === 'add' ? R.add(x, R.mul(kk, v[j])) : R.sub(x, R.mul(kk, v[j]))));
            value = vecText(r);
            label = op === 'add' ? (R.eq(kk, R.ONE) ? 'u + v' : `u + ${t(kk)}v`) : R.eq(kk, R.ONE) ? 'u − v' : `u − ${t(kk)}v`;
            sub = `|result| = ${surdBoth(norm2(r))}`;
            rows.v = `${vecText(v)}, |v| = ${surdBoth(norm2(v))}`;
            rows.result = value;
            rows.extra = `u − v = ${vecText(u.map((x, j) => R.sub(x, v[j])))}; u + v = ${vecText(u.map((x, j) => R.add(x, v[j])))}`;
            steps.push(`Add component by component: ${u.map((x, j) => `${t(x)} ${op === 'add' ? '+' : '−'} ${R.eq(kk, R.ONE) ? '' : `${t(kk)} × `}${t(v[j])}`).join(', ')}`, `= ${value}`);
        } else if (op === 'dot' || op === 'cosine' || op === 'angle') {
            const d = dotQ(u, v);
            const nv2 = norm2(v);
            const cosv = R.toNumber(d) / sqrt(R.toNumber(nu2) * R.toNumber(nv2));
            rows.v = `${vecText(v)}, |v| = ${surdBoth(nv2)}`;
            rows.result = t(d);
            rows.extra = `cos θ = ${f(cosv, 12)}, θ = ${f(Math.acos(Math.max(-1, Math.min(1, cosv))) / D, 10)}°`;

            if (R.isZero(nu2) || R.isZero(nv2)) {
                return fail('A zero vector has no direction.');
            }

            if (op === 'dot') {
                value = t(d);
                label = 'Dot product u · v';
                sub = R.isZero(d) ? 'Perpendicular (u · v = 0)' : rows.extra;
            } else if (op === 'cosine') {
                // cos² is rational, so the cosine is exact as ± surd.
                const c2 = R.div(R.mul(d, d), R.mul(nu2, nv2));
                value = `${R.sign(d) < 0 ? '−' : ''}${surd(c2)}`;
                label = 'Cosine similarity';
                sub = `≈ ${f(cosv, 12)}; angle ${f(Math.acos(Math.max(-1, Math.min(1, cosv))) / D, 8)}°`;
                rows.result = value;
            } else {
                value = f(Math.acos(Math.max(-1, Math.min(1, cosv))) / D, 12);
                label = 'Angle between u and v (°)';
                sub = `${f(Math.acos(Math.max(-1, Math.min(1, cosv))), 12)} rad`;
            }

            steps.push(`u · v = ${u.map((x, j) => `${t(x)} × ${t(v[j])}`).join(' + ')} = ${t(d)}`, `|u| = ${surdBoth(nu2)}, |v| = ${surdBoth(nv2)}`, `cos θ = u · v ÷ (|u||v|) = ${f(cosv, 12)}`);
        } else if (op === 'cross') {
            const r = crossQ(u, v);
            value = vecText(r);
            label = 'Cross product u × v';
            sub = `|u × v| = ${surdBoth(norm2(r))} (area of the parallelogram)`;
            rows.v = `${vecText(v)}, |v| = ${surdBoth(norm2(v))}`;
            rows.result = value;
            rows.extra = `Perpendicular to both: u · (u × v) = ${t(dotQ(u, r))}, v · (u × v) = ${t(dotQ(v, r))}; triangle area ${surdBoth(R.div(norm2(r), R.Q(4)))}`;
            steps.push('u × v = (u₂v₃ − u₃v₂, u₃v₁ − u₁v₃, u₁v₂ − u₂v₁)', `= (${t(u[1])}·${t(v[2])} − ${t(u[2])}·${t(v[1])}, ${t(u[2])}·${t(v[0])} − ${t(u[0])}·${t(v[2])}, ${t(u[0])}·${t(v[1])} − ${t(u[1])}·${t(v[0])})`, `= ${value}`);
        } else if (op === 'triple') {
            const r = dotQ(u, crossQ(v, w));
            value = t(R.qabs(r));
            label = 'Volume of the parallelepiped';
            sub = `Scalar triple product u · (v × w) = ${t(r)}`;
            rows.v = `${vecText(v)}, w = ${vecText(w)}`;
            rows.result = t(r);
            rows.extra = R.isZero(r) ? 'The vectors are coplanar (volume 0)' : `Tetrahedron on the same edges: ${t(R.div(R.qabs(r), R.Q(6)))}; orientation ${R.sign(r) > 0 ? 'right-handed' : 'left-handed'}`;
            steps.push(`v × w = ${vecText(crossQ(v, w))}`, `u · (v × w) = ${t(r)}`, `Volume = |${t(r)}| = ${value}`);
        } else if (op === 'projection') {
            const nv2 = norm2(v);

            if (R.isZero(nv2)) {
                return fail('Cannot project onto the zero vector.');
            }

            const d = dotQ(u, v);
            const s = R.div(d, nv2);
            const proj = v.map((x) => R.mul(s, x));
            const perp = u.map((x, j) => R.sub(x, proj[j]));
            value = vecText(proj);
            label = 'Projection of u onto v';
            sub = `Scalar projection ${R.sign(d) < 0 ? '−' : ''}${surd(R.div(R.mul(d, d), nv2))}`;
            rows.v = `${vecText(v)}, |v| = ${surdBoth(nv2)}`;
            rows.result = value;
            rows.extra = `Component of u perpendicular to v: ${vecText(perp)}`;
            steps.push(`proj_v u = (u · v ÷ |v|²) v = (${t(d)} ÷ ${t(nv2)}) v`, `= ${t(s)} × ${vecText(v)} = ${value}`, `u − proj = ${vecText(perp)} (perpendicular to v)`);
        } else if (op === 'magnitude') {
            value = surd(nu2);
            label = 'Magnitude |u|';
            sub = isExactRoot(nu2) ? `√${t(nu2)}` : `≈ ${f(sqrt(R.toNumber(nu2)), 12)}`;
            rows.result = surdBoth(nu2);
            rows.extra = `Unit vector ${u.map((x) => `${t(x)}/${nu}`).join(', ')}`;
            steps.push(`|u| = √(${u.map((x) => `(${t(x)})²`).join(' + ')}) = √${t(nu2)} = ${surdBoth(nu2)}`);
        } else if (op === 'unit') {
            if (R.isZero(nu2)) {
                return fail('The zero vector has no direction.');
            }

            const parts = u.map((x) => {
                const sq = R.div(R.mul(x, x), nu2);

                return `${R.sign(x) < 0 ? '−' : ''}${surd(sq)}`;
            });
            value = `⟨${parts.join(', ')}⟩`;
            label = 'Unit vector û';
            sub = `≈ ⟨${u.map((x) => f(R.toNumber(x) / sqrt(R.toNumber(nu2)), 8)).join(', ')}⟩`;
            rows.result = value;
            rows.extra = `Length check: ${f(u.reduce((s, x) => s + (R.toNumber(x) / sqrt(R.toNumber(nu2))) ** 2, 0), 12)}`;
            steps.push(`|u| = ${surdBoth(nu2)}`, `û = u ÷ |u| = ${value}`);
        } else {
            // Direction: angle in 2D, direction cosines and angles in 3D.
            const n = sqrt(R.toNumber(nu2));

            if (!n) {
                return fail('The zero vector has no direction.');
            }

            if (u.length === 2) {
                const ang = ((atan2(R.toNumber(u[1]), R.toNumber(u[0])) / D) + 360) % 360;
                value = f(ang, 12);
                label = 'Direction angle (°, from the +x axis)';
                sub = `Bearing ${f((450 - ang) % 360, 10)}° (clockwise from north)`;
                rows.result = `${f(ang, 12)}° = ${f(ang * D, 12)} rad`;
                rows.extra = `tan θ = ${t(R.isZero(u[0]) ? R.ZERO : R.div(u[1], u[0]))}${R.isZero(u[0]) ? ' (vertical)' : ''}`;
                steps.push(`θ = atan2(${t(u[1])}, ${t(u[0])}) = ${f(ang, 12)}°`);
            } else {
                const angles = u.map((x) => Math.acos(R.toNumber(x) / n) / D);
                value = angles.map((a) => `${f(a, 8)}°`).join(', ');
                label = 'Direction angles α, β, γ';
                sub = `Direction cosines ${u.map((x) => f(R.toNumber(x) / n, 8)).join(', ')}`;
                rows.result = value;
                rows.extra = `cos²α + cos²β + cos²γ = ${f(u.reduce((s, x) => s + (R.toNumber(x) / n) ** 2, 0), 12)}`;
                steps.push(`|u| = ${surdBoth(nu2)}`, ...u.map((x, j) => `${'αβγ'[j]} = acos(${t(x)} ÷ |u|) = ${f(angles[j], 12)}°`));
            }
        }

        const plot = u.length === 2 && (!v || v.length === 2) ? { diagram: { kind: 'diagram', shapes: [{ points: [[0, 0], points2([u])[0]] }, ...(v ? [{ points: [[0, 0], points2([v])[0]], muted: true }] : []), { points: [[-0.5, 0], [0.5, 0]], muted: true }], dots: [points2([u])[0], ...(v ? [points2([v])[0]] : [])], labels: [{ ...{ x: R.toNumber(u[0]) * 1.08, y: R.toNumber(u[1]) * 1.08 }, text: 'u' }, ...(v ? [{ x: R.toNumber(v[0]) * 1.08, y: R.toNumber(v[1]) * 1.08, text: 'v' }] : [])] } } : undefined;

        return result(value, label, { sub, rows: { result: rows.result ?? value, u: rows.u, v: rows.v ?? 'Not used', extra: rows.extra ?? '' }, steps, plots: plot });
    },

    convert_coords: (i, c) => {
        const system = c.system ?? 'polar';
        const dir = c.dir ?? i.dir ?? 'to';
        const n = (k) => Number(i[k]);

        if (system === 'polar') {
            if (dir === 'to') {
                const v = readQ(i, ['x', 'y']);

                if (!v) {
                    return need('Enter x and y.');
                }

                const r2 = R.add(R.mul(v[0], v[0]), R.mul(v[1], v[1]));
                const th = atan2(R.toNumber(v[1]), R.toNumber(v[0]));
                const deg = ((th / D) + 360) % 360;

                return result(`(${surd(r2)}, ${f(deg, 10)}°)`, 'Polar coordinates (r, θ)', { sub: `r = ${surdBoth(r2)}, θ = ${f(th, 12)} rad`, rows: { r: surdBoth(r2), theta: `${f(deg, 12)}° = ${f(deg * D, 12)} rad`, other: `Also (${surd(r2)}, ${f(deg - 360, 10)}°) or (−${surd(r2)}, ${f((deg + 180) % 360, 10)}°)`, back: `x = r cos θ = ${t(v[0])}, y = r sin θ = ${t(v[1])}` }, steps: [`r = √(x² + y²) = √(${t(v[0])}² + ${t(v[1])}²) = ${surdBoth(r2)}`, `θ = atan2(y, x) = ${f(deg, 12)}°`], plots: { diagram: { kind: 'diagram', shapes: [{ points: [[0, 0], points2([v])[0]] }, { points: [[0, 0], [Math.max(1, sqrt(R.toNumber(r2))) * 0.3, 0]], muted: true }], dots: points2([v]), labels: [{ x: R.toNumber(v[0]), y: R.toNumber(v[1]) * 1.12 + 0.2, text: pt(...v) }] } } });
            }

            const [r, deg] = [n('r'), n('theta')];

            if (![r, deg].every(Number.isFinite)) {
                return need('Enter r and θ.');
            }

            const [x, y] = [r * cos(deg * D), r * sin(deg * D)];

            return result(`(${f(x, 10)}, ${f(y, 10)})`, 'Cartesian coordinates (x, y)', { sub: `From r = ${f(r)}, θ = ${f(deg)}°`, rows: { r: f(r), theta: `${f(deg)}° = ${f(deg * D, 12)} rad`, other: `Quadrant ${x >= 0 ? (y >= 0 ? 'I' : 'IV') : y >= 0 ? 'II' : 'III'}`, back: `x = ${f(x, 12)}, y = ${f(y, 12)}` }, steps: [`x = r cos θ = ${f(r)} × cos ${f(deg)}° = ${f(x, 12)}`, `y = r sin θ = ${f(r)} × sin ${f(deg)}° = ${f(y, 12)}`], plots: { diagram: { kind: 'diagram', shapes: [{ points: [[0, 0], [x, y]] }, { points: [[0, 0], [abs(r) * 0.3, 0]], muted: true }], dots: [[x, y]] } } });
        }

        if (system === 'cylindrical') {
            if (dir === 'to') {
                const [x, y, z] = [n('x'), n('y'), n('z')];

                if (![x, y, z].every(Number.isFinite)) {
                    return need('Enter x, y and z.');
                }

                const r = hypot(x, y);
                const deg = ((atan2(y, x) / D) + 360) % 360;

                return result(`(${f(r, 10)}, ${f(deg, 10)}°, ${f(z)})`, 'Cylindrical (r, θ, z)', { sub: `θ = ${f(deg * D, 12)} rad`, rows: { r: f(r, 12), theta: `${f(deg, 12)}°`, z: f(z), spherical: `ρ = ${f(hypot(x, y, z), 12)}, φ = ${f(Math.acos(z / (hypot(x, y, z) || 1)) / D, 10)}°` }, steps: [`r = √(x² + y²) = ${f(r, 12)}`, `θ = atan2(y, x) = ${f(deg, 12)}°`, `z stays ${f(z)}`] });
            }

            const [r, deg, z] = [n('r'), n('theta'), n('z')];

            if (![r, deg, z].every(Number.isFinite)) {
                return need('Enter r, θ and z.');
            }

            return result(`(${f(r * cos(deg * D), 10)}, ${f(r * sin(deg * D), 10)}, ${f(z)})`, 'Cartesian (x, y, z)', { sub: `From (${f(r)}, ${f(deg)}°, ${f(z)})`, rows: { r: f(r), theta: `${f(deg)}°`, z: f(z), spherical: `ρ = ${f(hypot(r, z), 12)}` }, steps: [`x = r cos θ = ${f(r * cos(deg * D), 12)}`, `y = r sin θ = ${f(r * sin(deg * D), 12)}`, `z = ${f(z)}`] });
        }

        if (dir === 'to') {
            const [x, y, z] = [n('x'), n('y'), n('z')];

            if (![x, y, z].every(Number.isFinite)) {
                return need('Enter x, y and z.');
            }

            const rho = hypot(x, y, z);
            const th = ((atan2(y, x) / D) + 360) % 360;
            const ph = rho ? Math.acos(z / rho) / D : 0;

            return result(`(${f(rho, 10)}, ${f(th, 10)}°, ${f(ph, 10)}°)`, 'Spherical (ρ, θ, φ)', { sub: 'θ around the z-axis from +x; φ down from +z (physics: swap the names)', rows: { r: `ρ = ${f(rho, 12)}`, theta: `θ (azimuth) = ${f(th, 12)}°`, z: `φ (polar) = ${f(ph, 12)}°`, spherical: `Latitude ${f(90 - ph, 10)}°, longitude ${f(th > 180 ? th - 360 : th, 10)}°` }, steps: [`ρ = √(x² + y² + z²) = ${f(rho, 12)}`, `θ = atan2(y, x) = ${f(th, 12)}°`, `φ = acos(z ÷ ρ) = ${f(ph, 12)}°`] });
        }

        const [rho, th, ph] = [n('rho'), n('theta'), n('phi')];

        if (![rho, th, ph].every(Number.isFinite)) {
            return need('Enter ρ, θ and φ.');
        }

        const [x, y, z] = [rho * sin(ph * D) * cos(th * D), rho * sin(ph * D) * sin(th * D), rho * cos(ph * D)];

        return result(`(${f(x, 10)}, ${f(y, 10)}, ${f(z, 10)})`, 'Cartesian (x, y, z)', { sub: `From ρ = ${f(rho)}, θ = ${f(th)}°, φ = ${f(ph)}°`, rows: { r: `x = ${f(x, 12)}`, theta: `y = ${f(y, 12)}`, z: `z = ${f(z, 12)}`, spherical: `Cylindrical r = ρ sin φ = ${f(rho * sin(ph * D), 12)}` }, steps: [`x = ρ sin φ cos θ = ${f(x, 12)}`, `y = ρ sin φ sin θ = ${f(y, 12)}`, `z = ρ cos φ = ${f(z, 12)}`] });
    },

    plane: (i, c) => {
        const given = c.given ?? i.given ?? 'points';
        let normal;
        let point;
        const steps = [];

        if (given === 'points') {
            const A = readVec(i.p1);
            const B = readVec(i.p2);
            const C = readVec(i.p3);

            if (![A, B, C].every((p) => p && p.length === 3)) {
                return need('Enter three points as x, y, z.');
            }

            const ab = B.map((x, k) => R.sub(x, A[k]));
            const ac = C.map((x, k) => R.sub(x, A[k]));
            normal = crossQ(ab, ac);

            if (normal.every((x) => R.isZero(x))) {
                return fail('The three points lie on a line, so they do not fix a plane.');
            }

            point = A;
            steps.push(`AB = ${vecText(ab)}, AC = ${vecText(ac)}`, `Normal n = AB × AC = ${vecText(normal)}`);
        } else {
            point = readVec(i.p1);
            normal = readVec(i.normal);

            if (!point || point.length !== 3 || !normal || normal.length !== 3 || normal.every((x) => R.isZero(x))) {
                return need('Enter a point (x, y, z) and a non-zero normal vector.');
            }
        }

        const d = dotQ(normal, point);
        const ints = normalise(normal, d);
        const eq = standardText(ints, ['x', 'y', 'z']);
        const intercepts = ['x', 'y', 'z'].map((name, k) => (ints[k] === 0n ? `no ${name}-intercept` : `${name} = ${t(R.Q(ints[3], ints[k]))}`)).join(', ');
        const n2 = ints.slice(0, 3).reduce((s, v) => s + v * v, 0n);
        steps.push(`Plane: n · (r − P) = 0 → ${eq}`);

        return result(eq, 'Equation of the plane', { sub: `Normal ⟨${ints.slice(0, 3).map(bigText).join(', ')}⟩`, rows: { equation: eq, normal: `⟨${ints.slice(0, 3).map(bigText).join(', ')}⟩, |n| = ${surdBoth(R.Q(n2))}`, intercepts, origin: `Distance from the origin ${surdBoth(R.Q(ints[3] * ints[3], n2))}` }, steps });
    },

    point_plane: (i) => {
        const L = readLinear(String(i.eq ?? ''), ['x', 'y', 'z']);
        const p = readVec(i.p);

        if (L.error) {
            return String(i.eq ?? '').trim() ? fail(L.error) : need('Type the plane, such as 2x − y + 2z = 6.');
        }

        if (!p || p.length !== 3) {
            return need('Enter the point as x, y, z.');
        }

        const n2 = norm2(L.coef);
        const s = R.sub(dotQ(L.coef, p), L.rhs);
        const dSq = R.div(R.mul(s, s), n2);
        const k = R.div(s, n2);
        const foot = p.map((x, j) => R.sub(x, R.mul(k, L.coef[j])));

        return result(surd(dSq), 'Distance from the point to the plane', { sub: isExactRoot(dSq) ? `|${t(s)}| ÷ √${t(n2)}` : `≈ ${f(sqrt(R.toNumber(dSq)), 12)}`, rows: { distance: surdBoth(dSq), foot: `(${foot.map((x) => t(x)).join(', ')})`, plane: standardText(normalise(L.coef, L.rhs), ['x', 'y', 'z']), side: R.isZero(s) ? 'On the plane' : R.sign(s) > 0 ? 'On the side the normal points to' : 'On the opposite side' }, steps: [`d = |a x₀ + b y₀ + c z₀ − d| ÷ √(a² + b² + c²)`, `= |${t(s)}| ÷ √${t(n2)} = ${surdBoth(dSq)}`, `Nearest point on the plane: (${foot.map((x) => t(x)).join(', ')})`] });
    },

    planes_line: (i) => {
        const A = readLinear(String(i.eq1 ?? ''), ['x', 'y', 'z']);
        const B = readLinear(String(i.eq2 ?? ''), ['x', 'y', 'z']);

        if (A.error || B.error) {
            return String(i.eq1 ?? '').trim() && String(i.eq2 ?? '').trim() ? fail(A.error ?? B.error) : need('Type both plane equations.');
        }

        const dir = crossQ(A.coef, B.coef);
        const cosT = abs(R.toNumber(dotQ(A.coef, B.coef))) / sqrt(R.toNumber(norm2(A.coef)) * R.toNumber(norm2(B.coef)));

        if (dir.every((x) => R.isZero(x))) {
            const same = A.coef.every((x, k) => R.isZero(R.sub(R.mul(x, B.rhs), R.mul(B.coef[k], A.rhs))));

            return result(same ? 'Same plane' : 'Parallel planes', 'No single line', { sub: same ? 'The equations describe the same plane' : 'The normals are parallel, so the planes never meet', rows: { direction: 'None', point: 'None', param: 'None', angle: '0°' }, steps: ['n₁ × n₂ = 0: the normals are parallel'] });
        }

        // A point on the line: set the coordinate with the largest direction component to 0 and solve the 2 × 2 system.
        const k = [0, 1, 2].reduce((best, j) => (R.cmp(R.qabs(dir[j]), R.qabs(dir[best])) > 0 ? j : best), 0);
        const [p, qd] = [0, 1, 2].filter((j) => j !== k);
        const det = R.sub(R.mul(A.coef[p], B.coef[qd]), R.mul(A.coef[qd], B.coef[p]));
        const point = [R.ZERO, R.ZERO, R.ZERO];
        point[p] = R.div(R.sub(R.mul(A.rhs, B.coef[qd]), R.mul(B.rhs, A.coef[qd])), det);
        point[qd] = R.div(R.sub(R.mul(A.coef[p], B.rhs), R.mul(B.coef[p], A.rhs)), det);
        const dInts = normalise(dir, R.ZERO).slice(0, 3);
        const param = ['x', 'y', 'z'].map((name, j) => {
            const mag = dInts[j] < 0n ? -dInts[j] : dInts[j];
            const tt = `${mag === 1n ? '' : mag}t`;

            if (dInts[j] === 0n) {
                return `${name} = ${t(point[j])}`;
            }

            return R.isZero(point[j]) ? `${name} = ${dInts[j] < 0n ? '−' : ''}${tt}` : `${name} = ${t(point[j])} ${dInts[j] < 0n ? '−' : '+'} ${tt}`;
        }).join(', ');

        return result(param, 'Line of intersection', { sub: `Direction ⟨${dInts.map(bigText).join(', ')}⟩ through (${point.map((x) => t(x)).join(', ')})`, rows: { direction: `⟨${dInts.map(bigText).join(', ')}⟩ (n₁ × n₂ = ${vecText(dir)})`, point: `(${point.map((x) => t(x)).join(', ')})`, param, angle: `${f(Math.acos(Math.min(1, cosT)) / D, 10)}° between the planes` }, steps: [`Direction = n₁ × n₂ = ${vecText(dir)}`, `Set ${'xyz'[k]} = 0 and solve the two equations: point (${point.map((x) => t(x)).join(', ')})`, `Line: ${param}`] });
    },

    sphere_eq: (i, c) => {
        const given = c.given ?? i.given ?? 'center';
        let h;
        let k;
        let l;
        let r2;

        if (given === 'center') {
            const v = readQ(i, ['h', 'k', 'l', 'r']);

            if (!v || R.sign(v[3]) <= 0) {
                return need('Enter the centre (h, k, l) and a positive radius.');
            }

            [h, k, l] = v;
            r2 = R.mul(v[3], v[3]);
        } else {
            const text = String(i.eq ?? '');
            let tree;

            try {
                tree = parse(text);
            } catch (e) {
                return e instanceof ParseError ? fail(e.message) : (() => { throw e; })();
            }

            const F = (x, y, z) => {
                const env = { x: R.Q(x), y: R.Q(y), z: R.Q(z) };

                if (tree.t === 'rel') {
                    const a = evalExact(tree.parts[0], env);
                    const b = evalExact(tree.parts[1], env);

                    return a && b ? R.sub(a, b) : null;
                }

                return evalExact(tree, env);
            };
            const f0 = F(0, 0, 0);

            if (!f0) {
                return text.trim() ? fail('Use numbers and fractions only.') : need('Type the equation of the sphere.');
            }

            const sq = [[1, 0, 0], [0, 1, 0], [0, 0, 1]].map(([x, y, z]) => R.div(R.sub(R.add(F(x, y, z), F(-x, -y, -z)), R.mul(R.Q(2), f0)), R.Q(2)));
            const lin = [[1, 0, 0], [0, 1, 0], [0, 0, 1]].map(([x, y, z]) => R.div(R.sub(F(x, y, z), F(-x, -y, -z)), R.Q(2)));

            if (!sq.every((s) => R.eq(s, sq[0])) || R.isZero(sq[0])) {
                return fail('For a sphere the x², y² and z² coefficients must be equal.');
            }

            const A = sq[0];
            [h, k, l] = lin.map((L) => R.neg(R.div(L, R.mul(R.Q(2), A))));
            r2 = R.sub(R.add(R.add(R.mul(h, h), R.mul(k, k)), R.mul(l, l)), R.div(f0, A));
            const check = F(2, 3, 5);
            const predicted = R.add(R.mul(A, R.Q(4 + 9 + 25)), R.add(R.add(R.mul(lin[0], R.Q(2)), R.mul(lin[1], R.Q(3))), R.add(R.mul(lin[2], R.Q(5)), f0)));

            if (!check || !R.eq(check, predicted)) {
                return fail('This is not the equation of a sphere (cross terms or higher powers found).');
            }

            if (R.sign(r2) <= 0) {
                return fail(R.isZero(r2) ? 'The radius is 0: a single point.' : 'No real sphere: r² comes out negative.');
            }
        }

        const sh = (v, n) => (R.isZero(v) ? `${n}²` : `(${n} ${R.sign(v) > 0 ? '−' : '+'} ${t(R.qabs(v))})²`);
        const standard = `${sh(h, 'x')} + ${sh(k, 'y')} + ${sh(l, 'z')} = ${t(r2)}`;
        const F0 = R.sub(R.add(R.add(R.mul(h, h), R.mul(k, k)), R.mul(l, l)), r2);
        const term = (v, s) => (R.isZero(v) ? '' : ` ${R.sign(v) < 0 ? '−' : '+'} ${t(R.qabs(v))}${s}`);
        const general = `x² + y² + z²${term(R.mul(R.Q(-2), h), 'x')}${term(R.mul(R.Q(-2), k), 'y')}${term(R.mul(R.Q(-2), l), 'z')}${term(F0, '')} = 0`;
        const r = sqrt(R.toNumber(r2));
        const want = c.want ?? 'standard';

        return result(want === 'center' ? `(${t(h)}, ${t(k)}, ${t(l)})` : standard, want === 'center' ? 'Centre' : 'Standard equation', { sub: `Centre (${t(h)}, ${t(k)}, ${t(l)}), radius ${surdBoth(r2)}`, rows: { standard, general, center: `(${t(h)}, ${t(k)}, ${t(l)})`, radius: surdBoth(r2), volume: `V = (4/3)πr³ = ${f((4 / 3) * PI * r ** 3, 12)}; A = 4πr² = ${f(4 * PI * r * r, 12)}` }, steps: [given === 'center' ? '(x − h)² + (y − k)² + (z − l)² = r²' : 'Complete the square in x, y and z', `Centre (${t(h)}, ${t(k)}, ${t(l)}), r² = ${t(r2)}`, `Standard: ${standard}`, `General: ${general}`] });
    },

    poly_area: (i) => {
        const pts = readPoints(i.points);

        if (!pts || pts.length < 3) {
            return need('Type at least three vertices in order, one "x, y" per line.');
        }

        const terms = pts.map((p, k) => {
            const q2 = pts[(k + 1) % pts.length];

            return R.sub(R.mul(p[0], q2[1]), R.mul(q2[0], p[1]));
        });
        const s = terms.reduce((a, b) => R.add(a, b), R.ZERO);
        const area = R.div(R.qabs(s), R.Q(2));
        const perim = pts.reduce((sum, p, k) => {
            const q2 = pts[(k + 1) % pts.length];

            return sum + hypot(R.toNumber(R.sub(q2[0], p[0])), R.toNumber(R.sub(q2[1], p[1])));
        }, 0);

        return result(R.isInt(area) ? t(area) : `${t(area)} = ${f(R.toNumber(area), 12)}`, 'Area', { sub: `Shoelace formula over ${pts.length} vertices`, rows: { area: t(area), perim: f(perim, 12), orientation: R.sign(s) > 0 ? 'Counter-clockwise' : 'Clockwise', terms: terms.map((x) => t(x)).join(' + ') }, steps: ['A = ½|Σ (xᵢyᵢ₊₁ − xᵢ₊₁yᵢ)|', ...pts.map((p, k) => `${pt(...p)} → ${pt(...pts[(k + 1) % pts.length])}: ${t(terms[k])}`), `Sum ${t(s)}, area = |${t(s)}| ÷ 2 = ${t(area)}`], plots: { diagram: { kind: 'diagram', shapes: [{ points: [...points2(pts), points2(pts)[0]], closed: true }], dots: points2(pts) } } });
    },

    regression: (i, c) => {
        const pts = String(i.points ?? '').split(/\n|;/).map((l) => l.trim()).filter(Boolean).map((l) => l.split(/[,\s]+/).filter(Boolean).map((x) => Number(x.replace('−', '-'))));

        if (pts.length < 2 || pts.some((p) => p.length !== 2 || p.some((x) => !Number.isFinite(x)))) {
            return need('Type at least two points as x, y, one per line.');
        }

        const r = regression(pts);

        if (!(r.sxx > 0)) {
            return fail('All x values are equal, so the line would be vertical.');
        }

        const xs = pts.map((p) => p[0]);
        const lo = Math.min(...xs);
        const hi = Math.max(...xs);
        const pad = (hi - lo) * 0.1 || 1;
        const eq = `y = ${f(r.m, 10)}x ${r.b < 0 ? '−' : '+'} ${f(abs(r.b), 10)}`;
        const x0 = Number(i.x0);
        const predict = Number.isFinite(x0) && String(i.x0 ?? '') !== '' ? `At x = ${f(x0)}: y = ${f(r.m * x0 + r.b, 10)}` : 'Enter an x to predict';
        const strength = abs(r.r) > 0.9 ? 'very strong' : abs(r.r) > 0.7 ? 'strong' : abs(r.r) > 0.4 ? 'moderate' : abs(r.r) > 0.2 ? 'weak' : 'little or no';
        const rows = { equation: eq, r: f(r.r, 10), r2: f(r.r2, 10), means: `x̄ = ${f(r.mx, 10)}, ȳ = ${f(r.my, 10)}`, se: Number.isFinite(r.se) ? f(r.se, 10) : 'Needs three or more points', predict, count: String(r.n) };

        return result(c.mode === 'scatter' ? `r = ${f(r.r, 6)}` : eq, c.mode === 'scatter' ? 'Correlation' : 'Least squares line', { sub: c.mode === 'scatter' ? `${strength.replace(/^./, (ch) => ch.toUpperCase())} ${r.r >= 0 ? 'positive' : 'negative'} linear relationship; trend ${eq}` : `r = ${f(r.r, 8)}, r² = ${f(r.r2, 8)}`, rows, steps: [`n = ${r.n}, x̄ = ${f(r.mx, 12)}, ȳ = ${f(r.my, 12)}`, `Sxx = Σ(x − x̄)² = ${f(r.sxx, 12)}, Sxy = Σ(x − x̄)(y − ȳ) = ${f(r.sxy, 12)}`, `Slope m = Sxy ÷ Sxx = ${f(r.m, 12)}`, `Intercept b = ȳ − m x̄ = ${f(r.b, 12)}`, `r = Sxy ÷ √(Sxx Syy) = ${f(r.r, 12)}`], plots: { graph: { series: [[lo - pad, r.m * (lo - pad) + r.b], [hi + pad, r.m * (hi + pad) + r.b]], scatter: pts, xLabel: 'x', yLabel: 'y' } } });
    },

    parabola: (i, c) => {
        const given = c.given ?? i.given ?? 'standard';
        let a;
        let h;
        let k;

        if (given === 'standard') {
            const v = readQ(i, ['a', 'b', 'c']);

            if (!v || R.isZero(v[0])) {
                return need('Enter a (not 0), b and c.');
            }

            [a] = v;
            h = R.div(R.neg(v[1]), R.mul(R.Q(2), a));
            k = R.sub(v[2], R.div(R.mul(v[1], v[1]), R.mul(R.Q(4), a)));
        } else if (given === 'vertex') {
            const v = readQ(i, ['a', 'h', 'k']);

            if (!v || R.isZero(v[0])) {
                return need('Enter a (not 0) and the vertex (h, k).');
            }

            [a, h, k] = v;
        } else {
            const v = readQ(i, ['fx', 'fy', 'dy']);

            if (!v || R.eq(v[1], v[2])) {
                return need('Enter the focus and a directrix y = d that does not pass through it.');
            }

            const [fx, fy, dy] = v;
            const p = R.div(R.sub(fy, dy), R.Q(2));
            h = fx;
            k = R.div(R.add(fy, dy), R.Q(2));
            a = R.div(R.ONE, R.mul(R.Q(4), p));
        }

        const b = R.mul(R.Q(-2), R.mul(a, h));
        const cc = R.add(R.mul(a, R.mul(h, h)), k);
        const p = R.div(R.ONE, R.mul(R.Q(4), a));
        const disc = R.sub(R.mul(b, b), R.mul(R.Q(4), R.mul(a, cc)));
        const roots = R.sign(disc) < 0 ? 'None (no real x-intercepts)' : R.isZero(disc) ? `x = ${t(h)} (touches the axis)` : P.quadraticRoots(a, b, cc).exact.map((s) => `x = ${s}`).join(', ');
        const sh = (v, n) => (R.isZero(v) ? n : `(${n} ${R.sign(v) > 0 ? '−' : '+'} ${t(R.qabs(v))})`);
        const aText = R.eq(a, R.ONE) ? '' : R.eq(a, R.neg(R.ONE)) ? '−' : R.isInt(a) ? t(a) : `(${t(a)})`;
        const vertexForm = `y = ${aText}${sh(h, 'x')}²${R.isZero(k) ? '' : ` ${R.sign(k) < 0 ? '−' : '+'} ${t(R.qabs(k))}`}`;
        const standardForm = `y = ${P.toText([cc, b, a], 'x')}`;
        const rows = { vertex: pt(h, k), standard: standardForm, vertexForm, focus: pt(h, R.add(k, p)), directrix: `y = ${t(R.sub(k, p))}`, axis: `x = ${t(h)}`, roots, yint: `(0, ${t(cc)})`, latus: `${t(R.qabs(R.mul(R.Q(4), p)))} (the chord through the focus)`, opens: R.sign(a) > 0 ? 'Upwards (minimum at the vertex)' : 'Downwards (maximum at the vertex)' };
        const want = c.want ?? 'vertex';
        const H = R.toNumber(h);
        const span = Math.max(3, abs(R.toNumber(p)) * 8, ...(R.sign(disc) > 0 ? [sqrt(R.toNumber(disc)) / abs(R.toNumber(a))] : []));
        const series = Array.from({ length: 121 }, (_, n) => {
            const x = H - span + (2 * span * n) / 120;

            return [x, R.toNumber(a) * (x - H) ** 2 + R.toNumber(k)];
        });
        const values = { vertex: [pt(h, k), 'Vertex'], vertexForm: [vertexForm, 'Vertex form'], standard: [standardForm, 'Standard form'], focus: [pt(h, R.add(k, p)), 'Focus'] };

        return result(values[want][0], values[want][1], { sub: want === 'vertexForm' ? `Vertex ${pt(h, k)}` : vertexForm, rows, steps: [given === 'standard' ? `h = −b ÷ 2a = ${t(h)}` : given === 'focus' ? `Vertex halfway between focus and directrix: (${t(h)}, ${t(k)}); p = ${t(p)}, a = 1 ÷ 4p = ${t(a)}` : `Vertex (${t(h)}, ${t(k)})`, ...(given === 'standard' ? [`k = c − b² ÷ 4a = ${t(k)}`] : []), `Vertex form: ${vertexForm}`, `Standard form: ${standardForm}`, `Focal length p = 1 ÷ 4a = ${t(p)} → focus ${pt(h, R.add(k, p))}, directrix y = ${t(R.sub(k, p))}`], plots: { graph: { series, scatter: [[H, R.toNumber(k)], [H, R.toNumber(R.add(k, p))]], extra: [[[H - span, R.toNumber(R.sub(k, p))], [H + span, R.toNumber(R.sub(k, p))]]], axes: true, xLabel: 'x', yLabel: 'y' } } });
    },

    poly_graph: (i) => {
        const text = String(i.p ?? '').trim();
        let poly;

        try {
            poly = text ? toPoly(parse(text.replace(/^(y|f\(x\))\s*=/, '')), 'x') : null;
        } catch (e) {
            if (e instanceof ParseError) {
                return fail(e.message);
            }

            throw e;
        }

        if (!poly) {
            return text ? fail('Type a polynomial in x, such as x^3 - 3x + 1.') : need('Type a polynomial.');
        }

        const p = P.trim(poly);
        const n = P.deg(p);

        if (n < 1) {
            return fail('The polynomial must contain x.');
        }

        const realRoots = (q2) => (P.deg(q2) < 1 ? [] : P.numericRoots(q2).filter((z) => abs(z.im) < 1e-8 * Math.max(1, abs(z.re))).map((z) => z.re).sort((x, y) => x - y));
        const roots = realRoots(p);
        const crit = realRoots(P.derivative(p));
        const infl = n >= 3 ? realRoots(P.derivative(P.derivative(p))) : [];
        const val = (x) => P.evalNumber(p, x);
        const keys = [...roots, ...crit, ...infl, 0];
        const lo = Math.min(...keys) - 1.5;
        const hi = Math.max(...keys) + 1.5;
        const series = Array.from({ length: 241 }, (_, k) => {
            const x = lo + ((hi - lo) * k) / 240;

            return [x, val(x)];
        });
        const lead = R.toNumber(P.lead(p));
        const end = `${n % 2 === 0 ? (lead > 0 ? 'Up on both sides' : 'Down on both sides') : lead > 0 ? 'Down on the left, up on the right' : 'Up on the left, down on the right'}`;
        const turning = crit.map((x) => {
            const second = P.evalNumber(P.derivative(P.derivative(p)), x);

            return `(${f(x, 8)}, ${f(val(x), 8)}) ${second > 0 ? 'minimum' : second < 0 ? 'maximum' : 'flat'}`;
        });

        return result(roots.length ? roots.map((x) => f(x, 10)).join(', ') : 'No real roots', 'Real roots (x-intercepts)', { sub: `Degree ${n}; y-intercept ${t(p[0])}`, rows: { roots: roots.length ? roots.map((x) => `x ≈ ${f(x, 12)}`).join(', ') : 'None', yint: `(0, ${t(p[0])})`, turning: turning.length ? turning.join('; ') : 'None', inflection: infl.length ? infl.map((x) => `(${f(x, 8)}, ${f(val(x), 8)})`).join('; ') : 'None', end, degree: `${n} (at most ${n} roots and ${n - 1} turning points)` }, steps: [`f(x) = ${P.toText(p, 'x')}`, `Roots of f: ${roots.map((x) => f(x, 10)).join(', ') || 'none'}`, `f′(x) = ${P.toText(P.derivative(p), 'x')}, zero at ${crit.map((x) => f(x, 10)).join(', ') || 'no real x'}`, `End behaviour: ${end}`], plots: { graph: { series, scatter: [...roots.map((x) => [x, 0]), ...crit.map((x) => [x, val(x)])], axes: true, xLabel: 'x', yLabel: 'f(x)' } } });
    },

    rotate: (i) => {
        const v = readQ(i, ['x', 'y', 'cx', 'cy']);
        const ang = Number(i.angle);
        const cw = i.direction === 'cw';

        if (!v || !Number.isFinite(ang)) {
            return need('Enter the point, the centre and the angle.');
        }

        const [x, y, cx, cy] = v;
        const th = (cw ? -ang : ang) * D;
        const dx = R.sub(x, cx);
        const dy = R.sub(y, cy);
        const quarter = (((cw ? -ang : ang) % 360) + 360) % 360;
        let out;

        if ([0, 90, 180, 270].includes(quarter)) {
            const [c0, s0] = { 0: [1, 0], 90: [0, 1], 180: [-1, 0], 270: [0, -1] }[quarter];
            out = [R.add(cx, R.sub(R.mul(R.Q(c0), dx), R.mul(R.Q(s0), dy))), R.add(cy, R.add(R.mul(R.Q(s0), dx), R.mul(R.Q(c0), dy)))];
        }

        const nx = R.toNumber(cx) + R.toNumber(dx) * cos(th) - R.toNumber(dy) * sin(th);
        const ny = R.toNumber(cy) + R.toNumber(dx) * sin(th) + R.toNumber(dy) * cos(th);
        const text = out ? pt(...out) : `(${f(nx, 10)}, ${f(ny, 10)})`;
        const rule = { 90: '(x, y) → (−y, x)', 180: '(x, y) → (−x, −y)', 270: '(x, y) → (y, −x)', 0: 'No change' }[quarter] ?? 'x′ = x cos θ − y sin θ, y′ = x sin θ + y cos θ';

        return result(text, 'Rotated point', { sub: `${f(ang)}° ${cw ? 'clockwise' : 'counter-clockwise'} about ${pt(cx, cy)}`, rows: { rule: `${rule} (about the origin)`, decimal: `(${f(nx, 12)}, ${f(ny, 12)})`, distance: `Distance from the centre stays ${surdBoth(R.add(R.mul(dx, dx), R.mul(dy, dy)))}`, matrix: `[[cos θ, −sin θ], [sin θ, cos θ]] with θ = ${f(cw ? -ang : ang)}°` }, steps: [`Shift so the centre is the origin: (${t(dx)}, ${t(dy)})`, `Rotate: x′ = x cos θ − y sin θ, y′ = x sin θ + y cos θ with θ = ${f(cw ? -ang : ang)}°`, `Shift back: ${text}`], plots: { diagram: { kind: 'diagram', shapes: [{ points: [points2([[cx, cy]])[0], points2([[x, y]])[0]], muted: true, dashed: true }, { points: [points2([[cx, cy]])[0], [nx, ny]], muted: true, dashed: true }], dots: [points2([[x, y]])[0], [nx, ny], points2([[cx, cy]])[0]], labels: [{ x: R.toNumber(x), y: R.toNumber(y) + 0.4, text: 'P' }, { x: nx, y: ny + 0.4, text: 'P′' }] } } });
    },

    sigmoid: (i) => {
        const [x, L, k, x0] = [i.x, i.L ?? 1, i.k ?? 1, i.x0 ?? 0].map(Number);

        if (![x, L, k, x0].every(Number.isFinite)) {
            return need('Enter x (and optionally L, k and x₀).');
        }

        const s = L / (1 + exp(-k * (x - x0)));
        const deriv = k * s * (1 - s / L);
        const series = Array.from({ length: 121 }, (_, n) => {
            const xx = x0 - 8 / Math.max(abs(k), 1e-9) + (16 / Math.max(abs(k), 1e-9)) * (n / 120);

            return [xx, L / (1 + exp(-k * (xx - x0)))];
        });

        return result(f(s, 14), 'σ(x)', { sub: `Standard logistic σ(x) = 1 ÷ (1 + e⁻ˣ)${L !== 1 || k !== 1 || x0 !== 0 ? `, scaled by L = ${f(L)}, k = ${f(k)}, x₀ = ${f(x0)}` : ''}`, rows: { value: f(s, 15), derivative: f(deriv, 15), logit: L === 1 && s > 0 && s < 1 ? `ln(σ ÷ (1 − σ)) = ${f(log(s / (1 - s)), 12)}` : 'For L = 1 only', tanh: `σ(x) = ½(1 + tanh(x/2)) = ${f(0.5 * (1 + Math.tanh((k * (x - x0)) / 2)) * L, 12)}` }, steps: [`σ(x) = L ÷ (1 + e^(−k(x − x₀))) = ${f(s, 15)}`, `σ′(x) = k σ (1 − σ/L) = ${f(deriv, 15)}`], plots: { graph: { series, scatter: [[x, s]], xLabel: 'x', yLabel: 'σ(x)' } } });
    },

    triangulation: (i) => {
        const [base, a, b] = [i.base, i.alpha, i.beta].map(Number);

        if (!(base > 0 && a > 0 && b > 0)) {
            return need('Enter the baseline and the two angles to the target.');
        }

        if (a + b >= 180) {
            return fail('The two angles must add up to less than 180°.');
        }

        const g = 180 - a - b;
        const dA = (base * sin(b * D)) / sin(g * D);
        const dB = (base * sin(a * D)) / sin(g * D);
        const perp = dA * sin(a * D);
        const along = dA * cos(a * D);

        return result(f(perp, 10), 'Distance to the target (from the baseline)', { sub: `Station A: ${f(dA, 10)}, station B: ${f(dB, 10)}`, rows: { fromA: f(dA, 12), fromB: f(dB, 12), perp: f(perp, 12), position: `(${f(along, 10)}, ${f(perp, 10)}) with A at (0, 0) and B at (${f(base)}, 0)`, apex: `${f(g, 10)}° at the target` }, steps: [`Angle at the target = 180° − ${f(a)}° − ${f(b)}° = ${f(g, 10)}°`, `Law of sines: AT = base × sin B ÷ sin T = ${f(dA, 12)}`, `BT = base × sin A ÷ sin T = ${f(dB, 12)}`, `Perpendicular distance = AT × sin A = ${f(perp, 12)}`], plots: { diagram: { kind: 'diagram', shapes: [{ points: [[0, 0], [base, 0], [along, perp], [0, 0]], closed: true }], dots: [[0, 0], [base, 0], [along, perp]], labels: [{ x: 0, y: -perp * 0.08, text: 'A' }, { x: base, y: -perp * 0.08, text: 'B' }, { x: along, y: perp * 1.08, text: 'Target' }] } } });
    },
};

export default defineTools(handlers);
