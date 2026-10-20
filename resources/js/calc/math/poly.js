import * as C from './complex.js';
import { factorize } from './numtheory.js';
import * as R from './rational.js';

/**
 * Polynomials with exact rational coefficients, stored low degree first: [c0, c1, …, cn].
 * Arithmetic, long and synthetic division, rational roots, factoring over the rationals, surds
 * for quadratics and numeric roots of any degree (Durand–Kerner polished by Newton).
 */
export const deg = (p) => p.length - 1;
export const lead = (p) => p[p.length - 1];

export function trim(p) {
    const out = [...p];

    while (out.length > 1 && R.isZero(out[out.length - 1])) {
        out.pop();
    }

    return out;
}

export const isZeroPoly = (p) => p.length === 1 && R.isZero(p[0]);
export const add = (a, b) => trim(Array.from({ length: Math.max(a.length, b.length) }, (_, k) => R.add(a[k] ?? R.ZERO, b[k] ?? R.ZERO)));
export const sub = (a, b) => trim(Array.from({ length: Math.max(a.length, b.length) }, (_, k) => R.sub(a[k] ?? R.ZERO, b[k] ?? R.ZERO)));
export const scale = (p, q) => trim(p.map((c) => R.mul(c, q)));

export function mul(a, b) {
    const out = Array.from({ length: a.length + b.length - 1 }, () => R.ZERO);

    a.forEach((x, i) => b.forEach((y, j) => {
        out[i + j] = R.add(out[i + j], R.mul(x, y));
    }));

    return trim(out);
}

/** Long division: { q, r, steps } with steps for the layout. */
export function divmod(a, b) {
    if (isZeroPoly(b)) {
        throw new RangeError('Division by zero polynomial');
    }

    let r = trim(a);
    const q = Array.from({ length: Math.max(1, a.length - b.length + 1) }, () => R.ZERO);
    const steps = [];

    while (!isZeroPoly(r) && deg(r) >= deg(b)) {
        const k = deg(r) - deg(b);
        const c = R.div(lead(r), lead(b));
        q[k] = c;
        const t = Array.from({ length: k + 1 }, (_, i) => (i === k ? c : R.ZERO));
        const product = mul(t, b);
        r = sub(r, product);
        steps.push({ term: t, product, remainder: r });
    }

    return { q: trim(q), r, steps };
}

export function evalAt(p, x) {
    return p.reduceRight((acc, c) => R.add(R.mul(acc, x), c), R.ZERO);
}

export function evalNumber(p, x) {
    return p.reduceRight((acc, c) => acc * x + R.toNumber(c), 0);
}

export const derivative = (p) => (p.length === 1 ? [R.ZERO] : trim(p.slice(1).map((c, k) => R.mul(c, R.Q(k + 1)))));

/** Monic gcd. */
export function gcd(a, b) {
    while (!isZeroPoly(b)) {
        [a, b] = [b, divmod(a, b).r];
    }

    return isZeroPoly(a) ? a : scale(a, R.inv(lead(a)));
}

/** Integer coefficients with positive leading term and their content: p = (num/den) × primitive. */
export function primitive(p) {
    const den = p.reduce((l, c) => R.blcm(l, c.d), 1n);
    const ints = p.map((c) => (c.n * den) / c.d);
    let g = ints.reduce((acc, c) => R.bgcd(acc, c), 0n) || 1n;

    if (ints[ints.length - 1] < 0n) {
        g = -g;
    }

    return { content: R.Q(g, den), poly: ints.map((c) => R.Q(c / g)) };
}

/** Candidate rational roots p/q (rational root theorem) for a polynomial with integer coefficients. */
export function rationalCandidates(p) {
    const { poly } = primitive(p);
    let low = 0;

    while (low < poly.length - 1 && R.isZero(poly[low])) {
        low += 1;
    }

    const a0 = R.babs(poly[low].n);
    const an = R.babs(lead(poly).n);
    const divs = (n) => {
        if (n === 0n) {
            return [1n];
        }

        if (n > 10n ** 15n) {
            return null;
        }

        let list = [1n];

        for (const [pr, e] of factorize(n)) {
            const next = [];

            list.forEach((d) => {
                let pk = 1n;

                for (let k = 0n; k <= e; k += 1n) {
                    next.push(d * pk);
                    pk *= pr;
                }
            });
            list = next;
        }

        return list;
    };
    const ps = divs(a0);
    const qs = divs(an);

    if (!ps || !qs || ps.length * qs.length > 20000) {
        return null;
    }

    const seen = new Map();

    ps.forEach((a) => qs.forEach((b) => {
        [R.Q(a, b), R.Q(-a, b)].forEach((c) => seen.set(R.toFraction(c), c));
    }));

    return [...seen.values()].sort((x, y) => R.cmp(R.qabs(x), R.qabs(y)) || R.cmp(x, y));
}

