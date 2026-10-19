import { defineTools } from '../engines/formula.js';
import { BSA } from '../health/body.js';
import { toConventional } from '../health/labs.js';
import { scoreTotal } from './hl-scores.js';

/**
 * Cardiovascular, pulmonary and critical-care formulas: risk equations, haemodynamics, echo measurements, ECG intervals,
 * lung volumes, oxygenation indices and trauma scores. Each names its published source. Height arrives in metres, mass in grams.
 */
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
const f0 = (x) => (Number.isFinite(x) ? Math.round(x).toLocaleString('en-US') : '—');
const f1 = (x) => (Number.isFinite(x) ? x.toFixed(1) : '—');
const f2 = (x) => (Number.isFinite(x) ? x.toFixed(2) : '—');
const pct = (x) => `${(100 * x).toFixed(1)}%`;
const kgOf = (g) => g / 1000;
const lab = (i, name, analyte) => toConventional(i[name], analyte, i[`${name}_unit`]);
const need = (message) => ({ empty: message });

/**
 * 10-year ASCVD risk by the Pooled Cohort Equations (Goff et al., ACC/AHA 2013). Ages 40–79, cholesterol in mg/dL.
 */
export function pooledCohort({ age, sex, race, tc, hdl, sbp, treated, smoker, diabetes }) {
    const la = Math.log(age);
    const lt = Math.log(tc);
    const lh = Math.log(hdl);
    const ls = Math.log(sbp);
    const black = race === 'black';
    const female = sex === 'female';
    let sum;
    let s0;
    let mean;

    if (female && !black) {
        sum = -29.799 * la + 4.884 * la * la + 13.54 * lt - 3.114 * la * lt - 13.578 * lh + 3.149 * la * lh + (treated ? 2.019 * ls : 1.957 * ls) + 7.574 * smoker - 1.665 * la * smoker + 0.661 * diabetes;
        [s0, mean] = [0.9665, -29.18];
    } else if (female) {
        sum = 17.114 * la + 0.94 * lt - 18.92 * lh + 4.475 * la * lh + (treated ? 29.291 * ls - 6.432 * la * ls : 27.82 * ls - 6.087 * la * ls) + 0.691 * smoker + 0.874 * diabetes;
        [s0, mean] = [0.9533, 86.61];
    } else if (!black) {
        sum = 12.344 * la + 11.853 * lt - 2.664 * la * lt - 7.99 * lh + 1.769 * la * lh + (treated ? 1.797 * ls : 1.764 * ls) + 7.837 * smoker - 1.795 * la * smoker + 0.658 * diabetes;
        [s0, mean] = [0.9144, 61.18];
    } else {
        sum = 2.469 * la + 0.302 * lt - 0.307 * lh + (treated ? 1.916 * ls : 1.809 * ls) + 0.549 * smoker + 0.645 * diabetes;
        [s0, mean] = [0.8954, 19.54];
    }

    return 1 - s0 ** Math.exp(sum - mean);
}

/**
 * 10-year general cardiovascular risk (D'Agostino et al., Circulation 2008), cholesterol in mg/dL.
 */
export function framingham({ age, sex, tc, hdl, sbp, treated, smoker, diabetes }) {
    const male = sex !== 'female';
    const c = male ? [3.06117, 1.1237, -0.93263, 1.93303, 1.99881, 0.65451, 0.57367, 0.88936, 23.9802] : [2.32888, 1.20904, -0.70833, 2.76157, 2.82263, 0.52873, 0.69154, 0.95012, 26.1931];
    const sum = c[0] * Math.log(age) + c[1] * Math.log(tc) + c[2] * Math.log(hdl) + (treated ? c[4] : c[3]) * Math.log(sbp) + c[5] * smoker + c[6] * diabetes;

    return 1 - c[7] ** Math.exp(sum - c[8]);
}

/** Heart (vascular) age: the age at which someone with normal risk factors has the same Framingham risk. */
export function heartAge(p) {
    const risk = framingham(p);
    const normal = (a) => framingham({ age: a, sex: p.sex, tc: 180, hdl: 45, sbp: 125, treated: false, smoker: 0, diabetes: 0 });
    let low = 20;
    let high = 110;

    for (let n = 0; n < 60; n += 1) {
        const mid = (low + high) / 2;

        if (normal(mid) < risk) {
            low = mid;
        } else {
            high = mid;
        }
    }

    return (low + high) / 2;
}

function lipidProfile(i) {
    return { age: i.age, sex: i.sex === 'female' ? 'female' : 'male', race: i.race, tc: lab(i, 'tc', 'cholesterol'), hdl: lab(i, 'hdl', 'cholesterol'), sbp: i.sbp, treated: Boolean(i.treated), smoker: i.smoker ? 1 : 0, diabetes: i.diabetes ? 1 : 0 };
}

const QTC = {
    bazett: (qt, rr) => qt / Math.sqrt(rr),
    fridericia: (qt, rr) => qt / Math.cbrt(rr),
    framingham: (qt, rr) => qt + 154 * (1 - rr),
    hodges: (qt, rr) => qt + 1.75 * (60 / rr - 60),
};

// Revised Trauma Score codes (Champion et al. 1989).
const rtsCode = { gcs: (v) => (v >= 13 ? 4 : v >= 9 ? 3 : v >= 6 ? 2 : v >= 4 ? 1 : 0), sbp: (v) => (v > 89 ? 4 : v >= 76 ? 3 : v >= 50 ? 2 : v >= 1 ? 1 : 0), rr: (v) => (v > 29 ? 3 : v >= 10 ? 4 : v >= 6 ? 2 : v >= 1 ? 1 : 0) };

