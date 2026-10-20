import { defineTools } from '../engines/formula.js';
import { waterDensity, waterVapourPressure } from '../physics/air.js';
import { D, handlersFor, K, num, pw } from '../physics/core.js';

/**
 * Machines and mechanisms: levers, gears, pulleys, engines, pumps, springs and propellers.
 */
const g0 = K.g0;
const IN = 0.0254;

const readList = (text) => String(text ?? '').split(/[\n,;]+/).map((s) => Number(s.trim())).filter((v) => Number.isFinite(v) && v > 0);
const readPairs = (text) => {
    const rows = String(text ?? '').split(/\n|;/).map((l) => l.trim()).filter(Boolean).map((l) => l.split(/[,\s:]+/).map(Number));

    return rows.length && rows.every((r) => r.length === 2 && r.every((v) => v > 0)) ? rows : null;
};
const THREADS = { square: ['Square thread', 0], acme: ['ACME (29°)', 14.5], trapezoidal: ['Metric trapezoidal (30°)', 15] };

export const TOOLS = {
    belt_length: {
        type: 'calc',
        inputs: { D1: ['Large pulley diameter', 'length', 'mm', 200], D2: ['Small pulley diameter', 'length', 'mm', 100], C: ['Centre distance', 'length', 'mm', 500], kind: ['Belt', 'select', { open: 'Open belt', crossed: 'Crossed belt' }, 'open'] },
        out: 'length',
        outUnit: 'mm',
        label: 'Belt length',
        rows: { approx: ['Common approximation', 'length'], wrap: 'Wrap angle on the small pulley', ratio: 'Speed ratio' },
        run: (x) => {
            const [Dl, Ds] = [Math.max(x.D1, x.D2), Math.min(x.D1, x.D2)];
            const open = x.kind === 'open';
            const s = open ? (Dl - Ds) / (2 * x.C) : (Dl + Ds) / (2 * x.C);

            if (!(s < 1)) {
                return { error: 'The pulleys overlap at this centre distance.' };
            }

            const phi = Math.asin(s);
            const L = open ? 2 * x.C * Math.cos(phi) + (Math.PI * (Dl + Ds)) / 2 + phi * (Dl - Ds) : 2 * x.C * Math.cos(phi) + ((Math.PI + 2 * phi) * (Dl + Ds)) / 2;
            const approx = open ? 2 * x.C + (Math.PI * (Dl + Ds)) / 2 + (Dl - Ds) ** 2 / (4 * x.C) : 2 * x.C + (Math.PI * (Dl + Ds)) / 2 + (Dl + Ds) ** 2 / (4 * x.C);

            return { value: L, sub: `Wrap on the small pulley ${num((open ? Math.PI - 2 * phi : Math.PI + 2 * phi) / D, 4)}°`, rows: { approx: [approx, 'length'], wrap: `${num((open ? Math.PI - 2 * phi : Math.PI + 2 * phi) / D, 4)}°`, ratio: `${num(Dl / Ds, 4)} : 1` }, steps: [`φ = asin(${open ? '(D − d)' : '(D + d)'} ÷ 2C) = ${num(phi / D)}°`, open ? 'L = 2C cos φ + π(D + d)/2 + φ(D − d)' : 'L = 2C cos φ + (π + 2φ)(D + d)/2', `= ${num(L * 1000)} mm (pitch length)`] };
        },
    },
    bmep: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { torque: 'Torque', power: 'Power and rpm' }, 'torque'], T: ['Torque', 'torque', 'nm', 400], P: ['Power', 'power', 'kw', 150], rpm: ['Engine speed (rpm)', null, null, 5500, 0], V: ['Displacement', 'volume', 'l', 2.0], strokes: ['Cycle', 'select', { four: 'Four-stroke', two: 'Two-stroke' }, 'four'] },
        show: { T: 'mode:torque', P: 'mode:power', rpm: 'mode:power' },
        when: { T: (x) => x.mode === 'torque', P: (x) => x.mode === 'power', rpm: (x) => x.mode === 'power' },
        out: 'pressure',
        outUnit: 'bar',
        label: 'Brake mean effective pressure',
        rows: { T: ['Torque', 'torque'], typical: 'Typical BMEP' },
        run: (x) => {
            const T = x.mode === 'torque' ? x.T : x.P / ((x.rpm * 2 * Math.PI) / 60);
            const bmep = ((x.strokes === 'four' ? 4 : 2) * Math.PI * T) / x.V;

            return { value: bmep, sub: `${num(bmep / 6894.757)} psi`, rows: { T: [T, 'torque'], typical: 'Naturally aspirated petrol 10–13 bar, turbo petrol 18–25 bar, truck diesel 20–30 bar' }, steps: [x.strokes === 'four' ? 'BMEP = 4πT ÷ V_d' : 'BMEP = 2πT ÷ V_d', `= ${x.strokes === 'four' ? 4 : 2}π × ${num(T)} N·m ÷ ${num(x.V)} m³ = ${num(bmep / 1e5)} bar`] };
        },
    },
    carb_cfm: {
        type: 'calc',
        inputs: { V: ['Engine displacement', 'volume', 'in3', 350], rpm: ['Maximum rpm', null, null, 6000, 0], ve: ['Volumetric efficiency (%)', null, null, 85, 0] },
        out: 'flow',
        outUnit: 'cfm',
        label: 'Carburettor size',
        rows: { pick: 'Common carburettor sizes near this' },
        run: (x) => {
            const cid = x.V / 1.6387064e-5;
            const cfm = (cid * x.rpm * (x.ve / 100)) / 3456;
            const sizes = [390, 450, 500, 570, 600, 650, 750, 800, 850, 950, 1050];
            const near = sizes.reduce((a, b) => (Math.abs(b - cfm) < Math.abs(a - cfm) ? b : a));

            return { value: cfm * 4.719474e-4, sub: `${num(cfm, 4)} CFM (an estimate)`, rows: { pick: `${near} CFM` }, steps: ['CFM = CID × rpm × VE ÷ 3456 (four-stroke)', `= ${num(cid)} × ${num(x.rpm)} × ${num(x.ve / 100)} ÷ 3456 = ${num(cfm)} CFM`, 'Street engines: VE about 80–85%; race engines 90–105%'] };
        },
    },
    crawl_ratio: {
        type: 'calc',
        inputs: { first: ['First gear ratio', null, null, 4.71, 0], low: ['Transfer case low range', null, null, 2.72, 0], axle: ['Axle ratio', null, null, 4.1, 0], rpm: ['Engine idle speed (rpm, optional)', null, null, 800, 0], tyre: ['Tyre diameter (optional)', 'length', 'in', 33] },
        optional: ['rpm', 'tyre'],
        label: 'Crawl ratio',
        rows: { speed: 'Crawl speed at idle', torque: 'Torque multiplication' },
        run: (x) => {
            const cr = x.first * x.low * x.axle;
            const v = Number.isFinite(x.rpm) && Number.isFinite(x.tyre) ? ((x.rpm / cr) * Math.PI * x.tyre * 60) / 1000 : NaN;

            return { value: `${num(cr, 4)} : 1`, sub: cr >= 50 ? 'Good for rock crawling (50:1 or more)' : 'Moderate off-road gearing', rows: { speed: Number.isFinite(v) ? `${num(v, 3)} km/h (${num(v / 1.609344, 3)} mph)` : 'Enter idle rpm and tyre size', torque: `× ${num(cr, 4)} before losses` }, steps: ['Crawl ratio = first gear × low range × axle', `= ${num(x.first)} × ${num(x.low)} × ${num(x.axle)} = ${num(cr)}`] };
        },
    },
    diametral_pitch: pw({ vars: { P: ['Diametral pitch (teeth per inch)', null, null, 10], N: ['Number of teeth', null, null, 30], Dp: ['Pitch diameter', 'length', 'in', 3] }, out: 'P', k: IN, exp: { N: 1, Dp: -1 }, eq: 'P = N ÷ D', forms: { P: 'P = N ÷ D', N: 'N = P D', Dp: 'D = N ÷ P' }, rows: { module: 'Metric module', cp: 'Circular pitch', od: ['Outside diameter (D + 2/P)', 'length'] }, extra: (v) => ({ module: `${num(25.4 / v.P, 4)} mm`, cp: `${num(Math.PI / v.P, 4)} in`, od: [v.Dp + (2 / v.P) * IN, 'length'] }) }),
    displacement_engine: {
        type: 'calc',
        inputs: { bore: ['Bore', 'length', 'mm', 86], stroke: ['Stroke', 'length', 'mm', 86], n: ['Cylinders', null, null, 4, 1] },
        out: 'volume',
        outUnit: 'l',
        label: 'Engine displacement',
        rows: { cc: 'In cc', cid: 'In cubic inches', per: 'Per cylinder', ratio: 'Bore ÷ stroke' },
        run: (x) => {
            const V = (Math.PI / 4) * x.bore ** 2 * x.stroke * x.n;

            return { value: V, sub: `${num(V * 1e6, 5)} cc, ${num(V / 1.6387064e-5, 4)} cid`, rows: { cc: `${num(V * 1e6, 5)} cc`, cid: `${num(V / 1.6387064e-5, 4)} in³`, per: `${num((V / x.n) * 1e6, 5)} cc`, ratio: `${num(x.bore / x.stroke, 3)} (${x.bore > x.stroke ? 'oversquare' : x.bore < x.stroke ? 'undersquare' : 'square'})` }, steps: ['V = (π/4) × bore² × stroke × cylinders', `= 0.7854 × ${num(x.bore * 100)}² × ${num(x.stroke * 100)} × ${num(x.n)} cm³ = ${num(V * 1e6)} cm³`] };
        },
    },
    exhaust: {
        type: 'calc',
        inputs: { hp: ['Engine power', 'power', 'hp', 400], layout: ['System', 'select', { single: 'Single pipe', dual: 'Dual pipes' }, 'dual'] },
        out: 'length',
        outUnit: 'in',
        label: 'Pipe inside diameter',
        rows: { flow: 'Estimated exhaust flow', area: 'Total flow area' },
        run: (x) => {
            const hp = x.hp / 745.69987;
            const cfm = 2.2 * hp;
            const area = (cfm / 60 / 250) * 144;
            const pipes = x.layout === 'dual' ? 2 : 1;
            const d = Math.sqrt((4 * area) / pipes / Math.PI);

            return { value: d * IN, sub: `${pipes === 2 ? 'Each of two pipes' : 'One pipe'}, rounded up to the next ¼ in: ${num(Math.ceil(d * 4) / 4)} in`, rows: { flow: `${num(cfm, 4)} CFM`, area: `${num(area, 4)} in²` }, steps: ['Rule of thumb: about 2.2 CFM of exhaust per horsepower at a gas speed of 250 ft/s', `Area = ${num(cfm)} CFM ÷ (250 ft/s × 60) = ${num(area)} in²`, `d = √(4A ÷ πn) = ${num(d)} in`, 'An estimate: header design and the use of the car matter more than a fraction of an inch'] };
        },
    },
    fulcrum: {
        type: 'calc',
        inputs: { L: ['Bar length', 'length', 'm', 2], W: ['Load at one end', 'force', 'n', 600], F: ['Effort at the other end', 'force', 'n', 200] },
        out: 'length',
        outUnit: 'm',
        label: 'Fulcrum distance from the load',
        rows: { other: ['Distance from the effort', 'length'], ma: 'Mechanical advantage' },
        run: (x) => {
            const dl = (x.L * x.F) / (x.W + x.F);

            return { value: dl, sub: `${num(x.L - dl)} m from the effort`, rows: { other: [x.L - dl, 'length'], ma: num(x.W / x.F) }, steps: ['Balance: W × d_load = F × d_effort, d_load + d_effort = L', `d_load = L F ÷ (W + F) = ${num(dl)} m`, 'The bar’s own weight is ignored'] };
        },
    },
    gear_ratio: {
        type: 'calc',
        inputs: { stages: ['Stages: driver teeth, driven teeth (one pair per line)', 'textarea', null, '12, 36\n15, 45'], rpm: ['Input speed (rpm)', null, null, 1500, 0], T: ['Input torque (optional)', 'torque', 'nm', 10], eff: ['Efficiency per stage (%)', null, null, 98, 0] },
        optional: ['T'],
        label: 'Overall gear ratio',
        rows: { out: 'Output speed', torque: 'Output torque', each: 'Stage ratios', dir: 'Output direction (external gears)' },
        run: (x) => {
            const st = readPairs(x.stages);

            if (!st) {
                return { empty: 'Type each stage as driver teeth, driven teeth.' };
            }

            const i = st.reduce((p, [a, b]) => p * (b / a), 1);
            const eff = (x.eff / 100) ** st.length;

            return { value: `${num(i, 5)} : 1`, sub: i > 1 ? 'Reduction: slower, more torque' : 'Overdrive: faster, less torque', rows: { out: `${num(x.rpm / i)} rpm`, torque: Number.isFinite(x.T) ? `${num(x.T * i * eff)} N·m (with ${num(eff * 100, 4)}% overall efficiency)` : 'Enter an input torque', each: st.map(([a, b]) => `${b}/${a} = ${num(b / a, 4)}`).join(', '), dir: st.length % 2 ? 'Reversed' : 'Same as the input' }, steps: ['i = Π (driven ÷ driver)', `= ${st.map(([a, b]) => `${b}/${a}`).join(' × ')} = ${num(i)}`, `n_out = ${num(x.rpm)} ÷ ${num(i)} = ${num(x.rpm / i)} rpm`] };
        },
    },
    lever: {
        type: 'law',
        vars: { Fe: ['Effort force', 'force', 'n', 200], de: ['Effort arm', 'length', 'm', 1.5], Fl: ['Load force', 'force', 'n', 600], dl: ['Load arm', 'length', 'm', 0.5] },
        default: 'Fe',
        eq: 'F_e d_e = F_l d_l',
        forms: { Fe: 'F_e = F_l d_l ÷ d_e', de: 'd_e = F_l d_l ÷ F_e', Fl: 'F_l = F_e d_e ÷ d_l', dl: 'd_l = F_e d_e ÷ F_l' },
        solve: { Fe: (v) => (v.Fl * v.dl) / v.de, de: (v) => (v.Fl * v.dl) / v.Fe, Fl: (v) => (v.Fe * v.de) / v.dl, dl: (v) => (v.Fe * v.de) / v.Fl },
        rows: { ma: 'Mechanical advantage', classes: 'Lever classes' },
        extra: (v) => ({ ma: num(v.Fl / v.Fe), classes: 'Class 1: fulcrum between (seesaw); class 2: load between (wheelbarrow); class 3: effort between (tweezers). The balance equation is the same for all three.' }),
    },
    linear_actuator: {
        type: 'calc',
        inputs: { m: ['Lid or hatch mass', 'mass', 'kg', 20], c: ['Hinge to the lid’s centre of mass', 'length', 'cm', 40], a: ['Hinge to the actuator mount on the lid', 'length', 'cm', 15], bx: ['Base mount: distance along the lid from the hinge', 'length', 'cm', 5], by: ['Base mount: distance below the hinge', 'length', 'cm', 20], open: ['Fully open angle', 'angle', 'deg', 80], n: ['Number of actuators', null, null, 1, 1] },
        out: 'force',
        outUnit: 'n',
        label: 'Maximum force per actuator',
        rows: { closed: ['Force with the lid closed', 'force'], stroke: ['Stroke needed', 'length'], lengths: 'Installed length (closed → open)' },
        plots: [['force', 'Force needed as the lid opens']],
        run: (x) => {
            const at = (th) => {
                const A = [x.a * Math.cos(th), x.a * Math.sin(th)];
                const v = [A[0] - x.bx, A[1] + x.by];
                const len = Math.hypot(v[0], v[1]);
                const arm = Math.abs(A[0] * (v[1] / len) - A[1] * (v[0] / len));
                const M = x.m * g0 * x.c * Math.cos(th);

                return { F: M / arm / x.n, len };
            };
            const pts = Array.from({ length: 81 }, (_, k) => (x.open * k) / 80);
            const res = pts.map(at);
            const Fmax = Math.max(...res.map((r) => r.F));

            if (!Number.isFinite(Fmax)) {
                return { error: 'At some angle the actuator lines up with the hinge and cannot hold the lid; move a mount point.' };
            }

            const lens = res.map((r) => r.len);

            return { value: Fmax, sub: 'Static force to hold the lid (add a margin for speed and friction)', rows: { closed: [res[0].F, 'force'], stroke: [Math.max(...lens) - Math.min(...lens), 'length'], lengths: `${num(lens[0] * 100)} cm → ${num(lens[lens.length - 1] * 100)} cm` }, steps: ['Moment of the lid about the hinge: M = mgc cos θ', 'Actuator force F = M ÷ (lever arm of the actuator line about the hinge)', `Largest over 0–${num(x.open / D)}°: ${num(Fmax)} N per actuator`], plots: { force: { series: pts.map((th, k) => [th / D, res[k].F]), axes: true, xLabel: 'Opening angle (°)', yLabel: 'Force (N)' } } };
        },
    },
    mech_advantage: {
        type: 'calc',
        inputs: { machine: ['Machine', 'select', { lever: 'Lever', pulley: 'Pulley system', wheel: 'Wheel and axle', ramp: 'Inclined plane (ramp)', screw: 'Screw', wedge: 'Wedge' }, 'pulley'], e: ['Effort arm or wheel radius or ramp length or handle radius or wedge length', 'length', 'cm', 100], l: ['Load arm or axle radius or ramp height or thread lead or wedge thickness', 'length', 'cm', 25], ropes: ['Rope segments supporting the load', null, null, 4, 1], load: ['Load (optional)', 'force', 'n', 1000] },
        show: { e: 'machine:lever,wheel,ramp,screw,wedge', l: 'machine:lever,wheel,ramp,screw,wedge', ropes: 'machine:pulley' },
        when: { e: (x) => x.machine !== 'pulley', l: (x) => x.machine !== 'pulley', ropes: (x) => x.machine === 'pulley' },
        optional: ['load'],
        label: 'Ideal mechanical advantage',
        rows: { effort: 'Effort needed for that load (no friction)', distance: 'Effort distance per unit of load movement' },
        run: (x) => {
            const ma = x.machine === 'pulley' ? x.ropes : x.machine === 'screw' ? (2 * Math.PI * x.e) / x.l : x.e / x.l;
            const formula = { lever: 'MA = effort arm ÷ load arm', pulley: 'MA = number of supporting rope segments', wheel: 'MA = wheel radius ÷ axle radius', ramp: 'MA = length ÷ height', screw: 'MA = 2π × handle radius ÷ lead', wedge: 'MA = length ÷ thickness' }[x.machine];

            return { value: num(ma, 5), sub: formula, rows: { effort: Number.isFinite(x.load) ? `${num(x.load / ma)} N` : 'Enter a load', distance: `${num(ma)} ×` }, steps: [formula, `= ${num(ma)}`, 'Real machines lose some of this to friction'] };
        },
    },
    npsh: {
        type: 'calc',
        inputs: { liquid: ['Liquid', 'select', { water: 'Water (IAPWS-IF97)', custom: 'Other liquid' }, 'water'], T: ['Liquid temperature', 'temperature', 'c', 20], Ps: ['Pressure on the liquid surface (absolute)', 'pressure', 'kpa', 101.325], z: ['Liquid level above the pump inlet (negative for a suction lift)', 'length', 'm', -3], hf: ['Suction line losses', 'length', 'm', 0.5], pv: ['Vapour pressure', 'pressure', 'kpa', 3], rho: ['Density', 'density', 'kgm3', 1000], req: ['NPSH required by the pump (optional)', 'length', 'm', 3] },
        show: { pv: 'liquid:custom', rho: 'liquid:custom', T: 'liquid:water' },
        when: { pv: (x) => x.liquid === 'custom', rho: (x) => x.liquid === 'custom', T: (x) => x.liquid === 'water' },
        optional: ['req'],
        out: 'length',
        outUnit: 'm',
        label: 'NPSH available',
        rows: { pv: ['Vapour pressure', 'pressure'], head: ['Pressure head (Pₛ − Pᵥ) ÷ ρg', 'length'], margin: 'Margin over NPSH required' },
        run: (x) => {
            const water = x.liquid === 'water';

            if (water && !(x.T > 273.15 && x.T < 573)) {
                return { error: 'Water temperature must be between 0 and 300 °C.' };
            }

            const pv = water ? waterVapourPressure(x.T) : x.pv;
            const rho = water ? waterDensity(x.T - 273.15) : x.rho;
            const head = (x.Ps - pv) / (rho * g0);
            const npsha = head + x.z - x.hf;

            return { value: npsha, sub: Number.isFinite(x.req) ? (npsha - x.req >= 1 ? 'Comfortable margin' : npsha > x.req ? 'Thin margin: aim for at least 0.5–1 m (or 10–30%)' : 'Cavitation likely') : 'Compare with the pump’s NPSHr', rows: { pv: [pv, 'pressure'], head: [head, 'length'], margin: Number.isFinite(x.req) ? `${num(npsha - x.req)} m (ratio ${num(npsha / x.req, 3)})` : 'Enter NPSHr' }, steps: ['NPSHa = (Pₛ − Pᵥ) ÷ ρg + z − h_f', `Pᵥ = ${num(pv)} Pa, ρ = ${num(rho)} kg/m³${water ? ' (IAPWS-IF97, Kell)' : ''}`, `= ${num(head)} + ${num(x.z)} − ${num(x.hf)} = ${num(npsha)} m`] };
        },
    },
    piston_force: {
        type: 'calc',
        inputs: { P: ['Pressure', 'pressure', 'bar', 100], bore: ['Bore', 'length', 'mm', 63], rod: ['Rod diameter', 'length', 'mm', 36] },
        out: 'force',
        outUnit: 'kn',
        label: 'Extending (push) force',
        rows: { pull: ['Retracting (pull) force', 'force'], kg: 'Push force as a mass', area: 'Piston and annulus areas' },
        run: (x) => {
            const A = (Math.PI * x.bore ** 2) / 4;
            const a = A - (Math.PI * x.rod ** 2) / 4;

            if (!(x.rod < x.bore)) {
                return { error: 'The rod must be thinner than the bore.' };
            }

            return { value: x.P * A, sub: `Pull ${num((x.P * a) / 1000)} kN`, rows: { pull: [x.P * a, 'force'], kg: `${num((x.P * A) / g0)} kg`, area: `${num(A * 1e6)} mm², ${num(a * 1e6)} mm²` }, steps: ['Push F = P × πD²/4', `= ${num(x.P)} Pa × ${num(A)} m² = ${num(x.P * A)} N`, 'Pull F = P × π(D² − d²)/4', 'Seal friction takes roughly 5–10% off'] };
        },
    },
    piston_speed: {
        type: 'calc',
        inputs: { stroke: ['Stroke', 'length', 'mm', 86], rpm: ['Engine speed (rpm)', null, null, 7000, 0], rod: ['Connecting rod length (optional)', 'length', 'mm', 143] },
        optional: ['rod'],
        out: 'speed',
        outUnit: 'ms',
        label: 'Mean piston speed',
        rows: { max: ['Peak piston speed', 'speed'], at: 'Crank angle of the peak', limit: 'Typical limits' },
        run: (x) => {
            const mean = (2 * x.stroke * x.rpm) / 60;
            const r = x.stroke / 2;
            const w = (x.rpm * 2 * Math.PI) / 60;
            let peak = NaN;
            let at = NaN;

            if (Number.isFinite(x.rod) && x.rod > r) {
                for (let k = 0; k <= 1800; k += 1) {
                    const th = (k / 1800) * Math.PI;
                    const v = r * w * (Math.sin(th) + (r * Math.sin(2 * th)) / (2 * Math.sqrt(x.rod ** 2 - r * r * Math.sin(th) ** 2)));

                    if (!(v <= peak)) {
                        [peak, at] = [v, th];
                    }
                }
            }

            return { value: mean, sub: `${num(mean / 0.00508)} ft/min`, rows: { max: Number.isFinite(peak) ? [peak, 'speed'] : 'Enter the rod length', at: Number.isFinite(at) ? `${num(at / D, 4)}° after top dead centre` : 'Enter the rod length', limit: 'Road engines up to about 20–25 m/s mean; F1 about 25 m/s' }, steps: ['v_mean = 2 × stroke × rpm ÷ 60', `= 2 × ${num(x.stroke)} × ${num(x.rpm)} ÷ 60 = ${num(mean)} m/s`] };
        },
    },
    prop_pitch: {
        type: 'calc',
        inputs: { v: ['Boat speed', 'speed', 'knot', 30], rpm: ['Engine speed (rpm)', null, null, 5000, 0], gear: ['Gear ratio', null, null, 2, 0], slip: ['Slip (%)', null, null, 10, 0] },
        out: 'length',
        outUnit: 'in',
        label: 'Propeller pitch',
        rows: { prpm: 'Propeller rpm', theory: ['Theoretical speed for that pitch', 'speed'] },
        run: (x) => {
            const prpm = x.rpm / x.gear;
            const pitch = (x.v * 60) / (prpm * (1 - x.slip / 100));

            return { value: pitch, sub: `At ${num(prpm)} propeller rpm`, rows: { prpm: num(prpm), theory: [(pitch * prpm) / 60, 'speed'] }, steps: ['Pitch = speed ÷ (prop rpm × (1 − slip))', `= ${num(x.v * 60 / IN)} in/min ÷ (${num(prpm)} × ${num(1 - x.slip / 100)}) = ${num(pitch / IN)} in`] };
        },
    },
    prop_slip: {
        type: 'calc',
        inputs: { pitch: ['Propeller pitch', 'length', 'in', 21], rpm: ['Engine speed (rpm)', null, null, 5000, 0], gear: ['Gear ratio', null, null, 2, 0], v: ['Actual boat speed', 'speed', 'knot', 30] },
        label: 'Propeller slip',
        rows: { theory: ['Theoretical speed', 'speed'], typical: 'Typical slip' },
        run: (x) => {
            const theory = (x.pitch * (x.rpm / x.gear)) / 60;
            const slip = 1 - x.v / theory;

            return { value: num(slip * 100, 4), unit: '%', sub: `Theoretical ${num(theory / 0.514444, 4)} knots`, rows: { theory: [theory, 'speed'], typical: 'Planing boats 8–15%, displacement hulls 25–45%' }, steps: ['Theoretical speed = pitch × prop rpm', `= ${num(theory)} m/s`, `Slip = 1 − actual ÷ theoretical = ${num(slip * 100)}%`] };
        },
    },
    pulley: {
        type: 'calc',
        inputs: { mode: ['Set-up', 'select', { belt: 'Two pulleys on a belt', block: 'Block and tackle' }, 'belt'], D1: ['Driver pulley diameter', 'length', 'mm', 100], n1: ['Driver speed (rpm)', null, null, 1450, 0], D2: ['Driven pulley diameter', 'length', 'mm', 250], W: ['Load', 'mass', 'kg', 200], lines: ['Supporting lines', null, null, 4, 1], e: ['Efficiency per sheave (%)', null, null, 96, 0] },
        show: { D1: 'mode:belt', n1: 'mode:belt', D2: 'mode:belt', W: 'mode:block', lines: 'mode:block', e: 'mode:block' },
        when: { D1: (x) => x.mode === 'belt', n1: (x) => x.mode === 'belt', D2: (x) => x.mode === 'belt', W: (x) => x.mode === 'block', lines: (x) => x.mode === 'block', e: (x) => x.mode === 'block' },
        label: 'Result',
        rows: { a: 'Ratio', b: 'Detail' },
        run: (x) => {
            if (x.mode === 'belt') {
                const n2 = (x.D1 * x.n1) / x.D2;

                return { value: num(n2, 5), unit: 'rpm', label: 'Driven pulley speed', sub: `Belt speed ${num((Math.PI * x.D1 * x.n1) / 60)} m/s`, rows: { a: `${num(x.D2 / x.D1, 4)} : 1`, b: `Torque × ${num(x.D2 / x.D1, 4)} on the driven shaft (before losses)` }, steps: ['D₁n₁ = D₂n₂', `n₂ = ${num(x.D1 * 1000)} × ${num(x.n1)} ÷ ${num(x.D2 * 1000)} = ${num(n2)} rpm`] };
            }

            const e = x.e / 100;
            const eta = e === 1 ? 1 : (1 - e ** x.lines) / (x.lines * (1 - e));
            const F = (x.W * g0) / (x.lines * eta);

            return { value: num(F, 5), unit: 'N', label: 'Pull needed', sub: `${num(F / g0, 4)} kg-force; ideal ${num((x.W * g0) / x.lines, 5)} N`, rows: { a: `Ideal MA ${num(x.lines)}, actual ${num(x.lines * eta, 4)}`, b: `Pull ${num(x.lines)} m of rope per metre of lift; system efficiency ${num(eta * 100, 4)}%` }, steps: ['Ideal: F = W ÷ n', 'With sheave efficiency e: η = (1 − eⁿ) ÷ (n(1 − e))', `F = ${num(x.W * g0)} ÷ (${num(x.lines)} × ${num(eta)}) = ${num(F)} N`] };
        },
    },
    pump_power: {
        type: 'calc',
        inputs: { Q: ['Flow rate', 'flow', 'm3h', 30], mode: ['Head given as', 'select', { head: 'Height (head)', pressure: 'Pressure rise' }, 'head'], H: ['Total head', 'length', 'm', 20], dP: ['Pressure rise', 'pressure', 'bar', 2], sg: ['Specific gravity', null, null, 1, 0], eff: ['Pump efficiency (%)', null, null, 70, 0] },
        show: { H: 'mode:head', dP: 'mode:pressure' },
        when: { H: (x) => x.mode === 'head', dP: (x) => x.mode === 'pressure' },
        out: 'power',
        outUnit: 'kw',
        label: 'Shaft power',
        rows: { hyd: ['Hydraulic power', 'power'], motor: ['Motor with a 15% margin', 'power'] },
        run: (x) => {
            const hyd = x.mode === 'head' ? x.sg * 999.97 * g0 * x.Q * x.H : x.dP * x.Q;
            const shaft = hyd / (x.eff / 100);

            return { value: shaft, sub: `${num(shaft / 745.7)} hp`, rows: { hyd: [hyd, 'power'], motor: [shaft * 1.15, 'power'] }, steps: [x.mode === 'head' ? 'P_hyd = ρgQH' : 'P_hyd = ΔP Q', `= ${num(hyd)} W`, `Shaft power = P_hyd ÷ η = ${num(shaft)} W`] };
        },
    },
    shaft_size: {
        type: 'calc',
        inputs: { M: ['Bending moment', 'torque', 'nm', 300], T: ['Torque', 'torque', 'nm', 500], mat: ['Material', 'select', 'data:materials', 'steel_4140'], sy: ['Yield strength', 'pressure', 'mpa', 400], n: ['Safety factor', null, null, 2, 1] },
        show: { sy: 'mat:custom' },
        when: { sy: (x) => x.mat === 'custom' },
        data: ['materials'],
        out: 'length',
        outUnit: 'mm',
        label: 'Minimum solid shaft diameter',
        rows: { tresca: ['By maximum shear (Tresca)', 'length'], sy: ['Yield strength used', 'pressure'] },
        run: (x, ctx) => {
            const m = ctx.c.data.physics.materials[x.mat];
            const sy = x.mat === 'custom' ? x.sy : (m?.yield ?? NaN) * 1e6;

            if (!Number.isFinite(sy)) {
                return { error: 'This material has no yield strength (it is brittle); choose another or enter one.' };
            }

            const de = ((32 * x.n) / (Math.PI * sy) * Math.sqrt(x.M ** 2 + 0.75 * x.T ** 2)) ** (1 / 3);
            const tr = ((32 * x.n) / (Math.PI * sy) * Math.sqrt(x.M ** 2 + x.T ** 2)) ** (1 / 3);

            return { value: de, sub: 'Static loading, distortion-energy (von Mises) criterion', rows: { tresca: [tr, 'length'], sy: [sy, 'pressure'] }, steps: ['d = [32n ÷ (πS_y) × √(M² + ¾T²)]^(1/3)', `= ${num(de * 1000)} mm`, 'Rotating shafts carry fully reversed bending: check fatigue (Goodman) and keyway stress concentrations before choosing a size'] };
        },
    },
    speeds_feeds: {
        type: 'calc',
        inputs: { work: ['Workpiece material', 'select', 'data:cutting:fixed', 'aluminium'], tool: ['Tool material', 'select', { 0: 'High-speed steel', 1: 'Carbide' }, '1'], D: ['Cutter diameter', 'length', 'in', 0.5], z: ['Number of flutes', null, null, 3, 1], cl: ['Chip load per tooth', 'length', 'in', 0.002] },
        data: ['cutting'],
        label: 'Spindle speed',
        rows: { feed: 'Feed rate', sfm: 'Cutting speed used', note: 'Chip load guide' },
        run: (x, ctx) => {
            const sfm = ctx.c.data.physics.cutting[x.work].sfm[Number(x.tool)];
            const Din = x.D / IN;
            const rpm = (sfm * 12) / (Math.PI * Din);
            const ipm = rpm * x.z * (x.cl / IN);

            return { value: num(Math.round(rpm), 6), unit: 'rpm', sub: `Feed ${num(ipm, 4)} in/min (${num(ipm * 25.4, 4)} mm/min)`, rows: { feed: `${num(ipm, 4)} in/min = ${num(ipm * 25.4, 4)} mm/min`, sfm: `${sfm} SFM = ${num(sfm * 0.3048, 4)} m/min`, note: 'Start around 0.5–1% of the diameter per tooth for aluminium, less for steel; reduce for slotting or long reach' }, steps: ['rpm = SFM × 12 ÷ (π D)', `= ${sfm} × 12 ÷ (π × ${num(Din)}) = ${num(rpm)} rpm`, 'Feed = rpm × flutes × chip load', `= ${num(rpm)} × ${num(x.z)} × ${num(x.cl / IN)} = ${num(ipm)} in/min`, 'Starting values: adjust for machine rigidity, coolant and tool maker data'] };
        },
    },
    spring: {
        type: 'calc',
        inputs: { wire: ['Wire material', 'select', 'data:spring_wire:fixed', 'music'], d: ['Wire diameter', 'length', 'mm', 2], Dm: ['Mean coil diameter', 'length', 'mm', 20], n: ['Active coils', null, null, 8, 0], F: ['Load (optional)', 'force', 'n', 50] },
        optional: ['F'],
        data: ['spring_wire'],
        out: 'stiffness',
        outUnit: 'npmm',
        label: 'Spring rate',
        rows: { C: 'Spring index D/d', stress: ['Shear stress at that load (Wahl-corrected)', 'pressure'], defl: ['Deflection at that load', 'length'], solid: ['Solid height (squared and ground ends)', 'length'] },
        run: (x, ctx) => {
            const G = ctx.c.data.physics.spring_wire[x.wire].G * 1e9;
            const k = (G * x.d ** 4) / (8 * x.Dm ** 3 * x.n);
            const C = x.Dm / x.d;
            const Kw = (4 * C - 1) / (4 * C - 4) + 0.615 / C;
            const has = Number.isFinite(x.F);

            return { value: k, sub: `Index ${num(C, 3)}${C < 4 || C > 12 ? ' (outside the easy 4–12 range)' : ''}`, rows: { C: num(C, 4), stress: has ? [(Kw * 8 * x.F * x.Dm) / (Math.PI * x.d ** 3), 'pressure'] : 'Enter a load', defl: has ? [x.F / k, 'length'] : 'Enter a load', solid: [(x.n + 2) * x.d, 'length'] }, steps: ['k = Gd⁴ ÷ (8D³n)', `= ${num(G / 1e9)} GPa × ${num(x.d * 1000)}⁴ ÷ (8 × ${num(x.Dm * 1000)}³ × ${num(x.n)}) mm = ${num(k / 1000)} N/mm`, `Wahl factor K_w = (4C − 1)/(4C − 4) + 0.615/C = ${num(Kw)}`] };
        },
    },
    spring_rate: pw({ vars: { k: ['Spring rate', 'stiffness', 'npmm', 10], F: ['Force', 'force', 'n', 100], x: ['Deflection', 'length', 'mm', 10] }, out: 'k', exp: { F: 1, x: -1 }, eq: 'k = F ÷ x', forms: { k: 'k = F ÷ x', F: 'F = kx', x: 'x = F ÷ k' }, rows: { energy: ['Energy stored', 'energy'] }, extra: (v) => ({ energy: [0.5 * v.F * v.x, 'energy'] }) }),
    spring_convert: {
        type: 'calc',
        inputs: { k: ['Spring rate', 'stiffness', 'lbfpin', 500] },
        out: 'stiffness',
        outUnit: 'npmm',
        label: 'Converted spring rate',
        rows: { npm: ['In N/m', 'stiffness'], all: 'Every unit' },
        run: (x, ctx) => {
            const units = ctx.c.data.units.stiffness;

            return { value: x.k, sub: '1 lbf/in = 0.175127 N/mm; 1 kgf/mm = 9.80665 N/mm', rows: { npm: [x.k, 'stiffness'], all: Object.values(units).map((u) => `${num(x.k / u.factor, 5)} ${u.symbol}`).join(', ') }, steps: [`k = ${num(x.k)} N/m`] };
        },
    },
    torsion_spring: {
        type: 'calc',
        inputs: { wire: ['Wire material', 'select', 'data:spring_wire:fixed', 'music'], d: ['Wire diameter', 'length', 'mm', 2], Dm: ['Mean coil diameter', 'length', 'mm', 16], n: ['Body coils', null, null, 6, 0], L1: ['Leg 1 length', 'length', 'mm', 25], L2: ['Leg 2 length', 'length', 'mm', 25] },
        data: ['spring_wire'],
        out: 'rotational_stiffness',
        outUnit: 'nmdeg',
        label: 'Torsional rate',
        rows: { rad: ['Per radian', 'rotational_stiffness'], Na: 'Active coils including the legs', nmm: 'In N·mm per degree' },
        run: (x, ctx) => {
            const E = ctx.c.data.physics.spring_wire[x.wire].E * 1e9;
            const Na = x.n + (x.L1 + x.L2) / (3 * Math.PI * x.Dm);
            const k = (E * x.d ** 4) / (64 * x.Dm * Na);

            return { value: k, sub: `${num(k * D * 1000)} N·mm per degree`, rows: { rad: [k, 'rotational_stiffness'], Na: num(Na, 4), nmm: `${num(k * D * 1000)} N·mm/°` }, steps: ['k = Ed⁴ ÷ (64 D N_a) per radian, N_a = N_b + (L₁ + L₂) ÷ 3πD', `N_a = ${num(Na)}, k = ${num(k)} N·m/rad`, 'Shigley adds about 5% for coil friction (use 10.8 instead of 10.2 in the per-turn form)'] };
        },
    },
    transmission: {
        type: 'calc',
        inputs: { gears: ['Gear ratios (first to top, comma or line separated)', 'textarea', null, '3.36, 2.07, 1.43, 1.00, 0.84, 0.56'], final: ['Final drive ratio', null, null, 3.42, 0], tyre: ['Tyre diameter', 'length', 'in', 27], rpm: ['Engine speed (rpm)', null, null, 2500, 0] },
        out: 'speed',
        outUnit: 'kmh',
        label: 'Speed in top gear',
        rows: { drop: 'rpm after each upshift' },
        grids: [['gears', 'Speed in each gear']],
        run: (x) => {
            const g = readList(x.gears);

            if (!g.length) {
                return { empty: 'Enter the gear ratios.' };
            }

            const circ = Math.PI * x.tyre;
            const v = g.map((r) => ((x.rpm / (r * x.final)) * circ) / 60);

            return { value: v[v.length - 1], sub: `At ${num(x.rpm)} rpm (no tyre growth or slip)`, rows: { drop: g.slice(1).map((r, k) => `${k + 1}→${k + 2}: ${num((x.rpm * r) / g[k], 4)}`).join(', ') || 'Only one gear' }, steps: ['v = rpm × tyre circumference ÷ (gear × final drive)', `Tyre circumference ${num(circ)} m`], grids: { gears: { columns: ['Ratio', 'Overall', 'km/h', 'mph'], rows: g.map((r, k) => ({ header: `Gear ${k + 1}`, cells: [num(r, 4), num(r * x.final, 4), num(v[k] * 3.6, 4), num(v[k] / 0.44704, 4)] })) } } };
        },
    },
    twist_rate: {
        type: 'calc',
        inputs: { d: ['Bullet diameter', 'length', 'in', 0.308], L: ['Bullet length', 'length', 'in', 1.215], m: ['Bullet weight', 'mass', 'gr', 168], v: ['Muzzle velocity', 'speed', 'fts', 2700], s: ['Target stability factor', null, null, 1.5, 1] },
        out: 'length',
        outUnit: 'in',
        label: 'Slowest twist for stability (1 turn in)',
        rows: { cal: 'Twist in calibers', sg: 'Stability with a 1:10 twist' },
        run: (x) => {
            const d = x.d / IN;
            const l = x.L / x.d;
            const gr = x.m / 6.479891e-5;
            const fv = ((x.v / 0.3048) / 2800) ** (1 / 6);
            const t = Math.sqrt((30 * gr) / (x.s * d ** 3 * l * (1 + l * l))) * fv;
            const sg10 = (30 * gr) / ((10 / d) ** 2 * d ** 3 * l * (1 + l * l)) * ((x.v / 0.3048) / 2800) ** (1 / 3);

            return { value: t * d * IN, sub: `1:${num(t * d, 3)} in or faster (Miller rule, standard air)`, rows: { cal: num(t, 4), sg: `${num(sg10, 3)}${sg10 < 1.3 ? ' (marginal)' : ''}` }, steps: ['Miller: S_g = 30m ÷ (t² d³ l (1 + l²)) × (v ÷ 2800)^(1/3), m in grains, d in inches, t and l in calibers', `l = ${num(l)} calibers`, `For S_g = ${num(x.s)}: t = ${num(t)} calibers = ${num(t * d)} in`] };
        },
    },
    wing_loading: {
        type: 'calc',
        inputs: { m: ['Aircraft mass', 'mass', 'kg', 1100], S: ['Wing area', 'area', 'm2', 16.2], cl: ['Maximum lift coefficient (for stall speed)', null, null, 1.6, 0] },
        label: 'Wing loading',
        rows: { si: 'In N/m²', imp: 'In lb/ft²', stall: 'Stall speed at sea level', compare: 'For comparison' },
        run: (x) => {
            const wl = x.m / x.S;
            const vs = Math.sqrt((2 * x.m * g0) / (1.225 * x.S * x.cl));

            return { value: num(wl, 5), unit: 'kg/m²', sub: `Stall speed about ${num(vs / 0.514444, 3)} knots`, rows: { si: `${num(wl * g0, 5)} N/m²`, imp: `${num(wl * 0.204816, 4)} lb/ft²`, stall: `${num(vs, 4)} m/s = ${num(vs / 0.514444, 3)} kn`, compare: 'Paraglider ≈ 4 kg/m², Cessna 172 ≈ 70, airliner ≈ 600–750 kg/m²' }, steps: ['Wing loading = W ÷ S', `= ${num(x.m)} ÷ ${num(x.S)} = ${num(wl)} kg/m²`, `Stall: v = √(2W ÷ ρSC_Lmax) = ${num(vs)} m/s`] };
        },
    },
    screw_jack: {
        type: 'calc',
        inputs: { F: ['Load', 'force', 'kn', 10], thread: ['Thread', 'select', Object.fromEntries(Object.entries(THREADS).map(([k, v]) => [k, v[0]])), 'trapezoidal'], dm: ['Mean thread diameter', 'length', 'mm', 30], lead: ['Lead', 'length', 'mm', 6], mu: ['Thread friction μ', null, null, 0.15, 0], dc: ['Collar mean diameter (0 if none)', 'length', 'mm', 40], muc: ['Collar friction μ', null, null, 0.15, 0], r: ['Handle radius', 'length', 'cm', 30] },
        out: 'force',
        outUnit: 'n',
        label: 'Effort on the handle to raise',
        rows: { Tr: ['Torque to raise', 'torque'], Tl: ['Torque to lower', 'torque'], eff: 'Efficiency', lock: 'Self-locking?' },
        run: (x) => {
            const sec = 1 / Math.cos(THREADS[x.thread][1] * D);
            const pd = Math.PI * x.dm;
            const collar = (x.F * x.muc * x.dc) / 2;
            const Tr = ((x.F * x.dm) / 2) * ((x.lead + Math.PI * x.mu * x.dm * sec) / (pd - x.mu * x.lead * sec)) + collar;
            const Tl = ((x.F * x.dm) / 2) * ((Math.PI * x.mu * x.dm * sec - x.lead) / (pd + x.mu * x.lead * sec)) + collar;
            const eff = (x.F * x.lead) / (2 * Math.PI * Tr);

            return { value: Tr / x.r, sub: `Efficiency ${num(eff * 100, 3)}%`, rows: { Tr: [Tr, 'torque'], Tl: [Tl, 'torque'], eff: `${num(eff * 100, 4)}%`, lock: Math.PI * x.mu * x.dm * sec > x.lead ? 'Yes: the load cannot drive the screw down' : 'No: the load can back-drive the screw' }, steps: ['T_raise = (F d_m/2)(l + πμd_m sec α) ÷ (πd_m − μl sec α) + F μ_c d_c/2', `= ${num(Tr)} N·m`, `Effort = T ÷ handle radius = ${num(Tr / x.r)} N`] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
