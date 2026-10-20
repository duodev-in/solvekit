import assert from 'node:assert/strict';
import test from 'node:test';
import { fmtTime, parseTime, raceTime, vdot } from '../sports/time.js';
import { handlers as ball, innings, overs } from '../tools/sp-ball.js';
import { cyclingPower, handlers as cycle } from '../tools/sp-cycle.js';
import { handlers as fit, kcal } from '../tools/sp-fit.js';
import { bowling, eventPoints, handlers as misc } from '../tools/sp-misc.js';

/**
 * Inputs are in each unit table's base (mass in g, the rest SI); reference values come from each sport's
 * published definitions and are worked by hand in the comments.
 */
const num = (text) => Number(String(text).replace(/,/g, '').replace('−', '-').replace(/[^0-9.eE+-]/g, ''));
const close = (actual, expected, tolerance) => assert.ok(Math.abs((typeof actual === 'string' ? num(actual) : actual) - expected) <= tolerance, `${actual} ≠ ${expected}`);
const sports = {
    combined_events: {
        decathlon: {
            '100m': { name: '100 m', type: 'track', A: 25.4347, B: 18, C: 1.81 },
            lj: { name: 'Long jump', type: 'jump', A: 0.14354, B: 220, C: 1.4 },
            sp: { name: 'Shot put', type: 'throw', A: 51.39, B: 1.5, C: 1.05 },
            hj: { name: 'High jump', type: 'jump', A: 0.8465, B: 75, C: 1.42 },
            '400m': { name: '400 m', type: 'track', A: 1.53775, B: 82, C: 1.81 },
            '110mh': { name: '110 m hurdles', type: 'track', A: 5.74352, B: 28.5, C: 1.92 },
            dt: { name: 'Discus', type: 'throw', A: 12.91, B: 4, C: 1.1 },
            pv: { name: 'Pole vault', type: 'jump', A: 0.2797, B: 100, C: 1.35 },
            jt: { name: 'Javelin', type: 'throw', A: 10.14, B: 7, C: 1.08 },
            '1500m': { name: '1500 m', type: 'track', A: 0.03768, B: 480, C: 1.85 },
        },
    },
    strength: {
        wilks: { male: [-216.0475144, 16.2606339, -0.002388645, -0.00113732, 7.01863e-6, -1.291e-8] },
        dots: { male: [-0.000001093, 0.0007391293, -0.1918759221, 24.0900756, -307.75076] },
    },
};
const run = (handler, inputs) => handler(inputs, { data: { units: {}, sports } });

test('race times and VDOT', () => {
    assert.equal(parseTime('25:00'), 1500);
    assert.equal(parseTime('1:02:03'), 3723);
    assert.equal(fmtTime(3723), '1:02:03');
    // Daniels' tables: a 20:00 5K is VDOT 49.8 and a 25:00 5K is 38.3.
    close(vdot(5000, 1200), 49.8, 0.05);
    close(vdot(5000, 1500), 38.3, 0.05);
    close(raceTime(vdot(5000, 1200), 5000), 1200, 1);
});

test('baseball, basketball and cricket statistics', () => {
    assert.equal(run(ball.batting_average, { H: 150, AB: 500 }).value, '.300');
    close(innings(6.1), 6 + 1 / 3, 1e-12);
    assert.ok(Number.isNaN(innings(6.4)));
    close(overs(12.3), 12.5, 1e-12);
    close(run(ball.era, { ER: 60, IP: 180, G: 9 }).value, 3, 1e-9);
    // Every passer-rating component capped at 2.375 gives the perfect 158.3.
    assert.equal(run(ball.passer_rating, { league: 'nfl', C: 20, A: 20, Y: 500, TD: 6, INT: 0 }).value, '158.3');
    // (2.071 + 1.393 + 1.714 + 1.661) ÷ 6 × 100.
    assert.equal(run(ball.passer_rating, { league: 'nfl', C: 25, A: 35, Y: 300, TD: 3, INT: 1 }).value, '114.0');
});

test('fitness energy and cycling power', () => {
    // 8 METs × 3.5 × 70 kg ÷ 200 = 9.8 kcal per minute.
    close(kcal(8, 70, 1), 9.8, 1e-12);
    const flat = cyclingPower({ m: 85, v: 30 / 3.6, grade: 0, cda: 0.32, crr: 0.004 });
    // Air drag plus rolling resistance at 30 km/h, over a 97.5% efficient drivetrain.
    close(flat.total, (0.5 * 1.225 * 0.32 * (30 / 3.6) ** 3 + 0.004 * 85 * 9.80665 * (30 / 3.6)) / 0.975, 0.01);
    // Tanaka: 208 − 0.7 × 35 = 183.5, shown rounded.
    assert.equal(run(fit.max_hr, { age: 35, sex: 'male' }).value, '184 bpm');
    // 95% of a 250 W 20-minute test.
    close(run(cycle.ftp, { test: 't20', P: 250, w: 70000 }).value, 237.5, 1e-9);
});

test('combined events, strength scores and bowling', () => {
    // World Athletics tables give 1000 points for these marks in every event.
    const marks = { '100m': '10.395', lj: '7.76', sp: '18.40', hj: '2.21', '400m': '46.17', '110mh': '13.80', dt: '56.17', pv: '5.28', jt: '77.19', '1500m': '3:53.79' };
    assert.equal(run(misc.decathlon, marks).value, '10,000');
    assert.equal(eventPoints(sports.combined_events.decathlon['100m'], 10.395), 1000);
    // Wilks coefficient at 90 kg (men) is 0.6384 in the published table.
    close(run(misc.wilks, { sex: 'male', bw: 90000, total: 600000 }).rows.coef, 0.6384, 1e-4);
    close(run(misc.dots, { sex: 'male', bw: 90000, total: 600000 }).value, 387.96, 0.01);
    assert.equal(bowling('X X X X X X X X X XXX').total, 300);
    // 20 + 19 + 9 + 30 + 28 + 20 + 20 + 30 + 30 + 30.
    assert.equal(run(misc.bowling_score, { rolls: 'X 7/ 9- X X X 8/ X X XXX' }).value, '236');
});

test('Elo and the World Handicap System', () => {
    // Expected score 1 ÷ (1 + 10^(100/400)) = 0.3599; K 20 × 0.6401 = +12.8.
    assert.equal(run(misc.elo, { R: 1600, O: 1700, result: '1', K: '20' }).rows.change, '+12.8');
    // Six scores: lowest two differentials (12.18, 14.83) averaged, minus 1.
    assert.equal(run(misc.golf_handicap, { rounds: '88, 71.2, 128\n92, 70.4, 125\n85, 71.2, 128\n90, 72.0, 131\n87, 70.4, 125\n91, 71.2, 128' }).value, '12.5');
});
