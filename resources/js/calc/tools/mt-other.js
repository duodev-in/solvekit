import { defineTools } from '../engines/formula.js';
import * as N from '../math/numtheory.js';
import { f, fail, need, R, result } from '../math/util.js';

/**
 * Number systems (Babylonian base 60, Mayan base 20), algorithms (Luhn, ISBN, LFSR, RSA, cyclomatic
 * complexity), paradox explorers (Galileo, Hilbert's hotel, the potato paradox, Littlewood's law, the ugly
 * duckling theorem), the involute function, queueing theory, the iterated prisoner's dilemma and a random
 * number generator.
 */
const { abs, tan, atan, sqrt, floor } = Math;
const D = Math.PI / 180;
const fmtBig = (v) => (v < 0n ? `−${(-v).toLocaleString('en-US')}` : v.toLocaleString('en-US'));
const UNIT = '𒁹';
const TEN = '𒌋';

function readBig(text) {
    const s = String(text ?? '').replace(/[\s,_]/g, '');

    return /^\d+$/.test(s) ? BigInt(s) : null;
}

/** Digits of a non-negative integer in base b, most significant first. */
function digitsIn(n, b) {
    if (n === 0n) {
        return [0n];
    }

    const out = [];

    for (let v = n; v > 0n; v /= b) {
        out.unshift(v % b);
    }

    return out;
}

const babylonianGlyph = (d) => (d === 0n ? '␣' : `${TEN.repeat(Number(d / 10n))}${UNIT.repeat(Number(d % 10n))}`);
const MAYAN = Array.from({ length: 20 }, (_, k) => String.fromCodePoint(0x1d2e0 + k));
const mayanText = (d) => (d === 0 ? 'shell (0)' : `${'▬'.repeat(floor(d / 5))}${floor(d / 5) && d % 5 ? ' ' : ''}${'•'.repeat(d % 5)}`);

/** Strategies for the iterated prisoner's dilemma: (my history, their history, round, rng) → 'C' or 'D'. */
const STRATEGIES = {
    tft: ['Tit for tat', (me, them) => (them.length ? them[them.length - 1] : 'C')],
    allc: ['Always cooperate', () => 'C'],
    alld: ['Always defect', () => 'D'],
    grim: ['Grim trigger', (me, them) => (them.includes('D') ? 'D' : 'C')],
    tf2t: ['Tit for two tats', (me, them) => (them.length >= 2 && them[them.length - 1] === 'D' && them[them.length - 2] === 'D' ? 'D' : 'C')],
    pavlov: ['Pavlov (win-stay, lose-shift)', (me, them) => {
        if (!me.length) {
            return 'C';
        }

        return me[me.length - 1] === them[them.length - 1] ? 'C' : 'D';
    }],
    random: ['Random (50/50, seeded)', (me, them, k, rng) => (rng() < 0.5 ? 'C' : 'D')],
    gtft: ['Generous tit for tat', (me, them, k, rng) => (them.length && them[them.length - 1] === 'D' && rng() > 0.1 ? 'D' : 'C')],
};

function mulberry32(seed) {
    let a = seed >>> 0;

    return () => {
        a = (a + 0x6d2b79f5) >>> 0;
        let t = a;
        t = Math.imul(t ^ (t >>> 15), t | 1);
        t ^= t + Math.imul(t ^ (t >>> 7), t | 61);

        return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
    };
}

/** Unbiased random integer in [0, n) from crypto (falls back to Math.random). */
function randomBelow(n) {
    const c = globalThis.crypto;

    if (!c?.getRandomValues || n > 2 ** 32) {
        return floor(Math.random() * n);
    }

    const limit = 2 ** 32 - (2 ** 32 % n);
    const buf = new Uint32Array(1);

    do {
        c.getRandomValues(buf);
    } while (buf[0] >= limit);

    return buf[0] % n;
}

