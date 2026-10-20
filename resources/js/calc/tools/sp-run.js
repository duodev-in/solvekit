import { defineTools } from '../engines/formula.js';
import { handlersFor, num } from '../physics/core.js';
import { fmtTime, KM_PER_MI, paceText, parseTime, RACES, raceTime, speedForVo2, vdot } from '../sports/time.js';

/**
 * Running and triathlon: pace, race prediction (Riegel, Daniels VDOT), splits, steps and stride, triathlon planning.
 */
const N = (label, value, min = 0) => [label, null, null, value, min];
const T = (label, value) => [label, 'text', null, value];
const RACE_OPTIONS = Object.fromEntries(Object.entries(RACES).map(([k, v]) => [k, v[0]]));
const timeError = { error: 'Type times as h:mm:ss or mm:ss, such as 25:30 or 1:45:00.' };
const SEX = ['Sex', 'select', { male: 'Male', female: 'Female' }, 'male'];

/** Race distance in metres from a select (or custom distance). */
const raceMetres = (x) => (x.race === 'custom' ? x.dist : RACES[x.race][1]);
const RACE_INPUT = { race: ['Race distance', 'select', { ...RACE_OPTIONS, custom: 'Other distance' }, '5k'], dist: ['Distance', 'length', 'km', 7] };
const RACE_SHOW = { dist: 'race:custom' };
const RACE_WHEN = { dist: (x) => x.race === 'custom' };
const predictGrid = (fn) => ({ columns: ['Time', 'Pace'], rows: ['mile', '5k', '10k', 'half', 'marathon'].map((k) => ({ header: RACES[k][0], cells: [fmtTime(fn(RACES[k][1])), `${fmtTime(fn(RACES[k][1]) / (RACES[k][1] / 1000))} /km`] })) });

