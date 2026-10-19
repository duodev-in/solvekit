import { defineTools } from '../engines/formula.js';
import { addDays, addMonths, civilSeconds, fromCivilSeconds, parseDate, shortDate, weekday, WEEKDAYS } from '../everyday/dates.js';
import { ingredient, kn, measure, toGrams, VOLUME, WEIGHT } from '../food/kitchen.js';
import { boilingPointAt } from './fd-bake.js';
import { RICE, yieldRatio } from './fd-convert.js';

/**
 * Food safety and everyday cooking: safe internal temperatures and storage times (USDA FSIS, FoodKeeper),
 * boiled eggs (with the Williams heat-conduction model), brines and cures, rice water, steak, cooling water,
 * mashed potatoes and bread spreads.
 */
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
const cToF = (c) => (c * 9) / 5 + 32;
const both = (c) => `${kn(Math.round(cToF(c)))} °F (${kn(Math.round(c))} °C)`;
const LB = WEIGHT.lb.g;

/**
 * Williams (Physics Education 1998) time for an egg's yolk to reach a temperature: mass in g, temperatures in °C, result in seconds.
 * t = M^⅔ c ρ^⅓ ÷ (K π² (4π/3)^⅔) × ln[0.76 (T_egg − T_water) ÷ (T_yolk − T_water)], with c = 3.7 J/(g K), ρ = 1.038 g/cm³, K = 5.4 × 10⁻³ W/(cm K).
 */
export function williamsSeconds(mass, eggTemp, waterTemp, yolkTemp) {
    const factor = (mass ** (2 / 3) * 3.7 * 1.038 ** (1 / 3)) / (5.4e-3 * Math.PI ** 2 * ((4 * Math.PI) / 3) ** (2 / 3));

    return factor * Math.log((0.76 * (eggTemp - waterTemp)) / (yolkTemp - waterTemp));
}

// US egg sizes by USDA minimum weight per dozen (in the shell): small 18 oz, medium 21, large 24, extra large 27, jumbo 30.
const EGG_MASS = { small: 42.5, medium: 49.6, large: 56.7, xl: 63.8, jumbo: 70.9 };
// Times for a large egg from the fridge lowered into boiling water at sea level (tested cooking guides), with the yolk temperature each implies.
const DONENESS = {
    soft: { name: 'Soft (runny yolk, set white)', minutes: 6, yolk: 62 },
    jammy: { name: 'Jammy (soft-set yolk)', minutes: 7, yolk: 65 },
    medium: { name: 'Medium (barely set yolk)', minutes: 9, yolk: 70 },
    hard: { name: 'Hard (firm yolk)', minutes: 11, yolk: 77 },
};

// Storage dates are civil dates (no time zone); months and years follow the calendar.
const addTime = (date, amount, unit) => {
    if (unit === 'months' || unit === 'years') {
        return addMonths(date, unit === 'years' ? amount * 12 : amount);
    }

    if (unit === 'hours') {
        return fromCivilSeconds(civilSeconds({ date, seconds: 12 * 3600 }) + amount * 3600).date;
    }

    return addDays(date, unit === 'weeks' ? amount * 7 : amount);
};
const day = (date) => `${WEEKDAYS[weekday(date)].slice(0, 3)}, ${shortDate(date)}`;
const PLACE = { pantry: 'Pantry', fridge: 'Refrigerator', freezer: 'Freezer' };
const FROM = { '': '', purchase: 'from purchase', opening: 'after opening', thawing: 'after thawing' };
const timeText = ([, , low, high, unit]) => (low === null ? unit : low === high ? `${kn(low)} ${low === 1 ? unit.replace(/s$/, '') : unit}` : `${kn(low)}–${kn(high)} ${unit}`);

