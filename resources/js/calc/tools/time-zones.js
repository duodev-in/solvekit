import { formatOffset, zonedToEpoch, zoneOffsetMinutes } from './unix-time.js';

/**
 * Shows one wall-clock time in several zones, with the offset and the difference from the source.
 */
export function describeIn(epochMs, timeZone, sourceOffset) {
    const offset = zoneOffsetMinutes(epochMs, timeZone);
    const difference = (offset - sourceOffset) / 60;
    const label = new Intl.DateTimeFormat('en-US', { timeZone, weekday: 'short', day: 'numeric', month: 'short', hour: 'numeric', minute: '2-digit' }).format(new Date(epochMs));

    return { label, offset, difference };
}

export default function timeZones(ctx, config) {
    const names = config.zoneNames;

    ctx.root.querySelector('[data-calc-now]')?.addEventListener('click', () => {
        const now = new Date();
        ctx.field('date').value = now.toISOString().slice(0, 10);
        ctx.field('time').value = now.toTimeString().slice(0, 5);
        const browserZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        if (names[browserZone]) {
            ctx.field('zone').value = browserZone;
        }

        ctx.update();
    });

    ctx.onUpdate(() => {
        const source = ctx.field('zone').value;
        const [year, month, day] = (ctx.field('date').value || '').split('-').map(Number);
        const [hour = 0, minute = 0] = (ctx.field('time').value || '').split(':').map(Number);
        const targets = [...ctx.root.querySelectorAll('input[name="calc-targets"]:checked')].map((box) => box.value);

        if (!year) {
            ctx.clearResult('Pick a date and time.');

            return;
        }

        const epoch = zonedToEpoch({ year, month, day, hour, minute }, source);
        const sourceOffset = zoneOffsetMinutes(epoch, source);
        const sourceLabel = new Intl.DateTimeFormat('en-US', { timeZone: source, dateStyle: 'full', timeStyle: 'short' }).format(new Date(epoch));

        ctx.showResult({ value: sourceLabel, unit: '', label: names[source], sub: `${formatOffset(sourceOffset)} · ${new Date(epoch).toISOString().replace('.000', '')}` });

        ctx.renderRows('zones', targets.length
            ? targets.map((zone) => {
                const { label, offset, difference } = describeIn(epoch, zone, sourceOffset);
                const sign = difference > 0 ? '+' : difference < 0 ? '−' : '±';

                return { label: `${names[zone]} (${formatOffset(offset)})`, value: `${label} · ${sign}${ctx.format(Math.abs(difference))} h` };
            })
            : [{ label: 'No zones selected', value: 'Tick zones to compare' }]);
    });
}
