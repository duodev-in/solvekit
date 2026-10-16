import { defineTools, missing } from '../engines/formula.js';

/**
 * Livestock calculators: weights, gains, feed, grazing, storage and fencing.
 * Fields with a unit menu arrive in base units: meters and grams.
 */
const IN = 0.0254;
const FT = 0.3048;
const LB = 453.59237;
const BUSHEL_FT3 = 1.2445;
const AUM_LB = 780;

const pounds = (grams) => grams / LB;

export function cattleWeight(girthIn, lengthIn) {
    return (girthIn ** 2 * lengthIn) / 300;
}

/**
 * Grain bin volume in ft³: the cylinder to the eave plus a cone for a peaked top.
 */
export function binCubicFeet(diameterFt, eaveFt, peakFt = 0) {
    const area = Math.PI * (diameterFt / 2) ** 2;

    return area * eaveFt + (area * peakFt) / 3;
}

export function annualisedMortality(rate, days) {
    return 1 - (1 - rate) ** (365 / days);
}

export const handlers = {
    cattle_weight: (i, c, f) => {
        if (missing(i, 'girth', 'length')) {
            return { empty: 'Enter the heart girth and body length.' };
        }

        if (i.girth <= 0 || i.length <= 0) {
            return { error: 'Measurements must be greater than 0.' };
        }

        const lb = cattleWeight(i.girth / IN, i.length / IN);

        return {
            value: f(Math.round(lb)),
            unit: 'lb',
            label: 'Estimated live weight',
            sub: 'Tape estimates can be 5 to 10% off; use a scale for dosing and sales',
            rows: { kg: `${f(Math.round(lb * LB / 1000))} kg`, au: `${f(lb / 1000)} animal units` },
        };
    },

    adg: (i, c, f) => {
        if (missing(i, 'start', 'end', 'days')) {
            return { empty: 'Enter start weight, end weight and days.' };
        }

        if (i.days <= 0 || i.start <= 0) {
            return { error: 'Start weight and days must be greater than 0.' };
        }

        const unit = i.unit === 'kg' ? 'kg' : 'lb';
        const gain = i.end - i.start;
        const daily = gain / i.days;
        const toTarget = i.target > i.end && daily > 0 ? Math.ceil((i.target - i.end) / daily) : null;

        return {
            value: f(daily),
            unit: `${unit}/day`,
            label: 'Average daily gain',
            sub: `${f(gain)} ${unit} gained in ${f(i.days)} days`,
            rows: { weekly: `${f(daily * 7)} ${unit} per week`, total: `${f(gain)} ${unit}`, target: toTarget === null ? 'Enter a target above the end weight' : `${f(toTarget)} more days` },
        };
    },

    fcr: (i, c, f) => {
        if (missing(i, 'feed', 'gain')) {
            return { empty: 'Enter the feed used and weight gained.' };
        }

        if (i.feed <= 0 || i.gain <= 0) {
            return { error: 'Feed and gain must be greater than 0.' };
        }

        const ratio = i.feed / i.gain;

        return {
            value: f(ratio),
            unit: ': 1',
            label: 'Feed conversion ratio',
            sub: `${f(ratio)} units of feed per unit of gain; lower is better`,
            rows: { efficiency: `${f((i.gain / i.feed) * 100)}% (gain ÷ feed)`, cost: i.price > 0 ? `$${f(ratio * i.price)} per unit of gain` : 'Enter a feed price' },
        };
    },

    mortality: (i, c, f) => {
        if (missing(i, 'deaths', 'population')) {
            return { empty: 'Enter deaths and the number of animals at the start.' };
        }

        if (i.population <= 0 || i.deaths < 0 || i.deaths > i.population) {
            return { error: 'Deaths must be between 0 and the starting number.' };
        }

        const rate = i.deaths / i.population;

        return {
            value: f(rate * 100),
            unit: '%',
            label: 'Mortality rate',
            sub: `${f(i.deaths)} of ${f(i.population)} animals`,
            rows: { survival: `${f((1 - rate) * 100)}%`, annual: i.days > 0 ? `${f(annualisedMortality(rate, i.days) * 100)}% a year at this rate` : 'Enter the period in days', alive: f(i.population - i.deaths) },
        };
    },

    stocking_rate: (i, c, f) => {
        if (missing(i, 'acres', 'forage', 'utilisation', 'weight', 'days')) {
            return { empty: 'Enter acres, forage yield, utilisation, animal weight and grazing days.' };
        }

        if ([i.acres, i.forage, i.utilisation, i.weight, i.days].some((value) => value <= 0)) {
            return { error: 'Values must be greater than 0.' };
        }

        const available = i.acres * i.forage * (i.utilisation / 100);
        const perHead = pounds(i.weight) * 0.026 * i.days;
        const head = available / perHead;

        return {
            value: f(Math.floor(head)),
            unit: 'head',
            label: `For ${f(i.days)} days of grazing`,
            sub: `${f(head / i.acres)} head per acre, ${f(i.acres / head)} acres per head`,
            rows: { forage: `${f(available)} lb of usable dry matter`, demand: `${f(perHead)} lb per head (2.6% of body weight a day)`, aum: `${f(available / AUM_LB)} AUMs` },
        };
    },

    aum: (i, c, f) => {
        if (missing(i, 'head', 'weight', 'months')) {
            return { empty: 'Enter head, average weight and months.' };
        }

        if (i.head <= 0 || i.weight <= 0 || i.months <= 0) {
            return { error: 'Values must be greater than 0.' };
        }

        const units = pounds(i.weight) / 1000;
        const aums = i.head * units * i.months;

        return {
            value: f(aums),
            unit: 'AUM',
            label: 'Animal unit months',
            sub: `${f(i.head)} head × ${f(units)} AU × ${f(i.months)} months`,
            rows: { au: `${f(units)} per head`, forage: `${f(aums * AUM_LB)} lb (${f(aums * AUM_LB / 2000)} tons) of dry forage`, kg: `${f(aums * AUM_LB * LB / 1000000)} t (metric)` },
        };
    },

    hay: (i, c, f) => {
        if (missing(i, 'head', 'weight', 'days', 'bale')) {
            return { empty: 'Enter head, body weight, days and bale weight.' };
        }

        if (i.head <= 0 || i.weight <= 0 || i.days <= 0 || i.bale <= 0) {
            return { error: 'Values must be greater than 0.' };
        }

        const waste = Number.isNaN(i.waste) ? 0 : i.waste / 100;

        if (waste < 0 || waste >= 1) {
            return { error: 'Waste must be 0 to under 100%.' };
        }

        // Dry matter intake 2.5% of body weight; hay is about 88% dry matter.
        const dryMatter = i.head * pounds(i.weight) * 0.025 * i.days;
        const hay = dryMatter / 0.88 / (1 - waste);
        const bales = Math.ceil(hay / pounds(i.bale));

        return {
            value: f(bales),
            unit: 'bales',
            label: 'Hay needed',
            sub: `${f(hay / 2000)} US tons as fed, including ${f(waste * 100)}% waste`,
            rows: { tons: `${f(hay / 2000)} US tons (${f(hay * LB / 1e6)} t)`, daily: `${f(hay / i.days / i.head)} lb per head per day`, cost: i.price > 0 ? `$${f(bales * i.price)}` : 'Enter a price per bale' },
        };
    },

    grain_bin: (i, c, f) => {
        if (missing(i, 'diameter', 'eave')) {
            return { empty: 'Enter the bin diameter and grain depth.' };
        }

        if (i.diameter <= 0 || i.eave < 0 || i.peak < 0) {
            return { error: 'Sizes must be positive.' };
        }

        const cubicFeet = binCubicFeet(i.diameter / FT, i.eave / FT, Number.isNaN(i.peak) ? 0 : i.peak / FT);
        const bushels = cubicFeet / BUSHEL_FT3;
        const grain = c.data[i.grain];
        const lb = bushels * grain.lb;

        return {
            value: f(Math.round(bushels)),
            unit: 'bu',
            label: 'Bin capacity',
            sub: `${grain.name} at ${grain.lb} lb per bushel`,
            rows: { ft3: `${f(cubicFeet)} ft³ (${f(cubicFeet * 0.0283168)} m³)`, tons: `${f(lb / 2000)} US tons`, tonnes: `${f(lb * LB / 1e6)} t` },
        };
    },

    fence_cost: (i, c, f) => {
        if (missing(i, 'perimeter', 'strands', 'spacing')) {
            return { empty: 'Enter the fence length, strands and post spacing.' };
        }

        if (i.perimeter <= 0 || i.strands < 1 || i.spacing <= 0) {
            return { error: 'Enter a length, at least one strand and a post spacing.' };
        }

        const feet = i.perimeter / FT;
        const wire = feet * Math.round(i.strands);
        const posts = Math.ceil(i.perimeter / i.spacing) + 1;
        const price = (value) => (Number.isNaN(value) ? 0 : value);
        const wireCost = wire * price(i.wire_price);
        const postCost = posts * price(i.post_price);
        const gateCost = price(i.gates) * price(i.gate_price);
        const labour = feet * price(i.labour);

        return {
            value: `$${f(wireCost + postCost + gateCost + labour)}`,
            unit: '',
            label: 'Estimated cost',
            sub: `${f(feet)} ft of fence, ${f(Math.round(i.strands))} strands`,
            rows: { wire: `${f(wire)} ft · $${f(wireCost)}`, posts: `${f(posts)} posts · $${f(postCost)}`, gates: `$${f(gateCost)}`, labour: `$${f(labour)}`, per_foot: `$${f((wireCost + postCost + gateCost + labour) / feet)} per ft` },
        };
    },
};

export default defineTools(handlers);
