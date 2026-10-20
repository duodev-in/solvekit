import { fmt } from './rational.js';

/**
 * Complex numbers { re, im } in double precision, with polar forms, powers, roots and a tidy text form.
 */
export const c = (re, im = 0) => ({ re, im });
export const add = (a, b) => c(a.re + b.re, a.im + b.im);
export const sub = (a, b) => c(a.re - b.re, a.im - b.im);
export const mul = (a, b) => c(a.re * b.re - a.im * b.im, a.re * b.im + a.im * b.re);
export const conj = (a) => c(a.re, -a.im);
export const abs = (a) => Math.hypot(a.re, a.im);
export const arg = (a) => Math.atan2(a.im, a.re);
export const polar = (r, t) => c(r * Math.cos(t), r * Math.sin(t));
export const neg = (a) => c(-a.re, -a.im);

export function div(a, b) {
    const d = b.re * b.re + b.im * b.im;

    return c((a.re * b.re + a.im * b.im) / d, (a.im * b.re - a.re * b.im) / d);
}

export function exp(a) {
    return polar(Math.exp(a.re), a.im);
}

export function log(a) {
    return c(Math.log(abs(a)), arg(a));
}

/** a^b with complex exponent (principal value); integer powers by repeated squaring for accuracy. */
export function pow(a, b) {
    if (b.im === 0 && Number.isInteger(b.re) && Math.abs(b.re) <= 1e6) {
        let n = Math.abs(b.re);
        let base = a;
        let r = c(1, 0);

        while (n > 0) {
            if (n & 1) {
                r = mul(r, base);
            }

            base = mul(base, base);
            n = Math.floor(n / 2);
        }

        return b.re < 0 ? div(c(1, 0), r) : r;
    }

    if (a.re === 0 && a.im === 0) {
        return c(0, 0);
    }

    return exp(mul(b, log(a)));
}

/** All n-th roots (De Moivre). */
export function roots(a, n) {
    const r = abs(a) ** (1 / n);
    const t = arg(a);

    return Array.from({ length: n }, (_, k) => polar(r, (t + 2 * Math.PI * k) / n));
}

const clean = (x) => (Math.abs(x) < 1e-12 ? 0 : x);

/** "3 + 4i", "−2i", "5" with up to `sig` significant digits. */
export function text(a, sig = 10) {
    const re = clean(a.re);
    const im = clean(a.im);
    const scaleRef = Math.max(Math.abs(re), Math.abs(im));
    const r = Math.abs(re) < 1e-12 * scaleRef ? 0 : re;
    const i = Math.abs(im) < 1e-12 * scaleRef ? 0 : im;

    if (i === 0) {
        return fmt(r, sig);
    }

    const iText = `${fmt(Math.abs(i), sig) === '1' ? '' : fmt(Math.abs(i), sig)}i`;

    if (r === 0) {
        return `${i < 0 ? '−' : ''}${iText}`;
    }

    return `${fmt(r, sig)} ${i < 0 ? '−' : '+'} ${iText}`;
}

/** Parses "3+4i", "-2i", "i", "5", "2.5 - 1/2 i" into a complex number (null when invalid). */
export function parse(textIn) {
    const s = String(textIn ?? '').replace(/\s+/g, '').replace(/[−–]/g, '-').replace(/j/g, 'i');

    if (!s) {
        return null;
    }

    const num = (t) => {
        if (t === '' || t === '+') {
            return 1;
        }

        if (t === '-') {
            return -1;
        }

        const m = t.match(/^([+-]?)(\d*\.?\d+(?:e[+-]?\d+)?)(?:\/(\d*\.?\d+))?$/i);

        return m ? (m[1] === '-' ? -1 : 1) * Number(m[2]) / (m[3] ? Number(m[3]) : 1) : NaN;
    };
    const m = s.match(/^([+-]?[^+-]*?(?:e[+-]\d+)?)?([+-][^+-]*)?i$/i);

    if (s.endsWith('i')) {
        const body = s.slice(0, -1);
        const split = body.search(/(?<=[^eE+-])[+-](?=[^+-]*$)/);

        if (split > 0) {
            const re = num(body.slice(0, split));
            const im = num(body.slice(split));

            return Number.isFinite(re) && Number.isFinite(im) ? c(re, im) : null;
        }

        const im = num(body);

        return Number.isFinite(im) ? c(0, im) : null;
    }

    void m;
    const re = num(s);

    return Number.isFinite(re) ? c(re, 0) : null;
}
