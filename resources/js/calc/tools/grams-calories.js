/**
 * Food energy from weight: values per 100 g scaled to the weight entered.
 * Config: foods { key: { name, kcal, carbs, protein, fat } }, weightUnits (factor = grams), compare.
 */
export const KJ_PER_KCAL = 4.184;
export const DAILY_KCAL = 2000;

export function nutrition(food, grams) {
    const scale = grams / 100;

    return { kcal: food.kcal * scale, carbs: food.carbs * scale, protein: food.protein * scale, fat: food.fat * scale };
}

export default function gramsCalories(ctx, config) {
    const { foods, weightUnits, compare } = config;

    ctx.onUpdate(() => {
        const weight = ctx.number('weight');
        const unit = weightUnits[ctx.field('weight-unit').value];
        const key = ctx.field('food').value;
        const custom = key === 'custom';
        const food = custom ? { name: 'Custom food', kcal: ctx.number('custom-kcal'), carbs: 0, protein: 0, fat: 0 } : foods[key];

        if (Number.isNaN(weight) || Number.isNaN(food.kcal)) {
            ctx.clearResult('Enter the weight of the food.');

            return;
        }

        if (weight < 0 || food.kcal < 0) {
            ctx.showError('Weight and calories cannot be negative.');

            return;
        }

        const grams = weight * unit.factor;
        const values = nutrition(food, grams);

        ctx.showResult({ value: ctx.format(values.kcal), unit: 'kcal', label: `Calories in ${food.name.toLowerCase()}`, sub: `${ctx.format(grams)} g × ${ctx.format(food.kcal)} kcal per 100 g` });
        ctx.setRow('kj', ctx.format(values.kcal * KJ_PER_KCAL));
        ctx.setRow('per100', `${ctx.format(food.kcal)} kcal`);
        ctx.setRow('carbs', custom ? '—' : `${ctx.format(values.carbs)} g`);
        ctx.setRow('protein', custom ? '—' : `${ctx.format(values.protein)} g`);
        ctx.setRow('fat', custom ? '—' : `${ctx.format(values.fat)} g`);
        ctx.setRow('daily', `${ctx.format((values.kcal / DAILY_KCAL) * 100)}%`);

        ctx.renderRows('compare', compare.map((other) => ({ label: foods[other].name, value: `${ctx.format(nutrition(foods[other], grams).kcal)} kcal`, highlight: other === key })));
        ctx.setText('compare-heading', `${ctx.format(grams)} g of other foods`);
    });
}
