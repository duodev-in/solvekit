import { mean, ranks, sd, ss, sum, variance } from './data.js';
import { binomial, hypergeometric } from './dist.js';
import { chi2Sf, fSf, lchoose, nctCdf, normCdf, normInv, normSf, tCdf, tInv } from './special.js';

/**
 * Hypothesis tests. Each returns the statistic, degrees of freedom where they apply, and the p-value for the
 * requested tail ('two', 'left' or 'right'). Conventions follow R's stats package (t.test, chisq.test,
 * fisher.test, mcnemar.test, wilcox.test, kruskal.test), which the reference tests compare against.
 */

export const TAILS = { two: 'Two-tailed (≠)', left: 'Left-tailed (<)', right: 'Right-tailed (>)' };

/** p-value of a z statistic. */
export const zP = (z, tail) => (tail === 'left' ? normCdf(z) : tail === 'right' ? normSf(z) : 2 * normSf(Math.abs(z)));

/** p-value of a t statistic. */
export const tP = (t, df, tail) => (tail === 'left' ? tCdf(t, df) : tail === 'right' ? tCdf(-t, df) : 2 * tCdf(-Math.abs(t), df));

/** Critical values for a tail and α: z or t. */
export const zCrit = (alpha, tail) => (tail === 'two' ? normInv(1 - alpha / 2) : normInv(1 - alpha));
export const tCrit = (alpha, df, tail) => (tail === 'two' ? tInv(1 - alpha / 2, df) : tInv(1 - alpha, df));

/** The null and alternative hypotheses as text. */
export const hypotheses = (param, value, tail) => [`H₀: ${param} = ${value}`, `H₁: ${param} ${tail === 'left' ? '<' : tail === 'right' ? '>' : '≠'} ${value}`];

/** A plain-words decision. */
export const decision = (p, alpha) => (p < alpha ? `Reject H₀ at α = ${alpha} (p < α)` : `Do not reject H₀ at α = ${alpha} (p ≥ α)`);

/** One-sample t from a summary. */
export function tOne(m, s, n, mu0, tail) {
    const se = s / Math.sqrt(n);
    const t = (m - mu0) / se;
    const df = n - 1;

    return { t, df, se, p: tP(t, df, tail), d: (m - mu0) / s };
}

/** Two-sample t: Welch (unequal variances) or pooled (Student). */
export function tTwo(m1, s1, n1, m2, s2, n2, tail, pooled = false, delta0 = 0) {
    if (pooled) {
        const sp2 = ((n1 - 1) * s1 * s1 + (n2 - 1) * s2 * s2) / (n1 + n2 - 2);
        const se = Math.sqrt(sp2 * (1 / n1 + 1 / n2));
        const t = (m1 - m2 - delta0) / se;
        const df = n1 + n2 - 2;

        return { t, df, se, p: tP(t, df, tail), sp: Math.sqrt(sp2), d: (m1 - m2) / Math.sqrt(sp2) };
    }

    const v1 = (s1 * s1) / n1;
    const v2 = (s2 * s2) / n2;
    const se = Math.sqrt(v1 + v2);
    const t = (m1 - m2 - delta0) / se;
    const df = (v1 + v2) ** 2 / (v1 * v1 / (n1 - 1) + v2 * v2 / (n2 - 1));
    const sp = Math.sqrt(((n1 - 1) * s1 * s1 + (n2 - 1) * s2 * s2) / (n1 + n2 - 2));

    return { t, df, se, p: tP(t, df, tail), sp, d: (m1 - m2) / sp };
}

/** χ² goodness of fit: observed counts against expected counts or proportions. */
export function chiGoodness(obs, expected) {
    const total = sum(obs);
    const expSum = sum(expected);
    const e = expected.map((x) => (x * total) / expSum);
    const chi2 = sum(obs.map((o, i) => (o - e[i]) ** 2 / e[i]));
    const df = obs.length - 1;

    return { chi2, df, p: chi2Sf(chi2, df), e };
}

