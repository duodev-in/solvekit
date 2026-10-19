import { getCurrency } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { money, money0, num, pct } from '../finance/common.js';
import { parseRows } from '../rows-editor.js';

/**
 * Tax: US federal (2026), FICA and self-employment tax, state income and sales taxes, VAT and GST,
 * UK income tax, NI, SDLT and CGT (2026/27), Australia, the Philippines, Pakistan and Canada.
 * Tables come from config/finance_data.php; every result is an estimate for planning.
 */
const P = (value) => value / 100;
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
// Fixed-currency pages pass `sym` (a currency code); otherwise the page's display currency applies.
const symbolOf = (c) => c.sym ?? getCurrency();

/**
 * Tax on `income` from brackets [[threshold, rate], …] (each rate applies above its threshold).
 * Returns the tax, the marginal rate and the slices per bracket.
 */
export function bracketTax(income, brackets) {
    let tax = 0;
    let marginal = 0;
    const slices = [];

    brackets.forEach(([from, rate], k) => {
        const to = k + 1 < brackets.length ? brackets[k + 1][0] : Infinity;

        if (income > from) {
            const part = Math.min(income, to) - from;
            tax += part * rate;
            marginal = rate;
            slices.push({ from, to, rate, part, tax: part * rate });
        }
    });

    return { tax, marginal, slices };
}

/**
 * Brackets written as [threshold, fixed tax, rate on the excess] (Philippines, Pakistan).
 */
function fixedBracketTax(income, brackets) {
    const row = [...brackets].reverse().find(([from]) => income > from) ?? brackets[0];

    return { tax: row[1] + (income - row[0]) * row[2], marginal: row[2] };
}

const statusOf = (i) => i.status ?? 'single';

/**
 * Federal income tax for 2026 on ordinary income with long-term gains and qualified dividends taxed at 0/15/20%
 * (Schedule D worksheet stacking), less the child tax credit (refundable part capped).
 */
export function federalTax(f, { ordinary, gains = 0, status = 'single', children = 0, otherDependents = 0, deduction = null }) {
    const ded = deduction ?? f.standard[status];
    const taxable = Math.max(0, ordinary + gains - ded);
    const gainsTaxable = Math.min(Math.max(0, gains), taxable);
    const ordinaryTaxable = taxable - gainsTaxable;
    const ordinaryTax = bracketTax(ordinaryTaxable, f.brackets[status]);
    const [zeroTop, fifteenTop] = f.capital_gains[status];
    // Gains stack on top of ordinary income: the part below the 0% ceiling is untaxed, then 15%, then 20%.
    const at0 = Math.max(0, Math.min(taxable, zeroTop) - ordinaryTaxable);
    const at15 = Math.max(0, Math.min(taxable, fifteenTop) - Math.max(ordinaryTaxable, zeroTop));
    const at20 = Math.max(0, gainsTaxable - at0 - at15);
    const gainsTax = at15 * 0.15 + at20 * 0.2;
    const beforeCredits = ordinaryTax.tax + gainsTax;
    const agi = ordinary + gains;
    const reduction = Math.ceil(Math.max(0, agi - f.ctc.phaseout[status]) / 1000) * f.ctc.step;
    const credit = Math.max(0, children * f.ctc.amount + otherDependents * f.ctc.other_dependent - reduction);
    const used = Math.min(credit, beforeCredits);
    const refundable = Math.min(credit - used, children * f.ctc.refundable, Math.max(0, 0.15 * (agi - 2500)));

    return { taxable, ded, ordinaryTax: ordinaryTax.tax, gainsTax, beforeCredits, credit, refundable, tax: beforeCredits - used - refundable, marginal: ordinaryTax.marginal, slices: ordinaryTax.slices };
}

/**
 * Employee Social Security and Medicare on wages, with the 0.9% Additional Medicare Tax over the threshold.
 */
export function fica(f, wages, status = 'single') {
    const ss = Math.min(wages, f.fica.wage_base) * f.fica.ss_rate;
    const medicare = wages * f.fica.medicare;
    const additional = Math.max(0, wages - f.fica.additional_threshold[status]) * f.fica.additional;

    return { ss, medicare, additional, total: ss + medicare + additional };
}

/**
 * State income tax from the Tax Foundation table: income − standard deduction − exemptions, brackets for single
 * or joint filers, then any credit-style deductions or exemptions. Local taxes and phase-outs are not modelled.
 */
export function stateTax(st, income, status = 'single', dependents = 0) {
    const joint = status === 'mfj';
    const brackets = joint ? st.mfj : st.single;

    if (!brackets?.length) {
        return { tax: 0, marginal: 0, taxable: 0, none: true };
    }

    const pick = (value) => (typeof value === 'object' && value !== null ? { credit: value.credit } : { amount: value || 0 });
    const std = pick(st.std[joint ? 1 : 0]);
    const ex = pick(st.exempt[joint ? 1 : 0]);
    const dep = pick(st.exempt[2]);
    const taxable = Math.max(0, income - (std.amount ?? 0) - (ex.amount ?? 0) - (dep.amount ?? 0) * dependents);
    const result = bracketTax(taxable, brackets);
    const credits = (std.credit ?? 0) + (ex.credit ?? 0) + (dep.credit ?? 0) * dependents;

    return { tax: Math.max(0, result.tax - credits), marginal: result.marginal, taxable, slices: result.slices };
}

