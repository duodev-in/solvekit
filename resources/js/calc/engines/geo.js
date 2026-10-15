/**
 * Geographic coordinates on the WGS84 ellipsoid: UTM (Krüger series, accurate to well under a
 * millimeter inside a zone), MGRS, Open Location Code (Plus Codes), Maidenhead, Geohash and
 * degrees/minutes/seconds. Pure functions; no DOM.
 */
const A = 6378137;
const F = 1 / 298.257223563;
const K0 = 0.9996;
const N = F / (2 - F);
const A_HAT = (A / (1 + N)) * (1 + N ** 2 / 4 + N ** 4 / 64);
const ALPHA = [
    N / 2 - (2 / 3) * N ** 2 + (5 / 16) * N ** 3,
    (13 / 48) * N ** 2 - (3 / 5) * N ** 3,
    (61 / 240) * N ** 3,
];
const BETA = [
    N / 2 - (2 / 3) * N ** 2 + (37 / 96) * N ** 3,
    (1 / 48) * N ** 2 + (1 / 15) * N ** 3,
    (17 / 480) * N ** 3,
];
const DELTA = [
    2 * N - (2 / 3) * N ** 2 - 2 * N ** 3,
    (7 / 3) * N ** 2 - (8 / 5) * N ** 3,
    (56 / 15) * N ** 3,
];
const BANDS = 'CDEFGHJKLMNPQRSTUVWX';
const RAD = Math.PI / 180;

export function utmZone(lat, lon) {
    // +180° is the eastern edge of zone 60 (normalizing would move it to −180°, zone 1).
    if (lon === 180) {
        return 60;
    }

    const normalized = ((((lon + 180) % 360) + 360) % 360) - 180;
    let zone = Math.floor((normalized + 180) / 6) + 1;

    if (zone > 60) {
        zone = 60;
    }

    // Norway: zone 32 is widened over the west coast.
    if (lat >= 56 && lat < 64 && normalized >= 3 && normalized < 12) {
        zone = 32;
    }

    // Svalbard: zones 31, 33, 35 and 37 are widened; 32, 34 and 36 are not used.
    if (lat >= 72 && lat < 84) {
        if (normalized >= 0 && normalized < 9) zone = 31;
        else if (normalized >= 9 && normalized < 21) zone = 33;
        else if (normalized >= 21 && normalized < 33) zone = 35;
        else if (normalized >= 33 && normalized < 42) zone = 37;
    }

    return zone;
}

export function latitudeBand(lat) {
    if (lat < -80 || lat > 84) {
        return null;
    }

    // Band X covers 72° to 84° (12° tall); the others are 8°.
    return BANDS[Math.min(Math.floor((lat + 80) / 8), 19)];
}

/**
 * Latitude/longitude in decimal degrees → UTM. Valid from 80°S to 84°N.
 */
export function toUtm(lat, lon, forcedZone) {
    if (lat < -80 || lat > 84) {
        return null;
    }

    const zone = forcedZone ?? utmZone(lat, lon);
    const centralMeridian = (zone - 1) * 6 - 180 + 3;
    const phi = lat * RAD;
    const lambda = (lon - centralMeridian) * RAD;
    const e = Math.sqrt(F * (2 - F));
    const t = Math.sinh(Math.atanh(Math.sin(phi)) - e * Math.atanh(e * Math.sin(phi)));
    const xiPrime = Math.atan2(t, Math.cos(lambda));
    const etaPrime = Math.atanh(Math.sin(lambda) / Math.sqrt(1 + t * t));

    let xi = xiPrime;
    let eta = etaPrime;
    ALPHA.forEach((alpha, index) => {
        const j = 2 * (index + 1);
        xi += alpha * Math.sin(j * xiPrime) * Math.cosh(j * etaPrime);
        eta += alpha * Math.cos(j * xiPrime) * Math.sinh(j * etaPrime);
    });

    const easting = 500000 + K0 * A_HAT * eta;
    let northing = K0 * A_HAT * xi;

    if (lat < 0) {
        northing += 10000000;
    }

    return { zone, band: latitudeBand(lat), hemisphere: lat < 0 ? 'S' : 'N', easting, northing, centralMeridian };
}

/**
 * UTM → latitude/longitude in decimal degrees.
 */
