import { FT, FT2, IN, RAD, feetInches, inchFraction, money } from '../construction/geometry.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Roofing: pitch, rafters, roof area and materials, gambrel and truss geometry. Lengths arrive in meters.
 */
const ceil = (value) => Math.ceil(value - 1e-9);

/**
 * Slope multiplier (rafter length per unit of run) for a pitch in inches of rise per 12 of run.
 */
export const slopeFactor = (pitch) => Math.hypot(1, pitch / 12);

/**
 * Hip or valley length per unit of common run, for two planes of the same pitch meeting at 90° in plan.
 */
export const hipFactor = (pitch) => Math.sqrt(2 + (pitch / 12) ** 2);

function pitchFromInputs(i) {
    switch (i.mode) {
        case 'rise_run':
            return i.run > 0 && i.rise >= 0 ? (12 * i.rise) / i.run : NaN;
        case 'angle':
            return i.angle >= 0 && i.angle < 90 ? 12 * Math.tan(i.angle * RAD) : NaN;
        case 'percent':
            return i.percent >= 0 ? (12 * i.percent) / 100 : NaN;
        default:
            return i.pitch >= 0 ? i.pitch : NaN;
    }
}

export const handlers = {
    roof_pitch: (i, c, f) => {
        const pitch = pitchFromInputs(i);

        if (!Number.isFinite(pitch)) {
            return { empty: 'Enter the rise and run, angle, percent or pitch.' };
        }

        const angle = Math.atan(pitch / 12) / RAD;

        return {
            value: `${f(pitch)}/12`,
            unit: '',
            label: 'Roof pitch',
            sub: `${f(angle)}° and ${f((pitch / 12) * 100)}% slope`,
            rows: {
                angle: `${f(angle)}°`,
                percent: `${f((pitch / 12) * 100)}%`,
                ratio: pitch > 0 ? `1 : ${f(12 / pitch)}` : 'Flat',
                factor: `× ${f(slopeFactor(pitch))} (roof area ÷ footprint)`,
                hip: `× ${f(hipFactor(pitch))} hip or valley length per unit of run`,
            },
            lists: { pitches: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 14, 16, 18].map((p) => ({ label: `${p}/12`, value: `${f(Math.atan(p / 12) / RAD)}°, × ${f(slopeFactor(p))}`, highlight: Math.abs(p - pitch) < 0.5 })) },
        };
    },

    rafter_length: (i, c, f) => {
        if (missing(i, 'span', 'pitch') || !(i.span > 0) || !(i.pitch >= 0)) {
            return { empty: 'Enter the building span and the roof pitch.' };
        }

        const ridge = i.ridge > 0 ? i.ridge : 0;
        const run = i.span / 2 - ridge / 2;

        if (run <= 0) {
            return { error: 'The ridge board is wider than the span.' };
        }

        const factor = slopeFactor(i.pitch);
        const line = run * factor;
        const tail = (i.overhang > 0 ? i.overhang : 0) * factor;
        const total = line + tail;
        const angle = Math.atan(i.pitch / 12) / RAD;
        const stock = [8, 10, 12, 14, 16, 18, 20, 22, 24].map((ft) => ft * FT).find((len) => len >= total + (i.depth > 0 ? i.depth * Math.tan(angle * RAD) : 0) - 1e-9);

        return {
            value: feetInches(total),
            unit: '',
            label: 'Rafter length',
            sub: `${f(total / FT)} ft along the top edge, ridge to tail, at ${f(i.pitch)}/12`,
            rows: {
                line: `${feetInches(line)} from ridge to the outside of the wall`,
                tail: tail ? `${feetInches(tail)} overhang tail` : 'No overhang',
                rise: `${feetInches(run * (i.pitch / 12))} rise over ${feetInches(run)} of run`,
                cuts: `Plumb cut ${f(angle)}° from square, seat cut ${f(90 - angle)}°`,
                stock: stock ? `Buy ${f(stock / FT)} ft boards` : 'Longer than 24 ft stock',
            },
        };
    },

    roofing: (i, c, f) => {
        if (missing(i, 'length', 'width', 'pitch') || !(i.length > 0) || !(i.width > 0) || !(i.pitch >= 0)) {
            return { empty: 'Enter the footprint and the roof pitch.' };
        }

        const o = i.overhang > 0 ? i.overhang : 0;
        const L = i.length + 2 * o;
        const W = i.width + 2 * o;
        const factor = slopeFactor(i.pitch);
        const area = L * W * factor + (i.extra > 0 ? i.extra : 0);
        const waste = i.waste > 0 ? i.waste / 100 : 0;
        const squares = (area * (1 + waste)) / (100 * FT2);
        const bundles = ceil(squares * (i.bundles > 0 ? i.bundles : 3));
        const rafter = (W / 2) * factor;
        let ridge;
        let hips = 0;
        let edge;

        if (i.type === 'hip') {
            ridge = Math.max(L - W, 0);
            hips = 4 * (W / 2) * hipFactor(i.pitch);
            edge = 2 * (L + W);
        } else {
            ridge = L;
            edge = 2 * L + 4 * rafter;
        }

        const underlayment = i.roll > 0 ? ceil((area * 1.1) / i.roll) : null;

        return {
            value: f(squares),
            unit: 'squares',
            label: 'Roofing',
            sub: `${f(area / FT2)} ft² of roof (footprint × ${f(factor)})${waste ? ` plus ${f(i.waste)}%` : ''}; 1 square = 100 ft²`,
            rows: {
                area: `${f(area / FT2)} ft² (${f(area)} m²)`,
                bundles: `${f(bundles)} bundles at ${f(i.bundles > 0 ? i.bundles : 3)} per square`,
                underlayment: underlayment === null ? 'Enter a roll coverage' : `${f(underlayment)} rolls`,
                drip: `${f(edge / FT)} ft of drip edge (${f(ceil(edge / (10 * FT)))} × 10 ft)`,
                ridge: `${f(ridge / FT)} ft of ridge${hips ? ` and ${f(hips / FT)} ft of hips` : ''}`,
                cost: i.price > 0 ? money(squares * i.price) : 'Enter a price per square',
            },
        };
    },

    /**
     * Gambrel: two slopes each side. "semicircle" puts the four equal rafters on a half circle of the span.
     */
    gambrel: (i, c, f) => {
        if (missing(i, 'span') || !(i.span > 0)) {
            return { empty: 'Enter the span.' };
        }

        let lowerRun;
        let lowerAngle;
        let upperAngle;
        const half = i.span / 2;

        if (i.method === 'semicircle') {
            lowerAngle = 67.5;
            upperAngle = 22.5;
            lowerRun = half - half * Math.cos(45 * RAD);
        } else {
            if (!(i.lower_angle > 0 && i.lower_angle < 90) || !(i.upper_angle > 0 && i.upper_angle < 90) || !(i.lower_run > 0) || i.lower_run >= half) {
                return { empty: 'Enter both angles and a lower run less than half the span.' };
            }

            lowerAngle = i.lower_angle;
            upperAngle = i.upper_angle;
            lowerRun = i.lower_run;
        }

        const upperRun = half - lowerRun;
        const lowerRise = lowerRun * Math.tan(lowerAngle * RAD);
        const upperRise = upperRun * Math.tan(upperAngle * RAD);
        const lower = Math.hypot(lowerRun, lowerRise);
        const upper = Math.hypot(upperRun, upperRise);
        const height = lowerRise + upperRise;
        const section = 2 * ((lowerRun * lowerRise) / 2 + upperRun * lowerRise + (upperRun * upperRise) / 2);

        return {
            value: feetInches(height),
            unit: '',
            label: 'Roof height',
            sub: `Above the wall plates; lower slope ${f(lowerAngle)}°, upper ${f(upperAngle)}°`,
            rows: {
                lower: `${feetInches(lower)} at ${f(lowerAngle)}° (${f(12 * Math.tan(lowerAngle * RAD))}/12)`,
                upper: `${feetInches(upper)} at ${f(upperAngle)}° (${f(12 * Math.tan(upperAngle * RAD))}/12)`,
                break: `${feetInches(lowerRun)} in from each wall, ${feetInches(lowerRise)} up`,
                area: i.length > 0 ? `${f((2 * (lower + upper) * i.length) / FT2)} ft² of roof for ${f(i.length / FT)} ft` : 'Enter a length for the roof area',
                section: `${f(section / FT2)} ft² gable end (above the plates)`,
            },
        };
    },

    /**
     * Truss count and member lengths for king post and Fink (W) trusses, by geometry to member centerlines.
     */
    truss: (i, c, f) => {
        if (missing(i, 'length', 'spacing', 'span', 'pitch') || !(i.length > 0) || !(i.spacing > 0) || !(i.span > 0) || !(i.pitch > 0)) {
            return { empty: 'Enter the building length, truss spacing, span and pitch.' };
        }

        const count = Math.floor(i.length / i.spacing + 1e-9) + 1;
        const S = i.span;
        const H = (S / 2) * (i.pitch / 12);
        const o = i.overhang > 0 ? i.overhang : 0;
        const top = (S / 2 + o) * slopeFactor(i.pitch);
        const members = [['Top chords (2)', top], ['Bottom chord', S]];

        if (i.type === 'king') {
            members.push(['King post', H]);
        } else {
            const web = Math.hypot(S / 3 - S / 4, H / 2);
            const long = Math.hypot(S / 2 - S / 3, H);
            members.push(['Short webs (2)', web], ['Long webs (2)', long]);
        }

        return {
            value: f(count),
            unit: 'trusses',
            label: 'Trusses',
            sub: `${f(i.length / FT)} ft at ${f(i.spacing / IN)} in on center; ${f(H / FT)} ft rise at the peak`,
            rows: { rise: `${feetInches(H)} peak height above the bottom chord`, top: `${feetInches(top)} each top chord with overhang`, gables: '2 of the trusses are gable ends', note: 'Engineered trusses are designed and stamped by the maker' },
            lists: { members: members.map(([name, len]) => ({ label: name, value: `${feetInches(len)} (${f(len)} m)` })) },
        };
    },

    /**
     * Birdsmouth: seat cut s on the plate and plumb cut p = s × tan θ; the notch depth across the rafter is s × sin θ.
     */
    birdsmouth: (i, c, f) => {
        if (missing(i, 'pitch', 'depth', 'seat') || !(i.pitch > 0) || !(i.depth > 0) || !(i.seat > 0)) {
            return { empty: 'Enter the pitch, rafter depth and seat cut length.' };
        }

        const theta = Math.atan(i.pitch / 12);
        const plumb = i.seat * Math.tan(theta);
        const notch = i.seat * Math.sin(theta);
        const heel = i.depth / Math.cos(theta) - plumb;
        const quarter = notch <= i.depth / 4 + 1e-9;
        const third = notch <= i.depth / 3 + 1e-9;

        return {
            value: `${inchFraction(plumb / IN)} in`,
            unit: '',
            label: 'Plumb cut (heel cut) height',
            sub: `Seat ${inchFraction(i.seat / IN)} in at ${f(i.pitch)}/12 (${f(theta / RAD)}°)`,
            rows: {
                notch: `${inchFraction(notch / IN)} in deep, ${f((notch / i.depth) * 100)}% of the rafter`,
                heel: `${inchFraction(heel / IN)} in above the plate`,
                remaining: `${inchFraction((i.depth - notch) / IN)} in of rafter left at the bearing`,
                check: quarter ? 'Within ¼ of the depth (NDS 4.4.3 end-notch limit)' : third ? 'Within the ⅓ carpentry rule but over ¼ (NDS 4.4.3): shorten the seat' : 'Over ⅓ of the depth: shorten the seat cut',
            },
        };
    },

    metal_roof_cost: (i, c, f) => {
        if (missing(i, 'length', 'width', 'pitch', 'coverage') || !(i.length > 0) || !(i.width > 0) || !(i.pitch >= 0) || !(i.coverage > 0)) {
            return { empty: 'Enter the footprint, pitch and panel coverage width.' };
        }

        const o = i.overhang > 0 ? i.overhang : 0;
        const L = i.length + 2 * o;
        const panelLength = (i.width / 2 + o) * slopeFactor(i.pitch);
        const perSide = ceil(L / i.coverage);
        const panels = 2 * perSide;
        const area = 2 * panelLength * L;
        const purlins = i.purlin > 0 ? Math.floor(panelLength / i.purlin + 1e-9) + 1 : 0;
        const screws = purlins && i.screws > 0 ? panels * purlins * i.screws : 0;
        const lines = [
            ['Panels', panels * (panelLength / FT) * (i.price_ft > 0 ? i.price_ft : 0)],
            ['Trim, ridge cap and closures', (i.trim > 0 ? i.trim : 0) * (2 * L + 4 * panelLength) / FT],
            ['Screws', screws * (i.screw_price > 0 ? i.screw_price : 0)],
            ['Underlayment', (area / FT2) * (i.underlay > 0 ? i.underlay : 0)],
            ['Labor', (area / FT2) * (i.labor > 0 ? i.labor : 0)],
        ];
        const total = lines.reduce((sum, [, cost]) => sum + cost, 0);

        return {
            value: money(total),
            unit: '',
            label: 'Metal roof cost',
            sub: `${panels} panels of ${feetInches(panelLength)}, ${f(area / FT2)} ft² of roof, from your prices`,
            rows: {
                panels: `${panels} panels (${perSide} per side) of ${feetInches(panelLength)}`,
                area: `${f(area / FT2)} ft² (${f(area / (100 * FT2))} squares)`,
                screws: screws ? `${f(screws)} screws (${purlins} purlins per panel)` : 'Enter the purlin spacing',
                per_ft2: total ? `${money(total / (area / FT2))} per ft²` : 'Enter prices',
            },
            lists: { lines: lines.filter(([, cost]) => cost > 0).map(([label, cost]) => ({ label, value: money(cost) })) },
        };
    },
};

export default defineTools(handlers);