/**
 * A US paycheck: federal income tax on annualized taxable wages (standard deduction, child tax credit),
 * FICA and state income tax, per pay period.
 */
function paycheck(i, c, gross) {
    const f = c.data.federal;
    const status = statusOf(i);
    const periods = Number(i.periods ?? 26);
    const pretaxPct = P(or0(i.pretax_pct));
    const pretaxFlat = or0(i.pretax) * periods;
    const pretax = gross * pretaxPct + pretaxFlat;
    // 401(k) deferrals escape income tax but not FICA; section 125 health premiums escape both.
    const ficaWages = gross - pretaxFlat;
    const fed = federalTax(f, { ordinary: Math.max(0, gross - pretax), status, children: Math.round(or0(i.children)) });
    const payroll = fica(f, ficaWages, status);
    const st = c.data.states?.list?.[i.state ?? 'TX'];
    const state = st ? stateTax(st, Math.max(0, gross - pretax), status, Math.round(or0(i.children))) : { tax: 0 };
    const net = gross - pretax - Math.max(0, fed.tax) - payroll.total - state.tax - or0(i.post) * periods;

    return { gross, pretax, fed, payroll, state, net, periods, stateName: st?.name ?? '' };
}

function paycheckOutcome(r, s, label, value) {
    const per = (x) => money(x / r.periods, s);

    return {
        value,
        label,
        sub: `${money(r.net, s)} a year from ${money(r.gross, s)} gross (${pct(r.net / r.gross)} kept)`,
        rows: {
            gross: per(r.gross),
            federal: `${per(Math.max(0, r.fed.tax))}${r.fed.credit ? ` after ${money(r.fed.credit, s)} child tax credit a year` : ''}`,
            ss: per(r.payroll.ss),
            medicare: per(r.payroll.medicare + r.payroll.additional),
            state: r.state.none ? `None (${r.stateName} has no wage income tax)` : `${per(r.state.tax)} (${r.stateName})`,
            pretax: per(r.pretax),
            effective: pct((r.gross - r.net - r.pretax) / r.gross),
            marginal: `${pct(r.fed.marginal)} federal`,
        },
    };
}

const PAY_PERIODS = { 52: 'week', 26: 'two weeks', 24: 'half-month', 12: 'month', 1: 'year' };

function ukIncomeTax(u, income, scotland) {
    const allowance = Math.max(0, u.personal_allowance - Math.max(0, income - u.taper_start) / 2);
    const taxable = Math.max(0, income - allowance);
    const bands = scotland ? u.scotland : u.ruk;
    // Above £125,140 the personal allowance is gone; the top band still starts at £125,140 of taxable income.
    const result = bracketTax(taxable, bands);

    return { ...result, allowance, taxable };
}

function ukNi(u, earnings) {
    const n = u.ni;
    const main = Math.max(0, Math.min(earnings, n.uel) - n.pt) * n.main;
    const upper = Math.max(0, earnings - n.uel) * n.upper;

    return { employee: main + upper, employer: Math.max(0, earnings - n.secondary_threshold) * n.employer, class4: Math.max(0, Math.min(earnings, n.uel) - n.pt) * n.class4_main + Math.max(0, earnings - n.uel) * n.class4_upper };
}

const vatRates = { gb: 20, de: 19, fr: 20, it: 22, es: 21, nl: 21, ie: 23, be: 21, at: 20, pl: 23, se: 25, dk: 25, fi: 25.5, pt: 23, gr: 24, hu: 27, cz: 21, ch: 8.1, no: 25, ae: 5, sa: 15, za: 15, in: 18, au: 10, nz: 15, jp: 10, sg: 9 };

function addRemove(amount, ratePct, mode) {
    const r = P(ratePct);

    return mode === 'remove' ? { net: amount / (1 + r), tax: amount - amount / (1 + r), gross: amount } : { net: amount, tax: amount * r, gross: amount * (1 + r) };
}