export function fromUtm(zone, hemisphere, easting, northing) {
    const xi = (northing - (hemisphere === 'S' ? 10000000 : 0)) / (K0 * A_HAT);
    const eta = (easting - 500000) / (K0 * A_HAT);

    let xiPrime = xi;
    let etaPrime = eta;
    BETA.forEach((beta, index) => {
        const j = 2 * (index + 1);
        xiPrime -= beta * Math.sin(j * xi) * Math.cosh(j * eta);
        etaPrime -= beta * Math.cos(j * xi) * Math.sinh(j * eta);
    });

    const chi = Math.asin(Math.sin(xiPrime) / Math.cosh(etaPrime));
    let phi = chi;
    DELTA.forEach((delta, index) => {
        phi += delta * Math.sin(2 * (index + 1) * chi);
    });

    const centralMeridian = (zone - 1) * 6 - 180 + 3;
    const lambda = Math.atan2(Math.sinh(etaPrime), Math.cos(xiPrime));

    return { lat: phi / RAD, lon: centralMeridian + lambda / RAD };
}

const MGRS_COLUMNS = ['ABCDEFGH', 'JKLMNPQR', 'STUVWXYZ'];
const MGRS_ROWS = 'ABCDEFGHJKLMNPQRSTUV';

/**
 * MGRS reference, e.g. "18T WL 83959 07350" at 1 m precision.
 */
export function toMgrs(lat, lon, digits = 5) {
    const utm = toUtm(lat, lon);

    if (!utm) {
        return null;
    }

    const column = MGRS_COLUMNS[(utm.zone - 1) % 3][Math.floor(utm.easting / 100000) - 1];
    const row = MGRS_ROWS[(Math.floor(utm.northing / 100000) + (utm.zone % 2 === 0 ? 5 : 0)) % 20];
    const scale = 10 ** (5 - digits);
    const pad = (value) => String(Math.floor((value % 100000) / scale)).padStart(digits, '0');

    return `${utm.zone}${utm.band} ${column}${row} ${pad(utm.easting)} ${pad(utm.northing)}`;
}

export function fromMgrs(text) {
    const match = String(text).toUpperCase().replace(/\s+/g, '').match(/^(\d{1,2})([C-HJ-NP-X])([A-HJ-NP-Z])([A-HJ-NP-V])(\d*)$/);

    if (!match || match[5].length % 2 !== 0 || match[5].length > 10) {
        return null;
    }

    const [, zoneText, band, column, row, digitsText] = match;
    const zone = Number(zoneText);
    const half = digitsText.length / 2;
    const scale = 10 ** (5 - half);
    const columnIndex = MGRS_COLUMNS[(zone - 1) % 3].indexOf(column);
    const rowIndex = (MGRS_ROWS.indexOf(row) - (zone % 2 === 0 ? 5 : 0) + 20) % 20;

    if (zone < 1 || zone > 60 || columnIndex < 0) {
        return null;
    }

    const easting = (columnIndex + 1) * 100000 + (half ? Number(digitsText.slice(0, half)) * scale : 0);
    let northing = rowIndex * 100000 + (half ? Number(digitsText.slice(half)) * scale : 0);

    // The row letters repeat every 2,000 km; use the latitude band to pick the right cycle.
    const bandSouth = BANDS.indexOf(band) * 8 - 80;
    const hemisphere = bandSouth < 0 ? 'S' : 'N';
    const minimum = toUtm(bandSouth, (zone - 1) * 6 - 180 + 3, zone).northing - 100000;

    while (northing < minimum) {
        northing += 2000000;
    }

    return { ...fromUtm(zone, hemisphere, easting, northing), zone, hemisphere, easting, northing };
}

const OLC_ALPHABET = '23456789CFGHJMPQRVWX';

/**
 * Open Location Code (Plus Code) with 10 digits, about 14 m × 14 m.
 */
export function toPlusCode(lat, lon) {
    const clippedLat = Math.min(Math.max(lat, -90), 90 - 1e-10);
    const normalizedLon = ((((lon + 180) % 360) + 360) % 360) - 180;
    // Round away floating-point noise before flooring, as the reference implementation does.
    let latValue = Math.floor(Math.round((clippedLat + 90) * 8000 * 1e6) / 1e6);
    let lonValue = Math.floor(Math.round((normalizedLon + 180) * 8000 * 1e6) / 1e6);
    const pairs = [];

    for (let index = 0; index < 5; index += 1) {
        pairs.unshift(OLC_ALPHABET[latValue % 20] + OLC_ALPHABET[lonValue % 20]);
        latValue = Math.floor(latValue / 20);
        lonValue = Math.floor(lonValue / 20);
    }

    const code = pairs.join('');

    return `${code.slice(0, 8)}+${code.slice(8)}`;
}

