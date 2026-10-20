import assert from 'node:assert/strict';
import test from 'node:test';
import * as B from '../math/bits.js';
import * as L from '../math/linalg.js';
import * as N from '../math/numtheory.js';
import * as P from '../math/poly.js';
import { practice } from '../math/practice.js';
import * as R from '../math/rational.js';
import { ellipsePerimeter, ellipsoidArea, SHAPES } from '../math/shapes.js';
import { besselJ, erf, gamma } from '../math/special.js';
import { solve as solveTriangle } from '../math/triangle.js';
import { handlers as algebra } from '../tools/mt-algebra.js';
import { handlers as bits } from '../tools/mt-bits.js';
import { handlers as coord, surd } from '../tools/mt-coord.js';
import { handlers as frac } from '../tools/mt-frac.js';
import { handlers as matrix } from '../tools/mt-matrix.js';
import { handlers as number } from '../tools/mt-number.js';
import { handlers as other } from '../tools/mt-other.js';
import { handlers as percent } from '../tools/mt-percent.js';
import { handlers as seq } from '../tools/mt-seq.js';
import { handlers as shape } from '../tools/mt-shape.js';
import { handlers as solid } from '../tools/mt-solid.js';
import { handlers as tri } from '../tools/mt-tri.js';
import { exactTrig, trigValue, handlers as trig } from '../tools/mt-trig.js';
import { evalReal, parse } from '../math/expr.js';

const close = (actual, expected, tolerance) => assert.ok(Math.abs(Number(actual) - expected) <= tolerance, `${actual} ≠ ${expected}`);
const num = (text) => Number(String(text).replace(/,/g, '').replace(/[^0-9.eE+−-]/g, '').replace('−', '-'));

test('exact rationals: fractions, repeating decimals and rounding', () => {
    assert.equal(R.toFraction(R.add(R.Q(1, 3n), R.Q(1, 6n))), '1/2');
    assert.equal(R.toFraction(R.parseNumber('0.1(6)')), '1/6');
    assert.equal(R.toRepeating(R.Q(1, 7n)), '0.(142857)');
    assert.equal(frac.binary({ a: '3/4', b: '5/6' }, { op: '+' }).value, '19/12');
    assert.equal(percent.percentage({ mode: 'of', a: '15', b: '80' }, {}).value, '12');
});

test('number theory: primes, factors, modular arithmetic and big factorials', () => {
    assert.equal(N.isPrime(2n ** 61n - 1n), true);
    assert.equal(N.factorString(N.factorize(600851475143n)), '71 × 839 × 1471 × 6857');
    assert.equal(N.modInverse(17n, 3120n), 2753n);
    assert.equal(N.factorial(25n), 15511210043330985984000000n);
    assert.equal(number.gcf({ numbers: '84, 126' }, { want: 'gcf' }).value, '42');
});

test('polynomials: exact quadratic roots, rational roots and partial fractions', () => {
    assert.deepEqual(P.quadraticRoots(R.Q(1), R.Q(-2), R.Q(-1)).exact, ['1 − √2', '1 + √2']);
    assert.equal(algebra.quadratic({ a: '2', b: '4', c: '5' }, {}).value, '−1 − (√6/2)i,  −1 + (√6/2)i');
    assert.equal(algebra.factor({ p1: '6x^2 + 11x - 10' }, {}).value, '(3x − 2)(2x + 5)');
    assert.equal(algebra.partial_fractions({ num: '1', den: '(x-1)^2 (x+2)' }, {}).value, '−1/(9(x − 1)) + 1/(3(x − 1)²) + 1/(9(x + 2))');
    assert.equal(algebra.system({ eqs: 'x + y + z = 6\n2x - y + z = 3\nx + 2y - z = 2' }, {}).value, 'x = 1,  y = 2,  z = 3');
});

test('special functions match reference values', () => {
    close(gamma(0.5), Math.sqrt(Math.PI), 1e-14);
    close(erf(1), 0.8427007929497149, 1e-15);
    close(besselJ(1, 2.5), 0.4970941024642741, 1e-12);
});

test('sequences and series', () => {
    assert.equal(seq.fibonacci({ n: '50' }).value, '12,586,269,025');
    close(num(seq.series({ term: '(-1)^(n+1)/n', start: 1, end: 'inf' }).value), Math.log(2), 1e-9);
    assert.equal(seq.series({ term: '1/n', start: 1, end: 'inf' }).value, 'Diverges');
});

