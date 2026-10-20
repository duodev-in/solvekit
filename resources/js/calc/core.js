import { currencySymbol, getCurrency, isCurrency, rememberCurrency, setCurrency, storedCurrency } from './currency.js';
import { formatNumber, parseNumber } from './format.js';
import { initRowsEditor } from './rows-editor.js';

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
            // Long text results (dates, converted text) use a smaller type size.
            result.dataset.long = String(value).length > 26 || String(value).includes('\n') ? 'true' : 'false';
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
         * Fills a <table data-calc-grid>: { columns: [...], rows: [{ header, cells: [...], highlight? }] }.
         */
        renderGrid(name, grid) {
            const table = ctx.ref(name);

            if (!table) {
                return;
            }

            const cell = (tag, text, className) => Object.assign(document.createElement(tag), { textContent: text, className });
            // Large squares (8 × 8) use tighter cells so they fit the panel.
            const spacing = grid.columns.length > 4 && !grid.roomy ? 'px-0.5 py-1 text-[10.5px]' : 'px-2 py-1.5';
            const headerClass = `border border-slate-200 bg-slate-100 ${spacing} font-semibold text-slate-700`;
            const head = document.createElement('tr');
            head.append(cell('th', '', ''), ...grid.columns.map((column) => cell('th', column, headerClass)));
            const rows = grid.rows.map((row) => {
                const tr = document.createElement('tr');
                // A highlighted row marks the line that matches the result (the nearest table entry).
                const tone = row.highlight ? 'bg-primary-50 font-semibold text-primary-900' : 'text-slate-900';
                tr.append(cell('th', row.header, headerClass), ...row.cells.map((text) => cell('td', text, `border border-slate-200 ${spacing} ${tone}`)));

                return tr;
            });

            table.replaceChildren(head, ...rows);
        },

        /**
         * Draws a line chart into an <svg data-calc-plot>: { series: [[x, y], …], xLabel, yLabel, markers: [{ x, y, label }], yTicks? }.
         */
        renderPlot(name, plot) {
            const svg = ctx.ref(name);

            if (!svg) {
                return;
            }

            if (plot.kind === 'diagram') {
                drawDiagram(svg, plot);

                return;
            }

            if (plot.kind === 'numberline') {
                drawNumberLine(svg, plot);

                return;
            }

            if (plot.kind === 'box') {
                drawBoxes(svg, plot);

                return;
            }

            if (plot.kind === 'pie') {
                drawPie(svg, plot);

                return;
            }

            if (plot.kind === 'venn') {
                drawVenn(svg, plot);

                return;
            }

            if (!plot.series?.length && !plot.scatter?.length && !plot.bars?.length) {
                svg.replaceChildren();

                return;
            }

            plot = { ...plot, series: plot.series ?? [] };

            const width = 400;
            const height = 220;
            const margin = { left: 44, right: 14, top: 12, bottom: 34 };
            // An optional second line (plot.series2) shares the axes; plot.legend names the two lines.
            // Bars: { x, y } centred on x (probabilities, counts) or { x0, x1, y } spanning a class (histograms).
            const bars = (plot.bars ?? []).map((bar) => ({ ...bar, x0: bar.x0 ?? bar.x - 0.4 * (plot.barWidth ?? 1), x1: bar.x1 ?? bar.x + 0.4 * (plot.barWidth ?? 1) }));
            const barPoints = bars.flatMap((bar) => [[bar.x0, 0], [bar.x1, bar.y]]);
            const all = [...plot.series, ...(plot.series2 ?? []), ...(plot.scatter ?? []), ...(plot.extra ?? []).flat(), ...barPoints].filter(([x, y]) => Number.isFinite(x) && Number.isFinite(y));
            const xs = all.map(([x]) => x);
            const ys = all.map(([, y]) => y);
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
            const xTicks = plot.categories ? plot.categories.map((_, index) => index) : ticks(plot.xMin ?? Math.min(...xs), plot.xMax ?? Math.max(...xs));

            if (plot.categories) {
                xTicks.unshift(-0.6);
                xTicks.push(plot.categories.length - 0.4);
            }

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
            // Large ticks read as 20K, 1.5M; very large or very small ones in exponent form.
            const compact = new Intl.NumberFormat('en-US', { notation: 'compact', maximumFractionDigits: 1 });
            const label = (value) => (Math.abs(value) >= 1e15 || (Math.abs(value) < 1e-2 && value !== 0) ? value.toExponential(0) : Math.abs(value) >= 1e4 ? compact.format(value) : String(value));
            const nodes = [];

            yTicks.forEach((value) => {
                nodes.push(make('line', { x1: margin.left, x2: width - margin.right, y1: sy(value), y2: sy(value), class: 'stroke-slate-200' }));
                nodes.push(make('text', { x: margin.left - 6, y: sy(value) + 3.5, 'text-anchor': 'end', class: 'fill-slate-500', 'font-size': 10 }, label(value)));
            });
            xTicks.forEach((value) => {
                if (plot.categories && !Number.isInteger(value)) {
                    return;
                }

                const text = plot.categories ? String(plot.categories[value]).slice(0, 12) : label(value);
                nodes.push(make('text', { x: sx(value), y: height - margin.bottom + 14, 'text-anchor': 'middle', class: 'fill-slate-500', 'font-size': plot.categories && plot.categories.length > 8 ? 8 : 10 }, text));
            });
            nodes.push(make('line', { x1: margin.left, x2: width - margin.right, y1: height - margin.bottom, y2: height - margin.bottom, class: 'stroke-slate-400' }));

            // Axes through the origin (graphs of functions) when zero is inside the range.
            if (plot.axes) {
                if (y0 < 0 && y1 > 0) {
                    nodes.push(make('line', { x1: margin.left, x2: width - margin.right, y1: sy(0), y2: sy(0), class: 'stroke-slate-500' }));
                }

                if (x0 < 0 && x1 > 0) {
                    nodes.push(make('line', { x1: sx(0), x2: sx(0), y1: margin.top, y2: height - margin.bottom, class: 'stroke-slate-500' }));
                }
            }

            // A series may contain non-finite points (asymptotes, gaps): each finite run is drawn separately.
            const runs = (series) => series.reduce((list, point) => {
                if (Number.isFinite(point[0]) && Number.isFinite(point[1]) && point[1] >= y0 - (y1 - y0) && point[1] <= y1 + (y1 - y0)) {
                    list[list.length - 1].push(point);
                } else if (list[list.length - 1].length) {
                    list.push([]);
                }

                return list;
            }, [[]]).filter((run) => run.length > 1);
            const line = (series, cls, dash = '') => runs(series).forEach((run) => nodes.push(make('polyline', { points: run.map(([x, y]) => `${sx(x).toFixed(1)},${sy(y).toFixed(1)}`).join(' '), fill: 'none', 'stroke-width': 2, 'stroke-linejoin': 'round', class: cls, 'stroke-dasharray': dash })));

            // Shaded regions under a curve (probabilities): each a list of [x, y] closed down to y = 0.
            (plot.areas ?? []).forEach((area) => {
                const base = sy(Math.max(y0, 0));
                const points = [[area[0][0], null], ...area, [area[area.length - 1][0], null]].map(([x, y]) => `${sx(x).toFixed(1)},${(y === null ? base : sy(y)).toFixed(1)}`).join(' ');
                nodes.push(make('polygon', { points, class: 'fill-primary-100 stroke-none' }));
            });
            bars.forEach((bar) => {
                const top = sy(Math.max(bar.y, 0));
                const bottom = sy(Math.max(y0, 0));
                nodes.push(make('rect', { x: sx(bar.x0), y: Math.min(top, bottom), width: Math.max(0.5, sx(bar.x1) - sx(bar.x0)), height: Math.abs(bottom - top), class: bar.hi ? 'fill-primary-600' : plot.areas || bars.some((b) => b.hi) ? 'fill-slate-300' : 'fill-primary-500', stroke: 'white', 'stroke-width': bar.x === undefined ? 1 : 0.5 }));

                if (bar.label !== undefined && bars.length <= 16) {
                    nodes.push(make('text', { x: (sx(bar.x0) + sx(bar.x1)) / 2, y: Math.min(top, bottom) - 3, 'text-anchor': 'middle', class: 'fill-slate-600', 'font-size': 9 }, bar.label));
                }
            });
            line(plot.series, 'stroke-primary-600');
            (plot.extra ?? []).forEach((series) => line(series, 'stroke-amber-500', '5 3'));
            (plot.scatter ?? []).forEach(([x, y]) => nodes.push(make('circle', { cx: sx(x), cy: sy(y), r: 3, class: 'fill-primary-600' })));

            if (plot.series2?.length) {
                nodes.push(make('polyline', { points: plot.series2.map(([x, y]) => `${sx(x).toFixed(1)},${sy(y).toFixed(1)}`).join(' '), fill: 'none', 'stroke-width': 2, 'stroke-dasharray': '5 3', 'stroke-linejoin': 'round', class: 'stroke-amber-500' }));
            }

            (plot.legend ?? []).forEach((text, index) => {
                nodes.push(make('line', { x1: margin.left + 8 + index * 150, x2: margin.left + 26 + index * 150, y1: margin.top + 4, y2: margin.top + 4, 'stroke-width': 2, class: index ? 'stroke-amber-500' : 'stroke-primary-600', 'stroke-dasharray': index ? '5 3' : '' }));
                nodes.push(make('text', { x: margin.left + 30 + index * 150, y: margin.top + 7.5, class: 'fill-slate-600', 'font-size': 10 }, text));
            });
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
                } else if (ctx.field(name)?.type === 'checkbox') {
                    ctx.field(name).checked = Boolean(value);
                } else if (ctx.field(name)) {
                    ctx.field(name).value = value;
                    // Let widgets built on a hidden field (rows editors) redraw from the new value.
                    ctx.field(name).dispatchEvent(new Event('calc:set'));

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

    root.querySelectorAll('[data-rows-editor]').forEach(initRowsEditor);
    initTabs(root);

    return ctx;
}

