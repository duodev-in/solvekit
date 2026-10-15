/**
 * Volume of a box from length × width × height, each in its own length unit.
 *
 * Config: lengthUnits (factor = meters), volumeUnits (factor = liters), primary, rows.
 */
const DIMENSIONS = ['length', 'width', 'height'];

export function boxVolumeLiters(dimensionsInMeters) {
    return dimensionsInMeters.reduce((product, meters) => product * meters, 1) * 1000;
}

export default function boxVolume(ctx, config) {
    const { lengthUnits, volumeUnits, primary, rows } = config;

    ctx.onUpdate(() => {
        const values = DIMENSIONS.map((name) => ctx.number(name));

        if (values.some(Number.isNaN)) {
            ctx.clearResult('Enter length, width and height.');

            return;
        }

        if (values.some((value) => value < 0)) {
            ctx.showError('Dimensions cannot be negative.');

            return;
        }

        const units = DIMENSIONS.map((name) => lengthUnits[ctx.field(`${name}-unit`).value]);
        const meters = values.map((value, index) => value * units[index].factor);
        const liters = boxVolumeLiters(meters);
        const target = volumeUnits[primary];

        ctx.showResult({
            value: ctx.format(liters / target.factor),
            unit: target.symbol,
            sub: values.map((value, index) => `${ctx.format(value)} ${units[index].symbol}`).join(' × '),
        });

        rows.forEach((key) => ctx.setRow(key, ctx.format(liters / volumeUnits[key].factor)));
    });
}
