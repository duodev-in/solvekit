import { formatMoney } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { civilSeconds, clock, fromCivilSeconds, parseDate, parseTime, shortDate, weekday, WEEKDAYS } from '../everyday/dates.js';
import { ingredient, kn, measure, WEIGHT } from '../food/kitchen.js';

/**
 * Thanksgiving and party planning: turkey size, thawing and roasting (USDA FSIS charts), ham, holiday shopping
 * quantities, barbecues, taco bars, drinks, popcorn, beer pong and wedding bars. Per-person amounts are catering
 * conventions and can be changed on the page.
 */
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
const LB = WEIGHT.lb.g;
const lbKg = (lb) => `${kn(lb)} lb (${kn((lb * LB) / 1000)} kg)`;
const hm = (hours) => {
    const total = Math.round(hours * 60);

    if (total < 60) {
        return `${total} min`;
    }

    return `${Math.floor(total / 60)} h${total % 60 ? ` ${total % 60} min` : ''}`;
};
const span = (low, high, unit) => (low === high ? `${kn(low)} ${unit}` : `${kn(low)}–${kn(high)} ${unit}`);
const plural = (count, word, many = `${word}s`) => `${kn(count)} ${count === 1 ? word : many}`;

/** Pounds from a mass input (base grams). */
const pounds = (grams) => grams / LB;

/**
 * USDA FSIS roasting time at 325 °F for a whole turkey: [low, high] hours, or null outside the chart.
 */
export function turkeyRoastHours(turkey, lb, stuffed) {
    const rows = turkey[stuffed ? 'stuffed' : 'unstuffed'];
    const row = rows.find(([from, to]) => lb >= from && lb <= to);

    return row ? [row[2], row[3]] : null;
}

/**
 * USDA thawing: refrigerator 24 h per 4–5 lb (returns days, longest first), cold water 30 min per lb (hours).
 */
export function turkeyThaw(turkey, lb, method) {
    if (method === 'water') {
        return { low: (lb * turkey.cold_water_min_per_lb) / 60, high: (lb * turkey.cold_water_min_per_lb) / 60, unit: 'h' };
    }

    return { low: lb / turkey.fridge_lb_per_day[1], high: lb / turkey.fridge_lb_per_day[0], unit: 'days' };
}

/** Ham cooking minutes per pound from the FSIS FoodKeeper chart: the row for a ham type and cut. */
export function hamRow(ham, type, cut) {
    return ham.find((row) => row.type === type && row.cut === cut) ?? ham.find((row) => row.type === type);
}

// Meal times are civil date and clock values (no time zone): seconds on the civil time line.
const when = (total) => {
    const { date, seconds } = fromCivilSeconds(total);

    return `${WEEKDAYS[weekday(date)].slice(0, 3)}, ${shortDate(date)}, ${clock(seconds).h12}`;
};

function mealSeconds(i) {
    const date = parseDate(i.meal_date);
    const time = parseTime(i.meal_time);

    return date && time !== null ? civilSeconds({ date, seconds: time }) : null;
}

function thawOutcome(i, c) {
    const lb = pounds(i.weight);

    if (!ok(lb) || lb <= 0) {
        return { empty: 'Enter the turkey weight.' };
    }

    if (i.method === 'microwave') {
        return {
            value: 'Cook at once',
            label: 'Microwave thawing',
            sub: 'Follow the microwave maker\'s minutes per pound and defrost setting, then roast immediately: parts of the bird start to cook',
            rows: { fridge: `${span(Math.ceil(lb / 5), Math.ceil(lb / 4), 'days')} in the refrigerator instead`, water: `${hm((lb * 30) / 60)} in cold water instead`, start: 'Right before roasting', safety: 'Never thaw on the counter: the outside sits in the 40–140 °F danger zone' },
        };
    }

    const t = turkeyThaw(c.data.turkey, lb, i.method);
    const meal = mealSeconds(i);
    // Leave the longer estimate plus a day (fridge) or the roasting time (water) before the meal.
    const roast = turkeyRoastHours(c.data.turkey, lb, false);
    const leadHours = i.method === 'water' ? t.high + (roast ? roast[1] : lb * 0.25) + 0.5 : Math.ceil(t.high) * 24 + 24;
    const start = meal === null ? null : meal - leadHours * 3600;

    return {
        value: t.unit === 'days' ? span(Math.ceil(t.low), Math.ceil(t.high), 'days') : hm(t.high),
        label: i.method === 'water' ? 'Cold-water thawing' : 'Refrigerator thawing',
        sub: i.method === 'water' ? `${kn(lb)} lb at 30 minutes per pound; change the water every 30 minutes and cook right away` : `${kn(lb)} lb at 24 hours per 4–5 lb (USDA); it keeps 1–2 days in the fridge once thawed`,
        rows: {
            fridge: span(Math.ceil(lb / 5), Math.ceil(lb / 4), 'days'),
            water: `${hm((lb * 30) / 60)} (water at 40 °F or below, changed every 30 min)`,
            start: start === null ? 'Enter the meal date and time' : `${when(start)} (${i.method === 'water' ? 'then roast straight away' : 'with a day to spare'})`,
            safety: 'Never thaw on the counter: the outside sits in the 40–140 °F danger zone',
        },
    };
}

