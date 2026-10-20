import * as C from '../math/complex.js';
import { defineTools } from '../engines/formula.js';
import { evalExact, parse, ParseError, toPoly, variables } from '../math/expr.js';
import * as L from '../math/linalg.js';
import * as P from '../math/poly.js';
import * as S from '../math/sets.js';
import { dec, f, fail, need, q, R, result } from '../math/util.js';

/**
 * Polynomials and equations: arithmetic with the school layouts (FOIL, box method, long and synthetic division),
 * factoring over the rationals, completing the square, quadratic and cubic formulas, rational and numeric roots,
 * Descartes' rule, partial fractions, linear systems and inequalities. Coefficients stay exact.
 */
const t = R.toFraction;

/** Reads a polynomial from text; the variable is detected (x by default). */
export function readPoly(text, fallback = 'x') {
    let tree;

    try {
        tree = parse(String(text ?? '').replace(/=\s*0\s*$/, ''));
    } catch (e) {
        return { error: e instanceof ParseError ? e.message : 'Could not read the polynomial.' };
    }

    const vars = [...variables(tree)];

    if (vars.length > 1) {
        return { error: `Use one variable (found ${vars.join(', ')}).` };
    }

    const v = vars[0] ?? fallback;
    const p = toPoly(tree, v);

    return p ? { p, v } : { error: 'That is not a polynomial (no variables in denominators or fractional powers).' };
}

const roots = (p) => P.numericRoots(p);
const ctext = (z, sig = 10) => C.text(z, sig);

function linearOf(node, v) {
    const b = evalExact(node, { [v]: R.ZERO });
    const one = evalExact(node, { [v]: R.ONE });
    const two = evalExact(node, { [v]: R.Q(2) });

    if (!b || !one || !two) {
        return null;
    }

    const a = R.sub(one, b);

    return R.eq(R.sub(two, one), a) ? { a, b } : null;
}

function plotPoly(p, xs) {
    const lo = Math.min(...xs, -5);
    const hi = Math.max(...xs, 5);
    const pad = (hi - lo) * 0.2 + 1;
    const a = lo - pad;
    const b = hi + pad;
    const series = Array.from({ length: 201 }, (_, k) => {
        const x = a + ((b - a) * k) / 200;

        return [x, P.evalNumber(p, x)];
    });
    const ys = series.map((s) => s[1]).filter(Number.isFinite).sort((m, n) => m - n);
    const yLo = ys[Math.floor(ys.length * 0.05)];
    const yHi = ys[Math.floor(ys.length * 0.95)];

    return { series: series.map(([x, y]) => [x, Math.max(yLo - (yHi - yLo), Math.min(yHi + (yHi - yLo), y))]), axes: true, scatter: xs.map((x) => [x, 0]), xLabel: 'x', yLabel: 'y' };
}

/** Exact rational solution of a square linear system, else null. */
function solveSystem(rows, rhs) {
    const res = L.solve(rows, rhs);

    return res;
}

/** Partial fraction decomposition of N/D with D factoring into linear and irreducible quadratic factors over Q. */
function partialFractions(N, D, v) {
    let poly = [];
    let num = N;

    if (P.deg(N) >= P.deg(D)) {
        const d = P.divmod(N, D);
        poly = d.q;
        num = d.r;
    }

    const { roots: lin, rest } = P.rationalRoots(D);
    const prim = P.primitive(rest);
    const factors = [];

    lin.forEach(([r, m]) => factors.push({ f: [R.neg(r), R.ONE], m, quad: false }));

    if (P.deg(prim.poly) === 2) {
        factors.push({ f: prim.poly.map((c) => R.div(c, P.lead(prim.poly))), m: 1, quad: true });
    } else if (P.deg(prim.poly) > 2) {
        // Repeated quadratic: rest = q² ?
        const g = P.gcd(prim.poly, P.derivative(prim.poly));

        if (P.deg(g) === 2 && P.deg(prim.poly) === 4) {
            factors.push({ f: g, m: 2, quad: true });
        } else {
            return { error: 'The denominator has an irreducible factor of degree 3 or more, which has no partial fraction form over the rationals.' };
        }
    }

    // Unknowns: for each factor power k: A (linear) or Bx + C (quadratic) over f^k.
    const terms = [];

    factors.forEach((fac) => {
        for (let k = 1; k <= fac.m; k += 1) {
            terms.push({ fac, k });
        }
    });

    const monicD = P.scale(D, R.inv(P.lead(D)));
    const unknownCols = [];

    terms.forEach((term) => {
        const fk = Array.from({ length: term.k }).reduce((acc) => P.mul(acc, term.fac.f), [R.ONE]);
        const other = P.divmod(monicD, fk).q;

        if (term.fac.quad) {
            unknownCols.push({ term, coeff: 'B', poly: P.mul(other, [R.ZERO, R.ONE]) });
            unknownCols.push({ term, coeff: 'C', poly: other });
        } else {
            unknownCols.push({ term, coeff: 'A', poly: other });
        }
    });

    const n = P.deg(monicD);
    const target = P.scale(num, R.inv(P.lead(D)));
    const A = Array.from({ length: n }, (_, row) => unknownCols.map((u) => u.poly[row] ?? R.ZERO));
    const b = Array.from({ length: n }, (_, row) => target[row] ?? R.ZERO);
    const sol = solveSystem(A, b);

    if (sol.kind !== 'unique') {
        return { error: 'Could not solve for the coefficients.' };
    }

    const pieces = [];
    let idx = 0;

    terms.forEach((term) => {
        const inner = P.toText(term.fac.f, v);
        const ftxt = inner.includes(' ') ? `(${inner})${term.k > 1 ? R.sup(term.k) : ''}` : `${inner}${term.k > 1 ? R.sup(term.k) : ''}`;

        if (term.fac.quad) {
            const B = sol.x[idx];
            const Cc = sol.x[idx + 1];
            idx += 2;

            if (!R.isZero(B) || !R.isZero(Cc)) {
                const top = P.toText([Cc, B], v);
                pieces.push(`${top.includes(' ') ? `(${top})` : top}/${ftxt}`);
            }
        } else {
            const Aa = sol.x[idx];
            idx += 1;

            if (!R.isZero(Aa)) {
                const sign = R.sign(Aa) < 0 ? '−' : '';
                const mag = R.qabs(Aa);
                pieces.push(R.isInt(mag) ? `${sign}${t(mag)}/${ftxt}` : `${sign}${mag.n}/(${mag.d}${ftxt})`);
            }
        }
    });


    return { poly, pieces, unknowns: unknownCols.map((u, k) => `${u.coeff}${R.subscript(k + 1)} = ${t(sol.x[k])}`) };
}

