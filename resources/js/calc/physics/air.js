import { bisect } from './core.js';

/**
 * Water, moist air and the standard atmosphere.
 */

/** Saturation pressure of water (Pa) at T (K): IAPWS-IF97 region 4, valid 273.15–647.096 K. */
export function waterVapourPressure(T) {
    const n = [0.11670521452767e4, -0.72421316703206e6, -0.17073846940092e2, 0.12020824702470e5, -0.32325550322333e7, 0.14915108613530e2, -0.48232657361591e4, 0.40511340542057e6, -0.23855557567849, 0.65017534844798e3];
    const th = T + n[8] / (T - n[9]);
    const A = th * th + n[0] * th + n[1];
    const B = n[2] * th * th + n[3] * th + n[4];
    const C = n[5] * th * th + n[6] * th + n[7];

    return ((2 * C) / (-B + Math.sqrt(B * B - 4 * A * C))) ** 4 * 1e6;
}

/** Density of liquid water (kg/m³) at t °C, Kell (1975), 0–150 °C at 1 atm. */
export function waterDensity(t) {
    return (999.83952 + 16.945176 * t - 7.9870401e-3 * t * t - 46.170461e-6 * t ** 3 + 105.56302e-9 * t ** 4 - 280.54253e-12 * t ** 5) / (1 + 16.87985e-3 * t);
}

/** Dynamic viscosity of liquid water (Pa·s) at T (K): Vogel form μ = A·10^(B/(T − C)), within about 2.5% from 0 to 370 °C. */
export function waterViscosity(T) {
    return 2.414e-5 * 10 ** (247.8 / (T - 140));
}

/** Dynamic viscosity of air (Pa·s) at T (K): Sutherland's law, μ₀ = 1.716 × 10⁻⁵ Pa·s at 273.15 K, S = 110.4 K. */
export function airViscosity(T) {
    return 1.716e-5 * (T / 273.15) ** 1.5 * ((273.15 + 110.4) / (T + 110.4));
}

/** Saturation vapour pressure over water (t ≥ 0 °C) or ice (t < 0 °C), Pa: Hyland–Wexler (ASHRAE Fundamentals 2017, ch. 1). */
export function satPressure(T) {
    if (T < 273.15) {
        return Math.exp(-5.6745359e3 / T + 6.3925247 - 9.677843e-3 * T + 6.2215701e-7 * T ** 2 + 2.0747825e-9 * T ** 3 - 9.484024e-13 * T ** 4 + 4.1635019 * Math.log(T));
    }

    return Math.exp(-5.8002206e3 / T + 1.3914993 - 4.8640239e-2 * T + 4.1764768e-5 * T ** 2 - 1.4452093e-8 * T ** 3 + 6.5459673 * Math.log(T));
}

/** Dew point (K) for a vapour pressure (Pa), by inverting satPressure. */
export function dewPoint(pv) {
    return bisect((T) => satPressure(T) - pv, 173.15, 473.15, 100);
}

/** Humidity ratio W (kg water per kg dry air) from vapour pressure and total pressure (Pa). */
export const humidityRatio = (pv, p) => (0.621945 * pv) / (p - pv);

/** Wet-bulb temperature (K) from dry bulb T (K), humidity ratio W and pressure p (Pa): ASHRAE psychrometric equation solved by bisection. */
export function wetBulb(T, W, p) {
    const t = T - 273.15;
    const f = (twK) => {
        const tw = twK - 273.15;
        const Ws = humidityRatio(satPressure(twK), p);
        const Wcalc = tw >= 0 ? ((2501 - 2.326 * tw) * Ws - 1.006 * (t - tw)) / (2501 + 1.86 * t - 4.186 * tw) : ((2830 - 0.24 * tw) * Ws - 1.006 * (t - tw)) / (2830 + 1.86 * t - 2.1 * tw);

        return Wcalc - W;
    };

    return bisect(f, 173.15, T, 100);
}

/** Every psychrometric property from dry bulb T (K), vapour pressure pv (Pa) and pressure p (Pa). */
export function psychro(T, pv, p) {
    const t = T - 273.15;
    const ps = satPressure(T);
    const W = humidityRatio(pv, p);

    return {
        t,
        pv,
        ps,
        rh: pv / ps,
        W,
        dew: pv > 0 ? dewPoint(pv) : NaN,
        wet: wetBulb(T, W, p),
        h: 1.006 * t + W * (2501 + 1.86 * t),
        v: (287.042 * T * (1 + 1.607858 * W)) / p,
        rho: (p - pv) / (287.058 * T) + pv / (461.495 * T),
        abs: pv / (461.495 * T),
        Tv: T * (1 + W / 0.621945) / (1 + W),
    };
}

/** US Standard Atmosphere 1976 to 84.852 km geopotential: [base height (m), base T (K), lapse rate (K/m), base pressure (Pa)]. */
const LAYERS = [[0, 288.15, -0.0065, 101325], [11000, 216.65, 0, 22632.06], [20000, 216.65, 0.001, 5474.889], [32000, 228.65, 0.0028, 868.0187], [47000, 270.65, 0, 110.9063], [51000, 270.65, -0.0028, 66.93887], [71000, 214.65, -0.002, 3.956420]];
const GMR = (9.80665 * 0.0289644) / 8.31432;

/** Standard temperature (K), pressure (Pa) and density (kg/m³) at geometric altitude z (m), 0–86 km. */
export function standardAtmosphere(z) {
    const h = (6356766 * z) / (6356766 + z);
    const [hb, Tb, L, Pb] = [...LAYERS].reverse().find(([base]) => h >= base) ?? LAYERS[0];
    const T = Tb + L * (h - hb);
    const P = L === 0 ? Pb * Math.exp((-GMR * (h - hb)) / Tb) : Pb * (Tb / T) ** (GMR / L);

    return { T, P, rho: P / (287.0531 * T), h };
}
