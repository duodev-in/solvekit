import { integrate } from './special.js';

/**
 * Shape solvers. Each shape lists its quantities (vars: name → [label, dimension]), the sets of known values
 * it can be solved from (cases: "name_name" → params) and how every quantity follows from the params (all).
 * Dimensions: 1 length, 2 area, 3 volume, 'deg' angle in degrees, 'n' plain number. Var names never contain "_".
 * Cases return { error } when the values cannot belong to the shape.
 */
const { PI, sqrt, sin, cos, tan, asin, acos, atan, atan2, abs, hypot } = Math;
const D = PI / 180;
const S2 = sqrt(2);
const S3 = sqrt(3);
const PHI = (1 + sqrt(5)) / 2;
const bad = (error) => ({ error });

/** Positive root of t² − s t + p = 0 pairs (larger first), or null. */
function sumProduct(s, p) {
    const disc = s * s - 4 * p;

    if (disc < -1e-12 * s * s) {
        return null;
    }

    const root = sqrt(Math.max(disc, 0));

    return [(s + root) / 2, (s - root) / 2];
}

/** Solves g(x) = target for x in (lo, hi) by bisection (g increasing). */
export function solveIncreasing(g, target, lo, hi) {
    let a = lo;
    let b = hi;

    while (g(b) < target && b < 1e300) {
        b *= 2;
    }

    for (let k = 0; k < 200; k += 1) {
        const m = (a + b) / 2;

        if (g(m) < target) {
            a = m;
        } else {
            b = m;
        }
    }

    return (a + b) / 2;
}

/** Complete elliptic integral of the second kind E(m), m = k², by the AGM. */
export function ellipticE(m) {
    let a = 1;
    let b = sqrt(1 - m);
    let c2sum = m / 2;
    let power = 1;

    for (let k = 0; k < 40 && abs(a - b) > 1e-16 * a; k += 1) {
        const an = (a + b) / 2;
        const c = (a - b) / 2;
        b = sqrt(a * b);
        a = an;
        power *= 2;
        c2sum += (power * c * c) / 2;
    }

    return (PI / (2 * a)) * (1 - c2sum);
}

/** Exact ellipse perimeter 4a E(e²) with a ≥ b. */
export function ellipsePerimeter(a, b) {
    const [big, small] = a >= b ? [a, b] : [b, a];

    return 4 * big * ellipticE(1 - (small * small) / (big * big));
}

/** Points on a circle or arc (angles in radians) for diagrams. */
export const arc = (cx, cy, r, from = 0, to = 2 * PI, n = 72) => Array.from({ length: n + 1 }, (_, k) => [cx + r * cos(from + ((to - from) * k) / n), cy + r * sin(from + ((to - from) * k) / n)]);
const ellipsePts = (a, b, cx = 0, cy = 0) => Array.from({ length: 73 }, (_, k) => [cx + a * cos((2 * PI * k) / 72), cy + b * sin((2 * PI * k) / 72)]);
const mid = (p, q) => [(p[0] + q[0]) / 2, (p[1] + q[1]) / 2];
/** A label pushed outwards from the centre c. */
const out = (p, c, k, text) => {
    const dx = p[0] - c[0];
    const dy = p[1] - c[1];
    const len = hypot(dx, dy) || 1;

    return { x: p[0] + (dx / len) * k, y: p[1] + (dy / len) * k, text };
};
/** Oblique projection of a 3D point for solid drawings. */
const pr = ([x, y, z]) => [x + 0.45 * y, z + 0.3 * y];
const solid = (edges, hidden = []) => [...edges.map((e) => ({ points: e.map(pr) })), ...hidden.map((e) => ({ points: e.map(pr), muted: true, dashed: true }))];

/** Regular polygon helpers (n sides, side a). */
const polyR = (n, a) => a / (2 * sin(PI / n));
const polyr = (n, a) => a / (2 * tan(PI / n));
const polyArea = (n, a) => (n * a * a) / (4 * tan(PI / n));
const polygonPts = (n, R, rot = PI / 2 - PI / n) => Array.from({ length: n + 1 }, (_, k) => [R * cos(rot + (2 * PI * k) / n), R * sin(rot + (2 * PI * k) / n)]);