/**
 * Sets the page's display currency and wires the currency menu. Pages tied to one country's money set
 * `currencyFixed`; otherwise the viewer's remembered choice wins over the page default (`currency`, else USD).
 * The menu appears only on pages that show money (fields whose suffix carries the currency symbol).
 */
function initCurrency(root, config) {
    const pageDefault = isCurrency(config.currency) ? config.currency : 'USD';
    const fixed = Boolean(config.currencyFixed);
    setCurrency(fixed ? pageDefault : storedCurrency() ?? pageDefault);

    const paint = () => root.querySelectorAll('[data-currency-symbol]').forEach((node) => {
        node.textContent = currencySymbol().trim();
    });
    paint();

    const select = root.querySelector('[data-calc-currency]');

    if (!select || fixed || !root.querySelector('[data-currency-symbol]')) {
        return;
    }

    select.closest('[data-calc-currency-wrap]').hidden = false;
    select.value = getCurrency();
    // Runs before the runtime's own change listener on the root, so the recalculation already uses the new currency.
    select.addEventListener('change', () => {
        setCurrency(select.value);
        rememberCurrency(select.value);
        paint();
    });
    select.form?.addEventListener('reset', () => window.requestAnimationFrame(() => {
        select.value = getCurrency();
    }));
}

export function bootCalculatorPage(loadModule) {
    const root = document.querySelector('[data-calc-root]');

    if (!root) {
        return;
    }

    const config = JSON.parse(root.dataset.calc || '{}');
    initCurrency(root, config);
    const ctx = createCalculator(root, config);

    loadModule(config.engine)
        .then((module) => {
            module?.default?.(ctx, config);
            ctx.update();
        })
        .catch(() => ctx.showError('The calculator could not load. Check your connection and reload the page.'));
}

