import { defineTools } from '../engines/formula.js';

/**
 * Animal pregnancy timelines. The page passes the species table (config biology_data.gestation)
 * as `data`; each species has an average length, a normal range and dated milestones.
 */
const DAY = 86400000;
const dateFormat = new Intl.DateTimeFormat('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric', timeZone: 'UTC' });

export function parseDate(text) {
    const match = /^(\d{4})-(\d{2})-(\d{2})$/.exec(String(text ?? '').trim());

    if (!match) {
        return null;
    }

    const date = new Date(Date.UTC(Number(match[1]), Number(match[2]) - 1, Number(match[3])));

    return date.getUTCDate() === Number(match[3]) ? date : null;
}

export function addDays(date, days) {
    return new Date(date.getTime() + days * DAY);
}

export function daysBetween(from, to) {
    return Math.round((to.getTime() - from.getTime()) / DAY);
}

export function formatDate(date) {
    return dateFormat.format(date);
}

function todayUtc() {
    const now = new Date();

    return new Date(Date.UTC(now.getFullYear(), now.getMonth(), now.getDate()));
}

/**
 * Species entry for the chosen basis (dogs can be timed from breeding or from ovulation).
 */
export function lengthFor(species, basis) {
    return basis === 'ovulation' && species.ovulation ? { ...species, ...species.ovulation } : species;
}

export const handlers = {
    gestation: (i, c, f) => {
        const key = i.species ?? Object.keys(c.data)[0];
        const species = c.data[key];

        if (!species) {
            return { empty: 'Pick a species.' };
        }

        const start = parseDate(i.date);

        if (!start) {
            return { empty: 'Enter the breeding date.' };
        }

        const length = lengthFor(species, i.basis);
        const today = c.today ? parseDate(c.today) : todayUtc();
        const due = addDays(start, length.days);
        const elapsed = daysBetween(start, today);
        const remaining = daysBetween(today, due);

        let status;

        if (elapsed < 0) {
            status = `Breeding is ${f(-elapsed)} day${elapsed === -1 ? '' : 's'} away`;
        } else if (remaining > 0) {
            status = `Day ${f(elapsed)} of about ${length.days} · ${f(remaining)} day${remaining === 1 ? '' : 's'} to go`;
        } else if (elapsed <= length.max) {
            status = `Day ${f(elapsed)}: within the normal ${species.event.toLowerCase()} window`;
        } else {
            status = `Day ${f(elapsed)}: past the normal range of ${length.max} days; contact your vet`;
        }

        const events = [
            [0, i.basis === 'ovulation' ? 'Ovulation' : 'Breeding'],
            ...(species.milestones ?? []).filter(([day]) => day < length.days),
            [length.min, `Earliest normal ${species.event.toLowerCase()}`],
            [length.days, `${species.event} due (average)`],
            [length.max, `Latest normal ${species.event.toLowerCase()}`],
        ].sort((a, b) => a[0] - b[0]);
        const next = events.find(([day]) => day >= elapsed);

        return {
            value: formatDate(due),
            unit: '',
            label: `${species.event} date`,
            sub: status,
            rows: {
                earliest: formatDate(addDays(start, length.min)),
                latest: formatDate(addDays(start, length.max)),
                length: `${length.days} days (${length.min} to ${length.max})`,
                progress: elapsed >= 0 && elapsed <= length.max ? `${Math.round(Math.min(100, (elapsed / length.days) * 100))}%` : '—',
            },
            lists: {
                timeline: events.map(([day, text]) => ({ label: `Day ${day} · ${text}`, value: formatDate(addDays(start, day)), highlight: next !== undefined && day === next[0] && text === next[1] })),
            },
        };
    },
};

export default defineTools(handlers);
