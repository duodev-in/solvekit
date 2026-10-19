import { solve } from './tvm.js';

/**
 * Loans: level payments, amortization schedules (extra payments, interest-only periods, rate resets, balloons),
 * APR including fees, credit card payoff and multi-debt payoff strategies. Rates are annual fractions.
 */

/**
 * Level payment for a loan of `principal` over `n` periods at periodic rate r (balloon left at the end).
 */
export function payment(principal, r, n, balloon = 0) {
    if (!(n > 0)) {
        return NaN;
    }

    if (r === 0) {
        return (principal - balloon) / n;
    }

    return ((principal - balloon / (1 + r) ** n) * r) / (1 - (1 + r) ** -n);
}

/**
 * Balance after k payments of `pmtValue`.
 */
export function balanceAfter(principal, r, pmtValue, k) {
    return r === 0 ? principal - pmtValue * k : principal * (1 + r) ** k - pmtValue * (((1 + r) ** k - 1) / r);
}

/**
 * Full amortization. Options:
 *   principal, annualRate, years, perYear (12), extra (each period), extraYearly (once a year, at period perYear),
 *   lump: { period: amount }, interestOnly (periods), balloon (amount due at the end, payment computed for it),
 *   resets: [{ period, annualRate }] (rate changes from that period; payment re-amortized over the remaining term),
 *   fixedPayment (pay this instead of the level payment).
 * Returns { payment, rows (per period), years (per year), totalInterest, totalPaid, periods, payoffPeriod }.
 */
export function amortize({ principal, annualRate, years, perYear = 12, extra = 0, extraYearly = 0, lump = {}, interestOnly = 0, balloon = 0, resets = [], fixedPayment = null }) {
    const n = Math.round(years * perYear);
    let rate = annualRate / perYear;
    let balance = principal;
    let level = fixedPayment ?? payment(principal, rate, n - interestOnly, balloon);
    const firstPayment = interestOnly > 0 ? principal * rate : level;
    const rows = [];
    let totalInterest = 0;
    let totalPaid = 0;

    for (let p = 1; p <= n && balance > 1e-8; p += 1) {
        const reset = resets.find((x) => x.period === p);

        if (reset) {
            rate = reset.annualRate / perYear;

            if (fixedPayment === null) {
                level = payment(balance, rate, n - p + 1, balloon);
            }
        }

        if (p === interestOnly + 1 && interestOnly > 0 && fixedPayment === null) {
            level = payment(balance, rate, n - interestOnly, balloon);
        }

        const interest = balance * rate;
        let scheduled = p <= interestOnly ? interest : level;

        if (p === n && balloon > 0) {
            scheduled = balance + interest;
        }

        let principalPaid = Math.min(balance, scheduled - interest);
        let extraPaid = Math.min(balance - principalPaid, extra + (p % perYear === 0 ? extraYearly : 0) + (lump[p] ?? 0));
        extraPaid = Math.max(0, extraPaid);

        if (p === n && balloon === 0) {
            principalPaid = balance - extraPaid;
        }

        balance -= principalPaid + extraPaid;
        const paid = interest + principalPaid + extraPaid;
        totalInterest += interest;
        totalPaid += paid;
        rows.push({ period: p, payment: paid, interest, principal: principalPaid + extraPaid, balance: Math.max(0, balance), rate: rate * perYear });

        if (principalPaid + extraPaid < 0 && p > interestOnly) {
            return { error: 'The payment does not cover the interest: the loan would never be repaid.' };
        }
    }

    const yearsRows = [];
    rows.forEach((row) => {
        const y = Math.ceil(row.period / perYear);
        const entry = yearsRows[y - 1] ?? (yearsRows[y - 1] = { year: y, paid: 0, interest: 0, principal: 0, balance: 0 });
        entry.paid += row.payment;
        entry.interest += row.interest;
        entry.principal += row.principal;
        entry.balance = row.balance;
    });

    return { payment: firstPayment, level, rows, years: yearsRows, totalInterest, totalPaid, periods: rows.length, payoffPeriod: rows.length };
}

/**
 * APR (annual, by the actuarial method of Regulation Z Appendix J for regular payments):
 * the rate at which the payments' present value equals the amount financed (loan − prepaid finance charges).
 */
export function apr(amountFinanced, pmtValue, n, perYear = 12) {
    const r = solve((x) => (x === 0 ? pmtValue * n - amountFinanced : (pmtValue * (1 - (1 + x) ** -n)) / x - amountFinanced), 1e-9, 1, 4000);

    return r === null ? NaN : r * perYear;
}

/**
 * Credit card payoff month by month. Minimum payment = max(floor, percent of balance [+ interest]).
 * Interest each month = balance × APR ÷ 12 (an average-daily-balance card with steady balance gives the same).
 */
export function cardPayoff({ balance, apr: annual, payment: fixed = null, minPercent = 0.01, minFloor = 25, plusInterest = true, maxMonths = 1200 }) {
    let b = balance;
    let months = 0;
    let interestTotal = 0;
    const path = [[0, b]];

    while (b > 0.005 && months < maxMonths) {
        const interest = b * (annual / 12);
        let pay = fixed ?? Math.max(minFloor, b * minPercent + (plusInterest ? interest : 0));
        pay = Math.min(pay, b + interest);

        if (pay <= interest && fixed !== null) {
            return { never: true };
        }

        b = b + interest - pay;
        interestTotal += interest;
        months += 1;

        if (months % 12 === 0 || b <= 0.005) {
            path.push([months / 12, Math.max(0, b)]);
        }
    }

    return { months, interest: interestTotal, total: balance + interestTotal, path, never: months >= maxMonths };
}

/**
 * Pays several debts with one monthly budget: minimums on all, the rest to the target debt
 * (highest rate first for avalanche, smallest balance first for snowball). Freed minimums roll over.
 */
export function payoffPlan(debts, budget, method = 'avalanche', maxMonths = 1200) {
    const list = debts.map((d, index) => ({ ...d, index, balance: d.balance }));
    const order = () => list.filter((d) => d.balance > 0.005).sort((a, b) => (method === 'snowball' ? a.balance - b.balance : b.rate - a.rate || a.balance - b.balance));
    const minimums = list.reduce((sum, d) => sum + d.minimum, 0);

    if (budget < minimums) {
        return { error: 'The monthly budget is less than the minimum payments.' };
    }

    let months = 0;
    let interest = 0;
    const finished = [];

    while (list.some((d) => d.balance > 0.005) && months < maxMonths) {
        months += 1;
        list.forEach((d) => {
            if (d.balance > 0.005) {
                const charge = d.balance * (d.rate / 12);
                d.balance += charge;
                interest += charge;
            }
        });
        let money = budget;
        list.forEach((d) => {
            if (d.balance > 0.005) {
                const pay = Math.min(d.minimum, d.balance);
                d.balance -= pay;
                money -= pay;
            }
        });

        for (const d of order()) {
            if (money <= 0) {
                break;
            }

            const pay = Math.min(money, d.balance);
            d.balance -= pay;
            money -= pay;
        }

        list.forEach((d) => {
            if (d.balance <= 0.005 && !finished.some((x) => x.index === d.index)) {
                finished.push({ index: d.index, name: d.name, month: months });
            }
        });

        if (months > 1 && interest > 0 && list.every((d) => d.balance > 0.005) && budget <= list.reduce((s, d) => s + d.balance * (d.rate / 12), 0)) {
            return { error: 'The budget does not cover the interest: the debts would never be repaid.' };
        }
    }

    return months >= maxMonths ? { error: 'Payoff takes longer than 100 years at this budget.' } : { months, interest, finished };
}
