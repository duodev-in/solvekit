import { num } from '../physics/core.js';

/**
 * Shared helpers for the Statistics tools: number and probability text, exact counting with BigInt,
 * fractions, and the random sources (cryptographic for rolls and flips, seeded for repeatable simulations).
 */

/** Percentage text: 0.1234 → "12.34%". */
export const pct = (x, sig = 4) => `${num(x * 100, sig)}%`;

/** Probability with its percentage: "0.25 (25%)". */
export const prob = (x, sig = 6) => `${num(x, sig)} (${pct(x)})`;

/** "1 in 13,983,816" odds text (or "certain" / "impossible"). */
export const oneIn = (x, sig = 6) => (x >= 1 ? 'certain' : x <= 0 ? 'impossible' : `1 in ${num(1 / x, sig)}`);

/** p-value text: very small values in powers of ten. */
export const pText = (p) => (p < 1e-300 ? '< 1 × 10⁻³⁰⁰' : num(p, 4));

/** Greatest common divisor of two BigInts or numbers. */
export function gcd(a, b) {
    let x = a < 0 ? -a : a;
    let y = b < 0 ? -b : b;

    while (y) {
        [x, y] = [y, x % y];
    }

    return x;
}

/** A reduced fraction "13/27" from integers (BigInt or number). */
export function fraction(n, d) {
    const big = typeof n === 'bigint' || typeof d === 'bigint';
    const N = big ? BigInt(n) : n;
    const Dn = big ? BigInt(d) : d;
    const g = gcd(N, Dn) || (big ? 1n : 1);

    return `${(N / g).toLocaleString('en-US')}/${(Dn / g).toLocaleString('en-US')}`;
}

/** Exact n! and C(n, k), P(n, k) as BigInt. */
export function factorialBig(n) {
    let r = 1n;

    for (let k = 2n; k <= BigInt(n); k += 1n) {
        r *= k;
    }

    return r;
}

export function chooseBig(n, k) {
    if (k < 0 || k > n) {
        return 0n;
    }

    const kk = BigInt(Math.min(k, n - k));
    const N = BigInt(n);
    let r = 1n;

    for (let j = 1n; j <= kk; j += 1n) {
        r = (r * (N - kk + j)) / j;
    }

    return r;
}

/** Big integer text with thousands separators; very long ones shortened to scientific form. */
export function bigText(v) {
    const s = v.toString();

    if (s.length <= 21) {
        return BigInt(s).toLocaleString('en-US');
    }

    return `${s[0]}.${s.slice(1, 6)} × 10${String(s.length - 1).replace(/\d/g, (d) => '⁰¹²³⁴⁵⁶⁷⁸⁹'[d])}`;
}

/** Unbiased random integer in [0, n) from the browser's cryptographic generator (rejection sampling). */
export function randomInt(n) {
    const c = globalThis.crypto;

    if (!c?.getRandomValues) {
        return Math.floor(Math.random() * n);
    }

    const limit = Math.floor(0x100000000 / n) * n;
    const buffer = new Uint32Array(1);

    do {
        c.getRandomValues(buffer);
    } while (buffer[0] >= limit);

    return buffer[0] % n;
}

/** A seeded generator (mulberry32) so simulations repeat exactly for the same seed. */
export function seeded(seed) {
    let a = (Math.floor(seed) || 1) >>> 0;

    return () => {
        a = (a + 0x6d2b79f5) >>> 0;
        let t = a;
        t = Math.imul(t ^ (t >>> 15), t | 1);
        t ^= t + Math.imul(t ^ (t >>> 7), t | 61);

        return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
    };
}

/** Field definition helpers (same shape as the Physics tool tables). */
export const N = (label, value, min = null) => [label, null, null, value, min];
export const SEL = (label, options, value) => [label, 'select', options, value];
export const TXT = (label, value) => [label, 'textarea', null, value];
export const LINE = (label, value) => [label, 'text', null, value];
export { num };
