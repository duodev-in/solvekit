import { defineTools } from '../engines/formula.js';
import { evalReal, parse, ParseError, toPoly, variables } from '../math/expr.js';
import { practice } from '../math/practice.js';
import { arc, ellipsePerimeter, ellipsePts, polyArea, polygonPts, SHAPES } from '../math/shapes.js';
import { integrate } from '../math/special.js';
import { f, fail, need, R, result } from '../math/util.js';

/**
 * 2D and 3D shape tools: the generic "solve from any known values" handler for every shape in math/shapes.js,
 * the area, perimeter, volume and surface hubs, and the custom 2D tools (trapezoid, quadrilaterals, crescent,
 * centroids, sections, conics, spirals, cycloid, Möbius strip, segment addition).
 * Lengths are plain numbers in the unit chosen in the "unit" select; areas and volumes are shown in that unit squared or cubed.
 */
const { PI, sqrt, sin, cos, tan, asin, acos, atan2, abs, hypot } = Math;
const D = PI / 180;
export const UNITS = { mm: 0.001, cm: 0.01, m: 1, km: 1000, in: 0.0254, ft: 0.3048, yd: 0.9144, mi: 1609.344 };

/** Text of a value of the given dimension in unit u ("units" means no unit). */
export function measure(value, dim, u, sig = 10) {
    const plain = !UNITS[u];

    if (dim === 'deg') {
        return `${f(value, sig)}°`;
    }

    if (dim === 'n') {
        return f(value, sig);
    }

    if (dim === 'inv') {
        return `${f(value, sig)} per ${plain ? 'unit' : u}`;
    }

    if (plain) {
        return dim === 1 ? f(value, sig) : `${f(value, sig)} ${dim === 2 ? 'square' : 'cubic'} units`;
    }

    return `${f(value, sig)} ${u}${dim === 2 ? '²' : dim === 3 ? '³' : ''}`;
}

/** Outcome whose headline is a measurement (value and unit shown separately). */
function measured(value, dim, u, label, options = {}) {
    const [text, unit] = split(value, dim, u);

    return result(text, label, { ...options, unit });
}

/** The value and its unit separately (for the big result). */
function split(value, dim, u) {
    const text = measure(value, dim, u);
    const m = text.match(/^(−?[\d,.]+(?: × 10[⁻⁰¹²³⁴⁵⁶⁷⁸⁹]+)?)\s*(.*)$/);

    return m ? [m[1], m[2]] : [text, ''];
}

export function areaConversions(value, u) {
    if (!UNITS[u]) {
        return 'Choose a unit to convert';
    }

    const m2 = value * UNITS[u] ** 2;
    const parts = [`${f(m2, 8)} m²`, `${f(m2 / 0.09290304, 8)} ft²`, `${f(m2 * 1e4, 8)} cm²`, `${f(m2 / 0.00064516, 8)} in²`];

    if (m2 >= 1000) {
        parts.push(`${f(m2 / 4046.8564224, 8)} acres`, `${f(m2 / 1e4, 8)} ha`);
    }

    return parts.join(' = ');
}

export function volumeConversions(value, u) {
    if (!UNITS[u]) {
        return 'Choose a unit to convert';
    }

    const m3 = value * UNITS[u] ** 3;

    return [`${f(m3 * 1000, 8)} L`, `${f((m3 * 1000) / 3.785411784, 8)} US gal`, `${f(m3 / 0.028316846592, 8)} ft³`, `${f(m3 / 0.764554857984, 8)} yd³`, `${f(m3 * 1e6, 8)} cm³ (mL)`, `${f(m3 / 1.6387064e-5, 8)} in³`].join(' = ');
}

/** Generic shape solve: c.shape names the shape, i.given the case, c.want the headline quantity. */
function solveShape(i, c) {
    if (c.practice && i.mode === 'practice') {
        return practice(c.practice, i);
    }

    const shape = SHAPES[c.shape];
    const given = c.given ?? i.given ?? Object.keys(shape.cases)[0];
    const solver = shape.cases[given];
    const u = i.unit ?? 'cm';

    if (!solver) {
        return need('Choose what you know.');
    }

    const v = {};

    for (const name of shape.fixed ?? []) {
        v[name] = c[name] ?? i[name];

        if (name === 'n') {
            v.n = Number(v.n);
        }
    }

    const names = given.split('_');

    for (const name of names) {
        v[name] = Number(i[name]);
    }

    const missing = names.filter((name) => !(v[name] > 0));

    if (missing.length) {
        return need(`Enter ${missing.map((name) => shape.vars[name][0].replace(/^./, (ch) => ch.toLowerCase())).join(' and ')} (positive numbers).`);
    }

    const problem = shape.check?.(v);

    if (problem) {
        return fail(problem);
    }

    const params = solver(v);

    if (params.error) {
        return fail(params.error);
    }

    const all = shape.all(params, v);

    if (all.error) {
        return fail(all.error);
    }

    const bad = Object.keys(shape.vars).filter((k) => !Number.isFinite(all[k]) || all[k] < -1e-12 * Math.max(1, ...Object.values(all).filter(Number.isFinite).map(abs)));

    if (bad.length) {
        return fail('These values cannot belong to this shape. Check them and the unit.');
    }

    const want = c.want ?? Object.keys(shape.vars).find((k) => !names.includes(k));
    const VOLUME_UNITS = { L: [1e-3, 'L'], gal: [3.785411784e-3, 'US gal'], yd3: [0.764554857984, 'yd³'], ft3: [0.028316846592, 'ft³'] };
    const [value, unit] = c.volumeIn && shape.vars[want][1] === 3 && UNITS[u] ? [f((all[want] * UNITS[u] ** 3) / VOLUME_UNITS[c.volumeIn][0], 10), VOLUME_UNITS[c.volumeIn][1]] : split(all[want], shape.vars[want][1], u);
    const rows = Object.fromEntries(Object.entries(shape.vars).map(([k, [, dim]]) => [k, measure(all[k], dim, u)]));
    const dims = Object.values(shape.vars).map((x) => x[1]);
    const areaKey = ['area', 'surf'].find((k) => k in shape.vars) ?? Object.keys(shape.vars).find((k) => shape.vars[k][1] === 2);
    const volKey = dims.includes(3) ? 'vol' : null;

    if (areaKey) {
        rows.areas = areaConversions(all[areaKey], u);
    }

    if (volKey && all.vol !== undefined) {
        rows.volumes = volumeConversions(all.vol, u);
    }

    const t = (k, scale = 1) => measure(all[k] * scale, shape.vars[k][1], u, 5);
    const steps = [`Given: ${names.map((k) => `${shape.vars[k][0]} = ${measure(v[k], shape.vars[k][1], u)}`).join(', ')}${(shape.fixed ?? []).filter((k) => k === 'n').map(() => `, n = ${v.n}`).join('')}`];
    Object.keys(shape.vars).filter((k) => !names.includes(k)).forEach((k) => steps.push(`${shape.vars[k][0]}: ${shape.formulas?.[k] ?? ''} = ${measure(all[k], shape.vars[k][1], u)}`));
    const sub = c.sub ? c.sub.replace(/\{(\w+)\}/g, (m, k) => (k in all ? measure(all[k], shape.vars[k][1], u) : m)) : Object.keys(shape.vars).filter((k) => k !== want && !names.includes(k)).slice(0, 2).map((k) => `${shape.vars[k][0]} ${measure(all[k], shape.vars[k][1], u)}`).join(' · ');

    return result(value, shape.vars[want][0], { unit, sub: sub || shape.formulas?.[want] || '', rows, steps, plots: shape.draw ? { diagram: { kind: 'diagram', ...shape.draw(params, t, v) } } : undefined });
}

