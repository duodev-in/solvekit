import { defineTools } from '../engines/formula.js';
import { compile, evalExact, parse, ParseError } from '../math/expr.js';
import * as N from '../math/numtheory.js';
import { toText as polyText } from '../math/poly.js';
import { dec, f, fail, need, q, R, result } from '../math/util.js';

/**
 * Sequences and series: arithmetic and geometric sequences solved for any unknown, Fibonacci (BigInt,
 * fast doubling), Catalan and harmonic numbers, Pascal's triangle, Collatz, convolution, pattern detection,
 * finite and infinite sums with convergence tests, and the Lagrange error bound.
 */
const t = R.toFraction;
const big = (v) => N.parseBig(v);

function fib(n) {
    // Fast doubling: returns [F(n), F(n + 1)].
    if (n === 0n) {
        return [0n, 1n];
    }

    const [a, b] = fib(n / 2n);
    const c = a * (2n * b - a);
    const d = a * a + b * b;

    return n % 2n === 0n ? [c, d] : [d, c + d];
}

function list(text) {
    const items = String(text ?? '').split(/[\s,;]+/).filter(Boolean).map((s) => R.parseNumber(s));

    return items.length && items.every(Boolean) ? items : null;
}

const short = (s) => (s.length > 60 ? `${s.slice(0, 25)}…${s.slice(-10)} (${s.replace(/\D/g, '').length} digits)` : s);

