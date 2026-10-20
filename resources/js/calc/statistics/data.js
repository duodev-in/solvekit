/**
 * Data handling for the Statistics section: parsing pasted numbers, order statistics, quantile methods,
 * moments and ranks.
 *
 * Numbers may be separated by commas, spaces, tabs, semicolons or new lines (as pasted from a spreadsheet).
 * Fractions such as 3/4 and mixed numbers such as 1 1/2 are not accepted here (Least to Greatest reads them itself).
 */

/** Splits text into numbers. Returns { values, bad } where bad lists tokens that are not numbers. */
export function parseNumbers(text) {
    const tokens = String(text ?? '').replace(/[−–]/g, '-').split(/[\s,;]+/).filter(Boolean);
    const values = [];
    const bad = [];

    for (const token of tokens) {
        const clean = token.replace(/^\((.*)\)$/, '$1');
        const n = /^[+-]?(\d+\.?\d*|\.\d+)(e[+-]?\d+)?%?$/i.test(clean) ? Number(clean.replace('%', '')) : NaN;

        if (Number.isFinite(n)) {
            values.push(n);
        } else {
            bad.push(token);
        }
    }

    return { values, bad };
}

/** Lines of a text box, each split into numbers: "x, y" pairs, table rows. Blank lines are skipped. */
export function parseRows(text) {
    return String(text ?? '').split(/\r?\n/).map((line) => line.trim()).filter(Boolean).map((line) => parseNumbers(line.replace(/\t/g, ' ')));
}

/** Two equal-length columns from "x, y" lines. Returns { x, y, problem }. */
export function parsePairs(text) {
    const rows = parseRows(text);
    const x = [];
    const y = [];

    for (const [index, row] of rows.entries()) {
        if (row.bad.length || row.values.length !== 2) {
            return { x, y, problem: `Line ${index + 1} should hold two numbers (x, y).` };
        }

        x.push(row.values[0]);
        y.push(row.values[1]);
    }

    return { x, y, problem: null };
}

/** Values from "value, frequency" lines (frequency defaults to 1). */
export function parseFrequencies(text) {
    const rows = parseRows(text);
    const values = [];

    for (const [index, row] of rows.entries()) {
        if (row.bad.length || row.values.length < 1 || row.values.length > 2 || (row.values.length === 2 && (row.values[1] < 0 || !Number.isInteger(row.values[1])))) {
            return { values, problem: `Line ${index + 1} should hold a value and a whole-number frequency.` };
        }

        for (let k = 0; k < (row.values[1] ?? 1); k += 1) {
            values.push(row.values[0]);
        }
    }

    return { values, problem: null };
}

export const sum = (xs) => {
    // Neumaier summation keeps long sums of mixed magnitudes accurate.
    let s = 0;
    let c = 0;

    for (const x of xs) {
        const t = s + x;
        c += Math.abs(s) >= Math.abs(x) ? s - t + x : x - t + s;
        s = t;
    }

    return s + c;
};

export const mean = (xs) => sum(xs) / xs.length;
export const sorted = (xs) => [...xs].sort((a, b) => a - b);

/** Sum of squared deviations from the mean (two-pass). */
export const ss = (xs, m = mean(xs)) => sum(xs.map((x) => (x - m) ** 2));
export const variance = (xs, sample = true) => ss(xs) / (xs.length - (sample ? 1 : 0));
export const sd = (xs, sample = true) => Math.sqrt(variance(xs, sample));

export function median(xs) {
    const s = sorted(xs);
    const n = s.length;

    return n % 2 ? s[(n - 1) / 2] : (s[n / 2 - 1] + s[n / 2]) / 2;
}

/** Modes: the most frequent values (all of them when tied); empty when every value occurs once. */
export function modes(xs) {
    const counts = new Map();
    xs.forEach((x) => counts.set(x, (counts.get(x) ?? 0) + 1));
    const top = Math.max(...counts.values());

    if (top === 1 && xs.length > 1) {
        return { values: [], count: 1, counts };
    }

    return { values: [...counts].filter(([, c]) => c === top).map(([v]) => v).sort((a, b) => (typeof a === 'number' ? a - b : String(a).localeCompare(String(b)))), count: top, counts };
}

/**
 * Quantile methods (Hyndman & Fan 1996 numbering):
 *   inc     type 7, Excel PERCENTILE.INC / QUARTILE.INC, R and NumPy default: h = (n − 1)p + 1
 *   exc     type 6, Excel PERCENTILE.EXC / QUARTILE.EXC, Minitab, SPSS: h = (n + 1)p
 *   nearest nearest rank (type 1): the ⌈np⌉-th value
 *   halves  quartiles as medians of the lower and upper halves, leaving out the median when n is odd (TI-84, many textbooks)
 *   tukey   Tukey hinges: medians of the halves including the median when n is odd
 */
export const QUANTILE_METHODS = {
    inc: 'Inclusive (Excel .INC, R type 7)',
    exc: 'Exclusive (Excel .EXC, Minitab, SPSS)',
    halves: 'Median of halves (TI-84, textbooks)',
    tukey: 'Tukey hinges',
    nearest: 'Nearest rank',
};

