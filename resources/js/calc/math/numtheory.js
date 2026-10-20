import { babs, bgcd } from './rational.js';

/**
 * Number theory on BigInt: integer roots, modular arithmetic, primality (deterministic Miller–Rabin below
 * 3.3 × 10²⁴, 20 extra rounds above), factorisation (trial division then Pollard–Brent rho), divisors, CRT.
 */
export function parseBig(text) {
    const s = String(text ?? '').trim().replace(/[−–]/g, '-').replace(/[,_\s]/g, '');

    return /^[+-]?\d+$/.test(s) ? BigInt(s) : null;
}

/** ⌊ⁿ√x⌋ for x ≥ 0. */
export function iroot(x, n = 2n) {
    x = BigInt(x);
    n = BigInt(n);

    if (x < 0n) {
        throw new RangeError('negative');
    }

    if (x < 2n) {
        return x;
    }

    // Newton's method from a power-of-two start above the root.
    let r = 1n << (BigInt(x.toString(2).length) / n + 1n);

    while (true) {
        const next = ((n - 1n) * r + x / r ** (n - 1n)) / n;

        if (next >= r) {
            break;
        }

        r = next;
    }

    while (r ** n > x) {
        r -= 1n;
    }

    while ((r + 1n) ** n <= x) {
        r += 1n;
    }

    return r;
}

export const isqrt = (x) => iroot(x, 2n);

export function modPow(base, exp, mod) {
    base = BigInt(base);
    exp = BigInt(exp);
    mod = BigInt(mod);

    if (mod === 1n) {
        return 0n;
    }

    let result = 1n;
    base = ((base % mod) + mod) % mod;

    while (exp > 0n) {
        if (exp & 1n) {
            result = (result * base) % mod;
        }

        base = (base * base) % mod;
        exp >>= 1n;
    }

    return result;
}

/** Extended Euclid: [g, x, y] with ax + by = g. */
export function egcd(a, b) {
    let [oldR, r] = [BigInt(a), BigInt(b)];
    let [oldS, s] = [1n, 0n];
    let [oldT, t] = [0n, 1n];

    while (r !== 0n) {
        const q = oldR / r;
        [oldR, r] = [r, oldR - q * r];
        [oldS, s] = [s, oldS - q * s];
        [oldT, t] = [t, oldT - q * t];
    }

    return oldR < 0n ? [-oldR, -oldS, -oldT] : [oldR, oldS, oldT];
}

export const mod = (a, m) => ((BigInt(a) % BigInt(m)) + BigInt(m)) % BigInt(m);

export function modInverse(a, m) {
    const [g, x] = egcd(mod(a, m), BigInt(m));

    return g === 1n ? mod(x, m) : null;
}

const SMALL = [2n, 3n, 5n, 7n, 11n, 13n, 17n, 19n, 23n, 29n, 31n, 37n, 41n];

export function isPrime(n) {
    n = BigInt(n);

    if (n < 2n) {
        return false;
    }

    for (const p of SMALL) {
        if (n === p) {
            return true;
        }

        if (n % p === 0n) {
            return false;
        }
    }

    let d = n - 1n;
    let s = 0n;

    while ((d & 1n) === 0n) {
        d >>= 1n;
        s += 1n;
    }

    const bases = n < 3317044064679887385961981n ? SMALL : [...SMALL, ...Array.from({ length: 20 }, (_, k) => BigInt(43 + 2 * k))];

    witness: for (const a of bases) {
        let x = modPow(a, d, n);

        if (x === 1n || x === n - 1n) {
            continue;
        }

        for (let r = 1n; r < s; r += 1n) {
            x = (x * x) % n;

            if (x === n - 1n) {
                continue witness;
            }
        }

        return false;
    }

    return true;
}