test('shape solvers round-trip from every accepted set of known values', () => {
    const fixed = { n: 7, part: 'half', kind: '30' };
    const seed = { a: 3.7, b: 2.2, c: 2.9, l: 5.1, w: 2.3, h: 4.4, r: 1.9, R: 3.1, theta: 75, leg: 4, base: 5, outer: 5, inner: 2.1, major: 4, minor: 1.2, len: 6.5, legL: 4.6, legR: 5, long: 4, short: 2 };

    for (const [name, sh] of Object.entries(SHAPES)) {
        const first = Object.keys(sh.cases)[0];
        const start = { ...fixed, ...Object.fromEntries(first.split('_').map((k) => [k, seed[k]])) };

        if (name === 'trapPrism') {
            Object.assign(start, { a: 6, b: 3 });
        }

        if (name === 'cap') {
            start.r = 5;
        }

        const base = sh.all(sh.cases[first](start), fixed);

        for (const [key, solver] of Object.entries(sh.cases)) {
            const values = { ...fixed, ...Object.fromEntries(key.split('_').map((k) => [k, base[k]])) };
            const again = sh.all(solver(values), fixed);

            for (const v of Object.keys(sh.vars)) {
                if (key === 'a_baseH_len' || key === 'a_b_h_len') {
                    continue;
                }

                close(again[v], base[v], 1e-9 * Math.max(1, Math.abs(base[v])));
            }
        }
    }
});

test('ellipse perimeter, ellipsoid area and solid formulas', () => {
    close(ellipsePerimeter(5, 3), 25.526998863398127, 1e-12);
    close(ellipsoidArea(3, 2, 1), 48.88214630258206, 1e-9);
    assert.equal(shape.shape({ given: 'r_h', r: 3, h: 10, unit: 'cm' }, { shape: 'cylinder', want: 'vol' }).value, '282.7433388');
    assert.equal(shape.shape({ given: 'd_h', d: 2, h: 10, unit: 'ft' }, { shape: 'cylinder', want: 'vol', volumeIn: 'yd3' }).unit, 'yd³');
    close(num(solid.platonic({ solid: 'dodecahedron', a: 1, unit: 'cm' }, {}).value), 7.663118960624632, 1e-8);
    close(num(solid.great_circle({ lat1: 51.5074, lon1: -0.1278, lat2: 40.7128, lon2: -74.006, radius: 6371, unit: 'km' }).value), 5570.2, 0.1);
});

test('triangles: law of cosines and the ambiguous SSA case', () => {
    const sss = solveTriangle('sss', { a: 5, b: 6, c: 7 }).triangles[0];
    close(sss.area, Math.sqrt(216), 1e-12);
    close(sss.circr, 35 / (4 * Math.sqrt(6)), 1e-12);
    assert.equal(solveTriangle('ssa', { a: 6, b: 8, A: 35 }).triangles.length, 2);
    assert.equal(solveTriangle('ssa', { a: 9, b: 8, A: 35 }).triangles.length, 1);
    assert.ok(solveTriangle('ssa', { a: 3, b: 8, A: 35 }).error);
    assert.equal(tri.triangle({ given: 'coords', x1: 0, y1: 0, x2: 4, y2: 0, x3: 1, y3: 3, unit: 'units' }, { want: 'orthocenter' }).value, '(1, 1)');
    assert.equal(tri.sides_check({ a: '0.3', b: '0.4', c: '0.5' }, { mode: 'right' }).value, 'Yes, a right triangle');
    assert.equal(tri.clock({ time: '3:40' }).value, '130');
});

test('exact trig values agree with the computed values at every multiple of 1.5°', () => {
    for (let d = -360; d <= 360; d += 1.5) {
        for (const fn of ['sin', 'cos', 'tan', 'csc', 'sec', 'cot']) {
            const e = exactTrig(fn, d);

            if (e && e !== 'undefined') {
                close(evalReal(parse(e)), trigValue(fn, d), 1e-12);
            }
        }
    }

    assert.equal(trig.trig_fn({ angle: 75, angle_unit: 'deg' }, { fn: 'sin' }).value, '(√6 + √2)/4');
    assert.equal(trig.inverse({ x: '-1/2' }, { fn: 'acos' }).value, '120° = 2π/3');
    assert.equal(trig.identity({ identity: 'sin(2x) = 2sin(x)' }).value, 'Not an identity');
    assert.equal(trig.identity({ identity: 'cos(a - b) = cos(a)cos(b) + sin(a)sin(b)' }).value, 'Identity holds');
});

