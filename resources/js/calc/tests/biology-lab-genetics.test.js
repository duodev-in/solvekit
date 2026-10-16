import assert from 'node:assert/strict';
import test from 'node:test';
import { plainFormat } from '../engines/formula.js';
import { logistic, handlers as ecology, shannon, simpson } from '../tools/ecology.js';
import { chiSquarePValue, cross, handlers as genetics, parseGenotype, possibleBloodTypes } from '../tools/genetics.js';
import { doublingTime, henderson, handlers as lab, rcfFromRpm, rpmFromRcf } from '../tools/lab.js';
import { gcContent, meltingTemperature, proteinExtinction, proteinWeight, reverseComplement, translate, weightFromLength, handlers as sequence } from '../tools/sequence.js';

const close = (actual, expected, tolerance) => assert.ok(Math.abs(actual - expected) <= tolerance, `${actual} ≠ ${expected}`);
const f = plainFormat;

test('chi-square p-values match the critical value table', () => {
    close(chiSquarePValue(3.841, 1), 0.05, 1e-4);
    close(chiSquarePValue(7.815, 3), 0.05, 1e-4);
    close(chiSquarePValue(18.307, 10), 0.05, 1e-4);
    close(chiSquarePValue(0, 2), 1, 1e-12);
});

test('Mendel\'s dihybrid peas fit 9:3:3:1', () => {
    const outcome = genetics.chi_square({ observed: '315, 108, 101, 32', ratio: '9:3:3:1' }, {}, f);
    close(Number(outcome.value), 0.47, 0.001);
    assert.equal(outcome.rows.df, '3');
    assert.match(outcome.sub, /fit the expected ratio/);
});

test('Punnett crosses give the classic ratios', () => {
    const counts = (result) => Object.values(result.phenotypes).sort((a, b) => b - a);

    assert.deepEqual(counts(cross(parseGenotype('Aa'), parseGenotype('Aa'))), [3, 1]);
    assert.deepEqual(counts(cross(parseGenotype('AaBb'), parseGenotype('AaBb'))), [9, 3, 3, 1]);

    const trihybrid = cross(parseGenotype('AaBbCc'), parseGenotype('AaBbCc'));
    assert.equal(trihybrid.total, 64);
    assert.deepEqual(counts(trihybrid), [27, 9, 9, 9, 3, 3, 3, 1]);
    assert.equal(Object.keys(trihybrid.genotypes).length, 27);
    assert.equal(trihybrid.grid.rows.length, 8);
});

test('genotypes are normalised and validated', () => {
    assert.deepEqual(parseGenotype('aA'), [['A', 'a']]);
    assert.equal(parseGenotype('Ab'), null);
    assert.equal(parseGenotype('AaB'), null);
    assert.ok(genetics.dihybrid({ parent_a: 'AaBb', parent_b: 'Aa' }, {}, f).error);
    assert.ok(genetics.dihybrid({ parent_a: 'AaBb', parent_b: 'AaCc' }, {}, f).error);
});

test('blood types follow ABO and Rh inheritance', () => {
    assert.deepEqual(possibleBloodTypes('O', '-', 'O', '-'), { abo: ['O'], rh: ['-'] });
    assert.deepEqual(possibleBloodTypes('A', '+', 'B', '+'), { abo: ['A', 'B', 'AB', 'O'], rh: ['+', '-'] });
    assert.deepEqual(possibleBloodTypes('AB', '+', 'O', '-').abo, ['A', 'B']);
});

test('Hardy–Weinberg: 1 in 2,500 affected means about 1 in 26 carriers', () => {
    const outcome = genetics.hardy_weinberg({ mode: 'recessive', recessive: 0.04, population: NaN }, {}, f);
    assert.match(outcome.rows.carriers, /^1 in 25\.5/);
});

test('allele frequency from genotype counts', () => {
    const outcome = genetics.allele_frequency({ aa_dom: 360, het: 480, aa_rec: 160 }, {}, f);
    assert.equal(outcome.value, 'p = 0.6 · q = 0.4');
    assert.match(outcome.rows.hwe, /consistent/);
});

test('qPCR slope −3.32 is about 100% efficient', () => {
    close(Number(genetics.qpcr({ slope: -3.32 }, {}, f).value), 100, 0.2);
});

test('mutation rate by the p₀ method', () => {
    const outcome = genetics.mutation_rate({ cultures: 20, without: 8, cells: 2e8 }, {}, f);
    close(Number(outcome.rows.m), -Math.log(0.4), 1e-4);
});

