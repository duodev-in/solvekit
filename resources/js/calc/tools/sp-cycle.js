import { formatMoney } from '../currency.js';
import { defineTools } from '../engines/formula.js';
import { handlersFor, K, num } from '../physics/core.js';
import { fmtTime, parseTime } from '../sports/time.js';

/**
 * Cycling: gearing, cadence and speed, the cycling power model, zones, bike fit, chain and running costs.
 */
const g0 = K.g0;
const N = (label, value, min = 0) => [label, null, null, value, min];
const WHEEL = { wheel: ['Wheel and tyre', 'select', 'data:wheels', '700x25'], circ: ['Rolling circumference', 'length', 'mm', 2105] };
const WHEEL_SHOW = { circ: 'wheel:custom' };
const WHEEL_WHEN = { circ: (x) => x.wheel === 'custom' };
const circOf = (x, ctx) => (x.wheel === 'custom' ? x.circ : ctx.c.data.sports.wheels[x.wheel].mm / 1000);
const POSITIONS = { tops: ['Upright, hands on the tops (CdA ≈ 0.40)', 0.4], hoods: ['On the hoods (CdA ≈ 0.32)', 0.32], drops: ['In the drops (CdA ≈ 0.30)', 0.3], aero: ['Aero or time-trial position (CdA ≈ 0.23)', 0.23], mtb: ['Mountain bike, upright (CdA ≈ 0.45)', 0.45] };
const TYRES = { road: ['Road tyres on smooth tarmac (Crr 0.004)', 0.004], rough: ['Road tyres on rough tarmac (Crr 0.006)', 0.006], gravel: ['Gravel (Crr 0.008)', 0.008], mtb: ['Knobby MTB tyres (Crr 0.012)', 0.012] };
const opts = (table) => Object.fromEntries(Object.entries(table).map(([k, v]) => [k, v[0]]));

/** Power (W) to ride at v m/s: rolling, gravity and aerodynamic resistance, 2.5% drivetrain loss (Martin et al. 1998, simplified). */
export function cyclingPower({ m, v, grade, cda, crr, rho = 1.225, wind = 0 }) {
    const th = Math.atan(grade / 100);
    const roll = crr * m * g0 * Math.cos(th);
    const climb = m * g0 * Math.sin(th);
    const air = 0.5 * rho * cda * (v + wind) ** 2 * Math.sign(v + wind);

    return { total: ((roll + climb + air) * v) / 0.975, roll: roll * v, climb: climb * v, air: air * v };
}

const COGGAN = [['1 Active recovery', 0, 0.55], ['2 Endurance', 0.56, 0.75], ['3 Tempo', 0.76, 0.9], ['4 Lactate threshold', 0.91, 1.05], ['5 VO₂max', 1.06, 1.2], ['6 Anaerobic capacity', 1.21, 1.5], ['7 Neuromuscular power', 1.5, null]];

