import { formatMoney } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { addDays, parseDate, shortDate, toDays } from '../everyday/dates.js';
import { parseAmount } from '../food/kitchen.js';
import { navyBodyFat } from '../health/body.js';
import { parseRows } from '../rows-editor.js';

/**
 * Fitness, military standards, sleep, alcohol and smoking, and everyday health tools. Height arrives in metres,
 * mass in grams, temperatures in °C, dates as 'YYYY-MM-DD'.
 */
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
const f0 = (x) => (Number.isFinite(x) ? Math.round(x).toLocaleString('en-US') : '—');
const f1 = (x) => (Number.isFinite(x) ? x.toFixed(1) : '—');
const f2 = (x) => (Number.isFinite(x) ? x.toFixed(2) : '—');
const kgOf = (g) => g / 1000;
const LB = 453.59237;
const mmss = (s) => `${Math.floor(s / 60)}:${String(Math.round(s % 60)).padStart(2, '0')}`;
const parseTimeText = (text) => {
    const m = String(text ?? '').trim().match(/^(\d+):(\d{1,2})$/);

    return m ? Number(m[1]) * 60 + Number(m[2]) : Number.isFinite(Number(text)) && String(text).trim() !== '' ? Number(text) : NaN;
};

/** AFT points for one event: the highest table row whose standard the result meets. */
export function aftPoints(event, ageIndex, column, value) {
    const better = event.better;

    for (const [points, cells] of event.rows) {
        const cell = cells[ageIndex * 2 + column];

        if (cell === null || cell === undefined) {
            continue;
        }

        if (better === 'higher' ? value >= cell : value <= cell) {
            return points;
        }
    }

    return 0;
}

// Standard drink definitions: grams of pure alcohol (NIAAA, UK NHS, Australian NHMRC, WHO and others).
const STANDARD = { us: ['United States (NIAAA)', 14], uk: ['United Kingdom (unit)', 8], au: ['Australia (NHMRC)', 10], ca: ['Canada', 13.45], in: ['India (common definition)', 10], who: ['WHO', 10], ie: ['Ireland', 10], nz: ['New Zealand', 10] };
const ETHANOL = 0.789;

/** Widmark blood alcohol (g/100 mL, %) with Watson total body water; elimination 0.015%/h. */
export function bac({ grams, kg, cm, age, sex, hours }) {
    const tbw = sex === 'female' ? -2.097 + 0.1069 * cm + 0.2466 * kg : 2.447 - 0.09516 * age + 0.1074 * cm + 0.3362 * kg;
    // Widmark r = TBW ÷ (0.8 × weight); blood is about 80% water.
    const r = tbw / (0.8 * kg);
    const peak = (grams / (r * kg * 1000)) * 100;

    return { peak, now: Math.max(0, peak - 0.015 * hours), r };
}

const MILESTONES = [
    [20 / 1440, '20 minutes: heart rate and blood pressure drop'], [0.5, '12 hours: carbon monoxide in the blood falls to normal'], [14, '2 weeks to 3 months: circulation and lung function improve'],
    [30, '1 to 9 months: coughing and shortness of breath decrease'], [365, '1 year: the extra risk of coronary heart disease is half that of a smoker'], [5 * 365, '5–10 years: risk of mouth, throat and voice-box cancer drops by half; stroke risk falls'],
    [10 * 365, '10 years: lung cancer risk is about half that of someone still smoking'], [15 * 365, '15 years: risk of coronary heart disease is close to that of a non-smoker'],
];

