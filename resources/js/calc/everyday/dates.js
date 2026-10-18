/**
 * Calendar arithmetic on civil dates (proleptic Gregorian, no time zone), shared by the Everyday Life tools.
 *
 * Dates are plain { y, m, d } objects; day numbers count days since 1970-01-01, so differences and
 * weekdays are exact for any year and never shift with daylight saving time.
 */
export const WEEKDAYS = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
export const MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

/**
 * Days since 1970-01-01 (Howard Hinnant's days_from_civil).
 */
export function toDays({ y, m, d }) {
    const year = m <= 2 ? y - 1 : y;
    const era = Math.floor(year / 400);
    const yoe = year - era * 400;
    const doy = Math.floor((153 * (m + (m > 2 ? -3 : 9)) + 2) / 5) + d - 1;
    const doe = yoe * 365 + Math.floor(yoe / 4) - Math.floor(yoe / 100) + doy;

    return era * 146097 + doe - 719468;
}

export function fromDays(days) {
    const z = days + 719468;
    const era = Math.floor(z / 146097);
    const doe = z - era * 146097;
    const yoe = Math.floor((doe - Math.floor(doe / 1460) + Math.floor(doe / 36524) - Math.floor(doe / 146096)) / 365);
    const doy = doe - (365 * yoe + Math.floor(yoe / 4) - Math.floor(yoe / 100));
    const mp = Math.floor((5 * doy + 2) / 153);
    const d = doy - Math.floor((153 * mp + 2) / 5) + 1;
    const m = mp + (mp < 10 ? 3 : -9);

    return { y: yoe + era * 400 + (m <= 2 ? 1 : 0), m, d };
}

export const isLeap = (y) => (y % 4 === 0 && y % 100 !== 0) || y % 400 === 0;
export const daysInMonth = (y, m) => [31, isLeap(y) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m - 1];
export const daysInYear = (y) => (isLeap(y) ? 366 : 365);

/**
 * 0 = Sunday … 6 = Saturday.
 */
export const weekday = (date) => (((toDays(date) + 4) % 7) + 7) % 7;

/**
 * Reads 'YYYY-MM-DD' (or the date part of 'YYYY-MM-DDTHH:MM'); null when it is not a real date.
 */
export function parseDate(text) {
    const match = /^(\d{4,})-(\d{2})-(\d{2})/.exec(String(text ?? '').trim());

    if (!match) {
        return null;
    }

    const date = { y: Number(match[1]), m: Number(match[2]), d: Number(match[3]) };

    return date.y >= 1 && date.m >= 1 && date.m <= 12 && date.d >= 1 && date.d <= daysInMonth(date.y, date.m) ? date : null;
}

/**
 * Seconds after midnight from 'HH:MM' or 'HH:MM:SS'; null when invalid.
 */
export function parseTime(text) {
    const match = /^(\d{1,2}):(\d{2})(?::(\d{2}(?:\.\d+)?))?$/.exec(String(text ?? '').trim());

    if (!match) {
        return null;
    }

    const [h, m, s] = [Number(match[1]), Number(match[2]), Number(match[3] ?? 0)];

    return h < 24 && m < 60 && s < 60 ? h * 3600 + m * 60 + s : null;
}

/**
 * Reads 'YYYY-MM-DDTHH:MM' as { date, seconds }; a bare date means midnight.
 */
export function parseDateTime(text) {
    const date = parseDate(text);

    if (!date) {
        return null;
    }

    const time = String(text).includes('T') ? parseTime(String(text).split('T')[1]) : 0;

    return time === null ? null : { date, seconds: time };
}

/**
 * Seconds since 1970-01-01T00:00 on the civil time line (no time zone).
 */
export const civilSeconds = ({ date, seconds }) => toDays(date) * 86400 + seconds;

export function fromCivilSeconds(total) {
    const days = Math.floor(total / 86400);

    return { date: fromDays(days), seconds: total - days * 86400 };
}