const SVG_NS = 'http://www.w3.org/2000/svg';
const svgNode = (tag, attributes, text) => {
    const element = document.createElementNS(SVG_NS, tag);
    Object.entries(attributes).forEach(([key, value]) => element.setAttribute(key, value));

    if (text !== undefined) {
        element.textContent = text;
    }

    return element;
};

/**
 * A labelled drawing at equal scale (shapes, triangles, vectors): plot.shapes = [{ points, closed, dashed, muted }],
 * plot.labels = [{ x, y, text }], plot.dots = [[x, y]]. No axes.
 */
function drawDiagram(svg, plot) {
    const width = 400;
    const height = 240;
    const pad = 28;
    const pts = [...(plot.shapes ?? []).flatMap((shape) => shape.points), ...(plot.labels ?? []).map((l) => [l.x, l.y]), ...(plot.dots ?? [])].filter(([x, y]) => Number.isFinite(x) && Number.isFinite(y));

    if (!pts.length) {
        svg.replaceChildren();

        return;
    }

    const minX = Math.min(...pts.map((p) => p[0]));
    const maxX = Math.max(...pts.map((p) => p[0]));
    const minY = Math.min(...pts.map((p) => p[1]));
    const maxY = Math.max(...pts.map((p) => p[1]));
    const scale = Math.min((width - 2 * pad) / (maxX - minX || 1), (height - 2 * pad) / (maxY - minY || 1));
    const ox = (width - (maxX - minX) * scale) / 2;
    const oy = (height - (maxY - minY) * scale) / 2;
    const sx = (x) => ox + (x - minX) * scale;
    const sy = (y) => height - oy - (y - minY) * scale;
    const nodes = [];

    (plot.shapes ?? []).forEach((shape) => {
        const points = shape.points.map(([x, y]) => `${sx(x).toFixed(1)},${sy(y).toFixed(1)}`).join(' ');
        nodes.push(svgNode(shape.closed ? 'polygon' : 'polyline', { points, 'stroke-width': shape.muted ? 1 : 2, 'stroke-linejoin': 'round', 'stroke-dasharray': shape.dashed ? '4 3' : '', class: `${shape.muted ? 'stroke-slate-400' : 'stroke-primary-600'} ${shape.closed && !shape.muted ? 'fill-primary-50' : 'fill-none'}` }));
    });
    (plot.dots ?? []).forEach(([x, y]) => nodes.push(svgNode('circle', { cx: sx(x), cy: sy(y), r: 3, class: 'fill-slate-800' })));
    (plot.labels ?? []).forEach((label) => nodes.push(svgNode('text', { x: sx(label.x), y: sy(label.y) + 4, 'text-anchor': 'middle', 'font-size': 12, class: 'fill-slate-700' }, label.text)));
    svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
    svg.replaceChildren(...nodes);
}

