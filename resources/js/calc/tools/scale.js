/**
 * Map and drawing scales. A scale of 1:N means one unit on the map is N of the same unit in reality.
 * Config: lengthUnits (factor = meters).
 */
export function scaleDenominator(mapMeters, realMeters) {
    return realMeters / mapMeters;
}

export function formatRatio(denominator) {
    if (denominator >= 1) {
        return `1:${new Intl.NumberFormat('en-US', { maximumFractionDigits: 2 }).format(denominator)}`;
    }

    // Enlargements such as detail drawings: 5:1 instead of 1:0.2.
    return `${new Intl.NumberFormat('en-US', { maximumFractionDigits: 2 }).format(1 / denominator)}:1`;
}

export default function scale(ctx, config) {
    const { lengthUnits } = config;
    const unit = (name) => lengthUnits[ctx.field(name).value];

    ctx.onUpdate(() => {
        const mode = ctx.choice('mode');
        let denominator = ctx.number('ratio');
        let mapMeters = ctx.number('map') * unit('map-unit').factor;
        let realMeters = ctx.number('real') * unit('real-unit').factor;

        const needs = { scale: [mapMeters, realMeters], real: [mapMeters, denominator], map: [realMeters, denominator] }[mode];

        if (needs.some(Number.isNaN)) {
            ctx.clearResult('Fill in both fields for this mode.');

            return;
        }

        if (needs.some((value) => value <= 0)) {
            ctx.showError('Distances and the scale must be greater than 0.');

            return;
        }

        if (mode === 'scale') {
            denominator = scaleDenominator(mapMeters, realMeters);
            ctx.showResult({ value: formatRatio(denominator), unit: '', label: 'Scale', sub: `${ctx.format(ctx.number('map'))} ${unit('map-unit').symbol} on the map = ${ctx.format(ctx.number('real'))} ${unit('real-unit').symbol} in reality` });
        } else if (mode === 'real') {
            realMeters = mapMeters * denominator;
            const shown = realMeters / unit('real-unit').factor;
            ctx.showResult({ value: ctx.format(shown), unit: unit('real-unit').symbol, label: 'Real distance', sub: `${ctx.format(ctx.number('map'))} ${unit('map-unit').symbol} at ${formatRatio(denominator)}` });
        } else {
            mapMeters = realMeters / denominator;
            const shown = mapMeters / unit('map-unit').factor;
            ctx.showResult({ value: ctx.format(shown), unit: unit('map-unit').symbol, label: 'Map distance', sub: `${ctx.format(ctx.number('real'))} ${unit('real-unit').symbol} at ${formatRatio(denominator)}` });
        }

        ctx.setRow('ratio', formatRatio(denominator));
        ctx.setRow('cm', `${ctx.format(denominator / 100)} m (${ctx.format(denominator / 100000)} km)`);
        ctx.setRow('in', `${ctx.format(denominator / 12)} ft (${ctx.format(denominator / 63360)} mi)`);
        ctx.setRow('km', `${ctx.format(100000 / denominator)} cm`);
        ctx.setRow('mi', `${ctx.format(63360 / denominator)} in`);
        ctx.setRow('type', denominator < 1 ? 'Enlargement (detail drawing)' : denominator <= 10000 ? 'Large scale (plans, site maps)' : denominator <= 100000 ? 'Medium scale (topographic maps)' : 'Small scale (regional and world maps)');
    });
}
