import assert from 'node:assert/strict';
import test from 'node:test';
import { fiveNumber, kurtosis, parseNumbers, quantile, ranks, skewness, sorted } from '../statistics/data.js';
import { betaDist, binomial, gammaDist, hypergeometric, negBinomial, poisson, weibull } from '../statistics/dist.js';
import { ols, polyRow, intervals } from '../statistics/reg.js';
import { chi2Sf, fInv, lgamma, nctCdf, normCdf, normInv, tCdf, tInv } from '../statistics/special.js';
import { anova, chiIndependence, fisherExact, kendall, kruskalWallis, mannWhitney, mcnemar, signedRank, tPower, tTwo } from '../statistics/tests.js';
import { diceDistribution, parseDice, parseOdds, handlers as prob } from '../tools/st-prob.js';
import { handlers as inf } from '../tools/st-inf.js';
import { handlers as desc } from '../tools/st-desc.js';

/**
 * Reference values from SciPy 1.18 and statsmodels 0.15 (scipy.stats, statsmodels OLS and power), and from
 * classic published examples. Tolerances are relative unless stated.
 */
const close = (actual, expected, rel = 1e-9) => assert.ok(Math.abs(actual - expected) <= rel * Math.max(1, Math.abs(expected)), `${actual} ≠ ${expected}`);
const run = (handler, inputs) => handler(inputs, { data: { units: {}, statistics: {} } });

const X = [10.0, 10.6, 9.5, 8.2, 9.1, 8.0, 10.1, 12.7, 9.0, 8.8, 11.0, 10.7];
const Y = [11.8, 8.7, 11.4, 13.6, 7.5, 10.1, 5.8, 7.6, 6.0, 10.8, 7.7, 12.3, 12.0, 10.9, 3.9];
const XT = [3, 5, 5, 7, 8, 8, 8, 10, 12];
const YT = [4, 6, 8, 9, 9, 11, 13, 13, 15, 16];
const mean = (xs) => xs.reduce((a, b) => a + b, 0) / xs.length;
const sd = (xs) => Math.sqrt(xs.reduce((a, b) => a + (b - mean(xs)) ** 2, 0) / (xs.length - 1));

test('special functions match SciPy', () => {
    close(lgamma(10.3), 13.482036786138359, 1e-12);
    close(normCdf(-8), 6.220960574271785e-16, 1e-10);
    close(normInv(1e-12), -7.034483825301131, 1e-12);
    close(tCdf(2.1, 3), 0.9367173987251577, 1e-10);
    close(tInv(0.975, 10), 2.228138851986274, 1e-12);
    close(chi2Sf(3.84, 1), 0.05004352124870519, 1e-10);
    close(fInv(0.95, 3, 20), 3.098391212140781, 1e-10);
    close(nctCdf(2, 10, 1), 0.8076115625303752, 1e-10);
});

test('distributions match SciPy', () => {
    close(binomial(20, 0.3).cdf(6), 0.6080098122009244);
    close(poisson(4).cdf(2), 0.23810330555354436);
    close(hypergeometric(50, 12, 10).pdf(2), 0.3142078532711697, 1e-12);
    close(negBinomial(3, 0.4).pdf(4), 0.124416, 1e-12);
    close(betaDist(2, 5).cdf(0.3), 0.579825, 1e-12);
    close(gammaDist(2, 3).cdf(5), 0.4963317257665017, 1e-12);
    close(weibull(1.5, 10).cdf(8), 0.5110728376249136, 1e-12);
});

test('hypothesis tests match SciPy and statsmodels', () => {
    close(tTwo(mean(X), sd(X), X.length, mean(Y), sd(Y), Y.length, 'two').p, 0.5766383627120496, 1e-8);
    close(tTwo(mean(X), sd(X), X.length, mean(Y), sd(Y), Y.length, 'two', true).p, 0.6028943943899122, 1e-8);
    close(mannWhitney(XT, YT, 'two').p, 0.07082109121623324, 1e-8);
    close(kruskalWallis([XT, YT, [1, 2, 5, 5, 7]]).p, 0.010125717870864342, 1e-8);
    close(fisherExact(3, 9, 11, 4).p, 0.02130090785360674, 1e-10);
    close(fisherExact(3, 9, 11, 4).less, 0.01653205904787545, 1e-10);
    close(chiIndependence([[12, 5, 9], [7, 14, 6]]).p, 0.04590704893264419, 1e-9);
    close(chiIndependence([[12, 5], [7, 14]], true).p, 0.05028491606049412, 1e-9);
    close(anova([X, Y, [9.5, 10.2, 12.1, 11.4]]).p, 0.49848394780928074, 1e-8);
    close(mcnemar(7, 16).exact, 0.0931396484375, 1e-12);
    close(mcnemar(7, 16, true).p, 0.0952928380234566, 1e-9);
    close(kendall(X, Y.slice(0, 12)).p, 0.6383612539081289, 1e-9);
    close(tPower(0.5, 20, 0.05, 'two', 1), 0.5645044184390203, 1e-8);
    close(tPower(0.5, 30, 0.05, 'right', 2), 0.606025327886786, 1e-8);
});