/** Figures for the area, perimeter, volume and surface hubs: fields and formulas. */
export const FIGS = {
    square: { fields: ['a'], area: (v) => [v.a ** 2, 'A = a²'], perim: (v) => [4 * v.a, 'P = 4a'] },
    rectangle: { fields: ['l', 'w'], area: (v) => [v.l * v.w, 'A = lw'], perim: (v) => [2 * (v.l + v.w), 'P = 2(l + w)'] },
    triangle: { fields: ['b', 'h'], area: (v) => [(v.b * v.h) / 2, 'A = bh ÷ 2'] },
    triangle3: { fields: ['a', 'b', 'c'], area: (v) => heron(v.a, v.b, v.c), perim: (v) => [v.a + v.b + v.c, 'P = a + b + c'] },
    parallelogram: { fields: ['b', 'h', 'a'], area: (v) => [v.b * v.h, 'A = bh'], perim: (v) => [2 * (v.a + v.b), 'P = 2(a + b)'] },
    trapezoid: { fields: ['a', 'b', 'h'], area: (v) => [((v.a + v.b) / 2) * v.h, 'A = (a + b)h ÷ 2'] },
    trapezoid4: { fields: ['a', 'b', 'c', 'd'], perim: (v) => [v.a + v.b + v.c + v.d, 'P = a + b + c + d'] },
    rhombus: { fields: ['d1', 'd2'], area: (v) => [(v.d1 * v.d2) / 2, 'A = d₁d₂ ÷ 2'], perim: (v) => [4 * hypot(v.d1 / 2, v.d2 / 2), 'P = 4√((d₁/2)² + (d₂/2)²)'] },
    kite: { fields: ['d1', 'd2'], area: (v) => [(v.d1 * v.d2) / 2, 'A = d₁d₂ ÷ 2'] },
    circle: { fields: ['r'], area: (v) => [PI * v.r ** 2, 'A = πr²'], perim: (v) => [2 * PI * v.r, 'C = 2πr'], vol: null },
    ellipse: { fields: ['a', 'b'], area: (v) => [PI * v.a * v.b, 'A = πab'], perim: (v) => [ellipsePerimeter(v.a, v.b), 'P = 4a E(e) (exact)'] },
    sector: { fields: ['r', 'theta'], area: (v) => [(PI * v.r ** 2 * v.theta) / 360, 'A = πr²θ ÷ 360°'], perim: (v) => [2 * v.r + (PI * v.r * v.theta) / 180, 'P = 2r + πrθ ÷ 180°'] },
    polygon: { fields: ['n', 'a'], area: (v) => [polyArea(v.n, v.a), 'A = na² ÷ (4 tan(π/n))'], perim: (v) => [v.n * v.a, 'P = na'] },
    annulus: { fields: ['outer', 'r'], area: (v) => [PI * (v.outer ** 2 - v.r ** 2), 'A = π(R² − r²)'] },
    cube: { fields: ['a'], vol: (v) => [v.a ** 3, 'V = a³'], surf: (v) => [6 * v.a ** 2, 'A = 6a²'] },
    cuboid: { fields: ['l', 'w', 'h'], vol: (v) => [v.l * v.w * v.h, 'V = lwh'], surf: (v) => [2 * (v.l * v.w + v.l * v.h + v.w * v.h), 'A = 2(lw + lh + wh)'] },
    sphere: { fields: ['r'], vol: (v) => [(4 / 3) * PI * v.r ** 3, 'V = (4/3)πr³'], surf: (v) => [4 * PI * v.r ** 2, 'A = 4πr²'] },
    hemisphere: { fields: ['r'], vol: (v) => [(2 / 3) * PI * v.r ** 3, 'V = (2/3)πr³'], surf: (v) => [3 * PI * v.r ** 2, 'A = 3πr²'] },
    cylinder: { fields: ['r', 'h'], vol: (v) => [PI * v.r ** 2 * v.h, 'V = πr²h'], surf: (v) => [2 * PI * v.r * (v.r + v.h), 'A = 2πr(r + h)'] },
    cone: { fields: ['r', 'h'], vol: (v) => [(PI * v.r ** 2 * v.h) / 3, 'V = πr²h ÷ 3'], surf: (v) => [PI * v.r * (v.r + hypot(v.r, v.h)), 'A = πr(r + √(r² + h²))'] },
    pyramid: { fields: ['l', 'w', 'h'], vol: (v) => [(v.l * v.w * v.h) / 3, 'V = lwh ÷ 3'], surf: (v) => [v.l * v.w + v.l * hypot(v.h, v.w / 2) + v.w * hypot(v.h, v.l / 2), 'A = lw + l√(h² + (w/2)²) + w√(h² + (l/2)²)'] },
    triprism: { fields: ['b', 'h', 'len'], vol: (v) => [((v.b * v.h) / 2) * v.len, 'V = (bh ÷ 2) × L'] },
    ellipsoid: { fields: ['a', 'b', 'c'], vol: (v) => [(4 / 3) * PI * v.a * v.b * v.c, 'V = (4/3)πabc'] },
    torus: { fields: ['outer', 'r'], vol: (v) => [2 * PI ** 2 * v.outer * v.r ** 2, 'V = 2π²Rr²'], surf: (v) => [4 * PI ** 2 * v.outer * v.r, 'A = 4π²Rr'] },
    capsule: { fields: ['r', 'len'], vol: (v) => [PI * v.r ** 2 * ((4 / 3) * v.r + v.len), 'V = πr²(4r/3 + a)'], surf: (v) => [2 * PI * v.r * (2 * v.r + v.len), 'A = 2πr(2r + a)'] },
};

function heron(a, b, c) {
    const s = (a + b + c) / 2;
    const q = s * (s - a) * (s - b) * (s - c);

    return [q > 0 ? sqrt(q) : NaN, 'Heron: A = √(s(s − a)(s − b)(s − c))'];
}

const FIELD = { a: 'a', b: 'b', c: 'c', d: 'd', h: 'h', l: 'l', w: 'w', r: 'r', outer: 'R', d1: 'd₁', d2: 'd₂', n: 'n', theta: 'θ', len: 'L' };

function hub(i, c) {
    const fig = FIGS[i.fig];
    const want = c.measure;
    const u = i.unit ?? 'cm';

    if (!fig) {
        return need('Choose a shape.');
    }

    const v = Object.fromEntries(fig.fields.map((k) => [k, Number(i[k])]));
    const missing = fig.fields.filter((k) => !(v[k] > 0));

    if (missing.length) {
        return need(`Enter ${missing.map((k) => FIELD[k]).join(', ')}.`);
    }

    const pick = (m) => (fig[m] ? fig[m](v) : null);
    const main = want === 'ratio' ? null : pick(want);

    if (want !== 'ratio' && !main) {
        return need('This shape has no formula for this measure here; choose another shape.');
    }

    if (main && !Number.isFinite(main[0])) {
        return fail('These values do not form the shape (for three sides, each must be shorter than the other two together).');
    }

    const given = fig.fields.map((k) => `${FIELD[k]} = ${k === 'n' ? v[k] : k === 'theta' ? `${f(v[k])}°` : measure(v[k], 1, u)}`).join(', ');
    const dim = { area: 2, perim: 1, vol: 3, surf: 2 }[want];

    if (want === 'ratio') {
        const vol = pick('vol');
        const surf = pick('surf');

        if (!vol || !surf) {
            return need('Choose a solid that has both a volume and a surface area formula.');
        }

        const ratio = surf[0] / vol[0];

        return result(f(ratio, 10), 'Surface area to volume ratio', { unit: UNITS[u] ? `per ${u}` : 'per unit', sub: `${measure(surf[0], 2, u)} ÷ ${measure(vol[0], 3, u)}`, rows: { surf: measure(surf[0], 2, u), vol: measure(vol[0], 3, u), formula: `${surf[1]}; ${vol[1]}`, scale: 'Doubling every length halves the ratio' }, steps: [`Given: ${given}`, `${surf[1]} = ${measure(surf[0], 2, u)}`, `${vol[1]} = ${measure(vol[0], 3, u)}`, `Ratio = A ÷ V = ${f(ratio, 10)}`] });
    }

    const [value, unit] = split(main[0], dim, u);
    const rows = { formula: main[1], given };

    if (dim === 2) {
        rows.areas = areaConversions(main[0], u);
    }

    if (dim === 3) {
        rows.volumes = volumeConversions(main[0], u);
    }

    return result(value, { area: 'Area', perim: 'Perimeter', vol: 'Volume', surf: 'Surface area' }[want], { unit, sub: main[1], rows, steps: [`Given: ${given}`, `${main[1]} = ${measure(main[0], dim, u)}`] });
}

/** Trapezoid with bases a (bottom) and b (top). kind: isosceles, right or general. */
function trapezoid(i, c) {
    const u = i.unit ?? 'cm';
    const kind = c.kind ?? i.kind ?? 'isosceles';
    const given = c.given ?? i.given ?? 'a_b_h';
    const v = Object.fromEntries(['a', 'b', 'h', 'c', 'd', 'alpha', 'area', 'm'].map((k) => [k, Number(i[k])]));
    const need2 = (...ks) => ks.filter((k) => !(v[k] > 0));
    const fields = { a_b_h: ['a', 'b', 'h'], a_b_c_d: ['a', 'b', 'c', 'd'], a_b_alpha: ['a', 'b', 'alpha'], a_b_area: ['a', 'b', 'area'], m_h: ['m', 'h'] }[given];
    const label = { a: 'base a', b: 'base b', h: 'height', c: 'left leg', d: 'right leg', alpha: 'base angle', area: 'area', m: 'midsegment' };

    if (!fields) {
        return need('Choose what you know.');
    }

    if (need2(...fields).length) {
        return need(`Enter ${need2(...fields).map((k) => label[k]).join(', ')}.`);
    }

    if (given === 'm_h') {
        const area = v.m * v.h;

        return measured(area, 2, u, 'Area', { sub: 'A = midsegment × height', rows: { area: measure(area, 2, u), m: measure(v.m, 1, u), h: measure(v.h, 1, u), perim: 'Needs the bases and legs', legs: 'Needs the bases', angles: 'Needs the bases', diagonals: 'Needs the bases', areas: areaConversions(area, u) }, steps: [`A = m × h = ${f(v.m)} × ${f(v.h)} = ${measure(area, 2, u)}`] });
    }

    let { a, b } = v;

    if (b > a) {
        [a, b] = [b, a];
    }

    let h = v.h;
    let x;
    let y;

    if (given === 'a_b_area') {
        h = (2 * v.area) / (a + b);
    }

    if (given === 'a_b_c_d') {
        const e = a - b;

        if (e <= 0) {
            return fail('With equal bases the shape is a parallelogram and the height is not fixed by the sides; enter the height instead.');
        }

        const s = (e + v.c + v.d) / 2;
        const q = s * (s - e) * (s - v.c) * (s - v.d);

        if (!(q > 0)) {
            return fail('These sides do not form a trapezoid: the legs and the difference of the bases must form a triangle.');
        }

        h = (2 * sqrt(q)) / e;
        x = (v.c ** 2 - v.d ** 2 + e * e) / (2 * e);
        y = e - x;
    } else if (given === 'a_b_alpha') {
        if (v.alpha >= 90 && kind !== 'general') {
            return fail('The base angle at the longer base must be below 90°.');
        }

        h = kind === 'right' ? (a - b) * tan(v.alpha * D) : ((a - b) / 2) * tan(v.alpha * D);
    }

    if (x === undefined) {
        if (kind === 'right') {
            [x, y] = [0, a - b];
        } else if (kind === 'isosceles') {
            [x, y] = [(a - b) / 2, (a - b) / 2];
        }
    }

    const area = ((a + b) / 2) * h;
    const m = (a + b) / 2;
    const known = x !== undefined;
    const legL = known ? hypot(x, h) : NaN;
    const legR = known ? hypot(y, h) : NaN;
    const P = a + b + legL + legR;
    const pts = known ? [[0, 0], [a, 0], [a - y, h], [x, h], [0, 0]] : null;
    const angA = known ? atan2(h, x) / D : NaN;
    const angB = known ? atan2(h, y) / D : NaN;
    const want = c.want ?? 'area';
    const values = { area: [area, 2, 'Area'], perim: [P, 1, 'Perimeter'], m: [m, 1, 'Midsegment'], h: [h, 1, 'Height'], alpha: [angA, 'deg', 'Angle at the bottom left'], legs: [legL, 1, 'Left leg'] };
    const [wv, wd, wl] = values[want];

    if (!Number.isFinite(wv)) {
        return need('Choose isosceles or right, or enter all four sides, to find the legs and angles.');
    }

    const rows = {
        area: measure(area, 2, u), h: measure(h, 1, u), m: measure(m, 1, u),
        perim: known ? measure(P, 1, u) : 'Needs the legs (choose isosceles or right, or enter four sides)',
        legs: known ? `${measure(legL, 1, u)} and ${measure(legR, 1, u)}` : 'Unknown for a general trapezoid from a, b and h',
        angles: known ? `${f(angA, 8)}° and ${f(angB, 8)}° at the long base; ${f(180 - angA, 8)}° and ${f(180 - angB, 8)}° at the short base` : 'Needs the legs',
        diagonals: known ? `${measure(hypot(a - y, h), 1, u)} and ${measure(hypot(a - x, h), 1, u)}` : 'Needs the legs',
        areas: areaConversions(area, u),
    };
    const steps = [`Bases a = ${measure(a, 1, u)}, b = ${measure(b, 1, u)}`, `Height h = ${measure(h, 1, u)}${given === 'a_b_area' ? ' (from h = 2A ÷ (a + b))' : given === 'a_b_c_d' ? ' (from the triangle formed by the legs and a − b, Heron)' : ''}`, `Area = (a + b) ÷ 2 × h = ${measure(area, 2, u)}`, `Midsegment = (a + b) ÷ 2 = ${measure(m, 1, u)}`];

    if (known) {
        steps.push(`Legs = √(offset² + h²) = ${measure(legL, 1, u)} and ${measure(legR, 1, u)}`, `Perimeter = ${measure(P, 1, u)}`);
    }

    const t = (val) => measure(val, 1, u, 5);

    return measured(wv, wd, u, wl, { sub: want === 'area' ? `Midsegment ${measure(m, 1, u)} × height ${measure(h, 1, u)}` : `Area ${measure(area, 2, u)}`, rows, steps, plots: { diagram: { kind: 'diagram', shapes: pts ? [{ points: pts, closed: true }, { points: [[x, h], [x, 0]], muted: true, dashed: true }, { points: [[x / 2, h / 2], [a - y / 2, h / 2]], muted: true, dashed: true }] : [{ points: [[0, 0], [a, 0], [(a + b) / 2, h], [(a - b) / 2, h], [0, 0]], closed: true, dashed: true }], labels: [{ x: a / 2, y: -h * 0.12, text: `a = ${t(a)}` }, { x: (pts ? x : (a - b) / 2) + b / 2, y: h + h * 0.12, text: `b = ${t(b)}` }, { x: (pts ? x : (a - b) / 2) + a * 0.06, y: h * 0.25, text: `h = ${t(h)}` }] } } });
}

