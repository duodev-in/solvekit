import { defineTools } from '../engines/formula.js';

/**
 * DNA, RNA and protein sequence tools.
 */
export const AVOGADRO = 6.02214076e23;

const COMPLEMENT = { A: 'T', T: 'A', G: 'C', C: 'G', U: 'A', N: 'N' };
const RNA_COMPLEMENT = { A: 'U', U: 'A', G: 'C', C: 'G', T: 'A', N: 'N' };

/**
 * Cleans pasted sequences: drops FASTA headers, spaces, digits and line breaks; upper-cases.
 */
export function cleanSequence(text) {
    return String(text ?? '').split('\n').filter((line) => !line.startsWith('>')).join('').toUpperCase().replace(/[\s\d]/g, '');
}

export function validNucleic(sequence, allowU = true) {
    return (allowU ? /^[ACGTUN]+$/ : /^[ACGTN]+$/).test(sequence);
}

export function reverseComplement(sequence) {
    const isRna = sequence.includes('U') && !sequence.includes('T');
    const table = isRna ? RNA_COMPLEMENT : COMPLEMENT;

    return [...sequence].reverse().map((base) => table[base] ?? 'N').join('');
}

export function baseCounts(sequence) {
    return [...sequence].reduce((counts, base) => ({ ...counts, [base]: (counts[base] ?? 0) + 1 }), { A: 0, C: 0, G: 0, T: 0, U: 0, N: 0 });
}

export function gcContent(sequence) {
    const counts = baseCounts(sequence);
    const known = sequence.length - counts.N;

    return known ? (counts.G + counts.C) / known : 0;
}

// SantaLucia (1998) unified nearest-neighbour parameters: ΔH kcal/mol, ΔS cal/(mol·K).
const NN = {
    AA: [-7.9, -22.2], TT: [-7.9, -22.2], AT: [-7.2, -20.4], TA: [-7.2, -21.3],
    CA: [-8.5, -22.7], TG: [-8.5, -22.7], GT: [-8.4, -22.4], AC: [-8.4, -22.4],
    CT: [-7.8, -21.0], AG: [-7.8, -21.0], GA: [-8.2, -22.2], TC: [-8.2, -22.2],
    CG: [-10.6, -27.2], GC: [-9.8, -24.4], GG: [-8.0, -19.9], CC: [-8.0, -19.9],
};

/**
 * Melting temperature (°C) of a DNA oligo duplex by nearest-neighbour thermodynamics with the
 * SantaLucia salt correction. naMolar: monovalent salt (M); strandMolar: primer concentration (M).
 */
export function meltingTemperature(sequence, naMolar = 0.05, strandMolar = 250e-9) {
    let enthalpy = 0;
    let entropy = 0;

    for (let index = 0; index < sequence.length - 1; index += 1) {
        const [h, s] = NN[sequence.slice(index, index + 2)] ?? [0, 0];
        enthalpy += h;
        entropy += s;
    }

    [sequence[0], sequence[sequence.length - 1]].forEach((end) => {
        const isGc = end === 'G' || end === 'C';
        enthalpy += isGc ? 0.1 : 2.3;
        entropy += isGc ? -2.8 : 4.1;
    });

    entropy += 0.368 * (sequence.length - 1) * Math.log(naMolar);

    return (enthalpy * 1000) / (entropy + 1.98720425864083 * Math.log(strandMolar / 4)) - 273.15;
}

/**
 * Tm of a PCR product from its length and GC fraction (salt-adjusted empirical formula).
 */
export function productMeltingTemperature(lengthBp, gcFraction, naMolar = 0.05) {
    return 81.5 + 16.6 * Math.log10(naMolar) + 41 * gcFraction - 675 / lengthBp;
}

