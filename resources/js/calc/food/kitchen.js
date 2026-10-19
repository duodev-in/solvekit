/**
 * Kitchen measures: volume and weight units (with the US, nutrition-label, metric and imperial cups and the
 * Australian 20 ml tablespoon), ingredient densities from the USDA FoodData Central table in config/food_data.php,
 * kitchen fractions and recipe-line parsing shared by the Food and Cooking calculators.
 */
export const US_CUP_ML = 236.5882365;

/** Volume units in millilitres. */
export const VOLUME = {
    cup_us: { ml: US_CUP_ML, label: 'US cup', short: 'cup' },
    cup_label: { ml: 240, label: 'US nutrition-label cup (240 ml)', short: 'label cup' },
    cup_metric: { ml: 250, label: 'Metric cup (250 ml)', short: 'metric cup' },
    cup_uk: { ml: 284.130625, label: 'Imperial cup (284 ml)', short: 'imperial cup' },
    tbsp_us: { ml: US_CUP_ML / 16, label: 'US tablespoon (14.8 ml)', short: 'tbsp' },
    tbsp_metric: { ml: 15, label: 'Metric tablespoon (15 ml)', short: 'metric tbsp' },
    tbsp_au: { ml: 20, label: 'Australian tablespoon (20 ml)', short: 'Aus tbsp' },
    tsp_us: { ml: US_CUP_ML / 48, label: 'US teaspoon (4.9 ml)', short: 'tsp' },
    tsp_metric: { ml: 5, label: 'Metric teaspoon (5 ml)', short: 'metric tsp' },
    floz_us: { ml: US_CUP_ML / 8, label: 'US fluid ounce', short: 'fl oz' },
    floz_uk: { ml: 28.4130625, label: 'Imperial fluid ounce', short: 'imp fl oz' },
    pint_us: { ml: US_CUP_ML * 2, label: 'US pint', short: 'pt' },
    quart_us: { ml: US_CUP_ML * 4, label: 'US quart', short: 'qt' },
    gallon_us: { ml: US_CUP_ML * 16, label: 'US gallon', short: 'gal' },
    pint_uk: { ml: 568.26125, label: 'Imperial pint', short: 'imp pt' },
    ml: { ml: 1, label: 'Millilitre', short: 'ml' },
    dl: { ml: 100, label: 'Decilitre', short: 'dl' },
    l: { ml: 1000, label: 'Litre', short: 'L' },
};

/** Weight units in grams. */
export const WEIGHT = {
    g: { g: 1, label: 'Gram', short: 'g' },
    kg: { g: 1000, label: 'Kilogram', short: 'kg' },
    mg: { g: 0.001, label: 'Milligram', short: 'mg' },
    oz: { g: 28.349523125, label: 'Ounce', short: 'oz' },
    lb: { g: 453.59237, label: 'Pound', short: 'lb' },
};

/** A US stick of butter: ½ US cup, 8 tablespoons, 4 oz (113.4 g; USDA lists 113 g a stick and 227 g a cup). */
export const STICK_G = 113.4;

export const isVolume = (unit) => unit in VOLUME;
export const isWeight = (unit) => unit in WEIGHT;
export const unitShort = (unit) => (VOLUME[unit] ?? WEIGHT[unit])?.short ?? unit;

/**
 * The ingredient row for a key, or null.
 */
export function ingredient(config, key) {
    return config.data?.ingredients?.[key] ?? null;
}

/**
 * Grams per millilitre from the USDA grams-per-cup measure (USDA household cups are US cups).
 */
export function gramsPerMl(row) {
    return row && Number.isFinite(row.cup) ? row.cup / US_CUP_ML : NaN;
}

/**
 * Converts an amount in any kitchen unit to grams for an ingredient; NaN when a volume needs a density the ingredient lacks.
 */
export function toGrams(amount, unit, row) {
    if (isWeight(unit)) {
        return amount * WEIGHT[unit].g;
    }

    if (isVolume(unit)) {
        return amount * VOLUME[unit].ml * gramsPerMl(row);
    }

    if (unit === 'stick') {
        return amount * STICK_G;
    }

    const piece = row?.pieces?.[unit];

    return Number.isFinite(piece) ? amount * piece : NaN;
}

export function fromGrams(grams, unit, row) {
    if (isWeight(unit)) {
        return grams / WEIGHT[unit].g;
    }

    if (isVolume(unit)) {
        return grams / gramsPerMl(row) / VOLUME[unit].ml;
    }

    if (unit === 'stick') {
        return grams / STICK_G;
    }

    const piece = row?.pieces?.[unit];

    return Number.isFinite(piece) ? grams / piece : NaN;
}

/**
 * Kitchen number: whole numbers above 100, one decimal above 10, otherwise up to two decimals (three significant figures below 0.1).
 */
export function kn(value) {
    if (!Number.isFinite(value)) {
        return '—';
    }

    const magnitude = Math.abs(value);
    const options = magnitude >= 100 ? { maximumFractionDigits: 0 } : magnitude >= 10 ? { maximumFractionDigits: 1 } : magnitude >= 0.1 || magnitude === 0 ? { maximumFractionDigits: 2 } : { maximumSignificantDigits: 3 };

    return new Intl.NumberFormat('en-US', options).format(value);
}

