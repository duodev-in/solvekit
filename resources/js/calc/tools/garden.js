import { formatMoney } from '../currency.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Gardening & crops calculators. Inputs arrive in SI base units (m, m², L, °C); see formula.js.
 */
const FT = 0.3048;
const IN = 0.0254;
const FT2 = FT * FT;
const FT3_L = 28.316846592;
const YD3_L = 764.554857984;
const GAL_L = 3.785411784;
const ACRE = 4046.8564224;
const LB = 0.45359237;

const money = (value) => formatMoney(value);

/**
 * Bulk material for an area at a depth: volume in every unit plus bags and cost.
 */
export function coverage(areaM2, depthM, bagFt3 = 2, pricePerBag = 0) {
    const liters = areaM2 * depthM * 1000;
    const bags = Math.ceil(liters / (bagFt3 * FT3_L));

    return { liters, yd3: liters / YD3_L, ft3: liters / FT3_L, m3: liters / 1000, bags, cost: pricePerBag > 0 ? bags * pricePerBag : null };
}

function coverageOutcome(i, format, label, extraRows = {}) {
    if (missing(i, 'area', 'depth')) {
        return { empty: 'Enter the area and the depth.' };
    }

    if (i.area <= 0 || i.depth <= 0) {
        return { error: 'Area and depth must be greater than 0.' };
    }

    const result = coverage(i.area, i.depth, Number(i.bag ?? 2), i.price);

    return {
        value: format(result.yd3),
        unit: 'yd³',
        label,
        sub: `${format(i.area / FT2)} ft² at ${format(i.depth / IN)} in deep`,
        rows: {
            ft3: format(result.ft3),
            m3: format(result.m3),
            liters: format(result.liters),
            bags: `${result.bags} bags of ${i.bag ?? 2} ft³`,
            cost: result.cost === null ? 'Enter a price per bag' : money(result.cost),
            ...extraRows(result),
        },
    };
}

export function plantsForArea(areaM2, spacingM, pattern) {
    const perPlant = pattern === 'triangular' ? spacingM * spacingM * Math.sqrt(3) / 2 : spacingM * spacingM;

    return Math.floor(areaM2 / perPlant);
}

export function saturationVaporPressure(celsius) {
    return 0.61078 * Math.exp((17.27 * celsius) / (celsius + 237.3));
}

export function growingDegreeUnits(maxF, minF, base = 50, cap = 86) {
    const high = Math.min(Math.max(maxF, base), cap);
    const low = Math.min(Math.max(minF, base), cap);

    return (high + low) / 2 - base;
}

const toF = (celsius) => (celsius * 9) / 5 + 32;

