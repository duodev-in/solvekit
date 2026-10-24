import { defineTools } from '../engines/formula.js';
import { formatMoney } from '../currency.js';
import { handlersFor } from '../physics/core.js';
import { N, SEL, TXT, LINE, num, pct } from '../statistics/common.js';
import { parseNumbers, sum } from '../statistics/data.js';
import { normCdf, normInv } from '../statistics/special.js';
import * as G from '../tech/geo.js';
import { duration } from '../tech/net.js';

/**
 * Logistics, seasons and holidays, Earth and weather, and everyday odds and ends. Tables come from
 * config/other_data.php (carrier divisors, NMFC classes, containers, oxygen cylinders, MED, snow ratios,
 * resolutions, royalties) and config/physics_data.php (planet orbits).
 */

const MONEY = (label, value) => [label, 'money', null, value];
const LEN = (label, value, unit = 'cm') => [label, 'length', unit, value];
const MASS = (label, value, unit = 'kg') => [label, 'mass', unit, value];
const DATE = (label, value) => [label, 'date', null, value];

/** "2026-12-25" → { y, m, d } or null. */
function readDate(text) {
    const m = String(text ?? '').match(/^(\d{4})-(\d{2})-(\d{2})$/);

    return m ? { y: Number(m[1]), m: Number(m[2]), d: Number(m[3]) } : null;
}

const todayDate = () => {
    const t = new Date();

    return { y: t.getFullYear(), m: t.getMonth() + 1, d: t.getDate() };
};

/** Boxes of size b fitting in space s, best of the six orientations (or upright only). */
function bestFit(space, box, uprightOnly = false) {
    const [L, W, H] = space;
    const [l, w, h] = box;
    const orients = uprightOnly ? [[l, w, h], [w, l, h]] : [[l, w, h], [l, h, w], [w, l, h], [w, h, l], [h, l, w], [h, w, l]];
    let best = { n: 0 };

    for (const [a, b, c] of orients) {
        const nx = Math.floor(L / a + 1e-9);
        const ny = Math.floor(W / b + 1e-9);
        const nz = Math.floor(H / c + 1e-9);

        if (nx * ny * nz > best.n) {
            best = { n: nx * ny * nz, nx, ny, nz, dims: [a, b, c] };
        }
    }

    return best;
}