test('sequence helpers', () => {
    assert.equal(reverseComplement('ATGCGTACGTTAGC'), 'GCTAACGTACGCAT');
    assert.equal(translate('ATGGCCATTGTAATGGGCCGCTGAAAGGGTGCCCGATAG'), 'MAIVMGR*KGAR*');
    close(gcContent('GGCCAATT'), 0.5, 1e-12);
    close(weightFromLength(1000, 'dsdna'), 617996.04, 0.01);
});

test('ubiquitin weighs about 8,565 Da with one tyrosine', () => {
    const ubiquitin = 'MQIFVKTLTGKTITLEVEPSDTIENVKAKIQDKEGIPPDQQRLIFAGKQLEDGRTLSDYNIQKESTLHLVLRLRGG';
    close(proteinWeight(ubiquitin), 8564.8, 1);
    assert.equal(proteinExtinction(ubiquitin).reduced, 1490);
});

test('primer Tm by nearest neighbour is in the expected range', () => {
    const tm = meltingTemperature('AGCGGATAACAATTTCACACAGGA', 0.05, 250e-9);
    assert.ok(tm > 55 && tm < 65, `Tm ${tm}`);
    assert.ok(meltingTemperature('GCGCGCGCGCGCGCGCGCGC') > meltingTemperature('ATATATATATATATATATAT'));
});

test('copy number: 1 ng of a 3 kb plasmid is about 3.2 × 10⁸ copies', () => {
    const outcome = sequence.copy_number({ mass: 1, length: 3000, type: 'dsdna', volume: NaN }, {}, (value) => value);
    close(outcome.value, 3.248e8, 1e6);
});

test('lab maths', () => {
    close(rcfFromRpm(13000, 8.4), 15871, 1);
    close(rpmFromRcf(rcfFromRpm(5000, 10), 10), 5000, 1e-6);
    assert.equal(henderson(7.48, 1, 1), 7.48);
    close(doublingTime(48, 2e5, 8e5), 24, 1e-9);
});

test('molarity: 1 M NaCl in 500 mL is 29.22 g', () => {
    const outcome = lab.molarity({ mode: 'mass', concentration: 1, conc_unit: 'M', volume: 0.5, weight: 58.44 }, {}, f);
    assert.equal(outcome.value, '29.22');
});

test('dilution: 10× to 1× in 100 mL takes 10 mL of stock', () => {
    const outcome = lab.dilution({ solve: 'v1', c1: 10, v1: NaN, c2: 1, v2: 100 }, {}, f);
    assert.equal(outcome.value, '10');
    assert.equal(outcome.rows.diluent, '90');
    assert.ok(lab.dilution({ solve: 'v1', c1: 1, c2: 10, v2: 100 }, {}, f).error);
});

test('hemocytometer: 200 cells in 4 squares at 1:1 is 10⁶ cells/mL', () => {
    const outcome = lab.hemocytometer({ count: 200, squares: 4, dilution: 2, dead: 10, volume: NaN }, {}, (value) => value);
    assert.equal(outcome.value, 1e6);
    assert.equal(outcome.rows.viability, '95%');
});

test('buffer recipe for a target pH', () => {
    const outcome = lab.buffer({ buffer: 'hepes', mode: 'ratio', target: 7.48, total: 100 }, { data: { hepes: { pka: 7.48 } } }, f);
    assert.equal(outcome.value, '1');
    assert.match(outcome.rows.acid, /^50 /);
});

test('log reduction: 3 log is 99.9%', () => {
    assert.equal(lab.log_reduction({ mode: 'log', log: 3 }, {}, f).rows.percent, '99.9%');
    assert.equal(lab.log_reduction({ mode: 'counts', start: 1e6, end: 100 }, {}, f).value, '4');
});

test('diversity indexes', () => {
    close(shannon([20, 20, 20, 20, 20]), Math.log(5), 1e-12);
    close(simpson([20, 20, 20, 20, 20]), 1900 / 9900, 1e-12);
    assert.equal(ecology.shannon({ counts: '20 20 20 20 20' }, {}, f).rows.evenness, '1');
    assert.ok(ecology.shannon({ counts: '3, x' }, {}, f).error);
});

test('logistic growth approaches the carrying capacity', () => {
    close(logistic(100, 0.1, 1000, 0), 100, 1e-9);
    close(logistic(100, 0.1, 1000, 500), 1000, 1e-6);
});

test('mark–recapture Chapman estimate', () => {
    const outcome = ecology.mark_recapture({ marked: 50, caught: 60, recaptured: 10 }, {}, f);
    assert.equal(outcome.value, '282');
    assert.equal(outcome.rows.lincoln, '300');
});
