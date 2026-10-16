import { fitTwoParameter, linearFit, readPairs } from '../chemistry/fit.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Biochemistry: calibration curves, enzyme activity, isoelectric points and Michaelis–Menten kinetics.
 */
const AMINO = /^[ACDEFGHIKLMNPQRSTVWY]+$/;

/**
 * Net charge of a peptide at a pH for a pKa set (config.data.pka_sets entry).
 */
export function netCharge(sequence, ph, set) {
    const nterm = set.nterm_by_residue?.[sequence[0]] ?? set.nterm;
    const cterm = set.cterm_by_residue?.[sequence[sequence.length - 1]] ?? set.cterm;
    const positive = (pk) => 1 / (1 + 10 ** (ph - pk));
    const negative = (pk) => 1 / (1 + 10 ** (pk - ph));
    let charge = positive(nterm) - negative(cterm);

    for (const residue of sequence) {
        if (set.positive[residue] !== undefined) {
            charge += positive(set.positive[residue]);
        } else if (set.negative[residue] !== undefined) {
            charge -= negative(set.negative[residue]);
        }
    }

    return charge;
}

/**
 * Isoelectric point by bisection on the net charge (it falls monotonically with pH).
 */
export function isoelectricPoint(sequence, set) {
    let low = 0;
    let high = 14;

    for (let step = 0; step < 100; step += 1) {
        const middle = (low + high) / 2;

        if (netCharge(sequence, middle, set) > 0) {
            low = middle;
        } else {
            high = middle;
        }
    }

    return (low + high) / 2;
}

