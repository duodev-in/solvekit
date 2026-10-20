import * as R from './rational.js';

/**
 * Safe maths expression parser (no eval): numbers, fractions, variables, π, e, i, + − × ÷ ^, implicit
 * multiplication (2x, 3(x + 1), (x)(y)), |absolute value|, n!, functions and relations (=, <, ≤ …).
 * The tree can be evaluated exactly (rationals), as a double, as a complex number, or turned into a polynomial.
 */
export const FUNCTIONS = ['sqrt', 'cbrt', 'root', 'abs', 'exp', 'ln', 'log', 'log2', 'log10', 'sin', 'cos', 'tan', 'sec', 'csc', 'cot', 'asin', 'acos', 'atan', 'arcsin', 'arccos', 'arctan',
    'sinh', 'cosh', 'tanh', 'asinh', 'acosh', 'atanh', 'floor', 'ceil', 'round', 'sign', 'min', 'max', 'gcd', 'lcm', 'mod'];
const CONSTANTS = { pi: 'π', 'π': 'π', e: 'e', i: 'i', tau: 'τ', 'τ': 'τ', phi: 'φ', 'φ': 'φ' };
const REL = ['<=', '>=', '!=', '≤', '≥', '≠', '<', '>', '='];

export class ParseError extends Error {}

export function tokenize(text) {
    const s = String(text ?? '').replace(/[−–]/g, '-').replace(/[×·∙⋅]/g, '*').replace(/÷/g, '/').replace(/\*\*/g, '^').replace(/√/g, 'sqrt').replace(/∛/g, 'cbrt')
        .replace(/[²³⁴⁵⁶⁷⁸⁹¹⁰]+/g, (m) => `^${m.split('').map((c) => '⁰¹²³⁴⁵⁶⁷⁸⁹'.indexOf(c)).join('')}`);
    const tokens = [];
    let k = 0;

    while (k < s.length) {
        const c = s[k];

        if (/\s/.test(c)) {
            k += 1;
            continue;
        }

        const rel = REL.find((r) => s.startsWith(r, k));

        if (rel) {
            tokens.push({ t: 'rel', v: { '<=': '≤', '>=': '≥', '!=': '≠' }[rel] ?? rel });
            k += rel.length;
            continue;
        }

        // Mixed numbers: "2 1/3" is one number (two and a third), not 2 × 1/3.
        const mixedNum = s.slice(k).match(/^(\d+)\s+(\d+)\/(\d+)(?![\d.])/);

        if (mixedNum && (k === 0 || !/[\d.]/.test(s[k - 1]))) {
            tokens.push({ t: 'num', v: R.parseNumber(mixedNum[0]) });
            k += mixedNum[0].length;
            continue;
        }

        const num = s.slice(k).match(/^(\d+\.?\d*|\.\d+)(e[+-]?\d+)?/i);

        if (num && !(num[2] && /^e[a-z]/i.test(s.slice(k + num[1].length)))) {
            const text = num[2] && /^e/i.test(num[2]) && !/^e[+-]?\d/i.test(num[2]) ? num[1] : num[0];
            tokens.push({ t: 'num', v: R.parseNumber(text) });
            k += text.length;
            continue;
        }

        const id = s.slice(k).match(/^[a-zA-Zπτφα-ωθ_]+/);

        if (id) {
            tokens.push({ t: 'id', v: id[0] });
            k += id[0].length;
            continue;
        }

        if ('+-*/^()[]{},|!%'.includes(c)) {
            tokens.push({ t: c });
            k += 1;
            continue;
        }

        throw new ParseError(`Unexpected “${c}”`);
    }

    return tokens;
}

/** Splits identifiers like "xy" or "2pix" into known functions, constants and single-letter variables. */
function splitIdentifier(word) {
    const lower = word.toLowerCase();

    if (FUNCTIONS.includes(lower) || CONSTANTS[lower] || CONSTANTS[word]) {
        return [word];
    }

    const parts = [];
    let rest = word;

    while (rest) {
        const fn = [...FUNCTIONS, 'pi', 'tau', 'phi'].sort((a, b) => b.length - a.length).find((f) => rest.toLowerCase().startsWith(f));

        if (fn) {
            parts.push(rest.slice(0, fn.length));
            rest = rest.slice(fn.length);
        } else {
            parts.push(rest[0]);
            rest = rest.slice(1);
        }
    }

    return parts;
}

