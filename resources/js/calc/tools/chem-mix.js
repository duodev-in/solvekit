import { bufferCapacity, fractions, logActivityCoefficient, MODEL_LIMIT, solvePh } from '../chemistry/acidbase.js';
import { displayFormula, FormulaError, molarMass, parseFormula } from '../chemistry/formula.js';
import { ionicParts, nameFromFormula, NameError } from '../chemistry/nomenclature.js';
import { pKw } from '../chemistry/water.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Mixtures and solutions: concentrations, dilutions, pH, buffers, titrations, solubility and more.
 * Data sets (config/chemistry_data.php) arrive in config.data; volumes from unit menus arrive in liters.
 */
const PKW = pKw(25);
const WATER_MOLAR_MASS = 2 * 1.008 + 15.999;
const SUB = '₀₁₂₃₄₅₆₇₈₉';
const SUP = '⁰¹²³⁴⁵⁶⁷⁸⁹';

/**
 * Generic species label: speciesLabel(2, 1) → "H₂A⁻", speciesLabel(0, 3) → "A³⁻".
 */
export function speciesLabel(hydrogens, negative) {
    const h = hydrogens === 0 ? '' : `H${hydrogens === 1 ? '' : SUB[hydrogens]}`;
    const charge = negative === 0 ? '' : `${negative === 1 ? '' : SUP[negative]}⁻`;

    return `${h}A${charge}`;
}

const numberList = (text) => String(text ?? '').split(/[\s,;]+/).filter(Boolean).map(Number);

function read(text, elements) {
    if (!String(text ?? '').trim()) {
        return { empty: 'Enter a chemical formula.' };
    }

    try {
        return { parsed: parseFormula(text, elements) };
    } catch (error) {
        if (error instanceof FormulaError) {
            return { error: error.message };
        }

        throw error;
    }
}

const weightOf = (parsed, elements) => molarMass(parsed, elements).total;

/**
 * A component for the acid–base solver from a data entry or a custom definition.
 */
export function componentFor(choice, concentration, data, custom = {}) {
    if (choice === 'custom') {
        if (custom.kind === 'base') {
            return custom.strong ? { type: 'cation', concentration, charge: 1, protons: 1, label: 'Strong base' } : { type: 'base', concentration, pKaConjugate: PKW - custom.pkb, protons: 1, label: 'Weak base' };
        }

        return custom.strong ? { type: 'acid', concentration, pKa: [], strongSteps: 1, protons: 1, label: 'Strong acid' } : { type: 'acid', concentration, pKa: custom.pkas, strongSteps: 0, protons: custom.pkas.length, label: 'Weak acid' };
    }

    const [kind, key] = choice.split(':');

    if (kind === 'acid') {
        const acid = data.acids[key];

        return { type: 'acid', concentration, pKa: acid.pka, strongSteps: acid.strong_steps, protons: acid.pka.length + acid.strong_steps, label: acid.name, formula: acid.formula };
    }

    const base = data.bases[key];

    if (base.strong_hydroxides) {
        return { type: 'cation', concentration: concentration * base.strong_hydroxides, charge: 1, protons: base.strong_hydroxides, label: base.name, formula: base.formula, strongBase: true };
    }

    return { type: 'base', concentration, pKaConjugate: PKW - base.pkb, protons: 1, label: base.name, formula: base.formula };
}

function customFrom(i) {
    return { kind: i.kind, strong: i.strength === 'strong', pkas: numberList(i.pkas), pkb: i.pkb };
}

function validateCustom(i) {
    if (i.choice !== 'custom' || i.strength === 'strong') {
        return null;
    }

    if (i.kind === 'base') {
        return Number.isNaN(i.pkb) ? { empty: 'Enter the pKb of the base.' } : null;
    }

    const pkas = numberList(i.pkas);

    return !pkas.length || pkas.some((value) => Number.isNaN(value)) ? { empty: 'Enter the pKa values, separated by commas (e.g. 2.16, 7.21, 12.32).' } : null;
}

/**
 * Cumulative strong base (mol/L) needed to move a buffer between two pH values: ∫ β dpH (Simpson).
 */
function integrateCapacity(from, to, pKa, total) {
    const steps = 200;
    const h = (to - from) / steps;
    let sum = 0;

    for (let k = 0; k <= steps; k += 1) {
        const weight = k === 0 || k === steps ? 1 : k % 2 ? 4 : 2;
        sum += weight * bufferCapacity(from + k * h, pKa, total, PKW);
    }

    return (sum * h) / 3;
}

