import assert from 'node:assert/strict';
import { execSync } from 'node:child_process';
import test from 'node:test';
import { plainFormat } from '../engines/formula.js';
import { handlers as biochem, isoelectricPoint, netCharge } from '../tools/chem-biochem.js';
import { handlers as electro, ionicStrength } from '../tools/chem-electro.js';
import { degreeOfUnsaturation, handlers as organic } from '../tools/chem-organic.js';
import { cubicRoots, handlers as physical, millerFromIntercepts, waterSurfaceTension } from '../tools/chem-physical.js';
import { parseFormula } from '../chemistry/formula.js';

const php = (expression) => JSON.parse(execSync(`php -r 'echo json_encode(${expression});'`).toString());
const ELEMENTS = php('require "config/elements.php"');
const DATA = php('require "config/chemistry_data.php"');
const c = { data: { elements: ELEMENTS, ...DATA } };
const f = plainFormat;
const raw = (value) => value;
const close = (actual, expected, tolerance) => assert.ok(Math.abs(Number(actual) - expected) <= tolerance, `${actual} ≠ ${expected}`);
const potential = (start) => Object.entries(DATA.potentials).find(([, item]) => item.name.startsWith(start))[0];

test('Daniell cell: E° = 1.10 V', () => {
    const outcome = electro.cell_emf({ mode: 'table', cathode: potential('Cu²⁺ + 2e⁻ ⇌ Cu(s)'), anode: potential('Zn²⁺(aq) + 2e⁻ ⇌ Zn(s)'), temperature: 25, q: NaN }, c, raw);
    close(outcome.value, 0.3419 + 0.7618, 1e-9);
    assert.equal(outcome.rows.n, '2');
});

test('Nernst equation: 59.16 mV per decade at 25 °C', () => {
    const outcome = electro.nernst({ mode: 'q', standard: 0.34, electrons: 1, q: 10, temperature: 25 }, c, raw);
    close(outcome.value, 0.34 - 0.05916, 0.00001);
});

test('Faraday electrolysis of copper', () => {
    // 1 A for 1 h deposits 1.1855 g of copper.
    close(electro.electrolysis({ solve: 'mass', formula: 'Cu', weight: NaN, charge_number: 2, current: 1, time: 3600, efficiency: NaN }, c, raw).value, 1.1855, 0.0001);
});

test('ionic strength', () => {
    close(ionicStrength([{ concentration: 0.1, charge: 2 }, { concentration: 0.2, charge: -1 }]), 0.3, 1e-12);
    close(electro.ionic_strength({ mode: 'salt', salt: 'Na2SO4', salt_concentration: 0.1 }, c, raw).value, 0.3, 1e-12);
    close(electro.ionic_strength({ mode: 'ions', ions: 'Ca2+ 0.01\nCl- 0.02' }, c, raw).value, 0.03, 1e-12);
});

test('Born–Haber cycle for NaCl', () => {
    close(electro.lattice_energy({ formation: -411, sublimation: 107, ionization: 496, bond: 242, affinity: -349, nonmetal_atoms: 1 }, c, raw).value, -786, 1e-9);
});

test('gas laws', () => {
    close(physical.ideal_gas({ solve: 'v', moles: 1, pressure: 100000, temperature: 0, volume: NaN }, c, raw).value, 22.71095, 0.00001);
    close(physical.combined_gas({ law: 'boyle', p1: 100000, v1: 10, p2: 200000, t1: NaN, t2: NaN }, c, raw).value, 5, 1e-12);
    close(physical.combined_gas({ law: 'charles', v1: 10, t1: 0, t2: 273.15, p1: NaN, p2: NaN }, c, raw).value, 20, 1e-9);
    const roots = cubicRoots(1, -6, 11, -6);
    assert.deepEqual(roots.map((x) => Math.round(x * 1e9) / 1e9), [1, 2, 3]);
    const vdw = physical.van_der_waals({ gas: 'carbon_dioxide', solve: 'p', moles: 1, temperature: 0, volume: 22.4, pressure: NaN }, c, raw);
    close(vdw.value / 100, ((0.0831446262 * 273.15) / (22.4 - 0.04267) - 3.6 / 22.4 ** 2), 1e-9);
});

test('effusion, diffusion and half-life', () => {
    close(physical.effusion({ gas1: 'H2', gas2: 'O2', temperature: 25, rate2: NaN }, c, raw).value, Math.sqrt(31.998 / 2.016), 1e-9);
    close(physical.half_life({ solve: 'remaining', initial: 100, time: 30, half_life: 10, remaining: NaN }, c, raw).value, 12.5, 1e-12);
    // Carbon-14: 5700 y (NUBASE2020); after one half-life half remains.
    const carbon = physical.radioactive_decay({ isotope: 'carbon_14', initial: 100, time: DATA.isotopes.carbon_14.half_life_s, amount_unit: 'percent', half_life: NaN }, c, raw);
    close(carbon.value, 50, 1e-9);
});

test('Langmuir, osmotic pressure and partial pressures', () => {
    close(physical.langmuir({ mode: 'coverage', k: 2, pressure: 0.5, q_max: NaN }, c, raw).value, 0.5, 1e-12);
    close(physical.osmotic({ mode: 'pressure', molarity: 0.1, temperature: 25, vant_hoff: 1 }, c, raw).value, (0.1 * 1000 * 8.314462618 * 298.15) / 1000, 1e-6);
    const air = physical.partial_pressure({ mode: 'fractions', gases: 'N2 0.78084\nO2 0.20946\nAr 0.00934', total_pressure: 101325 }, c, f);
    assert.match(air.lists.gases[1].value, /21\.23/);
});

