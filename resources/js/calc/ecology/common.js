import { formatMoney } from '../currency.js';

/**
 * Shared helpers for the Ecology calculators: grid intensity, fuels, distances and finance.
 */
export const KM = 1000;
export const MILE = 1609.344;
export const GAL = 3.785411784; // liters
export const LB = 0.45359237;
export const KWH = 3.6e6; // joules
export const BTU = 1055.05585262;
export const THERM = 105505585.262; // joules

/**
 * Grid carbon intensity in kg CO2e per kWh from the country select (or the viewer's own value in g/kWh).
 */
export function gridKg(i, c, field = 'grid') {
    if (i[field] === 'custom') {
        return i[`${field}_custom`] >= 0 ? i[`${field}_custom`] / 1000 : null;
    }

    const row = c.data.grid?.[i[field]];

    return row ? row.g / 1000 : null;
}

export function gridLabel(i, c, field = 'grid') {
    if (i[field] === 'custom') {
        return `${i[`${field}_custom`]} g/kWh (your value)`;
    }

    const row = c.data.grid?.[i[field]];

    return row ? `${row.name} ${row.year}: ${row.g} g/kWh (Ember)` : '';
}

/**
 * Fuel CO2e per liter for a fuel choice: US EPA Hub factors per gallon or UK DESNZ factors per liter.
 */
export function fuelPerLiter(fuel, c) {
    const f = c.data.fuels;

    return {
        us_gasoline: { kg: f.epa_gasoline_gal / GAL, name: 'US gasoline (EPA)' },
        us_diesel: { kg: f.epa_diesel_gal / GAL, name: 'US diesel (EPA)' },
        uk_petrol: { kg: f.petrol_l, name: 'UK petrol, average biofuel blend (DESNZ)' },
        uk_diesel: { kg: f.diesel_l, name: 'UK diesel, average biofuel blend (DESNZ)' },
    }[fuel] ?? null;
}

/**
 * Liters of fuel per meter driven from an economy figure: mpg (US), mpg (UK), L/100 km or km/L.
 */
export function litersPerMeter(value, unit) {
    switch (unit) {
        case 'mpg_us':
            return value > 0 ? GAL / (value * MILE) : null;
        case 'mpg_uk':
            return value > 0 ? 4.54609 / (value * MILE) : null;
        case 'l100km':
            return value > 0 ? value / 100 / KM : null;
        case 'kml':
            return value > 0 ? 1 / (value * KM) : null;
        default:
            return null;
    }
}

/**
 * Great-circle distance in meters (haversine on the mean Earth radius, 6371.0088 km).
 */
export function greatCircle(lat1, lon1, lat2, lon2) {
    const r = Math.PI / 180;
    const dLat = (lat2 - lat1) * r;
    const dLon = (lon2 - lon1) * r;
    const a = Math.sin(dLat / 2) ** 2 + Math.cos(lat1 * r) * Math.cos(lat2 * r) * Math.sin(dLon / 2) ** 2;

    return 2 * 6371008.8 * Math.asin(Math.min(1, Math.sqrt(a)));
}

/**
 * Discounted cash flow for an energy project: yearly energy (kWh) degrading each year, a price rising
 * each year, fixed yearly costs; returns payback year (undiscounted), NPV, LCOE and the cumulative series.
 */
export function cashFlow({ cost, energy, price, escalation = 0, degradation = 0, upkeep = 0, rate = 0, years }) {
    let cumulative = -cost;
    let npv = -cost;
    let pvEnergy = 0;
    let pvCost = cost;
    let payback = null;
    let total = 0;
    const series = [[0, -cost]];

    for (let year = 1; year <= years; year += 1) {
        const kwh = energy * (1 - degradation / 100) ** (year - 1);
        const saving = kwh * price * (1 + escalation / 100) ** (year - 1) - upkeep;
        const discount = (1 + rate / 100) ** year;
        const before = cumulative;
        cumulative += saving;
        total += saving;
        npv += saving / discount;
        pvEnergy += kwh / discount;
        pvCost += upkeep / discount;
        series.push([year, cumulative]);

        if (payback === null && cumulative >= 0 && saving > 0) {
            payback = year - 1 + -before / saving;
        }
    }

    return { payback, npv, lcoe: pvEnergy > 0 ? pvCost / pvEnergy : null, total, series };
}

/**
 * Money in the page's display currency (chosen in the currency menu; US dollars by default).
 */
export const money = (value) => formatMoney(value);