/** The p-th quantile of sorted data s. Returns NaN when the method cannot reach p (exc with small n). */
export function quantile(s, p, method = 'inc') {
    const n = s.length;

    if (!n) {
        return NaN;
    }

    if (method === 'nearest') {
        return s[Math.min(n, Math.max(1, Math.ceil(n * p))) - 1];
    }

    if (method === 'halves' || method === 'tukey') {
        if (p === 0.5) {
            return median(s);
        }

        if (p !== 0.25 && p !== 0.75) {
            return quantile(s, p, 'inc');
        }

        const half = method === 'tukey' ? Math.ceil(n / 2) : Math.floor(n / 2);
        const part = p === 0.25 ? s.slice(0, half) : s.slice(n - half);

        return part.length ? median(part) : NaN;
    }

    const h = method === 'exc' ? (n + 1) * p : (n - 1) * p + 1;

    if (method === 'exc' && (h < 1 || h > n)) {
        return NaN;
    }

    const lo = Math.floor(h);
    const frac = h - lo;

    if (lo >= n) {
        return s[n - 1];
    }

    return s[lo - 1] + frac * (s[lo] - s[lo - 1]);
}

/** Position text for the working: "h = (n − 1)p + 1 = 3.25". */
export function quantilePosition(n, p, method) {
    if (method === 'exc') {
        return `position = (n + 1)p = ${n + 1} × ${p} = ${round((n + 1) * p)}`;
    }

    if (method === 'nearest') {
        return `rank = ⌈np⌉ = ⌈${round(n * p)}⌉ = ${Math.max(1, Math.ceil(n * p))}`;
    }

    if (method === 'halves' || method === 'tukey') {
        return method === 'halves' ? 'Q1 and Q3 are the medians of the lower and upper halves (the median itself left out when n is odd)' : 'Hinges are the medians of each half, the median included in both when n is odd';
    }

    return `position = (n − 1)p + 1 = ${n - 1} × ${p} + 1 = ${round((n - 1) * p + 1)}`;
}

const round = (x) => Number(x.toPrecision(10));

/** Five-number summary and fences. */
export function fiveNumber(xs, method = 'inc') {
    const s = sorted(xs);
    const q1 = quantile(s, 0.25, method);
    const q3 = quantile(s, 0.75, method);

    return { s, min: s[0], q1, med: median(s), q3, max: s[s.length - 1], iqr: q3 - q1 };
}

/** Skewness: g1 (population moment), G1 (adjusted Fisher–Pearson, Excel SKEW, SAS, SPSS), b1 (Minitab). */
export function skewness(xs) {
    const n = xs.length;
    const m = mean(xs);
    const m2 = sum(xs.map((x) => (x - m) ** 2)) / n;
    const m3 = sum(xs.map((x) => (x - m) ** 3)) / n;
    const g1 = m3 / m2 ** 1.5;

    return { g1, G1: n > 2 ? (g1 * Math.sqrt(n * (n - 1))) / (n - 2) : NaN, b1: g1 * ((n - 1) / n) ** 1.5, se: n > 3 ? Math.sqrt((6 * n * (n - 1)) / ((n - 2) * (n + 1) * (n + 3))) : NaN };
}

/** Excess kurtosis: g2 (population), G2 (Excel KURT, SAS, SPSS), b2 (Minitab). */
export function kurtosis(xs) {
    const n = xs.length;
    const m = mean(xs);
    const m2 = sum(xs.map((x) => (x - m) ** 2)) / n;
    const m4 = sum(xs.map((x) => (x - m) ** 4)) / n;
    const g2 = m4 / (m2 * m2) - 3;
    const G2 = n > 3 ? ((n - 1) / ((n - 2) * (n - 3))) * ((n + 1) * g2 + 6) : NaN;
    const se = skewness(xs).se;

    return { g2, G2, b2: (g2 + 3) * ((n - 1) / n) ** 2 - 3, se: n > 3 ? 2 * se * Math.sqrt((n * n - 1) / ((n - 3) * (n + 5))) : NaN };
}

/** Average ranks (ties share the mean of their positions), with the tie groups for corrections. */
export function ranks(xs) {
    const order = xs.map((x, i) => [x, i]).sort((a, b) => a[0] - b[0]);
    const r = new Array(xs.length);
    const ties = [];
    let i = 0;

    while (i < order.length) {
        let j = i;

        while (j + 1 < order.length && order[j + 1][0] === order[i][0]) {
            j += 1;
        }

        const avg = (i + j) / 2 + 1;

        for (let k = i; k <= j; k += 1) {
            r[order[k][1]] = avg;
        }

        if (j > i) {
            ties.push(j - i + 1);
        }

        i = j + 1;
    }

    return { r, ties };
}

/** Pearson correlation of two equal-length arrays. */
export function pearson(x, y) {
    const mx = mean(x);
    const my = mean(y);
    const sxy = sum(x.map((v, i) => (v - mx) * (y[i] - my)));

    return sxy / Math.sqrt(ss(x, mx) * ss(y, my));
}

/** Items of a category list: split on commas, semicolons or new lines when present, otherwise on spaces. */
export function splitItems(text) {
    const raw = String(text ?? '').trim();

    return (/[,;\n\t]/.test(raw) ? raw.split(/[,;\n\t]+/) : raw.split(/\s+/)).map((t) => t.trim()).filter(Boolean);
}

/** Compact list text: up to `max` values, then "… (n values)". */
export function listText(xs, fmt, max = 40) {
    const shown = xs.slice(0, max).map(fmt).join(', ');

    return xs.length > max ? `${shown}, … (${xs.length} values)` : shown;
}

/** A "Check: …" message for unreadable tokens. */
export const badTokens = (bad) => `These are not numbers: ${bad.slice(0, 5).join(', ')}${bad.length > 5 ? ' …' : ''}. Separate values with commas, spaces or new lines.`;

/**
 * Reads a data box for a tool: returns { xs } or { problem } (empty or unreadable).
 */
export function readData(text, min = 1) {
    const { values, bad } = parseNumbers(text);

    if (bad.length) {
        return { error: badTokens(bad) };
    }

    if (values.length < min) {
        return { empty: min === 1 ? 'Enter your data.' : `Enter at least ${min} values.` };
    }

    return { xs: values };
}
