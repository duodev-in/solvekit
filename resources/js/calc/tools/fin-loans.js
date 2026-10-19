import { getCurrency } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { amortize, apr as aprOf, balanceAfter, cardPayoff, payment, payoffPlan } from '../finance/loans.js';
import { money, money0, num, pct, yearGrid } from '../finance/common.js';
import { irrs, nper, rate as rateOf } from '../finance/tvm.js';
import { parseRows } from '../rows-editor.js';

/**
 * Loans, mortgages, credit cards and debt payoff. Rates are entered as annual percentages;
 * FHA, VA and loan-limit tables come from config/finance_data.php.
 */
const P = (value) => value / 100;
const ok = (...values) => values.every(Number.isFinite);
// Fixed-currency pages pass `sym` (a currency code); otherwise the page's display currency applies.
const symbolOf = (c) => c.sym ?? getCurrency();
const or0 = (value) => (Number.isFinite(value) ? value : 0);

const durationText = (months) => {
    const whole = Math.round(months);
    const y = Math.floor(whole / 12);
    const m = whole % 12;

    return `${y ? `${y} year${y === 1 ? '' : 's'}` : ''}${y && m ? ' ' : ''}${m || !y ? `${m} month${m === 1 ? '' : 's'}` : ''}`;
};

const scheduleGrid = (result, s) => yearGrid(result.years, [['Paid', 'paid'], ['Interest', 'interest'], ['Principal', 'principal'], ['Balance', 'balance']], s);
const balancePlot = (result, principal, s, compare = null) => ({
    series: [[0, principal], ...result.years.map((row) => [row.year, row.balance])],
    ...(compare ? { series2: [[0, principal], ...compare.years.map((row) => [row.year, row.balance])], legend: ['With extra payments', 'Without'] } : {}),
    xLabel: 'Year',
    yLabel: s,
});

/**
 * The amount borrowed: an amount field, or price − down payment (percent or amount).
 */
function principalOf(i) {
    if (ok(i.amount)) {
        return i.amount;
    }

    if (ok(i.price)) {
        const down = i.down_type === 'amount' ? or0(i.down) : i.price * P(or0(i.down));

        return i.price - down - or0(i.trade) + or0(i.trade_owed);
    }

    return NaN;
}

const termYears = (i) => (ok(i.years) ? i.years : ok(i.months) ? i.months / 12 : NaN);

/**
 * Amortizing loan with optional extra payments, a one-off lump sum, a balloon, an interest-only start and an
 * upfront fee (for the APR). Shared by the general loan, mortgage-schedule and EMI pages.
 */
function loanTool(i, c) {
    const s = symbolOf(c);
    const principal = principalOf(i);
    const years = termYears(i);

    if (!ok(principal, i.rate, years) || principal <= 0 || years <= 0) {
        return { empty: 'Enter the amount, rate and term.' };
    }

    const perYear = Number(i.per ?? 12);
    const lump = ok(i.lump, i.lump_month) && i.lump > 0 ? { [Math.round(i.lump_month)]: i.lump } : {};
    const options = { principal, annualRate: P(i.rate), years, perYear, interestOnly: Math.round(or0(i.io_years) * perYear), balloon: or0(i.balloon) };

    // Partially amortized: payments as if over the longer amortization, the rest due as a balloon at the end of the term.
    if (ok(i.amort_years) && i.amort_years > years) {
        const level = payment(principal, P(i.rate) / perYear, Math.round(i.amort_years * perYear));
        options.balloon = balanceAfter(principal, P(i.rate) / perYear, level, Math.round(years * perYear));
    }
    const base = amortize(options);
    const result = amortize({ ...options, extra: or0(i.extra), extraYearly: or0(i.extra_yearly), lump });

    if (base.error || result.error) {
        return { error: base.error ?? result.error };
    }

    const fee = i.fee_type === 'amount' ? or0(i.fee) : principal * P(or0(i.fee));
    const n = Math.round(years * perYear);
    const aprValue = fee > 0 && !options.balloon && !options.interestOnly ? aprOf(principal - fee, base.level, n, perYear) : P(i.rate);
    const extraUsed = result.totalInterest < base.totalInterest - 0.005;
    const periodName = { 12: 'month', 26: 'two weeks', 52: 'week', 4: 'quarter', 1: 'year' }[perYear] ?? 'period';

    return {
        value: money(options.interestOnly ? base.rows[options.interestOnly]?.payment ?? base.level : base.level, s),
        label: `Payment each ${periodName}`,
        sub: options.interestOnly
            ? `${money(base.payment, s)} interest-only for ${num(or0(i.io_years))} years, then this`
            : options.balloon ? `${num(n)} payments, then a ${money(options.balloon, s)} balloon` : `${num(n)} payments, ${money(base.totalInterest, s)} total interest`,
        rows: {
            interest: money(result.totalInterest, s),
            total: money(result.totalPaid + fee, s),
            payoff: `${durationText((result.periods / perYear) * 12)}${extraUsed ? ` (${durationText(((n - result.periods) / perYear) * 12)} sooner)` : ''}`,
            saved: extraUsed ? money(base.totalInterest - result.totalInterest, s) : 'Add extra payments to see the saving',
            apr: fee > 0 ? `${pct(aprValue)} with ${money(fee, s)} of fees` : pct(P(i.rate)),
            share: `${pct(result.totalInterest / principal)} of the amount borrowed`,
        },
        grids: { schedule: scheduleGrid(result, s) },
        plots: { chart: balancePlot(result, principal, s, extraUsed ? base : null) },
    };
}

/**
 * Monthly mortgage cost: principal and interest, property tax, insurance, HOA and PMI (dropped when the
 * scheduled balance reaches 78% of the original value, as the Homeowners Protection Act requires).
 */
function mortgageTool(i, c) {
    const s = symbolOf(c);
    const price = i.price;
    const principal = principalOf(i);
    const years = termYears(i);

    if (!ok(price, principal, i.rate, years) || principal <= 0 || years <= 0) {
        return { empty: 'Enter the price, down payment, rate and term.' };
    }

    const base = amortize({ principal, annualRate: P(i.rate), years });
    const result = amortize({ principal, annualRate: P(i.rate), years, extra: or0(i.extra), extraYearly: or0(i.extra_yearly), lump: ok(i.lump, i.lump_month) && i.lump > 0 ? { [Math.round(i.lump_month)]: i.lump } : {} });
    const tax = i.tax_type === 'amount' ? or0(i.tax) / 12 : (price * P(or0(i.tax))) / 12;
    const insurance = or0(i.insurance) / 12;
    const hoa = or0(i.hoa);
    const ltv = principal / price;
    const pmiRate = ok(i.pmi) ? P(i.pmi) : 0;
    const pmi = ltv > 0.8 ? (principal * pmiRate) / 12 : 0;
    const pmiMonths = pmi > 0 ? result.rows.findIndex((row) => row.balance <= 0.78 * price) + 1 : 0;
    const total = base.level + tax + insurance + hoa + pmi;
    const extraUsed = result.totalInterest < base.totalInterest - 0.005;

    return {
        value: money(total, s),
        label: 'Monthly payment',
        sub: `${money(base.level, s)} principal and interest on a ${money0(principal, s)} loan`,
        rows: {
            pi: money(base.level, s),
            taxes: money(tax, s),
            insurance: money(insurance, s),
            hoa: money(hoa, s),
            pmi: pmi > 0 ? `${money(pmi, s)} until month ${pmiMonths} (78% LTV)` : ltv > 0.8 ? 'Enter a PMI rate (LTV above 80%)' : 'None (20% or more down)',
            ltv: pct(ltv),
            interest: money(result.totalInterest, s),
            payoff: `${durationText(result.periods)}${extraUsed ? `, saving ${money(base.totalInterest - result.totalInterest, s)} interest` : ''}`,
        },
        grids: { schedule: scheduleGrid(result, s) },
        plots: { chart: balancePlot(result, principal, s, extraUsed ? base : null) },
    };
}

/**
 * FHA annual MIP rate in basis points (HUD Mortgagee Letter 2023-05) and how long it lasts.
 */
