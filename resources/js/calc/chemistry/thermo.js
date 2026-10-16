import { hillFormula, parseFormula } from './formula.js';

/**
 * Thermodynamics: water saturation (IAPWS), the standard atmosphere, Antoine vapor pressures
 * and lookups in the standard thermodynamic table.
 */
export const R = 8.314462618;

/**
 * Saturation vapor pressure of liquid water, Pa: IAPWS SR1-86 (Wagner and Pruss), 273.16 to 647.096 K.
 */
export function waterSaturationPressure(kelvin) {
    const tc = 647.096;
    const pc = 22.064e6;
    const a = [-7.85951783, 1.84408259, -11.7866497, 22.6807411, -15.9618719, 1.80122502];
    const t = 1 - kelvin / tc;

    return pc * Math.exp((tc / kelvin) * (a[0] * t + a[1] * t ** 1.5 + a[2] * t ** 3 + a[3] * t ** 3.5 + a[4] * t ** 4 + a[5] * t ** 7.5));
}

/**
 * Sublimation pressure of ice Ih, Pa: IAPWS R14-08 (2011), 50 to 273.16 K.
 */
export function iceSublimationPressure(kelvin) {
    const theta = kelvin / 273.16;
    const a = [-0.212144006e2, 0.273203819e2, -0.61059813e1];
    const b = [0.333333333e-2, 0.120666667e1, 0.170333333e1];

    return 611.657 * Math.exp((a[0] * theta ** b[0] + a[1] * theta ** b[1] + a[2] * theta ** b[2]) / theta);
}

/**
 * Boiling point of water (K) at a pressure, by bisection on the IAPWS saturation curve.
 */
export function waterBoilingPoint(pascal) {
    if (pascal < 611.657 || pascal > 22.064e6) {
        throw new RangeError('Water boils between 611.657 Pa (triple point) and 22.064 MPa (critical point).');
    }

    let low = 273.16;
    let high = 647.096;

    for (let step = 0; step < 100; step += 1) {
        const middle = (low + high) / 2;

        if (waterSaturationPressure(middle) < pascal) {
            low = middle;
        } else {
            high = middle;
        }
    }

    return (low + high) / 2;
}

/**
 * Air pressure (Pa) at a geopotential altitude in the ICAO standard atmosphere (troposphere, up to 11 km).
 */
export function standardAtmosphere(meters) {
    if (meters < -610 || meters > 11000) {
        throw new RangeError('The standard atmosphere formula here covers −610 to 11,000 m.');
    }

    return 101325 * (1 - 2.25577e-5 * meters) ** 5.25588;
}

/**
 * Antoine parameter set for a temperature, choosing the narrowest NIST range that contains it.
 * Sets: [T min K, T max K, A, B, C, reference]; log10(P / bar) = A − B ÷ (T + C).
 */
export function antoineSetForTemperature(sets, kelvin) {
    return sets.filter(([min, max]) => kelvin >= min && kelvin <= max).sort((x, y) => x[1] - x[0] - (y[1] - y[0]))[0] ?? null;
}

export function antoinePressure(set, kelvin) {
    const [, , a, b, c] = set;

    return 10 ** (a - b / (kelvin + c)) * 1e5;
}

export function antoineTemperature(set, pascal) {
    const [, , a, b, c] = set;

    return b / (a - Math.log10(pascal / 1e5)) - c;
}

/**
 * Boiling point for a pressure: tries each NIST set and keeps a result that lies inside its own range.
 */
export function antoineBoilingPoint(sets, pascal) {
    const found = sets
        .map((set) => ({ set, kelvin: antoineTemperature(set, pascal) }))
        .filter(({ set, kelvin }) => kelvin >= set[0] && kelvin <= set[1])
        .sort((x, y) => x.set[1] - x.set[0] - (y.set[1] - y.set[0]));

    return found[0] ?? null;
}

export const rangesText = (sets) => sets.map(([min, max]) => `${(min - 273.15).toFixed(1)} to ${(max - 273.15).toFixed(1)} °C`).join('; ');

/**
 * Clausius–Clapeyron: P₂ from a known point and the enthalpy of vaporization (J/mol).
 */
export function clausiusPressure(p1, t1, t2, enthalpy) {
    return p1 * Math.exp((-enthalpy / R) * (1 / t2 - 1 / t1));
}

export function clausiusTemperature(p1, t1, p2, enthalpy) {
    return 1 / (1 / t1 - (R * Math.log(p2 / p1)) / enthalpy);
}

/**
 * Index of the thermodynamic table by Hill formula, charge and phase, so "C2H5OH(l)", "C2H6O(l)" and
 * "CH3CH2OH(l)" all find the same entry.
 */
export function thermoIndex(table, elements) {
    const index = new Map();

    for (const [key, entry] of Object.entries(table)) {
        const match = /^(.+)\((s|l|g|aq)\)$/.exec(key);

        if (!match) {
            continue;
        }

        try {
            const parsed = parseFormula(match[1], elements);
            index.set(`${hillFormula(parsed.counts)}|${parsed.charge}|${match[2]}`, { ...entry, key });
        } catch {
            // Entries the parser cannot read are simply not indexed.
        }
    }

    return index;
}

export function lookupThermo(index, species) {
    return index.get(`${hillFormula(species.counts)}|${species.charge}|${species.phase}`) ?? null;
}
