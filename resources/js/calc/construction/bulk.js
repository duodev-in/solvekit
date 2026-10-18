import { FT3, LB, SHORT_TON, YD3, money } from './geometry.js';

/**
 * Bulk material helpers: densities from config('construction_data') and the standard result rows.
 */

/**
 * Loose density (kg/m³) of a product key ('gravel') or a Caterpillar bulk key ('gravel_dry'),
 * or the viewer's own density when they entered one.
 */
export function bulkDensity(data, key, custom, state = 'loose') {
    if (custom > 0) {
        return { density: custom, name: 'your density', source: 'entered' };
    }

    const product = data.products?.[key];
    const bulkKey = product ? product.bulk : key;
    const row = data.bulk?.[bulkKey];

    if (!row) {
        return null;
    }

    return { density: row[state], name: product?.name ?? row.name, source: `Caterpillar ${state} density for ${row.name.toLowerCase()}`, row };
}

/**
 * Standard rows for a volume (m³) of material at a density (kg/m³).
 */
export function bulkRows(volume, density, f, price = {}) {
    const kg = volume * density;
    const tons = kg / SHORT_TON;
    let cost = 'Enter a price';

    if (price.amount > 0) {
        cost = price.basis === 'yd3' ? money((volume / YD3) * price.amount) : price.basis === 't' ? money((kg / 1000) * price.amount) : money(tons * price.amount);
    }

    return {
        tons,
        rows: {
            tonnes: `${f(kg / 1000)} t`,
            pounds: `${f(kg / LB)} lb`,
            yd3: `${f(volume / YD3)} yd³`,
            ft3: `${f(volume / FT3)} ft³`,
            m3: `${f(volume)} m³`,
            bags: `${f(Math.ceil(kg / (50 * LB)))} × 50 lb bags`,
            density: `${f(density)} kg/m³ (${f(density / 16.01846337396014)} lb/ft³)`,
            cost,
        },
    };
}