/** Quadrilaterals: general (Bretschneider or a diagonal), parallelogram, rhombus and kite. */
function quad(i, c) {
    const u = i.unit ?? 'cm';
    const given = c.given ?? i.given ?? 'gen_angles';
    const v = Object.fromEntries(['a', 'b', 'c', 'd', 'p', 'h', 'd1', 'd2', 'alpha', 'gamma'].map((k) => [k, Number(i[k])]));
    const FIELDS = { gen_angles: ['a', 'b', 'c', 'd', 'alpha', 'gamma'], gen_diag: ['a', 'b', 'c', 'd', 'p'], para_angle: ['a', 'b', 'alpha'], para_height: ['a', 'b', 'h'], rhombus_angle: ['a', 'alpha'], rhombus_diags: ['d1', 'd2'], kite_diags: ['d1', 'd2'], kite_angle: ['a', 'b', 'alpha'] };
    const names = { a: 'side a', b: 'side b', c: 'side c', d: 'side d', p: 'diagonal p', h: 'height', d1: 'diagonal d₁', d2: 'diagonal d₂', alpha: 'angle α', gamma: 'angle γ' };
    const fields = FIELDS[given];

    if (!fields) {
        return need('Choose the shape and what you know.');
    }

    const missing = fields.filter((k) => !(v[k] > 0));

    if (missing.length) {
        return need(`Enter ${missing.map((k) => names[k]).join(', ')}.`);
    }

    if (fields.some((k) => (k === 'alpha' || k === 'gamma') && v[k] >= 180)) {
        return fail('Angles must be below 180°.');
    }

    let area;
    let perim;
    let pts;
    const rows = {};
    const steps = [];
    const { a, b, alpha } = v;

    if (given === 'gen_angles') {
        const s = (a + b + v.c + v.d) / 2;
        const half = ((alpha + v.gamma) / 2) * D;
        const q = (s - a) * (s - b) * (s - v.c) * (s - v.d) - a * b * v.c * v.d * cos(half) ** 2;

        if (!(q > 0)) {
            return fail('No quadrilateral has these sides and angles.');
        }

        area = sqrt(q);
        perim = 2 * s;
        steps.push(`s = (a + b + c + d) ÷ 2 = ${f(s)}`, `Bretschneider: A = √((s − a)(s − b)(s − c)(s − d) − abcd cos²((α + γ)/2)) = ${measure(area, 2, u)}`);
        rows.extra = `Cyclic (α + γ = 180°) gives the largest area: ${measure(sqrt((s - a) * (s - b) * (s - v.c) * (s - v.d)), 2, u)} (Brahmagupta)`;
        // Vertices: a along the x axis, d at angle α from it.
        const P0 = [0, 0];
        const P1 = [a, 0];
        const P3 = [v.d * cos(alpha * D), v.d * sin(alpha * D)];
        pts = [P0, P1, thirdPoint(P1, P3, b, v.c), P3, P0];
    } else if (given === 'gen_diag') {
        const t1 = heronArea(a, b, v.p);
        const t2 = heronArea(v.c, v.d, v.p);

        if (!(t1 > 0 && t2 > 0)) {
            return fail('The diagonal does not fit: a, b, p and c, d, p must each form a triangle.');
        }

        area = t1 + t2;
        perim = a + b + v.c + v.d;
        steps.push(`The diagonal p splits the shape into triangles (a, b, p) and (c, d, p)`, `Heron: ${measure(t1, 2, u)} + ${measure(t2, 2, u)} = ${measure(area, 2, u)}`);
        const ang = acos((a * a + v.p * v.p - b * b) / (2 * a * v.p));
        const Pp = [v.p * cos(ang), v.p * sin(ang)];
        pts = [[0, 0], [a, 0], Pp, thirdPoint(Pp, [0, 0], v.c, v.d, -1), [0, 0]];
        rows.extra = `Triangles: ${measure(t1, 2, u)} and ${measure(t2, 2, u)}`;
    } else if (given === 'para_angle' || given === 'para_height') {
        const h = given === 'para_angle' ? b * sin(alpha * D) : v.h;

        if (given === 'para_height' && h > b) {
            return fail('The height cannot exceed the slanted side b.');
        }

        const ang = given === 'para_angle' ? alpha : asin(h / b) / D;
        area = a * h;
        perim = 2 * (a + b);
        const dx = b * cos(ang * D);
        pts = [[0, 0], [a, 0], [a + dx, h], [dx, h], [0, 0]];
        rows.extra = `Height ${measure(h, 1, u)}; angles ${f(ang, 8)}° and ${f(180 - ang, 8)}°; diagonals ${measure(hypot(a + dx, h), 1, u)} and ${measure(hypot(a - dx, h), 1, u)}`;
        steps.push(`h = ${given === 'para_angle' ? 'b sin α' : 'given'} = ${measure(h, 1, u)}`, `A = a × h = ${measure(area, 2, u)}`, `P = 2(a + b) = ${measure(perim, 1, u)}`);
    } else if (given === 'rhombus_angle' || given === 'rhombus_diags') {
        const side = given === 'rhombus_angle' ? a : hypot(v.d1 / 2, v.d2 / 2);
        const ang = given === 'rhombus_angle' ? alpha : (2 * atan2(v.d2 / 2, v.d1 / 2)) / D;
        area = side * side * sin(ang * D);
        perim = 4 * side;
        const p = 2 * side * cos((ang * D) / 2);
        const q = 2 * side * sin((ang * D) / 2);
        pts = [[0, 0], [p / 2, q / 2], [p, 0], [p / 2, -q / 2], [0, 0]];
        rows.extra = `Side ${measure(side, 1, u)}; angles ${f(ang, 8)}° and ${f(180 - ang, 8)}°; diagonals ${measure(p, 1, u)} and ${measure(q, 1, u)}; height ${measure(area / side, 1, u)}`;
        steps.push(given === 'rhombus_diags' ? `A = d₁d₂ ÷ 2 = ${measure(area, 2, u)}` : `A = a² sin α = ${measure(area, 2, u)}`, `Side = ${given === 'rhombus_diags' ? '√((d₁/2)² + (d₂/2)²)' : 'a'} = ${measure(side, 1, u)}`, `P = 4 × side = ${measure(perim, 1, u)}`);
    } else {
        let s1;
        let s2;
        let p;
        let q;

        if (given === 'kite_diags') {
            area = (v.d1 * v.d2) / 2;
            p = v.d1;
            q = v.d2;
            perim = NaN;
            pts = [[0, 0], [q / 2, p * 0.3], [0, p], [-q / 2, p * 0.3], [0, 0]];
            rows.extra = 'The side lengths depend on where the diagonals cross; the area does not';
            steps.push(`A = d₁d₂ ÷ 2 = ${measure(area, 2, u)}`);
        } else {
            area = a * b * sin(alpha * D);
            s1 = a;
            s2 = b;
            perim = 2 * (a + b);
            q = sqrt(a * a + b * b - 2 * a * b * cos(alpha * D));
            const x = (a * a - b * b + q * q) / (2 * q);
            const yA = sqrt(Math.max(a * a - x * x, 0));
            pts = [[0, 0], [x, yA], [q, 0], [x, -yA], [0, 0]];
            rows.extra = `Diagonal between the unequal-side corners ${measure(q, 1, u)}; sides ${measure(s1, 1, u)}, ${measure(s1, 1, u)}, ${measure(s2, 1, u)}, ${measure(s2, 1, u)}`;
            steps.push(`A = ab sin α (two congruent triangles) = ${measure(area, 2, u)}`, `P = 2(a + b) = ${measure(perim, 1, u)}`);
        }
    }

    rows.area = measure(area, 2, u);
    rows.perim = Number.isFinite(perim) ? measure(perim, 1, u) : 'Needs the side lengths';
    rows.areas = areaConversions(area, u);
    const want = c.want ?? 'area';
    const wv = want === 'perim' ? perim : area;

    if (!Number.isFinite(wv)) {
        return need('Enter the sides to find the perimeter.');
    }

    return measured(wv, want === 'perim' ? 1 : 2, u, want === 'perim' ? 'Perimeter' : 'Area', { sub: want === 'perim' ? `Area ${measure(area, 2, u)}` : Number.isFinite(perim) ? `Perimeter ${measure(perim, 1, u)}` : 'A = d₁d₂ ÷ 2', rows, steps, plots: pts ? { diagram: { kind: 'diagram', shapes: [{ points: pts, closed: true }], dots: pts.slice(0, -1) } } : undefined });
}

