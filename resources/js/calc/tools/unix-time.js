/**
 * Unix time ↔ calendar date in any IANA time zone, using the browser's own time-zone rules.
 */
const SECOND = 1000;

/**
 * The UTC offset of a zone at an instant, in minutes (e.g. +330 for India).
 */
export function zoneOffsetMinutes(epochMs, timeZone) {
    const parts = Object.fromEntries(new Intl.DateTimeFormat('en-US', {
        timeZone, hourCycle: 'h23', year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit',
    }).formatToParts(new Date(epochMs)).map(({ type, value }) => [type, value]));
    const asUtc = Date.UTC(parts.year, parts.month - 1, parts.day, parts.hour, parts.minute, parts.second);

    return Math.round((asUtc - Math.floor(epochMs / SECOND) * SECOND) / 60000);
}

/**
 * Converts a wall-clock date and time in a zone to epoch milliseconds. Two passes settle the
 * offset across daylight-saving changes.
 */
export function zonedToEpoch({ year, month, day, hour = 0, minute = 0, second = 0 }, timeZone) {
    const wall = Date.UTC(year, month - 1, day, hour, minute, second);
    let epoch = wall - zoneOffsetMinutes(wall, timeZone) * 60000;
    epoch = wall - zoneOffsetMinutes(epoch, timeZone) * 60000;

    return epoch;
}

/**
 * ISO-8601 week number (weeks start Monday; week 1 contains the first Thursday).
 */
export function isoWeek(date) {
    const day = new Date(Date.UTC(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate()));
    const weekday = day.getUTCDay() || 7;
    day.setUTCDate(day.getUTCDate() + 4 - weekday);
    const yearStart = Date.UTC(day.getUTCFullYear(), 0, 1);

    return Math.ceil(((day - yearStart) / 86400000 + 1) / 7);
}

export function formatOffset(minutes) {
    const sign = minutes < 0 ? '−' : '+';
    const absolute = Math.abs(minutes);

    return `UTC${sign}${String(Math.floor(absolute / 60)).padStart(2, '0')}:${String(absolute % 60).padStart(2, '0')}`;
}

function relative(epochMs) {
    const seconds = Math.round((epochMs - Date.now()) / SECOND);
    const units = [[31557600, 'year'], [2629800, 'month'], [86400, 'day'], [3600, 'hour'], [60, 'minute'], [1, 'second']];
    const [size, unit] = units.find(([length]) => Math.abs(seconds) >= length) ?? [1, 'second'];

    return new Intl.RelativeTimeFormat('en', { numeric: 'auto' }).format(Math.round(seconds / size), unit);
}

export default function unixTime(ctx) {
    // Start in the visitor's own time zone when it is one of the listed zones.
    const browserZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    const zoneSelect = ctx.field('zone');

    if ([...zoneSelect.options].some((option) => option.value === browserZone)) {
        zoneSelect.value = browserZone;
    }

    ctx.root.querySelector('[data-calc-now]')?.addEventListener('click', () => {
        ctx.field('timestamp').value = String(Math.floor(Date.now() / SECOND));
        ctx.root.querySelector('input[name="calc-mode"][value="unix"]').checked = true;
        ctx.root.querySelector('input[name="calc-precision"][value="s"]').checked = true;
        ctx.update();
    });

    ctx.onUpdate(() => {
        const timeZone = ctx.field('zone').value;
        let epochMs;

        if (ctx.choice('mode') === 'unix') {
            const value = ctx.number('timestamp');

            if (Number.isNaN(value)) {
                ctx.clearResult('Enter a Unix timestamp.');

                return;
            }

            epochMs = ctx.choice('precision') === 'ms' ? value : value * SECOND;
        } else {
            const [year, month, day] = (ctx.field('date').value || '').split('-').map(Number);
            const [hour = 0, minute = 0, second = 0] = (ctx.field('time').value || '00:00:00').split(':').map(Number);

            if (!year || !month || !day) {
                ctx.clearResult('Pick a date.');

                return;
            }

            epochMs = zonedToEpoch({ year, month, day, hour, minute, second }, timeZone);
        }

        const date = new Date(epochMs);

        if (Number.isNaN(date.getTime())) {
            ctx.showError('That timestamp is outside the range a calendar date can show.');

            return;
        }

        const offset = zoneOffsetMinutes(epochMs, timeZone);
        const inZone = new Intl.DateTimeFormat('en-US', { timeZone, dateStyle: 'full', timeStyle: 'long' }).format(date);
        const seconds = Math.floor(epochMs / SECOND);

        ctx.showResult(ctx.choice('mode') === 'unix'
            ? { value: inZone, unit: '', label: 'Date and time', sub: `${formatOffset(offset)} · ${relative(epochMs)}` }
            : { value: String(seconds), unit: 's', label: 'Unix timestamp', sub: `${ctx.format(epochMs)} ms · ${relative(epochMs)}` });

        ctx.setRow('seconds', String(seconds));
        ctx.setRow('milliseconds', String(Math.round(epochMs)));
        ctx.setRow('iso', date.toISOString());
        ctx.setRow('rfc', date.toUTCString());
        ctx.setRow('zoned', inZone);
        ctx.setRow('offset', formatOffset(offset));
        ctx.setRow('weekday', new Intl.DateTimeFormat('en-US', { timeZone, weekday: 'long' }).format(date));
        ctx.setRow('week', `Week ${isoWeek(date)} (ISO, UTC)`);
        ctx.setRow('days', ctx.format(epochMs / 86400000));
        ctx.setRow('relative', relative(epochMs));
    });
}
