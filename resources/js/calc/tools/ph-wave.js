import { defineTools } from '../engines/formula.js';
import { D, handlersFor, K, num, pw } from '../physics/core.js';
import { simpson } from '../physics/util.js';

/**
 * Optics and light, and acoustic waves.
 */
const R_EARTH = 6371000;
const REFRACTION = { none: 'Ignore refraction', standard: 'Standard atmosphere (k = 0.13)' };
const kOf = (x) => (x.refr === 'standard' ? 0.13 : 0);

/** A medium chosen from physics_data.refractive, or a typed index. */
const medium = (key, label, def, custom = 1.5) => ({ [key]: [label, 'select', 'data:refractive', def], [`${key}n`]: [`${label}: refractive index`, null, null, custom, 1] });
const mediumShow = (...keys) => Object.fromEntries(keys.map((k) => [`${k}n`, `${k}:custom`]));
const mediumWhen = (...keys) => Object.fromEntries(keys.map((k) => [`${k}n`, (x) => x[k] === 'custom']));
const nOf = (x, ctx, key) => (x[key] === 'custom' ? x[`${key}n`] : ctx.c.data.physics.refractive[x[key]].n);
const nameOf = (x, ctx, key) => (x[key] === 'custom' ? `n = ${num(x[`${key}n`])}` : ctx.c.data.physics.refractive[x[key]].name);

/** Speed of sound in a physics_data.sound_media entry at temperature T (K). */
function soundSpeed(media, key, T) {
    const m = media[key];

    return m.speed ?? Math.sqrt((m.gamma * K.R * T) / (m.molar / 1000));
}

/** Gaussian lens or mirror equation 1/f = 1/dₒ + 1/dᵢ (real distances positive). */
function imaging(kind) {
    const lens = kind === 'lens';

    return {
        type: 'law',
        vars: { f: ['Focal length', 'length', 'cm', 10], o: ['Object distance', 'length', 'cm', 30], i: ['Image distance', 'length', 'cm', 15] },
        default: 'i',
        eq: '1/f = 1/dₒ + 1/dᵢ',
        forms: { f: 'f = dₒdᵢ ÷ (dₒ + dᵢ)', o: 'dₒ = f dᵢ ÷ (dᵢ − f)', i: 'dᵢ = f dₒ ÷ (dₒ − f)' },
        solve: { f: (v) => (v.o * v.i) / (v.o + v.i), o: (v) => (v.f * v.i) / (v.i - v.f), i: (v) => (v.f * v.o) / (v.o - v.f) },
        rows: { m: 'Magnification', image: 'Image', power: 'Power' },
        extra: (v) => {
            const m = -v.i / v.o;

            return { m: `${num(m)} ×`, image: `${v.i > 0 ? `Real (${lens ? 'opposite side of the lens' : 'in front of the mirror'})` : `Virtual (${lens ? 'same side as the object' : 'behind the mirror'})`}, ${m < 0 ? 'inverted' : 'upright'}, ${Math.abs(m) > 1 ? 'enlarged' : Math.abs(m) < 1 ? 'reduced' : 'same size'}`, power: `${num(1 / v.f)} D` };
        },
        steps: () => [lens ? 'Convention: converging lens f > 0, diverging f < 0; a real image (dᵢ > 0) forms on the far side' : 'Convention: concave mirror f > 0, convex f < 0; a real image (dᵢ > 0) forms in front of the mirror'],
    };
}

const MEDIA_SPEED = { air: 'Air at the temperature below', water: 'Fresh water (1,482 m/s)', seawater: 'Sea water (1,522 m/s)', custom: 'Other (enter the speed)' };
const mediumSpeed = (x, ctx) => (x.med === 'custom' ? x.c : soundSpeed(ctx.c.data.physics.sound_media, x.med, x.med === 'air' ? x.T : 293.15));
const speedInputs = { med: ['Medium', 'select', MEDIA_SPEED, 'air'], T: ['Air temperature', 'temperature', 'c', 20], c: ['Speed of sound', 'speed', 'ms', 343] };
const speedShow = { T: 'med:air', c: 'med:custom' };
const speedWhen = { T: (x) => x.med === 'air', c: (x) => x.med === 'custom' };
const BANDS = { 0: '125 Hz', 1: '250 Hz', 2: '500 Hz', 3: '1,000 Hz', 4: '2,000 Hz', 5: '4,000 Hz' };
const harmonics = (list, unit = 'Hz') => list.map((f, k) => `${k + 1}: ${num(f, 5)} ${unit}`).join(', ');