export const addDays = (date, n) => fromDays(toDays(date) + n);

/**
 * Adds whole months; a day past the end of the new month moves back to its last day (31 Jan + 1 month = 28/29 Feb).
 */
export function addMonths(date, n) {
    const index = date.y * 12 + (date.m - 1) + n;
    const y = Math.floor(index / 12);
    const m = index - y * 12 + 1;

    return { y, m, d: Math.min(date.d, daysInMonth(y, m)) };
}

export const compare = (a, b) => toDays(a) - toDays(b);

/**
 * Whole years, months and days from a to b (a ≤ b), counting months on the calendar.
 */
export function diffYMD(a, b) {
    let months = (b.y - a.y) * 12 + (b.m - a.m);

    if (toDays(addMonths(a, months)) > toDays(b)) {
        months -= 1;
    }

    const days = toDays(b) - toDays(addMonths(a, months));

    return { years: Math.floor(months / 12), months: months % 12, days, totalMonths: months };
}

/**
 * Day of the year, 1 … 366.
 */
export const dayOfYear = (date) => toDays(date) - toDays({ y: date.y, m: 1, d: 1 }) + 1;

/**
 * ISO 8601 week: weeks start on Monday and week 1 holds the year's first Thursday.
 */
export function isoWeek(date) {
    const days = toDays(date);
    const isoDay = weekday(date) || 7;
    const thursday = fromDays(days + 4 - isoDay);
    const week = Math.floor((dayOfYear(thursday) - 1) / 7) + 1;

    return { year: thursday.y, week };
}

export const isoWeeksInYear = (y) => isoWeek({ y, m: 12, d: 28 }).week;

/**
 * The nth given weekday of a month (n = -1 for the last one).
 */
export function nthWeekday(y, m, wd, n) {
    if (n > 0) {
        const first = weekday({ y, m, d: 1 });

        return { y, m, d: 1 + ((wd - first + 7) % 7) + (n - 1) * 7 };
    }

    const lastDay = daysInMonth(y, m);
    const last = weekday({ y, m, d: lastDay });

    return { y, m, d: lastDay - ((last - wd + 7) % 7) };
}

/**
 * US federal holidays of a year (5 U.S.C. 6103) with the date each is observed:
 * a Saturday holiday is observed on Friday and a Sunday holiday on Monday.
 */
export function usFederalHolidays(y) {
    const list = [
        ['New Year\'s Day', { y, m: 1, d: 1 }],
        ['Martin Luther King Jr. Day', nthWeekday(y, 1, 1, 3)],
        ['Washington\'s Birthday', nthWeekday(y, 2, 1, 3)],
        ['Memorial Day', nthWeekday(y, 5, 1, -1)],
        ...(y >= 2021 ? [['Juneteenth', { y, m: 6, d: 19 }]] : []),
        ['Independence Day', { y, m: 7, d: 4 }],
        ['Labor Day', nthWeekday(y, 9, 1, 1)],
        ['Columbus Day', nthWeekday(y, 10, 1, 2)],
        ['Veterans Day', { y, m: 11, d: 11 }],
        ['Thanksgiving Day', nthWeekday(y, 11, 4, 4)],
        ['Christmas Day', { y, m: 12, d: 25 }],
    ];

    return list.map(([name, date]) => {
        const wd = weekday(date);

        return { name, date, observed: wd === 6 ? addDays(date, -1) : wd === 0 ? addDays(date, 1) : date };
    });
}

/**
 * Parses a list of dates, one per line or separated by commas; returns valid dates and the count of unreadable entries.
 */
export function parseDateList(text) {
    const parts = String(text ?? '').split(/[\n,;]+/).map((part) => part.trim()).filter(Boolean);
    const dates = parts.map(parseDate).filter(Boolean);

    return { dates, invalid: parts.length - dates.length };
}

