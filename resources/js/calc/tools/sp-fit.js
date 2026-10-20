import { defineTools } from '../engines/formula.js';
import { handlersFor, K, num } from '../physics/core.js';
import { fmtTime, parseTime } from '../sports/time.js';

/**
 * Calories burned, overall fitness and performance: Compendium METs, ACSM and Pandolf equations, heart-rate methods.
 */
const met = (ctx, key) => ctx.c.data.sports.mets[key];
/** Gross energy (kcal) for a MET value, body mass (kg) and minutes. */
export const kcal = (MET, kg, minutes) => (MET * 3.5 * kg * minutes) / 200;
const N = (label, value, min = 0) => [label, null, null, value, min];
const WEIGHT = ['Body weight', 'mass', 'kg', 70];
const MIN = ['Duration', 'time', 'min', 30];
const SEX = ['Sex', 'select', { male: 'Male', female: 'Female' }, 'male'];
const pick = (keys, def) => ['Activity and effort', 'select', `data:mets:fixed:${keys.join(',')}`, def];
const fatNote = 'About 7,700 kcal of energy deficit corresponds to 1 kg of body fat (a rule of thumb)';

/** A Compendium-MET tool over a list of activity keys. */
function metTool({ keys, def, label = 'Calories burned', extraInputs = {}, extraRows = {}, extra }) {
    return {
        type: 'calc',
        inputs: { act: pick(keys, def), w: WEIGHT, t: MIN, ...extraInputs },
        data: ['mets'],
        label,
        rows: { perMin: 'Per minute', perHour: 'Per hour', met: 'MET value used', fat: 'Equivalent body fat', ...extraRows },
        run: (x, ctx) => {
            const m = met(ctx, x.act);
            const minutes = x.t / 60;
            const E = kcal(m.met, x.w, minutes);

            return { value: num(E, 4), unit: 'kcal', sub: `${m.name}, MET ${m.met}`, rows: { perMin: `${num(E / minutes, 3)} kcal`, perHour: `${num((E / minutes) * 60, 4)} kcal`, met: `${m.met} (Compendium ${m.code})`, fat: `${num((E / 7700) * 1000, 3)} g (${fatNote.toLowerCase()})`, ...(extra?.(x, E, m) ?? {}) }, steps: ['kcal = MET × 3.5 × weight (kg) × minutes ÷ 200', `= ${m.met} × 3.5 × ${num(x.w)} × ${num(minutes)} ÷ 200 = ${num(E)} kcal`, 'Gross energy (includes resting); an estimate: fitness, technique and body size change it'] };
        },
    };
}

/** Maximum heart rate by the chosen formula. */
export const MAX_HR = { tanaka: ['Tanaka (208 − 0.7 × age)', (a) => 208 - 0.7 * a], fox: ['Fox (220 − age)', (a) => 220 - a], gulati: ['Gulati, women (206 − 0.88 × age)', (a) => 206 - 0.88 * a], nes: ['Nes (211 − 0.64 × age)', (a) => 211 - 0.64 * a] };
const MAX_OPTIONS = Object.fromEntries(Object.entries(MAX_HR).map(([k, v]) => [k, v[0]]));
const HR_INPUTS = { age: N('Age', 35, 1), formula: ['Maximum heart rate from', 'select', { ...MAX_OPTIONS, known: 'A measured maximum' }, 'tanaka'], max: N('Measured maximum heart rate', 185, 1), rest: N('Resting heart rate (for Karvonen)', 60, 0) };
const HR_SHOW = { max: 'formula:known' };
const HR_WHEN = { max: (x) => x.formula === 'known' };
const hrMax = (x) => (x.formula === 'known' ? x.max : MAX_HR[x.formula][1](x.age));
const ZONES = [['Zone 1, recovery', 0.5, 0.6], ['Zone 2, endurance (fat-burning)', 0.6, 0.7], ['Zone 3, tempo', 0.7, 0.8], ['Zone 4, threshold', 0.8, 0.9], ['Zone 5, maximum', 0.9, 1.0]];

