/**
 * Bits, codes and text for the Technology section: UTF-8 bytes, Base64 (RFC 4648), ciphers, Morse (ITU-R M.1677-1),
 * T9 multi-tap (ITU E.161), Unicode text styles, parity and Hamming codes, hashes (MD5 RFC 1321, SHA FIPS 180-4),
 * chmod modes, colour models and UUIDs (RFC 9562). Everything runs in the browser.
 */

const enc = new TextEncoder();
const dec = new TextDecoder('utf-8', { fatal: true });

/** UTF-8 bytes of a string. */
export const utf8 = (text) => [...enc.encode(String(text ?? ''))];

/** Decodes UTF-8 bytes; returns null when they are not valid UTF-8. */
export function fromUtf8(bytes) {
    try {
        return dec.decode(new Uint8Array(bytes));
    } catch {
        return null;
    }
}

/** Reads bytes written in a base (2 or 16), with or without separators. Returns { bytes } or { problem }. */
export function parseBytes(text, base) {
    const clean = String(text ?? '').trim().replace(/0x/gi, '').replace(/[,;]/g, ' ');

    if (!clean) {
        return { bytes: [] };
    }

    const width = base === 2 ? 8 : 2;
    const valid = base === 2 ? /^[01]+$/ : /^[0-9a-f]+$/i;
    const groups = clean.split(/\s+/);
    const tokens = groups.length > 1 && groups.every((g) => g.length <= width) ? groups : clean.replace(/\s+/g, '').match(new RegExp(`.{1,${width}}`, 'g'));

    if (!tokens.every((t) => valid.test(t))) {
        return { problem: base === 2 ? 'Binary may only contain 0 and 1 (in groups of 8).' : 'Hex may only contain 0–9 and A–F.' };
    }

    if (groups.length === 1 && clean.replace(/\s+/g, '').length % width) {
        return { problem: base === 2 ? 'The number of bits is not a multiple of 8; separate bytes with spaces.' : 'An odd number of hex digits; each byte needs two.' };
    }

    return { bytes: tokens.map((t) => parseInt(t, base)) };
}

export const byteText = (bytes, base) => bytes.map((b) => b.toString(base).padStart(base === 2 ? 8 : 2, '0').toUpperCase()).join(' ');

const B64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

/** Base64 of bytes (RFC 4648 §4, or §5 URL-safe without padding). */
export function base64(bytes, urlSafe = false) {
    let out = '';

    for (let i = 0; i < bytes.length; i += 3) {
        const n = (bytes[i] << 16) | ((bytes[i + 1] ?? 0) << 8) | (bytes[i + 2] ?? 0);
        out += B64[(n >> 18) & 63] + B64[(n >> 12) & 63] + (i + 1 < bytes.length ? B64[(n >> 6) & 63] : '=') + (i + 2 < bytes.length ? B64[n & 63] : '=');
    }

    return urlSafe ? out.replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '') : out;
}

/** Bytes from Base64 (standard or URL-safe, padding optional). Returns { bytes } or { problem }. */
export function fromBase64(text) {
    const clean = String(text ?? '').replace(/\s+/g, '').replace(/-/g, '+').replace(/_/g, '/');

    if (!/^[A-Za-z0-9+/]*={0,2}$/.test(clean) || clean.replace(/=+$/, '').length % 4 === 1) {
        return { problem: 'This is not valid Base64 (A–Z, a–z, 0–9, + and / or - and _, with = padding).' };
    }

    const body = clean.replace(/=+$/, '');
    const bytes = [];

    for (let i = 0; i < body.length; i += 4) {
        const chunk = body.slice(i, i + 4);
        const n = [...chunk.padEnd(4, 'A')].reduce((acc, c) => (acc << 6) | B64.indexOf(c), 0);
        bytes.push((n >> 16) & 255);

        if (chunk.length > 2) {
            bytes.push((n >> 8) & 255);
        }

        if (chunk.length > 3) {
            bytes.push(n & 255);
        }
    }

    return { bytes };
}

/** Caesar shift of letters (other characters unchanged). */
export const caesar = (text, shift) => String(text ?? '').replace(/[a-z]/gi, (c) => {
    const base = c <= 'Z' ? 65 : 97;

    return String.fromCharCode(((((c.charCodeAt(0) - base + shift) % 26) + 26) % 26) + base);
});

/** Vigenère cipher (key letters only; non-letters pass through without using the key). */
export function vigenere(text, key, decrypt = false) {
    const shifts = [...String(key ?? '').toUpperCase().replace(/[^A-Z]/g, '')].map((c) => c.charCodeAt(0) - 65);

    if (!shifts.length) {
        return null;
    }

    let k = 0;

    return String(text ?? '').replace(/[a-z]/gi, (c) => {
        const s = shifts[k % shifts.length] * (decrypt ? -1 : 1);
        k += 1;

        return caesar(c, s);
    });
}