/** χ² test of independence on an r × c table (Yates' correction optional, 2 × 2 only, as in R). */
export function chiIndependence(table, yates = false) {
    const rows = table.map((r) => sum(r));
    const cols = table[0].map((_, j) => sum(table.map((r) => r[j])));
    const n = sum(rows);
    const e = table.map((r, i) => r.map((_, j) => (rows[i] * cols[j]) / n));
    const correct = yates && table.length === 2 && table[0].length === 2;
    const half = correct ? Math.min(0.5, ...table.flatMap((r, i) => r.map((o, j) => Math.abs(o - e[i][j])))) : 0;
    const chi2 = sum(table.flatMap((r, i) => r.map((o, j) => (Math.abs(o - e[i][j]) - half) ** 2 / e[i][j])));
    const df = (table.length - 1) * (table[0].length - 1);
    const v = Math.sqrt(chi2 / (n * Math.min(table.length - 1, table[0].length - 1)));

    return { chi2, df, p: chi2Sf(chi2, df), e, n, cramersV: v, rows, cols };
}

/** One-way ANOVA on groups of data. */
export function anova(groups) {
    const all = groups.flat();
    const grand = mean(all);
    const ssb = sum(groups.map((g) => g.length * (mean(g) - grand) ** 2));
    const ssw = sum(groups.map((g) => ss(g)));
    const dfb = groups.length - 1;
    const dfw = all.length - groups.length;
    const msb = ssb / dfb;
    const msw = ssw / dfw;
    const F = msb / msw;

    return { ssb, ssw, sst: ssb + ssw, dfb, dfw, msb, msw, F, p: fSf(F, dfb, dfw), eta2: ssb / (ssb + ssw), omega2: (ssb - dfb * msw) / (ssb + ssw + msw) };
}

/**
 * Fisher's exact test on [[a, b], [c, d]]. Two-sided p sums every table no more likely than the observed one
 * (relative tolerance 1e-7, as in R); 'less' and 'greater' refer to the odds ratio.
 */
export function fisherExact(a, b, c, d) {
    const N = a + b + c + d;
    const K = a + c;
    const n = a + b;
    const h = hypergeometric(N, K, n);
    const pObs = h.pdf(a);
    let two = 0;

    for (let k = h.lo; k <= h.hi; k += 1) {
        const q = h.pdf(k);

        if (q <= pObs * (1 + 1e-7)) {
            two += q;
        }
    }

    return { p: Math.min(1, two), less: h.cdf(a), greater: 1 - h.cdf(a - 1), pObs, oddsRatio: (a * d) / (b * c) };
}

/** McNemar's test on the discordant counts b and c: χ² with or without continuity correction, and exact binomial. */
export function mcnemar(b, c, correct = true) {
    const chi2 = b + c === 0 ? 0 : (Math.max(0, Math.abs(b - c) - (correct ? 1 : 0))) ** 2 / (b + c);
    const bin = binomial(b + c, 0.5);
    const exact = b + c === 0 ? 1 : Math.min(1, 2 * Math.min(bin.cdf(Math.min(b, c)), 1 - bin.cdf(Math.max(b, c) - 1)));

    return { chi2, p: chi2Sf(chi2, 1), exact };
}

/** Exact null distribution of the Mann–Whitney U for sizes m and n (no ties): P(U = u). */
function uDistribution(m, n) {
    // Counts of ways via the recurrence f(m, n, u) = f(m − 1, n, u − n) + f(m, n − 1, u), with probabilities.
    let table = Array.from({ length: n + 1 }, () => [1]);

    for (let i = 1; i <= m; i += 1) {
        const next = [[1]];

        for (let j = 1; j <= n; j += 1) {
            const size = i * j + 1;
            const row = new Array(size).fill(0);

            for (let u = 0; u < size; u += 1) {
                const a = u - j >= 0 ? (table[j][u - j] ?? 0) : 0;
                const b = next[j - 1][u] ?? 0;
                row[u] = (i * a + j * b) / (i + j);
            }

            next.push(row);
        }

        table = next;
    }

    return table[n];
}

