/**
 * Text tools for the Everyday Life section: numbers in words, case changes, Unicode letter styles,
 * upside-down and glitch text, the NATO alphabet and Pig Latin. All functions are pure.
 */
const ONES = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
const TENS = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
const SCALES = ['', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion', 'octillion', 'nonillion', 'decillion'];

function underHundred(n) {
    return n < 20 ? ONES[n] : TENS[Math.floor(n / 10)] + (n % 10 ? `-${ONES[n % 10]}` : '');
}

function underThousand(n) {
    const hundreds = Math.floor(n / 100);
    const rest = n % 100;

    return [hundreds ? `${ONES[hundreds]} hundred` : '', rest ? underHundred(rest) : ''].filter(Boolean).join(' ');
}

/**
 * A whole number given as a string of digits, in words (US short scale or the Indian lakh/crore system).
 */
export function integerWords(digits, { indian = false } = {}) {
    const clean = String(digits).replace(/^0+(?=\d)/, '');

    if (clean === '0') {
        return 'zero';
    }

    if (indian) {
        // Last three digits, then pairs: thousand, lakh; everything above is counted in crores.
        if (clean.length > 7) {
            const crores = clean.slice(0, -7);
            const rest = clean.slice(-7);

            return [`${integerWords(crores, { indian: true })} crore`, /^0+$/.test(rest) ? '' : integerWords(rest, { indian: true })].filter(Boolean).join(' ');
        }

        const n = Number(clean);
        const parts = [];
        const lakh = Math.floor(n / 100000);
        const thousand = Math.floor((n % 100000) / 1000);
        const rest = n % 1000;

        if (lakh) {
            parts.push(`${underHundred(lakh)} lakh`);
        }

        if (thousand) {
            parts.push(`${underHundred(thousand)} thousand`);
        }

        if (rest) {
            parts.push(underThousand(rest));
        }

        return parts.join(' ');
    }

    const groups = [];

    for (let end = clean.length; end > 0; end -= 3) {
        groups.unshift(Number(clean.slice(Math.max(0, end - 3), end)));
    }

    if (groups.length > SCALES.length) {
        return null;
    }

    return groups.map((group, index) => (group ? `${underThousand(group)}${SCALES[groups.length - 1 - index] ? ` ${SCALES[groups.length - 1 - index]}` : ''}` : '')).filter(Boolean).join(' ');
}

/**
 * Reads '1,234.56', '-42' or '1e6' into { negative, whole, fraction } digit strings; null if not a number.
 */
export function parseNumberText(text) {
    let value = String(text ?? '').trim().replace(/[,\s_']/g, '');

    if (/^[+-]?\d+(\.\d+)?e[+-]?\d+$/i.test(value)) {
        const n = Number(value);

        if (!Number.isFinite(n) || Math.abs(n) >= 1e21) {
            return null;
        }

        value = n.toLocaleString('en-US', { useGrouping: false, maximumFractionDigits: 20 });
    }

    const match = /^([+-]?)(\d*)(?:\.(\d+))?$/.exec(value);

    if (!match || (match[2] === '' && !match[3])) {
        return null;
    }

    return { negative: match[1] === '-', whole: match[2] || '0', fraction: match[3] ?? '' };
}

export const capitalize = (text) => text.charAt(0).toUpperCase() + text.slice(1);

/**
 * The number in words: 'one hundred twenty-three point four five'.
 */
export function numberWords(text, { indian = false } = {}) {
    const parsed = parseNumberText(text);

    if (!parsed) {
        return null;
    }

    const whole = integerWords(parsed.whole, { indian });

    if (whole === null) {
        return null;
    }

    const fraction = parsed.fraction ? ` point ${[...parsed.fraction].map((d) => ONES[Number(d)]).join(' ')}` : '';

    return `${parsed.negative && /[1-9]/.test(parsed.whole + parsed.fraction) ? 'minus ' : ''}${whole}${fraction}`;
}

const ORDINAL = { one: 'first', two: 'second', three: 'third', five: 'fifth', eight: 'eighth', nine: 'ninth', twelve: 'twelfth' };

/**
 * 'one hundred twenty-three' → 'one hundred twenty-third'.
 */
export function ordinalWords(words) {
    return words.replace(/(\w+)$/, (last) => ORDINAL[last] ?? (last.endsWith('y') ? `${last.slice(0, -1)}ieth` : `${last}th`));
}

/**
 * Check wording: 'One thousand two hundred thirty-four and 56/100 dollars'.
 */
export function checkWords(text, unit = 'dollars') {
    const parsed = parseNumberText(text);

    if (!parsed || parsed.negative) {
        return null;
    }

    const cents = Math.round(Number(`0.${parsed.fraction || '0'}`) * 100);
    let whole = BigInt(parsed.whole);
    let centsPart = cents;

    if (centsPart === 100) {
        whole += 1n;
        centsPart = 0;
    }

    const words = integerWords(whole.toString());

    return words === null ? null : `${capitalize(words)} and ${String(centsPart).padStart(2, '0')}/100 ${unit}`;
}

/**
 * Words and cents spelled out: 'one thousand dollars and five cents'.
 */
export function moneyWords(text, { single = 'dollar', plural = 'dollars', cent = 'cent', cents = 'cents' } = {}) {
    const parsed = parseNumberText(text);

    if (!parsed || parsed.negative) {
        return null;
    }

    const value = Math.round(Number(`0.${parsed.fraction || '0'}`) * 100);
    let whole = BigInt(parsed.whole);
    let centValue = value;

    if (centValue === 100) {
        whole += 1n;
        centValue = 0;
    }

    const wholeWords = integerWords(whole.toString());

    if (wholeWords === null) {
        return null;
    }

    const parts = [`${wholeWords} ${whole === 1n ? single : plural}`];

    if (centValue) {
        parts.push(`${integerWords(String(centValue))} ${centValue === 1 ? cent : cents}`);
    }

    return parts.join(' and ');
}

/**
 * Words of a text, using the browser's word segmenter when present.
 */
export function words(text) {
    const value = String(text ?? '');

    if (typeof Intl !== 'undefined' && Intl.Segmenter) {
        return [...new Intl.Segmenter('en', { granularity: 'word' }).segment(value)].filter((part) => part.isWordLike).map((part) => part.segment);
    }

    return value.match(/[\p{L}\p{N}]+(?:['’-][\p{L}\p{N}]+)*/gu) ?? [];
}

/**
 * User-perceived characters (grapheme clusters), so emoji and accents count once.
 */
export function graphemes(text) {
    const value = String(text ?? '');

    if (typeof Intl !== 'undefined' && Intl.Segmenter) {
        return [...new Intl.Segmenter('en', { granularity: 'grapheme' }).segment(value)].map((part) => part.segment);
    }

    return [...value];
}

/**
 * Case conversions.
 */
const SMALL_WORDS = new Set(['a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'in', 'nor', 'of', 'on', 'or', 'per', 'the', 'to', 'vs', 'via']);

export function toCase(text, mode) {
    const value = String(text ?? '');
    const parts = words(value).map((word) => word.toLowerCase());

    switch (mode) {
        case 'upper':
            return value.toUpperCase();
        case 'lower':
            return value.toLowerCase();
        case 'title':
            return value.toLowerCase().replace(/[\p{L}\p{N}]+(?:['’][\p{L}]+)*/gu, (word, offset) => (offset > 0 && SMALL_WORDS.has(word) && !/[.:!?]\s*$/.test(value.slice(0, offset)) ? word : capitalize(word)));
        case 'sentence':
            return value.toLowerCase().replace(/(^\s*|[.!?]\s+)(\p{L})/gu, (all, before, letter) => before + letter.toUpperCase()).replace(/\bi\b/g, 'I');
        case 'camel':
            return parts.map((word, index) => (index ? capitalize(word) : word)).join('');
        case 'pascal':
            return parts.map(capitalize).join('');
        case 'snake':
            return parts.join('_');
        case 'kebab':
            return parts.join('-');
        case 'constant':
            return parts.join('_').toUpperCase();
        case 'alternating':
            return [...value].map((char, index) => (index % 2 ? char.toUpperCase() : char.toLowerCase())).join('');
        case 'inverse':
            return [...value].map((char) => (char === char.toUpperCase() ? char.toLowerCase() : char.toUpperCase())).join('');
        default:
            return value;
    }
}

/**
 * Unicode Mathematical Alphanumeric Symbols: [capital A, small a, digit 0 (or null)] start points and the reserved holes.
 */
const STYLES = {
    bold: [0x1d400, 0x1d41a, 0x1d7ce],
    italic: [0x1d434, 0x1d44e, null, { h: 0x210e }],
    bold_italic: [0x1d468, 0x1d482, null],
    script: [0x1d49c, 0x1d4b6, null, { B: 0x212c, E: 0x2130, F: 0x2131, H: 0x210b, I: 0x2110, L: 0x2112, M: 0x2133, R: 0x211b, e: 0x212f, g: 0x210a, o: 0x2134 }],
    bold_script: [0x1d4d0, 0x1d4ea, null],
    sans_bold: [0x1d5d4, 0x1d5ee, 0x1d7ec],
    sans_italic: [0x1d608, 0x1d622, null],
    sans_bold_italic: [0x1d63c, 0x1d656, null],
};

export function styleText(text, style) {
    const [upper, lower, digit, holes = {}] = STYLES[style] ?? [];

    if (!upper) {
        return String(text ?? '');
    }

    return [...String(text ?? '')].map((char) => {
        if (holes[char]) {
            return String.fromCodePoint(holes[char]);
        }

        const code = char.codePointAt(0);

        if (code >= 65 && code <= 90) {
            return String.fromCodePoint(upper + code - 65);
        }

        if (code >= 97 && code <= 122) {
            return String.fromCodePoint(lower + code - 97);
        }

        if (digit && code >= 48 && code <= 57) {
            return String.fromCodePoint(digit + code - 48);
        }

        return char;
    }).join('');
}

/**
 * Adds a combining mark after every visible character (underline U+0332, double U+0333, strike U+0336, slash U+0338).
 */
export function combineText(text, mark) {
    const code = { underline: '̲', double: '̳', strike: '̶', slash: '̸', overline: '̅' }[mark] ?? '̲';

    return graphemes(text).map((char) => (/\s/.test(char) ? char : char + code)).join('');
}

const FLIP = {
    a: 'ɐ', b: 'q', c: 'ɔ', d: 'p', e: 'ǝ', f: 'ɟ', g: 'ƃ', h: 'ɥ', i: 'ᴉ', j: 'ɾ', k: 'ʞ', l: 'l', m: 'ɯ', n: 'u', o: 'o', p: 'd', q: 'b', r: 'ɹ', s: 's', t: 'ʇ', u: 'n', v: 'ʌ', w: 'ʍ', x: 'x', y: 'ʎ', z: 'z',
    A: '∀', B: 'ᗺ', C: 'Ɔ', D: 'ᗡ', E: 'Ǝ', F: 'Ⅎ', G: '⅁', H: 'H', I: 'I', J: 'ſ', K: 'ꓘ', L: '˥', M: 'W', N: 'N', O: 'O', P: 'Ԁ', Q: 'Ό', R: 'ᴚ', S: 'S', T: 'ꓕ', U: '∩', V: 'Λ', W: 'M', X: 'X', Y: '⅄', Z: 'Z',
    0: '0', 1: 'Ɩ', 2: 'ᄅ', 3: 'Ɛ', 4: 'ㄣ', 5: 'ϛ', 6: '9', 7: 'ㄥ', 8: '8', 9: '6',
    '.': '˙', ',': '\'', '\'': ',', '"': '„', '?': '¿', '!': '¡', '(': ')', ')': '(', '[': ']', ']': '[', '{': '}', '}': '{', '<': '>', '>': '<', '&': '⅋', _: '‾', ';': '؛',
};

/**
 * Rotates text 180°: each character is swapped for an upside-down look-alike and the order is reversed.
 */
export function upsideDown(text) {
    return graphemes(text).reverse().map((char) => FLIP[char] ?? char).join('');
}

export function reverseText(text, mode = 'characters') {
    const value = String(text ?? '');

    if (mode === 'words') {
        return value.split(/(\s+)/).reverse().join('');
    }

    if (mode === 'each_word') {
        return value.replace(/[^\s]+/g, (word) => graphemes(word).reverse().join(''));
    }

    return graphemes(value).reverse().join('');
}

/**
 * Deterministic pseudo-random numbers (mulberry32), so the same text and seed always glitch the same way.
 */
function random(seed) {
    let a = seed >>> 0;

    return () => {
        a = (a + 0x6d2b79f5) >>> 0;
        let t = a;
        t = Math.imul(t ^ (t >>> 15), t | 1);
        t ^= t + Math.imul(t ^ (t >>> 7), t | 61);

        return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
    };
}

const ABOVE = [0x300, 0x301, 0x302, 0x303, 0x304, 0x306, 0x307, 0x308, 0x30a, 0x30b, 0x30c, 0x30d, 0x30e, 0x310, 0x311, 0x312, 0x313, 0x314, 0x33d, 0x346, 0x34a, 0x34b, 0x34c, 0x350, 0x351, 0x352, 0x357, 0x35b, 0x363, 0x364, 0x365, 0x366, 0x367, 0x368, 0x369, 0x36a, 0x36b, 0x36c, 0x36d, 0x36e, 0x36f];
const BELOW = [0x316, 0x317, 0x318, 0x319, 0x31c, 0x31d, 0x31e, 0x31f, 0x320, 0x323, 0x324, 0x325, 0x326, 0x329, 0x32a, 0x32b, 0x32c, 0x32d, 0x32e, 0x32f, 0x330, 0x331, 0x332, 0x333, 0x339, 0x33a, 0x33b, 0x33c, 0x345, 0x347, 0x348, 0x349, 0x34d, 0x34e, 0x353, 0x354, 0x355, 0x356, 0x359, 0x35a];
const MIDDLE = [0x334, 0x335, 0x336, 0x337, 0x338];

/**
 * Zalgo-style glitch text: combining marks stacked above, through and below each letter.
 */
export function glitchText(text, intensity = 3, seed = 1) {
    const next = random(seed * 2654435761 + intensity);
    const pick = (list) => String.fromCodePoint(list[Math.floor(next() * list.length)]);

    return graphemes(text).map((char) => {
        if (/\s/.test(char)) {
            return char;
        }

        let out = char;

        for (let k = 0; k < intensity; k += 1) {
            out += pick(ABOVE) + pick(BELOW);
        }

        if (intensity >= 3 && next() < 0.3) {
            out += pick(MIDDLE);
        }

        return out;
    }).join('');
}

export const NATO = {
    A: 'Alfa', B: 'Bravo', C: 'Charlie', D: 'Delta', E: 'Echo', F: 'Foxtrot', G: 'Golf', H: 'Hotel', I: 'India', J: 'Juliett', K: 'Kilo', L: 'Lima', M: 'Mike', N: 'November', O: 'Oscar', P: 'Papa', Q: 'Quebec', R: 'Romeo', S: 'Sierra', T: 'Tango', U: 'Uniform', V: 'Victor', W: 'Whiskey', X: 'X-ray', Y: 'Yankee', Z: 'Zulu',
    0: 'Zero', 1: 'One', 2: 'Two', 3: 'Three', 4: 'Four', 5: 'Five', 6: 'Six', 7: 'Seven', 8: 'Eight', 9: 'Nine',
};
export const NATO_SPOKEN = { 3: 'Tree', 4: 'Fower', 5: 'Fife', 9: 'Niner', 1000: 'Tousand' };

/**
 * Spells text in the ICAO/NATO alphabet; letters without a code word are kept as they are.
 */
export function natoSpell(text, { spoken = false } = {}) {
    return graphemes(String(text ?? '')).map((char) => {
        if (/\s/.test(char)) {
            return '/';
        }

        const key = char.toUpperCase().normalize('NFD').replace(/[̀-ͯ]/g, '');

        return (spoken && NATO_SPOKEN[key]) || NATO[key] || char;
    }).join(' ').replace(/\s*\/\s*/g, ' / ');
}

/**
 * Pig Latin: consonant clusters move to the end with 'ay' (with 'qu' kept together); vowel words add 'way'.
 * Capitalisation of the first letter and surrounding punctuation are kept.
 */
export function pigLatin(text, { vowelSuffix = 'way' } = {}) {
    return String(text ?? '').replace(/[A-Za-z]+(?:'[A-Za-z]+)?/g, (word) => {
        const lower = word.toLowerCase();
        const capital = word[0] !== lower[0];
        const allCaps = word.length > 1 && word === word.toUpperCase();
        let result;

        if (/^[aeiou]/.test(lower)) {
            result = lower + vowelSuffix;
        } else {
            const match = /^(qu|[^aeiouy]*qu|[^aeiouy]+|y[^aeiouy]*)(.*)$/.exec(lower);
            result = match[2] ? `${match[2]}${match[1]}ay` : `${lower}ay`;
        }

        if (allCaps) {
            return result.toUpperCase();
        }

        return capital ? capitalize(result) : result;
    });
}
