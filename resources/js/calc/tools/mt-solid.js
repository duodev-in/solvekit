import { defineTools } from '../engines/formula.js';
import { f, fail, need, result } from '../math/util.js';
import { areaConversions, measure, volumeConversions } from './mt-shape.js';

/**
 * 3D extras: Euler's polyhedron formula, great-circle distance, Platonic solids and a tetrahedron (triangular
 * pyramid) from its vertices or its base and height.
 */
const { PI, sqrt, sin, cos, asin, acos, atan, atan2, abs, hypot } = Math;
const D = PI / 180;
const PHI = (1 + sqrt(5)) / 2;

/** Platonic solids for edge a: faces, edges, vertices, face type, volume and area factors, radii and dihedral angle. */
const PLATONIC = {
    tetrahedron: { name: 'Tetrahedron', F: 4, E: 6, V: 4, face: 'triangles', vol: 1 / (6 * sqrt(2)), area: sqrt(3), R: sqrt(6) / 4, r: 1 / sqrt(24), dihedral: acos(1 / 3) },
    cube: { name: 'Cube (hexahedron)', F: 6, E: 12, V: 8, face: 'squares', vol: 1, area: 6, R: sqrt(3) / 2, r: 0.5, dihedral: PI / 2 },
    octahedron: { name: 'Octahedron', F: 8, E: 12, V: 6, face: 'triangles', vol: sqrt(2) / 3, area: 2 * sqrt(3), R: 1 / sqrt(2), r: 1 / sqrt(6), dihedral: acos(-1 / 3) },
    dodecahedron: { name: 'Dodecahedron', F: 12, E: 30, V: 20, face: 'pentagons', vol: (15 + 7 * sqrt(5)) / 4, area: 3 * sqrt(25 + 10 * sqrt(5)), R: (sqrt(3) * PHI) / 2, r: (PHI * PHI) / (2 * sqrt(3 - PHI)), dihedral: acos(-1 / sqrt(5)) },
    icosahedron: { name: 'Icosahedron', F: 20, E: 30, V: 12, face: 'triangles', vol: (5 * (3 + sqrt(5))) / 12, area: 5 * sqrt(3), R: sqrt(PHI * sqrt(5)) / 2, r: (PHI * PHI) / (2 * sqrt(3)), dihedral: acos(-sqrt(5) / 3) },
};

