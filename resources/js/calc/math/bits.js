/**
 * Fixed-width integers on BigInt: parsing binary, hex, octal and decimal input, two's-complement views,
 * logic and arithmetic at a chosen width, shifts and rotates, binary fractions and IEEE 754 fields.
 */
export function parseInteger(text, base = 'auto') {
    let s = String(text ?? '').trim().replace(/[\s_]/g, '').replace(/[−–]/g, '-').toLowerCase();
    let sign = 1n;

    if (s.startsWith('-')) {
        sign = -1n;
        s = s.slice(1);
    }

    let radix = base === 'auto' ? 10 : Number(base);

    if (base === 'auto' || base === 2 || base === 16 || base === 8) {
        if (s.startsWith('0b')) {
            radix = 2;
            s = s.slice(2);
        } else if (s.startsWith('0x')) {
            radix = 16;
            s = s.slice(2);
        } else if (s.startsWith('0o')) {
            radix = 8;
            s = s.slice(2);
        }
    }

    const digits = '0123456789abcdefghijklmnopqrstuvwxyz'.slice(0, radix);

    if (!s || [...s].some((c) => !digits.includes(c))) {
        return null;
    }

    let v = 0n;

    for (const c of s) {
        v = v * BigInt(radix) + BigInt(digits.indexOf(c));
    }

    return sign * v;
}

export const mask = (bits) => (1n << BigInt(bits)) - 1n;

/** Wraps any integer into the width (two's complement bit pattern, unsigned 0 … 2ⁿ − 1). */
export const wrap = (v, bits) => ((v % (1n << BigInt(bits))) + (1n << BigInt(bits))) % (1n << BigInt(bits));

/** Signed value of a bit pattern. */
export function signed(pattern, bits) {
    const b = BigInt(bits);

    return pattern >= 1n << (b - 1n) ? pattern - (1n << b) : pattern;
}

export function inRange(v, bits, isSigned) {
    const b = BigInt(bits);

    return isSigned ? v >= -(1n << (b - 1n)) && v < 1n << (b - 1n) : v >= 0n && v < 1n << b;
}

/** Binary string grouped in fours. */
export function binary(pattern, bits) {
    return pattern.toString(2).padStart(bits, '0').replace(/\B(?=(\d{4})+(?!\d))/g, ' ');
}

export const hex = (pattern, bits) => pattern.toString(16).toUpperCase().padStart(Math.ceil(bits / 4), '0');

export function bitOp(op, a, b, bits) {
    const m = mask(bits);
    const A = wrap(a, bits);
    const B = wrap(b, bits);

    switch (op) {
        case 'and': return A & B;
        case 'or': return A | B;
        case 'xor': return A ^ B;
        case 'nand': return ~(A & B) & m;
        case 'nor': return ~(A | B) & m;
        case 'xnor': return ~(A ^ B) & m;
        case 'not': return ~A & m;
        default: return null;
    }
}

/** Shift or rotate: 'left', 'right' (logical), 'arith' (arithmetic right), 'rol', 'ror'. */
export function shift(a, n, kind, bits) {
    const b = BigInt(bits);
    const k = BigInt(n) % (kind === 'rol' || kind === 'ror' ? b : b + 1n);
    const A = wrap(a, bits);
    const m = mask(bits);

    switch (kind) {
        case 'left': return (A << k) & m;
        case 'right': return A >> k;
        case 'arith': return wrap(signed(A, bits) >> k, bits);
        case 'rol': return ((A << k) | (A >> (b - k))) & m;
        case 'ror': return ((A >> k) | (A << (b - k))) & m;
        default: return null;
    }
}

/** Binary representation of a decimal fraction (up to `places` bits), exact for terminating cases. */
export function fractionToBinary(text, places = 32) {
    const m = String(text).trim().match(/^(-?)(\d*)(?:\.(\d+))?$/);

    if (!m) {
        return null;
    }

    const int = BigInt(m[2] || '0');
    const frac = m[3] ?? '';
    let num = BigInt(frac || '0');
    const den = 10n ** BigInt(frac.length);
    let bitsOut = '';

    for (let k = 0; k < places && num !== 0n; k += 1) {
        num *= 2n;
        bitsOut += num >= den ? '1' : '0';
        num = num >= den ? num - den : num;
    }

    return { sign: m[1], int: int.toString(2), frac: bitsOut, exact: num === 0n };
}

