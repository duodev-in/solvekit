import assert from 'node:assert/strict';
import { execSync } from 'node:child_process';
import test from 'node:test';
import { easterGregorian, easterOrthodox, fromJd, jdn, maya, season, vincenty } from '../tech/geo.js';
import { ieltsOverall, handlers as edu } from '../tools/ot-edu.js';
import { HAND_NAMES, category, evaluate, parseCards, handlers as play } from '../tools/ot-play.js';
import { handlers as misc } from '../tools/ot-misc.js';

/** Reference values from geographiclib, python-dateutil and astropy, and from the published rules cited per test. */
const load = (file) => JSON.parse(execSync(`php -r 'echo json_encode(require "config/${file}.php");'`).toString());
const data = { units: load('units'), other: load('other_data'), physics: load('physics_data') };
const run = (handler, inputs) => handler(inputs, { data });

test('Easter matches dateutil', () => {
    assert.deepEqual(easterGregorian(2027), { y: 2027, m: 3, d: 28 });
    assert.deepEqual(easterOrthodox(2027), { y: 2027, m: 5, d: 2 });
    assert.deepEqual(easterGregorian(2025), easterOrthodox(2025));
});

test('Mayan calendar on 21 December 2012', () => {
    const day = maya(jdn(2012, 12, 21));
    assert.equal(day.longCount, '13.0.0.0.0');
    assert.equal(day.tzolkin, '4 Ajaw');
    assert.equal(day.haab, '3 K’ank’in');
});

test('geodesic distance matches geographiclib', () => {
    const london = vincenty(51.5074, -0.1278, 40.7128, -74.006);
    assert.ok(Math.abs(london.distance - 5585233.5789) < 1e-3, london.distance);
    assert.ok(Math.abs(london.initial - (360 - 71.631002)) < 1e-5, london.initial);
});

test('the 2027 March equinox matches astropy within a minute', () => {
    const t = fromJd(season(2027, 0));
    const astropy = 20 * 60 + 24 + 41 / 60;
    assert.deepEqual([t.y, t.m, t.d], [2027, 3, 20]);
    assert.ok(Math.abs(t.minutes - astropy) < 1, t.text);
});

test('IELTS overall band rounds .25 and .75 up', () => {
    assert.equal(ieltsOverall([6.5, 6.5, 5, 7]), 6.5);
    assert.equal(ieltsOverall([4, 3.5, 4, 4]), 4);
    assert.equal(ieltsOverall([6, 6, 6, 6.5]), 6);
    assert.equal(ieltsOverall([6.5, 6.5, 7, 7]), 7);
    assert.match(run(edu.ielts, { mode: 'bands', listening: 7, reading: 6.5, writing: 6, speaking: 7 }).value, /6\.5/);
});

test('D&D 5e (2014): encounter difficulty and hit points', () => {
    // 3 × CR 1 + 4 × CR 1/2 = 1,000 XP × 2.5 (7–10 monsters) = 2,500 against a 1,750 / 2,625 Medium / Hard party.
    assert.match(run(play.dnd_encounter, { rules: '2014', party: '5 5 5 4', monsters: '3 × 1\n1/2 × 4' }).value, /Medium/);
    // Fighter (d10), Con 14: 10 + 2 at level 1, then 6 + 2 for four levels.
    assert.match(run(play.dnd_hp, { cls: 'fighter', level: 5, con: 14, extra: '0' }).value, /^44\b/);
});

test('optimal stopping skips 7 of 20 candidates', () => {
    const r = run(play.dating_theory, { n: 20 });
    assert.match(r.value, /^7 candidates/);
    assert.match(r.rows.chance, /38\.4/);
});

test('poker hand ranking', () => {
    assert.equal(HAND_NAMES[category(evaluate(parseCards('Ah Kh Qh Jh Th')))], 'Straight flush');
    assert.ok(evaluate(parseCards('As Ad Ac Kd Kh')) > evaluate(parseCards('As Ks Qs Js 9s')));
});

test('dimensional weight bills the larger weight', () => {
    // 50 × 40 × 30 cm ÷ 5,000 = 12 kg against 8 kg actual.
    const r = run(misc.dim_weight, { carrier: 'fedex_ups', divisor: 5000, l: 0.5, w: 0.4, h: 0.3, actual: 8 });
    assert.match(r.value, /12/);
});
