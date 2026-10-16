import { defineTools, missing } from '../engines/formula.js';

/**
 * Pet and small-animal calculators: age, housing, nutrition, weight and costs.
 * Fields with a unit menu arrive in base units: meters for lengths.
 */
const IN = 0.0254;
const FT = 0.3048;
const GALLON = 3.785411784;
const HUMAN_LIFESPAN = 80;

export const TANK_SIZES = [10, 20, 29, 40, 55, 75, 90, 110, 125, 150, 180, 220, 300];

/**
 * Human-equivalent age as the same share of an 80-year human life.
 */
export function humanEquivalent(ageYears, lifespanYears) {
    return (ageYears / lifespanYears) * HUMAN_LIFESPAN;
}

export function lifeStage(share) {
    if (share < 0.08) {
        return 'Juvenile';
    }

    if (share < 0.65) {
        return 'Adult';
    }

    return share < 1 ? 'Senior' : 'Beyond the typical lifespan';
}

/**
 * Cricket chirps to °F. Snowy tree cricket: Dolbear (1897); field cricket: chirps in 14 s + 40.
 */
export function chirpsToFahrenheit(perMinute, species) {
    if (species === 'field') {
        return (perMinute * 14) / 60 + 40;
    }

    if (species === 'katydid') {
        return 60 + (perMinute - 19) / 3;
    }

    return 50 + (perMinute - 40) / 4;
}

/**
 * Horse weight in lb from heart girth and body length in inches (Carroll and Huntington, 1988).
 */
export function horseWeight(girthIn, lengthIn, group = 'adult') {
    return (girthIn ** 2 * lengthIn) / { adult: 330, yearling: 301, weanling: 280 }[group];
}

export function aquariumLiters(shape, d) {
    let cubicMeters;

    if (shape === 'cylinder') {
        cubicMeters = Math.PI * (d.diameter / 2) ** 2 * d.height;
    } else if (shape === 'bowfront') {
        // Rectangle plus the bow, taken as a parabolic segment: ⅔ × length × bow depth.
        cubicMeters = (d.length * d.width + (2 / 3) * d.length * d.bow) * d.height;
    } else if (shape === 'hexagon') {
        cubicMeters = ((3 * Math.sqrt(3)) / 2) * d.side ** 2 * d.height;
    } else {
        cubicMeters = d.length * d.width * d.height;
    }

    return cubicMeters * 1000;
}

const sizeText = (meters, f) => `${f(meters / FT)} ft (${f(meters)} m)`;

