import { AVOGADRO, BOLTZMANN, ELECTRON_MASS, ELECTRON_VOLT, GAS_CONSTANT, LIGHT, NEUTRON_MASS, PLANCK, PROTON_MASS, RYDBERG } from '../chemistry/constants.js';
import { fitTwoParameter, readPairs } from '../chemistry/fit.js';
import { FormulaError, molarMass, parseFormula } from '../chemistry/formula.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Physical chemistry: gas laws, effusion, diffusion, decay, surfaces, crystals and light.
 * Temperatures arrive in °C, pressures in Pa, volumes in L and lengths in m from unit menus.
 */
const K = (celsius) => celsius + 273.15;
const R = GAS_CONSTANT;

function weightFrom(text, elements) {
    try {
        const parsed = parseFormula(text, elements);

        return { weight: molarMass(parsed, elements).total, text: parsed.text };
    } catch (error) {
        if (error instanceof FormulaError) {
            return { error: error.message };
        }

        throw error;
    }
}

/**
 * Real roots of a cubic a x³ + b x² + c x + d (Cardano / trigonometric form).
 */
export function cubicRoots(a, b, c, d) {
    const p = (3 * a * c - b * b) / (3 * a * a);
    const q = (2 * b ** 3 - 9 * a * b * c + 27 * a * a * d) / (27 * a ** 3);
    const shift = -b / (3 * a);
    const discriminant = (q / 2) ** 2 + (p / 3) ** 3;

    if (discriminant > 1e-30) {
        const u = Math.cbrt(-q / 2 + Math.sqrt(discriminant));
        const v = Math.cbrt(-q / 2 - Math.sqrt(discriminant));

        return [u + v + shift];
    }

    const r = Math.sqrt(-p / 3);
    const phi = Math.acos(Math.max(-1, Math.min(1, (3 * q) / (2 * p * r))));

    return [0, 1, 2].map((k) => 2 * r * Math.cos(phi / 3 - (2 * Math.PI * k) / 3) + shift).sort((x, y) => x - y);
}

/** Atoms per cell, coordination number, edge from atomic radius (hard spheres). */
export const LATTICES = {
    sc: { name: 'Simple cubic', atoms: 1, coordination: 6, edge: (r) => 2 * r, packing: Math.PI / 6 },
    bcc: { name: 'Body-centred cubic', atoms: 2, coordination: 8, edge: (r) => (4 * r) / Math.sqrt(3), packing: (Math.PI * Math.sqrt(3)) / 8 },
    fcc: { name: 'Face-centred cubic', atoms: 4, coordination: 12, edge: (r) => 2 * Math.SQRT2 * r, packing: Math.PI / (3 * Math.SQRT2) },
    diamond: { name: 'Diamond cubic', atoms: 8, coordination: 4, edge: (r) => (8 * r) / Math.sqrt(3), packing: (Math.PI * Math.sqrt(3)) / 16 },
};

const gcd = (a, b) => (b ? gcd(b, a % b) : Math.abs(a));

/**
 * Surface tension of water in N/m, IAPWS R1-76 (2014): σ = B τ^μ (1 + b τ), τ = 1 − T/Tc.
 */
export function waterSurfaceTension(kelvin) {
    const tau = 1 - kelvin / 647.096;

    return 0.2358 * tau ** 1.256 * (1 - 0.625 * tau);
}

/**
 * Miller indices from axis intercepts (Infinity for a parallel plane), reduced to the smallest integers.
 */
export function millerFromIntercepts(intercepts) {
    const reciprocals = intercepts.map((value) => (Number.isFinite(value) ? 1 / value : 0));

    for (let multiplier = 1; multiplier <= 60; multiplier += 1) {
        const scaled = reciprocals.map((value) => value * multiplier);

        if (scaled.every((value) => Math.abs(value - Math.round(value)) < 1e-9)) {
            const integers = scaled.map(Math.round);
            const divisor = integers.reduce((acc, value) => gcd(acc, value), 0) || 1;

            return integers.map((value) => value / divisor);
        }
    }

    return null;
}

const millerText = (indices) => `(${indices.map((value) => (value < 0 ? `${Math.abs(value)}̅` : String(value))).join('')})`;

