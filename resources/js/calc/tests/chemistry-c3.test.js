import assert from 'node:assert/strict';
import { execSync } from 'node:child_process';
import test from 'node:test';
import { standardAtmosphere, waterBoilingPoint } from '../chemistry/thermo.js';
import { plainFormat } from '../engines/formula.js';
import { handlers as reactions } from '../tools/chem-reactions.js';
import { handlers as thermo } from '../tools/chem-thermo.js';

const php = (expression) => JSON.parse(execSync(`php -r 'echo json_encode(${expression});'`).toString());
const ELEMENTS = php('require "config/elements.php"');
const DATA = php('require "config/chemistry_data.php"');
const c = { data: { elements: ELEMENTS, ...DATA } };
const f = plainFormat;
const raw = (value) => value;
const close = (actual, expected, tolerance) => assert.ok(Math.abs(Number(actual) - expected) <= tolerance, `${actual} ≠ ${expected}`);

test('balancer and net ionic equation', () => {
    assert.equal(reactions.balancer({ equation: 'Fe + O2 = Fe2O3' }, c, f).value, '4Fe + 3O₂ → 2Fe₂O₃');
    assert.equal(reactions.net_ionic({ equation: 'AgNO3 + NaCl = AgCl + NaNO3' }, c, f).value, 'Ag⁺(aq) + Cl⁻(aq) → AgCl(s)');
    assert.equal(reactions.net_ionic({ equation: 'NaCl + KNO3 = NaNO3 + KCl' }, c, f).value, 'No net reaction');
});

test('mole ratio and amounts', () => {
    const outcome = reactions.molar_ratio({ equation: 'N2 + H2 = NH3', species_a: 'N2', species_b: 'NH3', amount: 28.014, amount_unit: 'g' }, c, f);
    assert.equal(outcome.value, '1 : 2');
    assert.match(outcome.rows.amount, /^2 mol = 34\.06/);
});

test('theoretical yield, limiting reactant and percent yield', () => {
    const input = { equation: 'H2 + O2 = H2O', amounts: 'H2 4 g\nO2 32 g', product: 'H2O', actual: NaN };
    const outcome = reactions.theoretical_yield(input, c, raw);
    close(outcome.value, (4 / 2.016) * 18.015, 1e-6);
    assert.equal(outcome.rows.limiting, 'H₂');
    assert.equal(reactions.limiting_reactant(input, c, f).value, 'H₂');
    close(reactions.percent_yield({ actual: 30, theoretical: 35.744 }, c, raw).value, 83.93, 0.01);
    close(reactions.actual_yield({ theoretical: 50, percent: 80 }, c, raw).value, 40, 1e-12);
});

test('equilibrium constant, ICE table and reaction quotient', () => {
    const k = reactions.equilibrium_constant({ mode: 'equilibrium', equation: 'N2(g) + H2(g) = NH3(g)', concentrations: 'N2 0.5\nH2 1.5\nNH3 0.1' }, c, raw);
    close(k.value, 0.01 / (0.5 * 1.5 ** 3), 1e-12);
    const ice = reactions.equilibrium_constant({ mode: 'ice', equation: 'H2(g) + I2(g) = HI(g)', concentrations: 'H2 1\nI2 1\nHI 0', known_species: 'HI', known_value: 1.56 }, c, raw);
    close(ice.value, 1.56 ** 2 / 0.22 ** 2, 1e-6);
    const solid = reactions.equilibrium_constant({ mode: 'equilibrium', equation: 'CaCO3(s) = CaO(s) + CO2(g)', concentrations: 'CO2 0.02' }, c, raw);
    close(solid.value, 0.02, 1e-12);
    const q = reactions.reaction_quotient({ equation: 'N2(g) + H2(g) = NH3(g)', concentrations: 'N2 0.5\nH2 1.5\nNH3 0.1', k: 0.5 }, c, f);
    assert.match(q.sub, /towards products/);
});

test('Kp from Kc for ammonia synthesis', () => {
    const outcome = reactions.kp({ direction: 'kc_to_kp', k: 0.5, temperature: 400, equation: 'N2(g) + 3H2(g) = 2NH3(g)', delta_n: NaN, pressure_unit: 'atm' }, c, raw);
    close(outcome.value, 0.5 * (0.0820573661 * 673.15) ** -2, 1e-12);
});