const HARDNESS_UNITS = {
    mgl: 'mg/L as CaCO₃ (ppm)',
    mmol: 'mmol/L',
    gpg: 'grains per US gallon (gpg)',
    dh: 'German degrees (°dH)',
    fh: 'French degrees (°fH)',
    e: 'English degrees (°e, Clark)',
};

export const handlers = {
    activity: (i, c, f) => {
        if (missing(i, 'charge', 'ionic_strength')) {
            return { empty: 'Enter the ion charge and the ionic strength.' };
        }

        if (i.ionic_strength < 0 || Math.round(i.charge) === 0) {
            return { error: 'Ionic strength cannot be negative and the charge cannot be 0.' };
        }

        const size = i.model === 'extended' ? (i.ion === 'custom' ? i.size : c.data.ion_sizes[i.ion]?.size_pm) / 100 : 0;

        if (i.model === 'extended' && !(size > 0)) {
            return { empty: 'Enter the ion size in pm.' };
        }

        const log = logActivityCoefficient(i.model, Math.round(i.charge), i.ionic_strength, size);
        const gamma = 10 ** log;
        const limit = MODEL_LIMIT[i.model];
        const names = { limiting: 'Debye–Hückel limiting law', extended: 'Extended Debye–Hückel', davies: 'Davies equation' };

        return {
            value: f(Math.round(gamma * 10000) / 10000),
            unit: 'γ',
            label: 'Activity coefficient',
            sub: i.ionic_strength > limit ? `Outside the ${names[i.model]}'s range (I up to about ${limit}); use with care` : `${names[i.model]} at 25 °C`,
            rows: { log: f(Math.round(log * 10000) / 10000), activity: i.concentration > 0 ? `${f(gamma * i.concentration)} mol/L` : 'Enter a concentration', range: `I ≤ ${limit} mol/kg` },
        };
    },

    alligation: (i, c, f) => {
        if (missing(i, 'high', 'low', 'target', 'total')) {
            return { empty: 'Enter both strengths, the target and the total amount.' };
        }

        if (!(i.high > i.target && i.target > i.low)) {
            return { error: 'The target must lie between the two strengths.' };
        }

        const partsHigh = i.target - i.low;
        const partsLow = i.high - i.target;
        const amountHigh = (i.total * partsHigh) / (partsHigh + partsLow);

        return {
            value: `${f(amountHigh)} + ${f(i.total - amountHigh)}`,
            unit: '',
            label: 'Stronger + weaker amount',
            sub: `${f(partsHigh)} parts at ${f(i.high)}% to ${f(partsLow)} parts at ${f(i.low)}%`,
            rows: { high: f(amountHigh), low: f(i.total - amountHigh), ratio: `${f(partsHigh / partsLow)} : 1` },
        };
    },

    bleach: (i, c, f) => {
        if (missing(i, 'percent', 'target', 'volume')) {
            return { empty: 'Enter the bleach strength, target ppm and final volume.' };
        }

        if (!(i.percent > 0) || !(i.target > 0) || !(i.volume > 0) || i.percent > 20) {
            return { error: 'Use the sodium hypochlorite percent from the label (usually 3 to 12%), a target and a volume above 0.' };
        }

        const density = i.density > 0 ? i.density : 1;
        const milligrams = i.target * i.volume;
        const bleachMl = milligrams / (i.percent / 100) / density / 1000;
        const chlorine = 70.906 / 74.442;

        if (bleachMl >= i.volume * 1000) {
            return { error: 'That target is stronger than the bleach itself.' };
        }

        return {
            value: f(bleachMl),
            unit: 'mL',
            label: 'Bleach to add',
            sub: `Make up to ${f(i.volume)} L with water`,
            rows: { water: `${f(i.volume * 1000 - bleachMl)} mL`, ratio: `1 part bleach to ${f(i.volume * 1000 / bleachMl - 1)} parts water`, chlorine: `${f(i.target * chlorine)} ppm available chlorine` },
        };
    },

    buffer_capacity: (i, c, f) => {
        const pKa = i.buffer === 'custom' ? i.pka : c.data.buffers[i.buffer]?.pka;

        if (pKa === undefined || Number.isNaN(pKa)) {
            return { empty: 'Pick a buffer or enter its pKa.' };
        }

        if (missing(i, 'total', 'ph') || !(i.total > 0)) {
            return { empty: 'Enter the total buffer concentration and the pH.' };
        }

        const beta = bufferCapacity(i.ph, pKa, i.total, PKW);
        const up = integrateCapacity(i.ph, i.ph + 0.1, pKa, i.total);
        const down = integrateCapacity(i.ph - 0.1, i.ph, pKa, i.total);

        return {
            value: f(beta),
            unit: 'mol/L per pH',
            label: 'Buffer capacity β',
            sub: Math.abs(i.ph - pKa) > 1 ? 'More than 1 pH unit from the pKa: little buffering' : `pKa ${f(pKa)}; capacity is highest at pH = pKa`,
            rows: { max: `${f(bufferCapacity(pKa, pKa, i.total, PKW))} mol/L per pH at pH ${f(pKa)}`, up: `${f(up * 1000)} mmol/L strong base`, down: `${f(down * 1000)} mmol/L strong acid` },
        };
    },

    concentration: (i, c, f) => {
        const formula = read(i.formula, c.data.elements);

        if (!formula.parsed) {
            return formula;
        }

        if (missing(i, 'value') || i.value < 0) {
            return { empty: 'Enter the concentration.' };
        }

        const weight = weightOf(formula.parsed, c.data.elements);
        const density = i.density > 0 ? i.density : 1;
        const solutionGrams = density * 1000;
        const toMolar = {
            m: (x) => x,
            mm: (x) => x / 1000,
            um: (x) => x / 1e6,
            gl: (x) => x / weight,
            mgl: (x) => x / 1000 / weight,
            ppm: (x) => (x * density) / 1000 / weight,
            wv: (x) => (x * 10) / weight,
            ww: (x) => ((x / 100) * solutionGrams) / weight,
            molal: (x) => (x * solutionGrams) / (1000 + x * weight),
            fraction: (x) => solutionGrams / (weight + (WATER_MOLAR_MASS * (1 - x)) / x),
        };

        if (i.from === 'fraction' && !(i.value > 0 && i.value < 1)) {
            return { error: 'A mole fraction is between 0 and 1.' };
        }

        const molar = toMolar[i.from](i.value);
        const soluteGrams = molar * weight;

        if (soluteGrams >= solutionGrams) {
            return { error: 'That is more solute than a liter of this solution can hold; check the density.' };
        }

        const solventGrams = solutionGrams - soluteGrams;
        const values = [
            ['Molarity', `${f(molar)} mol/L`], ['Millimolar', `${f(molar * 1000)} mM`], ['Micromolar', `${f(molar * 1e6)} µM`],
            ['Mass concentration', `${f(soluteGrams)} g/L`], ['Milligrams per liter', `${f(soluteGrams * 1000)} mg/L`],
            ['Parts per million (by mass)', `${f((soluteGrams * 1000) / density)} ppm`], ['Percent w/v', `${f(soluteGrams / 10)}%`],
            ['Percent w/w', `${f((soluteGrams / solutionGrams) * 100)}%`], ['Molality', `${f(molar / (solventGrams / 1000))} mol/kg`],
            ['Mole fraction (in water)', f(molar / (molar + solventGrams / WATER_MOLAR_MASS))],
        ];

        return {
            value: f(molar),
            unit: 'mol/L',
            label: `Concentration of ${formula.parsed.text}`,
            sub: `${f(weight)} g/mol; solution density ${f(density)} g/mL`,
            lists: { units: values.map(([label, value]) => ({ label, value })) },
        };
    },

    dilution_factor: (i, c, f) => {
        let factor;
        let aliquot = i.aliquot;
        let final = i.final;

        if (i.mode === 'volumes') {
            if (!(aliquot > 0) || !(final > 0)) {
                return { empty: 'Enter the aliquot and final volumes.' };
            }

            if (aliquot > final) {
                return { error: 'The aliquot cannot be larger than the final volume.' };
            }

            factor = final / aliquot;
        } else if (i.mode === 'concentrations') {
            if (!(i.c1 > 0) || !(i.c2 > 0)) {
                return { empty: 'Enter the stock and final concentrations.' };
            }

            if (i.c2 > i.c1) {
                return { error: 'The final concentration cannot be higher than the stock.' };
            }

            factor = i.c1 / i.c2;
            aliquot = final > 0 ? final / factor : NaN;
        } else {
            if (!(i.factor >= 1) || !(final > 0)) {
                return { empty: 'Enter a dilution factor of 1 or more and the final volume.' };
            }

            factor = i.factor;
            aliquot = final / factor;
        }

        return {
            value: f(factor),
            unit: '×',
            label: 'Dilution factor',
            sub: `1:${f(factor)} as "1 part in ${f(factor)} total" (1 part + ${f(factor - 1)} parts diluent)`,
            rows: { aliquot: aliquot > 0 ? `${f(aliquot)} mL` : 'Enter the final volume', diluent: aliquot > 0 ? `${f(final - aliquot)} mL` : '—', log: `${f(Math.log10(factor))} log` },
        };
    },

    mass_percent: (i, c, f) => {
        if (missing(i, 'solute', 'other')) {
            return { empty: 'Enter the solute mass and the solvent or solution mass.' };
        }

        const solution = i.basis === 'solution' ? i.other : i.solute + i.other;

        if (!(i.solute > 0) || !(solution > i.solute)) {
            return { error: 'The solution must weigh more than the solute alone.' };
        }

        const percent = (i.solute / solution) * 100;
        const formula = String(i.formula ?? '').trim() ? read(i.formula, c.data.elements) : null;

        if (formula?.error) {
            return formula;
        }

        const molality = formula?.parsed ? i.solute / weightOf(formula.parsed, c.data.elements) / ((solution - i.solute) / 1000) : null;

        return {
            value: f(percent),
            unit: '% w/w',
            label: 'Mass percent',
            sub: `${f(i.solute)} g in ${f(solution)} g of solution`,
            rows: { ppm: `${f(percent * 1e4)} ppm`, solvent: `${f(solution - i.solute)} g`, molality: molality === null ? 'Add a formula for molality' : `${f(molality)} mol/kg` },
        };
    },

    mixing_ratio: (i, c, f) => {
        const parts = numberList(String(i.ratio ?? '').replace(/:/g, ' '));

        if (parts.length < 2) {
            return { empty: 'Enter a ratio such as 1:4 or 2:1:1.' };
        }

        if (parts.some((value) => Number.isNaN(value) || value <= 0)) {
            return { error: 'Each part must be a number greater than 0.' };
        }

        if (!(i.total > 0)) {
            return { empty: 'Enter the total amount.' };
        }

        const sum = parts.reduce((total, value) => total + value, 0);
        const letters = 'ABCDEFGH';

        return {
            value: parts.map((part) => f((i.total * part) / sum)).join(' + '),
            unit: i.unit_label || '',
            label: `Amounts for ${parts.join(' : ')}`,
            sub: `${f(sum)} parts in total; one part is ${f(i.total / sum)}`,
            lists: { parts: parts.map((part, index) => ({ label: `Part ${letters[index]} (${part})`, value: `${f((i.total * part) / sum)} · ${f((part / sum) * 100)}%` })) },
        };
    },

    neutralization: (i, c, f) => {
        if (missing(i, 'acid_concentration', 'acid_volume', 'base_concentration') || !(i.acid_concentration > 0) || !(i.acid_volume > 0) || !(i.base_concentration > 0)) {
            return { empty: 'Enter the acid concentration and volume, and the base concentration.' };
        }

        const acid = componentFor(i.acid, 0, c.data);
        const base = componentFor(i.base, 0, c.data);
        const protons = acid.protons;
        const hydroxides = base.protons;
        const acidMoles = i.acid_concentration * i.acid_volume;
        const baseVolume = (acidMoles * protons) / (hydroxides * i.base_concentration);
        const total = i.acid_volume + baseVolume;
        const mixture = [componentFor(i.acid, acidMoles / total, c.data), componentFor(i.base, (i.base_concentration * baseVolume) / total, c.data)];
        const ph = solvePh(mixture, PKW);
        let salt = 'Not named for this pair';

        // Name the salt for a hydrogen acid and a metal hydroxide or ammonia.
        try {
            const anionText = (acid.formula ?? '').replace(/^H\d*/, '');
            const cation = base.formula === 'NH3' ? { text: 'NH4', charge: 1 } : base.strongBase ? { text: base.formula.replace(/\(?OH\)?\d*$/, ''), charge: hydroxides } : null;

            if (cation && anionText && acid.formula?.startsWith('H')) {
                const gcd = (a, b) => (b ? gcd(b, a % b) : a);
                const divisor = gcd(cation.charge, protons);
                const cationCount = protons / divisor;
                const anionCount = cation.charge / divisor;
                const wrap = (text, count, poly) => (count === 1 ? text : poly ? `(${text})${count}` : `${text}${count}`);
                const formula = wrap(cation.text, cationCount, cation.text === 'NH4') + wrap(anionText, anionCount, /[A-Z].*[A-Z]/.test(anionText));
                salt = `${nameFromFormula(formula, c.data.elements).name} (${displayFormula(formula)})`;
            }
        } catch (error) {
            if (!(error instanceof NameError || error instanceof FormulaError)) {
                throw error;
            }
        }

        return {
            value: f(baseVolume * 1000),
            unit: 'mL',
            label: `${base.label} to neutralize`,
            sub: `${f(acidMoles * protons * 1000)} mmol H⁺ from ${acid.label}`,
            rows: { moles: `${f(acidMoles * 1000)} mmol acid`, equivalents: `${protons} H⁺ per acid, ${hydroxides} per base`, ph: `pH ${f(Math.round(ph * 100) / 100)} at the equivalence point`, salt },
        };
    },

    percent_to_molarity: (i, c, f) => {
        let percent = i.percent;
        let density = i.density;
        let formulaText = i.formula;
        let label = '';

        if (i.reagent !== 'custom') {
            const reagent = c.data.reagents[i.reagent];
            [percent, density, formulaText, label] = [reagent.percent, reagent.density, reagent.formula, reagent.name];
        }

        const formula = read(formulaText, c.data.elements);

        if (!formula.parsed) {
            return formula;
        }

        if (!(percent > 0 && percent <= 100) || !(density > 0)) {
            return { empty: 'Enter the percent by mass and the density.' };
        }

        const weight = weightOf(formula.parsed, c.data.elements);
        const molar = (percent * density * 10) / weight;
        const molality = (percent / weight / (100 - percent)) * 1000;
        const solute = percent / weight;
        const water = (100 - percent) / WATER_MOLAR_MASS;

        return {
            value: f(Math.round(molar * 100) / 100),
            unit: 'mol/L',
            label: `Molarity of ${label || formula.parsed.text}`,
            sub: `${f(percent)}% w/w at ${f(density)} g/mL (${f(weight)} g/mol)`,
            rows: { molality: percent < 100 ? `${f(molality)} mol/kg` : '—', fraction: f(solute / (solute + water)), dilute: `${f(1000 / molar)} mL of it makes 1 L of 1 M` },
        };
    },

    ph: (i, c, f) => {
        if (!(i.concentration > 0)) {
            return { empty: 'Enter the concentration.' };
        }

        const invalid = validateCustom(i);

        if (invalid) {
            return invalid;
        }

        const component = componentFor(i.choice, i.concentration, c.data, customFrom(i));
        const ph = solvePh([component], PKW);
        const h = 10 ** -ph;
        const rows = { poh: f(Math.round((PKW - ph) * 1000) / 1000), h: `${f(h)} mol/L`, oh: `${f(10 ** -(PKW - ph))} mol/L` };
        let list;

        if (component.type === 'acid') {
            const alpha = fractions(h, component.pKa);
            const strong = component.strongSteps;
            rows.dissociation = `${f(((1 - (strong ? 0 : alpha[0])) * 100))}% ${strong ? '(first step complete)' : 'dissociated'}`;
            const weakSteps = component.pKa.length;
            list = alpha.map((fraction, j) => ({ label: speciesLabel(weakSteps - j, strong + j), value: `${f(fraction * 100)}%` }));
        } else if (component.type === 'base') {
            const protonated = fractions(h, [component.pKaConjugate])[0];
            rows.dissociation = `${f(protonated * 100)}% protonated (BH⁺)`;
            list = [{ label: 'B', value: `${f((1 - protonated) * 100)}%` }, { label: 'BH⁺', value: `${f(protonated * 100)}%` }];
        } else {
            rows.dissociation = '100% (strong base)';
            list = [{ label: 'OH⁻ released', value: `${f(component.concentration)} mol/L` }];
        }

        return {
            value: f(Math.round(ph * 1000) / 1000),
            unit: 'pH',
            label: `pH of ${f(i.concentration)} M ${component.label}`,
            sub: 'Exact charge-balance solution at 25 °C, including water',
            rows,
            lists: { species: list },
        };
    },

    raoult: (i, c, f) => {
        if (i.mode === 'nonvolatile') {
            if (missing(i, 'solute_moles', 'solvent_moles', 'p_solvent') || !(i.solvent_moles > 0) || i.solute_moles < 0 || !(i.p_solvent > 0)) {
                return { empty: 'Enter the moles of solute and solvent and the pure solvent vapor pressure.' };
            }

            const x = i.solvent_moles / (i.solvent_moles + i.solute_moles);
            const pressure = x * i.p_solvent;

            return { value: f(pressure / 1000), unit: 'kPa', label: 'Vapor pressure of the solution', sub: `Lowered by ${f((i.p_solvent - pressure) / 1000)} kPa (ΔP = x solute × P°)`, rows: { x1: f(x), p1: `${f(pressure / 1000)} kPa`, p2: '0 (non-volatile solute)', y1: '1 (only solvent evaporates)' } };
        }

        if (missing(i, 'x1', 'p1', 'p2') || !(i.x1 >= 0 && i.x1 <= 1) || !(i.p1 > 0) || !(i.p2 > 0)) {
            return { empty: 'Enter the mole fraction of liquid 1 (0 to 1) and both pure vapor pressures.' };
        }

        const partial1 = i.x1 * i.p1;
        const partial2 = (1 - i.x1) * i.p2;
        const total = partial1 + partial2;

        return {
            value: f(total / 1000),
            unit: 'kPa',
            label: 'Total vapor pressure',
            sub: 'Ideal solution: P = x₁P₁° + x₂P₂°',
            rows: { x1: `${f(i.x1)} and ${f(1 - i.x1)}`, p1: `${f(partial1 / 1000)} kPa`, p2: `${f(partial2 / 1000)} kPa`, y1: `${f(partial1 / total)} (liquid 1 in the vapor)` },
        };
    },

    reconstitution: (i, c, f) => {
        if (missing(i, 'amount', 'diluent') || !(i.amount > 0) || !(i.diluent > 0)) {
            return { empty: 'Enter the powder amount and the diluent volume.' };
        }

        const concentration = i.amount / i.diluent;
        const unit = i.amount_unit === 'units' ? 'units' : 'mg';
        const draw = i.wanted > 0 ? i.wanted / concentration : null;

        if (draw !== null && i.wanted > i.amount) {
            return { error: 'The amount wanted is more than the vial holds.' };
        }

        return {
            value: f(concentration),
            unit: `${unit}/mL`,
            label: 'Concentration after mixing',
            sub: `${f(i.amount)} ${unit} in ${f(i.diluent)} mL; assumes the powder adds no volume`,
            rows: { draw: draw === null ? 'Enter an amount wanted' : `${f(draw)} mL`, per_01: `${f(concentration * 0.1)} ${unit} in 0.1 mL`, doses: draw ? `${f(Math.floor(i.amount / i.wanted))} portions of that size` : '—' },
        };
    },

    saponification: (i, c, f) => {
        const rows = [1, 2, 3, 4, 5].map((n) => ({ oil: i[`oil_${n}`], weight: i[`weight_${n}`] })).filter((row) => row.oil && row.oil !== 'none' && row.weight > 0);

        if (!rows.length) {
            return { empty: 'Pick at least one oil and enter its weight.' };
        }

        const lye = i.lye === 'koh' ? 'koh' : 'naoh';
        const superfat = Number.isNaN(i.superfat) ? 0 : i.superfat;
        const purity = i.purity > 0 ? i.purity : 100;

        if (superfat < 0 || superfat >= 50) {
            return { error: 'Superfat should be 0 to under 50%.' };
        }

        const oilsTotal = rows.reduce((sum, row) => sum + row.weight, 0);
        const lyeNeeded = rows.reduce((sum, row) => sum + row.weight * c.data.oils[row.oil][lye], 0) * (1 - superfat / 100) / (purity / 100);
        const water = i.water_mode === 'ratio' ? lyeNeeded * (i.water_value > 0 ? i.water_value : 2) : (oilsTotal * (i.water_value > 0 ? i.water_value : 33)) / 100;

        return {
            value: f(Math.round(lyeNeeded * 100) / 100),
            unit: i.weight_unit || 'g',
            label: `${lye === 'koh' ? 'KOH' : 'NaOH'} needed`,
            sub: `${f(oilsTotal)} ${i.weight_unit || 'g'} of oils, ${f(superfat)}% superfat${purity < 100 ? `, ${f(purity)}% pure lye` : ''}`,
            rows: { water: `${f(Math.round(water * 10) / 10)} ${i.weight_unit || 'g'}`, concentration: `${f((lyeNeeded / (lyeNeeded + water)) * 100)}% lye solution`, oils: `${f(oilsTotal)} ${i.weight_unit || 'g'}` },
            lists: { oils: rows.map((row) => ({ label: c.data.oils[row.oil].name, value: `${f(row.weight)} × ${c.data.oils[row.oil][lye]} = ${f(row.weight * c.data.oils[row.oil][lye])}` })) },
        };
    },

    tds: (i, c, f) => {
        if (missing(i, 'residue', 'sample') || !(i.residue >= 0) || !(i.sample > 0)) {
            return { empty: 'Enter the dried residue mass and the sample volume.' };
        }

        const mgPerLiter = (i.residue * 1000) / i.sample;
        const kind = mgPerLiter < 1000 ? 'Fresh water (under 1,000 mg/L)' : mgPerLiter < 10000 ? 'Slightly to moderately saline' : mgPerLiter < 35000 ? 'Highly saline' : 'Brine (over 35,000 mg/L)';

        return {
            value: f(Math.round(mgPerLiter * 10) / 10),
            unit: 'mg/L',
            label: 'Total dissolved solids',
            sub: 'Dried residue ÷ sample volume (filtered sample dried at 180 °C)',
            rows: { ppm: `${f(mgPerLiter)} ppm (for water at about 1 kg/L)`, class: kind, grams: `${f(mgPerLiter / 1000)} g/L` },
        };
    },

    titration: (i, c, f) => {
        const invalid = validateCustom(i);

        if (invalid) {
            return invalid;
        }

        if (missing(i, 'analyte_volume', 'titrant_concentration') || !(i.analyte_volume > 0) || !(i.titrant_concentration > 0)) {
            return { empty: 'Enter the analyte volume and titrant concentration.' };
        }

        const analyteVolume = i.analyte_volume;
        const titrantIsBase = !(i.choice.startsWith('base') || (i.choice === 'custom' && i.kind === 'base'));
        const probe = componentFor(i.choice, 1, c.data, customFrom(i));

        if (i.mode === 'find') {
            if (!(i.titrant_volume > 0)) {
                return { empty: 'Enter the titrant volume at the end point.' };
            }

            const steps = Math.round(i.steps > 0 ? i.steps : probe.protons);
            const concentration = (i.titrant_concentration * i.titrant_volume) / steps / analyteVolume;

            return {
                value: f(concentration),
                unit: 'mol/L',
                label: `Concentration of ${probe.label}`,
                sub: `${f(i.titrant_concentration * i.titrant_volume * 1000)} mmol titrant ÷ ${steps} per analyte ÷ ${f(analyteVolume * 1000)} mL`,
                rows: { equivalence: `${f(i.titrant_volume * 1000)} mL`, moles: `${f(concentration * analyteVolume * 1000)} mmol analyte`, half: '—' },
            };
        }

        if (!(i.analyte_concentration > 0)) {
            return { empty: 'Enter the analyte concentration.' };
        }

        const analyteMoles = i.analyte_concentration * analyteVolume;
        const equivalences = Array.from({ length: probe.protons }, (_, k) => (analyteMoles * (k + 1)) / i.titrant_concentration);
        const last = equivalences[equivalences.length - 1];
        const phAt = (volume) => {
            const total = analyteVolume + volume;
            const titrant = (i.titrant_concentration * volume) / total;

            return solvePh([componentFor(i.choice, analyteMoles / total, c.data, customFrom(i)), titrantIsBase ? { type: 'cation', concentration: titrant, charge: 1 } : { type: 'anion', concentration: titrant, charge: 1 }], PKW);
        };
        const series = Array.from({ length: 151 }, (_, k) => {
            const volume = (last * 1.5 * k) / 150;

            return [volume * 1000, phAt(volume)];
        });
        const halfPh = phAt(equivalences[0] / 2);

        return {
            value: f(equivalences[0] * 1000),
            unit: 'mL',
            label: 'Equivalence point',
            sub: `pH ${f(Math.round(phAt(equivalences[0]) * 100) / 100)} at equivalence; ${titrantIsBase ? 'NaOH' : 'HCl'} titrant`,
            rows: { equivalence: equivalences.map((volume) => `${f(volume * 1000)} mL`).join(', '), moles: `${f(analyteMoles * 1000)} mmol analyte`, half: `pH ${f(Math.round(halfPh * 100) / 100)} at half-equivalence${probe.type === 'cation' || probe.strongSteps ? '' : ' (≈ pKa)'}` },
            plots: { curve: { series, xLabel: `${titrantIsBase ? 'NaOH' : 'HCl'} added (mL)`, yLabel: 'pH', yTicks: [0, 2, 4, 6, 8, 10, 12, 14], markers: equivalences.map((volume, k) => ({ x: volume * 1000, y: phAt(volume), label: equivalences.length > 1 ? `Eq ${k + 1}` : 'Equivalence' })) } },
            lists: { points: [0, 0.25, 0.5, 0.75, 0.9, 0.99, 1, 1.01, 1.1, 1.5].map((share) => ({ label: `${f(share * equivalences[0] * 1000)} mL`, value: `pH ${f(Math.round(phAt(share * equivalences[0]) * 100) / 100)}`, highlight: share === 1 })) },
        };
    },

    water_hardness: (i, c, f) => {
        const element = (symbol) => c.data.elements[symbol].weight;
        const carbonate = element('Ca') + element('C') + 3 * element('O');
        const lime = element('Ca') + element('O');
        const perUnit = {
            mgl: 1,
            mmol: carbonate,
            gpg: 64.79891 / 3.785411784,
            dh: (10 * carbonate) / lime,
            fh: 10,
            e: 64.79891 / 4.54609,
        };
        let mgPerLiter;

        if (i.mode === 'ions') {
            if (missing(i, 'calcium', 'magnesium') || i.calcium < 0 || i.magnesium < 0) {
                return { empty: 'Enter calcium and magnesium in mg/L.' };
            }

            mgPerLiter = i.calcium * (carbonate / element('Ca')) + i.magnesium * (carbonate / element('Mg'));
        } else {
            if (missing(i, 'value') || i.value < 0) {
                return { empty: 'Enter the hardness.' };
            }

            mgPerLiter = i.value * perUnit[i.from];
        }

        const kind = mgPerLiter <= 60 ? 'Soft (0–60 mg/L)' : mgPerLiter <= 120 ? 'Moderately hard (61–120 mg/L)' : mgPerLiter <= 180 ? 'Hard (121–180 mg/L)' : 'Very hard (over 180 mg/L)';

        return {
            value: f(Math.round(mgPerLiter * 100) / 100),
            unit: 'mg/L CaCO₃',
            label: 'Water hardness',
            sub: `${kind} (USGS)`,
            lists: { units: Object.entries(HARDNESS_UNITS).map(([key, name]) => ({ label: name, value: f(mgPerLiter / perUnit[key]), highlight: i.mode !== 'ions' && key === i.from })) },
        };
    },

    ksp: (i, c, f) => {
        let formulaText = i.formula;
        let kspValue = i.ksp_value;

        if (i.salt !== 'custom') {
            const salt = c.data.ksp[i.salt];
            formulaText = salt.formula;
            kspValue = salt.ksp;
        }

        let parts;

        if (!String(formulaText ?? '').trim()) {
            return { empty: 'Enter a salt formula.' };
        }

        try {
            parts = ionicParts(formulaText, c.data.elements);
        } catch (error) {
            if (error instanceof NameError) {
                return { error: error.message };
            }

            throw error;
        }

        const { cation, anion } = parts;
        const x = cation.count;
        const y = anion.count;
        const commonCation = i.common === 'cation' && i.common_concentration > 0 ? i.common_concentration : 0;
        const commonAnion = i.common === 'anion' && i.common_concentration > 0 ? i.common_concentration : 0;
        const ionText = `${displayFormula(cation.formula, cation.charge)} and ${displayFormula(anion.formula, anion.charge)}`;
        const weight = weightOf(parseFormula(formulaText, c.data.elements), c.data.elements);

        if (i.mode === 'from_solubility') {
            if (!(i.solubility > 0)) {
                return { empty: 'Enter the molar solubility.' };
            }

            const value = (x * i.solubility + commonCation) ** x * (y * i.solubility + commonAnion) ** y;

            return { value: f(value), unit: '', label: `Ksp of ${displayFormula(formulaText)}`, sub: `Ksp = [${displayFormula(cation.formula, cation.charge)}]^${x} [${displayFormula(anion.formula, anion.charge)}]^${y}`, rows: { ions: ionText, grams: `${f(i.solubility * weight)} g/L dissolved`, pksp: f(-Math.log10(value)) } };
        }

        if (!(kspValue > 0)) {
            return { empty: 'Enter the Ksp.' };
        }

        // Solve Ksp = (x s + Ca)^x (y s + Cb)^y for s by bisection on log s (monotonic in s).
        let low = -40;
        let high = 2;

        for (let step = 0; step < 200; step += 1) {
            const middle = (low + high) / 2;
            const s = 10 ** middle;
            const product = (x * s + commonCation) ** x * (y * s + commonAnion) ** y;

            if (product > kspValue) {
                high = middle;
            } else {
                low = middle;
            }
        }

        const solubility = 10 ** ((low + high) / 2);

        return {
            value: f(solubility),
            unit: 'mol/L',
            label: `Molar solubility of ${displayFormula(formulaText)}`,
            sub: commonCation || commonAnion ? `With ${f(commonCation || commonAnion)} M of the common ion already present` : `Ksp ${f(kspValue)} at 25 °C`,
            rows: { ions: `${ionText} (${x} : ${y})`, grams: `${f(solubility * weight)} g/L dissolved`, pksp: f(-Math.log10(kspValue)) },
        };
    },
};

export default defineTools(handlers);
