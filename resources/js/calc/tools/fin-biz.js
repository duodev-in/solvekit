import { getCurrency } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { money, money0, num, numberList, pct } from '../finance/common.js';
import { npv } from '../finance/tvm.js';
import { parseRows } from '../rows-editor.js';

/**
 * Business planning, sales, accounting and economics: break-even, SaaS and marketing metrics, inventory (FIFO, LIFO,
 * EOQ, safety stock), depreciation including MACRS, payment fees, check digits, CPI inflation and income distribution.
 */
const P = (value) => value / 100;
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
// Fixed-currency pages pass `sym` (a currency code); otherwise the page's display currency applies.
const symbolOf = (c) => c.sym ?? getCurrency();

// Depreciation ------------------------------------------------------------------------------------

/**
 * MACRS GDS rates (IRS Pub 946 Table A-1 style): 200% DB for 3–10-year property and 150% DB for 15–20-year,
 * half-year convention, switching to straight line when it gives more.
 */
export function macrsRates(life) {
    const factor = life >= 15 ? 1.5 : 2;
    const rate = factor / life;
    let remaining = 1;
    const rates = [];

    for (let k = 1; k <= life + 1; k += 1) {
        let d;

        if (k === life + 1) {
            d = remaining;
        } else {
            const db = remaining * rate * (k === 1 ? 0.5 : 1);
            const sl = k === 1 ? 0.5 / life : remaining / (life - k + 1.5);
            d = Math.max(db, sl);
        }

        d = Math.min(d, remaining);
        rates.push(d);
        remaining -= d;
    }

    return rates;
}

/**
 * A full depreciation schedule: straight line, declining balance (any factor, switching to straight line),
 * sum-of-years'-digits, units of production or MACRS.
 */
export function depreciationSchedule({ cost, salvage = 0, life, method = 'sl', factor = 2, units = [], totalUnits = 0, macrsLife = 5 }) {
    const rows = [];
    let book = cost;
    const base = cost - salvage;

    if (method === 'macrs') {
        macrsRates(macrsLife).forEach((r, k) => {
            const d = cost * r;
            book -= d;
            rows.push({ year: k + 1, dep: d, book, rate: r });
        });

        return rows;
    }

    const years = method === 'units' ? units.length : Math.ceil(life);

    for (let k = 1; k <= years; k += 1) {
        let d;

        if (method === 'units') {
            d = (base * units[k - 1]) / totalUnits;
        } else if (method === 'syd') {
            d = (base * (life - k + 1)) / ((life * (life + 1)) / 2);
        } else if (method === 'db') {
            const db = book * (factor / life);
            const sl = (book - salvage) / (life - k + 1);
            d = Math.max(db, sl);
        } else {
            d = base / life;
        }

        d = Math.max(0, Math.min(d, book - salvage));
        book -= d;
        rows.push({ year: k, dep: d, book });
    }

    return rows;
}

function depreciationOutcome(i, c, accumulatedOnly) {
    const s = symbolOf(c);
    const method = i.method ?? 'sl';

    if (!ok(i.cost) || i.cost <= 0 || (method !== 'macrs' && method !== 'units' && !(i.life > 0))) {
        return { empty: 'Enter the cost, salvage value and useful life.' };
    }

    const units = numberList(i.units);
    const rows = depreciationSchedule({ cost: i.cost, salvage: method === 'macrs' ? 0 : or0(i.salvage), life: i.life, method, factor: ok(i.factor) ? i.factor : 2, units, totalUnits: or0(i.total_units), macrsLife: Number(i.macrs ?? 5) });

    if (!rows.length) {
        return { empty: 'Enter the units produced each year.' };
    }

    const elapsed = Math.max(0, Math.min(rows.length, Math.round(or0(i.elapsed) || rows.length)));
    const accumulated = rows.slice(0, elapsed).reduce((sum, row) => sum + row.dep, 0);
    const names = { sl: 'Straight line', db: 'Declining balance', syd: 'Sum-of-years\'-digits', units: 'Units of production', macrs: `MACRS ${i.macrs ?? 5}-year (half-year convention)` };

    return {
        value: money(accumulatedOnly ? accumulated : rows[0].dep, s),
        label: accumulatedOnly ? `Accumulated depreciation after ${elapsed} years` : 'First-year depreciation',
        sub: `${names[method]}; book value ${money(accumulatedOnly ? i.cost - accumulated : rows[0].book, s)}`,
        rows: { book: money(i.cost - accumulated, s), total: money(rows.reduce((sum, row) => sum + row.dep, 0), s), method: names[method], years: `${rows.length} years of depreciation` },
        grids: { schedule: { columns: method === 'macrs' ? ['Rate', 'Depreciation', 'Book value'] : ['Depreciation', 'Accumulated', 'Book value'], rows: rows.map((row, k) => ({ header: String(row.year), cells: method === 'macrs' ? [pct(row.rate), money0(row.dep, s), money0(row.book, s)] : [money0(row.dep, s), money0(rows.slice(0, k + 1).reduce((a, b) => a + b.dep, 0), s), money0(row.book, s)] })), roomy: true } },
    };
}

// Inventory --------------------------------------------------------------------------------------

function inventoryCost(i, c, method) {
    const s = symbolOf(c);
    const layers = parseRows(i.layers).map((cells) => ({ units: Number(cells[0]), cost: Number(cells[1]) })).filter((l) => ok(l.units, l.cost) && l.units > 0);
    const sold = or0(i.sold);

    if (!layers.length) {
        return { empty: 'Add purchases with units and cost per unit.' };
    }

    const total = layers.reduce((sum, l) => sum + l.units, 0);

    if (sold > total) {
        return { error: `Only ${num(total)} units were bought.` };
    }

    const order = method === 'lifo' ? [...layers].reverse() : layers;
    let left = sold;
    let cogs = 0;
    const used = [];

    for (const layer of order) {
        const take = Math.min(left, layer.units);

        if (take > 0) {
            cogs += take * layer.cost;
            used.push({ label: `${num(take)} units at ${money(layer.cost, s)}`, value: money(take * layer.cost, s) });
        }

        left -= take;
    }

    const value = layers.reduce((sum, l) => sum + l.units * l.cost, 0);
    const average = value / total;

    return {
        value: money(cogs, s),
        label: `Cost of goods sold (${method.toUpperCase()})`,
        sub: `${num(sold)} units sold; ending inventory ${money(value - cogs, s)}`,
        rows: { ending: money(value - cogs, s), units: num(total - sold), average: `${money(average * sold, s)} under weighted average`, gross: ok(i.price) ? money(i.price * sold - cogs, s) : 'Enter a selling price for gross profit' },
        lists: { used },
    };
}

