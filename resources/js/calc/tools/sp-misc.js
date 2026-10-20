import { formatMoney } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { handlersFor, K, num } from '../physics/core.js';
import { fmtTime, parseTime } from '../sports/time.js';

/**
 * Watersports, weightlifting and other sports: boats and swimming, scuba, strength formulas and scores, athletics
 * scoring tables, golf handicaps, bowling, Elo and equipment sizing.
 */
const g0 = K.g0;
const N = (label, value, min = 0) => [label, null, null, value, min];
const SEX = ['Sex', 'select', { male: 'Male', female: 'Female' }, 'male'];
const UNIT = ['Weights in', 'select', { kg: 'kg', lb: 'lb' }, 'kg'];

/** One-rep-max estimators (weight w lifted for r reps). */
export const ONE_RM = {
    epley: ['Epley', (w, r) => (r === 1 ? w : w * (1 + r / 30))],
    brzycki: ['Brzycki', (w, r) => (w * 36) / (37 - r)],
    lombardi: ['Lombardi', (w, r) => w * r ** 0.1],
    lander: ['Lander', (w, r) => (100 * w) / (101.3 - 2.67123 * r)],
    mayhew: ['Mayhew', (w, r) => (100 * w) / (52.2 + 41.9 * Math.exp(-0.055 * r))],
    oconner: ['O’Conner', (w, r) => w * (1 + 0.025 * r)],
    wathan: ['Wathan', (w, r) => (100 * w) / (48.8 + 53.8 * Math.exp(-0.075 * r))],
};
const oneRm = (w, r) => {
    const list = Object.values(ONE_RM).map(([, f]) => f(w, r));

    return list.reduce((a, b) => a + b, 0) / list.length;
};
/** Round to the smallest jump you can load (2.5 kg or 5 lb by default). */
const roundTo = (v, step) => Math.round(v / step) * step;

/** % of 1RM at RPE 10 for 1–12 reps (Mike Tuchscherer, Reactive Training Systems). */
const RPE10 = [100, 95.5, 92.2, 89.2, 86.3, 83.7, 81.1, 78.6, 76.2, 73.9, 70.7, 68, 65.3, 62.6, 59.9, 57.4, 54.7];
/** % of 1RM for reps at an RPE (each RPE point below 10 counts as one more rep in reserve; half points interpolated). */
export function rpePercent(reps, rpe) {
    const pos = reps - 1 + (10 - rpe);
    const lo = Math.floor(pos);
    const f = pos - lo;

    return lo + 1 >= RPE10.length ? NaN : RPE10[lo] + f * (RPE10[lo + 1] - RPE10[lo]);
}

/** Ten-pin bowling score from rolls typed as X, /, -, or numbers. */
export function bowling(text) {
    const tokens = String(text ?? '').toUpperCase().replace(/[,|]/g, ' ').match(/X|\/|-|F|\d+/g) ?? [];
    const rolls = [];

    for (const t of tokens) {
        if (t === 'X') {
            rolls.push(10);
        } else if (t === '/') {
            if (!rolls.length) {
                return null;
            }

            rolls.push(10 - rolls[rolls.length - 1]);
        } else if (t === '-' || t === 'F') {
            rolls.push(0);
        } else {
            for (const d of t) {
                rolls.push(Number(d));
            }
        }
    }

    const frames = [];
    let i = 0;

    for (let f = 0; f < 10; f += 1) {
        if (i >= rolls.length) {
            break;
        }

        if (rolls[i] === 10) {
            frames.push({ score: 10 + (rolls[i + 1] ?? 0) + (rolls[i + 2] ?? 0), done: rolls[i + 2] !== undefined });
            i += 1;
        } else if (rolls[i] + (rolls[i + 1] ?? 0) === 10) {
            frames.push({ score: 10 + (rolls[i + 2] ?? 0), done: rolls[i + 2] !== undefined });
            i += 2;
        } else {
            if ((rolls[i] ?? 0) + (rolls[i + 1] ?? 0) > 10) {
                return null;
            }

            frames.push({ score: rolls[i] + (rolls[i + 1] ?? 0), done: rolls[i + 1] !== undefined });
            i += 2;
        }
    }

    let total = 0;

    return { frames: frames.map((f) => ({ ...f, total: (total += f.score) })), total };
}

/** World Handicap System: number of lowest differentials used and the adjustment, by number of scores. */
const WHS = [[3, 1, -2], [4, 1, -1], [5, 1, 0], [6, 2, -1], [7, 2, 0], [9, 3, 0], [12, 4, 0], [15, 5, 0], [17, 6, 0], [19, 7, 0], [20, 8, 0]];

/** Combined-events points: INT(A(B − T)^C) for track, INT(A(M − B)^C) for jumps (cm) and throws (m). */
export function eventPoints(e, mark) {
    const base = e.type === 'track' ? e.B - mark : e.type === 'jump' ? mark * 100 - e.B : mark - e.B;

    return base > 0 ? Math.floor(e.A * base ** e.C) : 0;
}