function fhaMip(table, baseLoan, ltv, years) {
    const long = years > 15;
    const rows = long ? table.long : table.short;
    const tier = baseLoan <= table.threshold ? rows.standard : rows.high;
    const row = tier.find((t) => ltv <= t.ltv_max) ?? tier[tier.length - 1];

    return { bps: row.bps, life: ltv > 0.9 };
}

function fhaTool(i, c) {
    const s = symbolOf(c);
    const t = c.data.fha;

    if (!ok(i.price, i.down, i.rate, i.years) || i.price <= 0) {
        return { empty: 'Enter the price, down payment, rate and term.' };
    }

    const downPct = P(i.down);

    if (downPct < t.min_down) {
        return { error: `FHA loans need at least ${pct(t.min_down)} down (credit score 580 or higher).` };
    }

    const baseLoan = i.price * (1 - downPct);
    const upfront = baseLoan * t.upfront;
    const loan = baseLoan + upfront;
    const ltv = baseLoan / i.price;
    const mip = fhaMip(t, baseLoan, ltv, i.years);
    const result = amortize({ principal: loan, annualRate: P(i.rate), years: i.years });
    const mipMonthly = (baseLoan * mip.bps) / 10000 / 12;
    const tax = (i.price * P(or0(i.tax))) / 12;
    const insurance = or0(i.insurance) / 12;

    return {
        value: money(result.level + mipMonthly + tax + insurance, s),
        label: 'Monthly payment',
        sub: `${money(result.level, s)} principal and interest + ${money(mipMonthly, s)} MIP`,
        rows: {
            base: money(baseLoan, s),
            upfront: `${money(upfront, s)} (${pct(t.upfront)}, added to the loan)`,
            loan: money(loan, s),
            mip: `${num(mip.bps / 100)}% a year: ${money(mipMonthly, s)} a month, ${mip.life ? 'for the life of the loan' : 'for 11 years'}`,
            taxes: money(tax + insurance, s),
            limit: `${money0(t.limit_floor, s)} in most counties, up to ${money0(t.limit_ceiling, s)} in high-cost areas (${t.year})`,
        },
        grids: { schedule: scheduleGrid(result, s) },
        plots: { chart: balancePlot(result, loan, s) },
    };
}

function vaTool(i, c) {
    const s = symbolOf(c);
    const t = c.data.va;

    if (!ok(i.price, i.rate, i.years) || i.price <= 0) {
        return { empty: 'Enter the price, rate and term.' };
    }

    const downPct = P(or0(i.down));
    const baseLoan = i.price * (1 - downPct);
    let feeRate = 0;

    if (!i.exempt) {
        if (i.purpose === 'irrrl') {
            feeRate = t.irrrl;
        } else if (i.purpose === 'cashout') {
            feeRate = i.use === 'subsequent' ? t.cashout_subsequent : t.cashout_first;
        } else {
            const tier = t.purchase.find((row) => downPct >= row.down_min);
            feeRate = i.use === 'subsequent' ? tier.subsequent : tier.first;
        }
    }

    const fee = baseLoan * feeRate;
    const loan = baseLoan + (i.finance_fee === false ? 0 : fee);
    const result = amortize({ principal: loan, annualRate: P(i.rate), years: i.years });
    const tax = (i.price * P(or0(i.tax))) / 12;
    const insurance = or0(i.insurance) / 12;

    return {
        value: money(result.level + tax + insurance, s),
        label: 'Monthly payment',
        sub: `${money(result.level, s)} principal and interest; VA loans have no monthly mortgage insurance`,
        rows: {
            fee: i.exempt ? 'Exempt (VA disability compensation or Purple Heart)' : `${money(fee, s)} (${pct(feeRate)})`,
            loan: money(loan, s),
            interest: money(result.totalInterest, s),
            taxes: money(tax + insurance, s),
            note: `Funding fee schedule in effect since ${t.effective}`,
        },
        grids: { schedule: scheduleGrid(result, s) },
        plots: { chart: balancePlot(result, loan, s) },
    };
}

/**
 * Adjustable-rate mortgage: fixed for the initial period, then the rate moves toward index + margin within the
 * initial, periodic and lifetime caps, adjusting every `adjust` months. The index is assumed to stay where you set it.
 */
function armTool(i, c) {
    const s = symbolOf(c);
    const principal = principalOf(i);

    if (!ok(principal, i.rate, i.years, i.fixed, i.index, i.margin) || principal <= 0) {
        return { empty: 'Enter the loan, start rate, fixed period, index and margin.' };
    }

    const start = P(i.rate);
    const target = P(i.index) + P(i.margin);
    const capFirst = P(or0(i.cap_first));
    const capPeriodic = P(or0(i.cap_periodic));
    const lifetime = start + P(or0(i.cap_life));
    const adjust = Math.round(or0(i.adjust) || 12);
    const resets = [];
    let current = start;

    for (let month = Math.round(i.fixed * 12) + 1, first = true; month <= i.years * 12; month += adjust, first = false) {
        const cap = first ? capFirst : capPeriodic;
        let delta = target - current;

        if (cap > 0) {
            delta = Math.max(-cap, Math.min(cap, delta));
        }

        // Most ARMs never go below the margin (the floor) or above start + lifetime cap.
        const next = Math.min(lifetime, Math.max(P(i.margin), current + delta));

        if (Math.abs(next - current) > 1e-12) {
            resets.push({ period: month, annualRate: next });
        }

        current = next;
    }

    const result = amortize({ principal, annualRate: start, years: i.years, resets });
    const fixedOnly = amortize({ principal, annualRate: start, years: i.years });
    const after = result.rows[Math.round(i.fixed * 12)];
    const highest = result.rows.reduce((max, row) => Math.max(max, row.payment), 0);

    return {
        value: money(fixedOnly.level, s),
        label: `Payment for the first ${num(i.fixed)} years`,
        sub: after ? `then ${money(after.payment, s)} at ${pct(after.rate)}` : 'No reset within the term',
        rows: {
            reset: after ? `${money(after.payment, s)} a month at ${pct(after.rate)}` : '—',
            highest: `${money(highest, s)} a month`,
            ceiling: pct(lifetime),
            interest: money(result.totalInterest, s),
            compare: `${money(fixedOnly.totalInterest, s)} if the start rate never changed`,
        },
        grids: { schedule: { columns: ['Rate', 'Payment', 'Balance'], rows: result.years.map((row) => { const last = result.rows[Math.min(result.rows.length - 1, row.year * 12 - 1)]; return { header: String(row.year), cells: [pct(last.rate), money(last.payment, s), money0(row.balance, s)] }; }), roomy: true } },
        plots: { chart: { series: result.rows.filter((row, k) => k % 12 === 0).map((row) => [Math.floor(row.period / 12), row.payment]), xLabel: 'Year', yLabel: `Monthly payment (${s})` } },
    };
}

function biweeklyTool(i, c) {
    const s = symbolOf(c);
    const principal = principalOf(i);

    if (!ok(principal, i.rate, i.years) || principal <= 0) {
        return { empty: 'Enter the loan, rate and term.' };
    }

    const monthly = amortize({ principal, annualRate: P(i.rate), years: i.years });
    // Half the monthly payment every two weeks: 26 half-payments, about one extra monthly payment a year.
    const biweekly = amortize({ principal, annualRate: P(i.rate), years: i.years, perYear: 26, fixedPayment: monthly.level / 2 });
    const savedMonths = i.years * 12 - (biweekly.periods / 26) * 12;

    return {
        value: money(monthly.level / 2, s),
        label: 'Biweekly payment',
        sub: `half of the ${money(monthly.level, s)} monthly payment, 26 times a year`,
        rows: {
            payoff: durationText((biweekly.periods / 26) * 12),
            sooner: durationText(savedMonths),
            saved: money(monthly.totalInterest - biweekly.totalInterest, s),
            interest: `${money(biweekly.totalInterest, s)} against ${money(monthly.totalInterest, s)} paying monthly`,
            yearly: `${money((monthly.level / 2) * 26, s)} a year against ${money(monthly.level * 12, s)}`,
        },
        grids: { schedule: scheduleGrid(biweekly, s) },
        plots: { chart: { series: [[0, principal], ...biweekly.years.map((row) => [row.year, row.balance])], series2: [[0, principal], ...monthly.years.map((row) => [row.year, row.balance])], legend: ['Biweekly', 'Monthly'], xLabel: 'Year', yLabel: s } },
    };
}