export const SHAPES = {
    square: {
        vars: { a: ['Side a', 1], diag: ['Diagonal d', 1], perim: ['Perimeter P', 1], area: ['Area A', 2], inr: ['Inscribed circle radius', 1], circr: ['Circumscribed circle radius', 1] },
        cases: { a: (v) => ({ a: v.a }), diag: (v) => ({ a: v.diag / S2 }), perim: (v) => ({ a: v.perim / 4 }), area: (v) => ({ a: sqrt(v.area) }), circr: (v) => ({ a: v.circr * S2 }) },
        all: ({ a }) => ({ a, diag: a * S2, perim: 4 * a, area: a * a, inr: a / 2, circr: (a * S2) / 2 }),
        formulas: { a: 'a = √A = P ÷ 4 = d ÷ √2', diag: 'd = a√2', perim: 'P = 4a', area: 'A = a²', inr: 'r = a ÷ 2', circr: 'R = a√2 ÷ 2' },
        draw: ({ a }, t) => ({ shapes: [{ points: [[0, 0], [a, 0], [a, a], [0, a], [0, 0]], closed: true }, { points: [[0, 0], [a, a]], muted: true, dashed: true }], labels: [{ x: a / 2, y: -a * 0.08, text: `a = ${t('a')}` }, { x: a * 0.62, y: a * 0.45, text: `d = ${t('diag')}` }] }),
    },
    rectangle: {
        vars: { l: ['Length l', 1], w: ['Width w', 1], diag: ['Diagonal d', 1], perim: ['Perimeter P', 1], area: ['Area A', 2], ratio: ['Aspect ratio l : w', 'n'], angle: ['Angle between diagonal and length', 'deg'], circr: ['Circumscribed circle radius', 1] },
        cases: {
            l_w: (v) => ({ l: v.l, w: v.w }),
            l_area: (v) => ({ l: v.l, w: v.area / v.l }),
            w_area: (v) => ({ l: v.area / v.w, w: v.w }),
            l_perim: (v) => (v.perim / 2 > v.l ? { l: v.l, w: v.perim / 2 - v.l } : bad('The perimeter must be more than twice the length.')),
            w_perim: (v) => (v.perim / 2 > v.w ? { l: v.perim / 2 - v.w, w: v.w } : bad('The perimeter must be more than twice the width.')),
            l_diag: (v) => (v.diag > v.l ? { l: v.l, w: sqrt(v.diag ** 2 - v.l ** 2) } : bad('The diagonal must be longer than the length.')),
            area_perim: (v) => {
                const roots = sumProduct(v.perim / 2, v.area);

                return roots && roots[1] > 0 ? { l: roots[0], w: roots[1] } : bad('No rectangle has this area and perimeter: P² must be at least 16A (the square is the extreme case).');
            },
            diag_perim: (v) => {
                const s = v.perim / 2;
                const roots = s > v.diag ? sumProduct(s, (s * s - v.diag * v.diag) / 2) : null;

                return roots && roots[1] > 0 ? { l: roots[0], w: roots[1] } : bad('No rectangle has this diagonal and perimeter: P/2 must lie between d and d√2.');
            },
            area_ratio: (v) => ({ l: sqrt(v.area * v.ratio), w: sqrt(v.area / v.ratio) }),
            perim_ratio: (v) => ({ l: (v.perim / 2) * (v.ratio / (1 + v.ratio)), w: v.perim / 2 / (1 + v.ratio) }),
            diag_ratio: (v) => ({ l: (v.diag * v.ratio) / hypot(1, v.ratio), w: v.diag / hypot(1, v.ratio) }),
            diag_angle: (v) => (v.angle < 90 ? { l: v.diag * cos(v.angle * D), w: v.diag * sin(v.angle * D) } : bad('The angle must be less than 90°.')),
        },
        all: ({ l, w }) => ({ l, w, diag: hypot(l, w), perim: 2 * (l + w), area: l * w, ratio: l / w, angle: atan2(w, l) / D, circr: hypot(l, w) / 2 }),
        formulas: { l: 'l = A ÷ w', w: 'w = A ÷ l', diag: 'd = √(l² + w²)', perim: 'P = 2(l + w)', area: 'A = l × w', ratio: 'l ÷ w', angle: 'θ = atan(w ÷ l)', circr: 'R = d ÷ 2' },
        draw: ({ l, w }, t) => ({ shapes: [{ points: [[0, 0], [l, 0], [l, w], [0, w], [0, 0]], closed: true }, { points: [[0, 0], [l, w]], muted: true, dashed: true }], labels: [{ x: l / 2, y: -Math.max(l, w) * 0.07, text: `l = ${t('l')}` }, { x: l + Math.max(l, w) * 0.12, y: w / 2, text: `w = ${t('w')}` }, { x: l * 0.55, y: w * 0.62, text: `d = ${t('diag')}` }] }),
    },
    polygon: {
        fixed: ['n'],
        vars: { a: ['Side a', 1], circr: ['Circumradius R', 1], inr: ['Apothem (inradius) r', 1], perim: ['Perimeter P', 1], area: ['Area A', 2], interior: ['Interior angle', 'deg'], exterior: ['Exterior angle', 'deg'], sum: ['Sum of interior angles', 'deg'], diagonals: ['Number of diagonals', 'n'] },
        cases: { a: (v) => ({ a: v.a }), circr: (v) => ({ a: 2 * v.circr * sin(PI / v.n) }), inr: (v) => ({ a: 2 * v.inr * tan(PI / v.n) }), perim: (v) => ({ a: v.perim / v.n }), area: (v) => ({ a: sqrt((4 * v.area * tan(PI / v.n)) / v.n) }) },
        check: (v) => (Number.isInteger(v.n) && v.n >= 3 && v.n <= 1000 ? null : 'The number of sides must be a whole number from 3 to 1000.'),
        all: ({ a }, v) => ({ a, circr: polyR(v.n, a), inr: polyr(v.n, a), perim: v.n * a, area: polyArea(v.n, a), interior: 180 - 360 / v.n, exterior: 360 / v.n, sum: (v.n - 2) * 180, diagonals: (v.n * (v.n - 3)) / 2 }),
        formulas: { a: 'a = 2R sin(π/n)', circr: 'R = a ÷ (2 sin(π/n))', inr: 'r = a ÷ (2 tan(π/n))', perim: 'P = n a', area: 'A = n a² ÷ (4 tan(π/n))', interior: 'Interior angle = 180° − 360°/n', exterior: 'Exterior angle = 360°/n', sum: 'Sum = (n − 2) × 180°', diagonals: 'Diagonals = n(n − 3) ÷ 2' },
        draw: ({ a }, t, v) => {
            const R = polyR(v.n, a);
            const pts = polygonPts(Math.min(v.n, 200), R);

            return { shapes: [{ points: pts, closed: true }, { points: [[0, 0], pts[0]], muted: true, dashed: true }, { points: [[0, 0], mid(pts[0], pts[1])], muted: true }], dots: [[0, 0]], labels: [out(mid(pts[0], pts[1]), [0, 0], R * 0.14, `a = ${t('a')}`), { x: pts[0][0] / 2 + R * 0.12, y: pts[0][1] / 2, text: 'R' }, { x: mid(pts[0], pts[1])[0] / 2 - R * 0.08, y: mid(pts[0], pts[1])[1] / 2, text: 'r' }] };
        },
    },
    ellipse: {
        vars: { a: ['Semi-major axis a', 1], b: ['Semi-minor axis b', 1], c: ['Focal distance c', 1], ecc: ['Eccentricity e', 'n'], area: ['Area A', 2], perim: ['Perimeter (circumference)', 1], latus: ['Semi-latus rectum', 1] },
        cases: {
            a_b: (v) => ({ a: Math.max(v.a, v.b), b: Math.min(v.a, v.b) }),
            a_c: (v) => (v.c < v.a ? { a: v.a, b: sqrt(v.a ** 2 - v.c ** 2) } : bad('The focal distance must be less than a.')),
            a_ecc: (v) => (v.ecc < 1 ? { a: v.a, b: v.a * sqrt(1 - v.ecc ** 2) } : bad('An ellipse has eccentricity below 1.')),
            a_area: (v) => (v.area <= PI * v.a ** 2 ? { a: v.a, b: v.area / (PI * v.a) } : bad('The area cannot exceed πa².')),
            b_c: (v) => ({ a: hypot(v.b, v.c), b: v.b }),
        },
        all: ({ a, b }) => ({ a, b, c: sqrt(Math.max(a * a - b * b, 0)), ecc: sqrt(Math.max(1 - (b * b) / (a * a), 0)), area: PI * a * b, perim: ellipsePerimeter(a, b), latus: (b * b) / a }),
        formulas: { c: 'c = √(a² − b²)', ecc: 'e = c ÷ a', area: 'A = πab', perim: 'P = 4a E(e) (complete elliptic integral, exact)', latus: 'ℓ = b² ÷ a', b: 'b = √(a² − c²)', a: 'a = √(b² + c²)' },
        draw: ({ a, b }, t) => {
            const c = sqrt(Math.max(a * a - b * b, 0));

            return { shapes: [{ points: ellipsePts(a, b), closed: true }, { points: [[0, 0], [a, 0]], muted: true }, { points: [[0, 0], [0, b]], muted: true }], dots: [[-c, 0], [c, 0], [0, 0]], labels: [{ x: a / 2, y: -b * 0.12, text: `a = ${t('a')}` }, { x: -a * 0.16, y: b / 2, text: `b = ${t('b')}` }, { x: c, y: b * 0.14, text: 'F₂' }, { x: -c, y: b * 0.14, text: 'F₁' }] };
        },
    },
    golden: {
        vars: { long: ['Long side a', 1], short: ['Short side b', 1], sum: ['a + b', 1], area: ['Area', 2], perim: ['Perimeter', 1], diag: ['Diagonal', 1] },
        cases: { long: (v) => ({ a: v.long }), short: (v) => ({ a: v.short * PHI }), sum: (v) => ({ a: v.sum / PHI }), area: (v) => ({ a: sqrt(v.area * PHI) }) },
        all: ({ a }) => ({ long: a, short: a / PHI, sum: a * PHI, area: (a * a) / PHI, perim: 2 * (a + a / PHI), diag: hypot(a, a / PHI) }),
        formulas: { long: 'a = φb', short: 'b = a ÷ φ', sum: 'a + b = φa', area: 'A = ab', perim: 'P = 2(a + b)', diag: 'd = √(a² + b²)' },
        draw: ({ a }, t) => {
            const b = a / PHI;
            const c = a - b;

            // The square b × b and the smaller golden rectangle beside it, with the first two quarter turns of the spiral.
            return { shapes: [{ points: [[0, 0], [a, 0], [a, b], [0, b], [0, 0]], closed: true }, { points: [[b, 0], [b, b]], muted: true, dashed: true }, { points: [[b, b - c], [a, b - c]], muted: true, dashed: true }, { points: [...arc(b, 0, b, PI / 2, PI, 24), ...arc(b, b - c, c, 0, PI / 2, 16).reverse()] }], labels: [{ x: a / 2, y: -b * 0.1, text: `a = ${t('long')}` }, { x: a + b * 0.18, y: b / 2, text: `b = ${t('short')}` }] };
        },
    },
    triBH: {
        vars: { base: ['Base b', 1], h: ['Height h', 1], area: ['Area A', 2] },
        cases: { base_h: (v) => ({ b: v.base, h: v.h }), area_h: (v) => ({ b: (2 * v.area) / v.h, h: v.h }), area_base: (v) => ({ b: v.base, h: (2 * v.area) / v.base }) },
        all: ({ b, h }) => ({ base: b, h, area: (b * h) / 2 }),
        formulas: { base: 'b = 2A ÷ h', h: 'h = 2A ÷ b', area: 'A = bh ÷ 2' },
        draw: ({ b, h }, t) => ({ shapes: [{ points: [[0, 0], [b, 0], [b * 0.35, h], [0, 0]], closed: true }, { points: [[b * 0.35, 0], [b * 0.35, h]], muted: true, dashed: true }], labels: [{ x: b / 2, y: -Math.max(b, h) * 0.08, text: `b = ${t('base')}` }, { x: b * 0.35 + Math.max(b, h) * 0.12, y: h / 2, text: `h = ${t('h')}` }] }),
    },
    circle: {
        vars: { r: ['Radius r', 1], d: ['Diameter d', 1], circ: ['Circumference C', 1], area: ['Area A', 2] },
        cases: { r: (v) => ({ r: v.r }), d: (v) => ({ r: v.d / 2 }), circ: (v) => ({ r: v.circ / (2 * PI) }), area: (v) => ({ r: sqrt(v.area / PI) }) },
        all: ({ r }) => ({ r, d: 2 * r, circ: 2 * PI * r, area: PI * r * r }),
        formulas: { r: 'r = d ÷ 2 = C ÷ 2π = √(A ÷ π)', d: 'd = 2r', circ: 'C = 2πr = πd', area: 'A = πr²' },
        draw: ({ r }, t) => ({ shapes: [{ points: arc(0, 0, r), closed: true }, { points: [[0, 0], [r, 0]], muted: true }], dots: [[0, 0]], labels: [{ x: r / 2, y: -r * 0.1, text: `r = ${t('r')}` }] }),
    },
    sector: {
        vars: { r: ['Radius r', 1], theta: ['Central angle θ', 'deg'], arc: ['Arc length s', 1], area: ['Sector area A', 2], chord: ['Chord length c', 1], perim: ['Sector perimeter', 1], segment: ['Segment area', 2], sagitta: ['Segment height (sagitta)', 1] },
        cases: {
            r_theta: (v) => ({ r: v.r, t: v.theta * D }),
            r_arc: (v) => ({ r: v.r, t: v.arc / v.r }),
            arc_theta: (v) => ({ r: v.arc / (v.theta * D), t: v.theta * D }),
            r_area: (v) => ({ r: v.r, t: (2 * v.area) / v.r ** 2 }),
            area_theta: (v) => ({ r: sqrt((2 * v.area) / (v.theta * D)), t: v.theta * D }),
            r_chord: (v) => (v.chord <= 2 * v.r ? { r: v.r, t: 2 * asin(v.chord / (2 * v.r)) } : bad('A chord cannot be longer than the diameter.')),
            chord_theta: (v) => ({ r: v.chord / (2 * sin((v.theta * D) / 2)), t: v.theta * D }),
            chord_sagitta: (v) => {
                const r = (v.sagitta ** 2 + (v.chord / 2) ** 2) / (2 * v.sagitta);

                return { r, t: v.sagitta <= r ? 2 * asin(v.chord / (2 * r)) : 2 * PI - 2 * asin(v.chord / (2 * r)) };
            },
            r_sagitta: (v) => (v.sagitta <= 2 * v.r ? { r: v.r, t: 2 * acos(1 - v.sagitta / v.r) } : bad('The segment height cannot exceed the diameter.')),
        },
        check: (v) => (v.theta !== undefined && v.theta > 360 ? 'The angle must be at most 360°.' : null),
        all: ({ r, t }) => (t > 2 * PI + 1e-12 ? bad('The angle comes out above 360°: check the values.') : { r, theta: t / D, arc: r * t, area: (r * r * t) / 2, chord: 2 * r * sin(t / 2), perim: 2 * r + r * t, segment: ((r * r) / 2) * (t - sin(t)), sagitta: r * (1 - cos(t / 2)) }),
        formulas: { theta: 'θ = s ÷ r (radians)', arc: 's = rθ', area: 'A = ½r²θ', chord: 'c = 2r sin(θ/2)', perim: 'P = 2r + s', segment: 'Segment = ½r²(θ − sin θ)', sagitta: 'h = r(1 − cos(θ/2))', r: 'r from the given values' },
        draw: ({ r, t }, tx) => {
            const a0 = PI / 2 - t / 2;
            const pts = arc(0, 0, r, a0, a0 + t, 48);

            return { shapes: [{ points: [[0, 0], ...pts, [0, 0]], closed: true }, { points: [pts[0], pts[pts.length - 1]], muted: true, dashed: true }, { points: arc(0, 0, r), muted: true, dashed: true }], dots: [[0, 0]], labels: [{ x: 0, y: r * 1.12, text: `s = ${tx('arc')}` }, { x: r * 0.12, y: -r * 0.14, text: `θ = ${tx('theta')}` }] };
        },
    },
    semicircle: {
        fixed: ['part'],
        vars: { r: ['Radius r', 1], d: ['Diameter d', 1], arc: ['Arc length', 1], area: ['Area A', 2], perim: ['Perimeter P', 1], centroid: ['Centroid distance from the straight edge', 1] },
        cases: { r: (v) => ({ r: v.r }), d: (v) => ({ r: v.d / 2 }), area: (v) => ({ r: sqrt((v.area * (v.part === 'quarter' ? 4 : 2)) / PI) }), perim: (v) => ({ r: v.perim / (v.part === 'quarter' ? 2 + PI / 2 : 2 + PI) }), arc: (v) => ({ r: v.arc / (v.part === 'quarter' ? PI / 2 : PI) }) },
        all: ({ r }, v) => {
            const k = v.part === 'quarter' ? 0.25 : 0.5;

            return { r, d: 2 * r, arc: 2 * PI * r * k, area: PI * r * r * k, perim: 2 * PI * r * k + (k === 0.5 ? 2 * r : 2 * r), centroid: (4 * r) / (3 * PI) };
        },
        formulas: { area: 'A = πr² ÷ 2 (semicircle) or ÷ 4 (quarter circle)', arc: 'Arc = πr (semicircle) or πr ÷ 2 (quarter)', perim: 'P = πr + 2r (semicircle) or πr/2 + 2r (quarter)', centroid: 'ȳ = 4r ÷ 3π', d: 'd = 2r', r: 'r from the given value' },
        draw: ({ r }, t, v) => (v.part === 'quarter' ? { shapes: [{ points: [[0, 0], ...arc(0, 0, r, 0, PI / 2, 36), [0, 0]], closed: true }], labels: [{ x: r / 2, y: -r * 0.1, text: `r = ${t('r')}` }] } : { shapes: [{ points: [...arc(0, 0, r, 0, PI, 48), [r, 0]], closed: true }], dots: [[0, 0]], labels: [{ x: r / 2, y: -r * 0.1, text: `r = ${t('r')}` }] }),
    },
    annulus: {
        vars: { outer: ['Outer radius R', 1], inner: ['Inner radius r', 1], width: ['Ring width w', 1], area: ['Area A', 2], outerC: ['Outer circumference', 1], innerC: ['Inner circumference', 1], mean: ['Mean radius', 1] },
        cases: {
            outer_inner: (v) => (v.outer > v.inner ? { R: v.outer, r: v.inner } : bad('The outer radius must be larger than the inner radius.')),
            outer_width: (v) => (v.width < v.outer ? { R: v.outer, r: v.outer - v.width } : bad('The width must be less than the outer radius.')),
            inner_width: (v) => ({ R: v.inner + v.width, r: v.inner }),
            outer_area: (v) => (v.area < PI * v.outer ** 2 ? { R: v.outer, r: sqrt(v.outer ** 2 - v.area / PI) } : bad('The area must be less than πR².')),
            inner_area: (v) => ({ R: sqrt(v.inner ** 2 + v.area / PI), r: v.inner }),
        },
        all: ({ R, r }) => ({ outer: R, inner: r, width: R - r, area: PI * (R * R - r * r), outerC: 2 * PI * R, innerC: 2 * PI * r, mean: (R + r) / 2 }),
        formulas: { area: 'A = π(R² − r²)', width: 'w = R − r', outerC: 'C = 2πR', innerC: 'c = 2πr', mean: '(R + r) ÷ 2', outer: 'R from the given values', inner: 'r from the given values' },
        draw: ({ R, r }, t) => ({ shapes: [{ points: arc(0, 0, R), closed: true }, { points: arc(0, 0, r) }, { points: [[0, 0], [R, 0]], muted: true }], dots: [[0, 0]], labels: [{ x: R * 0.85, y: R * 0.1, text: `R = ${t('outer')}` }, { x: -r / 2, y: r * 0.15, text: `r = ${t('inner')}` }] }),
    },
    squareInCircle: {
        vars: { r: ['Circle radius', 1], a: ['Square side', 1], circleArea: ['Circle area', 2], squareArea: ['Square area', 2], leftover: ['Area outside the square', 2], share: ['Square share of the circle (%)', 'n'] },
        cases: { r: (v) => ({ r: v.r }), a: (v) => ({ r: v.a / S2 }), circleArea: (v) => ({ r: sqrt(v.circleArea / PI) }), squareArea: (v) => ({ r: sqrt(v.squareArea / 2) }) },
        all: ({ r }) => ({ r, a: r * S2, circleArea: PI * r * r, squareArea: 2 * r * r, leftover: (PI - 2) * r * r, share: (200 / PI) }),
        formulas: { a: 'a = r√2 (the diagonal is the diameter)', circleArea: 'πr²', squareArea: 'a² = 2r²', leftover: '(π − 2) r²', share: '2 ÷ π = 63.66%', r: 'r = a ÷ √2' },
        draw: ({ r }, t) => {
            const a = r / S2;

            return { shapes: [{ points: arc(0, 0, r), muted: true }, { points: [[-a, -a], [a, -a], [a, a], [-a, a], [-a, -a]], closed: true }, { points: [[-a, -a], [a, a]], muted: true, dashed: true }], labels: [{ x: 0, y: -a - r * 0.1, text: `a = ${t('a')}` }, { x: r * 0.2, y: r * 0.05, text: `2r = ${t('r', 2)}` }] };
        },
    },
    rightTriangle: {
        vars: { a: ['Leg a', 1], b: ['Leg b', 1], c: ['Hypotenuse c', 1], alpha: ['Angle α (opposite a)', 'deg'], beta: ['Angle β (opposite b)', 'deg'], area: ['Area', 2], perim: ['Perimeter', 1], h: ['Height to the hypotenuse', 1], inr: ['Inradius', 1], circr: ['Circumradius', 1] },
        cases: {
            a_b: (v) => ({ a: v.a, b: v.b }),
            a_c: (v) => (v.c > v.a ? { a: v.a, b: sqrt(v.c ** 2 - v.a ** 2) } : bad('The hypotenuse must be the longest side.')),
            b_c: (v) => (v.c > v.b ? { a: sqrt(v.c ** 2 - v.b ** 2), b: v.b } : bad('The hypotenuse must be the longest side.')),
            a_alpha: (v) => (v.alpha < 90 ? { a: v.a, b: v.a / tan(v.alpha * D) } : bad('An acute angle is below 90°.')),
            b_alpha: (v) => (v.alpha < 90 ? { a: v.b * tan(v.alpha * D), b: v.b } : bad('An acute angle is below 90°.')),
            c_alpha: (v) => (v.alpha < 90 ? { a: v.c * sin(v.alpha * D), b: v.c * cos(v.alpha * D) } : bad('An acute angle is below 90°.')),
            a_area: (v) => ({ a: v.a, b: (2 * v.area) / v.a }),
            c_area: (v) => {
                const roots = sumProduct(sqrt(v.c ** 2 + 4 * v.area), 2 * v.area);

                return roots && roots[1] > 0 ? { a: roots[0], b: roots[1] } : bad('The area is too large for this hypotenuse (at most c²/4).');
            },
            area_perim: (v) => {
                // a + b = P − c and a² + b² = c² with ab = 2A give c = (P² − 4A) ÷ 2P.
                const c = (v.perim ** 2 - 4 * v.area) / (2 * v.perim);
                const roots = sumProduct(v.perim - c, 2 * v.area);

                return c > 0 && roots && roots[1] > 0 ? { a: roots[0], b: roots[1] } : bad('No right triangle has this area and perimeter.');
            },
        },
        all: ({ a, b }) => {
            const c = hypot(a, b);

            return { a, b, c, alpha: atan2(a, b) / D, beta: atan2(b, a) / D, area: (a * b) / 2, perim: a + b + c, h: (a * b) / c, inr: (a + b - c) / 2, circr: c / 2 };
        },
        formulas: { c: 'c = √(a² + b²)', a: 'a = √(c² − b²)', b: 'b = √(c² − a²)', alpha: 'α = atan(a ÷ b)', beta: 'β = 90° − α', area: 'A = ab ÷ 2', perim: 'P = a + b + c', h: 'h = ab ÷ c', inr: 'r = (a + b − c) ÷ 2', circr: 'R = c ÷ 2' },
        draw: ({ a, b }, t) => {
            const s = Math.max(a, b) * 0.08;

            return { shapes: [{ points: [[0, 0], [b, 0], [0, a], [0, 0]], closed: true }, { points: [[s, 0], [s, s], [0, s]], muted: true }], labels: [{ x: b / 2, y: -Math.max(a, b) * 0.08, text: `b = ${t('b')}` }, { x: -Math.max(a, b) * 0.14, y: a / 2, text: `a = ${t('a')}` }, { x: b / 2 + Math.max(a, b) * 0.12, y: a / 2 + Math.max(a, b) * 0.06, text: `c = ${t('c')}` }, { x: b - Math.max(a, b) * 0.17, y: Math.max(a, b) * 0.05, text: 'α' }, { x: Math.max(a, b) * 0.05, y: a - Math.max(a, b) * 0.17, text: 'β' }] };
        },
    },
    equilateral: {
        vars: { a: ['Side a', 1], h: ['Height h', 1], area: ['Area A', 2], perim: ['Perimeter P', 1], inr: ['Inradius r', 1], circr: ['Circumradius R', 1] },
        cases: { a: (v) => ({ a: v.a }), h: (v) => ({ a: (2 * v.h) / S3 }), area: (v) => ({ a: sqrt((4 * v.area) / S3) }), perim: (v) => ({ a: v.perim / 3 }), inr: (v) => ({ a: 2 * S3 * v.inr }), circr: (v) => ({ a: S3 * v.circr }) },
        all: ({ a }) => ({ a, h: (S3 / 2) * a, area: (S3 / 4) * a * a, perim: 3 * a, inr: a / (2 * S3), circr: a / S3 }),
        formulas: { a: 'a from the given value', h: 'h = (√3 ÷ 2)a', area: 'A = (√3 ÷ 4)a²', perim: 'P = 3a', inr: 'r = a ÷ (2√3)', circr: 'R = a ÷ √3' },
        draw: ({ a }, t) => ({ shapes: [{ points: [[0, 0], [a, 0], [a / 2, (S3 / 2) * a], [0, 0]], closed: true }, { points: [[a / 2, 0], [a / 2, (S3 / 2) * a]], muted: true, dashed: true }], labels: [{ x: a / 2, y: -a * 0.08, text: `a = ${t('a')}` }, { x: a / 2 + a * 0.12, y: a * 0.35, text: `h = ${t('h')}` }] }),
    },
    isosceles: {
        vars: { leg: ['Leg a (equal sides)', 1], base: ['Base b', 1], h: ['Height to the base h', 1], apex: ['Apex angle', 'deg'], baseAngle: ['Base angle', 'deg'], area: ['Area A', 2], perim: ['Perimeter P', 1], legH: ['Height to a leg', 1] },
        cases: {
            leg_base: (v) => (v.base < 2 * v.leg ? { a: v.leg, b: v.base } : bad('The base must be shorter than two legs (triangle inequality).')),
            base_h: (v) => ({ a: hypot(v.h, v.base / 2), b: v.base }),
            leg_h: (v) => (v.h < v.leg ? { a: v.leg, b: 2 * sqrt(v.leg ** 2 - v.h ** 2) } : bad('The height must be shorter than the leg.')),
            leg_apex: (v) => (v.apex < 180 ? { a: v.leg, b: 2 * v.leg * sin((v.apex * D) / 2) } : bad('The apex angle must be below 180°.')),
            base_baseAngle: (v) => (v.baseAngle < 90 ? { a: v.base / 2 / cos(v.baseAngle * D), b: v.base } : bad('The base angles must be below 90°.')),
            leg_baseAngle: (v) => (v.baseAngle < 90 ? { a: v.leg, b: 2 * v.leg * cos(v.baseAngle * D) } : bad('The base angles must be below 90°.')),
            base_area: (v) => ({ a: hypot((2 * v.area) / v.base, v.base / 2), b: v.base }),
            perim_base: (v) => (v.perim > 2 * v.base ? { a: (v.perim - v.base) / 2, b: v.base } : bad('The perimeter must be more than twice the base.')),
        },
        all: ({ a, b }) => {
            const h = sqrt(a * a - (b * b) / 4);

            return { leg: a, base: b, h, apex: 2 * asin(b / (2 * a)) / D, baseAngle: acos(b / (2 * a)) / D, area: (b * h) / 2, perim: 2 * a + b, legH: (b * h) / a };
        },
        formulas: { h: 'h = √(a² − b²/4)', apex: 'Apex = 2 asin(b ÷ 2a)', baseAngle: 'Base angle = (180° − apex) ÷ 2', area: 'A = bh ÷ 2', perim: 'P = 2a + b', legH: 'Height to a leg = bh ÷ a', leg: 'a = √(h² + (b/2)²)', base: 'b = 2√(a² − h²)' },
        draw: ({ a, b }, t) => {
            const h = sqrt(a * a - (b * b) / 4);

            return { shapes: [{ points: [[0, 0], [b, 0], [b / 2, h], [0, 0]], closed: true }, { points: [[b / 2, 0], [b / 2, h]], muted: true, dashed: true }], labels: [{ x: b / 2, y: -Math.max(b, h) * 0.08, text: `b = ${t('base')}` }, { x: b / 4 - Math.max(b, h) * 0.12, y: h / 2, text: `a = ${t('leg')}` }, { x: b / 2 + Math.max(b, h) * 0.1, y: h * 0.35, text: `h = ${t('h')}` }] };
        },
    },
    special: {
        fixed: ['kind'],
        vars: { short: ['Short leg a', 1], long: ['Long leg b', 1], hyp: ['Hypotenuse c', 1], area: ['Area', 2], perim: ['Perimeter', 1], h: ['Height to the hypotenuse', 1] },
        cases: {
            short: (v) => ({ a: v.short }),
            long: (v) => ({ a: v.long / (v.kind === '45' ? 1 : S3) }),
            hyp: (v) => ({ a: v.hyp / (v.kind === '45' ? S2 : 2) }),
            area: (v) => ({ a: sqrt((2 * v.area) / (v.kind === '45' ? 1 : S3)) }),
            perim: (v) => ({ a: v.perim / (v.kind === '45' ? 2 + S2 : 3 + S3) }),
        },
        all: ({ a }, v) => {
            const b = v.kind === '45' ? a : a * S3;
            const c = v.kind === '45' ? a * S2 : 2 * a;

            return { short: a, long: b, hyp: c, area: (a * b) / 2, perim: a + b + c, h: (a * b) / c };
        },
        formulas: { short: 'a (the shortest side)', long: 'b = a√3 (30-60-90) or a (45-45-90)', hyp: 'c = 2a (30-60-90) or a√2 (45-45-90)', area: 'A = ab ÷ 2', perim: 'P = a + b + c', h: 'h = ab ÷ c' },
        draw: ({ a }, t, v) => {
            const b = v.kind === '45' ? a : a * S3;

            return { shapes: [{ points: [[0, 0], [b, 0], [0, a], [0, 0]], closed: true }], labels: [{ x: b / 2, y: -Math.max(a, b) * 0.08, text: `${v.kind === '45' ? 'a' : 'b'} = ${t('long')}` }, { x: -Math.max(a, b) * 0.15, y: a / 2, text: `a = ${t('short')}` }, { x: b / 2 + Math.max(a, b) * 0.13, y: a / 2 + Math.max(a, b) * 0.05, text: `c = ${t('hyp')}` }, { x: b - Math.max(a, b) * 0.2, y: Math.max(a, b) * 0.05, text: v.kind === '45' ? '45°' : '30°' }, { x: Math.max(a, b) * 0.07, y: a - Math.max(a, b) * 0.2, text: v.kind === '45' ? '45°' : '60°' }] };
        },
    },
    star: {
        fixed: ['n'],
        vars: { outer: ['Outer radius R', 1], inner: ['Inner radius r', 1], edge: ['Edge length', 1], perim: ['Perimeter', 1], area: ['Area', 2], tip: ['Tip angle', 'deg'], chord: ['Chord (tip to tip line)', 1] },
        check: (v) => (Number.isInteger(v.n) && v.n >= 5 && v.n <= 50 ? null : 'The number of points must be a whole number from 5 to 50.'),
        cases: {
            outer: (v) => ({ R: v.outer }),
            inner: (v) => ({ R: v.inner / starRatio(v.n) }),
            edge: (v) => ({ R: v.edge / starEdge(v.n, 1) }),
            area: (v) => ({ R: sqrt(v.area / starArea(v.n, 1)) }),
        },
        all: ({ R }, v) => ({ outer: R, inner: R * starRatio(v.n), edge: starEdge(v.n, R), perim: 2 * v.n * starEdge(v.n, R), area: starArea(v.n, R), tip: 180 - 720 / v.n, chord: 2 * R * sin((2 * PI) / v.n) }),
        formulas: { inner: 'r = R cos(2π/n) ÷ cos(π/n)', edge: 'Edge from the law of cosines', perim: 'P = 2n × edge', area: 'A = n R r sin(π/n)', tip: 'Tip angle = 180° − 720°/n', chord: '2R sin(2π/n)', outer: 'R from the given value' },
        draw: ({ R }, t, v) => {
            const r = R * starRatio(v.n);
            const pts = Array.from({ length: 2 * v.n + 1 }, (_, k) => {
                const rad = k % 2 ? r : R;
                const ang = PI / 2 + (PI * k) / v.n;

                return [rad * cos(ang), rad * sin(ang)];
            });

            return { shapes: [{ points: pts, closed: true }, { points: [[0, 0], pts[0]], muted: true, dashed: true }, { points: [[0, 0], pts[1]], muted: true, dashed: true }], labels: [{ x: R * 0.15, y: R * 0.5, text: 'R' }, { x: pts[1][0] * 0.5 - R * 0.06, y: pts[1][1] * 0.5 + R * 0.08, text: 'r' }] };
        },
    },

    // Solids
    cube: {
        vars: { a: ['Edge a', 1], faceDiag: ['Face diagonal', 1], diag: ['Space diagonal', 1], vol: ['Volume V', 3], surf: ['Surface area A', 2], lat: ['Lateral area (4 faces)', 2], insr: ['Inscribed sphere radius', 1], circr: ['Circumscribed sphere radius', 1] },
        cases: { a: (v) => ({ a: v.a }), vol: (v) => ({ a: Math.cbrt(v.vol) }), surf: (v) => ({ a: sqrt(v.surf / 6) }), diag: (v) => ({ a: v.diag / S3 }), faceDiag: (v) => ({ a: v.faceDiag / S2 }) },
        all: ({ a }) => ({ a, faceDiag: a * S2, diag: a * S3, vol: a ** 3, surf: 6 * a * a, lat: 4 * a * a, insr: a / 2, circr: (a * S3) / 2 }),
        formulas: { a: 'a from the given value', faceDiag: 'f = a√2', diag: 'd = a√3', vol: 'V = a³', surf: 'A = 6a²', lat: '4a²', insr: 'a ÷ 2', circr: 'a√3 ÷ 2' },
        draw: ({ a }, t) => box(a, a, a, t('a'), t('a'), t('a')),
    },
    cuboid: {
        vars: { l: ['Length l', 1], w: ['Width w', 1], h: ['Height h', 1], vol: ['Volume V', 3], surf: ['Surface area A', 2], lat: ['Lateral area (4 sides)', 2], diag: ['Space diagonal d', 1], base: ['Base area', 2] },
        cases: {
            l_w_h: (v) => ({ l: v.l, w: v.w, h: v.h }),
            vol_l_w: (v) => ({ l: v.l, w: v.w, h: v.vol / (v.l * v.w) }),
            surf_l_w: (v) => (v.surf > 2 * v.l * v.w ? { l: v.l, w: v.w, h: (v.surf - 2 * v.l * v.w) / (2 * (v.l + v.w)) } : bad('The surface area must be more than twice the base area.')),
            diag_l_w: (v) => (v.diag > hypot(v.l, v.w) ? { l: v.l, w: v.w, h: sqrt(v.diag ** 2 - v.l ** 2 - v.w ** 2) } : bad('The diagonal must be longer than the base diagonal.')),
        },
        all: ({ l, w, h }) => ({ l, w, h, vol: l * w * h, surf: 2 * (l * w + l * h + w * h), lat: 2 * h * (l + w), diag: sqrt(l * l + w * w + h * h), base: l * w }),
        formulas: { vol: 'V = lwh', surf: 'A = 2(lw + lh + wh)', lat: '2h(l + w)', diag: 'd = √(l² + w² + h²)', base: 'lw', h: 'h from the given values' },
        draw: ({ l, w, h }, t) => box(l, w, h, t('l'), t('w'), t('h')),
    },
    sphere: {
        vars: { r: ['Radius r', 1], d: ['Diameter d', 1], circ: ['Circumference (great circle)', 1], surf: ['Surface area A', 2], vol: ['Volume V', 3], ratio: ['Surface to volume ratio', 'inv'] },
        cases: { r: (v) => ({ r: v.r }), d: (v) => ({ r: v.d / 2 }), circ: (v) => ({ r: v.circ / (2 * PI) }), surf: (v) => ({ r: sqrt(v.surf / (4 * PI)) }), vol: (v) => ({ r: Math.cbrt((3 * v.vol) / (4 * PI)) }) },
        all: ({ r }) => ({ r, d: 2 * r, circ: 2 * PI * r, surf: 4 * PI * r * r, vol: (4 / 3) * PI * r ** 3, ratio: 3 / r }),
        formulas: { r: 'r from the given value', d: 'd = 2r', circ: 'C = 2πr', surf: 'A = 4πr²', vol: 'V = (4/3)πr³', ratio: 'A ÷ V = 3 ÷ r' },
        draw: ({ r }, t) => ({ shapes: [{ points: arc(0, 0, r), closed: true }, { points: ellipsePts(r, r * 0.25), muted: true, dashed: true }, { points: [[0, 0], [r, 0]], muted: true }], dots: [[0, 0]], labels: [{ x: r / 2, y: r * 0.08, text: `r = ${t('r')}` }] }),
    },
    hemisphere: {
        vars: { r: ['Radius r', 1], d: ['Diameter', 1], vol: ['Volume V', 3], curved: ['Curved surface area', 2], base: ['Base (flat) area', 2], surf: ['Total surface area', 2], centroid: ['Centroid height', 1] },
        cases: { r: (v) => ({ r: v.r }), d: (v) => ({ r: v.d / 2 }), vol: (v) => ({ r: Math.cbrt((3 * v.vol) / (2 * PI)) }), curved: (v) => ({ r: sqrt(v.curved / (2 * PI)) }), surf: (v) => ({ r: sqrt(v.surf / (3 * PI)) }) },
        all: ({ r }) => ({ r, d: 2 * r, vol: (2 / 3) * PI * r ** 3, curved: 2 * PI * r * r, base: PI * r * r, surf: 3 * PI * r * r, centroid: (3 * r) / 8 }),
        formulas: { vol: 'V = (2/3)πr³', curved: '2πr²', base: 'πr²', surf: 'A = 3πr²', centroid: '3r ÷ 8', d: 'd = 2r', r: 'r from the given value' },
        draw: ({ r }, t) => ({ shapes: [{ points: arc(0, 0, r, 0, PI, 48) }, { points: ellipsePts(r, r * 0.25) }, { points: [[0, 0], [r, 0]], muted: true }], labels: [{ x: r / 2, y: -r * 0.12, text: `r = ${t('r')}` }] }),
    },
    cylinder: {
        vars: { r: ['Radius r', 1], h: ['Height h', 1], d: ['Diameter', 1], vol: ['Volume V', 3], lat: ['Lateral surface area', 2], base: ['Base area', 2], surf: ['Total surface area', 2], circ: ['Base circumference', 1], diag: ['Longest straight line inside', 1] },
        cases: {
            r_h: (v) => ({ r: v.r, h: v.h }),
            d_h: (v) => ({ r: v.d / 2, h: v.h }),
            vol_r: (v) => ({ r: v.r, h: v.vol / (PI * v.r ** 2) }),
            vol_h: (v) => ({ r: sqrt(v.vol / (PI * v.h)), h: v.h }),
            lat_r: (v) => ({ r: v.r, h: v.lat / (2 * PI * v.r) }),
            lat_h: (v) => ({ r: v.lat / (2 * PI * v.h), h: v.h }),
            surf_r: (v) => (v.surf > 2 * PI * v.r ** 2 ? { r: v.r, h: (v.surf - 2 * PI * v.r ** 2) / (2 * PI * v.r) } : bad('The surface area must exceed the two bases, 2πr².')),
            circ_h: (v) => ({ r: v.circ / (2 * PI), h: v.h }),
        },
        all: ({ r, h }) => ({ r, h, d: 2 * r, vol: PI * r * r * h, lat: 2 * PI * r * h, base: PI * r * r, surf: 2 * PI * r * (r + h), circ: 2 * PI * r, diag: hypot(2 * r, h) }),
        formulas: { vol: 'V = πr²h', lat: '2πrh', base: 'πr²', surf: 'A = 2πr(r + h)', circ: 'C = 2πr', diag: '√(4r² + h²)', d: 'd = 2r', r: 'r from the given values', h: 'h from the given values' },
        draw: ({ r, h }, t) => cylinderDraw(r, h, t('r'), t('h')),
    },
    hollowCylinder: {
        vars: { outer: ['Outer radius R', 1], inner: ['Inner radius r', 1], h: ['Height h', 1], wall: ['Wall thickness', 1], vol: ['Volume of material', 3], hole: ['Volume of the hole', 3], surf: ['Total surface area', 2] },
        cases: {
            outer_inner_h: (v) => (v.outer > v.inner ? { R: v.outer, r: v.inner, h: v.h } : bad('The outer radius must be larger than the inner radius.')),
            outer_wall_h: (v) => (v.wall < v.outer ? { R: v.outer, r: v.outer - v.wall, h: v.h } : bad('The wall must be thinner than the outer radius.')),
        },
        all: ({ R, r, h }) => ({ outer: R, inner: r, h, wall: R - r, vol: PI * (R * R - r * r) * h, hole: PI * r * r * h, surf: 2 * PI * (R + r) * h + 2 * PI * (R * R - r * r) }),
        formulas: { vol: 'V = π(R² − r²)h', hole: 'πr²h', surf: '2π(R + r)h + 2π(R² − r²)', wall: 'R − r', inner: 'r = R − wall' },
        draw: ({ R, r, h }, t) => {
            const d = cylinderDraw(R, h, t('outer'), t('h'));
            d.shapes.push({ points: ellipsePts(r, r * 0.3, 0, h) });
            d.labels.push({ x: 0, y: h + R * 0.42, text: `r = ${t('inner')}` });

            return d;
        },
    },
    cone: {
        vars: { r: ['Base radius r', 1], h: ['Height h', 1], slant: ['Slant height l', 1], d: ['Base diameter', 1], vol: ['Volume V', 3], lat: ['Lateral surface area', 2], base: ['Base area', 2], surf: ['Total surface area', 2], angle: ['Half-angle at the apex', 'deg'] },
        cases: {
            r_h: (v) => ({ r: v.r, h: v.h }),
            d_h: (v) => ({ r: v.d / 2, h: v.h }),
            r_slant: (v) => (v.slant > v.r ? { r: v.r, h: sqrt(v.slant ** 2 - v.r ** 2) } : bad('The slant height must exceed the radius.')),
            h_slant: (v) => (v.slant > v.h ? { r: sqrt(v.slant ** 2 - v.h ** 2), h: v.h } : bad('The slant height must exceed the height.')),
            vol_r: (v) => ({ r: v.r, h: (3 * v.vol) / (PI * v.r ** 2) }),
            vol_h: (v) => ({ r: sqrt((3 * v.vol) / (PI * v.h)), h: v.h }),
            lat_r: (v) => (v.lat > PI * v.r ** 2 ? { r: v.r, h: sqrt((v.lat / (PI * v.r)) ** 2 - v.r ** 2) } : bad('The lateral area must exceed πr².')),
            r_angle: (v) => (v.angle < 90 ? { r: v.r, h: v.r / tan(v.angle * D) } : bad('The half-angle must be below 90°.')),
        },
        all: ({ r, h }) => {
            const l = hypot(r, h);

            return { r, h, slant: l, d: 2 * r, vol: (PI * r * r * h) / 3, lat: PI * r * l, base: PI * r * r, surf: PI * r * (r + l), angle: atan2(r, h) / D };
        },
        formulas: { slant: 'l = √(r² + h²)', vol: 'V = πr²h ÷ 3', lat: 'πrl', base: 'πr²', surf: 'A = πr(r + l)', angle: 'atan(r ÷ h)', d: '2r', r: 'r from the given values', h: 'h from the given values' },
        draw: ({ r, h }, t) => ({ shapes: [{ points: [[-r, 0], [0, h], [r, 0]] }, { points: ellipsePts(r, r * 0.3).filter((p) => p[1] <= 1e-9) }, { points: ellipsePts(r, r * 0.3).filter((p) => p[1] >= -1e-9), muted: true, dashed: true }, { points: [[0, 0], [0, h]], muted: true, dashed: true }, { points: [[0, 0], [r, 0]], muted: true }], labels: [{ x: r / 2, y: -r * 0.3 - Math.max(r, h) * 0.08, text: `r = ${t('r')}` }, { x: -Math.max(r, h) * 0.2, y: h * 0.4, text: `h = ${t('h')}` }, { x: r / 2 + Math.max(r, h) * 0.25, y: h / 2 + Math.max(r, h) * 0.05, text: `l = ${t('slant')}` }] }),
    },
    frustum: {
        vars: { R: ['Bottom radius R', 1], r: ['Top radius r', 1], h: ['Height h', 1], slant: ['Slant height', 1], vol: ['Volume V', 3], lat: ['Lateral surface area', 2], surf: ['Total surface area', 2], top: ['Top area', 2], bottom: ['Bottom area', 2] },
        cases: {
            R_r_h: (v) => ({ R: v.R, r: v.r, h: v.h }),
            R_r_slant: (v) => (v.slant > abs(v.R - v.r) ? { R: v.R, r: v.r, h: sqrt(v.slant ** 2 - (v.R - v.r) ** 2) } : bad('The slant height must exceed R − r.')),
            R_r_vol: (v) => ({ R: v.R, r: v.r, h: (3 * v.vol) / (PI * (v.R ** 2 + v.R * v.r + v.r ** 2)) }),
        },
        all: ({ R, r, h }) => {
            const l = hypot(R - r, h);

            return { R, r, h, slant: l, vol: (PI * h * (R * R + R * r + r * r)) / 3, lat: PI * (R + r) * l, surf: PI * (R + r) * l + PI * (R * R + r * r), top: PI * r * r, bottom: PI * R * R };
        },
        formulas: { slant: 'l = √((R − r)² + h²)', vol: 'V = πh(R² + Rr + r²) ÷ 3', lat: 'π(R + r)l', surf: 'π(R + r)l + π(R² + r²)', top: 'πr²', bottom: 'πR²', h: 'h from the given values' },
        draw: ({ R, r, h }, t) => ({ shapes: [{ points: [[-R, 0], [-r, h]] }, { points: [[R, 0], [r, h]] }, { points: ellipsePts(r, r * 0.3, 0, h) }, { points: ellipsePts(R, R * 0.3).filter((p) => p[1] <= 1e-9) }, { points: ellipsePts(R, R * 0.3).filter((p) => p[1] >= -1e-9), muted: true, dashed: true }], labels: [{ x: 0, y: -R * 0.45, text: `R = ${t('R')}` }, { x: 0, y: h + r * 0.45, text: `r = ${t('r')}` }, { x: R * 0.95, y: h / 2, text: `h = ${t('h')}` }] }),
    },
    pyramid: {
        vars: { l: ['Base length l', 1], w: ['Base width w', 1], h: ['Height h', 1], vol: ['Volume V', 3], base: ['Base area', 2], lat: ['Lateral surface area', 2], surf: ['Total surface area', 2], slantL: ['Slant height on the length faces', 1], slantW: ['Slant height on the width faces', 1], edge: ['Lateral edge', 1], faceAngle: ['Angle between a face and the base', 'deg'] },
        cases: {
            l_w_h: (v) => ({ l: v.l, w: v.w, h: v.h }),
            vol_l_w: (v) => ({ l: v.l, w: v.w, h: (3 * v.vol) / (v.l * v.w) }),
            edge_l_w: (v) => (v.edge > hypot(v.l, v.w) / 2 ? { l: v.l, w: v.w, h: sqrt(v.edge ** 2 - (v.l ** 2 + v.w ** 2) / 4) } : bad('The lateral edge must exceed half the base diagonal.')),
            slantL_l_w: (v) => (v.slantL > v.w / 2 ? { l: v.l, w: v.w, h: sqrt(v.slantL ** 2 - v.w ** 2 / 4) } : bad('The slant height must exceed half the width.')),
        },
        all: ({ l, w, h }) => {
            const sl = hypot(h, w / 2);
            const sw = hypot(h, l / 2);

            return { l, w, h, vol: (l * w * h) / 3, base: l * w, lat: l * sl + w * sw, surf: l * w + l * sl + w * sw, slantL: sl, slantW: sw, edge: sqrt(h * h + (l * l + w * w) / 4), faceAngle: atan2(h, w / 2) / D };
        },
        formulas: { vol: 'V = lwh ÷ 3', base: 'lw', slantL: 'sₗ = √(h² + (w/2)²)', slantW: 'sᵥ = √(h² + (l/2)²)', lat: 'l sₗ + w sᵥ', surf: 'lw + l sₗ + w sᵥ', edge: '√(h² + (l² + w²)/4)', faceAngle: 'atan(h ÷ (w/2))', h: 'h from the given values' },
        draw: ({ l, w, h }, t) => {
            const apex = [l / 2, w / 2, h];
            const [p0, p1, p2, p3] = [[0, 0, 0], [l, 0, 0], [l, w, 0], [0, w, 0]];

            return { shapes: solid([[p0, p1, p2], [p0, apex], [p1, apex], [p2, apex]], [[p2, p3, p0], [p3, apex], [[l / 2, w / 2, 0], apex]]), labels: [{ ...xy(pr([l / 2, 0, 0]), 0, -Math.max(l, h) * 0.07), text: `l = ${t('l')}` }, { ...xy(pr([l, w / 2, 0]), Math.max(l, h) * 0.16, 0), text: `w = ${t('w')}` }, { ...xy(pr([l / 2, w / 2, h / 2]), Math.max(l, h) * 0.1, 0), text: `h = ${t('h')}` }] };
        },
    },
    regularPyramid: {
        fixed: ['n'],
        vars: { a: ['Base edge a', 1], h: ['Height h', 1], vol: ['Volume V', 3], base: ['Base area', 2], lat: ['Lateral surface area', 2], surf: ['Total surface area', 2], slant: ['Slant height (apothem of a face)', 1], edge: ['Lateral edge', 1], faceAngle: ['Angle between a face and the base', 'deg'], edgeAngle: ['Angle between an edge and the base', 'deg'] },
        check: (v) => (Number.isInteger(v.n) && v.n >= 3 && v.n <= 100 ? null : 'The base must have a whole number of sides from 3 to 100.'),
        cases: {
            a_h: (v) => ({ a: v.a, h: v.h }),
            vol_a: (v) => ({ a: v.a, h: (3 * v.vol) / polyArea(v.n, v.a) }),
            a_slant: (v) => (v.slant > polyr(v.n, v.a) ? { a: v.a, h: sqrt(v.slant ** 2 - polyr(v.n, v.a) ** 2) } : bad('The slant height must exceed the base apothem.')),
            a_edge: (v) => (v.edge > polyR(v.n, v.a) ? { a: v.a, h: sqrt(v.edge ** 2 - polyR(v.n, v.a) ** 2) } : bad('The lateral edge must exceed the base circumradius.')),
            a_faceAngle: (v) => (v.faceAngle < 90 ? { a: v.a, h: polyr(v.n, v.a) * tan(v.faceAngle * D) } : bad('The angle must be below 90°.')),
        },
        all: ({ a, h }, v) => {
            const r = polyr(v.n, a);
            const R = polyR(v.n, a);
            const s = hypot(h, r);

            return { a, h, vol: (polyArea(v.n, a) * h) / 3, base: polyArea(v.n, a), lat: (v.n * a * s) / 2, surf: polyArea(v.n, a) + (v.n * a * s) / 2, slant: s, edge: hypot(h, R), faceAngle: atan2(h, r) / D, edgeAngle: atan2(h, R) / D };
        },
        formulas: { vol: 'V = (base area × h) ÷ 3', base: 'n a² ÷ (4 tan(π/n))', slant: 's = √(h² + r²), r = base apothem', lat: 'n a s ÷ 2', surf: 'base + lateral', edge: '√(h² + R²), R = base circumradius', faceAngle: 'atan(h ÷ r)', edgeAngle: 'atan(h ÷ R)', h: 'h from the given values' },
        draw: ({ a, h }, t, v) => {
            const R = polyR(v.n, a);
            const base = polygonPts(Math.min(v.n, 60), R).map(([x, y]) => [x, y, 0]);
            const apex = [0, 0, h];
            const front = base.filter((p) => p[1] <= 1e-9);
            const back = base.filter((p) => p[1] >= -1e-9);

            return { shapes: solid([front, ...front.map((p) => [p, apex])], [back, [[0, 0, 0], apex]]), labels: [{ ...xy(pr([0, 0, h / 2]), R * 0.25, 0), text: `h = ${t('h')}` }, { ...xy(pr([0, -R, 0]), 0, -R * 0.2), text: `a = ${t('a')}` }] };
        },
    },
    tetrahedron: {
        vars: { a: ['Edge a', 1], vol: ['Volume V', 3], surf: ['Surface area', 2], face: ['Face area', 2], h: ['Height', 1], insr: ['Inscribed sphere radius', 1], circr: ['Circumscribed sphere radius', 1] },
        cases: { a: (v) => ({ a: v.a }), vol: (v) => ({ a: Math.cbrt(6 * S2 * v.vol) }), surf: (v) => ({ a: sqrt(v.surf / S3) }), h: (v) => ({ a: v.h / sqrt(2 / 3) }) },
        all: ({ a }) => ({ a, vol: a ** 3 / (6 * S2), surf: S3 * a * a, face: (S3 / 4) * a * a, h: a * sqrt(2 / 3), insr: a / sqrt(24), circr: a * sqrt(3 / 8) }),
        formulas: { vol: 'V = a³ ÷ (6√2)', surf: 'A = √3 a²', face: '(√3/4)a²', h: 'h = a√(2/3)', insr: 'a ÷ √24', circr: 'a√(3/8)', a: 'a from the given value' },
        draw: ({ a }, t) => {
            const p = [[0, 0, 0], [a, 0, 0], [a / 2, (S3 / 2) * a, 0], [a / 2, (S3 / 6) * a, a * sqrt(2 / 3)]];

            return { shapes: solid([[p[0], p[1], p[3], p[0]], [p[1], p[2], p[3]]], [[p[0], p[2]]]), labels: [{ ...xy(pr([a / 2, 0, 0]), 0, -a * 0.08), text: `a = ${t('a')}` }] };
        },
    },
    triPrism: {
        vars: { a: ['Base side a', 1], b: ['Base side b', 1], c: ['Base side c', 1], len: ['Prism length L', 1], vol: ['Volume V', 3], base: ['Base triangle area', 2], lat: ['Lateral area (3 rectangles)', 2], surf: ['Total surface area', 2], baseH: ['Base height onto a', 1] },
        cases: {
            a_b_c_len: (v) => (v.a + v.b > v.c && v.a + v.c > v.b && v.b + v.c > v.a ? { a: v.a, b: v.b, c: v.c, L: v.len } : bad('The three base sides do not form a triangle.')),
            a_baseH_len: (v) => ({ a: v.a, b: hypot(v.a / 2, v.baseH), c: hypot(v.a / 2, v.baseH), L: v.len }),
        },
        all: ({ a, b, c, L }) => {
            const s = (a + b + c) / 2;
            const area = sqrt(Math.max(s * (s - a) * (s - b) * (s - c), 0));

            return { a, b, c, len: L, vol: area * L, base: area, lat: (a + b + c) * L, surf: 2 * area + (a + b + c) * L, baseH: (2 * area) / a };
        },
        formulas: { base: 'Heron: √(s(s − a)(s − b)(s − c))', vol: 'V = base × L', lat: '(a + b + c)L', surf: '2 × base + lateral', baseH: '2 × base ÷ a', b: 'Isosceles base: b = c = √((a/2)² + h²)', c: 'c (as b)' },
        draw: ({ a, b, c, L }, t) => {
            const x = (a * a + b * b - c * c) / (2 * a);
            const y = sqrt(Math.max(b * b - x * x, 0));
            const f = [[0, 0, 0], [a, 0, 0], [x, 0, y]];
            const k = f.map(([px, , pz]) => [px, L, pz]);

            return { shapes: solid([[...f, f[0]], [k[1], k[2]], [f[1], k[1]], [f[2], k[2]]], [[k[0], k[1]], [k[0], k[2]], [f[0], k[0]]]), labels: [{ ...xy(pr([a / 2, 0, 0]), 0, -a * 0.1), text: `a = ${t('a')}` }, { ...xy(pr([a, L / 2, 0]), a * 0.22, 0), text: `L = ${t('len')}` }] };
        },
    },
    trapPrism: {
        vars: { a: ['Bottom base a', 1], b: ['Top base b', 1], h: ['Trapezoid height h', 1], legL: ['Left leg', 1], legR: ['Right leg', 1], len: ['Prism length L', 1], vol: ['Volume V', 3], base: ['Trapezoid area', 2], lat: ['Lateral area (4 rectangles)', 2], surf: ['Total surface area', 2] },
        cases: {
            a_b_h_len: (v) => ({ a: v.a, b: v.b, h: v.h, L: v.len, iso: true }),
            a_b_h_legL_legR_len: (v) => (v.legL >= v.h && v.legR >= v.h ? { a: v.a, b: v.b, h: v.h, L: v.len, c: v.legL, d: v.legR } : bad('Each leg must be at least as long as the height.')),
        },
        all: ({ a, b, h, L, c, d }) => {
            const cc = c ?? hypot(h, (a - b) / 2);
            const dd = d ?? cc;
            const area = ((a + b) / 2) * h;

            return { a, b, h, legL: cc, legR: dd, len: L, vol: area * L, base: area, lat: (a + b + cc + dd) * L, surf: 2 * area + (a + b + cc + dd) * L };
        },
        formulas: { base: '(a + b)h ÷ 2', vol: 'V = base × L', lat: '(a + b + legs) × L', surf: '2 × base + lateral', legL: 'Isosceles: √(h² + ((a − b)/2)²)', legR: 'as the left leg (isosceles)' },
        draw: ({ a, b, h, L }, t) => {
            const off = (a - b) / 2;
            const f = [[0, 0, 0], [a, 0, 0], [a - off, 0, h], [off, 0, h]];
            const k = f.map(([px, , pz]) => [px, L, pz]);

            return { shapes: solid([[...f, f[0]], [k[1], k[2], k[3]], [f[1], k[1]], [f[2], k[2]], [f[3], k[3]]], [[k[3], k[0], k[1]], [f[0], k[0]]]), labels: [{ ...xy(pr([a / 2, 0, 0]), 0, -a * 0.1), text: `a = ${t('a')}` }, { ...xy(pr([a / 2, 0, h]), 0, a * 0.08), text: `b = ${t('b')}` }, { ...xy(pr([a, L / 2, 0]), a * 0.22, 0), text: `L = ${t('len')}` }] };
        },
    },
    ellipsoid: {
        vars: { a: ['Semi-axis a', 1], b: ['Semi-axis b', 1], c: ['Semi-axis c', 1], vol: ['Volume V', 3], surf: ['Surface area A', 2] },
        cases: { a_b_c: (v) => ({ a: v.a, b: v.b, c: v.c }), vol_a_b: (v) => ({ a: v.a, b: v.b, c: (3 * v.vol) / (4 * PI * v.a * v.b) }) },
        all: ({ a, b, c }) => ({ a, b, c, vol: (4 / 3) * PI * a * b * c, surf: ellipsoidArea(a, b, c) }),
        formulas: { vol: 'V = (4/3)πabc', surf: 'A from the exact elliptic-integral formula (numerical integration)', c: 'c = 3V ÷ (4πab)' },
        draw: ({ a, b, c }, t) => ({ shapes: [{ points: ellipsePts(a, c), closed: true }, { points: ellipsePts(a, b * 0.3), muted: true, dashed: true }, { points: [[0, 0], [a, 0]], muted: true }, { points: [[0, 0], [0, c]], muted: true }], labels: [{ x: a / 2, y: -c * 0.1, text: `a = ${t('a')}` }, { x: -a * 0.15, y: c / 2, text: `c = ${t('c')}` }] }),
    },
    torus: {
        vars: { major: ['Major radius R (centre to tube centre)', 1], minor: ['Minor radius r (tube)', 1], outer: ['Outer radius R + r', 1], inner: ['Inner (hole) radius R − r', 1], vol: ['Volume V', 3], surf: ['Surface area A', 2] },
        cases: {
            major_minor: (v) => ({ R: v.major, r: v.minor }),
            outer_inner: (v) => (v.outer > v.inner ? { R: (v.outer + v.inner) / 2, r: (v.outer - v.inner) / 2 } : bad('The outer radius must exceed the inner radius.')),
            vol_major: (v) => ({ R: v.major, r: sqrt(v.vol / (2 * PI * PI * v.major)) }),
            surf_major: (v) => ({ R: v.major, r: v.surf / (4 * PI * PI * v.major) }),
        },
        all: ({ R, r }) => ({ major: R, minor: r, outer: R + r, inner: R - r, vol: 2 * PI * PI * R * r * r, surf: 4 * PI * PI * R * r }),
        check: () => null,
        formulas: { vol: 'V = 2π²Rr²', surf: 'A = 4π²Rr', outer: 'R + r', inner: 'R − r', minor: 'r from the given values', major: 'R from the given values' },
        draw: ({ R, r }, t) => ({ shapes: [{ points: ellipsePts(R + r, (R + r) * 0.4), closed: true }, { points: ellipsePts(Math.max(R - r, 0), Math.max(R - r, 0) * 0.4) }, { points: arc(R, 0, r), muted: true, dashed: true }], labels: [{ x: R, y: r * 1.3 + (R + r) * 0.1, text: `r = ${t('minor')}` }, { x: 0, y: -(R + r) * 0.55, text: `R = ${t('major')}` }] }),
    },
    cap: {
        vars: { r: ['Sphere radius r', 1], h: ['Cap height h', 1], a: ['Base radius a', 1], vol: ['Volume V', 3], curved: ['Curved surface area', 2], base: ['Base area', 2], surf: ['Total surface area', 2] },
        cases: {
            r_h: (v) => (v.h <= 2 * v.r ? { r: v.r, h: v.h } : bad('The cap height cannot exceed the diameter.')),
            a_h: (v) => ({ r: (v.a ** 2 + v.h ** 2) / (2 * v.h), h: v.h }),
            r_a: (v) => (v.a <= v.r ? { r: v.r, h: v.r - sqrt(v.r ** 2 - v.a ** 2) } : bad('The base radius cannot exceed the sphere radius.')),
        },
        all: ({ r, h }) => {
            const a = sqrt(Math.max(h * (2 * r - h), 0));

            return { r, h, a, vol: (PI * h * h * (3 * r - h)) / 3, curved: 2 * PI * r * h, base: PI * a * a, surf: 2 * PI * r * h + PI * a * a };
        },
        formulas: { a: 'a = √(h(2r − h))', vol: 'V = πh²(3r − h) ÷ 3', curved: '2πrh', base: 'πa²', surf: '2πrh + πa²', r: 'r = (a² + h²) ÷ 2h' },
        draw: ({ r, h }, t) => {
            const a = sqrt(Math.max(h * (2 * r - h), 0));
            const y0 = r - h;
            const start = Math.atan2(y0, a);

            return { shapes: [{ points: arc(0, 0, r), muted: true, dashed: true }, { points: [...arc(0, 0, r, start, PI - start, 48), [a, y0]], closed: true }], labels: [{ x: 0, y: y0 - r * 0.12, text: `a = ${t('a')}` }, { x: a * 0.25, y: r - h / 2, text: `h = ${t('h')}` }] };
        },
    },
    capsule: {
        vars: { r: ['Radius r', 1], len: ['Cylinder length a', 1], total: ['Total length a + 2r', 1], vol: ['Volume V', 3], surf: ['Surface area A', 2] },
        cases: {
            r_len: (v) => ({ r: v.r, a: v.len }),
            r_total: (v) => (v.total >= 2 * v.r ? { r: v.r, a: v.total - 2 * v.r } : bad('The total length must be at least the diameter.')),
            vol_r: (v) => (v.vol >= (4 / 3) * PI * v.r ** 3 ? { r: v.r, a: (v.vol - (4 / 3) * PI * v.r ** 3) / (PI * v.r ** 2) } : bad('The volume must be at least that of the sphere, (4/3)πr³.')),
        },
        all: ({ r, a }) => ({ r, len: a, total: a + 2 * r, vol: PI * r * r * ((4 / 3) * r + a), surf: 2 * PI * r * (2 * r + a) }),
        formulas: { vol: 'V = πr²((4/3)r + a)', surf: 'A = 2πr(2r + a)', total: 'a + 2r', len: 'a from the given values' },
        draw: ({ r, a }, t) => ({ shapes: [{ points: [...arc(a, 0, r, -PI / 2, PI / 2, 24), ...arc(0, 0, r, PI / 2, 1.5 * PI, 24), [a, -r]], closed: true }, { points: [[0, -r], [0, r]], muted: true, dashed: true }, { points: [[a, -r], [a, r]], muted: true, dashed: true }], labels: [{ x: a / 2, y: -r * 1.25, text: `a = ${t('len')}` }, { x: -r / 2, y: r * 0.15, text: `r = ${t('r')}` }] }),
    },
};

