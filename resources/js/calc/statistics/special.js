/**
 * Special functions for the Statistics section: log-gamma, the regularised incomplete gamma and beta
 * functions, erf, and the CDFs and quantiles of the normal, t, χ² and F distributions.
 *
 * Methods: Lanczos log-gamma (g = 7, 9 terms); incomplete gamma by series and Lentz continued fraction;
 * incomplete beta by Lentz continued fraction (Numerical Recipes §6.2–6.4); inverse normal by Wichura's
 * AS 241 (PPND16, about 1e-16); other quantiles by safeguarded bisection on the CDF; noncentral t by
 * Lenth's AS 243. Accurate to about 1e-12 relative in normal ranges.
 */

const LANCZOS = [0.99999999999980993, 676.5203681218851, -1259.1392167224028, 771.32342877765313, -176.61502916214059, 12.507343278686905, -0.13857109526572012, 9.9843695780195716e-6, 1.5056327351493116e-7];

/** ln Γ(x) for x > 0. */
export function lgamma(x) {
    if (x < 0.5) {
        return Math.log(Math.PI / Math.abs(Math.sin(Math.PI * x))) - lgamma(1 - x);
    }

    const z = x - 1;
    let a = LANCZOS[0];
    const t = z + 7.5;

    for (let k = 1; k < 9; k += 1) {
        a += LANCZOS[k] / (z + k);
    }

    return 0.5 * Math.log(2 * Math.PI) + (z + 0.5) * Math.log(t) - t + Math.log(a);
}

/** Γ(x). */
export const gamma = (x) => (x > 0 ? Math.exp(lgamma(x)) : Math.PI / (Math.sin(Math.PI * x) * Math.exp(lgamma(1 - x))));

/** ln(n!) exactly from a table for small n. */
const FACT = [1];
for (let k = 1; k <= 170; k += 1) {
    FACT[k] = FACT[k - 1] * k;
}
export const lfact = (n) => (n <= 170 ? Math.log(FACT[n]) : lgamma(n + 1));

/** ln C(n, k). */
export const lchoose = (n, k) => (k < 0 || k > n ? -Infinity : lfact(n) - lfact(k) - lfact(n - k));

/** ln B(a, b). */
export const lbeta = (a, b) => lgamma(a) + lgamma(b) - lgamma(a + b);

const EPS = 1e-16;
const TINY = 1e-300;

function gammaSeries(a, x) {
    let sum = 1 / a;
    let term = sum;

    for (let n = 1; n < 10000; n += 1) {
        term *= x / (a + n);
        sum += term;

        if (Math.abs(term) < Math.abs(sum) * EPS) {
            break;
        }
    }

    return sum * Math.exp(-x + a * Math.log(x) - lgamma(a));
}

function gammaFraction(a, x) {
    let b = x + 1 - a;
    let c = 1 / TINY;
    let d = 1 / b;
    let h = d;

    for (let i = 1; i < 10000; i += 1) {
        const an = -i * (i - a);
        b += 2;
        d = an * d + b;
        d = Math.abs(d) < TINY ? TINY : d;
        c = b + an / c;
        c = Math.abs(c) < TINY ? TINY : c;
        d = 1 / d;
        const delta = d * c;
        h *= delta;

        if (Math.abs(delta - 1) < EPS) {
            break;
        }
    }

    return Math.exp(-x + a * Math.log(x) - lgamma(a)) * h;
}

/** Regularised lower incomplete gamma P(a, x). */
export function gammaP(a, x) {
    if (x <= 0) {
        return 0;
    }

    return x < a + 1 ? gammaSeries(a, x) : 1 - gammaFraction(a, x);
}

/** Regularised upper incomplete gamma Q(a, x) = 1 − P(a, x). */
export function gammaQ(a, x) {
    if (x <= 0) {
        return 1;
    }

    return x < a + 1 ? 1 - gammaSeries(a, x) : gammaFraction(a, x);
}

function betaFraction(a, b, x) {
    const qab = a + b;
    const qap = a + 1;
    const qam = a - 1;
    let c = 1;
    let d = 1 - (qab * x) / qap;
    d = Math.abs(d) < TINY ? TINY : d;
    d = 1 / d;
    let h = d;

    for (let m = 1; m < 10000; m += 1) {
        const m2 = 2 * m;
        let aa = (m * (b - m) * x) / ((qam + m2) * (a + m2));
        d = 1 + aa * d;
        d = Math.abs(d) < TINY ? TINY : d;
        c = 1 + aa / c;
        c = Math.abs(c) < TINY ? TINY : c;
        d = 1 / d;
        h *= d * c;
        aa = (-(a + m) * (qab + m) * x) / ((a + m2) * (qap + m2));
        d = 1 + aa * d;
        d = Math.abs(d) < TINY ? TINY : d;
        c = 1 + aa / c;
        c = Math.abs(c) < TINY ? TINY : c;
        d = 1 / d;
        const delta = d * c;
        h *= delta;

        if (Math.abs(delta - 1) < EPS) {
            break;
        }
    }

    return h;
}

