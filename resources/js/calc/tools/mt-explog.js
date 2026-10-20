import { defineTools } from '../engines/formula.js';
import { exactRoot, parse, ParseError, show } from '../math/expr.js';
import { simplifySqrt } from '../math/poly.js';
import { dec, f, fail, need, q, R, result } from '../math/util.js';

/**
 * Exponents, radicals and logarithms: powers solved for any unknown, exponent rules shown with your numbers,
 * radicals multiplied and divided in simplest form, logarithms in any base, change of base, expanding and
 * condensing logarithms by the product, quotient and power rules, and exponential growth and functions.
 */
const t = R.toFraction;

function logb(x, b) {
    if (b === 10) {
        return Math.log10(x);
    }

    if (b === 2) {
        return Math.log2(x);
    }

    if (b === Math.E) {
        return Math.log(x);
    }

    return Math.log(x) / Math.log(b);
}

/** Exact integer logarithm when x is a power of b (both rationals). */
function exactLog(x, b) {
    if (!x || !b || R.sign(x) <= 0 || R.sign(b) <= 0 || R.eq(b, R.ONE)) {
        return null;
    }

    for (let k = -64; k <= 64; k += 1) {
        if (R.eq(R.pow(b, k), x)) {
            return k;
        }
    }

    return null;
}

const baseText = (b) => (b === 'e' ? 'ln' : b === '10' ? 'log' : `log${R.subscript(b)}`);

/** Expands log(arg) into a sum by the product, quotient and power rules. */
function expandLog(node, coef, out) {
    if (node.t === 'bin' && node.op === '*') {
        expandLog(node.a, coef, out);
        expandLog(node.b, coef, out);
    } else if (node.t === 'bin' && node.op === '/') {
        expandLog(node.a, coef, out);
        expandLog(node.b, R.neg(coef), out);
    } else if (node.t === 'bin' && node.op === '^' && node.b.t === 'num') {
        expandLog(node.a, R.mul(coef, node.b.v), out);
    } else if (node.t === 'bin' && node.op === '^' && node.b.t === 'neg' && node.b.a.t === 'num') {
        expandLog(node.a, R.mul(coef, R.neg(node.b.a.v)), out);
    } else if (node.t === 'call' && node.fn === 'sqrt') {
        expandLog(node.args[0], R.mul(coef, R.Q(1, 2)), out);
    } else if (node.t === 'call' && node.fn === 'cbrt') {
        expandLog(node.args[0], R.mul(coef, R.Q(1, 3)), out);
    } else {
        out.push([coef, node]);
    }
}

function coefText(c, first) {
    const sign = R.sign(c) < 0 ? '−' : '+';
    const abs = R.qabs(c);
    const num = R.eq(abs, R.ONE) ? '' : abs.d === 1n ? t(abs) : `(${t(abs)})`;

    return first ? `${sign === '−' ? '−' : ''}${num}` : ` ${sign} ${num}`;
}

