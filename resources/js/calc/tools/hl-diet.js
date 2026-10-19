import { defineTools } from '../engines/formula.js';
import { ACTIVITY, BMR } from '../health/body.js';
import { ANALYTES, fromConventional, toConventional } from '../health/labs.js';
import { parseAmount } from '../food/kitchen.js';
import { parseRows } from '../rows-editor.js';

/**
 * Energy, macronutrients, Dietary Reference Intakes, vitamins, diabetes and lipid calculations.
 * Height arrives in metres, mass in grams; lab values come with their own unit menus.
 */
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
const f0 = (x) => (Number.isFinite(x) ? Math.round(x).toLocaleString('en-US') : '—');
const f1 = (x) => (Number.isFinite(x) ? x.toFixed(1) : '—');
const f2 = (x) => (Number.isFinite(x) ? x.toFixed(2) : '—');
const kcal = (x) => `${f0(x)} kcal`;
const kgOf = (g) => g / 1000;
const lab = (i, name, analyte) => toConventional(i[name], analyte, i[`${name}_unit`]);

function profile(i) {
    const kg = kgOf(i.weight);
    const cm = i.height * 100;

    return ok(kg, cm, i.age) && kg > 0 && cm > 50 && i.age > 0 ? { kg, cm, age: i.age, sex: i.sex === 'female' ? 'female' : 'male' } : null;
}

const needProfile = { empty: 'Enter height, weight, age and sex.' };

/** Total daily energy expenditure from Mifflin–St Jeor (or another BMR formula) and an activity factor. */
export function tdee(p, activity = 'moderate', formula = 'mifflin', lean = NaN) {
    const bmr = formula === 'katch' ? BMR.katch({ lean }) : BMR[formula](p);

    return { bmr, tdee: bmr * (ACTIVITY[activity] ?? ACTIVITY.moderate)[0] };
}

/** IOM (2005) Estimated Energy Requirement, kcal/day. */
export function eer({ age, sex, kg, cm, pa = 'low' }) {
    const m = cm / 100;
    const level = { sedentary: 0, low: 1, active: 2, very: 3 }[pa] ?? 1;

    if (age >= 19) {
        const c = sex === 'male' ? [1, 1.11, 1.25, 1.48][level] : [1, 1.12, 1.27, 1.45][level];

        return sex === 'male' ? 662 - 9.53 * age + c * (15.91 * kg + 539.6 * m) : 354 - 6.91 * age + c * (9.36 * kg + 726 * m);
    }

    const c = sex === 'male' ? [1, 1.13, 1.26, 1.42][level] : [1, 1.16, 1.31, 1.56][level];
    const deposit = age >= 9 ? 25 : 20;

    return sex === 'male' ? 88.5 - 61.9 * age + c * (26.7 * kg + 903 * m) + deposit : 135.3 - 30.8 * age + c * (10 * kg + 934 * m) + deposit;
}

const SPLITS = {
    balanced: { name: 'Balanced (AMDR midpoints)', protein: 20, carbs: 50, fat: 30 },
    lowcarb: { name: 'Lower carb', protein: 30, carbs: 25, fat: 45 },
    highprotein: { name: 'Higher protein', protein: 35, carbs: 40, fat: 25 },
    endurance: { name: 'Endurance training', protein: 20, carbs: 60, fat: 20 },
};

function macroRows(calories, split) {
    const g = (pct, per) => (calories * pct) / 100 / per;

    return {
        protein: `${f0(g(split.protein, 4))} g (${split.protein}%, ${kcal((calories * split.protein) / 100)})`,
        carbs: `${f0(g(split.carbs, 4))} g (${split.carbs}%)`,
        fat: `${f0(g(split.fat, 9))} g (${split.fat}%)`,
        meals: `${f0(g(split.protein, 4) / 3)} g protein, ${f0(g(split.carbs, 4) / 3)} g carbs and ${f0(g(split.fat, 9) / 3)} g fat in each of 3 meals`,
    };
}

const GOALS = { lose_fast: [-1000, 'Lose about 1 kg (2 lb) a week'], lose: [-500, 'Lose about 0.5 kg (1 lb) a week'], lose_slow: [-250, 'Lose about 0.25 kg (½ lb) a week'], keep: [0, 'Maintain weight'], gain: [250, 'Gain about 0.25 kg a week'], gain_fast: [500, 'Gain about 0.5 kg a week'] };

/** DRI life stage for an age (years) and sex or pregnancy/lactation. */
export function driStage(age, sex, state) {
    if (state === 'pregnancy' || state === 'lactation') {
        return [state, age < 19 ? '14-18 y' : age < 31 ? '19-30 y' : '31-50 y'];
    }

    if (age < 0.5) {
        return ['infants', '0-6 mo'];
    }

    if (age < 1) {
        return ['infants', '7-12 mo'];
    }

    if (age < 9) {
        return ['children', age < 4 ? '1-3 y' : '4-8 y'];
    }

    const group = sex === 'female' ? 'females' : 'males';
    const stage = age < 14 ? '9-13 y' : age < 19 ? '14-18 y' : age < 31 ? '19-30 y' : age < 51 ? '31-50 y' : age < 71 ? '51-70 y' : '>70 y';

    return [group, stage];
}

function driValue(n, kind, group, stage) {
    return n[kind]?.[group]?.[stage] ?? [null, false];
}

const VITAMINS = ['vitamin_a', 'vitamin_c', 'vitamin_d', 'vitamin_e', 'vitamin_k', 'thiamin', 'riboflavin', 'niacin', 'vitamin_b6', 'folate', 'vitamin_b12', 'pantothenic_acid', 'biotin', 'choline'];
const MINERALS = ['calcium', 'chromium', 'copper', 'fluoride', 'iodine', 'iron', 'magnesium', 'manganese', 'molybdenum', 'phosphorus', 'selenium', 'zinc', 'potassium', 'sodium', 'chloride'];

function driGrid(c, keys, group, stage) {
    const nutrients = c.data.dri.nutrients;

    return {
        columns: ['Daily target', 'Upper limit'],
        rows: keys.filter((k) => nutrients[k]).map((key) => {
            const n = nutrients[key];
            const [value, ai] = driValue(n, 'rda', group, stage);
            const [ul] = driValue(n, 'ul', group, stage);
            const unit = n.unit.replace('/day', '');

            return { header: n.name, cells: [value === null ? 'Not set' : `${value.toLocaleString('en-US')} ${unit}${ai ? ' (AI)' : ''}`, ul === null ? 'Not set' : `${ul.toLocaleString('en-US')} ${unit}`] };
        }),
    };
}

const stageText = (group, stage) => `${{ infants: 'Infants', children: 'Children', males: 'Males', females: 'Females', pregnancy: 'Pregnancy', lactation: 'Lactation' }[group]} ${stage}`;

