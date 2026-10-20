/**
 * Numerical helpers for the Physics section.
 */

/** Complete elliptic integral of the first kind K(m), m = k², by the arithmetic–geometric mean. */
export function ellipticK(m) {
    let a = 1;
    let b = Math.sqrt(1 - m);

    for (let k = 0; k < 60 && Math.abs(a - b) > 1e-16 * a; k += 1) {
        [a, b] = [(a + b) / 2, Math.sqrt(a * b)];
    }

    return Math.PI / (2 * a);
}

/** Composite Simpson's rule on [a, b] with n (even) panels. */
export function simpson(f, a, b, n = 400) {
    const h = (b - a) / n;
    let s = f(a) + f(b);

    for (let k = 1; k < n; k += 1) {
        s += (k % 2 ? 4 : 2) * f(a + k * h);
    }

    return (s * h) / 3;
}

/** Newton's method with a numerical derivative; returns NaN if it does not converge. */
export function newton(f, x0, tolerance = 1e-12, iterations = 100) {
    let x = x0;

    for (let k = 0; k < iterations; k += 1) {
        const fx = f(x);
        const h = 1e-7 * Math.max(1, Math.abs(x));
        const d = (f(x + h) - f(x - h)) / (2 * h);

        if (!Number.isFinite(d) || d === 0) {
            return NaN;
        }

        const next = x - fx / d;

        if (Math.abs(next - x) <= tolerance * Math.max(1, Math.abs(next))) {
            return next;
        }

        x = next;
    }

    return NaN;
}

/** Complete elliptic integral of the second kind E(m), m = k², by the arithmetic–geometric mean. */
export function ellipticE(m) {
    if (m === 1) {
        return 1;
    }

    let a = 1;
    let b = Math.sqrt(1 - m);
    let sum = m / 2;
    let power = 0.5;

    for (let k = 0; k < 60 && Math.abs(a - b) > 1e-16 * a; k += 1) {
        const cn = (a - b) / 2;
        [a, b] = [(a + b) / 2, Math.sqrt(a * b)];
        power *= 2;
        sum += power * cn * cn;
    }

    return (Math.PI / (2 * a)) * (1 - sum);
}
