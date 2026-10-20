import { evalExact, parse, ParseError, variables } from './expr.js';
import * as R from './rational.js';

/**
 * Sets and logic: finite sets typed as lists, real intervals (unions of intervals with open or closed ends),
 * inequalities in one variable turned into intervals, and truth tables for logic expressions.
 */
export function parseSet(text) {
    const body = String(text ?? '').trim().replace(/^\{|\}$/g, '');

    if (!body.trim()) {
        return [];
    }

    const seen = new Set();

    return body.split(/[,;]/).map((s) => s.trim()).filter(Boolean).filter((s) => !seen.has(s) && seen.add(s));
}

export const setText = (items) => `{${items.join(', ')}}`;

/** Sort numerically when every element is a number. */
export function sortSet(items) {
    const nums = items.map((s) => R.parseNumber(s));

    return nums.every(Boolean) ? items.map((s, i) => [s, nums[i]]).sort((a, b) => R.cmp(a[1], b[1])).map(([s]) => s) : [...items].sort();
}

// Intervals ------------------------------------------------------------------------------------
// An interval: { lo, hi, loOpen, hiOpen } with lo/hi rationals or ±Infinity markers (null = infinite).

export const INF = null;

function lt(a, b) {
    // Compare endpoint values (null on the left means −∞, handled by callers).
    return R.cmp(a, b) < 0;
}

export function normalise(intervals) {
    const list = intervals.filter((i) => i.lo === INF || i.hi === INF || R.cmp(i.lo, i.hi) < 0 || (R.eq(i.lo, i.hi) && !i.loOpen && !i.hiOpen))
        .sort((a, b) => (a.lo === INF ? -1 : b.lo === INF ? 1 : R.cmp(a.lo, b.lo) || (a.loOpen ? 1 : 0) - (b.loOpen ? 1 : 0)));
    const out = [];

    for (const iv of list) {
        const last = out[out.length - 1];

        if (last && (last.hi === INF || (iv.lo !== INF && (lt(iv.lo, last.hi) || (R.eq(iv.lo, last.hi) && !(last.hiOpen && iv.loOpen)))))) {
            if (last.hi !== INF && (iv.hi === INF || lt(last.hi, iv.hi) || (R.eq(last.hi, iv.hi) && last.hiOpen))) {
                last.hi = iv.hi;
                last.hiOpen = iv.hiOpen;
            }
        } else {
            out.push({ ...iv });
        }
    }

    return out;
}

export function complement(intervals) {
    const list = normalise(intervals);
    const out = [];
    let lo = INF;
    let loOpen = true;
    let fromStart = true;

    for (const iv of list) {
        if (iv.lo !== INF) {
            out.push({ lo: fromStart ? INF : lo, hi: iv.lo, loOpen: fromStart ? true : loOpen, hiOpen: !iv.loOpen });
        }

        fromStart = false;
        lo = iv.hi;
        loOpen = !iv.hiOpen;

        if (iv.hi === INF) {
            return normalise(out);
        }
    }

    out.push({ lo: fromStart ? INF : lo, hi: INF, loOpen: fromStart ? true : loOpen, hiOpen: true });

    return normalise(out);
}

export const union = (a, b) => normalise([...a, ...b]);
export const intersect = (a, b) => complement(union(complement(a), complement(b)));

export function intervalText(intervals) {
    const list = normalise(intervals);

    if (!list.length) {
        return '∅';
    }

    return list.map((i) => (i.lo !== INF && i.hi !== INF && R.eq(i.lo, i.hi) ? `{${R.toFraction(i.lo)}}` : `${i.loOpen || i.lo === INF ? '(' : '['}${i.lo === INF ? '−∞' : R.toFraction(i.lo)}, ${i.hi === INF ? '∞' : R.toFraction(i.hi)}${i.hiOpen || i.hi === INF ? ')' : ']'}`)).join(' ∪ ');
}

export function setBuilderText(intervals, v = 'x') {
    const list = normalise(intervals);

    if (!list.length) {
        return '∅';
    }

    const one = (i) => {
        if (i.lo === INF && i.hi === INF) {
            return `${v} ∈ ℝ`;
        }

        if (i.lo === INF) {
            return `${v} ${i.hiOpen ? '<' : '≤'} ${R.toFraction(i.hi)}`;
        }

        if (i.hi === INF) {
            return `${v} ${i.loOpen ? '>' : '≥'} ${R.toFraction(i.lo)}`;
        }

        if (R.eq(i.lo, i.hi)) {
            return `${v} = ${R.toFraction(i.lo)}`;
        }

        return `${R.toFraction(i.lo)} ${i.loOpen ? '<' : '≤'} ${v} ${i.hiOpen ? '<' : '≤'} ${R.toFraction(i.hi)}`;
    };

    return `{${v} | ${list.map(one).join(' or ')}}`;
}

