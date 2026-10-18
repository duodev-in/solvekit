import assert from 'node:assert/strict';
import { execSync } from 'node:child_process';
import test from 'node:test';
import { ellipsePerimeter, feetInches, sagitta, segmentArea, shapeArea } from '../construction/geometry.js';
import { handlers as area } from '../tools/con-area.js';
import { handlers as bulk } from '../tools/con-bulk.js';
import { blockCoreVolume, handlers as concrete, stairsVolume } from '../tools/con-concrete.js';
import { handlers as elec, voltageDrop } from '../tools/con-elec.js';
import { handlers as finish } from '../tools/con-finish.js';
import { handlers as framing, stairLayout } from '../tools/con-framing.js';
import { handlers as hvac } from '../tools/con-hvac.js';
import { handlers as mech, stressArea } from '../tools/con-mech.js';
import { handlers as roof, slopeFactor } from '../tools/con-roof.js';
import { handlers as trig } from '../tools/con-trig.js';
import { handlers as water, tankVolume } from '../tools/con-water.js';
import { handlers as weight, profileArea } from '../tools/con-weight.js';

const DATA = JSON.parse(execSync(`php -r 'echo json_encode(require "config/construction_data.php");'`).toString());
const c = { data: DATA };
const raw = (value) => value;
const num = (text) => Number(String(text).replace(/[^0-9.eE+-].*$/, ''));
const close = (actual, expected, tolerance) => assert.ok(Math.abs(Number(actual) - expected) <= tolerance, `${actual} ≠ ${expected}`);

const IN = 0.0254;
const FT = 0.3048;
const FT2 = FT * FT;
const C = (f) => ((f - 32) * 5) / 9;
const rows = (unit) => ({ [unit]: { factor: { ft: FT, in: IN, m: 1, ft2: FT2, m2: 1 }[unit] } });

test('geometry: shapes, ellipse perimeter, segments and sagitta', () => {
    close(shapeArea('rectangle', { length: 2, width: 3 }).area, 6, 1e-12);
    close(shapeArea('l_shape', { length: 10, width: 8, cut_length: 4, cut_width: 3 }).area, 68, 1e-12);
    close(shapeArea('ring', { outer: 2, inner: 1 }).area, (Math.PI / 4) * 3, 1e-12);
    close(ellipsePerimeter(5, 3), 25.526998863398, 1e-9);
    close(ellipsePerimeter(1, 0.01), 4.00109832972265, 1e-9);
    close(segmentArea(1, 1), Math.PI / 2, 1e-12);
    close(sagitta(24, 36).sagitta, 24 - Math.sqrt(24 ** 2 - 18 ** 2), 1e-12);
    assert.equal(feetInches(14.464 * FT), '14 ft 5 9/16 in');
});

test('cubic yards and gallons per square foot', () => {
    close(area.cubic_yard({ input: 'shape', shape: 'rectangle', length: 20 * FT, width: 10 * FT, depth: 4 * IN, count: 1, material: 'none' }, c, raw).value, 200 / 81, 1e-9);
    // 1 gal/ft² is 1.604 in deep.
    close(area.gallons_per_square_foot({ mode: 'depth', depth: (231 / 144) * IN }, c, raw).value, 1, 1e-9);
    close(area.gallons_per_square_foot({ mode: 'volume', volume: 5 * 3.785411784, area: 200 * FT2 }, c, raw).value, 0.025, 1e-12);
});

test('square footage from a rows editor', () => {
    const outcome = area.square_footage({ rooms: '12 14 1\n10 12 2\n8 6 1', rooms_unit: 'ft' }, { rowUnits: { rooms: rows('ft') } }, raw);
    close(outcome.value, 168 + 240 + 48, 1e-9);
});