function starRatio(n) {
    // Regular star {n/2}: inner radius ratio cos(2π/n) ÷ cos(π/n).
    return cos((2 * PI) / n) / cos(PI / n);
}

function starEdge(n, R) {
    const r = R * starRatio(n);

    return sqrt(R * R + r * r - 2 * R * r * cos(PI / n));
}

function starArea(n, R) {
    return n * R * R * starRatio(n) * sin(PI / n);
}

/** Surface area of an ellipsoid (a, b, c any order) from the Legendre form with numerically integrated F and E. */
export function ellipsoidArea(a0, b0, c0) {
    const [a, b, c] = [a0, b0, c0].sort((x, y) => y - x);

    if (abs(a - c) < 1e-12 * a) {
        return 4 * PI * a * a;
    }

    const phi = acos(c / a);
    const k2 = (a * a * (b * b - c * c)) / (b * b * (a * a - c * c));
    const F = integrate((t) => 1 / sqrt(1 - k2 * sin(t) ** 2), 0, phi);
    const E = integrate((t) => sqrt(1 - k2 * sin(t) ** 2), 0, phi);

    return 2 * PI * c * c + ((2 * PI * a * b) / sin(phi)) * (E * sin(phi) ** 2 + F * cos(phi) ** 2);
}

const xy = ([x, y], dx, dy) => ({ x: x + dx, y: y + dy });

