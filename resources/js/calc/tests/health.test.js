import assert from 'node:assert/strict';
import { execSync } from 'node:child_process';
import test from 'node:test';
import { BMR, bmi, idealWeights } from '../health/body.js';
import { lmsAt, percentile, zScore } from '../health/growth.js';
import { toConventional } from '../health/labs.js';
import { framingham, handlers as clinical, heartAge, pooledCohort } from '../tools/hl-clinical.js';
import { eer } from '../tools/hl-diet.js';
import { egfr, nadler, handlers as labs } from '../tools/hl-labs.js';
import { finalSize, meld3, meldNa, handlers as misc } from '../tools/hl-misc.js';
import { bbtShift, dueDate, eyeColour, handlers as pregnancy } from '../tools/hl-pregnancy.js';
import { scoreBand, scoreTotal } from '../tools/hl-scores.js';

const DATA = JSON.parse(execSync(`php -r 'echo json_encode(require "config/health_data.php");'`, { maxBuffer: 1e8 }).toString());
const close = (actual, expected, tolerance) => assert.ok(Math.abs(Number(actual) - expected) <= tolerance, `${actual} ≠ ${expected}`);
const number = (text) => Number(String(text).replace(/[^0-9.−-]/g, '').replace('−', '-'));
const ACC = { age: 55, tc: 213, hdl: 50, sbp: 120, treated: false, smoker: 0, diabetes: 0 };

test('body measures: BMI, Mifflin–St Jeor, Devine and IOM EER', () => {
    close(bmi(70, 1.75), 22.857, 0.001);
    close(BMR.mifflin({ kg: 70, cm: 175, age: 30, sex: 'male' }), 1648.75, 1e-9);
    close(idealWeights(175.26, 'male').devine, 70.7, 0.05);
    close(eer({ age: 30, sex: 'female', kg: 65, cm: 165, pa: 'low' }), 2170, 1);
});

test('growth charts: CDC and WHO LMS medians', () => {
    const median = lmsAt(DATA.growth.cdc_bmi.male, 24);
    close(median[1], 16.575, 0.001);
    close(zScore(median[1], median), 0, 1e-9);
    close(percentile(DATA.growth.who_weight.female, 0, 3.2322).percentile, 50, 0.01);
});

test('Pooled Cohort Equations match the ACC/AHA worked examples', () => {
    close(100 * pooledCohort({ ...ACC, sex: 'female', race: 'white' }), 2.1, 0.05);
    close(100 * pooledCohort({ ...ACC, sex: 'female', race: 'black' }), 3.0, 0.05);
    close(100 * pooledCohort({ ...ACC, sex: 'male', race: 'white' }), 5.3, 0.1);
    close(100 * pooledCohort({ ...ACC, sex: 'male', race: 'black' }), 6.1, 0.05);
    assert.equal(clinical.pce({ ...ACC, age: 30, sex: 'male', tc_unit: 'mg/dL', hdl_unit: 'mg/dL' }).error, 'The Pooled Cohort Equations are validated for ages 40 to 79.');
});

test('Framingham 2008 risk rises with risk factors and heart age follows', () => {
    const base = { ...ACC, sex: 'male' };
    const smoker = { ...base, smoker: 1, sbp: 140, treated: true };
    assert.ok(framingham(smoker) > framingham(base));
    close(heartAge({ age: 55, sex: 'male', tc: 180, hdl: 45, sbp: 125, treated: false, smoker: 0, diabetes: 0 }), 55, 0.01);
    assert.ok(heartAge(smoker) > 75);
});

test('clinical formulas: QTc, MAP, Parkland, A–a gradient, PBW and RTS', () => {
    assert.equal(clinical.qtc({ qt: 400, hr: 80, input: 'hr', formula: 'bazett', sex: 'male' }).value, '462 ms');
    assert.equal(clinical.qtc({ qt: 400, hr: 80, input: 'hr', formula: 'fridericia', sex: 'male' }).value, '440 ms');
    assert.equal(clinical.map({ sbp: 120, dbp: 80 }).value, '93 mmHg');
    assert.equal(clinical.parkland({ weight: 80000, tbsa: 30 }).value, '9,600 mL');
    assert.equal(clinical.aa({ fio2: 21, pao2: 90, paco2: 40, patm: 760, age: 40 }).value, '10 mmHg');
    assert.equal(clinical.tidal({ height: 1.75, sex: 'male', ml_kg: 6 }).value, '423 mL');
    assert.equal(clinical.rts({ gcs: 15, sbp: 120, rr: 16 }).value, '7.84');
    assert.equal(clinical.iss({ head: '3', face: '1', chest: '4', abdomen: '2', extremity: '3', external: '1' }).value, '34');
    assert.equal(clinical.iss({ head: '6' }).value, '75');
});

test('scores: totals, bands and safety alerts', () => {
    const phq9 = DATA.scores.phq9;
    const all = Object.fromEntries(phq9.items.map((item) => [item.key, 'o1']));
    assert.equal(scoreTotal(phq9, all).total, 9);
    assert.equal(scoreBand(phq9, 9)[1], 'Mild (5–9)');
    assert.match(clinical.dasi({}, { data: { score: DATA.scores.dasi } }).sub, /9\.6 mL\/kg\/min/);

    const wells = scoreTotal(DATA.scores.wells_pe, { likely: true, hr: true });
    assert.equal(wells.total, 4.5);

    const news2 = DATA.scores.news2;
    const single = { rr: 'o0', spo2: 'o3', air: 'o0', sbp: 'o3', pulse: 'o2', acvpu: 'o0', temp: 'o2' };
    assert.equal(scoreTotal(news2, single).total, 3);
    assert.equal(scoreBand(news2, 3)[1], 'Low clinical risk (0–4)');
});