test('gravel by Caterpillar loose density', () => {
    const outcome = bulk.aggregate({ input: 'shape', shape: 'rectangle', length: 20 * FT, width: 10 * FT, depth: 3 * IN, waste: 5, material: 'gravel', density: NaN }, c, raw);
    close(outcome.value, (52.5 * FT ** 3 * 1690) / 907.18474, 1e-9);
});

test('excavation swell uses bank and loose densities', () => {
    const outcome = bulk.excavation({ shape: 'rectangle', length: 30 * FT, width: 20 * FT, depth: 4 * FT, slope: 0, soil: 'earth_dry', truck: NaN }, c, raw);
    close(outcome.value, 2400 / 27, 1e-9);
    // Prismoid with 1 : 1 sides equals the exact volume of a truncated pyramid.
    const prism = bulk.excavation({ shape: 'rectangle', length: 2, width: 2, depth: 1, slope: 1, soil: 'earth_dry' }, c, raw);
    close(num(prism.value) * 0.764554857984, (1 / 3) * (4 + 16 + 8), 1e-9);
});

test('metal weights and pipe schedules', () => {
    // AISC L2×2×¼ = 3.19 lb/ft; NPS 2 sch 40 = 3.65 lb/ft.
    close(profileArea('angle', { width: 2 * IN, depth: 2 * IN, thickness: 0.25 * IN }) / IN ** 2, 0.9375, 1e-12);
    const angle = weight.metal_weight({ profile: 'angle', angle_a: 2 * IN, angle_b: 2 * IN, angle_t: 0.25 * IN, length: FT, count: 1, metal: 'steel', density: NaN }, c, raw);
    close(angle.value, 3.19, 0.005);
    const pipe = weight.pipe_weight({ mode: 'table', nps: '2', schedule: '40', length: FT, count: 1, metal: 'steel', density: NaN }, c, raw);
    close(pipe.value, 3.65, 0.01);
    const w8 = weight.metal_weight({ profile: 'w_shape', designation: 'W8x31', length: 20 * FT, count: 1 }, c, raw);
    close(w8.value, 620, 1e-9);
});

test('log weight from Wood Handbook data', () => {
    const outcome = weight.log_weight({ small: 12 * IN, large: 14 * IN, length: 16 * FT, species: 'white_oak', count: 1, condition: 'green', moisture: NaN }, c, raw);
    const volume = (16 * FT * ((Math.PI / 4) * (12 * IN) ** 2 + (Math.PI / 4) * (14 * IN) ** 2)) / 2;
    close(outcome.value, (volume * 600 * 1.71) / 0.45359237, 1e-6);
});

test('rebar grid with lap splices', () => {
    const outcome = weight.rebar({ length: 30 * FT, width: 20 * FT, spacing: 12 * IN, spacing_other: NaN, cover: 3 * IN, stock: 20 * FT, system: 'us', us_bar: '#4', lap: 40 }, c, raw);
    close(outcome.value, 20 * (29.5 + 40 / 24) + 30 * 19.5, 1e-6);
});

test('concrete volumes, stairs, blocks and mortar', () => {
    close(stairsVolume(3, 7, 11, 48), 48 * 7 * 11 * 6, 1e-9);
    close(blockCoreVolume(8 * IN, 1.25 * IN, 1 * IN) / IN ** 3, 2 * 5.125 * 6.3125 * 8, 1e-6);
    const slab = concrete.concrete({ form: 'slab', shape: 'rectangle', length: 12 * FT, width: 10 * FT, thickness: 4 * IN, count: 1, waste: 5 }, c, raw);
    close(slab.value, 42 / 27, 1e-9);
    const mortar = concrete.mortar({ area: 200 * FT2, unit_type: 'modular', joint: 0.375 * IN, type: 'n', waste: 0 }, c, raw);
    close(mortar.value, (200 * (144 / (8 * 2.625)) * 3.625 * (8 * 2.625 - 7.625 * 2.25)) / 1728, 1e-6);
    const cement = concrete.cement({ volume: 1000, mix: '1:2:4', dry: 1.54, bag: 'kg_50', wc: 0.5 }, c, raw);
    assert.equal(cement.value, 7);
    close(num(cement.rows.cement.split('(')[1]), (1.54 / 7) * 1440, 1e-6);
});

