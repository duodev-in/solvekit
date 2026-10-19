import { formatMoney } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { findIngredient, ingredient, kn, lineGrams, parseAmount, parseUnit } from '../food/kitchen.js';
import { parseRows } from '../rows-editor.js';

/**
 * Nutrition from ingredient lists (USDA FoodData Central per 100 g), the emergency food and water supply, and recipe costs.
 */
const or0 = (value) => (Number.isFinite(value) ? value : 0);

// FDA Daily Values for a 2,000 kcal diet (21 CFR 101.9).
const DAILY = { fat: 78, carbs: 275, fiber: 28, protein: 50, sodium: 2300 };
const NUTRIENTS = ['kcal', 'protein', 'fat', 'carbs', 'fiber', 'sugar', 'sodium'];

/**
 * Totals for recipe lines "amount, unit, food": grams from USDA household measures, nutrients from per-100 g values.
 */
export function nutritionTotals(text, config) {
    const lines = parseRows(text).map(([amountText, unitText, name]) => {
        const match = findIngredient(config, name);
        const grams = match ? lineGrams(parseAmount(amountText), parseUnit(unitText), match.row) : NaN;

        return { name: name ?? '', amountText: `${amountText ?? ''} ${unitText ?? ''}`.trim(), match, grams };
    }).filter((line) => line.name);
    const totals = Object.fromEntries(NUTRIENTS.map((key) => [key, 0]));

    lines.filter((line) => Number.isFinite(line.grams)).forEach((line) => {
        NUTRIENTS.forEach((key) => {
            totals[key] += (or0(line.match.row.per100[key]) * line.grams) / 100;
        });
    });

    return { lines, totals };
}

function nutritionOutcome(i, c, label) {
    const { lines, totals } = nutritionTotals(i.items, c);
    const counted = lines.filter((line) => Number.isFinite(line.grams));

    if (!counted.length) {
        return { empty: 'Add foods with an amount and unit (for example 1, cup, Romaine lettuce).' };
    }

    const servings = Number.isFinite(i.servings) && i.servings > 0 ? i.servings : 1;
    const per = (key) => totals[key] / servings;
    const dv = (key) => `${kn(Math.round((100 * per(key)) / DAILY[key]))}% DV`;
    const missing = lines.filter((line) => !Number.isFinite(line.grams)).map((line) => line.name);
    // Walking at about 3 mph is 3.5 METs (Compendium of Physical Activities): kcal a minute = MET × 3.5 × kg ÷ 200.
    const kg = Number.isFinite(i.weight) && i.weight > 0 ? i.weight : 70;
    const walk = per('kcal') / ((3.5 * 3.5 * kg) / 200);

    return {
        value: `${kn(Math.round(per('kcal')))} kcal`,
        label: servings > 1 ? `${label} per serving` : label,
        sub: `${servings > 1 ? `${kn(Math.round(totals.kcal))} kcal in all, ${kn(servings)} servings; ` : ''}${kn(Math.round(counted.reduce((s, l) => s + l.grams, 0)))} g of food (USDA FoodData Central)`,
        rows: {
            protein: `${kn(per('protein'))} g (${dv('protein')})`,
            fat: `${kn(per('fat'))} g (${dv('fat')})`,
            carbs: `${kn(per('carbs'))} g (${dv('carbs')})`,
            fiber: `${kn(per('fiber'))} g (${dv('fiber')})`,
            sugar: `${kn(per('sugar'))} g total sugars`,
            sodium: `${kn(Math.round(per('sodium')))} mg (${dv('sodium')})`,
            walk: `${kn(Math.round(walk))} minutes of walking at 3 mph for ${kn(kg)} kg`,
            missing: missing.length ? `Not counted: ${missing.join(', ')}` : 'All foods counted',
        },
        grids: {
            foods: {
                columns: ['Grams', 'kcal', 'Protein', 'Fat', 'Carbs'],
                rows: lines.map((line) => {
                    const row = line.match?.row;
                    const g = line.grams;
                    const part = (key) => (Number.isFinite(g) ? kn((or0(row.per100[key]) * g) / 100) : '—');

                    return { header: row ? row.name : `${line.name} (not found)`, cells: [Number.isFinite(g) ? kn(g) : '—', Number.isFinite(g) ? kn(Math.round((row.per100.kcal * g) / 100)) : '—', part('protein'), part('fat'), part('carbs')] };
                }),
            },
        },
    };
}