export function parse(text) {
    const raw = tokenize(text);
    const tokens = raw.flatMap((tok) => (tok.t === 'id' ? splitIdentifier(tok.v).map((v) => ({ t: 'id', v })) : [tok]));
    let pos = 0;
    const peek = () => tokens[pos];
    const next = () => tokens[pos++];
    const expect = (t) => {
        if (peek()?.t !== t) {
            throw new ParseError(`Expected “${t}”`);
        }

        return next();
    };
    let absDepth = 0;
    const startsOperand = (tok) => tok && (tok.t === 'num' || tok.t === 'id' || tok.t === '(' || tok.t === '[' || tok.t === '{' || (tok.t === '|' && absDepth === 0));

    function primary() {
        const tok = next();

        if (!tok) {
            throw new ParseError('The expression ends too early');
        }

        if (tok.t === 'num') {
            return { t: 'num', v: tok.v };
        }

        if (tok.t === '(' || tok.t === '[' || tok.t === '{') {
            const close = { '(': ')', '[': ']', '{': '}' }[tok.t];
            const e = expression();
            expect(close);

            return e;
        }

        if (tok.t === '|') {
            absDepth += 1;
            const e = expression();
            absDepth -= 1;
            expect('|');

            return { t: 'call', fn: 'abs', args: [e] };
        }

        if (tok.t === 'id') {
            const lower = tok.v.toLowerCase();

            if (FUNCTIONS.includes(lower)) {
                const fn = { arcsin: 'asin', arccos: 'acos', arctan: 'atan' }[lower] ?? lower;

                if (peek()?.t === '(') {
                    next();
                    const args = [expression()];

                    while (peek()?.t === ',') {
                        next();
                        args.push(expression());
                    }

                    expect(')');

                    return { t: 'call', fn, args };
                }

                // sin x, ln 2: the argument binds tighter than + and ×, like a power.
                return { t: 'call', fn, args: [power()] };
            }

            if (CONSTANTS[lower] || CONSTANTS[tok.v]) {
                return { t: 'const', name: CONSTANTS[lower] ?? CONSTANTS[tok.v] };
            }

            return { t: 'var', name: tok.v };
        }

        if (tok.t === '-') {
            return { t: 'neg', a: power() };
        }

        if (tok.t === '+') {
            return power();
        }

        throw new ParseError(`Unexpected “${tok.t === 'rel' ? tok.v : tok.t}”`);
    }

    function postfix() {
        let e = primary();

        while (peek()?.t === '!' || peek()?.t === '%') {
            const op = next().t;
            e = op === '!' ? { t: 'fact', a: e } : { t: 'bin', op: '/', a: e, b: { t: 'num', v: R.Q(100) } };
        }

        return e;
    }

    function power() {
        const base = postfix();

        if (peek()?.t === '^') {
            next();
            const exponent = peek()?.t === '-' ? (next(), { t: 'neg', a: power() }) : power();

            return { t: 'bin', op: '^', a: base, b: exponent };
        }

        return base;
    }

    function unary() {
        if (peek()?.t === '-') {
            next();

            return { t: 'neg', a: unary() };
        }

        if (peek()?.t === '+') {
            next();

            return unary();
        }

        return power();
    }

    function term() {
        let e = unary();

        while (true) {
            const tok = peek();

            if (tok?.t === '*' || tok?.t === '/') {
                next();
                e = { t: 'bin', op: tok.t, a: e, b: unary() };
            } else if (startsOperand(tok)) {
                e = { t: 'bin', op: '*', a: e, b: power(), implicit: true };
            } else {
                return e;
            }
        }
    }

    function expression() {
        let e = term();

        while (peek()?.t === '+' || peek()?.t === '-') {
            const op = next().t;
            e = { t: 'bin', op, a: e, b: term() };
        }

        return e;
    }

    const first = expression();
    const parts = [first];
    const ops = [];

    while (peek()?.t === 'rel') {
        ops.push(next().v);
        parts.push(expression());
    }

    if (pos < tokens.length) {
        throw new ParseError(`Unexpected “${peek().t === 'num' ? R.toFraction(peek().v) : peek().v ?? peek().t}”`);
    }

    return ops.length ? { t: 'rel', ops, parts } : first;
}

