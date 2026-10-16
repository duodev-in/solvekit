import { displayFormula, FormulaError, parseFormula } from './formula.js';

/**
 * Inorganic nomenclature (IUPAC Red Book 2005 conventions as taught in general chemistry):
 * ionic compounds, binary molecular compounds, acids and hydrates, in both directions.
 * Organic compounds are out of scope: one molecular formula can belong to many structures.
 */
export const POLYATOMIC = [
    // [formula as written, name, charge, acid name or null]
    ['NH4', 'ammonium', 1, null],
    ['H3O', 'hydronium', 1, null],
    ['OH', 'hydroxide', -1, null],
    ['CN', 'cyanide', -1, 'hydrocyanic acid'],
    ['SCN', 'thiocyanate', -1, 'thiocyanic acid'],
    ['NO3', 'nitrate', -1, 'nitric acid'],
    ['NO2', 'nitrite', -1, 'nitrous acid'],
    ['ClO4', 'perchlorate', -1, 'perchloric acid'],
    ['ClO3', 'chlorate', -1, 'chloric acid'],
    ['ClO2', 'chlorite', -1, 'chlorous acid'],
    ['ClO', 'hypochlorite', -1, 'hypochlorous acid'],
    ['BrO3', 'bromate', -1, 'bromic acid'],
    ['BrO', 'hypobromite', -1, 'hypobromous acid'],
    ['IO4', 'periodate', -1, 'periodic acid'],
    ['IO3', 'iodate', -1, 'iodic acid'],
    ['MnO4', 'permanganate', -1, 'permanganic acid'],
    ['HCO3', 'hydrogen carbonate', -1, null],
    ['HSO4', 'hydrogen sulfate', -1, null],
    ['HSO3', 'hydrogen sulfite', -1, null],
    ['H2PO4', 'dihydrogen phosphate', -1, null],
    ['HPO4', 'hydrogen phosphate', -2, null],
    ['CH3COO', 'acetate', -1, 'acetic acid'],
    ['CH3CO2', 'acetate', -1, 'acetic acid'],
    ['C2H3O2', 'acetate', -1, 'acetic acid'],
    ['CO3', 'carbonate', -2, 'carbonic acid'],
    ['SO4', 'sulfate', -2, 'sulfuric acid'],
    ['SO3', 'sulfite', -2, 'sulfurous acid'],
    ['S2O3', 'thiosulfate', -2, 'thiosulfuric acid'],
    ['C2O4', 'oxalate', -2, 'oxalic acid'],
    ['CrO4', 'chromate', -2, 'chromic acid'],
    ['Cr2O7', 'dichromate', -2, 'dichromic acid'],
    ['SiO3', 'silicate', -2, 'silicic acid'],
    ['SeO4', 'selenate', -2, 'selenic acid'],
    ['PtCl6', 'hexachloroplatinate', -2, null],
    ['O2', 'peroxide', -2, null],
    ['PO4', 'phosphate', -3, 'phosphoric acid'],
    ['PO3', 'phosphite', -3, 'phosphorous acid'],
    ['AsO4', 'arsenate', -3, 'arsenic acid'],
    ['BO3', 'borate', -3, 'boric acid'],
];

export const MONATOMIC_ANIONS = {
    H: ['hydride', -1], F: ['fluoride', -1], Cl: ['chloride', -1], Br: ['bromide', -1], I: ['iodide', -1],
    O: ['oxide', -2], S: ['sulfide', -2], Se: ['selenide', -2], Te: ['telluride', -2],
    N: ['nitride', -3], P: ['phosphide', -3], As: ['arsenide', -3],
};

const BINARY_ACIDS = { F: 'hydrofluoric acid', Cl: 'hydrochloric acid', Br: 'hydrobromic acid', I: 'hydroiodic acid', S: 'hydrosulfuric acid', Se: 'hydroselenic acid' };

/** Names used for the second element of binary molecular compounds. */
const IDE = { ...Object.fromEntries(Object.entries(MONATOMIC_ANIONS).map(([symbol, [name]]) => [symbol, name])), C: 'carbide', B: 'boride', Si: 'silicide' };

/** IUPAC element sequence for binary compounds: the element earlier in this list is named first. */
const SEQUENCE = ['B', 'Si', 'C', 'Sb', 'As', 'P', 'N', 'H', 'Te', 'Se', 'S', 'At', 'I', 'Br', 'Cl', 'O', 'F'];

