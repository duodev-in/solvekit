import { defineTools } from '../engines/formula.js';
import { evalReal, parse, variables } from '../math/expr.js';
import * as Q from '../math/rational.js';
import { handlersFor } from '../physics/core.js';
import { N, SEL, TXT, LINE, num, pct } from '../statistics/common.js';
import { QUANTILE_METHODS, splitItems, fiveNumber, kurtosis, mean, median, modes, parseNumbers, parsePairs, parseRows, pearson, quantile, quantilePosition, ranks, readData, sd, skewness, sorted, ss, sum, variance } from '../statistics/data.js';
import { normCdf } from '../statistics/special.js';
import { correlationTest, grubbs, kendall } from '../statistics/tests.js';
import { curve, ols } from '../statistics/reg.js';

/**
 * Descriptive statistics: averages, spread, position, shape, association and ordering. Where textbooks differ
 * (quartile methods, sample vs population) the page offers the choice and names it in the working.
 */

const DATA = (value = '12, 15, 11, 18, 14, 16, 13, 20, 15, 17') => TXT('Data (separate with commas, spaces or new lines)', value);
const PAIRS = (value = '1, 2.1\n2, 3.9\n3, 6.2\n4, 7.8\n5, 9.9\n6, 12.3\n7, 13.8\n8, 16.1') => TXT('x, y pairs (one per line)', value);
const METHOD = SEL('Quartile method', QUANTILE_METHODS, 'inc');
const KIND = SEL('Data are a', { sample: 'Sample (divide by n − 1)', population: 'Population (divide by N)' }, 'sample');

/** Reads data or returns the problem outcome. */
function data(text, min = 1) {
    return readData(text, min);
}

/** Pairs with at least `min` points or a problem outcome. */
function pairs(text, min = 3) {
    const p = parsePairs(text);

    if (p.problem) {
        return { error: p.problem };
    }

    if (p.x.length < min) {
        return { empty: `Enter at least ${min} pairs.` };
    }

    return p;
}

/** A table of deviations from c for the working grid (first 200 rows). */
const deviationGrid = (xs, c, square = true) => ({ columns: square ? ['x − mean', '(x − mean)²'] : ['|x − centre|'], rows: xs.slice(0, 200).map((v) => ({ header: num(v, 8), cells: square ? [num(v - c, 8), num((v - c) ** 2, 8)] : [num(Math.abs(v - c), 8)] })) });

/** Grubbs and IQR outliers shared helper. */
function fences(xs, method, k = 1.5) {
    const f = fiveNumber(xs, method);

    return { ...f, lo: f.q1 - k * f.iqr, hi: f.q3 + k * f.iqr };
}

/** Text list that keeps the user's own number text (for ordering). */
function orderTokens(text) {
    const raw = String(text ?? '').trim();
    const parts = (/[,;\n]/.test(raw) ? raw.split(/[,;\n]+/) : raw.split(/\s+/)).map((t) => t.trim()).filter(Boolean);

    return parts.map((t) => ({ text: t, q: Q.parseNumber(t, { percent: true }) }));
}

const corrText = (r) => {
    const a = Math.abs(r);

    return `${a < 0.1 ? 'Negligible' : a < 0.3 ? 'Weak' : a < 0.5 ? 'Moderate' : a < 0.7 ? 'Strong' : 'Very strong'} ${r > 0 ? 'positive' : r < 0 ? 'negative' : ''}`.trim();
};