export const handlers = {
    mulch: (i, c, f) => coverageOutcome(i, f, 'Mulch needed', () => ({})),

    compost: (i, c, f) => coverageOutcome(i, f, 'Compost needed', () => ({})),

    soil: (i, c, f) => coverageOutcome(i, f, 'Soil needed', (r) => ({ tons: `${f((r.m3 * 1.2) / 0.90718474)} US tons (≈ 1.2 t/m³)` })),

    raised_bed: (i, c, f) => {
        if (missing(i, 'beds', 'length', 'width', 'depth')) {
            return { empty: 'Enter the number of beds and their size.' };
        }

        if ([i.beds, i.length, i.width, i.depth].some((v) => v <= 0)) {
            return { error: 'Beds and sizes must be greater than 0.' };
        }

        const liters = i.beds * i.length * i.width * i.depth * 1000;
        const ft3 = liters / FT3_L;

        return {
            value: f(ft3),
            unit: 'ft³',
            label: 'Soil mix needed',
            sub: `${i.beds} bed${i.beds === 1 ? '' : 's'} · ${f(liters / YD3_L)} yd³`,
            rows: {
                yd3: f(liters / YD3_L),
                liters: f(liters),
                topsoil: `${f(ft3 * 0.6)} ft³`,
                compost: `${f(ft3 * 0.3)} ft³`,
                aeration: `${f(ft3 * 0.1)} ft³`,
                bags: `${Math.ceil(ft3 / 1.5)} bags of 1.5 ft³`,
            },
        };
    },

    potting_soil: (i, c, f) => {
        if (missing(i, 'pots', 'diameter', 'depth')) {
            return { empty: 'Enter the number of pots and their size.' };
        }

        if ([i.pots, i.diameter, i.depth].some((v) => v <= 0)) {
            return { error: 'Pots and sizes must be greater than 0.' };
        }

        // Tapered pots hold about 85% of a straight cylinder of the rim diameter.
        const liters = i.pots * Math.PI * (i.diameter / 2) ** 2 * i.depth * 1000 * 0.85;

        return {
            value: f(liters),
            unit: 'L',
            label: 'Potting mix needed',
            sub: `${i.pots} pot${i.pots === 1 ? '' : 's'}, ${f(liters / i.pots)} L each`,
            rows: {
                quarts: f(liters / (GAL_L / 4)),
                ft3: f(liters / FT3_L),
                bags8: `${Math.ceil(liters / (GAL_L * 2))} bags of 8 qt`,
                bags1: `${Math.ceil(liters / FT3_L)} bags of 1 ft³`,
            },
        };
    },

    pine_straw: (i, c, f) => {
        if (missing(i, 'area', 'depth')) {
            return { empty: 'Enter the area and the depth.' };
        }

        if (i.area <= 0 || i.depth <= 0) {
            return { error: 'Area and depth must be greater than 0.' };
        }

        // One bale covers about 50 ft² at 3 inches.
        const coveragePerBale = (50 * 3) / (i.depth / IN);
        const bales = Math.ceil(i.area / FT2 / coveragePerBale);

        return {
            value: String(bales),
            unit: 'bales',
            label: 'Pine straw needed',
            sub: `${f(i.area / FT2)} ft² at ${f(i.depth / IN)} in`,
            rows: { coverage: `${f(coveragePerBale)} ft² per bale`, cost: i.price > 0 ? money(bales * i.price) : 'Enter a price per bale' },
        };
    },

    sod: (i, c, f) => {
        if (missing(i, 'area', 'waste')) {
            return { empty: 'Enter the lawn area.' };
        }

        if (i.area <= 0 || i.waste < 0) {
            return { error: 'Area must be greater than 0 and waste cannot be negative.' };
        }

        const ft2 = (i.area / FT2) * (1 + i.waste / 100);

        return {
            value: f(Math.ceil(ft2)),
            unit: 'ft²',
            label: 'Sod to order',
            sub: `Includes ${f(i.waste)}% for cuts and waste`,
            rows: {
                m2: f(ft2 * FT2),
                pieces: `${Math.ceil(ft2 / (16 * 24 / 144))} pieces (16 × 24 in)`,
                pallets: `${f(ft2 / 450)} pallets of 450 ft²`,
                cost: i.price > 0 ? money(ft2 * i.price) : 'Enter a price per ft²',
            },
        };
    },

    grass_seed: (i, c, f) => {
        if (missing(i, 'area')) {
            return { empty: 'Enter the lawn area.' };
        }

        if (i.area <= 0) {
            return { error: 'Area must be greater than 0.' };
        }

        const grass = c.data[i.grass];
        const rate = i.job === 'overseed' ? grass.overseed : grass.new;
        const pounds = (i.area / FT2 / 1000) * rate;

        return {
            value: f(pounds),
            unit: 'lb',
            label: `${grass.name} seed`,
            sub: `${f(rate)} lb per 1,000 ft² (${i.job === 'overseed' ? 'overseeding' : 'new lawn'})`,
            rows: { kg: f(pounds * LB), rate: `${f((rate * LB * 1000) / (1000 * FT2))} g per m²`, bags: `${Math.ceil(pounds / 5)} bags of 5 lb` },
        };
    },

    plant_spacing: (i, c, f) => {
        if (missing(i, 'area', 'spacing')) {
            return { empty: 'Enter the area and the spacing.' };
        }

        if (i.area <= 0 || i.spacing <= 0) {
            return { error: 'Area and spacing must be greater than 0.' };
        }

        const plants = plantsForArea(i.area, i.spacing, i.pattern);

        return {
            value: f(plants),
            unit: 'plants',
            label: 'Plants needed',
            sub: `${i.pattern === 'triangular' ? 'Triangular' : 'Square'} spacing of ${f(i.spacing / IN)} in`,
            rows: {
                square: f(plantsForArea(i.area, i.spacing, 'square')),
                triangular: f(plantsForArea(i.area, i.spacing, 'triangular')),
                per_m2: f(plants / i.area),
            },
        };
    },

    plant_population: (i, c, f) => {
        if (missing(i, 'row', 'spacing')) {
            return { empty: 'Enter the row width and the in-row spacing.' };
        }

        if (i.row <= 0 || i.spacing <= 0) {
            return { error: 'Spacings must be greater than 0.' };
        }

        const perM2 = 1 / (i.row * i.spacing);

        return {
            value: f(Math.round(perM2 * ACRE)),
            unit: 'plants/acre',
            label: 'Plant population',
            sub: `${f(i.row / IN)} in rows, ${f(i.spacing / IN)} in apart`,
            rows: { hectare: f(Math.round(perM2 * 10000)), m2: f(perM2), per_row_ft: f(FT / i.spacing) },
        };
    },

    bulb_spacing: (i, c, f) => {
        if (missing(i, 'area')) {
            return { empty: 'Enter the bed area.' };
        }

        if (i.area <= 0) {
            return { error: 'Area must be greater than 0.' };
        }

        const bulb = c.data[i.bulb];
        const bulbs = plantsForArea(i.area, bulb.spacing * IN, 'square');

        return {
            value: f(bulbs),
            unit: 'bulbs',
            label: `${bulb.name} bulbs`,
            sub: `${bulb.spacing} in apart, ${bulb.depth} in deep`,
            rows: { spacing: `${bulb.spacing} in (${f(bulb.spacing * 2.54)} cm)`, depth: `${bulb.depth} in (${f(bulb.depth * 2.54)} cm)`, per_ft2: f(144 / bulb.spacing ** 2) },
        };
    },

    vegetable_seed: (i, c, f) => {
        if (missing(i, 'length', 'rows', 'germination')) {
            return { empty: 'Enter the row length, number of rows and germination rate.' };
        }

        if (i.length <= 0 || i.rows <= 0 || i.germination <= 0 || i.germination > 100) {
            return { error: 'Row length and rows must be greater than 0; germination must be 1 to 100%.' };
        }

        const crop = c.data[i.crop];
        const plants = Math.floor(i.length / (crop.spacing * IN)) * i.rows;
        const seeds = Math.ceil((plants * crop.seeds) / (i.germination / 100));

        return {
            value: f(seeds),
            unit: 'seeds',
            label: `${crop.name} seeds to sow`,
            sub: `${f(plants)} plants at ${crop.spacing} in apart, ${f(i.germination)}% germination`,
            rows: { plants: f(plants), spacing: `${crop.spacing} in in the row, ${crop.row} in between rows`, per_spot: `${crop.seeds} per spot, thin to one` },
        };
    },

    vegetable_yield: (i, c, f) => {
        if (missing(i, 'length')) {
            return { empty: 'Enter the total row length.' };
        }

        if (i.length <= 0) {
            return { error: 'Row length must be greater than 0.' };
        }

        const tens = i.length / FT / 10;
        const crop = c.data[i.crop];

        return {
            value: f(crop.yield * tens),
            unit: 'lb',
            label: `Expected ${crop.name.toLowerCase()}`,
            sub: `About ${crop.yield} lb per 10 ft of row; actual yields vary widely`,
            rows: { kg: f(crop.yield * tens * LB) },
            lists: {
                compare: Object.entries(c.data).map(([key, other]) => ({ label: other.name, value: `${f(other.yield * tens)} lb`, highlight: key === i.crop })),
            },
            texts: { 'compare-heading': `Other crops in ${f(i.length / FT)} ft of row` },
        };
    },

    germination: (i, c, f) => {
        if (missing(i, 'sown', 'sprouted')) {
            return { empty: 'Enter the seeds sown and the seeds that sprouted.' };
        }

        if (i.sown <= 0 || i.sprouted < 0 || i.sprouted > i.sown) {
            return { error: 'Sprouted seeds must be between 0 and the number sown.' };
        }

        const rate = i.sprouted / i.sown;

        return {
            value: f(rate * 100),
            unit: '%',
            label: 'Germination rate',
            sub: `${f(i.sprouted)} of ${f(i.sown)} seeds sprouted`,
            rows: { needed: i.target > 0 && rate > 0 ? `${Math.ceil(i.target / rate)} seeds for ${f(i.target)} plants` : 'Enter a target number of plants', failed: f(i.sown - i.sprouted) },
        };
    },

    fertilizer: (i, c, f) => {
        if (missing(i, 'n', 'p', 'k', 'area', 'target')) {
            return { empty: 'Enter the N-P-K numbers, area and target rate.' };
        }

        if (i.n <= 0 || i.area <= 0 || i.target <= 0) {
            return { error: 'Nitrogen %, area and target rate must be greater than 0.' };
        }

        const per1000 = i.target / (i.n / 100);
        const total = per1000 * (i.area / FT2 / 1000);

        return {
            value: f(total),
            unit: 'lb',
            label: 'Fertilizer needed',
            sub: `${f(per1000)} lb of ${i.n}-${i.p}-${i.k} per 1,000 ft² for ${f(i.target)} lb N`,
            rows: { kg: f(total * LB), per1000: f(per1000), p: `${f((total * i.p) / 100)} lb P₂O₅`, k: `${f((total * i.k) / 100)} lb K₂O` },
        };
    },

    water_soluble: (i, c, f) => {
        if (missing(i, 'ppm', 'n', 'water')) {
            return { empty: 'Enter the target ppm, fertilizer N% and water volume.' };
        }

        if (i.ppm <= 0 || i.n <= 0 || i.water <= 0) {
            return { error: 'Values must be greater than 0.' };
        }

        const grams = (i.ppm * i.water) / (i.n * 10);

        return {
            value: f(grams),
            unit: 'g',
            label: 'Fertilizer to dissolve',
            sub: `${f(i.ppm)} ppm N from a ${f(i.n)}% N fertilizer`,
            rows: { per_l: `${f(grams / i.water)} g per L`, per_gal: `${f(((grams / i.water) * GAL_L) / 28.349523125)} oz per US gal`, oz: f(grams / 28.349523125) },
        };
    },

    lime: (i, c, f) => {
        if (missing(i, 'area', 'current', 'target')) {
            return { empty: 'Enter the area, current pH and target pH.' };
        }

        if (i.area <= 0 || i.current < 3 || i.target > 8.5) {
            return { error: 'Check the area and that pH values are realistic (3 to 8.5).' };
        }

        if (i.target <= i.current) {
            return { error: 'Lime raises pH; the target must be higher than the current pH. Use sulfur to lower it.' };
        }

        const soil = c.data[i.texture];
        const per1000 = soil.lb * (i.target - i.current);
        const total = per1000 * (i.area / FT2 / 1000);

        return {
            value: f(total),
            unit: 'lb',
            label: 'Ground limestone (estimate)',
            sub: `${f(per1000)} lb per 1,000 ft² on ${soil.name.toLowerCase()} soil; a soil test gives the exact rate`,
            rows: { kg: f(total * LB), per1000: f(per1000), bags: `${Math.ceil(total / 40)} bags of 40 lb` },
        };
    },

    mowing_cost: (i, c, f) => {
        if (missing(i, 'price', 'per_month', 'months')) {
            return { empty: 'Enter the price per mow and how often.' };
        }

        if (i.price < 0 || i.per_month <= 0 || i.months <= 0) {
            return { error: 'Values must be greater than 0.' };
        }

        const mows = i.per_month * i.months;

        return {
            value: money(i.price * mows),
            unit: '',
            label: 'Cost per season',
            sub: `${f(mows)} mows at ${money(i.price)}`,
            rows: { per_month: money(i.price * i.per_month), mows: f(mows), per_1000: i.area > 0 ? `${money(i.price / (i.area / FT2 / 1000))} per 1,000 ft²` : 'Enter the lawn area' },
        };
    },

    acres_per_hour: (i, c, f) => {
        if (missing(i, 'width', 'speed', 'efficiency')) {
            return { empty: 'Enter the implement width, speed and efficiency.' };
        }

        if (i.width <= 0 || i.speed <= 0 || i.efficiency <= 0 || i.efficiency > 100) {
            return { error: 'Width and speed must be greater than 0; efficiency 1 to 100%.' };
        }

        const m2PerHour = i.width * i.speed * 3600 * (i.efficiency / 100);

        return {
            value: f(m2PerHour / ACRE),
            unit: 'ac/h',
            label: 'Field capacity',
            sub: `${f(i.width / FT)} ft wide at ${f(i.speed / 0.44704)} mph, ${f(i.efficiency)}% efficient`,
            rows: { hectares: f(m2PerHour / 10000), theoretical: f(m2PerHour / (i.efficiency / 100) / ACRE), field: i.field > 0 ? `${f((i.field / m2PerHour))} h for the field` : 'Enter a field size' },
        };
    },

    corn_yield: (i, c, f) => {
        if (missing(i, 'ears', 'rows', 'kernels', 'factor')) {
            return { empty: 'Enter ears, kernel rows, kernels per row and the kernel factor.' };
        }

        if ([i.ears, i.rows, i.kernels, i.factor].some((v) => v <= 0)) {
            return { error: 'Values must be greater than 0.' };
        }

        const bushels = (i.ears * i.rows * i.kernels) / i.factor;

        return {
            value: f(bushels),
            unit: 'bu/ac',
            label: 'Estimated yield',
            sub: `${f(i.ears)} ears in 1/1,000 acre × ${f(i.rows)} rows × ${f(i.kernels)} kernels ÷ ${f(i.factor)}`,
            rows: { tonnes_ha: f((bushels * 56 * LB) / 1000 / (ACRE / 10000)), ears_acre: f(i.ears * 1000), kernels_ear: f(i.rows * i.kernels) },
        };
    },

    gdu: (i, c, f) => {
        if (missing(i, 'max', 'min')) {
            return { empty: 'Enter the day\'s high and low temperature.' };
        }

        if (i.min > i.max) {
            return { error: 'The low cannot be higher than the high.' };
        }

        const gdu = growingDegreeUnits(toF(i.max), toF(i.min));

        return {
            value: f(gdu),
            unit: 'GDU (°F)',
            label: 'Growing degree units today',
            sub: `High and low capped to 50–86 °F for corn`,
            rows: { celsius: f((gdu * 5) / 9), high: `${f(Math.min(Math.max(toF(i.max), 50), 86))} °F`, low: `${f(Math.min(Math.max(toF(i.min), 50), 86))} °F`, season: i.days > 0 ? `${f(gdu * i.days)} GDU over ${f(i.days)} similar days` : 'Enter a number of days' },
        };
    },

    dli: (i, c, f) => {
        if (missing(i, 'ppfd', 'hours')) {
            return { empty: 'Enter the light intensity (PPFD) and hours of light.' };
        }

        if (i.ppfd < 0 || i.hours <= 0 || i.hours > 24) {
            return { error: 'PPFD cannot be negative and hours must be 1 to 24.' };
        }

        const dli = i.ppfd * i.hours * 0.0036;
        const band = dli < 6 ? 'Low light (shade plants, houseplants)' : dli < 12 ? 'Medium light' : dli < 20 ? 'High light' : 'Very high light (fruiting crops)';

        return {
            value: f(dli),
            unit: 'mol/m²/day',
            label: 'Daily light integral',
            sub: band,
            lists: { 'quick-ref': [12, 17, 22, 30].map((target) => ({ label: `${target} mol/m²/day`, value: i.ppfd > 0 ? `${f(target / (i.ppfd * 0.0036))} h at this PPFD` : '—' })) },
        };
    },

    vpd: (i, c, f) => {
        if (missing(i, 'temp', 'humidity', 'offset')) {
            return { empty: 'Enter the air temperature, humidity and leaf offset.' };
        }

        if (i.humidity < 0 || i.humidity > 100) {
            return { error: 'Relative humidity must be 0 to 100%.' };
        }

        const air = saturationVaporPressure(i.temp);
        const leaf = saturationVaporPressure(i.temp + i.offset);
        const vpd = leaf - air * (i.humidity / 100);
        const band = vpd < 0.4 ? 'Too low: risk of mould and poor transpiration' : vpd < 0.8 ? 'Propagation and clones' : vpd < 1.2 ? 'Vegetative growth' : vpd < 1.6 ? 'Flowering' : 'Too high: plants may close their stomata';

        return {
            value: f(vpd),
            unit: 'kPa',
            label: 'Vapor pressure deficit',
            sub: band,
            rows: { svp_air: `${f(air)} kPa`, svp_leaf: `${f(leaf)} kPa`, avp: `${f(air * (i.humidity / 100))} kPa`, leaf_temp: `${f(i.temp + i.offset)} °C` },
        };
    },

    co2: (i, c, f) => {
        if (missing(i, 'length', 'width', 'height', 'target', 'ambient')) {
            return { empty: 'Enter the room size and the CO₂ levels.' };
        }

        if ([i.length, i.width, i.height].some((v) => v <= 0) || i.target <= i.ambient) {
            return { error: 'Room sizes must be greater than 0 and the target above the ambient level.' };
        }

        const room = i.length * i.width * i.height;
        const co2 = (room * (i.target - i.ambient)) / 1e6;

        return {
            value: f(co2 / 0.028316846592),
            unit: 'ft³',
            label: 'CO₂ to add',
            sub: `To raise ${f(room / 0.028316846592)} ft³ from ${f(i.ambient)} to ${f(i.target)} ppm`,
            rows: { liters: f(co2 * 1000), kg: f(co2 * 1.84), lb: f((co2 * 1.84) / LB), room: `${f(room)} m³` },
        };
    },

    water_potential: (i, c, f) => {
        if (missing(i, 'ionization', 'concentration', 'temp', 'pressure')) {
            return { empty: 'Enter the ionization constant, concentration, temperature and pressure potential.' };
        }

        if (i.ionization <= 0 || i.concentration < 0 || i.temp < -273.15) {
            return { error: 'Check the values: ionization > 0, concentration ≥ 0, temperature above absolute zero.' };
        }

        const solute = -i.ionization * i.concentration * 0.0083145 * (i.temp + 273.15);
        const total = solute + i.pressure;

        return {
            value: f(total),
            unit: 'MPa',
            label: 'Water potential (Ψ)',
            sub: `Ψs ${f(solute)} MPa + Ψp ${f(i.pressure)} MPa`,
            rows: { solute: `${f(solute)} MPa`, pressure: `${f(i.pressure)} MPa`, bars: `${f(total * 10)} bar` },
        };
    },

    rainwater: (i, c, f) => {
        if (missing(i, 'area', 'rain', 'efficiency')) {
            return { empty: 'Enter the roof area, rainfall and efficiency.' };
        }

        if (i.area <= 0 || i.rain < 0 || i.efficiency <= 0 || i.efficiency > 100) {
            return { error: 'Area must be greater than 0; efficiency 1 to 100%.' };
        }

        const liters = i.area * i.rain * 1000 * (i.efficiency / 100);

        return {
            value: f(liters / GAL_L),
            unit: 'US gal',
            label: 'Water collected',
            sub: `${f(i.area / FT2)} ft² roof, ${f(i.rain / IN)} in of rain, ${f(i.efficiency)}% captured`,
            rows: { liters: f(liters), ft3: f(liters / FT3_L), barrels: `${f(liters / GAL_L / 55)} rain barrels of 55 gal` },
        };
    },
};

export default defineTools(handlers);
