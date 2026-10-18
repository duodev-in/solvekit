import { GAL, money } from '../ecology/common.js';
import { addDays, addMonths, compare, longDate, parseDate, plural, toDays } from '../everyday/dates.js';
import { defineTools } from '../engines/formula.js';
import { parseRows } from '../rows-editor.js';
import { nowCivil } from './ev-time.js';

/**
 * Personal hygiene and other everyday calculators: bathing, products, babies, bags, frames and wells.
 * Unit fields arrive in base units: meters, liters, grams, °C.
 */
const IN = 0.0254;
const FT = 0.3048;
const today = (i) => addDays({ y: 1970, m: 1, d: 1 }, Math.floor(nowCivil(i) / 86400));
const inches = (m, f) => `${f(m / IN)} in (${f(m * 100)} cm)`;

/**
 * Body surface area in m² (Mosteller): √(height cm × weight kg ÷ 3600).
 */
export const bodySurface = (heightM, weightG) => Math.sqrt((heightM * 100 * (weightG / 1000)) / 3600);

/**
 * Heat needed to warm water (kWh) from cold to hot: m × 4.186 kJ/kg·K × ΔT.
 */
const heatKwh = (liters, cold, hot) => (liters * 4.186 * Math.max(0, hot - cold)) / 3600;

