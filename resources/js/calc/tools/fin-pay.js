import { getCurrency } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { money, num, numberList, pct } from '../finance/common.js';

/**
 * Pay: converting between hourly, daily, weekly, biweekly, semi-monthly, monthly and yearly pay; overtime under the
 * federal FLSA (1.5× over 40 hours a week) or California daily rules; raises, prorating and billing rates.
 */
const P = (value) => value / 100;
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
// Fixed-currency pages pass `sym` (a currency code); otherwise the page's display currency applies.
const symbolOf = (c) => c.sym ?? getCurrency();

/**
 * Yearly pay from an amount per period, with the hours and days that define a working year.
 */
function yearly(amount, period, hours, days, weeks) {
    const perYear = { hour: hours * weeks, day: days * weeks, week: weeks, biweek: weeks / 2, semimonth: 24, month: 12, quarter: 4, year: 1 }[period];

    return amount * perYear;
}

function payTable(i, c) {
    const s = symbolOf(c);
    const hours = ok(i.hours) && i.hours > 0 ? i.hours : 40;
    const days = ok(i.days) && i.days > 0 ? i.days : 5;
    const weeks = ok(i.weeks) && i.weeks > 0 ? i.weeks : 52;
    const period = i.period ?? c.period ?? 'year';

    if (!ok(i.amount) || i.amount < 0) {
        return { empty: 'Enter your pay.' };
    }

    const year = yearly(i.amount, period, hours, days, weeks);
    const target = i.target ?? c.target ?? 'hour';
    const values = { hour: year / (hours * weeks), day: year / (days * weeks), week: year / weeks, biweek: year / (weeks / 2), semimonth: year / 24, month: year / 12, quarter: year / 4, year };
    const labels = { hour: 'Hourly', day: 'Daily', week: 'Weekly', biweek: 'Biweekly', semimonth: 'Semi-monthly', month: 'Monthly', quarter: 'Quarterly', year: 'Yearly' };

    return {
        value: money(values[target], s),
        label: `${labels[target]} pay`,
        sub: `from ${money(i.amount, s)} ${labels[period].toLowerCase()}, ${num(hours)} hours a week, ${num(weeks)} weeks a year`,
        rows: Object.fromEntries(Object.entries(values).map(([k, v]) => [k, money(v, s)])),
    };
}

/**
 * Overtime for one week: FLSA (1.5× over 40 hours) or California (1.5× over 8 hours a day and 40 a week, 2× over 12 a day,
 * and on the seventh consecutive day 1.5× for the first 8 hours and 2× after).
 */
export function overtimeWeek(dailyHours, rules = 'federal', weeklyLimit = 40) {
    let regular = 0;
    let ot = 0;
    let dt = 0;

    if (rules === 'california') {
        dailyHours.forEach((h, k) => {
            if (k === 6 && dailyHours.slice(0, 6).every((x) => x > 0)) {
                ot += Math.min(h, 8);
                dt += Math.max(0, h - 8);

                return;
            }

            regular += Math.min(h, 8);
            ot += Math.max(0, Math.min(h, 12) - 8);
            dt += Math.max(0, h - 12);
        });

        // Weekly overtime: regular hours beyond 40 become overtime.
        if (regular > weeklyLimit) {
            ot += regular - weeklyLimit;
            regular = weeklyLimit;
        }
    } else {
        const total = dailyHours.reduce((a, b) => a + b, 0);
        regular = Math.min(total, weeklyLimit);
        ot = Math.max(0, total - weeklyLimit);
    }

    return { regular, ot, dt };
}

function overtimeTool(i, c) {
    const s = symbolOf(c);
    const rules = i.rules ?? c.rules ?? 'federal';

    if (!ok(i.rate) || i.rate <= 0) {
        return { empty: 'Enter the hourly rate.' };
    }

    let hours;

    if (i.mode === 'days' || rules === 'california') {
        const days = numberList(i.daily).slice(0, 7);

        if (!days.length) {
            return { empty: 'Enter the hours worked each day.' };
        }

        hours = overtimeWeek(days, rules);
    } else {
        if (!ok(i.worked)) {
            return { empty: 'Enter the hours worked in the week.' };
        }

        hours = overtimeWeek([i.worked], 'federal');
    }

    const multiplier = ok(i.multiplier) && i.multiplier > 0 ? i.multiplier : 1.5;
    const regularPay = hours.regular * i.rate;
    const otPay = hours.ot * i.rate * multiplier;
    const dtPay = hours.dt * i.rate * 2;
    const spread = c.spread && ok(i.span, i.min_wage) && i.span > 10 ? i.min_wage : 0;
    const total = regularPay + otPay + dtPay + spread;

    return {
        value: money(total, s),
        label: 'Gross pay for the week',
        sub: `${num(hours.regular)} regular + ${num(hours.ot)} overtime${hours.dt ? ` + ${num(hours.dt)} double-time` : ''} hours`,
        rows: {
            regular: money(regularPay, s),
            overtime: `${money(otPay, s)} at ${money(i.rate * multiplier, s)} an hour`,
            double: hours.dt ? `${money(dtPay, s)} at ${money(i.rate * 2, s)} an hour` : 'None',
            average: money(total / Math.max(1e-9, hours.regular + hours.ot + hours.dt), s),
            rules: rules === 'california' ? 'California: daily overtime over 8 hours, double time over 12, seventh-day rules' : `Federal FLSA: ${num(multiplier)}× over 40 hours a week${c.spread ? '; New York adds one hour at minimum wage when the workday spans over 10 hours' : ''}`,
            ...(c.spread ? { spread: spread ? `${money(spread, s)} spread-of-hours pay` : 'No spread-of-hours pay (span of 10 hours or less)' } : {}),
        },
    };
}