export const TOOLS = {
    magic_mile: {
        type: 'calc',
        inputs: { mile: T('Magic mile time (m:ss)', '8:00') },
        label: 'Marathon goal pace',
        rows: { k5: '5 km race pace', k10: '10 km race pace', half: 'Half marathon pace', mar: 'Marathon pace', long: 'Long-run pace (marathon pace + 2 min)' },
        run: (x) => {
            const m = parseTime(x.mile);

            if (!(m > 0)) {
                return timeError;
            }

            const per = (s) => `${fmtTime(s)} /mi (${fmtTime(s / KM_PER_MI)} /km)`;

            return { value: per(m * 1.3), sub: 'Jeff Galloway Magic Mile', rows: { k5: per(m + 33), k10: per(m * 1.15), half: per(m * 1.2), mar: per(m * 1.3), long: per(m * 1.3 + 120) }, steps: ['Run one hard mile, then: 5K pace = mile + 33 s; 10K = × 1.15; half = × 1.2; marathon = × 1.3 (per mile)', 'Galloway’s guide for realistic goals; an estimate'] };
        },
    },
    marathon_pace: {
        type: 'calc',
        inputs: { which: ['Race', 'select', { marathon: 'Marathon (42.195 km)', half: 'Half marathon (21.0975 km)' }, 'marathon'], goal: T('Goal time (h:mm:ss)', '4:00:00') },
        label: 'Pace',
        rows: { speed: 'Speed', mile: 'Per mile' },
        grids: [['splits', 'Splits every 5 km']],
        run: (x) => {
            const t = parseTime(x.goal, 3600);
            const d = RACES[x.which][1];

            if (!(t > 0)) {
                return timeError;
            }

            const pace = t / (d / 1000);
            const marks = [];

            for (let k = 5000; k < d; k += 5000) {
                marks.push(k);
            }

            marks.push(d);

            return { value: `${fmtTime(pace)} /km`, sub: `${fmtTime(pace * KM_PER_MI)} per mile`, rows: { speed: `${num(d / t * 3.6, 4)} km/h (${num((d / t) * 3.6 / KM_PER_MI, 4)} mph)`, mile: `${fmtTime(pace * KM_PER_MI)} /mi` }, steps: ['Pace = time ÷ distance', `= ${fmtTime(t)} ÷ ${num(d / 1000)} km`], grids: { splits: { columns: ['Time'], rows: marks.map((m) => ({ header: m === d ? 'Finish' : `${m / 1000} km`, cells: [fmtTime(pace * (m / 1000))] })) } } };
        },
    },
    pace: {
        type: 'calc',
        inputs: { want: ['Find', 'select', { pace: 'Pace', time: 'Time', dist: 'Distance' }, 'pace'], d: ['Distance', 'length', 'km', 5], t: T('Time (h:mm:ss)', '25:00'), p: T('Pace per km (m:ss)', '5:00') },
        show: { d: 'want:pace,time', t: 'want:pace,dist', p: 'want:time,dist' },
        when: { d: (x) => x.want !== 'dist' },
        label: 'Result',
        rows: { pace: 'Pace', speed: 'Speed', time: 'Time', dist: 'Distance' },
        run: (x) => {
            let d = x.d;
            let t = parseTime(x.t);
            let p = parseTime(x.p);

            if (x.want === 'pace') {
                p = t / (d / 1000);
            } else if (x.want === 'time') {
                t = p * (d / 1000);
            } else {
                d = (t / p) * 1000;
            }

            if (!(p > 0 && t > 0 && d > 0)) {
                return timeError;
            }

            const label = { pace: 'Pace', time: 'Time', dist: 'Distance' }[x.want];
            const value = { pace: `${fmtTime(p)} /km`, time: fmtTime(t), dist: `${num(d / 1000, 5)} km` }[x.want];

            return { value, label, sub: `${num(d / 1000, 5)} km in ${fmtTime(t)}`, rows: { pace: paceText(p), speed: `${num((d / t) * 3.6, 4)} km/h (${num((d / t) * 3.6 / KM_PER_MI, 4)} mph)`, time: fmtTime(t), dist: `${num(d / 1000, 5)} km (${num(d / 1000 / KM_PER_MI, 5)} mi)` }, steps: ['pace = time ÷ distance; time = pace × distance; distance = time ÷ pace'] };
        },
    },
    race_predictor: {
        type: 'calc',
        inputs: { ...RACE_INPUT, t: T('Your time (h:mm:ss)', '25:00'), target: ['Predict for', 'select', RACE_OPTIONS, 'half'] },
        show: RACE_SHOW,
        when: RACE_WHEN,
        label: 'Predicted time (Riegel)',
        rows: { vdot: 'Daniels VDOT prediction', pace: 'Predicted pace' },
        grids: [['all', 'Predictions (Riegel)']],
        run: (x) => {
            const d1 = raceMetres(x);
            const t1 = parseTime(x.t);

            if (!(t1 > 0)) {
                return timeError;
            }

            const riegel = (d2) => t1 * (d2 / d1) ** 1.06;
            const d2 = RACES[x.target][1];
            const V = vdot(d1, t1);

            return { value: fmtTime(riegel(d2)), sub: RACES[x.target][0], rows: { vdot: `${fmtTime(raceTime(V, d2))} (VDOT ${num(V, 3)})`, pace: `${fmtTime(riegel(d2) / (d2 / 1000))} /km` }, steps: ['Riegel (1981): T₂ = T₁ × (D₂ ÷ D₁)^1.06', `= ${fmtTime(t1)} × (${num(d2 / 1000)} ÷ ${num(d1 / 1000)})^1.06`, 'Assumes training for the longer distance; marathon predictions from short races are often optimistic'], grids: { all: predictGrid(riegel) } };
        },
    },
    race_improvement: {
        type: 'calc',
        inputs: { ...RACE_INPUT, now: T('Current time (h:mm:ss)', '25:00'), goal: T('Goal time (h:mm:ss)', '23:30'), weeks: N('Weeks of training', 12, 1) },
        show: RACE_SHOW,
        when: RACE_WHEN,
        label: 'Improvement needed',
        rows: { pace: 'Pace change per km', perWeek: 'Per week', realism: 'How realistic' },
        run: (x) => {
            const d = raceMetres(x);
            const a = parseTime(x.now);
            const b = parseTime(x.goal);

            if (!(a > 0 && b > 0)) {
                return timeError;
            }

            const pct = ((a - b) / a) * 100;

            return { value: `${num(pct, 3)}%`, sub: `${fmtTime(a - b)} faster`, rows: { pace: `${fmtTime(a / (d / 1000))} → ${fmtTime(b / (d / 1000))} /km`, perWeek: `${num(pct / x.weeks, 3)}% (${num((a - b) / x.weeks, 3)} s) a week`, realism: pct / (x.weeks / 12) <= 3 ? 'Realistic for most runners in a training block' : pct / (x.weeks / 12) <= 6 ? 'Ambitious' : 'Very ambitious; consider a longer timeline' }, steps: ['Improvement = (current − goal) ÷ current', `= ${num(pct)}%`, 'A guide: steady training often brings 1–3% per 12-week block (more for newer runners)'] };
        },
    },
    running_pace: {
        type: 'calc',
        inputs: { by: ['I know', 'select', { kmpace: 'Pace per km', mipace: 'Pace per mile', kmh: 'Speed in km/h', mph: 'Speed in mph' }, 'kmpace'], pace: T('Pace (m:ss)', '5:30'), speed: N('Speed', 11, 0.1) },
        show: { pace: 'by:kmpace,mipace', speed: 'by:kmh,mph' },
        when: { speed: (x) => ['kmh', 'mph'].includes(x.by) },
        label: 'Pace per km',
        rows: { mi: 'Pace per mile', kmh: 'km/h', mph: 'mph', m400: '400 m lap' },
        grids: [['races', 'Finish times at this pace']],
        run: (x) => {
            let p = { kmpace: parseTime(x.pace), mipace: parseTime(x.pace) / KM_PER_MI, kmh: 3600 / x.speed, mph: 3600 / (x.speed * KM_PER_MI) }[x.by];

            if (!(p > 0)) {
                return timeError;
            }

            return { value: `${fmtTime(p)} /km`, sub: `${num(3600 / p, 4)} km/h`, rows: { mi: `${fmtTime(p * KM_PER_MI)} /mi`, kmh: num(3600 / p, 4), mph: num(3600 / p / KM_PER_MI, 4), m400: fmtTime(p * 0.4, true) }, steps: ['km/h = 3,600 ÷ seconds per km; 1 mile = 1.609344 km'], grids: { races: { columns: ['Finish time'], rows: ['5k', '10k', 'half', 'marathon'].map((k) => ({ header: RACES[k][0], cells: [fmtTime(p * (RACES[k][1] / 1000))] })) } } };
        },
    },
    running_split: {
        type: 'calc',
        inputs: { ...RACE_INPUT, t: T('Goal time (h:mm:ss)', '50:00'), split: ['Split every', 'length', 'km', 1], neg: N('Negative split: second half faster by (%)', 0) },
        show: RACE_SHOW,
        when: RACE_WHEN,
        label: 'Average pace',
        rows: { halves: 'First and second half' },
        grids: [['splits', 'Split times']],
        run: (x) => {
            const d = raceMetres(x);
            const t = parseTime(x.t);

            if (!(t > 0) || !(x.split > 0)) {
                return timeError;
            }

            const f = x.neg / 100;
            const p1 = (t / (d / 1000)) * (1 + f / 2);
            const p2 = (t / (d / 1000)) * (1 - f / 2);
            const at = (m) => (m <= d / 2 ? p1 * (m / 1000) : p1 * (d / 2000) + p2 * ((m - d / 2) / 1000));
            const marks = [];

            for (let m = x.split; m < d - 1e-6 && marks.length < 200; m += x.split) {
                marks.push(m);
            }

            marks.push(d);

            return { value: `${fmtTime(t / (d / 1000))} /km`, sub: x.neg ? `First half ${fmtTime(p1)} /km, second ${fmtTime(p2)} /km` : 'Even pace', rows: { halves: `${fmtTime(at(d / 2))} + ${fmtTime(t - at(d / 2))}` }, steps: ['Even split: pace = time ÷ distance', 'Negative split: the halves’ paces differ by the chosen percentage, keeping the same total'], grids: { splits: { columns: ['Split', 'Cumulative'], rows: marks.map((m, k) => ({ header: m === d ? 'Finish' : `${num(m / 1000, 4)} km`, cells: [fmtTime(at(m) - (k ? at(marks[k - 1]) : 0)), fmtTime(at(m))] })) } } };
        },
    },
    steps_km: {
        type: 'calc',
        inputs: { steps: N('Steps', 10000, 1), mode: ['Activity', 'select', { walk: 'Walking', run: 'Running' }, 'walk'], by: ['Stride from', 'select', { height: 'My height', stride: 'My measured step length' }, 'height'], h: ['Height', 'length', 'cm', 170], s: ['Step length', 'length', 'cm', 70] },
        show: { h: 'by:height', s: 'by:stride' },
        when: { h: (x) => x.by === 'height', s: (x) => x.by === 'stride' },
        out: 'length',
        outUnit: 'km',
        label: 'Distance',
        rows: { step: ['Step length used', 'length'], per: 'Steps per km' },
        run: (x) => {
            const step = x.by === 'stride' ? x.s : x.h * (x.mode === 'walk' ? 0.415 : 0.65);

            return { value: x.steps * step, sub: `${num(x.steps)} steps of ${num(step * 100, 3)} cm`, rows: { step: [step, 'length'], per: num(1000 / step, 4) }, steps: ['Distance = steps × step length', x.by === 'height' ? `Step ≈ ${x.mode === 'walk' ? '0.415' : '0.65'} × height (a common estimate)` : 'Measured step length', `= ${num(x.steps)} × ${num(step)} m`] };
        },
    },
    steps_miles: {
        type: 'calc',
        inputs: { steps: N('Steps', 10000, 1), mode: ['Activity', 'select', { walk: 'Walking', run: 'Running' }, 'walk'], h: ['Height', 'length', 'in', 67] },
        out: 'length',
        outUnit: 'mi',
        label: 'Distance',
        rows: { per: 'Steps per mile', step: ['Step length used', 'length'] },
        run: (x) => {
            const step = x.h * (x.mode === 'walk' ? 0.415 : 0.65);

            return { value: x.steps * step, sub: `About ${num(1609.344 / step, 4)} steps per mile`, rows: { per: num(1609.344 / step, 4), step: [step, 'length'] }, steps: [`Step ≈ ${x.mode === 'walk' ? '0.415' : '0.65'} × height (a common estimate)`, `Distance = ${num(x.steps)} × ${num(step)} m`] };
        },
    },
    stride: {
        type: 'calc',
        inputs: { by: ['I know', 'select', { measure: 'Distance and steps', height: 'Only my height' }, 'measure'], d: ['Distance covered', 'length', 'm', 100], steps: N('Steps taken', 130, 1), h: ['Height', 'length', 'cm', 170], pace: T('Running pace per km (optional, m:ss)', '5:30') },
        show: { d: 'by:measure', steps: 'by:measure', h: 'by:height' },
        when: { d: (x) => x.by === 'measure', steps: (x) => x.by === 'measure', h: (x) => x.by === 'height' },
        out: 'length',
        outUnit: 'cm',
        label: 'Step length',
        rows: { stride: ['Stride length (two steps)', 'length'], cadence: 'Cadence at that pace' },
        run: (x) => {
            const step = x.by === 'measure' ? x.d / x.steps : x.h * 0.415;
            const p = parseTime(x.pace);

            return { value: step, sub: x.by === 'height' ? 'Walking estimate from height' : 'Measured', rows: { stride: [2 * step, 'length'], cadence: p > 0 ? `${num((1000 / step) / (p / 60), 3)} steps per minute` : 'Enter a pace' }, steps: ['Step length = distance ÷ steps (a stride is two steps)', x.by === 'height' ? 'Estimate: 0.415 × height' : `= ${num(x.d)} ÷ ${num(x.steps)} m`] };
        },
    },
    training_pace: {
        type: 'calc',
        inputs: { ...RACE_INPUT, t: T('Recent race time (h:mm:ss)', '25:00') },
        show: RACE_SHOW,
        when: RACE_WHEN,
        label: 'VDOT',
        rows: { E: 'Easy (E)', M: 'Marathon (M)', T: 'Threshold (T)', I: 'Interval (I)', R: 'Repetition (R)' },
        run: (x) => {
            const t = parseTime(x.t);

            if (!(t > 0)) {
                return timeError;
            }

            const V = vdot(raceMetres(x), t);
            const at = (p) => 60000 / speedForVo2(V * p);
            const I = at(0.975);
            const M = raceTime(V, 42195) / 42.195;

            return { value: num(V, 3), sub: 'Training paces per km (per mile in brackets)', rows: { E: `${fmtTime(at(0.7))}–${fmtTime(at(0.62))} /km`, M: paceText(M), T: paceText(at(0.88)), I: paceText(I), R: `${fmtTime(I - 15)} /km (${fmtTime((I - 15) * 0.4, true)} per 400 m)` }, steps: ['VDOT from the race (Daniels & Gilbert): VO₂ = −4.60 + 0.182258v + 0.000104v²; %VO₂max = 0.8 + 0.1894393e^(−0.012778t) + 0.2989558e^(−0.1932605t)', 'Paces at about 62–70% (E), marathon race pace (M), 88% (T), 97.5% (I) of VDOT; R about 6 s per 400 m faster than I', 'Close to the tables in Daniels’ Running Formula'] };
        },
    },
    vo2_runners: {
        type: 'calc',
        inputs: { ...RACE_INPUT, t: T('Race time (h:mm:ss)', '25:00') },
        show: RACE_SHOW,
        when: RACE_WHEN,
        label: 'VDOT (effective VO₂max)',
        rows: { note: 'Meaning' },
        grids: [['equiv', 'Equivalent race times']],
        run: (x) => {
            const t = parseTime(x.t);

            if (!(t > 0)) {
                return timeError;
            }

            const V = vdot(raceMetres(x), t);

            return { value: num(V, 3), unit: 'ml/kg/min', sub: 'Daniels VDOT from your race', rows: { note: 'VDOT reflects running economy too, so it can differ from a lab VO₂max' }, steps: ['Velocity v (m/min) and time t (min) from the race', 'VO₂ = −4.60 + 0.182258v + 0.000104v²', '%max = 0.8 + 0.1894393e^(−0.012778t) + 0.2989558e^(−0.1932605t)', `VDOT = VO₂ ÷ %max = ${num(V)}`], grids: { equiv: predictGrid((d) => raceTime(V, d)) } };
        },
    },
    treadmill: {
        type: 'calc',
        inputs: { v: ['Treadmill speed', 'speed', 'kmh', 10], incline: N('Incline (%)', 2), w: ['Body weight (for calories)', 'mass', 'kg', 70] },
        label: 'Equivalent flat pace',
        rows: { tread: 'Treadmill pace', vo2: 'Oxygen use', kcal: 'Calories per hour', note: 'Note' },
        run: (x) => {
            const v = x.v * 60;
            const vo2 = 0.2 * v + 0.9 * v * (x.incline / 100) + 3.5;
            const vFlat = (vo2 - 3.5) / 0.2;

            return { value: `${fmtTime(60000 / vFlat)} /km`, sub: `${num(vFlat * 0.06, 4)} km/h on the flat`, rows: { tread: `${fmtTime(60000 / v)} /km`, vo2: `${num(vo2, 3)} ml/kg/min`, kcal: `${num(((vo2 * x.w) / 1000) * 5 * 60, 4)} kcal`, note: 'Many runners set 1% incline to match outdoor air resistance (Jones & Doust 1996)' }, steps: ['ACSM running equation: VO₂ = 0.2v + 0.9v × grade + 3.5', 'Equal-effort flat speed: v_flat = (VO₂ − 3.5) ÷ 0.2', 'An estimate'] };
        },
    },
    cooper: {
        type: 'calc',
        inputs: { d: ['Distance in 12 minutes', 'length', 'm', 2400], age: N('Age', 30, 1), sex: SEX },
        label: 'Estimated VO₂max',
        rows: { rating: 'Rating', pace: 'Average pace' },
        run: (x) => {
            const v = (x.d - 504.9) / 44.73;
            const adj = x.sex === 'female' ? 300 : 0;
            const r = x.d + adj;
            const rating = x.age < 30 ? (r >= 2800 ? 'Excellent' : r >= 2400 ? 'Above average' : r >= 2200 ? 'Average' : 'Below average') : r >= 2700 ? 'Excellent' : r >= 2300 ? 'Above average' : r >= 1900 ? 'Average' : 'Below average';

            return { value: num(v, 3), unit: 'ml/kg/min', sub: `${num(x.d)} m in 12 minutes`, rows: { rating: `${rating} (approximate Cooper bands)`, pace: `${fmtTime(720 / (x.d / 1000))} /km` }, steps: ['Cooper (1968): VO₂max = (distance in m − 504.9) ÷ 44.73', `= (${num(x.d)} − 504.9) ÷ 44.73 = ${num(v)}`] };
        },
    },

    // Triathlon ----------------------------------------------------------------------------------
    tri_time: {
        type: 'calc',
        inputs: { dist: ['Distance', 'select', { sprint: 'Sprint (750 m, 20 km, 5 km)', olympic: 'Olympic (1.5 km, 40 km, 10 km)', half: '70.3 (1.9 km, 90 km, 21.1 km)', full: 'Full (3.8 km, 180 km, 42.2 km)' }, 'olympic'], swim: T('Swim pace per 100 m (m:ss)', '2:00'), t1: T('T1 transition (m:ss)', '3:00'), bike: ['Bike average speed', 'speed', 'kmh', 28], t2: T('T2 transition (m:ss)', '2:00'), run: T('Run pace per km (m:ss)', '5:30') },
        label: 'Finishing time',
        rows: { swim: 'Swim', t1: 'T1', bike: 'Bike', t2: 'T2', run: 'Run' },
        run: (x) => {
            const [s, b, r] = { sprint: [750, 20000, 5000], olympic: [1500, 40000, 10000], half: [1900, 90000, 21097.5], full: [3800, 180000, 42195] }[x.dist];
            const sw = (parseTime(x.swim) * s) / 100;
            const bk = b / x.bike;
            const rn = (parseTime(x.run) * r) / 1000;
            const [t1, t2] = [parseTime(x.t1), parseTime(x.t2)];

            if (![sw, rn, t1, t2].every((v) => v >= 0)) {
                return timeError;
            }

            const total = sw + t1 + bk + t2 + rn;

            return { value: fmtTime(total), sub: 'Sum of the legs and transitions', rows: { swim: fmtTime(sw), t1: fmtTime(t1), bike: fmtTime(bk), t2: fmtTime(t2), run: fmtTime(rn) }, steps: ['Time = swim + T1 + bike + T2 + run', `= ${[sw, t1, bk, t2, rn].map((v) => fmtTime(v)).join(' + ')} = ${fmtTime(total)}`] };
        },
    },
    sports_drink: {
        type: 'calc',
        inputs: { V: ['Bottle size', 'volume', 'ml', 750], carb: N('Carbohydrate concentration (%)', 6, 0), na: N('Sodium (mmol per litre)', 30, 0) },
        out: 'mass',
        outUnit: 'g',
        label: 'Sugar to add',
        rows: { salt: 'Table salt to add', kcal: 'Energy', sodium: 'Sodium', note: 'Guidance' },
        run: (x) => {
            const litres = x.V * 1000;
            const sugar = (x.carb / 100) * litres * 1000;
            const naMg = x.na * 22.99 * litres;
            const salt = (x.na * 58.44 * litres) / 1000;

            return { value: sugar / 1000, sub: `${num(sugar, 3)} g sugar and ${num(salt, 3)} g salt per ${num(litres * 1000)} ml`, rows: { salt: `${num(salt, 3)} g (about ${num(salt / 6, 2)} teaspoon)`, kcal: `${num(sugar * 4, 4)} kcal`, sodium: `${num(naMg, 4)} mg`, note: '6–8% carbohydrate and 20–50 mmol/L sodium for exercise over about an hour (ACSM position stand on fluid replacement); a mix of glucose and fructose suits higher intakes' }, steps: ['Sugar (g) = % × volume (ml) ÷ 100', 'Salt (g) = sodium mmol/L × 58.44 g/mol × litres ÷ 1,000', `= ${num(sugar)} g sugar, ${num(salt)} g salt`] };
        },
    },
    tri_hr_zones: {
        type: 'calc',
        inputs: { run: N('Running lactate-threshold heart rate', 170, 1), bike: N('Cycling lactate-threshold heart rate', 162, 1) },
        label: 'Run and bike zones',
        rows: { swim: 'Swimming' },
        grids: [['zones', 'Joe Friel heart-rate zones']],
        run: (x) => {
            const runZ = [[0, 0.85], [0.85, 0.89], [0.9, 0.94], [0.95, 0.99], [1, 1.02], [1.03, 1.06], [1.06, null]];
            const bikeZ = [[0, 0.81], [0.81, 0.89], [0.9, 0.93], [0.94, 0.99], [1, 1.02], [1.03, 1.06], [1.06, null]];
            const fmt = (l, [a, b]) => (b === null ? `${Math.round(l * a)}+` : a === 0 ? `under ${Math.round(l * b)}` : `${Math.round(l * a)}–${Math.round(l * b)}`);
            const names = ['1 Recovery', '2 Aerobic', '3 Tempo', '4 Sub-threshold', '5a Super-threshold', '5b Aerobic capacity', '5c Anaerobic capacity'];

            return { value: `${Math.round(x.run)} / ${Math.round(x.bike)} bpm`, sub: 'Threshold heart rates (run / bike)', rows: { swim: 'Use perceived effort or pace (CSS): heart rate is lower in water' }, steps: ['Friel zones as % of lactate-threshold heart rate (LTHR)', 'Find LTHR with a 30-minute solo time trial: average HR of the last 20 minutes (× 0.95 on the bike)'], grids: { zones: { columns: ['Run (bpm)', 'Bike (bpm)'], rows: names.map((n, k) => ({ header: n, cells: [fmt(x.run, runZ[k]), fmt(x.bike, bikeZ[k])] })) } } };
        },
    },
    tri_nutrition: {
        type: 'calc',
        inputs: { hours: T('Expected race time (h:mm)', '5:30'), w: ['Body weight', 'mass', 'kg', 70], sweat: ['Sweat rate', 'volume', 'l', 0.8] },
        label: 'Carbohydrate per hour',
        rows: { carbTotal: 'Carbohydrate in total', fluid: 'Fluid per hour', sodium: 'Sodium per hour', pre: 'Before the race' },
        run: (x) => {
            const h = parseTime(x.hours, 3600) / 3600;

            if (!(h > 0)) {
                return timeError;
            }

            const [lo, hi] = h < 1 ? [0, 0] : h < 2.5 ? [30, 60] : [60, 90];
            const fluid = Math.min(x.sweat * 1000 * 0.8 * 1000, 1000);

            return { value: h < 1 ? 'None needed' : `${lo}–${hi} g`, sub: `For about ${num(h, 3)} hours`, rows: { carbTotal: `${num(lo * h)}–${num(hi * h)} g`, fluid: `About ${num(fluid, 3)} ml (replace most, not all, sweat loss)`, sodium: '300–600 mg (more in heat or for salty sweaters)', pre: `${num(1 * x.w, 3)}–${num(4 * x.w, 3)} g carbohydrate 1–4 hours before (1–4 g/kg)` }, steps: ['ACSM and ISSN guidance: under 1 h none needed; 1–2.5 h 30–60 g/h; over 2.5 h up to 90 g/h from mixed glucose and fructose', 'Practise race fuelling in training; an estimate, not medical advice'] };
        },
    },
    tri_training: {
        type: 'calc',
        inputs: { dist: ['Race', 'select', { sprint: 'Sprint', olympic: 'Olympic', half: '70.3', full: 'Full distance' }, 'olympic'], hours: N('Hours a week you can train', 8, 1), weeks: N('Weeks until the race', 16, 4) },
        label: 'Weekly split at peak',
        rows: { swim: 'Swim', bike: 'Bike', run: 'Run', phases: 'Phases', taper: 'Taper' },
        run: (x) => {
            const [s, b, r] = { sprint: [0.25, 0.4, 0.35], olympic: [0.22, 0.45, 0.33], half: [0.18, 0.52, 0.3], full: [0.15, 0.55, 0.3] }[x.dist];
            const taper = { sprint: 1, olympic: 1, half: 2, full: 3 }[x.dist];
            const base = Math.max(1, Math.round((x.weeks - taper) * 0.5));
            const build = Math.max(1, x.weeks - taper - base);

            return { value: `${num(x.hours * s, 2)} / ${num(x.hours * b, 2)} / ${num(x.hours * r, 2)} h`, sub: 'Swim / bike / run hours a week', rows: { swim: `${num(x.hours * s, 2)} h (${num(s * 100)}%)`, bike: `${num(x.hours * b, 2)} h (${num(b * 100)}%)`, run: `${num(x.hours * r, 2)} h (${num(r * 100)}%)`, phases: `Base ${base} weeks, build ${build} weeks, with an easier week every 3–4`, taper: `${taper} week${taper > 1 ? 's' : ''}, cutting volume by 30–50%` }, steps: ['A common coaching convention: the bike share grows with race distance', 'A general guide, not a personal plan; build volume by no more than about 10% a week'] };
        },
    },
    sweat_rate: {
        type: 'calc',
        inputs: { before: ['Weight before', 'mass', 'kg', 70], after: ['Weight after', 'mass', 'kg', 69.2], drank: ['Fluid drunk', 'volume', 'ml', 500], urine: ['Urine passed', 'volume', 'ml', 0], t: ['Exercise time', 'time', 'min', 60] },
        out: 'volume',
        outUnit: 'l',
        label: 'Sweat rate per hour',
        rows: { loss: 'Body-weight loss', drink: 'Drink per hour to stay within 2% loss' },
        run: (x) => {
            const lost = (x.before - x.after) + x.drank * 1000 - x.urine * 1000;
            const hours = x.t / 3600;
            const rate = lost / hours / 1000;

            return { value: rate, sub: `${num(lost * 1000, 4)} ml of sweat in ${num(hours * 60)} minutes`, rows: { loss: `${num(((x.before - x.after) / x.before) * 100, 3)}% of body weight`, drink: `About ${num(Math.max(0, rate * 1000 - (0.02 * x.before) / hours) * 1000, 3)} ml` }, steps: ['Sweat (L) = weight lost (kg) + fluid drunk − urine (1 kg ≈ 1 L)', `= ${num(lost)} kg → ${num(rate)} L per hour`, 'ACSM: aim to lose no more than about 2% of body weight'] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