/** International Morse code, ITU-R M.1677-1 (! is a common non-ITU extra). */
export const MORSE = {
    A: '.-', B: '-...', C: '-.-.', D: '-..', E: '.', F: '..-.', G: '--.', H: '....', I: '..', J: '.---', K: '-.-', L: '.-..', M: '--', N: '-.', O: '---', P: '.--.', Q: '--.-', R: '.-.', S: '...', T: '-', U: '..-', V: '...-', W: '.--', X: '-..-', Y: '-.--', Z: '--..',
    1: '.----', 2: '..---', 3: '...--', 4: '....-', 5: '.....', 6: '-....', 7: '--...', 8: '---..', 9: '----.', 0: '-----',
    '.': '.-.-.-', ',': '--..--', ':': '---...', '?': '..--..', "'": '.----.', '-': '-....-', '/': '-..-.', '(': '-.--.', ')': '-.--.-', '"': '.-..-.', '=': '-...-', '+': '.-.-.', '@': '.--.-.', '!': '-.-.--',
};
const FROM_MORSE = Object.fromEntries(Object.entries(MORSE).map(([k, v]) => [v, k]));

export const toMorse = (text) => String(text ?? '').toUpperCase().trim().split(/\s+/).map((word) => [...word].map((c) => MORSE[c] ?? '?').join(' ')).join(' / ');

export const fromMorse = (code) => String(code ?? '').replace(/[•·]/g, '.').replace(/[–—−_]/g, '-').trim().split(/\s*[/|]\s*|\s{3,}/).map((word) => word.split(/\s+/).map((c) => FROM_MORSE[c] ?? '?').join('')).join(' ');

/** Morse length in timing units: dot 1, dash 3, gap 1 inside a letter, 3 between letters, 7 between words. */
export function morseUnits(code) {
    const words = code.split(' / ');

    return words.reduce((t, word, w) => t + (w ? 7 : 0) + word.split(' ').reduce((u, letter, l) => u + (l ? 3 : 0) + [...letter].reduce((v, s, k) => v + (k ? 1 : 0) + (s === '.' ? 1 : 3), 0), 0), 0);
}

/** Keypad letters (ITU E.161). */
export const T9 = { 2: 'ABC', 3: 'DEF', 4: 'GHI', 5: 'JKL', 6: 'MNO', 7: 'PQRS', 8: 'TUV', 9: 'WXYZ', 0: ' ' };

/** Multi-tap: "44 33 555 555 666" → "HELLO"; groups separated by spaces, 0 = space. */
export function fromT9(text) {
    return String(text ?? '').trim().split(/\s+/).filter(Boolean).map((g) => {
        if (!/^(\d)\1*$/.test(g) || !T9[g[0]]) {
            return '?';
        }

        const letters = T9[g[0]];

        return letters[(g.length - 1) % letters.length];
    }).join('');
}

export const toT9 = (text) => [...String(text ?? '').toUpperCase()].map((c) => {
    const key = Object.entries(T9).find(([, letters]) => letters.includes(c));

    return key ? key[0].repeat(key[1].indexOf(c) + 1) : '';
}).filter(Boolean).join(' ');

const SUP = { 0: '⁰', 1: '¹', 2: '²', 3: '³', 4: '⁴', 5: '⁵', 6: '⁶', 7: '⁷', 8: '⁸', 9: '⁹', '+': '⁺', '-': '⁻', '=': '⁼', '(': '⁽', ')': '⁾', a: 'ᵃ', b: 'ᵇ', c: 'ᶜ', d: 'ᵈ', e: 'ᵉ', f: 'ᶠ', g: 'ᵍ', h: 'ʰ', i: 'ⁱ', j: 'ʲ', k: 'ᵏ', l: 'ˡ', m: 'ᵐ', n: 'ⁿ', o: 'ᵒ', p: 'ᵖ', r: 'ʳ', s: 'ˢ', t: 'ᵗ', u: 'ᵘ', v: 'ᵛ', w: 'ʷ', x: 'ˣ', y: 'ʸ', z: 'ᶻ', A: 'ᴬ', B: 'ᴮ', D: 'ᴰ', E: 'ᴱ', G: 'ᴳ', H: 'ᴴ', I: 'ᴵ', J: 'ᴶ', K: 'ᴷ', L: 'ᴸ', M: 'ᴹ', N: 'ᴺ', O: 'ᴼ', P: 'ᴾ', R: 'ᴿ', T: 'ᵀ', U: 'ᵁ', V: 'ⱽ', W: 'ᵂ', ' ': ' ' };
const SUB = { 0: '₀', 1: '₁', 2: '₂', 3: '₃', 4: '₄', 5: '₅', 6: '₆', 7: '₇', 8: '₈', 9: '₉', '+': '₊', '-': '₋', '=': '₌', '(': '₍', ')': '₎', a: 'ₐ', e: 'ₑ', h: 'ₕ', i: 'ᵢ', j: 'ⱼ', k: 'ₖ', l: 'ₗ', m: 'ₘ', n: 'ₙ', o: 'ₒ', p: 'ₚ', r: 'ᵣ', s: 'ₛ', t: 'ₜ', u: 'ᵤ', v: 'ᵥ', x: 'ₓ', ' ': ' ' };
const SMALL_CAPS = { a: 'ᴀ', b: 'ʙ', c: 'ᴄ', d: 'ᴅ', e: 'ᴇ', f: 'ꜰ', g: 'ɢ', h: 'ʜ', i: 'ɪ', j: 'ᴊ', k: 'ᴋ', l: 'ʟ', m: 'ᴍ', n: 'ɴ', o: 'ᴏ', p: 'ᴘ', r: 'ʀ', s: 'ꜱ', t: 'ᴛ', u: 'ᴜ', v: 'ᴠ', w: 'ᴡ', y: 'ʏ', z: 'ᴢ' };
const MIRROR = { b: 'd', d: 'b', p: 'q', q: 'p', a: 'ɒ', c: 'ɔ', e: 'ɘ', s: 'ꙅ', '(': ')', ')': '(', '[': ']', ']': '[', '{': '}', '}': '{', '<': '>', '>': '<', '/': '\\', '\\': '/', '?': '⸮', B: 'ᙠ', C: 'Ɔ', D: 'ᗡ', E: 'Ǝ', J: 'Ⴑ', L: '⅃', N: 'И', R: 'Я', S: 'Ꙅ', Z: 'Ƹ' };

