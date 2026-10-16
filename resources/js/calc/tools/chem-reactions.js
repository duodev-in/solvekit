import { balance, BalanceError, formatEquation, sideTotals } from '../chemistry/balance.js';
import { FormulaError, hillFormula, molarMass, parseFormula } from '../chemistry/formula.js';
import { ionicEquations } from '../chemistry/ionic.js';
import { R } from '../chemistry/thermo.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Chemical reactions: balancing, ratios, yields, limiting reactants, equilibrium and kinetics.
 * Temperatures from unit menus arrive in °C; element data is config.data.elements.
 */
const kelvin = (celsius) => celsius + 273.15;

function balanced(equation, elements) {
    if (!String(equation ?? '').trim()) {
        return { empty: 'Enter a chemical equation.' };
    }

    try {
        return { result: balance(equation, elements) };
    } catch (error) {
        if (error instanceof BalanceError) {
            return { error: error.message };
        }

        throw error;
    }
}

const weightOf = (species, elements) => molarMass(species, elements).total;
const speciesKey = (species) => `${hillFormula(species.counts)}|${species.charge}`;

/**
 * All species with their signed coefficient (negative for reactants).
 */
function speciesList(result) {
    return [...result.reactants.map((item, index) => ({ item, nu: -result.coefficients[index], side: 'reactant' })),
        ...result.products.map((item, index) => ({ item, nu: result.coefficients[result.reactants.length + index], side: 'product' }))];
}

function findSpecies(result, text, elements) {
    const parsed = parseFormula(String(text).replace(/\((s|l|g|aq)\)$/i, ''), elements);
    const key = speciesKey(parsed);

    return speciesList(result).find(({ item }) => speciesKey(item) === key) ?? null;
}

/**
 * Lines "formula amount [unit]" → { entry, moles } matched to the equation's species.
 */
function readAmounts(text, result, elements, defaultUnit = 'g') {
    const lines = String(text ?? '').split(/\n|;/).map((line) => line.trim()).filter(Boolean);
    const found = [];

    for (const [index, line] of lines.entries()) {
        const match = /^(\S+)\s*[:=]?\s*([\d.]+(?:e-?\d+)?)\s*(g|mg|kg|mol|mmol|m|atm|bar)?$/i.exec(line);

        if (!match) {
            return { error: `Line ${index + 1}: write a formula and an amount, e.g. H2 4 g.` };
        }

        let entry;

        try {
            entry = findSpecies(result, match[1], elements);
        } catch (error) {
            if (error instanceof FormulaError) {
                return { error: `Line ${index + 1}: ${error.message}` };
            }

            throw error;
        }

        if (!entry) {
            return { error: `Line ${index + 1}: ${match[1]} is not in the equation.` };
        }

        const amount = Number(match[2]);
        const unit = (match[3] ?? defaultUnit).toLowerCase();
        const grams = { g: amount, mg: amount / 1000, kg: amount * 1000 }[unit];
        found.push({ entry, amount, unit, moles: grams !== undefined ? grams / weightOf(entry.item, elements) : unit === 'mmol' ? amount / 1000 : amount });
    }

    return { found };
}

/**
 * Equilibrium expression value, leaving out pure solids and liquids.
 */
function quotient(result, concentrations) {
    let value = 1;
    const used = [];

    for (const { item, nu } of speciesList(result)) {
        if (item.phase === 's' || item.phase === 'l') {
            continue;
        }

        const concentration = concentrations.get(speciesKey(item));

        if (concentration === undefined) {
            return { missing: item.text };
        }

        value *= concentration ** nu;
        used.push(`[${item.text.replace(/\((aq|g)\)$/, '')}]${Math.abs(nu) === 1 ? '' : `^${Math.abs(nu)}`}`);
    }

    return { value, used };
}

function concentrationsFrom(found) {
    return new Map(found.map(({ entry, amount }) => [speciesKey(entry.item), amount]));
}

function expression(result) {
    const part = (items, offset) => items.filter((item) => item.phase !== 's' && item.phase !== 'l')
        .map((item, index) => `[${item.text.replace(/\((aq|g)\)$/, '')}]${result.coefficients[offset + index] === 1 ? '' : superscript(result.coefficients[offset + index])}`).join('');
    const top = part(result.products, result.reactants.length) || '1';
    const bottom = part(result.reactants, 0) || '1';

    return `${top} ÷ ${bottom}`;
}

