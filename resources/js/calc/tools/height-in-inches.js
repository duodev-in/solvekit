const MAX_INCHES = 120;
const QUICK_REFERENCE = [60, 64, 66, 69, 72, 76];

/**
 * Splits inches into whole feet and inches, rounding first so 71.96 in reads 6′ 0″, never 5′ 12″.
 */
export function splitFeetInches(totalInches, inchDecimals = 1) {
    const scale = 10 ** inchDecimals;
    const rounded = Math.round(totalInches * scale) / scale;
    const feet = Math.floor(rounded / 12);
    const inches = Math.round((rounded - feet * 12) * scale) / scale;

    return { feet, inches };
}

export function formatHeight(totalInches) {
    const { feet, inches } = splitFeetInches(totalInches);

    return `${feet}′ ${inches}″`;
}

export default function heightInInches(ctx) {
    ctx.onUpdate(() => {
        const inches = ctx.number('value');

        ctx.renderRows('quick-ref', QUICK_REFERENCE.map((value) => ({
            label: `${value} in`,
            value: `${formatHeight(value)} · ${ctx.format(value * 2.54)} cm`,
            highlight: value === inches,
        })));

        if (Number.isNaN(inches)) {
            ctx.clearResult();

            return;
        }

        if (inches < 0 || inches > MAX_INCHES) {
            ctx.showError(`Enter a height between 0 and ${MAX_INCHES} inches.`);

            return;
        }

        ctx.showResult({ value: formatHeight(inches), unit: '', sub: `${ctx.format(inches)} in ÷ 12 = ${ctx.format(inches / 12)} ft` });
        ctx.setRow('cm', ctx.format(inches * 2.54));
        ctx.setRow('m', ctx.format((inches * 2.54) / 100));
        ctx.setRow('ft', ctx.format(inches / 12));
    });
}