test('crystals, Miller indices and surface tension', () => {
    // Copper, FCC with a = 361.49 pm: ρ = 4 × 63.546 ÷ (Nₐ a³) = 8.935 g/cm³.
    close(physical.cubic_cell({ lattice: 'fcc', element: 'Cu', mode: 'edge', edge: 361.49e-12, radius: NaN }, c, raw).value, (4 * 63.546) / (6.02214076e23 * 3.6149e-8 ** 3), 1e-9);
    assert.deepEqual(millerFromIntercepts([1, 2, Infinity]), [2, 1, 0]);
    assert.deepEqual(millerFromIntercepts([0.5, 1, 1]), [2, 1, 1]);
    close(waterSurfaceTension(298.15) * 1000, 71.97, 0.01);
    close(physical.young_laplace({ liquid: 'water', temperature: 25, shape: 'drop', r1: 0.001, r2: NaN, tension: NaN }, c, raw).value, 2 * waterSurfaceTension(298.15) / 0.001, 1e-9);
});

test('photons, matter waves and Henry\'s law', () => {
    // Balmer alpha (3 → 2) is 656.5 nm in vacuum.
    const balmer = physical.photon_energy({ mode: 'hydrogen', n1: 2, n2: 3 }, c, f);
    assert.match(balmer.rows.wavelength, /^656\.4/);
    close(physical.photon_energy({ mode: 'wavelength', wavelength: 500 }, c, raw).value, 2.4797, 0.0001);
    // A 100 eV electron has λ ≈ 122.6 pm.
    close(physical.de_broglie({ particle: 'electron', mode: 'energy', energy: 100, speed: NaN, mass: NaN }, c, raw).value, 122.6, 0.1);
    close(physical.henry({ gas: 'o2', temperature: 25, direction: 'concentration', pressure: 0.20946 * 101325 }, c, raw).value, 1.3e-3 * 0.20946 * 1000, 1e-9);
});

test('organic: COD, combustion, unsaturation, protein, ethylene and radiocarbon', () => {
    close(organic.cod({ mode: 'dichromate', blank: 10, sample_titrant: 6, normality: 0.25, sample_volume: 20 }, c, raw).value, 400, 1e-9);
    close(organic.cod({ mode: 'theoretical', formula: 'C6H12O6', concentration: NaN }, c, raw).value, (6 * 2 * 15.999) / 180.156, 1e-9);
    assert.equal(organic.combustion_analysis({ sample: 0.255, co2: 0.561, h2o: 0.306, n_mass: NaN, molar_mass: NaN }, c, f).value, 'C₃H₈O');
    assert.equal(organic.combustion_reaction({ fuel: 'C3H8' }, c, f).value, 'C₃H₈ + 5O₂ → 3CO₂ + 4H₂O');
    assert.equal(degreeOfUnsaturation(parseFormula('C6H6', ELEMENTS).counts), 4);
    assert.equal(degreeOfUnsaturation(parseFormula('C2H3Cl', ELEMENTS).counts), 1);
    close(organic.crude_protein({ food: 'milk', nitrogen: 0.5, factor: NaN }, c, raw).value, 3.19, 1e-9);
    const ethylene = organic.ethylene_density({ temperature: -103.77 }, c, raw);
    close(ethylene.value, 567.9, 1.5);
    close(organic.radiocarbon({ input: 'percent', value: 50, modern: NaN }, c, raw).value, 5568, 1);
});

test('biochemistry: calibration, enzyme activity, pI and Michaelis–Menten', () => {
    const calibration = biochem.calibration({ standards: '0 0.002\n1 0.101\n2 0.198\n4 0.401\n8 0.799', unknowns: '0.3' }, c, f);
    assert.match(calibration.value, /^y = 0\.09975x/);
    // NADH assay: ΔA 0.1/min, ε 6220, 1 cm, 1 mL total, 0.1 mL enzyme.
    close(biochem.enzyme_activity({ rate: 0.1, epsilon: 6220, path: 1, total_volume: 1, enzyme_volume: 0.1, dilution: NaN, protein: NaN }, c, raw).value, ((0.1 / 6220) * 0.001 * 1e6) / 0.1, 1e-12);
    // Same results as Biopython's IsoelectricPoint (Bjellqvist values).
    close(isoelectricPoint('INGAR', DATA.pka_sets.bjellqvist), 9.75, 0.001);
    close(netCharge('INGAR', 7, DATA.pka_sets.bjellqvist), 0.7601, 0.0001);
    close(isoelectricPoint('MQIFVKTLTGKTITLEVEPSDTIENVKAKIQDKEGIPPDQQRLIFAGKQLEDGRTLSDYNIQKESTLHLVLRLRGG', DATA.pka_sets.bjellqvist), 6.5616, 0.001);
    const fit = biochem.michaelis_menten({ mode: 'fit', data: [0.5, 1, 2, 4, 8, 16].map((s) => `${s} ${(10 * s) / (2 + s)}`).join('\n'), enzyme: NaN }, c, raw);
    close(fit.rows.vmax, 10, 1e-6);
    close(fit.rows.km, 2, 1e-6);
    close(biochem.michaelis_menten({ mode: 'rate', vmax: 10, km: 2, substrate: 2, enzyme: NaN }, c, raw).value, 5, 1e-12);
});
