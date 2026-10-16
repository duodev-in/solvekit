import { defineTools, missing } from '../engines/formula.js';
import { addDays, formatDate, parseDate } from './gestation.js';

/**
 * Everyday dog and cat care: age, weight, food, water, housing, heat cycles, quality of life and costs.
 * Fields with a unit menu arrive in base units: grams and meters.
 */
const KG = 1000;
const LB = 453.59237;
const IN = 0.0254;

/**
 * Widely used size-based dog age chart (human years at dog ages 1 to 16).
 */
export const DOG_AGE_CHART = {
    small: [15, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80],
    medium: [15, 24, 28, 32, 36, 42, 47, 51, 56, 60, 65, 69, 74, 78, 83, 87],
    large: [15, 24, 28, 32, 36, 45, 50, 55, 61, 66, 72, 77, 82, 88, 93, 99],
    giant: [12, 22, 31, 38, 45, 49, 56, 64, 71, 79, 86, 93, 100, 107, 114, 121],
};

export const DOG_LIFESPAN = { small: 14, medium: 13, large: 11.5, giant: 9 };

/**
 * Share of adult weight reached by age in weeks, by size class (approximate growth curves).
 */
export const GROWTH = {
    small: [[8, 25], [12, 37], [16, 50], [20, 62], [24, 72], [28, 80], [32, 86], [36, 91], [40, 95], [44, 98], [52, 100]],
    medium: [[8, 20], [12, 30], [16, 41], [20, 51], [24, 60], [28, 68], [32, 75], [36, 81], [40, 86], [44, 90], [52, 96], [60, 99], [64, 100]],
    large: [[8, 15], [12, 23], [16, 32], [20, 40], [24, 48], [28, 56], [32, 63], [36, 69], [40, 75], [44, 80], [52, 88], [60, 94], [68, 98], [72, 100]],
    giant: [[8, 11], [12, 17], [16, 24], [20, 31], [24, 38], [28, 45], [32, 51], [36, 57], [40, 63], [44, 68], [52, 76], [60, 84], [72, 92], [84, 97], [96, 100]],
    cat: [[4, 6], [8, 12], [12, 20], [16, 30], [20, 40], [24, 50], [28, 58], [32, 66], [36, 74], [40, 80], [44, 86], [48, 90], [52, 94], [64, 100]],
};

/**
 * Cat age chart (AAFP/AAHA): human years at cat ages in years.
 */
const CAT_AGE_POINTS = [[0, 0], [1 / 12, 1], [3 / 12, 4], [6 / 12, 10], [1, 15], [2, 24]];

export const CRATES = [
    { name: '18 in (XS)', length: 18, height: 14 },
    { name: '22 in (S)', length: 22, height: 16 },
    { name: '24 in (S/M)', length: 24, height: 19 },
    { name: '30 in (M)', length: 30, height: 21 },
    { name: '36 in (L)', length: 36, height: 25 },
    { name: '42 in (XL)', length: 42, height: 30 },
    { name: '48 in (XXL)', length: 48, height: 33 },
    { name: '54 in (Giant)', length: 54, height: 45 },
];

export const HARNESS = [
    { name: 'XXS', max: 13 }, { name: 'XS', max: 17 }, { name: 'S', max: 22 }, { name: 'M', max: 27 },
    { name: 'L', max: 32 }, { name: 'XL', max: 38 }, { name: 'XXL', max: Infinity },
];

/** Energy factors × RER (WSAVA and standard veterinary nutrition texts). */
export const DOG_FACTORS = { puppy_young: 3, puppy: 2, neutered: 1.6, intact: 1.8, inactive: 1.2, loss: 1, senior: 1.4, light_work: 2, moderate_work: 3, heavy_work: 4 };
export const CAT_FACTORS = { kitten: 2.5, neutered: 1.2, intact: 1.4, inactive: 1, loss: 0.8, senior: 1.1 };

export function restingEnergy(kg) {
    return 70 * kg ** 0.75;
}

