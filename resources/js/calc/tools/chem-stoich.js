import { balance, BalanceError } from '../chemistry/balance.js';
import { FormulaError, hillFormula, molarMass, parseFormula } from '../chemistry/formula.js';
import { pKw } from '../chemistry/water.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Stoichiometry calculators: moles, particles, concentrations, formulas and flows.
 * Masses arrive in grams and volumes in liters from unit menus; element data is config.data.elements.
 */
export const AVOGADRO = 6.02214076e23;
export const R = 8.314462618;
/** Molar volume of an ideal gas: IUPAC STP (273.15 K, 100 kPa) and the older 1 atm definition. */
export const MOLAR_VOLUME = { iupac: 22.71095464, atm: 22.41396954 };
/** Dry air (ISO 2533): molar mass 28.9644 g/mol, O₂ mole fraction 0.20946. */
export const AIR = { molarMass: 28.9644, oxygen: 0.20946 };

const FLOW_TO_LITERS_PER_SECOND = { l_s: 1, l_min: 1 / 60, l_h: 1 / 3600, m3_h: 1000 / 3600, m3_d: 1000 / 86400, gpm: 3.785411784 / 60, mgd: 3.785411784e6 / 86400 };

const GASES = ['H2', 'He', 'CH4', 'NH3', 'H2O', 'Ne', 'C2H2', 'N2', 'CO', 'C2H4', 'NO', 'C2H6', 'O2', 'H2S', 'HCl', 'Ar', 'CO2', 'N2O', 'C3H8', 'NO2', 'O3', 'C4H10', 'SO2', 'Cl2', 'Kr', 'SF6', 'Xe'];

