import { formatDm, formatDms, fromGeohash, fromMaidenhead, fromMgrs, fromPlusCode, fromUtm, parseLatLon, parseUtm, toGeohash, toMaidenhead, toMgrs, toPlusCode, toUtm } from '../engines/geo.js';

/**
 * Reads a position in any supported format and shows it in all of them.
 */
export function parsePosition(format, text) {
    switch (format) {
        case 'latlon': return parseLatLon(text);
        case 'utm': {
            const utm = parseUtm(text);

            return utm ? fromUtm(utm.zone, utm.hemisphere, utm.easting, utm.northing) : null;
        }
        case 'mgrs': return fromMgrs(text);
        case 'pluscode': return fromPlusCode(text);
        case 'maidenhead': return fromMaidenhead(text);
        case 'geohash': return fromGeohash(text);
        default: return null;
    }
}

const HINTS = {
    latlon: 'Use decimal (40.7484, -73.9857) or DMS (40°44′54″N 73°59′8″W).',
    utm: 'Use zone, band and meters, e.g. 18T 585631 4511327.',
    mgrs: 'Use a full reference, e.g. 18T WL 85631 11326.',
    pluscode: 'Use a full 10-digit Plus Code, e.g. 87G8Q2PR+X4.',
    maidenhead: 'Use 4 or 6 characters, e.g. FN30as.',
    geohash: 'Use 1 to 12 characters, e.g. dr5ru6j2c.',
};

export default function coordinates(ctx) {
    ctx.onUpdate(() => {
        const format = ctx.field('format').value;
        const text = ctx.field('value').value;
        ctx.setText('format-hint', HINTS[format]);

        if (text.trim() === '') {
            ctx.clearResult(HINTS[format]);

            return;
        }

        const position = parsePosition(format, text);

        if (!position || !Number.isFinite(position.lat)) {
            ctx.showError(`That does not look like a valid position. ${HINTS[format]}`);

            return;
        }

        const { lat, lon } = position;
        const utm = toUtm(lat, lon);

        ctx.showResult({ value: `${lat.toFixed(6)}, ${lon.toFixed(6)}`, unit: '', label: 'Decimal degrees', sub: `${formatDms(lat, 'lat')}, ${formatDms(lon, 'lon')}` });
        ctx.setRow('dd', `${lat.toFixed(6)}, ${lon.toFixed(6)}`);
        ctx.setRow('dms', `${formatDms(lat, 'lat')}, ${formatDms(lon, 'lon')}`);
        ctx.setRow('dm', `${formatDm(lat, 'lat')}, ${formatDm(lon, 'lon')}`);
        ctx.setRow('utm', utm ? `${utm.zone}${utm.band} ${utm.easting.toFixed(0)} ${utm.northing.toFixed(0)}` : 'Outside UTM (polar)');
        ctx.setRow('mgrs', toMgrs(lat, lon) ?? 'Outside UTM (polar)');
        ctx.setRow('pluscode', toPlusCode(lat, lon));
        ctx.setRow('maidenhead', toMaidenhead(lat, lon));
        ctx.setRow('geohash', toGeohash(lat, lon));
    });
}
