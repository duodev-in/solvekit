import { defineTools } from '../engines/formula.js';
import { evalExact, evalReal, exactRoot, parse } from '../math/expr.js';
import * as N from '../math/numtheory.js';
import { simplifySqrt } from '../math/poly.js';
import { both, dec, f, fail, need, q, R, result } from '../math/util.js';

/**
 * Number tools: divisibility, primes, factors, GCF and LCM (with Euclid's steps), modular arithmetic,
 * roots and radicals, rounding, significant figures, scientific notation, averages and other statistics.
 * Integers are BigInt, so large values stay exact.
 */
const big = (v) => N.parseBig(v);
const t = R.toFraction;
const fmtBig = (n) => R.fmt(BigInt(n));

function ints(text) {
    const list = String(text ?? '').split(/[\s,;]+/).filter(Boolean).map(N.parseBig);

    return list.length && list.every((v) => v !== null) ? list : null;
}

function numbers(text) {
    const list = String(text ?? '').split(/[\s,;]+/).filter(Boolean).map((s) => R.parseNumber(s));

    return list.length && list.every(Boolean) ? list : null;
}

function euclidSteps(a, b) {
    const steps = [];
    let [x, y] = [R.babs(a), R.babs(b)];

    while (y) {
        steps.push(`${x} = ${x / y} × ${y} + ${x % y}`);
        [x, y] = [y, x % y];
    }

    return { g: x, steps };
}

function factorTable(list) {
    return list.map((n) => {
        try {
            return `${n} = ${N.factorString(N.factorize(n))}`;
        } catch {
            return `${n} (too large to factor quickly)`;
        }
    });
}

/** Significant figures of a typed number (trailing zeros in integers without a decimal point are ambiguous). */
export function sigFigs(text) {
    const s = String(text ?? '').trim().replace(/^[-+−]/, '').replace(/,/g, '').toLowerCase();
    const m = s.match(/^(\d*)(?:\.(\d*))?(?:e[+-]?\d+)?$/);

    if (!m || (!m[1] && !m[2])) {
        return null;
    }

    const [mant] = s.split('e');
    const hasPoint = mant.includes('.');
    const digits = mant.replace('.', '');
    const stripped = digits.replace(/^0+/, '');

    if (!stripped) {
        return { count: hasPoint ? Math.max(1, (mant.split('.')[1] ?? '').length) : 1, ambiguous: false, zero: true };
    }

    if (hasPoint) {
        return { count: stripped.length, ambiguous: false };
    }

    const trailing = stripped.match(/0*$/)[0].length;

    return { count: stripped.length - trailing, max: stripped.length, ambiguous: trailing > 0 };
}

/** Exact rounding to n significant figures. */
export function roundSig(x, n, mode = 'half-up') {
    if (R.isZero(x)) {
        return R.ZERO;
    }

    const e = Math.floor(Math.log10(Math.abs(R.toNumber(x))));
    // Correct the estimate exactly.
    let exp = e;
    const abs = R.qabs(x);

    while (R.cmp(abs, R.pow(R.Q(10), exp)) < 0) {
        exp -= 1;
    }

    while (R.cmp(abs, R.pow(R.Q(10), exp + 1)) >= 0) {
        exp += 1;
    }

    const step = R.pow(R.Q(10), exp - n + 1);

    return R.roundTo(x, step, mode);
}

/** The place value a rounding to n significant figures works at. */
export function sigStep(x, n) {
    const abs = R.qabs(x);
    let exp = Math.floor(Math.log10(R.toNumber(abs)));

    while (R.cmp(abs, R.pow(R.Q(10), exp)) < 0) {
        exp -= 1;
    }

    while (R.cmp(abs, R.pow(R.Q(10), exp + 1)) >= 0) {
        exp += 1;
    }

    return R.pow(R.Q(10), exp - n + 1);
}

/** Scientific notation of an exact value: { mantissa (rational), exponent }. */
export function sci(x) {
    if (R.isZero(x)) {
        return { m: R.ZERO, e: 0 };
    }

    let e = Math.floor(Math.log10(Math.abs(R.toNumber(x))));
    const abs = R.qabs(x);

    while (R.cmp(abs, R.pow(R.Q(10), e)) < 0) {
        e -= 1;
    }

    while (R.cmp(abs, R.pow(R.Q(10), e + 1)) >= 0) {
        e += 1;
    }

    return { m: R.div(x, R.pow(R.Q(10), e)), e };
}

const hasRootOrPower = (node) => (node.t === 'call' && ['sqrt', 'cbrt', 'root'].includes(node.fn)) || (node.t === 'bin' && node.op === '^') || ['a', 'b'].some((k) => node[k] && hasRootOrPower(node[k])) || (node.args ?? []).some(hasRootOrPower);

/** The fraction with denominator up to 10,000 that matches x to 13 digits, if any (continued fractions). */
function bestRational(x) {
    let [h1, h0, k1, k0] = [1, 0, 0, 1];
    let v = x;

    for (let k = 0; k < 30; k += 1) {
        const a = Math.floor(v);
        [h1, h0] = [a * h1 + h0, h1];
        [k1, k0] = [a * k1 + k0, k1];

        if (k1 > 10000) {
            return null;
        }

        if (Math.abs(h1 / k1 - x) <= 1e-13 * Math.max(1, Math.abs(x))) {
            return R.Q(h1, k1);
        }

        if (v - a < 1e-15) {
            return null;
        }

        v = 1 / (v - a);
    }

    return null;
}

const sciText = ({ m, e }) => `${R.toRepeating(m).replace('-', '−')} × 10${R.sup(e)}`;