export function variables(node, out = new Set()) {
    if (!node) {
        return out;
    }

    if (node.t === 'var') {
        out.add(node.name);
    }

    ['a', 'b'].forEach((k) => node[k] && variables(node[k], out));
    (node.args ?? []).forEach((a) => variables(a, out));
    (node.parts ?? []).forEach((a) => variables(a, out));

    return out;
}

const CONST_VALUE = { 'π': Math.PI, e: Math.E, 'τ': 2 * Math.PI, 'φ': (1 + Math.sqrt(5)) / 2 };

/** Exact value as a rational, or null when the expression is not rational (roots, π, functions …). */
export function evalExact(node, vars = {}) {
    switch (node.t) {
        case 'num': return node.v;
        case 'var': return vars[node.name] && R.isQ(vars[node.name]) ? vars[node.name] : null;
        case 'neg': {
            const a = evalExact(node.a, vars);

            return a && R.neg(a);
        }
        case 'fact': {
            const a = evalExact(node.a, vars);

            if (!a || !R.isInt(a) || a.n < 0n || a.n > 5000n) {
                return null;
            }

            let r = 1n;

            for (let k = 2n; k <= a.n; k += 1n) {
                r *= k;
            }

            return R.Q(r);
        }
        case 'call': {
            if (node.fn === 'abs') {
                const a = evalExact(node.args[0], vars);

                return a && R.qabs(a);
            }

            if (node.fn === 'sqrt' || node.fn === 'cbrt') {
                const a = evalExact(node.args[0], vars);
                const k = node.fn === 'sqrt' ? 2 : 3;

                return a ? exactRoot(a, k) : null;
            }

            return null;
        }
        case 'bin': {
            const a = evalExact(node.a, vars);
            const b = evalExact(node.b, vars);

            if (!a || !b) {
                return null;
            }

            switch (node.op) {
                case '+': return R.add(a, b);
                case '-': return R.sub(a, b);
                case '*': return R.mul(a, b);
                case '/': return R.isZero(b) ? null : R.div(a, b);
                case '^': {
                    if (R.isInt(b) && R.babs(b.n) <= 4000n && !(R.isZero(a) && b.n < 0n)) {
                        return R.pow(a, b.n);
                    }

                    if (b.d <= 12n && a.n >= 0n) {
                        const root = exactRoot(a, Number(b.d));

                        return root ? R.pow(root, b.n) : null;
                    }

                    return null;
                }
                default: return null;
            }
        }
        default: return null;
    }
}

/** Exact k-th root of a rational when it is rational. */
export function exactRoot(a, k) {
    const kk = BigInt(k);

    if (a.n < 0n && k % 2 === 0) {
        return null;
    }

    const root = (x) => {
        let r = BigInt(Math.round(Number(x) ** (1 / k)));

        for (const c of [r - 1n, r, r + 1n]) {
            if (c >= 0n && c ** kk === x) {
                return c;
            }
        }

        // Large values: Newton on BigInt.
        if (x > 2n ** 50n) {
            let y = 1n << (BigInt(x.toString(2).length) / kk + 1n);

            while (true) {
                const z = ((kk - 1n) * y + x / y ** (kk - 1n)) / kk;

                if (z >= y) {
                    break;
                }

                y = z;
            }

            return y ** kk === x ? y : null;
        }

        return null;
    };
    const n = root(R.babs(a.n));
    const d = root(a.d);

    return n !== null && d !== null ? R.Q(a.n < 0n ? -n : n, d) : null;
}

