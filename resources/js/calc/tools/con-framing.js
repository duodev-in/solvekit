import { FT, FT2, FT3, IN, RAD, YD3, ellipsePerimeter, feetInches, money } from '../construction/geometry.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Framing, decks, stairs, ramps, fences and small structures. Lengths arrive in meters.
 */
const BAG_80 = 0.6 * FT3;
const ceil = (value) => Math.ceil(value - 1e-9);

/**
 * Concrete (m³) around one post in a round hole.
 */
function postConcrete(holeDiameter, depth, postWidth, round = false) {
    const hole = (Math.PI / 4) * holeDiameter ** 2 * depth;
    const post = round ? (Math.PI / 4) * postWidth ** 2 * depth : postWidth ** 2 * depth;

    return Math.max(hole - post, 0);
}

/**
 * Stair geometry for a total rise with a maximum riser and a chosen tread.
 */
export function stairLayout(rise, maxRiser, tread) {
    const risers = ceil(rise / maxRiser);
    const riser = rise / risers;
    const treads = risers - 1;
    const run = treads * tread;

    return { risers, riser, treads, run, stringer: Math.hypot(rise, run + tread), angle: Math.atan2(riser, tread) / RAD };
}

export const handlers = {
    framing: (i, c, f) => {
        if (missing(i, 'length', 'height', 'spacing') || !(i.length > 0) || !(i.height > 0) || !(i.spacing > 0)) {
            return { empty: 'Enter the wall length, height and stud spacing.' };
        }

        const openings = i.openings > 0 ? Math.round(i.openings) : 0;
        const corners = i.corners > 0 ? Math.round(i.corners) : 0;
        const base = Math.floor(i.length / i.spacing + 1e-9) + 1;
        const studs = ceil((base + 4 * openings + 2 * corners) * (1 + (i.waste > 0 ? i.waste / 100 : 0)));
        const plates = 3 * i.length;
        const header = openings && i.opening_width > 0 ? 2 * openings * (i.opening_width + 3 * IN) : 0;
        const studLength = i.height - 3 * 1.5 * IN;

        return {
            value: f(studs),
            unit: 'studs',
            label: 'Studs',
            sub: `${base} at ${f(i.spacing / IN)} in on center, + 4 per opening (king and jack) + 2 per corner`,
            rows: {
                plates: `${f(plates / FT)} ft of plate (1 bottom + 2 top)`,
                headers: header ? `${f(header / FT)} ft of header stock (2 plies)` : 'No openings',
                stud_length: `${feetInches(studLength)} precut (wall height less three 1½ in plates)`,
                board_feet: `${f((((studs * studLength + plates + header) / FT) * 2 * (Number(i.stud_size) || 4)) / 12)} bf of 2×${Number(i.stud_size) || 4} (nominal)`,
            },
        };
    },

    decking: (i, c, f) => {
        if (missing(i, 'length', 'width', 'board_width', 'board_length', 'joist_spacing') || !(i.length > 0) || !(i.width > 0) || !(i.board_width > 0) || !(i.board_length > 0) || !(i.joist_spacing > 0)) {
            return { empty: 'Enter the deck size, board width and length, and joist spacing.' };
        }

        const gap = i.gap > 0 ? i.gap : 0;
        const rows = ceil(i.width / (i.board_width + gap));
        const perRow = ceil(i.length / i.board_length);
        const boards = ceil(rows * perRow * (1 + (i.waste > 0 ? i.waste / 100 : 0)));
        const joists = Math.floor(i.length / i.joist_spacing + 1e-9) + 1;
        const screws = rows * joists * 2;

        return {
            value: f(boards),
            unit: 'boards',
            label: 'Deck boards',
            sub: `${rows} rows × ${perRow} board${perRow > 1 ? 's' : ''} of ${f(i.board_length / FT)} ft${i.waste > 0 ? `, plus ${f(i.waste)}%` : ''}`,
            rows: {
                linear: `${f((rows * i.length) / FT)} linear ft of decking`,
                joists: `${joists} joists of ${f(i.width / FT)} ft at ${f(i.joist_spacing / IN)} in on center`,
                screws: `${f(screws)} screws (2 per board at each joist), or ${f(rows * joists)} hidden clips`,
                area: `${f((i.length * i.width) / FT2)} ft²`,
                cost: i.price > 0 ? money(boards * i.price) : 'Enter a price per board',
            },
        };
    },

    /**
     * Balusters per section with an equal gap; the IRC R312.1.3 limit is that a 4 in sphere must not pass.
     */
    baluster: (i, c, f) => {
        if (missing(i, 'span', 'sections', 'baluster', 'max_gap') || !(i.span > 0) || !(i.sections >= 1) || !(i.baluster > 0) || !(i.max_gap > 0)) {
            return { empty: 'Enter the clear span between posts, the sections, the baluster width and the gap limit.' };
        }

        const perSection = Math.max(ceil((i.span - i.max_gap) / (i.baluster + i.max_gap)), 0);
        const gap = (i.span - perSection * i.baluster) / (perSection + 1);
        const total = perSection * Math.round(i.sections);
        const ok = gap < 4 * IN;

        return {
            value: f(total),
            unit: 'balusters',
            label: 'Balusters',
            sub: `${perSection} per section with ${f(gap / IN)} in gaps (${f((gap + i.baluster) / IN)} in on center)`,
            rows: {
                per_section: `${perSection}`,
                gap: `${f(gap / IN)} in (${f(gap * 1000)} mm)`,
                spacing: `${f((gap + i.baluster) / IN)} in on center; first center ${f((gap + i.baluster / 2) / IN)} in from the post`,
                code: ok ? 'Under 4 in: meets IRC R312.1.3' : 'A 4 in sphere would pass: add balusters',
            },
        };
    },

    stair: (i, c, f) => {
        if (missing(i, 'rise', 'max_riser', 'tread') || !(i.rise > 0) || !(i.max_riser > 0) || !(i.tread > 0)) {
            return { empty: 'Enter the total rise, the maximum riser and the tread depth.' };
        }

        const s = stairLayout(i.rise, i.max_riser, i.tread);
        const comfort = (2 * s.riser + i.tread) / IN;
        const codeRiser = i.code === 'ibc' ? 7 * IN : 7.75 * IN;
        const codeTread = i.code === 'ibc' ? 11 * IN : 10 * IN;
        const issues = [];

        if (s.riser > codeRiser + 1e-9) {
            issues.push(`risers over ${f(codeRiser / IN)} in`);
        }

        if (i.tread < codeTread - 1e-9) {
            issues.push(`treads under ${f(codeTread / IN)} in`);
        }

        return {
            value: f(s.risers),
            unit: 'risers',
            label: 'Steps',
            sub: `${s.risers} risers of ${f(s.riser / IN)} in and ${s.treads} treads of ${f(i.tread / IN)} in`,
            rows: {
                riser: `${f(s.riser / IN)} in (${feetInches(s.riser)})`,
                run: `${feetInches(s.run)} total run (${f(s.run * 1000)} mm)`,
                stringer: `${feetInches(s.stringer)} stringer, before cuts at the ends`,
                angle: `${f(s.angle)}°`,
                comfort: `2R + T = ${f(comfort)} in (24–25 in is the usual comfort range)`,
                code: issues.length ? `Fails ${i.code === 'ibc' ? 'IBC 1011.5' : 'IRC R311.7.5'}: ${issues.join(', ')}` : `Meets ${i.code === 'ibc' ? 'IBC 1011.5.2 (7 in max riser, 11 in min tread)' : 'IRC R311.7.5 (7¾ in max riser, 10 in min tread)'}`,
            },
        };
    },

    /**
     * Spiral stairs checked against IRC R311.7.10.1: 26 in clear width, 6¾ in tread at the 12 in walkline,
     * risers at most 9½ in, 6 ft 6 in headroom.
     */
    spiral: (i, c, f) => {
        if (missing(i, 'height', 'diameter', 'rotation') || !(i.height > 0) || !(i.diameter > 0) || !(i.rotation > 0)) {
            return { empty: 'Enter the floor-to-floor height, the diameter and the rotation.' };
        }

        const risers = i.risers >= 2 ? Math.round(i.risers) : ceil(i.height / (9.5 * IN));
        const rise = i.height / risers;
        const treads = risers - 1;
        const angle = i.rotation / treads;
        const pole = i.pole > 0 ? i.pole : 0;
        const width = i.diameter / 2 - pole / 2;
        const walkline = pole / 2 + 12 * IN;
        const treadAtWalkline = walkline * angle * RAD;
        const perTurn = 360 / angle;
        const headroom = rise * perTurn - (i.thickness > 0 ? i.thickness : 0);
        const checks = [
            [rise <= 9.5 * IN + 1e-9, `riser ${f(rise / IN)} in (≤ 9½)`],
            [width >= 26 * IN - 1e-9, `clear width ${f(width / IN)} in (≥ 26)`],
            [treadAtWalkline >= 6.75 * IN - 1e-9, `tread ${f(treadAtWalkline / IN)} in at the walkline (≥ 6¾)`],
            [headroom >= 78 * IN - 1e-9, `headroom ${f(headroom / IN)} in (≥ 78)`],
        ];
        const fails = checks.filter(([ok]) => !ok).map(([, text]) => text);

        return {
            value: f(treads),
            unit: 'treads',
            label: 'Spiral stair',
            sub: `${risers} risers of ${f(rise / IN)} in; ${f(angle)}° per tread`,
            rows: {
                rise: `${f(rise / IN)} in`,
                angle: `${f(angle)}° per tread`,
                walkline: `${f(treadAtWalkline / IN)} in deep at the walkline, ${f(walkline / IN)} in from the center`,
                headroom: `${f(headroom / IN)} in (${feetInches(headroom)})`,
                code: fails.length ? `Fails IRC R311.7.10.1: ${fails.join('; ')}` : 'Meets IRC R311.7.10.1',
            },
        };
    },

    /**
     * Ramps: ADA 405 allows 1 : 12 at most, 30 in of rise per run, 60 in landings, handrails over 6 in of rise.
     */
    ramp: (i, c, f) => {
        if (missing(i, 'rise', 'slope') || !(i.rise > 0) || !(i.slope > 0)) {
            return { empty: 'Enter the total rise and the slope.' };
        }

        const run = i.rise * i.slope;
        const segments = ceil(i.rise / (30 * IN));
        const landings = segments - 1;
        const landing = i.landing > 0 ? i.landing : 60 * IN;
        const total = run + landings * landing;
        const steep = i.slope < 12;

        return {
            value: f(run / FT),
            unit: 'ft of ramp',
            label: 'Ramp run',
            sub: `1 : ${f(i.slope)} slope (${f(100 / i.slope)}%, ${f(Math.atan(1 / i.slope) / RAD)}°) for ${f(i.rise / IN)} in of rise`,
            rows: {
                run: `${feetInches(run)} (${f(run)} m) of sloped ramp`,
                landings: landings ? `${landings} intermediate landing${landings > 1 ? 's' : ''} of ${f(landing / IN)} in (30 in rise per run)` : 'None needed',
                total: `${feetInches(total)} overall, plus top and bottom landings`,
                handrails: i.rise > 6 * IN ? 'Required on both sides (rise over 6 in)' : 'Not required (rise 6 in or less)',
                code: steep ? 'Steeper than 1 : 12: does not meet ADA 405.2' : 'Meets the ADA 405.2 running slope',
            },
        };
    },

    fence: (i, c, f) => {
        let length;
        let closed = false;

        if (i.layout === 'rectangle') {
            if (!(i.side_a > 0) || !(i.side_b > 0)) {
                return { empty: 'Enter both sides of the rectangle.' };
            }

            length = 2 * (i.side_a + i.side_b);
            closed = true;
        } else {
            length = i.length;
        }

        if (!(length > 0) || !(i.spacing > 0)) {
            return { empty: 'Enter the fence length and post spacing.' };
        }

        const gates = i.gates > 0 ? Math.round(i.gates) : 0;
        const gateWidth = gates * (i.gate_width > 0 ? i.gate_width : 0);
        const net = length - gateWidth;

        if (net <= 0) {
            return { error: 'The gates are wider than the fence.' };
        }

        const sections = ceil(net / i.spacing);
        const posts = (closed ? sections : sections + 1) + gates;
        const rails = sections * (i.rails > 0 ? Math.round(i.rails) : 0);
        const pickets = i.picket > 0 ? ceil(net / (i.picket + (i.picket_gap > 0 ? i.picket_gap : 0))) : null;
        const concrete = i.hole > 0 && i.depth > 0 && i.post > 0 ? postConcrete(i.hole, i.depth, i.post) * posts : 0;

        return {
            value: f(posts),
            unit: 'posts',
            label: 'Fence posts',
            sub: `${f(length / FT)} ft of fence${closed ? ' around the rectangle' : ''}, ${sections} sections${gates ? `, ${gates} gate${gates > 1 ? 's' : ''}` : ''}`,
            rows: {
                perimeter: `${f(length / FT)} ft (${f(length)} m)`,
                rails: `${f(rails)} rails`,
                pickets: pickets === null ? 'Enter a picket width' : `${f(pickets)} pickets`,
                concrete: concrete ? `${f(concrete / FT3)} ft³: ${f(ceil(concrete / BAG_80))} bags of 80 lb` : 'Enter the hole size',
            },
        };
    },

    vinyl_fence: (i, c, f) => {
        if (missing(i, 'length', 'panel') || !(i.length > 0) || !(i.panel > 0)) {
            return { empty: 'Enter the fence length and panel width.' };
        }

        const gates = i.gates > 0 ? Math.round(i.gates) : 0;
        const net = i.length - gates * (i.gate_width > 0 ? i.gate_width : 0);

        if (net <= 0) {
            return { error: 'The gates are wider than the fence.' };
        }

        const panels = ceil(net / i.panel);
        const posts = panels + 1 + gates;
        const concrete = i.hole > 0 && i.depth > 0 && i.post > 0 ? postConcrete(i.hole, i.depth, i.post) * posts : 0;

        return {
            value: f(panels),
            unit: 'panels',
            label: 'Fence panels',
            sub: `${f(net / FT)} ft of panels at ${f(i.panel / FT)} ft on center`,
            rows: {
                posts: `${posts} posts (${posts} caps)`,
                gates: gates ? `${gates} gate${gates > 1 ? 's' : ''}` : 'No gates',
                concrete: concrete ? `${f(concrete / FT3)} ft³: ${f(ceil(concrete / BAG_80))} bags of 80 lb` : 'Enter the hole size',
                cost: i.price > 0 ? money(panels * i.price) : 'Enter a price per panel',
            },
        };
    },

    /**
     * Post depth by the common rules (a third or half of the exposed height) and at least below the frost line.
     */
    post_depth: (i, c, f) => {
        if (missing(i, 'height', 'post') || !(i.height > 0) || !(i.post > 0)) {
            return { empty: 'Enter the height above ground and the post width.' };
        }

        const share = i.rule === 'half' ? 0.5 : 1 / 3;
        const byRule = i.height * share;
        const byFrost = i.frost > 0 ? i.frost + (i.below > 0 ? i.below : 0) : 0;
        const depth = Math.max(byRule, byFrost, 24 * IN);
        const hole = 3 * i.post;
        const concrete = postConcrete(hole, depth, i.post);
        const total = i.height + depth;
        const stock = [8, 10, 12, 14, 16].map((ft) => ft * FT).find((len) => len >= total - 1e-9);

        return {
            value: f(depth / IN),
            unit: 'in deep',
            label: 'Post hole depth',
            sub: depth === byFrost ? 'Set by the frost line' : depth === byRule ? `${i.rule === 'half' ? 'Half' : 'One third'} of the exposed height` : 'Minimum 2 ft',
            rows: {
                rule: `${f(byRule / IN)} in by the ${i.rule === 'half' ? 'one-half' : 'one-third'} rule`,
                frost: byFrost ? `${f(byFrost / IN)} in for the frost line` : 'Enter your frost depth',
                hole: `${f(hole / IN)} in across (3 × the post width)`,
                post: `${feetInches(total)} overall${stock ? `: buy ${f(stock / FT)} ft posts` : ''}`,
                concrete: `${f(concrete / FT3)} ft³ per post (${f(ceil(concrete / BAG_80))} bags of 80 lb)`,
            },
        };
    },

    shed_cost: (i, c, f) => {
        if (missing(i, 'length', 'width', 'wall_height', 'pitch') || !(i.length > 0) || !(i.width > 0) || !(i.wall_height > 0) || !(i.pitch >= 0)) {
            return { empty: 'Enter the shed size, wall height and roof pitch.' };
        }

        const L = i.length;
        const W = i.width;
        const overhang = i.overhang > 0 ? i.overhang : 0;
        const rafter = (W / 2 + overhang) * Math.hypot(1, i.pitch / 12);
        const roofArea = 2 * rafter * (L + 2 * overhang);
        const gable = 2 * ((W / 2) * (W / 2) * (i.pitch / 12));
        const wallArea = 2 * (L + W) * i.wall_height + gable;
        const sheet = 32 * FT2;
        const floorSheets = ceil((L * W) / sheet * 1.1);
        const wallSheets = ceil((wallArea / sheet) * 1.1);
        const roofSheets = ceil((roofArea / sheet) * 1.1);
        const studs = ceil((2 * (Math.floor(L / (16 * IN)) + 1) + 2 * (Math.floor(W / (16 * IN)) + 1) + 8) * 1.1);
        const joists = Math.floor(L / (16 * IN)) + 1;
        const rafters = 2 * (Math.floor(L / (24 * IN)) + 1);
        const squares = (roofArea / (100 * FT2)) * 1.1;
        const lines = [
            ['Floor sheathing', floorSheets, 'sheets', i.sheet_price],
            ['Wall sheathing or siding panels', wallSheets, 'sheets', i.siding_price > 0 ? i.siding_price : i.sheet_price],
            ['Roof sheathing', roofSheets, 'sheets', i.sheet_price],
            ['Wall studs', studs, 'studs', i.stud_price],
            ['Floor joists', joists, `joists of ${f(W / FT)} ft`, i.joist_price],
            ['Rafters', rafters, `rafters of ${f(rafter / FT)} ft`, i.joist_price],
            ['Roofing', Math.round(squares * 100) / 100, 'squares', i.roofing_price],
            ['Door, windows and hardware', 1, 'lot', i.other],
        ];
        const total = lines.reduce((sum, [, qty, , cost]) => sum + (cost > 0 ? qty * cost : 0), 0);

        return {
            value: money(total),
            unit: '',
            label: 'Materials cost',
            sub: `${f(L / FT)} × ${f(W / FT)} ft shed: ${money(total / ((L * W) / FT2))} per ft² of floor, from your prices`,
            rows: { floor: `${f((L * W) / FT2)} ft²`, roof: `${f(roofArea / FT2)} ft² of roof (${f(squares)} squares with 10%)`, walls: `${f(wallArea / FT2)} ft² of wall including gables`, rafter: `${feetInches(rafter)} rafters at ${f(i.pitch)}/12` },
            lists: { lines: lines.map(([label, qty, what, cost]) => ({ label: `${label}: ${f(qty)} ${what}`, value: cost > 0 ? money(qty * cost) : 'No price' })) },
        };
    },

    hoop_house: (i, c, f) => {
        if (missing(i, 'width', 'length', 'height', 'spacing') || !(i.width > 0) || !(i.length > 0) || !(i.height > 0) || !(i.spacing > 0)) {
            return { empty: 'Enter the width, length, height and hoop spacing.' };
        }

        const arc = ellipsePerimeter(i.width / 2, i.height) / 2;
        const hoops = Math.floor(i.length / i.spacing + 1e-9) + 1;
        const bury = i.bury > 0 ? i.bury : 0;
        const sheetWidth = arc + 2 * bury;
        const sheetLength = i.length + 2 * (i.height + bury);
        const endArea = (Math.PI / 4) * i.width * i.height;

        return {
            value: f(hoops),
            unit: 'hoops',
            label: 'Hoops',
            sub: `Each hoop ${feetInches(arc)} long${i.leg > 0 ? `, plus ${f((2 * i.leg) / IN)} in into the ground` : ''}`,
            rows: {
                hoop: `${feetInches(arc + (i.leg > 0 ? 2 * i.leg : 0))} of tubing per hoop, ${f(((arc + (i.leg > 0 ? 2 * i.leg : 0)) * hoops) / FT)} ft in total`,
                plastic: `${f(sheetWidth / FT)} × ${f(sheetLength / FT)} ft sheet (covers the ends)`,
                floor: `${f((i.width * i.length) / FT2)} ft² of growing area`,
                ends: `${f(endArea / FT2)} ft² per end wall`,
            },
        };
    },

    round_pen: (i, c, f) => {
        if (missing(i, 'diameter', 'panel') || !(i.diameter > 0) || !(i.panel > 0)) {
            return { empty: 'Enter the pen diameter and the panel length.' };
        }

        const circumference = Math.PI * i.diameter;
        const gate = i.gate > 0 ? i.gate : 0;
        const panels = ceil((circumference - gate) / i.panel);
        const sides = panels + (gate > 0 ? 1 : 0);
        // A ring of equal straight panels is a regular polygon; with the gate as one more side of about panel length.
        const radius = i.panel / (2 * Math.sin(Math.PI / sides));

        return {
            value: f(panels),
            unit: 'panels',
            label: 'Panels',
            sub: `${f(circumference / FT)} ft around${gate ? `, less a ${f(gate / FT)} ft gate` : ''}`,
            rows: { circumference: `${f(circumference / FT)} ft (${f(circumference)} m)`, actual: `${f((2 * radius) / FT)} ft across with ${sides} equal sides`, area: `${f((Math.PI / 4) * i.diameter ** 2 / FT2)} ft²` },
        };
    },

    /**
     * Ladder angle; OSHA 1926.1053(b)(5)(i) puts the base a quarter of the working length out (about 75.5°).
     */
    ladder: (i, c, f) => {
        if (missing(i, 'length') || !(i.length > 0)) {
            return { empty: 'Enter the ladder length.' };
        }

        let base;
        let height;

        if (i.mode === 'height') {
            if (!(i.height > 0) || i.height >= i.length) {
                return { empty: 'Enter a height less than the ladder length.' };
            }

            height = i.height;
            base = Math.sqrt(i.length ** 2 - height ** 2);
        } else {
            if (!(i.base > 0) || i.base >= i.length) {
                return { empty: 'Enter a base distance less than the ladder length.' };
            }

            base = i.base;
            height = Math.sqrt(i.length ** 2 - base ** 2);
        }

        const angle = Math.atan2(height, base) / RAD;
        const ideal = i.length / 4;
        const ratio = height / base;

        return {
            value: f(angle),
            unit: '°',
            label: 'Ladder angle',
            sub: `${f(ratio)} : 1 rise to base; OSHA's 4 : 1 rule is 75.5°`,
            rows: {
                height: `${feetInches(height)} up the wall`,
                base: `${feetInches(base)} out from the wall`,
                ideal: `${feetInches(ideal)} out (¼ of the length) for 4 : 1, reaching ${feetInches(Math.sqrt(i.length ** 2 - ideal ** 2))}`,
                check: Math.abs(angle - 75.52) <= 2.5 ? 'Close to 4 : 1' : angle > 75.52 ? 'Too steep: move the base out' : 'Too shallow: move the base in',
            },
        };
    },
};

export default defineTools(handlers);
