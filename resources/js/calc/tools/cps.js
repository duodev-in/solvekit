import unitsEngine, { convertUnit } from '../engines/units.js';

/**
 * Frequency converter (cycles per second, rpm, periods…) plus the wavelength at that frequency
 * in air, water and for light: λ = v ÷ f.
 */
export const WAVE_SPEEDS = { air: 343, water: 1481, light: 299792458 };

export function wavelength(speed, hertz) {
    return speed / hertz;
}

export default function cps(ctx, config) {
    let convertHandler = () => {};
    unitsEngine({ ...ctx, onUpdate: (handler) => { convertHandler = handler; } }, config);

    ctx.onUpdate(() => {
        convertHandler(ctx);
        const value = ctx.number('value');
        const fromUnit = config.units[ctx.field('from').value];

        if (Number.isNaN(value) || value <= 0) {
            Object.keys(WAVE_SPEEDS).forEach((key) => ctx.setRow(`wave_${key}`, '—'));

            return;
        }

        const hertz = convertUnit(value, fromUnit, config.units.hz);
        Object.entries(WAVE_SPEEDS).forEach(([key, speed]) => ctx.setRow(`wave_${key}`, ctx.format(wavelength(speed, hertz))));
    });
}
