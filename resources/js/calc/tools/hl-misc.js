import { defineTools } from '../engines/formula.js';
import { addDays, parseDate, shortDate, toDays } from '../everyday/dates.js';
import { toConventional } from '../health/labs.js';
import { parseRows } from '../rows-editor.js';

/**
 * Liver scores, geriatric screening, epidemiology, radiology, hormone ratios and medicine schedules. Lab values with a
 * unit menu are converted to conventional US units ({name}_unit). Schedules only do date and time arithmetic on the
 * instructions you already have; nothing here suggests a dose.
 */
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
const f0 = (x) => (Number.isFinite(x) ? Math.round(x).toLocaleString('en-US') : '—');
const f1 = (x) => (Number.isFinite(x) ? x.toFixed(1) : '—');
const f2 = (x) => (Number.isFinite(x) ? x.toFixed(2) : '—');
const kgOf = (g) => g / 1000;
const lab = (i, name, analyte) => toConventional(i[name], analyte, i[`${name}_unit`]);
const need = (message) => ({ empty: message });
const clamp = (x, lo, hi) => Math.min(hi, Math.max(lo, x));
const pct = (x, d = 1) => `${(100 * x).toFixed(d)}%`;

/** MELD 3.0 (Kim et al., Gastroenterology 2021) with the OPTN bounds. */
export function meld3({ bilirubin, inr, creatinine, sodium, albumin, female, dialysis }) {
    const bili = Math.max(1, bilirubin);
    const i = Math.max(1, inr);
    const cr = dialysis ? 3 : clamp(creatinine, 1, 3);
    const na = clamp(sodium, 125, 137);
    const alb = clamp(albumin, 1.5, 3.5);
    const score = 1.33 * (female ? 1 : 0) + 4.56 * Math.log(bili) + 0.82 * (137 - na) - 0.24 * (137 - na) * Math.log(bili) + 9.09 * Math.log(i) + 11.14 * Math.log(cr) + 1.85 * (3.5 - alb) - 1.83 * (3.5 - alb) * Math.log(cr) + 6;

    return Math.min(40, Math.round(score));
}

/** MELD and MELD-Na as used by UNOS from 2016. */
export function meldNa({ bilirubin, inr, creatinine, sodium, dialysis }) {
    const cr = dialysis ? 4 : clamp(creatinine, 1, 4);
    const base = Math.round(10 * (0.957 * Math.log(cr) + 0.378 * Math.log(Math.max(1, bilirubin)) + 1.12 * Math.log(Math.max(1, inr)) + 0.643));
    const na = clamp(sodium, 125, 137);

    return { meld: Math.min(40, base), meldNa: Math.min(40, base > 11 ? Math.round(base + 1.32 * (137 - na) - 0.033 * base * (137 - na)) : base) };
}

/** SIR epidemic model by 4th-order Runge–Kutta; returns the daily infected fraction. */
export function sir({ r0, days, i0, horizon }) {
    const gamma = 1 / days;
    const beta = r0 * gamma;
    let s = 1 - i0;
    let inf = i0;
    const dt = 0.1;
    const daily = [[0, inf]];
    const f = (S, I) => [-beta * S * I, beta * S * I - gamma * I];

    for (let step = 1; step <= horizon / dt; step += 1) {
        const k1 = f(s, inf);
        const k2 = f(s + (dt / 2) * k1[0], inf + (dt / 2) * k1[1]);
        const k3 = f(s + (dt / 2) * k2[0], inf + (dt / 2) * k2[1]);
        const k4 = f(s + dt * k3[0], inf + dt * k3[1]);
        s += (dt / 6) * (k1[0] + 2 * k2[0] + 2 * k3[0] + k4[0]);
        inf += (dt / 6) * (k1[1] + 2 * k2[1] + 2 * k3[1] + k4[1]);

        if (Math.abs(step * dt - Math.round(step * dt)) < 1e-9) {
            daily.push([Math.round(step * dt), inf]);
        }
    }

    return { daily, susceptible: s };
}

/** Final epidemic size z solving z = 1 − e^(−R₀ z). */
export function finalSize(r0) {
    if (r0 <= 1) {
        return 0;
    }

    let z = 0.9;

    for (let n = 0; n < 200; n += 1) {
        z = 1 - Math.exp(-r0 * z);
    }

    return z;
}

// Typical adult effective doses, mSv (Mettler et al., Radiology 2008).
export const EXAMS = {
    'Chest X-ray': 0.1, 'Dental X-ray (intraoral)': 0.005, 'Dental panoramic X-ray': 0.01, 'Mammogram': 0.4, 'Bone density (DXA)': 0.001, 'Arm or leg X-ray': 0.001, 'Lumbar spine X-ray': 1.5, 'Abdomen X-ray': 0.7,
    'Pelvis X-ray': 0.6, 'CT head': 2, 'CT chest': 7, 'CT abdomen': 8, 'CT pelvis': 6, 'CT coronary angiography': 16, 'CT colonography': 10, 'Barium enema': 8, 'Upper GI series': 6, 'Bone scan': 6.3, 'PET scan (FDG)': 14.1,
};
const US_BACKGROUND = 3.1;
// ANS personal dose chart: cosmic radiation by elevation, mrem a year.
const ELEVATION = [[1000, 26], [2000, 28], [3000, 31], [4000, 35], [5000, 41], [6000, 47], [7000, 52], [8000, 66], [9000, 79], [Infinity, 96]];
const STANDARD_2000 = [['Under 1', 13818], ['1–4', 55317], ['5–14', 145565], ['15–24', 138646], ['25–34', 135573], ['35–44', 162613], ['45–54', 134834], ['55–64', 87247], ['65–74', 66037], ['75–84', 44842], ['85 and over', 15508]];
const AREA = [0, 0.1, 10, 30, 50, 70, 90];

