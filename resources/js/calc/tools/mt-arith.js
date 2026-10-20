import { defineTools } from '../engines/formula.js';
import { evalExact, evalReal, parse, ParseError, show } from '../math/expr.js';
import * as N from '../math/numtheory.js';
import { dec, f, fail, need, q, R, result } from '../math/util.js';

/**
 * Arithmetic tools: exact operations on long numbers and decimals, written methods (long addition,
 * subtraction, multiplication and division, partial products) laid out column by column, order of
 * operations step by step, number properties, place value, magic squares, Polish notation and π experiments.
 */
const t = R.toFraction;

function list(text) {
    const items = String(text ?? '').split(/[\n,;]+|\s{2,}|\s(?=[+-]?\d)/).map((s) => s.trim()).filter(Boolean).map((s) => R.parseNumber(s));

    return items.length && items.every(Boolean) ? items : null;
}

/** Splits a non-negative decimal string into integer and fraction digits. */
function digitsOf(x, places) {
    const s = R.toDecimal(R.qabs(x), places, { keep: true });
    const [int, frac = ''] = s.split('.');

    return { int, frac };
}

function placesOf(values) {
    return Math.max(0, ...values.map((v) => {
        const p = R.decimalPlaces(v);

        return p === Infinity ? 6 : p;
    }));
}

function alignRows(values, places) {
    const parts = values.map((v) => digitsOf(v, places));
    const width = Math.max(...parts.map((p) => p.int.length));

    return parts.map((p) => p.int.padStart(width, ' ') + (places ? `.${p.frac}` : ''));
}

function longAdd(values) {
    const places = placesOf(values);
    const rows = alignRows(values, places);
    const total = values.reduce((a, b) => R.add(a, b), R.ZERO);
    const totalRow = alignRows([total], places)[0];
    const width = Math.max(totalRow.length, ...rows.map((r) => r.length)) + 2;
    // Carries from right to left.
    const digits = rows.map((r) => r.replace('.', '').padStart(width - 1, ' '));
    let carry = 0;
    const carries = Array(width - 1).fill(' ');
    const colSteps = [];

    for (let k = width - 2; k >= 0; k -= 1) {
        const sum = digits.reduce((s, r) => s + (r[k] === ' ' ? 0 : Number(r[k])), 0) + carry;

        if (sum === 0 && digits.every((r) => r[k] === ' ') && carry === 0) {
            continue;
        }

        colSteps.push(`Column ${width - 1 - k}: ${digits.map((r) => (r[k] === ' ' ? 0 : r[k])).join(' + ')}${carry ? ` + ${carry} (carry)` : ''} = ${sum} → write ${sum % 10}${sum >= 10 ? `, carry ${Math.floor(sum / 10)}` : ''}`);
        carry = Math.floor(sum / 10);

        if (k > 0 && carry) {
            carries[k - 1] = String(carry);
        }
    }

    const withPoint = (s) => (places ? `${s.slice(0, s.length - places)}.${s.slice(s.length - places)}` : s);
    const layout = [
        `  ${withPoint(carries.join('')).replace('.', ' ')}`,
        ...rows.map((r, k) => `${k === rows.length - 1 ? '+' : ' '} ${r.padStart(width - 1 + (places ? 1 : 0))}`),
        `  ${'─'.repeat(width - 1 + (places ? 1 : 0))}`,
        `  ${totalRow.padStart(width - 1 + (places ? 1 : 0))}`,
    ];

    return { total, layout, colSteps };
}

function longSub(a, b) {
    const places = placesOf([a, b]);
    const [ra, rb] = alignRows([a, b], places);
    const diff = R.sub(a, b);
    const width = Math.max(ra.length, rb.length);
    const top = ra.replace('.', '').padStart(width, ' ').split('').map((ch) => (ch === ' ' ? 0 : Number(ch)));
    const bottom = rb.replace('.', '').padStart(width, ' ').split('').map((ch) => (ch === ' ' ? 0 : Number(ch)));
    const steps = [];
    const work = [...top];
    const borrows = Array(work.length).fill(' ');

    for (let k = work.length - 1; k >= 0; k -= 1) {
        if (work[k] < bottom[k]) {
            let j = k - 1;

            while (j >= 0 && work[j] === 0) {
                work[j] = 9;
                borrows[j] = '9';
                j -= 1;
            }

            if (j >= 0) {
                work[j] -= 1;
                borrows[j] = String(work[j]);
            }

            work[k] += 10;
            steps.push(`Column ${work.length - k}: borrow → ${work[k]} − ${bottom[k]} = ${work[k] - bottom[k]}`);
        } else {
            steps.push(`Column ${work.length - k}: ${work[k]} − ${bottom[k]} = ${work[k] - bottom[k]}`);
        }
    }

    const fmtRow = (s) => (places ? `${s.slice(0, s.length - places)}.${s.slice(s.length - places)}` : s);
    const layout = [`  ${fmtRow(borrows.join(''))}`, `  ${ra.padStart(width + (places ? 1 : 0))}`, `− ${rb.padStart(width + (places ? 1 : 0))}`, `  ${'─'.repeat(width + (places ? 1 : 0))}`, `  ${alignRows([diff], places)[0].padStart(width + (places ? 1 : 0))}`];

    return { diff, layout, steps };
}