/** Value of a binary string with a point ("101.011"). */
export function binaryToDecimal(text) {
    const m = String(text).trim().match(/^(-?)([01]*)(?:\.([01]+))?$/);

    if (!m) {
        return null;
    }

    const int = m[2] ? BigInt(`0b${m[2]}`) : 0n;
    const frac = m[3] ?? '';
    // Exact decimal: frac / 2^len = frac × 5^len / 10^len.
    const fracDigits = frac ? (BigInt(`0b${frac}`) * 5n ** BigInt(frac.length)).toString().padStart(frac.length, '0') : '';

    return `${m[1]}${int}${fracDigits ? `.${fracDigits.replace(/0+$/, '')}` : ''}`;
}

const FORMATS = { 16: [5, 10], 32: [8, 23], 64: [11, 52] };

/** IEEE 754 fields of a number at 16, 32 or 64 bits. */
export function ieee754(x, bits = 32) {
    const buffer = new ArrayBuffer(8);
    const view = new DataView(buffer);
    let pattern;

    if (bits === 64) {
        view.setFloat64(0, x);
        pattern = view.getBigUint64(0);
    } else if (bits === 32) {
        view.setFloat32(0, x);
        pattern = BigInt(view.getUint32(0));
    } else {
        pattern = BigInt(toHalf(x));
    }

    const [eBits, mBits] = FORMATS[bits];
    const sign = pattern >> BigInt(bits - 1);
    const exp = (pattern >> BigInt(mBits)) & mask(eBits);
    const man = pattern & mask(mBits);
    const stored = fromPattern(pattern, bits);

    return { pattern, sign, exp, man, eBits, mBits, bias: 2 ** (eBits - 1) - 1, stored };
}

export function fromPattern(pattern, bits) {
    const [eBits, mBits] = FORMATS[bits];
    const sign = Number(pattern >> BigInt(bits - 1)) ? -1 : 1;
    const exp = Number((pattern >> BigInt(mBits)) & mask(eBits));
    const man = Number(pattern & mask(mBits));
    const bias = 2 ** (eBits - 1) - 1;

    if (exp === 2 ** eBits - 1) {
        return man ? NaN : sign * Infinity;
    }

    if (exp === 0) {
        return sign * (man / 2 ** mBits) * 2 ** (1 - bias);
    }

    return sign * (1 + man / 2 ** mBits) * 2 ** (exp - bias);
}

/** Nearest binary16 pattern to a double (round half to even, one rounding step). */
function toHalf(x) {
    if (Number.isNaN(x)) {
        return 0x7e00;
    }

    const sign = x < 0 || Object.is(x, -0) ? 0x8000 : 0;
    const a = Math.abs(x);

    if (a === Infinity) {
        return sign | 0x7c00;
    }

    if (a === 0) {
        return sign;
    }

    const roundEven = (v) => {
        const fl = Math.floor(v);
        const diff = v - fl;

        return diff > 0.5 || (diff === 0.5 && fl % 2 === 1) ? fl + 1 : fl;
    };
    let e = Math.floor(Math.log2(a));

    if (2 ** e > a) {
        e -= 1;
    } else if (2 ** (e + 1) <= a) {
        e += 1;
    }

    if (e < -14) {
        // Subnormal: units of 2^−24.
        const m = roundEven(a / 2 ** -24);

        return sign | m;
    }

    let m = roundEven((a / 2 ** e - 1) * 1024);

    if (m === 1024) {
        m = 0;
        e += 1;
    }

    if (e + 15 >= 31) {
        return sign | 0x7c00;
    }

    return sign | ((e + 15) << 10) | m;
}

export const toGray = (n) => n ^ (n >> 1n);

export function fromGray(g) {
    let n = g;

    for (let s = g >> 1n; s; s >>= 1n) {
        n ^= s;
    }

    return n;
}
