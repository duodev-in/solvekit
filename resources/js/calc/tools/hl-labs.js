import { defineTools } from '../engines/formula.js';
import { addDays, parseDate, shortDate, toDays } from '../everyday/dates.js';
import { idealWeights } from '../health/body.js';
import { toConventional } from '../health/labs.js';
import { parseRows } from '../rows-editor.js';

/**
 * Kidney, urine, electrolyte, acid–base and blood formulas. Lab values with a unit menu are converted to conventional
 * US units first ({name}_unit, health/labs.js); sodium, potassium, chloride and bicarbonate are in mmol/L (= mEq/L).
 * Height arrives in metres, mass in grams. Every result is a calculation for education, not a treatment order.
 */
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
const f0 = (x) => (Number.isFinite(x) ? Math.round(x).toLocaleString('en-US') : '—');
const f1 = (x) => (Number.isFinite(x) ? x.toFixed(1) : '—');
const f2 = (x) => (Number.isFinite(x) ? x.toFixed(2) : '—');
const kgOf = (g) => g / 1000;
const lab = (i, name, analyte) => toConventional(i[name], analyte, i[`${name}_unit`]);
const need = (message) => ({ empty: message });
const female = (i) => i.sex === 'female';

/** CKD-EPI 2021 (race-free) creatinine, 2012 cystatin C and 2021 creatinine–cystatin equations, mL/min/1.73 m². */
export const egfr = {
    creatinine: (scr, age, isFemale) => {
        const k = isFemale ? 0.7 : 0.9;
        const a = isFemale ? -0.241 : -0.302;

        return 142 * Math.min(scr / k, 1) ** a * Math.max(scr / k, 1) ** -1.2 * 0.9938 ** age * (isFemale ? 1.012 : 1);
    },
    cystatin: (scys, age, isFemale) => 133 * Math.min(scys / 0.8, 1) ** -0.499 * Math.max(scys / 0.8, 1) ** -1.328 * 0.996 ** age * (isFemale ? 0.932 : 1),
    combined: (scr, scys, age, isFemale) => {
        const k = isFemale ? 0.7 : 0.9;
        const a = isFemale ? -0.219 : -0.144;

        return 135 * Math.min(scr / k, 1) ** a * Math.max(scr / k, 1) ** -0.544 * Math.min(scys / 0.8, 1) ** -0.323 * Math.max(scys / 0.8, 1) ** -0.778 * 0.9961 ** age * (isFemale ? 0.963 : 1);
    },
    mdrd: (scr, age, isFemale) => 175 * scr ** -1.154 * age ** -0.203 * (isFemale ? 0.742 : 1),
};

export function ckdStage(gfr) {
    return gfr >= 90 ? 'G1: normal or high (90 or more)' : gfr >= 60 ? 'G2: mildly decreased (60–89)' : gfr >= 45 ? 'G3a: mildly to moderately decreased (45–59)' : gfr >= 30 ? 'G3b: moderately to severely decreased (30–44)' : gfr >= 15 ? 'G4: severely decreased (15–29)' : 'G5: kidney failure (under 15)';
}

/** Total body water fraction by age and sex (Adrogué–Madias). */
function tbwFraction(i) {
    if (i.group === 'child') {
        return 0.6;
    }

    const older = or0(i.age) >= 65;

    return female(i) ? (older ? 0.45 : 0.5) : older ? 0.5 : 0.6;
}

/** Nadler et al. (1962) blood volume, litres. */
export function nadler(m, kg, isFemale) {
    return isFemale ? 0.3561 * m ** 3 + 0.03308 * kg + 0.1833 : 0.3669 * m ** 3 + 0.03219 * kg + 0.6041;
}

const KFRE = { na: [0.975, 0.924], other: [0.9832, 0.9365] };
const INFUSATES = { hypertonic: ['3% saline', 513, 0], normal: ['0.9% saline', 154, 0], ringer: ['Lactated Ringer\'s', 130, 4], half: ['0.45% saline', 77, 0], quarter: ['0.2% saline in 5% dextrose', 34, 0], d5w: ['5% dextrose in water', 0, 0] };
const DONATION = {
    us: { whole: ['Whole blood', 56], power: ['Power Red (double red cells)', 112], platelets: ['Platelets (apheresis)', 7], plasma: ['Plasma (AB Elite)', 28] },
    uk: { whole: ['Whole blood', null] },
    in: { whole: ['Whole blood', null] },
};

function ancResult(i) {
    const wbc = i.wbc;
    const pct = or0(i.segs) + or0(i.bands);

    if (!ok(wbc) || wbc <= 0 || pct <= 0) {
        return need('Enter the white cell count and neutrophil percentage.');
    }

    const anc = wbc * pct * 10;
    const grade = anc >= 1500 ? 'Normal (1,500/µL or more)' : anc >= 1000 ? 'Mild neutropenia (1,000–1,499)' : anc >= 500 ? 'Moderate neutropenia (500–999)' : 'Severe neutropenia (under 500): high infection risk';

    return { value: `${f0(anc)}/µL`, label: 'Absolute neutrophil count', sub: grade, rows: { si: `${f2(anc / 1000)} × 10⁹/L`, grade, note: 'People of African or Middle Eastern ancestry may have lower counts without infection risk (Duffy-null phenotype)', formula: `ANC = WBC × (segs + bands) % = ${f1(wbc)} × ${f0(pct)}%` } };
}

function dripResult(i) {
    const minutes = or0(i.hours) * 60 + or0(i.minutes);
    const factor = Number(i.factor) || 20;

    if (!ok(i.volume) || i.volume <= 0 || minutes <= 0) {
        return need('Enter the volume and the infusion time.');
    }

    const gtt = (i.volume * factor) / minutes;

    return { value: `${f0(gtt)} drops/min`, label: 'Drip rate', sub: `${f1(gtt)} drops a minute (one every ${f1(60 / gtt)} seconds) at ${factor} drops/mL`, rows: { mlh: `${f0((i.volume / minutes) * 60)} mL/h`, seconds: `${f1(60 / gtt)} s per drop`, per15: `${f0(gtt / 4)} drops in 15 seconds`, formula: 'drops/min = volume (mL) × drop factor ÷ minutes' } };
}

function osmResult(i) {
    const glucose = lab(i, 'glucose', 'glucose');
    const bun = lab(i, 'bun', 'bun');

    if (!ok(i.na, glucose, bun)) {
        return need('Enter sodium, glucose and urea.');
    }

    const calc = 2 * i.na + glucose / 18 + bun / 2.8 + (ok(i.ethanol) ? i.ethanol / 3.7 : 0);
    const gap = ok(i.measured) ? i.measured - calc : NaN;

    return { value: `${f0(calc)} mOsm/kg`, label: 'Calculated osmolality', sub: calc < 275 ? 'Below the usual 275–295' : calc > 295 ? 'Above the usual 275–295' : 'Within the usual 275–295', rows: { gap: Number.isFinite(gap) ? `${f0(gap)} mOsm/kg (${gap > 10 ? 'raised: unmeasured osmoles such as toxic alcohols are possible' : 'normal, under 10'})` : 'Enter the measured osmolality for the gap', formula: '2 × Na + glucose ÷ 18 + BUN ÷ 2.8 (mg/dL)', ethanol: ok(i.ethanol) ? `+ ${f0(i.ethanol / 3.7)} from ethanol` : 'Not included' } };
}