const FRACTIONS = [[0, ''], [1 / 8, '⅛'], [1 / 4, '¼'], [1 / 3, '⅓'], [3 / 8, '⅜'], [1 / 2, '½'], [5 / 8, '⅝'], [2 / 3, '⅔'], [3 / 4, '¾'], [7 / 8, '⅞'], [1, '']];

/**
 * Nearest kitchen fraction (eighths and thirds), e.g. 1.32 → "1⅓". Returns null when no fraction is within 4%.
 */
export function fraction(value) {
    if (!Number.isFinite(value) || value <= 0) {
        return null;
    }

    let whole = Math.floor(value);
    const rest = value - whole;
    const [part, glyph] = FRACTIONS.reduce((best, item) => (Math.abs(item[0] - rest) < Math.abs(best[0] - rest) ? item : best));

    if (Math.abs(whole + part - value) > Math.max(0.04 * value, 0.01)) {
        return null;
    }

    if (part === 1) {
        whole += 1;
    }

    if (whole === 0 && glyph === '') {
        return null;
    }

    return `${whole > 0 ? whole : ''}${glyph}`;
}

/**
 * A measure written the way a cook reads it: "1⅓ cups (1.32)", or the plain number when no fraction is close.
 */
export function measure(value, unit) {
    const name = unitShort(unit);
    const plural = value >= 1.005 && /(cup|stick)$/.test(name) ? `${name}s` : name;
    // Fractions suit cups, spoons, sticks and fluid ounces below 20; millilitres and large counts stay decimal.
    const text = /^(cup|tbsp|tsp|stick|floz)/.test(unit) && value < 20 ? fraction(value) : null;

    if (!text || /^\d+$/.test(text)) {
        return `${kn(value)} ${plural}`;
    }

    // Show the decimal too when the fraction is only close, not exact.
    const exact = FRACTIONS.some(([part]) => Math.abs(value - Math.floor(value) - part) < 0.005);

    return exact ? `${text} ${plural}` : `${text} ${plural} (${kn(value)})`;
}

const VULGAR = { '¼': 0.25, '½': 0.5, '¾': 0.75, '⅓': 1 / 3, '⅔': 2 / 3, '⅛': 0.125, '⅜': 0.375, '⅝': 0.625, '⅞': 0.875 };

/**
 * Parses an amount such as "2", "1.5", "1 1/2", "1½", "¾" or "3/4"; NaN when it is not a number.
 */
export function parseAmount(text) {
    const value = String(text ?? '').trim().replace(/,/g, '.');

    if (value === '') {
        return NaN;
    }

    const match = value.match(/^(\d+(?:\.\d+)?)?\s*(?:([¼½¾⅓⅔⅛⅜⅝⅞])|(\d+)\s*\/\s*(\d+))?$/);

    if (!match || (!match[1] && !match[2] && !match[3])) {
        return NaN;
    }

    // "3/4" alone: the first number is the numerator, not a whole part.
    if (match[1] && !match[2] && !match[3] && value.includes('/')) {
        return NaN;
    }

    const whole = match[1] ? Number(match[1]) : 0;
    const part = match[2] ? VULGAR[match[2]] : match[3] ? Number(match[3]) / Number(match[4]) : 0;

    const amount = whole + part;

    return Number.isFinite(amount) ? amount : NaN;
}

const UNIT_WORDS = [
    [/^(cups?|c)$/, 'cup_us'], [/^(tablespoons?|tbsps?|tbs|tbl|T)$/, 'tbsp_us'], [/^(teaspoons?|tsps?|t)$/, 'tsp_us'],
    [/^(grams?|g|gr)$/, 'g'], [/^(kilograms?|kgs?)$/, 'kg'], [/^(milligrams?|mg)$/, 'mg'], [/^(ounces?|oz)$/, 'oz'], [/^(pounds?|lbs?)$/, 'lb'],
    [/^(millilit(er|re)s?|ml|mls)$/, 'ml'], [/^(decilit(er|re)s?|dl)$/, 'dl'], [/^(lit(er|re)s?|l)$/, 'l'], [/^(fl\.? ?oz|fluid ounces?)$/, 'floz_us'],
    [/^(pints?|pt)$/, 'pint_us'], [/^(quarts?|qt)$/, 'quart_us'], [/^(gallons?|gal)$/, 'gallon_us'], [/^(sticks?)$/, 'stick'],
    [/^(pinch(es)?)$/, 'pinch'], [/^(dash(es)?)$/, 'dash'], [/^(metric cups?)$/, 'cup_metric'],
];

/**
 * Normalises a written unit ("cups", "Tbsp", "g", "fl oz", "") to a unit key; '' means a count of pieces, and other words name a piece ("packet").
 */
