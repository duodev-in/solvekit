import { getCurrency } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { money, money0, num, numberList, pct, yearGrid } from '../finance/common.js';
import { effectiveAnnual, fv, growth, irrs, mirr, npv, nper, periodRate, pmt, pv, rate } from '../finance/tvm.js';
import { parseRows } from '../rows-editor.js';

/**
 * Investing, saving and retirement: compound growth, time value of money, cash-flow analysis,
 * risk measures, annuities and US retirement accounts (2026 IRS limits from config/finance_data.php).
 * Percent fields arrive as entered (7 = 7%) and are divided by 100 here.
 */
const P = (value) => value / 100;
const ok = (...values) => values.every(Number.isFinite);
// Fixed-currency pages pass `sym` (a currency code); otherwise the page's display currency applies.
const symbolOf = (c) => c.sym ?? getCurrency();
const compoundOf = (value) => (value === 'inf' ? Infinity : Number(value || 12));
const flowsOf = (text) => numberList(text);

const growthPlot = (rows, symbol, start = 0) => ({
    series: [[0, start], ...rows.map((row) => [row.year, row.balance])],
    series2: [[0, start], ...rows.map((row) => [row.year, row.deposits])],
    legend: ['Balance', 'Deposits'],
    xLabel: 'Year',
    yLabel: symbol,
});

/**
 * Savings growth with any compounding, regular deposits (made at the end or start of each period),
 * a yearly increase in deposits, an annual fee taken from the return and optional inflation.
 */
function growthTool(i, c) {
    const s = symbolOf(c);
    const years = i.years;
    const start = i.start ?? 0;
    const contribution = i.contribution ?? 0;

    if (!ok(start, years, i.rate) || years <= 0 || (!ok(contribution) && i.contribution !== undefined)) {
        return { empty: 'Enter the starting amount, rate and years.' };
    }

    const fee = ok(i.fee) ? P(i.fee) : 0;
    const result = growth({
        start,
        contribution: ok(contribution) ? contribution : 0,
        perYear: Number(i.per ?? c.per ?? 12),
        annual: P(i.rate) - fee,
        compound: compoundOf(i.compound),
        years,
        timing: i.timing ?? 'end',
        increase: ok(i.increase) ? P(i.increase) : 0,
    });
    const inflation = ok(i.inflation) ? P(i.inflation) : 0;
    const real = result.balance / (1 + inflation) ** years;

    return {
        value: money(result.balance, s),
        label: 'Future balance',
        sub: `after ${num(years)} years: ${money(result.deposits, s)} deposited, ${money(result.interest, s)} earned`,
        rows: {
            deposits: money(result.deposits, s),
            interest: money(result.interest, s),
            effective: pct(effectiveAnnual(P(i.rate) - fee, compoundOf(i.compound))),
            real: inflation ? `${money(real, s)} in today's money (${pct(inflation)} inflation)` : 'Enter inflation for today\'s money',
            share: result.balance > 0 ? `${pct(result.interest / result.balance)} of the balance is growth` : '—',
        },
        grids: { schedule: yearGrid(result.rows, [['Deposits', 'deposits'], ['Interest', 'interest'], ['Balance', 'balance']], s) },
        plots: { chart: growthPlot(result.rows, s, start) },
    };
}

/**
 * Applies the 2026 elective deferral limit with the age-50 catch-up and the age 60–63 higher catch-up (SECURE 2.0).
 */
const deferralLimit = (age, limits) => limits.deferral + (age >= 60 && age <= 63 ? limits.catchup_60_63 : age >= 50 ? limits.catchup_50 : 0);

/**
 * Year-by-year workplace plan (401(k) or 403(b)): employee deferral capped at the limit, employer match,
 * salary growth and returns until retirement. Limits stay at their 2026 values (they rise with inflation in practice).
 */
function workplacePlan(i, c) {
    const s = symbolOf(c);
    const limits = c.data.limits;

    if (!ok(i.salary, i.percent, i.age, i.retire, i.rate) || i.retire <= i.age) {
        return { empty: 'Enter salary, contribution, ages and return.' };
    }

    let balance = ok(i.balance) ? i.balance : 0;
    let salary = i.salary;
    let employee = 0;
    let employer = 0;
    let capped = false;
    const rows = [];
    const r = P(i.rate);

    for (let age = i.age; age < i.retire; age += 1) {
        const limit = deferralLimit(age, limits);
        let deferral = salary * P(i.percent);

        if (deferral > limit) {
            deferral = limit;
            capped = true;
        }

        const match = ok(i.match, i.matchLimit) ? Math.min(deferral, salary * P(i.matchLimit)) * P(i.match) : 0;
        // Contributions arrive through the year: half a year's growth on them on average.
        balance = balance * (1 + r) + (deferral + match) * (1 + r) ** 0.5;
        employee += deferral;
        employer += match;
        rows.push({ year: age + 1, deposits: employee + employer, interest: balance - employee - employer - (ok(i.balance) ? i.balance : 0), balance });
        salary *= 1 + (ok(i.raises) ? P(i.raises) : 0);
    }

    const firstLimit = deferralLimit(i.age, limits);

    return {
        value: money(balance, s),
        label: `Balance at ${num(i.retire)}`,
        sub: `${money(employee, s)} from you, ${money(employer, s)} from your employer`,
        rows: {
            employee: money(employee, s),
            employer: money(employer, s),
            growth: money(balance - employee - employer - (ok(i.balance) ? i.balance : 0), s),
            limit: `${money(firstLimit, s)} this year at age ${num(i.age)} (${limits.year} limit${i.age >= 50 ? ' with catch-up' : ''})${capped ? '; your percentage hits the limit' : ''}`,
            income: `${money((balance * 0.04) / 12, s)} a month at a 4% withdrawal rate`,
        },
        grids: { schedule: yearGrid(rows.map((row) => ({ ...row, year: row.year })), [['Contributions', 'deposits'], ['Growth', 'interest'], ['Balance', 'balance']], s) },
        plots: { chart: { ...growthPlot(rows, s, ok(i.balance) ? i.balance : 0), series: [[i.age, ok(i.balance) ? i.balance : 0], ...rows.map((row) => [row.year, row.balance])], series2: [[i.age, 0], ...rows.map((row) => [row.year, row.deposits])], xLabel: 'Age' } },
    };
}

/**
 * Roth IRA contribution allowed by modified AGI (IRS Pub 590-A worksheet: reduced proportionally across
 * the phase-out range, rounded up to $10, at least $200 if not zero).
 */
export function rothAllowed(limit, magi, range) {
    const [low, high] = range;

    if (magi <= low) {
        return limit;
    }

    if (magi >= high) {
        return 0;
    }

    const reduced = limit - (limit * (magi - low)) / (high - low);
    const rounded = Math.ceil(reduced / 10) * 10;

    return Math.max(200, Math.min(limit, rounded));
}

function iraTool(i, c, roth) {
    const s = symbolOf(c);
    const limits = c.data.limits;

    if (!ok(i.contribution, i.age, i.retire, i.rate) || i.retire <= i.age) {
        return { empty: 'Enter the contribution, ages and return.' };
    }

    let allowed = limits.ira + (i.age >= 50 ? limits.ira_catchup : 0);
    let note = `${money(allowed, s)} (${limits.year} limit${i.age >= 50 ? ' with the $1,100 catch-up' : ''})`;

    if (roth && ok(i.magi)) {
        const status = i.status ?? 'single';
        allowed = rothAllowed(allowed, i.magi, limits.roth_phaseout[status]);
        note = `${money(allowed, s)} at a MAGI of ${money0(i.magi, s)} (phase-out ${money0(limits.roth_phaseout[status][0], s)}–${money0(limits.roth_phaseout[status][1], s)})`;
    }

    const yearly = Math.min(i.contribution, allowed);
    const n = i.retire - i.age;
    const result = growth({ start: ok(i.balance) ? i.balance : 0, contribution: yearly, perYear: 1, annual: P(i.rate), compound: 1, years: n, timing: 'start' });
    const tax = ok(i.tax) ? P(i.tax) : 0;
    const rows = result.rows.map((row) => ({ ...row, year: i.age + row.year }));

    return {
        value: money(result.balance, s),
        label: `Balance at ${num(i.retire)}`,
        sub: roth ? 'Qualified withdrawals are tax-free' : `Taxed as income when withdrawn: about ${money(result.balance * (1 - tax), s)} after ${pct(tax)} tax`,
        rows: {
            allowed: note,
            contributed: `${money(yearly, s)} a year, ${money(result.deposits, s)} in total`,
            growth: money(result.interest, s),
            after: roth ? `${money(result.balance, s)} (no tax on qualified withdrawals)` : money(result.balance * (1 - tax), s),
            saved: roth ? `Compared with a taxable account at ${pct(tax)}, about ${money(result.interest * tax, s)} of tax avoided on growth` : `Deduction now: about ${money(yearly * tax, s)} a year if deductible`,
        },
        grids: { schedule: yearGrid(rows, [['Contributions', 'deposits'], ['Growth', 'interest'], ['Balance', 'balance']], s) },
        plots: { chart: { series: rows.map((row) => [row.year, row.balance]), series2: rows.map((row) => [row.year, row.deposits]), legend: ['Balance', 'Contributions'], xLabel: 'Age', yLabel: s } },
    };
}

