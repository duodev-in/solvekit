import { addDays, compare, durationText, longDate, parseDate, toDays } from '../everyday/dates.js';
import { defineTools } from '../engines/formula.js';
import { nowCivil } from './ev-time.js';

/**
 * Books and reading: listening and reading time, reading speed and reading goals.
 */
const hoursText = (hours) => durationText(hours * 3600, { units: ['h', 'min'] });
const today = (i) => {
    const days = Math.floor(nowCivil(i) / 86400);

    return addDays({ y: 1970, m: 1, d: 1 }, days);
};

/**
 * Days needed at a daily amount, and the date that lands on.
 */
function schedule(hours, minutesPerDay, i) {
    if (!(minutesPerDay > 0)) {
        return { days: null, text: 'Enter minutes a day to see a finish date' };
    }

    const days = Math.ceil((hours * 60) / minutesPerDay);

    return { days, text: `${days} days at ${minutesPerDay} minutes a day, finishing ${longDate(addDays(today(i), days - 1))}` };
}

/**
 * Reading time of a list of books from their pages and a pages-per-hour pace.
 */
function bookSet(books, i, f, what) {
    const pace = i.pace;

    if (!(pace > 0)) {
        return { empty: 'Enter your reading pace in pages per hour.' };
    }

    const pages = books.reduce((sum, book) => sum + book.pages, 0);
    const hours = pages / pace;
    const plan = schedule(hours, i.minutes, i);

    return {
        value: hoursText(hours),
        label: `Time to read ${what}`,
        sub: `${f(pages)} pages at ${f(pace)} pages an hour`,
        rows: {
            pages: `${f(pages)} pages in ${books.length === 1 ? '1 book' : `${books.length} books`}`,
            hours: `${f(hours)} hours`,
            days: plan.text,
        },
        lists: { books: books.map((book) => ({ label: book.label, value: `${f(book.pages)} pages · ${hoursText(book.pages / pace)}` })) },
    };
}

