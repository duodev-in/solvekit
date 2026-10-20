import { evalReal, parse } from './expr.js';
import { f, need, result } from './util.js';

/**
 * Practice mode for a few calculators: question n (1, 2, 3 …) is generated from a seeded random source, so the
 * same number always gives the same question. The typed answer may be a decimal, a fraction or an exact form
 * such as √3/2; it is accepted within the stated rounding.
 */
function rng(seed) {
    let a = (seed * 2654435761) >>> 0;

    return () => {
        a = (a + 0x6d2b79f5) >>> 0;
        let t = a;
        t = Math.imul(t ^ (t >>> 15), t | 1);
        t ^= t + Math.imul(t ^ (t >>> 7), t | 61);

        return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
    };
}

const pick = (r, list) => list[Math.floor(r() * list.length)];
const int = (r, lo, hi) => lo + Math.floor(r() * (hi - lo + 1));
const D = Math.PI / 180;

const TOPICS = {
    rectangle: (r) => {
        const l = int(r, 3, 24);
        const w = int(r, 2, l);
        const kind = pick(r, ['area', 'perimeter', 'width', 'diagonal']);

        if (kind === 'area') {
            return { q: `A rectangle is ${l} cm long and ${w} cm wide. What is its area in cm²?`, a: l * w, tol: 0, unit: 'cm²', work: [`A = l × w = ${l} × ${w} = ${l * w} cm²`] };
        }

        if (kind === 'perimeter') {
            return { q: `A rectangle is ${l} m by ${w} m. What is its perimeter in m?`, a: 2 * (l + w), tol: 0, unit: 'm', work: [`P = 2(l + w) = 2(${l} + ${w}) = ${2 * (l + w)} m`] };
        }

        if (kind === 'width') {
            return { q: `A rectangle has area ${l * w} cm² and length ${l} cm. How wide is it in cm?`, a: w, tol: 0, unit: 'cm', work: [`w = A ÷ l = ${l * w} ÷ ${l} = ${w} cm`] };
        }

        const d = Math.hypot(l, w);

        return { q: `A rectangle is ${l} cm by ${w} cm. How long is its diagonal in cm (to 2 decimal places)?`, a: d, tol: 0.006, unit: 'cm', work: [`d = √(l² + w²) = √(${l * l} + ${w * w}) = √${l * l + w * w}`, `≈ ${f(d, 6)} cm`] };
    },

    cylinder: (r) => {
        const radius = int(r, 2, 15);
        const h = int(r, 3, 30);
        const v = Math.PI * radius * radius * h;
        const kind = pick(r, ['cm3', 'litres', 'litres', 'surface']);

        if (kind === 'cm3') {
            return { q: `A cylinder has radius ${radius} cm and height ${h} cm. What is its volume in cm³ (to 1 decimal place)?`, a: v, tol: 0.06, unit: 'cm³', work: [`V = πr²h = π × ${radius}² × ${h}`, `= ${radius * radius * h}π ≈ ${f(v, 8)} cm³`] };
        }

        if (kind === 'litres') {
            return { q: `A cylindrical tank is ${2 * radius} cm across and ${h} cm tall. How many litres does it hold (to 2 decimal places)?`, a: v / 1000, tol: 0.006, unit: 'L', work: [`r = ${2 * radius} ÷ 2 = ${radius} cm`, `V = πr²h = π × ${radius}² × ${h} ≈ ${f(v, 8)} cm³`, `1 L = 1,000 cm³, so ${f(v / 1000, 6)} L`] };
        }

        const a = 2 * Math.PI * radius * (radius + h);

        return { q: `A closed cylinder has radius ${radius} cm and height ${h} cm. What is its total surface area in cm² (to 1 decimal place)?`, a, tol: 0.06, unit: 'cm²', work: [`A = 2πr(r + h) = 2π × ${radius} × ${radius + h}`, `≈ ${f(a, 8)} cm²`] };
    },

    rightTriangle: (r) => {
        const kind = pick(r, ['hyp', 'leg', 'opp', 'angle']);

        if (kind === 'hyp' || kind === 'leg') {
            const triples = [[3, 4, 5], [5, 12, 13], [8, 15, 17], [7, 24, 25], [6, 8, 10], [9, 12, 15], [20, 21, 29], [9, 40, 41]];
            const [x, y, z] = pick(r, triples);

            return kind === 'hyp'
                ? { q: `A right triangle has legs ${x} and ${y}. How long is the hypotenuse?`, a: z, tol: 0, unit: '', work: [`c = √(a² + b²) = √(${x * x} + ${y * y}) = √${z * z} = ${z}`] }
                : { q: `A right triangle has hypotenuse ${z} and one leg ${x}. How long is the other leg?`, a: y, tol: 0, unit: '', work: [`b = √(c² − a²) = √(${z * z} − ${x * x}) = √${y * y} = ${y}`] };
        }

        const hyp = int(r, 5, 30);
        const ang = int(r, 15, 75);

        if (kind === 'opp') {
            const a = hyp * Math.sin(ang * D);

            return { q: `A ladder ${hyp} m long leans at ${ang}° to the ground. How high up the wall does it reach (m, to 2 decimal places)?`, a, tol: 0.006, unit: 'm', work: ['opposite = hypotenuse × sin θ', `= ${hyp} × sin ${ang}° ≈ ${f(a, 6)} m`] };
        }

        const opp = int(r, 2, 20);
        const adj = int(r, 2, 20);
        const theta = Math.atan2(opp, adj) / D;

        return { q: `A ramp rises ${opp} m over a horizontal run of ${adj} m. What angle does it make with the ground (degrees, to 1 decimal place)?`, a: theta, tol: 0.06, unit: '°', work: ['tan θ = opposite ÷ adjacent', `θ = atan(${opp} ÷ ${adj}) ≈ ${f(theta, 6)}°`] };
    },

    trig: (r) => {
        const angles = [0, 30, 45, 60, 90, 120, 135, 150, 180, 210, 225, 240, 270, 300, 315, 330];
        const exact = { 0: ['0', '1', '0'], 30: ['1/2', '√3/2', '√3/3'], 45: ['√2/2', '√2/2', '1'], 60: ['√3/2', '1/2', '√3'], 90: ['1', '0', null] };
        let ang = pick(r, angles);
        let fn = pick(r, ['sin', 'cos', 'tan']);

        if (fn === 'tan' && (ang === 90 || ang === 270)) {
            fn = 'sin';
        }

        const ref = ang <= 90 ? ang : ang <= 180 ? 180 - ang : ang <= 270 ? ang - 180 : 360 - ang;
        const value = fn === 'sin' ? Math.sin(ang * D) : fn === 'cos' ? Math.cos(ang * D) : Math.tan(ang * D);
        const clean = Math.abs(value) < 1e-12 ? 0 : value;
        const base = exact[ref][{ sin: 0, cos: 1, tan: 2 }[fn]];
        const text = clean === 0 ? '0' : `${clean < 0 ? '−' : ''}${base}`;
        ang = ang === 360 ? 0 : ang;

        return { q: `What is the exact value of ${fn} ${ang}°? (Type it as a fraction or root, e.g. √3/2, or as a decimal.)`, a: clean, tol: 0.0006, unit: '', exactText: text, work: [`Reference angle ${ref}°`, `${fn} ${ref}° = ${base}`, `In this quadrant ${fn} is ${clean < 0 ? 'negative' : clean > 0 ? 'positive' : 'zero'}`, `So ${fn} ${ang}° = ${text}`] };
    },
};

