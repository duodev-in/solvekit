import { FT, IN, LBF, PSI, RAD, inchFraction } from '../construction/geometry.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Beams, fasteners, machining and welding. Lengths arrive in meters, forces in newtons, torques in N·m,
 * stresses in pascals.
 */
const ksi = (pa) => pa / PSI / 1000;
const MPA = 1e6;

/**
 * Second moment of area I (m⁴) and extreme fiber distance c (m) of a section about its strong axis.
 */
export function section(type, i) {
    switch (type) {
        case 'rectangle':
            return i.b > 0 && i.h > 0 ? { I: (i.b * i.h ** 3) / 12, c: i.h / 2, A: i.b * i.h } : null;
        case 'round':
            return i.d > 0 ? { I: (Math.PI * i.d ** 4) / 64, c: i.d / 2, A: (Math.PI * i.d ** 2) / 4 } : null;
        case 'tube': {
            if (!(i.d > 0) || !(i.t > 0) || 2 * i.t >= i.d) {
                return null;
            }

            const di = i.d - 2 * i.t;

            return { I: (Math.PI * (i.d ** 4 - di ** 4)) / 64, c: i.d / 2, A: (Math.PI * (i.d ** 2 - di ** 2)) / 4 };
        }
        case 'rect_tube': {
            if (!(i.b > 0) || !(i.h > 0) || !(i.t > 0) || 2 * i.t >= Math.min(i.b, i.h)) {
                return null;
            }

            return { I: (i.b * i.h ** 3 - (i.b - 2 * i.t) * (i.h - 2 * i.t) ** 3) / 12, c: i.h / 2, A: i.b * i.h - (i.b - 2 * i.t) * (i.h - 2 * i.t) };
        }
        case 'i_beam': {
            if (!(i.b > 0) || !(i.h > 0) || !(i.tf > 0) || !(i.tw > 0) || 2 * i.tf >= i.h || i.tw >= i.b) {
                return null;
            }

            const web = i.h - 2 * i.tf;

            return { I: (i.b * i.h ** 3 - (i.b - i.tw) * web ** 3) / 12, c: i.h / 2, A: 2 * i.b * i.tf + web * i.tw };
        }
        case 'custom':
            return i.inertia > 0 && i.depth > 0 ? { I: i.inertia, c: i.depth / 2, A: null } : null;
        default:
            return null;
    }
}

/**
 * Elastic modulus (Pa) of the chosen material: steel 29,000 ksi (AISC), aluminum 10,000 ksi (6061, Aluminum
 * Association), wood species from the Wood Handbook (MPa at 12% moisture), or the viewer's value.
 */
function modulus(i, c) {
    if (i.material === 'custom') {
        return i.e > 0 ? i.e * 1e9 : null;
    }

    if (i.material === 'steel') {
        return 29000 * 1000 * PSI;
    }

    if (i.material === 'aluminum') {
        return 10000 * 1000 * PSI;
    }

    const wood = c.data.wood?.[i.material.replace('wood:', '')];

    return wood ? wood.e_12 * MPA : null;
}

/**
 * Deflection along a beam for the standard cases (Roark): x from the left support or the fixed end.
 */
export function deflectionAt(loadCase, x, L, E, I, P, w) {
    switch (loadCase) {
        case 'ss_point':
            return x <= L / 2 ? (P * x * (3 * L * L - 4 * x * x)) / (48 * E * I) : deflectionAt(loadCase, L - x, L, E, I, P, w);
        case 'ss_uniform':
            return (w * x * (L ** 3 - 2 * L * x * x + x ** 3)) / (24 * E * I);
        case 'cant_point':
            return (P * x * x * (3 * L - x)) / (6 * E * I);
        case 'cant_uniform':
            return (w * x * x * (6 * L * L - 4 * L * x + x * x)) / (24 * E * I);
        default:
            return NaN;
    }
}

const MAX = {
    ss_point: (L, P) => ({ x: L / 2, moment: (P * L) / 4, shear: P / 2 }),
    ss_uniform: (L, P, w) => ({ x: L / 2, moment: (w * L * L) / 8, shear: (w * L) / 2 }),
    cant_point: (L, P) => ({ x: L, moment: P * L, shear: P }),
    cant_uniform: (L, P, w) => ({ x: L, moment: (w * L * L) / 2, shear: w * L }),
};

