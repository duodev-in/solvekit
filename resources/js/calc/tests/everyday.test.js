import assert from 'node:assert/strict';
import { execSync } from 'node:child_process';
import test from 'node:test';
import { equationOfEquinoxes, gmst, hms, illumination, jdFromMs, moonAt, msFromJd, phaseJd, phaseJde } from '../everyday/astro.js';
import { addMonths, countDays, diffYMD, fromDays, isoDate, isoWeek, toDays, usFederalHolidays, weekday } from '../everyday/dates.js';
import { checkWords, natoSpell, numberWords, pigLatin, styleText, toCase, upsideDown, words } from '../everyday/text.js';
import { handlers as books } from '../tools/ev-books.js';
import { handlers as care } from '../tools/ev-care.js';
import { braSize, footFromSize, handlers as clothing, packPieces, ringSizes, shoeSizes } from '../tools/ev-clothing.js';
import { handlers as fun } from '../tools/ev-fun.js';
import { halfEllipse, handlers as home } from '../tools/ev-home.js';
import { ergonomics, handlers as office } from '../tools/ev-office.js';
import { handlers as time, julianToDays, sunSign } from '../tools/ev-time.js';
import { handlers as transport, parseTire, pistonPosition, pressureAt } from '../tools/ev-transport.js';

const DATA = JSON.parse(execSync(`php -r '$e = require "config/ecology_data.php"; echo json_encode((require "config/everyday_data.php") + ["fuels" => $e["fuels"]]);'`).toString());
const c = { data: DATA };
const raw = (value) => value;
const close = (actual, expected, tolerance) => assert.ok(Math.abs(Number(actual) - expected) <= tolerance, `${actual} ≠ ${expected}`);
const IN = 0.0254;
const NOW = '2026-10-18T12:00';

test('civil calendar: day numbers, weekdays, ISO weeks and month arithmetic', () => {
    assert.equal(toDays({ y: 1970, m: 1, d: 1 }), 0);
    assert.equal(isoDate(fromDays(toDays({ y: 2000, m: 2, d: 29 }))), '2000-02-29');
    assert.equal(weekday({ y: 1969, m: 7, d: 20 }), 0);
    assert.deepEqual(isoWeek({ y: 2021, m: 1, d: 3 }), { year: 2020, week: 53 });
    assert.deepEqual(isoWeek({ y: 2026, m: 12, d: 31 }), { year: 2026, week: 53 });
    assert.equal(isoDate(addMonths({ y: 2027, m: 1, d: 31 }, 1)), '2027-02-28');
    assert.deepEqual(diffYMD({ y: 1990, m: 5, d: 15 }, { y: 2026, m: 10, d: 18 }), { years: 36, months: 5, days: 3, totalMonths: 437 });
    assert.equal(countDays({ y: 2026, m: 1, d: 1 }, { y: 2027, m: 1, d: 1 }).workdays, 261);
    // 1 January 2022 fell on a Saturday, so it was observed on Friday 31 December 2021.
    assert.equal(isoDate(usFederalHolidays(2022)[0].observed), '2021-12-31');
    assert.equal(julianToDays({ y: 1616, m: 4, d: 23 }) - toDays({ y: 1616, m: 4, d: 23 }), 10);
});

test('astronomy matches Meeus worked examples', () => {
    close(phaseJde(-283), 2443192.65118, 0.00001);
    close(phaseJde(544.75), 2467636.49186, 0.00001);
    assert.equal(hms(gmst(2446895.5)), '13h 10m 46.37s');
    assert.equal(hms(gmst(2446896.30625)), '8h 34m 57.09s');
    assert.equal(hms(gmst(2446895.5) + equationOfEquinoxes(2446895.5)), '13h 10m 46.13s');
    close(illumination(2448724.5).fraction, 0.6786, 0.002);
    const moon = moonAt(jdFromMs(Date.UTC(2024, 3, 9)));
    // New moon of 8 April 2024 (total solar eclipse) at 18:21 UTC.
    close(msFromJd(moon.previousNew), Date.UTC(2024, 3, 8, 18, 21), 2 * 60000);
});