const SUP = '⁰¹²³⁴⁵⁶⁷⁸⁹';
const superscript = (value) => [...String(value)].map((digit) => SUP[Number(digit)] ?? digit).join('');

function yieldTable(i, c, f) {
    const read = balanced(i.equation, c.data.elements);

    if (!read.result) {
        return read;
    }

    const amounts = readAmounts(i.amounts, read.result, c.data.elements);

    if (amounts.error) {
        return amounts;
    }

    const reactants = amounts.found.filter(({ entry }) => entry.side === 'reactant');

    if (!reactants.length) {
        return { empty: 'Enter the amount of at least one reactant.' };
    }

    const limiting = reactants.reduce((best, item) => (item.moles / -item.entry.nu < best.moles / -best.entry.nu ? item : best));
    const extent = limiting.moles / -limiting.entry.nu;

    return { result: read.result, reactants, limiting, extent };
}

export const handlers = {
    balancer: (i, c, f) => {
        const read = balanced(i.equation, c.data.elements);

        if (!read.result) {
            return read;
        }

        const totals = sideTotals(read.result);
        const massLeft = read.result.reactants.reduce((sum, item, index) => sum + read.result.coefficients[index] * weightOf(item, c.data.elements), 0);

        return {
            value: formatEquation(read.result),
            unit: '',
            label: 'Balanced equation',
            sub: `Coefficients ${read.result.coefficients.join(', ')}; smallest whole numbers`,
            rows: { coefficients: read.result.coefficients.join(' : '), mass: `${f(massLeft)} g on each side`, charge: read.result.hasCharge ? `${totals.left.charge} on each side` : 'Neutral' },
            lists: { atoms: [...totals.left.counts].map(([symbol, count]) => ({ label: symbol, value: `${count} = ${totals.right.counts.get(symbol)}` })) },
        };
    },

    net_ionic: (i, c, f) => {
        const read = balanced(i.equation, c.data.elements);

        if (!read.result) {
            return read;
        }

        const ionic = ionicEquations(read.result, c.data.elements);

        return {
            value: ionic.net ?? 'No net reaction',
            unit: '',
            label: 'Net ionic equation',
            sub: ionic.net ? 'Spectator ions removed' : 'Every ion appears unchanged on both sides, so nothing reacts',
            rows: { molecular: formatEquation(read.result), complete: ionic.complete, spectators: ionic.spectators.join(', ') || 'None' },
        };
    },

    molar_ratio: (i, c, f) => {
        const read = balanced(i.equation, c.data.elements);

        if (!read.result) {
            return read;
        }

        let a;
        let b;

        try {
            a = findSpecies(read.result, i.species_a, c.data.elements);
            b = findSpecies(read.result, i.species_b, c.data.elements);
        } catch (error) {
            if (error instanceof FormulaError) {
                return { error: error.message };
            }

            throw error;
        }

        if (!a || !b) {
            return { error: `${!a ? i.species_a : i.species_b} is not in the equation.` };
        }

        const ratio = Math.abs(b.nu) / Math.abs(a.nu);
        const weightA = weightOf(a.item, c.data.elements);
        const weightB = weightOf(b.item, c.data.elements);
        const molesA = i.amount > 0 ? (i.amount_unit === 'g' ? i.amount / weightA : i.amount) : null;

        return {
            value: `${Math.abs(a.nu)} : ${Math.abs(b.nu)}`,
            unit: '',
            label: `Mole ratio ${a.item.text} : ${b.item.text}`,
            sub: `${f(ratio)} mol of ${b.item.text} per mol of ${a.item.text}`,
            rows: { mass: `${f((Math.abs(a.nu) * weightA))} g : ${f(Math.abs(b.nu) * weightB)} g`, amount: molesA === null ? 'Enter an amount of the first species' : `${f(molesA * ratio)} mol = ${f(molesA * ratio * weightB)} g of ${b.item.text}`, equation: formatEquation(read.result) },
        };
    },

    theoretical_yield: (i, c, f) => {
        const table = yieldTable(i, c, f);

        if (!table.result) {
            return table;
        }

        let product;

        try {
            product = findSpecies(table.result, i.product, c.data.elements);
        } catch (error) {
            if (error instanceof FormulaError) {
                return { error: error.message };
            }

            throw error;
        }

        if (!product || product.side !== 'product') {
            return { error: `${i.product} is not a product of this equation.` };
        }

        const moles = table.extent * product.nu;
        const grams = moles * weightOf(product.item, c.data.elements);
        const actual = i.actual > 0 ? (i.actual / grams) * 100 : null;

        return {
            value: f(grams),
            unit: 'g',
            label: `Theoretical yield of ${product.item.text}`,
            sub: `${table.limiting.entry.item.text} is the limiting reactant`,
            rows: { moles: `${f(moles)} mol`, limiting: table.limiting.entry.item.text, percent: actual === null ? 'Enter an actual yield' : `${f(actual)}% yield` },
            lists: { reactants: table.reactants.map((item) => ({ label: item.entry.item.text, value: `${f(item.moles)} mol ÷ ${-item.entry.nu} = ${f(item.moles / -item.entry.nu)}${item === table.limiting ? ' (limiting)' : ''}`, highlight: item === table.limiting })) },
        };
    },

    limiting_reactant: (i, c, f) => {
        const table = yieldTable(i, c, f);

        if (!table.result) {
            return table;
        }

        if (table.reactants.length < 2) {
            return { empty: 'Enter amounts for at least two reactants.' };
        }

        const products = speciesList(table.result).filter(({ side }) => side === 'product');

        return {
            value: table.limiting.entry.item.text,
            unit: '',
            label: 'Limiting reactant',
            sub: `It runs out first, so the equation as written can run ${f(table.extent)} times (in moles)`,
            rows: { equation: formatEquation(table.result), products: products.map(({ item, nu }) => `${f(table.extent * nu * weightOf(item, c.data.elements))} g ${item.text}`).join(', ') },
            lists: { left: table.reactants.map((item) => {
                const left = item.moles - table.extent * -item.entry.nu;
                const grams = left * weightOf(item.entry.item, c.data.elements);

                return { label: item.entry.item.text, value: item === table.limiting ? 'Used up' : `${f(left)} mol (${f(grams)} g) left over`, highlight: item === table.limiting };
            }) },
        };
    },

    percent_yield: (i, c, f) => {
        if (missing(i, 'actual', 'theoretical') || !(i.theoretical > 0) || i.actual < 0) {
            return { empty: 'Enter the actual and theoretical yields.' };
        }

        const percent = (i.actual / i.theoretical) * 100;

        return { value: f(percent), unit: '%', label: 'Percent yield', sub: percent > 100 ? 'Over 100%: the product is probably wet or impure' : `${f(i.actual)} of ${f(i.theoretical)}`, rows: { lost: f(i.theoretical - i.actual), fraction: f(i.actual / i.theoretical) } };
    },

    actual_yield: (i, c, f) => {
        if (missing(i, 'theoretical', 'percent') || !(i.theoretical > 0) || i.percent < 0) {
            return { empty: 'Enter the theoretical yield and percent yield.' };
        }

        const actual = (i.theoretical * i.percent) / 100;

        return { value: f(actual), unit: i.unit_label || '', label: 'Actual yield', sub: `${f(i.percent)}% of ${f(i.theoretical)}`, rows: { lost: f(i.theoretical - actual), fraction: f(i.percent / 100) } };
    },

    equilibrium_constant: (i, c, f) => {
        const read = balanced(i.equation, c.data.elements);

        if (!read.result) {
            return read;
        }

        const amounts = readAmounts(i.concentrations, read.result, c.data.elements, 'm');

        if (amounts.error) {
            return amounts;
        }

        let concentrations = concentrationsFrom(amounts.found);
        let ice = null;

        if (i.mode === 'ice') {
            let known;

            try {
                known = findSpecies(read.result, i.known_species, c.data.elements);
            } catch (error) {
                if (error instanceof FormulaError) {
                    return { error: error.message };
                }

                throw error;
            }

            if (!known || Number.isNaN(i.known_value)) {
                return { empty: 'Enter which species you measured at equilibrium and its concentration.' };
            }

            const initial = concentrationsFrom(amounts.found);
            const start = initial.get(speciesKey(known.item)) ?? 0;
            const extent = (i.known_value - start) / known.nu;
            concentrations = new Map();
            ice = [];

            for (const { item, nu } of speciesList(read.result)) {
                if (item.phase === 's' || item.phase === 'l') {
                    continue;
                }

                const begin = initial.get(speciesKey(item)) ?? 0;
                const end = begin + nu * extent;

                if (end < -1e-12) {
                    return { error: `${item.text} would become negative; check the initial amounts.` };
                }

                concentrations.set(speciesKey(item), Math.max(0, end));
                ice.push({ label: item.text, value: `${f(begin)} → ${nu * extent >= 0 ? '+' : ''}${f(nu * extent)} → ${f(Math.max(0, end))}` });
            }
        }

        const q = quotient(read.result, concentrations);

        if (q.missing) {
            return { empty: `Enter the concentration of ${q.missing}.` };
        }

        return {
            value: f(q.value),
            unit: '',
            label: 'Equilibrium constant K',
            sub: `K = ${expression(read.result)} (pure solids and liquids left out)`,
            rows: { log: f(Math.log10(q.value)), favors: q.value > 1 ? 'Products' : q.value < 1 ? 'Reactants' : 'Neither', equation: formatEquation(read.result) },
            lists: { ice: ice ?? [...concentrations].map(([key, value]) => ({ label: key.split('|')[0], value: f(value) })) },
        };
    },

    reaction_quotient: (i, c, f) => {
        const read = balanced(i.equation, c.data.elements);

        if (!read.result) {
            return read;
        }

        const amounts = readAmounts(i.concentrations, read.result, c.data.elements, 'm');

        if (amounts.error) {
            return amounts;
        }

        const q = quotient(read.result, concentrationsFrom(amounts.found));

        if (q.missing) {
            return { empty: `Enter the concentration of ${q.missing}.` };
        }

        const k = i.k > 0 ? i.k : null;
        const direction = k === null ? 'Enter K to compare' : Math.abs(q.value / k - 1) < 1e-9 ? 'At equilibrium' : q.value < k ? 'Q < K: shifts towards products' : 'Q > K: shifts towards reactants';

        return {
            value: f(q.value),
            unit: '',
            label: 'Reaction quotient Q',
            sub: direction,
            rows: { direction, ratio: k === null ? '—' : f(q.value / k), equation: formatEquation(read.result) },
        };
    },

    kp: (i, c, f) => {
        let delta = i.delta_n;

        if (String(i.equation ?? '').trim()) {
            const read = balanced(i.equation, c.data.elements);

            if (!read.result) {
                return read;
            }

            const gases = speciesList(read.result).filter(({ item }) => item.phase === 'g');

            if (!gases.length) {
                return { error: 'Mark the gases with (g), e.g. N2(g) + 3H2(g) = 2NH3(g).' };
            }

            delta = gases.reduce((sum, { nu }) => sum + nu, 0);
        }

        if (Number.isNaN(delta) || missing(i, 'k', 'temperature') || !(i.k > 0)) {
            return { empty: 'Enter K, the temperature and Δn (or an equation with gases marked (g)).' };
        }

        const T = kelvin(i.temperature);
        const gas = i.pressure_unit === 'bar' ? 0.0831446262 : 0.0820573661;
        const factor = (gas * T) ** delta;
        const toKp = i.direction === 'kc_to_kp';

        return {
            value: f(toKp ? i.k * factor : i.k / factor),
            unit: '',
            label: toKp ? 'Kp' : 'Kc',
            sub: `Kp = Kc (RT)^Δn with Δn = ${f(delta)} and R = ${gas} L·${i.pressure_unit === 'bar' ? 'bar' : 'atm'}/(mol·K)`,
            rows: { delta: f(delta), rt: f(gas * T), kelvin: `${f(T)} K` },
        };
    },

    rate_constant: (i, c, f) => {
        const order = Number(i.order);
        let k;

        if (i.mode === 'halflife') {
            if (!(i.half_life > 0) || (order !== 1 && !(i.a0 > 0))) {
                return { empty: order === 1 ? 'Enter the half-life.' : 'Enter the half-life and initial concentration.' };
            }

            k = order === 0 ? i.a0 / (2 * i.half_life) : order === 1 ? Math.LN2 / i.half_life : 1 / (i.half_life * i.a0);
        } else {
            if (missing(i, 'a0', 'at', 'time') || !(i.a0 > 0) || !(i.at > 0) || !(i.time > 0) || i.at >= i.a0) {
                return { empty: 'Enter [A]₀, a lower [A] at time t, and t.' };
            }

            k = order === 0 ? (i.a0 - i.at) / i.time : order === 1 ? Math.log(i.a0 / i.at) / i.time : (1 / i.at - 1 / i.a0) / i.time;
        }

        const units = ['M/s', '1/s', '1/(M·s)'][order];
        const halfLife = order === 0 ? (i.a0 > 0 ? i.a0 / (2 * k) : null) : order === 1 ? Math.LN2 / k : i.a0 > 0 ? 1 / (k * i.a0) : null;

        return {
            value: f(k),
            unit: units,
            label: `Rate constant (order ${order})`,
            sub: ['[A] = [A]₀ − kt', 'ln[A] = ln[A]₀ − kt', '1/[A] = 1/[A]₀ + kt'][order],
            rows: { half: halfLife === null ? 'Enter [A]₀' : `${f(halfLife)} s`, units, rate: i.a0 > 0 ? `${f(k * i.a0 ** order)} M/s at [A]₀` : '—' },
        };
    },

    arrhenius: (i, c, f) => {
        const T = kelvin(i.temperature);
        const ea = i.ea * 1000;
        const solve = i.solve;
        const values = { k: i.k, a: i.a, ea, t: T };

        if (solve !== 't' && !(T > 0)) {
            return { empty: 'Enter the temperature.' };
        }

        if (solve === 'k') {
            if (!(i.a > 0) || Number.isNaN(ea)) {
                return { empty: 'Enter A and Ea.' };
            }

            values.k = i.a * Math.exp(-ea / (R * T));
        } else if (solve === 'a') {
            if (!(i.k > 0) || Number.isNaN(ea)) {
                return { empty: 'Enter k and Ea.' };
            }

            values.a = i.k / Math.exp(-ea / (R * T));
        } else if (solve === 'ea') {
            if (!(i.k > 0) || !(i.a > 0) || i.k >= i.a) {
                return { empty: 'Enter k and A (k smaller than A).' };
            }

            values.ea = -R * T * Math.log(i.k / i.a);
        } else {
            if (!(i.k > 0) || !(i.a > 0) || Number.isNaN(ea) || i.k >= i.a) {
                return { empty: 'Enter k, A and Ea (k smaller than A).' };
            }

            values.t = -ea / (R * Math.log(i.k / i.a));
        }

        const shown = { k: [f(values.k), 'same unit as A', 'Rate constant k'], a: [f(values.a), 'same unit as k', 'Pre-exponential factor A'], ea: [f(values.ea / 1000), 'kJ/mol', 'Activation energy'], t: [f(values.t - 273.15), '°C', 'Temperature'] }[solve];

        return {
            value: shown[0],
            unit: shown[1],
            label: shown[2],
            sub: 'k = A e^(−Ea/RT)',
            rows: { kelvin: `${f(values.t)} K`, fraction: `e^(−Ea/RT) = ${f(Math.exp(-values.ea / (R * values.t)))}` },
            lists: { temperatures: [-20, -10, 0, 10, 20].map((offset) => ({ label: `${f(values.t - 273.15 + offset)} °C`, value: f(values.a * Math.exp(-values.ea / (R * (values.t + offset)))), highlight: offset === 0 })) },
        };
    },

    activation_energy: (i, c, f) => {
        if (missing(i, 'k1', 't1', 'k2', 't2') || !(i.k1 > 0) || !(i.k2 > 0)) {
            return { empty: 'Enter two rate constants and their temperatures.' };
        }

        const T1 = kelvin(i.t1);
        const T2 = kelvin(i.t2);

        if (T1 <= 0 || T2 <= 0 || T1 === T2) {
            return { error: 'Use two different temperatures above absolute zero.' };
        }

        const ea = (-R * Math.log(i.k2 / i.k1)) / (1 / T2 - 1 / T1);
        const a = i.k1 / Math.exp(-ea / (R * T1));
        const T3 = Number.isNaN(i.t3) ? null : kelvin(i.t3);

        return {
            value: f(ea / 1000),
            unit: 'kJ/mol',
            label: 'Activation energy',
            sub: 'ln(k₂/k₁) = −Ea/R × (1/T₂ − 1/T₁)',
            rows: { a: `${f(a)} (units of k)`, k3: T3 ? `${f(a * Math.exp(-ea / (R * T3)))} at ${f(i.t3)} °C` : 'Enter a third temperature', ratio: `k rises ${f(i.k2 / i.k1)}× from T₁ to T₂` },
        };
    },
};


export default defineTools(handlers);
