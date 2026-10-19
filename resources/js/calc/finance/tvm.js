/**
 * Time value of money for the Finance section. Rates are per period as fractions (0.05 = 5%).
 * Cash-flow signs follow the usual convention: money received is positive, money paid is negative.
 */

/**
 * Future value of a present value and a level payment (type 1 = payments at the start of each period).
 */
export function fv(rate, n, pmt = 0, pv = 0, type = 0) {
    if (rate === 0) {
        return -(pv + pmt * n);
    }

    const growth = (1 + rate) ** n;

    return -(pv * growth + pmt * (1 + rate * type) * ((growth - 1) / rate));
}

export function pv(rate, n, pmt = 0, fvValue = 0, type = 0) {
    if (rate === 0) {
        return -(fvValue + pmt * n);
    }

    const growth = (1 + rate) ** n;

    return -(fvValue + pmt * (1 + rate * type) * ((growth - 1) / rate)) / growth;
}

export function pmt(rate, n, pvValue = 0, fvValue = 0, type = 0) {
    if (n <= 0) {
        return NaN;
    }

    if (rate === 0) {
        return -(pvValue + fvValue) / n;
    }

    const growth = (1 + rate) ** n;

    return -(rate * (pvValue * growth + fvValue)) / ((1 + rate * type) * (growth - 1));
}

export function nper(rate, pmtValue, pvValue = 0, fvValue = 0, type = 0) {
    if (rate === 0) {
        return pmtValue === 0 ? NaN : -(pvValue + fvValue) / pmtValue;
    }

    const adjusted = pmtValue * (1 + rate * type) / rate;
    const ratio = (adjusted - fvValue) / (adjusted + pvValue);

    return ratio > 0 ? Math.log(ratio) / Math.log(1 + rate) : NaN;
}

/**
 * Finds a root of f between lo and hi by bisection after scanning for a sign change; null when none.
 */
export function solve(f, lo, hi, steps = 400) {
    let a = lo;
    let fa = f(a);

    for (let k = 1; k <= steps; k += 1) {
        const b = lo + ((hi - lo) * k) / steps;
        const fb = f(b);

        if (Number.isFinite(fa) && Number.isFinite(fb) && (fa === 0 || fa * fb < 0)) {
            let [x0, x1, f0] = [a, b, fa];

            for (let it = 0; it < 200; it += 1) {
                const mid = (x0 + x1) / 2;
                const fm = f(mid);

                if (fm === 0 || Math.abs(x1 - x0) < 1e-14) {
                    return mid;
                }

                if (f0 * fm < 0) {
                    x1 = mid;
                } else {
                    [x0, f0] = [mid, fm];
                }
            }

            return (x0 + x1) / 2;
        }

        [a, fa] = [b, fb];
    }

    return null;
}

/**
 * Rate per period for given n, pmt, pv, fv (like a spreadsheet RATE function), searched from −99% to 1,000%.
 */
export function rate(n, pmtValue, pvValue, fvValue = 0, type = 0) {
    return solve((r) => (r === 0 ? pvValue + pmtValue * n + fvValue : pvValue * (1 + r) ** n + pmtValue * (1 + r * type) * (((1 + r) ** n - 1) / r) + fvValue), -0.99, 10, 4000);
}

/**
 * Net present value of flows at t = 0, 1, 2, … (the first flow is not discounted).
 */
export function npv(r, flows) {
    return flows.reduce((sum, cf, t) => sum + cf / (1 + r) ** t, 0);
}

/**
 * Internal rates of return: every sign change of NPV between −99% and 1,000% a period.
 */
export function irrs(flows) {
    const roots = [];
    const f = (r) => npv(r, flows);
    const grid = [];

    for (let r = -0.99; r <= 10; r += r < 1 ? 0.0025 : 0.05) {
        grid.push(r);
    }

    for (let k = 1; k < grid.length; k += 1) {
        const [a, b] = [grid[k - 1], grid[k]];

        if (f(a) * f(b) < 0 || f(b) === 0) {
            const root = solve(f, a, b, 4);

            if (root !== null && !roots.some((x) => Math.abs(x - root) < 1e-7)) {
                roots.push(root);
            }
        }
    }

    return roots;
}

/**
 * Modified IRR: negative flows discounted at the finance rate, positive flows compounded at the reinvestment rate.
 */
export function mirr(flows, finance, reinvest) {
    const n = flows.length - 1;
    const pvNeg = flows.reduce((sum, cf, t) => sum + (cf < 0 ? cf / (1 + finance) ** t : 0), 0);
    const fvPos = flows.reduce((sum, cf, t) => sum + (cf > 0 ? cf * (1 + reinvest) ** (n - t) : 0), 0);

    return n > 0 && pvNeg < 0 && fvPos > 0 ? (fvPos / -pvNeg) ** (1 / n) - 1 : NaN;
}

/**
 * Effective rate per contribution period when interest compounds `compound` times a year and money is added `per` times a year.
 */
export const periodRate = (annual, compound, per) => (compound === Infinity ? Math.exp(annual / per) - 1 : (1 + annual / compound) ** (compound / per) - 1);

export const effectiveAnnual = (annual, compound) => (compound === Infinity ? Math.exp(annual) - 1 : (1 + annual / compound) ** compound - 1);

/**
 * Year-by-year growth of a balance with regular contributions (made at the end, or start, of each contribution period),
 * an annual contribution increase and optional withdrawals. Returns rows per year and totals.
 */
export function growth({ start = 0, contribution = 0, perYear = 12, annual = 0, compound = 12, years = 10, timing = 'end', increase = 0, withdrawal = 0 }) {
    const r = periodRate(annual, compound, perYear);
    let balance = start;
    let deposits = start;
    let interest = 0;
    let payment = contribution;
    const rows = [];
    const totalPeriods = Math.round(years * perYear);

    for (let p = 1; p <= totalPeriods; p += 1) {
        if (timing === 'start') {
            balance += payment - withdrawal;
        }

        const earned = balance * r;
        balance += earned;
        interest += earned;

        if (timing !== 'start') {
            balance += payment - withdrawal;
        }

        deposits += payment - withdrawal;

        if (p % perYear === 0 || p === totalPeriods) {
            rows.push({ year: Math.ceil(p / perYear), balance, deposits, interest });

            if (p % perYear === 0) {
                payment *= 1 + increase;
            }
        }
    }

    return { balance, deposits, interest, rows, rate: r };
}
