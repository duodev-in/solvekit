import { defineTools } from '../engines/formula.js';
import { formatMoney } from '../currency.js';
import { handlersFor } from '../physics/core.js';
import { N, SEL, TXT, LINE, bigText, chooseBig, fraction, num, oneIn, pct, prob, randomInt, seeded } from '../statistics/common.js';
import { binomial, hypergeometric, regionProbability, regionText, distPlot } from '../statistics/dist.js';
import { normCdf, normInv } from '../statistics/special.js';
import { wilson } from '../statistics/tests.js';

/**
 * Probability and odds: counting, Bayes and diagnostic tests, odds formats, games of chance, dice, coins and
 * the classic paradoxes (each with its exact answer and a repeatable seeded simulation).
 */

const P = (label, value) => [label, null, null, value, 0];
const MONEY = (label, value) => [label, 'money', null, value];
const TRIALS = N('Simulated trials', 10000, 1);
const SEED = N('Simulation seed (same seed, same run)', 1, 1);
const REGION = { eq: 'Exactly', le: 'At most', ge: 'At least', lt: 'Fewer than', gt: 'More than' };

/** "Enter a probability between 0 and 1" check for named values. */
const notProb = (x, names) => names.find((k) => !(x[k] >= 0 && x[k] <= 1));
const probError = (label) => `${label} must be a probability between 0 and 1.`;

/** Trials between 1 and a million. */
const trialsOk = (n) => Number.isInteger(n) && n >= 1 && n <= 1e6;

/** Dice notation: terms like 3d6, d20, 4d6kh3, 2d20kl1, d% and constants, joined by + or −. */
export function parseDice(text) {
    const clean = String(text ?? '').toLowerCase().replace(/\s+/g, '').replace(/−/g, '-');

    if (!clean) {
        return { problem: 'Enter dice such as 2d6 or 1d20+5.' };
    }

    const terms = [];
    const re = /([+-]?)(?:(\d*)d(\d+|%)(?:(kh|kl)(\d+))?|(\d+))/gy;
    let match;
    let used = 0;

    while ((match = re.exec(clean)) !== null) {
        if (match[0] === '') {
            break;
        }

        used = re.lastIndex;
        const sign = match[1] === '-' ? -1 : 1;

        if (match[6] !== undefined) {
            terms.push({ sign, constant: Number(match[6]) });
            continue;
        }

        const count = match[2] === '' ? 1 : Number(match[2]);
        const sides = match[3] === '%' ? 100 : Number(match[3]);
        const keep = match[4] ? { mode: match[4], n: Number(match[5]) } : null;

        if (count < 1 || count > 100 || sides < 2 || sides > 1000) {
            return { problem: 'Use 1 to 100 dice with 2 to 1,000 sides each.' };
        }

        if (keep && (keep.n < 1 || keep.n > count)) {
            return { problem: `Keep between 1 and ${count} dice.` };
        }

        terms.push({ sign, count, sides, keep });
    }

    if (used !== clean.length || !terms.some((t) => t.sides)) {
        return { problem: 'Write dice as NdS, for example 3d6, 1d20+5, 4d6kh3 (keep highest 3) or 2d20kl1 (keep lowest 1).' };
    }

    return { terms };
}

/** Exact distribution of one dice term as { min, p: [...] } (p[j] = P(total = min + j)). */
function termDistribution(term) {
    const { count, sides, keep } = term;

    if (!keep || keep.n === count) {
        let dist = [1];

        for (let d = 0; d < count; d += 1) {
            const next = new Array(dist.length + sides - 1).fill(0);
            dist.forEach((p, j) => {
                for (let f = 0; f < sides; f += 1) {
                    next[j + f] += p / sides;
                }
            });
            dist = next;
        }

        return { min: count, p: dist };
    }

    if (sides ** count > 2e6) {
        return { problem: 'Keep-highest and keep-lowest work out exactly for up to about 2 million outcomes (for example 6d10kh3).' };
    }

    const p = new Array(keep.n * (sides - 1) + 1).fill(0);
    const roll = new Array(count).fill(1);
    const total = sides ** count;

    for (let k = 0; k < total; k += 1) {
        const s = [...roll].sort((a, b) => (keep.mode === 'kh' ? b - a : a - b)).slice(0, keep.n).reduce((t, v) => t + v, 0);
        p[s - keep.n] += 1 / total;

        for (let d = 0; d < count; d += 1) {
            roll[d] += 1;

            if (roll[d] <= sides) {
                break;
            }

            roll[d] = 1;
        }
    }

    return { min: keep.n, p };
}

/** Exact distribution of a whole dice expression. */
export function diceDistribution(terms) {
    let min = 0;
    let p = [1];

    for (const term of terms) {
        if (term.constant !== undefined) {
            min += term.sign * term.constant;
            continue;
        }

        const t = termDistribution(term);

        if (t.problem) {
            return t;
        }

        const tp = term.sign < 0 ? [...t.p].reverse() : t.p;
        const tmin = term.sign < 0 ? -(t.min + t.p.length - 1) : t.min;
        const next = new Array(p.length + tp.length - 1).fill(0);
        p.forEach((a, i) => tp.forEach((b, j) => {
            next[i + j] += a * b;
        }));
        p = next;
        min += tmin;
    }

    const mean = p.reduce((s, q, j) => s + q * (min + j), 0);
    const variance = p.reduce((s, q, j) => s + q * (min + j - mean) ** 2, 0);

    return { min, max: min + p.length - 1, p, mean, variance };
}

/** Odds text in any common format → decimal odds. Plain numbers are decimal odds. */
export function parseOdds(text) {
    const t = String(text ?? '').trim().toLowerCase().replace(/−/g, '-').replace(/\s+/g, ' ');
    let m;

    if ((m = t.match(/^([+-])\s*(\d+(?:\.\d+)?)$/))) {
        const v = Number(m[2]);

        return v >= 100 ? (m[1] === '+' ? 1 + v / 100 : 1 + 100 / v) : NaN;
    }

    if ((m = t.match(/^(\d+(?:\.\d+)?)\s*(?:\/|to|-|:)\s*(\d+(?:\.\d+)?)(?: against)?$/))) {
        return Number(m[2]) > 0 ? 1 + Number(m[1]) / Number(m[2]) : NaN;
    }

    if ((m = t.match(/^(\d+(?:\.\d+)?)\s*%$/))) {
        const p = Number(m[1]) / 100;

        return p > 0 && p < 1 ? 1 / p : NaN;
    }

    if (t === 'evens' || t === 'even') {
        return 2;
    }

    const d = Number(t);

    return d > 1 ? d : NaN;
}

/** Decimal odds → fractional text with small whole numbers (e.g. 2.5 → 3/2). */
function fractional(dec) {
    const x = dec - 1;
    let best = [Math.round(x), 1];

    for (let den = 1; den <= 100; den += 1) {
        const numr = Math.round(x * den);

        if (Math.abs(numr / den - x) < Math.abs(best[0] / best[1] - x) - 1e-12) {
            best = [numr, den];
        }

        if (Math.abs(numr / den - x) < 1e-9) {
            best = [numr, den];
            break;
        }
    }

    const g = (a, b) => (b ? g(b, a % b) : a);
    const k = g(best[0], best[1]) || 1;

    return `${best[0] / k}/${best[1] / k}`;
}

const moneyline = (dec) => (dec >= 2 ? `+${num((dec - 1) * 100, 5)}` : `−${num(100 / (dec - 1), 5)}`);

/** Longest run of equal values in a list. */
const longestRun = (list) => list.reduce(([best, run, prev], v) => (v === prev ? [Math.max(best, run + 1), run + 1, v] : [Math.max(best, 1), 1, v]), [0, 0, null])[0];

/** P(no run of k or more) for n flips with P(heads) = p, counting heads runs only or runs of either side. */
function noRun(n, k, p, either) {
    if (k > n) {
        return 1;
    }

    // State: [side, length of the current run]; side 0 = heads, 1 = tails.
    let h = new Array(k).fill(0);
    let t = new Array(k).fill(0);
    h[1] = p;
    t[1] = 1 - p;

    if (k === 1) {
        return either ? 0 : (1 - p) ** n;
    }

    for (let step = 2; step <= n; step += 1) {
        const nh = new Array(k).fill(0);
        const nt = new Array(k).fill(0);
        const sumH = h.reduce((a, b) => a + b, 0);
        const sumT = t.reduce((a, b) => a + b, 0);

        for (let len = 1; len < k; len += 1) {
            if (len + 1 < k) {
                nh[len + 1] += h[len] * p;
            }

            if (either) {
                if (len + 1 < k) {
                    nt[len + 1] += t[len] * (1 - p);
                }
            }
        }

        nh[1] += sumT * p;

        if (either) {
            nt[1] += sumH * (1 - p);
        } else {
            nt[1] += (sumH + sumT) * (1 - p);
        }

        h = nh;
        t = nt;
    }

    return h.reduce((a, b) => a + b, 0) + t.reduce((a, b) => a + b, 0);
}

/** Lottery presets (config/statistics_data.php): pick k of n plus bonus balls. */
function lotteryTiers(k, n, k2, n2) {
    const total = chooseBig(n, k) * (k2 > 0 ? chooseBig(n2, k2) : 1n);
    const tiers = [];

    for (let m = k; m >= 0; m -= 1) {
        for (let b = k2; b >= 0; b -= 1) {
            const ways = chooseBig(k, m) * chooseBig(n - k, k - m) * (k2 > 0 ? chooseBig(k2, b) * chooseBig(n2 - k2, k2 - b) : 1n);
            tiers.push({ m, b, ways });
        }
    }

    return { total, tiers };
}

/** Roulette bets: numbers covered and the payout ratio (to 1). */
const BETS = {
    straight: ['Straight up (1 number)', 1, 35],
    split: ['Split (2 numbers)', 2, 17],
    street: ['Street (3 numbers)', 3, 11],
    corner: ['Corner (4 numbers)', 4, 8],
    basket: ['Top line / basket (0, 00, 1, 2, 3; American only)', 5, 6],
    sixline: ['Six line (6 numbers)', 6, 5],
    dozen: ['Dozen or column (12 numbers)', 12, 2],
    even: ['Red/black, odd/even, 1–18/19–36 (18 numbers)', 18, 1],
};

/** Exact capital distribution for Parrondo's games after each round (Harmer & Abbott 1999). */
function parrondoExpected(pattern, rounds, eps) {
    const size = 2 * rounds + 1;
    let dist = new Array(size).fill(0);
    dist[rounds] = 1;
    const means = [[0, 0]];
    const pA = 0.5 - eps;
    const pB = (capital) => (((capital % 3) + 3) % 3 === 0 ? 0.1 - eps : 0.75 - eps);

    for (let r = 0; r < rounds; r += 1) {
        const next = new Array(size).fill(0);
        const game = pattern === 'random' ? 'R' : pattern[r % pattern.length];

        dist.forEach((q, index) => {
            if (!q) {
                return;
            }

            const capital = index - rounds;
            const win = game === 'A' ? pA : game === 'B' ? pB(capital) : 0.5 * pA + 0.5 * pB(capital);

            if (index + 1 < size) {
                next[index + 1] += q * win;
            }

            if (index - 1 >= 0) {
                next[index - 1] += q * (1 - win);
            }
        });
        dist = next;
        means.push([r + 1, dist.reduce((s, q, index) => s + q * (index - rounds), 0)]);
    }

    return means;
}