function roastOutcome(i, c) {
    const lb = pounds(i.weight);
    const hours = ok(lb) ? turkeyRoastHours(c.data.turkey, lb, Boolean(i.stuffed)) : null;

    if (!ok(lb) || lb <= 0) {
        return { empty: 'Enter the turkey weight.' };
    }

    if (!hours) {
        return { error: i.stuffed ? 'The USDA stuffed-turkey chart covers 8 to 24 lb.' : 'The USDA chart covers 4 to 24 lb; for a larger bird roast two smaller ones or rely on a thermometer.' };
    }

    const meal = mealSeconds(i);
    // 20–30 minutes of resting before carving.
    const start = meal === null ? null : meal - (hours[1] + 0.5) * 3600;

    return {
        value: `${hm(hours[0])} – ${hm(hours[1])}`,
        label: 'Roasting time at 325 °F (163 °C)',
        sub: `${kn(lb)} lb ${i.stuffed ? 'stuffed' : 'unstuffed'} turkey; done when the thigh, wing and breast reach 165 °F (74 °C)`,
        rows: {
            temp: '165 °F (74 °C) in the thickest part of the thigh, the wing joint and the breast' + (i.stuffed ? '; stuffing centre 165 °F too' : ''),
            rest: 'Rest 20–30 minutes before carving',
            start: start === null ? 'Enter the meal date and time' : `${when(start)} into the oven`,
            check: `Start checking at ${hm(hours[0] - 0.5)}`,
            perLb: `${kn((hours[0] * 60) / lb)}–${kn((hours[1] * 60) / lb)} min per lb`,
        },
    };
}

// Thanksgiving amounts per adult (children count as half): catering conventions; the turkey follows USDA.
const DINNER = [
    ['Turkey (whole, raw)', 'lb', 1, 1.5],
    ['Stuffing (prepared)', 'cups', 0.75, 1],
    ['Potatoes for mashing (raw)', 'lb', 0.5, 0.67],
    ['Gravy', 'cups', 0.33, 0.5],
    ['Cranberry sauce', 'cups', 0.25, 0.33],
    ['Green beans or other vegetables (raw)', 'lb', 0.25, 0.33],
    ['Sweet potatoes (raw)', 'lb', 0.33, 0.5],
    ['Dinner rolls', '', 1.5, 2],
    ['Pie (8 slices each)', 'pies', 1 / 6, 1 / 4],
];

