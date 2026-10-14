/**
 * Work done by a torque through an angle: W = τ × θ (θ in radians).
 * Config: torqueUnits (factor = N·m), angleUnits (factor = rad), energyUnits (factor = J), rows.
 */
export function work(torqueNm, angleRad) {
    return torqueNm * angleRad;
}

export default function nmToJoules(ctx, config) {
    const { torqueUnits, angleUnits, energyUnits, rows } = config;

    ctx.onUpdate(() => {
        const torque = ctx.number('torque');
        const angle = ctx.number('angle');
        const torqueUnit = torqueUnits[ctx.field('torque-unit').value];
        const angleUnit = angleUnits[ctx.field('angle-unit').value];

        if (Number.isNaN(torque) || Number.isNaN(angle)) {
            ctx.clearResult('Enter the torque and the angle turned.');

            return;
        }

        const torqueNm = torque * torqueUnit.factor;
        const radians = angle * angleUnit.factor;
        const joules = work(torqueNm, radians);

        ctx.showResult({ value: ctx.format(joules), unit: 'J', sub: `${ctx.format(torque)} ${torqueUnit.symbol} through ${ctx.format(angle)} ${angleUnit.symbol}` });
        rows.forEach((key) => ctx.setRow(key, ctx.format(joules / energyUnits[key].factor)));

        ctx.renderSteps('steps', [
            `τ = ${ctx.format(torqueNm)} N·m`,
            `θ = ${ctx.format(radians)} rad`,
            `W = τ × θ = ${ctx.format(joules)} J`,
        ]);
    });
}
