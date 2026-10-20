import * as R from './rational.js';

/**
 * Matrices. Exact routines work on rationals (row reduction, determinant, inverse, rank, null space);
 * decompositions work on doubles (LU, QR, Cholesky, symmetric and general eigenvalues, SVD).
 * A matrix is an array of rows.
 */

/** Parses "1 2 3\n4 5 6" (spaces, commas or tabs between entries; one row per line). */
export function parseMatrix(text) {
    const rows = String(text ?? '').trim().split(/\n|;/).map((line) => line.trim()).filter(Boolean)
        .map((line) => line.replace(/^\[|\]$/g, '').split(/[\s,\t]+/).filter(Boolean).map((v) => R.parseNumber(v)));

    if (!rows.length) {
        return { error: 'Enter the matrix, one row per line.' };
    }

    if (rows.some((row) => row.some((v) => v === null))) {
        return { error: 'Every entry must be a number or a fraction such as 3/4.' };
    }

    if (rows.some((row) => row.length !== rows[0].length)) {
        return { error: 'Every row needs the same number of entries.' };
    }

    if (rows.length > 8 || rows[0].length > 8) {
        return { error: 'Matrices up to 8 × 8 are supported.' };
    }

    return { m: rows };
}

export const size = (m) => [m.length, m[0].length];
export const toNum = (m) => m.map((row) => row.map((v) => (typeof v === 'number' ? v : R.toNumber(v))));
export const identity = (n) => Array.from({ length: n }, (_, i) => Array.from({ length: n }, (__, j) => (i === j ? R.ONE : R.ZERO)));
export const transpose = (m) => m[0].map((_, j) => m.map((row) => row[j]));
export const addM = (a, b) => a.map((row, i) => row.map((v, j) => R.add(v, b[i][j])));
export const subM = (a, b) => a.map((row, i) => row.map((v, j) => R.sub(v, b[i][j])));
export const scaleM = (a, k) => a.map((row) => row.map((v) => R.mul(v, k)));

export function mulM(a, b) {
    return a.map((row) => b[0].map((_, j) => row.reduce((acc, v, k) => R.add(acc, R.mul(v, b[k][j])), R.ZERO)));
}

export function powM(a, n) {
    let result = identity(a.length);
    let base = a;
    let k = BigInt(n);

    while (k > 0n) {
        if (k & 1n) {
            result = mulM(result, base);
        }

        base = mulM(base, base);
        k >>= 1n;
    }

    return result;
}

/** Text of a matrix with aligned columns (fractions or numbers). */
export function show(m, cell = (v) => (typeof v === 'number' ? R.fmt(Math.abs(v) < 1e-12 ? 0 : v, 6) : R.toFraction(v))) {
    const cells = m.map((row) => row.map(cell));
    const widths = cells[0].map((_, j) => Math.max(...cells.map((row) => row[j].length)));

    return cells.map((row, i) => {
        const [l, r] = m.length === 1 ? ['[', ']'] : i === 0 ? ['⎡', '⎤'] : i === m.length - 1 ? ['⎣', '⎦'] : ['⎢', '⎥'];

        return `${l} ${row.map((v, j) => v.padStart(widths[j])).join('  ')} ${r}`;
    }).join('\n');
}

/**
 * Row reduction to reduced row echelon form with the list of row operations.
 * Returns { rref, pivots, ops, swaps, det } (det only for square input).
 */
