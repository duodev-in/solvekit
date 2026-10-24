import { defineTools } from '../engines/formula.js';
import { formatMoney } from '../currency.js';
import { handlersFor } from '../physics/core.js';
import { clock, sunTimes } from '../physics/sun.js';
import { N, SEL, LINE, num, pct } from '../statistics/common.js';
import { contrast, parseColor } from '../tech/bits.js';
import { duration } from '../tech/net.js';

/**
 * Photography and video: lens optics (field of view, depth of field, hyperfocal distance, crop factor), exposure,
 * SMPTE timecode (with drop-frame), aspect ratios, screen and print sizes, file sizes, projectors and TVs, time
 * lapse and golden hour. Lengths arrive in metres via the Physics engine.
 */

const MM = (label, value) => [label, null, null, value, 0];
const DIST = (label, value, unit = 'm') => [label, 'length', unit, value];
const SENSOR = SEL('Sensor', 'data:sensors', 'ff');
const FF_DIAG = Math.hypot(36, 24);

/** Sensor width, height (mm) from the preset or the custom fields. */
function sensorOf(x, ctx) {
    const s = ctx.c.data.technology?.sensors?.[x.sensor];

    return s && x.sensor !== 'custom' ? { w: s.w, h: s.h, name: s.name } : { w: x.sw, h: x.sh, name: 'Custom sensor' };
}

const SENSOR_FIELDS = { sensor: SENSOR, sw: MM('Sensor width (mm)', 36), sh: MM('Sensor height (mm)', 24) };
const SENSOR_SHOW = { sw: 'sensor:custom', sh: 'sensor:custom' };
const SENSOR_WHEN = { sw: (x) => x.sensor === 'custom', sh: (x) => x.sensor === 'custom' };

const deg = (r) => (r * 180) / Math.PI;
const lengthText = (m) => (m === Infinity ? '∞' : m >= 1 ? `${num(m, 4)} m (${num(m / 0.3048, 4)} ft)` : `${num(m * 100, 4)} cm (${num(m / 0.0254, 4)} in)`);
const gcd = (a, b) => (b ? gcd(b, a % b) : a);

/** Simplified ratio of two integers, e.g. 1920 × 1080 → "16:9". */
function ratioText(w, h) {
    if (Number.isInteger(w) && Number.isInteger(h) && w > 0 && h > 0) {
        const g = gcd(w, h);

        return `${w / g}:${h / g}`;
    }

    return `${num(w / h, 4)}:1`;
}

/** Parses "16:9", "1.85:1", "4/3" or a decimal into a number. */
function parseRatio(text) {
    const m = String(text ?? '').trim().match(/^(\d+(?:\.\d+)?)\s*[:/x×]\s*(\d+(?:\.\d+)?)$/i);

    if (m) {
        return Number(m[1]) / Number(m[2]);
    }

    const v = Number(text);

    return v > 0 ? v : NaN;
}

/** SMPTE timecode helpers (ST 12-1): drop-frame at 29.97 and 59.94 fps. */
const RATES = { '23.976': [24000 / 1001, 24, false], 24: [24, 24, false], 25: [25, 25, false], '29.97df': [30000 / 1001, 30, true], '29.97': [30000 / 1001, 30, false], 30: [30, 30, false], 50: [50, 50, false], '59.94df': [60000 / 1001, 60, true], '59.94': [60000 / 1001, 60, false], 60: [60, 60, false] };
const RATE_OPTIONS = { '23.976': '23.976 fps', 24: '24 fps', 25: '25 fps (PAL)', '29.97df': '29.97 fps drop-frame (NTSC)', '29.97': '29.97 fps non-drop', 30: '30 fps', 50: '50 fps', '59.94df': '59.94 fps drop-frame', '59.94': '59.94 fps non-drop', 60: '60 fps' };

export function framesToTimecode(frames, rate) {
    const [, nominal, df] = RATES[rate];
    let f = frames;

    if (df) {
        const drop = nominal === 30 ? 2 : 4;
        const perMin = nominal * 60 - drop;
        const per10 = nominal * 600 - 9 * drop;
        const d = Math.floor(f / per10);
        const m = f % per10;
        f += drop * 9 * d + (m > drop ? drop * Math.floor((m - drop) / perMin) : 0);
    }

    const ff = f % nominal;
    const s = Math.floor(f / nominal);
    const p = (n) => String(n).padStart(2, '0');

    return `${p(Math.floor(s / 3600))}:${p(Math.floor(s / 60) % 60)}:${p(s % 60)}${df ? ';' : ':'}${p(ff)}`;
}

export function timecodeToFrames(text, rate) {
    const m = String(text ?? '').trim().match(/^(\d{1,2})[:;.](\d{1,2})[:;.](\d{1,2})[:;.](\d{1,2})$/);

    if (!m) {
        return { problem: 'Write timecode as HH:MM:SS:FF (drop-frame uses ; before the frames).' };
    }

    const [hh, mm, ss, ff] = m.slice(1).map(Number);
    const [, nominal, df] = RATES[rate];

    if (mm > 59 || ss > 59 || ff >= nominal) {
        return { problem: `Minutes and seconds go to 59 and frames to ${nominal - 1} at this rate.` };
    }

    if (!df) {
        return { frames: (hh * 3600 + mm * 60 + ss) * nominal + ff };
    }

    const drop = nominal === 30 ? 2 : 4;

    if (ss === 0 && ff < drop && mm % 10 !== 0) {
        return { problem: `Frames 00–${String(drop - 1).padStart(2, '0')} do not exist at the start of minute ${mm} in drop-frame timecode.` };
    }

    const minutes = 60 * hh + mm;

    return { frames: (hh * 3600 + mm * 60 + ss) * nominal + ff - drop * (minutes - Math.floor(minutes / 10)) };
}

/** Circle of confusion (mm) from the sensor diagonal (d/1500, the common convention). */
const coc = (w, h) => Math.hypot(w, h) / 1500;

