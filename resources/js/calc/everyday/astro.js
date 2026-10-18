/**
 * Moon phases and sidereal time from Jean Meeus, Astronomical Algorithms (2nd ed., 1998), chapters 12, 47–49,
 * and the IAU 2006 Earth rotation angle. Times are Julian Days (UT unless named JDE, which is Terrestrial Time).
 */
const RAD = Math.PI / 180;
const sin = (deg) => Math.sin(deg * RAD);
const cos = (deg) => Math.cos(deg * RAD);
const norm = (deg) => ((deg % 360) + 360) % 360;

export const SYNODIC_MONTH = 29.530588861;

/**
 * Julian Day of a UTC instant given as milliseconds since 1970-01-01T00:00Z.
 */
export const jdFromMs = (ms) => ms / 86400000 + 2440587.5;
export const msFromJd = (jd) => (jd - 2440587.5) * 86400000;

/**
 * ΔT = TT − UT in seconds (Espenak & Meeus polynomials, 1860–2150), used to turn Meeus's JDE into UT.
 */
export function deltaT(year) {
    if (year < 1900) {
        const t = year - 1860;

        return 7.62 + 0.5737 * t - 0.251754 * t ** 2 + 0.01680668 * t ** 3 - 0.0004473624 * t ** 4 + t ** 5 / 233174;
    }

    if (year < 1920) {
        const t = year - 1900;

        return -2.79 + 1.494119 * t - 0.0598939 * t ** 2 + 0.0061966 * t ** 3 - 0.000197 * t ** 4;
    }

    if (year < 1941) {
        const t = year - 1920;

        return 21.2 + 0.84493 * t - 0.0761 * t ** 2 + 0.0020936 * t ** 3;
    }

    if (year < 1961) {
        const t = year - 1950;

        return 29.07 + 0.407 * t - t ** 2 / 233 + t ** 3 / 2547;
    }

    if (year < 1986) {
        const t = year - 1975;

        return 45.45 + 1.067 * t - t ** 2 / 260 - t ** 3 / 718;
    }

    if (year < 2005) {
        const t = year - 2000;

        return 63.86 + 0.3345 * t - 0.060374 * t ** 2 + 0.0017275 * t ** 3 + 0.000651814 * t ** 4 + 0.00002373599 * t ** 5;
    }

    if (year < 2050) {
        const t = year - 2000;

        return 62.92 + 0.32217 * t + 0.005589 * t ** 2;
    }

    return -20 + 32 * ((year - 1820) / 100) ** 2 - 0.5628 * (2150 - year);
}