export function rref(m, { stopAtRef = false, augmentedCols = 0 } = {}) {
    const a = m.map((row) => [...row]);
    const [rows, cols] = size(a);
    const workCols = cols - augmentedCols;
    const pivots = [];
    const ops = [];
    let det = R.ONE;
    let r = 0;

    for (let col = 0; col < workCols && r < rows; col += 1) {
        let p = r;

        while (p < rows && R.isZero(a[p][col])) {
            p += 1;
        }

        if (p === rows) {
            det = R.ZERO;
            continue;
        }

        if (p !== r) {
            [a[p], a[r]] = [a[r], a[p]];
            det = R.neg(det);
            ops.push(`R${r + 1} ↔ R${p + 1}`);
        }

        const pv = a[r][col];

        if (!stopAtRef && !R.eq(pv, R.ONE)) {
            a[r] = a[r].map((v) => R.div(v, pv));
            ops.push(`R${r + 1} → R${r + 1} ÷ ${R.toFraction(pv)}`);
        }

        det = R.mul(det, pv);

        for (let i = stopAtRef ? r + 1 : 0; i < rows; i += 1) {
            if (i !== r && !R.isZero(a[i][col])) {
                const f = stopAtRef ? R.div(a[i][col], a[r][col]) : a[i][col];
                a[i] = a[i].map((v, j) => R.sub(v, R.mul(f, a[r][j])));
                ops.push(`R${i + 1} → R${i + 1} ${f.n < 0n ? '+' : '−'} ${R.toFraction(R.qabs(f))}·R${r + 1}`);
            }
        }

        pivots.push(col);
        r += 1;
    }

    if (r < rows || rows !== workCols) {
        det = rows === workCols && r < rows ? R.ZERO : det;
    }

    return { rref: a, pivots, ops, det: rows === workCols ? det : null };
}

export function det(m) {
    const n = m.length;

    if (n !== m[0].length) {
        return null;
    }

    // Bareiss fraction-free elimination keeps the numbers exact.
    const { det: d } = rref(m, { stopAtRef: true });

    return d;
}

export function inverse(m) {
    const n = m.length;
    const aug = m.map((row, i) => [...row, ...identity(n)[i]]);
    const { rref: red, pivots } = rref(aug, { augmentedCols: n });

    if (pivots.length < n) {
        return null;
    }

    return red.map((row) => row.slice(n));
}

export const rank = (m) => rref(m).pivots.length;
export const trace = (m) => m.reduce((acc, row, i) => R.add(acc, row[i]), R.ZERO);

export function minor(m, i, j) {
    return m.filter((_, r) => r !== i).map((row) => row.filter((_, c) => c !== j));
}

export function cofactorMatrix(m) {
    return m.map((row, i) => row.map((_, j) => {
        const d = m.length === 1 ? R.ONE : det(minor(m, i, j));

        return (i + j) % 2 ? R.neg(d) : d;
    }));
}

export const adjugate = (m) => transpose(cofactorMatrix(m));

/** Null space basis (exact). */
export function nullSpace(m) {
    const { rref: red, pivots } = rref(m);
    const cols = m[0].length;
    const free = Array.from({ length: cols }, (_, j) => j).filter((j) => !pivots.includes(j));

    return free.map((f) => {
        const v = Array.from({ length: cols }, () => R.ZERO);
        v[f] = R.ONE;
        pivots.forEach((pc, row) => {
            v[pc] = R.neg(red[row][f]);
        });

        return v;
    });
}

export function columnSpace(m) {
    const { pivots } = rref(m);

    return pivots.map((j) => m.map((row) => row[j]));
}

/** Solves Ax = b exactly: { kind: 'unique'|'none'|'infinite', x?, particular?, basis? }. */
export function solve(a, b) {
    const aug = a.map((row, i) => [...row, b[i]]);
    const { rref: red, pivots, ops } = rref(aug, { augmentedCols: 1 });
    const n = a[0].length;
    const inconsistent = red.some((row) => row.slice(0, n).every(R.isZero) && !R.isZero(row[n]));

    if (inconsistent) {
        return { kind: 'none', ops, rref: red };
    }

    const x = Array.from({ length: n }, () => R.ZERO);
    pivots.forEach((pc, row) => {
        x[pc] = red[row][n];
    });

    if (pivots.length === n) {
        return { kind: 'unique', x, ops, rref: red };
    }

    return { kind: 'infinite', particular: x, basis: nullSpace(a), ops, rref: red, free: Array.from({ length: n }, (_, j) => j).filter((j) => !pivots.includes(j)) };
}

// Floating-point decompositions ------------------------------------------------------------------

const zeros = (r, c) => Array.from({ length: r }, () => Array(c).fill(0));
const matmul = (a, b) => a.map((row) => b[0].map((_, j) => row.reduce((acc, v, k) => acc + v * b[k][j], 0)));
const T = (m) => m[0].map((_, j) => m.map((row) => row[j]));
export { matmul, T as transposeNum };

