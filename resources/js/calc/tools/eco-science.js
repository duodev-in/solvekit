import { fitTwoParameter, readPairs } from '../chemistry/fit.js';
import { gridKg, gridLabel, money } from '../ecology/common.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Ecology and environment science: carrying capacity, breathing, mercury, predator–prey, Passive House, AQI.
 */

/**
 * Lotka–Volterra integration (classical RK4): dx/dt = αx − βxy, dy/dt = δxy − γy.
 */
export function lotkaVolterra({ x0, y0, alpha, beta, gamma, delta, time, steps = 4000 }) {
    const h = time / steps;
    const dx = (x, y) => alpha * x - beta * x * y;
    const dy = (x, y) => delta * x * y - gamma * y;
    const out = [[0, x0, y0]];
    let x = x0;
    let y = y0;

    for (let k = 1; k <= steps; k += 1) {
        const k1x = dx(x, y);
        const k1y = dy(x, y);
        const k2x = dx(x + (h / 2) * k1x, y + (h / 2) * k1y);
        const k2y = dy(x + (h / 2) * k1x, y + (h / 2) * k1y);
        const k3x = dx(x + (h / 2) * k2x, y + (h / 2) * k2y);
        const k3y = dy(x + (h / 2) * k2x, y + (h / 2) * k2y);
        const k4x = dx(x + h * k3x, y + h * k3y);
        const k4y = dy(x + h * k3x, y + h * k3y);
        x += (h / 6) * (k1x + 2 * k2x + 2 * k3x + k4x);
        y += (h / 6) * (k1y + 2 * k2y + 2 * k3y + k4y);
        out.push([k * h, x, y]);
    }

    return out;
}

/**
 * Air Quality Index for one pollutant from the EPA breakpoint table (concentration truncated as the EPA requires).
 */
export function aqiFor(table, concentration) {
    const factor = 10 ** table.decimals;
    const c = Math.floor(concentration * factor + 1e-9) / factor;
    const row = table.rows.find(([lo, hi]) => c >= lo && c <= hi);

    if (!row) {
        return c > table.rows[table.rows.length - 1][1] ? { aqi: null, beyond: true } : { aqi: null };
    }

    const [lo, hi, ilo, ihi] = row;

    return { aqi: Math.round(((ihi - ilo) / (hi - lo)) * (c - lo) + ilo), truncated: c };
}

const CATEGORIES = [
    [50, 'Good', 'Air quality is satisfactory.'],
    [100, 'Moderate', 'Unusually sensitive people should consider limiting long or heavy exertion outdoors.'],
    [150, 'Unhealthy for Sensitive Groups', 'People with heart or lung disease, older adults, children and teens should reduce long or heavy exertion outdoors.'],
    [200, 'Unhealthy', 'Everyone should reduce long or heavy exertion; sensitive groups should avoid it.'],
    [300, 'Very Unhealthy', 'Everyone should avoid long or heavy exertion outdoors; sensitive groups should stay indoors.'],
    [500, 'Hazardous', 'Everyone should avoid all physical activity outdoors.'],
];

export const category = (aqi) => CATEGORIES.find(([max]) => aqi <= max) ?? CATEGORIES[CATEGORIES.length - 1];

const logistic = (t, k, r, n0) => k / (1 + ((k - n0) / n0) * Math.exp(-r * t));

