import { formatNumber, parseNumber } from './format.js';

const COPY_FEEDBACK_MS = 1200;

/**
 * Copies text to the clipboard, falling back to a temporary selection when the API is refused.
 */
async function copyText(text) {
    try {
        await navigator.clipboard.writeText(text);

        return true;
    } catch {
        const area = document.createElement('textarea');
        area.value = text;
        area.setAttribute('readonly', '');
        area.style.position = 'fixed';
        area.style.opacity = '0';
        document.body.appendChild(area);
        area.select();
        const copied = document.execCommand('copy');
        area.remove();

        return copied;
    }
}

function initTabs(root) {
    root.querySelectorAll('[data-calc-tabs]').forEach((group) => {
        const tabs = Array.from(group.querySelectorAll('[role="tab"]'));

        const select = (tab, { focus = false } = {}) => {
            tabs.forEach((item) => {
                const active = item === tab;
                item.setAttribute('aria-selected', String(active));
                item.tabIndex = active ? 0 : -1;
                document.getElementById(item.getAttribute('aria-controls')).hidden = !active;
            });

            if (focus) {
                tab.focus();
            }
        };

        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => select(tab));
            tab.addEventListener('keydown', (event) => {
                const step = { ArrowRight: 1, ArrowLeft: -1 }[event.key];

                if (step) {
                    event.preventDefault();
                    select(tabs[(index + step + tabs.length) % tabs.length], { focus: true });
                }
            });
        });
    });
}

function flash(button, label) {
    const original = button.dataset.label ?? button.textContent;
    button.dataset.label = original;
    button.dataset.copied = 'true';

    if (label) {
        button.textContent = label;
    }

    window.setTimeout(() => {
        delete button.dataset.copied;

        if (label) {
            button.textContent = original;
        }
    }, COPY_FEEDBACK_MS);
}

/**
 * Creates the calculator context that every engine and tool module works through.
 */