export const handlers = {
    gcf: (i, c) => {
        const list = ints(i.numbers);

        if (!list || list.length < 2 || list.every((n) => n === 0n)) {
            return need('Enter two or more whole numbers separated by commas.');
        }

        const g = list.reduce((acc, n) => R.bgcd(acc, n), 0n);
        const l = list.reduce((acc, n) => R.blcm(acc, n), 1n);
        const { steps } = euclidSteps(list[0], list[1]);
        const want = c.want ?? 'gcf';
        const main = want === 'lcm' ? l : g;
        const label = { gcf: 'Greatest common factor', lcm: 'Least common multiple', both: 'GCF and LCM' }[want];
        const common = want === 'gcf' || want === 'both' ? N.divisors(g || 1n) : null;

        return result(want === 'both' ? `GCF ${fmtBig(g)}, LCM ${fmtBig(l)}` : fmtBig(main), label, {
            sub: want === 'lcm' ? `GCF ${fmtBig(g)}${list.length === 2 ? `; ${list[0]} × ${list[1]} ÷ ${g} = ${l}` : ''}` : `LCM ${fmtBig(l)}`,
            rows: { gcf: fmtBig(g), lcm: fmtBig(l), common: common && common.length <= 60 ? common.join(', ') : `${N.divisors(g || 1n).length} common factors`, coprime: g === 1n ? 'Yes: relatively prime' : 'No' },
            steps: [...(want !== 'lcm' && list.length === 2 ? ['Euclid\'s algorithm:', ...steps, `GCF = ${g}`] : []), 'Prime factors:', ...factorTable(list), ...(want !== 'gcf' ? [`LCM = ${l}`] : [])],
        });
    },

    relatively_prime: (i) => {
        const list = ints(i.numbers);

        if (!list || list.length < 2) {
            return need('Enter two or more whole numbers.');
        }

        const g = list.reduce((acc, n) => R.bgcd(acc, n), 0n);
        const pairwise = list.every((a, k) => list.every((b, j) => j <= k || R.bgcd(a, b) === 1n));

        return result(g === 1n ? 'Relatively prime' : 'Not relatively prime', `GCF ${g}`, { sub: list.length > 2 ? (pairwise ? 'Also pairwise coprime' : 'Not pairwise coprime') : g === 1n ? 'They share no factor except 1' : `Both are divisible by ${g}`, rows: { gcf: g.toString(), pairwise: pairwise ? 'Yes' : 'No' }, steps: factorTable(list) });
    },

    factors: (i) => {
        const n = big(i.n);

        if (n === null || n === 0n) {
            return need('Enter a non-zero whole number.');
        }

        const divs = N.divisors(R.babs(n));
        const pairs = divs.filter((d) => d * d <= R.babs(n)).map((d) => `${d} × ${R.babs(n) / d}`);
        const sum = divs.reduce((s, d) => s + d, 0n);

        return result(divs.length <= 40 ? divs.join(', ') : `${divs.length} factors`, `Factors of ${fmtBig(n)}`, { sub: `${divs.length} positive factors${n < 0n ? ' (and their negatives)' : ''}`, rows: { count: String(divs.length), pairs: pairs.slice(0, 30).join(', '), prime: N.factorString(N.factorize(n)), sum: `${fmtBig(sum)} (${sum - R.babs(n) === R.babs(n) ? 'a perfect number' : sum - R.babs(n) > R.babs(n) ? 'abundant' : 'deficient'})` }, steps: [`${R.babs(n)} = ${N.factorString(N.factorize(n))}`, `Number of factors = ${[...N.factorize(n).values()].map((e) => `(${e} + 1)`).join(' × ') || '1'} = ${divs.length}`] });
    },

    prime_factors: (i) => {
        const n = big(i.n);

        if (n === null || R.babs(n) < 2n) {
            return need('Enter a whole number of 2 or more.');
        }

        if (R.babs(n) > 10n ** 40n) {
            return fail('Numbers up to 40 digits are supported.');
        }

        let factors;

        try {
            factors = N.factorize(n);
        } catch {
            return fail('This number could not be factored quickly; try a smaller one.');
        }

        const tree = [];
        let rest = R.babs(n);

        for (const [p, e] of factors) {
            for (let k = 0n; k < e; k += 1n) {
                tree.push(`${rest} = ${p} × ${rest / p}`);
                rest /= p;
            }
        }

        return result(N.factorString(factors), `Prime factorisation of ${fmtBig(n)}`, { sub: factors.size === 1 && [...factors.values()][0] === 1n ? 'It is prime' : `${[...factors.values()].reduce((s, e) => s + e, 0n)} prime factors with repetition`, rows: { list: [...factors.entries()].flatMap(([p, e]) => Array(Number(e)).fill(p)).join(' × '), distinct: [...factors.keys()].join(', '), count: String(N.divisors(R.babs(n)).length) }, steps: tree.slice(0, 40) });
    },

    prime: (i) => {
        const n = big(i.n);

        if (n === null) {
            return need('Enter a whole number.');
        }

        const p = N.isPrime(n);
        let smallest = null;

        if (!p && n > 1n) {
            try {
                smallest = [...N.factorize(n).keys()][0];
            } catch {
                smallest = null;
            }
        }

        return result(p ? 'Prime' : n < 2n ? 'Neither prime nor composite' : 'Composite', fmtBig(n), { sub: p ? 'Divisible only by 1 and itself' : smallest ? `Divisible by ${smallest}` : n < 2n ? 'Primes start at 2' : '', rows: { next: fmtBig(N.nextPrime(n < 1n ? 1n : n)), previous: n > 2n ? fmtBig(N.prevPrime(n)) : 'None', factor: smallest ? `${smallest} × ${n / smallest}` : 'None', test: 'Deterministic Miller–Rabin' }, steps: p ? [`No prime up to √${n} ≈ ${N.isqrt(n < 0n ? 0n : n)} divides ${n}`] : smallest ? [`${n} ÷ ${smallest} = ${n / smallest}`] : [] });
    },

    divisibility: (i) => {
        const n = big(i.n);
        const d = big(i.d);

        if (n === null || d === null || d === 0n) {
            return need('Enter a whole number and a non-zero divisor.');
        }

        const s = R.babs(n).toString();
        const digitSum = [...s].reduce((acc, ch) => acc + Number(ch), 0);
        const alt = [...s].reverse().reduce((acc, ch, k) => acc + (k % 2 ? -1 : 1) * Number(ch), 0);
        const rules = {
            2: `Last digit ${s.at(-1)} is ${Number(s.at(-1)) % 2 ? 'odd' : 'even'}`,
            3: `Digit sum ${digitSum} ${digitSum % 3 ? 'is not' : 'is'} divisible by 3`,
            4: `Last two digits ${s.slice(-2)} ${Number(s.slice(-2)) % 4 ? 'are not' : 'are'} divisible by 4`,
            5: `Last digit ${s.at(-1)} ${'05'.includes(s.at(-1)) ? 'is' : 'is not'} 0 or 5`,
            6: 'Divisible by both 2 and 3',
            8: `Last three digits ${s.slice(-3)} ${Number(s.slice(-3)) % 8 ? 'are not' : 'are'} divisible by 8`,
            9: `Digit sum ${digitSum} ${digitSum % 9 ? 'is not' : 'is'} divisible by 9`,
            10: `Last digit ${s.at(-1)} ${s.at(-1) === '0' ? 'is' : 'is not'} 0`,
            11: `Alternating digit sum ${alt} ${alt % 11 ? 'is not' : 'is'} divisible by 11`,
            12: 'Divisible by both 3 and 4',
        };
        const yes = n % d === 0n;

        return result(yes ? `Yes, ${fmtBig(n)} is divisible by ${d}` : `No, ${fmtBig(n)} is not divisible by ${d}`, `${n} ÷ ${d}`, { sub: yes ? `${n} ÷ ${d} = ${n / d}` : `Remainder ${N.mod(n, d)}`, rows: { rule: rules[Number(R.babs(d))] ?? `Rule: check the remainder of ${n} ÷ ${d}`, quotient: `${n / d} remainder ${n % d}`, all: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12].filter((k) => n % BigInt(k) === 0n).join(', ') || 'None from 2 to 12' }, steps: [rules[Number(R.babs(d))] ?? `${n} = ${n / d} × ${d} + ${n % d}`] });
    },

    modulo: (i, c) => {
        const a = big(i.a);
        const m = big(i.m);

        if (a === null || m === null || m === 0n) {
            return need('Enter a whole number and a non-zero modulus.');
        }

        const floored = N.mod(a, m) + (m < 0n && N.mod(a, m) !== 0n ? m : 0n);
        const truncated = a % m;
        const kind = c.kind ?? 'mod';

        if (kind === 'floor') {
            const qf = R.bfloor(a, m);

            return result(fmtBig(qf), `${a} // ${m}`, { sub: `Remainder ${fmtBig(a - qf * m)}`, rows: { quotient: fmtBig(qf), remainder: fmtBig(a - qf * m), truncated: `${a / m} (rounding towards zero)` }, steps: [`${a} ÷ ${m} = ${f(Number(a) / Number(m), 12)}`, `Round down: ${qf}`, `Remainder ${a} − ${qf} × ${m} = ${a - qf * m}`] });
        }

        return result(fmtBig(floored), `${a} mod ${m}`, { sub: a < 0n || m < 0n ? `Truncated remainder (as in C and JavaScript): ${fmtBig(truncated)}` : `${a} = ${R.bfloor(a, m)} × ${m} + ${floored}`, rows: { quotient: fmtBig(R.bfloor(a, m)), remainder: fmtBig(floored), truncated: fmtBig(truncated) }, steps: [`${a} = ${R.bfloor(a, m)} × ${m} + ${floored}`, `${a} mod ${m} = ${floored}`] });
    },

    division: (i, c) => {
        const a = big(i.a);
        const b = big(i.b);

        if (a === null || b === null || b === 0n) {
            return need('Enter a whole-number dividend and a non-zero divisor.');
        }

        const qt = a / b;
        const r = a % b;
        const x = R.Q(a, b);
        const want = c.want ?? 'quotient';

        return result(want === 'remainder' ? fmtBig(r) : `${fmtBig(qt)} R ${fmtBig(r)}`, want === 'remainder' ? 'Remainder' : 'Quotient and remainder', { sub: `${a} = ${qt} × ${b} + ${r}`, rows: { quotient: fmtBig(qt), remainder: fmtBig(r), decimal: dec(x), fraction: R.toMixed(x) }, steps: [`${a} ÷ ${b} = ${qt} remainder ${r}`, `Check: ${qt} × ${b} + ${r} = ${a}`] });
    },

    mod_inverse: (i) => {
        const a = big(i.a);
        const m = big(i.m);

        if (a === null || m === null || m < 2n) {
            return need('Enter a whole number and a modulus of 2 or more.');
        }

        const [g, x] = N.egcd(N.mod(a, m), m);

        if (g !== 1n) {
            return result('No inverse', `${a} mod ${m}`, { sub: `gcd(${a}, ${m}) = ${g}, not 1`, rows: { gcd: g.toString(), check: 'An inverse exists only when the numbers are coprime' }, steps: euclidSteps(N.mod(a, m), m).steps });
        }

        const inv = N.mod(x, m);

        return result(fmtBig(inv), `${a}⁻¹ mod ${m}`, { sub: `${a} × ${inv} = ${a * inv} ≡ 1 (mod ${m})`, rows: { gcd: '1', check: `${a} × ${inv} mod ${m} = ${N.mod(a * inv, m)}` }, steps: ['Extended Euclid:', ...euclidSteps(N.mod(a, m), m).steps, `Bézout: ${N.mod(a, m)} × ${x} + ${m} × … = 1`, `Inverse = ${x} mod ${m} = ${inv}`] });
    },

    power_mod: (i) => {
        const [a, b, m] = [big(i.a), big(i.b), big(i.m)];

        if (a === null || b === null || m === null || m < 1n || b < 0n) {
            return need('Enter a base, a non-negative exponent and a modulus of 1 or more.');
        }

        const r = N.modPow(a, b, m);
        const bits = b.toString(2);

        return result(fmtBig(r), `${a}^${b} mod ${m}`, { sub: `Square-and-multiply over ${bits.length} bits`, rows: { binary: bits, check: m < 10n ** 6n && b < 64n ? `${a ** b} mod ${m}` : 'Too large to expand' }, steps: [`Exponent in binary: ${bits}`, ...[...bits].slice(0, 20).map((bit, k) => `Bit ${k + 1} = ${bit}: ${bit === '1' ? 'square, then multiply by the base' : 'square'}`), `Result ${r}`] });
    },

    fermat: (i) => {
        const a = big(i.a);
        const p = big(i.p);

        if (a === null || p === null || p < 2n) {
            return need('Enter a whole number a and a modulus p.');
        }

        const r = N.modPow(a, p - 1n, p);
        const prime = N.isPrime(p);

        return result(`${a}^${p - 1n} ≡ ${r} (mod ${p})`, 'Fermat\'s little theorem', { sub: prime ? (a % p === 0n ? `${p} divides ${a}, so the theorem does not apply` : 'As predicted: p is prime') : r === 1n ? `${p} is not prime but passes for base ${a} (a Fermat pseudoprime)` : `${r} ≠ 1, so ${p} is not prime`, rows: { prime: prime ? 'Yes' : 'No', inverse: prime && a % p !== 0n ? `${N.modPow(a, p - 2n, p)} (a^(p−2) mod p)` : 'Not by Fermat', theorem: 'If p is prime and p does not divide a, then a^(p−1) ≡ 1 (mod p)' }, steps: [`${a}^${p - 1n} mod ${p} = ${r}`] });
    },

    crt: (i) => {
        const lines = String(i.system ?? '').split('\n').map((l) => l.trim()).filter(Boolean);
        const pairs = lines.map((l) => l.match(/^(-?\d+)\s*(?:mod|,|\s)\s*(\d+)$/i) ?? l.match(/x\s*[≡=]\s*(-?\d+)\s*\(?\s*mod\s*(\d+)\)?/i)).map((m) => m && [BigInt(m[1]), BigInt(m[2])]);

        if (pairs.length < 2 || pairs.some((p) => !p || p[1] < 1n)) {
            return need('Enter one congruence per line as "remainder mod modulus", for example 2 mod 3.');
        }

        const r = N.crt(pairs);

        if (!r) {
            return result('No solution', 'The congruences contradict each other', { sub: 'Two moduli share a factor and the remainders disagree', rows: { modulus: 'None', smallest: 'None' }, steps: pairs.map(([a, m]) => `x ≡ ${a} (mod ${m})`) });
        }

        return result(`x ≡ ${r[0]} (mod ${r[1]})`, 'Solution', { sub: `Smallest non-negative solution ${r[0]}`, rows: { modulus: fmtBig(r[1]), smallest: fmtBig(r[0]) }, steps: [...pairs.map(([a, m]) => `x ≡ ${a} (mod ${m}): ${r[0]} mod ${m} = ${N.mod(r[0], m)} ✓`)] });
    },

    factorial: (i) => {
        const n = big(i.n);

        if (n === null || n < 0n || n > 20000n) {
            return need('Enter a whole number from 0 to 20,000.');
        }

        const v = N.factorial(n);
        const s = v.toString();
        let zeros = 0n;

        for (let p = 5n; p <= n; p *= 5n) {
            zeros += n / p;
        }

        let dbl = 1n;

        for (let k = n; k > 1n; k -= 2n) {
            dbl *= k;
        }

        return result(s.length > 60 ? `${s.slice(0, 20)}… (${s.length} digits)` : fmtBig(v), `${n}!`, { sub: `${s.length} digits`, rows: { digits: String(s.length), zeros: zeros.toString(), double: dbl.toString().length > 40 ? `${dbl.toString().length} digits` : fmtBig(dbl), scientific: s.length > 15 ? `${s[0]}.${s.slice(1, 10)} × 10${R.sup(s.length - 1)}` : fmtBig(v) }, steps: [n <= 12n ? `${n}! = ${Array.from({ length: Number(n) }, (_, k) => Number(n) - k).join(' × ') || '1'} = ${v}` : `${n}! = ${n} × ${n - 1n} × … × 1`, `Trailing zeros: Σ ⌊n/5ᵏ⌋ = ${zeros}`] });
    },

    floor_ceil: (i, c) => {
        let x = q(i.x);

        if (!x) {
            try {
                x = evalExact(parse(i.x));
            } catch {
                x = null;
            }
        }

        if (!x) {
            return need('Enter a number or fraction.');
        }

        const fl = R.floor(x);
        const ce = R.ceil(x);

        return result(fmtBig(c.fn === 'ceil' ? ce : fl), `${c.fn === 'ceil' ? '⌈' : '⌊'}${t(x)}${c.fn === 'ceil' ? '⌉' : '⌋'}`, { sub: c.fn === 'ceil' ? 'Smallest integer ≥ x' : 'Largest integer ≤ x', rows: { floor: fmtBig(fl), ceil: fmtBig(ce), round: fmtBig(R.floor(R.roundTo(x, R.ONE))), fraction: t(R.sub(x, R.Q(fl))) }, steps: [`${t(x)} = ${dec(x)} lies between ${fl} and ${ce === fl ? fl + 1n : ce}`] });
    },

    abs_value: (i) => {
        let x;

        try {
            x = evalExact(parse(i.x));
        } catch {
            x = null;
        }

        if (!x) {
            const v = Number(i.x);

            return Number.isFinite(v) ? result(f(Math.abs(v)), `|${i.x}|`, { sub: 'Distance from zero', rows: { sign: v < 0 ? 'Negative' : 'Positive or zero', opposite: f(-v) }, steps: [`|${f(v)}| = ${f(Math.abs(v))}`] }) : need('Enter a number or expression.');
        }

        return result(t(R.qabs(x)), `|${t(x)}|`, { sub: 'Distance from zero on the number line', rows: { sign: R.sign(x) < 0 ? 'Negative' : R.sign(x) > 0 ? 'Positive' : 'Zero', opposite: t(R.neg(x)) }, steps: [`${t(x)} ${R.sign(x) < 0 ? 'is negative: drop the sign' : 'is not negative: unchanged'}`, `|${t(x)}| = ${t(R.qabs(x))}`] });
    },

    roots: (i, c) => {
        const n = c.index ?? Number(i.index ?? 2);
        let x = q(i.x);

        if (!x) {
            try {
                x = evalExact(parse(i.x));
            } catch {
                x = null;
            }
        }

        if (!x || !Number.isInteger(n) || n < 2 || n > 100) {
            return need('Enter a number and a root index from 2 to 100.');
        }

        const neg = R.sign(x) < 0;

        if (neg && n % 2 === 0) {
            const r = Math.abs(R.toNumber(x)) ** (1 / n);

            return result(`${f(r)}i`, `${n === 2 ? '√' : `${R.sup(n)}√`}(${t(x)})`, { sub: 'No real root: the principal root is imaginary', rows: { exact: n === 2 && R.isInt(x) ? `i√${R.babs(x.n)}` : 'Imaginary', decimal: `±${f(r, 12)}i`, check: `(${f(r)}i)${R.sup(n)} = ${t(x)}` }, steps: [`An even root of a negative number is imaginary: ${f(r, 12)}i`] });
        }

        const exact = exactRoot(x, n);

        if (exact) {
            return result(t(exact), `${n === 2 ? '√' : n === 3 ? '∛' : `${R.sup(n)}√`}${t(x)}`, { sub: n % 2 === 0 && !R.isZero(exact) ? `Also −${t(exact)} ${n === 2 ? 'squares to' : `raised to the power ${n} gives`} ${t(x)}` : 'Exact', rows: { exact: t(exact), decimal: dec(exact), check: `${t(exact)}${R.sup(n)} = ${t(x)}` }, steps: [`${t(exact)}${R.sup(n)} = ${t(x)}`] });
        }

        const value = (neg ? -1 : 1) * Math.abs(R.toNumber(x)) ** (1 / n);
        let exactText = 'Irrational';

        if (R.isInt(x) && R.babs(x.n) < 10n ** 30n) {
            const [out, inside] = simplifySqrt(R.babs(x.n), BigInt(n));
            exactText = `${neg ? '−' : ''}${out === 1n ? '' : out}${n === 2 ? '√' : n === 3 ? '∛' : `${R.sup(n)}√`}${inside}`;
        } else if (!R.isInt(x)) {
            // √(a/b) = √(a·bⁿ⁻¹)/b
            const top = R.babs(x.n) * x.d ** BigInt(n - 1);
            const [out, inside] = simplifySqrt(top, BigInt(n));
            const g = R.bgcd(out, x.d);
            exactText = `${neg ? '−' : ''}${out / g === 1n ? '' : out / g}${n === 2 ? '√' : `${R.sup(n)}√`}${inside}/${x.d / g}`;
        }

        return result(f(value, 12), `${n === 2 ? '√' : n === 3 ? '∛' : `${R.sup(n)}√`}${t(x)}`, { sub: `Exact form ${exactText}`, rows: { exact: exactText, decimal: f(value, 15), check: `${f(value, 12)}${R.sup(n)} ≈ ${f(value ** n, 12)}` }, steps: [`Pull out perfect ${n === 2 ? 'squares' : n === 3 ? 'cubes' : `${n}th powers`}: ${exactText}`, `≈ ${f(value, 15)}`] });
    },

    radical: (i) => {
        const coef = BigInt(i.coef || '1');
        const n = Number(i.index ?? 2);
        const rad = big(i.radicand);

        if (rad === null || rad < 0n || !(n >= 2)) {
            return need('Enter the coefficient, the index and a non-negative whole-number radicand.');
        }

        const [out, inside] = simplifySqrt(rad, BigInt(n));
        const sym = n === 2 ? '√' : n === 3 ? '∛' : `${R.sup(n)}√`;
        const total = coef * out;

        return result(inside === 1n ? total.toString() : `${total === 1n ? '' : total}${sym}${inside}`, `${coef === 1n ? '' : coef}${sym}${rad} simplified`, { sub: f(Number(coef) * Number(rad) ** (1 / n), 12), rows: { decimal: f(Number(coef) * Number(rad) ** (1 / n), 15), factor: `${rad} = ${out ** BigInt(n)} × ${inside}` }, steps: [`${rad} = ${out}${R.sup(n)} × ${inside}`, `${sym}${rad} = ${out}${sym}${inside}`, coef === 1n ? '' : `${coef} × ${out}${sym}${inside} = ${total}${sym}${inside}`].filter(Boolean) });
    },

    perfect_power: (i, c) => {
        const n = big(i.n);
        const k = BigInt(c.power ?? 2);

        if (n === null) {
            return need('Enter a whole number.');
        }

        const root = n < 0n && k % 2n ? -N.iroot(-n, k) : n < 0n ? null : N.iroot(n, k);
        const word = k === 2n ? 'square' : 'cube';

        if (root === null) {
            return result(`No, ${n} is not a perfect ${word}`, `${n}`, { sub: 'Negative numbers are not perfect squares', rows: { root: 'None', lower: 'None', upper: '0' }, steps: [] });
        }

        const yes = root ** k === n;
        const lo = n < 0n ? root - 1n : root;

        return result(yes ? `Yes, ${fmtBig(n)} = ${root}${R.sup(Number(k))}` : `No, ${fmtBig(n)} is not a perfect ${word}`, yes ? `Perfect ${word}` : `Between ${lo}${R.sup(Number(k))} and ${lo + 1n}${R.sup(Number(k))}`, { sub: yes ? `${k === 2n ? '√' : '∛'}${n} = ${root}` : `${lo ** k} < ${n} < ${(lo + 1n) ** k}`, rows: { root: yes ? root.toString() : f(Math.sign(Number(n)) * Math.abs(Number(n)) ** (1 / Number(k)), 12), lower: `${lo ** k} = ${lo}${R.sup(Number(k))}`, upper: `${(lo + 1n) ** k} = ${lo + 1n}${R.sup(Number(k))}` }, steps: [`Integer ${word} root: ${root}`, `${root}${R.sup(Number(k))} = ${root ** k}${yes ? ' ✓' : ` ≠ ${n}`}`] });
    },

    rounding: (i, c) => {
        const x = q(i.x);

        if (!x) {
            return need('Enter a number to round.');
        }

        const place = c.place ?? i.place ?? '0.01';
        const mode = i.method ?? 'half-up';

        if (place === 'sig') {
            const n = Math.max(1, Math.min(40, Math.round(Number(i.sig ?? 3))));

            if (R.isZero(x)) {
                return result('0', 'Zero has no significant figures to round', { rows: { method: mode, up: '0', down: '0', truncated: '0' } });
            }

            const st = sigStep(x, n);
            const r = R.roundTo(x, st, mode);
            const showS = (v) => R.toDecimal(v, 60);

            return result(showS(r), `${dec(x)} to ${n} significant figure${n === 1 ? '' : 's'}`, { sub: sciText(sci(r)), rows: { method: mode, up: showS(R.roundTo(x, st, 'up')), down: showS(R.roundTo(x, st, 'down')), truncated: showS(R.roundTo(x, st, 'truncate')) }, steps: [`The ${n}th significant digit is in the ${t(st)} place`, `Round ${dec(x)} to a multiple of ${t(st)}: ${showS(r)}`] });
        }

        const step = R.parseNumber(place);
        const r = R.roundTo(x, step, mode);
        const placeName = { 1000: 'thousand', 100: 'hundred', 10: 'ten', 1: 'whole number', 0.1: 'tenth', 0.01: 'hundredth', 0.001: 'thousandth' }[R.toNumber(step)] ?? `multiple of ${t(step)}`;
        const show = (v) => R.toDecimal(v, Math.max(0, R.decimalPlaces(step) === Infinity ? 10 : R.decimalPlaces(step)), { keep: true }).replace(/^(−?)(\d+)/, (m, sg, d) => sg + R.group(d));

        return result(show(r), `${dec(x)} rounded to the nearest ${placeName}`, { sub: `${mode === 'half-up' ? 'Halves round away from zero' : mode === 'half-even' ? 'Halves round to the even digit (banker\'s rounding)' : mode === 'up' ? 'Always up (ceiling)' : mode === 'down' ? 'Always down (floor)' : 'Halves round towards zero'}`, rows: { method: mode, up: show(R.roundTo(x, step, 'up')), down: show(R.roundTo(x, step, 'down')), truncated: show(R.roundTo(x, step, 'truncate')) }, steps: [`Nearest multiples of ${t(step)}: ${show(R.roundTo(x, step, 'down'))} and ${show(R.roundTo(x, step, 'up'))}`, `${dec(x)} → ${show(r)}`] });
    },

    sig_figs: (i) => {
        const text = String(i.x ?? '').trim();
        const info = sigFigs(text);

        if (!info) {
            return need('Enter a number such as 0.004560 or 1.20e3.');
        }

        const x = q(text);
        const n = Number(i.round || 0);
        const rounded = n > 0 && x ? roundSig(x, n) : null;

        return result(`${info.count}${info.ambiguous ? ` to ${info.max}` : ''} significant figure${info.count === 1 && !info.ambiguous ? '' : 's'}`, text, { sub: info.ambiguous ? 'Trailing zeros without a decimal point are ambiguous; write it in scientific notation to be clear' : 'Leading zeros never count; zeros between digits and trailing zeros after a decimal point do', rows: { scientific: x ? sciText(sci(x)) : '', rounded: rounded ? R.toDecimal(rounded, 40) : 'Choose a number of figures to round', decimals: String((text.split('.')[1] ?? '').replace(/e.*/i, '').length) }, steps: ['Rules: non-zero digits count; zeros between them count; leading zeros do not; trailing zeros count only with a decimal point'] });
    },

    sci_notation: (i, c) => {
        const x = q(i.x);

        if (!x) {
            return need('Enter a number such as 0.000356 or 6.02e23.');
        }

        const s = sci(x);
        const engE = Math.floor(s.e / 3) * 3;
        const engM = R.div(x, R.pow(R.Q(10), engE));
        const mode = c.mode ?? 'sci';

        return result(mode === 'eng' ? `${R.toRepeating(engM)} × 10${R.sup(engE)}` : mode === 'standard' ? R.toDecimal(x, 40).replace(/^(−?)(\d+)/, (m, sg, d) => sg + R.group(d)) : sciText(s), mode === 'eng' ? 'Engineering notation' : mode === 'standard' ? 'Standard (decimal) notation' : 'Scientific notation', { sub: mode === 'standard' ? sciText(s) : `E notation ${R.toRepeating(s.m)}e${s.e}`, rows: { scientific: sciText(s), engineering: `${R.toRepeating(engM)} × 10${R.sup(engE)}`, standard: R.toDecimal(x, 40), e: `${R.toRepeating(s.m)}e${s.e}` }, steps: [`Move the decimal point ${Math.abs(s.e)} place${Math.abs(s.e) === 1 ? '' : 's'} ${s.e >= 0 ? 'left' : 'right'}: mantissa ${R.toRepeating(s.m)}`, `Exponent ${s.e}`] });
    },

    sci_arith: (i) => {
        const a = q(i.a);
        const b = q(i.b);
        const op = i.op ?? '*';

        if (!a || !b || (op === '/' && R.isZero(b))) {
            return need('Enter two numbers (6.02e23 or 3.1 × 10^4 written as 3.1e4).');
        }

        const r = { '+': R.add, '-': R.sub, '*': R.mul, '/': R.div }[op](a, b);
        const [sa, sb, sr] = [sci(a), sci(b), sci(r)];

        return result(sciText(sr), 'Result', { sub: `${sciText(sa)} ${{ '+': '+', '-': '−', '*': '×', '/': '÷' }[op]} ${sciText(sb)}`, rows: { scientific: sciText(sr), engineering: sciText(sr), standard: R.toDecimal(r, 40), e: `${R.toRepeating(sr.m)}e${sr.e}` }, steps: op === '*' || op === '/' ? [`Mantissas: ${R.toRepeating(sa.m)} ${op === '*' ? '×' : '÷'} ${R.toRepeating(sb.m)} = ${R.toRepeating(op === '*' ? R.mul(sa.m, sb.m) : R.div(sa.m, sb.m))}`, `Exponents: ${sa.e} ${op === '*' ? '+' : '−'} ${sb.e} = ${op === '*' ? sa.e + sb.e : sa.e - sb.e}`, `Normalise: ${sciText(sr)}`] : [`Line up the exponents, then ${op === '+' ? 'add' : 'subtract'}`, sciText(sr)] });
    },

    standard_form: (i) => {
        const x = q(i.x);

        if (!x) {
            return need('Enter a number.');
        }

        const s = sci(x);

        return result(sciText(s), 'Standard form (UK)', { sub: `In the US, "standard form" usually means the number written out: ${R.toDecimal(x, 40)}`, rows: { uk: sciText(s), us: R.toDecimal(x, 40), words: 'a × 10ⁿ with 1 ≤ a < 10' }, steps: [`${R.toDecimal(x, 40)} = ${sciText(s)}`] });
    },

    order_magnitude: (i) => {
        const x = q(i.x);

        if (!x || R.isZero(x)) {
            return need('Enter a non-zero number.');
        }

        const s = sci(x);
        const rounded = R.cmp(R.qabs(s.m), R.Q(316227766, 100000000)) >= 0 ? s.e + 1 : s.e;

        return result(fmtBig(BigInt(s.e)), 'Order of magnitude', { sub: `${R.toDecimal(x, 40)} ≈ 10${R.sup(rounded)} to the nearest power of ten`, rows: { scientific: sciText(s), nearest: `10${R.sup(rounded)} (rounding at √10 ≈ 3.16)` }, steps: [`${R.toDecimal(x, 40)} = ${sciText(s)}`, `Order of magnitude = ${s.e}`] });
    },

    stats: (i, c) => {
        const list = numbers(i.list);

        if (!list) {
            return need('Enter numbers separated by commas or spaces.');
        }

        const n = list.length;
        const sum = list.reduce((a, b) => R.add(a, b), R.ZERO);
        const mean = R.div(sum, R.Q(n));
        const sorted = [...list].sort(R.cmp);
        const median = n % 2 ? sorted[(n - 1) / 2] : R.div(R.add(sorted[n / 2 - 1], sorted[n / 2]), R.Q(2));
        const counts = new Map();
        list.forEach((v) => counts.set(t(v), (counts.get(t(v)) ?? 0) + 1));
        const maxCount = Math.max(...counts.values());
        const modes = maxCount > 1 ? [...counts.entries()].filter(([, k]) => k === maxCount).map(([v]) => v) : [];
        const nums = list.map(R.toNumber);
        const positive = nums.every((v) => v > 0);
        const geo = positive ? Math.exp(nums.reduce((s, v) => s + Math.log(v), 0) / n) : NaN;
        const harm = positive ? n / nums.reduce((s, v) => s + 1 / v, 0) : NaN;
        const rms = Math.sqrt(nums.reduce((s, v) => s + v * v, 0) / n);
        const kind = c.kind ?? 'mean';
        const rows = { mean: dec(mean), median: dec(median), mode: modes.length ? modes.join(', ') : 'No mode (no value repeats)', range: dec(R.sub(sorted[n - 1], sorted[0])), sum: dec(sum), count: String(n), geometric: positive ? f(geo, 12) : 'Needs positive numbers', harmonic: positive ? f(harm, 12) : 'Needs positive numbers', rms: f(rms, 12) };
        const main = { mean: [dec(mean), 'Mean (average)', `${dec(sum)} ÷ ${n}`], geometric: [positive ? f(geo, 12) : 'Undefined', 'Geometric mean', positive ? `(${nums.map((v) => f(v)).join(' × ')})^(1/${n})` : 'All values must be positive'], harmonic: [positive ? f(harm, 12) : 'Undefined', 'Harmonic mean', positive ? `${n} ÷ (${nums.map((v) => `1/${f(v)}`).join(' + ')})` : 'All values must be positive'], rms: [f(rms, 12), 'Root mean square', `√((${nums.map((v) => (v < 0 ? `(${f(v)})²` : `${f(v)}²`)).join(' + ')}) ÷ ${n})`] }[kind];

        return result(main[0], main[1], { sub: main[2].length > 120 ? `${n} values` : main[2], rows, steps: [`n = ${n}`, `Sum = ${dec(sum)}`, `Sorted: ${sorted.map((v) => dec(v)).join(', ')}`, `Mean = ${dec(mean)}, median = ${dec(median)}`] });
    },

    weighted: (i) => {
        const lines = String(i.items ?? '').split('\n').map((l) => l.trim()).filter(Boolean).map((l) => l.split(/[\s,;]+/).map((s) => R.parseNumber(s.replace('%', ''))));

        if (!lines.length || lines.some((l) => l.length < 2 || !l[0] || !l[1])) {
            return need('Enter one value and its weight per line, such as 85, 30.');
        }

        const tw = lines.reduce((s, l) => R.add(s, l[1]), R.ZERO);

        if (R.isZero(tw)) {
            return fail('The weights add up to zero.');
        }

        const sum = lines.reduce((s, l) => R.add(s, R.mul(l[0], l[1])), R.ZERO);
        const w = R.div(sum, tw);

        return result(dec(w), 'Weighted average', { sub: `${dec(sum)} ÷ ${dec(tw)}`, rows: { total: dec(tw), simple: dec(R.div(lines.reduce((s, l) => R.add(s, l[0]), R.ZERO), R.Q(lines.length))), sum: dec(sum) }, steps: [...lines.map((l) => `${dec(l[0])} × ${dec(l[1])} = ${dec(R.mul(l[0], l[1]))}`), `Σ = ${dec(sum)}, Σw = ${dec(tw)}`, `${dec(w)}`] });
    },

    sum_products: (i) => {
        const a = numbers(i.a);
        const b = numbers(i.b);

        if (!a || !b || a.length !== b.length) {
            return need('Enter two lists of the same length.');
        }

        const products = a.map((x, k) => R.mul(x, b[k]));
        const s = products.reduce((acc, p) => R.add(acc, p), R.ZERO);

        return result(dec(s), 'Sum of products', { sub: `${a.length} pairs`, rows: { count: String(a.length), sumA: dec(a.reduce((x, y) => R.add(x, y), R.ZERO)), sumB: dec(b.reduce((x, y) => R.add(x, y), R.ZERO)) }, steps: [...products.map((p, k) => `${dec(a[k])} × ${dec(b[k])} = ${dec(p)}`), `Sum = ${dec(s)}`] });
    },

    reciprocal: (i) => {
        let x = q(i.x);

        if (!x) {
            try {
                x = evalExact(parse(i.x));
            } catch {
                x = null;
            }
        }

        if (!x) {
            return need('Enter a number or fraction.');
        }

        if (R.isZero(x)) {
            return fail('Zero has no reciprocal.');
        }

        const r = R.inv(x);

        return result(t(r), `1 ÷ ${t(x)}`, { sub: `${dec(r)}`, rows: { decimal: dec(r), check: `${t(x)} × ${t(r)} = 1`, mixed: R.toMixed(r) }, steps: [`Flip the fraction: ${t(x)} → ${t(r)}`] });
    },

    powers_i: (i) => {
        const n = big(i.n);

        if (n === null) {
            return need('Enter a whole-number power.');
        }

        const k = N.mod(n, 4n);
        const v = ['1', 'i', '−1', '−i'][Number(k)];

        return result(v, `i${R.sup(n)}`, { sub: `${fmtBig(n)} mod 4 = ${k}`, rows: { cycle: 'i⁰ = 1, i¹ = i, i² = −1, i³ = −i, then repeats', remainder: k.toString() }, steps: [`${n} = 4 × ${R.bfloor(n, 4n)} + ${k}`, `i${R.sup(n)} = (i⁴)${R.sup(R.bfloor(n, 4n))} × i${R.sup(k)} = ${v}`] });
    },

    rational: (i) => {
        const text = String(i.x ?? '').trim();
        let verdict;
        let why;

        if (/π|pi|\be\b|phi|φ/i.test(text) && !/^[\d./\s]+$/.test(text)) {
            verdict = 'Irrational';
            why = 'π, e and φ are irrational, and so is any non-zero rational multiple of them (assuming the expression does not cancel)';
        } else if (/\.\d*\.\.\.$|…$/.test(text)) {
            verdict = 'Cannot tell from a cut-off decimal';
            why = 'A decimal written with … could repeat or not; write the repeating block in brackets, e.g. 0.(3)';
        } else {
            let tree;

            try {
                tree = parse(text);
            } catch {
                tree = null;
            }

            const exact = R.parseNumber(text) ?? (tree && evalExact(tree));
            const value = tree ? evalReal(tree) : NaN;
            const near = Number.isFinite(value) ? bestRational(value) : null;

            if (exact) {
                verdict = 'Rational';
                why = `It equals the fraction ${t(exact)}`;
            } else if (tree && hasRootOrPower(tree) && near) {
                verdict = 'Rational';
                why = `The roots cancel: it equals ${t(near)} (checked to 13 significant digits)`;
            } else if (tree && hasRootOrPower(tree)) {
                verdict = 'Irrational';
                why = 'A root of a whole number that is not a perfect power is irrational, and it does not cancel here';
            } else {
                return need('Enter a number, fraction, repeating decimal, root or expression.');
            }
        }

        return result(verdict, text, { sub: why, rows: { definition: 'Rational numbers can be written as p/q with integers p, q and q ≠ 0', decimal: verdict === 'Rational' ? 'Its decimal terminates or repeats' : 'Its decimal never terminates or repeats' }, steps: [why] });
    },

    rationalize: (i) => {
        const a = big(i.a);
        const b = big(i.b);
        const cc = big(i.c);
        const d = big(i.d) ?? 0n;

        if (a === null || b === null || cc === null || cc < 2n) {
            return need('Enter the numerator a and the denominator d + b√c (b ≠ 0, c ≥ 2).');
        }

        const [out, inside] = simplifySqrt(cc);

        if (d === 0n) {
            // a / (b√c) = a√c / (b c)
            const den = b * cc;
            const g = R.bgcd(a, den);

            return result(`${a / g === 1n ? '' : a / g}√${cc}/${den / g}`, 'Rationalised', { sub: `Multiply top and bottom by √${cc}`, rows: { decimal: f(Number(a) / (Number(b) * Math.sqrt(Number(cc))), 12), simplified: inside === 1n ? 'The root is rational' : `√${cc} = ${out === 1n ? '' : out}√${inside}` }, steps: [`${a}/(${b}√${cc}) × √${cc}/√${cc} = ${a}√${cc}/${den}`, g > 1n ? `Divide by ${g}` : ''].filter(Boolean) });
        }

        // a / (d + b√c) = a(d − b√c) / (d² − b²c)
        const den = d * d - b * b * cc;

        if (den === 0n) {
            return fail('The denominator is zero.');
        }

        return result(`${a === 1n ? '' : a}(${d} ${b < 0n ? '+' : '−'} ${R.babs(b) === 1n ? '' : R.babs(b)}√${cc})/${den}`, 'Rationalised with the conjugate', { sub: `Conjugate ${d} ${b < 0n ? '+' : '−'} ${R.babs(b) === 1n ? '' : R.babs(b)}√${cc}`, rows: { decimal: f(Number(a) / (Number(d) + Number(b) * Math.sqrt(Number(cc))), 12), simplified: `= (${a * d} ${a * b < 0n ? '+' : '−'} ${R.babs(a * b)}√${cc})/${den}` }, steps: [`Multiply by the conjugate (${d} − ${b}√${cc})/(${d} − ${b}√${cc})`, `Denominator: ${d}² − ${b}² × ${cc} = ${den}`] });
    },

    multiplicative_inverse: (i) => handlers.reciprocal(i),
};

export default defineTools(handlers);
export { both };