export const handlers = {
    bmr: (i) => {
        const p = profile(i);

        if (!p) {
            return needProfile;
        }

        const lean = ok(i.body_fat) ? p.kg * (1 - i.body_fat / 100) : NaN;
        const formula = i.formula in BMR ? i.formula : 'mifflin';

        if (formula === 'katch' && !ok(lean)) {
            return { empty: 'Enter body fat % for the Katch–McArdle formula.' };
        }

        const value = formula === 'katch' ? BMR.katch({ lean }) : BMR[formula](p);
        const names = { mifflin: 'Mifflin–St Jeor (1990)', harris: 'Harris–Benedict, revised (Roza & Shizgal 1984)', harrisOriginal: 'Harris–Benedict, original (1919)', katch: 'Katch–McArdle' };
        const rows = Object.entries(names).filter(([key]) => key !== 'katch' || ok(lean)).map(([key, name]) => ({ header: name, cells: [kcal(key === 'katch' ? BMR.katch({ lean }) : BMR[key](p))], highlight: key === formula }));

        return {
            value: f0(value),
            unit: 'kcal/day',
            label: 'Basal metabolic rate',
            sub: `${names[formula]}: energy at complete rest`,
            rows: Object.fromEntries(Object.entries(ACTIVITY).map(([key, [factor, name]]) => [key, `${kcal(value * factor)} (${name.split(' (')[0].toLowerCase()}, × ${factor})`])),
            grids: { formulas: { columns: ['BMR'], rows } },
        };
    },

    // Harris–Benedict BMR with daily needs; the guided mode picks the activity factor from three questions.
    harris: (i) => {
        const p = profile(i);

        if (!p) {
            return needProfile;
        }

        const bmr = BMR[i.formula === 'harrisOriginal' ? 'harrisOriginal' : 'harris'](p);
        let activity = i.activity in ACTIVITY ? i.activity : 'moderate';

        if (i.mode === 'guided') {
            const points = ({ desk: 0, standing: 1, manual: 2 }[i.job] ?? 0) + ({ none: 0, few: 1, most: 2, daily: 3 }[i.days] ?? 0) + ({ easy: 0, moderate: 1, hard: 2 }[i.intensity] ?? 0);
            activity = points <= 1 ? 'sedentary' : points <= 3 ? 'light' : points <= 4 ? 'moderate' : points <= 5 ? 'active' : 'extra';
        }

        const [factor, name] = ACTIVITY[activity];

        return {
            value: f0(bmr),
            unit: 'kcal/day',
            label: 'Basal metabolic rate',
            sub: `${i.formula === 'harrisOriginal' ? 'Original Harris–Benedict (1919)' : 'Revised Harris–Benedict (Roza & Shizgal 1984)'}; ${kcal(bmr * factor)} a day at your activity`,
            rows: { tdee: `${kcal(bmr * factor)} (× ${factor}, ${name.toLowerCase()})`, activity: name, lose: `${kcal(bmr * factor - 500)} to lose about 0.5 kg a week`, mifflin: `${kcal(BMR.mifflin(p))} by Mifflin–St Jeor, usually closer to measured BMR` },
        };
    },

    lab_convert: (i) => {
        const analyte = ANALYTES[i.analyte] ? i.analyte : 'glucose';
        // The page converts SI (mmol/L, µmol/L) to conventional units or back.
        const units = Object.keys(ANALYTES[analyte].units);
        const unit = i.direction === 'from_si' ? units[1] : units[0];

        if (!ok(i.value) || i.value < 0) {
            return { empty: 'Enter a value.' };
        }

        const base = toConventional(i.value, analyte, unit);
        const others = Object.keys(ANALYTES[analyte].units).filter((u) => u !== unit);

        return {
            value: `${f2(fromConventional(base, analyte, others[0]))} ${others[0]}`,
            label: ANALYTES[analyte].name,
            sub: `${i.value} ${unit} = ${others.map((u) => `${f2(fromConventional(base, analyte, u))} ${u}`).join(' = ')}`,
            rows: { factor: `1 ${Object.keys(ANALYTES[analyte].units).find((u) => ANALYTES[analyte].units[u] !== 1) ?? unit} = ${f2(Object.values(ANALYTES[analyte].units).find((v) => v !== 1) ?? 1)} ${ANALYTES[analyte].base}`, note: 'Molar conversions use the analyte\'s molar mass' },
            grids: { all: { columns: ['Value'], rows: Object.keys(ANALYTES[analyte].units).map((u) => ({ header: u, cells: [f2(fromConventional(base, analyte, u))], highlight: u === unit })) } },
        };
    },

    tdee: (i) => {
        const p = profile(i);

        if (!p) {
            return needProfile;
        }

        const { bmr, tdee: total } = tdee(p, i.activity);

        return {
            value: f0(total),
            unit: 'kcal/day',
            label: 'Total daily energy expenditure',
            sub: `BMR ${kcal(bmr)} (Mifflin–St Jeor) × ${ACTIVITY[i.activity]?.[0] ?? 1.55} for ${(ACTIVITY[i.activity] ?? ACTIVITY.moderate)[1].toLowerCase()}`,
            rows: { bmr: kcal(bmr), lose: `${kcal(total - 500)} to lose about 0.5 kg (1 lb) a week`, gain: `${kcal(total + 300)} for a slow gain`, minimum: p.sex === 'female' ? 'Do not go below about 1,200 kcal without medical supervision' : 'Do not go below about 1,500 kcal without medical supervision' },
            grids: { levels: { columns: ['Calories a day'], rows: Object.entries(ACTIVITY).map(([key, [factor, name]]) => ({ header: name, cells: [kcal(bmr * factor)], highlight: key === i.activity })) } },
        };
    },

    calories: (i) => {
        const p = profile(i);

        if (!p) {
            return needProfile;
        }

        const { tdee: total } = tdee(p, i.activity);
        const goal = GOALS[i.goal] ?? GOALS.keep;
        const floor = p.sex === 'female' ? 1200 : 1500;
        const target = Math.max(total + goal[0], goal[0] < 0 ? floor : 0);

        return {
            value: f0(target),
            unit: 'kcal/day',
            label: goal[1],
            sub: `Maintenance ${kcal(total)} (Mifflin–St Jeor × activity)${target > total + goal[0] ? `; raised to the ${kcal(floor)} minimum` : ''}`,
            rows: { maintenance: kcal(total), change: `${goal[0] > 0 ? '+' : ''}${f0(goal[0])} kcal a day`, minimum: `${kcal(floor)} (do not go lower without medical supervision)`, note: 'Estimates are within about ± 10% for most people; adjust by watching your weight over 2–4 weeks' },
            grids: { goals: { columns: ['Calories a day'], rows: Object.entries(GOALS).map(([key, [delta, name]]) => ({ header: name, cells: [kcal(Math.max(total + delta, delta < 0 ? floor : 0))], highlight: key === i.goal })) } },
        };
    },

    simple_intake: (i) => {
        const kg = kgOf(i.weight);

        if (!ok(kg) || kg <= 0) {
            return { empty: 'Enter your weight.' };
        }

        const perKg = { low: 25, moderate: 30, high: 35 }[i.level] ?? 30;

        return { value: f0(kg * perKg), unit: 'kcal/day', label: 'Calorie intake', sub: `${perKg} kcal per kg of body weight (simple rule)`, rows: { range: `${kcal(kg * 25)} – ${kcal(kg * 35)} (25–35 kcal/kg)`, rule: 'A clinical rule of thumb; the Calorie Calculator uses height, age and sex as well' } };
    },

    deficit: (i) => {
        const p = profile(i);
        const goal = kgOf(i.goal_weight);

        if (!p || !ok(goal)) {
            return p ? { empty: 'Enter your goal weight.' } : needProfile;
        }

        const { tdee: total } = tdee(p, i.activity);
        const weeks = ok(i.weeks) && i.weeks > 0 ? i.weeks : NaN;

        if (!Number.isFinite(weeks)) {
            return { empty: 'Enter the number of weeks.' };
        }

        const deficit = ((p.kg - goal) * 7700) / (weeks * 7);
        const target = total - deficit;
        const floor = p.sex === 'female' ? 1200 : 1500;

        if (goal >= p.kg) {
            return { error: 'The goal weight must be below your current weight.' };
        }

        return {
            value: f0(Math.max(target, floor)),
            unit: 'kcal/day',
            label: `To reach ${f1(goal)} kg in ${f0(weeks)} weeks`,
            sub: `A deficit of ${kcal(deficit)} a day below maintenance (${kcal(total)})${target < floor ? `; that is below the ${kcal(floor)} minimum, so allow more time` : ''}`,
            rows: { deficit: kcal(deficit), rate: `${f2((p.kg - goal) / weeks)} kg a week`, safe: (p.kg - goal) / weeks > 1 ? 'Faster than the usual 0.5–1 kg a week' : 'Within the usual 0.5–1 kg a week', weeksAt500: `${f0(((p.kg - goal) * 7700) / 3500)} weeks at a 500 kcal deficit` },
        };
    },

    gain: (i) => {
        const p = profile(i);
        const goal = kgOf(i.goal_weight);

        if (!p || !ok(goal, i.weeks) || i.weeks <= 0) {
            return p ? { empty: 'Enter the goal weight and weeks.' } : needProfile;
        }

        const { tdee: total } = tdee(p, i.activity);
        const surplus = ((goal - p.kg) * 7700) / (i.weeks * 7);

        return {
            value: f0(total + surplus),
            unit: 'kcal/day',
            label: 'Calories to gain weight',
            sub: `Maintenance ${kcal(total)} + ${kcal(surplus)} a day`,
            rows: { surplus: kcal(surplus), rate: `${f2((goal - p.kg) / i.weeks)} kg a week`, protein: `${f0(p.kg * 1.6)}–${f0(p.kg * 2.2)} g protein a day with strength training (ISSN)`, pace: (goal - p.kg) / i.weeks > 0.5 ? 'Faster than about 0.25–0.5 kg a week adds more fat than muscle' : 'A steady pace for adding muscle' },
        };
    },

    eer: (i) => {
        const p = profile(i);

        if (!p) {
            return needProfile;
        }

        if (p.age < 3) {
            return { error: 'These EER equations start at age 3.' };
        }

        const base = eer({ ...p, pa: i.pa });
        const extra = { none: 0, preg2: 340, preg3: 452, lact1: 330, lact2: 400 }[i.state] ?? 0;

        return {
            value: f0(base + extra),
            unit: 'kcal/day',
            label: 'Estimated Energy Requirement',
            sub: `IOM (2005) equation for a ${p.age}-year-old ${p.sex}${extra ? `, + ${extra} kcal for pregnancy or lactation` : ''}`,
            rows: { base: kcal(base), extra: extra ? `+${extra} kcal` : 'None', levels: ['sedentary', 'low', 'active', 'very'].map((pa) => `${pa}: ${kcal(eer({ ...p, pa }) + extra)}`).join(' · ') },
        };
    },

    macros: (i) => {
        const p = profile(i);

        if (!p) {
            return needProfile;
        }

        const { tdee: total } = tdee(p, i.activity);
        const goal = GOALS[i.goal] ?? GOALS.keep;
        const calories = Math.max(total + goal[0], goal[0] < 0 ? (p.sex === 'female' ? 1200 : 1500) : 0);
        const split = SPLITS[i.split] ?? SPLITS.balanced;

        return {
            value: f0(calories),
            unit: 'kcal/day',
            label: `${split.name}, ${goal[1].toLowerCase()}`,
            sub: `${f0((calories * split.protein) / 400)} g protein, ${f0((calories * split.carbs) / 400)} g carbs, ${f0((calories * split.fat) / 900)} g fat`,
            rows: macroRows(calories, split),
        };
    },

    iifym: (i) => {
        const p = profile(i);

        if (!p) {
            return needProfile;
        }

        const { tdee: total } = tdee(p, i.activity);
        const goal = GOALS[i.goal] ?? GOALS.keep;
        const calories = Math.max(total + goal[0], goal[0] < 0 ? (p.sex === 'female' ? 1200 : 1500) : 0);
        const protein = p.kg * (ok(i.protein_g) ? i.protein_g : 1.8);
        const fat = (calories * (ok(i.fat_pct) ? i.fat_pct : 25)) / 100 / 9;
        const carbs = (calories - protein * 4 - fat * 9) / 4;

        if (carbs < 0) {
            return { error: 'Protein and fat already exceed the calories; lower one of them.' };
        }

        return {
            value: f0(calories),
            unit: 'kcal/day',
            label: 'Your macros',
            sub: `${f0(protein)} g protein · ${f0(carbs)} g carbs · ${f0(fat)} g fat`,
            rows: { protein: `${f0(protein)} g (${f1((protein * 4 * 100) / calories)}%)`, carbs: `${f0(carbs)} g (${f1((carbs * 4 * 100) / calories)}%)`, fat: `${f0(fat)} g (${f1((fat * 9 * 100) / calories)}%)`, meals: `${f0(protein / 4)} g protein in each of 4 meals` },
        };
    },

    keto: (i) => {
        const p = profile(i);

        if (!p) {
            return needProfile;
        }

        const { tdee: total } = tdee(p, i.activity);
        const calories = Math.max(total + ((GOALS[i.goal] ?? GOALS.lose)[0]), p.sex === 'female' ? 1200 : 1500);
        const carbs = ok(i.carbs) ? i.carbs : 25;
        const protein = p.kg * (ok(i.protein_g) ? i.protein_g : 1.2);
        const fat = (calories - carbs * 4 - protein * 4) / 9;

        return {
            value: `${f0(fat)} g fat`,
            label: 'Keto macros',
            sub: `${kcal(calories)}: ${f0(carbs)} g net carbs, ${f0(protein)} g protein, ${f0(fat)} g fat`,
            rows: { carbs: `${f0(carbs)} g (${f1((carbs * 400) / calories)}%)`, protein: `${f0(protein)} g (${f1((protein * 400) / calories)}%)`, fat: `${f0(fat)} g (${f1((fat * 900) / calories)}%)`, note: 'Ketogenic diets usually keep net carbs under 20–50 g; talk to a doctor if you take diabetes or blood-pressure medicine' },
        };
    },

    carbs: (i) => {
        if (!ok(i.calories) || i.calories <= 0) {
            return { empty: 'Enter your daily calories.' };
        }

        const pct = ok(i.percent) ? i.percent : 50;

        return { value: `${f0((i.calories * pct) / 400)} g`, label: 'Carbohydrate a day', sub: `${pct}% of ${kcal(i.calories)} (4 kcal a gram)`, rows: { amdr: `${f0((i.calories * 0.45) / 4)}–${f0((i.calories * 0.65) / 4)} g (45–65%, IOM AMDR)`, rda: '130 g a day minimum for brain glucose (IOM RDA, adults)', meals: `${f0((i.calories * pct) / 400 / 3)} g in each of 3 meals` } };
    },

    fat: (i) => {
        if (!ok(i.calories) || i.calories <= 0) {
            return { empty: 'Enter your daily calories.' };
        }

        const pct = ok(i.percent) ? i.percent : 30;

        return { value: `${f0((i.calories * pct) / 900)} g`, label: 'Fat a day', sub: `${pct}% of ${kcal(i.calories)} (9 kcal a gram)`, rows: { amdr: `${f0((i.calories * 0.2) / 9)}–${f0((i.calories * 0.35) / 9)} g (20–35%, IOM AMDR)`, saturated: `Under ${f0((i.calories * 0.1) / 9)} g saturated fat (less than 10%, Dietary Guidelines)`, trans: 'As little trans fat as possible' } };
    },

    fiber: (i, c) => {
        if (!ok(i.age) || i.age <= 0) {
            return { empty: 'Enter your age.' };
        }

        const [group, stage] = driStage(i.age, i.sex, i.state);
        const [ai] = driValue(c.data.dri.nutrients.total_fiber, 'rda', group, stage);
        const per = ok(i.calories) && i.calories > 0 ? (i.calories * 14) / 1000 : NaN;

        return {
            value: ai === null ? 'Not set' : `${f0(ai)} g`,
            label: 'Fibre a day (Adequate Intake)',
            sub: `${stageText(group, stage)}: 14 g per 1,000 kcal (NASEM)`,
            rows: { perCalories: Number.isFinite(per) ? `${f0(per)} g for ${kcal(i.calories)}` : 'Enter calories for 14 g per 1,000 kcal', sources: 'A cup of cooked lentils has about 15 g, a pear 5–6 g, a slice of whole-wheat bread about 2 g (USDA)', tip: 'Increase slowly and drink water' },
        };
    },

    protein: (i) => {
        const kg = kgOf(i.weight);

        if (!ok(kg) || kg <= 0) {
            return { empty: 'Enter your weight.' };
        }

        const ranges = { rda: [0.8, 0.8, 'Healthy adult, little exercise (RDA)'], active: [1.2, 1.6, 'Regular exercise'], strength: [1.6, 2.2, 'Building muscle (ISSN)'], older: [1.0, 1.2, 'Adults over 65 (PROT-AGE)'], pregnant: [1.1, 1.1, 'Pregnancy, 2nd and 3rd trimester (RDA)'] };
        const [low, high, name] = ranges[i.goal] ?? ranges.rda;

        return {
            value: low === high ? `${f0(kg * low)} g` : `${f0(kg * low)}–${f0(kg * high)} g`,
            label: 'Protein a day',
            sub: `${name}: ${low === high ? low : `${low}–${high}`} g per kg`,
            rows: { perMeal: `${f0((kg * high) / 4)} g in each of 4 meals`, rda: `${f0(kg * 0.8)} g (RDA, 0.8 g/kg)`, kidney: 'People with kidney disease should follow their care team\'s protein advice' },
            grids: { goals: { columns: ['g/kg', 'Protein'], rows: Object.entries(ranges).map(([key, [a, b, n]]) => ({ header: n, cells: [a === b ? String(a) : `${a}–${b}`, a === b ? `${f0(kg * a)} g` : `${f0(kg * a)}–${f0(kg * b)} g`], highlight: key === i.goal })) } },
        };
    },

    net_carbs: (i) => {
        if (!ok(i.carbs)) {
            return { empty: 'Enter total carbohydrate.' };
        }

        const net = i.carbs - or0(i.fiber) - 0.5 * or0(i.sugar_alcohol) - or0(i.allulose);
        const servings = ok(i.servings) && i.servings > 0 ? i.servings : 1;

        return { value: `${f1(Math.max(0, net))} g`, label: 'Net carbs per serving', sub: `${f1(i.carbs)} − ${f1(or0(i.fiber))} fibre − ½ × ${f1(or0(i.sugar_alcohol))} sugar alcohols`, rows: { pack: `${f1(Math.max(0, net) * servings)} g in ${servings} servings`, note: 'Net carbs are a labelling convention, not an FDA-defined term; erythritol is often subtracted in full' } };
    },

    added_sugar: (i) => {
        const items = parseRows(i.items).map(([name, grams, count]) => ({ name, grams: parseAmount(grams), count: parseAmount(count) || 1 })).filter((x) => x.name && Number.isFinite(x.grams));

        if (!items.length) {
            return { empty: 'Add foods or drinks with their grams of added sugar (on the Nutrition Facts label).' };
        }

        const total = items.reduce((sum, x) => sum + x.grams * x.count, 0);
        const limit = i.sex === 'male' ? 36 : 25;
        const calories = ok(i.calories) && i.calories > 0 ? i.calories : 2000;
        const pct = (total * 4 * 100) / calories;

        return {
            value: `${f0(total)} g`,
            label: 'Added sugar today',
            sub: `${f1(pct)}% of ${kcal(calories)}; about ${f1(total / 4.2)} teaspoons`,
            rows: { aha: `${total > limit ? 'Above' : 'Within'} the AHA limit of ${limit} g (${i.sex === 'male' ? 'men' : 'women'})`, who: `${pct >= 10 ? 'Above' : 'Within'} the WHO limit of 10% of energy (${f0(calories * 0.1 / 4)} g); 5% (${f0(calories * 0.05 / 4)} g) gives extra benefit`, dga: `Dietary Guidelines: less than 10% of calories (${f0(calories * 0.1 / 4)} g)` },
            grids: { items: { columns: ['Added sugar'], rows: items.map((x) => ({ header: `${x.count > 1 ? `${x.count} × ` : ''}${x.name}`, cells: [`${f1(x.grams * x.count)} g`] })) } },
        };
    },

    dri: (i, c) => {
        if (!ok(i.age) || i.age < 0) {
            return { empty: 'Enter age.' };
        }

        const [group, stage] = driStage(i.age, i.sex, i.state);
        const keys = c.only === 'vitamins' ? VITAMINS : c.only === 'minerals' ? MINERALS : [...VITAMINS, ...MINERALS, 'total_water', 'carbohydrate', 'total_fiber', 'protein'];
        const water = driValue(c.data.dri.nutrients.total_water, 'rda', group, stage)[0];

        return {
            value: stageText(group, stage),
            label: 'Life-stage group',
            sub: c.only === 'vitamins' ? 'Recommended Dietary Allowances (or Adequate Intakes, AI) and upper limits for each vitamin' : `Daily targets from the NASEM tables; total water ${water ?? '—'} L a day from drinks and food`,
            rows: { group: stageText(group, stage), ai: 'AI = Adequate Intake, used when there is not enough evidence for an RDA', ul: 'Upper limit: the most per day unlikely to cause harm; for some nutrients it applies to supplements only' },
            grids: { table: driGrid(c, keys, group, stage) },
        };
    },

    micronutrients: (i, c) => {
        const nutrients = c.data.dri.nutrients;
        const [group, stage] = driStage(ok(i.age) ? i.age : 30, i.sex, i.state);
        const rows = parseRows(i.items).map(([name, amount]) => {
            const key = Object.keys(nutrients).find((k) => nutrients[k].name.toLowerCase() === String(name ?? '').toLowerCase()) ?? Object.keys(nutrients).find((k) => nutrients[k].name.toLowerCase().includes(String(name ?? '').toLowerCase()));

            return { name, key, amount: parseAmount(amount) };
        }).filter((r) => r.key && Number.isFinite(r.amount));

        if (!rows.length) {
            return { empty: 'Add nutrients and the amount you take in (in the units shown).' };
        }

        const lines = rows.map((r) => {
            const n = nutrients[r.key];
            const [target, ai] = driValue(n, 'rda', group, stage);
            const [ul] = driValue(n, 'ul', group, stage);
            const pct = target ? (100 * r.amount) / target : NaN;

            return { n, r, target, ai, ul, pct, over: ul !== null && r.amount > ul };
        });
        const low = lines.filter((l) => l.pct < 100);
        const over = lines.filter((l) => l.over);

        return {
            value: `${lines.length - low.length} of ${lines.length}`,
            label: 'Nutrients meeting the target',
            sub: over.length ? `Above the upper limit: ${over.map((l) => l.n.name).join(', ')}` : low.length ? `Below target: ${low.map((l) => l.n.name).join(', ')}` : 'All entered nutrients meet their targets',
            rows: { group: stageText(group, stage), over: over.length ? over.map((l) => `${l.n.name} (${l.r.amount} vs UL ${l.ul})`).join('; ') : 'None above the upper limit' },
            grids: { table: { columns: ['Intake', 'Target', '% of target'], rows: lines.map((l) => ({ header: l.n.name, cells: [`${l.r.amount} ${l.n.unit.replace('/day', '')}`, l.target === null ? 'Not set' : `${l.target}${l.ai ? ' (AI)' : ''}`, Number.isFinite(l.pct) ? `${f0(l.pct)}%` : '—'], highlight: l.over })) } },
        };
    },

    vitamin_a: (i) => {
        if (!ok(i.amount) || i.amount < 0) {
            return { empty: 'Enter an amount.' };
        }

        // NIH ODS: 1 IU = 0.3 µg RAE (retinol), 0.15 (supplemental beta-carotene), 0.05 (dietary beta-carotene), 0.025 (other provitamin A carotenoids).
        const factor = { retinol: 0.3, beta_supp: 0.15, beta_food: 0.05, other: 0.025 }[i.form] ?? 0.3;
        const rae = i.unit === 'iu' ? i.amount * factor : i.amount;
        const iu = i.unit === 'iu' ? i.amount : i.amount / factor;

        return {
            value: i.unit === 'iu' ? `${f0(rae)} µg RAE` : `${f0(iu)} IU`,
            label: 'Vitamin A',
            sub: `${f0(iu)} IU = ${f0(rae)} µg RAE as ${{ retinol: 'retinol', beta_supp: 'supplemental beta-carotene', beta_food: 'beta-carotene in food', other: 'other carotenoids in food' }[i.form] ?? 'retinol'}`,
            rows: { rda: `${f0((100 * rae) / (i.sex === 'female' ? 700 : 900))}% of the adult RDA (${i.sex === 'female' ? 700 : 900} µg RAE)`, ul: i.form === 'retinol' ? `${rae > 3000 ? 'Above' : 'Within'} the 3,000 µg upper limit for preformed vitamin A` : 'The upper limit applies to preformed vitamin A (retinol), not beta-carotene', pregnancy: 'High-dose retinol supplements are not advised in pregnancy' },
        };
    },

    vitamin_d: (i) => {
        if (!ok(i.amount) || i.amount < 0) {
            return { empty: 'Enter an amount.' };
        }

        const mcg = i.unit === 'iu' ? i.amount / 40 : i.amount;
        const rda = ok(i.age) && i.age > 70 ? 20 : 15;

        return {
            value: i.unit === 'iu' ? `${f1(mcg)} µg` : `${f0(mcg * 40)} IU`,
            label: 'Vitamin D',
            sub: `${f0(mcg * 40)} IU = ${f1(mcg)} µg (1 µg = 40 IU)`,
            rows: { rda: `${f0((100 * mcg) / rda)}% of the RDA (${rda} µg = ${rda * 40} IU${rda === 20 ? ', over 70' : ', ages 1–70'})`, ul: `${mcg > 100 ? 'Above' : 'Within'} the 100 µg (4,000 IU) adult upper limit`, sun: 'Sunlight and blood levels vary a lot; a 25(OH)D blood test shows status' },
        };
    },

    mcg_iu: (i) => {
        if (!ok(i.amount) || i.amount < 0) {
            return { empty: 'Enter an amount.' };
        }

        // NIH ODS conversion factors: µg per IU (vitamin E in mg per IU).
        const factors = { vitamin_d: [0.025, 'µg'], vitamin_a: [0.3, 'µg RAE'], beta_carotene: [0.15, 'µg RAE'], vitamin_e_natural: [0.67, 'mg'], vitamin_e_synthetic: [0.45, 'mg'] };
        const [factor, unit] = factors[i.vitamin] ?? factors.vitamin_d;
        const value = i.direction === 'to_iu' ? i.amount / factor : i.amount * factor;

        return { value: i.direction === 'to_iu' ? `${f1(value)} IU` : `${value >= 100 ? f0(value) : f2(value)} ${unit}`, label: 'Converted amount', sub: `1 IU = ${factor} ${unit}`, rows: { factor: `1 IU = ${factor} ${unit} (NIH Office of Dietary Supplements)`, note: 'IU conversions depend on the form, so check the label for the exact compound' } };
    },

    fish_oil: (i) => {
        const per = or0(i.epa) + or0(i.dha);

        if (per <= 0) {
            return { empty: 'Enter EPA and DHA per serving from the label.' };
        }

        const daily = per * (ok(i.servings) ? i.servings : 1);

        return { value: `${f0(daily)} mg`, label: 'EPA + DHA a day', sub: `${f0(per)} mg a serving × ${ok(i.servings) ? i.servings : 1}`, rows: { efsa: `${daily >= 250 ? 'Meets' : 'Below'} EFSA's 250 mg a day for healthy adults`, aha: 'AHA: about 1 g a day of EPA + DHA for people with heart disease, under medical guidance', fda: `${daily > 5000 ? 'Above' : 'Within'} the 5 g a day the FDA considers safe from supplements`, food: 'Two servings of oily fish a week give roughly 250–500 mg a day' } };
    },

    sodium_salt: (i) => {
        if (!ok(i.amount) || i.amount <= 0) {
            return { empty: 'Enter an amount.' };
        }

        // Sodium chloride is 39.34% sodium by weight; a level teaspoon of table salt is about 6 g (label).
        const saltG = i.unit === 'tsp' ? i.amount * 6 : i.unit === 'sodium_mg' ? i.amount / 393.4 : i.amount;
        const sodium = saltG * 393.4;

        return { value: i.unit === 'sodium_mg' ? `${f1(saltG)} g salt` : `${f0(sodium)} mg sodium`, label: i.unit === 'sodium_mg' ? 'Salt' : 'Sodium', sub: `${f1(saltG)} g of salt = ${f0(sodium)} mg sodium (salt is 39.3% sodium)`, rows: { fda: `${f0((100 * sodium) / 2300)}% of the 2,300 mg daily value (FDA)`, who: `${sodium > 2000 ? 'Above' : 'Within'} WHO's under-2,000 mg (5 g salt) a day`, tsp: `${f1(saltG / 6)} teaspoons of table salt` } };
    },

    water_intake: (i, c) => {
        const kg = kgOf(i.weight);

        if (!ok(i.age) || i.age <= 0) {
            return { empty: 'Enter your age.' };
        }

        const [group, stage] = driStage(i.age, i.sex, i.state);
        const total = driValue(c.data.dri.nutrients.total_water, 'rda', group, stage)[0];
        const exercise = (or0(i.exercise) / 60) * 0.75;
        const hot = i.climate === 'hot' ? 0.5 : 0;
        // About 80% of total water comes from drinks and 20% from food.
        const drinks = total * 0.8 + exercise + hot;

        return {
            value: `${f1(drinks)} L`,
            label: 'Water from drinks a day',
            sub: `About ${f1(drinks / 0.2366)} cups; total water AI ${total} L (${stageText(group, stage)}, NASEM) of which about 80% comes from drinks`,
            rows: { total: `${total} L a day (drinks + food)`, exercise: exercise ? `+${f1(exercise)} L for ${f0(i.exercise)} min of exercise` : 'None added', climate: hot ? '+0.5 L for hot weather' : 'Temperate', perKg: Number.isFinite(kg) && kg > 0 ? `${f0((drinks * 1000) / kg)} ml per kg of body weight` : '—', check: 'Pale yellow urine is a simple sign of good hydration' },
        };
    },

    // Diabetes ------------------------------------------------------------------------------------
    glucose: (i) => {
        const mg = lab(i, 'value', 'glucose');

        if (!ok(mg) || mg <= 0) {
            return { empty: 'Enter a blood glucose value.' };
        }

        const context = i.context ?? 'fasting';
        const bands = { fasting: [[70, 'Low (hypoglycaemia below 70 mg/dL)'], [100, 'Normal fasting'], [126, 'Prediabetes range (100–125)'], [Infinity, 'Diabetes range (126 or more, confirm with a repeat test)']], ogtt: [[70, 'Low'], [140, 'Normal 2-hour value'], [200, 'Prediabetes range (140–199)'], [Infinity, 'Diabetes range (200 or more)']], random: [[70, 'Low'], [200, 'Not diagnostic on its own'], [Infinity, '200 or more with symptoms suggests diabetes']] }[context];

        return {
            value: i.value_unit === 'mmol/L' ? `${f0(mg)} mg/dL` : `${f1(mg / 18.016)} mmol/L`,
            label: 'Blood glucose',
            sub: bands.find(([limit]) => mg < limit)[1],
            rows: { mgdl: `${f0(mg)} mg/dL`, mmol: `${f1(mg / 18.016)} mmol/L`, ada: 'ADA Standards of Care diagnostic thresholds' },
        };
    },

    a1c: (i) => {
        let a1c = i.a1c_unit === 'mmol/mol' ? i.a1c / 10.929 + 2.15 : i.a1c;

        if (i.mode === 'from_glucose') {
            const mg = lab(i, 'avg', 'glucose');
            a1c = (mg + 46.7) / 28.7;
        }

        if (!ok(a1c) || a1c <= 0) {
            return { empty: i.mode === 'from_glucose' ? 'Enter the average glucose.' : 'Enter the A1c.' };
        }

        const eag = 28.7 * a1c - 46.7;
        const band = a1c < 5.7 ? 'Normal (below 5.7%)' : a1c < 6.5 ? 'Prediabetes (5.7–6.4%)' : 'Diabetes range (6.5% or more, confirm with a repeat test)';

        return {
            value: i.mode === 'from_glucose' ? `${f1(a1c)}%` : `${f0(eag)} mg/dL`,
            label: i.mode === 'from_glucose' ? 'Estimated A1c' : 'Estimated average glucose',
            sub: `A1c ${f1(a1c)}% (${f0((a1c - 2.15) * 10.929)} mmol/mol) ≈ average glucose ${f0(eag)} mg/dL (${f1(eag / 18.016)} mmol/L): ${band}`,
            rows: { eag: `${f0(eag)} mg/dL (${f1(eag / 18.016)} mmol/L)`, ifcc: `${f0((a1c - 2.15) * 10.929)} mmol/mol`, band, target: 'Many adults with diabetes aim for below 7% (ADA); targets are individual' },
        };
    },

    eag: (i) => {
        const a1c = i.a1c_unit === 'mmol/mol' ? i.a1c / 10.929 + 2.15 : i.a1c;

        if (!ok(a1c) || a1c <= 0) {
            return { empty: 'Enter the A1c.' };
        }

        const eag = 28.7 * a1c - 46.7;

        return { value: `${f0(eag)} mg/dL`, label: 'Estimated average glucose', sub: `${f1(eag / 18.016)} mmol/L from an A1c of ${f1(a1c)}% (ADAG study)`, rows: { eag: `${f0(eag)} mg/dL (${f1(eag / 18.016)} mmol/L)`, ifcc: `${f0((a1c - 2.15) * 10.929)} mmol/mol`, band: a1c < 5.7 ? 'Normal' : a1c < 6.5 ? 'Prediabetes' : 'Diabetes range', ci: 'In the ADAG study the 95% range around each estimate was about ± 25 mg/dL at 7%' } };
    },

    homa: (i) => {
        const mg = lab(i, 'glucose', 'glucose');
        const insulin = toConventional(i.insulin, 'insulin', i.insulin_unit);

        if (!ok(mg, insulin) || mg <= 0 || insulin <= 0) {
            return { empty: 'Enter fasting glucose and fasting insulin.' };
        }

        const mmol = mg / 18.016;
        const ir = (mmol * insulin) / 22.5;
        const beta = mmol > 3.5 ? (20 * insulin) / (mmol - 3.5) : NaN;

        return { value: f2(ir), label: 'HOMA-IR', sub: ir < 1 ? 'Below 1: insulin sensitive' : ir < 2 ? '1–2: usual range' : ir < 2.9 ? '2–2.9: early insulin resistance likely' : '2.9 or more: insulin resistance likely', rows: { beta: Number.isFinite(beta) ? `${f0(beta)}% (β-cell function, HOMA-%B)` : 'Needs fasting glucose above 3.5 mmol/L', formula: 'Glucose (mmol/L) × insulin (µU/mL) ÷ 22.5 (Matthews 1985)', note: 'Cut-offs vary between populations and insulin assays' } };
    },

    quicki: (i) => {
        const mg = lab(i, 'glucose', 'glucose');
        const insulin = toConventional(i.insulin, 'insulin', i.insulin_unit);

        if (!ok(mg, insulin) || mg <= 0 || insulin <= 0) {
            return { empty: 'Enter fasting glucose and fasting insulin.' };
        }

        const q = 1 / (Math.log10(insulin) + Math.log10(mg));

        return { value: q.toFixed(3), label: 'QUICKI', sub: q >= 0.357 ? 'Similar to healthy adults (about 0.37 ± 0.03)' : q >= 0.33 ? 'Lower than typical: some insulin resistance' : 'Low: insulin resistance likely', rows: { formula: '1 ÷ (log insulin µU/mL + log glucose mg/dL) (Katz 2000)', reference: 'Katz et al. reported about 0.366 in non-obese adults, 0.331 in obese and 0.304 in diabetes' } };
    },

    gl: (i, c) => {
        const foods = parseRows(i.items).map(([name, gi, carbs, servings]) => ({ name, gi: parseAmount(gi), carbs: parseAmount(carbs), servings: parseAmount(servings) || 1 })).filter((f) => f.name && ok(f.gi, f.carbs));

        if (!foods.length) {
            return { empty: 'Add foods with their GI and available carbohydrate per serving.' };
        }

        const total = foods.reduce((sum, f) => sum + (f.gi * f.carbs * f.servings) / 100, 0);
        const carbs = foods.reduce((sum, f) => sum + f.carbs * f.servings, 0);
        const gi = (100 * total) / carbs;

        return {
            value: f0(total),
            label: c.mode === 'gi' ? 'Glycemic load of the meal' : 'Glycemic load',
            sub: c.mode === 'gi' ? `Meal glycemic index ${f0(gi)} (${gi <= 55 ? 'low' : gi < 70 ? 'medium' : 'high'}) over ${f0(carbs)} g carbohydrate` : `${total <= 10 ? 'Low' : total < 20 ? 'Medium' : 'High'} (low ≤ 10, high ≥ 20 per meal)`,
            rows: { gi: `${f0(gi)} (low ≤ 55, high ≥ 70)`, carbs: `${f0(carbs)} g`, day: 'A daily total under about 80 is low and over 120 high' },
            grids: { foods: { columns: ['GI', 'Carbs', 'GL'], rows: foods.map((f) => ({ header: f.name, cells: [f0(f.gi), `${f0(f.carbs * f.servings)} g`, f1((f.gi * f.carbs * f.servings) / 100)] })) } },
        };
    },

    warsaw: (i) => {
        if (!ok(i.fat, i.protein) || i.fat < 0 || i.protein < 0) {
            return { empty: 'Enter fat and protein in grams.' };
        }

        const fpu = (9 * i.fat + 4 * i.protein) / 100;
        const hours = fpu < 1 ? 0 : fpu < 2 ? 3 : fpu < 3 ? 4 : fpu < 4 ? 5 : 8;

        return { value: `${f1(fpu)} FPU`, label: 'Fat-protein units', sub: `${f0(9 * i.fat + 4 * i.protein)} kcal from fat and protein; 1 FPU = 100 kcal`, rows: { carbs: `Counted like ${f0(fpu * 10)} g carbohydrate in the Warsaw method`, duration: hours ? `Extended over about ${hours} hours` : 'Under 1 FPU: usually not counted', care: 'Use only as agreed with your diabetes team; this page does not give insulin doses' } };
    },

    dka: (i) => {
        const mg = lab(i, 'glucose', 'glucose');

        if (!ok(mg, i.ph, i.hco3) || !ok(i.na, i.cl)) {
            return { empty: 'Enter glucose, pH, bicarbonate, sodium and chloride.' };
        }

        const ag = i.na - (i.cl + i.hco3);
        const meets = mg > 250 && i.ph <= 7.3 && i.hco3 <= 18 && i.ketones;
        // ADA 2009 consensus (Kitabchi et al.): severity by pH, bicarbonate and mental status.
        const severity = !meets ? 'Does not meet DKA criteria' : i.ph < 7 || i.hco3 < 10 || i.mental === 'stupor' ? 'Severe DKA' : i.ph < 7.25 || i.hco3 < 15 || i.mental === 'drowsy' ? 'Moderate DKA' : 'Mild DKA';

        return {
            value: severity,
            label: 'DKA classification',
            sub: `Glucose ${f0(mg)} mg/dL, pH ${i.ph}, bicarbonate ${i.hco3} mEq/L, anion gap ${f0(ag)}`,
            rows: { ag: `${f0(ag)} mEq/L (${ag > 12 ? 'raised' : ag > 10 ? 'borderline' : 'normal'})`, criteria: `Glucose > 250 ${mg > 250 ? '✓' : '✗'} · pH ≤ 7.30 ${i.ph <= 7.3 ? '✓' : '✗'} · HCO₃ ≤ 18 ${i.hco3 <= 18 ? '✓' : '✗'} · ketones ${i.ketones ? '✓' : '✗'}`, urgent: 'Suspected DKA is a medical emergency: seek care immediately', source: 'ADA consensus statement (Kitabchi et al., Diabetes Care 2009)' },
        };
    },

    // Lipids --------------------------------------------------------------------------------------
    chol_units: (i) => {
        const analyte = i.analyte === 'triglycerides' ? 'triglycerides' : 'cholesterol';

        if (!ok(i.value) || i.value <= 0) {
            return { empty: 'Enter a value.' };
        }

        const mg = toConventional(i.value, analyte, i.unit);

        return { value: i.unit === 'mmol/L' ? `${f0(mg)} mg/dL` : `${f2(mg / ANALYTES[analyte].units['mmol/L'])} mmol/L`, label: ANALYTES[analyte].name, sub: `${f0(mg)} mg/dL = ${f2(fromConventional(mg, analyte, 'mmol/L'))} mmol/L`, rows: { factor: analyte === 'triglycerides' ? '1 mmol/L = 88.57 mg/dL' : '1 mmol/L = 38.67 mg/dL', note: 'HDL, LDL and total cholesterol use the same factor' } };
    },

    chol_ratio: (i) => {
        const tc = lab(i, 'tc', 'cholesterol');
        const hdl = lab(i, 'hdl', 'cholesterol');
        const tg = lab(i, 'tg', 'triglycerides');

        if (!ok(tc, hdl) || hdl <= 0) {
            return { empty: 'Enter total and HDL cholesterol.' };
        }

        const ldl = ok(i.ldl) ? lab(i, 'ldl', 'cholesterol') : tc - hdl - (ok(tg) ? tg / 5 : NaN);
        const ratio = tc / hdl;

        return {
            value: f1(ratio),
            label: 'Total / HDL cholesterol ratio',
            sub: ratio < 3.5 ? 'Below 3.5: ideal' : ratio < 5 ? '3.5–5: acceptable' : '5 or more: higher risk',
            rows: { nonHdl: `${f0(tc - hdl)} mg/dL non-HDL (${tc - hdl < 130 ? 'desirable, under 130' : 'above 130'})`, ldlHdl: Number.isFinite(ldl) ? `${f1(ldl / hdl)} LDL / HDL (lower is better; under 2.5 is often used)` : 'Add LDL or triglycerides', tgHdl: ok(tg) ? `${f1(tg / hdl)} TG / HDL (above 3 suggests insulin resistance, mg/dL)` : 'Add triglycerides', note: 'Ratios add context; treatment decisions use LDL and overall cardiovascular risk' },
        };
    },

    ldl: (i) => {
        const tc = lab(i, 'tc', 'cholesterol');
        const hdl = lab(i, 'hdl', 'cholesterol');
        const tg = lab(i, 'tg', 'triglycerides');

        if (!ok(tc, hdl, tg)) {
            return { empty: 'Enter total cholesterol, HDL and triglycerides.' };
        }

        const friedewald = tc - hdl - tg / 5;
        const nonHdl = tc - hdl;
        // Sampson et al. (JAMA Cardiol 2020), NIH equation 2.
        const sampson = tc / 0.948 - hdl / 0.971 - (tg / 8.56 + (tg * nonHdl) / 2140 - (tg * tg) / 16100) - 9.44;
        const use = tg > 400 ? sampson : friedewald;
        const band = (x) => (x < 100 ? 'Optimal (under 100)' : x < 130 ? 'Near optimal (100–129)' : x < 160 ? 'Borderline high (130–159)' : x < 190 ? 'High (160–189)' : 'Very high (190 or more)');

        return {
            value: `${f0(use)} mg/dL`,
            label: tg > 400 ? 'LDL cholesterol (Sampson)' : 'LDL cholesterol (Friedewald)',
            sub: `${f2(use / 38.67)} mmol/L: ${band(use)}`,
            rows: { friedewald: tg > 400 ? 'Not valid with triglycerides above 400 mg/dL' : `${f0(friedewald)} mg/dL`, sampson: `${f0(sampson)} mg/dL (valid to 800 mg/dL triglycerides)`, nonHdl: `${f0(nonHdl)} mg/dL`, band: band(use) },
        };
    },

    vldl: (i) => {
        const tg = lab(i, 'tg', 'triglycerides');

        if (!ok(tg) || tg <= 0) {
            return { empty: 'Enter triglycerides.' };
        }

        const vldl = tg / 5;

        return { value: `${f0(vldl)} mg/dL`, label: 'VLDL cholesterol (estimate)', sub: `${f2(vldl / 38.67)} mmol/L: ${vldl < 30 ? 'within the usual 2–30 mg/dL' : 'above 30 mg/dL'}`, rows: { formula: 'Triglycerides ÷ 5 (mg/dL), Friedewald', limit: tg > 400 ? 'Not reliable with triglycerides above 400 mg/dL' : 'Valid for triglycerides up to 400 mg/dL' } };
    },

    metsyn: (i) => {
        const tg = lab(i, 'tg', 'triglycerides');
        const hdl = lab(i, 'hdl', 'cholesterol');
        const glucose = lab(i, 'glucose', 'glucose');
        const waist = i.waist * 100;

        if (!ok(tg, hdl, glucose, waist, i.sbp, i.dbp)) {
            return { empty: 'Enter waist, triglycerides, HDL, blood pressure and fasting glucose.' };
        }

        // Harmonised definition (Alberti et al., Circulation 2009) with population-specific waist cut-offs.
        const cut = { us: [102, 88], europid: [94, 80], asian: [90, 80] }[i.population] ?? [102, 88];
        const female = i.sex === 'female';
        const criteria = [
            ['Waist', waist >= (female ? cut[1] : cut[0]), `${f0(waist)} cm (≥ ${female ? cut[1] : cut[0]})`],
            ['Triglycerides', tg >= 150 || i.tg_treat, `${f0(tg)} mg/dL (≥ 150 or treated)`],
            ['HDL', hdl < (female ? 50 : 40) || i.hdl_treat, `${f0(hdl)} mg/dL (< ${female ? 50 : 40} or treated)`],
            ['Blood pressure', i.sbp >= 130 || i.dbp >= 85 || i.bp_treat, `${i.sbp}/${i.dbp} mmHg (≥ 130/85 or treated)`],
            ['Fasting glucose', glucose >= 100 || i.glucose_treat, `${f0(glucose)} mg/dL (≥ 100 or treated)`],
        ];
        const met = criteria.filter((x) => x[1]).length;

        return {
            value: `${met} of 5`,
            label: 'Criteria met',
            sub: met >= 3 ? 'Meets the definition of metabolic syndrome (3 or more)' : 'Does not meet the definition (fewer than 3)',
            rows: { result: met >= 3 ? 'Metabolic syndrome' : 'Not metabolic syndrome', source: 'Harmonised definition (IDF, AHA/NHLBI and others; Alberti 2009)' },
            grids: { criteria: { columns: ['Met', 'Value'], rows: criteria.map(([name, yes, text]) => ({ header: name, cells: [yes ? 'Yes' : 'No', text], highlight: yes })) } },
        };
    },

    activity_rows: (i, c) => {
        const kg = kgOf(i.weight);
        const mets = c.data.mets.activities;
        const items = parseRows(i.items).map(([activity, minutes, days]) => {
            const key = Object.keys(mets).find((k) => mets[k][0].toLowerCase() === String(activity ?? '').toLowerCase()) ?? Object.keys(mets).find((k) => mets[k][0].toLowerCase().includes(String(activity ?? '').toLowerCase().split(',')[0]));

            return { activity, key, minutes: parseAmount(minutes), days: parseAmount(days) || 1 };
        }).filter((x) => x.key && Number.isFinite(x.minutes));

        if (!items.length || !ok(kg) || kg <= 0) {
            return { empty: 'Enter your weight and add activities with minutes.' };
        }

        const lines = items.map((x) => ({ ...x, met: mets[x.key][1], name: mets[x.key][0], kcal: mets[x.key][1] * kg * (x.minutes / 60) * x.days }));
        const total = lines.reduce((sum, l) => sum + l.kcal, 0);
        const moderate = lines.filter((l) => l.met >= 3).reduce((sum, l) => sum + l.minutes * l.days * (l.met >= 6 ? 2 : 1), 0);

        return {
            value: kcal(total),
            label: c.period === 'week' ? 'Calories burned a week' : 'Calories burned',
            sub: `${f0(lines.reduce((s, l) => s + l.met * l.minutes * l.days, 0))} MET-minutes for ${f1(kg)} kg`,
            rows: { who: `${f0(moderate)} moderate-equivalent minutes (vigorous counts double) of the 150 a week WHO recommends`, net: `${kcal(total - kg * (lines.reduce((s, l) => s + l.minutes * l.days, 0) / 60))} above resting`, source: 'MET values: Compendium of Physical Activities (Ainsworth 2011); kcal = MET × kg × hours' },
            grids: { items: { columns: ['METs', 'Minutes', 'kcal'], rows: lines.map((l) => ({ header: l.name, cells: [String(l.met), f0(l.minutes * l.days), f0(l.kcal)] })) } },
        };
    },
};

export default defineTools(handlers);
