import { formatScientific } from '../format.js';
import unitsEngine from './units.js';

/**
 * Number-scale engine: the unit engine over number words (thousand, lakh, million, crore…), plus
 * the full number written out in Western and Indian digit grouping.
 */
export function groupDigits(value, system) {
    return new Intl.NumberFormat(system === 'indian' ? 'en-IN' : 'en-US', { maximumFractionDigits: 2 }).format(value);
}

export function integerDigits(value) {
    const whole = Math.floor(Math.abs(value));

    return whole === 0 ? 1 : Math.floor(Math.log10(whole)) + 1;
}

export default function numberScale(ctx, config) {
    let convertHandler = () => {};
    unitsEngine({ ...ctx, onUpdate: (handler) => { convertHandler = handler; } }, config);

    ctx.onUpdate(() => {
        convertHandler(ctx);

        const units = config.unitSets ? config.unitSets[ctx.choice(config.unitSetControl)] : config.units;
        const direction = ctx.choice('direction');
        const from = direction ? direction.split(':')[0] : ctx.field('from').value;
        const value = ctx.number('value');

        if (Number.isNaN(value) || value < 0) {
            ['western', 'indian', 'scientific', 'digits'].forEach((key) => ctx.setRow(key, '—'));

            return;
        }

        const ones = value * units[from].factor;
        ctx.setRow('western', groupDigits(ones, 'western'));
        ctx.setRow('indian', groupDigits(ones, 'indian'));
        ctx.setRow('scientific', ones === 0 ? '0' : formatScientific(ones, 6));
        ctx.setRow('digits', String(integerDigits(ones)));
    });
}