function heronArea(a, b, c) {
    const s = (a + b + c) / 2;
    const q = s * (s - a) * (s - b) * (s - c);

    return q > 0 ? sqrt(q) : NaN;
}

/** The point at distance r1 from P and r2 from Q, on the left of P → Q (side = 1) or the right (−1). */
function thirdPoint(P, Q, r1, r2, side = 1) {
    const d = hypot(Q[0] - P[0], Q[1] - P[1]);
    const a = (r1 * r1 - r2 * r2 + d * d) / (2 * d);
    const h = sqrt(Math.max(r1 * r1 - a * a, 0));
    const ex = (Q[0] - P[0]) / d;
    const ey = (Q[1] - P[1]) / d;

    return [P[0] + a * ex - side * h * ey, P[1] + a * ey + side * h * ex];
}

/** Overlap (lens) of circles R and r with centres d apart. */
export function lensArea(R0, r0, d) {
    if (d >= R0 + r0) {
        return 0;
    }

    if (d <= abs(R0 - r0)) {
        return PI * Math.min(R0, r0) ** 2;
    }

    const a1 = acos((d * d + R0 * R0 - r0 * r0) / (2 * d * R0));
    const a2 = acos((d * d + r0 * r0 - R0 * R0) / (2 * d * r0));

    return R0 * R0 * a1 + r0 * r0 * a2 - 0.5 * sqrt((-d + R0 + r0) * (d + R0 - r0) * (d - R0 + r0) * (d + R0 + r0));
}

/** Rows of numbers from a textarea ("x, y" or "x, y, m" per line). */
function readRows(text, min, max) {
    const lines = String(text ?? '').split(/\n|;/).map((l) => l.trim()).filter(Boolean);
    const rows = lines.map((l) => l.split(/[,\s]+/).filter(Boolean).map((x) => Number(x.replace('−', '-'))));

    if (rows.some((r) => r.length < min || r.length > max || r.some((x) => !Number.isFinite(x)))) {
        return null;
    }

    return rows;
}

/** Ax² + Bxy + Cy² + Dx + Ey + F = 0 from a typed equation, by sampling (exact for any quadratic). */
export function conicCoefficients(text) {
    let tree;

    try {
        tree = parse(text);
    } catch (e) {
        if (e instanceof ParseError) {
            return { error: e.message };
        }

        throw e;
    }

    const vars = [...variables(tree)].filter((n) => n !== 'x' && n !== 'y');

    if (vars.length) {
        return { error: `Use only x and y (found ${vars.join(', ')}).` };
    }

    const F = tree.t === 'rel' ? (x, y) => evalReal(tree.parts[0], { x, y }) - evalReal(tree.parts[1], { x, y }) : (x, y) => evalReal(tree, { x, y });
    const f00 = F(0, 0);
    const [fx1, fxm, fy1, fym, f11] = [F(1, 0), F(-1, 0), F(0, 1), F(0, -1), F(1, 1)];
    const A = (fx1 + fxm) / 2 - f00;
    const Dc = (fx1 - fxm) / 2;
    const C = (fy1 + fym) / 2 - f00;
    const E = (fy1 - fym) / 2;
    const B = f11 - A - C - Dc - E - f00;
    const fit = (x, y) => A * x * x + B * x * y + C * y * y + Dc * x + E * y + f00;
    const scale = Math.max(...[A, B, C, Dc, E, f00].map(abs), 1);

    for (const [x, y] of [[0.37, -1.21], [2.3, 0.7], [-3.1, 2.9]]) {
        if (!(abs(F(x, y) - fit(x, y)) < 1e-9 * scale * (1 + x * x + y * y))) {
            return { error: 'This is not a second-degree equation in x and y.' };
        }
    }

    if ([A, B, C].every((k) => abs(k) < 1e-12 * scale)) {
        return { error: 'There is no x², xy or y² term, so this is a line, not a conic.' };
    }

    const clean = (k) => (abs(k) < 1e-12 * scale ? 0 : k);

    return { A: clean(A), B: clean(B), C: clean(C), D: clean(Dc), E: clean(E), F: clean(f00) };
}

const sgn = (x, first = false) => (x < 0 ? (first ? '−' : ' − ') : first ? '' : ' + ');
const shift = (v, name) => (abs(v) < 1e-12 ? name : `(${name} ${v > 0 ? '−' : '+'} ${f(abs(v), 10)})`);

