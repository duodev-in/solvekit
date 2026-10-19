import { defineTools } from '../engines/formula.js';
import { aceCategory, bmi, bmiCategory, brozek, BSA, deurenbergBodyFat, healthyRange, idealWeights, leanMass, navyBodyFat, siri, skinfoldDensity } from '../health/body.js';
import { normalCdf, ordinal, percentile, valueAt } from '../health/growth.js';

/**
 * Body measurements, BMI and growth percentiles. Unit fields arrive in base units: height in metres,
 * mass in grams (converted to kg here), circumferences in metres.
 */
const ok = (...values) => values.every(Number.isFinite);
const f1 = (x) => (Number.isFinite(x) ? x.toFixed(1) : '—');
const f2 = (x) => (Number.isFinite(x) ? x.toFixed(2) : '—');
const kgOf = (grams) => grams / 1000;
const kgLb = (kg) => `${f1(kg)} kg (${f1(kg * 2.20462)} lb)`;
const cmIn = (cm) => `${f1(cm)} cm (${f1(cm / 2.54)} in)`;
const band = (value, cuts) => cuts.find(([limit]) => value < limit)[1];

function needBody(i) {
    return ok(i.height, i.weight) && i.height > 0.3 && i.weight > 0 ? null : { empty: 'Enter height and weight.' };
}

/** Child's age in months from years and months fields. */
const ageMonths = (i) => (Number.isFinite(i.years) ? i.years : 0) * 12 + (Number.isFinite(i.months) ? i.months : 0);

/** CDC BMI-for-age category from the percentile (and severe obesity at ≥ 120% of the 95th). */
function childBmi(c, sexKey, months, value) {
    const rows = c.data.growth.cdc_bmi[sexKey];
    const p = percentile(rows, months, value);

    if (!p) {
        return null;
    }

    const p95 = valueAt(1.6448536, p.lms);
    const category = value >= 1.2 * p95 ? 'Severe obesity' : p.percentile >= 95 ? 'Obesity' : p.percentile >= 85 ? 'Overweight' : p.percentile >= 5 ? 'Healthy weight' : 'Underweight';

    return { ...p, category, p95 };
}

function adultBmiOutcome(i, c) {
    const empty = needBody(i);

    if (empty) {
        return empty;
    }

    const kg = kgOf(i.weight);
    const value = bmi(kg, i.height);
    const [low, high] = healthyRange(i.height, 18.5, 24.9);
    const asian = i.cutoffs === 'asian';
    const [aLow, aHigh] = healthyRange(i.height, 18.5, 22.9);

    return {
        value: f1(value),
        unit: 'kg/m²',
        label: 'BMI',
        sub: `${bmiCategory(value, { asian })}${asian ? ' (WHO cut-offs for Asian populations)' : ' (WHO)'}`,
        rows: {
            category: bmiCategory(value, { asian }),
            range: asian ? `${kgLb(aLow)} – ${kgLb(aHigh)} (BMI 18.5–22.9)` : `${kgLb(low)} – ${kgLb(high)} (BMI 18.5–24.9)`,
            change: value > (asian ? 22.9 : 24.9) ? `Lose ${kgLb(kg - (asian ? aHigh : high))} to reach the healthy range` : value < 18.5 ? `Gain ${kgLb(low - kg)} to reach the healthy range` : 'Within the healthy range',
            prime: `${f2(value / 25)} (BMI ÷ 25)`,
            note: c.sexNote ?? 'BMI does not tell fat from muscle; waist size adds information about health risk',
        },
    };
}

function childBmiOutcome(i, c) {
    const empty = needBody(i);
    const months = ageMonths(i);

    if (empty) {
        return empty;
    }

    if (!(months >= 24 && months <= 240.5)) {
        return { error: 'CDC BMI-for-age charts cover ages 2 to 20.' };
    }

    const sexKey = i.sex === 'female' ? 'female' : 'male';
    const value = bmi(kgOf(i.weight), i.height);
    const p = childBmi(c, sexKey, months, value);

    return {
        // One decimal, so a child at the 84.6th percentile is not shown as the 85th (the overweight cut-off).
        value: ordinal(p.percentile, 1),
        unit: 'percentile',
        label: 'BMI-for-age',
        sub: `BMI ${f1(value)} kg/m² for a ${sexKey === 'male' ? 'boy' : 'girl'} aged ${Math.floor(months / 12)} y ${Math.round(months % 12)} m: ${p.category}`,
        rows: {
            bmi: `${f1(value)} kg/m²`,
            category: p.category,
            z: f2(p.z),
            p85: `${f1(valueAt(1.0364334, p.lms))} kg/m² (85th percentile)`,
            p95: `${f1(p.p95)} kg/m² (95th percentile)`,
        },
    };
}

