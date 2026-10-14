/**
 * Drops ↔ milliliters for a given drop factor (drops per mL), as printed on IV giving sets.
 */
export const DROP_FACTORS = [10, 15, 20, 60];
const TEASPOON_ML = 4.92892159375;
const FLUID_OUNCE_ML = 29.5735295625;

export function dropsToMilliliters(drops, dropsPerMl) {
    return drops / dropsPerMl;
}

export default function drops(ctx) {
    ctx.onUpdate(() => {
        const toMl = ctx.choice('direction') === 'drops:ml';
        const factor = Number(ctx.choice('factor'));
        const value = ctx.number('value');

        ctx.setText('value-suffix', toMl ? 'drops' : 'mL');

        if (Number.isNaN(value)) {
            ctx.clearResult();

            return;
        }

        if (value < 0) {
            ctx.showError('Enter an amount of 0 or more.');

            return;
        }

        const ml = toMl ? dropsToMilliliters(value, factor) : value;
        const dropCount = toMl ? value : value * factor;

        ctx.showResult(toMl
            ? { value: ctx.format(ml), unit: 'mL', label: 'Milliliters', sub: `${ctx.format(value)} drops ÷ ${factor} drops/mL` }
            : { value: ctx.format(dropCount), unit: 'drops', label: 'Drops', sub: `${ctx.format(value)} mL × ${factor} drops/mL` });

        ctx.setRow('tsp', ctx.format(ml / TEASPOON_ML));
        ctx.setRow('floz', ctx.format(ml / FLUID_OUNCE_ML));
        ctx.setRow('l', ctx.format(ml / 1000));

        ctx.renderRows('factors', DROP_FACTORS.map((dropsPerMl) => ({
            label: `${dropsPerMl} drops/mL`,
            value: toMl ? `${ctx.format(dropsToMilliliters(value, dropsPerMl))} mL` : `${ctx.format(value * dropsPerMl)} drops`,
            highlight: dropsPerMl === factor,
        })));
    });
}
