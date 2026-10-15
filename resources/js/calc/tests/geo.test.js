import assert from 'node:assert/strict';
import test from 'node:test';
import { formatDms, fromGeohash, fromMaidenhead, fromMgrs, fromPlusCode, fromUtm, latitudeBand, parseAngle, parseLatLon, parseUtm, toGeohash, toMaidenhead, toMgrs, toPlusCode, toUtm, utmZone } from '../engines/geo.js';
import { parsePosition } from '../tools/coordinates.js';
import { dmsToDecimal } from '../tools/dms.js';
import { formatRatio, scaleDenominator } from '../tools/scale.js';

const close = (actual, expected, tolerance) => assert.ok(Math.abs(actual - expected) <= tolerance, `${actual} ≠ ${expected}`);

// Reference values checked against PROJ (proj4js) to 0.1 mm.
test('UTM matches PROJ at reference points', () => {
    const origin = toUtm(0, 0);
    close(origin.easting, 166021.443, 0.001);
    close(origin.northing, 0, 0.001);

    const empire = toUtm(40.74844, -73.985664);
    assert.equal(`${empire.zone}${empire.band}`, '18T');
    close(empire.easting, 585631.397, 0.001);
    close(empire.northing, 4511326.923, 0.001);

    const sydney = toUtm(-33.8568, 151.2153);
    assert.equal(sydney.hemisphere, 'S');
    close(sydney.easting, 334900.570, 0.001);
    close(sydney.northing, 6252288.753, 0.001);
});

test('UTM round-trips', () => {
    const forward = toUtm(-12.3456, 45.6789);
    const back = fromUtm(forward.zone, forward.hemisphere, forward.easting, forward.northing);
    close(back.lat, -12.3456, 1e-9);
    close(back.lon, 45.6789, 1e-9);
});

test('special zones and bands', () => {
    assert.equal(utmZone(60.39, 5.32), 32);
    assert.equal(utmZone(78.22, 15.65), 33);
    assert.equal(utmZone(78.22, 9.5), 33);
    assert.equal(utmZone(0, 180), 60);
    assert.equal(latitudeBand(83.9), 'X');
    assert.equal(latitudeBand(-80), 'C');
    assert.equal(toUtm(85, 0), null);
});

test('MGRS encodes and decodes', () => {
    assert.equal(toMgrs(40.74844, -73.985664), '18T WL 85631 11326');
    const back = fromMgrs('18T WL 85631 11326');
    close(back.lat, 40.74844, 1e-4);
    close(back.lon, -73.985664, 1e-4);
    const south = fromMgrs(toMgrs(-33.8568, 151.2153));
    close(south.lat, -33.8568, 1e-4);
    assert.equal(fromMgrs('nonsense'), null);
});

test('Plus Codes, Maidenhead and Geohash', () => {
    assert.equal(toPlusCode(37.422, -122.0841), '849VCWC8+R9');
    close(fromPlusCode('849VCWC8+R9').lat, 37.4220625, 1e-9);
    assert.equal(toMaidenhead(38.89, -77.03), 'FM18lv');
    close(fromMaidenhead('FM18lv').lat, 38.895833, 1e-6);
    assert.equal(toGeohash(57.64911, 10.40744, 11), 'u4pruydqqvj');
    close(fromGeohash('u4pruydqqvj').lon, 10.40744, 1e-6);
});

test('DMS never shows 60 seconds and keeps the sign', () => {
    assert.equal(formatDms(12.35, 'lat'), '12° 21′ 0.00″ N');
    assert.equal(formatDms(-10.5), '−10° 30′ 0.00″');
    assert.equal(dmsToDecimal(10, 30, 0, true), -10.5);
    assert.equal(dmsToDecimal(-0, 30, 0, true), -0.5);
});

test('angle and position parsing', () => {
    close(parseAngle('40°44′54.4″N'), 40.748444, 1e-6);
    close(parseAngle('73 59 8.4 W'), -73.985667, 1e-6);
    assert.equal(parseAngle('12 60 0'), null);
    assert.deepEqual(parseLatLon('40.7128, -74.0060'), { lat: 40.7128, lon: -74.006 });
    assert.equal(parseLatLon('95, 10'), null);
    assert.deepEqual(parseUtm('18T 585631 4511327'), { zone: 18, hemisphere: 'N', easting: 585631, northing: 4511327 });
    close(parsePosition('utm', '56H 334901 6252289').lat, -33.8568, 1e-4);
});

test('scales', () => {
    assert.equal(scaleDenominator(0.04, 1000), 25000);
    assert.equal(formatRatio(25000), '1:25,000');
    assert.equal(formatRatio(0.2), '5:1');
});
