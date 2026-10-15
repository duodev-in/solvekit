const INCH_IN_CM = 2.54;

/**
 * Converts a feet + inches measurement. Inches may exceed 11; they carry into feet.
 */
export function feetInchesToMetric(feet, inches) {
    const totalInches = feet * 12 + inches;

    return {
        totalInches,
        normalisedFeet: Math.floor(totalInches / 12),
        normalisedInches: totalInches - Math.floor(totalInches / 12) * 12,
        centimeters: totalInches * INCH_IN_CM,
        meters: (totalInches * INCH_IN_CM) / 100,
        millimeters: totalInches * INCH_IN_CM * 10,
        decimalFeet: totalInches / 12,
        yards: totalInches / 36,
    };
}

export default function feetInches(ctx) {
    ctx.onUpdate(() => {
        const feet = ctx.number('feet');
        const inches = ctx.number('inches');

        if (Number.isNaN(feet) && Number.isNaN(inches)) {
            ctx.clearResult('Enter feet, inches or both.');

            return;
        }

        const ft = Number.isNaN(feet) ? 0 : feet;
        const inch = Number.isNaN(inches) ? 0 : inches;

        if (ft < 0 || inch < 0) {
            ctx.showError('Feet and inches cannot be negative.');

            return;
        }

        const result = feetInchesToMetric(ft, inch);

        ctx.showResult({
            value: ctx.format(result.centimeters),
            unit: 'cm',
            sub: `${ctx.format(result.normalisedFeet)} ft ${ctx.format(result.normalisedInches)} in = ${ctx.format(result.totalInches)} in`,
        });

        ctx.setRow('inches', ctx.format(result.totalInches));
        ctx.setRow('meters', ctx.format(result.meters));
        ctx.setRow('millimeters', ctx.format(result.millimeters));
        ctx.setRow('feet', ctx.format(result.decimalFeet));
        ctx.setRow('yards', ctx.format(result.yards));
    });
}