/** Plot data for the number line component. */
export function numberLine(intervals) {
    return {
        kind: 'numberline',
        intervals: normalise(intervals).map((i) => ({ from: i.lo === INF ? -Infinity : R.toNumber(i.lo), to: i.hi === INF ? Infinity : R.toNumber(i.hi), fromOpen: i.loOpen, toOpen: i.hiOpen })),
    };
}

/** Parses interval notation "(−∞, 3] ∪ [5, 7)" and "{4}". */
export function parseIntervals(text) {
    const s = String(text ?? '').replace(/\s+/g, '').replace(/[−–]/g, '-').replace(/inf(inity)?|∞/gi, '∞').replace(/U/g, '∪');
    const parts = s.split('∪').filter(Boolean);
    const out = [];

    for (const p of parts) {
        let m = p.match(/^([[(])(-?∞|[^,]+),(\+?∞|-?∞|[^\])]+)([\])])$/);

        if (m) {
            const lo = m[2].includes('∞') ? INF : R.parseNumber(m[2]);
            const hi = m[3].includes('∞') ? INF : R.parseNumber(m[3]);

            if ((m[2].includes('∞') && !m[2].startsWith('-')) || (m[3].includes('∞') && m[3].startsWith('-'))) {
                return null;
            }

            if ((lo === null && !m[2].includes('∞')) || (hi === null && !m[3].includes('∞'))) {
                return null;
            }

            out.push({ lo, hi, loOpen: m[1] === '(' || lo === INF, hiOpen: m[4] === ')' || hi === INF });
            continue;
        }

        m = p.match(/^\{([^}]+)\}$/);

        if (m) {
            const pts = m[1].split(',').map((x) => R.parseNumber(x));

            if (pts.some((x) => !x)) {
                return null;
            }

            pts.forEach((x) => out.push({ lo: x, hi: x, loOpen: false, hiOpen: false }));
            continue;
        }

        return null;
    }

    return normalise(out);
}

/**
 * Linear inequality or chain in one variable (2x + 3 < 7, −1 ≤ x − 2 < 4, x ≠ 3) to intervals.
 * Each side must be linear in the variable; returns { intervals, variable, steps } or { error }.
 */
export function solveLinearInequality(text) {
    let tree;

    try {
        tree = parse(String(text).replace(/≥/g, '>=').replace(/≤/g, '<='));
    } catch (e) {
        return { error: e instanceof ParseError ? e.message : 'Could not read the inequality.' };
    }

    if (tree.t !== 'rel') {
        return { error: 'Type an inequality such as 2x + 3 < 7.' };
    }

    const vars = [...variables(tree)];

    if (vars.length !== 1) {
        return { error: 'Use exactly one variable, such as x.' };
    }

    const v = vars[0];
    const linear = (node) => {
        // a·v + b with exact a, b: evaluate at v = 0 and v = 1.
        const b = evalExact(node, { [v]: R.ZERO });
        const one = evalExact(node, { [v]: R.ONE });
        const two = evalExact(node, { [v]: R.Q(2) });

        if (!b || !one || !two) {
            return null;
        }

        const a = R.sub(one, b);

        return R.eq(R.sub(two, one), a) ? { a, b } : null;
    };
    let result = [{ lo: INF, hi: INF, loOpen: true, hiOpen: true }];
    const steps = [];

    for (let k = 0; k < tree.ops.length; k += 1) {
        const left = linear(tree.parts[k]);
        const right = linear(tree.parts[k + 1]);

        if (!left || !right) {
            return { error: 'Each side must be linear in the variable (use the quadratic inequality tool for x²).' };
        }

        // (aL − aR)·v ⋈ bR − bL
        const a = R.sub(left.a, right.a);
        const c = R.sub(right.b, left.b);
        let op = tree.ops[k];
        let set;

        if (R.isZero(a)) {
            const truth = { '<': R.cmp(R.ZERO, c) < 0, '≤': R.cmp(R.ZERO, c) <= 0, '>': R.cmp(R.ZERO, c) > 0, '≥': R.cmp(R.ZERO, c) >= 0, '=': R.isZero(c), '≠': !R.isZero(c) }[op];
            set = truth ? [{ lo: INF, hi: INF, loOpen: true, hiOpen: true }] : [];
            steps.push(`0 ${op} ${R.toFraction(c)} is ${truth ? 'always true' : 'never true'}`);
        } else {
            const x = R.div(c, a);

            if (R.sign(a) < 0) {
                op = { '<': '>', '>': '<', '≤': '≥', '≥': '≤', '=': '=', '≠': '≠' }[op];
            }

            steps.push(`${R.toFraction(a)}${v} ${tree.ops[k]} ${R.toFraction(c)}  →  ${v} ${op} ${R.toFraction(x)}${R.sign(a) < 0 ? ' (dividing by a negative flips the sign)' : ''}`);
            set = {
                '<': [{ lo: INF, hi: x, loOpen: true, hiOpen: true }],
                '≤': [{ lo: INF, hi: x, loOpen: true, hiOpen: false }],
                '>': [{ lo: x, hi: INF, loOpen: true, hiOpen: true }],
                '≥': [{ lo: x, hi: INF, loOpen: false, hiOpen: true }],
                '=': [{ lo: x, hi: x, loOpen: false, hiOpen: false }],
                '≠': [{ lo: INF, hi: x, loOpen: true, hiOpen: true }, { lo: x, hi: INF, loOpen: true, hiOpen: true }],
            }[op];
        }

        result = intersect(result, set);
    }

    return { intervals: normalise(result), variable: v, steps };
}

