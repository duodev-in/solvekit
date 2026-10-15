/**
 * CSS length units. px is the base; em and rem use the base font size (the calculator assumes the
 * parent's size equals the root's, which is true unless an ancestor changes font-size).
 */
export const PX_REFERENCE = [8, 12, 14, 16, 20, 24, 32, 48];

export function toPx(value, unit, base) {
    return { px: value, em: value * base, rem: value * base, percent: (value / 100) * base, pt: value / 0.75, pc: value * 16, in: value * 96, cm: (value * 96) / 2.54, mm: (value * 96) / 25.4 }[unit];
}

export function fromPx(px, unit, base) {
    return { px, em: px / base, rem: px / base, percent: (px / base) * 100, pt: px * 0.75, pc: px / 16, in: px / 96, cm: (px * 2.54) / 96, mm: (px * 25.4) / 96 }[unit];
}

const SYMBOL = { px: 'px', em: 'em', rem: 'rem', percent: '%', pt: 'pt', pc: 'pc', in: 'in', cm: 'cm', mm: 'mm' };

export default function cssUnits(ctx) {
    ctx.root.querySelector('[data-calc-swap]')?.addEventListener('click', () => {
        const from = ctx.field('from');
        const to = ctx.field('to');
        [from.value, to.value] = [to.value, from.value];
        ctx.update();
    });

    ctx.onUpdate(() => {
        const value = ctx.number('value');
        const base = ctx.number('base');
        const from = ctx.field('from').value;
        const to = ctx.field('to').value;

        ctx.renderRows('quick-ref', PX_REFERENCE.map((px) => ({ label: `${px}px`, value: `${ctx.format(px / (base > 0 ? base : 16))}rem` })));
        ctx.setText('quick-ref-heading', `px to rem at ${ctx.format(base > 0 ? base : 16)}px`);

        if (Number.isNaN(value) || Number.isNaN(base)) {
            ctx.clearResult('Enter a value and the base font size.');

            return;
        }

        if (base <= 0) {
            ctx.showError('The base font size must be greater than 0.');

            return;
        }

        const px = toPx(value, from, base);
        const result = fromPx(px, to, base);

        ctx.showResult({ value: ctx.format(result), unit: SYMBOL[to], label: `In ${SYMBOL[to]}`, sub: `${ctx.format(value)}${SYMBOL[from]} = ${ctx.format(px)}px at a ${ctx.format(base)}px base` });
        Object.keys(SYMBOL).forEach((unit) => ctx.setRow(unit, ctx.format(fromPx(px, unit, base))));
    });
}
