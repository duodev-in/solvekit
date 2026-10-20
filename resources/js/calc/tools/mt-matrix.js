import { defineTools } from '../engines/formula.js';
import * as C from '../math/complex.js';
import { parse, ParseError, evalExact, variables } from '../math/expr.js';
import * as L from '../math/linalg.js';
import * as P from '../math/poly.js';
import { f, fail, need, R, result } from '../math/util.js';

/**
 * Linear algebra on typed matrices (one row per line, fractions allowed). Exact rational arithmetic for
 * arithmetic, determinants, inverses, row reduction, null and column spaces, Cramer, LU and the characteristic
 * polynomial; floating point (checked by residuals) for QR, Cholesky, eigenvalues, SVD, polar decomposition,
 * pseudoinverse, norms and condition numbers. Also Gram–Schmidt, linear combinations, independence and the
 * corner points of a linear program.
 */
const { abs, sqrt } = Math;
const t = (x) => R.toFraction(x);
const num = (v) => (typeof v === 'number' ? v : R.toNumber(v));
const cellText = (v) => (typeof v === 'number' ? f(abs(v) < 1e-12 ? 0 : v, 8) : t(v));
const grid = (m) => ({ columns: m[0].map((_, j) => `${j + 1}`), rows: m.map((row, i) => ({ header: `${i + 1}`, cells: row.map(cellText) })) });
const dims = (m) => `${m.length} × ${m[0].length}`;
const showM = (m) => L.show(m, cellText);

function readM(text, label) {
    const out = L.parseMatrix(text);

    if (out.error) {
        return { error: String(text ?? '').trim() ? `${label}: ${out.error}` : null, empty: `Enter matrix ${label}, one row per line.` };
    }

    return out;
}

/** Vectors typed one per line. */
function readVectors(text) {
    const out = L.parseMatrix(text);

    return out.error ? null : out.m;
}

const isSquare = (m) => m.length === m[0].length;
const isSymmetric = (m) => isSquare(m) && m.every((row, i) => row.every((v, j) => R.eq(v, m[j][i])));
const maxResidual = (a, b) => Math.max(...a.flatMap((row, i) => row.map((v, j) => abs(num(v) - num(b[i][j])))));

/** Exact LU with row swaps only when a pivot is zero: PA = LU. */
function exactLU(a) {
    const n = a.length;
    const U = a.map((row) => [...row]);
    const Lm = L.identity(n).map((row) => row.map(() => R.ZERO));
    const perm = Array.from({ length: n }, (_, i) => i);
    const ops = [];

    for (let k = 0; k < n; k += 1) {
        let p = k;

        while (p < n && R.isZero(U[p][k])) {
            p += 1;
        }

        if (p === n) {
            continue;
        }

        if (p !== k) {
            [U[p], U[k]] = [U[k], U[p]];
            [Lm[p], Lm[k]] = [Lm[k], Lm[p]];
            [perm[p], perm[k]] = [perm[k], perm[p]];
            ops.push(`Swap R${k + 1} and R${p + 1}`);
        }

        for (let i = k + 1; i < n; i += 1) {
            const factor = R.div(U[i][k], U[k][k]);
            Lm[i][k] = factor;

            if (!R.isZero(factor)) {
                U[i] = U[i].map((v, j) => R.sub(v, R.mul(factor, U[k][j])));
                ops.push(`R${i + 1} → R${i + 1} − (${t(factor)})·R${k + 1}  (l${i + 1}${k + 1} = ${t(factor)})`);
            }
        }
    }

    for (let i = 0; i < n; i += 1) {
        Lm[i][i] = R.ONE;
    }

    const Pm = perm.map((r) => Array.from({ length: n }, (_, j) => (j === r ? R.ONE : R.ZERO)));

    return { L: Lm, U, P: Pm, ops, swapped: perm.some((v, i) => v !== i) };
}

/** Classical Gram–Schmidt on rows (exact for the orthogonal set, then normalised numerically). */
function gramSchmidt(vs) {
    const out = [];
    const steps = [];

    vs.forEach((v, k) => {
        let w = [...v];

        out.forEach((u, j) => {
            const c = R.div(dot(v, u), dot(u, u));
            w = w.map((x, i) => R.sub(x, R.mul(c, u[i])));
            steps.push(`u${k + 1} −= (v${k + 1} · u${j + 1} ÷ u${j + 1} · u${j + 1}) u${j + 1} = ${t(c)} u${j + 1}`);
        });

        if (w.every((x) => R.isZero(x))) {
            steps.push(`v${k + 1} depends on the earlier vectors and is dropped`);
        } else {
            out.push(w);
            steps.push(`u${out.length} = (${w.map(t).join(', ')})`);
        }
    });

    return { orthogonal: out, steps };
}

const dot = (u, v) => u.reduce((s, x, i) => R.add(s, R.mul(x, v[i])), R.ZERO);

function eigenInfo(A) {
    const vals = L.eigenvalues(L.toNum(A));
    const cp = L.charPoly(A);

    return { vals, cp };
}