test('tile, carpet and wallpaper', () => {
    const tiles = finish.tile({ input: 'area', area: 100 * FT2, tile_length: 12 * IN, tile_width: 12 * IN, joint: 0.125 * IN, waste: 0 }, c, raw);
    assert.equal(tiles.value, 98);
    const carpet = finish.carpet({ rooms: '12 14', rooms_unit: 'ft', roll: 12 * FT, trim: 3 * IN }, { rowUnits: { rooms: rows('ft') } }, raw);
    close(carpet.value, 19, 1e-9);
    const paper = finish.wallpaper({ walls: '12 8\n14 8\n12 8\n14 8', walls_unit: 'ft', openings: '3 6.67 1', openings_unit: 'ft', roll_width: 20.5 * IN, roll_length: 33 * FT, repeat: 21 * IN, allowance: 4 * IN }, { rowUnits: { walls: rows('ft'), openings: rows('ft') } }, raw);
    assert.equal(paper.value, 11);
});

test('stairs, ramps and balusters meet their code limits', () => {
    const layout = stairLayout(108, 7.75, 10);
    assert.equal(layout.risers, 14);
    close(layout.riser, 108 / 14, 1e-12);
    const baluster = framing.baluster({ span: 70 * IN, sections: 4, baluster: 1.5 * IN, max_gap: 3.875 * IN }, c, raw);
    assert.equal(baluster.value, 52);
    close(num(baluster.rows.gap), 3.607142857, 1e-6);
    const ramp = framing.ramp({ rise: 24 * IN, slope: 12, landing: 60 * IN }, c, raw);
    close(ramp.value, 24, 1e-9);
});

test('roof pitch, rafters and birdsmouth', () => {
    close(slopeFactor(6), Math.sqrt(1.25), 1e-12);
    const roofing = roof.roofing({ length: 40 * FT, width: 30 * FT, pitch: 6, overhang: FT, type: 'gable', waste: 0, bundles: 3, roll: NaN }, c, raw);
    close(roofing.value, (42 * 32 * Math.sqrt(1.25)) / 100, 1e-9);
    const bird = roof.birdsmouth({ pitch: 6, depth: 7.25 * IN, seat: 3.5 * IN }, c, raw);
    assert.equal(bird.value, '1 3/4 in');
    const gambrel = roof.gambrel({ span: 16 * FT, method: 'semicircle' }, c, raw);
    assert.equal(gambrel.value, '8 ft 0 in');
});

test('heat loss and cooling loads', () => {
    const loss = hvac.heat_loss({ parts: '1200 13\n180 2\n40 2\n1500 38\n1500 19', parts_unit: 'ft2', r_units: 'ip', inside: C(70), outside: C(10), floor: 1500 * FT2, ceiling: 8 * FT, ach: 0.5 }, { rowUnits: { parts: rows('ft2') } }, raw);
    close(loss.value, (1200 / 13 + 90 + 20 + 1500 / 38 + 1500 / 19) * 60 + 0.018 * 12000 * 0.5 * 60, 1e-6);
    const tons = hvac.ac_tonnage({ load: 30000, equipment: 'ac' }, c, raw);
    close(tons.value, 2.5, 1e-12);
    const furnace = hvac.heating_size({ load: 45000, efficiency: 96 }, { data: {} }, raw);
    close(furnace.value, 46875, 1e-9);
});