const fact = (n) => {
    if (!Number.isInteger(n) || n < 0) {
        return NaN;
    }

    let r = 1;

    for (let k = 2; k <= n; k += 1) {
        r *= k;
    }

    return r;
};

/** Double-precision value; angles in radians unless options.degrees. */
export function evalReal(node, vars = {}, options = {}) {
    const toRad = options.degrees ? Math.PI / 180 : 1;
    const ev = (n) => evalReal(n, vars, options);

    switch (node.t) {
        case 'num': return R.toNumber(node.v);
        case 'const': return node.name === 'i' ? NaN : CONST_VALUE[node.name];
        case 'var': {
            const v = vars[node.name];

            return v === undefined ? NaN : R.isQ(v) ? R.toNumber(v) : v;
        }
        case 'neg': return -ev(node.a);
        case 'fact': return fact(ev(node.a));
        case 'bin': {
            const a = ev(node.a);
            const b = ev(node.b);

            switch (node.op) {
                case '+': return a + b;
                case '-': return a - b;
                case '*': return a * b;
                case '/': return a / b;
                case '^': {
                    // Odd roots of negatives: (−8)^(1/3) = −2.
                    if (a < 0 && !Number.isInteger(b)) {
                        const q = node.b.t === 'num' ? node.b.v : evalExact(node.b, vars);

                        if (q && q.d % 2n === 1n) {
                            return -((-a) ** b);
                        }
                    }

                    return a ** b;
                }
                default: return NaN;
            }
        }
        case 'call': {
            const x = node.args.map(ev);
            const [u, w] = x;

            switch (node.fn) {
                case 'sqrt': return Math.sqrt(u);
                case 'cbrt': return Math.cbrt(u);
                case 'root': return u < 0 && w % 2 === 1 ? -((-u) ** (1 / w)) : u ** (1 / w);
                case 'abs': return Math.abs(u);
                case 'exp': return Math.exp(u);
                case 'ln': return Math.log(u);
                case 'log': return x.length > 1 ? Math.log(u) / Math.log(w) : Math.log10(u);
                case 'log2': return Math.log2(u);
                case 'log10': return Math.log10(u);
                case 'sin': return Math.sin(u * toRad);
                case 'cos': return Math.cos(u * toRad);
                case 'tan': return Math.tan(u * toRad);
                case 'sec': return 1 / Math.cos(u * toRad);
                case 'csc': return 1 / Math.sin(u * toRad);
                case 'cot': return 1 / Math.tan(u * toRad);
                case 'asin': return Math.asin(u) / toRad;
                case 'acos': return Math.acos(u) / toRad;
                case 'atan': return Math.atan(u) / toRad;
                case 'sinh': return Math.sinh(u);
                case 'cosh': return Math.cosh(u);
                case 'tanh': return Math.tanh(u);
                case 'asinh': return Math.asinh(u);
                case 'acosh': return Math.acosh(u);
                case 'atanh': return Math.atanh(u);
                case 'floor': return Math.floor(u);
                case 'ceil': return Math.ceil(u);
                case 'round': return Math.round(u);
                case 'sign': return Math.sign(u);
                case 'min': return Math.min(...x);
                case 'max': return Math.max(...x);
                case 'mod': return ((u % w) + w) % w;
                default: return NaN;
            }
        }
        default: return NaN;
    }
}

/** A one-variable function f(x) from an expression (for graphs and numeric methods). */
export function compile(text, variable = 'x', options = {}) {
    const tree = parse(text);

    return (value) => evalReal(tree, { [variable]: value }, options);
}

/**
 * Polynomial in one variable as rational coefficients [c0, c1, …], or null when the expression is not a
 * polynomial (variable in a denominator, fractional power …). Other variables are not allowed.
 */