export const handlers = {
    lifespan_age: (i, c, f) => {
        const key = i.species ?? Object.keys(c.data)[0];
        const species = c.data[key];

        if (missing(i, 'age')) {
            return { empty: 'Enter the age.' };
        }

        if (i.age < 0) {
            return { error: 'Age cannot be negative.' };
        }

        const years = i.age_unit === 'months' ? i.age / 12 : i.age;
        const share = years / species.years;

        return {
            value: f(Math.round(humanEquivalent(years, species.years))),
            unit: 'human years',
            label: 'Human-equivalent age (approximate)',
            sub: `${species.name}: typical lifespan ${species.range} years`,
            rows: { stage: lifeStage(share), share: `${f(Math.min(share, 9.99) * 100)}% of a typical lifespan`, lifespan: `${species.range} years` },
        };
    },

    cricket: (i, c, f) => {
        if (missing(i, 'chirps', 'seconds')) {
            return { empty: 'Enter the chirps counted and the counting time.' };
        }

        if (i.chirps < 0 || i.seconds <= 0) {
            return { error: 'Chirps cannot be negative and the time must be greater than 0.' };
        }

        const perMinute = (i.chirps / i.seconds) * 60;
        const fahrenheit = chirpsToFahrenheit(perMinute, i.species);
        const celsius = ((fahrenheit - 32) * 5) / 9;

        return {
            value: f(fahrenheit),
            unit: '°F',
            label: 'Air temperature (estimate)',
            sub: `${f(perMinute)} chirps per minute; most reliable between about 55 and 100 °F`,
            rows: { celsius: `${f(celsius)} °C`, rate: `${f(perMinute)} per minute` },
        };
    },

    dry_matter: (i, c, f) => {
        if (missing(i, 'nutrient', 'moisture')) {
            return { empty: 'Enter the nutrient percent and moisture from the label.' };
        }

        if (i.moisture < 0 || i.moisture >= 100 || i.nutrient < 0 || i.nutrient > 100) {
            return { error: 'Percentages must be 0 to 100, and moisture below 100.' };
        }

        const dry = i.nutrient / (1 - i.moisture / 100);
        const hasSecond = !Number.isNaN(i.nutrient_b) && !Number.isNaN(i.moisture_b) && i.moisture_b < 100;
        const second = hasSecond ? i.nutrient_b / (1 - i.moisture_b / 100) : null;

        return {
            value: f(dry),
            unit: '% DM',
            label: 'On a dry-matter basis',
            sub: `${f(i.nutrient)}% as fed with ${f(i.moisture)}% moisture (${f(100 - i.moisture)}% dry matter)`,
            rows: {
                dm: `${f(100 - i.moisture)}%`,
                second: second === null ? 'Enter a second food to compare' : `${f(second)}% DM`,
                compare: second === null ? '—' : Math.abs(dry - second) < 0.05 ? 'About the same' : `${dry > second ? 'First' : 'Second'} food is higher by ${f(Math.abs(dry - second))} points`,
            },
        };
    },

    horse_weight: (i, c, f) => {
        if (missing(i, 'girth', 'length')) {
            return { empty: 'Enter the heart girth and body length.' };
        }

        if (i.girth <= 0 || i.length <= 0) {
            return { error: 'Measurements must be greater than 0.' };
        }

        const pounds = horseWeight(i.girth / IN, i.length / IN, i.group);

        return {
            value: f(Math.round(pounds)),
            unit: 'lb',
            label: 'Estimated weight',
            sub: 'Tape estimates are usually within about 3 to 10% of a scale',
            rows: { kg: `${f(Math.round(pounds * 0.45359237))} kg`, forage: `${f(pounds * 0.015)} to ${f(pounds * 0.025)} lb of forage a day (1.5 to 2.5% of body weight)` },
        };
    },

    rabbit_enclosure: (i, c, f) => {
        if (missing(i, 'rabbits', 'length', 'width', 'height')) {
            return { empty: 'Enter the number of rabbits and the enclosure size.' };
        }

        if (i.rabbits < 1 || i.length <= 0 || i.width <= 0 || i.height <= 0) {
            return { error: 'Enter at least one rabbit and sizes greater than 0.' };
        }

        // RWAF: 3 m × 2 m × 1 m high for a pair; groups scaled at 3 m² per rabbit (an estimate).
        const required = Math.max(6, 3 * Math.round(i.rabbits));
        const area = i.length * i.width;
        const meets = area >= required && i.height >= 1 && Math.max(i.length, i.width) >= 3;

        return {
            value: f(area),
            unit: 'm²',
            label: 'Your floor area',
            sub: `${f(area / FT ** 2)} ft². ${meets ? 'Meets the RWAF minimum of 3 × 2 × 1 m for a pair' : `Below the guide: aim for at least ${f(required)} m², 3 m long and 1 m high`}`,
            rows: {
                required: `${f(required)} m² (${f(required / FT ** 2)} ft²)${i.rabbits > 2 ? ', scaled from the pair guide' : ''}`,
                length: Math.max(i.length, i.width) >= 3 ? 'Yes, at least 3 m to run' : `No: longest side ${sizeText(Math.max(i.length, i.width), f)}, aim for 3 m`,
                height: i.height >= 1 ? 'Yes, room to stand up' : `No: ${sizeText(i.height, f)}, aim for 1 m`,
                single: i.rabbits < 2 ? 'Rabbits are social; keep them at least in pairs' : 'Good: rabbits do best in pairs or groups',
            },
        };
    },

    rat_cage: (i, c, f) => {
        if (missing(i, 'width', 'depth', 'height')) {
            return { empty: 'Enter the cage width, depth and height.' };
        }

        if (i.width <= 0 || i.depth <= 0 || i.height <= 0) {
            return { error: 'Sizes must be greater than 0.' };
        }

        const cubicFeet = (i.width * i.depth * i.height) / FT ** 3;
        // The epsilon stops unit round-off (17.9999 ft³) from losing a rat.
        const rats = Math.floor(cubicFeet / 2 + 1e-9);

        return {
            value: String(rats),
            unit: rats === 1 ? 'rat' : 'rats',
            label: 'Rats that fit',
            sub: rats < 2 ? 'Too small for a pair; rats should not live alone' : `At about 2 ft³ per rat, from ${f(cubicFeet)} ft³`,
            rows: { volume: `${f(cubicFeet)} ft³ (${f(cubicFeet * 28.3168)} L)`, bars: 'At most ½ in (1.3 cm) for adults; ⅜ in (1 cm) for young rats and small females', floor: 'Solid floors or levels are kinder to feet than wire' },
        };
    },

    turtle_tank: (i, c, f) => {
        if (missing(i, 'shell', 'turtles')) {
            return { empty: 'Enter the shell length and number of turtles.' };
        }

        if (i.shell <= 0 || i.turtles < 1) {
            return { error: 'Enter a shell length and at least one turtle.' };
        }

        const inches = i.shell / IN;
        const gallons = 10 * inches * (1 + 0.5 * (Math.round(i.turtles) - 1));
        const standard = TANK_SIZES.find((size) => size >= gallons);

        return {
            value: f(Math.ceil(gallons)),
            unit: 'US gal',
            label: 'Minimum tank size',
            sub: `10 gallons per inch of shell${i.turtles > 1 ? ', plus half for each extra turtle' : ''}`,
            rows: { liters: `${f(Math.ceil(gallons * GALLON))} L`, standard: standard ? `${standard} gal tank` : 'Larger than standard tanks: consider a pond or stock tank', depth: `At least ${f(inches * 2)} in (${f(i.shell * 200)} cm) of water` },
        };
    },

    pet_sitter: (i, c, f) => {
        if (missing(i, 'rate', 'visits', 'days')) {
            return { empty: 'Enter the rate, visits per day and number of days.' };
        }

        if (i.rate < 0 || i.visits < 1 || i.days < 1) {
            return { error: 'Enter a rate and at least one visit and one day.' };
        }

        const minutes = Number.isNaN(i.minutes) ? 30 : i.minutes;
        const extraPets = Math.max(0, (Number.isNaN(i.pets) ? 1 : Math.round(i.pets)) - 1);
        const perVisit = i.rate * (minutes / 30) + extraPets * (Number.isNaN(i.pet_fee) ? 0 : i.pet_fee);
        const perDay = perVisit * i.visits;
        const surcharge = 1 + (Number.isNaN(i.holiday) ? 0 : i.holiday) / 100;
        const total = perDay * i.days * surcharge;

        return {
            value: `$${f(total)}`,
            unit: '',
            label: 'Total cost',
            sub: `${f(i.visits * i.days)} visits of ${f(minutes)} minutes`,
            rows: { per_visit: `$${f(perVisit)}`, per_day: `$${f(perDay * surcharge)}`, per_week: `$${f(perDay * 7 * surcharge)}` },
        };
    },

    aquarium: (i, c, f) => {
        const needs = { rectangle: ['length', 'width', 'height'], cylinder: ['diameter', 'height'], bowfront: ['length', 'width', 'bow', 'height'], hexagon: ['side', 'height'] }[i.shape];

        if (missing(i, ...needs)) {
            return { empty: 'Enter the tank dimensions.' };
        }

        if (needs.some((name) => i[name] <= 0)) {
            return { error: 'Dimensions must be greater than 0.' };
        }

        const liters = aquariumLiters(i.shape, i);
        const gallons = liters / GALLON;

        return {
            value: f(gallons),
            unit: 'US gal',
            label: 'Tank volume',
            sub: `${f(liters)} liters, filled to the top`,
            rows: { liters: `${f(liters)} L`, real: `About ${f(gallons * 0.85)} gal (${f(liters * 0.85)} L) after substrate, decor and gap`, weight: `About ${f(liters)} kg (${f(liters * 2.20462)} lb) of fresh water` },
        };
    },

    chicken_coop: (i, c, f) => {
        if (missing(i, 'hens')) {
            return { empty: 'Enter the number of hens.' };
        }

        if (i.hens < 1) {
            return { error: 'Enter at least one hen.' };
        }

        const hens = Math.round(i.hens);
        const size = { bantam: { coop: 2, run: 5, roost: 6 }, standard: { coop: 4, run: 10, roost: 8 }, large: { coop: 5, run: 15, roost: 10 } }[i.breed];

        return {
            value: f(hens * size.coop),
            unit: 'ft²',
            label: 'Coop floor area',
            sub: `${size.coop} ft² per bird inside and ${size.run} ft² per bird in the run`,
            rows: { run: `${f(hens * size.run)} ft² (${f(hens * size.run * FT ** 2)} m²)`, coop_m2: `${f(hens * size.coop * FT ** 2)} m²`, nests: `${Math.ceil(hens / 4)} (one per 4 hens)`, roost: `${f(hens * size.roost)} in (${f(hens * size.roost * 2.54)} cm)` },
        };
    },
};

export default defineTools(handlers);
