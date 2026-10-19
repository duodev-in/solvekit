import { getCurrency } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { money, money0, num, numberList, pct } from '../finance/common.js';
import { solve } from '../finance/tvm.js';
import { parseRows } from '../rows-editor.js';

/**
 * Securities: equity valuation, bonds (price, yield, duration, convexity with coupon dates and day counts),
 * Black–Scholes–Merton, option payoffs and technical levels. Percent fields arrive as entered.
 */
const P = (value) => value / 100;
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
// Fixed-currency pages pass `sym` (a currency code); otherwise the page's display currency applies.
const symbolOf = (c) => c.sym ?? getCurrency();

/**
 * Standard normal CDF (Abramowitz & Stegun 26.2.17 via erf, |error| < 1.5e-7) and density.
 */
export function normCdf(x) {
    const t = 1 / (1 + 0.3275911 * (Math.abs(x) / Math.SQRT2));
    const erf = 1 - (((((1.061405429 * t - 1.453152027) * t) + 1.421413741) * t - 0.284496736) * t + 0.254829592) * t * Math.exp(-(x * x) / 2);

    return x >= 0 ? 0.5 * (1 + erf) : 0.5 * (1 - erf);
}

const normPdf = (x) => Math.exp(-(x * x) / 2) / Math.sqrt(2 * Math.PI);

/**
 * Black–Scholes–Merton for European options on a stock paying a continuous dividend yield q.
 */
export function blackScholes(S, K, T, r, q, sigma) {
    const sqrtT = Math.sqrt(T);
    const d1 = (Math.log(S / K) + (r - q + (sigma * sigma) / 2) * T) / (sigma * sqrtT);
    const d2 = d1 - sigma * sqrtT;
    const dq = Math.exp(-q * T);
    const dr = Math.exp(-r * T);
    const call = S * dq * normCdf(d1) - K * dr * normCdf(d2);
    const put = K * dr * normCdf(-d2) - S * dq * normCdf(-d1);
    const gamma = (dq * normPdf(d1)) / (S * sigma * sqrtT);
    const vega = (S * dq * normPdf(d1) * sqrtT) / 100;
    const thetaCall = (-(S * dq * normPdf(d1) * sigma) / (2 * sqrtT) - r * K * dr * normCdf(d2) + q * S * dq * normCdf(d1)) / 365;
    const thetaPut = (-(S * dq * normPdf(d1) * sigma) / (2 * sqrtT) + r * K * dr * normCdf(-d2) - q * S * dq * normCdf(-d1)) / 365;

    return {
        d1, d2, call, put, gamma, vega,
        delta: { call: dq * normCdf(d1), put: dq * (normCdf(d1) - 1) },
        theta: { call: thetaCall, put: thetaPut },
        rho: { call: (K * T * dr * normCdf(d2)) / 100, put: (-K * T * dr * normCdf(-d2)) / 100 },
    };
}

// Bonds ------------------------------------------------------------------------------------------

const parseDate = (text) => {
    const m = /^(\d{4})-(\d{2})-(\d{2})$/.exec(String(text ?? ''));

    return m ? { y: Number(m[1]), m: Number(m[2]), d: Number(m[3]) } : null;
};
const toDays = ({ y, m, d }) => Date.UTC(y, m - 1, d) / 86400000;
const addMonths = ({ y, m, d }, months) => {
    const total = y * 12 + (m - 1) + months;
    const year = Math.floor(total / 12);
    const month = (total % 12) + 1;
    const last = new Date(Date.UTC(year, month, 0)).getUTCDate();

    return { y: year, m: month, d: Math.min(d, last) };
};
const days30360 = (a, b) => 360 * (b.y - a.y) + 30 * (b.m - a.m) + (Math.min(b.d, 30) - Math.min(a.d, 30));

/**
 * Coupon schedule seen from the settlement date: previous and next coupon dates (stepping back from maturity),
 * the number of coupons left, accrued interest and the fraction of a period to the next coupon.
 */
export function bondSchedule(settle, maturity, freq, basis) {
    const step = 12 / freq;
    let next = maturity;
    let count = 1;

    while (toDays(addMonths(next, -step)) > toDays(settle)) {
        next = addMonths(next, -step);
        count += 1;
    }

    const prev = addMonths(next, -step);
    const thirty = basis === '30360';
    const period = thirty ? 360 / freq : toDays(next) - toDays(prev);
    const accruedDays = thirty ? days30360(prev, settle) : toDays(settle) - toDays(prev);

    return { prev, next, count, accruedFraction: accruedDays / period, toNext: 1 - accruedDays / period, accruedDays, period };
}

/**
 * Dirty price per 100 of face at a yield (street convention: compounded at the coupon frequency).
 */
export function bondDirty(schedule, couponRate, yieldRate, freq, redemption = 100) {
    const c = (100 * couponRate) / freq;
    const v = 1 + yieldRate / freq;
    let price = 0;

    for (let k = 0; k < schedule.count; k += 1) {
        const t = schedule.toNext + k;
        price += (c + (k === schedule.count - 1 ? redemption : 0)) / v ** t;
    }

    return price;
}

