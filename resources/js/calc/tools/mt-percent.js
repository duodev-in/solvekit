import { defineTools } from '../engines/formula.js';
import { both, dec, f, fail, need, pct, q, qs, R, result } from '../math/util.js';

/**
 * Percentage tools. Inputs are typed as text and kept exact (fractions of BigInts), so 0.1% of 0.3 or
 * 1/3 of a value are not rounded until they are displayed.
 */
const H = R.Q(100);
const ofPct = (p) => R.div(p, H);
const t = R.toFraction;

function changeRows(oldV, newV) {
    const diff = R.sub(newV, oldV);
    const rel = R.div(diff, R.qabs(oldV));

    return { diff, rel };
}

function parseClock(text) {
    const parts = String(text ?? '').trim().split(':').map((p) => R.parseNumber(p));

    if (!parts.length || parts.some((p) => !p) || parts.length > 3) {
        return null;
    }

    // h:m:s, m:s or plain hours.
    const [h, m, s] = parts.length === 3 ? parts : parts.length === 2 ? [R.ZERO, ...parts] : [parts[0], R.ZERO, R.ZERO];

    return R.add(R.add(R.mul(h, R.Q(3600)), R.mul(m, R.Q(60))), s);
}

const clock = (seconds) => {
    const total = R.toNumber(seconds);
    const h = Math.floor(total / 3600);
    const m = Math.floor((total % 3600) / 60);
    const s = total - h * 3600 - m * 60;

    return `${h}:${String(m).padStart(2, '0')}:${s < 10 ? '0' : ''}${f(Math.round(s * 1000) / 1000)}`;
};