export const handlers = {
    // Digestive system ----------------------------------------------------------------------------
    apri: (i) => {
        if (!ok(i.ast, i.uln, i.platelets) || i.uln <= 0 || i.platelets <= 0) {
            return need('Enter AST, the AST upper limit of normal and platelets.');
        }

        const apri = ((i.ast / i.uln) / i.platelets) * 100;

        return { value: f2(apri), label: 'APRI', sub: apri >= 2 ? '2.0 or more: cirrhosis likely (WHO hepatitis C guidance)' : apri >= 1.5 ? '1.5 or more: significant fibrosis likely' : apri < 0.5 ? 'Under 0.5: significant fibrosis unlikely' : '0.5–1.5: indeterminate', rows: { formula: 'APRI = (AST ÷ upper limit) ÷ platelets (× 10⁹/L) × 100', source: 'Wai et al., Hepatology 2003' } };
    },

    ast_alt: (i) => {
        if (!ok(i.ast, i.alt) || i.alt <= 0) {
            return need('Enter AST and ALT.');
        }

        const r = i.ast / i.alt;

        return { value: f2(r), label: 'AST/ALT (De Ritis) ratio', sub: r > 2 ? 'Over 2: typical of alcohol-related liver disease' : r >= 1 ? '1–2: can be seen with cirrhosis of any cause' : 'Under 1: typical of fatty liver disease and viral hepatitis', rows: { note: 'A pattern, not a diagnosis; very high levels of both point to acute injury', source: 'De Ritis et al. 1957; Sorbi et al., Am J Gastroenterol 1999' } };
    },

    fib4: (i) => {
        if (!ok(i.age, i.ast, i.alt, i.platelets) || i.alt <= 0 || i.platelets <= 0) {
            return need('Enter age, AST, ALT and platelets.');
        }

        const fib4 = (i.age * i.ast) / (i.platelets * Math.sqrt(i.alt));
        const low = i.age >= 65 ? 2.0 : 1.3;

        return { value: f2(fib4), label: 'FIB-4', sub: fib4 < low ? `Under ${low}: advanced fibrosis unlikely` : fib4 > 2.67 ? 'Over 2.67: advanced fibrosis likely; specialist referral' : `${low}–2.67: indeterminate; a second test (elastography or ELF) is advised`, rows: { formula: 'FIB-4 = age × AST ÷ (platelets × √ALT)', cutoffs: i.age >= 65 ? 'Age 65 or over: lower cut-off 2.0 (McPherson 2017)' : 'Cut-offs 1.3 and 2.67 (AASLD 2023)', source: 'Sterling et al., Hepatology 2006' } };
    },

    nfs: (i) => {
        const kg = kgOf(i.weight);
        const alb = lab(i, 'albumin', 'albumin');

        if (!ok(i.age, kg, i.height, i.ast, i.alt, i.platelets, alb) || i.alt <= 0) {
            return need('Enter age, height, weight, AST, ALT, platelets and albumin.');
        }

        const bmi = kg / (i.height * i.height);
        const nfs = -1.675 + 0.037 * i.age + 0.094 * bmi + 1.13 * (i.diabetes ? 1 : 0) + 0.99 * (i.ast / i.alt) - 0.013 * i.platelets - 0.66 * alb;

        return { value: f2(nfs), label: 'NAFLD fibrosis score', sub: nfs < -1.455 ? 'Under −1.455: advanced fibrosis unlikely (F0–F2)' : nfs > 0.676 ? 'Over 0.676: advanced fibrosis likely (F3–F4)' : '−1.455 to 0.676: indeterminate', rows: { bmi: `BMI ${f1(bmi)}`, formula: '−1.675 + 0.037 age + 0.094 BMI + 1.13 IFG/DM + 0.99 AST/ALT − 0.013 platelets − 0.66 albumin', source: 'Angulo et al., Hepatology 2007' } };
    },

    maddrey: (i) => {
        const bili = lab(i, 'bilirubin', 'bilirubin');

        if (!ok(i.pt, i.control, bili)) {
            return need('Enter PT, control PT and bilirubin.');
        }

        const df = 4.6 * (i.pt - i.control) + bili;

        return { value: f1(df), label: 'Maddrey discriminant function', sub: df >= 32 ? '32 or more: severe alcohol-associated hepatitis; specialists consider corticosteroids' : 'Under 32: not severe by this score', rows: { formula: 'DF = 4.6 × (PT − control) + bilirubin (mg/dL)', source: 'Maddrey et al., Gastroenterology 1978' } };
    },

    lille: (i) => {
        const b0 = lab(i, 'bili0', 'bilirubin') * 17.104;
        const b7 = lab(i, 'bili7', 'bilirubin') * 17.104;
        const alb = lab(i, 'albumin', 'albumin') * 10;

        if (!ok(i.age, b0, b7, alb, i.pt)) {
            return need('Enter age, albumin, bilirubin on day 0 and day 7, and PT.');
        }

        const r = 3.19 - 0.101 * i.age + 0.147 * alb + 0.0165 * (b0 - b7) - 0.206 * (i.renal ? 1 : 0) - 0.0065 * b0 - 0.0096 * i.pt;
        const lille = Math.exp(-r) / (1 + Math.exp(-r));

        return { value: f2(lille), label: 'Lille score', sub: lille >= 0.45 ? '0.45 or more: no response to corticosteroids (6-month survival about 25%)' : 'Under 0.45: response to corticosteroids (6-month survival about 85%)', rows: { formula: 'Lille = e^−R ÷ (1 + e^−R)', source: 'Louvet et al., Hepatology 2007' } };
    },

    meld: (i) => {
        const p = { bilirubin: lab(i, 'bilirubin', 'bilirubin'), inr: i.inr, creatinine: lab(i, 'cr', 'creatinine'), sodium: i.na, albumin: lab(i, 'albumin', 'albumin'), female: i.sex === 'female', dialysis: Boolean(i.dialysis) };

        if (!ok(p.bilirubin, p.inr, p.creatinine, p.sodium, p.albumin)) {
            return need('Enter bilirubin, INR, creatinine, sodium and albumin.');
        }

        const m3 = meld3(p);
        const old = meldNa(p);
        const survival = 0.946 ** Math.exp(0.17698 * m3 - 3.56);

        return { value: String(m3), label: 'MELD 3.0', sub: `About ${pct(survival, 0)} 90-day survival without a transplant`, rows: { meld: String(old.meld), meldNa: String(old.meldNa), bounds: 'Lab values below 1.0 count as 1.0; creatinine capped at 3.0; sodium 125–137; albumin 1.5–3.5', source: 'Kim et al., Gastroenterology 2021 (OPTN since 2023)' } };
    },

    saag: (i) => {
        const serum = lab(i, 'serum', 'albumin');
        const ascites = lab(i, 'ascites', 'albumin');

        if (!ok(serum, ascites)) {
            return need('Enter serum and ascitic fluid albumin.');
        }

        const saag = serum - ascites;

        return { value: `${f1(saag)} g/dL`, label: 'Serum-ascites albumin gradient', sub: saag >= 1.1 ? '1.1 g/dL or more: portal hypertension (cirrhosis, heart failure, Budd–Chiari)' : 'Under 1.1 g/dL: not portal hypertension (cancer, tuberculosis, pancreatitis, nephrotic syndrome)', rows: { formula: 'SAAG = serum albumin − ascitic albumin, same day', source: 'Runyon et al., Ann Intern Med 1992 (about 97% accurate)' } };
    },

    cdai: (i) => {
        if (!ok(i.stools, i.pain, i.wellbeing, i.hct, i.weight, i.standard) || i.standard <= 0) {
            return need('Enter the 7-day diary totals, haematocrit, weight and standard weight.');
        }

        const complications = ['arthritis', 'iritis', 'skin', 'anal', 'fistula', 'fever'].filter((k) => i[k]).length;
        const hctTerm = 6 * ((i.sex === 'female' ? 42 : 47) - i.hct);
        const weightTerm = Math.max(-10, 100 * (1 - i.weight / i.standard));
        const cdai = 2 * i.stools + 5 * i.pain + 7 * i.wellbeing + 20 * complications + 30 * (i.antidiarrheal ? 1 : 0) + 10 * (Number(i.mass) || 0) + hctTerm + weightTerm;

        return { value: f0(cdai), label: "Crohn's Disease Activity Index", sub: cdai < 150 ? 'Remission (under 150)' : cdai <= 220 ? 'Mildly active (150–220)' : cdai <= 450 ? 'Moderately active (220–450)' : 'Severely active (over 450)', rows: { parts: `Stools ${f0(2 * i.stools)}, pain ${f0(5 * i.pain)}, well-being ${f0(7 * i.wellbeing)}, complications ${20 * complications}, haematocrit ${f0(hctTerm)}, weight ${f0(weightTerm)}`, source: 'Best et al., Gastroenterology 1976' } };
    },

    // Geriatric -----------------------------------------------------------------------------------
    ost: (i) => {
        const kg = kgOf(i.weight);

        if (!ok(kg, i.age) || kg <= 0) {
            return need('Enter weight and age.');
        }

        const score = Math.trunc(0.2 * (kg - i.age));

        return { value: String(score), label: 'Osteoporosis Self-assessment Tool (OST)', sub: score < 2 ? 'Under 2: higher risk; a bone density (DXA) scan is often advised' : '2 or more: lower risk of osteoporosis', rows: { osta: score < -4 ? 'High risk (under −4, OSTA)' : score <= -1 ? 'Moderate risk (−4 to −1, OSTA)' : 'Low risk (over −1, OSTA)', formula: 'OST = 0.2 × (weight kg − age), decimals dropped', note: 'USPSTF (2025) recommends bone density screening for women 65 and over, and younger women at raised risk; FRAX is another tool' } };
    },

    // Epidemiology ----------------------------------------------------------------------------------
    incidence: (i) => {
        const per = Number(i.per) || 1000;

        if (!ok(i.cases, i.population) || i.population <= 0) {
            return need('Enter new cases and the population or person-time.');
        }

        const rate = (i.cases / i.population) * per;
        const rateMode = i.mode === 'rate';

        return { value: `${f2(rate)} per ${f0(per)}${rateMode ? ' person-years' : ''}`, label: rateMode ? 'Incidence rate' : 'Cumulative incidence (risk)', sub: rateMode ? `${f0(i.cases)} new cases in ${f0(i.population)} person-years` : `${f0(i.cases)} new cases among ${f0(i.population)} people at risk${ok(i.years) && i.years > 0 ? ` over ${f1(i.years)} years` : ''}`, rows: { percent: rateMode ? 'A rate, not a proportion' : `${f2((100 * i.cases) / i.population)}%`, formula: rateMode ? 'rate = new cases ÷ person-time' : 'risk = new cases ÷ population at risk at the start' } };
    },

    mortality: (i) => {
        const per = Number(i.per) || 100000;

        if (i.mode === 'cfr') {
            if (!ok(i.deaths, i.cases) || i.cases <= 0) {
                return need('Enter deaths and confirmed cases.');
            }

            return { value: `${f2((100 * i.deaths) / i.cases)}%`, label: 'Case fatality rate', sub: `${f0(i.deaths)} deaths among ${f0(i.cases)} cases`, rows: { crude: 'Not a population rate', method: 'CFR = deaths ÷ cases × 100', note: 'CFR depends on how many mild cases are counted and on deaths still to come' } };
        }

        if (i.mode === 'adjusted') {
            const rows = parseRows(i.groups).map(([, deaths, pop]) => [Number(deaths), Number(pop)]);

            if (rows.length !== STANDARD_2000.length || rows.some(([d, p]) => !ok(d, p) || p <= 0)) {
                return need('Enter deaths and population for all 11 age groups.');
            }

            const adjusted = rows.reduce((sum, [d, p], n) => sum + (d / p) * (STANDARD_2000[n][1] / 1e6), 0) * per;
            const crude = (rows.reduce((s, [d]) => s + d, 0) / rows.reduce((s, [, p]) => s + p, 0)) * per;

            return { value: `${f1(adjusted)} per ${f0(per)}`, label: 'Age-adjusted death rate', sub: `Crude rate ${f1(crude)} per ${f0(per)}`, rows: { crude: `${f1(crude)} per ${f0(per)}`, method: 'Direct standardisation to the US 2000 standard population (11 age groups)', note: 'Compare age-adjusted rates only when they use the same standard population' }, grids: { groups: { columns: ['Rate', 'Weight'], rows: rows.map(([d, p], n) => ({ header: STANDARD_2000[n][0], cells: [`${f1((d / p) * per)}`, `${(STANDARD_2000[n][1] / 1e4).toFixed(2)}%`] })) } } };
        }

        if (!ok(i.deaths, i.population) || i.population <= 0) {
            return need('Enter deaths and population.');
        }

        return { value: `${f1((i.deaths / i.population) * per)} per ${f0(per)}`, label: 'Crude death rate', sub: `${f0(i.deaths)} deaths in a population of ${f0(i.population)}`, rows: { crude: `${f1((i.deaths / i.population) * per)} per ${f0(per)}`, method: 'Crude rate = deaths ÷ population', note: 'Crude rates depend heavily on age structure; use age adjustment to compare populations' } };
    },

    nnt: (i) => {
        if (!ok(i.ce, i.cn, i.te, i.tn) || i.cn <= 0 || i.tn <= 0) {
            return need('Enter events and totals in both groups.');
        }

        const cer = i.ce / i.cn;
        const eer = i.te / i.tn;
        const arr = cer - eer;
        const se = Math.sqrt((cer * (1 - cer)) / i.cn + (eer * (1 - eer)) / i.tn);
        const lo = arr - 1.96 * se;
        const hi = arr + 1.96 * se;
        const rr = eer / cer;
        const or = (eer / (1 - eer)) / (cer / (1 - cer));
        const harm = arr < 0;
        const n = arr === 0 ? Infinity : Math.ceil(1 / Math.abs(arr));
        const ci = lo > 0 || hi < 0 ? `${f0(Math.ceil(1 / Math.abs(hi)))} to ${f0(Math.ceil(1 / Math.abs(lo)))}` : 'The 95% CI for the difference includes zero: not statistically significant';

        return {
            value: Number.isFinite(n) ? `${harm ? 'NNH' : 'NNT'} ${f0(n)}` : 'No difference',
            label: harm ? 'Number needed to harm' : 'Number needed to treat',
            sub: `${harm ? 'Absolute risk increase' : 'Absolute risk reduction'} ${pct(Math.abs(arr))} (control ${pct(cer)}, treatment ${pct(eer)})`,
            rows: { arr: `${pct(arr)} (95% CI ${pct(lo)} to ${pct(hi)})`, ci, rr: `${f2(rr)} relative risk; relative risk reduction ${pct(1 - rr)}`, or: `${f2(or)} odds ratio`, method: 'NNT = 1 ÷ ARR, rounded up; CI by Altman (BMJ 1998)' },
        };
    },

    vaccine: (i) => {
        if (!ok(i.vc, i.vn, i.uc, i.un) || i.vn <= 0 || i.un <= 0 || i.uc <= 0) {
            return need('Enter cases and totals for vaccinated and unvaccinated groups.');
        }

        const rr = (i.vc / i.vn) / (i.uc / i.un);
        const ve = 1 - rr;
        const se = i.vc > 0 ? Math.sqrt(1 / i.vc - 1 / i.vn + 1 / i.uc - 1 / i.un) : NaN;

        return { value: pct(ve), label: 'Vaccine efficacy', sub: Number.isFinite(se) ? `95% CI ${pct(1 - Math.exp(Math.log(rr) + 1.96 * se))} to ${pct(1 - Math.exp(Math.log(rr) - 1.96 * se))}` : 'No cases among the vaccinated: the CI needs an exact method', rows: { rr: `${f2(rr)} relative risk`, attack: `Attack rates ${pct(i.vc / i.vn, 2)} vaccinated, ${pct(i.uc / i.un, 2)} unvaccinated`, formula: 'VE = 1 − (attack rate vaccinated ÷ attack rate unvaccinated)' } };
    },

    sir: (i) => {
        if (!ok(i.population, i.r0, i.days, i.initial) || i.population <= 0 || i.days <= 0 || i.r0 <= 0 || i.initial <= 0) {
            return need('Enter population, R₀, infectious days and initial cases.');
        }

        const horizon = ok(i.horizon) && i.horizon > 10 ? Math.min(i.horizon, 730) : 365;
        const { daily } = sir({ r0: i.r0, days: i.days, i0: i.initial / i.population, horizon });
        const peak = daily.reduce((a, b) => (b[1] > a[1] ? b : a));
        const z = finalSize(i.r0);

        return {
            value: i.r0 > 1 ? `${f0(z * i.population)} people` : 'No epidemic',
            label: 'Total infected by the end (final size)',
            sub: i.r0 > 1 ? `${pct(z)} of the population; peak of ${f0(peak[1] * i.population)} infected at once on day ${peak[0]}` : 'With R₀ of 1 or less, each case infects fewer than one other and the outbreak fades',
            rows: { herd: i.r0 > 1 ? `${pct(1 - 1 / i.r0)} immune stops growth (1 − 1 ÷ R₀)` : 'Not needed', peak: `${f0(peak[1] * i.population)} on day ${peak[0]}`, beta: `β = ${f2(i.r0 / i.days)} a day, γ = ${f2(1 / i.days)} a day`, note: 'A teaching model: homogeneous mixing, no births, deaths, interventions or waning immunity' },
            plots: { curve: { series: daily.filter(([d]) => d % 2 === 0).map(([d, v]) => [d, Math.round(v * i.population)]), xLabel: 'Day', yLabel: 'People infected', markers: [{ x: peak[0], y: Math.round(peak[1] * i.population), label: 'Peak' }] } },
        };
    },

    sanitizer: (i) => {
        if (!ok(i.litres) || i.litres <= 0) {
            return need('Enter the batch size in litres.');
        }

        const k = i.litres / 10;
        const iso = i.formula === 'isopropanol';
        const alcohol = iso ? 7515 : 8333;

        return {
            value: `${f0(alcohol * k)} mL ${iso ? 'isopropyl alcohol 99.8%' : 'ethanol 96%'}`,
            label: `WHO formulation ${iso ? 'II' : 'I'} for ${f1(i.litres)} L`,
            sub: `Final ${iso ? 'isopropyl alcohol 75%' : 'ethanol 80%'} v/v, glycerol 1.45%, hydrogen peroxide 0.125%`,
            rows: { peroxide: `${f0(417 * k)} mL hydrogen peroxide 3%`, glycerol: `${f0(145 * k)} mL glycerol 98%`, water: `Top up to ${f1(i.litres)} L with distilled or boiled cooled water`, quarantine: 'Leave 72 hours before use so the peroxide kills any spores; alcohol is flammable', source: 'WHO Guide to Local Production of hand-rub formulations (2010)' },
            grids: { recipe: { columns: ['Amount'], rows: [[iso ? 'Isopropyl alcohol 99.8%' : 'Ethanol 96%', alcohol * k], ['Hydrogen peroxide 3%', 417 * k], ['Glycerol 98%', 145 * k], ['Water (to volume)', i.litres * 1000 - (alcohol + 417 + 145) * k]].map(([name, ml]) => ({ header: name, cells: [`${f0(ml)} mL`] })) } },
        };
    },

    // Radiology ---------------------------------------------------------------------------------------
    bed: (i) => {
        const ab = i.ab === 'custom' ? i.ab_custom : Number(i.ab);

        if (!ok(i.dose, i.fractions, ab) || ab <= 0) {
            return need('Enter dose per fraction, number of fractions and α/β.');
        }

        const total = i.dose * i.fractions;
        const bed = total * (1 + i.dose / ab);
        const eqd2 = bed / (1 + 2 / ab);

        return { value: `${f1(bed)} Gy`, label: `BED (α/β ${ab})`, sub: `EQD2 ${f1(eqd2)} Gy; total physical dose ${f1(total)} Gy`, rows: { eqd2: `${f1(eqd2)} Gy`, formula: 'BED = n d (1 + d ÷ α/β); EQD2 = BED ÷ (1 + 2 ÷ α/β)', note: 'Linear-quadratic model without repopulation or time factors (Fowler 1989)' } };
    },

    medical_radiation: (i) => {
        const items = parseRows(i.exams).map(([exam, count]) => ({ exam, count: Number(count) || 1, dose: EXAMS[exam] })).filter((x) => x.exam);
        const unknown = items.filter((x) => x.dose === undefined);
        const known = items.filter((x) => x.dose !== undefined);

        if (!known.length) {
            return need('Add imaging tests from the list.');
        }

        const total = known.reduce((s, x) => s + x.dose * x.count, 0);

        return {
            value: `${f2(total)} mSv`,
            label: 'Total effective dose',
            sub: `About ${total / US_BACKGROUND >= 1 ? `${f1(total / US_BACKGROUND)} years` : `${f0((total / US_BACKGROUND) * 365)} days`} of natural background radiation (3.1 mSv a year in the US)`,
            rows: { background: `${f0((total / US_BACKGROUND) * 365)} days of background`, unknown: unknown.length ? `Not recognised: ${unknown.map((x) => x.exam).join(', ')}` : 'All tests recognised', note: 'Typical adult doses; your dose depends on the scanner and your size. The benefit of a needed test usually far outweighs the small risk', source: 'Mettler et al., Radiology 2008; NCRP Report 160' },
            grids: { exams: { columns: ['Each', 'Total'], rows: known.map((x) => ({ header: `${x.exam} × ${x.count}`, cells: [`${x.dose} mSv`, `${f2(x.dose * x.count)} mSv`] })) } },
        };
    },

    radiation_dose: (i) => {
        const feet = i.elevation_unit === 'm' ? or0(i.elevation) * 3.28084 : or0(i.elevation);
        const cosmic = ELEVATION.find(([upTo]) => feet < upTo)[1] / 100;
        const radonLevel = i.radon_unit === 'bq' ? or0(i.radon) / 37 : or0(i.radon);
        const radon = ok(i.radon) && i.radon > 0 ? 2.28 * (radonLevel / 1.3) : 2.28;
        const flights = or0(i.flight_hours) * 0.005;
        const medical = or0(i.xrays) * EXAMS['Chest X-ray'] + or0(i.ct) * 7;
        const items = [['Radon and thoron at home', radon], ['Cosmic (elevation)', cosmic], ['Terrestrial (ground)', 0.21], ['Internal (food, water, body potassium)', 0.29], ['Air travel', flights], ['Medical imaging', medical]];
        const total = items.reduce((s, [, v]) => s + v, 0);

        return {
            value: `${f2(total)} mSv a year`,
            label: 'Estimated annual radiation dose',
            sub: `The US average is about 6.2 mSv (3.1 natural + 3.1 medical, NCRP 2009)`,
            rows: { radon: radonLevel >= 4 ? `Radon ${f1(radonLevel)} pCi/L is at or above the EPA action level of 4 pCi/L: consider fixing your home` : `Radon ${ok(i.radon) && i.radon > 0 ? `${f1(radonLevel)} pCi/L` : 'at the US average (1.3 pCi/L)'}`, note: 'Average dose factors from NCRP Report 160 and the ANS dose chart; individual doses vary', source: 'NCRP Report 160 (2009); American Nuclear Society; US EPA' },
            grids: { sources: { columns: ['mSv a year'], rows: items.map(([name, v]) => ({ header: name, cells: [f2(v)] })) } },
        };
    },

    tirads: (i) => {
        const composition = Number(i.composition) || 0;
        const spongiform = i.composition === 'spongiform';
        const echo = spongiform ? 0 : Number(i.echogenicity) || 0;
        const shape = spongiform ? 0 : Number(i.shape) || 0;
        const margin = spongiform ? 0 : Number(i.margin) || 0;
        const foci = spongiform ? 0 : (i.macro ? 1 : 0) + (i.rim ? 2 : 0) + (i.punctate ? 3 : 0);
        const points = (spongiform ? 0 : composition) + echo + shape + margin + foci;
        const level = points >= 7 ? 5 : points >= 4 ? 4 : points === 3 ? 3 : points === 2 ? 2 : 1;
        const rule = { 1: [null, null, 'Benign: no FNA'], 2: [null, null, 'Not suspicious: no FNA'], 3: [2.5, 1.5, 'Mildly suspicious'], 4: [1.5, 1.0, 'Moderately suspicious'], 5: [1.0, 0.5, 'Highly suspicious'] }[level];
        const size = i.size;
        const action = !rule[0] ? 'No FNA or follow-up needed' : !ok(size) ? `FNA if ${rule[0]} cm or more; follow-up if ${rule[1]} cm or more` : size >= rule[0] ? `FNA advised (${f1(size)} cm ≥ ${rule[0]} cm)` : size >= rule[1] ? `Ultrasound follow-up advised (${f1(size)} cm ≥ ${rule[1]} cm)` : 'No FNA or follow-up for this size';

        return { value: `TR${level}`, label: `ACR TI-RADS: ${rule[2].toLowerCase()}`, sub: `${points} points. ${action}`, rows: { points: String(points), action, thresholds: rule[0] ? `FNA from ${rule[0]} cm, follow-up from ${rule[1]} cm` : 'None', source: 'Tessler et al., J Am Coll Radiol 2017 (ACR TI-RADS)' } };
    },

    // Other ---------------------------------------------------------------------------------------
    basdai: (i) => {
        const q = [i.q1, i.q2, i.q3, i.q4, i.q5, i.q6];

        if (!q.every(Number.isFinite)) {
            return need('Answer all six questions (0–10).');
        }

        const score = (q[0] + q[1] + q[2] + q[3] + (q[4] + q[5]) / 2) / 5;

        return { value: f1(score), unit: 'of 10', label: 'BASDAI', sub: score >= 4 ? '4 or more: active disease (often used to consider treatment changes)' : 'Under 4: lower disease activity', rows: { formula: '(Q1 + Q2 + Q3 + Q4 + (Q5 + Q6) ÷ 2) ÷ 5', source: 'Garrett et al., J Rheumatol 1994' } };
    },

    easi: (i) => {
        const child = i.age_group === 'child';
        const weights = child ? { head: 0.2, upper: 0.2, trunk: 0.3, lower: 0.3 } : { head: 0.1, upper: 0.2, trunk: 0.3, lower: 0.4 };
        const regions = [['head', 'Head and neck'], ['upper', 'Upper limbs'], ['trunk', 'Trunk'], ['lower', 'Lower limbs']].map(([key, name]) => {
            const signs = ['ery', 'ind', 'exc', 'lic'].reduce((s, sign) => s + (Number(i[`${key}_${sign}`]) || 0), 0);
            const area = Number(i[`${key}_area`]) || 0;

            return { name, signs, area, score: signs * area * weights[key] };
        });
        const total = regions.reduce((s, r) => s + r.score, 0);
        const band = total === 0 ? 'Clear (0)' : total <= 1 ? 'Almost clear (0.1–1.0)' : total <= 7 ? 'Mild (1.1–7.0)' : total <= 21 ? 'Moderate (7.1–21.0)' : total <= 50 ? 'Severe (21.1–50.0)' : 'Very severe (50.1–72.0)';

        return { value: f1(total), unit: 'of 72', label: 'EASI', sub: band, rows: { band, multipliers: child ? 'Children 0–7: head 0.2, arms 0.2, trunk 0.3, legs 0.3' : 'Age 8 and over: head 0.1, arms 0.2, trunk 0.3, legs 0.4', source: 'Hanifin et al., Exp Dermatol 2001; bands from Leshem et al. 2015' }, grids: { regions: { columns: ['Signs', 'Area', 'Score'], rows: regions.map((r) => ({ header: r.name, cells: [String(r.signs), `${r.area} (${AREA[r.area]}%+)`, f1(r.score)] })) } } };
    },

    free_t: (i) => {
        const ttNgdl = lab(i, 'tt', 'testosterone');
        const alb = lab(i, 'albumin', 'albumin');

        if (!ok(ttNgdl, i.shbg, alb) || ttNgdl <= 0 || i.shbg < 0) {
            return need('Enter total testosterone, SHBG and albumin.');
        }

        const tt = (ttNgdl / 28.84) * 1e-9;
        const shbg = i.shbg * 1e-9;
        const albMol = (alb * 10) / 69000;
        const n = 1 + 3.6e4 * albMol;
        const a = n * 1e9;
        const b = n + 1e9 * (shbg - tt);
        const ft = (-b + Math.sqrt(b * b + 4 * a * tt)) / (2 * a);
        const bio = ft * n;

        return { value: `${f0(ft * 1e12)} pmol/L`, label: 'Calculated free testosterone', sub: `${f2((ft * 1e9) * 28.84)} ng/dL; ${pct(ft / tt, 2)} of total`, rows: { ngdl: `${f2(ft * 1e9 * 28.84)} ng/dL (${f0(ft * 1e9 * 288.4)} pg/mL)`, bio: `${f2(bio * 1e9)} nmol/L bioavailable (${f0(bio * 1e9 * 28.84)} ng/dL, ${pct(bio / tt)})`, note: 'Compare with the reference range of the lab and method; a single low value should be repeated in the morning', source: 'Vermeulen et al., J Clin Endocrinol Metab 1999' } };
    },

    pe2: (i) => {
        const p = lab(i, 'prog', 'progesterone');
        const e = lab(i, 'e2', 'estradiol');

        if (!ok(p, e) || e <= 0) {
            return need('Enter progesterone and estradiol.');
        }

        return { value: f0((p * 1000) / e), label: 'Progesterone-to-estradiol ratio', sub: `Both in pg/mL; molar ratio ${f0((p * 3.18) / (e * 3.671 / 1000))}`, rows: { conventional: `${f2(p / e)} (progesterone ng/mL ÷ estradiol pg/mL)`, molar: `${f0((p * 3.18) / ((e * 3.671) / 1000))} (nmol/L ÷ nmol/L)`, note: 'There is no validated cut-off for this ratio, so no diagnosis is shown; it varies widely through the cycle' } };
    },

    te2: (i) => {
        const t = lab(i, 'tt', 'testosterone');
        const e = lab(i, 'e2', 'estradiol');

        if (!ok(t, e) || e <= 0) {
            return need('Enter testosterone and estradiol.');
        }

        return { value: f1(t / e), label: 'Testosterone-to-estradiol ratio', sub: `Testosterone ng/dL ÷ estradiol pg/mL; molar ratio ${f0((t / 28.84) / ((e * 3.671) / 1000))}`, rows: { molar: `${f0((t / 28.84) / ((e * 3.671) / 1000))} (nmol/L ÷ nmol/L)`, note: 'Reported in studies of male infertility and ageing, but with no agreed reference range; interpret with a specialist' } };
    },

    // Dosage schedules ----------------------------------------------------------------------------
    half_life: (i) => {
        if (!ok(i.half, i.amount) || i.half <= 0 || i.amount <= 0) {
            return need('Enter the half-life and the starting amount.');
        }

        const repeat = i.mode === 'repeat';
        const tau = or0(i.interval);
        const count = repeat ? Math.max(1, Math.round(or0(i.doses))) : 1;
        const at = (t) => {
            let sum = 0;

            for (let n = 0; n < count; n += 1) {
                const since = t - n * tau;

                if (since >= 0) {
                    sum += i.amount * 0.5 ** (since / i.half);
                }
            }

            return sum;
        };
        const t = or0(i.time);
        const end = Math.max(t, (count - 1) * tau + 5 * i.half);
        const series = Array.from({ length: 121 }, (_, n) => [Number(((end * n) / 120).toFixed(2)), Number(at((end * n) / 120).toPrecision(4))]);
        const accumulation = repeat && tau > 0 ? 1 / (1 - 0.5 ** (tau / i.half)) : NaN;

        return {
            value: `${Number(at(t).toPrecision(3))} ${i.unit || 'mg'}`,
            label: `Amount left after ${f1(t)} hours`,
            sub: `${pct(at(t) / (i.amount * count))} of the total given; about ${f1(5 * i.half)} hours (5 half-lives) to clear 97%`,
            rows: { five: `${f1(4.32 * i.half)} hours to fall below 5% of a single dose`, steady: repeat ? `Steady state after about ${f1(5 * i.half)} hours; peak builds up to about ${f1(accumulation)} × a single dose` : 'Single dose', note: 'Assumes first-order elimination; it does not tell you when or how much to take' },
            grids: { halves: { columns: ['Time', 'Left'], rows: [0, 1, 2, 3, 4, 5].map((h) => ({ header: `${h} half-li${h === 1 ? 'fe' : 'ves'}`, cells: [`${f1(h * i.half)} h`, pct(0.5 ** h)] })) } },
            plots: { curve: { series, xLabel: 'Hours', yLabel: `Amount in the body (${i.unit || 'mg'})`, markers: [{ x: t, y: Number(at(t).toPrecision(4)), label: 'Now' }] } },
        };
    },

    med_times: (i) => {
        const parse = (text) => {
            const m = String(text ?? '').match(/^(\d{1,2}):(\d{2})$/);

            return m ? Number(m[1]) * 60 + Number(m[2]) : NaN;
        };
        const clock = (m) => {
            const minutes = ((Math.round(m) % 1440) + 1440) % 1440;
            const h = Math.floor(minutes / 60);

            return `${String(h).padStart(2, '0')}:${String(minutes % 60).padStart(2, '0')} (${((h + 11) % 12) + 1}:${String(minutes % 60).padStart(2, '0')} ${h < 12 ? 'am' : 'pm'})`;
        };
        const times = Number(i.times) || 3;
        let doses;

        if (i.mode === 'hourly') {
            const first = parse(i.first);

            if (!Number.isFinite(first)) {
                return need('Enter the time of the first dose.');
            }

            doses = Array.from({ length: times }, (_, n) => first + (n * 1440) / times);
        } else {
            const wake = parse(i.wake);
            let bed = parse(i.bed);

            if (!ok(wake, bed)) {
                return need('Enter when you wake up and go to bed.');
            }

            if (bed <= wake) {
                bed += 1440;
            }

            doses = Array.from({ length: times }, (_, n) => wake + ((bed - wake) * n) / (times - 1));
        }

        const gap = i.mode === 'hourly' ? 1440 / times : (doses[1] ?? doses[0]) - doses[0];

        return {
            value: doses.map((d) => clock(d).split(' ')[0]).join(', '),
            label: `${times} times a day`,
            sub: `${i.mode === 'hourly' ? 'Every' : 'About every'} ${f1(gap / 60)} hours${i.mode === 'hourly' ? ' around the clock' : ' while awake'}`,
            rows: { note: 'Follow the label or the pharmacist if it gives exact times or says “with food” or “8-hourly”; ask if a dose is missed', gap: `${f1(gap / 60)} hours between doses` },
            grids: { schedule: { columns: ['Time'], rows: doses.map((d, n) => ({ header: `Dose ${n + 1}`, cells: [clock(d)] })) } },
        };
    },

    refill: (i) => {
        const filled = parseDate(i.filled);
        const today = parseDate(i.today);

        if (!filled || !ok(i.quantity, i.per_day) || i.per_day <= 0) {
            return need('Enter the fill date, quantity and how many you use a day.');
        }

        const supply = Math.floor(i.quantity / i.per_day);
        const share = (Number(i.window) || 80) / 100;
        const runOut = addDays(filled, supply);
        const earliest = addDays(filled, Math.ceil(supply * share));
        const left = today ? toDays(runOut) - toDays(today) : NaN;

        return {
            value: shortDate(runOut),
            label: 'Runs out on',
            sub: `${supply}-day supply; earliest refill about ${shortDate(earliest)} (${f0(share * 100)}% used)`,
            rows: { supply: `${supply} days`, earliest: shortDate(earliest), left: Number.isFinite(left) ? (left >= 0 ? `${f0(left)} days left (${f0(Math.max(0, i.quantity - i.per_day * (toDays(today) - toDays(filled))))} left)` : `Ran out ${f0(-left)} days ago`) : '—', note: 'Refill rules vary by insurer, state and medicine (controlled drugs are stricter); check with your pharmacy' },
        };
    },
};

export default defineTools(handlers);
