/**
 * PPM (by mass, mg/kg) ↔ mg/L through the solution's density: mg/L = ppm × density (kg/L).
 */
export function mgPerLitre(ppm, density) {
    return ppm * density;
}

export default function ppmMgl(ctx, config) {
    const { quickRef } = config;

    ctx.onUpdate(() => {
        const toMgl = ctx.choice('direction') === 'ppm';
        const value = ctx.number('value');
        const density = ctx.number('density');

        ctx.setText('value-suffix', toMgl ? 'ppm' : 'mg/L');

        if (Number.isNaN(value) || Number.isNaN(density)) {
            ctx.clearResult();

            return;
        }

        if (value < 0 || density <= 0) {
            ctx.showError('The value cannot be negative and density must be greater than 0.');

            return;
        }

        const mgl = toMgl ? mgPerLitre(value, density) : value;
        const ppmValue = toMgl ? value : value / density;

        ctx.showResult(toMgl
            ? { value: ctx.format(mgl), unit: 'mg/L', label: 'Milligrams per liter', sub: `${ctx.format(value)} ppm × ${ctx.format(density)} kg/L` }
            : { value: ctx.format(ppmValue), unit: 'ppm', label: 'Parts per million', sub: `${ctx.format(value)} mg/L ÷ ${ctx.format(density)} kg/L` });

        ctx.setRow('ugml', ctx.format(mgl));
        ctx.setRow('ppb', ctx.format(ppmValue * 1000));
        ctx.setRow('percent', ctx.format(ppmValue / 10000));
        ctx.setRow('gl', ctx.format(mgl / 1000));
        ctx.renderRows('quick-ref', quickRef.map((input) => ({ label: `${ctx.format(input)} ppm`, value: `${ctx.format(mgPerLitre(input, density))} mg/L` })));
    });
}
