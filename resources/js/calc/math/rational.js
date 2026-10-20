/**
 * Exact rational numbers on BigInt: { n, d } with d > 0 and gcd(n, d) = 1. Parses integers, decimals, fractions,
 * mixed numbers ("1 1/2"), repeating decimals ("0.1(6)") and E notation without any floating-point rounding.
 */
export const babs = (a) => (a < 0n ? -a : a);

export function bgcd(a, b) {
    a = babs(a);
    b = babs(b);

    while (b) {
        [a, b] = [b, a % b];
    }

    return a;
}

export const blcm = (a, b) => (a === 0n || b === 0n ? 0n : babs((a / bgcd(a, b)) * b));

export function Q(n, d = 1n) {
    n = BigInt(n);
    d = BigInt(d);

    if (d === 0n) {
        throw new RangeError('Division by zero');
    }

    if (d < 0n) {
        n = -n;
        d = -d;
    }

    const g = bgcd(n, d) || 1n;

    return { n: n / g, d: d / g };
}

export const ZERO = Q(0);
export const ONE = Q(1);
export const isQ = (x) => x && typeof x.n === 'bigint' && typeof x.d === 'bigint';
export const add = (a, b) => Q(a.n * b.d + b.n * a.d, a.d * b.d);
export const sub = (a, b) => Q(a.n * b.d - b.n * a.d, a.d * b.d);
export const mul = (a, b) => Q(a.n * b.n, a.d * b.d);
export const div = (a, b) => Q(a.n * b.d, a.d * b.n);
export const neg = (a) => ({ n: -a.n, d: a.d });
export const qabs = (a) => ({ n: babs(a.n), d: a.d });
export const cmp = (a, b) => {
    const diff = a.n * b.d - b.n * a.d;

    return diff > 0n ? 1 : diff < 0n ? -1 : 0;
};
export const eq = (a, b) => a.n === b.n && a.d === b.d;
export const isZero = (a) => a.n === 0n;
export const isInt = (a) => a.d === 1n;
export const sign = (a) => (a.n > 0n ? 1 : a.n < 0n ? -1 : 0);
export const inv = (a) => Q(a.d, a.n);

/** Floor division of BigInts (towards −∞). */
export function bfloor(n, d) {
    const q = n / d;

    return (n % d !== 0n && (n < 0n) !== (d < 0n)) ? q - 1n : q;
}

export const floor = (a) => bfloor(a.n, a.d);
export const ceil = (a) => -bfloor(-a.n, a.d);

export function pow(a, k) {
    k = BigInt(k);

    if (k < 0n) {
        return pow(inv(a), -k);
    }

    return Q(a.n ** k, a.d ** k);
}

export function toNumber(a) {
    const n = Number(a.n);
    const d = Number(a.d);

    if (Number.isFinite(n) && Number.isFinite(d)) {
        return n / d;
    }

    // Very large parts: scale through a decimal string.
    return Number(toDecimal(a, 20).replace('…', ''));
}

/** Exact value of a double (every finite double is a rational). */
export function fromNumber(x) {
    if (!Number.isFinite(x)) {
        return null;
    }

    return parseNumber(String(x));
}

/**
 * Parses "−12", "3.25", "1.5e-3", "3/4", "-2 1/3", "0.1(6)", "1.2(45)", "45%" (as 45/100 when percent is allowed).
 * Returns null for anything else.
 */
