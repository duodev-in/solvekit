import { betaI, chi2Cdf, chi2Pdf, chi2Sf, fCdf, fPdf, fSf, gammaP, gammaQ, invert, lbeta, lchoose, lgamma, normCdf, normInv, normPdf, normSf, tCdf, tPdf } from './special.js';

/**
 * Probability distributions: each returns { pdf, cdf, sf, inv, mean, variance, discrete, lo, hi } where
 * lo/hi give a plotting range. Discrete CDFs are exact sums (via the incomplete beta and gamma functions
 * where a closed form exists), so P(X ≤ k) is right even for large n.
 */

/** Discrete quantile: the smallest integer k with cdf(k) ≥ p. */
function discreteInv(cdf, p, lo, hi) {
    if (p <= 0) {
        return lo;
    }

    let a = lo;
    let b = Number.isFinite(hi) ? hi : Math.max(lo + 1, 16);

    while (!Number.isFinite(hi) && cdf(b) < p) {
        b *= 2;
    }

    while (a < b) {
        const m = Math.floor((a + b) / 2);

        if (cdf(m) >= p - 1e-14) {
            b = m;
        } else {
            a = m + 1;
        }
    }

    return a;
}

export const normal = (mu, sigma) => ({
    pdf: (x) => normPdf((x - mu) / sigma) / sigma,
    cdf: (x) => normCdf((x - mu) / sigma),
    sf: (x) => normSf((x - mu) / sigma),
    inv: (p) => mu + sigma * normInv(p),
    mean: mu,
    variance: sigma * sigma,
    lo: mu - 4 * sigma,
    hi: mu + 4 * sigma,
});

export const studentT = (df) => ({
    pdf: (t) => tPdf(t, df),
    cdf: (t) => tCdf(t, df),
    sf: (t) => tCdf(-t, df),
    inv: (p) => invert((t) => tCdf(t, df), p, normInv(p) - 1, normInv(p) + 1),
    mean: df > 1 ? 0 : NaN,
    variance: df > 2 ? df / (df - 2) : df > 1 ? Infinity : NaN,
    lo: -Math.max(4, Math.min(8, 4 + 8 / df)),
    hi: Math.max(4, Math.min(8, 4 + 8 / df)),
});

export const chiSquare = (k) => ({
    pdf: (x) => chi2Pdf(x, k),
    cdf: (x) => chi2Cdf(x, k),
    sf: (x) => chi2Sf(x, k),
    inv: (p) => invert((x) => chi2Cdf(x, k), p, 0, Math.max(1, 2 * k), { min: 0 }),
    mean: k,
    variance: 2 * k,
    lo: 0,
    hi: k + 5 * Math.sqrt(2 * k) + 2,
});

export const fisherF = (d1, d2) => ({
    pdf: (x) => fPdf(x, d1, d2),
    cdf: (x) => fCdf(x, d1, d2),
    sf: (x) => fSf(x, d1, d2),
    inv: (p) => invert((x) => fCdf(x, d1, d2), p, 0, 5, { min: 0 }),
    mean: d2 > 2 ? d2 / (d2 - 2) : NaN,
    variance: d2 > 4 ? (2 * d2 * d2 * (d1 + d2 - 2)) / (d1 * (d2 - 2) ** 2 * (d2 - 4)) : NaN,
    lo: 0,
    hi: Math.max(4, invert((x) => fCdf(x, d1, d2), 0.995, 0, 5, { min: 0 })),
});

export const gammaDist = (shape, scale) => ({
    pdf: (x) => (x < 0 ? 0 : x === 0 ? (shape === 1 ? 1 / scale : shape < 1 ? Infinity : 0) : Math.exp((shape - 1) * Math.log(x) - x / scale - lgamma(shape) - shape * Math.log(scale))),
    cdf: (x) => gammaP(shape, Math.max(0, x) / scale),
    sf: (x) => gammaQ(shape, Math.max(0, x) / scale),
    inv: (p) => invert((x) => gammaP(shape, x / scale), p, 0, shape * scale * 2 + scale, { min: 0 }),
    mean: shape * scale,
    variance: shape * scale * scale,
    lo: 0,
    hi: shape * scale + 5 * Math.sqrt(shape) * scale,
});