/**
 * Highest home price whose payment (principal and interest, tax, insurance, HOA, PMI) fits within the 28% and
 * 36% debt-to-income limits. Solved by bisection because PMI depends on the price.
 */
function affordabilityTool(i, c) {
    const s = symbolOf(c);

    if (!ok(i.income, i.rate, i.years) || i.income <= 0) {
        return { empty: 'Enter income, rate and term.' };
    }

    const monthlyIncome = i.income / 12;
    const front = P(ok(i.front) ? i.front : 28);
    const back = P(ok(i.back) ? i.back : 36);
    const budget = Math.min(monthlyIncome * front, monthlyIncome * back - or0(i.debts));
    const down = or0(i.downpay);
    const cost = (price) => {
        const loan = Math.max(0, price - down);
        const pmi = loan / price > 0.8 ? (loan * P(or0(i.pmi))) / 12 : 0;

        return payment(loan, P(i.rate) / 12, i.years * 12) + (price * P(or0(i.tax))) / 12 + or0(i.insurance) / 12 + or0(i.hoa) + pmi;
    };

    if (budget <= 0) {
        return { error: 'Your other debts already use the whole 36% limit.' };
    }

    let lo = down;
    let hi = down + 1e8;

    for (let k = 0; k < 200; k += 1) {
        const mid = (lo + hi) / 2;

        if (cost(mid) > budget) {
            hi = mid;
        } else {
            lo = mid;
        }
    }

    const price = lo;
    const loan = price - down;

    return {
        value: money0(price, s),
        label: 'Home price you can afford',
        sub: `with ${money0(down, s)} down and a ${money(budget, s)} monthly housing budget`,
        rows: {
            budget: `${money(budget, s)} a month (${pct(budget / monthlyIncome)} of gross income)`,
            loan: money0(loan, s),
            pi: money(payment(loan, P(i.rate) / 12, i.years * 12), s),
            rule: monthlyIncome * front <= monthlyIncome * back - or0(i.debts) ? `Limited by the ${pct(front)} housing ratio` : `Limited by the ${pct(back)} total debt ratio`,
            ltv: pct(loan / price),
        },
    };
}

const loanPayoff = (i, c, labels = {}) => {
    const s = symbolOf(c);

    if (!ok(i.balance, i.rate, i.payment) || i.balance <= 0 || i.payment <= 0) {
        return { empty: 'Enter the balance, rate and payment.' };
    }

    const r = P(i.rate) / 12;

    if (i.payment <= i.balance * r) {
        return { error: `The payment must be more than the monthly interest of ${money(i.balance * r, s)}.` };
    }

    const months = nper(r, -i.payment, i.balance, 0, 0);
    const result = amortize({ principal: i.balance, annualRate: P(i.rate), years: Math.ceil(months) / 12, fixedPayment: i.payment });
    const target = ok(i.target) && i.target > 0 ? payment(i.balance, r, i.target * 12) : NaN;

    return {
        value: durationText(Math.ceil(months)),
        label: labels.label ?? 'Time to pay off',
        sub: `${num(Math.ceil(months))} payments of ${money(i.payment, s)}`,
        rows: {
            interest: money(result.totalInterest, s),
            total: money(result.totalPaid, s),
            last: money(result.rows[result.rows.length - 1].payment, s),
            target: Number.isFinite(target) ? `${money(target, s)} a month to finish in ${num(i.target)} years (${money(target - i.payment, s)} ${target > i.payment ? 'more' : 'less'})` : 'Enter a target to see the payment needed',
        },
        grids: { schedule: scheduleGrid(result, s) },
        plots: { chart: balancePlot(result, i.balance, s) },
    };
};

function refinanceTool(i, c) {
    const s = symbolOf(c);

    if (!ok(i.balance, i.rate, i.remaining, i.new_rate, i.new_years) || i.balance <= 0) {
        return { empty: 'Enter the current loan and the new loan.' };
    }

    const cashOut = or0(i.cash_out);
    const costs = or0(i.costs);
    const newPrincipal = i.balance + cashOut + (i.roll_costs ? costs : 0);
    const current = amortize({ principal: i.balance, annualRate: P(i.rate), years: i.remaining });
    const next = amortize({ principal: newPrincipal, annualRate: P(i.new_rate), years: i.new_years });
    const saving = current.level - next.level;
    const breakEven = saving > 0 ? costs / saving : NaN;
    const lifetime = current.totalPaid - next.totalPaid - (i.roll_costs ? 0 : costs) + cashOut;

    return {
        value: money(next.level, s),
        label: 'New monthly payment',
        sub: saving >= 0 ? `${money(saving, s)} a month less than ${money(current.level, s)} now` : `${money(-saving, s)} a month more than ${money(current.level, s)} now`,
        rows: {
            saving: money(saving, s),
            breakeven: Number.isFinite(breakEven) ? `${num(Math.ceil(breakEven))} months (${num(breakEven / 12)} years)` : 'Never: the payment does not fall',
            interest: `${money(next.totalInterest, s)} on the new loan, ${money(current.totalInterest, s)} left on the old`,
            lifetime: `${money(lifetime, s)} ${lifetime >= 0 ? 'less' : 'more'} paid over both terms${cashOut ? ' (counting the cash out)' : ''}`,
            loan: money(newPrincipal, s),
            ltv: ok(i.value) && i.value > 0 ? pct(newPrincipal / i.value) : 'Enter the home value',
        },
    };
}

function cardTool(i, c) {
    const s = symbolOf(c);

    if (!ok(i.balance, i.apr) || i.balance <= 0) {
        return { empty: 'Enter the balance and APR.' };
    }

    const r = P(i.apr) / 12;
    let pay = i.payment;

    if (i.mode === 'months') {
        if (!ok(i.months) || i.months <= 0) {
            return { empty: 'Enter the months to pay it off.' };
        }

        pay = payment(i.balance, r, i.months);
    }

    if (!ok(pay) || pay <= 0) {
        return { empty: 'Enter a monthly payment.' };
    }

    const result = cardPayoff({ balance: i.balance, apr: P(i.apr), payment: pay });

    if (result.never) {
        return { error: `${money(pay, s)} does not cover the ${money(i.balance * r, s)} monthly interest: the balance would never fall.` };
    }

    const minimum = cardPayoff({ balance: i.balance, apr: P(i.apr), minPercent: 0.01, minFloor: 25, plusInterest: true });

    return {
        value: i.mode === 'months' ? money(pay, s) : durationText(result.months),
        label: i.mode === 'months' ? 'Monthly payment needed' : 'Time to pay off',
        sub: `${money(result.interest, s)} interest, ${money(result.total, s)} in total`,
        rows: {
            months: `${num(result.months)} months`,
            interest: money(result.interest, s),
            total: money(result.total, s),
            minimum: minimum.never ? 'Minimum payments never clear it' : `Minimum payments only (1% + interest, $25 floor): ${durationText(minimum.months)}, ${money(minimum.interest, s)} interest`,
        },
        plots: { chart: { series: result.path, series2: minimum.path.filter(([year]) => year <= Math.max(result.months / 12, 1) * 3), legend: ['Your payment', 'Minimum only'], xLabel: 'Year', yLabel: s } },
    };
}

function debtsOf(text) {
    return parseRows(text)
        .map((cells, k) => ({ name: cells[0] || `Debt ${k + 1}`, balance: Number(cells[1]), rate: P(Number(cells[2])), minimum: Number(cells[3]) }))
        .filter((d) => ok(d.balance, d.rate, d.minimum) && d.balance > 0);
}

