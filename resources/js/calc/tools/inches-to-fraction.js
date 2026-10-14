export const DENOMINATORS = [2, 4, 8, 16, 32, 64];

function gcd(a, b) {
    return b === 0 ? a : gcd(b, a % b);
}

/**
 * Rounds a decimal to the nearest fraction with the given power-of-two denominator, the way a
 * tape measure reads. Returns the reduced parts and the rounding error (fraction − input).
 */
export function toFraction(decimal, denominator) {
    const sign = decimal < 0 ? -1 : 1;
    const steps = Math.round(Math.abs(decimal) * denominator);
    const whole = Math.floor(steps / denominator);
    const remainder = steps % denominator;
    const divisor = remainder === 0 ? 1 : gcd(remainder, denominator);

    return {
        sign,
        whole,
        numerator: remainder / divisor,
        denominator: denominator / divisor,
        error: sign * (steps / denominator) - decimal,
    };
}

export function formatFraction({ sign, whole, numerator, denominator }) {
    const parts = [];

    if (whole > 0 || numerator === 0) {
        parts.push(String(whole));
    }

    if (numerator > 0) {
        parts.push(`${numerator}/${denominator}`);
    }

    return `${sign < 0 && (whole > 0 || numerator > 0) ? '−' : ''}${parts.join(' ')}″`;
}

export default function inchesToFraction(ctx) {
    ctx.onUpdate(() => {
        const decimal = ctx.number('value');
        const precision = Number(ctx.choice('precision'));

        if (Number.isNaN(decimal)) {
            ctx.clearResult();

            return;
        }

        const fraction = toFraction(decimal, precision);
        const error = fraction.error;

        ctx.showResult({
            value: formatFraction(fraction),
            unit: '',
            sub: error === 0 ? `Exact at 1/${precision}″` : `Off by ${ctx.format(Math.abs(error))}″ (${error > 0 ? 'rounded up' : 'rounded down'})`,
        });

        DENOMINATORS.forEach((denominator) => {
            const option = toFraction(decimal, denominator);
            ctx.setRow(`d${denominator}`, `${formatFraction(option)}${option.error === 0 ? '' : ` (${option.error > 0 ? '+' : '−'}${ctx.format(Math.abs(option.error))})`}`);
        });

        ctx.setRow('mm', ctx.format(decimal * 25.4));
        ctx.setRow('cm', ctx.format(decimal * 2.54));
    });
}