test('exact rank tests on untied data', () => {
    const x = [3.1, 4.7, 5.2, 6.9, 8.0, 9.4, 10.6];
    const y = [2.2, 5.9, 7.7, 11.3, 12.8, 13.5, 14.1, 15.0];
    close(mannWhitney(x, y, 'two').p, 0.1205905205905206, 1e-12);
    close(signedRank([1.2, -0.4, 2.5, 3.1, -1.7, 0.9, 4.4, -2.2, 5.6, 0.3], 'two').p, 0.16015625, 1e-12);
    close(kendall([1, 3, 2, 5, 4, 7, 6, 9, 8], [2, 1, 4, 3, 6, 5, 9, 7, 8]).p, 0.07517636684303351, 1e-12);
});

test('regression matches statsmodels OLS', () => {
    const xs = [1, 2, 3, 4, 5, 6, 7, 8.5, 9, 11];
    const ys = [2.1, 3.9, 6.2, 7.8, 10.1, 12.2, 13.8, 17.5, 18.1, 22.4];
    const fit = ols(xs.map((v) => polyRow(v, 2)), ys);
    [0.10206694397058769, 1.9456346274680167, 0.00760645530078774].forEach((b, j) => close(fit.beta[j], b, 1e-9));
    [0.23892081603583895, 0.09280569685168615, 0.007662970305959375].forEach((s, j) => close(fit.se[j], s, 1e-8));
    const iv = intervals(fit, [1, 7.5, 56.25]);
    close(iv.ci[0], 14.895896087536855, 1e-9);
    close(iv.pi[1], 15.680453104843194, 1e-9);
});

test('data methods: quartiles, moments and ranks', () => {
    const s = sorted([6, 7, 15, 36, 39, 40, 41, 42, 43, 47, 49]);
    assert.deepEqual([0.25, 0.5, 0.75].map((p) => quantile(s, p, 'inc')), [25.5, 40, 42.5]);
    assert.deepEqual([0.25, 0.75].map((p) => quantile(s, p, 'exc')), [15, 43]);
    assert.deepEqual([0.25, 0.75].map((p) => quantile(s, p, 'halves')), [15, 43]);
    assert.equal(fiveNumber([3, 7, 8, 5, 12, 14, 21, 13, 18]).q3, 14);
    // Excel SKEW and KURT on 2, 4, 4, 4, 5, 5, 7, 9.
    close(skewness([2, 4, 4, 4, 5, 5, 7, 9]).G1, 0.8184875533567997, 1e-12);
    close(kurtosis([2, 4, 4, 4, 5, 5, 7, 9]).G2, 0.940625, 1e-12);
    assert.deepEqual(ranks([10, 20, 20, 30]).r, [1, 2.5, 2.5, 4]);
    assert.deepEqual(parseNumbers('1, 2.5;3\n-4 5e2').values, [1, 2.5, 3, -4, 500]);
});

test('probability tools', () => {
    // 3d6 averages 10.5; 4d6 keep highest 3 averages 15869/1296.
    close(diceDistribution(parseDice('3d6').terms).mean, 10.5, 1e-14);
    close(diceDistribution(parseDice('4d6kh3').terms).mean, 15869 / 1296, 1e-12);
    assert.equal(parseOdds('3/2'), 2.5);
    assert.equal(parseOdds('+150'), 2.5);
    close(parseOdds('-200'), 1.5, 1e-15);
    close(run(prob.birthday, { want: 'prob', n: 23, target: 50, days: 365 }).value.replace(/,/g, '') * 1, 0.507297, 1e-6);
    assert.equal(run(prob.lottery, { format: 'custom', k: 6, n: 49, k2: 0, n2: 10, tickets: 1, price: 2 }).value, '1 in 13,983,816');
    // Monty Hall with 3 doors: switching wins 2/3.
    close(Number(run(prob.monty_hall, { doors: 3, opened: 1, choice: 'switch', trials: 1000, seed: 1 }).value), 0.666667, 1e-6);
    // Coupon collector for 50 items: 50 × H(50).
    close(Number(run(prob.coupon, { n: 50, have: 0, draws: NaN }).value), 224.96, 1e-6);
});

test('inference and descriptive tools', () => {
    // Cochran: ±5% at 95% for a proportion needs 385.
    assert.equal(run(inf.sample_size, { type: 'prop', conf: 95, moe: 5, p: 50, sd: 15, N: 0 }).value, '385');
    // Classic power result: d = 0.5, α = 0.05, 80% power → 64 per group.
    assert.equal(run(inf.power, { test: 'two', solve: 'n', d: 0.5, p1: 0.3, p2: 0.4, n: 30, target: 0.8, alpha: 0.05, tail: 'two' }).value, '64 per group');
    assert.equal(run(desc.kappa, { data: '20, 5\n10, 15' }).value, '0.4');
    assert.equal(run(desc.least_greatest, { data: '0.5, 3/4, -2, 1 1/2, 0.45, 12%, 2/3', order: 'asc', dupes: 'keep' }).value, '-2, 12%, 0.45, 0.5, 2/3, 3/4, 1 1/2');
});