export const exponential = (rate) => ({
    pdf: (x) => (x < 0 ? 0 : rate * Math.exp(-rate * x)),
    cdf: (x) => (x < 0 ? 0 : -Math.expm1(-rate * x)),
    sf: (x) => (x < 0 ? 1 : Math.exp(-rate * x)),
    inv: (p) => -Math.log1p(-p) / rate,
    mean: 1 / rate,
    variance: 1 / (rate * rate),
    lo: 0,
    hi: 5 / rate,
});

export const betaDist = (a, b) => ({
    pdf: (x) => (x < 0 || x > 1 ? 0 : Math.exp((a - 1) * Math.log(x) + (b - 1) * Math.log1p(-x) - lbeta(a, b))),
    cdf: (x) => betaI(a, b, x),
    sf: (x) => 1 - betaI(a, b, x),
    inv: (p) => invert((x) => betaI(a, b, x), p, 0, 1, { min: 0, max: 1 }),
    mean: a / (a + b),
    variance: (a * b) / ((a + b) ** 2 * (a + b + 1)),
    lo: 0,
    hi: 1,
});

export const lognormal = (mu, sigma) => ({
    pdf: (x) => (x <= 0 ? 0 : normPdf((Math.log(x) - mu) / sigma) / (sigma * x)),
    cdf: (x) => (x <= 0 ? 0 : normCdf((Math.log(x) - mu) / sigma)),
    sf: (x) => (x <= 0 ? 1 : normSf((Math.log(x) - mu) / sigma)),
    inv: (p) => Math.exp(mu + sigma * normInv(p)),
    mean: Math.exp(mu + (sigma * sigma) / 2),
    variance: Math.expm1(sigma * sigma) * Math.exp(2 * mu + sigma * sigma),
    lo: 0,
    hi: Math.exp(mu + 3 * sigma),
});

export const uniform = (a, b) => ({
    pdf: (x) => (x < a || x > b ? 0 : 1 / (b - a)),
    cdf: (x) => (x <= a ? 0 : x >= b ? 1 : (x - a) / (b - a)),
    sf: (x) => (x <= a ? 1 : x >= b ? 0 : (b - x) / (b - a)),
    inv: (p) => a + p * (b - a),
    mean: (a + b) / 2,
    variance: (b - a) ** 2 / 12,
    lo: a - (b - a) * 0.15,
    hi: b + (b - a) * 0.15,
});

export const weibull = (k, lambda) => ({
    pdf: (x) => (x < 0 ? 0 : (k / lambda) * (x / lambda) ** (k - 1) * Math.exp(-((x / lambda) ** k))),
    cdf: (x) => (x <= 0 ? 0 : -Math.expm1(-((x / lambda) ** k))),
    sf: (x) => (x <= 0 ? 1 : Math.exp(-((x / lambda) ** k))),
    inv: (p) => lambda * (-Math.log1p(-p)) ** (1 / k),
    mean: lambda * Math.exp(lgamma(1 + 1 / k)),
    variance: lambda * lambda * (Math.exp(lgamma(1 + 2 / k)) - Math.exp(2 * lgamma(1 + 1 / k))),
    lo: 0,
    hi: lambda * (-Math.log(0.001)) ** (1 / k),
});

export const rayleigh = (sigma) => ({
    pdf: (x) => (x < 0 ? 0 : (x / (sigma * sigma)) * Math.exp((-x * x) / (2 * sigma * sigma))),
    cdf: (x) => (x <= 0 ? 0 : -Math.expm1((-x * x) / (2 * sigma * sigma))),
    sf: (x) => (x <= 0 ? 1 : Math.exp((-x * x) / (2 * sigma * sigma))),
    inv: (p) => sigma * Math.sqrt(-2 * Math.log1p(-p)),
    mean: sigma * Math.sqrt(Math.PI / 2),
    variance: ((4 - Math.PI) / 2) * sigma * sigma,
    lo: 0,
    hi: 4 * sigma,
});