export const handlers = {
    power: (i, c) => {
        const solveFor = c.solve ?? i.solve ?? 'result';
        const a = q(i.base);
        const n = q(i.exp);
        const r = q(i.result);

        if (solveFor === 'result') {
            if (!a || !n) {
                return need('Enter the base and the exponent.');
            }

            if (R.isZero(a) && R.sign(n) <= 0) {
                return fail(R.isZero(n) ? '0⁰ is undefined here (it is often taken as 1 by convention).' : 'Zero to a negative power is undefined.');
            }

            if (R.isInt(n) && R.babs(n.n) <= 10000n) {
                const v = R.pow(a, n.n);
                const s = t(v);

                return result(s.length > 60 ? `${dec(v).slice(0, 20)}… (${R.babs(v.n).toString().length} digits)` : R.isInt(v) ? R.fmt(v.n) : `${s} (${dec(v)})`, `${t(a)}${R.sup(n.n)}`, { sub: n.n < 0n ? `= 1 ÷ ${t(a)}${R.sup(-n.n)}` : n.n === 0n ? 'Any non-zero number to the power 0 is 1' : `${t(a)} multiplied by itself ${n.n} times`, rows: { exact: s.length > 60 ? `${R.babs(v.n).toString().length} digits` : s, decimal: f(R.toNumber(v), 12), scientific: f(R.toNumber(v), 8) }, steps: [n.n < 0n ? `${t(a)}${R.sup(n.n)} = 1 ÷ ${t(a)}${R.sup(-n.n)}` : `${t(a)}${R.sup(n.n)} = ${Array(Math.min(Number(R.babs(n.n)), 8)).fill(t(a).includes('/') || t(a).startsWith('−') ? `(${t(a)})` : t(a)).join(' × ')}${R.babs(n.n) > 8n ? ' × …' : ''}`, `= ${s.length > 80 ? `${s.slice(0, 80)}…` : s}`] });
            }

            const root = exactRoot(R.qabs(a), Number(n.d));
            const v = root && R.sign(a) >= 0 ? R.pow(root, n.n) : null;
            const x = R.toNumber(a) ** R.toNumber(n);

            return result(v ? t(v) : f(x, 12), `${t(a)}^(${t(n)})`, { sub: `= (${n.d === 2n ? '√' : `${R.sup(n.d)}√`}${t(a)})${R.sup(n.n)}`, rows: { exact: v ? t(v) : 'Irrational', decimal: f(x, 15), scientific: f(x, 8) }, steps: [`a^(m/n) = (ⁿ√a)^m`, v ? `= ${t(v)}` : `≈ ${f(x, 15)}`] });
        }

        if (solveFor === 'exp') {
            if (!a || !r || R.sign(a) <= 0 || R.eq(a, R.ONE) || R.sign(r) <= 0) {
                return need('Enter a positive base (not 1) and a positive result.');
            }

            const e = exactLog(r, a);
            const x = Math.log(R.toNumber(r)) / Math.log(R.toNumber(a));

            return result(e !== null ? f(e) : f(x, 12), `Exponent: ${t(a)}ˣ = ${t(r)}`, { sub: `x = log${R.subscript(t(a))}(${t(r)})`, rows: { exact: e !== null ? f(e) : `ln ${t(r)} ÷ ln ${t(a)}`, decimal: f(x, 15), scientific: `${t(a)}^${f(x, 10)} = ${f(R.toNumber(a) ** x, 10)}` }, steps: [`Take logarithms: x = ln(${t(r)}) ÷ ln(${t(a)}) = ${f(x, 15)}`] });
        }

        if (!n || !r || R.isZero(n)) {
            return need('Enter the exponent (not 0) and the result.');
        }

        const root = R.isInt(n) ? exactRoot(R.qabs(r), Number(R.babs(n.n))) : null;
        const sign = R.sign(r) < 0 && R.isInt(n) && n.n % 2n !== 0n ? -1 : 1;
        const x = sign * Math.abs(R.toNumber(r)) ** (1 / R.toNumber(n));

        return result(root ? t(R.mul(R.Q(sign), n.n < 0n ? R.inv(root) : root)) : f(x, 12), `Base: b${R.sup(t(n).replace('/', ''))} = ${t(r)}`, { sub: `b = ${t(r)}^(1/${t(n)})`, rows: { exact: root ? t(R.mul(R.Q(sign), n.n < 0n ? R.inv(root) : root)) : 'Irrational', decimal: f(x, 15), scientific: `${x < 0 ? `(${f(x, 10)})` : f(x, 10)}^${t(n)} = ${f(sign < 0 ? -(Math.abs(x) ** R.toNumber(n)) : x ** R.toNumber(n), 10)}` }, steps: [`b = ${t(r)}^(1/${t(n)}) = ${f(x, 15)}`] });
    },

    rule: (i, c) => {
        const base = String(i.base ?? 'a').trim() || 'a';
        const m = q(i.m);
        const n = q(i.n);

        if (!m || !n) {
            return need('Enter both exponents.');
        }

        const rule = c.rule;
        const out = rule === 'divide' ? R.sub(m, n) : rule === 'multiply' ? R.add(m, n) : R.mul(m, n);
        const expr = rule === 'divide' ? `${base}${R.sup(t(m))} ÷ ${base}${R.sup(t(n))}` : rule === 'multiply' ? `${base}${R.sup(t(m))} × ${base}${R.sup(t(n))}` : `(${base}${R.sup(t(m))})${R.sup(t(n))}`;
        const numBase = q(base);
        const value = numBase && R.isInt(out) && R.babs(out.n) < 2000n && !(R.isZero(numBase) && R.sign(out) < 0) ? R.pow(numBase, out.n) : null;
        const ruleText = rule === 'divide' ? 'aᵐ ÷ aⁿ = aᵐ⁻ⁿ' : rule === 'multiply' ? 'aᵐ × aⁿ = aᵐ⁺ⁿ' : '(aᵐ)ⁿ = aᵐⁿ';

        return result(`${base}${R.isInt(out) ? R.sup(out.n) : `^(${t(out)})`}`, expr, { sub: value ? `= ${t(value)}` : ruleText, rows: { rule: ruleText, exponent: t(out), value: value ? (t(value).length > 40 ? `${t(value).length} digits` : t(value)) : 'Enter a number as the base to evaluate', negative: R.sign(out) < 0 ? `${base}${R.sup(t(out))} = 1/${base}${R.sup(t(R.neg(out)))}` : 'Exponent is not negative' }, steps: [ruleText, `Exponent: ${t(m)} ${rule === 'divide' ? '−' : rule === 'multiply' ? '+' : '×'} ${t(n)} = ${t(out)}`] });
    },

    radicals: (i, c) => {
        const k = Math.round(Number(i.index ?? 2));
        const a = N2(i.c1);
        const b = N2(i.c2);
        const x = N2(i.r1);
        const y = N2(i.r2);

        if ([a, b, x, y].some((v) => v === null) || x < 0n || y < 0n || k < 2) {
            return need('Enter whole-number coefficients and radicands, and a root index of 2 or more.');
        }

        const sym = k === 2 ? '√' : k === 3 ? '∛' : `${R.sup(k)}√`;
        const steps = [];
        let coef;
        let rad;
        let den = 1n;

        if (c.op === 'divide') {
            if (b === 0n || y === 0n) {
                return fail('Cannot divide by zero.');
            }

            // a·ᵏ√x ÷ (b·ᵏ√y) = (a/b)·ᵏ√(x/y) = (a/b)·ᵏ√(x·y^(k−1)) / y
            const g = R.bgcd(x, y);
            const xx = x / g;
            const yy = y / g;
            const [out, inside] = simplifySqrt(xx * yy ** BigInt(k - 1), BigInt(k));
            const frac = R.Q(a * out, b * yy);
            coef = frac.n;
            den = frac.d;
            rad = inside;
            steps.push(`Combine: (${a}/${b}) ${sym}(${x}/${y}) = (${a}/${b}) ${sym}(${xx}/${yy})`);
            steps.push(`Rationalise: ${sym}(${xx}/${yy}) = ${sym}(${xx * yy ** BigInt(k - 1)})/${yy}`);
            steps.push(`Simplify ${sym}${xx * yy ** BigInt(k - 1)} = ${out}${sym}${inside}`);
        } else {
            const [out, inside] = simplifySqrt(x * y, BigInt(k));
            coef = a * b * out;
            rad = inside;
            steps.push(`Multiply the coefficients and the radicands: ${a * b}${sym}${x * y}`);
            steps.push(`Simplify ${sym}${x * y} = ${out}${sym}${inside}`);
        }

        const text = `${rad === 1n ? '' : ''}${coef === 1n && rad !== 1n ? '' : coef === -1n && rad !== 1n ? '−' : coef}${rad === 1n ? '' : `${sym}${rad}`}${den === 1n ? '' : `/${den}`}`;
        const value = (Number(a) * Number(x) ** (1 / k)) / (c.op === 'divide' ? Number(b) * Number(y) ** (1 / k) : 1) * (c.op === 'divide' ? 1 : Number(b) * Number(y) ** (1 / k));

        return result(text || '1', 'Simplest form', { sub: f(value, 12), rows: { decimal: f(value, 15), rule: c.op === 'divide' ? 'ᵏ√x ÷ ᵏ√y = ᵏ√(x/y)' : 'ᵏ√x × ᵏ√y = ᵏ√(xy)' }, steps });
    },

    log: (i, c) => {
        const b = c.base ?? i.base ?? '10';
        const bNum = b === 'e' ? Math.E : Number(R.toNumber(q(b) ?? R.Q(10)));
        const x = q(i.x);

        if (!x || R.sign(x) <= 0) {
            return need('Enter a positive number (logarithms of zero and negatives are undefined).');
        }

        if (!(bNum > 0) || bNum === 1) {
            return need('The base must be positive and not 1.');
        }

        const v = logb(R.toNumber(x), bNum);
        const e = b === 'e' ? null : exactLog(x, q(b));
        const neg = c.negative;

        return result(neg ? f(-v, 13) : e !== null ? f(e) : f(v, 13), neg ? `−log(${dec(x)})` : `${baseText(b)}(${dec(x)})`, { sub: neg ? `log(${dec(x)}) = ${f(v, 12)}` : e !== null ? `${b}${R.sup(e)} = ${dec(x)}` : `${b === 'e' ? 'e' : b}^${f(v, 10)} = ${dec(x)}`, rows: { ln: f(Math.log(R.toNumber(x)), 14), log10: f(Math.log10(R.toNumber(x)), 14), log2: f(Math.log2(R.toNumber(x)), 14), check: `${b === 'e' ? 'e' : b}^${f(v, 12)} = ${f(bNum ** v, 12)}` }, steps: [`${baseText(b)}(x) = ln(x) ÷ ln(${b})`, `= ${f(Math.log(R.toNumber(x)), 15)} ÷ ${f(Math.log(bNum), 15)} = ${f(v, 15)}`] });
    },

    antilog: (i) => {
        const bText = String(i.base ?? '10').trim();
        const b = bText === 'e' ? Math.E : Number(bText);
        const y = Number(i.y);

        if (!Number.isFinite(y) || !(b > 0) || b === 1) {
            return need('Enter the logarithm value and a base (positive, not 1).');
        }

        const v = b ** y;
        const exact = Number.isInteger(y) && Number.isInteger(b) && Math.abs(y) < 400 ? (y >= 0 ? R.fmt(BigInt(b) ** BigInt(y)) : `1/${R.fmt(BigInt(b) ** BigInt(-y))}`) : null;

        return result(exact && exact.length < 40 ? exact : f(v, 13), `Antilog${R.subscript(bText)}(${f(y)})`, { sub: `${bText}^${f(y)}`, rows: { decimal: f(v, 15), check: `log${R.subscript(bText)}(${f(v, 10)}) = ${f(Math.log(v) / Math.log(b), 12)}` }, steps: [`antilog_b(y) = b^y = ${bText}^${f(y)} = ${f(v, 15)}`] });
    },

    exp_e: (i) => {
        const x = Number(i.x);

        if (!Number.isFinite(x)) {
            return need('Enter x.');
        }

        const v = Math.exp(x);

        return result(f(v, 14), `e^${f(x)}`, { sub: 'e = 2.718281828459045…', rows: { inverse: `ln(${f(v, 10)}) = ${f(x)}`, reciprocal: `e^${f(-x)} = ${f(Math.exp(-x), 12)}`, series: `1 + x + x²/2! + x³/3! + … ≈ ${f(Array.from({ length: 30 }, (_, k) => x ** k / Array.from({ length: k }, (__, j) => j + 1).reduce((p, n) => p * n, 1)).reduce((a, b) => a + b, 0), 12)}` }, steps: ['eˣ = Σ xⁿ/n!'] });
    },

    change_base: (i) => {
        const x = Number(i.x);
        const b = Number(i.b);
        const cBase = i.c === 'e' ? Math.E : Number(i.c || 10);

        if (!(x > 0) || !(b > 0) || b === 1 || !(cBase > 0) || cBase === 1) {
            return need('Enter a positive number, a base b and a new base c (both positive, not 1).');
        }

        const v = Math.log(x) / Math.log(b);

        return result(f(v, 13), `log${R.subscript(f(b))}(${f(x)})`, { sub: i.c === 'e' ? `= ln(${f(x)}) ÷ ln(${f(b)})` : `= log${R.subscript(f(cBase))}(${f(x)}) ÷ log${R.subscript(f(cBase))}(${f(b)})`, rows: { top: f(Math.log(x) / Math.log(cBase), 14), bottom: f(Math.log(b) / Math.log(cBase), 14), rule: 'log_b(x) = log_c(x) ÷ log_c(b)' }, steps: [`log${R.subscript(f(cBase))}(${f(x)}) = ${f(Math.log(x) / Math.log(cBase), 15)}`, `log${R.subscript(f(cBase))}(${f(b)}) = ${f(Math.log(b) / Math.log(cBase), 15)}`, `Divide: ${f(v, 15)}`] });
    },

    exp_form: (i) => {
        const b = String(i.b ?? '').trim();
        const x = String(i.x ?? '').trim();
        const y = String(i.y ?? '').trim();

        if (!b || !x || !y) {
            return need('Enter the base, the number and the exponent.');
        }

        const [bq, xq, yq] = [q(b), q(x), q(y)].map((v) => (v ? R.toNumber(v) : NaN));
        const ok = bq > 0 && xq > 0 && Number.isFinite(yq) ? Math.abs(bq ** yq - xq) < 1e-9 * Math.max(1, xq) : null;
        const power = /^-?\d+$/.test(y) ? `${b}${R.sup(y)}` : `${b}^(${y})`;

        return result(`${power} = ${x}`, 'Exponential form', { sub: `log${R.subscript(b)}(${x}) = ${y}`, rows: { log: `log${R.subscript(b)}(${x}) = ${y}`, exp: `${power} = ${x}`, check: ok === null ? 'Enter numbers to check' : ok ? 'True' : `False: ${power} = ${f(bq ** yq, 10)}` }, steps: ['log_b(x) = y means bʸ = x', `log${R.subscript(b)}(${x}) = ${y}  ⇔  ${power} = ${x}`] });
    },

    exp_function: (i) => {
        const [x1, y1, x2, y2] = [i.x1, i.y1, i.x2, i.y2].map(Number);

        if (![x1, y1, x2, y2].every(Number.isFinite) || x1 === x2 || y1 <= 0 || y2 <= 0) {
            return need('Enter two points with different x and positive y.');
        }

        const b = (y2 / y1) ** (1 / (x2 - x1));
        const a = y1 / b ** x1;
        const series = Array.from({ length: 61 }, (_, k) => {
            const x = Math.min(x1, x2) - 1 + ((Math.abs(x2 - x1) + 2) * k) / 60;

            return [x, a * b ** x];
        });

        return result(`f(x) = ${f(a, 8)} × ${f(b, 8)}ˣ`, 'Exponential function through the points', { sub: b > 1 ? `Growth of ${f((b - 1) * 100, 6)}% per unit of x` : `Decay of ${f((1 - b) * 100, 6)}% per unit of x`, rows: { a: f(a, 12), b: f(b, 12), k: `${f(Math.log(b), 10)} (f(x) = a e^(kx))`, double: b > 1 ? `Doubles every ${f(Math.log(2) / Math.log(b), 8)}` : `Halves every ${f(Math.log(0.5) / Math.log(b), 8)}` }, steps: [`b = (y₂/y₁)^(1/(x₂ − x₁)) = (${f(y2)}/${f(y1)})^(1/${f(x2 - x1)}) = ${f(b, 12)}`, `a = y₁ ÷ b^x₁ = ${f(a, 12)}`], plots: { graph: { series, xLabel: 'x', yLabel: 'f(x)', markers: [{ x: x1, y: y1 }, { x: x2, y: y2 }] } } });
    },

    growth: (i) => {
        const solve = i.solve ?? 'final';
        const [P0, r, tt, Pt] = [i.p0, i.rate, i.t, i.pt].map(Number);
        const cont = i.model === 'continuous';
        const g = (rate) => (cont ? Math.exp(rate / 100) : 1 + rate / 100);
        let out;
        let label;

        if (solve === 'final') {
            if (![P0, r, tt].every(Number.isFinite)) {
                return need('Enter the initial value, rate and time.');
            }

            out = P0 * g(r) ** tt;
            label = 'Final value';
        } else if (solve === 'rate') {
            if (![P0, tt, Pt].every(Number.isFinite) || P0 <= 0 || Pt <= 0 || tt === 0) {
                return need('Enter positive initial and final values and a non-zero time.');
            }

            out = cont ? (Math.log(Pt / P0) / tt) * 100 : ((Pt / P0) ** (1 / tt) - 1) * 100;
            label = 'Growth rate per period (%)';
        } else if (solve === 'time') {
            if (![P0, r, Pt].every(Number.isFinite) || P0 <= 0 || Pt <= 0 || r === 0) {
                return need('Enter positive initial and final values and a non-zero rate.');
            }

            out = Math.log(Pt / P0) / Math.log(g(r));
            label = 'Time (periods)';
        } else {
            if (![r, tt, Pt].every(Number.isFinite)) {
                return need('Enter the rate, time and final value.');
            }

            out = Pt / g(r) ** tt;
            label = 'Initial value';
        }

        const p0 = solve === 'initial' ? out : P0;
        const rate = solve === 'rate' ? out : r;
        const time = solve === 'time' ? out : tt;
        const series = Array.from({ length: 51 }, (_, k) => [(time * k) / 50, p0 * g(rate) ** ((time * k) / 50)]);

        return result(f(out, 10), label, { sub: cont ? `P(t) = P₀e^(rt), r = ${f(rate, 8)}%` : `P(t) = P₀(1 + r)ᵗ, r = ${f(rate, 8)}%`, rows: { formula: cont ? 'P = P₀ e^(rt)' : 'P = P₀ (1 + r)ᵗ', double: rate > 0 ? `Doubling time ${f(Math.log(2) / Math.log(g(rate)), 8)}` : rate < 0 ? `Half-life ${f(Math.log(0.5) / Math.log(g(rate)), 8)}` : 'No change', factor: `× ${f(g(rate), 10)} per period` }, steps: [`Growth factor per period: ${f(g(rate), 12)}`, `${label}: ${f(out, 12)}`], plots: { graph: { series, xLabel: 'Time', yLabel: 'Value' } } });
    },

    expand_log: (i, c) => {
        const b = String(i.base ?? '10').trim() || '10';
        const name = baseText(b);

        if (c.mode === 'condense') {
            const text = String(i.expr ?? '').replace(/\s+/g, '').replace(/[−–]/g, '-');
            const re = /([+-]?)(\d+(?:\/\d+)?|\d*\.\d+)?\*?(?:log|ln)(?:_?\d+|_e)?\(([^()]+(?:\([^()]*\))?[^()]*)\)/gi;
            const terms = [];
            let m;
            let used = '';

            while ((m = re.exec(text)) !== null) {
                terms.push([R.mul(R.Q(m[1] === '-' ? -1 : 1), m[2] ? R.parseNumber(m[2]) : R.ONE), m[3]]);
                used += m[0];
            }

            if (!terms.length || used.replace(/^\+/, '') !== text.replace(/^\+/, '')) {
                return need('Type a sum of logarithms with the same base, such as 2log(x) + log(y) − 3log(z).');
            }

            const factor = (cf, arg) => {
                const a = /^[\w.]+$/.test(arg) ? arg : `(${arg})`;
                const p = R.qabs(cf);

                return R.eq(p, R.ONE) ? a : p.d === 1n ? `${a}${R.sup(p.n)}` : p.n === 1n && p.d === 2n ? `√${a}` : `${a}^(${t(p)})`;
            };
            const top = terms.filter(([cf]) => R.sign(cf) > 0).map(([cf, a]) => factor(cf, a));
            const bottom = terms.filter(([cf]) => R.sign(cf) < 0).map(([cf, a]) => factor(cf, a));
            const inner = `${top.join('') || '1'}${bottom.length ? `/${bottom.length > 1 ? `(${bottom.join('')})` : bottom[0]}` : ''}`;

            return result(`${name}(${inner})`, 'Condensed', { sub: 'Product, quotient and power rules', rows: { rules: 'log(xy) = log x + log y; log(x/y) = log x − log y; k log x = log xᵏ', terms: String(terms.length) }, steps: [...terms.map(([cf, a]) => `${t(cf)} ${name}(${a}) = ${R.sign(cf) < 0 ? '−' : ''}${name}(${factor(cf, a)})`), `Add the positive terms (product) and subtract the negative ones (quotient)`, `${name}(${inner})`] });
        }

        let tree;

        try {
            tree = parse(i.expr);
        } catch (e) {
            return fail(e instanceof ParseError ? e.message : 'Could not read the argument.');
        }

        const out = [];
        expandLog(tree, R.ONE, out);
        const merged = [];

        out.forEach(([cf, node]) => {
            const key = show(node);
            const ex = merged.find((m) => m[1] === key);

            if (ex) {
                ex[0] = R.add(ex[0], cf);
            } else {
                merged.push([cf, key, node]);
            }
        });

        const text = merged.filter(([cf]) => !R.isZero(cf)).map(([cf, key, node], k) => `${coefText(cf, k === 0)}${name}${['var', 'num', 'const'].includes(node.t) ? ` ${key}` : `(${key})`}`).join('');

        return result(text, 'Expanded', { sub: `${name}(${show(tree)})`, rows: { rules: 'log(xy) = log x + log y; log(x/y) = log x − log y; log(xᵏ) = k log x', terms: String(merged.length) }, steps: [`${name}(${show(tree)})`, 'Products become sums, quotients differences, powers and roots coefficients', `= ${text}`] });
    },
};

function N2(v) {
    const s = String(v ?? '').trim().replace(/[−–]/g, '-');

    return /^-?\d+$/.test(s) ? BigInt(s) : null;
}

export default defineTools(handlers);
