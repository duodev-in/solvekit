import { formatMoney } from '../currency.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Trees & forestry calculators. Lengths arrive in meters, areas in m² (see formula.js).
 */
const FT = 0.3048;
const IN = 0.0254;
const ACRE = 4046.8564224;
const LB = 0.45359237;
const RAD = Math.PI / 180;

const money = (value) => formatMoney(value, { decimals: 0 });

/**
 * Basal area of one stem in m² from its diameter in meters.
 */
export function basalArea(diameterM) {
    return (Math.PI / 4) * diameterM ** 2;
}

export function doyle(diameterIn, lengthFt) {
    return ((diameterIn - 4) ** 2 * lengthFt) / 16;
}

export function scribner(diameterIn, lengthFt) {
    return ((0.79 * diameterIn ** 2 - 2 * diameterIn - 4) * lengthFt) / 16;
}

/**
 * International ¼-inch rule: 0.22D² − 0.71D per 4-ft section, with ½ in of taper per section.
 */
export function international(diameterIn, lengthFt) {
    let total = 0;
    let remaining = lengthFt;
    let diameter = diameterIn;

    while (remaining > 0) {
        const section = Math.min(4, remaining);
        total += (0.22 * diameter ** 2 - 0.71 * diameter) * (section / 4);
        diameter += 0.5;
        remaining -= section;
    }

    return total;
}

/**
 * CO₂ stored in a tree: green weight from DBH and height, roots +20%, 72.5% dry matter,
 * 50% carbon, CO₂ = C × 3.6663. Returns pounds.
 */
export function treeCarbon(diameterIn, heightFt) {
    const green = (diameterIn < 11 ? 0.25 : 0.15) * diameterIn ** 2 * heightFt * 1.2;
    const dry = green * 0.725;
    const carbon = dry * 0.5;

    return { green, dry, carbon, co2: carbon * 3.6663 };
}

