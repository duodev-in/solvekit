import { FT } from '../construction/geometry.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Electrical: box fill, pull boxes, voltage drop, wire size and conduit fill from the NEC tables in
 * config('construction_data'). Lengths arrive in meters.
 */
const SIZES = ['14', '12', '10', '8', '6', '4', '3', '2', '1', '1/0', '2/0', '3/0', '4/0', '250', '300', '350', '400', '500', '600', '750', '1000'];

/**
 * 240.4(D) small-conductor overcurrent limits (A).
 */
const SMALL = { cu: { 14: 15, 12: 20, 10: 30 }, al: { 12: 15, 10: 25 } };

/**
 * Voltage drop (V) for a one-way length (m) and current, from the Table 8 DC resistance at 75 °C.
 */
export function voltageDrop(wire, material, lengthM, amps, phase) {
    const ohmsPerFt = (material === 'al' ? wire.r_al : wire.r_cu) / 1000;
    const factor = phase === 'three' ? Math.sqrt(3) : 2;

    return factor * (lengthM / FT) * ohmsPerFt * amps;
}

const label = (data, size) => data.wires[size].label;

export const handlers = {
    /**
     * NEC 314.16(B): conductors count once, a device yoke twice the largest conductor on it, all clamps once,
     * each support fitting type once, and up to four equipment grounding conductors once (+¼ each beyond four).
     */
    box_fill: (i, c, f) => {
        const allowance = c.data.box_fill.allowance;
        const counts = ['14', '12', '10', '8', '6'].map((size) => [size, i[`n${size}`] > 0 ? Math.round(i[`n${size}`]) : 0]).filter(([, n]) => n > 0);

        if (!counts.length) {
            return { empty: 'Enter the number of insulated conductors of each size.' };
        }

        const largest = counts[0][0];
        const big = allowance[largest];
        const lines = counts.map(([size, n]) => [`${n} × ${size} AWG conductors`, n * allowance[size]]);
        const devices = i.devices > 0 ? Math.round(i.devices) : 0;
        const grounds = i.grounds > 0 ? Math.round(i.grounds) : 0;
        const fittings = i.fittings > 0 ? Math.round(i.fittings) : 0;

        if (devices) {
            lines.push([`${devices} device yoke${devices > 1 ? 's' : ''} (2 each)`, devices * 2 * big]);
        }

        if (i.clamps === 'yes') {
            lines.push(['Internal cable clamps', big]);
        }

        if (fittings) {
            lines.push([`${fittings} support fitting type${fittings > 1 ? 's' : ''}`, fittings * big]);
        }

        if (grounds) {
            lines.push([`${grounds} equipment grounding conductor${grounds > 1 ? 's' : ''}`, (1 + Math.max(grounds - 4, 0) / 4) * big]);
        }

        const total = lines.reduce((sum, [, v]) => sum + v, 0);
        const boxes = Object.values(c.data.box_fill.boxes).filter(([, volume]) => volume >= total - 1e-9);
        const chosen = i.box !== 'none' ? c.data.box_fill.boxes[i.box] : null;

        return {
            value: f(total),
            unit: 'in³',
            label: 'Box volume required',
            sub: `${f(total * 16.387064)} cm³; allowances by the largest conductor, ${largest} AWG (${f(big)} in³)`,
            rows: {
                check: chosen ? (chosen[1] >= total - 1e-9 ? `${chosen[0]} (${f(chosen[1])} in³): fits` : `${chosen[0]} (${f(chosen[1])} in³): too small`) : 'Choose a box to check',
                smallest: boxes.length ? `${boxes.sort((a, b) => a[1] - b[1])[0][0]} (${f(boxes[0][1])} in³)` : 'Larger than every listed box: use a bigger box or extension ring',
                cm3: `${f(total * 16.387064)} cm³`,
            },
            lists: { lines: lines.map(([what, v]) => ({ label: what, value: `${f(v)} in³` })) },
        };
    },

    /**
     * NEC 314.28(A) pull and junction boxes (conductors 4 AWG and larger): straight pulls 8 × the largest raceway;
     * angle and U pulls 6 × the largest raceway plus the other raceways on the same wall and row.
     */
    pull_box: (i, c, f) => {
        if (missing(i, 'largest') || !(i.largest > 0)) {
            return { empty: 'Enter the trade size of the largest raceway.' };
        }

        const others = i.others > 0 ? i.others : 0;

        if (i.pull === 'straight') {
            const length = 8 * i.largest;

            return {
                value: f(length),
                unit: 'in',
                label: 'Minimum box length',
                sub: `8 × ${f(i.largest)} in raceway (NEC 314.28(A)(1))`,
                rows: { length: `${f(length)} in (${f(length * 25.4)} mm) between the walls the raceways enter`, rule: 'Straight pull: length ≥ 8 × largest raceway', spacing: 'The 6 × spacing rule applies to angle and U pulls', note: 'Applies to conductors 4 AWG and larger' },
            };
        }

        const distance = 6 * i.largest + others;

        return {
            value: f(distance),
            unit: 'in',
            label: 'Minimum distance to the opposite wall',
            sub: `6 × ${f(i.largest)} in + ${f(others)} in of other raceways (NEC 314.28(A)(2))`,
            rows: {
                length: `${f(distance)} in (${f(distance * 25.4)} mm)`,
                rule: `${i.pull === 'u' ? 'U' : 'Angle'} pull: 6 × largest + sum of the other raceways on that wall and row`,
                spacing: `${f(6 * i.largest)} in at least between raceway entries enclosing the same conductor (6 × the larger)`,
                note: 'Applies to conductors 4 AWG and larger',
            },
        };
    },

    voltage_drop: (i, c, f) => {
        if (missing(i, 'length', 'amps', 'volts') || !(i.length > 0) || !(i.amps > 0) || !(i.volts > 0)) {
            return { empty: 'Enter the one-way length, the current and the voltage.' };
        }

        const wire = c.data.wires[i.size];
        const vd = voltageDrop(wire, i.material, i.length, i.amps, i.phase);
        const percent = (vd / i.volts) * 100;
        const smallest = SIZES.find((size) => (voltageDrop(c.data.wires[size], i.material, i.length, i.amps, i.phase) / i.volts) * 100 <= 3 + 1e-9);

        return {
            value: f(vd),
            unit: 'V',
            label: 'Voltage drop',
            sub: `${f(percent)}% of ${f(i.volts)} V over ${f(i.length / FT)} ft (one way)`,
            rows: {
                percent: `${f(percent)}%`,
                at_load: `${f(i.volts - vd)} V at the load`,
                guide: percent <= 3 ? 'Within 3% (NEC 210.19(A) informational note for branch circuits)' : percent <= 5 ? 'Over 3% for a branch circuit; within 5% for feeder plus branch' : 'Over the 5% total in the NEC informational notes',
                smallest: smallest ? `${label(c.data, smallest)} keeps the drop at 3% or less` : 'Even 1000 kcmil exceeds 3%',
                resistance: `${f(i.material === 'al' ? wire.r_al : wire.r_cu)} Ω per 1000 ft at 75 °C (Chapter 9 Table 8)`,
            },
        };
    },

    wire_size: (i, c, f) => {
        if (missing(i, 'amps') || !(i.amps > 0)) {
            return { empty: 'Enter the load current.' };
        }

        const column = { 60: 0, 75: 1, 90: 2 }[i.temp] ?? 1;
        const required = i.continuous === 'yes' ? i.amps * 1.25 : i.amps;
        const material = i.material;
        const byAmpacity = SIZES.find((size) => {
            const wire = c.data.wires[size];
            const ampacity = material === 'al' ? wire.amp_al?.[column] : wire.amp_cu[column];
            const limit = SMALL[material][size];

            return ampacity && ampacity >= required - 1e-9 && (!limit || limit >= required - 1e-9);
        });

        if (!byAmpacity) {
            return { error: 'The load is beyond a single 1000 kcmil conductor; use parallel conductors.' };
        }

        let chosen = byAmpacity;
        const dropCheck = i.length > 0 && i.volts > 0;

        if (dropCheck) {
            const start = SIZES.indexOf(byAmpacity);
            chosen = SIZES.slice(start).find((size) => (voltageDrop(c.data.wires[size], material, i.length, i.amps, i.phase) / i.volts) * 100 <= (i.max_drop > 0 ? i.max_drop : 3) + 1e-9) ?? SIZES[SIZES.length - 1];
        }

        const wire = c.data.wires[chosen];
        const ampacity = material === 'al' ? wire.amp_al[column] : wire.amp_cu[column];
        const drop = dropCheck ? (voltageDrop(wire, material, i.length, i.amps, i.phase) / i.volts) * 100 : null;

        return {
            value: label(c.data, chosen),
            unit: material === 'al' ? 'aluminum' : 'copper',
            label: 'Wire size',
            sub: `${f(ampacity)} A at ${i.temp} °C (NEC Table 310.16)${chosen !== byAmpacity ? `; upsized from ${label(c.data, byAmpacity)} for voltage drop` : ''}`,
            rows: {
                required: `${f(required)} A${i.continuous === 'yes' ? ' (125% of a continuous load, 210.19(A)(1))' : ''}`,
                ampacity: `${f(ampacity)} A${SMALL[material][chosen] ? `, protected at ${SMALL[material][chosen]} A max (240.4(D))` : ''}`,
                by_ampacity: label(c.data, byAmpacity),
                drop: drop === null ? 'Enter length and voltage to check the drop' : `${f(drop)}% over ${f(i.length / FT)} ft`,
                note: 'Check terminal ratings (110.14(C)) and adjustment for more than three current-carrying conductors or hot locations',
            },
        };
    },

    conduit_fill: (i, c, f) => {
        const conduit = c.data.conduits[i.conduit];
        const groups = [1, 2, 3].map((k) => ({ size: i[`size${k}`], type: i[`type${k}`], count: i[`count${k}`] > 0 ? Math.round(i[`count${k}`]) : 0 })).filter((g) => g.count > 0);

        if (!groups.length) {
            return { empty: 'Enter at least one group of conductors.' };
        }

        const count = groups.reduce((sum, g) => sum + g.count, 0);
        const wireArea = groups.reduce((sum, g) => sum + g.count * c.data.wires[g.size].area[g.type], 0);
        const allowed = count === 1 ? 0.53 : count === 2 ? 0.31 : 0.4;
        const area = conduit.sizes[i.trade];
        const fill = wireArea / area;
        const fits = Object.entries(conduit.sizes).find(([, total]) => wireArea <= total * allowed + 1e-12);

        return {
            value: f(fill * 100),
            unit: '% fill',
            label: 'Conduit fill',
            sub: `${f(wireArea)} in² of conductors in ${f(area)} in² (${i.trade} in ${conduit.name}); ${f(allowed * 100)}% allowed for ${count} conductor${count > 1 ? 's' : ''}`,
            rows: {
                result: fill <= allowed + 1e-12 ? `Pass: ${f(fill * 100)}% ≤ ${f(allowed * 100)}%` : `Fail: ${f(fill * 100)}% > ${f(allowed * 100)}%`,
                smallest: fits ? `${fits[0]} in ${conduit.name}` : 'Larger than every size listed',
                wires: `${count} conductors, ${f(wireArea)} in² (${f(wireArea * 645.16)} mm²)`,
                allowed: `${f(area * allowed)} in² usable (Chapter 9 Table 1)`,
            },
            lists: { groups: groups.map((g) => ({ label: `${g.count} × ${label(c.data, g.size)} ${g.type.toUpperCase()}`, value: `${f(g.count * c.data.wires[g.size].area[g.type])} in²` })) },
        };
    },
};

export default defineTools(handlers);
