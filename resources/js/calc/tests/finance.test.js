import assert from 'node:assert/strict';
import { execSync } from 'node:child_process';
import test from 'node:test';
import { amortize, apr, cardPayoff, payoffPlan } from '../finance/loans.js';
import { fv, irrs, mirr, nper, pmt, rate } from '../finance/tvm.js';
import { checkDigit, macrsRates } from '../tools/fin-biz.js';
import { newRegime, oldRegime, sip } from '../tools/fin-india.js';
import { claimFactor, fullRetirementMonths, handlers as invest, rothAllowed } from '../tools/fin-invest.js';
import { lotteryAnnuity } from '../tools/fin-life.js';
import { handlers as loans } from '../tools/fin-loans.js';
import { blackScholes, handlers as markets, wilderRsi } from '../tools/fin-markets.js';
import { overtimeWeek } from '../tools/fin-pay.js';
import { handlers as simple } from '../tools/fin-simple.js';
import { federalTax, fica, stateTax, handlers as tax } from '../tools/fin-tax.js';

const DATA = JSON.parse(execSync(`php -r 'echo json_encode(require "config/finance_data.php");'`, { maxBuffer: 1e8 }).toString());
const close = (actual, expected, tolerance) => assert.ok(Math.abs(Number(actual) - expected) <= tolerance, `${actual} ≠ ${expected}`);
const amount = (text) => Number(String(text).replace(/[^0-9.−-]/g, '').replace('−', '-'));

test('time value of money matches spreadsheet functions', () => {
    close(pmt(0.06 / 12, 360, 200000), -1199.101, 0.001);
    close(fv(0.05 / 12, 120, -100, -10000), 31998.32, 0.01);
    close(nper(0.015, -200, 5000), 31.57, 0.01);
    close(rate(60, -400, 20000) * 12, 0.0742, 0.0001);
    close(mirr([-120000, 39000, 30000, 21000, 37000, 46000], 0.1, 0.12), 0.126094, 0.000001);
    assert.deepEqual(irrs([-100, 230, -132]).map((r) => Math.round(r * 1000) / 1000), [0.1, 0.2]);
});

test('loans: amortization, APR and payoff strategies', () => {
    const loan = amortize({ principal: 200000, annualRate: 0.06, years: 30 });
    close(loan.level, 1199.1, 0.01);
    close(loan.totalInterest, 231676.38, 0.05);
    const extra = amortize({ principal: 200000, annualRate: 0.06, years: 30, extra: 200 });
    assert.ok(extra.periods < 360 && extra.totalInterest < loan.totalInterest);
    close(apr(10000 - 500, 322.67, 36) * 100, 13.56, 0.05);
    assert.equal(cardPayoff({ balance: 1000, apr: 0.2, payment: 10 }).never, true);
    const debts = [{ name: 'Card', balance: 6500, rate: 0.2499, minimum: 160 }, { name: 'Car', balance: 14000, rate: 0.075, minimum: 380 }, { name: 'Small', balance: 4000, rate: 0.115, minimum: 130 }];
    assert.ok(payoffPlan(debts, 1200, 'avalanche').interest <= payoffPlan(debts, 1200, 'snowball').interest);
});

test('mortgage pages: FHA MIP and VA funding fee follow the 2026 tables', () => {
    const fha = loans.fha({ price: 350000, down: 3.5, rate: 6.25, years: 30, tax: 0, insurance: 0 }, { data: DATA });
    assert.match(fha.rows.mip, /^0\.55% a year/);
    const va = loans.va({ price: 400000, down: 0, rate: 6, years: 30, use: 'first', purpose: 'purchase', tax: 0, insurance: 0, exempt: false }, { data: DATA });
    assert.match(va.rows.fee, /\$8,600\.00 \(2\.15%\)/);
});

test('federal tax, FICA and state tax for 2026', () => {
    const f = DATA.federal;
    assert.equal(federalTax(f, { ordinary: 100000, status: 'single' }).tax, 13170);
    assert.equal(federalTax(f, { ordinary: 60000, gains: 50000, status: 'mfj' }).gainsTax, 0);
    assert.equal(federalTax(f, { ordinary: 450000, status: 'mfj', children: 2 }).credit, 1900);
    assert.equal(fica(f, 250000).ss, 11439);
    assert.equal(stateTax(DATA.states.list.TX, 90000).tax, 0);
    close(stateTax(DATA.states.list.IL, 75000).tax, (75000 - 2925) * 0.0495, 0.01);
    const uk = tax.uk_take_home({ salary: 40000, region: 'ruk', pension: 5, pension_type: 'net', student: 'plan2', postgrad: false }, { data: DATA, sym: 'GBP' });
    assert.equal(uk.rows.tax, '£5,086.00');
    assert.equal(uk.rows.ni, '£2,194.40');
    assert.equal(tax.sdlt({ price: 350000, buyer: 'first' }, { data: DATA, sym: 'GBP' }).value, '£2,500.00');
});