export function practice(topic, i) {
    const n = Math.round(Number(i.question ?? 1));

    if (!Number.isInteger(n) || n < 1 || n > 100000) {
        return need('Enter a question number (1, 2, 3 …). Change it for a new question.');
    }

    const item = TOPICS[topic](rng(n));
    const typed = String(i.answer ?? '').trim();
    const answerText = item.exactText ?? `${f(item.a, item.tol ? 8 : 12)}${item.unit ? ` ${item.unit}` : ''}`;

    if (!typed) {
        return result(`Question ${n}`, item.q, { sub: 'Type your answer, then compare with the worked solution', rows: { question: item.q, yours: 'Not answered yet', check: 'Waiting for your answer', answer: 'Shown after you answer' }, steps: ['Answer the question, then the worked solution appears here', 'Change the question number for another one'] });
    }

    let value;

    try {
        value = evalReal(parse(typed.replace(/,/g, '').replace(/°/g, '').replace(/(cm²|cm³|cm|m²|m|L)$/i, '')));
    } catch {
        value = NaN;
    }

    if (!Number.isFinite(value)) {
        return result('Not a number', item.q, { sub: 'Type a number, a fraction such as 3/4 or a root such as √3/2', rows: { question: item.q, yours: typed, check: 'Could not read the answer', answer: answerText }, steps: item.work });
    }

    const tolerance = Math.max(item.tol, 1e-9 * Math.max(1, Math.abs(item.a)));
    const correct = Math.abs(value - item.a) <= tolerance;

    return result(correct ? 'Correct ✓' : 'Not quite', item.q, { sub: correct ? `Well done. Try question ${n + 1} next.` : `The answer is ${answerText}`, rows: { question: item.q, yours: `${typed}${Math.abs(value - Number(typed)) > 1e-12 ? ` = ${f(value, 10)}` : ''}`, check: correct ? 'Correct' : `Off by ${f(Math.abs(value - item.a), 6)}`, answer: answerText }, steps: item.work });
}