const BOX_FILLS = ['fill-primary-100', 'fill-amber-100', 'fill-emerald-100', 'fill-rose-100', 'fill-sky-100', 'fill-violet-100'];
const PALETTE = ['fill-primary-600', 'fill-amber-500', 'fill-emerald-500', 'fill-rose-500', 'fill-sky-400', 'fill-violet-500', 'fill-lime-500', 'fill-orange-400', 'fill-teal-600', 'fill-slate-400'];

/** Axis ticks between min and max (about five). */
function niceTicks(min, max) {
    const span = max - min || Math.abs(max) || 1;
    const raw = span / 5;
    const power = 10 ** Math.floor(Math.log10(raw));
    const step = [1, 2, 2.5, 5, 10].map((m) => m * power).find((m) => m >= raw);
    const list = [];

    for (let value = Math.floor(min / step) * step; value <= max + step * 0.5; value += step) {
        list.push(Number(value.toPrecision(12)));
    }

    return list;
}

/**
 * Horizontal box plots on one axis: plot.boxes = [{ label, lo, q1, med, q3, hi, outliers: [], mean? }]
 * (lo/hi are the whisker ends).
 */
function drawBoxes(svg, plot) {
    const boxes = plot.boxes ?? [];

    if (!boxes.length) {
        svg.replaceChildren();

        return;
    }

    const width = 400;
    const rowHeight = 46;
    const height = 40 + rowHeight * boxes.length;
    const left = boxes.some((b) => b.label) ? 70 : 20;
    const right = width - 16;
    const values = boxes.flatMap((b) => [b.lo, b.hi, ...(b.outliers ?? [])]).filter(Number.isFinite);
    const xTicks = niceTicks(Math.min(...values), Math.max(...values));
    const [x0, x1] = [xTicks[0], xTicks[xTicks.length - 1]];
    const sx = (x) => left + ((x - x0) / (x1 - x0 || 1)) * (right - left);
    const nodes = [];
    const axisY = height - 24;

    xTicks.forEach((value) => {
        nodes.push(svgNode('line', { x1: sx(value), x2: sx(value), y1: 8, y2: axisY, class: 'stroke-slate-200' }));
        nodes.push(svgNode('text', { x: sx(value), y: axisY + 14, 'text-anchor': 'middle', 'font-size': 10, class: 'fill-slate-500' }, String(value)));
    });
    nodes.push(svgNode('line', { x1: left, x2: right, y1: axisY, y2: axisY, class: 'stroke-slate-400' }));
    boxes.forEach((b, index) => {
        const cy = 16 + rowHeight * index + rowHeight / 2;
        const h = 22;
        nodes.push(svgNode('line', { x1: sx(b.lo), x2: sx(b.q1), y1: cy, y2: cy, class: 'stroke-slate-700', 'stroke-width': 1.5 }));
        nodes.push(svgNode('line', { x1: sx(b.q3), x2: sx(b.hi), y1: cy, y2: cy, class: 'stroke-slate-700', 'stroke-width': 1.5 }));
        [b.lo, b.hi].forEach((x) => nodes.push(svgNode('line', { x1: sx(x), x2: sx(x), y1: cy - h / 4, y2: cy + h / 4, class: 'stroke-slate-700', 'stroke-width': 1.5 })));
        nodes.push(svgNode('rect', { x: sx(b.q1), y: cy - h / 2, width: Math.max(1, sx(b.q3) - sx(b.q1)), height: h, class: `${BOX_FILLS[index % BOX_FILLS.length]} stroke-slate-700`, 'stroke-width': 1.5 }));
        nodes.push(svgNode('line', { x1: sx(b.med), x2: sx(b.med), y1: cy - h / 2, y2: cy + h / 2, class: 'stroke-primary-700', 'stroke-width': 2.5 }));

        if (Number.isFinite(b.mean)) {
            nodes.push(svgNode('text', { x: sx(b.mean), y: cy + 4, 'text-anchor': 'middle', 'font-size': 12, class: 'fill-slate-800' }, '×'));
        }

        (b.outliers ?? []).forEach((x) => nodes.push(svgNode('circle', { cx: sx(x), cy, r: 3, class: 'fill-white stroke-rose-600', 'stroke-width': 1.5 })));

        if (b.label) {
            nodes.push(svgNode('text', { x: left - 8, y: cy + 4, 'text-anchor': 'end', 'font-size': 11, class: 'fill-slate-700' }, String(b.label).slice(0, 10)));
        }
    });

    if (plot.xLabel) {
        nodes.push(svgNode('text', { x: (left + right) / 2, y: height - 2, 'text-anchor': 'middle', 'font-size': 11, class: 'fill-slate-600' }, plot.xLabel));
    }

    svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
    svg.replaceChildren(...nodes);
}