/** Maps characters through a table; returns the text and the characters that had no mapping. */
function mapChars(text, table, { lower = false } = {}) {
    const missing = new Set();
    const out = [...String(text ?? '')].map((c) => {
        const key = lower ? c.toLowerCase() : c;

        if (table[key] !== undefined) {
            return table[key];
        }

        if (/\S/.test(c)) {
            missing.add(c);
        }

        return c;
    }).join('');

    return { text: out, missing: [...missing] };
}

export const superscript = (text) => mapChars(text, SUP);
export const subscript = (text) => mapChars(text, SUB);
export const smallCaps = (text) => mapChars(text, SMALL_CAPS, { lower: true });
export const smallText = (text) => mapChars(text, { ...SUP, ...Object.fromEntries(Object.entries(SUP).filter(([k]) => /[a-z]/.test(k)).map(([k, v]) => [k.toUpperCase(), v])) });

export function mirror(text) {
    return [...String(text ?? '')].reverse().map((c) => MIRROR[c] ?? c).join('');
}

/** Fraktur from the Mathematical Alphanumeric Symbols block (C, H, I, R, Z use the Letterlike Symbols code points). */
export function fraktur(text, bold = false) {
    const EXCEPT = { C: 'ℭ', H: 'ℌ', I: 'ℑ', R: 'ℜ', Z: 'ℨ' };

    return [...String(text ?? '')].map((c) => {
        const code = c.codePointAt(0);

        if (c >= 'A' && c <= 'Z') {
            return !bold && EXCEPT[c] ? EXCEPT[c] : String.fromCodePoint((bold ? 0x1d56c : 0x1d504) + code - 65);
        }

        if (c >= 'a' && c <= 'z') {
            return String.fromCodePoint((bold ? 0x1d586 : 0x1d51e) + code - 97);
        }

        return c;
    }).join('');
}

/** Strikethrough with a combining overlay after each character. */
export const strike = (text, mark = '̶') => [...String(text ?? '')].map((c) => (c === '\n' ? c : c + mark)).join('');

/** Even or odd parity bit for a bit string. */
export function parityBit(bits, odd = false) {
    const ones = [...bits].filter((b) => b === '1').length;

    return { ones, bit: (ones + (odd ? 1 : 0)) % 2 };
}

/** Hamming SEC code (parity at positions 1, 2, 4, …), with an optional overall parity bit for SECDED. */
export function hammingEncode(data, { odd = false, secded = false } = {}) {
    const d = [...data].map(Number);
    let r = 0;

    while (2 ** r < d.length + r + 1) {
        r += 1;
    }

    const n = d.length + r;
    const code = new Array(n + 1).fill(0);
    let k = 0;

    for (let pos = 1; pos <= n; pos += 1) {
        if ((pos & (pos - 1)) !== 0) {
            code[pos] = d[k];
            k += 1;
        }
    }

    const parity = [];

    for (let p = 0; p < r; p += 1) {
        const bit = 2 ** p;
        let x = odd ? 1 : 0;

        for (let pos = 1; pos <= n; pos += 1) {
            if (pos & bit && pos !== bit) {
                x ^= code[pos];
            }
        }

        code[bit] = x;
        parity.push([bit, x]);
    }

    let word = code.slice(1);

    if (secded) {
        word = [...word, word.reduce((a, b) => a ^ b, odd ? 1 : 0)];
    }

    return { word: word.join(''), r, parity };
}

