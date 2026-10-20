import { defineTools } from '../engines/formula.js';
import * as N from '../math/numtheory.js';
import { arc } from '../math/shapes.js';
import { circumcentre, solve as solveTriangle } from '../math/triangle.js';
import { f, fail, need, R, result } from '../math/util.js';
import { areaConversions, conicCoefficients, measure } from './mt-shape.js';

/**
 * Triangles (general solver, checks, triples, similarity, angles), circles (equations, theorems, tangents,
 * coin rotation, string around the Earth) and angles (between vectors, clock, complementary, coterminal, reference).
 */
const { PI, sqrt, sin, cos, tan, asin, acos, atan, atan2, abs, hypot } = Math;
const D = PI / 180;

const GIVEN_FIELDS = { bh: ['b', 'hb'], sss: ['a', 'b', 'c'], sas: ['b', 'angA', 'c'], asa: ['angB', 'a', 'angC'], aas: ['angA', 'angB', 'a'], ssa: ['a', 'b', 'angA'], coords: ['x1', 'y1', 'x2', 'y2', 'x3', 'y3'] };
const TYPE = { equilateral: 'Equilateral', isosceles: 'Isosceles', scalene: 'Scalene', right: 'right', acute: 'acute', obtuse: 'obtuse' };

function triangleRows(t, u, coords) {
    const L = (x) => measure(x, 1, u);
    const pt = (p) => `(${f(p[0], 10)}, ${f(p[1], 10)})`;

    return {
        sides: `a = ${L(t.a)}, b = ${L(t.b)}, c = ${L(t.c)}`,
        angles: `A = ${f(t.A, 10)}°, B = ${f(t.B, 10)}°, C = ${f(t.C, 10)}°`,
        area: measure(t.area, 2, u),
        perim: L(t.perim),
        heights: `ha = ${L(t.ha)}, hb = ${L(t.hb)}, hc = ${L(t.hc)}`,
        medians: `ma = ${L(t.ma)}, mb = ${L(t.mb)}, mc = ${L(t.mc)}`,
        bisectors: `ta = ${L(t.ta)}, tb = ${L(t.tb)}, tc = ${L(t.tc)}`,
        midsegments: `a/2 = ${L(t.a / 2)}, b/2 = ${L(t.b / 2)}, c/2 = ${L(t.c / 2)}`,
        inr: L(t.inr),
        circr: L(t.circr),
        type: `${TYPE[t.bySides]} ${TYPE[t.byAngles]} triangle`,
        exterior: `${f(180 - t.A, 10)}°, ${f(180 - t.B, 10)}°, ${f(180 - t.C, 10)}° (sum 360°)`,
        centres: `${coords ? '' : 'With A at (0, 0) and B on the x axis: '}centroid ${pt(t.centroid)}, circumcentre ${pt(t.circumcenter)}, incentre ${pt(t.incenter)}, orthocentre ${pt(t.orthocenter)}`,
        areas: areaConversions(t.area, u),
    };
}

function triangleDiagram(t, u, show = 'triangle') {
    const [P, Q, Rv] = t.points;
    const span = Math.max(t.a, t.b, t.c);
    const g = [(P[0] + Q[0] + Rv[0]) / 3, (P[1] + Q[1] + Rv[1]) / 3];
    const away = (p, k, text) => {
        const dx = p[0] - g[0];
        const dy = p[1] - g[1];
        const len = hypot(dx, dy) || 1;

        return { x: p[0] + (dx / len) * k, y: p[1] + (dy / len) * k, text };
    };
    const mid = (p, q) => [(p[0] + q[0]) / 2, (p[1] + q[1]) / 2];
    const shapes = [{ points: [P, Q, Rv, P], closed: true }];
    const dots = [];
    const labels = [away(P, span * 0.08, 'A'), away(Q, span * 0.08, 'B'), away(Rv, span * 0.08, 'C'), away(mid(Q, Rv), span * 0.17, `a = ${measure(t.a, 1, u, 5)}`), away(mid(P, Rv), span * 0.17, `b = ${measure(t.b, 1, u, 5)}`), away(mid(P, Q), span * 0.12, `c = ${measure(t.c, 1, u, 5)}`)];

    if (show === 'circumcenter') {
        shapes.push({ points: arc(t.circumcenter[0], t.circumcenter[1], t.circr), muted: true, dashed: true });
        dots.push(t.circumcenter);
    } else if (show === 'orthocenter') {
        // Altitudes from each vertex to the opposite line.
        [[P, Q, Rv], [Q, Rv, P], [Rv, P, Q]].forEach(([V, S, T]) => {
            const dx = T[0] - S[0];
            const dy = T[1] - S[1];
            const k = ((V[0] - S[0]) * dx + (V[1] - S[1]) * dy) / (dx * dx + dy * dy);
            const foot = [S[0] + k * dx, S[1] + k * dy];
            shapes.push({ points: [V, foot], muted: true, dashed: true });
            shapes.push({ points: [foot, t.orthocenter], muted: true, dashed: true });
        });
        dots.push(t.orthocenter);
    } else if (show === 'centroid') {
        [[P, Q, Rv], [Q, Rv, P], [Rv, P, Q]].forEach(([V, S, T]) => shapes.push({ points: [V, mid(S, T)], muted: true, dashed: true }));
        dots.push(t.centroid);
    } else if (show === 'incircle') {
        shapes.push({ points: arc(t.incenter[0], t.incenter[1], t.inr), muted: true, dashed: true });
        dots.push(t.incenter);
    } else if (show === 'heights') {
        [[P, Q, Rv]].forEach(([V, S, T]) => {
            const dx = T[0] - S[0];
            const dy = T[1] - S[1];
            const k = ((V[0] - S[0]) * dx + (V[1] - S[1]) * dy) / (dx * dx + dy * dy);
            shapes.push({ points: [V, [S[0] + k * dx, S[1] + k * dy]], muted: true, dashed: true });
        });
    } else if (show === 'midsegments') {
        shapes.push({ points: [mid(P, Q), mid(Q, Rv), mid(Rv, P), mid(P, Q)], muted: true, dashed: true });
    }

    return { kind: 'diagram', shapes, dots, labels };
}

const WANT = {
    missing: null,
    area: ['area', 2, 'Area'],
    perim: ['perim', 1, 'Perimeter'],
    circr: ['circr', 1, 'Circumradius R'],
    inr: ['inr', 1, 'Inradius r'],
    hc: ['hc', 1, 'Height to side c'],
    c: ['c', 1, 'Side c'],
};