/** Conic sections from a general equation: type, centre, axes, foci, eccentricity, directrices, with a graph. */
function conic(i, c) {
    const k = conicCoefficients(i.eq);

    if (k.error) {
        return String(i.eq ?? '').trim() ? fail(k.error) : need('Type an equation in x and y.');
    }

    const { A, B, C, D: Dc, E, F } = k;
    const disc = B * B - 4 * A * C;
    const theta = abs(B) < 1e-12 ? 0 : 0.5 * atan2(B, A - C);
    const [ct, st] = [cos(theta), sin(theta)];
    // Rotated coefficients (no xy term).
    const A1 = A * ct * ct + B * ct * st + C * st * st;
    const C1 = A * st * st - B * ct * st + C * ct * ct;
    const D1 = Dc * ct + E * st;
    const E1 = -Dc * st + E * ct;
    const general = `${[[A, 'x²'], [B, 'xy'], [C, 'y²'], [Dc, 'x'], [E, 'y'], [F, '']].filter(([v]) => v !== 0).map(([v, t], n) => `${sgn(v, n === 0)}${abs(v) === 1 && t ? '' : f(abs(v), 10)}${t}`).join('')} = 0`;
    const toXY = (u, w) => [u * ct - w * st, u * st + w * ct];
    const rows = { general, rotation: abs(theta) < 1e-12 ? 'None (no xy term)' : `Axes rotated by ${f(theta / D, 10)}°`, disc: `B² − 4AC = ${f(disc, 10)}` };
    let type;
    let series = [];
    const steps = [`Coefficients: A = ${f(A)}, B = ${f(B)}, C = ${f(C)}, D = ${f(Dc)}, E = ${f(E)}, F = ${f(F)}`, `Discriminant B² − 4AC = ${f(disc, 10)}`];

    if (abs(B) > 1e-12) {
        steps.push(`Rotate by θ = ½ atan(B ÷ (A − C)) = ${f(theta / D, 10)}° to remove the xy term`);
    }

    if (abs(A1) > 1e-12 && abs(C1) > 1e-12) {
        const h = -D1 / (2 * A1);
        const kk = -E1 / (2 * C1);
        const rhs = -F + A1 * h * h + C1 * kk * kk;
        const centre = toXY(h, kk);
        rows.center = `(${f(centre[0], 10)}, ${f(centre[1], 10)})`;

        if (abs(rhs) < 1e-12 * Math.max(1, abs(F))) {
            type = disc < 0 ? 'Degenerate ellipse (a single point)' : 'Degenerate hyperbola (two crossing lines)';
        } else {
            const p = rhs / A1;
            const q = rhs / C1;

            if (p > 0 && q > 0) {
                const [a, b, alongU] = p >= q ? [sqrt(p), sqrt(q), true] : [sqrt(q), sqrt(p), false];
                const cc = sqrt(a * a - b * b);
                const e = cc / a;
                type = abs(a - b) < 1e-12 * a ? 'Circle' : 'Ellipse';
                const focus = (s) => toXY(h + (alongU ? s * cc : 0), kk + (alongU ? 0 : s * cc));
                rows.standard = `${shift(h, abs(theta) > 1e-12 ? 'x′' : 'x')}²/${f(p, 10)} + ${shift(kk, abs(theta) > 1e-12 ? 'y′' : 'y')}²/${f(q, 10)} = 1`;
                rows.axes = type === 'Circle' ? `Radius ${f(a, 10)}` : `Semi-major a = ${f(a, 10)}, semi-minor b = ${f(b, 10)}`;
                rows.foci = type === 'Circle' ? 'The centre' : `(${f(focus(1)[0], 10)}, ${f(focus(1)[1], 10)}) and (${f(focus(-1)[0], 10)}, ${f(focus(-1)[1], 10)})`;
                rows.ecc = f(e, 10);
                rows.vertices = `(${toXY(h + (alongU ? a : 0), kk + (alongU ? 0 : a)).map((x) => f(x, 8)).join(', ')}) and (${toXY(h - (alongU ? a : 0), kk - (alongU ? 0 : a)).map((x) => f(x, 8)).join(', ')})`;
                rows.extra = `Area πab = ${f(PI * a * b, 10)}; perimeter ${f(ellipsePerimeter(a, b), 10)}`;
                rows.latus = type === 'Circle' ? `${f(2 * a, 10)} (a diameter)` : `2b² ÷ a = ${f((2 * b * b) / a, 10)}`;
                series = Array.from({ length: 145 }, (_, n) => toXY(h + sqrt(p) * cos((2 * PI * n) / 144), kk + sqrt(q) * sin((2 * PI * n) / 144)));
            } else if (p < 0 && q < 0) {
                type = 'No real points (imaginary ellipse)';
            } else {
                type = 'Hyperbola';
                const alongU = p > 0;
                const a = sqrt(abs(alongU ? p : q));
                const b = sqrt(abs(alongU ? q : p));
                const cc = hypot(a, b);
                const focus = (s) => toXY(h + (alongU ? s * cc : 0), kk + (alongU ? 0 : s * cc));
                rows.standard = alongU ? `${shift(h, 'x')}²/${f(a * a, 10)} − ${shift(kk, 'y')}²/${f(b * b, 10)} = 1` : `${shift(kk, 'y')}²/${f(a * a, 10)} − ${shift(h, 'x')}²/${f(b * b, 10)} = 1`;
                rows.axes = `Transverse semi-axis a = ${f(a, 10)}, conjugate b = ${f(b, 10)}`;
                rows.foci = `(${focus(1).map((x) => f(x, 10)).join(', ')}) and (${focus(-1).map((x) => f(x, 10)).join(', ')})`;
                rows.ecc = f(cc / a, 10);
                rows.vertices = `(${toXY(h + (alongU ? a : 0), kk + (alongU ? 0 : a)).map((x) => f(x, 8)).join(', ')}) and (${toXY(h - (alongU ? a : 0), kk - (alongU ? 0 : a)).map((x) => f(x, 8)).join(', ')})`;
                rows.extra = `Asymptote slopes ±${f(b / a, 10)} in the ${abs(theta) > 1e-12 ? 'rotated ' : ''}axes`;
                rows.latus = `2b² ÷ a = ${f((2 * b * b) / a, 10)}`;
                const branch = (s) => Array.from({ length: 61 }, (_, n) => {
                    const t = -2 + (4 * n) / 60;
                    const [u, w] = alongU ? [h + s * a * Math.cosh(t), kk + b * Math.sinh(t)] : [h + b * Math.sinh(t), kk + s * a * Math.cosh(t)];

                    return toXY(u, w);
                });
                series = [...branch(1), [NaN, NaN], ...branch(-1)];
            }
        }
    } else {
        type = 'Parabola';
        // A1 u² + D1 u + E1 w + F = 0 (or the same with u and w swapped).
        const uSquared = abs(A1) > 1e-12;
        const a2 = uSquared ? A1 : C1;
        const lin = uSquared ? D1 : E1;
        const other = uSquared ? E1 : D1;

        if (abs(other) < 1e-12) {
            type = 'Degenerate parabola (parallel lines or none)';
        } else {
            const h = -lin / (2 * a2);
            const kk = -(F - (lin * lin) / (4 * a2)) / other;
            const p = -other / (4 * a2);
            const vertex = uSquared ? toXY(h, kk) : toXY(kk, h);
            const focus = uSquared ? toXY(h, kk + p) : toXY(kk + p, h);
            rows.center = `Vertex (${vertex.map((x) => f(x, 10)).join(', ')})`;
            const k4 = f(4 * p, 10) === '1' ? '' : f(4 * p, 10) === '−1' ? '−' : f(4 * p, 10);
            const rhs = (name) => (k4 === '' ? shift(kk, name).replace(/^\((.*)\)$/, '$1') : `${k4}${shift(kk, name)}`);
            rows.standard = uSquared ? `${shift(h, 'x')}² = ${rhs('y')}` : `${shift(h, 'y')}² = ${rhs('x')}`;
            rows.axes = `Focal length p = ${f(p, 10)}; latus rectum ${f(abs(4 * p), 10)}`;
            rows.latus = `|4p| = ${f(abs(4 * p), 10)}, from (${(uSquared ? toXY(h - 2 * p, kk + p) : toXY(kk + p, h - 2 * p)).map((x) => f(x, 8)).join(', ')}) to (${(uSquared ? toXY(h + 2 * p, kk + p) : toXY(kk + p, h + 2 * p)).map((x) => f(x, 8)).join(', ')})`;
            rows.foci = `(${focus.map((x) => f(x, 10)).join(', ')})`;
            rows.ecc = '1';
            rows.vertices = `(${vertex.map((x) => f(x, 10)).join(', ')})`;
            rows.extra = `Directrix ${uSquared && abs(theta) < 1e-12 ? `y = ${f(kk - p, 10)}` : !uSquared && abs(theta) < 1e-12 ? `x = ${f(kk - p, 10)}` : 'perpendicular to the axis, p beyond the vertex'}`;
            const span = Math.max(abs(p) * 6, 2);
            series = Array.from({ length: 81 }, (_, n) => {
                const s = h - span + (2 * span * n) / 80;
                const w = kk + ((s - h) ** 2) / (4 * p);

                return uSquared ? toXY(s, w) : toXY(w, s);
            });
        }
    }

    ['center', 'standard', 'axes', 'foci', 'ecc', 'vertices', 'extra', 'latus'].forEach((key) => {
        rows[key] ??= 'Not applicable';
    });
    steps.push(`Type: ${type}`);

    const plot = series.length ? { graph: conicDiagram(series) } : undefined;
    const want = c.want ?? 'type';
    const value = { type, center: rows.center, foci: rows.foci, standard: rows.standard, latus: rows.latus.replace(/^.*?= /, '').replace(/, from.*$/, '').replace(/ \(a diameter\)$/, '') }[want] ?? type;

    return result(value, { type: 'Conic section', center: 'Centre', foci: 'Foci', standard: 'Standard form', latus: 'Latus rectum length' }[want] ?? 'Conic section', { sub: want === 'type' ? rows.standard : want === 'latus' ? `${type}: ${rows.latus}` : type, rows, steps, plots: plot });
}

/** Ellipse from its centre and semi-axes: standard form, foci, vertices (for the ellipse equation pages). */
function ellipseEq(i, c) {
    const [h, k, a0, b0] = [i.h, i.k, i.a, i.b].map(Number);

    if (![h, k].every(Number.isFinite) || !(a0 > 0 && b0 > 0)) {
        return need('Enter the centre (h, k) and the two semi-axes.');
    }

    const horizontal = a0 >= b0;
    const [a, b] = horizontal ? [a0, b0] : [b0, a0];
    const cc = sqrt(a * a - b * b);
    const xs = (x) => shift(h, 'x').replace('x', 'x');
    const std = `${xs()}²/${f(a0 * a0, 10)} + ${shift(k, 'y')}²/${f(b0 * b0, 10)} = 1`;
    const foci = horizontal ? [[h - cc, k], [h + cc, k]] : [[h, k - cc], [h, k + cc]];
    const A = b0 * b0;
    const C = a0 * a0;
    const general = `${f(A, 10)}x² + ${f(C, 10)}y²${sgn(-2 * A * h)}${f(abs(2 * A * h), 10)}x${sgn(-2 * C * k)}${f(abs(2 * C * k), 10)}y${sgn(A * h * h + C * k * k - A * C)}${f(abs(A * h * h + C * k * k - A * C), 10)} = 0`.replace(/ \+ 0x| − 0x/, '').replace(/ \+ 0y| − 0y/, '');
    const rows = { standard: std, general, center: `(${f(h)}, ${f(k)})`, foci: `(${foci[0].map((x) => f(x, 10)).join(', ')}) and (${foci[1].map((x) => f(x, 10)).join(', ')})`, vertices: horizontal ? `(${f(h - a, 10)}, ${f(k)}) and (${f(h + a, 10)}, ${f(k)})` : `(${f(h)}, ${f(k - a, 10)}) and (${f(h)}, ${f(k + a, 10)})`, ecc: f(cc / a, 10), c: f(cc, 10), extra: `Area ${f(PI * a * b, 10)}; perimeter ${f(ellipsePerimeter(a, b), 10)}` };
    const want = c.want ?? 'standard';

    return result(rows[want], { standard: 'Standard form', foci: 'Foci', center: 'Centre' }[want], { sub: want === 'foci' ? `c = √(a² − b²) = ${f(cc, 10)}` : `Foci ${rows.foci}`, rows, steps: [`Centre (h, k) = (${f(h)}, ${f(k)})`, `(x − h)²/a² + (y − k)²/b² = 1 → ${std}`, `c = √(${f(a * a)} − ${f(b * b)}) = ${f(cc, 10)}`, `Foci: ${rows.foci}`, `Expanded: ${general}`], plots: { graph: { ...conicDiagram(ellipsePts(a0, b0, h, k)), dots: [[h, k], ...foci] } } });
}

