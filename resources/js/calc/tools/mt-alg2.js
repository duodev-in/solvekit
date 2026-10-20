import * as C from '../math/complex.js';
import { defineTools } from '../engines/formula.js';
import { ParseError } from '../math/expr.js';
import * as N from '../math/numtheory.js';
import * as S from '../math/sets.js';
import * as SF from '../math/special.js';
import { f, fail, need, R, result } from '../math/util.js';

/**
 * Complex numbers and quaternions, special functions (Gamma, error function, Bessel, hyperbolic),
 * binomial coefficients and permutations, finite sets, intervals and truth tables.
 */
const ct = (z, sig = 10) => C.text(z, sig);
const degText = (rad) => `${f((rad * 180) / Math.PI, 10)}°`;

function polarText(z) {
    return `${f(C.abs(z), 10)}(cos ${f(C.arg(z), 10)} + i sin ${f(C.arg(z), 10)})`;
}

function parseQuat(text) {
    const s = String(text ?? '').replace(/\s+/g, '').replace(/[−–]/g, '-');

    if (!s) {
        return null;
    }

    const out = { w: 0, x: 0, y: 0, z: 0 };
    const terms = s.match(/[+-]?[^+-]+/g) ?? [];

    for (const term of terms) {
        const m = term.match(/^([+-]?)(\d*\.?\d*(?:e[+-]?\d+)?)\*?([ijk]?)$/i);

        if (!m || (!m[2] && !m[3])) {
            return null;
        }

        const v = (m[1] === '-' ? -1 : 1) * (m[2] ? Number(m[2]) : 1);
        out[{ '': 'w', i: 'x', j: 'y', k: 'z' }[m[3].toLowerCase()]] += v;
    }

    return out;
}

const qmul = (a, b) => ({ w: a.w * b.w - a.x * b.x - a.y * b.y - a.z * b.z, x: a.w * b.x + a.x * b.w + a.y * b.z - a.z * b.y, y: a.w * b.y - a.x * b.z + a.y * b.w + a.z * b.x, z: a.w * b.z + a.x * b.y - a.y * b.x + a.z * b.w });
const qnorm = (a) => Math.hypot(a.w, a.x, a.y, a.z);
const qconj = (a) => ({ w: a.w, x: -a.x, y: -a.y, z: -a.z });
const qtext = (a) => {
    const parts = [[a.w, ''], [a.x, 'i'], [a.y, 'j'], [a.z, 'k']].filter(([v]) => Math.abs(v) > 1e-12);

    if (!parts.length) {
        return '0';
    }

    return parts.map(([v, u], k) => `${k ? (v < 0 ? ' − ' : ' + ') : v < 0 ? '−' : ''}${f(Math.abs(v), 10) === '1' && u ? '' : f(Math.abs(v), 10)}${u}`).join('');
};