export const handlers = {
    audiobook_speed: (i, c, f) => {
        const length = (Number.isFinite(i.hours) ? i.hours : 0) * 3600 + (Number.isFinite(i.minutes) ? i.minutes : 0) * 60;

        if (!(length > 0) || !(i.speed > 0)) {
            return { empty: 'Enter the audiobook length and a playback speed.' };
        }

        const listening = length / i.speed;
        const plan = schedule(listening / 3600, i.daily, i);

        return {
            value: durationText(listening, { units: ['h', 'min'] }),
            label: `Listening time at ${f(i.speed)}×`,
            sub: `${durationText(length, { units: ['h', 'min'] })} ÷ ${f(i.speed)}`,
            rows: {
                saved: `${durationText(Math.max(0, length - listening), { units: ['h', 'min'] })} saved${i.speed < 1 ? ' (slower than normal: adds time)' : ''}`,
                days: plan.text,
                words: `About ${f(Math.round(155 * i.speed))} words a minute (narrators read about 150–160 at 1×)`,
            },
            lists: { speeds: [1, 1.25, 1.5, 1.75, 2, 2.5, 3].map((speed) => ({ label: `${speed}×`, value: durationText(length / speed, { units: ['h', 'min'] }), highlight: speed === i.speed })) },
        };
    },

    gluck: (i, c, f) => {
        const collections = c.data.gluck.map(([key, title, year, pages, publisher]) => ({ key, label: `${title} (${year}, ${publisher})`, pages }));
        let books;
        let what;

        if (i.collection === 'all') {
            books = collections;
            what = 'all 13 collections';
        } else if (i.collection === 'collected') {
            books = [{ label: 'Poems 1962–2012 (2012, Farrar, Straus and Giroux)', pages: c.data.gluck_collected }];
            what = 'Poems 1962–2012';
        } else {
            books = collections.filter((book) => book.key === i.collection);
            what = books[0]?.label.split(' (')[0] ?? 'the collection';
        }

        return books.length ? bookSet(books, i, f, what) : { empty: 'Choose a collection.' };
    },

    tokarczuk: (i, c, f) => {
        const all = c.data.tokarczuk.map(([key, title, year, pages, publisher, translator]) => ({ key, label: `${title} (${publisher}, ${year}; tr. ${translator})`, pages }));
        const books = i.book === 'all' ? all : all.filter((book) => book.key === i.book);

        if (i.book === 'custom') {
            return i.custom_pages > 0 ? bookSet([{ label: 'Your edition', pages: i.custom_pages }], i, f, 'your edition') : { empty: 'Enter the number of pages.' };
        }

        return books.length ? bookSet(books, i, f, i.book === 'all' ? 'all five books' : books[0].label.split(' (')[0]) : { empty: 'Choose a book.' };
    },

    free_time_books: (i, c, f) => {
        if (!(i.hours > 0) || !(i.pace > 0) || !(i.pages > 0) || !(i.days > 0)) {
            return { empty: 'Enter your free hours a day, reading pace, book length and days.' };
        }

        const pagesTotal = i.hours * i.days * i.pace;
        const books = pagesTotal / i.pages;

        return {
            value: f(Math.floor(books)),
            unit: Math.floor(books) === 1 ? 'book' : 'books',
            label: `Books you can read in ${f(i.days)} days`,
            sub: `${f(i.hours)} h a day × ${f(i.days)} days × ${f(i.pace)} pages an hour = ${f(pagesTotal)} pages`,
            rows: {
                exact: `${f(books)} books of ${f(i.pages)} pages`,
                perBook: `${hoursText(i.pages / i.pace)} of reading per book (${f(i.pages / (i.hours * i.pace))} days each)`,
                week: `${f((i.hours * 7 * i.pace) / i.pages)} books a week`,
            },
        };
    },

    reading_challenge: (i, c, f) => {
        const start = parseDate(i.start);
        const end = parseDate(i.end);
        const on = i.on ? parseDate(i.on) : today(i);

        if (!start || !end || !on || !(i.goal > 0)) {
            return { empty: 'Enter your goal and the challenge dates.' };
        }

        if (compare(end, start) <= 0) {
            return { error: 'The end date must be after the start date.' };
        }

        const total = toDays(end) - toDays(start) + 1;
        const elapsed = Math.min(total, Math.max(0, toDays(on) - toDays(start) + 1));
        const left = total - elapsed;
        const done = i.done >= 0 ? i.done : 0;
        const remaining = Math.max(0, i.goal - done);
        const expected = (i.goal * elapsed) / total;
        const pages = i.pages > 0 ? i.pages : null;

        if (remaining === 0) {
            return { value: 'Goal reached', label: 'Reading challenge', sub: `${f(done)} of ${f(i.goal)} books read`, rows: { pace: '—', pages: '—', track: `${f(done - i.goal)} books over the goal`, left: `${left} days left` } };
        }

        if (left <= 0) {
            return { value: `${f(remaining)} short`, label: 'Reading challenge ended', sub: `${f(done)} of ${f(i.goal)} books read`, rows: { pace: 'The challenge has ended', pages: '—', track: 'Behind', left: '0 days' } };
        }

        const ahead = done - expected;

        return {
            value: f(remaining / (left / 7)),
            unit: 'books a week',
            label: 'Pace needed for the rest',
            sub: `${f(remaining)} books in ${left} days (${f(remaining / (left / 30.436875))} a month)`,
            rows: {
                pace: `${f(remaining / left)} books a day`,
                pages: pages ? `${f((remaining * pages) / left)} pages a day at ${f(pages)} pages a book` : 'Enter pages per book',
                track: Math.abs(ahead) < 0.5 ? 'On track' : ahead > 0 ? `${f(Math.round(ahead * 10) / 10)} books ahead of an even pace` : `${f(Math.round(-ahead * 10) / 10)} books behind an even pace`,
                left: `${left} days left of ${total}`,
            },
        };
    },

    reading_speed: (i, c, f) => {
        const seconds = (Number.isFinite(i.minutes) ? i.minutes : 0) * 60 + (Number.isFinite(i.seconds) ? i.seconds : 0);

        if (!(i.words > 0) || !(seconds > 0)) {
            return { empty: 'Enter the words you read and how long it took.' };
        }

        const wpm = i.words / (seconds / 60);
        const perPage = i.per_page > 0 ? i.per_page : 300;

        return {
            value: f(Math.round(wpm)),
            unit: 'words a minute',
            label: 'Reading speed',
            sub: `${f(i.words)} words in ${durationText(seconds, { units: ['min', 's'] })}`,
            rows: {
                pages: `${f((wpm * 60) / perPage)} pages an hour at ${f(perPage)} words a page`,
                average: `${wpm >= 238 ? Math.round((wpm / 238 - 1) * 100) + '% faster than' : Math.round((1 - wpm / 238) * 100) + '% slower than'} the adult average of 238 words a minute (Brysbaert 2019, non-fiction)`,
                book: `${hoursText(90000 / wpm / 60)} for a 90,000-word novel`,
            },
        };
    },

    reading_time: (i, c, f) => {
        const perPage = i.per_page > 0 ? i.per_page : 300;
        const words = i.mode === 'pages' ? i.pages * perPage : i.words;

        if (!(words > 0) || !(i.wpm > 0)) {
            return { empty: 'Enter the length and a reading speed.' };
        }

        const minutes = words / i.wpm;
        const plan = schedule(minutes / 60, i.daily, i);

        return {
            value: hoursText(minutes / 60),
            label: 'Reading time',
            sub: `${f(words)} words at ${f(i.wpm)} words a minute${i.mode === 'pages' ? ` (${f(i.pages)} pages × ${f(perPage)} words)` : ''}`,
            rows: {
                minutes: `${f(minutes)} minutes`,
                days: plan.text,
                aloud: `${hoursText(words / 150 / 60)} read aloud at 150 words a minute`,
            },
        };
    },
};

export default defineTools(handlers);
