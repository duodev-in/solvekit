import { SYNODIC_MONTH, equationOfEquinoxes, gmst, hms, jdFromMs, moonAt, msFromJd, phaseName } from '../everyday/astro.js';
import {
    MONTHS, WEEKDAYS, addDays, addMonths, civilSeconds, clock, compare, countDays, dayOfYear, daysInMonth, daysInYear, diffYMD, durationText,
    fromCivilSeconds, fromDays, isLeap, isoDate, isoWeek, isoWeeksInYear, longDate, parseDate, parseDateList, parseDateTime, parseTime, plural, shortDate,
    toDays, usFederalHolidays, weekday, ymdText,
} from '../everyday/dates.js';
import { defineTools } from '../engines/formula.js';
import { formatOffset, zonedToEpoch, zoneOffsetMinutes } from './unix-time.js';

/**
 * Time and date: calendar arithmetic, ages, business days, the Moon and sidereal time.
 * Dates arrive as 'YYYY-MM-DD', times as 'HH:MM' and date-times as 'YYYY-MM-DDTHH:MM'.
 */
const DAY = 86400;

/**
 * The browser's current wall-clock time as civil seconds, or a fixed value passed in (tests).
 */
export function nowCivil(i) {
    if (i.now !== undefined) {
        return civilSeconds(parseDateTime(i.now));
    }

    const now = new Date();

    return toDays({ y: now.getFullYear(), m: now.getMonth() + 1, d: now.getDate() }) * DAY + now.getHours() * 3600 + now.getMinutes() * 60 + now.getSeconds();
}

const today = (i) => fromDays(Math.floor(nowCivil(i) / DAY));
const dateOr = (text, i) => (text ? parseDate(text) : today(i));
const at = ({ date, seconds }) => `${longDate(date)}, ${clock(seconds).h12}`;

/**
 * Next occurrence of a yearly date on or after a day (a 29 February date falls on 28 February in common years).
 */
export function nextAnniversary(start, from) {
    let years = Math.max(0, from.y - start.y);
    let date = addMonths(start, 12 * years);

    while (compare(date, from) < 0) {
        years += 1;
        date = addMonths(start, 12 * years);
    }

    return { date, years };
}

const GIFTS = {
    1: 'Paper', 2: 'Cotton', 3: 'Leather', 4: 'Fruit and flowers (linen)', 5: 'Wood', 6: 'Sugar (iron)', 7: 'Wool (copper)', 8: 'Bronze', 9: 'Pottery', 10: 'Tin',
    11: 'Steel', 12: 'Silk', 13: 'Lace', 14: 'Ivory', 15: 'Crystal', 20: 'China', 25: 'Silver', 30: 'Pearl', 35: 'Coral', 40: 'Ruby', 45: 'Sapphire', 50: 'Gold',
    55: 'Emerald', 60: 'Diamond', 70: 'Platinum',
};
const ordinal = (n) => `${n}${[11, 12, 13].includes(n % 100) ? 'th' : ['th', 'st', 'nd', 'rd'][n % 10] ?? 'th'}`;

function shiftTime(i, f, sign) {
    const start = parseDateTime(i.start);
    const parts = ['days', 'hours', 'minutes', 'seconds'].map((key) => (Number.isFinite(i[key]) ? i[key] : 0));

    if (!start) {
        return { empty: 'Enter a start date and time.' };
    }

    const moved = parts[0] * DAY + parts[1] * 3600 + parts[2] * 60 + parts[3];
    const end = fromCivilSeconds(civilSeconds(start) + sign * moved);

    if (end.date.y < 1 || end.date.y > 9999) {
        return { error: 'The result is outside the years 1–9999.' };
    }

    return {
        value: at(end),
        label: sign > 0 ? 'Date and time after adding' : 'Date and time after subtracting',
        sub: `${at(start)} ${sign > 0 ? '+' : '−'} ${durationText(moved)}`,
        rows: {
            clock24: `${isoDate(end.date)} ${clock(end.seconds, { withSeconds: true }).h24}`,
            weekday: WEEKDAYS[weekday(end.date)],
            total: `${f(moved / 3600)} hours (${f(moved / DAY)} days)`,
            note: 'Clock time, ignoring any daylight-saving change in between',
        },
    };
}

/**
 * A duration from day, hour, minute and second fields with a suffix (a_days, a_hours…).
 */
const durationFrom = (i, prefix) => ['days', 'hours', 'minutes', 'seconds'].reduce((sum, key, index) => sum + (Number.isFinite(i[`${prefix}${key}`]) ? i[`${prefix}${key}`] : 0) * [DAY, 3600, 60, 1][index], 0);

const hm = (seconds) => {
    const sign = seconds < 0 ? '−' : '';
    const total = Math.round(Math.abs(seconds) / 60);

    return `${sign}${Math.floor(total / 60)}:${String(total % 60).padStart(2, '0')}`;
};

/**
 * '1:30', '+2:45', '-0:20', '1h 30m', '90m' or '1.5' (hours) → seconds; null when unreadable.
 */
export function parseDuration(text) {
    const value = String(text).trim().replace(/\s+/g, ' ');
    const sign = value.startsWith('-') || value.startsWith('−') ? -1 : 1;
    const body = value.replace(/^[+\-−]\s*/, '');
    let match = /^(\d+):(\d{1,2})(?::(\d{1,2}(?:\.\d+)?))?$/.exec(body);

    if (match) {
        return sign * (Number(match[1]) * 3600 + Number(match[2]) * 60 + Number(match[3] ?? 0));
    }

    match = /^(?:(\d+(?:\.\d+)?) ?h(?:ours?|rs?)?)? ?(?:(\d+(?:\.\d+)?) ?m(?:in(?:utes?|s)?)?)? ?(?:(\d+(?:\.\d+)?) ?s(?:ec(?:onds?|s)?)?)?$/i.exec(body);

    if (match && (match[1] || match[2] || match[3])) {
        return sign * (Number(match[1] ?? 0) * 3600 + Number(match[2] ?? 0) * 60 + Number(match[3] ?? 0));
    }

    return /^\d+(\.\d+)?$/.test(body) ? sign * Number(body) * 3600 : null;
}

const ANIMALS = ['Rat', 'Ox', 'Tiger', 'Rabbit', 'Dragon', 'Snake', 'Horse', 'Goat', 'Monkey', 'Rooster', 'Dog', 'Pig'];
const ELEMENTS = ['Wood', 'Fire', 'Earth', 'Metal', 'Water'];

/**
 * The Chinese year a date falls in (the Gregorian year whose New Year has passed), from the New Year dates table.
 */
export function chineseYear(date, newYears) {
    const start = newYears[date.y] ? parseDate(newYears[date.y]) : null;

    if (!start || !newYears[date.y - 1]) {
        return null;
    }

    const year = compare(date, start) >= 0 ? date.y : date.y - 1;
    const stem = (((year - 4) % 10) + 10) % 10;

    return { year, animal: ANIMALS[(((year - 4) % 12) + 12) % 12], element: ELEMENTS[Math.floor(stem / 2)], yin: stem % 2 === 1, start: parseDate(newYears[year]) };
}

const WESTERN = [
    ['Capricorn', 1, 19], ['Aquarius', 2, 18], ['Pisces', 3, 20], ['Aries', 4, 19], ['Taurus', 5, 20], ['Gemini', 6, 20], ['Cancer', 7, 22], ['Leo', 8, 22],
    ['Virgo', 9, 22], ['Libra', 10, 22], ['Scorpio', 11, 21], ['Sagittarius', 12, 21], ['Capricorn', 12, 31],
];