export const handlers = {
    poly_arith: (i, c) => {
        const a = readPoly(i.p1);
        const b = readPoly(i.p2);
        const op = c.op ?? i.op ?? '+';

        if (a.error || b.error) {
            return need(a.error || b.error);
        }

        const v = a.v === 'x' && b.v !== 'x' ? b.v : a.v;
        const r = op === '+' ? P.add(a.p, b.p) : op === '-' ? P.sub(a.p, b.p) : P.mul(a.p, b.p);
        const steps = [];

        if (op === '*') {
            const terms = (p) => p.map((cf, k) => [cf, k]).filter(([cf]) => !R.isZero(cf)).reverse();
            const ta = terms(a.p);
            const tb = terms(b.p);
            const term = ([cf, k]) => P.toText(Array.from({ length: k + 1 }, (_, j) => (j === k ? cf : R.ZERO)), v);
            const labels = c.foil && ta.length === 2 && tb.length === 2 ? ['First', 'Outer', 'Inner', 'Last'] : null;
            let n = 0;

            ta.forEach((x) => tb.forEach((y) => {
                const prod = Array.from({ length: x[1] + y[1] + 1 }, (_, j) => (j === x[1] + y[1] ? R.mul(x[0], y[0]) : R.ZERO));
                steps.push(`${labels ? `${labels[n]}: ` : ''}(${term(x)})(${term(y)}) = ${P.toText(prod, v)}`);
                n += 1;
            }));
            steps.push(`Combine like terms: ${P.toText(r, v)}`);
        } else {
            steps.push(`(${P.toText(a.p, v)}) ${op === '+' ? '+' : '−'} (${P.toText(b.p, v)})`);

            if (op === '-') {
                steps.push(`Change the signs of the second: ${P.toText(a.p, v)} + (${P.toText(b.p.map(R.neg), v)})`);
            }

            steps.push(`Combine like terms: ${P.toText(r, v)}`);
        }

        const grids = c.box ? { box: { columns: P.toText(b.p, v).split(/ (?=[+−])/).map((s) => s.replace(/^\+ /, '')), rows: [...a.p].map((cf, k) => [cf, k]).filter(([cf]) => !R.isZero(cf)).reverse().map(([cf, k]) => ({ header: P.toText(Array.from({ length: k + 1 }, (_, j) => (j === k ? cf : R.ZERO)), v), cells: [...b.p].map((cb, kb) => [cb, kb]).filter(([cb]) => !R.isZero(cb)).reverse().map(([cb, kb]) => P.toText(Array.from({ length: k + kb + 1 }, (_, j) => (j === k + kb ? R.mul(cf, cb) : R.ZERO)), v)) })) } } : undefined;

        return result(P.toText(r, v), { '+': 'Sum', '-': 'Difference', '*': 'Product' }[op], { sub: `Degree ${P.deg(r)}`, rows: { degree: String(P.deg(r)), terms: String(r.filter((cf) => !R.isZero(cf)).length), factored: P.deg(r) >= 1 ? P.factorText(r, v) : t(r[0]) }, steps, grids });
    },

    square_binomial: (i) => {
        const a = readPoly(i.p1);

        if (a.error || a.p.filter((cf) => !R.isZero(cf)).length > 2) {
            return need('Enter a binomial such as 3x − 5.');
        }

        const r = P.mul(a.p, a.p);
        const nz = a.p.map((cf, k) => [cf, k]).filter(([cf]) => !R.isZero(cf)).reverse();
        const term = ([cf, k]) => P.toText(Array.from({ length: k + 1 }, (_, j) => (j === k ? cf : R.ZERO)), a.v);
        const [A, B] = nz.length === 2 ? nz : [nz[0], [R.ZERO, 0]];

        return result(P.toText(r, a.v), `(${P.toText(a.p, a.v)})²`, { sub: '(a + b)² = a² + 2ab + b²', rows: { degree: String(P.deg(r)), terms: String(r.filter((cf) => !R.isZero(cf)).length), factored: `(${P.toText(a.p, a.v)})²` }, steps: [`a = ${term(A)}, b = ${term(B)}`, `a² = ${term([R.mul(A[0], A[0]), 2 * A[1]])}`, `2ab = ${term([R.mul(R.Q(2), R.mul(A[0], B[0])), A[1] + B[1]])}`, `b² = ${term([R.mul(B[0], B[0]), 2 * B[1]])}`, `= ${P.toText(r, a.v)}`] });
    },

    divide: (i, c) => {
        const a = readPoly(i.p1);
        const b = readPoly(i.p2);

        if (a.error || b.error) {
            return need(a.error || b.error);
        }

        if (P.isZeroPoly(b.p)) {
            return fail('Cannot divide by zero.');
        }

        const v = a.v;

        if (c.synthetic) {
            if (P.deg(b.p) !== 1 || !R.eq(b.p[1], R.ONE)) {
                return need('Synthetic division needs a divisor of the form x − c.');
            }

            const root = R.neg(b.p[0]);
            const coeffs = [...a.p].reverse();
            const row = [];
            const bottom = [];
            let acc = R.ZERO;

            coeffs.forEach((cf, k) => {
                const add = k === 0 ? R.ZERO : R.mul(acc, root);
                row.push(k === 0 ? '' : t(add));
                acc = R.add(cf, add);
                bottom.push(t(acc));
            });

            const w = Math.max(...[...coeffs.map(t), ...row, ...bottom].map((s) => s.length)) + 2;
            const fmtRow = (cells) => cells.map((s) => s.padStart(w)).join('');
            const { q: qt, r } = P.divmod(a.p, b.p);

            return result(P.toText(qt, v) + (P.isZeroPoly(r) ? '' : ` remainder ${t(r[0])}`), 'Quotient', { sub: `Remainder ${t(r[0])} = P(${t(root)}) (remainder theorem)`, rows: { quotient: P.toText(qt, v), remainder: t(r[0]), factor: P.isZeroPoly(r) ? `(${P.toText(b.p, v)}) is a factor` : 'Not a factor' }, steps: [`${t(root).padStart(4)} |${fmtRow(coeffs.map(t))}`, `     |${fmtRow(row)}`, `     ${'─'.repeat(w * coeffs.length + 1)}`, `      ${fmtRow(bottom)}`, '', 'Bring down the first coefficient; multiply by c and add to the next, repeatedly.'] });
        }

        const { q: qt, r, steps } = P.divmod(a.p, b.p);
        const work = steps.flatMap((s) => [`Divide leading terms: ${P.toText(s.term, v)}`, `  × (${P.toText(b.p, v)}) = ${P.toText(s.product, v)}`, `  Subtract → ${P.toText(s.remainder, v)}`]);

        return result(P.toText(qt, v) + (P.isZeroPoly(r) ? '' : ` + ${P.deg(r) === 0 && R.isInt(r[0]) ? P.toText(r, v) : `(${P.toText(r, v)})`}/(${P.toText(b.p, v)})`), 'Quotient and remainder', { sub: P.isZeroPoly(r) ? 'Divides exactly' : `Remainder ${P.toText(r, v)}`, rows: { quotient: P.toText(qt, v), remainder: P.toText(r, v), factor: P.isZeroPoly(r) ? `(${P.toText(b.p, v)}) is a factor` : 'Not a factor' }, steps: work });
    },

    factor: (i, c) => {
        const a = readPoly(i.p1);

        if (a.error) {
            return need(a.error);
        }

        if (P.deg(a.p) < 1) {
            return need('Enter a polynomial with a variable.');
        }

        const v = a.v;
        const fact = P.factorText(a.p, v);
        const steps = [];

        if (P.deg(a.p) === 2) {
            const [cc, b, aa] = a.p;
            const prim = P.primitive(a.p);
            const [C0, B0, A0] = prim.poly.map((x) => x.n);
            const ac = A0 * C0;
            let pair = null;

            for (let d = 1n; d * d <= R.babs(ac) && R.babs(ac) <= 10n ** 12n; d += 1n) {
                if (ac === 0n) {
                    break;
                }

                if (ac % d === 0n) {
                    for (const [m, n] of [[d, ac / d], [-d, -ac / d]]) {
                        if (m + n === B0) {
                            pair = [m, n];
                        }
                    }
                }
            }

            steps.push(`a = ${t(aa)}, b = ${t(b)}, c = ${t(cc)}`);

            if (pair) {
                steps.push(`AC method: a × c = ${ac}; two numbers that multiply to ${ac} and add to ${B0}: ${pair[0]} and ${pair[1]}`);
                steps.push(`Split the middle term: ${A0}${v}² ${pair[0] < 0n ? '−' : '+'} ${R.babs(pair[0])}${v} ${pair[1] < 0n ? '−' : '+'} ${R.babs(pair[1])}${v} ${C0 < 0n ? '−' : '+'} ${R.babs(C0)}`);
                steps.push('Group in pairs and take out common factors');
            } else {
                steps.push(`No two integers multiply to ${ac} and add to ${B0}: no rational factors`);
            }
        }

        steps.push(`= ${fact}`);
        const prime = !fact.includes(')(') && !/\)[²³⁴⁵⁶⁷⁸⁹]/.test(fact) && P.rationalRoots(a.p).roots.length === 0;
        const perfect = c.perfect ? (() => {
            const [cc, b, aa] = a.p;

            return P.deg(a.p) === 2 && R.eq(R.mul(b, b), R.mul(R.Q(4), R.mul(aa, cc)));
        })() : null;

        return result(fact, c.perfect ? (perfect ? 'A perfect square trinomial' : 'Not a perfect square trinomial') : 'Factored form', { sub: c.perfect ? (perfect ? 'b² = 4ac' : `b² = ${t(R.mul(a.p[1] ?? R.ZERO, a.p[1] ?? R.ZERO))} but 4ac = ${t(R.mul(R.Q(4), R.mul(a.p[2] ?? R.ZERO, a.p[0])))}`) : prime ? 'Irreducible over the rationals (prime)' : `${P.toText(a.p, v)} = ${fact}`, rows: { expanded: P.toText(a.p, v), roots: P.rationalRoots(a.p).roots.map(([r, m]) => `${t(r)}${m > 1 ? ` (×${m})` : ''}`).join(', ') || 'No rational roots', degree: String(P.deg(a.p)) }, steps });
    },

    rational_zeros: (i) => {
        const a = readPoly(i.p1);

        if (a.error || P.deg(a.p) < 1) {
            return need(a.error || 'Enter a polynomial.');
        }

        const cands = P.rationalCandidates(a.p);

        if (!cands) {
            return fail('The constant or leading coefficient is too large to list every candidate.');
        }

        const { roots: rr } = P.rationalRoots(a.p);
        const zeros = rr.map(([r]) => t(r));

        return result(zeros.length ? zeros.join(', ') : 'None', 'Rational zeros', { sub: `${cands.length} candidates ±p/q tested`, rows: { candidates: cands.length <= 40 ? cands.map(t).join(', ') : `${cands.length} candidates`, factored: P.factorText(a.p, a.v), degree: String(P.deg(a.p)) }, steps: [`p divides the constant term, q divides the leading coefficient (after clearing fractions)`, ...cands.slice(0, 40).map((cnd) => `P(${t(cnd)}) = ${t(P.evalAt(a.p, cnd))}${R.isZero(P.evalAt(a.p, cnd)) ? '  ✓ zero' : ''}`)] });
    },

    roots: (i) => {
        const a = readPoly(i.p1);

        if (a.error || P.deg(a.p) < 1) {
            return need(a.error || 'Enter a polynomial of degree 1 or more.');
        }

        if (P.deg(a.p) > 20) {
            return fail('Polynomials up to degree 20 are supported.');
        }

        const { roots: rr, rest } = P.rationalRoots(a.p);
        const exact = rr.map(([r, m]) => `${a.v} = ${t(r)}${m > 1 ? ` (multiplicity ${m})` : ''}`);
        let others = [];

        if (P.deg(rest) === 2) {
            const qr = P.quadraticRoots(rest[2], rest[1], rest[0]);
            others = qr.exact.map((s) => `${a.v} = ${s}`);
        } else if (P.deg(rest) > 2) {
            others = roots(rest).map((z) => `${a.v} ≈ ${ctext(z, 12)}`);
        }

        const all = roots(a.p);
        const realRoots = all.filter((z) => z.im === 0).map((z) => z.re);

        return result([...exact, ...others].join(';  '), `Roots of ${P.toText(a.p, a.v)}`, { sub: `${all.length} roots counted with multiplicity; ${realRoots.length} real`, rows: { factored: P.factorText(a.p, a.v), real: realRoots.length ? realRoots.map((x) => f(x, 10)).join(', ') : 'None', complex: all.filter((z) => z.im !== 0).map((z) => ctext(z, 8)).join(', ') || 'None' }, steps: [`Rational roots by the rational root theorem: ${rr.length ? rr.map(([r]) => t(r)).join(', ') : 'none'}`, P.deg(rest) > 0 ? `Remaining factor ${P.toText(rest, a.v)} solved ${P.deg(rest) === 2 ? 'with the quadratic formula' : 'numerically (Durand–Kerner, Newton-polished)'}` : 'Fully factored'], plots: { graph: plotPoly(a.p, realRoots) } });
    },

    quadratic: (i, c) => {
        const v = [q(i.a), q(i.b), q(i.c)];

        if (v.some((x) => !x)) {
            return need('Enter a, b and c.');
        }

        const [a, b, cc] = v;

        if (R.isZero(a)) {
            if (R.isZero(b)) {
                return fail('With a = b = 0 there is no variable to solve for.');
            }

            const x = R.div(R.neg(cc), b);

            return result(`x = ${t(x)}`, 'Linear equation (a = 0)', { sub: `${t(b)}x + ${t(cc)} = 0`, rows: { disc: 'Not a quadratic', vertex: 'None', nature: 'One root', sum: t(x), product: 'Not a quadratic' }, steps: [`x = −c ÷ b = ${t(x)}`] });
        }

        const qr = P.quadraticRoots(a, b, cc);
        const h = R.div(R.neg(b), R.mul(R.Q(2), a));
        const k = R.sub(cc, R.div(R.mul(b, b), R.mul(R.Q(4), a)));
        const p = [cc, b, a];
        const disc = R.sub(R.mul(b, b), R.mul(R.Q(4), R.mul(a, cc)));
        const mode = c.mode ?? 'roots';
        const rows = { disc: t(disc), vertex: `(${t(h)}, ${t(k)})`, nature: qr.kind, sum: `${t(R.div(R.neg(b), a))} (−b/a)`, product: `${t(R.div(cc, a))} (c/a)` };
        const steps = [`Δ = b² − 4ac = (${t(b)})² − 4(${t(a)})(${t(cc)}) = ${t(disc)}`, `x = (−b ± √Δ) ÷ 2a = (${t(R.neg(b))} ± √${t(disc)}) ÷ ${t(R.mul(R.Q(2), a))}`, `x = ${qr.exact.join(' or ')}`];
        const plot = plotPoly(p, qr.kind.includes('complex') ? [R.toNumber(h)] : qr.values.map((z) => (typeof z === 'number' ? z : z.re)));

        if (mode === 'disc') {
            return result(t(disc), 'Discriminant Δ = b² − 4ac', { sub: R.sign(disc) > 0 ? 'Positive: two real roots' : R.sign(disc) === 0 ? 'Zero: one repeated real root' : 'Negative: two complex roots', rows, steps: steps.slice(0, 1) });
        }

        if (mode === 'square') {
            return result(`${t(a) === '1' ? '' : t(a)}(x ${R.sign(h) > 0 ? '−' : '+'} ${t(R.qabs(h))})² ${R.sign(k) < 0 ? '−' : '+'} ${t(R.qabs(k))}`, 'Completed square (vertex form)', { sub: `Vertex (${t(h)}, ${t(k)})`, rows, steps: [`Take out a = ${t(a)} from the x terms: ${t(a)}(x² + ${t(R.div(b, a))}x) + ${t(cc)}`, `Half of ${t(R.div(b, a))} is ${t(R.div(b, R.mul(R.Q(2), a)))}; add and subtract its square ${t(R.mul(R.div(b, R.mul(R.Q(2), a)), R.div(b, R.mul(R.Q(2), a))))}`, `${t(a)}(x + ${t(R.div(b, R.mul(R.Q(2), a)))})² + ${t(k)}`, `Roots: ${qr.exact.join(', ')}`], plots: { graph: plot } });
        }

        return result(qr.exact.join(',  '), 'Roots', { sub: qr.kind, rows, steps, plots: { graph: plot } });
    },

    cubic: (i) => {
        const v = [q(i.a), q(i.b), q(i.c), q(i.d)];

        if (v.some((x) => !x) || R.isZero(v[0])) {
            return need('Enter a (not zero), b, c and d.');
        }

        const p = [v[3], v[2], v[1], v[0]];
        const { roots: rr, rest } = P.rationalRoots(p);
        const exact = rr.map(([r, m]) => `${t(r)}${m > 1 ? ` (×${m})` : ''}`);

        if (P.deg(rest) === 2) {
            exact.push(...P.quadraticRoots(rest[2], rest[1], rest[0]).exact);
        }

        const all = roots(p);
        const [a, b, c, d] = v.map(R.toNumber);
        const disc = 18 * a * b * c * d - 4 * b ** 3 * d + b * b * c * c - 4 * a * c ** 3 - 27 * a * a * d * d;
        const real = all.filter((z) => z.im === 0).map((z) => z.re);

        return result(exact.length === 3 || (exact.length && P.deg(rest) <= 2) ? exact.join(',  ') : all.map((z) => ctext(z, 12)).join(',  '), 'Roots', { sub: disc > 0 ? 'Three distinct real roots' : disc === 0 ? 'A repeated root' : 'One real root and two complex conjugates', rows: { disc: f(disc, 10), real: real.map((x) => f(x, 12)).join(', '), complex: all.filter((z) => z.im !== 0).map((z) => ctext(z, 10)).join(', ') || 'None', factored: P.factorText(p) }, steps: [`Δ = 18abcd − 4b³d + b²c² − 4ac³ − 27a²d² = ${f(disc, 10)}`, rr.length ? `Rational root${rr.length > 1 ? 's' : ''} ${rr.map(([r]) => t(r)).join(', ')} found by the rational root theorem, then the quadratic formula` : 'No rational roots: Cardano\'s formula / numeric solution', ...all.map((z) => `x = ${ctext(z, 12)}`)], plots: { graph: plotPoly(p, real) } });
    },

    descartes: (i) => {
        const a = readPoly(i.p1);

        if (a.error || P.deg(a.p) < 1) {
            return need(a.error || 'Enter a polynomial.');
        }

        const signs = (p) => p.filter((cf) => !R.isZero(cf)).map((cf) => R.sign(cf));
        const changes = (s) => s.slice(1).filter((x, k) => x !== s[k]).length;
        const pos = changes([...signs(a.p)].reverse());
        const negPoly = a.p.map((cf, k) => (k % 2 ? R.neg(cf) : cf));
        const neg = changes([...signs(negPoly)].reverse());
        const list = (n) => Array.from({ length: Math.floor(n / 2) + 1 }, (_, k) => n - 2 * k).join(', ');
        const actual = roots(a.p).filter((z) => z.im === 0);

        return result(`Positive: ${list(pos)};  negative: ${list(neg)}`, 'Possible numbers of real roots', { sub: `Sign changes: ${pos} in P(x), ${neg} in P(−x)`, rows: { pos: String(pos), neg: String(neg), actual: `${actual.filter((z) => z.re > 0).length} positive and ${actual.filter((z) => z.re < 0).length} negative real roots` }, steps: [`P(x) = ${P.toText(a.p, a.v)}: signs ${[...signs(a.p)].reverse().map((s) => (s > 0 ? '+' : '−')).join(' ')}, ${pos} changes`, `P(−x) = ${P.toText(negPoly, a.v)}: ${neg} changes`, 'Each count can drop by an even number (pairs of complex roots)'] });
    },

    abs_equation: (i) => {
        let tree;

        try {
            tree = parse(i.eq);
        } catch (e) {
            return fail(e instanceof ParseError ? e.message : 'Could not read the equation.');
        }

        if (tree.t !== 'rel' || tree.ops.length !== 1 || tree.ops[0] !== '=') {
            return need('Type an equation such as |2x − 3| = 7.');
        }

        const v = [...variables(tree)][0] ?? 'x';
        let [lhs, rhs] = tree.parts;

        if (!(lhs.t === 'call' && lhs.fn === 'abs') && rhs.t === 'call' && rhs.fn === 'abs') {
            [lhs, rhs] = [rhs, lhs];
        }

        if (!(lhs.t === 'call' && lhs.fn === 'abs')) {
            return need('One side must be an absolute value |…|.');
        }

        const inner = linearOf(lhs.args[0], v);
        const rIsAbs = rhs.t === 'call' && rhs.fn === 'abs';
        const other = linearOf(rIsAbs ? rhs.args[0] : rhs, v);

        if (!inner || !other) {
            return need('The expressions inside must be linear (such as 2x − 3).');
        }

        const sols = new Map();
        const steps = [];
        const solveLin = (A, B) => (R.isZero(A) ? null : R.div(R.neg(B), A));
        const check = (x) => {
            const l = R.qabs(R.add(R.mul(inner.a, x), inner.b));
            const r = R.add(R.mul(other.a, x), other.b);

            return R.eq(l, rIsAbs ? R.qabs(r) : r);
        };

        [1, -1].forEach((s) => {
            // inner = s × other  →  (inner.a − s·other.a) x + (inner.b − s·other.b) = 0
            const A = R.sub(inner.a, R.mul(R.Q(s), other.a));
            const B = R.sub(inner.b, R.mul(R.Q(s), other.b));
            const x = solveLin(A, B);
            steps.push(`Case ${s > 0 ? '+' : '−'}: ${t(inner.a)}${v} + ${t(inner.b)} = ${s > 0 ? '' : '−('}${t(other.a)}${v} + ${t(other.b)}${s > 0 ? '' : ')'} → ${x ? `${v} = ${t(x)}${check(x) ? ' ✓' : ' ✗ (fails the check)'}` : (R.isZero(B) ? 'true for every x' : 'no solution')}`);

            if (x && check(x)) {
                sols.set(t(x), x);
            }
        });

        const list = [...sols.values()].sort(R.cmp);

        return result(list.length ? list.map((x) => `${v} = ${t(x)}`).join(',  ') : 'No solution', 'Solutions', { sub: list.length ? `${list.length} solution${list.length > 1 ? 's' : ''}` : 'An absolute value cannot equal a negative number', rows: { count: String(list.length), check: list.map((x) => `|${t(R.add(R.mul(inner.a, x), inner.b))}| = ${rIsAbs ? `|${t(R.add(R.mul(other.a, x), other.b))}|` : t(R.add(R.mul(other.a, x), other.b))}`).join('; ') || 'None' }, steps, plots: { line: { kind: 'numberline', points: list.map((x) => ({ x: R.toNumber(x), open: false })) } } });
    },

    abs_inequality: (i) => {
        const m = String(i.ineq ?? '').replace(/\s+/g, '').match(/^\|(.+)\|(<=|>=|<|>|≤|≥)(.+)$/);

        if (!m) {
            return need('Type an inequality such as |2x − 3| < 7.');
        }

        let inner;
        let cval;

        try {
            const tree = parse(m[1]);
            const v0 = [...variables(tree)][0] ?? 'x';
            inner = { ...linearOf(tree, v0), v: v0 };
            cval = evalExact(parse(m[3]));
        } catch {
            inner = null;
        }

        if (!inner?.a || !cval) {
            return need('Use a linear expression inside the bars and a number on the right.');
        }

        const op = { '<=': '≤', '>=': '≥' }[m[2]] ?? m[2];
        const lin = (k, o) => S.solveLinearInequality(`${t(inner.a)}*x + ${t(inner.b).replace('−', '-')} ${o} ${t(k).replace('−', '-')}`);
        let set;
        let steps;

        if (op === '<' || op === '≤') {
            if (R.sign(cval) < 0 || (R.isZero(cval) && op === '<')) {
                set = [];
                steps = ['An absolute value is never negative: no solution'];
            } else {
                const lo = lin(R.neg(cval), op === '<' ? '>' : '>=');
                const hi = lin(cval, op === '<' ? '<' : '<=');
                set = S.intersect(lo.intervals, hi.intervals);
                steps = [`−${t(cval)} ${op} ${m[1]} ${op} ${t(cval)}`, ...lo.steps, ...hi.steps];
            }
        } else if (R.sign(cval) < 0) {
            set = [{ lo: S.INF, hi: S.INF, loOpen: true, hiOpen: true }];
            steps = ['An absolute value is always greater than a negative number: every x'];
        } else {
            const lo = lin(R.neg(cval), op === '>' ? '<' : '<=');
            const hi = lin(cval, op === '>' ? '>' : '>=');
            set = S.union(lo.intervals, hi.intervals);
            steps = [`${m[1]} ${op === '>' ? '<' : '≤'} −${t(cval)}  or  ${m[1]} ${op} ${t(cval)}`, ...lo.steps, ...hi.steps];
        }

        return result(S.intervalText(set), 'Solution set', { sub: S.setBuilderText(set, inner.v), rows: { interval: S.intervalText(set), builder: S.setBuilderText(set, inner.v) }, steps, plots: { line: S.numberLine(set) } });
    },

    linear_ineq: (i, c) => {
        const r = S.solveLinearInequality(i.ineq);

        if (r.error) {
            return need(r.error);
        }

        const main = c.mode === 'builder' ? S.setBuilderText(r.intervals, r.variable) : S.intervalText(r.intervals);

        return result(main, c.mode === 'builder' ? 'Set-builder notation' : 'Interval notation', { sub: c.mode === 'builder' ? S.intervalText(r.intervals) : S.setBuilderText(r.intervals, r.variable), rows: { interval: S.intervalText(r.intervals), builder: S.setBuilderText(r.intervals, r.variable) }, steps: r.steps, plots: { line: S.numberLine(r.intervals) } });
    },

    quad_ineq: (i) => {
        const m = String(i.ineq ?? '').replace(/≤/g, '<=').replace(/≥/g, '>=').match(/^(.+?)(<=|>=|<|>)(.+)$/);

        if (!m) {
            return need('Type an inequality such as x² − x − 6 > 0.');
        }

        const a = readPoly(`(${m[1]}) - (${m[3]})`);

        if (a.error || P.deg(a.p) > 2 || P.deg(a.p) < 1) {
            return need(a.error || 'Use a quadratic (or linear) expression.');
        }

        const op = { '<=': '≤', '>=': '≥' }[m[2]] ?? m[2];
        const { roots: rr } = P.rationalRoots(a.p);
        let pts = [];

        if (P.deg(a.p) === 2) {
            const disc = R.sub(R.mul(a.p[1], a.p[1]), R.mul(R.Q(4), R.mul(a.p[2], a.p[0])));

            if (R.sign(disc) >= 0) {
                pts = rr.length ? rr.flatMap(([r, mult]) => Array(mult).fill(r)) : P.quadraticRoots(a.p[2], a.p[1], a.p[0]).values.map((x) => R.fromNumber(x));
            }
        } else {
            pts = [R.div(R.neg(a.p[0]), a.p[1])];
        }

        pts = [...new Map(pts.map((x) => [t(x), x])).values()].sort(R.cmp);
        const exactPts = pts.every((x) => R.toNumber(R.mul(x, R.Q(1))) === R.toNumber(x)) && rr.length;
        const holds = (x) => {
            const val = P.evalNumber(a.p, x);

            return { '<': val < 0, '≤': val <= 1e-12, '>': val > 0, '≥': val >= -1e-12 }[op];
        };
        const bounds = [-Infinity, ...pts.map(R.toNumber), Infinity];
        const set = [];
        const strict = op === '<' || op === '>';

        for (let k = 0; k < bounds.length - 1; k += 1) {
            const lo = bounds[k];
            const hi = bounds[k + 1];
            const mid = Number.isFinite(lo) && Number.isFinite(hi) ? (lo + hi) / 2 : Number.isFinite(lo) ? lo + 1 : Number.isFinite(hi) ? hi - 1 : 0;

            if (holds(mid)) {
                set.push({ lo: k === 0 ? S.INF : pts[k - 1], hi: k === bounds.length - 2 ? S.INF : pts[k], loOpen: strict || k === 0, hiOpen: strict || k === bounds.length - 2 });
            }
        }

        if (!strict) {
            pts.forEach((x) => set.push({ lo: x, hi: x, loOpen: false, hiOpen: false }));
        }

        const norm = S.normalise(set);

        return result(S.intervalText(norm), 'Solution set', { sub: S.setBuilderText(norm, a.v), rows: { interval: S.intervalText(norm), builder: S.setBuilderText(norm, a.v), roots: pts.length ? pts.map((x) => (exactPts ? t(x) : f(R.toNumber(x), 10))).join(', ') : 'No real roots' }, steps: [`f(${a.v}) = ${P.toText(a.p, a.v)} ${op} 0`, `Roots: ${pts.length ? pts.map((x) => f(R.toNumber(x), 10)).join(', ') : 'none (the parabola does not cross the axis)'}`, 'Test a point in each interval and keep where the sign is right'], plots: { graph: plotPoly(a.p, pts.map(R.toNumber)), line: S.numberLine(norm) } });
    },

    system: (i) => {
        const lines = String(i.eqs ?? '').split(/\n|;/).map((l) => l.trim()).filter(Boolean);

        if (lines.length < 2 || lines.length > 6) {
            return need('Enter 2 to 6 linear equations, one per line, such as 2x + 3y = 7.');
        }

        let trees;

        try {
            trees = lines.map((l) => parse(l));
        } catch (e) {
            return fail(e instanceof ParseError ? e.message : 'Could not read the equations.');
        }

        if (trees.some((tr) => tr.t !== 'rel' || tr.ops.length !== 1 || tr.ops[0] !== '=')) {
            return need('Each line must be an equation with one = sign.');
        }

        const vars = [...new Set(trees.flatMap((tr) => [...variables(tr)]))].sort();

        if (!vars.length || vars.length > 6) {
            return need('Use 1 to 6 variables.');
        }

        const rows = [];
        const rhs = [];

        for (const tr of trees) {
            const zero = Object.fromEntries(vars.map((v) => [v, R.ZERO]));
            const diff = { t: 'bin', op: '-', a: tr.parts[0], b: tr.parts[1] };
            const c0 = evalExact(diff, zero);

            if (!c0) {
                return need('The equations must be linear with numeric coefficients.');
            }

            const coeffs = vars.map((v) => {
                const e = evalExact(diff, { ...zero, [v]: R.ONE });

                return e && R.sub(e, c0);
            });

            // Linearity check at another point.
            const twoPt = evalExact(diff, Object.fromEntries(vars.map((v) => [v, R.Q(2)])));
            const predicted = coeffs.reduce((acc, cf) => R.add(acc, R.mul(cf, R.Q(2))), c0);

            if (coeffs.some((cf) => !cf) || !twoPt || !R.eq(twoPt, predicted)) {
                return need('The equations must be linear (no products of variables or powers).');
            }

            rows.push(coeffs);
            rhs.push(R.neg(c0));
        }

        const sol = L.solve(rows, rhs);
        const method = i.method ?? 'elimination';
        const steps = [`Augmented matrix:`, L.show(rows.map((r, k) => [...r, rhs[k]])), method === 'cramer' ? '' : 'Row operations:', ...(method === 'cramer' ? [] : sol.ops)].filter((s) => s !== '');

        if (sol.kind === 'none') {
            return result('No solution', 'Inconsistent system', { sub: 'The equations contradict each other (parallel lines or planes)', rows: { kind: 'Inconsistent', check: 'A row reduces to 0 = non-zero' }, steps });
        }

        if (sol.kind === 'infinite') {
            const free = sol.free.map((j) => vars[j]);

            return result('Infinitely many solutions', 'Dependent system', { sub: `Free variable${free.length > 1 ? 's' : ''}: ${free.join(', ')}`, rows: { kind: 'Dependent', check: vars.map((v, j) => `${v} = ${t(sol.particular[j])}${sol.basis.map((b, k) => (R.isZero(b[j]) ? '' : ` ${R.sign(b[j]) < 0 ? '−' : '+'} ${R.eq(R.qabs(b[j]), R.ONE) ? '' : t(R.qabs(b[j]))}${free[k]}`)).join('')}`).filter((s, j) => !sol.free.includes(j)).join(', ') }, steps });
        }

        if (method === 'cramer' && rows.length === vars.length) {
            const d = L.det(rows);
            steps.push(`D = ${t(d)}`);
            vars.forEach((v, j) => {
                const m = rows.map((r, k) => r.map((cf, c) => (c === j ? rhs[k] : cf)));
                steps.push(`D${v} = ${t(L.det(m))}  →  ${v} = ${t(L.det(m))} ÷ ${t(d)} = ${t(sol.x[j])}`);
            });
        }

        return result(vars.map((v, j) => `${v} = ${t(sol.x[j])}`).join(',  '), 'Solution', { sub: 'Unique solution', rows: { kind: 'Unique', check: lines.map((l) => `${l} ✓`).join('; ') }, steps });
    },

    partial_fractions: (i) => {
        const n = readPoly(i.num);
        const d = readPoly(i.den);

        if (n.error || d.error) {
            return need(n.error || d.error);
        }

        if (P.deg(d.p) < 1) {
            return need('The denominator must contain the variable.');
        }

        const g = P.gcd(n.p, d.p);

        if (P.deg(g) > 0) {
            return fail(`The fraction can be simplified first: numerator and denominator share the factor ${P.toText(g, d.v)}.`);
        }

        const r = partialFractions(n.p, d.p, d.v);

        if (r.error) {
            return fail(r.error);
        }

        const text = [...(P.isZeroPoly(r.poly) || !r.poly.length ? [] : [P.toText(r.poly, d.v)]), ...r.pieces].join(' + ').replace(/\+ −/g, '− ');

        return result(text, 'Partial fractions', { sub: `Denominator ${P.factorText(d.p, d.v)}`, rows: { factored: P.factorText(d.p, d.v), coefficients: r.unknowns.join(', ') }, steps: [r.poly.length && !P.isZeroPoly(r.poly) ? `Divide first: polynomial part ${P.toText(r.poly, d.v)}` : 'Proper fraction: no division needed', `Factor the denominator: ${P.factorText(d.p, d.v)}`, 'One term A/(x − r)ᵏ per linear factor power, (Bx + C)/qᵏ per quadratic factor', 'Multiply through and match coefficients:', ...r.unknowns] });
    },

    diamond: (i) => {
        const prod = q(i.product);
        const sum = q(i.sum);

        if (!prod || !sum) {
            return need('Enter the product (top) and the sum (bottom).');
        }

        const disc = R.sub(R.mul(sum, sum), R.mul(R.Q(4), prod));
        const qr = P.quadraticRoots(R.ONE, R.neg(sum), prod);

        return result(qr.exact.join(' and '), 'The two numbers', { sub: R.sign(disc) < 0 ? 'No real pair: the numbers are complex' : `They multiply to ${t(prod)} and add to ${t(sum)}`, rows: { equation: `${P.toText([prod, R.neg(sum), R.ONE], 't')} = 0`, check: qr.kind }, steps: [`The numbers are the roots of t² − St + P = 0`, `t = (S ± √(S² − 4P)) ÷ 2 = ${qr.exact.join(', ')}`] });
    },

    variation: (i, c) => {
        const x1 = q(i.x1);
        const y1 = q(i.y1);
        const x2 = q(i.x2);

        if (!x1 || !y1 || !x2) {
            return need('Enter a known pair (x₁, y₁) and the new x.');
        }

        const inverse = c.kind === 'inverse';

        if (inverse && R.isZero(x2)) {
            return fail('x cannot be zero in inverse variation.');
        }

        const k = inverse ? R.mul(x1, y1) : R.isZero(x1) ? null : R.div(y1, x1);

        if (!k) {
            return fail('x₁ cannot be zero in direct variation.');
        }

        const y2 = inverse ? R.div(k, x2) : R.mul(k, x2);
        const series = Array.from({ length: 61 }, (_, j) => {
            const x = (R.toNumber(x2) || 1) * (j / 30) * 1.5 + (inverse ? 0.05 : 0);

            return [x, inverse ? R.toNumber(k) / x : R.toNumber(k) * x];
        });

        return result(`y = ${t(y2)}`, `When x = ${t(x2)}`, { sub: inverse ? `y = ${t(k)}/x` : `y = ${R.isInt(k) ? t(k) : `(${t(k)})`}x`, rows: { k: t(k), equation: inverse ? `y = ${t(k)} ÷ x` : `y = ${R.isInt(k) ? t(k) : `(${t(k)})`}x`, decimal: dec(y2) }, steps: [inverse ? `k = x₁y₁ = ${t(x1)} × ${t(y1)} = ${t(k)}` : `k = y₁ ÷ x₁ = ${t(y1)} ÷ ${t(x1)} = ${t(k)}`, inverse ? `y = ${t(k)} ÷ ${t(x2)} = ${t(y2)}` : `y = ${t(k)} × ${t(x2)} = ${t(y2)}`], plots: { graph: { series, xLabel: 'x', yLabel: 'y', markers: [{ x: R.toNumber(x2), y: R.toNumber(y2), label: `(${dec(x2)}, ${dec(y2)})` }] } } });
    },

    exponential_eq: (i) => {
        const [a, b, p, qq, c] = [i.a, i.b, i.p, i.q, i.c].map(Number);

        if (![a, b, p, qq, c].every(Number.isFinite) || a === 0 || b <= 0 || b === 1 || p === 0) {
            return need('Enter a ≠ 0, a base b > 0 (not 1), p ≠ 0, q and c.');
        }

        const ratio = c / a;

        if (ratio <= 0) {
            return result('No real solution', `${f(a)} · ${f(b)}^(${f(p)}x + ${f(qq)}) = ${f(c)}`, { sub: 'A power of a positive base is always positive', rows: { exact: 'None', check: 'c ÷ a must be positive' }, steps: [`c ÷ a = ${f(ratio)} ≤ 0`] });
        }

        const x = (Math.log(ratio) / Math.log(b) - qq) / p;

        return result(`x = ${f(x, 12)}`, `${f(a)} · ${f(b)}^(${p === 1 ? '' : p === -1 ? '−' : f(p)}x ${qq < 0 ? '−' : '+'} ${f(Math.abs(qq))}) = ${f(c)}`, { sub: `x = (log_${f(b)}(${f(ratio)}) − ${f(qq)}) ÷ ${f(p)}`, rows: { exact: `(ln(${f(ratio)}) ÷ ln(${f(b)}) − ${f(qq)}) ÷ ${f(p)}`, check: `${f(a)} × ${f(b)}^${f(p * x + qq, 10)} = ${f(a * b ** (p * x + qq), 10)}` }, steps: [`Divide by ${f(a)}: ${f(b)}^(${f(p)}x + ${f(qq)}) = ${f(ratio)}`, `Take logs: (${f(p)}x + ${f(qq)}) ln ${f(b)} = ln ${f(ratio)}`, `${f(p)}x + ${f(qq)} = ${f(Math.log(ratio) / Math.log(b), 12)}`, `x = ${f(x, 12)}`] });
    },
};

export default defineTools(handlers);
