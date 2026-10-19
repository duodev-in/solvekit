import { formatMoney, getCurrency } from '../currency.js';

/**
 * Formatting and shared output helpers for the Finance section. Percent fields are entered as
 * percentages (25 = 25%) and handlers divide them by 100; results format rates back to percent.
 */
const intl = (options) => new Intl.NumberFormat('en-US', options);

/**
 * Money in a currency: `symbol` is a currency code (USD, INR…), the page's display currency when left out.
 * Two decimals for most currencies (Indian lakh/crore grouping for rupees), e.g. $1,234.50 or ₹12,34,567.00.
 */
export function money(value, symbol = getCurrency()) {
    return formatMoney(value, { code: symbol });
}

/**
 * Whole money amounts for large totals in tables and charts, e.g. $231,676 or ₹23,16,764.
 */
export function money0(value, symbol = getCurrency()) {
    return formatMoney(value, { code: symbol, decimals: 0 });
}

/**
 * A plain number: up to two decimals from 10 upward, four significant digits below.
 */
export function num(value) {
    if (!Number.isFinite(value)) {
        return '—';
    }

    if (value === 0) {
        return '0';
    }

    const magnitude = Math.abs(value);

    if (magnitude >= 1e15 || magnitude < 1e-6) {
        return value.toExponential(3).replace('e', ' × 10^').replace('-', '−');
    }

    const text = magnitude >= 10 ? intl({ maximumFractionDigits: 2 }).format(value) : intl({ maximumSignificantDigits: 4 }).format(value);

    return text.replace(/^-/, '−');
}

/**
 * A fraction as a percentage: 0.1234 → 12.34%.
 */
export const pct = (fraction) => (Number.isFinite(fraction) ? `${num(fraction * 100)}%` : '—');

const UNIT_TEXT = { d: ['day', 'days'], y: ['year', 'years'], m: ['month', 'months'], h: ['hour', 'hours'] };

/**
 * Formats a value by kind: $ money, % percent (from a fraction), x ratio, bp basis points, n number,
 * d/y/m/h days, years, months, hours.
 */
export function formatKind(value, kind, symbol = getCurrency()) {
    if (!Number.isFinite(value)) {
        return '—';
    }

    if (kind === '$') {
        return money(value, symbol);
    }

    if (kind === '%') {
        return pct(value);
    }

    if (kind === 'x') {
        return `${num(value)}×`;
    }

    if (kind === 'bp') {
        return `${num(value)} bp`;
    }

    if (UNIT_TEXT[kind]) {
        return `${num(value)} ${UNIT_TEXT[kind][Math.abs(value) === 1 ? 0 : 1]}`;
    }

    return num(value);
}

/**
 * Splits a formatted value into the big number and its unit for the result block.
 */
export function resultParts(value, kind, symbol = getCurrency()) {
    if (kind === '%') {
        return { value: num(value * 100), unit: '%' };
    }

    if (kind === 'x') {
        return { value: num(value), unit: '×' };
    }

    if (kind === 'bp') {
        return { value: num(value), unit: 'bp' };
    }

    if (UNIT_TEXT[kind]) {
        return { value: num(value), unit: UNIT_TEXT[kind][Math.abs(value) === 1 ? 0 : 1] };
    }

    return { value: formatKind(value, kind, symbol), unit: '' };
}

/**
 * Runs a one-formula tool described by the generated table in fin-simple.js:
 *   inputs: [[name, kind, optional]] (kind % values are divided by 100)
 *   out:    [label, fn(values), kind]
 *   rows:   [[key, fn(values), kind]]
 * Blank optional inputs count as 0 in the main result and leave dependent rows as —.
 */
export function runSimple(spec, i, config = {}) {
    const symbol = config.sym ?? getCurrency();
    const main = {};
    const extra = {};
    const blank = [];

    for (const [name, kind, optional] of spec.inputs) {
        const raw = i[name];
        const isBlank = raw === undefined || raw === '' || Number.isNaN(raw);

        if (isBlank && !optional) {
            return { empty: 'Enter all the values to see the result.' };
        }

        const value = isBlank ? NaN : Number(raw) / (kind === '%' ? 100 : 1);
        main[name] = isBlank ? 0 : value;
        extra[name] = value;

        if (isBlank) {
            blank.push(name);
        }
    }

    const [label, fn, kind] = spec.out;
    const value = fn(main);

    if (!Number.isFinite(value)) {
        return { error: 'These values give no result: check for a zero divisor or an impossible combination.' };
    }

    const rows = Object.fromEntries(spec.rows.map(([key, rowFn, rowKind]) => [key, formatKind(rowFn(extra), rowKind, symbol)]));

    if (spec.src) {
        // Percent inputs appear as the decimals the formula uses (21% → 0.21).
        const filled = spec.src.replace(/(?<![\w.])([A-Za-z_]\w*)(?!\w)/g, (word) => (word in main ? num(main[word]) : word));
        rows.calc = `${filled} = ${num(value)}`;
    }

    return { ...resultParts(value, kind, symbol), label, rows };
}

/**
 * Year table for a schedule: columns and rows for <x-calc.grid>, money without cents.
 */
export function yearGrid(years, columns, symbol = getCurrency()) {
    // `symbol` may also be a formatter, e.g. one with Indian digit grouping.
    const format = typeof symbol === 'function' ? symbol : (value) => money0(value, symbol);

    return {
        columns: columns.map(([title]) => title),
        rows: years.map((row) => ({ header: String(row.year), cells: columns.map(([, key]) => format(row[key])) })),
        roomy: true,
    };
}

/**
 * Parses a free list of numbers separated by commas, spaces or new lines.
 */
export const numberList = (text) => String(text ?? '').split(/[\s,;]+/).filter(Boolean).map(Number).filter(Number.isFinite);
