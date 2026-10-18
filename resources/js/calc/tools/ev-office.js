import { money } from '../ecology/common.js';
import { WEEKDAYS, addWorkdays, clock, compare, countDays, durationText, longDate, parseDate, parseDateList, parseTime, toDays, usFederalHolidays } from '../everyday/dates.js';
import { capitalize, checkWords, graphemes, moneyWords, numberWords, ordinalWords, reverseText, toCase, words } from '../everyday/text.js';
import { defineTools } from '../engines/formula.js';
import { parseRows } from '../rows-editor.js';

/**
 * Office, school and productivity: work time, typing, words, paper, money and test scores.
 * Unit fields arrive in base units (meters, grams).
 */
const IN = 0.0254;
const HOURS_PER_YEAR = 2080;
const cm = (m, f) => `${f(Math.round(m * 1000) / 10)} cm (${f(Math.round((m / IN) * 10) / 10)} in)`;

/**
 * Percentile text: '1-' means under 1 and '99+' over 99.
 */
const percentileText = (value) => (value === '99+' ? 'above the 99th' : value === '1-' ? 'below the 1st' : `${value}${['11', '12', '13'].includes(String(value).slice(-2)) ? 'th' : { 1: 'st', 2: 'nd', 3: 'rd' }[String(value).slice(-1)] ?? 'th'}`);

/**
 * Seated and standing ergonomic heights from body height (Pheasant, Bodyspace, 50th-percentile adult ratios:
 * popliteal height 0.25 H, sitting elbow height 0.14 H, sitting eye height 0.455 H; standing elbow height 0.63 H and eye height 0.936 H, Drillis & Contini).
 */
export function ergonomics(height, shoes = 0.025) {
    return {
        seat: 0.25 * height + shoes,
        seatedElbow: 0.25 * height + shoes + 0.14 * height,
        seatedEye: 0.25 * height + shoes + 0.455 * height,
        standingElbow: 0.63 * height + shoes,
        standingEye: 0.936 * height + shoes,
    };
}

function holidaysFor(i, fromYear, toYear) {
    if (i.holidays === 'us') {
        const set = new Set();

        for (let year = fromYear - 1; year <= toYear + 1; year += 1) {
            usFederalHolidays(year).forEach((holiday) => set.add(toDays(holiday.observed)));
        }

        return set;
    }

    if (i.holidays === 'custom') {
        return new Set(parseDateList(i.holiday_list).dates.map(toDays));
    }

    return new Set();
}

const textStats = (text) => {
    const value = String(text ?? '');
    const list = words(value);
    const sentences = value.split(/[.!?…]+(?:\s|$)/).filter((part) => /[\p{L}\p{N}]/u.test(part)).length;
    const paragraphs = value.split(/\n\s*\n/).filter((part) => part.trim()).length;

    return { words: list.length, list, characters: graphemes(value).length, noSpaces: graphemes(value.replace(/\s/g, '')).length, sentences, paragraphs };
};