/**
 * Western (tropical) sun sign from the conventional date ranges; the sign changes the day after each listed end date.
 */
export function sunSign({ m, d }) {
    return WESTERN.find(([, month, day]) => m < month || (m === month && d <= day))[0];
}

/**
 * Palindrome check of a date written in a format (separators ignored).
 */
export function dateDigits({ y, m, d }, format) {
    const p2 = (n) => String(n).padStart(2, '0');
    const yyyy = String(y).padStart(4, '0');

    return {
        mdy: `${p2(m)}${p2(d)}${yyyy}`, dmy: `${p2(d)}${p2(m)}${yyyy}`, ymd: `${yyyy}${p2(m)}${p2(d)}`, mdy_short: `${m}${d}${yyyy}`,
        mdyy: `${p2(m)}${p2(d)}${yyyy.slice(-2)}`, ddmmyy: `${p2(d)}${p2(m)}${yyyy.slice(-2)}`,
    }[format];
}

const FORMAT_NAME = { mdy: 'MM/DD/YYYY', dmy: 'DD/MM/YYYY', ymd: 'YYYY-MM-DD', mdy_short: 'M/D/YYYY', mdyy: 'MM/DD/YY', ddmmyy: 'DD/MM/YY' };
const FORMAT_LABEL = { mdy: (x) => `${String(x.m).padStart(2, '0')}/${String(x.d).padStart(2, '0')}/${x.y}`, dmy: (x) => `${String(x.d).padStart(2, '0')}/${String(x.m).padStart(2, '0')}/${x.y}`, ymd: (x) => isoDate(x), mdy_short: (x) => `${x.m}/${x.d}/${x.y}`, mdyy: (x) => `${String(x.m).padStart(2, '0')}/${String(x.d).padStart(2, '0')}/${String(x.y).slice(-2)}`, ddmmyy: (x) => `${String(x.d).padStart(2, '0')}/${String(x.m).padStart(2, '0')}/${String(x.y).slice(-2)}` };

/**
 * Julian-calendar date → day number (days since 1970-01-01).
 */
export function julianToDays({ y, m, d }) {
    const a = Math.floor((14 - m) / 12);
    const yy = y + 4800 - a;
    const mm = m + 12 * a - 3;

    return d + Math.floor((153 * mm + 2) / 5) + 365 * yy + Math.floor(yy / 4) - 32083 - 2440588;
}

function weekendDays(code) {
    return { sat_sun: [0, 6], fri_sat: [5, 6], sun: [0], none: [] }[code] ?? [0, 6];
}

/**
 * Holiday day numbers between two years: US federal (observed dates) or a custom list.
 */
function holidaySet(i, fromYear, toYear) {
    if (i.holidays === 'us') {
        const set = new Map();

        for (let year = fromYear - 1; year <= toYear + 1; year += 1) {
            usFederalHolidays(year).forEach((holiday) => set.set(toDays(holiday.observed), holiday));
        }

        return { set: new Set(set.keys()), names: set, invalid: 0 };
    }

    if (i.holidays === 'custom') {
        const { dates, invalid } = parseDateList(i.holiday_list);

        return { set: new Set(dates.map(toDays)), names: new Map(dates.map((date) => [toDays(date), { name: 'Your holiday', observed: date }])), invalid };
    }

    return { set: new Set(), names: new Map(), invalid: 0 };
}

const zoneLabel = (zone, names) => names?.[zone] ?? zone;

/**
 * The first n leap years from a year onwards.
 */
function leapYearsFrom(year, n) {
    const years = [];

    for (let y = year; years.length < n; y += 1) {
        if (isLeap(y)) {
            years.push(y);
        }
    }

    return years;
}