export function fromPlusCode(text) {
    const code = String(text).trim().toUpperCase().replace('+', '');

    if (!/^[23456789CFGHJMPQRVWX]{10}$/.test(code)) {
        return null;
    }

    let lat = -90;
    let lon = -180;
    let resolution = 20;

    for (let index = 0; index < 10; index += 2) {
        lat += OLC_ALPHABET.indexOf(code[index]) * resolution;
        lon += OLC_ALPHABET.indexOf(code[index + 1]) * resolution;
        resolution /= 20;
    }

    // Return the centre of the 1/8000° cell.
    return { lat: lat + resolution * 10, lon: lon + resolution * 10 };
}

export function toMaidenhead(lat, lon) {
    const adjustedLon = lon + 180;
    const adjustedLat = lat + 90;
    const letters = 'ABCDEFGHIJKLMNOPQRSTUVWX';

    return letters[Math.floor(adjustedLon / 20)]
        + letters[Math.floor(adjustedLat / 10)]
        + Math.floor((adjustedLon % 20) / 2)
        + Math.floor(adjustedLat % 10)
        + letters[Math.floor((adjustedLon % 2) * 12)].toLowerCase()
        + letters[Math.floor((adjustedLat % 1) * 24)].toLowerCase();
}

export function fromMaidenhead(text) {
    const locator = String(text).trim();

    if (!/^[A-R]{2}\d{2}([A-X]{2})?$/i.test(locator)) {
        return null;
    }

    const upper = locator.toUpperCase();
    let lon = (upper.charCodeAt(0) - 65) * 20 + Number(upper[2]) * 2 - 180;
    let lat = (upper.charCodeAt(1) - 65) * 10 + Number(upper[3]) - 90;

    if (upper.length === 6) {
        lon += (upper.charCodeAt(4) - 65) / 12 + 1 / 24;
        lat += (upper.charCodeAt(5) - 65) / 24 + 1 / 48;
    } else {
        lon += 1;
        lat += 0.5;
    }

    return { lat, lon };
}

const GEOHASH = '0123456789bcdefghjkmnpqrstuvwxyz';

export function toGeohash(lat, lon, precision = 9) {
    const latRange = [-90, 90];
    const lonRange = [-180, 180];
    let hash = '';
    let bits = 0;
    let value = 0;
    let even = true;

    while (hash.length < precision) {
        const range = even ? lonRange : latRange;
        const coordinate = even ? lon : lat;
        const middle = (range[0] + range[1]) / 2;
        value <<= 1;

        if (coordinate >= middle) {
            value |= 1;
            range[0] = middle;
        } else {
            range[1] = middle;
        }

        even = !even;
        bits += 1;

        if (bits === 5) {
            hash += GEOHASH[value];
            bits = 0;
            value = 0;
        }
    }

    return hash;
}

export function fromGeohash(text) {
    const hash = String(text).trim().toLowerCase();

    if (!/^[0-9b-hjkmnp-z]{1,12}$/.test(hash)) {
        return null;
    }

    const latRange = [-90, 90];
    const lonRange = [-180, 180];
    let even = true;

    [...hash].forEach((char) => {
        const value = GEOHASH.indexOf(char);

        for (let bit = 4; bit >= 0; bit -= 1) {
            const range = even ? lonRange : latRange;
            const middle = (range[0] + range[1]) / 2;
            range[(value >> bit) & 1 ? 0 : 1] = middle;
            even = !even;
        }
    });

    return { lat: (latRange[0] + latRange[1]) / 2, lon: (lonRange[0] + lonRange[1]) / 2 };
}

/**
 * Splits an angle into whole degrees, whole minutes and seconds, rounding the seconds first so
 * they never read 60.
 */
export function toDms(decimal, secondDecimals = 2) {
    const sign = decimal < 0 ? -1 : 1;
    const scale = 10 ** secondDecimals;
    const totalSeconds = Math.round(Math.abs(decimal) * 3600 * scale) / scale;
    const degrees = Math.floor(totalSeconds / 3600);
    const minutes = Math.floor((totalSeconds - degrees * 3600) / 60);
    const seconds = Math.round((totalSeconds - degrees * 3600 - minutes * 60) * scale) / scale;

    return { sign, degrees, minutes, seconds };
}