export function lu(a) {
    const n = a.length;
    const U = a.map((row) => [...row]);
    const L = zeros(n, n);
    const P = Array.from({ length: n }, (_, i) => i);

    for (let k = 0; k < n; k += 1) {
        let p = k;

        for (let i = k + 1; i < n; i += 1) {
            if (Math.abs(U[i][k]) > Math.abs(U[p][k])) {
                p = i;
            }
        }

        if (p !== k) {
            [U[p], U[k]] = [U[k], U[p]];
            [L[p], L[k]] = [L[k], L[p]];
            [P[p], P[k]] = [P[k], P[p]];
        }

        L[k][k] = 1;

        if (Math.abs(U[k][k]) < 1e-14) {
            continue;
        }

        for (let i = k + 1; i < n; i += 1) {
            const f = U[i][k] / U[k][k];
            L[i][k] = f;
            U[i] = U[i].map((v, j) => v - f * U[k][j]);
        }
    }

    const Pm = P.map((col) => Array.from({ length: n }, (_, j) => (j === col ? 1 : 0)));

    return { L, U, P: Pm };
}

/** Householder QR of an m × n matrix. */
export function qr(a) {
    const m = a.length;
    const n = a[0].length;
    let Rm = a.map((row) => [...row]);
    let Q = Array.from({ length: m }, (_, i) => Array.from({ length: m }, (__, j) => (i === j ? 1 : 0)));

    for (let k = 0; k < Math.min(m - 1, n); k += 1) {
        const x = Rm.slice(k).map((row) => row[k]);
        const norm = Math.hypot(...x);

        if (norm < 1e-15) {
            continue;
        }

        const alpha = x[0] > 0 ? -norm : norm;
        const v = [...x];
        v[0] -= alpha;
        const vn = Math.hypot(...v);

        if (vn < 1e-15) {
            continue;
        }

        const u = v.map((e) => e / vn);
        const H = Array.from({ length: m }, (_, i) => Array.from({ length: m }, (__, j) => (i === j ? 1 : 0) - (i >= k && j >= k ? 2 * u[i - k] * u[j - k] : 0)));
        Rm = matmul(H, Rm);
        Q = matmul(Q, H);
    }

    // Positive diagonal on R for a unique, readable answer.
    for (let k = 0; k < Math.min(m, n); k += 1) {
        if (Rm[k][k] < 0) {
            Rm[k] = Rm[k].map((v) => -v);
            Q = Q.map((row) => row.map((v, j) => (j === k ? -v : v)));
        }
    }

    return { Q, R: Rm.map((row) => row.map((v) => (Math.abs(v) < 1e-13 ? 0 : v))) };
}

export function cholesky(a) {
    const n = a.length;
    const L = zeros(n, n);

    for (let i = 0; i < n; i += 1) {
        for (let j = 0; j <= i; j += 1) {
            let sum = a[i][j];

            for (let k = 0; k < j; k += 1) {
                sum -= L[i][k] * L[j][k];
            }

            if (i === j) {
                if (sum <= 1e-14) {
                    return null;
                }

                L[i][i] = Math.sqrt(sum);
            } else {
                L[i][j] = sum / L[j][j];
            }
        }
    }

    return L;
}

/** Symmetric eigen decomposition by cyclic Jacobi: { values (descending), vectors (columns) }. */
export function eigSym(a) {
    const n = a.length;
    const A = a.map((row) => [...row]);
    let V = Array.from({ length: n }, (_, i) => Array.from({ length: n }, (__, j) => (i === j ? 1 : 0)));

    for (let sweep = 0; sweep < 100; sweep += 1) {
        let off = 0;

        for (let i = 0; i < n; i += 1) {
            for (let j = i + 1; j < n; j += 1) {
                off += A[i][j] ** 2;
            }
        }

        if (off < 1e-30) {
            break;
        }

        for (let p = 0; p < n; p += 1) {
            for (let q = p + 1; q < n; q += 1) {
                if (Math.abs(A[p][q]) < 1e-300) {
                    continue;
                }

                const theta = (A[q][q] - A[p][p]) / (2 * A[p][q]);
                const t = Math.sign(theta || 1) / (Math.abs(theta) + Math.sqrt(theta * theta + 1));
                const cs = 1 / Math.sqrt(t * t + 1);
                const sn = t * cs;

                for (let k = 0; k < n; k += 1) {
                    const akp = A[k][p];
                    const akq = A[k][q];
                    A[k][p] = cs * akp - sn * akq;
                    A[k][q] = sn * akp + cs * akq;
                }

                for (let k = 0; k < n; k += 1) {
                    const apk = A[p][k];
                    const aqk = A[q][k];
                    A[p][k] = cs * apk - sn * aqk;
                    A[q][k] = sn * apk + cs * aqk;
                }

                V = V.map((row) => {
                    const vp = row[p];
                    const vq = row[q];
                    const out = [...row];
                    out[p] = cs * vp - sn * vq;
                    out[q] = sn * vp + cs * vq;

                    return out;
                });
            }
        }
    }

    const order = Array.from({ length: n }, (_, i) => i).sort((i, j) => A[j][j] - A[i][i]);

    return { values: order.map((i) => A[i][i]), vectors: V.map((row) => order.map((i) => row[i])) };
}

