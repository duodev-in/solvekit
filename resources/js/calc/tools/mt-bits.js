import { defineTools } from '../engines/formula.js';
import * as B from '../math/bits.js';
import { f, fail, need, R, result } from '../math/util.js';

/**
 * Binary tools: logic gates at a chosen width, binary and hex arithmetic (exact BigInt, optional fixed width
 * with overflow), shifts and rotates, one's and two's complement, binary fractions (exact, with repeating
 * blocks), IEEE 754 fields with the exact stored value, and Gray code.
 */
const { abs } = Math;
const fmtBig = (v) => (v < 0n ? `−${(-v).toLocaleString('en-US')}` : v.toLocaleString('en-US'));
const BASES = { bin: 2, dec: 10, hex: 16, auto: 'auto' };

/** Reads an integer typed in the chosen base (auto accepts 0b and 0x prefixes; binary/hex need no prefix). */
function readInt(text, base) {
    const s = String(text ?? '').trim();

    if (!s) {
        return null;
    }

    return B.parseInteger(s, BASES[base] ?? 'auto');
}

const binText = (v) => (v < 0n ? `−${(-v).toString(2)}` : v.toString(2));
const hexText = (v) => (v < 0n ? `−${(-v).toString(16).toUpperCase()}` : v.toString(16).toUpperCase());
const group = (s) => s.replace(/\B(?=(\d{4})+(?!\d))/g, ' ');

/** Aligned rows of bit patterns for the working panel. */
function aligned(rows, bits) {
    const width = Math.max(...rows.map((r) => r[0].length));

    return rows.map(([name, pattern, note]) => `${name.padEnd(width)}  ${B.binary(pattern, bits)}${note ? `   ${note}` : ''}`);
}