export function toDm(decimal, minuteDecimals = 4) {
    const sign = decimal < 0 ? -1 : 1;
    const scale = 10 ** minuteDecimals;
    const totalMinutes = Math.round(Math.abs(decimal) * 60 * scale) / scale;
    const degrees = Math.floor(totalMinutes / 60);

    return { sign, degrees, minutes: Math.round((totalMinutes - degrees * 60) * scale) / scale };
}

export function formatDms(decimal, axis) {
    const { sign, degrees, minutes, seconds } = toDms(decimal);
    const hemisphere = axis === 'lat' ? (sign < 0 ? 'S' : 'N') : axis === 'lon' ? (sign < 0 ? 'W' : 'E') : '';
    const prefix = !axis && sign < 0 ? '−' : '';

    return `${prefix}${degrees}° ${minutes}′ ${seconds.toFixed(2)}″${hemisphere ? ` ${hemisphere}` : ''}`;
}

export function formatDm(decimal, axis) {
    const { sign, degrees, minutes } = toDm(decimal);
    const hemisphere = axis === 'lat' ? (sign < 0 ? 'S' : 'N') : (sign < 0 ? 'W' : 'E');

    return `${degrees}° ${minutes.toFixed(4)}′ ${hemisphere}`;
}

/**
 * Parses one angle: "40.7128", "-74.006", "40°42′46″N", "40 42 46.1 N", "74°0.36' W".
 * Returns decimal degrees or null.
 */
export function parseAngle(text) {
    const cleaned = String(text).trim().toUpperCase().replace(/[°º′'″"]/g, ' ').replace(/\s+/g, ' ');
    const match = cleaned.match(/^([NSEW])?\s*([-+]?\d+(?:\.\d+)?)(?:\s+(\d+(?:\.\d+)?))?(?:\s+(\d+(?:\.\d+)?))?\s*([NSEW])?$/);

    if (!match) {
        return null;
    }

    const [, before, degreesText, minutesText = '0', secondsText = '0', after] = match;
    const minutes = Number(minutesText);
    const seconds = Number(secondsText);

    if (minutes >= 60 || seconds >= 60) {
        return null;
    }

    const degrees = Number(degreesText);
    const magnitude = Math.abs(degrees) + minutes / 60 + seconds / 3600;
    const hemisphere = before ?? after;
    const negative = degrees < 0 || degreesText.startsWith('-') || hemisphere === 'S' || hemisphere === 'W';

    return negative ? -magnitude : magnitude;
}

/**
 * Parses "lat, lon" in decimal, DMS or DM form. Without a comma, hemisphere letters split the pair.
 */
export function parseLatLon(text) {
    const value = String(text).trim();
    let parts;

    if (/[,;]/.test(value)) {
        parts = value.split(/\s*[,;]\s*/);
    } else {
        const split = value.toUpperCase().match(/^(.*?[NS])\s*(.*[EW])$/) ?? value.match(/^(\S+)\s+(\S+)$/);
        parts = split ? [split[1], split[2]] : [];
    }

    if (parts.length !== 2) {
        return null;
    }

    const lat = parseAngle(parts[0]);
    const lon = parseAngle(parts[1]);

    if (lat === null || lon === null || Math.abs(lat) > 90 || Math.abs(lon) > 180) {
        return null;
    }

    return { lat, lon };
}

export function parseUtm(text) {
    const match = String(text).toUpperCase().trim().match(/^(\d{1,2})\s*([C-HJ-NP-X])?\s*([NS])?\s+(\d+(?:\.\d+)?)\s*(?:M?E)?[\s,]+(\d+(?:\.\d+)?)\s*(?:M?N)?$/);

    if (!match) {
        return null;
    }

    const [, zoneText, band, hemisphereLetter, eastingText, northingText] = match;
    const zone = Number(zoneText);
    const hemisphere = hemisphereLetter ?? (band ? (BANDS.indexOf(band) < 10 ? 'S' : 'N') : 'N');

    if (zone < 1 || zone > 60) {
        return null;
    }

    return { zone, hemisphere, easting: Number(eastingText), northing: Number(northingText) };
}
