import { formatMoney, getCurrency } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { num, pct, yearGrid } from '../finance/common.js';

/**
 * Indian personal finance: SIP, lump sum, SWP, RD and FD (bank methods), PPF, Sukanya Samriddhi, POMIS, EPF, NPS,
 * Atal Pension Yojana, HRA exemption, gratuity, TDS interest and the new vs old income-tax regime (FY 2026-27).
 * Notified rates come from config/finance_data.php and can be overridden on each page.
 */
const P = (value) => value / 100;
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
const S = 'INR';

/**
 * Rupees with Indian lakh/crore grouping: ₹12,34,567.
 */
export const inr = (value, decimals = 0) => formatMoney(value, { code: 'INR', decimals });

// Calculators that are general maths (SIP, lump sum, SWP, FD, RD) follow the page's display currency, rupees by default.
const moneyIn = (c) => (value, decimals = 0) => formatMoney(value, { code: c.sym ?? getCurrency(), decimals });
const amountText = (c, value) => ((c.sym ?? getCurrency()) === 'INR' ? lakh(value) : moneyIn(c)(value));

const lakh = (value) => (Math.abs(value) >= 1e7 ? `${num(value / 1e7)} crore` : Math.abs(value) >= 1e5 ? `${num(value / 1e5)} lakh` : inr(value));

/**
 * SIP future value with monthly instalments at the start of each month (annuity due), monthly rate = annual ÷ 12,
 * and an optional yearly step-up. Returns yearly rows.
 */
export function sip(monthly, annual, years, stepUp = 0, lump = 0) {
    const r = annual / 12;
    let balance = lump;
    let invested = lump;
    let instalment = monthly;
    const rows = [];

    for (let m = 1; m <= Math.round(years * 12); m += 1) {
        balance = (balance + instalment) * (1 + r);
        invested += instalment;

        if (m % 12 === 0) {
            rows.push({ year: m / 12, deposits: invested, interest: balance - invested, balance });
            instalment *= 1 + stepUp;
        }
    }

    return { balance, invested, rows };
}

const growthPlot = (rows, start = 0) => ({ series: [[0, start], ...rows.map((r) => [r.year, r.balance])], series2: [[0, start], ...rows.map((r) => [r.year, r.deposits])], legend: ['Value', 'Invested'], xLabel: 'Year', yLabel: S });

function slabTax(income, slabs) {
    let tax = 0;

    slabs.forEach(([from, rate], k) => {
        const to = k + 1 < slabs.length ? slabs[k + 1][0] : Infinity;

        if (income > from) {
            tax += (Math.min(income, to) - from) * rate;
        }
    });

    return tax;
}

function withSurchargeAndCess(tax, income, t, capped) {
    const row = [...t.surcharge].reverse().find(([from]) => income > from);
    const rate = row ? (capped ? Math.min(row[1], 0.25) : row[1]) : 0;

    return { surcharge: tax * rate, cess: tax * (1 + rate) * t.cess, total: tax * (1 + rate) * (1 + t.cess) };
}

/**
 * New regime (section 115BAC): slab tax, ₹60,000 rebate up to ₹12 lakh with marginal relief just above it.
 */
export function newRegime(t, taxable) {
    let tax = slabTax(taxable, t.new.slabs);

    if (taxable <= t.new.rebate_limit) {
        tax = Math.max(0, tax - t.new.rebate_max);
    } else {
        tax = Math.min(tax, taxable - t.new.rebate_limit);
    }

    return { base: tax, ...withSurchargeAndCess(tax, taxable, t, true) };
}

export function oldRegime(t, taxable, age = 'below60') {
    const slabs = age === 'super' ? t.old.slabs_super : age === 'senior' ? t.old.slabs_senior : t.old.slabs;
    let tax = slabTax(taxable, slabs);

    if (taxable <= t.old.rebate_limit) {
        tax = Math.max(0, tax - t.old.rebate_max);
    }

    return { base: tax, ...withSurchargeAndCess(tax, taxable, t, false) };
}