// Logic --------------------------------------------------------------------------------------

/** Parses and; or; not; xor; nand; nor; → (implies, ->); ↔ (iff, <->) with letters as variables. */
export function parseLogic(text) {
    const s = String(text ?? '')
        .replace(/<->|<=>|↔|⇔|\biff\b/gi, ' ⇔ ').replace(/->|=>|→|⇒|\bimplies\b/gi, ' ⇒ ')
        .replace(/&&|∧|\band\b|&|·/gi, ' ∧ ').replace(/\|\||∨|\bor\b|\||\+/gi, ' ∨ ')
        .replace(/⊕|\bxor\b|\^/gi, ' ⊕ ').replace(/\bnand\b|↑/gi, ' ↑ ').replace(/\bnor\b|↓/gi, ' ↓ ')
        .replace(/¬|!|~|\bnot\b/gi, ' ¬ ');
    const tokens = s.match(/[A-Za-z]\w*|[()¬∧∨⊕↑↓⇒⇔]|[01]|\S/g) ?? [];
    let pos = 0;
    const vars = [];
    const peek = () => tokens[pos];

    const atom = () => {
        const t = tokens[pos++];

        if (t === '(') {
            const e = iff();

            if (tokens[pos++] !== ')') {
                throw new ParseError('Missing )');
            }

            return e;
        }

        if (t === '¬') {
            return { op: '¬', a: atom() };
        }

        if (t === '0' || t === '1') {
            return { val: t === '1' };
        }

        if (t && /^[A-Za-z]\w*$/.test(t)) {
            if (!vars.includes(t)) {
                vars.push(t);
            }

            return { v: t };
        }

        throw new ParseError(t ? `Unexpected “${t}”` : 'The expression ends too early');
    };
    const level = (ops, nextFn) => () => {
        let e = nextFn();

        while (ops.includes(peek())) {
            const op = tokens[pos++];
            e = { op, a: e, b: nextFn() };
        }

        return e;
    };
    const and = level(['∧', '↑'], atom);
    const xor = level(['⊕'], and);
    const or = level(['∨', '↓'], xor);
    const imp = () => {
        const a = or();

        if (peek() === '⇒') {
            pos += 1;

            return { op: '⇒', a, b: imp() };
        }

        return a;
    };
    const iff = level(['⇔'], imp);
    const tree = iff();

    if (pos < tokens.length) {
        throw new ParseError(`Unexpected “${tokens[pos]}”`);
    }

    return { tree, vars: vars.sort() };
}

export function evalLogic(node, env) {
    if ('val' in node) {
        return node.val;
    }

    if (node.v) {
        return env[node.v];
    }

    const a = evalLogic(node.a, env);

    if (node.op === '¬') {
        return !a;
    }

    const b = evalLogic(node.b, env);

    return { '∧': a && b, '∨': a || b, '⊕': a !== b, '↑': !(a && b), '↓': !(a || b), '⇒': !a || b, '⇔': a === b }[node.op];
}

export function logicText(node) {
    if ('val' in node) {
        return node.val ? '1' : '0';
    }

    if (node.v) {
        return node.v;
    }

    if (node.op === '¬') {
        return `¬${node.a.v || 'val' in node.a ? logicText(node.a) : `(${logicText(node.a)})`}`;
    }

    const side = (n) => (n.op && n.op !== '¬' ? `(${logicText(n)})` : logicText(n));

    return `${side(node.a)} ${node.op} ${side(node.b)}`;
}
