import { L_LETTERS, bondOrderFromOrbitals, diatomicOrbitals, expandConfiguration, ionConfiguration, label, notation, orbitalBoxes, slater, sortSubshells, totalElectrons, unpairedElectrons, valenceElectrons } from '../chemistry/electrons.js';
import { FormulaError, hillFormula, molarMass, parseFormula } from '../chemistry/formula.js';
import { formulaFromName, nameFromFormula, NameError } from '../chemistry/nomenclature.js';
import { pKw } from '../chemistry/water.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * General chemistry calculators: atoms, isotopes, electrons, bonding, formulas and pKa.
 * Element data (config/elements.php, trimmed by App\Services\ChemistryData) arrives as config.data.elements.
 */
const HYDROGEN_ATOM = 1.00782503223;
const NEUTRON = 1.00866491606;
const MEV_PER_U = 931.49410242;
const SUP = '⁰¹²³⁴⁵⁶⁷⁸⁹';

const superscript = (value) => [...String(value)].map((digit) => SUP[Number(digit)]).join('');
/** "[Ar] 3d6 4s2" → "[Ar] 3d⁶ 4s²" for display. */
const prettyConfiguration = (text) => text.replace(/(\d[spdf])(\d+)/g, (_, subshell, count) => subshell + superscript(count));
const chargeText = (charge) => (charge === 0 ? '' : `${Math.abs(charge) === 1 ? '' : superscript(Math.abs(charge))}${charge > 0 ? '⁺' : '⁻'}`);

export function readFormula(text, elements) {
    try {
        return { parsed: parseFormula(text, elements) };
    } catch (error) {
        if (error instanceof FormulaError) {
            return String(text ?? '').trim() === '' ? { empty: 'Enter a chemical formula.' } : { error: error.message };
        }

        throw error;
    }
}

/**
 * Pauling's percent ionic character and the Hannay–Smyth formula.
 */
export function ionicCharacter(delta) {
    return { pauling: (1 - Math.exp(-(delta ** 2) / 4)) * 100, hannaySmyth: Math.min(100, 16 * delta + 3.5 * delta ** 2) };
}

/**
 * Bond type by electronegativity difference (common teaching convention).
 */
export function bondType(delta) {
    if (delta < 0.4) {
        return 'Nonpolar covalent (Δχ < 0.4)';
    }

    return delta <= 1.7 ? 'Polar covalent (0.4 ≤ Δχ ≤ 1.7)' : 'Ionic (Δχ > 1.7)';
}

function mostAbundant(element) {
    return element.isotopes.reduce((best, isotope) => (isotope[2] > best[2] ? isotope : best), element.isotopes[0]);
}

export function monoisotopicMass(parsed, elements) {
    let mass = 0;
    let nominal = 0;

    for (const [symbol, count] of parsed.counts) {
        const element = elements[symbol === 'D' || symbol === 'T' ? 'H' : symbol];

        if (!element.isotopes?.length) {
            return null;
        }

        const isotope = symbol === 'D' ? [2, 2.01410177812] : symbol === 'T' ? [3, 3.01604928132] : mostAbundant(element);
        mass += isotope[1] * count;
        nominal += isotope[0] * count;
    }

    return { mass, nominal };
}

/**
 * Parses a typed configuration ("1s2 2s2 2p6" or "[Ne] 3s2 3p4") into subshells.
 */
export function parseConfiguration(text, elements) {
    const clean = String(text ?? '').replace(/[⁰¹²³⁴⁵⁶⁷⁸⁹]/g, (digit) => SUP.indexOf(digit)).replace(/,/g, ' ').trim();
    const match = /^(?:\[\s*([A-Z][a-z]?)\s*\]\s*)?(.*)$/.exec(clean);
    const subshells = match[1] ? expandConfiguration(elements[match[1]]?.configuration ?? '', elements) : [];

    // Each count is read within its subshell's capacity, so "3s23p4" is 3s2 3p4 even without spaces.
    const token = '(\\d)(?:(s)(2|1)|(p)([1-6])|(d)(10|[1-9])|(f)(1[0-4]|[1-9]))';
    const body = match[2].replace(/\s+/g, '').toLowerCase();

    if (!new RegExp(`^(?:${token})*$`).test(body)) {
        return null;
    }

    for (const found of body.matchAll(new RegExp(token, 'g'))) {
        const item = [found[0], found[1], found[2] ?? found[4] ?? found[6] ?? found[8], found[3] ?? found[5] ?? found[7] ?? found[9]];

        const existing = subshells.find((entry) => entry.n === Number(item[1]) && entry.l === L_LETTERS.indexOf(item[2].toLowerCase()));

        if (existing) {
            existing.electrons += Number(item[3]);
        } else {
            subshells.push({ n: Number(item[1]), l: L_LETTERS.indexOf(item[2].toLowerCase()), electrons: Number(item[3]) });
        }
    }

    return sortSubshells(subshells);
}

