import { formatDms, parseAngle, toDms } from '../engines/geo.js';

/**
 * Decimal degrees ↔ degrees, minutes and seconds, with the sign kept for negative angles.
 */
export function dmsToDecimal(degrees, minutes, seconds, negative) {
    const magnitude = Math.abs(degrees) + minutes / 60 + seconds / 3600;

    return negative ? -magnitude : magnitude;
}

export default function dms(ctx) {
    ctx.onUpdate(() => {
        const toDmsMode = ctx.choice('mode') === 'to-dms';
        let decimal;

        if (toDmsMode) {
            const text = ctx.field('decimal').value;

            if (text.trim() === '') {
                ctx.clearResult('Enter an angle in decimal degrees.');

                return;
            }

            decimal = parseAngle(text);

            if (decimal === null) {
                ctx.showError('Enter a number such as 40.7484 or −73.9857.');

                return;
            }
        } else {
            const degrees = ctx.number('degrees');
            const minutes = Number.isNaN(ctx.number('minutes')) ? 0 : ctx.number('minutes');
            const seconds = Number.isNaN(ctx.number('seconds')) ? 0 : ctx.number('seconds');

            if (Number.isNaN(degrees)) {
                ctx.clearResult('Enter the degrees.');

                return;
            }

            if (minutes < 0 || minutes >= 60 || seconds < 0 || seconds >= 60) {
                ctx.showError('Minutes and seconds must be from 0 up to (but not including) 60.');

                return;
            }

            const negative = degrees < 0 || Object.is(degrees, -0) || ctx.choice('sign') === 'neg';
            decimal = dmsToDecimal(degrees, minutes, seconds, negative);
        }

        const parts = toDms(decimal);
        const axis = ctx.field('axis').value;

        if ((axis === 'lat' && Math.abs(decimal) > 90) || (axis === 'lon' && Math.abs(decimal) > 180)) {
            ctx.showError(axis === 'lat' ? 'Latitude must be between −90 and 90 degrees.' : 'Longitude must be between −180 and 180 degrees.');

            return;
        }

        ctx.showResult(toDmsMode
            ? { value: formatDms(decimal, axis === 'angle' ? undefined : axis), unit: '', label: 'Degrees, minutes, seconds', sub: `${ctx.format(decimal)}°` }
            : { value: `${decimal.toFixed(6)}°`, unit: '', label: 'Decimal degrees', sub: formatDms(decimal, axis === 'angle' ? undefined : axis) });

        ctx.setRow('decimal', `${decimal.toFixed(6)}°`);
        ctx.setRow('dms', formatDms(decimal, axis === 'angle' ? undefined : axis));
        ctx.setRow('dm', `${parts.sign < 0 ? '−' : ''}${parts.degrees}° ${(parts.minutes + parts.seconds / 60).toFixed(4)}′`);
        ctx.setRow('radians', ctx.format((decimal * Math.PI) / 180));
        ctx.setRow('gradians', ctx.format((decimal * 400) / 360));
        ctx.setRow('mils', ctx.format((decimal * 6400) / 360));
    });
}
