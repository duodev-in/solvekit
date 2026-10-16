import assert from 'node:assert/strict';
import { execSync } from 'node:child_process';
import test from 'node:test';
import { pKw, waterDensity } from '../chemistry/water.js';
import { plainFormat } from '../engines/formula.js';
import { bondType, handlers as general, ionicCharacter } from '../tools/chem-general.js';
import { handlers as stoich, stoichiometricAfr } from '../tools/chem-stoich.js';
import { handlers as lab } from '../tools/lab.js';
import { parseFormula } from '../chemistry/formula.js';

const ELEMENTS = JSON.parse(execSync('php -r \'echo json_encode(require "config/elements.php");\'').toString());
const c = { data: { elements: ELEMENTS } };
const f = plainFormat;
const raw = (value) => value;
const close = (actual, expected, tolerance) => assert.ok(Math.abs(Number(actual) - expected) <= tolerance, `${actual} ≠ ${expected}`);

test('IAPWS water ionization: check values and 25 °C', () => {
    close(pKw(25), 13.995, 0.001);
    close(pKw(0), 14.946, 0.001);
    close(waterDensity(25), 997.045, 0.005);
});

test('atom: sodium-23 cation', () => {
    const outcome = general.atom({ element: 'Na', mass_number: 23, charge: 1 }, c, f);
    assert.equal(outcome.value, '11 p · 12 n · 10 e');
    assert.match(outcome.rows.natural, /^Yes, 100%/);
    assert.ok(general.atom({ element: 'Na', mass_number: 10, charge: 0 }, c, f).error);
});

test('atomic mass and binding energy of iron-56', () => {
    const outcome = general.atomic_mass({ element: 'Fe', mode: 'isotope', mass_number: 56 }, c, raw);
    close(outcome.value, 55.93493633, 1e-6);
    // Iron-56 binds about 8.79 MeV per nucleon.
    close(parseFloat(outcome.rows.per_nucleon), 8.790, 0.002);
    assert.equal(general.atomic_mass({ element: 'Tc', mode: 'element' }, c, f).value, '[97]');
});

test('average atomic mass of chlorine from NIST isotopes', () => {
    close(general.average_atomic_mass({ mode: 'element', element: 'Cl' }, c, raw).value, 35.4529, 0.0002);
    const custom = general.average_atomic_mass({ mode: 'custom', isotopes: '34.96885 75.76\n36.96590 24.24' }, c, raw);
    close(custom.value, 35.4529, 0.0002);
});

test('bond orders from molecular orbitals', () => {
    const order = (molecule) => general.bond_order({ mode: 'molecule', molecule }, c, f);
    assert.equal(order('O2').value, '2');
    assert.equal(order('O2').rows.magnetism, 'Paramagnetic');
    assert.equal(order('N2').value, '3');
    assert.equal(order('NO').value, '2.5');
    assert.equal(order('CN-').value, '3');
    assert.equal(order('O2^2-').value, '1');
    assert.equal(order('He2').value, '0');
    assert.equal(order('H2^+').value, '0.5');
    assert.match(order('H2+').error, /H2\^\+/);
    assert.equal(order('B2').rows.magnetism, 'Paramagnetic');
    assert.equal(order('C2').rows.magnetism, 'Diamagnetic');
    assert.ok(order('HCl').error);
});

test('chemical names both ways', () => {
    const name = (query) => general.chemical_name({ mode: 'formula', query }, c, f).value;
    const formula = (query) => general.chemical_name({ mode: 'name', query }, c, f).value;
    assert.equal(name('Fe2(SO4)3'), 'iron(III) sulfate');
    assert.equal(name('CuSO4·5H2O'), 'copper(II) sulfate pentahydrate');
    assert.equal(name('N2O5'), 'dinitrogen pentaoxide');
    assert.equal(name('PbO2'), 'lead(IV) oxide');
    assert.equal(formula('ammonium phosphate'), '(NH₄)₃PO₄');
    assert.equal(formula('dinitrogen pentoxide'), 'N₂O₅');
    assert.ok(general.chemical_name({ mode: 'formula', query: 'C6H12O6' }, c, f).error);
});

test('Slater Zeff', () => {
    assert.equal(general.zeff({ element: 'Zn', orbital: '4-0' }, c, f).value, '4.35');
    assert.equal(general.zeff({ element: 'Zn', orbital: '3-2' }, c, f).value, '8.85');
    assert.equal(general.zeff({ element: 'N', orbital: 'valence' }, c, f).value, '3.9');
    assert.ok(general.zeff({ element: 'H', orbital: '2-1' }, c, f).error);
});

test('electron configurations, ions and practice mode', () => {
    const config = (element, charge = 0) => general.electron_config({ mode: 'config', element, charge }, c, f);
    assert.equal(config('Fe').value, '[Ar] 3d⁶ 4s²');
    assert.equal(config('Fe', 3).value, '[Ar] 3d⁵');
    assert.equal(config('Cu').value, '[Ar] 3d¹⁰ 4s¹');
    assert.equal(config('O', -2).value, '[He] 2s² 2p⁶');
    assert.equal(config('Fe').rows.unpaired, '4');
    const practice = (answer) => general.electron_config({ mode: 'practice', element: 'S', charge: 0, answer }, c, f).value;
    assert.equal(practice('1s2 2s2 2p6 3s2 3p4'), 'Correct');
    assert.equal(practice('[Ne] 3s2 3p4'), 'Correct');
    assert.equal(practice('[Ne]3s²3p⁴'), 'Correct');
    assert.equal(practice('[Ne] 3s2 3p6'), 'Not quite');
});