export const handlers = {
    sip: (i, c) => {
        const inr = moneyIn(c);
        if (!ok(i.rate, i.years) || i.years <= 0 || !(or0(i.monthly) > 0 || or0(i.lump) > 0)) {
            return { empty: 'Enter the monthly SIP (or a lump sum), expected return and years.' };
        }

        const r = sip(or0(i.monthly), P(i.rate), i.years, P(or0(i.stepup)), or0(i.lump));

        return {
            value: inr(r.balance),
            label: 'Expected value',
            sub: `${amountText(c, r.balance)} from ${inr(r.invested)} invested`,
            rows: { invested: inr(r.invested), gains: inr(r.balance - r.invested), multiple: `${num(r.balance / r.invested)}×`, xirr: pct(P(i.rate)) },
            grids: { schedule: yearGrid(r.rows, [['Invested', 'deposits'], ['Gains', 'interest'], ['Value', 'balance']], inr) },
            plots: { chart: { ...growthPlot(r.rows, or0(i.lump)), yLabel: c.sym ?? getCurrency() } },
        };
    },

    lumpsum: (i, c) => {
        const inr = moneyIn(c);
        if (!ok(i.amount, i.rate, i.years) || i.amount <= 0) {
            return { empty: 'Enter the amount, expected return and years.' };
        }

        const value = i.amount * (1 + P(i.rate)) ** i.years;

        return {
            value: inr(value),
            label: 'Expected value',
            sub: `${amountText(c, value)} after ${num(i.years)} years`,
            rows: { invested: inr(i.amount), gains: inr(value - i.amount), multiple: `${num(value / i.amount)}×`, doubling: `${num(Math.log(2) / Math.log(1 + P(i.rate)))} years to double` },
        };
    },

    elss: (i, c) => {
        const t = c.data.india;
        const lumpMode = i.mode === 'lump';

        if (!ok(i.amount, i.rate, i.years) || i.amount <= 0) {
            return { empty: 'Enter the amount, return and years.' };
        }

        const r = lumpMode ? { balance: i.amount * (1 + P(i.rate)) ** i.years, invested: i.amount } : sip(i.amount, P(i.rate), i.years);
        const yearly = lumpMode ? i.amount : i.amount * 12;
        const deduction = Math.min(yearly, t.old.cap_80c);
        const saving = deduction * P(or0(i.slab)) * (1 + t.cess);

        return {
            value: inr(r.balance),
            label: 'Expected value',
            sub: `from ${inr(r.invested)} invested; each investment is locked in for 3 years`,
            rows: { gains: inr(r.balance - r.invested), tax: `${inr(saving)} a year under section 80C (old regime only, up to ₹1.5 lakh)`, ltcg: 'Gains over ₹1.25 lakh a year are taxed at 12.5% on redemption', lockin: lumpMode ? 'Redeemable after 3 years' : 'Each SIP instalment unlocks 3 years after it is made' },
        };
    },

    swp: (i, c) => {
        const inr = moneyIn(c);
        if (!ok(i.corpus, i.withdrawal, i.rate, i.years) || i.corpus <= 0) {
            return { empty: 'Enter the corpus, monthly withdrawal, return and years.' };
        }

        const r = P(i.rate) / 12;
        let balance = i.corpus;
        let withdrawn = 0;
        let lasted = null;
        const rows = [];

        for (let m = 1; m <= Math.round(i.years * 12); m += 1) {
            const take = Math.min(i.withdrawal, balance);
            balance = (balance - take) * (1 + r);
            withdrawn += take;

            if (balance <= 0.5 && lasted === null) {
                lasted = m;
            }

            if (m % 12 === 0) {
                rows.push({ year: m / 12, deposits: withdrawn, interest: 0, balance: Math.max(0, balance) });
            }
        }

        return {
            value: inr(Math.max(0, balance)),
            label: 'Balance at the end',
            sub: lasted ? `The corpus runs out in month ${lasted}` : `after withdrawing ${inr(withdrawn)} over ${num(i.years)} years`,
            rows: { withdrawn: inr(withdrawn), sustainable: `${inr(i.corpus * r)} a month keeps the corpus intact`, rate: pct((i.withdrawal * 12) / i.corpus), lasts: lasted ? `${num(lasted / 12)} years` : 'Lasts the whole period' },
            grids: { schedule: { columns: ['Withdrawn so far', 'Balance'], rows: rows.map((row) => ({ header: String(row.year), cells: [inr(row.deposits), inr(row.balance)] })), roomy: true } },
        };
    },

    rd: (i, c) => {
        const inr = moneyIn(c);
        if (!ok(i.monthly, i.rate, i.months) || i.monthly <= 0 || i.months <= 0) {
            return { empty: 'Enter the monthly deposit, rate and months.' };
        }

        // Banks compound RDs quarterly: each instalment grows for its remaining months at (1 + r/4)^(months/3).
        const n = Math.round(i.months);
        let maturity = 0;

        for (let k = 1; k <= n; k += 1) {
            maturity += i.monthly * (1 + P(i.rate) / 4) ** ((n - k + 1) / 3);
        }

        const invested = i.monthly * n;

        return {
            value: inr(maturity),
            label: 'Maturity value',
            sub: `${inr(invested)} deposited over ${num(n)} months`,
            rows: { interest: inr(maturity - invested), invested: inr(invested), effective: pct((maturity / invested) ** (12 / ((n + 1) / 2)) - 1), tds: maturity - invested > 50000 ? 'TDS of 10% applies to interest over ₹50,000 a year (₹1 lakh for seniors)' : 'Below the ₹50,000 TDS threshold' },
        };
    },

    fd: (i, c) => {
        const inr = moneyIn(c);
        if (!ok(i.amount, i.rate, i.months) || i.amount <= 0 || i.months <= 0) {
            return { empty: 'Enter the deposit, rate and tenure.' };
        }

        const rate = P(i.rate + or0(i.senior));
        const years = i.months / 12;
        // Under 6 months banks pay simple interest; otherwise interest compounds quarterly.
        const maturity = i.months < 6 ? i.amount * (1 + rate * years) : i.amount * (1 + rate / 4) ** (4 * years);
        const interest = maturity - i.amount;

        return {
            value: inr(maturity),
            label: 'Maturity value',
            sub: `${inr(interest)} interest at ${pct(rate)} ${i.months < 6 ? 'simple' : 'compounded quarterly'}`,
            rows: { interest: inr(interest), yield: pct((maturity / i.amount) ** (1 / years) - 1), quarterly: inr((i.amount * rate) / 4), monthly: inr((i.amount * rate) / 12 / (1 + rate / 12)) },
        };
    },

    ppf: (i, c) => {
        const t = c.data.smallsavings;
        const rate = P(ok(i.rate) ? i.rate : t.ppf);
        const years = Math.round(ok(i.years) ? i.years : 15);

        if (!ok(i.yearly) || i.yearly < 500 || i.yearly > 150000) {
            return { error: 'PPF deposits are ₹500 to ₹1.5 lakh a year.' };
        }

        let balance = 0;
        const rows = [];

        // Deposited by April 5 each year, interest compounds yearly at the notified rate.
        for (let y = 1; y <= years; y += 1) {
            balance = (balance + i.yearly) * (1 + rate);
            rows.push({ year: y, deposits: i.yearly * y, interest: balance - i.yearly * y, balance });
        }

        return {
            value: inr(balance),
            label: `Maturity value after ${years} years`,
            sub: `${inr(i.yearly * years)} deposited at ${pct(rate)} (${t.quarter} rate)`,
            rows: { invested: inr(i.yearly * years), interest: inr(balance - i.yearly * years), tax: 'Tax-free (EEE): deposits qualify for 80C in the old regime, interest and maturity are exempt', extension: 'Can be extended in blocks of 5 years, with or without deposits' },
            grids: { schedule: yearGrid(rows, [['Deposited', 'deposits'], ['Interest', 'interest'], ['Balance', 'balance']], inr) },
        };
    },

    ssy: (i, c) => {
        const t = c.data.smallsavings;
        const rate = P(ok(i.rate) ? i.rate : t.ssy);

        if (!ok(i.yearly, i.age) || i.yearly < 250 || i.yearly > 150000 || i.age > 10) {
            return { error: 'Enter yearly deposits of ₹250 to ₹1.5 lakh for a girl aged 10 or under.' };
        }

        let balance = 0;
        const rows = [];

        // Deposits for 15 years from opening; the account matures 21 years after opening.
        for (let y = 1; y <= 21; y += 1) {
            balance = (balance + (y <= 15 ? i.yearly : 0)) * (1 + rate);
            rows.push({ year: y, deposits: i.yearly * Math.min(y, 15), interest: balance - i.yearly * Math.min(y, 15), balance });
        }

        const start = Number(i.start ?? 2026);

        return {
            value: inr(balance),
            label: 'Maturity value at 21 years',
            sub: `when she is ${num(i.age + 21)}, in ${start + 21}`,
            rows: { invested: inr(i.yearly * 15), interest: inr(balance - i.yearly * 15), rate: `${pct(rate)} (${t.quarter}, reset quarterly)`, withdrawal: `Up to 50% for education from age 18 (${start + Math.max(0, 18 - i.age)})` },
            grids: { schedule: yearGrid(rows, [['Deposited', 'deposits'], ['Interest', 'interest'], ['Balance', 'balance']], inr) },
        };
    },

    pomis: (i, c) => {
        const t = c.data.smallsavings;
        const rate = P(ok(i.rate) ? i.rate : t.pomis);
        const max = i.account === 'joint' ? 1500000 : 900000;

        if (!ok(i.amount) || i.amount < 1000) {
            return { empty: 'Enter a deposit of at least ₹1,000.' };
        }

        if (i.amount > max) {
            return { error: `The limit is ${inr(max)} for a ${i.account === 'joint' ? 'joint' : 'single'} account.` };
        }

        const monthly = (i.amount * rate) / 12;

        return {
            value: inr(monthly, 2),
            label: 'Monthly income',
            sub: `on ${inr(i.amount)} at ${pct(rate)} for 5 years`,
            rows: { yearly: inr(monthly * 12, 2), total: inr(monthly * 60, 2), maturity: `${inr(i.amount)} returned after 5 years`, tax: 'Interest is taxable; no TDS by the post office' },
        };
    },

    epf: (i, c) => {
        const t = c.data.epf;

        if (!ok(i.basic, i.age) || i.basic <= 0 || i.age >= 58) {
            return { empty: 'Enter monthly basic + DA and your age (under 58).' };
        }

        const rate = P(ok(i.rate) ? i.rate : t.rate);
        const growth = P(or0(i.growth));
        let balance = or0(i.balance);
        let basic = i.basic;
        let contributed = 0;
        const rows = [];

        for (let y = 1; y <= 58 - Math.round(i.age); y += 1) {
            let interest = 0;

            for (let m = 0; m < 12; m += 1) {
                const employee = basic * P(ok(i.percent) ? i.percent : 12);
                const eps = Math.min(basic, t.wage_ceiling) * t.eps;
                const employer = basic * t.employee - eps;
                balance += employee + employer;
                contributed += employee + employer;
                // Interest accrues on the monthly running balance and is credited at the year end.
                interest += balance * (rate / 12);
            }

            balance += interest;
            rows.push({ year: Math.round(i.age) + y, deposits: contributed, interest: balance - contributed - or0(i.balance), balance });
            basic *= 1 + growth;
        }

        return {
            value: inr(balance),
            label: 'EPF corpus at 58',
            sub: `${lakh(balance)} at ${pct(rate)} (rate for ${t.year})`,
            rows: { contributed: inr(contributed), interest: inr(balance - contributed - or0(i.balance)), eps: `${inr(Math.min(i.basic, t.wage_ceiling) * t.eps)} a month goes to EPS (pension), not EPF`, monthly: inr(i.basic * (P(ok(i.percent) ? i.percent : 12) + t.employee) - Math.min(i.basic, t.wage_ceiling) * t.eps) },
            grids: { schedule: yearGrid(rows, [['Contributed', 'deposits'], ['Interest', 'interest'], ['Balance', 'balance']], inr) },
        };
    },

    nps: (i, c) => {
        const t = c.data.nps;

        if (!ok(i.monthly, i.age, i.rate) || i.age >= 60) {
            return { empty: 'Enter the monthly contribution, age and expected return.' };
        }

        const years = 60 - i.age;
        const r = sip(i.monthly, P(i.rate), years, P(or0(i.stepup)), or0(i.balance));
        const lumpShare = Math.min(P(ok(i.lump) ? i.lump : 80), i.sector === 'govt' ? t.lump_govt : t.lump_private);
        const full = r.balance <= t.full_withdrawal_up_to;
        const lump = full ? r.balance : r.balance * lumpShare;
        const annuity = r.balance - lump;
        const pension = (annuity * P(or0(i.annuity_rate))) / 12;

        return {
            value: inr(r.balance),
            label: 'Corpus at 60',
            sub: `${lakh(r.balance)} from ${inr(r.invested)} contributed`,
            rows: { lump: `${inr(lump)} (${full ? '100%: corpus up to ₹8 lakh' : pct(lumpShare)}) tax-free up to 60%`, annuity: inr(annuity), pension: `${inr(pension)} a month at ${pct(P(or0(i.annuity_rate)))}`, rules: i.sector === 'govt' ? 'Government subscribers: at least 40% buys an annuity' : 'Non-government subscribers: up to 80% lump sum since December 2025' },
            plots: { chart: growthPlot(r.rows, or0(i.balance)) },
        };
    },

    apy: (i, c) => {
        const t = c.data.apy;
        const age = Math.round(i.age);
        const k = t.pensions.indexOf(Number(i.pension));

        if (!(age >= 18 && age <= 40) || k < 0) {
            return { error: 'Atal Pension Yojana is open from age 18 to 40.' };
        }

        const monthly = t.chart[String(age)][k];
        const months = (60 - age) * 12;

        return {
            value: inr(monthly),
            label: 'Monthly contribution',
            sub: `until 60 for a ${inr(t.pensions[k])} monthly pension`,
            rows: { total: inr(monthly * months), months: num(months), corpus: `${inr(t.corpus[k])} returned to the nominee`, quarterly: inr(monthly * 3) },
        };
    },

    hra: (i) => {
        if (!ok(i.basic, i.hra, i.rent)) {
            return { empty: 'Enter basic + DA, HRA received and rent paid.' };
        }

        const yearly = i.period === 'month' ? 12 : 1;
        const basic = i.basic * yearly;
        const hra = i.hra * yearly;
        const rent = i.rent * yearly;
        const a = hra;
        const b = Math.max(0, rent - 0.1 * basic);
        const cc = basic * (i.metro ? 0.5 : 0.4);
        const exempt = Math.min(a, b, cc);

        return {
            value: inr(exempt),
            label: 'HRA exemption a year',
            sub: 'least of HRA received, rent − 10% of basic, and 50% (metro) or 40% of basic',
            rows: { received: inr(a), rent: inr(b), share: `${inr(cc)} (${i.metro ? '50%' : '40%'} of basic)`, taxable: inr(hra - exempt), regime: 'Available only in the old tax regime' },
        };
    },

    gratuity: (i, c) => {
        const t = c.data.gratuity;

        if (!ok(i.salary, i.years) || i.salary <= 0) {
            return { empty: 'Enter the last drawn basic + DA and years of service.' };
        }

        const covered = i.covered !== 'no';
        // Covered employees: part-years over 6 months count as a full year; others: completed years only.
        const years = covered ? Math.floor(i.years) + (or0(i.months) > 6 ? 1 : 0) : Math.floor(i.years);
        const amount = (i.salary * (covered ? 15 / 26 : 15 / 30)) * years;
        const eligible = covered ? i.years >= 5 || i.fixed_term : true;
        const cap = i.employer === 'central' ? t.ceiling_central : t.ceiling_private;

        return {
            value: inr(Math.min(amount, cap)),
            label: 'Gratuity',
            sub: `${inr(i.salary)} × ${covered ? '15/26' : '15/30'} × ${years} years`,
            rows: { years: num(years), eligible: eligible ? 'Eligible' : 'Usually payable after 5 years of service (1 year for fixed-term employees under the Code on Social Security)', taxfree: `Up to ${inr(cap)} tax-free`, taxable: inr(Math.max(0, amount - cap)) },
        };
    },

    tds_interest: (i) => {
        if (!ok(i.amount) || i.amount <= 0 || !i.from || !i.to) {
            return { empty: 'Enter the TDS amount and the two dates.' };
        }

        const [y1, m1, d1] = String(i.from).split('-').map(Number);
        const [y2, m2, d2] = String(i.to).split('-').map(Number);

        if (!y1 || !y2 || y2 * 400 + m2 * 32 + d2 < y1 * 400 + m1 * 32 + d1) {
            return { error: 'The end date must be after the start date.' };
        }

        // Section 201(1A): interest for every month or part of a month, counted from the start date.
        let months = (y2 - y1) * 12 + (m2 - m1) + 1;

        if (d2 < d1) {
            months -= 1;
        }

        months = Math.max(1, months);
        const rate = i.type === 'not_paid' ? 0.015 : 0.01;
        const interest = i.amount * rate * months;

        return {
            value: inr(interest),
            label: 'Interest on late TDS',
            sub: `${pct(rate)} a month for ${months} month${months === 1 ? '' : 's'} (part months count in full)`,
            rows: { months: num(months), rate: `${pct(rate)} a month (${i.type === 'not_paid' ? 'deducted but not paid' : 'not deducted'})`, total: inr(i.amount + interest), note: 'Pay it before filing the TDS return; late filing fees (section 234E) are separate' },
        };
    },

    regime: (i, c) => {
        const t = c.data.india;

        if (!ok(i.salary) || i.salary < 0) {
            return { empty: 'Enter your salary.' };
        }

        const gross = i.salary + or0(i.other);
        const employerNps = or0(i.employer_nps);
        const newTaxable = Math.max(0, gross - (i.salary > 0 ? t.new.standard : 0) - Math.min(employerNps, i.salary * 0.14));
        const oldDeductions = (i.salary > 0 ? t.old.standard : 0) + Math.min(or0(i.c80), t.old.cap_80c) + or0(i.d80) + or0(i.hra_exempt) + Math.min(or0(i.home_interest), t.old.cap_24b) + Math.min(or0(i.nps), t.old.cap_nps) + or0(i.other_ded) + Math.min(employerNps, i.salary * 0.1);
        const oldTaxable = Math.max(0, gross - oldDeductions);
        const n = newRegime(t, newTaxable);
        const o = oldRegime(t, oldTaxable, i.age ?? 'below60');
        const better = n.total <= o.total ? 'New regime' : 'Old regime';

        return {
            value: better,
            label: `Lower tax for FY ${t.fy}`,
            sub: `saves ${inr(Math.abs(o.total - n.total))} a year`,
            rows: {
                new: `${inr(n.total)} on ${inr(newTaxable)} taxable`,
                old: `${inr(o.total)} on ${inr(oldTaxable)} taxable`,
                deductions: inr(oldDeductions),
                breakeven: (() => {
                    // Extra old-regime deductions that would make the two equal.
                    let lo = 0;
                    let hi = gross;

                    for (let k = 0; k < 60; k += 1) {
                        const mid = (lo + hi) / 2;

                        if (oldRegime(t, Math.max(0, oldTaxable - mid), i.age ?? 'below60').total > n.total) {
                            lo = mid;
                        } else {
                            hi = mid;
                        }
                    }

                    return o.total <= n.total ? 'The old regime already wins' : `${inr(hi)} more deductions would make the old regime equal`;
                })(),
                monthly: `${inr(Math.min(n.total, o.total) / 12)} a month`,
            },
        };
    },
};

export default defineTools(handlers);