const NONMETALS = new Set(['H', 'B', 'C', 'N', 'O', 'F', 'Si', 'P', 'S', 'Cl', 'As', 'Se', 'Br', 'Te', 'I', 'At', 'He', 'Ne', 'Ar', 'Kr', 'Xe', 'Rn', 'Sb']);

/** Metals with a single common charge, named without a Roman numeral. */
const FIXED_CHARGE = { Li: 1, Na: 1, K: 1, Rb: 1, Cs: 1, Fr: 1, Ag: 1, Be: 2, Mg: 2, Ca: 2, Sr: 2, Ba: 2, Ra: 2, Zn: 2, Cd: 2, Al: 3, Ga: 3, Sc: 3 };

export const PREFIXES = ['', 'mono', 'di', 'tri', 'tetra', 'penta', 'hexa', 'hepta', 'octa', 'nona', 'deca'];

const COMMON_NAMES = { H2O: 'water', H3N: 'ammonia', NH3: 'ammonia', CH4: 'methane', H2O2: 'hydrogen peroxide', H3P: 'phosphine', PH3: 'phosphine', N2H4: 'hydrazine' };

const ROMAN = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'];

const SPELLINGS = { aluminium: 'aluminum', caesium: 'cesium', sulphur: 'sulfur', sulphate: 'sulfate', sulphite: 'sulfite', sulphide: 'sulfide', sulphuric: 'sulfuric', sulphurous: 'sulfurous' };

export class NameError extends Error {}

function countText(count) {
    return count === 1 ? '' : String(count);
}

function prefixed(count, word, isFirst) {
    if (count > 10) {
        throw new NameError('Prefixes are defined up to 10 (deca).');
    }

    let prefix = count === 1 && isFirst ? '' : PREFIXES[count];

    // "mono-oxide" becomes "monoxide"; IUPAC keeps other vowels (pentaoxide).
    if (prefix === 'mono' && word.startsWith('o')) {
        prefix = 'mon';
    }

    return prefix + word;
}

function splitHydrate(text) {
    const match = /^(.*?)\s*[·•∙⋅*.]\s*(\d*)\s*H2O$/.exec(text.replace(/\s+/g, ''));

    return match ? { body: match[1], water: Number(match[2] || 1) } : { body: text.replace(/\s+/g, ''), water: 0 };
}

/**
 * Splits an ionic formula into cation and anion parts as written: Fe2(SO4)3, NH4NO3, NaHCO3, CaCl2.
 */
function splitIonic(body) {
    const cation = /^(\(NH4\)|NH4|[A-Z][a-z]?)(\d*)/.exec(body);

    if (!cation) {
        return null;
    }

    const cationText = cation[1].replace(/[()]/g, '');
    const rest = body.slice(cation[0].length);
    const grouped = /^\(([^()]+)\)(\d+)$/.exec(rest);
    const anionText = grouped ? grouped[1] : rest;
    const anionCount = grouped ? Number(grouped[2]) : null;

    return { cationText, cationCount: Number(cation[2] || 1), anionText, anionCount };
}

function findAnion(text, explicitCount, allowPeroxide = false) {
    // O2 is read as oxide first (PbO2 is lead(IV) oxide); peroxide only when a fixed charge needs it.
    const polyatomic = POLYATOMIC.find(([formula, , charge]) => charge < 0 && formula === text && (formula !== 'O2' || allowPeroxide));

    if (polyatomic) {
        return { name: polyatomic[1], charge: polyatomic[2], count: explicitCount ?? 1, acid: polyatomic[3], formula: polyatomic[0] };
    }

    if (explicitCount === null) {
        const withCount = /^([A-Z][a-z]?)(\d*)$/.exec(text);

        if (withCount && MONATOMIC_ANIONS[withCount[1]]) {
            const [name, charge] = MONATOMIC_ANIONS[withCount[1]];

            return { name, charge, count: Number(withCount[2] || 1), monatomic: withCount[1], formula: withCount[1] };
        }

        // A polyatomic anion written more than once without brackets is not valid (e.g. CaNO32).
        const polyCount = POLYATOMIC.find(([formula, , charge]) => charge < 0 && new RegExp(`^${formula}(\\d+)$`).test(text));

        if (polyCount) {
            throw new NameError(`Put the ${polyCount[1]} ion in brackets when there is more than one: (${polyCount[0]})${text.slice(polyCount[0].length)}.`);
        }
    }

    return null;
}

/**
 * Names a formula. Returns { name, type, ions? }.
 */
