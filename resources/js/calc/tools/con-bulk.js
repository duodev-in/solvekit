import { bulkDensity, bulkRows } from '../construction/bulk.js';
import { FT, FT2, FT3, IN, LB, SHORT_TON, YD3, money, shapeArea } from '../construction/geometry.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Bulk materials: gravel, sand, rock, base, asphalt and earthwork. Lengths arrive in meters,
 * areas in m², volumes in liters and densities in kg/m³ (see formula.js).
 */
const price = (i) => ({ amount: i.price, basis: i.price_basis });

/**
 * Plan area of the page's shape fields, or the area typed directly.
 */
function planArea(i) {
    if (i.input === 'area') {
        return i.area > 0 ? { area: i.area } : { empty: 'Enter the area.' };
    }

    return shapeArea(i.shape, i);
}

function materialOutcome(i, c, f, volume, label, extra = {}) {
    const material = bulkDensity(c.data, i.material, i.density);

    if (!material) {
        return { error: 'Choose a material or enter its density.' };
    }

    const { tons, rows } = bulkRows(volume, material.density, f, price(i));

    return {
        value: f(tons),
        unit: 'US tons',
        label,
        sub: `${f(volume / YD3)} yd³ at ${f(material.density)} kg/m³ (${material.source})`,
        rows: { ...rows, ...extra },
    };
}