/** Rational roots with multiplicity and the remaining factor: { roots: [[r, m]], rest }. */
export function rationalRoots(p) {
    let rest = trim(p);
    const roots = [];
    let zeros = 0;

    while (rest.length > 1 && R.isZero(rest[0])) {
        rest = rest.slice(1);
        zeros += 1;
    }

    if (zeros) {
        roots.push([R.ZERO, zeros]);
    }

    const candidates = deg(rest) >= 1 ? rationalCandidates(rest) ?? [] : [];

    for (const c of candidates) {
        let m = 0;

        while (deg(rest) >= 1 && R.isZero(evalAt(rest, c))) {
            rest = divmod(rest, [R.neg(c), R.ONE]).q;
            m += 1;
        }

        if (m) {
            roots.push([c, m]);
        }
    }

    return { roots, rest };
}

/** √n simplified: n = a² × b → [a, b] for BigInt n ≥ 0. */
export function simplifySqrt(n, k = 2n) {
    n = BigInt(n);
    k = BigInt(k);

    if (n === 0n) {
        return [0n, 1n];
    }

    let outside = 1n;
    let inside = 1n;

    for (const [p, e] of factorize(n)) {
        outside *= p ** (e / k);
        inside *= p ** (e % k);
    }

    return [outside, inside];
}

/** Text for (a + b√r) / c with integers; r = 1 means no radical. */
export function surd(a, b, r, c = 1n) {
    a = BigInt(a);
    b = BigInt(b);
    r = BigInt(r);
    c = BigInt(c);

    if (r === 1n) {
        return R.toFraction(R.Q(a + b, c));
    }

    if (c < 0n) {
        [a, b, c] = [-a, -b, -c];
    }

    const g = [a, b, c].reduce((acc, v) => R.bgcd(acc, v), 0n) || 1n;
    [a, b, c] = [a / g, b / g, c / g];
    const rad = `${R.babs(b) === 1n ? '' : R.babs(b)}√${r}`;
    let top;

    if (a === 0n) {
        top = `${b < 0n ? '−' : ''}${rad}`;
    } else {
        top = `${R.toFraction(R.Q(a))} ${b < 0n ? '−' : '+'} ${rad}`;
    }

    return c === 1n ? top : a === 0n ? `${top}/${c}` : `(${top})/${c}`;
}

/** Exact roots of ax² + bx + c (rational coefficients): text forms and numeric values. */
export function quadraticRoots(a, b, c) {
    // Scale to integers.
    const den = [a, b, c].reduce((l, x) => R.blcm(l, x.d), 1n);
    const [A, B, Cc] = [a, b, c].map((x) => (x.n * den) / x.d);
    const disc = B * B - 4n * A * Cc;
    const twoA = 2n * A;

    if (disc >= 0n) {
        const [out, inside] = simplifySqrt(disc);

        if (inside === 1n) {
            return { disc, exact: [R.toFraction(R.Q(-B - out, twoA)), R.toFraction(R.Q(-B + out, twoA))], values: [Number(R.toNumber(R.Q(-B - out, twoA))), Number(R.toNumber(R.Q(-B + out, twoA)))], kind: disc === 0n ? 'one repeated real root' : 'two rational roots' };
        }

        const s = Math.sqrt(Number(disc));
        const v = [(-Number(B) - s) / Number(twoA), (-Number(B) + s) / Number(twoA)].sort((x, y) => x - y);

        return { disc, exact: [surd(-B, -out, inside, twoA), surd(-B, out, inside, twoA)], values: v, kind: 'two irrational real roots' };
    }

    const [out, inside] = simplifySqrt(-disc);
    const re = R.Q(-B, twoA);
    const imText = (sign) => {
        const g = R.bgcd(out, twoA) || 1n;
        let num = out / g;
        let den2 = twoA / g;

        if (den2 < 0n) {
            den2 = -den2;
            sign = -sign;
        }

        const coef = `${num === 1n && inside !== 1n ? '' : num}${inside === 1n ? '' : `√${inside}`}`;

        if (den2 !== 1n) {
            return `${sign < 0 ? '−' : '+'} (${coef}/${den2})i`;
        }

        return `${sign < 0 ? '−' : '+'} ${coef === '1' ? '' : coef}i`;
    };
    const reText = R.isZero(re) ? '' : `${R.toFraction(re)} `;
    const im = Math.sqrt(Number(-disc)) / Math.abs(Number(twoA));

    return { disc, exact: [`${reText}${imText(-1)}`.replace(/^\+ /, '').replace(/^− /, '−'), `${reText}${imText(1)}`.replace(/^\+ /, '').replace(/^− /, '−')], values: [C.c(R.toNumber(re), -im), C.c(R.toNumber(re), im)], kind: 'two complex conjugate roots' };
}