export const handlers = {
    // Urology and nephrology -----------------------------------------------------------------------
    adrenal_washout: (i) => {
        if (!ok(i.unenhanced, i.enhanced, i.delayed) || i.enhanced <= i.unenhanced) {
            return need('Enter unenhanced, enhanced (portal venous) and 15-minute delayed attenuation in HU.');
        }

        const absolute = (100 * (i.enhanced - i.delayed)) / (i.enhanced - i.unenhanced);
        const relative = (100 * (i.enhanced - i.delayed)) / i.enhanced;
        const adenoma = absolute >= 60 || relative >= 40;

        return { value: `${f0(absolute)}%`, label: 'Absolute washout', sub: adenoma ? 'Consistent with an adenoma (absolute 60% or more, or relative 40% or more)' : 'Not typical of an adenoma; further assessment is usually advised', rows: { relative: `${f0(relative)}% (40% or more suggests adenoma)`, unenhanced: i.unenhanced <= 10 ? '10 HU or less on the unenhanced scan: lipid-rich adenoma' : 'Over 10 HU unenhanced', source: 'Caoili et al., Radiology 2002' } };
    },

    acr: (i) => {
        const cr = lab(i, 'ucr', 'ucreat');

        if (!ok(i.albumin, cr) || cr <= 0) {
            return need('Enter urine albumin and urine creatinine.');
        }

        const mgG = (i.albumin / cr) * 100;
        const stage = mgG < 30 ? 'A1: normal to mildly increased (under 30 mg/g)' : mgG <= 300 ? 'A2: moderately increased (30–300 mg/g)' : 'A3: severely increased (over 300 mg/g)';

        return { value: `${f0(mgG)} mg/g`, label: 'Albumin-to-creatinine ratio', sub: stage, rows: { mmol: `${f1(mgG / 8.84)} mg/mmol`, stage, confirm: 'Confirm with 2 of 3 samples over 3–6 months; exercise, infection and fever raise albumin', source: 'KDIGO 2024 CKD guideline' } };
    },

    bladder: (i) => {
        if (!ok(i.length, i.width, i.height)) {
            return need('Enter the three bladder dimensions in cm.');
        }

        const k = Number(i.coefficient) || 0.52;
        const v = i.length * i.width * i.height * k;

        return { value: `${f0(v)} mL`, label: 'Bladder volume', sub: i.context === 'pvr' ? (v < 50 ? 'Post-void residual under 50 mL: normal emptying' : v < 200 ? 'Post-void residual 50–199 mL: raised; repeat and review' : 'Post-void residual 200 mL or more: incomplete emptying') : `${k} × L × W × H`, rows: { formula: `V = L × W × H × ${k}`, note: 'Ultrasound estimates are within about 10–20% of catheter volumes' } };
    },

    bun_cr: (i) => {
        const bun = lab(i, 'bun', 'bun');
        const cr = lab(i, 'cr', 'creatinine');

        if (!ok(bun, cr) || cr <= 0) {
            return need('Enter urea (BUN) and creatinine.');
        }

        const ratio = bun / cr;
        const si = ((bun / 2.801) / (cr * 88.42)) * 1000;

        return { value: f0(ratio), label: 'BUN-to-creatinine ratio', sub: ratio > 20 ? 'Over 20: suggests a pre-renal cause (dehydration, bleeding, heart failure) or high protein load' : ratio < 10 ? 'Under 10: seen with intrinsic kidney injury, liver disease or low protein intake' : '10–20: typical, or intrinsic kidney disease', rows: { si: `${f0(si)} (urea mmol/L ÷ creatinine µmol/L × 1,000; over 100 suggests pre-renal)`, note: 'The ratio is a clue, not a diagnosis; gastrointestinal bleeding and steroids also raise BUN' } };
    },

    crcl: (i) => {
        const kg = kgOf(i.weight);
        const cr = lab(i, 'cr', 'creatinine');
        const cm = i.height * 100;

        if (!ok(kg, cr, i.age) || cr <= 0 || kg <= 0) {
            return need('Enter age, weight, sex and creatinine.');
        }

        const cg = (w) => ((140 - i.age) * w) / (72 * cr) * (female(i) ? 0.85 : 1);
        const ibw = ok(cm) && cm > 120 ? idealWeights(cm, female(i) ? 'female' : 'male').devine : NaN;
        const adjusted = Number.isFinite(ibw) ? ibw + 0.4 * (kg - ibw) : NaN;
        const which = !Number.isFinite(ibw) ? 'actual' : kg < ibw ? 'actual' : kg > 1.2 * ibw ? 'adjusted' : 'ideal';
        const pick = { actual: cg(kg), ideal: cg(ibw), adjusted: cg(adjusted) }[which];

        return {
            value: `${f0(pick)} mL/min`,
            label: 'Creatinine clearance (Cockcroft–Gault)',
            sub: `Using ${which} body weight${which === 'adjusted' ? ' (actual weight over 120% of ideal)' : which === 'actual' && Number.isFinite(ibw) ? ' (below ideal weight)' : ''}`,
            rows: { formula: '(140 − age) × weight ÷ (72 × creatinine mg/dL), × 0.85 for women', note: 'Not adjusted for body surface area; drug labels often still use Cockcroft–Gault', source: 'Cockcroft & Gault, Nephron 1976' },
            grids: { weights: { columns: ['Weight', 'CrCl'], rows: [['Actual', kg], ['Ideal (Devine)', ibw], ['Adjusted (IBW + 0.4 × excess)', adjusted]].map(([name, w], n) => ({ header: name, cells: [Number.isFinite(w) ? `${f1(w)} kg` : 'Add height', Number.isFinite(w) ? `${f0(cg(w))} mL/min` : '—'], highlight: ['actual', 'ideal', 'adjusted'][n] === which })) } },
        };
    },

    fena: (i) => {
        if (!ok(i.una, i.pna, i.ucr, i.pcr) || i.pna <= 0 || i.ucr <= 0) {
            return need('Enter urine and plasma sodium and creatinine (both creatinines in the same unit).');
        }

        const fe = (100 * (i.una * i.pcr)) / (i.pna * i.ucr);

        return { value: `${f2(fe)}%`, label: 'Fractional excretion of sodium', sub: fe < 1 ? 'Under 1%: suggests a pre-renal cause' : fe > 2 ? 'Over 2%: suggests intrinsic kidney injury such as acute tubular necrosis' : '1–2%: indeterminate', rows: { formula: 'FENa = (UNa × PCr) ÷ (PNa × UCr) × 100', note: 'Diuretics raise FENa; use FEUrea instead. Valid mainly in oliguric acute kidney injury' } };
    },

    feurea: (i) => {
        if (!ok(i.uurea, i.purea, i.ucr, i.pcr) || i.purea <= 0 || i.ucr <= 0) {
            return need('Enter urine and plasma urea and creatinine (each pair in the same unit).');
        }

        const fe = (100 * (i.uurea * i.pcr)) / (i.purea * i.ucr);

        return { value: `${f1(fe)}%`, label: 'Fractional excretion of urea', sub: fe <= 35 ? '35% or less: suggests a pre-renal cause' : fe >= 50 ? '50% or more: suggests intrinsic kidney injury' : '35–50%: indeterminate', rows: { formula: 'FEUrea = (UUrea × PCr) ÷ (PUrea × UCr) × 100', note: 'Useful when the person is taking diuretics (Carvounis et al., Kidney Int 2002)' } };
    },

    gfr: (i) => {
        const scr = lab(i, 'cr', 'creatinine');
        const isFemale = female(i);

        if (!ok(i.age) || i.age < 18) {
            return need('Enter an age of 18 or over (use the Pediatric GFR calculator for children).');
        }

        const values = {
            creatinine: ok(scr) && scr > 0 ? egfr.creatinine(scr, i.age, isFemale) : NaN,
            cystatin: ok(i.cys) && i.cys > 0 ? egfr.cystatin(i.cys, i.age, isFemale) : NaN,
            combined: ok(scr, i.cys) && scr > 0 && i.cys > 0 ? egfr.combined(scr, i.cys, i.age, isFemale) : NaN,
            mdrd: ok(scr) && scr > 0 ? egfr.mdrd(scr, i.age, isFemale) : NaN,
        };
        const key = i.mode === 'cystatin' ? 'cystatin' : i.mode === 'both' ? 'combined' : 'creatinine';
        const value = values[key];

        if (!Number.isFinite(value)) {
            return need(key === 'cystatin' ? 'Enter cystatin C.' : key === 'combined' ? 'Enter creatinine and cystatin C.' : 'Enter creatinine.');
        }

        return {
            value: `${f0(value)} mL/min/1.73 m²`,
            label: 'Estimated GFR',
            sub: ckdStage(value),
            rows: { stage: ckdStage(value), equation: { creatinine: 'CKD-EPI 2021 creatinine (race-free)', cystatin: 'CKD-EPI 2012 cystatin C', combined: 'CKD-EPI 2021 creatinine–cystatin C' }[key], note: 'CKD needs kidney damage or eGFR under 60 for more than 3 months; one result is not a diagnosis' },
            grids: { equations: { columns: ['eGFR'], rows: [['CKD-EPI 2021 creatinine', 'creatinine'], ['CKD-EPI 2012 cystatin C', 'cystatin'], ['CKD-EPI 2021 creatinine–cystatin', 'combined'], ['MDRD (IDMS, no race term)', 'mdrd']].map(([name, k]) => ({ header: name, cells: [Number.isFinite(values[k]) ? f0(values[k]) : '—'], highlight: k === key })) } },
        };
    },

    ped_gfr: (i) => {
        const cr = lab(i, 'cr', 'creatinine');
        const cm = i.height * 100;

        if (!ok(cr, cm) || cr <= 0 || cm <= 0) {
            return need('Enter height and creatinine.');
        }

        const value = (0.413 * cm) / cr;

        return { value: `${f0(value)} mL/min/1.73 m²`, label: 'eGFR (bedside Schwartz)', sub: ckdStage(value), rows: { formula: 'eGFR = 0.413 × height (cm) ÷ creatinine (mg/dL)', note: 'For children 1–18 with an enzymatic (IDMS) creatinine; young infants have lower normal values', source: 'Schwartz et al., J Am Soc Nephrol 2009' } };
    },

    kfre: (i) => {
        if (!ok(i.age, i.egfr, i.acr) || i.acr <= 0 || i.egfr <= 0) {
            return need('Enter age, eGFR and albumin-to-creatinine ratio (mg/g).');
        }

        const acr = i.acr_unit === 'mg/mmol' ? i.acr * 8.84 : i.acr;
        const sum = -0.2201 * (i.age / 10 - 7.036) + 0.2467 * ((female(i) ? 0 : 1) - 0.5642) - 0.5567 * (i.egfr / 5 - 7.222) + 0.451 * (Math.log(acr) - 5.137);
        const base = KFRE[i.region === 'na' ? 'na' : 'other'];
        const two = 1 - base[0] ** Math.exp(sum);
        const five = 1 - base[1] ** Math.exp(sum);

        return { value: `${f1(100 * five)}%`, label: '5-year risk of kidney failure', sub: `${f1(100 * two)}% at 2 years (needing dialysis or a transplant)`, rows: { two: `${f1(100 * two)}%`, five: `${f1(100 * five)}%`, use: five >= 0.05 ? 'A 5-year risk of 5% or more is a common threshold for nephrology referral (NICE 2021)' : 'Under the common 5% referral threshold', source: 'Tangri et al., JAMA 2011 and 2016 (4-variable KFRE), for eGFR under 60' } };
    },

    ktv: (i) => {
        const kg = kgOf(i.weight);

        if (!ok(i.pre, i.post, i.hours, kg) || i.pre <= 0 || kg <= 0) {
            return need('Enter pre- and post-dialysis urea, session hours, fluid removed and post-dialysis weight.');
        }

        const r = i.post / i.pre;
        const ktv = -Math.log(r - 0.008 * i.hours) + (4 - 3.5 * r) * (or0(i.uf) / kg);
        const urr = 100 * (1 - r);

        return { value: f2(ktv), label: 'Single-pool Kt/V (Daugirdas)', sub: ktv >= 1.4 ? 'At or above the 1.4 target (KDOQI 2015, thrice weekly)' : ktv >= 1.2 ? 'Above the 1.2 minimum but below the 1.4 target' : 'Below the 1.2 minimum adequacy', rows: { urr: `${f0(urr)}% urea reduction ratio (65% or more)`, formula: 'Kt/V = −ln(R − 0.008 t) + (4 − 3.5 R) × UF ÷ W', source: 'Daugirdas, J Am Soc Nephrol 1993' } };
    },

    urr: (i) => {
        if (!ok(i.pre, i.post) || i.pre <= 0) {
            return need('Enter pre- and post-dialysis urea.');
        }

        const urr = (100 * (i.pre - i.post)) / i.pre;

        return { value: `${f0(urr)}%`, label: 'Urea reduction ratio', sub: urr >= 65 ? 'At or above the 65% adequacy level' : 'Below the 65% adequacy level', rows: { approx: `About ${f2(-Math.log(1 - urr / 100))} Kt/V without ultrafiltration (Lowrie)`, formula: 'URR = (pre − post) ÷ pre × 100' } };
    },

    prostate: (i) => {
        if (!ok(i.length, i.width, i.height)) {
            return need('Enter the three prostate dimensions in cm.');
        }

        const v = (i.length * i.width * i.height * Math.PI) / 6;

        return { value: `${f0(v)} mL`, label: 'Prostate volume (ellipsoid)', sub: v > 30 ? 'Over 30 mL: enlarged' : 'Within the usual 20–30 mL for adults', rows: { formula: 'V = L × W × H × π ÷ 6 (0.52)', psad: ok(i.psa) ? `PSA density ${f2(i.psa / v)} ng/mL/mL` : 'Add PSA for the density', note: '1 mL is about 1 g of prostate tissue' } };
    },

    psa_density: (i) => {
        if (!ok(i.psa, i.volume) || i.volume <= 0) {
            return need('Enter PSA and prostate volume.');
        }

        const d = i.psa / i.volume;

        return { value: f2(d), unit: 'ng/mL/mL', label: 'PSA density', sub: d >= 0.15 ? '0.15 or more: higher chance of clinically significant cancer; often prompts MRI or biopsy discussion' : 'Under 0.15: lower chance of clinically significant cancer', rows: { formula: 'PSAD = PSA ÷ prostate volume', note: 'Thresholds of 0.10–0.20 are used with MRI findings (EAU 2024)' } };
    },

    psa_dt: (i) => {
        const points = parseRows(i.values).map(([date, psa]) => ({ date: parseDate(date), psa: Number(psa) })).filter((p) => p.date && p.psa > 0);

        if (points.length < 2) {
            return need('Enter at least two PSA results with dates (YYYY-MM-DD).');
        }

        const t0 = toDays(points[0].date);
        const xs = points.map((p) => (toDays(p.date) - t0) / 30.4375);
        const ys = points.map((p) => Math.log(p.psa));
        const mx = xs.reduce((a, b) => a + b, 0) / xs.length;
        const my = ys.reduce((a, b) => a + b, 0) / ys.length;
        const sxx = xs.reduce((a, x) => a + (x - mx) ** 2, 0);

        if (sxx === 0) {
            return { error: 'The PSA results need different dates.' };
        }

        const slope = xs.reduce((a, x, n) => a + (x - mx) * (ys[n] - my), 0) / sxx;

        if (slope <= 0) {
            return { value: 'Not rising', label: 'PSA doubling time', sub: 'PSA is stable or falling over these results', rows: { velocity: `${f2(((points.at(-1).psa - points[0].psa) / xs.at(-1)) * 12)} ng/mL a year`, method: 'Log-linear regression of ln PSA on time' } };
        }

        const dt = Math.LN2 / slope;

        return { value: `${f1(dt)} months`, label: 'PSA doubling time', sub: dt < 3 ? 'Under 3 months: very rapid' : dt < 12 ? 'Under 12 months' : 'Over 12 months', rows: { velocity: `${f2(((points.at(-1).psa - points[0].psa) / xs.at(-1)) * 12)} ng/mL a year`, method: `Log-linear regression of ln PSA on time (${points.length} results)`, note: 'Most useful after treatment; interpret with the urologist or oncologist' } };
    },

    ttkg: (i) => {
        if (!ok(i.uk, i.pk, i.uosm, i.posm) || i.pk <= 0 || i.uosm <= 0) {
            return need('Enter urine and plasma potassium and osmolality.');
        }

        const value = (i.uk / i.pk) / (i.uosm / i.posm);
        const valid = i.uosm > i.posm;
        const reading = i.pk < 3.5 ? (value > 3 ? 'With low potassium, over 3 suggests kidney potassium loss' : 'With low potassium, under 3 suggests losses outside the kidney') : i.pk > 5 ? (value < 7 ? 'With high potassium, under 7 suggests low aldosterone effect' : 'With high potassium, over 7 suggests a normal kidney response') : 'Typical range on a normal diet is about 8–9';

        return { value: f1(value), label: 'Transtubular potassium gradient', sub: reading, rows: { valid: valid ? 'Urine osmolality above plasma: the formula applies' : 'Not valid: urine osmolality must exceed plasma osmolality', formula: 'TTKG = (UK ÷ PK) ÷ (Uosm ÷ Posm)', note: 'Its assumptions have been questioned (Kamel & Halperin 2011); the urine K/creatinine ratio is an alternative' } };
    },

    urine_output: (i) => {
        const kg = kgOf(i.weight);

        if (!ok(i.volume, i.hours, kg) || i.hours <= 0 || kg <= 0) {
            return need('Enter urine volume, hours and weight.');
        }

        const rate = i.volume / (kg * i.hours);
        const stage = rate < 0.3 && i.hours >= 24 ? 'KDIGO stage 3 (under 0.3 mL/kg/h for 24 hours)' : rate < 0.5 && i.hours >= 12 ? 'KDIGO stage 2 (under 0.5 mL/kg/h for 12 hours)' : rate < 0.5 && i.hours >= 6 ? 'KDIGO stage 1 (under 0.5 mL/kg/h for 6 hours)' : rate < 0.5 ? 'Under 0.5 mL/kg/h (KDIGO counts this over 6 hours or more)' : 'Not oliguric (0.5 mL/kg/h or more)';

        return { value: `${f2(rate)} mL/kg/h`, label: 'Urine output', sub: stage, rows: { hourly: `${f0(i.volume / i.hours)} mL/h`, daily: `${f0((i.volume / i.hours) * 24)} mL a day at this rate`, source: 'KDIGO 2012 acute kidney injury urine output criteria' } };
    },

    pcr: (i) => {
        const cr = lab(i, 'ucr', 'ucreat');
        const factor = { 'mg/dL': 1, 'mg/L': 0.1, 'g/L': 100 }[i.protein_unit] ?? 1;
        const protein = or0(i.protein) * factor;

        if (!ok(cr) || cr <= 0 || protein <= 0) {
            return need('Enter urine protein and urine creatinine.');
        }

        const mgMg = protein / cr;
        const mgG = mgMg * 1000;
        const band = mgG < 150 ? 'Normal to mildly increased (under 150 mg/g)' : mgG <= 500 ? 'Moderately increased (150–500 mg/g)' : mgG < 3000 ? 'Severely increased (over 500 mg/g)' : 'Nephrotic range (about 3,000 mg/g or more)';

        return { value: `${f2(mgMg)} mg/mg`, label: 'Protein-to-creatinine ratio', sub: `About ${f2(mgMg)} g of protein a day; ${band.toLowerCase()}`, rows: { mgG: `${f0(mgG)} mg/g`, mmol: `${f0(mgG / 8.84)} mg/mmol`, band, note: 'PCR in mg/mg roughly equals grams of protein in 24 hours (KDIGO); confirm with repeat tests' } };
    },

    // Electrolytes and fluids ----------------------------------------------------------------------
    acid_base: (i) => {
        if (!ok(i.ph, i.pco2, i.hco3)) {
            return need('Enter pH, PaCO₂ and HCO₃.');
        }

        const { ph, pco2, hco3 } = i;
        const findings = [];
        let primary;

        if (ph < 7.35) {
            if (hco3 < 22) {
                primary = 'Metabolic acidosis';
                const expected = 1.5 * hco3 + 8;
                findings.push(pco2 > expected + 2 ? 'with a respiratory acidosis as well (PaCO₂ above Winters\' range)' : pco2 < expected - 2 ? 'with a respiratory alkalosis as well (PaCO₂ below Winters\' range)' : 'with appropriate respiratory compensation');
            } else {
                primary = 'Respiratory acidosis';
                const acute = 24 + (pco2 - 40) / 10;
                const chronic = 24 + 3.5 * ((pco2 - 40) / 10);
                findings.push(hco3 <= acute + 2 ? 'acute (HCO₃ up about 1 per 10 mmHg)' : hco3 <= chronic + 2 ? 'chronic or partly compensated (HCO₃ up about 3.5 per 10 mmHg)' : 'with a metabolic alkalosis as well');
            }
        } else if (ph > 7.45) {
            if (hco3 > 26) {
                primary = 'Metabolic alkalosis';
                const expected = 0.7 * hco3 + 21;
                findings.push(pco2 > expected + 2 ? 'with a respiratory acidosis as well' : pco2 < expected - 2 ? 'with a respiratory alkalosis as well' : 'with appropriate respiratory compensation');
            } else {
                primary = 'Respiratory alkalosis';
                const acute = 24 - 2 * ((40 - pco2) / 10);
                const chronic = 24 - 5 * ((40 - pco2) / 10);
                findings.push(hco3 >= acute - 2 ? 'acute (HCO₃ down about 2 per 10 mmHg)' : hco3 >= chronic - 2 ? 'chronic (HCO₃ down about 5 per 10 mmHg)' : 'with a metabolic acidosis as well');
            }
        } else {
            primary = pco2 > 45 && hco3 > 26 ? 'Normal pH: mixed respiratory acidosis and metabolic alkalosis' : pco2 < 35 && hco3 < 22 ? 'Normal pH: mixed respiratory alkalosis and metabolic acidosis' : 'No primary acid–base disorder';
        }

        const ag = ok(i.na, i.cl) ? i.na - i.cl - hco3 : NaN;
        const corrected = Number.isFinite(ag) && ok(i.albumin) ? ag + 2.5 * (4 - lab(i, 'albumin', 'albumin')) : ag;
        const delta = Number.isFinite(corrected) && hco3 < 24 ? (corrected - 12) / (24 - hco3) : NaN;

        return {
            value: primary,
            label: 'Primary disorder',
            sub: findings.join('; ') || `pH ${f2(ph)}, PaCO₂ ${f0(pco2)}, HCO₃ ${f0(hco3)}`,
            rows: { ag: Number.isFinite(ag) ? `${f0(ag)} (albumin-corrected ${f0(corrected)}; over 12 is raised)` : 'Enter Na and Cl', delta: Number.isFinite(delta) && corrected > 12 ? `${f2(delta)}: ${delta < 1 ? 'a normal-gap acidosis as well' : delta > 2 ? 'a metabolic alkalosis as well' : 'pure high anion gap acidosis'}` : 'Applies to a high anion gap acidosis', method: 'Boston rules, Winters\' formula and albumin correction (Figge)' },
        };
    },

    anion_gap: (i) => {
        if (!ok(i.na, i.cl, i.hco3)) {
            return need('Enter sodium, chloride and bicarbonate.');
        }

        const ag = i.na - (i.cl + i.hco3);
        const alb = lab(i, 'albumin', 'albumin');
        const corrected = Number.isFinite(alb) ? ag + 2.5 * (4 - alb) : NaN;
        const use = Number.isFinite(corrected) ? corrected : ag;

        return { value: `${f0(ag)} mmol/L`, label: 'Anion gap', sub: use > 12 ? 'Raised (over 12): high anion gap metabolic acidosis is possible (ketoacidosis, lactate, kidney failure, toxins)' : use < 3 ? 'Low (under 3): check for lab error, low albumin or paraproteins' : 'Within the usual 3–12 (lab ranges vary)', rows: { corrected: Number.isFinite(corrected) ? `${f0(corrected)} mmol/L (+ 2.5 × (4 − albumin g/dL))` : 'Enter albumin for the corrected gap', withK: ok(i.k) ? `${f0(ag + i.k)} mmol/L including potassium (usual 10–20)` : 'Not included', delta: i.hco3 < 24 && use > 12 ? `${f2((use - 12) / (24 - i.hco3))} delta ratio` : 'Used when the gap is raised and bicarbonate is low' } };
    },

    arterial_ph: (i) => {
        if (!ok(i.pco2, i.hco3) || i.pco2 <= 0 || i.hco3 <= 0) {
            return need('Enter PaCO₂ and HCO₃.');
        }

        const ph = 6.1 + Math.log10(i.hco3 / (0.03 * i.pco2));

        return { value: f2(ph), label: 'Arterial pH (Henderson–Hasselbalch)', sub: ph < 7.35 ? 'Acidaemia (under 7.35)' : ph > 7.45 ? 'Alkalaemia (over 7.45)' : 'Normal (7.35–7.45)', rows: { hplus: `${f0(10 ** (9 - ph))} nmol/L H⁺`, formula: 'pH = 6.1 + log₁₀(HCO₃ ÷ (0.03 × PaCO₂))' } };
    },

    bicarb_deficit: (i) => {
        const kg = kgOf(i.weight);

        if (!ok(kg, i.hco3, i.target) || kg <= 0) {
            return need('Enter weight and current and target bicarbonate.');
        }

        const factor = ok(i.factor) ? i.factor : 0.5;
        const deficit = factor * kg * (i.target - i.hco3);

        return { value: `${f0(Math.max(0, deficit))} mEq`, label: 'Bicarbonate deficit', sub: `${factor} × ${f1(kg)} kg × (${f0(i.target)} − ${f0(i.hco3)})`, rows: { factor: `${factor} L/kg distribution (rises in severe acidosis)`, note: 'A calculation for teaching; replacement, if any, is decided by the treating team and usually corrects only part of the deficit' } };
    },

    corrected_ca: (i) => {
        const ca = lab(i, 'ca', 'calcium');
        const alb = lab(i, 'albumin', 'albumin');

        if (!ok(ca, alb)) {
            return need('Enter total calcium and albumin.');
        }

        const corrected = ca + 0.8 * (4 - alb);

        return { value: `${f1(corrected)} mg/dL`, label: 'Albumin-corrected calcium', sub: corrected < 8.5 ? 'Low (under 8.5 mg/dL)' : corrected > 10.5 ? 'High (over 10.5 mg/dL)' : 'Within the usual 8.5–10.5 mg/dL', rows: { si: `${f2(corrected / 4.008)} mmol/L`, formula: 'Ca + 0.8 × (4 − albumin g/dL) (Payne 1973)', note: 'Ionised calcium is more accurate in critical illness and kidney failure' } };
    },

    corrected_mg: (i) => {
        const mg = lab(i, 'mg', 'magnesium');
        const alb = lab(i, 'albumin', 'albumin');

        if (!ok(mg, alb)) {
            return need('Enter magnesium and albumin.');
        }

        const mmol = mg / 2.431 + 0.005 * (40 - alb * 10);

        return { value: `${f2(mmol)} mmol/L`, label: 'Albumin-corrected magnesium', sub: mmol < 0.7 ? 'Low (under 0.7 mmol/L)' : mmol > 1.05 ? 'High (over 1.05 mmol/L)' : 'Within the usual 0.7–1.05 mmol/L', rows: { mgdl: `${f2(mmol * 2.431)} mg/dL`, formula: 'Mg (mmol/L) + 0.005 × (40 − albumin g/L) (Kroll & Elin 1985)' } };
    },

    drip: (i) => dripResult(i),

    iv_flow: (i) => {
        if (i.mode === 'finish') {
            const start = String(i.start ?? '').match(/^(\d{1,2}):(\d{2})$/);

            if (!ok(i.volume, i.rate) || i.rate <= 0) {
                return need('Enter the volume and the rate in mL/h.');
            }

            const hours = i.volume / i.rate;
            const startMin = start ? Number(start[1]) * 60 + Number(start[2]) : NaN;
            const end = startMin + hours * 60;
            const clock = (m) => `${String(Math.floor((m / 60) % 24)).padStart(2, '0')}:${String(Math.round(m % 60) % 60).padStart(2, '0')}`;

            return { value: `${Math.floor(hours)} h ${Math.round((hours % 1) * 60)} min`, label: 'Infusion time', sub: Number.isFinite(end) ? `Finishes at about ${clock(end)}${end >= 1440 ? ' the next day' : ''}` : 'Add a start time for the finish time', rows: { mlh: `${f0(i.rate)} mL/h`, gtt: `${f0((i.rate * (Number(i.factor) || 20)) / 60)} drops/min at ${Number(i.factor) || 20} drops/mL`, formula: 'time = volume ÷ rate' } };
        }

        const minutes = or0(i.hours) * 60 + or0(i.minutes);

        if (!ok(i.volume) || minutes <= 0) {
            return need('Enter the volume and the time.');
        }

        const rate = (i.volume / minutes) * 60;

        return { value: `${f0(rate)} mL/h`, label: 'IV flow rate', sub: `${f0(i.volume)} mL over ${f1(minutes / 60)} hours`, rows: { mlh: `${f1(rate)} mL/h`, gtt: `${f0((i.volume * (Number(i.factor) || 20)) / minutes)} drops/min at ${Number(i.factor) || 20} drops/mL`, formula: 'mL/h = volume ÷ hours' } };
    },

    free_water: (i) => {
        const kg = kgOf(i.weight);

        if (!ok(kg, i.na) || kg <= 0) {
            return need('Enter sodium, weight, age and sex.');
        }

        const tbw = tbwFraction(i) * kg;
        const deficit = tbw * (i.na / 140 - 1);

        return { value: `${f1(Math.max(0, deficit))} L`, label: 'Free water deficit', sub: i.na <= 145 ? 'Sodium is not raised, so there is no free water deficit' : `Total body water ${f1(tbw)} L (${tbwFraction(i)} × weight)`, rows: { tbw: `${f1(tbw)} L`, formula: 'Deficit = TBW × (Na ÷ 140 − 1)', note: 'Correction is usually limited to about 10 mmol/L a day in chronic hypernatraemia; ongoing losses add to the total' } };
    },

    osm: (i) => osmResult(i),

    na_htg: (i) => {
        const tg = lab(i, 'tg', 'triglycerides');

        if (!ok(i.na, tg)) {
            return need('Enter measured sodium and triglycerides.');
        }

        const corrected = i.na + 0.002 * tg;

        return { value: `${f0(corrected)} mmol/L`, label: 'Sodium corrected for triglycerides', sub: `+${f1(0.002 * tg)} mmol/L for triglycerides of ${f0(tg)} mg/dL`, rows: { formula: 'Na + 0.002 × triglycerides (mg/dL)', note: 'Pseudohyponatraemia: indirect ion-selective electrodes read low with very high lipids; direct ISE (blood gas) sodium is not affected' } };
    },

    na_glucose: (i) => {
        const glucose = lab(i, 'glucose', 'glucose');

        if (!ok(i.na, glucose)) {
            return need('Enter sodium and glucose.');
        }

        const excess = Math.max(0, glucose - 100) / 100;

        return { value: `${f0(i.na + 2.4 * excess)} mmol/L`, label: 'Corrected sodium (Hillier, 2.4)', sub: `Katz (1.6): ${f0(i.na + 1.6 * excess)} mmol/L`, rows: { katz: `${f1(i.na + 1.6 * excess)} mmol/L (Katz 1973)`, hillier: `${f1(i.na + 2.4 * excess)} mmol/L (Hillier 1999)`, note: 'High glucose draws water out of cells and dilutes sodium; the correction shows the sodium once glucose is normal' } };
    },

    na_rate: (i) => {
        const kg = kgOf(i.weight);
        const fluid = INFUSATES[i.infusate] ?? INFUSATES.normal;

        if (!ok(kg, i.na) || kg <= 0) {
            return need('Enter sodium, weight, age and sex.');
        }

        const tbw = tbwFraction(i) * kg;
        const change = (fluid[1] + fluid[2] - i.na) / (tbw + 1);
        const limit = i.na < 135 ? 8 : 10;

        return { value: `${change > 0 ? '+' : ''}${f1(change)} mmol/L`, label: `Expected change in sodium per litre of ${fluid[0]}`, sub: `TBW ${f1(tbw)} L; ${Number.isFinite(change) && change !== 0 ? `about ${f1(limit / Math.abs(change))} L would change sodium by ${limit} mmol/L` : 'no change expected'}`, rows: { formula: 'ΔNa = (infusate Na + K − serum Na) ÷ (TBW + 1) (Adrogué–Madias)', limit: i.na < 135 ? 'In chronic hyponatraemia, keep the rise to 8–10 mmol/L in 24 hours to avoid osmotic demyelination' : 'In chronic hypernatraemia, aim for a fall of about 10 mmol/L a day', note: 'Estimates often under-predict the change; sodium must be re-measured frequently by the treating team' } };
    },

    na_deficit: (i) => {
        const kg = kgOf(i.weight);

        if (!ok(kg, i.na, i.target) || kg <= 0) {
            return need('Enter current and target sodium, weight, age and sex.');
        }

        const tbw = tbwFraction(i) * kg;

        return { value: `${f0(Math.max(0, tbw * (i.target - i.na)))} mmol`, label: 'Sodium deficit', sub: `TBW ${f1(tbw)} L × (${f0(i.target)} − ${f0(i.na)})`, rows: { tbw: `${f1(tbw)} L`, note: 'A teaching estimate; the target should rise by no more than 8–10 mmol/L in 24 hours in chronic hyponatraemia' } };
    },

    tbw: (i) => {
        const kg = kgOf(i.weight);
        const cm = i.height * 100;

        if (!ok(kg, cm, i.age) || kg <= 0) {
            return need('Enter height, weight, age and sex.');
        }

        const watson = female(i) ? -2.097 + 0.1069 * cm + 0.2466 * kg : 2.447 - 0.09516 * i.age + 0.1074 * cm + 0.3362 * kg;
        const hume = female(i) ? 0.34454 * cm + 0.183809 * kg - 35.270121 : 0.194786 * cm + 0.296785 * kg - 14.012934;
        const simple = tbwFraction({ ...i, group: 'adult' }) * kg;

        return { value: `${f1(watson)} L`, label: 'Total body water (Watson)', sub: `${f0((100 * watson) / kg)}% of body weight`, rows: { hume: `${f1(hume)} L (Hume–Weyers 1971)`, simple: `${f1(simple)} L (${tbwFraction({ ...i, group: 'adult' })} × weight)`, source: 'Watson et al., Am J Clin Nutr 1980' } };
    },

    uag: (i) => {
        if (!ok(i.na, i.k, i.cl)) {
            return need('Enter urine sodium, potassium and chloride.');
        }

        const uag = i.na + i.k - i.cl;

        return { value: `${f0(uag)} mmol/L`, label: 'Urine anion gap', sub: uag < 0 ? 'Negative: kidneys are excreting ammonium normally; suggests gut bicarbonate loss (such as diarrhoea)' : 'Positive: suggests low ammonium excretion, as in renal tubular acidosis', rows: { formula: 'UAG = UNa + UK − UCl', note: 'For normal anion gap metabolic acidosis; unreliable with ketones, other unmeasured anions or urine Na under 20' } };
    },

    venous_ph: (i) => {
        if (!ok(i.ph)) {
            return need('Enter the venous pH.');
        }

        return { value: f2(i.ph + 0.03), label: 'Estimated arterial pH', sub: 'Venous pH is on average about 0.03 lower than arterial', rows: { pco2: ok(i.pco2) ? `About ${f0(i.pco2 - 4.4)} mmHg arterial PaCO₂ (venous is about 4–5 higher, with wide limits)` : 'Enter venous PCO₂', hco3: ok(i.hco3) ? `About ${f0(i.hco3 - 1)} mmol/L arterial HCO₃` : 'Enter venous HCO₃', note: 'Agreement is good for pH and HCO₃ but poor for PCO₂ and PO₂ (Byrne et al., Respirology 2014); a venous PCO₂ under 45 makes arterial hypercapnia unlikely' } };
    },

    winters: (i) => {
        if (!ok(i.hco3)) {
            return need('Enter bicarbonate.');
        }

        const expected = 1.5 * i.hco3 + 8;
        const verdict = !ok(i.pco2) ? 'Enter the measured PaCO₂ to compare' : i.pco2 > expected + 2 ? 'Measured PaCO₂ is higher: a respiratory acidosis is present as well' : i.pco2 < expected - 2 ? 'Measured PaCO₂ is lower: a respiratory alkalosis is present as well' : 'Within the range: appropriate respiratory compensation';

        return { value: `${f0(expected - 2)}–${f0(expected + 2)} mmHg`, label: 'Expected PaCO₂ (Winters\' formula)', sub: verdict, rows: { formula: 'PaCO₂ = 1.5 × HCO₃ + 8 ± 2', note: 'For metabolic acidosis only' } };
    },

    // Hematology ----------------------------------------------------------------------------------
    aec: (i) => {
        if (!ok(i.wbc, i.pct)) {
            return need('Enter WBC and eosinophil %.');
        }

        const aec = i.wbc * i.pct * 10;

        return { value: `${f0(aec)}/µL`, label: 'Absolute eosinophil count', sub: aec < 500 ? 'Normal (under 500/µL)' : aec < 1500 ? 'Mild eosinophilia (500–1,499)' : aec < 5000 ? 'Moderate eosinophilia (1,500–4,999)' : 'Severe eosinophilia (5,000 or more)', rows: { si: `${f2(aec / 1000)} × 10⁹/L`, note: 'Allergy, asthma and parasites are common causes; 1,500 or more persistently needs review' } };
    },

    alc: (i) => {
        if (!ok(i.wbc, i.pct)) {
            return need('Enter WBC and lymphocyte %.');
        }

        const alc = i.wbc * i.pct * 10;

        return { value: `${f0(alc)}/µL`, label: 'Absolute lymphocyte count', sub: alc < 1000 ? 'Lymphopenia (under 1,000/µL in adults)' : alc > 4000 ? 'Lymphocytosis (over 4,000/µL in adults)' : 'Within the adult range (1,000–4,000)', rows: { si: `${f2(alc / 1000)} × 10⁹/L`, note: 'Children have higher normal counts' } };
    },

    arc: (i) => {
        if (!ok(i.retic, i.rbc)) {
            return need('Enter reticulocyte % and red cell count.');
        }

        const arc = i.retic * i.rbc * 10;

        return { value: `${f0(arc)} × 10⁹/L`, label: 'Absolute reticulocyte count', sub: arc > 100 ? 'Over 100: the marrow is responding (bleeding or haemolysis)' : arc < 25 ? 'Low (under 25): reduced red cell production' : 'Within the usual 25–100', rows: { formula: 'ARC = retic % × RBC (× 10¹²/L) × 10' } };
    },

    ddimer: (i) => {
        const d = lab(i, 'ddimer', 'ddimer');

        if (!ok(i.age, d)) {
            return need('Enter age and the D-dimer result.');
        }

        const cutoff = i.age > 50 ? i.age * 10 : 500;

        return { value: `${f0(cutoff)} µg/L FEU`, label: 'Age-adjusted D-dimer cut-off', sub: d < cutoff ? `${f0(d)} is below the cut-off: with a low or “unlikely” clinical probability, PE can be excluded` : `${f0(d)} is at or above the cut-off: imaging is usually needed`, rows: { standard: `${d < 500 ? 'Below' : 'Above'} the standard 500 µg/L cut-off`, formula: 'Cut-off = age × 10 µg/L for people over 50', source: 'Righini et al., JAMA 2014 (ADJUST-PE)' } };
    },

    ag_ratio: (i) => {
        const tp = lab(i, 'protein', 'protein');
        const alb = lab(i, 'albumin', 'albumin');

        if (!ok(tp, alb) || tp <= alb) {
            return need('Enter total protein and albumin (protein higher than albumin).');
        }

        const glob = tp - alb;
        const ratio = alb / glob;

        return { value: f2(ratio), label: 'Albumin-to-globulin ratio', sub: ratio < 1 ? 'Low (under 1): high globulins (inflammation, myeloma) or low albumin' : ratio > 2.5 ? 'High (over 2.5)' : 'Within the usual 1.0–2.5', rows: { globulin: `${f1(glob)} g/dL (${f0(glob * 10)} g/L)`, formula: 'Globulin = total protein − albumin' } };
    },

    anc: (i) => ancResult(i),

    donation_due: (i) => {
        const last = parseDate(i.last);
        const today = parseDate(i.today);
        const country = DONATION[i.country] ? i.country : 'us';
        const type = DONATION[country][i.type] ? i.type : 'whole';
        let [name, days] = DONATION[country][type];

        if (!last) {
            return need('Enter the date of your last donation.');
        }

        if (days === null) {
            days = country === 'uk' ? (female(i) ? 112 : 84) : female(i) ? 120 : 90;
        }

        const next = addDays(last, days);
        const wait = today ? toDays(next) - toDays(today) : NaN;

        return { value: shortDate(next), label: `Next ${name.toLowerCase()} donation`, sub: Number.isFinite(wait) ? (wait <= 0 ? 'You can donate now, if you feel well and meet the other criteria' : `In ${f0(wait)} days`) : `${days} days after the last donation`, rows: { interval: `${days} days (${{ us: 'American Red Cross', uk: 'NHS Blood and Transplant', in: 'India NBTC 2017' }[country]})`, note: country === 'us' ? 'Whole blood up to 6 times a year; platelets up to 24 times a year' : 'Men and women have different minimum intervals', check: 'Medicines, travel and health questions on the day decide eligibility' } };
    },

    donor: (i) => {
        const kg = kgOf(i.weight);
        const m = i.height;

        if (!ok(kg, m, i.age) || kg <= 0) {
            return need('Enter age, height, weight and sex.');
        }

        const bv = nadler(m, kg, female(i));
        const okAge = i.age >= 17;
        const okWeight = kg >= 50;
        const power = female(i) ? m >= 1.651 && kg >= 68 : m >= 1.549 && kg >= 59;

        return { value: okAge && okWeight ? 'Likely eligible' : 'Not eligible on age or weight', label: 'Basic donor check (whole blood)', sub: `${okAge ? 'Age 17 or over' : 'Under 17 (16 with consent in some US states)'}; ${okWeight ? 'weight 50 kg (110 lb) or more' : 'under 50 kg (110 lb)'}`, rows: { volume: `${f1(bv)} L estimated blood volume (Nadler)`, share: `A 500 mL donation is ${f0(50 / bv)}% of your blood (limit 10.5 mL/kg: ${f0(10.5 * kg)} mL)`, power: power ? 'Meets the Power Red height and weight minimums' : 'Below the Power Red height and weight minimums', source: 'American Red Cross eligibility; younger donors have extra height and weight rules' } };
    },

    abl: (i) => {
        const kg = kgOf(i.weight);
        const perKg = { preterm: 100, term: 85, infant: 80, child: 75, man: 70, woman: 65 }[i.group] ?? 70;

        if (!ok(kg, i.hi, i.hf) || kg <= 0 || i.hi <= i.hf) {
            return need('Enter weight, starting haematocrit and the lowest acceptable haematocrit (lower than the start).');
        }

        const ebv = perKg * kg;
        const gross = (ebv * (i.hi - i.hf)) / ((i.hi + i.hf) / 2);
        const simple = (ebv * (i.hi - i.hf)) / i.hi;

        return { value: `${f0(gross)} mL`, label: 'Allowable blood loss (Gross)', sub: `Estimated blood volume ${f0(ebv)} mL (${perKg} mL/kg)`, rows: { simple: `${f0(simple)} mL by EBV × (Hi − Hf) ÷ Hi`, formula: 'ABL = EBV × (Hi − Hf) ÷ mean Hct (Gross 1983)', note: 'An anaesthesia planning estimate; transfusion decisions use the clinical picture' } };
    },

    blood_volume: (i) => {
        const kg = kgOf(i.weight);
        const m = i.height;

        if (!ok(kg, m) || kg <= 0 || m <= 0) {
            return need('Enter height, weight and sex.');
        }

        const bv = nadler(m, kg, female(i));
        const bmi = kg / (m * m);
        const lemmens = (70 / Math.sqrt(bmi / 22)) * kg;

        return { value: `${f2(bv)} L`, label: 'Blood volume (Nadler)', sub: `${f0((bv * 1000) / kg)} mL/kg`, rows: { lemmens: `${f2(lemmens / 1000)} L (Lemmens 2006, for obesity)`, simple: `${f2(((female(i) ? 65 : 70) * kg) / 1000)} L (${female(i) ? 65 : 70} mL/kg)`, source: 'Nadler, Hidalgo & Bloch, Surgery 1962' } };
    },

    plasma_volume: (i) => {
        const kg = kgOf(i.weight);
        const m = i.height;

        if (!ok(kg, m, i.hct) || kg <= 0) {
            return need('Enter height, weight, sex and haematocrit.');
        }

        const bv = nadler(m, kg, female(i));
        const pv = bv * (1 - i.hct / 100);

        return { value: `${f2(pv)} L`, label: 'Plasma volume', sub: `Blood volume ${f2(bv)} L × (1 − ${f0(i.hct)}%)`, rows: { bv: `${f2(bv)} L (Nadler)`, formula: 'PV = blood volume × (1 − haematocrit)', note: 'Typical plasma volume is about 40–50 mL/kg in adults' } };
    },

    crc: (i) => {
        if (!ok(i.retic, i.hct)) {
            return need('Enter reticulocyte % and haematocrit.');
        }

        const crc = (i.retic * i.hct) / 45;
        const maturation = i.hct >= 36 ? 1 : i.hct >= 26 ? 1.5 : i.hct >= 16 ? 2 : 2.5;
        const rpi = crc / maturation;

        return { value: `${f2(crc)}%`, label: 'Corrected reticulocyte count', sub: `Reticulocyte production index ${f2(rpi)}: ${rpi >= 2 ? 'adequate marrow response (blood loss or haemolysis)' : 'inadequate response (under 2): reduced production'}`, rows: { rpi: f2(rpi), maturation: `${maturation} days maturation time at Hct ${f0(i.hct)}%`, formula: 'CRC = retic × Hct ÷ 45; RPI = CRC ÷ maturation' } };
    },

    hct_hb: (i) => {
        if (i.from === 'hct') {
            if (!ok(i.hct)) {
                return need('Enter the haematocrit.');
            }

            return { value: `${f1(i.hct / 3)} g/dL`, label: 'Estimated haemoglobin', sub: `Haematocrit ${f0(i.hct)}% ÷ 3`, rows: { rule: 'Hct (%) ≈ 3 × Hb (g/dL) for normal-sized red cells', note: 'The rule fails with abnormal MCHC (iron deficiency, spherocytosis)' } };
        }

        if (!ok(i.hb)) {
            return need('Enter haemoglobin.');
        }

        return { value: `${f0(i.hb * 3)}%`, label: 'Estimated haematocrit', sub: `Haemoglobin ${f1(i.hb)} g/dL × 3`, rows: { rule: 'Hct (%) ≈ 3 × Hb (g/dL) for normal-sized red cells', note: 'The rule fails with abnormal MCHC (iron deficiency, spherocytosis)' } };
    },

    inr: (i) => {
        if (!ok(i.pt, i.mnpt, i.isi) || i.mnpt <= 0) {
            return need('Enter PT, mean normal PT and the ISI.');
        }

        const inr = (i.pt / i.mnpt) ** i.isi;

        return { value: f1(inr), label: 'INR', sub: inr < 1.2 ? 'Normal without anticoagulation (about 0.8–1.2)' : inr <= 3 ? 'Within 2–3 if on warfarin for most conditions' : 'Above 3: higher bleeding risk', rows: { formula: 'INR = (PT ÷ mean normal PT)^ISI', ratio: `${f2(i.pt / i.mnpt)} PT ratio`, note: 'Target ranges are set by the prescriber (often 2.0–3.0; 2.5–3.5 for some mechanical valves)' } };
    },

    iron_deficit: (i) => {
        const kg = kgOf(i.weight);
        const hb = lab(i, 'hb', 'hemoglobin');

        if (!ok(kg, hb) || kg <= 0) {
            return need('Enter weight and haemoglobin.');
        }

        const target = ok(i.target) ? i.target : kg >= 35 ? 15 : 13;
        const stores = kg >= 35 ? 500 : 15 * kg;
        const deficit = kg * Math.max(0, target - hb) * 2.4 + stores;

        return { value: `${f0(deficit)} mg`, label: 'Total iron deficit (Ganzoni)', sub: `${f1(kg)} kg × (${f1(target)} − ${f1(hb)}) × 2.4 + ${f0(stores)} mg stores`, rows: { stores: `${f0(stores)} mg`, formula: 'Deficit = weight × (target Hb − Hb) × 2.4 + stores', note: 'This is the body\'s iron shortfall, not a dose: iron products and amounts are prescribed by a clinician' } };
    },

    mentzer: (i) => {
        if (!ok(i.mcv, i.rbc) || i.rbc <= 0) {
            return need('Enter MCV and red cell count.');
        }

        const index = i.mcv / i.rbc;

        return { value: f1(index), label: 'Mentzer index', sub: index < 13 ? 'Under 13: thalassaemia trait is more likely' : index > 13 ? 'Over 13: iron deficiency is more likely' : 'Exactly 13: indeterminate', rows: { formula: 'MCV (fL) ÷ RBC (× 10¹²/L) (Mentzer 1973)', note: 'Confirm with ferritin and haemoglobin electrophoresis' } };
    },

    nlr: (i) => {
        const n = i.mode === 'pct' ? i.npct : i.neut;
        const l = i.mode === 'pct' ? i.lpct : i.lymph;

        if (!ok(n, l) || l <= 0) {
            return need('Enter neutrophils and lymphocytes.');
        }

        const nlr = n / l;

        return { value: f2(nlr), label: 'Neutrophil-to-lymphocyte ratio', sub: nlr < 0.78 ? 'Below the usual adult range' : nlr <= 3.53 ? 'Within the usual adult range (0.78–3.53)' : 'Above the usual adult range', rows: { range: '0.78–3.53 in healthy adults (Forget et al., BMC Res Notes 2017)', note: 'A marker of physiological stress and inflammation; there is no single diagnostic cut-off' } };
    },

    rbc_indices: (i) => {
        const hb = lab(i, 'hb', 'hemoglobin');

        if (!ok(hb, i.hct, i.rbc) || i.rbc <= 0 || i.hct <= 0) {
            return need('Enter haemoglobin, haematocrit and red cell count.');
        }

        const mcv = (i.hct * 10) / i.rbc;
        const mch = (hb * 10) / i.rbc;
        const mchc = (hb / i.hct) * 100;

        return { value: `${f1(mchc)} g/dL`, label: 'MCHC', sub: `MCV ${f0(mcv)} fL, MCH ${f1(mch)} pg`, rows: { mcv: `${f1(mcv)} fL (${mcv < 80 ? 'microcytic' : mcv > 100 ? 'macrocytic' : 'normocytic'}; 80–100)`, mch: `${f1(mch)} pg (27–33)`, mchc: `${f1(mchc)} g/dL (${mchc < 32 ? 'hypochromic' : mchc > 36 ? 'high' : 'normal'}; 32–36)` } };
    },

    tsat: (i) => {
        if (!ok(i.iron, i.tibc) || i.tibc <= 0) {
            return need('Enter serum iron and TIBC in the same unit.');
        }

        const t = (100 * i.iron) / i.tibc;

        return { value: `${f0(t)}%`, label: 'Transferrin saturation', sub: t < 20 ? 'Under 20%: suggests iron deficiency (check ferritin)' : t > 45 ? 'Over 45%: screen for iron overload (haemochromatosis) with a fasting repeat' : 'Within the usual 20–45%', rows: { formula: 'TSAT = serum iron ÷ TIBC × 100', note: 'Fasting morning samples are best, as iron varies through the day' } };
    },

    ipi: (i) => {
        if (!ok(i.age, i.ldh_ratio)) {
            return need('Enter age and the LDH ratio (result ÷ upper limit of normal).');
        }

        const stage = Number(i.stage) >= 3;
        const ecog = Number(i.ecog) >= 2;
        const ipi = (i.age > 60) + stage + (i.ldh_ratio > 1) + ecog + (or0(i.extranodal) > 1);
        const nccn = (i.age > 75 ? 3 : i.age > 60 ? 2 : i.age > 40 ? 1 : 0) + (i.ldh_ratio > 3 ? 2 : i.ldh_ratio > 1 ? 1 : 0) + stage + Boolean(i.major) + ecog;
        const ipiGroup = ipi <= 1 ? ['Low', '73%'] : ipi === 2 ? ['Low-intermediate', '51%'] : ipi === 3 ? ['High-intermediate', '43%'] : ['High', '26%'];
        const ripi = ipi === 0 ? ['Very good', '94%'] : ipi <= 2 ? ['Good', '79%'] : ['Poor', '55%'];
        const nccnGroup = nccn <= 1 ? ['Low', '96%'] : nccn <= 3 ? ['Low-intermediate', '82%'] : nccn <= 5 ? ['High-intermediate', '64%'] : ['High', '33%'];

        return {
            value: `IPI ${ipi}`,
            label: `International Prognostic Index: ${ipiGroup[0].toLowerCase()} risk`,
            sub: `R-IPI ${ripi[0].toLowerCase()}; NCCN-IPI ${nccn} (${nccnGroup[0].toLowerCase()})`,
            rows: { ipi: `${ipi} of 5: ${ipiGroup[0]} (5-year survival ${ipiGroup[1]} in the pre-rituximab cohort, Shipp 1993)`, ripi: `${ripi[0]} (4-year survival ${ripi[1]} with R-CHOP, Sehn 2007)`, nccn: `${nccn} of 8: ${nccnGroup[0]} (5-year survival ${nccnGroup[1]}, Zhou 2014)`, note: 'Group figures from studies, not a personal prediction; outcomes have improved with newer treatment' },
        };
    },

    mipi: (i) => {
        if (!ok(i.age, i.ldh_ratio, i.wbc) || i.ldh_ratio <= 0 || i.wbc <= 0) {
            return need('Enter age, LDH ratio and white cell count.');
        }

        const ecog = Number(i.ecog) >= 2;
        const score = 0.03535 * i.age + 0.6978 * ecog + 1.367 * Math.log10(i.ldh_ratio) + 0.9393 * Math.log10(i.wbc * 1000);
        const simple = (i.age >= 70 ? 3 : i.age >= 60 ? 2 : i.age >= 50 ? 1 : 0) + (ecog ? 2 : 0) + (i.ldh_ratio >= 1.5 ? 3 : i.ldh_ratio >= 1 ? 2 : i.ldh_ratio >= 0.67 ? 1 : 0) + (i.wbc >= 15 ? 3 : i.wbc >= 10 ? 2 : i.wbc >= 6.7 ? 1 : 0);
        const group = score < 5.7 ? 'Low risk (under 5.7)' : score < 6.2 ? 'Intermediate risk (5.7–6.2)' : 'High risk (6.2 or more)';

        return { value: f2(score), label: 'MIPI', sub: group, rows: { simple: `${simple} of 11: ${simple <= 3 ? 'low' : simple <= 5 ? 'intermediate' : 'high'} (simplified MIPI)`, survival: 'In the original cohort, median survival was not reached (low), 51 months (intermediate) and 29 months (high)', source: 'Hoster et al., Blood 2008; WBC entered as × 10⁹/L' } };
    },
};

export default defineTools(handlers);
