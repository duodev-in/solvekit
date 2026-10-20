import * as C from './complex.js';

/**
 * Special functions in double precision: adaptive Gauss–Kronrod integration, Gamma (Lanczos, real and complex),
 * error function (series and continued fraction), inverse erf, and Bessel J, Y, I, K of real order from their
 * integral representations (DLMF 10.9.6, 10.9.7, 10.32.4, 10.32.9), which stay accurate where series cancel.
 */
const XGK = [0.991455371120812639, 0.949107912342758525, 0.864864423359769073, 0.741531185599394440, 0.586087235467691130, 0.405845151377397167, 0.207784955007898468, 0];
const WGK = [0.022935322010529225, 0.063092092629978553, 0.104790010322250184, 0.140653259715525919, 0.169004726639267903, 0.190350578064785410, 0.204432940075298892, 0.209482141084727828];
const WG = [0.129484966168869693, 0.279705391489276668, 0.381830050505118945, 0.417959183673469388];

function gk15(f, a, b) {
    const c = (a + b) / 2;
    const h = (b - a) / 2;
    const fc = f(c);
    let k = fc * WGK[7];
    let g = fc * WG[3];

    for (let j = 0; j < 7; j += 1) {
        const x = h * XGK[j];
        const s = f(c - x) + f(c + x);
        k += WGK[j] * s;

        if (j % 2 === 1) {
            g += WG[(j - 1) / 2] * s;
        }
    }

    return [k * h, Math.abs((k - g) * h)];
}

/** Adaptive Gauss–Kronrod (7–15) integral of f over [a, b]. */
export function integrate(f, a, b, tol = 1e-13, depth = 0) {
    const [value, err] = gk15(f, a, b);

    if (depth > 40 || err <= Math.max(tol * Math.abs(value), 1e-300) || err < 1e-15 * (Math.abs(value) + 1e-300)) {
        return value;
    }

    const m = (a + b) / 2;

    return integrate(f, a, m, tol, depth + 1) + integrate(f, m, b, tol, depth + 1);
}

/** Integral over [a, b] split into `panels` pieces first (oscillating integrands). */
export function integratePanels(f, a, b, panels) {
    let sum = 0;
    const h = (b - a) / panels;

    for (let k = 0; k < panels; k += 1) {
        sum += integrate(f, a + k * h, a + (k + 1) * h);
    }

    return sum;
}

const G = 7;
const LANCZOS = [0.99999999999980993, 676.5203681218851, -1259.1392167224028, 771.32342877765313, -176.61502916214059, 12.507343278686905, -0.13857109526572012, 9.9843695780195716e-6, 1.5056327351493116e-7];

export function gamma(x) {
    if (Number.isInteger(x) && x <= 0) {
        return NaN;
    }

    if (Number.isInteger(x) && x <= 171) {
        let r = 1;

        for (let k = 2; k < x; k += 1) {
            r *= k;
        }

        return r;
    }

    if (x < 0.5) {
        return Math.PI / (Math.sin(Math.PI * x) * gamma(1 - x));
    }

    const z = x - 1;
    let a = LANCZOS[0];
    const t = z + G + 0.5;

    for (let k = 1; k < 9; k += 1) {
        a += LANCZOS[k] / (z + k);
    }

    return Math.sqrt(2 * Math.PI) * t ** (z + 0.5) * Math.exp(-t) * a;
}

export function lnGamma(x) {
    if (x < 0.5) {
        return Math.log(Math.PI / Math.abs(Math.sin(Math.PI * x))) - lnGamma(1 - x);
    }

    const z = x - 1;
    let a = LANCZOS[0];
    const t = z + G + 0.5;

    for (let k = 1; k < 9; k += 1) {
        a += LANCZOS[k] / (z + k);
    }

    return 0.5 * Math.log(2 * Math.PI) + (z + 0.5) * Math.log(t) - t + Math.log(a);
}

export function gammaComplex(z) {
    if (z.re < 0.5) {
        // Reflection: Γ(z) = π / (sin(πz) Γ(1 − z)).
        const piz = C.c(Math.PI * z.re, Math.PI * z.im);
        const sin = C.c(Math.sin(piz.re) * Math.cosh(piz.im), Math.cos(piz.re) * Math.sinh(piz.im));

        return C.div(C.c(Math.PI, 0), C.mul(sin, gammaComplex(C.c(1 - z.re, -z.im))));
    }

    const zz = C.c(z.re - 1, z.im);
    let a = C.c(LANCZOS[0], 0);
    const t = C.c(zz.re + G + 0.5, zz.im);

    for (let k = 1; k < 9; k += 1) {
        a = C.add(a, C.div(C.c(LANCZOS[k], 0), C.c(zz.re + k, zz.im)));
    }

    const powT = C.pow(t, C.c(zz.re + 0.5, zz.im));

    return C.mul(C.mul(C.c(Math.sqrt(2 * Math.PI), 0), powT), C.mul(C.exp(C.neg(t)), a));
}

export function erf(x) {
    if (x < 0) {
        return -erf(-x);
    }

    if (x < 3) {
        // Maclaurin series: 2/√π Σ (−1)ⁿ x²ⁿ⁺¹ / (n!(2n + 1)).
        let sum = x;
        let term = x;

        for (let n = 1; n < 200; n += 1) {
            term *= (-x * x) / n;
            const add = term / (2 * n + 1);
            sum += add;

            if (Math.abs(add) < 1e-17 * Math.abs(sum)) {
                break;
            }
        }

        return (2 / Math.sqrt(Math.PI)) * sum;
    }

    return 1 - erfc(x);
}