export const TOOLS = {
    // Optics -------------------------------------------------------------------------------------
    angular_resolution: pw({ vars: { theta: ['Angular resolution', 'angle', 'arcsec', 1.38389], lambda: ['Wavelength', 'length', 'nm', 550], D: ['Aperture diameter', 'length', 'mm', 100] }, out: 'theta', k: 1.22, exp: { lambda: 1, D: -1 }, eq: 'θ = 1.22 λ ÷ D', forms: { theta: 'θ = 1.22λ ÷ D (Rayleigh)', lambda: 'λ = θD ÷ 1.22', D: 'D = 1.22λ ÷ θ' }, rows: { dawes: 'Dawes limit (visual double stars)', km: ['Smallest detail at 1 km', 'length'] }, extra: (v) => ({ dawes: `${num(0.116 / v.D)}″`, km: [v.theta * 1000, 'length'] }) }),
    aperture_area: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { d: 'The aperture diameter', fn: 'Focal length and f-number' }, 'd'], D: ['Aperture diameter', 'length', 'mm', 200], f: ['Focal length', 'length', 'mm', 1000], N: ['f-number', null, null, 5, 0], obs: ['Central obstruction diameter', 'length', 'mm', 0] },
        show: { D: 'mode:d', f: 'mode:fn', N: 'mode:fn' },
        when: { D: (x) => x.mode === 'd', f: (x) => x.mode === 'fn', N: (x) => x.mode === 'fn' },
        optional: ['obs'],
        out: 'area',
        outUnit: 'cm2',
        label: 'Light-collecting area',
        rows: { D: ['Aperture diameter', 'length'], eye: 'Light grasp compared with a 7 mm eye pupil', mag: 'Approximate limiting magnitude', lost: 'Area lost to the obstruction' },
        run: (x) => {
            const D0 = x.mode === 'd' ? x.D : x.f / x.N;
            const d = Number.isFinite(x.obs) ? x.obs : 0;

            if (!(d < D0)) {
                return { error: 'The obstruction must be smaller than the aperture.' };
            }

            const A = (Math.PI * (D0 * D0 - d * d)) / 4;

            return { value: A, sub: `${num(A / ((Math.PI * 0.007 ** 2) / 4))} × a dark-adapted eye`, rows: { D: [D0, 'length'], eye: `${num(A / ((Math.PI * 0.007 ** 2) / 4))} ×`, mag: num(7.7 + 5 * Math.log10(D0 * 100), 3), lost: `${num((d * d) / (D0 * D0) * 100, 3)}%` }, steps: ['A = π(D² − d²) ÷ 4', `= π(${num(D0 * 1000)}² − ${num(d * 1000)}²) ÷ 4 mm² = ${num(A * 1e6)} mm²`, 'Limiting magnitude ≈ 7.7 + 5 log₁₀ D(cm), a rule of thumb for dark skies'] };
        },
    },
    binoculars: {
        type: 'calc',
        inputs: { M: ['Magnification', null, null, 8, 0], D: ['Objective diameter', 'length', 'mm', 42], fov: ['Real field of view (0 if unknown)', 'angle', 'deg', 7], d: ['Viewing distance', 'length', 'm', 1000] },
        optional: ['fov'],
        out: 'length',
        outUnit: 'mm',
        label: 'Exit pupil',
        rows: { twilight: 'Twilight factor √(M × D)', bright: 'Relative brightness (exit pupil²)', field: ['Width of view at that distance', 'length'], detail: ['Smallest detail visible at that distance', 'length'], same: ['Seen as large as with the naked eye at', 'length'] },
        run: (x) => {
            const ep = x.D / x.M;
            const Dmm = x.D * 1000;
            const res = Math.max(60 / x.M, 116 / Dmm);

            return { value: ep, sub: `Twilight factor ${num(Math.sqrt(x.M * Dmm), 4)}`, rows: { twilight: num(Math.sqrt(x.M * Dmm), 4), bright: num((ep * 1000) ** 2, 4), field: Number.isFinite(x.fov) && x.fov > 0 ? [2 * x.d * Math.tan(x.fov / 2), 'length'] : 'Enter the field of view', detail: [(x.d * res) / 206265, 'length'], same: [x.d / x.M, 'length'] }, steps: [`Exit pupil = D ÷ M = ${num(Dmm)} ÷ ${num(x.M)} = ${num(ep * 1000)} mm (a dark-adapted eye opens to about 7 mm)`, `Twilight factor = √(M × D) = ${num(Math.sqrt(x.M * Dmm))}`, `Resolution ≈ max(60″ ÷ M, 116″ ÷ D) = ${num(res)}″`] };
        },
    },
    blackbody: {
        type: 'calc',
        inputs: { T: ['Temperature', 'temperature', 'k', 5772], eps: ['Emissivity', null, null, 1, 0], area: ['Surface area (optional, for total power)', 'area', 'm2', 1] },
        optional: ['area'],
        out: 'length',
        outUnit: 'nm',
        label: 'Peak wavelength',
        rows: { M: ['Radiant exitance σεT⁴', 'intensity'], P: ['Total power from that area', 'power'], fpeak: 'Peak frequency', visible: 'Share emitted as visible light (380–750 nm)', color: 'Appearance' },
        plots: [['spectrum', 'Spectral exitance (Planck’s law)']],
        run: (x) => {
            if (!(x.T > 0) || x.eps > 1) {
                return { error: 'Temperature must be above absolute zero and emissivity at most 1.' };
            }

            const planck = (l) => (2 * Math.PI * K.h * K.c * K.c) / l ** 5 / Math.expm1((K.h * K.c) / (l * K.k * x.T));
            const peak = K.wien / x.T;
            const total = K.sigma * x.T ** 4;
            const visible = simpson(planck, 380e-9, 750e-9, 400) / total;
            const series = Array.from({ length: 161 }, (_, n) => {
                const l = peak * (0.2 + (5.8 * n) / 160);

                return [l * 1e9, x.eps * planck(l) * 1e-9];
            });
            const color = x.T < 800 ? 'Invisible (infrared)' : x.T < 1300 ? 'Dull red' : x.T < 2500 ? 'Orange-red' : x.T < 4000 ? 'Warm yellow-white' : x.T < 7000 ? 'White' : 'Bluish white';

            return { value: peak, sub: `Wien: λ_max = b ÷ T; σεT⁴ = ${num(x.eps * total)} W/m²`, rows: { M: [x.eps * total, 'intensity'], P: Number.isFinite(x.area) ? [x.eps * total * x.area, 'power'] : 'Enter an area', fpeak: `${num(5.878925757e10 * x.T / 1e12)} THz (frequency peak, not at c ÷ λ_max)`, visible: `${num(visible * 100, 4)}%`, color }, steps: [`λ_max = ${num(K.wien)} m·K ÷ ${num(x.T)} K = ${num(peak * 1e9)} nm`, `M = εσT⁴ = ${num(x.eps)} × 5.670 × 10⁻⁸ × ${num(x.T)}⁴ = ${num(x.eps * total)} W/m²`, 'Planck: M_λ = 2πhc² ÷ λ⁵ ÷ (e^(hc/λkT) − 1)'], plots: { spectrum: { series, axes: true, xLabel: 'Wavelength (nm)', yLabel: 'W/(m²·nm)' } } };
        },
    },
    bragg: {
        type: 'law',
        vars: { n: ['Diffraction order n', null, null, 1], lambda: ['Wavelength', 'length', 'nm', 0.15406], d: ['Lattice spacing d', 'length', 'nm', 0.3], theta: ['Bragg angle θ', 'angle', 'deg', 14.8806] },
        default: 'theta',
        eq: 'n λ = 2 d sin θ',
        forms: { theta: 'θ = asin(nλ ÷ 2d)', d: 'd = nλ ÷ (2 sin θ)', lambda: 'λ = 2d sin θ ÷ n', n: 'n = 2d sin θ ÷ λ' },
        solve: { theta: (v) => Math.asin((v.n * v.lambda) / (2 * v.d)), d: (v) => (v.n * v.lambda) / (2 * Math.sin(v.theta)), lambda: (v) => (2 * v.d * Math.sin(v.theta)) / v.n, n: (v) => (2 * v.d * Math.sin(v.theta)) / v.lambda },
        rows: { twoTheta: 'Detector angle 2θ', orders: 'Highest possible order' },
        extra: (v) => ({ twoTheta: `${num((2 * v.theta) / D)}°`, orders: String(Math.floor((2 * v.d) / v.lambda)) }),
        noSolution: 'No diffraction: nλ is larger than 2d.',
    },
    brewster: {
        type: 'calc',
        inputs: { ...medium('m1', 'Light comes from', 'air'), ...medium('m2', 'Into', 'bk7') },
        show: mediumShow('m1', 'm2'),
        when: mediumWhen('m1', 'm2'),
        data: ['refractive'],
        out: 'angle',
        outUnit: 'deg',
        label: 'Brewster’s angle',
        rows: { refr: 'Refracted angle', back: 'Brewster’s angle the other way', rs: 'Reflectance of s-polarised light there' },
        run: (x, ctx) => {
            const n1 = nOf(x, ctx, 'm1');
            const n2 = nOf(x, ctx, 'm2');
            const tb = Math.atan(n2 / n1);
            const tt = Math.PI / 2 - tb;
            const rs = ((n1 * Math.cos(tb) - n2 * Math.cos(tt)) / (n1 * Math.cos(tb) + n2 * Math.cos(tt))) ** 2;

            return { value: tb, sub: `${nameOf(x, ctx, 'm1')} → ${nameOf(x, ctx, 'm2')}: reflected light is fully s-polarised`, rows: { refr: `${num(tt / D)}° (reflected and refracted rays at 90°)`, back: `${num(Math.atan(n1 / n2) / D)}°`, rs: `${num(rs * 100, 4)}%` }, steps: [`θ_B = atan(n₂ ÷ n₁) = atan(${num(n2)} ÷ ${num(n1)}) = ${num(tb / D)}°`] };
        },
    },
    contact_vertex: {
        type: 'calc',
        inputs: { S: ['Spectacle sphere (D)', null, null, -5], C: ['Spectacle cylinder (D)', null, null, -1.5], axis: ['Axis (degrees)', null, null, 180], d: ['Vertex distance', 'length', 'mm', 12] },
        optional: ['C', 'axis'],
        label: 'Contact lens sphere',
        rows: { cyl: 'Contact lens cylinder', rounded: 'Rounded to 0.25 D steps', note: 'Note' },
        run: (x) => {
            const comp = (F) => F / (1 - x.d * F);
            const C = Number.isFinite(x.C) ? x.C : 0;
            const s = comp(x.S);
            const c = comp(x.S + C) - s;
            const q = (v) => (Math.round(v * 4) / 4).toFixed(2).replace('-', '−');

            return { value: num(s, 4), unit: 'D', sub: C ? `${q(s)} / ${q(c)} × ${num(x.axis ?? 180)}` : `Rounded: ${q(s)} D`, rows: { cyl: `${num(c, 4)} D`, rounded: `${q(s)} / ${q(c)}${C ? ` × ${num(x.axis ?? 180)}` : ''}`, note: Math.abs(x.S) < 4 ? 'Below ±4 D the change is usually smaller than a 0.25 D step' : 'A fitting by an eye-care professional is still needed' }, steps: ['F_c = F ÷ (1 − dF), d in metres, applied to each principal meridian', `Sphere meridian: ${num(x.S)} → ${num(s)} D`, ...(C ? [`Other meridian: ${num(x.S + C)} → ${num(comp(x.S + C))} D, so cylinder ${num(c)} D`] : [])] };
        },
    },
    grating: {
        type: 'law',
        vars: { N: ['Lines per millimetre', null, null, 600], lambda: ['Wavelength', 'length', 'nm', 532], m: ['Order m', null, null, 1], theta: ['Diffraction angle', 'angle', 'deg', 18.6] },
        default: 'theta',
        eq: 'd sin θ = m λ, d = 1 ÷ N',
        forms: { theta: 'θ = asin(mλN)', lambda: 'λ = sin θ ÷ (mN)', N: 'N = sin θ ÷ (mλ)', m: 'm = sin θ ÷ (λN)' },
        solve: { theta: (v) => Math.asin(v.m * v.lambda * v.N * 1000), lambda: (v) => Math.sin(v.theta) / (v.m * v.N * 1000), N: (v) => Math.sin(v.theta) / (v.m * v.lambda * 1000), m: (v) => Math.sin(v.theta) / (v.lambda * v.N * 1000) },
        rows: { d: 'Line spacing d', max: 'Highest visible order' },
        extra: (v) => ({ d: `${num(1000 / v.N)} µm`, max: String(Math.floor(1 / (v.lambda * v.N * 1000))) }),
        noSolution: 'That order does not exist: mλ is larger than the line spacing.',
    },
    diopter: pw({ vars: { P: ['Lens power (dioptres)', null, null, 2.5], f: ['Focal length', 'length', 'cm', 40] }, out: 'P', exp: { f: -1 }, eq: 'P = 1 ÷ f (f in metres)', forms: { P: 'P = 1 ÷ f', f: 'f = 1 ÷ P' }, rows: { kind: 'Lens type' }, extra: (v) => ({ kind: v.P > 0 ? 'Converging (plus, for long sight)' : 'Diverging (minus, for short sight)' }) }),
    horizon: {
        type: 'calc',
        inputs: { h: ['Eye height', 'length', 'm', 1.7], target: ['Target height (optional)', 'length', 'm', 0], refr: ['Refraction', 'select', REFRACTION, 'standard'] },
        optional: ['target'],
        out: 'length',
        outUnit: 'km',
        label: 'Distance to the horizon',
        rows: { geo: ['Without refraction', 'length'], seen: ['Target top visible up to', 'length'], dip: 'Dip of the horizon' },
        run: (x) => {
            const R = R_EARTH / (1 - kOf(x));
            const d = (h) => Math.sqrt(2 * R * h + h * h);
            const t = Number.isFinite(x.target) ? x.target : 0;

            return { value: d(x.h), sub: `R_eff = ${num(R / 1000)} km`, rows: { geo: [Math.sqrt(2 * R_EARTH * x.h + x.h * x.h), 'length'], seen: [d(x.h) + d(t), 'length'], dip: `${num((Math.acos(R / (R + x.h)) / D) * 60)}′` }, steps: ['d = √(2R_eff h + h²), R_eff = R ÷ (1 − k), R = 6,371 km', `= ${num(d(x.h) / 1000)} km`, ...(t ? [`Plus the target's own horizon: ${num(d(t) / 1000)} km`] : [])] };
        },
    },
    curvature: {
        type: 'calc',
        inputs: { d: ['Distance to the object', 'length', 'km', 10], h: ['Eye height', 'length', 'm', 2], refr: ['Refraction', 'select', REFRACTION, 'standard'] },
        out: 'length',
        outUnit: 'm',
        label: 'Hidden height',
        rows: { drop: ['Drop below a level line', 'length'], horizon: ['Your horizon distance', 'length'] },
        run: (x) => {
            const R = R_EARTH / (1 - kOf(x));
            const dh = Math.sqrt(x.h * (2 * R + x.h));
            const beyond = Math.max(0, x.d - dh);
            const hidden = Math.sqrt(beyond * beyond + R * R) - R;
            const drop = R * (1 - Math.cos(x.d / R));

            return { value: hidden, sub: beyond > 0 ? `The bottom ${num(hidden)} m is below your horizon` : 'The whole object is above your horizon', rows: { drop: [drop, 'length'], horizon: [dh, 'length'] }, steps: [`R_eff = ${num(R / 1000)} km`, `Horizon distance √(h(2R + h)) = ${num(dh / 1000)} km`, `Beyond the horizon: ${num(beyond / 1000)} km, hidden = √(x² + R²) − R = ${num(hidden)} m`, `Drop below level ≈ d² ÷ 2R = ${num(drop)} m`] };
        },
    },
    refractive_index: pw({ vars: { n: ['Refractive index n', null, null, 1.33], v: ['Speed of light in the medium', 'speed', 'kms', 225407.863] }, out: 'n', k: K.c, exp: { v: -1 }, eq: 'n = c ÷ v', forms: { n: 'n = c ÷ v', v: 'v = c ÷ n' }, rows: { delay: 'Extra delay per kilometre compared with vacuum' }, extra: (v) => ({ delay: `${num(((v.n - 1) * 1000 / K.c) * 1e6)} µs` }) }),
    laser_divergence: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { waist: 'The waist and wavelength', two: 'Two beam diameters and their spacing' }, 'waist'], w0: ['Waist radius w₀', 'length', 'mm', 0.5], lambda: ['Wavelength', 'length', 'nm', 1064], M2: ['Beam quality M²', null, null, 1, 1], d1: ['Diameter at the first point', 'length', 'mm', 2], d2: ['Diameter at the second point', 'length', 'mm', 6], L: ['Distance between them', 'length', 'm', 5] },
        show: { w0: 'mode:waist', lambda: 'mode:waist', M2: 'mode:waist', d1: 'mode:two', d2: 'mode:two', L: 'mode:two' },
        when: { w0: (x) => x.mode === 'waist', lambda: (x) => x.mode === 'waist', M2: (x) => x.mode === 'waist', d1: (x) => x.mode === 'two', d2: (x) => x.mode === 'two', L: (x) => x.mode === 'two' },
        out: 'angle',
        outUnit: 'mrad',
        label: 'Half-angle divergence',
        rows: { full: 'Full-angle divergence', zr: ['Rayleigh range', 'length'], at100: ['Beam diameter at 100 m', 'length'] },
        run: (x) => {
            if (x.mode === 'two') {
                const th = Math.atan((x.d2 - x.d1) / (2 * x.L));

                return { value: th, sub: 'From two measured diameters (far field)', rows: { full: `${num(2 * th * 1000)} mrad`, zr: 'Needs the waist', at100: [x.d2 + 2 * Math.tan(th) * (100 - x.L), 'length'] }, steps: ['θ = atan((d₂ − d₁) ÷ 2L)', `= ${num(th * 1000)} mrad`] };
            }

            const th = (x.M2 * x.lambda) / (Math.PI * x.w0);
            const zr = (Math.PI * x.w0 * x.w0) / (x.M2 * x.lambda);
            const w100 = x.w0 * Math.sqrt(1 + (100 / zr) ** 2);

            return { value: th, sub: `Rayleigh range ${num(zr)} m`, rows: { full: `${num(2 * th * 1000)} mrad`, zr: [zr, 'length'], at100: [2 * w100, 'length'] }, steps: ['θ = M²λ ÷ πw₀ (Gaussian beam, 1/e² radius)', `= ${num(th * 1000)} mrad`, `z_R = πw₀² ÷ M²λ = ${num(zr)} m`] };
        },
    },
    beam_expander: {
        type: 'calc',
        inputs: { type: ['Design', 'select', { kepler: 'Keplerian (two positive lenses)', galileo: 'Galilean (negative then positive)' }, 'galileo'], f1: ['Input lens focal length (magnitude)', 'length', 'mm', 25], f2: ['Output lens focal length', 'length', 'mm', 100], D: ['Input beam diameter', 'length', 'mm', 2], th: ['Input full divergence', 'angle', 'mrad', 1] },
        out: 'length',
        outUnit: 'mm',
        label: 'Output beam diameter',
        rows: { M: 'Magnification', th: 'Output divergence', sep: ['Lens separation', 'length'] },
        run: (x) => {
            const M = x.f2 / x.f1;
            const sep = x.type === 'kepler' ? x.f2 + x.f1 : x.f2 - x.f1;

            return { value: x.D * M, sub: `${num(M)} × expansion; divergence falls to ${num((x.th / M) * 1000)} mrad`, rows: { M: `${num(M)} ×`, th: `${num((x.th / M) * 1000)} mrad`, sep: [sep, 'length'] }, steps: ['M = f₂ ÷ f₁', `D_out = M D_in = ${num(x.D * M * 1000)} mm`, 'θ_out = θ_in ÷ M', x.type === 'kepler' ? 'Separation f₁ + f₂ (has an internal focus: good for a pinhole filter)' : 'Separation f₂ − |f₁| (no internal focus: shorter, fine for high power)'] };
        },
    },
    laser_brightness: {
        type: 'calc',
        inputs: { P: ['Output power', 'power', 'milliwatt', 5], w0: ['Waist radius w₀', 'length', 'mm', 0.5], th: ['Half-angle divergence', 'angle', 'mrad', 0.5] },
        label: 'Radiance (brightness)',
        rows: { sun: 'Compared with the Sun’s surface', intensity: 'Peak irradiance at the waist' },
        run: (x) => {
            const B = x.P / (Math.PI ** 2 * x.w0 ** 2 * x.th ** 2);

            return { value: num(B), unit: 'W/(m²·sr)', sub: `${num(B / 2.01e7)} × the Sun’s surface radiance`, rows: { sun: `${num(B / 2.01e7)} ×`, intensity: `${num((2 * x.P) / (Math.PI * x.w0 ** 2))} W/m²` }, steps: ['B = P ÷ (π² w₀² θ²)', `= ${num(B)} W/(m²·sr)`, 'Sun ≈ 2.0 × 10⁷ W/(m²·sr)'] };
        },
    },
    linewidth: {
        type: 'calc',
        inputs: { value: ['Linewidth', null, null, 0.1, 0], unit: ['Given in', 'select', { nm: 'nm', pm: 'pm', ghz: 'GHz', mhz: 'MHz', khz: 'kHz', cm: 'cm⁻¹' }, 'nm'], lambda: ['Centre wavelength', 'length', 'nm', 1550] },
        label: 'Linewidth in frequency',
        rows: { nm: 'In nanometres', pm: 'In picometres', hz: 'In hertz', cm: 'In wavenumbers', coh: 'Coherence length (≈ c ÷ πΔν, Lorentzian)', q: 'Quality factor ν ÷ Δν' },
        run: (x) => {
            const nu = K.c / x.lambda;
            const toHz = { nm: (v) => (K.c * v * 1e-9) / x.lambda ** 2, pm: (v) => (K.c * v * 1e-12) / x.lambda ** 2, ghz: (v) => v * 1e9, mhz: (v) => v * 1e6, khz: (v) => v * 1e3, cm: (v) => v * 100 * K.c };
            const dn = toHz[x.unit](x.value);
            const dl = (dn * x.lambda ** 2) / K.c;

            return { value: num(dn / 1e9), unit: 'GHz', sub: `${num(dl * 1e9)} nm at ${num(x.lambda * 1e9)} nm`, rows: { nm: `${num(dl * 1e9)} nm`, pm: `${num(dl * 1e12)} pm`, hz: `${num(dn)} Hz`, cm: `${num(dn / K.c / 100)} cm⁻¹`, coh: `${num(K.c / (Math.PI * dn))} m`, q: num(nu / dn) }, steps: ['Δν = cΔλ ÷ λ² (narrow lines)', `Δν = ${num(dn)} Hz, Δλ = ${num(dl * 1e9)} nm`] };
        },
    },
    spot_size: {
        type: 'calc',
        inputs: { lambda: ['Wavelength', 'length', 'nm', 1064], D: ['Beam diameter at the lens', 'length', 'mm', 5], f: ['Focal length', 'length', 'mm', 100], M2: ['Beam quality M²', null, null, 1, 1] },
        out: 'length',
        outUnit: 'um',
        label: 'Focused spot diameter',
        rows: { dof: ['Depth of focus (2 × Rayleigh range)', 'length'], na: 'Focusing NA (approx.)' },
        run: (x) => {
            const d = (4 * x.M2 * x.lambda * x.f) / (Math.PI * x.D);
            const zr = (Math.PI * (d / 2) ** 2) / (x.M2 * x.lambda);

            return { value: d, sub: `Depth of focus ${num(2 * zr * 1000)} mm`, rows: { dof: [2 * zr, 'length'], na: num(x.D / (2 * x.f), 4) }, steps: ['d = 4M²λf ÷ πD (1/e² diameter, Gaussian beam)', `= ${num(d * 1e6)} µm`] };
        },
    },
    lens_maker: {
        type: 'calc',
        inputs: { n: ['Refractive index of the lens', null, null, 1.5168, 1], R1: ['Radius of the first surface R₁', 'length', 'mm', 100], R2: ['Radius of the second surface R₂', 'length', 'mm', -100], d: ['Centre thickness', 'length', 'mm', 5], nm: ['Index of the surrounding medium', null, null, 1, 1] },
        out: 'length',
        outUnit: 'mm',
        label: 'Focal length',
        rows: { P: 'Power', thin: ['Thin-lens value (thickness ignored)', 'length'], kind: 'Lens type' },
        run: (x) => {
            const nr = x.n / x.nm;
            const inv1 = (r) => (Number.isFinite(1 / r) ? 1 / r : 0);
            const P = (nr - 1) * (inv1(x.R1) - inv1(x.R2) + ((nr - 1) * x.d * inv1(x.R1) * inv1(x.R2)) / nr);
            const thin = (nr - 1) * (inv1(x.R1) - inv1(x.R2));

            return { value: 1 / P, sub: `Power ${num(P)} D in the medium`, rows: { P: `${num(P)} D`, thin: [1 / thin, 'length'], kind: P > 0 ? 'Converging' : 'Diverging' }, steps: ['1/f = (n − 1)[1/R₁ − 1/R₂ + (n − 1)d ÷ (nR₁R₂)]', 'Sign convention: R > 0 when the centre of curvature is on the outgoing side', `f = ${num((1 / P) * 1000)} mm`] };
        },
    },
    lumen: {
        type: 'calc',
        inputs: { lm: ['Luminous flux (lumens)', null, null, 800, 0], beam: ['Beam angle (full)', 'angle', 'deg', 60], d: ['Distance to the surface', 'length', 'm', 2] },
        out: 'illuminance',
        outUnit: 'lx',
        label: 'Illuminance at the centre',
        rows: { cd: 'Luminous intensity', sr: 'Solid angle of the beam', spot: ['Beam diameter at that distance', 'length'], avg: 'Average over the beam spot' },
        run: (x) => {
            const sr = 2 * Math.PI * (1 - Math.cos(x.beam / 2));
            const cd = x.lm / sr;
            const r = x.d * Math.tan(x.beam / 2);

            return { value: cd / (x.d * x.d), sub: `${num(cd)} cd`, rows: { cd: `${num(cd)} cd`, sr: `${num(sr)} sr`, spot: [2 * r, 'length'], avg: `${num(x.lm / (Math.PI * r * r))} lx` }, steps: ['Ω = 2π(1 − cos(θ/2)), I = Φ ÷ Ω, E = I ÷ d²', `Ω = ${num(sr)} sr, I = ${num(cd)} cd, E = ${num(cd / (x.d * x.d))} lx`, 'Assumes the lumens are spread evenly over the beam'] };
        },
    },
    lux_fc: {
        type: 'calc',
        inputs: { E: ['Illuminance', 'illuminance', 'lx', 500] },
        out: 'illuminance',
        outUnit: 'fc',
        label: 'Converted illuminance',
        rows: { lx: ['In lux', 'illuminance'], typical: 'Typical levels' },
        run: (x) => ({ value: x.E, sub: '1 fc = 1 lm/ft² = 10.7639 lx', rows: { lx: [x.E, 'illuminance'], typical: 'Office 300–500 lx, overcast day 1,000 lx, full sun 100,000 lx' }, steps: [`${num(x.E)} lx ÷ 10.7639 = ${num(x.E / 10.7639104)} fc`] }),
    },
    malus: {
        type: 'law',
        vars: { I: ['Transmitted intensity', 'intensity', 'wm2', 75], I0: ['Incident (polarised) intensity', 'intensity', 'wm2', 100], theta: ['Angle between polariser axes', 'angle', 'deg', 30] },
        default: 'I',
        eq: 'I = I₀ cos² θ',
        forms: { I: 'I = I₀cos²θ', I0: 'I₀ = I ÷ cos²θ', theta: 'θ = acos √(I ÷ I₀)' },
        solve: { I: (v) => v.I0 * Math.cos(v.theta) ** 2, I0: (v) => v.I / Math.cos(v.theta) ** 2, theta: (v) => Math.acos(Math.sqrt(v.I / v.I0)) },
        rows: { share: 'Transmitted share', unpol: 'If the incident light were unpolarised' },
        extra: (v) => ({ share: `${num(Math.cos(v.theta) ** 2 * 100, 5)}%`, unpol: 'A first polariser passes half of it, then Malus’s law applies' }),
    },
    mirror: imaging('mirror'),
    optical_density: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { T: 'Transmittance', OD: 'Optical density' }, 'T'], T: ['Transmittance (%)', null, null, 10, 0], OD: ['Optical density', null, null, 3, 0] },
        show: { T: 'mode:T', OD: 'mode:OD' },
        when: { T: (x) => x.mode === 'T', OD: (x) => x.mode === 'OD' },
        label: 'Optical density',
        rows: { T: 'Transmittance', db: 'Attenuation', blocked: 'Light blocked' },
        run: (x) => {
            const od = x.mode === 'T' ? -Math.log10(x.T / 100) : x.OD;
            const T = 10 ** -od;

            if (!Number.isFinite(od)) {
                return { error: 'Transmittance must be above 0%.' };
            }

            return { value: x.mode === 'T' ? num(od, 5) : num(T * 100, 5), unit: x.mode === 'T' ? '' : '%', label: x.mode === 'T' ? 'Optical density' : 'Transmittance', sub: x.mode === 'T' ? `T = ${num(T * 100)}%` : `OD ${num(od)}`, rows: { T: `${num(T * 100)}% (1 in ${num(1 / T)})`, db: `${num(10 * od)} dB`, blocked: `${num((1 - T) * 100)}%` }, steps: ['OD = −log₁₀ T, T = 10^(−OD)', `OD ${num(od)} ↔ T = ${num(T)}`] };
        },
    },
    radar_horizon: {
        type: 'calc',
        inputs: { h1: ['Antenna height', 'length', 'm', 30], h2: ['Target height', 'length', 'm', 10], k: ['Refraction', 'select', { radar: 'Standard radio (k = 4/3)', optical: 'Optical (k ≈ 1.15)', none: 'Geometric (k = 1)' }, 'radar'] },
        out: 'length',
        outUnit: 'km',
        label: 'Radar horizon',
        rows: { a: ['Antenna horizon', 'length'], b: ['Target horizon', 'length'], nmi: 'In nautical miles' },
        run: (x) => {
            const k = { radar: 4 / 3, optical: 1.15, none: 1 }[x.k];
            const a = Math.sqrt(2 * k * R_EARTH * x.h1);
            const b = Math.sqrt(2 * k * R_EARTH * x.h2);

            return { value: a + b, sub: `${num(a / 1000)} km + ${num(b / 1000)} km`, rows: { a: [a, 'length'], b: [b, 'length'], nmi: `${num((a + b) / 1852)} nmi` }, steps: ['d = √(2kRh₁) + √(2kRh₂), R = 6,371 km', `= ${num((a + b) / 1000)} km (≈ 4.12(√h₁ + √h₂) km for k = 4/3)`] };
        },
    },
    snell: {
        type: 'calc',
        inputs: { ...medium('m1', 'Light comes from', 'air'), ...medium('m2', 'Into', 'water'), t1: ['Angle of incidence', 'angle', 'deg', 30] },
        show: mediumShow('m1', 'm2'),
        when: mediumWhen('m1', 'm2'),
        data: ['refractive'],
        out: 'angle',
        outUnit: 'deg',
        label: 'Angle of refraction',
        rows: { n: 'Refractive indices', crit: 'Critical angle', dev: 'Deviation', R: 'Reflected share (unpolarised)' },
        plots: [['rays', 'Ray diagram']],
        run: (x, ctx) => {
            const n1 = nOf(x, ctx, 'm1');
            const n2 = nOf(x, ctx, 'm2');
            const s = (n1 * Math.sin(x.t1)) / n2;
            const crit = n1 > n2 ? `${num(Math.asin(n2 / n1) / D)}°` : 'None (light enters a denser medium)';
            const inc = [[-Math.sin(x.t1), Math.cos(x.t1)], [0, 0]];
            const base = [{ points: [[-1.2, 0], [1.2, 0]], muted: true }, { points: [[0, -1.1], [0, 1.1]], muted: true, dashed: true }, { points: inc }];

            if (s > 1) {
                return { value: NaN, error: `Total internal reflection: the angle is past the critical angle ${crit}.` };
            }

            const t2 = Math.asin(s);
            const ci = Math.cos(x.t1);
            const ct = Math.cos(t2);
            const rs = ((n1 * ci - n2 * ct) / (n1 * ci + n2 * ct)) ** 2;
            const rp = ((n2 * ci - n1 * ct) / (n2 * ci + n1 * ct)) ** 2;

            return { value: t2, sub: `${nameOf(x, ctx, 'm1')} (n = ${num(n1)}) → ${nameOf(x, ctx, 'm2')} (n = ${num(n2)})`, rows: { n: `n₁ = ${num(n1)}, n₂ = ${num(n2)}`, crit, dev: `${num(Math.abs(x.t1 - t2) / D)}°`, R: `${num(((rs + rp) / 2) * 100, 4)}% (Fresnel)` }, steps: ['n₁ sin θ₁ = n₂ sin θ₂', `sin θ₂ = ${num(n1)} × sin ${num(x.t1 / D)}° ÷ ${num(n2)} = ${num(s)}`, `θ₂ = ${num(t2 / D)}°`], plots: { rays: { kind: 'diagram', shapes: [...base, { points: [[0, 0], [Math.sin(t2), -Math.cos(t2)]] }, { points: [[0, 0], [Math.sin(x.t1), Math.cos(x.t1)]], muted: true }], labels: [{ x: -0.9, y: 0.12, text: `n₁ = ${num(n1, 4)}` }, { x: -0.9, y: -0.18, text: `n₂ = ${num(n2, 4)}` }] } } };
        },
    },
    speed_light: {
        type: 'calc',
        inputs: { mode: ['Find', 'select', { t: 'Travel time for a distance', d: 'Distance for a time' }, 't'], d: ['Distance', 'astronomical', 'km', 384400], t: ['Time', 'time', 's', 1], ...medium('m', 'Medium', 'vacuum') },
        show: { d: 'mode:t', t: 'mode:d', ...mediumShow('m') },
        when: { d: (x) => x.mode === 't', t: (x) => x.mode === 'd', ...mediumWhen('m') },
        data: ['refractive'],
        label: 'Travel time',
        rows: { v: ['Speed of light in this medium', 'speed'], vac: 'In vacuum' },
        run: (x, ctx) => {
            const n = nOf(x, ctx, 'm');
            const v = K.c / n;

            if (x.mode === 'd') {
                const d = v * x.t;

                return { value: num(d / 1000), unit: 'km', label: 'Distance travelled', sub: `${num(d / K.au)} AU, ${num(d / K.ly)} light-years`, rows: { v: [v, 'speed'], vac: 'c = 299,792,458 m/s (exact)' }, steps: [`d = (c ÷ n) t = ${num(v)} m/s × ${num(x.t)} s = ${num(d)} m`] };
            }

            const t = x.d / v;
            const human = t < 1e-3 ? `${num(t * 1e6)} µs` : t < 120 ? `${num(t)} s` : t < 7200 ? `${num(t / 60)} min` : t < 2 * 86400 * 365.25 ? `${num(t / 3600)} h` : `${num(t / (86400 * 365.25))} years`;

            return { value: num(t), unit: 's', sub: human, rows: { v: [v, 'speed'], vac: 'c = 299,792,458 m/s (exact)' }, steps: [`t = d ÷ (c ÷ n) = ${num(x.d)} m ÷ ${num(v)} m/s = ${num(t)} s`] };
        },
    },
    telescope_fov: {
        type: 'calc',
        inputs: { mode: ['Method', 'select', { afov: 'Eyepiece apparent field', stop: 'Eyepiece field stop' }, 'afov'], F: ['Telescope focal length', 'length', 'mm', 1000], f: ['Eyepiece focal length', 'length', 'mm', 25], afov: ['Apparent field of view', 'angle', 'deg', 52], stop: ['Field stop diameter', 'length', 'mm', 21] },
        show: { f: 'mode:afov', afov: 'mode:afov', stop: 'mode:stop' },
        when: { f: (x) => x.mode === 'afov', afov: (x) => x.mode === 'afov', stop: (x) => x.mode === 'stop' },
        out: 'angle',
        outUnit: 'deg',
        label: 'True field of view',
        rows: { arcmin: 'In arcminutes', moons: 'Full Moons across (0.52° each)', M: 'Magnification' },
        run: (x) => {
            const tf = x.mode === 'stop' ? x.stop / x.F : x.afov / (x.F / x.f);

            return { value: tf, sub: x.mode === 'stop' ? 'TFOV = field stop ÷ focal length (radians)' : 'TFOV = AFOV ÷ magnification', rows: { arcmin: `${num((tf / D) * 60)}′`, moons: num(tf / D / 0.52, 3), M: x.mode === 'afov' ? `${num(x.F / x.f)} ×` : 'Not needed' }, steps: [x.mode === 'stop' ? `TFOV = ${num(x.stop * 1000)} ÷ ${num(x.F * 1000)} rad = ${num(tf / D)}°` : `M = ${num(x.F * 1000)} ÷ ${num(x.f * 1000)} = ${num(x.F / x.f)} ×, TFOV = ${num(x.afov / D)}° ÷ ${num(x.F / x.f)} = ${num(tf / D)}°`] };
        },
    },
    telescope_mag: {
        type: 'calc',
        inputs: { F: ['Telescope focal length', 'length', 'mm', 1000], f: ['Eyepiece focal length', 'length', 'mm', 25], D: ['Aperture', 'length', 'mm', 100], barlow: ['Barlow factor', null, null, 1, 1] },
        label: 'Magnification',
        rows: { ep: 'Exit pupil', ratio: 'Focal ratio', maxM: 'Highest useful magnification (≈ 2 × D in mm)', minM: 'Lowest useful magnification (7 mm exit pupil)', res: 'Resolving power (Dawes)' },
        run: (x) => {
            const M = (x.F * x.barlow) / x.f;
            const Dmm = x.D * 1000;

            return { value: num(M, 5), unit: '×', sub: `Exit pupil ${num(Dmm / M, 4)} mm`, rows: { ep: `${num(Dmm / M, 4)} mm`, ratio: `f/${num(x.F / x.D, 4)}`, maxM: `${num(2 * Dmm, 4)} ×`, minM: `${num(Dmm / 7, 4)} ×`, res: `${num(116 / Dmm, 3)}″` }, steps: ['M = F × Barlow ÷ f', `= ${num(x.F * 1000)} × ${num(x.barlow)} ÷ ${num(x.f * 1000)} = ${num(M)} ×`] };
        },
    },
    thin_film: {
        type: 'calc',
        inputs: { n1: ['Film index', null, null, 1.38, 1], t: ['Film thickness', 'length', 'nm', 99.64], ns: ['Substrate index', null, null, 1.52, 1], n0: ['Surrounding medium index', null, null, 1, 1], lambda: ['Wavelength', 'length', 'nm', 550] },
        label: 'Reflectance at that wavelength',
        rows: { bare: 'Bare substrate reflectance', qw: 'Quarter-wave thickness for this wavelength', ideal: 'Ideal film index √(n₀ n_s)', min: 'Lowest reflectance in 380–780 nm' },
        plots: [['curve', 'Reflectance across the visible spectrum']],
        run: (x) => {
            const r01 = (x.n0 - x.n1) / (x.n0 + x.n1);
            const r12 = (x.n1 - x.ns) / (x.n1 + x.ns);
            const R = (l) => {
                const c = Math.cos((4 * Math.PI * x.n1 * x.t) / l);

                return (r01 * r01 + r12 * r12 + 2 * r01 * r12 * c) / (1 + r01 * r01 * r12 * r12 + 2 * r01 * r12 * c);
            };
            const series = Array.from({ length: 201 }, (_, k) => {
                const l = (380 + 2 * k) * 1e-9;

                return [l * 1e9, R(l) * 100];
            });
            const min = series.reduce((a, b) => (b[1] < a[1] ? b : a));

            return { value: num(R(x.lambda) * 100, 5), unit: '%', sub: `Bare substrate ${num(((x.n0 - x.ns) / (x.n0 + x.ns)) ** 2 * 100, 4)}%`, rows: { bare: `${num(((x.n0 - x.ns) / (x.n0 + x.ns)) ** 2 * 100, 4)}%`, qw: `${num((x.lambda / (4 * x.n1)) * 1e9)} nm`, ideal: num(Math.sqrt(x.n0 * x.ns), 4), min: `${num(min[1], 4)}% at ${num(min[0], 4)} nm` }, steps: ['Single layer at normal incidence: r = (r₀₁ + r₁₂e^(−2iδ)) ÷ (1 + r₀₁r₁₂e^(−2iδ)), δ = 2πn₁t ÷ λ', `r₀₁ = ${num(r01)}, r₁₂ = ${num(r12)}`, `R = ${num(R(x.lambda) * 100)}%`], plots: { curve: { series, axes: true, xLabel: 'Wavelength (nm)', yLabel: 'Reflectance (%)' } } };
        },
    },
    thin_lens: imaging('lens'),
    critical_angle: {
        type: 'calc',
        inputs: { ...medium('m1', 'Dense medium (light inside)', 'water'), ...medium('m2', 'Outside medium', 'air') },
        show: mediumShow('m1', 'm2'),
        when: mediumWhen('m1', 'm2'),
        data: ['refractive'],
        out: 'angle',
        outUnit: 'deg',
        label: 'Critical angle',
        rows: { cone: 'Escape cone (full angle)', n: 'Refractive indices' },
        run: (x, ctx) => {
            const n1 = nOf(x, ctx, 'm1');
            const n2 = nOf(x, ctx, 'm2');

            if (!(n1 > n2)) {
                return { error: 'Total internal reflection needs light inside the denser medium (n₁ > n₂).' };
            }

            const tc = Math.asin(n2 / n1);

            return { value: tc, sub: 'Beyond this angle all light is reflected', rows: { cone: `${num((2 * tc) / D)}°`, n: `n₁ = ${num(n1)}, n₂ = ${num(n2)}` }, steps: [`sin θ_c = n₂ ÷ n₁ = ${num(n2)} ÷ ${num(n1)}`, `θ_c = ${num(tc / D)}°`] };
        },
    },
    numerical_aperture: {
        type: 'calc',
        inputs: { n1: ['Core index', null, null, 1.4682, 1], n2: ['Cladding index', null, null, 1.4629, 1], n0: ['Outside medium index', null, null, 1, 1], a: ['Core diameter (optional)', 'length', 'um', 8.2], lambda: ['Wavelength (optional)', 'length', 'nm', 1310] },
        optional: ['a', 'lambda'],
        label: 'Numerical aperture',
        rows: { half: 'Acceptance half-angle', full: 'Acceptance cone (full angle)', V: 'V-number', modes: 'Guiding' },
        run: (x) => {
            if (!(x.n1 > x.n2)) {
                return { error: 'The core index must be higher than the cladding index.' };
            }

            const NA = Math.sqrt(x.n1 ** 2 - x.n2 ** 2);
            const half = NA < x.n0 ? Math.asin(NA / x.n0) : Math.PI / 2;
            const V = Number.isFinite(x.a) && Number.isFinite(x.lambda) ? (Math.PI * x.a * NA) / x.lambda : NaN;

            return { value: num(NA, 5), sub: `Accepts light within ±${num(half / D)}°`, rows: { half: `${num(half / D)}°`, full: `${num((2 * half) / D)}°`, V: Number.isFinite(V) ? num(V, 4) : 'Enter the core diameter and wavelength', modes: Number.isFinite(V) ? (V < 2.405 ? 'Single-mode (V < 2.405)' : `Multimode, about ${num(V * V / 2, 3)} modes`) : 'Enter the core diameter and wavelength' }, steps: ['NA = √(n₁² − n₂²)', `= ${num(NA)}`, ...(Number.isFinite(V) ? [`V = πa NA ÷ λ = ${num(V)}`] : [])] };
        },
    },
    two_lens: {
        type: 'calc',
        inputs: { f1: ['First lens focal length', 'length', 'cm', 10], f2: ['Second lens focal length', 'length', 'cm', 15], d: ['Separation', 'length', 'cm', 40], o: ['Object distance from the first lens', 'length', 'cm', 20] },
        out: 'length',
        outUnit: 'cm',
        label: 'Final image distance from the second lens',
        rows: { i1: ['Image from lens 1', 'length'], m: 'Total magnification', feq: ['Equivalent focal length', 'length'], image: 'Final image' },
        run: (x) => {
            const i1 = (x.f1 * x.o) / (x.o - x.f1);
            const o2 = x.d - i1;
            const i2 = (x.f2 * o2) / (o2 - x.f2);
            const m = (-i1 / x.o) * (-i2 / o2);
            const feq = (x.f1 * x.f2) / (x.f1 + x.f2 - x.d);

            if (!Number.isFinite(i1) || !Number.isFinite(i2)) {
                return { error: 'An image forms at infinity (the object is at a focal point).' };
            }

            return { value: i2, sub: `Magnification ${num(m)} ×`, rows: { i1: [i1, 'length'], m: `${num(m)} ×`, feq: [feq, 'length'], image: `${i2 > 0 ? 'Real' : 'Virtual'}, ${m < 0 ? 'inverted' : 'upright'}` }, steps: [`Lens 1: dᵢ₁ = f₁dₒ ÷ (dₒ − f₁) = ${num(i1 * 100)} cm`, `Object for lens 2: dₒ₂ = d − dᵢ₁ = ${num(o2 * 100)} cm${o2 < 0 ? ' (virtual object)' : ''}`, `Lens 2: dᵢ₂ = ${num(i2 * 100)} cm`, `m = m₁m₂ = ${num(m)}`] };
        },
    },

    // Acoustics ----------------------------------------------------------------------------------
    acoustic_impedance: pw({ vars: { Z: ['Acoustic impedance (Pa·s/m, rayl)', null, null, 1479036], rho: ['Density', 'density', 'kgm3', 998], c: ['Speed of sound', 'speed', 'ms', 1482] }, out: 'Z', exp: { rho: 1, c: 1 }, eq: 'Z = ρ c', forms: { Z: 'Z = ρc', rho: 'ρ = Z ÷ c', c: 'c = Z ÷ ρ' }, rows: { mrayl: 'In MRayl', air: 'Sound reflected at a boundary with air (413 rayl)' }, extra: (v) => ({ mrayl: `${num(v.Z / 1e6)} MRayl`, air: `${num(((v.Z - 413) / (v.Z + 413)) ** 2 * 100, 5)}% of the energy` }) }),
    alfven: {
        type: 'calc',
        inputs: { B: ['Magnetic field', 'magnetic_field', 'nt', 5], n: ['Ion number density (per cm³)', null, null, 5, 0], m: ['Ion mass', 'particle_mass', 'u', 1.00727647] },
        out: 'speed',
        outUnit: 'kms',
        label: 'Alfvén speed',
        rows: { rho: 'Mass density', beta: 'Fraction of c' },
        run: (x) => {
            const rho = x.n * 1e6 * x.m;
            const v = x.B / Math.sqrt(K.mu0 * rho);

            return { value: v, sub: 'v_A = B ÷ √(μ₀ρ)', rows: { rho: `${num(rho)} kg/m³`, beta: `${num(v / K.c)} c${v > 0.1 * K.c ? ' (relativistic: use v_A ÷ √(1 + v_A²/c²))' : ''}` }, steps: [`ρ = n m = ${num(x.n)} × 10⁶ m⁻³ × ${num(x.m)} kg = ${num(rho)} kg/m³`, `v_A = ${num(x.B)} T ÷ √(μ₀ × ${num(rho)}) = ${num(v / 1000)} km/s`] };
        },
    },
    beat: {
        type: 'calc',
        inputs: { f1: ['First frequency', 'frequency_hz', 'hz', 440], f2: ['Second frequency', 'frequency_hz', 'hz', 444] },
        out: 'frequency_hz',
        outUnit: 'hz',
        label: 'Beat frequency',
        rows: { T: ['Time between beats', 'short_time'], avg: 'Tone you hear', cents: 'Difference in cents' },
        run: (x) => ({ value: Math.abs(x.f1 - x.f2), sub: `${num(Math.abs(x.f1 - x.f2))} beats per second`, rows: { T: [1 / Math.abs(x.f1 - x.f2), 'short_time'], avg: `${num((x.f1 + x.f2) / 2)} Hz`, cents: `${num(1200 * Math.log2(x.f2 / x.f1), 4)} cents` }, steps: [`f_beat = |f₁ − f₂| = |${num(x.f1)} − ${num(x.f2)}| = ${num(Math.abs(x.f1 - x.f2))} Hz`] }),
    },
    critical_damping: pw({ vars: { cc: ['Critical damping coefficient (N·s/m)', null, null, 20], k: ['Spring constant', 'stiffness', 'npm', 100], m: ['Mass', 'mass', 'kg', 1] }, out: 'cc', k: 2, exp: { k: 0.5, m: 0.5 }, eq: 'c_c = 2 √(k m)', forms: { cc: 'c_c = 2√(km)', k: 'k = c_c² ÷ 4m', m: 'm = c_c² ÷ 4k' }, rows: { wn: 'Natural frequency' }, extra: (v) => ({ wn: `${num(Math.sqrt(v.k / v.m))} rad/s (${num(Math.sqrt(v.k / v.m) / (2 * Math.PI))} Hz)` }) }),
    db: {
        type: 'calc',
        inputs: { mode: ['Calculate', 'select', { power: 'Decibels from a power ratio', amp: 'Decibels from an amplitude ratio', back: 'Ratios from decibels', add: 'Add sound levels' }, 'power'], ratio: ['Ratio', null, null, 100, 0], dB: ['Decibels', null, null, 3], levels: ['Levels in dB (one per line or comma separated)', 'textarea', null, '80, 80, 75'] },
        show: { ratio: 'mode:power,amp', dB: 'mode:back', levels: 'mode:add' },
        when: { ratio: (x) => x.mode === 'power' || x.mode === 'amp', dB: (x) => x.mode === 'back' },
        label: 'Decibels',
        rows: { p: 'Power ratio', a: 'Amplitude ratio' },
        run: (x) => {
            if (x.mode === 'add') {
                const list = String(x.levels).split(/[\n,;]+/).map((s) => Number(s.trim())).filter((v) => Number.isFinite(v));

                if (!list.length) {
                    return { empty: 'Enter the sound levels to add.' };
                }

                const L = 10 * Math.log10(list.reduce((s, l) => s + 10 ** (l / 10), 0));

                return { value: num(L, 5), unit: 'dB', label: 'Combined level', sub: `${list.length} sources added on an energy basis`, rows: { p: `${num(10 ** (L / 10))} × the reference`, a: 'Not used when adding levels' }, steps: ['L = 10 log₁₀ Σ 10^(Lᵢ/10)', `= ${num(L)} dB`, 'Two equal sources add 3 dB'] };
            }

            const dB = x.mode === 'back' ? x.dB : x.mode === 'power' ? 10 * Math.log10(x.ratio) : 20 * Math.log10(x.ratio);

            if (!Number.isFinite(dB)) {
                return { error: 'The ratio must be positive.' };
            }

            return { value: num(dB, 5), unit: 'dB', sub: `Power × ${num(10 ** (dB / 10))}, amplitude × ${num(10 ** (dB / 20))}`, rows: { p: `${num(10 ** (dB / 10))}`, a: `${num(10 ** (dB / 20))}` }, steps: ['Power: L = 10 log₁₀(P ÷ P₀); amplitude (voltage, pressure): L = 20 log₁₀(A ÷ A₀)', `= ${num(dB)} dB`] };
        },
    },
    db_gain: {
        type: 'calc',
        inputs: { kind: ['Measure', 'select', { v: 'Voltages', p: 'Powers' }, 'v'], vin: ['Input voltage', 'voltage', 'mv', 100], vout: ['Output voltage', 'voltage', 'v', 2], pin: ['Input power', 'power', 'milliwatt', 1], pout: ['Output power', 'power', 'w', 1] },
        show: { vin: 'kind:v', vout: 'kind:v', pin: 'kind:p', pout: 'kind:p' },
        when: { vin: (x) => x.kind === 'v', vout: (x) => x.kind === 'v', pin: (x) => x.kind === 'p', pout: (x) => x.kind === 'p' },
        label: 'Gain',
        rows: { ratio: 'Gain as a ratio', type: 'Type' },
        run: (x) => {
            const r = x.kind === 'v' ? x.vout / x.vin : x.pout / x.pin;
            const g = (x.kind === 'v' ? 20 : 10) * Math.log10(r);

            if (!Number.isFinite(g)) {
                return { error: 'Both values must be positive.' };
            }

            return { value: num(g, 5), unit: 'dB', sub: `× ${num(r)} ${x.kind === 'v' ? 'in voltage' : 'in power'}`, rows: { ratio: `${num(r)} ×`, type: g >= 0 ? 'Amplification' : 'Attenuation (loss)' }, steps: [x.kind === 'v' ? 'G = 20 log₁₀(V_out ÷ V_in) (same impedance)' : 'G = 10 log₁₀(P_out ÷ P_in)', `= ${num(g)} dB`] };
        },
    },
    distance_attenuation: {
        type: 'calc',
        inputs: { L1: ['Sound level at the first distance (dB)', null, null, 90], r1: ['First distance', 'length', 'm', 1], r2: ['Second distance', 'length', 'm', 10], src: ['Source', 'select', { point: 'Point source (spreads in all directions)', line: 'Line source (busy road, pipe)' }, 'point'] },
        label: 'Level at the second distance',
        rows: { change: 'Change', rule: 'Rule of thumb' },
        run: (x) => {
            const dL = (x.src === 'point' ? 20 : 10) * Math.log10(x.r2 / x.r1);

            return { value: num(x.L1 - dL, 5), unit: 'dB', sub: `${num(-dL, 4)} dB`, rows: { change: `${num(-dL, 4)} dB`, rule: x.src === 'point' ? '−6 dB per doubling of distance' : '−3 dB per doubling of distance' }, steps: [`ΔL = ${x.src === 'point' ? 20 : 10} log₁₀(r₂ ÷ r₁) = ${num(dL)} dB`, 'Free field: ground, walls and air absorption change real results'] };
        },
    },
    doppler: {
        type: 'calc',
        inputs: { kind: ['Wave', 'select', { sound: 'Sound (or any wave in a medium)', light: 'Light (relativistic)' }, 'sound'], f: ['Emitted frequency', 'frequency_hz', 'hz', 440], c: ['Wave speed in the medium', 'speed', 'ms', 343], vs: ['Source speed toward the observer', 'speed', 'kmh', 100], vo: ['Observer speed toward the source', 'speed', 'kmh', 0], v: ['Relative speed (positive = moving apart)', 'speed', 'kms', 1000] },
        show: { c: 'kind:sound', vs: 'kind:sound', vo: 'kind:sound', v: 'kind:light' },
        when: { c: (x) => x.kind === 'sound', vs: (x) => x.kind === 'sound', vo: (x) => x.kind === 'sound', v: (x) => x.kind === 'light' },
        out: 'frequency_hz',
        outUnit: 'hz',
        label: 'Observed frequency',
        rows: { shift: 'Shift', after: 'After passing (moving apart)', z: 'Redshift z' },
        run: (x) => {
            if (x.kind === 'light') {
                const b = x.v / K.c;

                if (!(Math.abs(b) < 1)) {
                    return { error: 'The speed must be below the speed of light.' };
                }

                const fo = x.f * Math.sqrt((1 - b) / (1 + b));

                return { value: fo, sub: b > 0 ? 'Redshifted (moving apart)' : 'Blueshifted (approaching)', rows: { shift: `${num(((fo - x.f) / x.f) * 100)}%`, after: 'Same formula with the sign of v reversed', z: num(x.f / fo - 1) }, steps: ['f′ = f √((1 − β) ÷ (1 + β)), β = v ÷ c', `= ${num(fo)} Hz`] };
            }

            if (!(x.vs < x.c)) {
                return { error: 'The source is at or above the wave speed: a shock (sonic boom) forms instead.' };
            }

            const fo = (x.f * (x.c + x.vo)) / (x.c - x.vs);
            const away = (x.f * (x.c - x.vo)) / (x.c + x.vs);

            return { value: fo, sub: `${num(fo - x.f)} Hz higher while approaching`, rows: { shift: `${num(((fo - x.f) / x.f) * 100)}%`, after: `${num(away)} Hz`, z: 'Only for light' }, steps: ['f′ = f (c + v_o) ÷ (c − v_s)', `= ${num(x.f)} × (${num(x.c)} + ${num(x.vo)}) ÷ (${num(x.c)} − ${num(x.vs)}) = ${num(fo)} Hz`] };
        },
    },
    freq_converter: {
        type: 'calc',
        inputs: { value: ['Value', null, null, 50, 0], from: ['Given as', 'select', { hz: 'Frequency (Hz)', khz: 'Frequency (kHz)', mhz: 'Frequency (MHz)', ghz: 'Frequency (GHz)', s: 'Period (s)', ms: 'Period (ms)', us: 'Period (µs)', w: 'Angular frequency (rad/s)', rpm: 'Revolutions per minute' }, 'hz'] },
        label: 'Frequency',
        rows: { T: 'Period', w: 'Angular frequency', rpm: 'Revolutions per minute', lambda: 'Wavelength of a radio wave', sound: 'Wavelength of sound in air (343 m/s)' },
        run: (x) => {
            const f = { hz: 1, khz: 1e3, mhz: 1e6, ghz: 1e9 }[x.from] ? x.value * { hz: 1, khz: 1e3, mhz: 1e6, ghz: 1e9 }[x.from] : { s: 1 / x.value, ms: 1e3 / x.value, us: 1e6 / x.value, w: x.value / (2 * Math.PI), rpm: x.value / 60 }[x.from];

            return { value: num(f), unit: 'Hz', sub: `Period ${num(1 / f)} s`, rows: { T: `${num(1 / f)} s`, w: `${num(2 * Math.PI * f)} rad/s`, rpm: `${num(f * 60)} rpm`, lambda: `${num(K.c / f)} m`, sound: `${num(343 / f)} m` }, steps: ['f = 1/T = ω/2π = rpm/60'] };
        },
    },
    helmholtz: {
        type: 'calc',
        inputs: { V: ['Cavity volume', 'volume', 'l', 0.75], d: ['Neck diameter', 'length', 'cm', 1.9], L: ['Neck length', 'length', 'cm', 7.6], end: ['End correction', 'select', { flanged: 'One flanged end and one free end (1.45 r)', both: 'Both ends flanged (1.7 r)', none: 'None' }, 'flanged'], T: ['Air temperature', 'temperature', 'c', 20] },
        out: 'frequency_hz',
        outUnit: 'hz',
        label: 'Resonant frequency',
        rows: { c: ['Speed of sound used', 'speed'], Leff: ['Effective neck length', 'length'], note: 'Nearest musical note' },
        run: (x) => {
            const c = Math.sqrt((1.4 * K.R * x.T) / 0.0289647);
            const r = x.d / 2;
            const A = Math.PI * r * r;
            const Leff = x.L + { flanged: 1.45, both: 1.7, none: 0 }[x.end] * r;
            const f = (c / (2 * Math.PI)) * Math.sqrt(A / (x.V * Leff));
            const names = ['A', 'A♯', 'B', 'C', 'C♯', 'D', 'D♯', 'E', 'F', 'F♯', 'G', 'G♯'];
            const n = Math.round(12 * Math.log2(f / 440));
            const octave = Math.floor((n + 9) / 12) + 4;

            return { value: f, sub: `Effective neck ${num(Leff * 100)} cm`, rows: { c: [c, 'speed'], Leff: [Leff, 'length'], note: `${names[((n % 12) + 12) % 12]}${octave} (${num(440 * 2 ** (n / 12), 5)} Hz)` }, steps: ['f = (c ÷ 2π) √(A ÷ V L_eff)', `A = ${num(A * 1e4)} cm², V = ${num(x.V * 1000)} L, L_eff = ${num(Leff * 100)} cm`, `f = ${num(f)} Hz`] };
        },
    },
    modulation: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { amp: 'Carrier and message amplitudes', env: 'Envelope maximum and minimum' }, 'env'], Am: ['Message amplitude', null, null, 0.5, 0], Ac: ['Carrier amplitude', null, null, 1, 0], max: ['Envelope maximum', null, null, 1.5, 0], min: ['Envelope minimum', null, null, 0.5, 0] },
        show: { Am: 'mode:amp', Ac: 'mode:amp', max: 'mode:env', min: 'mode:env' },
        when: { Am: (x) => x.mode === 'amp', Ac: (x) => x.mode === 'amp', max: (x) => x.mode === 'env', min: (x) => x.mode === 'env' },
        label: 'Modulation index',
        rows: { pct: 'Modulation depth', side: 'Power in the sidebands', total: 'Total power ÷ carrier power', status: 'Status' },
        run: (x) => {
            const m = x.mode === 'amp' ? x.Am / x.Ac : (x.max - x.min) / (x.max + x.min);

            return { value: num(m, 5), sub: `${num(m * 100)}% modulation`, rows: { pct: `${num(m * 100)}%`, side: `${num(((m * m) / (2 + m * m)) * 100)}% of the total`, total: num(1 + (m * m) / 2), status: m > 1 ? 'Over-modulated: the envelope distorts' : m === 1 ? 'Full modulation' : 'Normal' }, steps: [x.mode === 'amp' ? 'm = A_m ÷ A_c' : 'm = (A_max − A_min) ÷ (A_max + A_min)', `= ${num(m)}`, 'P_total = P_c (1 + m² ÷ 2)'] };
        },
    },
    reverberation: {
        type: 'calc',
        inputs: { L: ['Room length', 'length', 'm', 8], W: ['Room width', 'length', 'm', 6], H: ['Room height', 'length', 'm', 3], band: ['Frequency band', 'select', BANDS, '2'], floor: ['Floor', 'select', 'data:absorption:fixed', 'wood_floor'], ceiling: ['Ceiling', 'select', 'data:absorption:fixed', 'plaster'], walls: ['Walls', 'select', 'data:absorption:fixed', 'gypsum'], glass: ['Window area (part of the walls)', 'area', 'm2', 6], people: ['People in the room', null, null, 0, 0] },
        data: ['absorption'],
        out: 'time',
        outUnit: 's',
        label: 'Reverberation time RT60 (Sabine)',
        rows: { eyring: ['Eyring RT60 (better for absorbent rooms)', 'time'], A: 'Total absorption', V: ['Room volume', 'volume'], alpha: 'Average absorption coefficient', target: 'Typical targets' },
        run: (x, ctx) => {
            const ab = ctx.c.data.physics.absorption;
            const b = Number(x.band);
            const S = { floor: x.L * x.W, ceiling: x.L * x.W, walls: 2 * (x.L + x.W) * x.H };
            const glass = Math.min(x.glass, S.walls);
            const A = S.floor * ab[x.floor].a[b] + S.ceiling * ab[x.ceiling].a[b] + (S.walls - glass) * ab[x.walls].a[b] + glass * ab.glass.a[b] + x.people * [0.25, 0.35, 0.42, 0.46, 0.5, 0.5][b];
            const V = x.L * x.W * x.H;
            const total = S.floor + S.ceiling + S.walls;
            const alpha = A / total;
            const rt = (0.161 * V) / A;
            const eyring = (0.161 * V) / (-total * Math.log(1 - Math.min(alpha, 0.99)));

            return { value: rt, sub: `At ${BANDS[x.band]}; total absorption ${num(A)} m² sabins`, rows: { eyring: [eyring, 'time'], A: `${num(A)} m² (metric sabins)`, V: [V, 'volume'], alpha: num(alpha, 4), target: 'Speech/classroom 0.4–0.8 s, home cinema 0.3–0.5 s, concert hall 1.6–2.2 s' }, steps: ['A = Σ Sᵢαᵢ (+ about 0.4 m² per person at mid frequencies)', `V = ${num(V)} m³, A = ${num(A)} m²`, `Sabine RT60 = 0.161V ÷ A = ${num(rt)} s`, `Eyring RT60 = 0.161V ÷ (−S ln(1 − ᾱ)) = ${num(eyring)} s`] };
        },
    },
    absorption_coef: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { energy: 'Incident and absorbed sound energy', reflected: 'Incident and reflected sound energy', material: 'The material' }, 'energy'], Ei: ['Incident energy (any unit)', null, null, 100, 0], Ea: ['Absorbed energy (same unit)', null, null, 35, 0], Er: ['Reflected energy (same unit)', null, null, 65, 0], mat: ['Material', 'select', 'data:absorption:fixed', 'carpet_pad'], band: ['Frequency band', 'select', BANDS, '2'] },
        show: { Ei: 'mode:energy,reflected', Ea: 'mode:energy', Er: 'mode:reflected', mat: 'mode:material', band: 'mode:material' },
        when: { Ei: (x) => x.mode !== 'material', Ea: (x) => x.mode === 'energy', Er: (x) => x.mode === 'reflected' },
        data: ['absorption'],
        label: 'Absorption coefficient α',
        rows: { refl: 'Reflected share', nrc: 'Noise reduction coefficient (NRC)', bands: 'All bands (125 Hz–4 kHz)' },
        run: (x, ctx) => {
            if (x.mode === 'material') {
                const m = ctx.c.data.physics.absorption[x.mat];
                const a = m.a[Number(x.band)];
                const nrc = Math.round(((m.a[1] + m.a[2] + m.a[3] + m.a[4]) / 4) * 20) / 20;

                return { value: num(a, 3), sub: `${m.name} at ${BANDS[x.band]} (typical published value)`, rows: { refl: `${num((1 - a) * 100, 3)}%`, nrc: nrc.toFixed(2), bands: m.a.map((v) => num(v, 2)).join(', ') }, steps: ['Typical values from architectural acoustics tables; product data can differ', 'NRC = average of the 250, 500, 1,000 and 2,000 Hz values, rounded to 0.05'] };
            }

            const a = x.mode === 'energy' ? x.Ea / x.Ei : 1 - x.Er / x.Ei;

            if (!(a >= 0 && a <= 1)) {
                return { error: 'The absorbed (or reflected) energy must be between 0 and the incident energy.' };
            }

            return { value: num(a, 4), sub: `${num(a * 100)}% absorbed`, rows: { refl: `${num((1 - a) * 100)}%`, nrc: 'Pick a material to see it', bands: 'Pick a material to see them' }, steps: [x.mode === 'energy' ? 'α = E_absorbed ÷ E_incident' : 'α = 1 − E_reflected ÷ E_incident', `= ${num(a)}`] };
        },
    },
    sound_wavelength: {
        type: 'calc',
        inputs: { f: ['Frequency', 'frequency_hz', 'hz', 1000], ...speedInputs },
        show: speedShow,
        when: speedWhen,
        data: ['sound_media'],
        out: 'length',
        outUnit: 'cm',
        label: 'Wavelength',
        rows: { c: ['Speed of sound', 'speed'], T: ['Period', 'short_time'] },
        run: (x, ctx) => {
            const c = mediumSpeed(x, ctx);

            return { value: c / x.f, sub: `c = ${num(c)} m/s`, rows: { c: [c, 'speed'], T: [1 / x.f, 'short_time'] }, steps: [`λ = c ÷ f = ${num(c)} ÷ ${num(x.f)} = ${num(c / x.f)} m`] };
        },
    },
    speed_sound: {
        type: 'calc',
        inputs: { med: ['Medium', 'select', 'data:sound_media:fixed', 'air'], T: ['Temperature (gases)', 'temperature', 'c', 20] },
        show: { T: 'med:air,nitrogen,oxygen,helium,hydrogen,co2,methane' },
        data: ['sound_media'],
        out: 'speed',
        outUnit: 'ms',
        label: 'Speed of sound',
        rows: { kmh: 'In km/h and mph', km: 'Time to travel 1 km', lambda: 'Wavelength at 1 kHz', thunder: 'Thunder rule' },
        run: (x, ctx) => {
            const m = ctx.c.data.physics.sound_media[x.med];
            const c = soundSpeed(ctx.c.data.physics.sound_media, x.med, x.T);

            return { value: c, sub: m.speed ? `${m.name}: tabulated value` : `${m.name} at ${num(x.T - 273.15)} °C (ideal gas)`, rows: { kmh: `${num(c * 3.6)} km/h, ${num(c / 0.44704)} mph`, km: `${num(1000 / c)} s`, lambda: `${num(c / 1000)} m`, thunder: x.med === 'air' ? `Count seconds and divide by ${num(1000 / c, 3)} for km` : 'Only for air' }, steps: m.speed ? [`${m.name}: c ≈ ${num(c)} m/s`] : ['c = √(γRT ÷ M)', `= √(${num(m.gamma)} × 8.31446 × ${num(x.T)} ÷ ${num(m.molar / 1000)}) = ${num(c)} m/s`, 'Humidity raises the speed in air by under 0.5%'] };
        },
    },
    solid_sound: {
        type: 'calc',
        inputs: { mat: ['Material', 'select', 'data:solids', 'steel'], E: ["Young's modulus", 'pressure', 'gpa', 200], rho: ['Density', 'density', 'kgm3', 7850], nu: ["Poisson's ratio", null, null, 0.29, 0] },
        show: { E: 'mat:custom', rho: 'mat:custom', nu: 'mat:custom' },
        when: { E: (x) => x.mat === 'custom', rho: (x) => x.mat === 'custom', nu: (x) => x.mat === 'custom' },
        data: ['solids'],
        out: 'speed',
        outUnit: 'ms',
        label: 'Longitudinal (P-wave) speed',
        rows: { shear: ['Shear (S-wave) speed', 'speed'], bar: ['Thin-rod speed √(E/ρ)', 'speed'], Z: 'Acoustic impedance', props: 'Properties used' },
        run: (x, ctx) => {
            const m = x.mat === 'custom' ? { E: x.E, density: x.rho, nu: x.nu } : { ...ctx.c.data.physics.solids[x.mat], E: ctx.c.data.physics.solids[x.mat].E * 1e9 };

            if (!(m.nu >= 0 && m.nu < 0.5)) {
                return { error: "Poisson's ratio must be between 0 and 0.5." };
            }

            const cl = Math.sqrt((m.E * (1 - m.nu)) / (m.density * (1 + m.nu) * (1 - 2 * m.nu)));
            const cs = Math.sqrt(m.E / (2 * m.density * (1 + m.nu)));

            return { value: cl, sub: `Shear waves ${num(cs)} m/s`, rows: { shear: [cs, 'speed'], bar: [Math.sqrt(m.E / m.density), 'speed'], Z: `${num((m.density * cl) / 1e6)} MRayl`, props: `E = ${num(m.E / 1e9)} GPa, ρ = ${num(m.density)} kg/m³, ν = ${num(m.nu)}` }, steps: ['c_L = √(E(1 − ν) ÷ ρ(1 + ν)(1 − 2ν))', `= ${num(cl)} m/s`, 'c_S = √(E ÷ 2ρ(1 + ν))', `= ${num(cs)} m/s`] };
        },
    },
    standing_wave: {
        type: 'calc',
        inputs: { L: ['String length', 'length', 'cm', 64.8], mode: ['I know', 'select', { tension: 'Tension and linear density', speed: 'The wave speed' }, 'tension'], T: ['Tension', 'force', 'n', 73], mu: ['Linear density (g/m)', null, null, 0.401, 0], v: ['Wave speed', 'speed', 'ms', 427], n: ['Harmonics to list', null, null, 6, 1] },
        show: { T: 'mode:tension', mu: 'mode:tension', v: 'mode:speed' },
        when: { T: (x) => x.mode === 'tension', mu: (x) => x.mode === 'tension', v: (x) => x.mode === 'speed' },
        out: 'frequency_hz',
        outUnit: 'hz',
        label: 'Fundamental frequency',
        rows: { v: ['Wave speed', 'speed'], list: 'Harmonics', lambda: ['Fundamental wavelength (2L)', 'length'] },
        run: (x) => {
            const v = x.mode === 'speed' ? x.v : Math.sqrt(x.T / (x.mu / 1000));
            const f1 = v / (2 * x.L);

            return { value: f1, sub: `Wave speed ${num(v)} m/s`, rows: { v: [v, 'speed'], list: harmonics(Array.from({ length: Math.min(20, Math.round(x.n)) }, (_, k) => (k + 1) * f1)), lambda: [2 * x.L, 'length'] }, steps: [...(x.mode === 'tension' ? [`v = √(T ÷ μ) = √(${num(x.T)} ÷ ${num(x.mu / 1000)}) = ${num(v)} m/s`] : []), `fₙ = n v ÷ 2L, f₁ = ${num(f1)} Hz`] };
        },
    },
    pipe_resonance: {
        type: 'calc',
        inputs: { L: ['Pipe length', 'length', 'cm', 50], ends: ['Ends', 'select', { open: 'Open at both ends', closed: 'Closed at one end' }, 'open'], d: ['Inner diameter (for the end correction, optional)', 'length', 'cm', 2], T: ['Air temperature', 'temperature', 'c', 20], n: ['Resonances to list', null, null, 5, 1] },
        optional: ['d'],
        out: 'frequency_hz',
        outUnit: 'hz',
        label: 'Fundamental frequency',
        rows: { c: ['Speed of sound', 'speed'], list: 'Resonances', Leff: ['Effective length', 'length'] },
        run: (x) => {
            const c = Math.sqrt((1.4 * K.R * x.T) / 0.0289647);
            const r = Number.isFinite(x.d) ? x.d / 2 : 0;
            const open = x.ends === 'open';
            const Leff = x.L + (open ? 2 : 1) * 0.6 * r;
            const f1 = open ? c / (2 * Leff) : c / (4 * Leff);
            const list = Array.from({ length: Math.min(20, Math.round(x.n)) }, (_, k) => (open ? (k + 1) : 2 * k + 1) * f1);

            return { value: f1, sub: open ? 'All harmonics present' : 'Only odd harmonics', rows: { c: [c, 'speed'], list: harmonics(list), Leff: [Leff, 'length'] }, steps: [`c = ${num(c)} m/s at this temperature`, `End correction 0.6r per open end: L_eff = ${num(Leff * 100)} cm`, open ? `fₙ = nc ÷ 2L = ${num(f1)} Hz × n` : `fₙ = (2n − 1)c ÷ 4L = ${num(f1)} Hz × (1, 3, 5 …)`] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
