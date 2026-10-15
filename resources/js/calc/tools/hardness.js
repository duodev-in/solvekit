/**
 * Hardness conversion by linear interpolation in the ASTM E140 steel table.
 * Config: scales { key: { name, symbol } } and rows [[HRC, HV, HBW, HRA], …] (HRC descending).
 */
export function interpolate(rows, fromIndex, toIndex, value) {
    const points = rows.filter((row) => row[fromIndex] !== null && row[toIndex] !== null).map((row) => [row[fromIndex], row[toIndex]]).sort((a, b) => a[0] - b[0]);

    if (!points.length || value < points[0][0] || value > points[points.length - 1][0]) {
        return null;
    }

    for (let index = 1; index < points.length; index += 1) {
        const [x1, y1] = points[index - 1];
        const [x2, y2] = points[index];

        if (value <= x2) {
            return x2 === x1 ? y1 : y1 + ((value - x1) * (y2 - y1)) / (x2 - x1);
        }
    }

    return points[points.length - 1][1];
}

export function range(rows, index) {
    const values = rows.map((row) => row[index]).filter((value) => value !== null);

    return [Math.min(...values), Math.max(...values)];
}

export default function hardness(ctx, config) {
    const keys = Object.keys(config.scales);

    // Scales have different ranges, so swapping also carries the current result across:
    // 60 HRC → 697 HV, swap → 697 HV → 60 HRC.
    ctx.root.querySelector('[data-calc-swap]')?.addEventListener('click', () => {
        const from = ctx.field('from');
        const to = ctx.field('to');
        const converted = interpolate(config.rows, keys.indexOf(from.value), keys.indexOf(to.value), ctx.number('value'));

        if (converted !== null && !Number.isNaN(converted)) {
            ctx.field('value').value = String(Math.round(converted * 10) / 10);
        }

        [from.value, to.value] = [to.value, from.value];
        ctx.update();
    });

    ctx.onUpdate(() => {
        const from = ctx.field('from').value;
        const to = ctx.field('to').value;
        const value = ctx.number('value');
        const fromIndex = keys.indexOf(from);
        const [low, high] = range(config.rows, fromIndex);

        ctx.setText('value-suffix', config.scales[from].symbol);

        if (Number.isNaN(value)) {
            ctx.clearResult();

            return;
        }

        if (value < low || value > high) {
            ctx.showError(`The table covers ${config.scales[from].symbol} ${low} to ${high}. Outside that range there is no reliable conversion.`);

            return;
        }

        const converted = interpolate(config.rows, fromIndex, keys.indexOf(to), value);

        if (converted === null) {
            ctx.showError(`No ${config.scales[to].symbol} equivalent at this hardness (outside the standard Brinell range).`);

            return;
        }

        ctx.showResult({ value: ctx.format(converted), unit: config.scales[to].symbol, label: config.scales[to].name, sub: `≈ from ${ctx.format(value)} ${config.scales[from].symbol}, steel, ASTM E140` });

        keys.forEach((key, index) => {
            const equivalent = interpolate(config.rows, fromIndex, index, value);
            ctx.setRow(key, equivalent === null ? 'outside range' : ctx.format(equivalent));
        });
    });
}