const CODONS = {
    UUU: 'F', UUC: 'F', UUA: 'L', UUG: 'L', CUU: 'L', CUC: 'L', CUA: 'L', CUG: 'L', AUU: 'I', AUC: 'I', AUA: 'I', AUG: 'M',
    GUU: 'V', GUC: 'V', GUA: 'V', GUG: 'V', UCU: 'S', UCC: 'S', UCA: 'S', UCG: 'S', CCU: 'P', CCC: 'P', CCA: 'P', CCG: 'P',
    ACU: 'T', ACC: 'T', ACA: 'T', ACG: 'T', GCU: 'A', GCC: 'A', GCA: 'A', GCG: 'A', UAU: 'Y', UAC: 'Y', UAA: '*', UAG: '*',
    CAU: 'H', CAC: 'H', CAA: 'Q', CAG: 'Q', AAU: 'N', AAC: 'N', AAA: 'K', AAG: 'K', GAU: 'D', GAC: 'D', GAA: 'E', GAG: 'E',
    UGU: 'C', UGC: 'C', UGA: '*', UGG: 'W', CGU: 'R', CGC: 'R', CGA: 'R', CGG: 'R', AGU: 'S', AGC: 'S', AGA: 'R', AGG: 'R',
    GGU: 'G', GGC: 'G', GGA: 'G', GGG: 'G',
};

/**
 * Translates RNA or DNA (T read as U) with the standard genetic code; * marks stop codons.
 */
export function translate(sequence, frame = 0) {
    const rna = sequence.replace(/T/g, 'U');
    let protein = '';

    for (let index = frame; index + 3 <= rna.length; index += 3) {
        protein += CODONS[rna.slice(index, index + 3)] ?? 'X';
    }

    return protein;
}

export function codons(sequence) {
    return sequence.match(/.{1,3}/g)?.join(' ') ?? '';
}

// Average residue masses (Da) of amino acids in a peptide chain.
const RESIDUE = {
    A: 71.0788, R: 156.1875, N: 114.1038, D: 115.0886, C: 103.1388, E: 129.1155, Q: 128.1307, G: 57.0519, H: 137.1411, I: 113.1594,
    L: 113.1594, K: 128.1741, M: 131.1926, F: 147.1766, P: 97.1167, S: 87.0782, T: 101.1051, W: 186.2132, Y: 163.1760, V: 99.1326,
};
const WATER = 18.01528;

export function proteinWeight(sequence) {
    return [...sequence].reduce((total, residue) => total + RESIDUE[residue], WATER);
}

/**
 * Extinction coefficient at 280 nm (M⁻¹cm⁻¹), Pace et al. (1995): reduced cysteines and all cystines.
 */
export function proteinExtinction(sequence) {
    const count = (letter) => [...sequence].filter((residue) => residue === letter).length;
    const reduced = count('W') * 5500 + count('Y') * 1490;

    return { reduced, oxidized: reduced + Math.floor(count('C') / 2) * 125 };
}

/**
 * Molecular weight (g/mol) of single-stranded DNA or RNA from its sequence.
 */
export function nucleicWeight(sequence, type) {
    const counts = baseCounts(sequence);

    if (type === 'rna') {
        return counts.A * 329.21 + counts.U * 306.17 + counts.C * 305.18 + counts.G * 345.21 + 159.0;
    }

    const single = counts.A * 313.21 + counts.T * 304.2 + counts.C * 289.18 + counts.G * 329.21 - 61.96;

    if (type === 'dsdna') {
        const complement = baseCounts(reverseComplement(sequence));

        return single + complement.A * 313.21 + complement.T * 304.2 + complement.C * 289.18 + complement.G * 329.21 - 61.96;
    }

    return single;
}

/**
 * Average molecular weight from length alone (g/mol).
 */
export function weightFromLength(length, type) {
    return { dsdna: length * 617.96 + 36.04, ssdna: length * 308.97 + 18.02, rna: length * 320.5 + 159.0 }[type];
}

function readSequence(text, { protein = false, allowU = true } = {}) {
    const sequence = cleanSequence(text);

    if (!sequence) {
        return { empty: 'Paste or type a sequence.' };
    }

    if (protein ? !/^[ACDEFGHIKLMNPQRSTVWY]+$/.test(sequence) : !validNucleic(sequence, allowU)) {
        return { error: protein ? 'Use one-letter amino-acid codes (A, C, D … Y) only.' : 'Use only the bases A, C, G, T (or U) and N.' };
    }

    return { sequence };
}