export const TOOLS = {
    accuracy: {
        type: 'calc',
        inputs: { mode: SEL('Measure', { matrix: 'Classification (confusion matrix)', measure: 'A measurement against the true value' }, 'matrix'), TP: N('True positives', 45, 0), FP: N('False positives', 5, 0), TN: N('True negatives', 40, 0), FN: N('False negatives', 10, 0), measured: N('Measured value', 9.6), actual: N('True (accepted) value', 9.81) },
        show: { TP: 'mode:matrix', FP: 'mode:matrix', TN: 'mode:matrix', FN: 'mode:matrix', measured: 'mode:measure', actual: 'mode:measure' },
        when: { TP: (x) => x.mode === 'matrix', FP: (x) => x.mode === 'matrix', TN: (x) => x.mode === 'matrix', FN: (x) => x.mode === 'matrix', measured: (x) => x.mode === 'measure', actual: (x) => x.mode === 'measure' },
        label: 'Accuracy',
        rows: { second: 'Error rate', balanced: 'Balanced accuracy', prevalence: 'Prevalence' },
        run: (x) => {
            if (x.mode === 'measure') {
                if (x.actual === 0) {
                    return { error: 'The true value cannot be zero for a percentage.' };
                }

                const err = Math.abs(x.measured - x.actual) / Math.abs(x.actual);

                return { value: `${num(100 - err * 100, 6)}%`, sub: `Percent error ${num(err * 100, 6)}%`, rows: { second: `${num(err * 100, 6)}%`, balanced: 'For classifiers only', prevalence: 'For classifiers only' }, steps: ['Percent error = |measured − true| ÷ |true| × 100', `= |${num(x.measured)} − ${num(x.actual)}| ÷ ${num(Math.abs(x.actual))} × 100 = ${num(err * 100, 6)}%`, `Accuracy = 100% − percent error = ${num(100 - err * 100, 6)}%`] };
            }

            const total = x.TP + x.FP + x.TN + x.FN;

            if (total <= 0) {
                return { empty: 'Enter the counts.' };
            }

            const acc = (x.TP + x.TN) / total;
            const sens = x.TP / (x.TP + x.FN);
            const spec = x.TN / (x.TN + x.FP);

            return { value: pct(acc, 6), sub: `${num(x.TP + x.TN)} of ${num(total)} classified correctly`, rows: { second: pct(1 - acc, 6), balanced: Number.isFinite(sens + spec) ? pct((sens + spec) / 2, 6) : 'Needs both classes', prevalence: pct((x.TP + x.FN) / total, 6) }, steps: ['Accuracy = (TP + TN) ÷ (TP + FP + TN + FN)', `= (${num(x.TP)} + ${num(x.TN)}) ÷ ${num(total)} = ${num(acc, 8)}`, `Balanced accuracy = (sensitivity + specificity) ÷ 2 = (${num(sens, 6)} + ${num(spec, 6)}) ÷ 2`, 'With unequal classes, balanced accuracy is fairer than accuracy'] };
        },
    },
    bayes: {
        type: 'calc',
        inputs: { pA: P('P(A), the prior', 0.01), pBA: P('P(B | A)', 0.9), pBnA: P('P(B | not A)', 0.08) },
        label: 'P(A | B)',
        rows: { pB: 'P(B)', pAnB: 'P(A | not B)', lr: 'Likelihood ratio P(B|A) ÷ P(B|not A)' },
        grids: [['tree', 'The four branches']],
        run: (x) => {
            const bad = notProb(x, ['pA', 'pBA', 'pBnA']);

            if (bad) {
                return { error: probError({ pA: 'P(A)', pBA: 'P(B | A)', pBnA: 'P(B | not A)' }[bad]) };
            }

            const pB = x.pBA * x.pA + x.pBnA * (1 - x.pA);

            if (pB === 0) {
                return { error: 'P(B) is zero, so P(A | B) is undefined.' };
            }

            const post = (x.pBA * x.pA) / pB;
            const branches = [['A and B', x.pA * x.pBA], ['A and not B', x.pA * (1 - x.pBA)], ['not A and B', (1 - x.pA) * x.pBnA], ['not A and not B', (1 - x.pA) * (1 - x.pBnA)]];

            return { value: num(post, 6), sub: pct(post), rows: { pB: num(pB, 6), pAnB: pB < 1 ? num(((1 - x.pBA) * x.pA) / (1 - pB), 6) : 'Undefined (P(B) = 1)', lr: x.pBnA > 0 ? num(x.pBA / x.pBnA, 6) : 'Infinite' }, steps: ['P(A | B) = P(B | A) P(A) ÷ P(B)', `P(B) = P(B|A)P(A) + P(B|not A)P(not A) = ${num(x.pBA)} × ${num(x.pA)} + ${num(x.pBnA)} × ${num(1 - x.pA)} = ${num(pB, 8)}`, `P(A | B) = ${num(x.pBA * x.pA, 8)} ÷ ${num(pB, 8)} = ${num(post, 8)}`], grids: { tree: { columns: ['Probability', 'Per 10,000'], rows: branches.map(([h, p]) => ({ header: h, cells: [num(p, 6), num(p * 10000, 5)], highlight: h === 'A and B' })) } } };
        },
    },
    bertrand_box: {
        type: 'calc',
        inputs: { trials: TRIALS, seed: SEED },
        label: 'P(the other coin is gold | you drew gold)',
        rows: { exact: 'Exact answer', sim: 'Simulated share', counted: 'Gold draws counted' },
        run: (x) => {
            if (!trialsOk(x.trials)) {
                return { error: 'Use 1 to 1,000,000 trials.' };
            }

            const r = seeded(x.seed);
            const boxes = [['G', 'G'], ['S', 'S'], ['G', 'S']];
            let gold = 0;
            let other = 0;

            for (let k = 0; k < x.trials; k += 1) {
                const box = boxes[Math.floor(r() * 3)];
                const side = Math.floor(r() * 2);

                if (box[side] === 'G') {
                    gold += 1;

                    if (box[1 - side] === 'G') {
                        other += 1;
                    }
                }
            }

            return { value: '2/3', sub: `≈ ${num(2 / 3, 6)}, not 1/2`, rows: { exact: '2/3 ≈ 0.666667', sim: gold ? `${num(other / gold, 6)} (${num(other)} of ${num(gold)})` : 'No gold drawn', counted: num(gold) }, steps: ['Boxes: gold–gold, silver–silver, gold–silver; pick a box, then a coin at random', 'There are three gold coins you could have drawn, all equally likely', 'Two of them sit in the gold–gold box, so the other coin is gold in 2 of 3 cases', 'The tempting answer 1/2 forgets that the gold–gold box gives a gold draw twice as often'] };
        },
    },
    bertrand: {
        type: 'calc',
        inputs: { method: SEL('How the chord is chosen', { endpoints: 'Two random points on the circle', radius: 'A random point on a random radius', midpoint: 'A random midpoint inside the circle' }, 'endpoints'), trials: TRIALS, seed: SEED },
        label: 'P(chord longer than the triangle side)',
        rows: { exact: 'Exact answer for this method', sim: 'Simulated share', others: 'The other methods' },
        plots: [['chords', 'First 40 chords (longer ones in blue)']],
        run: (x) => {
            if (!trialsOk(x.trials)) {
                return { error: 'Use 1 to 1,000,000 trials.' };
            }

            const r = seeded(x.seed);
            const side = Math.sqrt(3);
            let longer = 0;
            const drawn = [];

            for (let k = 0; k < x.trials; k += 1) {
                let a;
                let b;

                if (x.method === 'endpoints') {
                    const t1 = r() * 2 * Math.PI;
                    const t2 = r() * 2 * Math.PI;
                    a = [Math.cos(t1), Math.sin(t1)];
                    b = [Math.cos(t2), Math.sin(t2)];
                } else {
                    let mx;
                    let my;

                    if (x.method === 'radius') {
                        const t = r() * 2 * Math.PI;
                        const d = r();
                        [mx, my] = [d * Math.cos(t), d * Math.sin(t)];
                    } else {
                        do {
                            mx = 2 * r() - 1;
                            my = 2 * r() - 1;
                        } while (mx * mx + my * my > 1);
                    }

                    const d = Math.hypot(mx, my) || 1e-12;
                    const half = Math.sqrt(Math.max(0, 1 - d * d));
                    const [ux, uy] = [-my / d, mx / d];
                    a = [mx + half * ux, my + half * uy];
                    b = [mx - half * ux, my - half * uy];
                }

                const long = Math.hypot(a[0] - b[0], a[1] - b[1]) > side;
                longer += long ? 1 : 0;

                if (drawn.length < 40) {
                    drawn.push({ points: [a, b], muted: !long });
                }
            }

            const exact = { endpoints: ['1/3', 1 / 3], radius: ['1/2', 1 / 2], midpoint: ['1/4', 1 / 4] }[x.method];
            const circle = Array.from({ length: 73 }, (_, j) => [Math.cos((j * Math.PI) / 36), Math.sin((j * Math.PI) / 36)]);
            const tri = [0, 1, 2, 3].map((j) => [Math.cos(Math.PI / 2 + (j * 2 * Math.PI) / 3), Math.sin(Math.PI / 2 + (j * 2 * Math.PI) / 3)]);

            return { value: exact[0], sub: `≈ ${num(exact[1], 6)} for this method`, rows: { exact: `${exact[0]} ≈ ${num(exact[1], 6)}`, sim: `${num(longer / x.trials, 6)} (${num(longer)} of ${num(x.trials)})`, others: 'Random endpoints 1/3, random radius 1/2, random midpoint 1/4' }, steps: ['A chord is longer than the side of the inscribed equilateral triangle when its midpoint lies within half the radius of the centre', 'Random endpoints: the second point must land in the opposite third of the circle → 1/3', 'Random radius point: the midpoint distance is uniform on [0, 1] → 1/2', 'Random midpoint: the midpoint is uniform over the disc, inner disc area (1/2)² → 1/4', 'Bertrand (1889): “at random” has no single meaning, so the question has no single answer'], plots: { chords: { kind: 'diagram', shapes: [{ points: circle, muted: true }, { points: tri, dashed: true, muted: true }, ...drawn.map((c) => ({ points: c.points, muted: c.muted }))] } } };
        },
    },
    birthday: {
        type: 'calc',
        inputs: { want: SEL('Find', { prob: 'The probability for a group', people: 'People needed for a probability' }, 'prob'), n: N('People in the group', 23, 1), target: N('Target probability (%)', 50, 0), days: N('Days in the year', 365, 1) },
        show: { n: 'want:prob', target: 'want:people' },
        when: { n: (x) => x.want === 'prob', target: (x) => x.want === 'people' },
        label: 'P(at least two share a birthday)',
        rows: { none: 'P(all birthdays different)', pairs: 'Pairs of people', half: 'People for 50%', ninetynine: 'People for 99%' },
        plots: [['curve', 'Probability by group size']],
        run: (x) => {
            const d = x.days;

            if (!(Number.isInteger(d) && d >= 2)) {
                return { error: 'Days must be a whole number of at least 2.' };
            }

            const pNone = (n) => {
                if (n > d) {
                    return 0;
                }

                let l = 0;

                for (let k = 0; k < n; k += 1) {
                    l += Math.log1p(-k / d);
                }

                return Math.exp(l);
            };
            const needed = (p) => {
                let n = 1;

                while (1 - pNone(n) < p && n <= d + 1) {
                    n += 1;
                }

                return n;
            };
            const n50 = needed(0.5);
            const n99 = needed(0.99);
            const top = Math.max(n99, x.want === 'prob' ? x.n : 0) + 5;
            const plot = { series: Array.from({ length: Math.min(top, d + 1) }, (_, n) => [n + 1, 1 - pNone(n + 1)]), xLabel: 'People', yLabel: 'P(shared birthday)', yMin: 0, yMax: 1 };

            if (x.want === 'people') {
                if (!(x.target > 0 && x.target < 100)) {
                    return { error: 'The target must be between 0% and 100%.' };
                }

                const n = needed(x.target / 100);
                plot.markers = [{ x: n, y: 1 - pNone(n), label: `${n} people` }];

                return { value: `${n} people`, label: 'People needed', sub: `${pct(1 - pNone(n))} with ${n} people (${pct(1 - pNone(n - 1))} with ${n - 1})`, rows: { none: num(pNone(n), 6), pairs: num((n * (n - 1)) / 2), half: `${n50}`, ninetynine: `${n99}` }, steps: ['P(shared) = 1 − (d/d)((d − 1)/d) … ((d − n + 1)/d)', `The smallest n with P(shared) ≥ ${num(x.target)}% is ${n}`], plots: { curve: plot } };
            }

            if (!(Number.isInteger(x.n) && x.n >= 1)) {
                return { error: 'Enter a whole number of people.' };
            }

            const pn = pNone(x.n);
            plot.markers = [{ x: x.n, y: 1 - pn, label: pct(1 - pn, 3) }];

            return { value: num(1 - pn, 6), sub: pct(1 - pn), rows: { none: num(pn, 6), pairs: num((x.n * (x.n - 1)) / 2), half: `${n50}`, ninetynine: `${n99}` }, steps: ['P(all different) = 1 × (d − 1)/d × (d − 2)/d × … × (d − n + 1)/d', `= ${num(pn, 8)} for n = ${x.n}, d = ${d}`, `P(at least one shared) = 1 − ${num(pn, 8)} = ${num(1 - pn, 8)}`, `With ${num((x.n * (x.n - 1)) / 2)} pairs, a match is likely far sooner than intuition says`, 'Assumes equally likely birthdays and ignores 29 February'], plots: { curve: plot } };
        },
    },
    boy_girl: {
        type: 'calc',
        inputs: { known: SEL('What you know about the two children', { one: 'At least one is a boy', older: 'The older child is a boy', tuesday: 'At least one is a boy born on a Tuesday' }, 'one'), trials: TRIALS, seed: SEED },
        label: 'P(both are boys)',
        rows: { exact: 'Exact answer', sim: 'Simulated share', families: 'Matching families' },
        run: (x) => {
            if (!trialsOk(x.trials)) {
                return { error: 'Use 1 to 1,000,000 trials.' };
            }

            const r = seeded(x.seed);
            let match = 0;
            let both = 0;

            for (let k = 0; k < x.trials; k += 1) {
                const kids = [0, 1].map(() => ({ boy: r() < 0.5, day: Math.floor(r() * 7) }));
                const ok = x.known === 'older' ? kids[0].boy : x.known === 'one' ? kids.some((c) => c.boy) : kids.some((c) => c.boy && c.day === 1);

                if (ok) {
                    match += 1;
                    both += kids.every((c) => c.boy) ? 1 : 0;
                }
            }

            const exact = { one: ['1/3', 1 / 3, ['Equally likely families: BB, BG, GB, GG', '“At least one boy” rules out only GG, leaving BB, BG, GB', 'Both boys in 1 of 3 → 1/3']], older: ['1/2', 1 / 2, ['Knowing the older child is a boy leaves BB and BG', 'The younger child is a boy half the time → 1/2']], tuesday: ['13/27', 13 / 27, ['There are 14 × 14 = 196 equally likely (sex, weekday) pairs', 'Families with at least one Tuesday boy: 27; of these, 13 have two boys', 'So P = 13/27 ≈ 0.481: the extra detail moves the answer close to 1/2']] }[x.known];

            return { value: exact[0], sub: `≈ ${num(exact[1], 6)}`, rows: { exact: `${exact[0]} ≈ ${num(exact[1], 6)}`, sim: match ? `${num(both / match, 6)} (${num(both)} of ${num(match)})` : 'No matching family', families: num(match) }, steps: [...exact[2], 'Martin Gardner (1959): the answer depends on how the information was obtained'] };
        },
    },
    chebyshev: {
        type: 'calc',
        inputs: { mode: SEL('Given', { k: 'Number of standard deviations k', range: 'Mean, SD and a range' }, 'k'), k: N('k (more than 1)', 2), mean: N('Mean', 100), sd: N('Standard deviation', 15, 0), lo: N('Lower limit', 70), hi: N('Upper limit', 130) },
        show: { k: 'mode:k', mean: 'mode:range', sd: 'mode:range', lo: 'mode:range', hi: 'mode:range' },
        when: { k: (x) => x.mode === 'k', mean: (x) => x.mode === 'range', sd: (x) => x.mode === 'range', lo: (x) => x.mode === 'range', hi: (x) => x.mode === 'range' },
        label: 'At least this share is within k SD',
        rows: { k: 'k', outside: 'At most outside', normal: 'Share if the data were normal' },
        run: (x) => {
            let k = x.k;
            let note = '';

            if (x.mode === 'range') {
                if (!(x.sd > 0) || !(x.lo < x.mean && x.hi > x.mean)) {
                    return { error: 'The range must contain the mean and the SD must be positive.' };
                }

                k = Math.min(x.mean - x.lo, x.hi - x.mean) / x.sd;
                note = `k = min(${num(x.mean - x.lo)}, ${num(x.hi - x.mean)}) ÷ ${num(x.sd)} = ${num(k, 6)}`;
            }

            if (!(k > 1)) {
                return { error: 'Chebyshev’s theorem says something only for k > 1.' };
            }

            const within = 1 - 1 / (k * k);

            return { value: pct(within, 6), sub: `Any distribution: at least ${pct(within, 4)} within ${num(k, 4)} SD of the mean`, rows: { k: num(k, 6), outside: pct(1 / (k * k), 6), normal: pct(2 * normCdf(k) - 1, 6) }, steps: [...(note ? [note] : []), 'P(|X − μ| < kσ) ≥ 1 − 1/k²', `= 1 − 1/${num(k * k, 6)} = ${num(within, 8)}`, 'A bound for every distribution; for bell-shaped data the true share is much higher'] };
        },
    },
    coin_flipper: {
        type: 'calc',
        inputs: { flips: N('Number of flips', 10, 1) },
        label: 'Flips',
        rows: { heads: 'Heads', tails: 'Tails', share: 'Share of heads', streak: 'Longest streak' },
        run: (x) => {
            if (!(Number.isInteger(x.flips) && x.flips >= 1 && x.flips <= 10000)) {
                return { error: 'Flip 1 to 10,000 coins.' };
            }

            const list = Array.from({ length: x.flips }, () => (randomInt(2) ? 'H' : 'T'));
            const heads = list.filter((v) => v === 'H').length;

            return { value: list.slice(0, 60).join(' ') + (list.length > 60 ? ' …' : ''), sub: `${heads} heads, ${x.flips - heads} tails (change any value to flip again)`, rows: { heads: num(heads), tails: num(x.flips - heads), share: pct(heads / x.flips), streak: `${longestRun(list)} in a row` }, steps: ['Each flip uses the browser’s cryptographic random source: heads and tails exactly equally likely', `Sequence: ${list.slice(0, 300).join('')}${list.length > 300 ? '…' : ''}`] };
        },
    },
    coin_prob: {
        type: 'calc',
        inputs: { n: N('Number of flips', 10, 1), mode: SEL('Heads wanted', REGION, 'eq'), k: N('Number of heads', 5, 0), p: P('P(heads) on one flip', 0.5) },
        label: 'Probability',
        rows: { exact: 'P(exactly k)', atleast: 'P(at least k)', atmost: 'P(at most k)', mean: 'Expected heads' },
        plots: [['dist', 'Number of heads']],
        run: (x) => {
            if (!(Number.isInteger(x.n) && x.n >= 1 && x.n <= 1e6) || !(Number.isInteger(x.k) && x.k >= 0 && x.k <= x.n)) {
                return { error: 'Use whole numbers with 0 ≤ heads ≤ flips.' };
            }

            if (!(x.p >= 0 && x.p <= 1)) {
                return { error: probError('P(heads)') };
            }

            const d = binomial(x.n, x.p);
            const value = regionProbability(d, x.mode, x.k);

            return { value: num(value, 6), sub: `${regionText(x.mode, x.k, 0, (v) => num(v), 'heads')} = ${pct(value)} (${oneIn(value)})`, rows: { exact: num(d.pdf(x.k), 6), atleast: num(regionProbability(d, 'ge', x.k), 6), atmost: num(d.cdf(x.k), 6), mean: num(x.n * x.p, 6) }, steps: ['Heads in n flips follow the binomial distribution', 'P(X = k) = C(n, k) pᵏ (1 − p)ⁿ⁻ᵏ', `P(X = ${x.k}) = C(${x.n}, ${x.k}) × ${num(x.p)}^${x.k} × ${num(1 - x.p)}^${x.n - x.k} = ${num(d.pdf(x.k), 8)}`, `${regionText(x.mode, x.k, 0, (v) => num(v))} = ${num(value, 8)}`], plots: { dist: distPlot(d, x.mode, x.k, 0, { xLabel: 'Heads', lo: Math.max(0, d.mean - 5 * Math.sqrt(d.variance) - 2), hi: Math.min(x.n, d.mean + 5 * Math.sqrt(d.variance) + 2) }) } };
        },
    },
    coin_streak: {
        type: 'calc',
        inputs: { n: N('Number of flips', 100, 1), k: N('Streak length', 7, 1), side: SEL('Streak of', { heads: 'Heads only', either: 'Either side (all heads or all tails)' }, 'heads'), p: P('P(heads) on one flip', 0.5) },
        label: 'P(a streak of at least k)',
        rows: { none: 'P(no such streak)', expected: 'Expected longest streak', median: 'Most likely longest streak' },
        run: (x) => {
            if (!(Number.isInteger(x.n) && x.n >= 1 && x.n <= 5000) || !(Number.isInteger(x.k) && x.k >= 1)) {
                return { error: 'Use 1 to 5,000 flips and a whole streak length.' };
            }

            if (!(x.p > 0 && x.p < 1)) {
                return { error: 'P(heads) must be between 0 and 1 (not 0 or 1).' };
            }

            const either = x.side === 'either';
            const none = noRun(x.n, x.k, x.p, either);
            let expected = 0;
            let mode = 1;
            let bestP = -1;
            let prev = 1;

            for (let j = 1; j <= x.n; j += 1) {
                const atLeast = 1 - noRun(x.n, j, x.p, either);
                const atLeastNext = j < x.n ? 1 - noRun(x.n, j + 1, x.p, either) : 0;
                expected += atLeast;

                if (atLeast - atLeastNext > bestP) {
                    bestP = atLeast - atLeastNext;
                    mode = j;
                }

                prev = atLeast;

                if (prev < 1e-12) {
                    break;
                }
            }

            return { value: num(1 - none, 6), sub: `${pct(1 - none)} chance of ${x.k} or more ${either ? 'of the same side' : 'heads'} in a row in ${x.n} flips`, rows: { none: num(none, 6), expected: num(expected, 5), median: `${mode} in a row` }, steps: ['Exact recurrence over the length of the current run (a Markov chain), not a simulation', `States: current run length 1 … ${x.k - 1} of ${either ? 'heads or tails' : 'heads'}; reaching ${x.k} means a streak occurred`, `P(no streak) = ${num(none, 8)}`, `Expected longest ${either ? 'run' : 'heads run'} = Σ P(longest ≥ j) = ${num(expected, 6)}`] };
        },
    },
    conditional: {
        type: 'calc',
        inputs: { mode: SEL('Given', { probs: 'P(A and B) and P(B)', table: 'A table of counts' }, 'probs'), pAB: P('P(A and B)', 0.12), pB: P('P(B)', 0.3), ab: N('A and B', 30, 0), anb: N('A and not B', 20, 0), nab: N('not A and B', 45, 0), nanb: N('not A and not B', 105, 0) },
        show: { pAB: 'mode:probs', pB: 'mode:probs', ab: 'mode:table', anb: 'mode:table', nab: 'mode:table', nanb: 'mode:table' },
        when: { pAB: (x) => x.mode === 'probs', pB: (x) => x.mode === 'probs', ab: (x) => x.mode === 'table', anb: (x) => x.mode === 'table', nab: (x) => x.mode === 'table', nanb: (x) => x.mode === 'table' },
        label: 'P(A | B)',
        rows: { pBA: 'P(B | A)', pA: 'P(A)', independent: 'Independence check' },
        run: (x) => {
            let pAB = x.pAB;
            let pB = x.pB;
            let pA = NaN;
            let lines = [];

            if (x.mode === 'table') {
                const n = x.ab + x.anb + x.nab + x.nanb;

                if (!(n > 0)) {
                    return { empty: 'Enter the counts.' };
                }

                pAB = x.ab / n;
                pB = (x.ab + x.nab) / n;
                pA = (x.ab + x.anb) / n;
                lines = [`n = ${num(n)}; P(A and B) = ${num(x.ab)}/${num(n)}, P(B) = ${num(x.ab + x.nab)}/${num(n)}, P(A) = ${num(x.ab + x.anb)}/${num(n)}`];
            } else if (notProb(x, ['pAB', 'pB'])) {
                return { error: 'Probabilities must be between 0 and 1.' };
            } else if (pAB > pB) {
                return { error: 'P(A and B) cannot be larger than P(B).' };
            }

            if (pB === 0) {
                return { error: 'P(B) is zero, so P(A | B) is undefined.' };
            }

            const cond = pAB / pB;

            return { value: num(cond, 6), sub: pct(cond), rows: { pBA: Number.isFinite(pA) && pA > 0 ? num(pAB / pA, 6) : 'Needs P(A)', pA: Number.isFinite(pA) ? num(pA, 6) : 'Not given', independent: Number.isFinite(pA) ? (Math.abs(cond - pA) < 1e-9 ? 'Independent: P(A | B) = P(A)' : `Dependent: P(A | B) = ${num(cond, 4)} vs P(A) = ${num(pA, 4)}`) : 'Enter a table to check' }, steps: [...lines, 'P(A | B) = P(A and B) ÷ P(B)', `= ${num(pAB, 6)} ÷ ${num(pB, 6)} = ${num(cond, 8)}`] };
        },
    },
    confusion: {
        type: 'calc',
        inputs: { TP: N('True positives (predicted yes, actually yes)', 80, 0), FP: N('False positives (predicted yes, actually no)', 20, 0), FN: N('False negatives (predicted no, actually yes)', 10, 0), TN: N('True negatives (predicted no, actually no)', 90, 0) },
        label: 'F1 score',
        rows: { precision: 'Precision (PPV)', recall: 'Recall (sensitivity)', specificity: 'Specificity', npv: 'Negative predictive value', accuracy: 'Accuracy', balanced: 'Balanced accuracy', mcc: 'Matthews correlation (MCC)', kappa: 'Cohen’s κ' },
        grids: [['matrix', 'Confusion matrix']],
        run: (x) => {
            const n = x.TP + x.FP + x.FN + x.TN;

            if (!(n > 0)) {
                return { empty: 'Enter the counts.' };
            }

            const ratio = (a, b) => (b > 0 ? a / b : NaN);
            const precision = ratio(x.TP, x.TP + x.FP);
            const recall = ratio(x.TP, x.TP + x.FN);
            const spec = ratio(x.TN, x.TN + x.FP);
            const f1 = ratio(2 * x.TP, 2 * x.TP + x.FP + x.FN);
            const acc = (x.TP + x.TN) / n;
            const den = Math.sqrt((x.TP + x.FP) * (x.TP + x.FN) * (x.TN + x.FP) * (x.TN + x.FN));
            const pe = ((x.TP + x.FP) * (x.TP + x.FN) + (x.FN + x.TN) * (x.FP + x.TN)) / (n * n);
            const show = (v) => (Number.isFinite(v) ? pct(v, 5) : 'Undefined (no cases)');

            return { value: Number.isFinite(f1) ? num(f1, 6) : 'Undefined', sub: `Accuracy ${pct(acc, 4)} on ${num(n)} cases`, rows: { precision: show(precision), recall: show(recall), specificity: show(spec), npv: show(ratio(x.TN, x.TN + x.FN)), accuracy: pct(acc, 5), balanced: Number.isFinite(recall + spec) ? pct((recall + spec) / 2, 5) : 'Undefined', mcc: den ? num((x.TP * x.TN - x.FP * x.FN) / den, 6) : '0 (a row or column is empty)', kappa: pe < 1 ? num((acc - pe) / (1 - pe), 6) : 'Undefined' }, steps: ['Precision = TP ÷ (TP + FP): of the predicted positives, how many were right', 'Recall = TP ÷ (TP + FN): of the real positives, how many were found', `F1 = 2TP ÷ (2TP + FP + FN) = ${num(2 * x.TP)} ÷ ${num(2 * x.TP + x.FP + x.FN)} = ${num(f1, 8)}`, 'With unbalanced classes, prefer MCC or balanced accuracy to plain accuracy'], grids: { matrix: { columns: ['Actually yes', 'Actually no', 'Total'], rows: [{ header: 'Predicted yes', cells: [num(x.TP), num(x.FP), num(x.TP + x.FP)] }, { header: 'Predicted no', cells: [num(x.FN), num(x.TN), num(x.FN + x.TN)] }, { header: 'Total', cells: [num(x.TP + x.FN), num(x.FP + x.TN), num(n)] }] } } };
        },
    },
    dice_average: {
        type: 'calc',
        inputs: { dice: LINE('Dice (e.g. 3d6+2, 4d6kh3, 2d20kl1)', '3d6') },
        label: 'Average roll',
        rows: { range: 'Lowest and highest', sd: 'Standard deviation', common: 'Most likely total' },
        plots: [['dist', 'Distribution of the total']],
        run: (x) => {
            const parsed = parseDice(x.dice);

            if (parsed.problem) {
                return { error: parsed.problem };
            }

            const d = diceDistribution(parsed.terms);

            if (d.problem) {
                return { error: d.problem };
            }

            const top = Math.max(...d.p);
            const modes = d.p.map((q, j) => [q, d.min + j]).filter(([q]) => q >= top * (1 - 1e-9)).map(([, v]) => v);

            return { value: num(d.mean, 6), sub: `${x.dice.trim()}: ${d.min} to ${d.max}`, rows: { range: `${d.min} to ${d.max}`, sd: num(Math.sqrt(d.variance), 6), common: modes.join(', ') }, steps: ['One fair die with s sides averages (s + 1) ÷ 2', ...parsed.terms.map((t) => (t.constant !== undefined ? `${t.sign < 0 ? '−' : '+'}${t.constant} adds ${t.sign * t.constant}` : t.keep ? `${t.count}d${t.sides} keep ${t.keep.mode === 'kh' ? 'highest' : 'lowest'} ${t.keep.n}: averaged over all ${num(t.sides ** t.count)} rolls` : `${t.count}d${t.sides}: ${t.count} × (${t.sides} + 1) ÷ 2 = ${num((t.count * (t.sides + 1)) / 2)}`)), `Average total = ${num(d.mean, 8)}`], plots: { dist: { kind: 'bars', bars: d.p.map((q, j) => ({ x: d.min + j, y: q })), xLabel: 'Total', yLabel: 'Probability' } } };
        },
    },
    dice_prob: {
        type: 'calc',
        inputs: { n: N('Number of dice', 2, 1), sides: N('Sides on each die', 6, 2), mode: SEL('Total wanted', REGION, 'eq'), target: N('Target total', 7) },
        label: 'Probability',
        rows: { odds: 'Odds', ways: 'Ways out of all outcomes', mean: 'Average total' },
        plots: [['dist', 'Distribution of the total']],
        grids: [['table', 'Every total']],
        run: (x) => {
            if (!(Number.isInteger(x.n) && x.n >= 1 && x.n <= 100 && Number.isInteger(x.sides) && x.sides >= 2 && x.sides <= 1000)) {
                return { error: 'Use 1 to 100 dice with 2 to 1,000 sides.' };
            }

            const d = diceDistribution([{ sign: 1, count: x.n, sides: x.sides }]);
            const at = (t) => (t < d.min || t > d.max ? 0 : d.p[t - d.min]);
            const cum = (t) => d.p.slice(0, Math.max(0, Math.min(d.p.length, Math.floor(t) - d.min + 1))).reduce((a, b) => a + b, 0);
            const value = { eq: at(x.target), le: cum(x.target), lt: cum(x.target - 1), ge: 1 - cum(x.target - 1), gt: 1 - cum(x.target) }[x.mode];
            const total = BigInt(x.sides) ** BigInt(x.n);
            const ways = Math.round(value * Number(total));
            const exactWays = Number(total) < 2 ** 52;

            return { value: num(value, 6), sub: `${regionText(x.mode, x.target, 0, (v) => num(v), 'total')} = ${pct(value)}`, rows: { odds: oneIn(value), ways: exactWays ? `${num(ways)} of ${num(Number(total))} (${fraction(ways, Number(total))})` : `${bigText(total)} outcomes in all`, mean: num(d.mean, 6) }, steps: [`${x.n} dice × ${x.sides} sides = ${bigText(total)} equally likely outcomes`, 'The distribution of the total is the convolution of single dice (exact, not simulated)', `${regionText(x.mode, x.target, 0, (v) => num(v), 'total')} = ${num(value, 8)}`], plots: { dist: { kind: 'bars', bars: d.p.map((q, j) => ({ x: d.min + j, y: q, hi: { eq: d.min + j === x.target, le: d.min + j <= x.target, lt: d.min + j < x.target, ge: d.min + j >= x.target, gt: d.min + j > x.target }[x.mode] })), xLabel: 'Total', yLabel: 'Probability' } }, grids: { table: { columns: ['Probability', 'At least', 'At most'], rows: d.p.slice(0, 400).map((q, j) => ({ header: String(d.min + j), cells: [num(q, 5), num(1 - cum(d.min + j - 1), 5), num(cum(d.min + j), 5)], highlight: d.min + j === x.target })) } } };
        },
    },
    dice_roller: {
        type: 'calc',
        inputs: { dice: LINE('Dice (e.g. 2d6, 1d20+5, 4d6kh3, d%)', '2d6') },
        label: 'Total',
        rows: { rolls: 'Each die', range: 'Possible range', average: 'Average total' },
        run: (x) => {
            const parsed = parseDice(x.dice);

            if (parsed.problem) {
                return { error: parsed.problem };
            }

            let total = 0;
            const parts = [];

            for (const t of parsed.terms) {
                if (t.constant !== undefined) {
                    total += t.sign * t.constant;
                    parts.push(`${t.sign < 0 ? '−' : '+'}${t.constant}`);
                    continue;
                }

                const rolls = Array.from({ length: t.count }, () => 1 + randomInt(t.sides));
                const kept = t.keep ? [...rolls].sort((a, b) => (t.keep.mode === 'kh' ? b - a : a - b)).slice(0, t.keep.n) : rolls;
                const s = kept.reduce((a, b) => a + b, 0);
                total += t.sign * s;
                parts.push(`${t.sign < 0 ? '−' : ''}${t.count}d${t.sides}${t.keep ? `${t.keep.mode}${t.keep.n}` : ''}: [${rolls.join(', ')}]${t.keep ? ` keep ${kept.join(', ')}` : ''}`);
            }

            const minMax = parsed.terms.reduce(([lo, hi], t) => (t.constant !== undefined ? [lo + t.sign * t.constant, hi + t.sign * t.constant] : t.sign > 0 ? [lo + (t.keep ? t.keep.n : t.count), hi + (t.keep ? t.keep.n : t.count) * t.sides] : [lo - (t.keep ? t.keep.n : t.count) * t.sides, hi - (t.keep ? t.keep.n : t.count)]), [0, 0]);
            const avg = parsed.terms.reduce((a, t) => a + (t.constant !== undefined ? t.sign * t.constant : t.keep ? 0 : (t.sign * t.count * (t.sides + 1)) / 2), 0);
            const hasKeep = parsed.terms.some((t) => t.keep);

            return { value: num(total), sub: `${x.dice.trim()} (change any value to roll again)`, rows: { rolls: parts.join('; '), range: `${minMax[0]} to ${minMax[1]}`, average: hasKeep ? 'See the Dice Average Calculator for keep rules' : num(avg, 6) }, steps: ['Each die is an unbiased cryptographic random choice of 1 to the number of sides', ...parts] };
        },
    },
    expected_value: {
        type: 'calc',
        inputs: { list: TXT('Outcomes: value, probability (one per line)', '100, 0.1\n20, 0.3\n-10, 0.6') },
        label: 'Expected value',
        rows: { variance: 'Variance', sd: 'Standard deviation', check: 'Sum of probabilities' },
        run: (x) => {
            const lines = String(x.list).split(/\r?\n/).map((l) => l.trim()).filter(Boolean);
            const items = [];

            for (const [index, line] of lines.entries()) {
                const parts = line.split(/[\s,;]+/).filter(Boolean).map(Number);

                if (parts.length !== 2 || !parts.every(Number.isFinite) || parts[1] < 0 || parts[1] > 1) {
                    return { error: `Line ${index + 1} should be a value and a probability between 0 and 1.` };
                }

                items.push(parts);
            }

            if (!items.length) {
                return { empty: 'Enter outcomes and probabilities.' };
            }

            const total = items.reduce((s, [, p]) => s + p, 0);

            if (Math.abs(total - 1) > 1e-6) {
                return { error: `The probabilities add up to ${num(total, 8)}; they must add up to 1.` };
            }

            const ev = items.reduce((s, [v, p]) => s + v * p, 0);
            const variance = items.reduce((s, [v, p]) => s + p * (v - ev) ** 2, 0);

            return { value: num(ev, 8), sub: `Average outcome per trial over many trials`, rows: { variance: num(variance, 8), sd: num(Math.sqrt(variance), 8), check: num(total, 8) }, steps: ['E[X] = Σ xᵢ pᵢ', `= ${items.map(([v, p]) => `${num(v)} × ${num(p)}`).join(' + ')}`, `= ${num(ev, 10)}`, 'Var(X) = Σ pᵢ (xᵢ − E[X])²'] };
        },
    },
    false_positive: {
        type: 'calc',
        inputs: { prev: N('Prevalence (%)', 1, 0), sens: N('Sensitivity (%)', 99, 0), spec: N('Specificity (%)', 95, 0), pop: N('People tested', 10000, 1) },
        label: 'P(condition | positive test)',
        rows: { falsePos: 'Positive results that are false', npv: 'P(no condition | negative)', positives: 'Positive results' },
        grids: [['table', 'What happens to the people tested']],
        run: (x) => {
            if (![x.prev, x.sens, x.spec].every((v) => v >= 0 && v <= 100)) {
                return { error: 'Percentages must be between 0 and 100.' };
            }

            const p = x.prev / 100;
            const se = x.sens / 100;
            const sp = x.spec / 100;
            const tp = x.pop * p * se;
            const fn = x.pop * p * (1 - se);
            const fp = x.pop * (1 - p) * (1 - sp);
            const tn = x.pop * (1 - p) * sp;
            const ppv = tp / (tp + fp);

            return { value: pct(ppv, 4), sub: `Only ${pct(ppv, 3)} of positives have the condition`, rows: { falsePos: pct(fp / (tp + fp), 4), npv: pct(tn / (tn + fn), 6), positives: num(tp + fp, 5) }, steps: ['P(condition | positive) = true positives ÷ all positives (Bayes’ theorem)', `True positives = ${num(x.pop)} × ${num(p)} × ${num(se)} = ${num(tp, 6)}`, `False positives = ${num(x.pop)} × ${num(1 - p)} × ${num(1 - sp)} = ${num(fp, 6)}`, `PPV = ${num(tp, 6)} ÷ ${num(tp + fp, 6)} = ${num(ppv, 6)}`, 'When a condition is rare, even an accurate test gives mostly false positives'], grids: { table: { columns: ['Test positive', 'Test negative', 'Total'], rows: [{ header: 'Has the condition', cells: [num(tp, 5), num(fn, 5), num(tp + fn, 5)] }, { header: 'Does not', cells: [num(fp, 5), num(tn, 5), num(fp + tn, 5)] }, { header: 'Total', cells: [num(tp + fp, 5), num(fn + tn, 5), num(x.pop)] }] } } };
        },
    },
    implied: {
        type: 'calc',
        inputs: { odds: TXT('Odds for each outcome (decimal 2.5, fractional 6/4, moneyline +150 or −200; one per line)', '2.10\n3.40\n3.75') },
        label: 'Total implied probability',
        rows: { margin: 'Bookmaker margin (overround)', first: 'First outcome' },
        grids: [['table', 'Each outcome']],
        run: (x) => {
            const lines = String(x.odds).split(/\r?\n/).map((l) => l.trim()).filter(Boolean);
            const decs = lines.map(parseOdds);
            const bad = decs.findIndex((d) => !Number.isFinite(d));

            if (!lines.length) {
                return { empty: 'Enter the odds.' };
            }

            if (bad >= 0) {
                return { error: `Line ${bad + 1} (“${lines[bad]}”) is not odds I can read: use 2.5, 3/2 or +150.` };
            }

            const imp = decs.map((d) => 1 / d);
            const total = imp.reduce((a, b) => a + b, 0);

            return { value: pct(total, 5), sub: lines.length > 1 ? `The market is ${total > 1 ? 'over' : 'under'}-round by ${pct(Math.abs(total - 1), 3)}` : `Implied probability ${pct(total, 5)}`, rows: { margin: lines.length > 1 ? pct(1 - 1 / total, 4) : 'Enter every outcome of the market', first: pct(imp[0], 5) }, steps: ['Implied probability = 1 ÷ decimal odds', ...lines.map((l, i) => `${l}: decimal ${num(decs[i], 6)} → ${pct(imp[i], 5)}`), `Total = ${pct(total, 6)}; fair (margin-free) probabilities divide each by the total`], grids: { table: { columns: ['Decimal', 'Implied', 'Fair probability', 'Fair odds'], rows: lines.map((l, i) => ({ header: l, cells: [num(decs[i], 5), pct(imp[i], 4), pct(imp[i] / total, 4), num(total / imp[i], 5)] })) } } };
        },
    },
    joint: {
        type: 'calc',
        inputs: { pA: P('P(A)', 0.5), pB: P('P(B)', 0.4), relation: SEL('A and B are', { independent: 'Independent', given: 'Dependent: I know P(B | A)', exclusive: 'Mutually exclusive' }, 'independent'), pBA: P('P(B | A)', 0.6) },
        show: { pBA: 'relation:given' },
        when: { pBA: (x) => x.relation === 'given' },
        label: 'P(A and B)',
        rows: { or: 'P(A or B)', neither: 'P(neither)', aOnly: 'P(A but not B)', bOnly: 'P(B but not A)' },
        run: (x) => {
            if (notProb(x, ['pA', 'pB']) || (x.relation === 'given' && notProb(x, ['pBA']))) {
                return { error: 'Probabilities must be between 0 and 1.' };
            }

            const and = x.relation === 'independent' ? x.pA * x.pB : x.relation === 'exclusive' ? 0 : x.pA * x.pBA;

            if (and > Math.min(x.pA, x.pB) + 1e-12 || x.pA + x.pB - and > 1 + 1e-12) {
                return { error: 'These probabilities are impossible together (check P(B | A) against P(B)).' };
            }

            const or = x.pA + x.pB - and;
            const rule = { independent: `P(A and B) = P(A) × P(B) = ${num(x.pA)} × ${num(x.pB)}`, exclusive: 'Mutually exclusive events cannot happen together: P(A and B) = 0', given: `P(A and B) = P(A) × P(B | A) = ${num(x.pA)} × ${num(x.pBA)}` }[x.relation];

            return { value: num(and, 6), sub: pct(and), rows: { or: num(or, 6), neither: num(1 - or, 6), aOnly: num(x.pA - and, 6), bOnly: num(x.pB - and, 6) }, steps: [rule, `= ${num(and, 8)}`, `P(A or B) = P(A) + P(B) − P(A and B) = ${num(or, 8)}`] };
        },
    },
    lottery: {
        type: 'calc',
        inputs: { format: SEL('Lottery', 'data:lotteries', 'custom'), k: N('Numbers picked', 6, 1), n: N('From a pool of', 49, 1), k2: N('Bonus numbers picked (0 if none)', 0, 0), n2: N('From a bonus pool of', 10, 1), tickets: N('Tickets bought', 1, 1), price: MONEY('Price per ticket', 2) },
        show: { k: 'format:custom', n: 'format:custom', k2: 'format:custom', n2: 'format:custom' },
        when: { k: (x) => x.format === 'custom', n: (x) => x.format === 'custom', k2: (x) => x.format === 'custom', n2: (x) => x.format === 'custom' },
        data: ['lotteries'],
        optional: ['price'],
        label: 'Odds of the jackpot',
        rows: { combos: 'Possible tickets', withTickets: 'Chance with your tickets', cost: 'Cost of the tickets', years: 'Draws needed for a 50% chance' },
        grids: [['tiers', 'Odds of each match']],
        run: (x, ctx) => {
            const preset = ctx.c.data.statistics?.lotteries?.[x.format];
            const [k, n, k2, n2] = preset && x.format !== 'custom' ? [preset.k, preset.n, preset.k2, preset.n2] : [x.k, x.n, x.k2, x.n2];

            if (![k, n, k2, n2].every(Number.isInteger) || k < 1 || k > n || n > 1000 || k2 < 0 || (k2 > 0 && k2 > n2) || n2 > 1000) {
                return { error: 'Pick fewer numbers than the pool holds (whole numbers, pools up to 1,000).' };
            }

            const { total, tiers } = lotteryTiers(k, n, k2, n2);
            const pJack = 1 / Number(total);
            const t = Math.max(1, x.tickets);
            const withT = Math.min(1, t / Number(total));
            const draws = Math.log(0.5) / Math.log1p(-withT);

            return { value: `1 in ${bigText(total)}`, sub: `${k} from ${n}${k2 ? ` plus ${k2} from ${n2}` : ''}${preset?.source && x.format !== 'custom' ? ` (${preset.name})` : ''}`, rows: { combos: bigText(total), withTickets: `${pct(withT, 4)} (${oneIn(withT)})`, cost: Number.isFinite(x.price) ? formatMoney(x.price * t) : 'Enter a price', years: withT >= 1 ? '1' : num(draws, 4) }, steps: [`Ways to choose ${k} of ${n}: C(${n}, ${k}) = ${bigText(chooseBig(n, k))}`, ...(k2 ? [`Ways to choose ${k2} of ${n2}: C(${n2}, ${k2}) = ${bigText(chooseBig(n2, k2))}`] : []), `Jackpot odds = 1 in ${bigText(total)} (P = ${num(pJack, 6)})`, 'Matching m of the main numbers: C(k, m) × C(n − k, k − m) ways (hypergeometric)', ...(preset?.source && x.format !== 'custom' ? [`Format: ${preset.source}`] : [])], grids: { tiers: { columns: ['Ways', 'Odds'], rows: tiers.filter((r) => r.ways > 0n).map((r) => ({ header: `${r.m} main${k2 ? ` + ${r.b} bonus` : ''}`, cells: [bigText(r.ways), `1 in ${num(Number(total) / Number(r.ways), 6)}`], highlight: r.m === k && r.b === k2 })) } } };
        },
    },
    monty_hall: {
        type: 'calc',
        inputs: { doors: N('Doors', 3, 3), opened: N('Doors the host opens (all goats)', 1, 1), choice: SEL('You', { switch: 'Switch', stay: 'Stay' }, 'switch'), trials: TRIALS, seed: SEED },
        label: 'P(win the car)',
        rows: { other: 'If you do the opposite', sim: 'Simulated wins', advantage: 'Switching vs staying' },
        run: (x) => {
            const n = x.doors;
            const k = x.opened;

            if (!(Number.isInteger(n) && Number.isInteger(k) && n >= 3 && n <= 1000 && k >= 1 && k <= n - 2)) {
                return { error: 'Use at least 3 doors; the host opens 1 to doors − 2 of them.' };
            }

            if (!trialsOk(x.trials)) {
                return { error: 'Use 1 to 1,000,000 trials.' };
            }

            const stay = 1 / n;
            const sw = (n - 1) / (n * (n - k - 1));
            const r = seeded(x.seed);
            let wins = 0;

            for (let t = 0; t < x.trials; t += 1) {
                const car = Math.floor(r() * n);
                const pick = Math.floor(r() * n);

                if (x.choice === 'stay') {
                    wins += pick === car ? 1 : 0;
                } else {
                    // Doors left after the host opens k goat doors (not the pick, not the car); switch to one of them at random.
                    const remaining = n - 1 - k;

                    if (pick !== car) {
                        wins += Math.floor(r() * remaining) === 0 ? 1 : 0;
                    }
                }
            }

            const mine = x.choice === 'switch' ? sw : stay;

            return { value: num(mine, 6), sub: `${x.choice === 'switch' ? 'Switching' : 'Staying'} wins ${pct(mine, 4)} of the time`, rows: { other: num(x.choice === 'switch' ? stay : sw, 6), sim: `${num(wins / x.trials, 6)} (${num(wins)} of ${num(x.trials)})`, advantage: `Switching is ${num(sw / stay, 5)}× as likely to win` }, steps: ['Staying wins only if the first pick was the car: 1/n', `Switching: the car is elsewhere with probability (n − 1)/n, spread over the n − k − 1 closed doors you can switch to`, `P(switch wins) = (n − 1) ÷ (n(n − k − 1)) = ${n - 1} ÷ (${n} × ${n - k - 1}) = ${num(sw, 8)}`, 'The host’s choice is not random: he always reveals a goat, which is why switching helps'] };
        },
    },
    odds: {
        type: 'calc',
        inputs: { odds: LINE('Odds (2.5, 3/2, “3 to 2”, +150, −200 or 40%)', '3/2'), stake: MONEY('Stake', 10) },
        optional: ['stake'],
        label: 'Implied probability',
        rows: { decimal: 'Decimal odds', fractional: 'Fractional odds', moneyline: 'Moneyline (American)', against: 'Odds against', payout: 'Payout if it wins', profit: 'Profit if it wins' },
        run: (x) => {
            const dec = parseOdds(x.odds);

            if (!Number.isFinite(dec)) {
                return { error: 'Enter odds such as 2.5 (decimal), 3/2 (fractional), +150 or −200 (moneyline) or 40%.' };
            }

            const p = 1 / dec;
            const stake = Number.isFinite(x.stake) ? x.stake : NaN;

            return { value: pct(p, 5), sub: `${fractional(dec)} = ${num(dec, 6)} decimal = ${moneyline(dec)}`, rows: { decimal: num(dec, 6), fractional: fractional(dec), moneyline: moneyline(dec), against: `${num(dec - 1, 5)} to 1 against`, payout: Number.isFinite(stake) ? formatMoney(stake * dec) : 'Enter a stake', profit: Number.isFinite(stake) ? formatMoney(stake * (dec - 1)) : 'Enter a stake' }, steps: ['Decimal odds = total return per 1 staked', 'Fractional a/b → decimal 1 + a/b; moneyline +m → 1 + m/100, −m → 1 + 100/m', `Implied probability = 1 ÷ ${num(dec, 6)} = ${num(p, 6)}`, 'Bookmaker odds include a margin, so implied probabilities run a little high'] };
        },
    },
    parrondo: {
        type: 'calc',
        inputs: { pattern: SEL('Play', { A: 'Game A only', B: 'Game B only', AB: 'Alternate A, B', AABB: 'A, A, B, B repeated', random: 'A or B at random each round' }, 'AABB'), rounds: N('Rounds', 100, 1), eps: N('Bias ε', 0.005, 0) },
        label: 'Expected capital after the last round',
        rows: { a: 'Game A alone', b: 'Game B alone', verdict: 'Result' },
        plots: [['capital', 'Expected capital (blue: your pattern; dashed: A and B alone)']],
        run: (x) => {
            if (!(Number.isInteger(x.rounds) && x.rounds >= 1 && x.rounds <= 2000) || !(x.eps >= 0 && x.eps < 0.1)) {
                return { error: 'Use 1 to 2,000 rounds and ε between 0 and 0.1.' };
            }

            const mine = parrondoExpected(x.pattern, x.rounds, x.eps);
            const a = parrondoExpected('A', x.rounds, x.eps);
            const b = parrondoExpected('B', x.rounds, x.eps);
            const end = mine[mine.length - 1][1];

            return { value: num(end, 5), sub: `${end > 0 ? 'Winning' : 'Losing'} on average after ${x.rounds} rounds`, rows: { a: num(a[a.length - 1][1], 5), b: num(b[b.length - 1][1], 5), verdict: x.pattern !== 'A' && x.pattern !== 'B' && end > 0 ? 'Two losing games combine into a winning one' : end > 0 ? 'Winning' : 'Losing' }, steps: [`Game A: win 1 with probability ½ − ε = ${num(0.5 - x.eps)}`, `Game B: if capital is a multiple of 3, win with ${num(0.1 - x.eps)}; otherwise with ${num(0.75 - x.eps)}`, 'Each game alone loses; mixing them changes how often capital sits on a multiple of 3', 'Exact: the capital distribution is carried forward round by round (no simulation)', 'Harmer & Abbott, Nature 402 (1999)'], plots: { capital: { series: mine, extra: [a, b], xLabel: 'Round', yLabel: 'Expected capital', axes: true } } };
        },
    },
    password: {
        type: 'calc',
        inputs: { by: SEL('Describe the password by', { sets: 'Length and characters', sample: 'A sample password (not sent anywhere)' }, 'sets'), length: N('Length', 12, 1), chars: SEL('Characters used', { 10: 'Digits only (10)', 26: 'Lowercase letters (26)', 36: 'Lowercase and digits (36)', 52: 'Upper and lowercase (52)', 62: 'Letters and digits (62)', 94: 'Letters, digits and symbols (94)' }, '62'), sample: LINE('Sample password', 'Tr0ub4dor&3'), rate: N('Guesses per second', 1e10, 1) },
        show: { length: 'by:sets', chars: 'by:sets', sample: 'by:sample' },
        when: { length: (x) => x.by === 'sets' },
        label: 'Possible passwords',
        rows: { entropy: 'Entropy', half: 'Time to search half', all: 'Time to search all' },
        run: (x) => {
            let L = x.length;
            let Nc = Number(x.chars);

            if (x.by === 'sample') {
                const s = String(x.sample ?? '');

                if (!s) {
                    return { empty: 'Enter a sample password.' };
                }

                L = [...s].length;
                Nc = (/[a-z]/.test(s) ? 26 : 0) + (/[A-Z]/.test(s) ? 26 : 0) + (/\d/.test(s) ? 10 : 0) + (/[^a-zA-Z\d]/.test(s) ? 32 : 0);
            }

            if (!(Number.isInteger(L) && L >= 1 && L <= 256)) {
                return { error: 'Length must be 1 to 256 characters.' };
            }

            const count = BigInt(Nc) ** BigInt(L);
            const bits = L * Math.log2(Nc);
            const secs = (2 ** bits / 2) / x.rate;
            const span = (s) => (s < 1 ? `${num(s, 3)} s` : s < 3600 ? `${num(s / 60, 3)} minutes` : s < 86400 * 365.25 ? `${num(s / 86400, 3)} days` : `${num(s / (86400 * 365.25), 3)} years`);

            return { value: bigText(count), sub: `${Nc} characters, length ${L}: ${num(bits, 4)} bits`, rows: { entropy: `${num(bits, 4)} bits`, half: span(secs), all: span(secs * 2) }, steps: [`Possibilities = (characters)^(length) = ${Nc}^${L}`, `Entropy = length × log₂(characters) = ${L} × ${num(Math.log2(Nc), 6)} = ${num(bits, 6)} bits`, `At ${num(x.rate)} guesses per second, a brute-force search finds it after half the space on average`, 'Real attackers try common words and patterns first; a random password is the only kind this number describes (NIST SP 800-63B)'] };
        },
    },
    p_hat: {
        type: 'calc',
        inputs: { x: N('Successes x', 42, 0), n: N('Sample size n', 120, 1), conf: N('Confidence for the interval (%)', 95, 0) },
        label: 'Sample proportion p̂',
        rows: { q: 'q̂ = 1 − p̂', se: 'Standard error', wilson: 'Wilson interval', wald: 'Wald interval' },
        run: (x) => {
            if (!(x.x >= 0 && x.x <= x.n) || !(x.conf > 0 && x.conf < 100)) {
                return { error: 'Successes must be between 0 and n; confidence between 0 and 100%.' };
            }

            const p = x.x / x.n;
            const se = Math.sqrt((p * (1 - p)) / x.n);
            const z = normInv(1 - (1 - x.conf / 100) / 2);
            const [lo, hi] = wilson(x.x, x.n, x.conf / 100);

            return { value: num(p, 6), sub: `${pct(p)} of the sample`, rows: { q: num(1 - p, 6), se: num(se, 6), wilson: `${num(lo, 5)} to ${num(hi, 5)}`, wald: `${num(Math.max(0, p - z * se), 5)} to ${num(Math.min(1, p + z * se), 5)}` }, steps: ['p̂ = x ÷ n', `= ${num(x.x)} ÷ ${num(x.n)} = ${num(p, 8)}`, `SE = √(p̂(1 − p̂)/n) = ${num(se, 8)}`, 'The Wilson interval is preferred; the Wald interval fails near 0 and 1'] };
        },
    },
    post_test: {
        type: 'calc',
        inputs: { pre: N('Pre-test probability (%)', 20, 0), by: SEL('Test described by', { lr: 'A likelihood ratio', sens: 'Sensitivity and specificity' }, 'sens'), lr: N('Likelihood ratio', 4, 0), sens: N('Sensitivity (%)', 85, 0), spec: N('Specificity (%)', 90, 0), result: SEL('Test result', { pos: 'Positive', neg: 'Negative' }, 'pos') },
        show: { lr: 'by:lr', sens: 'by:sens', spec: 'by:sens', result: 'by:sens' },
        when: { lr: (x) => x.by === 'lr', sens: (x) => x.by === 'sens', spec: (x) => x.by === 'sens' },
        label: 'Post-test probability',
        rows: { preOdds: 'Pre-test odds', lrUsed: 'Likelihood ratio used', postOdds: 'Post-test odds' },
        run: (x) => {
            if (!(x.pre >= 0 && x.pre < 100)) {
                return { error: 'The pre-test probability must be between 0 and 100%.' };
            }

            let lr = x.lr;
            let how = 'Likelihood ratio entered';

            if (x.by === 'sens') {
                const se = x.sens / 100;
                const sp = x.spec / 100;

                if (!(se >= 0 && se <= 1 && sp >= 0 && sp <= 1)) {
                    return { error: 'Sensitivity and specificity must be 0–100%.' };
                }

                lr = x.result === 'pos' ? se / (1 - sp) : (1 - se) / sp;
                how = x.result === 'pos' ? `LR+ = sensitivity ÷ (1 − specificity) = ${num(se)} ÷ ${num(1 - sp)}` : `LR− = (1 − sensitivity) ÷ specificity = ${num(1 - se)} ÷ ${num(sp)}`;
            }

            const preOdds = x.pre / (100 - x.pre);
            const postOdds = preOdds * lr;
            const post = Number.isFinite(postOdds) ? postOdds / (1 + postOdds) : 1;

            return { value: pct(post, 5), sub: `From ${num(x.pre)}% before the test`, rows: { preOdds: num(preOdds, 6), lrUsed: num(lr, 6), postOdds: num(postOdds, 6) }, steps: [how, `Pre-test odds = p ÷ (1 − p) = ${num(preOdds, 6)}`, `Post-test odds = pre-test odds × LR = ${num(postOdds, 6)}`, `Post-test probability = odds ÷ (1 + odds) = ${num(post, 6)}`] };
        },
    },
    probability: {
        type: 'calc',
        inputs: { pA: P('P(A)', 0.5), pB: P('P(B)', 0.3), relation: SEL('A and B are', { independent: 'Independent', exclusive: 'Mutually exclusive', given: 'I know P(A and B)' }, 'independent'), pAB: P('P(A and B)', 0.1) },
        show: { pAB: 'relation:given' },
        when: { pAB: (x) => x.relation === 'given' },
        label: 'P(A and B)',
        rows: { or: 'P(A or B)', notA: 'P(not A)', notB: 'P(not B)', xor: 'P(exactly one)', neither: 'P(neither)', aGivenB: 'P(A | B)' },
        plots: [['venn', 'Probabilities of each region']],
        run: (x) => {
            if (notProb(x, ['pA', 'pB']) || (x.relation === 'given' && notProb(x, ['pAB']))) {
                return { error: 'Probabilities must be between 0 and 1.' };
            }

            const and = x.relation === 'independent' ? x.pA * x.pB : x.relation === 'exclusive' ? 0 : x.pAB;

            if (and > Math.min(x.pA, x.pB) + 1e-12 || x.pA + x.pB - and > 1 + 1e-12) {
                return { error: x.relation === 'exclusive' ? 'Exclusive events need P(A) + P(B) ≤ 1.' : 'P(A and B) must be at most the smaller of P(A) and P(B), and P(A or B) at most 1.' };
            }

            const or = x.pA + x.pB - and;
            const f = (v) => num(v, 4);

            return { value: num(and, 6), sub: `P(A or B) = ${num(or, 6)}`, rows: { or: num(or, 6), notA: num(1 - x.pA, 6), notB: num(1 - x.pB, 6), xor: num(or - and, 6), neither: num(1 - or, 6), aGivenB: x.pB > 0 ? num(and / x.pB, 6) : 'Undefined (P(B) = 0)' }, steps: [x.relation === 'independent' ? 'Independent: P(A and B) = P(A) × P(B)' : x.relation === 'exclusive' ? 'Mutually exclusive: P(A and B) = 0' : 'P(A and B) as given', `P(A and B) = ${num(and, 8)}`, 'P(A or B) = P(A) + P(B) − P(A and B)', `= ${num(x.pA)} + ${num(x.pB)} − ${num(and, 8)} = ${num(or, 8)}`], plots: { venn: { kind: 'venn', names: ['A', 'B'], regions: { a: f(x.pA - and), b: f(x.pB - and), ab: f(and), none: f(1 - or) } } } };
        },
    },
    three_events: {
        type: 'calc',
        inputs: { pA: P('P(A)', 0.5), pB: P('P(B)', 0.4), pC: P('P(C)', 0.3) },
        label: 'P(all three)',
        rows: { any: 'P(at least one)', one: 'P(exactly one)', two: 'P(exactly two)', none: 'P(none)' },
        grids: [['table', 'All eight outcomes (independent events)']],
        run: (x) => {
            if (notProb(x, ['pA', 'pB', 'pC'])) {
                return { error: 'Probabilities must be between 0 and 1.' };
            }

            const ps = [x.pA, x.pB, x.pC];
            const outcomes = [];

            for (let mask = 7; mask >= 0; mask -= 1) {
                const bits = [4, 2, 1].map((b) => Boolean(mask & b));
                outcomes.push({ bits, p: bits.reduce((t, on, i) => t * (on ? ps[i] : 1 - ps[i]), 1) });
            }

            const byCount = (c) => outcomes.filter((o) => o.bits.filter(Boolean).length === c).reduce((t, o) => t + o.p, 0);

            return { value: num(byCount(3), 6), sub: `P(at least one) = ${num(1 - byCount(0), 6)}`, rows: { any: num(1 - byCount(0), 6), one: num(byCount(1), 6), two: num(byCount(2), 6), none: num(byCount(0), 6) }, steps: ['Independent events multiply: P(A and B and C) = P(A) P(B) P(C)', `= ${ps.map((v) => num(v)).join(' × ')} = ${num(byCount(3), 8)}`, 'P(at least one) = 1 − P(none) = 1 − (1 − P(A))(1 − P(B))(1 − P(C))'], grids: { table: { columns: ['Probability'], rows: outcomes.map((o) => ({ header: o.bits.map((on, i) => (on ? 'ABC'[i] : `not ${'ABC'[i]}`)).join(', '), cells: [num(o.p, 6)] })) } } };
        },
    },
    relative_risk: {
        type: 'calc',
        inputs: { a: N('Exposed: with the outcome', 30, 0), b: N('Exposed: without', 70, 0), c: N('Unexposed: with the outcome', 15, 0), d: N('Unexposed: without', 85, 0), conf: N('Confidence (%)', 95, 0) },
        label: 'Relative risk',
        rows: { ci: 'Confidence interval', riskE: 'Risk if exposed', riskU: 'Risk if unexposed', rd: 'Risk difference', or: 'Odds ratio', nnt: 'Number needed to treat / harm' },
        run: (x) => {
            if (![x.a, x.b, x.c, x.d].every((v) => v >= 0) || x.a + x.b === 0 || x.c + x.d === 0) {
                return { error: 'Enter counts for both groups.' };
            }

            const r1 = x.a / (x.a + x.b);
            const r0 = x.c / (x.c + x.d);
            const rr = r1 / r0;
            const z = normInv(1 - (1 - x.conf / 100) / 2);
            const se = Math.sqrt(1 / x.a - 1 / (x.a + x.b) + 1 / x.c - 1 / (x.c + x.d));
            const rd = r1 - r0;

            return { value: num(rr, 5), sub: rr > 1 ? `Exposure is linked to ${num((rr - 1) * 100, 4)}% more risk` : rr < 1 ? `Exposure is linked to ${num((1 - rr) * 100, 4)}% less risk` : 'No difference in risk', rows: { ci: Number.isFinite(se) && x.a > 0 && x.c > 0 ? `${num(Math.exp(Math.log(rr) - z * se), 5)} to ${num(Math.exp(Math.log(rr) + z * se), 5)}` : 'Needs events in both groups', riskE: pct(r1, 5), riskU: pct(r0, 5), rd: pct(rd, 5), or: x.b * x.c > 0 ? num((x.a * x.d) / (x.b * x.c), 5) : 'Undefined', nnt: rd === 0 ? 'Infinite' : `${num(Math.abs(1 / rd), 4)} (${rd > 0 ? 'NNH' : 'NNT'})` }, steps: [`Risk exposed = ${num(x.a)} ÷ ${num(x.a + x.b)} = ${num(r1, 6)}`, `Risk unexposed = ${num(x.c)} ÷ ${num(x.c + x.d)} = ${num(r0, 6)}`, `RR = ${num(r1, 6)} ÷ ${num(r0, 6)} = ${num(rr, 6)}`, `SE(ln RR) = √(1/a − 1/(a+b) + 1/c − 1/(c+d)) = ${num(se, 6)} (Katz log method)`] };
        },
    },
    risk: {
        type: 'calc',
        inputs: { e1: N('Events in the treated group', 12, 0), n1: N('People in the treated group', 200, 1), e0: N('Events in the control group', 24, 0), n0: N('People in the control group', 200, 1) },
        label: 'Absolute risk reduction',
        rows: { r1: 'Risk with treatment', r0: 'Risk without (control)', rrr: 'Relative risk reduction', rr: 'Relative risk', nnt: 'Number needed to treat' },
        run: (x) => {
            if (x.e1 > x.n1 || x.e0 > x.n0) {
                return { error: 'Events cannot exceed group size.' };
            }

            const r1 = x.e1 / x.n1;
            const r0 = x.e0 / x.n0;
            const arr = r0 - r1;

            return { value: pct(arr, 5), sub: arr > 0 ? `Treatment lowers the risk from ${pct(r0, 4)} to ${pct(r1, 4)}` : arr < 0 ? `Treatment raises the risk from ${pct(r0, 4)} to ${pct(r1, 4)}` : 'No difference', rows: { r1: pct(r1, 5), r0: pct(r0, 5), rrr: r0 > 0 ? pct(arr / r0, 5) : 'Undefined', rr: r0 > 0 ? num(r1 / r0, 5) : 'Undefined', nnt: arr === 0 ? 'Infinite' : `${num(Math.ceil(Math.abs(1 / arr)))} (${arr > 0 ? 'treat to prevent one event' : 'treated per extra harm (NNH)'})` }, steps: [`Absolute risk = events ÷ people: ${num(r1, 6)} and ${num(r0, 6)}`, `ARR = ${num(r0, 6)} − ${num(r1, 6)} = ${num(arr, 6)}`, 'RRR = ARR ÷ control risk; NNT = 1 ÷ ARR, rounded up'] };
        },
    },
    roulette: {
        type: 'calc',
        inputs: { wheel: SEL('Wheel', { european: 'European (single zero, 37 pockets)', american: 'American (double zero, 38 pockets)' }, 'european'), bet: SEL('Bet', Object.fromEntries(Object.entries(BETS).map(([k, v]) => [k, v[0]])), 'straight'), stake: MONEY('Stake', 10) },
        label: 'Payout if it wins',
        rows: { profit: 'Profit if it wins', chance: 'Chance of winning', ev: 'Expected result per bet', edge: 'House edge' },
        run: (x) => {
            const [name, covered, ratio] = BETS[x.bet];
            const pockets = x.wheel === 'american' ? 38 : 37;

            if (x.bet === 'basket' && x.wheel !== 'american') {
                return { error: 'The five-number basket bet exists only on the American wheel.' };
            }

            const p = covered / pockets;
            const ev = x.stake * (p * ratio - (1 - p));

            return { value: formatMoney(x.stake * (ratio + 1)), sub: `${name} pays ${ratio} to 1`, rows: { profit: formatMoney(x.stake * ratio), chance: `${covered}/${pockets} = ${pct(p, 4)}`, ev: formatMoney(ev), edge: pct(-(p * ratio - (1 - p)), 4) }, steps: [`Win probability = ${covered} ÷ ${pockets}`, `Payout = stake × (${ratio} + 1)`, `Expected result = stake × (P(win) × ${ratio} − P(lose)) = ${formatMoney(ev)}`, `House edge ${x.wheel === 'american' ? (x.bet === 'basket' ? '7.89% (the worst bet on the table)' : '5.26%') : '2.70%'}: no betting system changes it`] };
        },
    },
    sens_spec: {
        type: 'calc',
        inputs: { TP: N('True positives', 90, 0), FN: N('False negatives', 10, 0), FP: N('False positives', 30, 0), TN: N('True negatives', 270, 0), conf: N('Confidence (%)', 95, 0) },
        label: 'Sensitivity',
        rows: { spec: 'Specificity', ppv: 'Positive predictive value', npv: 'Negative predictive value', lrp: 'LR+', lrn: 'LR−', prev: 'Prevalence in this sample', acc: 'Accuracy' },
        run: (x) => {
            if (x.TP + x.FN === 0 || x.TN + x.FP === 0) {
                return { error: 'Enter at least one person with and one without the condition.' };
            }

            const c = x.conf / 100;
            const se = x.TP / (x.TP + x.FN);
            const sp = x.TN / (x.TN + x.FP);
            const [sl, sh] = wilson(x.TP, x.TP + x.FN, c);
            const [pl, ph] = wilson(x.TN, x.TN + x.FP, c);
            const total = x.TP + x.FN + x.FP + x.TN;

            return { value: pct(se, 5), sub: `${num(x.conf)}% CI ${pct(sl, 4)} to ${pct(sh, 4)} (Wilson)`, rows: { spec: `${pct(sp, 5)} (CI ${pct(pl, 4)} to ${pct(ph, 4)})`, ppv: x.TP + x.FP ? pct(x.TP / (x.TP + x.FP), 5) : 'No positives', npv: x.TN + x.FN ? pct(x.TN / (x.TN + x.FN), 5) : 'No negatives', lrp: sp < 1 ? num(se / (1 - sp), 5) : 'Infinite', lrn: sp > 0 ? num((1 - se) / sp, 5) : 'Infinite', prev: pct((x.TP + x.FN) / total, 5), acc: pct((x.TP + x.TN) / total, 5) }, steps: [`Sensitivity = TP ÷ (TP + FN) = ${num(x.TP)} ÷ ${num(x.TP + x.FN)} = ${num(se, 6)}`, `Specificity = TN ÷ (TN + FP) = ${num(x.TN)} ÷ ${num(x.TN + x.FP)} = ${num(sp, 6)}`, 'Predictive values depend on prevalence; sensitivity and specificity do not'] };
        },
    },
    two_envelopes: {
        type: 'calc',
        inputs: { strategy: SEL('Strategy', { always: 'Always switch', never: 'Never switch', threshold: 'Switch only if the amount is below a threshold' }, 'always'), max: N('Smaller amount is random from 1 to', 100, 1), threshold: N('Threshold', 60, 0), trials: TRIALS, seed: SEED },
        show: { threshold: 'strategy:threshold' },
        when: { threshold: (x) => x.strategy === 'threshold' },
        label: 'Average amount won',
        rows: { exact: 'Exact average for this strategy', baseline: 'Average without switching', gain: 'Gain from the strategy' },
        run: (x) => {
            if (!trialsOk(x.trials) || !(Number.isInteger(x.max) && x.max >= 1 && x.max <= 1e6)) {
                return { error: 'Use 1 to 1,000,000 trials and a whole maximum amount.' };
            }

            const r = seeded(x.seed);
            let total = 0;
            const switchIf = (amount) => (x.strategy === 'always' ? true : x.strategy === 'never' ? false : amount < x.threshold);

            for (let t = 0; t < x.trials; t += 1) {
                const small = 1 + Math.floor(r() * x.max);
                const pair = [small, 2 * small];
                const held = pair[Math.floor(r() * 2)];
                total += switchIf(held) ? (held === small ? 2 * small : small) : held;
            }

            let exact = 0;

            for (let s = 1; s <= x.max; s += 1) {
                exact += 0.5 * (switchIf(s) ? 2 * s : s) + 0.5 * (switchIf(2 * s) ? s : 2 * s);
            }

            exact /= x.max;
            const base = (1.5 * (x.max + 1)) / 2;

            return { value: num(total / x.trials, 6), sub: `${num(x.trials)} simulated games (seed ${x.seed})`, rows: { exact: num(exact, 6), baseline: num(base, 6), gain: num(exact - base, 6) }, steps: ['The argument “the other envelope holds 2x or x/2, so switching averages 1.25x” is wrong: x is not fixed', 'Once the amounts are set, swapping just exchanges the small and the large envelope: always or never switching both average 1.5 × E[smaller]', 'A threshold strategy can win on average, because it switches small amounts more often (Cover; McDonnell & Abbott, 2009)', `Exact average with this strategy = ${num(exact, 8)}`] };
        },
    },
    odds_ratio: {
        type: 'calc',
        inputs: { a: N('Exposed: with the outcome (cases)', 40, 0), b: N('Exposed: without (controls)', 60, 0), c: N('Unexposed: with the outcome', 20, 0), d: N('Unexposed: without', 80, 0), conf: N('Confidence (%)', 95, 0) },
        label: 'Odds ratio',
        rows: { ci: 'Confidence interval', p: 'p-value (z test on ln OR)', logor: 'ln(OR) ± SE', note: 'Zero cells' },
        run: (x) => {
            if (![x.a, x.b, x.c, x.d].every((v) => v >= 0)) {
                return { error: 'Counts cannot be negative.' };
            }

            const zero = [x.a, x.b, x.c, x.d].some((v) => v === 0);
            const [a, b, c, d] = zero ? [x.a + 0.5, x.b + 0.5, x.c + 0.5, x.d + 0.5] : [x.a, x.b, x.c, x.d];
            const or = (a * d) / (b * c);
            const se = Math.sqrt(1 / a + 1 / b + 1 / c + 1 / d);
            const z = normInv(1 - (1 - x.conf / 100) / 2);
            const zs = Math.log(or) / se;

            return { value: num(or, 5), sub: `${num(x.conf)}% CI ${num(Math.exp(Math.log(or) - z * se), 5)} to ${num(Math.exp(Math.log(or) + z * se), 5)}`, rows: { ci: `${num(Math.exp(Math.log(or) - z * se), 5)} to ${num(Math.exp(Math.log(or) + z * se), 5)}`, p: num(2 * normCdf(-Math.abs(zs)), 4), logor: `${num(Math.log(or), 5)} ± ${num(se, 5)}`, note: zero ? '0.5 added to every cell (Haldane–Anscombe)' : 'None' }, steps: ['OR = (a × d) ÷ (b × c)', `= (${num(a)} × ${num(d)}) ÷ (${num(b)} × ${num(c)}) = ${num(or, 6)}`, `SE(ln OR) = √(1/a + 1/b + 1/c + 1/d) = ${num(se, 6)} (Woolf)`, 'For a rare outcome the odds ratio is close to the relative risk'] };
        },
    },
    likelihood_ratio: {
        type: 'calc',
        inputs: { sens: N('Sensitivity (%)', 85, 0), spec: N('Specificity (%)', 90, 0), pre: N('Pre-test probability (%, optional)', 20, 0) },
        optional: ['pre'],
        label: 'Positive likelihood ratio (LR+)',
        rows: { lrn: 'Negative likelihood ratio (LR−)', postPos: 'Probability after a positive', postNeg: 'Probability after a negative', strength: 'How useful' },
        run: (x) => {
            const se = x.sens / 100;
            const sp = x.spec / 100;

            if (!(se >= 0 && se <= 1 && sp >= 0 && sp <= 1)) {
                return { error: 'Sensitivity and specificity must be 0–100%.' };
            }

            const lrp = se / (1 - sp);
            const lrn = (1 - se) / sp;
            const post = (lr) => {
                if (!(x.pre >= 0 && x.pre < 100)) {
                    return 'Enter a pre-test probability';
                }

                const o = (x.pre / (100 - x.pre)) * lr;

                return pct(Number.isFinite(o) ? o / (1 + o) : 1, 4);
            };

            return { value: Number.isFinite(lrp) ? num(lrp, 5) : 'Infinite', sub: `LR− = ${num(lrn, 5)}`, rows: { lrn: num(lrn, 5), postPos: post(lrp), postNeg: post(lrn), strength: lrp >= 10 || lrn <= 0.1 ? 'Large change (LR+ ≥ 10 or LR− ≤ 0.1)' : lrp >= 5 || lrn <= 0.2 ? 'Moderate change' : 'Small change' }, steps: ['LR+ = sensitivity ÷ (1 − specificity)', `= ${num(se)} ÷ ${num(1 - sp)} = ${num(lrp, 6)}`, 'LR− = (1 − sensitivity) ÷ specificity', `= ${num(1 - se)} ÷ ${num(sp)} = ${num(lrn, 6)}`, 'Post-test odds = pre-test odds × LR (Jaeschke et al., JAMA 1994)'] };
        },
    },
    kelly: {
        type: 'calc',
        inputs: { odds: LINE('Odds offered (2.5, 3/2 or +150)', '2.5'), p: N('Your chance of winning (%)', 45, 0), bank: MONEY('Bankroll', 1000) },
        optional: ['bank'],
        label: 'Kelly stake (share of bankroll)',
        rows: { stake: 'Stake', half: 'Half-Kelly stake', edge: 'Your edge (expected profit per 1 staked)' },
        run: (x) => {
            const dec = parseOdds(x.odds);

            if (!Number.isFinite(dec) || !(x.p > 0 && x.p < 100)) {
                return { error: 'Enter odds you can read (2.5, 3/2, +150) and a chance between 0 and 100%.' };
            }

            const b = dec - 1;
            const p = x.p / 100;
            const f = (b * p - (1 - p)) / b;
            const edge = p * b - (1 - p);
            const bank = Number.isFinite(x.bank) ? x.bank : NaN;

            if (f <= 0) {
                return { value: '0%', sub: 'No bet: the odds do not beat your estimate', rows: { stake: Number.isFinite(bank) ? formatMoney(0) : '—', half: Number.isFinite(bank) ? formatMoney(0) : '—', edge: num(edge, 5) }, steps: ['f* = (bp − q) ÷ b', `= (${num(b, 5)} × ${num(p)} − ${num(1 - p)}) ÷ ${num(b, 5)} = ${num(f, 6)} ≤ 0`, 'A negative edge means the Kelly criterion says do not bet'] };
            }

            return { value: pct(f, 4), sub: 'Maximises long-run growth if your probability is right', rows: { stake: Number.isFinite(bank) ? formatMoney(bank * f) : 'Enter a bankroll', half: Number.isFinite(bank) ? formatMoney((bank * f) / 2) : 'Enter a bankroll', edge: num(edge, 5) }, steps: ['Kelly (1956): f* = (bp − q) ÷ b, with b = decimal odds − 1, p = win chance, q = 1 − p', `= (${num(b, 5)} × ${num(p)} − ${num(1 - p)}) ÷ ${num(b, 5)} = ${num(f, 6)}`, 'Overestimating p makes full Kelly very risky; many bettors stake half of it'] };
        },
    },
    card_draw: {
        type: 'calc',
        inputs: { N: N('Cards in the deck', 52, 1), K: N('Cards of interest in the deck (e.g. aces)', 4, 0), n: N('Cards drawn', 5, 1), mode: SEL('You want', REGION, 'ge'), k: N('Number of those cards', 1, 0) },
        label: 'Probability',
        rows: { odds: 'Odds', exact: 'P(exactly k)', none: 'P(none of them)', mean: 'Expected number' },
        plots: [['dist', 'Cards of interest drawn']],
        run: (x) => {
            if (![x.N, x.K, x.n, x.k].every(Number.isInteger) || x.K > x.N || x.n > x.N) {
                return { error: 'Use whole numbers: cards of interest and cards drawn cannot exceed the deck.' };
            }

            const d = hypergeometric(x.N, x.K, x.n);
            const value = regionProbability(d, x.mode, x.k);

            return { value: num(value, 6), sub: `${regionText(x.mode, x.k, 0, (v) => num(v), 'cards')} = ${pct(value)}`, rows: { odds: oneIn(value), exact: num(d.pdf(x.k), 6), none: num(d.pdf(0), 6), mean: num(d.mean, 6) }, steps: ['Drawing without replacement follows the hypergeometric distribution', 'P(X = k) = C(K, k) C(N − K, n − k) ÷ C(N, n)', `P(X = ${x.k}) = C(${x.K}, ${x.k}) C(${x.N - x.K}, ${x.n - x.k}) ÷ C(${x.N}, ${x.n}) = ${num(d.pdf(x.k), 8)}`], plots: { dist: distPlot(d, x.mode, x.k, 0, { xLabel: 'Cards of interest' }) } };
        },
    },
    gamblers_ruin: {
        type: 'calc',
        inputs: { start: N('Starting money (units)', 10, 1), target: N('Target (units)', 20, 1), p: N('Chance of winning each 1-unit bet (%)', 47.4, 0) },
        label: 'P(reach the target before going broke)',
        rows: { ruin: 'P(going broke)', rounds: 'Expected number of bets', fair: 'In a fair game' },
        run: (x) => {
            if (!(Number.isInteger(x.start) && Number.isInteger(x.target) && x.start < x.target && x.start > 0)) {
                return { error: 'Use whole numbers with 0 < start < target.' };
            }

            if (!(x.p > 0 && x.p < 100)) {
                return { error: 'The chance must be between 0 and 100%.' };
            }

            const p = x.p / 100;
            const q = 1 - p;
            const i = x.start;
            const Nn = x.target;
            let win;
            let rounds;

            if (Math.abs(p - 0.5) < 1e-12) {
                win = i / Nn;
                rounds = i * (Nn - i);
            } else {
                const r = q / p;
                win = -Math.expm1(i * Math.log(r)) / -Math.expm1(Nn * Math.log(r));
                rounds = i / (q - p) - (Nn / (q - p)) * win;
            }

            return { value: num(win, 6), sub: `${pct(win, 4)} chance to turn ${i} into ${Nn}`, rows: { ruin: num(1 - win, 6), rounds: num(rounds, 5), fair: num(i / Nn, 6) }, steps: ['Each bet wins or loses 1 unit; play stops at 0 or at the target', 'P(win) = (1 − (q/p)^i) ÷ (1 − (q/p)^N) when p ≠ ½, and i/N when p = ½', `q/p = ${num(q / p, 6)}; P = ${num(win, 8)}`, 'Even a small house edge makes reaching a far target unlikely; bold play (fewer, bigger bets) does better'] };
        },
    },
    coupon: {
        type: 'calc',
        inputs: { n: N('Different items in the set', 50, 1), have: N('Different items already collected', 0, 0), draws: N('Draws you can make (optional)', 200, 0) },
        optional: ['draws'],
        label: 'Expected draws to complete the set',
        rows: { within: 'P(complete within your draws)', sd: 'Standard deviation of draws', last: 'Expected draws for the last item' },
        run: (x) => {
            const n = x.n;
            const m = x.have;

            if (!(Number.isInteger(n) && n >= 1 && n <= 10000 && Number.isInteger(m) && m >= 0 && m <= n)) {
                return { error: 'Use whole numbers: 1 to 10,000 items, and already collected at most that many.' };
            }

            let mean = 0;
            let variance = 0;

            for (let c = m; c < n; c += 1) {
                const pNew = (n - c) / n;
                mean += 1 / pNew;
                variance += (1 - pNew) / (pNew * pNew);
            }

            let within = 'Enter a number of draws';

            if (Number.isInteger(x.draws) && x.draws >= 0) {
                if (x.draws * n > 5e7) {
                    within = 'Too many draws to work out exactly';
                } else {
                    let dist = new Array(n + 1).fill(0);
                    dist[m] = 1;

                    for (let t = 0; t < x.draws; t += 1) {
                        const next = new Array(n + 1).fill(0);

                        for (let c = m; c <= n; c += 1) {
                            if (dist[c]) {
                                next[c] += (dist[c] * c) / n;

                                if (c < n) {
                                    next[c + 1] += (dist[c] * (n - c)) / n;
                                }
                            }
                        }

                        dist = next;
                    }

                    within = pct(dist[n], 5);
                }
            }

            return { value: num(mean, 6), sub: `${n - m} items still to find`, rows: { within, sd: num(Math.sqrt(variance), 5), last: num(n, 6) }, steps: ['With c distinct items, a new one comes with probability (n − c)/n, so it takes n/(n − c) draws on average', `E = Σ n/(n − c) for c = ${m} … ${n - 1} = n × H(${n - m}) = ${num(mean, 8)}`, 'The last item alone takes n draws on average'] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
