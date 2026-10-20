import { defineTools } from '../engines/formula.js';
import { handlersFor } from '../physics/core.js';
import { N, SEL, TXT, num, pct } from '../statistics/common.js';
import { QUANTILE_METHODS, splitItems, fiveNumber, mean, modes, parseNumbers, parsePairs, pearson, quantile, readData, sd, sorted, sum } from '../statistics/data.js';
import { betaDist, binomial, chiSquare, distPlot, exponential, fisherF, gammaDist, geometric, hypergeometric, lognormal, negBinomial, normal, poisson, rayleigh, regionProbability, regionText, studentT, uniform, weibull } from '../statistics/dist.js';
import { curve, ols } from '../statistics/reg.js';
import { lfact, normCdf, normInv, tInv } from '../statistics/special.js';
import { chiGoodness, chiIndependence } from '../statistics/tests.js';

/**
 * Distributions and plots: probability calculators for the common distributions (with the region shaded on
 * the chart) and the data charts (histogram, box plot, dot plot, stem-and-leaf, pie, frequency tables).
 */

const CONT_MODES = { le: 'P(X ≤ x)', ge: 'P(X ≥ x)', between: 'P(a ≤ X ≤ b)', outside: 'P(X < a or X > b)', inv: 'x for a given P(X ≤ x)' };
const DISC_MODES = { eq: 'P(X = k)', le: 'P(X ≤ k)', lt: 'P(X < k)', ge: 'P(X ≥ k)', gt: 'P(X > k)', between: 'P(a ≤ X ≤ b)' };

/**
 * A continuous distribution page: parameters, then a region (or a probability for the inverse).
 * build(x) returns the distribution or { error }.
 */
function contTool({ params, build, a = 1, b = 2, p = 0.95, xLabel = 'x', formula = [], note = '' }) {
    return {
        type: 'calc',
        inputs: { ...params, mode: SEL('Find', CONT_MODES, 'le'), a: N('x (or the lower limit a)', a), b: N('Upper limit b', b), p: N('Probability P(X ≤ x)', p, 0) },
        show: { a: 'mode:le,ge,between,outside', b: 'mode:between,outside', p: 'mode:inv' },
        when: { a: (x) => x.mode !== 'inv', b: (x) => x.mode === 'between' || x.mode === 'outside', p: (x) => x.mode === 'inv' },
        label: 'Probability',
        rows: { pdf: 'Density f(x)', mean: 'Mean', sd: 'Standard deviation', median: 'Median', q: 'Quartiles (25%, 75%)' },
        plots: [['dist', 'Distribution with the region shaded']],
        run: (x) => {
            const d = build(x);

            if (d.error) {
                return d;
            }

            const common = { mean: Number.isFinite(d.mean) ? num(d.mean, 6) : 'Undefined', sd: Number.isFinite(d.variance) ? num(Math.sqrt(d.variance), 6) : d.variance === Infinity ? 'Infinite' : 'Undefined', median: num(d.inv(0.5), 6), q: `${num(d.inv(0.25), 6)}, ${num(d.inv(0.75), 6)}` };
            const lo = Math.min(d.lo, ...(x.mode === 'inv' ? [] : [x.a, ...(x.mode === 'between' || x.mode === 'outside' ? [x.b] : [])].filter(Number.isFinite).map((v) => v - Math.abs(v) * 0.05)));
            const hi = Math.max(d.hi, ...(x.mode === 'inv' ? [] : [x.a, ...(x.mode === 'between' || x.mode === 'outside' ? [x.b] : [])].filter(Number.isFinite).map((v) => v + Math.abs(v) * 0.05)));

            if (x.mode === 'inv') {
                if (!(x.p > 0 && x.p < 1)) {
                    return { error: 'The probability must be between 0 and 1.' };
                }

                const v = d.inv(x.p);

                return { value: num(v, 8), label: 'x', sub: `P(X ≤ ${num(v, 6)}) = ${num(x.p)}`, rows: { pdf: num(d.pdf(v), 6), ...common }, steps: [...formula, `x is the ${num(x.p * 100)}th percentile: the inverse CDF at ${num(x.p)}`, `x = ${num(v, 10)}`, ...(note ? [note] : [])], plots: { dist: distPlot(d, 'le', v, 0, { xLabel, lo: Math.min(d.lo, v), hi: Math.max(d.hi, v) }) } };
            }

            if (x.mode !== 'le' && x.mode !== 'ge' && !(x.b > x.a)) {
                return { error: 'The upper limit b must be larger than a.' };
            }

            const value = regionProbability(d, x.mode, x.a, x.b);
            const text = regionText(x.mode, x.a, x.b, (v) => num(v));

            return { value: num(value, 8), sub: `${text} = ${pct(value)}`, rows: { pdf: num(d.pdf(x.a), 6), ...common }, steps: [...formula, `${text} = ${num(value, 10)}`, ...(note ? [note] : [])], plots: { dist: distPlot(d, x.mode, x.a, x.b, { xLabel, lo, hi }) } };
        },
    };
}

/** A discrete distribution page: parameters, then a region of whole numbers. */
function discTool({ params, build, a = 3, b = 6, xLabel = 'k', formula = [] }) {
    return {
        type: 'calc',
        inputs: { ...params, mode: SEL('Find', DISC_MODES, 'eq'), a: N('k (or the lower limit a)', a), b: N('Upper limit b', b) },
        show: { b: 'mode:between' },
        when: { b: (x) => x.mode === 'between' },
        label: 'Probability',
        rows: { eq: 'P(X = k)', le: 'P(X ≤ k)', ge: 'P(X ≥ k)', mean: 'Mean', sd: 'Standard deviation' },
        plots: [['dist', 'Probabilities with the region highlighted']],
        run: (x) => {
            const d = build(x);

            if (d.error) {
                return d;
            }

            if (!Number.isInteger(x.a) || (x.mode === 'between' && !(Number.isInteger(x.b) && x.b >= x.a))) {
                return { error: 'Use whole numbers for k (and a ≤ b).' };
            }

            const value = regionProbability(d, x.mode, x.a, x.b);
            const text = regionText(x.mode, x.a, x.b, (v) => num(v));
            const spread = Math.sqrt(d.variance);
            const lo = Math.max(d.lo, Math.floor(Math.min(x.a, d.mean - 4 * spread - 2)));
            const hi = Math.min(d.hi, Math.ceil(Math.max(x.mode === 'between' ? x.b : x.a, d.mean + 4 * spread + 2)));

            return { value: num(value, 8), sub: `${text} = ${pct(value)}`, rows: { eq: num(d.pdf(x.a), 8), le: num(regionProbability(d, 'le', x.a), 8), ge: num(regionProbability(d, 'ge', x.a), 8), mean: num(d.mean, 6), sd: num(spread, 6) }, steps: [...formula, `${text} = ${num(value, 10)}`], plots: { dist: distPlot(d, x.mode === 'eq' ? 'between' : x.mode, x.a, x.mode === 'eq' ? x.a : x.b, { xLabel, lo, hi }) } };
        },
    };
}

const positive = (v, name) => (v > 0 ? null : { error: `${name} must be positive.` });
const prob01 = (v, name) => (v > 0 && v <= 1 ? null : { error: `${name} must be between 0 and 1.` });

/** Class intervals for grouping: start, width and count covering the data. */
function classes(xs, k, width, start) {
    const lo = Math.min(...xs);
    const hi = Math.max(...xs);
    const kk = k > 0 ? k : Math.ceil(Math.log2(xs.length) + 1);
    const w = width > 0 ? width : (hi - lo) / kk || 1;
    const s = Number.isFinite(start) ? start : lo;
    const count = Math.max(1, Math.ceil((hi - s) / w - 1e-9));
    const bins = Array.from({ length: count }, (_, j) => ({ from: s + j * w, to: s + (j + 1) * w, f: 0 }));
    xs.forEach((v) => {
        const j = Math.min(count - 1, Math.max(0, Math.floor((v - s) / w + 1e-12)));
        bins[j].f += 1;
    });

    return { bins, w, kk };
}

/** "[10, 20)" interval text with the last class closed. */
const classText = (bin, last) => `${num(bin.from, 6)} – ${num(bin.to, 6)}${last ? '' : ' (excl.)'}`;

/** Decimal places in the data (for rounding class widths up to the data's precision). */
const placesOf = (xs) => Math.max(0, ...xs.map((v) => (String(v).split('.')[1] ?? '').length));

/** Frequency table rows for bins. */
function freqRows(bins, n) {
    let cum = 0;

    return bins.map((bin, j) => {
        cum += bin.f;

        return { header: classText(bin, j === bins.length - 1), cells: [num((bin.from + bin.to) / 2, 6), num(bin.f), num(bin.f / n, 4), num(cum), num(cum / n, 4)] };
    });
}

/** Reads "label, value" lines (labels may contain spaces). */
function labelledValues(text) {
    const out = [];

    for (const [index, line] of String(text ?? '').split(/\r?\n/).map((l) => l.trim()).filter(Boolean).entries()) {
        const m = line.match(/^(.*?)[,:\t]\s*(-?[\d.]+(?:e[+-]?\d+)?)\s*$/i);

        if (!m || !Number.isFinite(Number(m[2]))) {
            return { problem: `Line ${index + 1} should be a label and a number, e.g. “Rent, 1200”.` };
        }

        out.push({ label: m[1].trim() || `Item ${index + 1}`, value: Number(m[2]) });
    }

    return { items: out };
}