/** A growth percentile from WHO (under 24 months) or CDC (2–20 years) tables. */
function growthOutcome(i, c, measure) {
    const months = ageMonths(i);
    const sexKey = i.sex === 'female' ? 'female' : 'male';
    const g = c.data.growth;
    const value = measure === 'weight' ? kgOf(i.weight) : measure === 'head' ? i.head * 100 : i.height * 100;

    if (!ok(value) || value <= 0 || !(months >= 0)) {
        return { empty: 'Enter the age and the measurement.' };
    }

    const who = months < 24;
    const table = measure === 'weight' ? (who ? g.who_weight : g.cdc_weight) : measure === 'head' ? (who ? g.who_head : g.cdc_head_infant) : who ? g.who_length : g.cdc_stature;
    const p = percentile(table[sexKey], months, value);

    if (!p) {
        return { error: measure === 'head' ? 'Head circumference charts cover birth to 36 months.' : 'The charts cover birth to 20 years.' };
    }

    const unitText = measure === 'weight' ? kgLb(value) : cmIn(value);
    const label = { weight: 'Weight-for-age', head: 'Head circumference-for-age', height: who ? 'Length-for-age' : 'Height-for-age' }[measure];

    return {
        value: ordinal(p.percentile),
        unit: 'percentile',
        label,
        sub: `${unitText} at ${Math.floor(months / 12)} y ${Math.round(months % 12)} m (${who ? 'WHO 2006' : measure === 'head' ? 'CDC 2000 infant' : 'CDC 2000'} chart)`,
        rows: {
            z: f2(p.z),
            p50: `${measure === 'weight' ? kgLb(p.lms[1]) : cmIn(p.lms[1])} (median)`,
            range: `${measure === 'weight' ? kgLb(valueAt(-1.8807936, p.lms)) : cmIn(valueAt(-1.8807936, p.lms))} – ${measure === 'weight' ? kgLb(valueAt(1.8807936, p.lms)) : cmIn(valueAt(1.8807936, p.lms))} (3rd–97th)`,
            flag: p.percentile < 3 ? 'Below the 3rd percentile: worth discussing with your child\'s doctor' : p.percentile > 97 ? 'Above the 97th percentile: worth discussing with your child\'s doctor' : 'Within the 3rd–97th percentiles',
        },
    };
}

// FFIT body-shape rules (Lee et al. 2007), measurements in inches.
function bodyShape({ bust, waist, highHip, hips }) {
    if (bust - hips <= 1 && hips - bust < 3.6 && (bust - waist >= 9 || hips - waist >= 10)) {
        return 'Hourglass';
    }

    if (hips - bust >= 3.6 && hips - bust < 10 && hips - waist >= 9 && highHip / waist < 1.193) {
        return 'Bottom hourglass';
    }

    if (bust - hips > 1 && bust - hips < 10 && bust - waist >= 9) {
        return 'Top hourglass';
    }

    if (hips - bust > 2 && hips - waist >= 7 && highHip / waist >= 1.193) {
        return 'Spoon';
    }

    if (hips - bust >= 3.6 && hips - waist < 9) {
        return 'Triangle (pear)';
    }

    if (bust - hips >= 3.6 && bust - waist < 9) {
        return 'Inverted triangle';
    }

    return 'Rectangle';
}

