import { defineTools, missing } from '../engines/formula.js';

/**
 * Genetics calculators: Mendelian crosses, population genetics and statistics.
 */

/**
 * Parses a genotype such as "AaBb" into loci [["A","a"],["B","b"]]. Each locus is two letters of
 * the same gene; returns null when invalid.
 */
export function parseGenotype(text) {
    const letters = String(text ?? '').replace(/\s/g, '');

    if (letters.length === 0 || letters.length % 2 !== 0 || !/^[A-Za-z]+$/.test(letters)) {
        return null;
    }

    const loci = [];

    for (let index = 0; index < letters.length; index += 2) {
        const pair = [letters[index], letters[index + 1]];

        if (pair[0].toLowerCase() !== pair[1].toLowerCase()) {
            return null;
        }

        loci.push(pair.sort((a, b) => (a === a.toUpperCase() ? -1 : 1) - (b === b.toUpperCase() ? -1 : 1)));
    }

    return loci;
}

export function gametes(loci) {
    return loci.reduce((combinations, [first, second]) => combinations.flatMap((prefix) => [prefix + first, prefix + second]), ['']);
}

/**
 * Combines two gametes into a genotype, dominant allele first at each locus.
 */
export function combine(gameteA, gameteB) {
    return [...gameteA].map((allele, index) => [allele, gameteB[index]].sort((a, b) => (a === a.toUpperCase() ? -1 : 1) - (b === b.toUpperCase() ? -1 : 1)).join('')).join('');
}

export function phenotype(genotype) {
    return genotype.match(/../g).map((pair) => (pair[0] === pair[0].toUpperCase() ? pair[0].toUpperCase() : pair[0].toLowerCase())).join('');
}

function ratioText(counts) {
    return Object.entries(counts).sort((a, b) => b[1] - a[1]);
}

/**
 * Full cross: gametes of each parent, the grid and genotype and phenotype counts.
 */
export function cross(parentA, parentB) {
    const gametesA = [...new Set(gametes(parentA))];
    const gametesB = [...new Set(gametes(parentB))];
    const allA = gametes(parentA);
    const allB = gametes(parentB);
    const genotypes = {};
    const phenotypes = {};

    allA.forEach((ga) => allB.forEach((gb) => {
        const genotype = combine(ga, gb);
        genotypes[genotype] = (genotypes[genotype] ?? 0) + 1;
        phenotypes[phenotype(genotype)] = (phenotypes[phenotype(genotype)] ?? 0) + 1;
    }));

    return {
        grid: { columns: gametesB, rows: gametesA.map((ga) => ({ header: ga, cells: gametesB.map((gb) => combine(ga, gb)) })) },
        genotypes,
        phenotypes,
        total: allA.length * allB.length,
    };
}

/**
 * Regularised upper incomplete gamma Q(a, x), for chi-square p-values (Numerical Recipes).
 */
function lnGamma(z) {
    const coefficients = [76.18009172947146, -86.50532032941677, 24.01409824083091, -1.231739572450155, 0.1208650973866179e-2, -0.5395239384953e-5];
    let y = z;
    const x = z;
    let tmp = x + 5.5;
    tmp -= (x + 0.5) * Math.log(tmp);
    let series = 1.000000000190015;
    coefficients.forEach((coefficient) => {
        y += 1;
        series += coefficient / y;
    });

    return -tmp + Math.log((2.5066282746310005 * series) / x);
}

function gammaQ(a, x) {
    if (x <= 0) {
        return 1;
    }

    if (x < a + 1) {
        let sum = 1 / a;
        let term = sum;

        for (let n = 1; n < 500; n += 1) {
            term *= x / (a + n);
            sum += term;

            if (Math.abs(term) < Math.abs(sum) * 1e-15) {
                break;
            }
        }

        return 1 - sum * Math.exp(-x + a * Math.log(x) - lnGamma(a));
    }

    let b = x + 1 - a;
    let c = 1 / 1e-300;
    let d = 1 / b;
    let h = d;

    for (let n = 1; n < 500; n += 1) {
        const an = -n * (n - a);
        b += 2;
        d = an * d + b;
        d = Math.abs(d) < 1e-300 ? 1e-300 : d;
        c = b + an / c;
        c = Math.abs(c) < 1e-300 ? 1e-300 : c;
        d = 1 / d;
        const delta = d * c;
        h *= delta;

        if (Math.abs(delta - 1) < 1e-15) {
            break;
        }
    }

    return Math.exp(-x + a * Math.log(x) - lnGamma(a)) * h;
}

