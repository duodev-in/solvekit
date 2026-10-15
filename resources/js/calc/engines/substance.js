/**
 * Substance engine: volume ↔ weight through a density (V6 tools such as Gallons to Pounds).
 *
 * Config:
 *   volumeUnits / massUnits: unit tables (factor = liters / grams per unit)
 *   volume / mass:           the unit keys this tool converts between
 *   substances:              { key: { name, density } } with density in g/mL
 *   densityScale:            how the density field is shown: 1 = g/mL, 1000 = mg/mL
 *   densityLabel:            text for that unit
 *   rows:                    { mass: [keys], volume: [keys] } listed beside the result
 *   compare:                 substance keys for the "same amount of other substances" table
 *
 * Direction radio (optional): "v2m" volume → mass, "m2v" mass → volume. One-way tools set
 * `direction` in the config instead.
 */

/**
 * Mass in grams of a volume in liters at a density in g/mL (1 L = 1000 mL).
 */
export function massFromVolume(liters, density) {
    return liters * 1000 * density;
}

/**
 * Volume in liters of a mass in grams at a density in g/mL.
 */
export function volumeFromMass(grams, density) {
    return grams / density / 1000;
}

export default function substanceEngine(ctx, config) {
    const { volumeUnits, massUnits, volume, mass, substances, direction: fixedDirection = 'v2m', densityScale = 1, densityLabel = 'g/mL', rows = {}, compare = [] } = config;
    const select = ctx.field('substance');
    const densityField = ctx.field('density');

    const fillDensity = () => {
        const substance = substances[select.value];

        if (substance) {
            densityField.value = String(Number((substance.density * densityScale).toPrecision(6)));
        }
    };

    // Picking a substance fills in its density; typing a different density switches to "Custom".
    select.addEventListener('change', () => {
        fillDensity();
        ctx.update();
    });
    densityField.addEventListener('input', () => {
        const substance = substances[select.value];

        if (substance && Math.abs(substance.density * densityScale - Number(densityField.value)) > 1e-9) {
            select.value = 'custom';
        }
    });

    ctx.onUpdate(() => {
        const direction = ctx.choice('direction') ?? fixedDirection;
        const toMass = direction === 'v2m';
        const fromUnit = toMass ? volumeUnits[volume] : massUnits[mass];
        const toUnit = toMass ? massUnits[mass] : volumeUnits[volume];
        const value = ctx.number('value');
        const density = ctx.number('density') / densityScale;

        ctx.setText('value-suffix', fromUnit.symbol);
        ctx.setText('value-label', toMass ? 'Volume' : 'Weight');

        if (Number.isNaN(value)) {
            ctx.clearResult();

            return;
        }

        if (value < 0) {
            ctx.showError('Enter an amount of 0 or more.');

            return;
        }

        if (!(density > 0)) {
            ctx.showError(`Enter a density greater than 0 ${densityLabel}.`);

            return;
        }

        const convertWith = (rho) => (toMass
            ? massFromVolume(value * fromUnit.factor, rho) / toUnit.factor
            : volumeFromMass(value * fromUnit.factor, rho) / toUnit.factor);

        const result = convertWith(density);
        const name = substances[select.value]?.name ?? 'Custom substance';

        ctx.showResult({
            value: ctx.format(result),
            unit: toUnit.symbol,
            label: `${toUnit.name} of ${name.toLowerCase()}`,
            sub: `${ctx.format(value)} ${fromUnit.symbol} at ${ctx.format(density * densityScale)} ${densityLabel}`,
        });

        const grams = toMass ? massFromVolume(value * fromUnit.factor, density) : value * fromUnit.factor;
        const liters = toMass ? value * fromUnit.factor : volumeFromMass(value * fromUnit.factor, density);
        const listed = toMass ? (rows.mass ?? []).map((key) => [massUnits[key], grams / massUnits[key].factor]) : (rows.volume ?? []).map((key) => [volumeUnits[key], liters / volumeUnits[key].factor]);

        ctx.renderRows('also', listed.map(([unit, amount]) => ({ label: unit.name, value: `${ctx.format(amount)} ${unit.symbol}` })));

        ctx.renderRows('compare', compare.map((key) => ({
            label: substances[key].name,
            value: `${ctx.format(convertWith(substances[key].density))} ${toUnit.symbol}`,
            highlight: key === select.value,
        })));
        ctx.setText('compare-heading', `${ctx.format(value)} ${fromUnit.symbol} of other substances`);
    });
}