/** Decodes a Hamming code word: syndrome, corrected word, data bits, and the error verdict. */
export function hammingDecode(received, { odd = false, secded = false } = {}) {
    const bits = [...received].map(Number);
    const overall = secded ? bits.reduce((a, b) => a ^ b, odd ? 1 : 0) : 0;
    const word = secded ? bits.slice(0, -1) : bits;
    const n = word.length;
    let syndrome = 0;

    for (let bit = 1; bit <= n; bit *= 2) {
        let x = odd ? 1 : 0;

        for (let pos = 1; pos <= n; pos += 1) {
            if (pos & bit) {
                x ^= word[pos - 1];
            }
        }

        if (x) {
            syndrome += bit;
        }
    }

    const fixed = [...word];
    let verdict;

    if (secded && syndrome && !overall) {
        verdict = 'Two bits are wrong: detected but cannot be corrected';
    } else if (syndrome && syndrome <= n) {
        fixed[syndrome - 1] ^= 1;
        verdict = `Bit ${syndrome} was wrong and has been corrected`;
    } else if (syndrome) {
        verdict = 'More than one bit is wrong (the syndrome points outside the word)';
    } else {
        verdict = secded && overall ? 'Only the overall parity bit was wrong' : 'No error found';
    }

    const data = fixed.filter((_, i) => ((i + 1) & i) !== 0).join('');

    return { syndrome, fixed: fixed.join(''), data, verdict };
}

/** Hamming distance between two equal-length strings, with the differing positions. */
export function hammingDistance(a, b) {
    const x = [...a];
    const y = [...b];

    if (x.length !== y.length) {
        return null;
    }

    const positions = x.map((c, i) => (c !== y[i] ? i + 1 : 0)).filter(Boolean);

    return { distance: positions.length, positions };
}

/* ---------- Hashes (pure JS, synchronous) ---------- */

const hex32 = (n) => (n >>> 0).toString(16).padStart(8, '0');

/** MD5 (RFC 1321). */
export function md5(bytes) {
    const K = Array.from({ length: 64 }, (_, i) => Math.floor(Math.abs(Math.sin(i + 1)) * 2 ** 32) >>> 0);
    const S = [7, 12, 17, 22, 7, 12, 17, 22, 7, 12, 17, 22, 7, 12, 17, 22, 5, 9, 14, 20, 5, 9, 14, 20, 5, 9, 14, 20, 5, 9, 14, 20, 4, 11, 16, 23, 4, 11, 16, 23, 4, 11, 16, 23, 4, 11, 16, 23, 6, 10, 15, 21, 6, 10, 15, 21, 6, 10, 15, 21, 6, 10, 15, 21];
    const msg = [...bytes, 0x80];

    while (msg.length % 64 !== 56) {
        msg.push(0);
    }

    const bitLen = bytes.length * 8;

    for (let i = 0; i < 8; i += 1) {
        msg.push(Math.floor(bitLen / 2 ** (8 * i)) & 255);
    }

    let [a0, b0, c0, d0] = [0x67452301, 0xefcdab89, 0x98badcfe, 0x10325476];

    for (let off = 0; off < msg.length; off += 64) {
        const M = Array.from({ length: 16 }, (_, j) => msg[off + 4 * j] | (msg[off + 4 * j + 1] << 8) | (msg[off + 4 * j + 2] << 16) | (msg[off + 4 * j + 3] << 24));
        let [A, B, C, D] = [a0, b0, c0, d0];

        for (let i = 0; i < 64; i += 1) {
            let F;
            let g;

            if (i < 16) {
                F = (B & C) | (~B & D);
                g = i;
            } else if (i < 32) {
                F = (D & B) | (~D & C);
                g = (5 * i + 1) % 16;
            } else if (i < 48) {
                F = B ^ C ^ D;
                g = (3 * i + 5) % 16;
            } else {
                F = C ^ (B | ~D);
                g = (7 * i) % 16;
            }

            const tmp = D;
            D = C;
            C = B;
            const sum = (A + F + K[i] + M[g]) | 0;
            B = (B + ((sum << S[i]) | (sum >>> (32 - S[i])))) | 0;
            A = tmp;
        }

        a0 = (a0 + A) | 0;
        b0 = (b0 + B) | 0;
        c0 = (c0 + C) | 0;
        d0 = (d0 + D) | 0;
    }

    return [a0, b0, c0, d0].map((v) => [0, 8, 16, 24].map((s) => ((v >>> s) & 255).toString(16).padStart(2, '0')).join('')).join('');
}