// Rice water by method (cups of water per cup of rice) and cooking time: package and USA Rice Federation guidance.
const RICE_METHODS = {
    long: { stove: [2, '15–18 min, then 10 min covered off the heat'], cooker: [1.5, 'Cooker cycle'], pot: [1, '4 min high pressure, 10 min natural release'] },
    basmati: { stove: [1.5, '15 min, then 10 min off the heat'], cooker: [1.25, 'Cooker cycle'], pot: [1, '4 min high pressure, 10 min natural release'] },
    jasmine: { stove: [1.25, '15 min, then 10 min off the heat'], cooker: [1.1, 'Cooker cycle'], pot: [1, '4 min high pressure, 10 min natural release'] },
    medium: { stove: [1.5, '15–18 min, then 10 min off the heat'], cooker: [1.25, 'Cooker cycle'], pot: [1, '5 min high pressure, 10 min natural release'] },
    short: { stove: [1.25, 'Rinse, soak 30 min, simmer 15 min, rest 10'], cooker: [1.1, 'Cooker cycle (use the sushi line)'], pot: [1, '5 min high pressure, 10 min natural release'] },
    brown: { stove: [2.25, '40–45 min, then 10 min off the heat'], cooker: [2, 'Brown-rice cycle'], pot: [1.25, '22 min high pressure, 10 min natural release'] },
    parboiled: { stove: [2.25, '20–25 min'], cooker: [2, 'Cooker cycle'], pot: [null, 'Follow the package'] },
    wild: { stove: [3, '45–55 min simmer, drain any extra water'], cooker: [3, 'Brown-rice cycle'], pot: [1.5, '25–30 min high pressure, natural release'] },
};

const STEAK = { rare: { name: 'Rare', temp: 125, perInch: 4 }, mediumrare: { name: 'Medium rare', temp: 135, perInch: 5 }, medium: { name: 'Medium', temp: 145, perInch: 6 }, mediumwell: { name: 'Medium well', temp: 150, perInch: 7 }, well: { name: 'Well done', temp: 160, perInch: 8 } };

// Cooling water: time constants (minutes) for Newton's law of cooling in still room air, by container (typical values).
const VESSELS = { mug: { name: 'Mug (250 ml)', tau: 35 }, glass: { name: 'Glass (250 ml)', tau: 40 }, pan: { name: 'Saucepan (1 L)', tau: 70 }, pot: { name: 'Stock pot (4 L)', tau: 150 } };

// Spread per slice of bread, regular thickness, in US tablespoons (convention), and a usual US package in grams.
const SPREADS = { butter: [1 / 3, 454, '1 lb pack'], peanut_butter: [1, 454, '16 oz jar'], jam: [1, 510, '18 oz jar'], cream_cheese: [1, 227, '8 oz pack'], mayonnaise: [0.5, 850, '30 oz jar'], mustard: [1 / 3, 397, '14 oz bottle'] };

// FSIS limits for ingoing sodium nitrite (ppm): bacon pumped or immersion 120, bacon dry-cured 200, comminuted (sausage) 156, immersion-cured other meats 200.
const CURES = { bacon_dry: { name: 'Bacon, dry cure', limit: 200 }, bacon_wet: { name: 'Bacon, brine (immersion) cure', limit: 120 }, sausage: { name: 'Sausage or ground meat', limit: 156 }, whole: { name: 'Ham or other whole muscle, brine cure', limit: 200 } };

