import * as R from './rational.js';

/**
 * Small helpers shared by the Math tool modules: exact input parsing, display of exact values and
 * the outcome shape (every Math outcome sets the steps text so a previous result never lingers).
 */
export const need = (message) => ({ empty: message });
export const fail = (message) => ({ error: message });

/** Exact rational from a text field (also accepts a number from a number field). */
export function q(value, options) {
    if (value === undefined || value === null || value === '') {
        return null;
    }

    if (typeof value === 'number') {
        return Number.isFinite(value) ? R.fromNumber(value) : null;
    }

    return R.parseNumber(value, options);
}

/** Several exact values; null when any is missing or invalid. */
export function qs(...values) {
    const out = values.map((v) => q(v));

    return out.some((v) => v === null) ? null : out;
}

/** Plain double from a field. */
export function num(value) {
    if (typeof value === 'number') {
        return value;
    }

    const parsed = q(value);

    return parsed ? R.toNumber(parsed) : NaN;
}

/** Decimal text of an exact value: the exact expansion when short or repeating, else 12 places. */
export function dec(x, places = 12) {
    const e = R.expand(x, 60);

    if (e.terminates && e.fixed.length <= places) {
        return R.toRepeating(x).replace(/^(−?)(\d+)/, (m, s, i) => s + R.group(i));
    }

    if (e.repeat && e.fixed.length + e.repeat.length <= 8) {
        return R.toRepeating(x).replace(/^(−?)(\d+)/, (m, s, i) => s + R.group(i));
    }

    return `${R.toDecimal(x, places).replace(/^(−?)(\d+)/, (m, s, i) => s + R.group(i))}…`;
}

/** "3/4 (0.75)" or "5" for integers. */
export function both(x) {
    if (R.isInt(x)) {
        return R.fmt(x.n);
    }

    return `${R.toFraction(x)} (${dec(x)})`;
}

/** Percentage text from a rational fraction (0.25 → "25%"). */
export const pct = (x) => `${dec(R.mul(x, R.Q(100)))}%`;

/** Outcome with steps always present. */
export function result(value, label, { sub = '', unit = '', rows = {}, steps = '', grids, plots, lists } = {}) {
    return { value, unit, label, sub, rows, texts: { steps: Array.isArray(steps) ? steps.join('\n') : steps }, ...(grids ? { grids } : {}), ...(plots ? { plots } : {}), ...(lists ? { lists } : {}) };
}

export const f = (x, sig = 10) => R.fmt(Math.abs(x) < 1e-13 * Math.max(1, Math.abs(x)) ? 0 : x, sig);
export { R };