export const handlers = {
    arithmetic: (i) => {
        const a1 = q(i.a1);
        const d = q(i.d);
        const n = big(i.n);

        if (!a1 || !d || n === null || n < 1n) {
            return need('Enter the first term, the common difference and n (1 or more).');
        }

        const an = R.add(a1, R.mul(d, R.Q(n - 1n)));
        const sn = R.mul(R.Q(n, 2n), R.add(a1, an));
        const terms = Array.from({ length: Number(n > 10n ? 10n : n) }, (_, k) => dec(R.add(a1, R.mul(d, R.Q(k)))));

        return result(dec(an), `Term a${R.subscript(n)}`, { sub: `Sum of the first ${n} terms: ${dec(sn)}`, rows: { sum: dec(sn), terms: `${terms.join(', ')}${n > 10n ? ', …' : ''}`, formula: `aₙ = ${t(a1)} + (n − 1)(${t(d)})` }, steps: [`aₙ = a₁ + (n − 1)d = ${t(a1)} + ${n - 1n} × ${t(d)} = ${t(an)}`, `Sₙ = n(a₁ + aₙ)/2 = ${n}(${t(a1)} + ${t(an)})/2 = ${t(sn)}`] });
    },

    geometric: (i) => {
        const a1 = q(i.a1);
        const r = q(i.r);
        const n = big(i.n);

        if (!a1 || !r || n === null || n < 1n || n > 5000n) {
            return need('Enter the first term, the common ratio and n (1 to 5,000).');
        }

        const an = R.mul(a1, R.pow(r, n - 1n));
        const sn = R.eq(r, R.ONE) ? R.mul(a1, R.Q(n)) : R.div(R.mul(a1, R.sub(R.ONE, R.pow(r, n))), R.sub(R.ONE, r));
        const infinite = R.cmp(R.qabs(r), R.ONE) < 0 ? R.div(a1, R.sub(R.ONE, r)) : null;
        const terms = Array.from({ length: Number(n > 8n ? 8n : n) }, (_, k) => dec(R.mul(a1, R.pow(r, k))));

        return result(short(dec(an)), `Term a${R.subscript(n)}`, { sub: `Sum of the first ${n} terms: ${short(dec(sn))}`, rows: { sum: short(dec(sn)), infinite: infinite ? `${t(infinite)} (|r| < 1)` : 'Diverges (|r| ≥ 1)', terms: `${terms.join(', ')}${n > 8n ? ', …' : ''}`, formula: `aₙ = ${t(a1)} × (${t(r)})ⁿ⁻¹` }, steps: [`aₙ = a₁rⁿ⁻¹ = ${t(a1)} × (${t(r)})${R.sup(n - 1n)}`, R.eq(r, R.ONE) ? `Sₙ = n × a₁` : `Sₙ = a₁(1 − rⁿ)/(1 − r)`, infinite ? `S∞ = a₁/(1 − r) = ${t(infinite)}` : 'No infinite sum: |r| ≥ 1'] });
    },

    fibonacci: (i) => {
        const n = big(i.n);

        if (n === null || n < 0n || n > 100000n) {
            return need('Enter n from 0 to 100,000.');
        }

        const [fn, fn1] = fib(n);
        const s = fn.toString();
        const first = Array.from({ length: 15 }, (_, k) => fib(BigInt(k))[0]).join(', ');

        return result(short(R.fmt(fn)), `F${R.subscript(n)}`, { sub: `${s.length} digit${s.length === 1 ? '' : 's'}`, rows: { next: short(fn1.toString()), ratio: n > 1n ? `${f(Number(fn1) / Number(fn) || 1.618033988749895, 15)} → φ` : 'Needs n > 1', first, sum: `F₀ + … + F${R.subscript(n)} = F${R.subscript(n + 2n)} − 1` }, steps: ['F₀ = 0, F₁ = 1, Fₙ = Fₙ₋₁ + Fₙ₋₂', 'Computed by fast doubling: F₂ₖ = Fₖ(2Fₖ₊₁ − Fₖ), F₂ₖ₊₁ = Fₖ² + Fₖ₊₁²'] });
    },

    catalan: (i) => {
        const n = big(i.n);

        if (n === null || n < 0n || n > 5000n) {
            return need('Enter n from 0 to 5,000.');
        }

        const c = N.binomial(2n * n, n) / (n + 1n);

        return result(short(R.fmt(c)), `C${R.subscript(n)}`, { sub: `C(2n, n)/(n + 1)`, rows: { first: Array.from({ length: 12 }, (_, k) => N.binomial(2n * BigInt(k), BigInt(k)) / BigInt(k + 1)).join(', '), counts: `Ways to bracket ${n + 1n} factors, triangulate a ${n + 2n}-gon, or arrange ${n} pairs of parentheses` }, steps: [`Cₙ = (2n)! ÷ ((n + 1)! n!) = C(${2n * n}, ${n}) ÷ ${n + 1n}`] });
    },

    harmonic: (i) => {
        const n = big(i.n);

        if (n === null || n < 1n || n > 10n ** 12n) {
            return need('Enter n from 1 to 10¹².');
        }

        if (n <= 2000n) {
            let h = R.ZERO;

            for (let k = 1n; k <= n; k += 1n) {
                h = R.add(h, R.Q(1n, k));
            }

            const s = t(h);

            return result(f(R.toNumber(h), 15), `H${R.subscript(n)}`, { sub: s.length < 60 ? `= ${s}` : 'Exact fraction too long to show', rows: { exact: s.length < 80 ? s : `${s.length} characters`, approx: f(Math.log(Number(n)) + 0.5772156649015329 + 1 / (2 * Number(n)) - 1 / (12 * Number(n) ** 2), 15) }, steps: [`Hₙ = 1 + 1/2 + … + 1/${n}`, `≈ ln n + γ + 1/(2n) − 1/(12n²)`] });
        }

        const x = Number(n);
        const v = Math.log(x) + 0.5772156649015329 + 1 / (2 * x) - 1 / (12 * x * x) + 1 / (120 * x ** 4);

        return result(f(v, 15), `H${R.subscript(n)}`, { sub: 'Asymptotic expansion (error below 10⁻¹⁵)', rows: { exact: 'Too large to sum exactly', approx: f(v, 15) }, steps: ['Hₙ ≈ ln n + γ + 1/(2n) − 1/(12n²) + 1/(120n⁴)'] });
    },

    pascal: (i) => {
        const rows = Math.round(Number(i.rows));

        if (!(rows >= 1 && rows <= 30)) {
            return need('Enter 1 to 30 rows.');
        }

        const tri = Array.from({ length: rows }, (_, n) => Array.from({ length: n + 1 }, (__, k) => N.binomial(n, k)));
        const width = tri[rows - 1].map(String).join(' ').length;

        return result(tri[rows - 1].join(' '), `Row ${rows - 1}`, { sub: `Sum of row ${rows - 1} = 2${R.sup(rows - 1)} = ${2n ** BigInt(rows - 1)}`, rows: { sum: (2n ** BigInt(rows - 1)).toString(), middle: N.binomial(rows - 1, Math.floor((rows - 1) / 2)).toString() }, steps: tri.map((r) => r.join(' ').padStart(Math.floor((width + r.join(' ').length) / 2))) });
    },

    collatz: (i) => {
        const n = big(i.n);

        if (n === null || n < 1n) {
            return need('Enter a positive whole number.');
        }

        let x = n;
        let steps = 0;
        let peak = n;
        const seq = [n];

        while (x !== 1n && steps < 100000) {
            x = x % 2n === 0n ? x / 2n : 3n * x + 1n;
            steps += 1;
            peak = x > peak ? x : peak;

            if (seq.length < 400) {
                seq.push(x);
            }
        }

        return result(`${steps} steps`, `Collatz sequence from ${R.fmt(n)}`, { sub: `Highest value ${R.fmt(peak)}`, rows: { peak: R.fmt(peak), sequence: `${seq.slice(0, 20).join(' → ')}${seq.length > 20 ? ' → …' : ''}` }, steps: [`Even: halve. Odd: 3n + 1.`, seq.slice(0, 60).join(' → ')], plots: { graph: { series: seq.map((v, k) => [k, Number(v)]), xLabel: 'Step', yLabel: 'Value' } } });
    },

    convolution: (i) => {
        const a = list(i.a);
        const b = list(i.b);

        if (!a || !b) {
            return need('Enter two sequences of numbers.');
        }

        const out = Array.from({ length: a.length + b.length - 1 }, (_, n) => a.reduce((acc, x, k) => (n - k >= 0 && n - k < b.length ? R.add(acc, R.mul(x, b[n - k])) : acc), R.ZERO));

        return result(out.map((v) => dec(v)).join(', '), 'a * b', { sub: `${out.length} terms`, rows: { length: `${a.length} + ${b.length} − 1 = ${out.length}`, sum: `${dec(out.reduce((x, y) => R.add(x, y), R.ZERO))} (= sum of a × sum of b)` }, steps: out.map((v, n) => `(a * b)[${n}] = ${a.map((x, k) => (n - k >= 0 && n - k < b.length ? `${dec(x)}×${dec(b[n - k])}` : null)).filter(Boolean).join(' + ')} = ${dec(v)}`) });
    },

    detect: (i) => {
        const s = list(i.terms);

        if (!s || s.length < 3) {
            return need('Enter at least three terms.');
        }

        const diffs = (arr) => arr.slice(1).map((x, k) => R.sub(x, arr[k]));
        const allEq = (arr) => arr.every((x) => R.eq(x, arr[0]));
        const d1 = diffs(s);
        const more = Math.max(1, Math.round(Number(i.more ?? 5)));
        let kind;
        let next = [];
        let formula;

        if (allEq(d1)) {
            kind = 'Arithmetic';
            formula = `aₙ = ${t(s[0])} + (n − 1)(${t(d1[0])})`;
            next = Array.from({ length: more }, (_, k) => R.add(s[s.length - 1], R.mul(d1[0], R.Q(k + 1))));
        } else if (s.every((x) => !R.isZero(x)) && allEq(s.slice(1).map((x, k) => R.div(x, s[k])))) {
            const r = R.div(s[1], s[0]);
            kind = 'Geometric';
            formula = `aₙ = ${t(s[0])} × (${t(r)})ⁿ⁻¹`;
            next = Array.from({ length: more }, (_, k) => R.mul(s[s.length - 1], R.pow(r, k + 1)));
        } else if (s.length >= 4 && allEq(diffs(d1))) {
            const d2 = diffs(d1)[0];
            kind = 'Quadratic (second differences constant)';
            const a = R.div(d2, R.Q(2));
            const b = R.sub(d1[0], R.mul(a, R.Q(3)));
            const c = R.sub(s[0], R.add(a, b));
            formula = `aₙ = ${polyText([c, b, a], 'n')}`;
            next = Array.from({ length: more }, (_, k) => {
                const n = R.Q(s.length + k + 1);

                return R.add(R.add(R.mul(a, R.mul(n, n)), R.mul(b, n)), c);
            });
        } else if (s.slice(2).every((x, k) => R.eq(x, R.add(s[k], s[k + 1])))) {
            kind = 'Fibonacci-type (each term is the sum of the two before)';
            formula = 'aₙ = aₙ₋₁ + aₙ₋₂';
            const arr = [...s];

            for (let k = 0; k < more; k += 1) {
                arr.push(R.add(arr[arr.length - 1], arr[arr.length - 2]));
            }

            next = arr.slice(s.length);
        } else {
            return result('No simple pattern found', 'Sequence type', { sub: 'Not arithmetic, geometric, quadratic or Fibonacci-type', rows: { formula: 'Unknown', next: 'Unknown', differences: d1.map((v) => dec(v)).join(', ') }, steps: [`First differences: ${d1.map((v) => dec(v)).join(', ')}`, `Second differences: ${diffs(d1).map((v) => dec(v)).join(', ')}`] });
        }

        return result(next.map((v) => dec(v)).join(', '), `Next ${more} terms`, { sub: kind, rows: { formula, next: next.map((v) => dec(v)).join(', '), differences: d1.map((v) => dec(v)).join(', ') }, steps: [`First differences: ${d1.map((v) => dec(v)).join(', ')}`, `${kind}: ${formula}`] });
    },

    linear_sum: (i) => {
        const a = q(i.first);
        const l = q(i.last);
        const n = big(i.count);

        if (!a || !l || n === null || n < 1n) {
            return need('Enter the first term, the last term and the number of terms.');
        }

        const s = R.mul(R.Q(n, 2n), R.add(a, l));
        const d = n > 1n ? R.div(R.sub(l, a), R.Q(n - 1n)) : R.ZERO;

        return result(dec(s), `Sum of ${n} terms`, { sub: `${n} × (${dec(a)} + ${dec(l)}) ÷ 2`, rows: { d: dec(d), mean: dec(R.div(R.add(a, l), R.Q(2))) }, steps: ['Gauss: pair the first and last terms; each pair has the same sum', `S = n(a₁ + aₙ)/2 = ${n}(${dec(a)} + ${dec(l)})/2 = ${dec(s)}`] });
    },

    series: (i) => {
        const text = String(i.term ?? '').trim();
        const start = Math.round(Number(i.start ?? 1));
        const endText = String(i.end ?? '').trim().toLowerCase();
        const infinite = ['inf', 'infinity', '∞', ''].includes(endText);
        const end = infinite ? Infinity : Math.round(Number(endText));

        if (!text || !Number.isFinite(start) || (!infinite && !Number.isFinite(end)) || (!infinite && end < start)) {
            return need('Enter the term in n, the start and the end (or ∞).');
        }

        let tree;
        let g;

        try {
            tree = parse(text);
            g = compile(text, 'n');
        } catch (e) {
            return fail(e instanceof ParseError ? e.message : 'Could not read the term.');
        }

        if (!infinite) {
            if (end - start > 100000) {
                return fail('Finite sums up to 100,000 terms are added term by term.');
            }

            let exact = R.ZERO;
            let ok = true;
            let sum = 0;

            for (let n = start; n <= end; n += 1) {
                const e = ok ? evalExact(tree, { n: R.Q(n) }) : null;

                if (e) {
                    exact = R.add(exact, e);
                } else {
                    ok = false;
                }

                sum += g(n);
            }

            return result(ok ? dec(exact) : f(sum, 14), `Σ (n = ${start} to ${end}) ${text}`, { sub: ok && !R.isInt(exact) ? `= ${t(exact)}` : `${end - start + 1} terms`, rows: { terms: String(end - start + 1), test: 'Finite sum', partial: ok ? t(exact) : f(sum, 15) }, steps: [`${[start, start + 1, start + 2].filter((n) => n <= end).map((n) => f(g(n), 8)).join(' + ')}${end - start > 2 ? ' + …' : ''}`] });
        }

        // Infinite: partial sums with acceleration and simple tests.
        let s = 0;
        let last = 0;
        const partials = [];

        for (let n = start; n < start + 200000; n += 1) {
            last = g(n);
            s += last;

            if ((n - start + 1) % 20000 === 0) {
                partials.push(s);
            }
        }

        const l1 = Math.abs(g(1e6)) * 1e6;
        const l2 = Math.abs(g(2e6)) * 2e6;
        const ratios = [[50, 51], [100, 101]].map(([x, y]) => Math.abs(g(y) / g(x)));
        const ratio = ratios.every((r) => Number.isFinite(r) && r < 0.99) && Math.abs(ratios[0] - ratios[1]) < 0.02 ? ratios[1] : 1;
        const termLimit = Math.abs(g(1e8));
        let test;
        let converges;

        const alternating = [1000, 1001, 1002].every((n) => Math.sign(g(n)) === -Math.sign(g(n + 1)) && g(n) !== 0) && Math.abs(g(1001)) < Math.abs(g(1000));

        if (!(termLimit < 1e-6)) {
            test = 'Divergence test: the terms do not tend to 0';
            converges = false;
        } else if (alternating && !(ratio < 0.999)) {
            // Leibniz: the limit lies between consecutive partial sums; average them.
            const estimate = s - last / 2;

            return result(f(estimate, 10), `Σ (n = ${start} to ∞) ${text}`, { sub: 'Alternating series test: terms alternate in sign and shrink to 0, so the series converges', rows: { terms: '∞', test: 'Alternating series (Leibniz) test', partial: `S after 200,000 terms = ${f(s, 12)} (error below ${f(Math.abs(last), 3)})` }, steps: ['Signs alternate and |aₙ| decreases to 0', `Estimate: average of the last two partial sums = ${f(estimate, 12)}`] });
        } else if (ratio < 0.999) {
            test = `Ratio test: |aₙ₊₁/aₙ| → ${f(ratio, 6)} < 1, converges`;
            converges = true;
        } else if (Math.abs(l2 - l1) < 1e-3 * Math.max(l1, 1e-12) && l1 > 1e-9) {
            test = 'Limit comparison with Σ1/n: terms behave like c/n, so the series diverges';
            converges = false;
        } else {
            const p = Math.log(Math.abs(g(1e4)) / Math.abs(g(2e4))) / Math.log(2);

            if (!Number.isFinite(p)) {
                return result('Cannot tell', `Σ (n = ${start} to ∞) ${text}`, { sub: 'The automatic tests could not decide', rows: { terms: '∞', test: 'Inconclusive', partial: `S after 200,000 terms ≈ ${f(s, 10)}` }, steps: ['Ratio, divergence and p-series comparison tests were inconclusive'] });
            }

            converges = p > 1.0001;
            test = `Terms shrink like 1/n^${f(p, 4)}: ${converges ? 'p > 1, converges (p-series comparison)' : 'p ≤ 1, diverges'}`;
        }

        if (!converges) {
            return result('Diverges', `Σ (n = ${start} to ∞) ${text}`, { sub: test, rows: { terms: '∞', test, partial: `S after 200,000 terms ≈ ${f(s, 10)}` }, steps: [test] });
        }

        // Richardson-style tail estimate: integral of the tail for power-law terms.
        const N0 = start + 200000;
        const p = Math.log(Math.abs(g(N0)) / Math.abs(g(2 * N0))) / Math.log(2);
        const tail = ratio < 0.999 ? (last * ratio) / (1 - ratio) : Number.isFinite(p) && p > 1 ? (g(N0) * N0) / (p - 1) - g(N0) / 2 : 0;
        const total = s + tail;

        return result(f(total, 12), `Σ (n = ${start} to ∞) ${text}`, { sub: test, rows: { terms: '∞', test, partial: `S after 200,000 terms = ${f(s, 12)}; tail estimate ${f(tail, 6)}` }, steps: [test, `Partial sums: ${partials.slice(0, 5).map((v) => f(v, 10)).join(', ')}, …`] });
    },

    lagrange: (i) => {
        const [M, a, x, n] = [i.m, i.a, i.x, i.n].map(Number);

        if (![M, a, x, n].every(Number.isFinite) || n < 0 || !Number.isInteger(n)) {
            return need('Enter M (the maximum of |f⁽ⁿ⁺¹⁾|), the centre a, the point x and the degree n.');
        }

        let factorial = 1;

        for (let k = 2; k <= n + 1; k += 1) {
            factorial *= k;
        }

        const bound = (Math.abs(M) * Math.abs(x - a) ** (n + 1)) / factorial;

        return result(f(bound, 10), 'Error bound |Rₙ(x)|', { sub: `M|x − a|ⁿ⁺¹ ÷ (n + 1)! with n = ${n}`, rows: { factorial: `${n + 1}! = ${factorial}`, distance: f(Math.abs(x - a), 10), digits: bound > 0 ? `About ${Math.max(0, Math.floor(-Math.log10(bound)))} correct decimal places guaranteed` : 'Exact' }, steps: [`|Rₙ(x)| ≤ ${f(M)} × |${f(x)} − ${f(a)}|^${n + 1} ÷ ${n + 1}!`, `= ${f(M)} × ${f(Math.abs(x - a) ** (n + 1), 10)} ÷ ${factorial} = ${f(bound, 10)}`] });
    },
};

export default defineTools(handlers);
