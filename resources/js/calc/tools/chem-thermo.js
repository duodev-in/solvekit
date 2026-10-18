import { balance, BalanceError, formatEquation } from '../chemistry/balance.js';
import { FormulaError, molarMass, parseFormula } from '../chemistry/formula.js';
import { antoineBoilingPoint, antoinePressure, antoineSetForTemperature, clausiusPressure, clausiusTemperature, iceSublimationPressure, lookupThermo, R, rangesText, standardAtmosphere, thermoIndex, waterBoilingPoint, waterSaturationPressure } from '../chemistry/thermo.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Chemical thermodynamics: boiling and freezing points, vapor pressure, enthalpy, entropy, Gibbs energy.
 * Temperatures arrive in °C and pressures in Pa from unit menus; data sets arrive in config.data.
 */
const K = (celsius) => celsius + 273.15;
const STP = {
    iupac: { name: 'IUPAC STP (0 °C, 100 kPa)', t: 273.15, p: 100000 },
    atm: { name: '0 °C and 1 atm', t: 273.15, p: 101325 },
    ntp: { name: 'NTP (20 °C, 1 atm)', t: 293.15, p: 101325 },
    satp: { name: 'SATP (25 °C, 100 kPa)', t: 298.15, p: 100000 },
};

let cachedIndex = null;

function index(c) {
    if (!cachedIndex || cachedIndex.source !== c.data.thermo) {
        cachedIndex = { source: c.data.thermo, map: thermoIndex(c.data.thermo, c.data.elements) };
    }

    return cachedIndex.map;
}

function readEquation(text, elements) {
    if (!String(text ?? '').trim()) {
        return { empty: 'Enter a chemical equation with phases, e.g. CH4(g) + O2(g) = CO2(g) + H2O(l).' };
    }

    try {
        return { result: balance(text, elements) };
    } catch (error) {
        if (error instanceof BalanceError) {
            return { error: error.message };
        }

        throw error;
    }
}

/**
 * Standard reaction quantities from the table: ΔH°, ΔS°, ΔG° (from ΔfG° when available).
 */
export function reactionQuantities(result, c) {
    const table = index(c);
    const all = [...result.reactants.map((item, k) => [item, -result.coefficients[k]]), ...result.products.map((item, k) => [item, result.coefficients[result.reactants.length + k]])];
    const missingPhase = all.find(([item]) => !item.phase);

    if (missingPhase) {
        return { error: `Add a phase to ${missingPhase[0].text}, e.g. (s), (l), (g) or (aq).` };
    }

    const rows = [];
    let h = 0;
    let s = 0;
    let g = 0;
    let gComplete = true;

    for (const [item, nu] of all) {
        const entry = lookupThermo(table, item);

        if (!entry || entry.h === null || entry.s === null) {
            return { error: `${item.text} is not in the data table (311 substances); check the phase or formula.` };
        }

        h += nu * entry.h;
        s += nu * entry.s;

        if (entry.g === null) {
            gComplete = false;
        } else {
            g += nu * entry.g;
        }

        rows.push({ label: `${nu > 0 ? '+' : '−'}${Math.abs(nu)} ${item.text}`, value: `ΔfH° ${entry.h} · S° ${entry.s}${entry.g === null ? '' : ` · ΔfG° ${entry.g}`}` });
    }

    return { h, s, g: gComplete ? g : h - (298.15 * s) / 1000, gFromTable: gComplete, rows };
}

function pressureRows(pascal, f) {
    return { kpa: `${f(pascal / 1000)} kPa`, mmhg: `${f(pascal / 133.322368)} mmHg`, atm: `${f(pascal / 101325)} atm`, psi: `${f(pascal / 6894.757293)} psi` };
}

/**
 * K = exp(−ΔG ÷ RT), written as a power of ten when it is too large or small for a number.
 */
export function equilibriumConstant(gKj, kelvin, f) {
    const log10 = (-gKj * 1000) / (R * kelvin * Math.LN10);

    return Math.abs(log10) > 300 ? `10^${f(Math.round(log10 * 10) / 10)}` : f(10 ** log10);
}

