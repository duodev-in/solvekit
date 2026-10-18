import { FT, FT2, FT3, IN, LB, PCF, SHORT_TON, YD3, money, readRows } from '../construction/geometry.js';
import { defineTools, missing } from '../engines/formula.js';
import { doyle, international, scribner } from './forestry.js';

/**
 * Weights of materials: metal shapes, pipe, plate, glass, stone, logs, lumber, concrete and rebar.
 * Lengths arrive in meters, volumes in liters, masses in grams and densities in kg/m³.
 */
const lbAndKg = (kg, f) => `${f(kg / LB)} lb (${f(kg)} kg)`;

/**
 * Density (kg/m³) of a "group:key" material from the page data, e.g. "metal:steel" or "wood:white_oak".
 */
export function materialDensity(data, choice) {
    const [group, key] = String(choice ?? '').split(':');
    const row = { metal: data.metals, wood: data.wood, stone: data.stone, concrete: data.concrete, glass: data.glass }[group]?.[key];

    if (!row) {
        return null;
    }

    if (group === 'wood') {
        return { density: row.sg_12 * 1000 * 1.12, name: `${row.name} at 12% moisture` };
    }

    if (group === 'concrete') {
        return { density: row.pcf * PCF, name: row.name };
    }

    if (group === 'stone') {
        return { density: row.density, name: row.name };
    }

    return { density: row.density * 1000, name: row.name };
}

/**
 * Cross-section area (m²) of a bar, tube or structural profile with sharp corners and uniform thickness.
 */
export function profileArea(profile, i) {
    const t = i.thickness;

    switch (profile) {
        case 'plate':
            return i.width > 0 && t > 0 ? i.width * t : null;
        case 'round':
            return i.diameter > 0 ? (Math.PI / 4) * i.diameter ** 2 : null;
        case 'square':
            return i.side > 0 ? i.side ** 2 : null;
        case 'hex':
            return i.side > 0 ? (Math.sqrt(3) / 2) * i.side ** 2 : null;
        case 'flat':
            return i.width > 0 && t > 0 ? i.width * t : null;
        case 'tube':
            if (!(i.diameter > 0) || !(i.wall > 0) || 2 * i.wall >= i.diameter) {
                return null;
            }

            return (Math.PI / 4) * (i.diameter ** 2 - (i.diameter - 2 * i.wall) ** 2);
        case 'rect_tube':
            if (!(i.width > 0) || !(i.depth > 0) || !(i.wall > 0) || 2 * i.wall >= Math.min(i.width, i.depth)) {
                return null;
            }

            return i.width * i.depth - (i.width - 2 * i.wall) * (i.depth - 2 * i.wall);
        case 'angle':
            if (!(i.width > 0) || !(i.depth > 0) || !(t > 0) || t >= Math.min(i.width, i.depth)) {
                return null;
            }

            return t * (i.width + i.depth - t);
        case 'channel':
            if (!(i.width > 0) || !(i.depth > 0) || !(t > 0) || 2 * t >= i.depth || t >= i.width) {
                return null;
            }

            return t * (i.depth + 2 * i.width - 2 * t);
        case 'tee':
            if (!(i.width > 0) || !(i.depth > 0) || !(t > 0) || t >= i.depth) {
                return null;
            }

            return t * (i.width + i.depth - t);
        default:
            return null;
    }
}

/**
 * Each profile has its own fields on the page (so each can carry its own label); map them to profileArea's names.
 */
export function profileDimensions(profile, i) {
    return {
        plate: { width: i.plate_width, thickness: i.plate_thickness },
        round: { diameter: i.round_d },
        square: { side: i.square_side },
        hex: { side: i.hex_af },
        flat: { width: i.flat_width, thickness: i.flat_thickness },
        tube: { diameter: i.tube_od, wall: i.tube_wall },
        rect_tube: { width: i.rt_width, depth: i.rt_height, wall: i.rt_wall },
        angle: { width: i.angle_a, depth: i.angle_b, thickness: i.angle_t },
        channel: { depth: i.ch_depth, width: i.ch_flange, thickness: i.ch_t },
        tee: { width: i.tee_flange, depth: i.tee_depth, thickness: i.tee_t },
    }[profile] ?? {};
}

