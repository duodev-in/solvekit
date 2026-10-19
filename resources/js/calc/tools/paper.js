import { formatMoney } from '../currency.js';
/**
 * Paper quantities: sheets, quires, reams and cases, with weight from paper size and grammage
 * (GSM = grams per square meter) and optional cost per ream.
 * Config: units (factor = sheets), sizes { key: { name, area (m²) } }.
 */
export const MICRONS_PER_GSM = 1.25;

export function sheetWeightGrams(gsm, area) {
    return gsm * area;
}

export default function paper(ctx, config) {
    const { units, sizes } = config;

    ctx.onUpdate(() => {
        const quantity = ctx.number('quantity');
        const unit = units[ctx.field('unit').value];
        const size = sizes[ctx.field('size').value];
        const gsm = ctx.number('gsm');
        const price = ctx.number('price');

        if (Number.isNaN(quantity) || Number.isNaN(gsm)) {
            ctx.clearResult('Enter the quantity and the paper weight (GSM).');

            return;
        }

        if (quantity < 0 || gsm <= 0) {
            ctx.showError('Quantity cannot be negative and GSM must be greater than 0.');

            return;
        }

        const sheets = quantity * unit.factor;
        const kilograms = (sheets * sheetWeightGrams(gsm, size.area)) / 1000;

        ctx.showResult({ value: ctx.format(sheets), unit: 'sheets', label: 'Sheets', sub: `${ctx.format(quantity)} ${unit.name.toLowerCase()} of ${size.name}` });
        ctx.setRow('reams', ctx.format(sheets / 500));
        ctx.setRow('cases', ctx.format(sheets / 5000));
        ctx.setRow('kg', ctx.format(kilograms));
        ctx.setRow('lb', ctx.format(kilograms / 0.45359237));
        ctx.setRow('height', ctx.format((sheets * gsm * MICRONS_PER_GSM) / 10000));
        ctx.setRow('cost', price > 0 ? formatMoney((sheets / 500) * price) : 'Enter a price per ream');
        ctx.setRow('per_sheet', price > 0 ? formatMoney(price / 500, { decimals: 4 }) : 'Enter a price per ream');
    });
}