/**
 * Mann–Whitney U / Wilcoxon rank-sum test (x against y). Exact p when both samples have fewer than 50 values
 * and there are no ties; otherwise the normal approximation with tie and continuity corrections (as R).
 */
export function mannWhitney(x, y, tail, { exact = null, correct = true } = {}) {
    const m = x.length;
    const n = y.length;
    const { r, ties } = ranks([...x, ...y]);
    const R1 = sum(r.slice(0, m));
    const U1 = R1 - (m * (m + 1)) / 2;
    const U2 = m * n - U1;
    const useExact = exact ?? (m < 50 && n < 50 && !ties.length);
    let p;
    let z = NaN;

    if (useExact) {
        const dist = uDistribution(m, n);
        const cdf = (u) => sum(dist.slice(0, Math.floor(u + 1e-9) + 1));
        const left = cdf(U1);
        const right = 1 - cdf(U1 - 1);
        p = tail === 'left' ? left : tail === 'right' ? right : Math.min(1, 2 * Math.min(left, right));
    } else {
        const tieTerm = sum(ties.map((t) => t ** 3 - t));
        const sigma = Math.sqrt((m * n / 12) * (m + n + 1 - tieTerm / ((m + n) * (m + n - 1))));
        const diff = U1 - (m * n) / 2;
        const cc = correct ? (tail === 'two' ? Math.sign(diff) * 0.5 : tail === 'right' ? 0.5 : -0.5) : 0;
        z = (diff - cc) / sigma;
        p = zP(z, tail);
    }

    const zEffect = (U1 - (m * n) / 2) / Math.sqrt((m * n * (m + n + 1)) / 12);

    return { U1, U2, U: Math.min(U1, U2), W: R1, R1, R2: sum(r.slice(m)), p: Math.min(1, p), z, exact: useExact, ties: ties.length, r: Math.abs(zEffect) / Math.sqrt(m + n), ranks: r };
}

/** Exact null distribution of the Wilcoxon signed-rank statistic V for n pairs: P(V = v). */
function signedRankDistribution(n) {
    let dist = [1];

    for (let k = 1; k <= n; k += 1) {
        const next = new Array(dist.length + k).fill(0);
        dist.forEach((p, v) => {
            next[v] += p / 2;
            next[v + k] += p / 2;
        });
        dist = next;
    }

    return dist;
}

/**
 * Wilcoxon signed-rank test on differences d (zeros dropped). Exact when n < 50 with no ties, otherwise normal
 * with tie and continuity corrections (as R). V is the sum of positive ranks.
 */
export function signedRank(d, tail, { correct = true } = {}) {
    const nz = d.filter((x) => x !== 0);
    const n = nz.length;
    const { r, ties } = ranks(nz.map(Math.abs));
    const V = sum(r.filter((_, i) => nz[i] > 0));
    const Vminus = (n * (n + 1)) / 2 - V;
    const useExact = n < 50 && !ties.length && nz.length === d.length;
    let p;
    let z = NaN;

    if (useExact) {
        const dist = signedRankDistribution(n);
        const cdf = (v) => sum(dist.slice(0, Math.floor(v + 1e-9) + 1));
        const left = cdf(V);
        const right = 1 - cdf(V - 1);
        p = tail === 'left' ? left : tail === 'right' ? right : Math.min(1, 2 * Math.min(left, right));
    } else {
        const tieTerm = sum(ties.map((t) => t ** 3 - t));
        const sigma = Math.sqrt((n * (n + 1) * (2 * n + 1)) / 24 - tieTerm / 48);
        const diff = V - (n * (n + 1)) / 4;
        const cc = correct ? (tail === 'two' ? Math.sign(diff) * 0.5 : tail === 'right' ? 0.5 : -0.5) : 0;
        z = (diff - cc) / sigma;
        p = zP(z, tail);
    }

    return { V, Vminus, W: Math.min(V, Vminus), n, dropped: d.length - n, p: Math.min(1, p), z, exact: useExact, ranks: r, values: nz };
}