export function chiSquarePValue(chiSquare, degrees) {
    return gammaQ(degrees / 2, chiSquare / 2);
}

export function chiSquare(observed, expected) {
    return observed.reduce((total, value, index) => total + (value - expected[index]) ** 2 / expected[index], 0);
}

const numberList = (text) => String(text ?? '').split(/[\s,;:]+/).filter(Boolean).map(Number);

const BLOOD = { A: ['AA', 'AO'], B: ['BB', 'BO'], AB: ['AB'], O: ['OO'] };
const RH = { '+': ['++', '+-'], '-': ['--'] };

function childPhenotype(alleles) {
    const set = new Set(alleles);

    if (set.has('A') && set.has('B')) {
        return 'AB';
    }

    return set.has('A') ? 'A' : set.has('B') ? 'B' : 'O';
}

/**
 * Child ABO and Rh types that are possible from two parents' blood types.
 */
export function possibleBloodTypes(motherAbo, motherRh, fatherAbo, fatherRh) {
    const abo = new Set();
    BLOOD[motherAbo].forEach((m) => BLOOD[fatherAbo].forEach((p) => [...m].forEach((a) => [...p].forEach((b) => abo.add(childPhenotype([a, b]))))));
    const rh = new Set();
    RH[motherRh].forEach((m) => RH[fatherRh].forEach((p) => [...m].forEach((a) => [...p].forEach((b) => rh.add(a === '+' || b === '+' ? '+' : '-')))));

    return { abo: ['A', 'B', 'AB', 'O'].filter((type) => abo.has(type)), rh: ['+', '-'].filter((type) => rh.has(type)) };
}

function crossOutcome(i, f, loci) {
    const parentA = parseGenotype(i.parent_a);
    const parentB = parseGenotype(i.parent_b);

    if (!String(i.parent_a ?? '').trim() || !String(i.parent_b ?? '').trim()) {
        return { empty: 'Enter both parents\' genotypes.' };
    }

    if (!parentA || !parentB || parentA.length !== loci || parentB.length !== loci) {
        return { error: `Enter ${loci} gene${loci === 1 ? '' : 's'} per parent as letter pairs, e.g. ${['Aa', 'AaBb', 'AaBbCc'][loci - 1]}.` };
    }

    if (parentA.some((pair, index) => pair[0].toLowerCase() !== parentB[index][0].toLowerCase())) {
        return { error: 'Both parents must use the same genes in the same order.' };
    }

    const result = cross(parentA, parentB);
    const phenotypes = ratioText(result.phenotypes);
    const genotypes = ratioText(result.genotypes);

    return {
        value: phenotypes.map(([, count]) => count).join(' : '),
        unit: '',
        label: 'Phenotype ratio',
        sub: phenotypes.map(([type, count]) => `${type} ${f((count / result.total) * 100)}%`).join(' · '),
        grids: { grid: result.grid },
        lists: {
            genotypes: genotypes.map(([type, count]) => ({ label: type, value: `${count}/${result.total} (${f((count / result.total) * 100)}%)` })),
            phenotypes: phenotypes.map(([type, count]) => ({ label: type, value: `${count}/${result.total} (${f((count / result.total) * 100)}%)` })),
        },
    };
}

