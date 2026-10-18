import assert from 'node:assert/strict';
import { execSync } from 'node:child_process';
import { readFileSync } from 'node:fs';
import test from 'node:test';
import { cashFlow, greatCircle } from '../ecology/common.js';
import { handlers as energy, rayleighAveragePower, turbinePower } from '../tools/eco-energy.js';
import { findAirport, flightCategory, handlers as foot } from '../tools/eco-footprint.js';
import { handlers as living } from '../tools/eco-living.js';
import { aqiFor, handlers as science, lotkaVolterra } from '../tools/eco-science.js';

const DATA = JSON.parse(execSync(`php -r 'echo json_encode(require "config/ecology_data.php");'`).toString());
const AIRPORTS = JSON.parse(readFileSync('public/data/airports.json', 'utf8')).airports;
const c = { data: DATA };
const raw = (value) => value;
const num = (text) => Number(String(text).replace(/[^0-9.eE+-].*$/, ''));
const close = (actual, expected, tolerance) => assert.ok(Math.abs(Number(actual) - expected) <= tolerance, `${actual} ≠ ${expected}`);
const MILE = 1609.344;
const GAL = 3.785411784;

test('great-circle distance and DESNZ flight categories', () => {
    const lhr = findAirport('LHR', AIRPORTS);
    const jfk = findAirport('JFK — New York (US)', AIRPORTS);
    const cdg = findAirport('CDG', AIRPORTS);
    const del = findAirport('DEL', AIRPORTS);
    const bom = findAirport('BOM', AIRPORTS);
    close(greatCircle(lhr[4], lhr[5], jfk[4], jfk[5]) / 1000, 5540, 15);
    assert.equal(flightCategory(lhr, jfk), 'long');
    assert.equal(flightCategory(lhr, cdg), 'short');
    assert.equal(flightCategory(del, bom), 'international');
    const outcome = foot.flight({ mode: 'airports', from: 'LHR', to: 'JFK', cabin: 'economy', trip: 'return', passengers: 1, rf: 'yes' }, { ...c, airports: AIRPORTS }, raw);
    close(outcome.value, (greatCircle(lhr[4], lhr[5], jfk[4], jfk[5]) / 1000) * 0.11704 * 2, 1e-6);
});

test('bag break-even and vegan savings from the published tables', () => {
    assert.equal(foot.bag({ bag: 'cotton', uses: 52, scenario: '1' }, c, raw).value, 173);
    close(foot.vegan({ diet: 'high_meat', people: 1, years: 1 }, c, raw).value, (10.24 - 2.47) * 365.25, 1e-9);
});

test('crypto, car and home energy footprints', () => {
    const crypto = foot.crypto({ hashrate: 1000, tx: 500000, miner: 's21', overhead: 0, grid: 'OWID_WRL', yours: NaN }, c, raw);
    close(crypto.value, (1000e18 * 17.5e-12 * 8760) / 1000 / (500000 * 365), 1e-9);
    const car = foot.car({ mode: 'distance', distance: 12000 * MILE, economy: 28, economy_unit: 'mpg_us', fuel: 'us_gasoline' }, c, raw);
    close(car.value, (12000 / 28) * 8.78, 1e-6);
    const home = foot.home_energy({ electricity: 500, grid: 'custom', grid_custom: 400, gas: 0, oil: NaN, propane: NaN, people: 1 }, c, raw);
    close(home.value, (500 * 12 * 0.4) / 1000, 1e-12);
});

test('hydro, wind and the Betz limit', () => {
    close(energy.hydro({ flow: 1, flow_unit: 'm3s', head: 10, efficiency: 85, capacity: 100 }, c, raw).value, (0.85 * 998.2 * 9.80665 * 10) / 1000, 1e-9);
    const turbine = { rho: 1.225, area: Math.PI * 25, cp: 0.4, rated: 0 };
    close(turbinePower(10, turbine), 0.5 * 1.225 * Math.PI * 25 * 1000 * 0.4, 1e-6);
    // With no rated cap, the Rayleigh mean of v³ is (6/π) v̄³.
    close(rayleighAveragePower(6, turbine) / (0.5 * 1.225 * Math.PI * 25 * 0.4 * (6 / Math.PI) * 216), 1, 0.002);
    assert.ok(energy.wind({ mode: 'speed', diameter: 10, cp: 0.6, speed: 8, altitude: 0, temperature: 15 }, c, raw).error);
});

test('payback, solar size and batteries', () => {
    const flow = cashFlow({ cost: 1000, energy: 1000, price: 0.1, years: 20 });
    close(flow.payback, 10, 1e-9);
    const solar = energy.solar({ site: 'custom', sun_hours: 4, losses: 0, use: 1460, use_unit: 'year', panel: 400, share: 100, panel_area: 2 }, c, raw);
    close(solar.value, 1460 / (4 * 365), 0.01);
    close(energy.battery({ mode: 'backup', load: 1.5, hours: 8, dod: 90, efficiency: 95 }, c, raw).value, 12 / 0.855, 0.01);
});

test('living: drips, plug-in hybrid, shower and plastic policy', () => {
    close(living.drip({ drips: 10, drip_ml: 0.25, price: NaN }, c, raw).value, (10 * 1440 * 0.25 * 365) / 1000 / GAL, 1e-9);
    const phev = living.phev({ daily: 40 * MILE, range: 30 * MILE, days: 300, kwh_100: 33, kwh_unit: 'mi', economy: 45, economy_unit: 'mpg_us', fuel: 'us_gasoline', power_price: 0, fuel_price: 0, price_unit: 'gal', grid: 'USA' }, c, raw);
    close(phev.value, 75, 1e-9);
    const shower = living.shower({ minutes: 8, flow: 2.5, flow_unit: 'gpm', cold: 12.78, hot: 40.56, heater: 'gas', efficiency: 100, per_week: 7, people: 1, grid: 'USA' }, c, raw);
    close(shower.value, 20 * GAL, 1e-9);
    assert.equal(living.plastic_policy({ scenario: 'baseline' }, c, raw).value, 44);
});

test('science: AQI, Lotka–Volterra, breathing and carrying capacity', () => {
    assert.equal(aqiFor(DATA.aqi.pm25, 30).aqi, 90);
    assert.equal(aqiFor(DATA.aqi.o3_8h, 0.07853333).aqi, 126);
    const path = lotkaVolterra({ x0: 4, y0: 2.75, alpha: 1.1, beta: 0.4, gamma: 0.4, delta: 0.1, time: 10 });
    close(path[path.length - 1][1], 4, 1e-9);
    const breath = science.breathing({ mass: 70000, sleep: 24, sit: 0, light: 0, moderate: 0, vigorous: 0, rer: 0.85 }, c, raw);
    close(breath.value, (0.95 * 3.5 * 70 * 1440 * 0.85 * 1.977) / 1e6, 1e-9);
    const fit = science.carrying_capacity({ mode: 'fit', counts: Array.from({ length: 9 }, (_, k) => `${k * 2} ${500 / (1 + 24 * Math.exp(-0.5 * k * 2))}`).join('\n') }, c, raw);
    close(fit.value, 500, 1);
    close(num(science.fish_mercury({ mass: 70000, fish1: 'swordfish', grams1: 70, fish2: '', grams2: 0, fish3: '', grams3: 0 }, c, raw).value), (0.995 * 70) / 7 / 70, 0.001);
});