export const handlers = {
    aft: (i, c) => {
        const aft = c.data.aft;
        const ages = [[17, 21], [22, 26], [27, 31], [32, 36], [37, 41], [42, 46], [47, 51], [52, 56], [57, 61], [62, 200]];
        const ageIndex = ages.findIndex(([a, b]) => i.age >= a && i.age <= b);

        if (ageIndex < 0) {
            return { empty: 'Enter an age of 17 or over.' };
        }

        // The combat standard is sex-neutral and uses the M|C column for everyone.
        const column = i.standard === 'combat' || i.sex !== 'female' ? 0 : 1;
        const results = { mdl: i.mdl, hrp: i.hrp, sdc: parseTimeText(i.sdc), plk: parseTimeText(i.plk), run: parseTimeText(i.run) };

        if (!Object.values(results).every(Number.isFinite)) {
            return { empty: 'Enter all five events (times as m:ss).' };
        }

        const standard = aft.standards[i.standard] ?? aft.standards.general;
        const scores = Object.fromEntries(Object.entries(results).map(([key, value]) => [key, aftPoints(aft.events[key], ageIndex, column, value)]));
        const total = Object.values(scores).reduce((a, b) => a + b, 0);
        const failed = Object.entries(scores).filter(([, points]) => points < standard.minimum);
        const pass = !failed.length && total >= standard.total;
        const show = (key, value) => (aft.events[key].unit === 'time' ? mmss(value) : `${value} ${aft.events[key].unit}`);

        return {
            value: String(total),
            unit: 'of 500',
            label: 'AFT total',
            sub: `${pass ? 'Pass' : 'Fail'}: ${standard.name}, 60 points in each event and ${standard.total} in total; age group ${aft.ages[ageIndex]}`,
            rows: { result: pass ? 'Pass' : failed.length ? `Below 60 on: ${failed.map(([key]) => aft.events[key].name).join(', ')}` : `Total below ${standard.total}`, standard: standard.name, source: aft.source },
            grids: { events: { columns: ['Result', 'Points'], rows: Object.entries(scores).map(([key, points]) => ({ header: aft.events[key].name, cells: [show(key, results[key]), String(points)], highlight: points < standard.minimum })) } },
        };
    },

    army_bodyfat: (i) => {
        const lb = kgOf(i.weight) * 2.20462;
        const inches = (i.abdomen * 100) / 2.54;

        if (!ok(lb, inches, i.age) || lb <= 0 || inches <= 0) {
            return { empty: 'Enter weight, abdominal circumference and age.' };
        }

        // AR 600-9 one-site tape (Army Directive 2023-11): abdomen at the navel, weight in pounds.
        const fat = i.sex === 'female' ? -9.15 - 0.015 * lb + 1.27 * inches : -26.97 - 0.12 * lb + 1.99 * inches;
        const limits = i.sex === 'female' ? [[20, 30], [27, 32], [39, 34], [200, 36]] : [[20, 20], [27, 22], [39, 24], [200, 26]];
        const limit = limits.find(([max]) => i.age <= max)[1];

        return {
            value: `${f1(Math.max(0, fat))}%`,
            label: 'Army body fat (one-site tape)',
            sub: `${fat <= limit ? 'Meets' : 'Exceeds'} the ${limit}% maximum for ${i.sex === 'female' ? 'women' : 'men'} aged ${i.age} (AR 600-9)`,
            rows: { limit: `${limit}%`, formula: i.sex === 'female' ? '−9.15 − 0.015 × weight (lb) + 1.27 × abdomen (in)' : '−26.97 − 0.12 × weight (lb) + 1.99 × abdomen (in)', exempt: 'Soldiers scoring 465+ on the AFT (80+ in each event) are exempt from body fat assessment' },
        };
    },

    navy_bodyfat: (i) => {
        const cm = i.height * 100;

        if (!ok(cm, i.neck, i.waist, i.age) || (i.sex === 'female' && !ok(i.hip))) {
            return { empty: i.sex === 'female' ? 'Enter height, neck, waist and hip.' : 'Enter height, neck and abdomen.' };
        }

        const fat = navyBodyFat({ sex: i.sex, height: cm, neck: i.neck * 100, waist: i.waist * 100, hip: or0(i.hip) * 100 });
        // OPNAVINST 6110.1J: maximum body fat 26% (men) and 36% (women) up to 39; 27% and 37% from 40.
        const limit = (i.sex === 'female' ? 36 : 26) + (i.age >= 40 ? 1 : 0);

        return { value: `${f1(fat)}%`, label: 'Navy body fat (circumference)', sub: `${fat <= limit ? 'Within' : 'Above'} the ${limit}% Navy standard for your age and sex`, rows: { limit: `${limit}% (OPNAVINST 6110.1J)`, method: 'US Navy circumference equation (Hodgdon & Beckett); men measure the abdomen at the navel, women the waist at its narrowest and the hips at their widest' } };
    },

    ahi: (i) => {
        if (!ok(i.apneas, i.hypopneas, i.hours) || i.hours <= 0) {
            return { empty: 'Enter apneas, hypopneas and hours of sleep.' };
        }

        const value = (i.apneas + i.hypopneas) / i.hours;
        const band = value < 5 ? 'Normal (under 5)' : value < 15 ? 'Mild sleep apnoea (5–14.9)' : value < 30 ? 'Moderate sleep apnoea (15–29.9)' : 'Severe sleep apnoea (30 or more)';

        return { value: f1(value), unit: 'events/h', label: 'Apnea-hypopnea index', sub: band, rows: { band, events: `${f0(i.apneas + i.hypopneas)} events in ${f1(i.hours)} h`, source: 'American Academy of Sleep Medicine severity bands' } };
    },

    sleep_debt: (i) => {
        const nights = String(i.nights ?? '').split(/[,\s]+/).map(Number).filter((x) => Number.isFinite(x) && x >= 0);
        const need = ok(i.need) ? i.need : 8;

        if (!nights.length) {
            return { empty: 'Enter the hours you slept each night (for example 6.5, 7, 5.5).' };
        }

        const debt = nights.reduce((sum, h) => sum + Math.max(0, need - h), 0);
        const average = nights.reduce((a, b) => a + b, 0) / nights.length;

        return {
            value: `${f1(debt)} h`,
            label: `Sleep debt over ${nights.length} nights`,
            sub: `Average ${f1(average)} h a night against a need of ${f1(need)} h`,
            rows: { average: `${f1(average)} h`, short: `${nights.filter((h) => h < 7).length} nights under 7 h`, recover: debt > 0 ? `Add about 1 hour a night for ${Math.ceil(debt)} nights, or sleep in a little on weekends` : 'No debt', guideline: 'Adults need at least 7 hours a night (AASM and Sleep Research Society 2015)' },
        };
    },

    alcohol_units: (i, c) => {
        const drinks = parseRows(i.drinks).map(([name, ml, abv, count]) => ({ name, ml: parseAmount(ml), abv: parseAmount(abv), count: parseAmount(count) || 1 })).filter((d) => d.name && ok(d.ml, d.abv));

        if (!drinks.length) {
            return { empty: 'Add drinks with their volume (ml) and strength (% ABV).' };
        }

        const country = STANDARD[i.country] ?? STANDARD[c.country ?? 'uk'];
        const grams = drinks.reduce((sum, d) => sum + d.ml * (d.abv / 100) * ETHANOL * d.count, 0);
        const units = drinks.reduce((sum, d) => sum + (d.ml * d.abv * d.count) / 1000, 0);

        return {
            value: c.mode === 'standard' ? f1(grams / country[1]) : f1(units),
            label: c.mode === 'standard' ? `Standard drinks (${country[0]})` : 'UK units of alcohol',
            sub: `${f0(grams)} g of pure alcohol in ${drinks.length} drink${drinks.length > 1 ? 's' : ''}`,
            rows: { grams: `${f0(grams)} g`, units: `${f1(units)} UK units (8 g each)`, us: `${f1(grams / 14)} US standard drinks (14 g)`, guideline: c.mode === 'standard' ? `${country[0]}: one standard drink is ${country[1]} g` : 'UK Chief Medical Officers: no more than 14 units a week, spread over 3 or more days' },
            grids: { drinks: { columns: ['Alcohol', 'UK units'], rows: drinks.map((d) => ({ header: `${d.count > 1 ? `${d.count} × ` : ''}${d.name}`, cells: [`${f0(d.ml * (d.abv / 100) * ETHANOL * d.count)} g`, f1((d.ml * d.abv * d.count) / 1000)] })) } },
        };
    },

    bac: (i) => {
        const kg = kgOf(i.weight);
        const cm = i.height * 100;
        const drinks = parseRows(i.drinks).map(([name, ml, abv, count]) => ({ name, ml: parseAmount(ml), abv: parseAmount(abv), count: parseAmount(count) || 1 })).filter((d) => d.name && ok(d.ml, d.abv));

        if (!drinks.length || !ok(kg, cm, i.age, i.hours) || kg <= 0) {
            return { empty: 'Add drinks and enter your height, weight, age and hours since the first drink.' };
        }

        const grams = drinks.reduce((sum, d) => sum + d.ml * (d.abv / 100) * ETHANOL * d.count, 0);
        const b = bac({ grams, kg, cm, age: i.age, sex: i.sex, hours: i.hours });
        const toZero = b.now / 0.015;

        return {
            value: `${b.now.toFixed(3)}%`,
            label: 'Estimated blood alcohol now',
            sub: `Peak about ${b.peak.toFixed(3)}%; back to zero in about ${f1(toZero)} more hours`,
            rows: { grams: `${f0(grams)} g of alcohol (${f1(grams / 14)} US standard drinks)`, limit: b.now >= 0.08 ? 'At or above 0.08%, the legal driving limit in most US states and the UK (England and Wales)' : b.now >= 0.05 ? 'At or above 0.05%, the limit in Scotland, Australia and much of Europe' : 'Below 0.05%', zero: `About ${f1(toZero)} hours`, warning: 'An estimate only: never use it to decide whether you can drive. Any alcohol impairs driving.' },
        };
    },

    cigarettes: (i) => {
        const perDay = or0(i.per_day);
        const years = or0(i.years);

        if (perDay <= 0 || years <= 0) {
            return { empty: 'Enter cigarettes a day and years of smoking.' };
        }

        const total = perDay * 365.25 * years;
        const packs = total / (or0(i.pack_size) || 20);
        const cost = packs * or0(i.price);

        return {
            value: f0(total),
            label: 'Cigarettes smoked',
            sub: `${f1((perDay / 20) * years)} pack-years; ${or0(i.price) ? `${formatMoney(cost)} spent` : 'enter a pack price for the cost'}`,
            rows: { packs: `${f0(packs)} packs`, cost: or0(i.price) ? `${formatMoney(cost)} (${formatMoney((perDay / (or0(i.pack_size) || 20)) * 365.25 * or0(i.price))} a year)` : 'Enter a price', packYears: f1((perDay / 20) * years), time: `About ${f0((total * 11) / 60 / 24)} days of life lost at 11 minutes per cigarette (Shaw et al. 2000, an average estimate)` },
        };
    },

    pack_years: (i) => {
        const packs = i.unit === 'cigarettes' ? i.amount / 20 : i.amount;

        if (!ok(packs, i.years) || packs <= 0 || i.years <= 0) {
            return { empty: 'Enter how much and for how many years.' };
        }

        const value = packs * i.years;

        return { value: f1(value), label: 'Pack-years', sub: `${f2(packs)} packs a day × ${f1(i.years)} years`, rows: { screening: value >= 20 ? 'Meets the 20 pack-year threshold for yearly lung cancer screening (USPSTF 2021) if aged 50–80 and smoked within the last 15 years' : 'Below the 20 pack-year screening threshold', cigarettes: `${f0(value * 20 * 365.25)} cigarettes in total` } };
    },

    recovery: (i) => {
        const quit = parseDate(i.quit);
        const today = parseDate(i.today);

        if (!quit || !today) {
            return { empty: 'Enter your quit date.' };
        }

        const days = toDays(today) - toDays(quit);

        if (days < 0) {
            return { error: 'The quit date is in the future.' };
        }

        const reached = MILESTONES.filter(([d]) => days >= d);
        const next = MILESTONES.find(([d]) => days < d);
        const saved = or0(i.per_day) * days / 20 * or0(i.price);

        return {
            value: `${f0(days)} days`,
            label: 'Smoke-free',
            sub: `${reached.length} of ${MILESTONES.length} recovery milestones reached${next ? `; next on ${shortDate(addDays(quit, Math.ceil(next[0])))}` : ''}`,
            rows: { next: next ? next[1] : 'All milestones reached', saved: or0(i.price) ? formatMoney(saved) : 'Enter cigarettes a day and pack price', avoided: `${f0(or0(i.per_day) * days)} cigarettes not smoked`, source: 'Milestones: US Surgeon General (2020) and CDC benefits of quitting' },
            grids: { milestones: { columns: ['Date', 'Reached'], rows: MILESTONES.map(([d, text]) => ({ header: text, cells: [shortDate(addDays(quit, Math.ceil(d))), days >= d ? 'Yes' : 'Not yet'], highlight: days >= d })) } },
        };
    },

    sobriety: (i) => {
        const start = parseDate(i.start);
        const today = parseDate(i.today);

        if (!start || !today) {
            return { empty: 'Enter your sobriety date.' };
        }

        const days = toDays(today) - toDays(start);

        if (days < 0) {
            return { error: 'The date is in the future.' };
        }

        const chips = [[1, '24 hours'], [30, '30 days'], [60, '60 days'], [90, '90 days'], [182, '6 months'], [274, '9 months'], [365, '1 year'], [548, '18 months'], [730, '2 years'], [1825, '5 years'], [3650, '10 years']];
        const next = chips.find(([d]) => days < d);

        return {
            value: `${f0(days)} days`,
            label: 'Sober',
            sub: `${f1(days / 7)} weeks, ${f1(days / 30.44)} months${next ? `; ${next[1]} on ${shortDate(addDays(start, next[0]))}` : ''}`,
            rows: { weeks: f1(days / 7), saved: or0(i.per_week) ? `${formatMoney((or0(i.per_week) * days) / 7)} not spent` : 'Enter weekly spending', next: next ? `${next[1]} in ${next[0] - days} days` : 'Every milestone listed reached' },
        };
    },

    hot_car: (i) => {
        if (!ok(i.outside, i.minutes) || i.minutes < 0) {
            return { empty: 'Enter the outside temperature and minutes.' };
        }

        // McLaren, Null & Quinn (Pediatrics 2005): average rise inside a closed car, °F, by minutes.
        const curve = [[0, 0], [10, 19], [20, 29], [30, 34], [40, 38], [50, 41], [60, 43]];
        const m = Math.min(i.minutes, 60);
        const k = curve.findIndex(([t]) => t >= m);
        const rise = k <= 0 ? 0 : curve[k - 1][1] + ((m - curve[k - 1][0]) / (curve[k][0] - curve[k - 1][0])) * (curve[k][1] - curve[k - 1][1]);
        const outsideF = (i.outside * 9) / 5 + 32;
        const insideF = outsideF + rise;
        const insideC = ((insideF - 32) * 5) / 9;

        return {
            value: `${f0(insideF)} °F`,
            label: 'Inside the car',
            sub: `${f0(insideC)} °C after ${f0(m)} minutes on a ${f0(outsideF)} °F (${f0(i.outside)} °C) day; cracking the windows makes little difference`,
            rows: { rise: `+${f0(rise)} °F (${f1((rise * 5) / 9)} °C)`, danger: insideF >= 104 ? 'Dangerous: a child\'s body temperature can reach 104 °F (40 °C), the level of heatstroke' : 'Rising quickly: never leave a child or pet in a car', curve: 'Average rise measured in a dark sedan: 19 °F in 10 min, 34 °F in 30 min, 43 °F in 60 min' },
        };
    },

    noise: (i) => {
        if (!ok(i.level) || i.level < 70) {
            return { empty: 'Enter a sound level of 70 dBA or more.' };
        }

        const niosh = 480 / 2 ** ((i.level - 85) / 3);
        const osha = 480 / 2 ** ((i.level - 90) / 5);
        const t = (min) => (min >= 60 ? `${f1(min / 60)} h` : min >= 1 ? `${f0(min)} min` : `${f0(min * 60)} s`);

        return { value: t(niosh), label: 'Safe exposure a day (NIOSH)', sub: `${f0(i.level)} dBA: NIOSH recommends no more than ${t(niosh)}; the OSHA legal limit is ${t(osha)}`, rows: { niosh: `${t(niosh)} (85 dBA for 8 h, halved every 3 dB)`, osha: `${t(osha)} (90 dBA for 8 h, halved every 5 dB)`, examples: 'About 85 dBA heavy traffic, 100 dBA a motorcycle or concert, 110 dBA a chainsaw' } };
    },

    walking_calories: (i, c) => {
        const kg = kgOf(i.weight);
        const mode = i.mode ?? c?.mode;
        const km = mode === 'steps' ? (i.steps * (i.sex === 'female' ? 0.413 : 0.415) * i.height) / 1000 : i.distance / 1000;

        if (!ok(kg, km) || kg <= 0 || km <= 0) {
            return { empty: mode === 'steps' ? 'Enter steps, height and weight.' : 'Enter the distance and your weight.' };
        }

        // Compendium METs: 2.0 mph (3.2 km/h) 2.8, 3.0 mph (4.8 km/h) 3.5, 3.5 mph 4.3, 4.0 mph 5.0.
        const pace = { slow: [3.2, 2.8], moderate: [4.8, 3.5], brisk: [5.6, 4.3], fast: [6.4, 5.0] }[i.pace] ?? [4.8, 3.5];
        const hours = km / pace[0];
        const kcal = pace[1] * kg * hours;
        const steps = mode === 'steps' ? i.steps : (km * 1000) / (0.414 * (Number.isFinite(i.height) && i.height > 0 ? i.height : 1.7));

        return {
            value: `${f0(kcal)} kcal`,
            label: c.label ?? 'Calories burned walking',
            sub: `${f2(km)} km (${f2(km / 1.609344)} mi) in about ${f0(hours * 60)} minutes at ${pace[0]} km/h`,
            rows: { distance: `${f2(km)} km`, time: `${f0(hours * 60)} min`, steps: `${f0(steps)} steps`, net: `${f0(kcal - kg * hours)} kcal above resting` },
        };
    },

    // Pokémon GO eggs hatch after 2, 5, 7, 10 or 12 km of walking; the walking is counted with Compendium METs.
    pokemon: (i, c) => {
        const km = 2 * or0(i.eggs2) + 5 * or0(i.eggs5) + 7 * or0(i.eggs7) + 10 * or0(i.eggs10) + 12 * or0(i.eggs12) + or0(i.extra_km);

        if (km <= 0) {
            return { empty: 'Enter the eggs you hatched or the kilometres walked.' };
        }

        const outcome = handlers.walking_calories({ ...i, mode: 'distance', distance: km * 1000 }, { label: 'Calories burned walking' });

        return outcome.empty ? outcome : { ...outcome, sub: `${f1(km)} km of egg walking: ${outcome.sub}`, rows: { ...outcome.rows, fat: `About ${f0(outcome.rows ? Number(String(outcome.value).replace(/[^0-9.]/g, '')) / 7.7 : 0)} g of body fat at 7,700 kcal per kg (rule of thumb)` } };
    },

    dog_walk: (i) => {
        const kg = kgOf(i.weight);
        const minutes = or0(i.walks) * or0(i.minutes);

        if (!ok(kg) || kg <= 0 || minutes <= 0) {
            return { empty: 'Enter walks a week, minutes and your weight.' };
        }

        // Compendium: walking the dog 3.0 METs; brisk dog walking counted at 4.3 (walking 3.5 mph).
        const met = i.pace === 'brisk' ? 4.3 : 3.0;
        const kcal = met * kg * (minutes / 60);

        return { value: `${f0(minutes)} min`, label: 'Activity a week', sub: `${f0(kcal)} kcal a week (${f0((kcal * 52) / 7.7 / 1000)} kg of fat a year equivalent at 7,700 kcal/kg)`, rows: { who: minutes >= 150 ? 'Meets the WHO 150 minutes of moderate activity a week' : `${f0(150 - minutes)} more minutes a week to reach WHO's 150`, kcal: `${f0(kcal)} kcal a week, ${f0((kcal * 52))} a year`, met: `${met} METs (Compendium of Physical Activities)` } };
    },

    vo2: (i) => {
        let vo2;
        let method;

        if (i.method === 'cooper') {
            if (!ok(i.distance)) {
                return { empty: 'Enter the distance run in 12 minutes.' };
            }

            vo2 = (i.distance - 504.9) / 44.73;
            method = 'Cooper 12-minute run (1968)';
        } else if (i.method === 'rockport') {
            const lb = kgOf(i.weight) * 2.20462;
            const time = parseTimeText(i.time) / 60;

            if (!ok(lb, time, i.age, i.hr)) {
                return { empty: 'Enter weight, age, walk time and heart rate at the finish.' };
            }

            vo2 = 132.853 - 0.0769 * lb - 0.3877 * i.age + 6.315 * (i.sex === 'male' ? 1 : 0) - 3.2649 * time - 0.1565 * i.hr;
            method = 'Rockport 1-mile walk (Kline et al. 1987)';
        } else {
            if (!ok(i.age, i.rest) || i.rest <= 0) {
                return { empty: 'Enter age and resting heart rate.' };
            }

            vo2 = 15.3 * ((208 - 0.7 * i.age) / i.rest);
            method = 'Heart rate ratio (Uth et al. 2004) with max HR 208 − 0.7 × age';
        }

        return { value: f1(vo2), unit: 'mL/kg/min', label: 'Estimated VO₂ max', sub: `${method}; about ${f1(vo2 / 3.5)} METs`, rows: { mets: f1(vo2 / 3.5), method, note: 'Field tests estimate within about ± 10–15% of a lab test; compare your own results over time' } };
    },

    time_of_death: (i) => {
        const rectal = i.rectal;
        const ambient = i.ambient;
        const kg = kgOf(i.weight) * (Number(i.clothing) || 1);

        if (!ok(rectal, ambient, kg) || kg <= 0) {
            return { empty: 'Enter body and surroundings temperatures and body weight.' };
        }

        if (ambient > 23) {
            return { error: 'This version of the Henssge equation is for surroundings up to 23 °C.' };
        }

        const q = (rectal - ambient) / (37.2 - ambient);

        if (q >= 1 || q <= 0) {
            return { error: 'The body temperature must be between the surroundings and 37.2 °C.' };
        }

        // Henssge (1988): Q = 1.25 e^(B t) − 0.25 e^(5 B t), B = −1.2815 × mass^−0.625 + 0.0284; solve for t by bisection.
        const B = -1.2815 * kg ** -0.625 + 0.0284;
        const Q = (t) => 1.25 * Math.exp(B * t) - 0.25 * Math.exp(5 * B * t);
        let low = 0;
        let high = 200;

        for (let n = 0; n < 80; n += 1) {
            const mid = (low + high) / 2;

            if (Q(mid) > q) {
                low = mid;
            } else {
                high = mid;
            }
        }

        const t = (low + high) / 2;
        const spread = t < 12 ? 2.8 : 4.5;

        return { value: `${f1(t)} h`, label: 'Estimated time since death', sub: `95% range about ${f1(Math.max(0, t - spread))}–${f1(t + spread)} h (Henssge nomogram)`, rows: { q: q.toFixed(3), mass: `${f1(kg)} kg corrected body mass`, note: 'An educational model; forensic estimates combine several methods' } };
    },

    acuity: (i) => {
        let logmar;

        if (i.scale === 'logmar') {
            logmar = i.value2;
        } else if (i.scale === 'decimal') {
            logmar = -Math.log10(i.value);
        } else {
            const [num, den] = String(i.snellen ?? '').split('/').map(Number);
            logmar = Math.log10(den / num);
        }

        if (!Number.isFinite(logmar)) {
            return { empty: 'Enter an acuity, for example 20/40 or 6/12.' };
        }

        const decimal = 10 ** -logmar;
        const band = logmar <= 0.3 ? 'No or mild vision impairment (WHO)' : logmar <= 0.5 ? 'Mild impairment (worse than 6/12)' : logmar <= 1.0 ? 'Moderate impairment (worse than 6/18)' : logmar <= 1.3 ? 'Severe impairment (worse than 6/60)' : 'Blindness range (worse than 3/60)';

        const metric = Number((6 / decimal).toFixed(1));

        return { value: `20/${f0(20 / decimal)}`, label: 'Snellen (feet)', sub: `6/${metric} metric, decimal ${f2(decimal)}, logMAR ${f2(logmar)}`, rows: { metric: `6/${metric}`, decimal: f2(decimal), logmar: f2(logmar), band, driving: decimal >= 0.5 ? 'Meets the common 20/40 (6/12) driving standard' : 'Below the common 20/40 (6/12) driving standard' } };
    },
};

export default defineTools(handlers);