/** Sign test: exact binomial on the signs of d (zeros dropped). */
export function signTest(d, tail) {
    const plus = d.filter((x) => x > 0).length;
    const minus = d.filter((x) => x < 0).length;
    const n = plus + minus;
    const b = binomial(n, 0.5);
    const left = b.cdf(plus);
    const right = 1 - b.cdf(plus - 1);

    return { plus, minus, n, zeros: d.length - n, p: tail === 'left' ? left : tail === 'right' ? right : Math.min(1, 2 * Math.min(left, right)) };
}

/** Kruskal–Wallis H with tie correction; p from χ² with k − 1 df. */
export function kruskalWallis(groups) {
    const all = groups.flat();
    const N = all.length;
    const { r, ties } = ranks(all);
    let start = 0;
    const meanRanks = [];
    let H = 0;

    for (const g of groups) {
        const Ri = sum(r.slice(start, start + g.length));
        meanRanks.push(Ri / g.length);
        H += (Ri * Ri) / g.length;
        start += g.length;
    }

    H = (12 / (N * (N + 1))) * H - 3 * (N + 1);
    const C = 1 - sum(ties.map((t) => t ** 3 - t)) / (N ** 3 - N);
    const Hc = H / C;
    const df = groups.length - 1;

    return { H: Hc, Hraw: H, df, p: chi2Sf(Hc, df), meanRanks, epsilon2: Hc / ((N * N - 1) / (N + 1)) };
}

/** Exact null distribution of Kendall's discordant-pair count for n untied values (Mahonian numbers), as probabilities. */
function kendallDistribution(n) {
    let dist = [1];

    for (let k = 2; k <= n; k += 1) {
        const next = new Array(dist.length + k - 1).fill(0);
        dist.forEach((p, s) => {
            for (let j = 0; j < k; j += 1) {
                next[s + j] += p / k;
            }
        });
        dist = next;
    }

    return dist;
}

/** Kendall's τ-b with tie correction; exact p for n < 50 without ties, otherwise normal with tie-adjusted variance (as R). */
export function kendall(x, y, tail = 'two') {
    const n = x.length;
    let C = 0;
    let D = 0;
    let tx = 0;
    let ty = 0;

    for (let i = 0; i < n; i += 1) {
        for (let j = i + 1; j < n; j += 1) {
            const s = Math.sign(x[i] - x[j]) * Math.sign(y[i] - y[j]);

            if (s > 0) {
                C += 1;
            } else if (s < 0) {
                D += 1;
            } else {
                if (x[i] === x[j]) {
                    tx += 1;
                }

                if (y[i] === y[j]) {
                    ty += 1;
                }
            }
        }
    }

    const n0 = (n * (n - 1)) / 2;
    const tau = (C - D) / Math.sqrt((n0 - tx) * (n0 - ty));
    const tieX = ranks(x).ties;
    const tieY = ranks(y).ties;
    const exact = n < 50 && !tieX.length && !tieY.length;
    let p;
    let z = NaN;

    if (exact) {
        const dist = kendallDistribution(n);
        const cdf = (k) => sum(dist.slice(0, Math.floor(k + 1e-9) + 1));
        // τ = 1 − 4D / (n(n − 1)): small D means large τ.
        const left = 1 - cdf(D - 1);
        const right = cdf(D);
        p = tail === 'left' ? left : tail === 'right' ? right : Math.min(1, 2 * Math.min(left, right));
    } else {
        const v0 = n * (n - 1) * (2 * n + 5);
        const vt = sum(tieX.map((t) => t * (t - 1) * (2 * t + 5)));
        const vu = sum(tieY.map((t) => t * (t - 1) * (2 * t + 5)));
        const v1 = sum(tieX.map((t) => t * (t - 1))) * sum(tieY.map((t) => t * (t - 1)));
        const v2 = sum(tieX.map((t) => t * (t - 1) * (t - 2))) * sum(tieY.map((t) => t * (t - 1) * (t - 2)));
        const varS = (v0 - vt - vu) / 18 + v1 / (2 * n * (n - 1)) + v2 / (9 * n * (n - 1) * (n - 2));
        z = (C - D) / Math.sqrt(varS);
        p = zP(z, tail);
    }

    return { tau, C, D, tx, ty, p: Math.min(1, p), z, exact };
}