function longMultiply(a, b) {
    const pa = placesOf([a]);
    const pb = placesOf([b]);
    const ia = BigInt(R.toDecimal(R.qabs(a), pa, { keep: true }).replace('.', ''));
    const ib = BigInt(R.toDecimal(R.qabs(b), pb, { keep: true }).replace('.', ''));
    const product = ia * ib;
    const digitsB = ib.toString().split('').reverse();
    const partials = digitsB.map((d, k) => ia * BigInt(d) * 10n ** BigInt(k));
    const width = Math.max(product.toString().length, ia.toString().length, ib.toString().length + 2) + 2;
    const layout = [
        `  ${ia.toString().padStart(width)}`,
        `× ${ib.toString().padStart(width)}`,
        `  ${'─'.repeat(width)}`,
        ...partials.map((p) => `${partials.length > 1 ? '+ ' : '  '}${p.toString().padStart(width)}`),
        `  ${'─'.repeat(width)}`,
        `  ${product.toString().padStart(width)}`,
    ];
    const steps = digitsB.map((d, k) => `${ia} × ${d} = ${ia * BigInt(d)}${k ? `, shifted ${k} place${k === 1 ? '' : 's'} → ${partials[k]}` : ''}`);
    steps.push(`Add the rows: ${partials.join(' + ')} = ${product}`);

    if (pa + pb) {
        steps.push(`Place the decimal point ${pa + pb} digit${pa + pb === 1 ? '' : 's'} from the right`);
    }

    return { layout, steps };
}

function longDivide(a, b, places = 6) {
    // a, b positive integers (as BigInt); quotient digits with remainders.
    const s = a.toString();
    const steps = [];
    let rem = 0n;
    let qt = '';
    const lines = [];

    for (let k = 0; k < s.length; k += 1) {
        rem = rem * 10n + BigInt(s[k]);
        const d = rem / b;
        qt += d.toString();

        if (d > 0n || qt.replace(/^0+/, '')) {
            steps.push(`Bring down ${s[k]}: ${rem} ÷ ${b} = ${d}, ${d} × ${b} = ${d * b}, remainder ${rem - d * b}`);
            lines.push(`${' '.repeat(k + 2 - rem.toString().length)}${rem}`, `${' '.repeat(k + 1 - (d * b).toString().length)}−${d * b}`);
        }

        rem -= d * b;
    }

    let frac = '';

    for (let k = 0; k < places && rem !== 0n; k += 1) {
        rem *= 10n;
        const d = rem / b;
        steps.push(`Add a zero: ${rem} ÷ ${b} = ${d}, remainder ${rem - d * b}`);
        frac += d.toString();
        rem -= d * b;
    }

    const qInt = qt.replace(/^0+(?=\d)/, '');

    return { quotient: qInt + (frac ? `.${frac}` : ''), remainderInt: a % b, steps, layout: [`${' '.repeat(b.toString().length + 3 + s.length - qInt.length)}${qInt}`, `${b} ) ${a}`, ...lines.slice(0, 30).map((l) => `${' '.repeat(b.toString().length + 2)}${l}`)] };
}

/** One reduction step of an expression tree: the first operation (in reading order) whose operands are numbers. */
function reduceOnce(node) {
    const isNum = (n) => n.t === 'num';

    if (node.t === 'bin') {
        if (isNum(node.a) && isNum(node.b)) {
            const v = evalExact(node);

            return v ? { t: 'num', v } : null;
        }

        const a = isNum(node.a) ? null : reduceOnce(node.a);

        if (a) {
            return { ...node, a };
        }

        const b = isNum(node.b) ? null : reduceOnce(node.b);

        return b ? { ...node, b } : null;
    }

    if (node.t === 'neg') {
        if (isNum(node.a)) {
            return { t: 'num', v: R.neg(node.a.v) };
        }

        const a = reduceOnce(node.a);

        return a ? { ...node, a } : null;
    }

    if (node.t === 'fact' || node.t === 'call') {
        const args = node.t === 'fact' ? [node.a] : node.args;

        if (args.every(isNum)) {
            const v = evalExact(node);

            return v ? { t: 'num', v } : null;
        }

        for (let k = 0; k < args.length; k += 1) {
            if (!isNum(args[k])) {
                const r = reduceOnce(args[k]);

                if (r) {
                    return node.t === 'fact' ? { ...node, a: r } : { ...node, args: args.map((x, j) => (j === k ? r : x)) };
                }
            }
        }
    }

    return null;
}