export function nameFromFormula(input, elements) {
    useElementNames(elements);
    const { body, water } = splitHydrate(String(input ?? '').trim());

    if (body === '') {
        throw new NameError('Enter a formula.');
    }

    let parsed;

    try {
        parsed = parseFormula(body, elements);
    } catch (error) {
        throw new NameError(error instanceof FormulaError ? error.message : String(error));
    }

    if (parsed.charge !== 0) {
        throw new NameError('Enter a neutral compound, without a charge.');
    }

    const hydrate = water > 0 ? ` ${prefixed(water, 'hydrate', false)}` : '';
    const symbols = [...parsed.counts.keys()];

    if (COMMON_NAMES[body] && water === 0) {
        return { name: COMMON_NAMES[body], type: 'Molecular compound (common name)' };
    }

    if (symbols.some((symbol) => !elements[symbol])) {
        throw new NameError('Isotope symbols such as D are not named here.');
    }

    if (symbols.length === 1) {
        throw new NameError(`${elements[symbols[0]].name} is an element, not a compound.`);
    }

    // Acids: hydrogen written first, then an anion.
    if (body.startsWith('H') && !body.startsWith('Hg') && !body.startsWith('Ho') && !body.startsWith('Hf') && !body.startsWith('He')) {
        const acid = nameAcid(body);

        if (acid) {
            return { ...acid, name: acid.name + hydrate };
        }
    }

    const parts = splitIonic(body);
    const cationIsMetal = parts && (parts.cationText === 'NH4' || !NONMETALS.has(parts.cationText));

    if (parts && cationIsMetal) {
        return nameIonic(parts, elements, hydrate);
    }

    if (symbols.every((symbol) => NONMETALS.has(symbol)) && symbols.length === 2) {
        const name = nameBinaryMolecular(parsed.counts) + hydrate;
        // Textbooks often drop the a or o before "oxide" (pentoxide); IUPAC keeps it (pentaoxide).
        const common = name.replace(/(tetr|pent|hex|hept|oct|non|dec)aoxide/, '$1oxide');

        return { name, type: 'Binary molecular compound', ...(common !== name ? { alternative: common } : {}) };
    }

    throw new NameError('This tool names ionic compounds, binary molecular compounds, acids and hydrates. Organic compounds cannot be named from a formula alone.');
}

function nameAcid(body) {
    const match = /^H(\d*)(.+)$/.exec(body);
    const hydrogens = Number(match[1] || 1);
    const anion = POLYATOMIC.find(([formula, , charge, acid]) => charge < 0 && acid && formula === match[2]);

    if (anion && hydrogens === -anion[2]) {
        return { name: anion[3], type: 'Acid (oxyacid)', ions: [`H⁺ × ${hydrogens}`, `${anion[1]} (${displayFormula(anion[0], anion[2])})`] };
    }

    if (BINARY_ACIDS[match[2]] && hydrogens === -MONATOMIC_ANIONS[match[2]][1]) {
        const gas = `hydrogen ${MONATOMIC_ANIONS[match[2]][0]}`;

        return { name: `${gas} (as a solution in water: ${BINARY_ACIDS[match[2]]})`, type: 'Binary acid', ions: [`H⁺ × ${hydrogens}`, MONATOMIC_ANIONS[match[2]][0]] };
    }

    return null;
}

function nameIonic(parts, elements, hydrate) {
    const anion = findAnion(parts.anionText, parts.anionCount, parts.peroxide === true);

    if (!anion) {
        throw new NameError(`"${parts.anionText}" is not a recognised anion. Write polyatomic ions with brackets when there is more than one, e.g. Fe2(SO4)3.`);
    }

    const isAmmonium = parts.cationText === 'NH4';
    const cationTotal = -anion.charge * anion.count;

    if (cationTotal % parts.cationCount !== 0) {
        // Peroxides look like oxides: Na2O2, BaO2.
        if (anion.monatomic === 'O' && anion.count % 2 === 0) {
            return nameIonic({ ...parts, anionText: 'O2', anionCount: anion.count === 2 ? null : anion.count / 2, peroxide: true }, elements, hydrate);
        }

        throw new NameError('The charges do not give a whole-number charge on the cation; check the formula.');
    }

    const cationCharge = cationTotal / parts.cationCount;
    const fixed = isAmmonium ? 1 : FIXED_CHARGE[parts.cationText];

    if (fixed !== undefined && fixed !== cationCharge) {
        if (anion.monatomic === 'O' && cationCharge === 2 * fixed) {
            return nameIonic({ ...parts, anionText: 'O2', anionCount: anion.count === 2 ? null : anion.count / 2, peroxide: true }, elements, hydrate);
        }

        throw new NameError(`${isAmmonium ? 'Ammonium' : elements[parts.cationText].name} is always ${fixed}+, which does not balance this anion.`);
    }

    if (cationCharge < 1 || cationCharge > 8) {
        throw new NameError('That cation charge is not possible; check the formula.');
    }

    const metalName = isAmmonium ? 'ammonium' : elements[parts.cationText].name.toLowerCase();
    const cationName = fixed !== undefined ? metalName : `${metalName}(${ROMAN[cationCharge]})`;

    return {
        name: `${cationName} ${anion.name}${hydrate}`,
        type: hydrate ? 'Ionic compound (hydrate)' : 'Ionic compound',
        ions: [`${cationName} (${displayFormula(parts.cationText, cationCharge)}) × ${parts.cationCount}`, `${anion.name} (${displayFormula(anion.formula, anion.charge)}) × ${anion.count}`],
    };
}

