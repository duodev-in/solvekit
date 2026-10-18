import { bulkDensity } from '../construction/bulk.js';
import { ACRE, FT, FT2, FT3, GAL, IN, SHORT_TON, YD2, YD3, money, readRows, shapeArea } from '../construction/geometry.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Areas and volumes: cubic yards, square footage, square yards, coverage rates, wall area, FAR.
 */
const rowFactor = (c, name, unit) => c.rowUnits?.[name]?.[unit]?.factor ?? 1;

export const handlers = {
    cubic_yard: (i, c, f) => {
        let area;

        if (i.input === 'area') {
            if (!(i.area > 0)) {
                return { empty: 'Enter the area.' };
            }

            area = i.area;
        } else {
            const plan = shapeArea(i.shape, i);

            if (plan.empty || plan.error) {
                return plan;
            }

            area = plan.area;
        }

        if (missing(i, 'depth') || !(i.depth > 0)) {
            return { empty: 'Enter the depth or thickness.' };
        }

        const count = i.count > 0 ? i.count : 1;
        const volume = area * i.depth * count;
        const yd3 = volume / YD3;
        const material = i.material && i.material !== 'none' ? bulkDensity(c.data, i.material) : null;

        return {
            value: f(yd3),
            unit: 'yd³',
            label: 'Volume',
            sub: `${f(area / FT2)} ft² × ${f(i.depth / IN)} in${count > 1 ? ` × ${f(count)}` : ''} ÷ 27 ft³ per yd³`,
            rows: {
                ft3: `${f(volume / FT3)} ft³`,
                m3: `${f(volume)} m³`,
                weight: material ? `${f((volume * material.density) / SHORT_TON)} US tons of ${material.name.toLowerCase()}` : 'Choose a material',
                cost: i.price > 0 ? money(yd3 * i.price) : 'Enter a price per yd³',
                area: `${f(area / FT2)} ft² (${f(area)} m²)`,
            },
        };
    },

    gallons_per_square_foot: (i, c, f) => {
        let rate;

        if (i.mode === 'depth') {
            if (!(i.depth > 0)) {
                return { empty: 'Enter the liquid depth.' };
            }

            rate = i.depth / GAL;
        } else {
            if (!(i.volume > 0) || !(i.area > 0)) {
                return { empty: 'Enter the volume and the area it covers.' };
            }

            rate = i.volume / 1000 / GAL / i.area;
        }

        // rate is gallons per m²; convert to gallons per ft².
        const perFt2 = rate * FT2;
        const depth = perFt2 * GAL / FT2;

        return {
            value: f(perFt2),
            unit: 'gal/ft²',
            label: 'Coverage rate',
            sub: `${f(depth / IN)} in (${f(depth * 1000)} mm) of liquid`,
            rows: {
                lm2: `${f((perFt2 * GAL * 1000) / FT2)} L/m²`,
                ft2gal: `${f(1 / perFt2)} ft² per gallon`,
                depth: `${f(depth / IN)} in (${f(depth * 1000)} mm)`,
                total: i.mode === 'depth' && i.area > 0 ? `${f(perFt2 * (i.area / FT2))} gal for ${f(i.area / FT2)} ft²` : i.mode !== 'depth' ? `${f(i.volume / 1000 / GAL)} gal over ${f(i.area / FT2)} ft²` : 'Enter an area',
            },
        };
    },

    square_footage: (i, c, f) => {
        const factor = rowFactor(c, 'rooms', i.rooms_unit);
        const rooms = readRows(i.rooms, [factor, factor, 1]);
        const valid = rooms.filter(([l, w]) => l > 0 && w > 0);

        if (!valid.length) {
            return { empty: 'Enter the length and width of at least one area.' };
        }

        const list = valid.map(([l, w, n], index) => {
            const count = n > 0 ? n : 1;

            return { area: l * w * count, label: `Area ${index + 1}: ${f(l / FT)} × ${f(w / FT)} ft${count > 1 ? ` × ${f(count)}` : ''}` };
        });
        const total = list.reduce((sum, row) => sum + row.area, 0);
        const withWaste = total * (1 + (i.waste > 0 ? i.waste / 100 : 0));

        return {
            value: f(total / FT2),
            unit: 'ft²',
            label: 'Total area',
            sub: `${valid.length} area${valid.length > 1 ? 's' : ''}${i.waste > 0 ? `; ${f(withWaste / FT2)} ft² with ${f(i.waste)}% extra` : ''}`,
            rows: {
                m2: `${f(total)} m²`,
                yd2: `${f(total / YD2)} yd²`,
                acres: `${f(total / ACRE)} acres`,
                cost: i.price > 0 ? money((withWaste / FT2) * i.price) : 'Enter a price per ft²',
            },
            lists: { areas: list.map((row) => ({ label: row.label, value: `${f(row.area / FT2)} ft²` })) },
        };
    },

    square_yards: (i, c, f) => {
        const plan = shapeArea(i.shape, i);

        if (plan.empty || plan.error) {
            return plan;
        }

        const waste = i.waste > 0 ? i.waste / 100 : 0;
        const yd2 = (plan.area * (1 + waste)) / YD2;

        return {
            value: f(yd2),
            unit: 'yd²',
            label: 'Square yards',
            sub: waste ? `${f(plan.area / YD2)} yd² plus ${f(i.waste)}% extra` : `${f(plan.area / FT2)} ft² ÷ 9`,
            rows: { ft2: `${f(plan.area / FT2)} ft²`, m2: `${f(plan.area)} m²`, perimeter: `${f(plan.perimeter / FT)} ft`, cost: i.price > 0 ? money(yd2 * i.price) : 'Enter a price per yd²' },
        };
    },

    wall_area: (i, c, f) => {
        const wallFactor = rowFactor(c, 'walls', i.walls_unit);
        const openingFactor = rowFactor(c, 'openings', i.openings_unit);
        const walls = readRows(i.walls, [wallFactor, wallFactor]).filter(([l, h]) => l > 0 && h > 0);
        const openings = readRows(i.openings, [openingFactor, openingFactor, 1]).filter(([w, h]) => w > 0 && h > 0);

        if (!walls.length) {
            return { empty: 'Enter the length and height of at least one wall.' };
        }

        const gross = walls.reduce((sum, [l, h]) => sum + l * h, 0);
        const removed = openings.reduce((sum, [w, h, n]) => sum + w * h * (n > 0 ? n : 1), 0);
        const net = gross - removed;

        if (net <= 0) {
            return { error: 'The openings are larger than the walls.' };
        }

        return {
            value: f(net / FT2),
            unit: 'ft²',
            label: 'Net wall area',
            sub: `${f(gross / FT2)} ft² of wall less ${f(removed / FT2)} ft² of openings`,
            rows: {
                m2: `${f(net)} m²`,
                gross: `${f(gross / FT2)} ft²`,
                openings: `${f(removed / FT2)} ft²`,
                paint: i.coverage > 0 ? `${f(((net / FT2) * (i.coats > 0 ? i.coats : 1)) / i.coverage)} gal at ${f(i.coverage)} ft²/gal` : 'Enter a paint coverage',
            },
            lists: { walls: walls.map(([l, h], index) => ({ label: `Wall ${index + 1}: ${f(l / FT)} × ${f(h / FT)} ft`, value: `${f((l * h) / FT2)} ft²` })) },
        };
    },

    floor_area_ratio: (i, c, f) => {
        if (missing(i, 'lot') || !(i.lot > 0)) {
            return { empty: 'Enter the lot area.' };
        }

        if (i.mode === 'allowed') {
            if (!(i.far > 0)) {
                return { empty: 'Enter the FAR limit.' };
            }

            const allowed = i.far * i.lot;
            const floors = i.footprint > 0 ? allowed / i.footprint : null;

            return {
                value: f(allowed / FT2),
                unit: 'ft²',
                label: 'Floor area allowed',
                sub: `FAR ${f(i.far)} × ${f(i.lot / FT2)} ft² lot`,
                rows: { m2: `${f(allowed)} m²`, floors: floors === null ? 'Enter a footprint' : `${f(floors)} floors at that footprint`, coverage: i.footprint > 0 ? `${f((i.footprint / i.lot) * 100)}% lot coverage` : '—' },
            };
        }

        if (!(i.floor > 0)) {
            return { empty: 'Enter the gross floor area.' };
        }

        const far = i.floor / i.lot;

        return {
            value: f(far),
            unit: 'FAR',
            label: 'Floor area ratio',
            sub: `${f(i.floor / FT2)} ft² of floor ÷ ${f(i.lot / FT2)} ft² of lot`,
            rows: { m2: `${f(i.floor)} m² of floor`, coverage: i.footprint > 0 ? `${f((i.footprint / i.lot) * 100)}% lot coverage` : 'Enter a footprint', floors: i.footprint > 0 ? `${f(i.floor / i.footprint)} floors average` : '—' },
        };
    },
};

export default defineTools(handlers);