export function erfc(x) {
    if (x < 3) {
        return 1 - erf(x);
    }

    // Continued fraction (modified Lentz) for erfc x = e^(−x²)/√π · 1/(x + 1/2/(x + 1/(x + 3/2/(x + …)))).
    const tiny = 1e-300;
    let f = x;
    let Cc = x;
    let D = 0;

    for (let n = 1; n < 500; n += 1) {
        const an = n / 2;
        D = x + an * D;
        D = Math.abs(D) < tiny ? tiny : D;
        Cc = x + an / Cc;
        Cc = Math.abs(Cc) < tiny ? tiny : Cc;
        D = 1 / D;
        const delta = Cc * D;
        f *= delta;

        if (Math.abs(delta - 1) < 1e-16) {
            break;
        }
    }

    return Math.exp(-x * x) / (Math.sqrt(Math.PI) * f);
}

export function erfinv(y) {
    if (y <= -1 || y >= 1) {
        return y === 1 ? Infinity : y === -1 ? -Infinity : NaN;
    }

    // Giles (2010) single-precision start, then Newton on erf.
    let w = -Math.log((1 - y) * (1 + y));
    let x;

    if (w < 5) {
        w -= 2.5;
        x = [2.81022636e-08, 3.43273939e-07, -3.5233877e-06, -4.39150654e-06, 0.00021858087, -0.00125372503, -0.00417768164, 0.246640727, 1.50140941].reduce((p, c) => c + p * w, 0);
    } else {
        w = Math.sqrt(w) - 3;
        x = [-0.000200214257, 0.000100950558, 0.00134934322, -0.00367342844, 0.00573950773, -0.0076224613, 0.00943887047, 1.00167406, 2.83297682].reduce((p, c) => c + p * w, 0);
    }

    x *= y;

    for (let k = 0; k < 4; k += 1) {
        x -= (erf(x) - y) / ((2 / Math.sqrt(Math.PI)) * Math.exp(-x * x));
    }

    return x;
}

const tail = (x, nu) => Math.max(4, Math.asinh((60 + nu * 3) / Math.max(x, 1e-6)) + 2);

/** Bessel function of the first kind J_ν(x), x ≥ 0. */
export function besselJ(nu, x) {
    if (x === 0) {
        return nu === 0 ? 1 : 0;
    }

    if (x < 0) {
        return Number.isInteger(nu) ? (nu % 2 ? -1 : 1) * besselJ(nu, -x) : NaN;
    }

    if (nu < 0 && Number.isInteger(nu)) {
        return (nu % 2 ? -1 : 1) * besselJ(-nu, x);
    }

    const panels = Math.ceil((x + Math.abs(nu)) / 3) + 2;
    let v = integratePanels((t) => Math.cos(nu * t - x * Math.sin(t)), 0, Math.PI, panels) / Math.PI;

    if (!Number.isInteger(nu)) {
        v -= (Math.sin(nu * Math.PI) / Math.PI) * integrate((t) => Math.exp(-x * Math.sinh(t) - nu * t), 0, tail(x, Math.abs(nu)));
    }

    return v;
}

/** Bessel function of the second kind Y_ν(x), x > 0. */
export function besselY(nu, x) {
    if (x <= 0) {
        return NaN;
    }

    if (nu < 0 && Number.isInteger(nu)) {
        return (nu % 2 ? -1 : 1) * besselY(-nu, x);
    }

    const panels = Math.ceil((x + Math.abs(nu)) / 3) + 2;
    const first = integratePanels((t) => Math.sin(x * Math.sin(t) - nu * t), 0, Math.PI, panels) / Math.PI;
    const second = integrate((t) => (Math.exp(nu * t) + Math.exp(-nu * t) * Math.cos(nu * Math.PI)) * Math.exp(-x * Math.sinh(t)), 0, tail(x, Math.abs(nu)) + Math.abs(nu) / Math.max(x, 0.5)) / Math.PI;

    return first - second;
}

/** Modified Bessel function of the first kind I_ν(x), x ≥ 0. */
export function besselI(nu, x) {
    if (x === 0) {
        return nu === 0 ? 1 : 0;
    }

    if (nu < 0 && Number.isInteger(nu)) {
        return besselI(-nu, x);
    }

    // Scale by e^(−x) inside the integral to avoid overflow, then restore.
    const panels = Math.ceil(Math.abs(nu) / 3) + 2;
    let v = integratePanels((t) => Math.exp(x * (Math.cos(t) - 1)) * Math.cos(nu * t), 0, Math.PI, panels) / Math.PI;

    if (!Number.isInteger(nu)) {
        v -= (Math.sin(nu * Math.PI) / Math.PI) * integrate((t) => Math.exp(-x * Math.cosh(t) - x - nu * t), 0, tail(x, Math.abs(nu)));
    }

    return v * Math.exp(x);
}

/** Modified Bessel function of the second kind K_ν(x), x > 0. */
export function besselK(nu, x) {
    if (x <= 0) {
        return NaN;
    }

    const a = Math.abs(nu);
    // The integrand e^(−x cosh t) cosh(νt) peaks near t = asinh(ν/x); integrate well past it.
    const peak = Math.asinh(a / x);
    const end = peak + Math.acosh(Math.max(1, (50 + x) / x)) + 3;

    return integrate((t) => Math.exp(-x * Math.cosh(t)) * Math.cosh(a * t), 0, end);
}
