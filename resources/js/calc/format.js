const EXPONENT_MAX = 1e15;
const EXPONENT_MIN = 1e-6;
const AUTO_SIGNIFICANT_DIGITS = 7;

const SUPERSCRIPT = { '-': '⁻', 0: '⁰', 1: '¹', 2: '²', 3: '³', 4: '⁴', 5: '⁵', 6: '⁶', 7: '⁷', 8: '⁸', 9: '⁹' };

/**
 * Formats a number in scientific notation, e.g. 1.2346 × 10²¹.
 */
export function formatScientific(value, significantDigits = 5) {
    const [mantissa, exponent] = value.toExponential(significantDigits - 1).split('e');
    const trimmedMantissa = mantissa.includes('.') ? mantissa.replace(/\.?0+$/, '') : mantissa;
    const power = String(Number(exponent)).replace(/[-\d]/g, (char) => SUPERSCRIPT[char]);

    return `${trimmedMantissa} × 10${power}`;
}

/**
 * Formats a calculated value for display.
 *
 * `decimals` is a number of decimal places, or 'auto' for up to seven significant digits.
 * Very large and very small magnitudes switch to scientific notation so long values never
 * overflow the result block. Output is never written back into a number input.
 */
export function formatNumber(value, decimals = 'auto') {
    if (typeof value !== 'number' || !Number.isFinite(value)) {
        return '—';
    }

    if (value === 0) {
        return '0';
    }

    const magnitude = Math.abs(value);

    if (magnitude >= EXPONENT_MAX || magnitude < EXPONENT_MIN) {
        return formatScientific(value, decimals === 'auto' ? 5 : Math.max(Number(decimals), 1) + 1);
    }

    if (decimals === 'auto') {
        return new Intl.NumberFormat('en-US', { maximumSignificantDigits: AUTO_SIGNIFICANT_DIGITS }).format(value);
    }

    const places = Number(decimals);
    const formatted = new Intl.NumberFormat('en-US', { minimumFractionDigits: places, maximumFractionDigits: places }).format(value);

    // A tiny non-zero value rounded away by fixed decimals would read as 0; show it in full instead.
    if (Number(formatted.replace(/,/g, '')) === 0) {
        return formatScientific(value, 3);
    }

    return formatted;
}

/**
 * Parses an input's text into a number, or NaN when it is empty or not numeric.
 */
export function parseNumber(text) {
    const trimmed = String(text ?? '').trim().replace(/,/g, '');

    if (trimmed === '' || !/^[-+]?(\d+\.?\d*|\.\d+)(e[-+]?\d+)?$/i.test(trimmed)) {
        return Number.NaN;
    }

    return Number(trimmed);
}