function rho(n) {
    if (n % 2n === 0n) {
        return 2n;
    }

    for (let c = 1n; c < 50n; c += 1n) {
        let y = 2n;
        let x = 2n;
        let g = 1n;
        let q = 1n;
        let r = 1n;
        let ys = 2n;
        const m = 128n;
        const f = (v) => (v * v + c) % n;

        do {
            x = y;

            for (let i = 0n; i < r; i += 1n) {
                y = f(y);
            }

            let k = 0n;

            do {
                ys = y;

                for (let i = 0n; i < (m < r - k ? m : r - k); i += 1n) {
                    y = f(y);
                    q = (q * babs(x - y)) % n;
                }

                g = bgcd(q, n);
                k += m;
            } while (k < r && g === 1n);

            r *= 2n;
        } while (g === 1n && r < 1n << 40n);

        if (g === n) {
            do {
                ys = f(ys);
                g = bgcd(babs(x - ys), n);
            } while (g === 1n);
        }

        if (g !== n && g !== 1n) {
            return g;
        }
    }

    return null;
}

/** Prime factorisation as a Map prime → exponent (sorted). Throws when a factor cannot be found in time. */
export function factorize(n) {
    n = babs(BigInt(n));
    const out = new Map();
    const push = (p) => out.set(p, (out.get(p) ?? 0n) + 1n);

    if (n < 2n) {
        return out;
    }

    for (let p = 2n; p < 10000n && p * p <= n; p += p === 2n ? 1n : 2n) {
        while (n % p === 0n) {
            push(p);
            n /= p;
        }
    }

    const stack = n > 1n ? [n] : [];

    while (stack.length) {
        const m = stack.pop();

        if (isPrime(m)) {
            push(m);
            continue;
        }

        const root = isqrt(m);

        if (root * root === m) {
            stack.push(root, root);
            continue;
        }

        const d = rho(m);

        if (!d) {
            throw new RangeError('Could not factor');
        }

        stack.push(d, m / d);
    }

    return new Map([...out.entries()].sort((a, b) => (a[0] < b[0] ? -1 : 1)));
}

export const factorString = (factors) => [...factors.entries()].map(([p, e]) => (e > 1n ? `${p}${supBig(e)}` : `${p}`)).join(' × ') || '1';

const SUP = { 0: '⁰', 1: '¹', 2: '²', 3: '³', 4: '⁴', 5: '⁵', 6: '⁶', 7: '⁷', 8: '⁸', 9: '⁹' };
const supBig = (e) => e.toString().split('').map((c) => SUP[c]).join('');

/** All positive divisors in order (from the factorisation). */
export function divisors(n) {
    let list = [1n];

    for (const [p, e] of factorize(n)) {
        const next = [];

        for (const d of list) {
            let pk = 1n;

            for (let k = 0n; k <= e; k += 1n) {
                next.push(d * pk);
                pk *= p;
            }
        }

        list = next;
    }

    return list.sort((a, b) => (a < b ? -1 : a > b ? 1 : 0));
}

export function nextPrime(n) {
    let k = BigInt(n) + 1n;

    while (!isPrime(k)) {
        k += 1n;
    }

    return k;
}

export function prevPrime(n) {
    let k = BigInt(n) - 1n;

    while (k >= 2n && !isPrime(k)) {
        k -= 1n;
    }

    return k >= 2n ? k : null;
}

/** Chinese remainder theorem for x ≡ aᵢ (mod mᵢ), moduli need not be coprime. Returns [x, M] or null. */
export function crt(pairs) {
    let [x, m] = [0n, 1n];

    for (const [a0, m0] of pairs) {
        const a = mod(a0, m0);
        const [g, p] = egcd(m, m0);

        if ((a - x) % g !== 0n) {
            return null;
        }

        const l = (m / g) * m0;
        x = mod(x + ((((a - x) / g) * p) % (m0 / g)) * m, l);
        m = l;
    }

    return [x, m];
}

export function factorial(n) {
    let r = 1n;

    for (let k = 2n; k <= BigInt(n); k += 1n) {
        r *= k;
    }

    return r;
}

export function binomial(n, k) {
    n = BigInt(n);
    k = BigInt(k);

    if (k < 0n || k > n) {
        return 0n;
    }

    k = k > n - k ? n - k : k;
    let r = 1n;

    for (let i = 1n; i <= k; i += 1n) {
        r = (r * (n - k + i)) / i;
    }

    return r;
}