function combined(which, defaults) {
    return {
        type: 'calc',
        inputs: Object.fromEntries(defaults.map(([k, label, v]) => [k, [label, 'text', null, v]])),
        data: ['combined_events'],
        label: 'Total points',
        rows: { avg: 'Average per event', counted: 'Events entered' },
        grids: [['events', 'Points per event']],
        run: (x, ctx) => {
            const table = ctx.c.data.sports.combined_events[which];
            const rows = [];
            let total = 0;

            for (const [k] of defaults) {
                const e = table[k];
                const raw = String(x[k] ?? '').trim();

                if (!raw) {
                    continue;
                }

                const mark = e.type === 'track' ? parseTime(raw, 1) : Number(raw);

                if (!Number.isFinite(mark) || mark <= 0) {
                    return { error: `Check the ${e.name} result (times as seconds or m:ss.ss, distances in metres).` };
                }

                const p = eventPoints(e, mark);
                total += p;
                rows.push({ header: e.name, cells: [raw, num(p)] });
            }

            if (!rows.length) {
                return { empty: 'Enter at least one result.' };
            }

            return { value: num(total), unit: 'points', sub: `${rows.length} of ${defaults.length} events`, rows: { avg: num(total / rows.length, 4), counted: `${rows.length}` }, steps: ['World Athletics combined-events tables: points = A × (B − T)^C for running, A × (M − B)^C for jumps (cm) and throws (m), rounded down', 'Fully automatic times; hand times need +0.24 s (+0.14 s over 400 m)'], grids: { events: { columns: ['Result', 'Points'], rows } } };
        },
    };
}

