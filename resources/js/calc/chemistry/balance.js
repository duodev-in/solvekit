import { FormulaError, parseFormula } from './formula.js';

/**
 * Exact chemical equation balancing.
 *
 * Builds the element (and charge) matrix with reactants positive and products negative, finds its
 * null space with exact fractions (BigInt), and scales the single solution to the smallest whole numbers.
 */
const ARROWS = /\s*(?:<=>|<->|⇌|⇄|↔|→|⟶|->|=>|=)\s*/;

const abs = (value) => (value < 0n ? -value : value);

function gcd(a, b) {
    let x = abs(a);
    let y = abs(b);

    while (y) {
        [x, y] = [y, x % y];
    }

    return x;
}

class Fraction {
    constructor(numerator, denominator = 1n) {
        if (denominator === 0n) {
            throw new RangeError('Division by zero.');
        }

        const sign = denominator < 0n ? -1n : 1n;
        const divisor = gcd(numerator, denominator) || 1n;
        this.n = (sign * numerator) / divisor;
        this.d = abs(denominator) / divisor;
    }

    sub(other) {
        return new Fraction(this.n * other.d - other.n * this.d, this.d * other.d);
    }

    mul(other) {
        return new Fraction(this.n * other.n, this.d * other.d);
    }

    div(other) {
        return new Fraction(this.n * other.d, this.d * other.n);
    }

    isZero() {
        return this.n === 0n;
    }
}

/**
 * Null space of an integer matrix (rows × columns), as a list of basis vectors of Fractions.
 */
export function nullSpace(matrix, columns) {
    const rows = matrix.map((row) => row.map((value) => new Fraction(BigInt(value))));
    const pivots = [];
    let rank = 0;

    for (let column = 0; column < columns && rank < rows.length; column += 1) {
        const pivotRow = rows.findIndex((row, index) => index >= rank && !row[column].isZero());

        if (pivotRow === -1) {
            continue;
        }

        [rows[rank], rows[pivotRow]] = [rows[pivotRow], rows[rank]];
        const pivot = rows[rank][column];
        rows[rank] = rows[rank].map((value) => value.div(pivot));

        rows.forEach((row, index) => {
            if (index !== rank && !row[column].isZero()) {
                const factor = row[column];
                rows[index] = row.map((value, k) => value.sub(factor.mul(rows[rank][k])));
            }
        });

        pivots.push(column);
        rank += 1;
    }

    const free = [...Array(columns).keys()].filter((column) => !pivots.includes(column));

    return free.map((freeColumn) => {
        const vector = Array.from({ length: columns }, () => new Fraction(0n));
        vector[freeColumn] = new Fraction(1n);
        pivots.forEach((pivotColumn, row) => {
            vector[pivotColumn] = new Fraction(0n).sub(rows[row][freeColumn]);
        });

        return vector;
    });
}

/**
 * Smallest whole numbers proportional to a vector of Fractions.
 */
function toIntegers(vector) {
    const lcm = vector.reduce((acc, value) => (acc * value.d) / gcd(acc, value.d), 1n);
    const integers = vector.map((value) => (value.n * lcm) / value.d);
    const divisor = integers.reduce((acc, value) => gcd(acc, value), 0n) || 1n;

    return integers.map((value) => value / divisor);
}

/**
 * Splits one side of an equation into species, keeping any coefficient the user typed.
 * A "+" separates species when the next non-space character starts a species (a capital letter,
 * a digit, a bracket or e⁻) and it does not follow "^"; otherwise it is part of a charge
 * (NH4+ + OH-, Fe^3+ + e-, H2+O2).
 */