function toPostfix(node) {
    switch (node.t) {
        case 'num': return [t(node.v)];
        case 'var': return [node.name];
        case 'const': return [node.name];
        case 'neg': return [...toPostfix(node.a), 'neg'];
        case 'bin': return [...toPostfix(node.a), ...toPostfix(node.b), { '*': '×', '/': '÷', '-': '−' }[node.op] ?? node.op];
        default: throw new ParseError('Only + − × ÷ ^ are supported in Polish notation.');
    }
}

function toPrefix(node) {
    switch (node.t) {
        case 'num': return [t(node.v)];
        case 'var': return [node.name];
        case 'const': return [node.name];
        case 'neg': return ['neg', ...toPrefix(node.a)];
        case 'bin': return [{ '*': '×', '/': '÷', '-': '−' }[node.op] ?? node.op, ...toPrefix(node.a), ...toPrefix(node.b)];
        default: throw new ParseError('Only + − × ÷ ^ are supported in Polish notation.');
    }
}

const OPS = { '+': '+', '-': '-', '−': '-', '*': '*', '×': '*', x: '*', '/': '/', '÷': '/', '^': '^' };

function fromPolish(tokens, prefix) {
    const stack = [];
    const seq = prefix ? [...tokens].reverse() : tokens;
    const steps = [];

    for (const tok of seq) {
        if (OPS[tok]) {
            if (stack.length < 2) {
                throw new ParseError(`Not enough operands for “${tok}”`);
            }

            let [x, y] = [stack.pop(), stack.pop()];

            if (!prefix) {
                [x, y] = [y, x];
            }

            const node = { t: 'bin', op: OPS[tok], a: x, b: y };
            steps.push(`${tok} → ${show(node, { slash: false, tight: false })}`);
            stack.push(node);
        } else {
            const v = R.parseNumber(tok);

            if (!v) {
                throw new ParseError(`Unknown token “${tok}”`);
            }

            stack.push({ t: 'num', v });
        }
    }

    if (stack.length !== 1) {
        throw new ParseError('Too many operands');
    }

    return { tree: stack[0], steps };
}

/** Deterministic random numbers (mulberry32) so an experiment can be repeated from its seed. */
function rng(seed) {
    let a = seed >>> 0;

    return () => {
        a = (a + 0x6d2b79f5) >>> 0;
        let x = Math.imul(a ^ (a >>> 15), 1 | a);
        x ^= x + Math.imul(x ^ (x >>> 7), 61 | x);

        return ((x ^ (x >>> 14)) >>> 0) / 4294967296;
    };
}

function magicSquare(n) {
    const m = Array.from({ length: n }, () => Array(n).fill(0));

    if (n % 2 === 1) {
        let [r, c] = [0, (n - 1) / 2];

        for (let k = 1; k <= n * n; k += 1) {
            m[r][c] = k;
            const [nr, nc] = [(r - 1 + n) % n, (c + 1) % n];

            if (m[nr][nc]) {
                r = (r + 1) % n;
            } else {
                [r, c] = [nr, nc];
            }
        }
    } else if (n % 4 === 0) {
        for (let r = 0; r < n; r += 1) {
            for (let c = 0; c < n; c += 1) {
                const k = r * n + c + 1;
                const keep = (r % 4 === c % 4) || ((r % 4) + (c % 4) === 3);
                m[r][c] = keep ? n * n + 1 - k : k;
            }
        }
    } else {
        // LUX method (Conway) for singly even n = 4k + 2.
        const half = n / 2;
        const sub = magicSquare(half);
        const k = (n - 2) / 4;
        const add = [0, 2, 3, 1].map((x) => x * half * half);

        for (let r = 0; r < half; r += 1) {
            for (let c = 0; c < half; c += 1) {
                m[r][c] = sub[r][c] + add[0];
                m[r + half][c + half] = sub[r][c] + add[3];
                m[r][c + half] = sub[r][c] + add[1];
                m[r + half][c] = sub[r][c] + add[2];
            }
        }

        for (let r = 0; r < half; r += 1) {
            const cols = [...Array(k).keys()].map((c) => (r === Math.floor(half / 2) ? c + 1 : c));
            cols.push(...[...Array(k - 1).keys()].map((c) => n - 1 - c));

            for (const c of cols) {
                [m[r][c], m[r + half][c]] = [m[r + half][c], m[r][c]];
            }
        }
    }

    return m;
}

const PLACES = ['ones', 'tens', 'hundreds', 'thousands', 'ten thousands', 'hundred thousands', 'millions', 'ten millions', 'hundred millions', 'billions', 'ten billions', 'hundred billions', 'trillions'];
const DEC_PLACES = ['tenths', 'hundredths', 'thousandths', 'ten-thousandths', 'hundred-thousandths', 'millionths'];