/** Regularised incomplete beta I_x(a, b). */
export function betaI(a, b, x) {
    if (x <= 0) {
        return 0;
    }

    if (x >= 1) {
        return 1;
    }

    const front = Math.exp(a * Math.log(x) + b * Math.log1p(-x) - lbeta(a, b));

    return x < (a + 1) / (a + b + 2) ? (front * betaFraction(a, b, x)) / a : 1 - (front * betaFraction(b, a, 1 - x)) / b;
}

/** Upper tail 1 − I_x(a, b), computed without cancellation. */
export const betaIc = (a, b, x) => betaI(b, a, 1 - x);

/** erf and erfc from the incomplete gamma function. */
export const erf = (x) => (x >= 0 ? gammaP(0.5, x * x) : -gammaP(0.5, x * x));
export const erfc = (x) => (x >= 0 ? gammaQ(0.5, x * x) : 1 + gammaP(0.5, x * x));

/** Standard normal density, CDF and upper tail. */
export const normPdf = (z) => Math.exp(-0.5 * z * z) / Math.sqrt(2 * Math.PI);
export const normCdf = (z) => 0.5 * erfc(-z / Math.SQRT2);
export const normSf = (z) => 0.5 * erfc(z / Math.SQRT2);

/** Inverse standard normal (Wichura 1988, AS 241 PPND16). */
export function normInv(p) {
    if (p <= 0) {
        return -Infinity;
    }

    if (p >= 1) {
        return Infinity;
    }

    const q = p - 0.5;

    if (Math.abs(q) <= 0.425) {
        const r = 0.180625 - q * q;

        return (q * (((((((r * 2509.0809287301226727 + 33430.575583588128105) * r + 67265.770927008700853) * r + 45921.953931549871457) * r + 13731.693765509461125) * r + 1971.5909503065514427) * r + 133.14166789178437745) * r + 3.387132872796366608))
            / (((((((r * 5226.495278852545925 + 28729.085735721942674) * r + 39307.89580009271061) * r + 21213.794301586595867) * r + 5394.1960214247511077) * r + 687.1870074920579083) * r + 42.313330701600911252) * r + 1);
    }

    let r = q < 0 ? p : 1 - p;
    r = Math.sqrt(-Math.log(r));
    let value;

    if (r <= 5) {
        r -= 1.6;
        value = (((((((r * 7.7454501427834140764e-4 + 0.0227238449892691845833) * r + 0.24178072517745061177) * r + 1.27045825245236838258) * r + 3.64784832476320460504) * r + 5.7694972214606914055) * r + 4.6303378461565452959) * r + 1.42343711074968357734)
            / (((((((r * 1.05075007164441684324e-9 + 5.475938084995344946e-4) * r + 0.0151986665636164571966) * r + 0.14810397642748007459) * r + 0.68976733498510000455) * r + 1.6763848301838038494) * r + 2.05319162663775882187) * r + 1);
    } else {
        r -= 5;
        value = (((((((r * 2.01033439929228813265e-7 + 2.71155556874348757815e-5) * r + 0.0012426609473880784386) * r + 0.026532189526576123093) * r + 0.29656057182850489123) * r + 1.7848265399172913358) * r + 5.4637849111641143699) * r + 6.6579046435011037772)
            / (((((((r * 2.04426310338993978564e-15 + 1.4215117583164458887e-7) * r + 1.8463183175100546818e-5) * r + 7.868691311456132591e-4) * r + 0.0148753612908506148525) * r + 0.13692988092273580531) * r + 0.59983220655588793769) * r + 1);
    }

    return q < 0 ? -value : value;
}

/** Student t: CDF and upper tail. */
export function tCdf(t, df) {
    if (!Number.isFinite(df)) {
        return normCdf(t);
    }

    const tail = 0.5 * betaI(df / 2, 0.5, df / (df + t * t));

    return t >= 0 ? 1 - tail : tail;
}

export const tSf = (t, df) => tCdf(-t, df);