export const TOOLS = {
    cadence_speed: {
        type: 'calc',
        inputs: { by: ['Find', 'select', { speed: 'Speed from cadence', cadence: 'Cadence from speed' }, 'speed'], ring: N('Chainring teeth', 50, 1), cog: N('Cog teeth', 17, 1), ...WHEEL, rpm: N('Cadence (rpm)', 90, 1), v: ['Speed', 'speed', 'kmh', 30] },
        show: { ...WHEEL_SHOW, rpm: 'by:speed', v: 'by:cadence' },
        when: { ...WHEEL_WHEN, rpm: (x) => x.by === 'speed', v: (x) => x.by === 'cadence' },
        data: ['wheels'],
        label: 'Speed',
        rows: { ratio: 'Gear ratio', dev: 'Development (metres per pedal turn)' },
        grids: [['table', 'Speed at each cadence']],
        run: (x, ctx) => {
            const dev = circOf(x, ctx) * (x.ring / x.cog);
            const speed = (rpm) => (rpm * dev * 60) / 1000;

            if (x.by === 'cadence') {
                const rpm = (x.v * 60) / dev;

                return { value: `${num(rpm, 3)} rpm`, label: 'Cadence', sub: `${num(dev, 4)} m per pedal turn`, rows: { ratio: num(x.ring / x.cog, 4), dev: `${num(dev, 4)} m` }, steps: ['cadence = speed ÷ development', `= ${num(x.v * 60)} m/min ÷ ${num(dev, 4)} m`], grids: { table: { columns: ['km/h', 'mph'], rows: [60, 70, 80, 90, 100, 110, 120].map((c) => ({ header: `${c} rpm`, cells: [num(speed(c), 3), num(speed(c) / 1.609344, 3)] })) } } };
            }

            return { value: `${num(speed(x.rpm), 4)} km/h`, sub: `${num(speed(x.rpm) / 1.609344, 4)} mph`, rows: { ratio: num(x.ring / x.cog, 4), dev: `${num(dev, 4)} m` }, steps: ['speed = cadence × (chainring ÷ cog) × wheel circumference', `= ${num(x.rpm)} × ${num(x.ring / x.cog, 4)} × ${num(circOf(x, ctx), 4)} m per minute`], grids: { table: { columns: ['km/h', 'mph'], rows: [60, 70, 80, 90, 100, 110, 120].map((c) => ({ header: `${c} rpm`, cells: [num(speed(c), 3), num(speed(c) / 1.609344, 3)], highlight: c === Math.round(x.rpm / 10) * 10 })) } } };
        },
    },
    bike_gear: {
        type: 'calc',
        inputs: { rings: ['Chainrings (teeth, comma separated)', 'text', null, '50, 34'], cogs: ['Cassette (teeth, comma separated)', 'text', null, '11, 12, 13, 14, 15, 17, 19, 21, 24, 28'], ...WHEEL, crank: ['Crank length', 'length', 'mm', 172.5], measure: ['Show', 'select', { inches: 'Gear inches', dev: 'Development (m)', gain: 'Gain ratio' }, 'inches'] },
        show: WHEEL_SHOW,
        when: WHEEL_WHEN,
        data: ['wheels'],
        label: 'Gear range',
        rows: { low: 'Lowest gear', high: 'Highest gear', range: 'Range' },
        grids: [['gears', 'Every combination']],
        run: (x, ctx) => {
            const list = (t) => String(t).split(/[,\s]+/).map(Number).filter((v) => v > 0);
            const rings = list(x.rings);
            const cogs = list(x.cogs);

            if (!rings.length || !cogs.length) {
                return { empty: 'Enter the chainring and cog teeth.' };
            }

            const c = circOf(x, ctx);
            const val = (r, k) => ({ inches: (c / Math.PI / 0.0254) * (r / k), dev: c * (r / k), gain: (c / (2 * Math.PI) / x.crank) * (r / k) })[x.measure];
            const all = rings.flatMap((r) => cogs.map((k) => val(r, k)));
            const [lo, hi] = [Math.min(...all), Math.max(...all)];

            return { value: `${num(lo, 3)}–${num(hi, 3)}`, sub: { inches: 'Gear inches', dev: 'Metres per pedal turn', gain: 'Gain ratio' }[x.measure], rows: { low: num(lo, 4), high: num(hi, 4), range: `${num((hi / lo) * 100, 3)}%` }, steps: ['Gear inches = wheel diameter (in) × chainring ÷ cog', 'Development = wheel circumference × chainring ÷ cog', 'Gain ratio = (wheel radius ÷ crank length) × chainring ÷ cog (Sheldon Brown)'], grids: { gears: { columns: rings.map((r) => `${r}T`), rows: cogs.map((k) => ({ header: `${k}T`, cells: rings.map((r) => num(val(r, k), 3)) })) } } };
        },
    },
    bike_pace: {
        type: 'calc',
        inputs: { want: ['Find', 'select', { speed: 'Speed and pace', time: 'Time', dist: 'Distance' }, 'speed'], d: ['Distance', 'length', 'km', 40], t: ['Time (h:mm:ss)', 'text', null, '1:20:00'], v: ['Speed', 'speed', 'kmh', 30] },
        show: { d: 'want:speed,time', t: 'want:speed,dist', v: 'want:time,dist' },
        when: { d: (x) => x.want !== 'dist', v: (x) => x.want !== 'speed' },
        label: 'Average speed',
        rows: { pace: 'Pace', time: 'Time', dist: 'Distance', per10: 'Time per 10 km' },
        run: (x) => {
            let { d, v } = x;
            let t = parseTime(x.t, 3600);

            if (x.want === 'speed') {
                v = d / t;
            } else if (x.want === 'time') {
                t = d / v;
            } else {
                d = v * t;
            }

            if (!(d > 0 && t > 0 && v > 0)) {
                return { error: 'Type the time as h:mm:ss, such as 1:20:00.' };
            }

            const value = { speed: `${num(v * 3.6, 4)} km/h`, time: fmtTime(t), dist: `${num(d / 1000, 4)} km` }[x.want];

            return { value, label: { speed: 'Average speed', time: 'Time', dist: 'Distance' }[x.want], sub: `${num(v * 3.6, 4)} km/h (${num((v * 3.6) / 1.609344, 4)} mph)`, rows: { pace: `${fmtTime(1000 / v)} /km`, time: fmtTime(t), dist: `${num(d / 1000, 4)} km`, per10: fmtTime(10000 / v) }, steps: ['speed = distance ÷ time'] };
        },
    },
    bike_size: {
        type: 'calc',
        inputs: { inseam: ['Inseam (floor to crotch, in socks)', 'length', 'cm', 81], type: ['Bike', 'select', { road: 'Road or gravel', mtb: 'Mountain', hybrid: 'Hybrid or city' }, 'road'] },
        label: 'Frame size',
        rows: { saddle: ['Saddle height (centre of bottom bracket to top of saddle)', 'length'], note: 'Fit' },
        run: (x) => {
            const cm = x.inseam * 100;
            const frame = { road: `${num(cm * 0.665, 3)} cm`, mtb: `${num((cm * 0.226) / 1, 3)} in (${num(cm * 0.226 * 2.54, 3)} cm)`, hybrid: `${num(cm * 0.665 - 4, 3)} cm` }[x.type];

            return { value: frame, sub: 'Seat-tube length; check the maker’s size chart', rows: { saddle: [x.inseam * 0.883, 'length'], note: 'Reach and stack matter as much as frame size; a test ride or bike fit is best' }, steps: ['Road: inseam (cm) × 0.665; mountain: inseam (cm) × 0.226 in; hybrid: a little smaller than road', 'Saddle height: 0.883 × inseam (Greg LeMond)', 'A rule of thumb'] };
        },
    },
    bike_calories: {
        type: 'calc',
        inputs: { by: ['I know', 'select', { speed: 'Average speed', power: 'Average power (watts)' }, 'speed'], speed: ['Speed band', 'select', 'data:mets:fixed:bike_10,bike_12,bike_14,bike_16,bike_20,bike_fast', 'bike_14'], P: ['Average power', 'power', 'w', 150], w: ['Body weight', 'mass', 'kg', 70], t: ['Ride time', 'time', 'min', 60] },
        show: { speed: 'by:speed', P: 'by:power' },
        when: { P: (x) => x.by === 'power' },
        data: ['mets'],
        label: 'Calories burned',
        rows: { perHour: 'Per hour', method: 'Method' },
        run: (x, ctx) => {
            const minutes = x.t / 60;

            if (x.by === 'power') {
                const kj = (x.P * x.t) / 1000;
                const E = kj / (0.24 * 4.184);

                return { value: num(E, 4), unit: 'kcal', sub: `${num(kj, 4)} kJ of work`, rows: { perHour: `${num((E / minutes) * 60, 4)} kcal`, method: 'Mechanical work ÷ 24% efficiency (about 1 kcal per kJ)' }, steps: ['Work = watts × seconds', `= ${num(kj)} kJ; energy used = work ÷ efficiency (≈ 24%) ÷ 4.184`, `= ${num(E)} kcal`] };
            }

            const m = ctx.c.data.sports.mets[x.speed];
            const E = (m.met * 3.5 * x.w * minutes) / 200;

            return { value: num(E, 4), unit: 'kcal', sub: m.name, rows: { perHour: `${num((E / minutes) * 60, 4)} kcal`, method: `Compendium MET ${m.met} (${m.code})` }, steps: ['kcal = MET × 3.5 × kg × minutes ÷ 200', `= ${num(E)} kcal (an estimate)`] };
        },
    },
    chain_length: {
        type: 'calc',
        inputs: { C: ['Chainstay length (centre of bottom bracket to rear axle)', 'length', 'in', 16.5], F: N('Largest chainring teeth', 50, 1), R: N('Largest cog teeth', 28, 1) },
        label: 'Chain length',
        rows: { inches: 'Length in inches', links: 'Links (half-inch pitch)' },
        run: (x) => {
            const Cin = x.C / 0.0254;
            const L = 2 * Cin + x.F / 4 + x.R / 4 + 1;
            const links = Math.ceil(L * 2 / 2) * 2;

            return { value: `${links} links`, sub: `${num(L, 4)} in, rounded up to a whole inch`, rows: { inches: `${num(L, 4)} in`, links: `${links} (each inch is two links)` }, steps: ['Park Tool: L = 2 × chainstay + chainring ÷ 4 + cog ÷ 4 + 1 (inches)', `= 2 × ${num(Cin, 4)} + ${num(x.F / 4)} + ${num(x.R / 4)} + 1 = ${num(L)} in`, 'Check with the big-big method on your bike; derailleurs differ'] };
        },
    },
    breakaway: {
        type: 'calc',
        inputs: { gap: ['Gap', 'time', 's', 60], D: ['Distance to the finish', 'length', 'km', 20], vb: ['Breakaway speed', 'speed', 'kmh', 42], vc: ['Chasing group speed', 'speed', 'kmh', 46] },
        label: 'Does the chase catch them?',
        rows: { where: 'Catch point', stay: ['Speed the breakaway needs to stay away', 'speed'], finish: 'Gap at the finish if not caught' },
        run: (x) => {
            const gapDist = x.gap * x.vb;
            const caughtIn = x.vc > x.vb ? gapDist / (x.vc - x.vb) : Infinity;
            const caughtAt = caughtIn * x.vb;
            const caught = caughtAt < x.D;
            const stay = (x.D * x.vc) / (x.D + gapDist);
            const tb = x.D / x.vb;
            const tc = (x.D + gapDist) / x.vc;

            return { value: caught ? 'Yes' : 'No', sub: caught ? `Caught ${num((x.D - caughtAt) / 1000, 3)} km before the finish` : 'The breakaway stays away', rows: { where: caught ? `${num(caughtAt / 1000, 3)} km from here, after ${fmtTime(caughtIn)}` : 'Not before the finish', stay: [stay, 'speed'], finish: caught ? 'Caught' : `${fmtTime(tc - tb)} ahead` }, steps: [`Gap in distance = ${num(x.gap)} s × breakaway speed = ${num(gapDist)} m`, 'Closing speed = chase − breakaway; catch time = gap ÷ closing speed', 'Assumes steady speeds; drafting and terrain change real races'] };
        },
    },
    cycling_hr_zones: {
        type: 'calc',
        inputs: { lthr: N('Lactate-threshold heart rate (cycling)', 162, 1) },
        label: 'Threshold heart rate',
        rows: { find: 'How to find it' },
        grids: [['zones', 'Friel cycling heart-rate zones']],
        run: (x) => {
            const Z = [['1 Recovery', 0, 0.81], ['2 Aerobic', 0.81, 0.89], ['3 Tempo', 0.9, 0.93], ['4 Sub-threshold', 0.94, 0.99], ['5a Super-threshold', 1, 1.02], ['5b Aerobic capacity', 1.03, 1.06], ['5c Anaerobic capacity', 1.06, null]];
            const r = (p) => Math.round(x.lthr * p);

            return { value: `${Math.round(x.lthr)} bpm`, sub: 'Joe Friel’s seven cycling zones', rows: { find: '30-minute solo time trial: average heart rate of the last 20 minutes × 0.95' }, steps: ['Zones as % of LTHR (Friel, The Cyclist’s Training Bible)'], grids: { zones: { columns: ['Heart rate'], rows: Z.map(([n, a, b]) => ({ header: n, cells: [b === null ? `${r(a)}+ bpm` : a === 0 ? `under ${r(b)} bpm` : `${r(a)}–${r(b)} bpm`] })) } } };
        },
    },
    cycling_wattage: {
        type: 'calc',
        inputs: { rider: ['Rider weight', 'mass', 'kg', 75], bike: ['Bike and kit weight', 'mass', 'kg', 9], v: ['Speed', 'speed', 'kmh', 30], grade: N('Gradient (%)', 0), pos: ['Position', 'select', opts(POSITIONS), 'hoods'], tyre: ['Surface and tyres', 'select', opts(TYRES), 'road'], wind: ['Headwind (negative for tailwind)', 'speed', 'kmh', 0], rho: ['Air density', 'density', 'kgm3', 1.225] },
        out: 'power',
        outUnit: 'w',
        label: 'Power needed',
        rows: { wkg: 'Watts per kg (rider)', air: ['Aerodynamic drag', 'power'], roll: ['Rolling resistance', 'power'], climb: ['Climbing', 'power'] },
        run: (x) => {
            const p = cyclingPower({ m: x.rider + x.bike, v: x.v, grade: x.grade, cda: POSITIONS[x.pos][1], crr: TYRES[x.tyre][1], rho: x.rho, wind: x.wind });

            return { value: Math.max(0, p.total), sub: `${num(Math.max(0, p.total) / x.rider, 3)} W/kg`, rows: { wkg: `${num(Math.max(0, p.total) / x.rider, 3)} W/kg`, air: [p.air, 'power'], roll: [p.roll, 'power'], climb: [p.climb, 'power'] }, steps: ['P = (C_rr m g cos θ + m g sin θ + ½ρC_dA(v + v_wind)²) × v ÷ 0.975 (drivetrain)', `= ${num(p.total)} W`, 'Typical C_dA and C_rr; real values vary with clothing, tyres and pressure'] };
        },
    },
    ebike_range: {
        type: 'calc',
        inputs: { wh: ['Battery capacity (Wh)', null, null, 500, 1], assist: ['Assist level', 'select', { 0.5: 'Eco (motor adds about 50%)', 1.2: 'Tour (about 120%)', 2: 'Sport (about 200%)', 3: 'Turbo (about 300%)' }, '1.2'], rider: ['Rider weight', 'mass', 'kg', 80], bike: ['E-bike weight', 'mass', 'kg', 23], v: ['Average speed', 'speed', 'kmh', 22], grade: N('Average gradient (%)', 1), price: ['Electricity price per kWh (optional)', 'money', null, 0.2] },
        optional: ['price'],
        out: 'length',
        outUnit: 'km',
        label: 'Estimated range',
        rows: { whkm: 'Battery use', rider: 'Your pedalling power', cost: 'Cost of a full charge' },
        run: (x) => {
            const p = cyclingPower({ m: x.rider + x.bike, v: x.v, grade: x.grade, cda: 0.5, crr: 0.006 });
            const a = Number(x.assist);
            const motor = (Math.max(p.total, 0) * a) / (1 + a) / 0.8;
            const whPerKm = motor / (x.v * 3.6);
            const usable = x.wh * 0.9;

            return { value: whPerKm > 0 ? (usable / whPerKm) * 1000 : NaN, sub: `${num(whPerKm, 3)} Wh per km`, rows: { whkm: `${num(whPerKm, 3)} Wh/km`, rider: `${num(Math.max(p.total, 0) / (1 + a), 3)} W`, cost: Number.isFinite(x.price) ? formatMoney((x.wh / 1000 / 0.85) * x.price) : 'Enter a price' }, steps: ['Power needed from the cycling model (upright position, C_dA 0.5, C_rr 0.006)', 'Motor share = assist ÷ (1 + assist), motor and controller about 80% efficient', '90% of the battery used; an estimate: cold, hills, stops and tyre pressure change it'] };
        },
    },
    lube_cost: {
        type: 'calc',
        inputs: { price: ['Price of a bottle', 'money', null, 12], ml: N('Bottle size (ml)', 120, 1), per: N('Lube per application (ml)', 3, 0), km: N('Kilometres between applications', 200, 1), year: N('Kilometres ridden a year', 5000, 0) },
        label: 'Cost per year',
        rows: { per1000: 'Cost per 1,000 km', bottles: 'Bottles a year', apps: 'Applications a year' },
        run: (x) => {
            const apps = x.year / x.km;
            const mlYear = apps * x.per;
            const cost = (mlYear / x.ml) * x.price;

            return { value: formatMoney(cost), sub: `${num(apps, 3)} applications`, rows: { per1000: formatMoney((cost / x.year) * 1000), bottles: num(mlYear / x.ml, 3), apps: num(apps, 3) }, steps: ['Applications = km a year ÷ km between applications', 'Lube used = applications × ml each; cost = lube used ÷ bottle size × price', `= ${formatMoney(cost)}`] };
        },
    },
    ftp: {
        type: 'calc',
        inputs: { test: ['Test', 'select', { t20: '20-minute test (average power)', ramp: 'Ramp test (best 1-minute power)', t8: '8-minute test (average of two)', t60: 'One-hour best' }, 't20'], P: ['Test power', 'power', 'w', 250], w: ['Body weight', 'mass', 'kg', 75] },
        out: 'power',
        outUnit: 'w',
        label: 'Functional threshold power',
        rows: { wkg: 'Watts per kg', factor: 'Factor used' },
        run: (x) => {
            const f = { t20: 0.95, ramp: 0.75, t8: 0.9, t60: 1 }[x.test];

            return { value: x.P * f, sub: `${num((x.P * f) / x.w, 3)} W/kg`, rows: { wkg: num((x.P * f) / x.w, 3), factor: `${f * 100}% of test power` }, steps: ['FTP ≈ 95% of 20-minute power, 75% of ramp-test peak minute, 90% of 8-minute power (Allen & Coggan; Zwift/TrainerRoad ramp)', `= ${num(x.P)} × ${f}`] };
        },
    },
    power_zones: {
        type: 'calc',
        inputs: { ftp: ['FTP', 'power', 'w', 250], w: ['Body weight (optional)', 'mass', 'kg', 75] },
        optional: ['w'],
        label: 'FTP',
        rows: { wkg: 'FTP per kg' },
        grids: [['zones', 'Coggan power zones']],
        run: (x) => ({ value: `${num(x.ftp)} W`, sub: 'Seven training levels', rows: { wkg: Number.isFinite(x.w) ? `${num(x.ftp / x.w, 3)} W/kg` : 'Enter weight' }, steps: ['Coggan levels as % of FTP: < 55, 56–75, 76–90, 91–105, 106–120, 121–150, > 150'], grids: { zones: { columns: ['Watts', '% of FTP'], rows: COGGAN.map(([n, a, b]) => ({ header: n, cells: [b === null ? `${Math.round(a * x.ftp)}+` : a === 0 ? `under ${Math.round(b * x.ftp)}` : `${Math.round(a * x.ftp)}–${Math.round(b * x.ftp)}`, b === null ? `> ${a * 100}%` : `${Math.round(a * 100)}–${Math.round(b * 100)}%`] })) } } }),
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