test('electronegativity and ionic character', () => {
    const outcome = general.electronegativity({ element_a: 'Na', element_b: 'Cl' }, c, f);
    assert.equal(outcome.value, '2.23');
    assert.match(outcome.sub, /^Ionic/);
    close(ionicCharacter(2.23).pauling, 71.2, 0.1);
    assert.match(bondType(0.35), /^Nonpolar/);
});

test('molar mass, percent composition and monoisotopic mass', () => {
    close(general.molar_mass({ formula: 'C6H12O6' }, c, raw).value, 180.156, 1e-9);
    assert.equal(general.percent_composition({ formula: 'H2O' }, c, f).value, 'H 11.19% · O 88.81%');
    assert.match(general.molecular_weight({ formula: 'C6H12O6' }, c, f).rows.mono, /^180\.063/);
    assert.equal(general.molecular_weight({ formula: 'C6H12O6' }, c, f).rows.nominal, '180 Da');
});

test('mass and molar concentration', () => {
    close(general.mass_molar({ direction: 'mass', value: 58.44, formula: 'NaCl', weight: NaN }, c, raw).value, 1, 1e-4);
    close(general.mass_molar({ direction: 'molar', value: 0.5, formula: '', weight: 100 }, c, raw).value, 50, 1e-9);
});

test('pKa in every mode', () => {
    assert.equal(general.pka({ mode: 'ka', ka: 1.8e-5 }, c, f).value, '4.745');
    assert.equal(general.pka({ mode: 'ratio', ph: 5, base: 1, acid: 1 }, c, f).value, '5');
    // 0.1 M acetic acid has pH 2.87: Ka = [H⁺]² ÷ (C − [H⁺]) ≈ 1.85 × 10⁻⁵.
    close(general.pka({ mode: 'solution', ph: 2.87, concentration: 0.1 }, c, f).value, 4.734, 0.001);
});

test('stoichiometric air-fuel ratios', () => {
    close(stoichiometricAfr(parseFormula('C8H18', ELEMENTS), ELEMENTS), 15.13, 0.01);
    close(stoichiometricAfr(parseFormula('CH4', ELEMENTS), ELEMENTS), 17.24, 0.01);
    close(stoichiometricAfr(parseFormula('C2H5OH', ELEMENTS), ELEMENTS), 9.0, 0.01);
    const lean = stoich.afr({ mode: 'measured', fuel: 'C8H18', air: 16, fuel_mass: 1 }, c, f);
    assert.match(lean.sub, /^Lean/);
});

test('atom economy of ethanol dehydration', () => {
    close(stoich.atom_economy({ equation: 'C2H5OH = C2H4 + H2O', product: 'C2H4' }, c, raw).value, 60.9, 0.05);
});

test('empirical and molecular formula of glucose', () => {
    const outcome = stoich.empirical({ amounts: 'C 40.0\nH 6.71\nO 53.3', molar_mass: 180.16 }, c, f);
    assert.equal(outcome.value, 'CH₂O');
    assert.match(outcome.rows.molecular, /^C₆H₁₂O₆/);
    assert.equal(stoich.empirical({ amounts: 'Fe 69.94\nO 30.06', molar_mass: NaN }, c, f).value, 'Fe₂O₃');
});

test('grams, moles, particles and atoms', () => {
    close(stoich.grams_moles({ direction: 'mass', formula: 'H2O', mass: 18.015 }, c, raw).value, 1, 1e-9);
    close(stoich.avogadro({ direction: 'moles', value: 2, formula: '' }, c, raw).value, 2 * 6.02214076e23, 1e9);
    close(stoich.moles_atoms({ direction: 'moles', value: 1, formula: 'H2O' }, c, raw).value, 3 * 6.02214076e23, 1e9);
    close(stoich.mole({ mode: 'gas', gas_volume: 22.71095464, stp: 'iupac', formula: '' }, c, raw).value, 1, 1e-12);
});

test('hydrogen ion concentration', () => {
    const outcome = stoich.hydrogen_ion({ direction: 'ph', ph: 7, temperature: 25 }, c, f);
    assert.match(outcome.sub, /neutral at pH 6\.997/);
    assert.equal(stoich.hydrogen_ion({ direction: 'h', h: 1e-3, temperature: 25 }, c, f).value, '3');
});

test('molality, gas molar mass and mole fractions', () => {
    close(stoich.molality({ mode: 'mass', formula: 'NaCl', solute_mass: 58.44, solvent: 1000, density: NaN, water_solvent: 'yes' }, c, raw).value, 1, 1e-4);
    close(stoich.gas_molar_mass({ mode: 'ideal', mass: 31.998, volume: 22.71095464, temperature: 0, pressure: 100000 }, c, raw).value, 31.998, 1e-6);
    const fractions = stoich.mole_fraction({ components: 'H2O 90 g\nC2H5OH 10 g' }, c, f);
    assert.match(fractions.value, /C₂H₅OH 0\.0416/);
});

test('normality, ppm and residence time', () => {
    assert.equal(stoich.normality({ mode: 'molarity', molarity: 1, equivalents: 2 }, c, f).value, '2');
    close(stoich.ppm_molarity({ direction: 'ppm', value: 1000, formula: 'NaCl', weight: NaN, density: 1 }, c, raw).value, 0.017112, 1e-5);
    close(stoich.residence_time({ solve: 'tau', volume: 1000, flow: 10, flow_unit: 'l_min' }, c, raw).value, 100 / 60, 1e-12);
});

test('molarity accepts a formula instead of a molar mass', () => {
    close(lab.molarity({ mode: 'mass', concentration: 1, conc_unit: 'M', volume: 0.5, weight: NaN, formula: 'NaCl' }, c, raw).value, 29.22, 1e-9);
});
