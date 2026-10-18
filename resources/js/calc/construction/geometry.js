/**
 * Shared geometry and unit helpers for the Construction calculators.
 * Inputs arrive in base units (meters, m², liters, grams); constants below convert for display.
 */
export const IN = 0.0254;
export const FT = 0.3048;
export const YD = 0.9144;
export const FT2 = FT * FT;
export const YD2 = YD * YD;
export const FT3 = FT ** 3;
export const YD3 = YD ** 3;
export const GAL = 0.003785411784;
export const LB = 0.45359237;
export const SHORT_TON = 907.18474;
export const LONG_TON = 1016.0469088;
export const ACRE = 4046.8564224;
export const PCF = 16.01846337396014;
export const RAD = Math.PI / 180;
export const G0 = 9.80665;
export const LBF = 4.4482216152605;
export const PSI = 6894.757293168361;
export const BTU_H = 0.2930710701722222;

export const money = (value) => new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(value);

const positive = (...values) => values.every((value) => typeof value === 'number' && Number.isFinite(value) && value > 0);

/**
 * Area (m²) and perimeter (m) of a plan shape read from the <x-calc.shape> fields.
 *
 * @returns {{ area: number, perimeter: number } | { error: string } | { empty: string }}
 */
export function shapeArea(shape, i) {
    switch (shape) {
        case 'rectangle':
            if (!positive(i.length, i.width)) {
                return { empty: 'Enter the length and width.' };
            }

            return { area: i.length * i.width, perimeter: 2 * (i.length + i.width) };
        case 'circle':
            if (!positive(i.diameter)) {
                return { empty: 'Enter the diameter.' };
            }

            return { area: (Math.PI / 4) * i.diameter ** 2, perimeter: Math.PI * i.diameter };
        case 'triangle': {
            if (!positive(i.base, i.height)) {
                return { empty: 'Enter the base and height.' };
            }

            // Perimeter of an isosceles triangle with that base and height.
            const side = Math.hypot(i.base / 2, i.height);

            return { area: (i.base * i.height) / 2, perimeter: i.base + 2 * side };
        }
        case 'trapezoid': {
            if (!positive(i.side_a, i.side_b, i.height)) {
                return { empty: 'Enter both parallel sides and the height.' };
            }

            const leg = Math.hypot(Math.abs(i.side_b - i.side_a) / 2, i.height);

            return { area: ((i.side_a + i.side_b) / 2) * i.height, perimeter: i.side_a + i.side_b + 2 * leg };
        }
        case 'l_shape':
            if (!positive(i.length, i.width) || !(i.cut_length >= 0) || !(i.cut_width >= 0)) {
                return { empty: 'Enter the overall size and the corner cut-out.' };
            }

            if (i.cut_length >= i.length || i.cut_width >= i.width) {
                return { error: 'The cut-out must be smaller than the overall length and width.' };
            }

            return { area: i.length * i.width - i.cut_length * i.cut_width, perimeter: 2 * (i.length + i.width) };
        case 'ring':
            if (!positive(i.outer) || !(i.inner >= 0)) {
                return { empty: 'Enter the outer and inner diameters.' };
            }

            if (i.inner >= i.outer) {
                return { error: 'The inner diameter must be smaller than the outer diameter.' };
            }

            return { area: (Math.PI / 4) * (i.outer ** 2 - i.inner ** 2), perimeter: Math.PI * (i.outer + i.inner) };
        case 'oval':
            if (!positive(i.length, i.width)) {
                return { empty: 'Enter the length and width.' };
            }

            return { area: (Math.PI / 4) * i.length * i.width, perimeter: ellipsePerimeter(i.length / 2, i.width / 2) };
        default:
            return { error: 'Choose a shape.' };
    }
}

/**
 * Exact ellipse perimeter from semi-axes a and b, by the arithmetic–geometric mean:
 * P = 2π (a² − Σ 2ⁿ⁻¹ cₙ²) ÷ AGM(a, b), with c₀² = a² − b² and cₙ₊₁ = (aₙ − bₙ) ÷ 2.
 */
export function ellipsePerimeter(a, b) {
    let [x, y] = [Math.max(a, b), Math.min(a, b)];
    let sum = (x * x - y * y) / 2;
    let power = 1;

    for (let step = 0; step < 30 && Math.abs(x - y) > 1e-15 * x; step += 1) {
        const c = (x - y) / 2;
        [x, y] = [(x + y) / 2, Math.sqrt(x * y)];
        sum += power * c * c;
        power *= 2;
    }

    return (2 * Math.PI * (Math.max(a, b) ** 2 - sum)) / x;
}

/**
 * Area of a circular segment of radius r cut by a chord at height h from the bottom (0 ≤ h ≤ 2r).
 */
export function segmentArea(radius, height) {
    const h = Math.min(Math.max(height, 0), 2 * radius);

    return radius ** 2 * Math.acos((radius - h) / radius) - (radius - h) * Math.sqrt(2 * radius * h - h * h);
}

/**
 * Volume of a spherical cap of sphere radius r and height h.
 */
export function capVolume(radius, height) {
    return (Math.PI * height ** 2 * (3 * radius - height)) / 3;
}

/**
 * Sagitta (arc height) of a circle of radius r over a chord c, and the derived arc values.
 */
export function sagitta(radius, chord) {
    const half = chord / 2;
    const s = radius - Math.sqrt(radius ** 2 - half ** 2);
    const angle = 2 * Math.asin(half / radius);

    return { sagitta: s, angle, arc: radius * angle, area: segmentArea(radius, s) };
}

/**
 * Radius of the circle through a chord c with arc height s.
 */
export function radiusFromChordRise(chord, rise) {
    return ((chord / 2) ** 2 + rise ** 2) / (2 * rise);
}

/**
 * Parses "a b c" rows from a rows editor into numbers, converting length columns with the unit factor.
 * Blank cells ('-') read as NaN so a handler can skip or report them.
 */
export function readRows(text, factors = []) {
    return String(text ?? '')
        .split('\n')
        .map((line) => line.trim())
        .filter(Boolean)
        .map((line) => line.split(/\s+/).map((value, index) => (value === '-' ? Number.NaN : Number(value) * (factors[index] ?? 1))));
}

/**
 * Formats a length in meters as feet and inches to the nearest 1/16 in.
 */
export function feetInches(meters) {
    const sixteenths = Math.round((meters / IN) * 16);
    const feet = Math.floor(sixteenths / (12 * 16));
    const rest = sixteenths - feet * 12 * 16;
    const inches = Math.floor(rest / 16);
    let fraction = rest - inches * 16;
    let denominator = 16;

    while (fraction && fraction % 2 === 0) {
        fraction /= 2;
        denominator /= 2;
    }

    const inchText = fraction ? `${inches} ${fraction}/${denominator}` : `${inches}`;

    return feet ? `${feet} ft ${inchText} in` : `${inchText} in`;
}

/**
 * Fraction of an inch to the nearest 1/16 (for cut lists), e.g. 7.4375 → "7 7/16".
 */
export function inchFraction(inches) {
    const sixteenths = Math.round(inches * 16);
    const whole = Math.floor(sixteenths / 16);
    let fraction = sixteenths - whole * 16;
    let denominator = 16;

    while (fraction && fraction % 2 === 0) {
        fraction /= 2;
        denominator /= 2;
    }

    if (!fraction) {
        return `${whole}`;
    }

    return whole ? `${whole} ${fraction}/${denominator}` : `${fraction}/${denominator}`;
}