function sectionInputs(i) {
    return { b: i.b, h: i.h, d: i.d, t: i.t, tf: i.tf, tw: i.tw, inertia: i.inertia ? i.inertia * IN ** 4 : NaN, depth: i.depth };
}

/**
 * Tensile stress area (m²): ASME B1.1 0.7854 (d − 0.9743/n)² for inch threads, ISO 898-1 π/4 (d − 0.9382 P)² for metric.
 */
export function stressArea(system, major, pitch) {
    return system === 'inch' ? 0.7854 * (major - 0.9743 * pitch) ** 2 : (Math.PI / 4) * (major - 0.9382 * pitch) ** 2;
}

function threadOf(i, c) {
    if (i.system === 'metric') {
        const t = c.data.threads_metric[i.metric];

        if (!t) {
            return null;
        }

        const pitch = i.series === 'fine' ? t.fine : t.coarse;

        return { name: `M${t.major} × ${pitch}`, major: t.major / 1000, pitch: pitch / 1000, tpi: 25.4 / pitch, data: t };
    }

    const t = c.data.threads_inch[i.inch];

    if (!t) {
        return null;
    }

    const tpi = i.series === 'fine' ? t.unf : t.unc;

    if (!tpi) {
        return { error: `${i.inch} is not made in the ${i.series === 'fine' ? 'UNF' : 'UNC'} series.` };
    }

    return { name: `${i.inch}-${tpi} ${i.series === 'fine' ? 'UNF' : 'UNC'}`, major: t.major * IN, pitch: IN / tpi, tpi, data: t };
}

