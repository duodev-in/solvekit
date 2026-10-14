export const RESOLUTIONS = [72, 96, 150, 300, 600];

export function pixelsToInches(pixels, dpi) {
    return pixels / dpi;
}

export default function pixelsToInchesTool(ctx) {
    ctx.onUpdate(() => {
        const pixels = ctx.number('pixels');
        const dpi = ctx.number('dpi');

        if (Number.isNaN(pixels) || Number.isNaN(dpi)) {
            ctx.clearResult('Enter the pixel count and the resolution.');

            return;
        }

        if (pixels < 0 || dpi <= 0) {
            ctx.showError('Pixels cannot be negative and DPI must be greater than 0.');

            return;
        }

        const inches = pixelsToInches(pixels, dpi);

        ctx.showResult({ value: ctx.format(inches), unit: 'in', sub: `${ctx.format(pixels)} px ÷ ${ctx.format(dpi)} DPI = ${ctx.format(inches)} in` });
        ctx.setRow('cm', ctx.format(inches * 2.54));
        ctx.setRow('mm', ctx.format(inches * 25.4));
        RESOLUTIONS.forEach((resolution) => ctx.setRow(`dpi${resolution}`, ctx.format(pixelsToInches(pixels, resolution))));
    });
}