const valText = (z) => C.text(C.c(z.re, z.im), 10);

/** "2·v1 − v2 + 3·v3" from coefficients. */
function combo(coeffs, name = 'v') {
    const terms = coeffs.map((cf, k) => [cf, `${name}${k + 1}`]).filter(([cf]) => !R.isZero(cf));

    if (!terms.length) {
        return '0';
    }

    return terms.map(([cf, v], n) => {
        const mag = R.qabs(cf);
        const body = R.eq(mag, R.ONE) ? v : `${t(mag)}·${v}`;

        return n === 0 ? `${R.sign(cf) < 0 ? '−' : ''}${body}` : ` ${R.sign(cf) < 0 ? '−' : '+'} ${body}`;
    }).join('');
}

export const handlers = {
    matrix: (i, c) => {
        const op = c.op ?? i.op ?? 'mul';
        const two = ['add', 'sub', 'mul', 'hadamard', 'kron', 'cramer'].includes(op);
        const A0 = readM(i.a, 'A');

        if (A0.error) {
            return fail(A0.error);
        }

        if (!A0.m) {
            return need(A0.empty);
        }

        const A = A0.m;
        let B = null;

        if (two) {
            const B0 = op === 'cramer' ? { m: String(i.b ?? '').split(/[\n,;\s]+/).filter(Boolean).map((v) => [R.parseNumber(v)]) } : readM(i.b, 'B');

            if (B0.error) {
                return fail(B0.error);
            }

            if (!B0.m || !B0.m.length || B0.m.some((row) => row.some((v) => v === null))) {
                return need(op === 'cramer' ? 'Enter the right-hand side b, one number per equation.' : B0.empty);
            }

            B = B0.m;
        }

        const square = isSquare(A);
        const needSquare = (what) => fail(`${what} needs a square matrix; A is ${dims(A)}.`);
        const rows = { size: dims(A) };
        const steps = [`A =\n${showM(A)}`];
        let value;
        let label;
        let out = null;
        let sub = '';

        switch (op) {
            case 'add':
            case 'sub':
            case 'hadamard': {
                if (A.length !== B.length || A[0].length !== B[0].length) {
                    return fail(`A is ${dims(A)} but B is ${dims(B)}; they must be the same size.`);
                }

                out = op === 'add' ? L.addM(A, B) : op === 'sub' ? L.subM(A, B) : A.map((row, r) => row.map((v, k) => R.mul(v, B[r][k])));
                label = { add: 'A + B', sub: 'A − B', hadamard: 'Hadamard product A ∘ B' }[op];
                steps.push(`B =\n${showM(B)}`, `${op === 'hadamard' ? 'Multiply' : op === 'add' ? 'Add' : 'Subtract'} entry by entry:`);
                break;
            }

            case 'mul': {
                if (A[0].length !== B.length) {
                    return fail(`A has ${A[0].length} columns but B has ${B.length} rows; for AB they must match.`);
                }

                out = L.mulM(A, B);
                label = 'AB';
                steps.push(`B =\n${showM(B)}`, `Entry (i, j) = row i of A · column j of B, e.g. (1, 1) = ${A[0].map((v, k) => `${t(v)}·${t(B[k][0])}`).join(' + ')} = ${t(out[0][0])}`);
                rows.commute = isSquare(A) && isSquare(B) && A.length === B.length ? (L.mulM(B, A).every((row, r) => row.every((v, k) => R.eq(v, out[r][k]))) ? 'AB = BA here' : 'AB ≠ BA (matrix multiplication is not commutative)') : `Result is ${A.length} × ${B[0].length}`;
                break;
            }

            case 'kron': {
                out = A.flatMap((rowA) => B.map((rowB) => rowA.flatMap((a) => rowB.map((b) => R.mul(a, b)))));
                label = 'Kronecker (tensor) product A ⊗ B';
                steps.push(`B =\n${showM(B)}`, 'Each entry aᵢⱼ of A becomes the block aᵢⱼB');
                break;
            }

            case 'scalar': {
                const k = R.parseNumber(String(i.k ?? ''));

                if (!k) {
                    return need('Enter the scalar k.');
                }

                out = L.scaleM(A, k);
                label = `${t(k)}A`;
                steps.push(`Multiply every entry by ${t(k)}`);
                break;
            }

            case 'power': {
                if (!square) {
                    return needSquare('A power');
                }

                const n = Number(i.n);

                if (!Number.isInteger(n) || n < -20 || n > 200) {
                    return need('Enter a whole-number power from −20 to 200.');
                }

                const base = n < 0 ? L.inverse(A) : A;

                if (!base) {
                    return fail('A is singular, so negative powers do not exist.');
                }

                out = L.powM(base, Math.abs(n));
                label = `A^${n}`;
                steps.push(n < 0 ? `A⁻¹ first, then raise to ${-n}` : `Repeated squaring: A^${n}`);
                break;
            }

            case 'transpose': {
                out = L.transpose(A);
                label = 'Aᵀ';
                rows.symmetric = isSymmetric(A) ? 'A is symmetric (A = Aᵀ)' : 'A is not symmetric';
                steps.push('Rows become columns: (Aᵀ)ᵢⱼ = Aⱼᵢ');
                break;
            }

            case 'det':
            case 'expansion': {
                if (!square) {
                    return needSquare('A determinant');
                }

                const d = L.det(A);
                value = t(d);
                label = 'det A';
                sub = R.isZero(d) ? 'Singular: no inverse, the rows are dependent' : 'Invertible';

                if (op === 'expansion' || A.length <= 3) {
                    const terms = A[0].map((v, j) => {
                        const minor = A.length === 1 ? R.ONE : L.det(L.minor(A, 0, j));
                        const sign = j % 2 ? '−' : '+';

                        return { text: `${sign} ${t(v)} × det(M1${j + 1}) = ${sign} ${t(v)} × ${t(minor)}`, value: R.mul(R.Q(j % 2 ? -1 : 1), R.mul(v, minor)) };
                    });
                    steps.push('Cofactor expansion along row 1: det A = Σ (−1)^(1+j) a1j det(M1j)', ...terms.map((x) => x.text), `= ${t(d)}`);
                } else {
                    steps.push('Row reduction (Bareiss, exact): the determinant is the product of the pivots with a sign for each swap', `det A = ${t(d)}`);
                }

                rows.inverse = R.isZero(d) ? 'None' : `Exists (det ≠ 0)`;
                break;
            }

            case 'inverse': {
                if (!square) {
                    return needSquare('An inverse');
                }

                out = L.inverse(A);

                if (!out) {
                    return fail('A is singular (det = 0), so it has no inverse. Try the pseudoinverse.');
                }

                label = 'A⁻¹';
                rows.det = t(L.det(A));
                const aug = A.map((row, r) => [...row, ...L.identity(A.length)[r]]);
                const red = L.rref(aug, { augmentedCols: A.length });
                steps.push('Row-reduce [A | I] to [I | A⁻¹]:', ...red.ops.slice(0, 40), ...(red.ops.length > 40 ? [`… ${red.ops.length - 40} more operations`] : []));
                rows.check = 'A·A⁻¹ = I ✓';
                break;
            }

            case 'rank': {
                const red = L.rref(A);
                value = String(red.pivots.length);
                label = 'Rank';
                sub = `Nullity ${A[0].length - red.pivots.length} (rank + nullity = ${A[0].length} columns)`;
                out = red.rref;
                steps.push(...red.ops.slice(0, 40), `Pivots in columns ${red.pivots.map((p) => p + 1).join(', ') || 'none'}`);
                rows.pivots = red.pivots.map((p) => p + 1).join(', ') || 'None';
                break;
            }

            case 'trace': {
                if (!square) {
                    return needSquare('The trace');
                }

                const tr = L.trace(A);
                value = t(tr);
                label = 'Trace tr A';
                sub = `= ${A.map((row, r) => t(row[r])).join(' + ')}`;
                const ev = L.eigenvalues(L.toNum(A));
                rows.eigensum = `Sum of the eigenvalues: ${f(ev.reduce((s, z) => s + z.re, 0), 10)}`;
                steps.push('Trace = sum of the diagonal entries', `${A.map((row, r) => t(row[r])).join(' + ')} = ${t(tr)}`);
                break;
            }

            case 'rref':
            case 'ref': {
                const red = L.rref(A, { stopAtRef: op === 'ref' });
                out = red.rref;
                label = op === 'ref' ? 'Row echelon form' : 'Reduced row echelon form';
                rows.pivots = red.pivots.map((p) => p + 1).join(', ') || 'None';
                rows.rank = String(red.pivots.length);
                steps.push(...red.ops, 'Done');
                break;
            }

            case 'cofactor':
            case 'adjoint': {
                if (!square) {
                    return needSquare('The cofactor matrix');
                }

                out = op === 'adjoint' ? L.adjugate(A) : L.cofactorMatrix(A);
                label = op === 'adjoint' ? 'Adjugate (classical adjoint) adj A' : 'Cofactor matrix C';
                const d = L.det(A);
                rows.det = t(d);
                rows.inverse = R.isZero(d) ? 'None (det = 0)' : `A⁻¹ = adj A ÷ ${t(d)}`;
                steps.push('Cᵢⱼ = (−1)^(i+j) det(Mᵢⱼ), the determinant with row i and column j removed', ...(op === 'adjoint' ? ['adj A = Cᵀ'] : []));
                break;
            }

            case 'null':
            case 'column': {
                const basis = op === 'null' ? L.nullSpace(A) : L.columnSpace(A);
                const red = L.rref(A);
                label = op === 'null' ? 'Null space basis' : 'Column space basis';
                value = basis.length ? basis.map((v) => `(${v.map(t).join(', ')})`).join(', ') : op === 'null' ? '{0} (only the zero vector)' : '{0}';
                sub = op === 'null' ? `Dimension (nullity) ${basis.length}` : `Dimension (rank) ${basis.length}`;
                out = basis.length ? L.transpose(basis) : null;
                rows.rank = String(red.pivots.length);
                rows.pivots = red.pivots.map((p) => p + 1).join(', ') || 'None';
                steps.push(...red.ops.slice(0, 30), `RREF:\n${showM(red.rref)}`, op === 'null' ? 'Solve Ax = 0: each free column gives one basis vector' : 'The pivot columns of the original A form a basis');
                break;
            }

            case 'charpoly': {
                if (!square) {
                    return needSquare('The characteristic polynomial');
                }

                const cp = L.charPoly(A);
                value = `p(λ) = ${P.toText(cp, 'λ')}`;
                label = 'Characteristic polynomial det(λI − A)';
                const ev = L.eigenvalues(L.toNum(A));
                sub = `Eigenvalues: ${ev.map(valText).join(', ')}`;
                rows.det = `det A = ${t(L.det(A))} = (−1)ⁿ × constant term`;
                rows.trace = `trace A = ${t(L.trace(A))} = −(λ^(n−1) coefficient)`;
                steps.push('Faddeev–LeVerrier recursion gives the coefficients exactly', `p(λ) = ${P.toText(cp, 'λ')}`, `Factored over the rationals: ${P.factorText(cp, 'λ')}`);
                break;
            }

            case 'eigen':
            case 'diagonalize': {
                if (!square) {
                    return needSquare('Eigenvalues');
                }

                const { vals, cp } = eigenInfo(A);
                const N = L.toNum(A);
                const real = vals.filter((z) => abs(z.im) < 1e-12);
                const distinct = real.filter((z, k) => real.findIndex((w) => abs(w.re - z.re) < 1e-8 * Math.max(1, abs(z.re))) === k);
                const vecs = distinct.map((z) => ({ lambda: z.re, v: L.eigenvector(N, z.re) }));
                const vText = vecs.map(({ lambda, v }) => `λ = ${f(lambda, 10)}: (${v.map((x) => f(x, 8)).join(', ')})`);
                // Geometric multiplicities from the exact null space when λ is rational.
                const geo = P.rationalRoots(cp).roots.map(([root, multiplicity]) => {
                    const shifted = A.map((row, r) => row.map((v, k) => (r === k ? R.sub(v, root) : v)));

                    return { root, alg: multiplicity, geo: L.nullSpace(shifted).length, basis: L.nullSpace(shifted) };
                });
                const exactVecs = geo.map((g) => `λ = ${t(g.root)} (algebraic ${g.alg}, geometric ${g.geo}): ${g.basis.map((v) => `(${v.map(t).join(', ')})`).join(', ')}`);
                const n = A.length;
                const complex = vals.some((z) => abs(z.im) >= 1e-12);
                const defective = geo.some((g) => g.geo < g.alg);
                const totalGeo = geo.reduce((s, g) => s + g.geo, 0);
                const allRational = geo.reduce((s, g) => s + g.alg, 0) === n;
                const diag = !complex && (allRational ? totalGeo === n : distinct.length === n);
                label = op === 'diagonalize' ? 'Diagonalizable?' : 'Eigenvalues';
                value = op === 'diagonalize' ? (diag ? 'Yes, A = PDP⁻¹' : complex ? 'Not over the reals (complex eigenvalues)' : 'No (defective: too few eigenvectors)') : vals.map(valText).join(', ');
                sub = op === 'diagonalize' ? `Eigenvalues ${vals.map(valText).join(', ')}` : `Characteristic polynomial ${P.toText(cp, 'λ')}`;
                rows.eigenvalues = vals.map(valText).join(', ');
                rows.vectors = complex && !real.length ? 'No real eigenvectors (complex eigenvalues)' : allRational ? exactVecs.join('; ') : vText.join('; ');
                rows.charpoly = P.toText(cp, 'λ');

                if (op === 'diagonalize' && diag) {
                    if (allRational) {
                        const Pcols = geo.flatMap((g) => g.basis);
                        const Pm = L.transpose(Pcols);
                        const Dm = Pcols.map((_, k) => Pcols.map((__, j) => (k === j ? geo.flatMap((g) => g.basis.map(() => g.root))[k] : R.ZERO)));
                        out = Dm;
                        rows.P = showM(Pm).replace(/\n/g, ' ');
                        rows.check = L.mulM(L.mulM(Pm, Dm), L.inverse(Pm)).every((row, r) => row.every((v, k) => R.eq(v, A[r][k]))) ? 'PDP⁻¹ = A ✓ (exact)' : 'Check failed';
                        steps.push(`P (eigenvectors as columns) =\n${showM(Pm)}`, `D =\n${showM(Dm)}`);
                    } else {
                        const Pm = L.transposeNum(vecs.map((x) => x.v));
                        out = vecs.map((x, k) => vecs.map((__, j) => (k === j ? x.lambda : 0)));
                        rows.P = showM(Pm).replace(/\n/g, ' ');
                        rows.check = 'Eigenvectors are numerical (irrational eigenvalues)';
                        steps.push(`P (eigenvectors as columns) =\n${showM(Pm)}`);
                    }
                } else {
                    rows.P = diag ? '' : defective ? 'Some eigenvalue has fewer independent eigenvectors than its multiplicity' : complex ? 'Complex eigenvalues: diagonalizable over ℂ if they are distinct' : '';
                    rows.check = rows.P || 'Not applicable';
                }

                steps.push(`Characteristic polynomial: ${P.toText(cp, 'λ')}`, `Eigenvalues: ${vals.map(valText).join(', ')}`, ...(allRational ? exactVecs : vText));
                break;
            }

            case 'lu': {
                if (!square) {
                    return needSquare('LU decomposition');
                }

                const { L: Lm, U, P: Pm, ops, swapped } = exactLU(A);
                out = U;
                label = swapped ? 'PA = LU' : 'A = LU';
                value = swapped ? 'PA = LU (rows swapped)' : 'A = LU';
                rows.L = showM(Lm).replace(/\n/g, ' ');
                rows.P = swapped ? showM(Pm).replace(/\n/g, ' ') : 'Identity (no swaps)';
                rows.check = L.mulM(Lm, U).every((row, r) => row.every((v, k) => R.eq(v, L.mulM(Pm, A)[r][k]))) ? 'LU = PA ✓ (exact)' : 'Check failed';
                steps.push(...ops, `L =\n${showM(Lm)}`, `U =\n${showM(U)}`);
                sub = 'Grid: U (upper triangular)';
                break;
            }

            case 'qr': {
                const N = L.toNum(A);

                if (A.length < A[0].length) {
                    return fail('QR here needs at least as many rows as columns.');
                }

                const { Q, R: Rm } = L.qr(N);
                out = Rm;
                label = 'A = QR';
                value = 'A = QR';
                sub = 'Grid: R (upper triangular)';
                rows.Q = showM(Q).replace(/\n/g, ' ');
                rows.check = `max |QR − A| = ${f(maxResidual(L.matmul(Q, Rm), N), 3)}; QᵀQ = I`;
                steps.push('Householder reflections (numerical)', `Q =\n${showM(Q)}`, `R =\n${showM(Rm)}`);
                break;
            }

            case 'cholesky': {
                if (!isSymmetric(A)) {
                    return fail('Cholesky needs a symmetric matrix (A = Aᵀ).');
                }

                const Lm = L.cholesky(L.toNum(A));

                if (!Lm) {
                    return fail('A is not positive definite, so it has no Cholesky factorisation.');
                }

                out = Lm;
                label = 'A = LLᵀ';
                value = 'A = LLᵀ';
                sub = 'Grid: L (lower triangular)';
                rows.check = `max |LLᵀ − A| = ${f(maxResidual(L.matmul(Lm, L.transposeNum(Lm)), L.toNum(A)), 3)}`;
                rows.det = `det A = (product of the diagonal of L)² = ${f(Lm.reduce((s, row, r) => s * row[r], 1) ** 2, 12)}`;
                steps.push('l11 = √a11, then each entry from the ones above it', `L =\n${showM(Lm)}`);
                break;
            }

            case 'svd':
            case 'singular': {
                const N = L.toNum(A);
                const { U, S, V } = L.svd(N);
                label = op === 'svd' ? 'A = UΣVᵀ' : 'Singular values';
                value = S.map((s) => f(s, 10)).join(', ');
                sub = `Rank ${S.filter((s) => s > 1e-10 * (S[0] || 1)).length}; condition number ${S[S.length - 1] > 1e-14 * S[0] ? f(S[0] / S[S.length - 1], 10) : '∞'}`;
                rows.U = showM(U).replace(/\n/g, ' ');
                rows.V = showM(V).replace(/\n/g, ' ');
                const recon = U.map((row) => V.map((vrow) => row.reduce((s, u, k) => s + u * S[k] * vrow[k], 0)));
                rows.check = `max |UΣVᵀ − A| = ${f(maxResidual(recon, N), 3)}`;
                out = op === 'svd' ? S.map((s, k) => S.map((__, j) => (k === j ? s : 0))) : null;
                steps.push('σᵢ = √(eigenvalues of AᵀA)', `σ = ${S.map((s) => f(s, 12)).join(', ')}`, ...(op === 'svd' ? [`U =\n${showM(U)}`, `V =\n${showM(V)}`] : []));
                break;
            }

            case 'pinv': {
                const N = L.toNum(A);
                out = L.pinv(N);
                label = 'Moore–Penrose pseudoinverse A⁺';
                const check = maxResidual(L.matmul(L.matmul(N, out), N), N);
                rows.check = `max |AA⁺A − A| = ${f(check, 3)}`;
                rows.size = `${dims(A)} → A⁺ is ${A[0].length} × ${A.length}`;

                rows.inverse = isSquare(A) && L.inverse(A) ? 'A is invertible, so A⁺ = A⁻¹' : 'A has no ordinary inverse; A⁺ gives the least squares solution x = A⁺b';

                steps.push('A⁺ = V Σ⁺ Uᵀ from the SVD (reciprocals of the non-zero singular values)', `A⁺ =\n${showM(out)}`);
                break;
            }

            case 'polar': {
                if (!square) {
                    return needSquare('The polar decomposition');
                }

                const N = L.toNum(A);
                const { U, S, V } = L.svd(N);
                const Um = L.matmul(U, L.transposeNum(V));
                const Pm = L.matmul(L.matmul(V, S.map((s, k) => S.map((__, j) => (k === j ? s : 0)))), L.transposeNum(V));
                out = Pm;
                label = 'A = UP';
                value = 'A = UP (rotation × stretch)';
                sub = 'Grid: P (symmetric positive semidefinite)';
                rows.U = showM(Um).replace(/\n/g, ' ');
                rows.check = `max |UP − A| = ${f(maxResidual(L.matmul(Um, Pm), N), 3)}; U is orthogonal, det U = ${f(Math.sign(L.det(A) ? num(L.det(A)) : 1), 2)}`;
                steps.push('From the SVD A = WΣVᵀ: U = WVᵀ and P = VΣVᵀ', `U =\n${showM(Um)}`, `P =\n${showM(Pm)}`);
                break;
            }

            case 'norm':
            case 'cond': {
                const N = L.toNum(A);
                const nm = L.norms(N);
                rows.norms = `‖A‖₁ = ${f(nm.one, 10)}, ‖A‖₂ = ${f(nm.two, 10)}, ‖A‖∞ = ${f(nm.inf, 10)}, Frobenius ${f(nm.fro, 10)}, max ${f(nm.max, 10)}`;

                if (op === 'norm') {
                    value = f(nm.fro, 12);
                    label = 'Frobenius norm ‖A‖F';
                    sub = `Spectral ‖A‖₂ = ${f(nm.two, 10)}`;
                    steps.push('‖A‖₁ = largest column sum, ‖A‖∞ = largest row sum, ‖A‖₂ = largest singular value, ‖A‖F = √(Σ aᵢⱼ²)', rows.norms);
                } else {
                    if (!square) {
                        return needSquare('The condition number');
                    }

                    const S = L.svd(N).S;
                    const kappa = S[S.length - 1] > 1e-15 * S[0] ? S[0] / S[S.length - 1] : Infinity;
                    value = Number.isFinite(kappa) ? f(kappa, 10) : '∞ (singular)';
                    label = 'Condition number κ₂(A)';
                    sub = Number.isFinite(kappa) ? `About ${f(Math.log10(kappa), 3)} digits of accuracy may be lost solving Ax = b` : 'A is singular';
                    const inv = L.inverse(A);
                    rows.other = inv ? `κ₁ = ${f(nm.one * L.norms(L.toNum(inv)).one, 10)}, κ∞ = ${f(nm.inf * L.norms(L.toNum(inv)).inf, 10)}` : 'Infinite (no inverse)';
                    steps.push('κ₂ = σmax ÷ σmin', `= ${f(S[0], 12)} ÷ ${f(S[S.length - 1], 12)} = ${value}`);
                }

                break;
            }

            case 'cramer': {
                if (!square) {
                    return needSquare('Cramer\'s rule');
                }

                if (B.length !== A.length) {
                    return fail(`b needs ${A.length} numbers, one per equation.`);
                }

                const d = L.det(A);

                if (R.isZero(d)) {
                    return fail('det A = 0, so Cramer\'s rule does not apply (no unique solution).');
                }

                const xs = A.map((_, j) => {
                    const Aj = A.map((row, r) => row.map((v, k) => (k === j ? B[r][0] : v)));
                    const dj = L.det(Aj);
                    steps.push(`det A${j + 1} (column ${j + 1} replaced by b) = ${t(dj)} → x${j + 1} = ${t(dj)} ÷ ${t(d)} = ${t(R.div(dj, d))}`);

                    return R.div(dj, d);
                });
                steps.splice(1, 0, `det A = ${t(d)}`);
                value = xs.map((x, j) => `x${j + 1} = ${t(x)}`).join(', ');
                label = 'Solution by Cramer\'s rule';
                sub = `det A = ${t(d)}`;
                rows.det = t(d);
                rows.check = 'Ax = b ✓';
                break;
            }

            default:
                return need('Choose an operation.');
        }

        if (out) {
            const isMatrix = Array.isArray(out[0]);
            value ??= `${dims(out)} matrix`;
            rows.result = isMatrix ? showM(out).replace(/\n/g, ' ') : '';
            steps.push(`${label} =\n${showM(out)}`);
        }

        return result(value, label, { sub: sub || (out ? `${dims(out)} result shown in the grid` : ''), rows: { result: rows.result ?? value, size: rows.size, ...rows }, steps, grids: out ? { matrix: grid(out) } : undefined });
    },

    vectors: (i, c) => {
        const mode = c.mode ?? 'indep';
        const vs = readVectors(i.vecs);

        if (!vs) {
            return need('Type the vectors one per line, such as 1 2 3.');
        }

        if (mode === 'gram') {
            const { orthogonal, steps } = gramSchmidt(vs);
            const unit = orthogonal.map((u) => {
                const n = sqrt(num(dot(u, u)));

                return u.map((x) => num(x) / n);
            });

            return result(`${orthogonal.length} orthonormal vector${orthogonal.length === 1 ? '' : 's'}`, 'Gram–Schmidt', { sub: orthogonal.length < vs.length ? `${vs.length - orthogonal.length} dependent vector${vs.length - orthogonal.length === 1 ? '' : 's'} dropped` : 'The vectors were independent', rows: { orthogonal: orthogonal.map((u) => `(${u.map(t).join(', ')})`).join('; '), orthonormal: unit.map((u) => `(${u.map((x) => f(x, 8)).join(', ')})`).join('; '), check: `Largest |eᵢ · eⱼ| for i ≠ j: ${f(Math.max(0, ...unit.flatMap((u, a) => unit.slice(a + 1).map((w) => abs(u.reduce((s, x, k) => s + x * w[k], 0))))), 3)}` }, steps: ['uₖ = vₖ − Σ proj_{uⱼ} vₖ, then eₖ = uₖ ÷ |uₖ|', ...steps], grids: { matrix: grid(unit) } });
        }

        const red = L.rref(L.transpose(vs));
        const rank = red.pivots.length;

        if (mode === 'indep') {
            const indep = rank === vs.length;
            const dep = indep ? null : L.nullSpace(L.transpose(vs))[0];

            return result(indep ? 'Linearly independent' : 'Linearly dependent', 'Independence', { sub: `Rank ${rank} of ${vs.length} vectors${vs.length > vs[0].length ? ` (more vectors than dimensions ${vs[0].length}, so they must be dependent)` : ''}`, rows: { rank: String(rank), relation: dep ? `${combo(dep)} = 0` : 'Only the trivial combination gives 0', span: rank === vs[0].length ? `They span all of ℝ${vs[0].length}` : `They span a ${rank}-dimensional subspace` }, steps: ['Put the vectors as columns and row-reduce', ...red.ops.slice(0, 30), `Pivots: ${rank} of ${vs.length} columns`] });
        }

        // Linear combination: express the target as a combination of the vectors.
        const target = String(i.target ?? '').trim().split(/[\s,]+/).filter(Boolean).map((v) => R.parseNumber(v));

        if (!target.length || target.some((v) => v === null) || target.length !== vs[0].length) {
            return need(`Enter the target vector with ${vs[0].length} components.`);
        }

        const sol = L.solve(L.transpose(vs), target);

        if (sol.kind === 'none') {
            return result('Not possible', 'Linear combination', { sub: 'The target is not in the span of the vectors', rows: { coefficients: 'None', check: 'Inconsistent system', span: `The vectors span a ${rank}-dimensional subspace` }, steps: ['Solve c₁v₁ + … + cₖvₖ = target', ...sol.ops.slice(0, 30), 'A row 0 = non-zero appears: no solution'] });
        }

        const coeffs = sol.kind === 'unique' ? sol.x : sol.particular;

        return result(combo(coeffs), 'Linear combination', { sub: sol.kind === 'unique' ? 'The only way' : 'One of infinitely many ways (the vectors are dependent)', rows: { coefficients: coeffs.map((cf, k) => `c${k + 1} = ${t(cf)}`).join(', '), check: `= (${target.map(t).join(', ')}) ✓`, span: `The vectors span a ${rank}-dimensional subspace` }, steps: ['Solve c₁v₁ + … + cₖvₖ = target as a linear system', ...sol.ops.slice(0, 30), `c = (${coeffs.map(t).join(', ')})`] });
    },

    corner: (i) => {
        const lines = String(i.constraints ?? '').split(/\n|;/).map((s) => s.trim()).filter(Boolean);
        const objText = String(i.objective ?? '').trim();
        const goal = i.goal ?? 'max';

        if (!lines.length) {
            return need('Type the constraints, one per line, such as x + y <= 4.');
        }

        const parsed = [];

        for (const line of lines) {
            let tree;

            try {
                tree = parse(line);
            } catch (e) {
                if (e instanceof ParseError) {
                    return fail(`${line}: ${e.message}`);
                }

                throw e;
            }

            if (tree.t !== 'rel' || tree.ops.length !== 1 || ![...variables(tree)].every((v) => v === 'x' || v === 'y')) {
                return fail(`${line}: write each constraint as one inequality in x and y.`);
            }

            const F = (x, y) => {
                const env = { x: R.Q(x), y: R.Q(y) };
                const a = evalExact(tree.parts[0], env);
                const b = evalExact(tree.parts[1], env);

                return a && b ? R.sub(a, b) : null;
            };
            const c0 = F(0, 0);

            if (!c0) {
                return fail(`${line}: use numbers and fractions only.`);
            }

            const a = R.sub(F(1, 0), c0);
            const b = R.sub(F(0, 1), c0);

            if (!R.eq(F(2, 3), R.add(c0, R.add(R.mul(a, R.Q(2)), R.mul(b, R.Q(3)))))) {
                return fail(`${line}: constraints must be linear.`);
            }

            const op = tree.ops[0];
            // Store as a x + b y (≤ or ≥ or =) −c0.
            parsed.push({ a, b, rhs: R.neg(c0), op: op === '<' ? '≤' : op === '>' ? '≥' : op.replace('<=', '≤').replace('>=', '≥'), text: line });
        }

        if (i.nonneg !== false && i.nonneg !== 'no') {
            parsed.push({ a: R.ONE, b: R.ZERO, rhs: R.ZERO, op: '≥', text: 'x ≥ 0' }, { a: R.ZERO, b: R.ONE, rhs: R.ZERO, op: '≥', text: 'y ≥ 0' });
        }

        const ok = (x, y) => parsed.every(({ a, b, rhs, op }) => {
            const lhs = R.add(R.mul(a, x), R.mul(b, y));
            const cmp = R.cmp(lhs, rhs);

            return op === '≤' ? cmp <= 0 : op === '≥' ? cmp >= 0 : cmp === 0;
        });
        const pts = [];

        for (let p = 0; p < parsed.length; p += 1) {
            for (let q2 = p + 1; q2 < parsed.length; q2 += 1) {
                const A = parsed[p];
                const B = parsed[q2];
                const det = R.sub(R.mul(A.a, B.b), R.mul(B.a, A.b));

                if (R.isZero(det)) {
                    continue;
                }

                const x = R.div(R.sub(R.mul(A.rhs, B.b), R.mul(B.rhs, A.b)), det);
                const y = R.div(R.sub(R.mul(A.a, B.rhs), R.mul(B.a, A.rhs)), det);

                if (ok(x, y) && !pts.some((pp) => R.eq(pp[0], x) && R.eq(pp[1], y))) {
                    pts.push([x, y]);
                }
            }
        }

        if (!pts.length) {
            return fail('The constraints have no corner points: the feasible region is empty (or has no vertices).');
        }

        // Order around the centroid for drawing.
        const cx = pts.reduce((s, p) => s + num(p[0]), 0) / pts.length;
        const cy = pts.reduce((s, p) => s + num(p[1]), 0) / pts.length;
        pts.sort((u, v) => Math.atan2(num(u[1]) - cy, num(u[0]) - cx) - Math.atan2(num(v[1]) - cy, num(v[0]) - cx));
        let best = null;
        const values = [];

        if (objText) {
            let obj;

            try {
                obj = parse(objText.replace(/^[A-Za-z]\s*=/, ''));
            } catch (e) {
                if (e instanceof ParseError) {
                    return fail(`Objective: ${e.message}`);
                }

                throw e;
            }

            pts.forEach((p) => {
                const v = evalExact(obj, { x: p[0], y: p[1] });
                values.push(v);

                if (v && (!best || (goal === 'max' ? R.cmp(v, best.v) > 0 : R.cmp(v, best.v) < 0))) {
                    best = { p, v };
                }
            });
        }

        const list = pts.map((p, k) => `(${t(p[0])}, ${t(p[1])})${values[k] ? ` → ${t(values[k])}` : ''}`);
        const span = Math.max(1, ...pts.flat().map((v) => abs(num(v)))) * 1.15;

        return result(best ? `${goal === 'max' ? 'Maximum' : 'Minimum'} ${t(best.v)} at (${t(best.p[0])}, ${t(best.p[1])})` : `${pts.length} corner points`, 'Corner points', { sub: best ? `Checked all ${pts.length} corners` : 'Enter an objective to optimise', rows: { corners: list.join('; '), constraints: parsed.map((x) => x.text).join('; '), note: 'If the region is unbounded, an optimum may not exist even when a corner is listed' }, steps: ['Intersect each pair of boundary lines, keep the points that satisfy every constraint', ...list, ...(best ? [`Corner point theorem: the optimum of a linear objective over a bounded region is at a corner: ${t(best.v)}`] : [])], plots: { diagram: { kind: 'diagram', shapes: [{ points: [[-span * 0.1, 0], [span, 0]], muted: true }, { points: [[0, -span * 0.1], [0, span]], muted: true }, { points: [...pts, pts[0]].map((p) => [num(p[0]), num(p[1])]), closed: true }], dots: pts.map((p) => [num(p[0]), num(p[1])]), labels: pts.slice(0, 10).map((p) => ({ x: num(p[0]), y: num(p[1]) + span * 0.05, text: `(${t(p[0])}, ${t(p[1])})` })) } } });
    },
};

export default defineTools(handlers);
