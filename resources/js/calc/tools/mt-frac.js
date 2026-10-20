import { defineTools } from '../engines/formula.js';
import { evalExact, exactRoot, parse, ParseError, show } from '../math/expr.js';
import { both, dec, f, fail, need, q, qs, R, result } from '../math/util.js';

/**
 * Fraction tools on exact rationals: arithmetic with the usual school steps (common denominators, cancelling,
 * keep-change-flip), simplifying, equivalent fractions, mixed numbers, decimals (with repeating blocks),
 * comparisons, LCD, ratios, proportions, unit rates, the golden ratio and continued fractions.
 */
const t = R.toFraction;
const mixed = R.toMixed;

function parseFraction(text) {
    const x = q(text);

    if (x) {
        return x;
    }

    try {
        return evalExact(parse(text));
    } catch {
        return null;
    }
}

function opSteps(a, op, b) {
    const steps = [];
    let r;

    if (op === '+' || op === '-') {
        const l = R.blcm(a.d, b.d);
        const an = a.n * (l / a.d);
        const bn = b.n * (l / b.d);
        r = op === '+' ? R.add(a, b) : R.sub(a, b);

        if (a.d !== 1n || b.d !== 1n) {
            steps.push(`Common denominator: LCD(${a.d}, ${b.d}) = ${l}`);
            steps.push(`${t(a)} = ${an}/${l},  ${t(b)} = ${bn}/${l}`);
        }

        const top = op === '+' ? an + bn : an - bn;
        steps.push(`${an} ${op === '+' ? '+' : '−'} ${bn < 0n ? `(${bn})` : bn} = ${top}  →  ${top}/${l}`);

        if (R.bgcd(top, l) > 1n) {
            steps.push(`Simplify by ${R.bgcd(top, l)}: ${t(r)}`);
        }
    } else if (op === '*') {
        r = R.mul(a, b);
        steps.push(`Multiply tops and bottoms: (${a.n} × ${b.n}) / (${a.d} × ${b.d}) = ${a.n * b.n}/${a.d * b.d}`);

        if (R.bgcd(a.n * b.n, a.d * b.d) > 1n) {
            steps.push(`Simplify by ${R.bgcd(a.n * b.n, a.d * b.d)}: ${t(r)}`);
        }
    } else {
        if (R.isZero(b)) {
            return { error: 'Division by zero.' };
        }

        r = R.div(a, b);
        steps.push(`Keep, change, flip: ${t(a)} ÷ ${t(b)} = ${t(a)} × ${t(R.inv(b))}`);
        steps.push(`= ${a.n * b.d}/${a.d * b.n}${R.bgcd(a.n * b.d, a.d * b.n) > 1n ? ` = ${t(r)}` : ''}`);
    }

    return { r, steps };
}

function cfExpand(x, limit = 30) {
    const terms = [];
    let n = x.n;
    let d = x.d;

    while (d !== 0n && terms.length < limit) {
        const a = R.bfloor(n, d);
        terms.push(a);
        [n, d] = [d, n - a * d];
    }

    return terms;
}

function convergents(terms) {
    let [h1, h2, k1, k2] = [1n, 0n, 0n, 1n];

    return terms.map((a) => {
        const h = a * h1 + h2;
        const k = a * k1 + k2;
        [h2, h1, k2, k1] = [h1, h, k1, k];

        return R.Q(h, k);
    });
}

/** Periodic continued fraction of √n: [a0; (a1 … ak)]. */
function sqrtCf(n) {
    const a0 = BigInt(Math.floor(Math.sqrt(Number(n))));
    let fixed = a0;

    while (fixed * fixed > n) {
        fixed -= 1n;
    }

    while ((fixed + 1n) ** 2n <= n) {
        fixed += 1n;
    }

    if (fixed * fixed === n) {
        return { a0: fixed, period: [] };
    }

    let m = 0n;
    let d = 1n;
    let a = fixed;
    const period = [];

    do {
        m = d * a - m;
        d = (n - m * m) / d;
        a = (fixed + m) / d;
        period.push(a);
    } while (a !== 2n * fixed && period.length < 200);

    return { a0: fixed, period };
}

