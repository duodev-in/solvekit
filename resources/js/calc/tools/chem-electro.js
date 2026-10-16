import { FARADAY, GAS_CONSTANT } from '../chemistry/constants.js';
import { displayFormula, FormulaError, molarMass, parseFormula } from '../chemistry/formula.js';
import { ionicParts, NameError } from '../chemistry/nomenclature.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Electrochemistry: cell potentials, the Nernst equation, electrolysis, ionic strength and the
 * Born–Haber cycle. Temperatures arrive in °C; reduction potentials are config.data.potentials.
 */
const K = (celsius) => celsius + 273.15;

function nernst(standard, electrons, kelvin, q) {
    return standard - ((GAS_CONSTANT * kelvin) / (electrons * FARADAY)) * Math.log(q);
}

/**
 * Ionic strength of a list of ions { concentration, charge }: I = ½ Σ c z².
 */
export function ionicStrength(ions) {
    return 0.5 * ions.reduce((sum, ion) => sum + ion.concentration * ion.charge ** 2, 0);
}

export const handlers = {
    cell_emf: (i, c, f) => {
        let cathode;
        let anode;
        let electrons;

        if (i.mode === 'table') {
            const red = c.data.potentials[i.cathode];
            const ox = c.data.potentials[i.anode];

            if (!red || !ox) {
                return { empty: 'Pick the two half-reactions.' };
            }

            cathode = red.e;
            anode = ox.e;
            // Electrons transferred in the overall reaction: least common multiple of the two halves.
            const gcd = (a, b) => (b ? gcd(b, a % b) : a);
            electrons = (red.n * ox.n) / gcd(red.n, ox.n);
        } else {
            if (missing(i, 'e_cathode', 'e_anode', 'electrons') || !(i.electrons > 0)) {
                return { empty: 'Enter both standard potentials and the electrons transferred.' };
            }

            [cathode, anode, electrons] = [i.e_cathode, i.e_anode, Math.round(i.electrons)];
        }

        const standard = cathode - anode;
        const T = K(Number.isNaN(i.temperature) ? 25 : i.temperature);
        const q = i.q > 0 ? i.q : 1;
        const cell = nernst(standard, electrons, T, q);
        const gibbs = (-electrons * FARADAY * standard) / 1000;

        return {
            value: f(Math.round(cell * 10000) / 10000),
            unit: 'V',
            label: q === 1 ? 'Standard cell potential E°cell' : 'Cell potential Ecell',
            sub: standard > 0 ? 'Positive: the cell runs spontaneously (galvanic)' : 'Negative: the reaction needs an applied voltage (electrolytic)',
            rows: { standard: `${f(Math.round(standard * 10000) / 10000)} V (E°cathode − E°anode)`, gibbs: `${f(Math.round(gibbs * 100) / 100)} kJ/mol`, k: f(Math.exp((electrons * FARADAY * standard) / (GAS_CONSTANT * 298.15))), n: String(electrons) },
        };
    },

    nernst: (i, c, f) => {
        if (missing(i, 'standard', 'electrons') || !(i.electrons > 0)) {
            return { empty: 'Enter E° and the electrons transferred.' };
        }

        let q = i.q;

        if (i.mode === 'concentrations') {
            if (!(i.oxidized > 0) || !(i.reduced > 0)) {
                return { empty: 'Enter the concentrations of the oxidized and reduced forms.' };
            }

            q = i.reduced / i.oxidized;
        } else if (!(q > 0)) {
            return { empty: 'Enter the reaction quotient Q.' };
        }

        const T = K(Number.isNaN(i.temperature) ? 25 : i.temperature);
        const potential = nernst(i.standard, Math.round(i.electrons), T, q);
        const slope = ((GAS_CONSTANT * T * Math.LN10) / (Math.round(i.electrons) * FARADAY)) * 1000;

        return {
            value: f(Math.round(potential * 100000) / 100000),
            unit: 'V',
            label: 'Electrode or cell potential E',
            sub: `E = E° − (RT ÷ nF) ln Q; ${f(Math.round(slope * 100) / 100)} mV per decade of Q at ${f(T - 273.15)} °C`,
            rows: { shift: `${f(Math.round((potential - i.standard) * 100000) / 100000)} V from E°`, q: f(q), gibbs: `${f(Math.round(((-Math.round(i.electrons) * FARADAY * potential) / 1000) * 100) / 100)} kJ/mol` },
        };
    },

    electrolysis: (i, c, f) => {
        let weight = i.weight;
        let label = 'the substance';

        if (String(i.formula ?? '').trim()) {
            try {
                const parsed = parseFormula(i.formula, c.data.elements);
                weight = molarMass(parsed, c.data.elements).total;
                label = parsed.text;
            } catch (error) {
                if (error instanceof FormulaError) {
                    return { error: error.message };
                }

                throw error;
            }
        }

        const z = Math.round(i.charge_number);

        if (!(weight > 0) || !(z >= 1)) {
            return { empty: 'Enter the substance (formula or molar mass) and the electrons per ion.' };
        }

        const efficiency = (i.efficiency > 0 ? i.efficiency : 100) / 100;
        let mass;
        let current = i.current;
        let seconds = i.time;

        if (i.solve === 'mass') {
            if (!(current > 0) || !(seconds > 0)) {
                return { empty: 'Enter the current and time.' };
            }

            mass = ((current * seconds * efficiency) / (z * FARADAY)) * weight;
        } else if (i.solve === 'time') {
            if (!(i.mass > 0) || !(current > 0)) {
                return { empty: 'Enter the mass and current.' };
            }

            mass = i.mass;
            seconds = (mass / weight) * z * FARADAY / (current * efficiency);
        } else {
            if (!(i.mass > 0) || !(seconds > 0)) {
                return { empty: 'Enter the mass and time.' };
            }

            mass = i.mass;
            current = (mass / weight) * z * FARADAY / (seconds * efficiency);
        }

        const charge = current * seconds;
        const moles = mass / weight;
        const shown = { mass: [f(mass), 'g', `Mass of ${label} deposited`], time: [f(seconds / 3600), 'h', 'Time needed'], current: [f(current), 'A', 'Current needed'] }[i.solve];

        return {
            value: shown[0],
            unit: shown[1],
            label: shown[2],
            sub: `Faraday's law: m = I t M ÷ (z F) with F = ${f(FARADAY)} C/mol${efficiency < 1 ? `, ${f(efficiency * 100)}% current efficiency` : ''}`,
            rows: { charge: `${f(charge)} C (${f(charge / 3600)} A·h)`, moles: `${f(moles)} mol`, electrons: `${f((moles * z))} mol of electrons`, minutes: `${f(seconds / 60)} min at ${f(current)} A` },
        };
    },

    ionic_strength: (i, c, f) => {
        const ions = [];

        if (i.mode === 'salt') {
            if (!String(i.salt ?? '').trim() || !(i.salt_concentration > 0)) {
                return { empty: 'Enter the salt formula and its concentration.' };
            }

            try {
                const { cation, anion } = ionicParts(i.salt, c.data.elements);
                ions.push({ label: displayFormula(cation.formula, cation.charge), concentration: cation.count * i.salt_concentration, charge: cation.charge });
                ions.push({ label: displayFormula(anion.formula, anion.charge), concentration: anion.count * i.salt_concentration, charge: anion.charge });
            } catch (error) {
                if (error instanceof NameError) {
                    return { error: error.message };
                }

                throw error;
            }
        } else {
            const lines = String(i.ions ?? '').split(/\n|;/).map((line) => line.trim()).filter(Boolean);

            if (!lines.length) {
                return { empty: 'Enter each ion and its concentration, one per line (e.g. Ca2+ 0.01).' };
            }

            for (const [index, line] of lines.entries()) {
                const match = /^(\S+)\s+([\d.]+(?:e-?\d+)?)$/i.exec(line);

                if (!match) {
                    return { error: `Line ${index + 1}: write an ion and a concentration, e.g. SO4^2- 0.01.` };
                }

                let parsed;

                try {
                    parsed = parseFormula(match[1], c.data.elements);
                } catch (error) {
                    if (error instanceof FormulaError) {
                        return { error: `Line ${index + 1}: ${error.message}` };
                    }

                    throw error;
                }

                if (parsed.charge === 0) {
                    return { error: `Line ${index + 1}: ${parsed.text} has no charge; write it as an ion, e.g. Na+ or SO4^2-.` };
                }

                ions.push({ label: parsed.text, concentration: Number(match[2]), charge: parsed.charge });
            }
        }

        const strength = ionicStrength(ions);
        const net = ions.reduce((sum, ion) => sum + ion.concentration * ion.charge, 0);

        return {
            value: f(strength),
            unit: 'mol/L',
            label: 'Ionic strength I',
            sub: Math.abs(net) > 1e-12 ? `Charges do not balance (net ${f(net)} mol/L); check the ions` : 'I = ½ Σ cᵢ zᵢ²',
            rows: { count: String(ions.length), net: f(net) },
            lists: { ions: ions.map((ion) => ({ label: ion.label, value: `${f(ion.concentration)} × ${ion.charge ** 2} = ${f(ion.concentration * ion.charge ** 2)}` })) },
        };
    },

    lattice_energy: (i, c, f) => {
        const steps = ['formation', 'sublimation', 'ionization', 'bond', 'affinity'];

        if (missing(i, ...steps) || !(i.nonmetal_atoms >= 1)) {
            return { empty: 'Enter every step of the Born–Haber cycle in kJ/mol.' };
        }

        // ΔfH° = sublimation + ionization + atomization + electron affinity + U, so U = ΔfH° − the rest.
        // Atomization: each nonmetal atom needs half an X₂ bond, e.g. ½ × 242 kJ/mol for the Cl in NaCl.
        const atomization = (i.bond / 2) * Math.round(i.nonmetal_atoms);
        const lattice = i.formation - (i.sublimation + i.ionization + atomization + i.affinity);
        const rows = [
            ['Sublimation of the metal', i.sublimation],
            ['Ionization energy (total)', i.ionization],
            [`Atomization: ${Math.round(i.nonmetal_atoms)} × ½ bond energy`, atomization],
            ['Electron affinity (total)', i.affinity],
            ['Lattice formation enthalpy', lattice],
            ['Equals the enthalpy of formation', i.formation],
        ];

        return {
            value: f(Math.round(lattice * 10) / 10),
            unit: 'kJ/mol',
            label: 'Lattice enthalpy (gaseous ions → solid)',
            sub: `Lattice dissociation enthalpy +${f(Math.round(-lattice * 10) / 10)} kJ/mol, from the Born–Haber cycle (Hess's law)`,
            rows: { dissociation: `+${f(Math.round(-lattice * 10) / 10)} kJ/mol`, check: `${f(i.sublimation)} + ${f(i.ionization)} + ${f(atomization)} + (${f(i.affinity)}) + (${f(Math.round(lattice * 10) / 10)}) = ${f(i.formation)}` },
            lists: { cycle: rows.map(([label, value]) => ({ label, value: `${value >= 0 ? '+' : ''}${f(Math.round(value * 10) / 10)} kJ/mol`, highlight: label.startsWith('Lattice') })) },
        };
    },
};

export default defineTools(handlers);