/** Binomial(n, p): P(X ≤ k) = I_{1−p}(n − k, k + 1). */
export const binomial = (n, p) => {
    const pmf = (k) => {
        if (k < 0 || k > n || k !== Math.floor(k)) {
            return 0;
        }

        if (p === 0 || p === 1) {
            return (p === 0 && k === 0) || (p === 1 && k === n) ? 1 : 0;
        }

        return Math.exp(lchoose(n, k) + k * Math.log(p) + (n - k) * Math.log1p(-p));
    };
    const cdf = (k) => (k < 0 ? 0 : k >= n ? 1 : betaI(n - Math.floor(k), Math.floor(k) + 1, 1 - p));

    return { pdf: pmf, cdf, sf: (k) => 1 - cdf(k), inv: (q) => discreteInv(cdf, q, 0, n), mean: n * p, variance: n * p * (1 - p), discrete: true, lo: 0, hi: n };
};

/** Poisson(λ): P(X ≤ k) = Q(k + 1, λ). */
export const poisson = (lambda) => {
    const pmf = (k) => (k < 0 || k !== Math.floor(k) ? 0 : Math.exp(k * Math.log(lambda) - lambda - lgamma(k + 1)));
    const cdf = (k) => (k < 0 ? 0 : gammaQ(Math.floor(k) + 1, lambda));

    return { pdf: pmf, cdf, sf: (k) => 1 - cdf(k), inv: (q) => discreteInv(cdf, q, 0, Infinity), mean: lambda, variance: lambda, discrete: true, lo: 0, hi: Math.ceil(lambda + 5 * Math.sqrt(lambda) + 3) };
};

/** Geometric: trials to the first success (k = 1, 2, …) or failures before it (k = 0, 1, …). */
export const geometric = (p, failures = false) => {
    const start = failures ? 0 : 1;
    const pmf = (k) => (k < start || k !== Math.floor(k) ? 0 : (1 - p) ** (k - start) * p);
    const cdf = (k) => (k < start ? 0 : -Math.expm1((Math.floor(k) - start + 1) * Math.log1p(-p)));

    return { pdf: pmf, cdf, sf: (k) => 1 - cdf(k), inv: (q) => discreteInv(cdf, q, start, Infinity), mean: failures ? (1 - p) / p : 1 / p, variance: (1 - p) / (p * p), discrete: true, lo: start, hi: Math.ceil(start + Math.log(0.001) / Math.log1p(-p)) };
};

/** Negative binomial: failures before the r-th success (k = 0, 1, …) or trials to it (k = r, r + 1, …). */
export const negBinomial = (r, p, trials = false) => {
    const shift = trials ? r : 0;
    const pmf = (k) => {
        const f = k - shift;

        return f < 0 || f !== Math.floor(f) ? 0 : Math.exp(lgamma(f + r) - lgamma(r) - lgamma(f + 1) + r * Math.log(p) + f * Math.log1p(-p));
    };
    const cdf = (k) => (k - shift < 0 ? 0 : betaI(r, Math.floor(k - shift) + 1, p));
    const mean = (r * (1 - p)) / p + shift;

    return { pdf: pmf, cdf, sf: (k) => 1 - cdf(k), inv: (q) => discreteInv(cdf, q, shift, Infinity), mean, variance: (r * (1 - p)) / (p * p), discrete: true, lo: shift, hi: Math.ceil(mean + 5 * Math.sqrt((r * (1 - p)) / (p * p)) + 3) };
};

/** Hypergeometric: population N with K successes, n drawn without replacement. */
export const hypergeometric = (N, K, n) => {
    const lo = Math.max(0, n - (N - K));
    const hi = Math.min(n, K);
    const pmf = (k) => (k < lo || k > hi || k !== Math.floor(k) ? 0 : Math.exp(lchoose(K, k) + lchoose(N - K, n - k) - lchoose(N, n)));
    const cdf = (k) => {
        let sum = 0;

        for (let j = lo; j <= Math.min(Math.floor(k), hi); j += 1) {
            sum += pmf(j);
        }

        return Math.min(1, sum);
    };

    return { pdf: pmf, cdf, sf: (k) => 1 - cdf(k), inv: (q) => discreteInv(cdf, q, lo, hi), mean: (n * K) / N, variance: (n * K * (N - K) * (N - n)) / (N * N * (N - 1)), discrete: true, lo, hi };
};

