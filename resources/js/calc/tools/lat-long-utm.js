import { formatDms, fromUtm, latitudeBand, toMgrs, toUtm } from '../engines/geo.js';

/**
 * Latitude/longitude ↔ UTM on WGS84.
 */
export default function latLongUtm(ctx) {
    ctx.onUpdate(() => {
        const toUtmMode = ctx.choice('mode') === 'to-utm';
        let lat;
        let lon;

        if (toUtmMode) {
            lat = ctx.number('lat');
            lon = ctx.number('lon');

            if (Number.isNaN(lat) || Number.isNaN(lon)) {
                ctx.clearResult('Enter latitude and longitude in decimal degrees.');

                return;
            }

            if (Math.abs(lon) > 180) {
                ctx.showError('Longitude must be between −180 and 180.');

                return;
            }

            if (lat < -80 || lat > 84) {
                ctx.showError('UTM covers 80°S to 84°N. Polar areas use the UPS system instead.');

                return;
            }
        } else {
            const zone = ctx.number('zone');
            const easting = ctx.number('easting');
            const northing = ctx.number('northing');

            if ([zone, easting, northing].some(Number.isNaN)) {
                ctx.clearResult('Enter the zone, easting and northing.');

                return;
            }

            if (!Number.isInteger(zone) || zone < 1 || zone > 60 || easting < 100000 || easting > 900000 || northing < 0 || northing > 10000000) {
                ctx.showError('Use a zone from 1 to 60, easting between 100,000 and 900,000 m and northing between 0 and 10,000,000 m.');

                return;
            }

            ({ lat, lon } = fromUtm(zone, ctx.choice('hemisphere'), easting, northing));
        }

        const utm = toUtm(lat, lon);

        ctx.showResult(toUtmMode
            ? { value: `${utm.zone}${utm.band} ${utm.easting.toFixed(0)} ${utm.northing.toFixed(0)}`, unit: '', label: 'UTM (WGS84)', sub: `Easting ${utm.easting.toFixed(2)} m · Northing ${utm.northing.toFixed(2)} m` }
            : { value: `${lat.toFixed(6)}, ${lon.toFixed(6)}`, unit: '', label: 'Latitude, longitude', sub: `${formatDms(lat, 'lat')}, ${formatDms(lon, 'lon')}` });

        ctx.setRow('latlon', `${lat.toFixed(6)}, ${lon.toFixed(6)}`);
        ctx.setRow('dms', `${formatDms(lat, 'lat')}, ${formatDms(lon, 'lon')}`);
        ctx.setRow('zone', `${utm.zone}${latitudeBand(lat)} (${utm.hemisphere === 'N' ? 'northern' : 'southern'} hemisphere)`);
        ctx.setRow('easting', `${utm.easting.toFixed(2)} m`);
        ctx.setRow('northing', `${utm.northing.toFixed(2)} m`);
        ctx.setRow('meridian', `${utm.centralMeridian}°`);
        ctx.setRow('mgrs', toMgrs(lat, lon));
    });
}
