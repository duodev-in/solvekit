import { FormulaError, molarMass, parseFormula } from '../chemistry/formula.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Laboratory calculators: solutions, dilutions, cell counts, absorbance, buffers and growth.
 * Volumes arrive in liters when a field has a unit menu (see formula.js).
 */
export const MOLAR = { M: 1, mM: 1e-3, uM: 1e-6, nM: 1e-9 };
const MOLAR_LABEL = { M: 'M', mM: 'mM', uM: 'µM', nM: 'nM' };

export function rcfFromRpm(rpm, radiusCm) {
    return 1.118e-5 * radiusCm * rpm ** 2;
}

export function rpmFromRcf(rcf, radiusCm) {
    return Math.sqrt(rcf / (1.118e-5 * radiusCm));
}

export function doublingTime(hours, startCount, endCount) {
    return (hours * Math.LN2) / Math.log(endCount / startCount);
}

export function henderson(pKa, base, acid) {
    return pKa + Math.log10(base / acid);
}

const positive = (...values) => values.every((value) => value > 0);

/**
 * Formats a molar concentration in the most readable unit.
 */
export function molarText(molar, f) {
    const unit = molar >= 1 ? 'M' : molar >= 1e-3 ? 'mM' : molar >= 1e-6 ? 'uM' : 'nM';

    return `${f(molar / MOLAR[unit])} ${MOLAR_LABEL[unit]}`;
}