test('every Chinese New Year date is a new-moon day in China', () => {
    for (const [year, date] of Object.entries(DATA.chinese_new_year)) {
        const offset = Number(year) < 1929 ? 7.7611 : 8;
        const found = [-1, 0, 1].some((shift) => {
            const k = Math.round((Number(year) - 2000 + (Number(date.slice(5, 7)) - 1) / 12) * 12.3685) + shift;

            return new Date(msFromJd(phaseJd(k)) + offset * 3600e3).toISOString().slice(0, 10) === date;
        });
        assert.ok(found, `${year} ${date}`);
    }
});

test('time and date tools', () => {
    assert.equal(time.age({ birth: '1990-05-15', on: '2026-10-18', now: NOW }, c, raw).value, 36);
    assert.equal(time.date_calc({ start: '2026-10-18', operation: 'add', years: 0, months: 0, weeks: 0, days: 90 }, c, raw).value, 'Saturday, January 16, 2027');
    assert.equal(time.bc_ad({ year_a: 500, era_a: 'bc', year_b: 500, era_b: 'ad' }, c, raw).value, 999);
    assert.equal(time.business_days({ start: '2027-01-01', end: '2027-12-31', include_start: true, include_end: true, weekend: 'sat_sun', holidays: 'us', holiday_list: '' }, c, raw).value, 249);
    assert.equal(time.lunar_age({ birth: '1990-01-20', on: '2026-10-18', now: NOW }, c, raw).value, 38);
    assert.equal(time.korean_age({ birth: '2025-12-31', on: '2026-01-01', now: NOW }, c, raw).value, 2);
    assert.equal(time.palindrome({ from: 2000, to: 2100, format: 'mdy', now: NOW }, c, raw).value, 12);
    assert.equal(time.time_difference({ start: '2026-12-18T22:30', start_zone: 'America/New_York', end: '2026-12-19T11:15', end_zone: 'Europe/London' }, c, raw).value, '7 h 45 min');
    assert.equal(time.time_difference({ start: '2026-03-07T12:00', start_zone: 'America/Chicago', end: '2026-03-08T12:00', end_zone: 'America/Chicago' }, c, raw).value, '23 h');
    assert.equal(time.sleep({ mode: 'wake', time: '06:30', latency: 15, cycle: 90 }, c, raw).value, '10:45 PM');
    assert.equal(sunSign({ m: 8, d: 24 }), 'Virgo');
    assert.equal(sunSign({ m: 12, d: 25 }), 'Capricorn');
});

test('transport formulas', () => {
    close(pressureAt(0), 101325, 1e-6);
    const tire = parseTire('225/45R17');
    close(tire.diameter / IN, 24.97244, 1e-4);
    assert.equal(parseTire('33x12.50R15').diameter / IN, 33);
    close(pistonPosition(180, 0.1, 0.15), 0.1, 1e-12);
    close(transport.boat_speed({ power: 250 * 745.6998715822702, weight: 4000 * 453.59237, constant: '150' }, c, raw).value, 37.5, 1e-9);
    close(transport.horsepower({ mode: 'torque', torque: 1.3558179483314003 * 5252, rpm: 1 }, c, raw).value, 1, 1e-4);
    assert.equal(transport.miles_to_dollars({ miles: 48, trips: 20, rate: 'business_2026b' }, c, raw).value, '$729.60');
    assert.equal(transport.gas_oil({ ratio: 50, fuel: 3.785411784 }, c, raw).rows.floz, '2.56 US fl oz');
    close(transport.crosswind({ runway_mode: 'number', runway: 27, direction: 300, speed: 18 * 1852 / 3600 }, c, raw).value, 9, 1e-9);
    assert.equal(transport.speedo_gear({ revs: 672, axle: 4.1, drive: 8 }, c, raw).value, 22);
});

test('home, hygiene and other formulas', () => {
    close(halfEllipse(1, 1), Math.PI, 1e-9);
    close(home.pool_salt({ volume: 15000 * 3.785411784, current: 0, target: 3200, bag: 18143.7 }, c, raw).value, 400.58, 0.01);
    close(home.roll_length({ outer: 0.12, core: 0.076, thickness: 0.0001 }, c, raw).value, 67.73, 0.01);
    assert.equal(home.microwave({ minutes: 2, seconds: 0, from: 1100, to: 700 }, c, raw).value, '3:09');
    close(care.headphones({ sensitivity: 98, basis: 'mw', impedance: 300, spl: 110 }, c, raw).value, 15.849, 0.001);
    close(care.well({ diameter: 6 * IN, depth: 200 * 0.3048, static: 80 * 0.3048 }, c, raw).value, 176.26, 0.01);
    close(care.sunscreen({ height: 1.7, weight: 70000, face: true, arms: true, front: true, back: true, legs: true, per_day: 1, days: 1, people: 1, bottle: NaN }, c, raw).value, 36, 0.01);
});