function interpolate(points, x) {
    if (x <= points[0][0]) {
        return points[0][1] * (x / points[0][0]);
    }

    for (let index = 1; index < points.length; index += 1) {
        const [x1, y1] = points[index];

        if (x <= x1) {
            const [x0, y0] = points[index - 1];

            return y0 + ((y1 - y0) * (x - x0)) / (x1 - x0);
        }
    }

    return points[points.length - 1][1];
}

export function dogHumanAge(years, size) {
    const chart = DOG_AGE_CHART[size];
    const points = chart.map((human, index) => [index + 1, human]);

    if (years > 16) {
        const step = chart[15] - chart[14];

        return chart[15] + step * (years - 16);
    }

    return interpolate(points, years);
}

/**
 * Epigenetic clock for dogs (Wang et al., Cell Systems 2020): 16 × ln(age) + 31.
 */
export function epigeneticAge(years) {
    return 16 * Math.log(years) + 31;
}

export function catHumanAge(years) {
    return years <= 2 ? interpolate(CAT_AGE_POINTS, years) : 24 + 4 * (years - 2);
}

export function catLifeStage(years) {
    if (years < 1) {
        return 'Kitten';
    }

    if (years < 7) {
        return 'Young adult';
    }

    return years < 11 ? 'Mature adult' : 'Senior';
}

export function adultWeight(current, weeks, curve) {
    return current / (interpolate(GROWTH[curve], weeks) / 100);
}

/**
 * Feline body mass index (Hawthorne and Butterwick): body fat % from rib cage and leg index (cm).
 */
export function felineBodyFat(ribCageCm, legCm) {
    return (ribCageCm / 0.7062 - legCm) / 0.9156 - legCm;
}

function dogLifeStage(years, size) {
    if (years < (size === 'giant' ? 1.5 : 1)) {
        return 'Puppy';
    }

    if (years < 4) {
        return 'Young adult';
    }

    return years < DOG_LIFESPAN[size] * 0.75 ? 'Mature adult' : 'Senior';
}

function readAge(i) {
    return i.age_unit === 'months' ? i.age / 12 : i.age;
}

function energyOutcome(i, f, factors, species) {
    if (missing(i, 'weight')) {
        return { empty: 'Enter the weight.' };
    }

    if (i.weight <= 0) {
        return { error: 'Weight must be greater than 0.' };
    }

    const kg = i.weight / KG;
    const rer = restingEnergy(kg);
    const factor = factors[i.stage];
    const kcal = rer * factor;

    return { kg, rer, factor, kcal, note: i.stage === 'loss' ? `Use the ${species}'s ideal weight, not the current weight, for weight loss.` : 'A starting point; adjust by 10% at a time to keep an ideal body condition.' };
}