export const handlers = {
    turkey_roast: roastOutcome,
    turkey_thaw: thawOutcome,

    turkey_size: (i, c) => {
        const guests = or0(i.adults) + or0(i.kids) * 0.5;

        if (guests <= 0) {
            return { empty: 'Enter the number of guests.' };
        }

        // USDA per person: whole turkey 1 lb, bone-in breast ¾ lb, boneless breast ½ lb; more for leftovers.
        const per = { whole: [1, 1.5], breast: [0.75, 1.25], boneless: [0.5, 0.75] }[i.bird] ?? [1, 1.5];
        const lb = guests * per[i.leftovers ? 1 : 0];
        const roast = i.bird === 'whole' ? turkeyRoastHours(c.data.turkey, lb, false) : null;
        const thaw = turkeyThaw(c.data.turkey, lb, 'fridge');

        return {
            value: lbKg(lb),
            label: i.bird === 'whole' ? 'Whole turkey to buy' : i.bird === 'breast' ? 'Bone-in turkey breast' : 'Boneless turkey breast',
            sub: `${kn(per[i.leftovers ? 1 : 0])} lb a person for ${kn(guests)} adult portions (children count as half)${i.leftovers ? ', with leftovers' : ''}`,
            rows: {
                roast: roast ? `${hm(roast[0])}–${hm(roast[1])} unstuffed at 325 °F` : i.bird === 'whole' ? 'Outside the USDA chart (4–24 lb): consider two birds' : 'Roast to 165 °F; about 20–30 min per lb for breasts',
                thaw: `${span(Math.ceil(thaw.low), Math.ceil(thaw.high), 'days')} in the refrigerator`,
                twoBirds: lb > 24 ? `Two birds of about ${lbKg(lb / 2)} roast faster and more evenly` : 'One bird is fine',
            },
        };
    },

    thanksgiving: (i) => {
        const people = or0(i.adults) + or0(i.kids) * 0.5;

        if (people <= 0) {
            return { empty: 'Enter the number of guests.' };
        }

        const appetite = { light: 0.85, normal: 1, hearty: 1.2 }[i.appetite] ?? 1;
        const rows = DINNER.map(([name, unit, base, more]) => {
            const amount = people * (i.leftovers ? more : base) * (name.startsWith('Turkey') ? 1 : appetite);
            const shown = unit === 'pies' || unit === '' ? Math.ceil(amount) : amount;

            return { header: name, cells: [unit === 'cups' ? measure(shown, 'cup_us') : `${kn(shown)}${unit ? ` ${unit}` : ''}`] };
        });
        const turkey = people * (i.leftovers ? 1.5 : 1);

        return {
            value: lbKg(turkey),
            label: 'Turkey',
            sub: `Shopping for ${kn(or0(i.adults))} adults and ${kn(or0(i.kids))} children${i.leftovers ? ', with leftovers' : ''}`,
            rows: { people: `${kn(people)} adult portions`, roast: turkey >= 4 && turkey <= 24 ? 'See the Turkey Cooking Time Calculator for roasting times' : turkey > 24 ? 'Consider two turkeys' : 'A turkey breast may suit a small group', basis: 'USDA 1 lb of whole turkey a person (1½ with leftovers); other amounts are catering conventions' },
            grids: { list: { columns: ['Amount'], rows } },
        };
    },

    ham_person: (i, c) => {
        const guests = or0(i.adults) + or0(i.kids) * 0.5;

        if (guests <= 0) {
            return { empty: 'Enter the number of guests.' };
        }

        // USDA: boneless ¼–⅓ lb a person, bone-in ½–¾ lb (spiral-cut hams are bone-in).
        const per = i.bone === 'boneless' ? [0.25, 1 / 3] : [0.5, 0.75];
        const lb = guests * per[i.leftovers ? 1 : 0];
        const row = hamRow(c.data.ham, 'fully_cooked', i.bone === 'boneless' ? 'vacuum packed, boneless' : i.bone === 'spiral' ? 'slices, half, or spiral cut' : 'bone-in, whole');
        const minutes = row ? [lb * row.min_per_lb[0], lb * row.min_per_lb[1]] : null;

        return {
            value: lbKg(lb),
            label: `${i.bone === 'boneless' ? 'Boneless' : i.bone === 'spiral' ? 'Spiral-cut' : 'Bone-in'} ham`,
            sub: `${kn(per[i.leftovers ? 1 : 0])} lb a person for ${kn(guests)} adult portions${i.leftovers ? ', with leftovers' : ''}`,
            rows: {
                servings: `${kn(guests)} adult portions`,
                reheat: minutes ? `${hm(minutes[0] / 60)}–${hm(minutes[1] / 60)} at 325 °F to 140 °F (fully cooked ham, USDA)` : 'Reheat to 140 °F',
                note: 'A fresh (uncooked) ham must reach 145 °F and rest 3 minutes',
            },
        };
    },

    ham_cook: (i, c) => {
        const lb = pounds(i.weight);
        const row = c.data.ham.find((r) => `${r.type}|${r.cut}` === i.cut);

        if (!row) {
            return { empty: 'Choose the ham.' };
        }

        if (!ok(lb) || lb <= 0) {
            return { empty: 'Enter the ham weight.' };
        }

        const minutes = [lb * row.min_per_lb[0], lb * row.min_per_lb[1]];
        const target = row.type === 'fully_cooked' ? '140 °F (60 °C); 165 °F (74 °C) if not packaged in a USDA-inspected plant' : '145 °F (63 °C), then rest 3 minutes';
        const inChart = lb >= row.min_lb - 0.01 && lb <= row.max_lb + 0.01;

        return {
            value: `${hm(minutes[0] / 60)} – ${hm(minutes[1] / 60)}`,
            label: `At ${row.oven_f} °F (${kn(Math.round(((row.oven_f - 32) * 5) / 9))} °C)`,
            sub: `${kn(lb)} lb at ${row.min_per_lb[0]}–${row.min_per_lb[1]} minutes per pound (USDA FSIS)`,
            rows: {
                target,
                perLb: `${row.min_per_lb[0]}–${row.min_per_lb[1]} min per lb`,
                range: inChart ? `Chart weight ${row.min_lb}–${row.max_lb} lb` : `Outside the chart's ${row.min_lb}–${row.max_lb} lb: check early with a thermometer`,
                tip: row.type === 'fully_cooked' ? 'Cover with foil and add a little water to the pan so it does not dry out' : 'Cook uncovered, fat side up',
            },
        };
    },

    grill: (i) => {
        // Footprint per item with spacing (square inches): burger 25, hot dog or sausage 12, chicken piece 20, steak 60, ear of corn 14, kebab 16.
        const items = [['burgers', 'Burgers', 25], ['hotdogs', 'Hot dogs or sausages', 12], ['chicken', 'Chicken pieces', 20], ['steaks', 'Steaks', 60], ['corn', 'Ears of corn', 14], ['kebabs', 'Kebabs', 16]];
        const guests = or0(i.guests);
        const lines = items.map(([key, name, area]) => ({ name, count: Math.ceil(guests * or0(i[key])), area })).filter((line) => line.count > 0);
        const total = lines.reduce((sum, line) => sum + line.count * line.area, 0);

        if (total <= 0) {
            return { empty: 'Enter guests and how much of each food per guest.' };
        }

        const grillArea = or0(i.grill_area) || 363;
        const batches = Math.ceil(total / grillArea);

        return {
            value: `${kn(total)} in²`,
            label: 'Grill space for everything at once',
            sub: `${batches} batch${batches > 1 ? 'es' : ''} on a ${kn(grillArea)} in² grill (${kn(total * 6.4516 / 10000)} m² in all)`,
            rows: { batches: `${plural(batches, 'batch', 'batches')} on your grill`, kettle: `${plural(Math.ceil(total / 363), 'batch', 'batches')} on a 22 in kettle (363 in²)`, gas: `${plural(Math.ceil(total / 450), 'batch', 'batches')} on a typical 3-burner gas grill (about 450 in²)` },
            grids: { items: { columns: ['Count', 'Space'], rows: lines.map((line) => ({ header: line.name, cells: [String(line.count), `${kn(line.count * line.area)} in²`] })) } },
        };
    },

    bbq: (i) => {
        const people = or0(i.adults) + or0(i.kids) * 0.5;

        if (people <= 0) {
            return { empty: 'Enter the number of guests.' };
        }

        // About ½ lb of cooked meat per adult; raw weight allows for cooking loss (burgers 25%, bone-in chicken 35%, pulled pork or brisket 50%).
        const cooked = people * or0(i.meat_per) || people * 0.5;
        const mix = { burgers: or0(i.burgers), chicken: or0(i.chicken), pork: or0(i.pork) };
        const share = mix.burgers + mix.chicken + mix.pork || 1;
        const yieldOf = { burgers: 0.75, chicken: 0.65, pork: 0.5 };
        const raw = Object.fromEntries(Object.entries(mix).map(([key, pct]) => [key, (cooked * (pct / share)) / yieldOf[key]]));
        const rawTotal = Object.values(raw).reduce((a, b) => a + b, 0);
        // Quarter-pound burgers (raw weight) and pulled-pork sandwiches of ¼ lb cooked meat each need a bun.
        const burgers = Math.ceil(raw.burgers / 0.25);
        const buns = Math.ceil((burgers + (raw.pork * yieldOf.pork) / 0.25) * 1.1);
        const sides = people * or0(i.sides) * 0.25;

        return {
            value: lbKg(rawTotal),
            label: 'Raw meat to buy',
            sub: `${kn(cooked)} lb cooked for ${kn(people)} adult portions (${kn(cooked / people)} lb each)`,
            rows: {
                burgers: `${lbKg(raw.burgers)} ground beef (${burgers} quarter-pound burgers)`,
                chicken: `${lbKg(raw.chicken)} bone-in chicken`,
                pork: `${lbKg(raw.pork)} pork shoulder or brisket`,
                buns: `${buns} buns (10% spare)`,
                sides: `${lbKg(sides)} of sides (about 4 oz of each side a person)`,
                cost: ok(i.price_lb) && i.price_lb > 0 ? `${formatMoney(rawTotal * i.price_lb)} for the meat` : 'Enter a price per lb',
            },
        };
    },

    beer_pong: (i) => {
        const cups = Number(i.cups) || 10;
        const games = or0(i.games);

        if (games <= 0) {
            return { empty: 'Enter the number of games.' };
        }

        // Each game fills both sides' racks; a spare set of cups holds water for rinsing balls.
        const ounces = games * 2 * cups * or0(i.fill);
        const cans = Math.ceil(ounces / 12);

        return {
            value: `${cans}`,
            unit: cans === 1 ? 'can' : 'cans',
            label: '12 oz cans of beer',
            sub: `${kn(games)} games × 2 racks × ${cups} cups × ${kn(or0(i.fill))} fl oz = ${kn(ounces)} fl oz (${kn(ounces * 0.0295735)} L)`,
            rows: {
                cases: `${plural(Math.ceil(cans / 24), 'case')} of 24`,
                cups: `${cups * 2 + 2} cups per table (two racks and two water cups)`,
                table: 'Regulation table: 8 ft × 2 ft (244 × 61 cm), 27½ in high',
                responsibly: 'Have water and food available, and plan rides home',
            },
        };
    },

    party_drinks: (i) => {
        const guests = or0(i.guests);
        const hours = or0(i.hours);

        if (guests <= 0 || hours <= 0) {
            return { empty: 'Enter guests and hours.' };
        }

        // Rule of thumb: 2 drinks in the first hour, then 1 an hour.
        const drinks = guests * (2 + Math.max(0, hours - 1));
        const share = { beer: or0(i.beer), wine: or0(i.wine), spirits: or0(i.spirits), soft: or0(i.soft) };
        const sum = Object.values(share).reduce((a, b) => a + b, 0) || 1;
        const n = (key) => (drinks * share[key]) / sum;
        const beer = Math.ceil(n('beer'));
        const wine = Math.ceil(n('wine') / 5);
        const spirits = Math.ceil(n('spirits') / 16);
        const soft = Math.ceil(n('soft') / 8);
        const cost = or0(i.beer_price) * beer + or0(i.wine_price) * wine + or0(i.spirits_price) * spirits + or0(i.soft_price) * soft;

        return {
            value: kn(Math.ceil(drinks)),
            label: 'Drinks in all',
            sub: `${kn(guests)} guests over ${kn(hours)} hours: 2 the first hour, then 1 an hour`,
            rows: {
                beer: `${beer} bottles or cans (${plural(Math.ceil(beer / 24), 'case')})`,
                wine: `${wine} bottles (5 glasses each)`,
                spirits: `${spirits} bottles of 750 ml (16 drinks of 1½ oz)`,
                soft: `${soft} bottles of 2 L (8 glasses each), plus mixers`,
                ice: `${kn(guests * 1)} lb of ice for drinks (1 lb a guest), more for chilling`,
                cost: cost > 0 ? formatMoney(cost) : 'Enter prices',
            },
        };
    },

    popcorn: (i, c) => {
        const cupsPopped = i.mode === 'kernels' ? or0(i.kernels) * 32 : or0(i.people) * or0(i.per_person);

        if (cupsPopped <= 0) {
            return { empty: i.mode === 'kernels' ? 'Enter the kernels.' : 'Enter people and cups each.' };
        }

        // About 1 : 32 by volume: ½ cup of kernels pops to about 16 cups.
        const kernels = cupsPopped / 32;
        const row = ingredient(c, i.style === 'oil' ? 'popcorn_oil' : 'popcorn');
        const kcal = (row.per100.kcal * row.cup * cupsPopped) / 100;

        return {
            value: i.mode === 'kernels' ? `${kn(cupsPopped)} cups` : measure(kernels, 'cup_us'),
            label: i.mode === 'kernels' ? 'Popped popcorn' : 'Kernels to pop',
            sub: `${measure(kernels, 'cup_us')} of kernels → about ${kn(cupsPopped)} cups popped (${kn((cupsPopped * 236.6) / 1000)} L)`,
            rows: {
                tbsp: `${kn(kernels * 16)} tablespoons of kernels`,
                kcal: `${kn(Math.round(kcal))} kcal ${i.style === 'oil' ? 'oil-popped' : 'air-popped'} (${kn(Math.round((row.per100.kcal * row.cup) / 100))} a cup, USDA)`,
                bowls: `${kn(cupsPopped / 4)} bowls of 4 cups`,
                bags: `About ${kn(cupsPopped / 10)} microwave bags (about 10 cups each)`,
            },
        };
    },

    taco: (i) => {
        const people = or0(i.adults) + or0(i.kids) * 0.5;

        if (people <= 0) {
            return { empty: 'Enter the number of guests.' };
        }

        const appetite = { light: 0.8, normal: 1, hungry: 1.3 }[i.appetite] ?? 1;
        const p = people * appetite;
        const meat = p * 0.25;

        return {
            value: lbKg(meat),
            label: 'Taco meat (cooked)',
            sub: `About ${kn(Math.ceil(p * 2.5))} tacos for ${kn(people)} adult portions (2–3 each)`,
            rows: {
                raw: `${lbKg(meat / 0.75)} raw ground meat or chicken`,
                tortillas: `${kn(Math.ceil(p * 2.5 * 1.1))} tortillas or shells (10% spare)`,
                cheese: `${lbKg(p / 16)} shredded cheese (1 oz each)`,
                toppings: `${lbKg((p * 1.5) / 16)} lettuce, ${measure(p * 0.25, 'cup_us')} salsa, ${measure(p / 8, 'cup_us')} sour cream, ${measure(p / 8, 'cup_us')} guacamole`,
                sides: `${measure(p * 0.5, 'cup_us')} each of rice and beans`,
                cost: ok(i.price_lb) && i.price_lb > 0 ? `${formatMoney((meat / 0.75) * i.price_lb)} for the meat` : 'Enter a price per lb',
            },
        };
    },

    wedding_bar: (i) => {
        const guests = or0(i.guests);
        const hours = or0(i.hours);

        if (guests <= 0 || hours <= 0) {
            return { empty: 'Enter guests and reception hours.' };
        }

        const drinks = guests * hours;
        const sum = or0(i.wine) + or0(i.beer) + or0(i.spirits) || 1;
        const wine = Math.ceil((drinks * or0(i.wine)) / sum / 5);
        const beer = Math.ceil((drinks * or0(i.beer)) / sum);
        const spirits = Math.ceil((drinks * or0(i.spirits)) / sum / 16);
        const toast = i.toast ? Math.ceil(guests / 8) : 0;
        const cost = or0(i.wine_price) * (wine + toast) + or0(i.beer_price) * beer + or0(i.spirits_price) * spirits;

        return {
            value: kn(drinks),
            label: 'Drinks to plan for',
            sub: `${kn(guests)} guests × ${kn(hours)} hours at about 1 drink a guest an hour`,
            rows: {
                wine: `${wine} bottles (${plural(Math.ceil(wine / 12), 'case')} of 12)`,
                beer: `${beer} bottles or cans (${plural(Math.ceil(beer / 24), 'case')} of 24)`,
                spirits: `${spirits} bottles of 750 ml`,
                toast: toast ? `${toast} bottles of sparkling wine for the toast (8 glasses each)` : 'No toast',
                cost: cost > 0 ? formatMoney(cost) : 'Enter prices',
            },
        };
    },
};

export default defineTools(handlers);