test('kinetics: rate constant, Arrhenius and activation energy', () => {
    close(reactions.rate_constant({ order: '1', mode: 'concentrations', a0: 1, at: 0.5, time: 100 }, c, raw).value, Math.LN2 / 100, 1e-12);
    close(reactions.rate_constant({ order: '2', mode: 'halflife', half_life: 50, a0: 0.1 }, c, raw).value, 0.2, 1e-12);
    const k = reactions.arrhenius({ solve: 'k', a: 1e13, ea: 100, temperature: 25, k: NaN }, c, raw);
    close(k.value, 1e13 * Math.exp(-100000 / (8.314462618 * 298.15)), 1e-12);
    // A rate that doubles between 25 and 35 °C has Ea ≈ 52.9 kJ/mol.
    close(reactions.activation_energy({ k1: 1, t1: 25, k2: 2, t2: 35, t3: NaN }, c, raw).value, 52.9, 0.05);
});

test('IAPWS water vapor pressure and boiling points', () => {
    close(thermo.water_vapor({ temperature: 25 }, c, raw).value, 3.1698, 0.0002);
    close(thermo.water_vapor({ temperature: 100 }, c, raw).value, 101.418, 0.001);
    close(thermo.water_vapor({ temperature: -10 }, c, raw).value, 0.25987, 0.00002);
    close(waterBoilingPoint(101325) - 273.15, 99.974, 0.001);
    close(thermo.boiling_altitude({ mode: 'altitude', altitude: 0 }, c, raw).value, 99.97, 0.01);
    close(standardAtmosphere(1500), 84556, 1);
});

test('NIST Antoine: normal boiling points of ethanol and acetone', () => {
    close(thermo.boiling_point({ mode: 'antoine', substance: 'ethanol', pressure: 101325 }, c, raw).value, 78.3, 0.3);
    close(thermo.boiling_point({ mode: 'antoine', substance: 'acetone', pressure: 101325 }, c, raw).value, 56.1, 0.3);
    assert.ok(thermo.vapor_pressure({ mode: 'antoine', substance: 'ethanol', temperature: -40 }, c, f).error);
});

test('colligative properties of salt water', () => {
    close(thermo.colligative({ solvent: 'water', mode: 'moles', moles: 1, solvent_mass: 1000, vant_hoff: 2 }, { data: { ...c.data, kind: 'freezing' } }, raw).value, 3.72, 1e-9);
    close(thermo.colligative({ solvent: 'water', mode: 'moles', moles: 1, solvent_mass: 1000, vant_hoff: 2 }, { data: { ...c.data, kind: 'boiling' } }, raw).value, 1.024, 1e-9);
});

test('entropy and Gibbs energy', () => {
    close(thermo.entropy({ mode: 'phase', enthalpy: 40.65, temperature: 100 }, c, raw).value, 108.94, 0.01);
    const s = DATA.thermo;
    const expected = 2 * s['NH3(g)'].s - s['N2(g)'].s - 3 * s['H2(g)'].s;
    close(thermo.entropy({ mode: 'reaction', equation: 'N2(g) + H2(g) = NH3(g)' }, c, raw).value, expected, 1e-9);
    close(thermo.gibbs({ mode: 'hs', enthalpy: -92.2, entropy: -198.7, temperature: 25 }, c, raw).value, -92.2 + 0.29815 * 198.7, 0.001);
    close(thermo.gibbs({ mode: 'cell', potential: 1.1, electrons: 2, temperature: 25 }, c, raw).value, -212.268, 0.001);
});

test('enthalpy of reaction and heat of combustion of methane', () => {
    close(thermo.enthalpy_reaction({ equation: 'CH4(g) + O2(g) = CO2(g) + H2O(l)' }, c, raw).value, -890.5, 0.05);
    const combustion = thermo.combustion_heat({ mode: 'formula', fuel: 'CH4', phase: 'g', formation: NaN }, c, raw);
    close(combustion.value, -890.5, 0.05);
    assert.match(combustion.rows.lhv, /^-802\.5/);
    assert.ok(thermo.enthalpy_reaction({ equation: 'CH4 + O2 = CO2 + H2O' }, c, f).error);
});

test('phase rule, Q10, STP and specific heat', () => {
    assert.equal(thermo.phase_rule({ components: 1, phases: 3, constant: 'none' }, c, f).value, '0');
    close(thermo.q10({ mode: 'rates', r1: 2, t1: 20, r2: 4, t2: 30 }, c, raw).value, 2, 1e-12);
    close(thermo.stp({ mode: 'amount', standard: 'iupac', amount: 1, amount_unit: 'mol' }, c, raw).value, 22.711, 0.001);
    close(thermo.specific_heat({ mode: 'solve', solve: 'q', material: 'water', m: 100, dt: 10, q: NaN, c: NaN }, c, raw).value, 4186, 1e-9);
    const metal = thermo.specific_heat({ mode: 'calorimetry', metal_mass: 50, metal_t: 100, water_mass: 100, water_t: 20, final_t: 23.6 }, c, raw);
    close(metal.value, (100 * 4.186 * 3.6) / (50 * 76.4), 1e-9);
});