test('coordinate geometry stays exact', () => {
    assert.equal(surd(R.Q(18)), '3√2');
    assert.equal(coord.distance({ x1: '1', y1: '1', x2: '3', y2: '4' }, {}).value, '√13');
    assert.equal(coord.point_line({ eq: '3x + 4y = 10', px: '5', py: '5' }).value, '5');
    assert.equal(coord.parallel_perp({ eq: 'y = 2x + 1', px: '3', py: '4' }, { kind: 'perpendicular' }).value, 'y = −(1/2)x + 11/2');
    assert.equal(coord.plane({ p1: '1,0,0', p2: '0,2,0', p3: '0,0,3' }, {}).value, '6x + 3y + 2z = 6');
    assert.equal(coord.sphere_eq({ given: 'general', eq: 'x^2 + y^2 + z^2 - 2x + 4y - 6z = 2' }, {}).value, '(x − 1)² + (y + 2)² + (z − 3)² = 16');
    assert.equal(shape.conic({ eq: 'x^2/9 - y^2/16 = 1' }, {}).value, 'Hyperbola');
});

test('linear algebra: exact inverse, null space, LU and Cramer', () => {
    const A = L.parseMatrix('2 1 1\n1 3 2\n1 0 0').m;
    assert.equal(R.toFraction(L.det(A)), '−1');
    assert.deepEqual(L.inverse(A).map((row) => row.map(R.toFraction)), [['0', '0', '1'], ['−2', '1', '3'], ['3', '−1', '−5']]);
    assert.equal(matrix.matrix({ a: '1 2 3\n2 4 6\n1 1 1' }, { op: 'null' }).value, '(1, −2, 1)');
    assert.equal(matrix.matrix({ a: '2 1 -1\n-3 -1 2\n-2 1 2', b: '8 -11 -3' }, { op: 'cramer' }).value, 'x1 = 2, x2 = 3, x3 = −1');
    assert.equal(matrix.matrix({ a: '1 1\n0 1' }, { op: 'diagonalize' }).value, 'No (defective: too few eigenvectors)');
    assert.equal(matrix.corner({ constraints: 'x + y <= 4\nx + 3y <= 6', objective: '3x + 2y', goal: 'max', nonneg: 'yes' }).value, 'Maximum 12 at (4, 0)');
});

test('binary: logic, arithmetic, repeating binary fractions and IEEE 754', () => {
    assert.equal(bits.logic({ a: '1100', b: '1010', base: 'bin', bits: 8 }, { op: 'and' }).value, '0000 1000');
    assert.equal(bits.arith({ a: '110101', b: '101', base: 'bin' }, { op: 'div' }).value, '1010 r 11');
    assert.equal(bits.fraction({ dir: 'to', dec: '0.1' }).value, '0.0(0011)');
    assert.equal(B.hex(B.ieee754(0.1, 32).pattern, 32), '3DCCCCCD');
    assert.equal(B.hex(B.ieee754(65504, 16).pattern, 16), '7BFF');
    assert.equal(B.hex(B.ieee754(1 / 3, 16).pattern, 16), '3555');
    assert.equal(bits.complement({ a: '-5', base: 'dec', bits: 8 }, { kind: 'twos' }).value, '1111 1011');
});

test('other: RSA, Luhn, ISBN, queues, LFSR and number systems', () => {
    assert.equal(other.rsa({ p: '61', q: '53', e: '17', m: '65' }).value, 'c = 2,790');
    assert.equal(other.luhn({ number: '4539 1488 0343 6467' }, {}).value, 'Valid');
    assert.equal(other.isbn({ isbn: '0-306-40615' }).value, '0306406152');
    close(parseFloat(other.queue({ lambda: 10, mu: 4, servers: 3 }).rows.pwait), 70.224719, 1e-5);
    assert.equal(other.lfsr({ bits: 16, taps: '16,14,13,11', seed: '0xACE1', steps: 8, type: 'fibonacci' }).rows.period, '65,535');
    assert.equal(other.babylonian({ dir: 'from', sexa: '1;24,51,10' }).sub, '= 30547/21600 exactly');
    assert.equal(other.mayan({ n: '2024' }).rows.digits, '5, 1, 4');
    assert.equal(other.potato({ m1: 100, w1: 99, w2: 98 }).value, '50');
});

test('practice questions are reproducible and checked', () => {
    const first = practice('rectangle', { question: 1, answer: '' });
    assert.equal(practice('rectangle', { question: 1, answer: '' }).label, first.label);
    assert.equal(practice('trig', { question: 1, answer: '-1' }).value, 'Correct ✓');
    assert.equal(practice('trig', { question: 1, answer: '1' }).value, 'Not quite');
});
