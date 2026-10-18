import { bulkDensity } from '../construction/bulk.js';
import { FT, FT2, FT3, IN, LB, PCF, SHORT_TON, YD3, money, shapeArea } from '../construction/geometry.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Concrete, masonry and tile setting materials. Lengths arrive in meters, areas in m², volumes in liters.
 */
const REINFORCED_PCF = 150;

/**
 * Premix bag counts for a volume (m³) from the US bag yields in config('construction_data.bags.concrete').
 */
export function bagRows(volume, data, f) {
    return Object.fromEntries(Object.entries(data.bags.concrete).map(([pounds, ft3]) => [`bags_${pounds}`, `${f(Math.ceil(volume / (ft3 * FT3) - 1e-9))} bags (${ft3} ft³ each)`]));
}

function concreteOutcome(volume, i, c, f, label, sub, extra = {}) {
    const waste = i.waste > 0 ? i.waste / 100 : 0;
    const total = volume * (1 + waste);
    const yd3 = total / YD3;

    return {
        value: f(yd3),
        unit: 'yd³',
        label,
        sub: sub + (waste ? `, plus ${f(i.waste)}% extra` : ''),
        rows: {
            m3: `${f(total)} m³`,
            ft3: `${f(total / FT3)} ft³`,
            ...bagRows(total, c.data, f),
            weight: `${f((total * REINFORCED_PCF * PCF) / SHORT_TON)} US tons at 150 lb/ft³`,
            cost: i.price > 0 ? money(yd3 * i.price) : 'Enter a price per yd³',
            ...extra,
        },
    };
}

/**
 * Volume (m³) of solid steps on grade with an optional top landing.
 */
export function stairsVolume(steps, rise, run, width, landing = 0) {
    return width * rise * run * ((steps * (steps + 1)) / 2) + width * landing * steps * rise;
}

/**
 * Core volume (m³) of one hollow concrete block with two cores, from its actual size and the
 * face shell and web thicknesses; the grout column runs the full nominal height (bed joints are on the shells).
 */
export function blockCoreVolume(width, faceShell, web, nominalLength = 16 * IN, nominalHeight = 8 * IN, joint = 0.375 * IN) {
    const actualLength = nominalLength - joint;
    const actualWidth = width - joint;
    const coreWidth = actualWidth - 2 * faceShell;
    const coreLength = (actualLength - 3 * web) / 2;

    if (coreWidth <= 0 || coreLength <= 0) {
        return 0;
    }

    return 2 * coreWidth * coreLength * nominalHeight;
}

/**
 * Mortar volume (m³) for one masonry unit laid with full bed and head joints of thickness j.
 */
export function mortarPerUnit(length, height, width, joint) {
    return width * ((length + joint) * (height + joint) - length * height);
}

/**
 * Cement, lime and sand for a mortar volume by ASTM C270 proportions; sand ≈ mortar volume (the paste fills the voids).
 * Weights per ft³ from ASTM C270: portland cement 94 lb, hydrated lime 40 lb, damp loose masonry sand 80 lb.
 */
function mortarMaterials(volume, type, f) {
    const parts = type.cement + type.lime;
    const sand = volume;
    const cement = (sand / (3 * parts)) * type.cement;
    const lime = (sand / (3 * parts)) * type.lime;

    return {
        cement: `${f(cement / FT3)} ft³: ${f(Math.ceil(cement / FT3 - 1e-9))} bags of 94 lb portland cement`,
        lime: `${f(lime / FT3)} ft³: ${f(Math.ceil((lime * 40 * PCF) / (50 * LB) - 1e-9))} bags of 50 lb hydrated lime`,
        sand: `${f(sand / FT3)} ft³ (${f(sand / YD3)} yd³, ${f((sand * 80 * PCF) / SHORT_TON)} US tons damp)`,
    };
}