export const handlers = {
    acceptance: (i, c, f) => {
        if (!(i.applicants > 0) || !(i.admitted >= 0) || i.admitted > i.applicants) {
            return { empty: 'Enter the number of applicants and admitted students.' };
        }

        const rate = i.admitted / i.applicants;

        return {
            value: f(rate * 100),
            unit: '%',
            label: 'Acceptance rate',
            sub: `${f(i.admitted)} admitted of ${f(i.applicants)} applicants`,
            rows: {
                odds: rate > 0 ? `About 1 in ${f(Math.round((1 / rate) * 10) / 10)}` : 'No one admitted',
                rejected: `${f(i.applicants - i.admitted)} not admitted (${f((1 - rate) * 100)}%)`,
                yield: i.enrolled > 0 && i.admitted > 0 ? `${f((i.enrolled / i.admitted) * 100)}% yield (${f(i.enrolled)} enrolled)` : 'Enter enrolled students for the yield',
            },
        };
    },

    cycle_time: (i, c, f) => {
        const time = i.time > 0 ? i.time : NaN;

        if (!(time > 0) || !(i.units > 0)) {
            return { empty: 'Enter the production time and the units completed.' };
        }

        const cycle = time / i.units;
        const takt = i.available > 0 && i.demand > 0 ? (i.available * 60) / i.demand : null;

        return {
            value: f(cycle),
            unit: 'min per unit',
            label: 'Cycle time',
            sub: `${f(time)} min ÷ ${f(i.units)} units`,
            rows: {
                seconds: `${f(cycle * 60)} s per unit`,
                throughput: `${f(60 / cycle)} units an hour`,
                takt: takt ? `${f(takt)} min takt time: ${cycle <= takt ? 'cycle time meets demand' : `${f(cycle - takt)} min too slow to meet demand`}` : 'Enter available hours and demand for takt time',
            },
        };
    },

    deadline: (i, c, f) => {
        const start = parseDate(i.start);

        if (!start || !(i.days > 0) || !Number.isInteger(i.days)) {
            return { empty: 'Enter a start date and a whole number of working days.' };
        }

        const weekend = { sat_sun: [0, 6], fri_sat: [5, 6], sun: [0], none: [] }[i.weekend] ?? [0, 6];
        const holidays = holidaysFor(i, start.y, start.y + Math.ceil(i.days / 200) + 1);
        const end = addWorkdays(start, i.days, { weekend, holidays });
        const calendar = toDays(end) - toDays(start);

        return {
            value: longDate(end),
            label: 'Deadline',
            sub: `${f(i.days)} working days after ${longDate(start)}`,
            rows: {
                calendar: `${f(calendar)} calendar days`,
                weekday: WEEKDAYS[(((toDays(end) + 4) % 7) + 7) % 7],
                skipped: `${f(calendar - i.days)} weekend days and holidays skipped`,
            },
        };
    },

    desk_height: (i, c, f) => {
        const height = i.height > 0 ? i.height : NaN;

        if (!(height > 0)) {
            return { empty: 'Enter your height.' };
        }

        const e = ergonomics(height, i.shoes >= 0 ? i.shoes : 0.025);
        const elbow = i.elbow > 0 ? i.elbow : e.seatedElbow;

        return {
            value: cm(elbow, f),
            label: 'Desk (keyboard) height',
            sub: i.elbow > 0 ? 'Your measured seated elbow height' : 'Estimated from your height: elbows at 90° with shoulders relaxed',
            rows: {
                chair: `${cm(e.seat, f)} chair seat height (feet flat, thighs level)`,
                monitor: `Top of the screen at about ${cm(e.seatedEye, f)}, at or slightly below eye level`,
                standard: `Standard desks are about 72–76 cm (28–30 in): ${elbow < 0.72 ? 'use a keyboard tray or raise the chair with a footrest' : elbow > 0.76 ? 'raise the desk or lower the chair' : 'a standard desk suits you'}`,
                note: 'Estimates from average body proportions; measure your elbow height for a better fit',
            },
        };
    },

    standing_desk: (i, c, f) => {
        const height = i.height > 0 ? i.height : NaN;

        if (!(height > 0)) {
            return { empty: 'Enter your height.' };
        }

        const e = ergonomics(height, i.shoes >= 0 ? i.shoes : 0.025);
        const elbow = i.elbow > 0 ? i.elbow : e.standingElbow;

        return {
            value: cm(elbow, f),
            label: 'Standing desk height',
            sub: i.elbow > 0 ? 'Your measured standing elbow height' : 'Estimated from your height: forearms level, elbows at 90°',
            rows: {
                monitor: `Top of the screen at about ${cm(e.standingEye, f)}, at or slightly below eye level`,
                seated: `${cm(e.seatedElbow, f)} when you sit (for a sit-stand desk)`,
                note: 'Estimates from average body proportions; adjust so your wrists stay straight',
            },
        };
    },

    dollars_words: (i, c, f) => {
        const check = checkWords(i.amount, i.currency_word || 'dollars');
        const spoken = moneyWords(i.amount);

        if (!check || !spoken) {
            return { empty: 'Enter an amount (up to the decillions).' };
        }

        return {
            value: check,
            label: 'For a check',
            sub: 'Write the cents as a fraction of 100 and draw a line to the end of the space',
            rows: { spoken: capitalize(spoken), upper: check.toUpperCase(), digits: `$${Number(String(i.amount).replace(/[^\d.]/g, '')).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}` },
        };
    },

    numbers_words: (i, c, f) => {
        const text = numberWords(i.number, { indian: i.system === 'indian' });

        if (!text) {
            return { empty: 'Enter a number.' };
        }

        const whole = String(i.number).replace(/[,\s]/g, '');
        const isWhole = /^-?\d+$/.test(whole);

        return {
            value: capitalize(text),
            label: i.system === 'indian' ? 'In words (lakh and crore)' : 'In words',
            sub: `${graphemes(text).length} characters`,
            rows: {
                ordinal: isWhole && !whole.startsWith('-') ? capitalize(ordinalWords(text)) : 'Whole positive numbers only',
                other: capitalize(numberWords(i.number, { indian: i.system !== 'indian' }) ?? ''),
                check: checkWords(i.number) ?? 'Positive amounts only',
            },
        };
    },

    english_hours: (i, c, f) => {
        const levels = ['Pre-A1', 'A1', 'A2', 'B1', 'B2', 'C1', 'C2'];
        const hours = c.data.cefr_hours;
        const from = i.from === 'Pre-A1' ? [0, 0] : hours[i.from];
        const to = hours[i.to];

        if (!from || !to || levels.indexOf(i.to) <= levels.indexOf(i.from)) {
            return { empty: 'Choose a target level above your current level.' };
        }

        const low = Math.max(0, to[0] - from[1]);
        const high = to[1] - from[0];
        const perWeek = i.per_week > 0 ? i.per_week : null;

        return {
            value: `${f(low)}–${f(high)}`,
            unit: 'hours',
            label: `${i.from} to ${i.to}`,
            sub: 'Guided learning hours (classes and directed study)',
            rows: {
                weeks: perWeek ? `${f(Math.ceil(low / perWeek))}–${f(Math.ceil(high / perWeek))} weeks at ${f(perWeek)} hours a week` : 'Enter hours a week',
                months: perWeek ? `About ${f(Math.round((low / perWeek / 4.345) * 10) / 10)}–${f(Math.round((high / perWeek / 4.345) * 10) / 10)} months` : '—',
                note: 'A guideline: background, age, intensity and practice outside class change it a lot',
            },
        };
    },

    gmat: (i, c, f) => {
        const score = Math.round(i.score);
        const row = c.data.gmat[score];

        if (!row) {
            return { empty: 'Enter a GMAT Focus total score from 205 to 805 (it ends in 5).' };
        }

        return {
            value: `${f(row[0])}%`,
            label: `Percentile for ${score}`,
            sub: `About ${f(row[0])}% of test takers scored ${score} or lower (GMAC, July 2021 – June 2026)`,
            rows: {
                tenth: row[1] === row[2] ? `${row[1]} on the old (10th Edition) scale` : `${row[1]}–${row[2]} on the old (10th Edition) scale`,
                above: `${f(Math.round((100 - row[0]) * 10) / 10)}% scored higher`,
                note: 'GMAC updates percentiles each year; section-to-total scoring is not published',
            },
        };
    },

    sat: (i, c, f) => {
        const total = Math.round(i.total / 10) * 10;
        const row = c.data.sat_total[total];

        if (!row || i.total < 400 || i.total > 1600) {
            return { empty: 'Enter an SAT total score from 400 to 1600.' };
        }

        const section = (score, offset) => {
            const s = c.data.sat_section[Math.round(score / 10) * 10];

            return s ? `${percentileText(s[offset])} nationally, ${percentileText(s[offset + 1])} among test takers` : 'Enter a section score (200–800)';
        };

        return {
            value: percentileText(row[1]),
            unit: 'percentile',
            label: `SAT ${total}: among test takers`,
            sub: `${percentileText(row[0])} percentile of all US 11th and 12th graders`,
            rows: {
                rw: i.rw >= 200 && i.rw <= 800 ? `${f(i.rw)}: ${section(i.rw, 0)}` : 'Enter a Reading and Writing score',
                math: i.math >= 200 && i.math <= 800 ? `${f(i.math)}: ${section(i.math, 2)}` : 'Enter a Math score',
                sum: i.rw >= 200 && i.math >= 200 && Math.round(i.rw + i.math) !== total ? `Your sections add to ${f(i.rw + i.math)}, not ${total}` : 'Total = Reading and Writing + Math',
            },
        };
    },

    gwam: (i, c, f) => {
        const minutes = (i.minutes > 0 ? i.minutes : 0) + (i.seconds > 0 ? i.seconds / 60 : 0);
        const strokes = i.unit === 'words' ? i.count * 5 : i.count;

        if (!(strokes > 0) || !(minutes > 0)) {
            return { empty: 'Enter what you typed and how long it took.' };
        }

        const gross = strokes / 5 / minutes;
        const errors = i.errors > 0 ? i.errors : 0;
        const net = Math.max(0, gross - errors / minutes);

        return {
            value: f(Math.round(gross * 10) / 10),
            unit: 'GWAM',
            label: 'Gross words a minute',
            sub: `${f(strokes)} keystrokes ÷ 5 ÷ ${f(minutes)} min`,
            rows: { net: `${f(Math.round(net * 10) / 10)} net words a minute (less ${f(errors)} errors ÷ minutes)`, accuracy: strokes > 0 ? `${f(Math.max(0, (1 - errors / (strokes / 5)) * 100))}% of words correct` : '—', kph: `${f(Math.round(strokes / minutes * 60))} keystrokes an hour` },
        };
    },

    kph: (i, c, f) => {
        let perHour;

        if (i.mode === 'wpm') {
            perHour = i.wpm * 5 * 60;
        } else {
            const hours = ((i.minutes > 0 ? i.minutes : 0) + (i.seconds > 0 ? i.seconds / 60 : 0)) / 60;
            perHour = i.keystrokes / hours;
        }

        if (!(perHour > 0) || !Number.isFinite(perHour)) {
            return { empty: 'Enter keystrokes and time, or a typing speed.' };
        }

        return {
            value: f(Math.round(perHour)),
            unit: 'keystrokes an hour',
            label: 'Keystrokes per hour (KPH)',
            sub: i.mode === 'wpm' ? `${f(i.wpm)} WPM × 5 keystrokes per word × 60` : `${f(i.keystrokes)} keystrokes in ${f((i.minutes || 0) + (i.seconds || 0) / 60)} min`,
            rows: { kpm: `${f(Math.round(perHour / 60))} keystrokes a minute`, wpm: `${f(Math.round(perHour / 300))} words a minute`, note: 'Data entry jobs often ask for 8,000–10,000 KPH; check the employer\'s test rules' },
        };
    },

    lead_time: (i, c, f) => {
        let days;

        if (i.mode === 'dates') {
            const order = parseDate(i.order);
            const delivery = parseDate(i.delivery);

            if (!order || !delivery || compare(delivery, order) < 0) {
                return { empty: 'Enter the order date and a delivery date on or after it.' };
            }

            days = i.business ? countDays(order, delivery).workdays : toDays(delivery) - toDays(order);
        } else {
            days = ['supplier', 'transit', 'receiving'].reduce((sum, key) => sum + (i[key] > 0 ? i[key] : 0), 0);

            if (!(days > 0)) {
                return { empty: 'Enter the days for each stage.' };
            }
        }

        const reorder = i.demand > 0 ? i.demand * days + (i.safety > 0 ? i.safety : 0) : null;

        return {
            value: f(days),
            unit: days === 1 ? 'day' : 'days',
            label: 'Lead time',
            sub: i.mode === 'dates' ? `${i.business ? 'Business' : 'Calendar'} days from order to delivery` : 'Supplier + transit + receiving',
            rows: { weeks: `${f(days / 7)} weeks`, reorder: reorder !== null ? `Reorder at ${f(Math.ceil(reorder))} units in stock (${f(i.demand)} a day × ${f(days)} days + ${f(i.safety || 0)} safety stock)` : 'Enter daily demand for a reorder point' },
        };
    },

    meeting: (i, c, f) => {
        const rows = parseRows(i.people).map((cells, k) => ({ name: cells[0] || `Group ${k + 1}`, count: Number(cells[1]), salary: Number(cells[2]) })).filter((row) => row.count > 0 && row.salary > 0);

        if (!rows.length || !(i.minutes > 0)) {
            return { empty: 'Add attendees with their annual pay, and the meeting length.' };
        }

        const overhead = 1 + (i.overhead > 0 ? i.overhead : 0) / 100;
        const perHour = rows.reduce((sum, row) => sum + (row.count * row.salary * overhead) / HOURS_PER_YEAR, 0);
        const cost = (perHour * i.minutes) / 60;
        const yearly = i.per_year > 0 ? cost * i.per_year : null;
        const people = rows.reduce((sum, row) => sum + row.count, 0);

        return {
            value: money(cost),
            label: 'Cost of the meeting',
            sub: `${f(people)} people × ${f(i.minutes)} minutes`,
            rows: { minute: `${money(perHour / 60)} a minute`, year: yearly ? `${money(yearly)} a year at ${f(i.per_year)} meetings` : 'Enter meetings a year', hours: `${f((people * i.minutes) / 60)} person-hours` },
            lists: { groups: rows.map((row) => ({ label: `${row.name} (${f(row.count)})`, value: money((row.count * row.salary * overhead * i.minutes) / 60 / HOURS_PER_YEAR) })) },
        };
    },

    money_weight: (i, c, f) => {
        const item = c.data.money[i.denomination];

        if (!item || !(i.amount > 0)) {
            return { empty: 'Enter an amount and choose a note or coin.' };
        }

        const [name, value, grams, kind] = item;
        const count = Math.ceil(i.amount / value - 1e-9);
        const mass = count * grams;

        return {
            value: mass >= 1000 ? f(mass / 1000) : f(mass),
            unit: mass >= 1000 ? 'kg' : 'g',
            label: `Weight in ${name.toLowerCase()}s`,
            sub: `${f(count)} × ${f(grams)} g`,
            rows: {
                lb: `${f(mass / 453.59237)} lb`,
                count: `${f(count)} ${kind === 'note' ? 'notes' : 'coins'}`,
                stack: kind === 'note' ? `A stack about ${f((count * 0.0043 * 2.54) / 100)} m (${f((count * 0.0043) / 12)} ft) high` : 'Coins: stack height depends on thickness',
            },
        };
    },

    paper_thickness: (i, c, f) => {
        let microns;

        if (i.mode === 'stack') {
            if (!(i.stack > 0) || !(i.sheets > 0)) {
                return { empty: 'Enter the stack height and the number of sheets.' };
            }

            microns = (i.stack / i.sheets) * 1e6;
        } else {
            if (!(i.gsm > 0) || !(i.density > 0)) {
                return { empty: 'Enter the paper weight (GSM) and density.' };
            }

            microns = i.gsm / i.density;
        }

        return {
            value: f(Math.round(microns * 10) / 10),
            unit: 'µm per sheet',
            label: 'Paper thickness (caliper)',
            sub: `${f(microns / 1000)} mm`,
            rows: { mils: `${f(microns / 25.4)} mils (thousandths of an inch)`, ream: `A 500-sheet ream is about ${f((microns * 500) / 1000)} mm (${f((microns * 500) / 25400)} in) thick`, note: 'Typical office paper (80 GSM) is about 0.1 mm thick' },
        };
    },

    paper_weight: (i, c, f) => {
        const grades = c.data.paper_grades;
        const area = (g) => grades[g][1] * grades[g][2] * IN * IN;
        const gsm = i.direction === 'from_gsm' ? i.gsm : (i.pounds * 453.59237) / (500 * area(i.grade));

        if (!(gsm > 0)) {
            return { empty: 'Enter the paper weight.' };
        }

        const pounds = (g) => (gsm * area(g) * 500) / 453.59237;

        return {
            value: i.direction === 'from_gsm' ? f(Math.round(pounds(i.grade) * 10) / 10) : f(Math.round(gsm * 10) / 10),
            unit: i.direction === 'from_gsm' ? `lb ${grades[i.grade][0].toLowerCase()}` : 'GSM',
            label: i.direction === 'from_gsm' ? 'Basis weight' : 'Grams per square meter',
            sub: `${grades[i.grade][0]} basis size ${grades[i.grade][1]} × ${grades[i.grade][2]} in`,
            rows: { sheet: `A letter sheet (8.5 × 11 in) weighs ${f(gsm * 8.5 * 11 * IN * IN)} g; an A4 sheet ${f(gsm * 0.06237)} g` },
            lists: { grades: Object.keys(grades).map((g) => ({ label: grades[g][0], value: `${f(Math.round(pounds(g) * 10) / 10)} lb`, highlight: g === i.grade })) },
        };
    },

    pomodoro: (i, c, f) => {
        const start = parseTime(i.start);
        const sessions = Math.round(i.sessions);

        if (start === null || !(sessions > 0) || !(i.work > 0)) {
            return { empty: 'Enter a start time, focus length and number of sessions.' };
        }

        const every = i.every > 0 ? Math.round(i.every) : 4;
        const schedule = [];
        let t = start;

        for (let k = 1; k <= sessions; k += 1) {
            schedule.push({ label: `Focus ${k}`, value: `${clock(t).h12} – ${clock(t + i.work * 60).h12}` });
            t += i.work * 60;

            if (k < sessions) {
                const long = k % every === 0;
                const pause = (long ? i.long_break : i.short_break) * 60;
                schedule.push({ label: long ? 'Long break' : 'Break', value: `${f(pause / 60)} min` });
                t += pause;
            }
        }

        return {
            value: clock(t).h12,
            label: 'Finish time',
            sub: `${sessions} sessions from ${clock(start).h12}`,
            rows: { focus: `${durationText(sessions * i.work * 60, { units: ['h', 'min'] })} of focus`, total: `${durationText(t - start, { units: ['h', 'min'] })} in all` },
            lists: { schedule },
        };
    },

    reverse: (i, c, f) => {
        if (!String(i.text ?? '').length) {
            return { empty: 'Type or paste some text.' };
        }

        const out = reverseText(i.text, i.mode);

        return {
            value: out,
            label: { characters: 'Reversed text', words: 'Words in reverse order', each_word: 'Each word reversed' }[i.mode] ?? 'Reversed text',
            sub: `${graphemes(i.text).length} characters`,
            rows: { palindrome: graphemes(i.text.toLowerCase().replace(/[^\p{L}\p{N}]/gu, '')).join('') === graphemes(i.text.toLowerCase().replace(/[^\p{L}\p{N}]/gu, '')).reverse().join('') ? 'Yes, it reads the same backwards (ignoring spaces and punctuation)' : 'No' },
        };
    },

    slack: (i, c, f) => {
        if (![i.es, i.ef, i.ls, i.lf].every(Number.isFinite)) {
            return { empty: 'Enter the early and late start and finish.' };
        }

        if (i.ef < i.es || i.lf < i.ls) {
            return { error: 'A finish is before its start.' };
        }

        const total = i.ls - i.es;
        const check = i.lf - i.ef;
        const free = Number.isFinite(i.next_es) ? i.next_es - i.ef : null;

        return {
            value: f(total),
            unit: total === 1 ? 'day' : 'days',
            label: 'Total float (slack)',
            sub: total === 0 ? 'On the critical path: any delay delays the project' : `The task can slip ${f(total)} days without delaying the project`,
            rows: { check: Math.abs(check - total) < 1e-9 ? `LF − EF = ${f(check)} agrees` : `LF − EF = ${f(check)} does not match LS − ES: check the durations`, free: free === null ? 'Enter the next task\'s early start for free float' : `${f(free)} ${free === 1 ? 'day' : 'days'} free float (without delaying the next task)`, duration: `${f(i.ef - i.es)} days duration` },
        };
    },

    social_ban: (i, c, f) => {
        if (!(i.before > 0) || !(i.after >= 0) || i.after > i.before) {
            return { empty: 'Enter minutes a day before and after.' };
        }

        const saved = ((i.before - i.after) * 365.25) / 60;

        return {
            value: f(Math.round(saved)),
            unit: 'hours a year',
            label: 'Time freed',
            sub: `${f(i.before - i.after)} minutes a day (${f(((i.before - i.after) / i.before) * 100)}% less)`,
            rows: { days: `${f(saved / 24)} full days`, books: `${f(Math.floor(saved / (90000 / 238 / 60)))} novels at average reading speed`, workweeks: `${f(saved / 40)} 40-hour work weeks` },
        };
    },

    speaking: (i, c, f) => {
        const count = i.mode === 'text' ? words(i.text).length : i.words;
        const pace = i.pace > 0 ? i.pace : 130;

        if (!(count > 0)) {
            return { empty: 'Paste your text or enter a word count.' };
        }

        const minutes = count / pace;

        return {
            value: durationText(minutes * 60, { units: ['h', 'min', 's'] }),
            label: 'Speaking time',
            sub: `${f(count)} words at ${f(pace)} words a minute`,
            rows: { slow: `${durationText((count / 110) * 60, { units: ['h', 'min', 's'] })} slowly (110 wpm)`, fast: `${durationText((count / 160) * 60, { units: ['h', 'min', 's'] })} briskly (160 wpm)`, limit: i.limit > 0 ? `${f(Math.floor(i.limit * pace))} words fit in ${f(i.limit)} ${i.limit === 1 ? 'minute' : 'minutes'}` : 'Enter a time limit' },
        };
    },

    text_case: (i, c, f) => {
        if (!String(i.text ?? '').length) {
            return { empty: 'Type or paste some text.' };
        }

        const modes = { upper: 'UPPER CASE', lower: 'lower case', title: 'Title Case', sentence: 'Sentence case', camel: 'camelCase', pascal: 'PascalCase', snake: 'snake_case', kebab: 'kebab-case', constant: 'CONSTANT_CASE', alternating: 'aLtErNaTiNg', inverse: 'iNVERSE' };

        return {
            value: toCase(i.text, i.mode),
            label: modes[i.mode] ?? 'Converted',
            sub: `${graphemes(i.text).length} characters`,
            lists: { all: Object.entries(modes).filter(([key]) => key !== i.mode).map(([key, name]) => ({ label: name, value: toCase(i.text, key).slice(0, 120) })) },
        };
    },

    time_card: (i, c, f) => {
        const rows = parseRows(i.days).map((cells, k) => ({ name: cells[0] || `Day ${k + 1}`, start: parseTime(cells[1]), end: parseTime(cells[2]), lunch: Number(cells[3]) || 0 })).filter((row) => row.start !== null && row.end !== null);

        if (!rows.length) {
            return { empty: 'Enter days with start and end times like 09:00 and 17:30.' };
        }

        const daily = rows.map((row) => ({ ...row, hours: Math.max(0, ((row.end > row.start ? row.end - row.start : row.end - row.start + 86400) - row.lunch * 60) / 3600) }));
        const total = daily.reduce((sum, row) => sum + row.hours, 0);
        // Weekly rule (FLSA): hours over 40. Daily rule: hours over 8 a day, or over 40 a week if that is more.
        const weekly = Math.max(0, total - 40);
        const ot = i.rule === 'none' ? 0 : i.rule === 'daily' ? Math.max(weekly, daily.reduce((sum, row) => sum + Math.max(0, row.hours - 8), 0)) : weekly;
        const regular = total - ot;
        const rate = i.rate > 0 ? i.rate : null;
        const hm = (h) => `${Math.floor(h)}:${String(Math.round((h % 1) * 60)).padStart(2, '0')}`;

        return {
            value: f(Math.round(total * 100) / 100),
            unit: 'hours',
            label: 'Hours worked',
            sub: `${hm(total)} over ${rows.length} days`,
            rows: { regular: `${f(Math.round(regular * 100) / 100)} regular hours`, overtime: `${f(Math.round(ot * 100) / 100)} overtime hours`, pay: rate ? `${money(regular * rate + ot * rate * 1.5)} (${money(rate)}/h, overtime at 1.5×)` : 'Enter an hourly rate' },
            lists: { days: daily.map((row) => ({ label: row.name, value: `${clock(row.start).h12} – ${clock(row.end).h12}${row.lunch ? `, ${f(row.lunch)} min break` : ''}: ${hm(row.hours)}` })) },
        };
    },

    email_time: (i, c, f) => {
        if (!(i.emails > 0) || !(i.minutes > 0)) {
            return { empty: 'Enter emails a day and minutes on each.' };
        }

        const days = i.days > 0 ? i.days : 250;
        const hours = (i.emails * i.minutes * days) / 60;

        return {
            value: f(Math.round(hours)),
            unit: 'hours a year',
            label: 'Time on email',
            sub: `${f(i.emails)} emails × ${f(i.minutes)} min × ${f(days)} workdays`,
            rows: { day: `${durationText(i.emails * i.minutes * 60, { units: ['h', 'min'] })} a day`, share: `${f((hours / ((i.workday > 0 ? i.workday : 8) * days)) * 100)}% of working hours`, weeks: `${f(hours / 40)} 40-hour weeks a year`, cost: i.rate > 0 ? `${money(hours * i.rate)} of time a year` : 'Enter an hourly rate for the cost' },
        };
    },

    word_count: (i, c, f) => {
        const s = textStats(i.text);

        if (!s.characters) {
            return { empty: 'Type or paste some text.' };
        }

        const counts = {};
        s.list.map((w) => w.toLowerCase()).filter((w) => w.length > 3).forEach((w) => {
            counts[w] = (counts[w] ?? 0) + 1;
        });

        return {
            value: f(s.words),
            unit: s.words === 1 ? 'word' : 'words',
            label: 'Word count',
            sub: `${f(s.characters)} characters, ${f(s.noSpaces)} without spaces`,
            rows: {
                sentences: f(s.sentences),
                paragraphs: f(s.paragraphs),
                reading: `${durationText((s.words / 238) * 60, { units: ['min', 's'] })} at 238 words a minute`,
                speaking: `${durationText((s.words / 130) * 60, { units: ['min', 's'] })} at 130 words a minute`,
                average: s.words ? `${f(Math.round((s.noSpaces / s.words) * 10) / 10)} characters per word, ${s.sentences ? f(Math.round((s.words / s.sentences) * 10) / 10) : '—'} words per sentence` : '—',
            },
            lists: { top: Object.entries(counts).sort((a, b) => b[1] - a[1]).slice(0, 8).map(([w, n]) => ({ label: w, value: `${n}×` })) },
        };
    },

    wpm: (i, c, f) => {
        const minutes = (i.minutes > 0 ? i.minutes : 0) + (i.seconds > 0 ? i.seconds / 60 : 0);
        const strokes = i.unit === 'words' ? i.count * 5 : i.count;

        if (!(strokes > 0) || !(minutes > 0)) {
            return { empty: 'Enter what you typed and the time.' };
        }

        const gross = strokes / 5 / minutes;
        const errors = i.errors > 0 ? i.errors : 0;
        const net = Math.max(0, gross - errors / minutes);
        const accuracy = Math.max(0, (1 - errors / (strokes / 5)) * 100);

        return {
            value: f(Math.round(net)),
            unit: 'WPM',
            label: 'Net typing speed',
            sub: `${f(Math.round(gross))} gross WPM, ${f(errors)} errors`,
            rows: { accuracy: `${f(Math.round(accuracy * 10) / 10)}% accuracy`, cpm: `${f(Math.round(strokes / minutes))} characters a minute`, level: net < 30 ? 'Below 30 WPM: keep practicing touch typing' : net < 50 ? 'Average: most people type 30–50 WPM' : net < 80 ? 'Fast: above most office workers' : 'Very fast: professional level' },
        };
    },
};

export default defineTools(handlers);
