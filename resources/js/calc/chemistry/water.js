/**
 * Liquid water properties at 0.1 MPa.
 */

/**
 * Density of air-free water at 1 atm, 0 to 150 °C, in kg/m³ (Kell, 1975).
 */
export function waterDensity(celsius) {
    const t = celsius;

    return (999.83952 + 16.945176 * t - 7.9870401e-3 * t ** 2 - 46.170461e-6 * t ** 3 + 105.56302e-9 * t ** 4 - 280.54253e-12 * t ** 5) / (1 + 16.879850e-3 * t);
}

/**
 * Ionization constant of water, pKw, from IAPWS R11-07 (Bandura and Lvov, 2006).
 * T in kelvin, density in g/cm³. Check values: pKw(300 K, 1.0) = 13.906565.
 */
export function pKwIapws(kelvin, density) {
    const n = 6;
    const [a0, a1, a2] = [-0.864671, 8659.19, -22786.2];
    const [b0, b1, b2] = [0.642044, -56.8534, -0.375754];
    const z = density * Math.exp(a0 + a1 / kelvin + (a2 / kelvin ** 2) * density ** (2 / 3));
    const ideal = 0.61415 + 48251.33 / kelvin - 67707.93 / kelvin ** 2 + 10102100 / kelvin ** 3;

    return -2 * n * (Math.log10(1 + z) - (z / (z + 1)) * density * (b0 + b1 / kelvin + b2 * density)) + ideal + 2 * Math.log10(18.015268 / 1000);
}

/**
 * pKw of liquid water at 1 atm for 0 to 100 °C (13.995 at 25 °C).
 */
export function pKw(celsius = 25) {
    if (celsius < 0 || celsius > 100) {
        throw new RangeError('Water temperature must be 0 to 100 °C.');
    }

    return pKwIapws(celsius + 273.15, waterDensity(celsius) / 1000);
}
