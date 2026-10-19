import { getCurrency } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { money, money0, num, pct, yearGrid } from '../finance/common.js';
import { parseRows } from '../rows-editor.js';
import { federalTax } from './fin-tax.js';

/**
 * Personal finance odds and ends: budgets, bank reconciliation, car depreciation, phone plans, long-term care,
 * lottery payouts, rent splits, scrap metal, income percentile, wedding budgets, money counting, VA disability
 * and simple workplace comparisons.
 */
const P = (value) => value / 100;
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
// Fixed-currency pages pass `sym` (a currency code); otherwise the page's display currency applies.
const symbolOf = (c) => c.sym ?? getCurrency();
const TROY = 31.1034768;

/**
 * Lottery jackpot annuity: 30 payments, each 5% larger than the last, summing to the advertised jackpot.
 */
export function lotteryAnnuity(jackpot, years = 30, growth = 0.05) {
    const first = (jackpot * growth) / ((1 + growth) ** years - 1);

    return Array.from({ length: years }, (_, k) => first * (1 + growth) ** k);
}

function lotteryOutcome(i, c, game) {
    const s = symbolOf(c);
    const f = c.data.federal;

    if (!ok(i.jackpot) || i.jackpot <= 0) {
        return { empty: 'Enter the advertised jackpot.' };
    }

    const status = i.status ?? 'single';
    const cash = ok(i.cash) && i.cash > 0 ? i.cash : i.jackpot * P(ok(i.cash_pct) ? i.cash_pct : 45);
    const state = P(or0(i.state_rate));
    const taxOn = (amount) => federalTax(f, { ordinary: amount + or0(i.income), status }).beforeCredits - federalTax(f, { ordinary: or0(i.income), status }).beforeCredits;
    const payments = lotteryAnnuity(i.jackpot);
    const annuityNet = payments.reduce((sum, p) => sum + p - taxOn(p) - p * state, 0);
    const cashNet = cash - taxOn(cash) - cash * state;
    // Present value of the after-tax annuity at your investment return, to compare like with like.
    const r = P(or0(i.rate));
    const annuityPv = payments.reduce((sum, p, k) => sum + (p - taxOn(p) - p * state) / (1 + r) ** k, 0);

    return {
        value: money0(cashNet, s),
        label: 'Cash option after tax',
        sub: `${game}: ${money0(cash, s)} cash value, or ${money0(annuityNet, s)} after tax over 30 years`,
        rows: {
            first: `${money0(payments[0], s)} rising 5% a year to ${money0(payments[29], s)}`,
            annuity: money0(annuityNet, s),
            pv: `${money0(annuityPv, s)} today at ${pct(r)}`,
            better: annuityPv > cashNet ? 'The annuity is worth more at your investment return' : 'The cash option is worth more at your investment return',
            withheld: money0(cash * f.lottery_withholding, s),
        },
        grids: { schedule: { columns: ['Payment', 'After tax'], rows: payments.map((p, k) => ({ header: String(k + 1), cells: [money0(p, s), money0(p - taxOn(p) - p * state, s)] })), roomy: true } },
    };
}

function scrapOutcome(i, c, metal) {
    const s = symbolOf(c);
    const items = parseRows(i.items).map((cells) => ({ grams: Number(cells[0]), purity: Number(cells[1]) })).filter((x) => ok(x.grams, x.purity) && x.grams > 0);

    if (!items.length || !ok(i.spot) || i.spot <= 0) {
        return { empty: `Add pieces with weight and ${metal === 'gold' ? 'karat' : 'purity'}, and the spot price.` };
    }

    // Gold purity is entered in karats (24 = pure), silver as fineness in ‰ or % (925 or 92.5).
    const fraction = (p) => (metal === 'gold' ? p / 24 : p > 100 ? p / 1000 : p / 100);
    const pure = items.reduce((sum, x) => sum + x.grams * fraction(x.purity), 0);
    const melt = (pure / TROY) * i.spot;
    const payout = P(ok(i.payout) ? i.payout : 80);

    return {
        value: money(melt, s),
        label: 'Melt value',
        sub: `${num(pure)} g of pure ${metal} (${num(pure / TROY)} troy oz) at ${money(i.spot, s)} an ounce`,
        rows: { offer: `${money(melt * payout, s)} at a ${pct(payout)} buyer payout`, pure: `${num(pure)} g`, total: `${num(items.reduce((a, b) => a + b.grams, 0))} g of items`, ounces: num(pure / TROY) },
        lists: { pieces: items.map((x) => ({ label: `${num(x.grams)} g at ${metal === 'gold' ? `${num(x.purity)}K` : num(x.purity)}`, value: money(((x.grams * fraction(x.purity)) / TROY) * i.spot, s) })) },
    };
}