/**
 * Probability that a discrete or continuous variable falls in a stated region:
 * mode 'le' P(X ≤ a), 'lt' P(X < a), 'ge', 'gt', 'eq', 'between' P(a ≤ X ≤ b), 'outside'.
 */
export function regionProbability(d, mode, a, b) {
    if (d.discrete) {
        const le = (k) => d.cdf(Math.floor(k + 1e-9));
        const lt = (k) => d.cdf(Math.ceil(k - 1e-9) - 1);

        return { le: le(a), lt: lt(a), ge: 1 - lt(a), gt: 1 - le(a), eq: d.pdf(a), between: le(b) - lt(a), outside: 1 - (le(b) - lt(a)) }[mode];
    }

    return { le: d.cdf(a), lt: d.cdf(a), ge: d.sf(a), gt: d.sf(a), eq: 0, between: d.cdf(b) - d.cdf(a), outside: d.cdf(a) + d.sf(b) }[mode];
}

/** Text for a region, e.g. "P(X ≤ 7)". */
export const regionText = (mode, a, b, fmt, name = 'X') => ({ le: `P(${name} ≤ ${fmt(a)})`, lt: `P(${name} < ${fmt(a)})`, ge: `P(${name} ≥ ${fmt(a)})`, gt: `P(${name} > ${fmt(a)})`, eq: `P(${name} = ${fmt(a)})`, between: `P(${fmt(a)} ≤ ${name} ≤ ${fmt(b)})`, outside: `P(${name} < ${fmt(a)} or ${name} > ${fmt(b)})` }[mode]);

/** Whether a value x is inside the region (for shading). */
export const inRegion = (mode, x, a, b) => ({ le: x <= a, lt: x < a, ge: x >= a, gt: x > a, eq: x === a, between: x >= a && x <= b, outside: x < a || x > b }[mode]);

/**
 * Plot of a distribution with the region shaded: a curve for continuous ones, bars for discrete ones.
 */
export function distPlot(d, mode, a, b, { xLabel = 'x', lo = d.lo, hi = d.hi } = {}) {
    if (d.discrete) {
        const from = Math.max(d.lo, Math.floor(lo));
        const to = Math.min(d.hi, Math.ceil(hi));
        const step = Math.max(1, Math.ceil((to - from + 1) / 60));
        const bars = [];

        for (let k = from; k <= to; k += step) {
            bars.push({ x: k, y: d.pdf(k), hi: mode ? inRegion(mode, k, a, b) : false });
        }

        return { kind: 'bars', bars, xLabel, yLabel: 'P(X = k)' };
    }

    const n = 160;
    const series = [];

    for (let j = 0; j <= n; j += 1) {
        const x = lo + ((hi - lo) * j) / n;
        series.push([x, d.pdf(x)]);
    }

    const finite = series.filter(([, y]) => Number.isFinite(y));
    const top = Math.max(...finite.map(([, y]) => y));
    const cap = (y) => (Number.isFinite(y) ? Math.min(y, top) : top);
    const intervals = { le: [[lo, a]], lt: [[lo, a]], ge: [[a, hi]], gt: [[a, hi]], between: [[a, b]], outside: [[lo, a], [b, hi]] }[mode] ?? [];
    const areas = intervals
        .map(([from, to]) => [Math.max(from, lo), Math.min(to, hi)])
        .filter(([from, to]) => to > from)
        .map(([from, to]) => Array.from({ length: 81 }, (_, j) => from + ((to - from) * j) / 80).map((x) => [x, cap(d.pdf(x))]));

    return { series: series.map(([x, y]) => [x, cap(y)]), areas, xLabel, yLabel: 'Density', yMin: 0 };
}