export const handlers = {
    dog_age: (i, c, f) => {
        if (missing(i, 'age')) {
            return { empty: 'Enter the dog\'s age.' };
        }

        if (i.age <= 0) {
            return { error: 'Age must be greater than 0.' };
        }

        const years = readAge(i);
        const human = dogHumanAge(years, i.size);

        return {
            value: f(Math.round(human)),
            unit: 'human years',
            label: 'Human-equivalent age',
            sub: `Size-based chart for a ${i.size} dog`,
            rows: { epigenetic: years >= 0.25 ? `${f(Math.round(Math.max(0, epigeneticAge(years))))} human years` : 'For dogs over 3 months', stage: dogLifeStage(years, i.size), lifespan: `About ${f(DOG_LIFESPAN[i.size])} years for this size` },
        };
    },

    dog_ideal_weight: (i, c, f) => {
        if (missing(i, 'weight', 'bcs')) {
            return { empty: 'Enter the weight and body condition score.' };
        }

        if (i.weight <= 0 || i.bcs < 1 || i.bcs > 9) {
            return { error: 'Weight must be greater than 0 and the score 1 to 9.' };
        }

        const unit = i.weight_unit ?? 'kg';
        const ideal = i.weight / (1 + 0.1 * (Math.round(i.bcs) - 5));
        const difference = i.weight - ideal;

        return {
            value: f(ideal),
            unit,
            label: 'Estimated ideal weight',
            sub: i.bcs > 5 ? `About ${f((Math.round(i.bcs) - 5) * 10)}% over ideal at a score of ${Math.round(i.bcs)}` : i.bcs < 5 ? `About ${f((5 - Math.round(i.bcs)) * 10)}% under ideal; ask your vet about weight gain` : 'A score of 5 is ideal',
            rows: {
                change: difference > 0 ? `Lose about ${f(difference)} ${unit}` : difference < 0 ? `Gain about ${f(-difference)} ${unit}` : 'No change needed',
                weekly: difference > 0 ? `${f(i.weight * 0.01)} to ${f(i.weight * 0.02)} ${unit} a week (1 to 2%)` : '—',
                weeks: difference > 0 ? `About ${f(Math.ceil(difference / (i.weight * 0.015)))} weeks at 1.5% a week` : '—',
            },
        };
    },

    dog_nutrition: (i, c, f) => {
        const energy = energyOutcome(i, f, DOG_FACTORS, 'dog');

        if (!energy.kcal) {
            return energy;
        }

        const growing = i.stage === 'puppy' || i.stage === 'puppy_young';

        return {
            value: f(Math.round(energy.kcal)),
            unit: 'kcal/day',
            label: 'Daily energy need',
            sub: energy.note,
            rows: { rer: `${f(Math.round(energy.rer))} kcal (70 × ${f(energy.kg)} kg^0.75)`, factor: `× ${f(energy.factor)}`, protein: growing ? 'At least 22.5% of dry matter (AAFCO growth)' : 'At least 18% of dry matter (AAFCO adult)', fat: growing ? 'At least 8.5% of dry matter' : 'At least 5.5% of dry matter' },
        };
    },

    dog_food: (i, c, f) => {
        const energy = energyOutcome(i, f, DOG_FACTORS, 'dog');

        if (!energy.kcal) {
            return energy;
        }

        if (!(i.kcal_kg > 0)) {
            return { empty: 'Enter the food\'s calories per kg from the bag.' };
        }

        const grams = (energy.kcal / i.kcal_kg) * 1000;
        const meals = i.meals > 0 ? Math.round(i.meals) : 2;
        const cups = i.kcal_cup > 0 ? Math.round((energy.kcal / i.kcal_cup) * 100) / 100 : null;

        return {
            value: f(Math.round(grams)),
            unit: 'g/day',
            label: 'Food per day',
            sub: `${f(Math.round(energy.kcal))} kcal a day at ${f(i.kcal_kg)} kcal/kg, including treats`,
            rows: { cups: cups === null ? 'Enter kcal per cup' : `${f(cups)} cups (8 oz measuring cup)`, meal: `${f(Math.round(grams / meals))} g${cups === null ? '' : `, ${f(Math.round((cups / meals) * 100) / 100)} cups`} per meal × ${meals}`, week: `${f(grams * 7 / 1000)} kg`, bag: i.bag > 0 ? `About ${f(Math.floor(i.bag / grams))} days` : 'Enter a bag size' },
        };
    },

    raw_food: (i, c, f) => {
        if (missing(i, 'weight', 'percent')) {
            return { empty: 'Enter the weight and percent of body weight to feed.' };
        }

        if (i.weight <= 0 || i.percent <= 0 || i.percent > 10) {
            return { error: 'Weight must be greater than 0 and the percent 0 to 10.' };
        }

        const grams = i.weight * (i.percent / 100);
        const split = { barf: { muscle: 70, bone: 10, liver: 5, organ: 5, plants: 10 }, pmr: { muscle: 80, bone: 10, liver: 5, organ: 5, plants: 0 } }[i.ratio];
        const part = (share) => `${f(Math.round((grams * share) / 100))} g (${share}%)`;

        return {
            value: f(Math.round(grams)),
            unit: 'g/day',
            label: 'Raw food per day',
            sub: `${f(i.percent)}% of ${f(i.weight / KG)} kg; adults usually 2 to 3%`,
            rows: { muscle: part(split.muscle), bone: part(split.bone), liver: part(split.liver), organ: part(split.organ), plants: split.plants ? part(split.plants) : 'Not used in this ratio', week: `${f(grams * 7 / 1000)} kg a week` },
        };
    },

    dog_water: (i, c, f) => {
        if (missing(i, 'weight')) {
            return { empty: 'Enter the dog\'s weight.' };
        }

        if (i.weight <= 0) {
            return { error: 'Weight must be greater than 0.' };
        }

        const kg = i.weight / KG;
        const boost = 1 + (i.activity === 'active' ? 0.25 : 0) + (i.weather === 'hot' ? 0.25 : 0);
        const ml = kg * 55 * boost;

        return {
            value: f(Math.round(ml)),
            unit: 'mL/day',
            label: 'Water per day (estimate)',
            sub: `About 50 to 60 mL per kg${boost > 1 ? ', raised for activity or heat' : ''}; wet food supplies part of it`,
            rows: { cups: `${f(ml / 236.6)} US cups`, liters: `${f(ml / 1000)} L`, range: `${f(Math.round(kg * 50))} to ${f(Math.round(kg * 60))} mL at rest`, high: `Over ${f(Math.round(kg * 100))} mL a day (100 mL/kg) is too much: see a vet` },
        };
    },

    dog_crate: (i, c, f) => {
        if (missing(i, 'length', 'height')) {
            return { empty: 'Measure the dog\'s length and height.' };
        }

        if (i.length <= 0 || i.height <= 0) {
            return { error: 'Measurements must be greater than 0.' };
        }

        const needLength = i.length / IN + 3;
        const needHeight = i.height / IN + 3;
        const crate = CRATES.find((item) => item.length >= needLength && item.height >= needHeight);

        return {
            value: crate ? crate.name : 'Larger than 54 in',
            unit: '',
            label: 'Crate size',
            sub: `Needs about ${f(Math.ceil(needLength))} in long and ${f(Math.ceil(needHeight))} in high inside`,
            rows: { length: `${f(Math.ceil(needLength))} in (${f(Math.ceil(needLength * 2.54))} cm)`, height: `${f(Math.ceil(needHeight))} in (${f(Math.ceil(needHeight * 2.54))} cm)` },
            lists: { crates: CRATES.map((item) => ({ label: item.name, value: `${item.length} × ${item.height} in high`, highlight: item === crate })) },
        };
    },

    harness: (i, c, f) => {
        if (missing(i, 'chest')) {
            return { empty: 'Measure the chest girth.' };
        }

        if (i.chest <= 0) {
            return { error: 'Girth must be greater than 0.' };
        }

        const inches = i.chest / IN;
        const size = HARNESS.find((item) => inches <= item.max);
        const between = HARNESS.some((item) => Number.isFinite(item.max) && Math.abs(inches - item.max) < 0.75);

        return {
            value: size.name,
            unit: '',
            label: 'Harness size (generic chart)',
            sub: between ? 'On the edge between sizes: check the brand\'s chart and allow two fingers of space' : `Chest ${f(inches)} in (${f(inches * 2.54)} cm); brands differ, so check their chart`,
            rows: { chest: `${f(inches)} in (${f(inches * 2.54)} cm)` },
            lists: { sizes: HARNESS.map((item, index) => ({ label: item.name, value: Number.isFinite(item.max) ? `${index ? HARNESS[index - 1].max : 0}–${item.max} in` : `over ${HARNESS[index - 1].max} in`, highlight: item === size })) },
        };
    },

    heat_cycle: (i, c, f) => {
        const start = parseDate(i.date);

        if (!start) {
            return { empty: 'Enter the first day of the last heat.' };
        }

        const interval = { small: 152, medium: 183, large: 213, giant: 365 }[i.size];
        const next = addDays(start, interval);
        const cycles = [1, 2, 3].map((n) => addDays(start, interval * n));

        return {
            value: formatDate(next),
            unit: '',
            label: 'Next heat expected',
            sub: `About every ${f(Math.round(interval / 30.4))} months for a ${i.size} dog; often irregular in young dogs`,
            rows: {
                proestrus: `${formatDate(start)} to ${formatDate(addDays(start, 8))}`,
                fertile: `${formatDate(addDays(start, 9))} to ${formatDate(addDays(start, 14))}`,
                end: `About ${formatDate(addDays(start, 18))}`,
                window: `${formatDate(addDays(next, -30))} to ${formatDate(addDays(next, 30))}`,
            },
            lists: { cycles: cycles.map((date, index) => ({ label: `Heat ${index + 1}`, value: formatDate(date), highlight: index === 0 })) },
        };
    },

    dog_lifespan: (i, c, f) => {
        const breed = c.data[i.breed];
        let low;
        let high;
        let basis;

        if (breed) {
            [low, high] = breed.range;
            basis = `${breed.name}: AKC typical range`;
        } else {
            if (!(i.weight > 0)) {
                return { empty: 'Enter the adult weight for a mixed breed.' };
            }

            const lb = i.weight / LB;
            const size = lb < 20 ? 'small' : lb < 50 ? 'medium' : lb < 100 ? 'large' : 'giant';
            [low, high] = { small: [12, 16], medium: [10, 14], large: [10, 12], giant: [7, 10] }[size];
            basis = `Mixed breed, ${size} (${f(lb)} lb)`;
        }

        const age = Number.isNaN(i.age) ? null : i.age;
        const middle = (low + high) / 2;

        return {
            value: `${low}–${high}`,
            unit: 'years',
            label: 'Typical life expectancy',
            sub: basis,
            rows: { middle: `${f(middle)} years`, remaining: age === null ? 'Enter the current age' : age >= high ? 'Already beyond the typical range' : `About ${f(Math.max(0, low - age))} to ${f(high - age)} more years`, note: 'Genetics, weight and care matter as much as breed' },
        };
    },

    puppy_size: (i, c, f) => {
        if (missing(i, 'weight', 'weeks')) {
            return { empty: 'Enter the puppy\'s weight and age in weeks.' };
        }

        if (i.weight <= 0 || i.weeks < 6 || i.weeks > 104) {
            return { error: 'Enter a weight and an age of 6 to 104 weeks.' };
        }

        const unit = i.weight_unit ?? 'lb';
        const adult = adultWeight(i.weight, i.weeks, i.size);
        const share = interpolate(GROWTH[i.size], i.weeks);
        const done = GROWTH[i.size].at(-1)[0];

        return {
            value: f(Math.round(adult * 10) / 10),
            unit,
            label: 'Estimated adult weight',
            sub: `At ${f(i.weeks)} weeks a ${i.size} puppy is about ${f(Math.round(share))}% grown; estimates can be 15 to 20% off`,
            rows: { share: `${f(Math.round(share))}%`, grown: `Around ${f(Math.round(done / 4.33))} months`, range: `${f(Math.round(adult * 0.85))} to ${f(Math.round(adult * 1.15))} ${unit}` },
            lists: { growth: GROWTH[i.size].filter(([weeks]) => weeks % 8 === 0 || weeks === done).map(([weeks, percent]) => ({ label: `${weeks} weeks`, value: `${f(Math.round((adult * percent) / 100))} ${unit}`, highlight: Math.abs(weeks - i.weeks) < 4 })) },
        };
    },

    quality_of_life: (i, c, f) => {
        const keys = ['hurt', 'hunger', 'hydration', 'hygiene', 'happiness', 'mobility', 'more_good'];

        if (missing(i, ...keys)) {
            return { empty: 'Score each of the seven areas from 0 to 10.' };
        }

        if (keys.some((key) => i[key] < 0 || i[key] > 10)) {
            return { error: 'Each score must be 0 to 10.' };
        }

        const total = keys.reduce((sum, key) => sum + i[key], 0);
        const lowest = keys.reduce((low, key) => (i[key] < i[low] ? key : low), keys[0]);
        const names = { hurt: 'Hurt', hunger: 'Hunger', hydration: 'Hydration', hygiene: 'Hygiene', happiness: 'Happiness', mobility: 'Mobility', more_good: 'More good days than bad' };

        return {
            value: f(total),
            unit: '/ 70',
            label: 'Quality-of-life score',
            sub: total > 35 ? 'Above 35: quality of life is generally acceptable on this scale' : '35 or below: a sign to talk with your vet about comfort and options',
            rows: { lowest: `${names[lowest]} (${f(i[lowest])})`, percent: `${f(Math.round((total / 70) * 100))}%` },
        };
    },

    dog_cost: (i, c, f) => {
        const monthly = ['food', 'treats', 'insurance', 'grooming', 'supplies', 'other'];
        const yearly = ['vet', 'boarding'];
        const value = (key) => (Number.isNaN(i[key]) ? 0 : i[key]);
        const year = monthly.reduce((sum, key) => sum + value(key) * 12, 0) + yearly.reduce((sum, key) => sum + value(key), 0);
        const lifespan = DOG_LIFESPAN[i.size];
        const firstYear = year + value('setup');

        return {
            value: `$${f(Math.round(year))}`,
            unit: 'a year',
            label: 'Yearly cost',
            sub: 'Example prices; enter your own for a real budget',
            rows: { month: `$${f(Math.round(year / 12))}`, first: `$${f(Math.round(firstYear))}`, lifetime: `$${f(Math.round(firstYear + year * (lifespan - 1)))} over about ${f(lifespan)} years` },
        };
    },

    cat_age: (i, c, f) => {
        if (missing(i, 'age')) {
            return { empty: 'Enter the cat\'s age.' };
        }

        if (i.age <= 0) {
            return { error: 'Age must be greater than 0.' };
        }

        const years = readAge(i);

        return {
            value: f(Math.round(catHumanAge(years))),
            unit: 'human years',
            label: 'Human-equivalent age',
            sub: 'AAFP and AAHA feline life stage chart',
            rows: { stage: catLifeStage(years), next: years < 1 ? 'Young adult at 1 year' : years < 7 ? 'Mature adult at 7 years' : years < 11 ? 'Senior at 11 years' : 'Twice-yearly vet checks are recommended for seniors' },
        };
    },

    cat_bmi: (i, c, f) => {
        if (missing(i, 'rib_cage', 'leg')) {
            return { empty: 'Measure the rib cage and lower back leg.' };
        }

        if (i.rib_cage <= 0 || i.leg <= 0) {
            return { error: 'Measurements must be greater than 0.' };
        }

        const fat = felineBodyFat(i.rib_cage * 100, i.leg * 100);

        if (fat < 0 || fat > 80) {
            return { error: 'Check the measurements: rib cage at the 9th rib, leg from knee to ankle.' };
        }

        return {
            value: f(Math.round(fat)),
            unit: '% body fat',
            label: 'Feline body fat (FBMI)',
            sub: fat < 10 ? 'Below about 10%: may be underweight' : fat <= 30 ? 'Within the healthy range of about 10 to 30%' : 'Above 30%: likely overweight; ask your vet about a plan',
            rows: { band: fat < 10 ? 'Lean' : fat <= 30 ? 'Healthy' : 'Overweight', rib: `${f(i.rib_cage * 100)} cm`, leg: `${f(i.leg * 100)} cm` },
        };
    },

    cat_calories: (i, c, f) => {
        const energy = energyOutcome(i, f, CAT_FACTORS, 'cat');

        if (!energy.kcal) {
            return energy;
        }

        return {
            value: f(Math.round(energy.kcal)),
            unit: 'kcal/day',
            label: 'Daily energy need',
            sub: energy.note,
            rows: { rer: `${f(Math.round(energy.rer))} kcal (70 × ${f(energy.kg)} kg^0.75)`, factor: `× ${f(energy.factor)}`, treats: `Treats at most ${f(Math.round(energy.kcal * 0.1))} kcal (10%)` },
        };
    },

    kitten_size: (i, c, f) => {
        if (missing(i, 'weight', 'weeks')) {
            return { empty: 'Enter the kitten\'s weight and age in weeks.' };
        }

        if (i.weight <= 0 || i.weeks < 4 || i.weeks > 64) {
            return { error: 'Enter a weight and an age of 4 to 64 weeks.' };
        }

        const unit = i.weight_unit ?? 'lb';
        const adult = adultWeight(i.weight, i.weeks, 'cat');

        return {
            value: f(Math.round(adult * 10) / 10),
            unit,
            label: 'Estimated adult weight',
            sub: `At ${f(i.weeks)} weeks a kitten is about ${f(Math.round(interpolate(GROWTH.cat, i.weeks)))}% grown; breed and sex matter a lot`,
            rows: { range: `${f(Math.round(adult * 0.85 * 10) / 10)} to ${f(Math.round(adult * 1.15 * 10) / 10)} ${unit}`, grown: 'Most cats reach adult size at 12 to 18 months; Maine Coons up to 4 years' },
            lists: { growth: GROWTH.cat.filter(([weeks]) => weeks % 8 === 0 || weeks === 64).map(([weeks, percent]) => ({ label: `${weeks} weeks`, value: `${f(Math.round((adult * percent) / 10) / 10)} ${unit}`, highlight: Math.abs(weeks - i.weeks) < 4 })) },
        };
    },

    cat_water: (i, c, f) => {
        if (missing(i, 'weight')) {
            return { empty: 'Enter the cat\'s weight.' };
        }

        if (i.weight <= 0) {
            return { error: 'Weight must be greater than 0.' };
        }

        const total = (i.weight / KG) * 50;
        const wet = Number.isNaN(i.wet) ? 0 : i.wet;
        const fromFood = wet * ((Number.isNaN(i.moisture) ? 78 : i.moisture) / 100);
        const drink = Math.max(0, total - fromFood);

        return {
            value: f(Math.round(total)),
            unit: 'mL/day',
            label: 'Total water per day (estimate)',
            sub: `About 50 mL per kg, from food and drinking together`,
            rows: { food: `${f(Math.round(fromFood))} mL from wet food`, drink: `${f(Math.round(drink))} mL to drink (${f(drink / 29.57)} fl oz)`, tip: 'Cats drink little; wet food and fountains help' },
        };
    },

    cat_food: (i, c, f) => {
        const energy = energyOutcome(i, f, CAT_FACTORS, 'cat');

        if (!energy.kcal) {
            return energy;
        }

        const wetShare = Math.min(100, Math.max(0, Number.isNaN(i.wet_share) ? 50 : i.wet_share)) / 100;
        const wetKcal = energy.kcal * wetShare;
        const dryKcal = energy.kcal - wetKcal;

        if ((wetShare > 0 && !(i.kcal_can > 0)) || (wetShare < 1 && !(i.kcal_cup > 0))) {
            return { empty: 'Enter calories per can and per cup from the labels.' };
        }

        const meals = i.meals > 0 ? Math.round(i.meals) : 2;
        const cans = wetShare > 0 ? wetKcal / i.kcal_can : 0;
        const cups = wetShare < 1 ? dryKcal / i.kcal_cup : 0;

        return {
            value: `${f(Math.round(cans * 100) / 100)} cans + ${f(Math.round(cups * 100) / 100)} cups`,
            unit: '',
            label: 'Food per day',
            sub: `${f(Math.round(energy.kcal))} kcal a day, ${f(wetShare * 100)}% from wet food`,
            rows: { wet: `${f(Math.round(wetKcal))} kcal`, dry: `${f(Math.round(dryKcal))} kcal`, meal: `${f(Math.round((cans / meals) * 100) / 100)} cans and ${f(Math.round((cups / meals) * 100) / 100)} cups per meal × ${meals}` },
        };
    },
};

export default defineTools(handlers);