/**
 * Counts days from start to end (end excluded) by kind: workdays skip the weekend days and the holiday day numbers.
 */
export function countDays(start, end, { weekend = [0, 6], holidays = new Set() } = {}) {
    const from = toDays(start);
    const to = toDays(end);
    let workdays = 0;
    let weekendDays = 0;
    let holidaysSkipped = 0;

    for (let day = from; day < to; day += 1) {
        const wd = (((day + 4) % 7) + 7) % 7;

        if (weekend.includes(wd)) {
            weekendDays += 1;
        } else if (holidays.has(day)) {
            holidaysSkipped += 1;
        } else {
            workdays += 1;
        }
    }

    return { total: to - from, workdays, weekendDays, holidaysSkipped };
}

/**
 * Moves forward (or back, for negative n) by n workdays, skipping weekend days and holidays.
 */
export function addWorkdays(start, n, { weekend = [0, 6], holidays = new Set() } = {}) {
    let day = toDays(start);
    let left = Math.abs(n);
    const step = n < 0 ? -1 : 1;

    while (left > 0) {
        day += step;
        const wd = (((day + 4) % 7) + 7) % 7;

        if (!weekend.includes(wd) && !holidays.has(day)) {
            left -= 1;
        }
    }

    return fromDays(day);
}

const pad = (n) => String(n).padStart(2, '0');

export const isoDate = ({ y, m, d }) => `${String(y).padStart(4, '0')}-${pad(m)}-${pad(d)}`;
export const longDate = (date) => `${WEEKDAYS[weekday(date)]}, ${MONTHS[date.m - 1]} ${date.d}, ${date.y}`;
export const shortDate = (date) => `${MONTHS[date.m - 1].slice(0, 3)} ${date.d}, ${date.y}`;

/**
 * 13:05 → '1:05 PM' (12-hour) and '13:05' (24-hour).
 */
export function clock(seconds, { withSeconds = false } = {}) {
    const total = Math.round(((seconds % 86400) + 86400) % 86400);
    const h = Math.floor(total / 3600);
    const m = Math.floor((total % 3600) / 60);
    const s = total % 60;
    const tail = withSeconds ? `:${pad(s)}` : '';

    return { h24: `${pad(h)}:${pad(m)}${tail}`, h12: `${((h + 11) % 12) + 1}:${pad(m)}${tail} ${h < 12 ? 'AM' : 'PM'}` };
}

/**
 * 93784 s → '1 day 2 h 3 min 4 s' (zero parts left out).
 */
export function durationText(seconds, { units = ['day', 'h', 'min', 's'] } = {}) {
    const size = { day: 86400, h: 3600, min: 60, s: 1 };
    const smallest = size[units[units.length - 1]];
    const sign = seconds < 0 ? '−' : '';
    // Round to the smallest unit shown first, so 6 h 59.9 min reads 7 h.
    let rest = Math.round(Math.abs(seconds) / smallest) * smallest;
    const parts = [];

    units.forEach((name) => {
        const amount = Math.floor(rest / size[name]);
        rest -= amount * size[name];

        if (amount > 0) {
            const shown = amount.toLocaleString('en-US');
            parts.push(name === 'day' ? `${shown} ${amount === 1 ? 'day' : 'days'}` : `${shown} ${name}`);
        }
    });

    return parts.length ? sign + parts.join(' ') : `0 ${units[units.length - 1] === 'day' ? 'days' : units[units.length - 1]}`;
}

/**
 * 3 years, 1 month, 0 days → '3 years, 1 month and 0 days'.
 */
export function ymdText({ years, months, days }) {
    const part = (n, word) => `${n} ${word}${n === 1 ? '' : 's'}`;

    return `${part(years, 'year')}, ${part(months, 'month')} and ${part(days, 'day')}`;
}

export const plural = (n, word, many = `${word}s`) => `${n} ${Math.abs(n) === 1 ? word : many}`;