export const handlers = {
    beam_deflection: (i, c, f) => {
        if (missing(i, 'span') || !(i.span > 0)) {
            return { empty: 'Enter the span.' };
        }

        const s = section(i.section, sectionInputs(i));

        if (!s) {
            return { empty: 'Enter every size of the section.' };
        }

        const E = modulus(i, c);

        if (!E) {
            return { empty: 'Choose a material or enter its modulus.' };
        }

        const point = i.load_case.endsWith('point');
        const P = point ? i.point : 0;
        const w = point ? 0 : (i.uniform > 0 ? i.uniform * (i.w_units === 'knm' ? 1000 : LBF / FT) : NaN);

        if (point ? !(P > 0) : !(w > 0)) {
            return { empty: `Enter the ${point ? 'point load' : 'uniform load'}.` };
        }

        const L = i.span;
        const max = MAX[i.load_case](L, P, w);
        const delta = deflectionAt(i.load_case, max.x, L, E, s.I, P, w);
        const stress = (max.moment * s.c) / s.I;
        const limit = Number(i.limit) || 360;
        const ratio = L / delta;

        return {
            value: f(delta / IN),
            unit: 'in',
            label: 'Maximum deflection',
            sub: `${f(delta * 1000)} mm; L/${f(Math.round(ratio))}`,
            rows: {
                ratio: `L/${f(Math.round(ratio))} (${ratio >= limit ? 'within' : 'over'} the L/${limit} limit)`,
                moment: `${f(max.moment / (LBF * FT))} lb·ft (${f(max.moment / 1000)} kN·m)`,
                stress: `${f(ksi(stress))} ksi (${f(stress / MPA)} MPa)`,
                shear: `${f(max.shear / LBF)} lb (${f(max.shear / 1000)} kN)`,
                section: `I = ${f(s.I / IN ** 4)} in⁴, S = ${f(s.I / s.c / IN ** 3)} in³; E = ${f(ksi(E))} ksi`,
            },
            plots: { curve: { series: Array.from({ length: 51 }, (_, k) => [(L * k) / 50 / FT, -deflectionAt(i.load_case, (L * k) / 50, L, E, s.I, P, w) / IN]), xLabel: 'Position (ft)', yLabel: 'Deflection (in)' } },
        };
    },

    bending_stress: (i, c, f) => {
        if (missing(i, 'moment') || !(i.moment > 0)) {
            return { empty: 'Enter the bending moment.' };
        }

        const s = section(i.section, sectionInputs(i));

        if (!s) {
            return { empty: 'Enter every size of the section.' };
        }

        const stress = (i.moment * s.c) / s.I;
        const yieldStress = i.yield > 0 ? i.yield : null;

        return {
            value: f(stress / PSI),
            unit: 'psi',
            label: 'Bending stress',
            sub: `σ = M c ÷ I = ${f(stress / MPA)} MPa`,
            rows: {
                mpa: `${f(stress / MPA)} MPa (${f(ksi(stress))} ksi)`,
                modulus: `S = ${f(s.I / s.c / IN ** 3)} in³ (${f((s.I / s.c) * 1e9)} mm³)`,
                inertia: `I = ${f(s.I / IN ** 4)} in⁴ (${f(s.I * 1e12)} mm⁴), c = ${f(s.c / IN)} in`,
                factor: yieldStress ? `${f(yieldStress / stress)} against yield (${f(yieldStress / PSI)} psi)` : 'Enter a yield strength',
            },
        };
    },

    bolt_torque: (i, c, f) => {
        const t = threadOf(i, c);

        if (!t || t.error) {
            return t ?? { error: 'Choose a thread.' };
        }

        if (missing(i, 'percent', 'nut_factor') || !(i.percent > 0) || !(i.nut_factor > 0)) {
            return { empty: 'Enter the preload percentage and the nut factor.' };
        }

        const area = stressArea(i.system, t.major, t.pitch);
        let proof;

        if (i.system === 'metric') {
            const cls = c.data.bolt_grades.iso[i.iso_class];
            proof = (t.major > 0.016 && cls.proof_large ? cls.proof_large : cls.proof) * MPA;
        } else {
            const grade = Object.values(c.data.bolt_grades.sae).find((g) => g.name.startsWith(`SAE grade ${i.sae_grade}`) && t.major / IN >= g.min - 1e-9 && t.major / IN <= g.max + 1e-9);

            if (!grade) {
                return { error: `SAE grade ${i.sae_grade} is not specified for a ${f(t.major / IN)} in bolt.` };
            }

            proof = grade.proof * PSI;
        }

        const preload = area * proof * (i.percent / 100);
        const torque = i.nut_factor * t.major * preload;

        return {
            value: f(torque / (LBF * FT)),
            unit: 'lb·ft',
            label: 'Tightening torque',
            sub: `${t.name}: T = K × D × F = ${f(torque)} N·m`,
            rows: {
                nm: `${f(torque)} N·m (${f(torque / (LBF * IN))} lb·in)`,
                preload: `${f(preload / LBF)} lbf (${f(preload / 1000)} kN) clamp load`,
                proof: `${f(proof / PSI)} psi proof stress × ${f(area / IN ** 2)} in² = ${f((area * proof) / LBF)} lbf proof load`,
                area: `${f(area / IN ** 2)} in² (${f(area * 1e6)} mm²) tensile stress area`,
            },
        };
    },

    carbon_equivalent: (i, c, f) => {
        const v = (name) => (i[name] > 0 ? i[name] : 0);

        if (!(i.c > 0)) {
            return { empty: 'Enter the carbon content and the other elements you know.' };
        }

        const ce = v('c') + v('mn') / 6 + (v('cr') + v('mo') + v('v')) / 5 + (v('ni') + v('cu')) / 15;
        const pcm = v('c') + v('si') / 30 + (v('mn') + v('cu') + v('cr')) / 20 + v('ni') / 60 + v('mo') / 15 + v('v') / 10 + 5 * v('b');
        const guide = ce <= 0.35 ? 'Good weldability; preheat usually not needed' : ce <= 0.45 ? 'Preheat may be needed for thick sections' : ce <= 0.55 ? 'Preheat needed; consider low-hydrogen electrodes' : 'High hardenability: preheat, low-hydrogen practice and possibly post-weld heat treatment';

        return {
            value: f(Math.round(ce * 1000) / 1000),
            unit: 'CE (IIW)',
            label: 'Carbon equivalent',
            sub: guide,
            rows: { pcm: `${f(Math.round(pcm * 1000) / 1000)} (Ito–Bessyo)`, guide, iiw: 'CE = C + Mn/6 + (Cr + Mo + V)/5 + (Ni + Cu)/15' },
        };
    },

    k_factor: (i, c, f) => {
        if (missing(i, 'thickness', 'radius', 'angle') || !(i.thickness > 0) || !(i.radius >= 0) || !(i.angle > 0 && i.angle < 180)) {
            return { empty: 'Enter the thickness, inside radius and bend angle.' };
        }

        const theta = i.angle * RAD;
        const ossb = Math.tan(theta / 2) * (i.radius + i.thickness);
        let k;

        if (i.mode === 'measure') {
            if (!(i.leg_a > 0) || !(i.leg_b > 0) || !(i.flat > 0)) {
                return { empty: 'Enter both outside flange lengths and the measured flat length.' };
            }

            const bd = i.leg_a + i.leg_b - i.flat;
            const ba = 2 * ossb - bd;
            k = (ba / theta - i.radius) / i.thickness;
        } else {
            k = i.k;
        }

        if (!(k >= 0)) {
            return { error: 'These measurements give a negative K-factor; check them.' };
        }

        const ba = theta * (i.radius + k * i.thickness);
        const bd = 2 * ossb - ba;

        return {
            value: f(Math.round(k * 10000) / 10000),
            unit: 'K',
            label: 'K-factor',
            sub: `Neutral axis ${f(k * 100)}% of the thickness in from the inside`,
            rows: {
                ba: `${f(ba / IN)} in (${f(ba * 1000)} mm) bend allowance`,
                bd: `${f(bd / IN)} in (${f(bd * 1000)} mm) bend deduction`,
                ossb: `${f(ossb / IN)} in (${f(ossb * 1000)} mm) outside setback`,
                flat: i.leg_a > 0 && i.leg_b > 0 ? `${f((i.leg_a + i.leg_b - bd) / IN)} in flat for these flanges` : 'Enter flange lengths for the flat length',
            },
        };
    },

    mrr: (i, c, f) => {
        let mrr;
        let sub;

        if (i.process === 'turning') {
            if (!(i.speed > 0) || !(i.feed > 0) || !(i.doc > 0)) {
                return { empty: 'Enter the cutting speed, feed per revolution and depth of cut.' };
            }

            const surface = i.speed_unit === 'mmin' ? i.speed / 60 : (i.speed * FT) / 60;
            mrr = surface * i.feed * i.doc;
            sub = 'MRR = cutting speed × feed × depth of cut';
        } else if (i.process === 'drilling') {
            if (!(i.diameter > 0) || !(i.feed > 0) || !(i.rpm > 0)) {
                return { empty: 'Enter the drill diameter, feed per revolution and RPM.' };
            }

            mrr = (Math.PI / 4) * i.diameter ** 2 * i.feed * (i.rpm / 60);
            sub = 'MRR = π ÷ 4 × D² × feed × RPM';
        } else {
            if (!(i.width > 0) || !(i.doc > 0) || !(i.table > 0)) {
                return { empty: 'Enter the width and depth of cut and the table feed.' };
            }

            mrr = i.width * i.doc * (i.table_unit === 'mmmin' ? i.table / 1000 / 60 : (i.table * IN) / 60);
            sub = 'MRR = width × depth × table feed';
        }

        // mrr in m³/s
        const in3min = (mrr / IN ** 3) * 60;
        const power = i.unit_power > 0 ? in3min * i.unit_power : null;

        return {
            value: f(in3min),
            unit: 'in³/min',
            label: 'Material removal rate',
            sub,
            rows: { cm3: `${f(mrr * 1e6 * 60)} cm³/min`, mm3: `${f(mrr * 1e9)} mm³/s`, power: power === null ? 'Enter a unit power' : `${f(power)} hp at the cutter (${f(power * 0.7457)} kW)` },
        };
    },

    pitch_diameter: (i, c, f) => {
        if (i.mode === 'gear') {
            if (!(i.teeth >= 1)) {
                return { empty: 'Enter the number of teeth and the module or diametral pitch.' };
            }

            const module = i.gear_system === 'dp' ? (i.dp > 0 ? 25.4 / i.dp : NaN) : i.module;

            if (!(module > 0)) {
                return { empty: 'Enter the module or diametral pitch.' };
            }

            const d = (module * i.teeth) / 1000;

            return {
                value: f(d * 1000),
                unit: 'mm',
                label: 'Pitch diameter',
                sub: `d = m × z = ${f(module)} × ${f(i.teeth)}; ${f(d / IN)} in`,
                rows: { outside: `${f((d + (2 * module) / 1000) * 1000)} mm (${f((d + (2 * module) / 1000) / IN)} in) outside diameter`, root: `${f((d - (2.5 * module) / 1000) * 1000)} mm root diameter (full-depth teeth)`, circular: `${f(Math.PI * module)} mm circular pitch`, inches: `${f(d / IN)} in` },
            };
        }

        if (!(i.major > 0) || !(i.pitch > 0)) {
            return { empty: 'Enter the major diameter and the pitch.' };
        }

        const pitch = i.pitch_kind === 'tpi' ? IN / i.pitch : i.pitch / 1000;
        const d2 = i.major - 0.649519 * pitch;
        const wire = 0.57735 * pitch;
        const over = d2 + 3 * wire - 0.866025 * pitch;

        return {
            value: f(d2 / IN),
            unit: 'in',
            label: 'Pitch diameter (basic)',
            sub: `d₂ = d − 0.649519 P = ${f(d2 * 1000)} mm`,
            rows: {
                mm: `${f(d2 * 1000)} mm`,
                minor: `${f((i.major - 1.082532 * pitch) / IN)} in (${f((i.major - 1.082532 * pitch) * 1000)} mm) basic minor diameter`,
                wire: `${f(wire / IN)} in (${f(wire * 1000)} mm) best wire size`,
                over: `${f(over / IN)} in (${f(over * 1000)} mm) over three wires`,
            },
        };
    },

    punch_force: (i, c, f) => {
        let perimeter;

        if (i.hole === 'round') {
            perimeter = i.diameter > 0 ? Math.PI * i.diameter : NaN;
        } else if (i.hole === 'rect') {
            perimeter = i.length > 0 && i.width > 0 ? 2 * (i.length + i.width) : NaN;
        } else {
            perimeter = i.perimeter;
        }

        if (!(perimeter > 0) || !(i.thickness > 0)) {
            return { empty: 'Enter the hole size and the sheet thickness.' };
        }

        const shear = i.material === 'custom' ? i.shear : c.data.shear[i.material]?.psi * PSI;

        if (!(shear > 0)) {
            return { empty: 'Enter the shear strength.' };
        }

        const force = perimeter * i.thickness * shear;

        return {
            value: f(force / LBF / 2000),
            unit: 'US tons',
            label: 'Punch force',
            sub: `${f(perimeter / IN)} in perimeter × ${f(i.thickness / IN)} in × ${f(shear / PSI)} psi`,
            rows: { kn: `${f(force / 1000)} kN`, metric: `${f(force / 9806.65)} metric tons-force`, lbf: `${f(force / LBF)} lbf`, stripping: `${f((force * 0.1) / LBF / 2000)}–${f((force * 0.2) / LBF / 2000)} tons to strip (10–20%, a press-shop rule)` },
        };
    },

    /**
     * Solid rivet layout by FAA AC 43.13-1B practice: diameter about 3 × the thicker sheet, length = grip + 1.5 D,
     * edge distance at least 2 D, pitch at least 3 D.
     */
    rivet: (i, c, f) => {
        if (missing(i, 'thick', 'grip') || !(i.thick > 0) || !(i.grip > 0)) {
            return { empty: 'Enter the thicker sheet and the total grip.' };
        }

        const ideal = 3 * i.thick;
        const sizes = [3 / 32, 1 / 8, 5 / 32, 3 / 16, 1 / 4, 5 / 16, 3 / 8].map((s) => s * IN);
        const d = sizes.find((s) => s >= ideal - 1e-9) ?? sizes[sizes.length - 1];
        const length = i.grip + 1.5 * d;
        const lengths = Array.from({ length: 40 }, (_, k) => ((k + 2) * IN) / 16);
        const stock = lengths.find((l) => l >= length - 1e-9);

        return {
            value: `${inchFraction(d / IN)} in`,
            unit: '',
            label: 'Rivet diameter',
            sub: `3 × ${f(i.thick / IN)} in = ${f(ideal / IN)} in, rounded up to a standard size (a convention, not a strength check)`,
            rows: {
                length: `${f(length / IN)} in (grip + 1.5 D); next 1/16 in length ${stock ? `${inchFraction(stock / IN)} in` : 'over 2½ in'}`,
                edge: `${f((2 * d) / IN)} in minimum edge distance (2 D)`,
                pitch: `${f((3 * d) / IN)}–${f((4 * d) / IN)} in rivet pitch (3–4 D)`,
                mm: `${f(d * 1000)} mm diameter`,
            },
        };
    },

    spindle_speed: (i, c, f) => {
        if (missing(i, 'speed', 'diameter') || !(i.speed > 0) || !(i.diameter > 0)) {
            return { empty: 'Enter the cutting speed and the tool or work diameter.' };
        }

        const surface = i.speed_unit === 'mmin' ? i.speed / 60 : (i.speed * FT) / 60; // m/s
        const rpm = (surface * 60) / (Math.PI * i.diameter);
        const feed = i.teeth > 0 && i.chip > 0 ? rpm * i.teeth * i.chip : null;

        return {
            value: f(Math.round(rpm)),
            unit: 'RPM',
            label: 'Spindle speed',
            sub: `RPM = cutting speed ÷ (π × D) = ${f((surface * 60) / FT)} SFM on a ${f(i.diameter / IN)} in diameter`,
            rows: {
                feed: feed === null ? 'Enter teeth and chip load for the feed' : `${f(feed / IN)} in/min (${f(feed * 1000)} mm/min)`,
                sfm: `${f((surface * 60) / FT)} SFM (${f(surface * 60)} m/min)`,
                exact: `${f(rpm)} RPM`,
            },
        };
    },

    taper: (i, c, f) => {
        if (missing(i, 'large', 'small', 'length') || !(i.large > 0) || !(i.small >= 0) || !(i.length > 0)) {
            return { empty: 'Enter both diameters and the length.' };
        }

        if (i.small > i.large) {
            return { error: 'The small diameter is larger than the large diameter.' };
        }

        const perUnit = (i.large - i.small) / i.length;
        const half = Math.atan((i.large - i.small) / (2 * i.length)) / RAD;

        return {
            value: f(perUnit * 12),
            unit: 'in/ft',
            label: 'Taper per foot',
            sub: `${f(perUnit)} per inch on the diameter; ${f(2 * half)}° included`,
            rows: { per_inch: `${f(perUnit)} in/in (${f(perUnit)} mm/mm)`, included: `${f(2 * half)}°`, compound: `${f(half)}° (set the compound to half the included angle)`, ratio: perUnit > 0 ? `1 : ${f(1 / perUnit)}` : 'Parallel' },
        };
    },

    thread: (i, c, f) => {
        const t = threadOf(i, c);

        if (!t || t.error) {
            return t ?? { error: 'Choose a thread.' };
        }

        const P = t.pitch;
        const d = t.major;
        const area = stressArea(i.system, d, P);
        const tap = i.system === 'metric' ? `${f((d - P) * 1000)} mm (D − P)` : t.data.tap_drill ? `${t.data.tap_drill.drill} (${f(t.data.tap_drill.diameter)} in)` : 'Not listed';

        return {
            value: t.name,
            unit: '',
            label: 'Thread',
            sub: `${f(t.tpi)} threads per inch, pitch ${f(P * 1000)} mm`,
            rows: {
                major: `${f(d / IN)} in (${f(d * 1000)} mm)`,
                pitch_d: `${f((d - 0.649519 * P) / IN)} in (${f((d - 0.649519 * P) * 1000)} mm)`,
                minor: `${f((d - 1.082532 * P) / IN)} in (${f((d - 1.082532 * P) * 1000)} mm)`,
                height: `${f((0.866025 * P) / IN)} in fundamental triangle height H`,
                tap,
                area: `${f(area / IN ** 2)} in² (${f(area * 1e6)} mm²)`,
            },
        };
    },

    thread_pitch: (i, c, f) => {
        let pitchMm;

        if (i.mode === 'tpi') {
            if (!(i.tpi > 0)) {
                return { empty: 'Enter the threads per inch.' };
            }

            pitchMm = 25.4 / i.tpi;
        } else {
            if (!(i.pitch > 0)) {
                return { empty: 'Enter the pitch in millimeters.' };
            }

            pitchMm = i.pitch;
        }

        const tpi = 25.4 / pitchMm;
        const near = [];

        Object.entries(c.data.threads_inch).forEach(([name, t]) => {
            [['UNC', t.unc], ['UNF', t.unf]].forEach(([series, n]) => {
                if (n && Math.abs(25.4 / n - pitchMm) / pitchMm < 0.03) {
                    near.push({ label: `${name}-${n} ${series}`, value: `${f(25.4 / n)} mm pitch` });
                }
            });
        });
        Object.entries(c.data.threads_metric).forEach(([name, t]) => {
            [['coarse', t.coarse], ['fine', t.fine]].forEach(([series, p]) => {
                if (Math.abs(p - pitchMm) / pitchMm < 0.03) {
                    near.push({ label: `${name} × ${p} (${series})`, value: `${f(25.4 / p)} TPI` });
                }
            });
        });

        return {
            value: i.mode === 'tpi' ? f(pitchMm) : f(tpi),
            unit: i.mode === 'tpi' ? 'mm pitch' : 'TPI',
            label: i.mode === 'tpi' ? 'Pitch' : 'Threads per inch',
            sub: `P = 25.4 ÷ TPI`,
            rows: { pitch_in: `${f(pitchMm / 25.4)} in per thread`, pitch_mm: `${f(pitchMm)} mm`, tpi: `${f(tpi)} TPI` },
            lists: { near: near.length ? near : [{ label: 'Standard threads', value: 'None within 3%' }] },
        };
    },

    true_position: (i, c, f) => {
        if (missing(i, 'dx', 'dy', 'tolerance') || !(i.tolerance > 0)) {
            return { empty: 'Enter the X and Y deviations and the position tolerance.' };
        }

        const unit = i.units === 'mm' ? 'mm' : 'in';
        const position = 2 * Math.hypot(i.dx, i.dy);
        const bonus = i.mmc === 'yes' && i.actual > 0 && i.mmc_size > 0 ? Math.abs(i.actual - i.mmc_size) : 0;
        const allowed = i.tolerance + bonus;
        const pass = position <= allowed + 1e-12;

        return {
            value: f(position),
            unit,
            label: 'True position',
            sub: `${pass ? 'Pass' : 'Fail'}: ⌀${f(position)} against ⌀${f(allowed)} ${unit} allowed (ASME Y14.5)`,
            rows: {
                allowed: `⌀${f(allowed)} ${unit}${bonus ? ` (${f(i.tolerance)} + ${f(bonus)} bonus at MMC)` : ''}`,
                radial: `${f(Math.hypot(i.dx, i.dy))} ${unit} from the true position`,
                result: pass ? 'Pass' : 'Fail',
                used: `${f((position / allowed) * 100)}% of the tolerance used`,
            },
        };
    },

    /**
     * Fillet weld: throat = 0.707 × leg; AWS D1.1 allowable shear on the throat = 0.30 × FEXX (allowable stress design).
     */
    welding: (i, c, f) => {
        if (missing(i, 'leg', 'length', 'fexx') || !(i.leg > 0) || !(i.length > 0) || !(i.fexx > 0)) {
            return { empty: 'Enter the fillet leg, weld length and electrode strength.' };
        }

        const throat = 0.70711 * i.leg;
        const allowable = 0.3 * i.fexx * 1000 * PSI;
        const perLength = allowable * throat;
        const capacity = perLength * i.length;
        const metal = ((i.leg ** 2) / 2) * i.length * 7850;
        const efficiency = i.efficiency > 0 ? i.efficiency / 100 : 1;
        const required = i.load > 0 ? i.load / (allowable * 0.70711 * i.length) : null;

        return {
            value: f(capacity / LBF / 1000),
            unit: 'kips',
            label: 'Allowable weld load',
            sub: `0.30 × E${f(i.fexx)}XX on a ${f(throat / IN)} in throat × ${f(i.length / IN)} in`,
            rows: {
                kn: `${f(capacity / 1000)} kN`,
                per_inch: `${f(perLength * IN / LBF / 1000)} kips per inch of weld`,
                required: required === null ? 'Enter a load to size the leg' : `${f(required / IN)} in leg needed for ${f(i.load / LBF / 1000)} kips`,
                metal: `${f(metal / 0.45359237)} lb of weld metal; ${f(metal / efficiency / 0.45359237)} lb of electrode at ${f(efficiency * 100)}%`,
            },
        };
    },

    clearance_hole: (i, c, f) => {
        if (i.system === 'metric') {
            const t = c.data.threads_metric[i.metric];
            const d = t.clearance[i.metric_fit];

            return {
                value: f(d),
                unit: 'mm',
                label: 'Clearance hole',
                sub: `${i.metric} ${i.metric_fit} fit (ISO 273)`,
                rows: { fine: `${f(t.clearance.fine)} mm`, medium: `${f(t.clearance.medium)} mm`, coarse: `${f(t.clearance.coarse)} mm`, inch: `${f(d / 25.4)} in` },
            };
        }

        const t = c.data.threads_inch[i.inch];

        if (!t?.clearance) {
            return { error: 'No clearance drill is listed for this size.' };
        }

        const hole = t.clearance[i.inch_fit];

        return {
            value: `${hole.drill}`,
            unit: /^\d+$/.test(hole.drill) ? '(number drill)' : /^[A-Z]$/.test(hole.drill) ? '(letter drill)' : 'in drill',
            label: 'Clearance drill',
            sub: `${f(hole.diameter)} in hole for a ${i.inch} (${f(t.major)} in) screw, ${i.inch_fit} fit`,
            rows: { close: `${t.clearance.close.drill} (${f(t.clearance.close.diameter)} in)`, free: `${t.clearance.free.drill} (${f(t.clearance.free.diameter)} in)`, clearance: `${f((hole.diameter - t.major) * 1000)} thousandths over the major diameter`, mm: `${f(hole.diameter * 25.4)} mm` },
        };
    },

    countersink: (i, c, f) => {
        if (missing(i, 'head', 'hole', 'angle') || !(i.head > 0) || !(i.hole >= 0) || !(i.angle > 0 && i.angle < 180)) {
            return { empty: 'Enter the head diameter, hole diameter and countersink angle.' };
        }

        if (i.hole >= i.head) {
            return { error: 'The hole is as wide as the head.' };
        }

        const half = Math.tan((i.angle / 2) * RAD);
        const depth = (i.head - i.hole) / (2 * half);
        const atDepth = i.depth > 0 ? i.hole + 2 * i.depth * half : null;

        return {
            value: f(depth / IN),
            unit: 'in',
            label: 'Countersink depth',
            sub: `${f(depth * 1000)} mm for a ${f(i.head / IN)} in head at ${f(i.angle)}°`,
            rows: { mm: `${f(depth * 1000)} mm`, sharp: `${f(i.head / (2 * half) / IN)} in from a sharp point (no pilot hole)`, diameter: atDepth === null ? 'Enter a depth to see its diameter' : `${f(atDepth / IN)} in (${f(atDepth * 1000)} mm) at ${f(i.depth / IN)} in deep` },
        };
    },

    bolt_circle: (i, c, f) => {
        if (missing(i, 'diameter', 'holes') || !(i.diameter > 0) || !(i.holes >= 2)) {
            return { empty: 'Enter the bolt circle diameter and number of holes.' };
        }

        const n = Math.round(i.holes);
        const r = i.diameter / 2;
        const start = (i.start || 0) * RAD;
        const cx = i.cx || 0;
        const cy = i.cy || 0;
        const unit = i.units === 'mm' ? 'mm' : 'in';
        const list = Array.from({ length: n }, (_, k) => {
            const a = start + (2 * Math.PI * k) / n;
            const x = Math.abs(cx + r * Math.cos(a)) < 1e-12 ? 0 : cx + r * Math.cos(a);
            const y = Math.abs(cy + r * Math.sin(a)) < 1e-12 ? 0 : cy + r * Math.sin(a);

            return { label: `Hole ${k + 1} at ${f(((a / RAD) % 360 + 360) % 360)}°`, value: `X ${f(x)}, Y ${f(y)}` };
        });
        const chord = 2 * r * Math.sin(Math.PI / n);

        return {
            value: f(chord),
            unit,
            label: 'Spacing between holes',
            sub: `${n} holes, ${f(360 / n)}° apart on a ${f(i.diameter)} ${unit} circle`,
            rows: { angle: `${f(360 / n)}°`, chord: `${f(chord)} ${unit} center to center`, radius: `${f(r)} ${unit}` },
            lists: { holes: list },
        };
    },
};

export default defineTools(handlers);
