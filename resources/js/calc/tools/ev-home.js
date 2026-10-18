import { GAL, money } from '../ecology/common.js';
import { defineTools } from '../engines/formula.js';
import { parseRows } from '../rows-editor.js';

/**
 * Home economics: household energy and costs, lighting, pools and furnishing.
 * Unit fields arrive in base units: meters, m², liters, grams, °C.
 */
const IN = 0.0254;
const FT = 0.3048;
const inches = (m, f) => `${f(m / IN)} in (${f(m * 100)} cm)`;
const feetIn = (m) => {
    const total = Math.round(m / IN);

    return `${Math.floor(total / 12)}′ ${total % 12}″`;
};
const num = (value) => (value === '' || value === undefined ? NaN : Number(value));
const cash = (amount) => (Math.abs(amount) < 1 ? `${(amount * 100).toFixed(1)}¢` : money(amount));

/**
 * Rows of a text-and-numbers editor: [name, …numbers]; rows without a usable first number are skipped.
 */
function namedRows(text, columns) {
    return parseRows(text).map((cells, index) => ({ name: cells[0] || `Row ${index + 1}`, values: cells.slice(1, columns + 1).map(num) })).filter((row) => row.values.some((value) => value > 0));
}

/**
 * Perimeter of half an ellipse (Ramanujan's approximation, within 0.01% for arch shapes).
 */
export function halfEllipse(a, b) {
    const h = ((a - b) / (a + b)) ** 2;

    return (Math.PI * (a + b) * (1 + (3 * h) / (10 + Math.sqrt(4 - 3 * h)))) / 2;
}