/** A pie chart with a legend: plot.slices = [{ label, value }]. */
function drawPie(svg, plot) {
    const slices = (plot.slices ?? []).filter((s) => s.value > 0);
    const total = slices.reduce((t, s) => t + s.value, 0);

    if (!slices.length || !(total > 0)) {
        svg.replaceChildren();

        return;
    }

    const width = 400;
    const legendRows = slices.length;
    const height = Math.max(220, 24 + legendRows * 18);
    const cx = 110;
    const cy = height / 2;
    const r = 92;
    const nodes = [];
    let angle = -Math.PI / 2;

    slices.forEach((slice, index) => {
        const share = slice.value / total;
        const end = angle + share * 2 * Math.PI;
        const cls = `${PALETTE[index % PALETTE.length]} stroke-white`;

        if (share >= 0.999999) {
            nodes.push(svgNode('circle', { cx, cy, r, class: cls, 'stroke-width': 1.5 }));
        } else {
            const large = end - angle > Math.PI ? 1 : 0;
            const d = `M ${cx} ${cy} L ${(cx + r * Math.cos(angle)).toFixed(2)} ${(cy + r * Math.sin(angle)).toFixed(2)} A ${r} ${r} 0 ${large} 1 ${(cx + r * Math.cos(end)).toFixed(2)} ${(cy + r * Math.sin(end)).toFixed(2)} Z`;
            nodes.push(svgNode('path', { d, class: cls, 'stroke-width': 1.5 }));
        }

        if (share >= 0.06) {
            const mid = (angle + end) / 2;
            nodes.push(svgNode('text', { x: cx + r * 0.62 * Math.cos(mid), y: cy + r * 0.62 * Math.sin(mid) + 4, 'text-anchor': 'middle', 'font-size': 10, class: 'fill-white font-semibold' }, `${(share * 100).toFixed(share < 0.1 ? 1 : 0)}%`));
        }

        const ly = cy - (legendRows * 18) / 2 + index * 18 + 9;
        nodes.push(svgNode('rect', { x: 226, y: ly - 8, width: 11, height: 11, class: PALETTE[index % PALETTE.length] }));
        nodes.push(svgNode('text', { x: 243, y: ly + 1.5, 'font-size': 11, class: 'fill-slate-700' }, `${String(slice.label).slice(0, 18)} (${(share * 100).toFixed(1)}%)`));
        angle = end;
    });

    svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
    svg.replaceChildren(...nodes);
}