export const TOOLS = {
    // Watersports --------------------------------------------------------------------------------
    reel_capacity: {
        type: 'calc',
        inputs: { yards: N('Rated capacity (length on the spool)', 200, 1), d1: ['Rated line diameter', 'length', 'mm', 0.35], d2: ['Your line diameter', 'length', 'mm', 0.28] },
        label: 'Capacity with your line',
        rows: { ratio: 'Change', note: 'Note' },
        run: (x) => {
            const cap = x.yards * (x.d1 / x.d2) ** 2;

            return { value: num(cap, 4), unit: '(same length unit as the rating)', sub: `${num((cap / x.yards - 1) * 100, 3)}% more line`, rows: { ratio: `× ${num((x.d1 / x.d2) ** 2, 4)}`, note: 'Braid packs differently from monofilament; leave a little room at the lip' }, steps: ['The spool holds the same volume: capacity ∝ 1 ÷ diameter²', `= ${num(x.yards)} × (${num(x.d1 * 1000)} ÷ ${num(x.d2 * 1000)})² = ${num(cap)}`] };
        },
    },
    fish_weight: {
        type: 'calc',
        inputs: { L: ['Length', 'length', 'in', 24], G: ['Girth', 'length', 'in', 14], shape: ['Shape', 'select', { 800: 'Most fish (length × girth² ÷ 800)', 900: 'Slender fish such as pike, musky (÷ 900)', 1200: 'Bass (length × girth² ÷ 1,200)' }, '800'] },
        out: 'mass',
        outUnit: 'lb',
        label: 'Estimated weight',
        rows: { note: 'Accuracy' },
        run: (x) => {
            const Li = x.L / 0.0254;
            const Gi = x.G / 0.0254;
            const lb = (Li * Gi * Gi) / Number(x.shape);

            return { value: lb * 0.45359237, sub: `${num(lb, 3)} lb`, rows: { note: 'An angler’s rule of thumb, usually within about 10%' }, steps: [`Weight (lb) = length (in) × girth² (in) ÷ ${x.shape}`, `= ${num(Li)} × ${num(Gi)}² ÷ ${x.shape} = ${num(lb)} lb`] };
        },
    },
    hull_speed: {
        type: 'calc',
        inputs: { lwl: ['Waterline length', 'length', 'ft', 30], k: N('Speed–length ratio', 1.34, 0.5) },
        out: 'speed',
        outUnit: 'knot',
        label: 'Hull speed',
        rows: { kmh: ['In km/h', 'speed'], note: 'Meaning' },
        run: (x) => {
            const kn = x.k * Math.sqrt(x.lwl / 0.3048);

            return { value: kn * 0.514444, sub: `${num(kn, 3)} knots`, rows: { kmh: [kn * 0.514444, 'speed'], note: 'A displacement hull’s practical top speed, where its bow wave is as long as the boat; planing hulls can exceed it' }, steps: ['Hull speed (knots) = 1.34 × √(waterline length in feet)', `= ${num(x.k)} × √${num(x.lwl / 0.3048)} = ${num(kn)} kn`] };
        },
    },
    kite_size: {
        type: 'calc',
        inputs: { w: ['Rider weight', 'mass', 'kg', 75], wind: ['Wind speed', 'speed', 'knot', 18], skill: ['Board and skill', 'select', { 2.2: 'Twin-tip, intermediate', 2.4: 'Beginner or larger board', 2.0: 'Advanced or small board' }, '2.2'] },
        label: 'Kite size',
        rows: { range: 'Wind range for that kite (roughly)', note: 'Safety' },
        run: (x) => {
            const kn = x.wind / 0.514444;
            const size = (x.w * Number(x.skill)) / kn;

            return { value: num(size, 3), unit: 'm²', sub: `For ${num(kn, 3)} knots`, rows: { range: `${num(kn * 0.85, 3)}–${num(kn * 1.25, 3)} knots`, note: 'Do not ride in gusty or offshore wind; take lessons with a school' }, steps: ['Kite size (m²) ≈ rider weight (kg) × factor ÷ wind (knots)', `= ${num(x.w)} × ${x.skill} ÷ ${num(kn)}`, 'A rule of thumb; kite design changes the right size'] };
        },
    },
    scuba_weight: {
        type: 'calc',
        inputs: { w: ['Body weight', 'mass', 'kg', 75], suit: ['Exposure suit', 'select', { 0: 'Swimsuit or skin', 0.05: '3 mm wetsuit', 0.08: '5 mm wetsuit', 0.1: '7 mm wetsuit', 0.12: 'Drysuit (plus 2–4 kg for undergarments)' }, '0.08'], tank: ['Cylinder', 'select', { 2: 'Aluminium 80 (floats when nearly empty)', 0: 'Steel 12 L', '-2': 'Steel 15 L (heavy)' }, '2'], water: ['Water', 'select', { salt: 'Salt water', fresh: 'Fresh water' }, 'salt'] },
        out: 'mass',
        outUnit: 'kg',
        label: 'Starting weight to carry',
        rows: { check: 'Check it', fresh: 'Fresh water' },
        run: (x) => {
            const base = x.w * Number(x.suit) + Number(x.tank);
            const total = Math.max(0, x.water === 'fresh' ? base - x.w * 0.025 : base);

            return { value: total, sub: 'A starting point only', rows: { check: 'At the surface with a nearly empty tank and an empty BCD you should float at eye level when breathing normally; adjust from there', fresh: x.water === 'fresh' ? 'Already reduced by about 2.5% of body weight' : 'Use about 2.5% of body weight less' }, steps: ['Training rule of thumb: a share of body weight by suit thickness, plus or minus the cylinder’s buoyancy', 'Every diver is different: always do a buoyancy check before diving'] };
        },
    },
    windsurf: {
        type: 'calc',
        inputs: { w: ['Sailor weight', 'mass', 'kg', 75], wind: ['Wind speed', 'speed', 'knot', 15], skill: ['Skill', 'select', { 1.34: 'Intermediate (planing)', 1.5: 'Beginner or light wind', 1.2: 'Advanced' }, '1.34'] },
        label: 'Sail size',
        rows: { board: 'Board volume guide', range: 'Wind range' },
        run: (x) => {
            const kn = x.wind / 0.514444;
            const sail = (x.w * Number(x.skill)) / kn;

            return { value: num(sail, 3), unit: 'm²', sub: `For ${num(kn, 3)} knots`, rows: { board: `About ${num(x.w + 60)}–${num(x.w + 100)} litres for learners; ${num(x.w + 20)}–${num(x.w + 40)} L once planing in footstraps`, range: `${num(kn * 0.8, 3)}–${num(kn * 1.2, 3)} knots` }, steps: ['Sail (m²) ≈ weight (kg) × factor ÷ wind (knots)', `= ${num(x.w)} × ${x.skill} ÷ ${num(kn)}`, 'A rule of thumb'] };
        },
    },
    css: {
        type: 'calc',
        inputs: { t400: ['400 m time (m:ss)', 'text', null, '7:00'], t200: ['200 m time (m:ss)', 'text', null, '3:20'] },
        label: 'Critical swim speed',
        rows: { speed: 'Speed', paces: 'Training paces per 100 m' },
        run: (x) => {
            const a = parseTime(x.t400);
            const b = parseTime(x.t200);

            if (!(a > b && b > 0)) {
                return { error: 'Type both times as m:ss; the 400 m must be slower than the 200 m.' };
            }

            const v = 200 / (a - b);

            return { value: `${fmtTime(100 / v)} /100 m`, sub: `${num(v, 3)} m/s`, rows: { speed: `${num(v, 3)} m/s`, paces: `Threshold ${fmtTime(100 / v)}; endurance ${fmtTime(100 / v + 5)}–${fmtTime(100 / v + 10)}` }, steps: ['CSS = (400 − 200) ÷ (T₄₀₀ − T₂₀₀)', `= 200 ÷ ${num(a - b)} s = ${num(v)} m/s`] };
        },
    },
    sac: {
        type: 'calc',
        inputs: { used: ['Pressure used', 'pressure', 'bar', 100], V: ['Cylinder size (water volume)', 'volume', 'l', 12], t: ['Time at depth', 'time', 'min', 30], depth: ['Average depth', 'length', 'm', 15], water: ['Water', 'select', { salt: 'Salt water', fresh: 'Fresh water' }, 'salt'] },
        label: 'RMV (surface air consumption)',
        rows: { sac: 'SAC rate (pressure per minute at the surface)', ata: 'Pressure at that depth', note: 'Important' },
        run: (x) => {
            const ata = 1 + x.depth / (x.water === 'salt' ? 10 : 10.3);
            const bar = x.used / 1e5;
            const litres = bar * x.V * 1000;
            const rmv = litres / (x.t / 60) / ata;

            return { value: num(rmv, 3), unit: 'L/min', sub: `${num((bar / (x.t / 60)) / ata, 3)} bar/min SAC`, rows: { sac: `${num((bar / (x.t / 60)) / ata, 3)} bar/min`, ata: `${num(ata, 3)} bar absolute`, note: 'For logging and learning; plan gas with your training agency’s rules and a reserve' }, steps: ['Gas used (surface litres) = pressure used × cylinder volume', 'RMV = litres ÷ minutes ÷ (1 + depth ÷ 10)', `= ${num(litres)} ÷ ${num(x.t / 60)} ÷ ${num(ata)} = ${num(rmv)} L/min`] };
        },
    },

    // Weightlifting ------------------------------------------------------------------------------
    five_three_one: {
        type: 'calc',
        inputs: { rm: N('One-rep max', 100, 1), tm: N('Training max (% of 1RM)', 90, 50), step: N('Round to (smallest jump)', 2.5, 0.25), unit: UNIT },
        label: 'Training max',
        rows: { rule: 'Rule' },
        grids: [['plan', 'Four-week cycle (sets × reps @ weight)']],
        run: (x) => {
            const tm = (x.rm * x.tm) / 100;
            const W = [[[65, 5], [75, 5], [85, '5+']], [[70, 3], [80, 3], [90, '3+']], [[75, 5], [85, 3], [95, '1+']], [[40, 5], [50, 5], [60, 5]]];
            const u = x.unit;

            return { value: `${num(roundTo(tm, x.step))} ${u}`, sub: `${num(x.tm)}% of ${num(x.rm)} ${u}`, rows: { rule: 'The last set of weeks 1–3 is “as many reps as possible” (the + sets); add 2.5 kg (upper) or 5 kg (lower body) to the training max each cycle' }, steps: ['Jim Wendler 5/3/1: percentages of the training max (90% of 1RM)'], grids: { plan: { columns: ['Set 1', 'Set 2', 'Set 3'], rows: W.map((wk, i) => ({ header: ['Week 1 (5s)', 'Week 2 (3s)', 'Week 3 (5/3/1)', 'Week 4 (deload)'][i], cells: wk.map(([p, r]) => `${r} × ${num(roundTo((tm * p) / 100, x.step))} ${u}`) })) } } };
        },
    },
    bench_1rm: {
        type: 'calc',
        inputs: { w: N('Weight lifted', 80, 1), r: N('Reps completed (1–12 best)', 5, 1), unit: UNIT },
        label: 'Estimated bench press 1RM',
        rows: { epley: 'Epley', brzycki: 'Brzycki', range: 'Range of formulas' },
        run: (x) => {
            const all = Object.values(ONE_RM).map(([, f]) => f(x.w, x.r));
            const avg = oneRm(x.w, x.r);

            return { value: `${num(avg, 4)} ${x.unit}`, sub: `From ${num(x.w)} ${x.unit} × ${num(x.r)}`, rows: { epley: `${num(ONE_RM.epley[1](x.w, x.r), 4)} ${x.unit}`, brzycki: `${num(ONE_RM.brzycki[1](x.w, x.r), 4)} ${x.unit}`, range: `${num(Math.min(...all), 4)}–${num(Math.max(...all), 4)} ${x.unit}` }, steps: ['Average of seven published 1RM equations (Epley, Brzycki, Lombardi, Lander, Mayhew, O’Conner, Wathan)', 'Most accurate for sets of 10 reps or fewer; an estimate'] };
        },
    },
    bench_pyramid: {
        type: 'calc',
        inputs: { rm: N('One-rep max', 100, 1), type: ['Pyramid', 'select', { up: 'Ascending (light to heavy)', down: 'Descending (heavy to light)', tri: 'Triangle (up then down)' }, 'up'], step: N('Round to', 2.5, 0.25), unit: UNIT },
        label: 'Top set',
        rows: { volume: 'Total volume' },
        grids: [['sets', 'Sets']],
        run: (x) => {
            let sets = [[60, 12], [70, 10], [75, 8], [80, 6], [85, 4]];

            if (x.type === 'down') {
                sets = [...sets].reverse();
            } else if (x.type === 'tri') {
                sets = [...sets, ...sets.slice(0, -1).reverse()];
            }

            const volume = sets.reduce((s, [p, r]) => s + roundTo((x.rm * p) / 100, x.step) * r, 0);

            return { value: `${num(roundTo(x.rm * 0.85, x.step))} ${x.unit} × 4`, sub: `${sets.length} sets`, rows: { volume: `${num(volume)} ${x.unit}` }, steps: ['Percentages of 1RM with matching rep targets (60% × 12 up to 85% × 4)', 'A common programming convention'], grids: { sets: { columns: ['Weight', 'Reps', '% 1RM'], rows: sets.map(([p, r], k) => ({ header: `Set ${k + 1}`, cells: [`${num(roundTo((x.rm * p) / 100, x.step))} ${x.unit}`, String(r), `${p}%`] })) } } };
        },
    },
    one_rm: {
        type: 'calc',
        inputs: { w: N('Weight lifted', 100, 1), r: N('Reps completed (1–12 best)', 5, 1), unit: UNIT },
        label: 'Estimated one-rep max',
        rows: Object.fromEntries(Object.entries(ONE_RM).map(([k, [n]]) => [k, n])),
        grids: [['pct', 'Percentages of your 1RM']],
        run: (x) => {
            if (x.r > 30) {
                return { error: 'Use a set of 30 reps or fewer; 1RM formulas are unreliable beyond that.' };
            }

            const avg = oneRm(x.w, x.r);

            return { value: `${num(avg, 4)} ${x.unit}`, sub: 'Average of seven formulas', rows: Object.fromEntries(Object.entries(ONE_RM).map(([k, [, f]]) => [k, `${num(f(x.w, x.r), 4)} ${x.unit}`])), steps: ['Epley: w(1 + r/30); Brzycki: w × 36 ÷ (37 − r); Lombardi: w × r^0.1; and four more', 'An estimate: reps to failure, technique and training history change it'], grids: { pct: { columns: ['Weight', 'Reps (approx.)'], rows: [100, 95, 90, 85, 80, 75, 70, 65, 60].map((p, k) => ({ header: `${p}%`, cells: [`${num((avg * p) / 100, 4)} ${x.unit}`, ['1', '2', '4', '6', '8', '10', '12', '15', '20'][k]] })) } } };
        },
    },
    wilks: {
        type: 'calc',
        inputs: { sex: SEX, bw: ['Body weight', 'mass', 'kg', 90], total: ['Total lifted', 'mass', 'kg', 600] },
        data: ['strength'],
        label: 'Wilks score',
        rows: { coef: 'Wilks coefficient', dots: 'DOTS (for comparison)' },
        run: (x, ctx) => {
            const [a, b, c, d, e, f] = ctx.c.data.sports.strength.wilks[x.sex];
            const w = x.bw;
            const coef = 500 / (a + b * w + c * w ** 2 + d * w ** 3 + e * w ** 4 + f * w ** 5);
            const [da, db, dc, dd, de] = ctx.c.data.sports.strength.dots[x.sex];
            const dots = (x.total * 500) / (da * w ** 4 + db * w ** 3 + dc * w ** 2 + dd * w + de);

            return { value: num(x.total * coef, 5), sub: `${num(x.total)} kg at ${num(w)} kg body weight`, rows: { coef: num(coef, 5), dots: num(dots, 5) }, steps: ['Wilks = total × 500 ÷ (a + b·bw + c·bw² + d·bw³ + e·bw⁴ + f·bw⁵), weights in kg', `coefficient = ${num(coef, 6)}`] };
        },
    },
    dots: {
        type: 'calc',
        inputs: { sex: SEX, bw: ['Body weight', 'mass', 'kg', 90], total: ['Total lifted', 'mass', 'kg', 600] },
        data: ['strength'],
        label: 'DOTS score',
        rows: { coef: 'DOTS coefficient', band: 'Rough level' },
        run: (x, ctx) => {
            const [a, b, c, d, e] = ctx.c.data.sports.strength.dots[x.sex];
            const w = x.bw;
            const coef = 500 / (a * w ** 4 + b * w ** 3 + c * w ** 2 + d * w + e);
            const s = x.total * coef;

            return { value: num(s, 5), sub: 'Body-weight-adjusted strength (2019)', rows: { coef: num(coef, 5), band: s >= 500 ? 'Elite' : s >= 400 ? 'Advanced' : s >= 300 ? 'Intermediate' : 'Novice' }, steps: ['DOTS = total × 500 ÷ (a·bw⁴ + b·bw³ + c·bw² + d·bw + e)', `= ${num(x.total)} × ${num(coef, 6)}`] };
        },
    },
    ipf_gl: {
        type: 'calc',
        inputs: { sex: SEX, event: ['Event', 'select', { classic_powerlifting: 'Classic (raw) powerlifting', equipped_powerlifting: 'Equipped powerlifting', classic_bench: 'Classic bench press', equipped_bench: 'Equipped bench press' }, 'classic_powerlifting'], bw: ['Body weight', 'mass', 'kg', 90], total: ['Total (or bench result)', 'mass', 'kg', 600] },
        data: ['strength'],
        label: 'IPF GL points',
        rows: { coef: 'Coefficient' },
        run: (x, ctx) => {
            const [A, B, C] = ctx.c.data.sports.strength.ipf_gl[x.event][x.sex];
            const coef = 100 / (A - B * Math.exp(-C * x.bw));

            return { value: num(x.total * coef, 5), sub: ctx.c.data.sports.strength.ipf_gl[x.event].name, rows: { coef: num(coef, 6) }, steps: ['IPF GL = total × 100 ÷ (A − B·e^(−C·bw))', `A = ${A}, B = ${B}, C = ${C}`, `= ${num(x.total * coef)}`] };
        },
    },
    plates: {
        type: 'calc',
        inputs: { target: N('Target weight', 102.5, 0), bar: N('Bar weight', 20, 0), set: ['Plates you have (each size, comma separated)', 'text', null, '25, 20, 15, 10, 5, 2.5, 1.25'], unit: UNIT },
        label: 'Plates on each side',
        rows: { loaded: 'Weight loaded', off: 'Difference from the target' },
        run: (x) => {
            const sizes = String(x.set).split(/[,\s]+/).map(Number).filter((v) => v > 0).sort((a, b) => b - a);
            let side = (x.target - x.bar) / 2;

            if (side < 0) {
                return { error: 'The target is lighter than the bar.' };
            }

            const used = [];

            for (const p of sizes) {
                while (side >= p - 1e-9) {
                    used.push(p);
                    side -= p;
                }
            }

            const loaded = x.bar + 2 * used.reduce((a, b) => a + b, 0);

            return { value: used.length ? used.join(' + ') : 'Bar only', sub: `${num(loaded)} ${x.unit} loaded`, rows: { loaded: `${num(loaded)} ${x.unit}`, off: Math.abs(x.target - loaded) < 1e-9 ? 'Exact' : `${num(x.target - loaded)} ${x.unit} short` }, steps: ['Each side = (target − bar) ÷ 2, filled with the largest plates first', `= ${num((x.target - x.bar) / 2)} ${x.unit} per side`] };
        },
    },
    rpe: {
        type: 'calc',
        inputs: { w: N('Weight lifted', 140, 1), r: N('Reps', 5, 1), rpe: ['RPE', 'select', { 10: '10 (no reps left)', 9.5: '9.5', 9: '9 (one rep left)', 8.5: '8.5', 8: '8 (two reps left)', 7.5: '7.5', 7: '7 (three reps left)', 6.5: '6.5' }, '8'], unit: UNIT },
        label: 'Estimated 1RM',
        rows: { pct: 'That set as % of 1RM' },
        grids: [['table', 'Loads for other reps and RPE']],
        run: (x) => {
            const rpe = Number(x.rpe);
            const pct = rpePercent(x.r, rpe);

            if (!Number.isFinite(pct) || x.r > 12) {
                return { error: 'Use 1–12 reps.' };
            }

            const rm = (x.w * 100) / pct;

            return { value: `${num(rm, 4)} ${x.unit}`, sub: `${num(x.w)} × ${num(x.r)} @ RPE ${rpe}`, rows: { pct: `${num(pct, 4)}%` }, steps: ['RPE chart (Tuchscherer, Reactive Training Systems): each RPE point below 10 is one rep in reserve', `1RM = weight ÷ ${num(pct)}%`, 'An estimate'], grids: { table: { columns: ['RPE 7', 'RPE 8', 'RPE 9', 'RPE 10'], rows: [1, 2, 3, 4, 5, 6, 8, 10].map((n) => ({ header: `${n} reps`, cells: [7, 8, 9, 10].map((e) => `${num((rm * rpePercent(n, e)) / 100, 4)}`) })) } } };
        },
    },

    // Other sports -------------------------------------------------------------------------------
    arrow_foc: {
        type: 'calc',
        inputs: { L: ['Arrow length (nock throat to end of shaft)', 'length', 'in', 29], B: ['Balance point from the nock throat', 'length', 'in', 16.5] },
        label: 'Front of centre (FOC)',
        rows: { centre: ['Centre of the arrow', 'length'], use: 'Typical' },
        run: (x) => {
            const foc = (100 * (x.B - x.L / 2)) / x.L;

            return { value: `${num(foc, 3)}%`, sub: foc < 7 ? 'Low FOC' : foc > 15 ? 'High FOC' : 'In the common range', rows: { centre: [x.L / 2, 'length'], use: 'Target arrows about 7–12%; hunting arrows often 10–15% or more' }, steps: ['FOC = 100 × (balance point − length ÷ 2) ÷ length (AMO/ATA method)', `= 100 × (${num(x.B / 0.0254)} − ${num(x.L / 0.0254 / 2)}) ÷ ${num(x.L / 0.0254)}`] };
        },
    },
    elo: {
        type: 'calc',
        inputs: { R: N('Your rating', 1600, 0), O: N('Opponent rating', 1700, 0), result: ['Result', 'select', { 1: 'Win', 0.5: 'Draw', 0: 'Loss' }, '1'], K: ['K-factor', 'select', { 40: '40 (new players, juniors under 2300)', 20: '20 (standard)', 10: '10 (rated 2400 or more)' }, '20'] },
        label: 'New rating',
        rows: { E: 'Expected score', change: 'Change' },
        run: (x) => {
            const diff = Math.max(-400, Math.min(400, x.O - x.R));
            const E = 1 / (1 + 10 ** (diff / 400));
            const change = Number(x.K) * (Number(x.result) - E);

            return { value: num(x.R + change, 6), sub: `${change >= 0 ? '+' : ''}${num(change, 3)} points`, rows: { E: num(E, 4), change: `${change >= 0 ? '+' : ''}${num(change, 4)}` }, steps: ['FIDE: E = 1 ÷ (1 + 10^((R_opp − R) ÷ 400)), differences capped at 400', `ΔR = K × (score − E) = ${x.K} × (${x.result} − ${num(E, 4)}) = ${num(change)}`] };
        },
    },
    football_calories: {
        type: 'calc',
        inputs: { act: ['Level', 'select', 'data:mets:fixed:soccer_casual,soccer_comp', 'soccer_comp'], w: ['Body weight', 'mass', 'kg', 75], t: ['Minutes played', 'time', 'min', 90] },
        data: ['mets'],
        label: 'Calories burned',
        rows: { perHour: 'Per hour', distance: 'Distance a World Cup outfield player covers' },
        run: (x, ctx) => {
            const m = ctx.c.data.sports.mets[x.act];
            const minutes = x.t / 60;
            const E = (m.met * 3.5 * x.w * minutes) / 200;

            return { value: num(E, 4), unit: 'kcal', sub: m.name, rows: { perHour: `${num((E / minutes) * 60, 4)} kcal`, distance: 'About 10–13 km per 90 minutes (FIFA tracking data)' }, steps: ['kcal = MET × 3.5 × kg × minutes ÷ 200', `= ${m.met} × 3.5 × ${num(x.w)} × ${num(minutes)} ÷ 200`, 'An estimate'] };
        },
    },
    heptathlon: combined('heptathlon', [['100mh', '100 m hurdles (s)', '13.50'], ['hj', 'High jump (m)', '1.80'], ['sp', 'Shot put (m)', '14.00'], ['200m', '200 m (s)', '24.20'], ['lj', 'Long jump (m)', '6.30'], ['jt', 'Javelin (m)', '45.00'], ['800m', '800 m (m:ss.ss)', '2:12.00']]),
    decathlon: combined('decathlon', [['100m', '100 m (s)', '10.90'], ['lj', 'Long jump (m)', '7.40'], ['sp', 'Shot put (m)', '14.50'], ['hj', 'High jump (m)', '2.00'], ['400m', '400 m (s)', '49.00'], ['110mh', '110 m hurdles (s)', '14.40'], ['dt', 'Discus (m)', '45.00'], ['pv', 'Pole vault (m)', '4.80'], ['jt', 'Javelin (m)', '60.00'], ['1500m', '1500 m (m:ss.ss)', '4:30.00']]),
    pool_room: {
        type: 'calc',
        inputs: { table: ['Table', 'select', { 7: '7 ft (playing surface 39 × 78 in)', 8: '8 ft (44 × 88 in)', 9: '9 ft (50 × 100 in)' }, '8'], cue: ['Cue length', 'length', 'in', 58] },
        out: 'length',
        outUnit: 'ft',
        label: 'Minimum room length',
        rows: { width: ['Minimum room width', 'length'], shorter: 'With a 52 in cue' },
        run: (x) => {
            const [w, l] = { 7: [39, 78], 8: [44, 88], 9: [50, 100] }[x.table].map((v) => v * 0.0254);
            const s = 52 * 0.0254;

            return { value: l + 2 * x.cue, sub: `${num((w + 2 * x.cue) / 0.3048, 3)} ft wide`, rows: { width: [w + 2 * x.cue, 'length'], shorter: `${num((l + 2 * s) / 0.3048, 3)} × ${num((w + 2 * s) / 0.3048, 3)} ft` }, steps: ['Room = playing surface + 2 × cue length in each direction (Billiard Congress of America guidance)', 'Measure to walls and furniture that would block a stroke'] };
        },
    },
    ski_size: {
        type: 'calc',
        inputs: { h: ['Height', 'length', 'cm', 175], level: ['Ability', 'select', { beginner: 'Beginner', intermediate: 'Intermediate', advanced: 'Advanced', expert: 'Expert' }, 'intermediate'], style: ['Skiing', 'select', { piste: 'On piste', all: 'All-mountain', powder: 'Powder or freeride' }, 'all'], weight: ['Build', 'select', { light: 'Light for my height', average: 'Average', heavy: 'Heavy for my height' }, 'average'] },
        out: 'length',
        outUnit: 'cm',
        label: 'Ski length',
        rows: { range: 'Range to try', note: 'Note' },
        run: (x) => {
            const base = { beginner: -15, intermediate: -10, advanced: -5, expert: 0 }[x.level] + { piste: -5, all: 0, powder: 5 }[x.style] + { light: -5, average: 0, heavy: 5 }[x.weight];
            const L = x.h * 100 + base;

            return { value: L / 100, sub: 'Between chin and head height for most skiers', rows: { range: `${num(L - 5)}–${num(L + 5)} cm`, note: 'Rocker, turn radius and the shop’s advice matter; this is a rule of thumb' }, steps: ['Start from your height, shorter for beginners (about chin height) and longer for experts (about head height)', '± 5 cm for build and style'] };
        },
    },
    tennis_balls: {
        type: 'calc',
        inputs: { sessions: N('Sessions a week', 3, 0), hours: N('Hours per session', 1.5, 0), life: N('Hours of play a can lasts', 3, 0.5), price: ['Price of a can (3 or 4 balls)', 'money', null, 5], weeks: N('Weeks played a year', 46, 1) },
        label: 'Cans a year',
        rows: { cost: 'Cost a year', perHour: 'Cost per hour of play', perWeek: 'Cans a week' },
        run: (x) => {
            const hoursYear = x.sessions * x.hours * x.weeks;
            const cans = hoursYear / x.life;

            return { value: num(Math.ceil(cans), 4), sub: `${num(hoursYear)} hours of tennis`, rows: { cost: formatMoney(Math.ceil(cans) * x.price), perHour: formatMoney(x.price / x.life), perWeek: num(cans / x.weeks, 3) }, steps: ['Cans = hours played a year ÷ hours a can lasts', `= ${num(hoursYear)} ÷ ${num(x.life)} = ${num(cans)} (rounded up)`, 'Balls go flat at different rates; club players often change every 2–4 hours of play'] };
        },
    },
    golf_handicap: {
        type: 'calc',
        inputs: { rounds: ['Rounds: adjusted gross score, course rating, slope (one per line, newest first)', 'textarea', null, '88, 71.2, 128\n92, 70.4, 125\n85, 71.2, 128\n90, 72.0, 131\n87, 70.4, 125\n91, 71.2, 128'], cr: N('Course rating of the tee you play next (optional)', 71.2), slope: N('Slope of that tee (optional)', 128, 55), par: N('Par of that course (optional)', 72) },
        optional: ['cr', 'slope', 'par'],
        label: 'Handicap Index',
        rows: { used: 'Differentials used', course: 'Course handicap for the next tee' },
        run: (x) => {
            const rows = String(x.rounds).split(/\n|;/).map((l) => l.trim()).filter(Boolean).map((l) => l.split(/[,\s]+/).map(Number));

            if (rows.length < 3 || rows.some((r) => r.length !== 3 || !r.every(Number.isFinite) || r[2] < 55 || r[2] > 155)) {
                return { empty: 'Enter at least 3 rounds as score, course rating, slope (slope 55–155).' };
            }

            const recent = rows.slice(0, 20);
            const diffs = recent.map(([s, c, sl]) => Math.round(((113 / sl) * (s - c)) * 10) / 10);
            const [, count, adj] = [...WHS].reverse().find(([n]) => recent.length >= n);
            const best = [...diffs].sort((a, b) => a - b).slice(0, count);
            const index = Math.min(54, Math.floor((best.reduce((a, b) => a + b, 0) / count + adj) * 10 + 0.5 + 1e-9) / 10);
            const ch = Number.isFinite(x.cr) && Number.isFinite(x.slope) && Number.isFinite(x.par) ? Math.round(index * (x.slope / 113) + (x.cr - x.par)) : NaN;

            return { value: index.toFixed(1), sub: `Lowest ${count} of ${recent.length} differentials${adj ? `, ${adj} adjustment` : ''}`, rows: { used: best.map((d) => d.toFixed(1)).join(', '), course: Number.isFinite(ch) ? `${ch}` : 'Enter rating, slope and par' }, steps: ['Score differential = (113 ÷ slope) × (adjusted gross score − course rating), rounded to 0.1 (no playing-conditions adjustment)', 'World Handicap System: average of the lowest 8 of the last 20 (fewer when you have fewer scores)', 'Course handicap = index × slope ÷ 113 + (course rating − par)'] };
        },
    },
    bowling_score: {
        type: 'calc',
        inputs: { rolls: ['Rolls (X strike, / spare, - miss, or pin counts)', 'text', null, 'X 7/ 9- X X X 8/ X X XXX'] },
        label: 'Total score',
        rows: { frames: 'Frames completed', strikes: 'Strikes' },
        grids: [['card', 'Score card']],
        run: (x) => {
            const r = bowling(x.rolls);

            if (!r || !r.frames.length) {
                return { error: 'Type the rolls such as X 7/ 9- … (a frame cannot knock down more than 10 pins).' };
            }

            const strikes = (String(x.rolls).toUpperCase().match(/X/g) ?? []).length;

            return { value: num(r.total), sub: r.frames.length === 10 && r.frames[9].done ? 'Complete game' : 'Game in progress', rows: { frames: `${r.frames.length} of 10`, strikes: `${strikes}` }, steps: ['Strike: 10 + next two rolls; spare: 10 + next roll; open frame: pins knocked down', 'The 10th frame allows bonus rolls after a strike or spare'], grids: { card: { columns: ['Frame score', 'Running total'], rows: r.frames.map((f, k) => ({ header: `Frame ${k + 1}`, cells: [String(f.score), f.done ? String(f.total) : '…'] })) } } };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
