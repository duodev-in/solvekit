import { formatNumber } from '../format.js';
import { toBase } from './units.js';

/**
 * Formula runtime for one-off calculators (most Biology & Nature tools).
 *
 * A tool module exports pure handlers: (inputs, config, format) → outcome.
 * The page config names the handler (`tool`), the fields it reads (`fields`) and, for values
 * with a unit menu, the unit table (`unitFields: { field: { unitKey: unit } }`). Those values
 * arrive in the table's base unit (meters, m², liters, grams, °C…).
 *
 * Outcome shapes:
 *   { empty: 'message' }                      nothing to calculate yet
 *   { error: 'message' }                      the inputs are invalid
 *   { value, unit?, label?, sub?, rows?, lists?, texts? }
 *       rows:  { rowKey: 'text' }            fills <x-calc.rows> cells
 *       lists: { ref: [{ label, value, highlight? }] } fills <x-calc.quick-ref> lists
 *       texts: { ref: 'text' }               fills data-ref text
 *       grids: { ref: { columns, rows } }    fills <x-calc.grid> tables
 *       plots: { ref: { series, markers } }  draws <x-calc.plot> charts
 */
export function readInputs(ctx, fields, unitFields = {}) {
    return Object.fromEntries(fields.map((name) => {
        const radio = ctx.root.querySelector(`input[name="calc-${name}"]`);

        if (radio && radio.type === 'radio') {
            return [name, ctx.choice(name)];
        }

        const element = ctx.field(name);

        if (!element) {
            return [name, undefined];
        }

        if (element.type === 'checkbox') {
            return [name, element.checked];
        }

        if (element.type !== 'number') {
            return [name, element.value];
        }

        const value = ctx.number(name);
        const units = unitFields[name];

        if (units && !Number.isNaN(value)) {
            return [name, toBase(value, units[ctx.field(`${name}-unit`).value])];
        }

        return [name, value];
    }));
}

/**
 * Shows an outcome on the page.
 */
export function applyOutcome(ctx, outcome) {
    if (!outcome || outcome.empty !== undefined) {
        ctx.clearResult(outcome?.empty);

        return;
    }

    if (outcome.error) {
        ctx.showError(outcome.error);

        return;
    }

    ctx.showResult({ value: outcome.value, unit: outcome.unit ?? '', sub: outcome.sub ?? '', label: outcome.label });

    // Rows a mode does not fill must not keep values from another mode.
    ctx.root.querySelectorAll('[data-calc-row] [data-row-value]').forEach((cell) => {
        cell.textContent = '—';
    });
    Object.entries(outcome.rows ?? {}).forEach(([key, text]) => ctx.setRow(key, text));
    Object.entries(outcome.lists ?? {}).forEach(([ref, rows]) => ctx.renderRows(ref, rows));
    Object.entries(outcome.texts ?? {}).forEach(([ref, text]) => ctx.setText(ref, text));
    Object.entries(outcome.grids ?? {}).forEach(([ref, grid]) => ctx.renderGrid(ref, grid));
    Object.entries(outcome.plots ?? {}).forEach(([ref, plot]) => ctx.renderPlot(ref, plot));
}

/**
 * True when any of the named inputs is missing (blank or not a number).
 */
export function missing(inputs, ...names) {
    return names.some((name) => inputs[name] === undefined || inputs[name] === '' || Number.isNaN(inputs[name]));
}

/**
 * Builds a module's default export from its handlers.
 */
export function defineTools(handlers) {
    return function formulaTool(ctx, config) {
        const handler = handlers[config.tool];

        ctx.onUpdate(() => {
            applyOutcome(ctx, handler(readInputs(ctx, config.fields ?? [], config.unitFields), config, ctx.format));
        });
    };
}

/**
 * Formatter for tests and for handlers called outside a page.
 */
export const plainFormat = (value) => formatNumber(value, 'auto');
