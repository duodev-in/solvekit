/**
 * Solar position: NOAA Solar Calculator algorithm (Meeus, Astronomical Algorithms, ch. 25).
 * Accurate to about 0.01° in position and about a minute in rise and set times between 1800 and 2100.
 */
const R = Math.PI / 180;
const sind = (x) => Math.sin(x * R);
const cosd = (x) => Math.cos(x * R);

/** Julian day from a UTC calendar date and fractional hours. */
export function julianDay(y, m, d, hours = 0) {
    let Y = y;
    let M = m;

    if (M <= 2) {
        Y -= 1;
        M += 12;
    }

    const A = Math.floor(Y / 100);
    const B = 2 - A + Math.floor(A / 4);

    return Math.floor(365.25 * (Y + 4716)) + Math.floor(30.6001 * (M + 1)) + d + B - 1524.5 + hours / 24;
}

/** Sun's declination (°) and equation of time (minutes) at a Julian day. */
export function sunCoordinates(jd) {
    const T = (jd - 2451545) / 36525;
    const L0 = (280.46646 + T * (36000.76983 + 0.0003032 * T)) % 360;
    const M = 357.52911 + T * (35999.05029 - 0.0001537 * T);
    const e = 0.016708634 - T * (0.000042037 + 0.0000001267 * T);
    const C = sind(M) * (1.914602 - T * (0.004817 + 0.000014 * T)) + sind(2 * M) * (0.019993 - 0.000101 * T) + sind(3 * M) * 0.000289;
    const omega = 125.04 - 1934.136 * T;
    const lambda = L0 + C - 0.00569 - 0.00478 * sind(omega);
    const eps0 = 23 + (26 + (21.448 - T * (46.815 + T * (0.00059 - T * 0.001813))) / 60) / 60;
    const eps = eps0 + 0.00256 * cosd(omega);
    const decl = Math.asin(sind(eps) * sind(lambda)) / R;
    const y = Math.tan((eps / 2) * R) ** 2;
    const eot = 4 * (y * sind(2 * L0) - 2 * e * sind(M) + 4 * e * y * sind(M) * cosd(2 * L0) - 0.5 * y * y * sind(4 * L0) - 1.25 * e * e * sind(2 * M)) / R;
    const dist = (1.000001018 * (1 - e * e)) / (1 + e * cosd(M + C));

    return { decl, eot, dist };
}

/** Atmospheric refraction (°) for an apparent elevation, NOAA approximation. */
function refraction(el) {
    if (el > 85) {
        return 0;
    }

    const t = Math.tan(el * R);
    const arcsec = el > 5 ? 58.1 / t - 0.07 / t ** 3 + 0.000086 / t ** 5 : el > -0.575 ? 1735 + el * (-518.2 + el * (103.4 + el * (-12.79 + el * 0.711))) : -20.772 / t;

    return arcsec / 3600;
}

/** Elevation (° with refraction), azimuth (° from north), hour angle at a place and UTC moment. */
export function sunPosition(lat, lon, y, m, d, utcHours) {
    const { decl, eot, dist } = sunCoordinates(julianDay(y, m, d, utcHours));
    const tst = (((utcHours * 60 + eot + 4 * lon) % 1440) + 1440) % 1440;
    const ha = tst / 4 - 180;
    const cz = Math.min(1, Math.max(-1, sind(lat) * sind(decl) + cosd(lat) * cosd(decl) * cosd(ha)));
    const zen = Math.acos(cz) / R;
    const az0 = Math.acos(Math.min(1, Math.max(-1, (sind(lat) * cz - sind(decl)) / (cosd(lat) * Math.sin(zen * R))))) / R;
    const az = ha > 0 ? (az0 + 180) % 360 : (540 - az0) % 360;
    const geo = 90 - zen;

    return { elevation: geo + refraction(geo), geometric: geo, azimuth: az, decl, eot, ha, dist };
}

/** Sunrise, solar noon and sunset in UTC hours for a date (null when the sun does not rise or set). */
export function sunTimes(lat, lon, y, m, d, zenith = 90.833) {
    const at = (utc) => sunCoordinates(julianDay(y, m, d, utc));
    let noon = 12 - lon / 15 - at(12).eot / 60;
    noon = 12 - lon / 15 - at(noon).eot / 60;
    const event = (sign) => {
        let t = noon;

        for (let k = 0; k < 3; k += 1) {
            const { decl, eot } = at(t);
            const c = cosd(zenith) / (cosd(lat) * cosd(decl)) - Math.tan(lat * R) * Math.tan(decl * R);

            if (c > 1 || c < -1) {
                return { none: c > 1 ? 'down' : 'up' };
            }

            const ha = Math.acos(c) / R;
            t = 12 - lon / 15 - eot / 60 + (sign * ha) / 15;
        }

        return { t };
    };

    return { noon, rise: event(-1), set: event(1), decl: at(noon).decl };
}

/** "06:42" from fractional hours (wrapped into one day). */
export function clock(hours) {
    const h = ((hours % 24) + 24) % 24;
    let hh = Math.floor(h);
    let mm = Math.round((h - hh) * 60);

    if (mm === 60) {
        hh = (hh + 1) % 24;
        mm = 0;
    }

    return `${String(hh).padStart(2, '0')}:${String(mm).padStart(2, '0')}`;
}