export const tPdf = (t, df) => Math.exp(lgamma((df + 1) / 2) - lgamma(df / 2) - 0.5 * Math.log(df * Math.PI) - ((df + 1) / 2) * Math.log1p((t * t) / df));

/** χ² CDF and upper tail. */
export const chi2Cdf = (x, k) => gammaP(k / 2, x / 2);
export const chi2Sf = (x, k) => gammaQ(k / 2, x / 2);
export const chi2Pdf = (x, k) => (x <= 0 ? (k === 2 && x === 0 ? 0.5 : 0) : Math.exp((k / 2 - 1) * Math.log(x) - x / 2 - (k / 2) * Math.LN2 - lgamma(k / 2)));

/** F CDF and upper tail. */
export const fCdf = (x, d1, d2) => (x <= 0 ? 0 : betaI(d1 / 2, d2 / 2, (d1 * x) / (d1 * x + d2)));
export const fSf = (x, d1, d2) => (x <= 0 ? 1 : betaI(d2 / 2, d1 / 2, d2 / (d2 + d1 * x)));
export const fPdf = (x, d1, d2) => (x <= 0 ? 0 : Math.exp(0.5 * (d1 * Math.log(d1 * x) + d2 * Math.log(d2) - (d1 + d2) * Math.log(d1 * x + d2)) - Math.log(x) - lbeta(d1 / 2, d2 / 2)));

/**
 * Inverts an increasing CDF: the x with cdf(x) = p, searched in [lo, hi] (widened while needed) by
 * bisection to full double precision.
 */
export function invert(cdf, p, lo = -1, hi = 1, { min = -Infinity, max = Infinity } = {}) {
    if (!(p > 0 && p < 1)) {
        return p <= 0 ? min : max;
    }

    let a = Math.max(lo, min);
    let b = Math.min(hi, max);

    for (let k = 0; k < 400 && cdf(a) > p; k += 1) {
        a = min > -Infinity ? min + (a - min) / 2 : a * 2 - 1;
    }

    for (let k = 0; k < 400 && cdf(b) < p; k += 1) {
        b = max < Infinity ? max - (max - b) / 2 : b * 2 + 1;
    }

    for (let k = 0; k < 300; k += 1) {
        const m = (a + b) / 2;

        if (m === a || m === b) {
            break;
        }

        if (cdf(m) < p) {
            a = m;
        } else {
            b = m;
        }
    }

    return (a + b) / 2;
}

/** Quantiles. */
export const tInv = (p, df) => (Number.isFinite(df) ? invert((t) => tCdf(t, df), p, normInv(p) - 1, normInv(p) + 1) : normInv(p));
export const chi2Inv = (p, k) => invert((x) => chi2Cdf(x, k), p, 0, Math.max(1, k * 2), { min: 0 });
export const fInv = (p, d1, d2) => invert((x) => fCdf(x, d1, d2), p, 0, 5, { min: 0 });

/**
 * Noncentral t CDF P(T ≤ t) with df degrees of freedom and noncentrality δ (Lenth 1989, AS 243).
 */
export function nctCdf(t, df, delta) {
    if (t < 0) {
        return 1 - nctCdf(-t, df, -delta);
    }

    const x = (t * t) / (t * t + df);
    const lambda = delta * delta;
    let p = 0.5 * Math.exp(-0.5 * lambda);
    let q = Math.sqrt(2 / Math.PI) * p * delta;
    let s = 0.5 - p;
    let a = 0.5;
    const b = 0.5 * df;
    const rxb = (1 - x) ** b;
    const albeta = 0.5 * Math.log(Math.PI) + lgamma(b) - lgamma(0.5 + b);
    let xodd = betaI(a, b, x);
    let godd = 2 * rxb * Math.exp(a * Math.log(x) - albeta);
    let xeven = 1 - rxb;
    let geven = b * x * rxb;
    let tnc = p * xodd + q * xeven;

    if (x > 0) {
        for (let en = 1; en <= 2000; en += 1) {
            a += 1;
            xodd -= godd;
            xeven -= geven;
            godd *= (x * (a + b - 1)) / a;
            geven *= (x * (a + b - 0.5)) / (a + 0.5);
            p *= lambda / (2 * en);
            q *= lambda / (2 * en + 1);
            s -= p;
            tnc += p * xodd + q * xeven;

            if (2 * s * (xodd - godd) < 1e-14 && en > 10) {
                break;
            }
        }
    }

    return Math.min(1, Math.max(0, tnc + normCdf(-delta)));
}
