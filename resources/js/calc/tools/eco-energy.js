import { standardAtmosphere } from '../chemistry/thermo.js';
import { cashFlow, money } from '../ecology/common.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Renewable energy: hydro, solar, wind, project payback and home batteries.
 * Lengths arrive in meters, areas in m², temperatures in °C.
 */
const G = 9.80665;
const BETZ = 16 / 27;
const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
const FLOW = { m3s: 1, ls: 0.001, ft3s: 0.028316846592, gpm: 0.003785411784 / 60, m3h: 1 / 3600 };

/**
 * Dry-air density (kg/m³) from altitude (ICAO standard pressure) and the air temperature.
 */
export function airDensity(altitude, celsius) {
    return standardAtmosphere(altitude) / (287.05287 * (celsius + 273.15));
}

/**
 * Turbine output (W) at a wind speed: ½ ρ A v³ Cp between cut-in and cut-out, capped at the rated power.
 */
export function turbinePower(v, { rho, area, cp, rated, cutIn = 0, cutOut = Infinity }) {
    if (v < cutIn || v > cutOut) {
        return 0;
    }

    const p = 0.5 * rho * area * v ** 3 * cp;

    return rated > 0 ? Math.min(p, rated) : p;
}

/**
 * Average power (W) over a Rayleigh distribution of wind speeds with mean vMean (numerical integration to 40 m/s).
 */
export function rayleighAveragePower(vMean, turbine) {
    const step = 0.01;
    let total = 0;

    for (let v = step / 2; v < 40; v += step) {
        const pdf = ((Math.PI * v) / (2 * vMean ** 2)) * Math.exp((-Math.PI * v * v) / (4 * vMean ** 2));
        total += pdf * turbinePower(v, turbine) * step;
    }

    return total;
}

function projectOutcome(i, f, energy, label, extra = {}) {
    if (!(i.cost > 0) || !(energy > 0) || !(i.price > 0) || !(i.years >= 1)) {
        return { empty: 'Enter the cost, yearly energy, price and lifetime.' };
    }

    const net = i.cost - (i.incentive > 0 ? i.incentive : 0);
    const flow = cashFlow({ cost: net, energy, price: i.price, escalation: i.escalation || 0, degradation: i.degradation || 0, upkeep: i.upkeep > 0 ? i.upkeep : 0, rate: i.rate || 0, years: Math.round(i.years) });

    return {
        value: flow.payback === null ? 'Not within the lifetime' : f(flow.payback),
        unit: flow.payback === null ? '' : 'years',
        label,
        sub: `${money(net)} after incentives; ${money(energy * i.price)} of energy in year one`,
        rows: {
            npv: `${money(flow.npv)} net present value at ${f(i.rate || 0)}%`,
            lcoe: flow.lcoe === null ? '—' : `${money(flow.lcoe)} per kWh levelized cost`,
            total: `${money(flow.total)} of savings over ${f(Math.round(i.years))} years (${money(flow.total - net)} net)`,
            ...extra,
        },
        plots: { cash: { series: flow.series, xLabel: 'Year', yLabel: 'Cumulative $' } },
    };
}