export function parseNumber(text, { percent = false } = {}) {
    let s = String(text ?? '').trim().replace(/[−–]/g, '-').replace(/,/g, '').replace(/\s+/g, ' ');

    if (!s) {
        return null;
    }

    let scale = ONE;

    if (percent && s.endsWith('%')) {
        s = s.slice(0, -1).trim();
        scale = Q(1, 100);
    }

    let m = s.match(/^([+-]?)(\d+) (\d+)\/(\d+)$/);

    if (m) {
        const whole = BigInt(m[2]);
        const frac = Q(BigInt(m[3]), BigInt(m[4]));
        const value = add(Q(whole), frac);

        return mul(m[1] === '-' ? neg(value) : value, scale);
    }

    m = s.match(/^([+-]?[\d.()eE+-]+)\/([+-]?[\d.()eE+-]+)$/);

    if (m) {
        const a = parseNumber(m[1]);
        const b = parseNumber(m[2]);

        return a && b && !isZero(b) ? mul(div(a, b), scale) : null;
    }

    m = s.match(/^([+-]?)(\d*)(?:\.(\d*?)(?:\((\d+)\))?)?(?:[eE]([+-]?\d+))?$/);

    if (!m || (!m[2] && !m[3] && !m[4])) {
        return null;
    }

    const [, sg, intPart = '', fracPart = '', rep = '', exp = '0'] = m;
    let value = Q(BigInt(intPart || '0') * 10n ** BigInt(fracPart.length) + BigInt(fracPart || '0'), 10n ** BigInt(fracPart.length));

    if (rep) {
        // 0.ab(cd): the repeating block adds cd / (99 × 10^len(ab)).
        value = add(value, Q(BigInt(rep), (10n ** BigInt(rep.length) - 1n) * 10n ** BigInt(fracPart.length)));
    }

    const e = BigInt(exp);
    value = e >= 0n ? mul(value, Q(10n ** e)) : div(value, Q(10n ** -e));

    return mul(sg === '-' ? neg(value) : value, scale);
}

/** Parses a list of numbers separated by commas, spaces, semicolons or new lines. */
export function parseList(text, options) {
    return String(text ?? '').split(/[\s;,]+/).filter(Boolean).map((part) => parseNumber(part, options));
}

const group = (digits) => digits.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

/** "a/b" (or "a"), optionally grouped with thousands separators. */
export function toFraction(a, { grouping = false } = {}) {
    const n = grouping ? (a.n < 0n ? '−' : '') + group(babs(a.n).toString()) : (a.n < 0n ? '−' : '') + babs(a.n).toString();

    return a.d === 1n ? n : `${n}/${grouping ? group(a.d.toString()) : a.d}`;
}

/** Mixed number "2 1/3" (or the integer or proper fraction). */
export function toMixed(a) {
    const whole = babs(a.n) / a.d;
    const rest = babs(a.n) % a.d;
    const s = a.n < 0n ? '−' : '';

    if (rest === 0n) {
        return `${s}${whole}`;
    }

    return whole ? `${s}${whole} ${rest}/${a.d}` : `${s}${rest}/${a.d}`;
}

/**
 * Decimal expansion: { sign, int, fixed, repeat } with the repeating block found by long division
 * (up to `limit` digits; a longer period is reported as non-terminating without a block).
 */
export function expand(a, limit = 400) {
    const sign = a.n < 0n ? '−' : '';
    let r = babs(a.n) % a.d;
    const int = (babs(a.n) / a.d).toString();
    const seen = new Map();
    let digits = '';

    while (r !== 0n && !seen.has(r) && digits.length < limit) {
        seen.set(r, digits.length);
        r *= 10n;
        digits += (r / a.d).toString();
        r %= a.d;
    }

    if (r === 0n) {
        return { sign, int, fixed: digits, repeat: '', terminates: true };
    }

    if (seen.has(r)) {
        const at = seen.get(r);

        return { sign, int, fixed: digits.slice(0, at), repeat: digits.slice(at), terminates: false };
    }

    return { sign, int, fixed: digits, repeat: null, terminates: false };
}

/** "0.1(6)" style exact decimal, or the first digits followed by "…". */
export function toRepeating(a) {
    const e = expand(a);

    if (e.terminates) {
        return `${e.sign}${e.int}${e.fixed ? `.${e.fixed}` : ''}`;
    }

    return e.repeat === null ? `${e.sign}${e.int}.${e.fixed.slice(0, 30)}…` : `${e.sign}${e.int}.${e.fixed}(${e.repeat})`;
}