export const handlers = {
    ideal_gas: (i, c, f) => {
        const T = K(i.temperature);
        const n = i.moles;
        const V = i.volume / 1000;
        const P = i.pressure;
        const needs = { p: ['moles', 'volume', 'temperature'], v: ['moles', 'pressure', 'temperature'], n: ['pressure', 'volume', 'temperature'], t: ['pressure', 'volume', 'moles'] }[i.solve];

        if (missing(i, ...needs)) {
            return { empty: 'Enter the other three values.' };
        }

        const result = { p: (n * R * T) / V, v: ((n * R * T) / P) * 1000, n: (P * V) / (R * T), t: (P * V) / (n * R) - 273.15 }[i.solve];

        if (!Number.isFinite(result) || (i.solve !== 't' && result <= 0)) {
            return { error: 'Check the values: they must be positive and the temperature above absolute zero.' };
        }

        const shown = { p: [f(result / 1000), 'kPa', 'Pressure'], v: [f(result), 'L', 'Volume'], n: [f(result), 'mol', 'Amount of gas'], t: [f(result), '°C', 'Temperature'] }[i.solve];
        const moles = i.solve === 'n' ? result : n;
        const volume = i.solve === 'v' ? result : i.volume;

        return { value: shown[0], unit: shown[1], label: shown[2], sub: 'PV = nRT, R = 8.314 462 618 J/(mol·K)', rows: { atm: i.solve === 'p' ? `${f(result / 101325)} atm` : `${f(P / 101325)} atm`, molar: `${f(volume / moles)} L/mol`, kelvin: `${f(i.solve === 't' ? result + 273.15 : T)} K` } };
    },

    combined_gas: (i, c, f) => {
        const law = i.law;
        const T1 = K(i.t1);
        const T2 = K(i.t2);
        const fixedT = law === 'boyle';
        const fixedP = law === 'charles';
        const fixedV = law === 'gay_lussac';
        const p1 = fixedP ? 1 : i.p1;
        const v1 = fixedV ? 1 : i.v1;
        const t1 = fixedT ? 1 : T1;
        const p2 = fixedP ? 1 : i.p2;
        const t2 = fixedT ? 1 : T2;

        if ([p1, v1, t1, p2, t2].some((value) => Number.isNaN(value)) || p1 <= 0 || v1 <= 0 || t1 <= 0 || p2 <= 0 || t2 <= 0) {
            return { empty: 'Enter the starting state and the new conditions.' };
        }

        if (fixedV) {
            const pressure = (i.p1 * T2) / T1;

            return { value: f(pressure / 1000), unit: 'kPa', label: 'New pressure', sub: "Gay-Lussac's law: P₁ ÷ T₁ = P₂ ÷ T₂ (constant volume)", rows: { ratio: `${f(pressure / i.p1)}×`, law: "Gay-Lussac's law" } };
        }

        const volume = (p1 * v1 * t2) / (t1 * p2);
        const name = { combined: 'Combined gas law: P₁V₁ ÷ T₁ = P₂V₂ ÷ T₂', boyle: "Boyle's law: P₁V₁ = P₂V₂ (constant temperature)", charles: "Charles's law: V₁ ÷ T₁ = V₂ ÷ T₂ (constant pressure)" }[law];

        return { value: f(volume), unit: 'L', label: 'New volume', sub: name, rows: { ratio: `${f(volume / v1)}×`, law: name.split(':')[0] } };
    },

    van_der_waals: (i, c, f) => {
        const gas = i.gas === 'custom' ? { name: 'Custom gas', a: i.a, b: i.b } : c.data.vdw[i.gas];

        if (!gas || !(gas.a >= 0) || !(gas.b > 0)) {
            return { empty: 'Pick a gas or enter a and b.' };
        }

        // a in L²·bar/mol², b in L/mol; work in bar and L.
        const Rb = 0.0831446262;
        const n = i.moles;
        const T = K(i.temperature);
        const V = i.volume;
        const P = i.pressure / 1e5;

        if (!(n > 0)) {
            return { empty: 'Enter the amount of gas.' };
        }

        let result;
        let ideal;

        if (i.solve === 'p') {
            if (!(V > n * gas.b) || !(T > 0)) {
                return { error: 'The volume must be larger than n × b, the volume of the molecules themselves.' };
            }

            result = (n * Rb * T) / (V - n * gas.b) - (gas.a * n * n) / (V * V);
            ideal = (n * Rb * T) / V;
        } else if (i.solve === 't') {
            if (!(V > n * gas.b) || !(P > 0)) {
                return { empty: 'Enter the pressure and a volume larger than n × b.' };
            }

            result = ((P + (gas.a * n * n) / (V * V)) * (V - n * gas.b)) / (n * Rb);
            ideal = (P * V) / (n * Rb);
        } else {
            if (!(P > 0) || !(T > 0)) {
                return { empty: 'Enter the pressure and temperature.' };
            }

            // P V³ − (P n b + n R T) V² + a n² V − a b n³ = 0; the largest root is the gas-like volume.
            const roots = cubicRoots(P, -(P * n * gas.b + n * Rb * T), gas.a * n * n, -gas.a * gas.b * n ** 3).filter((root) => root > n * gas.b);
            result = Math.max(...roots);
            ideal = (n * Rb * T) / P;
        }

        const shown = { p: [f(result * 100), 'kPa', 'Pressure'], t: [f(result - 273.15), '°C', 'Temperature'], v: [f(result), 'L', 'Volume'] }[i.solve];
        const pressure = i.solve === 'p' ? result : P;
        const volume = i.solve === 'v' ? result : V;
        const temperature = i.solve === 't' ? result : T;
        const z = (pressure * volume) / (n * Rb * temperature);

        return {
            value: shown[0],
            unit: shown[1],
            label: `${shown[2]} of ${gas.name}`,
            sub: '(P + an²/V²)(V − nb) = nRT',
            rows: { ideal: i.solve === 'p' ? `${f(ideal * 100)} kPa` : i.solve === 't' ? `${f(ideal - 273.15)} °C` : `${f(ideal)} L`, z: `${f(z)} (1 for an ideal gas)`, constants: `a ${gas.a} L²·bar/mol², b ${gas.b} L/mol` },
        };
    },

    effusion: (i, c, f) => {
        const one = weightFrom(i.gas1, c.data.elements);
        const two = weightFrom(i.gas2, c.data.elements);

        if (one.error || two.error) {
            return { error: one.error ?? two.error };
        }

        const ratio = Math.sqrt(two.weight / one.weight);
        const T = K(Number.isNaN(i.temperature) ? 25 : i.temperature);
        const rms = (weight) => Math.sqrt((3 * R * T) / (weight / 1000));

        return {
            value: f(ratio),
            unit: '× as fast',
            label: `${one.text} effuses relative to ${two.text}`,
            sub: "Graham's law: rate₁ ÷ rate₂ = √(M₂ ÷ M₁)",
            rows: { time: `${f(1 / ratio)}× the time of ${two.text}`, rms1: `${f(rms(one.weight))} m/s for ${one.text}`, rms2: `${f(rms(two.weight))} m/s for ${two.text}`, rate: i.rate2 > 0 ? `${f(i.rate2 * ratio)} if ${two.text} is ${f(i.rate2)}` : `Enter the rate of ${two.text}` },
        };
    },

    diffusion: (i, c, f) => {
        if (i.mode === 'distance') {
            if (missing(i, 'distance', 'time') || !(i.distance > 0) || !(i.time > 0)) {
                return { empty: 'Enter the mean distance and time.' };
            }

            // Distance in µm.
            const d = ((i.distance * 1e-6) ** 2) / (2 * i.time);

            return { value: f(d), unit: 'm²/s', label: 'Diffusion coefficient', sub: 'From ⟨x²⟩ = 2Dt (one dimension)', rows: { cm: `${f(d * 1e4)} cm²/s`, time_mm: `${f(1e-6 / (2 * d))} s to move 1 mm`, radius: 'Not needed for bead tracking' } };
        }

        if (missing(i, 'temperature', 'viscosity', 'radius') || !(i.viscosity > 0) || !(i.radius > 0)) {
            return { empty: 'Enter the temperature, viscosity and particle radius.' };
        }

        const T = K(i.temperature);
        // Viscosity in mPa·s, radius in nm.
        const d = (BOLTZMANN * T) / (6 * Math.PI * (i.viscosity / 1000) * (i.radius * 1e-9));

        return { value: f(d), unit: 'm²/s', label: 'Diffusion coefficient', sub: 'Stokes–Einstein: D = kT ÷ (6πηr) for a sphere much larger than the solvent molecules', rows: { cm: `${f(d * 1e4)} cm²/s`, time_mm: `${f(1e-6 / (2 * d))} s to move 1 mm`, radius: `${f(i.radius)} nm` } };
    },

    half_life: (i, c, f) => {
        const solve = i.solve;
        let { initial, remaining, time, half } = { initial: i.initial, remaining: i.remaining, time: i.time, half: i.half_life };

        if (solve === 'remaining') {
            if (!(initial > 0) || !(time >= 0) || !(half > 0)) {
                return { empty: 'Enter the initial amount, time and half-life.' };
            }

            remaining = initial * 0.5 ** (time / half);
        } else if (solve === 'half') {
            if (!(initial > 0) || !(remaining > 0) || !(time > 0) || remaining >= initial) {
                return { empty: 'Enter the initial and a smaller remaining amount, and the time.' };
            }

            half = (time * Math.LN2) / Math.log(initial / remaining);
        } else if (solve === 'time') {
            if (!(initial > 0) || !(remaining > 0) || !(half > 0) || remaining > initial) {
                return { empty: 'Enter the initial and remaining amounts and the half-life.' };
            }

            time = (half * Math.log(initial / remaining)) / Math.LN2;
        } else {
            if (!(remaining > 0) || !(time >= 0) || !(half > 0)) {
                return { empty: 'Enter the remaining amount, time and half-life.' };
            }

            initial = remaining / 0.5 ** (time / half);
        }

        const lambda = Math.LN2 / half;
        const shown = { remaining: [f(remaining), 'Amount remaining'], half: [f(half), 'Half-life'], time: [f(time), 'Time elapsed'], initial: [f(initial), 'Initial amount'] }[solve];

        return {
            value: shown[0],
            unit: solve === 'half' || solve === 'time' ? 'time units' : '',
            label: shown[1],
            sub: `N = N₀ (½)^(t ÷ t½): ${f(time / half)} half-lives`,
            rows: { lambda: `${f(lambda)} per time unit`, mean: `${f(1 / lambda)} time units (τ = t½ ÷ ln 2)`, fraction: `${f((remaining / initial) * 100)}% left` },
            lists: { halves: [1, 2, 3, 4, 5, 10].map((k) => ({ label: `${k} half-li${k === 1 ? 'fe' : 'ves'} (${f(k * half)})`, value: `${f(initial * 0.5 ** k)} (${f(100 * 0.5 ** k)}%)` })) },
        };
    },

    radioactive_decay: (i, c, f) => {
        const isotope = i.isotope === 'custom' ? null : c.data.isotopes[i.isotope];
        const half = isotope ? isotope.half_life_s : i.half_life;

        if (!(half > 0) || !(i.initial > 0) || !(i.time >= 0) || missing(i, 'time')) {
            return { empty: 'Enter the initial amount, the time and the half-life (or pick an isotope).' };
        }

        const lambda = Math.LN2 / half;
        const left = i.initial * Math.exp(-lambda * i.time);
        let activity = 'Pick an isotope and give the amount in grams or Bq';

        if (isotope && i.amount_unit === 'g') {
            const atoms = (left / isotope.a) * AVOGADRO;
            const becquerel = lambda * atoms;
            activity = `${f(becquerel)} Bq (${f(becquerel / 3.7e10)} Ci)`;
        } else if (i.amount_unit === 'bq') {
            activity = `${f(left)} Bq (${f(left / 3.7e10)} Ci)`;
        }

        const year = 365.2422 * 86400;

        return {
            value: f(left),
            unit: { g: 'g', bq: 'Bq', percent: '%', atoms: 'atoms' }[i.amount_unit],
            label: 'Amount remaining',
            sub: isotope ? `${isotope.name}: half-life ${isotope.shown} (NUBASE2020)` : `Half-life ${f(half)} s`,
            rows: { fraction: `${f((left / i.initial) * 100)}% left after ${f(i.time / half)} half-lives`, lambda: `${f(lambda)} s⁻¹`, half: `${f(half / year)} years (${f(half / 86400)} days)`, activity },
        };
    },

    langmuir: (i, c, f) => {
        if (i.mode === 'fit') {
            const read = readPairs(i.data);

            if (read.error) {
                return read;
            }

            if (read.pairs.length < 3) {
                return { empty: 'Enter at least three points: pressure (or concentration) and amount adsorbed.' };
            }

            const qMax = Math.max(...read.pairs.map(([, q]) => q));
            const fit = fitTwoParameter((p, max, k) => (max * k * p) / (1 + k * p), read.pairs, [qMax * 1.2, 1 / read.pairs[Math.floor(read.pairs.length / 2)][0]]);

            return {
                value: f(fit.p),
                unit: 'q max',
                label: 'Langmuir fit: maximum adsorption',
                sub: `K = ${f(fit.q)}; R² = ${f(Math.round(fit.r2 * 1e6) / 1e6)} (non-linear least squares)`,
                rows: { k: f(fit.q), r2: f(fit.r2), coverage: 'Switch to coverage to get θ at a pressure' },
                plots: { isotherm: { series: Array.from({ length: 81 }, (_, k) => { const p = (Math.max(...read.pairs.map(([x]) => x)) * k) / 80; return [p, (fit.p * fit.q * p) / (1 + fit.q * p)]; }), markers: read.pairs.map(([x, y]) => ({ x, y })), xLabel: 'Pressure or concentration', yLabel: 'Adsorbed' } },
            };
        }

        if (missing(i, 'k', 'pressure') || !(i.k > 0) || i.pressure < 0) {
            return { empty: 'Enter K and the pressure or concentration.' };
        }

        const theta = (i.k * i.pressure) / (1 + i.k * i.pressure);

        return { value: f(theta), unit: 'θ', label: 'Fractional surface coverage', sub: 'θ = KP ÷ (1 + KP)', rows: { k: f(i.k), r2: 'Fit mode only', coverage: i.q_max > 0 ? `${f(theta * i.q_max)} adsorbed` : `${f(theta * 100)}% of sites` } };
    },

    osmotic: (i, c, f) => {
        const T = K(i.temperature);
        const factor = i.vant_hoff > 0 ? i.vant_hoff : 1;

        if (i.mode === 'molar_mass') {
            if (!(i.pressure > 0) || !(i.mass > 0) || !(i.volume > 0)) {
                return { empty: 'Enter the measured pressure, solute mass and solution volume.' };
            }

            const molar = i.pressure / (factor * R * T);
            const weight = i.mass / (molar * (i.volume / 1000) * 1000);

            return { value: f(weight), unit: 'g/mol', label: 'Molar mass of the solute', sub: 'From Π = iMRT', rows: { atm: `${f(i.pressure / 101325)} atm`, molar: `${f(molar / 1000)} mol/L`, mmhg: `${f(i.pressure / 133.322368)} mmHg` } };
        }

        if (!(i.molarity > 0) || !(T > 0)) {
            return { empty: 'Enter the molarity and temperature.' };
        }

        const pressure = factor * i.molarity * 1000 * R * T;

        return { value: f(pressure / 1000), unit: 'kPa', label: 'Osmotic pressure Π', sub: "van 't Hoff: Π = iMRT (dilute solutions)", rows: { atm: `${f(pressure / 101325)} atm`, molar: `${f(i.molarity)} mol/L`, mmhg: `${f(pressure / 133.322368)} mmHg` } };
    },

    partial_pressure: (i, c, f) => {
        const lines = String(i.gases ?? '').split(/\n|;/).map((line) => line.trim()).filter(Boolean);

        if (lines.length < 1) {
            return { empty: 'Enter each gas and its amount, one per line.' };
        }

        const gases = [];

        for (const [index, line] of lines.entries()) {
            const match = /^(\S+)\s+([\d.]+(?:e-?\d+)?)$/i.exec(line);

            if (!match) {
                return { error: `Line ${index + 1}: write a gas and a number, e.g. N2 0.78.` };
            }

            gases.push({ name: match[1], amount: Number(match[2]) });
        }

        const total = gases.reduce((sum, gas) => sum + gas.amount, 0);
        let pressure;

        if (i.mode === 'fractions') {
            if (!(i.total_pressure > 0)) {
                return { empty: 'Enter the total pressure.' };
            }

            pressure = i.total_pressure;
        } else {
            if (!(i.volume > 0)) {
                return { empty: 'Enter the volume and temperature.' };
            }

            pressure = (total * R * K(i.temperature)) / (i.volume / 1000);
        }

        return {
            value: f(pressure / 1000),
            unit: 'kPa',
            label: 'Total pressure',
            sub: "Dalton's law: pᵢ = xᵢ × P total",
            rows: { atm: `${f(pressure / 101325)} atm`, moles: i.mode === 'moles' ? `${f(total)} mol` : `fractions add to ${f(total)}` },
            lists: { gases: gases.map((gas) => ({ label: gas.name, value: `x = ${f(gas.amount / total)} · ${f(((gas.amount / total) * pressure) / 1000)} kPa` })) },
        };
    },

    two_photon: (i, c, f) => {
        if (missing(i, 'wavelength', 'density') || !(i.wavelength > 0) || !(i.density > 0)) {
            return { empty: 'Enter the wavelength and the number density of molecules.' };
        }

        // σ₂ = ħω β ÷ N; β in cm/GW → m/W, N in molecules/cm³ → /m³; 1 GM = 10⁻⁵⁸ m⁴·s.
        const photon = (PLANCK * LIGHT) / (i.wavelength * 1e-9);
        const n = i.density * 1e6;

        if (i.direction === 'beta') {
            if (!(i.beta > 0)) {
                return { empty: 'Enter β.' };
            }

            const sigma = (photon * (i.beta * 1e-11)) / n / 1e-58;

            return { value: f(sigma), unit: 'GM', label: 'Two-photon cross-section σ₂', sub: 'σ₂ = ħω β ÷ N; 1 GM = 10⁻⁵⁰ cm⁴·s per photon', rows: { photon: `${f(photon / ELECTRON_VOLT)} eV per photon`, si: `${f(sigma * 1e-58)} m⁴·s` } };
        }

        if (!(i.sigma > 0)) {
            return { empty: 'Enter σ₂ in GM.' };
        }

        const beta = ((i.sigma * 1e-58 * n) / photon) / 1e-11;

        return { value: f(beta), unit: 'cm/GW', label: 'Two-photon absorption coefficient β', sub: 'β = σ₂ N ÷ ħω', rows: { photon: `${f(photon / ELECTRON_VOLT)} eV per photon`, si: `${f(beta * 1e-11)} m/W` } };
    },

    young_laplace: (i, c, f) => {
        const tension = i.liquid === 'custom' ? i.tension / 1000 : waterSurfaceTension(K(Number.isNaN(i.temperature) ? 25 : i.temperature));
        const r1 = i.r1;

        if (!(tension > 0) || !(r1 > 0)) {
            return { empty: 'Enter the surface tension and radius.' };
        }

        let pressure;
        let description;

        if (i.shape === 'drop') {
            pressure = (2 * tension) / r1;
            description = 'Drop or bubble in a liquid: ΔP = 2γ ÷ R';
        } else if (i.shape === 'soap') {
            pressure = (4 * tension) / r1;
            description = 'Soap bubble (two surfaces): ΔP = 4γ ÷ R';
        } else if (i.shape === 'cylinder') {
            pressure = tension / r1;
            description = 'Cylinder: ΔP = γ ÷ R';
        } else {
            if (!(i.r2 > 0)) {
                return { empty: 'Enter both principal radii.' };
            }

            pressure = tension * (1 / r1 + 1 / i.r2);
            description = 'General surface: ΔP = γ (1/R₁ + 1/R₂)';
        }

        return { value: f(pressure), unit: 'Pa', label: 'Laplace pressure ΔP', sub: description, rows: { kpa: `${f(pressure / 1000)} kPa`, mmhg: `${f(pressure / 133.322368)} mmHg`, tension: `${f(tension * 1000)} mN/m` } };
    },

    cubic_cell: (i, c, f) => {
        const lattice = LATTICES[i.lattice];
        const element = c.data.elements[i.element];
        const weight = element.weight;
        let edge;

        if (i.mode === 'radius') {
            if (!(i.radius > 0)) {
                return { empty: 'Enter the atomic radius.' };
            }

            edge = lattice.edge(i.radius);
        } else {
            if (!(i.edge > 0)) {
                return { empty: 'Enter the edge length.' };
            }

            edge = i.edge;
        }

        const centimeters = edge * 100;
        const density = (lattice.atoms * weight) / (AVOGADRO * centimeters ** 3);
        const radius = i.mode === 'radius' ? i.radius : { sc: edge / 2, bcc: (Math.sqrt(3) * edge) / 4, fcc: edge / (2 * Math.SQRT2), diamond: (Math.sqrt(3) * edge) / 8 }[i.lattice];

        return {
            value: f(density),
            unit: 'g/cm³',
            label: `Density of ${element.name} as ${lattice.name.toLowerCase()}`,
            sub: `ρ = n M ÷ (Nₐ a³) with ${lattice.atoms} atom${lattice.atoms === 1 ? '' : 's'} per cell`,
            rows: { edge: `${f(edge * 1e12)} pm`, radius: `${f(radius * 1e12)} pm`, coordination: String(lattice.coordination), packing: `${f(lattice.packing * 100)}%`, volume: `${f(centimeters ** 3)} cm³ per cell` },
        };
    },

    miller: (i, c, f) => {
        let indices;

        if (i.mode === 'intercepts') {
            const parse = (value) => (/^(inf|∞|infinity)$/i.test(String(value).trim()) ? Infinity : Number(value));
            const intercepts = [i.x, i.y, i.z].map(parse);

            if (intercepts.some((value) => Number.isNaN(value) || value === 0)) {
                return { empty: 'Enter the intercepts in units of the cell edge; use ∞ for an axis the plane never crosses.' };
            }

            indices = millerFromIntercepts(intercepts);

            if (!indices) {
                return { error: 'These intercepts do not give small whole-number indices.' };
            }
        } else {
            indices = [i.h, i.k, i.l].map(Math.round);

            if (indices.some((value) => Number.isNaN(value)) || indices.every((value) => value === 0)) {
                return { empty: 'Enter h, k and l (not all zero).' };
            }
        }

        const sum = indices.reduce((total, value) => total + value * value, 0);
        const spacing = i.lattice_constant > 0 ? i.lattice_constant / Math.sqrt(sum) : null;
        const bragg = spacing && i.wavelength > 0 && i.wavelength / (2 * spacing) <= 1 ? (Math.asin(i.wavelength / (2 * spacing)) * 180) / Math.PI : null;

        return {
            value: millerText(indices),
            unit: '',
            label: 'Miller indices (hkl)',
            sub: i.mode === 'intercepts' ? 'Reciprocals of the intercepts, cleared to the smallest whole numbers' : `Plane ${millerText(indices)} of a cubic lattice`,
            rows: { spacing: spacing ? `${f(spacing * 1e12)} pm (d = a ÷ √(h² + k² + l²))` : 'Enter the lattice constant', bragg: bragg === null ? 'Enter a wavelength shorter than 2d' : `θ = ${f(bragg)}° (2θ = ${f(2 * bragg)}°)`, sum: String(sum) },
        };
    },

    photon_energy: (i, c, f) => {
        let wavelength;
        let label = 'Photon energy';

        if (i.mode === 'hydrogen') {
            const n1 = Math.round(i.n1);
            const n2 = Math.round(i.n2);

            if (!(n1 >= 1) || !(n2 > n1)) {
                return { empty: 'Enter two levels with the upper one higher, e.g. 2 and 3.' };
            }

            // Hydrogen Rydberg constant with the reduced-mass correction.
            const rydbergH = RYDBERG / (1 + ELECTRON_MASS / PROTON_MASS);
            wavelength = 1 / (rydbergH * (1 / n1 ** 2 - 1 / n2 ** 2));
            label = `Hydrogen ${n2} → ${n1} transition`;
        } else if (i.mode === 'frequency') {
            if (!(i.frequency > 0)) {
                return { empty: 'Enter the frequency.' };
            }

            wavelength = LIGHT / i.frequency;
        } else if (i.mode === 'energy') {
            if (!(i.energy > 0)) {
                return { empty: 'Enter the energy.' };
            }

            wavelength = (PLANCK * LIGHT) / (i.energy * ELECTRON_VOLT);
        } else {
            if (!(i.wavelength > 0)) {
                return { empty: 'Enter the wavelength.' };
            }

            wavelength = i.wavelength * 1e-9;
        }

        const energy = (PLANCK * LIGHT) / wavelength;
        const nm = wavelength * 1e9;
        const region = nm < 0.01 ? 'Gamma rays' : nm < 10 ? 'X-rays' : nm < 380 ? 'Ultraviolet' : nm <= 750 ? `Visible (${nm < 450 ? 'violet' : nm < 495 ? 'blue' : nm < 570 ? 'green' : nm < 590 ? 'yellow' : nm < 620 ? 'orange' : 'red'})` : nm < 1e6 ? 'Infrared' : 'Microwave or radio';

        return {
            value: f(energy / ELECTRON_VOLT),
            unit: 'eV',
            label,
            sub: `${region}; E = hc ÷ λ`,
            rows: { wavelength: `${f(nm)} nm`, frequency: `${f(LIGHT / wavelength)} Hz`, joules: `${f(energy)} J`, molar: `${f((energy * AVOGADRO) / 1000)} kJ/mol`, wavenumber: `${f(1 / (wavelength * 100))} cm⁻¹` },
        };
    },

    de_broglie: (i, c, f) => {
        const mass = { electron: ELECTRON_MASS, proton: PROTON_MASS, neutron: NEUTRON_MASS }[i.particle] ?? (i.mass > 0 ? i.mass : NaN);

        if (!(mass > 0)) {
            return { empty: 'Enter the particle mass.' };
        }

        let momentum;
        let speed;

        if (i.mode === 'energy') {
            if (!(i.energy > 0)) {
                return { empty: 'Enter the kinetic energy.' };
            }

            // Relativistic: pc = √(E_k² + 2 E_k m c²).
            const kinetic = i.energy * ELECTRON_VOLT;
            momentum = Math.sqrt(kinetic ** 2 + 2 * kinetic * mass * LIGHT ** 2) / LIGHT;
            speed = (momentum * LIGHT ** 2) / (kinetic + mass * LIGHT ** 2);
        } else {
            if (!(i.speed > 0) || i.speed >= LIGHT) {
                return { empty: 'Enter a speed below the speed of light.' };
            }

            speed = i.speed;
            momentum = (mass * speed) / Math.sqrt(1 - (speed / LIGHT) ** 2);
        }

        const wavelength = PLANCK / momentum;

        return {
            value: f(wavelength * 1e12),
            unit: 'pm',
            label: 'de Broglie wavelength',
            sub: `λ = h ÷ p (relativistic); v = ${f((speed / LIGHT) * 100)}% of c`,
            rows: { nm: `${f(wavelength * 1e9)} nm`, momentum: `${f(momentum)} kg·m/s`, speed: `${f(speed)} m/s` },
        };
    },

    henry: (i, c, f) => {
        const gas = c.data.henry[i.gas];

        if (!gas || missing(i, 'temperature')) {
            return { empty: 'Pick a gas and enter the temperature.' };
        }

        const T = K(i.temperature);
        const constant = gas.hcp * Math.exp(gas.c * (1 / T - 1 / 298.15));
        let concentration;
        let pressure;

        if (i.direction === 'concentration') {
            if (!(i.pressure > 0)) {
                return { empty: 'Enter the partial pressure of the gas.' };
            }

            pressure = i.pressure / 101325;
            concentration = constant * pressure;
        } else {
            if (!(i.concentration > 0)) {
                return { empty: 'Enter the dissolved concentration.' };
            }

            concentration = i.concentration;
            pressure = concentration / constant;
        }

        const weight = weightFrom(gas.name, c.data.elements).weight;

        return {
            value: i.direction === 'concentration' ? f(concentration * 1000) : f(pressure * 101.325),
            unit: i.direction === 'concentration' ? 'mmol/L' : 'kPa',
            label: i.direction === 'concentration' ? `Dissolved ${gas.name}` : `Partial pressure of ${gas.name}`,
            sub: `Henry's law in water at ${f(i.temperature)} °C: c = H p with H = ${f(constant)} mol/(L·atm)`,
            rows: { mg: `${f(concentration * weight * 1000)} mg/L`, constant: `${f(constant)} mol/(L·atm) (${f(gas.hcp)} at 25 °C)`, pressure: `${f(pressure)} atm` },
        };
    },
};

export default defineTools(handlers);