export const handlers = {
    /**
     * Gravel, sand, rock, limestone, river rock, crushed stone and similar: area × depth × density.
     */
    aggregate: (i, c, f) => {
        const plan = planArea(i);

        if (plan.empty || plan.error) {
            return plan;
        }

        if (missing(i, 'depth') || !(i.depth > 0)) {
            return { empty: 'Enter the depth.' };
        }

        const waste = i.waste > 0 ? i.waste / 100 : 0;
        const volume = plan.area * i.depth * (1 + waste);

        return materialOutcome(i, c, f, volume, 'Material needed', { area: `${f(plan.area / FT2)} ft² (${f(plan.area)} m²)` });
    },

    /**
     * Tons of any bulk material from a volume, or from an area and depth; loose or in-place density.
     */
    tonnage: (i, c, f) => {
        let volume;

        if (i.input === 'volume') {
            if (!(i.volume > 0)) {
                return { empty: 'Enter the volume.' };
            }

            volume = i.volume / 1000;
        } else {
            const plan = shapeArea('rectangle', i);

            if (plan.empty) {
                return plan;
            }

            if (!(i.depth > 0)) {
                return { empty: 'Enter the depth.' };
            }

            volume = plan.area * i.depth;
        }

        const material = bulkDensity(c.data, i.material, i.density, i.state);

        if (!material) {
            return { error: 'Choose a material or enter its density.' };
        }

        const { tons, rows } = bulkRows(volume, material.density, f, price(i));

        return {
            value: f(tons),
            unit: 'US tons',
            label: 'Weight',
            sub: `${f(volume / YD3)} yd³ at ${f(material.density)} kg/m³ (${material.source})`,
            rows: { ...rows, long: `${f((volume * material.density) / 1016.0469088)} long tons` },
        };
    },

    /**
     * Riprap: layer thickness checked against 1.5 × D50 (FHWA HEC-23), placed density = ρrock × (1 − porosity).
     */
    rip_rap: (i, c, f) => {
        const plan = planArea(i);

        if (plan.empty || plan.error) {
            return plan;
        }

        if (missing(i, 'thickness', 'd50', 'gravity', 'porosity') || !(i.thickness > 0) || !(i.d50 > 0) || !(i.gravity > 0)) {
            return { empty: 'Enter the layer thickness, D50, rock specific gravity and porosity.' };
        }

        if (!(i.porosity >= 0 && i.porosity < 100)) {
            return { error: 'Porosity must be between 0 and 100%.' };
        }

        const volume = plan.area * i.thickness;
        const density = i.gravity * 1000 * (1 - i.porosity / 100);
        const minimum = 1.5 * i.d50;
        const { tons, rows } = bulkRows(volume, density, f, price(i));

        return {
            value: f(tons),
            unit: 'US tons',
            label: 'Riprap needed',
            sub: i.thickness >= minimum - 1e-9 ? `Layer meets 1.5 × D50 = ${f(minimum / IN)} in` : `Thinner than 1.5 × D50 = ${f(minimum / IN)} in: thicken the layer`,
            rows: { ...rows, check: i.thickness >= minimum - 1e-9 ? `OK (${f(i.thickness / IN)} in ≥ ${f(minimum / IN)} in)` : `Too thin (${f(i.thickness / IN)} in < ${f(minimum / IN)} in)` },
        };
    },

    /**
     * Excavation: bank volume (prismoid or frustum with side slopes), swell to loose volume, truckloads.
     */
    excavation: (i, c, f) => {
        if (missing(i, 'depth') || !(i.depth > 0)) {
            return { empty: 'Enter the depth.' };
        }

        const slope = i.slope > 0 ? i.slope : 0;
        const d = i.depth;
        let volume;

        if (i.shape === 'circle') {
            if (!(i.diameter > 0)) {
                return { empty: 'Enter the bottom diameter.' };
            }

            const r1 = i.diameter / 2;
            const r2 = r1 + slope * d;
            volume = (Math.PI * d * (r1 * r1 + r1 * r2 + r2 * r2)) / 3;
        } else {
            if (!(i.length > 0) || !(i.width > 0)) {
                return { empty: 'Enter the bottom length and width.' };
            }

            const bottom = i.length * i.width;
            const top = (i.length + 2 * slope * d) * (i.width + 2 * slope * d);
            const middle = (i.length + slope * d) * (i.width + slope * d);
            volume = (d / 6) * (bottom + 4 * middle + top);
        }

        const soil = c.data.bulk[i.soil];
        const swell = soil.bank / soil.loose - 1;
        const loose = volume * (1 + swell);
        const trucks = i.truck > 0 ? Math.ceil(loose / (i.truck / 1000)) : null;

        return {
            value: f(volume / YD3),
            unit: 'yd³ bank',
            label: 'Excavation volume',
            sub: `${f(volume)} m³ in place; ${soil.name.toLowerCase()} swells ${f(swell * 100)}% when dug`,
            rows: {
                loose: `${f(loose / YD3)} yd³ (${f(loose)} m³)`,
                swell: `${f(swell * 100)}% (bank ${f(soil.bank)} → loose ${f(soil.loose)} kg/m³)`,
                weight: `${f((volume * soil.bank) / SHORT_TON)} US tons (${f((volume * soil.bank) / 1000)} t)`,
                trucks: trucks === null ? 'Enter a truck capacity' : `${f(trucks)} loads`,
                ft3: `${f(volume / FT3)} ft³ bank`,
            },
        };
    },

    /**
     * Asphalt: compacted volume × compacted density.
     */
    asphalt: (i, c, f) => {
        const plan = planArea(i);

        if (plan.empty || plan.error) {
            return plan;
        }

        if (!(i.thickness > 0)) {
            return { empty: 'Enter the compacted thickness.' };
        }

        const density = i.density > 0 ? i.density : c.data.asphalt_density;
        const volume = plan.area * i.thickness;
        const { tons, rows } = bulkRows(volume, density, f, price(i));

        return {
            value: f(tons),
            unit: 'US tons',
            label: 'Asphalt needed',
            sub: `${f(plan.area / 0.83612736)} yd² × ${f(i.thickness / IN)} in at ${f(density)} kg/m³`,
            rows: { ...rows, area: `${f(plan.area / FT2)} ft² (${f(plan.area / 0.83612736)} yd²)` },
        };
    },

    /**
     * Road base and gravel driveways: compacted depth, loose material ordered = compacted volume × (1 + compaction).
     */
    road_base: (i, c, f) => {
        const plan = planArea(i);

        if (plan.empty || plan.error) {
            return plan;
        }

        if (!(i.depth > 0) || missing(i, 'compaction')) {
            return { empty: 'Enter the compacted depth and compaction allowance.' };
        }

        const compacted = plan.area * i.depth;
        const loose = compacted * (1 + i.compaction / 100);

        return materialOutcome(i, c, f, loose, 'Base to order', { compacted: `${f(compacted / YD3)} yd³ compacted → ${f(loose / YD3)} yd³ loose` });
    },

    gravel_driveway: (i, c, f) => {
        if (missing(i, 'length', 'width', 'compaction') || !(i.length > 0) || !(i.width > 0)) {
            return { empty: 'Enter the driveway length, width and compaction allowance.' };
        }

        const area = i.length * i.width;
        const layers = [
            ['Base layer', i.base_depth, i.base_material],
            ['Middle layer', i.middle_depth, i.middle_material],
            ['Top layer', i.top_depth, i.top_material],
        ].filter(([, depth]) => depth > 0);

        if (!layers.length) {
            return { empty: 'Enter at least one layer depth.' };
        }

        let totalTons = 0;
        let totalYd3 = 0;
        const list = layers.map(([name, depth, key]) => {
            const material = bulkDensity(c.data, key);
            const volume = area * depth * (1 + i.compaction / 100);
            const tons = (volume * material.density) / SHORT_TON;
            totalTons += tons;
            totalYd3 += volume / YD3;

            return { label: `${name}: ${f(depth / IN)} in of ${material.name.toLowerCase()}`, value: `${f(tons)} US tons (${f(volume / YD3)} yd³)` };
        });

        return {
            value: f(totalTons),
            unit: 'US tons',
            label: 'Stone for the driveway',
            sub: `${f(area / FT2)} ft², ${layers.length} layer${layers.length > 1 ? 's' : ''}, ${f(i.compaction)}% compaction allowance`,
            rows: { yd3: `${f(totalYd3)} yd³ loose`, tonnes: `${f((totalTons * SHORT_TON) / 1000)} t`, cost: i.price > 0 ? money(totalTons * i.price) : 'Enter a price per ton', area: `${f(area / FT2)} ft²` },
            lists: { layers: list },
        };
    },

    /**
     * French drain: trench volume less the pipe, filter fabric to wrap the trench, and the fall.
     */
    french_drain: (i, c, f) => {
        if (missing(i, 'length', 'width', 'depth', 'pipe') || !(i.length > 0) || !(i.width > 0) || !(i.depth > 0)) {
            return { empty: 'Enter the trench length, width, depth and pipe diameter.' };
        }

        if (i.pipe >= Math.min(i.width, i.depth)) {
            return { error: 'The pipe must be narrower than the trench.' };
        }

        const trench = i.length * i.width * i.depth;
        const pipe = (Math.PI / 4) * i.pipe ** 2 * i.length;
        const gravel = trench - pipe;
        const fabricWidth = 2 * i.depth + 2 * i.width + (i.overlap > 0 ? i.overlap : 0);
        const fall = i.slope > 0 ? (i.length * i.slope) / 100 : 0;

        return materialOutcome(i, c, f, gravel, 'Drain gravel', {
            pipe: `${f(i.length / FT)} ft of ${f(i.pipe / IN)} in pipe`,
            fabric: `${f(fabricWidth / FT)} ft wide × ${f(i.length / FT)} ft (${f((fabricWidth * i.length) / FT2)} ft²)`,
            fall: fall ? `${f(fall / IN)} in over the run (${f(i.slope)}%)` : 'Enter a slope',
            trench: `${f(trench / YD3)} yd³ dug`,
        });
    },

    /**
     * Fire glass: fill volume × bulk density per pound (manufacturer figure, editable).
     */
    fire_glass: (i, c, f) => {
        const plan = shapeArea(i.shape, i);

        if (plan.empty || plan.error) {
            return plan;
        }

        if (!(i.depth > 0) || !(i.density > 0)) {
            return { empty: 'Enter the fill depth and the bulk density.' };
        }

        const volume = plan.area * i.depth;
        const kg = volume * i.density;
        const bags = i.bag > 0 ? Math.ceil(kg / i.bag) : null;

        return {
            value: f(kg / LB),
            unit: 'lb',
            label: 'Fire glass needed',
            sub: `${f(volume / FT3)} ft³ at ${f(i.density / 16.01846337396014)} lb/ft³`,
            rows: { kg: `${f(kg)} kg`, volume: `${f(volume / (IN ** 3))} in³ (${f(volume * 1000)} L)`, bags: bags === null ? 'Enter a bag size' : `${f(bags)} bags`, area: `${f(plan.area / FT2)} ft²` },
        };
    },

    /**
     * Paver sand: bedding layer, optional base course of crushed stone.
     */
    paver_sand: (i, c, f) => {
        const plan = planArea(i);

        if (plan.empty || plan.error) {
            return plan;
        }

        if (!(i.bedding > 0)) {
            return { empty: 'Enter the bedding sand depth.' };
        }

        const sand = bulkDensity(c.data, 'sand_damp', i.density);
        const sandVolume = plan.area * i.bedding;
        const sandTons = (sandVolume * sand.density) / SHORT_TON;
        const base = i.base > 0 ? bulkDensity(c.data, 'crushed_stone') : null;
        const baseVolume = base ? plan.area * i.base * (1 + (i.compaction > 0 ? i.compaction / 100 : 0)) : 0;

        return {
            value: f(sandTons),
            unit: 'US tons',
            label: 'Bedding sand',
            sub: `${f(sandVolume / YD3)} yd³ of damp sand at ${f(sand.density)} kg/m³`,
            rows: {
                sand_yd3: `${f(sandVolume / YD3)} yd³ (${f(sandVolume / FT3)} ft³)`,
                bags: `${f(Math.ceil((sandVolume * sand.density) / (50 * LB)))} × 50 lb bags`,
                base: base ? `${f((baseVolume * base.density) / SHORT_TON)} US tons (${f(baseVolume / YD3)} yd³ loose)` : 'Enter a base depth',
                area: `${f(plan.area / FT2)} ft²`,
            },
        };
    },
};

export default defineTools(handlers);