/** Eigenvalues of a general real matrix (Hessenberg + shifted QR), complex pairs included: [{ re, im }]. */
export function eigenvalues(a) {
    const n = a.length;
    const H = a.map((row) => [...row]);

    // Reduce to Hessenberg form.
    for (let m = 1; m < n - 1; m += 1) {
        let x = 0;
        let i = m;

        for (let j = m; j < n; j += 1) {
            if (Math.abs(H[j][m - 1]) > Math.abs(x)) {
                x = H[j][m - 1];
                i = j;
            }
        }

        if (i !== m) {
            [H[i], H[m]] = [H[m], H[i]];
            H.forEach((row) => {
                [row[i], row[m]] = [row[m], row[i]];
            });
        }

        if (x !== 0) {
            for (i = m + 1; i < n; i += 1) {
                let y = H[i][m - 1];

                if (y !== 0) {
                    y /= x;
                    H[i][m - 1] = y;

                    for (let j = m; j < n; j += 1) {
                        H[i][j] -= y * H[m][j];
                    }

                    for (let j = 0; j < n; j += 1) {
                        H[j][m] += y * H[j][i];
                    }
                }
            }
        }
    }

    for (let i = 2; i < n; i += 1) {
        for (let j = 0; j < i - 1; j += 1) {
            H[i][j] = 0;
        }
    }

    // Francis QR (Numerical Recipes hqr).
    const wr = Array(n).fill(0);
    const wi = Array(n).fill(0);
    let nn = n - 1;
    let anorm = 0;
    let t = 0;

    for (let i = 0; i < n; i += 1) {
        for (let j = Math.max(i - 1, 0); j < n; j += 1) {
            anorm += Math.abs(H[i][j]);
        }
    }

    let p = 0;
    let q = 0;
    let r = 0;
    let s = 0;
    let w;
    let x;
    let y;
    let z = 0;

    while (nn >= 0) {
        let its = 0;
        let l;

        do {
            for (l = nn; l >= 1; l -= 1) {
                s = Math.abs(H[l - 1][l - 1]) + Math.abs(H[l][l]);

                if (s === 0) {
                    s = anorm;
                }

                if (Math.abs(H[l][l - 1]) + s === s) {
                    H[l][l - 1] = 0;
                    break;
                }
            }

            x = H[nn][nn];

            if (l === nn) {
                wr[nn] = x + t;
                wi[nn] = 0;
                nn -= 1;
            } else {
                y = H[nn - 1][nn - 1];
                w = H[nn][nn - 1] * H[nn - 1][nn];

                if (l === nn - 1) {
                    p = 0.5 * (y - x);
                    q = p * p + w;
                    z = Math.sqrt(Math.abs(q));
                    x += t;

                    if (q >= 0) {
                        z = p + (p >= 0 ? Math.abs(z) : -Math.abs(z));
                        wr[nn - 1] = wr[nn] = x + z;

                        if (z) {
                            wr[nn] = x - w / z;
                        }

                        wi[nn - 1] = wi[nn] = 0;
                    } else {
                        wr[nn - 1] = wr[nn] = x + p;
                        wi[nn - 1] = -(wi[nn] = z);
                    }

                    nn -= 2;
                } else {
                    if (its === 60) {
                        throw new Error('Eigenvalues did not converge');
                    }

                    if (its === 10 || its === 20) {
                        t += x;

                        for (let i = 0; i <= nn; i += 1) {
                            H[i][i] -= x;
                        }

                        s = Math.abs(H[nn][nn - 1]) + Math.abs(H[nn - 1][nn - 2]);
                        y = x = 0.75 * s;
                        w = -0.4375 * s * s;
                    }

                    its += 1;
                    let m;

                    for (m = nn - 2; m >= l; m -= 1) {
                        z = H[m][m];
                        r = x - z;
                        s = y - z;
                        p = (r * s - w) / H[m + 1][m] + H[m][m + 1];
                        q = H[m + 1][m + 1] - z - r - s;
                        r = H[m + 2][m + 1];
                        s = Math.abs(p) + Math.abs(q) + Math.abs(r);
                        p /= s;
                        q /= s;
                        r /= s;

                        if (m === l) {
                            break;
                        }

                        const u = Math.abs(H[m][m - 1]) * (Math.abs(q) + Math.abs(r));
                        const v = Math.abs(p) * (Math.abs(H[m - 1][m - 1]) + Math.abs(z) + Math.abs(H[m + 1][m + 1]));

                        if (u + v === v) {
                            break;
                        }
                    }

                    for (let i = m + 2; i <= nn; i += 1) {
                        H[i][i - 2] = 0;

                        if (i !== m + 2) {
                            H[i][i - 3] = 0;
                        }
                    }

                    for (let k = m; k <= nn - 1; k += 1) {
                        if (k !== m) {
                            p = H[k][k - 1];
                            q = H[k + 1][k - 1];
                            r = 0;

                            if (k !== nn - 1) {
                                r = H[k + 2][k - 1];
                            }

                            x = Math.abs(p) + Math.abs(q) + Math.abs(r);

                            if (x !== 0) {
                                p /= x;
                                q /= x;
                                r /= x;
                            }
                        }

                        const sg = Math.sqrt(p * p + q * q + r * r);
                        s = p >= 0 ? sg : -sg;

                        if (s !== 0) {
                            if (k === m) {
                                if (l !== m) {
                                    H[k][k - 1] = -H[k][k - 1];
                                }
                            } else {
                                H[k][k - 1] = -s * x;
                            }

                            p += s;
                            x = p / s;
                            y = q / s;
                            z = r / s;
                            q /= p;
                            r /= p;

                            for (let j = k; j <= nn; j += 1) {
                                p = H[k][j] + q * H[k + 1][j];

                                if (k !== nn - 1) {
                                    p += r * H[k + 2][j];
                                    H[k + 2][j] -= p * z;
                                }

                                H[k + 1][j] -= p * y;
                                H[k][j] -= p * x;
                            }

                            const mmin = nn < k + 3 ? nn : k + 3;

                            for (let i = l; i <= mmin; i += 1) {
                                p = x * H[i][k] + y * H[i][k + 1];

                                if (k !== nn - 1) {
                                    p += z * H[i][k + 2];
                                    H[i][k + 2] -= p * r;
                                }

                                H[i][k + 1] -= p * q;
                                H[i][k] -= p;
                            }
                        }
                    }
                }
            }
        } while (l < nn - 1);
    }

    const scaleRef = Math.max(1, ...wr.map(Math.abs));

    return wr.map((re, i) => ({ re, im: Math.abs(wi[i]) < 1e-6 * scaleRef ? 0 : wi[i] })).sort((u, v) => v.re - u.re || v.im - u.im);
}

