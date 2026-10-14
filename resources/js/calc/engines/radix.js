/**
 * Radix engine: whole numbers between bases 2, 8, 10 and 16 using BigInt, so there is no size limit.
 * Config: none; the direction toggle is "from:to" in radix numbers, e.g. "2:16".
 */
const DIGITS = { 2: /^[01]+$/, 8: /^[0-7]+$/, 10: /^[0-9]+$/, 16: /^[0-9a-f]+$/i };
const NAMES = { 2: 'binary', 8: 'octal', 10: 'decimal', 16: 'hexadecimal' };
const MAX_STEPS = 8;

export function parseRadix(text, radix) {
    const cleaned = String(text).trim().replace(/[\s_]/g, '').replace(/^0[bxo]/i, '');
    const negative = cleaned.startsWith('-');
    const digits = negative ? cleaned.slice(1) : cleaned;

    if (!DIGITS[radix].test(digits)) {
        return null;
    }

    const value = [...digits.toLowerCase()].reduce((total, digit) => total * BigInt(radix) + BigInt(parseInt(digit, 16)), 0n);

    return negative ? -value : value;
}

export function toRadix(value, radix) {
    const text = (value < 0n ? -value : value).toString(radix);

    return (value < 0n ? '-' : '') + (radix === 16 ? text.toUpperCase() : text);
}

/**
 * Splits digits into groups from the right, e.g. binary in fours.
 */
export function groupFromRight(text, size, separator = ' ') {
    const negative = text.startsWith('-');
    const digits = negative ? text.slice(1) : text;
    const groups = [];

    for (let end = digits.length; end > 0; end -= size) {
        groups.unshift(digits.slice(Math.max(0, end - size), end));
    }

    return (negative ? '-' : '') + groups.join(separator);
}

export function bitLength(value) {
    const magnitude = value < 0n ? -value : value;

    return magnitude === 0n ? 1 : magnitude.toString(2).length;
}

/**
 * Worked steps: repeated division for decimal → base, positional sum for base → decimal.
 */
export function conversionSteps(value, from, to) {
    const magnitude = value < 0n ? -value : value;

    if (from === 10) {
        const steps = [];
        let quotient = magnitude;

        while (quotient > 0n && steps.length < MAX_STEPS) {
            const remainder = quotient % BigInt(to);
            steps.push(`${quotient} ÷ ${to} = ${quotient / BigInt(to)} remainder ${toRadix(remainder, to)}`);
            quotient /= BigInt(to);
        }

        if (quotient > 0n) {
            steps.push('… continue until the quotient is 0');
        }

        steps.push(`Read the remainders from bottom to top: ${toRadix(magnitude, to)}`);

        return steps;
    }

    const digits = [...toRadix(magnitude, from)];
    const terms = digits.map((digit, index) => `${digit}×${from}^${digits.length - 1 - index}`);
    const shown = terms.length > MAX_STEPS ? [...terms.slice(0, MAX_STEPS), '…'] : terms;

    return [`${shown.join(' + ')}`, `= ${magnitude.toString(10)} in decimal`, ...(to === 10 ? [] : [`= ${toRadix(magnitude, to)} in ${NAMES[to]}`])];
}

export default function radixEngine(ctx) {
    ctx.onUpdate(() => {
        const [from, to] = ctx.choice('direction').split(':').map(Number);
        const text = ctx.field('value').value;
        ctx.setText('value-label', `${NAMES[from][0].toUpperCase()}${NAMES[from].slice(1)} number`);

        if (text.trim() === '') {
            ctx.clearResult(`Enter a ${NAMES[from]} number.`);

            return;
        }

        const value = parseRadix(text, from);

        if (value === null) {
            const allowed = { 2: '0 and 1', 8: '0 to 7', 10: '0 to 9', 16: '0 to 9 and A to F' }[from];
            ctx.showError(`A ${NAMES[from]} number can only use the digits ${allowed}. Fractions are not supported.`);

            return;
        }

        const result = toRadix(value, to);
        const grouping = { 2: 4, 8: 3, 10: 3, 16: 4 }[to];

        ctx.showResult({
            value: groupFromRight(result, grouping, to === 10 ? ',' : ' '),
            unit: `base ${to}`,
            label: NAMES[to][0].toUpperCase() + NAMES[to].slice(1),
            sub: `${text.trim()} in base ${from}`,
        });

        ctx.setRow('bin', groupFromRight(toRadix(value, 2), 4));
        ctx.setRow('oct', toRadix(value, 8));
        ctx.setRow('dec', groupFromRight(toRadix(value, 10), 3, ','));
        ctx.setRow('hex', groupFromRight(toRadix(value, 16), 4));
        ctx.setRow('bits', `${bitLength(value)} bits`);
        ctx.setRow('bytes', `${Math.ceil(bitLength(value) / 8)} bytes`);
        ctx.renderSteps('steps', conversionSteps(value, from, to));
    });
}
