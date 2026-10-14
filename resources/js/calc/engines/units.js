/**
 * Unit-table engine: drives every unit converter (V1) and fixed-pair converter (V2).
 *
 * Config (built by the Blade components from config/units.php):
 *   units:     { key: { name, symbol, factor, offset?, inverse? } }  factor = base units per one
 *              of this unit. `offset` units (temperature) convert as (value + offset) × factor;
 *              `inverse` units (L/100 km) convert as factor ÷ value.
 *   list:      keys shown in the right-panel list
 *   quickRef:  input values for the quick-reference table (fixed-pair tools), or an object
 *              of such lists keyed by direction value when each direction needs its own scale
 *   min:       lowest accepted input (defaults to no limit)
 *   kitchenFraction: add a cooking fraction hint such as "about 1 ½ cups" to the result
 *
 * A direction value is "from:to". A key written as "@name" is read from another control, so one
 * toggle can pair a fixed unit with a unit picked elsewhere (e.g. "ml:@cup").
 */

const KITCHEN_FRACTIONS = [[0, ''], [1 / 4, '¼'], [1 / 3, '⅓'], [1 / 2, '½'], [2 / 3, '⅔'], [3 / 4, '¾'], [1, '']];
const KITCHEN_TOLERANCE = 0.03;

/**
 * The nearest everyday cooking fraction (quarters and thirds), or null when none is close.
 */
export function kitchenFraction(value) {
    if (!(value > 0)) {
        return null;
    }

    const whole = Math.floor(value);
    const [fraction, glyph] = KITCHEN_FRACTIONS.reduce((best, candidate) => (Math.abs(value - whole - candidate[0]) < Math.abs(value - whole - best[0]) ? candidate : best));

    if (Math.abs(value - whole - fraction) > KITCHEN_TOLERANCE) {
        return null;
    }

    const wholePart = whole + (fraction === 1 ? 1 : 0);

    if (wholePart === 0 && glyph === '') {
        return null;
    }

    return [wholePart > 0 ? String(wholePart) : '', glyph].filter(Boolean).join(' ');
}

export function convert(value, fromFactor, toFactor) {
    return (value * fromFactor) / toFactor;
}

export function toBase(value, unit) {
    if (unit.inverse) {
        return unit.factor / value;
    }

    return (value + (unit.offset ?? 0)) * unit.factor;
}

export function fromBase(base, unit) {
    if (unit.inverse) {
        return unit.factor / base;
    }

    return base / unit.factor - (unit.offset ?? 0);
}

/**
 * Converts between two units of one table, handling offset and inverse units.
 */
export function convertUnit(value, fromUnit, toUnit) {
    return fromBase(toBase(value, fromUnit), toUnit);
}

export function isLinear(unit) {
    return !unit.inverse && !unit.offset;
}

/**
 * The value of one `from` unit expressed in `to` units, e.g. 1 m = 3.28084 ft.
 */
export function unitRatio(units, from, to) {
    return convert(1, units[from].factor, units[to].factor);
}

/**
 * Reads the active from/to pair: a direction toggle ("from:to") wins over the two unit selects.
 */
function readPair(ctx) {
    const direction = ctx.choice('direction');

    if (direction) {
        const resolve = (key) => (key.startsWith('@') ? ctx.choice(key.slice(1)) : key);
        const [from, to] = direction.split(':').map(resolve);

        return { from, to };
    }

    return { from: ctx.field('from').value, to: ctx.field('to').value };
}

export default function unitsEngine(ctx, config) {
    const { units, list = [], quickRef = [], min, kitchenFraction: withFraction = false } = config;

    ctx.root.querySelector('[data-calc-swap]')?.addEventListener('click', () => {
        const from = ctx.field('from');
        const to = ctx.field('to');
        [from.value, to.value] = [to.value, from.value];
        ctx.update();
    });

    ctx.onUpdate(() => {
        const { from, to } = readPair(ctx);
        const value = ctx.number('value');
        const fromUnit = units[from];
        const toUnit = units[to];

        ctx.setText('value-suffix', fromUnit.symbol);
        ctx.setText('list-heading', Number.isNaN(value) ? `1 ${fromUnit.symbol} in other units` : `${ctx.format(value)} ${fromUnit.symbol} in other units`);
        const linear = isLinear(fromUnit) && isLinear(toUnit);
        ctx.setText('ratio', linear ? `1 ${fromUnit.symbol} = ${ctx.format(unitRatio(units, from, to))} ${toUnit.symbol}` : '');

        const quickInputs = Array.isArray(quickRef) ? quickRef : (quickRef[ctx.choice('direction')] ?? []);

        if (quickInputs.length) {
            ctx.renderRows('quick-ref', quickInputs.map((input) => ({
                label: `${ctx.format(input)} ${fromUnit.symbol}`,
                value: `${ctx.format(convertUnit(input, fromUnit, toUnit))} ${toUnit.symbol}`,
                highlight: input === value,
            })));
        }

        if (Number.isNaN(value)) {
            ctx.clearResult();

            return;
        }

        if (min !== undefined && value < min) {
            ctx.showError(`Enter a value of ${min} or more.`);

            return;
        }

        if (value === 0 && (fromUnit.inverse || toUnit.inverse)) {
            ctx.showError(`${fromUnit.name} must be greater than 0 for this conversion.`);

            return;
        }

        const converted = convertUnit(value, fromUnit, toUnit);
        const shown = ctx.format(converted);

        const fraction = withFraction ? kitchenFraction(converted) : null;

        ctx.showResult({
            value: shown,
            unit: toUnit.symbol,
            sub: linear
                ? `${ctx.format(value)} ${fromUnit.symbol} × ${ctx.format(unitRatio(units, from, to))} = ${shown} ${toUnit.symbol}${fraction ? ` · about ${fraction} ${toUnit.symbol}` : ''}`
                : `${ctx.format(value)} ${fromUnit.symbol} = ${shown} ${toUnit.symbol}`,
            label: `${toUnit.name}`,
        });

        list.forEach((key) => ctx.setRow(key, ctx.format(convertUnit(value, fromUnit, units[key]))));

        ctx.renderSteps('steps', linear
            ? [
                `Start with ${ctx.format(value)} ${fromUnit.symbol}.`,
                `1 ${fromUnit.symbol} = ${ctx.format(unitRatio(units, from, to))} ${toUnit.symbol}.`,
                `${ctx.format(value)} × ${ctx.format(unitRatio(units, from, to))} = ${shown} ${toUnit.symbol}.`,
            ]
            : [
                `Start with ${ctx.format(value)} ${fromUnit.symbol}.`,
                `Convert to the common base unit, then to ${toUnit.name.toLowerCase()}.`,
                `Result: ${shown} ${toUnit.symbol}.`,
            ]);
    });
}
