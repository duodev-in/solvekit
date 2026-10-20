import { defineTools } from '../engines/formula.js';
import { handlersFor } from '../physics/core.js';
import { N, SEL, TXT, num, pct, pText } from '../statistics/common.js';
import { mean, median, parseNumbers, parsePairs, parseRows, readData, sd, splitItems, sum } from '../statistics/data.js';
import { binomial, chiSquare, distPlot, fisherF, normal, poisson, regionProbability, studentT } from '../statistics/dist.js';
import { curve, intervals, ols, polyRow } from '../statistics/reg.js';
import { fInv, normCdf, normInv, normSf, tInv } from '../statistics/special.js';
import { TAILS, anova, decision, fisherExact, hypotheses, kruskalWallis, mannWhitney, mcnemar, signTest, signedRank, tCrit, tOne, tP, tPower, tSampleSize, tTwo, zCrit, zP } from '../statistics/tests.js';

/**
 * Inference, regression and statistical tests, plus sample size, entropy, Markov chains and the z-table.
 * p-values follow R's conventions (exact rank tests for small untied samples, Welch t by default).
 */

const ALPHA = N('Significance level α', 0.05, 0);
const TAIL = SEL('Alternative hypothesis', TAILS, 'two');
const PAIRS = (value = '1, 2.1\n2, 3.9\n3, 6.2\n4, 7.8\n5, 9.9\n6, 12.3\n7, 13.8\n8, 16.1') => TXT('x, y pairs (one per line)', value);
const SAMPLE_A = '12.1, 14.3, 11.8, 15.2, 13.6, 12.9, 14.8, 13.3';
const SAMPLE_B = '15.4, 16.2, 14.9, 17.8, 15.9, 16.6, 18.1, 15.2, 16.9';

const alphaOk = (a) => a > 0 && a < 1;

/** Reads a data box into numbers or returns the problem outcome (with a label for the message). */
function sample(text, min, label) {
    const r = readData(text, min);

    if (r.error) {
        return { error: `${label}: ${r.error}` };
    }

    if (r.empty) {
        return { empty: `${label}: enter at least ${min} values.` };
    }

    return r;
}

/** Plot of a test statistic's distribution with the p-value region shaded. */
function testPlot(d, stat, tail, xLabel) {
    if (tail === 'two') {
        const a = Math.abs(stat);

        return distPlot(d, 'outside', -a, a, { xLabel, lo: Math.min(d.lo, -a * 1.1), hi: Math.max(d.hi, a * 1.1) });
    }

    return distPlot(d, tail === 'left' ? 'le' : 'ge', stat, 0, { xLabel, lo: Math.min(d.lo, stat * 1.1), hi: Math.max(d.hi, stat * 1.1) });
}

/** A regression page for a model given by its design-row builder. */
function regTool({ inputs = {}, build, label, sample: example = '1, 2.1\n2, 3.9\n3, 6.2\n4, 7.8\n5, 9.9\n6, 12.3\n7, 13.8\n8, 16.1', plotTitle = 'Data and fitted curve' }) {
    return {
        type: 'calc',
        inputs: { data: PAIRS(example), ...inputs, at: N('Predict y at x (optional)', 9) },
        optional: ['at'],
        label,
        rows: { equation: 'Equation', r2: 'R²', adj: 'Adjusted R²', se: 'Residual standard error', prediction: 'Prediction at x', ci: 'Confidence interval (mean response)', pi: 'Prediction interval (new value)' },
        plots: [['fit', plotTitle]],
        grids: [['coef', 'Coefficients']],
        run: (x) => {
            const p = parsePairs(x.data);

            if (p.problem) {
                return { error: p.problem };
            }

            const model = build(x, p);

            if (model.error) {
                return model;
            }

            const fit = ols(model.X, model.y);

            if (fit.problem) {
                return { error: fit.problem };
            }

            const f = (v) => model.predict(fit.beta, v);
            const pred = Number.isFinite(x.at) ? f(x.at) : NaN;
            const row0 = Number.isFinite(pred) ? model.row(x.at) : null;
            const iv = row0 && row0.every(Number.isFinite) ? intervals(fit, row0, (x.conf ?? 95) / 100) : null;
            const back = model.back ?? ((v) => v);
            const ivText = (pair) => (iv ? `${num(back(pair[0]), 6)} to ${num(back(pair[1]), 6)}` : 'Enter an x value');

            return { value: model.equation(fit.beta), sub: `R² = ${num(fit.r2, 6)}`, rows: { equation: model.equation(fit.beta), r2: num(fit.r2, 8), adj: num(fit.adj, 8), se: num(fit.sigma, 6), prediction: Number.isFinite(pred) ? num(pred, 8) : 'Enter an x value', ci: iv ? ivText(iv.ci) : 'Enter an x value', pi: iv ? ivText(iv.pi) : 'Enter an x value' }, steps: [...model.steps, `Fitted by least squares (QR decomposition) on ${p.x.length} points`, `F = ${num(fit.F, 6)} with ${fit.dfm} and ${fit.dfe} df, p = ${pText(fit.pF)}`, ...(model.note ? [model.note] : [])], plots: { fit: { scatter: p.x.map((v, i) => [v, p.y[i]]), series: curve(f, [...p.x, ...(Number.isFinite(x.at) ? [x.at] : [])]).filter(([, y]) => Number.isFinite(y)), ...(Number.isFinite(pred) ? { markers: [{ x: x.at, y: pred, label: 'prediction' }] } : {}), xLabel: 'x', yLabel: 'y' } }, grids: { coef: { columns: ['Estimate', 'Std. error', 't', 'p-value'], rows: fit.beta.map((b, j) => ({ header: model.names[j], cells: [num(b, 8), num(fit.se[j], 6), num(fit.t[j], 5), pText(fit.p[j])] })) } } };
        },
    };
}

/** Polynomial model of a given degree. */
const polyModel = (degree) => (x, p) => {
    if (p.x.length < degree + 2) {
        return { error: `Enter at least ${degree + 2} points for a degree-${degree} fit.` };
    }

    return {
        X: p.x.map((v) => polyRow(v, degree)),
        row: (v) => polyRow(v, degree),
        y: p.y,
        predict: (beta, v) => beta.reduce((t, b, j) => t + b * v ** j, 0),
        equation: (beta) => `y = ${beta.map((b, j) => ({ b, j })).reverse().map(({ b, j }, k) => `${k ? (b < 0 ? ' − ' : ' + ') : b < 0 ? '−' : ''}${num(Math.abs(b), 6)}${j === 0 ? '' : j === 1 ? 'x' : `x${'⁰¹²³⁴⁵⁶⁷⁸⁹'[j]}`}`).join('')}`,
        names: Array.from({ length: degree + 1 }, (_, j) => (j === 0 ? 'Intercept' : j === 1 ? 'x' : `x${'⁰¹²³⁴⁵⁶⁷⁸⁹'[j]}`)),
        steps: [`Model: y = ${Array.from({ length: degree + 1 }, (_, j) => (j === 0 ? 'b₀' : `b${'₀₁₂₃₄₅₆₇₈₉'[j]}x${j > 1 ? '⁰¹²³⁴⁵⁶⁷⁸⁹'[j] : ''}`)).join(' + ')}`],
        note: degree >= 3 ? 'High-degree polynomials can swing wildly outside the data; do not extrapolate far' : '',
    };
};

/** Shannon entropy of probabilities in a base. */
const entropy = (ps, base) => -sum(ps.filter((p) => p > 0).map((p) => p * Math.log(p))) / Math.log(base);

/** Matrix × vector helpers for Markov chains. */
const step = (dist, P) => P[0].map((_, j) => sum(dist.map((d, i) => d * P[i][j])));