const NEW = [
    [-0.4072, 0, 0, 1, 0], [0.17241, 1, 1, 0, 0], [0.01608, 0, 0, 2, 0], [0.01039, 0, 0, 0, 2], [0.00739, 1, -1, 1, 0], [-0.00514, 1, 1, 1, 0],
    [0.00208, 2, 2, 0, 0], [-0.00111, 0, 0, 1, -2], [-0.00057, 0, 0, 1, 2], [0.00056, 1, 1, 2, 0], [-0.00042, 0, 0, 3, 0], [0.00042, 1, 1, 0, 2],
    [0.00038, 1, 1, 0, -2], [-0.00024, 1, -1, 2, 0], [-0.00007, 0, 2, 1, 0], [0.00004, 0, 0, 2, -2], [0.00004, 0, 3, 0, 0], [0.00003, 0, 1, 1, -2],
    [0.00003, 0, 0, 2, 2], [-0.00003, 0, 1, 1, 2], [0.00003, 0, -1, 1, 2], [-0.00002, 0, -1, 1, -2], [-0.00002, 0, 1, 3, 0], [0.00002, 0, 0, 4, 0],
];
const FULL = [
    [-0.40614, 0, 0, 1, 0], [0.17302, 1, 1, 0, 0], [0.01614, 0, 0, 2, 0], [0.01043, 0, 0, 0, 2], [0.00734, 1, -1, 1, 0], [-0.00515, 1, 1, 1, 0],
    [0.00209, 2, 2, 0, 0], [-0.00111, 0, 0, 1, -2], [-0.00057, 0, 0, 1, 2], [0.00056, 1, 1, 2, 0], [-0.00042, 0, 0, 3, 0], [0.00042, 1, 1, 0, 2],
    [0.00038, 1, 1, 0, -2], [-0.00024, 1, -1, 2, 0], [-0.00007, 0, 2, 1, 0], [0.00004, 0, 0, 2, -2], [0.00004, 0, 3, 0, 0], [0.00003, 0, 1, 1, -2],
    [0.00003, 0, 0, 2, 2], [-0.00003, 0, 1, 1, 2], [0.00003, 0, -1, 1, 2], [-0.00002, 0, -1, 1, -2], [-0.00002, 0, 1, 3, 0], [0.00002, 0, 0, 4, 0],
];
const QUARTER = [
    [-0.62801, 0, 0, 1, 0], [0.17172, 1, 1, 0, 0], [-0.01183, 1, 1, 1, 0], [0.00862, 0, 0, 2, 0], [0.00804, 0, 0, 0, 2], [0.00454, 1, -1, 1, 0],
    [0.00204, 2, 2, 0, 0], [-0.0018, 0, 0, 1, -2], [-0.0007, 0, 0, 1, 2], [-0.0004, 0, 0, 3, 0], [-0.00034, 1, -1, 2, 0], [0.00032, 1, 1, 0, 2],
    [0.00032, 1, 1, 0, -2], [-0.00028, 2, 2, 1, 0], [0.00027, 1, 1, 2, 0], [-0.00005, 0, -1, 1, -2], [0.00004, 0, 0, 2, 2], [-0.00004, 0, 1, 1, 2],
    [0.00004, 0, -2, 1, 0], [0.00003, 0, 1, 1, -2], [0.00003, 0, 3, 0, 0], [0.00002, 0, 0, 2, -2], [0.00002, 0, -1, 1, 2], [-0.00002, 0, 1, 3, 0],
];
const PLANETARY = [
    [0.000325, 299.77, 0.107408, -0.009173], [0.000165, 251.88, 0.016321, 0], [0.000164, 251.83, 26.651886, 0], [0.000126, 349.42, 36.412478, 0],
    [0.00011, 84.66, 18.206239, 0], [0.000062, 141.74, 53.303771, 0], [0.00006, 207.14, 2.453732, 0], [0.000056, 154.84, 7.30686, 0],
    [0.000047, 34.52, 27.261239, 0], [0.000042, 207.19, 0.121824, 0], [0.00004, 291.34, 1.844379, 0], [0.000037, 161.72, 24.198154, 0],
    [0.000035, 239.56, 25.513099, 0], [0.000023, 331.55, 3.592518, 0],
];

/**
 * Julian Ephemeris Day of lunar phase k (Meeus ch. 49): k integer = new moon, +0.25 first quarter, +0.5 full, +0.75 last quarter.
 * Each term is [coefficient, power of E, multiple of M, multiple of M′, multiple of F]; the sin Ω term is added separately.
 */
export function phaseJde(k) {
    const T = k / 1236.85;
    const E = 1 - 0.002516 * T - 0.0000074 * T * T;
    const M = 2.5534 + 29.1053567 * k - 0.0000014 * T * T - 0.00000011 * T ** 3;
    const Mp = 201.5643 + 385.81693528 * k + 0.0107582 * T * T + 0.00001238 * T ** 3 - 0.000000058 * T ** 4;
    const F = 160.7108 + 390.67050284 * k - 0.0016118 * T * T - 0.00000227 * T ** 3 + 0.000000011 * T ** 4;
    const Omega = 124.7746 - 1.56375588 * k + 0.0020672 * T * T + 0.00000215 * T ** 3;
    let jde = 2451550.09766 + SYNODIC_MONTH * k + 0.00015437 * T * T - 0.00000015 * T ** 3 + 0.00000000073 * T ** 4;
    const fraction = Math.round((k - Math.floor(k)) * 4) / 4;
    const terms = fraction === 0 ? NEW : fraction === 0.5 ? FULL : QUARTER;

    terms.forEach(([c, e, m, mp, f]) => {
        jde += c * E ** e * sin(m * M + mp * Mp + f * F);
    });
    jde += -0.00017 * sin(Omega);

    if (fraction === 0.25 || fraction === 0.75) {
        const W = 0.00306 - 0.00038 * E * cos(M) + 0.00026 * cos(Mp) - 0.00002 * cos(Mp - M) + 0.00002 * cos(Mp + M) + 0.00002 * cos(2 * F);
        jde += fraction === 0.25 ? W : -W;
    }

    PLANETARY.forEach(([c, a, b, t2]) => {
        jde += c * sin(a + b * k + t2 * T * T);
    });

    return jde;
}

/**
 * The phase as a UT Julian Day.
 */
export function phaseJd(k) {
    const jde = phaseJde(k);
    const year = 2000 + (jde - 2451545) / 365.25;

    return jde - deltaT(year) / 86400;
}

