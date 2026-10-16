import assert from 'node:assert/strict';
import { execSync } from 'node:child_process';
import test from 'node:test';
import { logActivityCoefficient, solvePh } from '../chemistry/acidbase.js';
import { plainFormat } from '../engines/formula.js';
import { handlers as mix, speciesLabel } from '../tools/chem-mix.js';

const php = (expression) => JSON.parse(execSync(`php -r 'echo json_encode(${expression});'`).toString());
const ELEMENTS = php('require "config/elements.php"');
const DATA = php('require "config/chemistry_data.php"');
const c = { data: { elements: ELEMENTS, ...DATA } };
const f = plainFormat;
const raw = (value) => value;
const close = (actual, expected, tolerance) => assert.ok(Math.abs(Number(actual) - expected) <= tolerance, `${actual} ≠ ${expected}`);

test('exact pH: textbook solutions', () => {
    close(solvePh([{ type: 'acid', concentration: 0.1, pKa: [4.756] }]), 2.881, 0.001);
    close(solvePh([{ type: 'acid', concentration: 1e-8, pKa: [], strongSteps: 1 }]), 6.976, 0.001);
    close(solvePh([{ type: 'acid', concentration: 0.1, pKa: [1.99], strongSteps: 1 }]), 0.964, 0.002);
    close(solvePh([]), 13.995 / 2, 1e-6);
});

test('Debye–Hückel models reproduce Kielland activity coefficients', () => {
    // Kielland (1937): K⁺ (300 pm) γ = 0.964 at I = 0.001 and 0.76 at 0.1; Ca²⁺ (600 pm) 0.675 at 0.01.
    close(10 ** logActivityCoefficient('limiting', 1, 0.001), 0.964, 0.001);
    close(10 ** logActivityCoefficient('extended', 1, 0.1, 3), 0.76, 0.01);
    close(10 ** logActivityCoefficient('extended', 2, 0.01, 6), 0.675, 0.002);
    const outcome = mix.activity({ model: 'davies', charge: 2, ionic_strength: 0.1, ion: 'ca', size: NaN, concentration: 0.01 }, c, f);
    close(outcome.value, 0.373, 0.001);
    assert.match(mix.activity({ model: 'limiting', charge: 1, ionic_strength: 0.1, ion: 'k', size: NaN, concentration: NaN }, c, f).sub, /Outside/);
});

test('alligation, mixing ratio, dilution factor and mass percent', () => {
    const allig = mix.alligation({ high: 95, low: 70, target: 80, total: 500 }, c, f);
    assert.equal(allig.value, '200 + 300');
    assert.equal(mix.mixing_ratio({ ratio: '1:4', total: 500, unit_label: 'mL' }, c, f).value, '100 + 400');
    assert.equal(mix.dilution_factor({ mode: 'volumes', aliquot: 1, final: 10 }, c, f).value, '10');
    assert.equal(mix.mass_percent({ solute: 5, other: 95, basis: 'solvent', formula: '' }, c, f).value, '5');
});

test('bleach dilution', () => {
    close(mix.bleach({ percent: 6, target: 200, volume: 1, density: 1 }, c, raw).value, 3.3333, 1e-4);
});

test('buffer capacity peaks at the pKa', () => {
    const at = mix.buffer_capacity({ buffer: 'custom', pka: 4.76, total: 0.1, ph: 4.76 }, c, raw);
    close(at.value, Math.LN10 * 0.025, 1e-4);
});

test('concentration in every unit', () => {
    const outcome = mix.concentration({ formula: 'NaCl', value: 1, from: 'm', density: 1.04 }, c, f);
    const percent = outcome.lists.units.find((row) => row.label === 'Percent w/w').value;
    close(parseFloat(percent), (58.44 / 1040) * 100, 0.01);
    close(mix.concentration({ formula: 'NaCl', value: 5.619, from: 'ww', density: 1.04 }, c, raw).value, 1, 0.001);
});

test('neutralization volumes, pH and salt', () => {
    const hcl = mix.neutralization({ acid: 'acid:hydrochloric_acid', base: 'base:sodium_hydroxide', acid_concentration: 0.1, acid_volume: 0.025, base_concentration: 0.1 }, c, f);
    assert.equal(hcl.value, '25');
    assert.match(hcl.rows.ph, /pH 7/);
    assert.match(hcl.rows.salt, /^sodium chloride/);
    const sulfuric = mix.neutralization({ acid: 'acid:sulfuric_acid', base: 'base:sodium_hydroxide', acid_concentration: 0.1, acid_volume: 0.025, base_concentration: 0.1 }, c, f);
    assert.equal(sulfuric.value, '50');
    assert.match(sulfuric.rows.salt, /^sodium sulfate \(Na₂SO₄\)/);
    const phosphate = mix.neutralization({ acid: 'acid:phosphoric_acid', base: 'base:calcium_hydroxide', acid_concentration: 0.1, acid_volume: 0.02, base_concentration: 0.1 }, c, f);
    assert.match(phosphate.rows.salt, /Ca₃\(PO₄\)₂/);
});