export const handlers = {
    bath_shower: (i, c, f) => {
        const lpm = i.flow_unit === 'lpm' ? i.flow : i.flow * GAL;

        if (!(i.bath > 0) || !(lpm > 0) || !(i.minutes > 0)) {
            return { empty: 'Enter the bath volume, shower flow and minutes.' };
        }

        const shower = lpm * i.minutes;
        const efficiency = (i.efficiency > 0 ? i.efficiency : 90) / 100;
        // Only the hot share of the water is heated: (used − cold) ÷ (heater − cold).
        const hotShare = i.hot > i.cold ? Math.min(1, Math.max(0, (i.used - i.cold) / (i.hot - i.cold))) : 1;
        const cost = (liters) => {
            const energy = heatKwh(liters * hotShare, i.cold, i.hot) / efficiency;
            const energyCost = i.energy_unit === 'therm' ? ((energy * 3412.14) / 100000) * (i.energy_price > 0 ? i.energy_price : 0) : energy * (i.energy_price > 0 ? i.energy_price : 0);
            const waterCost = (i.water_unit === 'kgal' ? liters / GAL / 1000 : liters / 1000) * (i.water_price > 0 ? i.water_price : 0);

            return { energy, total: energyCost + waterCost };
        };
        const bath = cost(i.bath);
        const showerCost = cost(shower);

        return {
            value: f(Math.abs(i.bath - shower) / GAL),
            unit: 'US gal',
            label: shower < i.bath ? 'The shower saves' : 'The bath saves',
            sub: `Bath ${f(i.bath / GAL)} gal vs shower ${f(shower / GAL)} gal (${f(lpm / GAL)} gpm × ${f(i.minutes)} min)`,
            rows: {
                bath: `${money(bath.total)} each (${f(bath.energy)} kWh to heat)`,
                shower: `${money(showerCost.total)} each (${f(showerCost.energy)} kWh to heat)`,
                breakEven: `A shower uses as much water as the bath after ${f(i.bath / lpm)} minutes`,
                metric: `Bath ${f(i.bath)} L, shower ${f(shower)} L`,
            },
        };
    },

    beauty: (i, c, f) => {
        const rows = parseRows(i.products).map((cells, k) => ({ name: cells[0] || `Product ${k + 1}`, price: Number(cells[1]), weeks: Number(cells[2]) })).filter((row) => row.price > 0 && row.weeks > 0);

        if (!rows.length) {
            return { empty: 'Add products with a price and how many weeks each lasts.' };
        }

        const items = rows.map((row) => ({ ...row, year: (row.price * 52.1786) / row.weeks }));
        const year = items.reduce((sum, item) => sum + item.year, 0);

        return {
            value: money(year),
            label: 'Cost a year',
            sub: `${items.length} products`,
            rows: { month: money(year / 12), day: money(year / 365.25), ten: `${money(year * 10)} over 10 years` },
            lists: { items: items.sort((a, b) => b.year - a.year).map((item) => ({ label: item.name, value: `${money(item.year)} a year (${money(item.price)} every ${f(item.weeks)} weeks)` })) },
        };
    },

    masks: (i, c, f) => {
        if (!(i.people > 0) || !(i.per_day > 0) || !(i.days > 0)) {
            return { empty: 'Enter people, masks a day and days.' };
        }

        const masks = Math.ceil(i.people * i.per_day * i.days);
        const cost = masks * (i.price > 0 ? i.price : 0);
        const reusable = i.cloth > 0 && i.cloth_price > 0 ? i.cloth * i.people * i.cloth_price * Math.ceil(i.days / (i.cloth_days > 0 ? i.cloth_days : 365)) : null;

        return {
            value: f(masks),
            unit: 'disposable masks',
            label: 'Masks needed',
            sub: `${plural(i.people, 'person', 'people')} × ${f(i.per_day)} a day × ${plural(i.days, 'day')}`,
            rows: { cost: i.price > 0 ? money(cost) : 'Enter a price per mask', boxes: `${f(Math.ceil(masks / 50))} boxes of 50`, reusable: reusable === null ? 'Enter reusable mask details to compare' : `${money(reusable)} for reusable masks` },
        };
    },

    hair_growth: (i, c, f) => {
        if (!(i.current >= 0) || !(i.target > i.current) || !(i.rate > 0)) {
            return { empty: 'Enter the current and a longer target length, and the growth rate.' };
        }

        const months = (i.target - i.current) / i.rate;
        const start = i.start ? parseDate(i.start) : today(i);
        const whole = Math.floor(months);
        const done = start ? addDays(addMonths(start, whole), Math.round((months - whole) * 30.44)) : null;

        return {
            value: f(months),
            unit: 'months',
            label: 'Time to reach your length',
            sub: `${inches(i.target - i.current, f)} to grow at ${inches(i.rate, f)} a month`,
            rows: { date: done ? `Around ${longDate(done)}` : '—', years: `${f(months / 12)} years`, trims: 'Trims take length off: add the length you cut to the target', note: 'Growth varies with age, genes and health' },
        };
    },

    sunscreen: (i, c, f) => {
        if (!(i.height > 0) || !(i.weight > 0)) {
            return { empty: 'Enter your height and weight.' };
        }

        const share = ['face', 'arms', 'front', 'back', 'legs'].reduce((sum, key) => sum + (i[key] ? { face: 9, arms: 18, front: 18, back: 18, legs: 36 }[key] : 0), 0) / 100;

        if (!(share > 0)) {
            return { empty: 'Tick the areas you cover.' };
        }

        const area = bodySurface(i.height, i.weight);
        const grams = area * 10000 * share * 0.002;
        const perDay = i.per_day > 0 ? i.per_day : 1;
        const total = grams * perDay * (i.days > 0 ? i.days : 1) * (i.people > 0 ? i.people : 1);
        const bottle = i.bottle > 0 ? i.bottle * 1000 : null;

        return {
            value: f(grams),
            unit: 'g per application',
            label: 'Sunscreen for full protection',
            sub: `${f(area)} m² body × ${f(share * 100)}% covered × 2 mg/cm² (the SPF test amount)`,
            rows: {
                ml: `About ${f(grams)} mL, ${f(grams / 29.57)} fl oz (${f(grams / 5)} teaspoons)`,
                trip: `${f(total)} g for the whole trip`,
                bottles: bottle ? `${f(Math.ceil(total / bottle))} bottles of ${f(Math.round((bottle / 1000 / 0.0295735) * 10) / 10)} fl oz (${f(Math.round(bottle))} mL)` : 'Enter the bottle size',
                note: 'Reapply at least every 2 hours and after swimming or sweating (FDA label rule)',
            },
        };
    },

    toilet_paper: (i, c, f) => {
        if (!(i.people > 0) || !(i.uses > 0) || !(i.sheets > 0) || !(i.per_roll > 0)) {
            return { empty: 'Enter people, uses a day, sheets per use and sheets per roll.' };
        }

        const sheetsDay = i.people * i.uses * i.sheets;
        const rollsWeek = (sheetsDay * 7) / i.per_roll;
        const pack = i.pack > 0 ? i.pack : null;

        return {
            value: f(rollsWeek),
            unit: 'rolls a week',
            label: 'Toilet paper used',
            sub: `${f(sheetsDay)} sheets a day ÷ ${f(i.per_roll)} sheets a roll`,
            rows: { month: `${f(rollsWeek * 4.348)} rolls a month`, year: `${f(Math.ceil(rollsWeek * 52.18))} rolls a year`, pack: pack ? `A ${f(pack)}-roll pack lasts ${f((pack * i.per_roll) / sheetsDay)} days` : 'Enter a pack size' },
        };
    },

    toothpaste: (i, c, f) => {
        if (!(i.tube > 0) || !(i.amount > 0) || !(i.people > 0) || !(i.brushings > 0)) {
            return { empty: 'Enter the tube size, amount per brushing, people and brushings a day.' };
        }

        const perDay = i.amount * i.people * i.brushings;
        const days = i.tube / perDay;

        return {
            value: f(days),
            unit: 'days',
            label: 'A tube lasts',
            sub: `${f(i.tube)} g ÷ (${f(i.amount)} g × ${f(i.people)} × ${f(i.brushings)} a day)`,
            rows: { tubes: `${f(Math.ceil(365.25 / days))} tubes a year`, cost: i.price > 0 ? `${money((365.25 / days) * i.price)} a year` : 'Enter a tube price', note: 'Dentists advise a pea-sized amount for children 3–6 and a rice-grain smear under 3' },
        };
    },

    battery_charge: (i, c, f) => {
        const wh = i.mode === 'wh' ? i.wh : i.ah * i.volts;
        const power = i.charger_mode === 'watts' ? i.charger_w : i.charger_a * (i.volts > 0 ? i.volts : NaN);

        if (!(wh > 0) || !(power > 0) || !(i.to > i.from)) {
            return { empty: 'Enter the battery capacity, charger rating and a target above the start charge.' };
        }

        const efficiency = (i.efficiency > 0 ? i.efficiency : 85) / 100;
        const needed = (wh * (i.to - i.from)) / 100;
        const hours = needed / (power * efficiency);

        return {
            value: hours >= 1 ? `${Math.floor(hours)} h ${Math.round((hours % 1) * 60)} min` : `${Math.round(hours * 60)} min`,
            label: 'Charging time',
            sub: `${f(needed)} Wh ÷ (${f(power)} W × ${f(efficiency * 100)}%)`,
            rows: { energy: `${f(needed / efficiency)} Wh from the charger`, cost: i.price > 0 ? money((needed / efficiency / 1000) * i.price) : 'Enter an electricity price', note: 'Lithium batteries slow down near full (constant-voltage stage), so the last 20% takes longer' },
        };
    },

    baby_cost: (i, c, f) => {
        const rows = parseRows(i.items).map((cells, k) => ({ name: cells[0] || `Item ${k + 1}`, cost: Number(cells[1]), months: Number(cells[2]) })).filter((row) => row.cost > 0);

        if (!rows.length) {
            return { empty: 'Add costs, each with how many months it applies (1 for a one-off).' };
        }

        const items = rows.map((row) => ({ ...row, total: row.cost * (row.months > 0 ? row.months : 1) }));
        const total = items.reduce((sum, item) => sum + item.total, 0);

        return {
            value: money(total),
            label: 'First-year cost',
            sub: `${items.length} budget lines`,
            rows: { month: `${money(total / 12)} a month on average`, biggest: `Biggest: ${items.reduce((a, b) => (b.total > a.total ? b : a)).name}`, note: 'Your own figures: costs vary hugely with location, insurance and childcare' },
            lists: { items: items.sort((a, b) => b.total - a.total).map((item) => ({ label: item.name, value: `${money(item.total)}${item.months > 1 ? ` (${money(item.cost)} × ${f(item.months)} months)` : ''}` })) },
        };
    },

    diapers: (i, c, f) => {
        const from = i.from >= 0 ? i.from : NaN;
        const to = i.to > from ? i.to : NaN;

        if (!(to > from)) {
            return { empty: 'Enter the age range in months.' };
        }

        const bands = [[0, 1, i.band1], [1, 5, i.band2], [5, 12, i.band3], [12, 48, i.band4]];
        let total = 0;
        const lists = [];

        bands.forEach(([start, end, perDay]) => {
            const months = Math.max(0, Math.min(end, to) - Math.max(start, from));

            if (months > 0 && perDay > 0) {
                const count = months * 30.4375 * perDay;
                total += count;
                lists.push({ label: `${start}–${end === 48 ? 'potty training' : `${end} months`}`, value: `${f(Math.round(count))} diapers (${f(perDay)} a day for ${plural(months, 'month')})` });
            }
        });

        if (!(total > 0)) {
            return { empty: 'Enter changes a day for the ages covered.' };
        }

        return {
            value: f(Math.round(total)),
            unit: 'diapers',
            label: `Diapers from ${f(from)} to ${f(to)} months`,
            sub: `About ${f(total / ((to - from) * 30.4375))} a day on average`,
            rows: { cost: i.price > 0 ? `${money(total * i.price)} (${money((total * i.price) / (to - from))} a month)` : 'Enter a price per diaper', boxes: `${f(Math.ceil(total / 150))} boxes of 150` },
            lists: { bands: lists },
        };
    },

    expiry: (i, c, f) => {
        const start = parseDate(i.start);
        const on = i.on ? parseDate(i.on) : today(i);

        if (!start || !(i.life > 0) || !on) {
            return { empty: 'Enter the date and the shelf life.' };
        }

        const n = Math.round(i.life);
        const end = i.life_unit === 'days' ? addDays(start, n) : i.life_unit === 'weeks' ? addDays(start, n * 7) : i.life_unit === 'years' ? addMonths(start, n * 12) : addMonths(start, n);
        const left = toDays(end) - toDays(on);

        return {
            value: longDate(end),
            label: 'Use by',
            sub: `${plural(n, i.life_unit.replace(/s$/, ''))} after ${longDate(start)}`,
            rows: { left: left > 0 ? `${plural(left, 'day')} left` : left === 0 ? 'Expires today' : `Expired ${plural(-left, 'day')} ago`, status: compare(end, on) > 0 ? 'Still within its shelf life' : 'Past its shelf life', note: 'The open-jar symbol (e.g. 12M) means use within 12 months of opening' },
        };
    },

    garbage_bag: (i, c, f) => {
        const round = i.shape === 'round';
        const perimeter = round ? Math.PI * i.diameter : 2 * (i.length + i.width);
        const bottom = round ? i.diameter : Math.min(i.length, i.width);
        const volume = round ? Math.PI * (i.diameter / 2) ** 2 * i.height : i.length * i.width * i.height;

        if (!(perimeter > 0) || !(i.height > 0)) {
            return { empty: 'Enter the bin\'s size.' };
        }

        const overhang = i.overhang > 0 ? i.overhang : 4 * IN;
        const width = perimeter / 2;
        const length = i.height + bottom / 2 + overhang;

        return {
            value: `${f(Math.ceil(width / IN))} × ${f(Math.ceil(length / IN))} in`,
            label: 'Bag size (flat width × length)',
            sub: `${f(Math.ceil(width * 100))} × ${f(Math.ceil(length * 100))} cm`,
            rows: { capacity: `${f((volume * 1000) / GAL)} US gal (${f(volume * 1000)} L) bin`, rule: `Width = half the bin\'s perimeter; length = height + half the base + ${f(overhang / IN)} in overhang` },
        };
    },

    headphones: (i, c, f) => {
        if (!Number.isFinite(i.sensitivity) || !(i.impedance > 0) || !Number.isFinite(i.spl)) {
            return { empty: 'Enter the sensitivity, impedance and target loudness.' };
        }

        let mw;
        let volts;

        if (i.basis === 'v') {
            volts = 10 ** ((i.spl - i.sensitivity) / 20);
            mw = (volts ** 2 / i.impedance) * 1000;
        } else {
            mw = 10 ** ((i.spl - i.sensitivity) / 10);
            volts = Math.sqrt((mw / 1000) * i.impedance);
        }

        return {
            value: f(mw),
            unit: 'mW',
            label: `Power for ${f(i.spl)} dB SPL`,
            sub: `${f(i.sensitivity)} dB/${i.basis === 'v' ? 'V' : 'mW'} at ${f(i.impedance)} Ω`,
            rows: { volts: `${f(volts)} V RMS`, current: `${f((volts / i.impedance) * 1000)} mA`, safety: 'NIOSH: 85 dBA is safe for 8 hours; each +3 dB halves the safe time' },
        };
    },

    linear_inches: (i, c, f) => {
        if (!(i.length > 0) || !(i.width > 0) || !(i.height > 0)) {
            return { empty: 'Enter the length, width and height.' };
        }

        const total = i.length + i.width + i.height;
        const limit = i.limit > 0 ? i.limit : 62 * IN;

        return {
            value: f(total / IN),
            unit: 'linear inches',
            label: 'Total dimensions',
            sub: `${f(i.length / IN)} + ${f(i.width / IN)} + ${f(i.height / IN)} in = ${f(total * 100)} cm`,
            rows: { limit: Math.abs(total - limit) < 0.001 ? 'Exactly at the limit' : total <= limit ? `Within the ${f(limit / IN)} in (${f(limit * 100)} cm) limit by ${f((limit - total) / IN)} in` : `${f((total - limit) / IN)} in over the ${f(limit / IN)} in limit`, note: 'Many airlines allow 62 linear inches (158 cm) for checked bags; carry-on limits are often 22 × 14 × 9 in. Check your airline' },
        };
    },

    picture_frame: (i, c, f) => {
        if (!(i.art_w > 0) || !(i.art_h > 0) || !(i.moulding > 0)) {
            return { empty: 'Enter the artwork size and moulding width.' };
        }

        const overlap = i.overlap >= 0 ? i.overlap : 0.25 * IN;
        const side = i.mat > 0 ? i.mat : 0;
        const bottomExtra = i.bottom > 0 ? i.bottom : 0;
        const openW = i.art_w - 2 * overlap;
        const openH = i.art_h - 2 * overlap;
        const matW = openW + 2 * side;
        const matH = openH + 2 * side + bottomExtra;
        const outerW = matW + 2 * (i.moulding - (i.rabbet > 0 ? i.rabbet : 0));
        const outerH = matH + 2 * (i.moulding - (i.rabbet > 0 ? i.rabbet : 0));
        const run = 2 * (outerW + outerH);

        return {
            value: `${f(outerW / IN)} × ${f(outerH / IN)} in`,
            label: 'Frame outside size',
            sub: `${f(outerW * 100)} × ${f(outerH * 100)} cm`,
            rows: { opening: side > 0 ? `Mat opening ${f(openW / IN)} × ${f(openH / IN)} in` : 'No mat', glass: `Glass and backing ${f(matW / IN)} × ${f(matH / IN)} in`, moulding: `${f(run / IN)} in (${f(run / FT)} ft) of moulding along the outside edge; buy about 10% extra for cuts` },
        };
    },

    screen_time: (i, c, f) => {
        if (!(i.minutes > 0)) {
            return { empty: 'Enter minutes a day.' };
        }

        const hours = (i.minutes * 365.25) / 60;
        const book = 90000 / 238 / 60;

        return {
            value: f(Math.round(hours)),
            unit: 'hours a year',
            label: 'Time spent',
            sub: `${f(i.minutes)} minutes a day = ${f(hours / 24)} full days a year`,
            rows: {
                books: `${f(Math.floor(hours / book))} novels of 90,000 words at 238 words a minute`,
                language: `${f((hours / 675) * 100)}% of the 600–750 class hours FSI estimates for Spanish or French`,
                run: `${f(hours / 13.5)} times through the 9-week Couch to 5K plan (about 13.5 hours of running)`,
                life: `${f((i.minutes / (16 * 60)) * 100)}% of 16 waking hours`,
            },
        };
    },

    well: (i, c, f) => {
        if (!(i.diameter > 0) || !(i.depth > 0) || !(i.static >= 0) || i.static >= i.depth) {
            return { empty: 'Enter the casing diameter, well depth and a water level above the bottom.' };
        }

        const column = i.depth - i.static;
        const liters = Math.PI * (i.diameter / 2) ** 2 * column * 1000;
        const perFoot = (Math.PI * (i.diameter / 2) ** 2 * FT * 1000) / GAL;

        return {
            value: f(liters / GAL),
            unit: 'US gal',
            label: 'Water stored in the well',
            sub: `${f(column / FT)} ft (${f(column)} m) of water in a ${f(i.diameter / IN)} in casing`,
            rows: { liters: `${f(liters)} L`, perFoot: `${f(perFoot)} gal per foot of water`, note: 'Stored water only; how much the well can supply also depends on its recovery rate' },
        };
    },
};

export default defineTools(handlers);
