/**
 * Download time, required speed and shared bandwidth. Sizes use decimal (SI) bytes like network
 * speeds do; efficiency allows for protocol overhead and real-world conditions.
 * Config: dataUnits (factor = bytes), rateUnits (factor = bit/s).
 */
export function downloadSeconds(bytes, bitsPerSecond, efficiency) {
    return (bytes * 8) / (bitsPerSecond * efficiency);
}

export function formatDuration(seconds) {
    if (!Number.isFinite(seconds)) {
        return '—';
    }

    if (seconds < 1) {
        return `${(seconds * 1000).toFixed(0)} ms`;
    }

    const parts = [];
    let remaining = Math.round(seconds);
    [[86400, 'd'], [3600, 'h'], [60, 'min'], [1, 's']].forEach(([size, label]) => {
        const count = Math.floor(remaining / size);

        if (count > 0) {
            parts.push(`${count} ${label}`);
            remaining -= count * size;
        }
    });

    return parts.join(' ') || '0 s';
}

export default function mbpsCalculator(ctx, config) {
    const { dataUnits, rateUnits } = config;

    ctx.onUpdate(() => {
        const mode = ctx.choice('mode');
        const efficiency = ctx.number('efficiency') / 100;

        if (!(efficiency > 0 && efficiency <= 1)) {
            ctx.showError('Efficiency must be between 1 and 100%.');

            return;
        }

        if (mode === 'time') {
            const size = ctx.number('size');
            const speed = ctx.number('speed');

            if (Number.isNaN(size) || Number.isNaN(speed)) {
                ctx.clearResult('Enter the file size and connection speed.');

                return;
            }

            if (size < 0 || speed <= 0) {
                ctx.showError('Size cannot be negative and speed must be greater than 0.');

                return;
            }

            const bytes = size * dataUnits[ctx.field('size-unit').value].factor;
            const rate = speed * rateUnits[ctx.field('speed-unit').value].factor;
            const seconds = downloadSeconds(bytes, rate, efficiency);

            ctx.showResult({ value: formatDuration(seconds), unit: '', label: 'Download time', sub: `at ${ctx.format(efficiency * 100)}% efficiency` });
            ctx.setRow('seconds', ctx.format(seconds));
            ctx.setRow('minutes', ctx.format(seconds / 60));
            ctx.setRow('hours', ctx.format(seconds / 3600));
            ctx.setRow('throughput', ctx.format((rate * efficiency) / 8e6));

            return;
        }

        if (mode === 'speed') {
            const size = ctx.number('size');
            const minutes = ctx.number('minutes');

            if (Number.isNaN(size) || Number.isNaN(minutes)) {
                ctx.clearResult('Enter the file size and the time you want it to take.');

                return;
            }

            if (size < 0 || minutes <= 0) {
                ctx.showError('Size cannot be negative and time must be greater than 0.');

                return;
            }

            const bytes = size * dataUnits[ctx.field('size-unit').value].factor;
            const required = (bytes * 8) / (minutes * 60) / efficiency;

            ctx.showResult({ value: ctx.format(required / 1e6), unit: 'Mbit/s', label: 'Speed needed', sub: `to move ${ctx.format(size)} ${dataUnits[ctx.field('size-unit').value].symbol} in ${ctx.format(minutes)} min` });
            ctx.setRow('seconds', ctx.format(minutes * 60));
            ctx.setRow('minutes', ctx.format(minutes));
            ctx.setRow('hours', ctx.format(minutes / 60));
            ctx.setRow('throughput', ctx.format(required / 8e6));

            return;
        }

        const users = ctx.number('users');
        const perUser = ctx.number('per-user');

        if (Number.isNaN(users) || Number.isNaN(perUser)) {
            ctx.clearResult('Enter the number of users and the speed each needs.');

            return;
        }

        if (users < 0 || perUser < 0) {
            ctx.showError('Users and speed cannot be negative.');

            return;
        }

        const total = (users * perUser) / efficiency;
        ctx.showResult({ value: ctx.format(total), unit: 'Mbit/s', label: 'Total bandwidth', sub: `${ctx.format(users)} users × ${ctx.format(perUser)} Mbit/s ÷ ${ctx.format(efficiency * 100)}%` });
        ctx.setRow('seconds', '—');
        ctx.setRow('minutes', '—');
        ctx.setRow('hours', '—');
        ctx.setRow('throughput', ctx.format(total / 8));
    });
}