function bondMeasures(schedule, couponRate, y, freq, redemption = 100) {
    const c = (100 * couponRate) / freq;
    const v = 1 + y / freq;
    let price = 0;
    let weighted = 0;
    let convex = 0;

    for (let k = 0; k < schedule.count; k += 1) {
        const t = schedule.toNext + k;
        const cf = c + (k === schedule.count - 1 ? redemption : 0);
        const pv = cf / v ** t;
        price += pv;
        weighted += t * pv;
        convex += (cf * t * (t + 1)) / v ** (t + 2);
    }

    const macaulay = weighted / price / freq;

    return { price, macaulay, modified: macaulay / v, convexity: convex / (price * freq * freq) };
}

function bondInputs(i) {
    const settle = parseDate(i.settle);
    const maturity = parseDate(i.maturity);
    const freq = Number(i.freq ?? 2);

    if (!settle || !maturity || toDays(maturity) <= toDays(settle) || !ok(i.coupon)) {
        return null;
    }

    return { settle, maturity, freq, schedule: bondSchedule(settle, maturity, freq, i.basis ?? 'act'), coupon: P(i.coupon), face: ok(i.face) ? i.face : 1000 };
}

const yieldFromPrice = (schedule, coupon, freq, dirty, redemption = 100) => solve((y) => bondDirty(schedule, coupon, y, freq, redemption) - dirty, -0.5, 2, 2000);

const dateText = ({ y, m, d }) => new Date(Date.UTC(y, m - 1, d)).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', timeZone: 'UTC' });

// Options ----------------------------------------------------------------------------------------

function legsOf(text) {
    return parseRows(text)
        .map((cells) => ({ type: String(cells[0]).toLowerCase().startsWith('p') ? 'put' : String(cells[0]).toLowerCase().startsWith('s') ? 'stock' : 'call', side: String(cells[1]).toLowerCase().startsWith('s') ? -1 : 1, strike: Number(cells[2]), premium: Number(cells[3]), qty: Number(cells[4] || 1) }))
        .filter((leg) => ok(leg.strike, leg.premium, leg.qty));
}

const legValue = (leg, price) => {
    const intrinsic = leg.type === 'call' ? Math.max(0, price - leg.strike) : leg.type === 'put' ? Math.max(0, leg.strike - price) : price - leg.strike;

    return leg.side * leg.qty * (intrinsic - (leg.type === 'stock' ? 0 : leg.premium));
};

function payoffSummary(legs, multiplier, s) {
    const strikes = legs.map((leg) => leg.strike);
    const lo = Math.max(0, Math.min(...strikes) * 0.5);
    const hi = Math.max(...strikes) * 1.5;
    const profit = (price) => legs.reduce((sum, leg) => sum + legValue(leg, price), 0) * multiplier;
    const series = [];

    for (let k = 0; k <= 200; k += 1) {
        const price = lo + ((hi - lo) * k) / 200;
        series.push([price, profit(price)]);
    }

    // Beyond the chart the payoff is linear: its slope decides whether the profit or loss is unlimited.
    const slopeUp = profit(hi * 10) - profit(hi * 9);
    const values = [0, ...strikes].map(profit).concat(series.map(([, v]) => v));
    const maxProfit = slopeUp > 1e-9 ? Infinity : Math.max(...values);
    const maxLoss = slopeUp < -1e-9 ? -Infinity : Math.min(...values);
    const breakEvens = [];

    for (let k = 1; k < series.length; k += 1) {
        const [x0, y0] = series[k - 1];
        const [x1, y1] = series[k];

        if ((y0 < 0 && y1 >= 0) || (y0 > 0 && y1 <= 0)) {
            breakEvens.push(x0 + ((x1 - x0) * -y0) / (y1 - y0));
        }
    }

    return {
        profit, series, breakEvens,
        maxProfitText: maxProfit === Infinity ? 'Unlimited' : money(maxProfit, s),
        maxLossText: maxLoss === -Infinity ? 'Unlimited' : money(maxLoss, s),
        net: legs.reduce((sum, leg) => sum + (leg.type === 'stock' ? -leg.side * leg.qty * leg.strike : -leg.side * leg.qty * leg.premium), 0) * multiplier,
    };
}

