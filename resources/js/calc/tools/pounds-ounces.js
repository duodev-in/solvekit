const POUND_G = 453.59237;
const OUNCE_G = POUND_G / 16;

export function poundsOuncesToGrams(pounds, ounces) {
    return pounds * POUND_G + ounces * OUNCE_G;
}

export function gramsToStone(grams) {
    const totalPounds = grams / POUND_G;
    const stone = Math.floor(totalPounds / 14);

    return { stone, pounds: totalPounds - stone * 14 };
}

export default function poundsOunces(ctx) {
    ctx.onUpdate(() => {
        const pounds = ctx.number('pounds');
        const ounces = ctx.number('ounces');

        if (Number.isNaN(pounds) && Number.isNaN(ounces)) {
            ctx.clearResult('Enter pounds, ounces or both.');

            return;
        }

        const lb = Number.isNaN(pounds) ? 0 : pounds;
        const oz = Number.isNaN(ounces) ? 0 : ounces;

        if (lb < 0 || oz < 0) {
            ctx.showError('Pounds and ounces cannot be negative.');

            return;
        }

        const grams = poundsOuncesToGrams(lb, oz);
        const totalOunces = grams / OUNCE_G;
        const wholePounds = Math.floor(totalOunces / 16);
        const { stone, pounds: stonePounds } = gramsToStone(grams);

        ctx.showResult({
            value: ctx.format(grams / 1000),
            unit: 'kg',
            label: 'Kilograms',
            sub: `${wholePounds} lb ${ctx.format(totalOunces - wholePounds * 16)} oz = ${ctx.format(grams)} g`,
        });

        ctx.setRow('g', ctx.format(grams));
        ctx.setRow('oz', ctx.format(totalOunces));
        ctx.setRow('lb', ctx.format(grams / POUND_G));
        ctx.setRow('st', `${stone} st ${ctx.format(stonePounds)} lb`);
        ctx.setRow('t', ctx.format(grams / 1e6));

        ctx.renderSteps('steps', [
            `${ctx.format(lb)} lb × 16 + ${ctx.format(oz)} oz = ${ctx.format(totalOunces)} oz`,
            `${ctx.format(totalOunces)} oz × 28.349523125 = ${ctx.format(grams)} g`,
        ]);
    });
}