export const handlers = {
    euler: (i) => {
        const vals = [i.v, i.e, i.f].map((x) => (x === '' || x === undefined || x === null || Number.isNaN(Number(x)) ? null : Number(x)));
        const blanks = vals.map((x, k) => (x === null ? k : -1)).filter((k) => k >= 0);
        const names = ['Vertices V', 'Edges E', 'Faces F'];

        if (blanks.length > 1 || vals.some((x) => x !== null && !(Number.isInteger(x) && x >= 0))) {
            return need('Enter whole numbers for two (or all three) of V, E and F.');
        }

        const [V, E, F] = vals;

        if (blanks.length === 1) {
            const k = blanks[0];
            const value = k === 0 ? 2 + E - F : k === 1 ? V + F - 2 : 2 + E - V;

            if (value <= 0) {
                return fail('No convex polyhedron has these counts: the missing value would be zero or negative.');
            }

            const filled = vals.map((x, n) => (n === k ? value : x));
            const plausible = filled[1] >= 6 && 2 * filled[1] >= 3 * filled[2] && 2 * filled[1] >= 3 * filled[0];

            return result(String(value), names[k], { sub: 'V − E + F = 2', rows: { check: `${filled[0]} − ${filled[1]} + ${filled[2]} = ${filled[0] - filled[1] + filled[2]}`, bounds: plausible ? 'Also satisfies E ≥ 6, 2E ≥ 3F and 2E ≥ 3V, needed for a real polyhedron' : 'Fails E ≥ 6, 2E ≥ 3F or 2E ≥ 3V, so no real polyhedron has these counts', genus: 'For a solid with g holes (a torus has 1): V − E + F = 2 − 2g' }, steps: ['Euler\'s formula for convex polyhedra: V − E + F = 2', `${names[k]} = ${k === 0 ? `2 + ${E} − ${F}` : k === 1 ? `${V} + ${F} − 2` : `2 + ${E} − ${V}`} = ${value}`] });
        }

        const chi = V - E + F;

        return result(String(chi), 'V − E + F (Euler characteristic)', { sub: chi === 2 ? 'Consistent with a convex polyhedron' : `Not 2: a solid with ${(2 - chi) / 2} hole${(2 - chi) / 2 === 1 ? '' : 's'}, or the counts are wrong`, rows: { check: `${V} − ${E} + ${F} = ${chi}`, bounds: E >= 6 && 2 * E >= 3 * F && 2 * E >= 3 * V ? 'E ≥ 6, 2E ≥ 3F and 2E ≥ 3V hold' : 'Fails E ≥ 6, 2E ≥ 3F or 2E ≥ 3V', genus: `Genus g = (2 − χ) ÷ 2 = ${f((2 - chi) / 2)}` }, steps: [`χ = V − E + F = ${V} − ${E} + ${F} = ${chi}`] });
    },

    great_circle: (i) => {
        const [lat1, lon1, lat2, lon2] = [i.lat1, i.lon1, i.lat2, i.lon2].map(Number);
        const R0 = Number(i.radius);
        const u = i.unit ?? 'km';

        if (![lat1, lon1, lat2, lon2].every(Number.isFinite) || !(R0 > 0)) {
            return need('Enter both points in decimal degrees and the sphere radius.');
        }

        if (abs(lat1) > 90 || abs(lat2) > 90) {
            return fail('Latitude runs from −90° to 90°.');
        }

        const [p1, p2] = [lat1 * D, lat2 * D];
        const dl = (lon2 - lon1) * D;
        // Vincenty's formula for the central angle (accurate for all distances, including antipodes).
        const y = hypot(cos(p2) * sin(dl), cos(p1) * sin(p2) - sin(p1) * cos(p2) * cos(dl));
        const x = sin(p1) * sin(p2) + cos(p1) * cos(p2) * cos(dl);
        const sigma = atan2(y, x);
        const dist = R0 * sigma;
        const bearing = ((atan2(sin(dl) * cos(p2), cos(p1) * sin(p2) - sin(p1) * cos(p2) * cos(dl)) / D) + 360) % 360;
        const back = ((atan2(-sin(dl) * cos(p1), cos(p2) * sin(p1) - sin(p2) * cos(p1) * cos(dl)) / D) + 360) % 360;
        const Bx = cos(p2) * cos(dl);
        const By = cos(p2) * sin(dl);
        const midLat = atan2(sin(p1) + sin(p2), hypot(cos(p1) + Bx, By)) / D;
        const midLon = (((lon1 * D + atan2(By, cos(p1) + Bx)) / D + 540) % 360) - 180;
        const unitText = u === 'units' ? '' : ` ${u}`;
        const pts = Array.from({ length: 41 }, (_, n) => {
            const t = n / 40;
            const A = sin((1 - t) * sigma) / sin(sigma || 1e-12);
            const B = sin(t * sigma) / sin(sigma || 1e-12);
            const X = A * cos(p1) * cos(lon1 * D) + B * cos(p2) * cos(lon2 * D);
            const Y = A * cos(p1) * sin(lon1 * D) + B * cos(p2) * sin(lon2 * D);
            const Z = A * sin(p1) + B * sin(p2);

            return [atan2(Y, X) / D, atan2(Z, hypot(X, Y)) / D];
        });

        return result(f(dist, 10), 'Great-circle distance', { unit: unitText.trim(), sub: `Central angle ${f(sigma / D, 10)}°`, rows: { angle: `${f(sigma / D, 12)}° = ${f(sigma, 12)} rad`, bearing: `${f(bearing, 8)}° (from north, clockwise)`, back: `${f(back, 8)}° at the destination, looking back`, midpoint: `${f(midLat, 8)}°, ${f(midLon, 8)}°`, sphere: `On a sphere of radius ${f(R0)}${unitText}; the Earth is slightly flattened, so real distances differ by up to about 0.5%` }, steps: ['Central angle σ = atan2(√((cos φ₂ sin Δλ)² + (cos φ₁ sin φ₂ − sin φ₁ cos φ₂ cos Δλ)²), sin φ₁ sin φ₂ + cos φ₁ cos φ₂ cos Δλ)', `σ = ${f(sigma, 12)} rad`, `Distance = Rσ = ${f(R0)} × ${f(sigma, 12)} = ${f(dist, 12)}${unitText}`, `Initial bearing θ = atan2(sin Δλ cos φ₂, cos φ₁ sin φ₂ − sin φ₁ cos φ₂ cos Δλ) = ${f(bearing, 10)}°`], plots: { route: { series: pts.map(([lon, lat]) => [lon, lat]), scatter: [[lon1, lat1], [lon2, lat2]], xLabel: 'Longitude (°)', yLabel: 'Latitude (°)' } } });
    },

    platonic: (i, c) => {
        const solid = PLATONIC[c.solid ?? i.solid];
        const a = Number(i.a);
        const u = i.unit ?? 'cm';

        if (!solid) {
            return need('Choose a solid.');
        }

        if (!(a > 0)) {
            return need('Enter the edge length.');
        }

        const V = solid.vol * a ** 3;
        const A = solid.area * a * a;
        const want = c.want ?? 'vol';
        const rows = { counts: `${solid.F} faces (${solid.face}), ${solid.E} edges, ${solid.V} vertices; V − E + F = ${solid.V - solid.E + solid.F}`, vol: measure(V, 3, u), surf: measure(A, 2, u), circr: measure(solid.R * a, 1, u), insr: measure(solid.r * a, 1, u), dihedral: `${f(solid.dihedral / D, 12)}°`, volumes: volumeConversions(V, u), areas: areaConversions(A, u) };
        const main = want === 'surf' ? measure(A, 2, u) : measure(V, 3, u);
        const m = main.match(/^(\S+)\s*(.*)$/);

        return result(m[1], `${solid.name} ${want === 'surf' ? 'surface area' : 'volume'}`, { unit: m[2], sub: rows.counts, rows, steps: [`Volume = ${f(solid.vol, 12)} × a³ = ${measure(V, 3, u)}`, `Surface area = ${f(solid.area, 12)} × a² = ${measure(A, 2, u)}`, `Circumradius = ${f(solid.R, 12)} × a, inradius = ${f(solid.r, 12)} × a`, `Dihedral angle ${f(solid.dihedral / D, 12)}°`] });
    },

    tetra: (i) => {
        const u = i.unit ?? 'cm';
        const mode = i.given ?? 'vertices';

        if (mode === 'base') {
            const [a, b, cc, h] = [i.a, i.b, i.c, i.h].map(Number);

            if (![a, b, cc, h].every((x) => x > 0)) {
                return need('Enter the three base sides and the height.');
            }

            const s = (a + b + cc) / 2;
            const q = s * (s - a) * (s - b) * (s - cc);

            if (!(q > 0)) {
                return fail('The base sides do not form a triangle.');
            }

            const base = sqrt(q);
            const V = (base * h) / 3;
            const m = measure(V, 3, u).match(/^(\S+)\s*(.*)$/);

            return result(m[1], 'Volume', { unit: m[2], sub: `Base ${measure(base, 2, u)} × height ÷ 3`, rows: { base: measure(base, 2, u), vol: measure(V, 3, u), volumes: volumeConversions(V, u), faces: 'The side faces depend on where the apex sits; enter vertices for the full surface area' }, steps: [`Heron: base area = √(s(s − a)(s − b)(s − c)) = ${measure(base, 2, u)}`, `V = base × h ÷ 3 = ${measure(V, 3, u)}`] });
        }

        const P = [[i.x1, i.y1, i.z1], [i.x2, i.y2, i.z2], [i.x3, i.y3, i.z3], [i.x4, i.y4, i.z4]].map((p) => p.map(Number));

        if (P.flat().some((x) => !Number.isFinite(x))) {
            return need('Enter the coordinates of the four vertices.');
        }

        const sub = (p, q) => [p[0] - q[0], p[1] - q[1], p[2] - q[2]];
        const cross = (p, q) => [p[1] * q[2] - p[2] * q[1], p[2] * q[0] - p[0] * q[2], p[0] * q[1] - p[1] * q[0]];
        const dot = (p, q) => p[0] * q[0] + p[1] * q[1] + p[2] * q[2];
        const [A, B, C, Dv] = P;
        const triple = dot(sub(B, A), cross(sub(C, A), sub(Dv, A)));
        const V = abs(triple) / 6;

        if (V < 1e-14) {
            return fail('The four points lie in one plane, so the volume is 0.');
        }

        const faces = [[A, B, C], [A, B, Dv], [A, C, Dv], [B, C, Dv]].map(([p, q, r]) => hypot(...cross(sub(q, p), sub(r, p))) / 2);
        const S = faces.reduce((s, x) => s + x, 0);
        const hD = (3 * V) / faces[0];
        const m = measure(V, 3, u).match(/^(\S+)\s*(.*)$/);

        return result(m[1], 'Volume', { unit: m[2], sub: `|AB · (AC × AD)| ÷ 6`, rows: { base: `Faces ${faces.map((x) => f(x, 8)).join(', ')}`, vol: measure(V, 3, u), volumes: volumeConversions(V, u), faces: `Total surface ${measure(S, 2, u)}; height from D to ABC ${measure(hD, 1, u)}` }, steps: [`Scalar triple product AB · (AC × AD) = ${f(triple, 12)}`, `V = |${f(triple, 12)}| ÷ 6 = ${f(V, 12)}`, `Face areas from ½|cross products|: ${faces.map((x) => f(x, 10)).join(', ')}`] });
    },
};

export default defineTools(handlers);