test('tank volumes at any depth', () => {
    // Half-full horizontal cylinder holds half its volume; a sphere's cap at full depth is the whole sphere.
    const h = tankVolume('horizontal', 2, 5, 0, 1);
    close(h.filled, h.total / 2, 1e-12);
    close(tankVolume('sphere', 2, 0, 0, 2).filled, (4 / 3) * Math.PI, 1e-12);
    const cone = tankVolume('cone', 2, 3, 0, 1, 1);
    close(cone.filled, Math.PI / 3, 1e-12);
    const tank = water.tank({ tank: 'horizontal', diameter: 4 * FT, length: 10 * FT, fill: 30 * IN }, c, raw);
    close(tank.value, 618.05, 0.01);
});

test('fasteners, machining and welding', () => {
    close(stressArea('inch', 0.5 * IN, IN / 13) / IN ** 2, 0.1419, 0.0001);
    const torque = mech.bolt_torque({ system: 'inch', inch: '1/2', series: 'coarse', sae_grade: '5', percent: 75, nut_factor: 0.2 }, c, raw);
    close(torque.value, 75.38, 0.01);
    const rpm = mech.spindle_speed({ speed: 300, speed_unit: 'sfm', diameter: 0.5 * IN, teeth: 4, chip: 0.002 * IN }, c, raw);
    assert.equal(rpm.value, 2292);
    const weld = mech.welding({ leg: 0.25 * IN, length: 6 * IN, fexx: 70, efficiency: 65, load: NaN }, c, raw);
    close(weld.value, 0.3 * 70 * 0.70711 * 0.25 * 6, 0.001);
    const k = mech.k_factor({ mode: 'measure', thickness: 0.0625 * IN, radius: 0.0625 * IN, angle: 90, leg_a: IN, leg_b: IN, flat: 1.8825 * IN }, c, raw);
    close(k.value, 0.3496, 0.0001);
    const beam = mech.beam_deflection({ load_case: 'ss_uniform', span: 12 * FT, limit: '360', uniform: 100, w_units: 'lbft', section: 'rectangle', b: 1.5 * IN, h: 9.25 * IN, material: 'wood:douglas_fir' }, c, raw);
    close(beam.value, 0.2427, 0.0005);
});

test('NEC electrical tables', () => {
    close(voltageDrop(DATA.wires['12'], 'cu', 100 * FT, 16, 'single'), 6.336, 1e-9);
    const wire = elec.wire_size({ amps: 40, continuous: 'yes', material: 'cu', temp: '75', length: NaN, volts: 240, phase: 'single', max_drop: 3 }, c, raw);
    assert.equal(wire.value, '8 AWG');
    const fill = elec.conduit_fill({ conduit: 'emt', trade: '3/4', size1: '12', type1: 'thhn', count1: 6, size2: '10', type2: 'thhn', count2: 1, count3: 0 }, c, raw);
    close(fill.value, ((6 * 0.0133 + 0.0211) / 0.533) * 100, 1e-9);
    const box = elec.box_fill({ n14: 4, n12: 0, n10: 0, n8: 0, n6: 0, devices: 1, grounds: 2, clamps: 'yes', fittings: 0, box: 'none' }, c, raw);
    close(box.value, 16, 1e-12);
});

test('offsets, arches and vertical curves', () => {
    const offset = trig.rolling_offset({ offset: 12 * IN, roll: 8 * IN, angle: 45 }, c, raw);
    assert.equal(offset.value, '1 ft 8 3/8 in');
    const arch = trig.arch({ mode: 'rise', span: 48 * IN, rise: 8 * IN }, c, raw);
    assert.equal(arch.value, '3 ft 4 in');
    const crown = trig.angle_cut({ mode: 'crown', spring: 38, corner: 90 }, c, raw);
    close(crown.value, 31.62, 0.01);
    const curve = trig.vertical_curve({ g1: 3, g2: -2, length: 400, pvi_station: 1500, pvi_elevation: 250, interval: 50, units: 'ft' }, c, raw);
    close(curve.value, 247.6, 1e-9);
    const sag = trig.sagitta({ solve: 'radius', chord: 36, sag: 6, units: 'in' }, c, raw);
    close(sag.value, 30, 1e-12);
});
