/**
 * Body measurement formulas shared by the Health calculators. Inputs are SI: height in metres, mass in kilograms,
 * circumferences in centimetres unless a function says otherwise. Each formula names its published source.
 */
export const bmi = (kg, m) => kg / (m * m);

/** WHO adult BMI categories (with the optional lower cut-offs for Asian populations, WHO Expert Consultation 2004). */
export function bmiCategory(value, { asian = false } = {}) {
    const cuts = asian ? [[18.5, 'Underweight'], [23, 'Healthy weight'], [27.5, 'Overweight'], [Infinity, 'Obesity']] : [[18.5, 'Underweight'], [25, 'Healthy weight'], [30, 'Overweight'], [35, 'Obesity class I'], [40, 'Obesity class II'], [Infinity, 'Obesity class III']];

    return cuts.find(([limit]) => value < limit)[1];
}

/** Weight range for the healthy BMI band at a height. */
export const healthyRange = (m, low = 18.5, high = 24.9) => [low * m * m, high * m * m];

/** Ideal body weight (kg) by the published formulas; height in cm. Inches over 5 ft × the per-inch increment. */
export function idealWeights(cm, sex) {
    const inchesOver = cm / 2.54 - 60;
    const male = sex === 'male';

    return {
        devine: (male ? 50 : 45.5) + 2.3 * inchesOver,
        robinson: (male ? 52 : 49) + (male ? 1.9 : 1.7) * inchesOver,
        miller: (male ? 56.2 : 53.1) + (male ? 1.41 : 1.36) * inchesOver,
        hamwi: (male ? 48 : 45.5) + (male ? 2.7 : 2.2) * inchesOver,
    };
}

/** Body surface area (m²); height in cm, mass in kg. */
export const BSA = {
    mosteller: (cm, kg) => Math.sqrt((cm * kg) / 3600),
    dubois: (cm, kg) => 0.007184 * cm ** 0.725 * kg ** 0.425,
    haycock: (cm, kg) => 0.024265 * cm ** 0.3964 * kg ** 0.5378,
    gehan: (cm, kg) => 0.0235 * cm ** 0.42246 * kg ** 0.51456,
    boyd: (cm, kg) => 0.0003207 * cm ** 0.3 * (kg * 1000) ** (0.7285 - 0.0188 * Math.log10(kg * 1000)),
};

/** Lean body mass (kg): Boer (1984), James (1976) and Hume (1966); height in cm. */
export function leanMass(cm, kg, sex) {
    const male = sex === 'male';

    return {
        boer: male ? 0.407 * kg + 0.267 * cm - 19.2 : 0.252 * kg + 0.473 * cm - 48.3,
        james: male ? 1.1 * kg - 128 * (kg / cm) ** 2 : 1.07 * kg - 148 * (kg / cm) ** 2,
        hume: male ? 0.3281 * kg + 0.33929 * cm - 29.5336 : 0.29569 * kg + 0.41813 * cm - 43.2933,
    };
}

/** US Navy circumference body fat % (Hodgdon & Beckett 1984), measurements in cm. */
export function navyBodyFat({ sex, height, neck, waist, hip }) {
    return sex === 'male'
        ? 495 / (1.0324 - 0.19077 * Math.log10(waist - neck) + 0.15456 * Math.log10(height)) - 450
        : 495 / (1.29579 - 0.35004 * Math.log10(waist + hip - neck) + 0.221 * Math.log10(height)) - 450;
}

/** BMI-based adult body fat % (Deurenberg 1991). */
export const deurenbergBodyFat = (bmiValue, age, sex) => 1.2 * bmiValue + 0.23 * age - 10.8 * (sex === 'male' ? 1 : 0) - 5.4;

/** American Council on Exercise body fat categories. */
export function aceCategory(fat, sex) {
    const cuts = sex === 'male' ? [[6, 'Essential fat'], [14, 'Athletes'], [18, 'Fitness'], [25, 'Average'], [Infinity, 'Obese']] : [[14, 'Essential fat'], [21, 'Athletes'], [25, 'Fitness'], [32, 'Average'], [Infinity, 'Obese']];

    return cuts.find(([limit]) => fat < limit)[1];
}

/** Body density from skinfolds (mm): Jackson & Pollock 3- and 7-site, Durnin & Womersley 4-site; Siri and Brozek fat %. */
export function skinfoldDensity({ method, sex, age, sum }) {
    const male = sex === 'male';

    if (method === 'jp3') {
        return male ? 1.10938 - 0.0008267 * sum + 0.0000016 * sum ** 2 - 0.0002574 * age : 1.0994921 - 0.0009929 * sum + 0.0000023 * sum ** 2 - 0.0001392 * age;
    }

    if (method === 'jp7') {
        return male ? 1.112 - 0.00043499 * sum + 0.00000055 * sum ** 2 - 0.00028826 * age : 1.097 - 0.00046971 * sum + 0.00000056 * sum ** 2 - 0.00012828 * age;
    }

    // Durnin & Womersley (1974) 4-site (biceps, triceps, subscapular, suprailiac): D = c − m × log10(sum), by age band (under 20, 20–29, 30–39, 40–49, 50+).
    const bands = male
        ? [[20, 1.162, 0.063], [30, 1.1631, 0.0632], [40, 1.1422, 0.0544], [50, 1.162, 0.07], [Infinity, 1.1715, 0.0779]]
        : [[20, 1.1549, 0.0678], [30, 1.1599, 0.0717], [40, 1.1423, 0.0632], [50, 1.1333, 0.0612], [Infinity, 1.1339, 0.0645]];
    const [, c, m] = bands.find(([limit]) => age < limit);

    return c - m * Math.log10(sum);
}

export const siri = (density) => 495 / density - 450;
export const brozek = (density) => 457 / density - 414.2;

/** Basal metabolic rate (kcal/day); height in cm. */
export const BMR = {
    mifflin: ({ kg, cm, age, sex }) => 10 * kg + 6.25 * cm - 5 * age + (sex === 'male' ? 5 : -161),
    // Harris–Benedict revised by Roza & Shizgal (1984).
    harris: ({ kg, cm, age, sex }) => (sex === 'male' ? 88.362 + 13.397 * kg + 4.799 * cm - 5.677 * age : 447.593 + 9.247 * kg + 3.098 * cm - 4.33 * age),
    harrisOriginal: ({ kg, cm, age, sex }) => (sex === 'male' ? 66.473 + 13.7516 * kg + 5.0033 * cm - 6.755 * age : 655.0955 + 9.5634 * kg + 1.8496 * cm - 4.6756 * age),
    katch: ({ lean }) => 370 + 21.6 * lean,
};

/** Activity factors (multiples of BMR) used for TDEE. */
export const ACTIVITY = {
    sedentary: [1.2, 'Sedentary (little or no exercise)'],
    light: [1.375, 'Light (exercise 1–3 days a week)'],
    moderate: [1.55, 'Moderate (exercise 3–5 days a week)'],
    active: [1.725, 'Active (hard exercise 6–7 days a week)'],
    extra: [1.9, 'Very active (physical job or training twice a day)'],
};

/** Age in whole years between ISO dates is left to the date helpers; this converts years to months for growth charts. */
export const yearsToMonths = (years) => years * 12;