/** Null-space vector of (A − λI) for a real eigenvalue, normalised (inverse iteration). */
export function eigenvector(a, lambda) {
    const n = a.length;
    const shifted = a.map((row, i) => row.map((v, j) => v - (i === j ? lambda + 1e-10 * (1 + Math.abs(lambda)) : 0)));
    let v = Array.from({ length: n }, (_, i) => 1 / Math.sqrt(n) + i * 1e-3);

    for (let it = 0; it < 50; it += 1) {
        const next = solveNum(shifted, v);

        if (!next) {
            break;
        }

        const norm = Math.hypot(...next);
        v = next.map((e) => e / norm);
    }

    // Sign convention: first non-zero component positive.
    const lead = v.find((e) => Math.abs(e) > 1e-9) ?? 1;

    return v.map((e) => (lead < 0 ? -e : e)).map((e) => (Math.abs(e) < 1e-12 ? 0 : e));
}

/** Gaussian elimination with partial pivoting on doubles. */
export function solveNum(a, b) {
    const n = a.length;
    const M = a.map((row, i) => [...row, b[i]]);

    for (let k = 0; k < n; k += 1) {
        let p = k;

        for (let i = k + 1; i < n; i += 1) {
            if (Math.abs(M[i][k]) > Math.abs(M[p][k])) {
                p = i;
            }
        }

        if (Math.abs(M[p][k]) < 1e-300) {
            return null;
        }

        [M[p], M[k]] = [M[k], M[p]];

        for (let i = k + 1; i < n; i += 1) {
            const f = M[i][k] / M[k][k];

            for (let j = k; j <= n; j += 1) {
                M[i][j] -= f * M[k][j];
            }
        }
    }

    const x = Array(n).fill(0);

    for (let i = n - 1; i >= 0; i -= 1) {
        let s = M[i][n];

        for (let j = i + 1; j < n; j += 1) {
            s -= M[i][j] * x[j];
        }

        x[i] = s / M[i][i];
    }

    return x;
}