export const handlers = {
    vapor_pressure: (i, c, f) => {
        if (i.mode === 'clausius') {
            if (missing(i, 't1', 'p1', 'enthalpy', 't2') || !(i.p1 > 0) || !(i.enthalpy > 0)) {
                return { empty: 'Enter a known point, the enthalpy of vaporization and the new temperature.' };
            }

            const pressure = clausiusPressure(i.p1, K(i.t1), K(i.t2), i.enthalpy * 1000);

            return { value: f(pressure / 1000), unit: 'kPa', label: `Vapor pressure at ${f(i.t2)} °C`, sub: 'Clausius–Clapeyron, assuming ΔHvap is constant over the range', rows: { ...pressureRows(pressure, f), source: 'Your data' } };
        }

        if (missing(i, 'temperature')) {
            return { empty: 'Enter the temperature.' };
        }

        const T = K(i.temperature);

        if (i.substance === 'water') {
            if (T < 50 || T > 647.096) {
                return { error: 'Water vapor pressure is defined here from −223 °C (ice) to the critical point, 373.946 °C.' };
            }

            const pressure = T < 273.16 ? iceSublimationPressure(T) : waterSaturationPressure(T);

            return { value: f(pressure / 1000), unit: 'kPa', label: `Vapor pressure of water at ${f(i.temperature)} °C`, sub: T < 273.16 ? 'Over ice: IAPWS 2011 sublimation equation' : 'IAPWS saturation equation (Wagner and Pruss)', rows: { ...pressureRows(pressure, f), source: 'IAPWS' } };
        }

        const substance = c.data.antoine[i.substance];
        const set = antoineSetForTemperature(substance.sets, T);

        if (!set) {
            return { error: `NIST has no Antoine data for ${substance.name} at ${f(i.temperature)} °C. Valid ranges: ${rangesText(substance.sets)}.` };
        }

        const pressure = antoinePressure(set, T);

        return { value: f(pressure / 1000), unit: 'kPa', label: `Vapor pressure of ${substance.name} at ${f(i.temperature)} °C`, sub: `Antoine equation, NIST WebBook (${set[5]})`, rows: { ...pressureRows(pressure, f), source: `A ${set[2]}, B ${set[3]}, C ${set[4]}; ${f(set[0] - 273.15)} to ${f(set[1] - 273.15)} °C` } };
    },

    boiling_point: (i, c, f) => {
        if (i.mode === 'clausius') {
            if (missing(i, 't1', 'p1', 'enthalpy', 'p2') || !(i.p1 > 0) || !(i.p2 > 0) || !(i.enthalpy > 0)) {
                return { empty: 'Enter a known boiling point and pressure, the enthalpy of vaporization and the new pressure.' };
            }

            const T = clausiusTemperature(i.p1, K(i.t1), i.p2, i.enthalpy * 1000);

            return { value: f(Math.round((T - 273.15) * 100) / 100), unit: '°C', label: 'Boiling point', sub: 'Clausius–Clapeyron, assuming ΔHvap is constant', rows: { kelvin: `${f(T)} K`, fahrenheit: `${f(((T - 273.15) * 9) / 5 + 32)} °F`, source: 'Your data' } };
        }

        if (!(i.pressure > 0)) {
            return { empty: 'Enter the pressure.' };
        }

        if (i.substance === 'water') {
            let T;

            try {
                T = waterBoilingPoint(i.pressure);
            } catch (error) {
                return { error: error.message };
            }

            return { value: f(Math.round((T - 273.15) * 100) / 100), unit: '°C', label: `Boiling point of water at ${f(i.pressure / 1000)} kPa`, sub: 'IAPWS saturation equation, solved for temperature', rows: { kelvin: `${f(T)} K`, fahrenheit: `${f(((T - 273.15) * 9) / 5 + 32)} °F`, source: 'IAPWS' } };
        }

        const substance = c.data.antoine[i.substance];
        const found = antoineBoilingPoint(substance.sets, i.pressure);

        if (!found) {
            return { error: `That pressure gives a boiling point outside NIST's data for ${substance.name} (${rangesText(substance.sets)}).` };
        }

        return { value: f(Math.round((found.kelvin - 273.15) * 100) / 100), unit: '°C', label: `Boiling point of ${substance.name}`, sub: `Antoine equation, NIST WebBook (${found.set[5]})`, rows: { kelvin: `${f(found.kelvin)} K`, fahrenheit: `${f(((found.kelvin - 273.15) * 9) / 5 + 32)} °F`, source: `Valid ${f(found.set[0] - 273.15)} to ${f(found.set[1] - 273.15)} °C` } };
    },

    boiling_altitude: (i, c, f) => {
        let pressure;

        if (i.mode === 'pressure') {
            if (!(i.pressure > 0)) {
                return { empty: 'Enter the air pressure.' };
            }

            pressure = i.pressure;
        } else {
            if (missing(i, 'altitude')) {
                return { empty: 'Enter the altitude.' };
            }

            try {
                pressure = standardAtmosphere(i.altitude);
            } catch (error) {
                return { error: error.message };
            }
        }

        const T = waterBoilingPoint(pressure) - 273.15;

        return {
            value: f(Math.round(T * 100) / 100),
            unit: '°C',
            label: 'Water boils at',
            sub: i.mode === 'pressure' ? `At ${f(pressure / 1000)} kPa (IAPWS)` : `Standard atmosphere: ${f(pressure / 1000)} kPa at ${f(i.altitude)} m; weather shifts this by about ±0.5 °C`,
            rows: { fahrenheit: `${f((T * 9) / 5 + 32)} °F`, pressure: `${f(pressure / 1000)} kPa (${f(pressure / 101325)} atm)`, drop: `${f(Math.round((99.97 - T) * 100) / 100)} °C below sea level` },
        };
    },

    colligative: (input, c, f) => {
        // Each page says which property it shows (data.kind: 'boiling' or 'freezing').
        const i = { ...input, kind: input.kind ?? c.data.kind };
        const solvent = c.data.solvents[i.solvent];
        const constant = i.kind === 'freezing' ? solvent.kf : solvent.kb;

        if (constant === undefined || constant === null) {
            return { error: `No ${i.kind === 'freezing' ? 'Kf' : 'Kb'} value for ${solvent.name} in the data.` };
        }

        let moles = i.moles;

        if (i.mode === 'mass') {
            if (!String(i.formula ?? '').trim() || !(i.solute_mass > 0)) {
                return { empty: 'Enter the solute formula and mass.' };
            }

            try {
                moles = i.solute_mass / molarMass(parseFormula(i.formula, c.data.elements), c.data.elements).total;
            } catch (error) {
                if (error instanceof FormulaError) {
                    return { error: error.message };
                }

                throw error;
            }
        } else if (!(moles > 0)) {
            return { empty: 'Enter the moles of solute.' };
        }

        if (!(i.solvent_mass > 0)) {
            return { empty: 'Enter the solvent mass.' };
        }

        const factor = i.vant_hoff > 0 ? i.vant_hoff : 1;
        const molality = moles / (i.solvent_mass / 1000);
        const change = factor * constant * molality;
        const normal = i.kind === 'freezing' ? solvent.tf : solvent.tb;
        const newPoint = normal === undefined || normal === null ? null : normal + (i.kind === 'freezing' ? -change : change);

        return {
            value: f(change),
            unit: '°C',
            label: i.kind === 'freezing' ? 'Freezing point depression ΔTf' : 'Boiling point elevation ΔTb',
            sub: `ΔT = i × K × b = ${f(factor)} × ${constant} × ${f(molality)} mol/kg`,
            rows: { new_point: newPoint === null ? `Normal point of ${solvent.name} not in the data` : `${f(newPoint)} °C`, molality: `${f(molality)} mol/kg`, constant: `${constant} K·kg/mol (${solvent.name})` },
        };
    },

    entropy: (i, c, f) => {
        if (i.mode === 'phase') {
            if (missing(i, 'enthalpy', 'temperature')) {
                return { empty: 'Enter the enthalpy of the phase change and its temperature.' };
            }

            const value = (i.enthalpy * 1000) / K(i.temperature);

            return { value: f(value), unit: 'J/(mol·K)', label: 'Entropy of the phase change', sub: `ΔS = ΔH ÷ T at ${f(K(i.temperature))} K`, rows: { kj: `${f(value / 1000)} kJ/(mol·K)`, method: 'ΔS = ΔH ÷ T' } };
        }

        if (i.mode === 'heating') {
            if (missing(i, 'mass', 'heat_capacity', 't1', 't2') || !(i.mass > 0) || !(i.heat_capacity > 0)) {
                return { empty: 'Enter the mass, specific heat and both temperatures.' };
            }

            const value = i.mass * i.heat_capacity * Math.log(K(i.t2) / K(i.t1));

            return { value: f(value), unit: 'J/K', label: 'Entropy change on heating', sub: 'ΔS = m c ln(T₂ ÷ T₁), constant heat capacity', rows: { kj: `${f(value / 1000)} kJ/K`, method: 'ΔS = m c ln(T₂/T₁)' } };
        }

        if (i.mode === 'expansion') {
            if (missing(i, 'moles', 'v1', 'v2') || !(i.v1 > 0) || !(i.v2 > 0)) {
                return { empty: 'Enter the moles and both volumes.' };
            }

            const value = i.moles * R * Math.log(i.v2 / i.v1);

            return { value: f(value), unit: 'J/K', label: 'Entropy change of expansion', sub: 'Ideal gas, constant temperature: ΔS = nR ln(V₂ ÷ V₁)', rows: { kj: `${f(value / 1000)} kJ/K`, method: 'ΔS = nR ln(V₂/V₁)' } };
        }

        const read = readEquation(i.equation, c.data.elements);

        if (!read.result) {
            return read;
        }

        const quantities = reactionQuantities(read.result, c);

        if (quantities.error) {
            return quantities;
        }

        return { value: f(quantities.s), unit: 'J/(mol·K)', label: 'Standard reaction entropy ΔS°', sub: formatEquation(read.result), rows: { kj: `${f(quantities.s / 1000)} kJ/(mol·K)`, method: 'Σ ν S°(products) − Σ ν S°(reactants)' }, lists: { terms: quantities.rows } };
    },

    gibbs: (i, c, f) => {
        const T = K(Number.isNaN(i.temperature) ? 25 : i.temperature);
        let g;
        let extra = {};

        if (i.mode === 'hs') {
            if (missing(i, 'enthalpy', 'entropy')) {
                return { empty: 'Enter ΔH and ΔS.' };
            }

            g = i.enthalpy - (T * i.entropy) / 1000;
            extra = { crossover: i.entropy !== 0 ? `${f((i.enthalpy * 1000) / i.entropy - 273.15)} °C (ΔG = 0)` : 'None' };
        } else if (i.mode === 'k') {
            if (!(i.k > 0)) {
                return { empty: 'Enter the equilibrium constant.' };
            }

            g = (-R * T * Math.log(i.k)) / 1000;
        } else if (i.mode === 'cell') {
            if (missing(i, 'potential', 'electrons') || !(i.electrons > 0)) {
                return { empty: 'Enter E° and the electrons transferred.' };
            }

            g = (-i.electrons * 96485.33212 * i.potential) / 1000;
        } else {
            const read = readEquation(i.equation, c.data.elements);

            if (!read.result) {
                return read;
            }

            const quantities = reactionQuantities(read.result, c);

            if (quantities.error) {
                return quantities;
            }

            g = Math.abs(T - 298.15) < 1e-9 ? quantities.g : quantities.h - (T * quantities.s) / 1000;
            extra = { crossover: quantities.s !== 0 ? `${f((quantities.h * 1000) / quantities.s - 273.15)} °C (ΔG = 0)` : 'None' };
        }

        return {
            value: f(Math.round(g * 1000) / 1000),
            unit: 'kJ/mol',
            label: 'Gibbs free energy change ΔG',
            sub: g < 0 ? 'Negative: spontaneous in the forward direction' : g > 0 ? 'Positive: not spontaneous as written' : 'Zero: at equilibrium',
            rows: { k: equilibriumConstant(g, T, f), kelvin: `${f(T)} K`, crossover: extra.crossover ?? 'Needs ΔH and ΔS' },
        };
    },

    phase_rule: (i, c, f) => {
        if (missing(i, 'components', 'phases') || i.components < 1 || i.phases < 1) {
            return { empty: 'Enter the number of components and phases.' };
        }

        const variables = i.constant === 'pressure' ? 1 : 2;
        const freedom = Math.round(i.components) - Math.round(i.phases) + variables;

        if (freedom < 0) {
            return { error: 'That many phases cannot coexist at equilibrium for this many components.' };
        }

        const words = ['invariant (a fixed point, like the triple point)', 'univariant (a line on the phase diagram)', 'bivariant (an area on the phase diagram)'];

        return { value: String(freedom), unit: freedom === 1 ? 'degree of freedom' : 'degrees of freedom', label: 'Degrees of freedom F', sub: `F = C − P + ${variables}: ${words[freedom] ?? `${freedom} variables can change`}`, rows: { formula: `${Math.round(i.components)} − ${Math.round(i.phases)} + ${variables}`, max: `${Math.round(i.components) + variables} phases at most` } };
    },

    combustion_heat: (i, c, f) => {
        if (i.mode === 'bomb') {
            if (missing(i, 'calorimeter', 'delta_t', 'sample') || !(i.calorimeter > 0) || !(i.sample > 0)) {
                return { empty: 'Enter the calorimeter constant, temperature rise and sample mass.' };
            }

            const heat = i.calorimeter * i.delta_t;
            const perGram = heat / i.sample;
            let perMole = null;

            if (String(i.fuel ?? '').trim()) {
                try {
                    perMole = perGram * molarMass(parseFormula(i.fuel, c.data.elements), c.data.elements).total;
                } catch (error) {
                    if (!(error instanceof FormulaError)) {
                        throw error;
                    }
                }
            }

            return { value: f(perGram), unit: 'kJ/g', label: 'Heat of combustion', sub: `q = C × ΔT = ${f(heat)} kJ released by ${f(i.sample)} g`, rows: { molar: perMole === null ? 'Enter the fuel formula' : `${f(perMole)} kJ/mol`, lhv: 'Needs the fuel formula and heats of formation', equation: 'Bomb calorimeter (constant volume, ΔU)' } };
        }

        let fuel;

        try {
            fuel = parseFormula(i.fuel, c.data.elements);
        } catch (error) {
            if (error instanceof FormulaError) {
                return String(i.fuel ?? '').trim() ? { error: error.message } : { empty: 'Enter the fuel formula.' };
            }

            throw error;
        }

        const counts = fuel.counts;
        const unsupported = [...counts.keys()].filter((symbol) => !['C', 'H', 'O', 'N', 'S'].includes(symbol));

        if (unsupported.length) {
            return { error: `Fuels may contain only C, H, O, N and S (found ${unsupported.join(', ')}).` };
        }

        let formation = i.formation;
        let source = 'Your value';

        if (Number.isNaN(formation)) {
            const entry = lookupThermo(index(c), { counts, charge: 0, phase: i.phase });

            if (!entry || entry.h === null) {
                return { error: `${fuel.text}(${i.phase}) is not in the data table; enter its ΔfH° instead.` };
            }

            formation = entry.h;
            source = `Table: ${entry.name}`;
        }

        const table = c.data.thermo;
        const co2 = (counts.get('C') ?? 0) * table['CO2(g)'].h;
        const so2 = (counts.get('S') ?? 0) * table['SO2(g)'].h;
        const water = ((counts.get('H') ?? 0) / 2);
        const higher = co2 + so2 + water * table['H2O(l)'].h - formation;
        const lower = co2 + so2 + water * table['H2O(g)'].h - formation;
        const weight = molarMass(fuel, c.data.elements).total;
        const oxygen = (counts.get('C') ?? 0) + (counts.get('H') ?? 0) / 4 + (counts.get('S') ?? 0) - (counts.get('O') ?? 0) / 2;

        return {
            value: f(Math.round(higher * 10) / 10),
            unit: 'kJ/mol',
            label: `Enthalpy of combustion of ${fuel.text}`,
            sub: `Higher heating value (water as liquid); ${f(-higher / weight)} kJ/g released`,
            rows: { molar: `${f(-higher / weight)} kJ/g (${f(-higher / weight / 4.184)} kcal/g)`, lhv: `${f(Math.round(lower * 10) / 10)} kJ/mol (water as vapor)`, equation: `${fuel.text} + ${f(oxygen)} O₂ → ${counts.get('C') ?? 0} CO₂ + ${f(water)} H₂O${counts.get('S') ? ` + ${counts.get('S')} SO₂` : ''}${counts.get('N') ? ` + ${f(counts.get('N') / 2)} N₂` : ''} · ΔfH° ${source}` },
        };
    },

    q10: (i, c, f) => {
        if (i.mode === 'predict') {
            if (missing(i, 'q10', 'r1', 't1', 't2') || !(i.q10 > 0)) {
                return { empty: 'Enter Q10, one rate and both temperatures.' };
            }

            const rate = i.r1 * i.q10 ** ((i.t2 - i.t1) / 10);

            return { value: f(rate), unit: '', label: `Rate at ${f(i.t2)} °C`, sub: `R₂ = R₁ × Q10^((T₂ − T₁) ÷ 10)`, rows: { factor: `${f(rate / i.r1)}×`, q10: f(i.q10) } };
        }

        if (missing(i, 'r1', 't1', 'r2', 't2') || !(i.r1 > 0) || !(i.r2 > 0) || i.t1 === i.t2) {
            return { empty: 'Enter two rates at two different temperatures.' };
        }

        const q10 = (i.r2 / i.r1) ** (10 / (i.t2 - i.t1));

        return { value: f(q10), unit: '', label: 'Q10 temperature coefficient', sub: q10 >= 2 && q10 <= 3 ? 'Typical of enzyme-driven biological processes (2 to 3)' : 'Q10 = (R₂ ÷ R₁)^(10 ÷ (T₂ − T₁))', rows: { factor: `${f(i.r2 / i.r1)}× over ${f(i.t2 - i.t1)} °C`, q10: f(q10) } };
    },

    stp: (i, c, f) => {
        const standard = STP[i.standard];
        let moles;

        if (i.mode === 'convert') {
            if (missing(i, 'volume', 'temperature', 'pressure') || !(i.volume > 0) || !(i.pressure > 0)) {
                return { empty: 'Enter the gas volume, temperature and pressure.' };
            }

            moles = (i.pressure * (i.volume / 1000)) / (R * K(i.temperature));
        } else if (i.amount_unit === 'g') {
            try {
                moles = i.amount / molarMass(parseFormula(i.formula, c.data.elements), c.data.elements).total;
            } catch (error) {
                if (error instanceof FormulaError) {
                    return { error: error.message };
                }

                throw error;
            }
        } else {
            moles = i.amount;
        }

        if (!(moles > 0)) {
            return { empty: 'Enter the amount of gas.' };
        }

        const molarVolume = (R * standard.t) / standard.p * 1000;

        return {
            value: f(moles * molarVolume),
            unit: 'L',
            label: `Volume at ${standard.name}`,
            sub: `Ideal gas: ${f(molarVolume)} L per mole at these conditions`,
            rows: { moles: `${f(moles)} mol`, molar: `${f(molarVolume)} L/mol`, all: Object.values(STP).map((item) => `${f(moles * (R * item.t) / item.p * 1000)} L (${item.name.split(' (')[0]})`).join(' · ') },
        };
    },

    water_vapor: (i, c, f) => {
        if (missing(i, 'temperature')) {
            return { empty: 'Enter the temperature.' };
        }

        const T = K(i.temperature);

        if (T < 50 || T > 647.096) {
            return { error: 'This covers −223 °C to the critical point at 373.946 °C.' };
        }

        const overIce = T < 273.16;
        const pressure = overIce ? iceSublimationPressure(T) : waterSaturationPressure(T);
        const supercooled = overIce && T >= 233.15 ? waterSaturationPressure(T) : null;

        return {
            value: f(pressure / 1000),
            unit: 'kPa',
            label: `Saturation vapor pressure at ${f(i.temperature)} °C`,
            sub: overIce ? 'Over ice (IAPWS 2011)' : 'Over liquid water (IAPWS)',
            rows: { ...pressureRows(pressure, f), hpa: `${f(pressure / 100)} hPa (mbar)`, supercooled: supercooled === null ? (overIce ? 'Below −40 °C, not defined' : 'Not applicable above 0 °C') : `${f(supercooled / 1000)} kPa over supercooled water` },
            lists: { table: [0, 10, 20, 25, 30, 40, 50, 60, 70, 80, 90, 100].map((celsius) => ({ label: `${celsius} °C`, value: `${f(Math.round(waterSaturationPressure(Math.max(273.16, K(celsius))) / 10) / 100)} kPa`, highlight: Math.abs(celsius - i.temperature) < 1e-9 })) },
        };
    },

    enthalpy_reaction: (i, c, f) => {
        const read = readEquation(i.equation, c.data.elements);

        if (!read.result) {
            return read;
        }

        const quantities = reactionQuantities(read.result, c);

        if (quantities.error) {
            return quantities;
        }

        return {
            value: f(Math.round(quantities.h * 10) / 10),
            unit: 'kJ/mol',
            label: 'Standard enthalpy of reaction ΔH°',
            sub: `${quantities.h < 0 ? 'Exothermic' : 'Endothermic'}: ${formatEquation(read.result)}`,
            rows: { s: `${f(Math.round(quantities.s * 10) / 10)} J/(mol·K)`, g: `${f(Math.round(quantities.g * 10) / 10)} kJ/mol${quantities.gFromTable ? '' : ' (from ΔH° − TΔS°)'}`, k: equilibriumConstant(quantities.g, 298.15, f) },
            lists: { terms: quantities.rows },
        };
    },

    specific_heat: (i, c, f) => {
        const water = c.data.specific_heats.water.c;

        if (i.mode === 'calorimetry') {
            if (missing(i, 'metal_mass', 'metal_t', 'water_mass', 'water_t', 'final_t') || !(i.metal_mass > 0) || !(i.water_mass > 0)) {
                return { empty: 'Enter both masses, both starting temperatures and the final temperature.' };
            }

            const heatGained = i.water_mass * water * (i.final_t - i.water_t);
            const heat = heatGained / (i.metal_mass * (i.metal_t - i.final_t));

            if (!(heat > 0)) {
                return { error: 'The final temperature must lie between the starting temperatures.' };
            }

            const nearest = Object.values(c.data.specific_heats).reduce((best, item) => (Math.abs(item.c - heat) < Math.abs(best.c - heat) ? item : best));

            return { value: f(heat), unit: 'J/(g·K)', label: 'Specific heat of the sample', sub: `Heat lost by the sample = heat gained by the water (${f(heatGained)} J)`, rows: { q: `${f(heatGained)} J`, closest: `${nearest.name} (${nearest.c} J/(g·K))`, kj: `${f(heatGained / 1000)} kJ` } };
        }

        const c0 = i.material === 'custom' ? i.c : c.data.specific_heats[i.material]?.c;
        const solve = i.solve;
        const values = { q: i.q, m: i.m, c: c0, dt: i.dt };
        const needs = { q: ['m', 'c', 'dt'], m: ['q', 'c', 'dt'], c: ['q', 'm', 'dt'], dt: ['q', 'm', 'c'] }[solve];

        if (needs.some((name) => Number.isNaN(values[name]) || values[name] === undefined)) {
            return { empty: 'Enter the other three values.' };
        }

        const result = { q: values.m * values.c * values.dt, m: values.q / (values.c * values.dt), c: values.q / (values.m * values.dt), dt: values.q / (values.m * values.c) }[solve];

        if (!Number.isFinite(result)) {
            return { error: 'Check the values; one of them makes the equation divide by zero.' };
        }

        const labels = { q: ['Heat q', 'J'], m: ['Mass', 'g'], c: ['Specific heat', 'J/(g·K)'], dt: ['Temperature change', '°C'] };

        const heat = solve === 'q' ? result : values.q;
        const material = i.material === 'custom' ? `Custom, ${f(c0)} J/(g·K)` : `${c.data.specific_heats[i.material].name}, ${c0} J/(g·K)`;

        return { value: f(result), unit: labels[solve][1], label: labels[solve][0], sub: 'q = m × c × ΔT', rows: { q: `${f(heat / 1000)} kJ · ${f(heat / 4.184)} cal`, closest: material, kj: `${f(heat / 1055.06)} BTU` } };
    },
};

export default defineTools(handlers);
