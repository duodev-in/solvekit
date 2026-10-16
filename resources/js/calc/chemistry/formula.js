/**
 * Chemical formula parsing.
 *
 * Reads formulas such as H2O, Ca(OH)2, [Cu(NH3)4]SO4, CuSO4·5H2O, Fe^3+, SO4 2- and e-.
 * Counts are exact integers; the element table comes from config/elements.php via the page.
 */
const SUBSCRIPTS = { '₀': '0', '₁': '1', '₂': '2', '₃': '3', '₄': '4', '₅': '5', '₆': '6', '₇': '7', '₈': '8', '₉': '9' };
const SUPERSCRIPTS = { '⁰': '0', '¹': '1', '²': '2', '³': '3', '⁴': '4', '⁵': '5', '⁶': '6', '⁷': '7', '⁸': '8', '⁹': '9', '⁺': '+', '⁻': '-' };
const OPEN = { '(': ')', '[': ']', '{': '}' };
// A hydrate dot: ·, *, or a full stop followed by a digit (CuSO4.5H2O).
const HYDRATE_DOTS = /[·•∙⋅*]|\.(?=\d)/;

export class FormulaError extends Error {}

/**
 * Hydrogen isotopes written as their own symbols.
 */
export const ISOTOPE_SYMBOLS = { D: 'H', T: 'H' };

function normaliseText(text) {
    let output = '';
    let inSuperscript = false;

    for (const character of String(text ?? '')) {
        if (SUBSCRIPTS[character]) {
            output += SUBSCRIPTS[character];
        } else if (SUPERSCRIPTS[character]) {
            output += (inSuperscript ? '' : '^') + SUPERSCRIPTS[character];
            inSuperscript = true;
            continue;
        } else {
            output += character;
        }

        inSuperscript = false;
    }

    return output.replace(/[−–]/g, '-').trim();
}

/**
 * Splits a trailing charge off a species. Accepted forms:
 *   caret      Fe^3+, SO4^2-, SO4^-2, NH4^+
 *   space      Fe 3+, SO4 2-
 *   plain      NH4+, Cl-, OH-, Fe3+
 * In the plain form a number before the sign is the charge only for a single atom (Fe3+, Al3+);
 * for a group it is a subscript (NH4+ is NH₄⁺), so write sulfate as SO4^2- or SO4 2-.
 */
export function splitCharge(text) {
    const caret = /^(.*?)\^\s*\(?(?:(\d*)([+-])|([+-])(\d+))\)?$/.exec(text);

    if (caret) {
        const sign = (caret[3] ?? caret[4]) === '-' ? -1 : 1;
        const magnitude = Number(caret[2] || caret[5] || 1);

        return { body: caret[1].trim(), charge: sign * magnitude };
    }

    const spaced = /^(.*\S)\s+(\d*)([+-])$/.exec(text);

    if (spaced) {
        return { body: spaced[1], charge: (spaced[3] === '-' ? -1 : 1) * Number(spaced[2] || 1) };
    }

    const plain = /^(.*?)(\d*)([+-])$/.exec(text);

    if (plain && plain[1] !== '') {
        const sign = plain[3] === '-' ? -1 : 1;

        if (plain[2] !== '' && /^[A-Z][a-z]?$/.test(plain[1])) {
            return { body: plain[1], charge: sign * Number(plain[2]) };
        }

        return { body: plain[1] + plain[2], charge: sign };
    }

    return { body: text, charge: 0 };
}

function readNumber(text, position) {
    let end = position;

    while (end < text.length && /\d/.test(text[end])) {
        end += 1;
    }

    return end === position ? { value: 1, end } : { value: Number(text.slice(position, end)), end };
}

function addCounts(target, source, times = 1) {
    for (const [symbol, count] of source) {
        target.set(symbol, (target.get(symbol) ?? 0) + count * times);
    }

    return target;
}

function parseGroup(text, elements, start, closing) {
    const counts = new Map();
    let position = start;

    while (position < text.length) {
        const character = text[position];

        if (OPEN[character]) {
            const inner = parseGroup(text, elements, position + 1, OPEN[character]);
            const { value, end } = readNumber(text, inner.end + 1);
            addCounts(counts, inner.counts, value);
            position = end;
            continue;
        }

        if (character === ')' || character === ']' || character === '}') {
            if (character !== closing) {
                throw new FormulaError(closing ? `Expected "${closing}" but found "${character}".` : `"${character}" has no opening bracket.`);
            }

            return { counts, end: position };
        }

        if (/[A-Z]/.test(character)) {
            const symbol = /^[A-Z][a-z]?/.exec(text.slice(position))[0];
            const known = elements[symbol] || ISOTOPE_SYMBOLS[symbol] ? symbol : elements[symbol[0]] || ISOTOPE_SYMBOLS[symbol[0]] ? symbol[0] : null;

            if (!known) {
                throw new FormulaError(`"${symbol}" is not an element symbol.`);
            }

            const { value, end } = readNumber(text, position + known.length);
            counts.set(known, (counts.get(known) ?? 0) + value);
            position = end;
            continue;
        }

        if (/[a-z]/.test(character)) {
            throw new FormulaError(`"${text.slice(position, position + 2)}" is not an element symbol; symbols start with a capital letter (Co, not co).`);
        }

        throw new FormulaError(`"${character}" cannot be read in a formula.`);
    }

    if (closing) {
        throw new FormulaError(`A "${closing}" is missing.`);
    }

    return { counts, end: position };
}