function debtPlanTool(i, c) {
    const s = symbolOf(c);
    const debts = debtsOf(i.debts);

    if (!debts.length || !ok(i.budget)) {
        return { empty: 'Add your debts and a monthly budget.' };
    }

    const method = i.method ?? 'avalanche';
    const plan = payoffPlan(debts, i.budget, method);

    if (plan.error) {
        return { error: plan.error };
    }

    const minimums = debts.reduce((sum, d) => sum + d.minimum, 0);
    const minimumOnly = payoffPlan(debts, minimums, method);
    const other = payoffPlan(debts, i.budget, method === 'avalanche' ? 'snowball' : 'avalanche');
    const total = debts.reduce((sum, d) => sum + d.balance, 0);

    return {
        value: durationText(plan.months),
        label: 'Debt-free in',
        sub: `${money(plan.interest, s)} interest on ${money(total, s)} of debt, paying ${money(i.budget, s)} a month`,
        rows: {
            total: money(total, s),
            interest: money(plan.interest, s),
            minimums: minimumOnly.error ? 'Minimums alone never clear the debts' : `Minimums only (${money(minimums, s)}): ${durationText(minimumOnly.months)}, ${money(minimumOnly.interest, s)} interest`,
            other: other.error ? '—' : `${method === 'avalanche' ? 'Snowball' : 'Avalanche'}: ${durationText(other.months)}, ${money(other.interest, s)} interest`,
            rate: pct(debts.reduce((sum, d) => sum + d.balance * d.rate, 0) / total),
        },
        lists: { order: plan.finished.map((f) => ({ label: f.name, value: `paid off in month ${f.month}` })) },
    };
}