function nameBinaryMolecular(counts) {
    const [first, second] = [...counts.keys()].sort((a, b) => SEQUENCE.indexOf(a) - SEQUENCE.indexOf(b));

    if (!IDE[second]) {
        throw new NameError('This pair of nonmetals has no standard binary name here.');
    }

    return `${prefixed(counts.get(first), ELEMENT_NAMES[first], true)} ${prefixed(counts.get(second), IDE[second], false)}`;
}

/** Element names used inside names (set from the page's element table). */
let ELEMENT_NAMES = {};

export function useElementNames(elements) {
    ELEMENT_NAMES = Object.fromEntries(Object.entries(elements).map(([symbol, element]) => [symbol, element.name.toLowerCase()]));
}

function gcd(a, b) {
    return b ? gcd(b, a % b) : a;
}

/**
 * Builds a formula from a name: "iron(III) sulfate", "dinitrogen pentoxide", "sulfuric acid",
 * "copper(II) sulfate pentahydrate", "ammonium phosphate".
 */
export function formulaFromName(input, elements) {
    useElementNames(elements);
    let text = String(input ?? '').trim().toLowerCase().replace(/\s+/g, ' ');

    for (const [variant, standard] of Object.entries(SPELLINGS)) {
        text = text.replace(new RegExp(`\\b${variant}\\b`, 'g'), standard);
    }

    if (text === '') {
        throw new NameError('Enter a name.');
    }

    let water = 0;
    const hydrateMatch = /^(.*) (mono|di|tri|tetra|penta|hexa|hepta|octa|nona|deca)?hydrate$/.exec(text);

    if (hydrateMatch) {
        text = hydrateMatch[1];
        water = Math.max(1, PREFIXES.indexOf(hydrateMatch[2] ?? 'mono'));
    }

    const result = formulaCore(text, elements);
    const formula = water ? `${result.formula}·${water}H2O` : result.formula;

    return { ...result, formula, display: displayFormula(formula) };
}