export const handlers = {
    molarity: (input, c, f) => {
        const i = { ...input };

        // A formula, when given, sets the molar mass (NaCl instead of 58.44).
        if (String(i.formula ?? '').trim() && c.data?.elements) {
            try {
                i.weight = molarMass(parseFormula(i.formula, c.data.elements), c.data.elements).total;
            } catch (error) {
                if (error instanceof FormulaError) {
                    return { error: error.message };
                }

                throw error;
            }
        }

        const molar = i.concentration * MOLAR[i.conc_unit];

        if (i.mode === 'mass') {
            if (missing(i, 'concentration', 'volume', 'weight')) {
                return { empty: 'Enter concentration, volume and molar mass.' };
            }

            if (!positive(i.concentration, i.volume, i.weight)) {
                return { error: 'Values must be greater than 0.' };
            }

            const grams = molar * i.volume * i.weight;

            return { value: f(grams), unit: 'g', label: 'Mass to weigh', sub: `${f(i.concentration)} ${MOLAR_LABEL[i.conc_unit]} in ${f(i.volume * 1000)} mL`, rows: { mg: `${f(grams * 1000)} mg`, moles: `${f(molar * i.volume * 1000)} mmol` } };
        }

        if (i.mode === 'concentration') {
            if (missing(i, 'mass', 'volume', 'weight')) {
                return { empty: 'Enter mass, volume and molar mass.' };
            }

            if (!positive(i.mass, i.volume, i.weight)) {
                return { error: 'Values must be greater than 0.' };
            }

            const result = i.mass / i.weight / i.volume;

            return { value: molarText(result, f), label: 'Concentration', sub: `${f(i.mass)} g in ${f(i.volume * 1000)} mL`, rows: { mg: `${f(result * i.weight)} g/L`, moles: `${f((i.mass / i.weight) * 1000)} mmol` } };
        }

        if (missing(i, 'mass', 'concentration', 'weight')) {
            return { empty: 'Enter mass, concentration and molar mass.' };
        }

        if (!positive(i.mass, i.concentration, i.weight)) {
            return { error: 'Values must be greater than 0.' };
        }

        const liters = i.mass / i.weight / molar;

        return { value: f(liters * 1000), unit: 'mL', label: 'Volume to make up to', sub: `${f(i.mass)} g at ${f(i.concentration)} ${MOLAR_LABEL[i.conc_unit]}`, rows: { mg: `${f(liters)} L`, moles: `${f((i.mass / i.weight) * 1000)} mmol` } };
    },

    dilution: (i, c, f) => {
        const known = { c1: i.c1, v1: i.v1, c2: i.c2, v2: i.v2 };
        const target = i.solve;
        const others = Object.keys(known).filter((key) => key !== target);

        if (others.some((key) => Number.isNaN(known[key]))) {
            return { empty: 'Enter the three known values.' };
        }

        if (others.some((key) => known[key] <= 0)) {
            return { error: 'Values must be greater than 0.' };
        }

        const values = { ...known };
        values[target] = { c1: (i.c2 * i.v2) / i.v1, v1: (i.c2 * i.v2) / i.c1, c2: (i.c1 * i.v1) / i.v2, v2: (i.c1 * i.v1) / i.c2 }[target];

        if (values.c2 > values.c1) {
            return { error: 'The final concentration cannot be higher than the stock (C₂ > C₁).' };
        }

        const names = { c1: 'Stock concentration C₁', v1: 'Stock volume V₁', c2: 'Final concentration C₂', v2: 'Final volume V₂' };

        return {
            value: f(values[target]),
            unit: (target.startsWith('c') ? c.data?.concentration : c.data?.volume) ?? '',
            label: names[target],
            sub: c.data ? `Take ${f(values.v1)} ${c.data.volume} of stock and make up to ${f(values.v2)} ${c.data.volume}` : 'In the same units you entered for the other concentration or volume',
            rows: { diluent: `${f(values.v2 - values.v1)}${c.data ? ` ${c.data.volume}` : ''}`, factor: `1 : ${f(values.c1 / values.c2)}` },
        };
    },

    serial_dilution: (i, c, f) => {
        if (missing(i, 'stock', 'factor', 'steps', 'final_volume')) {
            return { empty: 'Enter stock, dilution factor, number of tubes and volume per tube.' };
        }

        if (!positive(i.stock, i.final_volume) || i.factor <= 1 || i.steps < 1 || i.steps > 20) {
            return { error: 'Stock and volume must be greater than 0, the factor above 1 and 1 to 20 tubes.' };
        }

        const transfer = i.final_volume / i.factor;
        const tubes = Array.from({ length: Math.round(i.steps) }, (_, index) => ({ label: `Tube ${index + 1}`, value: `${f(i.stock / i.factor ** (index + 1))} · move ${f(transfer)} into ${f(i.final_volume - transfer)} diluent` }));

        return {
            value: f(i.stock / i.factor ** Math.round(i.steps)),
            unit: '',
            label: `Concentration in tube ${Math.round(i.steps)}`,
            sub: `1:${f(i.factor)} each step, total dilution 1:${f(i.factor ** Math.round(i.steps))}`,
            rows: { transfer: f(transfer), diluent: f(i.final_volume - transfer) },
            lists: { tubes },
        };
    },

    centrifuge: (i, c, f) => {
        if (missing(i, 'speed', 'radius')) {
            return { empty: 'Enter the speed and the rotor radius.' };
        }

        if (!positive(i.speed, i.radius)) {
            return { error: 'Speed and radius must be greater than 0.' };
        }

        const toRcf = i.mode === 'rpm';
        const result = toRcf ? rcfFromRpm(i.speed, i.radius) : rpmFromRcf(i.speed, i.radius);

        return {
            value: f(Math.round(result)),
            unit: toRcf ? '× g' : 'rpm',
            label: toRcf ? 'Relative centrifugal force' : 'Rotor speed',
            sub: `Rotor radius ${f(i.radius)} cm`,
            lists: { 'quick-ref': [1000, 3000, 5000, 10000, 13000, 15000].map((rpm) => ({ label: `${f(rpm)} rpm`, value: `${f(Math.round(rcfFromRpm(rpm, i.radius)))} × g` })) },
        };
    },

    hemocytometer: (i, c, f) => {
        if (missing(i, 'count', 'squares', 'dilution')) {
            return { empty: 'Enter cells counted, squares counted and the dilution factor.' };
        }

        if (!positive(i.squares, i.dilution) || i.count < 0) {
            return { error: 'Squares and dilution must be greater than 0.' };
        }

        const perMl = (i.count / i.squares) * i.dilution * 1e4;
        const dead = Number.isNaN(i.dead) ? 0 : i.dead;
        const viable = i.count > 0 ? (i.count - dead) / i.count : 0;

        return {
            value: f(perMl),
            unit: 'cells/mL',
            label: 'Cell concentration',
            sub: `${f(i.count / i.squares)} cells per large square × ${f(i.dilution)} × 10⁴`,
            rows: { viable: f(perMl * viable), viability: `${f(viable * 100)}%`, total: i.volume > 0 ? f(perMl * i.volume) : 'Enter a sample volume' },
        };
    },

    beer_lambert: (i, c, f) => {
        const solve = i.solve;
        const fields = { absorbance: 'absorbance', epsilon: 'epsilon', concentration: 'concentration', path: 'path' };
        const others = Object.keys(fields).filter((key) => key !== solve);

        if (others.some((key) => Number.isNaN(i[key]))) {
            return { empty: 'Enter the three known values.' };
        }

        const value = {
            absorbance: i.epsilon * i.concentration * i.path,
            epsilon: i.absorbance / (i.concentration * i.path),
            concentration: i.absorbance / (i.epsilon * i.path),
            path: i.absorbance / (i.epsilon * i.concentration),
        }[solve];

        if (!Number.isFinite(value)) {
            return { error: 'Check the values; one of them makes the equation divide by zero.' };
        }

        const absorbance = solve === 'absorbance' ? value : i.absorbance;
        const labels = { absorbance: ['Absorbance', ''], epsilon: ['Molar absorptivity ε', 'M⁻¹cm⁻¹'], concentration: ['Concentration', 'M'], path: ['Path length', 'cm'] };

        return { value: f(value), unit: labels[solve][1], label: labels[solve][0], sub: solve === 'concentration' ? `A = ε × c × l, so c = ${molarText(value, f)}` : 'A = ε × c × l', rows: { transmittance: `${f(10 ** -absorbance * 100)}%` } };
    },

    od600: (i, c, f) => {
        if (missing(i, 'od', 'factor')) {
            return { empty: 'Enter the OD600 reading and cells per OD unit.' };
        }

        if (i.od < 0 || i.factor <= 0) {
            return { error: 'OD cannot be negative and the factor must be greater than 0.' };
        }

        const perMl = i.od * i.factor;

        return {
            value: f(perMl),
            unit: 'cells/mL',
            label: 'Cell concentration',
            sub: i.od > 1 ? 'Above OD 1 readings stop being linear; dilute and re-read' : `OD ${f(i.od)} × ${f(i.factor)}`,
            rows: { total: i.volume > 0 ? f(perMl * i.volume * 1000) : 'Enter a culture volume', per_ul: f(perMl / 1000) },
        };
    },

    buffer: (i, c, f) => {
        const pKa = i.buffer === 'custom' ? i.pka : c.data[i.buffer]?.pka;

        if (Number.isNaN(pKa) || pKa === undefined) {
            return { empty: 'Pick a buffer or enter its pKa.' };
        }

        if (i.mode === 'ph') {
            if (missing(i, 'base', 'acid')) {
                return { empty: 'Enter the base and acid concentrations.' };
            }

            if (!positive(i.base, i.acid)) {
                return { error: 'Both concentrations must be greater than 0.' };
            }

            const ph = henderson(pKa, i.base, i.acid);

            return {
                value: f(ph),
                unit: 'pH',
                label: 'Buffer pH',
                sub: `pKa ${f(pKa)} + log(${f(i.base)} ÷ ${f(i.acid)})`,
                rows: { ratio: f(i.base / i.acid), pka: f(pKa), range: `${f(pKa - 1)} to ${f(pKa + 1)}`, acid: `${f(i.acid)} mM`, base_amount: `${f(i.base)} mM` },
            };
        }

        if (missing(i, 'target', 'total')) {
            return { empty: 'Enter the target pH and total buffer concentration.' };
        }

        const ratio = 10 ** (i.target - pKa);
        const acid = i.total / (1 + ratio);

        return {
            value: f(ratio),
            unit: 'base : acid',
            label: 'Base to acid ratio',
            sub: Math.abs(i.target - pKa) > 1 ? 'More than 1 pH unit from the pKa: buffering will be weak' : `For pH ${f(i.target)} with pKa ${f(pKa)}`,
            rows: { ratio: f(ratio), acid: `${f(acid)} mM`, base_amount: `${f(i.total - acid)} mM`, pka: f(pKa), range: `${f(pKa - 1)} to ${f(pKa + 1)}` },
        };
    },

    resuspension: (i, c, f) => {
        if (missing(i, 'nmol', 'target')) {
            return { empty: 'Enter the oligo amount and the target concentration.' };
        }

        if (!positive(i.nmol, i.target)) {
            return { error: 'Values must be greater than 0.' };
        }

        const microliters = (i.nmol / i.target) * 1000;

        return { value: f(microliters), unit: 'µL', label: 'Buffer to add', sub: `${f(i.nmol)} nmol to ${f(i.target)} µM`, rows: { working: `1 µL of stock + ${f(i.target / 10 - 1)} µL buffer gives 10 µM` } };
    },

    percent_solution: (i, c, f) => {
        if (missing(i, 'percent', 'volume')) {
            return { empty: 'Enter the percent and the final volume.' };
        }

        if (!positive(i.percent, i.volume) || i.percent > 100) {
            return { error: 'Percent must be 0 to 100 and volume greater than 0.' };
        }

        const amount = (i.percent / 100) * i.volume * 1000;
        const isVolume = i.kind === 'vv';

        return {
            value: f(amount),
            unit: isVolume ? 'mL' : 'g',
            label: isVolume ? 'Volume of solute' : 'Mass of solute',
            sub: `${f(i.percent)}% ${isVolume ? 'v/v' : 'w/v'} in ${f(i.volume * 1000)} mL`,
            rows: { solvent: isVolume ? `${f(i.volume * 1000 - amount)} mL` : `Make up to ${f(i.volume * 1000)} mL`, molar: !isVolume && i.weight > 0 ? `${f((amount / i.weight) / i.volume)} M` : 'Enter a molar mass (w/v only)' },
        };
    },

    dna_concentration: (i, c, f) => {
        if (missing(i, 'a260', 'dilution')) {
            return { empty: 'Enter the A260 reading and dilution factor.' };
        }

        if (i.a260 < 0 || i.dilution <= 0) {
            return { error: 'A260 cannot be negative and the dilution must be greater than 0.' };
        }

        const factor = { dsdna: 50, ssdna: 33, rna: 40 }[i.type];
        const concentration = i.a260 * factor * i.dilution;
        const ratio = i.a280 > 0 ? i.a260 / i.a280 : null;

        return {
            value: f(concentration),
            unit: 'µg/mL',
            label: 'Concentration',
            sub: `A260 ${f(i.a260)} × ${factor} µg/mL × dilution ${f(i.dilution)}`,
            rows: {
                ng: `${f(concentration)} ng/µL`,
                yield: i.volume > 0 ? `${f(concentration * i.volume / 1000)} µg in ${f(i.volume)} µL` : 'Enter a volume',
                purity: ratio === null ? 'Enter A280 for the purity ratio' : `${f(ratio)} ${ratio >= 1.8 && ratio <= 2.1 ? '(pure)' : ratio < 1.8 ? '(possible protein contamination)' : '(high; check for RNA)'}`,
            },
        };
    },

    ligation: (i, c, f) => {
        if (missing(i, 'vector_ng', 'vector_bp', 'insert_bp', 'ratio')) {
            return { empty: 'Enter vector amount and size, insert size and molar ratio.' };
        }

        if (!positive(i.vector_ng, i.vector_bp, i.insert_bp, i.ratio)) {
            return { error: 'Values must be greater than 0.' };
        }

        const insert = (ratio) => ratio * i.vector_ng * (i.insert_bp / i.vector_bp);
        const pmol = (ng, bp) => (ng * 1000) / (bp * 650);

        return {
            value: f(insert(i.ratio)),
            unit: 'ng',
            label: 'Insert needed',
            sub: `${f(i.ratio)}:1 insert to vector`,
            rows: { vector_pmol: `${f(pmol(i.vector_ng, i.vector_bp) * 1000)} fmol vector`, insert_pmol: `${f(pmol(insert(i.ratio), i.insert_bp) * 1000)} fmol insert` },
            lists: { 'quick-ref': [1, 3, 5, 7].map((ratio) => ({ label: `${ratio}:1`, value: `${f(insert(ratio))} ng`, highlight: ratio === i.ratio })) },
        };
    },

    protein_concentration: (i, c, f) => {
        if (missing(i, 'a280', 'path')) {
            return { empty: 'Enter the A280 reading and path length.' };
        }

        if (i.a280 < 0 || i.path <= 0) {
            return { error: 'A280 cannot be negative and the path length must be greater than 0.' };
        }

        if (i.mode === 'simple') {
            const mgml = i.a280 / i.path;

            return { value: f(mgml), unit: 'mg/mL', label: 'Approximate concentration', sub: 'Assumes A280 of 1.0 = 1 mg/mL; accurate only within about ±50%', rows: { molar: 'Use the ε mode for molar concentration' } };
        }

        if (!positive(i.epsilon, i.weight)) {
            return { empty: 'Enter the extinction coefficient and molecular weight.' };
        }

        const molar = i.a280 / (i.epsilon * i.path);

        return { value: f(molar * i.weight), unit: 'mg/mL', label: 'Protein concentration', sub: `c = A ÷ (ε × l) = ${molarText(molar, f)}`, rows: { molar: molarText(molar, f) } };
    },

    generation_time: (i, c, f) => {
        if (missing(i, 'start', 'end', 'time')) {
            return { empty: 'Enter the starting count, final count and time.' };
        }

        if (!positive(i.start, i.end, i.time) || i.end <= i.start) {
            return { error: 'Counts must be positive and the final count higher than the start.' };
        }

        const generations = Math.log10(i.end / i.start) / Math.log10(2);
        const minutes = (i.time / generations) * 60;

        return {
            value: f(minutes),
            unit: 'min',
            label: 'Generation time',
            sub: `${f(generations)} generations in ${f(i.time)} h`,
            rows: { generations: f(generations), rate: `${f(generations / i.time)} per hour`, hours: `${f(minutes / 60)} h` },
        };
    },

    doubling_time: (i, c, f) => {
        if (missing(i, 'start', 'end', 'time')) {
            return { empty: 'Enter the starting count, final count and time.' };
        }

        if (!positive(i.start, i.end, i.time) || i.end <= i.start) {
            return { error: 'Counts must be positive and the final count higher than the start.' };
        }

        const td = doublingTime(i.time, i.start, i.end);

        return {
            value: f(td),
            unit: 'h',
            label: 'Doubling time',
            sub: `t × ln 2 ÷ ln(${f(i.end)} ÷ ${f(i.start)})`,
            rows: { rate: `${f(Math.log(i.end / i.start) / i.time)} per hour`, fold: `${f(i.end / i.start)}×`, doublings: f(i.time / td) },
        };
    },

    log_reduction: (i, c, f) => {
        let log;

        if (i.mode === 'counts') {
            if (missing(i, 'start', 'end')) {
                return { empty: 'Enter the counts before and after.' };
            }

            if (!positive(i.start, i.end) || i.end > i.start) {
                return { error: 'Counts must be positive and the final count no higher than the start.' };
            }

            log = Math.log10(i.start / i.end);
        } else if (i.mode === 'percent') {
            if (missing(i, 'percent') || i.percent <= 0 || i.percent >= 100) {
                return { error: 'Enter a percent reduction between 0 and 100 (not 100).' };
            }

            log = -Math.log10(1 - i.percent / 100);
        } else {
            if (missing(i, 'log') || i.log < 0) {
                return { empty: 'Enter a log reduction.' };
            }

            log = i.log;
        }

        return {
            value: f(log),
            unit: 'log',
            label: 'Log reduction',
            sub: `${f((1 - 10 ** -log) * 100)}% reduction`,
            rows: { percent: `${f((1 - 10 ** -log) * 100)}%`, surviving: `1 in ${f(10 ** log)}` },
            lists: { 'quick-ref': [1, 2, 3, 4, 5, 6].map((value) => ({ label: `${value} log`, value: `${f((1 - 10 ** -value) * 100)}%`, highlight: Math.abs(value - log) < 1e-9 })) },
        };
    },
};

export default defineTools(handlers);
