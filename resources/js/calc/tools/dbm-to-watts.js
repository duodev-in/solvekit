/**
 * Power levels: dBm, dBW, dBu and dBV ↔ watts. Voltage levels need the load impedance:
 * P = V² ÷ R. dBu is referenced to 0.7746 V (1 mW into 600 Ω); dBV to 1 V.
 */
export const DBU_REFERENCE_V = Math.sqrt(0.6);

export function toWatts(value, unit, ohms) {
    switch (unit) {
        case 'dbm': return 10 ** ((value - 30) / 10);
        case 'dbw': return 10 ** (value / 10);
        case 'dbu': return (DBU_REFERENCE_V * 10 ** (value / 20)) ** 2 / ohms;
        case 'dbv': return (10 ** (value / 20)) ** 2 / ohms;
        case 'w': return value;
        case 'mw': return value / 1e3;
        case 'uw': return value / 1e6;
        default: return Number.NaN;
    }
}

export function levels(watts, ohms) {
    const voltage = Math.sqrt(watts * ohms);

    return {
        dbm: 10 * Math.log10(watts) + 30,
        dbw: 10 * Math.log10(watts),
        dbu: 20 * Math.log10(voltage / DBU_REFERENCE_V),
        dbv: 20 * Math.log10(voltage),
        w: watts,
        mw: watts * 1e3,
        uw: watts * 1e6,
        v: voltage,
        a: voltage / ohms,
    };
}

const LOGARITHMIC = ['dbm', 'dbw', 'dbu', 'dbv'];

export default function dbmToWatts(ctx) {
    ctx.onUpdate(() => {
        const value = ctx.number('value');
        const unit = ctx.field('unit').value;
        const ohms = ctx.number('impedance');

        if (Number.isNaN(value)) {
            ctx.clearResult();

            return;
        }

        if (!(ohms > 0)) {
            ctx.showError('Impedance must be greater than 0 Ω.');

            return;
        }

        if (!LOGARITHMIC.includes(unit) && value <= 0) {
            ctx.showError('Power must be greater than 0 to express it in decibels.');

            return;
        }

        const watts = toWatts(value, unit, ohms);
        const all = levels(watts, ohms);

        ctx.showResult(LOGARITHMIC.includes(unit)
            ? { value: ctx.format(watts), unit: 'W', label: 'Watts', sub: `${ctx.format(all.mw)} mW` }
            : { value: ctx.format(all.dbm), unit: 'dBm', label: 'dBm', sub: `${ctx.format(all.dbw)} dBW` });

        Object.entries(all).forEach(([key, amount]) => ctx.setRow(key, ctx.format(amount)));
    });
}