/**
 * A two- or three-set Venn diagram with region counts: plot.names = ['A', 'B'(, 'C')], plot.regions =
 * { a, b, ab, none } or { a, b, c, ab, ac, bc, abc, none } (counts of each exclusive region).
 */
function drawVenn(svg, plot) {
    const three = plot.names?.length === 3;
    const width = 400;
    const height = three ? 280 : 220;
    const r = three ? 78 : 82;
    const centres = three ? [[160, 105], [240, 105], [200, 172]] : [[155, 110], [245, 110]];
    const nodes = [svgNode('rect', { x: 6, y: 6, width: width - 12, height: height - 12, class: 'fill-none stroke-slate-300' })];
    const fills = ['fill-primary-500', 'fill-amber-500', 'fill-emerald-500'];
    const value = (key) => (plot.regions?.[key] ?? '');

    centres.forEach(([x, y], index) => nodes.push(svgNode('circle', { cx: x, cy: y, r, class: `${fills[index]} stroke-slate-600`, 'fill-opacity': 0.22, 'stroke-width': 1.5 })));
    const names = plot.names ?? [];
    const labelAt = three ? [[100, 40], [300, 40], [200, 268]] : [[95, 30], [305, 30]];
    names.forEach((name, index) => nodes.push(svgNode('text', { x: labelAt[index][0], y: labelAt[index][1], 'text-anchor': 'middle', 'font-size': 13, class: 'fill-slate-800 font-semibold' }, String(name).slice(0, 16))));
    const spots = three
        ? { a: [128, 92], b: [272, 92], c: [200, 205], ab: [200, 80], ac: [158, 150], bc: [242, 150], abc: [200, 127], none: [370, 262] }
        : { a: [115, 114], b: [285, 114], ab: [200, 114], none: [370, 200] };
    Object.entries(spots).forEach(([key, [x, y]]) => nodes.push(svgNode('text', { x, y, 'text-anchor': 'middle', 'font-size': 13, class: 'fill-slate-900' }, String(value(key)))));
    svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
    svg.replaceChildren(...nodes);
}

