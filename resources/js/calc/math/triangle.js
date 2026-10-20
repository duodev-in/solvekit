/**
 * General triangle solver. Sides a, b, c are opposite the angles A, B, C (degrees).
 * solve(given, v) returns { triangles: [full measures, …] } (two for the ambiguous SSA case) or { error }.
 */
const { PI, sqrt, sin, cos, acos, asin, abs, hypot, atan2 } = Math;
const D = PI / 180;
const EPS = 1e-10;

/** Every measure of the triangle with sides a, b, c (and optional vertex coordinates). */
export function measures(a, b, c, vertices = null) {
    const A = acos(clamp((b * b + c * c - a * a) / (2 * b * c))) / D;
    const B = acos(clamp((a * a + c * c - b * b) / (2 * a * c))) / D;
    const C = 180 - A - B;
    const s = (a + b + c) / 2;
    const area = sqrt(Math.max(s * (s - a) * (s - b) * (s - c), 0));
    const pts = vertices ?? place(a, b, c);
    const [P, Q, Rv] = pts;
    const centroid = [(P[0] + Q[0] + Rv[0]) / 3, (P[1] + Q[1] + Rv[1]) / 3];
    const circumcenter = circumcentre(P, Q, Rv);
    const incenter = [(a * P[0] + b * Q[0] + c * Rv[0]) / (a + b + c), (a * P[1] + b * Q[1] + c * Rv[1]) / (a + b + c)];
    const orthocenter = [P[0] + Q[0] + Rv[0] - 2 * circumcenter[0], P[1] + Q[1] + Rv[1] - 2 * circumcenter[1]];

    return {
        a, b, c, A, B, C, area, perim: 2 * s, s,
        ha: (2 * area) / a, hb: (2 * area) / b, hc: (2 * area) / c,
        ma: 0.5 * sqrt(2 * b * b + 2 * c * c - a * a), mb: 0.5 * sqrt(2 * a * a + 2 * c * c - b * b), mc: 0.5 * sqrt(2 * a * a + 2 * b * b - c * c),
        ta: (2 * b * c * cos((A * D) / 2)) / (b + c), tb: (2 * a * c * cos((B * D) / 2)) / (a + c), tc: (2 * a * b * cos((C * D) / 2)) / (a + b),
        inr: area / s, circr: (a * b * c) / (4 * area),
        points: pts, centroid, circumcenter, incenter, orthocenter,
        bySides: classifySides(a, b, c), byAngles: classifyAngles(A, B, C),
    };
}

const clamp = (x) => Math.min(1, Math.max(-1, x));

/** Vertices A at the origin, B on the x axis: side c = AB, b = AC, a = BC. */
function place(a, b, c) {
    const x = (b * b + c * c - a * a) / (2 * c);

    return [[0, 0], [c, 0], [x, sqrt(Math.max(b * b - x * x, 0))]];
}

export function circumcentre([ax, ay], [bx, by], [cx, cy]) {
    const d = 2 * (ax * (by - cy) + bx * (cy - ay) + cx * (ay - by));
    const a2 = ax * ax + ay * ay;
    const b2 = bx * bx + by * by;
    const c2 = cx * cx + cy * cy;

    return [(a2 * (by - cy) + b2 * (cy - ay) + c2 * (ay - by)) / d, (a2 * (cx - bx) + b2 * (ax - cx) + c2 * (bx - ax)) / d];
}

export function classifySides(a, b, c) {
    const eq = (x, y) => abs(x - y) <= 1e-9 * Math.max(x, y);

    if (eq(a, b) && eq(b, c)) {
        return 'equilateral';
    }

    return eq(a, b) || eq(b, c) || eq(a, c) ? 'isosceles' : 'scalene';
}

export function classifyAngles(A, B, C) {
    const max = Math.max(A, B, C);

    if (abs(max - 90) < 1e-7) {
        return 'right';
    }

    return max > 90 ? 'obtuse' : 'acute';
}

const ok = (a, b, c) => a > 0 && b > 0 && c > 0 && a + b > c * (1 + EPS) && a + c > b * (1 + EPS) && b + c > a * (1 + EPS);