/** Big-endian padding for SHA-1/SHA-256 (64-byte blocks). */
function padBE(bytes, block = 64, lenBytes = 8) {
    const msg = [...bytes, 0x80];

    while (msg.length % block !== block - lenBytes) {
        msg.push(0);
    }

    const bitLen = BigInt(bytes.length) * 8n;

    for (let i = lenBytes - 1; i >= 0; i -= 1) {
        msg.push(Number((bitLen >> BigInt(8 * i)) & 255n));
    }

    return msg;
}

const rotr = (x, n) => (x >>> n) | (x << (32 - n));

/** SHA-1 (FIPS 180-4). */
export function sha1(bytes) {
    const msg = padBE(bytes);
    let h = [0x67452301, 0xefcdab89, 0x98badcfe, 0x10325476, 0xc3d2e1f0];

    for (let off = 0; off < msg.length; off += 64) {
        const w = new Array(80);

        for (let i = 0; i < 16; i += 1) {
            w[i] = (msg[off + 4 * i] << 24) | (msg[off + 4 * i + 1] << 16) | (msg[off + 4 * i + 2] << 8) | msg[off + 4 * i + 3];
        }

        for (let i = 16; i < 80; i += 1) {
            const x = w[i - 3] ^ w[i - 8] ^ w[i - 14] ^ w[i - 16];
            w[i] = (x << 1) | (x >>> 31);
        }

        let [a, b, c, d, e] = h;

        for (let i = 0; i < 80; i += 1) {
            const [f, k] = i < 20 ? [(b & c) | (~b & d), 0x5a827999] : i < 40 ? [b ^ c ^ d, 0x6ed9eba1] : i < 60 ? [(b & c) | (b & d) | (c & d), 0x8f1bbcdc] : [b ^ c ^ d, 0xca62c1d6];
            const t = (((a << 5) | (a >>> 27)) + f + e + k + w[i]) | 0;
            e = d;
            d = c;
            c = (b << 30) | (b >>> 2);
            b = a;
            a = t;
        }

        h = h.map((v, i) => (v + [a, b, c, d, e][i]) | 0);
    }

    return h.map(hex32).join('');
}

const K256 = [0x428a2f98, 0x71374491, 0xb5c0fbcf, 0xe9b5dba5, 0x3956c25b, 0x59f111f1, 0x923f82a4, 0xab1c5ed5, 0xd807aa98, 0x12835b01, 0x243185be, 0x550c7dc3, 0x72be5d74, 0x80deb1fe, 0x9bdc06a7, 0xc19bf174, 0xe49b69c1, 0xefbe4786, 0x0fc19dc6, 0x240ca1cc, 0x2de92c6f, 0x4a7484aa, 0x5cb0a9dc, 0x76f988da, 0x983e5152, 0xa831c66d, 0xb00327c8, 0xbf597fc7, 0xc6e00bf3, 0xd5a79147, 0x06ca6351, 0x14292967, 0x27b70a85, 0x2e1b2138, 0x4d2c6dfc, 0x53380d13, 0x650a7354, 0x766a0abb, 0x81c2c92e, 0x92722c85, 0xa2bfe8a1, 0xa81a664b, 0xc24b8b70, 0xc76c51a3, 0xd192e819, 0xd6990624, 0xf40e3585, 0x106aa070, 0x19a4c116, 0x1e376c08, 0x2748774c, 0x34b0bcb5, 0x391c0cb3, 0x4ed8aa4a, 0x5b9cca4f, 0x682e6ff3, 0x748f82ee, 0x78a5636f, 0x84c87814, 0x8cc70208, 0x90befffa, 0xa4506ceb, 0xbef9a3f7, 0xc67178f2];

/** SHA-256 (FIPS 180-4). */
export function sha256(bytes) {
    const msg = padBE(bytes);
    let h = [0x6a09e667, 0xbb67ae85, 0x3c6ef372, 0xa54ff53a, 0x510e527f, 0x9b05688c, 0x1f83d9ab, 0x5be0cd19];

    for (let off = 0; off < msg.length; off += 64) {
        const w = new Array(64);

        for (let i = 0; i < 16; i += 1) {
            w[i] = (msg[off + 4 * i] << 24) | (msg[off + 4 * i + 1] << 16) | (msg[off + 4 * i + 2] << 8) | msg[off + 4 * i + 3];
        }

        for (let i = 16; i < 64; i += 1) {
            const s0 = rotr(w[i - 15], 7) ^ rotr(w[i - 15], 18) ^ (w[i - 15] >>> 3);
            const s1 = rotr(w[i - 2], 17) ^ rotr(w[i - 2], 19) ^ (w[i - 2] >>> 10);
            w[i] = (w[i - 16] + s0 + w[i - 7] + s1) | 0;
        }

        let [a, b, c, d, e, f, g, hh] = h;

        for (let i = 0; i < 64; i += 1) {
            const S1 = rotr(e, 6) ^ rotr(e, 11) ^ rotr(e, 25);
            const ch = (e & f) ^ (~e & g);
            const t1 = (hh + S1 + ch + K256[i] + w[i]) | 0;
            const S0 = rotr(a, 2) ^ rotr(a, 13) ^ rotr(a, 22);
            const maj = (a & b) ^ (a & c) ^ (b & c);
            const t2 = (S0 + maj) | 0;
            hh = g;
            g = f;
            f = e;
            e = (d + t1) | 0;
            d = c;
            c = b;
            b = a;
            a = (t1 + t2) | 0;
        }

        h = h.map((v, i) => (v + [a, b, c, d, e, f, g, hh][i]) | 0);
    }

    return h.map(hex32).join('');
}