export const handlers = {
    carrying_capacity: (i, c, f) => {
        if (i.mode === 'resource') {
            if (!(i.resource > 0) || !(i.need > 0)) {
                return { empty: 'Enter the resource available and the need of one individual.' };
            }

            const k = i.resource / i.need;

            return {
                value: f(Math.floor(k)),
                unit: 'individuals',
                label: 'Carrying capacity K',
                sub: `${f(i.resource)} ÷ ${f(i.need)} per individual`,
                rows: { k: f(k), now: i.population > 0 ? `${f((i.population / k) * 100)}% of capacity now` : 'Enter the current population', room: i.population > 0 ? `${f(k - i.population)} more individuals` : '—' },
            };
        }

        const read = readPairs(i.counts);

        if (read.error) {
            return read;
        }

        const pairs = read.pairs.sort((a, b) => a[0] - b[0]);

        if (pairs.length < 4 || pairs.some(([, n]) => !(n > 0))) {
            return { empty: 'Enter at least four counts over time (time and population, one pair per line).' };
        }

        const [t0, n0] = pairs[0];
        const shifted = pairs.map(([t, n]) => [t - t0, n]);
        const nMax = Math.max(...pairs.map(([, n]) => n));
        const fit = fitTwoParameter((t, k, r) => logistic(t, k, r, n0), shifted, [nMax * 1.2, 0.5]);

        if (!(fit.p > 0) || !(fit.q > 0)) {
            return { error: 'These counts do not follow logistic growth; a carrying capacity cannot be fitted.' };
        }

        const tEnd = shifted[shifted.length - 1][0] * 1.5;

        return {
            value: f(Math.round(fit.p)),
            unit: 'individuals',
            label: 'Carrying capacity K (fitted)',
            sub: `Logistic fit with N₀ = ${f(n0)}: r = ${f(fit.q)} per time unit, R² = ${f(Math.round(fit.r2 * 1e4) / 1e4)}`,
            rows: { k: f(fit.p), now: `${f((pairs[pairs.length - 1][1] / fit.p) * 100)}% of capacity at the last count`, room: `Half of K reached at t = ${f(t0 + Math.log((fit.p - n0) / n0) / fit.q)}` },
            plots: { curve: { series: Array.from({ length: 81 }, (_, k) => [t0 + (tEnd * k) / 80, logistic((tEnd * k) / 80, fit.p, fit.q, n0)]), markers: pairs.map(([x, y]) => ({ x, y })), xLabel: 'Time', yLabel: 'Population' } },
        };
    },

    /**
     * CO₂ breathed out: VO₂ = 3.5 mL/kg/min per MET, VCO₂ = VO₂ × RER, 1.977 g per liter of CO₂ (STPD).
     */
    breathing: (i, c, f) => {
        if (missing(i, 'mass') || !(i.mass > 0)) {
            return { empty: 'Enter your body mass.' };
        }

        const rer = i.rer > 0 ? i.rer : 0.85;
        const kg = i.mass / 1000;
        const blocks = [['Sleeping', i.sleep, 0.95], ['Sitting', i.sit, 1.3], ['Light activity', i.light, 2.5], ['Moderate activity', i.moderate, 4.5], ['Vigorous activity', i.vigorous, 8.0]];
        const hours = blocks.reduce((s, [, h]) => s + (h > 0 ? h : 0), 0);

        if (!(hours > 0)) {
            return { empty: 'Enter the hours spent at each activity level.' };
        }

        if (hours > 24.0001) {
            return { error: `The hours add up to ${f(hours)}, more than a day.` };
        }

        let grams = 0;
        const list = blocks.filter(([, h]) => h > 0).map(([name, h, met]) => {
            const g = met * 3.5 * kg * h * 60 * rer * 1.977 / 1000;
            grams += g;

            return { label: `${name}: ${f(h)} h at ${met} MET`, value: `${f(g)} g CO₂` };
        });

        return {
            value: f(grams / 1000),
            unit: 'kg CO₂ a day',
            label: 'CO₂ you breathe out',
            sub: `${f(hours)} hours; respiratory exchange ratio ${f(rer)}`,
            rows: { year: `${f((grams / 1000) * 365)} kg a year`, hour: `${f(grams / hours)} g an hour on average`, note: 'Breathed carbon comes from food that plants recently took from the air, so it is not a net emission' },
            lists: { blocks: list },
        };
    },

    fish_mercury: (i, c, f) => {
        if (missing(i, 'mass') || !(i.mass > 0)) {
            return { empty: 'Enter your body mass.' };
        }

        const rfd = c.data.mercury_rfd;
        const kg = i.mass / 1000;
        let micrograms = 0;
        const list = [];

        [1, 2, 3].forEach((k) => {
            const fish = c.data.fish[i[`fish${k}`]];
            const grams = i[`grams${k}`];

            if (fish && grams > 0) {
                const ug = fish.ppm * grams; // mg/kg × g = µg
                micrograms += ug;
                list.push({ label: `${fish.name}: ${f(grams)} g a week at ${fish.ppm} ppm`, value: `${f(ug / 7 / kg)} µg/kg/day` });
            }
        });

        if (!list.length) {
            return { empty: 'Choose the fish you eat and grams per week.' };
        }

        const dose = micrograms / 7 / kg;

        return {
            value: f(Math.round(dose * 1000) / 1000),
            unit: 'µg/kg/day',
            label: 'Mercury intake',
            sub: `${f((dose / rfd) * 100)}% of the EPA reference dose (${rfd} µg/kg/day)`,
            rows: { week: `${f(micrograms)} µg of mercury a week`, limit: micrograms <= rfd * kg * 7 ? `${f(rfd * kg * 7 - micrograms)} µg a week below the reference dose` : `${f(micrograms - rfd * kg * 7)} µg a week over the reference dose`, advice: 'Pregnant people and children should follow the FDA/EPA fish advice chart' },
            lists: { fish: list },
        };
    },

    lotka_volterra: (i, c, f) => {
        if (missing(i, 'prey', 'predators', 'alpha', 'beta', 'gamma', 'delta', 'time') || ![i.prey, i.predators, i.alpha, i.beta, i.gamma, i.delta, i.time].every((v) => v > 0)) {
            return { empty: 'Enter positive starting sizes, rates and a time span.' };
        }

        const path = lotkaVolterra({ x0: i.prey, y0: i.predators, alpha: i.alpha, beta: i.beta, gamma: i.gamma, delta: i.delta, time: i.time });
        const preyMax = Math.max(...path.map(([, x]) => x));
        const predMax = Math.max(...path.map(([, , y]) => y));
        const peaks = [];

        for (let k = 1; k < path.length - 1; k += 1) {
            if (path[k][1] > path[k - 1][1] && path[k][1] >= path[k + 1][1]) {
                peaks.push(path[k][0]);
            }
        }

        const period = peaks.length > 1 ? (peaks[peaks.length - 1] - peaks[0]) / (peaks.length - 1) : null;
        const every = Math.max(1, Math.floor(path.length / 200));
        const sample = path.filter((_, k) => k % every === 0);

        return {
            value: `${f(i.gamma / i.delta)} prey · ${f(i.alpha / i.beta)} predators`,
            unit: '',
            label: 'Equilibrium populations',
            sub: period === null ? 'Run longer to see a full cycle' : `Populations cycle every ${f(period)} time units`,
            rows: { prey_max: `${f(preyMax)} prey at the peak`, pred_max: `${f(predMax)} predators at the peak`, period: period === null ? 'Not a full cycle yet' : `${f(period)} time units`, end: `${f(path[path.length - 1][1])} prey and ${f(path[path.length - 1][2])} predators at t = ${f(i.time)}` },
            plots: { populations: { series: sample.map(([t, x]) => [t, x]), series2: sample.map(([t, , y]) => [t, y]), legend: ['Prey', 'Predators'], xLabel: 'Time', yLabel: 'Population' } },
        };
    },

    passive_house: (i, c, f) => {
        if (missing(i, 'area') || !(i.area > 0)) {
            return { empty: 'Enter the heated floor area.' };
        }

        const limit = c.data.constants.passive_house_kwh_m2;
        const current = i.input === 'bills' ? (i.heating_kwh > 0 ? i.heating_kwh * (i.efficiency > 0 ? i.efficiency / 100 : 1) / i.area : NaN) : i.demand;

        if (!(current > 0)) {
            return { empty: 'Enter your heating demand or your yearly heating energy.' };
        }

        const saved = Math.max(current - limit, 0) * i.area;
        const delivered = saved / (i.efficiency > 0 ? i.efficiency / 100 : 1);
        const factor = i.fuel === 'electricity' ? gridKg(i, c) : i.fuel === 'oil' ? c.data.fuels.heating_oil_kwh : c.data.fuels.natural_gas_kwh;

        return {
            value: f(saved),
            unit: 'kWh of heat a year',
            label: 'Heat saved at the Passive House standard',
            sub: `${f(current)} → ${limit} kWh/(m²·a) on ${f(i.area)} m²`,
            rows: {
                fuel: `${f(delivered)} kWh of ${i.fuel} a year at ${f(i.efficiency || 100)}% efficiency`,
                money: i.price > 0 ? `${money(delivered * i.price)} a year` : 'Enter an energy price',
                co2: factor === null ? 'Choose a grid' : `${f((delivered * factor) / 1000)} t CO₂e a year${i.fuel === 'electricity' ? ` (${gridLabel(i, c)})` : ' (DESNZ)'}`,
                share: `${f((saved / (current * i.area)) * 100)}% less heating`,
            },
        };
    },

    smog: (i, c, f) => {
        const results = [];

        Object.entries(c.data.aqi).forEach(([key, table]) => {
            const value = i[key];

            if (value >= 0 && value !== '' && !Number.isNaN(value) && value !== undefined) {
                const r = aqiFor(table, value);
                results.push({ key, name: table.name, ...r });
            }
        });

        if (!results.length) {
            return { empty: 'Enter at least one pollutant concentration.' };
        }

        const valid = results.filter((r) => r.aqi !== null);

        if (!valid.length) {
            return { error: results.some((r) => r.beyond) ? 'A concentration is above the top of the AQI scale (beyond index).' : 'Use the 1-hour ozone or 24-hour SO₂ table for this range.' };
        }

        const top = valid.reduce((a, b) => (b.aqi > a.aqi ? b : a));
        const [, name, message] = category(top.aqi);

        return {
            value: f(top.aqi),
            unit: 'AQI',
            label: name,
            sub: `Set by ${top.name}. ${message}`,
            rows: { category: name, pollutant: `${top.name}: ${f(top.truncated)}`, advice: message },
            lists: { pollutants: results.map((r) => ({ label: r.name, value: r.aqi === null ? (r.beyond ? 'Beyond the scale' : 'Outside this table') : `AQI ${r.aqi} (${category(r.aqi)[1]})`, highlight: r === top })) },
        };
    },
};

export default defineTools(handlers);