export const handlers = {
    babylonian: (i) => {
        const dir = i.dir ?? 'to';

        if (dir === 'from') {
            const text = String(i.sexa ?? '').trim();
            const m = text.match(/^(\d+(?:\s*,\s*\d+)*)(?:\s*;\s*(\d+(?:\s*,\s*\d+)*))?$/);

            if (!m) {
                return need('Type base-60 digits separated by commas, with ; before the fraction, such as 1;24,51,10.');
            }

            const ints = m[1].split(',').map((x) => BigInt(x.trim()));
            const fracs = m[2] ? m[2].split(',').map((x) => BigInt(x.trim())) : [];

            if ([...ints, ...fracs].some((d) => d > 59n)) {
                return fail('Each base-60 digit must be from 0 to 59.');
            }

            let v = R.ZERO;
            ints.forEach((d) => {
                v = R.add(R.mul(v, R.Q(60)), R.Q(d));
            });
            fracs.forEach((d, k) => {
                v = R.add(v, R.Q(d, 60n ** BigInt(k + 1)));
            });

            return result(R.isInt(v) ? fmtBig(v.n) : f(R.toNumber(v), 15), 'Decimal value', { sub: R.isInt(v) ? `${ints.length} sexagesimal places` : `= ${R.toFraction(v)} exactly`, rows: { sexagesimal: text, glyphs: [...ints, ...fracs].map(babylonianGlyph).join('  '), decimal: R.isInt(v) ? fmtBig(v.n) : f(R.toNumber(v), 15), places: [...ints.map((d, k) => `${d} × 60^${ints.length - 1 - k}`), ...fracs.map((d, k) => `${d} × 60^−${k + 1}`)].join(' + ') }, steps: [...ints.map((d, k) => `${d} × 60^${ints.length - 1 - k} = ${fmtBig(d * 60n ** BigInt(ints.length - 1 - k))}`), ...fracs.map((d, k) => `${d} ÷ 60^${k + 1} = ${f(Number(d) / 60 ** (k + 1), 12)}`), `Total ${R.isInt(v) ? fmtBig(v.n) : f(R.toNumber(v), 15)}`] });
        }

        const n = readBig(i.n);

        if (n === null) {
            return need('Enter a whole number.');
        }

        const ds = digitsIn(n, 60n);

        return result(ds.map(babylonianGlyph).join('  '), 'Babylonian numerals', { sub: `Base 60: ${ds.join(',')}`, rows: { sexagesimal: ds.join(','), glyphs: ds.map(babylonianGlyph).join('  '), decimal: fmtBig(n), places: ds.map((d, k) => `${d} × 60^${ds.length - 1 - k}`).join(' + ') }, steps: ['Divide by 60 repeatedly; the remainders are the base-60 digits', ...ds.map((d, k) => `${d} × 60^${ds.length - 1 - k}`), `Each digit is written with ${TEN} for ten and ${UNIT} for one; the Babylonians had no zero symbol (a gap, shown ␣, was used later)`] });
    },

    mayan: (i) => {
        const dir = i.dir ?? 'to';

        if (dir === 'from') {
            const ds = String(i.digits ?? '').split(/[,\s]+/).filter(Boolean).map(Number);

            if (!ds.length || ds.some((d) => !Number.isInteger(d) || d < 0 || d > 19)) {
                return need('Type the Mayan digits (0 to 19) from the top, separated by commas.');
            }

            const v = ds.reduce((s, d) => s * 20n + BigInt(d), 0n);

            return result(fmtBig(v), 'Decimal value', { sub: ds.map((d) => MAYAN[d]).join(' '), rows: { digits: ds.join(', '), glyphs: ds.map((d) => MAYAN[d]).join(' '), bars: ds.map(mayanText).join(' | '), longcount: 'Pure base 20 (the calendar long count uses 18 × 20 in the third place)' }, steps: ds.map((d, k) => `${d} × 20^${ds.length - 1 - k}`).concat([`= ${fmtBig(v)}`]) });
        }

        const n = readBig(i.n);

        if (n === null) {
            return need('Enter a whole number.');
        }

        const ds = digitsIn(n, 20n).map(Number);
        // Long count: 1, 20, 360, 7,200, 144,000 …
        const lc = [];
        let rest = n;
        const weights = [20n, 18n];

        for (let k = 0; rest > 0n || k === 0; k += 1) {
            const w = weights[k] ?? 20n;
            lc.unshift(rest % w);
            rest /= w;

            if (k > 12) {
                break;
            }
        }

        return result(ds.map((d) => MAYAN[d]).join(' '), 'Mayan numerals (top to bottom)', { sub: `Base 20: ${ds.join(', ')}`, rows: { digits: ds.join(', '), glyphs: ds.map((d) => MAYAN[d]).join(' '), bars: ds.map(mayanText).join(' | '), longcount: `${lc.join('.')} (calendar long count)` }, steps: ['Divide by 20 repeatedly; the remainders, read upwards, are the digits', ...ds.map((d, k) => `${d} × 20^${ds.length - 1 - k}: ${mayanText(d)}`), 'A bar is 5, a dot is 1 and a shell is 0'] });
    },

    luhn: (i, c) => {
        const digits = String(i.number ?? '').replace(/[\s-]/g, '');

        if (!/^\d+$/.test(digits)) {
            return need('Enter the digits (spaces and dashes are ignored).');
        }

        const sumOf = (s) => [...s].reverse().reduce((acc, ch, k) => {
            let d = Number(ch);

            if (k % 2 === 1) {
                d *= 2;

                if (d > 9) {
                    d -= 9;
                }
            }

            return acc + d;
        }, 0);
        const sum = sumOf(digits);
        const valid = sum % 10 === 0;
        const check = (10 - (sumOf(`${digits}0`) % 10)) % 10;
        const want = c.want ?? 'check';
        const doubled = [...digits].reverse().map((ch, k) => (k % 2 === 1 ? `${ch}→${Number(ch) * 2 > 9 ? Number(ch) * 2 - 9 : Number(ch) * 2}` : ch)).reverse().join(' ');

        return result(want === 'check' ? (valid ? 'Valid' : 'Invalid') : `${digits}${check}`, want === 'check' ? 'Luhn check' : 'With check digit', { sub: want === 'check' ? `Sum ${sum}; ${valid ? 'divisible by 10' : `not divisible by 10 (the right last digit would be ${(10 - (sumOf(`${digits.slice(0, -1)}0`) % 10)) % 10})`}` : `Check digit ${check}`, rows: { sum: String(sum), checkDigit: `${check} (to append to ${digits})`, doubled, valid: valid ? 'Valid as typed' : 'Invalid as typed' }, steps: ['From the right, double every second digit; subtract 9 from results above 9', doubled, `Sum = ${sum}`, valid ? 'Sum divisible by 10: valid' : 'Not divisible by 10: invalid', `Check digit to append: ${check}`] });
    },

    isbn: (i) => {
        const s = String(i.isbn ?? '').replace(/[\s-]/g, '').toUpperCase();

        if (!/^\d{9}[\dX]?$|^\d{12,13}$/.test(s)) {
            return need('Enter 9 or 10 characters for ISBN-10, or 12 or 13 digits for ISBN-13.');
        }

        const isbn10check = (nine) => {
            const sum = [...nine].reduce((acc, ch, k) => acc + Number(ch) * (10 - k), 0);
            const c = (11 - (sum % 11)) % 11;

            return c === 10 ? 'X' : String(c);
        };
        const isbn13check = (twelve) => String((10 - ([...twelve].reduce((acc, ch, k) => acc + Number(ch) * (k % 2 ? 3 : 1), 0) % 10)) % 10);

        if (s.length <= 10) {
            const nine = s.slice(0, 9);
            const c = isbn10check(nine);
            const full = `${nine}${c}`;
            const thirteen = `978${nine}${isbn13check(`978${nine}`)}`;
            const valid = s.length === 10 ? s[9] === c : null;

            return result(s.length === 10 ? (valid ? 'Valid ISBN-10' : `Invalid (check digit should be ${c})`) : full, s.length === 10 ? 'ISBN-10 check' : 'ISBN-10 with check digit', { sub: `ISBN-13: ${thirteen}`, rows: { check: c, isbn10: full, isbn13: thirteen, rule: 'ISBN-10: Σ digit × weight (10 down to 2), check = (11 − sum mod 11) mod 11, 10 written X' }, steps: [...[...nine].map((ch, k) => `${ch} × ${10 - k} = ${Number(ch) * (10 - k)}`), `Sum ${[...nine].reduce((acc, ch, k) => acc + Number(ch) * (10 - k), 0)}`, `Check digit ${c}`, `ISBN-13: prefix 978, drop the old check digit, recompute: ${thirteen}`] });
        }

        const twelve = s.slice(0, 12);
        const c = isbn13check(twelve);
        const valid = s.length === 13 ? s[12] === c : null;
        const ten = twelve.startsWith('978') ? `${twelve.slice(3)}${isbn10check(twelve.slice(3))}` : 'None (only 978 ISBN-13s have an ISBN-10)';

        return result(s.length === 13 ? (valid ? 'Valid ISBN-13' : `Invalid (check digit should be ${c})`) : `${twelve}${c}`, s.length === 13 ? 'ISBN-13 check' : 'ISBN-13 with check digit', { sub: `ISBN-10: ${ten}`, rows: { check: c, isbn10: ten, isbn13: `${twelve}${c}`, rule: 'ISBN-13: weights 1, 3, 1, 3 …; check = (10 − sum mod 10) mod 10' }, steps: [`Weighted sum ${[...twelve].map((ch, k) => `${ch}×${k % 2 ? 3 : 1}`).join(' + ')} = ${[...twelve].reduce((acc, ch, k) => acc + Number(ch) * (k % 2 ? 3 : 1), 0)}`, `Check digit ${c}`] });
    },

    lfsr: (i) => {
        const n = Number(i.bits);
        const taps = String(i.taps ?? '').split(/[,\s]+/).filter(Boolean).map(Number);
        const seedText = String(i.seed ?? '').trim();
        const steps = Math.min(Number(i.steps ?? 32), 512);
        const type = i.type ?? 'fibonacci';

        if (!Number.isInteger(n) || n < 2 || n > 32) {
            return need('Enter a register length from 2 to 32 bits.');
        }

        if (!taps.length || taps.some((tp) => !Number.isInteger(tp) || tp < 1 || tp > n) || !taps.includes(n)) {
            return need(`Enter the tap positions (1 to ${n}), including ${n}, such as ${n === 16 ? '16, 14, 13, 11' : `${n}, ${n - 1}`}.`);
        }

        let state = /^[01]+$/.test(seedText) ? parseInt(seedText, 2) : /^0x/i.test(seedText) ? parseInt(seedText, 16) : NaN;

        if (!Number.isFinite(state) || state <= 0 || state >= 2 ** n) {
            return need(`Enter a non-zero seed of at most ${n} bits (binary, or 0x… hex).`);
        }

        const seed = state;
        const mask = 2 ** n - 1;
        // Bit positions are 1 (rightmost output end) … n; Fibonacci shifts right and feeds the XOR of the taps into bit n.
        const tapMask = taps.reduce((m, tp) => m | (1 << (tp - 1)), 0) >>> 0;
        const next = (s) => {
            const out = s & 1;

            if (type === 'galois') {
                let v = s >>> 1;

                if (out) {
                    v ^= (tapMask >>> 1) | (1 << (n - 1));
                }

                return [(v & mask) >>> 0, out];
            }

            let fb = 0;
            taps.forEach((tp) => {
                fb ^= (s >>> (n - tp)) & 1;
            });

            return [((s >>> 1) | (fb << (n - 1))) >>> 0, out];
        };
        const outBits = [];
        const states = [];

        for (let k = 0; k < steps; k += 1) {
            const [s2, o] = next(state);
            outBits.push(o);
            states.push(state);
            state = s2;
        }

        // Period: run until the seed returns (bounded).
        let period = null;
        let s = seed;
        const limit = n <= 24 ? 2 ** n : 2 ** 22;

        for (let k = 1; k <= limit; k += 1) {
            s = next(s)[0];

            if (s === seed) {
                period = k;
                break;
            }
        }

        const maximal = period === 2 ** n - 1;

        return result(outBits.join(''), `First ${steps} output bits`, { sub: period ? `Period ${period.toLocaleString('en-US')}${maximal ? ' (maximal length)' : ` (maximal would be ${(2 ** n - 1).toLocaleString('en-US')})`}` : `Period longer than ${limit.toLocaleString('en-US')} steps`, rows: { period: period ? period.toLocaleString('en-US') : 'Not found within the limit', maximal: maximal ? 'Yes: the taps give a primitive polynomial' : 'No', states: states.slice(0, 16).map((x) => x.toString(2).padStart(n, '0')).join(', '), ones: `${outBits.filter((b) => b).length} ones and ${outBits.filter((b) => !b).length} zeros in the first ${steps}` }, steps: [`${type === 'galois' ? 'Galois' : 'Fibonacci'} LFSR, ${n} bits, taps ${taps.join(', ')}`, ...states.slice(0, 12).map((x, k) => `${String(k).padStart(3)}: ${x.toString(2).padStart(n, '0')} → out ${outBits[k]}`)] });
    },

    rsa: (i) => {
        const p = N.parseBig(String(i.p ?? ''));
        const q = N.parseBig(String(i.q ?? ''));
        const e = N.parseBig(String(i.e ?? '65537'));
        const msg = String(i.m ?? '').trim();

        if (p === null || q === null || e === null) {
            return need('Enter two primes p and q and the public exponent e.');
        }

        if (!N.isPrime(p) || !N.isPrime(q)) {
            return fail(`${!N.isPrime(p) ? `p = ${p}` : `q = ${q}`} is not prime.`);
        }

        if (p === q) {
            return fail('p and q must be different primes.');
        }

        const n = p * q;
        const phi = (p - 1n) * (q - 1n);

        if (N.egcd(e, phi)[0] !== 1n || e <= 1n || e >= phi) {
            return fail(`e must be between 1 and φ(n) = ${fmtBig(phi)} with gcd(e, φ) = 1.`);
        }

        const d = N.modInverse(e, phi);
        const rows = { n: fmtBig(n), phi: fmtBig(phi), public: `(e, n) = (${fmtBig(e)}, ${fmtBig(n)})`, private: `(d, n) = (${fmtBig(d)}, ${fmtBig(n)})` };
        const steps = [`n = p × q = ${fmtBig(n)}`, `φ(n) = (p − 1)(q − 1) = ${fmtBig(phi)}`, `d = e⁻¹ mod φ(n) = ${fmtBig(d)} (e × d ≡ 1)`];
        let value = `d = ${fmtBig(d)}`;
        let sub = `n = ${fmtBig(n)}`;

        if (msg) {
            const m = N.parseBig(msg);

            if (m !== null) {
                if (m >= n) {
                    return fail(`The message number must be smaller than n = ${fmtBig(n)}.`);
                }

                const cph = N.modPow(m, e, n);
                const back = N.modPow(cph, d, n);
                value = `c = ${fmtBig(cph)}`;
                sub = `Decrypts back to ${fmtBig(back)}`;
                rows.cipher = `${fmtBig(m)}^${fmtBig(e)} mod ${fmtBig(n)} = ${fmtBig(cph)}`;
                rows.decrypted = `${fmtBig(cph)}^${fmtBig(d)} mod ${fmtBig(n)} = ${fmtBig(back)}`;
                steps.push(`Encrypt: c = m^e mod n = ${fmtBig(cph)}`, `Decrypt: m = c^d mod n = ${fmtBig(back)}`);
            } else {
                const codes = [...msg].map((ch) => BigInt(ch.codePointAt(0)));

                if (codes.some((cd) => cd >= n)) {
                    return fail(`n = ${fmtBig(n)} is too small for these characters; use bigger primes.`);
                }

                const ciph = codes.map((cd) => N.modPow(cd, e, n));
                const back = ciph.map((cv) => String.fromCodePoint(Number(N.modPow(cv, d, n)))).join('');
                value = ciph.slice(0, 8).map(fmtBig).join(' ') + (ciph.length > 8 ? ' …' : '');
                sub = `Decrypts back to "${back}"`.replace(/"/g, '');
                rows.cipher = ciph.map(fmtBig).join(' ');
                rows.decrypted = back;
                steps.push('Each character code is encrypted separately (textbook RSA, for learning only)', ...codes.slice(0, 6).map((cd, k) => `${String.fromCodePoint(Number(cd))} = ${cd} → ${fmtBig(ciph[k])}`));
            }
        }

        rows.cipher ??= 'Enter a message';
        rows.decrypted ??= 'Enter a message';

        return result(value, msg ? 'Ciphertext' : 'Private exponent', { sub, rows, steps: [...steps, 'Real RSA uses primes hundreds of digits long and padding; this demonstration is not secure'] });
    },

    cyclomatic: (i) => {
        const mode = i.mode ?? 'graph';
        let M;
        const steps = [];

        if (mode === 'graph') {
            const [E, Nn, P] = [i.edges, i.nodes, i.parts ?? 1].map(Number);

            if (![E, Nn, P].every((v) => Number.isInteger(v) && v >= 0) || P < 1) {
                return need('Enter whole numbers of edges, nodes and connected components.');
            }

            M = E - Nn + 2 * P;
            steps.push(`M = E − N + 2P = ${E} − ${Nn} + 2 × ${P} = ${M}`);
        } else {
            const dpts = Number(i.decisions);

            if (!Number.isInteger(dpts) || dpts < 0) {
                return need('Enter the number of decision points (if, while, for, case, &&, ||).');
            }

            M = dpts + 1;
            steps.push(`M = decision points + 1 = ${dpts} + 1 = ${M}`);
        }

        if (M < 1) {
            return fail('These numbers give M below 1; check the edges and nodes.');
        }

        const band = M <= 10 ? 'Simple, low risk' : M <= 20 ? 'More complex, moderate risk' : M <= 50 ? 'Complex, high risk' : 'Very complex, untestable in practice';

        return result(String(M), 'Cyclomatic complexity M', { sub: band, rows: { band, tests: `At least ${M} test cases for full branch (basis path) coverage`, rule: 'McCabe suggested splitting functions above 10' }, steps });
    },

    galileo: (i) => {
        const n = Number(i.n);

        if (!Number.isInteger(n) || n < 1 || n > 1e15) {
            return need('Enter a whole number n up to 10¹⁵.');
        }

        const squares = floor(sqrt(n) + 1e-9) ** 2 <= n ? floor(sqrt(n) + 1e-9) : floor(sqrt(n));
        const pairs = Array.from({ length: Math.min(10, squares) }, (_, k) => `${k + 1} ↔ ${(k + 1) ** 2}`);

        return result(squares.toLocaleString('en-US'), `Perfect squares from 1 to ${n.toLocaleString('en-US')}`, { sub: `Only ${f((squares / n) * 100, 6)}% of the numbers, yet the squares can be paired one-to-one with all numbers`, rows: { share: `${f((squares / n) * 100, 8)}%`, nonsquares: (n - squares).toLocaleString('en-US'), pairing: `${pairs.join(', ')}, …`, lesson: 'For infinite sets "as many" means a one-to-one pairing exists, so a part can be as big as the whole (Cantor)' }, steps: [`Squares up to n: ⌊√n⌋ = ${squares}`, `Fraction √n ÷ n → 0 as n grows`, 'But n ↔ n² matches every number with exactly one square, so the two infinite sets have the same size'] });
    },

    hilbert: (i) => {
        const scenario = i.scenario ?? 'finite';
        const k = Number(i.k ?? 1);
        const room = Number(i.room ?? 1);

        if (!Number.isInteger(room) || room < 1) {
            return need('Enter a room number (1 or more).');
        }

        if (scenario === 'finite') {
            if (!Number.isInteger(k) || k < 1) {
                return need('Enter how many new guests arrive.');
            }

            return result(`Room ${(room + k).toLocaleString('en-US')}`, `Where the guest in room ${room} moves`, { sub: `Everyone moves from room n to n + ${k}; new guests take rooms 1 to ${k}`, rows: { rule: `n → n + ${k}`, newGuests: `Rooms 1 to ${k}`, examples: Array.from({ length: 5 }, (_, j) => `${j + 1} → ${j + 1 + k}`).join(', '), lesson: 'A full infinite hotel can always take finitely many more guests' }, steps: [`Guest in room n moves to room n + ${k}`, `Rooms 1 … ${k} are now free for the ${k} new guest${k === 1 ? '' : 's'}`] });
        }

        if (scenario === 'bus') {
            return result(`Room ${(2 * room).toLocaleString('en-US')}`, `Where the guest in room ${room} moves`, { sub: 'Everyone moves to room 2n; the infinitely many new guests take the odd rooms', rows: { rule: 'n → 2n', newGuests: 'New guest j takes room 2j − 1', examples: Array.from({ length: 5 }, (_, j) => `${j + 1} → ${2 * (j + 1)}`).join(', '), lesson: 'ℕ can be split into two copies of itself (evens and odds)' }, steps: ['Old guest in room n → room 2n (all even rooms)', 'New guest number j → room 2j − 1 (all odd rooms)'] });
        }

        // Infinitely many buses: prime powers.
        const primes = [2n, 3n, 5n, 7n, 11n, 13n];

        return result(`Room 2^${room} = ${fmtBig(2n ** BigInt(room))}`, `Where the guest in room ${room} moves`, { sub: 'Old guests go to powers of 2; passenger j of bus b goes to (b-th odd prime)^j', rows: { rule: 'n → 2ⁿ; bus b, seat j → p_b^j', newGuests: `Bus 1 seat ${k}: 3^${k} = ${fmtBig(3n ** BigInt(Math.max(1, k)))}; bus 2 seat ${k}: 5^${k} = ${fmtBig(5n ** BigInt(Math.max(1, k)))}`, examples: primes.slice(1, 5).map((pr, b) => `bus ${b + 1}: ${pr}, ${pr ** 2n}, ${pr ** 3n}, …`).join('; '), lesson: 'By unique prime factorisation no two people share a room (many rooms stay empty)' }, steps: ['Old guest in room n → room 2ⁿ', 'Bus b uses the (b + 1)-th prime p: seat j → room pʲ', 'Prime powers never coincide, so everyone gets a room'] });
    },

    involute: (i) => {
        const dir = i.dir ?? 'to';

        if (dir === 'from') {
            const v = Number(i.inv);

            if (!(v > 0) || v > 10) {
                return need('Enter inv α (a positive number).');
            }

            // Newton on tan a − a = v, starting from the cube-root approximation.
            let a = Math.cbrt(3 * v);

            for (let k = 0; k < 50; k += 1) {
                const step = (tan(a) - a - v) / (tan(a) ** 2);
                a -= step;

                if (abs(step) < 1e-16) {
                    break;
                }
            }

            return result(f(a / D, 12), 'Pressure angle α', { unit: '°', sub: `${f(a, 14)} rad`, rows: { inv: f(tan(a) - a, 15), alpha: `${f(a / D, 14)}° = ${f(a, 14)} rad`, tan: f(tan(a), 14), use: 'Gear tooth thickness and centre distance calculations' }, steps: ['Solve tan α − α = inv α by Newton\'s method', `α = ${f(a, 15)} rad = ${f(a / D, 12)}°`] });
        }

        const deg = Number(i.alpha);

        if (!(deg > 0 && deg < 90)) {
            return need('Enter an angle between 0° and 90°.');
        }

        const a = deg * D;
        const v = tan(a) - a;

        return result(f(v, 14), `inv ${f(deg)}°`, { sub: `tan α − α with α = ${f(a, 12)} rad`, rows: { inv: f(v, 15), alpha: `${f(deg)}° = ${f(a, 14)} rad`, tan: f(tan(a), 14), use: 'Gear tooth thickness and centre distance calculations' }, steps: [`α = ${f(deg)}° = ${f(a, 15)} rad`, `inv α = tan α − α = ${f(tan(a), 15)} − ${f(a, 15)} = ${f(v, 15)}`] });
    },

    miracle: (i) => {
        const [rate, hours, odds, days] = [i.rate, i.hours, i.odds, i.days ?? 30].map(Number);

        if (!(rate > 0 && hours > 0 && hours <= 24 && odds >= 1 && days > 0)) {
            return need('Enter events per second, alert hours per day and the odds (one in …).');
        }

        const perDay = rate * hours * 3600;
        const daysPer = odds / perDay;
        const expected = (perDay * days) / odds;
        const pAtLeast = 1 - Math.exp(-expected);

        return result(f(daysPer, 8), 'Days per "miracle"'.replace(/"/g, ''), { sub: `About ${f(expected, 6)} one-in-${f(odds)} events in ${f(days)} days`, rows: { perDay: f(perDay, 10), expected: f(expected, 10), chance: `${f(pAtLeast * 100, 6)}% chance of at least one in ${f(days)} days`, lesson: 'Littlewood\'s law: with about a million noticed events a month, one-in-a-million coincidences are routine' }, steps: [`Events per day = ${f(rate)} × ${f(hours)} h × 3,600 s = ${f(perDay, 10)}`, `Days for ${f(odds)} events = ${f(odds)} ÷ ${f(perDay, 10)} = ${f(daysPer, 8)}`, `Poisson: P(at least one in ${f(days)} days) = 1 − e^(−${f(expected, 6)}) = ${f(pAtLeast, 8)}`] });
    },

    potato: (i) => {
        const [m1, w1, w2] = [i.m1, i.w1, i.w2].map(Number);

        if (!(m1 > 0) || !(w1 >= 0 && w1 < 100) || !(w2 >= 0 && w2 < 100)) {
            return need('Enter the starting mass and the two water percentages (below 100).');
        }

        if (w2 > w1) {
            return fail('Drying lowers the water share; the new percentage must not be higher.');
        }

        const dry = m1 * (1 - w1 / 100);
        const m2 = dry / (1 - w2 / 100);

        return result(f(m2, 10), 'New mass', { sub: `${f((m2 / m1) * 100, 6)}% of the original`, rows: { dry: f(dry, 10), water: `${f(m1 - dry, 10)} → ${f(m2 - dry, 10)}`, lost: f(m1 - m2, 10), lesson: 'The dry matter is fixed; going from 1% dry to 2% dry means the total must halve' }, steps: [`Dry matter = ${f(m1)} × (1 − ${f(w1)}%) = ${f(dry, 10)}`, `After drying it is ${f(100 - w2)}% of the mass: ${f(dry, 10)} ÷ ${f(1 - w2 / 100, 6)} = ${f(m2, 10)}`] });
    },

    ugly: (i) => {
        const n = Number(i.n);

        if (!Number.isInteger(n) || n < 2 || n > 60) {
            return need('Enter the number of objects (2 to 60).');
        }

        const total = 2n ** BigInt(n);
        const shared = 2n ** BigInt(n - 2);

        return result(fmtBig(shared), `Predicates shared by any two of ${n} objects`, { sub: `Out of ${fmtBig(total)} possible predicates (classes): always a quarter`, rows: { total: fmtBig(total), shared: fmtBig(shared), share: '25% for every pair', lesson: 'Counting all predicates, an ugly duckling is exactly as similar to a swan as two swans are: similarity needs a choice of which features matter (Watanabe)' }, steps: [`With ${n} objects there are 2^${n} = ${fmtBig(total)} ways to pick a subset, each a possible predicate`, 'Two given objects both belong to a subset in 2^(n−2) ways', `= ${fmtBig(shared)}, the same for every pair`] });
    },

    queue: (i) => {
        const [lambda, mu, c0] = [i.lambda, i.mu, i.servers ?? 1].map(Number);
        const c = Math.round(c0);

        if (!(lambda > 0 && mu > 0 && c >= 1 && c <= 500)) {
            return need('Enter the arrival rate, the service rate per server and the number of servers.');
        }

        const a = lambda / mu;
        const rho = a / c;

        if (rho >= 1) {
            return fail(`Utilisation ρ = λ ÷ (cμ) = ${f(rho, 6)} ≥ 1: the queue grows without limit. Add servers or speed up service.`);
        }

        // Erlang C via a stable recurrence.
        let term = 1;
        let sum = 1;

        for (let k = 1; k < c; k += 1) {
            term *= a / k;
            sum += term;
        }

        const last = (term * a) / c / (1 - rho);
        const p0 = 1 / (sum + last);
        const pw = last * p0;
        const Lq = (pw * rho) / (1 - rho);
        const Wq = Lq / lambda;
        const W = Wq + 1 / mu;
        const L = lambda * W;

        return result(f(Wq, 10), 'Average wait in the queue Wq', { sub: `Utilisation ${f(rho * 100, 6)}%; ${f(pw * 100, 6)}% of arrivals wait`, rows: { rho: `${f(rho * 100, 8)}%`, pwait: `${f(pw * 100, 8)}% (Erlang C)`, lq: f(Lq, 10), l: f(L, 10), wq: f(Wq, 10), w: f(W, 10), p0: f(p0, 10) }, steps: [`Offered load a = λ ÷ μ = ${f(a, 10)}, ρ = a ÷ c = ${f(rho, 10)}`, `P₀ = ${f(p0, 12)}`, `Erlang C: P(wait) = ${f(pw, 12)}`, `Lq = P(wait) ρ ÷ (1 − ρ) = ${f(Lq, 12)}`, `Wq = Lq ÷ λ = ${f(Wq, 12)}; W = Wq + 1/μ = ${f(W, 12)}`, `L = λW = ${f(L, 12)} (Little's law)`] });
    },

    prisoner: (i) => {
        const [T, Rw, Pn, S] = [i.t, i.r, i.p, i.s].map(Number);
        const rounds = Math.round(Number(i.rounds));
        const picked = Object.keys(STRATEGIES).filter((k) => String(i.strategies ?? 'tft,allc,alld,grim,tf2t,pavlov,random,gtft').split(',').map((x) => x.trim()).includes(k));

        if (![T, Rw, Pn, S].every(Number.isFinite) || !(rounds >= 1 && rounds <= 1000)) {
            return need('Enter the four payoffs and 1 to 1,000 rounds.');
        }

        if (!(T > Rw && Rw > Pn && Pn > S)) {
            return fail('A prisoner\'s dilemma needs T > R > P > S (temptation, reward, punishment, sucker).');
        }

        const pay = { CC: [Rw, Rw], CD: [S, T], DC: [T, S], DD: [Pn, Pn] };
        const names = picked.length >= 2 ? picked : Object.keys(STRATEGIES);
        const totals = Object.fromEntries(names.map((k) => [k, 0]));
        const table = names.map(() => names.map(() => 0));

        names.forEach((a, x) => {
            names.forEach((b, y) => {
                if (y < x) {
                    return;
                }

                const rng = mulberry32(1234 + 31 * x + y);
                const ha = [];
                const hb = [];
                let sa = 0;
                let sb = 0;

                for (let k = 0; k < rounds; k += 1) {
                    const ma = STRATEGIES[a][1](ha, hb, k, rng);
                    const mb = STRATEGIES[b][1](hb, ha, k, rng);
                    const [pa, pb] = pay[ma + mb];
                    sa += pa;
                    sb += pb;
                    ha.push(ma);
                    hb.push(mb);
                }

                table[x][y] = sa;
                table[y][x] = sb;

                if (x === y) {
                    totals[a] += sa;
                } else {
                    totals[a] += sa;
                    totals[b] += sb;
                }
            });
        });
        const ranking = [...names].sort((u, v) => totals[v] - totals[u]);

        return result(STRATEGIES[ranking[0]][0], 'Tournament winner', { sub: `${f(totals[ranking[0]])} points over ${names.length} matches of ${rounds} rounds`, rows: { ranking: ranking.map((k, n) => `${n + 1}. ${STRATEGIES[k][0]} ${f(totals[k])}`).join('; '), payoffs: `T = ${T}, R = ${Rw}, P = ${Pn}, S = ${S}`, lesson: 'Nice, retaliating and forgiving strategies such as tit for tat tend to win round-robin tournaments (Axelrod, 1980)' }, steps: ['Every strategy plays every other (and itself) for the chosen number of rounds; random moves use a fixed seed', ...ranking.map((k) => `${STRATEGIES[k][0]}: ${f(totals[k])}`)], grids: { scores: { columns: names.map((k) => STRATEGIES[k][0].split(' (')[0]), rows: names.map((k, x) => ({ header: STRATEGIES[k][0].split(' (')[0], cells: table[x].map((v) => f(v)) })) } } });
    },

    random: (i) => {
        const [lo, hi] = [i.min, i.max].map(Number);
        const count = Math.round(Number(i.count ?? 1));
        const places = Math.round(Number(i.places ?? 0));
        const unique = i.unique === 'yes';

        if (![lo, hi].every(Number.isFinite) || hi < lo) {
            return need('Enter a minimum and a maximum (at least the minimum).');
        }

        if (!(count >= 1 && count <= 1000) || !(places >= 0 && places <= 6)) {
            return need('Generate 1 to 1,000 numbers with 0 to 6 decimal places.');
        }

        const scale = 10 ** places;
        const loI = Math.ceil(lo * scale - 1e-9);
        const hiI = Math.floor(hi * scale + 1e-9);
        const span = hiI - loI + 1;

        if (span < 1) {
            return fail('No numbers with that many decimal places lie in the range.');
        }

        if (unique && count > span) {
            return fail(`Only ${span.toLocaleString('en-US')} different values exist in the range.`);
        }

        const picked = new Set();
        const out = [];

        while (out.length < count) {
            const v = loI + randomBelow(span);

            if (unique && picked.has(v)) {
                continue;
            }

            picked.add(v);
            out.push(v / scale);
        }

        const text = (v) => v.toFixed(places);
        const sum = out.reduce((s, v) => s + v, 0);

        return result(out.slice(0, 20).map(text).join(', ') + (out.length > 20 ? ' …' : ''), `${count} random number${count === 1 ? '' : 's'} from ${text(lo)} to ${text(hi)}`, { sub: `Sum ${f(sum, 12)}, mean ${f(sum / count, 10)}`, rows: { list: out.map(text).join(', '), sorted: [...out].sort((a, b) => a - b).map(text).join(', '), sum: f(sum, 12), method: 'Browser cryptographic random numbers with rejection sampling (every value equally likely)' }, steps: [`Each value is a uniform choice among ${span.toLocaleString('en-US')} possible values${unique ? ', without repeats' : ''}`, ...out.slice(0, 50).map(text)] });
    },
};

export default defineTools(handlers);