function formulaCore(text, elements) {
    const common = Object.entries(COMMON_NAMES).find(([formula, name]) => name === text && !formula.startsWith('H3'));

    if (common) {
        return { formula: common[0], type: 'Molecular compound (common name)' };
    }

    const symbolByName = Object.fromEntries(Object.entries(ELEMENT_NAMES).map(([symbol, name]) => [name, symbol]));

    // Acids.
    const acid = POLYATOMIC.find(([, , , acidName]) => acidName === text);

    if (acid) {
        return { formula: `H${countText(-acid[2])}${acid[0]}`, type: 'Acid (oxyacid)' };
    }

    const binaryAcid = Object.entries(BINARY_ACIDS).find(([, name]) => name === text);

    if (binaryAcid) {
        return { formula: `H${countText(-MONATOMIC_ANIONS[binaryAcid[0]][1])}${binaryAcid[0]}`, type: 'Binary acid' };
    }

    const words = text.split(' ');

    // Ionic: cation (with optional Roman numeral) then anion.
    const cationMatch = /^([a-z]+)(?:\(([ivx]+)\))?$/.exec(words[0]);
    const anionName = words.slice(1).join(' ');
    const polyatomic = POLYATOMIC.find(([, name, charge]) => charge < 0 && name === anionName);
    const monatomic = Object.entries(MONATOMIC_ANIONS).find(([, [name]]) => name === anionName);

    if (cationMatch && (polyatomic || monatomic) && (cationMatch[1] === 'ammonium' || (symbolByName[cationMatch[1]] && !NONMETALS.has(symbolByName[cationMatch[1]])))) {
        const isAmmonium = cationMatch[1] === 'ammonium';
        const symbol = isAmmonium ? 'NH4' : symbolByName[cationMatch[1]];
        const roman = cationMatch[2] ? ROMAN.indexOf(cationMatch[2].toUpperCase()) : null;
        const charge = isAmmonium ? 1 : roman ?? FIXED_CHARGE[symbol];

        if (!charge || charge < 1) {
            throw new NameError(`Give the charge of ${cationMatch[1]} as a Roman numeral, e.g. ${cationMatch[1]}(II).`);
        }

        if (FIXED_CHARGE[symbol] && roman && roman !== FIXED_CHARGE[symbol]) {
            throw new NameError(`${cationMatch[1]} is always ${FIXED_CHARGE[symbol]}+.`);
        }

        const [anionFormula, anionCharge] = polyatomic ? [polyatomic[0], -polyatomic[2]] : [monatomic[0], -monatomic[1][1]];
        const divisor = gcd(charge, anionCharge);
        const cationCount = anionCharge / divisor;
        const anionCount = charge / divisor;
        const wrap = (formula, count, multi) => (count === 1 ? formula : multi ? `(${formula})${count}` : `${formula}${count}`);

        return {
            formula: wrap(symbol, cationCount, isAmmonium) + wrap(anionFormula, anionCount, Boolean(polyatomic)),
            type: 'Ionic compound',
        };
    }

    // Binary molecular: "[prefix]element [prefix]ide".
    if (words.length === 2) {
        const parsePart = (word, names) => {
            for (let count = 10; count >= 1; count -= 1) {
                // Accept the elided forms too: monoxide, pentoxide, decoxide.
                const full = PREFIXES[count];
                const variants = [[full, false], ...(/[ao]$/.test(full) ? [[full.slice(0, -1), true]] : [])];

                for (const [prefix, elided] of variants) {
                    const rest = word.slice(prefix.length);

                    if (!word.startsWith(prefix) || (elided && !rest.startsWith('o'))) {
                        continue;
                    }

                    const found = names(rest);

                    if (found) {
                        return { symbol: found, count };
                    }
                }
            }

            const plain = names(word);

            return plain ? { symbol: plain, count: 1 } : null;
        };
        const first = parsePart(words[0], (word) => symbolByName[word] ?? null);
        const second = parsePart(words[1], (word) => Object.entries(IDE).find(([, name]) => name === word)?.[0] ?? null);

        if (first && second && NONMETALS.has(first.symbol)) {
            return { formula: `${first.symbol}${countText(first.count)}${second.symbol}${countText(second.count)}`, type: 'Binary molecular compound' };
        }
    }

    throw new NameError('This name is not recognised. Try forms like "iron(III) chloride", "dinitrogen pentoxide" or "sulfuric acid".');
}

/**
 * The ions of a salt for solubility and ionic-strength work: { cation, anion } with formula,
 * count and charge. Mercury(I) is the dimer Hg₂²⁺, so Hg2Cl2 is one cation and two anions.
 */
export function ionicParts(input, elements) {
    const body = String(input ?? '').replace(/\s+/g, '');

    if (/^Hg2/.test(body)) {
        const rest = body.slice(3);
        const grouped = /^\(([^()]+)\)(\d+)$/.exec(rest);
        const anion = findAnion(grouped ? grouped[1] : rest, grouped ? Number(grouped[2]) : null);

        if (!anion || -anion.charge * anion.count !== 2) {
            throw new NameError('Mercury(I) salts contain Hg₂²⁺; check the formula.');
        }

        return { cation: { formula: 'Hg2', count: 1, charge: 2 }, anion: { formula: anion.formula, count: anion.count, charge: anion.charge } };
    }

    useElementNames(elements);
    const parts = splitIonic(body);

    if (!parts || (parts.cationText !== 'NH4' && NONMETALS.has(parts.cationText))) {
        throw new NameError('Enter an ionic compound, e.g. AgCl, CaF2 or Ca3(PO4)2.');
    }

    const anion = findAnion(parts.anionText, parts.anionCount);

    if (!anion) {
        throw new NameError(`"${parts.anionText}" is not a recognised anion.`);
    }

    const total = -anion.charge * anion.count;

    if (total % parts.cationCount !== 0) {
        throw new NameError('The charges in this formula do not balance.');
    }

    return { cation: { formula: parts.cationText, count: parts.cationCount, charge: total / parts.cationCount }, anion: { formula: anion.formula, count: anion.count, charge: anion.charge } };
}