function checkAnswer(answerKg, actualKg, f) {
    if (!(answerKg > 0)) {
        return 'Enter your answer to check it';
    }

    const error = (answerKg - actualKg) / actualKg;

    return Math.abs(error) <= 0.01 ? `Correct (within 1%: ${f(answerKg / LB)} lb)` : `Not quite: ${f(Math.abs(error) * 100)}% ${error > 0 ? 'high' : 'low'}`;
}

export const handlers = {
    /**
     * Metal weight for any profile: area × length × density × count. W-shapes use the nominal lb/ft in the name.
     */
    metal_weight: (i, c, f) => {
        const profile = i.profile ?? 'plate';

        if (missing(i, 'length') || !(i.length > 0)) {
            return { empty: 'Enter the length.' };
        }

        const count = i.count > 0 ? i.count : 1;
        let perMeter;
        let area = null;
        let densityText;

        if (profile === 'w_shape') {
            const match = String(i.designation ?? '').trim().match(/^W\s*(\d+(?:\.\d+)?)\s*[x×]\s*(\d+(?:\.\d+)?)$/i);

            if (!match) {
                return { error: 'Enter a W-shape as W depth × lb/ft, for example W8x31.' };
            }

            perMeter = (Number(match[2]) * LB) / FT;
            densityText = `nominal ${match[2]} lb/ft from the designation (AISC)`;
        } else {
            area = profileArea(profile, profileDimensions(profile, i));

            if (area === null) {
                return { empty: 'Enter every size of the section (walls thinner than half the width).' };
            }

            const material = i.density > 0 ? { density: i.density, name: 'your density' } : materialDensity(c.data, `metal:${i.metal}`);

            if (!material) {
                return { error: 'Choose a metal or enter its density.' };
            }

            perMeter = area * material.density;
            densityText = `${material.name}, ${f(material.density / 1000)} g/cm³`;
        }

        const piece = perMeter * i.length;
        const total = piece * count;
        const rows = {
            total: lbAndKg(total, f),
            piece: lbAndKg(piece, f),
            per_length: `${f((perMeter * FT) / LB)} lb/ft (${f(perMeter)} kg/m)`,
            area: area === null ? 'From the designation' : `${f(area / IN ** 2)} in² (${f(area * 1e6)} mm²)`,
            density: densityText,
            cost: i.price > 0 ? money((total / LB) * i.price) : 'Enter a price per lb',
        };

        if (profile === 'plate') {
            rows.per_area = `${f((perMeter / i.plate_width) * (FT2 / LB))} lb/ft² (${f(perMeter / i.plate_width)} kg/m²)`;
        }

        if (i.answer !== undefined) {
            rows.answer = checkAnswer(i.answer / 1000, total, f);
        }

        return {
            value: f(total / LB),
            unit: 'lb',
            label: 'Weight',
            sub: `${f(total)} kg${count > 1 ? `, ${f(count)} pieces` : ''}; ${densityText}`,
            rows,
        };
    },

    /**
     * Pipe weight from ASME B36.10M size and schedule, or any OD and wall.
     */
    pipe_weight: (i, c, f) => {
        let od;
        let wall;

        if (i.mode === 'custom') {
            od = i.od;
            wall = i.wall;
        } else {
            const size = c.data.pipe.sizes[i.nps];
            const inches = size?.wall[i.schedule];

            if (!inches) {
                return { error: `NPS ${i.nps} is not made in ${c.data.pipe.schedules[i.schedule]}.` };
            }

            od = size.od * IN;
            wall = inches * IN;
        }

        if (!(od > 0) || !(wall > 0) || !(i.length > 0)) {
            return { empty: 'Enter the outside diameter, wall thickness and length.' };
        }

        if (2 * wall >= od) {
            return { error: 'The wall must be less than half the outside diameter.' };
        }

        const material = i.density > 0 ? { density: i.density, name: 'your density' } : { density: c.data.metals[i.metal].density * 1000, name: c.data.metals[i.metal].name };
        const id = od - 2 * wall;
        const metal = (Math.PI / 4) * (od ** 2 - id ** 2) * material.density;
        const water = (Math.PI / 4) * id ** 2 * 998.2;
        const count = i.count > 0 ? i.count : 1;
        const total = metal * i.length * count;
        const rows = {
            per_foot: `${f((metal * FT) / LB)} lb/ft (${f(metal)} kg/m)`,
            id: `${f(id / IN)} in (${f(id * 1000)} mm)`,
            od: `${f(od / IN)} in OD, ${f(wall / IN)} in wall`,
            water: `${f((water * FT) / LB)} lb/ft of water`,
            filled: lbAndKg((metal + water) * i.length * count, f),
            density: `${material.name}, ${f(material.density / 1000)} g/cm³`,
        };

        if (i.answer !== undefined) {
            rows.answer = checkAnswer(i.answer / 1000, total, f);
        }

        return {
            value: f(total / LB),
            unit: 'lb',
            label: 'Pipe weight',
            sub: `${f(total)} kg for ${f((i.length * count) / FT)} ft of pipe`,
            rows,
        };
    },

    glass_weight: (i, c, f) => {
        if (missing(i, 'length', 'width', 'thickness') || !(i.length > 0) || !(i.width > 0) || !(i.thickness > 0)) {
            return { empty: 'Enter the length, width and thickness.' };
        }

        const glass = c.data.glass[i.glass];
        const count = i.count > 0 ? i.count : 1;
        const plies = i.plies > 0 ? i.plies : 1;
        const area = i.length * i.width;
        const glassKg = area * i.thickness * plies * glass.density * 1000;
        const interlayer = plies > 1 && i.interlayer > 0 ? area * i.interlayer * (plies - 1) * 1070 : 0;
        const pane = glassKg + interlayer;

        return {
            value: f((pane * count) / LB),
            unit: 'lb',
            label: 'Glass weight',
            sub: `${f(pane * count)} kg; ${glass.name.toLowerCase()} at ${f(glass.density)} g/cm³`,
            rows: {
                pane: lbAndKg(pane, f),
                per_area: `${f((pane / area) * (FT2 / LB))} lb/ft² (${f(pane / area)} kg/m²)`,
                area: `${f(area / FT2)} ft² (${f(area)} m²) per pane`,
                interlayer: plies > 1 ? `${f(interlayer / LB)} lb of PVB interlayer` : 'Single pane',
            },
        };
    },

    stone_weight: (i, c, f) => {
        let volume;

        if (i.form === 'volume') {
            volume = i.volume / 1000;
        } else if (i.form === 'cylinder') {
            volume = i.diameter > 0 && i.length > 0 ? (Math.PI / 4) * i.diameter ** 2 * i.length : NaN;
        } else {
            volume = i.length * i.width * i.height;
        }

        if (!(volume > 0)) {
            return { empty: 'Enter the stone\'s sizes or volume.' };
        }

        const material = i.density > 0 ? { density: i.density, name: 'your density' } : materialDensity(c.data, `stone:${i.stone}`);
        const count = i.count > 0 ? i.count : 1;
        const piece = volume * material.density;
        const rows = {
            piece: lbAndKg(piece, f),
            tons: `${f((piece * count) / SHORT_TON)} US tons (${f((piece * count) / 1000)} t)`,
            volume: `${f(volume / FT3)} ft³ (${f(volume)} m³) each`,
            density: `${material.name}, ${f(material.density)} kg/m³ (${f(material.density / PCF)} lb/ft³)`,
        };

        if (i.answer !== undefined) {
            rows.answer = checkAnswer(i.answer / 1000, piece * count, f);
        }

        return { value: f((piece * count) / LB), unit: 'lb', label: 'Stone weight', sub: `${f(piece * count)} kg${count > 1 ? ` for ${f(count)} pieces` : ''}`, rows };
    },

    /**
     * Log weight: Smalian volume × wood density at the moisture content (Wood Handbook).
     */
    log_weight: (i, c, f) => {
        if (missing(i, 'small', 'large', 'length') || !(i.small > 0) || !(i.large > 0) || !(i.length > 0)) {
            return { empty: 'Enter both end diameters and the length.' };
        }

        if (i.small > i.large) {
            return { error: 'The small-end diameter is larger than the large end.' };
        }

        const wood = c.data.wood[i.species];
        let moisture = i.moisture;
        let gravity = wood.sg_green;

        if (i.condition === 'dry') {
            moisture = 12;
            gravity = wood.sg_12;
        } else if (i.condition === 'green' && !(moisture >= 0)) {
            moisture = wood.mc_green;
        }

        if (!(moisture >= 0)) {
            return { error: `The Wood Handbook gives no green moisture for ${wood.name}; enter one.` };
        }

        const volume = (i.length * ((Math.PI / 4) * i.small ** 2 + (Math.PI / 4) * i.large ** 2)) / 2;
        const density = gravity * 1000 * (1 + moisture / 100);
        const count = i.count > 0 ? i.count : 1;
        const kg = volume * density * count;
        const smallIn = i.small / IN;
        const lengthFt = i.length / FT;

        return {
            value: f(kg / LB),
            unit: 'lb',
            label: 'Log weight',
            sub: `${wood.name} at ${f(moisture)}% moisture: ${f(density)} kg/m³ (${f(density / PCF)} lb/ft³)`,
            rows: {
                kg: `${f(kg)} kg (${f(kg / SHORT_TON)} US tons)`,
                volume: `${f((volume * count) / FT3)} ft³ (${f(volume * count)} m³), Smalian`,
                density: `${f(density)} kg/m³ at ${f(moisture)}%`,
                board_feet: smallIn >= 6 ? `${f(Math.round(international(smallIn, lengthFt) * count))} bf International ¼″, ${f(Math.round(doyle(smallIn, lengthFt) * count))} Doyle, ${f(Math.round(scribner(smallIn, lengthFt) * count))} Scribner` : 'Log rules start at 6 in',
            },
        };
    },

    lumber: (i, c, f) => {
        const lengthFactor = c.rowUnits?.pieces?.[i.pieces_unit]?.factor ?? FT;
        const pieces = readRows(i.pieces, [1, 1, lengthFactor, 1]).filter(([t, w, l]) => t > 0 && w > 0 && l > 0);

        if (!pieces.length) {
            return { empty: 'Enter at least one piece: nominal thickness, width (in) and length.' };
        }

        const dressed = (nominal) => c.data.lumber_dressed[nominal] ?? (nominal >= 5 ? nominal - 0.5 : null);
        let boardFeet = 0;
        let actualVolume = 0;
        let count = 0;
        let linear = 0;
        const list = pieces.map(([t, w, l, n]) => {
            const qty = n > 0 ? n : 1;
            const bf = (t * w * (l / FT) * qty) / 12;
            const at = dressed(t);
            const aw = dressed(w);
            boardFeet += bf;
            count += qty;
            linear += l * qty;

            if (at && aw) {
                actualVolume += at * IN * aw * IN * l * qty;
            }

            return { label: `${f(qty)} × ${f(t)}×${f(w)} at ${f(l / FT)} ft (actual ${at ? f(at) : '?'} × ${aw ? f(aw) : '?'} in)`, value: `${f(bf)} bf` };
        });

        return {
            value: f(boardFeet),
            unit: 'bf',
            label: 'Board feet',
            sub: `${f(count)} pieces, ${f(linear / FT)} linear ft; nominal sizes`,
            rows: {
                cost: i.price > 0 ? money(boardFeet * i.price) : 'Enter a price per board foot',
                nominal: `${f(boardFeet * 0.00235973722)} m³ nominal`,
                actual: actualVolume ? `${f(actualVolume / FT3)} ft³ (${f(actualVolume)} m³) dressed` : 'Sizes outside the PS 20 table',
                linear: `${f(linear / FT)} ft (${f(linear)} m)`,
            },
            lists: { pieces: list },
        };
    },

    concrete_weight: (i, c, f) => {
        const volume = i.input === 'volume' ? i.volume / 1000 : i.length * i.width * i.depth;

        if (!(volume > 0)) {
            return { empty: 'Enter the volume or the sizes.' };
        }

        const type = c.data.concrete[i.type];
        const density = type.pcf * PCF;
        const kg = volume * density;

        return {
            value: f(kg / LB),
            unit: 'lb',
            label: 'Concrete weight',
            sub: `${type.name}: ${f(type.pcf)} lb/ft³ (${f(density)} kg/m³), ASCE 7`,
            rows: {
                kg: `${f(kg)} kg`,
                tons: `${f(kg / SHORT_TON)} US tons (${f(kg / 1000)} t)`,
                per_yd3: `${f((density * YD3) / LB)} lb per yd³`,
                volume: `${f(volume / YD3)} yd³ (${f(volume)} m³)`,
            },
        };
    },

    /**
     * Rebar grid for a slab: bars each way at a spacing inside the cover, with lap splices on long runs.
     */
    rebar: (i, c, f) => {
        if (missing(i, 'length', 'width', 'spacing', 'cover', 'stock') || !(i.length > 0) || !(i.width > 0) || !(i.spacing > 0) || !(i.stock > 0)) {
            return { empty: 'Enter the slab size, spacing, cover and stock bar length.' };
        }

        const bar = i.system === 'metric' ? c.data.rebar.metric[i.metric_bar] : c.data.rebar.us[i.us_bar];
        const diameter = i.system === 'metric' ? bar.diameter / 1000 : bar.diameter * IN;
        const massPerMeter = i.system === 'metric' ? bar.mass : (bar.weight * LB) / FT;
        const lap = (i.lap > 0 ? i.lap : 0) * diameter;
        const runL = i.length - 2 * i.cover;
        const runW = i.width - 2 * i.cover;

        if (runL <= 0 || runW <= 0) {
            return { error: 'The cover is larger than half the slab.' };
        }

        if (lap >= i.stock) {
            return { error: 'The lap is longer than a stock bar.' };
        }

        const spacingW = i.spacing_other > 0 ? i.spacing_other : i.spacing;
        const barsAlongLength = Math.floor(runW / i.spacing + 1e-9) + 1;
        const barsAlongWidth = Math.floor(runL / spacingW + 1e-9) + 1;
        const piecesPerRun = (run) => (run <= i.stock ? 1 : Math.ceil((run - lap) / (i.stock - lap) - 1e-9));
        const lengthWithLaps = (run) => run + (piecesPerRun(run) - 1) * lap;
        const total = barsAlongLength * lengthWithLaps(runL) + barsAlongWidth * lengthWithLaps(runW);
        const stockBars = Math.ceil(total / i.stock - 1e-9);
        const kg = total * massPerMeter;

        return {
            value: f(total / FT),
            unit: 'ft of bar',
            label: 'Rebar needed',
            sub: `${f(barsAlongLength)} bars × ${f(runL / FT)} ft and ${f(barsAlongWidth)} bars × ${f(runW / FT)} ft, ${f(i.spacing / IN)} in on center`,
            rows: {
                stock: `${f(stockBars)} bars of ${f(i.stock / FT)} ft`,
                weight: lbAndKg(kg, f),
                meters: `${f(total)} m`,
                laps: lap ? `${f(lap / IN)} in per splice (${f(i.lap)} bar diameters)` : 'No laps',
                bars: `${f(barsAlongLength + barsAlongWidth)} runs`,
            },
        };
    },

    size_to_weight: (i, c, f) => {
        if (missing(i, 'length', 'width', 'height') || !(i.length > 0) || !(i.width > 0) || !(i.height > 0)) {
            return { empty: 'Enter the length, width and height.' };
        }

        const material = i.density > 0 ? { density: i.density, name: 'your density' } : materialDensity(c.data, i.material);

        if (!material) {
            return { error: 'Choose a material or enter its density.' };
        }

        const count = i.count > 0 ? i.count : 1;
        const volume = i.length * i.width * i.height;
        const piece = volume * material.density;

        return {
            value: f((piece * count) / LB),
            unit: 'lb',
            label: 'Weight',
            sub: `${material.name}, ${f(material.density)} kg/m³`,
            rows: {
                kg: `${f(piece * count)} kg`,
                piece: lbAndKg(piece, f),
                volume: `${f(volume / FT3)} ft³ (${f(volume * 1000)} L) each`,
                tons: `${f((piece * count) / SHORT_TON)} US tons`,
            },
        };
    },
};

export default defineTools(handlers);