/**
 * Illuminated fraction and phase angle of the Moon (Meeus ch. 48, low-precision phase angle from D, M, M′).
 */
export function illumination(jd) {
    const T = (jd - 2451545) / 36525;
    const D = norm(297.8501921 + 445267.1114034 * T - 0.0018819 * T * T + T ** 3 / 545868 - T ** 4 / 113065000);
    const M = norm(357.5291092 + 35999.0502909 * T - 0.0001536 * T * T + T ** 3 / 24490000);
    const Mp = norm(134.9633964 + 477198.8675055 * T + 0.0087414 * T * T + T ** 3 / 69699 - T ** 4 / 14712000);
    const i = 180 - D - 6.289 * sin(Mp) + 2.1 * sin(M) - 1.274 * sin(2 * D - Mp) - 0.658 * sin(2 * D) - 0.214 * sin(2 * Mp) - 0.11 * sin(D);

    return { fraction: (1 + cos(i)) / 2, waxing: norm(D) < 180, elongation: D };
}

/**
 * Phases around a moment: the last new moon before it and the next new, first quarter, full and last quarter after it.
 */
export function moonAt(jd) {
    const year = 2000 + (jd - 2451545) / 365.25;
    let k = Math.floor((year - 2000) * 12.3685) - 2;

    while (phaseJd(k + 1) <= jd) {
        k += 1;
    }

    while (phaseJd(k) > jd) {
        k -= 1;
    }

    const next = {};
    [['first', 0.25], ['full', 0.5], ['last', 0.75], ['new', 1], ['first', 1.25], ['full', 1.5], ['last', 1.75]].forEach(([name, offset]) => {
        const when = phaseJd(k + offset);

        if (when > jd && next[name] === undefined) {
            next[name] = when;
        }
    });

    const lit = illumination(jd);
    const age = jd - phaseJd(k);

    return { previousNew: phaseJd(k), age, next, ...lit };
}

/**
 * Name of the phase from the Moon's age and the illuminated fraction (principal phases get ±1 day).
 */
export function phaseName(age, fraction, waxing) {
    if (age < 1 || age > SYNODIC_MONTH - 1) {
        return 'New Moon';
    }

    if (Math.abs(fraction - 1) < 0.02 || Math.abs(age - SYNODIC_MONTH / 2) < 1) {
        return 'Full Moon';
    }

    if (Math.abs(fraction - 0.5) < 0.035) {
        return waxing ? 'First Quarter' : 'Last Quarter';
    }

    if (waxing) {
        return fraction < 0.5 ? 'Waxing Crescent' : 'Waxing Gibbous';
    }

    return fraction < 0.5 ? 'Waning Crescent' : 'Waning Gibbous';
}

/**
 * Greenwich mean sidereal time in degrees (IAU 2006: Earth rotation angle plus the precession polynomial).
 * UT1 is taken as UTC (within 0.9 s) and TT as UT + ΔT.
 */
export function gmst(jd) {
    const du = jd - 2451545;
    const era = 360 * (0.779057273264 + 0.00273781191135448 * du + (du % 1));
    const t = (jd + deltaT(2000 + du / 365.25) / 86400 - 2451545) / 36525;
    const poly = (0.014506 + 4612.156534 * t + 1.3915817 * t * t - 0.00000044 * t ** 3 - 0.000029956 * t ** 4 - 0.0000000368 * t ** 5) / 3600;

    return norm(era + poly);
}

/**
 * Equation of the equinoxes in degrees from the main nutation terms (Meeus ch. 22, accurate to about 0.5″).
 */
export function equationOfEquinoxes(jd) {
    const T = (jd - 2451545) / 36525;
    const omega = 125.04452 - 1934.136261 * T;
    const L = 280.4665 + 36000.7698 * T;
    const Lp = 218.3165 + 481267.8813 * T;
    const dPsi = -17.2 * sin(omega) - 1.32 * sin(2 * L) - 0.23 * sin(2 * Lp) + 0.21 * sin(2 * omega);
    const eps = 23.43929111 - 0.013004167 * T + 0.00256 * cos(omega);

    return (dPsi * cos(eps)) / 3600;
}

/**
 * Degrees → hours, minutes and seconds text.
 */
export function hms(deg) {
    const hours = norm(deg) / 15;
    const h = Math.floor(hours);
    const m = Math.floor((hours - h) * 60);
    const s = ((hours - h) * 60 - m) * 60;

    return `${h}h ${String(m).padStart(2, '0')}m ${s.toFixed(2).padStart(5, '0')}s`;
}