test('office: words, scores and paper', () => {
    assert.equal(numberWords('1234567.89'), 'one million two hundred thirty-four thousand five hundred sixty-seven point eight nine');
    assert.equal(numberWords('12345678', { indian: true }), 'one crore twenty-three lakh forty-five thousand six hundred seventy-eight');
    assert.equal(checkWords('1234.56'), 'One thousand two hundred thirty-four and 56/100 dollars');
    assert.equal(toCase('the lord of the rings: the return of the king', 'title'), 'The Lord of the Rings: The Return of the King');
    assert.equal(toCase('Total amount due', 'snake'), 'total_amount_due');
    assert.equal(words("Don't stop: it's five o'clock.").length, 5);
    assert.equal(office.gmat({ score: 645 }, c, raw).value, '85.6%');
    assert.equal(office.sat({ total: 1200 }, c, raw).value, '75th');
    close(office.paper_weight({ direction: 'from_gsm', gsm: 75, grade: 'bond' }, c, raw).value, 19.9, 1e-9);
    close(ergonomics(1.75).seatedElbow, 0.7075, 1e-9);
    assert.equal(office.deadline({ start: '2026-12-18', days: 10, weekend: 'sat_sun', holidays: 'us' }, c, raw).value, 'Tuesday, January 5, 2027');
});

test('clothing sizes and sewing layouts', () => {
    const ring = ringSizes(54.4);
    assert.equal(ring.us, 7);
    assert.equal(ring.uk, 'N½');
    assert.deepEqual(shoeSizes(0.265), { usMen: 9.5, usWomen: 11, uk: 8.5, eu: 43, mondo: 265, jp: 26.5 });
    close(footFromSize(9.5, 'us_men'), (31.5 / 3) * IN, 1e-12);
    assert.deepEqual(braSize(32 * IN, 37 * IN), { band: 32, cupIndex: 5, euBand: 80, euIndex: 1 });
    assert.equal(packPieces([{ name: 'A', length: 1, w: 0.5, count: 2 }], 1).length, 1);
    assert.equal(clothing.hst({ finished: 3 * IN, count: 48, method: 'two', trim: false, wof: 42 * IN }, c, raw).value, '3 ⅞ in');
    assert.equal(clothing.hat({ head: 22.5 * IN }, c, raw).value, '7 ⅛');
});

test('text styles, translators and marathons', () => {
    assert.equal(styleText('Hi 1', 'bold'), '𝐇𝐢 𝟏');
    assert.equal(styleText('he', 'italic'), 'ℎ𝑒');
    assert.equal(styleText('Be', 'script'), 'ℬℯ');
    assert.equal(upsideDown('Hello!'), '¡ollǝH');
    assert.equal(pigLatin('Quite a string'), 'Itequay away ingstray');
    assert.equal(natoSpell('SOS 9', { spoken: true }), 'Sierra Oscar Sierra / Niner');
    assert.equal(fun.middle_earth({ lotr: true, hobbit: false, rohirrim: false, version: 'extended', order: 'story', break: 0, start: '' }, c, raw).value, '11 h 55 min');
    assert.equal(fun.star_wars({ saga: true, anthology: false, clone_wars: false, order: 'release', break: 0, start: '' }, c, raw).value, '20 h 24 min');
    assert.equal(fun.hp_currency({ amount: 1, from: 'galleon' }, c, raw).rows.knuts, '493 Knuts');
    assert.equal(fun.yes_no({ question: 'x', toss: 1, random: 0.2 }, c, raw).value, 'Yes');
    assert.equal(books.reading_time({ mode: 'words', words: 90000, wpm: 238, daily: 0, now: NOW }, c, raw).value, '6 h 18 min');
});