export const handlers = {
    loan: loanTool,
    mortgage: mortgageTool,
    fha: fhaTool,
    va: vaTool,
    arm: armTool,
    biweekly: biweeklyTool,
    affordability: affordabilityTool,

    jumbo: (i, c) => {
        const out = loanTool(i, c);
        const limits = c.data.loanlimits;

        if (out.empty || out.error) {
            return out;
        }

        const s = symbolOf(c);
        const amount = principalOf(i);
        const limit = ok(i.limit) && i.limit > 0 ? i.limit : limits.baseline;
        out.rows.jumbo = amount > limit ? `Jumbo: ${money0(amount - limit, s)} above the ${money0(limit, s)} conforming limit` : `Conforming: ${money0(limit - amount, s)} under the ${money0(limit, s)} limit`;
        out.rows.limits = `${money0(limits.baseline, s)} in most counties, up to ${money0(limits.ceiling, s)} in high-cost areas (${limits.year})`;

        return out;
    },

    payoff: (i, c) => loanPayoff(i, c),

    mortgage_payoff: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.balance, i.rate, i.payment)) {
            return { empty: 'Enter the balance, rate and monthly payment.' };
        }

        const out = loanPayoff(i, c);

        if (out.empty || out.error) {
            return out;
        }

        const r = P(i.rate) / 12;
        const months = nper(r, -(i.payment + or0(i.extra)), i.balance, 0, 0);
        const withExtra = amortize({ principal: i.balance, annualRate: P(i.rate), years: Math.ceil(months) / 12, fixedPayment: i.payment + or0(i.extra) });
        const base = amortize({ principal: i.balance, annualRate: P(i.rate), years: Math.ceil(nper(r, -i.payment, i.balance, 0, 0)) / 12, fixedPayment: i.payment });
        out.rows.extra = or0(i.extra) > 0 ? `${durationText(Math.ceil(months))} with ${money(i.extra, s)} extra, saving ${money(base.totalInterest - withExtra.totalInterest, s)}` : 'Add an extra payment to compare';

        return out;
    },

    penalty: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.balance, i.rate, i.remaining)) {
            return { empty: 'Enter the balance, your rate and the months left in the term.' };
        }

        const threeMonths = i.balance * P(i.rate) * (3 / 12);
        const comparison = ok(i.compare) ? P(i.compare) : NaN;
        const ird = Number.isFinite(comparison) ? Math.max(0, i.balance * (P(i.rate) - comparison) * (i.remaining / 12)) : NaN;
        const fixed = i.type !== 'variable';
        const penalty = fixed && Number.isFinite(ird) ? Math.max(threeMonths, ird) : threeMonths;

        return {
            value: money(penalty, s),
            label: 'Estimated prepayment penalty',
            sub: fixed ? 'the greater of three months\' interest and the interest rate differential' : 'three months\' interest (variable-rate mortgage)',
            rows: {
                three: money(threeMonths, s),
                ird: Number.isFinite(ird) ? `${money(ird, s)} at a ${pct(comparison)} comparison rate` : 'Enter the comparison rate',
                basis: fixed ? 'Fixed rate: greater of the two' : 'Variable rate: three months\' interest',
                note: 'Lenders define the comparison rate differently (posted vs discounted); check your mortgage terms',
            },
        };
    },

    points: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.amount, i.rate, i.points_rate, i.points, i.years)) {
            return { empty: 'Enter the loan, both rates, points and term.' };
        }

        const without = amortize({ principal: i.amount, annualRate: P(i.rate), years: i.years });
        const withPoints = amortize({ principal: i.amount, annualRate: P(i.points_rate), years: i.years });
        const cost = i.amount * P(i.points);
        const saving = without.level - withPoints.level;
        const stay = ok(i.stay) ? i.stay : i.years;
        const net = saving * stay * 12 - cost;

        return {
            value: saving > 0 ? `${num(Math.ceil(cost / saving))} months` : 'Never',
            label: 'Break-even',
            sub: `${money(cost, s)} for points saves ${money(saving, s)} a month`,
            rows: {
                cost: money(cost, s),
                saving: money(saving, s),
                payments: `${money(withPoints.level, s)} with points, ${money(without.level, s)} without`,
                net: `${money(net, s)} ${net >= 0 ? 'saved' : 'lost'} if you keep the loan ${num(stay)} years`,
                lifetime: money(without.totalInterest - withPoints.totalInterest - cost, s),
            },
        };
    },

    loan_rate: (i, c) => {
        const s = symbolOf(c);
        const principal = principalOf(i);

        if (!ok(principal, i.payment, i.years) || principal <= 0 || i.payment <= 0) {
            return { empty: 'Enter the loan, payment and term.' };
        }

        const n = Math.round(i.years * 12);

        if (i.payment * n <= principal) {
            return { error: 'The payments do not repay the loan.' };
        }

        const r = rateOf(n, -i.payment, principal, 0, 0);

        return r === null ? { error: 'No rate matches these figures.' } : {
            value: num(r * 1200),
            unit: '%',
            label: 'Interest rate',
            sub: `${money(i.payment, s)} a month for ${num(i.years)} years on ${money0(principal, s)}`,
            rows: { effective: pct((1 + r) ** 12 - 1), interest: money(i.payment * n - principal, s), total: money(i.payment * n, s), monthly: pct(r) },
        };
    },

    refinance: refinanceTool,

    comparison: (i, c) => {
        const s = symbolOf(c);
        const loans = parseRows(i.loans).map((cells, k) => ({ name: cells[0] || `Loan ${k + 1}`, amount: Number(cells[1]), rate: Number(cells[2]), years: Number(cells[3]), fees: Number(cells[4] || 0) })).filter((l) => ok(l.amount, l.rate, l.years) && l.amount > 0 && l.years > 0);

        if (!loans.length) {
            return { empty: 'Add loans to compare.' };
        }

        const results = loans.map((l) => {
            const a = amortize({ principal: l.amount, annualRate: P(l.rate), years: l.years });

            return { ...l, payment: a.level, interest: a.totalInterest, cost: a.totalInterest + l.fees, apr: l.fees > 0 ? aprOf(l.amount - l.fees, a.level, Math.round(l.years * 12)) : P(l.rate) };
        });
        const best = results.reduce((a, b) => (b.cost < a.cost ? b : a));
        const lowest = results.reduce((a, b) => (b.payment < a.payment ? b : a));

        return {
            value: best.name,
            label: 'Lowest total cost',
            sub: `${money(best.cost, s)} of interest and fees`,
            rows: { cheapest: `${best.name}: ${money(best.cost, s)}`, payment: `${lowest.name}: ${money(lowest.payment, s)} a month`, gap: money(results.reduce((max, r) => Math.max(max, r.cost), 0) - best.cost, s), count: num(results.length) },
            grids: { schedule: { columns: ['Payment', 'Interest', 'Fees', 'APR'], rows: results.map((r) => ({ header: r.name, cells: [money(r.payment, s), money0(r.interest, s), money0(r.fees, s), pct(r.apr)] })), roomy: true } },
        };
    },

    apr: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.amount, i.rate, i.years) || i.amount <= 0) {
            return { empty: 'Enter the amount, rate and term.' };
        }

        const n = Math.round(i.years * 12);
        const level = payment(i.amount, P(i.rate) / 12, n);
        const fees = or0(i.fees) + i.amount * P(or0(i.points));
        const value = aprOf(i.amount - fees, level, n);

        return {
            value: num(value * 100),
            unit: '%',
            label: 'APR',
            sub: `on a ${pct(P(i.rate))} note rate with ${money(fees, s)} of prepaid finance charges`,
            rows: { payment: money(level, s), financed: money(i.amount - fees, s), charge: money(level * n - i.amount + fees, s), gap: `${num((value - P(i.rate)) * 100)} percentage points above the note rate` },
        };
    },

    balance: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.amount, i.rate, i.years, i.paid) || i.amount <= 0) {
            return { empty: 'Enter the loan, rate, term and payments made.' };
        }

        const r = P(i.rate) / 12;
        const n = Math.round(i.years * 12);
        const level = payment(i.amount, r, n);
        const k = Math.min(Math.round(i.paid), n);
        const left = Math.max(0, balanceAfter(i.amount, r, level, k));

        return {
            value: money(left, s),
            label: 'Balance remaining',
            sub: `after ${num(k)} of ${num(n)} payments of ${money(level, s)}`,
            rows: { principal: money(i.amount - left, s), interest: money(level * k - (i.amount - left), s), remaining: `${num(n - k)} payments, ${money(level * (n - k) - left, s)} interest still to pay`, share: pct((i.amount - left) / i.amount) },
        };
    },

    card: cardTool,

    card_minimum: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.balance, i.apr, i.percent, i.floor) || i.balance <= 0) {
            return { empty: 'Enter the balance, APR and minimum payment rule.' };
        }

        const result = cardPayoff({ balance: i.balance, apr: P(i.apr), minPercent: P(i.percent), minFloor: i.floor, plusInterest: i.plus_interest !== false });

        if (result.never) {
            return { error: 'At this rule the minimum payment never clears the balance.' };
        }

        const first = Math.max(i.floor, i.balance * P(i.percent) + (i.plus_interest !== false ? i.balance * (P(i.apr) / 12) : 0));
        const fixed = cardPayoff({ balance: i.balance, apr: P(i.apr), payment: first });

        return {
            value: durationText(result.months),
            label: 'Time to pay off with minimums',
            sub: `${money(result.interest, s)} interest; first minimum ${money(first, s)}`,
            rows: { first: money(first, s), interest: money(result.interest, s), total: money(result.total, s), fixed: fixed.never ? '—' : `Keep paying ${money(first, s)}: ${durationText(fixed.months)}, ${money(fixed.interest, s)} interest` },
            plots: { chart: { series: result.path, series2: fixed.path, legend: ['Minimums', 'Fixed first payment'], xLabel: 'Year', yLabel: s } },
        };
    },

    card_interest: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.balance, i.apr, i.days)) {
            return { empty: 'Enter the average daily balance, APR and days.' };
        }

        const daily = P(i.apr) / 365;
        const interest = i.balance * daily * i.days;

        return {
            value: money(interest, s),
            label: 'Interest this billing cycle',
            sub: `average daily balance × ${pct(daily)} a day × ${num(i.days)} days`,
            rows: { daily: pct(daily), perDay: money(i.balance * daily, s), year: money(i.balance * P(i.apr), s), effective: pct((1 + daily) ** 365 - 1) },
        };
    },

    balance_transfer: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.balance, i.apr, i.payment, i.fee, i.promo, i.months, i.after)) {
            return { empty: 'Enter the balance, rates, fee, promo period and payment.' };
        }

        const stay = cardPayoff({ balance: i.balance, apr: P(i.apr), payment: i.payment });
        const fee = i.balance * P(i.fee);
        let b = i.balance + fee;
        let interest = 0;
        let months = 0;

        while (b > 0.005 && months < 1200) {
            const r = (months < i.months ? P(i.promo) : P(i.after)) / 12;
            const charge = b * r;

            if (i.payment <= charge) {
                return { error: 'The payment does not cover the interest after the promotion.' };
            }

            interest += charge;
            b = b + charge - Math.min(i.payment, b + charge);
            months += 1;
        }

        const leftAtEnd = Math.max(0, balanceAfter(i.balance + fee, P(i.promo) / 12, i.payment, Math.min(i.months, months)));
        const saved = (stay.never ? Infinity : stay.interest) - (interest + fee);

        return {
            value: Number.isFinite(saved) ? money(saved, s) : 'Large',
            label: 'Saved by transferring',
            sub: `${money(fee, s)} transfer fee + ${money(interest, s)} interest against ${stay.never ? 'never paying off' : money(stay.interest, s)}`,
            rows: { fee: money(fee, s), stay: stay.never ? 'Never paid off' : `${durationText(stay.months)}, ${money(stay.interest, s)} interest`, move: `${durationText(months)}, ${money(interest + fee, s)} interest and fee`, left: `${money(leftAtEnd, s)} left when the promo ends` },
        };
    },

    debt_plan: debtPlanTool,

    snowball_vs_avalanche: (i, c) => {
        const s = symbolOf(c);
        const debts = debtsOf(i.debts);

        if (!debts.length || !ok(i.budget)) {
            return { empty: 'Add your debts and a monthly budget.' };
        }

        const a = payoffPlan(debts, i.budget, 'avalanche');
        const b = payoffPlan(debts, i.budget, 'snowball');

        if (a.error) {
            return { error: a.error };
        }

        const diff = b.interest - a.interest;

        return {
            value: money(diff, s),
            label: 'Avalanche saves',
            sub: diff > 0.005 ? `in interest compared with the snowball` : 'Both orders cost the same here',
            rows: {
                avalanche: `${durationText(a.months)}, ${money(a.interest, s)} interest`,
                snowball: `${durationText(b.months)}, ${money(b.interest, s)} interest`,
                firstWin: `Snowball clears ${b.finished[0]?.name} in month ${b.finished[0]?.month}; avalanche clears ${a.finished[0]?.name} in month ${a.finished[0]?.month}`,
                months: `${num(b.months - a.months)} months difference`,
            },
            lists: { avalanche: a.finished.map((f) => ({ label: f.name, value: `month ${f.month}` })), snowball: b.finished.map((f) => ({ label: f.name, value: `month ${f.month}` })) },
        };
    },

    consolidation: (i, c) => {
        const s = symbolOf(c);
        const debts = debtsOf(i.debts);

        if (!debts.length || !ok(i.rate, i.years)) {
            return { empty: 'Add your debts and the consolidation loan terms.' };
        }

        const total = debts.reduce((sum, d) => sum + d.balance, 0);
        const minimums = debts.reduce((sum, d) => sum + d.minimum, 0);
        const fee = total * P(or0(i.fee));
        const loan = amortize({ principal: total + fee, annualRate: P(i.rate), years: i.years });
        const current = payoffPlan(debts, minimums, 'avalanche');
        const blended = debts.reduce((sum, d) => sum + d.balance * d.rate, 0) / total;

        return {
            value: money(loan.level, s),
            label: 'Consolidation loan payment',
            sub: `against ${money(minimums, s)} of minimum payments now`,
            rows: {
                total: money(total, s),
                interest: `${money(loan.totalInterest + fee, s)} with the loan (incl. ${money(fee, s)} fee)`,
                current: current.error ? 'Your minimums never clear the debts' : `${money(current.interest, s)} paying current minimums for ${durationText(current.months)}`,
                saving: current.error ? '—' : money(current.interest - loan.totalInterest - fee, s),
                rate: `${pct(blended)} average now, ${pct(P(i.rate))} with the loan`,
            },
        };
    },

    blended_rate: (i, c) => {
        const s = symbolOf(c);
        const loans = parseRows(i.loans).map((cells, k) => ({ name: cells[0] || `Loan ${k + 1}`, balance: Number(cells[1]), rate: Number(cells[2]) })).filter((l) => ok(l.balance, l.rate) && l.balance > 0);

        if (!loans.length) {
            return { empty: 'Add balances and rates.' };
        }

        const total = loans.reduce((sum, l) => sum + l.balance, 0);
        const blended = loans.reduce((sum, l) => sum + l.balance * l.rate, 0) / total;

        return {
            value: num(blended),
            unit: '%',
            label: 'Blended interest rate',
            sub: `balance-weighted average of ${loans.length} loans`,
            rows: { total: money(total, s), yearly: money((total * blended) / 100, s), highest: `${num(Math.max(...loans.map((l) => l.rate)))}%`, simple: `${num(loans.reduce((sum, l) => sum + l.rate, 0) / loans.length)}% unweighted` },
        };
    },

    deferred: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.amount, i.rate, i.defer, i.years) || i.amount <= 0) {
            return { empty: 'Enter the loan, rate, deferral and repayment term.' };
        }

        const accrued = i.subsidized ? 0 : i.compound === 'monthly' ? i.amount * ((1 + P(i.rate) / 12) ** i.defer - 1) : i.amount * P(i.rate) * (i.defer / 12);
        const capitalized = i.amount + accrued;
        const result = amortize({ principal: capitalized, annualRate: P(i.rate), years: i.years });
        const noDefer = amortize({ principal: i.amount, annualRate: P(i.rate), years: i.years });

        return {
            value: money(result.level, s),
            label: 'Monthly payment after deferral',
            sub: `${money(accrued, s)} of interest added to the balance`,
            rows: { accrued: money(accrued, s), balance: money(capitalized, s), interest: money(result.totalInterest + accrued, s), extra: `${money(result.level - noDefer.level, s)} a month more than without deferral` },
        };
    },

    early_payoff: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.balance, i.rate, i.payment, i.target) || i.target <= 0) {
            return { empty: 'Enter the balance, rate, payment and target.' };
        }

        const r = P(i.rate) / 12;
        const needed = payment(i.balance, r, i.target * 12);
        const now = nper(r, -i.payment, i.balance, 0, 0);
        const before = amortize({ principal: i.balance, annualRate: P(i.rate), years: Math.ceil(now) / 12, fixedPayment: i.payment });
        const after = amortize({ principal: i.balance, annualRate: P(i.rate), years: i.target });

        if (!Number.isFinite(now)) {
            return { error: 'The current payment does not cover the interest.' };
        }

        return {
            value: money(Math.max(0, needed - i.payment), s),
            label: 'Extra each month',
            sub: `pay ${money(needed, s)} a month to finish in ${num(i.target)} years`,
            rows: { now: durationText(Math.ceil(now)), saved: money(before.totalInterest - after.totalInterest, s), needed: money(needed, s), interest: money(after.totalInterest, s) },
        };
    },

    finance_charge: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.amount, i.rate, i.months) || i.amount <= 0) {
            return { empty: 'Enter the amount, rate and term.' };
        }

        const level = payment(i.amount, P(i.rate) / 12, i.months);
        const interest = level * i.months - i.amount;
        const fees = or0(i.fees);

        return {
            value: money(interest + fees, s),
            label: 'Finance charge',
            sub: 'all interest and fees: the cost of the credit (Truth in Lending)',
            rows: { interest: money(interest, s), fees: money(fees, s), payment: money(level, s), apr: pct(fees ? aprOf(i.amount - fees, level, i.months) : P(i.rate)) },
        };
    },

    heloc: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.amount, i.rate, i.draw, i.repay) || i.amount <= 0) {
            return { empty: 'Enter the amount drawn, rate, draw and repayment periods.' };
        }

        const io = (i.amount * P(i.rate)) / 12;
        const repay = payment(i.amount, P(i.rate) / 12, i.repay * 12);
        const total = io * i.draw * 12 + repay * i.repay * 12;
        const available = ok(i.value, i.owed) ? Math.max(0, i.value * P(ok(i.cltv) ? i.cltv : 85) - i.owed) : NaN;

        return {
            value: money(io, s),
            label: 'Interest-only payment during the draw',
            sub: `then ${money(repay, s)} a month for ${num(i.repay)} years`,
            rows: { repay: money(repay, s), jump: `${money(repay - io, s)} more a month (payment shock)`, interest: money(total - i.amount, s), line: Number.isFinite(available) ? `${money0(available, s)} at ${num(ok(i.cltv) ? i.cltv : 85)}% combined LTV` : 'Enter home value and mortgage' },
        };
    },

    car_lease: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.price, i.residual, i.months) || i.months <= 0) {
            return { empty: 'Enter the price, residual and term.' };
        }

        const mf = i.rate_type === 'apr' ? P(or0(i.rate)) / 24 : or0(i.rate);
        const cap = i.price + or0(i.fees) - or0(i.down) - or0(i.trade);
        const residualValue = i.residual_type === 'amount' ? i.residual : (ok(i.msrp) ? i.msrp : i.price) * P(i.residual);
        const depreciation = (cap - residualValue) / i.months;
        const finance = (cap + residualValue) * mf;
        const before = depreciation + finance;
        const tax = before * P(or0(i.tax));

        return {
            value: money(before + tax, s),
            label: 'Monthly lease payment',
            sub: `${money(depreciation, s)} depreciation + ${money(finance, s)} rent charge + ${money(tax, s)} tax`,
            rows: { cap: money(cap, s), residual: money(residualValue, s), mf: `${num(mf)} (≈ ${num(mf * 2400)}% APR)`, total: money((before + tax) * i.months + or0(i.down), s) },
        };
    },

    auto_loan: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.price, i.rate, i.months) || i.price <= 0) {
            return { empty: 'Enter the price, rate and term.' };
        }

        // Most states tax the price after the trade-in credit; fees are added to the amount financed here.
        const taxBase = i.price - (i.trade_credit === false ? 0 : or0(i.trade));
        const tax = taxBase * P(or0(i.tax));
        const financed = i.price + tax + or0(i.fees) - or0(i.down) - or0(i.trade) + or0(i.trade_owed);

        if (financed <= 0) {
            return { error: 'The down payment and trade-in cover the whole price.' };
        }

        const result = amortize({ principal: financed, annualRate: P(i.rate), years: i.months / 12 });

        return {
            value: money(result.level, s),
            label: 'Monthly payment',
            sub: `${money(financed, s)} financed for ${num(i.months)} months`,
            rows: { financed: money(financed, s), tax: money(tax, s), interest: money(result.totalInterest, s), total: money(result.totalPaid + or0(i.down), s), ratio: or0(i.income) > 0 ? `${pct(result.level / (i.income / 12))} of gross monthly income` : 'Enter income to compare' },
            grids: { schedule: scheduleGrid(result, s) },
        };
    },

    car_affordability: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.payment, i.rate, i.months) || i.payment <= 0) {
            return { empty: 'Enter your monthly budget, rate and term.' };
        }

        const r = P(i.rate) / 12;
        const loan = r === 0 ? i.payment * i.months : (i.payment * (1 - (1 + r) ** -i.months)) / r;
        const price = (loan + or0(i.down) + or0(i.trade) - or0(i.fees)) / (1 + P(or0(i.tax)));

        return {
            value: money0(price, s),
            label: 'Car price you can afford',
            sub: `${money(i.payment, s)} a month for ${num(i.months)} months`,
            rows: { loan: money0(loan, s), interest: money(i.payment * i.months - loan, s), tax: money(price * P(or0(i.tax)), s), rule: or0(i.income) > 0 ? `${pct((i.payment * 12) / i.income)} of income on payments (many advisers suggest under 10–15%)` : 'Enter income to compare' },
        };
    },

    payday: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.amount, i.fee, i.days) || i.amount <= 0 || i.days <= 0) {
            return { empty: 'Enter the amount, fee and term.' };
        }

        const apr = (i.fee / i.amount) * (365 / i.days);

        return {
            value: num(apr * 100),
            unit: '%',
            label: 'APR',
            sub: `${money(i.fee, s)} to borrow ${money(i.amount, s)} for ${num(i.days)} days`,
            rows: { per100: money((i.fee / i.amount) * 100, s), rollover: `${money(i.fee * Math.max(1, or0(i.rollovers) + 1), s)} in fees after ${num(or0(i.rollovers))} rollovers`, effective: pct((1 + i.fee / i.amount) ** (365 / i.days) - 1), card: money(i.amount * 0.24 * (i.days / 365), s) },
        };
    },

    mortgage_interest: (i, c) => {
        const s = symbolOf(c);
        const out = loanTool(i, c);

        if (out.empty || out.error) {
            return out;
        }

        const result = amortize({ principal: i.amount, annualRate: P(i.rate), years: i.years });
        const first = result.years[0];
        const cap = 750000;
        const share = i.amount > cap ? cap / i.amount : 1;
        const tax = P(or0(i.tax_rate));

        return {
            value: money(first.interest, s),
            label: 'Interest in the first year',
            sub: `${money(result.totalInterest, s)} over the whole loan`,
            rows: {
                total: money(result.totalInterest, s),
                deduction: tax ? `${money(first.interest * share * tax, s)} first-year tax saving if you itemize${share < 1 ? ' (interest on $750,000 of debt)' : ''}` : 'Enter your tax rate',
                share: pct(first.interest / first.paid),
                payment: out.value,
            },
            grids: out.grids,
            plots: { chart: { series: result.years.map((row) => [row.year, row.interest]), series2: result.years.map((row) => [row.year, row.principal]), legend: ['Interest', 'Principal'], xLabel: 'Year', yLabel: s } },
        };
    },

    student_plans: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.balance, i.rate) || i.balance <= 0) {
            return { empty: 'Enter the balance and rate.' };
        }

        const r = P(i.rate) / 12;
        const standard = amortize({ principal: i.balance, annualRate: P(i.rate), years: 10 });
        const extended = amortize({ principal: i.balance, annualRate: P(i.rate), years: 25 });
        // Graduated: five 24-month steps rising by equal amounts; no payment below the interest or above 3× another (34 CFR 685.208).
        const graduated = (start, step) => {
            let b = i.balance;
            let paid = 0;

            for (let m = 0; m < 120; m += 1) {
                const pay = start + step * Math.floor(m / 24);
                b = b * (1 + r) - pay;
                paid += pay;
            }

            return { b, paid };
        };
        // Smallest equal step that repays the loan in 10 years when the first payment is the interest.
        const stepFor = (start) => {
            let lo = 0;
            let hi = i.balance;

            for (let k = 0; k < 100; k += 1) {
                const mid = (lo + hi) / 2;

                if (graduated(start, mid).b > 0) {
                    lo = mid;
                } else {
                    hi = mid;
                }
            }

            return hi;
        };
        let first = i.balance * r;
        let step = stepFor(first);

        if (first + 4 * step > 3 * first) {
            // Too steep: keep the last payment at 3× the first (step = first ÷ 2) and solve for the first payment.
            let lo = i.balance * r;
            let hi = i.balance;

            for (let k = 0; k < 100; k += 1) {
                const mid = (lo + hi) / 2;

                if (graduated(mid, mid / 2).b > 0) {
                    lo = mid;
                } else {
                    hi = mid;
                }
            }

            first = hi;
            step = first / 2;
        }

        const g = graduated(first, step);
        const eligibleExtended = i.balance > 30000;

        return {
            value: money(standard.level, s),
            label: 'Standard plan payment (10 years)',
            sub: `${money(standard.totalInterest, s)} interest in total`,
            rows: {
                standard: `${money(standard.level, s)} a month, ${money(standard.totalPaid, s)} in total`,
                graduated: `${money(first, s)} rising to ${money(first + 4 * step, s)} every two years, ${money(g.paid, s)} in total (estimate)`,
                extended: eligibleExtended ? `${money(extended.level, s)} a month for 25 years, ${money(extended.totalPaid, s)} in total` : `${money(extended.level, s)} for 25 years (needs over $30,000 of Direct Loans)`,
                note: 'Income-driven plans (IBR, RAP from July 2026) set payments from income instead',
            },
        };
    },

    forgiveness: (i, c) => {
        const plans = { pslf: [120, 'PSLF: 120 qualifying payments while working full-time for government or a non-profit'], ibr_new: [240, 'IBR (new borrowers after July 1, 2014): 20 years'], ibr_old: [300, 'IBR (earlier borrowers): 25 years'], icr: [300, 'ICR: 25 years'], paye: [240, 'PAYE: 20 years'], rap: [360, 'RAP (from July 1, 2026): 30 years'] };
        const [needed, text] = plans[i.plan] ?? plans.pslf;

        if (!ok(i.made) || !i.start) {
            return { empty: 'Enter the payments already counted and today\'s date.' };
        }

        const left = Math.max(0, needed - Math.round(i.made));
        const [y, m] = String(i.start).split('-').map(Number);
        const months = (y * 12 + (m - 1)) + left;
        const date = new Date(Date.UTC(Math.floor(months / 12), months % 12, 1));
        const forgiven = ok(i.balance) ? i.balance : NaN;

        return {
            value: left === 0 ? 'Eligible now' : date.toLocaleDateString('en-US', { month: 'long', year: 'numeric', timeZone: 'UTC' }),
            label: 'Forgiveness from about',
            sub: left === 0 ? 'You have the required qualifying payments' : `${num(left)} more qualifying payments (${durationText(left)})`,
            rows: {
                plan: text,
                left: `${num(left)} payments`,
                progress: pct(Math.min(1, Math.round(i.made) / needed)),
                tax: i.plan === 'pslf' ? 'PSLF forgiveness is not taxable income' : 'The federal tax exclusion for IDR forgiveness (ARPA) ended with 2025, so forgiveness from 2026 may be taxable income',
                amount: Number.isFinite(forgiven) ? `${money(forgiven, symbolOf(c))} today; the amount forgiven depends on the payments made until then` : 'Enter the balance (optional)',
            },
        };
    },

    post_judgment: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.amount, i.rate, i.days) || i.amount <= 0) {
            return { empty: 'Enter the judgment, rate and days.' };
        }

        const years = i.days / 365;
        const federal = i.method !== 'simple';
        // 28 U.S.C. 1961(b): computed daily, compounded annually.
        const interest = federal ? i.amount * ((1 + P(i.rate)) ** Math.floor(years) * (1 + P(i.rate) * (years - Math.floor(years))) - 1) : i.amount * P(i.rate) * years;

        return {
            value: money(interest, s),
            label: 'Post-judgment interest',
            sub: `${num(i.days)} days at ${pct(P(i.rate))}, ${federal ? 'compounded annually (federal)' : 'simple (many states)'}`,
            rows: { daily: money((i.amount * P(i.rate)) / 365, s), total: money(i.amount + interest, s), years: num(years), basis: federal ? 'Federal: weekly average 1-year Treasury yield for the week before judgment' : 'State statutory rate' },
        };
    },

    pmi: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.value, i.amount, i.rate, i.pmi, i.years) || i.value <= 0) {
            return { empty: 'Enter the home value, loan, rate, PMI rate and term.' };
        }

        const ltv = i.amount / i.value;
        const monthly = (i.amount * P(i.pmi)) / 12;
        const result = amortize({ principal: i.amount, annualRate: P(i.rate), years: i.years, extra: or0(i.extra) });
        const request = result.rows.findIndex((row) => row.balance <= 0.8 * i.value) + 1;
        const auto = result.rows.findIndex((row) => row.balance <= 0.78 * i.value) + 1;

        if (ltv <= 0.8) {
            return { value: money(0, s), label: 'Monthly PMI', sub: 'No PMI: the loan is 80% of value or less', rows: { ltv: pct(ltv), request: '—', auto: '—', total: money(0, s) } };
        }

        return {
            value: money(monthly, s),
            label: 'Monthly PMI',
            sub: `${pct(P(i.pmi))} a year at ${pct(ltv)} LTV`,
            rows: { ltv: pct(ltv), request: `Month ${request} (${durationText(request)}): you can ask to cancel at 80%`, auto: `Month ${auto} (${durationText(auto)}): ends automatically at 78%`, total: money(monthly * auto, s) },
        };
    },

    rental: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.price, i.rent, i.rate, i.years) || i.price <= 0) {
            return { empty: 'Enter price, rent, loan rate and term.' };
        }

        const down = i.price * P(or0(i.down));
        const loan = i.price - down;
        const closing = or0(i.closing);
        const level = loan > 0 ? payment(loan, P(i.rate) / 12, i.years * 12) : 0;
        const effectiveRent = i.rent * 12 * (1 - P(or0(i.vacancy)));
        const expenses = i.price * P(or0(i.tax)) + or0(i.insurance) + i.rent * 12 * P(or0(i.management)) + i.price * P(or0(i.maintenance)) + or0(i.hoa) * 12;
        const noi = effectiveRent - expenses;
        const cash = noi - level * 12;
        const invested = down + closing;
        const hold = Math.round(ok(i.hold) ? i.hold : 10);
        const flows = [-invested];
        let rent = effectiveRent;
        let cost = expenses;

        for (let y = 1; y <= hold; y += 1) {
            let flow = rent - cost - level * 12;

            if (y === hold) {
                const value = i.price * (1 + P(or0(i.appreciation))) ** hold;
                const left = Math.max(0, balanceAfter(loan, P(i.rate) / 12, level, Math.min(hold, i.years) * 12));
                flow += value * (1 - P(or0(i.selling))) - left;
            }

            flows.push(flow);
            rent *= 1 + P(or0(i.rent_growth));
            cost *= 1 + P(or0(i.rent_growth));
        }

        const irr = irrs(flows)[0];

        return {
            value: money(cash / 12, s),
            label: 'Monthly cash flow',
            sub: `${money(cash, s)} a year after the ${money(level, s)} mortgage payment`,
            rows: {
                noi: money(noi, s),
                cap: pct(noi / i.price),
                coc: invested > 0 ? pct(cash / invested) : '—',
                irr: Number.isFinite(irr) ? `${pct(irr)} over ${hold} years including the sale` : 'No IRR (cash flows do not change sign)',
                invested: money(invested, s),
                grm: `${num(i.price / (i.rent * 12))}×`,
            },
        };
    },

    rent_or_buy: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.price, i.rent, i.rate, i.years) || i.price <= 0 || i.years < 1) {
            return { empty: 'Enter the price, rent, mortgage rate and years.' };
        }

        const years = Math.round(i.years);
        const down = i.price * P(or0(i.down));
        const loan = i.price - down;
        const level = payment(loan, P(i.rate) / 12, 30 * 12);
        const ret = P(or0(i.invest));
        let renterPortfolio = down + i.price * P(or0(i.buy_costs));
        let rent = i.rent;
        let value = i.price;
        const series = [];
        const series2 = [];
        let crossover = null;

        for (let y = 1; y <= years; y += 1) {
            const owning = level * 12 + value * (P(or0(i.tax)) + P(or0(i.maintenance))) + or0(i.insurance);
            const renting = rent * 12 + or0(i.renters_insurance);
            // Whoever pays less each year invests the difference at the investment return.
            renterPortfolio = renterPortfolio * (1 + ret) + (owning - renting);
            value *= 1 + P(or0(i.appreciation));
            rent *= 1 + P(or0(i.rent_growth));
            const balance = Math.max(0, balanceAfter(loan, P(i.rate) / 12, level, y * 12));
            const ownerWealth = value * (1 - P(or0(i.sell_costs))) - balance;
            series.push([y, ownerWealth]);
            series2.push([y, renterPortfolio]);

            if (crossover === null && ownerWealth > renterPortfolio) {
                crossover = y;
            }
        }

        const [owner, renter] = [series[series.length - 1][1], series2[series2.length - 1][1]];

        return {
            value: owner >= renter ? 'Buying' : 'Renting',
            label: `Comes out ahead after ${years} years`,
            sub: `by ${money0(Math.abs(owner - renter), s)} in net wealth`,
            rows: { owner: money0(owner, s), renter: money0(renter, s), crossover: crossover ? `Buying pulls ahead in year ${crossover}` : 'Buying does not pull ahead in this period', payment: money(level, s) },
            plots: { chart: { series, series2, legend: ['Buy: home equity after selling costs', 'Rent: invested savings'], xLabel: 'Year', yLabel: s } },
        };
    },

    offer: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.list, i.comps, i.area)) {
            return { empty: 'Enter the list price, comparable price per square foot and size.' };
        }

        const value = i.comps * i.area;
        const ratio = P(ok(i.ratio) ? i.ratio : 100);
        const dom = or0(i.dom);
        // Listings that have sat longer than the local norm leave more room to negotiate (a rule of thumb, 1% per 30 extra days, capped at 5%).
        const room = Math.min(0.05, Math.max(0, (dom - or0(i.typical_dom)) / 30) * 0.01);
        const offer = Math.min(i.list, value) * ratio * (1 - room);

        return {
            value: money0(offer, s),
            label: 'Suggested opening offer',
            sub: `market value from comparables ${money0(value, s)}`,
            rows: { value: money0(value, s), gap: pct(i.list / value - 1), room: pct(room), range: `${money0(offer * 0.98, s)} – ${money0(Math.min(i.list, value * ratio), s)}` },
        };
    },

    arv: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.arv, i.repairs)) {
            return { empty: 'Enter the after-repair value and repair costs.' };
        }

        const rule = P(ok(i.rule) ? i.rule : 70);
        const max = i.arv * rule - i.repairs;
        const profit = ok(i.purchase) ? i.arv - i.purchase - i.repairs - i.arv * P(or0(i.costs)) : NaN;

        return {
            value: money0(max, s),
            label: 'Maximum offer (70% rule)',
            sub: `${pct(rule)} of ${money0(i.arv, s)} minus ${money0(i.repairs, s)} repairs`,
            rows: { profit: Number.isFinite(profit) ? money0(profit, s) : 'Enter a purchase price', margin: Number.isFinite(profit) ? pct(profit / i.arv) : '—', all: ok(i.purchase) ? money0(i.purchase + i.repairs, s) : '—', rule: `${pct(rule)} leaves about ${pct(1 - rule)} for holding, selling costs and profit` },
        };
    },

    commercial_lease: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.area, i.base) || i.area <= 0) {
            return { empty: 'Enter the area and base rent per square foot.' };
        }

        const extras = i.type === 'gross' ? 0 : i.type === 'modified' ? or0(i.cam) : or0(i.cam) + or0(i.taxes) + or0(i.insurance);
        const yearly = (i.base + extras) * i.area;
        const term = Math.round(or0(i.term) || 1);
        let total = 0;
        let year = yearly;

        for (let y = 0; y < term; y += 1) {
            total += year;
            year *= 1 + P(or0(i.escalation));
        }

        return {
            value: money(yearly / 12, s),
            label: 'Monthly rent',
            sub: `${money(i.base + extras, s)} per ft² a year, ${i.type === 'gross' ? 'gross' : i.type === 'modified' ? 'modified gross' : 'triple net'}`,
            rows: { yearly: money(yearly, s), extras: money(extras * i.area, s), total: `${money(total, s)} over ${term} years`, monthlyFt: money((i.base + extras) / 12, s) },
        };
    },

    pagibig: (i, c) => {
        const s = symbolOf(c);
        const table = c.data.pagibig;
        const preset = table.rates[i.period];
        const r = ok(i.rate) ? P(i.rate) : preset;

        if (!ok(i.amount, i.years) || i.amount <= 0 || !Number.isFinite(r)) {
            return { empty: 'Enter the loan, term and repricing period.' };
        }

        if (i.years > 30) {
            return { error: 'Pag-IBIG housing loans run up to 30 years.' };
        }

        const result = amortize({ principal: i.amount, annualRate: r, years: i.years });
        const income = ok(i.income) ? i.income : NaN;

        return {
            value: money(result.level, s),
            label: 'Monthly amortization',
            sub: `${pct(r)} fixed for the ${i.period}-year repricing period`,
            rows: { rate: ok(i.rate) ? `${pct(r)} (your rate)` : `${pct(preset)} (${table.source})`, interest: money(result.totalInterest, s), total: money(result.totalPaid, s), income: Number.isFinite(income) ? `${pct(result.level / income)} of gross monthly income (Pag-IBIG allows up to 35%)` : 'Enter income' },
            grids: { schedule: scheduleGrid(result, s) },
        };
    },
};

export default defineTools(handlers);