export const handlers = {
    pce: (i) => {
        const p = lipidProfile(i);

        if (!ok(p.age, p.tc, p.hdl, p.sbp)) {
            return need('Enter age, cholesterol, HDL and systolic blood pressure.');
        }

        if (p.age < 40 || p.age > 79) {
            return { error: 'The Pooled Cohort Equations are validated for ages 40 to 79.' };
        }

        const risk = pooledCohort(p);
        const optimal = pooledCohort({ ...p, tc: 170, hdl: 50, sbp: 110, treated: false, smoker: 0, diabetes: 0 });
        const band = risk < 0.05 ? 'Low (under 5%)' : risk < 0.075 ? 'Borderline (5–7.4%)' : risk < 0.2 ? 'Intermediate (7.5–19.9%)' : 'High (20% or more)';

        return {
            value: pct(risk),
            label: '10-year risk of heart attack or stroke (ASCVD)',
            sub: band,
            rows: { band, optimal: `${pct(optimal)} with optimal risk factors at the same age`, guideline: 'ACC/AHA 2019: statin therapy is usually discussed from 7.5%, alongside risk-enhancing factors', source: 'Pooled Cohort Equations (Goff et al. 2013); race-specific coefficients as published' },
        };
    },

    framingham: (i) => {
        const p = lipidProfile(i);

        if (!ok(p.age, p.tc, p.hdl, p.sbp)) {
            return need('Enter age, cholesterol, HDL and systolic blood pressure.');
        }

        if (p.age < 30 || p.age > 74) {
            return { error: 'The Framingham general CVD equation was developed for ages 30 to 74.' };
        }

        const risk = framingham(p);

        return {
            value: pct(risk),
            label: '10-year cardiovascular disease risk',
            sub: risk < 0.1 ? 'Low (under 10%)' : risk < 0.2 ? 'Intermediate (10–20%)' : 'High (20% or more)',
            rows: { heartAge: `${f0(heartAge(p))} years`, includes: 'Coronary heart disease, stroke, peripheral artery disease and heart failure', source: 'D\'Agostino et al., Circulation 2008' },
        };
    },

    heart_age: (i) => {
        const p = lipidProfile(i);

        if (!ok(p.age, p.tc, p.hdl, p.sbp) || p.age < 30 || p.age > 74) {
            return need('Enter an age of 30–74, cholesterol, HDL and systolic pressure.');
        }

        const age = heartAge(p);

        return {
            value: `${f0(age)} years`,
            label: 'Heart (vascular) age',
            sub: age > p.age + 0.5 ? `${f0(age - p.age)} years older than your age of ${p.age}` : age < p.age - 0.5 ? `${f0(p.age - age)} years younger than your age of ${p.age}` : `The same as your age of ${p.age}`,
            rows: { risk: pct(framingham(p)), normal: 'Compared with someone with total cholesterol 180, HDL 45, systolic 125, no smoking or diabetes', source: 'D\'Agostino et al., Circulation 2008 (vascular age)' },
        };
    },

    bp: (i) => {
        if (!ok(i.sbp, i.dbp)) {
            return need('Enter systolic and diastolic pressure.');
        }

        const s = i.sbp;
        const d = i.dbp;
        const category = s > 180 || d > 120 ? 'Hypertensive crisis (over 180 and/or over 120): seek care now if you have symptoms' : s >= 140 || d >= 90 ? 'Stage 2 hypertension (140+ or 90+)' : s >= 130 || d >= 80 ? 'Stage 1 hypertension (130–139 or 80–89)' : s >= 120 ? 'Elevated (120–129 and under 80)' : 'Normal (under 120 and under 80)';

        return {
            value: `${f0(s)}/${f0(d)} mmHg`,
            label: 'Blood pressure category (ACC/AHA 2017)',
            sub: category,
            rows: { category, map: `${f0(d + (s - d) / 3)} mmHg`, pulse: `${f0(s - d)} mmHg`, esc: s >= 140 || d >= 90 ? 'Hypertension (ESC 2024, 140/90 or more)' : s >= 120 || d >= 70 ? 'Elevated (ESC 2024, 120–139 or 70–89)' : 'Non-elevated (ESC 2024)', check: 'Average two or more readings on two or more occasions before deciding' },
        };
    },

    map: (i) => {
        if (!ok(i.sbp, i.dbp)) {
            return need('Enter systolic and diastolic pressure.');
        }

        const map = i.dbp + (i.sbp - i.dbp) / 3;

        return { value: `${f0(map)} mmHg`, label: 'Mean arterial pressure', sub: map < 65 ? 'Below 65 mmHg: may not perfuse organs well' : map > 100 ? 'Above 100 mmHg' : 'Within the usual 70–100 mmHg', rows: { pulse: `${f0(i.sbp - i.dbp)} mmHg pulse pressure`, formula: 'MAP = DBP + (SBP − DBP) ÷ 3', target: 'Sepsis guidelines target MAP 65 mmHg or more' } };
    },

    shock_index: (i) => {
        if (!ok(i.hr, i.sbp) || i.sbp <= 0) {
            return need('Enter heart rate and systolic pressure.');
        }

        const si = i.hr / i.sbp;
        const map = ok(i.dbp) ? i.dbp + (i.sbp - i.dbp) / 3 : NaN;

        return { value: f2(si), label: 'Shock index', sub: si < 0.7 ? 'Normal (0.5–0.7)' : si < 1 ? 'Raised (0.7–1.0): watch closely' : '1.0 or more: suggests shock', rows: { modified: Number.isFinite(map) ? `${f2(i.hr / map)} (HR ÷ MAP; above 1.3 is high)` : 'Add diastolic pressure', formula: 'SI = HR ÷ SBP (Allgöwer 1967)' } };
    },

    rpp: (i) => {
        if (!ok(i.hr, i.sbp)) {
            return need('Enter heart rate and systolic pressure.');
        }

        const value = i.hr * i.sbp;

        return { value: f0(value), unit: 'mmHg·bpm', label: 'Rate-pressure product', sub: value < 10000 ? 'Typical at rest (under 10,000)' : value < 20000 ? 'Moderate cardiac work' : 'High cardiac work (20,000 or more, as in heavy exercise)', rows: { formula: 'RPP = HR × SBP', meaning: 'An index of myocardial oxygen demand' } };
    },

    cardiac_output: (i) => {
        let co;

        if (i.mode === 'fick') {
            const hb = lab(i, 'hb', 'hemoglobin');

            if (!ok(i.vo2, hb, i.sao2, i.svo2)) {
                return need('Enter VO₂, hemoglobin and arterial and venous saturations.');
            }

            // Fick: CO = VO₂ ÷ (CaO₂ − CvO₂), contents in mL O₂/dL = 1.34 × Hb × SaO₂.
            co = i.vo2 / ((1.34 * hb * (i.sao2 - i.svo2)) / 100 * 10);
        } else {
            if (!ok(i.hr, i.sv)) {
                return need('Enter heart rate and stroke volume.');
            }

            co = (i.hr * i.sv) / 1000;
        }

        const bsa = ok(i.height, i.weight) ? BSA.mosteller(i.height * 100, kgOf(i.weight)) : NaN;

        return { value: `${f2(co)} L/min`, label: 'Cardiac output', sub: co < 4 ? 'Below the usual 4–8 L/min' : co > 8 ? 'Above the usual 4–8 L/min' : 'Within the usual 4–8 L/min', rows: { index: Number.isFinite(bsa) ? `${f2(co / bsa)} L/min/m² (BSA ${f2(bsa)} m²)` : 'Add height and weight for the cardiac index', method: i.mode === 'fick' ? 'Fick principle, assuming dissolved O₂ is negligible' : 'CO = HR × SV' } };
    },

    cardiac_index: (i) => {
        const co = i.mode === 'hrsv' ? (i.hr * i.sv) / 1000 : i.co;
        const bsa = ok(i.height, i.weight) ? BSA.mosteller(i.height * 100, kgOf(i.weight)) : NaN;

        if (!ok(co, bsa)) {
            return need('Enter cardiac output (or heart rate and stroke volume), height and weight.');
        }

        const ci = co / bsa;

        return { value: `${f2(ci)} L/min/m²`, label: 'Cardiac index', sub: ci < 2.2 ? 'Low (under 2.2): suggests cardiogenic shock if with low pressure' : ci < 2.5 ? 'Slightly low (2.2–2.5)' : ci <= 4 ? 'Normal (2.5–4.0)' : 'High (over 4.0)', rows: { bsa: `${f2(bsa)} m² (Mosteller)`, co: `${f2(co)} L/min` } };
    },

    stroke_volume: (i) => {
        let sv;
        let method;

        if (i.mode === 'volumes') {
            sv = i.edv - i.esv;
            method = 'EDV − ESV';
        } else if (i.mode === 'doppler') {
            sv = Math.PI * (i.lvot / 2) ** 2 * i.vti;
            method = 'π × (LVOT ÷ 2)² × VTI';
        } else {
            sv = (i.co * 1000) / i.hr;
            method = 'CO ÷ HR';
        }

        if (!ok(sv) || sv <= 0) {
            return need('Enter the measurements for the chosen method.');
        }

        return { value: `${f0(sv)} mL`, label: 'Stroke volume', sub: sv < 60 ? 'Below the usual 60–100 mL' : sv > 100 ? 'Above the usual 60–100 mL' : 'Within the usual 60–100 mL', rows: { method } };
    },

    doppler_co: (i) => {
        if (!ok(i.lvot, i.vti, i.hr) || i.lvot <= 0) {
            return need('Enter LVOT diameter, VTI and heart rate.');
        }

        const sv = Math.PI * (i.lvot / 2) ** 2 * i.vti;
        const co = (sv * i.hr) / 1000;
        const bsa = ok(i.height, i.weight) ? BSA.mosteller(i.height * 100, kgOf(i.weight)) : NaN;

        return { value: `${f2(co)} L/min`, label: 'Cardiac output (Doppler)', sub: `Stroke volume ${f0(sv)} mL × ${f0(i.hr)} bpm`, rows: { sv: `${f0(sv)} mL`, area: `${f2(Math.PI * (i.lvot / 2) ** 2)} cm² LVOT area`, index: Number.isFinite(bsa) ? `${f2(co / bsa)} L/min/m²` : 'Add height and weight' } };
    },

    ef: (i) => {
        if (!ok(i.edv, i.esv) || i.edv <= 0 || i.esv > i.edv) {
            return need('Enter end-diastolic and end-systolic volumes (ESV below EDV).');
        }

        const ef = (100 * (i.edv - i.esv)) / i.edv;

        return { value: `${f0(ef)}%`, label: 'Ejection fraction', sub: ef >= 50 ? 'Normal (50% or more)' : ef > 40 ? 'Mildly reduced (41–49%)' : 'Reduced (40% or less)', rows: { sv: `${f0(i.edv - i.esv)} mL stroke volume`, hf: ef >= 50 ? 'With heart failure symptoms: HF with preserved EF' : ef > 40 ? 'HF with mildly reduced EF (HFmrEF)' : 'HF with reduced EF (HFrEF)', source: 'AHA/ACC/HFSA 2022 heart failure guideline' } };
    },

    lv_mass: (i) => {
        if (!ok(i.lvid, i.ivs, i.pw) || i.lvid <= 0) {
            return need('Enter LVIDd, IVSd and PWd in cm.');
        }

        // ASE (Devereux) cube formula, dimensions in cm.
        const mass = 0.8 * 1.04 * ((i.ivs + i.lvid + i.pw) ** 3 - i.lvid ** 3) + 0.6;
        const bsa = ok(i.height, i.weight) ? BSA.dubois(i.height * 100, kgOf(i.weight)) : NaN;
        const index = mass / bsa;
        const rwt = (2 * i.pw) / i.lvid;
        const limit = i.sex === 'female' ? 95 : 115;
        const lvh = Number.isFinite(index) && index > limit;
        const geometry = rwt > 0.42 ? (lvh ? 'Concentric hypertrophy' : 'Concentric remodelling') : lvh ? 'Eccentric hypertrophy' : 'Normal geometry';

        return { value: `${f0(mass)} g`, label: 'Left ventricular mass', sub: Number.isFinite(index) ? `${f0(index)} g/m² (normal ≤ ${limit} for ${i.sex === 'female' ? 'women' : 'men'}); ${geometry}` : 'Add height and weight to index by BSA', rows: { index: Number.isFinite(index) ? `${f0(index)} g/m²` : 'Needs height and weight', rwt: `${f2(rwt)} (above 0.42 is concentric)`, geometry, source: 'ASE/EACVI chamber quantification (Lang et al. 2015)' } };
    },

    ava: (i) => {
        if (!ok(i.lvot, i.vti_lvot, i.vti_av) || i.vti_av <= 0) {
            return need('Enter LVOT diameter and both VTIs (or peak velocities).');
        }

        const area = Math.PI * (i.lvot / 2) ** 2;
        const ava = (area * i.vti_lvot) / i.vti_av;
        const bsa = ok(i.height, i.weight) ? BSA.mosteller(i.height * 100, kgOf(i.weight)) : NaN;

        return { value: `${f2(ava)} cm²`, label: 'Aortic valve area (continuity)', sub: ava > 1.5 ? 'Mild stenosis or normal (over 1.5 cm²)' : ava >= 1 ? 'Moderate aortic stenosis (1.0–1.5 cm²)' : 'Severe aortic stenosis (under 1.0 cm²)', rows: { indexed: Number.isFinite(bsa) ? `${f2(ava / bsa)} cm²/m² (severe under 0.6)` : 'Add height and weight', ratio: `${f2(i.vti_lvot / i.vti_av)} velocity ratio (severe under 0.25)`, source: 'Baumgartner et al., ASE/EACVI 2017' } };
    },

    mva: (i) => {
        let mva;

        if (i.mode === 'pht') {
            if (!ok(i.pht) || i.pht <= 0) {
                return need('Enter the pressure half-time.');
            }

            mva = 220 / i.pht;
        } else {
            if (!ok(i.lvot, i.vti_lvot, i.vti_mv) || i.vti_mv <= 0) {
                return need('Enter LVOT diameter and the LVOT and mitral VTIs.');
            }

            mva = (Math.PI * (i.lvot / 2) ** 2 * i.vti_lvot) / i.vti_mv;
        }

        return { value: `${f2(mva)} cm²`, label: 'Mitral valve area', sub: mva > 1.5 ? 'Not severe (over 1.5 cm²)' : mva > 1 ? 'Severe mitral stenosis (1.5 cm² or less)' : 'Very severe mitral stenosis (1.0 cm² or less)', rows: { method: i.mode === 'pht' ? 'MVA = 220 ÷ pressure half-time (Hatle)' : 'Continuity equation', source: 'ACC/AHA 2020 valve guideline staging' } };
    },

    gorlin: (i) => {
        if (!ok(i.co, i.hr, i.period, i.gradient) || i.gradient <= 0) {
            return need('Enter cardiac output, heart rate, ejection or filling period and mean gradient.');
        }

        const constant = i.valve === 'mitral' ? 37.7 : 44.3;
        const area = (i.co * 1000) / (i.hr * (i.period / 1000) * constant * Math.sqrt(i.gradient));

        return { value: `${f2(area)} cm²`, label: `${i.valve === 'mitral' ? 'Mitral' : 'Aortic'} valve area (Gorlin)`, sub: `Constant ${constant} (44.3 × ${i.valve === 'mitral' ? '0.85' : '1'})`, rows: { formula: 'Area = CO ÷ (HR × SEP or DFP × C × √mean gradient)', severity: i.valve === 'mitral' ? (area <= 1.5 ? 'Severe mitral stenosis' : 'Not severe') : area < 1 ? 'Severe aortic stenosis' : area <= 1.5 ? 'Moderate aortic stenosis' : 'Mild or none' } };
    },

    pisa: (i) => {
        if (!ok(i.radius, i.alias, i.vmax) || i.vmax <= 0) {
            return need('Enter PISA radius, aliasing velocity and peak MR velocity.');
        }

        const flow = 2 * Math.PI * i.radius ** 2 * i.alias;
        const eroa = flow / i.vmax;
        const rvol = Number.isFinite(i.vti) ? eroa * i.vti : NaN;
        const severe = eroa >= 0.4 || rvol >= 60;

        return { value: `${f2(eroa)} cm²`, label: 'Effective regurgitant orifice area', sub: eroa >= 0.4 ? 'Severe primary MR (0.40 cm² or more)' : eroa >= 0.2 ? 'Moderate MR (0.20–0.39 cm²)' : 'Mild MR (under 0.20 cm²)', rows: { flow: `${f0(flow)} mL/s regurgitant flow`, rvol: Number.isFinite(rvol) ? `${f0(rvol)} mL regurgitant volume (severe 60 or more)` : 'Add MR VTI for the volume', severity: severe ? 'Severe' : 'Not severe', source: 'Zoghbi et al., ASE 2017' } };
    },

    pvr: (i) => {
        if (!ok(i.mpap, i.pcwp, i.co) || i.co <= 0) {
            return need('Enter mean PA pressure, wedge pressure and cardiac output.');
        }

        const wu = (i.mpap - i.pcwp) / i.co;

        return { value: `${f2(wu)} Wood units`, label: 'Pulmonary vascular resistance', sub: `${f0(wu * 80)} dyn·s·cm⁻⁵: ${wu > 2 ? 'raised (over 2 WU, ESC/ERS 2022 definition of pre-capillary PH)' : 'normal (2 WU or less)'}`, rows: { tpg: `${f1(i.mpap - i.pcwp)} mmHg transpulmonary gradient`, dynes: `${f0(wu * 80)} dyn·s·cm⁻⁵`, ph: i.mpap > 20 ? 'Mean PA pressure over 20 mmHg: pulmonary hypertension by the 2022 definition' : 'Mean PA pressure 20 mmHg or less' } };
    },

    cpp: (i) => {
        const map = ok(i.map) ? i.map : ok(i.sbp, i.dbp) ? i.dbp + (i.sbp - i.dbp) / 3 : NaN;

        if (!ok(map, i.icp)) {
            return need('Enter MAP (or systolic and diastolic) and intracranial pressure.');
        }

        const cpp = map - i.icp;

        return { value: `${f0(cpp)} mmHg`, label: 'Cerebral perfusion pressure', sub: cpp < 60 ? 'Below 60 mmHg: risk of ischaemia' : cpp > 70 ? 'Above 70 mmHg' : 'Within the 60–70 mmHg target (Brain Trauma Foundation 2016)', rows: { map: `${f0(map)} mmHg`, icp: i.icp > 22 ? 'ICP above 22 mmHg: treatment threshold' : 'ICP 22 mmHg or less' } };
    },

    ich_volume: (i) => {
        if (!ok(i.a, i.b, i.c)) {
            return need('Enter A, B and C in cm.');
        }

        const v = (i.a * i.b * i.c) / 2;

        return { value: `${f1(v)} mL`, label: 'Haematoma volume (ABC/2)', sub: v >= 30 ? '30 mL or more: 1 point on the ICH score' : 'Under 30 mL', rows: { formula: 'V = A × B × C ÷ 2 (Kothari 1996)', c: 'C = number of slices with blood × slice thickness (count partial slices as half)' } };
    },

    abi: (i) => {
        const arm = Math.max(or0(i.arm_left), or0(i.arm_right));

        if (arm <= 0 || !ok(i.ankle_left, i.ankle_right)) {
            return need('Enter both arm and both ankle systolic pressures.');
        }

        const band = (v) => (v > 1.4 ? 'Non-compressible (over 1.40)' : v >= 1 ? 'Normal (1.00–1.40)' : v > 0.9 ? 'Borderline (0.91–0.99)' : v > 0.4 ? 'Peripheral artery disease (0.41–0.90)' : 'Severe PAD (0.40 or less)');
        const left = i.ankle_left / arm;
        const right = i.ankle_right / arm;
        const worst = Math.min(left, right);

        return { value: f2(worst), label: 'Ankle-brachial index (lower leg)', sub: band(worst), rows: { left: `${f2(left)}: ${band(left)}`, right: `${f2(right)}: ${band(right)}`, method: 'Each ankle pressure ÷ the higher arm pressure (AHA/ACC 2016)' } };
    },

    six_minute: (i) => {
        const cm = i.height * 100;
        const kg = kgOf(i.weight);

        if (!ok(i.distance, cm, kg, i.age)) {
            return need('Enter distance walked, height, weight and age.');
        }

        // Enright & Sherrill (1998), healthy adults 40–80.
        const predicted = i.sex === 'female' ? 2.11 * cm - 2.29 * kg - 5.78 * i.age + 667 : 7.57 * cm - 5.02 * i.age - 1.76 * kg - 309;
        const lln = predicted - (i.sex === 'female' ? 139 : 153);

        return { value: `${f0((100 * i.distance) / predicted)}%`, label: 'Of predicted distance', sub: `Predicted ${f0(predicted)} m; lower limit of normal ${f0(lln)} m`, rows: { predicted: `${f0(predicted)} m`, lln: `${f0(lln)} m`, result: i.distance < lln ? 'Below the lower limit of normal' : 'Within the normal range', source: 'Enright & Sherrill, Am J Respir Crit Care Med 1998' } };
    },

    duke: (i) => {
        if (!ok(i.minutes, i.st)) {
            return need('Enter exercise time and ST deviation.');
        }

        const angina = { none: 0, nonlimiting: 1, limiting: 2 }[i.angina] ?? 0;
        const score = i.minutes - 5 * i.st - 4 * angina;
        const group = score >= 5 ? ['Low risk (+5 or more)', '97%'] : score >= -10 ? ['Moderate risk (−10 to +4)', '90%'] : ['High risk (−11 or less)', '65%'];

        return { value: f1(score), label: 'Duke treadmill score', sub: `${group[0]}: about ${group[1]} 5-year survival in the original cohort`, rows: { formula: `${f1(i.minutes)} − 5 × ${f1(i.st)} − 4 × ${angina}`, source: 'Mark et al., Ann Intern Med 1987 / N Engl J Med 1991 (Bruce protocol)' } };
    },

    ecg_boxes: (i) => {
        if (!ok(i.boxes) || i.boxes < 0) {
            return need('Enter the number of boxes.');
        }

        const speed = Number(i.speed) || 25;
        const ms = (i.boxes * (i.size === 'large' ? 5 : 1) * 1000) / speed;

        return { value: `${f0(ms)} ms`, label: 'Duration', sub: `${f2(ms / 1000)} s at ${speed} mm/s`, rows: { small: `1 small box = ${f0(1000 / speed)} ms`, large: `1 large box = ${f0(5000 / speed)} ms`, normals: 'PR 120–200 ms, QRS under 120 ms, QTc under 450–460 ms' } };
    },

    ecg_rate: (i) => {
        const speed = Number(i.speed) || 25;
        let hr;

        if (i.method === 'small') {
            hr = (60 * speed) / i.value;
        } else if (i.method === 'large') {
            hr = (60 * speed) / (5 * i.value);
        } else if (i.method === 'six') {
            hr = i.value * 10;
        } else {
            hr = 60 / i.value;
        }

        if (!ok(hr) || hr <= 0) {
            return need('Enter the measurement.');
        }

        return { value: `${f0(hr)} bpm`, label: 'Heart rate', sub: hr < 60 ? 'Bradycardia (under 60)' : hr > 100 ? 'Tachycardia (over 100)' : 'Normal (60–100)', rows: { rr: `${f0(60000 / hr)} ms RR interval`, rule: { small: '1,500 ÷ small boxes (at 25 mm/s)', large: '300 ÷ large boxes', six: 'QRS complexes in 6 seconds × 10 (for irregular rhythms)', seconds: '60 ÷ RR in seconds' }[i.method] ?? '' } };
    },

    qtc: (i) => {
        const rr = i.input === 'rr' ? i.rr / 1000 : 60 / i.hr;

        if (!ok(i.qt, rr) || rr <= 0) {
            return need('Enter QT and heart rate (or RR).');
        }

        const formula = QTC[i.formula] ? i.formula : 'bazett';
        const value = QTC[formula](i.qt, rr);
        const limit = i.sex === 'female' ? 460 : 450;
        const band = value > 500 ? 'Over 500 ms: markedly prolonged, higher risk of torsades' : value > limit ? `Prolonged (over ${limit} ms for ${i.sex === 'female' ? 'women' : 'men'})` : value < 350 ? 'Short (under 350 ms)' : 'Normal';

        return {
            value: `${f0(value)} ms`,
            label: `QTc (${formula[0].toUpperCase()}${formula.slice(1)})`,
            sub: band,
            rows: { band, hr: `${f0(60 / rr)} bpm, RR ${f0(rr * 1000)} ms` },
            grids: { formulas: { columns: ['QTc'], rows: Object.entries(QTC).map(([key, fn]) => ({ header: key[0].toUpperCase() + key.slice(1), cells: [`${f0(fn(i.qt, rr))} ms`], highlight: key === formula })) } },
        };
    },

    // Pulmonary ---------------------------------------------------------------------------------
    aa: (i) => {
        if (!ok(i.fio2, i.pao2, i.paco2)) {
            return need('Enter FiO₂, PaO₂ and PaCO₂.');
        }

        const patm = ok(i.patm) ? i.patm : 760;
        const pAO2 = (i.fio2 / 100) * (patm - 47) - i.paco2 / 0.8;
        const gradient = pAO2 - i.pao2;
        const expected = ok(i.age) ? i.age / 4 + 4 : NaN;

        return { value: `${f0(gradient)} mmHg`, label: 'A–a gradient', sub: Number.isFinite(expected) ? `${gradient > expected ? 'Raised' : 'Normal'} for age (expected about ${f0(expected)} mmHg on room air)` : `Alveolar PO₂ ${f0(pAO2)} mmHg`, rows: { pao2: `${f0(pAO2)} mmHg alveolar (PAO₂ = FiO₂ × (Patm − 47) − PaCO₂ ÷ 0.8)`, expected: Number.isFinite(expected) ? `${f0(expected)} mmHg (age ÷ 4 + 4)` : 'Enter age', note: 'The expected value applies on room air; the gradient widens with higher FiO₂' } };
    },

    dead_space: (i) => {
        if (!ok(i.paco2, i.peco2) || i.paco2 <= 0) {
            return need('Enter PaCO₂ and mixed expired PECO₂.');
        }

        const ratio = (i.paco2 - i.peco2) / i.paco2;

        return { value: f2(ratio), label: 'Dead space fraction (Vd/Vt)', sub: ratio <= 0.3 ? 'Normal (about 0.2–0.3)' : ratio < 0.6 ? 'Raised' : 'High (0.6 or more is linked with higher ARDS mortality)', rows: { vd: ok(i.vt) ? `${f0(ratio * i.vt)} mL of a ${f0(i.vt)} mL breath` : 'Add tidal volume for mL', formula: 'Bohr–Enghoff: (PaCO₂ − PECO₂) ÷ PaCO₂' } };
    },

    ett: (i) => {
        if (i.group === 'adult') {
            const female = i.sex === 'female';

            return { value: female ? '7.0–7.5 mm' : '7.5–8.0 mm', label: 'Endotracheal tube internal diameter', sub: `Typical adult ${female ? 'female' : 'male'} size; oral depth about ${female ? 21 : 23} cm at the teeth`, rows: { depth: `${female ? 21 : 23} cm at the teeth`, note: 'Choose by the patient\'s anatomy; a size smaller should be ready' } };
        }

        if (!ok(i.age) || i.age < 1 || i.age > 16) {
            return need('Enter an age of 1–16 years (infants: 3.0–3.5 mm by weight).');
        }

        const uncuffed = i.age / 4 + 4;
        const cuffed = i.age / 4 + 3.5;

        return { value: `${f1(Math.round(cuffed * 2) / 2)} mm cuffed`, label: 'Endotracheal tube size', sub: `Uncuffed ${f1(Math.round(uncuffed * 2) / 2)} mm (Cole formula); oral depth about ${f0(i.age / 2 + 12)} cm`, rows: { depth: `${f0(i.age / 2 + 12)} cm at the lips (age ÷ 2 + 12), or 3 × the tube size`, note: 'Have half a size above and below ready' } };
    },

    fev1: (i) => {
        if (!ok(i.fev1, i.fvc) || i.fvc <= 0) {
            return need('Enter FEV₁ and FVC after a bronchodilator.');
        }

        const ratio = i.fev1 / i.fvc;
        const pctPred = i.fev1_pct;
        const grade = !Number.isFinite(pctPred) ? 'Enter FEV₁ % predicted for the GOLD grade' : pctPred >= 80 ? 'GOLD 1 (mild, 80% or more)' : pctPred >= 50 ? 'GOLD 2 (moderate, 50–79%)' : pctPred >= 30 ? 'GOLD 3 (severe, 30–49%)' : 'GOLD 4 (very severe, under 30%)';

        return { value: f2(ratio), label: 'FEV₁/FVC', sub: ratio < 0.7 ? 'Below 0.70: airflow obstruction (GOLD)' : 'Not obstructed by the fixed-ratio rule', rows: { grade: ratio < 0.7 ? grade : 'Grading applies only with obstruction', percent: `${f0(100 * ratio)}%`, note: 'The fixed 0.70 ratio can over-diagnose older adults; labs also use the lower limit of normal (GLI)' } };
    },

    lights: (i) => {
        if (!ok(i.pleural_protein, i.serum_protein, i.pleural_ldh, i.serum_ldh, i.ldh_uln)) {
            return need('Enter pleural and serum protein and LDH, and the LDH upper limit of normal.');
        }

        const c = [['Pleural/serum protein > 0.5', i.pleural_protein / i.serum_protein > 0.5, f2(i.pleural_protein / i.serum_protein)], ['Pleural/serum LDH > 0.6', i.pleural_ldh / i.serum_ldh > 0.6, f2(i.pleural_ldh / i.serum_ldh)], ['Pleural LDH > ⅔ of the upper limit', i.pleural_ldh > (2 / 3) * i.ldh_uln, f0(i.pleural_ldh)]];
        const exudate = c.some((x) => x[1]);

        return { value: exudate ? 'Exudate' : 'Transudate', label: "Light's criteria", sub: `${c.filter((x) => x[1]).length} of 3 criteria met (any one means exudate)`, rows: { note: exudate ? 'Exudates come from infection, cancer, inflammation and others; Light\'s criteria can misclassify transudates on diuretics' : 'Transudates are usually from heart failure, cirrhosis or kidney disease', source: 'Light et al., Ann Intern Med 1972' }, grids: { criteria: { columns: ['Met', 'Value'], rows: c.map(([name, met, value]) => ({ header: name, cells: [met ? 'Yes' : 'No', value], highlight: met })) } } };
    },

    lung_volumes: (i) => {
        const h = i.height;

        if (!ok(h, i.age) || h < 1.4) {
            return need('Enter height and age.');
        }

        // ECCS/ERS 1993 reference equations (Quanjer et al.), adults 18–70, height in metres.
        const m = i.sex !== 'female';
        const v = {
            TLC: m ? 7.99 * h - 7.08 : 6.6 * h - 5.79,
            VC: m ? 6.1 * h - 0.028 * i.age - 4.65 : 4.66 * h - 0.024 * i.age - 3.28,
            FRC: m ? 2.34 * h + 0.009 * i.age - 1.09 : 2.24 * h + 0.001 * i.age - 1.0,
            RV: m ? 1.31 * h + 0.022 * i.age - 1.23 : 1.81 * h + 0.016 * i.age - 2.0,
            FVC: m ? 5.76 * h - 0.026 * i.age - 4.34 : 4.43 * h - 0.026 * i.age - 2.89,
            FEV1: m ? 4.3 * h - 0.029 * i.age - 2.49 : 3.95 * h - 0.025 * i.age - 2.6,
        };

        return { value: `${f2(v.TLC)} L`, label: 'Predicted total lung capacity', sub: `ECCS 1993 reference for a ${i.age}-year-old ${m ? 'man' : 'woman'}, ${f0(h * 100)} cm`, grids: { volumes: { columns: ['Predicted'], rows: Object.entries(v).map(([k, x]) => ({ header: { TLC: 'Total lung capacity', VC: 'Vital capacity', FRC: 'Functional residual capacity', RV: 'Residual volume', FVC: 'Forced vital capacity', FEV1: 'FEV₁' }[k], cells: [`${f2(x)} L`] })) } } };
    },

    vital_capacity: (i) => {
        const cm = i.height * 100;

        if (!ok(cm, i.age)) {
            return need('Enter height and age.');
        }

        // Baldwin, Cournand & Richards (1948).
        const vc = (i.sex === 'female' ? 21.78 - 0.101 * i.age : 27.63 - 0.112 * i.age) * cm;
        const measured = Number.isFinite(i.measured) ? i.measured * 1000 : NaN;

        return { value: `${f2(vc / 1000)} L`, label: 'Predicted vital capacity', sub: Number.isFinite(measured) ? `Measured ${f2(measured / 1000)} L is ${f0((100 * measured) / vc)}% of predicted` : 'Baldwin formula', rows: { formula: i.sex === 'female' ? '(21.78 − 0.101 × age) × height cm' : '(27.63 − 0.112 × age) × height cm', note: 'Below 80% of predicted suggests restriction; modern labs use GLI equations' } };
    },

    nodule: (i) => {
        if (!ok(i.d1, i.d2, i.days) || i.d1 <= 0 || i.d2 <= 0 || i.days <= 0) {
            return need('Enter both diameters and the days between scans.');
        }

        if (i.d2 <= i.d1) {
            return { value: 'No growth', label: 'Volume doubling time', sub: 'The nodule has not grown between the scans', rows: { volume: 'No increase in size', source: 'Solid nodules stable for 2 years are usually benign' } };
        }

        const vdt = (i.days * Math.LN2) / (3 * Math.log(i.d2 / i.d1));

        return { value: `${f0(vdt)} days`, label: 'Volume doubling time', sub: vdt < 400 ? 'Under 400 days: growth worrying for a solid nodule' : vdt <= 600 ? '400–600 days: indeterminate' : 'Over 600 days: slow, more often benign', rows: { volume: `${f1((i.d2 / i.d1) ** 3)} × the volume`, formula: 'VDT = t × ln 2 ÷ (3 × ln(d₂ ÷ d₁)), treating the nodule as a sphere', source: 'BTS 2015 pulmonary nodule guideline thresholds' } };
    },

    mean_airway: (i) => {
        if (!ok(i.pip, i.peep, i.ti, i.rr) || i.rr <= 0) {
            return need('Enter PIP, PEEP, inspiratory time and rate.');
        }

        const ttot = 60 / i.rr;
        const k = i.wave === 'sine' ? 0.5 : 1;
        const map = k * (i.pip - i.peep) * (i.ti / ttot) + i.peep;

        return { value: `${f1(map)} cmH₂O`, label: 'Mean airway pressure', sub: `I:E ${f1(i.ti)} s of ${f1(ttot)} s`, rows: { formula: 'MAP = K × (PIP − PEEP) × Ti ÷ Ttot + PEEP', k: `K = ${k} (${i.wave === 'sine' ? 'sine' : 'square'} waveform)` } };
    },

    oi: (i) => {
        if (!ok(i.fio2, i.map, i.pao2) || i.pao2 <= 0) {
            return need('Enter FiO₂, mean airway pressure and PaO₂.');
        }

        const oi = (i.fio2 * i.map) / i.pao2;

        return { value: f1(oi), label: 'Oxygenation index', sub: oi < 4 ? 'Under 4: below the paediatric ARDS range' : oi < 8 ? 'Mild paediatric ARDS (4–8)' : oi < 16 ? 'Moderate paediatric ARDS (8–16)' : 'Severe paediatric ARDS (16 or more)', rows: { formula: 'OI = FiO₂ (%) × MAP ÷ PaO₂', neonatal: oi >= 40 ? '40 or more: a common neonatal ECMO criterion' : 'Neonatal ECMO is often considered at 40 or more' } };
    },

    pf: (i) => {
        if (!ok(i.pao2, i.fio2) || i.fio2 <= 0) {
            return need('Enter PaO₂ and FiO₂.');
        }

        const pf = i.pao2 / (i.fio2 / 100);

        return { value: f0(pf), label: 'PaO₂/FiO₂ ratio', sub: pf > 300 ? 'Over 300: not ARDS range' : pf > 200 ? 'Mild ARDS range (201–300)' : pf > 100 ? 'Moderate ARDS range (101–200)' : 'Severe ARDS range (100 or less)', rows: { note: 'Berlin definition: with PEEP or CPAP of 5 cmH₂O or more, bilateral opacities and onset within a week', sofa: pf >= 400 ? 'SOFA respiration 0' : pf >= 300 ? 'SOFA respiration 1' : 'SOFA respiration 2 or more' } };
    },

    qpqs: (i) => {
        if (!ok(i.sao2, i.svo2, i.spvo2, i.spao2) || i.spvo2 === i.spao2) {
            return need('Enter the four oxygen saturations.');
        }

        const ratio = (i.sao2 - i.svo2) / (i.spvo2 - i.spao2);

        return { value: f2(ratio), label: 'Qp/Qs', sub: ratio < 0.95 ? 'Below 1: net right-to-left shunt' : ratio < 1.05 ? 'About 1: no net shunt' : ratio < 1.5 ? '1–1.5: small left-to-right shunt' : ratio < 2 ? '1.5–2: significant left-to-right shunt' : 'Over 2: large left-to-right shunt', rows: { formula: '(SaO₂ − SvO₂) ÷ (SpvO₂ − SpaO₂)' } };
    },

    rsbi: (i) => {
        if (!ok(i.rr, i.vt) || i.vt <= 0) {
            return need('Enter respiratory rate and tidal volume.');
        }

        const value = i.rr / (i.vt / 1000);

        return { value: f0(value), label: 'Rapid shallow breathing index', sub: value < 105 ? 'Under 105: weaning more likely to succeed' : '105 or more: weaning more likely to fail', rows: { formula: 'RSBI = RR ÷ VT (L), Yang & Tobin 1991' } };
    },

    tidal: (i) => {
        const cm = i.height * 100;

        if (!ok(cm) || cm < 120) {
            return need('Enter height.');
        }

        const pbw = (i.sex === 'female' ? 45.5 : 50) + 0.91 * (cm - 152.4);
        const ml = ok(i.ml_kg) ? i.ml_kg : 6;

        return { value: `${f0(pbw * ml)} mL`, label: `Tidal volume at ${ml} mL/kg`, sub: `Predicted body weight ${f1(pbw)} kg (ARDSnet)`, rows: { range: `${f0(pbw * 4)}–${f0(pbw * 8)} mL (4–8 mL/kg)`, pbw: `${f1(pbw)} kg`, note: 'Lung-protective ventilation targets 6 mL/kg PBW with plateau pressure 30 cmH₂O or less' } };
    },

    psi: (i) => {
        if (!ok(i.age)) {
            return need('Enter age.');
        }

        const items = [
            ['nursing', 10, 'Nursing home resident'], ['cancer', 30, 'Neoplastic disease'], ['liver', 20, 'Liver disease'], ['chf', 10, 'Congestive heart failure'], ['cvd', 10, 'Cerebrovascular disease'], ['renal', 10, 'Renal disease'],
            ['mental', 20, 'Altered mental status'], ['rr', 20, 'Respiratory rate 30 or more'], ['sbp', 20, 'Systolic BP under 90'], ['temp', 15, 'Temperature under 35 °C or 40 °C or more'], ['pulse', 10, 'Pulse 125 or more'],
            ['ph', 30, 'Arterial pH under 7.35'], ['bun', 20, 'BUN 30 mg/dL (11 mmol/L) or more'], ['na', 20, 'Sodium under 130'], ['glucose', 10, 'Glucose 250 mg/dL (14 mmol/L) or more'], ['hct', 10, 'Hematocrit under 30%'], ['o2', 10, 'PaO₂ under 60 or SpO₂ under 90%'], ['effusion', 10, 'Pleural effusion'],
        ];
        const points = (i.sex === 'female' ? i.age - 10 : i.age) + items.reduce((sum, [key, p]) => sum + (i[key] ? p : 0), 0);
        const lowRisk = i.age <= 50 && !['cancer', 'liver', 'chf', 'cvd', 'renal', 'mental', 'rr', 'sbp', 'temp', 'pulse'].some((key) => i[key]);
        const cls = lowRisk ? ['I', '0.1%'] : points <= 70 ? ['II', '0.6%'] : points <= 90 ? ['III', '0.9%'] : points <= 130 ? ['IV', '9.3%'] : ['V', '27%'];

        return { value: `Class ${cls[0]}`, label: 'Pneumonia Severity Index', sub: `${lowRisk ? 'No risk factors and age 50 or under' : `${f0(points)} points`}; 30-day mortality about ${cls[1]} in the derivation cohort`, rows: { points: lowRisk ? 'Class I (not scored)' : `${f0(points)}`, care: ['I', 'II'].includes(cls[0]) ? 'Outpatient treatment is usually appropriate' : cls[0] === 'III' ? 'Outpatient or brief observation' : 'Hospital admission is usually advised', source: 'Fine et al., N Engl J Med 1997' } };
    },

    // Critical care -----------------------------------------------------------------------------
    iss: (i) => {
        const ais = ['head', 'face', 'chest', 'abdomen', 'extremity', 'external'].map((key) => Number(i[key]) || 0);

        if (ais.some((x) => x === 6)) {
            return { value: '75', label: 'Injury Severity Score', sub: 'Any AIS 6 (unsurvivable) region sets ISS to 75', rows: { band: 'Maximum score', formula: 'ISS = sum of the squares of the three highest regional AIS' } };
        }

        const top = [...ais].sort((a, b) => b - a).slice(0, 3);
        const iss = top.reduce((sum, x) => sum + x * x, 0);

        return { value: String(iss), label: 'Injury Severity Score', sub: iss > 15 ? 'Major trauma (ISS over 15)' : iss >= 9 ? 'Moderate (9–15)' : 'Minor (under 9)', rows: { band: iss > 24 ? 'Very severe (25 or more)' : iss > 15 ? 'Severe (16–24)' : iss >= 9 ? 'Moderate' : 'Minor', formula: `${top.map((x) => `${x}²`).join(' + ')} (three highest regions)` } };
    },

    rts: (i) => {
        if (!ok(i.gcs, i.sbp, i.rr)) {
            return need('Enter GCS, systolic pressure and respiratory rate.');
        }

        const codes = { gcs: rtsCode.gcs(i.gcs), sbp: rtsCode.sbp(i.sbp), rr: rtsCode.rr(i.rr) };
        const rts = 0.9368 * codes.gcs + 0.7326 * codes.sbp + 0.2908 * codes.rr;
        const triage = codes.gcs + codes.sbp + codes.rr;

        return { value: f2(rts), label: 'Revised Trauma Score', sub: `Triage RTS ${triage} of 12${triage < 11 ? ': trauma centre care advised' : ''}`, rows: { codes: `GCS ${codes.gcs}, SBP ${codes.sbp}, RR ${codes.rr}`, triage: `${triage} (sum of codes)`, formula: 'RTS = 0.9368 GCS + 0.7326 SBP + 0.2908 RR (coded values)' } };
    },

    nedocs: (i) => {
        if (!ok(i.ed_beds, i.hospital_beds, i.ed_patients, i.admits) || i.ed_beds <= 0 || i.hospital_beds <= 0) {
            return need('Enter beds, patients and admitted patients waiting.');
        }

        // Weiss et al., Acad Emerg Med 2004.
        const score = Math.min(200, Math.max(0, -20 + 85.8 * (i.ed_patients / i.ed_beds) + 600 * (i.admits / i.hospital_beds) + 13.4 * or0(i.vents) + 0.93 * or0(i.admit_hours) + 5.64 * or0(i.wait_hours)));
        const band = score <= 20 ? 'Not busy' : score <= 60 ? 'Busy' : score <= 100 ? 'Extremely busy but not overcrowded' : score <= 140 ? 'Overcrowded' : score <= 180 ? 'Severely overcrowded' : 'Dangerously overcrowded';

        return { value: f0(score), label: 'NEDOCS', sub: band, rows: { band, source: 'National ED Overcrowding Scale (Weiss 2004)' } };
    },

    scorad: (i) => {
        const intensity = ['erythema', 'oedema', 'oozing', 'excoriation', 'lichen', 'dryness'].reduce((sum, key) => sum + (Number(i[key]) || 0), 0);

        if (!ok(i.extent)) {
            return need('Enter the affected body surface (%).');
        }

        const objective = i.extent / 5 + (7 * intensity) / 2;
        const total = objective + or0(i.itch) + or0(i.sleep);

        return { value: f1(total), label: 'SCORAD', sub: total < 25 ? 'Mild (under 25)' : total <= 50 ? 'Moderate (25–50)' : 'Severe (over 50)', rows: { objective: `${f1(objective)} objective SCORAD (mild under 15, severe over 40)`, parts: `A ${f0(i.extent)}% ÷ 5 + 7 × B ${intensity} ÷ 2 + C ${f0(or0(i.itch) + or0(i.sleep))}`, source: 'European Task Force on Atopic Dermatitis, Dermatology 1993' } };
    },

    sepsis: (i) => {
        if (!i.infection) {
            return { value: 'Not assessed', label: 'Sepsis-3', sub: 'Sepsis-3 applies to suspected or confirmed infection', rows: { sepsis: 'No suspected infection entered', shock: 'Not assessed' } };
        }

        const sepsis = or0(i.sofa_rise) >= 2;
        const shock = sepsis && i.vasopressors && or0(i.lactate) > 2;

        return { value: shock ? 'Septic shock' : sepsis ? 'Sepsis' : 'Criteria not met', label: 'Sepsis-3', sub: shock ? 'Vasopressors for MAP ≥ 65 and lactate over 2 mmol/L despite fluids' : sepsis ? 'Infection with a SOFA rise of 2 or more' : 'SOFA rise under 2', rows: { sepsis: sepsis ? 'Yes: organ dysfunction (SOFA +2)' : 'No', shock: shock ? 'Yes' : 'No', source: 'Singer et al., JAMA 2016 (Third International Consensus)' } };
    },

    parkland: (i) => {
        const kg = kgOf(i.weight);

        if (!ok(kg, i.tbsa) || kg <= 0 || i.tbsa <= 0) {
            return need('Enter weight and % total body surface area burned.');
        }

        const total = 4 * kg * i.tbsa;
        const since = or0(i.hours_since);

        return { value: `${f0(total)} mL`, label: 'Fluid in the first 24 hours (Parkland, 4 mL/kg/%TBSA)', sub: `${f0(total / 2)} mL in the first 8 hours from the time of the burn${since ? ` (${f0(Math.max(0, 8 - since))} h remaining)` : ''}, then ${f0(total / 2)} mL over 16 hours`, rows: { first: `${f0(total / 2)} mL (${f0(total / 16)} mL/h)`, next: `${f0(total / 2)} mL (${f0(total / 32)} mL/h)`, range: `${f0(2 * kg * i.tbsa)}–${f0(total)} mL (ABA 2–4 mL/kg/%TBSA)`, note: 'Adjust to urine output (0.5 mL/kg/h in adults); clinical teams decide fluid orders' } };
    },

    dasi: (i, c) => {
        const { total, parts } = scoreTotal(c.data.score, i);
        const vo2 = 0.43 * total + 9.6;

        return { value: f1(total), unit: 'of 58.2', label: 'Duke Activity Status Index', sub: `Estimated peak VO₂ ${f1(vo2)} mL/kg/min (${f1(vo2 / 3.5)} METs)`, rows: { vo2: `${f1(vo2)} mL/kg/min`, mets: f1(vo2 / 3.5), periop: vo2 / 3.5 < 4 ? 'Under 4 METs: lower functional capacity before surgery' : '4 METs or more: adequate functional capacity', source: 'Hlatky et al., Am J Cardiol 1989' }, grids: { items: { columns: ['Answer', 'Points'], rows: parts.map((part) => ({ header: part.item.short ?? part.item.label, cells: [part.answer, String(part.points)], highlight: part.points !== 0 })) } } };
    },
};

export default defineTools(handlers);