export const handlers = {
    shift: (i, c, f) => {
        const start = parseTime(i.start);

        if (start === null || !(i.length > 0) || i.length > 24) {
            return { empty: 'Enter a start time and a shift length up to 24 hours.' };
        }

        const breakSeconds = (i.break > 0 ? i.break : 0) * 60;
        const length = i.length * 3600;

        if (breakSeconds >= length) {
            return { error: 'The break is longer than the shift.' };
        }

        const paid = i.paid_break ? length : length - breakSeconds;
        const days = i.days > 0 ? i.days : 5;
        const end = start + length;
        const shifts = Math.floor(24 / i.length);

        return {
            value: clock(end).h12,
            label: 'Shift ends',
            sub: `${clock(start).h12} + ${durationText(length)}${end >= DAY ? ' (next day)' : ''}`,
            rows: {
                paid: `${f(paid / 3600)} hours (${hm(paid)})`,
                week: `${f((paid * days) / 3600)} hours over ${f(days)} shifts`,
                clock24: `${clock(start).h24} – ${clock(end).h24}`,
                cover: shifts >= 2 ? `${shifts} shifts of ${f(i.length)} h cover ${f(shifts * i.length)} of 24 hours` : 'One shift a day',
            },
            lists: {
                rotation: Array.from({ length: Math.max(1, shifts) }, (_, k) => ({
                    label: `Shift ${k + 1}`,
                    value: `${clock(start + k * length).h12} – ${clock(start + (k + 1) * length).h12}`,
                    highlight: k === 0,
                })),
            },
        };
    },

    add_time: (i, c, f) => shiftTime(i, f, 1),
    subtract_time: (i, c, f) => shiftTime(i, f, -1),

    age: (i, c, f) => {
        const birth = parseDate(i.birth);
        const on = dateOr(i.on, i);

        if (!birth || !on) {
            return { empty: 'Enter a date of birth.' };
        }

        if (compare(birth, on) > 0) {
            return { error: 'The date of birth is after the date to measure on.' };
        }

        const age = diffYMD(birth, on);
        const days = toDays(on) - toDays(birth);
        const next = nextAnniversary(birth, addDays(on, 1));

        return {
            value: f(age.years),
            unit: age.years === 1 ? 'year' : 'years',
            label: 'Age',
            sub: ymdText(age),
            rows: {
                months: `${f(age.totalMonths)} months and ${plural(age.days, 'day')}`,
                weeks: `${f(Math.floor(days / 7))} weeks and ${plural(days % 7, 'day')}`,
                days: `${f(days)} days`,
                hours: `${f(days * 24)} hours`,
                next: `${longDate(next.date)}: turns ${next.years} in ${plural(toDays(next.date) - toDays(on), 'day')}`,
                born: `A ${WEEKDAYS[weekday(birth)]}`,
            },
        };
    },

    age_difference: (i, c, f) => {
        const a = parseDate(i.first);
        const b = parseDate(i.second);

        if (!a || !b) {
            return { empty: 'Enter both dates of birth.' };
        }

        const [older, younger] = compare(a, b) <= 0 ? [a, b] : [b, a];
        const gap = diffYMD(older, younger);
        const days = toDays(younger) - toDays(older);

        return {
            value: ymdText(gap),
            label: 'Age difference',
            sub: compare(a, b) === 0 ? 'Born on the same day' : `${compare(a, b) < 0 ? i.first_name || 'Person 1' : i.second_name || 'Person 2'} is older`,
            rows: {
                years: `${f(days / 365.2425)} years (average Gregorian year)`,
                months: `${f(gap.totalMonths)} months and ${plural(gap.days, 'day')}`,
                weeks: `${f(Math.floor(days / 7))} weeks and ${plural(days % 7, 'day')}`,
                days: `${f(days)} days`,
            },
        };
    },

    anniversary: (i, c, f) => {
        const start = parseDate(i.start);
        const on = dateOr(i.on, i);

        if (!start || !on) {
            return { empty: 'Enter the date you got together or married.' };
        }

        if (compare(start, on) > 0) {
            return { error: 'The start date is after the date to measure on.' };
        }

        const together = diffYMD(start, on);
        const next = nextAnniversary(start, addDays(on, 1));
        const days = toDays(on) - toDays(start);
        const isToday = together.months === 0 && together.days === 0 && together.years > 0;

        return {
            value: f(together.years),
            unit: together.years === 1 ? 'year together' : 'years together',
            label: isToday ? `Happy ${ordinal(together.years)} anniversary` : 'Together for',
            sub: `${ymdText(together)}; ${f(days)} days`,
            rows: {
                next: `${ordinal(next.years)} on ${longDate(next.date)}`,
                left: plural(toDays(next.date) - toDays(on), 'day'),
                gift: GIFTS[next.years] ? `${GIFTS[next.years]} (US traditional list)` : 'No traditional gift for this year',
                weeks: `${f(Math.floor(days / 7))} weeks`,
            },
            lists: {
                milestones: [1, 5, 10, 25, 50].map((years) => ({ label: `${ordinal(years)} (${GIFTS[years]})`, value: longDate(addMonths(start, 12 * years)), highlight: years === next.years })),
            },
        };
    },

    baby_age: (i, c, f) => {
        const birth = parseDate(i.birth);
        const on = dateOr(i.on, i);

        if (!birth || !on) {
            return { empty: 'Enter the baby\'s date of birth.' };
        }

        if (compare(birth, on) > 0) {
            return { error: 'The date of birth is after the date to measure on.' };
        }

        const days = toDays(on) - toDays(birth);
        const age = diffYMD(birth, on);
        const due = i.premature ? parseDate(i.due) : null;
        const early = due ? toDays(due) - toDays(birth) : 0;

        if (i.premature && !due) {
            return { empty: 'Enter the due date.' };
        }

        const corrected = days - early;

        return {
            value: `${plural(Math.floor(days / 7), 'week')} ${plural(days % 7, 'day')}`,
            label: 'Baby\'s age',
            sub: `${plural(age.totalMonths, 'month')} and ${plural(age.days, 'day')} (${f(days)} days)`,
            rows: {
                months: `${plural(age.totalMonths, 'month')}, ${plural(age.days, 'day')}`,
                days: `${f(days)} days`,
                corrected: !i.premature ? 'Born at term: no correction' : early <= 0 ? 'The due date is not after the birth date' : corrected < 0 ? `${plural(-corrected, 'day')} before the due date` : `${plural(Math.floor(corrected / 7), 'week')} ${plural(corrected % 7, 'day')} (${plural(diffYMD(due, on).totalMonths, 'month')} ${plural(diffYMD(due, on).days, 'day')})`,
                early: !i.premature ? 'Not entered' : early > 0 ? `Born ${plural(Math.floor(early / 7), 'week')} ${plural(early % 7, 'day')} early` : 'Not early',
            },
        };
    },

    bc_ad: (i, c, f) => {
        if (!(i.year_a >= 1) || !(i.year_b >= 1) || !Number.isInteger(i.year_a) || !Number.isInteger(i.year_b)) {
            return { empty: 'Enter two whole years (1 or later) and their eras.' };
        }

        const astro = (year, era) => (era === 'bc' ? 1 - year : year);
        const a = astro(i.year_a, i.era_a);
        const b = astro(i.year_b, i.era_b);
        const years = Math.abs(b - a);
        const name = (year, era) => (era === 'bc' ? `${year} BC` : `AD ${year}`);

        return {
            value: f(years),
            unit: years === 1 ? 'year' : 'years',
            label: 'Years between',
            sub: `From ${name(i.year_a, i.era_a)} to ${name(i.year_b, i.era_b)}; there is no year 0, so 1 BC is followed by AD 1`,
            rows: {
                astronomical: `${a} and ${b} (astronomical numbering, where 1 BC = 0)`,
                centuries: `${f(years / 100)} centuries`,
                naive: i.era_a !== i.era_b ? `Adding the two numbers gives ${f(i.year_a + i.year_b)}, one too many` : 'Same era: a simple difference',
            },
        };
    },

    birthday: (i, c, f) => {
        const birth = parseDate(i.birth);
        const on = dateOr(i.on, i);

        if (!birth || !on) {
            return { empty: 'Enter a date of birth.' };
        }

        if (compare(birth, on) > 0) {
            return { error: 'The date of birth is after today\'s date.' };
        }

        const next = nextAnniversary(birth, on);
        const left = toDays(next.date) - toDays(on);

        return {
            value: WEEKDAYS[weekday(birth)],
            label: 'You were born on a',
            sub: longDate(birth),
            rows: {
                next: left === 0 ? `Today! You turn ${next.years}` : `${longDate(next.date)} (turning ${next.years})`,
                left: plural(left, 'day'),
                lived: `${f(toDays(on) - toDays(birth))} days`,
                leap: birth.m === 2 && birth.d === 29 ? 'A leap-day birthday: celebrated on 28 February in common years here' : 'Every year',
            },
            lists: {
                upcoming: Array.from({ length: 6 }, (_, k) => {
                    const date = addMonths(birth, 12 * (next.years + k));

                    return { label: `${ordinal(next.years + k)} birthday`, value: longDate(date), highlight: k === 0 };
                }),
            },
        };
    },

    business_days: (i, c, f) => {
        const start = parseDate(i.start);
        const endInput = parseDate(i.end);

        if (!start || !endInput) {
            return { empty: 'Enter a start and an end date.' };
        }

        const [from, to] = compare(start, endInput) <= 0 ? [start, endInput] : [endInput, start];

        if (toDays(to) - toDays(from) > 366 * 200) {
            return { error: 'Use a range of 200 years or less.' };
        }

        const end = i.include_end ? addDays(to, 1) : to;
        const holidays = holidaySet(i, from.y, to.y);
        const counted = countDays(i.include_start === false ? addDays(from, 1) : from, end, { weekend: weekendDays(i.weekend), holidays: holidays.set });
        const skipped = [...holidays.names.entries()].filter(([day]) => day >= toDays(from) && day < toDays(end) && !weekendDays(i.weekend).includes((((day + 4) % 7) + 7) % 7));

        return {
            value: f(counted.workdays),
            unit: counted.workdays === 1 ? 'business day' : 'business days',
            label: 'Business days',
            sub: `${shortDate(from)} to ${shortDate(to)}, ${i.include_end ? 'including' : 'not including'} the end date`,
            rows: {
                total: `${f(counted.total)} calendar days`,
                weekend: `${f(counted.weekendDays)} weekend days`,
                holidays: i.holidays === 'none' ? 'None set' : `${f(counted.holidaysSkipped)} on workdays${holidays.invalid ? ` (${holidays.invalid} entries not read)` : ''}`,
                weeks: `${f(counted.workdays / (7 - weekendDays(i.weekend).length || 7))} working weeks`,
            },
            lists: {
                skipped: skipped.length ? skipped.slice(0, 40).map(([day, holiday]) => ({ label: holiday.name, value: longDate(fromDays(day)) })) : [{ label: 'Holidays skipped', value: 'None in this range' }],
            },
        };
    },

    calendar: (i, c, f) => {
        const y = i.year;
        const m = Number(i.month);

        if (!Number.isInteger(y) || y < 1 || y > 9999 || !(m >= 1 && m <= 12)) {
            return { empty: 'Enter a year from 1 to 9999.' };
        }

        const sundayFirst = i.start === 'sunday';
        const first = { y, m, d: 1 };
        const offset = sundayFirst ? weekday(first) : (weekday(first) + 6) % 7;
        const total = daysInMonth(y, m);
        const rows = [];
        const holidays = new Map(usFederalHolidays(y).filter((h) => h.date.m === m).map((h) => [h.date.d, h.name]));

        for (let start = 1 - offset; start <= total; start += 7) {
            const cells = Array.from({ length: 7 }, (_, k) => {
                const d = start + k;

                return d >= 1 && d <= total ? `${d}${holidays.has(d) ? '*' : ''}` : '';
            });
            const monday = start + (sundayFirst ? 1 : 0);
            const weekDate = addDays(first, monday - 1);
            rows.push({ header: `W${isoWeek(weekDate).week}`, cells });
        }

        const counted = countDays(first, addDays(first, total), { weekend: [0, 6] });
        const names = sundayFirst ? ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] : ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        return {
            value: `${MONTHS[m - 1]} ${y}`,
            label: 'Calendar',
            sub: `${total} days, starting on a ${WEEKDAYS[weekday(first)]}`,
            rows: {
                weekdays: `${counted.workdays} weekdays (Mon–Fri), ${counted.weekendDays} weekend days`,
                weeks: `ISO weeks ${isoWeek(first).week}–${isoWeek({ y, m, d: total }).week}`,
                year: `${y} has ${daysInYear(y)} days${isLeap(y) ? ' (leap year)' : ''} and ${isoWeeksInYear(y)} ISO weeks`,
                quarter: `Q${Math.ceil(m / 3)}`,
            },
            grids: { month: { columns: names, rows, roomy: true } },
            lists: {
                holidays: holidays.size ? [...holidays.entries()].map(([d, name]) => ({ label: `${d}* ${name}`, value: WEEKDAYS[weekday({ y, m, d })] })) : [{ label: 'US federal holidays', value: 'None this month' }],
            },
        };
    },

    chronological_age: (i, c, f) => {
        const birth = parseDate(i.birth);
        const test = dateOr(i.test, i);

        if (!birth || !test) {
            return { empty: 'Enter the date of birth and the test date.' };
        }

        if (compare(birth, test) > 0) {
            return { error: 'The date of birth is after the test date.' };
        }

        const exact = diffYMD(birth, test);
        // Test manuals subtract each part and borrow 30 days for a month and 12 months for a year.
        let days = test.d - birth.d;
        let months = test.m - birth.m;
        let years = test.y - birth.y;

        if (days < 0) {
            days += 30;
            months -= 1;
        }

        if (months < 0) {
            months += 12;
            years -= 1;
        }

        const rounded = days >= 16 ? (months === 11 ? `${years + 1};0` : `${years};${months + 1}`) : `${years};${months}`;

        return {
            value: `${exact.years};${exact.months};${exact.days}`,
            label: 'Chronological age (years;months;days)',
            sub: ymdText(exact),
            rows: {
                borrow: `${years};${months};${days} (subtracting with 30-day months)`,
                rounded: `${rounded} (rounding 16 days or more up a month)`,
                months: `${f(exact.totalMonths)} months`,
                note: 'Check your test manual: some score in years;months and differ in how they round',
            },
        };
    },

    date_calc: (i, c, f) => {
        const start = parseDate(i.start);

        if (!start) {
            return { empty: 'Enter a start date.' };
        }

        const sign = i.operation === 'subtract' ? -1 : 1;
        const whole = (key) => (Number.isFinite(i[key]) ? Math.trunc(i[key]) : 0);
        const months = whole('years') * 12 + whole('months');
        const days = whole('weeks') * 7 + whole('days');
        const step = addMonths(start, sign * months);
        const end = addDays(step, sign * days);

        if (end.y < 1 || end.y > 9999) {
            return { error: 'The result is outside the years 1–9999.' };
        }

        return {
            value: longDate(end),
            label: sign > 0 ? 'Date after adding' : 'Date after subtracting',
            sub: `${longDate(start)} ${sign > 0 ? '+' : '−'} ${plural(whole('years'), 'year')}, ${plural(whole('months'), 'month')}, ${plural(whole('weeks'), 'week')}, ${plural(whole('days'), 'day')}`,
            rows: {
                iso: isoDate(end),
                day: `Day ${dayOfYear(end)} of ${daysInYear(end.y)}`,
                week: `ISO week ${isoWeek(end).week} of ${isoWeek(end).year}`,
                apart: `${f(Math.abs(toDays(end) - toDays(start)))} days from the start date`,
                clamp: step.d !== start.d ? `${MONTHS[step.m - 1]} has no day ${start.d}, so the month step lands on day ${step.d}` : 'Months and years are added first, then weeks and days',
            },
        };
    },

    date_to_date: (i, c, f) => {
        const a = parseDate(i.start);
        const b = parseDate(i.end);

        if (!a || !b) {
            return { empty: 'Enter a start and an end date.' };
        }

        const [from, to] = compare(a, b) <= 0 ? [a, b] : [b, a];
        const end = i.include_end ? addDays(to, 1) : to;
        const days = toDays(end) - toDays(from);
        const ymd = diffYMD(from, end);

        return {
            value: f(days),
            unit: days === 1 ? 'day' : 'days',
            label: 'Duration',
            sub: `${ymdText(ymd)}${compare(a, b) > 0 ? ' (the end date is before the start date)' : ''}`,
            rows: {
                weeks: `${f(Math.floor(days / 7))} weeks and ${plural(days % 7, 'day')}`,
                months: `${f(ymd.totalMonths)} months and ${plural(ymd.days, 'day')}`,
                years: `${f(days / 365.2425)} years`,
                hours: `${f(days * 24)} hours`,
                minutes: `${f(days * 1440)} minutes`,
                seconds: `${f(days * DAY)} seconds`,
            },
        };
    },

    day_counter: (i, c, f) => {
        const a = parseDate(i.start);
        const b = parseDate(i.end);

        if (!a || !b) {
            return { empty: 'Enter a start and an end date.' };
        }

        const [from, to] = compare(a, b) <= 0 ? [a, b] : [b, a];

        if (toDays(to) - toDays(from) > 366 * 1000) {
            return { error: 'Use a range of 1,000 years or less.' };
        }

        const end = i.include_end ? addDays(to, 1) : to;
        const counted = countDays(from, end, { weekend: [0, 6] });
        const perWeekday = Array(7).fill(0);

        for (let day = toDays(from); day < toDays(end); day += 1) {
            perWeekday[(((day + 4) % 7) + 7) % 7] += 1;
        }

        return {
            value: f(counted.total),
            unit: counted.total === 1 ? 'day' : 'days',
            label: 'Days',
            sub: `${shortDate(from)} to ${shortDate(to)}, ${i.include_end ? 'counting both ends' : 'not counting the end date'}`,
            rows: {
                weekdays: `${f(counted.workdays)} weekdays (Monday–Friday)`,
                weekend: `${f(counted.weekendDays)} weekend days`,
                weeks: `${f(Math.floor(counted.total / 7))} full weeks and ${plural(counted.total % 7, 'day')}`,
            },
            lists: { weekdays: [1, 2, 3, 4, 5, 6, 0].map((wd) => ({ label: WEEKDAYS[wd], value: f(perWeekday[wd]) })) },
        };
    },

    day_of_year: (i, c, f) => {
        let date;

        if (i.mode === 'number') {
            if (!Number.isInteger(i.year) || i.year < 1 || !Number.isInteger(i.day) || i.day < 1) {
                return { empty: 'Enter a year and a day number.' };
            }

            if (i.day > daysInYear(i.year)) {
                return { error: `${i.year} has only ${daysInYear(i.year)} days.` };
            }

            date = addDays({ y: i.year, m: 1, d: 1 }, i.day - 1);
        } else {
            date = parseDate(i.date);
        }

        if (!date) {
            return { empty: 'Enter a date.' };
        }

        const n = dayOfYear(date);
        const total = daysInYear(date.y);

        return {
            value: i.mode === 'number' ? longDate(date) : f(n),
            unit: i.mode === 'number' ? '' : `of ${total}`,
            label: i.mode === 'number' ? `Day ${i.day} of ${i.year} is` : 'Day of the year',
            sub: i.mode === 'number' ? `Day ${n} of ${total}` : longDate(date),
            rows: {
                left: `${f(total - n)} days left in ${date.y}`,
                percent: `${f((n / total) * 100)}% of the year done`,
                week: `ISO week ${isoWeek(date).week}`,
                ordinal: `${date.y}-${String(n).padStart(3, '0')} (ISO 8601 ordinal date)`,
                quarter: `Q${Math.ceil(date.m / 3)}`,
            },
        };
    },

    day_of_week: (i, c, f) => {
        const match = /^(\d{1,4})-(\d{2})-(\d{2})$/.exec(String(i.date ?? '').trim());

        if (!match) {
            return { empty: 'Enter a date.' };
        }

        const date = { y: Number(match[1]), m: Number(match[2]), d: Number(match[3]) };
        const julian = i.calendar === 'julian';
        const monthLength = julian && date.m === 2 ? (date.y % 4 === 0 ? 29 : 28) : daysInMonth(date.y, date.m);

        if (date.y < 1 || date.m < 1 || date.m > 12 || date.d < 1 || date.d > monthLength) {
            return { error: 'That date does not exist in this calendar.' };
        }

        const days = julian ? julianToDays(date) : toDays(date);
        const wd = (((days + 4) % 7) + 7) % 7;
        const gregorian = fromDays(days);
        const doomsday = weekday({ y: gregorian.y, m: 4, d: 4 });

        return {
            value: WEEKDAYS[wd],
            label: 'Day of the week',
            sub: julian ? `${isoDate(date)} (Julian) = ${longDate(gregorian)} (Gregorian)` : longDate(date),
            rows: {
                iso: `ISO weekday ${wd || 7} (Monday = 1)`,
                week: `ISO week ${isoWeek(gregorian).week} of ${isoWeek(gregorian).year}`,
                doomsday: `${WEEKDAYS[doomsday]} (Conway's Doomsday for ${gregorian.y}: 4/4, 6/6, 8/8, 10/10, 12/12 share it)`,
                gregorian: julian ? `${f(days - toDays(date))} days between the calendars' labels` : 'Proleptic Gregorian calendar',
            },
        };
    },

    every_second: (i, c, f) => {
        const birth = parseDate(i.birth);
        const time = i.time ? parseTime(i.time) : 0;

        if (!birth || time === null) {
            return { empty: 'Enter your date of birth.' };
        }

        const now = nowCivil(i);
        const seconds = now - civilSeconds({ date: birth, seconds: time });

        if (seconds < 0) {
            return { error: 'The date of birth is in the future.' };
        }

        const billion = fromCivilSeconds(civilSeconds({ date: birth, seconds: time }) + 1e9);

        return {
            value: f(Math.floor(seconds)),
            unit: 'seconds',
            label: 'You have been alive for',
            sub: durationText(seconds),
            rows: {
                minutes: `${f(Math.floor(seconds / 60))} minutes`,
                hours: `${f(Math.floor(seconds / 3600))} hours`,
                days: `${f(Math.floor(seconds / DAY))} days`,
                weeks: `${f(Math.floor(seconds / DAY / 7))} weeks`,
                heart: `About ${f(Math.round((seconds / 60) * 70))} heartbeats at 70 a minute (resting rates are 60–100)`,
                breaths: `About ${f(Math.round((seconds / 60) * 15))} breaths at 15 a minute (adults: 12–20)`,
                billion: `${seconds < 1e9 ? 'Your billionth second: ' : 'You passed a billion seconds on '}${at(billion)}`,
            },
        };
    },

    half_birthday: (i, c, f) => {
        const birth = parseDate(i.birth);
        const on = dateOr(i.on, i);

        if (!birth || !on) {
            return { empty: 'Enter a date of birth.' };
        }

        if (compare(birth, on) > 0) {
            return { error: 'The date of birth is after today\'s date.' };
        }

        const half = addMonths(birth, 6);
        let years = Math.max(0, on.y - half.y);
        let next = addMonths(half, 12 * years);

        while (compare(next, on) < 0) {
            years += 1;
            next = addMonths(half, 12 * years);
        }

        return {
            value: longDate(next),
            label: 'Next half birthday',
            sub: `${MONTHS[half.m - 1]} ${half.d} every year: six months after ${MONTHS[birth.m - 1]} ${birth.d}`,
            rows: {
                left: toDays(next) === toDays(on) ? 'Today!' : plural(toDays(next) - toDays(on), 'day'),
                age: `You will be ${years}½`,
                rule: half.d !== birth.d ? `${MONTHS[half.m - 1]} has no day ${birth.d}, so it falls on the last day of the month` : 'Same day of the month, six months on',
            },
        };
    },

    hours: (i, c, f) => {
        const start = parseTime(i.start);
        const end = parseTime(i.end);

        if (start === null || end === null) {
            return { empty: 'Enter a start and an end time.' };
        }

        const span = end > start ? end - start : end - start + DAY;
        const breakSeconds = (i.break > 0 ? i.break : 0) * 60;

        if (breakSeconds >= span) {
            return { error: 'The break is as long as the time worked.' };
        }

        const worked = span - breakSeconds;

        return {
            value: f(worked / 3600),
            unit: 'hours',
            label: 'Hours',
            sub: `${clock(start).h12} to ${clock(end).h12}${end <= start ? ' the next day' : ''}${breakSeconds ? `, less a ${f(i.break)}-minute break` : ''}`,
            rows: {
                hm: `${hm(worked)} (hours:minutes)`,
                minutes: `${f(worked / 60)} minutes`,
                span: `${hm(span)} from start to end`,
                pay: i.rate > 0 ? `${f((worked / 3600) * i.rate)} at ${f(i.rate)} an hour` : 'Enter an hourly rate to see pay',
            },
        };
    },

    hours_minutes: (i, c, f) => {
        const lines = String(i.times ?? '').split(/\n+/).map((line) => line.trim()).filter(Boolean);
        const values = lines.map(parseDuration);
        const bad = values.filter((value) => value === null).length;
        const total = values.filter((value) => value !== null).reduce((sum, value) => sum + value, 0);

        if (!lines.length || bad === lines.length) {
            return { empty: 'Enter times such as 1:30, +2:45 or -0:20, one per line.' };
        }

        return {
            value: hm(total),
            unit: 'h:mm',
            label: 'Total',
            sub: `${f(lines.length - bad)} entries${bad ? `; ${bad} not read` : ''}`,
            rows: {
                decimal: `${f(total / 3600)} hours`,
                minutes: `${f(total / 60)} minutes`,
                days: durationText(total, { units: ['day', 'h', 'min'] }),
            },
            lists: { entries: lines.slice(0, 30).map((line, k) => ({ label: line, value: values[k] === null ? 'Not read' : hm(values[k]) })) },
        };
    },

    korean_age: (i, c, f) => {
        const birth = parseDate(i.birth);
        const on = dateOr(i.on, i);

        if (!birth || !on) {
            return { empty: 'Enter a date of birth.' };
        }

        if (compare(birth, on) > 0) {
            return { error: 'The date of birth is after the date to measure on.' };
        }

        const international = diffYMD(birth, on).years;

        return {
            value: f(on.y - birth.y + 1),
            unit: 'years (Korean age)',
            label: 'Korean age (세는 나이)',
            sub: 'Counted from 1 at birth, adding a year every 1 January',
            rows: {
                international: `${f(international)} (international age, 만 나이, the legal age in Korea since 28 June 2023)`,
                year: `${f(on.y - birth.y)} (year age, 연 나이, still used for school entry, military service and the youth protection laws)`,
                gap: `${f(on.y - birth.y + 1 - international)} years more than international age`,
            },
        };
    },

    leap_year: (i, c, f) => {
        const y = i.year;

        if (!Number.isInteger(y) || y < 1) {
            return { empty: 'Enter a year.' };
        }

        const leap = isLeap(y);
        const reason = y % 400 === 0 ? 'divisible by 400' : y % 100 === 0 ? 'divisible by 100 but not 400' : y % 4 === 0 ? 'divisible by 4 and not by 100' : 'not divisible by 4';
        let previous = y - 1;
        let next = y + 1;

        while (previous > 0 && !isLeap(previous)) {
            previous -= 1;
        }

        while (!isLeap(next)) {
            next += 1;
        }

        const from = Number.isInteger(i.from) ? i.from : null;
        const to = Number.isInteger(i.to) ? i.to : null;
        let inRange = null;

        if (from !== null && to !== null && from >= 1 && to >= from) {
            const leapsUpTo = (n) => Math.floor(n / 4) - Math.floor(n / 100) + Math.floor(n / 400);
            inRange = leapsUpTo(to) - leapsUpTo(from - 1);
        }

        return {
            value: leap ? 'Yes' : 'No',
            label: `Is ${y} a leap year?`,
            sub: `${y} is ${reason}${leap ? ', so February has 29 days' : ', so February has 28 days'} (Gregorian rule)`,
            rows: {
                days: `${daysInYear(y)} days`,
                previous: previous > 0 ? String(previous) : 'None',
                next: String(next),
                range: inRange === null ? 'Enter a range to count leap years' : `${f(inRange)} leap years from ${from} to ${to}`,
            },
            lists: { upcoming: leapYearsFrom(y, 8).map((year) => ({ label: String(year), value: `29 February is a ${WEEKDAYS[weekday({ y: year, m: 2, d: 29 })]}`, highlight: year === y })) },
        };
    },

    lunar_age: (i, c, f) => {
        const birth = parseDate(i.birth);
        const on = dateOr(i.on, i);

        if (!birth || !on) {
            return { empty: 'Enter a date of birth.' };
        }

        if (compare(birth, on) > 0) {
            return { error: 'The date of birth is after the date to measure on.' };
        }

        const years = c.data.chinese_new_year;
        const born = chineseYear(birth, years);
        const now = chineseYear(on, years);

        if (!born || !now) {
            return { error: 'Dates from 31 January 1900 to 31 December 2099 are supported.' };
        }

        const lunar = now.year - born.year + 1;

        return {
            value: f(lunar),
            unit: lunar === 1 ? 'year' : 'years',
            label: 'Lunar (nominal) age',
            sub: `1 at birth, plus 1 at each Chinese New Year; born in the Year of the ${born.animal}`,
            rows: {
                zodiac: `${born.element} ${born.animal} (${born.yin ? 'yin' : 'yang'}), year starting ${longDate(born.start)}`,
                international: `${f(diffYMD(birth, on).years)} (international age)`,
                year: `Now in the Year of the ${now.animal}, from ${longDate(now.start)}`,
                next: years[now.year + 1] ? `Next Chinese New Year: ${longDate(parseDate(years[now.year + 1]))}` : '—',
            },
        };
    },

    minute: (i, c, f) => {
        let seconds;

        if (i.mode === 'convert') {
            seconds = (Number.isFinite(i.hours) ? i.hours : 0) * 3600 + (Number.isFinite(i.minutes) ? i.minutes : 0) * 60;

            if (!(seconds >= 0) || (!Number.isFinite(i.hours) && !Number.isFinite(i.minutes))) {
                return { empty: 'Enter hours and minutes.' };
            }
        } else {
            const start = parseTime(i.start);
            const end = parseTime(i.end);

            if (start === null || end === null) {
                return { empty: 'Enter a start and an end time.' };
            }

            seconds = end > start ? end - start : end - start + DAY;
        }

        return {
            value: f(seconds / 60),
            unit: 'minutes',
            label: i.mode === 'convert' ? 'In minutes' : 'Minutes between',
            sub: `${hm(seconds)} (hours:minutes)`,
            rows: { hours: `${f(seconds / 3600)} hours`, seconds: `${f(seconds)} seconds`, days: `${f(seconds / DAY)} days` },
        };
    },

    months_between: (i, c, f) => {
        const a = parseDate(i.start);
        const b = parseDate(i.end);

        if (!a || !b) {
            return { empty: 'Enter a start and an end date.' };
        }

        const [from, to] = compare(a, b) <= 0 ? [a, b] : [b, a];
        const ymd = diffYMD(from, to);
        const days = toDays(to) - toDays(from);
        const fraction = ymd.days / daysInMonth(addMonths(from, ymd.totalMonths).y, addMonths(from, ymd.totalMonths).m);

        return {
            value: f(ymd.totalMonths),
            unit: ymd.totalMonths === 1 ? 'month' : 'months',
            label: 'Whole months between',
            sub: `${plural(ymd.totalMonths, 'month')} and ${plural(ymd.days, 'day')}`,
            rows: {
                exact: `${f(ymd.totalMonths + fraction)} months (days as a share of the next month)`,
                average: `${f(days / 30.436875)} months of average length (30.44 days)`,
                ymd: ymdText(ymd),
                days: `${f(days)} days`,
            },
        };
    },

    moon_phase: (i, c, f) => {
        const date = parseDate(i.date);
        const time = i.time ? parseTime(i.time) : 0;

        if (!date || time === null) {
            return { empty: 'Enter a date.' };
        }

        if (date.y < 1900 || date.y > 2100) {
            return { error: 'Use a date between 1900 and 2100.' };
        }

        const zone = i.zone || 'UTC';
        const epoch = zonedToEpoch({ year: date.y, month: date.m, day: date.d, hour: Math.floor(time / 3600), minute: Math.floor((time % 3600) / 60) }, zone);
        const moon = moonAt(jdFromMs(epoch));
        const name = phaseName(moon.age, moon.fraction, moon.waxing);
        const local = (jd) => new Intl.DateTimeFormat('en-US', { timeZone: zone, weekday: 'short', month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' }).format(new Date(msFromJd(jd)));

        return {
            value: name,
            label: 'Moon phase',
            sub: `${(moon.fraction * 100).toFixed(1)}% illuminated, ${moon.waxing ? 'waxing' : 'waning'}`,
            rows: {
                age: `${moon.age.toFixed(1)} days since the new moon (a lunar month is ${SYNODIC_MONTH.toFixed(2)} days)`,
                new: local(moon.next.new),
                first: local(moon.next.first),
                full: local(moon.next.full),
                last: local(moon.next.last),
                zone: `Times in ${zoneLabel(zone, c.data?.zones)} (${formatOffset(zoneOffsetMinutes(epoch, zone))})`,
            },
        };
    },

    palindrome: (i, c, f) => {
        const from = i.from;
        const to = i.to;

        if (!Number.isInteger(from) || !Number.isInteger(to) || from < 1 || to < from) {
            return { empty: 'Enter a range of years.' };
        }

        if (to - from > 2000 || to > 9999) {
            return { error: 'Search up to 2,000 years at a time, up to the year 9999.' };
        }

        const found = [];

        for (let day = toDays({ y: from, m: 1, d: 1 }), end = toDays({ y: to, m: 12, d: 31 }); day <= end; day += 1) {
            const date = fromDays(day);
            const digits = dateDigits(date, i.format);

            if (digits === [...digits].reverse().join('')) {
                found.push(date);
            }
        }

        const now = today(i);
        const next = found.find((date) => compare(date, now) >= 0);

        return {
            value: f(found.length),
            unit: found.length === 1 ? 'palindrome date' : 'palindrome dates',
            label: 'Palindrome dates found',
            sub: `${from}–${to}, written ${FORMAT_NAME[i.format]}`,
            rows: {
                next: next ? `${FORMAT_LABEL[i.format](next)} (${longDate(next)})` : 'None after today in this range',
                first: found.length ? FORMAT_LABEL[i.format](found[0]) : '—',
                last: found.length ? FORMAT_LABEL[i.format](found.at(-1)) : '—',
            },
            lists: { dates: found.length ? found.slice(0, 40).map((date) => ({ label: FORMAT_LABEL[i.format](date), value: longDate(date), highlight: next && compare(date, next) === 0 })) : [{ label: 'Palindromes', value: 'None in this range' }] },
        };
    },

    reverse_time: (i, c, f) => {
        const end = parseDateTime(i.end);

        if (!end) {
            return { empty: 'Enter when you need to finish.' };
        }

        // Each line is 'Step name, minutes' (or just minutes).
        const parsed = String(i.steps ?? '').split('\n').map((line) => line.trim()).filter(Boolean).map((line) => {
            const match = /^(.*?)[,\t:]?\s*(\d+(?:\.\d+)?)\s*(?:min(?:utes?)?)?$/i.exec(line);

            return match ? { name: match[1].replace(/[,\t:]\s*$/, '').trim() || 'Step', seconds: Number(match[2]) * 60 } : null;
        }).filter(Boolean);
        const total = parsed.reduce((sum, step) => sum + step.seconds, 0) + durationFrom(i, '');

        if (!(total > 0)) {
            return { empty: 'Enter a duration or add steps with their minutes.' };
        }

        const start = fromCivilSeconds(civilSeconds(end) - total);
        let cursor = civilSeconds(start);
        const schedule = parsed.map((step) => {
            const row = { label: step.name, value: `${clock(cursor).h12} → ${clock(cursor + step.seconds).h12}` };
            cursor += step.seconds;

            return row;
        });

        return {
            value: at(start),
            label: 'Start at',
            sub: `${durationText(total)} before ${at(end)}`,
            rows: {
                clock24: `${isoDate(start.date)} ${clock(start.seconds).h24}`,
                total: `${f(total / 60)} minutes in all`,
                day: toDays(start.date) === toDays(end.date) ? 'Same day' : `${plural(toDays(end.date) - toDays(start.date), 'day')} before`,
            },
            lists: { schedule: schedule.length ? schedule : [{ label: 'Steps', value: 'Add steps to see a schedule' }] },
        };
    },

    sidereal: (i, c, f) => {
        const date = parseDate(i.date);
        const time = i.time ? parseTime(i.time) : 0;

        if (!date || time === null || !Number.isFinite(i.longitude) || Math.abs(i.longitude) > 180) {
            return { empty: 'Enter a date, a UTC time and a longitude from −180° to 180°.' };
        }

        const jd = toDays(date) + 2440587.5 + time / DAY;
        const mean = gmst(jd);
        const apparent = mean + equationOfEquinoxes(jd);
        const east = i.longitude;

        return {
            value: hms(mean + east),
            label: 'Local mean sidereal time',
            sub: `At longitude ${f(Math.abs(east))}° ${east >= 0 ? 'E' : 'W'}, ${isoDate(date)} ${clock(time, { withSeconds: true }).h24} UTC`,
            rows: {
                gmst: hms(mean),
                gast: hms(apparent),
                last: hms(apparent + east),
                degrees: `${f(((mean + east) % 360 + 360) % 360)}° (LMST in degrees)`,
                jd: `JD ${f(jd)}`,
            },
        };
    },

    sleep: (i, c, f) => {
        const time = parseTime(i.time);

        if (time === null) {
            return { empty: 'Enter a time.' };
        }

        const latency = (i.latency >= 0 ? i.latency : 15) * 60;
        const cycle = (i.cycle > 0 ? i.cycle : 90) * 60;
        const options = [6, 5, 4, 3].map((cycles) => {
            const sleep = cycles * cycle;
            const when = i.mode === 'wake' ? time - sleep - latency : time + latency + sleep;

            return { cycles, sleep, when };
        });
        // Suggest the whole number of cycles closest to 8 hours of sleep.
        const best = options.reduce((closest, option) => (Math.abs(option.sleep - 8 * 3600) < Math.abs(closest.sleep - 8 * 3600) ? option : closest));

        return {
            value: clock(best.when).h12,
            label: i.mode === 'wake' ? 'Go to bed at' : 'Set your alarm for',
            sub: `${best.cycles} cycles of ${f(cycle / 60)} min = ${f(best.sleep / 3600)} h of sleep, plus ${f(latency / 60)} min to fall asleep`,
            rows: {
                range: 'Adults need 7 or more hours a night (AASM and Sleep Research Society)',
                cycle: `Sleep cycles run about 90 minutes but vary from about 70 to 120`,
            },
            lists: { options: options.map((option) => ({ label: `${option.cycles} cycles (${f(option.sleep / 3600)} h)`, value: `${clock(option.when).h12}`, highlight: option === best })) },
        };
    },

    time_calc: (i, c, f) => {
        const a = durationFrom(i, 'a_');
        const b = durationFrom(i, 'b_');
        let total;

        if (i.operation === 'multiply' || i.operation === 'divide') {
            if (!Number.isFinite(i.factor) || (i.operation === 'divide' && i.factor === 0)) {
                return { empty: 'Enter a number to multiply or divide by (not 0).' };
            }

            total = i.operation === 'multiply' ? a * i.factor : a / i.factor;
        } else {
            total = i.operation === 'subtract' ? a - b : a + b;
        }

        return {
            value: durationText(total),
            label: 'Result',
            sub: `${hm(total)} (hours:minutes)`,
            rows: {
                hours: `${f(total / 3600)} hours`,
                minutes: `${f(total / 60)} minutes`,
                seconds: `${f(total)} seconds`,
                days: `${f(total / DAY)} days`,
            },
        };
    },

    time_difference: (i, c, f) => {
        const start = parseDateTime(i.start);
        const end = parseDateTime(i.end);

        if (!start || !end) {
            return { empty: 'Enter both date-times.' };
        }

        const toEpoch = ({ date, seconds }, zone) => zonedToEpoch({ year: date.y, month: date.m, day: date.d, hour: Math.floor(seconds / 3600), minute: Math.floor((seconds % 3600) / 60) }, zone);
        const a = toEpoch(start, i.start_zone || 'UTC');
        const b = toEpoch(end, i.end_zone || 'UTC');
        const seconds = (b - a) / 1000;
        const offsetA = zoneOffsetMinutes(a, i.start_zone || 'UTC');
        const offsetB = zoneOffsetMinutes(b, i.end_zone || 'UTC');
        const startThere = new Intl.DateTimeFormat('en-US', { timeZone: i.end_zone || 'UTC', dateStyle: 'medium', timeStyle: 'short' }).format(new Date(a));

        return {
            value: durationText(seconds, { units: ['day', 'h', 'min'] }),
            label: seconds < 0 ? 'The end is before the start by' : 'Time between',
            sub: `${f(Math.abs(seconds) / 3600)} hours, with each time read in its own time zone`,
            rows: {
                hm: `${hm(seconds)} (hours:minutes)`,
                minutes: `${f(seconds / 60)} minutes`,
                offsets: `${formatOffset(offsetA)} → ${formatOffset(offsetB)} (${f((offsetB - offsetA) / 60)} h apart)`,
                there: `The start is ${startThere} in ${zoneLabel(i.end_zone || 'UTC', c.data?.zones)}`,
            },
        };
    },

    time_duration: (i, c, f) => {
        const start = parseDateTime(i.start);
        const end = parseDateTime(i.end);

        if (!start || !end) {
            return { empty: 'Enter a start and an end date and time.' };
        }

        const seconds = civilSeconds(end) - civilSeconds(start);
        const [from, to] = seconds >= 0 ? [start, end] : [end, start];
        let calendar = diffYMD(from.date, to.date);
        let rest = to.seconds - from.seconds;

        if (rest < 0) {
            calendar = diffYMD(from.date, addDays(to.date, -1));
            rest += DAY;
        }

        return {
            value: durationText(Math.abs(seconds), { units: ['day', 'h', 'min'] }),
            label: seconds < 0 ? 'Duration (end before start)' : 'Duration',
            sub: `${ymdText(calendar)}, ${durationText(rest, { units: ['h', 'min'] })}`,
            rows: {
                hours: `${f(Math.abs(seconds) / 3600)} hours`,
                minutes: `${f(Math.abs(seconds) / 60)} minutes`,
                seconds: `${f(Math.abs(seconds))} seconds`,
                weeks: `${f(Math.abs(seconds) / DAY / 7)} weeks`,
                note: 'Clock times, ignoring any daylight-saving change in between',
            },
        };
    },

    time_decimal: (i, c, f) => {
        let seconds;

        if (i.mode === 'decimal') {
            if (!Number.isFinite(i.decimal)) {
                return { empty: 'Enter decimal hours.' };
            }

            seconds = i.decimal * 3600;
        } else {
            if (![i.hours, i.minutes, i.seconds].some(Number.isFinite)) {
                return { empty: 'Enter hours, minutes and seconds.' };
            }

            seconds = (Number.isFinite(i.hours) ? i.hours : 0) * 3600 + (Number.isFinite(i.minutes) ? i.minutes : 0) * 60 + (Number.isFinite(i.seconds) ? i.seconds : 0);
        }

        const whole = Math.round(Math.abs(seconds));
        const hms = `${seconds < 0 ? '−' : ''}${Math.floor(whole / 3600)}:${String(Math.floor((whole % 3600) / 60)).padStart(2, '0')}:${String(whole % 60).padStart(2, '0')}`;

        return {
            value: i.mode === 'decimal' ? hms : f(seconds / 3600),
            unit: i.mode === 'decimal' ? 'h:mm:ss' : 'hours',
            label: i.mode === 'decimal' ? 'Hours, minutes and seconds' : 'Decimal hours',
            sub: i.mode === 'decimal' ? `${f(i.decimal)} h = ${durationText(seconds, { units: ['h', 'min', 's'] })}` : `${hms} = ${f(seconds / 3600)} h`,
            rows: {
                minutes: `${f(seconds / 60)} minutes (decimal minutes)`,
                seconds: `${f(seconds)} seconds`,
                hms,
                days: `${f(seconds / DAY)} days`,
            },
        };
    },

    week: (i, c, f) => {
        if (i.mode === 'number') {
            const date = parseDate(i.date);

            if (!date) {
                return { empty: 'Enter a date.' };
            }

            const iso = isoWeek(date);
            const monday = addDays(date, -((weekday(date) + 6) % 7));

            return {
                value: `Week ${iso.week}`,
                label: 'ISO week number',
                sub: `${iso.year}-W${String(iso.week).padStart(2, '0')}-${weekday(date) || 7}`,
                rows: {
                    range: `${shortDate(monday)} – ${shortDate(addDays(monday, 6))} (Monday to Sunday)`,
                    weeks: `${iso.year} has ${isoWeeksInYear(iso.year)} ISO weeks`,
                    us: `Week ${Math.floor((dayOfYear(date) + weekday({ y: date.y, m: 1, d: 1 }) - 1) / 7) + 1} counting Sunday weeks from 1 January (US style)`,
                },
            };
        }

        if (i.mode === 'from_week') {
            if (!Number.isInteger(i.week_year) || !Number.isInteger(i.week_number) || i.week_number < 1) {
                return { empty: 'Enter a year and a week number.' };
            }

            if (i.week_number > isoWeeksInYear(i.week_year)) {
                return { error: `${i.week_year} has ${isoWeeksInYear(i.week_year)} ISO weeks.` };
            }

            const jan4 = { y: i.week_year, m: 1, d: 4 };
            const monday = addDays(jan4, -((weekday(jan4) + 6) % 7) + (i.week_number - 1) * 7);

            return {
                value: `${shortDate(monday)} – ${shortDate(addDays(monday, 6))}`,
                label: `Week ${i.week_number} of ${i.week_year}`,
                sub: 'ISO 8601 weeks run Monday to Sunday; week 1 holds the first Thursday',
                rows: { range: `${longDate(monday)} to ${longDate(addDays(monday, 6))}`, weeks: `${i.week_year} has ${isoWeeksInYear(i.week_year)} ISO weeks` },
            };
        }

        const a = parseDate(i.start);
        const b = parseDate(i.end);

        if (!a || !b) {
            return { empty: 'Enter a start and an end date.' };
        }

        const days = Math.abs(toDays(b) - toDays(a));

        return {
            value: f(days / 7),
            unit: 'weeks',
            label: 'Weeks between',
            sub: `${plural(Math.floor(days / 7), 'week')} and ${plural(days % 7, 'day')}`,
            rows: { days: `${f(days)} days`, months: `${f(days / 30.436875)} average months`, range: `ISO weeks ${isoWeek(compare(a, b) <= 0 ? a : b).week} to ${isoWeek(compare(a, b) <= 0 ? b : a).week}` },
        };
    },

    countdown: (i, c, f) => {
        const target = parseDateTime(i.target);

        if (!target) {
            return { empty: 'Enter the date and time to count down to.' };
        }

        const now = nowCivil(i);
        const left = civilSeconds(target) - now;
        const nowDate = fromCivilSeconds(now).date;
        const counted = countDays(nowDate, target.date, { weekend: [0, 6] });

        return {
            value: durationText(Math.abs(left)),
            label: left >= 0 ? `Until ${shortDate(target.date)}` : `Since ${shortDate(target.date)}`,
            sub: at(target),
            rows: {
                days: `${f(Math.abs(left) / DAY)} days`,
                hours: `${f(Math.floor(Math.abs(left) / 3600))} hours`,
                weeks: `${f(Math.abs(left) / DAY / 7)} weeks`,
                workdays: left > 0 ? `${f(counted.workdays)} weekdays (Monday–Friday) before the day` : '—',
                sleeps: left > 0 ? `${plural(toDays(target.date) - toDays(nowDate), 'sleep')}` : '—',
            },
        };
    },
};

const run = defineTools(handlers);

export default function everydayTime(ctx, config) {
    run(ctx, config);

    // Countdowns and the seconds-alive counter tick every second.
    if (['countdown', 'every_second'].includes(config.tool)) {
        window.setInterval(() => ctx.update(), 1000);
    }
}