export const handlers = {
    // The main BMI page shows child rows under their own keys (c_…) next to the adult rows.
    bmi: (i, c) => {
        if (i.mode !== 'child') {
            return adultBmiOutcome(i, c);
        }

        const outcome = childBmiOutcome(i, c);

        return outcome.rows ? { ...outcome, rows: Object.fromEntries(Object.entries(outcome.rows).map(([key, value]) => [`c_${key}`, value])) } : outcome;
    },
    bmi_child: childBmiOutcome,

    bmi_older: (i) => {
        const empty = needBody(i);

        if (empty) {
            return empty;
        }

        const value = bmi(kgOf(i.weight), i.height);
        // Older adults: lowest mortality around BMI 24–31 (Winter et al. 2014); ESPEN flags malnutrition below 20 (under 70) or 22 (70+).
        const lowCut = i.age >= 70 ? 22 : 20;
        const category = value < lowCut ? 'Underweight (malnutrition risk, ESPEN)' : value < 23 ? 'Low-normal: watch for weight loss' : value <= 30 ? 'Healthy range for older adults' : value < 35 ? 'Overweight to obesity' : 'Obesity';

        return {
            value: f1(value),
            unit: 'kg/m²',
            label: 'BMI',
            sub: category,
            rows: { category, range: `${kgLb(23 * i.height ** 2)} – ${kgLb(30 * i.height ** 2)} (BMI 23–30)`, standard: bmiCategory(value), note: 'Unplanned weight loss matters more than the number: tell a doctor about losing over 5% in 6 months' },
        };
    },

    bmi_loss: (i) => {
        const empty = needBody(i);

        if (empty) {
            return empty;
        }

        const kg = kgOf(i.weight);
        const now = bmi(kg, i.height);
        const target = i.target_bmi * i.height ** 2;

        if (!ok(i.target_bmi, i.deficit) || i.deficit <= 0) {
            return { empty: 'Enter a goal BMI and a daily calorie deficit.' };
        }

        if (target >= kg) {
            return { error: `A BMI of ${f1(i.target_bmi)} is ${kgLb(target)}, above your current weight.` };
        }

        // About 7,700 kcal per kg of body fat, a rule of thumb; real loss slows as weight falls.
        const weeks = ((kg - target) * 7700) / i.deficit / 7;

        return {
            value: `${f1(weeks)} weeks`,
            label: `To reach BMI ${f1(i.target_bmi)}`,
            sub: `From BMI ${f1(now)} (${kgLb(kg)}) to ${kgLb(target)} at ${Math.round(i.deficit)} kcal a day below maintenance`,
            rows: {
                lose: kgLb(kg - target),
                rate: `${f2((i.deficit * 7) / 7700)} kg (${f2((i.deficit * 7 * 2.20462) / 7700)} lb) a week`,
                b25: now > 25 ? `BMI 25 at ${kgLb(25 * i.height ** 2)}` : 'Already below BMI 25',
                safe: (i.deficit * 7) / 7700 > 1 ? 'Faster than the usual 0.5–1 kg a week guidance' : 'Within the usual 0.5–1 kg a week guidance',
                model: 'Rule of thumb: about 7,700 kcal per kg; loss usually slows over time',
            },
        };
    },

    absi: (i) => {
        const empty = needBody(i);

        if (empty || !ok(i.waist) || i.waist <= 0) {
            return empty ?? { empty: 'Enter the waist circumference.' };
        }

        const value = bmi(kgOf(i.weight), i.height);
        const absi = i.waist / (value ** (2 / 3) * i.height ** 0.5);

        return {
            value: absi.toFixed(4),
            label: 'A Body Shape Index',
            sub: `BMI ${f1(value)}, waist ${cmIn(i.waist * 100)}`,
            rows: { bmi: `${f1(value)} kg/m²`, meaning: 'Higher ABSI means more waist for a given height and BMI, linked with higher mortality in NHANES (Krakauer & Krakauer 2012)', typical: 'US adults average about 0.080–0.083; compare over time rather than against one cut-off' },
        };
    },

    adjusted_weight: (i) => {
        const empty = needBody(i);

        if (empty) {
            return empty;
        }

        const kg = kgOf(i.weight);
        const ibw = idealWeights(i.height * 100, i.sex).devine;
        const adjusted = kg > ibw ? ibw + 0.4 * (kg - ibw) : kg;

        return {
            value: kgLb(adjusted),
            label: 'Adjusted body weight',
            sub: `Ideal (Devine) ${kgLb(ibw)}; actual is ${Math.round((100 * kg) / ibw)}% of ideal`,
            rows: { ibw: kgLb(ibw), percent: `${Math.round((100 * kg) / ibw)}%`, use: kg > ibw * 1.2 ? 'Over 120% of ideal: adjusted weight is commonly used' : kg < ibw ? 'Below ideal: actual weight is used' : 'Within 120% of ideal: ideal or actual weight is commonly used' },
        };
    },

    bai: (i) => {
        if (!ok(i.hip, i.height) || i.hip <= 0 || i.height <= 0.3) {
            return { empty: 'Enter hip circumference and height.' };
        }

        const fat = (i.hip * 100) / i.height ** 1.5 - 18;

        return {
            value: `${f1(fat)}%`,
            label: 'Body adiposity index',
            sub: `Estimated body fat; ${aceCategory(fat, i.sex)} on the ACE scale`,
            rows: { formula: `${f1(i.hip * 100)} ÷ ${f2(i.height)}^1.5 − 18`, category: aceCategory(fat, i.sex), note: 'BAI was developed in Mexican-American and African-American adults; it can over- or underestimate in other groups' },
        };
    },

    body_fat: (i) => {
        const empty = needBody(i);

        if (empty) {
            return empty;
        }

        const kg = kgOf(i.weight);
        let fat;

        if (i.method === 'bmi') {
            if (!ok(i.age)) {
                return { empty: 'Enter your age.' };
            }

            fat = deurenbergBodyFat(bmi(kg, i.height), i.age, i.sex);
        } else {
            if (!ok(i.neck, i.waist) || (i.sex === 'female' && !ok(i.hip))) {
                return { empty: i.sex === 'female' ? 'Enter neck, waist and hip.' : 'Enter neck and waist.' };
            }

            fat = navyBodyFat({ sex: i.sex, height: i.height * 100, neck: i.neck * 100, waist: i.waist * 100, hip: (i.hip ?? 0) * 100 });
        }

        if (!Number.isFinite(fat) || fat <= 0 || fat >= 70) {
            return { error: 'These measurements give an impossible body fat; check that the waist is larger than the neck.' };
        }

        return {
            value: `${f1(fat)}%`,
            label: 'Body fat',
            sub: `${aceCategory(fat, i.sex)} (American Council on Exercise) by the ${i.method === 'bmi' ? 'BMI (Deurenberg)' : 'US Navy tape'} method`,
            rows: { fatMass: kgLb((kg * fat) / 100), lean: kgLb(kg * (1 - fat / 100)), category: aceCategory(fat, i.sex), method: i.method === 'bmi' ? 'Deurenberg et al. (1991): 1.2 × BMI + 0.23 × age − 10.8 × male − 5.4' : 'Hodgdon & Beckett (1984) US Navy circumference equations' },
        };
    },

    frame: (i) => {
        if (!ok(i.height, i.wrist) || i.wrist <= 0) {
            return { empty: 'Enter height and wrist circumference.' };
        }

        const r = i.height / i.wrist;
        const frame = i.sex === 'male' ? band(-r, [[-10.4, 'Small'], [-9.6, 'Medium'], [Infinity, 'Large']]) : band(-r, [[-11, 'Small'], [-10.1, 'Medium'], [Infinity, 'Large']]);

        return {
            value: frame,
            label: 'Body frame',
            sub: `Height ÷ wrist = ${f1(r)} (Grant 1980)`,
            rows: { ratio: f1(r), cutoffs: i.sex === 'male' ? 'Men: small > 10.4, medium 9.6–10.4, large < 9.6' : 'Women: small > 11.0, medium 10.1–11.0, large < 10.1', use: 'Frame size widens or narrows an ideal-weight range by about 10%' },
        };
    },

    body_shape: (i) => {
        const inch = (m) => (m * 100) / 2.54;

        if (!ok(i.bust, i.waist, i.high_hip, i.hips)) {
            return { empty: 'Enter bust, waist, high hip and hip.' };
        }

        const m = { bust: inch(i.bust), waist: inch(i.waist), highHip: inch(i.high_hip), hips: inch(i.hips) };

        return {
            value: bodyShape(m),
            label: 'Body shape',
            sub: `Bust ${f1(m.bust)} in, waist ${f1(m.waist)} in, hips ${f1(m.hips)} in (FFIT rules)`,
            rows: { bustHips: `${f1(m.bust - m.hips)} in`, hipsWaist: `${f1(m.hips - m.waist)} in`, bustWaist: `${f1(m.bust - m.waist)} in`, note: 'Shapes describe proportions for clothing fit, not health' },
        };
    },

    bri: (i) => {
        if (!ok(i.waist, i.height) || i.waist <= 0 || i.height <= 0.3) {
            return { empty: 'Enter waist and height.' };
        }

        const e = Math.sqrt(1 - (i.waist / (2 * Math.PI)) ** 2 / (0.5 * i.height) ** 2);
        const value = 364.2 - 365.5 * e;

        return {
            value: f2(value),
            label: 'Body Roundness Index',
            sub: value < 3.41 ? 'Below 3.41: higher mortality was seen at very low BRI' : value < 4.45 ? '3.41–4.45' : value <= 5.46 ? '4.45–5.46: the range with the lowest mortality' : value < 6.91 ? '5.46–6.91: moderately higher mortality' : '6.91 or more: highest mortality group',
            rows: { eccentricity: e.toFixed(3), study: 'Mortality groups from Zhang et al. (JAMA Netw Open 2024, NHANES 1999–2018)', formula: 'BRI = 364.2 − 365.5 × √(1 − (waist ÷ 2π)² ÷ (½ height)²) (Thomas 2013)' },
        };
    },

    bsa: (i) => {
        const empty = needBody(i);

        if (empty) {
            return empty;
        }

        const cm = i.height * 100;
        const kg = kgOf(i.weight);
        const names = { mosteller: 'Mosteller', dubois: 'DuBois & DuBois', haycock: 'Haycock', gehan: 'Gehan & George', boyd: 'Boyd' };
        const formula = BSA[i.formula] ? i.formula : 'mosteller';

        return {
            value: BSA[formula](cm, kg).toFixed(2),
            unit: 'm²',
            label: `Body surface area (${names[formula]})`,
            sub: `${f1(cm)} cm, ${f1(kg)} kg`,
            grids: { formulas: { columns: ['BSA (m²)'], rows: Object.entries(names).map(([key, name]) => ({ header: name, cells: [BSA[key](cm, kg).toFixed(3)], highlight: key === formula })) } },
        };
    },

    knee_height: (i) => {
        if (!ok(i.knee, i.age) || i.knee <= 0) {
            return { empty: 'Enter knee height and age.' };
        }

        const kh = i.knee * 100;
        // Chumlea, Roche & Steinbaugh (1985), ages 60–90.
        const cm = i.sex === 'male' ? 64.19 - 0.04 * i.age + 2.02 * kh : 84.88 - 0.24 * i.age + 1.83 * kh;

        return {
            value: cmIn(cm),
            label: 'Estimated height',
            sub: `From a knee height of ${cmIn(kh)} (Chumlea 1985)`,
            rows: { formula: i.sex === 'male' ? '64.19 − 0.04 × age + 2.02 × knee height' : '84.88 − 0.24 × age + 1.83 × knee height', error: 'About ± 4 cm for 95% of people', population: i.age < 60 ? 'Developed in adults aged 60–90; less accurate for younger people' : 'Adults aged 60–90' },
        };
    },

    ffmi: (i) => {
        const empty = needBody(i);

        if (empty) {
            return empty;
        }

        const kg = kgOf(i.weight);
        let fat = i.body_fat;

        if (i.mode === 'tape') {
            fat = navyBodyFat({ sex: i.sex, height: i.height * 100, neck: i.neck * 100, waist: i.waist * 100, hip: (i.hip ?? 0) * 100 });
        }

        if (!ok(fat) || fat <= 0 || fat >= 70) {
            return { empty: i.mode === 'tape' ? 'Enter neck and waist (and hip for women).' : 'Enter your body fat percentage.' };
        }

        const lean = kg * (1 - fat / 100);
        const ffmi = lean / i.height ** 2;
        const normalized = ffmi + 6.1 * (1.8 - i.height);
        const cuts = i.sex === 'male' ? [[18, 'Below average'], [20, 'Average'], [22, 'Above average'], [23, 'Excellent'], [26, 'Superior'], [Infinity, 'Very high (above most natural lifters)']] : [[15, 'Below average'], [17, 'Average'], [18, 'Above average'], [19, 'Excellent'], [22, 'Superior'], [Infinity, 'Very high']];

        return {
            value: f1(normalized),
            unit: 'kg/m²',
            label: 'Normalised FFMI',
            sub: `${band(normalized, cuts)}; FFMI ${f1(ffmi)} with ${f1(fat)}% body fat${i.mode === 'tape' ? ' (US Navy tape estimate)' : ''}`,
            rows: { ffmi: f1(ffmi), lean: kgLb(lean), fat: kgLb(kg - lean), band: band(normalized, cuts), kouri: i.sex === 'male' ? 'Kouri et al. (1995): about 25 was the upper limit seen in men not using steroids' : 'Bands for women are rougher conventions' },
        };
    },

    ideal_weight: (i) => {
        if (!ok(i.height) || i.height < 1.2) {
            return { empty: 'Enter a height above 120 cm (4 ft), the range the formulas were made for.' };
        }

        const w = idealWeights(i.height * 100, i.sex);
        const [low, high] = healthyRange(i.height);
        const frame = { small: 0.9, medium: 1, large: 1.1 }[i.frame] ?? 1;

        return {
            value: `${kgLb(Math.min(...Object.values(w)) * frame)} – ${kgLb(Math.max(...Object.values(w)) * frame)}`,
            label: 'Ideal weight (four formulas)',
            sub: `Healthy BMI range ${kgLb(low)} – ${kgLb(high)}${frame !== 1 ? `; adjusted ${frame < 1 ? '−' : '+'}10% for a ${i.frame} frame` : ''}`,
            grids: { formulas: { columns: ['Ideal weight'], rows: [['Devine (1974)', w.devine], ['Robinson (1983)', w.robinson], ['Miller (1983)', w.miller], ['Hamwi (1964)', w.hamwi]].map(([name, kg]) => ({ header: name, cells: [kgLb(kg * frame)] })).concat([{ header: 'BMI 18.5–24.9', cells: [`${kgLb(low)} – ${kgLb(high)}`] }]) } },
        };
    },

    lean_mass: (i) => {
        const empty = needBody(i);

        if (empty) {
            return empty;
        }

        const kg = kgOf(i.weight);
        const l = leanMass(i.height * 100, kg, i.sex);

        return {
            value: kgLb(l.boer),
            label: 'Lean body mass (Boer)',
            sub: `${f1((100 * l.boer) / kg)}% of body weight; body fat about ${f1(100 - (100 * l.boer) / kg)}%`,
            grids: { formulas: { columns: ['Lean mass', 'Body fat'], rows: [['Boer (1984)', l.boer], ['James (1976)', l.james], ['Hume (1966)', l.hume]].map(([name, lean]) => ({ header: name, cells: [kgLb(lean), `${f1(100 - (100 * lean) / kg)}%`] })) } },
        };
    },

    overweight: (i) => {
        const empty = needBody(i);

        if (empty) {
            return empty;
        }

        const kg = kgOf(i.weight);
        const value = bmi(kg, i.height);
        const [low, high] = healthyRange(i.height);
        const over = kg - high;

        return {
            value: over > 0 ? `${kgLb(over)} over` : kg < low ? `${kgLb(low - kg)} under` : 'In range',
            label: 'Compared with the healthy BMI range',
            sub: `BMI ${f1(value)}: ${bmiCategory(value)}`,
            rows: { range: `${kgLb(low)} – ${kgLb(high)}`, bmi: f1(value), obesity: value >= 30 ? `${kgLb(kg - 29.9 * i.height ** 2)} above the obesity threshold (BMI 30)` : `${kgLb(30 * i.height ** 2 - kg)} below the obesity threshold` },
        };
    },

    ponderal: (i) => {
        const empty = needBody(i);

        if (empty) {
            return empty;
        }

        const kg = kgOf(i.weight);
        const pi = kg / i.height ** 3;

        if (i.mode === 'newborn') {
            // Rohrer's index for newborns in g/cm³ × 100.
            const rohrer = ((kg * 1000) / (i.height * 100) ** 3) * 100;

            return { value: f2(rohrer), unit: 'g/cm³ × 100', label: 'Newborn ponderal index', sub: rohrer < 2 ? 'Below 2.0: thin for length (suggests restricted growth)' : rohrer > 3 ? 'Above 3.0: heavy for length' : 'Within the usual 2.0–3.0 range', rows: { si: `${f1(pi)} kg/m³`, note: 'Cut-offs vary with gestational age' } };
        }

        return { value: f1(pi), unit: 'kg/m³', label: 'Ponderal index', sub: pi < 11 ? 'Below 11: underweight for height' : pi > 15 ? 'Above 15: heavy for height' : 'Within the usual 11–15 range', rows: { si: `${f1(pi)} kg/m³`, note: 'Scales better than BMI for very tall or short people' } };
    },

    rfm: (i) => {
        if (!ok(i.height, i.waist) || i.waist <= 0) {
            return { empty: 'Enter height and waist.' };
        }

        const value = 64 - 20 * (i.height / i.waist) + (i.sex === 'female' ? 12 : 0);
        const cut = i.sex === 'female' ? 40 : 30;

        return {
            value: `${f1(value)}%`,
            label: 'Relative fat mass',
            sub: value >= cut ? `At or above ${cut}%, the obesity cut-off in the validation study` : `Below the ${cut}% obesity cut-off`,
            rows: { formula: `64 − 20 × height ÷ waist${i.sex === 'female' ? ' + 12' : ''}`, cutoff: `${cut}% (${i.sex === 'female' ? 'women' : 'men'}; Woolcott & Bergman 2018)` },
        };
    },

    skinfold: (i) => {
        const mm = (key) => Number.isFinite(i[key]) ? i[key] : NaN;
        const sites = {
            jp3: i.sex === 'male' ? ['chest', 'abdomen', 'thigh'] : ['triceps', 'suprailiac', 'thigh'],
            jp7: ['chest', 'midaxillary', 'triceps', 'subscapular', 'abdomen', 'suprailiac', 'thigh'],
            dw4: ['biceps', 'triceps', 'subscapular', 'suprailiac'],
        }[i.method] ?? [];
        const values = sites.map(mm);

        if (!ok(i.age) || values.some((v) => !Number.isFinite(v))) {
            return { empty: `Enter age and these skinfolds (mm): ${sites.join(', ')}.` };
        }

        const sum = values.reduce((a, b) => a + b, 0);
        const density = skinfoldDensity({ method: i.method, sex: i.sex, age: i.age, sum });
        const fat = siri(density);

        return {
            value: `${f1(fat)}%`,
            label: 'Body fat (Siri)',
            sub: `${aceCategory(fat, i.sex)}; sum of ${sites.length} skinfolds ${f1(sum)} mm`,
            rows: { density: `${density.toFixed(4)} g/cm³`, brozek: `${f1(brozek(density))}% (Brozek)`, sites: sites.join(', '), method: { jp3: 'Jackson & Pollock 3-site (1978, 1980)', jp7: 'Jackson & Pollock 7-site (1978, 1980)', dw4: 'Durnin & Womersley 4-site (1974)' }[i.method] },
        };
    },

    whr: (i) => {
        if (!ok(i.waist, i.hip) || i.hip <= 0) {
            return { empty: 'Enter waist and hip.' };
        }

        const r = i.waist / i.hip;
        const cut = i.sex === 'female' ? 0.85 : 0.9;

        return { value: f2(r), label: 'Waist-to-hip ratio', sub: r >= cut ? `At or above ${cut}: substantially increased risk (WHO 2008)` : `Below ${cut}: not increased (WHO 2008)`, rows: { cutoff: `${cut} for ${i.sex === 'female' ? 'women' : 'men'}`, shape: r >= cut ? 'Apple-shaped (more fat at the waist)' : 'Pear-shaped or even' } };
    },

    whtr: (i) => {
        if (!ok(i.waist, i.height) || i.height <= 0) {
            return { empty: 'Enter waist and height.' };
        }

        const r = i.waist / i.height;

        return {
            value: f2(r),
            label: 'Waist-to-height ratio',
            sub: r < 0.4 ? 'Below 0.4: take care, may be low' : r < 0.5 ? '0.4–0.49: healthy (NICE 2022)' : r < 0.6 ? '0.5–0.59: increased health risk' : '0.6 or more: high health risk',
            rows: { target: `Keep your waist under ${cmIn(50 * i.height)} (half your height)`, guideline: 'NICE (2022) adult guidance; the 0.5 boundary also applies to children over 5' },
        };
    },

    weight_loss: (i) => {
        const start = kgOf(i.start);
        const now = kgOf(i.current);

        if (!ok(start, now) || start <= 0) {
            return { empty: 'Enter the starting and current weight.' };
        }

        const pct = (100 * (start - now)) / start;
        const weeks = Number.isFinite(i.weeks) && i.weeks > 0 ? i.weeks : NaN;

        return {
            value: `${f1(pct)}%`,
            label: pct >= 0 ? 'Weight lost' : 'Weight gained',
            sub: `${kgLb(Math.abs(start - now))} ${pct >= 0 ? 'lost' : 'gained'}${Number.isFinite(weeks) ? ` over ${weeks} weeks` : ''}`,
            rows: { perWeek: Number.isFinite(weeks) ? `${kgLb(Math.abs(start - now) / weeks)} a week (${f2(pct / weeks)}% a week)` : 'Enter weeks for a weekly rate', milestone: pct >= 5 ? '5% or more: the amount linked with better blood pressure, glucose and lipids' : `${kgLb(start * 0.05 - (start - now))} more to reach 5%`, ten: pct >= 10 ? '10% or more reached' : `10% is ${kgLb(start * 0.9)}` },
        };
    },

    draw_length: (i) => {
        if (!ok(i.span) || i.span <= 0) {
            return { empty: 'Enter your arm span.' };
        }

        const inches = (i.span * 100) / 2.54 / 2.5;

        return { value: `${f1(inches)} in`, label: 'Draw length', sub: `${f1(inches * 2.54)} cm from an arm span of ${cmIn(i.span * 100)} (span ÷ 2.5)`, rows: { bow: inches < 26 ? 'Look at youth or short-draw bows' : 'Most adult bows adjust to this draw', check: 'Confirm at an archery shop: draw length depends on form and anchor point' } };
    },

    face_shape: (i) => {
        const { length, forehead, cheek, jaw } = i;

        if (!ok(length, forehead, cheek, jaw) || cheek <= 0) {
            return { empty: 'Enter face length and the three widths.' };
        }

        const ratio = length / cheek;
        let shape;

        if (ratio >= 1.5) {
            shape = 'Oblong';
        } else if (forehead >= cheek * 0.95 && jaw >= cheek * 0.95) {
            shape = ratio > 1.25 ? 'Rectangle' : 'Square';
        } else if (forehead > cheek * 0.98 && forehead > jaw * 1.15) {
            shape = 'Heart';
        } else if (cheek > forehead * 1.1 && cheek > jaw * 1.1) {
            shape = 'Diamond';
        } else {
            shape = ratio < 1.25 ? 'Round' : 'Oval';
        }

        return { value: shape, label: 'Face shape', sub: `Length is ${f2(ratio)} × the cheekbone width`, rows: { ratio: f2(ratio), widths: `Forehead ${f1(forehead * 100)} cm, cheekbones ${f1(cheek * 100)} cm, jaw ${f1(jaw * 100)} cm`, note: 'A stylists\' rule of thumb, not a measurement standard' } };
    },

    karvonen: (i) => {
        if (!ok(i.age, i.rest) || i.age <= 0 || i.rest <= 0) {
            return { empty: 'Enter your age and resting heart rate.' };
        }

        const max = i.max_formula === 'tanaka' ? 208 - 0.7 * i.age : 220 - i.age;
        const reserve = max - i.rest;
        const at = (pct) => Math.round(reserve * pct / 100 + i.rest);
        const pct = ok(i.intensity) ? i.intensity : 70;

        return {
            value: `${at(pct)} bpm`,
            label: `Target heart rate at ${pct}%`,
            sub: `Max ${Math.round(max)} bpm (${i.max_formula === 'tanaka' ? 'Tanaka 208 − 0.7 × age' : '220 − age'}), reserve ${Math.round(reserve)} bpm`,
            rows: { max: `${Math.round(max)} bpm`, reserve: `${Math.round(reserve)} bpm`, moderate: `${at(40)}–${at(59)} bpm (moderate, 40–59% of reserve, ACSM)`, vigorous: `${at(60)}–${at(89)} bpm (vigorous, 60–89%)` },
            grids: { zones: { columns: ['Heart rate', 'Effort'], rows: [[50, 60, 'Zone 1, very light'], [60, 70, 'Zone 2, light'], [70, 80, 'Zone 3, moderate'], [80, 90, 'Zone 4, hard'], [90, 100, 'Zone 5, maximum']].map(([a, b, name]) => ({ header: `${a}–${b}%`, cells: [`${at(a)}–${at(b)} bpm`, name], highlight: pct >= a && pct < b })) } },
        };
    },

    height_percentile: (i, c) => growthOutcome(i, c, 'height'),
    weight_percentile: (i, c) => growthOutcome(i, c, 'weight'),
    head_percentile: (i, c) => growthOutcome(i, c, 'head'),

    baby_percentile: (i, c) => {
        const results = [['Weight', 'weight', i.weight], ['Length', 'height', i.height], ['Head', 'head', i.head]].filter(([, , v]) => ok(v) && v > 0).map(([name, key]) => [name, growthOutcome(i, c, key)]);

        if (!results.length || ageMonths(i) > 24) {
            return ageMonths(i) > 24 ? { error: 'The WHO baby charts cover birth to 24 months; use the Height or Weight Percentile Calculator for older children.' } : { empty: 'Enter the age and at least one measurement.' };
        }

        const first = results[0][1];

        return {
            value: first.value,
            unit: 'percentile',
            label: `${results[0][0]}-for-age`,
            sub: results.map(([name, r]) => `${name}: ${r.value ?? '—'}`).join(' · '),
            grids: { all: { columns: ['Percentile', 'Z-score'], rows: results.map(([name, r]) => ({ header: name, cells: [r.value ?? '—', r.rows?.z ?? '—'] })) } },
        };
    },

    fetal_weight: (i) => {
        const ga = (Number.isFinite(i.weeks) ? i.weeks : NaN) + (Number.isFinite(i.days) ? i.days : 0) / 7;
        let efw = i.efw;

        if (i.mode === 'biometry') {
            // Hadlock (1985) four-parameter estimate, measurements in cm.
            const [hc, ac, fl, bpd] = [i.hc, i.ac, i.fl, i.bpd].map((m) => m * 100);
            efw = 10 ** (1.3596 - 0.00386 * ac * fl + 0.0064 * hc + 0.00061 * bpd * ac + 0.0424 * ac + 0.174 * fl);
        }

        if (!ok(ga, efw) || ga < 10 || ga > 41 || efw <= 0) {
            return { empty: 'Enter gestational age (10–41 weeks) and the estimated fetal weight or the four measurements.' };
        }

        // Hadlock (1991) in utero standard: ln(median) = 0.578 + 0.332 GA − 0.00354 GA², SD 12.7% of the median.
        const median = Math.exp(0.578 + 0.332 * ga - 0.00354 * ga * ga);
        const z = (efw - median) / (0.127 * median);
        const p = 100 * normalCdf(z);

        return {
            value: ordinal(p),
            unit: 'percentile',
            label: 'Estimated fetal weight',
            sub: `${Math.round(efw)} g at ${Math.floor(ga)} weeks ${Math.round((ga % 1) * 7)} days; median ${Math.round(median)} g (Hadlock 1991)`,
            rows: { efw: `${Math.round(efw)} g (${f2(efw / 453.59237)} lb)`, median: `${Math.round(median)} g`, size: p < 10 ? 'Below the 10th percentile: small for gestational age' : p > 90 ? 'Above the 90th percentile: large for gestational age' : 'Appropriate for gestational age (10th–90th)', note: 'Ultrasound estimates are typically within ± 10–15% of the true weight' },
        };
    },

    iq_percentile: (i) => {
        if (!ok(i.iq)) {
            return { empty: 'Enter an IQ score.' };
        }

        const sd = Number(i.sd) || 15;
        const z = (i.iq - 100) / sd;
        const p = 100 * normalCdf(z);
        const rarity = z >= 0 ? 1 / (1 - normalCdf(z)) : 1 / normalCdf(z);

        return {
            value: ordinal(p),
            unit: 'percentile',
            label: `IQ ${Math.round(i.iq)}`,
            sub: `Higher than ${p.toFixed(p > 99 || p < 1 ? 2 : 1)}% of people (mean 100, SD ${sd})`,
            rows: { z: f2(z), rarity: `About 1 in ${Math.round(rarity).toLocaleString('en-US')} people score ${z >= 0 ? 'this high or higher' : 'this low or lower'}`, range: i.iq >= 130 ? 'Very superior (130+)' : i.iq >= 120 ? 'Superior (120–129)' : i.iq >= 110 ? 'High average (110–119)' : i.iq >= 90 ? 'Average (90–109)' : i.iq >= 80 ? 'Low average (80–89)' : i.iq >= 70 ? 'Borderline (70–79)' : 'Extremely low (below 70)' },
        };
    },

    adult_height: (i) => {
        const father = i.father * 100;
        const mother = i.mother * 100;

        if (!ok(father, mother) || father <= 0 || mother <= 0) {
            return { empty: 'Enter both parents\' heights.' };
        }

        // Tanner mid-parental height: (father + mother ± 13 cm) ÷ 2, with about ± 8.5 cm covering 95% of children.
        const target = (father + mother + (i.sex === 'male' ? 13 : -13)) / 2;

        return {
            value: cmIn(target),
            label: 'Predicted adult height',
            sub: `95% of children end up within ${cmIn(target - 8.5)} – ${cmIn(target + 8.5)}`,
            rows: { method: 'Mid-parental height (Tanner 1970): average of the parents, plus 6.5 cm for boys or minus 6.5 cm for girls', range: `${cmIn(target - 8.5)} – ${cmIn(target + 8.5)}`, feet: `${Math.floor(target / 2.54 / 12)} ft ${Math.round((target / 2.54) % 12)} in` },
        };
    },
};

export default defineTools(handlers);
