import unitsEngine from '../engines/units.js';

/**
 * Minutes ↔ hours on the unit engine, plus the clock form (H:MM) and a worded form.
 * Rounds to whole minutes before splitting so 119.6 min reads 2:00, never 1:60.
 */
export function clockForm(totalMinutes) {
    const rounded = Math.round(totalMinutes);
    const hours = Math.floor(rounded / 60);

    return `${hours}:${String(rounded - hours * 60).padStart(2, '0')}`;
}

export function wordedForm(totalMinutes) {
    const rounded = Math.round(totalMinutes);
    const hours = Math.floor(rounded / 60);
    const minutes = rounded - hours * 60;
    const part = (count, word) => `${count} ${word}${count === 1 ? '' : 's'}`;

    return [hours ? part(hours, 'hour') : '', minutes || !hours ? part(minutes, 'minute') : ''].filter(Boolean).join(' ');
}

export default function minutesHours(ctx, config) {
    let convertHandler = () => {};
    unitsEngine({ ...ctx, onUpdate: (handler) => { convertHandler = handler; } }, config);

    ctx.onUpdate(() => {
        convertHandler(ctx);
        const value = ctx.number('value');

        if (Number.isNaN(value) || value < 0) {
            return;
        }

        const minutes = ctx.choice('direction') === 'min:h' ? value : value * 60;
        ctx.setRow('clock', clockForm(minutes));
        ctx.setRow('worded', wordedForm(minutes));
        ctx.setRow('workdays', ctx.format(minutes / 480));
    });
}