export const TOOLS = {
    five_number: {
        type: 'calc',
        inputs: { data: DATA('3, 7, 8, 5, 12, 14, 21, 13, 18'), method: METHOD },
        label: 'Five-number summary',
        rows: { min: 'Minimum', q1: 'First quartile Q1', med: 'Median', q3: 'Third quartile Q3', max: 'Maximum', iqr: 'IQR' },
        plots: [['box', 'Box plot']],
        run: (x) => {
            const r = data(x.data, 2);

            if (!r.xs) {
                return r;
            }

            const f = fiveNumber(r.xs, x.method);

            if (!Number.isFinite(f.q1)) {
                return { error: 'Too few values for this quartile method.' };
            }

            return { value: [f.min, f.q1, f.med, f.q3, f.max].map((v) => num(v, 6)).join(', '), sub: `n = ${f.s.length}, ${QUANTILE_METHODS[x.method]}`, rows: { min: num(f.min, 8), q1: num(f.q1, 8), med: num(f.med, 8), q3: num(f.q3, 8), max: num(f.max, 8), iqr: num(f.iqr, 8) }, steps: [`Sorted: ${f.s.slice(0, 60).map((v) => num(v)).join(', ')}${f.s.length > 60 ? ' …' : ''}`, quantilePosition(f.s.length, 0.25, x.method), 'Median = middle value (average of the two middle values when n is even)'], plots: { box: { kind: 'box', boxes: [{ lo: f.min, q1: f.q1, med: f.med, q3: f.q3, hi: f.max, mean: mean(r.xs) }] } } };
        },
    },
    avg_rating: {
        type: 'calc',
        inputs: { s5: N('5-star ratings', 120, 0), s4: N('4-star ratings', 45, 0), s3: N('3-star ratings', 20, 0), s2: N('2-star ratings', 8, 0), s1: N('1-star ratings', 12, 0), target: N('Target average (optional)', 4.5, 1) },
        optional: ['target'],
        label: 'Average rating',
        rows: { total: 'Ratings', share5: 'Share of 5-star', need: '5-star ratings needed for the target' },
        plots: [['bars', 'Ratings by stars']],
        run: (x) => {
            const counts = [x.s1, x.s2, x.s3, x.s4, x.s5];

            if (counts.some((c) => !(c >= 0))) {
                return { error: 'Counts must be zero or more.' };
            }

            const n = sum(counts);

            if (!n) {
                return { empty: 'Enter how many ratings of each kind.' };
            }

            const total = sum(counts.map((c, i) => c * (i + 1)));
            const avg = total / n;
            let need = 'Enter a target';

            if (Number.isFinite(x.target)) {
                need = x.target >= 5 ? 'A perfect 5.0 needs every rating to be 5 stars' : avg >= x.target ? 'Already reached' : num(Math.ceil((x.target * n - total) / (5 - x.target) - 1e-9));
            }

            return { value: num(avg, 4), sub: `${'★'.repeat(Math.round(avg))}${'☆'.repeat(5 - Math.round(avg))} from ${num(n)} ratings`, rows: { total: num(n), share5: pct(x.s5 / n, 4), need }, steps: ['Average = Σ(stars × count) ÷ number of ratings', `= (5×${num(x.s5)} + 4×${num(x.s4)} + 3×${num(x.s3)} + 2×${num(x.s2)} + 1×${num(x.s1)}) ÷ ${num(n)}`, `= ${num(total)} ÷ ${num(n)} = ${num(avg, 8)}`, 'k more 5-star ratings reach target T when (sum + 5k) ÷ (n + k) ≥ T'], plots: { bars: { bars: counts.map((c, i) => ({ x: i + 1, y: c, label: num(c) })), xLabel: 'Stars', yLabel: 'Ratings', yMin: 0 } } };
        },
    },
    cv: {
        type: 'calc',
        inputs: { mode: SEL('From', { data: 'Data', summary: 'Mean and standard deviation' }, 'data'), data: DATA(), mean: N('Mean', 50), sd: N('Standard deviation', 5, 0) },
        show: { data: 'mode:data', mean: 'mode:summary', sd: 'mode:summary' },
        when: { mean: (x) => x.mode === 'summary', sd: (x) => x.mode === 'summary' },
        label: 'Coefficient of variation',
        rows: { sample: 'Using the sample SD', pop: 'Using the population SD', mean: 'Mean' },
        run: (x) => {
            let m = x.mean;
            let s = x.sd;
            let sp = NaN;

            if (x.mode === 'data') {
                const r = data(x.data, 2);

                if (!r.xs) {
                    return r;
                }

                m = mean(r.xs);
                s = sd(r.xs);
                sp = sd(r.xs, false);
            }

            if (m === 0) {
                return { error: 'The mean is zero, so the CV is undefined.' };
            }

            const cv = s / Math.abs(m);

            return { value: pct(cv, 5), sub: `SD is ${pct(cv, 4)} of the mean`, rows: { sample: pct(cv, 6), pop: Number.isFinite(sp) ? pct(sp / Math.abs(m), 6) : 'Needs the data', mean: num(m, 8) }, steps: ['CV = s ÷ |x̄| × 100%', `= ${num(s, 8)} ÷ ${num(Math.abs(m), 8)} × 100% = ${num(cv * 100, 8)}%`, 'Only meaningful for data on a ratio scale (a true zero), such as weights or times'] };
        },
    },
    cohens_d: {
        type: 'calc',
        inputs: { m1: N('Mean of group 1', 24.5), s1: N('SD of group 1', 4.2, 0), n1: N('Size of group 1', 30, 2), m2: N('Mean of group 2', 21.3), s2: N('SD of group 2', 3.9, 0), n2: N('Size of group 2', 30, 2) },
        label: 'Cohen’s d',
        rows: { g: 'Hedges’ g', ci: '95% CI for d', sp: 'Pooled SD', size: 'Size' },
        run: (x) => {
            const sp = Math.sqrt(((x.n1 - 1) * x.s1 ** 2 + (x.n2 - 1) * x.s2 ** 2) / (x.n1 + x.n2 - 2));

            if (!(sp > 0)) {
                return { error: 'The pooled SD must be positive.' };
            }

            const d = (x.m1 - x.m2) / sp;
            const J = 1 - 3 / (4 * (x.n1 + x.n2) - 9);
            const se = Math.sqrt((x.n1 + x.n2) / (x.n1 * x.n2) + (d * d) / (2 * (x.n1 + x.n2)));
            const a = Math.abs(d);

            return { value: num(d, 5), sub: `${a < 0.2 ? 'Negligible' : a < 0.5 ? 'Small' : a < 0.8 ? 'Medium' : 'Large'} effect`, rows: { g: num(d * J, 5), ci: `${num(d - 1.959964 * se, 5)} to ${num(d + 1.959964 * se, 5)}`, sp: num(sp, 6), size: '0.2 small, 0.5 medium, 0.8 large (Cohen 1988)' }, steps: ['s_pooled = √(((n₁ − 1)s₁² + (n₂ − 1)s₂²) ÷ (n₁ + n₂ − 2))', `= ${num(sp, 8)}`, `d = (x̄₁ − x̄₂) ÷ s_pooled = (${num(x.m1)} − ${num(x.m2)}) ÷ ${num(sp, 6)} = ${num(d, 8)}`, `Hedges’ g = d × (1 − 3 ÷ (4(n₁ + n₂) − 9)) = ${num(d * J, 8)}`] };
        },
    },
    proportionality: {
        type: 'calc',
        inputs: { data: PAIRS('2, 7\n4, 14\n6, 21\n10, 35') },
        label: 'Constant of proportionality k',
        rows: { equation: 'Equation', proportional: 'Proportional?', ratios: 'Each y ÷ x' },
        plots: [['line', 'y against x']],
        run: (x) => {
            const p = pairs(x.data, 1);

            if (!p.x) {
                return p;
            }

            if (p.x.some((v) => v === 0)) {
                return { error: 'x cannot be zero (k = y ÷ x).' };
            }

            const ks = p.y.map((v, i) => v / p.x[i]);
            const k = ks[0];
            const same = ks.every((v) => Math.abs(v - k) <= 1e-9 * Math.max(1, Math.abs(k)));
            const fit = p.x.length > 1 ? sum(p.x.map((v, i) => v * p.y[i])) / sum(p.x.map((v) => v * v)) : k;

            return { value: num(same ? k : fit, 8), sub: same ? `y = ${num(k, 8)}x` : 'Not exactly proportional: best-fit k through the origin shown', rows: { equation: `y = ${num(same ? k : fit, 8)}x`, proportional: same ? 'Yes: every y ÷ x is the same' : 'No: the ratios differ', ratios: ks.map((v) => num(v, 6)).join(', ') }, steps: ['k = y ÷ x for each pair; the relationship is proportional when every ratio is equal and the line passes through the origin', ...(same ? [] : [`Best fit through the origin: k = Σxy ÷ Σx² = ${num(fit, 8)}`])], plots: { line: { scatter: p.x.map((v, i) => [v, p.y[i]]), series: curve((v) => (same ? k : fit) * v, [0, ...p.x]), xLabel: 'x', yLabel: 'y', axes: true } } };
        },
    },
    correlation: {
        type: 'calc',
        inputs: { data: PAIRS(), type: SEL('Coefficient', { pearson: 'Pearson r (linear)', spearman: 'Spearman ρ (ranks)', kendall: 'Kendall τ-b (ranks)' }, 'pearson') },
        label: 'Correlation coefficient',
        rows: { p: 'p-value (two-sided)', ci: '95% CI (Pearson)', r2: 'r²', strength: 'Strength' },
        plots: [['scatter', 'Scatter plot']],
        run: (x) => {
            const p = pairs(x.data, 3);

            if (!p.x) {
                return p;
            }

            let r;
            let pv;
            let method;

            if (x.type === 'kendall') {
                const k = kendall(p.x, p.y);
                [r, pv, method] = [k.tau, k.p, `τ-b from ${k.C} concordant and ${k.D} discordant pairs; ${k.exact ? 'exact p-value' : 'normal approximation with tie correction'}`];
            } else {
                const xs = x.type === 'spearman' ? ranks(p.x).r : p.x;
                const ys = x.type === 'spearman' ? ranks(p.y).r : p.y;
                r = pearson(xs, ys);
                pv = correlationTest(r, p.x.length).p;
                method = x.type === 'spearman' ? 'Spearman ρ = Pearson r of the ranks (ties share average ranks); p from the t approximation' : 'r = Σ(x − x̄)(y − ȳ) ÷ √(Σ(x − x̄)² Σ(y − ȳ)²); p from t = r√(n − 2)/√(1 − r²)';
            }

            if (!Number.isFinite(r)) {
                return { error: 'One variable does not vary, so the correlation is undefined.' };
            }

            const t = correlationTest(r, p.x.length);

            return { value: num(r, 6), sub: `${corrText(r)}, p = ${num(pv, 4)}`, rows: { p: num(pv, 6), ci: x.type === 'pearson' ? `${num(t.lo, 5)} to ${num(t.hi, 5)}` : 'Shown for Pearson only', r2: num(r * r, 6), strength: corrText(r) }, steps: [method, `n = ${p.x.length}`], plots: { scatter: { scatter: p.x.map((v, i) => [v, p.y[i]]), xLabel: 'x', yLabel: 'y' } } };
        },
    },
    mcc: {
        type: 'calc',
        inputs: { TP: N('True positives', 90, 0), FP: N('False positives', 10, 0), TN: N('True negatives', 85, 0), FN: N('False negatives', 15, 0) },
        label: 'Matthews correlation coefficient',
        rows: { chi: 'χ² = n × MCC²', f1: 'F1 score', acc: 'Accuracy', meaning: 'Meaning' },
        run: (x) => {
            const den = Math.sqrt((x.TP + x.FP) * (x.TP + x.FN) * (x.TN + x.FP) * (x.TN + x.FN));
            const n = x.TP + x.FP + x.TN + x.FN;

            if (!n) {
                return { empty: 'Enter the counts.' };
            }

            const mcc = den === 0 ? 0 : (x.TP * x.TN - x.FP * x.FN) / den;

            return { value: num(mcc, 6), sub: den === 0 ? 'A row or column is empty: MCC set to 0' : mcc > 0.5 ? 'Strong agreement' : mcc > 0 ? 'Some agreement' : 'No better than chance', rows: { chi: num(n * mcc * mcc, 6), f1: num((2 * x.TP) / (2 * x.TP + x.FP + x.FN), 6), acc: pct((x.TP + x.TN) / n, 5), meaning: '+1 perfect, 0 no better than random, −1 total disagreement' }, steps: ['MCC = (TP·TN − FP·FN) ÷ √((TP + FP)(TP + FN)(TN + FP)(TN + FN))', `= (${num(x.TP * x.TN)} − ${num(x.FP * x.FN)}) ÷ ${num(den, 8)} = ${num(mcc, 8)}`, 'Unlike accuracy and F1, MCC stays fair when the classes are unbalanced (Matthews 1975; Chicco & Jurman 2020)'] };
        },
    },
    covariance: {
        type: 'calc',
        inputs: { data: PAIRS() },
        label: 'Sample covariance',
        rows: { pop: 'Population covariance', r: 'Correlation r', means: 'Means x̄, ȳ' },
        run: (x) => {
            const p = pairs(x.data, 2);

            if (!p.x) {
                return p;
            }

            const mx = mean(p.x);
            const my = mean(p.y);
            const sxy = sum(p.x.map((v, i) => (v - mx) * (p.y[i] - my)));
            const n = p.x.length;

            return { value: num(sxy / (n - 1), 8), sub: sxy > 0 ? 'x and y tend to rise together' : sxy < 0 ? 'y tends to fall as x rises' : 'No linear co-movement', rows: { pop: num(sxy / n, 8), r: num(pearson(p.x, p.y), 6), means: `${num(mx, 8)}, ${num(my, 8)}` }, steps: ['cov(x, y) = Σ(x − x̄)(y − ȳ) ÷ (n − 1)', `Σ(x − x̄)(y − ȳ) = ${num(sxy, 10)}`, `÷ ${n - 1} = ${num(sxy / (n - 1), 10)}`, 'Covariance depends on the units; the correlation r rescales it to −1 … 1'] };
        },
    },
    decile: {
        type: 'calc',
        inputs: { data: DATA('2, 4, 5, 7, 8, 10, 11, 13, 14, 16, 17, 19, 20, 22, 25'), method: SEL('Method', { inc: QUANTILE_METHODS.inc, exc: QUANTILE_METHODS.exc, nearest: QUANTILE_METHODS.nearest }, 'inc') },
        label: 'Median (5th decile)',
        rows: { d1: 'D1 (10%)', d9: 'D9 (90%)', range: 'D9 − D1' },
        grids: [['table', 'All nine deciles']],
        run: (x) => {
            const r = data(x.data, 2);

            if (!r.xs) {
                return r;
            }

            const s = sorted(r.xs);
            const ds = Array.from({ length: 9 }, (_, j) => quantile(s, (j + 1) / 10, x.method));

            return { value: num(ds[4], 8), sub: `n = ${s.length}`, rows: { d1: Number.isFinite(ds[0]) ? num(ds[0], 8) : 'Not reachable with this n', d9: Number.isFinite(ds[8]) ? num(ds[8], 8) : 'Not reachable with this n', range: num(ds[8] - ds[0], 8) }, steps: [`Method: ${QUANTILE_METHODS[x.method]}`, quantilePosition(s.length, 0.1, x.method)], grids: { table: { columns: ['Value'], rows: ds.map((v, j) => ({ header: `D${j + 1} (${(j + 1) * 10}%)`, cells: [Number.isFinite(v) ? num(v, 8) : '—'] })) } } };
        },
    },
    descriptive: {
        type: 'calc',
        inputs: { data: DATA('4.1, 5.3, 6.2, 5.8, 7.4, 6.6, 5.1, 4.9, 6.8, 7.1, 5.5, 6.0') },
        label: 'Mean',
        rows: { n: 'Count n', median: 'Median', sd: 'Standard deviation (sample)', range: 'Minimum – maximum' },
        grids: [['table', 'Summary statistics']],
        plots: [['box', 'Box plot']],
        run: (x) => {
            const r = data(x.data, 2);

            if (!r.xs) {
                return r;
            }

            const xs = r.xs;
            const n = xs.length;
            const m = mean(xs);
            const f = fiveNumber(xs);
            const md = modes(xs);
            const sk = skewness(xs);
            const ku = kurtosis(xs);
            const rows = [['Count n', num(n)], ['Sum', num(sum(xs), 10)], ['Mean', num(m, 10)], ['Median', num(f.med, 10)], ['Mode', md.values.length ? md.values.map((v) => num(v)).join(', ') : 'None'], ['Standard deviation (sample)', num(sd(xs), 8)], ['Standard deviation (population)', num(sd(xs, false), 8)], ['Variance (sample)', num(variance(xs), 8)], ['Variance (population)', num(variance(xs, false), 8)], ['Standard error of the mean', num(sd(xs) / Math.sqrt(n), 8)], ['Minimum', num(f.min, 10)], ['Q1 (inclusive)', num(f.q1, 8)], ['Q3 (inclusive)', num(f.q3, 8)], ['Maximum', num(f.max, 10)], ['Range', num(f.max - f.min, 10)], ['IQR', num(f.iqr, 8)], ['Coefficient of variation', m !== 0 ? pct(sd(xs) / Math.abs(m), 5) : '—'], ['Skewness (G₁, Excel SKEW)', num(sk.G1, 6)], ['Excess kurtosis (G₂, Excel KURT)', num(ku.G2, 6)]];

            return { value: num(m, 10), sub: `n = ${n}`, rows: { n: num(n), median: num(f.med, 10), sd: num(sd(xs), 8), range: `${num(f.min, 8)} – ${num(f.max, 8)}` }, steps: ['Mean = Σx ÷ n; sample SD divides by n − 1, population SD by n', 'Quartiles here use the inclusive method (Excel QUARTILE.INC, R type 7)'], grids: { table: { columns: ['Value'], rows: rows.map(([h, v]) => ({ header: h, cells: [v] })) } }, plots: { box: { kind: 'box', boxes: [{ lo: f.min, q1: f.q1, med: f.med, q3: f.q3, hi: f.max, mean: m }] } } };
        },
    },
    dispersion: {
        type: 'calc',
        inputs: { data: DATA() },
        label: 'Standard deviation (sample)',
        rows: { range: 'Range', iqr: 'Interquartile range', variance: 'Variance (sample)', mad: 'Mean absolute deviation', medad: 'Median absolute deviation', cv: 'Coefficient of variation', iod: 'Index of dispersion (variance ÷ mean)' },
        run: (x) => {
            const r = data(x.data, 2);

            if (!r.xs) {
                return r;
            }

            const xs = r.xs;
            const m = mean(xs);
            const f = fiveNumber(xs);
            const med = median(xs);

            return { value: num(sd(xs), 8), sub: `n = ${xs.length}, mean ${num(m, 8)}`, rows: { range: num(f.max - f.min, 8), iqr: num(f.iqr, 8), variance: num(variance(xs), 8), mad: num(mean(xs.map((v) => Math.abs(v - m))), 8), medad: num(median(xs.map((v) => Math.abs(v - med))), 8), cv: m !== 0 ? pct(sd(xs) / Math.abs(m), 5) : 'Undefined (mean 0)', iod: m !== 0 ? num(variance(xs) / m, 6) : 'Undefined' }, steps: ['Range and IQR use only the extremes or quartiles; variance and SD use every value', 'The median absolute deviation resists outliers best', 'Index of dispersion near 1 fits a Poisson count; above 1 means over-dispersed'] };
        },
    },
    error_prop: {
        type: 'calc',
        inputs: { formula: LINE('Formula (use the variable names below)', 'm * g * h'), vars: TXT('Variables: name = value ± uncertainty (one per line)', 'm = 2.50 ± 0.02\ng = 9.81 ± 0.01\nh = 1.20 ± 0.05') },
        label: 'Result',
        rows: { u: 'Uncertainty (1σ)', rel: 'Relative uncertainty', largest: 'Largest contributor' },
        grids: [['table', 'Contribution of each variable']],
        run: (x) => {
            let tree;

            try {
                tree = parse(x.formula);
            } catch (e) {
                return { error: `The formula could not be read: ${e.message}` };
            }

            const vars = {};

            for (const [index, line] of String(x.vars ?? '').split(/\r?\n/).map((l) => l.trim()).filter(Boolean).entries()) {
                const m = line.replace(/\+\/-|\+-/g, '±').match(/^([A-Za-zα-ωΑ-Ω_][\w]*)\s*=\s*([-+\d.eE]+)\s*(?:±\s*([\d.eE+-]+))?$/);

                if (!m) {
                    return { error: `Line ${index + 1} should look like “x = 2.5 ± 0.1”.` };
                }

                vars[m[1]] = { v: Number(m[2]), u: Number(m[3] ?? 0) };
            }

            const names = [...variables(tree)];
            const missing = names.filter((n) => !(n in vars));

            if (missing.length) {
                return { error: `Give a value for ${missing.join(', ')}.` };
            }

            const values = Object.fromEntries(names.map((n) => [n, vars[n].v]));
            const f = (vals) => evalReal(tree, vals);
            const y = f(values);

            if (!Number.isFinite(y)) {
                return { error: 'The formula has no real value for these inputs.' };
            }

            const parts = names.map((n) => {
                const h = Math.max(Math.abs(values[n]) * 1e-5, 1e-8);
                const d1 = (f({ ...values, [n]: values[n] + h }) - f({ ...values, [n]: values[n] - h })) / (2 * h);
                const d2 = (f({ ...values, [n]: values[n] + h / 2 }) - f({ ...values, [n]: values[n] - h / 2 })) / h;
                const deriv = (4 * d2 - d1) / 3;

                return { n, deriv, c: deriv * vars[n].u };
            });
            const u = Math.sqrt(sum(parts.map((p) => p.c * p.c)));
            const top = parts.reduce((a, b) => (Math.abs(b.c) > Math.abs(a.c) ? b : a), parts[0] ?? { n: '—', c: 0 });

            return { value: `${num(y, 8)} ± ${num(u, 3)}`, sub: `Relative uncertainty ${pct(Math.abs(u / y), 3)}`, rows: { u: num(u, 6), rel: pct(Math.abs(u / y), 4), largest: parts.length ? `${top.n} (${pct((top.c * top.c) / (u * u || 1), 3)} of the variance)` : '—' }, steps: ['First-order propagation (GUM, JCGM 100:2008) for independent inputs:', 'u(f)² = Σ (∂f/∂xᵢ × u(xᵢ))²', ...parts.map((p) => `∂f/∂${p.n} = ${num(p.deriv, 6)}; contribution ${num(p.c, 6)}`), `u(f) = ${num(u, 8)}`, 'Partial derivatives are computed numerically; correlated inputs need covariance terms'], grids: { table: { columns: ['∂f/∂x', 'u(x)', 'Contribution', 'Share of variance'], rows: parts.map((p) => ({ header: p.n, cells: [num(p.deriv, 6), num(vars[p.n].u, 6), num(p.c, 6), pct((p.c * p.c) / (u * u || 1), 3)] })) } } };
        },
    },
    grouped_sd: {
        type: 'calc',
        inputs: { data: TXT('Classes: lower − upper, frequency (or midpoint, frequency)', '10-20, 5\n20-30, 12\n30-40, 18\n40-50, 9\n50-60, 6'), kind: KIND },
        label: 'Standard deviation',
        rows: { mean: 'Grouped mean', variance: 'Variance', n: 'Total frequency' },
        grids: [['table', 'Working table']],
        run: (x) => {
            const rows = [];

            for (const [index, line] of String(x.data ?? '').split(/\r?\n/).map((l) => l.trim()).filter(Boolean).entries()) {
                const m = line.replace(/[–—−]/g, '-').match(/^(-?[\d.]+)\s*(?:-\s*(-?[\d.]+))?\s*[,;\t ]\s*([\d.]+)$/);

                if (!m) {
                    return { error: `Line ${index + 1} should be “10-20, 5” or “15, 5”.` };
                }

                const mid = m[2] !== undefined ? (Number(m[1]) + Number(m[2])) / 2 : Number(m[1]);
                rows.push({ label: m[2] !== undefined ? `${m[1]}–${m[2]}` : m[1], mid, f: Number(m[3]) });
            }

            const n = sum(rows.map((r) => r.f));

            if (rows.length < 1 || n < 2) {
                return { empty: 'Enter classes with a total frequency of at least 2.' };
            }

            const m = sum(rows.map((r) => r.f * r.mid)) / n;
            const ssq = sum(rows.map((r) => r.f * (r.mid - m) ** 2));
            const v = ssq / (n - (x.kind === 'sample' ? 1 : 0));

            return { value: num(Math.sqrt(v), 8), sub: `${x.kind === 'sample' ? 'Sample' : 'Population'} SD from class midpoints`, rows: { mean: num(m, 8), variance: num(v, 8), n: num(n) }, steps: ['Each class is represented by its midpoint m', `Mean = Σfm ÷ Σf = ${num(sum(rows.map((r) => r.f * r.mid)), 10)} ÷ ${num(n)} = ${num(m, 8)}`, `Σf(m − mean)² = ${num(ssq, 10)}`, `Variance = ${num(ssq, 8)} ÷ ${x.kind === 'sample' ? `(${num(n)} − 1)` : num(n)} = ${num(v, 8)}`, 'Grouping loses detail, so this estimates the SD of the raw data'], grids: { table: { columns: ['Midpoint m', 'f', 'f × m', 'f(m − mean)²'], rows: rows.map((r) => ({ header: r.label, cells: [num(r.mid, 6), num(r.f), num(r.f * r.mid, 8), num(r.f * (r.mid - m) ** 2, 8)] })) } } };
        },
    },
    iqv: {
        type: 'calc',
        inputs: { data: TXT('Counts in each category', '40, 25, 20, 15') },
        label: 'Index of qualitative variation',
        rows: { k: 'Categories K', diversity: 'Gini–Simpson 1 − Σp²', shares: 'Shares' },
        run: (x) => {
            const { values } = parseNumbers(x.data);

            if (values.length < 2 || values.some((v) => v < 0)) {
                return { error: 'Enter at least two category counts (zero or more).' };
            }

            const n = sum(values);
            const p = values.map((v) => v / n);
            const gs = 1 - sum(p.map((v) => v * v));
            const k = values.length;
            const iqv = (k * gs) / (k - 1);

            return { value: num(iqv, 6), sub: iqv > 0.9 ? 'Spread almost evenly over the categories' : iqv < 0.3 ? 'Concentrated in few categories' : 'Moderately spread', rows: { k: String(k), diversity: num(gs, 6), shares: p.map((v) => pct(v, 3)).join(', ') }, steps: ['IQV = K(1 − Σpᵢ²) ÷ (K − 1)', `Σpᵢ² = ${num(1 - gs, 8)}`, `IQV = ${k} × ${num(gs, 8)} ÷ ${k - 1} = ${num(iqv, 8)}`, '0 = everything in one category, 1 = spread evenly over all K'] };
        },
    },
    iqr: {
        type: 'calc',
        inputs: { data: DATA('3, 7, 8, 5, 12, 14, 21, 13, 18'), method: METHOD },
        label: 'Interquartile range',
        rows: { q1: 'Q1', q3: 'Q3', fences: 'Outlier fences (1.5 × IQR)' },
        run: (x) => {
            const r = data(x.data, 2);

            if (!r.xs) {
                return r;
            }

            const f = fiveNumber(r.xs, x.method);

            if (!Number.isFinite(f.iqr)) {
                return { error: 'Too few values for this quartile method.' };
            }

            return { value: num(f.iqr, 8), sub: `Middle 50% spans ${num(f.q1, 6)} to ${num(f.q3, 6)}`, rows: { q1: num(f.q1, 8), q3: num(f.q3, 8), fences: `${num(f.q1 - 1.5 * f.iqr, 8)} and ${num(f.q3 + 1.5 * f.iqr, 8)}` }, steps: [`Sorted: ${f.s.slice(0, 60).map((v) => num(v)).join(', ')}`, `Method: ${QUANTILE_METHODS[x.method]}`, quantilePosition(f.s.length, 0.25, x.method), `IQR = Q3 − Q1 = ${num(f.q3, 8)} − ${num(f.q1, 8)} = ${num(f.iqr, 8)}`] };
        },
    },
    least_greatest: {
        type: 'calc',
        inputs: { data: TXT('Numbers (decimals, fractions like 3/4, mixed numbers like 1 1/2, percentages)', '0.5, 3/4, -2, 1 1/2, 0.45, 12%, 2/3'), order: SEL('Order', { asc: 'Least to greatest (ascending)', desc: 'Greatest to least (descending)' }, 'asc'), dupes: SEL('Repeated values', { keep: 'Keep', drop: 'Remove' }, 'keep') },
        label: 'Ordered list',
        rows: { count: 'Values', smallest: 'Smallest', largest: 'Largest' },
        run: (x) => {
            const items = orderTokens(x.data);

            if (!items.length) {
                return { empty: 'Enter some numbers.' };
            }

            const bad = items.filter((i) => !i.q);

            if (bad.length) {
                return { error: `These are not numbers: ${bad.slice(0, 5).map((b) => b.text).join(', ')}. Separate values with commas when using mixed numbers.` };
            }

            let list = [...items].sort((a, b) => Q.cmp(a.q, b.q));

            if (x.dupes === 'drop') {
                list = list.filter((item, i) => i === 0 || !Q.eq(item.q, list[i - 1].q));
            }

            if (x.order === 'desc') {
                list.reverse();
            }

            const sep = x.order === 'asc' ? ' < ' : ' > ';
            const text = list.map((i, k) => (k && Q.eq(i.q, list[k - 1].q) ? ` = ${i.text}` : `${k ? sep : ''}${i.text}`)).join('');

            return { value: list.map((i) => i.text).join(', '), sub: text, rows: { count: num(list.length), smallest: items.reduce((a, b) => (Q.cmp(b.q, a.q) < 0 ? b : a)).text, largest: items.reduce((a, b) => (Q.cmp(b.q, a.q) > 0 ? b : a)).text }, steps: ['Each value is read exactly (fractions and decimals as exact ratios), then compared', ...list.slice(0, 40).map((i) => `${i.text} = ${Q.toDecimal(i.q, 6)}`)] };
        },
    },
    mad_mean: {
        type: 'calc',
        inputs: { data: DATA('2, 4, 6, 8, 10, 12, 30'), about: SEL('Deviations from the', { mean: 'Mean', median: 'Median' }, 'mean') },
        label: 'Mean absolute deviation',
        rows: { centre: 'Centre used', sd: 'Standard deviation (population)', ratio: 'MAD ÷ SD' },
        grids: [['table', 'Absolute deviations']],
        run: (x) => {
            const r = data(x.data, 2);

            if (!r.xs) {
                return r;
            }

            const c = x.about === 'mean' ? mean(r.xs) : median(r.xs);
            const mad = mean(r.xs.map((v) => Math.abs(v - c)));

            return { value: num(mad, 8), sub: `Average distance from the ${x.about}`, rows: { centre: `${x.about} = ${num(c, 8)}`, sd: num(sd(r.xs, false), 8), ratio: num(mad / sd(r.xs, false), 5) }, steps: [`MAD = Σ|x − ${x.about === 'mean' ? 'x̄' : 'median'}| ÷ n`, `= ${num(sum(r.xs.map((v) => Math.abs(v - c))), 10)} ÷ ${r.xs.length} = ${num(mad, 10)}`, 'For normal data MAD ≈ 0.80 × SD'], grids: { table: deviationGrid(r.xs, c, false) } };
        },
    },
    mean_median_mode: {
        type: 'calc',
        inputs: { data: DATA('4, 8, 6, 5, 3, 8, 9, 5, 8, 7') },
        label: 'Mean',
        rows: { median: 'Median', mode: 'Mode', range: 'Range', sorted: 'Sorted data' },
        run: (x) => {
            const r = data(x.data);

            if (!r.xs) {
                return r;
            }

            const s = sorted(r.xs);
            const m = modes(r.xs);
            const n = s.length;

            return { value: num(mean(r.xs), 10), sub: `Median ${num(median(r.xs), 10)}, mode ${m.values.length ? m.values.map((v) => num(v)).join(', ') : 'none'}`, rows: { median: num(median(r.xs), 10), mode: m.values.length ? `${m.values.map((v) => num(v)).join(', ')} (${m.count} times)` : 'No mode (every value appears once)', range: num(s[n - 1] - s[0], 10), sorted: s.slice(0, 80).map((v) => num(v)).join(', ') + (n > 80 ? ' …' : '') }, steps: [`Mean = Σx ÷ n = ${num(sum(r.xs), 10)} ÷ ${n} = ${num(mean(r.xs), 10)}`, n % 2 ? `Median = the ${(n + 1) / 2}th sorted value = ${num(s[(n - 1) / 2])}` : `Median = average of the ${n / 2}th and ${n / 2 + 1}th sorted values = (${num(s[n / 2 - 1])} + ${num(s[n / 2])}) ÷ 2`, 'Mode = the most frequent value(s)'] };
        },
    },
    median: {
        type: 'calc',
        inputs: { data: DATA('7, 1, 9, 4, 3, 8') },
        label: 'Median',
        rows: { n: 'Values', sorted: 'Sorted data', position: 'Position' },
        run: (x) => {
            const r = data(x.data);

            if (!r.xs) {
                return r;
            }

            const s = sorted(r.xs);
            const n = s.length;

            return { value: num(median(s), 10), sub: n % 2 ? 'the middle value' : 'average of the two middle values', rows: { n: num(n), sorted: s.slice(0, 80).map((v, i) => (i === Math.floor((n - 1) / 2) || (n % 2 === 0 && i === n / 2) ? `[${num(v)}]` : num(v))).join(', ') + (n > 80 ? ' …' : ''), position: n % 2 ? `${(n + 1) / 2}th` : `${n / 2}th and ${n / 2 + 1}th` }, steps: ['Sort the data', n % 2 ? `n = ${n} is odd: the median is the ${(n + 1) / 2}th value` : `n = ${n} is even: average the ${n / 2}th and ${n / 2 + 1}th values`, `Median = ${num(median(s), 10)}`] };
        },
    },
    mad_median: {
        type: 'calc',
        inputs: { data: DATA('2, 3, 3, 4, 5, 6, 40'), scale: SEL('Scale', { raw: 'Raw MAD', normal: 'Scaled × 1.4826 (estimates σ for normal data)' }, 'raw') },
        label: 'Median absolute deviation',
        rows: { median: 'Median', scaled: 'Scaled MAD (× 1.4826)', sd: 'Standard deviation for comparison' },
        run: (x) => {
            const r = data(x.data, 2);

            if (!r.xs) {
                return r;
            }

            const med = median(r.xs);
            const devs = r.xs.map((v) => Math.abs(v - med));
            const mad = median(devs);
            const value = x.scale === 'normal' ? 1.482602218505602 * mad : mad;

            return { value: num(value, 8), sub: x.scale === 'normal' ? 'Robust estimate of σ' : 'Median distance from the median', rows: { median: num(med, 8), scaled: num(1.482602218505602 * mad, 8), sd: num(sd(r.xs), 8) }, steps: [`Median = ${num(med, 8)}`, `|x − median| = ${sorted(devs).slice(0, 40).map((v) => num(v)).join(', ')}`, `MAD = median of these = ${num(mad, 8)}`, '1.4826 = 1/Φ⁻¹(3/4) makes the MAD match σ for normal data; unlike the SD it ignores outliers'] };
        },
    },
    midrange: {
        type: 'calc',
        inputs: { data: DATA('12, 5, 19, 8, 3, 15') },
        label: 'Midrange',
        rows: { min: 'Minimum', max: 'Maximum', mean: 'Mean for comparison' },
        run: (x) => {
            const r = data(x.data);

            if (!r.xs) {
                return r;
            }

            const lo = Math.min(...r.xs);
            const hi = Math.max(...r.xs);

            return { value: num((lo + hi) / 2, 10), sub: 'Halfway between the smallest and largest values', rows: { min: num(lo, 10), max: num(hi, 10), mean: num(mean(r.xs), 10) }, steps: ['Midrange = (minimum + maximum) ÷ 2', `= (${num(lo)} + ${num(hi)}) ÷ 2 = ${num((lo + hi) / 2, 10)}`, 'Uses only two values, so a single outlier moves it'] };
        },
    },
    minmax: {
        type: 'calc',
        inputs: { data: DATA('14, -3, 27, 8, 27, 0.5, 11') },
        label: 'Minimum and maximum',
        rows: { min: 'Minimum', max: 'Maximum', range: 'Range', where: 'Positions (1 = first)' },
        run: (x) => {
            const r = data(x.data);

            if (!r.xs) {
                return r;
            }

            const lo = Math.min(...r.xs);
            const hi = Math.max(...r.xs);
            const at = (v) => r.xs.map((u, i) => (u === v ? i + 1 : 0)).filter(Boolean).join(', ');

            return { value: `${num(lo, 10)} and ${num(hi, 10)}`, sub: `${r.xs.length} values`, rows: { min: num(lo, 10), max: num(hi, 10), range: num(hi - lo, 10), where: `min at ${at(lo)}; max at ${at(hi)}` }, steps: ['Scan every value, keeping the smallest and largest seen', `Range = ${num(hi)} − ${num(lo)} = ${num(hi - lo, 10)}`] };
        },
    },
    mode: {
        type: 'calc',
        inputs: { data: TXT('Data (numbers or words)', '3, 7, 7, 2, 9, 7, 3, 3, 5') },
        label: 'Mode',
        rows: { count: 'Occurs', kind: 'Type' },
        grids: [['table', 'Frequency of each value']],
        run: (x) => {
            const items = splitItems(x.data);

            if (!items.length) {
                return { empty: 'Enter your data.' };
            }

            const numeric = items.every((t) => Number.isFinite(Number(t)));
            const values = numeric ? items.map(Number) : items;
            const m = modes(values);
            const keys = [...m.counts.entries()].sort((a, b) => b[1] - a[1] || (numeric ? a[0] - b[0] : 0));

            return { value: m.values.length ? m.values.map(String).join(', ') : 'No mode', sub: m.values.length ? `appears ${m.count} times` : 'every value appears once', rows: { count: m.values.length ? `${m.count} of ${items.length}` : '1 each', kind: m.values.length === 0 ? 'No mode' : m.values.length === 1 ? 'Unimodal' : m.values.length === 2 ? 'Bimodal' : 'Multimodal' }, steps: ['Count how often each value occurs; the mode is the most frequent', 'Data can have several modes, or none when all counts are equal'], grids: { table: { columns: ['Count'], rows: keys.slice(0, 200).map(([k, c]) => ({ header: String(k), cells: [num(c)], highlight: c === m.count && m.values.length > 0 })) } } };
        },
    },
    mse: {
        type: 'calc',
        inputs: { observed: TXT('Observed (actual) values', '3, -0.5, 2, 7, 4.2'), predicted: TXT('Predicted values (same order)', '2.5, 0.0, 2, 8, 4.0') },
        label: 'Mean squared error',
        rows: { rmse: 'RMSE', mae: 'MAE', mape: 'MAPE', n: 'Pairs' },
        grids: [['table', 'Errors']],
        run: (x) => {
            const a = parseNumbers(x.observed).values;
            const p = parseNumbers(x.predicted).values;

            if (!a.length || a.length !== p.length) {
                return { error: 'Enter the same number of observed and predicted values.' };
            }

            const e = a.map((v, i) => v - p[i]);
            const mse = mean(e.map((v) => v * v));
            const mapeOk = a.every((v) => v !== 0);

            return { value: num(mse, 8), sub: `RMSE ${num(Math.sqrt(mse), 8)}`, rows: { rmse: num(Math.sqrt(mse), 8), mae: num(mean(e.map(Math.abs)), 8), mape: mapeOk ? pct(mean(e.map((v, i) => Math.abs(v / a[i]))), 5) : 'Undefined (an observed value is 0)', n: num(a.length) }, steps: ['MSE = Σ(y − ŷ)² ÷ n', `= ${num(sum(e.map((v) => v * v)), 10)} ÷ ${a.length} = ${num(mse, 10)}`, 'RMSE = √MSE is in the same units as the data; MAE weights all errors equally'], grids: { table: { columns: ['Predicted', 'Error', 'Squared'], rows: a.slice(0, 200).map((v, i) => ({ header: num(v, 8), cells: [num(p[i], 8), num(e[i], 8), num(e[i] ** 2, 8)] })) } } };
        },
    },
    outlier: {
        type: 'calc',
        inputs: { data: DATA('12, 14, 15, 15, 16, 17, 18, 19, 21, 45'), method: SEL('Method', { iqr: 'Tukey fences (1.5 × IQR)', z: 'z-score (|z| > 3)', grubbs: 'Grubbs’ test (α = 0.05)' }, 'iqr') },
        label: 'Outliers',
        rows: { limits: 'Limits', count: 'Outliers found', note: 'Note' },
        plots: [['box', 'Box plot']],
        run: (x) => {
            const r = data(x.data, 3);

            if (!r.xs) {
                return r;
            }

            const f = fences(r.xs, 'inc');
            let out;
            let limits;
            let note;

            if (x.method === 'iqr') {
                out = r.xs.filter((v) => v < f.lo || v > f.hi);
                limits = `${num(f.lo, 8)} to ${num(f.hi, 8)}`;
                note = 'Fences at Q1 − 1.5 IQR and Q3 + 1.5 IQR (Tukey 1977)';
            } else if (x.method === 'z') {
                const m = mean(r.xs);
                const s = sd(r.xs);
                out = r.xs.filter((v) => Math.abs((v - m) / s) > 3);
                limits = `${num(m - 3 * s, 8)} to ${num(m + 3 * s, 8)}`;
                note = 'The outlier itself inflates the SD, so small samples rarely reach |z| > 3';
            } else {
                if (r.xs.length < 3) {
                    return { error: 'Grubbs’ test needs at least 3 values.' };
                }

                const g = grubbs(r.xs, 0.05);
                out = g.outlier ? [g.suspect] : [];
                limits = `G = ${num(g.G, 5)} vs critical ${num(g.crit, 5)} (p ≤ ${num(g.p, 3)})`;
                note = 'Tests one value at a time and assumes the rest are normal';
            }

            const inside = f.s.filter((v) => v >= f.lo && v <= f.hi);

            return { value: out.length ? out.map((v) => num(v)).join(', ') : 'None', sub: `${x.method === 'iqr' ? 'Tukey fences' : x.method === 'z' ? 'z-scores' : 'Grubbs’ test'}`, rows: { limits, count: num(out.length), note }, steps: [`Q1 = ${num(f.q1, 8)}, Q3 = ${num(f.q3, 8)}, IQR = ${num(f.iqr, 8)}`, note, 'Check outliers before removing them: they may be real'], plots: { box: { kind: 'box', boxes: [{ lo: inside[0], q1: f.q1, med: f.med, q3: f.q3, hi: inside[inside.length - 1], outliers: f.s.filter((v) => v < f.lo || v > f.hi), mean: mean(r.xs) }] } } };
        },
    },
    pearson: {
        type: 'calc',
        inputs: { data: PAIRS() },
        label: 'Pearson r',
        rows: { r2: 'r²', t: 't (n − 2 df)', p: 'p-value (two-sided)', ci: '95% confidence interval' },
        plots: [['scatter', 'Scatter plot with least-squares line']],
        run: (x) => {
            const p = pairs(x.data, 3);

            if (!p.x) {
                return p;
            }

            const r = pearson(p.x, p.y);

            if (!Number.isFinite(r)) {
                return { error: 'One variable does not vary, so r is undefined.' };
            }

            const t = correlationTest(r, p.x.length);
            const fit = ols(p.x.map((v) => [1, v]), p.y);

            return { value: num(r, 6), sub: corrText(r), rows: { r2: num(r * r, 6), t: `${num(t.t, 6)} (${t.df} df)`, p: num(t.p, 6), ci: p.x.length > 3 ? `${num(t.lo, 5)} to ${num(t.hi, 5)}` : 'Needs 4 or more pairs' }, steps: ['r = Σ(x − x̄)(y − ȳ) ÷ √(Σ(x − x̄)² Σ(y − ȳ)²)', `t = r√(n − 2) ÷ √(1 − r²) = ${num(t.t, 6)}`, 'CI by Fisher’s z = atanh(r) with SE 1/√(n − 3)'], plots: { scatter: { scatter: p.x.map((v, i) => [v, p.y[i]]), series: fit.beta ? curve((v) => fit.beta[0] + fit.beta[1] * v, p.x) : [], xLabel: 'x', yLabel: 'y' } } };
        },
    },
    percentile: {
        type: 'calc',
        inputs: { data: DATA('15, 20, 35, 40, 50, 55, 60, 70, 80, 95'), p: N('Percentile (0–100)', 90, 0), method: SEL('Method', { inc: QUANTILE_METHODS.inc, exc: QUANTILE_METHODS.exc, nearest: QUANTILE_METHODS.nearest }, 'inc') },
        label: 'Value at the percentile',
        rows: { position: 'Position', others: 'Other methods' },
        run: (x) => {
            const r = data(x.data);

            if (!r.xs) {
                return r;
            }

            if (!(x.p >= 0 && x.p <= 100)) {
                return { error: 'The percentile must be between 0 and 100.' };
            }

            const s = sorted(r.xs);
            const v = quantile(s, x.p / 100, x.method);

            if (!Number.isFinite(v)) {
                return { error: 'The exclusive method cannot reach this percentile with so few values; use the inclusive method.' };
            }

            return { value: num(v, 10), sub: `${num(x.p)}th percentile, ${QUANTILE_METHODS[x.method]}`, rows: { position: quantilePosition(s.length, x.p / 100, x.method), others: Object.entries({ inc: 'Inclusive', exc: 'Exclusive', nearest: 'Nearest rank' }).map(([k, l]) => `${l}: ${Number.isFinite(quantile(s, x.p / 100, k)) ? num(quantile(s, x.p / 100, k), 8) : '—'}`).join('; ') }, steps: [`Sorted: ${s.slice(0, 60).map((u) => num(u)).join(', ')}`, quantilePosition(s.length, x.p / 100, x.method), 'A fractional position interpolates between the two neighbouring values'] };
        },
    },
    percentile_rank: {
        type: 'calc',
        inputs: { data: DATA('55, 62, 68, 70, 70, 74, 78, 81, 85, 92'), value: N('Value', 74) },
        label: 'Percentile rank',
        rows: { below: 'Values below', equal: 'Values equal', strict: 'Share strictly below' },
        run: (x) => {
            const r = data(x.data);

            if (!r.xs) {
                return r;
            }

            const below = r.xs.filter((v) => v < x.value).length;
            const equal = r.xs.filter((v) => v === x.value).length;
            const pr = ((below + 0.5 * equal) / r.xs.length) * 100;

            return { value: num(pr, 6), sub: `${num(x.value)} is at the ${num(pr, 4)}th percentile`, rows: { below: num(below), equal: num(equal), strict: pct(below / r.xs.length, 5) }, steps: ['PR = (B + ½E) ÷ n × 100, where B counts values below and E values equal', `= (${below} + ½ × ${equal}) ÷ ${r.xs.length} × 100 = ${num(pr, 8)}`] };
        },
    },
    pooled_sd: {
        type: 'calc',
        inputs: { data: TXT('Groups: standard deviation, size (one per line)', '4.2, 25\n3.8, 30\n5.1, 20') },
        label: 'Pooled standard deviation',
        rows: { variance: 'Pooled variance', df: 'Degrees of freedom Σ(n − 1)' },
        run: (x) => {
            const rows = parseRows(x.data).map((r) => r.values);

            if (rows.length < 2 || rows.some((r) => r.length !== 2 || r[0] < 0 || r[1] < 2)) {
                return { error: 'Enter at least two groups, each an SD (0 or more) and a size (2 or more).' };
            }

            const df = sum(rows.map(([, n]) => n - 1));
            const v = sum(rows.map(([s, n]) => (n - 1) * s * s)) / df;

            return { value: num(Math.sqrt(v), 8), sub: `from ${rows.length} groups`, rows: { variance: num(v, 8), df: num(df) }, steps: ['s_p = √(Σ(nᵢ − 1)sᵢ² ÷ Σ(nᵢ − 1))', `= √(${num(sum(rows.map(([s, n]) => (n - 1) * s * s)), 10)} ÷ ${num(df)}) = ${num(Math.sqrt(v), 10)}`, 'Assumes the groups share one true variance'] };
        },
    },
    pop_variance: {
        type: 'calc',
        inputs: { data: DATA('2, 4, 4, 4, 5, 5, 7, 9') },
        label: 'Population variance σ²',
        rows: { sd: 'Population SD σ', mean: 'Mean μ', sample: 'Sample variance s² (for comparison)' },
        grids: [['table', 'Squared deviations']],
        run: (x) => {
            const r = data(x.data);

            if (!r.xs) {
                return r;
            }

            const m = mean(r.xs);
            const v = ss(r.xs) / r.xs.length;

            return { value: num(v, 10), sub: `σ = ${num(Math.sqrt(v), 10)}`, rows: { sd: num(Math.sqrt(v), 10), mean: num(m, 10), sample: r.xs.length > 1 ? num(variance(r.xs), 10) : 'Needs 2 values' }, steps: ['σ² = Σ(x − μ)² ÷ N', `= ${num(ss(r.xs), 10)} ÷ ${r.xs.length} = ${num(v, 10)}`, 'Use this when the data are the whole population, not a sample'], grids: { table: deviationGrid(r.xs, m) } };
        },
    },
    cpk: {
        type: 'calc',
        inputs: { lsl: N('Lower specification limit (LSL)', 9.5), usl: N('Upper specification limit (USL)', 10.5), mode: SEL('Process data', { summary: 'Mean and standard deviation', data: 'Measurements' }, 'summary'), mean: N('Process mean', 10.1), sd: N('Process standard deviation', 0.12, 0), data: DATA('10.02, 10.11, 9.98, 10.15, 10.07, 10.21, 9.95, 10.09, 10.13, 10.04') },
        show: { mean: 'mode:summary', sd: 'mode:summary', data: 'mode:data' },
        when: { mean: (x) => x.mode === 'summary', sd: (x) => x.mode === 'summary' },
        label: 'Cpk',
        rows: { cp: 'Cp (potential)', cpu: 'Cpu', cpl: 'Cpl', ppm: 'Expected out of spec (ppm)', verdict: 'Rating' },
        run: (x) => {
            let m = x.mean;
            let s = x.sd;

            if (x.mode === 'data') {
                const r = data(x.data, 2);

                if (!r.xs) {
                    return r;
                }

                [m, s] = [mean(r.xs), sd(r.xs)];
            }

            if (!(x.usl > x.lsl) || !(s > 0)) {
                return { error: 'USL must be above LSL and the SD positive.' };
            }

            const cp = (x.usl - x.lsl) / (6 * s);
            const cpu = (x.usl - m) / (3 * s);
            const cpl = (m - x.lsl) / (3 * s);
            const cpk = Math.min(cpu, cpl);
            const ppm = (normCdf(-3 * cpu) + normCdf(-3 * cpl)) * 1e6;

            return { value: num(cpk, 4), sub: cpk >= 1.33 ? 'Capable (Cpk ≥ 1.33)' : cpk >= 1 ? 'Marginal (1.00–1.33)' : 'Not capable (Cpk < 1)', rows: { cp: num(cp, 4), cpu: num(cpu, 4), cpl: num(cpl, 4), ppm: num(ppm, 4), verdict: '≥ 1.33 capable, 1.67 for critical features; < 1 produces defects' }, steps: ['Cp = (USL − LSL) ÷ 6σ: the spread the specification allows', 'Cpk = min(USL − μ, μ − LSL) ÷ 3σ: also penalises an off-centre mean', `μ = ${num(m, 8)}, σ = ${num(s, 8)}`, `Cpk = min(${num(cpu, 6)}, ${num(cpl, 6)}) = ${num(cpk, 6)}`, 'With an SD from all measurements these are strictly Pp and Ppk; a stable, normal process is assumed'] };
        },
    },
    quartile: {
        type: 'calc',
        inputs: { data: DATA('6, 7, 15, 36, 39, 40, 41, 42, 43, 47, 49'), method: METHOD },
        label: 'Quartiles Q1, Q2, Q3',
        rows: { q1: 'Q1 (25th percentile)', q2: 'Q2 (median)', q3: 'Q3 (75th percentile)', iqr: 'IQR' },
        grids: [['table', 'The same data by every method']],
        run: (x) => {
            const r = data(x.data, 2);

            if (!r.xs) {
                return r;
            }

            const s = sorted(r.xs);
            const q = [0.25, 0.5, 0.75].map((p) => quantile(s, p, x.method));

            if (!q.every(Number.isFinite)) {
                return { error: 'Too few values for this method; use the inclusive method.' };
            }

            return { value: q.map((v) => num(v, 6)).join(', '), sub: QUANTILE_METHODS[x.method], rows: { q1: num(q[0], 10), q2: num(q[1], 10), q3: num(q[2], 10), iqr: num(q[2] - q[0], 10) }, steps: [`Sorted (n = ${s.length}): ${s.slice(0, 60).map((v) => num(v)).join(', ')}`, quantilePosition(s.length, 0.25, x.method), 'Different textbooks and programs use different rules; all are correct definitions, so state the one you use'], grids: { table: { columns: ['Q1', 'Q2', 'Q3'], rows: Object.entries(QUANTILE_METHODS).map(([k, label]) => ({ header: label, cells: [0.25, 0.5, 0.75].map((p) => (Number.isFinite(quantile(s, p, k)) ? num(quantile(s, p, k), 6) : '—')), highlight: k === x.method })) } } };
        },
    },
    range: {
        type: 'calc',
        inputs: { data: DATA('23, 7, 41, 15, 9, 33') },
        label: 'Range',
        rows: { min: 'Minimum', max: 'Maximum', iqr: 'IQR (for comparison)' },
        run: (x) => {
            const r = data(x.data);

            if (!r.xs) {
                return r;
            }

            const f = fiveNumber(r.xs);

            return { value: num(f.max - f.min, 10), sub: `${num(f.min)} to ${num(f.max)}`, rows: { min: num(f.min, 10), max: num(f.max, 10), iqr: r.xs.length > 1 ? num(f.iqr, 8) : '—' }, steps: ['Range = maximum − minimum', `= ${num(f.max)} − ${num(f.min)} = ${num(f.max - f.min, 10)}`, 'The range depends only on the two extremes, so one outlier changes it a lot'] };
        },
    },
    rsd: {
        type: 'calc',
        inputs: { data: DATA('98.2, 99.1, 97.8, 98.6, 99.4, 98.0') },
        label: 'Relative standard deviation',
        rows: { mean: 'Mean', sd: 'Standard deviation (sample)', pop: 'RSD with the population SD' },
        run: (x) => {
            const r = data(x.data, 2);

            if (!r.xs) {
                return r;
            }

            const m = mean(r.xs);

            if (m === 0) {
                return { error: 'The mean is zero, so the RSD is undefined.' };
            }

            const rsd = (sd(r.xs) / Math.abs(m)) * 100;

            return { value: `${num(rsd, 6)}%`, sub: 'Precision of repeated measurements', rows: { mean: num(m, 10), sd: num(sd(r.xs), 8), pop: `${num((sd(r.xs, false) / Math.abs(m)) * 100, 6)}%` }, steps: ['RSD = s ÷ |x̄| × 100% (the coefficient of variation as a percentage)', `= ${num(sd(r.xs), 8)} ÷ ${num(Math.abs(m), 8)} × 100% = ${num(rsd, 8)}%`] };
        },
    },
    rse: {
        type: 'calc',
        inputs: { mode: SEL('From', { data: 'Data', summary: 'An estimate and its standard error' }, 'data'), data: DATA(), est: N('Estimate', 42.5), se: N('Standard error', 3.1, 0) },
        show: { data: 'mode:data', est: 'mode:summary', se: 'mode:summary' },
        when: { est: (x) => x.mode === 'summary', se: (x) => x.mode === 'summary' },
        label: 'Relative standard error',
        rows: { se: 'Standard error', est: 'Estimate', reliable: 'Reliability' },
        run: (x) => {
            let est = x.est;
            let se = x.se;

            if (x.mode === 'data') {
                const r = data(x.data, 2);

                if (!r.xs) {
                    return r;
                }

                est = mean(r.xs);
                se = sd(r.xs) / Math.sqrt(r.xs.length);
            }

            if (est === 0) {
                return { error: 'The estimate is zero, so the RSE is undefined.' };
            }

            const rse = (se / Math.abs(est)) * 100;

            return { value: `${num(rse, 5)}%`, sub: rse > 30 ? 'Unreliable (RSE above 30%)' : rse > 25 ? 'Use with caution' : 'Reliable', rows: { se: num(se, 8), est: num(est, 8), reliable: 'Agencies such as NCHS and ABS flag estimates with RSE over 25–30%' }, steps: ['RSE = SE ÷ |estimate| × 100%', `= ${num(se, 8)} ÷ ${num(Math.abs(est), 8)} × 100% = ${num(rse, 8)}%`] };
        },
    },
    skewness: {
        type: 'calc',
        inputs: { data: DATA('2, 3, 3, 4, 4, 4, 5, 5, 6, 9, 12') },
        label: 'Sample skewness G₁',
        rows: { g1: 'Population skewness g₁', b1: 'b₁ (Minitab)', pearson: 'Pearson’s 2nd: 3(mean − median)/s', se: 'Standard error of G₁', z: 'z = G₁ ÷ SE' },
        run: (x) => {
            const r = data(x.data, 3);

            if (!r.xs) {
                return r;
            }

            const k = skewness(r.xs);

            if (!Number.isFinite(k.g1)) {
                return { error: 'The data do not vary, so skewness is undefined.' };
            }

            return { value: num(k.G1, 6), sub: Math.abs(k.G1) < 0.5 ? 'Roughly symmetric' : k.G1 > 0 ? 'Right (positively) skewed: a long tail of high values' : 'Left (negatively) skewed: a long tail of low values', rows: { g1: num(k.g1, 6), b1: num(k.b1, 6), pearson: num((3 * (mean(r.xs) - median(r.xs))) / sd(r.xs), 6), se: Number.isFinite(k.se) ? num(k.se, 5) : 'Needs 4+ values', z: Number.isFinite(k.se) ? num(k.G1 / k.se, 5) : '—' }, steps: ['g₁ = m₃ ÷ m₂^(3/2), with mᵣ = Σ(x − x̄)ʳ ÷ n', 'G₁ = g₁ √(n(n − 1)) ÷ (n − 2): the adjusted Fisher–Pearson coefficient used by Excel SKEW, SAS and SPSS', '|z| > 2 suggests real skew rather than chance (Joanes & Gill 1998)'] };
        },
    },
    spearman: {
        type: 'calc',
        inputs: { data: PAIRS('1, 2\n2, 1\n3, 4\n4, 3\n5, 6\n6, 5\n7, 8\n8, 9\n9, 7\n10, 10') },
        label: 'Spearman ρ',
        rows: { p: 'p-value (two-sided, t approximation)', n: 'Pairs', strength: 'Strength', ties: 'Ties' },
        grids: [['table', 'Ranks']],
        run: (x) => {
            const p = pairs(x.data, 3);

            if (!p.x) {
                return p;
            }

            const rx = ranks(p.x);
            const ry = ranks(p.y);
            const rho = pearson(rx.r, ry.r);

            if (!Number.isFinite(rho)) {
                return { error: 'One variable does not vary, so ρ is undefined.' };
            }

            const t = correlationTest(rho, p.x.length);
            const noTies = !rx.ties.length && !ry.ties.length;
            const d2 = sum(rx.r.map((v, i) => (v - ry.r[i]) ** 2));
            const n = p.x.length;

            return { value: num(rho, 6), sub: corrText(rho), rows: { p: num(t.p, 6), n: num(n), strength: corrText(rho), ties: noTies ? 'None' : 'Tied values share their average rank' }, steps: ['Rank x and y separately (ties get the average rank), then correlate the ranks', ...(noTies ? [`Without ties: ρ = 1 − 6Σd² ÷ (n(n² − 1)) = 1 − 6 × ${num(d2)} ÷ (${n} × ${n * n - 1}) = ${num(1 - (6 * d2) / (n * (n * n - 1)), 8)}`] : []), `p from t = ρ√(n − 2)/√(1 − ρ²) = ${num(t.t, 6)} with ${n - 2} df`], grids: { table: { columns: ['y', 'Rank x', 'Rank y', 'd²'], rows: p.x.slice(0, 200).map((v, i) => ({ header: num(v, 8), cells: [num(p.y[i], 8), num(rx.r[i]), num(ry.r[i]), num((rx.r[i] - ry.r[i]) ** 2)] })) } } };
        },
    },
    std_dev: {
        type: 'calc',
        inputs: { data: DATA('2, 4, 4, 4, 5, 5, 7, 9'), kind: KIND },
        label: 'Standard deviation',
        rows: { variance: 'Variance', mean: 'Mean', other: 'The other version', n: 'Count' },
        grids: [['table', 'Deviations from the mean']],
        run: (x) => {
            const r = data(x.data, x.kind === 'sample' ? 2 : 1);

            if (!r.xs) {
                return r;
            }

            const m = mean(r.xs);
            const sample = x.kind === 'sample';
            const v = ss(r.xs) / (r.xs.length - (sample ? 1 : 0));

            return { value: num(Math.sqrt(v), 10), sub: `${sample ? 'Sample s' : 'Population σ'} for ${r.xs.length} values`, rows: { variance: num(v, 10), mean: num(m, 10), other: r.xs.length > 1 ? `${sample ? 'Population σ' : 'Sample s'} = ${num(sd(r.xs, !sample), 10)}` : '—', n: num(r.xs.length) }, steps: [`Mean = ${num(sum(r.xs), 10)} ÷ ${r.xs.length} = ${num(m, 10)}`, `Σ(x − x̄)² = ${num(ss(r.xs), 10)}`, `Variance = ${num(ss(r.xs), 10)} ÷ ${sample ? `(${r.xs.length} − 1)` : r.xs.length} = ${num(v, 10)}`, `SD = √${num(v, 10)} = ${num(Math.sqrt(v), 10)}`], grids: { table: deviationGrid(r.xs, m) } };
        },
    },
    sdi: {
        type: 'calc',
        inputs: { lab: N('Your laboratory’s mean', 102.5), group: N('Peer group mean', 100), sd: N('Peer group standard deviation', 2.5, 0) },
        label: 'Standard deviation index (SDI)',
        rows: { bias: 'Difference from the group', verdict: 'Assessment' },
        run: (x) => {
            if (!(x.sd > 0)) {
                return { error: 'The group SD must be positive.' };
            }

            const sdi = (x.lab - x.group) / x.sd;
            const a = Math.abs(sdi);

            return { value: num(sdi, 4), sub: a <= 1 ? 'Acceptable (|SDI| ≤ 1)' : a <= 2 ? 'Marginal: review (1 < |SDI| ≤ 2)' : 'Unacceptable: investigate (|SDI| > 2)', rows: { bias: `${num(x.lab - x.group, 6)} (${pct((x.lab - x.group) / x.group, 4)})`, verdict: '|SDI| ≤ 1 good, ≤ 2 acceptable, > 2 investigate (proficiency-testing practice)' }, steps: ['SDI = (laboratory mean − group mean) ÷ group SD', `= (${num(x.lab)} − ${num(x.group)}) ÷ ${num(x.sd)} = ${num(sdi, 6)}`] };
        },
    },
    sd_mean: {
        type: 'calc',
        inputs: { sigma: N('Standard deviation σ (or s)', 15, 0), n: N('Sample size n', 36, 1), N: N('Population size N (0 = very large)', 0, 0) },
        label: 'Standard deviation of the sample mean',
        rows: { fpc: 'Finite population correction', plain: 'Without the correction' },
        run: (x) => {
            if (!(x.sigma >= 0) || (x.N > 0 && x.N < x.n)) {
                return { error: 'σ must be 0 or more and n no larger than N.' };
            }

            const fpc = x.N > 0 ? Math.sqrt((x.N - x.n) / (x.N - 1)) : 1;
            const se = (x.sigma / Math.sqrt(x.n)) * fpc;

            return { value: num(se, 8), sub: 'σ_x̄ = σ/√n', rows: { fpc: x.N > 0 ? num(fpc, 6) : 'Not used', plain: num(x.sigma / Math.sqrt(x.n), 8) }, steps: ['σ_x̄ = σ ÷ √n', `= ${num(x.sigma)} ÷ √${num(x.n)} = ${num(x.sigma / Math.sqrt(x.n), 10)}`, ...(x.N > 0 ? [`× √((N − n) ÷ (N − 1)) = × ${num(fpc, 8)} → ${num(se, 10)}`] : []), 'Quadrupling the sample size halves the spread of the sample mean'] };
        },
    },
    std_error: {
        type: 'calc',
        inputs: { mode: SEL('From', { data: 'Data', sd: 'Standard deviation and n', prop: 'A proportion' }, 'data'), data: DATA(), s: N('Standard deviation', 8, 0), n: N('Sample size', 25, 1), p: N('Proportion p̂', 0.4, 0), np: N('Sample size', 200, 1) },
        show: { data: 'mode:data', s: 'mode:sd', n: 'mode:sd', p: 'mode:prop', np: 'mode:prop' },
        when: { s: (x) => x.mode === 'sd', n: (x) => x.mode === 'sd', p: (x) => x.mode === 'prop', np: (x) => x.mode === 'prop' },
        label: 'Standard error',
        rows: { ci: 'Approximate 95% interval (± 1.96 SE)', centre: 'Estimate' },
        run: (x) => {
            let se;
            let centre;
            let how;

            if (x.mode === 'prop') {
                if (!(x.p >= 0 && x.p <= 1)) {
                    return { error: 'p̂ must be between 0 and 1.' };
                }

                se = Math.sqrt((x.p * (1 - x.p)) / x.np);
                centre = x.p;
                how = `SE = √(p̂(1 − p̂)/n) = √(${num(x.p)} × ${num(1 - x.p)} ÷ ${num(x.np)})`;
            } else if (x.mode === 'sd') {
                se = x.s / Math.sqrt(x.n);
                centre = NaN;
                how = `SE = s/√n = ${num(x.s)} ÷ √${num(x.n)}`;
            } else {
                const r = data(x.data, 2);

                if (!r.xs) {
                    return r;
                }

                se = sd(r.xs) / Math.sqrt(r.xs.length);
                centre = mean(r.xs);
                how = `SE = s/√n = ${num(sd(r.xs), 8)} ÷ √${r.xs.length}`;
            }

            return { value: num(se, 8), sub: 'Typical error of the estimate', rows: { ci: Number.isFinite(centre) ? `${num(centre - 1.959964 * se, 8)} to ${num(centre + 1.959964 * se, 8)}` : `± ${num(1.959964 * se, 8)}`, centre: Number.isFinite(centre) ? num(centre, 8) : '—' }, steps: [how, `= ${num(se, 10)}`] };
        },
    },
    sum_squares: {
        type: 'calc',
        inputs: { data: DATA('3, 5, 7, 9, 11') },
        label: 'Sum of squares Σ(x − x̄)²',
        rows: { raw: 'Raw sum of squares Σx²', shortcut: 'Shortcut Σx² − (Σx)²/n', mean: 'Mean' },
        grids: [['table', 'Squared deviations']],
        run: (x) => {
            const r = data(x.data);

            if (!r.xs) {
                return r;
            }

            const m = mean(r.xs);
            const raw = sum(r.xs.map((v) => v * v));

            return { value: num(ss(r.xs), 10), sub: `about the mean ${num(m, 8)}`, rows: { raw: num(raw, 10), shortcut: num(raw - sum(r.xs) ** 2 / r.xs.length, 10), mean: num(m, 10) }, steps: ['SS = Σ(x − x̄)²: the total squared distance from the mean', 'Variance = SS ÷ (n − 1); the shortcut formula can lose precision with large values'], grids: { table: deviationGrid(r.xs, m) } };
        },
    },
    uncertainty: {
        type: 'calc',
        inputs: { data: DATA('9.81, 9.79, 9.83, 9.80, 9.82, 9.78, 9.81'), k: N('Coverage factor k', 2, 0) },
        label: 'Result',
        rows: { u: 'Standard uncertainty u = s/√n', U: 'Expanded uncertainty U = k·u', rel: 'Relative uncertainty', sd: 'SD of single readings' },
        run: (x) => {
            const r = data(x.data, 2);

            if (!r.xs) {
                return r;
            }

            const m = mean(r.xs);
            const s = sd(r.xs);
            const u = s / Math.sqrt(r.xs.length);
            const U = x.k * u;

            return { value: `${num(m, 8)} ± ${num(U, 3)}`, sub: `k = ${num(x.k)} (about ${x.k === 2 ? '95%' : 'the matching'} coverage)`, rows: { u: num(u, 6), U: num(U, 6), rel: pct(U / Math.abs(m), 4), sd: num(s, 6) }, steps: ['Type A evaluation (GUM, JCGM 100:2008): repeated readings give the mean and its standard uncertainty', `u = s ÷ √n = ${num(s, 8)} ÷ √${r.xs.length} = ${num(u, 8)}`, `U = k·u = ${num(x.k)} × ${num(u, 8)} = ${num(U, 8)}`, 'Add Type B components (instrument resolution, calibration) in quadrature for a full budget'] };
        },
    },
    fences: {
        type: 'calc',
        inputs: { mode: SEL('From', { data: 'Data', quartiles: 'Q1 and Q3' }, 'data'), data: DATA('12, 14, 15, 15, 16, 17, 18, 19, 21, 45'), q1: N('Q1', 15), q3: N('Q3', 19), k: N('Multiplier (1.5 = outliers, 3 = extreme)', 1.5, 0), method: METHOD },
        show: { data: 'mode:data', method: 'mode:data', q1: 'mode:quartiles', q3: 'mode:quartiles' },
        when: { q1: (x) => x.mode === 'quartiles', q3: (x) => x.mode === 'quartiles' },
        label: 'Lower and upper fence',
        rows: { lower: 'Lower fence', upper: 'Upper fence', iqr: 'IQR', outliers: 'Values outside' },
        run: (x) => {
            let q1 = x.q1;
            let q3 = x.q3;
            let xs = [];

            if (x.mode === 'data') {
                const r = data(x.data, 2);

                if (!r.xs) {
                    return r;
                }

                const f = fiveNumber(r.xs, x.method);
                [q1, q3, xs] = [f.q1, f.q3, r.xs];
            }

            if (!(q3 >= q1)) {
                return { error: 'Q3 must be at least Q1.' };
            }

            const iqr = q3 - q1;
            const lo = q1 - x.k * iqr;
            const hi = q3 + x.k * iqr;
            const out = xs.filter((v) => v < lo || v > hi);

            return { value: `${num(lo, 8)} and ${num(hi, 8)}`, sub: `Q1 − ${num(x.k)}·IQR and Q3 + ${num(x.k)}·IQR`, rows: { lower: num(lo, 10), upper: num(hi, 10), iqr: num(iqr, 10), outliers: x.mode === 'data' ? (out.length ? out.map((v) => num(v)).join(', ') : 'None') : 'Enter data to list them' }, steps: [`IQR = Q3 − Q1 = ${num(q3, 8)} − ${num(q1, 8)} = ${num(iqr, 8)}`, `Lower fence = Q1 − ${num(x.k)} × IQR = ${num(lo, 10)}`, `Upper fence = Q3 + ${num(x.k)} × IQR = ${num(hi, 10)}`] };
        },
    },
    variance: {
        type: 'calc',
        inputs: { data: DATA('6, 2, 3, 1, 8, 4'), kind: KIND },
        label: 'Variance',
        rows: { sd: 'Standard deviation', mean: 'Mean', other: 'The other version' },
        grids: [['table', 'Squared deviations']],
        run: (x) => {
            const r = data(x.data, x.kind === 'sample' ? 2 : 1);

            if (!r.xs) {
                return r;
            }

            const sample = x.kind === 'sample';
            const v = ss(r.xs) / (r.xs.length - (sample ? 1 : 0));

            return { value: num(v, 10), sub: `${sample ? 'Sample s²' : 'Population σ²'}`, rows: { sd: num(Math.sqrt(v), 10), mean: num(mean(r.xs), 10), other: r.xs.length > 1 ? `${sample ? 'Population' : 'Sample'}: ${num(variance(r.xs, !sample), 10)}` : '—' }, steps: [`Σ(x − x̄)² = ${num(ss(r.xs), 10)}`, `Variance = ${num(ss(r.xs), 10)} ÷ ${sample ? `(n − 1) = ${r.xs.length - 1}` : `n = ${r.xs.length}`} = ${num(v, 10)}`, 'Dividing by n − 1 (Bessel’s correction) makes the sample variance unbiased'], grids: { table: deviationGrid(r.xs, mean(r.xs)) } };
        },
    },
    venn: {
        type: 'calc',
        inputs: { mode: SEL('Enter', { lists2: 'Two lists of items', lists3: 'Three lists of items', counts2: 'Counts for two sets', counts3: 'Counts for three sets' }, 'lists2'), A: TXT('Set A', 'apple, banana, cherry, date, fig'), B: TXT('Set B', 'banana, date, grape, kiwi'), C: TXT('Set C', 'cherry, date, kiwi, lemon'), nA: N('|A|', 30, 0), nB: N('|B|', 25, 0), nC: N('|C|', 20, 0), nAB: N('|A ∩ B|', 10, 0), nAC: N('|A ∩ C|', 6, 0), nBC: N('|B ∩ C|', 5, 0), nABC: N('|A ∩ B ∩ C|', 2, 0), total: N('Total in the universe (optional)', 60, 0) },
        show: { A: 'mode:lists2,lists3', B: 'mode:lists2,lists3', C: 'mode:lists3', nA: 'mode:counts2,counts3', nB: 'mode:counts2,counts3', nAB: 'mode:counts2,counts3', nC: 'mode:counts3', nAC: 'mode:counts3', nBC: 'mode:counts3', nABC: 'mode:counts3', total: 'mode:counts2,counts3' },
        when: { nA: (x) => x.mode.startsWith('counts'), nB: (x) => x.mode.startsWith('counts'), nAB: (x) => x.mode.startsWith('counts'), nC: (x) => x.mode === 'counts3', nAC: (x) => x.mode === 'counts3', nBC: (x) => x.mode === 'counts3', nABC: (x) => x.mode === 'counts3' },
        optional: ['total'],
        label: 'Union',
        rows: { inter: 'Intersection of all', only: 'In exactly one set', none: 'In none (needs a total)', detail: 'Regions' },
        plots: [['venn', 'Venn diagram']],
        run: (x) => {
            const three = x.mode === 'lists3' || x.mode === 'counts3';
            let r;
            let detail = '';

            if (x.mode.startsWith('lists')) {
                const set = (t) => new Set(String(t ?? '').split(/[,;\n]+/).map((v) => v.trim()).filter(Boolean));
                const [A, B, C] = [set(x.A), set(x.B), three ? set(x.C) : new Set()];
                const all = new Set([...A, ...B, ...C]);
                const where = (v) => `${A.has(v) ? 'a' : ''}${B.has(v) ? 'b' : ''}${C.has(v) ? 'c' : ''}`;
                const groups = {};
                all.forEach((v) => {
                    groups[where(v)] = [...(groups[where(v)] ?? []), v];
                });
                const c = (k) => groups[k]?.length ?? 0;
                r = three ? { a: c('a'), b: c('b'), c: c('c'), ab: c('ab'), ac: c('ac'), bc: c('bc'), abc: c('abc') } : { a: c('a'), b: c('b'), ab: c('ab') };
                detail = Object.entries(groups).map(([k, v]) => `${k.toUpperCase().split('').join(' ∩ ')} only: ${v.join(', ')}`).join('; ');
            } else if (!three) {
                if (x.nAB > Math.min(x.nA, x.nB)) {
                    return { error: '|A ∩ B| cannot exceed |A| or |B|.' };
                }

                r = { a: x.nA - x.nAB, b: x.nB - x.nAB, ab: x.nAB };
            } else {
                const ab = x.nAB - x.nABC;
                const ac = x.nAC - x.nABC;
                const bc = x.nBC - x.nABC;
                r = { a: x.nA - ab - ac - x.nABC, b: x.nB - ab - bc - x.nABC, c: x.nC - ac - bc - x.nABC, ab, ac, bc, abc: x.nABC };

                if (Object.values(r).some((v) => v < 0)) {
                    return { error: 'These counts are inconsistent: a region would be negative.' };
                }
            }

            const union = sum(Object.values(r));
            const only = r.a + r.b + (r.c ?? 0);
            const hasTotal = x.mode.startsWith('counts') && Number.isFinite(x.total) && x.total > 0;

            if (hasTotal && x.total < union) {
                return { error: 'The total is smaller than the union.' };
            }

            const regions = { ...r, none: hasTotal ? x.total - union : '' };

            return { value: num(union), sub: three ? '|A ∪ B ∪ C| by inclusion–exclusion' : '|A ∪ B| = |A| + |B| − |A ∩ B|', rows: { inter: num(three ? r.abc : r.ab), only: num(only), none: hasTotal ? num(x.total - union) : 'Enter a total', detail: detail || Object.entries(r).map(([k, v]) => `${k.toUpperCase()}: ${v}`).join(', ') }, steps: three ? ['|A ∪ B ∪ C| = |A| + |B| + |C| − |A∩B| − |A∩C| − |B∩C| + |A∩B∩C|', 'Each region of the diagram counts the elements in exactly those sets'] : ['|A ∪ B| = |A| + |B| − |A ∩ B|', 'A only = |A| − |A ∩ B|; B only = |B| − |A ∩ B|'], plots: { venn: { kind: 'venn', names: three ? ['A', 'B', 'C'] : ['A', 'B'], regions } } };
        },
    },
    kurtosis: {
        type: 'calc',
        inputs: { data: DATA('2, 4, 4, 5, 5, 5, 5, 6, 6, 8, 15') },
        label: 'Excess kurtosis G₂',
        rows: { g2: 'Population excess kurtosis g₂', b2: 'b₂ (Minitab)', raw: 'Kurtosis (not excess) g₂ + 3', se: 'Standard error', shape: 'Shape' },
        run: (x) => {
            const r = data(x.data, 4);

            if (!r.xs) {
                return r;
            }

            const k = kurtosis(r.xs);

            if (!Number.isFinite(k.g2)) {
                return { error: 'The data do not vary, so kurtosis is undefined.' };
            }

            return { value: num(k.G2, 6), sub: k.G2 > 0.5 ? 'Leptokurtic: heavier tails than a normal distribution' : k.G2 < -0.5 ? 'Platykurtic: lighter tails than a normal distribution' : 'Close to normal (mesokurtic)', rows: { g2: num(k.g2, 6), b2: num(k.b2, 6), raw: num(k.g2 + 3, 6), se: num(k.se, 5), shape: 'Normal = 0 excess (3 non-excess)' }, steps: ['g₂ = m₄ ÷ m₂² − 3, with mᵣ = Σ(x − x̄)ʳ ÷ n', 'G₂ = ((n − 1) ÷ ((n − 2)(n − 3))) × ((n + 1)g₂ + 6): Excel KURT, SAS and SPSS', 'Kurtosis mainly reflects the tails (outliers), not the peak'] };
        },
    },
    trimmed_mean: {
        type: 'calc',
        inputs: { data: DATA('2, 4, 5, 5, 6, 7, 7, 8, 9, 40'), trim: N('Trim from each end (%)', 10, 0) },
        label: 'Trimmed mean',
        rows: { removed: 'Values removed from each end', winsor: 'Winsorised mean', mean: 'Ordinary mean', median: 'Median' },
        run: (x) => {
            const r = data(x.data, 3);

            if (!r.xs) {
                return r;
            }

            if (!(x.trim >= 0 && x.trim < 50)) {
                return { error: 'Trim between 0% and 50% from each end.' };
            }

            const s = sorted(r.xs);
            const n = s.length;
            const g = Math.floor((n * x.trim) / 100);
            const kept = s.slice(g, n - g);
            const wins = s.map((v, i) => (i < g ? s[g] : i >= n - g ? s[n - g - 1] : v));

            return { value: num(mean(kept), 10), sub: `${num(x.trim)}% trimmed: ${kept.length} of ${n} values kept`, rows: { removed: String(g), winsor: num(mean(wins), 10), mean: num(mean(s), 10), median: num(median(s), 10) }, steps: [`Remove ⌊n × ${num(x.trim)}%⌋ = ${g} value${g === 1 ? '' : 's'} from each end of the sorted data`, `Mean of the rest = ${num(sum(kept), 10)} ÷ ${kept.length} = ${num(mean(kept), 10)}`, 'Winsorising replaces the extremes by the nearest kept value instead of dropping them'] };
        },
    },
    kendall: {
        type: 'calc',
        inputs: { data: PAIRS('1, 2\n2, 1\n3, 4\n4, 3\n5, 6\n6, 5\n7, 8\n8, 9\n9, 7\n10, 10') },
        label: 'Kendall τ-b',
        rows: { p: 'p-value (two-sided)', pairs: 'Concordant / discordant pairs', method: 'p-value method' },
        run: (x) => {
            const p = pairs(x.data, 3);

            if (!p.x) {
                return p;
            }

            const k = kendall(p.x, p.y);

            if (!Number.isFinite(k.tau)) {
                return { error: 'One variable does not vary, so τ is undefined.' };
            }

            return { value: num(k.tau, 6), sub: corrText(k.tau), rows: { p: num(k.p, 6), pairs: `${k.C} / ${k.D}`, method: k.exact ? 'Exact (no ties, n < 50)' : 'Normal approximation with tie-adjusted variance' }, steps: ['A pair of points is concordant if x and y move in the same direction, discordant if opposite', 'τ-b = (C − D) ÷ √((n₀ − T_x)(n₀ − T_y)), with n₀ = n(n − 1)/2 and T the tied pairs', `= (${k.C} − ${k.D}) ÷ √((${(p.x.length * (p.x.length - 1)) / 2} − ${k.tx})(${(p.x.length * (p.x.length - 1)) / 2} − ${k.ty})) = ${num(k.tau, 8)}`] };
        },
    },
    cronbach: {
        type: 'calc',
        inputs: { data: TXT('Item scores: one respondent per line, one column per item', '4, 5, 4, 4\n3, 3, 4, 3\n5, 5, 5, 4\n2, 3, 2, 2\n4, 4, 3, 4\n3, 4, 3, 3\n5, 4, 5, 5\n2, 2, 3, 2') },
        label: 'Cronbach’s α',
        rows: { items: 'Items k', people: 'Respondents', band: 'Interpretation' },
        grids: [['table', 'α if each item were deleted']],
        run: (x) => {
            const rows = parseRows(x.data).map((r) => r.values);
            const k = rows[0]?.length;

            if (rows.length < 2 || !(k >= 2) || rows.some((r) => r.length !== k)) {
                return { error: 'Enter at least 2 respondents, each with the same number (2 or more) of item scores.' };
            }

            const alpha = (cols) => {
                const kk = cols.length;
                const itemVar = sum(cols.map((c) => variance(rows.map((r) => r[c]))));
                const totalVar = variance(rows.map((r) => sum(cols.map((c) => r[c]))));

                return (kk / (kk - 1)) * (1 - itemVar / totalVar);
            };
            const all = Array.from({ length: k }, (_, j) => j);
            const a = alpha(all);

            if (!Number.isFinite(a)) {
                return { error: 'The total scores do not vary, so α is undefined.' };
            }

            return { value: num(a, 5), sub: a >= 0.9 ? 'Excellent' : a >= 0.8 ? 'Good' : a >= 0.7 ? 'Acceptable' : a >= 0.6 ? 'Questionable' : 'Poor', rows: { items: String(k), people: num(rows.length), band: '≥ 0.9 excellent, ≥ 0.8 good, ≥ 0.7 acceptable (George & Mallery)' }, steps: ['α = (k ÷ (k − 1)) × (1 − Σ item variances ÷ variance of the totals)', `= (${k} ÷ ${k - 1}) × (1 − ${num(sum(all.map((c) => variance(rows.map((r) => r[c])))), 8)} ÷ ${num(variance(rows.map((r) => sum(r))), 8)}) = ${num(a, 8)}`, 'Very high α (> 0.95) can mean redundant items'], grids: { table: { columns: ['α without it'], rows: k > 2 ? all.map((j) => ({ header: `Item ${j + 1}`, cells: [num(alpha(all.filter((c) => c !== j)), 5)] })) : [{ header: 'Needs 3+ items', cells: ['—'] }] } } };
        },
    },
    kappa: {
        type: 'calc',
        inputs: { data: TXT('Agreement table: rater A’s categories in rows, rater B’s in columns', '20, 5\n10, 15') },
        label: 'Cohen’s κ',
        rows: { po: 'Observed agreement pₒ', pe: 'Chance agreement pₑ', ci: '95% CI (approximate)', band: 'Strength (Landis & Koch)' },
        run: (x) => {
            const t = parseRows(x.data).map((r) => r.values);
            const k = t.length;

            if (k < 2 || t.some((r) => r.length !== k) || t.flat().some((v) => v < 0)) {
                return { error: 'Enter a square table of counts (2 × 2 or larger).' };
            }

            const n = sum(t.flat());
            const po = sum(t.map((r, i) => r[i])) / n;
            const rowsT = t.map((r) => sum(r));
            const cols = t[0].map((_, j) => sum(t.map((r) => r[j])));
            const pe = sum(rowsT.map((r, i) => (r * cols[i]) / (n * n)));
            const kappa = (po - pe) / (1 - pe);
            const se = Math.sqrt((po * (1 - po)) / (n * (1 - pe) ** 2));
            const band = kappa < 0 ? 'Poor (less than chance)' : kappa <= 0.2 ? 'Slight' : kappa <= 0.4 ? 'Fair' : kappa <= 0.6 ? 'Moderate' : kappa <= 0.8 ? 'Substantial' : 'Almost perfect';

            return { value: num(kappa, 5), sub: `${band} agreement`, rows: { po: num(po, 6), pe: num(pe, 6), ci: `${num(kappa - 1.959964 * se, 4)} to ${num(kappa + 1.959964 * se, 4)}`, band }, steps: ['κ = (pₒ − pₑ) ÷ (1 − pₑ) (Cohen 1960)', `pₒ = agreements ÷ n = ${num(po, 8)}`, `pₑ = Σ(row total × column total) ÷ n² = ${num(pe, 8)}`, `κ = ${num(kappa, 8)}`] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