/**
 * Draws a balance down by a monthly withdrawal that rises yearly; returns months until empty (capped at 100 years).
 */
function drawdown(balance, withdrawal, annual, increase = 0, maxMonths = 1200) {
    const r = (1 + annual) ** (1 / 12) - 1;
    let b = balance;
    let w = withdrawal;
    let months = 0;
    let paid = 0;
    const path = [[0, b]];

    while (b > 0 && months < maxMonths) {
        b = b * (1 + r) - w;
        paid += b < 0 ? w + b : w;
        months += 1;

        if (months % 12 === 0) {
            w *= 1 + increase;
            path.push([months / 12, Math.max(0, b)]);
        }
    }

    if (months % 12 !== 0) {
        path.push([months / 12, Math.max(0, b)]);
    }

    return { months, paid, path, lasts: months >= maxMonths, end: Math.max(0, b) };
}

const durationText = (months) => {
    const y = Math.floor(months / 12);
    const m = months % 12;

    return `${y} year${y === 1 ? '' : 's'}${m ? ` ${m} month${m === 1 ? '' : 's'}` : ''}`;
};

/**
 * Full retirement age for a birth year (Social Security Act §216(l)): 66 for 1943–54, rising two months a year to 67 from 1960.
 */
export const fullRetirementMonths = (born) => (born <= 1954 ? 66 * 12 : born >= 1960 ? 67 * 12 : 66 * 12 + 2 * (born - 1954));

/**
 * Benefit as a share of the PIA when claiming at an age in months: 5/9 of 1% a month for the first 36 months early,
 * 5/12 of 1% beyond; 2/3 of 1% a month delayed credit after FRA to 70.
 */
export function claimFactor(claimMonths, fraMonths) {
    const early = fraMonths - claimMonths;

    if (early > 0) {
        return 1 - (Math.min(early, 36) * 5) / 900 - (Math.max(0, early - 36) * 5) / 1200;
    }

    return 1 + (Math.min(-early, 70 * 12 - fraMonths) * 2) / 300;
}

const ageText = (months) => `${Math.floor(months / 12)}${months % 12 ? ` and ${months % 12} months` : ''}`;