export const TOOLS = {
    cbm: {
        type: 'calc',
        inputs: { l: LEN('Carton length', 60), w: LEN('Carton width', 40), h: LEN('Carton height', 35), qty: N('Number of cartons', 120, 1) },
        data: ['containers'],
        label: 'Total volume',
        rows: { each: 'One carton', ft3: 'Cubic feet', containers: 'Containers by volume (at 85% fill)' },
        run: (x, ctx) => {
            const each = x.l * x.w * x.h;
            const total = each * x.qty;
            const c = ctx.c.data.other?.containers ?? {};
            const fits = Object.values(c).map((k) => `${k.name}: ${num(Math.ceil(total / ((k.l * k.w * k.h) / 1e9 * 0.85) - 1e-9))}`).join('; ');

            return { value: `${num(total, 5)} m³`, sub: `${num(x.qty)} cartons`, rows: { each: `${num(each, 5)} m³`, ft3: num(total * 35.3147, 5), containers: fits || '—' }, steps: ['CBM = length × width × height (m) × quantity', 'Real loads rarely fill more than 80–90% of a container; check weight too'] };
        },
    },
    container_loading: {
        type: 'calc',
        inputs: { container: SEL('Container', 'data:containers', '20'), cl: LEN('Container inside length (custom)', 590), cw: LEN('Inside width (custom)', 235), ch: LEN('Inside height (custom)', 239), l: LEN('Carton length', 60), w: LEN('Carton width', 40), h: LEN('Carton height', 35), weight: MASS('Carton weight', 18), rotate: SEL('Cartons may lie on any side?', { no: 'No (this side up)', yes: 'Yes' }, 'no') },
        show: { cl: 'container:custom', cw: 'container:custom', ch: 'container:custom' },
        data: ['containers'],
        label: 'Cartons that fit',
        rows: { layout: 'Layout (length × width × height)', fill: 'Volume used', weight: 'Load weight', payload: 'Payload check' },
        run: (x, ctx) => {
            const c = ctx.c.data.other?.containers?.[x.container];
            const space = c && x.container !== 'custom' ? [c.l / 1000, c.w / 1000, c.h / 1000] : [x.cl, x.cw, x.ch];
            const fit = bestFit(space, [x.l, x.w, x.h], x.rotate === 'no');

            if (!fit.n) {
                return { error: 'The carton does not fit in this container.' };
            }

            const load = fit.n * x.weight;
            const payload = c?.payload;

            return { value: num(fit.n), sub: c && x.container !== 'custom' ? c.name : 'Custom container', rows: { layout: `${fit.nx} × ${fit.ny} × ${fit.nz}`, fill: pct((fit.n * x.l * x.w * x.h) / (space[0] * space[1] * space[2]), 4), weight: `${num(load, 5)} kg`, payload: payload ? (load <= payload ? `Within the ${num(payload)} kg payload` : `Over the ${num(payload)} kg payload: limit is ${num(Math.floor(payload / x.weight))} cartons`) : '—' }, steps: ['Cartons are stacked in a single orientation, the best of those allowed', 'Mixed orientations can fit a few more; a load plan from the forwarder has the final say', 'Inside dimensions: Hapag-Lloyd equipment pages (boxes vary slightly)'] };
        },
    },
    dim_weight: {
        type: 'calc',
        inputs: { carrier: SEL('Carrier rule', 'data:dim_divisors', 'fedex_ups'), divisor: N('Divisor (custom, cm³/kg)', 5000, 1), l: LEN('Length', 50), w: LEN('Width', 40), h: LEN('Height', 30), actual: MASS('Actual weight', 8) },
        show: { divisor: 'carrier:custom' },
        when: { divisor: (x) => x.carrier === 'custom' },
        data: ['dim_divisors'],
        label: 'Billable weight',
        rows: { dim: 'Dimensional weight', actualRow: 'Actual weight', applies: 'Rule', imperial: 'In pounds' },
        run: (x, ctx) => {
            const c = ctx.c.data.other?.dim_divisors?.[x.carrier];
            const cm = [x.l, x.w, x.h].map((v) => Math.ceil(v * 100 - 1e-9));
            const inches = [x.l, x.w, x.h].map((v) => Math.ceil(v / 0.0254 - 1e-9));
            const metric = !c || x.carrier === 'custom' || x.carrier === 'dhl' || x.carrier === 'air_6000';
            const divisor = c && x.carrier !== 'custom' ? c : { cm: x.divisor, in: x.divisor / 36.127, threshold: 0 };
            const vIn = inches.reduce((a, b) => a * b, 1);
            const applies = !(divisor.threshold && vIn <= divisor.threshold);
            const dimKg = metric ? cm.reduce((a, b) => a * b, 1) / divisor.cm : (Math.ceil(vIn / divisor.in - 1e-9)) * 0.45359237;
            const bill = applies ? Math.max(dimKg, x.actual) : x.actual;

            return { value: `${num(bill, 5)} kg`, sub: applies ? (dimKg > x.actual ? 'Dimensional weight applies' : 'Actual weight applies') : 'Under the size threshold: actual weight applies', rows: { dim: `${num(dimKg, 5)} kg`, actualRow: `${num(x.actual, 5)} kg`, applies: metric ? `L × W × H (cm, each rounded up) ÷ ${num(divisor.cm)}` : `L × W × H (in, each rounded up) ÷ ${num(divisor.in)}, rounded up to a whole lb${divisor.threshold ? ` (only above ${num(divisor.threshold)} in³)` : ''}`, imperial: `${num(bill / 0.45359237, 5)} lb` }, steps: ['Carriers bill the larger of actual and dimensional weight', 'Divisors: FedEx and UPS 139 in³/lb (daily rates), UPS retail 166, USPS 139 from July 2026 for parcels over 1 ft³, DHL Express 5,000 cm³/kg', 'Contract rates can use other divisors; check your account'] };
        },
    },
    dpmo: {
        type: 'calc',
        inputs: { defects: N('Defects found', 34, 0), units: N('Units inspected', 5000, 1), opps: N('Defect opportunities per unit', 8, 1) },
        label: 'DPMO',
        rows: { sigma: 'Sigma level (with 1.5σ shift)', yield: 'Process yield', dpu: 'Defects per unit' },
        run: (x) => {
            const dpo = x.defects / (x.units * x.opps);
            const dpmo = dpo * 1e6;
            const sigma = dpo > 0 && dpo < 1 ? normInv(1 - dpo) + 1.5 : dpo === 0 ? Infinity : 0;

            return { value: num(dpmo, 5), sub: `${num(x.defects)} defects in ${num(x.units * x.opps)} opportunities`, rows: { sigma: Number.isFinite(sigma) ? num(sigma, 4) : '> 6 (no defects)', yield: pct(1 - dpo, 6), dpu: num(x.defects / x.units, 5) }, steps: ['DPMO = defects ÷ (units × opportunities) × 1,000,000', 'Sigma level = Φ⁻¹(1 − DPO) + 1.5 (the Six Sigma convention for long-term drift)', '3.4 DPMO corresponds to six sigma'] };
        },
    },
    freight_class: {
        type: 'calc',
        inputs: { l: LEN('Length', 48, 'in'), w: LEN('Width', 40, 'in'), h: LEN('Height (including pallet)', 50, 'in'), weight: MASS('Weight (including pallet)', 600, 'lb'), units: N('Number of identical pallets', 1, 1) },
        data: ['freight_classes'],
        label: 'Estimated freight class',
        rows: { density: 'Density', volume: 'Volume', note: 'Note' },
        grids: [['table', 'NMFC density scale (2025)']],
        run: (x, ctx) => {
            const table = ctx.c.data.other?.freight_classes ?? [];
            const ft3 = (x.l * x.w * x.h) / 0.0283168466;
            const lb = x.weight / 0.45359237;
            const density = lb / ft3;
            const cls = table.find((r) => density >= r.min);

            return { value: cls ? `Class ${cls.class}` : '—', sub: `${num(density, 4)} lb/ft³`, rows: { density: `${num(density, 4)} lb/ft³ (${num(density * 16.0185, 4)} kg/m³)`, volume: `${num(ft3 * x.units, 4)} ft³ (${num(x.l * x.w * x.h * x.units, 4)} m³)`, note: 'An estimate from density: the class that applies is set by the commodity’s NMFC item' }, steps: ['Density = weight (lb) ÷ volume (ft³), with the pallet included', 'Density-based scale of NMFC Docket 2025-1 (effective 19 July 2025), 13 bands from class 50 to 400'], grids: { table: { columns: ['Density (lb/ft³)'], rows: table.map((r, i) => ({ header: `Class ${r.class}`, cells: [i === 0 ? `${r.min} or more` : `${r.min} to under ${table[i - 1].min}`], highlight: cls === r })) } } };
        },
    },
    pallet: {
        type: 'calc',
        inputs: { pallet: SEL('Pallet', { us: 'US GMA 48 × 40 in', eur: 'EUR 1200 × 800 mm', uk: 'UK 1200 × 1000 mm', custom: 'Custom' }, 'us'), pl: LEN('Pallet length (custom)', 120), pw: LEN('Pallet width (custom)', 100), l: LEN('Box length', 40), w: LEN('Box width', 30), h: LEN('Box height', 25), maxH: LEN('Maximum load height (with pallet)', 160), palletH: LEN('Pallet height', 15), weight: MASS('Box weight', 12), maxW: MASS('Maximum load weight', 1000), overhang: LEN('Allowed overhang per side', 0) },
        show: { pl: 'pallet:custom', pw: 'pallet:custom' },
        label: 'Boxes per pallet',
        rows: { layer: 'Boxes per layer', layers: 'Layers', weight: 'Load weight', limit: 'Limited by' },
        run: (x) => {
            const size = { us: [1.2192, 1.016], eur: [1.2, 0.8], uk: [1.2, 1.0] }[x.pallet] ?? [x.pl, x.pw];
            const L = size[0] + 2 * (x.overhang || 0);
            const W = size[1] + 2 * (x.overhang || 0);
            const perLayer = Math.max(Math.floor(L / x.l + 1e-9) * Math.floor(W / x.w + 1e-9), Math.floor(L / x.w + 1e-9) * Math.floor(W / x.l + 1e-9));
            const layers = Math.floor((x.maxH - x.palletH) / x.h + 1e-9);
            const byHeight = perLayer * layers;
            const byWeight = x.maxW > 0 ? Math.floor(x.maxW / x.weight + 1e-9) : Infinity;
            const n = Math.min(byHeight, byWeight);

            if (!(perLayer > 0 && layers > 0)) {
                return { error: 'The box does not fit on the pallet with these limits.' };
            }

            return { value: num(n), sub: `${perLayer} per layer × ${layers} layers`, rows: { layer: num(perLayer), layers: num(layers), weight: `${num(n * x.weight, 5)} kg`, limit: byWeight < byHeight ? 'Weight' : 'Height' }, steps: ['Boxes per layer: the better of the two upright orientations (column stacking)', 'Layers = (maximum height − pallet height) ÷ box height', 'Interlocked patterns can add a box or two per layer and make the load more stable'] };
        },
    },
    reorder_point: {
        type: 'calc',
        inputs: { demand: N('Average daily demand (units)', 40, 0), lead: N('Lead time (days)', 7, 0), method: SEL('Safety stock', { fixed: 'A fixed number', service: 'From a service level' }, 'service'), safety: N('Safety stock (units)', 60, 0), sdDemand: N('Standard deviation of daily demand', 12, 0), service: N('Service level (%)', 95, 0) },
        show: { safety: 'method:fixed', sdDemand: 'method:service', service: 'method:service' },
        when: { safety: (x) => x.method === 'fixed', sdDemand: (x) => x.method === 'service', service: (x) => x.method === 'service' },
        label: 'Reorder point',
        rows: { lt: 'Demand during the lead time', ss: 'Safety stock', z: 'z for the service level' },
        run: (x) => {
            const z = x.method === 'service' ? normInv(x.service / 100) : NaN;
            const ss = x.method === 'service' ? z * x.sdDemand * Math.sqrt(x.lead) : x.safety;
            const rop = x.demand * x.lead + ss;

            return { value: `${num(Math.ceil(rop - 1e-9))} units`, sub: 'Order again when stock falls to this', rows: { lt: num(x.demand * x.lead, 5), ss: num(ss, 5), z: Number.isFinite(z) ? num(z, 4) : '—' }, steps: ['ROP = daily demand × lead time + safety stock', 'Safety stock = z × σ(daily demand) × √(lead time) for variable demand and a fixed lead time'] };
        },
    },
    takt: {
        type: 'calc',
        inputs: { minutes: N('Available production time per shift (minutes)', 450, 0), demand: N('Customer demand per shift (units)', 300, 1), cycle: N('Total work content per unit (seconds, optional)', 360, 0) },
        optional: ['cycle'],
        label: 'Takt time',
        rows: { perHour: 'Units per hour needed', operators: 'Operators (stations) needed' },
        run: (x) => {
            const t = (x.minutes * 60) / x.demand;

            return { value: `${num(t, 4)} s per unit`, sub: `${num(x.demand)} units in ${num(x.minutes)} min`, rows: { perHour: num(3600 / t, 4), operators: x.cycle > 0 ? `${num(Math.ceil(x.cycle / t - 1e-9))} (${num(x.cycle / t, 4)} exactly)` : 'Enter the work content' }, steps: ['Takt time = available time ÷ customer demand', 'Available time excludes breaks and planned stops', 'Operators = total work content ÷ takt time, rounded up'] };
        },
    },
    landed_cost: {
        type: 'calc',
        inputs: { units: N('Units', 1000, 1), price: MONEY('Product cost per unit', 4.5), freight: MONEY('Freight (total)', 1200), insurance: MONEY('Insurance (total)', 60), duty: N('Duty rate (%)', 10, 0), basis: SEL('Duty charged on', { cif: 'CIF value (cost + insurance + freight)', fob: 'FOB value (product only)' }, 'cif'), tax: N('Import VAT / GST (% of value + duty, if not reclaimed)', 0, 0), fees: MONEY('Other fees (customs broker, port, handling)', 250) },
        label: 'Landed cost per unit',
        rows: { total: 'Total landed cost', duty: 'Duty', taxRow: 'Import tax', share: 'Share that is not the product' },
        run: (x) => {
            const goods = x.units * x.price;
            const base = x.basis === 'cif' ? goods + x.freight + x.insurance : goods;
            const duty = (base * x.duty) / 100;
            const tax = ((goods + x.freight + x.insurance + duty) * x.tax) / 100;
            const total = goods + x.freight + x.insurance + duty + tax + x.fees;

            return { value: formatMoney(total / x.units), sub: `${num(x.units)} units`, rows: { total: formatMoney(total), duty: formatMoney(duty), taxRow: formatMoney(tax), share: pct(1 - goods / total, 4) }, steps: ['Landed cost = product + freight + insurance + duty + taxes + fees', 'The EU, UK and India charge duty on the CIF value; the US uses the FOB (transaction) value', 'Reclaimable VAT/GST is not a cost: enter 0 if you reclaim it'] };
        },
    },
    christmas_tree: {
        type: 'calc',
        inputs: { height: LEN('Tree height', 1.8, 'm'), style: SEL('Look', { light: 'Light decoration', standard: 'Standard', full: 'Full and bright' }, 'standard') },
        label: 'Lights needed',
        rows: { garland: 'Garland or tinsel', ornaments: 'Ornaments', topper: 'Topper size' },
        run: (x) => {
            const ft = x.height / 0.3048;
            const k = { light: 0.5, standard: 1, full: 1.5 }[x.style];

            return { value: `${num(Math.round((ft * 100 * k) / 50) * 50)} lights`, sub: `${num(x.height, 3)} m (${num(ft, 3)} ft) tree`, rows: { garland: `${num(x.height * 2.5 * k, 3)} m`, ornaments: num(Math.round(ft * 10 * k)), topper: `about ${num(Math.max(15, x.height * 100 * 0.1), 3)} cm tall` }, steps: ['Common retail guidance: about 100 mini lights per foot of tree for a standard look', 'Garland: about two to three times the tree height; about 10 ornaments per foot', 'Rules of thumb — wider trees need more'] };
        },
    },
    countdown: {
        type: 'calc',
        inputs: { holiday: SEL('Holiday', { christmas: 'Christmas (25 December)', newyear: 'New Year’s Day (1 January)', valentine: 'Valentine’s Day (14 February)', easter: 'Easter Sunday', halloween: 'Halloween (31 October)', thanksgiving: 'Thanksgiving (US, 4th Thursday of November)', fall: 'First day of autumn (September equinox)', custom: 'Another date' }, 'christmas'), date: DATE('Date (for another date)', '2026-12-31'), from: DATE('Counting from (blank = today)', '') },
        show: { date: 'holiday:custom' },
        label: 'Days to go',
        rows: { when: 'Date', weekday: 'Day of the week', weeks: 'Weeks and days', sleeps: 'Sleeps' },
        run: (x) => {
            const from = readDate(x.from) ?? todayDate();
            const target = (y) => {
                switch (x.holiday) {
                    case 'christmas': return { y, m: 12, d: 25 };
                    case 'newyear': return { y: y + 1, m: 1, d: 1 };
                    case 'valentine': return { y, m: 2, d: 14 };
                    case 'easter': return G.easterGregorian(y);
                    case 'halloween': return { y, m: 10, d: 31 };
                    case 'thanksgiving': return { y, m: 11, d: G.nthWeekday(y, 11, 4, 4) };
                    case 'fall': {
                        const j = G.fromJd(G.season(y, 2));

                        return { y: j.y, m: j.m, d: j.d };
                    }
                    default: return readDate(x.date);
                }
            };
            let t = target(from.y);

            if (!t) {
                return { error: 'Enter the date to count to.' };
            }

            const j0 = G.jdn(from.y, from.m, from.d);

            if (x.holiday !== 'custom' && G.jdn(t.y, t.m, t.d) < j0) {
                t = target(from.y + 1);
            }

            if (x.holiday === 'newyear' && G.jdn(t.y, t.m, t.d) - j0 > 365) {
                t = { y: from.y, m: 1, d: 1 };
            }

            const days = G.jdn(t.y, t.m, t.d) - j0;

            return { value: days === 0 ? 'Today!' : days > 0 ? `${num(days)} days` : `${num(-days)} days ago`, sub: `until ${G.dateText(t)}`, rows: { when: G.dateText(t), weekday: G.weekday(t.y, t.m, t.d), weeks: `${Math.floor(Math.abs(days) / 7)} weeks and ${Math.abs(days) % 7} days`, sleeps: num(Math.max(0, days)) }, steps: ['Days between two dates by Julian Day Numbers (no time-zone effects)', 'Easter by the Gregorian computus; the September equinox from Meeus’s formula (UTC date)', `Counting from ${G.dateText(from)}`] };
        },
    },
    easter: {
        type: 'calc',
        inputs: { year: N('Year', 2027, 1583), church: SEL('Church', { western: 'Western (Catholic, Protestant)', orthodox: 'Orthodox' }, 'western') },
        label: 'Easter Sunday',
        rows: { other: 'The other church’s Easter', ash: 'Ash Wednesday', goodFriday: 'Good Friday', pentecost: 'Pentecost' },
        grids: [['table', 'The next ten years']],
        run: (x) => {
            if (!(Number.isInteger(x.year) && x.year >= 1583 && x.year <= 4099)) {
                return { error: 'Use a year from 1583 to 4099 (the Gregorian calendar).' };
            }

            const e = x.church === 'western' ? G.easterGregorian(x.year) : G.easterOrthodox(x.year);
            const o = x.church === 'western' ? G.easterOrthodox(x.year) : G.easterGregorian(x.year);

            return { value: G.dateText(e), sub: x.church === 'western' ? 'Western Easter' : 'Orthodox Easter (Gregorian date)', rows: { other: G.dateText(o), ash: x.church === 'western' ? G.dateText(G.addDays(e, -46)) : 'Western churches only', goodFriday: G.dateText(G.addDays(e, -2)), pentecost: G.dateText(G.addDays(e, 49)) }, steps: ['Easter is the first Sunday after the ecclesiastical full moon on or after 21 March', 'Western: Gregorian computus (Meeus/Jones/Butcher algorithm); Orthodox: Julian computus converted to the Gregorian calendar'], grids: { table: { columns: ['Western', 'Orthodox'], rows: Array.from({ length: 10 }, (_, k) => ({ header: String(x.year + k), cells: [G.dateText(G.easterGregorian(x.year + k)).replace(` ${x.year + k}`, ''), G.dateText(G.easterOrthodox(x.year + k)).replace(` ${x.year + k}`, '')] })) } } };
        },
    },
    mayan: {
        type: 'calc',
        inputs: { mode: SEL('Convert', { toMaya: 'A date → Mayan calendar', fromMaya: 'A Long Count → date' }, 'toMaya'), date: DATE('Date', '2012-12-21'), lc: LINE('Long Count (b.k.t.u.k)', '13.0.0.0.0') },
        show: { date: 'mode:toMaya', lc: 'mode:fromMaya' },
        label: 'Long Count',
        rows: { tzolkin: 'Tzolk’in', haab: 'Haab’', lord: 'Lord of the Night', date: 'Gregorian date', days: 'Days since the Long Count began' },
        run: (x) => {
            let J;

            if (x.mode === 'toMaya') {
                const d = readDate(x.date);

                if (!d) {
                    return { error: 'Enter a date.' };
                }

                J = G.jdn(d.y, d.m, d.d);
            } else {
                J = G.fromLongCount(x.lc);

                if (J === null) {
                    return { error: 'Write the Long Count as five numbers, e.g. 13.0.0.0.0 (k’atun, tun and k’in up to 19, winal up to 17).' };
                }
            }

            const m = G.maya(J);
            const g = G.fromJdn(J);

            return { value: m.longCount, sub: `${m.tzolkin} ${m.haab}`, rows: { tzolkin: m.tzolkin, haab: m.haab, lord: m.lord, date: `${G.dateText(g)} (${G.weekday(g.y, g.m, g.d)})`, days: num(m.days) }, steps: ['Long Count: b’ak’tun (144,000 days), k’atun (7,200), tun (360), winal (20), k’in (1)', 'GMT correlation 584283: 13.0.0.0.0 4 Ajaw 8 Kumk’u = 11 August 3114 BC (proleptic Gregorian)', 'Dates before 1582 are shown in the proleptic Gregorian calendar'] };
        },
    },
    resolutions: {
        type: 'calc',
        inputs: { weeks: N('Weeks since 1 January', 4, 0) },
        data: ['resolutions'],
        label: 'Share still on track',
        rows: { odds: 'Your chance from here (if like the study)', milestones: 'Study milestones' },
        plots: [['curve', 'Resolvers still keeping their resolution']],
        run: (x, ctx) => {
            const pts = ctx.c.data.other?.resolutions ?? [];
            const at = (w) => {
                for (let i = 1; i < pts.length; i += 1) {
                    if (w <= pts[i][0]) {
                        const [w0, p0] = pts[i - 1];
                        const [w1, p1] = pts[i];

                        return p0 + ((w - w0) / (w1 - w0)) * (p1 - p0);
                    }
                }

                return pts[pts.length - 1][1];
            };
            const now = at(x.weeks);

            return { value: `${num(now, 3)}%`, sub: `after ${num(x.weeks)} weeks`, rows: { odds: `${pct(at(26) / now, 3)} chance to still be on track at 6 months, given you are now`, milestones: '1 week 77%, 1 month 55%, 3 months 43%, 6 months 40%, 2 years 19%' }, steps: ['Norcross & Vangarelli (1988–89) followed 200 resolvers; values between their check points are interpolated', 'Making a specific, measurable resolution and tracking it improves the odds'], plots: { curve: { series: Array.from({ length: 105 }, (_, w) => [w, at(w)]), markers: [{ x: x.weeks, y: now, label: 'you' }], xLabel: 'Weeks', yLabel: '% on track', yMin: 0, yMax: 100 } } };
        },
    },
    snowman: {
        type: 'calc',
        inputs: { height: LEN('Snowman height', 1.5, 'm'), snow: SEL('Snow', { packed: 'Packed snowball (about 400 kg/m³)', wet: 'Wet, heavy snow (about 500 kg/m³)' }, 'packed'), fresh: LEN('Depth of fresh snow on the ground', 10, 'cm') },
        label: 'Snow needed',
        rows: { balls: 'Ball diameters (3 : 2 : 1)', weight: 'Weight', area: 'Area of fresh snow to gather' },
        run: (x) => {
            const d = x.height / 1.75;
            const ds = [d, (d * 2) / 3, d / 3];
            const vol = sum(ds.map((v) => (Math.PI / 6) * v ** 3));
            const rho = x.snow === 'packed' ? 400 : 500;
            const freshVol = (vol * rho) / 100;

            return { value: `${num(vol, 4)} m³`, sub: `of packed snow for a ${num(x.height, 3)} m snowman`, rows: { balls: ds.map((v) => `${num(v * 100, 3)} cm`).join(', '), weight: `${num(vol * rho, 4)} kg`, area: `${num(freshVol / x.fresh, 4)} m² at ${num(x.fresh * 100, 3)} cm deep (fresh snow ≈ 100 kg/m³)` }, steps: ['Three balls with diameters in the ratio 3 : 2 : 1, stacked with some overlap (height ≈ 1.75 × base diameter)', 'Volume of a sphere = π d³ ÷ 6; snow densities are typical values'] };
        },
    },
    trick_treat: {
        type: 'calc',
        inputs: { visitors: N('Expected trick-or-treaters', 80, 0), pieces: N('Pieces per child', 2, 1), perBag: N('Pieces in one bag of candy', 100, 1), bagPrice: MONEY('Price per bag', 12), spare: N('Spare (%)', 15, 0) },
        label: 'Bags to buy',
        rows: { pieces: 'Pieces needed', cost: 'Cost' },
        run: (x) => {
            const pieces = Math.ceil(x.visitors * x.pieces * (1 + x.spare / 100));
            const bags = Math.ceil(pieces / x.perBag);

            return { value: num(bags), sub: `${num(pieces)} pieces`, rows: { pieces: num(pieces), cost: formatMoney(bags * x.bagPrice) }, steps: ['Pieces = visitors × pieces each × (1 + spare)', 'Last year’s count is the best guide to visitors'] };
        },
    },
    seasons: {
        type: 'calc',
        inputs: { year: N('Year', 2027, 1941), tz: N('Show times at UTC offset (hours)', 0) },
        label: 'March equinox',
        rows: { june: 'June solstice', september: 'September equinox', december: 'December solstice', lengths: 'Season lengths (spring, summer, autumn, winter, northern)' },
        run: (x) => {
            if (!(Number.isInteger(x.year) && x.year >= 1941 && x.year <= 2100)) {
                return { error: 'Use a year from 1941 to 2100.' };
            }

            const jds = [0, 1, 2, 3].map((k) => G.season(x.year, k));
            const t = (jd) => G.fromJd(jd + x.tz / 24).text.replace('UTC', x.tz ? `UTC${x.tz > 0 ? '+' : ''}${num(x.tz)}` : 'UTC');
            const next = G.season(x.year + 1, 0);
            const lens = [jds[1] - jds[0], jds[2] - jds[1], jds[3] - jds[2], next - jds[3]].map((d) => `${num(d, 4)} d`);

            return { value: t(jds[0]), sub: `${x.year}`, rows: { june: t(jds[1]), september: t(jds[2]), december: t(jds[3]), lengths: lens.join(', ') }, steps: ['Meeus, Astronomical Algorithms ch. 27 (24 periodic terms), converted from Terrestrial Time to UTC with ΔT', 'Accurate to about a minute; checked against a modern solar ephemeris'] };
        },
    },
    dst: {
        type: 'calc',
        inputs: { year: N('Year', 2027, 2008), region: SEL('Region', { us: 'United States and Canada', eu: 'European Union', uk: 'United Kingdom', au: 'Australia (NSW, Vic, SA, Tas, ACT)', nz: 'New Zealand' }, 'us') },
        label: 'Clocks go forward',
        rows: { back: 'Clocks go back', length: 'Length of daylight saving', rule: 'Rule' },
        run: (x) => {
            const y = x.year;
            const R = {
                us: [[y, 3, G.nthWeekday(y, 3, 0, 2), '2:00 local'], [y, 11, G.nthWeekday(y, 11, 0, 1), '2:00 local'], 'Second Sunday in March to first Sunday in November (Energy Policy Act 2005)'],
                eu: [[y, 3, G.nthWeekday(y, 3, 0, -1), '01:00 UTC'], [y, 10, G.nthWeekday(y, 10, 0, -1), '01:00 UTC'], 'Last Sunday in March to last Sunday in October at 01:00 UTC (Directive 2000/84/EC)'],
                uk: [[y, 3, G.nthWeekday(y, 3, 0, -1), '1:00 GMT'], [y, 10, G.nthWeekday(y, 10, 0, -1), '2:00 BST'], 'Last Sunday in March to last Sunday in October (gov.uk)'],
                au: [[y, 10, G.nthWeekday(y, 10, 0, 1), '2:00 standard time'], [y + 1, 4, G.nthWeekday(y + 1, 4, 0, 1), '3:00 daylight time'], 'First Sunday in October to first Sunday in April (NSW Government); Qld, WA and NT do not change'],
                nz: [[y, 9, G.nthWeekday(y, 9, 0, -1), '2:00'], [y + 1, 4, G.nthWeekday(y + 1, 4, 0, 1), '3:00'], 'Last Sunday in September to first Sunday in April (NZ Daylight Time Order 2007)'],
            }[x.region];
            const [start, end, rule] = R;
            const days = G.jdn(end[0], end[1], end[2]) - G.jdn(start[0], start[1], start[2]);

            return { value: `${G.weekday(start[0], start[1], start[2])} ${G.dateText({ y: start[0], m: start[1], d: start[2] })} at ${start[3]}`, sub: 'Clocks go forward one hour (lose an hour of sleep)', rows: { back: `${G.weekday(end[0], end[1], end[2])} ${G.dateText({ y: end[0], m: end[1], d: end[2] })} at ${end[3]}`, length: `${days} days`, rule }, steps: ['“Spring forward, fall back”', 'Rules change by law; these are the rules in force in 2026'] };
        },
    },
    antipode: {
        type: 'calc',
        inputs: { lat: LINE('Latitude (e.g. 28.6139 or 28°36′50″N)', '28.6139'), lon: LINE('Longitude (e.g. 77.2090 or 77°12′32″E)', '77.2090') },
        label: 'Antipode',
        rows: { dms: 'In degrees, minutes, seconds', distance: 'Distance through the Earth', around: 'Distance along the surface' },
        run: (x) => {
            const lat = G.parseAngle(x.lat, true);
            const lon = G.parseAngle(x.lon, false);

            if (lat === null || lon === null) {
                return { error: 'Enter a latitude (−90 to 90) and longitude (−180 to 180).' };
            }

            const [a, b] = G.antipode(lat, lon);

            return { value: `${num(a, 7)}, ${num(b, 7)}`, sub: `opposite ${num(lat, 7)}, ${num(lon, 7)}`, rows: { dms: `${G.dms(a, true)}, ${G.dms(b, false)}`, distance: `${num((2 * G.EARTH_MEAN_RADIUS) / 1000, 5)} km (mean diameter)`, around: `${num((Math.PI * G.EARTH_MEAN_RADIUS) / 1000, 5)} km` }, steps: ['Antipode: latitude → −latitude, longitude → longitude ± 180°', 'About 71% of the surface is ocean, so most antipodes are at sea'] };
        },
    },
    azimuth: {
        type: 'calc',
        inputs: { lat1: LINE('From latitude', '51.5074'), lon1: LINE('From longitude', '-0.1278'), lat2: LINE('To latitude', '40.7128'), lon2: LINE('To longitude', '-74.0060') },
        label: 'Initial bearing (azimuth)',
        rows: { compass: 'Compass direction', final: 'Final bearing on arrival', distance: 'Distance (WGS-84)' },
        run: (x) => {
            const p = [G.parseAngle(x.lat1, true), G.parseAngle(x.lon1, false), G.parseAngle(x.lat2, true), G.parseAngle(x.lon2, false)];

            if (p.some((v) => v === null)) {
                return { error: 'Enter both points as latitude and longitude.' };
            }

            const v = G.vincenty(...p);

            if (!v) {
                return { error: 'The points are almost exactly opposite: the bearing is not unique.' };
            }

            return { value: `${num(v.initial, 6)}°`, sub: `${G.compass(v.initial)} (clockwise from true north)`, rows: { compass: G.compass(v.initial), final: `${num(v.final, 6)}°`, distance: `${num(v.distance / 1000, 7)} km` }, steps: ['Great-circle (geodesic) bearing on the WGS-84 ellipsoid by Vincenty’s formula', 'The bearing changes along a great circle, so the final bearing differs from the initial one', 'For a magnetic compass, subtract the local magnetic declination'] };
        },
    },
    earthquake: {
        type: 'calc',
        inputs: { m: N('Magnitude (moment magnitude Mw)', 7.8, 0), m2: N('Compare with magnitude (optional)', 6, 0) },
        optional: ['m2'],
        label: 'Energy released',
        rows: { tnt: 'TNT equivalent', moment: 'Seismic moment M₀', compare: 'Compared with the other quake' },
        run: (x) => {
            const E = 10 ** (1.5 * x.m + 4.8);
            const M0 = 10 ** (1.5 * x.m + 9.1);
            const tnt = E / 4.184e9;

            return { value: `${num(E, 4)} J`, sub: `magnitude ${num(x.m)}`, rows: { tnt: tnt >= 1e6 ? `${num(tnt / 1e6, 4)} megatons` : tnt >= 1e3 ? `${num(tnt / 1e3, 4)} kilotons` : `${num(tnt, 4)} tons`, moment: `${num(M0, 4)} N·m`, compare: Number.isFinite(x.m2) ? `${num(10 ** (1.5 * (x.m - x.m2)), 4)} × the energy, ${num(10 ** (x.m - x.m2), 4)} × the ground shaking amplitude` : 'Enter a second magnitude' }, steps: ['log₁₀ E = 1.5 M + 4.8 (Gutenberg–Richter, E in joules)', 'Mw = (2/3)(log₁₀ M₀ − 9.1), M₀ in newton-metres (Hanks & Kanamori 1979)', 'Each whole magnitude is about 32 times more energy and 10 times the amplitude'] };
        },
    },
    latlong_distance: {
        type: 'calc',
        inputs: { lat1: LINE('Point A latitude', '19.0760'), lon1: LINE('Point A longitude', '72.8777'), lat2: LINE('Point B latitude', '28.6139'), lon2: LINE('Point B longitude', '77.2090') },
        label: 'Distance',
        rows: { miles: 'In miles and nautical miles', haversine: 'Haversine (spherical) distance', bearing: 'Initial bearing', midpoint: 'Midpoint' },
        run: (x) => {
            const p = [G.parseAngle(x.lat1, true), G.parseAngle(x.lon1, false), G.parseAngle(x.lat2, true), G.parseAngle(x.lon2, false)];

            if (p.some((v) => v === null)) {
                return { error: 'Enter both points as latitude and longitude (decimal or DMS).' };
            }

            const v = G.vincenty(...p);
            const h = G.haversine(...p);
            const d = v ? v.distance : h;
            const mid = G.midpoint(...p);

            return { value: `${num(d / 1000, 7)} km`, sub: v ? 'Ellipsoidal (Vincenty, WGS-84)' : 'Spherical (points almost opposite)', rows: { miles: `${num(d / 1609.344, 7)} mi, ${num(d / 1852, 7)} nmi`, haversine: `${num(h / 1000, 7)} km (${pct(Math.abs(h - d) / d, 3)} different)`, bearing: v ? `${num(v.initial, 5)}° (${G.compass(v.initial)})` : '—', midpoint: `${num(mid[0], 6)}, ${num(mid[1], 6)}` }, steps: ['Vincenty’s inverse formula on the WGS-84 ellipsoid (accurate to about a millimetre)', 'The haversine formula on a sphere of mean radius 6,371 km is within about 0.5%', 'This is the shortest path over the surface, not a road or flight route'] };
        },
    },
    rainfall: {
        type: 'calc',
        inputs: { rain: LEN('Rainfall depth', 25, 'mm'), area: ['Area (roof, garden, field)', 'area', 'm2', 100], runoff: SEL('Surface', { 0.95: 'Metal or tiled roof (0.95)', 0.85: 'Concrete or asphalt (0.85)', 0.6: 'Gravel (0.6)', 0.2: 'Lawn or garden (0.2)', 1: 'All the water (1.0)' }, '0.95') },
        label: 'Rain volume',
        rows: { collected: 'Water you could collect (runoff)', weight: 'Weight', gallons: 'In US gallons' },
        run: (x) => {
            const vol = x.rain * x.area;
            const col = vol * Number(x.runoff);

            return { value: `${num(vol * 1000, 5)} L`, sub: `${num(x.rain * 1000, 4)} mm on ${num(x.area, 5)} m²`, rows: { collected: `${num(col * 1000, 5)} L`, weight: `${num(vol * 1000, 5)} kg`, gallons: num((vol * 1000) / 3.785411784, 5) }, steps: ['Volume = depth × area: 1 mm of rain on 1 m² is 1 litre', 'Runoff coefficient: the share that flows off the surface (rainwater harvesting uses about 0.8–0.95 for roofs)'] };
        },
    },
    rain_snow: {
        type: 'calc',
        inputs: { rain: LEN('Liquid precipitation (rain equivalent)', 10, 'mm'), temp: N('Surface temperature (°F)', 25), by: SEL('Ratio', { table: 'From temperature (NWS table)', fixed: 'My own ratio' }, 'table'), ratio: N('Snow : liquid ratio', 10, 1) },
        show: { temp: 'by:table', ratio: 'by:fixed' },
        when: { temp: (x) => x.by === 'table', ratio: (x) => x.by === 'fixed' },
        data: ['snow_ratio'],
        label: 'Snow depth',
        rows: { ratioUsed: 'Ratio used', inches: 'In inches', range: 'Plausible range (5:1 to 20:1)' },
        run: (x, ctx) => {
            const table = ctx.c.data.other?.snow_ratio ?? [];
            let r = x.ratio;

            if (x.by === 'table') {
                if (x.temp > 34) {
                    return { value: 'Rain', sub: 'Above about 34 °F precipitation usually falls as rain', rows: { ratioUsed: '—', inches: '—', range: '—' }, steps: ['Snow is unlikely above about 34 °F (1 °C) at the surface'] };
                }

                r = (table.find(([min]) => x.temp >= min) ?? table[table.length - 1])[1];
            }

            const depth = x.rain * r;

            return { value: `${num(depth * 100, 4)} cm`, sub: `${num(x.rain * 1000, 4)} mm of liquid at ${r}:1`, rows: { ratioUsed: `${r} : 1`, inches: num(depth / 0.0254, 4), range: `${num(x.rain * 5 * 100, 4)} – ${num(x.rain * 20 * 100, 4)} cm` }, steps: ['Snow depth = liquid equivalent × snow-to-liquid ratio', 'Temperature table: NWS Observing Handbook No. 7 (10:1 at 28–34 °F up to 100:1 below −20 °F)', 'The NWS calls it a rough guide: real ratios range from 3:1 to 100:1'] };
        },
    },
    sunbathing: {
        type: 'calc',
        inputs: { uvi: N('UV index', 8, 0), skin: SEL('Skin type (Fitzpatrick)', 'data:med:fixed', 'III'), spf: N('Sunscreen SPF (1 = none)', 1, 1) },
        data: ['med'],
        label: 'Time until sunburn',
        rows: { range: 'Range for your skin type', withSpf: 'With sunscreen (applied thickly, ideal)', med: 'Minimal erythemal dose' },
        run: (x, ctx) => {
            const m = ctx.c.data.other?.med?.[x.skin];

            if (!m || !(x.uvi > 0)) {
                return { error: 'Enter a UV index above 0 and a skin type.' };
            }

            const irr = x.uvi * 0.025;
            const t = (mj) => (mj * 10) / irr / 60;
            const mid = (m.lo + m.hi) / 2;

            return { value: `about ${num(t(mid), 3)} min`, sub: `UV index ${num(x.uvi)}, ${m.name}`, rows: { range: `${num(t(m.lo), 3)} – ${num(t(m.hi), 3)} min`, withSpf: x.spf > 1 ? `${num(t(m.lo) * x.spf, 3)} – ${num(t(m.hi) * x.spf, 3)} min (most people apply a third as much: about ${num((t(m.lo) * x.spf) / 3, 3)} min)` : 'No sunscreen', med: `${m.lo}–${m.hi} mJ/cm²` }, steps: ['UV index 1 = 25 mW/m² of erythemally weighted UV (WHO/WMO)', 'Time = minimal erythemal dose ÷ irradiance', 'MED by skin type: D’Orazio et al. (2013). An estimate: reflection, altitude and medicines change it; seek shade at UV 3 and above'] };
        },
    },
    age_planets: {
        type: 'calc',
        inputs: { birth: DATE('Date of birth', '1995-06-15'), on: DATE('On date (blank = today)', '') },
        data: ['physics:bodies'],
        label: 'Age on Mars',
        rows: { mercury: 'Mercury', venus: 'Venus', earth: 'Earth', jupiter: 'Jupiter', saturn: 'Saturn', uranus: 'Uranus', neptune: 'Neptune' },
        run: (x, ctx) => {
            const b = readDate(x.birth);
            const o = readDate(x.on) ?? todayDate();
            const bodies = ctx.c.data.physics?.bodies ?? {};

            if (!b) {
                return { error: 'Enter a date of birth.' };
            }

            const days = G.jdn(o.y, o.m, o.d) - G.jdn(b.y, b.m, b.d);

            if (days < 0) {
                return { error: 'The date of birth is after the date.' };
            }

            const age = (k) => (bodies[k]?.period_d ? days / bodies[k].period_d : NaN);
            const text = (k) => `${num(age(k), 5)} years (next birthday in ${num(Math.ceil((1 - (age(k) % 1)) * bodies[k].period_d), 5)} Earth days)`;

            return { value: `${num(age('mars'), 5)} years`, sub: `${num(days)} Earth days old`, rows: { mercury: text('mercury'), venus: text('venus'), earth: text('earth'), jupiter: text('jupiter'), saturn: text('saturn'), uranus: text('uranus'), neptune: text('neptune') }, steps: ['Planet age = days alive ÷ the planet’s orbital (sidereal) period', 'Orbital periods from the NASA Planetary Fact Sheet'] };
        },
    },
    impact_angle: {
        type: 'calc',
        inputs: { width: LEN('Stain width', 6, 'mm'), length: LEN('Stain length', 12, 'mm') },
        label: 'Angle of impact',
        rows: { ratio: 'Width ÷ length', note: 'Note' },
        run: (x) => {
            if (!(x.width > 0 && x.length >= x.width)) {
                return { error: 'The length must be at least the width.' };
            }

            const a = (Math.asin(x.width / x.length) * 180) / Math.PI;

            return { value: `${num(a, 4)}°`, sub: 'from the surface', rows: { ratio: num(x.width / x.length, 4), note: a > 80 ? 'Nearly perpendicular (round stain)' : a < 30 ? 'Glancing impact (long stain)' : 'Oblique impact' }, steps: ['sin α = width ÷ length of the elliptical stain (bloodstain pattern analysis)', 'Measure the best-fit ellipse, ignoring tails and satellite spatter'] };
        },
    },
    recruitment: {
        type: 'calc',
        inputs: { stages: TXT('Stages: name, working days (one per line)', 'Write and approve the job, 5\nAdvertise, 15\nScreen applications, 5\nInterviews, 10\nOffer and acceptance, 5\nNotice period, 20'), start: DATE('Start date', '2026-11-02') },
        label: 'Total time to hire',
        rows: { finish: 'Expected start date (working days)', calendar: 'In calendar weeks', longest: 'Longest stage' },
        grids: [['table', 'Timeline']],
        run: (x) => {
            const stages = String(x.stages ?? '').split(/\r?\n/).map((l) => l.trim()).filter(Boolean).map((l) => {
                const m = l.match(/^(.*?)[,;\t]\s*(\d+(?:\.\d+)?)$/);

                return m ? { name: m[1], days: Number(m[2]) } : null;
            });
            const s = readDate(x.start);

            if (!stages.length || stages.some((v) => !v) || !s) {
                return { error: 'Each line needs a stage and a number of working days, and a start date.' };
            }

            const total = sum(stages.map((v) => v.days));
            let j = G.jdn(s.y, s.m, s.d);
            const rows = [];

            for (const st of stages) {
                let left = Math.ceil(st.days);

                while (left > 0) {
                    j += 1;
                    const wd = (j + 1) % 7;

                    if (wd !== 0 && wd !== 6) {
                        left -= 1;
                    }
                }

                rows.push({ header: st.name, cells: [num(st.days), G.dateText(G.fromJdn(j))] });
            }

            const longest = stages.reduce((a, b) => (b.days > a.days ? b : a));

            return { value: `${num(total)} working days`, sub: `from ${G.dateText(s)}`, rows: { finish: G.dateText(G.fromJdn(j)), calendar: num(total / 5, 3), longest: `${longest.name} (${num(longest.days)} days)` }, steps: ['Stages run one after another; weekends are skipped (public holidays are not)', 'Overlapping stages (screening while advertising) shorten the total'], grids: { table: { columns: ['Days', 'Finishes'], rows } } };
        },
    },
    diamond_weight: {
        type: 'calc',
        inputs: { shape: SEL('Shape', { round: 'Round brilliant (factor 0.0061)', custom: 'Other shape (enter your factor)' }, 'round'), diameter: N('Average diameter or length (mm)', 6.5, 0), width: N('Width (mm, other shapes)', 6.5, 0), depth: N('Depth (mm)', 4, 0), factor: N('Shape factor', 0.0062, 0) },
        show: { width: 'shape:custom', factor: 'shape:custom' },
        when: { width: (x) => x.shape === 'custom', factor: (x) => x.shape === 'custom' },
        label: 'Estimated weight',
        rows: { grams: 'In grams', points: 'In points', note: 'Accuracy' },
        run: (x) => {
            const ct = x.shape === 'round' ? x.diameter ** 2 * x.depth * 0.0061 : x.diameter * x.width * x.depth * x.factor;

            return { value: `${num(ct, 4)} ct`, sub: x.shape === 'round' ? `${num(x.diameter)} mm round, ${num(x.depth)} mm deep` : 'Custom shape factor', rows: { grams: `${num(ct * 0.2, 4)} g`, points: num(ct * 100, 4), note: 'Within about 5–10% for well-cut stones; only weighing is exact' }, steps: ['Round brilliant: carats ≈ average diameter² × depth × 0.0061 (mm)', '1 carat = 0.2 g = 100 points', 'Fancy-shape factors differ between references, so enter the one your appraiser uses'] };
        },
    },
    engagement: {
        type: 'calc',
        inputs: { likes: N('Likes', 820, 0), comments: N('Comments', 64, 0), shares: N('Shares', 31, 0), saves: N('Saves', 45, 0), followers: N('Followers', 25000, 1), reach: N('Reach (optional)', 12000, 0), impressions: N('Impressions (optional)', 18000, 0) },
        optional: ['reach', 'impressions'],
        label: 'Engagement rate (by followers)',
        rows: { byReach: 'By reach', byImpressions: 'By impressions', total: 'Total engagements' },
        run: (x) => {
            const e = x.likes + x.comments + x.shares + x.saves;

            return { value: pct(e / x.followers, 4), sub: `${num(e)} engagements, ${num(x.followers)} followers`, rows: { byReach: x.reach > 0 ? pct(e / x.reach, 4) : 'Enter reach', byImpressions: x.impressions > 0 ? pct(e / x.impressions, 4) : 'Enter impressions', total: num(e) }, steps: ['Engagement rate = (likes + comments + shares + saves) ÷ base × 100', 'By followers compares accounts; by reach shows how people who saw it reacted', 'Platforms define engagements differently; compare like with like'] };
        },
    },
    us_flag: {
        type: 'calc',
        inputs: { hoist: LEN('Flag height (hoist)', 3, 'ft') },
        label: 'Flag length (fly)',
        rows: { union: 'Union (blue field) height × length', stripe: 'Each stripe', star: 'Star diameter', area: 'Flag area' },
        run: (x) => {
            const A = x.hoist;
            const f = (k) => (A * k >= 0.3 ? `${num((A * k) / 0.3048, 4)} ft (${num(A * k * 100, 4)} cm)` : `${num((A * k) / 0.0254, 4)} in (${num(A * k * 100, 4)} cm)`);

            return { value: f(1.9), sub: `for a ${f(1)} hoist`, rows: { union: `${f(7 / 13)} × ${f(0.76)}`, stripe: f(1 / 13), star: f(0.0616), area: `${num(A * A * 1.9, 4)} m²` }, steps: ['Executive Order 10834 (1959): hoist A = 1.0, fly B = 1.9, union hoist C = 7/13, union fly D = 0.76, star diameter K = 0.0616, stripe L = 1/13', 'Stars sit in 9 rows (6 and 5 alternating), 50 in all'] };
        },
    },
    gender_pay_gap: {
        type: 'calc',
        inputs: { men: MONEY('Average (or median) pay of men', 52000), women: MONEY('Average (or median) pay of women', 45000) },
        label: 'Gender pay gap',
        rows: { ratio: 'Women earn per 1 earned by men', days: 'Days in a year worked “unpaid”', equalPay: 'Equal Pay Day (this gap)' },
        run: (x) => {
            const gap = (x.men - x.women) / x.men;
            const days = Math.round(gap * 365);
            const d = G.addDays({ y: 2026, m: 12, d: 31 }, days);

            return { value: pct(gap, 4), sub: gap > 0 ? 'Women earn less' : gap < 0 ? 'Women earn more' : 'No gap', rows: { ratio: num(x.women / x.men, 4), days: num(Math.max(0, days)), equalPay: gap > 0 ? `${d.d} ${G.MONTHS[d.m - 1]} of the next year (women’s pay catches up with men’s for the previous year)` : '—' }, steps: ['Gap = (men’s pay − women’s pay) ÷ men’s pay (OECD and Eurostat convention)', 'An unadjusted gap compares all jobs; it is not the same as unequal pay for the same work'] };
        },
    },
    expert_fresher: {
        type: 'calc',
        inputs: { months: N('Period to compare (months)', 12, 1), expertSalary: MONEY('Expert: monthly cost (salary and benefits)', 9000), expertRamp: N('Expert: months to full productivity', 1, 0), fresherSalary: MONEY('Fresher: monthly cost', 4000), fresherRamp: N('Fresher: months to full productivity', 6, 0), fresherFull: N('Fresher at full speed (% of an expert)', 70, 1), training: MONEY('Training cost for the fresher (one-off)', 5000), mentoring: N('Mentor time for the fresher (% of an expert, during ramp-up)', 15, 0) },
        label: 'Cost per unit of expert output',
        rows: { expertCost: 'Expert: cost and output', fresherCost: 'Fresher: cost and output', verdict: 'Cheaper per unit of work' },
        run: (x) => {
            const out = (ramp, full) => {
                let o = 0;

                for (let m = 1; m <= x.months; m += 1) {
                    o += m <= ramp && ramp > 0 ? (full * (m - 0.5)) / ramp : full;
                }

                return o;
            };
            const eOut = out(x.expertRamp, 1);
            const fOut = out(x.fresherRamp, x.fresherFull / 100);
            const eCost = x.expertSalary * x.months;
            const fCost = x.fresherSalary * x.months + x.training + x.expertSalary * (x.mentoring / 100) * Math.min(x.months, x.fresherRamp);

            return { value: `${formatMoney(eCost / eOut)} vs ${formatMoney(fCost / fOut)}`, sub: 'expert vs fresher, per expert-month of output', rows: { expertCost: `${formatMoney(eCost)} for ${num(eOut, 4)} expert-months`, fresherCost: `${formatMoney(fCost)} for ${num(fOut, 4)} expert-months`, verdict: eCost / eOut < fCost / fOut ? 'The expert' : 'The fresher' }, steps: ['Output ramps up linearly to full productivity over the ramp-up months', 'Fresher cost adds training and the mentor’s time during ramp-up', 'A model with your assumptions: quality, retention and growth are not included'] };
        },
    },
    matched_betting: {
        type: 'calc',
        inputs: { type: SEL('Bet', { qualifying: 'Qualifying bet (your own money)', snr: 'Free bet, stake not returned', sr: 'Free bet, stake returned' }, 'qualifying'), stake: MONEY('Back stake', 20), back: N('Back odds (decimal)', 3.0, 1), lay: N('Lay odds (decimal)', 3.1, 1), commission: N('Exchange commission (%)', 2, 0) },
        label: 'Lay stake',
        rows: { liability: 'Liability (needed in the exchange)', ifBack: 'Profit if the back bet wins', ifLay: 'Profit if the lay bet wins', retention: 'Free-bet value kept' },
        run: (x) => {
            const c = x.commission / 100;
            const ret = x.type === 'snr' ? x.stake * (x.back - 1) : x.stake * x.back;
            const lay = ret / (x.lay - c);
            const liability = lay * (x.lay - 1);
            const ifBack = x.type === 'qualifying' ? x.stake * (x.back - 1) - liability : ret - (x.type === 'sr' ? x.stake : 0) - liability;
            const ifLay = lay * (1 - c) - (x.type === 'qualifying' ? x.stake : 0);

            return { value: formatMoney(lay), sub: `lay at ${num(x.lay)} with ${num(x.commission)}% commission`, rows: { liability: formatMoney(liability), ifBack: formatMoney(ifBack), ifLay: formatMoney(ifLay), retention: x.type === 'qualifying' ? 'Free bets only' : pct(Math.min(ifBack, ifLay) / x.stake, 4) }, steps: ['Lay stake = back return ÷ (lay odds − commission), where the back return is stake × odds (qualifying, stake returned) or stake × (odds − 1) (free bet, stake not returned)', 'The two outcomes then give (almost) the same result', 'Gambling has risks; bookmakers may restrict accounts that match bet'] };
        },
    },
    nanowrimo: {
        type: 'calc',
        inputs: { words: N('Words written so far', 18000, 0), goal: N('Goal (words)', 50000, 1), date: DATE('Today’s date', '2026-11-12'), end: DATE('Deadline', '2026-11-30') },
        label: 'Words per day needed',
        rows: { left: 'Words left', days: 'Days left (including today)', pace: 'Your pace so far (from 1 November)', finish: 'Finish date at your pace' },
        run: (x) => {
            const t = readDate(x.date);
            const e = readDate(x.end);

            if (!t || !e) {
                return { error: 'Enter today’s date and the deadline.' };
            }

            const daysLeft = G.jdn(e.y, e.m, e.d) - G.jdn(t.y, t.m, t.d) + 1;
            const left = Math.max(0, x.goal - x.words);
            const elapsed = G.jdn(t.y, t.m, t.d) - G.jdn(t.y, 11, 1);
            const pace = elapsed > 0 ? x.words / elapsed : NaN;

            if (daysLeft <= 0) {
                return { error: 'The deadline has passed.' };
            }

            return { value: left ? num(Math.ceil(left / daysLeft)) : 'Done!', sub: `${num(left)} words in ${daysLeft} days`, rows: { left: num(left), days: num(daysLeft), pace: Number.isFinite(pace) && pace > 0 ? `${num(pace, 4)} words a day` : '—', finish: Number.isFinite(pace) && pace > 0 ? G.dateText(G.addDays(t, Math.ceil(left / pace))) : '—' }, steps: ['Words per day = words left ÷ days left', 'The classic November challenge is 50,000 words (1,667 a day); the NaNoWriMo organisation closed in 2025, but writers still run the challenge'] };
        },
    },
    oxygen: {
        type: 'calc',
        inputs: { cylinder: SEL('Cylinder', 'data:oxygen:fixed', 'e'), psi: N('Gauge pressure (psi)', 2000, 0), flow: N('Flow rate (L/min)', 2, 0), residual: N('Safe residual pressure (psi)', 200, 0) },
        data: ['oxygen'],
        label: 'Time until the safe residual',
        rows: { empty: 'Time until empty', litres: 'Oxygen above the residual', factor: 'Cylinder factor' },
        run: (x, ctx) => {
            const c = ctx.c.data.other?.oxygen?.[x.cylinder];

            if (!c || !(x.flow > 0)) {
                return { error: 'Choose a cylinder and a flow above zero.' };
            }

            const usable = Math.max(0, x.psi - x.residual) * c.factor;

            return { value: duration((usable / x.flow) * 60), sub: `${c.name} at ${num(x.flow)} L/min`, rows: { empty: duration(((x.psi * c.factor) / x.flow) * 60), litres: `${num(usable, 5)} L`, factor: `${c.factor} L/psi` }, steps: ['Duration (min) = (gauge psi − safe residual) × cylinder factor ÷ flow (L/min)', 'Factors: D 0.16, E 0.28, M 1.56, G 2.41, H/K 3.14 L/psi (clinical references)', 'A planning estimate: change the cylinder before it reaches the residual'] };
        },
    },
    pay_gap: {
        type: 'calc',
        inputs: { higher: MONEY('Higher-paid group’s average pay', 60000), lower: MONEY('Lower-paid group’s average pay', 48000) },
        label: 'Pay gap',
        rows: { amount: 'Difference per year', ratio: 'Lower ÷ higher', raise: 'Raise needed to close it' },
        run: (x) => ({ value: pct((x.higher - x.lower) / x.higher, 4), sub: 'of the higher pay', rows: { amount: formatMoney(x.higher - x.lower), ratio: num(x.lower / x.higher, 4), raise: pct((x.higher - x.lower) / x.lower, 4) }, steps: ['Gap = (higher − lower) ÷ higher', 'Closing it needs a raise of (higher − lower) ÷ lower, a larger percentage'] }),
    },
    pert: {
        type: 'calc',
        inputs: { tasks: TXT('Tasks on the critical path: name, optimistic, most likely, pessimistic (days)', 'Design, 3, 5, 10\nBuild, 8, 12, 20\nTest, 2, 4, 9\nLaunch, 1, 2, 4'), deadline: N('Deadline (days, optional)', 28, 0) },
        optional: ['deadline'],
        label: 'Expected duration',
        rows: { sd: 'Standard deviation', chance: 'Chance to finish by the deadline', p90: '90% confidence date' },
        grids: [['table', 'Each task']],
        run: (x) => {
            const rows = String(x.tasks ?? '').split(/\r?\n/).map((l) => l.trim()).filter(Boolean).map((l) => {
                const p = l.split(/\s*[,;\t]\s*/);
                const nums = p.slice(-3).map(Number);

                return p.length >= 3 && nums.every(Number.isFinite) && nums[0] <= nums[1] && nums[1] <= nums[2] ? { name: p.length > 3 ? p.slice(0, -3).join(', ') : 'Task', o: nums[0], m: nums[1], pe: nums[2] } : null;
            });

            if (!rows.length || rows.some((r) => !r)) {
                return { error: 'Each line needs optimistic ≤ most likely ≤ pessimistic times.' };
            }

            const e = rows.map((r) => (r.o + 4 * r.m + r.pe) / 6);
            const v = rows.map((r) => ((r.pe - r.o) / 6) ** 2);
            const E = sum(e);
            const S = Math.sqrt(sum(v));
            const z = (x.deadline - E) / S;
            const chance = normCdf(z);

            return { value: `${num(E, 4)} days`, sub: `± ${num(S, 3)} (1 SD)`, rows: { sd: num(S, 4), chance: Number.isFinite(z) ? pct(chance, 3) : 'Enter a deadline', p90: `${num(E + 1.2816 * S, 4)} days` }, steps: ['Each task: expected = (O + 4M + P) ÷ 6, SD = (P − O) ÷ 6', 'Path: add the expected times and the variances (tasks assumed independent)', 'The chance uses a normal approximation'], grids: { table: { columns: ['Expected', 'SD'], rows: rows.map((r, i) => ({ header: r.name, cells: [num(e[i], 4), num(Math.sqrt(v[i]), 4)] })) } } };
        },
    },
    rpm_rounds: {
        type: 'calc',
        inputs: { rounds: N('Rounds fired', 30, 1), seconds: N('In seconds', 3, 0) },
        label: 'Rate of fire',
        rows: { rps: 'Rounds per second', gap: 'Time between rounds' },
        run: (x) => ({ value: `${num((x.rounds / x.seconds) * 60, 5)} rounds/min`, sub: `${num(x.rounds)} rounds in ${num(x.seconds)} s`, rows: { rps: num(x.rounds / x.seconds, 5), gap: `${num((x.seconds / x.rounds) * 1000, 4)} ms` }, steps: ['Rate = rounds ÷ time × 60', 'Count from the first to the last shot: n shots span n − 1 intervals, so short bursts read a little low'] }),
    },
    salt_dough: {
        type: 'calc',
        inputs: { flour: N('Flour (cups)', 2, 0), unit: SEL('Measure in', { cups: 'US cups', grams: 'Grams' }, 'cups') },
        label: 'Recipe',
        rows: { salt: 'Salt', water: 'Water', bake: 'Baking' },
        run: (x) => {
            const g = x.unit === 'grams';

            return { value: g ? `${num(x.flour * 125)} g flour` : `${num(x.flour)} cups flour`, sub: '2 : 1 : 1 flour, salt, water by volume', rows: { salt: g ? `${num(x.flour * 0.5 * 273)} g` : `${num(x.flour / 2)} cups`, water: g ? `${num(x.flour * 0.5 * 237)} ml` : `${num(x.flour / 2)} cups (add slowly)`, bake: 'Low oven, about 120 °C (250 °F), 1–3 hours depending on thickness' }, steps: ['A common salt-dough recipe: 2 parts flour, 1 part salt, about 1 part water by volume', 'Gram amounts use 1 cup flour ≈ 125 g and 1 cup table salt ≈ 273 g', 'Not edible: keep away from pets (salt poisoning)'] };
        },
    },
    sandbox: {
        type: 'calc',
        inputs: { shape: SEL('Shape', { rect: 'Rectangle', round: 'Circle', hex: 'Hexagon' }, 'rect'), length: LEN('Length (or diameter, or side for a hexagon)', 1.5, 'm'), width: LEN('Width (rectangle)', 1.5, 'm'), depth: LEN('Sand depth', 25, 'cm'), bag: MASS('Bag size', 25, 'kg') },
        show: { width: 'shape:rect' },
        label: 'Sand needed',
        rows: { weight: 'Weight (dry play sand ≈ 1,600 kg/m³)', bags: 'Bags', area: 'Area' },
        run: (x) => {
            const area = x.shape === 'rect' ? x.length * x.width : x.shape === 'round' ? (Math.PI * x.length * x.length) / 4 : ((3 * Math.sqrt(3)) / 2) * x.length * x.length;
            const vol = area * x.depth;
            const kg = vol * 1600;

            return { value: `${num(vol, 4)} m³`, sub: `${num(vol * 1000, 4)} litres`, rows: { weight: `${num(kg, 5)} kg`, bags: num(Math.ceil(kg / x.bag - 1e-9)), area: `${num(area, 4)} m²` }, steps: ['Volume = area × depth; weight = volume × bulk density (dry sand about 1,600 kg/m³)', 'Add about 10% for settling'] };
        },
    },
    royalties: {
        type: 'calc',
        inputs: { spotify: N('Spotify streams', 100000, 0), apple: N('Apple Music streams', 20000, 0), youtube: N('YouTube streams', 50000, 0), amazon: N('Amazon Music streams', 10000, 0), share: N('Your share after label or distributor (%)', 85, 0) },
        data: ['royalties'],
        label: 'Estimated payout',
        rows: { gross: 'Before your label or distributor', perStream: 'Average per stream', breakdown: 'By platform' },
        run: (x, ctx) => {
            const r = ctx.c.data.other?.royalties ?? {};
            const keys = ['spotify', 'apple', 'youtube', 'amazon'];
            const parts = keys.map((k) => x[k] * (r[k]?.rate ?? 0));
            const gross = sum(parts);
            const streams = sum(keys.map((k) => x[k]));

            return { value: formatMoney((gross * x.share) / 100), sub: `${num(streams)} streams`, rows: { gross: formatMoney(gross), perStream: streams ? `$${num(gross / streams, 3)}` : '—', breakdown: keys.map((k, i) => `${r[k]?.name ?? k} ${formatMoney(parts[i])}`).join(', ') }, steps: ['Average payouts per stream (USD): Amazon 0.0088, Apple 0.0062, YouTube 0.0048, Spotify 0.0030 (Duetti 2024 report)', 'Platforms pay a share of revenue, not a fixed rate: country, subscription type and deals change it', 'Songwriting (publishing) royalties are paid separately'] };
        },
    },
    travel: {
        type: 'calc',
        inputs: { travellers: N('Travellers', 2, 1), days: N('Days', 5, 1), by: SEL('Getting there', { fare: 'Fares (total)', drive: 'Driving' }, 'drive'), fares: MONEY('Fares for everyone', 600), distance: LEN('Round-trip distance', 900, 'km'), economy: N('Fuel use (L/100 km)', 7, 0), fuel: MONEY('Fuel price per litre', 1.6), lodging: MONEY('Lodging per night', 120), food: MONEY('Food per person per day', 45), activities: MONEY('Activities and extras (total)', 200) },
        show: { fares: 'by:fare', distance: 'by:drive', economy: 'by:drive', fuel: 'by:drive' },
        when: { fares: (x) => x.by === 'fare', distance: (x) => x.by === 'drive', economy: (x) => x.by === 'drive', fuel: (x) => x.by === 'drive' },
        label: 'Trip cost',
        rows: { perPerson: 'Per person', perDay: 'Per day', breakdown: 'Transport, lodging, food, activities' },
        run: (x) => {
            const transport = x.by === 'fare' ? x.fares : (x.distance / 1000) * (x.economy / 100) * x.fuel;
            const lodging = x.lodging * Math.max(0, x.days - 1);
            const food = x.food * x.travellers * x.days;
            const total = transport + lodging + food + x.activities;

            return { value: formatMoney(total), sub: `${x.travellers} travellers, ${x.days} days`, rows: { perPerson: formatMoney(total / x.travellers), perDay: formatMoney(total / x.days), breakdown: [transport, lodging, food, x.activities].map(formatMoney).join(', ') }, steps: ['Driving cost = distance × fuel use ÷ 100 × fuel price', 'Lodging is per night (days − 1)', 'Add a buffer of 10–15% for the unexpected'] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