export const handlers = {
    calibration: (i, c, f) => {
        const read = readPairs(i.standards);

        if (read.error) {
            return read;
        }

        if (read.pairs.length < 3) {
            return { empty: 'Enter at least three standards: concentration and signal.' };
        }

        if (new Set(read.pairs.map(([x]) => x)).size < 2) {
            return { error: 'The standards need at least two different concentrations.' };
        }

        const fit = linearFit(read.pairs);
        const lod = (3.3 * fit.sy) / Math.abs(fit.slope);
        const loq = (10 * fit.sy) / Math.abs(fit.slope);
        const unknowns = String(i.unknowns ?? '').split(/[\s,;]+/).filter(Boolean).map(Number).filter((value) => !Number.isNaN(value));
        const xs = read.pairs.map(([x]) => x);
        const [minX, maxX] = [Math.min(...xs), Math.max(...xs)];
        const results = unknowns.map((signal) => {
            const x = (signal - fit.intercept) / fit.slope;

            return { label: `Signal ${f(signal)}`, value: `${f(x)}${x < minX || x > maxX ? ' (outside the standards: extrapolated)' : x < loq ? ' (below the LOQ)' : ''}` };
        });

        return {
            value: `y = ${f(fit.slope)}x ${fit.intercept >= 0 ? '+' : '−'} ${f(Math.abs(fit.intercept))}`,
            unit: '',
            label: 'Calibration line',
            sub: `R² = ${f(Math.round(fit.r2 * 1e6) / 1e6)} from ${fit.n} standards (least squares)`,
            rows: { slope: `${f(fit.slope)} ± ${f(fit.slopeError)}`, intercept: `${f(fit.intercept)} ± ${f(fit.interceptError)}`, lod: f(lod), loq: f(loq), sy: f(fit.sy) },
            lists: { unknowns: results.length ? results : [{ label: 'Unknowns', value: 'Enter signals to convert' }] },
            plots: { curve: { series: [[minX, fit.slope * minX + fit.intercept], [maxX, fit.slope * maxX + fit.intercept]], markers: read.pairs.map(([x, y]) => ({ x, y })), xLabel: 'Concentration', yLabel: 'Signal' } },
        };
    },

    enzyme_activity: (i, c, f) => {
        if (missing(i, 'rate', 'epsilon', 'path', 'total_volume', 'enzyme_volume') || !(i.epsilon > 0) || !(i.path > 0) || !(i.enzyme_volume > 0)) {
            return { empty: 'Enter ΔA/min, ε, path length and both volumes.' };
        }

        // µmol/min in the cuvette = (ΔA/min ÷ (ε l)) mol/L × total volume (mL) × 1000.
        const micromolesPerMinute = (i.rate / (i.epsilon * i.path)) * i.total_volume * 1000;
        const perMilliliter = (micromolesPerMinute / i.enzyme_volume) * (i.dilution > 0 ? i.dilution : 1);
        const specific = i.protein > 0 ? perMilliliter / i.protein : null;

        return {
            value: f(perMilliliter),
            unit: 'U/mL',
            label: 'Enzyme activity',
            sub: '1 U = 1 µmol of substrate converted per minute',
            rows: { specific: specific === null ? 'Enter the protein concentration' : `${f(specific)} U/mg`, katal: `${f(perMilliliter / 60 / 1e6)} kat/mL (${f((perMilliliter / 60) * 1000)} nkat/mL)`, cuvette: `${f(micromolesPerMinute)} µmol/min in the cuvette` },
        };
    },

    isoelectric: (i, c, f) => {
        const sequence = String(i.sequence ?? '').toUpperCase().replace(/^>.*$/m, '').replace(/[\s\d*]/g, '');

        if (!sequence) {
            return { empty: 'Paste a protein sequence in one-letter codes.' };
        }

        if (!AMINO.test(sequence)) {
            return { error: 'Use the 20 standard one-letter amino-acid codes only.' };
        }

        const set = c.data.pka_sets[i.pka_set];
        const pi = isoelectricPoint(sequence, set);
        const other = Object.entries(c.data.pka_sets).find(([key]) => key !== i.pka_set);
        const otherPi = isoelectricPoint(sequence, other[1]);

        return {
            value: f(Math.round(pi * 100) / 100),
            unit: 'pI',
            label: 'Isoelectric point',
            sub: `${set.name} pKa set; published sets differ, so compare with ${other[1].name}: ${f(Math.round(otherPi * 100) / 100)}`,
            rows: { charge7: f(Math.round(netCharge(sequence, 7, set) * 100) / 100), length: `${sequence.length} residues`, other: `${f(Math.round(otherPi * 100) / 100)} (${other[1].name})` },
            lists: { charges: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12].map((ph) => ({ label: `pH ${ph}`, value: f(Math.round(netCharge(sequence, ph, set) * 100) / 100), highlight: Math.abs(ph - pi) < 0.5 })) },
        };
    },

    michaelis_menten: (i, c, f) => {
        if (i.mode === 'fit') {
            const read = readPairs(i.data);

            if (read.error) {
                return read;
            }

            if (read.pairs.length < 3) {
                return { empty: 'Enter at least three points: substrate concentration and rate.' };
            }

            if (read.pairs.some(([s, v]) => s <= 0 || v < 0)) {
                return { error: 'Concentrations must be above 0 and rates not negative.' };
            }

            const vMaxGuess = Math.max(...read.pairs.map(([, v]) => v));
            const half = read.pairs.reduce((best, pair) => (Math.abs(pair[1] - vMaxGuess / 2) < Math.abs(best[1] - vMaxGuess / 2) ? pair : best));
            const fit = fitTwoParameter((s, vmax, km) => (vmax * s) / (km + s), read.pairs, [vMaxGuess * 1.1, half[0]]);
            const kcat = i.enzyme > 0 ? fit.p / i.enzyme : null;
            const maxS = Math.max(...read.pairs.map(([s]) => s));

            return {
                value: `Vmax ${f(fit.p)} · Km ${f(fit.q)}`,
                unit: '',
                label: 'Michaelis–Menten fit',
                sub: `Non-linear least squares; R² = ${f(Math.round(fit.r2 * 1e6) / 1e6)}`,
                rows: { vmax: f(fit.p), km: f(fit.q), kcat: kcat === null ? 'Enter the enzyme concentration' : `${f(kcat)} per unit time`, efficiency: kcat === null ? 'Needs kcat' : f(kcat / fit.q) },
                lists: { lineweaver: read.pairs.map(([s, v]) => ({ label: `1/[S] = ${f(1 / s)}`, value: `1/v = ${f(1 / v)}` })) },
                plots: { curve: { series: Array.from({ length: 81 }, (_, k) => { const s = (maxS * 1.2 * k) / 80; return [s, (fit.p * s) / (fit.q + s)]; }), markers: read.pairs.map(([x, y]) => ({ x, y })), xLabel: '[S]', yLabel: 'Rate v' } },
            };
        }

        if (missing(i, 'vmax', 'km', 'substrate') || !(i.vmax > 0) || !(i.km > 0) || i.substrate < 0) {
            return { empty: 'Enter Vmax, Km and the substrate concentration.' };
        }

        const rate = (i.vmax * i.substrate) / (i.km + i.substrate);
        const kcat = i.enzyme > 0 ? i.vmax / i.enzyme : null;

        return {
            value: f(rate),
            unit: '',
            label: 'Reaction rate v',
            sub: `${f((rate / i.vmax) * 100)}% of Vmax; v = Vmax[S] ÷ (Km + [S])`,
            rows: { vmax: f(i.vmax), km: f(i.km), kcat: kcat === null ? 'Enter the enzyme concentration' : `${f(kcat)} per unit time`, efficiency: kcat === null ? 'Needs kcat' : f(kcat / i.km) },
            lists: { lineweaver: [0.25, 0.5, 1, 2, 4, 10].map((multiple) => ({ label: `[S] = ${f(multiple)} × Km`, value: `v = ${f((i.vmax * multiple) / (1 + multiple))}` })) },
            plots: { curve: { series: Array.from({ length: 81 }, (_, k) => { const s = (Math.max(i.substrate, i.km) * 5 * k) / 80; return [s, (i.vmax * s) / (i.km + s)]; }), markers: [{ x: i.substrate, y: rate, label: 'Your [S]' }], xLabel: '[S]', yLabel: 'Rate v' } },
        };
    },
};

export default defineTools(handlers);
