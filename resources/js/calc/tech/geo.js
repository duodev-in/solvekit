/**
 * Geodesy and calendars: Vincenty (1975) distance and bearings on the WGS-84 ellipsoid (with the haversine
 * sphere for comparison), antipodes; Easter by the Gregorian and Julian computus; the Mayan calendar (GMT
 * correlation 584283); equinoxes and solstices (Meeus, Astronomical Algorithms, 2nd ed., ch. 27); daylight-saving
 * rules; and Julian Day Numbers.
 */

const D2R = Math.PI / 180;
const WGS84 = { a: 6378137, f: 1 / 298.257223563 };
export const EARTH_MEAN_RADIUS = 6371008.8;

/** Parses "51.5074", "51°30′26″N", "51 30 26 N", "-0.1278" into decimal degrees (null if unreadable). */
export function parseAngle(text, isLat) {
    const s = String(text ?? '').trim().toUpperCase().replace(/[°º′'″"]/g, ' ').replace(/,/g, '.');
    const m = s.match(/^([+-]?\d+(?:\.\d+)?)(?:\s+(\d+(?:\.\d+)?))?(?:\s+(\d+(?:\.\d+)?))?\s*([NSEW])?$/);

    if (!m) {
        return null;
    }

    let v = Math.abs(Number(m[1])) + Number(m[2] ?? 0) / 60 + Number(m[3] ?? 0) / 3600;

    if (m[1].startsWith('-') || m[4] === 'S' || m[4] === 'W') {
        v = -v;
    }

    if ((isLat && (m[4] === 'E' || m[4] === 'W')) || (!isLat && (m[4] === 'N' || m[4] === 'S'))) {
        return null;
    }

    return Math.abs(v) <= (isLat ? 90 : 180) ? v : null;
}

/** Degrees → "51° 30′ 26.6″ N". */
export function dms(v, isLat) {
    const a = Math.abs(v);
    const d = Math.floor(a);
    const m = Math.floor((a - d) * 60);
    const s = (a - d - m / 60) * 3600;

    return `${d}° ${m}′ ${s.toFixed(1)}″ ${isLat ? (v >= 0 ? 'N' : 'S') : v >= 0 ? 'E' : 'W'}`;
}

/** Great-circle distance on a sphere (haversine). */
export function haversine(lat1, lon1, lat2, lon2, R = EARTH_MEAN_RADIUS) {
    const dLat = (lat2 - lat1) * D2R;
    const dLon = (lon2 - lon1) * D2R;
    const h = Math.sin(dLat / 2) ** 2 + Math.cos(lat1 * D2R) * Math.cos(lat2 * D2R) * Math.sin(dLon / 2) ** 2;

    return 2 * R * Math.asin(Math.min(1, Math.sqrt(h)));
}

/**
 * Vincenty's inverse formula on WGS-84: distance (m), initial and final bearings (°). Returns null when the
 * iteration does not converge (nearly antipodal points).
 */
export function vincenty(lat1, lon1, lat2, lon2) {
    const { a, f } = WGS84;
    const b = a * (1 - f);
    const L = (lon2 - lon1) * D2R;
    const U1 = Math.atan((1 - f) * Math.tan(lat1 * D2R));
    const U2 = Math.atan((1 - f) * Math.tan(lat2 * D2R));
    const [sinU1, cosU1, sinU2, cosU2] = [Math.sin(U1), Math.cos(U1), Math.sin(U2), Math.cos(U2)];
    let lambda = L;
    let iter = 0;
    let sinSigma;
    let cosSigma;
    let sigma;
    let cosSqAlpha;
    let cos2SigmaM;
    let sinLambda;
    let cosLambda;

    do {
        sinLambda = Math.sin(lambda);
        cosLambda = Math.cos(lambda);
        sinSigma = Math.sqrt((cosU2 * sinLambda) ** 2 + (cosU1 * sinU2 - sinU1 * cosU2 * cosLambda) ** 2);

        if (sinSigma === 0) {
            return { distance: 0, initial: 0, final: 0 };
        }

        cosSigma = sinU1 * sinU2 + cosU1 * cosU2 * cosLambda;
        sigma = Math.atan2(sinSigma, cosSigma);
        const sinAlpha = (cosU1 * cosU2 * sinLambda) / sinSigma;
        cosSqAlpha = 1 - sinAlpha * sinAlpha;
        cos2SigmaM = cosSqAlpha !== 0 ? cosSigma - (2 * sinU1 * sinU2) / cosSqAlpha : 0;
        const C = (f / 16) * cosSqAlpha * (4 + f * (4 - 3 * cosSqAlpha));
        const prev = lambda;
        lambda = L + (1 - C) * f * sinAlpha * (sigma + C * sinSigma * (cos2SigmaM + C * cosSigma * (-1 + 2 * cos2SigmaM * cos2SigmaM)));

        if (Math.abs(lambda - prev) < 1e-12) {
            break;
        }

        iter += 1;
    } while (iter < 1000);

    if (iter >= 1000) {
        return null;
    }

    const uSq = (cosSqAlpha * (a * a - b * b)) / (b * b);
    const A = 1 + (uSq / 16384) * (4096 + uSq * (-768 + uSq * (320 - 175 * uSq)));
    const B = (uSq / 1024) * (256 + uSq * (-128 + uSq * (74 - 47 * uSq)));
    const deltaSigma = B * sinSigma * (cos2SigmaM + (B / 4) * (cosSigma * (-1 + 2 * cos2SigmaM * cos2SigmaM) - (B / 6) * cos2SigmaM * (-3 + 4 * sinSigma * sinSigma) * (-3 + 4 * cos2SigmaM * cos2SigmaM)));
    const distance = b * A * (sigma - deltaSigma);
    const initial = Math.atan2(cosU2 * sinLambda, cosU1 * sinU2 - sinU1 * cosU2 * cosLambda) / D2R;
    const final = Math.atan2(cosU1 * sinLambda, -sinU1 * cosU2 + cosU1 * sinU2 * cosLambda) / D2R;

    return { distance, initial: (initial + 360) % 360, final: (final + 360) % 360 };
}

/** Spherical midpoint of two points. */
export function midpoint(lat1, lon1, lat2, lon2) {
    const [p1, p2, dl] = [lat1 * D2R, lat2 * D2R, (lon2 - lon1) * D2R];
    const bx = Math.cos(p2) * Math.cos(dl);
    const by = Math.cos(p2) * Math.sin(dl);
    const lat = Math.atan2(Math.sin(p1) + Math.sin(p2), Math.sqrt((Math.cos(p1) + bx) ** 2 + by * by));
    const lon = lon1 * D2R + Math.atan2(by, Math.cos(p1) + bx);

    return [lat / D2R, ((lon / D2R + 540) % 360) - 180];
}

export const antipode = (lat, lon) => [-lat, lon > 0 ? lon - 180 : lon + 180];

export const COMPASS = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW'];
export const compass = (deg) => COMPASS[Math.round(deg / 22.5) % 16];

/** Julian Day Number of a Gregorian date (noon). */
export function jdn(y, m, d) {
    const a = Math.floor((14 - m) / 12);
    const yy = y + 4800 - a;
    const mm = m + 12 * a - 3;

    return d + Math.floor((153 * mm + 2) / 5) + 365 * yy + Math.floor(yy / 4) - Math.floor(yy / 100) + Math.floor(yy / 400) - 32045;
}

/** Gregorian date from a JDN. */
export function fromJdn(J) {
    const a = J + 32044;
    const b = Math.floor((4 * a + 3) / 146097);
    const c = a - Math.floor((146097 * b) / 4);
    const d = Math.floor((4 * c + 3) / 1461);
    const e = c - Math.floor((1461 * d) / 4);
    const m = Math.floor((5 * e + 2) / 153);

    return { y: 100 * b + d - 4800 + Math.floor(m / 10), m: m + 3 - 12 * Math.floor(m / 10), d: e - Math.floor((153 * m + 2) / 5) + 1 };
}

/** Western (Gregorian) Easter: the anonymous Gregorian algorithm (Meeus/Jones/Butcher). */
export function easterGregorian(Y) {
    const a = Y % 19;
    const b = Math.floor(Y / 100);
    const c = Y % 100;
    const d = Math.floor(b / 4);
    const e = b % 4;
    const f = Math.floor((b + 8) / 25);
    const g = Math.floor((b - f + 1) / 3);
    const h = (19 * a + b - d - g + 15) % 30;
    const i = Math.floor(c / 4);
    const k = c % 4;
    const l = (32 + 2 * e + 2 * i - h - k) % 7;
    const m = Math.floor((a + 11 * h + 22 * l) / 451);
    const month = Math.floor((h + l - 7 * m + 114) / 31);

    return { y: Y, m: month, d: ((h + l - 7 * m + 114) % 31) + 1 };
}

/** Orthodox Easter: Julian computus (Meeus), given as a Gregorian date. */
export function easterOrthodox(Y) {
    const a = Y % 4;
    const b = Y % 7;
    const c = Y % 19;
    const d = (19 * c + 15) % 30;
    const e = (2 * a + 4 * b - d + 34) % 7;
    const month = Math.floor((d + e + 114) / 31);
    const day = ((d + e + 114) % 31) + 1;
    // Julian calendar date → JDN, then to Gregorian.
    const aa = Math.floor((14 - month) / 12);
    const yy = Y + 4800 - aa;
    const mm = month + 12 * aa - 3;
    const J = day + Math.floor((153 * mm + 2) / 5) + 365 * yy + Math.floor(yy / 4) - 32083;

    return fromJdn(J);
}

export const MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
export const WEEKDAYS = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
export const weekday = (y, m, d) => WEEKDAYS[(jdn(y, m, d) + 1) % 7];
export const dateText = ({ y, m, d }) => `${d} ${MONTHS[m - 1]} ${y}`;

/** Adds days to a date. */
export const addDays = ({ y, m, d }, n) => fromJdn(jdn(y, m, d) + n);

/** Mayan calendar from a Gregorian date (GMT correlation 584283). */
const TZOLKIN = ['Imix', 'Ik’', 'Ak’b’al', 'K’an', 'Chikchan', 'Kimi', 'Manik’', 'Lamat', 'Muluk', 'Ok', 'Chuwen', 'Eb’', 'B’en', 'Ix', 'Men', 'K’ib’', 'Kab’an', 'Etz’nab’', 'Kawak', 'Ajaw'];
const HAAB = ['Pop', 'Wo’', 'Sip', 'Sotz’', 'Sek', 'Xul', 'Yaxk’in', 'Mol', 'Ch’en', 'Yax', 'Sak’', 'Keh', 'Mak', 'K’ank’in', 'Muwan', 'Pax', 'K’ayab', 'Kumk’u', 'Wayeb’'];
export const MAYA_CORRELATION = 584283;

export function maya(J) {
    const days = J - MAYA_CORRELATION;
    const mod = (x, n) => ((x % n) + n) % n;
    const lc = [Math.floor(days / 144000), Math.floor(mod(days, 144000) / 7200), Math.floor(mod(days, 7200) / 360), Math.floor(mod(days, 360) / 20), mod(days, 20)];
    const haab = mod(days + 348, 365);

    return { days, longCount: lc.join('.'), tzolkin: `${mod(days + 3, 13) + 1} ${TZOLKIN[mod(days + 19, 20)]}`, haab: `${haab % 20} ${HAAB[Math.floor(haab / 20)]}`, lord: `G${mod(days + 8, 9) + 1}` };
}

/** Days from the Mayan Long Count back to a JDN. */
export function fromLongCount(text) {
    const parts = String(text ?? '').trim().split('.').map(Number);

    if (parts.length !== 5 || !parts.every(Number.isInteger) || parts[1] > 19 || parts[2] > 19 || parts[3] > 17 || parts[4] > 19) {
        return null;
    }

    return MAYA_CORRELATION + parts[0] * 144000 + parts[1] * 7200 + parts[2] * 360 + parts[3] * 20 + parts[4];
}

/** ΔT = TT − UT in seconds (Espenak & Meeus 2006 polynomials, 1941–2150). */
export function deltaT(year) {
    if (year < 1961) {
        const t = year - 1950;

        return 29.07 + 0.407 * t - (t * t) / 233 + t ** 3 / 2547;
    }

    if (year < 1986) {
        const t = year - 1975;

        return 45.45 + 1.067 * t - (t * t) / 260 - t ** 3 / 718;
    }

    if (year < 2005) {
        const t = year - 2000;

        return 63.86 + 0.3345 * t - 0.060374 * t * t + 0.0017275 * t ** 3 + 0.000651814 * t ** 4 + 0.00002373599 * t ** 5;
    }

    if (year < 2050) {
        const t = year - 2000;

        return 62.92 + 0.32217 * t + 0.005589 * t * t;
    }

    const u = (year - 1820) / 100;

    return -20 + 32 * u * u - 0.5628 * (2150 - year);
}

const SEASON_TERMS = [[485, 324.96, 1934.136], [203, 337.23, 32964.467], [199, 342.08, 20.186], [182, 27.85, 445267.112], [156, 73.14, 45036.886], [136, 171.52, 22518.443], [77, 222.54, 65928.934], [74, 296.72, 3034.906], [70, 243.58, 9037.513], [58, 119.81, 33718.147], [52, 297.17, 150.678], [50, 21.02, 2281.226], [45, 247.54, 29929.562], [44, 325.15, 31555.956], [29, 60.93, 4443.417], [18, 155.12, 67555.328], [17, 288.79, 4562.452], [16, 198.04, 62894.029], [14, 199.76, 31436.921], [12, 95.39, 14577.848], [12, 287.11, 31931.756], [12, 320.81, 34777.259], [9, 227.73, 1222.114], [8, 15.45, 16859.074]];
const SEASON_MEAN = [[2451623.80984, 365242.37404, 0.05169, -0.00411, -0.00057], [2451716.56767, 365241.62603, 0.00325, 0.00888, -0.0003], [2451810.21715, 365242.01767, -0.11575, 0.00337, 0.00078], [2451900.05952, 365242.74049, -0.06223, -0.00823, 0.00032]];

/** Equinox or solstice (0 March, 1 June, 2 September, 3 December) for years 1000–3000, as a UTC Julian Day. */
export function season(year, which) {
    const Y = (year - 2000) / 1000;
    const c = SEASON_MEAN[which];
    const jde0 = c[0] + c[1] * Y + c[2] * Y * Y + c[3] * Y ** 3 + c[4] * Y ** 4;
    const T = (jde0 - 2451545) / 36525;
    const W = (35999.373 * T - 2.47) * D2R;
    const dl = 1 + 0.0334 * Math.cos(W) + 0.0007 * Math.cos(2 * W);
    const S = SEASON_TERMS.reduce((sum, [A, B, C]) => sum + A * Math.cos((B + C * T) * D2R), 0);
    const jde = jde0 + (0.00001 * S) / dl;

    return jde - deltaT(year) / 86400;
}

/** UTC calendar date and time from a Julian Day. */
export function fromJd(jd) {
    const J = Math.floor(jd + 0.5);
    const frac = jd + 0.5 - J;
    const date = fromJdn(J);
    const minutes = Math.round(frac * 1440);

    return { ...date, minutes, text: `${dateText(date)}, ${String(Math.floor(minutes / 60) % 24).padStart(2, '0')}:${String(minutes % 60).padStart(2, '0')} UTC` };
}

/** The n-th (1-based, or -1 = last) given weekday (0 = Sunday) of a month. */
export function nthWeekday(y, m, weekdayIndex, n) {
    if (n > 0) {
        const first = (jdn(y, m, 1) + 1) % 7;

        return 1 + ((weekdayIndex - first + 7) % 7) + 7 * (n - 1);
    }

    const days = new Date(Date.UTC(y, m, 0)).getUTCDate();
    const last = (jdn(y, m, days) + 1) % 7;

    return days - ((last - weekdayIndex + 7) % 7);
}