export const handlers = {
    height: (i, c, f) => {
        let height;
        let sub;

        if (i.method === 'angle') {
            if (missing(i, 'distance', 'angle', 'eye')) {
                return { empty: 'Enter the distance, the angle to the top and your eye height.' };
            }

            if (i.distance <= 0 || i.angle <= 0 || i.angle >= 90) {
                return { error: 'Distance must be greater than 0 and the angle between 0° and 90°.' };
            }

            height = i.distance * Math.tan(i.angle * RAD) + i.eye;
            sub = `${f(i.distance / FT)} ft away at ${f(i.angle)}° plus eye height`;
        } else if (i.method === 'two_angles') {
            if (missing(i, 'distance', 'angle', 'base_angle')) {
                return { empty: 'Enter the distance and the angles to the top and the base.' };
            }

            height = i.distance * (Math.tan(i.angle * RAD) + Math.tan(i.base_angle * RAD));
            sub = `Top ${f(i.angle)}°, base ${f(i.base_angle)}° below eye level`;
        } else {
            if (missing(i, 'shadow', 'stick', 'stick_shadow')) {
                return { empty: 'Enter the tree\'s shadow, a stick\'s height and the stick\'s shadow.' };
            }

            if (i.stick_shadow <= 0) {
                return { error: 'The stick\'s shadow must be greater than 0.' };
            }

            height = (i.shadow * i.stick) / i.stick_shadow;
            sub = 'Similar triangles: tree height ÷ tree shadow = stick ÷ stick shadow';
        }

        return { value: f(height / FT), unit: 'ft', label: 'Tree height', sub, rows: { meters: f(height) } };
    },

    diameter: (i, c, f) => {
        if (missing(i, 'circumference')) {
            return { empty: 'Enter the trunk circumference at breast height (4.5 ft).' };
        }

        if (i.circumference <= 0) {
            return { error: 'Circumference must be greater than 0.' };
        }

        const diameter = i.circumference / Math.PI;

        return {
            value: f(diameter / IN),
            unit: 'in',
            label: 'Diameter at breast height (DBH)',
            sub: `${f(i.circumference / IN)} in ÷ π`,
            rows: { cm: f(diameter * 100), radius: `${f(diameter / 2 / IN)} in`, basal: `${f(basalArea(diameter) / (FT * FT))} ft²` },
        };
    },

    basal_area: (i, c, f) => {
        if (missing(i, 'dbh')) {
            return { empty: 'Enter the diameter at breast height.' };
        }

        if (i.dbh <= 0) {
            return { error: 'DBH must be greater than 0.' };
        }

        const perTree = basalArea(i.dbh);
        const trees = i.trees > 0 ? i.trees : 1;

        return {
            value: f(perTree / (FT * FT)),
            unit: 'ft²',
            label: 'Basal area per tree',
            sub: `0.005454 × ${f(i.dbh / IN)}² in`,
            rows: { m2: f(perTree), stand_ac: `${f((perTree * trees) / (FT * FT))} ft² per acre for ${f(trees)} trees/acre`, stand_ha: `${f((perTree * trees * 10000) / ACRE)} m² per hectare` },
        };
    },

    age: (i, c, f) => {
        if (missing(i, 'circumference')) {
            return { empty: 'Enter the trunk circumference at breast height.' };
        }

        if (i.circumference <= 0) {
            return { error: 'Circumference must be greater than 0.' };
        }

        const species = c.data[i.species];
        const diameterIn = i.circumference / Math.PI / IN;

        return {
            value: f(Math.round(diameterIn * species.factor)),
            unit: 'years',
            label: `Estimated age of a ${species.name.toLowerCase()}`,
            sub: `${f(diameterIn)} in diameter × growth factor ${species.factor}`,
            rows: { diameter: `${f(diameterIn)} in`, factor: String(species.factor) },
            lists: {
                compare: Object.entries(c.data).map(([key, other]) => ({ label: other.name, value: `${f(Math.round(diameterIn * other.factor))} years`, highlight: key === i.species })),
            },
        };
    },

    spacing: (i, c, f) => {
        if (missing(i, 'area', 'spacing', 'row')) {
            return { empty: 'Enter the area and the spacing between trees and rows.' };
        }

        if (i.area <= 0 || i.spacing <= 0 || i.row <= 0) {
            return { error: 'Area and spacings must be greater than 0.' };
        }

        const trees = Math.floor(i.area / (i.spacing * i.row));

        return {
            value: f(trees),
            unit: 'trees',
            label: 'Trees needed',
            sub: `${f(i.spacing / FT)} ft apart in rows ${f(i.row / FT)} ft apart`,
            rows: { per_acre: f(Math.floor(ACRE / (i.spacing * i.row))), per_ha: f(Math.floor(10000 / (i.spacing * i.row))) },
        };
    },

    value: (i, c, f) => {
        if (missing(i, 'dbh', 'price', 'species', 'condition', 'location')) {
            return { empty: 'Enter the diameter, unit price and the three ratings.' };
        }

        if (i.dbh <= 0 || i.price < 0 || [i.species, i.condition, i.location].some((v) => v < 0 || v > 100)) {
            return { error: 'Diameter must be greater than 0 and ratings 0 to 100%.' };
        }

        const areaIn2 = (Math.PI / 4) * (i.dbh / IN) ** 2;
        const basic = areaIn2 * i.price;
        const value = basic * (i.species / 100) * (i.condition / 100) * (i.location / 100);

        return {
            value: money(value),
            unit: '',
            label: 'Appraised value (estimate)',
            sub: 'Trunk formula method; a certified arborist gives a formal appraisal',
            rows: { area: `${f(areaIn2)} in²`, basic: money(basic), factors: `${f(i.species)}% × ${f(i.condition)}% × ${f(i.location)}%` },
        };
    },

    board_feet: (i, c, f) => {
        if (i.mode === 'lumber') {
            if (missing(i, 'thickness', 'width', 'length', 'pieces')) {
                return { empty: 'Enter thickness, width, length and number of pieces.' };
            }

            const bf = ((i.thickness / IN) * (i.width / IN) * (i.length / FT) * i.pieces) / 12;

            return { value: f(bf), unit: 'bf', label: 'Board feet', sub: 'thickness (in) × width (in) × length (ft) ÷ 12', rows: { m3: f(bf * 0.00235974), cost: i.price > 0 ? money(bf * i.price) : 'Enter a price per board foot' } };
        }

        if (missing(i, 'log_diameter', 'log_length')) {
            return { empty: 'Enter the small-end diameter and log length.' };
        }

        const diameter = i.log_diameter / IN;
        const length = i.log_length / FT;

        if (diameter < 6) {
            return { error: 'Log rules apply from about 6 inches small-end diameter.' };
        }

        const results = { doyle: doyle(diameter, length), scribner: scribner(diameter, length), international: international(diameter, length) };

        return {
            value: f(Math.round(results[i.scale])),
            unit: 'bf',
            label: `${{ doyle: 'Doyle', scribner: 'Scribner', international: 'International ¼″' }[i.scale]} log scale`,
            sub: `${f(diameter)} in small end, ${f(length)} ft long`,
            rows: { doyle: f(Math.round(results.doyle)), scribner: f(Math.round(results.scribner)), international: f(Math.round(results.international)) },
        };
    },

    cord: (i, c, f) => {
        if (missing(i, 'length', 'height', 'depth')) {
            return { empty: 'Enter the stack length, height and depth.' };
        }

        if ([i.length, i.height, i.depth].some((v) => v <= 0)) {
            return { error: 'Sizes must be greater than 0.' };
        }

        const m3 = i.length * i.height * i.depth;
        const ft3 = m3 / FT ** 3;
        const cords = ft3 / 128;

        return {
            value: f(cords),
            unit: 'cords',
            label: 'Firewood',
            sub: `${f(ft3)} ft³ stacked (a full cord is 128 ft³)`,
            rows: { face: `${f((i.length * i.height) / (FT * FT) / 32)} face cords (4 × 8 ft faces)`, steres: f(m3), cost: i.price > 0 ? money(cords * i.price) : 'Enter a price per cord' },
        };
    },

    carbon: (i, c, f) => {
        if (missing(i, 'dbh', 'height')) {
            return { empty: 'Enter the trunk diameter and tree height.' };
        }

        if (i.dbh <= 0 || i.height <= 0) {
            return { error: 'Diameter and height must be greater than 0.' };
        }

        const result = treeCarbon(i.dbh / IN, i.height / FT);

        return {
            value: f(result.co2),
            unit: 'lb CO₂',
            label: 'CO₂ stored (estimate)',
            sub: `About ${f(result.co2 * LB)} kg; a rough allometric estimate`,
            rows: { kg: f(result.co2 * LB), green: `${f(result.green)} lb`, dry: `${f(result.dry)} lb`, carbon: `${f(result.carbon)} lb` },
        };
    },

    leaves: (i, c, f) => {
        if (missing(i, 'crown', 'lai', 'leaf_size')) {
            return { empty: 'Enter the crown width, leaf area index and typical leaf size.' };
        }

        if (i.crown <= 0 || i.lai <= 0 || i.leaf_size <= 0) {
            return { error: 'Values must be greater than 0.' };
        }

        const groundArea = Math.PI * (i.crown / 2) ** 2;
        const leafArea = groundArea * i.lai;
        const leaves = leafArea / (i.leaf_size / 10000);

        return {
            value: f(Math.round(leaves)),
            unit: 'leaves',
            label: 'Estimated leaves',
            sub: 'Crown area × leaf area index ÷ leaf size; a rough estimate',
            rows: { crown_area: `${f(groundArea)} m²`, leaf_area: `${f(leafArea)} m²` },
        };
    },
};

export default defineTools(handlers);