export const handlers = {
    depreciation: (i, c, f) => {
        const life = i.appliance === 'custom' ? i.life : c.data.appliance_life[i.appliance]?.[1];

        if (!(i.price > 0) || !(life > 0) || !(i.age >= 0)) {
            return { empty: 'Enter the price, age and useful life.' };
        }

        const salvage = i.salvage > 0 ? i.salvage : 0;
        const schedule = [];
        let value = i.price;

        for (let year = 1; year <= Math.ceil(life); year += 1) {
            const loss = i.method === 'declining' ? Math.max(0, Math.min(value * (2 / life), value - salvage)) : (i.price - salvage) / life;
            value = Math.max(salvage, value - loss);
            schedule.push({ year, value });
        }

        const at = (age) => {
            if (age <= 0) {
                return i.price;
            }

            if (age >= life) {
                return salvage;
            }

            const whole = Math.floor(age);
            const start = whole === 0 ? i.price : schedule[whole - 1].value;
            const end = schedule[whole]?.value ?? salvage;

            return start - (start - end) * (age - whole);
        };
        const now = at(i.age);

        return {
            value: money(now),
            label: 'Current value',
            sub: `${f(i.age)} of ${f(life)} years, ${i.method === 'declining' ? 'double-declining balance' : 'straight line'}`,
            rows: {
                lost: `${money(i.price - now)} lost (${f(((i.price - now) / i.price) * 100)}%)`,
                yearly: i.method === 'declining' ? `${money(i.price * (2 / life))} in the first year, less each year` : `${money((i.price - salvage) / life)} a year`,
                left: i.age >= life ? 'Past its typical life' : `${f(life - i.age)} years of typical life left`,
            },
            lists: { schedule: schedule.map((row) => ({ label: `End of year ${row.year}`, value: money(row.value), highlight: Math.ceil(i.age) === row.year })) },
        };
    },

    appliance_wattage: (i, c, f) => {
        const rows = namedRows(i.appliances, 3);

        if (!rows.length) {
            return { empty: 'Add appliances with their watts and hours of use a day.' };
        }

        const items = rows.map(({ name, values: [watts, hours, days] }) => ({ name, kwh: ((watts > 0 ? watts : 0) * (hours > 0 ? hours : 0) * ((days > 0 ? days : 7) / 7)) / 1000 }));
        const day = items.reduce((sum, item) => sum + item.kwh, 0);
        const price = i.price > 0 ? i.price : null;

        return {
            value: f(day * 30.4375),
            unit: 'kWh a month',
            label: 'Electricity used',
            sub: `${f(day)} kWh a day on average`,
            rows: { year: `${f(day * 365.25)} kWh a year`, cost: price ? `${money(day * 30.4375 * price)} a month, ${money(day * 365.25 * price)} a year` : 'Enter an electricity price' },
            lists: { items: items.map((item) => ({ label: item.name, value: `${f(item.kwh * 30.4375)} kWh/month${price ? ` · ${money(item.kwh * 30.4375 * price)}` : ''}` })) },
        };
    },

    shopping_list: (i, c, f) => {
        const rows = namedRows(i.items, 2);

        if (!rows.length) {
            return { empty: 'Add items with a quantity and price.' };
        }

        const lines = rows.map(({ name, values: [qty, price] }) => ({ name, total: (qty > 0 ? qty : 1) * (price > 0 ? price : 0) }));
        const subtotal = lines.reduce((sum, line) => sum + line.total, 0);
        const discount = i.coupons > 0 ? Math.min(i.coupons, subtotal) : 0;
        const tax = ((subtotal - discount) * (i.tax > 0 ? i.tax : 0)) / 100;
        const total = subtotal - discount + tax;
        const people = i.people > 0 ? i.people : 1;

        return {
            value: money(total * people),
            label: people > 1 ? `Total for ${f(people)}` : 'Total',
            sub: `${money(subtotal)} − ${money(discount)} coupons + ${money(tax)} tax${people > 1 ? ` = ${money(total)} each` : ''}`,
            rows: { subtotal: money(subtotal), tax: money(tax), each: money(total), items: `${f(lines.length)} items` },
            lists: { lines: lines.map((line) => ({ label: line.name, value: money(line.total) })) },
        };
    },

    balloon_arch: (i, c, f) => {
        const length = i.shape === 'arch' ? (i.width > 0 && i.height > 0 ? halfEllipse(i.width / 2, i.height) : NaN) : i.length;

        if (!(length > 0)) {
            return { empty: 'Enter the arch width and height, or the garland length.' };
        }

        let balloons;
        let detail;

        if (i.style === 'organic') {
            const perFoot = i.per_foot > 0 ? i.per_foot : 15;
            balloons = Math.ceil((length / FT) * perFoot);
            detail = `${f(perFoot)} mixed balloons per foot`;
        } else {
            const size = Number(i.size) * IN;
            const clusters = Math.ceil(length / size);
            balloons = clusters * 4;
            detail = `${f(clusters)} clusters of 4 × ${f(Number(i.size))}-inch balloons`;
        }

        return {
            value: f(balloons),
            unit: 'balloons',
            label: 'Balloons needed',
            sub: detail,
            rows: { length: `${f(length / FT)} ft (${f(length)} m) along the ${i.shape === 'arch' ? 'arch' : 'garland'}`, spare: `${f(Math.ceil(balloons * 1.1))} with 10% spare for pops`, note: 'Classic arches pack one 4-balloon cluster per balloon width; organic garlands are a decorator\'s rule of thumb' },
        };
    },

    mirror: (i, c, f) => {
        if (!(i.vanity > 0) || !(i.counter > 0)) {
            return { empty: 'Enter the vanity width and counter height.' };
        }

        const sinks = i.double ? 2 : 1;
        const maxWidth = i.double ? i.vanity / 2 - 2 * IN : i.vanity - 4 * IN;
        const minWidth = i.double ? i.vanity / 2 - 8 * IN : i.vanity - 8 * IN;
        const bottom = i.counter + (i.faucet > 0 ? i.faucet : 0) + 5 * IN;
        const eye = (i.person > 0 ? i.person : 70 * IN) - 4.5 * IN;
        const top = eye + 8 * IN;

        return {
            value: `${Math.round(minWidth / IN)}–${Math.round(maxWidth / IN)} in`,
            label: sinks > 1 ? 'Width of each mirror' : 'Mirror width',
            sub: `${Math.round(minWidth * 100)}–${Math.round(maxWidth * 100)} cm: ${sinks > 1 ? 'one mirror centered over each sink' : 'a few inches narrower than the vanity'}`,
            rows: {
                height: `${inches(Math.max(0, top - bottom), f)} tall, from ${feetIn(bottom)} to ${feetIn(top)} above the floor`,
                bottom: `${feetIn(bottom)}: 5 in above the faucet`,
                center: `Center at about ${feetIn((top + bottom) / 2)}`,
                note: 'Design guidelines, not code: adjust for lights, cabinets and the tallest user',
            },
        };
    },

    bean_bag: (i, c, f) => {
        let volume;

        if (i.shape === 'sphere') {
            volume = (4 / 3) * Math.PI * (i.diameter / 2) ** 3;
        } else if (i.shape === 'cylinder') {
            volume = Math.PI * (i.diameter / 2) ** 2 * i.height;
        } else {
            volume = i.length * i.width * i.height;
        }

        volume *= 1000;

        if (!(volume > 0)) {
            return { empty: 'Enter the bag\'s size.' };
        }

        const fill = (i.fill > 0 ? i.fill : 80) / 100;
        const liters = volume * fill;
        const bags = i.bag > 0 ? Math.ceil(liters / i.bag) : null;

        return {
            value: f(liters),
            unit: 'liters',
            label: 'Filling needed',
            sub: `${f(volume)} L bag × ${f(fill * 100)}% full`,
            rows: { ft3: `${f(liters / 28.316846592)} ft³`, bags: bags ? `${bags} bags of ${f(i.bag)} L` : 'Enter the filling bag size', note: 'Bean bags are usually filled 70–85% so they can mould to you' },
        };
    },

    bed_size: (i, c, f) => {
        const region = c.data.mattresses[i.region];

        if (!region) {
            return { empty: 'Choose a region.' };
        }

        const unitM = region[1] === 'in' ? IN : 0.01;
        const sizes = region[2].map(([name, w, l]) => ({ name, w: w * unitM, l: l * unitM, label: `${w} × ${l} ${region[1]}` }));
        const chosen = sizes[Number(i.size)] ?? sizes[0];
        const clearance = i.clearance > 0 ? i.clearance : 0.6;
        const fits = (s) => i.room_length > 0 && i.room_width > 0 && s.l + clearance <= i.room_length && s.w + 2 * clearance <= i.room_width;

        return {
            value: chosen.label,
            label: `${chosen.name} (${region[0]})`,
            sub: region[1] === 'in' ? `${f(chosen.w * 100)} × ${f(chosen.l * 100)} cm` : `${f(chosen.w / IN)} × ${f(chosen.l / IN)} in`,
            rows: {
                area: `${f(chosen.w * chosen.l)} m² (${f((chosen.w * chosen.l) / FT ** 2)} ft²)`,
                fit: i.room_length > 0 && i.room_width > 0 ? (fits(chosen) ? `Fits with ${f(clearance * 100)} cm (${f(clearance / IN)} in) walkways at the foot and both sides` : 'Too tight for walkways at the foot and both sides') : 'Enter the room size to check',
            },
            lists: { sizes: sizes.map((s) => ({ label: s.name, value: `${s.label}${i.room_length > 0 && i.room_width > 0 ? (fits(s) ? ' · fits' : ' · tight') : ''}`, highlight: s === chosen })) },
        };
    },

    blind_size: (i, c, f) => {
        if (!(i.width > 0) || !(i.height > 0)) {
            return { empty: 'Enter the window opening width and height.' };
        }

        if (i.mount === 'inside') {
            return {
                value: `${f(i.width / IN)} × ${f(i.height / IN)} in`,
                label: 'Order size (inside mount)',
                sub: 'Order the exact opening; the maker deducts for clearance',
                rows: { metric: `${f(i.width * 100)} × ${f(i.height * 100)} cm`, measure: 'Measure the width at the top, middle and bottom and use the narrowest; the height at left, middle and right and use the longest', depth: 'Check the window has enough depth for the headrail' },
            };
        }

        const side = i.overlap > 0 ? i.overlap : 1.5 * IN;
        const top = i.top > 0 ? i.top : 3 * IN;

        return {
            value: `${f((i.width + 2 * side) / IN)} × ${f((i.height + top + side) / IN)} in`,
            label: 'Order size (outside mount)',
            sub: `Opening + ${f(side / IN)} in each side, ${f(top / IN)} in above for the headrail and ${f(side / IN)} in below`,
            rows: { metric: `${f((i.width + 2 * side) * 100)} × ${f((i.height + top + side) * 100)} cm`, measure: 'Overlap of 1½–3 in each side blocks light and gives privacy', depth: 'Check nothing blocks the headrail brackets' },
        };
    },

    data_usage: (i, c, f) => {
        const s = c.data.streaming;
        const video = { low: s.video_low, medium: s.video_medium, sd: s.video_sd, hd: s.video_hd, uhd: s.video_4k }[i.video_quality] ?? s.video_hd;
        const music = { normal: s.music_normal, high: s.music_high, very_high: s.music_very_high }[i.music_quality] ?? s.music_high;
        const parts = [
            ['Video streaming', i.video, video],
            ['Music streaming', i.music, music],
            ['Video calls', i.calls, s.video_call],
            ['Social media and web', i.web, (i.web_rate > 0 ? i.web_rate : 0) / 1000],
            ['Online gaming', i.gaming, (i.gaming_rate > 0 ? i.gaming_rate : 0) / 1000],
        ].map(([name, hours, rate]) => ({ name, gb: (hours > 0 ? hours : 0) * rate * 30.4375 }));
        const total = parts.reduce((sum, part) => sum + part.gb, 0);

        if (!(total > 0)) {
            return { empty: 'Enter hours a day for at least one activity.' };
        }

        const plan = i.plan > 0 ? i.plan : null;

        return {
            value: f(total),
            unit: 'GB a month',
            label: 'Data used',
            sub: `${f(total / 30.4375)} GB a day`,
            rows: { plan: plan ? (total <= plan ? `Fits your ${f(plan)} GB plan with ${f(plan - total)} GB spare` : `${f(total - plan)} GB over your ${f(plan)} GB plan`) : 'Enter your plan allowance', year: `${f(total * 12 / 1000)} TB a year` },
            lists: { parts: parts.filter((part) => part.gb > 0).map((part) => ({ label: part.name, value: `${f(part.gb)} GB/month` })) },
        };
    },

    dilution: (i, c, f) => {
        if (!(i.ratio > 0)) {
            return { empty: 'Enter the ratio as parts of water per part of concentrate.' };
        }

        let concentrate;
        let water;

        if (i.mode === 'total') {
            if (!(i.total > 0)) {
                return { empty: 'Enter the amount of mix you want.' };
            }

            concentrate = i.total / (1 + i.ratio);
            water = i.total - concentrate;
        } else {
            if (!(i.concentrate > 0)) {
                return { empty: 'Enter the amount of concentrate.' };
            }

            concentrate = i.concentrate;
            water = concentrate * i.ratio;
        }

        const ml = (liters) => (liters < 1 ? `${f(liters * 1000)} mL` : `${f(liters)} L`);

        return {
            value: ml(concentrate),
            label: 'Concentrate',
            sub: `+ ${ml(water)} of water at 1:${f(i.ratio)}`,
            rows: { water: `${ml(water)} (${f(water / 0.0295735295625)} US fl oz)`, concentrate: `${f(concentrate / 0.0295735295625)} US fl oz of concentrate`, total: ml(concentrate + water), percent: `${f(100 / (1 + i.ratio))}% concentrate` },
        };
    },

    electricity: (i, c, f) => {
        let kwhDay;
        let detail;

        if (i.mode === 'once') {
            if (!(i.watts > 0) || !(i.minutes > 0)) {
                return { empty: 'Enter the power and how long one use lasts.' };
            }

            const kwh = (i.watts * i.minutes) / 60 / 1000;
            const price = i.price > 0 ? i.price : null;

            return {
                value: price ? cash(kwh * price) : `${f(kwh)} kWh`,
                label: 'Cost of one use',
                sub: `${f(i.watts)} W × ${f(i.minutes)} min = ${f(kwh)} kWh`,
                rows: { day: price && i.uses > 0 ? `${money(kwh * price * i.uses)} a day at ${f(i.uses)} uses` : 'Enter uses a day', month: price && i.uses > 0 ? money(kwh * price * i.uses * 30.4375) : '—', year: price && i.uses > 0 ? money(kwh * price * i.uses * 365.25) : '—', kwh: `${f(kwh * 1000)} Wh` },
            };
        }

        if (i.mode === 'kwh') {
            kwhDay = i.kwh_month / 30.4375;
            detail = `${f(i.kwh_month)} kWh a month`;
        } else {
            kwhDay = ((i.watts > 0 ? i.watts : NaN) * (i.hours > 0 ? i.hours : NaN)) / 1000;
            detail = `${f(i.watts)} W × ${f(i.hours)} h a day`;
        }

        if (!(kwhDay > 0) || !(i.price > 0)) {
            return { empty: 'Enter the power and hours a day (or kWh) and your price.' };
        }

        return {
            value: money(kwhDay * 30.4375 * i.price),
            label: 'Cost a month',
            sub: `${detail} at ${money(i.price)}/kWh`,
            rows: { day: money(kwhDay * i.price), month: `${f(kwhDay * 30.4375)} kWh a month`, year: `${money(kwhDay * 365.25 * i.price)} a year`, kwh: `${f(kwhDay * 365.25)} kWh a year` },
        };
    },

    eui: (i, c, f) => {
        const fuels = c.data.source_site;
        let site = 0;
        let source = 0;
        const parts = [];

        Object.entries(fuels).forEach(([key, [name, unitName, kbtu, ratio]]) => {
            const amount = i[key];

            if (amount > 0) {
                site += amount * kbtu;
                source += amount * kbtu * ratio;
                parts.push({ label: name, value: `${f(amount)} ${unitName} = ${f(amount * kbtu)} kBtu site, ${f(amount * kbtu * ratio)} kBtu source` });
            }
        });

        if (!(site > 0) || !(i.area > 0)) {
            return { empty: 'Enter a year of energy use and the floor area.' };
        }

        const ft2 = i.area / FT ** 2;
        const median = c.data.eui_medians[i.type];
        const siteEui = site / ft2;
        const sourceEui = source / ft2;

        return {
            value: f(siteEui),
            unit: 'kBtu/ft²',
            label: 'Site EUI',
            sub: `${f(site)} kBtu over ${f(ft2)} ft² in a year`,
            rows: {
                source: `${f(sourceEui)} kBtu/ft² source EUI`,
                metric: `${f((siteEui * 1055.05585262) / 1000 / (FT ** 2) / 3.6)} kWh/m² site`,
                median: median ? `National median for ${median[0].toLowerCase()}: ${median[1]} source, ${median[2]} site; yours is ${f((sourceEui / median[1]) * 100)}% of the median source EUI` : '—',
            },
            lists: { parts },
        };
    },

    dryer: (i, c, f) => {
        if (!(i.loads > 0) || !(i.power_price > 0)) {
            return { empty: 'Enter loads a week and your electricity price.' };
        }

        const loads = i.loads * 52.18;
        const electric = loads * i.electric_kwh * i.power_price;
        const gasTherms = loads * i.gas_therms;
        const gas = gasTherms * (i.gas_price > 0 ? i.gas_price : 0) + loads * i.gas_kwh * i.power_price;

        return {
            value: money(Math.abs(electric - gas)),
            label: electric > gas ? 'Gas dryer saves a year' : 'Electric dryer saves a year',
            sub: `${f(loads)} loads a year`,
            rows: { electric: `${money(electric)} a year (${f(loads * i.electric_kwh)} kWh)`, gas: `${money(gas)} a year (${f(gasTherms)} therms + ${f(loads * i.gas_kwh)} kWh)`, load: `${money(i.electric_kwh * i.power_price)} vs ${money(i.gas_therms * i.gas_price + i.gas_kwh * i.power_price)} per load` },
        };
    },

    generator: (i, c, f) => {
        const rows = namedRows(i.appliances, 3);

        if (!rows.length) {
            return { empty: 'Add appliances with their running and starting watts.' };
        }

        const items = rows.map(({ name, values: [running, starting, qty] }) => ({ name, running: (running > 0 ? running : 0) * (qty > 0 ? qty : 1), surge: Math.max(0, (starting > 0 ? starting : running) - running) }));
        const running = items.reduce((sum, item) => sum + item.running, 0);
        const largest = items.reduce((best, item) => (item.surge > best.surge ? item : best), items[0]);
        const peak = running + largest.surge;
        const margin = 1 + (i.margin > 0 ? i.margin : 0) / 100;

        return {
            value: f(Math.ceil((peak * margin) / 100) * 100),
            unit: 'W generator',
            label: 'Starting (surge) watts needed',
            sub: `${f(running)} W running + ${f(largest.surge)} W extra to start ${largest.name}${margin > 1 ? `, + ${f((margin - 1) * 100)}% margin` : ''}`,
            rows: { running: `${f(running * margin)} W running watts with margin`, surge: `${f(peak)} W peak when the largest motor starts`, note: 'Start large motors one at a time; check each appliance\'s label' },
            lists: { items: items.map((item) => ({ label: item.name, value: `${f(item.running)} W running, +${f(item.surge)} W to start` })) },
        };
    },

    hot_tub: (i, c, f) => {
        const kwhMonth = i.mode === 'kwh' ? i.kwh_month : (i.heater > 0 && i.hours > 0 ? i.heater * i.hours * 30.4375 : NaN) + (i.pump > 0 ? (i.pump * (i.pump_hours > 0 ? i.pump_hours : 0) * 30.4375) / 1000 : 0);

        if (!(kwhMonth > 0) || !(i.price > 0)) {
            return { empty: 'Enter the heater and pump use (or kWh a month) and your price.' };
        }

        const chemicals = i.chemicals > 0 ? i.chemicals : 0;
        const energy = kwhMonth * i.price;

        return {
            value: money(energy + chemicals),
            label: 'Cost a month',
            sub: `${money(energy)} electricity (${f(kwhMonth)} kWh) + ${money(chemicals)} chemicals`,
            rows: { year: money((energy + chemicals) * 12), day: money((energy + chemicals) / 30.4375), note: 'Heating use rises sharply in cold weather; a good cover saves the most' },
        };
    },

    cleaning: (i, c, f) => {
        const perClean = i.mode === 'rooms' ? (i.rooms > 0 ? i.rooms : NaN) * (i.room_price > 0 ? i.room_price : NaN) + (i.bathrooms > 0 ? i.bathrooms * (i.bath_price > 0 ? i.bath_price : 0) : 0) : (i.hours > 0 ? i.hours : NaN) * (i.rate > 0 ? i.rate : NaN) * (i.cleaners > 0 ? i.cleaners : 1);

        if (!(perClean > 0)) {
            return { empty: 'Enter hours and an hourly rate, or rooms and a price per room.' };
        }

        const perYear = { weekly: 52, biweekly: 26, monthly: 12, once: 1 }[i.frequency] ?? 26;
        const tip = 1 + (i.tip > 0 ? i.tip : 0) / 100;

        return {
            value: money(perClean * tip),
            label: 'Cost per clean',
            sub: `${money(perClean)}${tip > 1 ? ` + ${f((tip - 1) * 100)}% tip` : ''}`,
            rows: { year: `${money(perClean * tip * perYear)} a year`, month: `${money((perClean * tip * perYear) / 12)} a month`, cleans: `${perYear} cleans a year` },
        };
    },

    tables: (i, c, f) => {
        const seats = { round60: 8, round72: 10, round48: 6, rect6: 6, rect8: 8, rect6_ends: 8, rect8_ends: 10 }[i.table] ?? 8;
        const perTable = i.seats > 0 ? i.seats : seats;

        if (!(i.guests > 0)) {
            return { empty: 'Enter the number of guests.' };
        }

        const tables = Math.ceil(i.guests / perTable);
        const area = i.guests * (i.space > 0 ? i.space : 12);

        return {
            value: f(tables),
            unit: tables === 1 ? 'table' : 'tables',
            label: 'Tables needed',
            sub: `${f(i.guests)} guests ÷ ${f(perTable)} seats a table`,
            rows: { empty: `${f(tables * perTable - i.guests)} spare seats`, area: `About ${f(area)} ft² (${f(area * FT ** 2)} m²) of floor for seated dining`, chairs: `${f(i.guests)} chairs` },
        };
    },

    laundry: (i, c, f) => {
        if (!(i.loads > 0)) {
            return { empty: 'Enter loads a week.' };
        }

        const waterCost = i.water > 0 && i.water_price > 0 ? (i.water / 1000) * i.water_price : 0;
        const washer = (i.washer_kwh > 0 ? i.washer_kwh : 0) * (i.power_price > 0 ? i.power_price : 0);
        const dryer = i.dry ? (i.dryer_kwh > 0 ? i.dryer_kwh : 0) * (i.power_price > 0 ? i.power_price : 0) : 0;
        const detergent = i.detergent > 0 ? i.detergent : 0;
        const perLoad = waterCost + washer + dryer + detergent;
        const loads = i.loads * 52.18;

        return {
            value: money(perLoad),
            label: 'Cost per load',
            sub: `Water ${money(waterCost)} + washer ${money(washer)} + dryer ${money(dryer)} + detergent ${money(detergent)}`,
            rows: { year: `${money(perLoad * loads)} a year for ${f(loads)} loads`, month: money((perLoad * loads) / 12), water: `${f((i.water > 0 ? i.water : 0) * loads)} L (${f(((i.water > 0 ? i.water : 0) * loads) / GAL)} gal) of water a year` },
        };
    },

    led: (i, c, f) => {
        if (!(i.old_watts > 0) || !(i.led_watts > 0) || !(i.bulbs > 0) || !(i.hours > 0) || !(i.price > 0)) {
            return { empty: 'Enter both wattages, the number of bulbs, hours a day and your price.' };
        }

        const kwhSaved = ((i.old_watts - i.led_watts) * i.bulbs * i.hours * 365.25) / 1000;
        const saved = kwhSaved * i.price;
        const cost = (i.led_price > 0 ? i.led_price : 0) * i.bulbs;

        return {
            value: money(saved),
            label: 'Saved a year',
            sub: `${f(kwhSaved)} kWh a year less`,
            rows: { payback: cost > 0 ? (saved > 0 ? `${f((cost / saved) * 12)} months to pay back ${money(cost)} of bulbs` : 'No saving') : 'Enter the LED price', lifetime: i.led_life > 0 ? `LEDs last ${f(i.led_life / (i.hours * 365.25))} years at ${f(i.hours)} h a day` : '—', ten: money(saved * 10 - cost) + ' saved over 10 years after buying the bulbs' },
        };
    },

    lighting: (i, c, f) => {
        i = { ...i, lux: Number(i.lux) };

        if (!(i.area > 0) || !(i.lux > 0)) {
            return { empty: 'Enter the room area and target light level.' };
        }

        const utilization = (i.utilization > 0 ? i.utilization : 70) / 100;
        const lumens = (i.lux * i.area) / utilization;
        const fixtures = i.fixture > 0 ? Math.ceil(lumens / i.fixture) : null;

        return {
            value: f(Math.round(lumens)),
            unit: 'lumens',
            label: 'Light output needed',
            sub: `${f(i.lux)} lux × ${f(i.area)} m² ÷ ${f(utilization)} utilization`,
            rows: { fixtures: fixtures ? `${fixtures} fixtures of ${f(i.fixture)} lm` : 'Enter lumens per fixture', watts: `About ${f(lumens / 90)} W of LED at 90 lm/W`, footcandles: `${f(i.lux / 10.7639)} footcandles` },
        };
    },

    lumens_watts: (i, c, f) => {
        const efficacy = i.efficacy > 0 ? i.efficacy : { incandescent: 13.3, halogen: 18.6, cfl: 61.5, led: 88.9 }[i.bulb];

        if (!(efficacy > 0)) {
            return { empty: 'Choose a bulb type.' };
        }

        const watts = i.direction === 'to_lumens' ? i.watts : i.lumens / efficacy;
        const lumens = i.direction === 'to_lumens' ? i.watts * efficacy : i.lumens;

        if (!(watts > 0) || !(lumens > 0)) {
            return { empty: 'Enter the lumens or watts.' };
        }

        const match = c.data.lumens.reduce((best, row) => (Math.abs(row[0] - lumens) < Math.abs(best[0] - lumens) ? row : best));

        return {
            value: i.direction === 'to_lumens' ? f(Math.round(lumens)) : f(watts),
            unit: i.direction === 'to_lumens' ? 'lumens' : 'watts',
            label: i.direction === 'to_lumens' ? 'Light output' : 'Power needed',
            sub: `At ${f(efficacy)} lumens per watt`,
            rows: { equivalent: `${f(match[0])} lm is the output of a ${match[1]} W incandescent bulb`, led: `${f(lumens / 88.9)} W LED, ${f(lumens / 13.3)} W incandescent` },
            lists: { equivalence: c.data.lumens.map(([lm, w]) => ({ label: `${lm} lumens`, value: `${w} W incandescent · about ${f(lm / 88.9)} W LED`, highlight: lm === match[0] })) },
        };
    },

    microwave: (i, c, f) => {
        const time = (i.minutes > 0 ? i.minutes : 0) * 60 + (i.seconds > 0 ? i.seconds : 0);

        if (!(time > 0) || !(i.from > 0) || !(i.to > 0)) {
            return { empty: 'Enter the recipe time and both wattages.' };
        }

        const yours = (time * i.from) / i.to;
        const mmss = (s) => `${Math.floor(Math.round(s) / 60)}:${String(Math.round(s) % 60).padStart(2, '0')}`;

        return {
            value: mmss(yours),
            unit: 'min:s',
            label: `Time in your ${f(i.to)} W microwave`,
            sub: `${mmss(time)} × ${f(i.from)} W ÷ ${f(i.to)} W`,
            rows: { seconds: `${f(Math.round(yours))} seconds`, note: 'Check food is heated through; stir and let it stand' },
        };
    },

    period: (i, c, f) => {
        if (!(i.per_day > 0) || !(i.days > 0) || !(i.price > 0)) {
            return { empty: 'Enter products a day, days a period and the price per product.' };
        }

        const cycles = i.cycles > 0 ? i.cycles : 13;
        const perYear = i.per_day * i.days * cycles;
        const cost = perYear * i.price;
        const years = i.years > 0 ? i.years : 1;
        const cup = i.cup_price > 0 ? i.cup_price * Math.ceil(years / (i.cup_life > 0 ? i.cup_life : 10)) : null;

        return {
            value: money(cost),
            label: 'Cost a year',
            sub: `${f(perYear)} products a year (${f(i.per_day)} a day × ${f(i.days)} days × ${f(cycles)} periods)`,
            rows: { lifetime: `${money(cost * years)} over ${f(years)} ${years === 1 ? 'year' : 'years'} (${f(perYear * years)} products)`, cup: cup === null ? 'Enter a menstrual cup price' : `${money(cup)} in reusable cups over ${f(years)} ${years === 1 ? 'year' : 'years'}` },
        };
    },

    pool_salt: (i, c, f) => {
        if (!(i.volume > 0) || !(i.target > 0) || !(i.current >= 0)) {
            return { empty: 'Enter the pool volume and current and target salt levels.' };
        }

        if (i.current >= i.target) {
            return { value: '0', unit: 'lb', label: 'Salt to add', sub: 'Already at or above the target; dilute with fresh water to lower it', rows: { kg: '0 kg', bags: '0 bags', note: '—' } };
        }

        const kg = (i.volume * (i.target - i.current)) / 1e6;
        const bag = i.bag > 0 ? i.bag : 18143.7;

        return {
            value: f(kg / 0.45359237),
            unit: 'lb',
            label: 'Salt to add',
            sub: `${f(i.volume / GAL)} US gal × ${f(i.target - i.current)} ppm`,
            rows: { kg: `${f(kg)} kg`, bags: `${Math.ceil((kg * 1000) / bag)} bags of ${f(bag / 453.59237)} lb`, note: 'Add pool-grade salt with the pump running and retest after 24 hours' },
        };
    },

    pool_shock: (i, c, f) => {
        const strength = { cal_hypo_65: 65, cal_hypo_73: 73, dichlor: 56, trichlor: 90, lithium: 35 }[i.product];

        if (!(i.volume > 0) || !(i.rise > 0)) {
            return { empty: 'Enter the pool volume and the chlorine rise.' };
        }

        const chlorine = i.volume * i.rise;

        if (i.product === 'liquid') {
            const percent = i.liquid > 0 ? i.liquid : 12.5;
            const liters = chlorine / (percent * 10 * 1000);

            return {
                value: f(liters / GAL),
                unit: 'US gal',
                label: 'Liquid chlorine to add',
                sub: `${f(chlorine / 1000)} g of chlorine at ${f(percent)}% (trade percent)`,
                rows: { metric: `${f(liters)} L`, floz: `${f(liters / 0.0295735295625)} US fl oz`, note: 'Add at dusk with the pump running; keep swimmers out until free chlorine is below 5 ppm' },
            };
        }

        const grams = chlorine / 1000 / (strength / 100);

        return {
            value: f(grams / 453.59237),
            unit: 'lb',
            label: 'Shock to add',
            sub: `${f(chlorine / 1000)} g of available chlorine ÷ ${strength}%`,
            rows: { metric: `${f(grams / 1000)} kg`, floz: `${f(grams / 28.349523125)} oz by weight`, note: 'Pre-dissolve granular shock if the label says to; follow the label' },
        };
    },

    quit_smoking: (i, c, f) => {
        if (!(i.per_day > 0) || !(i.price > 0)) {
            return { empty: 'Enter how much you smoke a day and the price.' };
        }

        const packs = i.unit === 'cigarettes' ? i.per_day / (i.per_pack > 0 ? i.per_pack : 20) : i.per_day;
        const year = packs * 365.25 * i.price;
        const years = i.years > 0 ? i.years : 1;

        return {
            value: money(year),
            label: 'Saved a year',
            sub: `${f(packs)} ${packs === 1 ? 'pack' : 'packs'} a day × ${money(i.price)}`,
            rows: { month: money(year / 12), total: `${money(year * years)} over ${f(years)} years`, cigarettes: `${f(packs * (i.per_pack > 0 ? i.per_pack : 20) * 365.25 * years)} cigarettes not smoked` },
        };
    },

    recessed: (i, c, f) => {
        if (!(i.length > 0) || !(i.width > 0) || !(i.ceiling > 0)) {
            return { empty: 'Enter the room size and ceiling height.' };
        }

        const spacing = i.ceiling / 2;
        const across = Math.max(1, Math.ceil(i.width / spacing));
        const along = Math.max(1, Math.ceil(i.length / spacing));
        const gapW = i.width / across;
        const gapL = i.length / along;

        return {
            value: f(across * along),
            unit: 'lights',
            label: 'Recessed lights',
            sub: `${along} rows of ${across}, about ${feetIn(spacing)} apart`,
            rows: { spacing: `${feetIn(gapL)} apart along the length, ${feetIn(gapW)} across`, edge: `${feetIn(gapL / 2)} and ${feetIn(gapW / 2)} from the walls`, rule: 'Rule of thumb: space lights half the ceiling height apart, half that from walls' },
        };
    },

    roll_length: (i, c, f) => {
        if (!(i.outer > i.core) || !(i.thickness > 0)) {
            return { empty: 'Enter the outer and core diameters and the material thickness.' };
        }

        const length = (Math.PI * (i.outer ** 2 - i.core ** 2)) / (4 * i.thickness);
        const wraps = (i.outer - i.core) / (2 * i.thickness);

        return {
            value: f(length),
            unit: 'm',
            label: 'Length on the roll',
            sub: `π × (${f(i.outer * 1000)}² − ${f(i.core * 1000)}² mm) ÷ (4 × ${f(i.thickness * 1000)} mm)`,
            rows: { feet: `${f(length / FT)} ft`, wraps: `${f(wraps)} wraps`, note: 'Assumes the material is wound tightly with no gaps' },
        };
    },

    rug: (i, c, f) => {
        if (!(i.length > 0) || !(i.width > 0)) {
            return { empty: 'Enter the room size.' };
        }

        const border = (i.border > 0 ? i.border : 18 * IN);
        const L = i.length - 2 * border;
        const W = i.width - 2 * border;

        if (!(L > 0) || !(W > 0)) {
            return { error: 'The border is wider than the room.' };
        }

        const sizes = i.system === 'cm' ? c.data.rugs.cm.map(([w, l]) => [w * 0.01, l * 0.01, `${w} × ${l} cm`]) : c.data.rugs.ft.map(([w, l]) => [w * FT, l * FT, `${w} × ${l} ft`]);
        const long = Math.max(L, W);
        const short = Math.min(L, W);
        const fitting = sizes.filter(([w, l]) => l <= long + 0.01 && w <= short + 0.01);
        const best = fitting.at(-1);

        return {
            value: best ? best[2] : 'Smaller than standard',
            label: 'Largest standard rug that leaves the border',
            sub: `Room ${feetIn(i.length)} × ${feetIn(i.width)} less ${feetIn(border)} of floor each side = ${feetIn(long)} × ${feetIn(short)}`,
            rows: { exact: `${f(long / FT)} × ${f(short / FT)} ft (${f(long * 100)} × ${f(short * 100)} cm) at most`, rule: 'Designers leave 12–18 in (30–45 cm) of floor around a room-size rug' },
            lists: { sizes: sizes.map(([w, l, label]) => ({ label, value: l <= long + 0.01 && w <= short + 0.01 ? 'fits' : 'too big', highlight: best && label === best[2] })) },
        };
    },

    sofa: (i, c, f) => {
        if (!(i.wall > 0)) {
            return { empty: 'Enter the wall length.' };
        }

        const ideal = (i.wall * 2) / 3;
        const rows = { range: `${feetIn(i.wall / 2)} to ${feetIn(ideal)} long`, door: 'Enter the sofa and door sizes to check' };

        if (i.depth > 0 && i.height > 0 && i.door_width > 0) {
            const narrow = Math.min(i.depth, i.height);
            rows.door = narrow <= i.door_width ? `Fits through: its ${feetIn(narrow)} side clears the ${feetIn(i.door_width)} door` : `Too wide: its narrowest side, ${feetIn(narrow)}, is wider than the ${feetIn(i.door_width)} door (removing legs or the door may help)`;
        }

        return {
            value: feetIn(ideal),
            label: 'Sofa length (about two-thirds of the wall)',
            sub: `${feetIn(i.wall)} wall × ⅔ = ${f(ideal * 100)} cm`,
            rows: { ...rows, note: 'A design rule of thumb; also leave 30–36 in (75–90 cm) walkways' },
        };
    },

    unit_price: (i, c, f) => {
        const rows = namedRows(i.products, 2).filter(({ values: [price, qty] }) => price > 0 && qty > 0);

        if (!rows.length) {
            return { empty: 'Add products with a price and a quantity.' };
        }

        const items = rows.map(({ name, values: [price, qty] }) => ({ name, unit: price / qty }));
        const best = items.reduce((a, b) => (b.unit < a.unit ? b : a));
        const per = i.per > 0 ? i.per : 1;

        return {
            value: best.name,
            label: 'Best value',
            sub: `${money(best.unit * per)} per ${f(per)} ${i.unit_name || 'units'}`,
            rows: { saving: items.length > 1 ? `${f(((items.reduce((a, b) => (b.unit > a.unit ? b : a)).unit - best.unit) / items.reduce((a, b) => (b.unit > a.unit ? b : a)).unit) * 100)}% cheaper per unit than the most expensive` : 'Add another product to compare' },
            lists: { items: items.map((item) => ({ label: item.name, value: `${money(item.unit * per)} per ${f(per)} ${i.unit_name || 'units'}`, highlight: item === best })) },
        };
    },
};

export default defineTools(handlers);