export const handlers = {
    pay: payTable,
    overtime: overtimeTool,

    hourly_ot_salary: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.rate, i.hours) || i.rate <= 0) {
            return { empty: 'Enter the rate and regular hours.' };
        }

        const weeks = ok(i.weeks) ? i.weeks : 52;
        const ot = or0(i.ot_hours);
        const weekly = Math.min(i.hours, 40) * i.rate + (Math.max(0, i.hours - 40) + ot) * i.rate * 1.5;
        const yearly = weekly * weeks;

        return {
            value: money(yearly, s),
            label: 'Yearly pay with overtime',
            sub: `${money(weekly, s)} a week for ${num(weeks)} weeks`,
            rows: { base: money(Math.min(i.hours, 40) * i.rate * weeks, s), overtime: money((Math.max(0, i.hours - 40) + ot) * i.rate * 1.5 * weeks, s), monthly: money(yearly / 12, s), effective: `${money(weekly / (i.hours + ot), s)} an hour on average` },
        };
    },

    time_and_half: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.rate) || i.rate <= 0) {
            return { empty: 'Enter the hourly rate.' };
        }

        const hours = or0(i.hours);

        return {
            value: money(i.rate * 1.5, s),
            label: 'Time-and-a-half rate',
            sub: `${money(i.rate, s)} × 1.5`,
            rows: { pay: money(i.rate * 1.5 * hours, s), double: money(i.rate * 2, s), extra: money(i.rate * 0.5 * hours, s), daily: money(i.rate * 1.5 * 8, s) },
        };
    },

    shift12: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.rate, i.shifts) || i.rate <= 0) {
            return { empty: 'Enter the rate and shifts a week.' };
        }

        const length = ok(i.length) && i.length > 0 ? i.length : 12;
        const days = Array.from({ length: Math.min(7, Math.round(i.shifts)) }, () => length);
        const hours = overtimeWeek(days, i.rules ?? 'federal');
        const night = P(or0(i.night));
        const nightHours = Math.min(or0(i.night_hours), length) * days.length;
        const pay = hours.regular * i.rate + hours.ot * i.rate * 1.5 + hours.dt * i.rate * 2 + nightHours * i.rate * night;

        return {
            value: money(pay, s),
            label: 'Weekly pay',
            sub: `${num(days.length)} shifts of ${num(length)} hours (${num(days.length * length)} hours)`,
            rows: { regular: `${num(hours.regular)} hours`, overtime: `${num(hours.ot)} hours at 1.5×${hours.dt ? `, ${num(hours.dt)} at 2×` : ''}`, night: money(nightHours * i.rate * night, s), yearly: money(pay * 52, s) },
        };
    },

    billable: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.billable, i.total) || i.total <= 0) {
            return { empty: 'Enter billable and total hours.' };
        }

        const utilization = i.billable / i.total;

        return {
            value: num(utilization * 100),
            unit: '%',
            label: 'Billable utilization',
            sub: `${num(i.billable)} of ${num(i.total)} hours`,
            rows: { revenue: ok(i.rate) ? money(i.billable * i.rate, s) : 'Enter a billing rate', target: ok(i.target) ? `${num(i.total * P(i.target) - i.billable)} more hours to reach ${num(i.target)}%` : 'Enter a target', yearly: ok(i.rate) ? money(i.billable * i.rate * 52, s) : '—', effective: ok(i.rate) ? `${money((i.billable * i.rate) / i.total, s)} per hour worked` : '—' },
        };
    },

    bill_rate: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.pay) || i.pay <= 0) {
            return { empty: 'Enter the pay rate.' };
        }

        const burden = P(or0(i.burden));
        const cost = i.pay * (1 + burden);
        const margin = P(or0(i.margin));

        if (margin >= 1) {
            return { error: 'The margin must be below 100%.' };
        }

        const bill = cost / (1 - margin);

        return {
            value: money(bill, s),
            label: 'Bill rate',
            sub: `pay ${money(i.pay, s)} + ${pct(burden)} burden, ${pct(margin)} gross margin`,
            rows: { cost: money(cost, s), profit: money(bill - cost, s), markup: pct(bill / i.pay - 1), weekly: money(bill * 40, s) },
        };
    },

    future_salary: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.salary, i.raise_pct, i.years)) {
            return { empty: 'Enter salary, yearly raise and years.' };
        }

        const future = i.salary * (1 + P(i.raise_pct)) ** i.years;
        const inflation = P(or0(i.inflation));

        return {
            value: money(future, s),
            label: `Salary in ${num(i.years)} years`,
            sub: `${pct(P(i.raise_pct))} a year`,
            rows: { increase: money(future - i.salary, s), real: inflation ? `${money(future / (1 + inflation) ** i.years, s)} in today's money` : 'Enter inflation for today\'s money', total: money(Array.from({ length: Math.ceil(i.years) }, (_, k) => i.salary * (1 + P(i.raise_pct)) ** k).reduce((a, b) => a + b, 0), s), monthly: money(future / 12, s) },
        };
    },

    raise: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.current) || i.current <= 0) {
            return { empty: 'Enter your current pay.' };
        }

        const next = i.mode === 'amount' ? i.current + or0(i.change) : i.mode === 'new' ? or0(i.new_pay) : i.current * (1 + P(or0(i.change)));
        const change = next - i.current;

        return {
            value: i.mode === 'new' ? `${num((change / i.current) * 100)}%` : money(next, s),
            label: i.mode === 'new' ? 'Raise' : 'New pay',
            sub: `${money(change, s)} more (${pct(change / i.current)})`,
            rows: { new: money(next, s), percent: pct(change / i.current), monthly: money(change / 12, s), real: ok(i.inflation) ? `${pct((1 + change / i.current) / (1 + P(i.inflation)) - 1)} after ${num(i.inflation)}% inflation` : 'Enter inflation for the real raise' },
        };
    },

    prorate: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.salary, i.worked, i.total) || i.total <= 0) {
            return { empty: 'Enter salary, days worked and days in the period.' };
        }

        const periodPay = i.salary / (i.periods_year ?? 12);
        const pay = periodPay * (i.worked / i.total);

        return {
            value: money(pay, s),
            label: 'Prorated pay',
            sub: `${num(i.worked)} of ${num(i.total)} days of a ${money(periodPay, s)} period`,
            rows: { period: money(periodPay, s), daily: money(periodPay / i.total, s), share: pct(i.worked / i.total), yearly: money(i.salary, s) },
        };
    },

    tip: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.bill, i.tip) || i.bill < 0) {
            return { empty: 'Enter the bill and tip percentage.' };
        }

        const people = Math.max(1, Math.round(or0(i.people) || 1));
        const base = i.on === 'pretax' && ok(i.tax) ? i.bill / (1 + P(i.tax)) : i.bill;
        const tip = base * P(i.tip);
        let total = i.bill + tip;

        if (i.round === 'up') {
            total = Math.ceil(total);
        }

        const each = total / people;

        return {
            value: money(total - i.bill, s),
            label: 'Tip',
            sub: `${money(total, s)} in total${people > 1 ? `, ${money(each, s)} each` : ''}`,
            rows: { total: money(total, s), each: money(each, s), tip_each: money((total - i.bill) / people, s), rate: pct((total - i.bill) / base) },
            lists: { guide: [15, 18, 20, 22, 25].map((rate) => ({ label: `${rate}%`, value: `${money(base * P(rate), s)} tip, ${money(i.bill + base * P(rate), s)} total`, highlight: rate === i.tip })) },
        };
    },

    leave_sale: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.salary, i.days, i.working) || i.working <= 0) {
            return { empty: 'Enter salary, leave days and working days.' };
        }

        const daily = i.salary / i.working;
        const gross = daily * i.days;

        return {
            value: money(gross, s),
            label: 'Payout for the leave days',
            sub: `${money(daily, s)} a day × ${num(i.days)} days`,
            rows: { daily: money(daily, s), tax: ok(i.tax) ? money(gross * (1 - P(i.tax)), s) : 'Enter a tax rate', hourly: money(daily / 8, s), basis: `${num(i.working)} working days a year` },
        };
    },
};

export default defineTools(handlers);