export const TOOLS = {
    // Calories burned ----------------------------------------------------------------------------
    burpee: {
        type: 'calc',
        inputs: { w: WEIGHT, n: N('Burpees', 100, 1), rate: N('Burpees per minute', 10, 1) },
        data: ['mets'],
        label: 'Calories burned',
        rows: { per: 'Per burpee', time: 'Time taken', met: 'MET value used' },
        run: (x, ctx) => {
            const m = met(ctx, 'calisthenics_vig');
            const minutes = x.n / x.rate;
            const E = kcal(m.met, x.w, minutes);

            return { value: num(E, 4), unit: 'kcal', sub: `${num(minutes, 3)} minutes of burpees`, rows: { per: `${num(E / x.n, 3)} kcal`, time: fmtTime(minutes * 60), met: `${m.met} (Compendium ${m.code}, vigorous calisthenics)` }, steps: ['kcal = MET × 3.5 × kg × minutes ÷ 200', `= ${m.met} × 3.5 × ${num(x.w)} × ${num(minutes)} ÷ 200 = ${num(E)} kcal`, 'An estimate'] };
        },
    },
    hr_calories: {
        type: 'calc',
        inputs: { sex: SEX, age: N('Age', 35, 1), w: WEIGHT, hr: N('Average heart rate', 145, 1), t: MIN },
        label: 'Calories burned',
        rows: { perMin: 'Per minute', note: 'Validity' },
        run: (x) => {
            const minutes = x.t / 60;
            const perMin = x.sex === 'male' ? (-55.0969 + 0.6309 * x.hr + 0.1988 * x.w + 0.2017 * x.age) / 4.184 : (-20.4022 + 0.4472 * x.hr - 0.1263 * x.w + 0.074 * x.age) / 4.184;

            if (!(perMin > 0)) {
                return { error: 'That heart rate is too low for the equation (it is meant for exercise, roughly 90–150 bpm and above).' };
            }

            return { value: num(perMin * minutes, 4), unit: 'kcal', sub: `${num(perMin, 3)} kcal per minute`, rows: { perMin: `${num(perMin, 3)} kcal`, note: 'Steady exercise heart rates; not for rest or very short efforts' }, steps: [x.sex === 'male' ? 'Keytel et al. (2005), men: kcal/min = (−55.0969 + 0.6309 HR + 0.1988 kg + 0.2017 age) ÷ 4.184' : 'Keytel et al. (2005), women: kcal/min = (−20.4022 + 0.4472 HR − 0.1263 kg + 0.074 age) ÷ 4.184', `= ${num(perMin)} kcal/min × ${num(minutes)} min`, 'An estimate'] };
        },
    },
    elliptical: metTool({ keys: ['elliptical'], def: 'elliptical' }),
    fat_zone: {
        type: 'calc',
        inputs: HR_INPUTS,
        show: HR_SHOW,
        when: HR_WHEN,
        label: 'Fat-burning zone',
        rows: { max: 'Maximum heart rate', pct: 'Simple % of maximum', note: 'About the fat-burning zone' },
        grids: [['zones', 'All five zones (Karvonen)']],
        run: (x) => {
            const max = hrMax(x);
            const hrr = max - x.rest;
            const z = (p) => Math.round(x.rest + p * hrr);

            return { value: `${z(0.6)}–${z(0.7)} bpm`, sub: '60–70% of heart-rate reserve (Karvonen)', rows: { max: `${num(max, 4)} bpm`, pct: `${Math.round(0.6 * max)}–${Math.round(0.7 * max)} bpm (60–70% of max)`, note: 'Fat supplies a larger share of energy at low intensity, but harder sessions burn more total energy; both help weight loss' }, steps: ['Karvonen: target = rest + % × (max − rest)', `Max ${num(max)} bpm, reserve ${num(hrr)} bpm`], grids: { zones: { columns: ['Heart rate'], rows: ZONES.map(([n, a, b]) => ({ header: n, cells: [`${z(a)}–${z(b)} bpm`], highlight: a === 0.6 })) } } };
        },
    },
    hiking: {
        type: 'calc',
        inputs: { w: WEIGHT, load: ['Pack weight', 'mass', 'kg', 8], d: ['Distance', 'length', 'km', 10], up: ['Total ascent', 'length', 'm', 500], v: ['Walking speed on the flat', 'speed', 'kmh', 4.5], terrain: ['Terrain', 'select', { 1.0: 'Paved road or treadmill', 1.1: 'Dirt road or good trail', 1.2: 'Light brush', 1.5: 'Heavy brush or rough trail', 1.8: 'Swampy bog', 2.1: 'Loose sand' }, '1.1'] },
        label: 'Calories burned',
        rows: { time: 'Hiking time (Naismith)', rate: 'Average energy rate', grade: 'Average grade uphill' },
        run: (x) => {
            const flatH = x.d / 1000 / (x.v * 3.6);
            const time = flatH + x.up / 600;
            const grade = (100 * x.up) / (x.d / 2);
            const v = x.v;
            const eta = Number(x.terrain);
            const W = x.w;
            const L = x.load;
            const P = (G) => 1.5 * W + 2 * (W + L) * (L / W) ** 2 + eta * (W + L) * (1.5 * v * v + 0.35 * v * G);
            const watts = (P(grade) + P(0)) / 2;
            const E = (watts * time * 3600) / 4184;

            return { value: num(E, 4), unit: 'kcal', sub: `About ${fmtTime(time * 3600)} of hiking`, rows: { time: fmtTime(time * 3600), rate: `${num(watts, 4)} W (${num((watts * 3600) / 4184, 4)} kcal/h)`, grade: `${num(grade, 3)}% over the climbing half` }, steps: ['Pandolf et al. (1977): M = 1.5W + 2(W + L)(L/W)² + η(W + L)(1.5v² + 0.35vG) watts', 'Half the distance climbing at the average grade, half on the flat (descent assumed level)', 'Time: Naismith’s rule, 1 hour per 5 km plus 1 hour per 600 m ascent', 'An estimate'] };
        },
    },
    jump_rope: metTool({ keys: ['rope_slow', 'rope_moderate', 'rope_fast'], def: 'rope_moderate' }),
    running_cal: {
        type: 'calc',
        inputs: { w: WEIGHT, d: ['Distance', 'length', 'km', 10], pace: ['Pace per km (mm:ss)', 'text', null, '5:30'], grade: N('Incline (%)', 0) },
        label: 'Calories burned',
        rows: { perKm: 'Per km', perMile: 'Per mile', vo2: 'Oxygen use', time: 'Running time' },
        run: (x) => {
            const sPerKm = parseTime(x.pace);

            if (!(sPerKm > 0)) {
                return { error: 'Type the pace as minutes:seconds per km, such as 5:30.' };
            }

            const v = 1000 / (sPerKm / 60);
            const vo2 = 0.2 * v + 0.9 * v * (x.grade / 100) + 3.5;
            const minutes = ((x.d / 1000) * sPerKm) / 60;
            const E = ((vo2 * x.w) / 1000) * 5 * minutes;

            return { value: num(E, 4), unit: 'kcal', sub: `${num(E / (x.d / 1000), 3)} kcal per km`, rows: { perKm: `${num(E / (x.d / 1000), 3)} kcal`, perMile: `${num((E / (x.d / 1000)) * 1.609344, 3)} kcal`, vo2: `${num(vo2, 3)} ml/kg/min`, time: fmtTime(minutes * 60) }, steps: ['ACSM running equation: VO₂ = 0.2v + 0.9v × grade + 3.5 (v in m/min)', `v = ${num(v)} m/min → VO₂ = ${num(vo2)} ml/kg/min`, 'kcal = VO₂ × kg ÷ 1000 × 5 kcal per litre of oxygen × minutes', `= ${num(E)} kcal (gross)`] };
        },
    },
    sauna: {
        type: 'calc',
        inputs: { w: WEIGHT, t: ['Time in the sauna', 'time', 'min', 15], MET: N('MET value (resting is 1.0–1.3)', 1.5, 1) },
        label: 'Calories burned',
        rows: { extra: 'Above sitting quietly', water: 'About the weight you lose' },
        run: (x) => {
            const minutes = x.t / 60;
            const E = kcal(x.MET, x.w, minutes);

            return { value: num(E, 3), unit: 'kcal', sub: 'Little more than resting', rows: { extra: `${num(E - kcal(1.3, x.w, minutes), 3)} kcal`, water: 'Weight lost in a sauna is sweat (water), regained when you drink, not fat' }, steps: ['kcal = MET × 3.5 × kg × minutes ÷ 200', `= ${num(x.MET)} × 3.5 × ${num(x.w)} × ${num(minutes)} ÷ 200`, 'Studies find heart rate rises in a sauna but energy use stays close to resting; the Compendium lists no sauna value, so the MET is your assumption'] };
        },
    },
    snow_shoveling: metTool({ keys: ['shovel_moderate', 'shovel_vigorous'], def: 'shovel_moderate', extraRows: { heart: 'Caution' }, extra: () => ({ heart: 'Shovelling heavy snow strains the heart; take breaks, especially if you have heart disease' }) }),
    stairs: metTool({ keys: ['stairs_slow', 'stairs_fast', 'stair_machine'], def: 'stairs_fast', extraInputs: { flights: N('Flights climbed (optional, 3 m each)', 20) }, extraRows: { work: 'Mechanical work of climbing' }, extra: (x) => ({ work: Number.isFinite(x.flights) ? `${num((x.w * K.g0 * x.flights * 3) / 1000, 4)} kJ (${num((x.w * K.g0 * x.flights * 3) / 4184, 3)} kcal; muscles are about 20–25% efficient)` : 'Enter flights' }) }),
    swimming: metTool({ keys: ['swim_free_light', 'swim_free_fast', 'swim_back', 'swim_breast', 'swim_fly', 'swim_leisure'], def: 'swim_free_light' }),
    walking_cal: {
        type: 'calc',
        inputs: { w: WEIGHT, load: ['Carried load', 'mass', 'kg', 0], d: ['Distance', 'length', 'km', 5], v: ['Speed', 'speed', 'kmh', 5], grade: N('Incline (%)', 0) },
        label: 'Calories burned',
        rows: { perKm: 'Per km', time: 'Walking time', vo2: 'Oxygen use' },
        run: (x) => {
            const v = x.v * 60;
            const vo2 = 0.1 * v + 1.8 * v * (x.grade / 100) + 3.5;
            const minutes = x.d / x.v / 60;
            const E = ((vo2 * (x.w + x.load)) / 1000) * 5 * minutes;

            return { value: num(E, 4), unit: 'kcal', sub: `${num(E / (x.d / 1000), 3)} kcal per km`, rows: { perKm: `${num(E / (x.d / 1000), 3)} kcal`, time: fmtTime(minutes * 60), vo2: `${num(vo2, 3)} ml/kg/min` }, steps: ['ACSM walking equation: VO₂ = 0.1v + 1.8v × grade + 3.5 (v in m/min, best for 50–100 m/min)', `VO₂ = ${num(vo2)} ml/kg/min, × (body + load) kg ÷ 1000 × 5 kcal/L × minutes`, `= ${num(E)} kcal (gross)`] };
        },
    },
    weight_loss: {
        type: 'calc',
        inputs: { sex: SEX, age: N('Age', 35, 15), h: ['Height', 'length', 'cm', 175], w: ['Current weight', 'mass', 'kg', 90], goal: ['Goal weight', 'mass', 'kg', 80], act: ['Activity', 'select', { 1.2: 'Sedentary', 1.375: 'Light exercise 1–3 days a week', 1.55: 'Moderate exercise 3–5 days', 1.725: 'Hard exercise 6–7 days', 1.9: 'Very hard exercise or physical job' }, '1.375'], intake: N('Daily calories you plan to eat', 2000, 800) },
        label: 'Time to reach the goal',
        rows: { tdee: 'Calories you burn now (TDEE)', deficit: 'Starting daily deficit', rate: 'First-week loss', end: 'Calories burned at the goal weight' },
        plots: [['weight', 'Projected weight']],
        run: (x) => {
            const bmr = (w) => 10 * w + 6.25 * x.h * 100 - 5 * x.age + (x.sex === 'male' ? 5 : -161);
            const tdee = (w) => bmr(w) * Number(x.act);

            if (!(x.goal < x.w)) {
                return { error: 'The goal weight must be below the current weight.' };
            }

            if (!(x.intake < tdee(x.w))) {
                return { error: `At ${num(x.intake)} kcal a day there is no deficit: you burn about ${num(tdee(x.w), 4)} kcal now.` };
            }

            let w = x.w;
            let weeks = 0;
            const series = [[0, w]];

            while (w > x.goal && weeks < 520) {
                const deficit = tdee(w) - x.intake;

                if (deficit <= 0) {
                    break;
                }

                w -= (deficit * 7) / 7700;
                weeks += 1;
                series.push([weeks, Math.max(w, x.goal)]);
            }

            if (w > x.goal) {
                return { error: `Weight levels off at about ${num(w, 3)} kg on this intake, above the goal. Eat a little less or move more.` };
            }

            const first = ((tdee(x.w) - x.intake) * 7) / 7700;

            return { value: `${weeks} weeks`, sub: `About ${num(weeks / 4.345, 3)} months`, rows: { tdee: `${num(tdee(x.w), 4)} kcal/day (Mifflin–St Jeor × activity)`, deficit: `${num(tdee(x.w) - x.intake, 4)} kcal/day`, rate: `${num(first, 3)} kg (${num((first / x.w) * 100, 2)}% of body weight; up to about 1% a week is a common guide)`, end: `${num(tdee(x.goal), 4)} kcal/day` }, steps: ['Each week: TDEE from Mifflin–St Jeor at the current weight × activity factor', 'Weight change = 7 × (TDEE − intake) ÷ 7,700 kcal per kg', 'Loss slows as weight falls because you burn less', 'An estimate; real loss also depends on water, muscle and adherence. Ask a doctor before very low-calorie diets'], plots: { weight: { series, axes: true, xLabel: 'Weeks', yLabel: 'Weight (kg)' } } };
        },
    },
    rowing_cal: {
        type: 'calc',
        inputs: { by: ['I know', 'select', { watts: 'Average watts (from the monitor)', effort: 'The effort' }, 'watts'], P: ['Average power', 'power', 'w', 150], act: pick(['row_light', 'row_moderate', 'row_vigorous'], 'row_moderate'), w: WEIGHT, t: MIN },
        show: { P: 'by:watts', act: 'by:effort' },
        when: { P: (x) => x.by === 'watts' },
        data: ['mets'],
        label: 'Calories burned',
        rows: { perHour: 'Per hour', method: 'Method' },
        run: (x, ctx) => {
            const minutes = x.t / 60;

            if (x.by === 'watts') {
                const perHour = 4 * 0.8604 * x.P + 300;

                return { value: num((perHour * minutes) / 60, 4), unit: 'kcal', sub: `${num(perHour, 4)} kcal per hour`, rows: { perHour: `${num(perHour, 4)} kcal`, method: 'Concept2 monitor formula: kcal/h = 4 × 0.8604 × watts + 300' }, steps: ['Concept2: kcal/h = 4 × 0.8604 × W + 300 (assumes 25% efficiency and a 300 kcal/h base)', `= ${num(perHour)} kcal/h × ${num(minutes / 60)} h`] };
            }

            const m = met(ctx, x.act);
            const E = kcal(m.met, x.w, minutes);

            return { value: num(E, 4), unit: 'kcal', sub: m.name, rows: { perHour: `${num((E / minutes) * 60, 4)} kcal`, method: `Compendium MET ${m.met} (${m.code})` }, steps: ['kcal = MET × 3.5 × kg × minutes ÷ 200', `= ${num(E)} kcal`] };
        },
    },
    yoga_cal: metTool({ keys: ['yoga_hatha', 'yoga_power', 'pilates'], def: 'yoga_hatha' }),

    // Overall fitness ----------------------------------------------------------------------------
    ape_index: {
        type: 'calc',
        inputs: { span: ['Arm span (fingertip to fingertip)', 'length', 'cm', 180], h: ['Height', 'length', 'cm', 175] },
        label: 'Ape index',
        rows: { diff: ['Span minus height', 'length'], note: 'Meaning' },
        run: (x) => ({ value: (x.span / x.h).toFixed(3), sub: `${x.span >= x.h ? '+' : '−'}${num(Math.abs(x.span - x.h) * 100, 3)} cm`, rows: { diff: [x.span - x.h, 'length'], note: x.span / x.h > 1.03 ? 'Long arms for your height: an advantage in climbing, swimming and boxing' : x.span / x.h < 0.98 ? 'Short arms for your height' : 'About average (span is usually close to height)' }, steps: ['Ape index = arm span ÷ height (also given as span − height)', `= ${num(x.span * 100)} ÷ ${num(x.h * 100)} = ${(x.span / x.h).toFixed(4)}`] }),
    },
    punch_force: {
        type: 'calc',
        inputs: { m: ['Effective mass behind the punch', 'mass', 'kg', 2.9], v: ['Fist speed at impact', 'speed', 'ms', 9], t: ['Contact time', 'short_time', 'ms', 8] },
        out: 'force',
        outUnit: 'n',
        label: 'Average punch force',
        rows: { kgf: 'As a weight', E: 'Kinetic energy of the fist', compare: 'For comparison' },
        run: (x) => {
            const F = (x.m * x.v) / x.t;

            return { value: F, sub: `${num(F / K.g0, 4)} kg-force`, rows: { kgf: `${num(F / K.g0, 4)} kg-force`, E: `${num(0.5 * x.m * x.v * x.v, 4)} J`, compare: 'Olympic boxers measured about 3,400 N on average (Walilko et al. 2005)' }, steps: ['Impulse: F = m_eff × v ÷ contact time', `= ${num(x.m)} × ${num(x.v)} ÷ ${num(x.t)} = ${num(F)} N`, 'An estimate: effective mass and contact time vary with technique'] };
        },
    },
    vertical_jump: {
        type: 'calc',
        inputs: { by: ['I know', 'select', { h: 'Jump height', t: 'Hang time' }, 'h'], h: ['Jump height', 'length', 'cm', 50], t: ['Hang time', 'short_time', 'ms', 640], m: ['Body mass', 'mass', 'kg', 75] },
        show: { h: 'by:h', t: 'by:t' },
        when: { h: (x) => x.by === 'h', t: (x) => x.by === 't' },
        out: 'length',
        outUnit: 'cm',
        label: 'Jump height',
        rows: { power: 'Peak power (Sayers)', v: 'Take-off speed', hang: 'Hang time', band: 'Rating' },
        run: (x) => {
            const h = x.by === 'h' ? x.h : (K.g0 * x.t * x.t) / 8;
            const pp = 60.7 * h * 100 + 45.3 * x.m - 2055;

            return { value: h, sub: `Peak power ${num(pp, 4)} W`, rows: { power: `${num(pp, 4)} W (${num(pp / x.m, 3)} W/kg)`, v: `${num(Math.sqrt(2 * K.g0 * h), 3)} m/s`, hang: `${num(Math.sqrt((8 * h) / K.g0), 3)} s`, band: h >= 0.7 ? 'Excellent' : h >= 0.5 ? 'Very good' : h >= 0.4 ? 'Above average' : h >= 0.3 ? 'Average' : 'Below average' }, steps: ['From hang time: h = g t² ÷ 8', 'Sayers et al. (1999): peak power = 60.7 × h(cm) + 45.3 × mass(kg) − 2055', `= ${num(pp)} W`] };
        },
    },

    // Performance --------------------------------------------------------------------------------
    anaerobic_threshold: {
        type: 'calc',
        inputs: { by: ['Method', 'select', { test: '30-minute time-trial heart rate (Friel)', pct: 'Percentage of maximum' }, 'pct'], sport: ['Sport', 'select', { run: 'Running', bike: 'Cycling' }, 'run'], avg: N('Average heart rate over the last 20 minutes', 165, 1), ...HR_INPUTS },
        show: { avg: 'by:test', age: 'by:pct', formula: 'by:pct', max: 'formula:known', rest: 'by:none' },
        when: { avg: (x) => x.by === 'test', age: (x) => x.by === 'pct', max: (x) => x.by === 'pct' && x.formula === 'known', rest: () => false },
        label: 'Anaerobic (lactate) threshold heart rate',
        rows: { range: 'Typical range', note: 'Method' },
        run: (x) => {
            if (x.by === 'test') {
                const lthr = x.sport === 'run' ? x.avg : x.avg * 0.95;

                return { value: `${Math.round(lthr)} bpm`, sub: x.sport === 'run' ? 'Running LTHR' : 'Cycling LTHR (95% of the 30-minute average)', rows: { range: `${Math.round(lthr * 0.98)}–${Math.round(lthr * 1.02)} bpm`, note: 'Joe Friel’s 30-minute solo time trial: average heart rate of the last 20 minutes' }, steps: ['LTHR = average HR of the last 20 minutes of a 30-minute all-out effort', x.sport === 'bike' ? 'Cycling: × 0.95' : 'Running: as measured'] };
            }

            const max = hrMax(x);

            return { value: `${Math.round(0.85 * max)}–${Math.round(0.9 * max)} bpm`, sub: '85–90% of maximum heart rate', rows: { range: `${Math.round(0.85 * max)}–${Math.round(0.9 * max)} bpm`, note: 'A rule of thumb; a lab or field test is more accurate' }, steps: [`Max HR ${num(max)} bpm`, 'Threshold ≈ 85–90% of max (an estimate)'] };
        },
    },
    bruce: {
        type: 'calc',
        inputs: { T: N('Time on the treadmill (minutes, decimals allowed)', 10, 0), sex: SEX },
        label: 'Estimated VO₂max',
        rows: { mets: 'METs', stage: 'Stage reached' },
        run: (x) => {
            const vo2 = x.sex === 'male' ? 14.76 - 1.379 * x.T + 0.451 * x.T ** 2 - 0.012 * x.T ** 3 : 4.38 * x.T - 3.9;
            const stage = Math.min(7, Math.floor(x.T / 3) + 1);

            return { value: num(vo2, 4), unit: 'ml/kg/min', sub: `${num(vo2 / 3.5, 3)} METs`, rows: { mets: num(vo2 / 3.5, 3), stage: `Stage ${stage} (3 minutes each)` }, steps: [x.sex === 'male' ? 'Foster et al. (1984): VO₂max = 14.76 − 1.379T + 0.451T² − 0.012T³' : 'Women (Bruce 1973): VO₂max = 4.38T − 3.90', `= ${num(vo2)} ml/kg/min; 1 MET = 3.5 ml/kg/min`, 'Valid for the standard Bruce protocol without holding the rails'] };
        },
    },
    erg: {
        type: 'calc',
        inputs: { by: ['I know', 'select', { split: 'Split per 500 m', watts: 'Watts', cal: 'Calories per hour' }, 'split'], split: ['Split per 500 m (m:ss.s)', 'text', null, '2:00.0'], P: N('Watts', 203, 1), cal: N('Calories per hour', 999, 301), d: ['Distance (for the finish time)', 'length', 'm', 2000] },
        show: { split: 'by:split', P: 'by:watts', cal: 'by:cal' },
        when: { P: (x) => x.by === 'watts', cal: (x) => x.by === 'cal' },
        label: 'Split per 500 m',
        rows: { watts: 'Watts', cal: 'Calories per hour', time: 'Time for the distance' },
        run: (x) => {
            let pace;

            if (x.by === 'split') {
                pace = parseTime(x.split) / 500;
            } else {
                const P = x.by === 'watts' ? x.P : (x.cal - 300) / (4 * 0.8604);
                pace = Math.cbrt(2.8 / P);
            }

            if (!(pace > 0)) {
                return { error: 'Type the split as minutes:seconds, such as 2:00.0.' };
            }

            const P = 2.8 / pace ** 3;

            return { value: fmtTime(pace * 500, true), sub: `${num(P, 4)} W`, rows: { watts: `${num(P, 4)} W`, cal: `${num(4 * 0.8604 * P + 300, 4)} cal/h`, time: fmtTime(pace * x.d, true) }, steps: ['Concept2: watts = 2.80 ÷ pace³ (pace in seconds per metre)', `pace = ${num(pace, 5)} s/m → ${num(P)} W`, 'cal/h = 4 × 0.8604 × watts + 300'] };
        },
    },
    heart_rate: {
        type: 'calc',
        inputs: { beats: N('Beats counted', 18, 1), sec: ['Counted for', 'select', { 10: '10 seconds', 15: '15 seconds', 20: '20 seconds', 30: '30 seconds', 60: '60 seconds' }, '15'], age: N('Age (for the resting range)', 35, 1) },
        label: 'Heart rate',
        rows: { range: 'Resting range for adults', note: 'Tip' },
        run: (x) => {
            const bpm = (x.beats * 60) / Number(x.sec);

            return { value: `${num(bpm, 3)} bpm`, sub: bpm < 60 ? 'Below 60 at rest (common in fit people)' : bpm > 100 ? 'Above 100 at rest' : 'Within the usual resting range', rows: { range: '60–100 bpm (American Heart Association); athletes often 40–60', note: 'Count at rest, sitting, for at least 30 seconds for accuracy' }, steps: ['bpm = beats × 60 ÷ seconds counted', `= ${num(x.beats)} × 60 ÷ ${x.sec} = ${num(bpm)}`] };
        },
    },
    hr_recovery: {
        type: 'calc',
        inputs: { peak: N('Heart rate at the end of exercise', 170, 1), one: N('After 1 minute', 145, 1), two: N('After 2 minutes (optional)', 125, 1) },
        optional: ['two'],
        label: 'One-minute heart-rate recovery',
        rows: { two: 'Two-minute recovery', note: 'What it suggests' },
        run: (x) => {
            const h1 = x.peak - x.one;
            const h2 = Number.isFinite(x.two) ? x.peak - x.two : NaN;

            return { value: `${num(h1)} bpm`, sub: h1 <= 12 ? 'Low (12 or less)' : h1 >= 25 ? 'Fast recovery' : 'Normal', rows: { two: Number.isFinite(h2) ? `${num(h2)} bpm${h2 <= 22 ? ' (low: 22 or less)' : ''}` : 'Enter a 2-minute value', note: 'A drop of 12 bpm or less in the first minute (with a cool-down walk) was linked to higher risk (Cole et al., NEJM 1999). Not a diagnosis' }, steps: ['HRR₁ = peak − heart rate after 1 minute', `= ${num(x.peak)} − ${num(x.one)} = ${num(h1)} bpm`] };
        },
    },
    hr_zones: {
        type: 'calc',
        inputs: { ...HR_INPUTS, method: ['Method', 'select', { karvonen: 'Karvonen (heart-rate reserve)', pct: 'Percentage of maximum' }, 'karvonen'] },
        show: { ...HR_SHOW, rest: 'method:karvonen' },
        when: { ...HR_WHEN, rest: (x) => x.method === 'karvonen' },
        label: 'Maximum heart rate',
        rows: { method: 'Method' },
        grids: [['zones', 'Training zones']],
        run: (x) => {
            const max = hrMax(x);
            const z = (p) => Math.round(x.method === 'karvonen' ? x.rest + p * (max - x.rest) : p * max);

            return { value: `${num(max, 4)} bpm`, sub: x.method === 'karvonen' ? `Reserve ${num(max - x.rest)} bpm` : '% of maximum', rows: { method: x.method === 'karvonen' ? 'Zone = rest + % × (max − rest)' : 'Zone = % × max' }, steps: [`Max HR from ${x.formula === 'known' ? 'your measurement' : MAX_HR[x.formula][0]}: ${num(max)} bpm`, 'Five zones at 50–60, 60–70, 70–80, 80–90 and 90–100%'], grids: { zones: { columns: ['Heart rate', 'Feels like'], rows: ZONES.map(([n, a, b], k) => ({ header: n, cells: [`${z(a)}–${z(b)} bpm`, ['Very easy', 'Easy, can talk', 'Moderate, short sentences', 'Hard, few words', 'All-out'][k]] })) } } };
        },
    },
    hiking_time: {
        type: 'calc',
        inputs: { d: ['Distance', 'length', 'km', 15], up: ['Ascent', 'length', 'm', 800], down: ['Descent', 'length', 'm', 800], speed: ['Flat walking speed', 'speed', 'kmh', 5], fit: ['Fitness and pack', 'select', { 1: 'Fit, light pack', 1.15: 'Average, day pack', 1.35: 'Heavy pack or slow group' }, '1.15'] },
        label: 'Walking time (Naismith)',
        rows: { tobler: 'Tobler’s hiking function (average-slope estimate)', breaks: 'With 10 minutes of rest per hour' },
        run: (x) => {
            const f = Number(x.fit);
            const steep = x.down / (x.d / 2) > 0.21;
            const base = x.d / 1000 / (x.speed * 3.6) + x.up / 600 + (steep ? (x.down / 300) * (10 / 60) : -(x.down / 300) * (10 / 60));
            const hours = Math.max(base, x.d / 1000 / (x.speed * 3.6)) * f;
            const slope = (x.up + x.down) / x.d;
            const tob = (x.d / 1000 / (6 * Math.exp(-3.5 * Math.abs(slope / 2 + 0.05)))) * f;

            return { value: fmtTime(hours * 3600), sub: `${num(hours, 3)} hours of walking`, rows: { tobler: fmtTime(tob * 3600), breaks: fmtTime(hours * 3600 * 1.2) }, steps: ['Naismith: 1 hour per 5 km (your flat speed) + 1 hour per 600 m of ascent', `Langmuir: ${steep ? 'add' : 'subtract'} 10 minutes per 300 m of ${steep ? 'steep' : 'gentle'} descent`, `× ${f} for fitness and load`, 'An estimate for planning; allow for weather and daylight'] };
        },
    },
    max_hr: {
        type: 'calc',
        inputs: { age: N('Age', 35, 1), sex: SEX },
        label: 'Maximum heart rate (Tanaka)',
        rows: { tanaka: 'Tanaka (208 − 0.7 × age)', fox: 'Fox (220 − age)', gulati: 'Gulati, women (206 − 0.88 × age)', nes: 'Nes (211 − 0.64 × age)', note: 'Accuracy' },
        run: (x) => {
            const t = MAX_HR.tanaka[1](x.age);

            return { value: `${Math.round(t)} bpm`, sub: x.sex === 'female' ? `Gulati gives ${Math.round(MAX_HR.gulati[1](x.age))} bpm for women` : 'Tanaka et al. (2001)', rows: { tanaka: `${Math.round(t)} bpm`, fox: `${Math.round(MAX_HR.fox[1](x.age))} bpm`, gulati: x.sex === 'female' ? `${Math.round(MAX_HR.gulati[1](x.age))} bpm` : 'For women', nes: `${Math.round(MAX_HR.nes[1](x.age))} bpm`, note: 'Individuals differ by ±10–12 bpm from any formula; a supervised test is exact' }, steps: ['Tanaka: HRmax = 208 − 0.7 × age', `= 208 − 0.7 × ${num(x.age)} = ${num(t)}`] };
        },
    },
    met_minutes: {
        type: 'calc',
        inputs: { list: ['Activities: MET value, minutes per week (one per line)', 'textarea', null, '3.5, 150\n8.0, 60\n6.0, 45'] },
        label: 'MET-minutes per week',
        rows: { goal: 'Against the WHO guideline', mod: 'Moderate minutes equivalent' },
        run: (x) => {
            const rows = String(x.list).split(/\n|;/).map((l) => l.trim()).filter(Boolean).map((l) => l.split(/[,\s]+/).map(Number));

            if (!rows.length || rows.some((r) => r.length !== 2 || !r.every((v) => v >= 0))) {
                return { empty: 'Type each activity as MET, minutes per week.' };
            }

            const total = rows.reduce((s, [m, t]) => s + m * t, 0);

            return { value: num(total, 5), sub: total >= 600 ? 'Meets the guideline' : `${num(600 - total)} short of 600`, rows: { goal: total >= 1200 ? 'Well above (≥ 1,200: extra benefit)' : total >= 600 ? 'Meets the minimum (600 MET-min)' : 'Below the minimum', mod: `${num(total / 4)} minutes at 4 METs` }, steps: ['MET-minutes = Σ MET × minutes', ...rows.map(([m, t]) => `${num(m)} × ${num(t)} = ${num(m * t)}`), 'WHO 2020: 150–300 minutes of moderate activity a week ≈ 600–1,200 MET-minutes'] };
        },
    },
    target_hr: {
        type: 'calc',
        inputs: { ...HR_INPUTS, lo: N('Intensity from (%)', 60, 0), hi: N('Intensity to (%)', 80, 0) },
        show: HR_SHOW,
        when: HR_WHEN,
        label: 'Target heart rate',
        rows: { max: 'Maximum heart rate', pct: 'Simple % of maximum', per10: 'Beats in 10 seconds' },
        run: (x) => {
            const max = hrMax(x);
            const k = (p) => Math.round(x.rest + (p / 100) * (max - x.rest));

            return { value: `${k(x.lo)}–${k(x.hi)} bpm`, sub: `${num(x.lo)}–${num(x.hi)}% of heart-rate reserve`, rows: { max: `${num(max, 4)} bpm`, pct: `${Math.round((x.lo / 100) * max)}–${Math.round((x.hi / 100) * max)} bpm`, per10: `${Math.round(k(x.lo) / 6)}–${Math.round(k(x.hi) / 6)}` }, steps: ['Karvonen: target = rest + intensity × (max − rest)', `= ${num(x.rest)} + ${num(x.lo / 100)}–${num(x.hi / 100)} × ${num(max - x.rest)}`] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
