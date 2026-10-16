import { balance, BalanceError, formatEquation } from '../chemistry/balance.js';
import { FormulaError, hillFormula, molarMass, parseFormula } from '../chemistry/formula.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Organic chemistry: oxygen demand, combustion, unsaturation, protein from nitrogen, ethylene
 * density and radiocarbon age. Element data is config.data.elements.
 */
function read(text, elements) {
    if (!String(text ?? '').trim()) {
        return { empty: 'Enter a molecular formula.' };
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
 * Degree of unsaturation (rings + π bonds) = (2C + 2 + N − H − X) ÷ 2; O and S do not count.
 */
export function degreeOfUnsaturation(counts) {
    const get = (symbol) => counts.get(symbol) ?? 0;
    const carbonLike = get('C') + get('Si');
    const nitrogenLike = get('N') + get('P');
    const hydrogenLike = get('H') + get('D') + get('F') + get('Cl') + get('Br') + get('I');

    return (2 * carbonLike + 2 + nitrogenLike - hydrogenLike) / 2;
}

/**
 * Theoretical oxygen demand of CcHhOoNn (nitrogen to NH₃, Na and K to their oxides), g O₂ per g compound.
 */
export function theoreticalOxygenDemand(counts, elements) {
    const get = (symbol) => counts.get(symbol) ?? 0;
    // Alkali metals end as the oxide M₂O (¼ O₂ each), as for the KHP standard (1.176 g O₂/g).
    const oxygen = get('C') + (get('H') - 3 * get('N')) / 4 - get('O') / 2 + (get('Na') + get('K')) / 4;
    const weight = [...counts].reduce((sum, [symbol, count]) => sum + elements[symbol].weight * count, 0);

    return (oxygen * 2 * elements.O.weight) / weight;
}

/**
 * Linear interpolation in sorted [x, …, y] rows.
 */
function interpolate(points, x, xIndex, yIndex) {
    for (let k = 1; k < points.length; k += 1) {
        if (x <= points[k][xIndex]) {
            const [a, b] = [points[k - 1], points[k]];

            return a[yIndex] + ((b[yIndex] - a[yIndex]) * (x - a[xIndex])) / (b[xIndex] - a[xIndex]);
        }
    }

    return null;
}

export const handlers = {
    cod: (i, c, f) => {
        if (i.mode === 'theoretical') {
            const formula = read(i.formula, c.data.elements);

            if (!formula.parsed) {
                return formula;
            }

            const unsupported = [...formula.parsed.counts.keys()].filter((symbol) => !['C', 'H', 'O', 'N', 'Na', 'K'].includes(symbol));

            if (unsupported.length) {
                return { error: `Only C, H, O, N, Na and K are covered (found ${unsupported.join(', ')}).` };
            }

            const ratio = theoreticalOxygenDemand(formula.parsed.counts, c.data.elements);
            const mgPerLiter = i.concentration > 0 ? ratio * i.concentration : null;

            return { value: f(ratio), unit: 'g O₂/g', label: `Theoretical oxygen demand of ${formula.parsed.text}`, sub: 'Complete oxidation to CO₂ and H₂O, nitrogen released as NH₃', rows: { cod: mgPerLiter === null ? 'Enter a concentration' : `${f(mgPerLiter)} mg/L O₂`, weight: `${f(weightOf(formula.parsed, c.data.elements))} g/mol` } };
        }

        if (missing(i, 'blank', 'sample_titrant', 'normality', 'sample_volume') || !(i.sample_volume > 0) || !(i.normality > 0)) {
            return { empty: 'Enter the blank and sample titrant volumes, the FAS normality and the sample volume.' };
        }

        if (i.sample_titrant > i.blank) {
            return { error: 'The sample titration cannot use more titrant than the blank.' };
        }

        const cod = ((i.blank - i.sample_titrant) * i.normality * 8000) / i.sample_volume;

        return { value: f(Math.round(cod * 10) / 10), unit: 'mg/L O₂', label: 'Chemical oxygen demand', sub: 'COD = (A − B) × N × 8000 ÷ sample mL (dichromate reflux, Standard Methods 5220)', rows: { cod: `${f(cod / 1000)} g/L`, weight: `${f(i.blank - i.sample_titrant)} mL titrant consumed` } };
    },

    combustion_analysis: (i, c, f) => {
        if (missing(i, 'sample', 'co2', 'h2o') || !(i.sample > 0) || !(i.co2 > 0) || !(i.h2o >= 0)) {
            return { empty: 'Enter the sample mass and the masses of CO₂ and H₂O formed.' };
        }

        const e = c.data.elements;
        const co2 = e.C.weight + 2 * e.O.weight;
        const water = 2 * e.H.weight + e.O.weight;
        const carbon = (i.co2 * e.C.weight) / co2;
        const hydrogen = (i.h2o * 2 * e.H.weight) / water;
        const nitrogen = i.n_mass > 0 ? i.n_mass : 0;
        const oxygen = i.sample - carbon - hydrogen - nitrogen;

        if (oxygen < -1e-6 * i.sample) {
            return { error: 'Carbon and hydrogen add up to more than the sample; check the masses.' };
        }

        const amounts = [['C', carbon / e.C.weight], ['H', hydrogen / e.H.weight], ['N', nitrogen / e.N.weight], ['O', Math.max(0, oxygen) / e.O.weight]].filter(([, moles]) => moles > 1e-9 * i.sample);
        const smallest = Math.min(...amounts.map(([, moles]) => moles));
        let counts = null;
        let multiplier = 1;

        for (; multiplier <= 12; multiplier += 1) {
            if (amounts.every(([, moles]) => Math.abs((moles / smallest) * multiplier - Math.round((moles / smallest) * multiplier)) <= 0.08)) {
                counts = new Map(amounts.map(([symbol, moles]) => [symbol, Math.round((moles / smallest) * multiplier)]));
                break;
            }
        }

        if (!counts) {
            return { error: 'No whole-number ratio up to ×12 fits these masses; check the data.' };
        }

        const empiricalMass = [...counts].reduce((sum, [symbol, count]) => sum + e[symbol].weight * count, 0);
        let molecular = 'Enter a molar mass';

        if (i.molar_mass > 0) {
            const n = Math.round(i.molar_mass / empiricalMass);
            molecular = n >= 1 && Math.abs(i.molar_mass / empiricalMass - n) < 0.05 * n ? hillFormula(new Map([...counts].map(([symbol, count]) => [symbol, count * n]))) : 'Molar mass is not a whole multiple of the empirical formula';
        }

        return {
            value: hillFormula(counts),
            unit: '',
            label: 'Empirical formula',
            sub: `C ${f((carbon / i.sample) * 100)}%, H ${f((hydrogen / i.sample) * 100)}%, O by difference ${f((Math.max(0, oxygen) / i.sample) * 100)}%`,
            rows: { molecular, carbon: `${f(carbon)} g C`, hydrogen: `${f(hydrogen)} g H`, oxygen: `${f(Math.max(0, oxygen))} g O (by difference)` },
        };
    },

    combustion_reaction: (i, c, f) => {
        const formula = read(i.fuel, c.data.elements);

        if (!formula.parsed) {
            return formula;
        }

        const counts = formula.parsed.counts;
        const unsupported = [...counts.keys()].filter((symbol) => !['C', 'H', 'O', 'N', 'S'].includes(symbol));

        if (unsupported.length) {
            return { error: `Fuels may contain only C, H, O, N and S (found ${unsupported.join(', ')}).` };
        }

        const products = [counts.has('C') ? 'CO2' : null, counts.has('H') ? 'H2O' : null, counts.has('S') ? 'SO2' : null, counts.has('N') ? 'N2' : null].filter(Boolean);
        let result;

        try {
            result = balance(`${i.fuel} + O2 = ${products.join(' + ')}`, c.data.elements);
        } catch (error) {
            if (error instanceof BalanceError) {
                return { error: error.message };
            }

            throw error;
        }

        const fuelCoefficient = result.coefficients[0];
        const oxygen = result.coefficients[1] / fuelCoefficient;
        const fuelWeight = weightOf(formula.parsed, c.data.elements);
        const productAmounts = result.products.map((item, index) => `${f(result.coefficients[2 + index] / fuelCoefficient)} mol ${item.text}`);

        return {
            value: formatEquation(result),
            unit: '',
            label: `Complete combustion of ${formula.parsed.text}`,
            sub: 'Balanced exactly; nitrogen leaves as N₂ and sulfur as SO₂',
            rows: { oxygen: `${f(oxygen)} mol O₂ per mol fuel (${f((oxygen * 31.998) / fuelWeight)} g per g)`, products: productAmounts.join(', '), air: `${f((oxygen * 28.9644) / 0.20946 / fuelWeight)} g of air per g of fuel` },
        };
    },

    crude_protein: (i, c, f) => {
        const factor = i.food === 'custom' ? i.factor : c.data.jones[i.food]?.factor;

        if (missing(i, 'nitrogen') || !(factor > 0) || i.nitrogen < 0) {
            return { empty: 'Enter the nitrogen content and choose a factor.' };
        }

        if (i.nitrogen > 30) {
            return { error: 'Nitrogen above 30% is not possible for foods; check the value.' };
        }

        const protein = i.nitrogen * factor;

        return { value: f(Math.round(protein * 100) / 100), unit: '%', label: 'Crude protein', sub: `${f(i.nitrogen)}% N × ${factor}`, rows: { factor: `${factor}${i.food === 'custom' ? ' (your value)' : ` (${c.data.jones[i.food].name}, FAO)`}`, general: `${f(Math.round(i.nitrogen * 6.25 * 100) / 100)}% with the general 6.25`, per100: `${f(protein)} g per 100 g` } };
    },

    unsaturation: (i, c, f) => {
        const formula = read(i.formula, c.data.elements);

        if (!formula.parsed) {
            return formula;
        }

        if (formula.parsed.charge !== 0) {
            return { error: 'Enter a neutral molecular formula.' };
        }

        const value = degreeOfUnsaturation(formula.parsed.counts);

        if (value < 0 || !Number.isInteger(value)) {
            return { error: `That gives ${f(value)}, which is not possible for a neutral closed-shell molecule; check the hydrogen count.` };
        }

        return {
            value: String(value),
            unit: value === 1 ? 'degree' : 'degrees',
            label: `Degree of unsaturation of ${formula.parsed.text}`,
            sub: value === 0 ? 'Saturated: no rings or multiple bonds' : `Rings + π bonds = ${value}; also called the double bond equivalent (DBE)`,
            rows: { meaning: value >= 4 ? 'Four or more: consider a benzene ring' : value === 2 ? 'Two: a triple bond, two double bonds, two rings, or one of each' : value === 1 ? 'One ring or one double bond' : 'Only single bonds, no rings', hill: hillFormula(formula.parsed.counts) },
        };
    },

    ethylene_density: (i, c, f) => {
        const points = c.data.ethylene.saturated_liquid.points;

        if (missing(i, 'temperature')) {
            return { empty: 'Enter the temperature.' };
        }

        const T = i.temperature + 273.15;
        const [low, high] = [points[0][0], points[points.length - 1][0]];

        if (T < low || T > high) {
            return { error: `Saturated liquid ethylene exists from the triple point (${f(low - 273.15)} °C) to the critical point (${f(high - 273.15)} °C).` };
        }

        const density = interpolate(points, T, 0, 2);
        const pressure = interpolate(points, T, 0, 1);

        return {
            value: f(Math.round(density * 1000) / 1000),
            unit: 'kg/m³',
            label: 'Saturated liquid ethylene density',
            sub: `At ${f(i.temperature)} °C and its vapor pressure ${f(pressure)} MPa (NIST data, interpolated)`,
            rows: { lb: `${f(density * 0.0624279606)} lb/ft³`, volume: `${f(1 / density)} m³/kg`, pressure: `${f(pressure)} MPa (${f(pressure * 10)} bar)` },
        };
    },

    radiocarbon: (i, c, f) => {
        let fraction;

        if (i.input === 'percent') {
            if (!(i.value > 0) || i.value > 100) {
                return { empty: 'Enter the percent of modern carbon remaining (0 to 100).' };
            }

            fraction = i.value / 100;
        } else if (i.input === 'fraction') {
            if (!(i.value > 0) || i.value > 1.5) {
                return { empty: 'Enter F¹⁴C (fraction modern), usually 0 to 1.' };
            }

            fraction = i.value;
        } else {
            if (!(i.value > 0) || !(i.modern > 0)) {
                return { empty: 'Enter the sample and modern activities.' };
            }

            fraction = i.value / i.modern;
        }

        // Conventional radiocarbon age uses the Libby half-life (5568 y): t = −8033 ln F.
        const conventional = -8033 * Math.log(fraction);
        const decay = (-5700 / Math.LN2) * Math.log(fraction);

        return {
            value: f(Math.round(conventional)),
            unit: 'years BP',
            label: 'Conventional radiocarbon age',
            sub: conventional > 50000 ? 'Beyond about 50,000 years too little ¹⁴C is left for reliable dating' : 'Libby half-life 5568 y, before present (1950); not calibrated to calendar years',
            rows: { decay: `${f(Math.round(decay))} years with the measured half-life (5700 y, NUBASE2020)`, fraction: `${f(fraction)} of modern ¹⁴C`, halves: `${f(-Math.log(fraction) / Math.LN2)} half-lives` },
        };
    },
};

export default defineTools(handlers);