// Payment fees -----------------------------------------------------------------------------------

function feeOutcome(i, c, percent, fixed, name) {
    const s = symbolOf(c);

    if (!ok(i.amount) || i.amount <= 0) {
        return { empty: 'Enter the amount.' };
    }

    const rate = P(percent + (i.international ? 1.5 : 0));
    const fee = i.amount * rate + fixed;
    const grossUp = (i.amount + fixed) / (1 - rate);

    return {
        value: money(i.mode === 'grossup' ? grossUp : i.amount - fee, s),
        label: i.mode === 'grossup' ? 'Ask for this to receive the amount' : 'You receive',
        sub: `${name}: ${num(rate * 100)}% + ${money(fixed, s)} per transaction`,
        rows: { fee: money(i.mode === 'grossup' ? grossUp - i.amount : fee, s), effective: pct(fee / i.amount), grossup: money(grossUp, s), net: money(i.amount - fee, s) },
    };
}

// Check digits -----------------------------------------------------------------------------------

export function checkDigit(type, digits) {
    const d = digits.split('').map(Number);

    if (type === 'isbn10') {
        const sum = d.reduce((acc, x, k) => acc + x * (10 - k), 0);
        const check = (11 - (sum % 11)) % 11;

        return check === 10 ? 'X' : String(check);
    }

    if (type === 'luhn') {
        const sum = d.reverse().reduce((acc, x, k) => {
            const y = k % 2 === 0 ? x * 2 : x;

            return acc + (y > 9 ? y - 9 : y);
        }, 0);

        return String((10 - (sum % 10)) % 10);
    }

    // UPC-A and EAN/GTIN/ISBN-13: weights 3 and 1 alternating from the rightmost data digit.
    const sum = d.reverse().reduce((acc, x, k) => acc + x * (k % 2 === 0 ? 3 : 1), 0);

    return String((10 - (sum % 10)) % 10);
}

const CHECK_LENGTHS = { upc: 11, ean13: 12, ean8: 7, isbn10: 9, isbn13: 12, luhn: null };

// CPI --------------------------------------------------------------------------------------------

function cpiOf(c, year) {
    return c.data.cpi.annual[String(year)];
}

function inflationOutcome(i, c, label) {
    const s = symbolOf(c);
    const t = c.data.cpi;
    const from = Math.round(i.from);
    const to = Math.round(i.to);

    if (i.mode === 'rate') {
        if (!ok(i.amount, i.rate, i.years)) {
            return { empty: 'Enter the amount, inflation rate and years.' };
        }

        const value = i.amount * (1 + P(i.rate)) ** i.years;

        return { value: money(value, s), label: 'Future cost', sub: `${money(i.amount, s)} with ${pct(P(i.rate))} inflation for ${num(i.years)} years`, rows: { change: pct(value / i.amount - 1), power: `${money(i.amount / (1 + P(i.rate)) ** i.years, s)} is what ${money(i.amount, s)} will buy then, in today's money`, halving: `${num(Math.log(2) / Math.log(1 + P(i.rate)))} years to halve purchasing power`, source: 'Constant rate you entered' } };
    }

    const a = cpiOf(c, from);
    const b = cpiOf(c, to);

    if (!ok(i.amount) || !a || !b) {
        return { empty: `Enter an amount and years from ${t.first} to ${t.last}.` };
    }

    const value = (i.amount * b) / a;
    const years = Math.abs(to - from);

    return {
        value: money(value, s),
        label,
        sub: `${money(i.amount, s)} in ${from} has the same buying power as ${money(value, s)} in ${to}`,
        rows: {
            change: pct(b / a - 1),
            power: pct(years ? (b / a) ** (1 / years) - 1 : 0) + ' a year on average',
            halving: `CPI-U ${num(a)} in ${from}, ${num(b)} in ${to}${t.estimated.includes(to) || t.estimated.includes(from) ? ' (latest year estimated)' : ''}`,
            source: t.source,
        },
    };
}