function read(text, elements, required = true) {
    if (!String(text ?? '').trim()) {
        return required ? { empty: 'Enter a chemical formula.' } : { parsed: null };
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

function weightOf(parsed, elements) {
    return molarMass(parsed, elements).total;
}

/**
 * Formula or typed molar mass, whichever the user gave (formula wins).
 */
function molarMassInput(i, c) {
    const formula = read(i.formula, c.data.elements, false);

    if (formula.error) {
        return formula;
    }

    if (formula.parsed) {
        return { weight: weightOf(formula.parsed, c.data.elements), label: formula.parsed.text };
    }

    return i.weight > 0 ? { weight: i.weight, label: `${i.weight} g/mol` } : { empty: 'Enter a formula or a molar mass.' };
}

/**
 * Oxygen needed to burn one mole of a fuel CcHhOoNnSs completely to CO₂, H₂O, SO₂ and N₂.
 */
export function oxygenForCombustion(counts) {
    const unsupported = [...counts.keys()].filter((symbol) => !['C', 'H', 'O', 'N', 'S'].includes(symbol));

    if (unsupported.length) {
        throw new FormulaError(`Fuels may contain only C, H, O, N and S (found ${unsupported.join(', ')}).`);
    }

    return (counts.get('C') ?? 0) + (counts.get('H') ?? 0) / 4 + (counts.get('S') ?? 0) - (counts.get('O') ?? 0) / 2;
}

export function stoichiometricAfr(parsed, elements) {
    const oxygen = oxygenForCombustion(parsed.counts);

    if (oxygen <= 0) {
        throw new FormulaError('This substance needs no oxygen to burn.');
    }

    return (oxygen * AIR.molarMass) / AIR.oxygen / weightOf(parsed, elements);
}

/**
 * Empirical formula from element amounts: mole ratios divided by the smallest, then the smallest
 * whole-number multiplier (1 to 12) that brings every ratio within 0.08 of a whole number.
 */
export function empiricalFormula(amounts, elements) {
    const moles = amounts.map(({ symbol, mass }) => ({ symbol, moles: mass / elements[symbol].weight }));
    const smallest = Math.min(...moles.map((item) => item.moles));
    const ratios = moles.map((item) => ({ ...item, ratio: item.moles / smallest }));

    for (let multiplier = 1; multiplier <= 12; multiplier += 1) {
        if (ratios.every((item) => Math.abs(item.ratio * multiplier - Math.round(item.ratio * multiplier)) <= 0.08)) {
            const counts = new Map(ratios.map((item) => [item.symbol, Math.round(item.ratio * multiplier)]));

            return { counts, multiplier, ratios };
        }
    }

    return { counts: null, ratios };
}

function parseAmountLines(text) {
    return String(text ?? '').split(/\n|;/).map((line) => line.trim()).filter(Boolean);
}

export const handlers = {
    afr: (i, c, f) => {
        const fuel = read(i.fuel, c.data.elements);

        if (!fuel.parsed) {
            return fuel;
        }

        let stoich;

        try {
            stoich = stoichiometricAfr(fuel.parsed, c.data.elements);
        } catch (error) {
            return { error: error.message };
        }

        const oxygen = oxygenForCombustion(fuel.parsed.counts);

        if (i.mode === 'measured') {
            if (missing(i, 'air', 'fuel_mass') || !(i.air > 0) || !(i.fuel_mass > 0)) {
                return { empty: 'Enter the air and fuel mass.' };
            }

            const afr = i.air / i.fuel_mass;
            const lambda = afr / stoich;

            return {
                value: f(afr),
                unit: ': 1',
                label: 'Air–fuel ratio (mass)',
                sub: lambda > 1.005 ? `Lean: λ = ${f(lambda)}` : lambda < 0.995 ? `Rich: λ = ${f(lambda)}` : 'Stoichiometric (λ = 1)',
                rows: { stoich: `${f(stoich)} : 1 for ${fuel.parsed.text}`, lambda: f(lambda), phi: f(1 / lambda), oxygen: `${f(oxygen)} mol O₂ per mol fuel` },
            };
        }

        return {
            value: f(stoich),
            unit: ': 1',
            label: `Stoichiometric air–fuel ratio of ${fuel.parsed.text}`,
            sub: 'Mass of dry air per mass of fuel for complete combustion',
            rows: { stoich: `${f(stoich)} kg air per kg fuel`, lambda: '1 at this ratio', phi: '1 at this ratio', oxygen: `${f(oxygen)} mol O₂ per mol fuel` },
        };
    },

    atom_economy: (i, c, f) => {
        let result;

        try {
            result = balance(i.equation, c.data.elements);
        } catch (error) {
            if (error instanceof BalanceError) {
                return String(i.equation ?? '').trim() ? { error: error.message } : { empty: 'Enter a chemical equation.' };
            }

            throw error;
        }

        const product = read(i.product, c.data.elements);

        if (!product.parsed) {
            return product;
        }

        const key = hillFormula(product.parsed.counts);
        const index = result.products.findIndex((item) => hillFormula(item.counts) === key);

        if (index === -1) {
            return { error: `${product.parsed.text} is not one of the products.` };
        }

        const reactantMass = result.reactants.reduce((sum, item, k) => sum + result.coefficients[k] * weightOf(item, c.data.elements), 0);
        const productMass = result.coefficients[result.reactants.length + index] * weightOf(result.products[index], c.data.elements);

        return {
            value: f((productMass / reactantMass) * 100),
            unit: '%',
            label: `Atom economy for ${result.products[index].text}`,
            sub: 'Mass of the wanted product ÷ mass of all reactants, from the balanced equation',
            rows: { product: `${f(productMass)} g`, reactants: `${f(reactantMass)} g`, waste: `${f(reactantMass - productMass)} g of by-products` },
        };
    },

    avogadro: (i, c, f) => {
        const formula = read(i.formula, c.data.elements, false);

        if (formula.error) {
            return formula;
        }

        if (missing(i, 'value') || i.value < 0) {
            return { empty: i.direction === 'particles' ? 'Enter the number of particles.' : 'Enter the moles.' };
        }

        const moles = i.direction === 'particles' ? i.value / AVOGADRO : i.value;
        const particles = moles * AVOGADRO;
        const mass = formula.parsed ? moles * weightOf(formula.parsed, c.data.elements) : null;

        return {
            value: f(i.direction === 'particles' ? moles : particles),
            unit: i.direction === 'particles' ? 'mol' : 'particles',
            label: i.direction === 'particles' ? 'Amount of substance' : 'Number of particles',
            sub: 'Nₐ = 6.022 140 76 × 10²³ per mole (exact)',
            rows: { moles: `${f(moles)} mol`, particles: f(particles), mass: mass === null ? 'Add a formula for the mass' : `${f(mass)} g of ${formula.parsed.text}` },
        };
    },

    empirical: (i, c, f) => {
        const lines = parseAmountLines(i.amounts);

        if (!lines.length) {
            return { empty: 'Enter each element and its mass or percent, one per line (e.g. C 40.0).' };
        }

        const amounts = [];

        for (const [index, line] of lines.entries()) {
            const match = /^([A-Z][a-z]?)\s*[:=]?\s*([\d.]+)\s*(?:%|g)?$/.exec(line);

            if (!match || !c.data.elements[match[1]] || !(Number(match[2]) > 0)) {
                return { error: `Line ${index + 1}: write an element symbol and a positive amount, e.g. C 40.0.` };
            }

            amounts.push({ symbol: match[1], mass: Number(match[2]) });
        }

        const result = empiricalFormula(amounts, c.data.elements);

        if (!result.counts) {
            return { error: 'No whole-number ratio up to ×12 fits these amounts; check the data.' };
        }

        const empirical = parseFormula([...result.counts].map(([symbol, count]) => symbol + (count === 1 ? '' : count)).join(''), c.data.elements);
        const empiricalMass = weightOf(empirical, c.data.elements);
        let molecular = 'Enter the molar mass for the molecular formula';

        if (i.molar_mass > 0) {
            const n = i.molar_mass / empiricalMass;

            if (Math.abs(n - Math.round(n)) > 0.05 * Math.max(1, Math.round(n)) || Math.round(n) < 1) {
                molecular = `${f(i.molar_mass)} g/mol is not a whole multiple of ${f(empiricalMass)}`;
            } else {
                const multiple = Math.round(n);
                molecular = `${hillFormula(new Map([...result.counts].map(([symbol, count]) => [symbol, count * multiple])))} (× ${multiple})`;
            }
        }

        return {
            value: hillFormula(result.counts),
            unit: '',
            label: 'Empirical formula',
            sub: `Mole ratios × ${result.multiplier}; ${f(empiricalMass)} g/mol`,
            rows: { molecular, mass: `${f(empiricalMass)} g/mol`, multiplier: `× ${result.multiplier}` },
            lists: { ratios: result.ratios.map((item) => ({ label: item.symbol, value: `${f(item.moles)} mol → ratio ${f(item.ratio)} → ${result.counts.get(item.symbol)}` })) },
        };
    },

    grams_moles: (i, c, f) => {
        const formula = read(i.formula, c.data.elements);

        if (!formula.parsed) {
            return formula;
        }

        const weight = weightOf(formula.parsed, c.data.elements);

        if (i.direction === 'moles') {
            if (missing(i, 'moles') || i.moles < 0) {
                return { empty: 'Enter the moles.' };
            }

            const grams = i.moles * weight;

            return { value: f(grams), unit: 'g', label: `Mass of ${formula.parsed.text}`, sub: `${f(i.moles)} mol × ${f(weight)} g/mol`, rows: { mmol: `${f(i.moles * 1000)} mmol`, particles: f(i.moles * AVOGADRO), weight: `${f(weight)} g/mol` } };
        }

        if (missing(i, 'mass') || i.mass < 0) {
            return { empty: 'Enter the mass.' };
        }

        const moles = i.mass / weight;

        return { value: f(moles), unit: 'mol', label: `Moles of ${formula.parsed.text}`, sub: `${f(i.mass)} g ÷ ${f(weight)} g/mol`, rows: { mmol: `${f(moles * 1000)} mmol`, particles: f(moles * AVOGADRO), weight: `${f(weight)} g/mol` } };
    },

    hydrogen_ion: (i, c, f) => {
        const temperature = Number.isNaN(i.temperature) ? 25 : i.temperature;
        let water;

        try {
            water = pKw(temperature);
        } catch (error) {
            return { error: error.message };
        }

        let ph;

        if (i.direction === 'h') {
            if (!(i.h > 0)) {
                return { empty: 'Enter [H⁺] in mol/L.' };
            }

            ph = -Math.log10(i.h);
        } else {
            if (missing(i, 'ph')) {
                return { empty: 'Enter the pH.' };
            }

            ph = i.ph;
        }

        const h = 10 ** -ph;
        const poh = water - ph;

        return {
            value: i.direction === 'h' ? f(Math.round(ph * 1000) / 1000) : f(h),
            unit: i.direction === 'h' ? 'pH' : 'mol/L',
            label: i.direction === 'h' ? 'pH' : 'Hydrogen ion concentration [H⁺]',
            sub: `At ${f(temperature)} °C water is neutral at pH ${f(Math.round((water / 2) * 1000) / 1000)}; ${ph < water / 2 ? 'this is acidic' : ph > water / 2 ? 'this is basic' : 'this is neutral'}`,
            rows: { h: `${f(h)} mol/L`, poh: f(Math.round(poh * 1000) / 1000), oh: `${f(10 ** -poh)} mol/L`, pkw: f(Math.round(water * 1000) / 1000) },
        };
    },

    molality: (i, c, f) => {
        let moles = i.moles;
        let weight = null;
        const formula = read(i.formula, c.data.elements, false);

        if (formula.error) {
            return formula;
        }

        if (i.mode === 'mass') {
            if (!formula.parsed) {
                return { empty: 'Enter the solute formula.' };
            }

            weight = weightOf(formula.parsed, c.data.elements);

            if (!(i.solute_mass > 0)) {
                return { empty: 'Enter the solute mass.' };
            }

            moles = i.solute_mass / weight;
        } else if (!(moles > 0)) {
            return { empty: 'Enter the moles of solute.' };
        }

        if (!(i.solvent > 0)) {
            return { empty: 'Enter the solvent mass.' };
        }

        const kg = i.solvent / 1000;
        const molality = moles / kg;
        const solventMoles = i.solvent / weightOf(parseFormula('H2O', c.data.elements), c.data.elements);
        const soluteMass = weight ? moles * weight : null;
        const molarity = i.density > 0 && soluteMass !== null ? moles / (((soluteMass + i.solvent) / i.density) / 1000) : null;

        return {
            value: f(molality),
            unit: 'mol/kg',
            label: 'Molality',
            sub: `${f(moles)} mol in ${f(kg)} kg of solvent`,
            rows: { fraction: i.water_solvent === 'yes' ? f(moles / (moles + solventMoles)) : 'For water as the solvent', molarity: molarity === null ? 'Enter the solution density (mass mode)' : `${f(molarity)} mol/L`, mmol: `${f(molality * 1000)} mmol/kg` },
        };
    },

    gas_molar_mass: (i, c, f) => {
        if (missing(i, 'temperature', 'pressure')) {
            return { empty: 'Enter the temperature and pressure.' };
        }

        const kelvin = i.temperature + 273.15;

        if (kelvin <= 0 || i.pressure <= 0) {
            return { error: 'Temperature must be above absolute zero and pressure above 0.' };
        }

        let molar;

        if (i.mode === 'density') {
            if (!(i.density > 0)) {
                return { empty: 'Enter the gas density.' };
            }

            molar = (i.density * R * kelvin) / i.pressure;
        } else {
            if (!(i.mass > 0) || !(i.volume > 0)) {
                return { empty: 'Enter the mass and volume.' };
            }

            molar = (i.mass * R * kelvin) / (i.pressure * (i.volume / 1000));
        }

        const candidates = GASES.map((gas) => ({ gas, weight: weightOf(parseFormula(gas, c.data.elements), c.data.elements) }))
            .sort((a, b) => Math.abs(a.weight - molar) - Math.abs(b.weight - molar))
            .slice(0, 4);

        return {
            value: f(molar),
            unit: 'g/mol',
            label: 'Molar mass of the gas',
            sub: 'Ideal gas: M = mRT ÷ PV',
            rows: { kelvin: `${f(kelvin)} K`, density_stp: `${f(molar / MOLAR_VOLUME.iupac)} g/L at IUPAC STP` },
            lists: { matches: candidates.map((item) => ({ label: parseFormula(item.gas, c.data.elements).text, value: `${f(item.weight)} g/mol (${f(((item.weight - molar) / molar) * 100)}%)`, highlight: Math.abs(item.weight - molar) / molar < 0.02 })) },
        };
    },

    mole: (i, c, f) => {
        const formula = read(i.formula, c.data.elements, false);

        if (formula.error) {
            return formula;
        }

        const weight = formula.parsed ? weightOf(formula.parsed, c.data.elements) : null;
        let moles;

        if (i.mode === 'mass') {
            if (!weight) {
                return { empty: 'Enter a formula to convert mass to moles.' };
            }

            if (!(i.mass >= 0) || missing(i, 'mass')) {
                return { empty: 'Enter the mass.' };
            }

            moles = i.mass / weight;
        } else if (i.mode === 'particles') {
            if (missing(i, 'particles') || i.particles < 0) {
                return { empty: 'Enter the number of particles.' };
            }

            moles = i.particles / AVOGADRO;
        } else if (i.mode === 'gas') {
            if (missing(i, 'gas_volume') || i.gas_volume < 0) {
                return { empty: 'Enter the gas volume at STP.' };
            }

            moles = i.gas_volume / MOLAR_VOLUME[i.stp ?? 'iupac'];
        } else {
            if (missing(i, 'concentration', 'solution_volume')) {
                return { empty: 'Enter the concentration and volume.' };
            }

            moles = i.concentration * i.solution_volume;
        }

        return {
            value: f(moles),
            unit: 'mol',
            label: 'Amount of substance',
            sub: 'n = m ÷ M = N ÷ Nₐ = V ÷ Vm = c × V',
            rows: { mass: weight ? `${f(moles * weight)} g of ${formula.parsed.text}` : 'Add a formula for the mass', particles: f(moles * AVOGADRO), gas: `${f(moles * MOLAR_VOLUME.iupac)} L at IUPAC STP (${f(moles * MOLAR_VOLUME.atm)} L at 0 °C, 1 atm)` },
        };
    },

    mole_fraction: (i, c, f) => {
        const lines = parseAmountLines(i.components);

        if (lines.length < 2) {
            return { empty: 'Enter at least two components, one per line: formula, amount and unit (g or mol).' };
        }

        const parts = [];

        for (const [index, line] of lines.entries()) {
            const match = /^(\S+)\s+([\d.]+(?:e-?\d+)?)\s*(g|mg|kg|mol|mmol)?$/i.exec(line);

            if (!match) {
                return { error: `Line ${index + 1}: write a formula, an amount and g or mol, e.g. H2O 90 g.` };
            }

            const formula = read(match[1], c.data.elements);

            if (!formula.parsed) {
                return { error: `Line ${index + 1}: ${formula.error ?? formula.empty}` };
            }

            const weight = weightOf(formula.parsed, c.data.elements);
            const unit = (match[3] ?? 'mol').toLowerCase();
            const amount = Number(match[2]);
            const grams = { g: amount, mg: amount / 1000, kg: amount * 1000 }[unit];
            const moles = grams !== undefined ? grams / weight : unit === 'mmol' ? amount / 1000 : amount;
            parts.push({ text: formula.parsed.text, moles, grams: moles * weight });
        }

        const totalMoles = parts.reduce((sum, part) => sum + part.moles, 0);
        const totalGrams = parts.reduce((sum, part) => sum + part.grams, 0);

        return {
            value: parts.map((part) => `${part.text} ${f(Math.round((part.moles / totalMoles) * 10000) / 10000)}`).join(' · '),
            unit: '',
            label: 'Mole fractions',
            sub: `${f(totalMoles)} mol in total; fractions add up to 1`,
            rows: { total: `${f(totalMoles)} mol`, mass: `${f(totalGrams)} g` },
            lists: { parts: parts.map((part) => ({ label: part.text, value: `x = ${f(part.moles / totalMoles)} · ${f((part.moles / totalMoles) * 100)} mol% · ${f((part.grams / totalGrams) * 100)} mass%` })) },
        };
    },

    moles_atoms: (i, c, f) => {
        const formula = read(i.formula, c.data.elements, false);

        if (formula.error) {
            return formula;
        }

        const atomsPerUnit = formula.parsed ? [...formula.parsed.counts.values()].reduce((sum, count) => sum + count, 0) : 1;
        const weight = formula.parsed ? weightOf(formula.parsed, c.data.elements) : null;

        if (missing(i, 'value') || i.value < 0) {
            return { empty: i.direction === 'atoms' ? 'Enter the number of atoms.' : 'Enter the moles.' };
        }

        const moles = i.direction === 'atoms' ? i.value / (AVOGADRO * atomsPerUnit) : i.value;
        const atoms = moles * AVOGADRO * atomsPerUnit;

        return {
            value: f(i.direction === 'atoms' ? moles : atoms),
            unit: i.direction === 'atoms' ? 'mol' : 'atoms',
            label: i.direction === 'atoms' ? 'Moles' : 'Number of atoms',
            sub: formula.parsed ? `${atomsPerUnit} atoms in each ${formula.parsed.text}` : 'For a single element (1 atom per formula unit)',
            rows: { molecules: `${f(moles * AVOGADRO)} formula units`, atoms: f(atoms), mass: weight ? `${f(moles * weight)} g` : 'Add a formula for the mass' },
        };
    },

    normality: (i, c, f) => {
        const equivalents = Math.round(i.equivalents);

        if (!(equivalents >= 1)) {
            return { empty: 'Enter the equivalents per formula unit (H⁺, OH⁻ or electrons).' };
        }

        let molarity = i.molarity;
        let weight = null;

        if (i.mode === 'mass') {
            const formula = read(i.formula, c.data.elements);

            if (!formula.parsed) {
                return formula;
            }

            weight = weightOf(formula.parsed, c.data.elements);

            if (!(i.mass > 0) || !(i.volume > 0)) {
                return { empty: 'Enter the mass and solution volume.' };
            }

            molarity = i.mass / weight / i.volume;
        } else if (!(molarity >= 0) || missing(i, 'molarity')) {
            return { empty: 'Enter the molarity.' };
        }

        return {
            value: f(molarity * equivalents),
            unit: 'N',
            label: 'Normality',
            sub: `${f(molarity)} M × ${equivalents} equivalent${equivalents === 1 ? '' : 's'}`,
            rows: { molarity: `${f(molarity)} mol/L`, equivalent: weight ? `${f(weight / equivalents)} g per equivalent` : 'Use mass mode for the equivalent weight', meq: `${f(molarity * equivalents * 1000)} meq/L` },
        };
    },

    ppm_molarity: (i, c, f) => {
        const mass = molarMassInput(i, c);

        if (!mass.weight) {
            return mass;
        }

        const density = i.density > 0 ? i.density : 1;

        if (missing(i, 'value') || i.value < 0) {
            return { empty: 'Enter the concentration.' };
        }

        // ppm here is by mass (mg/kg); mg/L = ppm × solution density in g/mL.
        if (i.direction === 'molar') {
            const mgPerLiter = i.value * mass.weight * 1000;

            return { value: f(mgPerLiter / density), unit: 'ppm', label: 'Parts per million (by mass)', sub: `${f(i.value)} mol/L × ${f(mass.weight)} g/mol`, rows: { mg: `${f(mgPerLiter)} mg/L`, micromolar: `${f(i.value * 1e6)} µM`, density: `${f(density)} g/mL` } };
        }

        const mgPerLiter = i.value * density;
        const molar = mgPerLiter / 1000 / mass.weight;

        return { value: f(molar), unit: 'mol/L', label: 'Molarity', sub: `${f(i.value)} ppm × ${f(density)} g/mL ÷ ${f(mass.weight)} g/mol`, rows: { mg: `${f(mgPerLiter)} mg/L`, micromolar: `${f(molar * 1e6)} µM`, density: `${f(density)} g/mL` } };
    },

    residence_time: (i, c, f) => {
        const toLitersPerSecond = FLOW_TO_LITERS_PER_SECOND[i.flow_unit];
        let seconds;
        let liters = i.volume;
        let flow = i.flow * toLitersPerSecond;

        if (i.solve === 'tau') {
            if (!(i.volume > 0) || !(i.flow > 0)) {
                return { empty: 'Enter the volume and flow rate.' };
            }

            seconds = liters / flow;
        } else if (i.solve === 'volume') {
            if (!(i.time > 0) || !(i.flow > 0)) {
                return { empty: 'Enter the residence time and flow rate.' };
            }

            seconds = i.time;
            liters = flow * seconds;
        } else {
            if (!(i.time > 0) || !(i.volume > 0)) {
                return { empty: 'Enter the residence time and volume.' };
            }

            seconds = i.time;
            flow = liters / seconds;
        }

        const hours = seconds / 3600;
        const values = {
            tau: [f(hours), 'h', 'Residence time τ'],
            volume: [f(liters), 'L', 'Volume'],
            flow: [f(flow / toLitersPerSecond), { l_s: 'L/s', l_min: 'L/min', l_h: 'L/h', m3_h: 'm³/h', m3_d: 'm³/day', gpm: 'gal/min', mgd: 'MGD' }[i.flow_unit], 'Flow rate'],
        }[i.solve];

        return {
            value: values[0],
            unit: values[1],
            label: values[2],
            sub: 'τ = V ÷ Q (also called detention or hydraulic retention time)',
            rows: { minutes: `${f(hours * 60)} min`, days: `${f(hours / 24)} days`, velocity: `${f(1 / hours)} per hour`, turnovers: `${f(24 / hours)} a day`, volume: `${f(liters)} L (${f(liters / 1000)} m³)` },
        };
    },
};

export default defineTools(handlers);