const singleOption = (type) => (i, c) => {
    const s = symbolOf(c);

    if (!ok(i.strike, i.premium, i.price) || i.strike <= 0) {
        return { empty: 'Enter the strike, premium and stock price at expiry.' };
    }

    const contracts = ok(i.contracts) ? i.contracts : 1;
    const side = i.side === 'short' ? -1 : 1;
    const legs = [{ type, side, strike: i.strike, premium: i.premium, qty: contracts }];
    const summary = payoffSummary(legs, 100, s);
    const result = summary.profit(i.price);
    const breakEven = type === 'call' ? i.strike + i.premium : i.strike - i.premium;
    const intrinsic = type === 'call' ? Math.max(0, i.price - i.strike) : Math.max(0, i.strike - i.price);

    return {
        value: money(result, s),
        label: `Profit or loss at ${money(i.price, s)}`,
        sub: `${side > 0 ? 'Long' : 'Short'} ${num(contracts)} ${type} contract${contracts === 1 ? '' : 's'} (100 shares each)`,
        rows: {
            breakeven: money(breakEven, s),
            max_profit: summary.maxProfitText,
            max_loss: summary.maxLossText,
            intrinsic: `${money(intrinsic, s)} a share at expiry`,
            premium: `${money(i.premium * 100 * contracts, s)} ${side > 0 ? 'paid' : 'received'}`,
            roi: side > 0 ? pct(result / (i.premium * 100 * contracts)) : `${pct(result / (i.premium * 100 * contracts))} of the premium kept`,
        },
        plots: { chart: { series: summary.series, xLabel: `Stock price at expiry (${s})`, yLabel: `Profit (${s})`, markers: [{ x: breakEven, y: 0, label: 'Break-even' }] } },
    };
};

/**
 * Wilder's RSI: first average gain/loss is the simple mean of the first `n` changes, then smoothed by (n − 1)/n.
 */
export function wilderRsi(prices, n) {
    const changes = prices.slice(1).map((p, k) => p - prices[k]);
    let gain = changes.slice(0, n).reduce((sum, x) => sum + Math.max(0, x), 0) / n;
    let loss = changes.slice(0, n).reduce((sum, x) => sum + Math.max(0, -x), 0) / n;
    const out = [loss === 0 ? 100 : 100 - 100 / (1 + gain / loss)];

    changes.slice(n).forEach((x) => {
        gain = (gain * (n - 1) + Math.max(0, x)) / n;
        loss = (loss * (n - 1) + Math.max(0, -x)) / n;
        out.push(loss === 0 ? 100 : 100 - 100 / (1 + gain / loss));
    });

    return out;
}

