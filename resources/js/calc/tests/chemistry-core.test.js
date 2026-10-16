import assert from 'node:assert/strict';
import { execSync } from 'node:child_process';
import test from 'node:test';
import { balance, formatEquation, sideTotals, splitSide } from '../chemistry/balance.js';
import { FormulaError, hillFormula, molarMass, parseFormula } from '../chemistry/formula.js';

const ELEMENTS = JSON.parse(execSync('php -r \'echo json_encode(require "config/elements.php");\'').toString());
const close = (actual, expected, tolerance) => assert.ok(Math.abs(actual - expected) <= tolerance, `${actual} ≠ ${expected}`);
const counts = (formula) => Object.fromEntries(parseFormula(formula, ELEMENTS).counts);
const mass = (formula) => molarMass(parseFormula(formula, ELEMENTS), ELEMENTS).total;
const coefficients = (equation) => balance(equation, ELEMENTS).coefficients;

test('molar masses from IUPAC atomic weights', () => {
    close(mass('H2O'), 18.015, 1e-9);
    close(mass('Ca(OH)2'), 74.092, 1e-9);
    close(mass('CuSO4·5H2O'), 249.677, 1e-9);
    close(mass('CuSO4.5H2O'), 249.677, 1e-9);
    close(mass('C6H12O6'), 180.156, 1e-9);
    close(mass('D2O'), 2 * 2.01410177812 + 15.999, 1e-9);
});

test('brackets, complexes and hydrates count exactly', () => {
    assert.deepEqual(counts('[Cu(NH3)4]SO4'), { Cu: 1, N: 4, H: 12, S: 1, O: 4 });
    assert.deepEqual(counts('K4[Fe(CN)6]'), { K: 4, Fe: 1, C: 6, N: 6 });
    assert.deepEqual(counts('Al2(SO4)3·18H2O'), { Al: 2, S: 3, O: 30, H: 36 });
    assert.deepEqual(counts('C₆H₁₂O₆'), { C: 6, H: 12, O: 6 });
});

test('charges in every accepted notation', () => {
    const charge = (formula) => parseFormula(formula, ELEMENTS).charge;
    assert.equal(charge('Fe3+'), 3);
    assert.equal(charge('Fe^3+'), 3);
    assert.equal(charge('Fe^+3'), 3);
    assert.equal(charge('Fe³⁺'), 3);
    assert.equal(charge('SO4^2-'), -2);
    assert.equal(charge('SO4 2-'), -2);
    assert.equal(charge('SO₄²⁻'), -2);
    assert.equal(charge('NH4+'), 1);
    assert.deepEqual(counts('NH4+'), { N: 1, H: 4 });
    assert.equal(charge('Cl-'), -1);
    assert.equal(charge('e-'), -1);
    assert.equal(parseFormula('SO4^2-', ELEMENTS).text, 'SO₄²⁻');
    assert.equal(parseFormula('CuSO4*5H2O', ELEMENTS).text, 'CuSO₄·5H₂O');
});

test('clear errors for bad formulas', () => {
    const error = (formula) => assert.throws(() => parseFormula(formula, ELEMENTS), FormulaError);
    error('co');
    error('Xx');
    error('Ca(OH2');
    error('CaOH)2');
    error('2H2O');
    error('');
    assert.throws(() => parseFormula('Xx', ELEMENTS), /"Xx" is not an element symbol/);
});

test('Hill order', () => {
    assert.equal(hillFormula(parseFormula('CH3CH2OH', ELEMENTS).counts), 'C₂H₆O');
    assert.equal(hillFormula(parseFormula('NaCl', ELEMENTS).counts), 'ClNa');
});

test('species splitting tells separators from charges', () => {
    assert.deepEqual(splitSide('NH4+ + OH-').map((s) => s.formula), ['NH4+', 'OH-']);
    assert.deepEqual(splitSide('Fe^3+ + e-').map((s) => s.formula), ['Fe^3+', 'e-']);
    assert.deepEqual(splitSide('2H2+O2').map((s) => [s.typed, s.formula]), [[2, 'H2'], [null, 'O2']]);
});

test('balances molecular equations', () => {
    assert.deepEqual(coefficients('Fe + O2 = Fe2O3'), [4, 3, 2]);
    assert.deepEqual(coefficients('C3H8 + O2 -> CO2 + H2O'), [1, 5, 3, 4]);
    assert.deepEqual(coefficients('KMnO4 + HCl = KCl + MnCl2 + H2O + Cl2'), [2, 16, 2, 2, 8, 5]);
    assert.deepEqual(coefficients('H2+O2=H2O'), [2, 1, 2]);
    assert.deepEqual(coefficients('C57H110O6 + O2 = CO2 + H2O'), [2, 163, 114, 110]);
    assert.deepEqual(coefficients('2H2 + 2O2 = 2H2O'), [2, 1, 2]);
});

test('balances ionic and redox equations with charge', () => {
    assert.deepEqual(coefficients('MnO4^- + Fe^2+ + H^+ = Mn^2+ + Fe^3+ + H2O'), [1, 5, 8, 1, 5, 4]);
    assert.deepEqual(coefficients('Cr2O7^2- + H+ + e- = Cr3+ + H2O'), [1, 14, 6, 2, 7]);
    assert.deepEqual(coefficients('NH4+ + OH- = NH3 + H2O'), [1, 1, 1, 1]);
});

test('balanced output and atom check', () => {
    const result = balance('Fe + O2 = Fe2O3', ELEMENTS);
    assert.equal(formatEquation(result), '4Fe + 3O₂ → 2Fe₂O₃');
    const totals = sideTotals(result);
    assert.deepEqual(Object.fromEntries(totals.left.counts), Object.fromEntries(totals.right.counts));
});

test('reports equations that cannot be balanced or are ambiguous', () => {
    assert.throws(() => balance('H2 = O2', ELEMENTS), /cannot be balanced/);
    assert.throws(() => balance('H2 + O2 = H2O + H2O2', ELEMENTS), /more than one independent balance/);
    assert.throws(() => balance('H2 + O2', ELEMENTS), /one arrow or equals sign/);
    assert.throws(() => balance('H2O = H2 + O2 + Xx', ELEMENTS), /Xx/);
});

test('balances a large redox equation quickly', () => {
    const start = performance.now();
    const result = coefficients('K4Fe(CN)6 + KMnO4 + H2SO4 = KHSO4 + Fe2(SO4)3 + MnSO4 + HNO3 + CO2 + H2O');
    const elapsed = performance.now() - start;
    assert.deepEqual(result, [10, 122, 299, 162, 5, 122, 60, 60, 188]);
    assert.ok(elapsed < 20, `took ${elapsed} ms`);
});