export const handlers = {
    arith: (i, c) => {
        const op = c.op ?? i.op ?? '+';
        const items = op === '+' || op === '*' ? list(i.list ?? `${i.a ?? ''}\n${i.b ?? ''}`) : [q(i.a), q(i.b)];

        if (!items || items.length < (op === '+' || op === '*' ? 1 : 2) || items.some((v) => !v)) {
            return need(op === '+' || op === '*' ? 'Enter the numbers, one per line or separated by commas.' : 'Enter both numbers.');
        }

        if (op === '/' && R.isZero(items[1])) {
            return fail('Division by zero is undefined.');
        }

        const r = items.slice(1).reduce((acc, v) => ({ '+': R.add, '-': R.sub, '*': R.mul, '/': R.div }[op](acc, v)), items[0]);
        const sym = { '+': '+', '-': '−', '*': '×', '/': '÷' }[op];
        const word = { '+': 'Sum', '-': 'Difference', '*': 'Product', '/': 'Quotient' }[op];
        const dp = R.decimalPlaces(r);

        return result(dp === Infinity ? dec(r) : R.toDecimal(r, dp).replace(/^(−?)(\d+)/, (m, s, d) => s + R.group(d)), word, { sub: items.length > 4 ? `${items.length} numbers` : items.map((v) => dec(v)).join(` ${sym} `), rows: { exact: t(r), scientific: R.isZero(r) ? '0' : `${f(R.toNumber(r), 12)}`, digits: R.isInt(r) ? `${R.babs(r.n).toString().length} digits` : `${dp === Infinity ? 'Repeating' : `${dp} decimal places`}` }, steps: items.length > 1 ? [`${items.map((v) => dec(v)).join(` ${sym} `)} = ${dec(r)}`] : [dec(r)] });
    },

    long_add: (i) => {
        const items = list(i.list);

        if (!items || items.length < 2 || items.some((v) => R.sign(v) < 0)) {
            return need('Enter two or more non-negative numbers, one per line.');
        }

        const { total, layout, colSteps } = longAdd(items);

        return result(dec(total), 'Sum', { sub: `${items.length} numbers added in columns`, rows: { exact: t(total), columns: String(colSteps.length) }, steps: [...layout, '', ...colSteps] });
    },

    long_sub: (i) => {
        const a = q(i.a);
        const b = q(i.b);

        if (!a || !b || R.sign(a) < 0 || R.sign(b) < 0) {
            return need('Enter two non-negative numbers.');
        }

        const swap = R.cmp(a, b) < 0;
        const { diff, layout, steps } = longSub(swap ? b : a, swap ? a : b);

        return result(dec(swap ? R.neg(diff) : diff), 'Difference', { sub: swap ? `${dec(b)} − ${dec(a)} is worked, then the sign is made negative` : `${dec(a)} − ${dec(b)}`, rows: { exact: t(R.sub(a, b)), columns: String(steps.length) }, steps: [...layout, '', ...steps] });
    },

    long_mult: (i, c) => {
        const a = q(i.a);
        const b = q(i.b);

        if (!a || !b) {
            return need('Enter two numbers.');
        }

        const product = R.mul(a, b);

        if (c.partial) {
            const ia = R.toDecimal(R.qabs(a), 0);
            const ib = R.toDecimal(R.qabs(b), 0);

            if (!R.isInt(a) || !R.isInt(b)) {
                return need('Partial products uses whole numbers.');
            }

            const parts = (s) => s.split('').map((d, k) => BigInt(d) * 10n ** BigInt(s.length - k - 1)).filter((v) => v);
            const pa = parts(ia);
            const pb = parts(ib);
            const products = pa.flatMap((x) => pb.map((y) => [x, y, x * y]));

            return result(dec(product), 'Product', { sub: `${pa.join(' + ')} times ${pb.join(' + ')}`, rows: { exact: t(product), columns: String(products.length) }, steps: [...products.map(([x, y, p]) => `${x} × ${y} = ${p}`), `Add the partial products: ${products.map((p) => p[2]).join(' + ')} = ${products.reduce((s, p) => s + p[2], 0n)}`] });
        }

        const { layout, steps } = longMultiply(a, b);

        return result(dec(product), 'Product', { sub: `${dec(a)} × ${dec(b)}`, rows: { exact: t(product), columns: String(steps.length) }, steps: [...layout, '', ...steps, R.sign(product) < 0 ? 'One factor is negative, so the product is negative' : ''].filter((s) => s !== '' || true) });
    },

    long_div: (i) => {
        const a = N.parseBig(i.a);
        const b = N.parseBig(i.b);

        if (a === null || b === null || a < 0n || b <= 0n) {
            return need('Enter a whole-number dividend and a positive whole-number divisor.');
        }

        const places = Math.max(0, Math.min(20, Math.round(Number(i.places ?? 0))));
        const { quotient, remainderInt, steps, layout } = longDivide(a, b, places);

        return result(places ? quotient : `${R.group(quotient)} R ${remainderInt}`, `${a} ÷ ${b}`, { sub: `${a} = ${a / b} × ${b} + ${remainderInt}`, rows: { quotient: (a / b).toString(), remainder: remainderInt.toString(), decimal: dec(R.Q(a, b)) }, steps: [...layout, '', ...steps] });
    },

    order_ops: (i) => {
        const text = String(i.expr ?? '').trim();

        if (!text) {
            return need('Type an expression such as 3 + 4 × (2 − 1)^2.');
        }

        let tree;

        try {
            tree = parse(text);
        } catch (e) {
            return fail(e instanceof ParseError ? e.message : 'Could not read the expression.');
        }

        const exact = evalExact(tree);
        const steps = [`  ${show(tree, { slash: false, tight: false })}`];
        let node = tree;

        for (let k = 0; k < 60 && node.t !== 'num'; k += 1) {
            const next = reduceOnce(node);

            if (!next) {
                break;
            }

            node = next;
            steps.push(`= ${show(node, { slash: false, tight: false })}`);
        }

        const value = exact ? dec(exact) : f(evalReal(tree), 12);

        return result(value, 'Value', { sub: exact && !R.isInt(exact) ? `= ${t(exact)}` : 'Brackets, exponents, × and ÷ left to right, then + and − left to right', rows: { exact: exact ? t(exact) : 'Not a rational number', rule: 'PEMDAS / BODMAS: × and ÷ have equal rank, as do + and −' }, steps });
    },

    abs_change: (i) => {
        const a = q(i.a);
        const b = q(i.b);

        if (!a || !b) {
            return need('Enter the starting and the final value.');
        }

        const d = R.sub(b, a);

        return result(`${R.sign(d) > 0 ? '+' : ''}${dec(d)}`, 'Absolute change', { sub: R.sign(d) > 0 ? 'An increase' : R.sign(d) < 0 ? 'A decrease' : 'No change', rows: { relative: R.isZero(a) ? 'Undefined from zero' : `${dec(R.mul(R.div(d, R.qabs(a)), R.Q(100)))}%`, size: dec(R.qabs(d)) }, steps: [`${dec(b)} − ${dec(a)} = ${dec(d)}`] });
    },

    property: (i, c) => {
        const v = [q(i.a), q(i.b), q(i.c)];

        if (v.some((x) => !x)) {
            return need('Enter three numbers.');
        }

        const [a, b, cc] = v;

        if (c.prop === 'distributive') {
            const left = R.mul(a, R.add(b, cc));
            const right = R.add(R.mul(a, b), R.mul(a, cc));

            return result(`${dec(left)} = ${dec(right)}`, `${dec(a)}(${dec(b)} + ${dec(cc)}) = ${dec(a)}×${dec(b)} + ${dec(a)}×${dec(cc)}`, { sub: 'Multiplication distributes over addition', rows: { left: `${dec(a)} × ${dec(R.add(b, cc))} = ${dec(left)}`, right: `${dec(R.mul(a, b))} + ${dec(R.mul(a, cc))} = ${dec(right)}`, holds: 'Always for real numbers' }, steps: [`Left: ${dec(a)} × (${dec(b)} + ${dec(cc)}) = ${dec(a)} × ${dec(R.add(b, cc))} = ${dec(left)}`, `Right: ${dec(a)} × ${dec(b)} + ${dec(a)} × ${dec(cc)} = ${dec(R.mul(a, b))} + ${dec(R.mul(a, cc))} = ${dec(right)}`] });
        }

        const op = i.op ?? '+';
        const fn = { '+': R.add, '-': R.sub, '*': R.mul, '/': R.div }[op];
        const sym = { '+': '+', '-': '−', '*': '×', '/': '÷' }[op];

        if (op === '/' && (R.isZero(b) || R.isZero(cc) || R.isZero(R.div(b, cc)))) {
            return fail('Division by zero.');
        }

        const left = fn(fn(a, b), cc);
        const right = fn(a, fn(b, cc));
        const same = R.eq(left, right);

        return result(same ? 'Equal' : 'Not equal', `(${dec(a)} ${sym} ${dec(b)}) ${sym} ${dec(cc)} vs ${dec(a)} ${sym} (${dec(b)} ${sym} ${dec(cc)})`, { sub: op === '+' || op === '*' ? `${op === '+' ? 'Addition' : 'Multiplication'} is associative: grouping never changes the result` : `${op === '-' ? 'Subtraction' : 'Division'} is not associative in general`, rows: { left: `${dec(left)}`, right: `${dec(right)}`, holds: op === '+' || op === '*' ? 'Always' : 'Not in general' }, steps: [`(${dec(a)} ${sym} ${dec(b)}) ${sym} ${dec(cc)} = ${dec(fn(a, b))} ${sym} ${dec(cc)} = ${dec(left)}`, `${dec(a)} ${sym} (${dec(b)} ${sym} ${dec(cc)}) = ${dec(a)} ${sym} ${dec(fn(b, cc))} = ${dec(right)}`] });
    },

    compatible: (i) => {
        const a = Number(i.a);
        const b = Number(i.b);
        const op = i.op ?? '+';

        if (!Number.isFinite(a) || !Number.isFinite(b) || (op === '/' && b === 0)) {
            return need('Enter two numbers.');
        }

        const round1 = (x) => {
            if (x === 0) {
                return 0;
            }

            const p = 10 ** Math.floor(Math.log10(Math.abs(x)));

            return Math.round(x / p) * p;
        };
        let ca;
        let cb;

        if (op === '/') {
            cb = round1(b);
            ca = Math.round(a / cb) * cb || cb;
        } else if (op === '*') {
            ca = round1(a);
            cb = round1(b);
        } else {
            const p = 10 ** Math.max(0, Math.floor(Math.log10(Math.max(Math.abs(a), Math.abs(b)))) - 1);
            ca = Math.round(a / p) * p;
            cb = Math.round(b / p) * p;
        }

        const fn = { '+': (x, y) => x + y, '-': (x, y) => x - y, '*': (x, y) => x * y, '/': (x, y) => x / y }[op];
        const sym = { '+': '+', '-': '−', '*': '×', '/': '÷' }[op];
        const est = fn(ca, cb);
        const exact = fn(a, b);

        return result(f(est), 'Estimate', { sub: `${f(ca)} ${sym} ${f(cb)}`, rows: { compatible: `${f(ca)} and ${f(cb)}`, exact: f(exact, 10), error: exact ? `${f(((est - exact) / Math.abs(exact)) * 100, 3)}%` : '0' }, steps: [`Replace ${f(a)} with ${f(ca)} and ${f(b)} with ${f(cb)}: numbers that are easy to ${op === '/' ? 'divide' : 'work with'} mentally`, `${f(ca)} ${sym} ${f(cb)} = ${f(est)}`, `Exact: ${f(exact, 10)}`] });
    },

    consecutive: (i) => {
        const sum = N.parseBig(i.sum);
        const n = N.parseBig(i.count);
        const kind = i.kind ?? 'any';

        if (sum === null || n === null || n < 1n || n > 10000n) {
            return need('Enter the sum and how many consecutive integers (1 to 10,000).');
        }

        const d = kind === 'any' ? 1n : 2n;
        const top = sum - (n * (n - 1n) * d) / 2n;

        if (top % n !== 0n) {
            return result('No solution', `${n} consecutive ${kind === 'any' ? '' : `${kind} `}integers cannot add up to ${sum}`, { rows: { first: 'None', formula: `n·a + d·n(n − 1)/2 = ${sum}` }, steps: [`a = (${sum} − ${(n * (n - 1n) * d) / 2n}) ÷ ${n} = ${R.toFraction(R.Q(top, n))}, not an integer`] });
        }

        const a = top / n;

        if (kind !== 'any' && N.mod(a, 2n) !== (kind === 'even' ? 0n : 1n)) {
            return result('No solution', `No ${kind} integers work`, { rows: { first: 'None', formula: `n·a + d·n(n − 1)/2 = ${sum}` }, steps: [`The first number would be ${a}, which is not ${kind}`] });
        }

        const items = Array.from({ length: Number(n > 30n ? 30n : n) }, (_, k) => a + BigInt(k) * d);

        return result(items.join(', ') + (n > 30n ? ', …' : ''), `${n} consecutive ${kind === 'any' ? '' : `${kind} `}integers`, { sub: `Adding up to ${sum}`, rows: { first: a.toString(), formula: `${n}a + ${(n * (n - 1n) * d) / 2n} = ${sum}` }, steps: [`Let the first be a: ${n}a + ${d === 1n ? '' : '2×'}(0 + 1 + … + ${n - 1n}) = ${sum}`, `a = ${a}`] });
    },

    counting: (i) => {
        const items = String(i.choices ?? '').split(/[\s,;×x*]+/).filter(Boolean).map(N.parseBig);

        if (!items.length || items.some((v) => v === null || v < 0n)) {
            return need('Enter the number of choices at each stage, such as 3, 4, 2.');
        }

        const total = items.reduce((p, v) => p * v, 1n);

        return result(R.fmt(total), 'Possible outcomes', { sub: items.join(' × '), rows: { stages: String(items.length), rule: 'If one choice can be made in m ways and the next in n ways, together they can be made in m × n ways' }, steps: [`${items.join(' × ')} = ${total}`] });
    },

    compare: (i) => {
        const read = (s) => {
            const x = q(s);

            if (x) {
                return { exact: x, value: R.toNumber(x) };
            }

            try {
                const tree = parse(s);
                const e = evalExact(tree);

                return { exact: e, value: e ? R.toNumber(e) : evalReal(tree) };
            } catch {
                return null;
            }
        };
        const a = read(i.a);
        const b = read(i.b);

        if (!a || !b || !Number.isFinite(a.value) || !Number.isFinite(b.value)) {
            return need('Enter two numbers, fractions or expressions.');
        }

        const c = a.exact && b.exact ? R.cmp(a.exact, b.exact) : Math.sign(a.value - b.value);
        const sym = c < 0 ? '<' : c > 0 ? '>' : '=';

        return result(`${i.a} ${sym} ${i.b}`, c < 0 ? 'Less than' : c > 0 ? 'Greater than' : 'Equal', { sub: `${f(a.value, 12)} ${sym} ${f(b.value, 12)}`, rows: { difference: a.exact && b.exact ? dec(R.sub(a.exact, b.exact)) : f(a.value - b.value, 12), method: a.exact && b.exact ? 'Exact comparison' : 'Compared numerically (15 significant digits)' }, steps: [`${i.a} = ${a.exact ? dec(a.exact) : f(a.value, 15)}`, `${i.b} = ${b.exact ? dec(b.exact) : f(b.value, 15)}`] });
    },

    place_value: (i, c) => {
        const x = q(i.x);

        if (!x) {
            return need('Enter a number such as 4,305.27.');
        }

        const dp = Math.min(R.decimalPlaces(x), 6);
        const { int, frac } = digitsOf(x, dp === Infinity ? 6 : dp);
        const parts = [];

        int.split('').forEach((d, k) => {
            const place = int.length - k - 1;
            parts.push({ d, name: PLACES[place] ?? `10^${place}`, value: `${d}${'0'.repeat(place)}`, power: place });
        });
        frac.split('').forEach((d, k) => parts.push({ d, name: DEC_PLACES[k], value: `0.${'0'.repeat(k)}${d}`, power: -(k + 1) }));
        const digit = Number(i.digit ?? NaN);
        const nonzero = parts.filter((p) => p.d !== '0');

        if (c.mode === 'expanded') {
            return result(nonzero.map((p) => R.group(p.value.replace(/^0\./, '0.'))).join(' + ') || '0', 'Expanded form', { sub: `${R.sign(x) < 0 ? '−(' : ''}${dec(R.qabs(x))}${R.sign(x) < 0 ? ')' : ''}`, rows: { factors: nonzero.map((p) => `${p.d} × ${p.power >= 0 ? R.group(`1${'0'.repeat(p.power)}`) : `1/${R.group(`1${'0'.repeat(-p.power)}`)}`}`).join(' + '), powers: nonzero.map((p) => `${p.d} × 10${R.sup(p.power)}`).join(' + ') }, steps: nonzero.map((p) => `${p.d} in the ${p.name} place = ${p.value}`) });
        }

        return result(Number.isFinite(digit) && parts.find((p) => Number(p.d) === digit) ? parts.filter((p) => Number(p.d) === digit).map((p) => p.name).join(', ') : `${parts.length} digits`, Number.isFinite(digit) ? `Place of the digit ${digit}` : 'Place values', { sub: dec(x), rows: { factors: parts.map((p) => `${p.d}: ${p.name}`).join(', '), powers: parts.map((p) => `${p.d} × 10${R.sup(p.power)}`).join(' + ') }, steps: parts.map((p) => `${p.d} → ${p.name} (${p.value})`) });
    },

    digit_sum: (i, c) => {
        const n = N.parseBig(i.n);

        if (n === null) {
            return need('Enter a whole number.');
        }

        const sum = (v) => [...R.babs(v).toString()].reduce((s, d) => s + BigInt(d), 0n);
        const chain = [R.babs(n)];

        while (chain[chain.length - 1] >= 10n) {
            chain.push(sum(chain[chain.length - 1]));
        }

        const root = chain[chain.length - 1];

        return result(c.root ? root.toString() : sum(n).toString(), c.root ? 'Digital root' : 'Digit sum', { sub: c.root ? chain.join(' → ') : `${[...R.babs(n).toString()].join(' + ')}`, rows: { sum: sum(n).toString(), root: root.toString(), nine: `${n} mod 9 = ${N.mod(n, 9n)} (digital root ${n === 0n ? 0 : N.mod(n, 9n) || 9n} for positive numbers)` }, steps: chain.slice(0, -1).map((v, k) => `${[...v.toString()].join(' + ')} = ${chain[k + 1]}`) });
    },

    triangular: (i) => {
        const n = N.parseBig(i.n);

        if (n === null || n < 0n) {
            return need('Enter a whole number.');
        }

        const tn = (n * (n + 1n)) / 2n;
        const test = 8n * n + 1n;
        const r = N.isqrt(test);
        const isTri = r * r === test;
        const k = isTri ? (r - 1n) / 2n : null;
        const dots = n <= 8n ? Array.from({ length: Number(n) }, (_, j) => `${' '.repeat(Number(n) - j - 1)}${'● '.repeat(j + 1)}`.trimEnd()) : [];

        return result(R.fmt(tn), `T${R.subscript(n)} (the ${n}th triangular number)`, { sub: `${n}(${n} + 1)/2`, rows: { test: isTri ? `${n} is itself triangular: T${R.subscript(k)}` : `${n} is not triangular`, next: `T${R.subscript(n + 1n)} = ${((n + 1n) * (n + 2n)) / 2n}`, sequence: Array.from({ length: 10 }, (_, j) => (j + 1) * (j + 2) / 2).join(', ') }, steps: [...dots, `T${R.subscript(n)} = ${n} × ${n + 1n} ÷ 2 = ${tn}`] });
    },

    magic: (i) => {
        const n = Math.round(Number(i.n));

        if (!Number.isFinite(n) || n < 3 || n > 12) {
            return need('Enter an order from 3 to 12.');
        }

        const m = magicSquare(n);
        const constant = (n * (n * n + 1)) / 2;
        const ok = m.every((row) => row.reduce((a, b) => a + b, 0) === constant) && m[0].every((_, c2) => m.reduce((a, row) => a + row[c2], 0) === constant) && m.reduce((a, row, k) => a + row[k], 0) === constant && m.reduce((a, row, k) => a + row[n - 1 - k], 0) === constant;
        const w = String(n * n).length;

        return result(String(constant), `Magic constant for a ${n} × ${n} square`, { sub: ok ? 'Every row, column and diagonal adds up to it' : 'Check failed', rows: { method: n % 2 ? 'Siamese method (odd order)' : n % 4 === 0 ? 'Doubly even pattern' : 'LUX method (singly even)', formula: `M = n(n² + 1)/2 = ${n}(${n * n} + 1)/2` }, steps: m.map((row) => row.map((v) => String(v).padStart(w)).join(' ')) });
    },

    polish: (i) => {
        const text = String(i.expr ?? '').trim();
        const from = i.from ?? 'infix';

        if (!text) {
            return need('Enter an expression.');
        }

        try {
            let tree;
            let steps = [];

            if (from === 'infix') {
                tree = parse(text);
            } else {
                const tokens = text.split(/\s+/).filter(Boolean);
                ({ tree, steps } = fromPolish(tokens, from === 'prefix'));
            }

            const prefix = toPrefix(tree).join(' ');
            const postfix = toPostfix(tree).join(' ');
            const value = evalExact(tree);

            return result(from === 'postfix' ? show(tree) : postfix, from === 'postfix' ? 'Infix form' : 'Postfix (reverse Polish)', { sub: value ? `Value ${dec(value)}` : '', rows: { infix: show(tree), prefix, postfix, value: value ? dec(value) : 'Not numeric' }, steps: steps.length ? steps : [`Infix: ${show(tree)}`, `Prefix: ${prefix}`, `Postfix: ${postfix}`] });
        } catch (e) {
            return fail(e instanceof ParseError ? e.message : 'Could not read the expression.');
        }
    },

    pi_experiment: (i) => {
        const n = Math.round(Number(i.trials));
        const seed = Math.round(Number(i.seed ?? 1));

        if (!Number.isFinite(n) || n < 10 || n > 2000000) {
            return need('Enter between 10 and 2,000,000 trials.');
        }

        const rand = rng(seed);
        let estimate;
        let hits = 0;
        const series = [];

        if (i.method === 'buffon') {
            const l = 1;
            const spacing = Number(i.spacing ?? 2) || 2;

            for (let k = 1; k <= n; k += 1) {
                const x = rand() * (spacing / 2);
                const theta = rand() * (Math.PI / 2);

                if (x <= (l / 2) * Math.sin(theta)) {
                    hits += 1;
                }

                if (k % Math.max(1, Math.floor(n / 100)) === 0 && hits) {
                    series.push([k, (2 * l * k) / (spacing * hits)]);
                }
            }

            estimate = hits ? (2 * l * n) / (spacing * hits) : NaN;
        } else {
            for (let k = 1; k <= n; k += 1) {
                const x = rand();
                const y = rand();

                if (x * x + y * y <= 1) {
                    hits += 1;
                }

                if (k % Math.max(1, Math.floor(n / 100)) === 0) {
                    series.push([k, (4 * hits) / k]);
                }
            }

            estimate = (4 * hits) / n;
        }

        return result(f(estimate, 8), 'Estimate of π', { sub: `Error ${f(estimate - Math.PI, 3)} after ${R.group(String(n))} trials`, rows: { hits: R.group(String(hits)), error: `${f(Math.abs(estimate - Math.PI) / Math.PI * 100, 3)}%`, method: i.method === 'buffon' ? 'Buffon\'s needle (needle length 1)' : 'Random points in a quarter circle' }, steps: [i.method === 'buffon' ? `π ≈ 2ln ÷ (t × crossings) = 2 × 1 × ${n} ÷ (${i.spacing ?? 2} × ${hits})` : `π ≈ 4 × inside ÷ total = 4 × ${hits} ÷ ${n}`], plots: { curve: { series, xLabel: 'Trials', yLabel: 'Estimate of π', series2: series.map(([x]) => [x, Math.PI]), legend: ['Estimate', 'π'] } } });
    },
};

export default defineTools(handlers);