export function toPoly(node, variable = 'x') {
    const P = (c) => [c];
    const addP = (a, b) => Array.from({ length: Math.max(a.length, b.length) }, (_, k) => R.add(a[k] ?? R.ZERO, b[k] ?? R.ZERO));
    const mulP = (a, b) => {
        const out = Array.from({ length: a.length + b.length - 1 }, () => R.ZERO);
        a.forEach((x, i) => b.forEach((y, j) => {
            out[i + j] = R.add(out[i + j], R.mul(x, y));
        }));

        return out;
    };
    const go = (n) => {
        switch (n.t) {
            case 'num': return P(n.v);
            case 'var': return n.name === variable ? [R.ZERO, R.ONE] : null;
            case 'neg': {
                const a = go(n.a);

                return a && a.map(R.neg);
            }
            case 'bin': {
                const a = go(n.a);

                if (n.op === '^') {
                    const e = evalExact(n.b);

                    if (!a || !e || !R.isInt(e) || e.n < 0n || e.n > 60n) {
                        return null;
                    }

                    let r = P(R.ONE);

                    for (let k = 0n; k < e.n; k += 1n) {
                        r = mulP(r, a);
                    }

                    return r;
                }

                const b = go(n.b);

                if (!a || !b) {
                    return null;
                }

                if (n.op === '+') {
                    return addP(a, b);
                }

                if (n.op === '-') {
                    return addP(a, b.map(R.neg));
                }

                if (n.op === '*') {
                    return mulP(a, b);
                }

                if (n.op === '/') {
                    const nz = b.filter((c, k) => k > 0 && !R.isZero(c));

                    return nz.length || R.isZero(b[0]) ? null : a.map((c) => R.div(c, b[0]));
                }

                return null;
            }
            default: return null;
        }
    };
    const out = go(node);

    if (!out) {
        return null;
    }

    while (out.length > 1 && R.isZero(out[out.length - 1])) {
        out.pop();
    }

    return out;
}

/** Readable text for a tree (2*x^2 → 2x²). */
export function show(node, opts = {}) {
    const prec = { '+': 1, '-': 1, '*': 2, '/': 2, '^': 3 };
    const wrap = (child, parentPrec, right = false) => {
        const p = child.t === 'bin' ? prec[child.op] : child.t === 'neg' ? 1.5 : 9;
        const s = show(child, opts);

        return p < parentPrec || (right && p === parentPrec && child.t === 'bin') ? `(${s})` : s;
    };

    switch (node.t) {
        case 'num': return R.toFraction(node.v);
        case 'var': return node.name;
        case 'const': return node.name;
        case 'neg': return `−${wrap(node.a, 2)}`;
        case 'fact': return `${wrap(node.a, 9)}!`;
        case 'call': return node.fn === 'abs' ? `|${show(node.args[0], opts)}|` : node.fn === 'sqrt' ? `√(${show(node.args[0], opts)})` : `${node.fn}(${node.args.map((a) => show(a, opts)).join(', ')})`;
        case 'bin': {
            if (node.op === '^') {
                const e = node.b.t === 'num' && R.isInt(node.b.v) && node.b.v.n >= 0n ? R.sup(node.b.v.n) : `^${wrap(node.b, 4)}`;

                return `${wrap(node.a, 4)}${e}`;
            }

            if (node.op === '*') {
                const left = wrap(node.a, 2);
                const right = wrap(node.b, 2, true);
                const tight = node.implicit || (opts.tight !== false && /[\d)]$/.test(left) && /^[a-zπ(√]/i.test(right));

                return tight ? `${left}${right}` : `${left} × ${right}`;
            }

            if (opts.slash !== false && node.op === '/' && ['num', 'var', 'const'].includes(node.a.t) && ['num', 'var', 'const'].includes(node.b.t)) {
                return `${show(node.a, opts)}/${show(node.b, opts)}`;
            }

            return `${wrap(node.a, prec[node.op])} ${{ '-': '−', '/': '÷' }[node.op] ?? node.op} ${wrap(node.b, prec[node.op], true)}`;
        }
        case 'rel': return node.parts.map((p, k) => (k ? ` ${node.ops[k - 1]} ` : '') + show(p, opts)).join('');
        default: return '?';
    }
}