export const handlers = {
    annealing: (i, c, f) => {
        const forward = readSequence(i.forward, { allowU: false });
        const reverse = readSequence(i.reverse, { allowU: false });

        if (forward.empty || reverse.empty) {
            return { empty: 'Enter both primer sequences.' };
        }

        if (forward.error || reverse.error) {
            return forward.error ? forward : reverse;
        }

        const na = (Number.isNaN(i.sodium) ? 50 : i.sodium) / 1000;
        const strand = (Number.isNaN(i.primer) ? 250 : i.primer) * 1e-9;
        const tmForward = meltingTemperature(forward.sequence, na, strand);
        const tmReverse = meltingTemperature(reverse.sequence, na, strand);
        const lowest = Math.min(tmForward, tmReverse);
        const hasProduct = i.product_length > 0 && i.product_gc > 0;
        const productTm = hasProduct ? productMeltingTemperature(i.product_length, i.product_gc / 100, na) : null;
        const annealing = hasProduct ? 0.3 * lowest + 0.7 * productTm - 14.9 : lowest - 5;

        return {
            value: f(annealing),
            unit: '°C',
            label: 'Annealing temperature',
            sub: hasProduct ? 'Rychlik: 0.3 × Tm(primer) + 0.7 × Tm(product) − 14.9' : 'Lower primer Tm − 5 °C (add the product to use the Rychlik formula)',
            rows: {
                tm_forward: `${f(tmForward)} °C (${forward.sequence.length} nt, ${f(gcContent(forward.sequence) * 100)}% GC)`,
                tm_reverse: `${f(tmReverse)} °C (${reverse.sequence.length} nt, ${f(gcContent(reverse.sequence) * 100)}% GC)`,
                difference: `${f(Math.abs(tmForward - tmReverse))} °C`,
                product: productTm === null ? 'Enter product length and GC%' : `${f(productTm)} °C`,
            },
        };
    },

    protein_weight: (i, c, f) => {
        const read = readSequence(i.sequence, { protein: true });

        if (!read.sequence) {
            return read;
        }

        const weight = proteinWeight(read.sequence);
        const extinction = proteinExtinction(read.sequence);

        return {
            value: f(weight / 1000),
            unit: 'kDa',
            label: 'Molecular weight',
            sub: `${read.sequence.length} amino acids · ${f(weight)} Da`,
            rows: {
                length: `${read.sequence.length} residues`,
                epsilon: `${f(extinction.reduced)} M⁻¹cm⁻¹ (reduced) · ${f(extinction.oxidized)} (cystines)`,
                abs: extinction.reduced ? `${f(extinction.reduced / weight)} for 1 mg/mL` : 'No Trp or Tyr: A280 cannot be used',
            },
        };
    },

    nucleic_weight: (i, c, f) => {
        if (i.mode === 'length') {
            if (!(i.length > 0)) {
                return { empty: 'Enter the length.' };
            }

            const weight = weightFromLength(i.length, i.type);

            return { value: f(weight), unit: 'g/mol', label: 'Molecular weight', sub: `${f(i.length)} ${i.type === 'dsdna' ? 'bp' : 'nt'}, average composition`, rows: { kda: `${f(weight / 1000)} kDa`, per_ug: `${f(1e-6 / weight * 1e12)} pmol per µg` } };
        }

        const read = readSequence(i.sequence, { allowU: i.type === 'rna' });

        if (!read.sequence) {
            return read;
        }

        const sequence = i.type === 'rna' ? read.sequence.replace(/T/g, 'U') : read.sequence.replace(/U/g, 'T');
        const weight = nucleicWeight(sequence, i.type);

        return { value: f(weight), unit: 'g/mol', label: 'Molecular weight', sub: `${sequence.length} ${i.type === 'dsdna' ? 'bp' : 'nt'} from the sequence`, rows: { kda: `${f(weight / 1000)} kDa`, per_ug: `${f(1e6 / weight)} pmol per µg` } };
    },

    reverse_complement: (i, c, f) => {
        const read = readSequence(i.sequence);

        if (!read.sequence) {
            return read;
        }

        const { sequence } = read;
        const complement = [...sequence].map((base) => (sequence.includes('U') ? RNA_COMPLEMENT : COMPLEMENT)[base]).join('');

        return {
            value: reverseComplement(sequence),
            label: 'Reverse complement (5′→3′)',
            sub: `${sequence.length} bases`,
            rows: { complement, reverse: [...sequence].reverse().join(''), length: `${sequence.length}`, gc: `${f(gcContent(sequence) * 100)}%` },
        };
    },

    gc_content: (i, c, f) => {
        const read = readSequence(i.sequence);

        if (!read.sequence) {
            return read;
        }

        const counts = baseCounts(read.sequence);
        const gc = gcContent(read.sequence);
        const length = read.sequence.length;

        return {
            value: f(gc * 100),
            unit: '%',
            label: 'GC content',
            sub: `${counts.G + counts.C} G or C in ${length - counts.N} known bases`,
            rows: { at: `${f((1 - gc) * 100)}%`, a: String(counts.A), t: String(counts.T + counts.U), g: String(counts.G), c: String(counts.C), tm: length >= 8 && length <= 60 && !read.sequence.includes('U') ? `${f(meltingTemperature(read.sequence))} °C (50 mM Na⁺, 250 nM)` : 'For DNA oligos of 8 to 60 nt' },
        };
    },

    transcribe: (i, c, f) => {
        const read = readSequence(i.sequence, { allowU: false });

        if (!read.sequence) {
            return read;
        }

        const coding = i.strand === 'template' ? reverseComplement(read.sequence) : read.sequence;
        const mrna = coding.replace(/T/g, 'U');
        const protein = translate(mrna);

        return {
            value: mrna,
            label: 'mRNA (5′→3′)',
            sub: i.strand === 'template' ? 'Read from the template strand: reverse complement with U for T' : 'Same as the coding strand with U for T',
            rows: { codons: codons(mrna), protein: protein || '—', length: `${mrna.length} nt`, gc: `${f(gcContent(mrna) * 100)}%` },
        };
    },

    translate: (i, c, f) => {
        const read = readSequence(i.sequence);

        if (!read.sequence) {
            return read;
        }

        const forward = read.sequence.replace(/U/g, 'T');
        const reverse = reverseComplement(forward);
        const frame = Number(i.frame);
        const protein = translate(frame < 3 ? forward : reverse, frame % 3);

        return {
            value: protein || '—',
            label: `Protein, frame ${frame < 3 ? '+' : '−'}${(frame % 3) + 1}`,
            sub: `${protein.replace(/\*$/, '').length} amino acids${protein.includes('*') ? ' · * is a stop codon' : ''}`,
            rows: Object.fromEntries([0, 1, 2, 3, 4, 5].map((index) => [`f${index}`, translate(index < 3 ? forward : reverse, index % 3) || '—'])),
        };
    },

    copy_number: (i, c, f) => {
        if (!(i.mass > 0) || !(i.length > 0)) {
            return { empty: 'Enter the DNA mass and length.' };
        }

        const weight = weightFromLength(i.length, i.type);
        const copies = (i.mass * 1e-9 * AVOGADRO) / weight;

        return {
            value: f(copies),
            unit: 'copies',
            label: 'Copy number',
            sub: `${f(i.mass)} ng of ${f(i.length)} ${i.type === 'dsdna' ? 'bp' : 'nt'} (${f(weight)} g/mol)`,
            rows: { per_ul: i.volume > 0 ? `${f(copies / i.volume)} copies per µL` : 'Enter a volume', moles: `${f((i.mass * 1e-9) / weight * 1e15)} fmol`, weight: `${f(weight)} g/mol` },
        };
    },
};

export default defineTools(handlers);