export const handlers = {
    concrete: (i, c, f) => {
        const count = i.count > 0 ? i.count : 1;
        let volume;
        let sub;

        switch (i.form) {
            case 'slab': {
                const plan = shapeArea(i.shape, i);

                if (plan.empty || plan.error) {
                    return plan;
                }

                if (!(i.thickness > 0)) {
                    return { empty: 'Enter the slab thickness.' };
                }

                volume = plan.area * i.thickness;
                sub = `${f(plan.area / FT2)} ft² × ${f(i.thickness / IN)} in`;
                break;
            }
            case 'wall':
            case 'footing':
                if (!(i.run > 0) || !(i.section_width > 0) || !(i.section_depth > 0)) {
                    return { empty: 'Enter the length, width and height or depth.' };
                }

                volume = i.run * i.section_width * i.section_depth;
                sub = `${f(i.run / FT)} ft × ${f(i.section_width / IN)} in × ${f(i.section_depth / IN)} in`;
                break;
            case 'round':
                if (!(i.round_diameter > 0) || !(i.round_height > 0)) {
                    return { empty: 'Enter the diameter and height.' };
                }

                volume = (Math.PI / 4) * i.round_diameter ** 2 * i.round_height;
                sub = `π ÷ 4 × ${f(i.round_diameter / IN)} in² × ${f(i.round_height / FT)} ft`;
                break;
            case 'stairs':
                if (!(i.steps >= 1) || !(i.rise > 0) || !(i.run_depth > 0) || !(i.stair_width > 0)) {
                    return { empty: 'Enter the steps, rise, run and width.' };
                }

                volume = stairsVolume(Math.round(i.steps), i.rise, i.run_depth, i.stair_width, i.landing > 0 ? i.landing : 0);
                sub = `${f(Math.round(i.steps))} solid steps`;
                break;
            case 'curb': {
                if (!(i.run > 0) || !(i.curb_depth > 0) || !(i.curb_height > 0) || !(i.gutter_width > 0) || !(i.flag > 0)) {
                    return { empty: 'Enter the curb and gutter sizes and the length.' };
                }

                volume = i.run * (i.curb_depth * (i.curb_height + i.flag) + i.gutter_width * i.flag);
                sub = `${f(i.run / FT)} ft of curb and gutter`;
                break;
            }
            default:
                return { error: 'Choose what you are pouring.' };
        }

        return concreteOutcome(volume * count, i, c, f, 'Concrete needed', sub + (count > 1 ? ` × ${f(count)}` : ''));
    },

    sonotube: (i, c, f) => {
        const diameter = i.tube === 'custom' ? i.diameter : Number(i.tube) * IN;

        if (!(diameter > 0) || !(i.height > 0)) {
            return { empty: 'Enter the tube diameter and height.' };
        }

        const count = i.count > 0 ? i.count : 1;
        const one = (Math.PI / 4) * diameter ** 2 * i.height;

        return concreteOutcome(one * count, i, c, f, 'Concrete needed', `${f(count)} × ${f(diameter / IN)} in tube, ${f(i.height / FT)} ft`, { each: `${f(one / FT3)} ft³ per tube` });
    },

    column: (i, c, f) => {
        const count = i.count > 0 ? i.count : 1;
        let one;

        if (i.section === 'square') {
            if (!(i.side > 0) || !(i.other > 0) || !(i.height > 0)) {
                return { empty: 'Enter both sides and the height.' };
            }

            one = i.side * i.other * i.height;
        } else {
            if (!(i.diameter > 0) || !(i.height > 0)) {
                return { empty: 'Enter the diameter and height.' };
            }

            one = (Math.PI / 4) * i.diameter ** 2 * i.height;
        }

        return concreteOutcome(one * count, i, c, f, 'Concrete needed', `${f(count)} column${count > 1 ? 's' : ''}`, { each: `${f(one / FT3)} ft³ per column` });
    },

    stairs: (i, c, f) => {
        if (missing(i, 'steps', 'rise', 'run_depth', 'stair_width') || !(i.steps >= 1) || !(i.rise > 0) || !(i.run_depth > 0) || !(i.stair_width > 0)) {
            return { empty: 'Enter the steps, rise, run and width.' };
        }

        const steps = Math.round(i.steps);
        const volume = stairsVolume(steps, i.rise, i.run_depth, i.stair_width, i.landing > 0 ? i.landing : 0);

        return concreteOutcome(volume, i, c, f, 'Concrete needed', `${f(steps)} solid steps, ${f((steps * i.rise) / IN)} in total rise`, {
            rise: `${f((steps * i.rise) / IN)} in total rise, ${f(((steps - 1) * i.run_depth + (i.landing > 0 ? i.landing : i.run_depth)) / FT)} ft total run`,
        });
    },

    hole_volume: (i, c, f) => {
        if (missing(i, 'diameter', 'depth') || !(i.diameter > 0) || !(i.depth > 0)) {
            return { empty: 'Enter the hole diameter and depth.' };
        }

        const count = i.count > 0 ? i.count : 1;
        const hole = (Math.PI / 4) * i.diameter ** 2 * i.depth;
        let post = 0;

        if (i.post === 'round' && i.post_size > 0) {
            post = (Math.PI / 4) * i.post_size ** 2 * i.depth;
        } else if (i.post === 'square' && i.post_size > 0) {
            post = i.post_size ** 2 * i.depth;
        }

        if (post >= hole) {
            return { error: 'The post is as big as the hole.' };
        }

        return concreteOutcome((hole - post) * count, i, c, f, 'Concrete for the holes', `${f(count)} × ${f(i.diameter / IN)} in holes, ${f(i.depth / IN)} in deep${post ? ', less the posts' : ''}`, {
            hole: `${f(hole / FT3)} ft³ per hole (${f((hole * count) / FT3)} ft³ dug in total)`,
        });
    },

    block: (i, c, f) => {
        if (missing(i, 'length', 'height') || !(i.length > 0) || !(i.height > 0)) {
            return { empty: 'Enter the wall length and height.' };
        }

        const [blockLength, blockHeight] = String(i.block).split('x').map((v) => Number(v) * IN);
        const net = i.length * i.height - (i.openings > 0 ? i.openings : 0);

        if (net <= 0) {
            return { error: 'The openings are larger than the wall.' };
        }

        const perArea = 1 / (blockLength * blockHeight);
        const blocks = Math.ceil(net * perArea * (1 + (i.waste > 0 ? i.waste / 100 : 0)) - 1e-9);
        const courses = Math.ceil(i.height / blockHeight - 1e-9);

        return {
            value: f(blocks),
            unit: 'blocks',
            label: 'Blocks needed',
            sub: `${f(net / FT2)} ft² at ${f(perArea * FT2)} blocks per ft²${i.waste > 0 ? `, plus ${f(i.waste)}%` : ''}`,
            rows: {
                area: `${f(net / FT2)} ft² (${f(net)} m²)`,
                courses: `${f(courses)} courses, ${f(Math.ceil(i.length / blockLength - 1e-9))} blocks per course`,
                per_ft2: `${f(perArea * FT2)} per ft² (${f(perArea)} per m²)`,
                cost: i.price > 0 ? money(blocks * i.price) : 'Enter a price per block',
            },
        };
    },

    block_fill: (i, c, f) => {
        let blocks;

        if (i.input === 'blocks') {
            blocks = i.blocks;
        } else {
            blocks = i.area > 0 ? i.area / (16 * IN * 8 * IN) : NaN;
        }

        if (!(blocks > 0) || !(i.face_shell > 0) || !(i.web > 0)) {
            return { empty: 'Enter the wall area or block count and the shell and web thicknesses.' };
        }

        const core = blockCoreVolume(Number(i.width) * IN, i.face_shell, i.web);

        if (core <= 0) {
            return { error: 'The shells and webs leave no core; check the thicknesses.' };
        }

        const fraction = i.fill === 'spaced' && i.spacing > 0 ? Math.min(1, (8 * IN) / i.spacing) : 1;
        const volume = blocks * core * fraction * (1 + (i.waste > 0 ? i.waste / 100 : 0));

        return {
            value: f(volume / FT3),
            unit: 'ft³',
            label: 'Grout or concrete fill',
            sub: `${f(blocks)} blocks × ${f(core / FT3)} ft³ of core${fraction < 1 ? ` × ${f(fraction * 100)}% of cells` : ''}`,
            rows: {
                yd3: `${f(volume / YD3)} yd³ (${f(volume)} m³)`,
                ...bagRows(volume, c.data, f),
                per_block: `${f(core / FT3)} ft³ per block, both cores`,
                per_ft2: `${f((core * fraction) / (16 * IN * 8 * IN) / FT3 * FT2)} ft³ per ft² of wall`,
            },
        };
    },

    mortar: (i, c, f) => {
        const unitSize = c.data.units[i.unit_type];
        const joint = i.joint;

        if (missing(i, 'area', 'joint') || !(i.area > 0) || !(joint > 0)) {
            return { empty: 'Enter the wall area and joint thickness.' };
        }

        const [length, height, width] = unitSize.size.map((v) => v * IN);
        const units = i.area / ((length + joint) * (height + joint));
        let perUnit;

        if (unitSize.hollow) {
            // Face-shell bedding: bed and head joints on the two face shells only.
            perUnit = joint * 2 * i.face_shell * (length + joint + height);
        } else {
            perUnit = mortarPerUnit(length, height, width, joint);
        }

        const volume = units * perUnit * (1 + (i.waste > 0 ? i.waste / 100 : 0));
        const type = c.data.mortar[i.type];

        return {
            value: f(volume / FT3),
            unit: 'ft³',
            label: 'Mortar needed',
            sub: `${f(units)} ${unitSize.name.toLowerCase()}s with ${f(joint / IN)} in joints${i.waste > 0 ? `, plus ${f(i.waste)}%` : ''}`,
            rows: { units: `${f(Math.ceil(units))} units`, yd3: `${f(volume / YD3)} yd³ (${f(volume * 1000)} L)`, ...mortarMaterials(volume, type, f), proportion: `${type.name}: 1 cement : ${type.lime} lime : ${f(3 * (1 + type.lime))} sand (ASTM C270)` },
        };
    },

    /**
     * Nominal mix by volume with a dry-volume factor (site convention): cement, sand and aggregate for a concrete volume.
     */
    cement: (i, c, f) => {
        let parts;

        if (i.mix === 'custom') {
            parts = [i.part_cement, i.part_sand, i.part_aggregate];
        } else {
            parts = i.mix.split(':').map(Number);
        }

        if (!(i.volume > 0) || parts.some((p) => !(p >= 0)) || !(parts[0] > 0) || !(i.dry > 0)) {
            return { empty: 'Enter the concrete volume, the mix and the dry-volume factor.' };
        }

        const wet = i.volume / 1000;
        const dry = wet * i.dry;
        const sum = parts[0] + parts[1] + parts[2];
        const [cement, sand, aggregate] = parts.map((p) => (dry * p) / sum);
        const bag = c.data.bags.cement[i.bag];
        const cementKg = cement * 1440;
        const water = i.wc > 0 ? cementKg * i.wc : null;

        return {
            value: f(Math.ceil(cementKg / bag.kg - 1e-9)),
            unit: 'bags',
            label: 'Cement',
            sub: `${f(cementKg)} kg of cement for ${f(wet)} m³ (${f(wet / YD3)} yd³) of ${parts.join(' : ')} concrete`,
            rows: {
                cement: `${f(cement)} m³ (${f(cementKg)} kg at 1440 kg/m³)`,
                sand: `${f(sand)} m³ (${f(sand / FT3)} ft³, ${f((sand * 1420) / 1000)} t dry)`,
                aggregate: `${f(aggregate)} m³ (${f(aggregate / FT3)} ft³, ${f((aggregate * 1690) / 1000)} t)`,
                water: water === null ? 'Enter a water–cement ratio' : `${f(water)} L (${f(water / 3.785411784)} gal) at w/c ${f(i.wc)}`,
                dry: `${f(dry)} m³ of dry materials (× ${f(i.dry)})`,
            },
        };
    },

    grout: (i, c, f) => {
        if (missing(i, 'area', 'tile_length', 'tile_width', 'joint', 'depth', 'density') || !(i.area > 0) || !(i.tile_length > 0) || !(i.tile_width > 0) || !(i.joint > 0) || !(i.depth > 0) || !(i.density > 0)) {
            return { empty: 'Enter the area, tile size, joint width and depth, and the grout density.' };
        }

        const L = i.tile_length;
        const W = i.tile_width;
        const perArea = ((L + W + i.joint) * i.joint * i.depth) / ((L + i.joint) * (W + i.joint));
        const volume = i.area * perArea * (1 + (i.waste > 0 ? i.waste / 100 : 0));
        const kg = volume * i.density;
        const bags = i.bag > 0 ? Math.ceil(kg / (i.bag / 1000) - 1e-9) : null;

        return {
            value: f(kg / LB),
            unit: 'lb',
            label: 'Grout needed',
            sub: `${f(volume * 1000)} L of joints at ${f(i.density / 1000)} kg/L`,
            rows: { kg: `${f(kg)} kg`, volume: `${f(volume * 1000)} L (${f(volume / FT3)} ft³)`, per_area: `${f(((perArea * i.density) / LB) * FT2)} lb per ft² (${f(perArea * i.density)} kg/m²)`, bags: bags === null ? 'Enter a bag size' : `${f(bags)} bags` },
        };
    },

    thinset: (i, c, f) => {
        if (missing(i, 'area') || !(i.area > 0)) {
            return { empty: 'Enter the tile area.' };
        }

        const trowel = c.data.trowels[i.trowel];
        const [low, high] = i.trowel === 'custom' ? [i.coverage, i.coverage] : [trowel.min, trowel.max];

        if (!(low > 0)) {
            return { empty: 'Enter the coverage per bag from your bag.' };
        }

        const area = (i.area / FT2) * (1 + (i.waste > 0 ? i.waste / 100 : 0)) * (i.back_butter ? 1.25 : 1);
        const most = Math.ceil(area / low - 1e-9);
        const least = Math.ceil(area / high - 1e-9);

        return {
            value: f(most),
            unit: most === 1 ? 'bag' : 'bags',
            label: 'Thinset (50 lb bags)',
            sub: least === most ? `${f(area)} ft² at ${f(low)} ft² per bag` : `${f(least)}–${f(most)} bags: ${f(area)} ft² at ${f(low)}–${f(high)} ft² per bag`,
            rows: { coverage: `${f(low)}${high !== low ? `–${f(high)}` : ''} ft² per 50 lb bag`, area: `${f(area)} ft² to cover`, weight: `${f(most * 50)} lb (${f(most * 50 * LB)} kg)` },
        };
    },

    brick: (i, c, f) => {
        const unitSize = c.data.units[i.unit_type];
        let area;

        if (i.input === 'area') {
            area = i.area;
        } else {
            area = i.length * i.height;
        }

        if (!(area > 0) || !(i.joint >= 0)) {
            return { empty: 'Enter the wall size or area and the joint thickness.' };
        }

        const net = area - (i.openings > 0 ? i.openings : 0);

        if (net <= 0) {
            return { error: 'The openings are larger than the wall.' };
        }

        const [length, height, width] = unitSize.size.map((v) => v * IN);
        const perArea = 1 / ((length + i.joint) * (height + i.joint));
        const waste = i.waste > 0 ? i.waste / 100 : 0;
        const bricks = Math.ceil(net * perArea * (1 + waste) - 1e-9);
        const mortar = net * perArea * mortarPerUnit(length, height, width, i.joint) * (1 + (i.mortar_waste > 0 ? i.mortar_waste / 100 : 0));

        return {
            value: f(bricks),
            unit: 'bricks',
            label: 'Bricks needed',
            sub: `${f(net / FT2)} ft² at ${f(perArea * FT2)} per ft²${waste ? `, plus ${f(i.waste)}%` : ''}`,
            rows: { per_ft2: `${f(perArea * FT2)} per ft² (${f(perArea)} per m²)`, mortar: `${f(mortar / FT3)} ft³ of mortar (${f(mortar * 1000)} L)`, area: `${f(net / FT2)} ft² (${f(net)} m²)`, cost: i.price > 0 ? money(bricks * i.price) : 'Enter a price per brick' },
        };
    },

    retaining_wall: (i, c, f) => {
        if (missing(i, 'length', 'height', 'block_length', 'block_height', 'block_depth') || !(i.length > 0) || !(i.height > 0) || !(i.block_length > 0) || !(i.block_height > 0) || !(i.block_depth > 0)) {
            return { empty: 'Enter the wall length and height and the block size.' };
        }

        const buried = i.buried > 0 ? i.buried : 0;
        const courses = Math.ceil((i.height + buried) / i.block_height - 1e-9);
        const perCourse = Math.ceil(i.length / i.block_length - 1e-9);
        const blocks = courses * perCourse;
        const caps = i.cap_length > 0 ? Math.ceil(i.length / i.cap_length - 1e-9) : 0;
        const base = i.length * (i.block_depth + 2 * (i.base_extra > 0 ? i.base_extra : 0)) * (i.base_depth > 0 ? i.base_depth : 0);
        const drain = i.length * (i.height + buried) * (i.drain_width > 0 ? i.drain_width : 0);
        const stone = bulkDensity(c.data, 'crushed_stone');
        const gravel = bulkDensity(c.data, 'gravel');
        const warn = i.height > 4 * FT ? 'Walls over 4 ft (measured from the footing) need an engineered design under IRC R404.4.' : `${f(courses)} courses of ${f(perCourse)} blocks`;

        return {
            value: f(blocks),
            unit: 'blocks',
            label: 'Wall blocks',
            sub: warn,
            rows: {
                courses: `${f(courses)} courses (${buried ? `${f(buried / IN)} in below grade, ` : ''}${f(courses * i.block_height / IN)} in total)`,
                caps: caps ? `${f(caps)} caps` : 'Enter a cap length',
                base: base ? `${f((base * stone.density) / SHORT_TON)} US tons of base stone (${f(base / YD3)} yd³)` : 'Enter a base depth',
                drain: drain ? `${f((drain * gravel.density) / SHORT_TON)} US tons of drainage gravel (${f(drain / YD3)} yd³)` : 'Enter a drainage width',
                cost: i.price > 0 ? money(blocks * i.price) : 'Enter a price per block',
            },
        };
    },

    driveway_cost: (i, c, f) => {
        if (missing(i, 'length', 'width', 'thickness', 'concrete_price') || !(i.length > 0) || !(i.width > 0) || !(i.thickness > 0)) {
            return { empty: 'Enter the driveway size, thickness and concrete price.' };
        }

        const area = i.length * i.width;
        const volume = area * i.thickness * (1 + (i.waste > 0 ? i.waste / 100 : 0));
        const ft2 = area / FT2;
        const lines = [
            ['Concrete', (volume / YD3) * i.concrete_price],
            ['Reinforcement', ft2 * (i.reinforcement > 0 ? i.reinforcement : 0)],
            ['Labor and finishing', ft2 * (i.labor > 0 ? i.labor : 0)],
            ['Removal of old surface', ft2 * (i.removal > 0 ? i.removal : 0)],
            ['Base preparation', ft2 * (i.base > 0 ? i.base : 0)],
        ];
        const total = lines.reduce((sum, [, cost]) => sum + cost, 0);

        return {
            value: money(total),
            unit: '',
            label: 'Driveway cost',
            sub: `${money(total / ft2)} per ft² for ${f(ft2)} ft² at ${f(i.thickness / IN)} in`,
            rows: { yd3: `${f(volume / YD3)} yd³ of concrete`, per_ft2: `${money(total / ft2)} per ft²`, area: `${f(ft2)} ft² (${f(area)} m²)`, trucks: `${f(Math.ceil(volume / YD3 / 10 - 1e-9))} loads at 10 yd³` },
            lists: { lines: lines.filter(([, cost]) => cost > 0).map(([label, cost]) => ({ label, value: money(cost) })) },
        };
    },
};

export default defineTools(handlers);