export const TOOLS = {
    render: {
        type: 'calc',
        inputs: { by: SEL('Length given as', { frames: 'Number of frames', time: 'Duration and frame rate' }, 'time'), frames: N('Frames', 1440, 1), seconds: N('Animation length (s)', 60, 0), fps: N('Frame rate (fps)', 24, 1), perFrame: N('Render time per frame (minutes)', 4, 0), machines: N('Machines (render nodes)', 1, 1), price: [`Price per machine-hour (cloud, optional)`, 'money', null, 0.9] },
        show: { frames: 'by:frames', seconds: 'by:time', fps: 'by:time' },
        when: { frames: (x) => x.by === 'frames', seconds: (x) => x.by === 'time', fps: (x) => x.by === 'time' },
        optional: ['price'],
        label: 'Total render time',
        rows: { frames: 'Frames', machineHours: 'Machine-hours', cost: 'Cloud cost' },
        run: (x) => {
            const frames = x.by === 'frames' ? x.frames : Math.ceil(x.seconds * x.fps);
            const hours = (frames * x.perFrame) / 60;

            return { value: duration((hours * 3600) / x.machines), sub: `${num(frames)} frames on ${x.machines} machine${x.machines > 1 ? 's' : ''}`, rows: { frames: num(frames), machineHours: num(hours, 5), cost: Number.isFinite(x.price) ? formatMoney(hours * x.price) : 'Enter a price' }, steps: ['Total = frames × time per frame ÷ machines', 'Render a few test frames: the slowest scenes set the schedule'] };
        },
    },
    aspect: {
        type: 'calc',
        inputs: { w: N('Width', 1920, 0), h: N('Height', 1080, 0), newW: N('New width (optional)', 1280, 0) },
        optional: ['newW'],
        label: 'Aspect ratio',
        rows: { decimal: 'As a decimal', newH: 'Height for the new width', css: 'CSS', name: 'Common name' },
        run: (x) => {
            if (!(x.w > 0 && x.h > 0)) {
                return { error: 'Enter a width and height above zero.' };
            }

            const r = x.w / x.h;
            const names = [[16 / 9, '16:9 (HD video, most screens)'], [4 / 3, '4:3 (classic TV, iPad)'], [16 / 10, '16:10 (laptops)'], [21 / 9, '21:9 (ultrawide; strictly 64:27)'], [3 / 2, '3:2 (35 mm photos)'], [1, '1:1 (square)'], [9 / 16, '9:16 (vertical video, stories)'], [4 / 5, '4:5 (Instagram portrait)'], [2.39, '2.39:1 (cinema scope)'], [1.85, '1.85:1 (cinema flat)']];
            const name = names.find(([v]) => Math.abs(v - r) < 0.005);

            return { value: ratioText(x.w, x.h), sub: `${num(x.w)} × ${num(x.h)}`, rows: { decimal: `${num(r, 6)}:1`, newH: x.newW > 0 ? num(x.newW / r, 6) : 'Enter a width', css: `aspect-ratio: ${ratioText(x.w, x.h).replace(':', ' / ')};`, name: name ? name[1] : 'Not a standard ratio' }, steps: ['Divide both sides by their greatest common divisor', 'Keep the ratio when resizing: new height = new width × height ÷ width'] };
        },
    },
    blink: {
        type: 'calc',
        inputs: { people: N('People in the photo', 20, 1), light: SEL('Light', { good: 'Good light (about 10 blinks a minute)', poor: 'Poor light (blink more often)' }, 'good'), blinkMs: N('Blink duration (ms)', 250, 0), shutter: N('Shutter speed (1/x s)', 125, 1) },
        label: 'Photos to take',
        rows: { pPhoto: 'Chance one photo is blink-free', for90: 'Photos for a 90% chance', rule: 'Barnes’s rule of thumb' },
        run: (x) => {
            const rate = (x.light === 'good' ? 10 : 15) / 60;
            const t = x.blinkMs / 1000 + 1 / x.shutter;
            const p = (1 - rate * t) ** x.people;

            if (!(rate * t < 1)) {
                return { error: 'Blink duration is too long for these values.' };
            }

            return { value: num(Math.ceil(1 / p), 4), sub: `On average, for ${x.people} people`, rows: { pPhoto: pct(p, 4), for90: num(Math.ceil(Math.log(0.1) / Math.log(1 - p))), rule: `About ${num(Math.ceil(x.people / (x.light === 'good' ? 3 : 2)))} (people ÷ ${x.light === 'good' ? 3 : 2})` }, steps: ['P(everyone’s eyes open) = (1 − x t)ⁿ, with x blinks per second, t blink plus exposure time, n people', 'Expected photos = 1 ÷ P (Piers Barnes and Nic Svenson, CSIRO, 2006)', 'The poor-light blink rate here is an assumption; the formula is the CSIRO one'] };
        },
    },
    fov: {
        type: 'calc',
        inputs: { ...SENSOR_FIELDS, f: MM('Focal length (mm)', 50), dist: DIST('Subject distance', 10) },
        show: SENSOR_SHOW,
        when: SENSOR_WHEN,
        data: ['sensors'],
        label: 'Horizontal angle of view',
        rows: { vertical: 'Vertical angle', diagonal: 'Diagonal angle', field: 'Field of view at the distance', equiv: 'Full-frame equivalent focal length' },
        run: (x, ctx) => {
            const s = sensorOf(x, ctx);

            if (!(s.w > 0 && s.h > 0 && x.f > 0)) {
                return { error: 'Enter the sensor size and a focal length.' };
            }

            const a = (d) => 2 * Math.atan(d / (2 * x.f));
            const crop = FF_DIAG / Math.hypot(s.w, s.h);

            return { value: `${num(deg(a(s.w)), 4)}°`, sub: `${s.name}, ${num(x.f)} mm`, rows: { vertical: `${num(deg(a(s.h)), 4)}°`, diagonal: `${num(deg(a(Math.hypot(s.w, s.h))), 4)}°`, field: `${lengthText((x.dist * s.w) / x.f)} × ${lengthText((x.dist * s.h) / x.f)}`, equiv: `${num(x.f * crop, 4)} mm` }, steps: ['Angle of view = 2 atan(sensor dimension ÷ (2 × focal length))', 'Field at distance D = D × sensor dimension ÷ focal length (thin lens, focused far away)'] };
        },
    },
    contrast_ratio: {
        type: 'calc',
        inputs: { fg: LINE('Text colour', '#767676'), bg: LINE('Background colour', '#ffffff') },
        label: 'Contrast ratio',
        rows: { aa: 'WCAG AA normal text (4.5:1)', aaLarge: 'WCAG AA large text (3:1)', aaa: 'WCAG AAA normal text (7:1)', ui: 'UI components and graphics (3:1)' },
        run: (x) => {
            const a = parseColor(x.fg);
            const b = parseColor(x.bg);

            if (!a || !b) {
                return { error: 'Enter both colours as #rrggbb, #rgb or rgb(r, g, b).' };
            }

            const c = contrast(a, b);
            const pass = (t) => (c >= t ? 'Pass' : 'Fail');

            return { value: `${num(Math.floor(c * 100) / 100, 4)}:1`, sub: c >= 7 ? 'Excellent' : c >= 4.5 ? 'Good for body text' : c >= 3 ? 'Large text only' : 'Too low', rows: { aa: pass(4.5), aaLarge: pass(3), aaa: pass(7), ui: pass(3) }, steps: ['Contrast = (L₁ + 0.05) ÷ (L₂ + 0.05), with relative luminance L from linearised sRGB (WCAG 2.2)', 'Large text is 18 pt, or 14 pt bold; the ratio is truncated, not rounded, when checking'] };
        },
    },
    crop: {
        type: 'calc',
        inputs: { ...SENSOR_FIELDS, f: MM('Lens focal length (mm)', 35), aperture: MM('Aperture (f-number)', 1.8) },
        show: SENSOR_SHOW,
        when: SENSOR_WHEN,
        data: ['sensors'],
        label: 'Crop factor',
        rows: { equivF: 'Equivalent focal length', equivN: 'Equivalent aperture (depth of field)', diagonal: 'Sensor diagonal', area: 'Sensor area vs full frame' },
        run: (x, ctx) => {
            const s = sensorOf(x, ctx);
            const crop = FF_DIAG / Math.hypot(s.w, s.h);

            return { value: `${num(crop, 4)}×`, sub: s.name, rows: { equivF: `${num(x.f * crop, 4)} mm`, equivN: `f/${num(x.aperture * crop, 3)}`, diagonal: `${num(Math.hypot(s.w, s.h), 4)} mm`, area: pct((s.w * s.h) / (36 * 24), 3) }, steps: ['Crop factor = full-frame diagonal (43.27 mm) ÷ sensor diagonal', 'Equivalent focal length gives the same angle of view on full frame; equivalent aperture gives the same depth of field and total light', 'Exposure (brightness) is set by the actual f-number, not the equivalent'] };
        },
    },
    dof: {
        type: 'calc',
        inputs: { ...SENSOR_FIELDS, f: MM('Focal length (mm)', 50), n: MM('Aperture (f-number)', 2.8), dist: DIST('Focus distance', 3) },
        show: SENSOR_SHOW,
        when: SENSOR_WHEN,
        data: ['sensors'],
        label: 'Depth of field',
        rows: { near: 'Near limit', far: 'Far limit', front: 'In front / behind', hyper: 'Hyperfocal distance', coc: 'Circle of confusion' },
        plots: [['chart', 'Depth of field by aperture']],
        run: (x, ctx) => {
            const s = sensorOf(x, ctx);
            const c = coc(s.w, s.h) / 1000;
            const f = x.f / 1000;
            const calc = (N) => {
                const H = (f * f) / (N * c) + f;
                const near = (x.dist * (H - f)) / (H + x.dist - 2 * f);
                const far = x.dist < H ? (x.dist * (H - f)) / (H - x.dist) : Infinity;

                return { H, near, far };
            };
            const r = calc(x.n);

            if (!(x.dist > f)) {
                return { error: 'The focus distance must be longer than the focal length.' };
            }

            return { value: r.far === Infinity ? '∞' : lengthText(r.far - r.near), sub: `${num(x.f)} mm at f/${num(x.n)}, focused at ${lengthText(x.dist)}`, rows: { near: lengthText(r.near), far: lengthText(r.far), front: r.far === Infinity ? `${lengthText(x.dist - r.near)} / ∞` : `${lengthText(x.dist - r.near)} / ${lengthText(r.far - x.dist)}`, hyper: lengthText(r.H), coc: `${num(c * 1000, 3)} mm` }, steps: ['H = f² ÷ (N c) + f', 'Near = s(H − f) ÷ (H + s − 2f); far = s(H − f) ÷ (H − s), infinite once s ≥ H', 'c = sensor diagonal ÷ 1500 (the usual convention for prints viewed normally)'], plots: { chart: { series: [1.4, 2, 2.8, 4, 5.6, 8, 11, 16, 22].map((N) => { const q = calc(N); return [N, q.far === Infinity ? NaN : q.far - q.near]; }), markers: [{ x: x.n, y: r.far === Infinity ? 0 : r.far - r.near, label: 'yours' }], xLabel: 'f-number', yLabel: 'Depth of field (m)', yMin: 0 } } };
        },
    },
    exposure: {
        type: 'calc',
        inputs: { solve: SEL('Find', { ev: 'Exposure value (EV)', shutter: 'Shutter speed', aperture: 'Aperture', iso: 'ISO' }, 'ev'), n: MM('Aperture (f-number)', 8), t: MM('Shutter speed (1/x s; e.g. 250)', 250), iso: MM('ISO', 100), ev: [`Exposure value at ISO 100 (EV₁₀₀)`, null, null, 15] },
        show: { n: 'solve:ev,shutter,iso', t: 'solve:ev,aperture,iso', iso: 'solve:ev,shutter,aperture', ev: 'solve:shutter,aperture,iso' },
        when: { n: (x) => x.solve !== 'aperture', t: (x) => x.solve !== 'shutter', iso: (x) => x.solve !== 'iso', ev: (x) => x.solve !== 'ev' },
        label: 'Result',
        rows: { ev100: 'EV at ISO 100', scene: 'Typical scene', equivalents: 'Equivalent exposures' },
        run: (x) => {
            const t = (v) => 1 / v;
            let ev100;
            let value;

            if (x.solve === 'ev') {
                ev100 = Math.log2((x.n * x.n) / t(x.t)) - Math.log2(x.iso / 100);
                value = `EV ${num(ev100, 3)}`;
            } else if (x.solve === 'shutter') {
                ev100 = x.ev;
                const sec = (x.n * x.n) / 2 ** (x.ev + Math.log2(x.iso / 100));
                value = sec >= 1 ? `${num(sec, 4)} s` : `1/${num(1 / sec, 4)} s`;
            } else if (x.solve === 'aperture') {
                ev100 = x.ev;
                value = `f/${num(Math.sqrt(t(x.t) * 2 ** (x.ev + Math.log2(x.iso / 100))), 3)}`;
            } else {
                ev100 = x.ev;
                value = `ISO ${num(100 * 2 ** (Math.log2((x.n * x.n) / t(x.t)) - x.ev), 4)}`;
            }

            const scene = ev100 >= 15 ? 'Bright sun (sunny 16: EV 15)' : ev100 >= 12 ? 'Hazy sun to light overcast' : ev100 >= 9 ? 'Overcast or open shade' : ev100 >= 6 ? 'Bright indoor lighting' : ev100 >= 2 ? 'Dim indoor, street at night' : 'Night landscape, moonlight';
            const eq = [2.8, 4, 5.6, 8, 11, 16].map((N) => { const s = (N * N) / 2 ** ev100; return `f/${N} ${s >= 1 ? `${num(s, 3)} s` : `1/${num(Math.round(1 / s), 4)}`}`; }).join(', ');

            return { value, sub: `EV₁₀₀ ${num(ev100, 3)}`, rows: { ev100: num(ev100, 4), scene, equivalents: `${eq} (at ISO 100)` }, steps: ['EV = log₂(N² ÷ t) at ISO 100; each +1 EV halves the light', 'Raising the ISO one stop lets the same scene take one EV less from aperture and shutter'] };
        },
    },
    film: {
        type: 'calc',
        inputs: { format: SEL('Film format', 'data:film:fixed', '35_4'), fps: N('Frame rate (fps)', 24, 1), mode: SEL('Find', { length: 'Film length for a running time', time: 'Running time for a length' }, 'length'), minutes: N('Running time (minutes)', 10, 0), feet: N('Film length (feet)', 400, 0) },
        show: { minutes: 'mode:length', feet: 'mode:time' },
        when: { minutes: (x) => x.mode === 'length', feet: (x) => x.mode === 'time' },
        data: ['film'],
        label: 'Result',
        rows: { frames: 'Frames', metres: 'In metres', rolls: '400 ft rolls (100 ft for 8 mm formats)', perMin: 'Feet per minute' },
        run: (x, ctx) => {
            const f = ctx.c.data.technology?.film?.[x.format];

            if (!f) {
                return { error: 'Choose a film format.' };
            }

            const fpm = (x.fps * 60) / f.fpf;
            const feet = x.mode === 'length' ? x.minutes * fpm : x.feet;
            const minutes = feet / fpm;
            const roll = f.fpf >= 72 ? 100 : 400;

            return { value: x.mode === 'length' ? `${num(feet, 5)} ft` : `${num(minutes, 4)} min`, sub: `${f.name} at ${num(x.fps)} fps`, rows: { frames: num(Math.round(feet * f.fpf)), metres: `${num(feet * 0.3048, 5)} m`, rolls: num(Math.ceil(feet / roll - 1e-9)), perMin: num(fpm, 5) }, steps: [`${f.name}: ${num(f.fpf, 5)} frames per foot`, 'Feet per minute = fps × 60 ÷ frames per foot (35 mm 4-perf at 24 fps = 90 ft/min)'] };
        },
    },
    focal_length: {
        type: 'calc',
        inputs: { ...SENSOR_FIELDS, by: SEL('From', { subject: 'Subject size and distance', angle: 'Angle of view' }, 'subject'), subject: DIST('Subject width to fill the frame', 2), dist: DIST('Distance to the subject', 10), angle: MM('Horizontal angle of view (°)', 40) },
        show: { ...SENSOR_SHOW, subject: 'by:subject', dist: 'by:subject', angle: 'by:angle' },
        when: { ...SENSOR_WHEN, subject: (x) => x.by === 'subject', dist: (x) => x.by === 'subject', angle: (x) => x.by === 'angle' },
        data: ['sensors'],
        label: 'Focal length',
        rows: { equiv: 'Full-frame equivalent', angle: 'Horizontal angle of view' },
        run: (x, ctx) => {
            const s = sensorOf(x, ctx);
            const f = x.by === 'subject' ? (s.w * x.dist) / x.subject : s.w / (2 * Math.tan((x.angle * Math.PI) / 360));

            return { value: `${num(f, 4)} mm`, sub: s.name, rows: { equiv: `${num(f * (FF_DIAG / Math.hypot(s.w, s.h)), 4)} mm`, angle: `${num(deg(2 * Math.atan(s.w / (2 * f))), 4)}°` }, steps: [x.by === 'subject' ? 'f = sensor width × distance ÷ subject width' : 'f = sensor width ÷ (2 tan(angle ÷ 2))'] };
        },
    },
    frames_tc: {
        type: 'calc',
        inputs: { frames: N('Frame count', 107892, 0), rate: SEL('Frame rate', RATE_OPTIONS, '29.97df') },
        label: 'Timecode',
        rows: { real: 'Real (clock) time', nominal: 'Frames per second used for counting', back: 'Check (back to frames)' },
        run: (x) => {
            if (!Number.isInteger(x.frames) || x.frames < 0) {
                return { error: 'Enter a whole number of frames.' };
            }

            const tc = framesToTimecode(x.frames, x.rate);
            const [fps, nominal, df] = RATES[x.rate];

            return { value: tc, sub: RATE_OPTIONS[x.rate], rows: { real: duration(x.frames / fps), nominal: `${nominal}${df ? ' (drop-frame skips numbers, not frames)' : ''}`, back: num(timecodeToFrames(tc, x.rate).frames) }, steps: ['Timecode counts frames in hours:minutes:seconds:frames at the nominal rate', df ? `Drop-frame skips frame numbers 00–0${nominal === 30 ? 1 : 3} at the start of every minute except each tenth (SMPTE ST 12-1), so timecode tracks clock time at ${num(fps, 6)} fps` : 'Non-drop timecode drifts from clock time at fractional rates (3.6 s per hour at 29.97)'] };
        },
    },
    tc_frames: {
        type: 'calc',
        inputs: { tc: LINE('Timecode (HH:MM:SS:FF)', '01:00:00;00'), rate: SEL('Frame rate', RATE_OPTIONS, '29.97df') },
        label: 'Frame count',
        rows: { real: 'Real (clock) time', back: 'Check (back to timecode)' },
        run: (x) => {
            const r = timecodeToFrames(x.tc, x.rate);

            if (r.problem) {
                return { error: r.problem };
            }

            const [fps] = RATES[x.rate];

            return { value: num(r.frames), sub: RATE_OPTIONS[x.rate], rows: { real: duration(r.frames / fps), back: framesToTimecode(r.frames, x.rate) }, steps: ['Frames = (hours × 3600 + minutes × 60 + seconds) × nominal fps + frames', 'Drop-frame then subtracts the skipped numbers: 2 (or 4 at 59.94) for every minute that is not a multiple of 10'] };
        },
    },
    hyperfocal: {
        type: 'calc',
        inputs: { ...SENSOR_FIELDS, f: MM('Focal length (mm)', 24), n: MM('Aperture (f-number)', 8) },
        show: SENSOR_SHOW,
        when: SENSOR_WHEN,
        data: ['sensors'],
        label: 'Hyperfocal distance',
        rows: { near: 'Sharp from (half the hyperfocal distance)', coc: 'Circle of confusion' },
        grids: [['table', 'By aperture']],
        run: (x, ctx) => {
            const s = sensorOf(x, ctx);
            const c = coc(s.w, s.h);
            const H = (N) => ((x.f * x.f) / (N * c) + x.f) / 1000;

            return { value: lengthText(H(x.n)), sub: `${num(x.f)} mm at f/${num(x.n)}, ${s.name}`, rows: { near: lengthText(H(x.n) / 2), coc: `${num(c, 3)} mm` }, steps: ['H = f² ÷ (N c) + f', 'Focus at H and everything from H/2 to infinity is acceptably sharp'], grids: { table: { columns: ['Hyperfocal', 'Sharp from'], rows: [2.8, 4, 5.6, 8, 11, 16, 22].map((N) => ({ header: `f/${N}`, cells: [lengthText(H(N)), lengthText(H(N) / 2)], highlight: N === x.n })) } } };
        },
    },
    image_size: {
        type: 'calc',
        inputs: { w: N('Width (pixels)', 6000, 1), h: N('Height (pixels)', 4000, 1), depth: SEL('Bits per channel', { 8: '8-bit', 10: '10-bit', 12: '12-bit', 14: '14-bit', 16: '16-bit', 32: '32-bit float' }, '8'), channels: SEL('Channels', { 1: '1 (greyscale)', 3: '3 (RGB)', 4: '4 (RGBA or CMYK)' }, '3') },
        label: 'Uncompressed size',
        rows: { mp: 'Megapixels', bytes: 'Bytes', jpeg: 'Typical JPEG (about 10:1)', png: 'Typical PNG (about 2:1, varies)' },
        run: (x) => {
            const bytes = (x.w * x.h * Number(x.depth) * Number(x.channels)) / 8;
            const mb = (b) => `${num(b / 1e6, 4)} MB (${num(b / 2 ** 20, 4)} MiB)`;

            return { value: mb(bytes), sub: `${num(x.w)} × ${num(x.h)}, ${x.depth}-bit × ${x.channels}`, rows: { mp: num((x.w * x.h) / 1e6, 4), bytes: num(bytes), jpeg: mb(bytes / 10), png: mb(bytes / 2) }, steps: ['Size = width × height × bits per channel × channels ÷ 8', 'Compressed sizes depend on the image; the ratios are rough guides'] };
        },
    },
    image_ratio: {
        type: 'calc',
        inputs: { w: N('Original width', 4000, 1), h: N('Original height', 3000, 1), fit: SEL('Resize to', { width: 'A new width', height: 'A new height', ratio: 'A different aspect ratio (crop)' }, 'width'), newW: N('New width', 1200, 1), newH: N('New height', 800, 1), ratio: LINE('Target ratio', '16:9') },
        show: { newW: 'fit:width', newH: 'fit:height', ratio: 'fit:ratio' },
        when: { newW: (x) => x.fit === 'width', newH: (x) => x.fit === 'height' },
        label: 'New size',
        rows: { ratio: 'Original ratio', scale: 'Scale', crop: 'Pixels lost to the crop' },
        run: (x) => {
            const r = x.w / x.h;

            if (x.fit === 'ratio') {
                const t = parseRatio(x.ratio);

                if (!(t > 0)) {
                    return { error: 'Write the ratio as 16:9, 3:2 or a decimal.' };
                }

                const [cw, ch] = t > r ? [x.w, Math.round(x.w / t)] : [Math.round(x.h * t), x.h];

                return { value: `${num(cw)} × ${num(ch)}`, sub: `Largest ${x.ratio} crop`, rows: { ratio: ratioText(x.w, x.h), scale: '100%', crop: pct(1 - (cw * ch) / (x.w * x.h), 3) }, steps: ['Keep the full side that limits the new ratio and crop the other'] };
            }

            const [nw, nh] = x.fit === 'width' ? [x.newW, x.newW / r] : [x.newH * r, x.newH];

            return { value: `${num(Math.round(nw))} × ${num(Math.round(nh))}`, sub: `exact ${num(nw, 6)} × ${num(nh, 6)}`, rows: { ratio: ratioText(x.w, x.h), scale: pct(nw / x.w, 4), crop: 'None' }, steps: ['New height = new width × original height ÷ original width (or the reverse)'] };
        },
    },
    ppi: {
        type: 'calc',
        inputs: { w: N('Horizontal resolution (px)', 2560, 1), h: N('Vertical resolution (px)', 1440, 1), diag: N('Diagonal size (inches)', 27, 0) },
        label: 'Pixel density',
        rows: { pitch: 'Dot pitch', size: 'Screen width × height', retina: 'Pixels blend at about', total: 'Total pixels' },
        run: (x) => {
            const px = Math.hypot(x.w, x.h);
            const ppi = px / x.diag;
            const wIn = (x.diag * x.w) / px;
            const hIn = (x.diag * x.h) / px;

            return { value: `${num(ppi, 5)} PPI`, sub: `${num(x.w)} × ${num(x.h)} on ${num(x.diag)}″`, rows: { pitch: `${num(25.4 / ppi, 4)} mm`, size: `${num(wIn, 4)} × ${num(hIn, 4)} in (${num(wIn * 2.54, 4)} × ${num(hIn * 2.54, 4)} cm)`, retina: `${num(3438 / ppi, 4)} in (${num((3438 / ppi) * 2.54, 4)} cm) away (1 arcminute per pixel)`, total: num(x.w * x.h) }, steps: ['PPI = √(width² + height²) ÷ diagonal', 'At a distance of 3438 ÷ PPI inches one pixel spans 1 arcminute, about the limit of 20/20 vision'] };
        },
    },
    projector: {
        type: 'calc',
        inputs: { throw: MM('Throw ratio (distance ÷ image width)', 1.5), solve: SEL('Find', { distance: 'Distance for an image width', width: 'Image size at a distance' }, 'distance'), width: DIST('Image width', 2.5), distance: DIST('Distance from the screen', 3.5), aspect: LINE('Aspect ratio', '16:9') },
        show: { width: 'solve:distance', distance: 'solve:width' },
        when: { width: (x) => x.solve === 'distance', distance: (x) => x.solve === 'width' },
        label: 'Result',
        rows: { width: 'Image width', height: 'Image height', diag: 'Diagonal', distance: 'Throw distance' },
        run: (x) => {
            const a = parseRatio(x.aspect);

            if (!(a > 0 && x.throw > 0)) {
                return { error: 'Enter a throw ratio and an aspect ratio such as 16:9.' };
            }

            const w = x.solve === 'distance' ? x.width : x.distance / x.throw;
            const d = w * x.throw;
            const h = w / a;
            const diag = Math.hypot(w, h);

            return { value: x.solve === 'distance' ? lengthText(d) : `${num(diag / 0.0254, 4)}″ diagonal`, sub: `Throw ratio ${num(x.throw)}:1`, rows: { width: lengthText(w), height: lengthText(h), diag: `${lengthText(diag)} = ${num(diag / 0.0254, 4)}″`, distance: lengthText(d) }, steps: ['Throw distance = throw ratio × image width (measured from the lens)', 'Zoom lenses have a range of throw ratios: check both ends in the projector’s manual'] };
        },
    },
    res_scale: {
        type: 'calc',
        inputs: { w: N('Width (px)', 3840, 1), h: N('Height (px)', 2160, 1), scale: N('Scale (%)', 67, 0) },
        label: 'Scaled resolution',
        rows: { pixels: 'Pixel count', change: 'Change in pixel count' },
        run: (x) => {
            const s = x.scale / 100;
            const [w, h] = [Math.round(x.w * s), Math.round(x.h * s)];

            return { value: `${num(w)} × ${num(h)}`, sub: `${num(x.scale)}% of ${num(x.w)} × ${num(x.h)}`, rows: { pixels: num(w * h), change: pct((w * h) / (x.w * x.h), 4) }, steps: ['Each side is multiplied by the scale; the pixel count by the scale squared', 'Games’ render-scale settings (and upscalers) work this way: 67% of 4K renders about 2560 × 1440'] };
        },
    },
    screen_size: {
        type: 'calc',
        inputs: { diag: N('Diagonal (inches)', 55, 0), aspect: LINE('Aspect ratio', '16:9') },
        label: 'Width × height',
        rows: { cm: 'In centimetres', area: 'Screen area', compare: 'Equal-height 4:3 screen' },
        run: (x) => {
            const a = parseRatio(x.aspect);

            if (!(a > 0 && x.diag > 0)) {
                return { error: 'Enter a diagonal and an aspect ratio.' };
            }

            const h = x.diag / Math.sqrt(a * a + 1);
            const w = h * a;

            return { value: `${num(w, 4)} × ${num(h, 4)} in`, sub: `${num(x.diag)}″ at ${x.aspect}`, rows: { cm: `${num(w * 2.54, 4)} × ${num(h * 2.54, 4)} cm`, area: `${num(w * h, 4)} in² (${num(w * h * 6.4516, 4)} cm²)`, compare: `${num(Math.hypot(h * (4 / 3), h), 4)}″ diagonal` }, steps: ['Height = diagonal ÷ √(ratio² + 1); width = height × ratio', 'TV sizes are the diagonal of the visible picture'] };
        },
    },
    shutter: {
        type: 'calc',
        inputs: { ...SENSOR_FIELDS, purpose: SEL('For', { handheld: 'Hand-held sharpness', stars: 'Stars without trails (NPF rule)', rule500: 'Stars without trails (500 rule)' }, 'handheld'), f: MM('Focal length (mm)', 50), stops: MM('Stabilisation (stops)', 0), n: MM('Aperture (f-number, NPF rule)', 2.8), px: MM('Image width (pixels, NPF rule)', 6000) },
        show: { ...SENSOR_SHOW, stops: 'purpose:handheld', n: 'purpose:stars', px: 'purpose:stars' },
        when: SENSOR_WHEN,
        data: ['sensors'],
        label: 'Slowest shutter speed',
        rows: { method: 'Rule used', crop: 'Crop factor used' },
        run: (x, ctx) => {
            const s = sensorOf(x, ctx);
            const crop = FF_DIAG / Math.hypot(s.w, s.h);
            let t;
            let method;

            if (x.purpose === 'handheld') {
                t = (1 / (x.f * crop)) * 2 ** x.stops;
                method = 'Reciprocal rule: 1 ÷ (focal length × crop factor), doubled for each stop of stabilisation';
            } else if (x.purpose === 'rule500') {
                t = 500 / (x.f * crop);
                method = '500 rule: 500 ÷ (focal length × crop factor) — too long for today’s high-resolution sensors';
            } else {
                const pitch = (s.w / x.px) * 1000;
                t = (35 * x.n + 30 * pitch) / x.f;
                method = `Simplified NPF rule (Frédéric Michaud): (35 N + 30 p) ÷ f, with pixel pitch p = ${num(pitch, 3)} µm`;
            }

            return { value: t >= 1 ? `${num(t, 3)} s` : `1/${num(Math.round(1 / t), 4)} s`, sub: `${num(x.f)} mm on ${s.name}`, rows: { method, crop: `${num(crop, 3)}×` }, steps: [method, 'These are starting points: check the result at 100% and adjust'] };
        },
    },
    time_lapse: {
        type: 'calc',
        inputs: { solve: SEL('Find', { clip: 'Clip length', interval: 'Interval between shots', duration: 'Event duration to shoot' }, 'clip'), duration: N('Event duration (minutes)', 120, 0), interval: N('Interval between shots (s)', 5, 0), clip: N('Clip length (s)', 30, 0), fps: N('Playback frame rate (fps)', 24, 1), fileMb: N('Size of one photo (MB, optional)', 25, 0) },
        show: { duration: 'solve:clip,interval', interval: 'solve:clip,duration', clip: 'solve:interval,duration' },
        when: { duration: (x) => x.solve !== 'duration', interval: (x) => x.solve !== 'interval', clip: (x) => x.solve !== 'clip' },
        optional: ['fileMb'],
        label: 'Result',
        rows: { frames: 'Photos', speedup: 'Speed-up', storage: 'Card space' },
        run: (x) => {
            let { duration: dur, interval: iv, clip } = x;

            if (x.solve === 'clip') {
                clip = (dur * 60) / iv / x.fps;
            } else if (x.solve === 'interval') {
                iv = (dur * 60) / (clip * x.fps);
            } else {
                dur = (clip * x.fps * iv) / 60;
            }

            const frames = Math.round((dur * 60) / iv);

            return { value: x.solve === 'clip' ? `${num(clip, 4)} s of video` : x.solve === 'interval' ? `${num(iv, 4)} s between shots` : `${num(dur, 4)} min of shooting`, sub: `${num(frames)} photos at ${num(x.fps)} fps`, rows: { frames: num(frames), speedup: `${num(iv * x.fps, 4)}×`, storage: x.fileMb > 0 ? `${num((frames * x.fileMb) / 1000, 4)} GB` : 'Enter a photo size' }, steps: ['Photos = event duration ÷ interval; clip length = photos ÷ playback fps', 'Speed-up = interval × fps (5 s at 24 fps plays 120× faster)'] };
        },
    },
    tv_mount: {
        type: 'calc',
        inputs: { diag: N('TV diagonal (inches)', 65, 0), eye: DIST('Seated eye height', 107, 'cm'), offset: DIST('Raise above eye level (optional)', 0, 'cm') },
        optional: ['offset'],
        label: 'Height to the centre of the TV',
        rows: { bottom: 'Height to the bottom edge', top: 'Height to the top edge', screenH: 'Screen height' },
        run: (x) => {
            const h = ((x.diag * 9) / Math.sqrt(337)) * 0.0254;
            const centre = x.eye + (x.offset || 0);

            return { value: lengthText(centre), sub: `${num(x.diag)}″ 16:9 screen`, rows: { bottom: lengthText(centre - h / 2), top: lengthText(centre + h / 2), screenH: lengthText(h) }, steps: ['Common guidance: put the centre of the screen at seated eye level (about 100–110 cm on a sofa)', 'If it must go higher (above a fireplace), tilt it down toward the seats', 'The bracket position depends on where the mounting holes sit on your TV'] };
        },
    },
    tv_size: {
        type: 'calc',
        inputs: { solve: SEL('Find', { size: 'TV size for my seating distance', distance: 'Seating distance for a TV size' }, 'size'), distance: DIST('Viewing distance', 2.5), diag: N('TV diagonal (inches)', 65, 0), standard: SEL('Viewing angle', { smpte: 'SMPTE 30° (comfortable)', thx: 'THX 40° (cinematic)' }, 'smpte'), res: SEL('Resolution', { 1080: '1080p', 2160: '4K', 4320: '8K' }, '2160') },
        show: { distance: 'solve:size', diag: 'solve:distance' },
        when: { distance: (x) => x.solve === 'size', diag: (x) => x.solve === 'distance' },
        label: 'Result',
        rows: { other: 'With the other standard', resolution: 'Closest distance before pixels show' },
        run: (x) => {
            const tanHalf = (s) => Math.tan(((s === 'thx' ? 40 : 30) * Math.PI) / 360);
            const widthToDiag = Math.sqrt(337) / 16;
            const res = Number(x.res);

            if (x.solve === 'size') {
                const diagIn = (s) => ((2 * x.distance * tanHalf(s)) / 0.0254) * widthToDiag;
                const pixelDist = (d) => ((d * (9 / Math.sqrt(337))) / res) * 3438 * 0.0254;

                return { value: `${num(diagIn(x.standard), 3)}″`, sub: `at ${lengthText(x.distance)}`, rows: { other: `${num(diagIn(x.standard === 'thx' ? 'smpte' : 'thx'), 3)}″`, resolution: `${lengthText(pixelDist(diagIn(x.standard)))} for that size at ${x.res === '2160' ? '4K' : x.res === '4320' ? '8K' : '1080p'}` }, steps: ['The screen width fills the chosen angle: width = 2 × distance × tan(angle ÷ 2)', 'Diagonal = width × √337 ÷ 16 for 16:9'] };
            }

            const w = (x.diag / widthToDiag) * 0.0254;
            const dist = (s) => w / (2 * tanHalf(s));
            const pixel = (((x.diag * 9) / Math.sqrt(337)) / res) * 3438 * 0.0254;

            return { value: lengthText(dist(x.standard)), sub: `${num(x.diag)}″`, rows: { other: lengthText(dist(x.standard === 'thx' ? 'smpte' : 'thx')), resolution: lengthText(pixel) }, steps: ['Distance = screen width ÷ (2 tan(angle ÷ 2))', 'Pixels blend when one pixel spans under 1 arcminute'] };
        },
    },
    vert_exag: {
        type: 'calc',
        inputs: { hscale: LINE('Horizontal scale', '1:24000'), vscale: LINE('Vertical scale', '1:2000') },
        label: 'Vertical exaggeration',
        rows: { meaning: 'Meaning' },
        run: (x) => {
            const read = (t) => {
                const m = String(t ?? '').trim().match(/^1\s*[:/]\s*([\d,.]+)$/);

                return m ? Number(m[1].replace(/,/g, '')) : Number(String(t).replace(/,/g, ''));
            };
            const H = read(x.hscale);
            const V = read(x.vscale);

            if (!(H > 0 && V > 0)) {
                return { error: 'Write scales as 1:24000 (or just the denominator).' };
            }

            return { value: `${num(H / V, 5)}×`, sub: `1:${num(H)} horizontal, 1:${num(V)} vertical`, rows: { meaning: H / V > 1 ? `Heights look ${num(H / V, 4)} times taller than they really are` : 'No exaggeration (or flattened)' }, steps: ['VE = vertical scale ÷ horizontal scale = horizontal denominator ÷ vertical denominator'] };
        },
    },
    video_size: {
        type: 'calc',
        inputs: { preset: SEL('Video bitrate', { custom: 'My own bitrate', yt2160: 'YouTube 4K upload (45 Mbit/s)', yt1440: 'YouTube 1440p upload (16 Mbit/s)', yt1080: 'YouTube 1080p upload (8 Mbit/s)', yt720: 'YouTube 720p upload (5 Mbit/s)', yt480: 'YouTube 480p upload (2.5 Mbit/s)' }, 'yt1080'), bitrate: ['Video bitrate', 'data_rate', 'mbps', 50], audio: ['Audio bitrate', 'data_rate', 'kbps', 320], minutes: N('Duration (minutes)', 10, 0) },
        show: { bitrate: 'preset:custom' },
        when: { bitrate: (x) => x.preset === 'custom' },
        label: 'File size',
        rows: { perMinute: 'Per minute', perGb: 'Minutes per GB', total: 'Total bitrate' },
        run: (x) => {
            const video = { yt2160: 45e6, yt1440: 16e6, yt1080: 8e6, yt720: 5e6, yt480: 2.5e6 }[x.preset] ?? x.bitrate;
            const total = video + x.audio;
            const bytes = (total * x.minutes * 60) / 8;

            return { value: bytes >= 1e9 ? `${num(bytes / 1e9, 4)} GB` : `${num(bytes / 1e6, 4)} MB`, sub: `${num(x.minutes)} min at ${num(total / 1e6, 4)} Mbit/s`, rows: { perMinute: `${num((total * 60) / 8 / 1e6, 4)} MB`, perGb: num(8e9 / total / 60, 4), total: `${num(total / 1e6, 4)} Mbit/s` }, steps: ['Size = (video + audio bitrate) × duration ÷ 8', 'Variable-bitrate files vary around the average; containers add a little overhead', 'YouTube presets: its recommended SDR upload bitrates at 24–30 fps'] };
        },
    },
    frame_size: {
        type: 'calc',
        inputs: { w: N('Width (px)', 1920, 1), h: N('Height (px)', 1080, 1), depth: SEL('Bit depth', { 8: '8-bit', 10: '10-bit', 12: '12-bit', 16: '16-bit' }, '10'), chroma: SEL('Chroma subsampling', { 3: '4:4:4 (RGB)', 2: '4:2:2', 1.5: '4:2:0' }, '2'), fps: N('Frame rate (fps)', 25, 1) },
        label: 'Uncompressed frame',
        rows: { rate: 'Data rate', perHour: 'Per hour', perMin: 'Per minute' },
        run: (x) => {
            const bits = x.w * x.h * Number(x.depth) * Number(x.chroma);
            const bytes = bits / 8;

            return { value: `${num(bytes / 1e6, 5)} MB`, sub: `${num(x.w)} × ${num(x.h)}, ${x.depth}-bit`, rows: { rate: `${num((bits * x.fps) / 1e9, 5)} Gbit/s`, perHour: `${num((bytes * x.fps * 3600) / 1e9, 5)} GB`, perMin: `${num((bytes * x.fps * 60) / 1e9, 5)} GB` }, steps: ['Samples per pixel: 3 for 4:4:4, 2 for 4:2:2, 1.5 for 4:2:0', 'Frame size = pixels × samples per pixel × bit depth ÷ 8'] };
        },
    },
    golden_hour: {
        type: 'calc',
        inputs: { lat: N('Latitude (°, north positive)', 51.5074), lon: N('Longitude (°, east positive)', -0.1278), date: ['Date', 'date', null, '2026-06-21'], tz: N('Time zone offset from UTC (hours, e.g. 1 for BST, 5.5 for IST)', 1) },
        label: 'Evening golden hour',
        rows: { morningGolden: 'Morning golden hour', morningBlue: 'Morning blue hour', eveningBlue: 'Evening blue hour', sunrise: 'Sunrise and sunset' },
        run: (x) => {
            const m = String(x.date ?? '').match(/^(\d{4})-(\d{2})-(\d{2})$/);

            if (!m || !(Math.abs(x.lat) <= 90 && Math.abs(x.lon) <= 180)) {
                return { error: 'Enter a date and a latitude/longitude.' };
            }

            const [y, mo, d] = m.slice(1).map(Number);
            const at = (elev) => sunTimes(x.lat, x.lon, y, mo, d, 90 - elev);
            const local = (ev) => (ev.t === undefined ? (ev.none === 'up' ? 'Sun stays above' : 'Sun stays below') : clock(ev.t + x.tz));
            const span = (a, b) => `${local(a)} – ${local(b)}`;
            const [neg6, neg4, pos6] = [at(-6), at(-4), at(6)];
            const std = sunTimes(x.lat, x.lon, y, mo, d);

            return { value: span(pos6.set, neg4.set), sub: `${x.date} at ${num(x.lat, 6)}, ${num(x.lon, 6)} (UTC${x.tz >= 0 ? '+' : ''}${num(x.tz)})`, rows: { morningGolden: span(neg4.rise, pos6.rise), morningBlue: span(neg6.rise, neg4.rise), eveningBlue: span(neg4.set, neg6.set), sunrise: `${local(std.rise)} and ${local(std.set)}` }, steps: ['Golden hour: the Sun between 6° above and 4° below the horizon; blue hour: 4° to 6° below', 'Sun position from the NOAA solar algorithm (accurate to about a minute)', 'Hills, buildings and clouds change what you see; enter your own time-zone offset (including daylight saving)'] };
        },
    },
    guide_number: {
        type: 'calc',
        inputs: { solve: SEL('Find', { distance: 'Flash range', aperture: 'Aperture to use', gn: 'Guide number needed' }, 'distance'), gn: N('Guide number (metres, ISO 100)', 40, 0), n: MM('Aperture (f-number)', 8), dist: DIST('Subject distance', 5), iso: MM('ISO', 100) },
        show: { gn: 'solve:distance,aperture', n: 'solve:distance,gn', dist: 'solve:aperture,gn' },
        when: { gn: (x) => x.solve !== 'gn', n: (x) => x.solve !== 'aperture', dist: (x) => x.solve !== 'distance' },
        label: 'Result',
        rows: { effective: 'Guide number at this ISO', feet: 'Guide number in feet' },
        run: (x) => {
            const k = Math.sqrt(x.iso / 100);
            const value = x.solve === 'distance' ? lengthText((x.gn * k) / x.n) : x.solve === 'aperture' ? `f/${num((x.gn * k) / x.dist, 3)}` : `${num((x.dist * x.n) / k, 4)} (m, ISO 100)`;
            const gn = x.solve === 'gn' ? (x.dist * x.n) / k : x.gn;

            return { value, sub: 'Full power, direct flash', rows: { effective: num(gn * k, 4), feet: num(gn / 0.3048, 4) }, steps: ['Guide number = distance × f-number (at ISO 100)', 'Each doubling of ISO multiplies the guide number by √2', 'Bounce flash and modifiers lose one to three stops'] };
        },
    },
    megapixel: {
        type: 'calc',
        inputs: { by: SEL('From', { pixels: 'Width and height in pixels', mp: 'Megapixels and aspect ratio' }, 'pixels'), w: N('Width (px)', 6000, 1), h: N('Height (px)', 4000, 1), mp: N('Megapixels', 24, 0), aspect: LINE('Aspect ratio', '3:2') },
        show: { w: 'by:pixels', h: 'by:pixels', mp: 'by:mp', aspect: 'by:mp' },
        when: { w: (x) => x.by === 'pixels', h: (x) => x.by === 'pixels', mp: (x) => x.by === 'mp' },
        label: 'Megapixels',
        rows: { dims: 'Pixel dimensions', print300: 'Print at 300 PPI (gallery)', print240: 'Print at 240 PPI', print150: 'Print at 150 PPI (posters)' },
        run: (x) => {
            let w = x.w;
            let h = x.h;

            if (x.by === 'mp') {
                const a = parseRatio(x.aspect);

                if (!(a > 0)) {
                    return { error: 'Enter an aspect ratio such as 3:2.' };
                }

                h = Math.sqrt((x.mp * 1e6) / a);
                w = h * a;
            }

            const print = (ppi) => `${num(w / ppi, 4)} × ${num(h / ppi, 4)} in (${num((w / ppi) * 2.54, 4)} × ${num((h / ppi) * 2.54, 4)} cm)`;

            return { value: `${num((w * h) / 1e6, 4)} MP`, sub: `${num(Math.round(w))} × ${num(Math.round(h))}`, rows: { dims: `${num(Math.round(w))} × ${num(Math.round(h))}`, print300: print(300), print240: print(240), print150: print(150) }, steps: ['Megapixels = width × height ÷ 1,000,000', 'Print size = pixels ÷ PPI; larger prints are viewed from further away and need fewer PPI'] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
