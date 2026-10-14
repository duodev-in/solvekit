/**
 * Real power from RMS values. Methods: V & R (P = V²/R), I & R (P = I²R), V & I with power factor
 * (P = V·I·PF). The remaining quantities follow from Ohm's law and S = V·I.
 */
export function solve(method, { voltage, current, resistance, powerFactor = 1 }) {
    if (method === 'vr') {
        const i = voltage / resistance;

        return { voltage, current: i, resistance, power: voltage * i, apparent: voltage * i, powerFactor: 1 };
    }

    if (method === 'ir') {
        const v = current * resistance;

        return { voltage: v, current, resistance, power: v * current, apparent: v * current, powerFactor: 1 };
    }

    const apparent = voltage * current;

    return { voltage, current, resistance: voltage / current, power: apparent * powerFactor, apparent, powerFactor };
}

/**
 * Reactive power, guarded so rounding can never take the square root of a tiny negative number.
 */
export function reactivePower(apparent, real) {
    return Math.sqrt(Math.max(0, apparent ** 2 - real ** 2));
}

const NEEDS = { vr: ['voltage', 'resistance'], ir: ['current', 'resistance'], vi: ['voltage', 'current', 'pf'] };

export default function rmsToWatts(ctx) {
    ctx.onUpdate(() => {
        const method = ctx.choice('method');
        const inputs = Object.fromEntries(NEEDS[method].map((name) => [name, ctx.number(name)]));

        if (Object.values(inputs).some(Number.isNaN)) {
            ctx.clearResult('Fill in every field for this method.');

            return;
        }

        if (Object.values(inputs).some((value) => value <= 0)) {
            ctx.showError('Values must be greater than 0.');

            return;
        }

        if (method === 'vi' && inputs.pf > 1) {
            ctx.showError('Power factor must be between 0 and 1.');

            return;
        }

        const result = solve(method, { ...inputs, powerFactor: inputs.pf });

        ctx.showResult({ value: ctx.format(result.power), unit: 'W', sub: `${ctx.format(result.voltage)} V rms × ${ctx.format(result.current)} A rms × PF ${ctx.format(result.powerFactor)}` });
        ctx.setRow('kw', ctx.format(result.power / 1000));
        ctx.setRow('hp', ctx.format(result.power / 745.6998715822702));
        ctx.setRow('v', ctx.format(result.voltage));
        ctx.setRow('a', ctx.format(result.current));
        ctx.setRow('ohm', ctx.format(result.resistance));
        ctx.setRow('va', ctx.format(result.apparent));
        ctx.setRow('var', ctx.format(reactivePower(result.apparent, result.power)));
        ctx.setRow('kwh', ctx.format((result.power * 24) / 1000));
    });
}
