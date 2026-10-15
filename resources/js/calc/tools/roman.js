const SYMBOLS = [[1000, 'M'], [900, 'CM'], [500, 'D'], [400, 'CD'], [100, 'C'], [90, 'XC'], [50, 'L'], [40, 'XL'], [10, 'X'], [9, 'IX'], [5, 'V'], [4, 'IV'], [1, 'I']];
const VALID = /^M{0,3}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/;

/**
 * Standard Roman numerals, 1 to 3999. Returns the numeral and the parts used.
 */
export function toRoman(number) {
    let remaining = number;
    const parts = [];

    SYMBOLS.forEach(([value, symbol]) => {
        while (remaining >= value) {
            parts.push([symbol, value]);
            remaining -= value;
        }
    });

    return { numeral: parts.map(([symbol]) => symbol).join(''), parts };
}

export function fromRoman(text) {
    const numeral = text.trim().toUpperCase();

    if (numeral === '' || !VALID.test(numeral)) {
        return null;
    }

    const parts = [];
    let index = 0;

    SYMBOLS.forEach(([value, symbol]) => {
        while (numeral.startsWith(symbol, index)) {
            parts.push([symbol, value]);
            index += symbol.length;
        }
    });

    return { value: parts.reduce((total, [, value]) => total + value, 0), parts };
}

export default function roman(ctx) {
    ctx.onUpdate(() => {
        const toNumeral = ctx.choice('direction') === 'number';
        const text = ctx.field('value').value.trim();
        ctx.setText('value-label', toNumeral ? 'Number (1 to 3999)' : 'Roman numeral');

        if (text === '') {
            ctx.clearResult(toNumeral ? 'Enter a whole number from 1 to 3999.' : 'Enter a Roman numeral such as MMXXVI.');

            return;
        }

        let number;
        let parts;

        if (toNumeral) {
            number = Number(text);

            if (!Number.isInteger(number) || number < 1 || number > 3999) {
                ctx.showError('Standard Roman numerals cover whole numbers from 1 to 3999.');

                return;
            }

            ({ parts } = toRoman(number));
        } else {
            const parsed = fromRoman(text);

            if (!parsed) {
                ctx.showError('That is not a valid Roman numeral. Use I, V, X, L, C, D and M in standard order, e.g. XIV, not XIIII.');

                return;
            }

            ({ value: number, parts } = parsed);
        }

        const numeral = parts.map(([symbol]) => symbol).join('');

        ctx.showResult(toNumeral
            ? { value: numeral, unit: '', label: 'Roman numeral', sub: `${number} = ${parts.map(([symbol]) => symbol).join(' + ')}` }
            : { value: new Intl.NumberFormat('en-US').format(number), unit: '', label: 'Number', sub: `${numeral} = ${parts.map(([, value]) => value).join(' + ')}` });

        ctx.setRow('number', String(number));
        ctx.setRow('numeral', numeral);
        ctx.setRow('length', `${numeral.length} characters`);
        ctx.setRow('symbols', [...new Set(numeral)].join(', '));
    });
}