export const handlers = {
    shape: solveShape,
    hub,
    trapezoid,
    quad,
    conic,
    ellipse_eq: ellipseEq,

    crescent: (i) => {
        const u = i.unit ?? 'cm';
        const [R0, r0, d] = [i.outer, i.inner, i.dist].map(Number);

        if (!(R0 > 0 && r0 > 0 && d >= 0)) {
            return need('Enter the two radii and the distance between the centres.');
        }

        if (d >= R0 + r0) {
            return fail('The circles do not overlap, so no crescent is cut out.');
        }

        if (d + R0 <= r0) {
            return fail('The second circle covers the first completely, so nothing is left.');
        }

        const lens = lensArea(R0, r0, d);
        const area = PI * R0 * R0 - lens;
        // Arc of the big circle outside the small one, plus arc of the small circle inside the big one.
        const inside = d + r0 <= R0;
        const a1 = inside ? 0 : acos((d * d + R0 * R0 - r0 * r0) / (2 * d * R0));
        const a2 = inside ? PI : acos((d * d + r0 * r0 - R0 * R0) / (2 * d * r0));
        const perim = inside ? 2 * PI * (R0 + r0) : 2 * R0 * (PI - a1) + 2 * r0 * a2;
        const big = arc(0, 0, R0);
        const small = arc(d, 0, r0);

        return measured(area, 2, u, 'Crescent area', { sub: `πR² − overlap = ${measure(PI * R0 * R0, 2, u)} − ${measure(lens, 2, u)}`, rows: { lens: measure(lens, 2, u), circle: measure(PI * R0 * R0, 2, u), perim: measure(perim, 1, u), share: `${f((area / (PI * R0 * R0)) * 100, 6)}% of the circle`, areas: areaConversions(area, u) }, steps: [`Circle area πR² = ${measure(PI * R0 * R0, 2, u)}`, `Overlap (lens) = R²α + r²β − ½√((−d + R + r)(d + R − r)(d − R + r)(d + R + r)) = ${measure(lens, 2, u)}`, `Crescent = ${measure(area, 2, u)}`], plots: { diagram: { kind: 'diagram', shapes: [{ points: big, closed: true }, { points: small, muted: true, dashed: true }], dots: [[0, 0], [d, 0]], labels: [{ x: -R0 * 0.5, y: R0 * 0.1, text: `R = ${measure(R0, 1, u, 5)}` }, { x: d + r0 * 0.4, y: -r0 * 0.15, text: `r = ${measure(r0, 1, u, 5)}` }] } } });
    },

    center_mass: (i, c) => {
        const rows = readRows(i.points, 2, c.mode === 'centroid' ? 2 : 3);

        if (!rows || rows.length < (c.mode === 'centroid' ? 3 : 1)) {
            return need(c.mode === 'centroid' ? 'Type at least three vertices, one "x, y" per line, in order around the shape.' : 'Type one point per line: x, y, mass.');
        }

        if (c.mode === 'centroid') {
            let A = 0;
            let cx = 0;
            let cy = 0;
            const n = rows.length;

            for (let k = 0; k < n; k += 1) {
                const [x0, y0] = rows[k];
                const [x1, y1] = rows[(k + 1) % n];
                const cross = x0 * y1 - x1 * y0;
                A += cross;
                cx += (x0 + x1) * cross;
                cy += (y0 + y1) * cross;
            }

            A /= 2;

            if (abs(A) < 1e-14) {
                return fail('The vertices enclose no area (they may lie on a line).');
            }

            cx /= 6 * A;
            cy /= 6 * A;
            const avg = [rows.reduce((s, p) => s + p[0], 0) / n, rows.reduce((s, p) => s + p[1], 0) / n];

            return result(`(${f(cx, 10)}, ${f(cy, 10)})`, 'Centroid (centre of area)', { sub: `Area ${f(abs(A), 10)}`, rows: { area: f(abs(A), 12), vertexMean: `(${f(avg[0], 10)}, ${f(avg[1], 10)})${n === 3 ? ' (same as the centroid for a triangle)' : ''}`, orientation: A > 0 ? 'Counter-clockwise' : 'Clockwise' }, steps: [`Shoelace area A = ½Σ(xᵢyᵢ₊₁ − xᵢ₊₁yᵢ) = ${f(A, 12)}`, `Cx = Σ(xᵢ + xᵢ₊₁)(xᵢyᵢ₊₁ − xᵢ₊₁yᵢ) ÷ 6A = ${f(cx, 12)}`, `Cy = Σ(yᵢ + yᵢ₊₁)(xᵢyᵢ₊₁ − xᵢ₊₁yᵢ) ÷ 6A = ${f(cy, 12)}`], plots: { diagram: { kind: 'diagram', shapes: [{ points: [...rows, rows[0]].map((p) => [p[0], p[1]]), closed: true }], dots: [[cx, cy]], labels: [{ x: cx, y: cy + Math.max(...rows.map((p) => abs(p[1] - cy))) * 0.12, text: 'G' }] } } });
        }

        const pts = rows.map((r) => (r.length === 2 ? [r[0], 0, r[1]] : r));
        const M = pts.reduce((s, p) => s + p[2], 0);

        if (!(M > 0) || pts.some((p) => p[2] < 0)) {
            return fail('Masses must be positive.');
        }

        const cx = pts.reduce((s, p) => s + p[0] * p[2], 0) / M;
        const cy = pts.reduce((s, p) => s + p[1] * p[2], 0) / M;
        const span = Math.max(1, ...pts.map((p) => hypot(p[0] - cx, p[1] - cy)));

        return result(`(${f(cx, 10)}, ${f(cy, 10)})`, 'Centre of mass', { sub: `Total mass ${f(M, 10)}`, rows: { mass: f(M, 12), x: f(cx, 12), y: f(cy, 12), moment: `Σmx = ${f(cx * M, 10)}, Σmy = ${f(cy * M, 10)}` }, steps: [`M = Σm = ${f(M, 12)}`, `x̄ = Σmx ÷ M = ${f(cx * M, 12)} ÷ ${f(M, 12)} = ${f(cx, 12)}`, `ȳ = Σmy ÷ M = ${f(cy * M, 12)} ÷ ${f(M, 12)} = ${f(cy, 12)}`], plots: { diagram: { kind: 'diagram', shapes: [], dots: [...pts.map((p) => [p[0], p[1]]), [cx, cy]], labels: [...pts.slice(0, 12).map((p) => ({ x: p[0], y: p[1] + span * 0.08, text: `m = ${f(p[2], 4)}` })), { x: cx, y: cy - span * 0.1, text: 'CM' }] } } });
    },

    section: (i, c) => {
        const u = i.unit ?? 'cm';
        const kind = i.section ?? 'rect';
        const [b, h, t, tw, D0, d0, offset] = [i.b, i.h, i.t, i.tw, i.dout, i.din, i.offset].map(Number);
        const pos = (...xs) => xs.every((x) => x > 0);
        // Parts: rectangles [x0, y0, width, height] (negative area for holes) or circles.
        let parts;
        let label;

        if (kind === 'rect') {
            if (!pos(b, h)) {
                return need('Enter the width and height.');
            }

            parts = [[0, 0, b, h]];
            label = 'Rectangle';
        } else if (kind === 'hollowRect') {
            if (!pos(b, h, t) || 2 * t >= Math.min(b, h)) {
                return need('Enter the width, height and a wall thickness under half the smaller side.');
            }

            parts = [[0, 0, b, h], [t, t, b - 2 * t, h - 2 * t, -1]];
            label = 'Hollow rectangle (box section)';
        } else if (kind === 'ibeam' || kind === 'tbeam' || kind === 'channel' || kind === 'angle') {
            if (!pos(b, h, t, tw) || 2 * t >= h || tw >= b) {
                return need('Enter the flange width b, total height h, flange thickness t and web thickness (t under h/2, web under b).');
            }

            parts = {
                ibeam: [[0, 0, b, t], [(b - tw) / 2, t, tw, h - 2 * t], [0, h - t, b, t]],
                tbeam: [[0, h - t, b, t], [(b - tw) / 2, 0, tw, h - t]],
                channel: [[0, 0, b, t], [0, t, tw, h - 2 * t], [0, h - t, b, t]],
                angle: [[0, 0, b, t], [0, t, tw, h - t]],
            }[kind];
            label = { ibeam: 'I-beam', tbeam: 'T-section', channel: 'C-channel', angle: 'L-angle' }[kind];
        } else if (kind === 'circle' || kind === 'tube') {
            if (!pos(D0) || (kind === 'tube' && !(d0 > 0 && d0 < D0))) {
                return need(kind === 'tube' ? 'Enter the outer and inner diameters (inner smaller).' : 'Enter the diameter.');
            }

            const ro = D0 / 2;
            const ri = kind === 'tube' ? d0 / 2 : 0;
            const A = PI * (ro * ro - ri * ri);
            const I = (PI / 4) * (ro ** 4 - ri ** 4);

            return sectionResult(c, u, kind === 'tube' ? 'Hollow circle (pipe)' : 'Circle', A, [ro, ro], I, I, ro, ro, offset, { kind: 'diagram', shapes: [{ points: arc(0, 0, ro), closed: true }, ...(ri ? [{ points: arc(0, 0, ri) }] : [])], dots: [[0, 0]] }, kind === 'tube' ? 'A = π(D² − d²) ÷ 4, I = π(D⁴ − d⁴) ÷ 64' : 'A = πD² ÷ 4, I = πD⁴ ÷ 64');
        } else if (kind === 'triangle') {
            if (!pos(b, h)) {
                return need('Enter the base and height.');
            }

            const A = (b * h) / 2;

            return sectionResult(c, u, 'Triangle (isosceles)', A, [b / 2, h / 3], (b * h ** 3) / 36, (h * b ** 3) / 48, (2 * h) / 3, b / 2, offset, { kind: 'diagram', shapes: [{ points: [[0, 0], [b, 0], [b / 2, h], [0, 0]], closed: true }], dots: [[b / 2, h / 3]] }, 'A = bh ÷ 2, Ix = bh³ ÷ 36');
        } else {
            return need('Choose a section.');
        }

        const area = (p) => (p[4] ?? 1) * p[2] * p[3];
        const A = parts.reduce((s, p) => s + area(p), 0);
        const cx = parts.reduce((s, p) => s + area(p) * (p[0] + p[2] / 2), 0) / A;
        const cy = parts.reduce((s, p) => s + area(p) * (p[1] + p[3] / 2), 0) / A;
        const Ix = parts.reduce((s, p) => s + (p[4] ?? 1) * ((p[2] * p[3] ** 3) / 12 + p[2] * p[3] * (p[1] + p[3] / 2 - cy) ** 2), 0);
        const Iy = parts.reduce((s, p) => s + (p[4] ?? 1) * ((p[3] * p[2] ** 3) / 12 + p[2] * p[3] * (p[0] + p[2] / 2 - cx) ** 2), 0);
        const ys = parts.flatMap((p) => [p[1], p[1] + p[3]]);
        const xs = parts.flatMap((p) => [p[0], p[0] + p[2]]);
        const shapes = parts.map((p) => ({ points: [[p[0], p[1]], [p[0] + p[2], p[1]], [p[0] + p[2], p[1] + p[3]], [p[0], p[1] + p[3]], [p[0], p[1]]], closed: !(p[4] < 0), muted: p[4] < 0 }));

        return sectionResult(c, u, label, A, [cx, cy], Ix, Iy, Math.max(Math.max(...ys) - cy, cy - Math.min(...ys)), Math.max(Math.max(...xs) - cx, cx - Math.min(...xs)), offset, { kind: 'diagram', shapes, dots: [[cx, cy]] }, 'Split into rectangles; I = Σ(bh³/12 + A d²) (parallel axis theorem)');
    },

    segment_addition: (i) => {
        const texts = [i.ab, i.bc, i.ac].map((s) => String(s ?? '').trim());
        const names = ['AB', 'BC', 'AC'];

        try {
            const polys = texts.map((s) => (s ? toPoly(parse(s), 'x') : null));

            if (polys.some((p, k) => texts[k] && !p)) {
                return fail('Use numbers or expressions in x such as 2x + 3.');
            }

            if (polys.some((p) => p && p.length > 2)) {
                return fail('Only linear expressions (ax + b) are supported.');
            }

            const blanks = polys.map((p, k) => (p ? null : k)).filter((k) => k !== null);
            const hasX = polys.some((p) => p && p.length > 1 && !R.isZero(p[1]));
            const val = (p, x) => (p.length > 1 ? R.add(p[0], R.mul(p[1], x)) : p[0]);

            if (blanks.length === 1 && !hasX) {
                const [ab, bc, ac] = polys.map((p) => (p ? p[0] : null));
                const missing = blanks[0];
                const value = missing === 2 ? R.add(ab, bc) : missing === 0 ? R.sub(ac, bc) : R.sub(ac, ab);

                if (R.sign(value) <= 0) {
                    return fail('The parts must be shorter than the whole segment AC.');
                }

                return result(R.toFraction(value), names[missing], { sub: 'AB + BC = AC', rows: { x: 'No unknown x', ab: R.toFraction(ab ?? value), bc: R.toFraction(bc ?? value), ac: R.toFraction(ac ?? value) }, steps: [`AB + BC = AC`, `${names[missing]} = ${R.toFraction(value)}`] });
            }

            if (blanks.length) {
                return need('Fill in all three segments (in terms of x), or leave exactly one blank when all are numbers.');
            }

            // AB + BC − AC = 0 → linear in x.
            const lhs = [0, 1].map((k) => R.sub(R.add(polys[0][k] ?? R.ZERO, polys[1][k] ?? R.ZERO), polys[2][k] ?? R.ZERO));

            if (R.isZero(lhs[1])) {
                return fail(R.isZero(lhs[0]) ? 'Every x works: the expressions always add up.' : 'No x works: the expressions never add up.');
            }

            const x = R.div(R.neg(lhs[0]), lhs[1]);
            const lens = polys.map((p) => val(p, x));

            if (lens.some((L) => R.sign(L) <= 0)) {
                return result(`x = ${R.toFraction(x)}`, 'Solution', { sub: 'But a segment comes out zero or negative, so no such points exist', rows: { x: R.toFraction(x), ab: R.toFraction(lens[0]), bc: R.toFraction(lens[1]), ac: R.toFraction(lens[2]) }, steps: [`(${texts[0]}) + (${texts[1]}) = ${texts[2]}`, `x = ${R.toFraction(x)}`] });
            }

            return result(`x = ${R.toFraction(x)}`, 'Solution', { sub: `AB = ${R.toFraction(lens[0])}, BC = ${R.toFraction(lens[1])}, AC = ${R.toFraction(lens[2])}`, rows: { x: R.toFraction(x), ab: R.toFraction(lens[0]), bc: R.toFraction(lens[1]), ac: R.toFraction(lens[2]) }, steps: [`Segment addition: AB + BC = AC`, `(${texts[0]}) + (${texts[1]}) = ${texts[2]}`, `Collect terms: ${R.toFraction(lhs[1])}x = ${R.toFraction(R.neg(lhs[0]))}`, `x = ${R.toFraction(x)}`, `Check: ${R.toFraction(lens[0])} + ${R.toFraction(lens[1])} = ${R.toFraction(lens[2])} ✓`], plots: { diagram: { kind: 'diagram', shapes: [{ points: [[0, 0], [R.toNumber(lens[2]), 0]] }], dots: [[0, 0], [R.toNumber(lens[0]), 0], [R.toNumber(lens[2]), 0]], labels: [{ x: 0, y: R.toNumber(lens[2]) * 0.05, text: 'A' }, { x: R.toNumber(lens[0]), y: R.toNumber(lens[2]) * 0.05, text: 'B' }, { x: R.toNumber(lens[2]), y: R.toNumber(lens[2]) * 0.05, text: 'C' }] } } });
        } catch (e) {
            if (e instanceof ParseError) {
                return fail(e.message);
            }

            throw e;
        }
    },

    spiral: (i) => {
        const u = i.unit ?? 'cm';
        const kind = i.kind ?? 'roll';
        let length;
        let pts;
        const steps = [];
        const rows = {};

        if (kind === 'roll') {
            const [Dout, Din, thick] = [i.dout, i.din, i.thick].map(Number);

            if (!(Dout > 0 && Din >= 0 && thick > 0 && Dout > Din)) {
                return need('Enter the outer and inner diameters and the material thickness.');
            }

            const turns = (Dout - Din) / (2 * thick);
            const a = Din / 2;
            const b = thick / (2 * PI);
            length = archLength(a, b, 0, 2 * PI * turns);
            rows.turns = f(turns, 10);
            rows.approx = measure((PI * turns * (Dout + Din)) / 2, 1, u);
            steps.push(`Turns N = (D − d) ÷ 2t = ${f(turns, 10)}`, `Archimedean spiral r = d/2 + (t/2π)θ, θ from 0 to 2πN`, `Exact length L = ∫√(r² + (dr/dθ)²) dθ = ${measure(length, 1, u)}`, `Quick estimate πN(D + d) ÷ 2 = ${rows.approx}`);
            pts = Array.from({ length: Math.min(800, Math.ceil(turns * 60) + 2) }, (_, n, arr) => {
                const th = (2 * PI * turns * n) / (Math.min(800, Math.ceil(turns * 60) + 2) - 1);

                return [(a + b * th) * cos(th), (a + b * th) * sin(th)];
            });
        } else {
            const [a, b, turns] = [i.a, i.b, i.turns].map(Number);

            if (!(Number.isFinite(a) && a >= 0 && b > 0 && turns > 0)) {
                return need(kind === 'log' ? 'Enter a (> 0), the growth b and the number of turns.' : 'Enter a, b and the number of turns.');
            }

            const end = 2 * PI * turns;

            if (kind === 'log') {
                if (!(a > 0)) {
                    return need('For a logarithmic spiral a must be positive.');
                }

                length = (sqrt(1 + b * b) / b) * (a * Math.exp(b * end) - a);
                steps.push('Logarithmic spiral r = a e^(bθ)', `L = (√(1 + b²) ÷ b)(r_end − r_start) = ${measure(length, 1, u)}`);
                pts = Array.from({ length: 301 }, (_, n) => {
                    const th = (end * n) / 300;
                    const r = a * Math.exp(b * th);

                    return [r * cos(th), r * sin(th)];
                });
                rows.turns = f(turns, 10);
                rows.approx = `End radius ${measure(a * Math.exp(b * end), 1, u)}`;
            } else {
                length = archLength(a, b, 0, end);
                steps.push('Archimedean spiral r = a + bθ', `L = ∫₀^(2πN) √((a + bθ)² + b²) dθ = ${measure(length, 1, u)}`);
                pts = Array.from({ length: 301 }, (_, n) => {
                    const th = (end * n) / 300;

                    return [(a + b * th) * cos(th), (a + b * th) * sin(th)];
                });
                rows.turns = f(turns, 10);
                rows.approx = `End radius ${measure(a + b * end, 1, u)}; gap between turns ${measure(2 * PI * b, 1, u)}`;
            }
        }

        return measured(length, 1, u, 'Spiral length', { sub: kind === 'roll' ? `${rows.turns} turns` : rows.approx, rows, steps, plots: { diagram: { kind: 'diagram', shapes: [{ points: pts }] } } });
    },

    cycloid: (i) => {
        const u = i.unit ?? 'cm';
        const r = Number(i.r);
        const turns = Number(i.turns ?? 1);

        if (!(r > 0) || !(turns > 0)) {
            return need('Enter the radius of the rolling circle and how far it rolls (turns).');
        }

        const th = 2 * PI * turns;
        const full = Math.floor(turns);
        const rest = th - 2 * PI * full;
        const length = 8 * r * full + 4 * r * (1 - cos(rest / 2));
        const pts = Array.from({ length: 241 }, (_, n) => {
            const t = (th * n) / 240;

            return [r * (t - sin(t)), r * (1 - cos(t))];
        });

        return measured(length, 1, u, 'Length of the path traced', { sub: `One arch: 8r = ${measure(8 * r, 1, u)}`, rows: { arch: measure(8 * r, 1, u), area: measure(3 * PI * r * r, 2, u), base: measure(2 * PI * r, 1, u), height: measure(2 * r, 1, u), point: `(${f(r * (th - sin(th)), 10)}, ${f(r * (1 - cos(th)), 10)})` }, steps: ['x = r(t − sin t), y = r(1 − cos t)', 'Arc length of one arch = 8r', `Area under one arch = 3πr² = ${measure(3 * PI * r * r, 2, u)}`, `After ${f(turns)} turn${turns === 1 ? '' : 's'}: ${measure(length, 1, u)}`], plots: { diagram: { kind: 'diagram', shapes: [{ points: pts }, { points: [[0, 0], [r * th, 0]], muted: true }, { points: arc(r * th, r, r), muted: true, dashed: true }] } } });
    },

    mobius: (i) => {
        const u = i.unit ?? 'cm';
        const [R0, w] = [i.r, i.w].map(Number);

        if (!(R0 > 0 && w > 0) || w >= 2 * R0) {
            return need('Enter the radius of the centre circle and a strip width under the diameter.');
        }

        // Parametric Möbius band: (R + s cos(t/2)) (cos t, sin t), s sin(t/2), s in [−w/2, w/2].
        const pt = (t, s) => [(R0 + s * cos(t / 2)) * cos(t), (R0 + s * cos(t / 2)) * sin(t), s * sin(t / 2)];
        const area = integrate((t) => integrate((s) => {
            const e = 1e-6;
            const p = pt(t, s);
            const dt = pt(t + e, s).map((x, k) => (x - p[k]) / e);
            const ds = pt(t, s + e).map((x, k) => (x - p[k]) / e);
            const cr = [dt[1] * ds[2] - dt[2] * ds[1], dt[2] * ds[0] - dt[0] * ds[2], dt[0] * ds[1] - dt[1] * ds[0]];

            return hypot(...cr);
        }, -w / 2, w / 2, 1e-9), 0, 2 * PI, 1e-9);
        const edge = integrate((t) => {
            const e = 1e-6;
            const p = pt(t, w / 2);
            const q = pt(t + e, w / 2);

            return hypot(q[0] - p[0], q[1] - p[1], q[2] - p[2]) / e;
        }, 0, 4 * PI, 1e-10);
        const L = 2 * PI * R0;
        const outline = Array.from({ length: 241 }, (_, n) => {
            const p = pt((4 * PI * n) / 240, w / 2);

            return [p[0] + 0.35 * p[1], p[2] + 0.25 * p[1]];
        });

        return measured(L * w, 2, u, 'Paper needed (strip length × width)', { sub: `Strip ${measure(L, 1, u)} long, ${measure(w, 1, u)} wide, given one half-twist`, rows: { length: measure(L, 1, u), area: measure(area, 2, u), edge: measure(edge, 1, u), sides: '1 side and 1 edge', cut: 'Cutting along the middle gives one loop twice as long with two full twists; cutting a third of the way in gives two linked loops' }, steps: [`Centre line length = 2πR = ${measure(L, 1, u)}`, `Strip of paper = L × w = ${measure(L * w, 2, u)}`, `Smooth Möbius surface (R + s cos(t/2))(cos t, sin t), s sin(t/2): area by double integration = ${measure(area, 2, u)}`, `The single edge runs around twice: length ${measure(edge, 1, u)}`], plots: { diagram: { kind: 'diagram', shapes: [{ points: outline }] } } });
    },

    scale_rect: (i) => {
        const u = i.unit ?? 'cm';
        const [l, w, k0, newL] = [i.l, i.w, i.k, i.newl].map(Number);
        const byLength = i.by === 'length';
        const k = byLength ? newL / l : k0;

        if (!(l > 0 && w > 0)) {
            return need('Enter the original length and width.');
        }

        if (!(k > 0)) {
            return need(byLength ? 'Enter the new length.' : 'Enter the scale factor.');
        }

        const L = (x) => measure(x, 1, u);

        return result(f(k, 12), 'Scale factor k', { sub: `New rectangle ${L(l * k)} × ${L(w * k)}`, rows: { size: `${L(l * k)} × ${L(w * k)}`, area: `${measure(l * w, 2, u)} → ${measure(l * w * k * k, 2, u)} (× k² = ${f(k * k, 10)})`, perim: `${L(2 * (l + w))} → ${L(2 * (l + w) * k)} (× k)`, kind: k > 1 ? 'Enlargement' : k < 1 ? 'Reduction' : 'Same size' }, steps: [byLength ? `k = new length ÷ old length = ${f(newL)} ÷ ${f(l)} = ${f(k, 12)}` : `k = ${f(k)}`, `New width = ${f(w)} × ${f(k, 10)} = ${f(w * k, 12)}`, `Lengths scale by k, areas by k² = ${f(k * k, 12)}`], plots: { diagram: { kind: 'diagram', shapes: [{ points: [[0, 0], [l, 0], [l, w], [0, w], [0, 0]], muted: true, dashed: true }, { points: [[0, 0], [l * k, 0], [l * k, w * k], [0, w * k], [0, 0]], closed: true }] } } });
    },

    polygon_perimeter: (i) => {
        const u = i.unit ?? 'cm';
        const text = String(i.sides ?? '').trim();
        const pts = readRows(text, 2, 2);

        if (pts && pts.length >= 3 && /\n|;/.test(text)) {
            const n = pts.length;
            const sides = pts.map((p, k) => hypot(pts[(k + 1) % n][0] - p[0], pts[(k + 1) % n][1] - p[1]));
            const P = sides.reduce((s, x) => s + x, 0);
            let A = 0;

            for (let k = 0; k < n; k += 1) {
                A += pts[k][0] * pts[(k + 1) % n][1] - pts[(k + 1) % n][0] * pts[k][1];
            }

            return measured(P, 1, u, 'Perimeter', { sub: `${n} vertices`, rows: { sides: sides.map((s) => f(s, 8)).join(', '), count: String(n), area: `${measure(abs(A) / 2, 2, u)} (shoelace)` }, steps: sides.map((s, k) => `Side ${k + 1}: ${f(s, 10)}`).concat([`Perimeter = ${measure(P, 1, u)}`]), plots: { diagram: { kind: 'diagram', shapes: [{ points: [...pts, pts[0]], closed: true }], dots: pts } } });
        }

        const sides = text.split(/[,;]/.test(text) ? /[,;]+/ : /\s+/).map((s) => s.trim()).filter(Boolean).map((s) => R.parseNumber(s));

        if (sides.length < 3 || sides.some((s) => !s || R.sign(s) <= 0)) {
            return need('Type at least three side lengths separated by commas (fractions allowed), or vertices "x, y" one per line.');
        }

        const P = sides.reduce((s, x) => R.add(s, x), R.ZERO);
        const max = sides.reduce((m, x) => (R.cmp(x, m) > 0 ? x : m), sides[0]);
        const closes = R.cmp(R.mul(max, R.Q(2)), P) < 0;

        return result(R.isInt(P) ? R.fmt(P.n) : `${R.toFraction(P)} = ${f(R.toNumber(P), 10)}`, 'Perimeter', { unit: UNITS[u] ? u : '', sub: `${sides.length} sides`, rows: { sides: sides.map((s) => R.toFraction(s)).join(' + '), count: String(sides.length), area: closes ? 'Needs the angles too (the sides alone do not fix the area)' : 'These sides cannot close: the longest is at least the sum of the rest' }, steps: [`P = ${sides.map((s) => R.toFraction(s)).join(' + ')} = ${R.toFraction(P)}`] });
    },
};