export const handlers = {
    // Business planning --------------------------------------------------------------------------
    printer: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.printer, i.filament, i.grams, i.hours, i.outsource) || i.outsource <= 0) {
            return { empty: 'Enter the printer, material, print time and the outsourced price.' };
        }

        const material = (i.grams / 1000) * i.filament;
        const power = (or0(i.watts) / 1000) * i.hours * or0(i.kwh);
        const labor = or0(i.labor_minutes) / 60 * or0(i.wage);
        const perPart = material + power + labor + or0(i.wear) * i.hours;
        const saving = i.outsource - perPart;

        return {
            value: saving > 0 ? `${num(Math.ceil(i.printer / saving))} parts` : 'Never',
            label: 'Break-even',
            sub: saving > 0 ? `the printer pays for itself after this many parts` : 'Printing in-house costs more per part than outsourcing',
            rows: { per: money(perPart, s), material: money(material, s), power: money(power, s), saving: money(saving, s), at100: money(i.printer + perPart * 100 - i.outsource * 100, s) },
        };
    },

    depreciation: (i, c) => depreciationOutcome(i, c, false),
    accumulated: (i, c) => depreciationOutcome(i, c, true),

    afn: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.sales, i.next, i.assets, i.liabilities, i.margin, i.payout) || i.sales <= 0) {
            return { empty: 'Enter sales, projected sales, assets, spontaneous liabilities, margin and payout.' };
        }

        const dS = i.next - i.sales;
        const assetNeed = (i.assets / i.sales) * dS;
        const liabilityRise = (i.liabilities / i.sales) * dS;
        const retained = P(i.margin) * i.next * (1 - P(i.payout));
        const afn = assetNeed - liabilityRise - retained;

        return {
            value: money(afn, s),
            label: 'Additional funds needed',
            sub: afn > 0 ? 'external financing required' : 'growth can be funded internally',
            rows: { assets: money(assetNeed, s), liabilities: money(liabilityRise, s), retained: money(retained, s), growth: pct(dS / i.sales) },
        };
    },

    break_even: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.fixed, i.price, i.variable) || i.price <= i.variable) {
            return { empty: 'Enter fixed costs and a price above the variable cost.' };
        }

        const margin = i.price - i.variable;
        const units = (i.fixed + or0(i.target)) / margin;

        return {
            value: num(Math.ceil(units)),
            unit: 'units',
            label: or0(i.target) ? 'Units for the target profit' : 'Break-even units',
            sub: `${money(units * i.price, s)} of sales`,
            rows: { revenue: money(units * i.price, s), margin: `${money(margin, s)} a unit (${pct(margin / i.price)})`, safety: ok(i.expected) ? `${pct((i.expected - units) / i.expected)} margin of safety at ${num(i.expected)} units` : 'Enter expected sales', profit: ok(i.expected) ? money(i.expected * margin - i.fixed, s) : '—' },
            plots: { chart: { series: [[0, 0], [units * 2, units * 2 * i.price]], series2: [[0, i.fixed], [units * 2, i.fixed + units * 2 * i.variable]], legend: ['Revenue', 'Total cost'], xLabel: 'Units', yLabel: s, markers: [{ x: units, y: units * i.price, label: 'Break-even' }] } },
        };
    },

    build_buy: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.build_up, i.build_year, i.buy_up, i.buy_year, i.years, i.rate)) {
            return { empty: 'Enter both options\' costs, years and discount rate.' };
        }

        const flows = (up, yearly) => [up, ...Array.from({ length: Math.round(i.years) }, () => yearly)];
        const build = npv(P(i.rate), flows(i.build_up, i.build_year));
        const buy = npv(P(i.rate), flows(i.buy_up, i.buy_year));

        return {
            value: build <= buy ? 'Build' : 'Buy',
            label: 'Lower cost of ownership',
            sub: `saves ${money(Math.abs(buy - build), s)} in present value over ${num(i.years)} years`,
            rows: { build: money(build, s), buy: money(buy, s), nominalBuild: money(i.build_up + i.build_year * i.years, s), nominalBuy: money(i.buy_up + i.buy_year * i.years, s) },
        };
    },

    burndown: (i) => {
        const total = or0(i.total);
        const done = numberList(i.done);
        const days = Math.round(or0(i.days));

        if (!(total > 0) || !(days > 0) || !done.length) {
            return { empty: 'Enter total points, sprint days and points completed each day.' };
        }

        let remaining = total;
        const actual = [[0, total]];

        done.forEach((x, k) => {
            remaining -= x;
            actual.push([k + 1, remaining]);
        });

        const velocity = (total - remaining) / done.length;
        const finish = velocity > 0 ? done.length + remaining / velocity : Infinity;

        return {
            value: num(Math.max(0, remaining)),
            unit: 'points left',
            label: `After day ${done.length}`,
            sub: Number.isFinite(finish) ? `at ${num(velocity)} points a day the work finishes on day ${num(Math.ceil(finish))} of ${days}` : 'No progress yet',
            rows: { ideal: num(total - (total / days) * done.length), velocity: `${num(velocity)} points a day`, needed: done.length < days ? `${num(remaining / (days - done.length))} points a day to finish on time` : '—', status: finish <= days ? 'On track' : 'Behind schedule' },
            plots: { chart: { series: actual, series2: [[0, total], [days, 0]], legend: ['Actual', 'Ideal'], xLabel: 'Day', yLabel: 'Points remaining' } },
        };
    },

    burn_rate: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.cash, i.expenses) || i.expenses <= 0) {
            return { empty: 'Enter cash and monthly expenses.' };
        }

        const net = i.expenses - or0(i.revenue);

        return {
            value: net > 0 ? `${num(i.cash / net)} months` : 'Not burning',
            label: 'Runway',
            sub: net > 0 ? `net burn ${money(net, s)} a month` : 'Revenue covers expenses',
            rows: { gross: money(i.expenses, s), net: money(net, s), date: net > 0 ? `${num(Math.floor(i.cash / net))} full months of cash` : '—', raise: net > 0 ? `${money(net * 18, s)} buys 18 months of runway` : '—' },
        };
    },

    budget_lines: (i, c) => {
        const s = symbolOf(c);
        const rows = parseRows(i.lines).map((cells, k) => ({ name: cells[0] || `Line ${k + 1}`, type: String(cells[1] ?? '').toLowerCase().startsWith('i') ? 'income' : 'expense', amount: Number(cells[2]) })).filter((r) => ok(r.amount));

        if (!rows.length) {
            return { empty: 'Add income and expense lines.' };
        }

        const income = rows.filter((r) => r.type === 'income').reduce((a, b) => a + b.amount, 0);
        const expense = rows.filter((r) => r.type === 'expense').reduce((a, b) => a + b.amount, 0);

        return {
            value: money(income - expense, s),
            label: income >= expense ? 'Monthly surplus' : 'Monthly shortfall',
            sub: `${money((income - expense) * 12, s)} a year`,
            rows: { income: money(income, s), expenses: money(expense, s), margin: income ? pct((income - expense) / income) : '—', largest: rows.filter((r) => r.type === 'expense').sort((a, b) => b.amount - a.amount)[0]?.name ?? 'None' },
            lists: { lines: rows.filter((r) => r.type === 'expense').map((r) => ({ label: r.name, value: `${money(r.amount, s)} (${income ? pct(r.amount / income) : '—'} of income)` })) },
        };
    },

    valuation: (i, c) => {
        const s = symbolOf(c);
        const methods = [];

        if (ok(i.earnings, i.multiple) && i.earnings > 0) {
            methods.push(['Earnings multiple', i.earnings * i.multiple]);
        }

        if (ok(i.revenue, i.rev_multiple) && i.revenue > 0) {
            methods.push(['Revenue multiple', i.revenue * i.rev_multiple]);
        }

        if (ok(i.assets, i.liabilities) && i.assets > 0) {
            methods.push(['Net assets', i.assets - i.liabilities]);
        }

        if (ok(i.fcf, i.rate, i.growth) && i.fcf > 0 && P(i.rate) > P(i.growth)) {
            methods.push(['Discounted cash flow', (i.fcf * (1 + P(i.growth))) / (P(i.rate) - P(i.growth))]);
        }

        if (!methods.length) {
            return { empty: 'Enter figures for at least one method.' };
        }

        const values = methods.map(([, v]) => v);
        const average = values.reduce((a, b) => a + b, 0) / values.length;

        return {
            value: money0(average, s),
            label: 'Average of the methods',
            sub: `range ${money0(Math.min(...values), s)} to ${money0(Math.max(...values), s)}`,
            rows: { low: money0(Math.min(...values), s), high: money0(Math.max(...values), s), count: num(methods.length), note: 'Buyers usually weight the method that suits the business (assets for holding companies, earnings for profitable firms)' },
            lists: { methods: methods.map(([name, v]) => ({ label: name, value: money0(v, s) })) },
        };
    },

    churn: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.start, i.lost) || i.start <= 0) {
            return { empty: 'Enter customers at the start and customers lost.' };
        }

        const rate = i.lost / i.start;
        const months = Math.max(1, or0(i.months) || 1);
        const monthly = 1 - (1 - rate) ** (1 / months);
        const revenueChurn = ok(i.mrr, i.churned_mrr) && i.mrr > 0 ? i.churned_mrr / i.mrr : NaN;
        const nrr = ok(i.mrr) && i.mrr > 0 ? (i.mrr - or0(i.churned_mrr) - or0(i.contraction) + or0(i.expansion)) / i.mrr : NaN;

        return {
            value: num(rate * 100),
            unit: '%',
            label: 'Customer churn rate',
            sub: `${num(i.lost)} of ${num(i.start)} customers lost in ${num(months)} month${months === 1 ? '' : 's'}`,
            rows: { monthly: pct(monthly), annual: pct(1 - (1 - monthly) ** 12), lifetime: `${num(1 / monthly)} months average lifetime`, revenue: Number.isFinite(revenueChurn) ? pct(revenueChurn) : 'Enter MRR figures', nrr: Number.isFinite(nrr) ? pct(nrr) : 'Enter MRR figures' },
        };
    },

    consulting: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.income, i.hours, i.weeks) || i.hours <= 0 || i.weeks <= 0) {
            return { empty: 'Enter target income, billable hours and weeks.' };
        }

        const needed = (i.income + or0(i.overhead) + or0(i.taxes)) / (1 - P(or0(i.profit)));
        const hourly = needed / (i.hours * i.weeks);

        return {
            value: money(hourly, s),
            label: 'Hourly rate',
            sub: `${num(i.hours * i.weeks)} billable hours a year`,
            rows: { day: money(hourly * 8, s), week: money(hourly * i.hours, s), project: ok(i.project_hours) ? money(hourly * i.project_hours, s) : 'Enter project hours', revenue: money(needed, s) },
        };
    },

    cost_function: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.fixed, i.variable, i.quantity) || i.quantity <= 0) {
            return { empty: 'Enter fixed cost, variable cost and quantity.' };
        }

        const q = i.quantity;
        const a2 = or0(i.quadratic);
        const total = i.fixed + i.variable * q + a2 * q * q;
        const series = [];

        for (let k = 0; k <= 40; k += 1) {
            const x = (q * 2 * k) / 40;
            series.push([x, i.fixed + i.variable * x + a2 * x * x]);
        }

        return {
            value: money(total, s),
            label: 'Total cost',
            sub: a2 ? `C(Q) = ${num(i.fixed)} + ${num(i.variable)}Q + ${num(a2)}Q²` : `C(Q) = ${num(i.fixed)} + ${num(i.variable)}Q`,
            rows: { average: money(total / q, s), afc: money(i.fixed / q, s), avc: money(i.variable + a2 * q, s), marginal: money(i.variable + 2 * a2 * q, s), minimum: a2 > 0 ? `${num(Math.sqrt(i.fixed / a2))} units minimize average cost` : 'Average cost keeps falling with output' },
            plots: { chart: { series, xLabel: 'Quantity', yLabel: s, markers: [{ x: q, y: total, label: 'Q' }] } },
        };
    },

    cost_business: (i, c) => {
        const s = symbolOf(c);
        const monthly = or0(i.overhead) + or0(i.payroll) + or0(i.direct) + or0(i.other);

        if (!(monthly > 0)) {
            return { empty: 'Enter your monthly costs.' };
        }

        return {
            value: money(monthly, s),
            label: 'Cost of doing business a month',
            sub: `${money(monthly * 12, s)} a year`,
            rows: { hour: ok(i.hours) && i.hours > 0 ? money(monthly / i.hours, s) : 'Enter billable hours', day: money((monthly * 12) / 260, s), share: `Overhead ${pct(or0(i.overhead) / monthly)}, payroll ${pct(or0(i.payroll) / monthly)}`, revenue: ok(i.margin) ? `${money(monthly / (1 - P(i.margin)), s)} a month of revenue for a ${num(i.margin)}% margin` : 'Enter a target margin' },
        };
    },

    cpm: (i, c) => {
        const s = symbolOf(c);
        const solve = i.solve ?? 'cpm';
        let cost = i.cost;
        let impressions = i.impressions;

        if (solve === 'cost') {
            cost = (i.cpm * impressions) / 1000;
        } else if (solve === 'impressions') {
            impressions = (cost / i.cpm) * 1000;
        }

        if (!ok(cost, impressions) || impressions <= 0) {
            return { empty: 'Enter two of cost, impressions and CPM.' };
        }

        const cpm = (cost / impressions) * 1000;
        const clicks = ok(i.clicks) ? i.clicks : NaN;

        return {
            value: solve === 'cost' ? money(cost, s) : solve === 'impressions' ? num(impressions) : money(cpm, s),
            label: { cpm: 'CPM (cost per 1,000 impressions)', cost: 'Campaign cost', impressions: 'Impressions' }[solve],
            sub: `${money(cost, s)} for ${num(impressions)} impressions`,
            rows: { cpm: money(cpm, s), cpc: Number.isFinite(clicks) && clicks > 0 ? money(cost / clicks, s) : 'Enter clicks', ctr: Number.isFinite(clicks) ? pct(clicks / impressions) : 'Enter clicks', per: money(cost / impressions, s) },
        };
    },

    evm: (i) => {
        if (!ok(i.bac, i.pv, i.ev, i.ac) || i.ac <= 0 || i.pv <= 0) {
            return { empty: 'Enter BAC, PV, EV and AC.' };
        }

        const cpi = i.ev / i.ac;
        const spi = i.ev / i.pv;
        const eac = i.bac / cpi;

        return {
            value: num(cpi),
            label: 'Cost performance index (CPI)',
            sub: `${cpi >= 1 ? 'Under' : 'Over'} budget, ${spi >= 1 ? 'ahead of' : 'behind'} schedule (SPI ${num(spi)})`,
            rows: { cv: num(i.ev - i.ac), sv: num(i.ev - i.pv), spi: num(spi), eac: num(eac), etc: num(eac - i.ac), vac: num(i.bac - eac), tcpi: num((i.bac - i.ev) / (i.bac - i.ac)) },
        };
    },

    emv: (i, c) => {
        const s = symbolOf(c);
        const rows = parseRows(i.outcomes).map((cells, k) => ({ name: cells[0] || `Outcome ${k + 1}`, p: P(Number(cells[1])), v: Number(cells[2]) })).filter((r) => ok(r.p, r.v));

        if (!rows.length) {
            return { empty: 'Add outcomes with a probability and an impact.' };
        }

        const total = rows.reduce((a, b) => a + b.p, 0);
        const emv = rows.reduce((a, b) => a + b.p * b.v, 0);

        return {
            value: money(emv, s),
            label: 'Expected monetary value',
            sub: Math.abs(total - 1) > 0.001 ? `Probabilities add up to ${pct(total)} (fine for independent risks; scenarios should total 100%)` : 'Probabilities total 100%',
            rows: { threats: money(rows.filter((r) => r.v < 0).reduce((a, b) => a + b.p * b.v, 0), s), opportunities: money(rows.filter((r) => r.v > 0).reduce((a, b) => a + b.p * b.v, 0), s), probability: pct(total), count: num(rows.length) },
            lists: { outcomes: rows.map((r) => ({ label: `${r.name} (${pct(r.p)})`, value: money(r.p * r.v, s) })) },
        };
    },

    fifo: (i, c) => inventoryCost(i, c, c.method ?? 'fifo'),

    adsense: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.views) || i.views <= 0) {
            return { empty: 'Enter daily page views.' };
        }

        const daily = i.mode === 'cpc' ? i.views * P(or0(i.ctr)) * or0(i.cpc) : (i.views / 1000) * or0(i.rpm);

        return {
            value: money(daily * 30.4375, s),
            label: 'Estimated earnings a month',
            sub: 'an estimate from your own figures; AdSense pays 68% of ad revenue to publishers for content ads',
            rows: { day: money(daily, s), year: money(daily * 365.25, s), rpm: money((daily / i.views) * 1000, s), note: 'RPM varies by niche, country and season' },
        };
    },

    hhi: (i) => {
        const shares = numberList(i.shares);

        if (!shares.length) {
            return { empty: 'Enter market shares in percent.' };
        }

        const total = shares.reduce((a, b) => a + b, 0);
        const hhi = shares.reduce((a, b) => a + b * b, 0);
        const merged = shares.length >= 2 ? hhi + 2 * shares[0] * shares[1] : NaN;

        return {
            value: num(hhi),
            label: 'Herfindahl-Hirschman Index',
            sub: hhi > 1800 ? 'Highly concentrated (over 1,800, 2023 Merger Guidelines)' : hhi >= 1000 ? 'Moderately concentrated' : 'Unconcentrated (under 1,000)',
            rows: { total: `${num(total)}%${Math.abs(total - 100) > 0.01 ? ' (shares do not add to 100%)' : ''}`, firms: num(shares.length), equivalent: num(10000 / hhi), merger: Number.isFinite(merged) ? `Merging the first two: ${num(merged)} (+${num(merged - hhi)}${merged > 1800 && merged - hhi > 100 ? ', presumed to lessen competition' : ''})` : '—' },
        };
    },

    high_low: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.high_units, i.high_cost, i.low_units, i.low_cost) || i.high_units === i.low_units) {
            return { empty: 'Enter activity and cost at the highest and lowest levels.' };
        }

        const vc = (i.high_cost - i.low_cost) / (i.high_units - i.low_units);
        const fc = i.high_cost - vc * i.high_units;

        return {
            value: money(vc, s),
            label: 'Variable cost per unit',
            sub: `fixed cost ${money(fc, s)} a period`,
            rows: { fixed: money(fc, s), formula: `Cost = ${money(fc, s)} + ${money(vc, s)} × units`, predict: ok(i.at) ? money(fc + vc * i.at, s) : 'Enter an activity level to predict', check: money(fc + vc * i.low_units, s) },
        };
    },

    labor_cost: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.wage, i.hours) || i.wage <= 0) {
            return { empty: 'Enter the wage and hours a week.' };
        }

        const yearlyWage = i.wage * i.hours * 52;
        const taxes = yearlyWage * P(or0(i.taxes));
        const benefits = or0(i.benefits) * 12;
        const overhead = yearlyWage * P(or0(i.overhead));
        const total = yearlyWage + taxes + benefits + overhead;
        const productive = i.hours * 52 - or0(i.paid_off) * 8;

        return {
            value: money(total / productive, s),
            label: 'Fully loaded cost per productive hour',
            sub: `${money(total, s)} a year for ${num(productive)} productive hours`,
            rows: { yearly: money(total, s), monthly: money(total / 12, s), burden: pct(total / yearlyWage - 1), wage: money(yearlyWage, s) },
        };
    },

    days_off: (i) => {
        if (!ok(i.entitlement, i.months)) {
            return { empty: 'Enter the yearly entitlement and months worked.' };
        }

        const accrued = (i.entitlement * Math.min(12, i.months)) / 12 + or0(i.carried);
        const left = accrued - or0(i.used);

        return {
            value: num(left),
            unit: 'days',
            label: 'Leave remaining',
            sub: `${num(accrued)} days accrued after ${num(i.months)} months`,
            rows: { accrued: `${num(accrued)} days`, used: `${num(or0(i.used))} days`, rate: `${num(i.entitlement / 12)} days a month`, hours: `${num(left * (or0(i.hours) || 8))} hours` },
        };
    },

    funnel: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.impressions, i.ctr, i.lead_rate, i.close_rate, i.value)) {
            return { empty: 'Enter the funnel figures.' };
        }

        const clicks = i.impressions * P(i.ctr);
        const leads = clicks * P(i.lead_rate);
        const sales = leads * P(i.close_rate);
        const revenue = sales * i.value;
        const spend = or0(i.spend);

        return {
            value: money(revenue, s),
            label: 'Revenue',
            sub: `${num(sales)} sales from ${num(i.impressions)} impressions`,
            rows: { clicks: num(clicks), leads: num(leads), sales: num(sales), cpa: spend ? money(spend / sales, s) : 'Enter ad spend', roas: spend ? `${num(revenue / spend)}×` : 'Enter ad spend' },
            lists: { stages: [['Impressions', i.impressions], ['Clicks', clicks], ['Leads', leads], ['Sales', sales]].map(([k, v]) => ({ label: k, value: num(v) })) },
        };
    },

    saas: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.mrr, i.customers) || i.mrr <= 0 || i.customers <= 0) {
            return { empty: 'Enter MRR and customers at the start of the month.' };
        }

        const end = i.mrr + or0(i.new_mrr) + or0(i.expansion) - or0(i.contraction) - or0(i.churned_mrr);
        const customersEnd = i.customers + or0(i.new_customers) - or0(i.lost);
        const churn = or0(i.lost) / i.customers;
        const arpa = end / customersEnd;
        const nrr = (i.mrr + or0(i.expansion) - or0(i.contraction) - or0(i.churned_mrr)) / i.mrr;
        const margin = P(ok(i.margin) ? i.margin : 80);
        const ltv = churn > 0 ? (arpa * margin) / churn : NaN;
        const cac = ok(i.spend) && or0(i.new_customers) > 0 ? i.spend / i.new_customers : NaN;

        return {
            value: money(end, s),
            label: 'MRR at month end',
            sub: `ARR ${money(end * 12, s)}, ${pct(end / i.mrr - 1)} growth this month`,
            rows: { arr: money(end * 12, s), arpa: money(arpa, s), churn: pct(churn), nrr: pct(nrr), ltv: Number.isFinite(ltv) ? money(ltv, s) : 'No churn: LTV unbounded', cac: Number.isFinite(cac) ? `${money(cac, s)}; payback ${num(cac / (arpa * margin))} months` : 'Enter sales and marketing spend', ratio: Number.isFinite(ltv) && Number.isFinite(cac) ? `${num(ltv / cac)}×` : '—' },
        };
    },

    safety_stock: (i) => {
        const z = { 90: 1.2816, 95: 1.6449, 97.5: 1.96, 98: 2.0537, 99: 2.3263, 99.9: 3.0902 }[Number(i.service)];

        if (!ok(i.demand, i.sd, i.lead) || !z) {
            return { empty: 'Enter demand, its variability and lead time.' };
        }

        const sdLead = or0(i.sd_lead);
        const ss = z * Math.sqrt(i.lead * i.sd ** 2 + i.demand ** 2 * sdLead ** 2);

        return {
            value: num(Math.ceil(ss)),
            unit: 'units',
            label: 'Safety stock',
            sub: `${i.service}% cycle service level (z = ${num(z)})`,
            rows: { rop: `${num(Math.ceil(i.demand * i.lead + ss))} units`, lead: `${num(i.demand * i.lead)} units`, formula: sdLead ? 'Demand and lead-time variability combined' : 'Demand variability only', days: `${num(ss / i.demand)} days of demand` },
        };
    },

    commission: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.sales) || i.sales < 0) {
            return { empty: 'Enter total sales.' };
        }

        let commission = 0;
        const steps = [];

        if (i.plan === 'tiered') {
            const tiers = parseRows(i.tiers).map((cells) => ({ from: Number(cells[0]), rate: P(Number(cells[1])) })).filter((t) => ok(t.from, t.rate)).sort((a, b) => a.from - b.from);

            tiers.forEach((t, k) => {
                const to = k + 1 < tiers.length ? tiers[k + 1].from : Infinity;

                if (i.sales > t.from) {
                    const part = Math.min(i.sales, to) - t.from;
                    commission += part * t.rate;
                    steps.push({ label: `${pct(t.rate)} on ${money0(t.from, s)}–${Number.isFinite(to) ? money0(to, s) : 'up'}`, value: money(part * t.rate, s) });
                }
            });
        } else {
            commission = i.sales * P(or0(i.rate));
            steps.push({ label: `${num(or0(i.rate))}% of ${money(i.sales, s)}`, value: money(commission, s) });
        }

        const draw = or0(i.draw);
        const pay = Math.max(commission, draw);

        return {
            value: money(pay + or0(i.base), s),
            label: 'Pay for the period',
            sub: draw ? (commission >= draw ? `commission ${money(commission, s)} covers the ${money(draw, s)} draw` : `${money(draw - commission, s)} of the draw is carried forward`) : `${money(commission, s)} commission${or0(i.base) ? ` + ${money(i.base, s)} base` : ''}`,
            rows: { commission: money(commission, s), effective: pct(i.sales ? commission / i.sales : 0), draw: draw ? money(Math.max(0, draw - commission), s) : 'No draw', base: money(or0(i.base), s) },
            lists: { tiers: steps },
        };
    },

    smoking: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.breaks, i.minutes, i.wage) || i.wage <= 0) {
            return { empty: 'Enter breaks, minutes and wage.' };
        }

        const days = ok(i.days) ? i.days : 230;
        const hours = (i.breaks * i.minutes * days) / 60;
        const time = hours * i.wage * (1 + P(or0(i.burden)));
        const total = time + or0(i.health);

        return {
            value: money(total, s),
            label: 'Yearly cost to the employer',
            sub: `${num(hours)} hours of breaks a year`,
            rows: { time: money(time, s), health: money(or0(i.health), s), days: `${num(hours / 8)} working days`, staff: ok(i.smokers) ? money(total * i.smokers, s) : 'Enter the number of smokers' },
        };
    },

    tenure: (i) => {
        const a = /^(\d{4})-(\d{2})-(\d{2})$/.exec(String(i.start ?? ''));
        const b = /^(\d{4})-(\d{2})-(\d{2})$/.exec(String(i.end ?? ''));

        if (!a || !b) {
            return { empty: 'Enter the start and end dates.' };
        }

        const [y1, m1, d1] = a.slice(1).map(Number);
        const [y2, m2, d2] = b.slice(1).map(Number);
        const start = Date.UTC(y1, m1 - 1, d1);
        const end = Date.UTC(y2, m2 - 1, d2);

        if (end < start) {
            return { error: 'The end date is before the start date.' };
        }

        let years = y2 - y1;
        let monthsDiff = m2 - m1;
        let days = d2 - d1;

        if (days < 0) {
            monthsDiff -= 1;
            days += new Date(Date.UTC(y2, m2 - 1, 0)).getUTCDate();
        }

        if (monthsDiff < 0) {
            years -= 1;
            monthsDiff += 12;
        }

        const totalDays = (end - start) / 86400000;

        return {
            value: `${years} years ${monthsDiff} months`,
            label: 'Tenure',
            sub: `and ${days} days`,
            rows: { decimal: `${num(totalDays / 365.2425)} years`, months: num(years * 12 + monthsDiff), days: num(totalDays), weeks: num(totalDays / 7) },
        };
    },

    ad_revenue: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.views, i.rpm)) {
            return { empty: 'Enter monthly views and RPM.' };
        }

        const share = ok(i.monetized) ? P(i.monetized) : 1;
        const month = (i.views / 1000) * share * i.rpm;

        return {
            value: money(month, s),
            label: 'Estimated revenue a month',
            sub: `${num(i.views)} views at ${money(i.rpm, s)} RPM${share < 1 ? `, ${pct(share)} monetized` : ''}`,
            rows: { year: money(month * 12, s), day: money(month / 30.4375, s), per1000: money(i.rpm * share, s), range: `${money(month * 0.5, s)} – ${money(month * 1.5, s)} if RPM varies ±50%` },
        };
    },

    payroll_cost: (i, c) => {
        const s = symbolOf(c);
        const f = c.data.federal.fica;

        if (!ok(i.salary) || i.salary <= 0) {
            return { empty: 'Enter the salary.' };
        }

        const fica = Math.min(i.salary, f.wage_base) * f.ss_rate + i.salary * f.medicare;
        const futa = Math.min(i.salary, 7000) * 0.006;
        const suta = Math.min(i.salary, or0(i.suta_base) || 7000) * P(or0(i.suta));
        const benefits = or0(i.benefits) * 12;
        const match = i.salary * P(or0(i.match));
        const other = or0(i.other);
        const total = i.salary + fica + futa + suta + benefits + match + other;

        return {
            value: money(total, s),
            label: 'Total cost per employee a year',
            sub: `${num(total / i.salary)}× the salary`,
            rows: { fica: money(fica, s), unemployment: money(futa + suta, s), benefits: money(benefits + match, s), monthly: money(total / 12, s), hourly: money(total / 2080, s) },
        };
    },

    // Sales -------------------------------------------------------------------------------------
    stacked_discounts: (i, c) => {
        const s = symbolOf(c);
        const items = parseRows(i.items).map((cells, k) => ({ name: cells[0] || `Item ${k + 1}`, price: Number(cells[1]), off: P(Number(cells[2] || 0)), extra: P(Number(cells[3] || 0)), qty: Number(cells[4] || 1) })).filter((r) => ok(r.price, r.off, r.extra, r.qty));

        if (!items.length) {
            return { empty: 'Add items with a price and discounts.' };
        }

        const list = items.reduce((a, r) => a + r.price * r.qty, 0);
        const sale = items.reduce((a, r) => a + r.price * (1 - r.off) * (1 - r.extra) * r.qty, 0);
        const coupon = Math.min(sale, or0(i.coupon));
        const subtotal = sale - coupon;
        const tax = subtotal * P(or0(i.tax));

        return {
            value: money(subtotal + tax, s),
            label: 'You pay',
            sub: `saving ${money(list - subtotal, s)} (${pct((list - subtotal) / list)}) on ${money(list, s)}`,
            rows: { list: money(list, s), saved: money(list - subtotal, s), tax: money(tax, s), coupon: money(coupon, s) },
            lists: { items: items.map((r) => ({ label: `${r.name}${r.qty > 1 ? ` × ${r.qty}` : ''}`, value: `${money(r.price * (1 - r.off) * (1 - r.extra) * r.qty, s)} (${pct(1 - (1 - r.off) * (1 - r.extra))} off)` })) },
        };
    },

    check_digit: (i) => {
        const type = i.type ?? 'ean13';
        const digits = String(i.code ?? '').replace(/[\s-]/g, '');
        const want = CHECK_LENGTHS[type];

        if (!/^\d+$/.test(digits) || (want && digits.length !== want && digits.length !== want + 1) || (!want && digits.length < 2)) {
            return { empty: want ? `Enter ${want} digits (or all ${want + 1} to verify).` : 'Enter the number without its check digit (or with it, to verify).' };
        }

        const verifying = want ? digits.length === want + 1 : false;
        const body = verifying ? digits.slice(0, -1) : digits;
        const check = checkDigit(type, body);
        const valid = verifying ? check === digits.slice(-1).toUpperCase() : null;

        return {
            value: check,
            label: 'Check digit',
            sub: verifying ? (valid ? 'The number is valid' : `Invalid: the last digit should be ${check}`) : `Full number: ${body}${check}`,
            rows: { full: `${body}${check}`, type: { upc: 'UPC-A', ean13: 'EAN-13 / GTIN-13', ean8: 'EAN-8', isbn10: 'ISBN-10 (mod 11)', isbn13: 'ISBN-13', luhn: 'Luhn (mod 10)' }[type], valid: verifying ? (valid ? 'Valid' : 'Invalid') : 'Enter the full number to verify', method: type === 'isbn10' ? 'Weights 10 to 2, mod 11 (10 = X)' : type === 'luhn' ? 'Double every second digit from the right, mod 10' : 'Weights 3 and 1 from the right, mod 10' },
        };
    },

    margin: (i, c) => {
        const s = symbolOf(c);
        const mode = i.mode ?? 'cost_price';
        let cost = i.cost;
        let price = i.price;

        if (mode === 'cost_margin') {
            price = cost / (1 - P(or0(i.margin)));
        } else if (mode === 'price_margin') {
            cost = price * (1 - P(or0(i.margin)));
        }

        if (!ok(cost, price) || price <= 0) {
            return { empty: 'Enter two of cost, price and margin.' };
        }

        const profit = price - cost;

        return {
            value: mode === 'cost_margin' ? money(price, s) : mode === 'price_margin' ? money(cost, s) : `${num((profit / price) * 100)}%`,
            label: { cost_price: 'Gross margin', cost_margin: 'Selling price', price_margin: 'Maximum cost' }[mode],
            sub: `profit ${money(profit, s)} a unit`,
            rows: { margin: pct(profit / price), markup: cost ? pct(profit / cost) : '—', profit: money(profit, s), price: money(price, s) },
        };
    },

    paypal: (i, c) => {
        const t = c.data.fees.paypal;
        const kind = t[i.kind ?? 'checkout'];

        return feeOutcome(i, c, kind[0], kind[1], `PayPal ${kind[2]}`);
    },

    stripe: (i, c) => {
        const t = c.data.fees.stripe;
        const kind = t[i.kind ?? 'card'];

        return feeOutcome(i, c, kind[0], kind[1], `Stripe ${kind[2]}`);
    },

    eoq: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.demand, i.order_cost, i.holding) || i.demand <= 0 || i.holding <= 0) {
            return { empty: 'Enter annual demand, ordering cost and holding cost.' };
        }

        const q = Math.sqrt((2 * i.demand * i.order_cost) / i.holding);
        const orders = i.demand / q;

        return {
            value: num(q),
            unit: 'units',
            label: 'Economic order quantity',
            sub: `${num(orders)} orders a year`,
            rows: { orders: num(orders), cycle: `${num(365 / orders)} days between orders`, cost: money(orders * i.order_cost + (q / 2) * i.holding, s), rop: ok(i.lead) ? `${num((i.demand / 365) * i.lead)} units` : 'Enter lead time' },
        };
    },

    optimal_price: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.a, i.b, i.mc) || i.b <= 0) {
            return { empty: 'Enter the demand intercept, slope and marginal cost.' };
        }

        // Linear demand Q = a − bP: revenue P(a − bP), MR = MC gives P* = (a/b + MC) ÷ 2.
        const price = (i.a / i.b + i.mc) / 2;
        const q = i.a - i.b * price;

        if (q <= 0) {
            return { error: 'At this cost nothing sells at a profit.' };
        }

        return {
            value: money(price, s),
            label: 'Profit-maximizing price',
            sub: `sells ${num(q)} units`,
            rows: { quantity: num(q), profit: money((price - i.mc) * q - or0(i.fixed), s), elasticity: num((-i.b * price) / q), markup: pct((price - i.mc) / price) },
        };
    },

    // Macroeconomics ----------------------------------------------------------------------------
    cpi: (i, c) => inflationOutcome(i, c, 'Equivalent value'),

    comparative: (i) => {
        if (!ok(i.a1, i.a2, i.b1, i.b2) || [i.a1, i.a2, i.b1, i.b2].some((x) => x <= 0)) {
            return { empty: 'Enter how much of each good each producer can make.' };
        }

        // Opportunity cost of one unit of good 1 = units of good 2 given up.
        const oaA = i.a2 / i.a1;
        const oaB = i.b2 / i.b1;
        const first = oaA < oaB ? i.name_a || 'Producer A' : i.name_b || 'Producer B';
        const second = oaA < oaB ? i.name_b || 'Producer B' : i.name_a || 'Producer A';

        return {
            value: first,
            label: `Comparative advantage in ${i.good1 || 'good 1'}`,
            sub: `${second} has the comparative advantage in ${i.good2 || 'good 2'}`,
            rows: { a: `${i.name_a || 'A'}: 1 ${i.good1 || 'good 1'} costs ${num(oaA)} ${i.good2 || 'good 2'}`, b: `${i.name_b || 'B'}: 1 ${i.good1 || 'good 1'} costs ${num(oaB)} ${i.good2 || 'good 2'}`, terms: `Trade benefits both at a price between ${num(Math.min(oaA, oaB))} and ${num(Math.max(oaA, oaB))} ${i.good2 || 'good 2'} per ${i.good1 || 'good 1'}`, absolute: i.a1 > i.b1 ? `${i.name_a || 'A'} has the absolute advantage in ${i.good1 || 'good 1'}` : `${i.name_b || 'B'} has the absolute advantage in ${i.good1 || 'good 1'}` },
        };
    },

    discretionary: (i, c) => {
        const s = symbolOf(c);
        const t = c.data.poverty;

        if (!ok(i.income) || i.income < 0) {
            return { empty: 'Enter your income.' };
        }

        const size = Math.max(1, Math.round(or0(i.family) || 1));
        const region = i.region ?? 'contiguous';
        const guideline = t[region].base + t[region].step * (size - 1);
        const plan = Number(i.plan ?? 150);
        const discretionary = Math.max(0, i.income - guideline * P(plan));
        const budget = i.income - or0(i.taxes) - or0(i.essentials);

        return {
            value: money(discretionary, s),
            label: 'Discretionary income (student loan definition)',
            sub: `AGI above ${num(plan)}% of the ${t.year} poverty guideline (${money0(guideline, s)} for ${size})`,
            rows: { guideline: money0(guideline, s), monthly: money(discretionary / 12, s), ibr: `${money(discretionary * 0.1 / 12, s)} a month at 10% (IBR for new borrowers)`, budget: ok(i.taxes, i.essentials) ? `${money(budget, s)} a year after taxes and essentials (budgeting definition)` : 'Enter taxes and essentials' },
        };
    },

    gdp: (i, c) => {
        const s = symbolOf(c);

        if (i.mode === 'income') {
            const parts = ['wages', 'rent', 'interest', 'profits', 'taxes', 'depreciation'].map((k) => or0(i[k]));
            const total = parts.reduce((a, b) => a + b, 0);

            return total ? { value: money(total, s), label: 'GDP (income approach)', sub: 'compensation + rent + interest + profits + indirect taxes + depreciation', rows: { share: `Compensation of employees ${pct(parts[0] / total)}, profits ${pct(parts[3] / total)}` } } : { empty: 'Enter the income components.' };
        }

        const C = or0(i.c);
        const I = or0(i.inv);
        const G = or0(i.g);
        const NX = or0(i.x) - or0(i.m);
        const total = C + I + G + NX;

        if (!total) {
            return { empty: 'Enter consumption, investment, government spending and trade.' };
        }

        return {
            value: money(total, s),
            label: 'GDP (expenditure approach)',
            sub: `C ${pct(C / total)}, I ${pct(I / total)}, G ${pct(G / total)}, net exports ${pct(NX / total)}`,
            rows: { share: `Net exports ${money(NX, s)} (${NX < 0 ? 'trade deficit' : 'trade surplus'})` },
        };
    },

    gini: (i) => {
        const incomes = numberList(i.incomes).filter((x) => x >= 0).sort((a, b) => a - b);

        if (incomes.length < 2) {
            return { empty: 'Enter at least two incomes.' };
        }

        const n = incomes.length;
        const total = incomes.reduce((a, b) => a + b, 0);
        // G = Σ (2k − n − 1) xₖ ÷ (n Σ x) with incomes sorted ascending.
        const g = incomes.reduce((acc, x, k) => acc + (2 * (k + 1) - n - 1) * x, 0) / (n * total);
        let cumulative = 0;
        const lorenz = [[0, 0], ...incomes.map((x, k) => { cumulative += x; return [((k + 1) / n) * 100, (cumulative / total) * 100]; })];

        return {
            value: num(g),
            label: 'Gini coefficient',
            sub: g < 0.3 ? 'Low inequality' : g < 0.45 ? 'Moderate inequality' : 'High inequality',
            rows: { mean: num(total / n), median: num(n % 2 ? incomes[(n - 1) / 2] : (incomes[n / 2 - 1] + incomes[n / 2]) / 2), top: pct(incomes.slice(Math.floor(n * 0.8)).reduce((a, b) => a + b, 0) / total), count: num(n) },
            plots: { chart: { series: lorenz, series2: [[0, 0], [100, 100]], legend: ['Lorenz curve', 'Equality'], xLabel: 'Population (%)', yLabel: 'Income (%)' } },
        };
    },

    ppp: (i) => {
        if (!ok(i.price_a, i.price_b) || i.price_a <= 0 || i.price_b <= 0) {
            return { empty: 'Enter the price of the same basket in both countries.' };
        }

        const implied = i.price_b / i.price_a;
        const market = ok(i.rate) ? i.rate : NaN;

        return {
            value: num(implied),
            label: 'Implied PPP exchange rate (B per A)',
            sub: Number.isFinite(market) ? `Currency B is ${market > implied ? 'undervalued' : 'overvalued'} by ${pct(Math.abs(implied / market - 1))} against the market rate ${num(market)}` : 'Enter the market exchange rate to compare',
            rows: { implied: num(implied), valuation: Number.isFinite(market) ? pct(implied / market - 1) : '—', income: ok(i.income) ? `${num(i.income / implied)} in currency A at PPP` : 'Enter an income in currency B to convert' },
        };
    },
};

export default defineTools(handlers);