/** SHA-512 (FIPS 180-4) with BigInt words. */
export function sha512(bytes) {
    const M64 = (1n << 64n) - 1n;
    const K = ['428a2f98d728ae22', '7137449123ef65cd', 'b5c0fbcfec4d3b2f', 'e9b5dba58189dbbc', '3956c25bf348b538', '59f111f1b605d019', '923f82a4af194f9b', 'ab1c5ed5da6d8118', 'd807aa98a3030242', '12835b0145706fbe', '243185be4ee4b28c', '550c7dc3d5ffb4e2', '72be5d74f27b896f', '80deb1fe3b1696b1', '9bdc06a725c71235', 'c19bf174cf692694', 'e49b69c19ef14ad2', 'efbe4786384f25e3', '0fc19dc68b8cd5b5', '240ca1cc77ac9c65', '2de92c6f592b0275', '4a7484aa6ea6e483', '5cb0a9dcbd41fbd4', '76f988da831153b5', '983e5152ee66dfab', 'a831c66d2db43210', 'b00327c898fb213f', 'bf597fc7beef0ee4', 'c6e00bf33da88fc2', 'd5a79147930aa725', '06ca6351e003826f', '142929670a0e6e70', '27b70a8546d22ffc', '2e1b21385c26c926', '4d2c6dfc5ac42aed', '53380d139d95b3df', '650a73548baf63de', '766a0abb3c77b2a8', '81c2c92e47edaee6', '92722c851482353b', 'a2bfe8a14cf10364', 'a81a664bbc423001', 'c24b8b70d0f89791', 'c76c51a30654be30', 'd192e819d6ef5218', 'd69906245565a910', 'f40e35855771202a', '106aa07032bbd1b8', '19a4c116b8d2d0c8', '1e376c085141ab53', '2748774cdf8eeb99', '34b0bcb5e19b48a8', '391c0cb3c5c95a63', '4ed8aa4ae3418acb', '5b9cca4f7763e373', '682e6ff3d6b2b8a3', '748f82ee5defb2fc', '78a5636f43172f60', '84c87814a1f0ab72', '8cc702081a6439ec', '90befffa23631e28', 'a4506cebde82bde9', 'bef9a3f7b2c67915', 'c67178f2e372532b', 'ca273eceea26619c', 'd186b8c721c0c207', 'eada7dd6cde0eb1e', 'f57d4f7fee6ed178', '06f067aa72176fba', '0a637dc5a2c898a6', '113f9804bef90dae', '1b710b35131c471b', '28db77f523047d84', '32caab7b40c72493', '3c9ebe0a15c9bebc', '431d67c49c100d4c', '4cc5d4becb3e42b6', '597f299cfc657e2a', '5fcb6fab3ad6faec', '6c44198c4a475817'].map((x) => BigInt(`0x${x}`));
    const rot = (x, n) => ((x >> BigInt(n)) | (x << BigInt(64 - n))) & M64;
    const msg = padBE(bytes, 128, 16);
    let h = ['6a09e667f3bcc908', 'bb67ae8584caa73b', '3c6ef372fe94f82b', 'a54ff53a5f1d36f1', '510e527fade682d1', '9b05688c2b3e6c1f', '1f83d9abfb41bd6b', '5be0cd19137e2179'].map((x) => BigInt(`0x${x}`));

    for (let off = 0; off < msg.length; off += 128) {
        const w = new Array(80);

        for (let i = 0; i < 16; i += 1) {
            w[i] = msg.slice(off + 8 * i, off + 8 * i + 8).reduce((acc, b) => (acc << 8n) | BigInt(b), 0n);
        }

        for (let i = 16; i < 80; i += 1) {
            const s0 = rot(w[i - 15], 1) ^ rot(w[i - 15], 8) ^ (w[i - 15] >> 7n);
            const s1 = rot(w[i - 2], 19) ^ rot(w[i - 2], 61) ^ (w[i - 2] >> 6n);
            w[i] = (w[i - 16] + s0 + w[i - 7] + s1) & M64;
        }

        let [a, b, c, d, e, f, g, hh] = h;

        for (let i = 0; i < 80; i += 1) {
            const S1 = rot(e, 14) ^ rot(e, 18) ^ rot(e, 41);
            const ch = (e & f) ^ (~e & M64 & g);
            const t1 = (hh + S1 + ch + K[i] + w[i]) & M64;
            const S0 = rot(a, 28) ^ rot(a, 34) ^ rot(a, 39);
            const maj = (a & b) ^ (a & c) ^ (b & c);
            const t2 = (S0 + maj) & M64;
            hh = g;
            g = f;
            f = e;
            e = (d + t1) & M64;
            d = c;
            c = b;
            b = a;
            a = (t1 + t2) & M64;
        }

        h = h.map((v, i) => (v + [a, b, c, d, e, f, g, hh][i]) & M64);
    }

    return h.map((v) => v.toString(16).padStart(16, '0')).join('');
}