export const handlers = {
    monohybrid: (i, c, f) => crossOutcome(i, f, 1),
    dihybrid: (i, c, f) => crossOutcome(i, f, 2),
    trihybrid: (i, c, f) => crossOutcome(i, f, 3),

    allele_frequency: (i, c, f) => {
        if (missing(i, 'aa_dom', 'het', 'aa_rec')) {
            return { empty: 'Enter the number of each genotype.' };
        }

        const n = i.aa_dom + i.het + i.aa_rec;

        if ([i.aa_dom, i.het, i.aa_rec].some((value) => value < 0) || n <= 0) {
            return { error: 'Counts cannot be negative and must add up to more than 0.' };
        }

        const p = (2 * i.aa_dom + i.het) / (2 * n);
        const q = 1 - p;
        const expected = [p * p * n, 2 * p * q * n, q * q * n];
        const chi = chiSquare([i.aa_dom, i.het, i.aa_rec], expected);
        const pValue = chiSquarePValue(chi, 1);

        return {
            value: `p = ${f(p)} · q = ${f(q)}`,
            unit: '',
            label: 'Allele frequencies',
            sub: `${f(n)} individuals, ${f(2 * n)} alleles`,
            rows: { expected_dom: f(expected[0]), expected_het: f(expected[1]), expected_rec: f(expected[2]), het_obs: f(i.het / n), hwe: `χ² = ${f(chi)}, p = ${f(pValue)} ${pValue < 0.05 ? '(not in equilibrium)' : '(consistent with equilibrium)'}` },
        };
    },

    hardy_weinberg: (i, c, f) => {
        let p;

        if (i.mode === 'p') {
            p = i.p;
        } else if (i.mode === 'q') {
            p = 1 - i.q;
        } else {
            p = 1 - Math.sqrt(i.recessive / 100);
        }

        if (Number.isNaN(p)) {
            return { empty: 'Enter a frequency.' };
        }

        if (p < 0 || p > 1) {
            return { error: 'Frequencies must be between 0 and 1 (or 0 to 100%).' };
        }

        const q = 1 - p;
        const n = i.population > 0 ? i.population : null;
        const count = (share) => (n ? ` · ${f(Math.round(share * n))} of ${f(n)}` : '');

        return {
            value: `${f(p * p)} : ${f(2 * p * q)} : ${f(q * q)}`,
            unit: '',
            label: 'p² : 2pq : q²',
            sub: `p = ${f(p)}, q = ${f(q)}`,
            rows: { dom: `${f(p * p * 100)}%${count(p * p)}`, het: `${f(2 * p * q * 100)}%${count(2 * p * q)}`, rec: `${f(q * q * 100)}%${count(q * q)}`, carriers: `1 in ${f(1 / (2 * p * q))}` },
        };
    },

    chi_square: (i, c, f) => {
        const observed = numberList(i.observed);
        const ratio = numberList(i.ratio);

        if (!observed.length || !ratio.length) {
            return { empty: 'Enter observed counts and the expected ratio.' };
        }

        if (observed.length !== ratio.length || observed.length < 2) {
            return { error: 'Enter the same number of observed classes and ratio parts (at least two).' };
        }

        if ([...observed, ...ratio].some((value) => Number.isNaN(value) || value < 0) || ratio.some((value) => value === 0)) {
            return { error: 'Counts must be numbers of 0 or more and ratio parts greater than 0.' };
        }

        const total = observed.reduce((sum, value) => sum + value, 0);
        const ratioSum = ratio.reduce((sum, value) => sum + value, 0);
        const expected = ratio.map((part) => (part / ratioSum) * total);
        const chi = chiSquare(observed, expected);
        const degrees = observed.length - 1;
        const pValue = chiSquarePValue(chi, degrees);

        return {
            value: f(chi),
            unit: 'χ²',
            label: 'Chi-square',
            sub: `p = ${f(pValue)} with ${degrees} degree${degrees === 1 ? '' : 's'} of freedom: ${pValue < 0.05 ? 'reject the expected ratio at 0.05' : 'the data fit the expected ratio'}`,
            rows: { p: f(pValue), df: String(degrees), total: f(total) },
            lists: { classes: observed.map((value, index) => ({ label: `Class ${index + 1}`, value: `observed ${f(value)} · expected ${f(expected[index])}` })) },
        };
    },

    recombination: (i, c, f) => {
        if (missing(i, 'recombinants', 'total')) {
            return { empty: 'Enter recombinant and total offspring.' };
        }

        if (i.total <= 0 || i.recombinants < 0 || i.recombinants > i.total) {
            return { error: 'Recombinants must be between 0 and the total.' };
        }

        const frequency = i.recombinants / i.total;

        return {
            value: f(frequency * 100),
            unit: '%',
            label: 'Recombination frequency',
            sub: frequency >= 0.5 ? 'Close to 50%: the genes behave as unlinked' : `About ${f(frequency * 100)} cM apart`,
            rows: { cm: `${f(frequency * 100)} cM`, parental: f(i.total - i.recombinants) },
        };
    },

    mutation_frequency: (i, c, f) => {
        if (missing(i, 'mutants', 'cells')) {
            return { empty: 'Enter mutant colonies and total viable cells.' };
        }

        if (i.cells <= 0 || i.mutants < 0) {
            return { error: 'Viable cells must be greater than 0.' };
        }

        const frequency = i.mutants / i.cells;

        return { value: f(frequency), unit: '', label: 'Mutation frequency', sub: `${f(i.mutants)} mutants in ${f(i.cells)} cells`, rows: { per_million: `${f(frequency * 1e6)} per 10⁶ cells`, one_in: frequency > 0 ? `1 in ${f(1 / frequency)}` : '—' } };
    },

    mutation_rate: (i, c, f) => {
        if (missing(i, 'cultures', 'without', 'cells')) {
            return { empty: 'Enter cultures tested, cultures without mutants and cells per culture.' };
        }

        if (i.cultures <= 0 || i.cells <= 0 || i.without <= 0 || i.without > i.cultures) {
            return { error: 'Cultures without mutants must be between 1 and the total.' };
        }

        const p0 = i.without / i.cultures;
        const m = -Math.log(p0);

        return { value: f(m / i.cells), unit: 'per cell division', label: 'Mutation rate (p₀ method)', sub: `p₀ = ${f(p0)}, m = −ln p₀ = ${f(m)} mutations per culture`, rows: { m: f(m), p0: f(p0) } };
    },

    qpcr: (i, c, f) => {
        if (missing(i, 'slope')) {
            return { empty: 'Enter the standard-curve slope.' };
        }

        if (i.slope >= 0) {
            return { error: 'A standard curve slope is negative (about −3.32 for 100% efficiency).' };
        }

        const amplification = 10 ** (-1 / i.slope);
        const efficiency = (amplification - 1) * 100;

        return {
            value: f(efficiency),
            unit: '%',
            label: 'Amplification efficiency',
            sub: efficiency >= 90 && efficiency <= 110 ? 'Within the accepted 90 to 110% range' : 'Outside 90 to 110%: check dilutions, inhibitors and primer design',
            rows: { factor: `${f(amplification)}× per cycle`, ideal: '−3.32 gives 100%' },
        };
    },

    blood_type: (i, c, f) => {
        const result = possibleBloodTypes(i.mother_abo, i.mother_rh, i.father_abo, i.father_rh);
        const sign = (rh) => (rh === '-' ? '−' : '+');
        const types = result.abo.flatMap((abo) => result.rh.map((rh) => `${abo}${sign(rh)}`));
        const all = ['A', 'B', 'AB', 'O'].flatMap((abo) => ['+', '-'].map((rh) => `${abo}${sign(rh)}`));

        return {
            value: types.join(', '),
            unit: '',
            label: 'Possible blood types for a child',
            sub: `From ${i.mother_abo}${sign(i.mother_rh)} and ${i.father_abo}${sign(i.father_rh)}; which one depends on the parents' hidden genes`,
            lists: { types: all.map((type) => ({ label: type, value: types.includes(type) ? 'Possible' : 'Not possible', highlight: types.includes(type) })) },
        };
    },
};

export default defineTools(handlers);