// An example shelf-stable plan: shares of calories from each staple (USDA energy per 100 g).
const SUPPLY = [['rice_white', 'White rice (dry)', 0.3], ['pasta_elbows', 'Pasta (dry)', 0.15], ['oats', 'Rolled oats', 0.1], ['black_beans', 'Dry beans', 0.1], ['peanut_butter', 'Peanut butter', 0.12], ['tuna', 'Canned tuna (drained)', 0.05], ['raisins', 'Raisins or dried fruit', 0.08], ['oil_vegetable', 'Vegetable oil', 0.1]];

export const handlers = {
    // Pages name their result (Salad calories, Calories per serving) with calc.label.
    nutrition: (i, c) => nutritionOutcome(i, c, c.label ?? 'Calories'),

    quarantine: (i, c) => {
        const people = or0(i.adults) + or0(i.kids);
        const days = or0(i.days);

        if (people <= 0 || days <= 0) {
            return { empty: 'Enter the people and the number of days.' };
        }

        const kcal = (or0(i.adults) * or0(i.adult_kcal) + or0(i.kids) * or0(i.kid_kcal)) * days;
        // Ready.gov: at least one gallon of water per person per day, for drinking and sanitation.
        const gallons = people * days + or0(i.pets) * days * 0.25;
        const items = SUPPLY.map(([key, name, share]) => {
            const row = ingredient(c, key);
            const kg = (kcal * share) / row.per100.kcal / 10;

            return { header: name, cells: [`${kn(kg)} kg (${kn(kg * 2.20462)} lb)`, `${kn(Math.round(kcal * share))} kcal`] };
        });

        return {
            value: `${kn(Math.round(kcal))} kcal`,
            label: 'Food energy needed',
            sub: `${kn(people)} ${people === 1 ? 'person' : 'people'} for ${kn(days)} days; ${kn(gallons)} US gallons (${kn(gallons * 3.785)} L) of water`,
            rows: {
                water: `${kn(gallons)} gallons (${kn(gallons * 3.785)} L): 1 gallon a person a day${or0(i.pets) ? ', plus about ¼ gallon a day for each pet' : ''}`,
                perDay: `${kn(Math.round(kcal / days))} kcal a day for the household`,
                readyGov: days < 3 ? 'Ready.gov advises at least a 3-day supply for evacuation and 2 weeks at home' : days < 14 ? 'Ready.gov suggests 2 weeks of supplies at home' : 'Rotate stock: use and replace before the best-by dates',
                other: 'Add a manual can opener, any medicines, baby food or formula, and food for special diets',
            },
            grids: { plan: { columns: ['Amount', 'Energy'], rows: items } },
        };
    },

    recipe_cost: (i) => {
        const lines = parseRows(i.items).map(([name, price, pack, used]) => ({ name, price: parseAmount(price), pack: parseAmount(pack), used: parseAmount(used) }))
            .filter((line) => line.name && Number.isFinite(line.price) && line.pack > 0 && Number.isFinite(line.used))
            .map((line) => ({ ...line, cost: (line.price * line.used) / line.pack }));

        if (!lines.length) {
            return { empty: 'Add ingredients: price paid, package size and amount used (same unit).' };
        }

        const total = lines.reduce((sum, line) => sum + line.cost, 0) * (1 + or0(i.extra) / 100);
        const servings = or0(i.servings) || 1;
        const top = lines.reduce((a, b) => (b.cost > a.cost ? b : a));

        return {
            value: formatMoney(total / servings),
            label: 'Cost per serving',
            sub: `${formatMoney(total)} for ${kn(servings)} servings`,
            rows: {
                total: formatMoney(total),
                top: `${top.name}: ${formatMoney(top.cost)} (${kn((100 * top.cost) / lines.reduce((s, l) => s + l.cost, 0))}% of ingredients)`,
                extra: or0(i.extra) ? `${kn(i.extra)}% added for oil, spices and small items` : 'No allowance for pantry items',
                price: or0(i.margin) > 0 && or0(i.margin) < 100 ? `${formatMoney(total / servings / (1 - i.margin / 100))} a serving to sell at a ${kn(i.margin)}% margin` : 'Set a margin to see a selling price',
            },
            grids: { costs: { columns: ['Used', 'Cost'], rows: lines.map((line) => ({ header: line.name, cells: [`${kn(line.used)} of ${kn(line.pack)}`, formatMoney(line.cost)], highlight: line === top })) } },
        };
    },
};

export default defineTools(handlers);
