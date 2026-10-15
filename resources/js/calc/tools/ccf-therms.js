/**
 * CCF ↔ therms: therms = CCF × heating value (BTU/ft³) × 100 ÷ 100,000.
 */
export function thermsFromCcf(ccf, heatingValue) {
    return (ccf * 100 * heatingValue) / 100000;
}

export default function ccfTherms(ctx, config) {
    const { quickRef } = config;

    ctx.onUpdate(() => {
        const toTherms = ctx.choice('direction') === 'ccf';
        const value = ctx.number('value');
        const heatingValue = ctx.number('heating');
        const price = ctx.number('price');

        ctx.setText('value-suffix', toTherms ? 'CCF' : 'thm');

        if (Number.isNaN(value) || Number.isNaN(heatingValue)) {
            ctx.clearResult();

            return;
        }

        if (value < 0 || heatingValue <= 0) {
            ctx.showError('The amount cannot be negative and the heating value must be greater than 0.');

            return;
        }

        const therms = toTherms ? thermsFromCcf(value, heatingValue) : value;
        const ccf = toTherms ? value : (value * 100000) / (100 * heatingValue);

        ctx.showResult(toTherms
            ? { value: ctx.format(therms), unit: 'thm', label: 'Therms', sub: `${ctx.format(value)} CCF × ${ctx.format(heatingValue)} BTU/ft³ ÷ 1,000` }
            : { value: ctx.format(ccf), unit: 'CCF', label: 'Hundred cubic feet', sub: `${ctx.format(value)} thm × 1,000 ÷ ${ctx.format(heatingValue)} BTU/ft³` });

        ctx.setRow('ft3', ctx.format(ccf * 100));
        ctx.setRow('m3', ctx.format(ccf * 2.8316846592));
        ctx.setRow('btu', ctx.format(therms * 100000));
        ctx.setRow('kwh', ctx.format((therms * 100000 * 1055.05585262) / 3.6e6));
        ctx.setRow('cost', price > 0 ? new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(therms * price) : 'Enter a price per therm');
        ctx.renderRows('quick-ref', quickRef.map((amount) => ({ label: `${amount} CCF`, value: `${ctx.format(thermsFromCcf(amount, heatingValue))} thm` })));
    });
}