function box(l, w, h, tl, tw, th) {
    const p = (x, y, z) => [x, y, z];
    const s = Math.max(l, w, h);

    return {
        shapes: solid([[p(0, 0, 0), p(l, 0, 0), p(l, 0, h), p(0, 0, h), p(0, 0, 0)], [p(l, 0, 0), p(l, w, 0), p(l, w, h), p(l, 0, h)], [p(0, 0, h), p(0, w, h), p(l, w, h)]], [[p(0, 0, 0), p(0, w, 0), p(l, w, 0)], [p(0, w, 0), p(0, w, h)]]),
        labels: [{ ...xy(pr([l / 2, 0, 0]), 0, -s * 0.08), text: `l = ${tl}` }, { ...xy(pr([l, w / 2, 0]), s * 0.2, -s * 0.02), text: `w = ${tw}` }, { ...xy(pr([0, 0, h / 2]), -s * 0.16, 0), text: `h = ${th}` }],
    };
}

function cylinderDraw(r, h, tr, th) {
    const e = ellipsePts(r, r * 0.3);

    return {
        shapes: [{ points: ellipsePts(r, r * 0.3, 0, h) }, { points: e.filter((p) => p[1] <= 1e-9) }, { points: e.filter((p) => p[1] >= -1e-9), muted: true, dashed: true }, { points: [[-r, 0], [-r, h]] }, { points: [[r, 0], [r, h]] }, { points: [[0, h], [r, h]], muted: true }],
        labels: [{ x: 0, y: h + r * 0.3 + Math.max(r, h) * 0.08, text: `r = ${tr}` }, { x: r + Math.max(r, h) * 0.25, y: h / 2, text: `h = ${th}` }],
    };
}

export { sumProduct, polyArea, polyR, polyr, polygonPts, PHI, ellipsePts };
