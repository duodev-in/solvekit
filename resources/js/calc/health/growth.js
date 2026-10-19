/**
 * Growth-chart percentiles from LMS tables (CDC 2000, WHO 2006): z = ((X/M)^L − 1) ÷ (L S), or ln(X/M) ÷ S when L = 0.
 * Tables are rows of [age in months, L, M, S]; values between rows are interpolated linearly.
 */
export function lmsAt(rows, months) {
    if (!rows?.length || months < rows[0][0] || months > rows[rows.length - 1][0]) {
        return null;
    }

    const upper = rows.findIndex((row) => row[0] >= months);

    if (rows[upper][0] === months || upper === 0) {
        return rows[upper].slice(1);
    }

    const [a, b] = [rows[upper - 1], rows[upper]];
    const t = (months - a[0]) / (b[0] - a[0]);

    return [1, 2, 3].map((k) => a[k] + t * (b[k] - a[k]));
}

export function zScore(value, [L, M, S]) {
    return Math.abs(L) < 1e-9 ? Math.log(value / M) / S : ((value / M) ** L - 1) / (L * S);
}

/** The measurement at a z-score. */
export function valueAt(z, [L, M, S]) {
    return Math.abs(L) < 1e-9 ? M * Math.exp(S * z) : M * (1 + L * S * z) ** (1 / L);
}

/** Standard normal cumulative distribution (Abramowitz & Stegun 7.1.26 via erf, error < 1.5 × 10⁻⁷). */
export function normalCdf(z) {
    const t = 1 / (1 + 0.3275911 * Math.abs(z) / Math.SQRT2);
    const erf = 1 - (((((1.061405429 * t - 1.453152027) * t) + 1.421413741) * t - 0.284496736) * t + 0.254829592) * t * Math.exp(-(z * z) / 2);

    return z >= 0 ? (1 + erf) / 2 : (1 - erf) / 2;
}

/** Inverse standard normal (Acklam's rational approximation, relative error < 1.2 × 10⁻⁹). */
export function normalQuantile(p) {
    const a = [-3.969683028665376e1, 2.209460984245205e2, -2.759285104469687e2, 1.38357751867269e2, -3.066479806614716e1, 2.506628277459239];
    const b = [-5.447609879822406e1, 1.615858368580409e2, -1.556989798598866e2, 6.680131188771972e1, -1.328068155288572e1];
    const c = [-7.784894002430293e-3, -3.223964580411365e-1, -2.400758277161838, -2.549732539343734, 4.374664141464968, 2.938163982698783];
    const d = [7.784695709041462e-3, 3.224671290700398e-1, 2.445134137142996, 3.754408661907416];
    const low = 0.02425;

    if (p < low) {
        const q = Math.sqrt(-2 * Math.log(p));

        return (((((c[0] * q + c[1]) * q + c[2]) * q + c[3]) * q + c[4]) * q + c[5]) / ((((d[0] * q + d[1]) * q + d[2]) * q + d[3]) * q + 1);
    }

    if (p > 1 - low) {
        return -normalQuantile(1 - p);
    }

    const q = p - 0.5;
    const r = q * q;

    return ((((((a[0] * r + a[1]) * r + a[2]) * r + a[3]) * r + a[4]) * r + a[5]) * q) / (((((b[0] * r + b[1]) * r + b[2]) * r + b[3]) * r + b[4]) * r + 1);
}

/**
 * Percentile of a measurement: { z, percentile, lms } or null outside the table's ages.
 */
export function percentile(rows, months, value) {
    const lms = lmsAt(rows, months);

    if (!lms || !(value > 0)) {
        return null;
    }

    const z = zScore(value, lms);

    return { z, percentile: 100 * normalCdf(z), lms };
}

/** "75th", "3rd", "below the 0.1st" for display; `decimals` keeps one decimal place (84.6th). */
export function ordinal(p, decimals = 0) {
    if (p < 0.1) {
        return 'below the 0.1st';
    }

    if (p > 99.9) {
        return 'above the 99.9th';
    }

    const n = decimals || p < 1 || p > 99 ? Math.round(p * 10) / 10 : Math.round(p);
    const whole = Math.round(n);
    const suffix = n !== whole ? 'th' : whole % 100 >= 11 && whole % 100 <= 13 ? 'th' : ({ 1: 'st', 2: 'nd', 3: 'rd' }[whole % 10] ?? 'th');

    return `${n}${suffix}`;
}