test('kidney and electrolytes: CKD-EPI 2021, Cockcroft–Gault, anion gap, osmolality', () => {
    close(egfr.creatinine(1.1, 55, false), 79.3, 0.2);
    close(egfr.creatinine(0.7, 40, true), 112.1, 0.1);
    assert.equal(labs.crcl({ age: 65, sex: 'male', cr: 1.2, cr_unit: 'mg/dL', weight: 85000, height: 1.7 }).value, '64 mL/min');
    assert.equal(labs.anion_gap({ na: 140, cl: 100, hco3: 14, albumin: 3, albumin_unit: 'g/dL' }).rows.corrected.split(' ')[0], '29');
    assert.equal(labs.osm({ na: 140, glucose: 100, glucose_unit: 'mg/dL', bun: 14, bun_unit: 'mg/dL BUN' }).value, '291 mOsm/kg');
    assert.equal(labs.corrected_ca({ ca: 7.8, ca_unit: 'mg/dL', albumin: 2.5, albumin_unit: 'g/dL' }).value, '9.0 mg/dL');
    assert.equal(labs.arterial_ph({ pco2: 40, hco3: 24 }).value, '7.40');
    assert.equal(labs.acid_base({ ph: 7.28, pco2: 28, hco3: 13 }).value, 'Metabolic acidosis');
    close(toConventional(88.42, 'creatinine', 'µmol/L'), 1, 1e-9);
});

test('blood: Nadler volume, ANC, INR and Ganzoni deficit', () => {
    close(nadler(1.7, 70, false), 4.66, 0.01);
    assert.equal(labs.anc({ wbc: 4.5, segs: 40, bands: 5 }).value, '2,025/µL');
    assert.equal(labs.inr({ pt: 24, mnpt: 12, isi: 1.1 }).value, '2.1');
    assert.equal(labs.iron_deficit({ weight: 70000, hb: 9, hb_unit: 'g/dL', target: 15 }).value, '1,508 mg');
});

test('liver and epidemiology: MELD bounds, SIR final size, NNT and vaccine efficacy', () => {
    assert.equal(meld3({ bilirubin: 1, inr: 1, creatinine: 1, sodium: 137, albumin: 3.5, female: false }), 6);
    assert.deepEqual(meldNa({ bilirubin: 1, inr: 1, creatinine: 1, sodium: 137 }), { meld: 6, meldNa: 6 });
    close(finalSize(2.5), 0.8926, 0.0005);
    assert.equal(finalSize(0.9), 0);
    assert.equal(misc.nnt({ ce: 30, cn: 200, te: 18, tn: 200 }).value, 'NNT 17');
    assert.equal(misc.vaccine({ vc: 8, vn: 15000, uc: 160, un: 15000 }).value, '95.0%');
    assert.equal(misc.bed({ dose: 2, fractions: 30, ab: '10' }).rows.eqd2, '60.0 Gy');
});

test('pregnancy dating, cycles and the three-over-six rule', () => {
    assert.deepEqual(dueDate({ lmp: '2026-07-06', cycle: 28 }, 'lmp').edd, { y: 2027, m: 4, d: 12 });
    assert.deepEqual(dueDate({ lmp: '2026-07-06', cycle: 32 }, 'lmp').edd, { y: 2027, m: 4, d: 16 });
    assert.deepEqual(dueDate({ transfer: '2026-07-25', embryo: '5' }, 'ivf').edd, { y: 2027, m: 4, d: 12 });
    assert.equal(pregnancy.pregnancy({ lmp: '2026-07-06', cycle: 28, today: '2026-10-19' }, { focus: 'age' }).value, '15 weeks 0 days');
    assert.match(pregnancy.edd_compare({ lmp: '2026-07-06', cycle: 28, scan: '2026-09-01', scan_weeks: 7, scan_days: 0 }).sub, /^Use the ultrasound date/);
    assert.equal(pregnancy.crl({ crl: 45 }).value, '11 weeks 1 day');
    assert.equal(bbtShift([36.4, 36.3, 36.4, 36.5, 36.3, 36.4, 36.4, 36.7, 36.8, 36.8], 0.1).index, 7);
    const blue = eyeColour('blue', 'blue');
    assert.equal(blue.blue, 1);
    close(Object.values(eyeColour('brown', 'green')).reduce((a, b) => a + b, 0), 1, 1e-9);
});

test('schedules only do date and time arithmetic', () => {
    assert.equal(misc.med_times({ mode: 'awake', times: '3', wake: '07:00', bed: '22:00' }).value, '07:00, 14:30, 22:00');
    assert.equal(misc.refill({ filled: '2026-10-01', quantity: 90, per_day: 3, window: '80' }).value, 'Oct 31, 2026');
    close(number(misc.half_life({ mode: 'single', amount: 500, half: 6, time: 12 }).value), 125, 1e-9);
});
