import { defineTools } from '../engines/formula.js';
import { formatMoney } from '../currency.js';
import { handlersFor } from '../physics/core.js';
import { N, SEL, TXT, num, pct } from '../statistics/common.js';
import { parseNumbers } from '../statistics/data.js';

/**
 * Electronics, PCB and computing: batteries, impedances, attenuators, regulators, PCB traces (IPC-2221 and
 * IPC-2141 design equations, labelled as estimates), RF units, distortion, RAID, RAM latency, drones and
 * printing costs. Inputs arrive in SI (lengths in m, power in W) via the Physics engine.
 */

const C0 = 299792458;
const MU0 = 1.25663706212e-6;
const EPS0 = 8.8541878128e-12;
const RHO_CU = 1.724e-8;
const ALPHA_CU = 0.00393;
const OZ_MIL = 1.378;
const MONEY = (label, value) => [label, 'money', null, value];
const L = (label, value, unit = 'mm') => [label, 'length', unit, value];

/** Nearest E24 resistor value. */
const E24 = [1.0, 1.1, 1.2, 1.3, 1.5, 1.6, 1.8, 2.0, 2.2, 2.4, 2.7, 3.0, 3.3, 3.6, 3.9, 4.3, 4.7, 5.1, 5.6, 6.2, 6.8, 7.5, 8.2, 9.1];
export function nearestE24(r) {
    if (!(r > 0)) {
        return NaN;
    }

    const decade = 10 ** Math.floor(Math.log10(r));
    const candidates = [...E24.map((v) => v * decade), 10 * decade];

    return candidates.reduce((a, b) => (Math.abs(Math.log(b / r)) < Math.abs(Math.log(a / r)) ? b : a));
}

const ohms = (r) => (r >= 1e6 ? `${num(r / 1e6, 4)} MΩ` : r >= 1e3 ? `${num(r / 1e3, 4)} kΩ` : `${num(r, 4)} Ω`);

/** IPC-2221 maximum current (A) for a cross-section in mil² and temperature rise (°C). */
export const ipcCurrent = (areaMil2, dT, internal) => (internal ? 0.024 : 0.048) * dT ** 0.44 * areaMil2 ** 0.725;