/** Decimal rounded half away from zero to `places` (exact), trailing zeros removed unless `keep`. */
export function toDecimal(a, places = 10, { keep = false } = {}) {
    const p = 10n ** BigInt(places);
    const scaled = babs(a.n) * p * 2n + a.d;
    const rounded = scaled / (2n * a.d);
    let s = rounded.toString().padStart(places + 1, '0');
    let out = places ? `${s.slice(0, -places)}.${s.slice(-places)}` : s;

    if (!keep && places) {
        out = out.replace(/0+$/, '').replace(/\.$/, '');
    }

    return (a.n < 0n && rounded !== 0n ? '−' : '') + out;
}

/** Exact rounding of a rational to a multiple of `step` (a rational), with a rounding mode. */
export function roundTo(a, step, mode = 'half-up') {
    const x = div(a, step);
    const f = floor(x);
    const frac = sub(x, Q(f));
    const half = Q(1, 2);
    let k;

    switch (mode) {
        case 'up': k = isZero(frac) ? f : f + 1n; break;
        case 'down': k = f; break;
        case 'truncate': k = x.n < 0n && !isZero(frac) ? f + 1n : f; break;
        case 'away': k = isZero(frac) ? f : x.n < 0n ? f : f + 1n; break;
        case 'half-even': {
            const c = cmp(frac, half);
            k = c < 0 ? f : c > 0 ? f + 1n : (f % 2n === 0n ? f : f + 1n);
            break;
        }
        case 'half-down': k = cmp(frac, half) > 0 ? f + 1n : f; break;
        default: {
            // Half away from zero, the school rule.
            const c = cmp(frac, half);
            k = c > 0 || (c === 0 && x.n >= 0n) ? f + 1n : f;
        }
    }

    return mul(Q(k), step);
}

/** Number of decimal places a terminating rational needs (Infinity when it repeats). */
export function decimalPlaces(a) {
    const e = expand(a);

    return e.terminates ? e.fixed.length : Infinity;
}

/** Formats a double for display: up to `sig` significant digits, no trailing zeros, scientific for extremes. */
export function fmt(x, sig = 10) {
    if (typeof x === 'bigint') {
        return x < 0n ? `−${group((-x).toString())}` : group(x.toString());
    }

    if (isQ(x)) {
        return toFraction(x);
    }

    if (!Number.isFinite(x)) {
        return Number.isNaN(x) ? 'undefined' : x > 0 ? '∞' : '−∞';
    }

    if (x !== 0 && (Math.abs(x) >= 1e15 || Math.abs(x) < 1e-6)) {
        const [m, e] = x.toExponential(sig - 1).split('e');

        return `${m.replace(/\.?0+$/, '').replace('-', '−')} × 10${sup(Number(e))}`;
    }

    let s = Number(x.toPrecision(sig)).toString();

    if (s.includes('e')) {
        s = Number(x.toPrecision(sig)).toFixed(Math.max(0, sig - Math.floor(Math.log10(Math.abs(x))) - 1));
    }

    const [i, f] = s.replace('-', '').split('.');

    return `${x < 0 && Number(s) !== 0 ? '−' : ''}${group(i)}${f ? `.${f}` : ''}`;
}

const SUP = { '-': '⁻', 0: '⁰', 1: '¹', 2: '²', 3: '³', 4: '⁴', 5: '⁵', 6: '⁶', 7: '⁷', 8: '⁸', 9: '⁹' };
const SUB = { 0: '₀', 1: '₁', 2: '₂', 3: '₃', 4: '₄', 5: '₅', 6: '₆', 7: '₇', 8: '₈', 9: '₉' };
export const sup = (n) => String(n).split('').map((c) => SUP[c] ?? c).join('');
export const subscript = (n) => String(n).split('').map((c) => SUB[c] ?? c).join('');
export { group };
