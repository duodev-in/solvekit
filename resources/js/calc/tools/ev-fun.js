import { money } from '../ecology/common.js';
import { addDays, civilSeconds, clock, durationText, fromCivilSeconds, longDate, parseDate, parseDateTime } from '../everyday/dates.js';
import { NATO, NATO_SPOKEN, combineText, glitchText, graphemes, natoSpell, pigLatin, styleText, upsideDown } from '../everyday/text.js';
import { defineTools } from '../engines/formula.js';
import { handlers as care } from './ev-care.js';
import { chineseYear, nowCivil, sunSign } from './ev-time.js';

/**
 * Leisure and fun: text styles, marathons, hobbies and games.
 */
const IN = 0.0254;
const hours = (h) => durationText(h * 3600, { units: ['h', 'min'] });
const today = (i) => addDays({ y: 1970, m: 1, d: 1 }, Math.floor(nowCivil(i) / 86400));

/**
 * A viewing plan: total minutes with breaks between items, and the clock times of each item from a start.
 */
function marathon(items, i, f, title) {
    if (!items.length) {
        return { empty: 'Choose at least one film.' };
    }

    const gap = (i.break > 0 ? i.break : 0) * 60;
    const start = parseDateTime(i.start);
    let t = start ? civilSeconds(start) : 0;
    const schedule = items.map((item, index) => {
        const begin = t;
        t += item.minutes * 60 + (index < items.length - 1 ? gap : 0);

        return { label: item.title, value: start ? `${clock(begin).h12} – ${clock(begin + item.minutes * 60).h12} (${hours(item.minutes / 60)})` : hours(item.minutes / 60) };
    });
    const watching = items.reduce((sum, item) => sum + item.minutes, 0);
    const total = watching * 60 + gap * (items.length - 1);
    const end = start ? fromCivilSeconds(civilSeconds(start) + total) : null;

    return {
        value: durationText(total, { units: ['h', 'min'] }),
        label: title,
        sub: `${items.length} ${items.length === 1 ? 'film' : 'films'}: ${hours(watching / 60)} of film${gap && items.length > 1 ? ` + ${items.length - 1} ${items.length === 2 ? 'break' : 'breaks'} of ${f(gap / 60)} min` : ''}`,
        rows: { finish: end ? `${longDate(end.date)}, ${clock(end.seconds).h12}` : 'Enter a start time', days: `${f(Math.round((total / 86400) * 100) / 100)} days nonstop`, evenings: `${Math.ceil(watching / 180)} evenings of 3 hours` },
        lists: { schedule },
    };
}

/**
 * Remembers each random answer per question and toss, so retyping does not re-roll it.
 */
const tosses = new Map();

function secureRandom() {
    const values = new Uint32Array(1);
    globalThis.crypto.getRandomValues(values);

    return values[0] / 2 ** 32;
}

const UNICODE_NOTE = 'Unicode characters: some apps, screen readers and search engines do not read them as normal letters';

const textTool = (label, transform, list, note = UNICODE_NOTE) => (i) => {
    if (!String(i.text ?? '').length) {
        return { empty: 'Type or paste some text.' };
    }

    const out = transform(i);

    return {
        value: out,
        label,
        sub: `${graphemes(i.text).length} characters in, ${graphemes(out).length} out`,
        rows: { note },
        lists: list ? { variants: list(i) } : {},
    };
};