export const handlers = {
    safe_temp: (i, c) => {
        const rows = c.data.safe;
        const row = rows[Number(i.food)] ?? rows[0];

        return {
            value: row[2] ? `${row[2]} °F` : 'By look',
            label: row[1],
            sub: row[2] ? `${kn(Math.round(((row[2] - 32) * 5) / 9))} °C${row[3] ? `, then rest ${row[3]} minutes` : ''}${row[4] ? `. ${row[4]}` : ''}` : row[4],
            rows: { c: row[2] ? `${kn(Math.round(((row[2] - 32) * 5) / 9))} °C` : 'No temperature given', rest: row[3] ? `${row[3]} minutes before carving or eating` : 'None needed', group: row[0], how: 'Insert the thermometer in the thickest part, away from bone, fat and gristle' },
            grids: { chart: { columns: ['°F', '°C', 'Rest'], rows: rows.map((r, k) => ({ header: r[1], cells: [r[2] ? String(r[2]) : 'By look', r[2] ? kn(Math.round(((r[2] - 32) * 5) / 9)) : 'By look', r[3] ? `${r[3]} min` : 'None'], highlight: k === Number(i.food) })) } },
        };
    },

    storage: (i, c) => {
        const food = c.data.storage[Number(i.food)];

        if (!food) {
            return { empty: 'Choose a food.' };
        }

        const stored = parseDate(i.stored);
        const matching = food.times.filter((t) => t[0] === i.place);
        const wanted = { unopened: ['purchase', ''], opened: ['opening'], thawed: ['thawing'] }[i.state] ?? ['purchase', ''];
        const entry = matching.find((t) => wanted.includes(t[1])) ?? matching[0];
        const all = food.times.map((t) => ({ header: `${PLACE[t[0]]}${FROM[t[1]] ? `, ${FROM[t[1]]}` : ''}`, cells: [timeText(t)], highlight: t === entry }));

        if (!entry) {
            return { value: 'Not listed', label: `${PLACE[i.place]} storage`, sub: `FoodKeeper has no ${PLACE[i.place].toLowerCase()} time for ${food.name}; see the other places below`, rows: { range: 'Not listed', best: 'Not listed', tip: food.tip || 'No extra tips' }, grids: { times: { columns: ['Time'], rows: all } } };
        }

        const [, , low, high, unit] = entry;
        const dated = low !== null && stored !== null;

        return {
            value: dated ? day(addTime(stored, high, unit)) : timeText(entry),
            label: dated ? 'Use by (longest time)' : `${PLACE[i.place]} storage`,
            sub: `${food.name}: ${timeText(entry)} in the ${PLACE[i.place].toLowerCase()}${FROM[entry[1]] ? ` ${FROM[entry[1]]}` : ''} (USDA FoodKeeper)`,
            rows: {
                range: timeText(entry),
                best: dated && low !== high ? `${day(addTime(stored, low, unit))} for best quality` : dated ? day(addTime(stored, low, unit)) : 'No date (see the time)',
                tip: food.tip || (i.place === 'freezer' ? 'Frozen food stays safe indefinitely at 0 °F; the times are for quality' : 'Keep the fridge at 40 °F (4 °C) or below'),
            },
            grids: { times: { columns: ['Time'], rows: all } },
        };
    },

    egg_boil: (i) => {
        const done = DONENESS[i.doneness] ?? DONENESS.medium;
        const mass = EGG_MASS[i.size] ?? EGG_MASS.large;
        const start = i.start === 'room' ? 20 : 4;
        const water = boilingPointAt(or0(i.altitude));

        if (done.yolk >= water - 1) {
            return { error: `Water boils at ${kn(water)} °C at this altitude, too low to reach that doneness by boiling.` };
        }

        // Scale the tested time with the Williams model: mass^⅔ and the logarithmic temperature term.
        const ratio = (williamsSeconds(mass, start, water, done.yolk) / williamsSeconds(EGG_MASS.large, 4, boilingPointAt(0), done.yolk));
        const minutes = done.minutes * ratio;
        const aeb = { medium: 9, large: 12, xl: 15, jumbo: 15, small: 9 }[i.size] ?? 12;

        return {
            value: `${kn(Math.round(minutes * 2) / 2)} min`,
            label: done.name,
            sub: `${i.size === 'xl' ? 'Extra large' : i.size[0].toUpperCase() + i.size.slice(1)} egg (${kn(mass)} g) from the ${i.start === 'room' ? 'counter' : 'fridge'}, lowered into water boiling at ${both(water)}`,
            rows: {
                steam: `${kn(Math.round(minutes * 2) / 2)} min steaming over boiling water (about the same as boiling)`,
                cold: i.doneness === 'hard' ? `Cold start: cover with cold water, bring to a boil, cover, take off the heat and leave ${aeb} min (American Egg Board)` : 'For runny or jammy yolks, start in boiling water for accuracy',
                ice: 'Move to ice water for 2–5 minutes to stop the cooking and make peeling easier',
                safety: 'USDA: cook eggs until the yolk and white are firm, or use pasteurized eggs, for people at higher risk',
            },
        };
    },

    ideal_egg: (i) => {
        const mass = i.mass_mode === 'size' ? EGG_MASS[i.size] ?? EGG_MASS.large : i.mass;
        const water = boilingPointAt(or0(i.altitude));
        const yolk = i.yolk === 'custom' ? i.yolk_custom : Number(i.yolk);

        if (!ok(mass, i.egg_temp, yolk) || mass <= 0) {
            return { empty: 'Enter the egg mass, its starting temperature and the yolk temperature.' };
        }

        if (yolk >= water || yolk <= i.egg_temp) {
            return { error: `The yolk target must be above the egg's starting temperature and below the boiling point (${kn(water)} °C here).` };
        }

        const seconds = williamsSeconds(mass, i.egg_temp, water, yolk);

        return {
            value: `${Math.floor(seconds / 60)} min ${Math.round(seconds % 60)} s`,
            label: 'Boiling time (Williams model)',
            sub: `${kn(mass)} g egg from ${both(i.egg_temp)} to a ${both(yolk)} yolk in water at ${both(water)}`,
            rows: {
                water: `${both(water)} at your altitude`,
                yolk: yolk < 64 ? 'Runny yolk' : yolk < 68 ? 'Jammy yolk' : yolk < 74 ? 'Just set yolk' : 'Firm yolk',
                sensitivity: `+10 g of egg adds about ${kn((williamsSeconds(mass + 10, i.egg_temp, water, yolk) - seconds) / 60)} min`,
                note: 'The model assumes a uniform sphere; real eggs often need a minute or so more',
            },
        };
    },

    brine: (i, c) => {
        const salt = c.data.salt[i.salt] ?? c.data.salt.table;
        let base;

        if (i.mode === 'equilibrium') {
            base = or0(i.meat) + or0(i.water_eq);

            if (base <= 0) {
                return { empty: 'Enter the meat weight and the water.' };
            }
        } else {
            base = i.water * 1000;

            if (!ok(base) || base <= 0) {
                return { empty: 'Enter the water.' };
            }
        }

        const pct = or0(i.percent);
        const grams = (base * pct) / 100;
        const sugar = (base * or0(i.sugar)) / 100;
        const tsp = grams / salt.tsp;

        return {
            value: `${kn(grams)} g`,
            label: salt.name,
            sub: i.mode === 'equilibrium' ? `${kn(pct)}% of ${kn(base)} g (meat + water): the meat ends up seasoned at ${kn(pct)}% however long it sits` : `${kn(pct)}% of ${kn(base)} g of water`,
            rows: {
                volume: `${measure(tsp / 3, 'tbsp_us')}, or ${measure(tsp / 48, 'cup_us')}`,
                others: Object.entries(c.data.salt).filter(([key]) => key !== i.salt).map(([, s]) => `${s.name}: ${measure(grams / s.tsp / 3, 'tbsp_us')}`).join('; '),
                sugar: sugar > 0 ? `${kn(sugar)} g sugar (${measure(sugar / 200, 'cup_us')})` : 'No sugar',
                time: i.mode === 'equilibrium' ? 'Usually 1–3 days in the fridge, depending on thickness' : 'Typical: chicken pieces 1–4 h, whole chicken 4–12 h, turkey 12–24 h; keep below 40 °F (4 °C)',
            },
        };
    },

    curing: (i) => {
        const cure = CURES[i.product] ?? CURES.bacon_dry;
        const grams = i.meat;
        const ppm = ok(i.ppm) ? i.ppm : cure.limit;

        if (!ok(grams) || grams <= 0) {
            return { empty: 'Enter the meat weight.' };
        }

        if (ppm > cure.limit) {
            return { error: `USDA FSIS limits ingoing sodium nitrite to ${cure.limit} ppm for ${cure.name.toLowerCase()}.` };
        }

        // Prague Powder (Cure) #1 is 6.25% sodium nitrite and 93.75% salt.
        const curePowder = (grams * ppm) / 1e6 / 0.0625;
        const salt = Math.max(0, (grams * or0(i.salt)) / 100 - curePowder * 0.9375);
        const sugar = (grams * or0(i.sugar)) / 100;

        return {
            value: `${kn(curePowder)} g`,
            label: 'Prague Powder #1 (Cure #1)',
            sub: `${kn(ppm)} ppm ingoing nitrite for ${kn(grams)} g (${kn(grams / LB)} lb) of ${cure.name.toLowerCase()}; FSIS limit ${cure.limit} ppm`,
            rows: {
                salt: `${kn(salt)} g (${kn(or0(i.salt))}% of the meat, less the salt in the cure)`,
                sugar: `${kn(sugar)} g (${kn(or0(i.sugar))}%)`,
                nitrite: `${kn((curePowder * 0.0625 * 1000))} mg of sodium nitrite`,
                time: i.product.startsWith('bacon') ? 'About 7–10 days in the fridge (36–40 °F), turning daily, then rinse, dry and smoke or roast to 150 °F' : 'Follow a tested recipe for time and temperature',
                warning: 'Weigh cure on a 0.1 g scale and mix it evenly; never use Cure #1 at more than the stated amount, and keep it away from children',
            },
        };
    },

    rice_water: (i, c) => {
        const type = RICE[i.type] ? i.type : 'long';
        const method = RICE_METHODS[type][i.method] ?? RICE_METHODS[type].stove;
        const cups = i.amount;

        if (!ok(cups) || cups <= 0) {
            return { empty: 'Enter the cups of rice.' };
        }

        const raw = ingredient(c, RICE[type].raw);
        const cooked = ingredient(c, RICE[type].cooked);
        const cookedCups = (cups * raw.cup * yieldRatio(raw, cooked)) / cooked.cup;

        if (method[0] === null) {
            return { value: 'See package', label: 'Water', sub: `${RICE[type].name}: ${method[1].toLowerCase()} for pressure cooking`, rows: { ratio: 'Not listed', time: method[1], yield: measure(cookedCups, 'cup_us'), rinse: 'Rinse white rice until the water runs nearly clear' } };
        }

        return {
            value: measure(cups * method[0], 'cup_us').replace(/ \(.*\)$/, ''),
            label: 'Water',
            sub: `${measure(cups, 'cup_us')} ${RICE[type].name.toLowerCase()} at 1 : ${kn(method[0])} (${kn(cups * method[0] * VOLUME.cup_us.ml)} ml)`,
            rows: { ratio: `1 : ${kn(method[0])} by volume`, time: method[1], yield: `About ${measure(cookedCups, 'cup_us')} cooked (USDA)`, rinse: type === 'parboiled' || type === 'wild' ? 'No rinsing needed' : 'Rinse until the water runs nearly clear for fluffier rice' },
        };
    },

    steak: (i) => {
        const done = STEAK[i.doneness] ?? STEAK.mediumrare;
        const inches = i.thickness / 0.0254;

        if (!ok(inches) || inches <= 0) {
            return { empty: 'Enter the steak thickness.' };
        }

        const pull = done.temp - 5;

        if (i.method === 'reverse') {
            // Reverse sear: about 20 minutes per inch at 250–275 °F to 10–15 °F under the target, then 1 minute a side in a very hot pan.
            return {
                value: `${kn(Math.round(inches * 20))}–${kn(Math.round(inches * 25))} min`,
                label: 'In a 250–275 °F oven, then sear',
                sub: `${kn(inches)} in steak: take it out at ${kn(done.temp - 12)} °F, sear 1 min a side, serve at about ${done.temp} °F (${done.name.toLowerCase()})`,
                rows: { target: `${done.temp} °F (${kn(Math.round(((done.temp - 32) * 5) / 9))} °C) ${done.name.toLowerCase()}`, pull: `Out of the oven at ${kn(done.temp - 12)} °F`, rest: 'Little rest needed after a reverse sear', usda: 'USDA safe minimum for beef steaks: 145 °F (63 °C) with a 3-minute rest' },
            };
        }

        const perSide = (done.perInch * inches) / (i.method === 'broil' ? 0.9 : 1);

        return {
            value: `${kn(Math.round(perSide * 2) / 2)} min`,
            label: 'Each side, over high heat',
            sub: `${kn(inches)} in steak, ${done.name.toLowerCase()}: pull at ${pull} °F, rest to about ${done.temp} °F (${kn(Math.round(((done.temp - 32) * 5) / 9))} °C)`,
            rows: { target: `${done.temp} °F (${kn(Math.round(((done.temp - 32) * 5) / 9))} °C) ${done.name.toLowerCase()}`, pull: `${pull} °F (it rises about 5 °F while resting)`, rest: '5–10 minutes before slicing', usda: 'USDA safe minimum for beef steaks: 145 °F (63 °C) with a 3-minute rest' },
        };
    },

    water_cool: (i) => {
        const room = i.room;

        if (!ok(i.start, i.target, room) || i.start <= i.target || i.target <= room) {
            return { empty: 'Enter a start above the target, and a target above room temperature.' };
        }

        // A measured point (minutes, temperature) fits the time constant; otherwise a typical value for the container.
        const measured = ok(i.after, i.measured) && i.after > 0 && i.measured < i.start && i.measured > room;
        const tau = measured ? i.after / Math.log((i.start - room) / (i.measured - room)) : (VESSELS[i.vessel] ?? VESSELS.mug).tau;
        const minutes = tau * Math.log((i.start - room) / (i.target - room));
        const series = [];

        for (let t = 0; t <= minutes * 1.4; t += Math.max(1, minutes / 60)) {
            series.push([Math.round(t), Number((room + (i.start - room) * Math.exp(-t / tau)).toFixed(1))]);
        }

        return {
            value: minutes >= 90 ? `${kn(minutes / 60)} h` : `${kn(Math.round(minutes))} min`,
            label: 'Time to cool',
            sub: `${both(i.start)} → ${both(i.target)} in a room at ${both(room)}; time constant ${kn(Math.round(tau))} min${measured ? ' (from your measurement)' : ' (typical)'}`,
            rows: {
                minutes: `${kn(Math.round(minutes))} minutes`,
                after30: `${both(room + (i.start - room) * Math.exp(-30 / tau))} after 30 min`,
                drink: i.target > 70 ? 'Hot drinks above about 65 °C (149 °F) can scald; many people drink coffee at 55–60 °C' : 'Below about 60 °C (140 °F)',
                food: 'For cooked food the FDA Food Code allows 2 hours from 135 °F to 70 °F, then 4 more to 41 °F: use shallow containers or an ice bath',
            },
            plots: { curve: { series, xLabel: 'Minutes', yLabel: 'Temperature (°C)', markers: [{ x: Math.round(minutes), y: Number(i.target.toFixed(1)), label: 'Target' }] } },
        };
    },

    mashed: (i, c) => {
        const people = or0(i.adults) + or0(i.kids) * 0.5;

        if (people <= 0) {
            return { empty: 'Enter the number of guests.' };
        }

        const appetite = { light: 0.8, normal: 1, hearty: 1.25 }[i.appetite] ?? 1;
        const lb = people * (i.role === 'main' ? 0.75 : 0.5) * appetite;
        // Classic ratio per pound of potatoes: 2 tbsp butter, ¼ cup milk, ½ tsp salt; peeling loses about 15%.
        const butterG = toGrams(lb * 2, 'tbsp_us', ingredient(c, 'butter'));
        const milkG = toGrams(lb / 4, 'cup_us', ingredient(c, 'milk'));
        const mashedG = lb * LB * 0.85 + butterG + milkG;
        const cups = mashedG / ingredient(c, 'mashed_potatoes').cup;

        return {
            value: `${kn(Math.ceil(lb * 2) / 2)} lb`,
            label: 'Potatoes (raw, unpeeled)',
            sub: `${kn((lb * LB) / 1000)} kg for ${kn(people)} adult portions as a ${i.role === 'main' ? 'main' : 'side'}; about ${measure(cups, 'cup_us')} mashed`,
            rows: {
                butter: `${measure(lb * 2, 'tbsp_us')} (${kn(butterG)} g)`,
                milk: `${measure(lb / 4, 'cup_us')} (${kn(milkG)} ml)`,
                salt: `${measure(lb / 2, 'tsp_us')} to taste`,
                servings: `${kn(cups / (i.role === 'main' ? 1 : 0.67))} servings of ${i.role === 'main' ? '1 cup' : '⅔ cup'}`,
                type: 'Russet or Yukon Gold potatoes mash best',
            },
        };
    },

    spreads: (i, c) => {
        const spread = SPREADS[i.spread] ?? SPREADS.butter;
        const slices = i.mode === 'sandwiches' ? or0(i.sandwiches) * (i.both ? 2 : 1) : or0(i.slices);

        if (slices <= 0) {
            return { empty: 'Enter slices or sandwiches.' };
        }

        const row = ingredient(c, i.spread);
        const tbsp = slices * spread[0] * ({ thin: 0.5, regular: 1, thick: 1.5 }[i.thickness] ?? 1);
        const grams = toGrams(tbsp, 'tbsp_us', row);

        return {
            value: `${kn(grams)} g`,
            label: row.name,
            sub: `${measure(tbsp, 'tbsp_us')} for ${kn(slices)} slices (${measure(tbsp / slices, 'tbsp_us')} each)`,
            rows: {
                packages: `${kn(grams / spread[1])} × ${spread[2]} (${kn(spread[1])} g)`,
                cups: measure(tbsp / 16, 'cup_us'),
                kcal: `${kn(Math.round((row.per100.kcal * grams) / 100))} kcal (${kn(Math.round((row.per100.kcal * grams) / 100 / slices))} a slice, USDA)`,
            },
        };
    },
};

export default defineTools(handlers);
