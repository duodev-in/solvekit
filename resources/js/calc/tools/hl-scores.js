import { defineTools } from '../engines/formula.js';

/**
 * Published scores and questionnaires, driven by their definitions in config/health_data.php (scores.{key}):
 * yes/no items with points and multiple-choice items with points per answer, summed and matched to the
 * authors' bands. Select values are option indexes ("o0", "o1" …). Definitions may add `alerts` (a support message when an
 * item reaches a level), `percent` (a factor to show the raw score as a percentage) and `mean` (average per item).
 */
export function scoreTotal(definition, inputs) {
    const parts = definition.items.map((item) => {
        if (item.type === 'check') {
            return { item, points: inputs[item.key] ? item.points : 0, answer: inputs[item.key] ? 'Yes' : 'No' };
        }

        const index = Number(String(inputs[item.key] ?? `o${item.default ?? 0}`).replace(/^o/, ''));
        const option = item.options[index] ?? item.options[item.default ?? 0];

        return { item, points: option[1], answer: option[0] };
    });

    return { total: parts.reduce((sum, part) => sum + part.points, 0), parts };
}

export function scoreBand(definition, total) {
    return [...definition.bands].reverse().find((band) => total >= band[0]) ?? definition.bands[0];
}

const points = (n) => `${Number.isInteger(n) ? n : n.toFixed(1)} point${n === 1 ? '' : 's'}`;

export const handlers = {
    score: (i, c) => {
        const definition = c.data.score;
        const { total, parts } = scoreTotal(definition, i);
        const band = scoreBand(definition, total);
        const scored = parts.filter((part) => part.points !== 0);
        // Safety alerts: an answer at or above a level on a named item (thoughts of self-harm) shows a support message.
        const alerts = (definition.alerts ?? []).filter((alert) => {
            const part = parts.find((x) => x.item.key === alert.key);

            return part && part.points >= alert.min;
        });
        const extra = {};

        if (definition.percent) {
            extra.percent = `${Math.round(total * definition.percent)}% (raw score × ${definition.percent})`;
        }

        if (definition.mean) {
            extra.mean = `${(total / definition.items.length).toFixed(1)} average per item`;
        }

        if (definition.alerts) {
            extra.alert = alerts.length ? [...new Set(alerts.map((alert) => alert.message))].join(' ') : (definition.alert_none ?? 'No answer on the safety question');
        }

        return {
            value: Number.isInteger(total) ? String(total) : total.toFixed(1),
            unit: definition.max !== undefined ? `of ${definition.max}` : '',
            label: definition.name,
            sub: alerts.length ? `${band[1]}. ${alerts[0].message}` : band[1],
            rows: {
                ...extra,
                band: band[1],
                meaning: band[2],
                counted: scored.length ? scored.map((part) => `${part.item.short ?? part.item.label} (${part.points > 0 ? '+' : ''}${points(part.points)})`).join('; ') : 'No items scored',
                source: definition.source,
            },
            grids: { items: { columns: ['Answer', 'Points'], rows: parts.map((part) => ({ header: part.item.short ?? part.item.label, cells: [part.answer, String(part.points)], highlight: part.points !== 0 })) } },
        };
    },
};

export default defineTools(handlers);