export const handlers = {
    expression: (i) => {
        const text = String(i.expr ?? '').trim();

        if (!text) {
            return need('Type a fraction expression such as 3/4 + 5/6.');
        }

        let tree;

        try {
            tree = parse(text);
        } catch (e) {
            return fail(e instanceof ParseError ? e.message : 'Could not read the expression.');
        }

        const r = evalExact(tree);

        if (!r) {
            return fail('Use numbers, fractions, mixed numbers in brackets, + − × ÷, brackets and whole-number powers.');
        }

        const steps = [`Read as: ${show(tree)}`];

        if (tree.t === 'bin' && '+-*/'.includes(tree.op)) {
            const a = evalExact(tree.a);
            const b = evalExact(tree.b);
            const s = a && b && opSteps(a, tree.op, b);

            if (s && !s.error) {
                steps.push(...s.steps);
            }
        }

        steps.push(`= ${t(r)}${R.isInt(r) ? '' : `  = ${mixed(r)}  ≈ ${dec(r)}`}`);

        return result(t(r), 'Result in lowest terms', { sub: R.isInt(r) ? 'A whole number' : `Mixed number ${mixed(r)}`, rows: { mixed: mixed(r), decimal: dec(r), reciprocal: R.isZero(r) ? 'None (zero)' : t(R.inv(r)) }, steps });
    },

    binary: (i, c) => {
        const a = parseFraction(i.a);
        const b = parseFraction(i.b);
        const op = c.op ?? i.op ?? '+';

        if (!a || !b) {
            return need('Enter both numbers (fractions, mixed numbers such as 1 1/2, or decimals).');
        }

        const s = opSteps(a, op, b);

        if (s.error) {
            return fail(s.error);
        }

        const sym = { '+': '+', '-': '−', '*': '×', '/': '÷' }[op];

        return result(t(s.r), `${t(a)} ${sym} ${t(b)}`, { sub: R.isInt(s.r) ? 'A whole number' : `${mixed(s.r)} as a mixed number`, rows: { mixed: mixed(s.r), decimal: dec(s.r), reciprocal: R.isZero(s.r) ? 'None (zero)' : t(R.inv(s.r)) }, steps: [...s.steps, `Answer: ${t(s.r)}`] });
    },

    simplify: (i) => {
        const v = qs(i.num, i.den);

        if (!v || !R.isInt(v[0]) || !R.isInt(v[1])) {
            return need('Enter a whole-number numerator and denominator.');
        }

        const [n, d] = [v[0].n, v[1].n];

        if (d === 0n) {
            return fail('The denominator cannot be zero.');
        }

        const g = R.bgcd(n, d) || 1n;
        const r = R.Q(n, d);

        return result(t(r), 'In lowest terms', { sub: g > 1n ? `Divide top and bottom by ${g}` : 'Already in lowest terms', rows: { gcf: g.toString(), mixed: mixed(r), decimal: dec(r) }, steps: [`GCF(${R.babs(n)}, ${R.babs(d)}) = ${g}`, `${n} ÷ ${g} = ${n / g},  ${d} ÷ ${g} = ${d / g}`, `${t(r)}`] });
    },

    equivalent: (i) => {
        const x = parseFraction(i.value);

        if (!x) {
            return need('Enter a fraction such as 2/3.');
        }

        const other = i.check ? parseFraction(i.check) : null;
        const list = Array.from({ length: 10 }, (_, k) => `${x.n * BigInt(k + 1)}/${x.d * BigInt(k + 1)}`);

        return result(list.slice(1, 4).join(', '), `Fractions equal to ${t(x)}`, { sub: other ? (R.eq(other, x) ? `${i.check} is equivalent (both equal ${t(x)})` : `${i.check} is not equivalent (${t(other)} ≠ ${t(x)})`) : 'Multiply top and bottom by the same number', rows: { lowest: t(x), decimal: dec(x), check: other ? (R.eq(other, x) ? 'Equivalent' : 'Not equivalent') : 'Enter a fraction to check' }, steps: list.map((s, k) => `${t(x)} × ${k + 1}/${k + 1} = ${s}`) });
    },

    to_decimal: (i) => {
        const x = parseFraction(i.value);

        if (!x) {
            return need('Enter a fraction such as 5/12.');
        }

        const e = R.expand(x, 2000);
        const rep = e.terminates ? 'Terminating' : e.repeat === null ? 'Repeating (period over 2,000 digits)' : `Repeating block “${e.repeat}” (${e.repeat.length} digit${e.repeat.length === 1 ? '' : 's'})`;
        const text = e.terminates ? R.toRepeating(x) : e.repeat === null ? `${R.toDecimal(x, 30)}…` : R.toRepeating(x);

        return result(text.length > 60 ? `${text.slice(0, 58)}…` : text, `${t(x)} as a decimal`, { sub: rep, rows: { kind: rep, rounded: R.toDecimal(x, 10), percent: `${dec(R.mul(x, R.Q(100)))}%`, why: e.terminates ? `The denominator ${x.d} has only 2s and 5s as prime factors` : `The denominator ${x.d} has a prime factor other than 2 and 5` }, steps: [`${x.n} ÷ ${x.d} by long division`, text] });
    },

    from_decimal: (i) => {
        const raw = String(i.value ?? '').trim().replace(/…$/, '');
        const x = q(raw.replace(/\.(\d*)\s*\[(\d+)\]/, '.$1($2)'));

        if (!x) {
            return need('Enter a decimal such as 0.375 or a repeating decimal such as 0.1(6) or 0.(142857).');
        }

        const m = raw.match(/^(−|-)?(\d*)\.(\d*)\((\d+)\)$/);
        const steps = [];

        if (m) {
            const [, sign, int, fixed, rep] = m;
            const big = BigInt(`${int || '0'}${fixed}${rep}`);
            const small = BigInt(`${int || '0'}${fixed}`);
            const den = 10n ** BigInt(fixed.length + rep.length) - 10n ** BigInt(fixed.length);
            steps.push(`Let x = ${raw}`);
            steps.push(`10${R.sup(fixed.length + rep.length)}x = ${int || '0'}${fixed}${rep}.(${rep}),  10${R.sup(fixed.length)}x = ${int || '0'}${fixed}${fixed.length ? '' : ''}.(${rep})`);
            steps.push(`Subtract: ${den}x = ${big} − ${small} = ${big - small}`);
            steps.push(`x = ${sign ? '−' : ''}${big - small}/${den} = ${t(x)}`);
        } else {
            const places = (raw.split('.')[1] ?? '').length;
            steps.push(`${raw} = ${raw.replace('.', '').replace(/^(-?)0+(?=\d)/, '$1')}/${10n ** BigInt(places)}`);
            steps.push(`Simplify: ${t(x)}`);
        }

        return result(t(x), 'As a fraction', { sub: R.isInt(x) ? 'A whole number' : `${mixed(x)} as a mixed number`, rows: { mixed: mixed(x), percent: `${dec(R.mul(x, R.Q(100)))}%`, check: R.toRepeating(x) }, steps });
    },

    mixed_convert: (i, c) => {
        const x = parseFraction(i.value);

        if (!x) {
            return need(c.to === 'mixed' ? 'Enter an improper fraction such as 17/5.' : 'Enter a mixed number such as 3 2/5.');
        }

        const whole = R.babs(x.n) / x.d;
        const rest = R.babs(x.n) % x.d;

        if (c.to === 'mixed') {
            return result(mixed(x), 'As a mixed number', { sub: `${R.babs(x.n)} ÷ ${x.d} = ${whole} remainder ${rest}`, rows: { improper: t(x), decimal: dec(x), whole: whole.toString() }, steps: [`${R.babs(x.n)} ÷ ${x.d} = ${whole} remainder ${rest}`, `${whole} whole and ${rest}/${x.d} → ${mixed(x)}`] });
        }

        return result(t(x), 'As an improper fraction', { sub: `${whole} × ${x.d} + ${rest} = ${R.babs(x.n)}`, rows: { improper: t(x), decimal: dec(x), whole: whole.toString() }, steps: [`Multiply the whole number by the denominator: ${whole} × ${x.d} = ${whole * x.d}`, `Add the numerator: ${whole * x.d} + ${rest} = ${R.babs(x.n)}`, `${t(x)}`] });
    },

    compare: (i) => {
        const items = String(i.list ?? '').split(/[,;\n]+/).map((s) => s.trim()).filter(Boolean);
        const values = items.map((s) => parseFraction(s.replace(/%$/, '')) && (s.endsWith('%') ? R.div(parseFraction(s.slice(0, -1)), R.Q(100)) : parseFraction(s)));

        if (items.length < 2 || values.some((v) => !v)) {
            return need('Enter at least two fractions, decimals or percentages separated by commas.');
        }

        const order = items.map((s, k) => [s, values[k]]).sort((a, b) => R.cmp(a[1], b[1]));
        const chain = order.map(([s], k) => (k ? `${R.cmp(order[k - 1][1], order[k][1]) === 0 ? '=' : '<'} ${s}` : s)).join(' ');
        const lcd = values.reduce((l, v) => R.blcm(l, v.d), 1n);

        return result(chain, 'Least to greatest', { sub: items.length === 2 ? (R.cmp(values[0], values[1]) === 0 ? `${items[0]} = ${items[1]}` : `${items[0]} ${R.cmp(values[0], values[1]) < 0 ? '<' : '>'} ${items[1]}`) : `Greatest: ${order[order.length - 1][0]}`, rows: { descending: [...order].reverse().map(([s]) => s).join(', '), lcd: lcd.toString(), decimals: order.map(([s, v]) => `${s} = ${dec(v)}`).join('; ') }, steps: [`Common denominator ${lcd}:`, ...items.map((s, k) => `${s} = ${values[k].n * (lcd / values[k].d)}/${lcd}`), `Compare the numerators: ${chain}`] });
    },

    lcd: (i) => {
        const items = String(i.list ?? '').split(/[,;\n]+/).map((s) => s.trim()).filter(Boolean);
        const values = items.map(parseFraction);

        if (items.length < 2 || values.some((v) => !v)) {
            return need('Enter two or more fractions separated by commas.');
        }

        const l = values.reduce((acc, v) => R.blcm(acc, v.d), 1n);

        return result(l.toString(), 'Least common denominator', { sub: `LCM of ${values.map((v) => v.d).join(', ')}`, rows: { rewritten: values.map((v) => `${v.n * (l / v.d)}/${l}`).join(', '), product: values.reduce((p, v) => p * v.d, 1n).toString() }, steps: [...values.map((v, k) => `${items[k]} = ${t(v)}: × ${l / v.d}/${l / v.d} → ${v.n * (l / v.d)}/${l}`)] });
    },

    exponent: (i) => {
        const base = parseFraction(i.base);
        const e = parseFraction(i.exp);

        if (!base || !e) {
            return need('Enter the base and a fractional exponent such as 2/3.');
        }

        if (base.n < 0n && e.d % 2n === 0n) {
            return fail('An even root of a negative number is not real.');
        }

        const root = exactRoot(R.qabs(base), Number(e.d));
        const value = R.toNumber(base) < 0 ? -(Math.abs(R.toNumber(base)) ** R.toNumber(e)) : R.toNumber(base) ** R.toNumber(e);
        const exact = root ? R.pow(base.n < 0n ? R.neg(root) : root, e.n) : null;
        const radical = `${e.d === 2n ? '√' : e.d === 3n ? '∛' : `${e.d}√`}(${t(base)})${R.babs(e.n) === 1n ? '' : R.sup(R.babs(e.n))}`;

        return result(exact ? t(exact) : f(value, 12), `${t(base)}^(${t(e)})`, { sub: exact ? 'Exact' : 'Not a rational number; shown to 12 significant digits', rows: { radical: `${e.n < 0n ? '1 / ' : ''}${radical}`, decimal: exact ? dec(exact) : f(value, 15), rule: 'a^(m/n) = (ⁿ√a)^m' }, steps: [`a^(m/n) = (ⁿ√a)^m with m = ${e.n}, n = ${e.d}`, root ? `${e.d}-th root of ${t(R.qabs(base))} = ${t(root)}` : `${e.d}-th root of ${t(R.qabs(base))} is irrational ≈ ${f(Math.abs(R.toNumber(base)) ** (1 / Number(e.d)), 12)}`, `Raise to the power ${e.n}: ${exact ? t(exact) : f(value, 12)}`] });
    },

    golden: (i) => {
        const phi = (1 + Math.sqrt(5)) / 2;
        const v = Number(i.value);

        if (!Number.isFinite(v) || v <= 0) {
            return need('Enter a positive length.');
        }

        let a;
        let b;

        if (i.known === 'a') {
            a = v;
            b = v / phi;
        } else if (i.known === 'b') {
            b = v;
            a = v * phi;
        } else {
            a = v / phi;
            b = v - a;
        }

        return result(`a = ${f(a)}, b = ${f(b)}`, 'Golden ratio lengths', { sub: `(a + b) ÷ a = a ÷ b = φ = ${f(phi, 12)}`, rows: { a: f(a, 12), b: f(b, 12), total: f(a + b, 12), phi: '(1 + √5) ÷ 2 = 1.6180339887…' }, steps: [`φ = (1 + √5)/2 ≈ ${f(phi, 15)}`, i.known === 'total' ? `a = total ÷ φ = ${f(a, 12)}` : i.known === 'a' ? `b = a ÷ φ = ${f(b, 12)}` : `a = b × φ = ${f(a, 12)}`, `a + b = ${f(a + b, 12)}`] });
    },

    proportion: (i) => {
        const vals = ['a', 'b', 'c', 'd'].map((k) => (String(i[k] ?? '').trim().toLowerCase() === 'x' || String(i[k] ?? '').trim() === '' ? null : parseFraction(i[k])));
        const missing = vals.map((v, k) => (v ? -1 : k)).filter((k) => k >= 0);

        if (missing.length !== 1) {
            return need('Fill in three of the four values and leave one blank (or type x).');
        }

        const [a, b, cc, d] = vals;
        const m = missing[0];
        // a/b = c/d → ad = bc
        const x = m === 0 ? R.div(R.mul(b, cc), d) : m === 1 ? R.div(R.mul(a, d), cc) : m === 2 ? R.div(R.mul(a, d), b) : R.div(R.mul(b, cc), a);
        const full = [...vals];
        full[m] = x;
        const name = ['A', 'B', 'C', 'D'][m];

        return result(both(x), `${name} =`, { sub: `${t(full[0])} : ${t(full[1])} = ${t(full[2])} : ${t(full[3])}`, rows: { check: `${t(R.mul(full[0], full[3]))} = ${t(R.mul(full[1], full[2]))}`, ratio: t(R.div(full[0], full[1])), decimal: dec(x) }, steps: ['Cross-multiply: A × D = B × C', `${name} = ${m === 0 || m === 3 ? 'B × C ÷' : 'A × D ÷'} ${m === 0 ? 'D' : m === 1 ? 'C' : m === 2 ? 'B' : 'A'} = ${t(x)}`] });
    },

    cross: (i) => {
        const v = qs(i.a, i.b, i.c);

        if (!v || R.isZero(v[0])) {
            return need('Enter a, b and c (a not zero) for a/b = c/x.');
        }

        const [a, b, cc] = v;
        const x = R.div(R.mul(b, cc), a);

        return result(both(x), 'x =', { sub: `${R.isInt(a) ? t(a) : `(${t(a)})`}/${R.isInt(b) ? t(b) : `(${t(b)})`} = ${R.isInt(cc) ? t(cc) : `(${t(cc)})`}/x`, rows: { check: `${t(a)} × ${t(x)} = ${t(b)} × ${t(cc)} = ${t(R.mul(b, cc))}`, decimal: dec(x) }, steps: [`Cross-multiply: ${t(a)} × x = ${t(b)} × ${t(cc)}`, `x = ${t(R.mul(b, cc))} ÷ ${t(a)} = ${t(x)}`] });
    },

    ratio: (i) => {
        const parts = String(i.ratio ?? '').split(/[:/,\s]+/).filter(Boolean).map(parseFraction);

        if (parts.length < 2 || parts.some((p) => !p) || parts.every(R.isZero)) {
            return need('Enter a ratio such as 12:18 or 2:3:5.');
        }

        const l = parts.reduce((acc, p) => R.blcm(acc, p.d), 1n);
        const ints = parts.map((p) => (p.n * l) / p.d);
        const g = ints.reduce((acc, n) => R.bgcd(acc, n), 0n) || 1n;
        const simple = ints.map((n) => n / g);
        const mode = i.mode ?? 'simplify';
        const sum = simple.reduce((s, n) => s + n, 0n);
        const rows = { simplest: simple.join(' : '), fractions: simple.map((n) => `${n}/${sum}`).join(', '), unit: simple.map((n) => dec(R.Q(n, simple[0] || 1n))).join(' : ') };

        if (mode === 'total') {
            const total = parseFraction(i.total);

            if (!total) {
                return need('Enter the total to share.');
            }

            const shares = simple.map((n) => R.mul(total, R.Q(n, sum)));

            return result(shares.map((s) => dec(s)).join(' : '), `${t(total)} shared in the ratio ${simple.join(' : ')}`, { sub: `${sum} parts of ${dec(R.div(total, R.Q(sum)))}`, rows, steps: [`Total parts = ${simple.join(' + ')} = ${sum}`, `One part = ${t(total)} ÷ ${sum} = ${dec(R.div(total, R.Q(sum)))}`, ...shares.map((s, k) => `${simple[k]} parts = ${dec(s)}`)] });
        }

        if (mode === 'scale') {
            const target = parseFraction(i.total);

            if (!target || R.isZero(R.Q(simple[0]))) {
                return need('Enter the new value of the first term.');
            }

            const k = R.div(target, R.Q(simple[0]));
            const scaled = simple.map((n) => R.mul(R.Q(n), k));

            return result(scaled.map((s) => dec(s)).join(' : '), `Equivalent ratio starting with ${t(target)}`, { sub: `Scale factor ${dec(k)}`, rows, steps: [`Scale factor = ${t(target)} ÷ ${simple[0]} = ${dec(k)}`, ...scaled.map((s, j) => `${simple[j]} × ${dec(k)} = ${dec(s)}`)] });
        }

        return result(simple.join(' : '), 'Simplest form', { sub: g > 1n ? `Divided by the GCF ${g}` : 'Already in simplest form', rows, steps: [l > 1n ? `Clear fractions: × ${l} → ${ints.join(' : ')}` : `Ratio ${ints.join(' : ')}`, `GCF = ${g}`, `${simple.join(' : ')}`] });
    },

    unit_rate: (i) => {
        const v = qs(i.amount, i.per);

        if (!v || R.isZero(v[1])) {
            return need('Enter the amount and a non-zero quantity.');
        }

        const [amount, per] = v;
        const rate = R.div(amount, per);
        const unitA = String(i.unitA || 'units').trim();
        const unitB = String(i.unitB || 'item').trim();

        return result(`${dec(rate)} ${unitA} per ${unitB}`, 'Unit rate', { sub: `${dec(amount)} ${unitA} ÷ ${dec(per)} ${unitB}`, rows: { inverse: R.isZero(rate) ? 'None' : `${dec(R.inv(rate))} ${unitB} per ${unitA}`, per100: `${dec(R.mul(rate, R.Q(100)))} ${unitA} per 100 ${unitB}`, fraction: t(rate) }, steps: [`${dec(amount)} ÷ ${dec(per)} = ${dec(rate)}`] });
    },

    continued: (i) => {
        const text = String(i.value ?? '').trim();
        const sq = text.match(/^(?:sqrt|√)\s*\(?\s*(\d+)\s*\)?$/i);

        if (sq) {
            const n = BigInt(sq[1]);
            const { a0, period } = sqrtCf(n);

            if (!period.length) {
                return result(`[${a0}]`, `√${n} as a continued fraction`, { sub: `${n} is a perfect square`, rows: { notation: `[${a0}]`, convergents: a0.toString(), period: 'None' }, steps: [`√${n} = ${a0}`] });
            }

            const terms = [a0, ...Array.from({ length: 12 }, (_, k) => period[k % period.length])];
            const conv = convergents(terms).slice(0, 8);

            return result(`[${a0}; (${period.join(', ')})]`, `√${n} as a continued fraction`, { sub: `Repeating block of length ${period.length}`, rows: { notation: `[${a0}; ${period.join(', ')}, ${period.join(', ')}, …]`, convergents: conv.map(t).join(', '), period: String(period.length) }, steps: conv.map((x, k) => `${t(x)} ≈ ${R.toDecimal(x, 10)} (error ${f(Math.abs(R.toNumber(x) - Math.sqrt(Number(n))), 3)})`).map((s, k) => `Convergent ${k}: ${s}`) });
        }

        const x = parseFraction(text);

        if (!x) {
            return need('Enter a fraction, a decimal or sqrt(n).');
        }

        const terms = cfExpand(x);
        const conv = convergents(terms);

        return result(`[${terms[0]}${terms.length > 1 ? `; ${terms.slice(1).join(', ')}` : ''}]`, `${t(x)} as a continued fraction`, { sub: `${terms.length} terms (finite: the number is rational)`, rows: { notation: `${terms[0]} + 1/(${terms.slice(1, 4).join(' + 1/(')}${terms.length > 4 ? ' + …' : ''}${')'.repeat(Math.min(terms.length - 1, 3))}`, convergents: conv.map(t).join(', '), period: 'None (finite)' }, steps: terms.map((a, k) => `a${R.subscript(k)} = ${a}${k < conv.length ? `   convergent ${t(conv[k])}` : ''}`) });
    },

    egyptian: (i) => {
        let x = parseFraction(i.value);

        if (!x || R.sign(x) <= 0 || R.cmp(x, R.ONE) >= 0) {
            return need('Enter a fraction between 0 and 1 such as 4/13.');
        }

        const parts = [];
        const steps = [];

        while (!R.isZero(x) && parts.length < 30) {
            const d = R.ceil(R.inv(x));
            parts.push(d);
            const next = R.sub(x, R.Q(1n, d));
            steps.push(`${t(x)} − 1/${d} = ${t(next)}`);
            x = next;
        }

        return result(parts.map((d) => `1/${d}`).join(' + '), 'As a sum of unit fractions', { sub: `${parts.length} unit fractions (greedy algorithm)`, rows: { count: String(parts.length), largest: `1/${parts[parts.length - 1]}`, method: 'Fibonacci–Sylvester greedy: take the largest unit fraction that fits' }, steps });
    },

    terminating: (i) => {
        const x = parseFraction(i.value);

        if (!x) {
            return need('Enter a fraction such as 7/40.');
        }

        let d = x.d;
        const factors = [];

        for (const p of [2n, 5n]) {
            let k = 0;

            while (d % p === 0n) {
                d /= p;
                k += 1;
            }

            factors.push(k);
        }

        const term = d === 1n;

        return result(term ? 'Terminating' : 'Repeating', `${t(x)} as a decimal`, { sub: term ? `${R.toRepeating(x)} (${Math.max(...factors)} decimal place${Math.max(...factors) === 1 ? '' : 's'})` : `${R.toRepeating(x)}`, rows: { decimal: R.toRepeating(x), denominator: `${x.d} = 2${R.sup(factors[0])} × 5${R.sup(factors[1])}${d > 1n ? ` × ${d}` : ''}`, rule: 'A fraction in lowest terms terminates exactly when its denominator has no prime factors except 2 and 5' }, steps: [`Lowest terms: ${t(x)}`, `Denominator ${x.d} = 2${R.sup(factors[0])} × 5${R.sup(factors[1])}${d > 1n ? ` × ${d}` : ''}`, term ? 'Only 2s and 5s: terminating' : `Other factor ${d}: repeating`] });
    },
};

export default defineTools(handlers);
