/**
 * Flow through a round orifice: Q = Cd × A × √(2ΔP / ρ), with water at 20 °C.
 * Config: pressureUnits (factor = Pa), lengthUnits (factor = m), flowUnits (factor = m³/s), rows.
 */
export const WATER_DENSITY = 998.2;

export function orificeFlow(pressurePa, diameterM, dischargeCoefficient, density = WATER_DENSITY) {
    const area = (Math.PI * diameterM ** 2) / 4;
    const velocity = Math.sqrt((2 * pressurePa) / density);

    return { area, velocity, flow: dischargeCoefficient * area * velocity };
}

export default function psiToGpm(ctx, config) {
    const { pressureUnits, lengthUnits, flowUnits, rows } = config;

    ctx.onUpdate(() => {
        const pressure = ctx.number('pressure');
        const diameter = ctx.number('diameter');
        const coefficient = ctx.number('coefficient');
        const pressureUnit = pressureUnits[ctx.field('pressure-unit').value];
        const lengthUnit = lengthUnits[ctx.field('diameter-unit').value];

        if ([pressure, diameter, coefficient].some(Number.isNaN)) {
            ctx.clearResult('Enter the pressure, opening diameter and discharge coefficient.');

            return;
        }

        if (pressure < 0 || diameter <= 0) {
            ctx.showError('Pressure cannot be negative and the diameter must be greater than 0.');

            return;
        }

        if (coefficient <= 0 || coefficient > 1) {
            ctx.showError('The discharge coefficient must be between 0 and 1.');

            return;
        }

        const { flow } = orificeFlow(pressure * pressureUnit.factor, diameter * lengthUnit.factor, coefficient);

        ctx.showResult({
            value: ctx.format(flow / flowUnits.gpm.factor),
            unit: 'gpm',
            sub: `${ctx.format(pressure)} ${pressureUnit.symbol} through ${ctx.format(diameter)} ${lengthUnit.symbol}, Cd ${ctx.format(coefficient)}`,
        });

        rows.forEach((key) => ctx.setRow(key, ctx.format(flow / flowUnits[key].factor)));
    });
}
