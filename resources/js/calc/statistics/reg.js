import { mean, sum } from './data.js';
import { fSf, tCdf, tInv } from './special.js';

/**
 * Ordinary least squares by Householder QR (stable for polynomial and nearly collinear designs, unlike the
 * normal equations). Returns coefficients with standard errors, t and p values, fitted values, residuals,
 * R², adjusted R², the overall F test and (XᵀX)⁻¹ for intervals.
 */
export function ols(X, y) {
    const n = X.length;
    const k = X[0].length;

    if (n <= k) {
        return { problem: `Enter at least ${k + 1} points for this model.` };
    }

    const A = X.map((row) => [...row]);
    const b = [...y];
    const R = Array.from({ length: k }, () => new Array(k).fill(0));

    for (let j = 0; j < k; j += 1) {
        let norm = 0;

        for (let i = j; i < n; i += 1) {
            norm += A[i][j] * A[i][j];
        }

        norm = Math.sqrt(norm);

        if (norm === 0) {
            return { problem: 'The x values do not vary enough to fit this model.' };
        }

        const alpha = A[j][j] > 0 ? -norm : norm;
        const v = new Array(n).fill(0);
        v[j] = A[j][j] - alpha;

        for (let i = j + 1; i < n; i += 1) {
            v[i] = A[i][j];
        }

        const vv = sum(v.slice(j).map((x) => x * x));

        if (vv > 0) {
            for (let c = j; c < k; c += 1) {
                let dot = 0;

                for (let i = j; i < n; i += 1) {
                    dot += v[i] * A[i][c];
                }

                const f = (2 * dot) / vv;

                for (let i = j; i < n; i += 1) {
                    A[i][c] -= f * v[i];
                }
            }

            let dot = 0;

            for (let i = j; i < n; i += 1) {
                dot += v[i] * b[i];
            }

            const f = (2 * dot) / vv;

            for (let i = j; i < n; i += 1) {
                b[i] -= f * v[i];
            }
        }

        for (let c = j; c < k; c += 1) {
            R[j][c] = A[j][c];
        }
    }

    const scale = Math.max(...R.map((row, i) => Math.abs(row[i])));

    if (R.some((row, i) => Math.abs(row[i]) < scale * 1e-12)) {
        return { problem: 'The model cannot be fitted: some terms are exact combinations of others (for example too few distinct x values).' };
    }

    // Back substitution for β and for R⁻¹ (to form (XᵀX)⁻¹ = R⁻¹R⁻ᵀ).
    const beta = new Array(k).fill(0);

    for (let i = k - 1; i >= 0; i -= 1) {
        let s = b[i];

        for (let c = i + 1; c < k; c += 1) {
            s -= R[i][c] * beta[c];
        }

        beta[i] = s / R[i][i];
    }

    const Rinv = Array.from({ length: k }, () => new Array(k).fill(0));

    for (let i = k - 1; i >= 0; i -= 1) {
        Rinv[i][i] = 1 / R[i][i];

        for (let c = i + 1; c < k; c += 1) {
            let s = 0;

            for (let m = i + 1; m <= c; m += 1) {
                s += R[i][m] * Rinv[m][c];
            }

            Rinv[i][c] = -s / R[i][i];
        }
    }

    const XtXinv = Array.from({ length: k }, (_, i) => Array.from({ length: k }, (_, j) => sum(Rinv[i].map((x, m) => x * Rinv[j][m]))));
    const fitted = X.map((row) => sum(row.map((x, j) => x * beta[j])));
    const resid = y.map((v, i) => v - fitted[i]);
    const sse = sum(resid.map((e) => e * e));
    const hasIntercept = X.every((row) => row[0] === 1);
    const ybar = mean(y);
    const sst = hasIntercept ? sum(y.map((v) => (v - ybar) ** 2)) : sum(y.map((v) => v * v));
    const dfe = n - k;
    const sigma2 = sse / dfe;
    const se = XtXinv.map((row, i) => Math.sqrt(sigma2 * row[i]));
    const t = beta.map((v, i) => v / se[i]);
    const p = t.map((v) => 2 * tCdf(-Math.abs(v), dfe));
    const r2 = 1 - sse / sst;
    const dfm = k - (hasIntercept ? 1 : 0);
    const adj = 1 - (1 - r2) * ((n - (hasIntercept ? 1 : 0)) / dfe);
    const F = dfm > 0 ? ((sst - sse) / dfm) / sigma2 : NaN;

    return { beta, se, t, p, fitted, resid, sse, sst, ssr: sst - sse, r2, adj, F, pF: dfm > 0 ? fSf(F, dfm, dfe) : NaN, dfm, dfe, sigma: Math.sqrt(sigma2), XtXinv, n, k };
}

/** Confidence (mean response) and prediction intervals at a design row x0. */
export function intervals(fit, x0, conf = 0.95) {
    const yhat = sum(x0.map((x, j) => x * fit.beta[j]));
    const h = sum(x0.map((xi, i) => sum(x0.map((xj, j) => xi * fit.XtXinv[i][j] * xj))));
    const tc = tInv(1 - (1 - conf) / 2, fit.dfe);
    const seMean = fit.sigma * Math.sqrt(h);
    const sePred = fit.sigma * Math.sqrt(1 + h);

    return { yhat, seMean, sePred, ci: [yhat - tc * seMean, yhat + tc * seMean], pi: [yhat - tc * sePred, yhat + tc * sePred], tc };
}

/** Polynomial design rows [1, x, x², …]. */
export const polyRow = (x, degree) => Array.from({ length: degree + 1 }, (_, j) => x ** j);

/** Curve points of f over the x range of the data, for a fitted-line chart. */
export function curve(f, xs, n = 120) {
    const lo = Math.min(...xs);
    const hi = Math.max(...xs);
    const pad = (hi - lo) * 0.05 || 1;

    return Array.from({ length: n + 1 }, (_, j) => {
        const x = lo - pad + ((hi - lo + 2 * pad) * j) / n;

        return [x, f(x)];
    });
}