export const TOOLS = {
    benford: {
        type: 'calc',
        inputs: { data: TXT('Data (amounts, populations, counts…)', '100, 107, 114, 123, 131, 140, 150, 161, 172, 184, 197, 210, 225, 241, 258, 276, 295, 316, 338, 362, 387, 414, 443, 474, 507, 543, 581, 621, 665, 711, 761, 815, 872, 933, 998, 1068, 1142, 1222, 1308, 1399, 1497, 1602, 1714, 1834, 1963, 2100, 2247, 2405, 2573, 2753, 2946, 3152, 3373, 3609, 3861, 4132, 4421, 4730, 5061, 5416, 5795, 6200, 6634, 7099, 7596, 8127, 8696, 9305, 9956, 10653, 11399, 12197, 13051, 13964, 14942, 15988, 17107, 18304, 19585, 20956, 22423, 23993, 25673, 27470, 29393, 31450, 33652, 36007, 38528, 41225, 44110, 47198, 50502, 54037, 57820, 61867, 66198, 70831, 75790, 81095') },
        data: ['benford_mad'],
        label: 'Mean absolute deviation (MAD)',
        rows: { verdict: 'Conformity (Nigrini)', chi: 'χ² (8 df) and p-value', n: 'Values used' },
        plots: [['digits', 'First digits: observed (bars) vs Benford (line)']],
        grids: [['table', 'First-digit frequencies']],
        run: (x, ctx) => {
            const { values, bad } = parseNumbers(x.data);

            if (bad.length) {
                return { error: `These are not numbers: ${bad.slice(0, 5).join(', ')}.` };
            }

            const digits = values.map((v) => Math.abs(v)).filter((v) => v > 0).map((v) => Number(v.toExponential().charAt(0)));

            if (digits.length < 10) {
                return { empty: 'Enter at least 10 non-zero values (Benford tests need hundreds to be reliable).' };
            }

            const counts = Array.from({ length: 9 }, (_, d) => digits.filter((v) => v === d + 1).length);
            const expected = Array.from({ length: 9 }, (_, d) => Math.log10(1 + 1 / (d + 1)));
            const n = digits.length;
            const mad = sum(counts.map((c, d) => Math.abs(c / n - expected[d]))) / 9;
            const gof = chiGoodness(counts, expected);
            const band = (ctx.c.data.statistics?.benford_mad ?? []).find((b) => b.max === null || mad <= b.max);

            return { value: num(mad, 4), sub: band?.name ?? '', rows: { verdict: `${band?.name ?? ''}${n < 300 ? ' (fewer than 300 values: treat with caution)' : ''}`, chi: `${num(gof.chi2, 5)}, p = ${num(gof.p, 4)}`, n: num(n) }, steps: ['Benford’s law: P(first digit = d) = log₁₀(1 + 1/d), so 1 leads about 30.1% of the time and 9 only 4.6%', `MAD = average |observed share − Benford share| over the 9 digits = ${num(mad, 6)}`, 'Nigrini’s first-digit bands: ≤ 0.006 close, ≤ 0.012 acceptable, ≤ 0.015 marginal, above that nonconforming', 'Data spanning several orders of magnitude (amounts, populations) tend to follow Benford; assigned numbers and capped values do not'], plots: { digits: { bars: counts.map((c, d) => ({ x: d + 1, y: c / n })), series: expected.map((e, d) => [d + 1, e]), xLabel: 'First digit', yLabel: 'Share', yMin: 0 } }, grids: { table: { columns: ['Count', 'Observed', 'Benford'], rows: counts.map((c, d) => ({ header: String(d + 1), cells: [num(c), pct(c / n, 3), pct(expected[d], 3)] })) } } };
        },
    },
    beta: contTool({ params: { alpha: N('α (shape)', 2, 0), beta: N('β (shape)', 5, 0) }, build: (x) => positive(x.alpha, 'α') ?? positive(x.beta, 'β') ?? betaDist(x.alpha, x.beta), a: 0.3, b: 0.6, formula: ['f(x) = x^(α−1)(1 − x)^(β−1) ÷ B(α, β) on 0 ≤ x ≤ 1', 'CDF = regularised incomplete beta I_x(α, β)'] }),
    binomial: discTool({ params: { n: N('Trials n', 20, 0), p: N('Success probability p', 0.3, 0) }, build: (x) => (Number.isInteger(x.n) && x.n >= 0 && x.n <= 1e7 ? null : { error: 'n must be a whole number.' }) ?? (x.p >= 0 && x.p <= 1 ? binomial(x.n, x.p) : { error: 'p must be between 0 and 1.' }), a: 6, b: 9, formula: ['P(X = k) = C(n, k) pᵏ (1 − p)ⁿ⁻ᵏ', 'Cumulative sums use the regularised incomplete beta function (exact)'] }),
    box_plot: {
        type: 'calc',
        inputs: { data: TXT('Data sets: one per line, optionally named (“Group A: 3, 5, 7”)', 'Class A: 62, 67, 70, 71, 74, 75, 78, 80, 84, 99\nClass B: 55, 60, 64, 68, 70, 72, 73, 79, 82, 88'), method: SEL('Quartile method', QUANTILE_METHODS, 'inc') },
        label: 'Median (first set)',
        rows: { five: 'Five-number summary (first set)', iqr: 'IQR', fences: 'Fences (1.5 × IQR)', outliers: 'Outliers' },
        plots: [['box', 'Box plot']],
        grids: [['table', 'Every data set']],
        run: (x) => {
            const sets = [];

            for (const [index, line] of String(x.data ?? '').split(/\r?\n/).map((l) => l.trim()).filter(Boolean).entries()) {
                const m = line.match(/^([^:]*[A-Za-z][^:]*):(.*)$/);
                const { values, bad } = parseNumbers(m ? m[2] : line);

                if (bad.length) {
                    return { error: `Line ${index + 1}: these are not numbers: ${bad.slice(0, 4).join(', ')}.` };
                }

                if (values.length) {
                    sets.push({ name: m ? m[1].trim() : `Set ${index + 1}`, values });
                }
            }

            if (!sets.length) {
                return { empty: 'Enter your data.' };
            }

            const boxes = sets.map((set) => {
                const f = fiveNumber(set.values, x.method);
                const lo = f.q1 - 1.5 * f.iqr;
                const hi = f.q3 + 1.5 * f.iqr;
                const inside = f.s.filter((v) => v >= lo && v <= hi);

                return { ...f, name: set.name, fenceLo: lo, fenceHi: hi, whiskerLo: inside[0], whiskerHi: inside[inside.length - 1], outliers: f.s.filter((v) => v < lo || v > hi), mean: mean(set.values) };
            });
            const b0 = boxes[0];

            if (!Number.isFinite(b0.q1)) {
                return { error: 'Too few values for this quartile method; add data or choose the inclusive method.' };
            }

            return { value: num(b0.med, 8), sub: `${b0.name}: n = ${b0.s.length}`, rows: { five: [b0.min, b0.q1, b0.med, b0.q3, b0.max].map((v) => num(v, 6)).join(', '), iqr: num(b0.iqr, 6), fences: `${num(b0.fenceLo, 6)} and ${num(b0.fenceHi, 6)}`, outliers: b0.outliers.length ? b0.outliers.map((v) => num(v)).join(', ') : 'None' }, steps: [`Quartile method: ${QUANTILE_METHODS[x.method]}`, 'The box runs from Q1 to Q3 with a line at the median; × marks the mean', 'Whiskers reach the furthest values within 1.5 × IQR of the box (Tukey); points beyond are drawn separately as outliers'], plots: { box: { kind: 'box', boxes: boxes.map((b) => ({ label: b.name, lo: b.whiskerLo, q1: b.q1, med: b.med, q3: b.q3, hi: b.whiskerHi, outliers: b.outliers, mean: b.mean })) } }, grids: { table: { columns: ['n', 'Min', 'Q1', 'Median', 'Q3', 'Max', 'IQR'], rows: boxes.map((b) => ({ header: b.name, cells: [num(b.s.length), num(b.min, 5), num(b.q1, 5), num(b.med, 5), num(b.q3, 5), num(b.max, 5), num(b.iqr, 5)] })) } } };
        },
    },
    clt: {
        type: 'calc',
        inputs: { mu: N('Population mean μ', 70), sigma: N('Population standard deviation σ', 12, 0), n: N('Sample size n', 36, 1), mode: SEL('Find', { le: 'P(x̄ ≤ a)', ge: 'P(x̄ ≥ a)', between: 'P(a ≤ x̄ ≤ b)' }, 'between'), a: N('a', 68), b: N('b', 73) },
        show: { b: 'mode:between' },
        when: { b: (x) => x.mode === 'between' },
        label: 'Probability for the sample mean',
        rows: { se: 'Standard error σ/√n', za: 'z for a', zb: 'z for b', range: 'Middle 95% of sample means' },
        plots: [['dist', 'Sampling distribution of the mean']],
        run: (x) => {
            if (!(x.sigma > 0 && Number.isInteger(x.n))) {
                return { error: 'σ must be positive and n a whole number.' };
            }

            const se = x.sigma / Math.sqrt(x.n);
            const d = normal(x.mu, se);
            const value = regionProbability(d, x.mode, x.a, x.b);

            return { value: num(value, 6), sub: `${regionText(x.mode, x.a, x.b, (v) => num(v), 'x̄')} = ${pct(value)}`, rows: { se: num(se, 6), za: num((x.a - x.mu) / se, 5), zb: x.mode === 'between' ? num((x.b - x.mu) / se, 5) : '—', range: `${num(x.mu - 1.959964 * se, 6)} to ${num(x.mu + 1.959964 * se, 6)}` }, steps: ['Central limit theorem: for large n, x̄ is approximately normal with mean μ and standard error σ/√n, whatever the population’s shape', `SE = ${num(x.sigma)} ÷ √${x.n} = ${num(se, 6)}`, `z = (a − μ) ÷ SE = ${num((x.a - x.mu) / se, 6)}`, x.n < 30 ? 'n is under 30: the approximation needs a roughly normal population' : 'n ≥ 30 is usually enough for the approximation'], plots: { dist: distPlot(d, x.mode, x.a, x.b, { xLabel: 'Sample mean' }) } };
        },
    },
    chi_square: {
        type: 'calc',
        inputs: { mode: SEL('Calculate', { gof: 'Goodness of fit (observed vs expected)', independence: 'Test of independence (contingency table)', dist: 'p-value from a χ² value' }, 'gof'), observed: TXT('Observed counts', '18, 22, 30, 30'), expected: TXT('Expected counts or proportions (blank = equal)', '25, 25, 25, 25'), table: TXT('Table: one row per line', '12, 5, 9\n7, 14, 6'), yates: SEL('Yates’ continuity correction (2 × 2 only)', { no: 'No', yes: 'Yes' }, 'no'), chi: N('χ² value', 3.84, 0), df: N('Degrees of freedom', 1, 1) },
        show: { observed: 'mode:gof', expected: 'mode:gof', table: 'mode:independence', yates: 'mode:independence', chi: 'mode:dist', df: 'mode:dist' },
        when: { chi: (x) => x.mode === 'dist', df: (x) => x.mode === 'dist' },
        label: 'χ² statistic',
        rows: { df: 'Degrees of freedom', p: 'p-value', crit: 'Critical value (α = 0.05)', effect: 'Effect size' },
        plots: [['dist', 'χ² distribution (shaded: p-value)']],
        grids: [['table', 'Expected counts']],
        run: (x) => {
            let chi;
            let df;
            let p;
            let effect = '—';
            let grid = { columns: [], rows: [] };
            let steps;

            if (x.mode === 'dist') {
                chi = x.chi;
                df = x.df;
                p = chiSquare(df).sf(chi);
                steps = ['p = P(χ² ≥ value) with the given degrees of freedom'];
            } else if (x.mode === 'gof') {
                const obs = parseNumbers(x.observed).values;
                const expRaw = parseNumbers(x.expected).values;
                const exp = expRaw.length ? expRaw : obs.map(() => 1);

                if (obs.length < 2 || exp.length !== obs.length) {
                    return { error: 'Enter at least two observed counts and the same number of expected values.' };
                }

                const g = chiGoodness(obs, exp);
                [chi, df, p] = [g.chi2, g.df, g.p];
                effect = `Cohen’s w = ${num(Math.sqrt(chi / sum(obs)), 4)}`;
                grid = { columns: ['Observed', 'Expected', '(O − E)²/E'], rows: obs.map((o, i) => ({ header: `Category ${i + 1}`, cells: [num(o), num(g.e[i], 6), num((o - g.e[i]) ** 2 / g.e[i], 5)] })) };
                steps = ['χ² = Σ (O − E)² ÷ E, with E scaled so expected counts add up to the observed total', `df = categories − 1 = ${df}`, ...(g.e.some((e) => e < 5) ? ['Some expected counts are below 5: the χ² approximation may be poor'] : [])];
            } else {
                const rows = String(x.table ?? '').split(/\r?\n/).map((l) => parseNumbers(l).values).filter((r) => r.length);

                if (rows.length < 2 || rows.some((r) => r.length !== rows[0].length) || rows[0].length < 2) {
                    return { error: 'Enter a table of at least 2 × 2 counts, every row the same length.' };
                }

                const t = chiIndependence(rows, x.yates === 'yes');
                [chi, df, p] = [t.chi2, t.df, t.p];
                effect = `Cramér’s V = ${num(t.cramersV, 4)}`;
                grid = { columns: rows[0].map((_, j) => `Column ${j + 1}`), rows: t.e.map((r, i) => ({ header: `Row ${i + 1}`, cells: r.map((v) => num(v, 5)) })) };
                steps = ['E = row total × column total ÷ grand total', `χ² = Σ ${x.yates === 'yes' && rows.length === 2 && rows[0].length === 2 ? '(|O − E| − ½)²' : '(O − E)²'} ÷ E`, `df = (rows − 1)(columns − 1) = ${df}`, ...(t.e.flat().some((e) => e < 5) ? ['Some expected counts are below 5: consider Fisher’s exact test'] : [])];
            }

            const d = chiSquare(df);

            return { value: num(chi, 6), sub: `p = ${num(p, 4)}${p < 0.05 ? ' (significant at 0.05)' : ''}`, rows: { df: num(df, 6), p: num(p, 6), crit: num(d.inv(0.95), 6), effect }, steps: [...steps, `p = P(χ²(${num(df)}) ≥ ${num(chi, 6)}) = ${num(p, 8)}`], plots: { dist: distPlot(d, 'ge', chi, 0, { xLabel: 'χ²', hi: Math.max(d.hi, chi * 1.1) }) }, grids: { table: grid } };
        },
    },
    class_width: {
        type: 'calc',
        inputs: { data: TXT('Data (or leave blank and enter min and max)', '12, 15, 22, 27, 31, 34, 38, 41, 45, 48, 52, 55, 61, 66, 72'), min: N('Minimum (if no data)', 12), max: N('Maximum (if no data)', 72), k: N('Number of classes (0 = Sturges’ rule)', 5, 0) },
        optional: ['min', 'max'],
        label: 'Class width',
        rows: { raw: 'Exact (max − min) ÷ k', k: 'Classes', sturges: 'Sturges’ suggestion' },
        grids: [['table', 'Class limits']],
        run: (x) => {
            const { values } = parseNumbers(x.data);
            const lo = values.length ? Math.min(...values) : x.min;
            const hi = values.length ? Math.max(...values) : x.max;

            if (!(Number.isFinite(lo) && Number.isFinite(hi) && hi > lo)) {
                return { empty: 'Enter data, or a minimum and a larger maximum.' };
            }

            const sturges = values.length ? Math.ceil(Math.log2(values.length) + 1) : NaN;
            const k = x.k > 0 ? Math.round(x.k) : sturges;

            if (!(k >= 1)) {
                return { error: 'Enter the number of classes (Sturges’ rule needs data).' };
            }

            const places = placesOf(values.length ? values : [lo, hi]);
            const unit = 10 ** -places;
            const raw = (hi - lo) / k;
            const q = raw / unit;
            const width = Number(((Math.abs(q - Math.round(q)) < 1e-9 ? Math.round(q) + 1 : Math.ceil(q)) * unit).toPrecision(12));

            return { value: num(width, 8), sub: `Rounded up from ${num(raw, 6)} so ${k} classes cover the data`, rows: { raw: num(raw, 8), k: String(k), sturges: Number.isFinite(sturges) ? `${sturges} classes for n = ${values.length}` : 'Needs data' }, steps: ['Class width = (maximum − minimum) ÷ number of classes, rounded up', `= (${num(hi)} − ${num(lo)}) ÷ ${k} = ${num(raw, 8)}`, `Rounded up to the data’s precision (${num(unit)}), and up one step when it divides exactly, so the maximum falls inside the last class: ${num(width, 8)}`], grids: { table: { columns: ['Lower limit', 'Upper limit'], rows: Array.from({ length: k }, (_, j) => ({ header: `Class ${j + 1}`, cells: [num(lo + j * width, 8), num(lo + (j + 1) * width - unit, 8)] })) } } };
        },
    },
    confidence_interval: {
        type: 'calc',
        inputs: { mode: SEL('Data', { mean_s: 'Mean with sample SD (t)', mean_sigma: 'Mean with known σ (z)', data: 'Raw data (t)', prop: 'A proportion' }, 'mean_s'), mean: N('Sample mean', 50), s: N('Standard deviation', 8, 0), n: N('Sample size', 25, 1), data: TXT('Data', '48, 52, 51, 47, 55, 50, 49, 53, 46, 54'), x: N('Successes', 42, 0), nprop: N('Sample size', 120, 1), conf: N('Confidence level (%)', 95, 0) },
        show: { mean: 'mode:mean_s,mean_sigma', s: 'mode:mean_s,mean_sigma', n: 'mode:mean_s,mean_sigma', data: 'mode:data', x: 'mode:prop', nprop: 'mode:prop' },
        when: { mean: (x) => x.mode === 'mean_s' || x.mode === 'mean_sigma', s: (x) => x.mode === 'mean_s' || x.mode === 'mean_sigma', n: (x) => x.mode === 'mean_s' || x.mode === 'mean_sigma', x: (x) => x.mode === 'prop', nprop: (x) => x.mode === 'prop' },
        label: 'Confidence interval',
        rows: { centre: 'Point estimate', moe: 'Margin of error', crit: 'Critical value', se: 'Standard error' },
        run: (x) => {
            const c = x.conf / 100;

            if (!(c > 0 && c < 1)) {
                return { error: 'The confidence level must be between 0 and 100%.' };
            }

            let centre;
            let se;
            let crit;
            let critName;
            let lo;
            let hi;
            let steps = [];

            if (x.mode === 'prop') {
                if (!(x.x >= 0 && x.x <= x.nprop)) {
                    return { error: 'Successes must be between 0 and the sample size.' };
                }

                centre = x.x / x.nprop;
                se = Math.sqrt((centre * (1 - centre)) / x.nprop);
                crit = normInv(1 - (1 - c) / 2);
                critName = 'z';
                const z2 = crit * crit;
                const mid = (centre + z2 / (2 * x.nprop)) / (1 + z2 / x.nprop);
                const half = (crit / (1 + z2 / x.nprop)) * Math.sqrt(se * se + z2 / (4 * x.nprop * x.nprop));
                [lo, hi] = [Math.max(0, mid - half), Math.min(1, mid + half)];
                steps = [`p̂ = ${num(x.x)} ÷ ${num(x.nprop)} = ${num(centre, 6)}`, 'Wilson score interval (accurate for small n and p near 0 or 1)', `Wald interval for comparison: ${num(centre - crit * se, 6)} to ${num(centre + crit * se, 6)}`];
            } else {
                let m = x.mean;
                let s = x.s;
                let n = x.n;

                if (x.mode === 'data') {
                    const r = readData(x.data, 2);

                    if (!r.xs) {
                        return r;
                    }

                    [m, s, n] = [mean(r.xs), sd(r.xs), r.xs.length];
                    steps.push(`From the data: n = ${n}, x̄ = ${num(m, 8)}, s = ${num(s, 8)}`);
                }

                if (!(s >= 0 && n >= 2)) {
                    return { error: 'Use a non-negative SD and at least 2 values.' };
                }

                centre = m;
                se = s / Math.sqrt(n);
                const useZ = x.mode === 'mean_sigma';
                crit = useZ ? normInv(1 - (1 - c) / 2) : tInv(1 - (1 - c) / 2, n - 1);
                critName = useZ ? 'z' : `t (${n - 1} df)`;
                [lo, hi] = [m - crit * se, m + crit * se];
                steps.push(`SE = ${useZ ? 'σ' : 's'}/√n = ${num(s)} ÷ √${n} = ${num(se, 8)}`, `${critName} critical value = ${num(crit, 8)}`);
            }

            return { value: `${num(lo, 6)} to ${num(hi, 6)}`, sub: `${num(x.conf)}% confidence`, rows: { centre: num(centre, 8), moe: `± ${num((hi - lo) / 2, 6)}`, crit: `${critName} = ${num(crit, 6)}`, se: num(se, 6) }, steps: [...steps, `Interval = ${num(lo, 8)} to ${num(hi, 8)}`, `In repeated samples, ${num(x.conf)}% of intervals built this way contain the true value`] };
        },
    },
    continuity: {
        type: 'calc',
        inputs: { n: N('Trials n', 40, 1), p: N('Success probability p', 0.5, 0), mode: SEL('Statement', { eq: 'P(X = k)', le: 'P(X ≤ k)', lt: 'P(X < k)', ge: 'P(X ≥ k)', gt: 'P(X > k)' }, 'le'), k: N('k', 23) },
        label: 'Normal approximation (corrected)',
        rows: { corrected: 'Corrected statement', exact: 'Exact binomial', without: 'Without correction', check: 'np and n(1 − p)' },
        run: (x) => {
            if (!(Number.isInteger(x.n) && x.p > 0 && x.p < 1 && Number.isInteger(x.k))) {
                return { error: 'Use a whole n and k and 0 < p < 1.' };
            }

            const mu = x.n * x.p;
            const s = Math.sqrt(x.n * x.p * (1 - x.p));
            const Phi = (v) => normCdf((v - mu) / s);
            const k = x.k;
            const [text, approx, raw] = { eq: [`P(${k - 0.5} < Y < ${k + 0.5})`, Phi(k + 0.5) - Phi(k - 0.5), 0], le: [`P(Y < ${k + 0.5})`, Phi(k + 0.5), Phi(k)], lt: [`P(Y < ${k - 0.5})`, Phi(k - 0.5), Phi(k)], ge: [`P(Y > ${k - 0.5})`, 1 - Phi(k - 0.5), 1 - Phi(k)], gt: [`P(Y > ${k + 0.5})`, 1 - Phi(k + 0.5), 1 - Phi(k)] }[x.mode];
            const exact = regionProbability(binomial(x.n, x.p), x.mode, k);

            return { value: num(approx, 6), sub: `${text} with Y ~ N(${num(mu, 5)}, ${num(s, 5)}²)`, rows: { corrected: text, exact: num(exact, 6), without: num(raw, 6), check: `${num(mu, 5)} and ${num(x.n - mu, 5)}${mu >= 10 && x.n - mu >= 10 ? ' (both ≥ 10: approximation fine)' : ' (below 10: use the exact value)'}` }, steps: ['A discrete count k covers the interval k − ½ to k + ½ on the continuous normal curve', `μ = np = ${num(mu, 6)}, σ = √(np(1 − p)) = ${num(s, 6)}`, `${DISC_MODES[x.mode].replace('k', k)} → ${text}`, `Approximation ${num(approx, 8)} vs exact ${num(exact, 8)}`] };
        },
    },
    dot_plot: {
        type: 'calc',
        inputs: { data: TXT('Data', '3, 4, 4, 5, 5, 5, 6, 6, 7, 8, 8, 10') },
        label: 'Mode',
        rows: { n: 'Values', range: 'Range', median: 'Median' },
        plots: [['dots', 'Dot plot']],
        run: (x) => {
            const r = readData(x.data);

            if (!r.xs) {
                return r;
            }

            const m = modes(r.xs);
            const seen = new Map();
            const dots = sorted(r.xs).map((v) => {
                const c = (seen.get(v) ?? 0) + 1;
                seen.set(v, c);

                return [v, c];
            });

            return { value: m.values.length ? m.values.map((v) => num(v)).join(', ') : 'No mode', sub: m.values.length ? `appears ${m.count} times` : 'Every value appears once', rows: { n: num(r.xs.length), range: `${num(Math.min(...r.xs))} to ${num(Math.max(...r.xs))}`, median: num(quantile(sorted(r.xs), 0.5), 8) }, steps: ['Each value gets one dot, stacked above its place on the number line', 'Tall stacks show the mode; gaps and lone dots stand out'], plots: { dots: { scatter: dots, xLabel: 'Value', yLabel: 'Count', yMin: 0, yMax: Math.max(...dots.map(([, c]) => c)) + 1 } } };
        },
    },
    effect_size: {
        type: 'calc',
        inputs: { mode: SEL('From', { groups: 'Two group means and SDs', t: 'A t statistic', r: 'A correlation r', or: 'An odds ratio' }, 'groups'), m1: N('Mean 1', 105), s1: N('SD 1', 15, 0), n1: N('Size 1', 30, 2), m2: N('Mean 2', 98), s2: N('SD 2', 14, 0), n2: N('Size 2', 30, 2), t: N('t', 2.5), r: N('r', 0.3), or: N('Odds ratio', 2.5, 0) },
        show: { m1: 'mode:groups', s1: 'mode:groups', m2: 'mode:groups', s2: 'mode:groups', n1: 'mode:groups,t', n2: 'mode:groups,t', t: 'mode:t', r: 'mode:r', or: 'mode:or' },
        when: { m1: (x) => x.mode === 'groups', s1: (x) => x.mode === 'groups', m2: (x) => x.mode === 'groups', s2: (x) => x.mode === 'groups', n1: (x) => x.mode === 'groups' || x.mode === 't', n2: (x) => x.mode === 'groups' || x.mode === 't', t: (x) => x.mode === 't', r: (x) => x.mode === 'r', or: (x) => x.mode === 'or' },
        label: 'Cohen’s d',
        rows: { g: 'Hedges’ g (small-sample corrected)', r: 'Correlation r', eta: 'η² (variance explained)', size: 'Size (Cohen 1988)' },
        run: (x) => {
            let d;
            let steps;
            const n1 = x.n1;
            const n2 = x.n2;

            if (x.mode === 'groups') {
                const sp = Math.sqrt(((n1 - 1) * x.s1 ** 2 + (n2 - 1) * x.s2 ** 2) / (n1 + n2 - 2));
                d = (x.m1 - x.m2) / sp;
                steps = [`Pooled SD = √(((n₁ − 1)s₁² + (n₂ − 1)s₂²) ÷ (n₁ + n₂ − 2)) = ${num(sp, 6)}`, `d = (${num(x.m1)} − ${num(x.m2)}) ÷ ${num(sp, 6)} = ${num(d, 6)}`];
            } else if (x.mode === 't') {
                d = x.t * Math.sqrt(1 / n1 + 1 / n2);
                steps = [`d = t √(1/n₁ + 1/n₂) = ${num(x.t)} × √(1/${n1} + 1/${n2}) = ${num(d, 6)}`];
            } else if (x.mode === 'r') {
                if (!(Math.abs(x.r) < 1)) {
                    return { error: 'r must be between −1 and 1.' };
                }

                d = (2 * x.r) / Math.sqrt(1 - x.r * x.r);
                steps = [`d = 2r ÷ √(1 − r²) = ${num(d, 6)}`];
            } else {
                if (!(x.or > 0)) {
                    return { error: 'The odds ratio must be positive.' };
                }

                d = (Math.log(x.or) * Math.sqrt(3)) / Math.PI;
                steps = [`d = ln(OR) × √3 ÷ π = ${num(d, 6)} (Chinn 2000)`];
            }

            const nn = x.mode === 'groups' || x.mode === 't' ? n1 + n2 : NaN;
            const J = Number.isFinite(nn) ? 1 - 3 / (4 * (nn - 2) - 1) : NaN;
            const a = Number.isFinite(nn) ? (nn * nn) / (n1 * n2) : 4;
            const r = d / Math.sqrt(d * d + a);
            const abs = Math.abs(d);

            return { value: num(d, 5), sub: `${abs < 0.2 ? 'Negligible' : abs < 0.5 ? 'Small' : abs < 0.8 ? 'Medium' : 'Large'} effect`, rows: { g: Number.isFinite(J) ? num(d * J, 5) : 'Needs group sizes', r: num(r, 5), eta: num(r * r, 5), size: '0.2 small, 0.5 medium, 0.8 large' }, steps: [...steps, 'r = d ÷ √(d² + (n₁ + n₂)²/(n₁n₂)) (or d² + 4 for equal groups)', 'Benchmarks are rough; judge effects in the context of the field'] };
        },
    },
    empirical: {
        type: 'calc',
        inputs: { mean: N('Mean μ', 100), sd: N('Standard deviation σ', 15, 0) },
        label: '68% of values lie between',
        rows: { r95: '95% between', r997: '99.7% between', exact: 'Exact normal shares' },
        grids: [['table', 'The 68–95–99.7 rule']],
        plots: [['curve', 'Normal curve (shaded ±1σ)']],
        run: (x) => {
            if (!(x.sd > 0)) {
                return { error: 'σ must be positive.' };
            }

            const band = (k) => `${num(x.mean - k * x.sd, 6)} to ${num(x.mean + k * x.sd, 6)}`;
            const d = normal(x.mean, x.sd);

            return { value: band(1), sub: 'μ ± 1σ', rows: { r95: band(2), r997: band(3), exact: `${pct(2 * normCdf(1) - 1, 5)}, ${pct(2 * normCdf(2) - 1, 5)}, ${pct(2 * normCdf(3) - 1, 5)}` }, steps: ['For a normal distribution about 68% of values lie within 1σ of the mean, 95% within 2σ and 99.7% within 3σ', 'Exactly: 68.27%, 95.45% and 99.73%; for exactly 95%, use ±1.96σ'], grids: { table: { columns: ['Range', 'Rule', 'Exact'], rows: [1, 2, 3].map((k) => ({ header: `μ ± ${k}σ`, cells: [band(k), ['68%', '95%', '99.7%'][k - 1], pct(2 * normCdf(k) - 1, 5)] })) } }, plots: { curve: distPlot(d, 'between', x.mean - x.sd, x.mean + x.sd, { xLabel: 'x' }) } };
        },
    },
    exponential: contTool({ params: { rate: N('Rate λ (events per unit time)', 0.5, 0) }, build: (x) => positive(x.rate, 'λ') ?? exponential(x.rate), a: 2, b: 4, xLabel: 'Time', formula: ['f(x) = λe^(−λx), P(X ≤ x) = 1 − e^(−λx); mean 1/λ'], note: 'Memoryless: P(X > s + t | X > s) = P(X > t)' }),
    exp_growth: {
        type: 'calc',
        inputs: { data: TXT('Time, value pairs (one per line)', '0, 100\n1, 118\n2, 141\n3, 166\n4, 197\n5, 233'), at: N('Predict the value at time', 8) },
        label: 'Predicted value',
        rows: { model: 'Fitted model', rate: 'Growth rate per time unit', doubling: 'Doubling time', r2: 'R² (on ln y)' },
        plots: [['fit', 'Data and fitted curve']],
        run: (x) => {
            const { x: t, y, problem } = parsePairs(x.data);

            if (problem) {
                return { error: problem };
            }

            if (t.length < 3 || y.some((v) => v <= 0)) {
                return { error: 'Enter at least 3 pairs with positive values.' };
            }

            const fit = ols(t.map((v) => [1, v]), y.map(Math.log));

            if (fit.problem) {
                return { error: fit.problem };
            }

            const a = Math.exp(fit.beta[0]);
            const k = fit.beta[1];
            const f = (v) => a * Math.exp(k * v);

            return { value: num(f(x.at), 6), sub: `at time ${num(x.at)}`, rows: { model: `y = ${num(a, 6)} × e^(${num(k, 6)} t)`, rate: pct(Math.expm1(k), 5), doubling: k > 0 ? num(Math.LN2 / k, 6) : `Halving time ${num(-Math.LN2 / k, 6)}`, r2: num(fit.r2, 6) }, steps: ['Fit ln y = ln a + k t by least squares, then y = a e^(kt)', `ln a = ${num(fit.beta[0], 8)}, k = ${num(k, 8)}`, `Prediction = ${num(a, 6)} × e^(${num(k, 6)} × ${num(x.at)}) = ${num(f(x.at), 8)}`, 'Predicting far beyond the data assumes the growth continues unchanged'], plots: { fit: { scatter: t.map((v, i) => [v, y[i]]), series: curve(f, [...t, x.at]), markers: [{ x: x.at, y: f(x.at), label: 'prediction' }], xLabel: 'Time', yLabel: 'Value' } } };
        },
    },
    freq_dist: {
        type: 'calc',
        inputs: { data: TXT('Data', '23, 29, 31, 35, 36, 38, 41, 42, 44, 45, 47, 49, 52, 55, 58, 61, 63, 67, 72, 78'), k: N('Number of classes (0 = Sturges)', 6, 0), width: N('Class width (optional)', 10, 0), start: N('First class starts at (optional)', 20) },
        optional: ['width', 'start'],
        label: 'Classes',
        rows: { width: 'Class width', n: 'Values', modal: 'Modal class' },
        plots: [['hist', 'Histogram']],
        grids: [['table', 'Frequency distribution']],
        run: (x) => {
            const r = readData(x.data, 2);

            if (!r.xs) {
                return r;
            }

            const { bins, w } = classes(r.xs, x.k, x.width, x.start);

            if (Number.isFinite(x.start) && x.start > Math.min(...r.xs)) {
                return { error: 'The first class must start at or below the smallest value.' };
            }

            const top = Math.max(...bins.map((b) => b.f));
            const modal = bins.find((b) => b.f === top);

            return { value: num(bins.length), sub: `of width ${num(w, 6)}`, rows: { width: num(w, 6), n: num(r.xs.length), modal: classText(modal, false) }, steps: ['Each class includes its lower limit and excludes its upper limit (the last class includes both)', 'Relative frequency = f ÷ n; cumulative frequency adds the classes so far'], plots: { hist: { bars: bins.map((b) => ({ x0: b.from, x1: b.to, y: b.f })), xLabel: 'Value', yLabel: 'Frequency', yMin: 0 } }, grids: { table: { columns: ['Midpoint', 'f', 'Relative', 'Cumulative', 'Cum. relative'], rows: freqRows(bins, r.xs.length) } } };
        },
    },
    freq_polygon: {
        type: 'calc',
        inputs: { data: TXT('Data', '23, 29, 31, 35, 36, 38, 41, 42, 44, 45, 47, 49, 52, 55, 58, 61, 63, 67, 72, 78'), k: N('Number of classes (0 = Sturges)', 6, 0), width: N('Class width (optional)', 10, 0), start: N('First class starts at (optional)', 20) },
        optional: ['width', 'start'],
        label: 'Class midpoints plotted',
        rows: { width: 'Class width', peak: 'Highest point' },
        plots: [['poly', 'Frequency polygon']],
        grids: [['table', 'Points of the polygon']],
        run: (x) => {
            const r = readData(x.data, 2);

            if (!r.xs) {
                return r;
            }

            const { bins, w } = classes(r.xs, x.k, x.width, x.start);
            const mids = bins.map((b) => [(b.from + b.to) / 2, b.f]);
            const pts = [[mids[0][0] - w, 0], ...mids, [mids[mids.length - 1][0] + w, 0]];
            const top = mids.reduce((a, b) => (b[1] > a[1] ? b : a));

            return { value: num(mids.length), sub: 'plus a zero point at each end', rows: { width: num(w, 6), peak: `${num(top[1])} at ${num(top[0], 6)}` }, steps: ['Plot each class frequency at the class midpoint and join the points', 'Add a zero-frequency class at each end so the polygon meets the axis'], plots: { poly: { series: pts, markers: mids.map(([mx, f]) => ({ x: mx, y: f })), xLabel: 'Class midpoint', yLabel: 'Frequency', yMin: 0 } }, grids: { table: { columns: ['Midpoint', 'Frequency'], rows: pts.map(([mx, f], j) => ({ header: j === 0 || j === pts.length - 1 ? 'End' : classText(bins[j - 1], j === pts.length - 2), cells: [num(mx, 6), num(f)] })) } } };
        },
    },
    geometric: discTool({ params: { p: N('Success probability p', 0.2, 0), form: SEL('Count', { trials: 'Trials up to and including the first success (1, 2, …)', failures: 'Failures before the first success (0, 1, …)' }, 'trials') }, build: (x) => prob01(x.p, 'p') ?? geometric(x.p, x.form === 'failures'), a: 3, b: 5, formula: ['P(X = k) = (1 − p)^(k − 1) p for trials (k ≥ 1), or (1 − p)ᵏ p for failures (k ≥ 0)'] }),
    histogram: {
        type: 'calc',
        inputs: { data: TXT('Data', '4.2, 5.1, 5.5, 5.8, 6.0, 6.1, 6.3, 6.4, 6.6, 6.8, 7.0, 7.1, 7.3, 7.5, 7.9, 8.2, 8.6, 9.4'), rule: SEL('Bins', { sturges: 'Sturges (1 + log₂ n)', sqrt: 'Square root (√n)', scott: 'Scott (3.49 s n^−⅓)', fd: 'Freedman–Diaconis (2 IQR n^−⅓)', width: 'My own width' }, 'sturges'), width: N('Bin width', 1, 0), start: N('First bin starts at (optional)', 4) },
        show: { width: 'rule:width' },
        when: { width: (x) => x.rule === 'width' },
        optional: ['start'],
        label: 'Bins',
        rows: { width: 'Bin width', n: 'Values', tallest: 'Tallest bin' },
        plots: [['hist', 'Histogram']],
        grids: [['table', 'Bin counts']],
        run: (x) => {
            const r = readData(x.data, 2);

            if (!r.xs) {
                return r;
            }

            const n = r.xs.length;
            const span = Math.max(...r.xs) - Math.min(...r.xs) || 1;
            const f = fiveNumber(r.xs);
            const width = { sturges: span / Math.ceil(Math.log2(n) + 1), sqrt: span / Math.ceil(Math.sqrt(n)), scott: (3.49 * sd(r.xs)) / Math.cbrt(n), fd: (2 * f.iqr) / Math.cbrt(n), width: x.width }[x.rule];

            if (!(width > 0)) {
                return { error: 'The bin width must be positive (the data may have no spread).' };
            }

            if (span / width > 500) {
                return { error: 'That width makes more than 500 bins; use a wider bin.' };
            }

            const start = Number.isFinite(x.start) && x.start <= Math.min(...r.xs) ? x.start : Math.min(...r.xs);
            const { bins } = classes(r.xs, 0, width, start);
            const top = bins.reduce((a, b) => (b.f > a.f ? b : a));

            return { value: num(bins.length), sub: `of width ${num(width, 6)}`, rows: { width: num(width, 6), n: num(n), tallest: `${classText(top, false)}: ${top.f}` }, steps: [`Bin rule: ${{ sturges: 'k = ⌈log₂ n + 1⌉ bins', sqrt: 'k = ⌈√n⌉ bins', scott: 'h = 3.49 s n^(−1/3)', fd: 'h = 2 IQR n^(−1/3)', width: 'your width' }[x.rule]}`, 'Each bin includes its left edge; the last bin also includes its right edge'], plots: { hist: { bars: bins.map((b) => ({ x0: b.from, x1: b.to, y: b.f })), xLabel: 'Value', yLabel: 'Frequency', yMin: 0 } }, grids: { table: { columns: ['Midpoint', 'f', 'Relative', 'Cumulative', 'Cum. relative'], rows: freqRows(bins, n) } } };
        },
    },
    hypergeometric: discTool({ params: { N: N('Population size N', 50, 1), K: N('Successes in the population K', 12, 0), n: N('Draws n (without replacement)', 10, 0) }, build: (x) => ([x.N, x.K, x.n].every(Number.isInteger) && x.K <= x.N && x.n <= x.N ? hypergeometric(x.N, x.K, x.n) : { error: 'Use whole numbers with K ≤ N and n ≤ N.' }), a: 2, b: 4, formula: ['P(X = k) = C(K, k) C(N − K, n − k) ÷ C(N, n)'] }),
    inverse_normal: {
        type: 'calc',
        inputs: { p: N('Probability (area)', 0.95, 0), mean: N('Mean μ', 0), sd: N('Standard deviation σ', 1, 0), tail: SEL('Area', { left: 'Left of x: P(X ≤ x)', right: 'Right of x: P(X ≥ x)', centre: 'Centred between −x and x (symmetric)' }, 'left') },
        label: 'x',
        rows: { z: 'z-score', check: 'Check' },
        plots: [['dist', 'Normal curve with the area shaded']],
        run: (x) => {
            if (!(x.p > 0 && x.p < 1) || !(x.sd > 0)) {
                return { error: 'The probability must be between 0 and 1 and σ positive.' };
            }

            const z = x.tail === 'left' ? normInv(x.p) : x.tail === 'right' ? normInv(1 - x.p) : normInv(0.5 + x.p / 2);
            const v = x.mean + z * x.sd;
            const d = normal(x.mean, x.sd);
            const value = x.tail === 'centre' ? `${num(x.mean - z * x.sd, 8)} to ${num(v, 8)}` : num(v, 8);

            return { value, sub: `z = ${x.tail === 'centre' ? '±' : ''}${num(z, 8)}`, rows: { z: num(z, 10), check: x.tail === 'centre' ? `P(${num(x.mean - z * x.sd, 6)} ≤ X ≤ ${num(v, 6)}) = ${num(d.cdf(v) - d.cdf(x.mean - z * x.sd), 8)}` : `P(X ${x.tail === 'left' ? '≤' : '≥'} ${num(v, 6)}) = ${num(x.tail === 'left' ? d.cdf(v) : d.sf(v), 8)}` }, steps: [`z = Φ⁻¹(${x.tail === 'left' ? num(x.p) : x.tail === 'right' ? `1 − ${num(x.p)}` : `0.5 + ${num(x.p)}/2`}) = ${num(z, 10)} (Wichura AS 241)`, `x = μ + zσ = ${num(x.mean)} + ${num(z, 8)} × ${num(x.sd)} = ${num(v, 10)}`], plots: { dist: distPlot(d, x.tail === 'left' ? 'le' : x.tail === 'right' ? 'ge' : 'between', x.tail === 'centre' ? x.mean - z * x.sd : v, v, { xLabel: 'x' }) } };
        },
    },
    lognormal: contTool({ params: { mu: N('μ (mean of ln X)', 0), sigma: N('σ (SD of ln X)', 0.5, 0) }, build: (x) => positive(x.sigma, 'σ') ?? lognormal(x.mu, x.sigma), a: 1.5, b: 2.5, formula: ['ln X ~ N(μ, σ²): P(X ≤ x) = Φ((ln x − μ) ÷ σ)', 'Mean e^(μ + σ²/2), median e^μ'] }),
    neg_binomial: discTool({ params: { r: N('Successes needed r', 3, 1), p: N('Success probability p', 0.4, 0), form: SEL('Count', { failures: 'Failures before the r-th success (0, 1, …)', trials: 'Trials to the r-th success (r, r + 1, …)' }, 'failures') }, build: (x) => (x.r > 0 ? null : { error: 'r must be positive.' }) ?? prob01(x.p, 'p') ?? negBinomial(x.r, x.p, x.form === 'trials'), a: 4, b: 6, formula: ['P(X = k failures) = C(k + r − 1, k) pʳ (1 − p)ᵏ', 'Cumulative via the regularised incomplete beta function'] }),
    normal: contTool({ params: { mu: N('Mean μ', 0), sigma: N('Standard deviation σ', 1, 0) }, build: (x) => positive(x.sigma, 'σ') ?? normal(x.mu, x.sigma), a: 1.96, b: 1, formula: ['z = (x − μ) ÷ σ; P(X ≤ x) = Φ(z)'] }),
    sampling_mean: {
        type: 'calc',
        inputs: { mu: N('Population mean μ', 500), sigma: N('Population SD σ', 100, 0), n: N('Sample size n', 25, 1), N: N('Population size (0 = very large)', 0, 0), mode: SEL('Find', { le: 'P(x̄ ≤ a)', ge: 'P(x̄ ≥ a)', between: 'P(a ≤ x̄ ≤ b)' }, 'ge'), a: N('a', 530), b: N('b', 540) },
        show: { b: 'mode:between' },
        when: { b: (x) => x.mode === 'between' },
        label: 'Probability',
        rows: { se: 'Standard error of x̄', z: 'z', fpc: 'Finite population correction' },
        plots: [['dist', 'Sampling distribution of x̄']],
        run: (x) => {
            if (!(x.sigma > 0) || !(Number.isInteger(x.n) && x.n >= 1) || (x.N > 0 && x.N < x.n)) {
                return { error: 'σ must be positive and n at most the population size.' };
            }

            const fpc = x.N > 0 ? Math.sqrt((x.N - x.n) / (x.N - 1)) : 1;
            const se = (x.sigma / Math.sqrt(x.n)) * fpc;
            const d = normal(x.mu, se);
            const value = regionProbability(d, x.mode, x.a, x.b);

            return { value: num(value, 6), sub: `${regionText(x.mode, x.a, x.b, (v) => num(v), 'x̄')} = ${pct(value)}`, rows: { se: num(se, 6), z: num((x.a - x.mu) / se, 6), fpc: x.N > 0 ? num(fpc, 6) : 'Not used' }, steps: ['x̄ ~ N(μ, (σ/√n)²) for a normal population (or approximately for large n)', `SE = σ/√n${x.N > 0 ? ' × √((N − n)/(N − 1))' : ''} = ${num(se, 6)}`, `z = (${num(x.a)} − ${num(x.mu)}) ÷ ${num(se, 6)} = ${num((x.a - x.mu) / se, 6)}`], plots: { dist: distPlot(d, x.mode, x.a, x.b, { xLabel: 'Sample mean' }) } };
        },
    },
    pie_chart: {
        type: 'calc',
        inputs: { data: TXT('Categories: label, value (one per line)', 'Rent, 1200\nFood, 450\nTransport, 220\nSavings, 400\nOther, 330') },
        label: 'Total',
        rows: { largest: 'Largest slice', count: 'Slices' },
        plots: [['pie', 'Pie chart']],
        grids: [['table', 'Percentages and angles']],
        run: (x) => {
            const { items, problem } = labelledValues(x.data);

            if (problem) {
                return { error: problem };
            }

            if (!items.length || items.some((i) => i.value < 0)) {
                return { error: 'Enter categories with values of zero or more.' };
            }

            const total = sum(items.map((i) => i.value));

            if (!(total > 0)) {
                return { error: 'The values must add up to more than zero.' };
            }

            const big = items.reduce((a, b) => (b.value > a.value ? b : a));

            return { value: num(total, 8), sub: `${items.length} categories`, rows: { largest: `${big.label}: ${pct(big.value / total, 4)}`, count: num(items.length) }, steps: ['Percentage = value ÷ total × 100', 'Angle = value ÷ total × 360°', `Total = ${num(total, 8)}`], plots: { pie: { kind: 'pie', slices: items } }, grids: { table: { columns: ['Value', 'Percent', 'Angle'], rows: items.map((i) => ({ header: i.label, cells: [num(i.value, 8), pct(i.value / total, 4), `${num((i.value / total) * 360, 5)}°`] })) } } };
        },
    },
    poisson: discTool({ params: { lambda: N('Average rate λ', 4, 0) }, build: (x) => positive(x.lambda, 'λ') ?? poisson(x.lambda), a: 2, b: 5, formula: ['P(X = k) = λᵏ e^(−λ) ÷ k!', 'Cumulative P(X ≤ k) = Q(k + 1, λ), the regularised upper incomplete gamma function'] }),
    rayleigh: contTool({ params: { sigma: N('Scale σ', 2, 0) }, build: (x) => positive(x.sigma, 'σ') ?? rayleigh(x.sigma), a: 3, b: 4, formula: ['f(x) = (x/σ²) e^(−x²/2σ²); P(X ≤ x) = 1 − e^(−x²/2σ²)', 'Mean σ√(π/2), mode σ'] }),
    rel_freq: {
        type: 'calc',
        inputs: { data: TXT('Data (numbers or words)', 'red, blue, red, green, blue, red, yellow, blue, red, green') },
        label: 'Categories',
        rows: { n: 'Observations', top: 'Most frequent' },
        plots: [['bars', 'Relative frequency']],
        grids: [['table', 'Frequency table']],
        run: (x) => {
            const items = splitItems(x.data);

            if (!items.length) {
                return { empty: 'Enter your data.' };
            }

            const numeric = items.every((t) => Number.isFinite(Number(t)));
            const values = numeric ? items.map(Number) : items;
            const m = modes(values);
            const keys = [...m.counts.keys()].sort((a, b) => (numeric ? a - b : 0));
            let cum = 0;

            return { value: num(keys.length), sub: `${items.length} observations`, rows: { n: num(items.length), top: `${m.values.length ? m.values.join(', ') : keys.join(', ')} (${pct(m.count / items.length, 4)})` }, steps: ['Relative frequency = count ÷ total', 'The relative frequencies add up to 1 (100%)'], plots: { bars: { bars: keys.map((k, j) => ({ x: j, y: m.counts.get(k) / items.length })), categories: keys.map(String), yLabel: 'Relative frequency', yMin: 0 } }, grids: { table: { columns: ['Count', 'Relative', 'Cumulative relative'], rows: keys.map((k) => { cum += m.counts.get(k); return { header: String(k), cells: [num(m.counts.get(k)), num(m.counts.get(k) / items.length, 4), num(cum / items.length, 4)] }; }) } } };
        },
    },
    sampling_prop: {
        type: 'calc',
        inputs: { p: N('Population proportion p', 0.4, 0), n: N('Sample size n', 100, 1), mode: SEL('Find', { le: 'P(p̂ ≤ a)', ge: 'P(p̂ ≥ a)', between: 'P(a ≤ p̂ ≤ b)' }, 'ge'), a: N('a', 0.45, 0), b: N('b', 0.5, 0) },
        show: { b: 'mode:between' },
        when: { b: (x) => x.mode === 'between' },
        label: 'Probability',
        rows: { se: 'Standard error √(p(1 − p)/n)', z: 'z for a', check: 'np and n(1 − p)' },
        plots: [['dist', 'Sampling distribution of p̂']],
        run: (x) => {
            if (!(x.p > 0 && x.p < 1) || !Number.isInteger(x.n)) {
                return { error: 'p must be between 0 and 1 and n a whole number.' };
            }

            const se = Math.sqrt((x.p * (1 - x.p)) / x.n);
            const d = normal(x.p, se);
            const value = regionProbability(d, x.mode, x.a, x.b);
            const ok = x.n * x.p >= 10 && x.n * (1 - x.p) >= 10;

            return { value: num(value, 6), sub: `${regionText(x.mode, x.a, x.b, (v) => num(v), 'p̂')} = ${pct(value)}`, rows: { se: num(se, 6), z: num((x.a - x.p) / se, 6), check: `${num(x.n * x.p, 5)} and ${num(x.n * (1 - x.p), 5)}${ok ? ' (both ≥ 10: normal model fine)' : ' (below 10: use the binomial)'}` }, steps: ['p̂ is approximately N(p, p(1 − p)/n) when np and n(1 − p) are at least 10', `SE = √(${num(x.p)} × ${num(1 - x.p)} ÷ ${x.n}) = ${num(se, 6)}`, `z = (${num(x.a)} − ${num(x.p)}) ÷ ${num(se, 6)} = ${num((x.a - x.p) / se, 6)}`], plots: { dist: distPlot(d, x.mode, x.a, x.b, { xLabel: 'Sample proportion' }) } };
        },
    },
    stem_leaf: {
        type: 'calc',
        inputs: { data: TXT('Data', '12, 15, 21, 23, 23, 27, 31, 34, 36, 38, 41, 42, 45, 47, 52, 58, 63'), leaf: SEL('Leaf unit', { auto: 'Automatic', 0.1: '0.1', 1: '1', 10: '10', 100: '100' }, 'auto'), split: SEL('Stems', { one: 'One line per stem', two: 'Split stems (0–4 and 5–9)' }, 'one') },
        label: 'Stems',
        rows: { key: 'Key', n: 'Values', median: 'Median' },
        grids: [['plot', 'Stem-and-leaf plot']],
        run: (x) => {
            const r = readData(x.data);

            if (!r.xs) {
                return r;
            }

            const s = sorted(r.xs);

            if (s[0] < 0) {
                return { error: 'This stem-and-leaf plot takes values of zero or more.' };
            }

            let unit = x.leaf === 'auto' ? 10 ** -placesOf(s) : Number(x.leaf);

            while (x.leaf === 'auto' && (s[s.length - 1] - s[0]) / (10 * unit) > 20) {
                unit *= 10;
            }

            unit = Number(unit.toPrecision(12));

            if ((s[s.length - 1] - s[0]) / (10 * unit) > 200) {
                return { error: 'That leaf unit makes more than 200 stems; choose a larger one.' };
            }

            const scaled = s.map((v) => Math.round(v / unit));
            const stems = new Map();
            scaled.forEach((v) => {
                const stem = Math.floor(v / 10);
                const lf = ((v % 10) + 10) % 10;
                const key = x.split === 'two' ? `${stem}${lf < 5 ? 'a' : 'b'}` : String(stem);
                stems.set(key, [...(stems.get(key) ?? []), lf]);
            });
            const minStem = Math.floor(scaled[0] / 10);
            const maxStem = Math.floor(scaled[scaled.length - 1] / 10);
            const rows = [];

            for (let stem = minStem; stem <= maxStem; stem += 1) {
                for (const half of x.split === 'two' ? ['a', 'b'] : ['']) {
                    const key = `${stem}${half}`;
                    rows.push({ header: x.split === 'two' ? `${stem}${half === 'a' ? '·' : '*'}` : String(stem), cells: [(stems.get(key) ?? []).join(' ')] });
                }
            }

            return { value: num(rows.length), sub: `${num(r.xs.length)} values`, rows: { key: `${minStem} | ${(((scaled[0] % 10) + 10) % 10)} means ${num(scaled[0] * unit, 8)}`, n: num(r.xs.length), median: num(quantile(s, 0.5), 8) }, steps: [`Leaf unit ${num(unit)}: each value is rounded to the leaf unit, its last digit is the leaf and the rest is the stem`, x.split === 'two' ? 'Split stems: · holds leaves 0–4 and * holds leaves 5–9' : 'Every stem between the smallest and largest is listed, even if it has no leaves'], grids: { plot: { columns: ['Leaves'], rows, roomy: true } } };
        },
    },
    uniform: contTool({ params: { lo: N('Minimum a', 0), hi: N('Maximum b', 10) }, build: (x) => (x.hi > x.lo ? uniform(x.lo, x.hi) : { error: 'The maximum must be larger than the minimum.' }), a: 3, b: 7, formula: ['f(x) = 1 ÷ (b − a) on [a, b]; P(X ≤ x) = (x − a) ÷ (b − a)', 'Mean (a + b)/2, variance (b − a)²/12'] }),
    ucl: {
        type: 'calc',
        inputs: { chart: SEL('Chart', { xbar_r: 'X̄ and R (subgroups)', xbar_s: 'X̄ and S (subgroups)', imr: 'Individuals and moving range', summary: 'From a mean, SD and subgroup size' }, 'xbar_r'), subgroups: TXT('Subgroups: one per line', '10.2, 10.4, 9.9, 10.1, 10.0\n10.3, 10.1, 10.2, 9.8, 10.0\n9.9, 10.0, 10.2, 10.1, 10.3\n10.1, 10.4, 10.0, 9.9, 10.2'), values: TXT('Individual values', '20.1, 19.8, 20.4, 20.0, 19.7, 20.3, 20.2, 19.9, 20.5, 20.0'), mean: N('Process mean', 50), sd: N('Process standard deviation', 2, 0), n: N('Subgroup size', 4, 1), k: N('Sigma multiplier', 3, 0) },
        show: { subgroups: 'chart:xbar_r,xbar_s', values: 'chart:imr', mean: 'chart:summary', sd: 'chart:summary', n: 'chart:summary' },
        when: { mean: (x) => x.chart === 'summary', sd: (x) => x.chart === 'summary', n: (x) => x.chart === 'summary' },
        data: ['control_charts'],
        label: 'Upper control limit (UCL)',
        rows: { centre: 'Centre line', lcl: 'Lower control limit (LCL)', spread: 'Spread chart limits', out: 'Points outside the limits' },
        plots: [['chart', 'Control chart']],
        run: (x, ctx) => {
            const C = ctx.c.data.statistics?.control_charts ?? {};
            const k = x.k;

            if (x.chart === 'summary') {
                if (!(x.sd > 0 && x.n >= 1)) {
                    return { error: 'The SD must be positive and the subgroup size at least 1.' };
                }

                const half = (k * x.sd) / Math.sqrt(x.n);

                return { value: num(x.mean + half, 8), sub: `Mean ± ${num(k)}σ/√n`, rows: { centre: num(x.mean, 8), lcl: num(x.mean - half, 8), spread: '—', out: '—' }, steps: [`UCL = μ + ${num(k)}σ/√n = ${num(x.mean)} + ${num(k)} × ${num(x.sd)} ÷ √${x.n} = ${num(x.mean + half, 8)}`, `LCL = μ − ${num(k)}σ/√n = ${num(x.mean - half, 8)}`] };
            }

            if (x.chart === 'imr') {
                const r = readData(x.values, 2);

                if (!r.xs) {
                    return r;
                }

                const mr = r.xs.slice(1).map((v, i) => Math.abs(v - r.xs[i]));
                const xbar = mean(r.xs);
                const mrbar = mean(mr);
                const d2 = C[2]?.d2 ?? 1.1284;
                const ucl = xbar + (k * mrbar) / d2;
                const lcl = xbar - (k * mrbar) / d2;
                const out = r.xs.filter((v) => v > ucl || v < lcl).length;

                return { value: num(ucl, 8), sub: `Individuals chart, ${r.xs.length} points`, rows: { centre: num(xbar, 8), lcl: num(lcl, 8), spread: `MR chart: UCL ${num((C[2]?.D4 ?? 3.2665) * mrbar, 6)}, centre ${num(mrbar, 6)}`, out: num(out) }, steps: [`Average moving range MR̄ = ${num(mrbar, 8)}`, `σ estimate = MR̄ ÷ d₂ = ${num(mrbar, 6)} ÷ ${num(d2, 5)}`, `UCL = x̄ + ${num(k)} MR̄/d₂ = ${num(ucl, 8)}; LCL = ${num(lcl, 8)}`], plots: { chart: { series: r.xs.map((v, i) => [i + 1, v]), extra: [[[1, ucl], [r.xs.length, ucl]], [[1, lcl], [r.xs.length, lcl]], [[1, xbar], [r.xs.length, xbar]]], markers: r.xs.map((v, i) => ({ x: i + 1, y: v })), xLabel: 'Observation', yLabel: 'Value' } } };
            }

            const groups = String(x.subgroups ?? '').split(/\r?\n/).map((l) => parseNumbers(l).values).filter((g) => g.length);
            const n = groups[0]?.length;

            if (groups.length < 2 || groups.some((g) => g.length !== n) || n < 2 || n > 25) {
                return { error: 'Enter at least 2 subgroups, each with the same size (2 to 25 values).' };
            }

            const c = C[n];
            const means = groups.map(mean);
            const xbarbar = mean(means);
            let ucl;
            let lcl;
            let spread;
            let steps;

            if (x.chart === 'xbar_r') {
                const rbar = mean(groups.map((g) => Math.max(...g) - Math.min(...g)));
                const a2 = (k / 3) * c.A2;
                [ucl, lcl] = [xbarbar + a2 * rbar, xbarbar - a2 * rbar];
                spread = `R chart: UCL ${num(c.D4 * rbar, 6)}, centre ${num(rbar, 6)}, LCL ${num(c.D3 * rbar, 6)}`;
                steps = [`Grand mean X̄̄ = ${num(xbarbar, 8)}; average range R̄ = ${num(rbar, 8)}`, `A₂ = ${c.A2} for subgroups of ${n}`, `UCL = X̄̄ + A₂R̄ = ${num(ucl, 8)}; LCL = X̄̄ − A₂R̄ = ${num(lcl, 8)}`];
            } else {
                const sbar = mean(groups.map((g) => sd(g)));
                const a3 = (k / 3) * c.A3;
                [ucl, lcl] = [xbarbar + a3 * sbar, xbarbar - a3 * sbar];
                spread = `S chart: UCL ${num(c.B4 * sbar, 6)}, centre ${num(sbar, 6)}, LCL ${num(c.B3 * sbar, 6)}`;
                steps = [`Grand mean X̄̄ = ${num(xbarbar, 8)}; average SD S̄ = ${num(sbar, 8)}`, `A₃ = ${c.A3} for subgroups of ${n}`, `UCL = X̄̄ + A₃S̄ = ${num(ucl, 8)}; LCL = X̄̄ − A₃S̄ = ${num(lcl, 8)}`];
            }

            const out = means.filter((v) => v > ucl || v < lcl).length;

            return { value: num(ucl, 8), sub: `X̄ chart, ${groups.length} subgroups of ${n}`, rows: { centre: num(xbarbar, 8), lcl: num(lcl, 8), spread, out: num(out) }, steps: [...steps, 'Constants computed from the normal distribution; they match ASTM E2587 / Montgomery’s tables', 'Limits describe the process’s own variation; they are not specification limits'], plots: { chart: { series: means.map((v, i) => [i + 1, v]), extra: [[[1, ucl], [means.length, ucl]], [[1, lcl], [means.length, lcl]], [[1, xbarbar], [means.length, xbarbar]]], markers: means.map((v, i) => ({ x: i + 1, y: v })), xLabel: 'Subgroup', yLabel: 'Subgroup mean' } } };
        },
    },
    weibull: contTool({ params: { k: N('Shape k', 1.5, 0), lambda: N('Scale λ', 10, 0) }, build: (x) => positive(x.k, 'k') ?? positive(x.lambda, 'λ') ?? weibull(x.k, x.lambda), a: 8, b: 12, formula: ['P(X ≤ x) = 1 − e^(−(x/λ)^k); reliability R(x) = e^(−(x/λ)^k)', 'Hazard rate h(x) = (k/λ)(x/λ)^(k − 1): falling for k < 1, constant for k = 1, rising for k > 1'] }),
    t_dist: contTool({ params: { df: N('Degrees of freedom', 10, 0) }, build: (x) => positive(x.df, 'Degrees of freedom') ?? studentT(x.df), a: 2.228, b: 3, xLabel: 't', p: 0.975, formula: ['P(T ≤ t) from the regularised incomplete beta function: tail = ½ I_(df/(df + t²))(df/2, ½)'] }),
    f_dist: contTool({ params: { d1: N('Numerator df', 3, 0), d2: N('Denominator df', 20, 0) }, build: (x) => positive(x.d1, 'Numerator df') ?? positive(x.d2, 'Denominator df') ?? fisherF(x.d1, x.d2), a: 3.1, b: 4, xLabel: 'F', formula: ['P(F ≤ f) = I_(d₁f/(d₁f + d₂))(d₁/2, d₂/2)'] }),
    gamma_dist: contTool({ params: { shape: N('Shape k', 2, 0), scale: N('Scale θ (1/rate)', 3, 0) }, build: (x) => positive(x.shape, 'Shape') ?? positive(x.scale, 'Scale') ?? gammaDist(x.shape, x.scale), a: 5, b: 10, formula: ['f(x) = x^(k−1) e^(−x/θ) ÷ (Γ(k) θᵏ)', 'P(X ≤ x) = P(k, x/θ), the regularised lower incomplete gamma function; mean kθ'] }),
    multinomial: {
        type: 'calc',
        inputs: { data: TXT('Categories: probability, count (one per line)', '0.5, 3\n0.3, 2\n0.2, 1') },
        label: 'P(exactly these counts)',
        rows: { n: 'Total trials n', expected: 'Expected counts', ways: 'Arrangements n!/∏xᵢ!' },
        run: (x) => {
            const rows = String(x.data ?? '').split(/\r?\n/).map((l) => parseNumbers(l).values).filter((r) => r.length);

            if (rows.length < 2 || rows.some((r) => r.length !== 2 || r[0] < 0 || r[0] > 1 || r[1] < 0 || !Number.isInteger(r[1]))) {
                return { error: 'Enter at least two lines of a probability (0–1) and a whole-number count.' };
            }

            const total = sum(rows.map((r) => r[0]));

            if (Math.abs(total - 1) > 1e-6) {
                return { error: `The probabilities add up to ${num(total, 8)}; they must add up to 1.` };
            }

            const n = sum(rows.map((r) => r[1]));
            const logWays = lfact(n) - sum(rows.map((r) => lfact(r[1])));
            const logP = logWays + sum(rows.map(([p, c]) => (c ? c * Math.log(p) : 0)));
            const p = Math.exp(logP);

            return { value: num(p, 8), sub: pct(p), rows: { n: num(n), expected: rows.map(([pp]) => num(n * pp, 5)).join(', '), ways: num(Math.exp(logWays), 8) }, steps: ['P = n! ÷ (x₁! x₂! … x_k!) × p₁^x₁ p₂^x₂ … p_k^x_k', `= ${num(Math.exp(logWays), 8)} × ${rows.map(([pp, c]) => `${num(pp)}^${c}`).join(' × ')}`, `= ${num(p, 10)}`] };
        },
    },
    ogive: {
        type: 'calc',
        inputs: { data: TXT('Data', '23, 29, 31, 35, 36, 38, 41, 42, 44, 45, 47, 49, 52, 55, 58, 61, 63, 67, 72, 78'), k: N('Number of classes (0 = Sturges)', 6, 0), width: N('Class width (optional)', 10, 0), start: N('First class starts at (optional)', 20) },
        optional: ['width', 'start'],
        label: 'Median read from the ogive',
        rows: { q1: 'Lower quartile', q3: 'Upper quartile', n: 'Values' },
        plots: [['ogive', 'Cumulative frequency (ogive)']],
        grids: [['table', 'Cumulative frequency']],
        run: (x) => {
            const r = readData(x.data, 2);

            if (!r.xs) {
                return r;
            }

            const { bins } = classes(r.xs, x.k, x.width, x.start);
            const n = r.xs.length;
            const pts = [[bins[0].from, 0]];
            let cum = 0;
            bins.forEach((b) => {
                cum += b.f;
                pts.push([b.to, cum]);
            });
            const read = (target) => {
                for (let j = 1; j < pts.length; j += 1) {
                    if (pts[j][1] >= target) {
                        const [x0, c0] = pts[j - 1];
                        const [x1, c1] = pts[j];

                        return c1 === c0 ? x0 : x0 + ((target - c0) / (c1 - c0)) * (x1 - x0);
                    }
                }

                return pts[pts.length - 1][0];
            };
            const med = read(n / 2);

            return { value: num(med, 6), sub: `at cumulative frequency n/2 = ${num(n / 2)}`, rows: { q1: num(read(n / 4), 6), q3: num(read((3 * n) / 4), 6), n: num(n) }, steps: ['Plot cumulative frequency at each upper class boundary, starting from zero at the first lower boundary', 'Read the median at n/2 and the quartiles at n/4 and 3n/4 by linear interpolation', 'Grouped estimates differ slightly from the exact data median'], plots: { ogive: { series: pts, markers: [{ x: med, y: n / 2, label: 'median' }], xLabel: 'Upper class boundary', yLabel: 'Cumulative frequency', yMin: 0 } }, grids: { table: { columns: ['Upper boundary', 'Cumulative f'], rows: pts.map(([b, c], j) => ({ header: j ? classText(bins[j - 1], j === bins.length) : 'Start', cells: [num(b, 6), num(c)] })) } } };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