export function splitSide(text) {
    const parts = [];
    let current = '';

    for (let index = 0; index < text.length; index += 1) {
        const character = text[index];

        if (character === '+') {
            const before = current.trimEnd();
            const after = text.slice(index + 1).trimStart();
            // "(aq)" right after a sign is a phase label, not the start of the next species: Fe^3+(aq).
            const startsSpecies = /^(?:[A-Z(\[{]|\d|e\s*[-−⁻]|e\^)/.test(after) && !/^\((?:s|l|g|aq)\)/i.test(after);

            if (before !== '' && !before.endsWith('^') && startsSpecies) {
                parts.push(current);
                current = '';
                continue;
            }
        }

        current += character;
    }

    parts.push(current);

    return parts
        .map((part) => part.trim())
        .filter(Boolean)
        .map((part) => {
            const match = /^(\d+)\s*(?=[A-Z(\[{]|e\b)/.exec(part);

            return { typed: match ? Number(match[1]) : null, formula: match ? part.slice(match[1].length).trim() : part };
        });
}

export class BalanceError extends Error {}

/**
 * Balances an equation such as "Fe + O2 = Fe2O3" or "MnO4^- + Fe^2+ + H^+ = Mn^2+ + Fe^3+ + H2O".
 *
 * @returns {{ reactants: Array, products: Array, coefficients: number[], elements: string[] }}
 */
export function balance(equation, elements) {
    const sides = String(equation ?? '').split(ARROWS);

    if (sides.length !== 2 || !sides[0].trim() || !sides[1].trim()) {
        throw new BalanceError('Write the equation with one arrow or equals sign, e.g. H2 + O2 = H2O.');
    }

    const parse = (side) => splitSide(side).map((species) => {
        // A phase label such as (s), (l), (g) or (aq) may follow the formula.
        const phaseMatch = /\((s|l|g|aq)\)$/i.exec(species.formula);
        const formula = phaseMatch ? species.formula.slice(0, -phaseMatch[0].length).trim() : species.formula;
        const phase = phaseMatch ? phaseMatch[1].toLowerCase() : null;

        try {
            const parsed = parseFormula(formula, elements);

            return { ...species, formula, phase, ...parsed, text: parsed.text + (phase ? `(${phase})` : '') };
        } catch (error) {
            if (error instanceof FormulaError) {
                throw new BalanceError(`${species.formula}: ${error.message}`);
            }

            throw error;
        }
    });

    const reactants = parse(sides[0]);
    const products = parse(sides[1]);
    const species = [...reactants, ...products];
    const symbols = [...new Set(species.flatMap((item) => [...item.counts.keys()]))];
    const hasCharge = species.some((item) => item.charge !== 0);
    const sign = (index) => (index < reactants.length ? 1 : -1);
    const matrix = symbols.map((symbol) => species.map((item, index) => sign(index) * (item.counts.get(symbol) ?? 0)));

    if (hasCharge) {
        matrix.push(species.map((item, index) => sign(index) * item.charge));
    }

    const basis = nullSpace(matrix, species.length);

    if (basis.length === 0) {
        throw new BalanceError('This equation cannot be balanced: check the formulas, or a species is missing.');
    }

    if (basis.length > 1) {
        throw new BalanceError('This equation has more than one independent balance (it combines separate reactions). Split it into single reactions.');
    }

    let coefficients = toIntegers(basis[0]);

    if (coefficients.every((value) => value <= 0n)) {
        coefficients = coefficients.map((value) => -value);
    }

    if (coefficients.some((value) => value <= 0n)) {
        throw new BalanceError(coefficients.some((value) => value === 0n)
            ? 'A species takes no part in this reaction (its coefficient would be 0). Remove it or check the formulas.'
            : 'The only balance puts a species on the wrong side. Check which side each species belongs on.');
    }

    if (coefficients.some((value) => value > BigInt(Number.MAX_SAFE_INTEGER))) {
        throw new BalanceError('The coefficients are too large to show.');
    }

    return { reactants, products, coefficients: coefficients.map(Number), elements: symbols, hasCharge };
}

/**
 * The balanced equation as text, e.g. "4Fe + 3O₂ → 2Fe₂O₃".
 */
export function formatEquation(result) {
    const term = (item, coefficient) => `${coefficient === 1 ? '' : coefficient}${item.text}`;
    const left = result.reactants.map((item, index) => term(item, result.coefficients[index])).join(' + ');
    const right = result.products.map((item, index) => term(item, result.coefficients[result.reactants.length + index])).join(' + ');

    return `${left} → ${right}`;
}

/**
 * Atom and charge totals on each side, for the check table.
 */
export function sideTotals(result) {
    const total = (items, offset) => {
        const counts = new Map();
        let charge = 0;
        items.forEach((item, index) => {
            const coefficient = result.coefficients[offset + index];
            item.counts.forEach((count, symbol) => counts.set(symbol, (counts.get(symbol) ?? 0) + count * coefficient));
            charge += item.charge * coefficient;
        });

        return { counts, charge };
    };

    return { left: total(result.reactants, 0), right: total(result.products, result.reactants.length) };
}