/** Possible hash types for a string (by format markers, length and character set). */
export function identifyHash(text) {
    const s = String(text ?? '').trim();
    const prefixes = [[/^\$2[abxy]\$\d{2}\$[./A-Za-z0-9]{53}$/, 'bcrypt'], [/^\$argon2(id|i|d)\$/, 'Argon2'], [/^\$1\$/, 'MD5-crypt (Unix)'], [/^\$apr1\$/, 'Apache MD5 (apr1)'], [/^\$5\$/, 'SHA-256-crypt (Unix)'], [/^\$6\$/, 'SHA-512-crypt (Unix)'], [/^\$y\$/, 'yescrypt (Unix)'], [/^\$P\$|^\$H\$/, 'phpass (WordPress, phpBB)'], [/^pbkdf2_sha256\$/, 'Django PBKDF2-SHA256'], [/^\{SSHA\}/, 'LDAP salted SHA-1'], [/^\*[0-9A-F]{40}$/i, 'MySQL 4.1+ (SHA-1 of SHA-1)']];
    const marked = prefixes.filter(([re]) => re.test(s)).map(([, name]) => name);

    if (marked.length) {
        return { types: marked, kind: 'format marker' };
    }

    if (/^[0-9a-f]+$/i.test(s)) {
        const byLength = { 8: ['CRC-32', 'Adler-32'], 16: ['MySQL 3.2 (OLD_PASSWORD)', 'CRC-64', 'Half MD5'], 32: ['MD5', 'NTLM', 'MD4', 'MD2', 'LM (two halves)'], 40: ['SHA-1', 'RIPEMD-160', 'HAS-160'], 48: ['Tiger-192'], 56: ['SHA-224', 'SHA3-224', 'SHA-512/224'], 64: ['SHA-256', 'SHA3-256', 'BLAKE2s-256', 'BLAKE3', 'Keccak-256', 'SHA-512/256'], 96: ['SHA-384', 'SHA3-384'], 128: ['SHA-512', 'SHA3-512', 'BLAKE2b-512', 'Whirlpool'] };

        return { types: byLength[s.length] ?? [], kind: `${s.length} hex characters (${s.length * 4} bits)` };
    }

    if (/^[A-Za-z0-9+/]+=*$/.test(s)) {
        const bytes = Math.floor((s.replace(/=+$/, '').length * 6) / 8);
        const byBytes = { 16: ['MD5 (Base64)'], 20: ['SHA-1 (Base64)'], 32: ['SHA-256 (Base64)'], 64: ['SHA-512 (Base64)'] };

        return { types: byBytes[bytes] ?? [], kind: `Base64 of ${bytes} bytes` };
    }

    return { types: [], kind: 'unknown format' };
}

/** chmod: parses octal (755, 4755) or symbolic (rwxr-xr-x) into permission flags. */
export function parseMode(text) {
    const s = String(text ?? '').trim();

    if (/^[0-7]{3,4}$/.test(s)) {
        const digits = s.padStart(4, '0').split('').map(Number);

        return { special: digits[0], perms: digits.slice(1) };
    }

    if (/^[-r][-w][-xsS][-r][-w][-xsS][-r][-w][-xtT]$/.test(s)) {
        const perms = [0, 3, 6].map((o) => (s[o] === 'r' ? 4 : 0) + (s[o + 1] === 'w' ? 2 : 0) + (/[xst]/.test(s[o + 2]) ? 1 : 0));
        const special = (/[sS]/.test(s[2]) ? 4 : 0) + (/[sS]/.test(s[5]) ? 2 : 0) + (/[tT]/.test(s[8]) ? 1 : 0);

        return { special, perms };
    }

    return null;
}

export function modeText({ special, perms }) {
    const sym = perms.map((p, i) => {
        const x = p & 1;
        const sp = [4, 2, 1][i] & special;
        const exec = sp ? (i === 2 ? (x ? 't' : 'T') : x ? 's' : 'S') : x ? 'x' : '-';

        return `${p & 4 ? 'r' : '-'}${p & 2 ? 'w' : '-'}${exec}`;
    }).join('');

    return { octal: `${special ? special : ''}${perms.join('')}`, symbolic: sym };
}