/** All complex roots numerically (Durand–Kerner, then Newton polishing). Coefficients may be rationals or numbers. */
export function numericRoots(p) {
    const coeffs = p.map((c) => (typeof c === 'number' ? c : R.toNumber(c)));

    while (coeffs.length > 1 && coeffs[coeffs.length - 1] === 0) {
        coeffs.pop();
    }

    const n = coeffs.length - 1;

    if (n < 1) {
        return [];
    }

    const a = coeffs.map((c) => c / coeffs[n]);
    const f = (z) => a.reduceRight((acc, c) => C.add(C.mul(acc, z), C.c(c, 0)), C.c(0, 0));
    const radius = 1 + Math.max(...a.slice(0, n).map(Math.abs));
    let z = Array.from({ length: n }, (_, k) => C.polar(radius * 0.9, (2 * Math.PI * k) / n + 0.4));

    for (let iter = 0; iter < 2000; iter += 1) {
        let delta = 0;

        z = z.map((zi, i) => {
            let denom = C.c(1, 0);

            z.forEach((zj, j) => {
                if (i !== j) {
                    denom = C.mul(denom, C.sub(zi, zj));
                }
            });
            const step = C.div(f(zi), denom);
            delta = Math.max(delta, C.abs(step));

            return C.sub(zi, step);
        });

        if (delta < 1e-15 * radius) {
            break;
        }
    }

    const df = (zz) => {
        let acc = C.c(0, 0);

        for (let k = n; k >= 1; k -= 1) {
            acc = C.add(C.mul(acc, zz), C.c(k * a[k], 0));
        }

        return acc;
    };

    return z.map((zi) => {
        let w = zi;

        for (let k = 0; k < 4; k += 1) {
            const d = df(w);

            if (C.abs(d) > 0) {
                w = C.sub(w, C.div(f(w), d));
            }
        }

        // Snap tiny imaginary parts of real roots.
        return Math.abs(w.im) < 1e-10 * Math.max(1, Math.abs(w.re)) ? C.c(w.re, 0) : w;
    }).sort((u, v) => u.re - v.re || u.im - v.im);
}

/** Polynomial text in a variable: 2x³ − x + 1/2. */
export function toText(p, x = 'x') {
    const terms = [];

    for (let k = p.length - 1; k >= 0; k -= 1) {
        const c = p[k];

        if (R.isZero(c) && !(p.length === 1)) {
            continue;
        }

        const abs = R.qabs(c);
        const coef = k === 0 ? R.toFraction(abs) : R.eq(abs, R.ONE) ? '' : abs.d === 1n ? R.toFraction(abs) : `(${R.toFraction(abs)})`;
        const v = k === 0 ? '' : k === 1 ? x : `${x}${R.sup(k)}`;
        terms.push({ neg: c.n < 0n, text: `${coef}${v}` || '0' });
    }

    if (!terms.length) {
        return '0';
    }

    return terms.map((t, i) => (i === 0 ? `${t.neg ? '−' : ''}${t.text}` : `${t.neg ? '−' : '+'} ${t.text}`)).join(' ');
}

const lin = (r, x) => {
    // (x − r) as text, or (qx − p) for r = p/q.
    if (R.isZero(r)) {
        return x;
    }

    if (r.d === 1n) {
        return `(${x} ${r.n < 0n ? '+' : '−'} ${R.babs(r.n)})`;
    }

    return `(${r.d}${x} ${r.n < 0n ? '+' : '−'} ${R.babs(r.n)})`;
};

/**
 * Factored form over the rationals: integer content × linear factors × an irreducible rest.
 * Quadratic rests stay as they are when they have no rational roots.
 */
export function factorText(p, x = 'x') {
    const { roots, rest } = rationalRoots(p);
    let k = R.ONE;
    const parts = [];

    roots.forEach(([r, m]) => {
        // (x − p/q) = (qx − p)/q: move 1/q into the constant.
        k = R.div(k, R.pow(R.Q(r.d), m));
        parts.push(`${lin(r, x)}${m > 1 ? R.sup(m) : ''}`);
    });

    const prim = primitive(rest);
    k = R.mul(k, prim.content);

    if (deg(prim.poly) >= 1) {
        parts.push(`(${toText(prim.poly, x)})`);
    }

    const constant = R.eq(k, R.ONE) ? '' : R.eq(k, R.Q(-1)) ? '−' : R.toFraction(k);

    if (!parts.length) {
        return R.toFraction(k);
    }

    if (parts.length === 1 && !constant && parts[0].startsWith('(') && parts[0].endsWith(')')) {
        return parts[0].slice(1, -1);
    }

    return `${constant}${parts.join('')}`;
}
