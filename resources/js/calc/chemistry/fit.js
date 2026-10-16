/**
 * Curve fitting: ordinary least squares and two-parameter non-linear least squares.
 */

/**
 * Parses "x y" or "x, y" pairs, one per line.
 */
export function readPairs(text) {
    const pairs = [];

    for (const [index, line] of String(text ?? '').split(/\n|;/).map((value) => value.trim()).filter(Boolean).entries()) {
        const numbers = line.split(/[\s,]+/).map(Number);

        if (numbers.length < 2 || numbers.slice(0, 2).some((value) => Number.isNaN(value))) {
            return { error: `Line ${index + 1}: write two numbers, x and y.` };
        }

        pairs.push([numbers[0], numbers[1]]);
    }

    return { pairs };
}

/**
 * Least-squares line y = slope x + intercept, with R², the residual standard deviation and the
 * standard errors of slope and intercept.
 */
export function linearFit(pairs) {
    const n = pairs.length;
    const meanX = pairs.reduce((sum, [x]) => sum + x, 0) / n;
    const meanY = pairs.reduce((sum, [, y]) => sum + y, 0) / n;
    const sxx = pairs.reduce((sum, [x]) => sum + (x - meanX) ** 2, 0);
    const sxy = pairs.reduce((sum, [x, y]) => sum + (x - meanX) * (y - meanY), 0);
    const syy = pairs.reduce((sum, [, y]) => sum + (y - meanY) ** 2, 0);
    const slope = sxy / sxx;
    const intercept = meanY - slope * meanX;
    const residuals = pairs.map(([x, y]) => y - (slope * x + intercept));
    const sse = residuals.reduce((sum, value) => sum + value ** 2, 0);
    const sy = n > 2 ? Math.sqrt(sse / (n - 2)) : 0;

    return {
        slope,
        intercept,
        r2: syy === 0 ? 1 : 1 - sse / syy,
        sy,
        slopeError: sy / Math.sqrt(sxx),
        interceptError: sy * Math.sqrt(1 / n + meanX ** 2 / sxx),
        residuals,
        n,
    };
}

/**
 * Levenberg–Marquardt for a two-parameter model f(x; p, q). Returns { p, q, sse, r2, iterations }.
 */
export function fitTwoParameter(model, pairs, start) {
    let [p, q] = start;
    let lambda = 1e-3;
    const sse = (a, b) => pairs.reduce((sum, [x, y]) => sum + (y - model(x, a, b)) ** 2, 0);
    let current = sse(p, q);
    let iterations = 0;

    for (; iterations < 500; iterations += 1) {
        // Numerical Jacobian.
        let jtj = [0, 0, 0];
        let jtr = [0, 0];

        for (const [x, y] of pairs) {
            const hp = Math.abs(p) * 1e-7 || 1e-7;
            const hq = Math.abs(q) * 1e-7 || 1e-7;
            const base = model(x, p, q);
            const dp = (model(x, p + hp, q) - base) / hp;
            const dq = (model(x, p, q + hq) - base) / hq;
            const r = y - base;
            jtj = [jtj[0] + dp * dp, jtj[1] + dp * dq, jtj[2] + dq * dq];
            jtr = [jtr[0] + dp * r, jtr[1] + dq * r];
        }

        const a = jtj[0] * (1 + lambda);
        const d = jtj[2] * (1 + lambda);
        const det = a * d - jtj[1] ** 2;

        if (det === 0) {
            break;
        }

        const stepP = (d * jtr[0] - jtj[1] * jtr[1]) / det;
        const stepQ = (a * jtr[1] - jtj[1] * jtr[0]) / det;
        const trial = sse(p + stepP, q + stepQ);

        if (trial < current) {
            const improvement = current - trial;
            p += stepP;
            q += stepQ;
            current = trial;
            lambda /= 10;

            if (improvement < 1e-15 * (1 + current) && Math.abs(stepP) < 1e-12 * (1 + Math.abs(p))) {
                break;
            }
        } else {
            lambda *= 10;

            if (lambda > 1e12) {
                break;
            }
        }
    }

    const meanY = pairs.reduce((sum, [, y]) => sum + y, 0) / pairs.length;
    const total = pairs.reduce((sum, [, y]) => sum + (y - meanY) ** 2, 0);

    return { p, q, sse: current, r2: total === 0 ? 1 : 1 - current / total, iterations };
}
