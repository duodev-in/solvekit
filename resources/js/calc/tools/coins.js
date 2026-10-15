/**
 * Face and melt value of US coins. Config: coin { face, types: { key: { name, mass, metals } } }.
 * Metal prices: silver per troy ounce, base metals per pound.
 */
export const TROY_OUNCE_G = 31.1034768;
export const POUND_G = 453.59237;

export function meltValue(type, prices) {
    return Object.entries(type.metals).reduce((total, [metal, fraction]) => {
        const grams = type.mass * fraction;

        if (metal === 'silver') {
            return total + (grams / TROY_OUNCE_G) * prices.silver;
        }

        return total + (grams / POUND_G) * (prices[metal] ?? 0);
    }, 0);
}

const money = (value) => new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: value !== 0 && Math.abs(value) < 0.1 ? 4 : 2 }).format(value);

export default function coins(ctx, config) {
    const { coin, coinName } = config;

    ctx.onUpdate(() => {
        const count = ctx.number('count');
        const type = coin.types[ctx.field('type').value];
        const melt = ctx.choice('method') === 'melt';
        const prices = { silver: ctx.number('silver'), copper: ctx.number('copper'), nickel: ctx.number('nickel'), zinc: ctx.number('zinc') };

        if (Number.isNaN(count)) {
            ctx.clearResult(`Enter how many ${coinName} you have.`);

            return;
        }

        if (count < 0 || !Number.isInteger(count)) {
            ctx.showError('Enter a whole number of coins.');

            return;
        }

        const face = count * coin.face;
        const perCoinMelt = meltValue(type, Object.fromEntries(Object.entries(prices).map(([metal, price]) => [metal, Number.isNaN(price) ? 0 : price])));
        const totalMelt = count * perCoinMelt;
        const silverOunces = (count * type.mass * (type.metals.silver ?? 0)) / TROY_OUNCE_G;

        ctx.showResult(melt
            ? { value: money(totalMelt), unit: '', label: 'Melt value', sub: `Face value ${money(face)} · metal is worth ${ctx.format(perCoinMelt / coin.face * 100)}% of face` }
            : { value: money(face), unit: '', label: 'Face value', sub: `${ctx.format(count)} × ${money(coin.face)}` });

        ctx.setRow('face', money(face));
        ctx.setRow('melt', money(totalMelt));
        ctx.setRow('per_coin', money(perCoinMelt));
        ctx.setRow('weight', `${ctx.format((count * type.mass) / 1000)} kg (${ctx.format((count * type.mass) / POUND_G)} lb)`);
        ctx.setRow('silver', `${ctx.format(silverOunces)} troy oz`);
        ctx.setRow('composition', Object.entries(type.metals).map(([metal, fraction]) => `${ctx.format(fraction * 100)}% ${metal}`).join(', '));
        ctx.setRow('quarters', ctx.format(Math.floor(face / 0.25)));
        ctx.setRow('dollars', ctx.format(Math.floor(face)));
    });
}
