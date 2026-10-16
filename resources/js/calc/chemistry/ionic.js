import { displayFormula } from './formula.js';
import { ionicParts } from './nomenclature.js';

/**
 * Net ionic equations for precipitation, acid–base and gas-forming reactions in water, using the
 * standard solubility rules and strong-electrolyte lists of general chemistry. Redox reactions and
 * complex ions are outside this scope.
 */
const GROUP_1 = new Set(['Li', 'Na', 'K', 'Rb', 'Cs', 'NH4']);
const STRONG_ACIDS = { HCl: ['Cl', -1, 1], HBr: ['Br', -1, 1], HI: ['I', -1, 1], HNO3: ['NO3', -1, 1], HClO4: ['ClO4', -1, 1], HClO3: ['ClO3', -1, 1], H2SO4: ['SO4', -2, 2] };
const STRONG_BASE_CATIONS = new Set(['Li', 'Na', 'K', 'Rb', 'Cs', 'Ca', 'Sr', 'Ba']);
const ALWAYS_SOLUBLE_ANIONS = new Set(['NO3', 'CH3COO', 'CH3CO2', 'C2H3O2', 'ClO4', 'ClO3']);
/** Products that leave the solution as gases. */
const GASES = new Set(['CO2', 'SO2', 'H2S', 'H2', 'O2', 'N2', 'Cl2', 'NO', 'NO2']);

/**
 * Solubility rules: true when an ionic compound of this cation and anion dissolves in water.
 */
export function isSoluble(cation, anion) {
    if (GROUP_1.has(cation) || ALWAYS_SOLUBLE_ANIONS.has(anion)) {
        return true;
    }

    if (['Cl', 'Br', 'I'].includes(anion)) {
        return !['Ag', 'Pb', 'Hg2', 'Cu'].includes(cation);
    }

    if (anion === 'F') {
        return !['Mg', 'Ca', 'Sr', 'Ba', 'Pb'].includes(cation);
    }

    if (anion === 'SO4') {
        return !['Ba', 'Sr', 'Pb', 'Ca', 'Ag', 'Hg2'].includes(cation);
    }

    if (anion === 'OH') {
        return ['Ba', 'Sr'].includes(cation);
    }

    if (anion === 'S') {
        return ['Ca', 'Sr', 'Ba'].includes(cation);
    }

    // Carbonates, phosphates, sulfites, chromates, oxalates, silicates and oxides.
    return false;
}

/**
 * How a species appears in water: as ions (strong electrolyte) or as a whole formula with a phase.
 */
export function classify(species, elements) {
    const formula = species.formula.replace(/\s+/g, '');

    if (species.charge !== 0) {
        return { ions: [{ text: displayFormula(formula.replace(/\^.*$|[+-]$|\d*[+-]$/, ''), species.charge), key: `${formula}|${species.charge}`, count: 1 }], phase: 'aq' };
    }

    if (species.phase === 's' || species.phase === 'l' || species.phase === 'g') {
        return { whole: true, phase: species.phase };
    }

    if (STRONG_ACIDS[formula]) {
        const [anion, charge, hydrogens] = STRONG_ACIDS[formula];

        return { ions: [{ text: 'H⁺', key: 'H|1', count: hydrogens }, { text: displayFormula(anion, charge), key: `${anion}|${charge}`, count: 1 }], phase: 'aq' };
    }

    if (GASES.has(formula)) {
        return { whole: true, phase: 'g' };
    }

    // Acetates are often written with the metal last: CH3COONa, CH3COOK.
    const acetate = /^(CH3COO|CH3CO2|C2H3O2)(Li|Na|K|Rb|Cs|NH4)$/.exec(formula);

    if (acetate) {
        return { ions: [{ text: displayFormula(acetate[2], 1), key: `${acetate[2]}|1`, count: 1 }, { text: 'CH₃COO⁻', key: 'CH3COO|-1', count: 1 }], phase: 'aq' };
    }

    if (formula === 'H2O' || /^H\d*[A-Z]/.test(formula) || !/^(?:\(?NH4\)?|[A-Z][a-z]?)/.test(formula)) {
        return { whole: true, phase: formula === 'H2O' ? 'l' : species.phase ?? 'aq' };
    }

    let parts;

    try {
        parts = ionicParts(formula, elements);
    } catch {
        return { whole: true, phase: species.phase ?? 'aq' };
    }

    const { cation, anion } = parts;
    const strongBase = anion.formula === 'OH' && STRONG_BASE_CATIONS.has(cation.formula);

    if (!strongBase && !isSoluble(cation.formula, anion.formula)) {
        return { whole: true, phase: 's' };
    }

    return {
        ions: [
            { text: displayFormula(cation.formula, cation.charge), key: `${cation.formula}|${cation.charge}`, count: cation.count },
            { text: displayFormula(anion.formula, anion.charge), key: `${['CH3CO2', 'C2H3O2'].includes(anion.formula) ? 'CH3COO' : anion.formula}|${anion.charge}`, count: anion.count },
        ],
        phase: 'aq',
    };
}

/**
 * Complete and net ionic equations from a balanced result (see balance.js).
 */
export function ionicEquations(result, elements) {
    const side = (items, offset) => {
        const terms = new Map();

        items.forEach((item, index) => {
            const coefficient = result.coefficients[offset + index];
            const kind = classify(item, elements);

            if (kind.whole) {
                const key = `whole:${item.text}|${kind.phase}`;
                const text = `${displayFormula(item.formula.replace(/\^.*$/, ''), 0)}(${kind.phase})`;
                const entry = terms.get(key) ?? { text, count: 0, spectatorable: true };
                entry.count += coefficient;
                terms.set(key, entry);
            } else {
                kind.ions.forEach((ion) => {
                    const key = `ion:${ion.key}`;
                    const entry = terms.get(key) ?? { text: `${ion.text}(aq)`, count: 0, spectatorable: true };
                    entry.count += coefficient * ion.count;
                    terms.set(key, entry);
                });
            }
        });

        return terms;
    };

    const left = side(result.reactants, 0);
    const right = side(result.products, result.reactants.length);
    const format = (terms) => [...terms.values()].filter((term) => term.count > 0).map((term) => `${term.count === 1 ? '' : term.count}${term.text}`).join(' + ');
    const complete = `${format(left)} → ${format(right)}`;
    const spectators = [];

    for (const [key, term] of left) {
        if (key.startsWith('ion:') && right.has(key)) {
            const common = Math.min(term.count, right.get(key).count);

            if (common > 0) {
                spectators.push(term.text);
                term.count -= common;
                right.get(key).count -= common;
            }
        }
    }

    const counts = [...left.values(), ...right.values()].map((term) => term.count).filter((count) => count > 0);
    const gcd = (a, b) => (b ? gcd(b, a % b) : a);
    const divisor = counts.reduce((acc, value) => gcd(acc, value), 0) || 1;
    [left, right].forEach((terms) => terms.forEach((term) => {
        term.count /= divisor;
    }));

    const leftText = format(left);
    const rightText = format(right);

    return { complete, net: leftText && rightText ? `${leftText} → ${rightText}` : null, spectators };
}