export const handlers = {
    complex: (i, c) => {
        const a = C.parse(i.z1);
        const op = c.op ?? i.op ?? '+';
        const b = ['conj', 'form', 'pow'].includes(op) ? C.c(0, 0) : C.parse(i.z2);

        if (!a || !b) {
            return need('Enter complex numbers such as 3 + 4i or −2i.');
        }

        let r;
        let label;
        const steps = [];

        switch (op) {
            case '+': r = C.add(a, b); label = 'Sum'; steps.push(`(${ct(a)}) + (${ct(b)}) = (${f(a.re)} + ${f(b.re)}) + (${f(a.im)} + ${f(b.im)})i`); break;
            case '-': r = C.sub(a, b); label = 'Difference'; steps.push(`Subtract real and imaginary parts separately`); break;
            case '*': r = C.mul(a, b); label = 'Product'; steps.push(`(${f(a.re)} + ${f(a.im)}i)(${f(b.re)} + ${f(b.im)}i) = ${f(a.re * b.re)} + ${f(a.re * b.im)}i + ${f(a.im * b.re)}i + ${f(a.im * b.im)}i²`, 'i² = −1, so collect real and imaginary parts'); break;
            case '/': {
                if (b.re === 0 && b.im === 0) {
                    return fail('Division by zero.');
                }

                r = C.div(a, b);
                label = 'Quotient';
                steps.push(`Multiply top and bottom by the conjugate ${ct(C.conj(b))}`, `Denominator: ${f(b.re)}² + ${f(b.im)}² = ${f(b.re ** 2 + b.im ** 2)}`, `Numerator: ${ct(C.mul(a, C.conj(b)))}`);
                break;
            }
            case 'conj': r = C.conj(a); label = 'Complex conjugate'; steps.push(`Change the sign of the imaginary part: ${ct(a)} → ${ct(r)}`, `z × z̄ = ${f(a.re ** 2 + a.im ** 2)} (= |z|²)`); break;
            case 'pow': {
                const n = Number(i.n ?? 2);
                r = C.pow(a, C.c(n, 0));
                label = `z^${f(n)}`;
                steps.push(`De Moivre: |z|ⁿ (cos nθ + i sin nθ) = ${f(C.abs(a) ** n, 10)}(cos ${f(n * C.arg(a), 8)} + i sin ${f(n * C.arg(a), 8)})`);
                break;
            }
            default: r = a; label = 'Forms of z';
        }

        const form = c.show ?? 'rect';
        const value = form === 'polar' ? `${f(C.abs(r), 10)} ∠ ${degText(C.arg(r))}` : form === 'trig' ? polarText(r) : form === 'exp' ? `${f(C.abs(r), 10)}e^(${f(C.arg(r), 10)}i)` : ct(r);

        return result(value, label, { sub: form === 'rect' ? `|z| = ${f(C.abs(r), 10)}, arg z = ${degText(C.arg(r))}` : ct(r), rows: { rect: ct(r), polar: `${f(C.abs(r), 10)} ∠ ${degText(C.arg(r))} (${f(C.arg(r), 10)} rad)`, trig: polarText(r), exp: `${f(C.abs(r), 10)}e^(${f(C.arg(r), 10)}i)`, conj: ct(C.conj(r)) }, steps, plots: { argand: { kind: 'diagram', shapes: [{ points: [[0, 0], [r.re, r.im]] }, { points: [[-Math.max(1, Math.abs(r.re)) * 1.2, 0], [Math.max(1, Math.abs(r.re)) * 1.2, 0]], muted: true }, { points: [[0, -Math.max(1, Math.abs(r.im)) * 1.2], [0, Math.max(1, Math.abs(r.im)) * 1.2]], muted: true }], dots: [[r.re, r.im]], labels: [{ x: r.re, y: r.im + Math.max(Math.abs(r.im), 1) * 0.15, text: ct(r, 5) }, { x: Math.max(1, Math.abs(r.re)) * 1.2, y: -Math.max(1, Math.abs(r.im)) * 0.12, text: 'Re' }, { x: Math.max(1, Math.abs(r.re)) * 0.1, y: Math.max(1, Math.abs(r.im)) * 1.2, text: 'Im' }] } } });
    },

    complex_roots: (i) => {
        const z = C.parse(i.z1);
        const n = Math.round(Number(i.n));

        if (!z || !(n >= 2 && n <= 24)) {
            return need('Enter a complex number and n from 2 to 24.');
        }

        const rs = C.roots(z, n);

        return result(rs.map((w) => ct(w, 8)).join(',  '), `The ${n} ${n === 2 ? 'square' : n === 3 ? 'cube' : `${n}th`} roots of ${ct(z)}`, { sub: `On a circle of radius ${f(C.abs(z) ** (1 / n), 10)}, ${f(360 / n)}° apart`, rows: { modulus: f(C.abs(z) ** (1 / n), 12), principal: ct(rs[0], 12), spacing: `${f(360 / n)}°` }, steps: rs.map((w, k) => `k = ${k}: ${f(C.abs(z) ** (1 / n), 10)} cis(${f((C.arg(z) + 2 * Math.PI * k) / n, 8)}) = ${ct(w, 10)}`), plots: { argand: { kind: 'diagram', shapes: [{ points: [...rs, rs[0]].map((w) => [w.re, w.im]), closed: false, dashed: true }], dots: rs.map((w) => [w.re, w.im]), labels: rs.slice(0, 8).map((w, k) => ({ x: w.re * 1.15, y: w.im * 1.15, text: `w${R.subscript(k)}` })) } } });
    },

    quaternion: (i) => {
        const a = parseQuat(i.q1);
        const b = parseQuat(i.q2);
        const op = i.op ?? '*';

        if (!a || (!b && op !== 'unary')) {
            return need('Enter quaternions such as 1 + 2i − j + 3k.');
        }

        let r;

        switch (op) {
            case '+': r = { w: a.w + b.w, x: a.x + b.x, y: a.y + b.y, z: a.z + b.z }; break;
            case '-': r = { w: a.w - b.w, x: a.x - b.x, y: a.y - b.y, z: a.z - b.z }; break;
            case '/': {
                const n2 = qnorm(b) ** 2;

                if (!n2) {
                    return fail('Cannot divide by zero.');
                }

                const inv = { w: b.w / n2, x: -b.x / n2, y: -b.y / n2, z: -b.z / n2 };
                r = qmul(a, inv);
                break;
            }
            default: r = qmul(a, b);
        }

        const n2 = qnorm(a) ** 2;

        return result(qtext(r), { '+': 'Sum', '-': 'Difference', '*': 'Hamilton product', '/': 'Quotient a × b⁻¹' }[op] ?? 'Result', { sub: op === '*' ? `b × a = ${qtext(qmul(b, a))} (multiplication is not commutative)` : `|result| = ${f(qnorm(r), 10)}`, rows: { norm: f(qnorm(a), 12), conj: qtext(qconj(a)), inverse: n2 ? qtext({ w: a.w / n2, x: -a.x / n2, y: -a.y / n2, z: -a.z / n2 }) : 'None', unit: qnorm(a) ? qtext({ w: a.w / qnorm(a), x: a.x / qnorm(a), y: a.y / qnorm(a), z: a.z / qnorm(a) }) : 'None' }, steps: ['i² = j² = k² = ijk = −1, ij = k, jk = i, ki = j', `a = ${qtext(a)}`, `b = ${qtext(b ?? { w: 0, x: 0, y: 0, z: 0 })}`, `Result = ${qtext(r)}`] });
    },

    binomial: (i, c) => {
        const n = N.parseBig(i.n);
        const k = N.parseBig(i.k);

        if (n === null || k === null || n < 0n || k < 0n || n > 100000n) {
            return need('Enter whole numbers n (up to 100,000) and k.');
        }

        const comb = N.binomial(n, k);
        const perm = k > n ? 0n : N.factorial(n) / N.factorial(n - k);
        const combRep = N.binomial(n + k - 1n, k);
        const permRep = n ** k;
        const mode = c.mode ?? i.mode ?? 'comb';
        const main = { comb, perm, combrep: combRep, permrep: permRep }[mode];
        const label = { comb: `C(${n}, ${k}) = ${n} choose ${k}`, perm: `P(${n}, ${k}) permutations`, combrep: 'Combinations with repetition', permrep: 'Permutations with repetition' }[mode];
        const s = main.toString();

        return result(s.length > 40 ? `${s.slice(0, 20)}… (${s.length} digits)` : R.fmt(main), label, { sub: { comb: 'Order does not matter, no repeats', perm: 'Order matters, no repeats', combrep: 'Order does not matter, repeats allowed', permrep: 'Order matters, repeats allowed' }[mode], rows: { comb: R.fmt(comb), perm: perm.toString().length > 40 ? `${perm.toString().length} digits` : R.fmt(perm), combrep: combRep.toString().length > 40 ? `${combRep.toString().length} digits` : R.fmt(combRep), permrep: permRep.toString().length > 40 ? `${permRep.toString().length} digits` : R.fmt(permRep) }, steps: [`C(n, k) = n! ÷ (k!(n − k)!) = ${n}! ÷ (${k}! × ${n - k < 0n ? 0n : n - k}!)`, `P(n, k) = n! ÷ (n − k)!`, `With repetition: C(n + k − 1, k) and nᵏ`] });
    },

    special: (i, c) => {
        const fn = c.fn ?? i.fn;
        const x = Number(i.x);

        if (!Number.isFinite(x)) {
            return need('Enter x.');
        }

        const range = (g, lo, hi) => Array.from({ length: 121 }, (_, k) => {
            const xx = lo + ((hi - lo) * k) / 120;

            return [xx, g(xx)];
        });

        if (fn === 'gamma') {
            const im = Number(i.y || 0);

            if (im) {
                const g = SF.gammaComplex(C.c(x, im));

                return result(ct(g, 12), `Γ(${ct(C.c(x, im))})`, { sub: `|Γ| = ${f(C.abs(g), 10)}`, rows: { ln: ct(C.log(g), 10), factorial: 'Complex argument', reflection: 'Γ(z)Γ(1 − z) = π / sin(πz)' }, steps: ['Lanczos approximation (g = 7), reflection for Re z < 1/2'] });
            }

            const g = SF.gamma(x);

            if (!Number.isFinite(g)) {
                return result('Undefined', `Γ(${f(x)})`, { sub: 'Γ has poles at 0, −1, −2, …', rows: { ln: 'Undefined', factorial: 'None', reflection: 'Γ(z)Γ(1 − z) = π / sin(πz)' } });
            }

            return result(f(g, 14), `Γ(${f(x)})`, { sub: Number.isInteger(x) && x > 0 ? `= ${f(x - 1)}!` : x === 0.5 ? '= √π' : '', rows: { ln: f(SF.lnGamma(x), 14), factorial: x > -1 ? `${f(x - 1)}! = Γ(${f(x)})` : 'Not a factorial', reflection: 'Γ(z)Γ(1 − z) = π / sin(πz)' }, steps: ['Γ(x) = ∫₀^∞ t^(x−1) e^(−t) dt', 'Lanczos approximation, accurate to about 15 digits'], plots: { graph: { series: range((t) => { const v = SF.gamma(t); return Math.abs(v) < 25 ? v : NaN; }, -4.9, 5), axes: true, xLabel: 'x', yLabel: 'Γ(x)', yMin: -25, yMax: 25, markers: [{ x, y: Math.max(-25, Math.min(25, g)) }] } } });
        }

        if (fn === 'erf') {
            return result(f(SF.erf(x), 14), `erf(${f(x)})`, { sub: `erfc = ${f(SF.erfc(x), 14)}`, rows: { erfc: f(SF.erfc(x), 14), inverse: Math.abs(x) < 1 ? `erf⁻¹(${f(x)}) = ${f(SF.erfinv(x), 14)}` : 'Defined for −1 < x < 1', normal: `P(|Z| < ${f(x * Math.SQRT2, 8)}) = ${f(SF.erf(x), 10)} for a standard normal Z` }, steps: ['erf x = (2/√π) ∫₀ˣ e^(−t²) dt', x < 3 ? 'Maclaurin series' : 'Continued fraction for erfc'], plots: { graph: { series: range(SF.erf, -3, 3), axes: true, xLabel: 'x', yLabel: 'erf(x)', markers: [{ x: Math.max(-3, Math.min(3, x)), y: SF.erf(Math.max(-3, Math.min(3, x))) }] } } });
        }

        if (fn === 'bessel') {
            const nu = Number(i.nu ?? 0);
            const kind = i.kind ?? 'J';
            const g = { J: SF.besselJ, Y: SF.besselY, I: SF.besselI, K: SF.besselK }[kind];
            const v = g(nu, x);

            if (!Number.isFinite(v)) {
                return need(kind === 'Y' || kind === 'K' ? 'Y and K are defined for x > 0.' : 'Enter x ≥ 0.');
            }

            const lo = kind === 'Y' || kind === 'K' ? 0.1 : 0;
            const hi = Math.max(10, x * 1.3);

            return result(f(v, 13), `${kind}${R.subscript(nu)}(${f(x)})`, { sub: { J: 'Bessel function of the first kind', Y: 'Bessel function of the second kind', I: 'Modified Bessel function of the first kind', K: 'Modified Bessel function of the second kind' }[kind], rows: { kind: kind, order: f(nu), method: 'Integral representation (DLMF 10.9, 10.32), adaptive Gauss–Kronrod' }, steps: [{ J: 'J_ν(x) = (1/π)∫₀^π cos(νt − x sin t) dt − (sin νπ/π)∫₀^∞ e^(−x sinh t − νt) dt', Y: 'Y_ν(x) = (1/π)∫₀^π sin(x sin t − νt) dt − (1/π)∫₀^∞ (e^(νt) + e^(−νt) cos νπ) e^(−x sinh t) dt', I: 'I_ν(x) = (1/π)∫₀^π e^(x cos t) cos νt dt − (sin νπ/π)∫₀^∞ e^(−x cosh t − νt) dt', K: 'K_ν(x) = ∫₀^∞ e^(−x cosh t) cosh νt dt' }[kind]], plots: { graph: { series: range((t) => { const w = g(nu, t); return Math.abs(w) < 50 ? w : NaN; }, lo, hi), axes: true, xLabel: 'x', yLabel: `${kind}${R.subscript(nu)}(x)`, markers: [{ x, y: Math.max(-50, Math.min(50, v)) }] } } });
        }

        // Hyperbolic functions.
        const vals = { sinh: Math.sinh(x), cosh: Math.cosh(x), tanh: Math.tanh(x), coth: 1 / Math.tanh(x), sech: 1 / Math.cosh(x), csch: 1 / Math.sinh(x) };
        const which = c.which ?? i.which ?? 'sinh';
        const inv = { asinh: Math.asinh(x), acosh: x >= 1 ? Math.acosh(x) : NaN, atanh: Math.abs(x) < 1 ? Math.atanh(x) : NaN };

        return result(Number.isFinite(vals[which]) ? f(vals[which], 14) : 'Undefined', `${which}(${f(x)})`, { sub: { sinh: '(eˣ − e⁻ˣ) ÷ 2', cosh: '(eˣ + e⁻ˣ) ÷ 2', tanh: 'sinh x ÷ cosh x', coth: 'cosh x ÷ sinh x', sech: '1 ÷ cosh x', csch: '1 ÷ sinh x' }[which], rows: { sinh: f(vals.sinh, 12), cosh: f(vals.cosh, 12), tanh: f(vals.tanh, 12), others: `coth ${Number.isFinite(vals.coth) ? f(vals.coth, 10) : 'undefined'}, sech ${f(vals.sech, 10)}, csch ${Number.isFinite(vals.csch) ? f(vals.csch, 10) : 'undefined'}`, inverse: `asinh ${f(inv.asinh, 10)}, acosh ${Number.isFinite(inv.acosh) ? f(inv.acosh, 10) : 'needs x ≥ 1'}, atanh ${Number.isFinite(inv.atanh) ? f(inv.atanh, 10) : 'needs |x| < 1'}` }, steps: [`e^${f(x)} = ${f(Math.exp(x), 12)}, e^${f(-x)} = ${f(Math.exp(-x), 12)}`, 'cosh² x − sinh² x = 1'], plots: { graph: { series: range((t) => ({ sinh: Math.sinh, cosh: Math.cosh, tanh: Math.tanh, coth: (u) => 1 / Math.tanh(u), sech: (u) => 1 / Math.cosh(u), csch: (u) => 1 / Math.sinh(u) }[which](t)), -3, 3).map(([a, b]) => [a, Math.abs(b) < 12 ? b : NaN]), axes: true, xLabel: 'x', yLabel: which, markers: [{ x: Math.max(-3, Math.min(3, x)), y: Math.max(-12, Math.min(12, vals[which])) }] } } });
    },

    set_ops: (i, c) => {
        const a = S.parseSet(i.a);
        const b = S.parseSet(i.b);
        const u = i.u ? S.parseSet(i.u) : null;
        const mode = c.mode ?? 'ops';

        if (mode === 'power') {
            if (a.length > 12) {
                return fail('Sets up to 12 elements (4,096 subsets) are listed.');
            }

            const subsets = [];

            for (let m = 0; m < 2 ** a.length; m += 1) {
                subsets.push(a.filter((_, k) => m & (1 << k)));
            }

            subsets.sort((x, y) => x.length - y.length);

            return result(`${2 ** a.length} subsets`, `Power set of ${S.setText(a)}`, { sub: `2^${a.length} = ${2 ** a.length}`, rows: { count: String(2 ** a.length), proper: String(2 ** a.length - 1), size: String(a.length) }, steps: subsets.map(S.setText) });
        }

        if (mode === 'subset') {
            const isSub = a.every((x) => b.includes(x));
            const proper = isSub && b.length > a.length;
            const n = Math.round(Number(i.n));

            return result(isSub ? (proper ? 'A ⊂ B (proper subset)' : 'A ⊆ B') : 'A ⊄ B', `Is ${S.setText(a)} a subset of ${S.setText(b)}?`, { sub: isSub ? 'Every element of A is in B' : `Not in B: ${a.filter((x) => !b.includes(x)).join(', ')}`, rows: { count: `${2 ** b.length} subsets of B`, proper: `${2 ** b.length - 1} proper subsets of B`, size: Number.isFinite(n) && n >= 0 && n <= b.length ? `${R.fmt(N.binomial(b.length, n))} subsets of B with ${n} elements` : `|A| = ${a.length}, |B| = ${b.length}` }, steps: a.map((x) => `${x} ${b.includes(x) ? '∈' : '∉'} B`) });
        }

        const union = S.sortSet([...new Set([...a, ...b])]);
        const inter = S.sortSet(a.filter((x) => b.includes(x)));
        const aMinusB = S.sortSet(a.filter((x) => !b.includes(x)));
        const bMinusA = S.sortSet(b.filter((x) => !a.includes(x)));
        const sym = S.sortSet([...aMinusB, ...bMinusA]);
        const comp = u ? S.sortSet(u.filter((x) => !a.includes(x))) : null;

        return result(S.setText(union), 'A ∪ B', { sub: `A ∩ B = ${S.setText(inter)}`, rows: { union: S.setText(union), inter: S.setText(inter), diff: `A − B = ${S.setText(aMinusB)}, B − A = ${S.setText(bMinusA)}`, sym: S.setText(sym), comp: comp ? S.setText(comp) : 'Enter a universal set U', sizes: `|A ∪ B| = |A| + |B| − |A ∩ B| = ${a.length} + ${b.length} − ${inter.length} = ${union.length}` }, steps: [`A = ${S.setText(a)}`, `B = ${S.setText(b)}`, `Only in A: ${S.setText(aMinusB)}; in both: ${S.setText(inter)}; only in B: ${S.setText(bMinusA)}`] });
    },

    intervals: (i) => {
        const a = S.parseIntervals(i.a);
        const b = i.b ? S.parseIntervals(i.b) : null;
        const op = i.op ?? 'union';

        if (!a || (op !== 'complement' && !b)) {
            return need('Enter intervals such as (−∞, 3] ∪ [5, 7) and [2, 6].');
        }

        const r = op === 'union' ? S.union(a, b) : op === 'intersection' ? S.intersect(a, b) : op === 'difference' ? S.intersect(a, S.complement(b)) : S.complement(a);

        return result(S.intervalText(r), { union: 'A ∪ B', intersection: 'A ∩ B', difference: 'A − B', complement: 'Complement of A' }[op], { sub: S.setBuilderText(r), rows: { interval: S.intervalText(r), builder: S.setBuilderText(r) }, steps: [`A = ${S.intervalText(a)}`, ...(b ? [`B = ${S.intervalText(b)}`] : []), `${{ union: 'A ∪ B', intersection: 'A ∩ B', difference: 'A − B', complement: 'ℝ − A' }[op]} = ${S.intervalText(r)}`], plots: { line: S.numberLine(r) } });
    },

    truth_table: (i) => {
        let parsed;

        try {
            parsed = S.parseLogic(i.expr);
        } catch (e) {
            return fail(e instanceof ParseError ? e.message : 'Could not read the expression.');
        }

        const { tree, vars } = parsed;

        if (vars.length > 6) {
            return fail('Up to 6 variables (64 rows) are supported.');
        }

        const rows = [];
        let trues = 0;
        const minterms = [];

        for (let m = 0; m < 2 ** vars.length; m += 1) {
            const env = Object.fromEntries(vars.map((v, k) => [v, Boolean((m >> (vars.length - 1 - k)) & 1)]));
            const out = S.evalLogic(tree, env);
            trues += out ? 1 : 0;

            if (out) {
                minterms.push(vars.map((v) => (env[v] ? v : `¬${v}`)).join(' ∧ '));
            }

            rows.push({ header: vars.map((v) => `${v} = ${env[v] ? 'T' : 'F'}`).join(', '), cells: [out ? 'T' : 'F'], highlight: out });
        }

        const kind = trues === rows.length ? 'Tautology (always true)' : trues === 0 ? 'Contradiction (always false)' : 'Contingency (sometimes true)';

        return result(kind, S.logicText(tree), { sub: `${trues} of ${rows.length} rows true`, rows: { vars: vars.join(', '), dnf: minterms.length ? minterms.map((m) => `(${m})`).join(' ∨ ') : 'None (never true)', count: `${trues} true, ${rows.length - trues} false` }, steps: [`Variables: ${vars.join(', ')}`, 'Columns: ' + vars.join(' ') + ' | result'], grids: { table: { columns: [S.logicText(tree)], rows: rows.map((r2) => ({ ...r2, header: r2.header })) } } });
    },
};

export default defineTools(handlers);