/** Pearson r with its t test and Fisher-z confidence interval. */
export function correlationTest(r, n, tail = 'two', conf = 0.95) {
    const df = n - 2;
    const t = (r * Math.sqrt(df)) / Math.sqrt(1 - r * r);
    const z = Math.atanh(r);
    const se = 1 / Math.sqrt(n - 3);
    const zc = normInv(1 - (1 - conf) / 2);

    return { t, df, p: Math.abs(r) === 1 ? 0 : tP(t, df, tail), lo: Math.tanh(z - zc * se), hi: Math.tanh(z + zc * se) };
}

/** Wilson score interval for a proportion x/n. */
export function wilson(x, n, conf = 0.95) {
    const z = normInv(1 - (1 - conf) / 2);
    const p = x / n;
    const centre = (p + (z * z) / (2 * n)) / (1 + (z * z) / n);
    const half = (z / (1 + (z * z) / n)) * Math.sqrt((p * (1 - p)) / n + (z * z) / (4 * n * n));

    return [Math.max(0, centre - half), Math.min(1, centre + half)];
}

/** Grubbs' test for one outlier (two-sided): G, its critical value and an upper bound on p. */
export function grubbs(xs, alpha = 0.05) {
    const n = xs.length;
    const m = mean(xs);
    const s = sd(xs);
    const devs = xs.map((x) => Math.abs(x - m));
    const G = Math.max(...devs);
    const suspect = xs[devs.indexOf(G)];
    const g = G / s;
    const tc = tInv(1 - alpha / (2 * n), n - 2);
    const crit = ((n - 1) / Math.sqrt(n)) * Math.sqrt((tc * tc) / (n - 2 + tc * tc));
    const t = Math.sqrt((n * (n - 2) * g * g) / ((n - 1) ** 2 - n * g * g));
    const p = Number.isFinite(t) ? Math.min(1, 2 * n * tCdf(-t, n - 2)) : 0;

    return { G: g, crit, suspect, p, outlier: g > crit };
}

/** Power of a t-test (one-sample/paired: groups 1; two independent equal groups: groups 2) via the noncentral t. */
export function tPower(d, n, alpha, tail, groups = 1) {
    const df = groups === 1 ? n - 1 : 2 * n - 2;
    const delta = groups === 1 ? d * Math.sqrt(n) : d * Math.sqrt(n / 2);

    if (tail === 'two') {
        const tc = tInv(1 - alpha / 2, df);

        return 1 - nctCdf(tc, df, delta) + nctCdf(-tc, df, delta);
    }

    const tc = tInv(1 - alpha, df);

    return tail === 'right' ? 1 - nctCdf(tc, df, delta) : nctCdf(-tc, df, delta);
}

/** Smallest n (per group) reaching the target power. */
export function tSampleSize(d, power, alpha, tail, groups = 1) {
    let n = 2;

    while (n < 1e6 && tPower(Math.abs(d), n, alpha, tail === 'left' ? 'right' : tail, groups) < power) {
        n = n < 100 ? n + 1 : Math.ceil(n * 1.01);
    }

    return n;
}

/** Variance of an array (sample) — re-exported for tools that compute their own tests. */
export { variance };