export const handlers = {
    logic: (i, c) => {
        const op = c.op ?? i.op ?? 'and';
        const bits = Number(i.bits ?? 8);
        const a = readInt(i.a, i.base);
        const b = op === 'not' ? 0n : readInt(i.b, i.base);

        if (a === null || b === null) {
            return need(op === 'not' ? 'Enter a number (binary, decimal or hex as chosen).' : 'Enter both numbers (binary, decimal or hex as chosen).');
        }

        const A = B.wrap(a, bits);
        const Bv = B.wrap(b, bits);
        const r = B.bitOp(op, a, b, bits);
        const name = op.toUpperCase();
        const truth = { and: '1 only when both bits are 1', or: '1 when either bit is 1', xor: '1 when the bits differ', nand: 'NOT AND: 0 only when both bits are 1', nor: 'NOT OR: 1 only when both bits are 0', xnor: 'NOT XOR: 1 when the bits are equal', not: 'Flips every bit' }[op];
        const lines = aligned([['A', A, `(${fmtBig(A)})`], ...(op === 'not' ? [] : [['B', Bv, `(${fmtBig(Bv)})`]]), [name, r, `(${fmtBig(r)})`]], bits);
        const wrapped = a !== A || (op !== 'not' && b !== Bv);

        return result(group(r.toString(2).padStart(bits, '0')), `${op === 'not' ? 'NOT A' : `A ${name} B`} (${bits}-bit)`, { sub: `= ${fmtBig(r)} = 0x${B.hex(r, bits)}`, rows: { binary: B.binary(r, bits), decimal: fmtBig(r), signed: fmtBig(B.signed(r, bits)), hex: `0x${B.hex(r, bits)}`, rule: truth }, steps: [`Each bit: ${truth}`, ...lines, ...(wrapped ? [`Negative or oversized inputs were taken as ${bits}-bit two's complement patterns`] : [])] });
    },

    arith: (i, c) => {
        const op = c.op ?? i.op ?? 'add';
        const base = c.base ?? i.base ?? 'bin';
        const a = readInt(i.a, base);
        const b = readInt(i.b, base);
        const width = i.bits && i.bits !== 'none' ? Number(i.bits) : null;
        const show = base === 'hex' ? hexText : base === 'dec' ? fmtBig : binText;

        if (a === null || b === null) {
            return need(`Enter both numbers in ${base === 'hex' ? 'hexadecimal' : base === 'dec' ? 'decimal' : 'binary'}.`);
        }

        if ((op === 'div' || op === 'mod') && b === 0n) {
            return fail('Division by zero is undefined.');
        }

        let r;
        let rem = null;
        const steps = [];

        if (op === 'add') {
            r = a + b;
        } else if (op === 'sub') {
            r = a - b;
        } else if (op === 'mul') {
            r = a * b;
        } else {
            // Floor-free truncating division like hardware, with a non-negative remainder for positive inputs.
            r = a / b;
            rem = a - r * b;
        }

        if (op === 'mod') {
            r = ((a % b) + b) % b;
        }

        // Long-hand working for non-negative binary operands.
        if (a >= 0n && b >= 0n && base !== 'dec') {
            const radix = base === 'hex' ? 16 : 2;
            const sa = a.toString(radix).toUpperCase();
            const sb = b.toString(radix).toUpperCase();

            if (op === 'add' || (op === 'sub' && a >= b)) {
                const n = Math.max(sa.length, sb.length) + 1;
                const pa = sa.padStart(n, '0');
                const pb = sb.padStart(n, '0');
                let carry = 0;
                const marks = Array(n).fill(' ');

                for (let k = n - 1; k >= 0; k -= 1) {
                    const x = parseInt(pa[k], radix);
                    const y = parseInt(pb[k], radix);

                    if (carry) {
                        marks[k] = op === 'add' ? '1' : 'b';
                    }

                    carry = op === 'add' ? (x + y + carry >= radix ? 1 : 0) : x - y - carry < 0 ? 1 : 0;
                }

                const res = (op === 'add' ? a + b : a - b).toString(radix).toUpperCase().padStart(n, ' ');
                steps.push(`${(op === 'add' ? 'carry' : 'borrow').padEnd(7)}${marks.join('')}`, `       ${sa.padStart(n, ' ')}`, `   ${op === 'add' ? '+' : '−'}   ${sb.padStart(n, ' ')}`, `       ${'─'.repeat(n)}`, `       ${res}`);
            } else if (op === 'mul' && sb.length <= 16) {
                const n = sa.length + sb.length;
                steps.push(`  ${sa.padStart(n, ' ')}`, `× ${sb.padStart(n, ' ')}`, `  ${'─'.repeat(n)}`);
                [...sb].reverse().forEach((d, k) => {
                    const part = BigInt(parseInt(d, radix)) * a;
                    steps.push(`  ${(part === 0n ? '0'.repeat(sa.length) : part.toString(radix).toUpperCase()).padStart(n - k, ' ')}${' '.repeat(k)}`);
                });
                steps.push(`  ${'─'.repeat(n)}`, `  ${(a * b).toString(radix).toUpperCase().padStart(n, ' ')}`);
            } else if ((op === 'div' || op === 'mod') && b > 0n) {
                steps.push(`Long division of ${sa} by ${sb} (base ${radix}):`);
                let cur = 0n;
                let q = '';

                for (const d of sa) {
                    cur = cur * BigInt(radix) + BigInt(parseInt(d, radix));
                    const digit = cur / b;
                    q += digit.toString(radix).toUpperCase();

                    if (digit) {
                        steps.push(`  ${cur.toString(radix).toUpperCase()} − ${(digit * b).toString(radix).toUpperCase()} = ${(cur - digit * b).toString(radix).toUpperCase()}`);
                    }

                    cur -= digit * b;
                }

                steps.push(`Quotient ${q.replace(/^0+(?=.)/, '')}, remainder ${cur.toString(radix).toUpperCase()}`);
            }
        }

        let overflow = '';

        if (width) {
            const wrapped = B.wrap(r, width);
            const fitsU = B.inRange(r, width, false);
            const fitsS = B.inRange(r, width, true);
            overflow = fitsU && fitsS ? 'No overflow' : `${!fitsU ? `Unsigned overflow (wraps to ${fmtBig(wrapped)})` : ''}${!fitsU && !fitsS ? '; ' : ''}${!fitsS ? `signed overflow (wraps to ${fmtBig(B.signed(wrapped, width))})` : ''}`;
            steps.push(`${width}-bit pattern: ${B.binary(wrapped, width)}`);
        }

        const sym = { add: '+', sub: '−', mul: '×', div: '÷', mod: 'mod' }[op];
        const value = op === 'div' ? `${show(r)} r ${show(rem)}` : show(r);

        return result(value, `${show(a)} ${sym} ${show(b)}`, { sub: `= ${fmtBig(r)}${op === 'div' ? ` remainder ${fmtBig(rem)}` : ''} in decimal`, rows: { binary: group(binText(r)), decimal: fmtBig(r), hex: hexText(r), octal: r < 0n ? `−${(-r).toString(8)}` : r.toString(8), overflow: overflow || 'Unlimited width (no overflow)', ...(op === 'div' ? { remainder: `${show(rem)} (${fmtBig(rem)})` } : {}) }, steps: [`A = ${show(a)} = ${fmtBig(a)}, B = ${show(b)} = ${fmtBig(b)}`, ...steps, `Result: ${value}`] });
    },

    shift: (i) => {
        const bits = Number(i.bits ?? 8);
        const a = readInt(i.a, i.base);
        const n = Number(i.n);
        const kind = i.kind ?? 'left';

        if (a === null || !Number.isInteger(n) || n < 0) {
            return need('Enter the number and a whole shift amount.');
        }

        const A = B.wrap(a, bits);
        const r = B.shift(a, n, kind, bits);
        const label = { left: 'Logical shift left', right: 'Logical shift right', arith: 'Arithmetic shift right', rol: 'Rotate left', ror: 'Rotate right' }[kind];
        const effect = kind === 'left' ? `× 2^${n} = × ${2 ** n} (bits pushed out are lost)` : kind === 'right' ? `÷ 2^${n}, rounded down (unsigned)` : kind === 'arith' ? `÷ 2^${n} rounded down, keeping the sign bit` : 'No bits are lost; they wrap around';

        return result(group(r.toString(2).padStart(bits, '0')), `${label} by ${n}`, { sub: `= ${fmtBig(r)} unsigned, ${fmtBig(B.signed(r, bits))} signed`, rows: { binary: B.binary(r, bits), decimal: fmtBig(r), signed: fmtBig(B.signed(r, bits)), hex: `0x${B.hex(r, bits)}`, rule: effect }, steps: [...aligned([['before', A, `(${fmtBig(A)})`], ['after', r, `(${fmtBig(r)})`]], bits), effect] });
    },

    complement: (i, c) => {
        const kind = c.kind ?? 'twos';
        const bits = Number(i.bits ?? 8);
        const text = String(i.a ?? '').trim();
        const asPattern = (i.base ?? 'dec') !== 'dec';
        const v = readInt(text, asPattern ? i.base : 'dec');

        if (v === null) {
            return need(asPattern ? 'Enter a bit pattern.' : 'Enter a whole number (negative allowed).');
        }

        if (asPattern) {
            if (v < 0n || v > B.mask(bits)) {
                return fail(`The pattern does not fit in ${bits} bits.`);
            }

            const value = kind === 'twos' ? B.signed(v, bits) : (v >> BigInt(bits - 1)) ? -((~v) & B.mask(bits)) : v;

            return result(fmtBig(value), `Value of the ${bits}-bit ${kind === 'twos' ? "two's" : "one's"} complement pattern`, { sub: `${B.binary(v, bits)} with the leading bit as the sign`, rows: { binary: B.binary(v, bits), ones: B.binary(~v & B.mask(bits), bits), twos: B.binary(B.wrap(-v, bits), bits), range: kind === 'twos' ? `${fmtBig(-(1n << BigInt(bits - 1)))} to ${fmtBig((1n << BigInt(bits - 1)) - 1n)}` : `${fmtBig(-((1n << BigInt(bits - 1)) - 1n))} to ${fmtBig((1n << BigInt(bits - 1)) - 1n)} (with two zeros)`, hex: `0x${B.hex(v, bits)}` }, steps: [kind === 'twos' ? 'Two\'s complement: the leading bit is worth −2^(n−1)' : 'One\'s complement: a leading 1 means negative; flip all bits to read the size', `Value = ${fmtBig(value)}`] });
        }

        const limit = kind === 'twos' ? 1n << BigInt(bits - 1) : (1n << BigInt(bits - 1)) - 1n;

        if (v >= (1n << BigInt(bits - 1)) || v < -limit) {
            return fail(`${fmtBig(v)} does not fit in ${bits}-bit ${kind === 'twos' ? "two's" : "one's"} complement (range ${kind === 'twos' ? `${fmtBig(-limit)} to ${fmtBig(limit - 1n)}` : `±${fmtBig(limit)}`}).`);
        }

        const plain = v < 0n ? -v : v;
        const ones = v < 0n ? ~plain & B.mask(bits) : plain;
        const twos = B.wrap(v, bits);
        const pattern = kind === 'twos' ? twos : ones;

        return result(group(pattern.toString(2).padStart(bits, '0')), `${bits}-bit ${kind === 'twos' ? "two's" : "one's"} complement of ${fmtBig(v)}`, { sub: `0x${B.hex(pattern, bits)}`, rows: { binary: B.binary(pattern, bits), ones: B.binary(ones, bits), twos: B.binary(twos, bits), range: kind === 'twos' ? `${fmtBig(-limit)} to ${fmtBig(limit - 1n)}` : `−${fmtBig(limit)} to ${fmtBig(limit)}`, hex: `0x${B.hex(pattern, bits)}` }, steps: [`|${fmtBig(v)}| in binary: ${B.binary(plain, bits)}`, ...(v < 0n ? [`Flip every bit (one's complement): ${B.binary(ones, bits)}`, ...(kind === 'twos' ? [`Add 1 (two's complement): ${B.binary(twos, bits)}`] : [])] : ['Positive numbers are stored unchanged'])] });
    },

    fraction: (i) => {
        const dir = i.dir ?? 'to';

        if (dir === 'from') {
            const text = String(i.bin ?? '').trim().replace(/[−–]/g, '-');
            const rep = text.match(/^(-?)([01]*)\.([01]*)\(([01]+)\)$/);

            if (rep) {
                // Repeating binary: value = int + (fixed + repeat/(2^r − 1)) / 2^f.
                const [, sign, int, fixed, repeat] = rep;
                const intV = int ? BigInt(`0b${int}`) : 0n;
                const fixedV = fixed ? BigInt(`0b${fixed}`) : 0n;
                const repV = BigInt(`0b${repeat}`);
                const den = (2n ** BigInt(repeat.length) - 1n) * 2n ** BigInt(fixed.length);
                const num = fixedV * (2n ** BigInt(repeat.length) - 1n) + repV;
                let v = R.add(R.Q(intV), R.Q(num, den));
                v = sign ? R.neg(v) : v;

                return result(R.toFraction(v), 'Decimal value', { sub: `= ${f(R.toNumber(v), 15)}`, rows: { exact: R.toFraction(v), decimal: f(R.toNumber(v), 15), binary: text, kind: 'Repeating binary fraction' }, steps: [`Repeating block ${repeat} of length ${repeat.length}: worth ${repeat}₂ ÷ (2^${repeat.length} − 1)`, `= ${R.toFraction(v)}`] });
            }

            const dec = B.binaryToDecimal(text);

            if (dec === null) {
                return need('Type a binary number such as 101.011 (or 0.0(0011) for a repeating block).');
            }

            const frac = text.split('.')[1] ?? '';

            return result(dec, 'Decimal value', { sub: `${text}₂ = ${dec}₁₀`, rows: { exact: dec, decimal: dec, binary: text, kind: 'Terminating (every finite binary fraction is a finite decimal)' }, steps: [...[...frac].map((d, k) => (d === '1' ? `bit ${k + 1} after the point: 2^−${k + 1} = ${B.binaryToDecimal(`0.${'0'.repeat(k)}1`)}` : null)).filter(Boolean), `Total: ${dec}`] });
        }

        const x = R.parseNumber(String(i.dec ?? ''));

        if (!x) {
            return need('Type a decimal number such as 0.1 or 5.75 (fractions like 1/3 work too).');
        }

        const neg = R.sign(x) < 0;
        const ax = R.qabs(x);
        const intPart = ax.n / ax.d;
        let rem = ax.n % ax.d;
        const den = ax.d;
        const seen = new Map();
        let digits = '';
        let repeatAt = -1;
        const steps = [];

        while (rem !== 0n && digits.length < 200) {
            if (seen.has(rem)) {
                repeatAt = seen.get(rem);
                break;
            }

            seen.set(rem, digits.length);
            rem *= 2n;
            const bit = rem >= den ? 1n : 0n;

            if (digits.length < 12) {
                steps.push(`× 2 = ${R.toFraction(R.Q(rem, den))} → bit ${bit}`);
            }

            digits += bit;
            rem -= bit * den;
        }

        const intBin = intPart.toString(2);
        const text = repeatAt >= 0 ? `${neg ? '−' : ''}${intBin}.${digits.slice(0, repeatAt)}(${digits.slice(repeatAt)})` : `${neg ? '−' : ''}${intBin}${digits ? `.${digits}` : ''}`;

        return result(text, 'Binary', { sub: repeatAt >= 0 ? `Repeats forever: the block ${digits.slice(repeatAt)} (period ${digits.length - repeatAt})` : 'Terminates (the denominator is a power of 2)', rows: { exact: R.toFraction(x), decimal: f(R.toNumber(x), 15), binary: text, kind: repeatAt >= 0 ? `Repeating: ${R.toFraction(x)} has a denominator that is not a power of 2, so it cannot be stored exactly in binary floating point` : 'Exact in binary' }, steps: [`Integer part ${intPart} = ${intBin}₂`, 'Fraction part: multiply by 2 repeatedly, the integer part of each product is the next bit', ...steps, ...(repeatAt >= 0 ? ['A remainder repeated, so the bits repeat from there'] : [])] });
    },

    ieee: (i) => {
        const bits = Number(i.bits ?? 32);
        const dir = i.dir ?? 'to';
        let pattern;
        let input = null;

        if (dir === 'from') {
            const text = String(i.pattern ?? '').trim().replace(/\s/g, '');
            const v = /^0x/i.test(text) ? B.parseInteger(text) : /^[01]+$/.test(text) ? B.parseInteger(text, 2) : null;

            if (v === null || v < 0n || v > B.mask(bits)) {
                return need(`Enter ${bits} bits (or 0x followed by ${bits / 4} hex digits).`);
            }

            pattern = v;
        } else {
            input = R.parseNumber(String(i.x ?? '').trim());
            const raw = String(i.x ?? '').trim().toLowerCase();
            const special = { inf: Infinity, infinity: Infinity, '-inf': -Infinity, nan: NaN }[raw];

            if (!input && special === undefined) {
                return need('Enter a decimal number such as 0.1 or −2.5e−3.');
            }

            pattern = B.ieee754(special ?? R.toNumber(input), bits).pattern;
        }

        const info = B.ieee754(0, bits);
        const eBits = info.eBits;
        const mBits = info.mBits;
        const bias = info.bias;
        const sign = pattern >> BigInt(bits - 1);
        const exp = (pattern >> BigInt(mBits)) & B.mask(eBits);
        const man = pattern & B.mask(mBits);
        const value = B.fromPattern(pattern, bits);
        const kind = exp === B.mask(eBits) ? (man ? 'NaN' : 'Infinity') : exp === 0n ? (man ? 'Subnormal' : 'Zero') : 'Normal';
        // Exact stored value as a fraction: (−1)^s × M × 2^E.
        let stored = null;

        if (kind === 'Normal' || kind === 'Subnormal') {
            const M = kind === 'Normal' ? (1n << BigInt(mBits)) + man : man;
            const E = (kind === 'Normal' ? Number(exp) - bias : 1 - bias) - mBits;
            stored = E >= 0 ? R.Q(M * 2n ** BigInt(E)) : R.Q(M, 2n ** BigInt(-E));

            if (sign) {
                stored = R.neg(stored);
            }
        }

        const exactDecimal = stored ? R.toRepeating(stored) : kind === 'Zero' ? (sign ? '−0' : '0') : kind;
        const err = stored && input ? R.sub(stored, input) : null;
        const bitsText = `${sign} ${exp.toString(2).padStart(eBits, '0')} ${man.toString(2).padStart(mBits, '0')}`;

        return result(bitsText, `${bits}-bit IEEE 754 pattern (sign, exponent, mantissa)`, { sub: `0x${B.hex(pattern, bits)} = ${kind === 'Normal' || kind === 'Subnormal' ? f(value, 17) : kind}`, rows: { hex: `0x${B.hex(pattern, bits)}`, sign: `${sign} (${sign ? 'negative' : 'positive'})`, exponent: kind === 'Normal' ? `${exp.toString(2).padStart(eBits, '0')} = ${exp}, minus bias ${bias} → 2^${Number(exp) - bias}` : `${exp.toString(2).padStart(eBits, '0')} (${kind === 'Subnormal' ? `subnormal: 2^${1 - bias}` : kind})`, mantissa: `${man.toString(2).padStart(mBits, '0')}${kind === 'Normal' ? ' (with the hidden leading 1)' : ''}`, stored: exactDecimal.length > 120 ? `${exactDecimal.slice(0, 120)}…` : exactDecimal, error: err ? (R.isZero(err) ? 'None: the number is stored exactly' : `${f(R.toNumber(err), 6)} (relative ${f(abs(R.toNumber(err) / R.toNumber(input)), 3)})`) : 'Not applicable', kind },
            steps: [...(input ? [`Input ${R.toFraction(input)}`] : []), `Sign bit ${sign}`, kind === 'Normal' ? `Exponent field ${exp} − bias ${bias} = ${Number(exp) - bias}` : `Exponent field ${exp}: ${kind}`, `Mantissa ${man.toString(2).padStart(mBits, '0')}`, `Value = ${sign ? '−' : ''}${kind === 'Normal' ? '1.' : '0.'}mantissa × 2^${kind === 'Normal' ? Number(exp) - bias : 1 - bias}`, `Exactly ${exactDecimal.length > 200 ? `${exactDecimal.slice(0, 200)}…` : exactDecimal}`] });
    },

    gray: (i) => {
        const dir = i.dir ?? 'to';
        const text = String(i.a ?? '').trim();
        const base = i.base ?? (dir === 'to' ? 'dec' : 'bin');
        const v = readInt(text, dir === 'to' ? base : 'bin');

        if (v === null || v < 0n) {
            return need(dir === 'to' ? 'Enter a non-negative number.' : 'Enter a Gray code in binary.');
        }

        const width = Math.max(1, v.toString(2).length);

        if (dir === 'to') {
            const g = B.toGray(v);

            return result(g.toString(2).padStart(width, '0'), 'Gray code', { sub: `${fmtBig(v)} = ${v.toString(2)}₂`, rows: { binary: v.toString(2), gray: g.toString(2).padStart(width, '0'), decimal: fmtBig(v), next: `${fmtBig(v + 1n)} → ${B.toGray(v + 1n).toString(2).padStart(width, '0')} (one bit changes)` }, steps: ['Gray = n XOR (n >> 1)', ...aligned([['n', v], ['n>>1', v >> 1n], ['gray', g]], width)] });
        }

        const n = B.fromGray(v);

        return result(n.toString(2).padStart(width, '0'), 'Binary', { sub: `= ${fmtBig(n)}`, rows: { binary: n.toString(2), gray: text, decimal: fmtBig(n), next: `Next Gray code ${B.toGray(n + 1n).toString(2).padStart(width, '0')}` }, steps: ['Each binary bit = XOR of all Gray bits from the left up to it', `${text} → ${n.toString(2).padStart(width, '0')} = ${fmtBig(n)}`] });
    },
};

export default defineTools(handlers);
