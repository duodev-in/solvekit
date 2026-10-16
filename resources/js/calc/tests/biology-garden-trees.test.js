import assert from 'node:assert/strict';
import test from 'node:test';
import { plainFormat } from '../engines/formula.js';
import { basalArea, doyle, international, scribner, treeCarbon } from '../tools/forestry.js';
import { coverage, growingDegreeUnits, handlers as garden, plantsForArea, saturationVaporPressure } from '../tools/garden.js';
import { pounds } from '../tools/wastewater.js';

const close = (actual, expected, tolerance) => assert.ok(Math.abs(actual - expected) <= tolerance, `${actual} ≠ ${expected}`);
const FT = 0.3048;
const IN = 0.0254;

test('coverage: 108 ft² at 3 in is one cubic yard', () => {
    const result = coverage(108 * FT * FT, 3 * IN);
    close(result.yd3, 1, 1e-9);
    assert.equal(coverage(108 * FT * FT, 3 * IN, 2).bags, 14);
});

test('triangular spacing fits about 15% more plants', () => {
    const area = 100 * FT * FT;
    assert.equal(plantsForArea(area, FT, 'square'), 100);
    assert.equal(plantsForArea(area, FT, 'triangular'), 115);
});

test('GDU caps the high at 86 °F and raises the low to 50 °F', () => {
    assert.equal(growingDegreeUnits(95, 70), 28);
    assert.equal(growingDegreeUnits(70, 40), 10);
});

test('saturation vapor pressure follows Tetens', () => {
    close(saturationVaporPressure(25), 3.1676, 1e-4);
    close(saturationVaporPressure(0), 0.61078, 1e-9);
});

test('fertilizer and water-soluble fertilizer', () => {
    const outcome = garden.fertilizer({ n: 20, p: 5, k: 10, area: 1000 * FT * FT, target: 1 }, {}, plainFormat);
    assert.equal(outcome.value, '5');
    const soluble = garden.water_soluble({ ppm: 200, n: 20, water: 1 }, {}, plainFormat);
    assert.equal(soluble.value, '1');
});

test('corn yield, DLI and rainwater', () => {
    assert.equal(garden.corn_yield({ ears: 32, rows: 16, kernels: 35, factor: 90 }, {}, plainFormat).value, '199.1111');
    assert.equal(garden.dli({ ppfd: 500, hours: 12 }, {}, plainFormat).value, '21.6');
    close(Number(garden.rainwater({ area: 1000 * FT * FT, rain: IN, efficiency: 100 }, {}, plainFormat).value.replace(/,/g, '')), 623.38, 0.01);
});

test('handlers report missing and invalid input', () => {
    assert.ok(garden.mulch({ area: Number.NaN, depth: 0.05 }, {}, plainFormat).empty);
    assert.ok(garden.lime({ area: 100, current: 6.5, target: 6 }, { data: {} }, plainFormat).error);
});

test('forestry: basal area and log rules', () => {
    close(basalArea(10 * IN) / (FT * FT), 0.5454, 1e-4);
    assert.equal(doyle(16, 16), 144);
    close(scribner(16, 16), 166.24, 0.01);
    close(international(16, 16), 199.6, 0.01);
    assert.equal(Math.round(international(16, 16)), 200);
});

test('tree carbon follows the green-weight method', () => {
    const result = treeCarbon(18, 60);
    close(result.co2, 4650.56, 0.1);
});

test('wastewater pounds formula', () => {
    assert.equal(pounds(200, 1), 1668);
});