/** General triangle: c.want picks the headline; SSA can give two triangles. */
function triangle(i, c) {
    const u = i.unit ?? 'cm';
    const given = c.given ?? i.given ?? 'sss';
    const fields = GIVEN_FIELDS[given];

    if (!fields) {
        return need('Choose what you know.');
    }

    const v = Object.fromEntries(fields.map((k) => [k, Number(i[k])]));

    if (given === 'bh') {
        if (!(v.b > 0 && v.hb > 0)) {
            return need('Enter the base and the height to it.');
        }

        const area = (v.b * v.hb) / 2;
        const text = measure(area, 2, u).match(/^(\S+)\s*(.*)$/);
        const more = 'Needs a side or an angle as well (choose another option)';

        return result(text[1], 'Area', { unit: text[2], sub: 'A = base × height ÷ 2', rows: { sides: more, angles: more, area: measure(area, 2, u), perim: more, heights: `Height to the base ${measure(v.hb, 1, u)}`, medians: more, bisectors: more, midsegments: more, inr: more, circr: more, type: more, exterior: more, centres: more, areas: areaConversions(area, u), second: 'Not ambiguous' }, steps: [`A = ½ × b × h = ½ × ${measure(v.b, 1, u)} × ${measure(v.hb, 1, u)} = ${measure(area, 2, u)}`], plots: { diagram: { kind: 'diagram', shapes: [{ points: [[0, 0], [v.b, 0], [v.b * 0.35, v.hb], [0, 0]], closed: true }, { points: [[v.b * 0.35, 0], [v.b * 0.35, v.hb]], muted: true, dashed: true }], labels: [{ x: v.b / 2, y: -v.hb * 0.1, text: `b = ${measure(v.b, 1, u, 5)}` }, { x: v.b * 0.35 + v.b * 0.1, y: v.hb / 2, text: `h = ${measure(v.hb, 1, u, 5)}` }] } } });
    }

    const solved = solveTriangle(given, { a: v.a, b: v.b, c: v.c, A: v.angA, B: v.angB, C: v.angC, x1: v.x1, y1: v.y1, x2: v.x2, y2: v.y2, x3: v.x3, y3: v.y3 });

    if (solved.empty) {
        return need(solved.empty);
    }

    if (solved.error) {
        return fail(solved.error);
    }

    const [t, t2] = solved.triangles;
    const rows = triangleRows(t, u, given === 'coords');
    rows.second = t2 ? `Second triangle: c = ${measure(t2.c, 1, u)}, B = ${f(t2.B, 10)}°, C = ${f(t2.C, 10)}°, area ${measure(t2.area, 2, u)}` : given === 'ssa' ? 'Only one triangle fits' : 'Not ambiguous';
    const steps = [];
    const G = { sss: 'Three sides (SSS)', sas: 'Two sides and the included angle (SAS)', asa: 'Two angles and the side between them (ASA)', aas: 'Two angles and a side not between them (AAS)', ssa: 'Two sides and a non-included angle (SSA)', coords: 'Three vertices' }[given];
    steps.push(`Known: ${G}`);

    if (given === 'sss' || given === 'coords') {
        if (given === 'coords') {
            steps.push(`Side lengths from the distance formula: a = BC = ${f(t.a, 10)}, b = CA = ${f(t.b, 10)}, c = AB = ${f(t.c, 10)}`, `Shoelace area = ½|x₁(y₂ − y₃) + x₂(y₃ − y₁) + x₃(y₁ − y₂)| = ${f(abs(solved.shoelace), 12)}`);
        }

        steps.push(`Law of cosines: A = acos((b² + c² − a²) ÷ 2bc) = ${f(t.A, 10)}°`, `B = acos((a² + c² − b²) ÷ 2ac) = ${f(t.B, 10)}°`, `C = 180° − A − B = ${f(t.C, 10)}°`);
    } else if (given === 'sas') {
        steps.push(`Law of cosines: a = √(b² + c² − 2bc cos A) = ${f(t.a, 10)}`, `Then B = ${f(t.B, 10)}° and C = ${f(t.C, 10)}°`);
    } else if (given === 'ssa') {
        steps.push(`Law of sines: sin B = b sin A ÷ a = ${f((t.b * sin(t.A * D)) / t.a, 10)}`, t2 ? `Two angles have this sine: B = ${f(t.B, 10)}° or ${f(t2.B, 10)}°, so two triangles fit (the ambiguous case)` : `B = ${f(t.B, 10)}° (the obtuse alternative does not fit)`, `C = 180° − A − B, c = a sin C ÷ sin A = ${f(t.c, 10)}`);
    } else {
        steps.push(`Third angle: 180° minus the other two`, `Law of sines: a ÷ sin A = b ÷ sin B = c ÷ sin C = ${f(t.a / sin(t.A * D), 10)}`, `Sides: a = ${f(t.a, 10)}, b = ${f(t.b, 10)}, c = ${f(t.c, 10)}`);
    }

    steps.push(`Area = ½ab sin C = ${measure(t.area, 2, u)}`, `Perimeter = ${measure(t.perim, 1, u)}`);
    const want = c.want ?? 'missing';
    const draw = c.draw ?? (want === 'circr' ? 'circumcenter' : want === 'inr' ? 'incircle' : 'triangle');
    const plots = { diagram: triangleDiagram(t, u, draw) };

    if (['circumcenter', 'orthocenter', 'centroid', 'incenter'].includes(want)) {
        const p = t[want];
        const names = { circumcenter: 'Circumcentre', orthocenter: 'Orthocentre', centroid: 'Centroid', incenter: 'Incentre' };

        return result(`(${f(p[0], 10)}, ${f(p[1], 10)})`, names[want], { sub: want === 'circumcenter' ? `Circumradius ${measure(t.circr, 1, u)}` : want === 'incenter' ? `Inradius ${measure(t.inr, 1, u)}` : rows.type, rows, steps: [...steps, want === 'centroid' ? 'Centroid = average of the vertices' : want === 'circumcenter' ? 'Circumcentre: where the perpendicular bisectors meet (equidistant from the vertices)' : want === 'orthocenter' ? 'Orthocentre: where the altitudes meet (H = A + B + C − 2O)' : 'Incentre = (aA + bB + cC) ÷ (a + b + c)', `${names[want]} = (${f(p[0], 12)}, ${f(p[1], 12)})`], plots: { diagram: triangleDiagram(t, u, want === 'incenter' ? 'incircle' : want) } });
    }

    if (want === 'type') {
        return result(rows.type.replace(/^./, (ch) => ch.toUpperCase()), 'Classification', { sub: `${{ equilateral: 'All sides equal', isosceles: 'Two sides equal', scalene: 'No sides equal' }[t.bySides]}; largest angle ${f(Math.max(t.A, t.B, t.C), 10)}°`, rows, steps: [...steps, `By sides: ${t.bySides}`, `By angles: ${t.byAngles} (largest angle ${f(Math.max(t.A, t.B, t.C), 10)}°)`], plots });
    }

    if (want === 'angles') {
        return result(`${f(t.A, 8)}°, ${f(t.B, 8)}°, ${f(t.C, 8)}°`, 'Angles A, B, C', { sub: `Exterior angles ${rows.exterior}`, rows, steps, plots });
    }

    if (want === 'heights') {
        return result(measure(t.hc, 1, u), 'Height to side c', { sub: `ha = ${measure(t.ha, 1, u)}, hb = ${measure(t.hb, 1, u)}`, rows, steps: [...steps, 'h = 2 × area ÷ base'], plots: { diagram: triangleDiagram(t, u, 'heights') } });
    }

    if (want === 'midsegments') {
        return result(`${measure(t.a / 2, 1, u, 8)}, ${measure(t.b / 2, 1, u, 8)}, ${measure(t.c / 2, 1, u, 8)}`, 'Midsegments (parallel to a, b, c)', { sub: 'Each midsegment is half the side it is parallel to', rows, steps: [...steps, 'Midsegment theorem: joining two midpoints gives a segment parallel to the third side and half as long'], plots: { diagram: triangleDiagram(t, u, 'midsegments') } });
    }

    if (want === 'missing') {
        const parts = [];

        if (!fields.includes('a') && given !== 'coords') {
            parts.push(`a = ${measure(t.a, 1, u, 8)}`);
        }

        if (!fields.includes('b') && given !== 'coords') {
            parts.push(`b = ${measure(t.b, 1, u, 8)}`);
        }

        if (!fields.includes('c') && given !== 'coords') {
            parts.push(`c = ${measure(t.c, 1, u, 8)}`);
        }

        ['A', 'B', 'C'].forEach((k) => !fields.includes(`ang${k}`) && given !== 'coords' && parts.push(`${k} = ${f(t[k], 8)}°`));

        if (given === 'coords') {
            parts.push(`a = ${measure(t.a, 1, u, 8)}`, `b = ${measure(t.b, 1, u, 8)}`, `c = ${measure(t.c, 1, u, 8)}`);
        }

        return result(t2 ? `Two triangles: c = ${measure(t.c, 1, u, 8)} or ${measure(t2.c, 1, u, 8)}` : parts.join(', '), t2 ? 'Ambiguous case' : given === 'coords' ? 'Side lengths' : 'Missing sides and angles', { sub: `Area ${measure(t.area, 2, u)} · ${rows.type}`, rows, steps, plots });
    }

    const [key, dim, label] = WANT[want];
    const text = measure(t[key], dim, u);
    const m = text.match(/^(\S+)\s*(.*)$/);

    return result(m[1], label, { unit: m[2], sub: t2 ? `Second triangle: ${measure(t2[key], dim, u)}` : want === 'area' ? `Perimeter ${measure(t.perim, 1, u)}` : `Area ${measure(t.area, 2, u)}`, rows, steps, plots });
}