/**
 * Parses one formula into element counts and charge.
 *
 * @returns {{ counts: Map<string, number>, charge: number, text: string }}
 */
export function parseFormula(input, elements) {
    const text = normaliseText(input);

    if (text === '') {
        throw new FormulaError('Enter a formula.');
    }

    if (/^e\s*-?$/.test(text) || text === 'e^-') {
        return { counts: new Map(), charge: -1, text: 'e⁻' };
    }

    const { body, charge } = splitCharge(text);
    const counts = new Map();

    body.split(HYDRATE_DOTS).forEach((part, index) => {
        let piece = part.replace(/\s+/g, '');

        if (piece === '') {
            throw new FormulaError('A hydrate needs a formula after the dot, e.g. CuSO4·5H2O.');
        }

        let multiplier = 1;

        if (index > 0) {
            const lead = /^(\d+)/.exec(piece);

            if (lead) {
                multiplier = Number(lead[1]);
                piece = piece.slice(lead[1].length);
            }
        } else if (/^\d/.test(piece)) {
            throw new FormulaError('Remove the number in front of the formula; it is a coefficient, not part of the formula.');
        }

        addCounts(counts, parseGroup(piece, elements, 0, null).counts, multiplier);
    });

    if (counts.size === 0) {
        throw new FormulaError('Enter a formula with at least one element.');
    }

    return { counts, charge, text: displayFormula(body, charge) };
}

const SUB = '₀₁₂₃₄₅₆₇₈₉';
const SUP = '⁰¹²³⁴⁵⁶⁷⁸⁹';

/**
 * Pretty text: H₂SO₄, CuSO₄·5H₂O, Fe³⁺.
 */
export function displayFormula(body, charge = 0) {
    let output = '';
    let afterDot = true;

    for (const character of body.replace(/\s+/g, '').replace(/\.(?=\d)/g, '·')) {
        if (/[·•∙⋅*]/.test(character)) {
            output += '·';
            afterDot = true;
            continue;
        }

        output += /\d/.test(character) && !afterDot ? SUB[Number(character)] : character;
        afterDot = afterDot && /\d/.test(character);
    }

    if (charge !== 0) {
        const magnitude = Math.abs(charge);
        output += (magnitude === 1 ? '' : [...String(magnitude)].map((digit) => SUP[Number(digit)]).join('')) + (charge > 0 ? '⁺' : '⁻');
    }

    return output;
}

/**
 * Element weight, resolving D and T to hydrogen isotope masses.
 */
export function elementWeight(symbol, elements) {
    if (symbol === 'D') {
        return 2.01410177812;
    }

    if (symbol === 'T') {
        return 3.01604928132;
    }

    return elements[symbol].weight;
}

/**
 * Molar mass and the share of each element.
 *
 * @returns {{ total: number, parts: Array<{ symbol: string, name: string, count: number, mass: number, percent: number }> }}
 */
export function molarMass(parsed, elements) {
    const parts = [...parsed.counts].map(([symbol, count]) => ({
        symbol,
        name: elements[symbol]?.name ?? (symbol === 'D' ? 'Deuterium' : 'Tritium'),
        count,
        mass: count * elementWeight(symbol, elements),
    }));
    const total = parts.reduce((sum, part) => sum + part.mass, 0);

    return { total, parts: parts.map((part) => ({ ...part, percent: (part.mass / total) * 100 })) };
}

/**
 * Hill order (C, then H, then the rest alphabetically; alphabetical when there is no carbon).
 */
export function hillFormula(counts) {
    const symbols = [...counts.keys()];
    const ordered = counts.has('C')
        ? ['C', ...(counts.has('H') ? ['H'] : []), ...symbols.filter((symbol) => symbol !== 'C' && symbol !== 'H').sort()]
        : symbols.sort();

    return displayFormula(ordered.map((symbol) => symbol + (counts.get(symbol) === 1 ? '' : counts.get(symbol))).join(''));
}