export const TOOLS = {
    abs_uncertainty: {
        type: 'calc',
        inputs: { mode: SEL('From', { relative: 'A value and its relative (%) uncertainty', readings: 'Repeated readings' }, 'relative'), value: N('Measured value', 25.4), rel: N('Relative uncertainty (%)', 2, 0), data: TXT('Readings', '9.8, 10.1, 9.9, 10.3, 10.0') },
        show: { value: 'mode:relative', rel: 'mode:relative', data: 'mode:readings' },
        when: { value: (x) => x.mode === 'relative', rel: (x) => x.mode === 'relative' },
        label: 'Result with absolute uncertainty',
        rows: { abs: 'Absolute uncertainty', rel: 'Relative uncertainty', se: 'Standard error (readings)' },
        run: (x) => {
            if (x.mode === 'readings') {
                const r = readData(x.data, 2);

                if (!r.xs) {
                    return r;
                }

                const m = mean(r.xs);
                const half = (Math.max(...r.xs) - Math.min(...r.xs)) / 2;

                return { value: `${num(m, 6)} ± ${num(half, 3)}`, sub: 'Mean ± half the range', rows: { abs: num(half, 6), rel: pct(half / Math.abs(m), 4), se: num(sd(r.xs) / Math.sqrt(r.xs.length), 6) }, steps: [`Mean = ${num(m, 8)}`, `Absolute uncertainty = (max − min) ÷ 2 = (${num(Math.max(...r.xs))} − ${num(Math.min(...r.xs))}) ÷ 2 = ${num(half, 8)}`, 'Half the range is the usual school-lab rule; the standard error is the statistical alternative'] };
            }

            const abs = Math.abs(x.value) * (x.rel / 100);

            return { value: `${num(x.value, 8)} ± ${num(abs, 3)}`, sub: `${num(x.rel)}% of ${num(x.value)}`, rows: { abs: num(abs, 8), rel: `${num(x.rel)}%`, se: 'Needs repeated readings' }, steps: ['Absolute uncertainty = |value| × relative uncertainty', `= ${num(Math.abs(x.value))} × ${num(x.rel / 100)} = ${num(abs, 8)}`, 'Quote the uncertainty to 1–2 significant figures and round the value to match'] };
        },
    },
    ab_test: {
        type: 'calc',
        inputs: { nA: N('Visitors to A (control)', 5000, 1), cA: N('Conversions in A', 400, 0), nB: N('Visitors to B (variant)', 5000, 1), cB: N('Conversions in B', 460, 0), conf: N('Confidence level (%)', 95, 0), tail: SEL('Test', { two: 'Two-sided (B ≠ A)', right: 'One-sided (B > A)' }, 'two') },
        label: 'p-value',
        rows: { rates: 'Conversion rates A and B', uplift: 'Relative uplift', ci: 'Difference B − A (CI)', z: 'z', verdict: 'Result' },
        run: (x) => {
            if (x.cA > x.nA || x.cB > x.nB) {
                return { error: 'Conversions cannot exceed visitors.' };
            }

            const pA = x.cA / x.nA;
            const pB = x.cB / x.nB;
            const pool = (x.cA + x.cB) / (x.nA + x.nB);
            const se0 = Math.sqrt(pool * (1 - pool) * (1 / x.nA + 1 / x.nB));
            const z = (pB - pA) / se0;
            const p = zP(z, x.tail);
            const alpha = 1 - x.conf / 100;
            const se = Math.sqrt((pA * (1 - pA)) / x.nA + (pB * (1 - pB)) / x.nB);
            const zc = normInv(1 - alpha / 2);
            const significant = p < alpha;

            return { value: pText(p), sub: significant ? `Significant at ${num(x.conf)}%: B ${pB > pA ? 'beats' : 'trails'} A` : `Not significant at ${num(x.conf)}%`, rows: { rates: `${pct(pA, 4)} and ${pct(pB, 4)}`, uplift: pA > 0 ? pct((pB - pA) / pA, 4) : '—', ci: `${pct(pB - pA, 4)} (${pct(pB - pA - zc * se, 4)} to ${pct(pB - pA + zc * se, 4)})`, z: num(z, 6), verdict: significant ? 'The difference is unlikely to be chance' : 'Keep testing or accept no detectable difference' }, steps: ['Two-proportion z-test with the pooled proportion under H₀: pA = pB', `Pooled p = (${num(x.cA)} + ${num(x.cB)}) ÷ (${num(x.nA)} + ${num(x.nB)}) = ${num(pool, 6)}`, `SE = √(p(1 − p)(1/nA + 1/nB)) = ${num(se0, 6)}`, `z = (${num(pB, 6)} − ${num(pA, 6)}) ÷ ${num(se0, 6)} = ${num(z, 6)}`, 'Decide the sample size before the test; stopping as soon as p dips below α inflates false positives'] };
        },
    },
    anova: {
        type: 'calc',
        inputs: { data: TXT('Groups: one per line, optionally named (“Diet A: 4.2, 5.1, …”)', 'Diet A: 4.2, 5.1, 3.8, 4.9, 5.4\nDiet B: 6.1, 5.8, 6.9, 7.2, 6.4\nDiet C: 5.0, 4.6, 5.9, 5.3, 4.8'), alpha: ALPHA },
        label: 'F statistic',
        rows: { p: 'p-value', eta: 'η² (effect size)', crit: 'Critical F', verdict: 'Decision' },
        grids: [['table', 'ANOVA table'], ['groups', 'Group summaries']],
        run: (x) => {
            const groups = [];

            for (const [index, line] of String(x.data ?? '').split(/\r?\n/).map((l) => l.trim()).filter(Boolean).entries()) {
                const m = line.match(/^([^:]*[A-Za-z][^:]*):(.*)$/);
                const { values, bad } = parseNumbers(m ? m[2] : line);

                if (bad.length) {
                    return { error: `Line ${index + 1}: these are not numbers: ${bad.slice(0, 4).join(', ')}.` };
                }

                if (values.length) {
                    groups.push({ name: m ? m[1].trim() : `Group ${index + 1}`, values });
                }
            }

            if (groups.length < 2 || groups.some((g) => g.values.length < 2)) {
                return { error: 'Enter at least two groups with two or more values each.' };
            }

            const a = anova(groups.map((g) => g.values));
            const crit = fInv(1 - x.alpha, a.dfb, a.dfw);

            return { value: num(a.F, 6), sub: `p = ${pText(a.p)}`, rows: { p: pText(a.p), eta: num(a.eta2, 5), crit: num(crit, 6), verdict: decision(a.p, x.alpha) }, steps: ['H₀: all group means are equal; H₁: at least one differs', 'F = (between-group mean square) ÷ (within-group mean square)', `F = ${num(a.msb, 8)} ÷ ${num(a.msw, 8)} = ${num(a.F, 8)}`, 'Assumes independent, roughly normal groups with similar variances; a significant F says some means differ, not which (use a post-hoc test)'], grids: { table: { columns: ['SS', 'df', 'MS', 'F', 'p'], rows: [{ header: 'Between groups', cells: [num(a.ssb, 8), num(a.dfb), num(a.msb, 8), num(a.F, 6), pText(a.p)] }, { header: 'Within groups', cells: [num(a.ssw, 8), num(a.dfw), num(a.msw, 8), '', ''] }, { header: 'Total', cells: [num(a.sst, 8), num(a.dfb + a.dfw), '', '', ''] }] }, groups: { columns: ['n', 'Mean', 'SD'], rows: groups.map((g) => ({ header: g.name, cells: [num(g.values.length), num(mean(g.values), 6), num(sd(g.values), 6)] })) } } };
        },
    },
    bonferroni: {
        type: 'calc',
        inputs: { alpha: N('Family-wise α', 0.05, 0), m: N('Number of tests', 5, 1), pvalues: TXT('p-values (optional, one per test)', '0.003, 0.012, 0.02, 0.04, 0.3') },
        optional: ['pvalues'],
        label: 'Bonferroni-corrected α',
        rows: { sidak: 'Šidák α', bonf: 'Significant (Bonferroni)', holm: 'Significant (Holm)' },
        grids: [['table', 'Each p-value']],
        run: (x) => {
            const { values } = parseNumbers(x.pvalues);
            const m = values.length || x.m;

            if (!alphaOk(x.alpha) || !(m >= 1) || values.some((p) => p < 0 || p > 1)) {
                return { error: 'α must be between 0 and 1, and p-values between 0 and 1.' };
            }

            const bonf = x.alpha / m;
            const order = values.map((p, i) => ({ p, i })).sort((a, b) => a.p - b.p);
            const holm = new Array(values.length).fill(false);

            for (const [k, item] of order.entries()) {
                if (item.p <= x.alpha / (m - k)) {
                    holm[item.i] = true;
                } else {
                    break;
                }
            }

            return { value: num(bonf, 6), sub: `α ÷ ${m} tests`, rows: { sidak: num(1 - (1 - x.alpha) ** (1 / m), 6), bonf: values.length ? `${values.filter((p) => p <= bonf).length} of ${m}` : 'Enter p-values', holm: values.length ? `${holm.filter(Boolean).length} of ${m}` : 'Enter p-values' }, steps: ['Bonferroni: test each hypothesis at α/m, keeping the chance of any false positive at most α', 'Holm (1979): sort p-values; compare the k-th smallest with α/(m − k + 1) and stop at the first failure (never less powerful than Bonferroni)', `Šidák: 1 − (1 − α)^(1/m) for independent tests`], grids: { table: { columns: ['Holm threshold', 'Bonferroni', 'Holm'], rows: values.map((p, i) => ({ header: `p = ${num(p, 4)}`, cells: [num(x.alpha / (m - order.findIndex((o) => o.i === i)), 4), p <= bonf ? 'Significant' : 'Not significant', holm[i] ? 'Significant' : 'Not significant'] })) } } };
        },
    },
    r_squared: {
        type: 'calc',
        inputs: { mode: SEL('From', { pairs: 'x, y data (straight-line fit)', predicted: 'Observed and predicted values' }, 'pairs'), data: PAIRS(), observed: TXT('Observed', '3, 5, 7, 10, 12'), predicted: TXT('Predicted', '2.8, 5.3, 7.1, 9.6, 12.2'), k: N('Predictors in the model (for adjusted R²)', 1, 1) },
        show: { data: 'mode:pairs', observed: 'mode:predicted', predicted: 'mode:predicted', k: 'mode:predicted' },
        label: 'R²',
        rows: { adj: 'Adjusted R²', r: 'r (Pearson, pairs)', ss: 'SS residual and SS total' },
        run: (x) => {
            let y;
            let yhat;
            let k = x.k;
            let r = NaN;

            if (x.mode === 'pairs') {
                const p = parsePairs(x.data);

                if (p.problem) {
                    return { error: p.problem };
                }

                const fit = ols(p.x.map((v) => [1, v]), p.y);

                if (fit.problem) {
                    return { error: fit.problem };
                }

                [y, yhat, k] = [p.y, fit.fitted, 1];
                r = Math.sign(fit.beta[1]) * Math.sqrt(fit.r2);
            } else {
                y = parseNumbers(x.observed).values;
                yhat = parseNumbers(x.predicted).values;

                if (y.length < 3 || y.length !== yhat.length) {
                    return { error: 'Enter the same number (3 or more) of observed and predicted values.' };
                }
            }

            const m = mean(y);
            const sst = sum(y.map((v) => (v - m) ** 2));
            const sse = sum(y.map((v, i) => (v - yhat[i]) ** 2));
            const r2 = 1 - sse / sst;
            const n = y.length;

            return { value: num(r2, 8), sub: `${pct(Math.max(0, r2), 4)} of the variation in y is explained`, rows: { adj: n - k - 1 > 0 ? num(1 - ((1 - r2) * (n - 1)) / (n - k - 1), 8) : 'Needs more points', r: Number.isFinite(r) ? num(r, 8) : '—', ss: `${num(sse, 8)} and ${num(sst, 8)}` }, steps: ['R² = 1 − SS_res ÷ SS_tot', `= 1 − ${num(sse, 8)} ÷ ${num(sst, 8)} = ${num(r2, 8)}`, 'Adjusted R² = 1 − (1 − R²)(n − 1) ÷ (n − k − 1) penalises extra predictors', 'A high R² does not prove the model is right; check the residuals'] };
        },
    },
    critical_value: {
        type: 'calc',
        inputs: { dist: SEL('Distribution', { z: 'Standard normal (z)', t: 'Student t', chi2: 'Chi-square (χ²)', f: 'F' }, 'z'), alpha: ALPHA, tail: TAIL, df1: N('Degrees of freedom (df₁)', 10, 0), df2: N('Denominator df (df₂, F only)', 20, 0) },
        show: { df1: 'dist:t,chi2,f', df2: 'dist:f' },
        when: { df1: (x) => x.dist !== 'z', df2: (x) => x.dist === 'f' },
        label: 'Critical value',
        rows: { region: 'Rejection region', confidence: 'Matching confidence level' },
        plots: [['dist', 'Rejection region']],
        run: (x) => {
            if (!alphaOk(x.alpha)) {
                return { error: 'α must be between 0 and 1.' };
            }

            const a = x.alpha;
            const d = { z: normal(0, 1), t: studentT(x.df1), chi2: chiSquare(x.df1), f: fisherF(x.df1, x.df2) }[x.dist];
            const inv = (p) => d.inv(p);
            let value;
            let region;
            let plot;

            if (x.tail === 'two') {
                const lo = inv(a / 2);
                const hi = inv(1 - a / 2);
                value = x.dist === 'z' || x.dist === 't' ? `±${num(hi, 6)}` : `${num(lo, 6)} and ${num(hi, 6)}`;
                region = `statistic < ${num(lo, 6)} or > ${num(hi, 6)}`;
                plot = distPlot(d, 'outside', lo, hi, { xLabel: x.dist === 'chi2' ? 'χ²' : x.dist });
            } else if (x.tail === 'left') {
                const c = inv(a);
                value = num(c, 6);
                region = `statistic < ${num(c, 6)}`;
                plot = distPlot(d, 'le', c, 0, { xLabel: x.dist });
            } else {
                const c = inv(1 - a);
                value = num(c, 6);
                region = `statistic > ${num(c, 6)}`;
                plot = distPlot(d, 'ge', c, 0, { xLabel: x.dist });
            }

            return { value, sub: `${TAILS[x.tail]}, α = ${num(a)}`, rows: { region, confidence: pct(1 - a, 4) }, steps: [`The critical value cuts off ${x.tail === 'two' ? 'α/2 in each tail' : 'α in one tail'} of the ${x.dist === 'z' ? 'standard normal' : x.dist === 't' ? `t distribution with ${num(x.df1)} df` : x.dist === 'chi2' ? `χ² distribution with ${num(x.df1)} df` : `F(${num(x.df1)}, ${num(x.df2)}) distribution`}`, 'Computed from the inverse CDF (no table lookup)'], plots: { dist: plot } };
        },
    },
    cubic_reg: regTool({ build: polyModel(3), label: 'Cubic fit', sample: '-2, -6.1\n-1, 0.8\n0, 2.1\n1, 1.9\n2, 1.2\n3, 4.8\n4, 17.9' }),
    dof: {
        type: 'calc',
        inputs: { test: SEL('Test', { one: 'One-sample or paired t', pooled: 'Two-sample t (equal variances)', welch: 'Two-sample t (Welch)', gof: 'χ² goodness of fit', indep: 'χ² independence', anova: 'One-way ANOVA', reg: 'Linear regression' }, 'welch'), n1: N('n (or n₁)', 12, 1), n2: N('n₂', 15, 1), s1: N('s₁', 4.2, 0), s2: N('s₂', 6.8, 0), k: N('Categories or groups k', 4, 1), r: N('Rows', 3, 1), c: N('Columns', 4, 1), N: N('Total observations N', 40, 1), p: N('Predictors p', 2, 1) },
        show: { n1: 'test:one,pooled,welch,reg', n2: 'test:pooled,welch', s1: 'test:welch', s2: 'test:welch', k: 'test:gof,anova', r: 'test:indep', c: 'test:indep', N: 'test:anova', p: 'test:reg' },
        label: 'Degrees of freedom',
        rows: { formula: 'Formula' },
        run: (x) => {
            const [df, formula, extra] = {
                one: [x.n1 - 1, 'df = n − 1', ''],
                pooled: [x.n1 + x.n2 - 2, 'df = n₁ + n₂ − 2', ''],
                welch: (() => {
                    const v1 = x.s1 ** 2 / x.n1;
                    const v2 = x.s2 ** 2 / x.n2;

                    return [(v1 + v2) ** 2 / (v1 ** 2 / (x.n1 - 1) + v2 ** 2 / (x.n2 - 1)), 'Welch–Satterthwaite: df = (s₁²/n₁ + s₂²/n₂)² ÷ ((s₁²/n₁)²/(n₁ − 1) + (s₂²/n₂)²/(n₂ − 1))', 'Usually not a whole number; software uses it as is'];
                })(),
                gof: [x.k - 1, 'df = k − 1 (minus 1 more for each parameter estimated from the data)', ''],
                indep: [(x.r - 1) * (x.c - 1), 'df = (rows − 1)(columns − 1)', ''],
                anova: [`${x.k - 1} and ${x.N - x.k}`, 'Between groups k − 1; within groups N − k', ''],
                reg: [x.n1 - x.p - 1, 'Residual df = n − p − 1', ''],
            }[x.test];

            if (typeof df === 'number' && !(df > 0)) {
                return { error: 'These sizes leave no degrees of freedom.' };
            }

            return { value: typeof df === 'number' ? num(df, 8) : df, sub: formula, rows: { formula }, steps: [formula, ...(extra ? [extra] : []), 'Degrees of freedom count the independent pieces of information left after estimating parameters'] };
        },
    },
    exp_reg: regTool({ build: (x, p) => (p.x.length < 3 || p.y.some((v) => v <= 0) ? { error: 'Enter at least 3 points with positive y.' } : { X: p.x.map((v) => [1, v]), row: (v) => [1, v], back: Math.exp, y: p.y.map(Math.log), predict: (b, v) => Math.exp(b[0] + b[1] * v), equation: (b) => `y = ${num(Math.exp(b[0]), 6)} × ${num(Math.exp(b[1]), 6)}ˣ`, names: ['ln a', 'ln b'], steps: ['Model y = a·bˣ, fitted as ln y = ln a + x ln b', 'R² refers to the fit of ln y'] }), label: 'Exponential fit', sample: '0, 3.1\n1, 4.6\n2, 6.9\n3, 10.2\n4, 15.5\n5, 23.1' }),
    fisher: {
        type: 'calc',
        inputs: { a: N('Row 1, column 1', 3, 0), b: N('Row 1, column 2', 9, 0), c: N('Row 2, column 1', 11, 0), d: N('Row 2, column 2', 4, 0), alt: SEL('Alternative', { two: 'Two-sided', less: 'Odds ratio < 1', greater: 'Odds ratio > 1' }, 'two'), alpha: ALPHA },
        label: 'p-value',
        rows: { or: 'Sample odds ratio', pobs: 'P(this exact table)', verdict: 'Decision' },
        run: (x) => {
            if (![x.a, x.b, x.c, x.d].every((v) => Number.isInteger(v) && v >= 0)) {
                return { error: 'Enter whole-number counts.' };
            }

            const f = fisherExact(x.a, x.b, x.c, x.d);
            const p = { two: f.p, less: f.less, greater: f.greater }[x.alt];

            return { value: pText(p), sub: decision(p, x.alpha), rows: { or: x.b * x.c ? num(f.oddsRatio, 6) : 'Infinite or undefined', pobs: num(f.pObs, 6), verdict: decision(p, x.alpha) }, steps: ['With the row and column totals fixed, the top-left count follows a hypergeometric distribution', 'P(table) = C(a + b, a) C(c + d, c) ÷ C(n, a + c)', 'Two-sided p adds the probabilities of every table no more likely than the one observed (as R)', 'Exact for any sample size; preferred to χ² when expected counts are small'] };
        },
    },
    f_stat: {
        type: 'calc',
        inputs: { mode: SEL('From', { summary: 'Two standard deviations', data: 'Two samples' }, 'summary'), s1: N('SD of sample 1', 6.2, 0), n1: N('Size of sample 1', 21, 2), s2: N('SD of sample 2', 4.1, 0), n2: N('Size of sample 2', 25, 2), a: TXT('Sample 1', SAMPLE_A), b: TXT('Sample 2', SAMPLE_B), tail: TAIL, alpha: ALPHA },
        show: { s1: 'mode:summary', n1: 'mode:summary', s2: 'mode:summary', n2: 'mode:summary', a: 'mode:data', b: 'mode:data' },
        when: { s1: (x) => x.mode === 'summary', n1: (x) => x.mode === 'summary', s2: (x) => x.mode === 'summary', n2: (x) => x.mode === 'summary' },
        label: 'F statistic',
        rows: { df: 'Degrees of freedom', p: 'p-value', crit: 'Critical value(s)', verdict: 'Decision' },
        plots: [['dist', 'F distribution']],
        run: (x) => {
            let [s1, n1, s2, n2] = [x.s1, x.n1, x.s2, x.n2];

            if (x.mode === 'data') {
                const A = sample(x.a, 2, 'Sample 1');
                const B = sample(x.b, 2, 'Sample 2');

                if (!A.xs) {
                    return A;
                }

                if (!B.xs) {
                    return B;
                }

                [s1, n1, s2, n2] = [sd(A.xs), A.xs.length, sd(B.xs), B.xs.length];
            }

            if (!(s2 > 0)) {
                return { error: 'The second SD must be positive.' };
            }

            const F = (s1 * s1) / (s2 * s2);
            const d = fisherF(n1 - 1, n2 - 1);
            const p = x.tail === 'two' ? Math.min(1, 2 * Math.min(d.cdf(F), d.sf(F))) : x.tail === 'left' ? d.cdf(F) : d.sf(F);
            const crit = x.tail === 'two' ? `${num(d.inv(x.alpha / 2), 5)} and ${num(d.inv(1 - x.alpha / 2), 5)}` : num(d.inv(x.tail === 'left' ? x.alpha : 1 - x.alpha), 5);

            return { value: num(F, 6), sub: `p = ${pText(p)}`, rows: { df: `${n1 - 1} and ${n2 - 1}`, p: pText(p), crit, verdict: decision(p, x.alpha) }, steps: ['H₀: the two population variances are equal', `F = s₁² ÷ s₂² = ${num(s1 * s1, 8)} ÷ ${num(s2 * s2, 8)} = ${num(F, 8)}`, 'The F test is very sensitive to non-normal data; Levene’s test is more robust'], plots: { dist: x.tail === 'two' ? distPlot(d, F >= d.inv(0.5) ? 'ge' : 'le', F, 0, { xLabel: 'F', hi: Math.max(d.hi, F * 1.1) }) : distPlot(d, x.tail === 'left' ? 'le' : 'ge', F, 0, { xLabel: 'F', hi: Math.max(d.hi, F * 1.1) }) } };
        },
    },
    hypothesis: {
        type: 'calc',
        inputs: { test: SEL('Test', { t: 'Mean, σ unknown (t-test)', z: 'Mean, σ known (z-test)', prop: 'Proportion (z-test)' }, 't'), h0: N('Value under H₀ (μ₀ or p₀)', 100), mean: N('Sample mean', 104.2), sd: N('Standard deviation (s or σ)', 12, 0), n: N('Sample size', 36, 1), x: N('Successes', 58, 0), tail: TAIL, alpha: ALPHA },
        show: { mean: 'test:t,z', sd: 'test:t,z', x: 'test:prop' },
        when: { mean: (x) => x.test !== 'prop', sd: (x) => x.test !== 'prop', x: (x) => x.test === 'prop' },
        label: 'Decision',
        rows: { stat: 'Test statistic', p: 'p-value', crit: 'Critical value', h: 'Hypotheses' },
        plots: [['dist', 'p-value region']],
        run: (x) => {
            if (!alphaOk(x.alpha)) {
                return { error: 'α must be between 0 and 1.' };
            }

            let stat;
            let p;
            let crit;
            let d;
            let name;
            let lines;

            if (x.test === 'prop') {
                if (!(x.h0 > 0 && x.h0 < 1) || x.x > x.n) {
                    return { error: 'p₀ must be between 0 and 1 and successes at most n.' };
                }

                const ph = x.x / x.n;
                const se = Math.sqrt((x.h0 * (1 - x.h0)) / x.n);
                stat = (ph - x.h0) / se;
                p = zP(stat, x.tail);
                crit = zCrit(x.alpha, x.tail);
                d = normal(0, 1);
                name = 'z';
                lines = [`p̂ = ${num(x.x)} ÷ ${num(x.n)} = ${num(ph, 6)}`, `z = (p̂ − p₀) ÷ √(p₀(1 − p₀)/n) = ${num(stat, 6)}`];
            } else if (x.test === 'z') {
                stat = (x.mean - x.h0) / (x.sd / Math.sqrt(x.n));
                p = zP(stat, x.tail);
                crit = zCrit(x.alpha, x.tail);
                d = normal(0, 1);
                name = 'z';
                lines = [`z = (x̄ − μ₀) ÷ (σ/√n) = (${num(x.mean)} − ${num(x.h0)}) ÷ (${num(x.sd)}/√${num(x.n)}) = ${num(stat, 6)}`];
            } else {
                const r = tOne(x.mean, x.sd, x.n, x.h0, x.tail);
                [stat, p] = [r.t, r.p];
                crit = tCrit(x.alpha, r.df, x.tail);
                d = studentT(r.df);
                name = `t (${r.df} df)`;
                lines = [`t = (x̄ − μ₀) ÷ (s/√n) = (${num(x.mean)} − ${num(x.h0)}) ÷ (${num(x.sd)}/√${num(x.n)}) = ${num(stat, 6)}`];
            }

            const [h0, h1] = hypotheses(x.test === 'prop' ? 'p' : 'μ', num(x.h0), x.tail);

            return { value: p < x.alpha ? 'Reject H₀' : 'Do not reject H₀', sub: `p = ${pText(p)} ${p < x.alpha ? '<' : '≥'} α = ${num(x.alpha)}`, rows: { stat: `${name} = ${num(stat, 6)}`, p: pText(p), crit: `${x.tail === 'two' ? '±' : x.tail === 'left' ? '−' : ''}${num(Math.abs(crit), 6)}`, h: `${h0}; ${h1}` }, steps: [`1. ${h0}, ${h1}`, `2. α = ${num(x.alpha)}`, `3. ${lines.join('; ')}`, `4. p-value = ${pText(p)}; critical value ${x.tail === 'two' ? '±' : ''}${num(Math.abs(crit), 6)}`, `5. ${decision(p, x.alpha)}`, 'Not rejecting H₀ is not proof that H₀ is true'], plots: { dist: testPlot(d, stat, x.tail, name.split(' ')[0]) } };
        },
    },
    linear_reg: regTool({ inputs: { conf: N('Confidence for intervals (%)', 95, 0) }, build: (x, p) => (p.x.length < 3 ? { error: 'Enter at least 3 points.' } : { X: p.x.map((v) => [1, v]), row: (v) => [1, v], y: p.y, predict: (b, v) => b[0] + b[1] * v, equation: (b) => `ŷ = ${num(b[0], 6)} ${b[1] < 0 ? '−' : '+'} ${num(Math.abs(b[1]), 6)}x`, names: ['Intercept b₀', 'Slope b₁'], steps: ['Least squares: b₁ = Σ(x − x̄)(y − ȳ) ÷ Σ(x − x̄)², b₀ = ȳ − b₁x̄'] }), label: 'Regression line' }),
    margin_error: {
        type: 'calc',
        inputs: { type: SEL('For a', { prop: 'Proportion (survey percentage)', mean: 'Mean' }, 'prop'), conf: N('Confidence level (%)', 95, 0), n: N('Sample size', 1000, 1), p: N('Proportion p (0.5 = most cautious)', 0.5, 0), sd: N('Standard deviation', 15, 0), N: N('Population size (0 = very large)', 0, 0) },
        show: { p: 'type:prop', sd: 'type:mean' },
        when: { p: (x) => x.type === 'prop', sd: (x) => x.type === 'mean' },
        label: 'Margin of error',
        rows: { z: 'z critical value', se: 'Standard error', fpc: 'Finite population correction' },
        run: (x) => {
            if (!(x.conf > 0 && x.conf < 100) || (x.N > 0 && x.N < x.n)) {
                return { error: 'Confidence must be between 0 and 100% and n no larger than the population.' };
            }

            const z = normInv(1 - (1 - x.conf / 100) / 2);
            const se = x.type === 'prop' ? Math.sqrt((x.p * (1 - x.p)) / x.n) : x.sd / Math.sqrt(x.n);
            const fpc = x.N > 0 ? Math.sqrt((x.N - x.n) / (x.N - 1)) : 1;
            const moe = z * se * fpc;

            return { value: x.type === 'prop' ? `± ${pct(moe, 4)}` : `± ${num(moe, 6)}`, sub: `${num(x.conf)}% confidence, n = ${num(x.n)}`, rows: { z: num(z, 6), se: num(se, 6), fpc: x.N > 0 ? num(fpc, 6) : 'Not used' }, steps: [`MOE = z × ${x.type === 'prop' ? '√(p(1 − p)/n)' : 'σ/√n'}${x.N > 0 ? ' × √((N − n)/(N − 1))' : ''}`, `= ${num(z, 6)} × ${num(se, 6)}${x.N > 0 ? ` × ${num(fpc, 6)}` : ''} = ${num(moe, 8)}`, 'Covers random sampling error only, not bias from who answers or how questions are worded'] };
        },
    },
    mcnemar: {
        type: 'calc',
        inputs: { a: N('Both yes (before yes, after yes)', 30, 0), b: N('Yes before, no after', 12, 0), c: N('No before, yes after', 25, 0), d: N('Both no', 33, 0), correct: SEL('Continuity correction', { yes: 'Yes (Edwards)', no: 'No' }, 'yes'), alpha: ALPHA },
        label: 'p-value (χ²)',
        rows: { chi: 'χ² (1 df)', exact: 'Exact p-value (binomial)', change: 'Discordant pairs b and c', verdict: 'Decision' },
        run: (x) => {
            if (![x.a, x.b, x.c, x.d].every((v) => Number.isInteger(v) && v >= 0)) {
                return { error: 'Enter whole-number counts.' };
            }

            const m = mcnemar(x.b, x.c, x.correct === 'yes');

            return { value: pText(m.p), sub: decision(m.p, x.alpha), rows: { chi: num(m.chi2, 6), exact: pText(m.exact), change: `${x.b} and ${x.c}`, verdict: decision(m.p, x.alpha) }, steps: ['Only the pairs that changed (b and c) carry information about a shift', `χ² = (|b − c|${x.correct === 'yes' ? ' − 1' : ''})² ÷ (b + c) = ${num(m.chi2, 8)}`, 'The exact test treats b as Binomial(b + c, ½); prefer it when b + c < 25'] };
        },
    },
    normal_approx: {
        type: 'calc',
        inputs: { dist: SEL('Distribution', { binomial: 'Binomial (n, p)', poisson: 'Poisson (λ)' }, 'binomial'), n: N('Trials n', 50, 1), p: N('Probability p', 0.3, 0), lambda: N('Rate λ', 20, 0), mode: SEL('Find', { le: 'P(X ≤ k)', ge: 'P(X ≥ k)', eq: 'P(X = k)' }, 'le'), k: N('k', 18) },
        show: { n: 'dist:binomial', p: 'dist:binomial', lambda: 'dist:poisson' },
        when: { n: (x) => x.dist === 'binomial', p: (x) => x.dist === 'binomial', lambda: (x) => x.dist === 'poisson' },
        label: 'Normal approximation',
        rows: { exact: 'Exact probability', error: 'Approximation error', params: 'μ and σ used', ok: 'Conditions' },
        run: (x) => {
            const bin = x.dist === 'binomial';

            if (bin ? !(Number.isInteger(x.n) && x.p > 0 && x.p < 1) : !(x.lambda > 0)) {
                return { error: 'Use a whole n with 0 < p < 1, or a positive λ.' };
            }

            const mu = bin ? x.n * x.p : x.lambda;
            const s = Math.sqrt(bin ? x.n * x.p * (1 - x.p) : x.lambda);
            const Phi = (v) => normCdf((v - mu) / s);
            const approx = { le: Phi(x.k + 0.5), ge: 1 - Phi(x.k - 0.5), eq: Phi(x.k + 0.5) - Phi(x.k - 0.5) }[x.mode];
            const exact = regionProbability(bin ? binomial(x.n, x.p) : poisson(x.lambda), x.mode, x.k);
            const ok = bin ? x.n * x.p >= 10 && x.n * (1 - x.p) >= 10 : x.lambda >= 10;

            return { value: num(approx, 6), sub: `with continuity correction`, rows: { exact: num(exact, 6), error: num(approx - exact, 4), params: `μ = ${num(mu, 6)}, σ = ${num(s, 6)}`, ok: ok ? (bin ? 'np and n(1 − p) ≥ 10: good approximation' : 'λ ≥ 10: good approximation') : 'Conditions not met: trust the exact value' }, steps: [`μ = ${bin ? 'np' : 'λ'} = ${num(mu, 6)}, σ = ${bin ? '√(np(1 − p))' : '√λ'} = ${num(s, 6)}`, `Continuity correction: ${{ le: `X ≤ ${x.k} → Y < ${x.k + 0.5}`, ge: `X ≥ ${x.k} → Y > ${x.k - 0.5}`, eq: `X = ${x.k} → ${x.k - 0.5} < Y < ${x.k + 0.5}` }[x.mode]}`, `Approximation ${num(approx, 8)} vs exact ${num(exact, 8)}`] };
        },
    },
    point_estimate: {
        type: 'calc',
        inputs: { x: N('Successes x', 9, 0), n: N('Trials n', 10, 1), conf: N('Confidence level (%)', 95, 0) },
        label: 'Best point estimate',
        rows: { mle: 'Maximum likelihood x/n', laplace: 'Laplace (x + 1)/(n + 2)', jeffreys: 'Jeffreys (x + ½)/(n + 1)', wilson: 'Wilson (x + z²/2)/(n + z²)', rule: 'Which one' },
        run: (x) => {
            if (!(Number.isInteger(x.x) && Number.isInteger(x.n) && x.x <= x.n)) {
                return { error: 'Use whole numbers with x ≤ n.' };
            }

            const z = normInv(1 - (1 - x.conf / 100) / 2);
            const mle = x.x / x.n;
            const lap = (x.x + 1) / (x.n + 2);
            const jef = (x.x + 0.5) / (x.n + 1);
            const wil = (x.x + (z * z) / 2) / (x.n + z * z);
            const [best, why] = mle <= 0.5 ? [wil, 'p̂ ≤ 0.5: Wilson'] : mle < 0.9 ? [mle, '0.5 < p̂ < 0.9: maximum likelihood'] : [Math.min(jef, lap), 'p̂ ≥ 0.9: the smaller of Jeffreys and Laplace'];

            return { value: num(best, 6), sub: why, rows: { mle: num(mle, 6), laplace: num(lap, 6), jeffreys: num(jef, 6), wilson: num(wil, 6), rule: 'Sauro & Lewis (2012): Wilson up to 0.5, MLE to 0.9, then min(Jeffreys, Laplace)' }, steps: ['For small samples, x/n is often too extreme (9 of 10 does not mean 90% in general)', 'The adjusted estimators pull the estimate towards 0.5 by different amounts', `Chosen: ${why} = ${num(best, 8)}`] };
        },
    },
    poly_reg: regTool({ inputs: { degree: SEL('Degree', { 1: '1 (straight line)', 2: '2 (quadratic)', 3: '3 (cubic)', 4: '4 (quartic)', 5: '5', 6: '6' }, '2') }, build: (x, p) => polyModel(Number(x.degree))(x, p), label: 'Polynomial fit', sample: '0, 1.2\n1, 1.9\n2, 4.1\n3, 8.8\n4, 16.3\n5, 26.0\n6, 37.9\n7, 51.2' }),
    power: {
        type: 'calc',
        inputs: { test: SEL('Test', { one: 'One-sample or paired t-test', two: 'Two-sample t-test (equal groups)', prop: 'Two proportions (equal groups)' }, 'two'), solve: SEL('Find', { power: 'Power for a sample size', n: 'Sample size for a power' }, 'n'), d: N('Effect size d (Cohen)', 0.5), p1: N('Proportion 1', 0.3, 0), p2: N('Proportion 2', 0.4, 0), n: N('Sample size (per group)', 30, 2), target: N('Target power', 0.8, 0), alpha: ALPHA, tail: SEL('Test', { two: 'Two-sided', right: 'One-sided' }, 'two') },
        show: { d: 'test:one,two', p1: 'test:prop', p2: 'test:prop', n: 'solve:power', target: 'solve:n' },
        when: { d: (x) => x.test !== 'prop', p1: (x) => x.test === 'prop', p2: (x) => x.test === 'prop', n: (x) => x.solve === 'power', target: (x) => x.solve === 'n' },
        label: 'Result',
        rows: { effect: 'Effect size', other: 'Detail', method: 'Method' },
        plots: [['curve', 'Power by sample size']],
        run: (x) => {
            if (!alphaOk(x.alpha)) {
                return { error: 'α must be between 0 and 1.' };
            }

            let powerAt;
            let effect;
            let method;

            if (x.test === 'prop') {
                if (!(x.p1 > 0 && x.p1 < 1 && x.p2 > 0 && x.p2 < 1) || x.p1 === x.p2) {
                    return { error: 'Use two different proportions between 0 and 1.' };
                }

                const h = Math.abs(2 * Math.asin(Math.sqrt(x.p1)) - 2 * Math.asin(Math.sqrt(x.p2)));
                const za = x.tail === 'two' ? normInv(1 - x.alpha / 2) : normInv(1 - x.alpha);
                powerAt = (n) => normCdf(h * Math.sqrt(n / 2) - za) + (x.tail === 'two' ? normCdf(-h * Math.sqrt(n / 2) - za) : 0);
                effect = `Cohen’s h = ${num(h, 5)}`;
                method = 'Normal approximation with the arcsine transform (Cohen 1988)';
            } else {
                if (!(x.d !== 0 && Number.isFinite(x.d))) {
                    return { error: 'The effect size must not be zero.' };
                }

                const groups = x.test === 'one' ? 1 : 2;
                powerAt = (n) => tPower(Math.abs(x.d), n, x.alpha, x.tail, groups);
                effect = `d = ${num(x.d)}`;
                method = 'Exact power from the noncentral t distribution (as G*Power, R pwr)';
            }

            let n;
            let pw;

            if (x.solve === 'n') {
                if (!(x.target > 0 && x.target < 1)) {
                    return { error: 'The target power must be between 0 and 1.' };
                }

                if (x.test === 'prop') {
                    n = 2;

                    while (powerAt(n) < x.target && n < 1e8) {
                        n = n < 1000 ? n + 1 : Math.ceil(n * 1.001);
                    }
                } else {
                    n = tSampleSize(x.d, x.target, x.alpha, x.tail, x.test === 'one' ? 1 : 2);
                }

                pw = powerAt(n);
            } else {
                n = x.n;
                pw = powerAt(n);
            }

            const top = Math.max(10, Math.ceil(n * 2));
            const series = Array.from({ length: 60 }, (_, j) => Math.max(2, Math.round(2 + ((top - 2) * j) / 59))).map((m) => [m, powerAt(m)]);

            return { value: x.solve === 'n' ? `${num(n)} ${x.test === 'one' ? 'subjects (pairs)' : 'per group'}` : pct(pw, 4), sub: x.solve === 'n' ? `gives power ${pct(pw, 4)}` : `with ${num(n)} ${x.test === 'one' ? 'subjects' : 'per group'}`, rows: { effect, other: x.solve === 'n' ? `Total ${num(x.test === 'one' ? n : 2 * n)}` : `β (miss rate) = ${pct(1 - pw, 4)}`, method }, steps: ['Power = P(reject H₀ | the effect is real)', `α = ${num(x.alpha)}, ${x.tail === 'two' ? 'two-sided' : 'one-sided'}`, method, '0.8 power is the usual minimum; smaller effects need much larger samples (n grows with 1/d²)'], plots: { curve: { series, markers: [{ x: n, y: pw, label: `n = ${num(n)}` }], xLabel: 'Sample size (per group)', yLabel: 'Power', yMin: 0, yMax: 1 } } };
        },
    },
    p_value: {
        type: 'calc',
        inputs: { dist: SEL('Statistic', { z: 'z', t: 't', chi2: 'χ²', f: 'F' }, 'z'), stat: N('Value of the statistic', 1.96), tail: TAIL, df1: N('Degrees of freedom (df₁)', 10, 0), df2: N('Denominator df (df₂, F only)', 20, 0), alpha: ALPHA },
        show: { df1: 'dist:t,chi2,f', df2: 'dist:f' },
        when: { df1: (x) => x.dist !== 'z', df2: (x) => x.dist === 'f' },
        label: 'p-value',
        rows: { verdict: 'Decision', levels: 'Significant at' },
        plots: [['dist', 'Shaded area = p-value']],
        run: (x) => {
            const d = { z: normal(0, 1), t: studentT(x.df1), chi2: chiSquare(x.df1), f: fisherF(x.df1, x.df2) }[x.dist];
            const symmetric = x.dist === 'z' || x.dist === 't';
            const p = symmetric ? (x.dist === 'z' ? zP(x.stat, x.tail) : tP(x.stat, x.df1, x.tail)) : x.tail === 'left' ? d.cdf(x.stat) : x.tail === 'right' ? d.sf(x.stat) : Math.min(1, 2 * Math.min(d.cdf(x.stat), d.sf(x.stat)));
            const levels = [0.1, 0.05, 0.01, 0.001].filter((a) => p < a);

            return { value: pText(p), sub: `${x.dist === 'chi2' ? 'χ²' : x.dist} = ${num(x.stat)}, ${TAILS[x.tail]}`, rows: { verdict: decision(p, x.alpha), levels: levels.length ? levels.map((a) => `α = ${a}`).join(', ') : 'None of 0.1, 0.05, 0.01, 0.001' }, steps: ['The p-value is the probability, if H₀ were true, of a statistic at least as extreme as the one observed', symmetric ? `${x.tail === 'two' ? 'Two-tailed: p = 2 × P(stat > |value|)' : x.tail === 'left' ? 'p = P(stat ≤ value)' : 'p = P(stat ≥ value)'}` : `${x.tail === 'two' ? 'Two-tailed: twice the smaller tail' : x.tail === 'left' ? 'Lower tail' : 'Upper tail (usual for χ² and F)'}`, `p = ${num(p, 10)}`, 'A small p-value is evidence against H₀, not the probability that H₀ is true'], plots: { dist: symmetric || x.tail !== 'two' ? testPlot(d, x.stat, x.tail, x.dist) : distPlot(d, d.cdf(x.stat) < 0.5 ? 'le' : 'ge', x.stat, 0, { xLabel: x.dist, hi: Math.max(d.hi, x.stat * 1.1) }) } };
        },
    },
    quad_reg: regTool({ build: polyModel(2), label: 'Quadratic fit', sample: '-3, 9.8\n-2, 4.1\n-1, 1.2\n0, 0.1\n1, 0.9\n2, 4.2\n3, 8.7\n4, 16.3' }),
    raw_score: {
        type: 'calc',
        inputs: { z: N('z-score', 1.5), mean: N('Mean μ', 100), sd: N('Standard deviation σ', 15, 0) },
        label: 'Raw score x',
        rows: { pct: 'Percentile (normal)', above: 'Share above' },
        run: (x) => {
            const v = x.mean + x.z * x.sd;

            return { value: num(v, 10), sub: `${num(Math.abs(x.z))} SD ${x.z >= 0 ? 'above' : 'below'} the mean`, rows: { pct: pct(normCdf(x.z), 5), above: pct(normSf(x.z), 5) }, steps: ['x = μ + zσ', `= ${num(x.mean)} + ${num(x.z)} × ${num(x.sd)} = ${num(v, 10)}`] };
        },
    },
    residual: {
        type: 'calc',
        inputs: { mode: SEL('From', { pairs: 'x, y data (straight-line fit)', predicted: 'Observed and predicted values' }, 'pairs'), data: PAIRS('1, 2.3\n2, 3.8\n3, 6.4\n4, 7.7\n5, 10.6\n6, 11.6\n7, 14.4'), observed: TXT('Observed', '3, 5, 7, 10, 12'), predicted: TXT('Predicted', '2.8, 5.3, 7.1, 9.6, 12.2') },
        show: { data: 'mode:pairs', observed: 'mode:predicted', predicted: 'mode:predicted' },
        label: 'Sum of squared residuals',
        rows: { largest: 'Largest residual', mean: 'Mean residual', line: 'Fitted line' },
        plots: [['resid', 'Residual plot']],
        grids: [['table', 'Residuals']],
        run: (x) => {
            let y;
            let yhat;
            let xs;
            let stdRes = null;
            let line = '—';

            if (x.mode === 'pairs') {
                const p = parsePairs(x.data);

                if (p.problem) {
                    return { error: p.problem };
                }

                const X = p.x.map((v) => [1, v]);
                const fit = ols(X, p.y);

                if (fit.problem) {
                    return { error: fit.problem };
                }

                [y, yhat, xs] = [p.y, fit.fitted, p.x];
                stdRes = fit.resid.map((e, i) => {
                    const h = sum(X[i].map((a, j) => sum(X[i].map((b, k) => a * fit.XtXinv[j][k] * b))));

                    return e / (fit.sigma * Math.sqrt(1 - h));
                });
                line = `ŷ = ${num(fit.beta[0], 6)} ${fit.beta[1] < 0 ? '−' : '+'} ${num(Math.abs(fit.beta[1]), 6)}x`;
            } else {
                y = parseNumbers(x.observed).values;
                yhat = parseNumbers(x.predicted).values;
                xs = yhat;

                if (!y.length || y.length !== yhat.length) {
                    return { error: 'Enter the same number of observed and predicted values.' };
                }
            }

            const e = y.map((v, i) => v - yhat[i]);
            const big = e.reduce((a, b) => (Math.abs(b) > Math.abs(a) ? b : a), 0);

            return { value: num(sum(e.map((v) => v * v)), 8), sub: `${e.length} residuals`, rows: { largest: num(big, 6), mean: num(mean(e), 6), line }, steps: ['Residual e = observed y − predicted ŷ', 'A good fit leaves residuals scattered randomly around zero; curves or funnels mean the model misses something', ...(stdRes ? ['Standardised residuals beyond ±2 deserve a look'] : [])], plots: { resid: { scatter: xs.map((v, i) => [v, e[i]]), extra: [[[Math.min(...xs), 0], [Math.max(...xs), 0]]], xLabel: x.mode === 'pairs' ? 'x' : 'Predicted', yLabel: 'Residual', axes: true } }, grids: { table: { columns: ['y', 'ŷ', 'Residual', ...(stdRes ? ['Standardised'] : [])], rows: y.slice(0, 200).map((v, i) => ({ header: x.mode === 'pairs' ? `x = ${num(xs[i])}` : `#${i + 1}`, cells: [num(v, 8), num(yhat[i], 8), num(e[i], 6), ...(stdRes ? [num(stdRes[i], 4)] : [])] })) } } };
        },
    },
    sampling_error: {
        type: 'calc',
        inputs: { type: SEL('For a', { mean: 'Mean (from σ)', prop: 'Proportion' }, 'mean'), sd: N('Population SD σ', 20, 0), p: N('Proportion p', 0.5, 0), n: N('Sample size', 400, 1), conf: N('Confidence level (%)', 95, 0), N: N('Population size (0 = very large)', 0, 0) },
        show: { sd: 'type:mean', p: 'type:prop' },
        when: { sd: (x) => x.type === 'mean', p: (x) => x.type === 'prop' },
        label: 'Sampling error',
        rows: { se: 'Standard error', z: 'z', fpc: 'Finite population correction' },
        run: (x) => {
            if (x.N > 0 && x.N < x.n) {
                return { error: 'The sample cannot be larger than the population.' };
            }

            const z = normInv(1 - (1 - x.conf / 100) / 2);
            const se = x.type === 'prop' ? Math.sqrt((x.p * (1 - x.p)) / x.n) : x.sd / Math.sqrt(x.n);
            const fpc = x.N > 0 ? Math.sqrt((x.N - x.n) / (x.N - 1)) : 1;
            const e = z * se * fpc;

            return { value: x.type === 'prop' ? `± ${pct(e, 4)}` : `± ${num(e, 6)}`, sub: `${num(x.conf)}% of samples fall within this of the true value`, rows: { se: num(se, 6), z: num(z, 6), fpc: x.N > 0 ? num(fpc, 6) : 'Not used' }, steps: [`Sampling error = z × SE${x.N > 0 ? ' × √((N − n)/(N − 1))' : ''}`, `= ${num(z, 6)} × ${num(se, 6)}${x.N > 0 ? ` × ${num(fpc, 6)}` : ''} = ${num(e, 8)}`, 'It shrinks with √n: four times the sample halves the error'] };
        },
    },
    t_stat: {
        type: 'calc',
        inputs: { mean: N('Sample mean x̄', 52.3), mu: N('Hypothesised mean μ₀', 50), s: N('Sample standard deviation s', 6.1, 0), n: N('Sample size n', 25, 2), tail: TAIL },
        label: 't',
        rows: { df: 'Degrees of freedom', se: 'Standard error s/√n', p: 'p-value' },
        run: (x) => {
            if (!(x.s > 0)) {
                return { error: 's must be positive.' };
            }

            const r = tOne(x.mean, x.s, x.n, x.mu, x.tail);

            return { value: num(r.t, 8), sub: `${r.df} df, p = ${pText(r.p)}`, rows: { df: String(r.df), se: num(r.se, 8), p: pText(r.p) }, steps: ['t = (x̄ − μ₀) ÷ (s/√n)', `= (${num(x.mean)} − ${num(x.mu)}) ÷ (${num(x.s)}/√${num(x.n)}) = ${num(r.t, 10)}`] };
        },
    },
    t_test: {
        type: 'calc',
        inputs: { type: SEL('Test', { welch: 'Two independent samples (Welch, unequal variances)', pooled: 'Two independent samples (pooled, equal variances)', paired: 'Paired samples', one: 'One sample' }, 'welch'), input: SEL('Enter', { data: 'Raw data', summary: 'Means, SDs and sizes' }, 'data'), a: TXT('Sample 1 (or the only sample / before)', SAMPLE_A), b: TXT('Sample 2 (or after)', SAMPLE_B), m1: N('Mean 1', 13.5), s1: N('SD 1', 1.2, 0), n1: N('Size 1', 8, 2), m2: N('Mean 2', 16.3), s2: N('SD 2', 1.1, 0), n2: N('Size 2', 9, 2), mu: N('Hypothesised mean or difference', 0), tail: TAIL, alpha: ALPHA },
        show: { a: 'input:data', b: 'input:data', m1: 'input:summary', s1: 'input:summary', n1: 'input:summary', m2: 'input:summary', s2: 'input:summary', n2: 'input:summary' },
        when: { m1: (x) => x.input === 'summary', s1: (x) => x.input === 'summary', n1: (x) => x.input === 'summary', m2: (x) => x.input === 'summary' && x.type !== 'one' && x.type !== 'paired', s2: (x) => x.input === 'summary' && x.type !== 'one' && x.type !== 'paired', n2: (x) => x.input === 'summary' && x.type !== 'one' && x.type !== 'paired' },
        label: 't',
        rows: { df: 'Degrees of freedom', p: 'p-value', ci: 'Confidence interval for the difference', d: 'Cohen’s d', verdict: 'Decision' },
        plots: [['dist', 't distribution (shaded: p-value)']],
        run: (x) => {
            if (!alphaOk(x.alpha)) {
                return { error: 'α must be between 0 and 1.' };
            }

            let r;
            let diff;
            let lines;

            if (x.type === 'one' || x.type === 'paired') {
                let m = x.m1;
                let s = x.s1;
                let n = x.n1;

                if (x.input === 'data') {
                    const A = sample(x.a, 2, 'Sample 1');

                    if (!A.xs) {
                        return A;
                    }

                    let xs = A.xs;

                    if (x.type === 'paired') {
                        const B = sample(x.b, 2, 'Sample 2');

                        if (!B.xs) {
                            return B;
                        }

                        if (B.xs.length !== A.xs.length) {
                            return { error: 'Paired samples need the same number of values in each.' };
                        }

                        xs = B.xs.map((v, i) => v - A.xs[i]);
                    }

                    [m, s, n] = [mean(xs), sd(xs), xs.length];
                }

                r = tOne(m, s, n, x.mu, x.tail);
                diff = m;
                lines = [`${x.type === 'paired' ? 'Differences (2 − 1)' : 'Sample'}: mean ${num(m, 8)}, SD ${num(s, 8)}, n = ${n}`, `t = (${num(m, 6)} − ${num(x.mu)}) ÷ (${num(s, 6)}/√${n}) = ${num(r.t, 8)}`];
            } else {
                let [m1, s1, n1, m2, s2, n2] = [x.m1, x.s1, x.n1, x.m2, x.s2, x.n2];

                if (x.input === 'data') {
                    const A = sample(x.a, 2, 'Sample 1');
                    const B = sample(x.b, 2, 'Sample 2');

                    if (!A.xs) {
                        return A;
                    }

                    if (!B.xs) {
                        return B;
                    }

                    [m1, s1, n1, m2, s2, n2] = [mean(A.xs), sd(A.xs), A.xs.length, mean(B.xs), sd(B.xs), B.xs.length];
                }

                r = tTwo(m1, s1, n1, m2, s2, n2, x.tail, x.type === 'pooled', x.mu);
                diff = m1 - m2;
                lines = [`Means ${num(m1, 8)} and ${num(m2, 8)}; SDs ${num(s1, 6)} and ${num(s2, 6)}; sizes ${n1} and ${n2}`, `SE = ${num(r.se, 8)}${x.type === 'pooled' ? ` (pooled SD ${num(r.sp, 6)})` : ''}`, `t = (${num(m1, 6)} − ${num(m2, 6)} − ${num(x.mu)}) ÷ ${num(r.se, 6)} = ${num(r.t, 8)}`];
            }

            const tc = tInv(1 - x.alpha / 2, r.df);
            const d = studentT(r.df);

            return { value: num(r.t, 6), sub: `${num(r.df, 5)} df, p = ${pText(r.p)}`, rows: { df: num(r.df, 6), p: pText(r.p), ci: `${num(diff - tc * r.se, 6)} to ${num(diff + tc * r.se, 6)} (${num((1 - x.alpha) * 100)}%)`, d: num(r.d, 4), verdict: decision(r.p, x.alpha) }, steps: [...lines, x.type === 'welch' ? 'Welch’s test does not assume equal variances (R’s default)' : x.type === 'pooled' ? 'Assumes both groups share one variance' : '', decision(r.p, x.alpha)].filter(Boolean), plots: { dist: testPlot(d, r.t, x.tail, 't') } };
        },
    },
    mann_whitney: {
        type: 'calc',
        inputs: { a: TXT('Sample 1', SAMPLE_A), b: TXT('Sample 2', SAMPLE_B), tail: TAIL, alpha: ALPHA },
        label: 'U',
        rows: { p: 'p-value', u12: 'U₁ and U₂', method: 'Method', r: 'Effect size r', verdict: 'Decision' },
        run: (x) => {
            const A = sample(x.a, 1, 'Sample 1');
            const B = sample(x.b, 1, 'Sample 2');

            if (!A.xs) {
                return A;
            }

            if (!B.xs) {
                return B;
            }

            const m = mannWhitney(A.xs, B.xs, x.tail);

            return { value: num(m.U), sub: `p = ${pText(m.p)}`, rows: { p: pText(m.p), u12: `${num(m.U1)} and ${num(m.U2)}`, method: m.exact ? 'Exact distribution (no ties, n < 50)' : `Normal approximation, z = ${num(m.z, 5)}, with tie and continuity corrections`, r: num(m.r, 4), verdict: decision(m.p, x.alpha) }, steps: ['Rank all values together (ties share the average rank)', `R₁ = sum of sample 1’s ranks = ${num(m.R1)}`, `U₁ = R₁ − n₁(n₁ + 1)/2 = ${num(m.U1)}; U₂ = n₁n₂ − U₁ = ${num(m.U2)}`, 'U is the smaller; the test compares the two distributions without assuming normality', 'Identical to the Wilcoxon rank-sum test'] };
        },
    },
    wilcoxon_rank_sum: {
        type: 'calc',
        inputs: { a: TXT('Sample 1', SAMPLE_A), b: TXT('Sample 2', SAMPLE_B), tail: TAIL, alpha: ALPHA },
        label: 'W (rank sum of sample 1)',
        rows: { p: 'p-value', u: 'Equivalent Mann–Whitney U₁', method: 'Method', verdict: 'Decision' },
        run: (x) => {
            const A = sample(x.a, 1, 'Sample 1');
            const B = sample(x.b, 1, 'Sample 2');

            if (!A.xs) {
                return A;
            }

            if (!B.xs) {
                return B;
            }

            const m = mannWhitney(A.xs, B.xs, x.tail);

            return { value: num(m.W), sub: `p = ${pText(m.p)}`, rows: { p: pText(m.p), u: num(m.U1), method: m.exact ? 'Exact distribution (no ties, n < 50)' : `Normal approximation, z = ${num(m.z, 5)}`, verdict: decision(m.p, x.alpha) }, steps: ['Rank both samples together; W is the sum of sample 1’s ranks', `W = ${num(m.W)}; U₁ = W − n₁(n₁ + 1)/2 = ${num(m.U1)}`, 'Same test and p-value as the Mann–Whitney U test (R’s wilcox.test reports U₁ as W)'] };
        },
    },
    youden: {
        type: 'calc',
        inputs: { mode: SEL('From', { single: 'Sensitivity and specificity', cutoffs: 'Several cut-offs' }, 'single'), sens: N('Sensitivity (%)', 85, 0), spec: N('Specificity (%)', 78, 0), rows: TXT('Cut-offs: value, sensitivity %, specificity %', '5, 98, 40\n10, 92, 62\n15, 85, 78\n20, 70, 88\n25, 52, 95') },
        show: { sens: 'mode:single', spec: 'mode:single', rows: 'mode:cutoffs' },
        when: { sens: (x) => x.mode === 'single', spec: (x) => x.mode === 'single' },
        label: 'Youden’s J',
        rows: { best: 'Best cut-off', meaning: 'Meaning' },
        grids: [['table', 'J for each cut-off']],
        run: (x) => {
            if (x.mode === 'single') {
                const J = x.sens / 100 + x.spec / 100 - 1;

                return { value: num(J, 5), sub: `${pct(J, 4)} better than chance`, rows: { best: 'Enter several cut-offs to compare', meaning: 'J = 0: useless test; J = 1: perfect' }, steps: ['J = sensitivity + specificity − 1', `= ${num(x.sens / 100)} + ${num(x.spec / 100)} − 1 = ${num(J, 6)}`], grids: { table: { columns: [], rows: [] } } };
            }

            const rows = parseRows(x.rows).map((r) => r.values);

            if (!rows.length || rows.some((r) => r.length !== 3)) {
                return { error: 'Each line needs a cut-off, a sensitivity and a specificity.' };
            }

            const js = rows.map(([, se, sp]) => se / 100 + sp / 100 - 1);
            const k = js.indexOf(Math.max(...js));

            return { value: num(js[k], 5), sub: `at cut-off ${num(rows[k][0])}`, rows: { best: num(rows[k][0]), meaning: 'The cut-off with the largest J balances sensitivity and specificity' }, steps: ['J = sensitivity + specificity − 1 for each cut-off; the maximum picks the cut-off'], grids: { table: { columns: ['Sensitivity', 'Specificity', 'J'], rows: rows.map((r, i) => ({ header: num(r[0]), cells: [`${num(r[1])}%`, `${num(r[2])}%`, num(js[i], 4)], highlight: i === k })) } } };
        },
    },
    z_score: {
        type: 'calc',
        inputs: { mode: SEL('From', { values: 'A value, mean and SD', data: 'A value within a data set' }, 'values'), x: N('Value x', 85), mean: N('Mean μ', 70), sd: N('Standard deviation σ', 10, 0), data: TXT('Data set', '62, 70, 74, 78, 81, 85, 88, 90, 93, 97') },
        show: { mean: 'mode:values', sd: 'mode:values', data: 'mode:data' },
        when: { mean: (x) => x.mode === 'values', sd: (x) => x.mode === 'values' },
        label: 'z-score',
        rows: { below: 'P(Z < z), percentile', above: 'P(Z > z)', between: 'P(−|z| < Z < |z|)' },
        plots: [['dist', 'Standard normal curve']],
        run: (x) => {
            let m = x.mean;
            let s = x.sd;

            if (x.mode === 'data') {
                const r = readData(x.data, 2);

                if (!r.xs) {
                    return r;
                }

                [m, s] = [mean(r.xs), sd(r.xs)];
            }

            if (!(s > 0)) {
                return { error: 'σ must be positive.' };
            }

            const z = (x.x - m) / s;

            return { value: num(z, 8), sub: `${num(Math.abs(z), 4)} SD ${z >= 0 ? 'above' : 'below'} the mean`, rows: { below: pct(normCdf(z), 5), above: pct(normSf(z), 5), between: pct(1 - 2 * normSf(Math.abs(z)), 5) }, steps: ['z = (x − μ) ÷ σ', `= (${num(x.x)} − ${num(m, 8)}) ÷ ${num(s, 8)} = ${num(z, 10)}`, x.mode === 'data' ? 'Mean and sample SD taken from the data set' : '', 'Percentiles assume a normal distribution'].filter(Boolean), plots: { dist: distPlot(normal(0, 1), 'le', z, 0, { xLabel: 'z', lo: Math.min(-4, z - 0.5), hi: Math.max(4, z + 0.5) }) } };
        },
    },
    z_test: {
        type: 'calc',
        inputs: { type: SEL('Test', { mean: 'One mean (σ known)', mean2: 'Two means (σ known)', prop: 'One proportion', prop2: 'Two proportions' }, 'mean'), m1: N('Sample mean 1', 104), s1: N('Population SD σ₁', 15, 0), n1: N('Sample size 1', 50, 1), m2: N('Sample mean 2', 98), s2: N('Population SD σ₂', 15, 0), n2: N('Sample size 2', 50, 1), x1: N('Successes 1', 62, 0), x2: N('Successes 2', 48, 0), h0: N('Value under H₀ (μ₀, p₀ or difference)', 100), tail: TAIL, alpha: ALPHA },
        show: { m1: 'type:mean,mean2', s1: 'type:mean,mean2', m2: 'type:mean2', s2: 'type:mean2', n2: 'type:mean2,prop2', x1: 'type:prop,prop2', x2: 'type:prop2' },
        when: { m1: (x) => x.type.startsWith('mean'), s1: (x) => x.type.startsWith('mean'), m2: (x) => x.type === 'mean2', s2: (x) => x.type === 'mean2', n2: (x) => x.type.endsWith('2'), x1: (x) => x.type.startsWith('prop'), x2: (x) => x.type === 'prop2' },
        label: 'z',
        rows: { p: 'p-value', crit: 'Critical value', ci: 'Confidence interval', verdict: 'Decision' },
        plots: [['dist', 'Standard normal (shaded: p-value)']],
        run: (x) => {
            if (!alphaOk(x.alpha)) {
                return { error: 'α must be between 0 and 1.' };
            }

            let z;
            let est;
            let se;
            let how;

            if (x.type === 'mean') {
                se = x.s1 / Math.sqrt(x.n1);
                est = x.m1;
                z = (x.m1 - x.h0) / se;
                how = `z = (x̄ − μ₀) ÷ (σ/√n) = (${num(x.m1)} − ${num(x.h0)}) ÷ ${num(se, 6)}`;
            } else if (x.type === 'mean2') {
                se = Math.sqrt(x.s1 ** 2 / x.n1 + x.s2 ** 2 / x.n2);
                est = x.m1 - x.m2;
                z = (est - x.h0) / se;
                how = `z = (x̄₁ − x̄₂ − D₀) ÷ √(σ₁²/n₁ + σ₂²/n₂) = ${num(est - x.h0, 6)} ÷ ${num(se, 6)}`;
            } else if (x.type === 'prop') {
                if (!(x.h0 > 0 && x.h0 < 1) || x.x1 > x.n1) {
                    return { error: 'p₀ must be between 0 and 1 and successes at most n.' };
                }

                est = x.x1 / x.n1;
                const se0 = Math.sqrt((x.h0 * (1 - x.h0)) / x.n1);
                se = Math.sqrt((est * (1 - est)) / x.n1);
                z = (est - x.h0) / se0;
                how = `z = (p̂ − p₀) ÷ √(p₀(1 − p₀)/n) = (${num(est, 6)} − ${num(x.h0)}) ÷ ${num(se0, 6)}`;
            } else {
                if (x.x1 > x.n1 || x.x2 > x.n2) {
                    return { error: 'Successes cannot exceed sample sizes.' };
                }

                const p1 = x.x1 / x.n1;
                const p2 = x.x2 / x.n2;
                const pool = (x.x1 + x.x2) / (x.n1 + x.n2);
                const se0 = Math.sqrt(pool * (1 - pool) * (1 / x.n1 + 1 / x.n2));
                est = p1 - p2;
                se = Math.sqrt((p1 * (1 - p1)) / x.n1 + (p2 * (1 - p2)) / x.n2);
                z = est / se0;
                how = `z = (p̂₁ − p̂₂) ÷ √(p̄(1 − p̄)(1/n₁ + 1/n₂)) = ${num(est, 6)} ÷ ${num(se0, 6)} (pooled p̄ = ${num(pool, 6)}; H₀: p₁ = p₂)`;
            }

            const p = zP(z, x.tail);
            const zc = normInv(1 - x.alpha / 2);

            return { value: num(z, 6), sub: `p = ${pText(p)}`, rows: { p: pText(p), crit: `${x.tail === 'two' ? '±' : ''}${num(zCrit(x.alpha, x.tail), 6)}`, ci: `${num(est - zc * se, 6)} to ${num(est + zc * se, 6)}`, verdict: decision(p, x.alpha) }, steps: [how, `= ${num(z, 8)}`, decision(p, x.alpha)], plots: { dist: testPlot(normal(0, 1), z, x.tail, 'z') } };
        },
    },
    wilcoxon_signed: {
        type: 'calc',
        inputs: { mode: SEL('Data', { paired: 'Paired samples (before and after)', one: 'One sample against a median' }, 'paired'), a: TXT('Sample 1 (before) or the sample', '125, 132, 118, 140, 128, 135, 122, 130, 138, 126'), b: TXT('Sample 2 (after)', '120, 128, 119, 131, 122, 127, 121, 124, 130, 125'), m0: N('Hypothesised median', 0), tail: TAIL, alpha: ALPHA },
        show: { b: 'mode:paired', m0: 'mode:one' },
        label: 'V (sum of positive ranks)',
        rows: { p: 'p-value', w: 'W = min(V⁺, V⁻)', n: 'Non-zero differences used', method: 'Method', verdict: 'Decision' },
        run: (x) => {
            const A = sample(x.a, 1, 'Sample 1');

            if (!A.xs) {
                return A;
            }

            let d;

            if (x.mode === 'paired') {
                const B = sample(x.b, 1, 'Sample 2');

                if (!B.xs) {
                    return B;
                }

                if (B.xs.length !== A.xs.length) {
                    return { error: 'Paired samples need the same number of values.' };
                }

                d = A.xs.map((v, i) => v - B.xs[i]);
            } else {
                d = A.xs.map((v) => v - (x.m0 || 0));
            }

            const s = signedRank(d, x.tail);

            if (!s.n) {
                return { error: 'Every difference is zero.' };
            }

            return { value: num(s.V), sub: `p = ${pText(s.p)}`, rows: { p: pText(s.p), w: num(s.W), n: `${s.n}${s.dropped ? ` (${s.dropped} zero dropped)` : ''}`, method: s.exact ? 'Exact distribution' : `Normal approximation, z = ${num(s.z, 5)}, tie and continuity corrected`, verdict: decision(s.p, x.alpha) }, steps: [`Differences ${x.mode === 'paired' ? '(sample 1 − sample 2)' : `(x − ${num(x.m0 || 0)})`}; zeros are dropped`, 'Rank the absolute differences (ties share the average rank), then sum the ranks of the positive ones', `V⁺ = ${num(s.V)}, V⁻ = ${num(s.Vminus)}`, 'Tests whether the differences are centred on zero without assuming normality'] };
        },
    },
    kruskal: {
        type: 'calc',
        inputs: { data: TXT('Groups: one per line, optionally named', 'A: 27, 2, 4, 18, 7, 9\nB: 20, 8, 14, 36, 21, 22\nC: 34, 31, 3, 23, 30, 6'), alpha: ALPHA },
        label: 'H statistic',
        rows: { p: 'p-value', df: 'Degrees of freedom', eps: 'ε² (effect size)', verdict: 'Decision' },
        grids: [['table', 'Mean ranks']],
        run: (x) => {
            const groups = String(x.data ?? '').split(/\r?\n/).map((l) => l.trim()).filter(Boolean).map((line, i) => {
                const m = line.match(/^([^:]*[A-Za-z][^:]*):(.*)$/);

                return { name: m ? m[1].trim() : `Group ${i + 1}`, values: parseNumbers(m ? m[2] : line).values };
            }).filter((g) => g.values.length);

            if (groups.length < 2) {
                return { error: 'Enter at least two groups, one per line.' };
            }

            const k = kruskalWallis(groups.map((g) => g.values));

            return { value: num(k.H, 6), sub: `p = ${pText(k.p)}`, rows: { p: pText(k.p), df: String(k.df), eps: num(k.epsilon2, 4), verdict: decision(k.p, x.alpha) }, steps: ['Rank all values together; compare the groups’ mean ranks', 'H = 12 ÷ (N(N + 1)) × Σ Rᵢ²/nᵢ − 3(N + 1), divided by the tie correction', `p from χ² with ${k.df} df (as R’s kruskal.test)`, 'A rank-based alternative to one-way ANOVA'], grids: { table: { columns: ['n', 'Mean rank', 'Median'], rows: groups.map((g, i) => ({ header: g.name, cells: [num(g.values.length), num(k.meanRanks[i], 6), num(median(g.values), 6)] })) } } };
        },
    },
    sign_test: {
        type: 'calc',
        inputs: { mode: SEL('Data', { paired: 'Paired samples', one: 'One sample against a median' }, 'paired'), a: TXT('Sample 1 (before) or the sample', '7, 5, 8, 6, 9, 4, 7, 8, 6, 9, 7'), b: TXT('Sample 2 (after)', '6, 5, 6, 4, 7, 5, 5, 6, 6, 7, 5'), m0: N('Hypothesised median', 0), tail: TAIL, alpha: ALPHA },
        show: { b: 'mode:paired', m0: 'mode:one' },
        label: 'p-value',
        rows: { signs: 'Plus / minus signs', zeros: 'Ties (dropped)', verdict: 'Decision' },
        run: (x) => {
            const A = sample(x.a, 1, 'Sample 1');

            if (!A.xs) {
                return A;
            }

            let d;

            if (x.mode === 'paired') {
                const B = sample(x.b, 1, 'Sample 2');

                if (!B.xs) {
                    return B;
                }

                if (B.xs.length !== A.xs.length) {
                    return { error: 'Paired samples need the same number of values.' };
                }

                d = A.xs.map((v, i) => v - B.xs[i]);
            } else {
                d = A.xs.map((v) => v - (x.m0 || 0));
            }

            const s = signTest(d, x.tail);

            if (!s.n) {
                return { error: 'Every difference is zero.' };
            }

            return { value: pText(s.p), sub: decision(s.p, x.alpha), rows: { signs: `${s.plus} / ${s.minus}`, zeros: String(s.zeros), verdict: decision(s.p, x.alpha) }, steps: ['Count positive and negative differences; under H₀ each is equally likely', `Plus signs ~ Binomial(${s.n}, ½)`, 'Exact binomial p-value; uses only the signs, so it needs no assumptions about shape'] };
        },
    },
    multiple_reg: {
        type: 'calc',
        inputs: { data: TXT('Rows: y, x₁, x₂, … (one observation per line)', '24, 2, 50\n31, 3, 55\n35, 4, 52\n42, 5, 60\n47, 6, 58\n55, 7, 65\n58, 8, 63\n66, 9, 70'), names: TXT('Variable names (optional): y, x₁, x₂, …', 'Sales, Ads, Price') },
        optional: ['names'],
        label: 'Fitted equation',
        rows: { r2: 'R²', adj: 'Adjusted R²', F: 'F test', se: 'Residual standard error' },
        grids: [['coef', 'Coefficients']],
        run: (x) => {
            const rows = parseRows(x.data).map((r) => r.values);
            const k = rows[0]?.length;

            if (!(k >= 2 && k <= 7) || rows.some((r) => r.length !== k)) {
                return { error: 'Each line needs y and 1 to 6 predictors, the same number on every line.' };
            }

            const names = splitItems(x.names);
            const label = (j) => names[j] ?? (j === 0 ? 'y' : `x${'₀₁₂₃₄₅₆₇₈₉'[j]}`);
            const fit = ols(rows.map((r) => [1, ...r.slice(1)]), rows.map((r) => r[0]));

            if (fit.problem) {
                return { error: fit.problem };
            }

            const eq = `${label(0)} = ${num(fit.beta[0], 6)}${fit.beta.slice(1).map((b, j) => ` ${b < 0 ? '−' : '+'} ${num(Math.abs(b), 6)}·${label(j + 1)}`).join('')}`;

            return { value: eq, sub: `R² = ${num(fit.r2, 6)}`, rows: { r2: num(fit.r2, 8), adj: num(fit.adj, 8), F: `F = ${num(fit.F, 6)} (${fit.dfm}, ${fit.dfe} df), p = ${pText(fit.pF)}`, se: num(fit.sigma, 6) }, steps: ['Ordinary least squares: β = argmin Σ(y − Xβ)², solved by QR decomposition', 'Each coefficient is the change in y for one unit of that predictor, holding the others fixed', 'Correlated predictors inflate the standard errors (multicollinearity)'], grids: { coef: { columns: ['Estimate', 'Std. error', 't', 'p-value'], rows: fit.beta.map((b, j) => ({ header: j === 0 ? 'Intercept' : label(j), cells: [num(b, 8), num(fit.se[j], 6), num(fit.t[j], 5), pText(fit.p[j])] })) } } };
        },
    },
    log_power_reg: regTool({ inputs: { model: SEL('Model', { log: 'Logarithmic: y = a + b ln x', power: 'Power: y = a·xᵇ' }, 'log') }, build: (x, p) => {
        if (p.x.length < 3 || p.x.some((v) => v <= 0) || (x.model === 'power' && p.y.some((v) => v <= 0))) {
            return { error: x.model === 'power' ? 'Enter at least 3 points with positive x and y.' : 'Enter at least 3 points with positive x.' };
        }

        return x.model === 'log'
            ? { X: p.x.map((v) => [1, Math.log(v)]), row: (v) => [1, Math.log(v)], y: p.y, predict: (b, v) => b[0] + b[1] * Math.log(v), equation: (b) => `y = ${num(b[0], 6)} ${b[1] < 0 ? '−' : '+'} ${num(Math.abs(b[1]), 6)} ln x`, names: ['a', 'b'], steps: ['Model y = a + b ln x, linear in ln x'] }
            : { X: p.x.map((v) => [1, Math.log(v)]), row: (v) => [1, Math.log(v)], back: Math.exp, y: p.y.map(Math.log), predict: (b, v) => Math.exp(b[0]) * v ** b[1], equation: (b) => `y = ${num(Math.exp(b[0]), 6)} x^${num(b[1], 6)}`, names: ['ln a', 'b'], steps: ['Model y = a·xᵇ, fitted as ln y = ln a + b ln x', 'R² refers to the fit on the log scale'] };
    }, label: 'Fitted curve', sample: '1, 2.1\n2, 3.4\n3, 4.2\n4, 4.7\n6, 5.6\n8, 6.2\n12, 6.9\n16, 7.5' }),
    sample_size: {
        type: 'calc',
        inputs: { type: SEL('Estimating a', { prop: 'Proportion (survey percentage)', mean: 'Mean' }, 'prop'), conf: N('Confidence level (%)', 95, 0), moe: N('Margin of error (± % for proportions)', 5, 0), p: N('Expected proportion (%; 50 = most cautious)', 50, 0), sd: N('Expected standard deviation', 15, 0), N: N('Population size (0 = very large)', 0, 0) },
        show: { p: 'type:prop', sd: 'type:mean' },
        when: { p: (x) => x.type === 'prop', sd: (x) => x.type === 'mean' },
        label: 'Sample size needed',
        rows: { infinite: 'For a very large population', z: 'z', formula: 'Formula' },
        run: (x) => {
            if (!(x.conf > 0 && x.conf < 100) || !(x.moe > 0)) {
                return { error: 'Confidence must be between 0 and 100% and the margin positive.' };
            }

            const z = normInv(1 - (1 - x.conf / 100) / 2);
            const n0 = x.type === 'prop' ? (z * z * (x.p / 100) * (1 - x.p / 100)) / (x.moe / 100) ** 2 : (z * x.sd / x.moe) ** 2;
            const n = x.N > 0 ? n0 / (1 + (n0 - 1) / x.N) : n0;

            return { value: num(Math.ceil(n - 1e-9)), sub: `for ±${num(x.moe)}${x.type === 'prop' ? '%' : ''} at ${num(x.conf)}% confidence`, rows: { infinite: num(Math.ceil(n0 - 1e-9)), z: num(z, 6), formula: x.type === 'prop' ? 'n₀ = z² p(1 − p) ÷ E²' : 'n₀ = (zσ ÷ E)²' }, steps: [x.type === 'prop' ? `n₀ = ${num(z, 6)}² × ${num(x.p / 100)} × ${num(1 - x.p / 100)} ÷ ${num(x.moe / 100)}² = ${num(n0, 8)}` : `n₀ = (${num(z, 6)} × ${num(x.sd)} ÷ ${num(x.moe)})² = ${num(n0, 8)}`, ...(x.N > 0 ? [`Finite population: n = n₀ ÷ (1 + (n₀ − 1)/N) = ${num(n, 8)}`] : []), 'Round up; then allow for people who do not respond (Cochran 1977)'] };
        },
    },
    shannon: {
        type: 'calc',
        inputs: { mode: SEL('From', { probs: 'Probabilities', counts: 'Counts', text: 'A text (character frequencies)' }, 'probs'), probs: TXT('Probabilities (adding up to 1)', '0.5, 0.25, 0.125, 0.125'), counts: TXT('Counts', '40, 30, 20, 10'), text: TXT('Text', 'hello world'), base: SEL('Units', { 2: 'bits (log₂)', 2.718281828459045: 'nats (ln)', 10: 'hartleys (log₁₀)' }, '2') },
        show: { probs: 'mode:probs', counts: 'mode:counts', text: 'mode:text' },
        label: 'Shannon entropy',
        rows: { max: 'Maximum possible (all equal)', efficiency: 'Efficiency H ÷ Hmax', symbols: 'Symbols' },
        run: (x) => {
            let ps;

            if (x.mode === 'text') {
                const chars = [...String(x.text ?? '')];

                if (!chars.length) {
                    return { empty: 'Enter some text.' };
                }

                const counts = new Map();
                chars.forEach((c) => counts.set(c, (counts.get(c) ?? 0) + 1));
                ps = [...counts.values()].map((c) => c / chars.length);
            } else {
                const { values } = parseNumbers(x.mode === 'probs' ? x.probs : x.counts);

                if (!values.length || values.some((v) => v < 0)) {
                    return { error: 'Enter non-negative values.' };
                }

                const total = sum(values);

                if (x.mode === 'probs' && Math.abs(total - 1) > 1e-6) {
                    return { error: `The probabilities add up to ${num(total, 8)}; they must add up to 1.` };
                }

                ps = values.map((v) => v / total);
            }

            const base = Number(x.base);
            const unit = base === 2 ? 'bits' : base === 10 ? 'hartleys' : 'nats';
            const H = entropy(ps, base);
            const k = ps.filter((p) => p > 0).length;
            const Hmax = Math.log(k) / Math.log(base);

            return { value: `${num(H, 8)} ${unit}`, sub: x.mode === 'text' ? `per character (${num(H * [...String(x.text)].length, 6)} ${unit} for the whole text)` : 'per symbol', rows: { max: `${num(Hmax, 8)} ${unit}`, efficiency: k > 1 ? pct(H / Hmax, 5) : '—', symbols: num(k) }, steps: ['H = −Σ pᵢ log pᵢ (Shannon 1948)', `= ${num(H, 10)} ${unit}`, 'Entropy is the average information per symbol: the minimum average code length possible', 'Ecologists use the same formula (with ln) as the Shannon diversity index'] };
        },
    },
    markov: {
        type: 'calc',
        inputs: { matrix: TXT('Transition matrix: row i gives the probabilities of moving from state i', '0.9, 0.075, 0.025\n0.15, 0.8, 0.05\n0.25, 0.25, 0.5'), start: TXT('Starting distribution (or the number of the starting state)', '1'), steps: N('Steps', 3, 0) },
        label: 'Distribution after the steps',
        rows: { steady: 'Steady state (long run)', most: 'Most likely state now' },
        grids: [['table', 'Distribution step by step']],
        run: (x) => {
            const P = parseRows(x.matrix).map((r) => r.values);
            const n = P.length;

            if (n < 2 || P.some((r) => r.length !== n || r.some((v) => v < 0))) {
                return { error: 'Enter a square matrix of non-negative probabilities.' };
            }

            const bad = P.findIndex((r) => Math.abs(sum(r) - 1) > 1e-6);

            if (bad >= 0) {
                return { error: `Row ${bad + 1} adds up to ${num(sum(P[bad]), 8)}; each row must add up to 1.` };
            }

            const s = parseNumbers(x.start).values;
            let dist;

            if (s.length === 1 && Number.isInteger(s[0]) && s[0] >= 1 && s[0] <= n) {
                dist = Array.from({ length: n }, (_, i) => (i === s[0] - 1 ? 1 : 0));
            } else if (s.length === n && Math.abs(sum(s) - 1) < 1e-6) {
                dist = s;
            } else {
                return { error: `Enter a starting state from 1 to ${n}, or ${n} probabilities adding up to 1.` };
            }

            if (!(Number.isInteger(x.steps) && x.steps >= 0 && x.steps <= 10000)) {
                return { error: 'Use 0 to 10,000 steps.' };
            }

            const history = [dist];

            for (let t = 0; t < x.steps; t += 1) {
                dist = step(dist, P);

                if (t < 50) {
                    history.push(dist);
                }
            }

            let pi = Array.from({ length: n }, () => 1 / n);

            for (let t = 0; t < 100000; t += 1) {
                const next = step(pi, P);
                const avg = next.map((v, i) => (v + pi[i]) / 2);
                const change = Math.max(...avg.map((v, i) => Math.abs(v - pi[i])));
                pi = avg;

                if (change < 1e-15) {
                    break;
                }
            }

            const most = dist.indexOf(Math.max(...dist));

            return { value: dist.map((v) => num(v, 6)).join(', '), sub: `after ${x.steps} step${x.steps === 1 ? '' : 's'}`, rows: { steady: pi.map((v) => num(v, 6)).join(', '), most: `State ${most + 1} (${pct(dist[most], 4)})` }, steps: ['Distribution after one step: πₜ₊₁ = πₜ P (row vector times matrix)', `After ${x.steps} steps: π₀ Pⁿ`, 'Steady state π = πP: found by averaged iteration (assumes one closed class of states)'], grids: { table: { columns: Array.from({ length: n }, (_, i) => `State ${i + 1}`), rows: history.map((h, t) => ({ header: `Step ${t}`, cells: h.map((v) => num(v, 5)) })) } } };
        },
    },
    z_table: {
        type: 'calc',
        inputs: { mode: SEL('Look up', { z: 'Probability for a z-score', p: 'z-score for a probability' }, 'z'), z: N('z', 1.96), p: N('Probability (left area)', 0.975, 0) },
        show: { z: 'mode:z', p: 'mode:p' },
        when: { z: (x) => x.mode === 'z', p: (x) => x.mode === 'p' },
        label: 'Left area Φ(z) = P(Z < z)',
        rows: { right: 'Right area P(Z > z)', centre: 'Between 0 and z', two: 'Between −z and z', z: 'z' },
        grids: [['table', 'Standard normal table: P(Z < z) for z = row + column']],
        run: (x) => {
            const z = x.mode === 'z' ? x.z : normInv(x.p);

            if (x.mode === 'p' && !(x.p > 0 && x.p < 1)) {
                return { error: 'The probability must be between 0 and 1.' };
            }

            const rows = [];

            for (let r = -34; r <= 34; r += 1) {
                rows.push({ header: (r / 10).toFixed(1), cells: Array.from({ length: 10 }, (_, c) => normCdf(r / 10 + (r < 0 ? -c : c) / 100).toFixed(4)), highlight: Math.abs(Math.trunc(z * 10) - r) === 0 });
            }

            return { value: num(normCdf(z), 8), sub: `z = ${num(z, 6)}`, rows: { right: num(normSf(z), 8), centre: num(Math.abs(normCdf(z) - 0.5), 8), two: num(1 - 2 * normSf(Math.abs(z)), 8), z: num(z, 8) }, steps: ['Φ(z) is the area under the standard normal curve to the left of z', 'Computed exactly (erfc), so no interpolation between table rows is needed', 'In the table, negative rows step further left: row −1.2, column 0.03 is z = −1.23'], grids: { table: { columns: Array.from({ length: 10 }, (_, c) => `0.0${c}`), rows } } };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