test('India: SIP value and both tax regimes', () => {
    close(sip(10000, 0.12, 10).balance, 2323391, 1);
    const t = DATA.india;
    assert.equal(newRegime(t, 1200000).total, 0);
    close(newRegime(t, 1425000).total, 97500, 0.01);
    close(oldRegime(t, 1105000).total, 149760, 0.01);
});

test('securities: bonds match spreadsheet PRICE, YIELD and DURATION; Black–Scholes textbook values', () => {
    const price = markets.bond_price({ settle: '2008-02-15', maturity: '2017-11-15', coupon: 5.75, ytm: 6.5, freq: '2', basis: '30360', face: 100 }, {});
    close(amount(price.value), 94.63, 0.005);
    const y = markets.bond_yield({ settle: '2008-02-15', maturity: '2016-11-15', coupon: 5.75, price: 95.04287, freq: '2', basis: '30360', face: 100 }, {});
    close(y.value, 6.5, 0.001);
    const d = markets.duration({ settle: '2018-07-01', maturity: '2048-01-01', coupon: 8, ytm: 9, freq: '2', basis: 'act' }, {});
    close(d.value, 10.92, 0.01);
    const bs = blackScholes(100, 100, 1, 0.05, 0, 0.2);
    close(bs.call, 10.4506, 0.0001);
    close(bs.put, 5.5735, 0.0001);
    assert.equal(wilderRsi([1, 2, 3, 4], 3)[0], 100);
});

test('retirement rules: Roth phase-out, Social Security and lottery annuity', () => {
    assert.equal(rothAllowed(7500, 160000, [153000, 168000]), 4000);
    assert.equal(fullRetirementMonths(1957), 66 * 12 + 6);
    close(claimFactor(62 * 12, 67 * 12), 0.7, 1e-9);
    close(claimFactor(70 * 12, 67 * 12), 1.24, 1e-9);
    close(lotteryAnnuity(1000000).reduce((a, b) => a + b, 0), 1000000, 0.01);
    const growth = invest.growth({ start: 10000, rate: 5, compound: '12', years: 10, contribution: 0, per: '12' }, {});
    assert.equal(growth.value, '$16,470.09');
});

test('business tools: MACRS, check digits, overtime and the simple formula table', () => {
    assert.deepEqual(macrsRates(5).map((r) => Math.round(r * 10000) / 100), [20, 32, 19.2, 11.52, 11.52, 5.76]);
    assert.equal(checkDigit('ean13', '400638133393'), '1');
    assert.equal(checkDigit('isbn10', '030640615'), '2');
    assert.equal(checkDigit('luhn', '7992739871'), '3');
    assert.deepEqual(overtimeWeek([10, 9, 13, 8, 8, 0, 0], 'california'), { regular: 40, ot: 7, dt: 1 });
    assert.equal(simple.bradford_factor({ spells: 3, days: 6 }, {}).value, '54');
    assert.equal(simple.apy({ apr: 4.5, n: 365 }, {}).rows.calc, '(1 + 0.045 ÷ 365)^365 − 1 = 0.04602');
});

test('display currency: symbols, Indian grouping and minor units', async () => {
    const { CURRENCIES, formatMoney, getCurrency, setCurrency } = await import('../currency.js');
    assert.ok(CURRENCIES.some(([code]) => code === 'INR'));
    assert.equal(formatMoney(2323391.4, { code: 'INR', decimals: 0 }), '₹23,23,391');
    assert.equal(formatMoney(1234.5, { code: 'EUR' }), '€1,234.50');
    assert.equal(formatMoney(1234.5, { code: 'JPY' }), '¥1,235');
    assert.equal(formatMoney(-5, { code: 'GBP' }), '−£5.00');
    setCurrency('INR');
    assert.equal(getCurrency(), 'INR');
    assert.equal(simple.ctr({ clicks: 1, impressions: 2 }, {}).value, '50');
    assert.equal(invest.growth({ start: 10000, rate: 5, compound: '12', years: 10, contribution: 0, per: '12' }, {}).value, '₹16,470.09');
    setCurrency('XXX');
    assert.equal(getCurrency(), 'INR');
    setCurrency('USD');
});
