/**
 * Voltage from energy and charge: V = E ÷ Q.
 * Config: energyUnits (factor = J), chargeUnits (factor = C).
 */
export function volts(energyJ, chargeC) {
    return energyJ / chargeC;
}

export default function joulesToVolts(ctx, config) {
    const { energyUnits, chargeUnits } = config;

    ctx.onUpdate(() => {
        const energy = ctx.number('energy');
        const charge = ctx.number('charge');
        const energyUnit = energyUnits[ctx.field('energy-unit').value];
        const chargeUnit = chargeUnits[ctx.field('charge-unit').value];

        if (Number.isNaN(energy) || Number.isNaN(charge)) {
            ctx.clearResult('Enter the energy and the charge.');

            return;
        }

        if (charge === 0) {
            ctx.showError('Charge must not be 0.');

            return;
        }

        const energyJ = energy * energyUnit.factor;
        const chargeC = charge * chargeUnit.factor;
        const voltage = volts(energyJ, chargeC);

        ctx.showResult({ value: ctx.format(voltage), unit: 'V', sub: `${ctx.format(energy)} ${energyUnit.symbol} ÷ ${ctx.format(charge)} ${chargeUnit.symbol}` });
        ctx.setRow('mv', ctx.format(voltage * 1000));
        ctx.setRow('kv', ctx.format(voltage / 1000));
        ctx.setRow('j', ctx.format(energyJ));
        ctx.setRow('c', ctx.format(chargeC));

        ctx.renderSteps('steps', [
            `E = ${ctx.format(energyJ)} J`,
            `Q = ${ctx.format(chargeC)} C`,
            `V = E ÷ Q = ${ctx.format(voltage)} V`,
        ]);
    });
}