/* ---------- Colour ---------- */

/** Parses #rgb, #rrggbb, rgb(…), hsl(…) or bare r, g, b into { r, g, b } (0–255). */
export function parseColor(text) {
    const s = String(text ?? '').trim().toLowerCase();
    let m;

    if ((m = s.match(/^#?([0-9a-f]{3}|[0-9a-f]{6})$/))) {
        const h = m[1].length === 3 ? [...m[1]].map((c) => c + c).join('') : m[1];

        return { r: parseInt(h.slice(0, 2), 16), g: parseInt(h.slice(2, 4), 16), b: parseInt(h.slice(4, 6), 16) };
    }

    if ((m = s.match(/^hsl\(\s*([\d.]+)\s*,?\s*([\d.]+)%\s*,?\s*([\d.]+)%\s*\)$/))) {
        return hslToRgb(Number(m[1]), Number(m[2]) / 100, Number(m[3]) / 100);
    }

    if ((m = s.match(/^(?:rgb\()?\s*(\d{1,3})\s*[, ]\s*(\d{1,3})\s*[, ]\s*(\d{1,3})\s*\)?$/))) {
        const [r, g, b] = [m[1], m[2], m[3]].map(Number);

        return [r, g, b].every((v) => v <= 255) ? { r, g, b } : null;
    }

    return null;
}

export function hslToRgb(h, s, l) {
    const c = (1 - Math.abs(2 * l - 1)) * s;
    const hp = (((h % 360) + 360) % 360) / 60;
    const x = c * (1 - Math.abs((hp % 2) - 1));
    const [r1, g1, b1] = hp < 1 ? [c, x, 0] : hp < 2 ? [x, c, 0] : hp < 3 ? [0, c, x] : hp < 4 ? [0, x, c] : hp < 5 ? [x, 0, c] : [c, 0, x];
    const m = l - c / 2;

    return { r: Math.round((r1 + m) * 255), g: Math.round((g1 + m) * 255), b: Math.round((b1 + m) * 255) };
}

export function colorModels({ r, g, b }) {
    const [R, G, B] = [r, g, b].map((v) => v / 255);
    const max = Math.max(R, G, B);
    const min = Math.min(R, G, B);
    const d = max - min;
    const h = d === 0 ? 0 : max === R ? 60 * (((G - B) / d) % 6) : max === G ? 60 * ((B - R) / d + 2) : 60 * ((R - G) / d + 4);
    const l = (max + min) / 2;
    const sl = d === 0 ? 0 : d / (1 - Math.abs(2 * l - 1));
    const sv = max === 0 ? 0 : d / max;
    const k = 1 - max;
    const cmyk = k === 1 ? [0, 0, 0, 100] : [(1 - R - k) / (1 - k), (1 - G - k) / (1 - k), (1 - B - k) / (1 - k), k].map((v) => v * 100);

    return { hex: `#${[r, g, b].map((v) => v.toString(16).padStart(2, '0')).join('').toUpperCase()}`, rgb: [r, g, b], hsl: [(h + 360) % 360, sl * 100, l * 100], hsv: [(h + 360) % 360, sv * 100, max * 100], cmyk };
}

/** WCAG 2.x relative luminance and contrast ratio. */
export function luminance({ r, g, b }) {
    const lin = (v) => {
        const c = v / 255;

        return c <= 0.04045 ? c / 12.92 : ((c + 0.055) / 1.055) ** 2.4;
    };

    return 0.2126 * lin(r) + 0.7152 * lin(g) + 0.0722 * lin(b);
}

export const contrast = (a, b) => {
    const [l1, l2] = [luminance(a), luminance(b)].sort((x, y) => y - x);

    return (l1 + 0.05) / (l2 + 0.05);
};

/* ---------- UUID (RFC 9562) ---------- */

function randomBytes(n) {
    const out = new Uint8Array(n);
    globalThis.crypto.getRandomValues(out);

    return [...out];
}

const uuidText = (b) => {
    const h = b.map((x) => x.toString(16).padStart(2, '0')).join('');

    return `${h.slice(0, 8)}-${h.slice(8, 12)}-${h.slice(12, 16)}-${h.slice(16, 20)}-${h.slice(20)}`;
};

export function uuid4() {
    const b = randomBytes(16);
    b[6] = (b[6] & 0x0f) | 0x40;
    b[8] = (b[8] & 0x3f) | 0x80;

    return uuidText(b);
}

export function uuid7(ms = Date.now()) {
    const b = randomBytes(16);

    for (let i = 0; i < 6; i += 1) {
        b[i] = Math.floor(ms / 2 ** (8 * (5 - i))) & 255;
    }

    b[6] = (b[6] & 0x0f) | 0x70;
    b[8] = (b[8] & 0x3f) | 0x80;

    return uuidText(b);
}