const sameConfiguration = (a, b) => a.length === b.length && a.every((item, index) => item.n === b[index].n && item.l === b[index].l && item.electrons === b[index].electrons);

function elementConfiguration(element, charge, elements) {
    const neutral = expandConfiguration(element.configuration, elements);

    if (charge > element.z) {
        throw new RangeError(`${element.name} has only ${element.z} electrons.`);
    }

    return ionConfiguration(neutral, charge);
}

export const handlers = {
    atom: (i, c, f) => {
        const element = c.data.elements[i.element];

        if (missing(i, 'mass_number')) {
            return { empty: 'Enter the mass number.' };
        }

        const charge = Number.isNaN(i.charge) ? 0 : Math.round(i.charge);
        const a = Math.round(i.mass_number);

        if (a < element.z) {
            return { error: `The mass number must be at least the atomic number (${element.z}).` };
        }

        if (charge > element.z) {
            return { error: `A ${element.name} atom has only ${element.z} electrons to lose.` };
        }

        const natural = element.isotopes.find((isotope) => isotope[0] === a);

        return {
            value: `${element.z} p · ${a - element.z} n · ${element.z - charge} e`,
            unit: '',
            label: 'Protons, neutrons and electrons',
            sub: `${superscript(a)}${element.symbol}${chargeText(charge)}: ${element.name}-${a}${charge ? `, ${charge > 0 ? 'cation' : 'anion'} with charge ${charge > 0 ? '+' : ''}${charge}` : ', neutral atom'}`,
            rows: { protons: String(element.z), neutrons: String(a - element.z), electrons: String(element.z - charge), nucleons: String(a), natural: natural ? `Yes, ${f(natural[2] * 100)}% of natural ${element.name.toLowerCase()}` : 'Not a naturally occurring isotope' },
        };
    },

    atomic_mass: (i, c, f) => {
        const element = c.data.elements[i.element];

        if (i.mode === 'isotope') {
            if (missing(i, 'mass_number')) {
                return { empty: 'Enter the mass number.' };
            }

            const isotope = element.isotopes.find((item) => item[0] === Math.round(i.mass_number));

            if (!isotope) {
                return { error: `${element.name}-${Math.round(i.mass_number)} is not a naturally occurring isotope. Natural isotopes: ${element.isotopes.map((item) => item[0]).join(', ') || 'none'}.` };
            }

            const neutrons = isotope[0] - element.z;
            const defect = element.z * HYDROGEN_ATOM + neutrons * NEUTRON - isotope[1];
            const binding = defect * MEV_PER_U;

            return {
                value: f(isotope[1]),
                unit: 'u',
                label: `Mass of ${element.name}-${isotope[0]}`,
                sub: `NIST relative atomic mass; ${f(isotope[2] * 100)}% natural abundance`,
                rows: { molar: `${f(isotope[1])} g/mol (this isotope alone)`, z: String(element.z), isotopes_count: String(element.isotopes.length), defect: `${f(defect)} u`, binding: `${f(binding)} MeV`, per_nucleon: `${f(binding / isotope[0])} MeV per nucleon` },
                lists: { isotopes: element.isotopes.map((item) => ({ label: `${element.symbol}-${item[0]}`, value: `${f(item[1])} u · ${f(item[2] * 100)}%`, highlight: item === isotope })) },
            };
        }

        const radioactive = element.mass_number !== undefined;

        return {
            value: radioactive ? `[${element.mass_number}]` : f(element.weight),
            unit: radioactive ? '' : 'u',
            label: `Standard atomic weight of ${element.name}`,
            sub: radioactive ? `No stable isotopes: mass of the longest-lived isotope is ${f(element.weight)} u` : `IUPAC abridged value ± ${f(element.uncertainty)}`,
            rows: { molar: radioactive ? `${f(element.weight)} g/mol (that isotope)` : `${f(element.weight)} g/mol`, z: String(element.z), isotopes_count: String(element.isotopes.length), defect: 'Choose "One isotope"', binding: 'Choose "One isotope"', per_nucleon: 'Choose "One isotope"' },
            lists: { isotopes: element.isotopes.length ? element.isotopes.map((item) => ({ label: `${element.symbol}-${item[0]}`, value: `${f(item[1])} u · ${f(item[2] * 100)}%` })) : [{ label: 'Natural isotopes', value: 'None' }] },
        };
    },

    average_atomic_mass: (i, c, f) => {
        let rows;

        if (i.mode === 'element') {
            const element = c.data.elements[i.element];

            if (!element.isotopes.length) {
                return { error: `${element.name} has no natural isotopes.` };
            }

            rows = element.isotopes.map((item) => ({ name: `${element.symbol}-${item[0]}`, mass: item[1], fraction: item[2] }));
        } else {
            const lines = String(i.isotopes ?? '').split(/\n|;/).map((line) => line.trim()).filter(Boolean);

            if (!lines.length) {
                return { empty: 'Enter one isotope per line: mass and abundance.' };
            }

            rows = [];

            for (const [index, line] of lines.entries()) {
                const numbers = line.replace(/%/g, '').split(/[\s,]+/).map(Number);

                if (numbers.length < 2 || numbers.some((value) => Number.isNaN(value) || value < 0)) {
                    return { error: `Line ${index + 1}: write the mass and the abundance, e.g. 34.96885 75.76.` };
                }

                rows.push({ name: `Isotope ${index + 1}`, mass: numbers[0], fraction: numbers[1] });
            }

            const sum = rows.reduce((total, row) => total + row.fraction, 0);
            const inPercent = sum > 1.5;
            rows = rows.map((row) => ({ ...row, fraction: inPercent ? row.fraction / 100 : row.fraction }));
        }

        const total = rows.reduce((sum, row) => sum + row.fraction, 0);
        const average = rows.reduce((sum, row) => sum + row.mass * row.fraction, 0);

        return {
            value: f(average),
            unit: 'u',
            label: 'Average atomic mass',
            sub: Math.abs(total - 1) > 0.001 ? `Abundances add up to ${f(total * 100)}%, not 100%; check them` : 'Σ mass × abundance',
            rows: { total: `${f(total * 100)}%`, normalised: `${f(average / total)} u if scaled to 100%` },
            lists: { contributions: rows.map((row) => ({ label: row.name, value: `${f(row.mass)} u × ${f(row.fraction * 100)}% = ${f(row.mass * row.fraction)} u` })) },
        };
    },

    bond_order: (i, c, f) => {
        if (i.mode === 'counts') {
            if (missing(i, 'bonding', 'antibonding')) {
                return { empty: 'Enter the bonding and antibonding electrons.' };
            }

            if (i.bonding < 0 || i.antibonding < 0) {
                return { error: 'Electron counts cannot be negative.' };
            }

            const order = (i.bonding - i.antibonding) / 2;

            return { value: f(order), unit: '', label: 'Bond order', sub: order <= 0 ? 'Zero or less: no stable bond' : '(bonding − antibonding) ÷ 2', rows: { mo: '—', unpaired: '—', magnetism: '—' } };
        }

        const read = readFormula(i.molecule, c.data.elements);

        if (!read.parsed) {
            return read;
        }

        const atoms = [...read.parsed.counts].flatMap(([symbol, count]) => Array(count).fill(symbol));

        if (atoms.length !== 2) {
            // "H2+" reads as H²⁺; a molecular ion needs the caret (H2^+, O2^-).
            const ambiguous = /^([A-Z][a-z]?)(\d)([+-])$/.exec(String(i.molecule ?? '').trim());

            return { error: ambiguous ? `Write the molecular ion as ${ambiguous[1]}${ambiguous[2]}^${ambiguous[3]} (a ${ambiguous[1]}${ambiguous[2]} molecule with charge ${ambiguous[3]}1).` : 'Enter a diatomic molecule or ion, e.g. O2, N2^+, CO, NO or CN-.' };
        }

        const [a, b] = atoms.map((symbol) => c.data.elements[symbol === 'D' || symbol === 'T' ? 'H' : symbol]);

        if (a.period !== b.period || a.period > 2) {
            return { error: 'The molecular orbital diagram here covers two atoms from period 1 (H, He) or two from period 2 (Li to Ne).' };
        }

        const electrons = a.z + b.z - read.parsed.charge;

        if (electrons < 1) {
            return { error: 'No electrons left in this ion.' };
        }

        const orbitals = diatomicOrbitals(electrons, a.period);
        const result = bondOrderFromOrbitals(orbitals);
        const filled = orbitals.filter((item) => item.electrons > 0 && !(a.period === 2 && item.name.endsWith('1s')));

        return {
            value: f(result.order),
            unit: '',
            label: `Bond order of ${read.parsed.text}`,
            sub: result.order <= 0 ? 'Bond order 0: the molecule is not stable' : `${electrons} electrons; ${a.period === 2 ? (electrons <= 14 ? 'π2p below σ2p (s–p mixing, up to N₂)' : 'σ2p below π2p (O₂ onward)') : 'σ1s and σ*1s only'}`,
            rows: { mo: filled.map((item) => `(${item.name})${superscript(item.electrons)}`).join(' '), unpaired: String(result.unpaired), magnetism: result.unpaired ? 'Paramagnetic' : 'Diamagnetic' },
            lists: { levels: orbitals.filter((item) => item.name !== 'overflow').slice().reverse().map((item) => ({ label: item.name, value: `${item.electrons} of ${item.capacity}${item.antibonding ? ' (antibonding)' : ''}` })) },
        };
    },

    chemical_name: (i, c, f) => {
        const text = String(i.query ?? '').trim();

        if (!text) {
            return { empty: i.mode === 'name' ? 'Enter a compound name.' : 'Enter a formula.' };
        }

        try {
            if (i.mode === 'name') {
                const result = formulaFromName(text, c.data.elements);

                return { value: result.display, unit: '', label: 'Formula', sub: result.type, rows: { type: result.type, detail: '—' } };
            }

            const result = nameFromFormula(text, c.data.elements);

            return { value: result.name, unit: '', label: 'IUPAC name', sub: result.type, rows: { type: result.type, detail: result.alternative ? `Also written ${result.alternative}` : result.ions ? result.ions.join(' · ') : '—' } };
        } catch (error) {
            if (error instanceof NameError) {
                return { error: error.message };
            }

            throw error;
        }
    },

    zeff: (i, c, f) => {
        const element = c.data.elements[i.element];
        const subshells = expandConfiguration(element.configuration, c.data.elements);
        const [n, l] = String(i.orbital ?? 'valence').split('-').map(Number);
        const target = i.orbital === 'valence' || Number.isNaN(n)
            ? [...subshells].sort((x, y) => y.n - x.n || y.l - x.l)[0]
            : subshells.find((item) => item.n === n && item.l === l);

        if (!target) {
            return { error: `${element.name} has no electrons in that orbital. Its configuration is ${element.configuration}.` };
        }

        const result = slater(subshells, element.z, target.n, target.l);

        return {
            value: f(result.zeff),
            unit: '',
            label: `Zeff for a ${label(target)} electron of ${element.name}`,
            sub: `Z ${element.z} − shielding ${f(result.shielding)} (Slater's rules)`,
            rows: { shielding: f(result.shielding), z: String(element.z), configuration: prettyConfiguration(element.configuration) },
            lists: { breakdown: result.breakdown.map((item) => ({ label: item.group, value: `${item.electrons} × ${item.each} = ${f(item.electrons * item.each)}` })) },
        };
    },

    electron_config: (i, c, f) => {
        const element = c.data.elements[i.element];
        const charge = Number.isNaN(i.charge) ? 0 : Math.round(i.charge);
        let subshells;

        try {
            subshells = elementConfiguration(element, charge, c.data.elements);
        } catch (error) {
            return { error: error.message };
        }

        const written = notation(subshells, c.data.elements);
        const symbol = `${element.symbol}${chargeText(charge)}`;
        const boxes = subshells.map((item) => ({ label: label(item), value: orbitalBoxes(item) }));

        if (i.mode === 'practice') {
            const answer = String(i.answer ?? '').trim();

            if (!answer) {
                return { empty: `Write the configuration of ${symbol}, e.g. 1s2 2s2 2p6 or [Ne] 3s2.` };
            }

            const typed = parseConfiguration(answer, c.data.elements);

            if (!typed) {
                return { error: 'Write subshells like 1s2 2s2 2p6, optionally starting with a noble gas core such as [Ne].' };
            }

            const correct = sameConfiguration(typed, subshells);

            return {
                value: correct ? 'Correct' : 'Not quite',
                unit: '',
                label: `Your answer for ${symbol}`,
                sub: correct ? `${prettyConfiguration(written.short)} is right` : `You wrote ${totalElectrons(typed)} electrons; ${symbol} has ${totalElectrons(subshells)}. The answer is ${prettyConfiguration(written.short)}`,
                rows: { full: prettyConfiguration(written.full), valence: String(valenceElectrons(subshells)), unpaired: String(unpairedElectrons(subshells)), magnetism: unpairedElectrons(subshells) ? 'Paramagnetic' : 'Diamagnetic' },
                lists: { boxes },
            };
        }

        return {
            value: prettyConfiguration(written.short),
            unit: '',
            label: `Electron configuration of ${symbol}`,
            sub: `${totalElectrons(subshells)} electrons${element.predicted ? ' · predicted (not yet measured)' : charge ? ' · electrons removed from the highest n first' : ' · NIST ground state'}`,
            rows: { full: prettyConfiguration(written.full), valence: String(valenceElectrons(subshells)), unpaired: String(unpairedElectrons(subshells)), magnetism: unpairedElectrons(subshells) ? 'Paramagnetic' : 'Diamagnetic' },
            lists: { boxes },
        };
    },

    electronegativity: (i, c, f) => {
        const a = c.data.elements[i.element_a];
        const b = c.data.elements[i.element_b];

        if (a.electronegativity === null || b.electronegativity === null) {
            return { error: `${(a.electronegativity === null ? a : b).name} has no Pauling electronegativity value.` };
        }

        const delta = Math.abs(a.electronegativity - b.electronegativity);

        return {
            value: f(Math.round(delta * 100) / 100),
            unit: 'Δχ',
            label: `Electronegativity difference, ${a.symbol}–${b.symbol}`,
            sub: bondType(delta),
            rows: { a: `${a.name}: ${a.electronegativity}`, b: `${b.name}: ${b.electronegativity}`, ionic: `${f(ionicCharacter(delta).pauling)}% (Pauling)`, more: delta === 0 ? 'Equal' : `${(a.electronegativity > b.electronegativity ? a : b).name} pulls the electrons` },
        };
    },

    ionic_character: (i, c, f) => {
        let delta;

        if (i.mode === 'delta') {
            if (missing(i, 'delta') || i.delta < 0) {
                return { empty: 'Enter the electronegativity difference.' };
            }

            delta = i.delta;
        } else {
            const a = c.data.elements[i.element_a];
            const b = c.data.elements[i.element_b];

            if (a.electronegativity === null || b.electronegativity === null) {
                return { error: 'One of these elements has no Pauling electronegativity value.' };
            }

            delta = Math.abs(a.electronegativity - b.electronegativity);
        }

        const result = ionicCharacter(delta);

        return {
            value: f(Math.round(result.pauling * 10) / 10),
            unit: '%',
            label: 'Percent ionic character (Pauling)',
            sub: `Δχ = ${f(delta)}; ${bondType(delta)}`,
            rows: { hannay: `${f(Math.round(result.hannaySmyth * 10) / 10)}%`, covalent: `${f(Math.round((100 - result.pauling) * 10) / 10)}%`, delta: f(delta) },
        };
    },

    mass_molar: (i, c, f) => {
        let weight = i.weight;

        if (String(i.formula ?? '').trim()) {
            const read = readFormula(i.formula, c.data.elements);

            if (!read.parsed) {
                return read;
            }

            weight = molarMass(read.parsed, c.data.elements).total;
        }

        if (!(weight > 0)) {
            return { empty: 'Enter a formula or a molar mass.' };
        }

        if (missing(i, 'value') || i.value < 0) {
            return { empty: 'Enter the concentration.' };
        }

        if (i.direction === 'molar') {
            const gramsPerLiter = i.value * weight;

            return { value: f(gramsPerLiter), unit: 'g/L', label: 'Mass concentration', sub: `${f(i.value)} mol/L × ${f(weight)} g/mol`, rows: { mg: `${f(gramsPerLiter * 1000)} mg/L`, ppm: `${f(gramsPerLiter * 1000)} ppm (mg/L, dilute water solutions)`, weight: `${f(weight)} g/mol` } };
        }

        const molar = i.value / weight;

        return { value: f(molar), unit: 'mol/L', label: 'Molar concentration', sub: `${f(i.value)} g/L ÷ ${f(weight)} g/mol`, rows: { mg: `${f(molar * 1000)} mmol/L`, ppm: `${f(molar * 1e6)} µmol/L`, weight: `${f(weight)} g/mol` } };
    },

    molar_mass: (i, c, f) => {
        const read = readFormula(i.formula, c.data.elements);

        if (!read.parsed) {
            return read;
        }

        const result = molarMass(read.parsed, c.data.elements);
        const atoms = result.parts.reduce((sum, part) => sum + part.count, 0);

        return {
            value: f(result.total),
            unit: 'g/mol',
            label: `Molar mass of ${read.parsed.text}`,
            sub: `${atoms} atoms of ${result.parts.length} element${result.parts.length === 1 ? '' : 's'}; IUPAC atomic weights`,
            rows: { hill: hillFormula(read.parsed.counts), atoms: String(atoms), kg: `${f(result.total / 1000)} kg/mol` },
            lists: { parts: result.parts.map((part) => ({ label: `${part.symbol} × ${part.count}`, value: `${f(part.mass)} g/mol · ${f(part.percent)}%` })) },
        };
    },

    percent_composition: (i, c, f) => {
        const read = readFormula(i.formula, c.data.elements);

        if (!read.parsed) {
            return read;
        }

        const result = molarMass(read.parsed, c.data.elements);

        return {
            value: result.parts.map((part) => `${part.symbol} ${f(Math.round(part.percent * 100) / 100)}%`).join(' · '),
            unit: '',
            label: `Percent composition of ${read.parsed.text}`,
            sub: `By mass, from a molar mass of ${f(result.total)} g/mol`,
            rows: { total: `${f(result.total)} g/mol`, hill: hillFormula(read.parsed.counts) },
            lists: { parts: result.parts.map((part) => ({ label: `${part.name} (${part.symbol} × ${part.count})`, value: `${f(part.percent)}% · ${f(part.mass)} g` })) },
        };
    },

    molecular_weight: (i, c, f) => {
        const read = readFormula(i.formula, c.data.elements);

        if (!read.parsed) {
            return read;
        }

        const result = molarMass(read.parsed, c.data.elements);
        const mono = monoisotopicMass(read.parsed, c.data.elements);

        return {
            value: f(result.total),
            unit: 'Da',
            label: `Molecular weight of ${read.parsed.text}`,
            sub: 'Average mass from IUPAC atomic weights; 1 Da = 1 g/mol',
            rows: { mono: mono ? `${f(mono.mass)} Da` : 'Not defined: an element has no stable isotope', nominal: mono ? `${mono.nominal} Da` : '—', hill: hillFormula(read.parsed.counts) },
            lists: { parts: result.parts.map((part) => ({ label: `${part.symbol} × ${part.count}`, value: `${f(part.mass)} Da` })) },
        };
    },

    pka: (i, c, f) => {
        const temperature = 25;
        const water = pKw(temperature);
        let pKa;

        if (i.mode === 'ka') {
            if (!(i.ka > 0)) {
                return { empty: 'Enter Ka.' };
            }

            pKa = -Math.log10(i.ka);
        } else if (i.mode === 'pka') {
            if (missing(i, 'pka_value')) {
                return { empty: 'Enter pKa.' };
            }

            pKa = i.pka_value;
        } else if (i.mode === 'ratio') {
            if (missing(i, 'ph', 'base', 'acid') || !(i.base > 0) || !(i.acid > 0)) {
                return { empty: 'Enter the pH and both concentrations.' };
            }

            pKa = i.ph - Math.log10(i.base / i.acid);
        } else {
            if (missing(i, 'ph', 'concentration') || !(i.concentration > 0)) {
                return { empty: 'Enter the pH and the acid concentration.' };
            }

            // Exact for a weak monoprotic acid: [A⁻] = [H⁺] − [OH⁻], [HA] = C − [A⁻].
            const h = 10 ** -i.ph;
            const conjugate = h - 10 ** -water / h;
            const acid = i.concentration - conjugate;

            if (conjugate <= 0 || acid <= 0) {
                return { error: 'This pH is not possible for a weak acid at that concentration.' };
            }

            pKa = -Math.log10((h * conjugate) / acid);
        }

        return {
            value: f(Math.round(pKa * 1000) / 1000),
            unit: '',
            label: 'pKa',
            sub: pKa < 0 ? 'Below 0: a strong acid' : pKa < 4 ? 'A moderately weak acid' : pKa < 10 ? 'A weak acid' : 'A very weak acid',
            rows: { ka: f(10 ** -pKa), pkb: f(Math.round((water - pKa) * 1000) / 1000), kb: f(10 ** -(water - pKa)), pkw: `${f(Math.round(water * 1000) / 1000)} at 25 °C (IAPWS)` },
        };
    },
};


export default defineTools(handlers);
