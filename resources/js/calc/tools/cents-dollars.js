/**
 * Cents ↔ main currency units, with amounts written in words. Config: currencies
 * { key: { symbol, major, minor, minorPlural } } (100 minor units per major unit).
 */
const SMALL = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
const TENS = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
const SCALES = [[1e12, 'trillion'], [1e9, 'billion'], [1e6, 'million'], [1e3, 'thousand']];

export function numberToWords(number) {
    if (number < 20) {
        return SMALL[number];
    }

    if (number < 100) {
        return `${TENS[Math.floor(number / 10)]}${number % 10 ? `-${SMALL[number % 10]}` : ''}`;
    }

    if (number < 1000) {
        return `${SMALL[Math.floor(number / 100)]} hundred${number % 100 ? ` ${numberToWords(number % 100)}` : ''}`;
    }

    const [size, word] = SCALES.find(([scale]) => number >= scale);

    return `${numberToWords(Math.floor(number / size))} ${word}${number % size ? ` ${numberToWords(number % size)}` : ''}`;
}

export function amountInWords(totalMinor, currency) {
    const major = Math.floor(totalMinor / 100);
    const minor = totalMinor % 100;
    const majorWords = `${numberToWords(major)} ${major === 1 ? currency.major : currency.majorPlural}`;
    const minorWords = `${numberToWords(minor)} ${minor === 1 ? currency.minor : currency.minorPlural}`;

    return minor ? `${majorWords} and ${minorWords}` : majorWords;
}

export default function centsDollars(ctx, config) {
    const { currencies, quickRef } = config;

    ctx.onUpdate(() => {
        const toMajor = ctx.choice('direction') === 'cents';
        const currency = currencies[ctx.field('currency').value];
        const value = ctx.number('value');
        const money = (amount) => new Intl.NumberFormat('en-US', { style: 'currency', currency: ctx.field('currency').value, currencyDisplay: 'narrowSymbol' }).format(amount);

        ctx.setText('value-suffix', toMajor ? currency.minorPlural : currency.majorPlural);
        ctx.renderRows('quick-ref', quickRef.map((cents) => ({ label: `${cents} ${currency.minorPlural}`, value: money(cents / 100) })));

        if (Number.isNaN(value)) {
            ctx.clearResult();

            return;
        }

        if (value < 0) {
            ctx.showError('Enter an amount of 0 or more.');

            return;
        }

        const totalMinor = Math.round(toMajor ? value : value * 100);

        ctx.showResult(toMajor
            ? { value: money(totalMinor / 100), unit: '', label: currency.majorPlural[0].toUpperCase() + currency.majorPlural.slice(1), sub: `${ctx.format(value)} ${currency.minorPlural} ÷ 100` }
            : { value: ctx.format(totalMinor), unit: currency.minorPlural, label: currency.minorPlural[0].toUpperCase() + currency.minorPlural.slice(1), sub: `${money(value)} × 100` });

        ctx.setRow('decimal', money(totalMinor / 100));
        ctx.setRow('minor', `${totalMinor} ${totalMinor === 1 ? currency.minor : currency.minorPlural}`);
        ctx.setRow('mixed', `${Math.floor(totalMinor / 100)} ${currency.majorPlural} ${totalMinor % 100} ${currency.minorPlural}`);
        ctx.setRow('words', totalMinor < 1e15 ? amountInWords(totalMinor, currency) : 'Too large to write out');
    });
}