export const handlers = {
    paycheck: (i, c) => {
        const s = symbolOf(c);
        const periods = Number(i.periods ?? 26);
        const gross = i.pay_basis === 'hourly' ? or0(i.hourly) * or0(i.hours) * 52 : i.pay_basis === 'period' ? or0(i.amount) * periods : or0(i.salary);

        if (!(gross > 0)) {
            return { empty: 'Enter your pay.' };
        }

        const r = paycheck(i, c, gross);

        return paycheckOutcome(r, s, `Take-home pay each ${PAY_PERIODS[periods] ?? 'period'}`, money(r.net / periods, s));
    },

    net_to_gross: (i, c) => {
        const s = symbolOf(c);
        const periods = Number(i.periods ?? 26);

        if (!(i.net > 0)) {
            return { empty: 'Enter the take-home pay you want.' };
        }

        const target = i.net * periods;
        let lo = target;
        let hi = target * 3 + 10000;

        for (let k = 0; k < 100; k += 1) {
            const mid = (lo + hi) / 2;

            if (paycheck(i, c, mid).net < target) {
                lo = mid;
            } else {
                hi = mid;
            }
        }

        const r = paycheck(i, c, hi);

        return paycheckOutcome(r, s, `Gross pay needed each ${PAY_PERIODS[periods] ?? 'period'}`, money(hi / periods, s));
    },

    tax_bracket: (i, c) => {
        const s = symbolOf(c);
        const f = c.data.federal;
        const status = statusOf(i);

        if (!ok(i.income) || i.income < 0) {
            return { empty: 'Enter your income.' };
        }

        const taxable = i.basis === 'taxable' ? i.income : Math.max(0, i.income - f.standard[status]);
        const r = bracketTax(taxable, f.brackets[status]);

        return {
            value: num(r.marginal * 100),
            unit: '%',
            label: 'Marginal tax bracket',
            sub: `${money(r.tax, s)} federal income tax on ${money(taxable, s)} of taxable income`,
            rows: { tax: money(r.tax, s), effective: pct(i.income > 0 ? r.tax / i.income : 0), taxable: money(taxable, s), next: (() => { const next = f.brackets[status].find(([from]) => from > taxable); return next ? `${money(next[0] - taxable, s)} more income reaches ${pct(next[1])}` : 'Already in the top bracket'; })() },
            lists: { slices: r.slices.map((x) => ({ label: `${pct(x.rate)} on ${money0(x.from, s)}–${Number.isFinite(x.to) ? money0(x.to, s) : 'and up'}`, value: money(x.tax, s), highlight: x.rate === r.marginal })) },
        };
    },

    agi: (i, c) => {
        const s = symbolOf(c);
        const incomes = ['wages', 'interest', 'dividends', 'business', 'gains', 'retirement', 'other_income'].reduce((sum, k) => sum + or0(i[k]), 0);
        const adjustments = ['hsa', 'ira', 'student_interest', 'se_half', 'other_adj'].reduce((sum, k) => sum + or0(i[k]), 0);
        const studentCap = Math.min(or0(i.student_interest), 2500);
        const agi = incomes - adjustments + (or0(i.student_interest) - studentCap);
        const f = c.data.federal;

        if (!incomes) {
            return { empty: 'Enter your income.' };
        }

        return {
            value: money(agi, s),
            label: 'Adjusted gross income (AGI)',
            sub: `${money(incomes, s)} total income − ${money(adjustments - (or0(i.student_interest) - studentCap), s)} adjustments`,
            rows: { total: money(incomes, s), adjustments: money(adjustments - (or0(i.student_interest) - studentCap), s), taxable: `${money(Math.max(0, agi - f.standard[statusOf(i)]), s)} after the ${money(f.standard[statusOf(i)], s)} standard deduction`, note: studentCap < or0(i.student_interest) ? 'Student loan interest is capped at $2,500' : 'Adjustments from Schedule 1, Part II' },
        };
    },

    magi: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.agi)) {
            return { empty: 'Enter your AGI.' };
        }

        const purpose = i.purpose ?? 'roth';
        // Add-backs by purpose (IRS Pub 590-A worksheet, Form 8962, Form 8960).
        const addBacks = purpose === 'roth' ? or0(i.ira_deduction) + or0(i.student_interest) + or0(i.foreign) - or0(i.roth_conversion) : purpose === 'aca' ? or0(i.foreign) + or0(i.tax_exempt) + or0(i.untaxed_ss) : or0(i.foreign);
        const magi = i.agi + addBacks;
        const limits = c.data.limits;

        return {
            value: money(magi, s),
            label: 'Modified AGI',
            sub: { roth: 'for Roth IRA eligibility', aca: 'for ACA premium tax credits', niit: 'for the net investment income tax' }[purpose],
            rows: {
                added: money(addBacks, s),
                check: purpose === 'roth' ? (() => { const [lo, hi] = limits.roth_phaseout[statusOf(i)]; return magi <= lo ? 'Full Roth contribution allowed' : magi >= hi ? 'No direct Roth contribution' : 'Reduced Roth contribution'; })() : purpose === 'niit' ? (magi > c.data.federal.niit[statusOf(i)] ? `NIIT applies above ${money0(c.data.federal.niit[statusOf(i)], s)}` : 'Below the NIIT threshold') : 'Compare with 100–400% of the federal poverty line for subsidies',
                agi: money(i.agi, s),
            },
        };
    },

    amt: (i, c) => {
        const s = symbolOf(c);
        const f = c.data.federal;
        const status = statusOf(i);

        if (!ok(i.income)) {
            return { empty: 'Enter your taxable income.' };
        }

        const amti = i.income + or0(i.salt) + or0(i.iso) + or0(i.other_pref) + (i.standard_taken ? f.standard[status] : 0);
        const exemption = Math.max(0, f.amt.exemption[status] - f.amt.phaseout_rate * Math.max(0, amti - f.amt.phaseout[status]));
        const base = Math.max(0, amti - exemption);
        const brk = f.amt.breakpoint[status];
        const tmt = Math.min(base, brk) * 0.26 + Math.max(0, base - brk) * 0.28;
        const regular = bracketTax(i.income, f.brackets[status]).tax;
        const amt = Math.max(0, tmt - regular);

        return {
            value: money(amt, s),
            label: 'Alternative minimum tax',
            sub: amt > 0 ? 'You would owe AMT on top of regular tax' : 'Regular tax is higher, so no AMT',
            rows: { amti: money(amti, s), exemption: money(exemption, s), tmt: money(tmt, s), regular: money(regular, s) },
        };
    },

    ctc: (i, c) => {
        const s = symbolOf(c);
        const f = c.data.federal;
        const status = statusOf(i);

        if (!ok(i.agi, i.children)) {
            return { empty: 'Enter income and the number of qualifying children.' };
        }

        const r = federalTax(f, { ordinary: i.agi, status, children: Math.round(i.children), otherDependents: Math.round(or0(i.others)) });
        const full = Math.round(i.children) * f.ctc.amount + Math.round(or0(i.others)) * f.ctc.other_dependent;
        const used = Math.min(r.credit, r.beforeCredits);
        const received = used + r.refundable;

        return {
            value: money(received, s),
            label: 'Child tax credit you can use',
            sub: r.credit < full ? `reduced from ${money(full, s)} by the income phase-out` : received < r.credit ? `${money(r.credit, s)} credit, limited by your tax and the refundable cap` : `${money(f.ctc.amount, s)} per child under 17 in ${f.year}`,
            rows: { credit: money(r.credit, s), refundable: money(r.refundable, s), used: money(used, s), tax: money(Math.max(0, r.beforeCredits - used), s), phaseout: `Starts at ${money0(f.ctc.phaseout[status], s)} AGI: $50 less per $1,000 above` },
        };
    },

    fica: (i, c) => {
        const s = symbolOf(c);
        const f = c.data.federal;

        if (!ok(i.wages) || i.wages < 0) {
            return { empty: 'Enter your wages.' };
        }

        const r = fica(f, i.wages, statusOf(i));

        return {
            value: money(r.total, s),
            label: 'FICA tax (employee)',
            sub: `${pct(r.total / i.wages)} of wages; your employer pays a matching ${money(r.ss + r.medicare, s)}`,
            rows: { ss: `${money(r.ss, s)} (6.2% up to ${money0(f.fica.wage_base, s)})`, medicare: `${money(r.medicare, s)} (1.45%)`, additional: money(r.additional, s), employer: money(r.ss + r.medicare, s) },
        };
    },

    self_employment: (i, c) => {
        const s = symbolOf(c);
        const f = c.data.federal;

        if (!ok(i.profit) || i.profit <= 0) {
            return { empty: 'Enter your net self-employment profit.' };
        }

        const earnings = i.profit * f.fica.se_factor;

        if (earnings < 400) {
            return { value: money(0, s), label: 'Self-employment tax', sub: 'No SE tax below $400 of net earnings', rows: { earnings: money(earnings, s), ss: money(0, s), medicare: money(0, s), deduction: money(0, s) } };
        }

        const ssRoom = Math.max(0, f.fica.wage_base - or0(i.wages));
        const ss = Math.min(earnings, ssRoom) * 0.124;
        const medicare = earnings * 0.029;
        const additional = Math.max(0, earnings + or0(i.wages) - f.fica.additional_threshold[statusOf(i)]) * 0.009;
        const tax = ss + medicare;

        return {
            value: money(tax, s),
            label: 'Self-employment tax',
            sub: `on ${money(earnings, s)} of net earnings (92.35% of profit); deduct half (${money(tax / 2, s)}) from income`,
            rows: { earnings: money(earnings, s), ss: money(ss, s), medicare: `${money(medicare, s)}${additional ? ` + ${money(additional, s)} Additional Medicare Tax (Form 8959)` : ''}`, deduction: money(tax / 2, s) },
        };
    },

    estimated: (i, c) => {
        const s = symbolOf(c);
        const f = c.data.federal;

        if (!ok(i.this_year, i.last_year)) {
            return { empty: 'Enter this year\'s expected tax and last year\'s tax.' };
        }

        const high = or0(i.last_agi) > (statusOf(i) === 'mfs' ? f.safe_harbor.high_agi_mfs : f.safe_harbor.high_agi);
        const prior = i.last_year * (high ? 1.1 : 1);
        const current = i.this_year * 0.9;
        const required = Math.max(0, Math.min(prior, current) - or0(i.withheld));

        return {
            value: money(required / 4, s),
            label: 'Each quarterly payment',
            sub: `${money(required, s)} for the year: the smaller of ${pct(high ? 1.1 : 1)} of last year's tax and 90% of this year's, less withholding`,
            rows: { prior: money(prior, s), current: money(current, s), required: money(required, s), dates: 'Due April 15, June 15 and September 15, 2026, and January 15, 2027' },
        };
    },

    capital_gains: (i, c) => {
        const s = symbolOf(c);
        const f = c.data.federal;
        const status = statusOf(i);

        if (!ok(i.gain, i.income)) {
            return { empty: 'Enter the gain and your other taxable income.' };
        }

        const long = i.term !== 'short';
        const base = federalTax(f, { ordinary: i.income, status, deduction: 0 });
        const withGain = long ? federalTax(f, { ordinary: i.income, gains: i.gain, status, deduction: 0 }) : federalTax(f, { ordinary: i.income + i.gain, status, deduction: 0 });
        const tax = withGain.beforeCredits - base.beforeCredits;
        const magi = i.income + i.gain + f.standard[status];
        const niit = Math.max(0, Math.min(i.gain, magi - f.niit[status])) * f.niit.rate;

        return {
            value: money(tax + niit, s),
            label: long ? 'Tax on the long-term gain' : 'Tax on the short-term gain',
            sub: `${pct((tax + niit) / i.gain)} of the gain${niit ? `, including ${money(niit, s)} NIIT` : ''}`,
            rows: { federal: money(tax, s), niit: money(niit, s), rate: long ? `0% up to ${money0(f.capital_gains[status][0], s)}, 15% to ${money0(f.capital_gains[status][1], s)}, then 20% (taxable income)` : 'Taxed as ordinary income (held one year or less)', after: money(i.gain - tax - niit, s) },
        };
    },

    lottery: (i, c) => {
        const s = symbolOf(c);
        const f = c.data.federal;

        if (!ok(i.prize) || i.prize <= 0) {
            return { empty: 'Enter the prize.' };
        }

        const status = statusOf(i);
        const withheld = i.prize * f.lottery_withholding;
        const fed = federalTax(f, { ordinary: i.prize + or0(i.income), status }).beforeCredits - federalTax(f, { ordinary: or0(i.income), status }).beforeCredits;
        const state = i.prize * P(or0(i.state_rate));

        return {
            value: money(i.prize - fed - state, s),
            label: 'Prize after tax',
            sub: `${money(fed, s)} federal and ${money(state, s)} state tax`,
            rows: { withheld: `${money(withheld, s)} (24% withheld on prizes over $5,000)`, owed: money(Math.max(0, fed - withheld), s), federal: `${money(fed, s)} (${pct(fed / i.prize)})`, state: money(state, s) },
        };
    },

    rmd: (i, c) => {
        const s = symbolOf(c);
        const t = c.data.rmd;

        if (!ok(i.balance, i.age) || i.balance < 0) {
            return { empty: 'Enter the December 31 balance and your age this year.' };
        }

        const start = or0(i.born) >= 1960 ? t.start_age_born_1960_on : t.start_age_born_1951_1959;

        if (i.age < start) {
            return { value: money(0, s), label: 'Required minimum distribution', sub: `RMDs start at ${start} for your birth year`, rows: { factor: '—', start: `Age ${start}`, deadline: 'None yet', next: `In ${start - i.age} years` } };
        }

        const factor = t.table[String(Math.min(120, Math.round(i.age)))];
        const rmd = i.balance / factor;

        return {
            value: money(rmd, s),
            label: 'Required minimum distribution',
            sub: `${money(i.balance, s)} ÷ ${num(factor)} (Uniform Lifetime Table)`,
            rows: { factor: num(factor), start: `Age ${start}`, deadline: i.age === start ? 'First RMD can wait until April 1 next year (then two in one year)' : 'By December 31', next: money((i.balance - rmd) * (1 + P(or0(i.rate))) / t.table[String(Math.min(120, Math.round(i.age) + 1))], s) },
        };
    },

    state_tax: (i, c) => {
        const s = symbolOf(c);
        const st = c.data.states.list[i.state ?? c.state];

        if (!st || !ok(i.income)) {
            return { empty: 'Choose a state and enter your income.' };
        }

        const r = stateTax(st, i.income, statusOf(i), Math.round(or0(i.dependents)));
        const local = P(or0(i.local)) * Math.max(0, r.taxable || i.income);

        return {
            value: money(r.tax + local, s),
            label: `${st.name} income tax`,
            sub: r.none ? st.note ?? `${st.name} has no individual income tax on wages` : `${pct((r.tax + local) / i.income)} of income, top rate on your income ${pct(r.marginal)}`,
            rows: {
                taxable: money(r.taxable, s),
                marginal: pct(r.marginal),
                local: or0(i.local) ? money(local, s) : 'Enter a local rate if your city or county taxes income',
                top: st.single.length ? pct(st.single[st.single.length - 1][1]) : 'None',
            },
            lists: { slices: r.slices?.length ? r.slices.map((x) => ({ label: `${pct(x.rate)} on ${money0(x.from, s)}–${Number.isFinite(x.to) ? money0(x.to, s) : 'and up'}`, value: money(x.tax, s) })) : [{ label: r.none ? 'No state tax on wages' : 'Income below the first taxed bracket', value: money(0, s) }] },
        };
    },

    new_york: (i, c) => {
        const s = symbolOf(c);
        const st = c.data.states.list.NY;

        if (!ok(i.income)) {
            return { empty: 'Enter your income.' };
        }

        const r = stateTax(st, i.income, statusOf(i), Math.round(or0(i.dependents)));
        // New York City resident tax, 2026 rates (4 brackets).
        const nycBrackets = statusOf(i) === 'mfj' ? [[0, 0.03078], [21600, 0.03762], [45000, 0.03819], [90000, 0.03876]] : [[0, 0.03078], [12000, 0.03762], [25000, 0.03819], [50000, 0.03876]];
        const nyc = i.nyc ? bracketTax(r.taxable, nycBrackets).tax : 0;

        return {
            value: money(r.tax + nyc, s),
            label: i.nyc ? 'New York State and City income tax' : 'New York State income tax',
            sub: `${pct((r.tax + nyc) / i.income)} of income`,
            rows: { state: money(r.tax, s), nyc: i.nyc ? money(nyc, s) : 'Tick NYC resident to add city tax', taxable: money(r.taxable, s), marginal: pct(r.marginal + (i.nyc ? 0.03876 : 0)) },
        };
    },

    no_income_tax: (i, c) => {
        const s = symbolOf(c);
        const rates = c.data.sales.rates.TX;

        if (!ok(i.income)) {
            return { empty: 'Enter your income.' };
        }

        const spending = or0(i.spending);
        const sales = spending * P(rates.state + (ok(i.local) ? i.local : rates.local));
        const property = or0(i.home_value) * P(or0(i.property_rate));
        const compare = c.data.states.list[i.compare ?? 'CA'];
        const saved = compare ? stateTax(compare, i.income, statusOf(i)).tax : 0;

        return {
            value: money(0, s),
            label: 'Texas state income tax',
            sub: 'Texas has no personal income tax (Texas Constitution, art. 8, §24-a)',
            rows: { sales: `${money(sales, s)} a year on ${money(spending, s)} of taxable spending (${num(rates.state + (ok(i.local) ? i.local : rates.local))}%)`, property: `${money(property, s)} a year`, total: money(sales + property, s), compare: compare ? `${money(saved, s)} of ${compare.name} income tax on the same income` : '—' },
        };
    },

    sales_tax: (i, c) => {
        const s = symbolOf(c);
        const code = c.state ?? i.state;
        const preset = code ? c.data.sales.rates[code] : null;
        const stateRate = preset ? preset.state : 0;
        // New Jersey Urban Enterprise Zones charge half the state rate at qualifying sellers.
        const rate = code === 'NJ' && i.uez ? stateRate / 2 : preset ? stateRate + (ok(i.local) ? i.local : 0) : or0(i.rate);

        if (!ok(i.amount)) {
            return { empty: 'Enter the amount.' };
        }

        const r = addRemove(i.amount, rate, i.mode ?? 'add');

        return {
            value: money(i.mode === 'remove' ? r.net : r.gross, s),
            label: i.mode === 'remove' ? 'Price before tax' : 'Total with tax',
            sub: `${money(r.tax, s)} sales tax at ${num(rate)}%`,
            rows: { tax: money(r.tax, s), rate: preset ? `${num(stateRate)}% state + ${num(rate - stateRate)}% local` : `${num(rate)}%`, net: money(r.net, s), gross: money(r.gross, s) },
        };
    },

    vat: (i, c) => {
        const s = symbolOf(c);
        const rate = i.country === 'custom' || !i.country ? or0(i.rate) : vatRates[i.country];

        if (!ok(i.amount)) {
            return { empty: 'Enter the amount.' };
        }

        const r = addRemove(i.amount, rate, i.mode ?? 'add');

        return {
            value: money(i.mode === 'remove' ? r.net : r.gross, s),
            label: i.mode === 'remove' ? 'Net amount (excluding VAT)' : 'Gross amount (including VAT)',
            sub: `${money(r.tax, s)} VAT at ${num(rate)}%`,
            rows: { vat: money(r.tax, s), net: money(r.net, s), gross: money(r.gross, s), fraction: i.mode === 'remove' ? `VAT is ${num(rate)}/${num(100 + rate)} of the gross` : `${num(rate)}% of the net` },
        };
    },

    gst_india: (i, c) => {
        const s = symbolOf(c);
        const rate = i.slab === 'custom' ? or0(i.rate) : Number(i.slab ?? 18);

        if (!ok(i.amount)) {
            return { empty: 'Enter the amount.' };
        }

        const r = addRemove(i.amount, rate, i.mode ?? 'add');

        return {
            value: money(i.mode === 'remove' ? r.net : r.gross, s),
            label: i.mode === 'remove' ? 'Value before GST' : 'Value including GST',
            sub: `${money(r.tax, s)} GST at ${num(rate)}%`,
            rows: { gst: money(r.tax, s), split: i.supply === 'inter' ? `IGST ${money(r.tax, s)}` : `CGST ${money(r.tax / 2, s)} + SGST ${money(r.tax / 2, s)}`, net: money(r.net, s), gross: money(r.gross, s) },
        };
    },

    gst_canada: (i, c) => {
        const s = symbolOf(c);
        const t = c.data.canada;
        const [name, kind, provincial] = t.provinces[i.province ?? 'QC'];

        if (!ok(i.amount)) {
            return { empty: 'Enter the amount.' };
        }

        const total = kind === 'hst' ? provincial : t.gst + provincial;
        const r = addRemove(i.amount, total, i.mode ?? 'add');
        const gst = kind === 'hst' ? 0 : r.net * P(t.gst);
        const prov = kind === 'hst' ? r.tax : r.net * P(provincial);
        const label = { hst: 'HST', qst: 'QST', pst: kind === 'pst' && i.province === 'MB' ? 'RST' : 'PST', gst: '' }[kind];

        return {
            value: money(i.mode === 'remove' ? r.net : r.gross, s),
            label: i.mode === 'remove' ? 'Price before tax' : 'Total with tax',
            sub: `${name}: ${kind === 'hst' ? `${num(provincial)}% HST` : kind === 'gst' ? '5% GST only' : `5% GST + ${num(provincial)}% ${label}`}`,
            rows: { gst: kind === 'hst' ? `Included in HST (5% federal part ${money(r.net * 0.05, s)})` : money(gst, s), provincial: kind === 'gst' ? 'None' : `${money(prov, s)} ${label}`, total: money(r.tax, s), rate: `${num(total)}%` },
        };
    },

    // UK ----------------------------------------------------------------------------------------
    uk_take_home: (i, c) => {
        const s = symbolOf(c);
        const u = c.data.uk;

        if (!ok(i.salary) || i.salary <= 0) {
            return { empty: 'Enter your salary.' };
        }

        // Salary sacrifice pension lowers income tax and NI; relief-at-source is simplified to the same effect on tax only.
        const pension = i.salary * P(or0(i.pension));
        const taxable = i.salary - pension;
        const tax = ukIncomeTax(u, taxable, i.region === 'scotland');
        const niBase = i.pension_type === 'sacrifice' ? taxable : i.salary;
        const ni = ukNi(u, niBase).employee;
        const plan = u.student[i.student ?? 'none'];
        const loan = plan ? Math.max(0, niBase - plan[0]) * plan[1] : 0;
        const pg = i.postgrad ? Math.max(0, niBase - u.student.postgrad[0]) * u.student.postgrad[1] : 0;
        const net = i.salary - pension - tax.tax - ni - loan - pg;

        return {
            value: money(net / 12, s),
            label: 'Take-home pay a month',
            sub: `${money(net, s)} a year (${u.year})`,
            rows: { tax: money(tax.tax, s), ni: money(ni, s), pension: money(pension, s), loan: money(loan + pg, s), allowance: money(tax.allowance, s), marginal: pct(tax.marginal + (niBase > u.ni.uel ? u.ni.upper : niBase > u.ni.pt ? u.ni.main : 0) + (plan && niBase > plan[0] ? plan[1] : 0)), weekly: money(net / 52, s) },
        };
    },

    uk_ni: (i, c) => {
        const s = symbolOf(c);
        const u = c.data.uk;

        if (!ok(i.earnings) || i.earnings < 0) {
            return { empty: 'Enter your earnings.' };
        }

        const r = ukNi(u, i.earnings);
        const self = i.type === 'self';

        return {
            value: money(self ? r.class4 : r.employee, s),
            label: self ? 'Class 4 National Insurance' : 'Employee National Insurance (Class 1)',
            sub: self ? `6% on profits from ${money0(u.ni.pt, s)} to ${money0(u.ni.uel, s)}, 2% above` : `8% on earnings from ${money0(u.ni.pt, s)} to ${money0(u.ni.uel, s)}, 2% above`,
            rows: { employer: self ? 'Not applicable' : `${money(r.employer, s)} (15% above ${money0(u.ni.secondary_threshold, s)}; Employment Allowance may reduce it)`, monthly: money((self ? r.class4 : r.employee) / 12, s), rate: pct((self ? r.class4 : r.employee) / Math.max(1, i.earnings)), year: u.year },
        };
    },

    sdlt: (i, c) => {
        const s = symbolOf(c);
        const t = c.data.uk.sdlt;

        if (!ok(i.price) || i.price <= 0) {
            return { empty: 'Enter the price.' };
        }

        const ftb = i.buyer === 'first' && i.price <= t.ftb_max;
        const base = bracketTax(i.price, ftb ? t.ftb : t.standard);
        const surcharge = i.buyer === 'additional' ? i.price * t.surcharge : 0;
        const nonResident = i.non_resident ? i.price * t.non_resident : 0;
        const total = base.tax + surcharge + nonResident;

        return {
            value: money(total, s),
            label: 'Stamp Duty Land Tax',
            sub: `${pct(total / i.price)} effective (England and Northern Ireland rates from April 1, 2025)`,
            rows: { base: money(base.tax, s), relief: i.buyer === 'first' ? (ftb ? 'First-time buyer relief applied' : 'No relief: price over £500,000') : 'Not a first-time buyer', surcharge: money(surcharge + nonResident, s), effective: pct(total / i.price) },
            lists: { slices: base.slices.map((x) => ({ label: `${pct(x.rate)} on £${num(x.from)}–${Number.isFinite(x.to) ? `£${num(x.to)}` : 'above'}`, value: money(x.tax, s) })) },
        };
    },

    uk_cgt: (i, c) => {
        const s = symbolOf(c);
        const t = c.data.uk.cgt;

        if (!ok(i.gain, i.income)) {
            return { empty: 'Enter the gain and your taxable income.' };
        }

        const taxable = Math.max(0, i.gain - or0(i.losses) - t.allowance);
        const pa = c.data.uk.personal_allowance;
        const basicLeft = Math.max(0, t.basic_band - Math.max(0, i.income - pa));
        const atBasic = Math.min(taxable, basicLeft);
        const tax = atBasic * t.basic + (taxable - atBasic) * t.higher;

        return {
            value: money(tax, s),
            label: 'Capital Gains Tax',
            sub: `${money(taxable, s)} taxable after the ${money0(t.allowance, s)} annual exempt amount`,
            rows: { basic: `${money(atBasic, s)} at 18%`, higher: `${money(taxable - atBasic, s)} at 24%`, effective: pct(i.gain > 0 ? tax / i.gain : 0), due: 'Report UK residential property within 60 days of completion' },
        };
    },

    uk_coins: (i, c) => {
        const s = symbolOf(c);
        const coins = c.data.uk.coins;
        const coin = coins.find((x) => x[0] === i.coin) ?? coins[0];
        const [name, value, grams, bag] = coin;

        if (i.mode === 'weight') {
            if (!ok(i.grams) || i.grams < 0) {
                return { empty: 'Enter the weight.' };
            }

            const count = Math.round(i.grams / grams);

            return { value: money(count * value, s), label: `Value of ${name} coins`, sub: `about ${num(count)} coins of ${num(grams)} g`, rows: { count: num(count), bag: `A ${money(bag, s)} bag of ${name} weighs ${num((bag / value) * grams)} g`, grams: `${num(grams)} g each`, check: `${num(i.grams / grams)} coins by weight` } };
        }

        if (!ok(i.amount) || i.amount < 0) {
            return { empty: 'Enter the value.' };
        }

        const count = Math.round(i.amount / value);

        return { value: `${num((count * grams) / 1000)} kg`, label: `Weight of ${money(i.amount, s)} in ${name}`, sub: `${num(count)} coins of ${num(grams)} g`, rows: { count: num(count), bag: `Standard bag: ${money(bag, s)} (${num(bag / value)} coins, ${num((bag / value) * grams)} g)`, grams: `${num(grams)} g each`, check: `${num(count / (bag / value))} ${count / (bag / value) === 1 ? 'bag' : 'bags'}` } };
    },

    // Other countries --------------------------------------------------------------------------
    australia: (i, c) => {
        const s = symbolOf(c);
        const t = c.data.australia;

        if (!ok(i.income) || i.income < 0) {
            return { empty: 'Enter your taxable income.' };
        }

        const base = bracketTax(i.income, t.brackets);
        const l = t.lito;
        const lito = i.income <= l.full_to ? l.max : i.income <= l.step1_to ? l.max - (i.income - l.full_to) * l.rate1 : Math.max(0, 325 - (i.income - l.step1_to) * l.rate2);
        const tax = Math.max(0, base.tax - lito);
        const medicare = i.medicare === false ? 0 : i.income * t.medicare;

        return {
            value: money(tax + medicare, s),
            label: `Income tax ${t.year}`,
            sub: `${money(i.income - tax - medicare, s)} after tax (${pct((tax + medicare) / Math.max(1, i.income))} of income)`,
            rows: { tax: money(base.tax, s), lito: money(Math.min(lito, base.tax), s), medicare: money(medicare, s), marginal: pct(base.marginal + (i.medicare === false ? 0 : t.medicare)), fortnight: money((i.income - tax - medicare) / 26, s) },
        };
    },

    philippines: (i, c) => {
        const s = symbolOf(c);
        const t = c.data.philippines;

        if (!ok(i.salary) || i.salary <= 0) {
            return { empty: 'Enter your monthly basic salary.' };
        }

        const sss = Math.min(Math.max(i.salary, t.sss.msc_min), t.sss.msc_max) * t.sss.rate;
        const philhealth = Math.min(Math.max(i.salary, t.philhealth.floor), t.philhealth.ceiling) * t.philhealth.rate;
        const pagibig = Math.min(i.salary, t.pagibig.cap_salary) * t.pagibig.rate;
        const contributions = sss + philhealth + pagibig;
        const bonus = or0(i.bonus);
        const annual = (i.salary - contributions) * 12 + Math.max(0, bonus - t.exempt_bonus) + or0(i.other) * 12;
        const r = fixedBracketTax(annual, t.brackets);

        return {
            value: money(r.tax / 12, s),
            label: 'Withholding tax a month',
            sub: `${money(r.tax, s)} a year on ${money(annual, s)} taxable`,
            rows: { contributions: `${money(contributions, s)} a month (SSS ${money(sss, s)}, PhilHealth ${money(philhealth, s)}, Pag-IBIG ${money(pagibig, s)})`, net: money(i.salary + or0(i.other) - contributions - r.tax / 12, s), marginal: pct(r.marginal), bonus: bonus > t.exempt_bonus ? `${money(bonus - t.exempt_bonus, s)} of the 13th month and bonuses is taxable` : 'Within the ₱90,000 tax-free limit' },
        };
    },

    pakistan: (i, c) => {
        const s = symbolOf(c);
        const t = c.data.pakistan;
        const annual = i.period === 'month' ? or0(i.salary) * 12 : or0(i.salary);

        if (!(annual > 0)) {
            return { empty: 'Enter your salary.' };
        }

        const r = fixedBracketTax(annual, t.brackets);

        return {
            value: money(r.tax / 12, s),
            label: 'Income tax a month',
            sub: `${money(r.tax, s)} a year, tax year ${t.year}`,
            rows: { yearly: money(r.tax, s), net: money((annual - r.tax) / 12, s), effective: pct(r.tax / annual), marginal: pct(r.marginal) },
        };
    },
};

export default defineTools(handlers);