export const handlers = {
    budget: (i, c) => {
        const s = symbolOf(c);
        const rows = parseRows(i.lines).map((cells, k) => ({ name: cells[0] || `Item ${k + 1}`, amount: Number(cells[1]) })).filter((r) => ok(r.amount));

        if (!ok(i.income) || i.income <= 0) {
            return { empty: 'Enter your monthly income.' };
        }

        const spent = rows.reduce((a, b) => a + b.amount, 0);
        const left = i.income - spent;

        return {
            value: money(left, s),
            label: left >= 0 ? 'Left over each month' : 'Over budget each month',
            sub: `${money(spent, s)} of ${money(i.income, s)} spent (${pct(spent / i.income)})`,
            rows: { spent: money(spent, s), yearly: money(left * 12, s), saving: pct(Math.max(0, left) / i.income), largest: rows.sort((a, b) => b.amount - a.amount)[0]?.name ?? '—' },
            lists: { lines: rows.map((r) => ({ label: r.name, value: `${money(r.amount, s)} (${pct(r.amount / i.income)})` })) },
        };
    },

    reconcile: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.bank, i.book)) {
            return { empty: 'Enter the bank statement balance and your book balance.' };
        }

        const adjustedBank = i.bank + or0(i.deposits) - or0(i.checks) + or0(i.bank_error);
        const adjustedBook = i.book + or0(i.interest) + or0(i.collections) - or0(i.fees) - or0(i.nsf) + or0(i.book_error);
        const diff = adjustedBank - adjustedBook;

        return {
            value: Math.abs(diff) < 0.005 ? 'Reconciled' : money(diff, s),
            label: Math.abs(diff) < 0.005 ? 'Balances agree' : 'Unexplained difference',
            sub: `adjusted bank ${money(adjustedBank, s)}, adjusted books ${money(adjustedBook, s)}`,
            rows: { bank: money(adjustedBank, s), book: money(adjustedBook, s), entries: `Record ${money(or0(i.interest) + or0(i.collections) - or0(i.fees) - or0(i.nsf), s)} of bank items in your books`, hint: Math.abs(diff) % 9 < 0.005 && Math.abs(diff) > 0.005 ? 'A difference divisible by 9 often means transposed digits' : 'Check each item on the statement' },
        };
    },

    car_depreciation: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.price, i.years) || i.price <= 0) {
            return { empty: 'Enter the price and years.' };
        }

        let value = i.price;
        const rows = [];

        for (let y = 1; y <= Math.round(i.years); y += 1) {
            value *= 1 - P(y === 1 ? or0(i.first) : or0(i.later));
            rows.push({ year: y, deposits: i.price - value, interest: 0, balance: value });
        }

        return {
            value: money(value, s),
            label: `Value after ${num(i.years)} years`,
            sub: `${pct(1 - value / i.price)} lost to depreciation`,
            rows: { lost: money(i.price - value, s), yearly: money((i.price - value) / i.years, s), first: money(i.price * P(or0(i.first)), s), per_mile: ok(i.miles) && i.miles > 0 ? money((i.price - value) / (i.miles * i.years), s) : 'Enter yearly miles' },
            grids: { schedule: yearGrid(rows, [['Lost so far', 'deposits'], ['Value', 'balance']], s) },
            plots: { chart: { series: [[0, i.price], ...rows.map((r) => [r.year, r.balance])], xLabel: 'Year', yLabel: s } },
        };
    },

    phone_plans: (i, c) => {
        const s = symbolOf(c);
        const plans = parseRows(i.plans).map((cells, k) => ({ name: cells[0] || `Plan ${k + 1}`, monthly: Number(cells[1]), device: Number(cells[2] || 0), upfront: Number(cells[3] || 0), lines: Number(cells[4] || 1) })).filter((p) => ok(p.monthly, p.device, p.upfront));
        const months = Math.round(or0(i.months) || 24);

        if (!plans.length) {
            return { empty: 'Add plans to compare.' };
        }

        const costs = plans.map((p) => ({ ...p, total: (p.monthly + p.device) * months + p.upfront }));
        const best = costs.reduce((a, b) => (b.total < a.total ? b : a));

        return {
            value: best.name,
            label: `Cheapest over ${months} months`,
            sub: `${money(best.total, s)} in total, ${money(best.total / months, s)} a month on average`,
            rows: { best: money(best.total, s), gap: money(Math.max(...costs.map((x) => x.total)) - best.total, s), per_line: money(best.total / months / Math.max(1, best.lines), s), count: num(costs.length) },
            lists: { plans: costs.map((p) => ({ label: p.name, value: `${money(p.total, s)} (${money(p.total / months, s)} a month)`, highlight: p === best })) },
        };
    },

    ltc: (i, c) => {
        const s = symbolOf(c);
        const t = c.data.ltc;
        const care = t.costs[i.care ?? 'assisted'];

        if (!care || !ok(i.years)) {
            return { empty: 'Choose a type of care and years.' };
        }

        const base = ok(i.cost) && i.cost > 0 ? i.cost * 12 : care[1] * (i.care === 'home_aide' || i.care === 'homemaker' ? (or0(i.hours) || 44) / 44 : 1);
        const growth = P(ok(i.inflation) ? i.inflation : 3);
        const start = or0(i.start);
        let total = 0;

        for (let y = 0; y < i.years; y += 1) {
            total += base * (1 + growth) ** (start + y);
        }

        return {
            value: money0(total, s),
            label: 'Total cost of care',
            sub: `${care[0]}: ${money0(base, s)} a year today (${t.source})`,
            rows: { first: money0(base * (1 + growth) ** start, s), monthly: money0((base * (1 + growth) ** start) / 12, s), average: money0(total / i.years, s), note: 'Medicare covers little long-term custodial care; Medicaid pays after assets are spent down' },
            lists: { types: Object.values(t.costs).map(([name, cost]) => ({ label: name, value: `${money0(cost, s)} a year` })) },
        };
    },

    lottery_annuity: (i, c) => lotteryOutcome(i, c, 'Lottery'),
    mega_millions: (i, c) => lotteryOutcome(i, c, 'Mega Millions'),
    powerball: (i, c) => lotteryOutcome(i, c, 'Powerball'),

    rent_split: (i, c) => {
        const s = symbolOf(c);
        const people = parseRows(i.people).map((cells, k) => ({ name: cells[0] || `Person ${k + 1}`, size: Number(cells[1]), income: Number(cells[2]) })).filter((p) => ok(p.size, p.income));

        if (!people.length || !ok(i.rent)) {
            return { empty: 'Enter the rent and the people sharing.' };
        }

        const method = i.method ?? 'size';
        const shared = P(ok(i.shared) ? i.shared : 30);
        const totalSize = people.reduce((a, b) => a + b.size, 0);
        const totalIncome = people.reduce((a, b) => a + b.income, 0);
        const share = (p) => (method === 'equal' ? 1 / people.length : method === 'income' ? p.income / totalIncome : shared / people.length + (1 - shared) * (p.size / totalSize));
        const lines = people.map((p) => ({ label: p.name, value: `${money(i.rent * share(p), s)} (${pct(share(p))})` }));

        return {
            value: money(i.rent * share(people[0]), s),
            label: `${people[0].name} pays`,
            sub: { equal: 'Equal shares', income: 'In proportion to income', size: `${pct(shared)} of the rent split equally for shared space, the rest by room size` }[method],
            rows: { equal: money(i.rent / people.length, s), total: money(i.rent, s), method: { equal: 'Equal', income: 'By income', size: 'By room size' }[method], people: num(people.length) },
            lists: { shares: lines },
        };
    },

    scrap_gold: (i, c) => scrapOutcome(i, c, 'gold'),
    scrap_silver: (i, c) => scrapOutcome(i, c, 'silver'),

    percentile: (i, c) => {
        const s = symbolOf(c);
        const t = c.data.income;

        if (!ok(i.income) || i.income < 0) {
            return { empty: 'Enter household income.' };
        }

        // Interpolate between the Census quintile limits (log-linear above the 20th percentile).
        const points = [[0, 0], ...t.limits];
        let percentile = 99;

        for (let k = 1; k < points.length; k += 1) {
            const [p0, v0] = points[k - 1];
            const [p1, v1] = points[k];

            if (i.income <= v1) {
                percentile = k === 1 ? p0 + ((p1 - p0) * i.income) / v1 : p0 + ((p1 - p0) * Math.log(i.income / v0)) / Math.log(v1 / v0);
                break;
            }
        }

        const top = i.income > t.limits[t.limits.length - 1][1];

        return {
            value: top ? 'Top 5%' : `${num(Math.floor(percentile))}th`,
            label: 'Household income percentile',
            sub: top ? `above ${money0(t.limits[t.limits.length - 1][1], s)}, the top 5% cutoff in ${t.year}` : `higher than about ${num(Math.floor(percentile))}% of US households in ${t.year}`,
            rows: { median: money0(t.median, s), ratio: `${num(i.income / t.median)}× the median`, quintile: top ? 'Top 5%' : `${['Lowest', 'Second', 'Middle', 'Fourth', 'Top'][Math.min(4, Math.floor(percentile / 20))]} fifth`, source: t.source },
            lists: { limits: t.limits.map(([p, v]) => ({ label: `${p}th percentile`, value: money0(v, s) })) },
        };
    },

    wedding: (i, c) => {
        const s = symbolOf(c);
        const t = c.data.wedding;

        if (!ok(i.budget) || i.budget <= 0) {
            return { empty: 'Enter your total budget.' };
        }

        const guests = Math.max(1, Math.round(or0(i.guests) || 100));

        return {
            value: money0(i.budget / guests, s),
            label: 'Budget per guest',
            sub: `${money0(i.budget, s)} for ${num(guests)} guests`,
            rows: { venue: money0(i.budget * t.split.venue_catering, s), contingency: money0(i.budget * 0.05, s), guests: num(guests), source: t.source },
            lists: { split: Object.entries(t.split).map(([k, share]) => ({ label: t.names[k], value: `${money0(i.budget * share, s)} (${pct(share)})` })) },
        };
    },

    money_counter: (i, c) => {
        const s = symbolOf(c);
        const rows = parseRows(i.counts).map((cells) => ({ value: Number(cells[0]), count: Number(cells[1]) })).filter((r) => ok(r.value, r.count) && r.count > 0);

        if (!rows.length) {
            return { empty: 'Enter how many of each note and coin you have.' };
        }

        const total = rows.reduce((a, r) => a + r.value * r.count, 0);

        return {
            value: money(total, s),
            label: 'Total',
            sub: `${num(rows.reduce((a, r) => a + r.count, 0))} notes and coins`,
            rows: { notes: money(rows.filter((r) => r.value >= 1).reduce((a, r) => a + r.value * r.count, 0), s), coins: money(rows.filter((r) => r.value < 1).reduce((a, r) => a + r.value * r.count, 0), s), pieces: num(rows.reduce((a, r) => a + r.count, 0)), largest: money(Math.max(...rows.map((r) => r.value)), s) },
            lists: { lines: rows.map((r) => ({ label: `${num(r.count)} × ${money(r.value, s)}`, value: money(r.value * r.count, s) })) },
        };
    },

    va_disability: (i, c) => {
        const t = c.data.vadisability;
        const ratings = String(i.ratings ?? '').split(/[\s,;]+/).map(Number).filter((x) => x > 0 && x <= 100).sort((a, b) => b - a);

        if (!ratings.length) {
            return { empty: 'Enter each disability rating in percent.' };
        }

        // VA math (38 CFR 4.25): apply each rating to the remaining "whole person", then round to the nearest 10.
        let remaining = 100;
        ratings.forEach((r) => {
            remaining -= (remaining * r) / 100;
        });
        const exact = 100 - remaining;
        const combined = Math.min(100, Math.round(exact / 10) * 10);
        const pay = combined >= 10 ? t.alone[String(combined)] : 0;

        return {
            value: `${combined}%`,
            label: 'Combined VA rating',
            sub: `${num(exact)}% before rounding to the nearest 10`,
            rows: { pay: combined >= 10 ? `${money(pay, 'USD')} a month (veteran alone, ${t.year})` : 'No compensation below 10%', year: money(pay * 12, '$'), exact: `${num(exact)}%`, note: combined >= 30 ? 'Dependents add to the monthly rate at 30% and above (VA rate tables)' : 'Ratings of 10% and 20% are not increased for dependents' },
        };
    },

    workplace_costs: (i, c) => {
        const s = symbolOf(c);
        const office = or0(i.rent) * or0(i.space) + or0(i.utilities) + or0(i.office_equipment) / 3;
        const remote = or0(i.stipend) * 12 + or0(i.remote_equipment) / 3 + or0(i.coworking) * 12;

        if (!(office > 0 || remote > 0)) {
            return { empty: 'Enter the costs for each arrangement.' };
        }

        const people = Math.max(1, Math.round(or0(i.people) || 1));

        return {
            value: money0(office - remote, s),
            label: office >= remote ? 'Remote saves per worker a year' : 'On-site saves per worker a year',
            sub: `on-site ${money0(office, s)} vs remote ${money0(remote, s)} per worker`,
            rows: { office: money0(office, s), remote: money0(remote, s), team: money0((office - remote) * people, s), note: 'Equipment is spread over 3 years; productivity and salary differences are not included' },
        };
    },

    hr_roi: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.employees, i.hours, i.cost, i.price)) {
            return { empty: 'Enter employees, hours saved, hourly cost and price.' };
        }

        const benefit = i.employees * i.hours * 12 * i.cost + or0(i.other);
        const costs = i.employees * i.price * 12 + or0(i.setup);
        const roi = (benefit - costs) / costs;

        return {
            value: `${num(roi * 100)}%`,
            label: 'First-year ROI',
            sub: `${money0(benefit, s)} of time saved against ${money0(costs, s)} of cost`,
            rows: { benefit: money0(benefit, s), cost: money0(costs, s), payback: benefit > 0 ? `${num((costs / benefit) * 12)} months` : 'Never', hours: `${num(i.employees * i.hours * 12)} hours saved a year` },
        };
    },

    ces: (i) => {
        const counts = String(i.counts ?? '').split(/[\s,;]+/).map(Number).filter(Number.isFinite);
        const scale = Number(i.scale ?? 7);

        if (counts.length !== scale || counts.every((x) => x === 0)) {
            return { empty: `Enter ${scale} counts: how many answered 1, 2, … ${scale}.` };
        }

        const total = counts.reduce((a, b) => a + b, 0);
        const average = counts.reduce((a, n, k) => a + n * (k + 1), 0) / total;
        const easyFrom = scale === 7 ? 5 : 4;
        const easy = counts.slice(easyFrom - 1).reduce((a, b) => a + b, 0) / total;
        const hard = counts.slice(0, scale === 7 ? 3 : 2).reduce((a, b) => a + b, 0) / total;

        return {
            value: num(average),
            label: 'Customer Effort Score',
            sub: `average on a 1–${scale} scale from ${num(total)} responses`,
            rows: { easy: `${pct(easy)} found it easy (${easyFrom}–${scale})`, hard: pct(hard), net: pct(easy - hard), responses: num(total) },
        };
    },
};

export default defineTools(handlers);