export function createCalculator(root, config) {
    const form = root.querySelector('[data-calc-form]');
    const result = root.querySelector('[data-calc-result]');
    const announcer = root.querySelector('[data-calc-announcer]');
    let updateHandler = () => {};

    const decimals = () => root.querySelector('input[name="calc-decimals"]:checked')?.value ?? 'auto';

    const ctx = {
        root,
        config,

        field(name) {
            return root.querySelector(`#calc-${name}`);
        },

        number(name) {
            return parseNumber(ctx.field(name)?.value);
        },

        choice(name) {
            const checked = root.querySelector(`input[name="calc-${name}"]:checked`);

            return checked ? checked.value : ctx.field(name)?.value;
        },

        format(value) {
            return formatNumber(value, decimals());
        },

        ref(name) {
            return root.querySelector(`[data-ref="${name}"]`);
        },

        setText(name, text) {
            const element = ctx.ref(name);

            if (element) {
                element.textContent = text;
            }
        },

        onUpdate(handler) {
            updateHandler = handler;
        },

        update() {
            // <… data-show-when="method:vr,vi"> is shown only while that control has one of those values.
            root.querySelectorAll('[data-show-when]').forEach((element) => {
                const [name, values] = element.dataset.showWhen.split(':');
                element.hidden = !values.split(',').includes(ctx.choice(name));
            });

            updateHandler(ctx);
        },

        showResult({ value, unit = '', sub = '', label }) {
            result.dataset.state = 'ready';
            result.querySelector('[data-result-value]').textContent = value;
            result.querySelector('[data-result-unit]').textContent = unit;
            result.querySelector('[data-result-sub]').textContent = sub;

            if (label !== undefined) {
                result.querySelector('[data-result-label]').textContent = label;
            }
        },

        showError(message) {
            result.dataset.state = 'error';
            result.querySelector('[data-result-value]').textContent = '—';
            result.querySelector('[data-result-unit]').textContent = '';
            result.querySelector('[data-result-sub]').textContent = message;
            ctx.clearRows();
        },

        clearResult(message = 'Enter a value to see the result.') {
            result.dataset.state = 'empty';
            result.querySelector('[data-result-value]').textContent = '—';
            result.querySelector('[data-result-unit]').textContent = '';
            result.querySelector('[data-result-sub]').textContent = message;
            ctx.clearRows();
        },

        /**
         * Writes a value into a server-rendered row: <… data-calc-row="key"><… data-row-value></…>.
         */
        setRow(key, value, unit) {
            root.querySelectorAll(`[data-calc-row="${key}"]`).forEach((row) => {
                row.querySelector('[data-row-value]').textContent = value;

                // Tools whose units change with a setting (e.g. kB ↔ KiB) relabel the row as well.
                if (unit) {
                    row.dataset.rowUnit = unit.symbol;
                    row.querySelector('[data-row-label]')?.replaceChildren(`${unit.name} `, Object.assign(document.createElement('span'), { className: 'text-slate-400', textContent: unit.symbol ? `(${unit.symbol})` : '' }));
                }
            });
        },

        clearRows() {
            root.querySelectorAll('[data-row-value]').forEach((cell) => {
                cell.textContent = '—';
            });
            root.querySelectorAll('[data-calc-generated], [data-calc-grid], [data-calc-plot]').forEach((list) => list.replaceChildren());
        },

        /**
         * Replaces a generated list (quick reference, comparisons) with label/value rows.
         */
        renderRows(name, rows) {
            const list = ctx.ref(name);

            if (!list) {
                return;
            }

            list.replaceChildren(...rows.map((row) => {
                const item = document.createElement('li');
                item.className = 'calc-row';
                item.dataset.highlight = row.highlight ? 'true' : 'false';

                const label = document.createElement('span');
                label.className = 'calc-row-label';
                label.textContent = row.label;

                const value = document.createElement('span');
                value.className = 'calc-row-value';
                value.textContent = row.value;

                item.append(label, value);

                return item;
            }));

            if (list.hasAttribute('data-collapse-long')) {
                const expand = list.parentElement.querySelector('[data-calc-expand]');
                expand.hidden = rows.length <= 8 || list.hasAttribute('data-expanded');
                expand.textContent = `Show all ${rows.length}`;
            }
        },


        /**
         * Fills a <table data-calc-grid>: { columns: [...], rows: [{ header, cells: [...] }] }.
         */
        renderGrid(name, grid) {
            const table = ctx.ref(name);

            if (!table) {
                return;
            }

            const cell = (tag, text, className) => Object.assign(document.createElement(tag), { textContent: text, className });
            // Large squares (8 × 8) use tighter cells so they fit the panel.
            const spacing = grid.columns.length > 4 ? 'px-0.5 py-1 text-[10.5px]' : 'px-2 py-1.5';
            const headerClass = `border border-slate-200 bg-slate-100 ${spacing} font-semibold text-slate-700`;
            const head = document.createElement('tr');
            head.append(cell('th', '', ''), ...grid.columns.map((column) => cell('th', column, headerClass)));
            const rows = grid.rows.map((row) => {
                const tr = document.createElement('tr');
                tr.append(cell('th', row.header, headerClass), ...row.cells.map((text) => cell('td', text, `border border-slate-200 ${spacing} text-slate-900`)));

                return tr;
            });

            table.replaceChildren(head, ...rows);
        },

        /**
         * Draws a line chart into an <svg data-calc-plot>: { series: [[x, y], …], xLabel, yLabel, markers: [{ x, y, label }], yTicks? }.
         */
        renderPlot(name, plot) {
            const svg = ctx.ref(name);

            if (!svg || !plot.series?.length) {
                return;
            }

            const width = 400;
            const height = 220;
            const margin = { left: 44, right: 14, top: 12, bottom: 34 };
            const xs = plot.series.map(([x]) => x);
            const ys = plot.series.map(([, y]) => y);
            const ticks = (min, max) => {
                const span = max - min || Math.abs(max) || 1;
                const raw = span / 5;
                const power = 10 ** Math.floor(Math.log10(raw));
                const step = [1, 2, 2.5, 5, 10].map((m) => m * power).find((m) => m >= raw);
                const first = Math.floor(min / step) * step;
                const list = [];

                for (let value = first; value <= max + step * 0.5; value += step) {
                    list.push(Number(value.toPrecision(12)));
                }

                return list;
            };
            const xTicks = ticks(plot.xMin ?? Math.min(...xs), plot.xMax ?? Math.max(...xs));
            const yTicks = plot.yTicks ?? ticks(plot.yMin ?? Math.min(...ys), plot.yMax ?? Math.max(...ys));
            const [x0, x1] = [xTicks[0], xTicks[xTicks.length - 1]];
            const [y0, y1] = [yTicks[0], yTicks[yTicks.length - 1]];
            const sx = (x) => margin.left + ((x - x0) / (x1 - x0 || 1)) * (width - margin.left - margin.right);
            const sy = (y) => height - margin.bottom - ((y - y0) / (y1 - y0 || 1)) * (height - margin.top - margin.bottom);
            const make = (tag, attributes, text) => {
                const element = document.createElementNS('http://www.w3.org/2000/svg', tag);
                Object.entries(attributes).forEach(([key, value]) => element.setAttribute(key, value));

                if (text !== undefined) {
                    element.textContent = text;
                }

                return element;
            };
            const label = (value) => (Math.abs(value) >= 1e4 || (Math.abs(value) < 1e-2 && value !== 0) ? value.toExponential(0) : String(value));
            const nodes = [];

            yTicks.forEach((value) => {
                nodes.push(make('line', { x1: margin.left, x2: width - margin.right, y1: sy(value), y2: sy(value), class: 'stroke-slate-200' }));
                nodes.push(make('text', { x: margin.left - 6, y: sy(value) + 3.5, 'text-anchor': 'end', class: 'fill-slate-500', 'font-size': 10 }, label(value)));
            });
            xTicks.forEach((value) => {
                nodes.push(make('text', { x: sx(value), y: height - margin.bottom + 14, 'text-anchor': 'middle', class: 'fill-slate-500', 'font-size': 10 }, label(value)));
            });
            nodes.push(make('line', { x1: margin.left, x2: width - margin.right, y1: height - margin.bottom, y2: height - margin.bottom, class: 'stroke-slate-400' }));
            nodes.push(make('polyline', { points: plot.series.map(([x, y]) => `${sx(x).toFixed(1)},${sy(y).toFixed(1)}`).join(' '), fill: 'none', 'stroke-width': 2, 'stroke-linejoin': 'round', class: 'stroke-primary-600' }));
            (plot.markers ?? []).forEach((marker) => {
                nodes.push(make('circle', { cx: sx(marker.x), cy: sy(marker.y), r: 3.5, class: 'fill-white stroke-slate-900', 'stroke-width': 1.5 }));

                if (marker.label) {
                    nodes.push(make('text', { x: sx(marker.x) + 6, y: sy(marker.y) - 6, class: 'fill-slate-700', 'font-size': 10 }, marker.label));
                }
            });

            if (plot.xLabel) {
                nodes.push(make('text', { x: (margin.left + width - margin.right) / 2, y: height - 4, 'text-anchor': 'middle', class: 'fill-slate-600', 'font-size': 11 }, plot.xLabel));
            }

            if (plot.yLabel) {
                nodes.push(make('text', { x: 12, y: (margin.top + height - margin.bottom) / 2, 'text-anchor': 'middle', transform: `rotate(-90 12 ${(margin.top + height - margin.bottom) / 2})`, class: 'fill-slate-600', 'font-size': 11 }, plot.yLabel));
            }

            svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
            svg.replaceChildren(...nodes);
        },

        announce(text) {
            if (announcer) {
                announcer.textContent = text;
            }
        },
    };

    // Recalculate on any change inside the calculator form or the decimals control.
    root.addEventListener('input', (event) => {
        if (event.target.closest('[data-calc-form]') || event.target.name === 'calc-decimals') {
            ctx.update();
        }
    });
    root.addEventListener('change', (event) => {
        if (event.target.closest('[data-calc-form]') || event.target.name === 'calc-decimals') {
            ctx.update();
        }
    });
    form?.addEventListener('submit', (event) => event.preventDefault());

    root.querySelector('[data-calc-reset]')?.addEventListener('click', () => {
        form?.reset();
        // Let the browser restore default values before recalculating.
        window.requestAnimationFrame(() => ctx.update());
        ctx.field('value')?.focus();
    });

    root.querySelectorAll('[data-calc-example]').forEach((chip) => {
        chip.addEventListener('click', () => {
            const values = JSON.parse(chip.dataset.calcExample);

            Object.entries(values).forEach(([name, value]) => {
                // Compare values directly: example values can hold newlines or quotes that break a selector.
                const radio = [...root.querySelectorAll(`input[name="calc-${name}"]`)].find((input) => input.type === 'radio' && input.value === String(value));

                if (radio) {
                    radio.checked = true;
                } else if (ctx.field(name)) {
                    ctx.field(name).value = value;

                    // Let modules that react to a select (e.g. a substance filling its density) see the change.
                    if (ctx.field(name).tagName === 'SELECT') {
                        ctx.field(name).dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }
            });

            ctx.update();
        });
    });

    // Copy the primary result, or any row the viewer clicks.
    root.addEventListener('click', async (event) => {
        const resultButton = event.target.closest('[data-copy-result]');
        const row = event.target.closest('[data-calc-row]');

        if (resultButton && result.dataset.state === 'ready') {
            const text = `${result.querySelector('[data-result-value]').textContent} ${result.querySelector('[data-result-unit]').textContent}`.trim();
            const copied = await copyText(text);
            flash(resultButton, copied ? 'Copied' : 'Copy failed');
            ctx.announce(copied ? `Copied ${text}` : 'Copy failed');
        } else if (row && row.tagName === 'BUTTON') {
            const value = row.querySelector('[data-row-value]').textContent;

            if (value === '—') {
                return;
            }

            const text = `${value} ${row.dataset.rowUnit ?? ''}`.trim();
            const copied = await copyText(text);
            flash(row);
            ctx.announce(copied ? `Copied ${text}` : 'Copy failed');
        }
    });

    root.querySelectorAll('[data-calc-expand]').forEach((button) => {
        button.addEventListener('click', () => {
            const list = button.parentElement.querySelector('[data-collapsible]');
            const expanded = list.toggleAttribute('data-expanded');
            button.hidden = expanded;
        });
    });

    initTabs(root);

    return ctx;
}

export function bootCalculatorPage(loadModule) {
    const root = document.querySelector('[data-calc-root]');

    if (!root) {
        return;
    }

    const config = JSON.parse(root.dataset.calc || '{}');
    const ctx = createCalculator(root, config);

    loadModule(config.engine)
        .then((module) => {
            module?.default?.(ctx, config);
            ctx.update();
        })
        .catch(() => ctx.showError('The calculator could not load. Check your connection and reload the page.'));
}