export const handlers = {
    growth: growthTool,

    cd: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.deposit, i.rate, i.term) || i.term <= 0) {
            return { empty: 'Enter the deposit, rate and term.' };
        }

        const n = compoundOf(i.compound);
        const years = i.term / 12;
        // A quoted APY already includes compounding; an APR compounds n times a year.
        const apy = i.rate_type === 'apr' ? effectiveAnnual(P(i.rate), n) : P(i.rate);
        const value = i.deposit * (1 + apy) ** years;
        const penalty = ok(i.penalty) && i.penalty > 0 ? i.deposit * ((1 + apy) ** (i.penalty / 12) - 1) : NaN;

        return {
            value: money(value, s),
            label: 'Value at maturity',
            sub: `${money(value - i.deposit, s)} interest over ${num(i.term)} months`,
            rows: {
                interest: money(value - i.deposit, s),
                apy: pct(apy),
                monthly: money((value - i.deposit) / i.term, s),
                penalty: Number.isFinite(penalty) ? `${money(penalty, s)} (${num(i.penalty)} months of interest)` : 'Enter the penalty in months of interest',
            },
        };
    },

    compound_rate: (i, c) => {
        if (!ok(i.start, i.end, i.years) || i.start <= 0 || i.end <= 0 || i.years <= 0) {
            return { empty: 'Enter the starting amount, ending amount and years.' };
        }

        const n = compoundOf(i.compound);
        const growthFactor = i.end / i.start;
        const nominal = n === Infinity ? Math.log(growthFactor) / i.years : n * (growthFactor ** (1 / (n * i.years)) - 1);

        return {
            value: num(nominal * 100),
            unit: '%',
            label: 'Annual interest rate',
            sub: `compounded ${n === Infinity ? 'continuously' : `${num(n)} times a year`}`,
            rows: {
                effective: pct(growthFactor ** (1 / i.years) - 1),
                total: pct(growthFactor - 1),
                multiple: `${num(growthFactor)}×`,
                doubling: growthFactor > 1 ? `${num(Math.log(2) / Math.log(growthFactor ** (1 / i.years)))} years to double at this rate` : '—',
            },
        };
    },

    future_value: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.present, i.rate, i.years)) {
            return { empty: 'Enter the present value, rate and years.' };
        }

        const per = Number(i.per ?? 12);
        const r = periodRate(P(i.rate), compoundOf(i.compound), per);
        const n = i.years * per;
        const payment = ok(i.payment) ? i.payment : 0;
        const type = i.timing === 'start' ? 1 : 0;
        const lump = -fv(r, n, 0, i.present, 0);
        const stream = -fv(r, n, payment, 0, type);

        return {
            value: money(lump + stream, s),
            label: 'Future value',
            sub: `${money(i.present + payment * n, s)} paid in over ${num(i.years)} years`,
            rows: { lump: money(lump, s), stream: money(stream, s), interest: money(lump + stream - i.present - payment * n, s), factor: `${num((1 + r) ** n)} (growth of 1 over the period)` },
        };
    },

    present_value: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.future, i.rate, i.years)) {
            return { empty: 'Enter the future value, rate and years.' };
        }

        const per = Number(i.per ?? 12);
        const r = periodRate(P(i.rate), compoundOf(i.compound), per);
        const n = i.years * per;
        const payment = ok(i.payment) ? i.payment : 0;
        const type = i.timing === 'start' ? 1 : 0;
        const lump = -pv(r, n, 0, i.future, 0);
        const stream = -pv(r, n, payment, 0, type);

        return {
            value: money(lump + stream, s),
            label: 'Present value',
            sub: `of ${money(i.future, s)}${payment ? ` and ${money(payment, s)} each period` : ''} at ${pct(P(i.rate))}`,
            rows: { lump: money(lump, s), stream: money(stream, s), discount: money(i.future + payment * n - lump - stream, s), factor: num((1 + r) ** -n) },
        };
    },

    tvm: (i, c) => {
        const s = symbolOf(c);
        const per = Number(i.per ?? 12);
        const type = i.timing === 'start' ? 1 : 0;
        const r = P(i.rate) / per;
        const solveFor = i.solve ?? 'fv';
        const need = { pv: ['n', 'rate', 'pmt', 'fv'], fv: ['n', 'rate', 'pmt', 'pv'], pmt: ['n', 'rate', 'pv', 'fv'], n: ['rate', 'pmt', 'pv', 'fv'], rate: ['n', 'pmt', 'pv', 'fv'] }[solveFor];

        if (need.some((name) => !ok(i[name]))) {
            return { empty: 'Enter the other four values.' };
        }

        let answer;
        let text;

        if (solveFor === 'fv') {
            answer = fv(r, i.n, i.pmt, i.pv, type);
            text = money(answer, s);
        } else if (solveFor === 'pv') {
            answer = pv(r, i.n, i.pmt, i.fv, type);
            text = money(answer, s);
        } else if (solveFor === 'pmt') {
            answer = pmt(r, i.n, i.pv, i.fv, type);
            text = money(answer, s);
        } else if (solveFor === 'n') {
            answer = nper(r, i.pmt, i.pv, i.fv, type);
            text = num(answer);
        } else {
            const periodic = rate(i.n, i.pmt, i.pv, i.fv, type);
            answer = periodic === null ? NaN : periodic * per;
            text = `${num(answer * 100)}%`;
        }

        if (!Number.isFinite(answer)) {
            return { error: 'No solution: check the signs (money paid out is negative, money received positive).' };
        }

        const labels = { fv: 'Future value (FV)', pv: 'Present value (PV)', pmt: 'Payment (PMT)', n: 'Number of periods (N)', rate: 'Annual rate (I/Y)' };
        const values = { n: solveFor === 'n' ? answer : i.n, r: solveFor === 'rate' ? answer / per : r, pmt: solveFor === 'pmt' ? answer : i.pmt, pv: solveFor === 'pv' ? answer : i.pv, fv: solveFor === 'fv' ? answer : i.fv };

        return {
            value: text,
            label: labels[solveFor],
            sub: 'Cash paid out is negative, cash received is positive',
            rows: {
                periods: `${num(values.n)} periods (${num(values.n / per)} years)`,
                periodic: `${pct(values.r)} a period`,
                effective: pct((1 + values.r) ** per - 1),
                total: `${money(values.pmt * values.n, s)} in payments`,
            },
        };
    },

    interest_rate: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.amount, i.payment, i.months) || i.amount <= 0 || i.payment <= 0 || i.months <= 0) {
            return { empty: 'Enter the amount, payment and number of months.' };
        }

        if (i.payment * i.months <= i.amount) {
            return { error: 'The payments do not repay the amount, so the rate would be zero or negative.' };
        }

        const monthly = rate(i.months, -i.payment, i.amount, 0, 0);

        if (monthly === null) {
            return { error: 'No rate between −99% and 1,000% matches these figures.' };
        }

        return {
            value: num(monthly * 1200),
            unit: '%',
            label: 'Annual interest rate (APR)',
            sub: `${money(i.payment, s)} a month for ${num(i.months)} months on ${money(i.amount, s)}`,
            rows: { monthly: pct(monthly), effective: pct((1 + monthly) ** 12 - 1), interest: money(i.payment * i.months - i.amount, s), total: money(i.payment * i.months, s) },
        };
    },

    discount_rate: (i, c) => {
        const s = symbolOf(c);

        if (i.mode === 'factor') {
            if (!ok(i.rate, i.years)) {
                return { empty: 'Enter the rate and years.' };
            }

            const factor = (1 + P(i.rate)) ** -i.years;

            return {
                value: num(factor),
                label: 'Discount factor',
                sub: `1 ÷ (1 + ${pct(P(i.rate))})^${num(i.years)}`,
                rows: { rate: pct(P(i.rate)), pv: ok(i.future) ? money(i.future * factor, s) : '—', continuous: num(Math.exp(-P(i.rate) * i.years)), years: num(i.years) },
            };
        }

        if (!ok(i.present, i.future, i.years) || i.present <= 0 || i.future <= 0 || i.years <= 0) {
            return { empty: 'Enter the present value, future value and years.' };
        }

        const r = (i.future / i.present) ** (1 / i.years) - 1;

        return {
            value: num(r * 100),
            unit: '%',
            label: 'Discount rate',
            sub: `turns ${money(i.present, s)} into ${money(i.future, s)} in ${num(i.years)} years`,
            rows: { rate: pct(r), pv: money(i.present, s), continuous: pct(Math.log(i.future / i.present) / i.years), years: num(i.years) },
        };
    },

    savings_rate: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.deposit, i.goal, i.years) || i.years <= 0) {
            return { empty: 'Enter the deposit, goal and years.' };
        }

        const monthly = ok(i.monthly) ? i.monthly : 0;
        const n = Math.round(i.years * 12);
        const paid = i.deposit + monthly * n;

        if (paid >= i.goal) {
            return { value: '0', unit: '%', label: 'Interest rate needed', sub: 'Your deposits alone reach the goal', rows: { paid: money(paid, s), interest: money(0, s), monthly: '—', effective: '—' } };
        }

        const r = rate(n, -monthly, -i.deposit, i.goal, 0);

        if (r === null) {
            return { error: 'No realistic rate reaches this goal.' };
        }

        return {
            value: num(r * 1200),
            unit: '%',
            label: 'Interest rate needed (APR)',
            sub: `compounded monthly to reach ${money(i.goal, s)}`,
            rows: { paid: money(paid, s), interest: money(i.goal - paid, s), monthly: pct(r), effective: pct((1 + r) ** 12 - 1) },
        };
    },

    npv: (i, c) => {
        const s = symbolOf(c);
        const flows = flowsOf(i.flows);

        if (flows.length < 2 || !ok(i.rate)) {
            return { empty: 'Enter the rate and at least two cash flows (year 0 first).' };
        }

        const r = P(i.rate);
        const value = npv(r, flows);
        const inflows = flows.reduce((sum, cf, t) => sum + (t > 0 ? cf / (1 + r) ** t : 0), 0);
        const roots = irrs(flows);
        let cumulative = 0;
        const rows = flows.map((cf, t) => {
            const discounted = cf / (1 + r) ** t;
            cumulative += discounted;

            return { header: String(t), cells: [money0(cf, s), num((1 + r) ** -t), money0(discounted, s), money0(cumulative, s)] };
        });

        return {
            value: money(value, s),
            label: 'Net present value',
            sub: value >= 0 ? `Positive at ${pct(r)}: the project earns more than the rate` : `Negative at ${pct(r)}: the project earns less than the rate`,
            rows: {
                inflows: money(inflows, s),
                investment: money(flows[0], s),
                index: flows[0] < 0 ? num(inflows / -flows[0]) : '—',
                irr: roots.length ? roots.map(pct).join(', ') + (roots.length > 1 ? ' (several: flows change sign more than once)' : '') : 'None',
            },
            grids: { schedule: { columns: ['Cash flow', 'Factor', 'Present value', 'Cumulative'], rows, roomy: true } },
        };
    },

    irr: (i, c) => {
        const s = symbolOf(c);
        const flows = flowsOf(i.flows);

        if (flows.length < 2) {
            return { empty: 'Enter at least two cash flows (the investment first, as a negative number).' };
        }

        if (!flows.some((x) => x < 0) || !flows.some((x) => x > 0)) {
            return { error: 'An IRR needs both negative and positive cash flows.' };
        }

        const roots = irrs(flows);
        const changes = flows.slice(1).filter((x, k) => x !== 0 && Math.sign(x) !== Math.sign(flows.slice(0, k + 1).filter((y) => y !== 0).pop() ?? x)).length;
        const series = [];

        for (let r = -0.5; r <= 1.0001; r += 0.025) {
            series.push([Math.round(r * 1000) / 10, npv(r, flows)]);
        }

        if (!roots.length) {
            return { error: 'No rate between −99% and 1,000% makes the NPV zero.' };
        }

        return {
            value: num(roots[0] * 100),
            unit: '%',
            label: roots.length > 1 ? 'Internal rates of return' : 'Internal rate of return',
            sub: roots.length > 1 ? `Also ${roots.slice(1).map(pct).join(', ')}: with ${changes} sign changes the IRR is not unique; use NPV or MIRR` : `NPV is zero at this rate`,
            rows: {
                all: roots.map(pct).join(', '),
                total: money(flows.reduce((a, b) => a + b, 0), s),
                multiple: flows[0] < 0 ? `${num(flows.slice(1).filter((x) => x > 0).reduce((a, b) => a + b, 0) / -flows[0])}×` : '—',
                npv0: money(npv(0, flows), s),
            },
            plots: { chart: { series, xLabel: 'Discount rate (%)', yLabel: `NPV (${s})`, markers: roots.filter((r) => r <= 1 && r >= -0.5).map((r) => ({ x: r * 100, y: 0, label: `IRR ${pct(r)}` })) } },
        };
    },

    mirr: (i, c) => {
        const flows = flowsOf(i.flows);

        if (flows.length < 2 || !ok(i.finance, i.reinvest)) {
            return { empty: 'Enter the cash flows and the two rates.' };
        }

        const value = mirr(flows, P(i.finance), P(i.reinvest));

        if (!Number.isFinite(value)) {
            return { error: 'MIRR needs at least one negative and one positive cash flow.' };
        }

        const n = flows.length - 1;
        const pvNeg = flows.reduce((sum, cf, t) => sum + (cf < 0 ? cf / (1 + P(i.finance)) ** t : 0), 0);
        const fvPos = flows.reduce((sum, cf, t) => sum + (cf > 0 ? cf * (1 + P(i.reinvest)) ** (n - t) : 0), 0);
        const roots = irrs(flows);

        return {
            value: num(value * 100),
            unit: '%',
            label: 'Modified internal rate of return',
            sub: `over ${n} periods`,
            rows: { pv: money(pvNeg, symbolOf(c)), fv: money(fvPos, symbolOf(c)), irr: roots.length ? roots.map(pct).join(', ') : 'None', periods: num(n) },
        };
    },

    dcf: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.cash, i.growth, i.years, i.rate, i.terminal) || i.years < 1) {
            return { empty: 'Enter the cash flow, growth, years and rates.' };
        }

        const r = P(i.rate);
        const g = P(i.growth);
        const tg = P(i.terminal);

        if (tg >= r) {
            return { error: 'The terminal growth rate must be below the discount rate.' };
        }

        let flow = i.cash;
        let pvSum = 0;
        const rows = [];

        for (let t = 1; t <= i.years; t += 1) {
            flow *= 1 + g;
            const present = flow / (1 + r) ** t;
            pvSum += present;
            rows.push({ header: String(t), cells: [money0(flow, s), money0(present, s)] });
        }

        const terminal = (flow * (1 + tg)) / (r - tg);
        const terminalPv = terminal / (1 + r) ** i.years;
        const total = pvSum + terminalPv;
        const equity = total - (ok(i.debt) ? i.debt : 0);

        return {
            value: money(total, s),
            label: 'Present value (enterprise value)',
            sub: `${pct(terminalPv / total)} of it from the terminal value`,
            rows: {
                forecast: money(pvSum, s),
                terminal: `${money(terminal, s)} in year ${num(i.years)}, ${money(terminalPv, s)} today`,
                equity: ok(i.debt) ? money(equity, s) : 'Enter net debt for the equity value',
                share: ok(i.debt, i.shares) && i.shares > 0 ? money(equity / i.shares, s) : 'Enter shares for a value per share',
            },
            grids: { schedule: { columns: ['Cash flow', 'Present value'], rows, roomy: true } },
        };
    },

    payback: (i, c) => {
        const s = symbolOf(c);
        const flows = flowsOf(i.flows);

        if (!ok(i.investment) || i.investment <= 0 || !flows.length) {
            return { empty: 'Enter the investment and the yearly cash flows.' };
        }

        const r = ok(i.rate) ? P(i.rate) : 0;
        const find = (discount) => {
            let left = i.investment;

            for (let t = 0; t < flows.length; t += 1) {
                const cf = flows[t] / (1 + discount) ** (t + 1);

                if (cf >= left && cf > 0) {
                    return t + left / cf;
                }

                left -= cf;
            }

            return NaN;
        };
        const simple = find(0);
        const discounted = find(r);
        let cumulative = -i.investment;
        let cumulativeDisc = -i.investment;
        const rows = flows.map((cf, t) => {
            cumulative += cf;
            cumulativeDisc += cf / (1 + r) ** (t + 1);

            return { header: String(t + 1), cells: [money0(cf, s), money0(cumulative, s), money0(cumulativeDisc, s)] };
        });

        return {
            value: Number.isFinite(simple) ? num(simple) : 'Never',
            unit: Number.isFinite(simple) ? 'years' : '',
            label: 'Payback period',
            sub: Number.isFinite(simple) ? 'until the cash flows repay the investment' : 'The cash flows never repay the investment',
            rows: {
                discounted: Number.isFinite(discounted) ? `${num(discounted)} years at ${pct(r)}` : `Not within the cash flows at ${pct(r)}`,
                total: money(flows.reduce((a, b) => a + b, 0), s),
                npv: money(npv(r, [-i.investment, ...flows]), s),
                years: num(flows.length),
            },
            grids: { schedule: { columns: ['Cash flow', 'Cumulative', 'Discounted cumulative'], rows, roomy: true } },
        };
    },

    profitability_index: (i, c) => {
        const s = symbolOf(c);
        const flows = flowsOf(i.flows);

        if (!ok(i.investment, i.rate) || i.investment <= 0 || !flows.length) {
            return { empty: 'Enter the investment, rate and cash flows.' };
        }

        const present = flows.reduce((sum, cf, t) => sum + cf / (1 + P(i.rate)) ** (t + 1), 0);
        const index = present / i.investment;

        return {
            value: num(index),
            label: 'Profitability index',
            sub: index >= 1 ? 'Above 1: the project adds value at this rate' : 'Below 1: the project destroys value at this rate',
            rows: { pv: money(present, s), npv: money(present - i.investment, s), investment: money(i.investment, s), irr: irrs([-i.investment, ...flows]).map(pct).join(', ') || 'None' },
        };
    },

    expected_return: (i, c) => {
        const rows = parseRows(i.scenarios).map((cells) => ({ name: cells[0], p: P(Number(cells[1])), r: P(Number(cells[2])) })).filter((row) => ok(row.p, row.r));

        if (!rows.length) {
            return { empty: 'Add scenarios with a probability and a return.' };
        }

        const total = rows.reduce((sum, row) => sum + row.p, 0);

        if (Math.abs(total - 1) > 0.001) {
            return { error: `The probabilities add up to ${pct(total)}; they must total 100%.` };
        }

        const mean = rows.reduce((sum, row) => sum + row.p * row.r, 0);
        const variance = rows.reduce((sum, row) => sum + row.p * (row.r - mean) ** 2, 0);
        const amount = ok(i.amount) ? i.amount : NaN;

        return {
            value: num(mean * 100),
            unit: '%',
            label: 'Expected return',
            sub: `standard deviation ${pct(Math.sqrt(variance))}`,
            rows: {
                sd: pct(Math.sqrt(variance)),
                best: pct(Math.max(...rows.map((row) => row.r))),
                worst: pct(Math.min(...rows.map((row) => row.r))),
                gain: Number.isFinite(amount) ? money(amount * mean, symbolOf(c)) : 'Enter an amount',
            },
            lists: { scenarios: rows.map((row) => ({ label: `${row.name || 'Scenario'} (${pct(row.p)})`, value: `${pct(row.r)} → contributes ${pct(row.p * row.r)}` })) },
        };
    },

    expected_utility: (i, c) => {
        const s = symbolOf(c);
        const rows = parseRows(i.outcomes).map((cells) => ({ p: P(Number(cells[0])), x: Number(cells[1]) })).filter((row) => ok(row.p, row.x));

        if (!rows.length) {
            return { empty: 'Add outcomes with a probability and an amount.' };
        }

        const total = rows.reduce((sum, row) => sum + row.p, 0);

        if (Math.abs(total - 1) > 0.001) {
            return { error: `The probabilities add up to ${pct(total)}; they must total 100%.` };
        }

        const wealth = ok(i.wealth) ? i.wealth : 0;
        const gamma = ok(i.gamma) ? i.gamma : 2;
        const kind = i.utility ?? 'log';
        const u = (w) => (kind === 'linear' ? w : kind === 'log' ? Math.log(w) : gamma === 1 ? Math.log(w) : w ** (1 - gamma) / (1 - gamma));
        const inverse = (value) => (kind === 'linear' ? value : kind === 'log' || gamma === 1 ? Math.exp(value) : (value * (1 - gamma)) ** (1 / (1 - gamma)));

        if (kind !== 'linear' && rows.some((row) => wealth + row.x <= 0)) {
            return { error: 'Log and power utility need positive final wealth: raise your starting wealth.' };
        }

        const expected = rows.reduce((sum, row) => sum + row.p * (wealth + row.x), 0) - wealth;
        const eu = rows.reduce((sum, row) => sum + row.p * u(wealth + row.x), 0);
        const ce = inverse(eu) - wealth;

        return {
            value: money(ce, s),
            label: 'Certainty equivalent',
            sub: `the sure gain worth the same to you (${kind === 'linear' ? 'linear' : kind === 'log' ? 'log' : `power, γ = ${num(gamma)}`} utility)`,
            rows: { eu: num(eu), ev: money(expected, s), premium: money(expected - ce, s), verdict: ce > 0 ? 'Worth taking compared with doing nothing' : 'Not worth taking at this risk aversion' },
        };
    },

    max_drawdown: (i, c) => {
        const prices = flowsOf(i.prices);

        if (prices.length < 2 || prices.some((x) => x <= 0)) {
            return { empty: 'Enter at least two positive prices or values in order.' };
        }

        let peak = prices[0];
        let peakIndex = 0;
        let worst = 0;
        let at = [0, 0];

        prices.forEach((price, k) => {
            if (price > peak) {
                peak = price;
                peakIndex = k;
            }

            const fall = price / peak - 1;

            if (fall < worst) {
                worst = fall;
                at = [peakIndex, k];
            }
        });

        const recovery = prices.findIndex((price, k) => k > at[1] && price >= prices[at[0]]);

        return {
            value: num(worst * 100),
            unit: '%',
            label: 'Maximum drawdown',
            sub: worst < 0 ? `from ${num(prices[at[0]])} (point ${at[0] + 1}) to ${num(prices[at[1]])} (point ${at[1] + 1})` : 'The series never fell below an earlier peak',
            rows: {
                peak: `${num(prices[at[0]])} at point ${at[0] + 1}`,
                trough: `${num(prices[at[1]])} at point ${at[1] + 1}`,
                recovery: worst === 0 ? '—' : recovery > 0 ? `Recovered at point ${recovery + 1}` : 'Not yet recovered',
                total: pct(prices[prices.length - 1] / prices[0] - 1),
            },
            plots: { chart: { series: prices.map((price, k) => [k + 1, price]), xLabel: 'Point', yLabel: 'Value', markers: worst < 0 ? [{ x: at[0] + 1, y: prices[at[0]], label: 'Peak' }, { x: at[1] + 1, y: prices[at[1]], label: 'Trough' }] : [] } },
        };
    },

    moving_average: (i) => {
        const values = flowsOf(i.prices);
        const n = Math.round(i.window);

        if (!(n >= 1) || values.length < n) {
            return { empty: 'Enter a window and at least that many values.' };
        }

        const sma = [];
        const wma = [];
        const ema = [];
        const alpha = 2 / (n + 1);
        const weights = (n * (n + 1)) / 2;

        values.forEach((value, k) => {
            if (k >= n - 1) {
                const slice = values.slice(k - n + 1, k + 1);
                sma.push([k + 1, slice.reduce((a, b) => a + b, 0) / n]);
                wma.push([k + 1, slice.reduce((sum, x, j) => sum + x * (j + 1), 0) / weights]);
                // The EMA starts from the first SMA, as most charting packages do.
                ema.push([k + 1, ema.length ? alpha * value + (1 - alpha) * ema[ema.length - 1][1] : sma[0][1]]);
            }
        });

        const last = (list) => list[list.length - 1][1];

        return {
            value: num(last(sma)),
            label: `${n}-period simple moving average`,
            sub: `latest of ${sma.length} values`,
            rows: { wma: num(last(wma)), ema: num(last(ema)), alpha: num(alpha), latest: num(values[values.length - 1]) },
            plots: { chart: { series: values.map((value, k) => [k + 1, value]), series2: sma, legend: ['Values', `SMA ${n}`], xLabel: 'Period', yLabel: 'Value' } },
            lists: { averages: sma.map(([k, value], j) => ({ label: `Period ${k}`, value: `SMA ${num(value)} · WMA ${num(wma[j][1])} · EMA ${num(ema[j][1])}` })) },
        };
    },

    sortino: (i) => {
        const returns = flowsOf(i.returns).map(P);

        if (returns.length < 2 || !ok(i.target)) {
            return { empty: 'Enter at least two returns and the target return.' };
        }

        const target = P(i.target);
        const mean = returns.reduce((a, b) => a + b, 0) / returns.length;
        const downside = Math.sqrt(returns.reduce((sum, r) => sum + Math.min(0, r - target) ** 2, 0) / returns.length);
        const sd = Math.sqrt(returns.reduce((sum, r) => sum + (r - mean) ** 2, 0) / (returns.length - 1));

        if (downside === 0) {
            return { error: 'No return fell below the target, so downside deviation is zero.' };
        }

        return {
            value: num((mean - target) / downside),
            label: 'Sortino ratio',
            sub: `average return ${pct(mean)} against a ${pct(target)} target`,
            rows: { mean: pct(mean), downside: pct(downside), sd: pct(sd), sharpe: num((mean - target) / sd) },
        };
    },

    ttm: (i, c) => {
        const s = symbolOf(c);

        if (i.mode === 'annual') {
            if (!ok(i.annual, i.ytd, i.prior)) {
                return { empty: 'Enter the last annual figure and the two year-to-date figures.' };
            }

            const value = i.annual + i.ytd - i.prior;

            return { value: money(value, s), label: 'Trailing twelve months', sub: 'last fiscal year + this year to date − same period last year', rows: { change: pct(value / i.annual - 1), ytd: money(i.ytd - i.prior, s) } };
        }

        const quarters = [i.q1, i.q2, i.q3, i.q4];

        if (!ok(...quarters)) {
            return { empty: 'Enter the last four quarters.' };
        }

        const value = quarters.reduce((a, b) => a + b, 0);

        return { value: money(value, s), label: 'Trailing twelve months', sub: 'sum of the last four quarters', rows: { average: money(value / 4, s), runrate: money(quarters[3] * 4, s) } };
    },

    var: (i, c) => {
        const s = symbolOf(c);
        const z = { 90: 1.2815515655, 95: 1.6448536270, 97.5: 1.9599639845, 99: 2.3263478740, 99.5: 2.5758293035 }[Number(i.confidence)];

        if (i.mode === 'historical') {
            const returns = flowsOf(i.returns).map(P).sort((a, b) => a - b);

            if (returns.length < 10 || !ok(i.value)) {
                return { empty: 'Enter the portfolio value and at least 10 past returns.' };
            }

            const tail = 1 - Number(i.confidence) / 100;
            const index = Math.max(0, Math.ceil(tail * returns.length - 1e-9) - 1);
            const loss = -returns[index] * i.value;
            const worst = returns.slice(0, index + 1);
            const es = (-worst.reduce((a, b) => a + b, 0) / worst.length) * i.value;

            return {
                value: money(Math.max(0, loss), s),
                label: `${i.confidence}% historical VaR (one period)`,
                sub: `from ${returns.length} past returns, one period ahead`,
                rows: { percent: pct(-returns[index]), es: money(es, s), worst: pct(returns[0]), method: 'Historical simulation' },
            };
        }

        if (!ok(i.value, i.volatility, i.days)) {
            return { empty: 'Enter the value, volatility and horizon.' };
        }

        const t = i.days / 252;
        const mu = ok(i.mean) ? P(i.mean) : 0;
        const sigma = P(i.volatility) * Math.sqrt(t);
        const loss = i.value * (z * sigma - mu * t);
        const density = Math.exp(-(z ** 2) / 2) / Math.sqrt(2 * Math.PI);
        const es = i.value * ((sigma * density) / (1 - Number(i.confidence) / 100) - mu * t);

        return {
            value: money(Math.max(0, loss), s),
            label: `${i.confidence}% VaR over ${num(i.days)} trading days`,
            sub: `a loss larger than this is expected ${pct(1 - Number(i.confidence) / 100)} of the time (normal returns)`,
            rows: { percent: pct(loss / i.value), es: money(es, s), worst: `σ over the horizon ${pct(sigma)}`, method: `Parametric, z = ${num(z)}` },
        };
    },

    fee_drag: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.start, i.rate, i.fee, i.years) || i.years <= 0) {
            return { empty: 'Enter the balance, return, fee and years.' };
        }

        const base = { start: i.start, contribution: ok(i.contribution) ? i.contribution : 0, perYear: 12, compound: 12, years: i.years };
        const without = growth({ ...base, annual: P(i.rate) });
        const withFee = growth({ ...base, annual: P(i.rate) - P(i.fee) });
        const lost = without.balance - withFee.balance;

        return {
            value: money(lost, s),
            label: 'Lost to fees',
            sub: `${pct(lost / without.balance)} of what the balance would have been`,
            rows: { without: money(without.balance, s), with: money(withFee.balance, s), deposits: money(withFee.deposits, s), first: money(i.start * P(i.fee), s) },
            plots: { chart: { series: [[0, i.start], ...without.rows.map((row) => [row.year, row.balance])], series2: [[0, i.start], ...withFee.rows.map((row) => [row.year, row.balance])], legend: ['No fees', 'After fees'], xLabel: 'Year', yLabel: s } },
        };
    },

    mutual_fund: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.rate, i.years) || i.years <= 0) {
            return { empty: 'Enter the return and years.' };
        }

        const fee = ok(i.fee) ? P(i.fee) : 0;
        const load = ok(i.load) ? P(i.load) : 0;
        const start = (ok(i.start) ? i.start : 0) * (1 - load);
        const monthly = (ok(i.monthly) ? i.monthly : 0) * (1 - load);
        const result = growth({ start, contribution: monthly, perYear: 12, annual: P(i.rate) - fee, compound: 12, years: i.years, timing: 'start' });
        const invested = (ok(i.start) ? i.start : 0) + (ok(i.monthly) ? i.monthly : 0) * 12 * i.years;

        return {
            value: money(result.balance, s),
            label: 'Fund value',
            sub: `${money(invested, s)} invested over ${num(i.years)} years`,
            rows: { invested: money(invested, s), gain: money(result.balance - invested, s), net: pct(P(i.rate) - fee), load: money(invested * load, s) },
            grids: { schedule: yearGrid(result.rows, [['Invested', 'deposits'], ['Growth', 'interest'], ['Value', 'balance']], s) },
            plots: { chart: growthPlot(result.rows, s, start) },
        };
    },

    bitcoin_etf: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.amount, i.growth, i.fee, i.years) || i.years <= 0) {
            return { empty: 'Enter the amount, assumed yearly price change, fee and years.' };
        }

        const direct = i.amount * (1 + P(i.growth)) ** i.years;
        const etf = i.amount * ((1 + P(i.growth)) * (1 - P(i.fee))) ** i.years;
        const units = ok(i.price) && i.price > 0 ? i.amount / i.price : NaN;

        return {
            value: money(etf, s),
            label: 'ETF value',
            sub: `if bitcoin changes ${pct(P(i.growth))} a year (an assumption: prices are very volatile)`,
            rows: { direct: money(direct, s), fees: money(direct - etf, s), shares: Number.isFinite(units) ? num(units) : 'Enter the share price', change: pct(etf / i.amount - 1) },
        };
    },

    opportunity_cost: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.amount, i.chosen, i.alternative, i.years)) {
            return { empty: 'Enter the amount, both returns and years.' };
        }

        const a = i.amount * (1 + P(i.chosen)) ** i.years;
        const b = i.amount * (1 + P(i.alternative)) ** i.years;

        return {
            value: money(b - a, s),
            label: 'Opportunity cost',
            sub: b > a ? 'what the alternative would have earned on top' : 'Negative: your choice beats the alternative',
            rows: { chosen: money(a, s), alternative: money(b, s), percent: pct((b - a) / a), yearly: money((b - a) / i.years, s) },
        };
    },

    // Retirement ---------------------------------------------------------------------------------
    workplace: workplacePlan,
    ira: (i, c) => iraTool(i, c, false),
    roth: (i, c) => iraTool(i, c, true),

    retirement: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.age, i.retire, i.life, i.savings, i.monthly, i.rate, i.income) || i.retire <= i.age || i.life <= i.retire) {
            return { empty: 'Enter ages, savings, contributions, returns and the income you want.' };
        }

        const inflation = ok(i.inflation) ? P(i.inflation) : 0;
        const before = growth({ start: i.savings, contribution: i.monthly, perYear: 12, annual: P(i.rate), compound: 12, years: i.retire - i.age, increase: ok(i.increase) ? P(i.increase) : 0 });
        const yearsRetired = i.life - i.retire;
        const incomeAtRetirement = i.income * (1 + inflation) ** (i.retire - i.age);
        const other = (ok(i.other) ? i.other : 0) * (1 + inflation) ** (i.retire - i.age);
        const need = Math.max(0, incomeAtRetirement - other);
        const after = P(ok(i.after) ? i.after : i.rate);
        // Withdrawals at the start of each year, rising with inflation: present value of a growing annuity due.
        const g = (1 + inflation) / (1 + after);
        const nestEgg = need * (Math.abs(g - 1) < 1e-12 ? yearsRetired : (1 - g ** yearsRetired) / (1 - g));
        const rows = before.rows.map((row) => ({ ...row, year: i.age + row.year }));
        let b = before.balance;
        let w = need;
        let depleted = null;

        for (let y = 0; y < yearsRetired; y += 1) {
            b = (b - w) * (1 + after);

            if (b < 0 && depleted === null) {
                depleted = i.retire + y;
            }

            rows.push({ year: i.retire + y + 1, deposits: before.deposits, interest: 0, balance: Math.max(0, b) });
            w *= 1 + inflation;
        }

        const gap = nestEgg - before.balance;
        const extra = gap > 0 ? -pmt(periodRate(P(i.rate), 12, 12), (i.retire - i.age) * 12, 0, gap, 0) : 0;

        return {
            value: money(before.balance, s),
            label: `Savings at ${num(i.retire)}`,
            sub: gap > 0 ? `${money(gap, s)} short of the ${money(nestEgg, s)} needed` : `Enough: ${money(-gap, s)} more than the ${money(nestEgg, s)} needed`,
            rows: {
                needed: money(nestEgg, s),
                income: `${money(need, s)} a year from savings at ${num(i.retire)} (${money(i.income, s)} today, less other income)`,
                lasts: depleted === null ? `Lasts past age ${num(i.life)}` : `Runs out at about age ${depleted}`,
                extra: gap > 0 ? `${money(extra, s)} more a month` : 'None',
            },
            grids: { schedule: { columns: ['Balance'], rows: rows.map((row) => ({ header: String(row.year), cells: [money0(row.balance, s)] })), roomy: true } },
            plots: { chart: { series: [[i.age, i.savings], ...rows.map((row) => [row.year, row.balance])], xLabel: 'Age', yLabel: s, markers: [{ x: i.retire, y: before.balance, label: 'Retire' }] } },
        };
    },

    withdrawal: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.balance, i.withdrawal, i.rate) || i.balance <= 0 || i.withdrawal <= 0) {
            return { empty: 'Enter the balance, monthly withdrawal and return.' };
        }

        const result = drawdown(i.balance, i.withdrawal, P(i.rate), ok(i.increase) ? P(i.increase) : 0);
        const r = (1 + P(i.rate)) ** (1 / 12) - 1;
        const sustainable = i.balance * r;

        return {
            value: result.lasts ? 'Over 100' : durationText(result.months),
            unit: result.lasts ? 'years' : '',
            label: 'Savings last',
            sub: result.lasts ? 'The return covers the withdrawals' : `${money(result.paid, s)} withdrawn in total`,
            rows: {
                total: money(result.paid, s),
                sustainable: `${money(sustainable, s)} a month keeps the balance level (no increases)`,
                rate: pct((i.withdrawal * 12) / i.balance),
                end: result.lasts ? money(result.end, s) : 'Empty',
            },
            plots: { chart: { series: result.path, xLabel: 'Year', yLabel: s } },
        };
    },

    annuity: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.payment, i.rate, i.years) || i.years <= 0) {
            return { empty: 'Enter the payment, rate and years.' };
        }

        const per = Number(i.per ?? 12);
        const r = P(i.rate) / per;
        const n = i.years * per;
        const type = i.timing === 'start' ? 1 : 0;
        const present = -pv(r, n, i.payment, 0, type);
        const future = -fv(r, n, i.payment, 0, type);
        const wantFuture = i.solve === 'fv';

        return {
            value: money(wantFuture ? future : present, s),
            label: wantFuture ? 'Future value of the annuity' : 'Present value of the annuity',
            sub: `${money(i.payment, s)} ${type ? 'at the start' : 'at the end'} of each period, ${num(n)} periods`,
            rows: { pv: money(present, s), fv: money(future, s), total: money(i.payment * n, s), interest: money(wantFuture ? future - i.payment * n : i.payment * n - present, s) },
        };
    },

    annuity_fv: (i, c) => handlers.annuity({ ...i, solve: 'fv' }, c),
    annuity_pv: (i, c) => handlers.annuity({ ...i, solve: 'pv' }, c),

    annuity_payout: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.balance, i.rate, i.years) || i.balance <= 0 || i.years <= 0) {
            return { empty: 'Enter the balance, rate and years.' };
        }

        const per = Number(i.per ?? 12);
        const r = P(i.rate) / per;
        const n = i.years * per;
        const type = i.timing === 'start' ? 1 : 0;
        const payment = -pmt(r, n, i.balance, 0, type);
        const names = { 12: 'a month', 4: 'a quarter', 1: 'a year', 2: 'every six months' };

        return {
            value: money(payment, s),
            label: `Payout ${names[per] ?? 'a period'}`,
            sub: `for ${num(i.years)} years from ${money(i.balance, s)}`,
            rows: { total: money(payment * n, s), interest: money(payment * n - i.balance, s), yearly: money(payment * per, s), payments: num(n) },
        };
    },

    deferred_annuity: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.deposit, i.rate, i.defer, i.years) || i.years <= 0) {
            return { empty: 'Enter the deposit, growth rate, deferral and payout years.' };
        }

        const yearly = ok(i.yearly) ? i.yearly : 0;
        const value = growth({ start: i.deposit, contribution: yearly, perYear: 1, annual: P(i.rate), compound: 1, years: i.defer, timing: 'start' }).balance;
        const payoutRate = P(ok(i.payout_rate) ? i.payout_rate : i.rate) / 12;
        const payment = -pmt(payoutRate, i.years * 12, value, 0, 0);
        const paidIn = i.deposit + yearly * i.defer;

        return {
            value: money(payment, s),
            label: 'Monthly payout',
            sub: `for ${num(i.years)} years after ${num(i.defer)} years of growth`,
            rows: { value: money(value, s), paidin: money(paidIn, s), total: money(payment * i.years * 12, s), ratio: `${num((payment * i.years * 12) / paidIn)}× what you paid in` },
        };
    },

    early_retirement: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.age, i.retire, i.expenses, i.wr, i.savings, i.monthly, i.rate) || i.retire <= i.age || i.wr <= 0) {
            return { empty: 'Enter ages, expenses, withdrawal rate, savings and return.' };
        }

        const inflation = ok(i.inflation) ? P(i.inflation) : 0;
        const years = i.retire - i.age;
        const target = ((i.expenses * (1 + inflation) ** years) / P(i.wr));
        const projected = growth({ start: i.savings, contribution: i.monthly, perYear: 12, annual: P(i.rate), compound: 12, years }).balance;
        const gap = target - projected;
        const extra = gap > 0 ? -pmt(periodRate(P(i.rate), 12, 12), years * 12, 0, gap, 0) : 0;
        const r = periodRate(P(i.rate), 12, 12);
        const reach = nper(r, -i.monthly, -i.savings, target, 0);

        return {
            value: money(target, s),
            label: `Savings needed at ${num(i.retire)}`,
            sub: `${money(i.expenses, s)} a year today, ${pct(P(i.wr))} withdrawal rate${inflation ? `, ${pct(inflation)} inflation` : ''}`,
            rows: {
                projected: money(projected, s),
                gap: gap > 0 ? `${money(gap, s)} short` : `${money(-gap, s)} ahead`,
                extra: gap > 0 ? `${money(extra, s)} more a month` : 'None',
                reach: Number.isFinite(reach) ? `Age ${num(i.age + reach / 12)} at your current saving` : 'Not reachable at this saving rate',
            },
        };
    },

    growing_annuity: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.payment, i.rate, i.growth, i.years) || i.years <= 0) {
            return { empty: 'Enter the first payment, rate, growth and years.' };
        }

        const r = P(i.rate);
        const g = P(i.growth);
        const n = i.years;
        const present = Math.abs(r - g) < 1e-12 ? (i.payment * n) / (1 + r) : (i.payment / (r - g)) * (1 - ((1 + g) / (1 + r)) ** n);
        const future = present * (1 + r) ** n;
        const total = Math.abs(g) < 1e-12 ? i.payment * n : (i.payment * ((1 + g) ** n - 1)) / g;

        return {
            value: money(present, s),
            label: 'Present value',
            sub: `${num(n)} yearly payments starting at ${money(i.payment, s)}, growing ${pct(g)}`,
            rows: { fv: money(future, s), total: money(total, s), last: money(i.payment * (1 + g) ** (n - 1), s), perpetuity: r > g ? money(i.payment / (r - g), s) : 'Needs rate above growth' },
        };
    },

    immediate_annuity: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.premium, i.rate, i.years) || i.premium <= 0 || i.years <= 0) {
            return { empty: 'Enter the premium, rate and payout years.' };
        }

        const payment = -pmt(P(i.rate) / 12, i.years * 12, i.premium, 0, 0);

        return {
            value: money(payment, s),
            label: 'Monthly income',
            sub: `for ${num(i.years)} years (period certain) from ${money(i.premium, s)}`,
            rows: { yearly: money(payment * 12, s), total: money(payment * i.years * 12, s), payout: pct((payment * 12) / i.premium), breakeven: `${num(i.premium / payment / 12)} years to get the premium back` },
        };
    },

    rule72: (i) => {
        if (i.mode === 'rate') {
            if (!ok(i.years) || i.years <= 0) {
                return { empty: 'Enter the years to double.' };
            }

            return { value: num(72 / i.years), unit: '%', label: 'Rate needed to double', sub: `in ${num(i.years)} years (Rule of 72)`, rows: { exact: pct(2 ** (1 / i.years) - 1), rule69: `${num(69.3 / i.years)}%`, rule70: `${num(70 / i.years)}%`, error: pct(72 / i.years / 100 - (2 ** (1 / i.years) - 1)) } };
        }

        if (!ok(i.rate) || i.rate <= 0) {
            return { empty: 'Enter the annual return.' };
        }

        const exact = Math.log(2) / Math.log(1 + P(i.rate));

        return {
            value: num(72 / i.rate),
            unit: 'years',
            label: 'Years to double (Rule of 72)',
            sub: `at ${pct(P(i.rate))} a year`,
            rows: { exact: `${num(exact)} years`, rule69: `${num(69.3 / i.rate)} years (continuous compounding)`, rule70: `${num(70 / i.rate)} years`, error: `${num(72 / i.rate - exact)} years` },
        };
    },

    variable_annuity: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.deposit, i.rate, i.me, i.fund, i.years)) {
            return { empty: 'Enter the deposit, return, fees and years.' };
        }

        const fees = P(i.me) + P(i.fund) + (ok(i.rider) ? P(i.rider) : 0);
        const gross = i.deposit * (1 + P(i.rate)) ** i.years;
        const net = i.deposit * ((1 + P(i.rate)) * (1 - fees)) ** i.years;

        return {
            value: money(net, s),
            label: 'Value after fees',
            sub: `${pct(fees)} a year in total fees`,
            rows: { gross: money(gross, s), fees: money(gross - net, s), share: pct((gross - net) / gross), net: pct((1 + P(i.rate)) * (1 - fees) - 1) },
        };
    },

    ss_breakeven: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.born, i.pia) || i.pia <= 0 || i.born < 1900) {
            return { empty: 'Enter your birth year and your benefit at full retirement age.' };
        }

        const fra = fullRetirementMonths(i.born);
        const cola = ok(i.cola) ? P(i.cola) : 0;
        const ages = [62 * 12, fra, 70 * 12];
        const monthly = ages.map((age) => i.pia * claimFactor(age, fra));
        const cumulative = (k, ageMonths) => {
            let total = 0;

            for (let m = ages[k]; m < ageMonths; m += 1) {
                total += monthly[k] * (1 + cola) ** Math.floor((m - ages[k]) / 12);
            }

            return total;
        };
        const breakEven = (a, b) => {
            for (let m = ages[b]; m <= 110 * 12; m += 1) {
                if (cumulative(b, m) >= cumulative(a, m)) {
                    return m;
                }
            }

            return NaN;
        };
        const be62fra = breakEven(0, 1);
        const beFra70 = breakEven(1, 2);
        const be6270 = breakEven(0, 2);
        const series = [];
        const series2 = [];

        for (let age = 62; age <= 95; age += 1) {
            series.push([age, cumulative(0, age * 12)]);
            series2.push([age, cumulative(2, age * 12)]);
        }

        return {
            value: Number.isFinite(be6270) ? ageText(be6270) : '—',
            unit: '',
            label: 'Break-even age, 62 vs 70',
            sub: `Claiming at 70 pays more in total if you live past this age`,
            rows: {
                fra: ageText(fra),
                at62: `${money(monthly[0], s)} a month (${pct(monthly[0] / i.pia)} of your benefit)`,
                atFra: `${money(monthly[1], s)} a month`,
                at70: `${money(monthly[2], s)} a month (${pct(monthly[2] / i.pia)})`,
                be62fra: Number.isFinite(be62fra) ? `Age ${ageText(be62fra)}` : '—',
                befra70: Number.isFinite(beFra70) ? `Age ${ageText(beFra70)}` : '—',
            },
            plots: { chart: { series, series2, legend: ['Claim at 62', 'Claim at 70'], xLabel: 'Age', yLabel: `Total received (${s})` } },
        };
    },

    // Personal savings goals --------------------------------------------------------------------
    college: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.years, i.cost, i.rate) || i.years < 0) {
            return { empty: 'Enter years until college, yearly cost and return.' };
        }

        const inflation = ok(i.inflation) ? P(i.inflation) : 0;
        const length = ok(i.length) ? i.length : 4;
        let cost = 0;

        for (let y = 0; y < length; y += 1) {
            cost += i.cost * (1 + inflation) ** (i.years + y);
        }

        const saved = growth({ start: ok(i.savings) ? i.savings : 0, contribution: ok(i.monthly) ? i.monthly : 0, perYear: 12, annual: P(i.rate), compound: 12, years: Math.max(i.years, 1e-9) }).balance;
        const gap = cost - saved;
        const extra = gap > 0 && i.years > 0 ? -pmt(periodRate(P(i.rate), 12, 12), i.years * 12, 0, gap, 0) : 0;

        return {
            value: money(saved, s),
            label: 'Saved by the first year of college',
            sub: `${pct(Math.min(1, saved / cost))} of the projected ${money(cost, s)} cost`,
            rows: { cost: money(cost, s), gap: gap > 0 ? money(gap, s) : `None: ${money(-gap, s)} spare`, extra: gap > 0 ? `${money(extra, s)} more a month` : 'None', first: money(i.cost * (1 + inflation) ** i.years, s) },
        };
    },

    goal: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.goal, i.years, i.rate) || i.goal <= 0 || i.years <= 0) {
            return { empty: 'Enter the goal, time and return.' };
        }

        const saved = ok(i.saved) ? i.saved : 0;
        const r = periodRate(P(i.rate), 12, 12);
        const n = Math.round(i.years * 12);
        const monthly = Math.max(0, -pmt(r, n, -saved, i.goal, 0));
        const total = saved + monthly * n;

        return {
            value: money(monthly, s),
            label: 'Save each month',
            sub: `to reach ${money(i.goal, s)} in ${num(i.years)} years`,
            rows: { deposits: money(total, s), interest: money(i.goal - total, s), weekly: money((monthly * 12) / 52, s), grown: money(saved * (1 + r) ** n, s) },
        };
    },

    fire: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.expenses, i.wr, i.savings, i.yearly, i.rate) || i.wr <= 0) {
            return { empty: 'Enter spending, withdrawal rate, savings and return.' };
        }

        const target = i.expenses / P(i.wr);
        const r = P(i.rate);
        let balance = i.savings;
        let years = 0;
        const series = [[0, balance]];

        while (balance < target && years < 100) {
            balance = balance * (1 + r) + i.yearly;
            years += 1;
            series.push([years, balance]);
        }

        const income = ok(i.income) ? i.income : NaN;

        return {
            value: money(target, s),
            label: 'FIRE number',
            sub: years < 100 ? `reached in about ${years} years (${money(balance, s)})` : 'Not reached in 100 years at this saving',
            rows: {
                years: years < 100 ? `${years} years${ok(i.age) ? `, at age ${num(i.age + years)}` : ''}` : 'Over 100 years',
                multiple: `${num(1 / P(i.wr))}× yearly spending`,
                savingsRate: Number.isFinite(income) && income > 0 ? pct(i.yearly / income) : 'Enter after-tax income',
                monthly: money(i.expenses / 12, s),
            },
            plots: { chart: { series, xLabel: 'Year', yLabel: s, markers: [{ x: Math.min(years, 100), y: target, label: 'FIRE' }] } },
        };
    },

    sabbatical: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.expenses, i.months, i.saved, i.monthly, i.until) || i.expenses <= 0) {
            return { empty: 'Enter monthly costs, time off, savings and saving plan.' };
        }

        const income = ok(i.income) ? i.income : 0;
        const cost = (i.expenses - income) * i.months + (ok(i.oneoff) ? i.oneoff : 0);
        const fund = i.saved + i.monthly * i.until;
        const affordable = (fund - (ok(i.oneoff) ? i.oneoff : 0)) / Math.max(1e-9, i.expenses - income);
        const needMonthly = i.until > 0 ? Math.max(0, (cost - i.saved) / i.until) : NaN;

        return {
            value: money(cost, s),
            label: 'Sabbatical cost',
            sub: fund >= cost ? `Covered: ${money(fund, s)} saved by the start` : `${money(cost - fund, s)} short of ${money(fund, s)} saved by the start`,
            rows: { fund: money(fund, s), affordable: `${num(Math.max(0, affordable))} months`, need: Number.isFinite(needMonthly) ? `${money(needMonthly, s)} a month` : '—', gap: fund >= cost ? 'None' : money(cost - fund, s) },
        };
    },

    trump_account: (i, c) => {
        const s = symbolOf(c);
        const rules = c.data.trump;

        if (!ok(i.born, i.family, i.rate) || i.born < 2008) {
            return { empty: 'Enter the birth year, yearly contributions and return.' };
        }

        const employer = Math.min(ok(i.employer) ? i.employer : 0, rules.employer_cap);
        const yearly = Math.min(i.family + employer, rules.annual_cap);
        const seed = i.born >= rules.pilot_years[0] && i.born <= rules.pilot_years[1] ? rules.pilot : 0;
        const start = Math.max(rules.first_year, i.born);
        const years = i.born + 18 - start;

        if (years <= 0) {
            return { error: 'Contributions start in July 2026: the child would already be 18.' };
        }

        const result = growth({ start: seed, contribution: yearly, perYear: 1, annual: P(i.rate), compound: 1, years, timing: 'end' });

        return {
            value: money(result.balance, s),
            label: 'Balance at 18',
            sub: `${num(years)} years of growth at ${pct(P(i.rate))}${seed ? ` including the ${money(seed, s)} Treasury pilot deposit` : ''}`,
            rows: {
                seed: seed ? `${money(seed, s)} (child born ${rules.pilot_years[0]}–${rules.pilot_years[1]})` : `None (only for children born ${rules.pilot_years[0]}–${rules.pilot_years[1]})`,
                yearly: `${money(yearly, s)} a year${i.family + employer > rules.annual_cap ? ` (capped at ${money(rules.annual_cap, s)})` : ''}`,
                deposits: money(result.deposits, s),
                growth: money(result.interest, s),
            },
            grids: { schedule: yearGrid(result.rows.map((row) => ({ ...row, year: start + row.year })), [['Deposits', 'deposits'], ['Growth', 'interest'], ['Balance', 'balance']], s) },
        };
    },
};

export default defineTools(handlers);