export function parseUnit(text) {
    const raw = String(text ?? '').trim().replace(/\.$/, '');

    if (raw === '' || /^(each|ea|pieces?|pcs?|whole|x|large|medium|small|cloves?|eggs?|slices?)$/i.test(raw)) {
        return raw.toLowerCase().replace(/s$/, '').replace(/^(each|ea|piece|pc|whole|x|egg)$/, '');
    }

    // T and t are the only case-sensitive abbreviations (tablespoon and teaspoon).
    for (const [pattern, key] of UNIT_WORDS) {
        if (pattern.test(raw) || (!['T', 't'].includes(raw) && pattern.test(raw.toLowerCase()))) {
            return key;
        }
    }

    // Any other word is a named piece (packet, can, slice); the ingredient's piece weights decide whether it is known.
    return /^[a-z][a-z ()-]*$/i.test(raw) ? raw.toLowerCase().replace(/s$/, '') : null;
}

const ALIASES = { flour: 'flour_ap', sugar: 'sugar', 'brown sugar': 'sugar_brown_packed', 'icing sugar': 'sugar_powdered', 'confectioners sugar': 'sugar_powdered', butter: 'butter', milk: 'milk', egg: 'egg', eggs: 'egg', water: 'water', oil: 'oil_vegetable', salt: 'salt', rice: 'rice_white', basmati: 'rice_white', jasmine: 'rice_white', yeast: 'yeast_active', cream: 'cream_heavy', cheese: 'cheddar', oats: 'oats', honey: 'honey', cocoa: 'cocoa', garlic: 'garlic', 'garlic clove': 'garlic', 'garlic cloves': 'garlic', 'cooked rice': 'rice_white_cooked' };

/**
 * Finds the ingredient a recipe line names: its key, its exact name, an alias, or the closest name by shared words.
 * Returns { key, row } or null.
 */
export function findIngredient(config, text) {
    const all = config.data?.ingredients ?? {};
    const query = String(text ?? '').trim().toLowerCase();

    if (!query) {
        return null;
    }

    if (all[query]) {
        return { key: query, row: all[query] };
    }

    const exact = Object.entries(all).find(([, row]) => row.name.toLowerCase() === query);

    if (exact) {
        return { key: exact[0], row: exact[1] };
    }

    const alias = ALIASES[query] ?? ALIASES[query.replace(/s$/, '')];

    if (alias && all[alias]) {
        return { key: alias, row: all[alias] };
    }

    const words = query.split(/[^a-z0-9]+/).filter((word) => word.length > 1).map((word) => word.replace(/oes$/, 'o').replace(/s$/, ''));
    const wordAlias = words.map((word) => ALIASES[word]).find((key) => key && all[key]);

    if (wordAlias && words.length === 2 && words.some((word) => ['basmati', 'jasmine'].includes(word))) {
        return { key: wordAlias, row: all[wordAlias] };
    }

    // Rarer words count for more (parmesan beats cheese); a name that starts with a query word gets a small bonus.
    const names = Object.values(all).map((row) => row.name.toLowerCase());
    const has = (name, word) => new RegExp(`\\b${word.replace(/[^a-z0-9]/g, '')}`).test(name);
    const weight = Object.fromEntries(words.map((word) => [word, 1 / Math.max(1, names.filter((name) => has(name, word)).length)]));
    const total = words.reduce((sum, word) => sum + weight[word], 0);
    let best = null;

    Object.entries(all).forEach(([key, row]) => {
        const name = row.name.toLowerCase();
        const hits = words.filter((word) => has(name, word));
        const score = hits.reduce((sum, word) => sum + weight[word], 0) / total + (hits.some((word) => name.startsWith(word)) ? 0.05 : 0) - name.length / 2000 - (/\((cooked|sifted)\b/.test(name) && !hits.some((word) => ['cooked', 'sifted'].includes(word)) ? 0.02 : 0);

        if (hits.length && (!best || score > best.score)) {
            best = { key, row, score };
        }
    });

    return best ? { key: best.key, row: best.row } : null;
}

/**
 * Grams for one recipe line (amount, written unit, ingredient row). Pieces use the ingredient's first named piece
 * (a large egg, a clove, a slice); pinch and dash are ⅛ and 1⁄16 teaspoon.
 */
export function lineGrams(amount, unitKey, row) {
    if (!Number.isFinite(amount) || unitKey === null) {
        return NaN;
    }

    if (unitKey === 'pinch' || unitKey === 'dash') {
        return toGrams(amount * (unitKey === 'pinch' ? 1 / 16 : 1 / 8), 'tsp_us', row);
    }

    if (unitKey === '' || !(unitKey in VOLUME || unitKey in WEIGHT || unitKey === 'stick')) {
        const pieces = row?.pieces ?? {};
        // A bare count uses the large or first listed piece; a named piece must be in the ingredient's list.
        const piece = unitKey === '' || unitKey === 'large' ? pieces.large ?? Object.values(pieces)[0] : pieces[unitKey];

        return Number.isFinite(piece) ? amount * piece : NaN;
    }

    return toGrams(amount, unitKey, row);
}
