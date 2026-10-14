/**
 * Power from torque and rotational speed: P = τ × ω, with ω = rpm × 2π / 60.
 * Config: torqueUnits (factor = N·m), powerUnits (factor = W), rows (power unit keys).
 */
export const RPM_REFERENCE = [1000, 2000, 3000, 4000, 5000, 6000];

export function powerWatts(torqueNm, rpm) {
    return torqueNm * rpm * (2 * Math.PI) / 60;
}

export default function torqueToHp(ctx, config) {
    const { torqueUnits, powerUnits, rows } = config;

    ctx.onUpdate(() => {
        const torque = ctx.number('torque');
        const rpm = ctx.number('rpm');
        const torqueUnit = torqueUnits[ctx.field('torque-unit').value];
        const powerUnit = powerUnits[ctx.field('power-unit').value];

        if (Number.isNaN(torque) || Number.isNaN(rpm)) {
            ctx.clearResult('Enter the torque and the engine speed.');

            return;
        }

        if (torque < 0 || rpm < 0) {
            ctx.showError('Torque and RPM cannot be negative.');

            return;
        }

        const torqueNm = torque * torqueUnit.factor;
        const watts = powerWatts(torqueNm, rpm);

        ctx.showResult({
            value: ctx.format(watts / powerUnit.factor),
            unit: powerUnit.symbol,
            label: powerUnit.name,
            sub: `${ctx.format(torque)} ${torqueUnit.symbol} at ${ctx.format(rpm)} rpm`,
        });

        rows.forEach((key) => ctx.setRow(key, ctx.format(watts / powerUnits[key].factor)));

        ctx.renderRows('quick-ref', RPM_REFERENCE.map((speed) => ({
            label: `${ctx.format(speed)} rpm`,
            value: `${ctx.format(powerWatts(torqueNm, speed) / powerUnit.factor)} ${powerUnit.symbol}`,
            highlight: speed === rpm,
        })));
        ctx.setText('quick-ref-heading', `${ctx.format(torque)} ${torqueUnit.symbol} at other speeds`);

        ctx.renderSteps('steps', [
            `Torque = ${ctx.format(torqueNm)} N·m`,
            `ω = ${ctx.format(rpm)} rpm × 2π ÷ 60 = ${ctx.format((rpm * 2 * Math.PI) / 60)} rad/s`,
            `P = τ × ω = ${ctx.format(watts)} W = ${ctx.format(watts / powerUnit.factor)} ${powerUnit.symbol}`,
        ]);
    });
}