/** Thin SVD from the symmetric eigen problem of AᵀA (fine for the small matrices here). */
export function svd(a) {
    const m = a.length;
    const n = a[0].length;
    const ata = matmul(T(a), a);
    const { values, vectors } = eigSym(ata);
    const sigma = values.map((v) => Math.sqrt(Math.max(0, v)));
    const k = Math.min(m, n);
    const V = vectors;
    const U = zeros(m, k);

    for (let j = 0; j < k; j += 1) {
        if (sigma[j] > 1e-12 * (sigma[0] || 1)) {
            for (let i = 0; i < m; i += 1) {
                U[i][j] = a[i].reduce((acc, v, c) => acc + v * V[c][j], 0) / sigma[j];
            }
        }
    }

    // Complete U with Gram–Schmidt where singular values vanish.
    for (let j = 0; j < k; j += 1) {
        if (U.every((row) => row[j] === 0)) {
            for (let e = 0; e < m; e += 1) {
                let v = Array.from({ length: m }, (_, i) => (i === e ? 1 : 0));

                for (let c = 0; c < k; c += 1) {
                    if (c !== j && U.some((row) => row[c] !== 0)) {
                        const d = v.reduce((acc, x, i) => acc + x * U[i][c], 0);
                        v = v.map((x, i) => x - d * U[i][c]);
                    }
                }

                const norm = Math.hypot(...v);

                if (norm > 1e-6) {
                    v.forEach((x, i) => {
                        U[i][j] = x / norm;
                    });
                    break;
                }
            }
        }
    }

    return { U, S: sigma.slice(0, k), V: V.map((row) => row.slice(0, k)) };
}

export function pinv(a) {
    const { U, S, V } = svd(a);
    const tol = 1e-12 * Math.max(...a.map((r) => r.length), a.length) * (S[0] || 0);

    return V.map((vrow) => U.map((urow) => S.reduce((acc, s, k) => acc + (s > tol ? (vrow[k] * urow[k]) / s : 0), 0)));
}

export function norms(a) {
    const abs = a.map((row) => row.map(Math.abs));
    const one = Math.max(...abs[0].map((_, j) => abs.reduce((acc, row) => acc + row[j], 0)));
    const inf = Math.max(...abs.map((row) => row.reduce((x, y) => x + y, 0)));
    const fro = Math.sqrt(abs.flat().reduce((acc, v) => acc + v * v, 0));
    const two = svd(a).S[0];
    const max = Math.max(...abs.flat());

    return { one, two, inf, fro, max };
}

/**
 * Characteristic polynomial det(λI − A) exactly (Faddeev–LeVerrier), coefficients low degree first.
 */
export function charPoly(a) {
    const n = a.length;
    let M = identity(n).map((row) => row.map(() => R.ZERO));
    const coeffs = Array(n + 1).fill(R.ZERO);
    coeffs[n] = R.ONE;

    for (let k = 1; k <= n; k += 1) {
        // M_k = A·M_{k−1} + c_{n−k+1}·I
        M = mulM(a, M).map((row, i) => row.map((v, j) => (i === j ? R.add(v, coeffs[n - k + 1]) : v)));
        const tr = trace(mulM(a, M));
        coeffs[n - k] = R.div(R.neg(tr), R.Q(k));
    }

    return coeffs;
}