/** A curve (NaN rows split branches) on x and y axes, drawn to scale. */
function conicDiagram(points) {
    const runs = [[]];
    points.forEach((p) => (Number.isFinite(p[0]) && Number.isFinite(p[1]) ? runs[runs.length - 1].push(p) : runs.push([])));
    const finite = points.filter((p) => Number.isFinite(p[0]) && Number.isFinite(p[1]));
    const xs = finite.map((p) => p[0]);
    const ys = finite.map((p) => p[1]);
    const [x0, x1, y0, y1] = [Math.min(...xs, 0), Math.max(...xs, 0), Math.min(...ys, 0), Math.max(...ys, 0)];
    const padX = (x1 - x0) * 0.08 || 1;
    const padY = (y1 - y0) * 0.08 || 1;

    return { kind: 'diagram', shapes: [{ points: [[x0 - padX, 0], [x1 + padX, 0]], muted: true }, { points: [[0, y0 - padY], [0, y1 + padY]], muted: true }, ...runs.filter((r) => r.length > 1).map((r) => ({ points: r }))], labels: [{ x: x1 + padX, y: padY * 0.6, text: 'x' }, { x: padX * 0.6, y: y1 + padY, text: 'y' }] };
}

function archLength(a, b, t0, t1) {
    const F = (t) => {
        const r = a + b * t;
        const root = hypot(r, b);

        return (r * root + b * b * Math.log(r + root)) / (2 * b);
    };

    return F(t1) - F(t0);
}