export const handlers = {
    dead_time_books: (i, c, f) => {
        if (!(i.minutes > 0) || !(i.length > 0) || !(i.speed > 0)) {
            return { empty: 'Enter your dead time a day, a book length and playback speed.' };
        }

        const yearHours = (i.minutes * (i.days > 0 ? i.days : 365)) / 60;
        const perBook = i.length / i.speed;

        return {
            value: f(Math.floor(yearHours / perBook)),
            unit: 'audiobooks a year',
            label: 'Books in your dead time',
            sub: `${f(Math.round(yearHours))} hours a year ÷ ${hours(perBook)} per book at ${f(i.speed)}×`,
            rows: { hours: `${f(Math.round(yearHours))} hours of listening a year`, month: `${f(Math.round((yearHours / perBook / 12) * 10) / 10)} books a month`, book: `One ${f(i.length)}-hour book every ${f(Math.round(perBook / (yearHours / 365) * 10) / 10)} days` },
        };
    },

    bold: textTool('Bold text', (i) => styleText(i.text, i.style), (i) => ['bold', 'sans_bold', 'bold_italic', 'sans_bold_italic', 'bold_script'].map((s) => ({ label: { bold: 'Bold serif', sans_bold: 'Bold sans', bold_italic: 'Bold italic', sans_bold_italic: 'Bold italic sans', bold_script: 'Bold script' }[s], value: styleText(i.text, s), highlight: s === i.style }))),
    italic: textTool('Italic text', (i) => styleText(i.text, i.style), (i) => ['italic', 'sans_italic', 'bold_italic', 'sans_bold_italic'].map((s) => ({ label: { italic: 'Italic serif', sans_italic: 'Italic sans', bold_italic: 'Bold italic', sans_bold_italic: 'Bold italic sans' }[s], value: styleText(i.text, s), highlight: s === i.style }))),
    cursive: textTool('Cursive text', (i) => styleText(i.text, i.style), (i) => ['script', 'bold_script'].map((s) => ({ label: s === 'script' ? 'Script' : 'Bold script', value: styleText(i.text, s), highlight: s === i.style }))),
    underline: textTool('Styled text', (i) => combineText(i.text, i.style), (i) => ['underline', 'double', 'strike', 'slash', 'overline'].map((s) => ({ label: { underline: 'Underline', double: 'Double underline', strike: 'Strikethrough', slash: 'Slashed', overline: 'Overline' }[s], value: combineText(i.text, s), highlight: s === i.style }))),
    upside_down: textTool('Upside-down text', (i) => upsideDown(i.text), (i) => [{ label: 'Upside down', value: upsideDown(i.text), highlight: true }, { label: 'Backwards only', value: graphemes(i.text).reverse().join('') }]),
    glitch: textTool('Glitch text', (i) => glitchText(i.text, Math.max(1, Math.min(8, Math.round(i.intensity || 3))), Math.round(i.seed || 1))),
    pig_latin: textTool('Pig Latin', (i) => pigLatin(i.text, { vowelSuffix: i.suffix || 'way' }), null, 'Consonants before the first vowel move to the end with ay; qu stays together'),

    nato: (i, c, f) => {
        if (!String(i.text ?? '').trim()) {
            return { empty: 'Type a word, name or code.' };
        }

        const spelled = natoSpell(i.text, { spoken: i.spoken });
        const letters = [...new Set(graphemes(i.text.toUpperCase()).filter((ch) => NATO[ch]))];

        return {
            value: spelled,
            label: 'NATO phonetic spelling',
            sub: `${letters.length} different letters and digits; / separates words`,
            rows: { note: i.spoken ? 'ICAO pronunciations: Tree (3), Fower (4), Fife (5), Niner (9)' : 'Standard ICAO spellings: Alfa and Juliett are spelled that way on purpose' },
            lists: { letters: letters.map((ch) => ({ label: ch, value: (i.spoken && NATO_SPOKEN[ch]) || NATO[ch] })) },
        };
    },

    clay: (i, c, f) => {
        if (i.mode === 'size') {
            if (!(i.fired > 0) || !(i.shrink > 0) || i.shrink >= 50) {
                return { empty: 'Enter the fired size you want and the shrinkage.' };
            }

            const wet = i.fired / (1 - i.shrink / 100);

            return {
                value: `${f(Math.round((wet / IN) * 100) / 100)} in`,
                label: 'Make it this size wet',
                sub: `${f(Math.round(wet * 1000) / 10)} cm: ${f(Math.round((i.fired / IN) * 100) / 100)} in ÷ (1 − ${f(i.shrink)}%)`,
                rows: { ratio: `${f(Math.round((wet / i.fired) * 1000) / 1000)}× the fired size`, volume: `Volume shrinks about ${f(Math.round((1 - (1 - i.shrink / 100) ** 3) * 1000) / 10)}%`, note: 'Use the shrinkage of your own clay body at your firing temperature' },
            };
        }

        if (!(i.wet > 0) || !(i.after > 0) || i.after > i.wet) {
            return { empty: 'Enter the wet and fired length of a test bar.' };
        }

        const s = (i.wet - i.after) / i.wet;

        return {
            value: f(Math.round(s * 1000) / 10),
            unit: '%',
            label: 'Total shrinkage',
            sub: `(${f(Math.round((i.wet / IN) * 100) / 100)} − ${f(Math.round((i.after / IN) * 100) / 100)} in) ÷ ${f(Math.round((i.wet / IN) * 100) / 100)} in`,
            rows: { ratio: `Make pieces ${f(Math.round((1 / (1 - s)) * 1000) / 1000)}× the size you want`, volume: `Volume shrinks about ${f(Math.round((1 - (1 - s) ** 3) * 1000) / 10)}%`, note: 'Mark a 10 cm (or 4 in) line on a wet test tile and measure it after firing' },
        };
    },

    drake_love: (i, c, f) => {
        const steps = [['Population', i.population], ['Of the gender you like', i.gender / 100], ['In your age range', i.age / 100], ['Single', i.single / 100], ['With the education you want', i.education / 100], ['You find attractive', i.attractive / 100], ['Who find you attractive', i.mutual / 100], ['You get on with', i.compatible / 100]];

        if (!(i.population > 0) || steps.slice(1).some(([, v]) => !(v >= 0) || v > 1)) {
            return { empty: 'Enter the population and each share from 0 to 100%.' };
        }

        let n = i.population;
        const list = steps.map(([label, v], index) => {
            n = index === 0 ? v : n * v;

            return { label, value: f(Math.round(n * 10) / 10) };
        });

        return {
            value: f(Math.round(n)),
            unit: Math.round(n) === 1 ? 'person' : 'people',
            label: 'Potential partners',
            sub: `${f(i.population)} × your ${steps.length - 1} shares`,
            rows: { share: `1 in ${f(Math.round(i.population / Math.max(n, 1e-9)))} people`, note: 'For fun: a playful use of the Drake equation, popularized by Peter Backus (2010)' },
            lists: { steps: list },
        };
    },

    hammock: (i, c, f) => {
        const angle = (i.angle > 0 && i.angle < 90 ? i.angle : 30) * (Math.PI / 180);

        if (!(i.distance > 0) || !(i.ridgeline > 0) || i.ridgeline >= i.distance) {
            return { empty: 'Enter the distance between anchors and a shorter ridgeline length.' };
        }

        const span = (i.distance - i.ridgeline) / 2;
        const drop = span * Math.tan(angle);
        const hang = (i.sit > 0 ? i.sit : 0) + (i.sag > 0 ? i.sag : 0) + drop;
        const weight = i.weight > 0 ? i.weight : null;
        const tension = weight ? weight / (2 * Math.sin(angle)) : null;

        return {
            value: `${f(Math.round((hang / IN) * 10) / 10)} in`,
            label: 'Hang point height',
            sub: `${f(Math.round(hang * 1000) / 10)} cm up each anchor`,
            rows: {
                strap: `${f(Math.round((span / Math.cos(angle) / IN) * 10) / 10)} in (${f(Math.round((span / Math.cos(angle)) * 100))} cm) of suspension each side`,
                tension: tension ? `${f(Math.round(tension / 453.59237))} lb (${f(Math.round(tension / 1000))} kg-force) on each anchor at ${f(Math.round((angle * 180) / Math.PI))}°` : 'Enter your weight for the tension',
                angle: 'At 30° the pull on each anchor equals your weight; flatter hangs pull much harder',
            },
        };
    },

    hp_currency: (i, c, f) => {
        const knuts = { galleon: 493, sickle: 29, knut: 1 };
        const total = i.from === 'gbp' ? (i.amount / 5) * 493 : i.amount * knuts[i.from];

        if (!(total >= 0) || !Number.isFinite(total) || i.amount === undefined || Number.isNaN(i.amount)) {
            return { empty: 'Enter an amount.' };
        }

        const g = Math.floor(total / 493);
        const s = Math.floor((total % 493) / 29);
        const k = Math.round(total % 29 * 1000) / 1000;

        return {
            value: `${f(g)} G, ${f(s)} S, ${f(k)} K`,
            label: 'Galleons, Sickles and Knuts',
            sub: '1 Galleon = 17 Sickles = 493 Knuts; 1 Sickle = 29 Knuts',
            rows: { galleons: `${f(Math.round((total / 493) * 10000) / 10000)} Galleons`, knuts: `${f(Math.round(total * 1000) / 1000)} Knuts`, gbp: `About £${f(Math.round((total / 493) * 5 * 100) / 100)} at about £5 a Galleon (J.K. Rowling, 2001)` },
        };
    },

    helium: (i, c, f) => {
        const diameter = i.size > 0 ? i.size : NaN;
        const volume = (4 / 3) * Math.PI * (diameter / 2) ** 3;
        const T = (i.temperature > -50 ? i.temperature : 20) + 273.15;
        const p = 101325 * (1 - 2.25577e-5 * (i.altitude || 0)) ** 5.25588;
        const air = p / (287.05 * T);
        const purity = (i.purity > 0 ? i.purity : 100) / 100;
        const gas = purity * (p / (2077.1 * T)) + (1 - purity) * air;
        const gross = volume * (air - gas) * 1000;
        const net = gross - (i.balloon > 0 ? i.balloon : 0);

        if (!(volume > 0)) {
            return { empty: 'Enter the inflated balloon size.' };
        }

        if (!(net > 0)) {
            return { error: 'The balloon is heavier than the lift its helium gives: it will not float.' };
        }

        const needed = i.payload > 0 ? Math.ceil(i.payload / net) : null;

        return {
            value: f(Math.round(net * 10) / 10),
            unit: 'g of lift each',
            label: 'Net lift per balloon',
            sub: `${f(Math.round(gross * 10) / 10)} g from ${f(Math.round(volume * 1e6) / 1000)} L of helium − ${f(i.balloon > 0 ? i.balloon : 0)} g of balloon`,
            rows: { needed: needed ? `${f(needed)} balloons to lift ${f(i.payload)} g` : 'Enter a weight to lift', gas: needed ? `${f(Math.round(needed * volume * 1000))} L (${f(Math.round(needed * volume * 35.3147 * 10) / 10)} ft³) of helium` : `${f(Math.round(volume * 1000 * 100) / 100)} L per balloon`, note: 'Latex balloons slowly lose helium: 11 in balloons float for about 12–24 hours untreated' },
        };
    },

    middle_earth: (i, c, f) => {
        const pick = c.data.middle_earth.filter(([, , , , , group]) => i[group]);
        const sorted = i.order === 'release' ? [...pick].sort((a, b) => a[2] - b[2]) : pick;

        return marathon(sorted.map(([, title, year, theatrical, extended]) => ({ title: `${title} (${year})`, minutes: i.version === 'extended' ? extended : theatrical })), i, f, 'Marathon length');
    },

    star_wars: (i, c, f) => {
        const pick = c.data.star_wars.filter(([key]) => (key.startsWith('ep') ? i.saga : key === 'clone_wars' ? i.clone_wars : i.anthology));
        const sorted = [...pick].sort((a, b) => (i.order === 'release' ? a[2] - b[2] : a[4] - b[4]));

        return marathon(sorted.map(([, title, year, minutes]) => ({ title: `${title} (${year})`, minutes })), i, f, 'Marathon length');
    },

    oscars: (i, c, f) => {
        const from = Math.round(i.from);
        const to = Math.round(i.to);

        if (!(from >= 1929) || !(to >= from)) {
            return { empty: 'Enter a range of ceremony years from 1929.' };
        }

        const films = c.data.best_picture.filter(([year]) => year >= from && year <= to);

        if (!films.length) {
            return { empty: 'No ceremonies in that range.' };
        }

        const minutes = films.reduce((sum, [, , m]) => sum + m, 0);
        const perDay = i.per_day > 0 ? i.per_day : null;
        const longest = films.reduce((a, b) => (b[2] > a[2] ? b : a));

        return {
            value: hours(minutes / 60),
            label: `${films.length} Best Picture winners`,
            sub: `Ceremonies ${from}–${to}`,
            rows: { days: perDay ? `${f(Math.ceil(minutes / 60 / perDay))} days at ${f(perDay)} hours a day` : 'Enter hours a day', longest: `Longest: ${longest[1]} (${longest[2]} min)`, average: `${f(Math.round(minutes / films.length))} min on average` },
            lists: { films: films.map(([year, title, m]) => ({ label: `${year}: ${title}`, value: `${m} min` })) },
        };
    },

    podcasts: (i, c, f) => {
        if (!(i.minutes > 0) || !(i.episode > 0) || !(i.speed > 0)) {
            return { empty: 'Enter your dead time, episode length and speed.' };
        }

        const minutesYear = i.minutes * (i.days > 0 ? i.days : 365);
        const per = i.episode / i.speed;

        return {
            value: f(Math.floor(minutesYear / per)),
            unit: 'episodes a year',
            label: 'Podcast episodes in your dead time',
            sub: `${f(Math.round(minutesYear / 60))} hours a year ÷ ${f(Math.round(per * 10) / 10)} min per episode at ${f(i.speed)}×`,
            rows: { week: `${f(Math.round((minutesYear / per / 52.18) * 10) / 10)} episodes a week`, catalog: i.backlog > 0 ? `A ${f(i.backlog)}-episode back catalog takes ${f(Math.ceil((i.backlog * per) / i.minutes))} days` : 'Enter a back catalog size' },
        };
    },

    binge: (i, c, f) => {
        const episodes = i.episodes > 0 ? i.episodes : NaN;
        const per = Math.max(0, (i.length > 0 ? i.length : NaN) - (i.skip > 0 ? i.skip : 0)) / (i.speed > 0 ? i.speed : 1);
        const total = episodes * per;

        if (!(total > 0) || !(i.per_day > 0)) {
            return { empty: 'Enter the episodes, their length and hours a day.' };
        }

        const days = Math.ceil(total / 60 / i.per_day);
        const start = i.start ? parseDate(i.start) : today(i);

        return {
            value: f(days),
            unit: days === 1 ? 'day' : 'days',
            label: 'Days to finish',
            sub: `${hours(total / 60)} of viewing at ${f(i.per_day)} hours a day`,
            rows: { finish: start ? `Finish on ${longDate(addDays(start, days - 1))}` : '—', total: `${f(Math.round(total / 60 * 10) / 10)} hours in all (${f(episodes)} episodes of ${f(Math.round(per * 10) / 10)} min)`, saved: i.skip > 0 || i.speed > 1 ? `${hours((episodes * i.length - total) / 60)} saved by skipping and speed` : 'Skip intros or speed up to save time' },
        };
    },

    series: (i, c, f) => {
        const episodes = (i.seasons > 0 ? i.seasons : NaN) * (i.per_season > 0 ? i.per_season : NaN);
        const per = (i.length > 0 ? i.length : NaN) / (i.speed > 0 ? i.speed : 1);
        const total = episodes * per;

        if (!(total > 0)) {
            return { empty: 'Enter the seasons, episodes per season and episode length.' };
        }

        const days = i.per_day > 0 ? Math.ceil(total / 60 / i.per_day) : null;
        const start = i.start ? parseDate(i.start) : today(i);

        return {
            value: hours(total / 60),
            label: 'Total watch time',
            sub: `${f(episodes)} episodes × ${f(Math.round(per * 10) / 10)} min`,
            rows: { days: `${f(Math.round((total / 60 / 24) * 100) / 100)} days nonstop`, finish: days ? `${f(days)} days at ${f(i.per_day)} h a day, finishing ${longDate(addDays(start, days - 1))}` : 'Enter hours a day', episodes: f(episodes) },
        };
    },

    silver_lining: (i, c, f) => {
        const daily = (i.commute > 0 ? i.commute : 0) + (i.other > 0 ? i.other : 0);

        if (!(daily > 0) || !(i.days > 0)) {
            return { empty: 'Enter the minutes saved a day and the number of days.' };
        }

        const total = (daily * i.days) / 60;
        const saved = (i.cost > 0 ? i.cost : 0) * i.days;

        return {
            value: f(Math.round(total)),
            unit: 'hours gained',
            label: 'Time won back',
            sub: `${f(daily)} min a day × ${f(i.days)} days`,
            rows: { days: `${f(Math.round((total / 24) * 10) / 10)} full days`, money: saved > 0 ? `${money(saved)} not spent on travel` : 'Enter daily travel costs', books: `${f(Math.floor(total / (90000 / 238 / 60)))} ${Math.floor(total / (90000 / 238 / 60)) === 1 ? 'novel' : 'novels'} at average reading speed` },
        };
    },

    screen_time: (i, c, f) => care.screen_time({ minutes: i.unit === 'hours' ? i.amount * 60 : i.amount }, c, f),

    tent: (i, c, f) => {
        if (!(i.people > 0)) {
            return { empty: 'Enter the number of people.' };
        }

        const extra = (i.comfort === 'roomy' ? 1 : 0) + (i.gear ? 1 : 0) + (i.dog ? 1 : 0);
        const rating = i.people + extra;
        const area = rating * (i.per_person > 0 ? i.per_person : 15);

        return {
            value: `${f(rating)}-person`,
            label: 'Tent to buy',
            sub: `${f(i.people)} sleeping${extra ? ` + ${extra} for ${[i.comfort === 'roomy' ? 'comfort' : '', i.gear ? 'gear' : '', i.dog ? 'a dog' : ''].filter(Boolean).join(', ')}` : ''}`,
            rows: { area: `About ${f(area)} ft² (${f(Math.round(area * 0.092903 * 10) / 10)} m²) of floor`, pad: 'A standard sleeping pad is 20 × 72 in (10 ft²); wide pads are 25 in', note: 'Tent person ratings assume snug spacing; many campers size up by one' },
        };
    },

    witcher: (i, c, f) => {
        const books = c.data.witcher_books.filter(([key]) => (key === 'season_of_storms' ? i.storms : i.saga));
        const screen = c.data.witcher_screen.filter(([key]) => (key.startsWith('s') && key.length === 2 ? i.series : key === 'blood_origin' ? i.blood_origin : i.anime));
        const pace = i.pace > 0 ? i.pace : 40;
        const pages = books.reduce((sum, b) => sum + b[2], 0);
        const watch = screen.reduce((sum, s) => sum + s[2], 0);
        const totalHours = pages / pace + watch / 60;

        if (!(totalHours > 0)) {
            return { empty: 'Choose books or series to finish.' };
        }

        return {
            value: hours(totalHours),
            label: 'Time to finish',
            sub: `${f(pages)} pages at ${f(pace)} pages an hour + ${hours(watch / 60)} of viewing`,
            rows: { reading: books.length ? `${hours(pages / pace)} reading ${books.length} ${books.length === 1 ? 'book' : 'books'}` : 'No books chosen', watching: screen.length ? `${hours(watch / 60)} watching` : 'No series chosen', days: i.per_day > 0 ? `${f(Math.ceil(totalHours / i.per_day))} days at ${f(i.per_day)} ${i.per_day === 1 ? 'hour' : 'hours'} a day` : 'Enter hours a day' },
            lists: { items: [...books.map(([, title, p, edition]) => ({ label: title, value: `${p} pages (${edition})` })), ...screen.map(([, title, m]) => ({ label: title, value: hours(m / 60) }))] },
        };
    },

    yes_no: (i, c, f) => {
        const key = `${String(i.question ?? '').trim().toLowerCase()}|${Math.round(i.toss || 1)}`;
        let roll = i.random;

        if (roll === undefined) {
            if (!tosses.has(key)) {
                tosses.set(key, secureRandom());
            }

            roll = tosses.get(key);
        }

        const yes = roll < 0.5;

        return {
            value: yes ? 'Yes' : 'No',
            label: i.question ? String(i.question).trim() : 'The answer is',
            sub: `Toss ${f(Math.round(i.toss || 1))}: a fair 50/50 choice from your device's secure random number generator`,
            rows: { again: 'Change the toss number for a new answer', note: 'Just for fun: please do not make important decisions this way' },
        };
    },

    zodiac: (i, c, f) => {
        const birth = parseDate(i.birth);

        if (!birth) {
            return { empty: 'Enter a date of birth.' };
        }

        const sign = sunSign(birth);
        const chinese = chineseYear(birth, c.data.chinese_new_year);
        const symbols = { Aries: '♈', Taurus: '♉', Gemini: '♊', Cancer: '♋', Leo: '♌', Virgo: '♍', Libra: '♎', Scorpio: '♏', Sagittarius: '♐', Capricorn: '♑', Aquarius: '♒', Pisces: '♓' };
        const elements = { Aries: 'Fire', Leo: 'Fire', Sagittarius: 'Fire', Taurus: 'Earth', Virgo: 'Earth', Capricorn: 'Earth', Gemini: 'Air', Libra: 'Air', Aquarius: 'Air', Cancer: 'Water', Scorpio: 'Water', Pisces: 'Water' };

        return {
            value: `${symbols[sign]} ${sign}`,
            label: 'Western zodiac sign',
            sub: `${elements[sign]} sign; dates follow the usual newspaper ranges and shift by a day in some years`,
            rows: { chinese: chinese ? `${chinese.element} ${chinese.animal} (${chinese.yin ? 'yin' : 'yang'}); the year began ${longDate(chinese.start)}` : 'Chinese zodiac for 1900–2099 only', note: 'For fun: astrology has no scientific support' },
        };
    },
};

export default defineTools(handlers);