export const TOOLS = {
    print_cost: {
        type: 'calc',
        inputs: { weight: N('Part weight (g)', 120, 0), spoolPrice: MONEY('Filament price per kg', 22), hours: N('Print time (hours)', 6, 0), watts: N('Printer power (W)', 150, 0), kwh: MONEY('Electricity price per kWh', 0.15), wear: MONEY('Machine wear per hour', 0.2), labour: MONEY('Labour (setup and finishing)', 5), fail: N('Failure rate (%)', 10, 0), margin: N('Profit margin (%)', 0, 0) },
        label: 'Cost per print',
        rows: { material: 'Filament', energy: 'Electricity', machine: 'Machine wear', labourRow: 'Labour', price: 'Price with margin' },
        run: (x) => {
            if (!(x.fail >= 0 && x.fail < 100) || !(x.margin >= 0 && x.margin < 100)) {
                return { error: 'Failure rate and margin must be below 100%.' };
            }

            const material = (x.weight / 1000) * x.spoolPrice;
            const energy = ((x.watts * x.hours) / 1000) * x.kwh;
            const machine = x.wear * x.hours;
            const base = material + energy + machine + x.labour;
            const cost = base / (1 - x.fail / 100);

            return { value: formatMoney(cost), sub: `including ${num(x.fail)}% failed prints`, rows: { material: formatMoney(material), energy: formatMoney(energy), machine: formatMoney(machine), labourRow: formatMoney(x.labour), price: formatMoney(cost / (1 - x.margin / 100)) }, steps: ['Filament = weight ÷ 1000 × price per kg', 'Electricity = power × hours ÷ 1000 × price per kWh', 'Divide by (1 − failure rate) to spread the cost of failed prints', 'Price = cost ÷ (1 − margin)'] };
        },
    },
    amdahl: {
        type: 'calc',
        inputs: { p: N('Parallel part of the work (%)', 90, 0), n: N('Processors or cores', 8, 1), target: N('Target speedup (optional)', 5, 1) },
        optional: ['target'],
        label: 'Speedup',
        rows: { max: 'Maximum possible speedup', efficiency: 'Efficiency per processor', needed: 'Processors for the target' },
        plots: [['curve', 'Speedup by number of processors']],
        run: (x) => {
            const p = x.p / 100;

            if (!(p >= 0 && p <= 1)) {
                return { error: 'The parallel part is 0–100%.' };
            }

            const S = (n) => 1 / (1 - p + p / n);
            const max = p < 1 ? 1 / (1 - p) : Infinity;
            let needed = 'Enter a target';

            if (Number.isFinite(x.target)) {
                needed = x.target >= max ? `Impossible: the limit is ${num(max, 4)}×` : num(Math.ceil((p / (1 / x.target - (1 - p))) - 1e-9));
            }

            return { value: `${num(S(x.n), 5)}×`, sub: `${num(x.n)} processors, ${num(x.p)}% parallel`, rows: { max: Number.isFinite(max) ? `${num(max, 5)}×` : 'Unlimited', efficiency: pct(S(x.n) / x.n, 4), needed }, steps: ['Amdahl (1967): S = 1 ÷ ((1 − p) + p/N)', `= 1 ÷ (${num(1 - p)} + ${num(p)} ÷ ${num(x.n)}) = ${num(S(x.n), 6)}`, 'The serial part limits the speedup however many processors are added'], plots: { curve: { series: Array.from({ length: 64 }, (_, k) => [k + 1, S(k + 1)]), xLabel: 'Processors', yLabel: 'Speedup', yMin: 0 } } };
        },
    },
    battery_capacity: {
        type: 'calc',
        inputs: { mode: SEL('Find', { wh: 'Energy (Wh) from Ah and volts', ah: 'Capacity (Ah) from Wh and volts' }, 'wh'), v: N('Voltage (V)', 12, 0), ah: N('Capacity (Ah)', 100, 0), wh: N('Energy (Wh)', 1200, 0), load: N('Load (W, optional)', 60, 0) },
        show: { ah: 'mode:wh', wh: 'mode:ah' },
        when: { ah: (x) => x.mode === 'wh', wh: (x) => x.mode === 'ah' },
        optional: ['load'],
        label: 'Result',
        rows: { mah: 'In mAh', kwh: 'In kWh', runtime: 'Run time at the load (ideal)' },
        run: (x) => {
            if (!(x.v > 0)) {
                return { error: 'Enter a voltage above zero.' };
            }

            const wh = x.mode === 'wh' ? x.v * x.ah : x.wh;
            const ah = wh / x.v;

            return { value: x.mode === 'wh' ? `${num(wh, 6)} Wh` : `${num(ah, 6)} Ah`, sub: `${num(ah, 5)} Ah at ${num(x.v)} V = ${num(wh, 5)} Wh`, rows: { mah: num(ah * 1000, 6), kwh: num(wh / 1000, 6), runtime: x.load > 0 ? `${num(wh / x.load, 5)} h` : 'Enter a load' }, steps: ['Energy (Wh) = voltage × capacity (Ah)', 'Airlines limit carry-on lithium batteries by Wh (usually 100 Wh without approval)', 'Real run time is shorter: inverter losses, depth of discharge and temperature'] };
        },
    },
    battery_size: {
        type: 'calc',
        inputs: { load: N('Average load (W)', 300, 0), hours: N('Hours of backup (autonomy)', 8, 0), v: N('System voltage (V)', 24, 0), chem: SEL('Battery type', { lfp: 'LiFePO4 (90% usable)', nmc: 'Lithium-ion NMC (80% usable)', agm: 'Lead-acid AGM/gel (50% usable)', flooded: 'Flooded lead-acid (50% usable)' }, 'lfp'), eff: N('Inverter / system efficiency (%)', 90, 1), unit: N('Capacity of one battery (Ah, optional)', 100, 0), unitV: N('Voltage of one battery (V, optional)', 12, 0) },
        optional: ['unit', 'unitV'],
        label: 'Battery capacity needed',
        rows: { wh: 'Energy to store', usableWh: 'Energy used', layout: 'Batteries needed' },
        run: (x) => {
            const dod = { lfp: 0.9, nmc: 0.8, agm: 0.5, flooded: 0.5 }[x.chem];

            if (!(x.v > 0 && x.eff > 0 && x.eff <= 100)) {
                return { error: 'Voltage and efficiency must be positive (efficiency up to 100%).' };
            }

            const used = x.load * x.hours;
            const wh = used / (dod * (x.eff / 100));
            const ah = wh / x.v;
            let layout = 'Enter one battery’s Ah and V';

            if (x.unit > 0 && x.unitV > 0) {
                const series = Math.ceil(x.v / x.unitV - 1e-9);
                const parallel = Math.ceil(ah / x.unit - 1e-9);
                layout = x.v % x.unitV ? 'System voltage is not a multiple of the battery voltage' : `${series} in series × ${parallel} in parallel = ${series * parallel} batteries`;
            }

            return { value: `${num(ah, 5)} Ah at ${num(x.v)} V`, sub: `${num(wh / 1000, 4)} kWh of battery`, rows: { wh: `${num(wh, 5)} Wh`, usableWh: `${num(used, 5)} Wh`, layout }, steps: ['Energy used = load × hours', `Battery energy = used ÷ (usable depth of discharge ${pct(dod, 3)} × efficiency ${num(x.eff)}%)`, 'Capacity (Ah) = battery energy ÷ system voltage', 'Cold weather and ageing reduce capacity; add a margin'] };
        },
    },
    cable_impedance: {
        type: 'calc',
        inputs: { type: SEL('Cable', { coax: 'Coaxial', pair: 'Twisted or parallel pair' }, 'coax'), D: L('Shield inner diameter D (coax) or wire spacing s (pair, centre to centre)', 2.95), d: L('Inner conductor diameter d (or wire diameter)', 0.81), er: N('Dielectric constant εr', 2.25, 1) },
        label: 'Characteristic impedance Z₀',
        rows: { vf: 'Velocity factor', cap: 'Capacitance per metre', ind: 'Inductance per metre', delay: 'Delay per metre' },
        run: (x) => {
            if (!(x.D > x.d && x.d > 0)) {
                return { error: x.type === 'coax' ? 'The shield diameter must be larger than the inner conductor.' : 'The spacing must be larger than the wire diameter.' };
            }

            const geo = x.type === 'coax' ? Math.log(x.D / x.d) : Math.acosh(x.D / x.d);
            const z = x.type === 'coax' ? (60 / Math.sqrt(x.er)) * geo : (120 / Math.sqrt(x.er)) * geo;
            const c = x.type === 'coax' ? (2 * Math.PI * EPS0 * x.er) / geo : (Math.PI * EPS0 * x.er) / geo;
            const l = x.type === 'coax' ? (MU0 / (2 * Math.PI)) * geo : (MU0 / Math.PI) * geo;

            return { value: `${num(z, 5)} Ω`, sub: x.type === 'coax' ? 'Z₀ = (60/√εr) ln(D/d)' : 'Z₀ = (120/√εr) arcosh(s/d)', rows: { vf: num(1 / Math.sqrt(x.er), 4), cap: `${num(c * 1e12, 5)} pF/m`, ind: `${num(l * 1e9, 5)} nH/m`, delay: `${num((Math.sqrt(x.er) / C0) * 1e9, 4)} ns/m` }, steps: [x.type === 'coax' ? 'Coax: Z₀ = (60/√εr) ln(D/d) = (138/√εr) log₁₀(D/d)' : 'Parallel pair in a uniform dielectric: Z₀ = (120/√εr) arcosh(s/d)', 'Velocity factor = 1/√εr (solid PE ≈ 0.66, foam ≈ 0.8)', 'RG-58 (d 0.81 mm, D 2.95 mm, PE) gives about 50 Ω'] };
        },
    },
    crosstalk: {
        type: 'calc',
        inputs: { s: L('Spacing between traces (edge to edge)', 0.3), h: L('Height above the reference plane', 0.2) },
        label: 'Crosstalk (estimate)',
        rows: { db: 'In dB', rule: 'Spacing for under 5%', note: 'Note' },
        plots: [['curve', 'Crosstalk by spacing']],
        run: (x) => {
            if (!(x.s > 0 && x.h > 0)) {
                return { error: 'Enter positive spacing and height.' };
            }

            const k = (s) => 1 / (1 + (s / x.h) ** 2);

            return { value: pct(k(x.s), 3), sub: `s/h = ${num(x.s / x.h, 3)}`, rows: { db: `${num(20 * Math.log10(k(x.s)), 4)} dB`, rule: `s ≥ ${num(Math.sqrt(1 / 0.05 - 1) * x.h * 1000, 3)} mm (≈ 4.4 h)`, note: 'A first estimate for parallel microstrip; a field solver or simulation is needed for sign-off' }, steps: ['Coupling ≈ 1 ÷ (1 + (s/h)²) (design rule of thumb)', 'Halving the height to the plane, or tripling the spacing (3W rule), cuts crosstalk sharply'], plots: { curve: { series: Array.from({ length: 50 }, (_, j) => { const s = (x.h * (j + 1)) / 5; return [s * 1000, k(s) * 100]; }), xLabel: 'Spacing (mm)', yLabel: 'Crosstalk (%)', yMin: 0 } } };
        },
    },
    drone_flight: {
        type: 'calc',
        inputs: { mah: N('Battery capacity (mAh)', 5000, 0), cells: N('Cells in series (S)', 4, 1), usable: N('Usable capacity (%)', 80, 1), by: SEL('Average draw from', { amps: 'Current (A)', watts: 'Power (W)' }, 'amps'), amps: N('Average current (A)', 18, 0), watts: N('Average power (W)', 266, 0) },
        show: { amps: 'by:amps', watts: 'by:watts' },
        when: { amps: (x) => x.by === 'amps', watts: (x) => x.by === 'watts' },
        label: 'Flight time (estimate)',
        rows: { voltage: 'Nominal voltage', energy: 'Battery energy', current: 'Average current' },
        run: (x) => {
            const v = x.cells * 3.7;
            const i = x.by === 'amps' ? x.amps : x.watts / v;

            if (!(i > 0)) {
                return { error: 'Enter an average current or power above zero.' };
            }

            const minutes = ((x.mah / 1000) * (x.usable / 100) * 60) / i;

            return { value: `${num(minutes, 4)} min`, sub: `${num(x.mah)} mAh ${x.cells}S at ${num(i, 4)} A`, rows: { voltage: `${num(v, 4)} V (3.7 V per LiPo cell)`, energy: `${num((x.mah / 1000) * v, 5)} Wh`, current: `${num(i, 4)} A` }, steps: ['Time = usable capacity (Ah) ÷ average current × 60', 'Landing at about 20% charge protects LiPo batteries', 'Wind, aggressive flying and cold batteries shorten it'] };
        },
    },
    drone_motor: {
        type: 'calc',
        inputs: { weight: N('All-up weight (g)', 1200, 0), motors: SEL('Motors', { 3: '3 (tricopter)', 4: '4 (quadcopter)', 6: '6 (hexacopter)', 8: '8 (octocopter)' }, '4'), twr: SEL('Thrust-to-weight ratio', { 2: '2:1 (camera, gentle flying)', 3: '3:1 (sport)', 5: '5:1 (racing)', 8: '8:1 (racing, very agile)' }, '2') },
        label: 'Thrust needed per motor',
        rows: { total: 'Total thrust', hover: 'Thrust per motor at hover', note: 'Choosing a motor' },
        run: (x) => {
            const n = Number(x.motors);
            const t = Number(x.twr);

            return { value: `${num((x.weight * t) / n, 5)} g`, sub: `${t}:1 thrust-to-weight with ${n} motors`, rows: { total: `${num(x.weight * t, 5)} g`, hover: `${num(x.weight / n, 5)} g (${pct(1 / t, 3)} throttle-thrust)`, note: 'Pick a motor and propeller whose maker’s thrust table reaches this at full throttle on your battery voltage' }, steps: ['Thrust per motor = all-up weight × thrust-to-weight ratio ÷ motors', '2:1 is the minimum for stable control'] };
        },
    },
    duty_cycle: {
        type: 'calc',
        inputs: { on: [L('Pulse width (on time)', 0)[0], 'time', 'ms', 2], period: ['Period', 'time', 'ms', 10], v: N('Pulse voltage (V)', 5, 0) },
        label: 'Duty cycle',
        rows: { off: 'Off time', freq: 'Frequency', avg: 'Average voltage', rms: 'RMS voltage' },
        run: (x) => {
            if (!(x.period > 0 && x.on >= 0 && x.on <= x.period)) {
                return { error: 'The on time must be between 0 and the period.' };
            }

            const d = x.on / x.period;

            return { value: pct(d, 5), sub: `${num(x.on * 1000, 5)} ms on in ${num(x.period * 1000, 5)} ms`, rows: { off: `${num((x.period - x.on) * 1000, 5)} ms`, freq: `${num(1 / x.period, 5)} Hz`, avg: `${num(d * x.v, 5)} V`, rms: `${num(Math.sqrt(d) * x.v, 5)} V` }, steps: ['D = on time ÷ period', 'Average of a rectangular wave = D × peak; RMS = √D × peak'] };
        },
    },
    edpi: {
        type: 'calc',
        inputs: { dpi: N('Mouse DPI (CPI)', 800, 1), sens: N('In-game sensitivity', 1.5, 0), game: SEL('Game (for cm/360°)', { none: 'Other', cs: 'Counter-Strike 2 / Apex (yaw 0.022)', val: 'Valorant (yaw 0.07)', ow: 'Overwatch 2 (yaw 0.0066)' }, 'cs') },
        label: 'eDPI',
        rows: { cm360: 'Distance for a 360° turn', in360: 'In inches', note: 'Typical eDPI' },
        run: (x) => {
            const yaw = { cs: 0.022, val: 0.07, ow: 0.0066 }[x.game];
            const inch = yaw ? 360 / (x.dpi * x.sens * yaw) : NaN;

            return { value: num(x.dpi * x.sens, 6), sub: `${num(x.dpi)} DPI × ${num(x.sens)}`, rows: { cm360: yaw ? `${num(inch * 2.54, 4)} cm` : 'Choose a game', in360: yaw ? `${num(inch, 4)} in` : '—', note: 'CS2 professionals mostly play 600–1,200 eDPI' }, steps: ['eDPI = DPI × sensitivity, so players can compare settings', 'cm/360 = 360° ÷ (DPI × sensitivity × yaw) × 2.54, using the game’s degrees per mouse count'] };
        },
    },
    gsd: {
        type: 'calc',
        inputs: { sensor: N('Sensor width (mm)', 13.2, 0), focal: N('Focal length (mm)', 8.8, 0), imageW: N('Image width (pixels)', 5472, 1), imageH: N('Image height (pixels)', 3648, 1), height: ['Flight height', 'length', 'm', 100], target: N('Target GSD (cm/px, optional)', 2, 0) },
        optional: ['target'],
        label: 'Ground sample distance',
        rows: { footprint: 'Image footprint on the ground', area: 'Area covered', heightFor: 'Height for the target GSD' },
        run: (x) => {
            const gsd = (x.sensor * x.height * 100) / (x.focal * x.imageW);
            const w = (gsd * x.imageW) / 100;
            const h = (gsd * x.imageH) / 100;

            return { value: `${num(gsd, 4)} cm/px`, sub: `at ${num(x.height, 4)} m`, rows: { footprint: `${num(w, 5)} m × ${num(h, 5)} m`, area: `${num((w * h) / 10000, 4)} ha`, heightFor: x.target > 0 ? `${num((x.target * x.focal * x.imageW) / (x.sensor * 100), 5)} m` : 'Enter a target' }, steps: ['GSD = sensor width × flight height ÷ (focal length × image width)', `= ${num(x.sensor)} mm × ${num(x.height)} m ÷ (${num(x.focal)} mm × ${num(x.imageW)} px) × 100 = ${num(gsd, 6)} cm/px`, 'Defaults: a 1-inch, 20 MP mapping drone camera'] };
        },
    },
    impedance_matching: {
        type: 'calc',
        inputs: { rs: N('Source resistance Rs (Ω)', 50, 0), rl: N('Load resistance RL (Ω)', 200, 0), f: ['Frequency', 'frequency_hz', 'mhz', 14] },
        label: 'L-network (low-pass)',
        rows: { q: 'Loaded Q', series: 'Series element (low-pass)', shunt: 'Shunt element (low-pass)', highpass: 'High-pass version', placement: 'Placement' },
        run: (x) => {
            if (!(x.rs > 0 && x.rl > 0 && x.f > 0)) {
                return { error: 'Enter positive resistances and frequency.' };
            }

            if (x.rs === x.rl) {
                return { value: 'Already matched', sub: 'No network needed', rows: { q: '0', series: '—', shunt: '—', highpass: '—', placement: '—' }, steps: ['Rs = RL'] };
            }

            const hi = Math.max(x.rs, x.rl);
            const lo = Math.min(x.rs, x.rl);
            const q = Math.sqrt(hi / lo - 1);
            const xs = q * lo;
            const xp = hi / q;
            const w = 2 * Math.PI * x.f;
            const H = (xl) => `${num((xl / w) * 1e9, 5)} nH`;
            const F = (xc) => `${num((1 / (w * xc)) * 1e12, 5)} pF`;

            return { value: `L ${H(xs)}, C ${F(xp)}`, sub: `Q = ${num(q, 4)}`, rows: { q: num(q, 5), series: `L = ${H(xs)} (X = ${num(xs, 5)} Ω)`, shunt: `C = ${F(xp)} (X = ${num(xp, 5)} Ω)`, highpass: `Series C = ${F(xs)}, shunt L = ${H(xp)}`, placement: `Shunt element across the ${x.rl > x.rs ? 'load' : 'source'} (the higher resistance)` }, steps: ['Q = √(R_high ÷ R_low − 1)', 'Series reactance = Q × R_low; shunt reactance = R_high ÷ Q', 'For complex loads, first cancel the load reactance; this page handles resistive source and load'] };
        },
    },
    lm317: {
        type: 'calc',
        inputs: { mode: SEL('Find', { vout: 'Output voltage from R1 and R2', r2: 'R2 for a target voltage' }, 'r2'), r1: N('R1 (Ω)', 240, 1), r2: N('R2 (Ω)', 720, 0), target: N('Target output (V)', 5, 1.25), vin: N('Input voltage (V)', 9, 0), iload: N('Load current (A)', 0.5, 0) },
        show: { r2: 'mode:vout', target: 'mode:r2' },
        when: { r2: (x) => x.mode === 'vout', target: (x) => x.mode === 'r2' },
        label: 'Result',
        rows: { vout: 'Output voltage', e24: 'Nearest E24 R2 and its output', headroom: 'Input headroom', power: 'Power in the regulator' },
        run: (x) => {
            const iadj = 50e-6;
            const vout = (r2) => 1.25 * (1 + r2 / x.r1) + iadj * r2;
            const r2 = x.mode === 'r2' ? (x.target - 1.25) / (1.25 / x.r1 + iadj) : x.r2;
            const v = vout(r2);
            const e = nearestE24(r2);
            const head = x.vin - v;

            return { value: x.mode === 'r2' ? `R2 = ${ohms(r2)}` : `${num(v, 5)} V`, sub: `with R1 = ${ohms(x.r1)}`, rows: { vout: `${num(v, 5)} V`, e24: `${ohms(e)} → ${num(vout(e), 5)} V`, headroom: `${num(head, 4)} V${head < 3 ? ' (below about 3 V: may drop out at full load)' : ''}`, power: `${num(Math.max(0, head) * x.iload, 4)} W${Math.max(0, head) * x.iload > 1 ? ' (needs a heatsink)' : ''}` }, steps: ['V_out = 1.25 V × (1 + R2/R1) + I_adj × R2, with I_adj ≈ 50 µA (TI LM317 datasheet)', 'R1 of 240 Ω keeps the minimum load current flowing', 'Power dissipated = (V_in − V_out) × I_load'] };
        },
    },
    pcb_impedance: {
        type: 'calc',
        inputs: { type: SEL('Structure', { micro: 'Microstrip (outer layer)', strip: 'Symmetric stripline (inner layer)', dmicro: 'Differential microstrip', dstrip: 'Differential stripline' }, 'micro'), w: L('Trace width', 0.3), t: L('Copper thickness', 0.035), h: L('Dielectric height (to the plane; stripline: each side)', 0.2), s: L('Gap between the pair (differential)', 0.2), er: N('Dielectric constant εr', 4.3, 1) },
        show: { s: 'type:dmicro,dstrip' },
        label: 'Impedance (IPC-2141 estimate)',
        rows: { single: 'Single-ended Z₀', eeff: 'Effective εr', delay: 'Delay per inch' },
        run: (x) => {
            const { w, t, h, er } = x;
            const ratio = (0.8 * w + t) > 0 ? h / (0.8 * w + t) : NaN;
            let z0;
            let eeff;

            if (x.type === 'micro' || x.type === 'dmicro') {
                z0 = (87 / Math.sqrt(er + 1.41)) * Math.log(5.98 * ratio);
                eeff = (er + 1) / 2 + ((er - 1) / 2) * (1 + (12 * h) / w) ** -0.5;
            } else {
                z0 = (60 / Math.sqrt(er)) * Math.log((1.9 * (2 * h + t)) / (0.8 * w + t));
                eeff = er;
            }

            if (!(z0 > 0)) {
                return { error: 'These dimensions are outside the range of the equations (try a narrower trace or thicker dielectric).' };
            }

            const z = x.type === 'dmicro' ? 2 * z0 * (1 - 0.48 * Math.exp((-0.96 * x.s) / h)) : x.type === 'dstrip' ? 2 * z0 * (1 - 0.347 * Math.exp((-2.9 * x.s) / (2 * h + t))) : z0;
            const ok = x.type.endsWith('micro') ? w / h > 0.1 && w / h < 2 : w / h < 0.35 * 2;

            return { value: `${num(z, 4)} Ω`, sub: x.type.startsWith('d') ? 'Differential impedance' : 'Single-ended impedance', rows: { single: `${num(z0, 4)} Ω`, eeff: num(eeff, 4), delay: `${num((Math.sqrt(eeff) / C0) * 0.0254 * 1e12, 4)} ps/in` }, steps: [x.type.endsWith('micro') ? 'IPC-2141 microstrip: Z₀ = 87/√(εr + 1.41) × ln(5.98h ÷ (0.8w + t))' : 'IPC-2141 stripline: Z₀ = 60/√εr × ln(1.9(2h + t) ÷ (0.8w + t))', ...(x.type.startsWith('d') ? ['Differential: 2Z₀ × (1 − coupling term in the gap)'] : []), ok ? 'Within the equations’ usual range; expect ±5–10% against a field solver' : 'Outside the equations’ usual range: check with a field solver', 'Fabricators’ stack-up tools give the final values'] };
        },
    },
    trace_current: {
        type: 'calc',
        inputs: { w: L('Trace width', 0.5), oz: N('Copper weight (oz/ft²)', 1, 0), dT: N('Allowed temperature rise (°C)', 10, 0), layer: SEL('Layer', { external: 'External (outer)', internal: 'Internal' }, 'external'), len: L('Trace length (for resistance)', 50) },
        label: 'Maximum current (IPC-2221)',
        rows: { area: 'Cross-section', resistance: 'Resistance at 25 °C', drop: 'Voltage drop at that current' },
        run: (x) => {
            const wMil = (x.w / 0.0000254);
            const area = wMil * x.oz * OZ_MIL;
            const i = ipcCurrent(area, x.dT, x.layer === 'internal');
            const r = (RHO_CU * (1 + ALPHA_CU * 5) * x.len) / (x.w * x.oz * 34.8e-6);

            return { value: `${num(i, 4)} A`, sub: `${num(x.w * 1000, 4)} mm, ${num(x.oz)} oz, ${num(x.dT)} °C rise`, rows: { area: `${num(area, 5)} mil²`, resistance: `${num(r * 1000, 4)} mΩ`, drop: `${num(i * r * 1000, 4)} mV` }, steps: ['IPC-2221: I = k × ΔT^0.44 × A^0.725, A in mil², k = 0.048 outer / 0.024 inner', '1 oz copper ≈ 34.8 µm (1.378 mil) thick', 'IPC-2152 (charts) is newer and often allows more current; this is the conservative classic'] };
        },
    },
    trace_resistance: {
        type: 'calc',
        inputs: { w: L('Trace width', 0.25), len: L('Length', 100), oz: N('Copper weight (oz/ft²)', 1, 0), temp: N('Temperature (°C)', 25), current: N('Current (A, optional)', 1, 0) },
        optional: ['current'],
        label: 'Resistance',
        rows: { drop: 'Voltage drop', power: 'Power lost', perLen: 'Per cm' },
        run: (x) => {
            const area = x.w * x.oz * 34.8e-6;
            const r = (RHO_CU * (1 + ALPHA_CU * (x.temp - 20)) * x.len) / area;

            return { value: r < 1 ? `${num(r * 1000, 5)} mΩ` : `${num(r, 5)} Ω`, sub: `${num(x.len * 1000, 4)} mm × ${num(x.w * 1000, 4)} mm, ${num(x.oz)} oz`, rows: { drop: x.current > 0 ? `${num(r * x.current * 1000, 5)} mV` : 'Enter a current', power: x.current > 0 ? `${num(r * x.current ** 2 * 1000, 5)} mW` : '—', perLen: `${num((r / (x.len * 100)) * 1000, 5)} mΩ/cm` }, steps: ['R = ρ L ÷ (w t) with copper ρ = 1.724 × 10⁻⁸ Ω·m at 20 °C', 'Temperature coefficient 0.393% per °C', '1 oz copper ≈ 34.8 µm thick (plating adds to outer layers)'] };
        },
    },
    trace_width: {
        type: 'calc',
        inputs: { current: N('Current (A)', 2, 0), oz: N('Copper weight (oz/ft²)', 1, 0), dT: N('Allowed temperature rise (°C)', 10, 0), layer: SEL('Layer', { external: 'External (outer)', internal: 'Internal' }, 'external') },
        label: 'Minimum trace width (IPC-2221)',
        rows: { mil: 'In mils', area: 'Cross-section', other: 'On the other layer type' },
        run: (x) => {
            const area = (k) => (x.current / (k * x.dT ** 0.44)) ** (1 / 0.725);
            const k = x.layer === 'internal' ? 0.024 : 0.048;
            const wMil = area(k) / (x.oz * OZ_MIL);
            const otherMil = area(k === 0.048 ? 0.024 : 0.048) / (x.oz * OZ_MIL);

            return { value: `${num(wMil * 0.0254, 4)} mm`, sub: `${num(x.current)} A, ${num(x.oz)} oz, ${num(x.dT)} °C rise`, rows: { mil: `${num(wMil, 4)} mil`, area: `${num(area(k), 5)} mil²`, other: `${num(otherMil * 0.0254, 4)} mm (${x.layer === 'internal' ? 'external' : 'internal'})` }, steps: ['A = (I ÷ (k ΔT^0.44))^(1/0.725) mil² (IPC-2221)', 'Width = A ÷ (thickness of the copper weight)', 'Inner layers need about 2.6× the width because heat escapes more slowly'] };
        },
    },
    pi_attenuator: {
        type: 'calc',
        inputs: { db: N('Attenuation (dB)', 10, 0), z: N('Impedance Z₀ (Ω)', 50, 0), topology: SEL('Topology', { pi: 'Pi (two shunt, one series)', t: 'T (two series, one shunt)' }, 'pi') },
        label: 'Resistor values',
        rows: { shunt: 'Shunt resistor(s)', series: 'Series resistor(s)', e24: 'Nearest E24 and the attenuation they give' },
        run: (x) => {
            if (!(x.db > 0 && x.z > 0)) {
                return { error: 'Enter attenuation and impedance above zero.' };
            }

            const k = 10 ** (x.db / 20);
            const pi = x.topology === 'pi';
            const shunt = pi ? (x.z * (k + 1)) / (k - 1) : (x.z * 2 * k) / (k * k - 1);
            const series = pi ? (x.z * (k * k - 1)) / (2 * k) : (x.z * (k - 1)) / (k + 1);
            const [sh, se] = [nearestE24(shunt), nearestE24(series)];
            // Attenuation of the rounded network into Z0 (voltage ratio of the loaded divider).
            let att;

            if (pi) {
                const par = (a, b) => (a * b) / (a + b);
                const zLoad = par(sh, x.z);
                const zIn = par(sh, se + zLoad);
                const v1 = zIn / (zIn + x.z);
                att = -20 * Math.log10((2 * v1 * zLoad) / (se + zLoad));
            } else {
                const par = (a, b) => (a * b) / (a + b);
                const zMid = par(sh, se + x.z);
                const zIn = se + zMid;
                const vMid = (zMid / zIn) * (zIn / (zIn + x.z));
                att = -20 * Math.log10((2 * vMid * x.z) / (se + x.z));
            }

            return { value: pi ? `Shunt ${ohms(shunt)}, series ${ohms(series)}` : `Series ${ohms(series)}, shunt ${ohms(shunt)}`, sub: `${num(x.db)} dB in ${num(x.z)} Ω`, rows: { shunt: `${pi ? '2 × ' : ''}${ohms(shunt)}`, series: `${pi ? '' : '2 × '}${ohms(series)}`, e24: `${ohms(sh)} and ${ohms(se)} → ${num(att, 4)} dB` }, steps: ['K = 10^(dB/20)', pi ? 'Pi: shunt = Z₀(K + 1)/(K − 1), series = Z₀(K² − 1)/(2K)' : 'T: series = Z₀(K − 1)/(K + 1), shunt = 2KZ₀/(K² − 1)', 'Both ends stay matched to Z₀'] };
        },
    },
    propagation_delay: {
        type: 'calc',
        inputs: { len: L('Length', 150), type: SEL('Medium', { strip: 'Stripline or cable (εeff = εr)', micro: 'Microstrip (εeff ≈ 0.475 εr + 0.67)', vf: 'Velocity factor known' }, 'micro'), er: N('Dielectric constant εr', 4.3, 1), vf: N('Velocity factor', 0.66, 0), f: ['Frequency (for electrical length)', 'frequency_hz', 'mhz', 100] },
        show: { er: 'type:strip,micro', vf: 'type:vf' },
        optional: ['f'],
        label: 'Propagation delay',
        rows: { perUnit: 'Per inch and per cm', speed: 'Signal speed', electrical: 'Electrical length' },
        run: (x) => {
            const eeff = x.type === 'micro' ? 0.475 * x.er + 0.67 : x.type === 'strip' ? x.er : 1 / x.vf ** 2;

            if (!(eeff >= 1)) {
                return { error: 'The dielectric constant must be at least 1 (velocity factor at most 1).' };
            }

            const v = C0 / Math.sqrt(eeff);
            const t = x.len / v;

            return { value: `${num(t * 1e12, 5)} ps`, sub: `over ${num(x.len * 1000, 5)} mm`, rows: { perUnit: `${num((0.0254 / v) * 1e12, 4)} ps/in, ${num((0.01 / v) * 1e12, 4)} ps/cm`, speed: `${num(v / C0, 4)} c (${num(v / 1e6, 5)} mm/ns)`, electrical: x.f > 0 ? `${num((x.len * x.f) / v, 4)} wavelengths (${num((360 * x.len * x.f) / v, 5)}°)` : 'Enter a frequency' }, steps: ['t = L √εeff ÷ c', x.type === 'micro' ? 'Microstrip: εeff ≈ 0.475 εr + 0.67 (IPC-2141 approximation for FR-4)' : 'Fully embedded: εeff = εr'] };
        },
    },
    raid: {
        type: 'calc',
        inputs: { level: SEL('RAID level', { 0: 'RAID 0 (striping)', 1: 'RAID 1 (mirror)', 5: 'RAID 5 (single parity)', 6: 'RAID 6 (double parity)', 10: 'RAID 10 (striped mirrors)', 50: 'RAID 50', 60: 'RAID 60' }, '5'), drives: N('Number of drives', 6, 1), size: ['Size of each drive', 'data', 'tb', 8], groups: N('Groups (RAID 50/60)', 2, 1) },
        show: { groups: 'level:50,60' },
        label: 'Usable capacity',
        rows: { raw: 'Raw capacity', efficiency: 'Storage efficiency', tolerance: 'Drive failures survived', penalty: 'Write penalty (I/O per write)', reads: 'Read speed (× one drive, ideal)' },
        run: (x) => {
            const n = x.drives;
            const level = Number(x.level);
            const g = x.groups;
            const rules = {
                0: [1, n, '0', 1],
                1: [2, 1, `${n - 1} (any)`, 2],
                5: [3, n - 1, '1', 4],
                6: [4, n - 2, '2', 6],
                10: [4, n / 2, '1 per mirror pair (at least 1)', 2],
                50: [6, n - g, `1 per group (${g} at best)`, 4],
                60: [8, n - 2 * g, `2 per group (${2 * g} at best)`, 6],
            }[level];

            if (n < rules[0] || (level === 10 && n % 2) || ((level === 50 || level === 60) && (n % g || n / g < (level === 50 ? 3 : 4)))) {
                return { error: `RAID ${level} needs at least ${rules[0]} drives${level === 10 ? ' in pairs' : level >= 50 ? `, split evenly into groups of at least ${level === 50 ? 3 : 4}` : ''}.` };
            }

            const usable = rules[1] * x.size;
            const tb = (b) => `${num(b / 1e12, 5)} TB (${num(b / 2 ** 40, 5)} TiB)`;

            return { value: tb(usable), sub: `RAID ${level} on ${n} drives`, rows: { raw: tb(n * x.size), efficiency: pct(rules[1] / n, 4), tolerance: rules[2], penalty: `${rules[3]}×`, reads: `${num(level === 1 ? n : level === 10 ? n : rules[1] + (level === 0 ? 0 : 0), 3)}×` }, steps: ['RAID 5 gives up one drive’s space to parity, RAID 6 two, mirrors half', 'Drive makers quote decimal TB; operating systems often show TiB', 'RAID is not a backup: deletions and ransomware are copied too'] };
        },
    },
    ram_latency: {
        type: 'calc',
        inputs: { mts: N('Data rate (MT/s, e.g. DDR5-6000)', 6000, 1), cl: N('CAS latency (CL)', 30, 1) },
        label: 'First-word latency',
        rows: { clock: 'I/O clock', cycle: 'Clock period' },
        grids: [['table', 'Common kits']],
        run: (x) => {
            const ns = (x.cl * 2000) / x.mts;

            return { value: `${num(ns, 4)} ns`, sub: `DDR-${x.mts} CL${x.cl}`, rows: { clock: `${num(x.mts / 2, 5)} MHz`, cycle: `${num(2000 / x.mts, 4)} ns` }, steps: ['Latency (ns) = CL × 2000 ÷ data rate (MT/s): CL counts clock cycles and the clock runs at half the data rate', 'Lower is better; a faster kit with higher CL can have the same true latency'], grids: { table: { columns: ['Latency'], rows: [[3200, 16], [3600, 18], [4800, 40], [5600, 36], [6000, 30], [6400, 32], [7200, 34]].map(([m, c]) => ({ header: `DDR-${m} CL${c}`, cells: [`${num((c * 2000) / m, 4)} ns`] })) } } };
        },
    },
    rf_unit: {
        type: 'calc',
        inputs: { value: N('Value', 10), unit: SEL('Unit', { dbm: 'dBm', dbw: 'dBW', w: 'W', mw: 'mW', uw: 'µW', dbuv: 'dBµV (voltage)', v: 'V (RMS)', mv: 'mV (RMS)' }, 'dbm'), z: N('Impedance (Ω)', 50, 0) },
        label: 'Power',
        rows: { dbm: 'dBm', dbw: 'dBW', w: 'Watts', mw: 'Milliwatts', v: 'Voltage (RMS)', dbuv: 'dBµV', vpp: 'Peak-to-peak (sine)' },
        run: (x) => {
            const toW = { dbm: (v) => 10 ** ((v - 30) / 10), dbw: (v) => 10 ** (v / 10), w: (v) => v, mw: (v) => v / 1e3, uw: (v) => v / 1e6, dbuv: (v) => (10 ** (v / 20) * 1e-6) ** 2 / x.z, v: (v) => (v * v) / x.z, mv: (v) => (v / 1000) ** 2 / x.z }[x.unit];
            const w = toW(x.value);

            if (!(w > 0) || !(x.z > 0)) {
                return { error: 'Enter a positive power or voltage and impedance.' };
            }

            const vrms = Math.sqrt(w * x.z);

            return { value: `${num(10 * Math.log10(w * 1000), 5)} dBm`, sub: `${num(w, 6)} W into ${num(x.z)} Ω`, rows: { dbm: num(10 * Math.log10(w * 1000), 6), dbw: num(10 * Math.log10(w), 6), w: num(w, 6), mw: num(w * 1000, 6), v: `${num(vrms, 6)} V`, dbuv: num(20 * Math.log10(vrms / 1e-6), 6), vpp: `${num(vrms * 2 * Math.SQRT2, 6)} V` }, steps: ['P(dBm) = 10 log₁₀(P ÷ 1 mW); dBW = dBm − 30', 'V = √(P Z) for a matched load; dBµV = 20 log₁₀(V ÷ 1 µV)', '0 dBm in 50 Ω = 1 mW = 0.2236 V = 107 dBµV'] };
        },
    },
    thd: {
        type: 'calc',
        inputs: { mode: SEL('Harmonics entered as', { volts: 'Amplitudes (fundamental first)', dbc: 'dB below the fundamental (dBc)' }, 'volts'), list: TXT('Values (fundamental, 2nd, 3rd …; or dBc of 2nd, 3rd …)', '1, 0.02, 0.05, 0.01, 0.008'), noise: N('Noise relative to the fundamental (optional, %)', 0, 0) },
        optional: ['noise'],
        label: 'THD',
        rows: { db: 'In dB', thdn: 'THD+N', largest: 'Largest harmonic' },
        run: (x) => {
            const { values } = parseNumbers(x.list);
            let harm;

            if (x.mode === 'volts') {
                if (values.length < 2 || !(values[0] > 0)) {
                    return { error: 'Enter the fundamental first, then at least one harmonic.' };
                }

                harm = values.slice(1).map((v) => v / values[0]);
            } else {
                if (!values.length) {
                    return { empty: 'Enter harmonic levels in dBc.' };
                }

                harm = values.map((d) => 10 ** (-Math.abs(d) / 20));
            }

            const thd = Math.sqrt(harm.reduce((s, h) => s + h * h, 0));
            const n = (x.noise || 0) / 100;
            const k = harm.indexOf(Math.max(...harm));

            return { value: pct(thd, 4), sub: `${harm.length} harmonics`, rows: { db: `${num(20 * Math.log10(thd), 4)} dB`, thdn: pct(Math.sqrt(thd * thd + n * n), 4), largest: `H${k + 2} (${pct(harm[k], 4)})` }, steps: ['THD = √(V₂² + V₃² + …) ÷ V₁ (IEEE / IEC THD_F definition)', 'THD+N adds the noise in quadrature'] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