function sectionResult(c, u, label, A, [cx, cy], Ix, Iy, ymax, xmax, offset, diagram, formula) {
    const want = c.want ?? 'area';
    const d = Number.isFinite(offset) && offset > 0 ? offset : 0;
    const Ishift = Ix + A * d * d;
    const rows = {
        area: measure(A, 2, u),
        centroid: `(${f(cx, 10)}, ${f(cy, 10)}) ${UNITS[u] ? u : ''} from the bottom left`.replace(/ {2}/g, ' '),
        ix: `${f(Ix, 10)} ${UNITS[u] ? `${u}⁴` : 'units⁴'}`,
        iy: `${f(Iy, 10)} ${UNITS[u] ? `${u}⁴` : 'units⁴'}`,
        modulus: `Sx = ${f(Ix / ymax, 10)}, Sy = ${f(Iy / xmax, 10)} ${UNITS[u] ? `${u}³` : 'units³'}`,
        gyration: `rx = ${f(sqrt(Ix / A), 10)}, ry = ${f(sqrt(Iy / A), 10)}`,
        polar: `J = Ix + Iy = ${f(Ix + Iy, 10)}`,
        shifted: d ? `I = Ix + Ad² = ${f(Ishift, 10)} (axis ${f(d)} away)` : 'Enter an axis offset to apply the parallel axis theorem',
    };

    if (want === 'inertia') {
        return result(f(d ? Ishift : Ix, 10), d ? 'Moment of inertia about the shifted axis' : 'Moment of inertia Ix (centroidal)', { unit: UNITS[u] ? `${u}⁴` : 'units⁴', sub: `${label}; Iy = ${f(Iy, 10)}`, rows, steps: [formula, `Area A = ${measure(A, 2, u)}`, `Centroid ȳ = ${f(cy, 10)}`, `Ix = ${f(Ix, 12)}`, `Iy = ${f(Iy, 12)}`, ...(d ? [`Parallel axis: I = Ix + A d² = ${f(Ix, 10)} + ${f(A, 10)} × ${f(d)}² = ${f(Ishift, 10)}`] : [])], plots: { diagram } });
    }

    return measured(A, 2, u, 'Cross-sectional area', { sub: label, rows, steps: [formula, `A = ${measure(A, 2, u)}`, `Centroid (${f(cx, 10)}, ${f(cy, 10)})`], plots: { diagram } });
}

export { polygonPts };
export default defineTools(handlers);