export const handlers = {
    triangle,

    sides_check: (i, c) => {
        const sides = [i.a, i.b, i.c].map((x) => R.parseNumber(String(x ?? '')));

        if (sides.some((s) => !s || R.sign(s) <= 0)) {
            return need('Enter three positive side lengths (fractions allowed).');
        }

        const [a, b, cc] = sides;
        const t = (x) => R.toFraction(x);
        const sq = (x) => (R.isInt(x) ? `${t(x)}²` : `(${t(x)})²`);

        if (c.mode === 'right') {
            const sorted = [...sides].sort((x, y) => R.cmp(x, y));
            const [p, q, h] = sorted;
            const lhs = R.add(R.mul(p, p), R.mul(q, q));
            const rhs = R.mul(h, h);
            const right = R.eq(lhs, rhs);
            const cmp = R.cmp(lhs, rhs);

            return result(right ? 'Yes, a right triangle' : 'No', 'Is it a right triangle?', { sub: right ? `${sq(p)} + ${sq(q)} = ${sq(h)}` : `${sq(p)} + ${sq(q)} = ${t(lhs)} ${cmp > 0 ? '>' : '<'} ${sq(h)} = ${t(rhs)}, so it is ${cmp > 0 ? 'acute' : 'obtuse'}`, rows: { lhs: t(lhs), rhs: t(rhs), kind: right ? 'Right' : cmp > 0 ? 'Acute (a² + b² > c²)' : 'Obtuse (a² + b² < c²)', valid: R.cmp(R.add(p, q), h) > 0 ? 'The sides form a triangle' : 'These sides do not even form a triangle' }, steps: ['Take the longest side as c', `a² + b² = ${sq(p)} + ${sq(q)} = ${t(lhs)}`, `c² = ${sq(h)} = ${t(rhs)}`, right ? 'Equal, so the converse of Pythagoras says the triangle is right-angled' : 'Not equal, so it is not a right triangle'] });
        }

        const checks = [[a, b, cc, 'a + b > c'], [a, cc, b, 'a + c > b'], [b, cc, a, 'b + c > a']].map(([x, y, z, label]) => [label, R.cmp(R.add(x, y), z) > 0, R.add(x, y), z]);
        const okAll = checks.every((k) => k[1]);
        const degenerate = checks.some(([, , s, z]) => R.eq(s, z));
        const sorted = [...sides].sort((x, y) => R.cmp(x, y));

        return result(okAll ? 'Yes, these sides form a triangle' : 'No triangle', 'Triangle inequality', { sub: okAll ? 'Each side is shorter than the other two together' : degenerate ? 'Two sides add up exactly to the third: the points lie on a line (degenerate triangle)' : 'One side is too long', rows: { checks: checks.map(([label, ok2, s, z]) => `${label}: ${t(s)} ${ok2 ? '>' : '≤'} ${t(z)} ${ok2 ? '✓' : '✗'}`).join('; '), range: `For the other two sides ${t(sorted[0])} and ${t(sorted[1])}, the third side must lie strictly between ${t(R.sub(sorted[1], sorted[0]))} and ${t(R.add(sorted[0], sorted[1]))}` }, steps: checks.map(([label, ok2, s, z]) => `${label}: ${t(s)} ${ok2 ? '>' : '≤'} ${t(z)}`) });
    },

    pyth_triples: (i) => {
        const mode = i.mode ?? 'list';

        if (mode === 'euclid') {
            const m = N.parseBig(String(i.m ?? ''));
            const n = N.parseBig(String(i.n ?? ''));

            if (m === null || n === null || !(m > n && n > 0n)) {
                return need('Enter whole numbers m > n > 0.');
            }

            const a = m * m - n * n;
            const b = 2n * m * n;
            const cc = m * m + n * n;
            const primitive = N.egcd(m, n)[0] === 1n && (m - n) % 2n === 1n;

            return result(`(${R.fmt(a)}, ${R.fmt(b)}, ${R.fmt(cc)})`, 'Pythagorean triple', { sub: primitive ? 'Primitive (no common factor)' : 'Not primitive: m and n must be coprime and of opposite parity', rows: { first: `(${R.fmt(a)}, ${R.fmt(b)}, ${R.fmt(cc)})`, check: `${R.fmt(a)}² + ${R.fmt(b)}² = ${R.fmt(a * a + b * b)} = ${R.fmt(cc)}²`, primitive: primitive ? 'Yes' : 'No', perimeter: R.fmt(a + b + cc), area: R.fmt((a * b) / 2n) }, steps: ['Euclid: a = m² − n², b = 2mn, c = m² + n²', `a = ${R.fmt(a)}, b = ${R.fmt(b)}, c = ${R.fmt(cc)}`] });
        }

        if (mode === 'check') {
            const xs = [i.a, i.b, i.c].map((x) => N.parseBig(String(x ?? '')));

            if (xs.some((x) => x === null || x <= 0n)) {
                return need('Enter three positive whole numbers.');
            }

            const [p, q, h] = xs.sort((x, y) => (x < y ? -1 : x > y ? 1 : 0));
            const isTriple = p * p + q * q === h * h;
            const g = N.egcd(N.egcd(p, q)[0], h)[0];

            return result(isTriple ? 'Yes' : 'No', 'Pythagorean triple?', { sub: `${R.fmt(p)}² + ${R.fmt(q)}² = ${R.fmt(p * p + q * q)}, ${R.fmt(h)}² = ${R.fmt(h * h)}`, rows: { first: `(${R.fmt(p)}, ${R.fmt(q)}, ${R.fmt(h)})`, check: isTriple ? 'a² + b² = c²' : 'a² + b² ≠ c²', primitive: isTriple ? (g === 1n ? 'Primitive' : `${R.fmt(g)} × (${R.fmt(p / g)}, ${R.fmt(q / g)}, ${R.fmt(h / g)})`) : 'Not a triple', perimeter: R.fmt(p + q + h), area: isTriple ? R.fmt((p * q) / 2n) : 'Not a right triangle' }, steps: [`${R.fmt(p)}² + ${R.fmt(q)}² = ${R.fmt(p * p + q * q)}`, `${R.fmt(h)}² = ${R.fmt(h * h)}`] });
        }

        const limit = Math.round(Number(i.limit));

        if (!(limit >= 5 && limit <= 2000)) {
            return need('Enter a largest hypotenuse from 5 to 2,000.');
        }

        const triples = [];

        for (let m = 2; m * m < limit; m += 1) {
            for (let n = 1; n < m; n += 1) {
                if ((m - n) % 2 === 1 && Number(N.egcd(BigInt(m), BigInt(n))[0]) === 1) {
                    const [a, b, cc] = [m * m - n * n, 2 * m * n, m * m + n * n];

                    for (let k = 1; k * cc <= limit; k += 1) {
                        triples.push([Math.min(k * a, k * b), Math.max(k * a, k * b), k * cc, k === 1]);
                    }
                }
            }
        }

        triples.sort((x, y) => x[2] - y[2] || x[0] - y[0]);
        const primitive = triples.filter((t) => t[3]).length;

        return result(`${triples.length} triples`, `Pythagorean triples with c ≤ ${limit}`, { sub: `${primitive} primitive`, rows: { first: triples.slice(0, 12).map((t) => `(${t[0]}, ${t[1]}, ${t[2]})`).join(', '), primitive: String(primitive), check: 'Every triple satisfies a² + b² = c²', perimeter: triples.length ? `Largest: (${triples[triples.length - 1].slice(0, 3).join(', ')})` : 'None', area: 'Generated by Euclid\'s formula and multiples' }, steps: triples.slice(0, 300).map((t) => `(${t[0]}, ${t[1]}, ${t[2]})${t[3] ? ' primitive' : ''}`).concat(triples.length > 300 ? [`… ${triples.length - 300} more`] : []) });
    },

    similar: (i, c) => {
        const mode = c.mode ?? i.mode ?? 'solve';
        const u = i.unit ?? 'cm';
        const T1 = [i.a1, i.b1, i.c1].map(Number);

        if (mode === 'proportion') {
            const vals = [i.ad, i.db, i.ae, i.ec].map((x) => (x === '' || x === undefined || Number.isNaN(Number(x)) ? null : Number(x)));
            const blanks = vals.map((x, k) => (x === null ? k : -1)).filter((k) => k >= 0);

            if (blanks.length !== 1 || vals.some((x) => x !== null && !(x > 0))) {
                return need('Enter three of AD, DB, AE and EC and leave the unknown one blank.');
            }

            const [ad, db, ae, ec] = vals;
            const solved = [ae * db / ec, ad * ec / ae, ad * ec / db, ae * db / ad][blanks[0]];
            const names = ['AD', 'DB', 'AE', 'EC'];
            const filled = vals.map((x, k) => (k === blanks[0] ? solved : x));

            return result(measure(solved, 1, u).split(' ')[0], names[blanks[0]], { unit: measure(solved, 1, u).split(' ').slice(1).join(' '), sub: `AD/DB = AE/EC = ${f(filled[0] / filled[1], 10)}`, rows: { ratio: f(filled[0] / filled[1], 12), sides: `AD = ${f(filled[0], 10)}, DB = ${f(filled[1], 10)}, AE = ${f(filled[2], 10)}, EC = ${f(filled[3], 10)}`, area: `Small triangle ADE is ${f((filled[0] / (filled[0] + filled[1])) ** 2 * 100, 8)}% of ABC`, k: `AB/AD = ${f((filled[0] + filled[1]) / filled[0], 10)}` }, steps: ['A line parallel to one side divides the other two sides proportionally: AD/DB = AE/EC', `${names[blanks[0]]} = ${f(solved, 12)}`] });
        }

        if (T1.some((x) => !(x > 0))) {
            return need('Enter the three sides of the first triangle.');
        }

        const [a, b, cc] = T1;

        if (!(a + b > cc && a + cc > b && b + cc > a)) {
            return fail('The first triangle\'s sides break the triangle inequality.');
        }

        if (mode === 'check') {
            const T2 = [i.a2, i.b2, i.c2].map(Number);

            if (T2.some((x) => !(x > 0))) {
                return need('Enter the three sides of the second triangle.');
            }

            const s1 = [...T1].sort((x, y) => x - y);
            const s2 = [...T2].sort((x, y) => x - y);
            const ratios = s2.map((x, k) => x / s1[k]);
            const similar = ratios.every((r) => abs(r - ratios[0]) < 1e-9 * ratios[0]);
            const congruent = similar && abs(ratios[0] - 1) < 1e-9;

            return result(congruent ? 'Congruent (SSS)' : similar ? 'Similar (SSS)' : 'Not similar', 'Similarity', { sub: similar ? `Scale factor ${f(ratios[0], 10)}` : `Side ratios ${ratios.map((r) => f(r, 6)).join(', ')} differ`, rows: { k: similar ? f(ratios[0], 12) : 'None', ratio: ratios.map((r) => f(r, 10)).join(', '), area: similar ? `Area ratio k² = ${f(ratios[0] ** 2, 10)}` : 'Not similar', sides: `Sorted: (${s1.map((x) => f(x)).join(', ')}) and (${s2.map((x) => f(x)).join(', ')})` }, steps: ['Sort both triangles\' sides and divide matching sides', ...ratios.map((r, k) => `${f(s2[k])} ÷ ${f(s1[k])} = ${f(r, 10)}`), similar ? 'All ratios are equal, so the triangles are similar (SSS similarity)' : 'The ratios differ, so the triangles are not similar'] });
        }

        // Solve: one side of the second triangle (matching a, b or c) or a scale factor.
        const known = i.match ?? 'a';
        const value = Number(i.side2);
        const k = known === 'k' ? value : value / { a, b, c: cc }[known];

        if (!(k > 0)) {
            return need(known === 'k' ? 'Enter the scale factor.' : 'Enter the matching side of the second triangle.');
        }

        const s = (a + b + cc) / 2;
        const area1 = sqrt(s * (s - a) * (s - b) * (s - cc));
        const L = (x) => measure(x, 1, u);

        return result(f(k, 10), 'Scale factor k', { sub: `Second triangle: ${L(a * k)}, ${L(b * k)}, ${L(cc * k)}`, rows: { k: f(k, 12), ratio: `a′ = ${L(a * k)}, b′ = ${L(b * k)}, c′ = ${L(cc * k)}`, area: `${measure(area1, 2, u)} → ${measure(area1 * k * k, 2, u)} (× k² = ${f(k * k, 10)})`, sides: `Perimeters ${L(2 * s)} → ${L(2 * s * k)} (× k)` }, steps: [known === 'k' ? `k = ${f(k)}` : `k = ${f(value)} ÷ ${f({ a, b, c: cc }[known])} = ${f(k, 12)}`, 'Multiply every side by k; angles stay the same', `Areas scale by k² = ${f(k * k, 12)}`] });
    },

    tri_angles: (i, c) => {
        const [A, B] = [i.angA, i.angB].map(Number);

        if (!(A > 0 && B > 0)) {
            return need('Enter two interior angles.');
        }

        const C = 180 - A - B;

        if (!(C > 0)) {
            return fail(`The two angles add up to ${f(A + B)}°, but they must total less than 180°.`);
        }

        const max = Math.max(A, B, C);
        const kind = abs(max - 90) < 1e-9 ? 'Right' : max > 90 ? 'Obtuse' : 'Acute';
        const iso = abs(A - B) < 1e-9 || abs(A - C) < 1e-9 || abs(B - C) < 1e-9;

        const sines = [A, B, C].map((x) => sin(x * D));
        const ratio = sines.map((x) => f(x / sines[0], 8)).join(' : ');

        if (c.want === 'exterior') {
            return result(`${f(180 - A, 12)}°, ${f(180 - B, 12)}°, ${f(180 - C, 12)}°`, 'Exterior angles', { sub: 'They always add up to 360°', rows: { exterior: `${f(180 - A, 12)}°, ${f(180 - B, 12)}°, ${f(180 - C, 12)}° (sum 360°)`, kind: `Third interior angle C = ${f(C, 12)}°`, radians: `${f(A * D, 10)}, ${f(B * D, 10)}, ${f(C * D, 10)} rad`, remote: `Exterior angle at C = A + B = ${f(A + B, 12)}°`, ratio: `a : b : c = ${ratio}` }, steps: ['Exterior angle = 180° − interior angle', `At A: 180° − ${f(A)}° = ${f(180 - A, 12)}°`, `At B: 180° − ${f(B)}° = ${f(180 - B, 12)}°`, `At C: 180° − ${f(C, 12)}° = ${f(180 - C, 12)}°`, 'Exterior angle theorem: each equals the sum of the two remote interior angles'] });
        }

        return result(f(C, 12), 'Third angle C', { unit: '°', sub: 'A + B + C = 180°', rows: { ratio: `a : b : c = sin A : sin B : sin C = ${ratio}`, exterior: `${f(180 - A, 12)}°, ${f(180 - B, 12)}°, ${f(180 - C, 12)}° (sum 360°)`, kind: `${kind}${abs(A - 60) < 1e-9 && abs(B - 60) < 1e-9 ? ', equilateral' : iso ? ', isosceles' : ''}`, radians: `${f(A * D, 10)}, ${f(B * D, 10)}, ${f(C * D, 10)} rad`, remote: `Exterior angle at C = A + B = ${f(A + B, 12)}°` }, steps: ['Triangle sum theorem: A + B + C = 180°', `C = 180° − ${f(A)}° − ${f(B)}° = ${f(C, 12)}°`, 'Each exterior angle = 180° − interior angle = sum of the two remote interior angles'] });
    },

    circle_eq: (i, c) => {
        const mode = c.given ?? i.given ?? 'center';
        let h;
        let k;
        let r;
        const steps = [];

        if (mode === 'center') {
            [h, k, r] = [i.h, i.k, i.r].map(Number);

            if (![h, k].every(Number.isFinite) || !(r > 0)) {
                return need('Enter the centre (h, k) and the radius.');
            }
        } else if (mode === 'diameter') {
            const [x1, y1, x2, y2] = [i.x1, i.y1, i.x2, i.y2].map(Number);

            if (![x1, y1, x2, y2].every(Number.isFinite) || (x1 === x2 && y1 === y2)) {
                return need('Enter the two different endpoints of the diameter.');
            }

            [h, k, r] = [(x1 + x2) / 2, (y1 + y2) / 2, hypot(x2 - x1, y2 - y1) / 2];
            steps.push(`Centre = midpoint = ((${f(x1)} + ${f(x2)}) ÷ 2, (${f(y1)} + ${f(y2)}) ÷ 2) = (${f(h, 10)}, ${f(k, 10)})`, `Radius = half the distance = ${f(r, 10)}`);
        } else if (mode === 'points') {
            const p = [[i.x1, i.y1], [i.x2, i.y2], [i.x3, i.y3]].map((q) => q.map(Number));

            if (p.flat().some((x) => !Number.isFinite(x))) {
                return need('Enter three points on the circle.');
            }

            const cross = (p[1][0] - p[0][0]) * (p[2][1] - p[0][1]) - (p[2][0] - p[0][0]) * (p[1][1] - p[0][1]);

            if (abs(cross) < 1e-12) {
                return fail('The three points lie on a line, so no circle passes through them.');
            }

            [h, k] = circumcentre(...p);
            r = hypot(p[0][0] - h, p[0][1] - k);
            steps.push('The centre is equidistant from the three points (where the perpendicular bisectors meet)', `Centre (${f(h, 10)}, ${f(k, 10)}), radius ${f(r, 10)}`);
        } else {
            const co = conicCoefficients(String(i.eq ?? ''));

            if (co.error) {
                return String(i.eq ?? '').trim() ? fail(co.error) : need('Type the equation, such as x^2 + y^2 - 4x + 6y - 3 = 0.');
            }

            if (abs(co.B) > 1e-12 || abs(co.A - co.C) > 1e-12 * Math.max(abs(co.A), 1) || co.A === 0) {
                return fail('This is not a circle: the x² and y² coefficients must be equal and there must be no xy term.');
            }

            const [D0, E0, F0] = [co.D / co.A, co.E / co.A, co.F / co.A];
            [h, k] = [-D0 / 2, -E0 / 2];
            const r2 = h * h + k * k - F0;

            if (!(r2 > 0)) {
                return fail(r2 === 0 ? 'The radius is 0: the equation describes a single point.' : 'No real circle: completing the square gives a negative r².');
            }

            r = sqrt(r2);
            steps.push(`Divide by ${f(co.A)}: x² + y² ${D0 < 0 ? '−' : '+'} ${f(abs(D0), 10)}x ${E0 < 0 ? '−' : '+'} ${f(abs(E0), 10)}y ${F0 < 0 ? '−' : '+'} ${f(abs(F0), 10)} = 0`, `Complete the square: (x − h)² + (y − k)² = h² + k² − F with h = −D/2, k = −E/2`, `r² = ${f(r2, 12)}`);
        }

        const sh = (v, n) => (abs(v) < 1e-12 ? `${n}²` : `(${n} ${v > 0 ? '−' : '+'} ${f(abs(v), 10)})²`);
        const standard = `${sh(h, 'x')} + ${sh(k, 'y')} = ${f(r * r, 10)}`;
        const [D1, E1, F1] = [-2 * h, -2 * k, h * h + k * k - r * r];
        const term = (v, s) => (abs(v) < 1e-12 ? '' : ` ${v < 0 ? '−' : '+'} ${f(abs(v), 10)}${s}`);
        const general = `x² + y²${term(D1, 'x')}${term(E1, 'y')}${term(F1, '')} = 0`;
        const rows = { standard, general, center: `(${f(h, 10)}, ${f(k, 10)})`, radius: f(r, 12), diameter: f(2 * r, 12), area: f(PI * r * r, 12), circ: f(2 * PI * r, 12), param: `x = ${f(h, 8)} + ${f(r, 8)} cos t, y = ${f(k, 8)} + ${f(r, 8)} sin t` };
        const want = c.want ?? 'standard';
        const value = { standard, general, center: rows.center, radius: rows.radius }[want];
        steps.push(`Standard form (x − h)² + (y − k)² = r²: ${standard}`, `Expanded (general form): ${general}`);

        return result(value, { standard: 'Standard form', general: 'General form', center: 'Centre', radius: 'Radius' }[want], { sub: want === 'standard' ? `Centre (${f(h, 10)}, ${f(k, 10)}), radius ${f(r, 10)}` : standard, rows, steps, plots: { diagram: { kind: 'diagram', shapes: [{ points: [[Math.min(0, h - r) - r * 0.2, 0], [Math.max(0, h + r) + r * 0.2, 0]], muted: true }, { points: [[0, Math.min(0, k - r) - r * 0.2], [0, Math.max(0, k + r) + r * 0.2]], muted: true }, { points: arc(h, k, r), closed: true }, { points: [[h, k], [h + r, k]], muted: true, dashed: true }], dots: [[h, k]], labels: [{ x: h, y: k - r * 0.15, text: `(${f(h, 4)}, ${f(k, 4)})` }] } } });
    },

    circle_theorems: (i) => {
        const th = i.theorem ?? 'inscribed';
        const val = (x) => (x === '' || x === undefined || x === null || Number.isNaN(Number(x)) ? null : Number(x));

        if (th === 'inscribed') {
            const [central, inscribed] = [val(i.central), val(i.inscribed)];

            if ((central === null) === (inscribed === null)) {
                return need('Enter either the central angle or the inscribed angle (leave the other blank).');
            }

            const ce = central ?? 2 * inscribed;
            const ins = inscribed ?? central / 2;

            if (!(ce > 0 && ce < 360)) {
                return fail('The central angle must be between 0° and 360°.');
            }

            return result(f(central === null ? ce : ins, 12), central === null ? 'Central angle' : 'Inscribed angle', { unit: '°', sub: 'An inscribed angle is half the central angle on the same arc', rows: { arc: `Arc measure ${f(ce, 12)}°`, other: `An inscribed angle on the other arc: ${f((360 - ce) / 2, 12)}°`, semicircle: 'Any angle inscribed in a semicircle is 90° (Thales)', cyclic: 'Opposite angles of a cyclic quadrilateral add to 180°' }, steps: ['Inscribed angle theorem: inscribed = central ÷ 2', `${f(ce, 12)}° ÷ 2 = ${f(ins, 12)}°`] });
        }

        const rows = { arc: '', other: '', semicircle: '', cyclic: '' };
        const solveFour = (names, vals, eq, solver, label) => {
            const blanks = vals.map((x, k) => (x === null ? k : -1)).filter((k) => k >= 0);

            if (blanks.length !== 1 || vals.some((x) => x !== null && !(x > 0))) {
                return need(`Enter three of ${names.join(', ')} and leave the unknown blank.`);
            }

            const x = solver(blanks[0], vals);

            if (!(x > 0)) {
                return fail('No positive length satisfies the theorem with these values.');
            }

            const filled = vals.map((v, k) => (k === blanks[0] ? x : v));

            return result(f(x, 12), names[blanks[0]], { sub: eq, rows: { arc: names.map((n, k) => `${n} = ${f(filled[k], 10)}`).join(', '), other: label(filled), semicircle: eq, cyclic: 'Power of a point: the product is the same for every line through the point' }, steps: [eq, `${names[blanks[0]]} = ${f(x, 12)}`] });
        };

        if (th === 'chords') {
            return solveFour(['a', 'b', 'c', 'd'], [val(i.ca), val(i.cb), val(i.cc), val(i.cd)], 'Intersecting chords: a × b = c × d', (k, v) => {
                const [a, b, c, d] = v;

                return [(c * d) / b, (c * d) / a, (a * b) / d, (a * b) / c][k];
            }, (v) => `Both products = ${f(v[0] * v[1], 10)}`);
        }

        if (th === 'secants') {
            return solveFour(['a (outside part 1)', 'b (inside part 1)', 'c (outside part 2)', 'd (inside part 2)'], [val(i.ca), val(i.cb), val(i.cc), val(i.cd)], 'Two secants: a(a + b) = c(c + d)', (k, v) => {
                const [a, b, c, d] = v;

                if (k === 1) {
                    return (c * (c + d)) / a - a;
                }

                if (k === 3) {
                    return (a * (a + b)) / c - c;
                }

                // Outside part: x² + (inside)x − product = 0.
                const [inside, product] = k === 0 ? [b, c * (c + d)] : [d, a * (a + b)];

                return (-inside + sqrt(inside * inside + 4 * product)) / 2;
            }, (v) => `Both products = ${f(v[0] * (v[0] + v[1]), 10)}`);
        }

        // Tangent and secant from the same point: t² = a(a + b).
        return solveFour(['t (tangent)', 'a (outside part)', 'b (inside part)'], [val(i.ca), val(i.cb), val(i.cc)], 'Tangent–secant: t² = a(a + b)', (k, v) => {
            const [t, a, b] = v;

            return [sqrt(a * (a + b)), (-b + sqrt(b * b + 4 * t * t)) / 2, (t * t) / a - a][k];
        }, (v) => `t² = ${f(v[0] ** 2, 10)}`);
    },

    tangent: (i, c) => {
        const u = i.unit ?? 'cm';
        const mode = c.given ?? i.given ?? 'distance';
        let r;
        let d;
        let h = 0;
        let k = 0;
        let px;
        let py;

        if (mode === 'point') {
            [h, k, r, px, py] = [i.h, i.k, i.r, i.px, i.py].map(Number);

            if (![h, k, px, py].every(Number.isFinite) || !(r > 0)) {
                return need('Enter the centre, the radius and the outside point.');
            }

            d = hypot(px - h, py - k);
        } else {
            [r, d] = [i.r, i.d].map(Number);

            if (!(r > 0 && d > 0)) {
                return need('Enter the radius and the distance from the centre to the point.');
            }

            [px, py] = [d, 0];
        }

        if (d <= r) {
            return fail(d === r ? 'The point is on the circle: the tangent there is perpendicular to the radius.' : 'The point is inside the circle, so no tangent passes through it.');
        }

        const len = sqrt(d * d - r * r);
        const half = asin(r / d);
        const base = atan2(k - py, h - px);
        const touch = [1, -1].map((s) => {
            const ang = base + s * half;

            return [px + len * cos(ang), py + len * sin(ang)];
        });
        const line = ([x1, y1]) => {
            const dx = x1 - px;
            const dy = y1 - py;

            if (abs(dx) < 1e-12) {
                return `x = ${f(px, 10)}`;
            }

            const m = dy / dx;

            return `y = ${f(m, 10)}x ${py - m * px < 0 ? '−' : '+'} ${f(abs(py - m * px), 10)}`;
        };
        const want = c.want ?? 'length';
        const rows = { length: measure(len, 1, u), angle: `${f((2 * half) / D, 12)}°`, central: `${f(180 - (2 * half) / D, 12)}°`, points: touch.map((p) => `(${f(p[0], 10)}, ${f(p[1], 10)})`).join(' and '), lines: mode === 'point' ? touch.map(line).join(' and ') : 'Enter coordinates to get the line equations', distance: measure(d, 1, u) };
        const steps = [`Distance from the centre d = ${f(d, 12)}`, 'The tangent is perpendicular to the radius at the touching point', `Tangent length = √(d² − r²) = ${measure(len, 1, u)}`, `Angle between the two tangents = 2 asin(r ÷ d) = ${f((2 * half) / D, 12)}°`];
        const plot = { diagram: { kind: 'diagram', shapes: [{ points: arc(h, k, r), closed: true }, { points: [touch[0], [px, py], touch[1]] }, { points: [[h, k], touch[0]], muted: true, dashed: true }, { points: [[h, k], touch[1]], muted: true, dashed: true }], dots: [[h, k], [px, py], ...touch], labels: [{ x: px, y: py + r * 0.18, text: 'P' }] } };

        return want === 'angle' ? result(f((2 * half) / D, 12), 'Angle between the tangents', { unit: '°', sub: `Each tangent is ${measure(len, 1, u)} long`, rows, steps, plots: plot }) : result(measure(len, 1, u).split(' ')[0], 'Tangent length', { unit: measure(len, 1, u).split(' ').slice(1).join(' '), sub: `Angle between the tangents ${f((2 * half) / D, 10)}°`, rows, steps, plots: plot });
    },

    coin_rotation: (i) => {
        const [R0, r] = [i.outer, i.r].map(Number);
        const inside = i.side === 'inside';

        if (!(R0 > 0 && r > 0)) {
            return need('Enter the radius of the fixed coin and of the rolling coin.');
        }

        if (inside && r >= R0) {
            return fail('To roll inside, the moving coin must be smaller than the fixed circle.');
        }

        const turns = inside ? R0 / r - 1 : R0 / r + 1;
        const path = 2 * PI * (inside ? R0 - r : R0 + r);
        const centreR = inside ? R0 - r : R0 + r;
        const curve = Array.from({ length: 361 }, (_, n) => {
            const t = (2 * PI * n) / 360;
            const k = centreR / r;

            return inside ? [centreR * cos(t) + r * cos(k * t), centreR * sin(t) - r * sin(k * t)] : [centreR * cos(t) - r * cos(k * t), centreR * sin(t) - r * sin(k * t)];
        });

        return result(f(turns, 12), 'Rotations of the rolling coin', { sub: inside ? `Not ${f(R0 / r, 10)}: going around on the inside takes one turn away` : `Not ${f(R0 / r, 10)}: going around the outside adds one extra turn`, rows: { naive: f(R0 / r, 12), path: f(path, 12), extra: inside ? 'Rolling inside subtracts the one turn from going around' : 'Rolling outside adds one turn from going around', curve: inside ? 'A point on the rim traces a hypocycloid' : 'A point on the rim traces an epicycloid (a cardioid for equal coins)' }, steps: ['The centre of the rolling coin travels around a circle of radius ' + (inside ? 'R − r' : 'R + r'), `Path length = 2π(${inside ? 'R − r' : 'R + r'}) = ${f(path, 12)}`, `Rotations = path ÷ circumference of the coin = ${f(path, 12)} ÷ ${f(2 * PI * r, 12)} = ${f(turns, 12)}`], plots: { diagram: { kind: 'diagram', shapes: [{ points: arc(0, 0, R0), closed: true }, { points: arc(centreR, 0, r), muted: true }, { points: curve, muted: true, dashed: true }], dots: [[0, 0]] } } });
    },

    girdle: (i) => {
        const u = i.unit ?? 'm';
        const [R0, extra] = [i.r, i.extra].map(Number);

        if (!(R0 > 0 && extra > 0)) {
            return need('Enter the radius of the sphere and the extra length of string.');
        }

        const gap = extra / (2 * PI);
        // Pulled up at one point: 2R(tan θ − θ) = extra, height = R(sec θ − 1).
        let lo = 0;
        let hi = PI / 2 - 1e-12;

        for (let n = 0; n < 200; n += 1) {
            const m = (lo + hi) / 2;

            if (2 * R0 * (tan(m) - m) < extra) {
                lo = m;
            } else {
                hi = m;
            }
        }

        const theta = (lo + hi) / 2;
        const peak = R0 * (1 / cos(theta) - 1);

        return result(measure(gap, 1, u).split(' ')[0], 'Even gap all the way round', { unit: measure(gap, 1, u).split(' ').slice(1).join(' '), sub: 'The same for a football or the Earth: extra ÷ 2π', rows: { gap: measure(gap, 1, u), peak: measure(peak, 1, u), circ: measure(2 * PI * R0, 1, u), reverse: `To raise a string by 1 ${u === 'units' ? 'unit' : u} all round you need ${f(2 * PI, 10)} extra` }, steps: ['New circumference 2π(R + h) = 2πR + extra', `h = extra ÷ 2π = ${f(extra)} ÷ ${f(2 * PI, 10)} = ${measure(gap, 1, u)}`, `Pulled tight at one point instead: solve 2R(tan θ − θ) = extra → θ = ${f(theta / D, 10)}°`, `Peak height R(sec θ − 1) = ${measure(peak, 1, u)}`] });
    },

    angle_vectors: (i) => {
        const read = (s) => String(s ?? '').replace(/[()<>⟨⟩[\]]/g, ' ').split(/[,\s]+/).filter(Boolean).map((x) => Number(x.replace('−', '-')));
        const u = read(i.u);
        const v = read(i.v);

        if (u.length < 2 || u.length > 3 || u.length !== v.length || [...u, ...v].some((x) => !Number.isFinite(x))) {
            return need('Enter two vectors with the same number of components (2 or 3), such as 3, 4.');
        }

        const dot = u.reduce((s, x, k) => s + x * v[k], 0);
        const nu = hypot(...u);
        const nv = hypot(...v);

        if (!nu || !nv) {
            return fail('A zero vector has no direction, so the angle is undefined.');
        }

        const cosT = Math.min(1, Math.max(-1, dot / (nu * nv)));
        const theta = acos(cosT);
        const cross = u.length === 3 ? [u[1] * v[2] - u[2] * v[1], u[2] * v[0] - u[0] * v[2], u[0] * v[1] - u[1] * v[0]] : [u[0] * v[1] - u[1] * v[0]];
        const plot = u.length === 2 ? { diagram: { kind: 'diagram', shapes: [{ points: [[0, 0], u] }, { points: [[0, 0], v] }, { points: arc(0, 0, Math.min(nu, nv) * 0.25, atan2(u[1], u[0]), atan2(u[1], u[0]) + (cross[0] >= 0 ? theta : -theta), 24), muted: true }], dots: [u, v], labels: [{ x: u[0] * 1.08, y: u[1] * 1.08, text: 'u' }, { x: v[0] * 1.08, y: v[1] * 1.08, text: 'v' }] } } : undefined;

        return result(f(theta / D, 12), 'Angle between the vectors', { unit: '°', sub: `${f(theta, 12)} rad`, rows: { dot: f(dot, 12), norms: `|u| = ${f(nu, 12)}, |v| = ${f(nv, 12)}`, cos: f(cosT, 12), cross: u.length === 3 ? `(${cross.map((x) => f(x, 10)).join(', ')})` : `${f(cross[0], 12)} (z component)`, relation: abs(dot) < 1e-12 * nu * nv ? 'Perpendicular (dot product 0)' : abs(abs(cosT) - 1) < 1e-12 ? (cosT > 0 ? 'Parallel, same direction' : 'Parallel, opposite directions') : theta < PI / 2 ? 'Acute angle' : 'Obtuse angle' }, steps: [`u · v = ${u.map((x, k) => `${f(x)} × ${f(v[k])}`).join(' + ')} = ${f(dot, 12)}`, `|u| = ${f(nu, 12)}, |v| = ${f(nv, 12)}`, `cos θ = u · v ÷ (|u||v|) = ${f(cosT, 12)}`, `θ = acos(${f(cosT, 10)}) = ${f(theta / D, 12)}°`], plots: plot });
    },

    clock: (i) => {
        const text = String(i.time ?? '').trim();
        const m = text.match(/^(\d{1,2})(?::(\d{1,2})(?::(\d{1,2}))?)?\s*(am|pm)?$/i);

        if (!m) {
            return need('Type a time such as 3:40 or 10:15:30.');
        }

        const hh = Number(m[1]) % 12;
        const mm = Number(m[2] ?? 0);
        const ss = Number(m[3] ?? 0);

        if (mm > 59 || ss > 59) {
            return fail('Minutes and seconds go up to 59.');
        }

        const minuteHand = 6 * mm + 0.1 * ss;
        const hourHand = 30 * hh + 0.5 * mm + ss / 120;
        let diff = abs(hourHand - minuteHand) % 360;
        const small = Math.min(diff, 360 - diff);
        // Next time the hands overlap: they meet every 12/11 hours.
        const minutesNow = hh * 60 + mm + ss / 60;
        const k = Math.ceil((minutesNow + 1e-9) / (720 / 11));
        const next = ((k * 720) / 11) % 720;
        const nh = Math.floor(next / 60);
        const nm = next - 60 * nh;
        const hand = (deg, len) => [len * sin(deg * D), len * cos(deg * D)];
        const ticks = Array.from({ length: 12 }, (_, n) => ({ points: [hand(n * 30, 0.9), hand(n * 30, 1)], muted: true }));

        return result(f(small, 12), 'Angle between the hands', { unit: '°', sub: `The reflex angle is ${f(360 - small, 12)}°`, rows: { hour: `${f(hourHand, 12)}° from 12`, minute: `${f(minuteHand, 12)}° from 12`, reflex: `${f(360 - small, 12)}°`, overlap: `${nh === 0 ? 12 : nh}:${String(Math.floor(nm)).padStart(2, '0')}:${String(Math.round((nm % 1) * 60)).padStart(2, '0')} (they meet every 65 5/11 minutes)` }, steps: ['Hour hand: 30° per hour + 0.5° per minute', `= 30 × ${hh} + 0.5 × ${mm}${ss ? ` + ${ss}/120` : ''} = ${f(hourHand, 12)}°`, 'Minute hand: 6° per minute', `= 6 × ${mm}${ss ? ` + 0.1 × ${ss}` : ''} = ${f(minuteHand, 12)}°`, `Difference ${f(abs(hourHand - minuteHand), 12)}°, smaller angle ${f(small, 12)}°`], plots: { diagram: { kind: 'diagram', shapes: [{ points: arc(0, 0, 1), closed: true }, ...ticks, { points: [[0, 0], hand(hourHand, 0.5)] }, { points: [[0, 0], hand(minuteHand, 0.8)] }], dots: [[0, 0]] } } });
    },

    comp_supp: (i, c) => {
        const kind = c.kind ?? 'complement';
        const unit = i.angle_unit ?? 'deg';
        const x = Number(i.angle);

        if (!Number.isFinite(x)) {
            return need('Enter an angle.');
        }

        const deg = unit === 'rad' ? x / D : unit === 'pi' ? x * 180 : x;
        const total = kind === 'complement' ? 90 : kind === 'supplement' ? 180 : 360;
        const other = total - deg;
        const name = { complement: 'Complement', supplement: 'Supplement', explement: 'Explement' }[kind];

        if (deg <= 0 || deg >= total) {
            return fail(`Only angles between 0° and ${total}° have a ${name.toLowerCase()} (the angles must add to ${total}°).`);
        }

        const piText = (d) => {
            const q = R.div(R.fromNumber(Number(d.toPrecision(12))), R.Q(180));

            if (q.d > 3600n) {
                return `${f(d / 180, 10)}π`;
            }

            const top = R.babs(q.n) === 1n ? (q.n < 0n ? '−' : '') : R.fmt(q.n);

            return `${top}π${q.d === 1n ? '' : `/${q.d}`}`;
        };

        return result(f(other, 12), name, { unit: '°', sub: `${f(deg, 12)}° + ${f(other, 12)}° = ${total}°`, rows: { radians: `${f(other * D, 12)} rad = ${piText(other)} rad`, given: `${f(deg, 12)}° (${f(deg * D, 12)} rad)`, complement: deg < 90 ? `${f(90 - deg, 12)}°` : 'None (angle is 90° or more)', supplement: deg < 180 ? `${f(180 - deg, 12)}°` : 'None (angle is 180° or more)' }, steps: [`${name}s add up to ${total}°`, `${total}° − ${f(deg, 12)}° = ${f(other, 12)}°`, `In radians: ${piText(total)} − ${f(deg * D, 10)} = ${f(other * D, 12)}`] });
    },

    coterminal: (i, c) => {
        const unit = i.angle_unit ?? 'deg';
        const x = Number(i.angle);

        if (!Number.isFinite(x)) {
            return need('Enter an angle.');
        }

        const deg = unit === 'rad' ? x / D : unit === 'pi' ? x * 180 : x;
        const norm = ((deg % 360) + 360) % 360;
        const clean = abs(norm - 360) < 1e-9 ? 0 : norm;
        const quadrant = clean === 0 || clean === 90 || clean === 180 || clean === 270 ? `On an axis (${clean}°)` : `Quadrant ${['I', 'II', 'III', 'IV'][Math.floor(clean / 90)]}`;
        const ref = clean <= 90 ? clean : clean <= 180 ? 180 - clean : clean <= 270 ? clean - 180 : 360 - clean;
        const piMul = (k) => (k === '1' ? 'π' : k === '−1' ? '−π' : k === '0' ? '0' : `${k}π`);
        const show = (d) => (unit === 'deg' ? `${f(d, 12)}°` : unit === 'pi' ? piMul(f(d / 180, 12)) : `${f(d * D, 12)} rad`);
        const list = [-2, -1, 1, 2].map((k) => show(clean + 360 * k));
        const want = c.want ?? 'coterminal';
        const dir = [cos(clean * D), sin(clean * D)];
        const plots = { diagram: { kind: 'diagram', shapes: [{ points: arc(0, 0, 1), muted: true }, { points: [[-1.2, 0], [1.2, 0]], muted: true }, { points: [[0, -1.2], [0, 1.2]], muted: true }, { points: [[0, 0], dir] }, { points: arc(0, 0, 0.25, 0, clean * D, 36), muted: true }], dots: [dir] } };

        if (want === 'reference') {
            return result(f(ref, 12), 'Reference angle', { unit: '°', sub: `${quadrant}; ${f(ref * D, 12)} rad`, rows: { coterminal: `${f(clean, 12)}° in [0°, 360°)`, quadrant, list: list.join(', '), signs: `sin ${sin(clean * D) >= 0 ? '+' : '−'}, cos ${cos(clean * D) >= 0 ? '+' : '−'}, tan ${tan(clean * D) >= 0 ? '+' : '−'} in this position` }, steps: [`Coterminal angle in [0°, 360°): ${f(clean, 12)}°`, clean <= 90 ? 'Quadrant I: reference = θ' : clean <= 180 ? 'Quadrant II: reference = 180° − θ' : clean <= 270 ? 'Quadrant III: reference = θ − 180°' : 'Quadrant IV: reference = 360° − θ', `Reference angle = ${f(ref, 12)}°`], plots });
        }

        return result(unit === 'deg' ? f(clean, 12) : unit === 'pi' ? piMul(f(clean / 180, 12)) : f(clean * D, 12), 'Coterminal angle in one turn', { unit: unit === 'deg' ? '°' : 'rad', sub: `Others: ${list.join(', ')}`, rows: { coterminal: `${f(clean, 12)}° = ${f(clean * D, 12)} rad`, quadrant, list: list.join(', '), signs: `Reference angle ${f(ref, 12)}°` }, steps: ['Coterminal angles differ by whole turns: θ + 360°k', `${f(deg, 12)}° mod 360° = ${f(clean, 12)}°`, `Examples: ${list.join(', ')}`], plots });
    },
};

export default defineTools(handlers);