export const handlers = {
    beta: (i) => {
        const a = numberList(i.stock).map(P);
        const b = numberList(i.market).map(P);
        const n = Math.min(a.length, b.length);

        if (n < 3) {
            return { empty: 'Enter at least three matching returns for the stock and the market.' };
        }

        const x = b.slice(0, n);
        const y = a.slice(0, n);
        const mx = x.reduce((s, v) => s + v, 0) / n;
        const my = y.reduce((s, v) => s + v, 0) / n;
        const cov = x.reduce((s, v, k) => s + (v - mx) * (y[k] - my), 0) / (n - 1);
        const varX = x.reduce((s, v) => s + (v - mx) ** 2, 0) / (n - 1);
        const varY = y.reduce((s, v) => s + (v - my) ** 2, 0) / (n - 1);

        if (varX === 0) {
            return { error: 'The market returns do not vary, so beta is undefined.' };
        }

        const beta = cov / varX;
        const corr = cov / Math.sqrt(varX * varY);

        return {
            value: num(beta),
            label: 'Beta',
            sub: beta > 1 ? 'More volatile than the market' : beta < 0 ? 'Moves against the market' : 'Less volatile than the market',
            rows: { correlation: num(corr), r2: pct(corr * corr), alpha: `${pct(my - beta * mx)} a period`, periods: num(n) },
        };
    },

    carried_interest: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.capital, i.proceeds, i.hurdle, i.years, i.carry) || i.capital <= 0) {
            return { empty: 'Enter capital, proceeds, hurdle, years and carry.' };
        }

        // European (whole-fund) waterfall: return of capital, preferred return, GP catch-up, then the carry split.
        const carry = P(i.carry);
        const profit = i.proceeds - i.capital;
        const preferred = i.capital * ((1 + P(i.hurdle)) ** i.years - 1);
        let left = Math.max(0, profit);
        const lpPref = Math.min(left, preferred);
        left -= lpPref;
        let gp = 0;

        if (i.catchup !== 'none') {
            // Full catch-up: the GP takes 100% until it holds carry% of profits so far.
            const catchUp = Math.min(left, (carry * lpPref) / (1 - carry));
            gp += catchUp;
            left -= catchUp;
        }

        gp += left * carry;
        const lp = Math.max(0, profit) - gp;

        return {
            value: money(gp, s),
            label: 'Carried interest to the GP',
            sub: profit > preferred ? `${pct(gp / Math.max(profit, 1e-9))} of ${money(profit, s)} profit` : 'The hurdle was not cleared, so no carry is earned',
            rows: { profit: money(profit, s), preferred: money(preferred, s), lp: money(lp, s), multiple: `${num(i.proceeds / i.capital)}× gross, ${num((i.capital + lp) / i.capital)}× to LPs` },
        };
    },

    wacc: (i) => {
        if (!ok(i.equity, i.debt, i.re, i.rd) || i.equity + i.debt <= 0) {
            return { empty: 'Enter the values and costs of equity and debt.' };
        }

        const v = i.equity + i.debt;
        const t = P(or0(i.tax));
        const wacc = (i.equity / v) * P(i.re) + (i.debt / v) * P(i.rd) * (1 - t);

        return {
            value: num(wacc * 100),
            unit: '%',
            label: 'WACC',
            sub: 'weighted average cost of capital',
            rows: { we: pct(i.equity / v), wd: pct(i.debt / v), rd: pct(P(i.rd) * (1 - t)), equity: pct((i.equity / v) * P(i.re)) },
        };
    },

    cost_of_equity: (i) => {
        if (i.mode === 'ddm') {
            if (!ok(i.dividend, i.price, i.growth) || i.price <= 0) {
                return { empty: 'Enter next year\'s dividend, the price and growth.' };
            }

            const re = i.dividend / i.price + P(i.growth);

            return { value: num(re * 100), unit: '%', label: 'Cost of equity (dividend growth model)', sub: 'Rₑ = D₁ ÷ P₀ + g', rows: { yield: pct(i.dividend / i.price), growth: pct(P(i.growth)) } };
        }

        if (!ok(i.rf, i.beta, i.mrp)) {
            return { empty: 'Enter the risk-free rate, beta and market risk premium.' };
        }

        const re = P(i.rf) + i.beta * P(i.mrp);

        return { value: num(re * 100), unit: '%', label: 'Cost of equity (CAPM)', sub: 'Rₑ = Rf + β × MRP', rows: { premium: pct(i.beta * P(i.mrp)), rf: pct(P(i.rf)) } };
    },

    dividend: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.shares, i.dps) || i.shares <= 0) {
            return { empty: 'Enter shares and the annual dividend per share.' };
        }

        const yearly = i.shares * i.dps;
        const per = Number(i.freq ?? 4);
        const years = Math.round(or0(i.years));
        const price = ok(i.price) && i.price > 0 ? i.price : NaN;
        let shares = i.shares;
        let dps = i.dps;
        let p = price;

        // Dividend reinvestment: each payment buys shares at that year's price.
        for (let y = 0; y < years && Number.isFinite(p); y += 1) {
            shares += (shares * dps) / p;
            dps *= 1 + P(or0(i.growth));
            p *= 1 + P(or0(i.appreciation));
        }

        return {
            value: money(yearly, s),
            label: 'Dividends a year',
            sub: `${money(yearly / per, s)} each payment, ${per} times a year`,
            rows: {
                yield: Number.isFinite(price) ? pct(i.dps / price) : 'Enter the share price',
                monthly: money(yearly / 12, s),
                drip: Number.isFinite(price) && years ? `${num(shares)} shares worth ${money(shares * p, s)} after ${years} years, paying ${money(shares * dps, s)} a year` : 'Enter price and years for reinvestment',
                cost: Number.isFinite(price) ? money(i.shares * price, s) : '—',
            },
        };
    },

    ddm: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.dividend, i.rate, i.growth)) {
            return { empty: 'Enter the dividend, required return and growth.' };
        }

        const r = P(i.rate);
        const g = P(i.growth);

        if (i.mode === 'two') {
            if (!ok(i.years, i.terminal) || P(i.terminal) >= r) {
                return { error: 'Enter years of high growth and a long-run growth rate below the required return.' };
            }

            let d = i.dividend;
            let value = 0;

            for (let t = 1; t <= i.years; t += 1) {
                d *= 1 + g;
                value += d / (1 + r) ** t;
            }

            const terminal = (d * (1 + P(i.terminal))) / (r - P(i.terminal));
            value += terminal / (1 + r) ** i.years;

            return { value: money(value, s), label: 'Intrinsic value per share (two-stage)', sub: `${pct(terminal / (1 + r) ** i.years / value)} of it from the terminal value`, rows: { d1_two: money(i.dividend * (1 + g), s), terminal: money(terminal, s), price_two: ok(i.price) ? `${pct(Math.abs(i.price / value - 1))} ${i.price > value ? 'above' : 'below'} value` : 'Enter the price to compare' } };
        }

        if (g >= r) {
            return { error: 'Growth must be below the required return for the Gordon model.' };
        }

        const d1 = i.dividend * (1 + g);
        const value = d1 / (r - g);

        return { value: money(value, s), label: 'Intrinsic value per share (Gordon)', sub: `D₁ ${money(d1, s)} ÷ (${pct(r)} − ${pct(g)})`, rows: { d1: money(d1, s), price: ok(i.price) ? `${pct(Math.abs(i.price / value - 1))} ${i.price > value ? 'above' : 'below'} value` : 'Enter the price to compare', implied: ok(i.price) && i.price > 0 ? `${pct(d1 / i.price + g)} return at today\'s price` : '—' } };
    },

    dupont: (i) => {
        if (!ok(i.income, i.revenue, i.assets, i.equity) || i.revenue <= 0 || i.assets <= 0 || i.equity <= 0) {
            return { empty: 'Enter net income, revenue, average assets and equity.' };
        }

        const margin = i.income / i.revenue;
        const turnover = i.revenue / i.assets;
        const leverage = i.assets / i.equity;
        const five = ok(i.ebt, i.ebit) && i.ebt !== 0 && i.ebit !== 0 && i.revenue !== 0;

        return {
            value: num(margin * turnover * leverage * 100),
            unit: '%',
            label: 'Return on equity',
            sub: `${pct(margin)} margin × ${num(turnover)} turnover × ${num(leverage)} leverage`,
            rows: {
                margin: pct(margin),
                turnover: `${num(turnover)}×`,
                leverage: `${num(leverage)}×`,
                five: five ? `tax burden ${num(i.income / i.ebt)} × interest burden ${num(i.ebt / i.ebit)} × EBIT margin ${pct(i.ebit / i.revenue)} × turnover × leverage` : 'Enter EBT and EBIT for the 5-step version',
            },
        };
    },

    intrinsic: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.fcf, i.growth, i.years, i.rate, i.terminal) || P(i.terminal) >= P(i.rate)) {
            return { empty: 'Enter cash flow per share, growth, years and rates (terminal growth below the discount rate).' };
        }

        let flow = i.fcf;
        let value = 0;

        for (let t = 1; t <= i.years; t += 1) {
            flow *= 1 + P(i.growth);
            value += flow / (1 + P(i.rate)) ** t;
        }

        const terminal = (flow * (1 + P(i.terminal))) / (P(i.rate) - P(i.terminal));
        value += terminal / (1 + P(i.rate)) ** i.years;

        return {
            value: money(value, s),
            label: 'Intrinsic value per share',
            sub: `free cash flow to equity discounted at ${pct(P(i.rate))}`,
            rows: { terminal: money(terminal / (1 + P(i.rate)) ** i.years, s), share: pct(terminal / (1 + P(i.rate)) ** i.years / value), mos: ok(i.price) ? `${pct((value - i.price) / value)} margin of safety at ${money(i.price, s)}` : 'Enter the price', pe: ok(i.eps) && i.eps > 0 ? `${num(value / i.eps)}× earnings` : '—' },
        };
    },

    portfolio_beta: (i, c) => {
        const rows = parseRows(i.holdings).map((cells, k) => ({ name: cells[0] || `Holding ${k + 1}`, value: Number(cells[1]), beta: Number(cells[2]) })).filter((h) => ok(h.value, h.beta) && h.value > 0);

        if (!rows.length) {
            return { empty: 'Add holdings with a value and a beta.' };
        }

        const total = rows.reduce((sum, h) => sum + h.value, 0);
        const beta = rows.reduce((sum, h) => sum + (h.value / total) * h.beta, 0);

        return {
            value: num(beta),
            label: 'Portfolio beta',
            sub: `a 10% market move suggests about ${pct(beta * 0.1)} for the portfolio`,
            rows: { total: money(total, symbolOf(c)), highest: rows.reduce((a, b) => (b.beta > a.beta ? b : a)).name, count: num(rows.length), hedge: money(-beta * total, symbolOf(c)) },
            lists: { weights: rows.map((h) => ({ label: h.name, value: `${pct(h.value / total)} × β ${num(h.beta)}` })) },
        };
    },

    stock: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.shares, i.buy, i.sell) || i.shares <= 0) {
            return { empty: 'Enter shares, buy and sell price.' };
        }

        const fees = or0(i.buy_fee) + or0(i.sell_fee);
        const cost = i.shares * i.buy + or0(i.buy_fee);
        const profit = i.shares * (i.sell - i.buy) - fees;
        const tax = P(or0(i.tax));

        return {
            value: money(profit, s),
            label: profit >= 0 ? 'Profit' : 'Loss',
            sub: `${pct(profit / cost)} return on ${money(cost, s)}`,
            rows: { cost: money(cost, s), proceeds: money(i.shares * i.sell - or0(i.sell_fee), s), breakeven: money((cost + or0(i.sell_fee)) / i.shares, s), after: tax && profit > 0 ? money(profit * (1 - tax), s) : money(profit, s) },
        };
    },

    stock_average: (i, c) => {
        const s = symbolOf(c);
        const buys = parseRows(i.buys).map((cells) => ({ shares: Number(cells[0]), price: Number(cells[1]) })).filter((b) => ok(b.shares, b.price) && b.shares > 0);

        if (!buys.length) {
            return { empty: 'Add purchases with shares and price.' };
        }

        const shares = buys.reduce((sum, b) => sum + b.shares, 0);
        const cost = buys.reduce((sum, b) => sum + b.shares * b.price, 0);
        const avg = cost / shares;
        const now = ok(i.price) ? i.price : NaN;

        return {
            value: money(avg, s),
            label: 'Average price per share',
            sub: `${num(shares)} shares for ${money(cost, s)}`,
            rows: { shares: num(shares), cost: money(cost, s), value: Number.isFinite(now) ? money(shares * now, s) : 'Enter the current price', pl: Number.isFinite(now) ? `${money(shares * (now - avg), s)} (${pct(now / avg - 1)})` : '—' },
        };
    },

    altman: (i) => {
        if (!ok(i.wc, i.re, i.ebit, i.equity, i.sales, i.assets, i.liabilities) || i.assets <= 0 || i.liabilities <= 0) {
            return { empty: 'Enter the balance sheet and income figures.' };
        }

        const A = i.wc / i.assets;
        const B = i.re / i.assets;
        const C = i.ebit / i.assets;
        const D = i.equity / i.liabilities;
        const E = i.sales / i.assets;
        const model = i.model ?? 'public';
        const [z, safe, distress, name] = model === 'private'
            ? [0.717 * A + 0.847 * B + 3.107 * C + 0.420 * D + 0.998 * E, 2.9, 1.23, "Z' (private manufacturers, book equity)"]
            : model === 'nonmfg'
                ? [6.56 * A + 3.26 * B + 6.72 * C + 1.05 * D, 2.6, 1.1, "Z'' (non-manufacturers and emerging markets, book equity)"]
                : [1.2 * A + 1.4 * B + 3.3 * C + 0.6 * D + 1.0 * E, 2.99, 1.81, 'Original Z (public manufacturers, market equity)'];

        return {
            value: num(z),
            label: 'Altman Z-score',
            sub: z > safe ? 'Safe zone' : z < distress ? 'Distress zone: higher risk of bankruptcy within two years' : 'Grey zone',
            rows: { model: name, zones: `Distress below ${distress}, safe above ${safe}`, ratios: `A ${num(A)}, B ${num(B)}, C ${num(C)}, D ${num(D)}${model === 'nonmfg' ? '' : `, E ${num(E)}`}`, note: 'A screening model from 1968 (revised 1983, 1995), not a forecast' },
        };
    },

    bond_price: (i, c) => {
        const s = symbolOf(c);
        const b = bondInputs(i);

        if (!b || !ok(i.ytm)) {
            return { empty: 'Enter settlement and maturity dates, coupon and yield.' };
        }

        const m = bondMeasures(b.schedule, b.coupon, P(i.ytm), b.freq);
        const accrued = (100 * b.coupon * b.schedule.accruedFraction) / b.freq;
        const clean = m.price - accrued;
        const scale = b.face / 100;

        return {
            value: money(clean * scale, s),
            label: 'Clean price',
            sub: `${num(clean)} per 100 of face; dirty ${money(m.price * scale, s)}`,
            rows: {
                dirty: money(m.price * scale, s),
                accrued: `${money(accrued * scale, s)} (${num(b.schedule.accruedDays)} days since ${dateText(b.schedule.prev)})`,
                current: pct((b.coupon * 100) / clean),
                coupons: `${num(b.schedule.count)} left, next on ${dateText(b.schedule.next)}`,
                duration: `Macaulay ${num(m.macaulay)} years, modified ${num(m.modified)}`,
                premium: clean > 100 ? 'Trades at a premium (coupon above yield)' : clean < 100 ? 'Trades at a discount (coupon below yield)' : 'Trades at par',
            },
        };
    },

    bond_yield: (i, c) => {
        const s = symbolOf(c);
        const b = bondInputs(i);

        if (!b || !ok(i.price) || i.price <= 0) {
            return { empty: 'Enter settlement and maturity dates, coupon and clean price.' };
        }

        const accrued = (100 * b.coupon * b.schedule.accruedFraction) / b.freq;
        const clean = (i.price / b.face) * 100;
        const y = yieldFromPrice(b.schedule, b.coupon, b.freq, clean + accrued);
        let ytc = NaN;
        const callDate = parseDate(i.call_date);

        if (callDate && ok(i.call_price) && toDays(callDate) > toDays(b.settle)) {
            const callSchedule = bondSchedule(b.settle, callDate, b.freq, i.basis ?? 'act');
            ytc = yieldFromPrice(callSchedule, b.coupon, b.freq, clean + accrued, (i.call_price / b.face) * 100) ?? NaN;
        }

        if (y === null) {
            return { error: 'No yield between −50% and 200% matches this price.' };
        }

        return {
            value: num(y * 100),
            unit: '%',
            label: 'Yield to maturity',
            sub: `bond-equivalent, compounded ${b.freq === 2 ? 'semi-annually' : b.freq === 1 ? 'annually' : `${b.freq} times a year`}`,
            rows: {
                current: pct((b.coupon * 100) / clean),
                ytc: Number.isFinite(ytc) ? pct(ytc) : 'Enter a call date and price',
                worst: Number.isFinite(ytc) ? pct(Math.min(y, ytc)) : pct(y),
                effective: pct((1 + y / b.freq) ** b.freq - 1),
                accrued: money((accrued * b.face) / 100, s),
            },
        };
    },

    duration: (i) => {
        const b = bondInputs(i);

        if (!b || !ok(i.ytm)) {
            return { empty: 'Enter dates, coupon and yield.' };
        }

        const m = bondMeasures(b.schedule, b.coupon, P(i.ytm), b.freq);
        const shift = P(ok(i.shift) ? i.shift : 1);

        return {
            value: num(m.macaulay),
            unit: 'years',
            label: 'Macaulay duration',
            sub: `modified duration ${num(m.modified)}`,
            rows: {
                modified: num(m.modified),
                convexity: num(m.convexity),
                change: `${pct(-m.modified * shift + 0.5 * m.convexity * shift * shift)} price change for a ${pct(shift)} rise in yield`,
                dv01: `${num((m.modified * m.price) / 10000)} per 100 of face per basis point`,
            },
        };
    },

    convexity: (i) => {
        const b = bondInputs(i);

        if (!b || !ok(i.ytm)) {
            return { empty: 'Enter dates, coupon and yield.' };
        }

        const m = bondMeasures(b.schedule, b.coupon, P(i.ytm), b.freq);
        const shift = P(ok(i.shift) ? i.shift : 1);
        const exact = bondDirty(b.schedule, b.coupon, P(i.ytm) + shift, b.freq) / m.price - 1;

        return {
            value: num(m.convexity),
            label: 'Convexity',
            sub: `modified duration ${num(m.modified)}`,
            rows: {
                duration: pct(-m.modified * shift),
                withConvexity: pct(-m.modified * shift + 0.5 * m.convexity * shift * shift),
                exact: pct(exact),
                macaulay: `${num(m.macaulay)} years`,
            },
        };
    },

    effective_duration: (i) => {
        if (!ok(i.price, i.down, i.up, i.shift) || i.price <= 0 || i.shift <= 0) {
            return { empty: 'Enter the price and the prices after yields fall and rise.' };
        }

        const dy = P(i.shift);
        const duration = (i.down - i.up) / (2 * i.price * dy);
        const convexity = (i.down + i.up - 2 * i.price) / (i.price * dy * dy);

        return {
            value: num(duration),
            label: 'Effective duration',
            sub: `about ${pct(duration * 0.01)} price change per 1% yield move`,
            rows: { convexity: num(convexity), change: pct(-duration * 0.01 + 0.5 * convexity * 0.0001), dv01: num((duration * i.price) / 10000), shift: `${num(i.shift * 100)} bp` },
        };
    },

    black_scholes: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.spot, i.strike, i.days, i.rate, i.vol) || i.spot <= 0 || i.strike <= 0 || i.days <= 0 || i.vol <= 0) {
            return { empty: 'Enter stock price, strike, days, rate and volatility.' };
        }

        const T = i.days / 365;
        const m = blackScholes(i.spot, i.strike, T, P(i.rate), P(or0(i.divyield)), P(i.vol));

        return {
            value: money(m.call, s),
            label: 'Call value',
            sub: `put ${money(m.put, s)}`,
            rows: {
                put: money(m.put, s),
                delta: `call ${num(m.delta.call)}, put ${num(m.delta.put)}`,
                gamma: num(m.gamma),
                vega: `${money(m.vega, s)} per 1 point of volatility`,
                theta: `call ${money(m.theta.call, s)}, put ${money(m.theta.put, s)} a day`,
                rho: `call ${money(m.rho.call, s)}, put ${money(m.rho.put, s)} per 1% rate`,
                d: `d₁ ${num(m.d1)}, d₂ ${num(m.d2)}`,
            },
        };
    },

    call_option: singleOption('call'),
    put_option: singleOption('put'),

    spread: (i, c) => {
        const s = symbolOf(c);
        const legs = legsOf(i.legs);

        if (!legs.length) {
            return { empty: 'Add option legs: type, buy or sell, strike, premium and contracts.' };
        }

        const summary = payoffSummary(legs, 100, s);
        const at = ok(i.price) ? i.price : NaN;

        return {
            value: Number.isFinite(at) ? money(summary.profit(at), s) : summary.maxProfitText,
            label: Number.isFinite(at) ? `Profit or loss at ${money(at, s)}` : 'Maximum profit',
            sub: `${summary.net >= 0 ? 'Net credit' : 'Net debit'} of ${money(Math.abs(summary.net), s)} to open`,
            rows: { max_profit: summary.maxProfitText, max_loss: summary.maxLossText, breakeven: summary.breakEvens.length ? summary.breakEvens.map((x) => money(x, s)).join(', ') : 'None', legs: num(legs.length) },
            plots: { chart: { series: summary.series, xLabel: `Stock price at expiry (${s})`, yLabel: `Profit (${s})`, markers: summary.breakEvens.map((x) => ({ x, y: 0, label: 'BE' })) } },
        };
    },

    fibonacci: (i) => {
        if (!ok(i.high, i.low) || i.high <= i.low) {
            return { empty: 'Enter a swing high above the swing low.' };
        }

        const range = i.high - i.low;
        const up = i.trend !== 'down';
        const levels = [0, 0.236, 0.382, 0.5, 0.618, 0.786, 1];
        const extensions = [1.272, 1.618, 2.618];
        const at = (r) => (up ? i.high - range * r : i.low + range * r);
        const ext = (r) => (up ? i.low + range * r : i.high - range * r);

        return {
            value: num(at(0.618)),
            label: '61.8% retracement',
            sub: up ? 'pullback levels in an uptrend (measured down from the high)' : 'bounce levels in a downtrend (measured up from the low)',
            rows: { r382: num(at(0.382)), r50: num(at(0.5)), r786: num(at(0.786)), range: num(range) },
            lists: { levels: levels.map((r) => ({ label: `${num(r * 100)}%`, value: num(at(r)), highlight: r === 0.618 })).concat(extensions.map((r) => ({ label: `${num(r * 100)}% extension`, value: num(ext(r)) }))) },
        };
    },

    pivots: (i) => {
        if (!ok(i.high, i.low, i.close) || i.high < i.low) {
            return { empty: 'Enter the previous high, low and close.' };
        }

        const { high: H, low: L, close: C } = i;
        const range = H - L;
        const method = i.method ?? 'classic';
        let pp = (H + L + C) / 3;
        let levels;

        if (method === 'fibonacci') {
            levels = { R3: pp + range, R2: pp + 0.618 * range, R1: pp + 0.382 * range, S1: pp - 0.382 * range, S2: pp - 0.618 * range, S3: pp - range };
        } else if (method === 'woodie') {
            pp = (H + L + 2 * C) / 4;
            levels = { R2: pp + range, R1: 2 * pp - L, S1: 2 * pp - H, S2: pp - range };
        } else if (method === 'camarilla') {
            levels = { R4: C + (range * 1.1) / 2, R3: C + (range * 1.1) / 4, R2: C + (range * 1.1) / 6, R1: C + (range * 1.1) / 12, S1: C - (range * 1.1) / 12, S2: C - (range * 1.1) / 6, S3: C - (range * 1.1) / 4, S4: C - (range * 1.1) / 2 };
        } else {
            levels = { R3: H + 2 * (pp - L), R2: pp + range, R1: 2 * pp - L, S1: 2 * pp - H, S2: pp - range, S3: L - 2 * (H - pp) };
        }

        const entries = Object.entries(levels);

        return {
            value: num(pp),
            label: 'Pivot point',
            sub: `${method[0].toUpperCase()}${method.slice(1)} pivots from the previous period`,
            rows: { r1: num(levels.R1), s1: num(levels.S1), range: num(range), method: method[0].toUpperCase() + method.slice(1) },
            lists: { levels: [...entries.filter(([k]) => k.startsWith('R')), ['PP', pp], ...entries.filter(([k]) => k.startsWith('S'))].map(([k, v]) => ({ label: k, value: num(v), highlight: k === 'PP' })) },
        };
    },

    rsi: (i) => {
        const prices = numberList(i.prices);
        const n = Math.round(i.period);

        if (!(n >= 2) || prices.length < n + 1) {
            return { empty: `Enter at least ${Number.isFinite(n) ? n + 1 : 15} prices and a period.` };
        }

        const values = wilderRsi(prices, n);
        const last = values[values.length - 1];

        return {
            value: num(last),
            label: `RSI (${n})`,
            sub: last >= 70 ? 'Overbought (70 or above)' : last <= 30 ? 'Oversold (30 or below)' : 'Neutral (between 30 and 70)',
            rows: { previous: values.length > 1 ? num(values[values.length - 2]) : '—', high: num(Math.max(...values)), low: num(Math.min(...values)), count: num(values.length) },
            plots: { chart: { series: values.map((v, k) => [k + n + 1, v]), xLabel: 'Price number', yLabel: 'RSI', yTicks: [0, 30, 50, 70, 100] } },
        };
    },

    pvgo: (i, c) => {
        const s = symbolOf(c);

        if (!ok(i.price, i.eps, i.rate) || i.rate <= 0) {
            return { empty: 'Enter the price, EPS and cost of equity.' };
        }

        const noGrowth = i.eps / P(i.rate);
        const pvgo = i.price - noGrowth;

        return {
            value: money(pvgo, s),
            label: 'Present value of growth opportunities',
            sub: `${pct(pvgo / i.price)} of the price is for growth`,
            rows: { nogrowth: money(noGrowth, s), share: pct(pvgo / i.price), pe: `${num(i.price / i.eps)}×`, nogrowthPe: `${num(1 / P(i.rate))}×` },
        };
    },

    irp: (i) => {
        if (!ok(i.spot, i.rd, i.rf, i.days) || i.spot <= 0) {
            return { empty: 'Enter the spot rate, both interest rates and days.' };
        }

        const basis = Number(i.basis ?? 360);
        const t = i.days / basis;
        const forward = (i.spot * (1 + P(i.rd) * t)) / (1 + P(i.rf) * t);
        const quoted = ok(i.forward) ? i.forward : NaN;

        return {
            value: num(forward),
            label: 'Forward rate by covered interest parity',
            sub: forward > i.spot ? 'The base currency trades at a forward premium' : 'The base currency trades at a forward discount',
            rows: {
                points: num((forward - i.spot) * (i.spot >= 20 ? 100 : 10000)),
                premium: pct(((forward - i.spot) / i.spot) * (basis / i.days)),
                arbitrage: Number.isFinite(quoted) ? `${num((quoted - forward) * (i.spot >= 20 ? 100 : 10000))} points ${quoted > forward ? 'above' : 'below'} parity` : 'Enter a quoted forward to compare',
                continuous: num(i.spot * Math.exp((P(i.rd) - P(i.rf)) * t)),
            },
        };
    },
};

export default defineTools(handlers);
