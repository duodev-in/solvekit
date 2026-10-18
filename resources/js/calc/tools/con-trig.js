import { FT, IN, RAD, feetInches, radiusFromChordRise, sagitta, segmentArea } from '../construction/geometry.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Angles, offsets, arcs, grades and curves. Lengths arrive in meters.
 */
const len = (m, f) => `${feetInches(m)} (${f(m * 1000)} mm)`;

export const handlers = {
    /**
     * Rolling offset: true offset = √(offset² + roll²); travel = true offset ÷ sin θ; run = true offset ÷ tan θ.
     */
    rolling_offset: (i, c, f) => {
        if (missing(i, 'offset', 'roll', 'angle') || !(i.offset >= 0) || !(i.roll >= 0) || !(i.angle > 0 && i.angle < 90)) {
            return { empty: 'Enter the offset, roll and fitting angle.' };
        }

        const trueOffset = Math.hypot(i.offset, i.roll);

        if (!(trueOffset > 0)) {
            return { empty: 'Enter a non-zero offset or roll.' };
        }

        const theta = i.angle * RAD;
        const travel = trueOffset / Math.sin(theta);
        const run = trueOffset / Math.tan(theta);

        return {
            value: feetInches(travel),
            unit: '',
            label: 'Travel (center to center)',
            sub: `${f(travel / IN)} in through ${f(i.angle)}° fittings`,
            rows: { true: len(trueOffset, f), run: len(run, f), constant: `× ${f(1 / Math.sin(theta))} travel per unit of true offset`, roll_angle: `Rotate the fittings ${f(Math.atan2(i.roll, i.offset) / RAD)}° from vertical` },
        };
    },

    /**
     * Sagitta: s = r − √(r² − (c/2)²); the other two from any pair of radius, chord and sagitta.
     */
    sagitta: (i, c, f) => {
        let r;
        let chord;

        if (i.solve === 'radius') {
            if (!(i.chord > 0) || !(i.sag > 0)) {
                return { empty: 'Enter the chord and the sagitta.' };
            }

            chord = i.chord;
            r = radiusFromChordRise(chord, i.sag);
        } else if (i.solve === 'chord') {
            if (!(i.radius > 0) || !(i.sag > 0) || i.sag > 2 * i.radius) {
                return { empty: 'Enter the radius and a sagitta up to the diameter.' };
            }

            r = i.radius;
            chord = 2 * Math.sqrt(2 * r * i.sag - i.sag ** 2);
        } else {
            if (!(i.radius > 0) || !(i.chord > 0)) {
                return { empty: 'Enter the radius and the chord.' };
            }

            if (i.chord > 2 * i.radius) {
                return { error: 'The chord cannot be longer than the diameter.' };
            }

            r = i.radius;
            chord = i.chord;
        }

        const s = i.solve === 'chord' ? i.sag : sagitta(r, chord).sagitta;
        const angle = 2 * Math.asin(Math.min(chord / (2 * r), 1));
        // A sagitta over the radius means the arc is more than a half circle.
        const major = i.solve !== 'sagitta' && s > r;
        const theta = major ? 2 * Math.PI - angle : angle;
        // Sizes are plain numbers in the unit the viewer picked.
        const scale = 1;
        const unit = i.units ?? 'in';
        const out = { sagitta: s, radius: r, chord }[i.solve];

        return {
            value: f(out / scale),
            unit,
            label: { sagitta: 'Sagitta', radius: 'Radius', chord: 'Chord' }[i.solve],
            sub: `s = r − √(r² − (c ÷ 2)²)`,
            rows: {
                sagitta: `${f(s / scale)} ${unit}`,
                radius: `${f(r / scale)} ${unit} (diameter ${f((2 * r) / scale)})`,
                chord: `${f(chord / scale)} ${unit}`,
                arc: `${f((r * theta) / scale)} ${unit} over ${f(theta / RAD)}°`,
                area: `${f(segmentArea(r, s) / scale ** 2)} ${unit}² segment`,
            },
        };
    },

    arch: (i, c, f) => {
        let r;
        let rise;

        if (i.mode === 'radius') {
            if (!(i.span > 0) || !(i.radius > 0) || i.span > 2 * i.radius) {
                return { empty: 'Enter the span and a radius at least half the span.' };
            }

            r = i.radius;
            rise = r - Math.sqrt(r * r - (i.span / 2) ** 2);
        } else {
            if (!(i.span > 0) || !(i.rise > 0) || i.rise > i.span / 2) {
                return { empty: 'Enter the span and a rise up to half the span.' };
            }

            rise = i.rise;
            r = radiusFromChordRise(i.span, rise);
        }

        const angle = 2 * Math.asin(i.span / (2 * r));
        const arc = r * angle;

        return {
            value: feetInches(r),
            unit: '',
            label: 'Arch radius',
            sub: `${f(r / IN)} in radius for a ${f(i.span / IN)} in span and ${f(rise / IN)} in rise`,
            rows: { arc: len(arc, f), rise: len(rise, f), angle: `${f(angle / RAD)}°`, area: `${f(segmentArea(r, rise) / IN ** 2)} in² (${f(segmentArea(r, rise) / FT ** 2)} ft²) under the arch`, center: `${feetInches(r - rise)} below the springing line` },
        };
    },

    /**
     * Polygon frames (miter = 180° ÷ sides) and crown molding laid flat:
     * miter = atan(sin S ÷ tan(A/2)), bevel = asin(cos S × cos(A/2)).
     */
    angle_cut: (i, c, f) => {
        if (i.mode === 'crown') {
            if (missing(i, 'spring', 'corner') || !(i.spring > 0 && i.spring < 90) || !(i.corner > 0 && i.corner < 180)) {
                return { empty: 'Enter the spring angle and the wall corner angle.' };
            }

            const s = i.spring * RAD;
            const half = (i.corner / 2) * RAD;
            const miter = Math.atan(Math.sin(s) / Math.tan(half)) / RAD;
            const bevel = Math.asin(Math.cos(s) * Math.cos(half)) / RAD;

            return {
                value: f(miter),
                unit: '° miter',
                label: 'Saw settings (crown laid flat)',
                sub: `Bevel ${f(bevel)}° for ${f(i.spring)}° crown in a ${f(i.corner)}° corner`,
                rows: { miter: `${f(miter)}°`, bevel: `${f(bevel)}°`, nested: `Or nested upside down at ${f(i.spring)}° spring: miter ${f(90 - i.corner / 2)}°, no bevel` },
            };
        }

        if (missing(i, 'sides') || !(i.sides >= 3)) {
            return { empty: 'Enter the number of sides (3 or more).' };
        }

        const n = Math.round(i.sides);
        const miter = 180 / n;

        return {
            value: f(miter),
            unit: '°',
            label: 'Miter angle',
            sub: `${n} sides: each joint is ${f(360 / n)}° of the turn, split between two pieces`,
            rows: { miter: `${f(miter)}° on the saw scale`, interior: `${f((180 * (n - 2)) / n)}° interior corner`, from_edge: `${f(90 - miter)}° measured from the edge of the board` },
        };
    },

    angle_of_depression: (i, c, f) => {
        let angle;
        let height;
        let distance;

        if (i.mode === 'angle') {
            if (!(i.height > 0) || !(i.distance > 0)) {
                return { empty: 'Enter the height and horizontal distance.' };
            }

            height = i.height;
            distance = i.distance;
            angle = Math.atan2(height, distance) / RAD;
        } else {
            if (!(i.angle > 0 && i.angle < 90) || !(i.height > 0)) {
                return { empty: 'Enter the angle and the height.' };
            }

            angle = i.angle;
            height = i.height;
            distance = height / Math.tan(angle * RAD);
        }

        return {
            value: i.mode === 'angle' ? f(angle) : feetInches(distance),
            unit: i.mode === 'angle' ? '°' : '',
            label: i.mode === 'angle' ? 'Angle of depression' : 'Horizontal distance',
            sub: `tan θ = height ÷ horizontal distance`,
            rows: { angle: `${f(angle)}° below horizontal`, height: len(height, f), distance: len(distance, f), sight: `${len(Math.hypot(height, distance), f)} line of sight` },
        };
    },

    bowl_segment: (i, c, f) => {
        if (missing(i, 'segments', 'diameter', 'ring') || !(i.segments >= 3) || !(i.diameter > 0) || !(i.ring > 0) || 2 * i.ring >= i.diameter) {
            return { empty: 'Enter the segments, the outside diameter and a ring width less than the radius.' };
        }

        const n = Math.round(i.segments);
        const t = Math.tan(Math.PI / n);
        const outer = i.diameter * t;
        const inner = (i.diameter - 2 * i.ring) * t;
        const kerf = i.kerf > 0 ? i.kerf : 0;
        const board = n * ((outer + inner) / 2 + kerf);

        return {
            value: f(180 / n),
            unit: '°',
            label: 'Miter angle',
            sub: `${n} segments; each is ${f(360 / n)}° of the ring`,
            rows: { outer: len(outer, f) + ' outside length', inner: len(inner, f) + ' inside length', board: `${len(board, f)} of board ${f(i.ring / IN)} in wide, alternating the cuts`, polygon: 'Lengths are for a polygon that just contains the outside circle' },
        };
    },

    elevation_grade: (i, c, f) => {
        let rise;
        let run;

        if (i.mode === 'elevations') {
            if (missing(i, 'start', 'end', 'distance') || !(i.distance > 0)) {
                return { empty: 'Enter both elevations and the horizontal distance.' };
            }

            rise = i.end - i.start;
            run = i.distance;
        } else {
            if (missing(i, 'rise', 'run') || !(i.run > 0)) {
                return { empty: 'Enter the rise and run.' };
            }

            rise = i.rise;
            run = i.run;
        }

        const grade = (rise / run) * 100;

        return {
            value: f(grade),
            unit: '%',
            label: 'Grade',
            sub: `${f(Math.atan(rise / run) / RAD)}°; ${rise === 0 ? 'level' : `1 in ${f(Math.abs(run / rise))}`}`,
            rows: { angle: `${f(Math.atan(rise / run) / RAD)}°`, ratio: rise === 0 ? 'Level' : `1 : ${f(Math.abs(run / rise))} (${rise > 0 ? 'up' : 'down'})`, per_ft: `${f((rise / run) * 12)} in per ft (${f((rise / run) * 1000)} mm per m)`, slope_length: len(Math.hypot(rise, run), f) },
        };
    },

    miter: (i, c, f) => {
        if (i.mode === 'sides') {
            if (!(i.sides >= 3)) {
                return { empty: 'Enter the number of sides.' };
            }

            const n = Math.round(i.sides);

            return { value: f(180 / n), unit: '°', label: 'Miter angle', sub: `${n}-sided frame`, rows: { corner: `${f((180 * (n - 2)) / n)}° corner`, saw: `${f(180 / n)}° on the miter saw`, edge: `${f(90 - 180 / n)}° from the board edge` } };
        }

        if (!(i.corner > 0 && i.corner < 360)) {
            return { empty: 'Enter the corner angle.' };
        }

        const miter = Math.abs(180 - i.corner) / 2;

        return {
            value: f(miter),
            unit: '°',
            label: 'Miter angle',
            sub: `Each piece of a ${f(i.corner)}° corner`,
            rows: { corner: `${f(i.corner)}° corner (${i.corner > 180 ? 'outside' : 'inside'})`, saw: `${f(miter)}° on the miter saw`, edge: `${f(90 - miter)}° from the board edge` },
        };
    },

    /**
     * Symmetrical parabolic vertical curve (AASHTO): y = BVC + g₁x + (g₂ − g₁) x² ÷ (2L).
     */
    vertical_curve: (i, c, f) => {
        if (missing(i, 'g1', 'g2', 'length', 'pvi_station', 'pvi_elevation') || !(i.length > 0)) {
            return { empty: 'Enter both grades, the curve length and the PVI station and elevation.' };
        }

        const g1 = i.g1 / 100;
        const g2 = i.g2 / 100;
        const L = i.length;
        const bvc = i.pvi_station - L / 2;
        const bvcElevation = i.pvi_elevation - (g1 * L) / 2;
        const at = (x) => bvcElevation + g1 * x + ((g2 - g1) * x * x) / (2 * L);
        const turn = g2 !== g1 ? (-g1 * L) / (g2 - g1) : null;
        const hasTurn = turn !== null && turn >= 0 && turn <= L;
        const step = i.interval > 0 ? i.interval : L / 10;
        const xs = [];

        for (let s = Math.ceil(bvc / step - 1e-9) * step; s <= bvc + L + 1e-9; s += step) {
            xs.push(s);
        }

        if (!xs.length || xs[0] > bvc + 1e-9) {
            xs.unshift(bvc);
        }

        if (xs[xs.length - 1] < bvc + L - 1e-9) {
            xs.push(bvc + L);
        }

        const station = (s) => {
            const whole = Math.floor(s / 100 + 1e-9);

            return `${whole}+${String(f(Math.round((s - whole * 100) * 100) / 100)).padStart(2, '0')}`;
        };

        return {
            value: hasTurn ? f(at(turn)) : f(at(L)),
            unit: i.units === 'm' ? 'm' : 'ft',
            label: hasTurn ? (g2 > g1 ? 'Low point elevation' : 'High point elevation') : 'EVC elevation',
            sub: hasTurn ? `At station ${station(bvc + turn)}` : `Grades ${f(i.g1)}% to ${f(i.g2)}% over ${f(L)}`,
            rows: {
                bvc: `Station ${station(bvc)}, elevation ${f(bvcElevation)}`,
                evc: `Station ${station(bvc + L)}, elevation ${f(at(L))}`,
                turn: hasTurn ? `Station ${station(bvc + turn)}, elevation ${f(at(turn))}` : 'Not on this curve',
                k: `K = ${f(L / Math.abs(i.g2 - i.g1))} per 1% of grade change`,
            },
            lists: { stations: xs.map((s) => ({ label: `Station ${station(s)}`, value: f(at(s - bvc)) })) },
        };
    },
};

export default defineTools(handlers);