/**
 * given: 'sss' (a, b, c), 'sas' (b, A, c: two sides and the included angle), 'asa' (B, a, C), 'aas' (A, B, a),
 * 'ssa' (a, b, A: the angle is opposite a), 'coords' (x1, y1, x2, y2, x3, y3).
 */
export function solve(given, v) {
    const pos = (...xs) => xs.every((x) => Number.isFinite(x) && x > 0);

    if (given === 'sss') {
        if (!pos(v.a, v.b, v.c)) {
            return { empty: 'Enter the three sides.' };
        }

        return ok(v.a, v.b, v.c) ? { triangles: [measures(v.a, v.b, v.c)] } : { error: 'These sides break the triangle inequality: each side must be shorter than the other two together.' };
    }

    if (given === 'sas') {
        if (!pos(v.b, v.c, v.A)) {
            return { empty: 'Enter two sides and the angle between them.' };
        }

        if (v.A >= 180) {
            return { error: 'The angle must be below 180°.' };
        }

        const a = sqrt(v.b * v.b + v.c * v.c - 2 * v.b * v.c * cos(v.A * D));

        return { triangles: [measures(a, v.b, v.c)], law: `a² = b² + c² − 2bc cos A = ${round(a * a)}` };
    }

    if (given === 'asa' || given === 'aas') {
        const [A, B, side] = given === 'asa' ? [180 - v.B - v.C, v.B, v.a] : [v.A, v.B, v.a];
        const C = 180 - A - B;

        if (given === 'asa' ? !pos(v.B, v.C, v.a) : !pos(v.A, v.B, v.a)) {
            return { empty: 'Enter two angles and a side.' };
        }

        if (!(A > 0 && C > 0)) {
            return { error: 'The two angles must add up to less than 180°.' };
        }

        const k = side / sin(A * D);

        return { triangles: [measures(side, k * sin(B * D), k * sin(C * D))] };
    }

    if (given === 'ssa') {
        if (!pos(v.a, v.b, v.A)) {
            return { empty: 'Enter two sides and an angle opposite one of them.' };
        }

        if (v.A >= 180) {
            return { error: 'The angle must be below 180°.' };
        }

        const sinB = (v.b * sin(v.A * D)) / v.a;

        if (sinB > 1 + 1e-12) {
            return { error: `No triangle: b sin A = ${round(v.b * sin(v.A * D))} is longer than a, so side a cannot reach the third side.` };
        }

        const B1 = asin(Math.min(sinB, 1)) / D;
        const out = [];

        for (const B of abs(sinB - 1) < 1e-12 ? [B1] : [B1, 180 - B1]) {
            const C = 180 - v.A - B;

            if (C > 1e-9) {
                const c = (v.a * sin(C * D)) / sin(v.A * D);
                out.push(measures(v.a, v.b, c));
            }
        }

        return out.length ? { triangles: out } : { error: 'No triangle has these values.' };
    }

    if (given === 'coords') {
        const p = [[v.x1, v.y1], [v.x2, v.y2], [v.x3, v.y3]];

        if (p.flat().some((x) => !Number.isFinite(x))) {
            return { empty: 'Enter the coordinates of the three vertices.' };
        }

        // Vertex A = (x1, y1), B = (x2, y2), C = (x3, y3): a = BC, b = CA, c = AB.
        const a = hypot(p[1][0] - p[2][0], p[1][1] - p[2][1]);
        const b = hypot(p[0][0] - p[2][0], p[0][1] - p[2][1]);
        const c = hypot(p[0][0] - p[1][0], p[0][1] - p[1][1]);
        const cross = (p[1][0] - p[0][0]) * (p[2][1] - p[0][1]) - (p[2][0] - p[0][0]) * (p[1][1] - p[0][1]);

        if (abs(cross) <= 1e-12 * Math.max(a * a, b * b, c * c, 1)) {
            return { error: 'The three points lie on one line, so they do not form a triangle.' };
        }

        return { triangles: [measures(a, b, c, p)], shoelace: cross / 2 };
    }

    return { empty: 'Choose what you know.' };
}

const round = (x) => Number(x.toPrecision(10));

export { atan2, D };