test('concentrated reagents match their tabulated molarity', () => {
    for (const [key, reagent] of Object.entries(DATA.reagents)) {
        const outcome = mix.percent_to_molarity({ reagent: key }, c, raw);
        close(outcome.value, reagent.molarity, reagent.molarity * 0.015);
    }
});

test('pH calculator and species labels', () => {
    const acetic = mix.ph({ choice: 'acid:acetic_acid', concentration: 0.1 }, c, f);
    assert.equal(acetic.value, '2.881');
    assert.deepEqual(acetic.lists.species.map((row) => row.label), ['HA', 'A⁻']);
    const phosphoric = mix.ph({ choice: 'acid:phosphoric_acid', concentration: 0.1 }, c, f);
    assert.deepEqual(phosphoric.lists.species.map((row) => row.label), ['H₃A', 'H₂A⁻', 'HA²⁻', 'A³⁻']);
    assert.equal(mix.ph({ choice: 'base:sodium_hydroxide', concentration: 0.01 }, c, f).value, '11.995');
    assert.equal(speciesLabel(1, 1), 'HA⁻');
    assert.ok(mix.ph({ choice: 'custom', kind: 'acid', strength: 'weak', pkas: '', concentration: 0.1 }, c, f).empty);
});

test('titration of acetic acid with sodium hydroxide', () => {
    const outcome = mix.titration({ mode: 'curve', choice: 'acid:acetic_acid', analyte_concentration: 0.1, analyte_volume: 0.025, titrant_concentration: 0.1 }, c, f);
    assert.equal(outcome.value, '25');
    assert.match(outcome.sub, /^pH 8\.7/);
    assert.match(outcome.rows.half, /^pH 4\.76/);
    assert.equal(outcome.plots.curve.series.length, 151);
    const found = mix.titration({ mode: 'find', choice: 'acid:sulfuric_acid', analyte_volume: 0.025, titrant_concentration: 0.1, titrant_volume: 0.03, steps: NaN }, c, raw);
    close(found.value, 0.06, 1e-12);
    assert.equal(mix.titration({ mode: 'curve', choice: 'acid:phosphoric_acid', analyte_concentration: 0.1, analyte_volume: 0.01, titrant_concentration: 0.1 }, c, f).plots.curve.markers.length, 3);
});

test('water hardness conversions', () => {
    const outcome = mix.water_hardness({ mode: 'value', value: 100, from: 'mgl' }, c, raw);
    const unit = (name) => outcome.lists.units.find((row) => row.label.startsWith(name)).value;
    close(unit('grains'), 5.842, 0.002);
    close(unit('German'), 5.603, 0.002);
    close(unit('French'), 10, 1e-9);
    close(mix.water_hardness({ mode: 'ions', calcium: 40, magnesium: 10 }, c, raw).value, 141.06, 0.02);
});

test('solubility products', () => {
    close(mix.ksp({ salt: 'silver_i_chloride', mode: 'from_ksp', common: 'none' }, c, raw).value, Math.sqrt(1.77e-10), 1e-9);
    close(mix.ksp({ salt: 'calcium_fluoride', mode: 'from_ksp', common: 'none' }, c, raw).value, (3.45e-11 / 4) ** (1 / 3), 1e-8);
    close(mix.ksp({ salt: 'silver_i_chloride', mode: 'from_ksp', common: 'anion', common_concentration: 0.1 }, c, raw).value, 1.77e-9, 1e-12);
    close(mix.ksp({ salt: 'custom', formula: 'Ca3(PO4)2', mode: 'from_solubility', solubility: 1e-6, common: 'none' }, c, raw).value, 108e-30, 1e-33);
});

test('Raoult, reconstitution, TDS and saponification', () => {
    close(mix.raoult({ mode: 'volatile', x1: 0.5, p1: 10000, p2: 20000 }, c, raw).value, 15, 1e-12);
    assert.equal(mix.reconstitution({ amount: 10, amount_unit: 'mg', diluent: 2, wanted: 2.5 }, c, f).rows.draw, '0.5 mL');
    assert.equal(mix.tds({ residue: 0.05, sample: 0.1 }, c, f).value, '500');
    const soap = mix.saponification({ oil_1: 'olive_oil', weight_1: 1000, lye: 'naoh', superfat: 5, purity: 100, water_mode: 'percent', water_value: 33, weight_unit: 'g' }, c, raw);
    close(soap.value, 1000 * 0.135 * 0.95, 0.01);
});