/**
 * A number line with shaded intervals and points: plot.intervals = [{ from, to, fromOpen, toOpen }] (±Infinity for rays),
 * plot.points = [{ x, open }], plot.range = [min, max].
 */
function drawNumberLine(svg, plot) {
    const width = 400;
    const height = 90;
    const left = 24;
    const right = width - 24;
    const y = 44;
    const ends = [...(plot.intervals ?? []).flatMap((i) => [i.from, i.to]), ...(plot.points ?? []).map((p) => p.x)].filter(Number.isFinite);
    let [min, max] = plot.range ?? [Math.min(...ends, 0), Math.max(...ends, 0)];

    if (min === max) {
        min -= 5;
        max += 5;
    }

    const span = max - min;
    min -= span * 0.15;
    max += span * 0.15;
    const sx = (x) => left + ((x - min) / (max - min)) * (right - left);
    const clampX = (x) => (x === -Infinity ? left : x === Infinity ? right : sx(x));
    const nodes = [svgNode('line', { x1: left - 8, x2: right + 8, y1: y, y2: y, class: 'stroke-slate-500', 'stroke-width': 1.5 })];
    const raw = span / 6;
    const power = 10 ** Math.floor(Math.log10(raw || 1));
    const step = [1, 2, 2.5, 5, 10].map((m) => m * power).find((m) => m >= raw) || 1;

    for (let tick = Math.ceil(min / step) * step; tick <= max; tick += step) {
        const value = Number(tick.toPrecision(12));
        nodes.push(svgNode('line', { x1: sx(value), x2: sx(value), y1: y - 5, y2: y + 5, class: 'stroke-slate-400' }));
        nodes.push(svgNode('text', { x: sx(value), y: y + 22, 'text-anchor': 'middle', 'font-size': 11, class: 'fill-slate-500' }, String(value)));
    }

    (plot.intervals ?? []).forEach((interval) => {
        nodes.push(svgNode('line', { x1: clampX(interval.from), x2: clampX(interval.to), y1: y, y2: y, 'stroke-width': 5, 'stroke-linecap': 'butt', class: 'stroke-primary-600' }));
        [[interval.from, interval.fromOpen], [interval.to, interval.toOpen]].forEach(([x, open]) => {
            if (Number.isFinite(x)) {
                nodes.push(svgNode('circle', { cx: sx(x), cy: y, r: 5.5, 'stroke-width': 2, class: `stroke-primary-600 ${open ? 'fill-white' : 'fill-primary-600'}` }));
            } else {
                nodes.push(svgNode('polygon', { points: x < 0 ? `${left - 10},${y} ${left},${y - 6} ${left},${y + 6}` : `${right + 10},${y} ${right},${y - 6} ${right},${y + 6}`, class: 'fill-primary-600' }));
            }
        });
    });
    (plot.points ?? []).forEach((point) => nodes.push(svgNode('circle', { cx: sx(point.x), cy: y, r: 5.5, 'stroke-width': 2, class: `stroke-primary-600 ${point.open ? 'fill-white' : 'fill-primary-600'}` })));
    svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
    svg.replaceChildren(...nodes);
}