export const handlers = {
    hydro: (i, c, f) => {
        const q = i.flow > 0 ? i.flow * (FLOW[i.flow_unit] ?? 1) : NaN;

        if (!(q > 0) || !(i.head > 0) || !(i.efficiency > 0 && i.efficiency <= 100)) {
            return { empty: 'Enter the flow, head and efficiency.' };
        }

        const watts = (i.efficiency / 100) * 998.2 * G * q * i.head;
        const cf = i.capacity > 0 ? i.capacity / 100 : 1;
        const kwh = (watts * 8760 * cf) / 1000;

        return {
            value: f(watts / 1000),
            unit: 'kW',
            label: 'Electrical power',
            sub: `η ρ g Q H = ${f(i.efficiency)}% × 998.2 kg/m³ × 9.81 × ${f(q)} m³/s × ${f(i.head)} m`,
            rows: {
                hp: `${f(watts / 745.6999)} hp`,
                year: `${f(kwh)} kWh a year at a ${f(cf * 100)}% capacity factor`,
                homes: i.home_kwh > 0 ? `${f(kwh / i.home_kwh)} homes using ${f(i.home_kwh)} kWh a year` : 'Enter a home\'s yearly use',
                hydraulic: `${f((998.2 * G * q * i.head) / 1000)} kW of water power before losses`,
            },
        };
    },

    solar: (i, c, f) => {
        let monthly;
        let source;

        if (i.site === 'custom') {
            if (!(i.sun_hours > 0)) {
                return { empty: 'Enter your peak sun hours per day.' };
            }

            const perKwp = i.sun_hours * (1 - (i.losses >= 0 ? i.losses : 14) / 100);
            monthly = MONTHS.map((_, k) => perKwp * [31, 28.25, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][k]);
            source = `${f(i.sun_hours)} peak sun hours a day, ${f(i.losses >= 0 ? i.losses : 14)}% losses`;
        } else {
            const city = c.data.solar_cities[i.site];

            if (!city) {
                return { empty: 'Choose a city.' };
            }

            monthly = city.monthly;
            source = `PVGIS for ${city.name}: ${f(city.yearly)} kWh per kWp, panels tilted ${city.tilt}°`;
        }

        const yieldPerKwp = monthly.reduce((s, m) => s + m, 0);
        const use = i.use_unit === 'month' ? i.use * 12 : i.use;

        if (!(use > 0) || !(i.panel > 0)) {
            return { empty: 'Enter your electricity use and the panel wattage.' };
        }

        const share = i.share > 0 ? i.share / 100 : 1;
        const kwp = (use * share) / yieldPerKwp;
        const panels = Math.ceil((kwp * 1000) / i.panel - 1e-9);
        const built = (panels * i.panel) / 1000;

        return {
            value: f(Math.round(kwp * 100) / 100),
            unit: 'kWp',
            label: 'Solar system size',
            sub: `${panels} panels of ${f(i.panel)} W (${f(built)} kWp) to cover ${f(share * 100)}% of ${f(use)} kWh a year`,
            rows: {
                panels: `${panels} panels, ${f(built * yieldPerKwp)} kWh a year`,
                area: i.panel_area > 0 ? `${f(panels * i.panel_area)} m² of panels (${f(panels * i.panel_area * 10.7639)} ft²)` : 'Enter a panel area',
                yield: source,
                best: `${MONTHS[monthly.indexOf(Math.max(...monthly))]} gives the most, ${MONTHS[monthly.indexOf(Math.min(...monthly))]} the least`,
            },
            plots: { monthly: { series: monthly.map((m, k) => [k + 1, m * built]), series2: MONTHS.map((_, k) => [k + 1, use / 12]), legend: ['Solar output', 'Your use'], xLabel: 'Month (1–12)', yLabel: 'kWh' } },
        };
    },

    solar_wattage: (i, c, f) => {
        const area = i.input === 'size' ? (i.length > 0 && i.width > 0 ? i.length * i.width : NaN) : i.area;

        if (!(area > 0) || !(i.efficiency > 0 && i.efficiency <= 100)) {
            return { empty: 'Enter the panel size and efficiency.' };
        }

        const watts = area * 1000 * (i.efficiency / 100);
        const daily = i.sun_hours > 0 ? (watts * i.sun_hours) / 1000 : null;

        return {
            value: f(Math.round(watts * 10) / 10),
            unit: 'W',
            label: 'Panel rating (standard test conditions)',
            sub: `${f(area)} m² × 1000 W/m² × ${f(i.efficiency)}%`,
            rows: {
                daily: daily === null ? 'Enter sun hours' : `${f(daily)} kWh a day before system losses`,
                year: daily === null ? '—' : `${f(daily * 365)} kWh a year before losses`,
                per_area: `${f(watts / area)} W/m² (${f(watts / area / 10.7639)} W/ft²)`,
            },
        };
    },

    wind: (i, c, f) => {
        if (missing(i, 'diameter') || !(i.diameter > 0) || !(i.cp > 0)) {
            return { empty: 'Enter the rotor diameter and power coefficient.' };
        }

        if (i.cp > BETZ) {
            return { error: `Cp cannot exceed the Betz limit of 16/27 (0.593).` };
        }

        let rho;

        try {
            rho = i.density > 0 ? i.density : airDensity(i.altitude || 0, Number.isFinite(i.temperature) ? i.temperature : 15);
        } catch (error) {
            return { error: error.message };
        }

        const area = (Math.PI / 4) * i.diameter ** 2;
        const turbine = { rho, area, cp: i.cp, rated: i.rated > 0 ? i.rated * 1000 : 0, cutIn: i.cut_in || 0, cutOut: i.cut_out > 0 ? i.cut_out : Infinity };

        if (i.mode === 'average') {
            if (!(i.mean > 0)) {
                return { empty: 'Enter the average wind speed.' };
            }

            const avg = rayleighAveragePower(i.mean, turbine);
            const kwh = (avg * 8760) / 1000;

            return {
                value: f(kwh),
                unit: 'kWh a year',
                label: 'Yearly energy',
                sub: `Rayleigh wind distribution with a ${f(i.mean)} m/s average; air ${f(rho)} kg/m³`,
                rows: {
                    average: `${f(avg / 1000)} kW average output`,
                    capacity: turbine.rated ? `${f((avg / turbine.rated) * 100)}% capacity factor` : 'Enter a rated power',
                    area: `${f(area)} m² swept`,
                    density: `${f(rho)} kg/m³`,
                },
                plots: { curve: { series: Array.from({ length: 61 }, (_, k) => [k * 0.5, turbinePower(k * 0.5, turbine) / 1000]), xLabel: 'Wind speed (m/s)', yLabel: 'kW' } },
            };
        }

        if (!(i.speed >= 0)) {
            return { empty: 'Enter the wind speed.' };
        }

        const power = turbinePower(i.speed, turbine);
        const wind = 0.5 * rho * area * i.speed ** 3;

        return {
            value: f(power / 1000),
            unit: 'kW',
            label: 'Turbine power',
            sub: `½ ρ A v³ Cp at ${f(i.speed)} m/s; air ${f(rho)} kg/m³`,
            rows: {
                wind: `${f(wind / 1000)} kW in the wind`,
                betz: `${f((wind * BETZ) / 1000)} kW at the Betz limit`,
                area: `${f(area)} m² swept`,
                density: `${f(rho)} kg/m³`,
            },
            plots: { curve: { series: Array.from({ length: 61 }, (_, k) => [k * 0.5, turbinePower(k * 0.5, turbine) / 1000]), xLabel: 'Wind speed (m/s)', yLabel: 'kW', markers: [{ x: i.speed, y: power / 1000, label: 'Now' }] } },
        };
    },

    wind_profit: (i, c, f) => projectOutcome(i, f, i.energy, 'Payback time', { energy: `${f(i.energy)} kWh a year` }),

    solar_payback: (i, c, f) => projectOutcome(i, f, i.energy, 'Payback time', { energy: `${f(i.energy)} kWh a year, falling ${f(i.degradation || 0)}% a year` }),

    battery: (i, c, f) => {
        let energy;

        if (i.mode === 'backup') {
            energy = i.load > 0 && i.hours > 0 ? i.load * i.hours : NaN;
        } else {
            energy = i.daily;
        }

        if (!(energy > 0) || !(i.dod > 0 && i.dod <= 100) || !(i.efficiency > 0 && i.efficiency <= 100)) {
            return { empty: 'Enter the energy you need, depth of discharge and efficiency.' };
        }

        const capacity = energy / ((i.dod / 100) * (i.efficiency / 100));
        const units = i.unit_kwh > 0 ? Math.ceil(capacity / i.unit_kwh - 1e-9) : null;

        return {
            value: f(Math.round(capacity * 100) / 100),
            unit: 'kWh',
            label: 'Battery capacity',
            sub: `${f(energy)} kWh ÷ (${f(i.dod)}% depth of discharge × ${f(i.efficiency)}% efficiency)`,
            rows: {
                usable: `${f(capacity * (i.dod / 100))} kWh usable`,
                units: units === null ? 'Enter a battery size' : `${units} batteries of ${f(i.unit_kwh)} kWh (${f(units * i.unit_kwh)} kWh)`,
                losses: `${f(capacity * (i.dod / 100) - energy)} kWh lost in conversion`,
            },
        };
    },
};

export default defineTools(handlers);