export const handlers = {
    percentage: (i) => {
        const mode = i.mode ?? 'of';
        const v = qs(i.a, i.b);

        if (!v) {
            return need('Enter both numbers (fractions such as 3/4 are fine).');
        }

        const [a, b] = v;

        if (mode === 'of') {
            const r = R.mul(ofPct(a), b);

            return result(dec(r), `${dec(a)}% of ${dec(b)}`, { sub: R.isInt(r) ? '' : `= ${t(r)} exactly`, rows: { fraction: t(r), formula: `${dec(a)} ÷ 100 × ${dec(b)} = ${dec(r)}`, other: `${dec(a)}% = ${t(ofPct(a))} = ${dec(ofPct(a))}` }, steps: [`${dec(a)}% = ${dec(a)}/100 = ${dec(ofPct(a))}`, `${dec(ofPct(a))} × ${dec(b)} = ${dec(r)}`] });
        }

        if (mode === 'is') {
            if (R.isZero(b)) {
                return fail('The whole cannot be zero.');
            }

            const p = R.mul(R.div(a, b), H);

            return result(`${dec(p)}%`, `${dec(a)} is this percent of ${dec(b)}`, { rows: { fraction: t(R.div(a, b)), formula: `${dec(a)} ÷ ${dec(b)} × 100 = ${dec(p)}%`, other: `${dec(b)} is ${dec(R.mul(R.div(b, a), H))}% of ${dec(a)}` }, steps: [`${dec(a)} ÷ ${dec(b)} = ${dec(R.div(a, b))}`, `× 100 = ${dec(p)}%`] });
        }

        if (R.isZero(a)) {
            return fail('The percentage cannot be zero.');
        }

        const whole = R.div(b, ofPct(a));

        return result(dec(whole), `${dec(b)} is ${dec(a)}% of`, { rows: { fraction: t(whole), formula: `${dec(b)} ÷ (${dec(a)} ÷ 100) = ${dec(whole)}`, other: `Check: ${dec(a)}% of ${dec(whole)} = ${dec(b)}` }, steps: [`${dec(a)}% = ${dec(ofPct(a))}`, `${dec(b)} ÷ ${dec(ofPct(a))} = ${dec(whole)}`] });
    },

    change: (i, c) => {
        const v = qs(i.a, i.b);

        if (!v) {
            return need('Enter the original and the new value.');
        }

        const [oldV, newV] = v;

        if (R.isZero(oldV)) {
            return fail('The original value cannot be zero (a change from zero has no percentage).');
        }

        const { diff, rel } = changeRows(oldV, newV);
        const word = R.sign(diff) > 0 ? 'increase' : R.sign(diff) < 0 ? 'decrease' : 'no change';
        const relative = c.relative;

        return result(relative ? dec(rel) : `${dec(R.mul(rel, H))}%`, relative ? 'Relative change' : `Percentage ${word === 'no change' ? 'change' : word}`, {
            sub: word === 'no change' ? 'The values are equal' : `A${word === 'increase' ? 'n' : ''} ${word} of ${dec(R.qabs(diff))}`,
            rows: { diff: `${R.sign(diff) > 0 ? '+' : ''}${dec(diff)}`, percent: `${dec(R.mul(rel, H))}%`, relative: dec(rel), formula: `(${dec(newV)} − ${dec(oldV)}) ÷ |${dec(oldV)}| × 100` },
            steps: [`Change = ${dec(newV)} − ${dec(oldV)} = ${dec(diff)}`, `Change ÷ |original| = ${dec(diff)} ÷ ${dec(R.qabs(oldV))} = ${dec(rel)}`, `× 100 = ${dec(R.mul(rel, H))}%`],
        });
    },

    increase: (i, c) => {
        const dir = c.direction === 'decrease' ? -1 : 1;
        const word = dir > 0 ? 'increase' : 'decrease';
        const mode = i.mode ?? 'find';

        if (mode === 'apply') {
            const v = qs(i.a, i.p);

            if (!v) {
                return need(`Enter the value and the percentage ${word}.`);
            }

            const [a, p] = v;
            const factor = R.add(R.ONE, R.mul(R.Q(dir), ofPct(p)));
            const r = R.mul(a, factor);

            return result(dec(r), `After a ${dec(p)}% ${word}`, { sub: `${dec(a)} ${dir > 0 ? '+' : '−'} ${dec(R.mul(a, ofPct(p)))}`, rows: { diff: `${dir > 0 ? '+' : '−'}${dec(R.mul(a, ofPct(p)))}`, factor: `× ${dec(factor)}`, formula: `${dec(a)} × (1 ${dir > 0 ? '+' : '−'} ${dec(p)}/100)` }, steps: [`${dec(p)}% of ${dec(a)} = ${dec(R.mul(a, ofPct(p)))}`, `${dec(a)} ${dir > 0 ? '+' : '−'} ${dec(R.mul(a, ofPct(p)))} = ${dec(r)}`] });
        }

        const v = qs(i.a, i.b);

        if (!v) {
            return need('Enter the original and the new value.');
        }

        const [a, b] = v;

        if (R.isZero(a)) {
            return fail('The original value cannot be zero.');
        }

        const diff = R.mul(R.sub(b, a), R.Q(dir));
        const p = R.mul(R.div(diff, R.qabs(a)), H);
        const wrongWay = R.sign(diff) < 0;

        return result(`${dec(p)}%`, `Percentage ${word}`, { sub: wrongWay ? `The value went the other way: a ${dir > 0 ? 'decrease' : 'increase'} of ${dec(R.neg(p))}%` : `${dec(R.qabs(diff))} on ${dec(a)}`, rows: { diff: dec(R.sub(b, a)), factor: `× ${dec(R.div(b, a))}`, formula: dir > 0 ? `(${dec(b)} − ${dec(a)}) ÷ ${dec(a)} × 100` : `(${dec(a)} − ${dec(b)}) ÷ ${dec(a)} × 100` }, steps: [`Difference = ${dec(R.qabs(R.sub(b, a)))}`, `÷ ${dec(R.qabs(a))} × 100 = ${dec(R.qabs(p))}%`] });
    },

    difference: (i) => {
        const v = qs(i.a, i.b);

        if (!v) {
            return need('Enter both values.');
        }

        const [a, b] = v;
        const mean = R.div(R.add(a, b), R.Q(2));

        if (R.isZero(mean)) {
            return fail('The average of the two values is zero, so the percentage difference is undefined.');
        }

        const d = R.mul(R.div(R.qabs(R.sub(a, b)), R.qabs(mean)), H);
        const ch = R.isZero(a) ? null : R.mul(R.div(R.sub(b, a), R.qabs(a)), H);

        return result(`${dec(d)}%`, 'Percentage difference', { sub: `|${dec(a)} − ${dec(b)}| ÷ ${dec(R.qabs(mean))}`, rows: { absolute: dec(R.qabs(R.sub(a, b))), mean: dec(mean), change: ch ? `${dec(ch)}% from the first to the second` : 'Undefined from zero', formula: '|a − b| ÷ ((a + b) ÷ 2) × 100' }, steps: [`|${dec(a)} − ${dec(b)}| = ${dec(R.qabs(R.sub(a, b)))}`, `Average = ${dec(mean)}`, `${dec(R.qabs(R.sub(a, b)))} ÷ ${dec(R.qabs(mean))} × 100 = ${dec(d)}%`] });
    },

    pct_of_pct: (i) => {
        const v = qs(i.a, i.b);

        if (!v) {
            return need('Enter both percentages.');
        }

        const [a, b] = v;
        const r = R.mul(R.mul(ofPct(a), ofPct(b)), H);
        const base = q(i.base);

        return result(`${dec(r)}%`, `${dec(a)}% of ${dec(b)}%`, { sub: base ? `${dec(r)}% of ${dec(base)} = ${dec(R.mul(ofPct(r), base))}` : 'Multiply the two as decimals', rows: { decimal: dec(ofPct(r)), ofBase: base ? dec(R.mul(ofPct(r), base)) : 'Add a number to apply it to', formula: `${dec(ofPct(a))} × ${dec(ofPct(b))} = ${dec(ofPct(r))}` }, steps: [`${dec(a)}% × ${dec(b)}% = ${dec(ofPct(a))} × ${dec(ofPct(b))}`, `= ${dec(ofPct(r))} = ${dec(r)}%`] });
    },

    points: (i) => {
        const v = qs(i.a, i.b);

        if (!v) {
            return need('Enter both percentages.');
        }

        const [a, b] = v;
        const pp = R.sub(b, a);
        const rel = R.isZero(a) ? null : R.mul(R.div(pp, R.qabs(a)), H);

        return result(`${R.sign(pp) > 0 ? '+' : ''}${dec(pp)} pp`, 'Change in percentage points', { sub: rel ? `A relative change of ${dec(rel)}%` : 'Relative change undefined from 0%', rows: { points: `${dec(pp)} percentage points`, relative: rel ? `${dec(rel)}%` : 'Undefined', note: 'Percentage points measure the gap between two percentages; percent measures it relative to the first' }, steps: [`${dec(b)}% − ${dec(a)}% = ${dec(pp)} percentage points`] });
    },

    error: (i) => {
        const v = qs(i.measured, i.actual);

        if (!v) {
            return need('Enter the measured and the true value.');
        }

        const [m, a] = v;

        if (R.isZero(a)) {
            return fail('The true value cannot be zero.');
        }

        const abs = R.qabs(R.sub(m, a));
        const rel = R.div(abs, R.qabs(a));

        return result(`${dec(R.mul(rel, H))}%`, 'Percent error', { sub: R.cmp(m, a) > 0 ? 'The measurement is too high' : R.cmp(m, a) < 0 ? 'The measurement is too low' : 'Exact', rows: { absolute: dec(abs), relative: dec(rel), formula: '|measured − true| ÷ |true| × 100' }, steps: [`|${dec(m)} − ${dec(a)}| = ${dec(abs)}`, `${dec(abs)} ÷ ${dec(R.qabs(a))} = ${dec(rel)}`, `× 100 = ${dec(R.mul(rel, H))}%`] });
    },

    average: (i) => {
        const lines = String(i.items ?? '').split('\n').map((l) => l.trim()).filter(Boolean);
        const rows = lines.map((l) => l.replace(/%/g, '').split(/[\s,;]+/).filter(Boolean).map((p) => R.parseNumber(p)));

        if (!rows.length || rows.some((r) => !r[0] || (r[1] === null && r.length > 1))) {
            return need('Enter one percentage per line, optionally followed by its sample size (45, 200).');
        }

        const simple = R.div(rows.reduce((s, r) => R.add(s, r[0]), R.ZERO), R.Q(rows.length));
        const weighted = rows.every((r) => r[1]);
        const total = weighted ? rows.reduce((s, r) => R.add(s, r[1]), R.ZERO) : null;
        const w = weighted && !R.isZero(total) ? R.div(rows.reduce((s, r) => R.add(s, R.mul(r[0], r[1])), R.ZERO), total) : null;

        return result(`${dec(w ?? simple)}%`, w ? 'Weighted average percentage' : 'Average percentage', { sub: w ? `Simple average ${dec(simple)}% (ignores the sample sizes)` : 'Add sample sizes for the weighted average', rows: { simple: `${dec(simple)}%`, weighted: w ? `${dec(w)}%` : 'Needs a size on every line', count: String(rows.length) }, steps: w ? [`Σ(p × n) = ${dec(rows.reduce((s, r) => R.add(s, R.mul(r[0], r[1])), R.ZERO))}`, `Σn = ${dec(total)}`, `${dec(w)}%`] : [`(${rows.map((r) => dec(r[0])).join(' + ')}) ÷ ${rows.length} = ${dec(simple)}%`] });
    },

    to_percent: (i, c) => {
        const x = q(i.value);

        if (!x) {
            return need(c.from === 'fraction' ? 'Enter a fraction such as 3/8 or 1 1/4.' : 'Enter a decimal such as 0.375.');
        }

        const p = R.mul(x, H);

        return result(`${dec(p)}%`, 'As a percentage', { sub: `${c.from === 'fraction' ? t(x) : dec(x)} × 100`, rows: { fraction: t(x), decimal: dec(x), percent: `${dec(p)}%`, exact: R.isInt(p) || R.expand(p).terminates ? 'Exact' : `Repeating: ${R.toRepeating(p)}%` }, steps: [`${c.from === 'fraction' ? `${t(x)} = ${dec(x)}` : dec(x)}`, `× 100 = ${dec(p)}%`] });
    },

    pct_to_fraction: (i) => {
        const p = q(String(i.value ?? '').replace('%', ''));

        if (!p) {
            return need('Enter a percentage such as 37.5.');
        }

        const x = R.div(p, H);

        return result(t(x), `${dec(p)}% as a fraction`, { sub: `${dec(p)}/100 simplified`, rows: { mixed: R.toMixed(x), decimal: dec(x), gcf: `${t(R.mul(p, R.Q(p.d)))}/${100n * p.d} ÷ ${R.bgcd(p.n, 100n * p.d)} on top and bottom` }, steps: [`${dec(p)}% = ${dec(p)}/100`, p.d === 1n ? `= ${t(x)}` : `= ${t(R.mul(p, R.Q(p.d)))}/${100n * p.d} = ${t(x)}`] });
    },

    reverse: (i) => {
        const v = qs(i.final, i.p);

        if (!v) {
            return need('Enter the final value and the percentage.');
        }

        const [fin, p] = v;
        const dir = i.direction === 'decrease' ? -1 : 1;
        const factor = R.add(R.ONE, R.mul(R.Q(dir), R.div(p, H)));

        if (R.sign(factor) <= 0) {
            return fail('A decrease of 100% or more cannot be reversed.');
        }

        const orig = R.div(fin, factor);

        return result(dec(orig), 'Original value', { sub: `${dec(fin)} ÷ ${dec(factor)}`, rows: { change: `${dir > 0 ? '+' : '−'}${dec(R.qabs(R.sub(fin, orig)))}`, check: `${dec(orig)} × ${dec(factor)} = ${dec(fin)}`, fraction: t(orig) }, steps: [`Multiplier = 1 ${dir > 0 ? '+' : '−'} ${dec(p)}/100 = ${dec(factor)}`, `Original = ${dec(fin)} ÷ ${dec(factor)} = ${dec(orig)}`] });
    },

    goal: (i) => {
        const v = qs(i.current, i.goal);

        if (!v) {
            return need('Enter the current value and the goal.');
        }

        const start = q(i.start) ?? R.ZERO;
        const [cur, goal] = v;
        const span = R.sub(goal, start);

        if (R.isZero(span)) {
            return fail('The goal must differ from the starting value.');
        }

        const p = R.mul(R.div(R.sub(cur, start), span), H);

        return result(`${dec(p)}%`, 'Of the goal reached', { sub: R.cmp(p, H) >= 0 ? 'Goal reached' : `${dec(R.qabs(R.sub(goal, cur)))} still to go`, rows: { remaining: dec(R.qabs(R.sub(goal, cur))), remainingPct: `${dec(R.sub(H, p))}%`, formula: `(${dec(cur)} − ${dec(start)}) ÷ (${dec(goal)} − ${dec(start)}) × 100` }, steps: [`Progress = ${dec(R.sub(cur, start))}`, `Distance = ${dec(span)}`, `${dec(p)}%`] });
    },

    time: (i) => {
        const part = parseClock(i.part);
        const total = parseClock(i.total);

        if (!part || !total || R.isZero(total)) {
            return need('Enter both times as h:mm:ss, mm:ss or hours.');
        }

        const p = R.mul(R.div(part, total), H);

        return result(`${dec(p)}%`, 'Of the total time', { sub: `${clock(part)} of ${clock(total)}`, rows: { part: `${dec(part)} s`, total: `${dec(total)} s`, rest: clock(R.sub(total, part)) }, steps: [`${clock(part)} = ${dec(part)} s`, `${clock(total)} = ${dec(total)} s`, `${dec(part)} ÷ ${dec(total)} × 100 = ${dec(p)}%`] });
    },

    doubling: (i) => {
        if (i.mode === 'values') {
            const [a, b, n] = [i.start, i.end, i.periods].map(Number);

            if (!(a > 0 && b > 0 && n > 0) || a === b) {
                return need('Enter a positive start and end value (different) and the number of periods.');
            }

            const rate = (b / a) ** (1 / n) - 1;
            const td = Math.log(2) / Math.log(1 + rate);

            return result(`${f(td, 6)} periods`, 'Doubling time', { sub: `Growth of ${f(rate * 100, 6)}% per period`, rows: { rate: `${f(rate * 100, 8)}% per period`, rule70: `${f(70 / (rate * 100), 4)} periods`, rule72: `${f(72 / (rate * 100), 4)} periods`, formula: 'T = ln 2 ÷ ln(1 + r)' }, steps: [`r = (${f(b)} ÷ ${f(a)})^(1/${f(n)}) − 1 = ${f(rate, 8)}`, `T = ln 2 ÷ ln(1 + r) = ${f(td, 8)}`] });
        }

        const r = Number(i.rate) / 100;

        if (!Number.isFinite(r) || r <= 0) {
            return need('Enter a positive growth rate in percent.');
        }

        const continuous = i.compounding === 'continuous';
        const td = continuous ? Math.log(2) / r : Math.log(2) / Math.log(1 + r);

        return result(`${f(td, 6)} periods`, 'Doubling time', { sub: continuous ? 'Continuous growth: T = ln 2 ÷ r' : 'Compound growth: T = ln 2 ÷ ln(1 + r)', rows: { rate: `${f(r * 100, 8)}% per period`, rule70: `${f(70 / (r * 100), 4)} periods`, rule72: `${f(72 / (r * 100), 4)} periods`, formula: continuous ? 'T = ln 2 ÷ r' : 'T = ln 2 ÷ ln(1 + r)' }, steps: [`T = ${continuous ? `0.693147… ÷ ${f(r)}` : `0.693147… ÷ ln(${f(1 + r)})`} = ${f(td, 8)}`] });
    },

    slope: (i) => {
        let rise;
        let run;
        let angle;

        if (i.mode === 'angle') {
            angle = Number(i.angle);

            if (!Number.isFinite(angle) || angle <= -90 || angle >= 90) {
                return need('Enter an angle between −90° and 90°.');
            }

            const g = Math.tan((angle * Math.PI) / 180) * 100;

            return result(`${f(g, 8)}%`, 'Slope (grade)', { sub: `${f(angle)}° from horizontal`, rows: { angle: `${f(angle)}°`, ratio: g === 0 ? 'Flat' : `1 : ${f(100 / Math.abs(g), 6)}`, formula: 'grade = tan θ × 100' }, steps: [`tan ${f(angle)}° = ${f(g / 100, 10)}`, `× 100 = ${f(g, 8)}%`] });
        }

        if (i.mode === 'percent') {
            const g = Number(i.percent);

            if (!Number.isFinite(g)) {
                return need('Enter the slope in percent.');
            }

            angle = (Math.atan(g / 100) * 180) / Math.PI;

            return result(`${f(angle, 8)}°`, 'Angle from horizontal', { sub: `${f(g)}% grade`, rows: { angle: `${f(angle, 8)}°`, ratio: g === 0 ? 'Flat' : `1 : ${f(100 / Math.abs(g), 6)}`, formula: 'θ = arctan(grade ÷ 100)' }, steps: [`θ = arctan(${f(g / 100)}) = ${f(angle, 8)}°`] });
        }

        const v = qs(i.rise, i.run);

        if (!v || R.isZero(v[1])) {
            return need('Enter the rise and a non-zero run.');
        }

        [rise, run] = v;
        const g = R.mul(R.div(rise, run), H);
        angle = (Math.atan(R.toNumber(R.div(rise, run))) * 180) / Math.PI;

        return result(`${dec(g)}%`, 'Slope (grade)', { sub: `${dec(rise)} up for ${dec(run)} across`, rows: { angle: `${f(angle, 8)}°`, ratio: R.isZero(rise) ? 'Flat' : `1 : ${dec(R.qabs(R.div(run, rise)))}`, formula: 'grade = rise ÷ run × 100' }, steps: [`${dec(rise)} ÷ ${dec(run)} = ${dec(R.div(rise, run))}`, `× 100 = ${dec(g)}%`, `θ = arctan(${dec(R.div(rise, run))}) = ${f(angle, 8)}°`] });
    },
};

export default defineTools(handlers);
export { both, pct };
