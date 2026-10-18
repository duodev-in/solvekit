import { FT, FT2, FT3, GAL, IN, YD2, money, readRows, shapeArea } from '../construction/geometry.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Finishes and coverings: drywall, paint, tile, flooring, carpet, wallpaper, siding, trim, stain and sealant.
 * Lengths arrive in meters, areas in m², volumes in liters.
 */
const factor = (c, name, unit) => c.rowUnits?.[name]?.[unit]?.factor ?? 1;
const extra = (percent) => 1 + (percent > 0 ? percent / 100 : 0);

/**
 * Walls from a rows editor (length × height) and openings (width × height × count), net area in m².
 */
function wallArea(i, c, wallsName = 'walls', openingsName = 'openings') {
    const wf = factor(c, wallsName, i[`${wallsName}_unit`]);
    const walls = readRows(i[wallsName], [wf, wf]).filter(([l, h]) => l > 0 && h > 0);
    let openings = 0;

    if (i[openingsName] !== undefined) {
        const of = factor(c, openingsName, i[`${openingsName}_unit`]);
        openings = readRows(i[openingsName], [of, of, 1]).filter(([w, h]) => w > 0 && h > 0).reduce((sum, [w, h, n]) => sum + w * h * (n > 0 ? n : 1), 0);
    }

    const gross = walls.reduce((sum, [l, h]) => sum + l * h, 0);

    return { walls, gross, openings, net: gross - openings, length: walls.reduce((sum, [l]) => sum + l, 0) };
}

function roomRows(i, c, name = 'rooms') {
    const rf = factor(c, name, i[`${name}_unit`]);

    return readRows(i[name], [rf, rf]).filter(([l, w]) => l > 0 && w > 0);
}

/**
 * Gallons and liters, with the gallons split into whole gallons and quarts to buy.
 */
function paintRows(liters, f) {
    const gallons = liters / (GAL * 1000);
    const quarts = Math.ceil(gallons * 4 - 1e-9);

    return { liters: `${f(liters)} L`, buy: `${Math.floor(quarts / 4)} gal + ${quarts % 4} qt` };
}

export const handlers = {
    drywall: (i, c, f) => {
        const area = wallArea(i, c);
        const ceiling = i.ceiling > 0 ? i.ceiling : 0;

        if (!area.walls.length && !ceiling) {
            return { empty: 'Enter at least one wall or a ceiling area.' };
        }

        const net = area.net + ceiling;

        if (net <= 0) {
            return { error: 'The openings are larger than the walls.' };
        }

        const [sw, sl] = String(i.sheet).split('x').map((v) => Number(v) * FT);
        const sheets = Math.ceil((net * extra(i.waste)) / (sw * sl) - 1e-9);
        // Screws at IRC Table R702.3.5 spacing over framing at the stud spacing: 16 in on walls, 12 in on ceilings.
        const framing = i.spacing > 0 ? i.spacing : 16 * IN;
        const perSheet = (spacing) => (Math.floor(sw / framing + 1e-9) + 1) * (Math.floor(sl / spacing + 1e-9) + 1);
        const wallSheets = (area.net / net) * sheets;
        const screws = Math.ceil(wallSheets * perSheet(16 * IN) + (sheets - wallSheets) * perSheet(12 * IN));
        const tape = sheets * (sw + sl);

        return {
            value: f(sheets),
            unit: 'sheets',
            label: 'Drywall sheets',
            sub: `${f(net / FT2)} ft² at ${f(sw / FT)} × ${f(sl / FT)} ft${i.waste > 0 ? `, plus ${f(i.waste)}%` : ''}`,
            rows: {
                area: `${f(net / FT2)} ft² (${f(net)} m²)`,
                screws: `${f(screws)} screws (16 in apart on walls, 12 in on ceilings)`,
                tape: `${f(tape / FT)} ft of joint tape (${f(Math.ceil(tape / (250 * FT) - 1e-9))} rolls of 250 ft)`,
                cost: i.price > 0 ? money(sheets * i.price) : 'Enter a price per sheet',
            },
        };
    },

    paint: (i, c, f) => {
        const area = wallArea(i, c);
        const ceiling = i.ceiling > 0 ? i.ceiling : 0;

        if (!area.walls.length && !ceiling) {
            return { empty: 'Enter at least one wall or a ceiling area.' };
        }

        const net = area.net + ceiling;

        if (net <= 0) {
            return { error: 'The openings are larger than the walls.' };
        }

        if (!(i.coverage > 0)) {
            return { empty: 'Enter the coverage from the paint label.' };
        }

        const coats = i.coats > 0 ? i.coats : 1;
        const coverage = i.coverage * FT2 / GAL / 1000; // m² per liter
        const liters = (net * coats) / coverage;
        const primer = i.primer ? net / coverage : 0;

        return {
            value: f(liters / (GAL * 1000)),
            unit: 'gal',
            label: 'Paint needed',
            sub: `${f(net / FT2)} ft² × ${f(coats)} coat${coats > 1 ? 's' : ''} at ${f(i.coverage)} ft² per gallon`,
            rows: { ...paintRows(liters, f), area: `${f(net / FT2)} ft² (${f(net)} m²)`, primer: primer ? `${f(primer / (GAL * 1000))} gal of primer (one coat)` : 'No primer', cost: i.price > 0 ? money(Math.ceil(liters / (GAL * 1000) - 1e-9) * i.price) : 'Enter a price per gallon' },
        };
    },

    tile: (i, c, f) => {
        let area;

        if (i.input === 'area') {
            area = i.area;
        } else {
            const plan = shapeArea(i.shape, i);

            if (plan.empty || plan.error) {
                return plan;
            }

            area = plan.area;
        }

        if (!(area > 0) || !(i.tile_length > 0) || !(i.tile_width > 0) || !(i.joint >= 0)) {
            return { empty: 'Enter the area, tile size and joint width.' };
        }

        const perTile = (i.tile_length + i.joint) * (i.tile_width + i.joint);
        const tiles = Math.ceil((area / perTile) * extra(i.waste) - 1e-9);
        const boxes = i.per_box > 0 ? Math.ceil(tiles / i.per_box - 1e-9) : null;

        const noun = c.data?.noun ?? 'tiles';

        return {
            value: f(tiles),
            unit: noun,
            label: `${noun[0].toUpperCase()}${noun.slice(1)} needed`,
            sub: `${f(area / FT2)} ft² ÷ ${f(perTile / (IN * IN))} in² per tile with joint${i.waste > 0 ? `, plus ${f(i.waste)}%` : ''}`,
            rows: {
                boxes: boxes === null ? 'Enter tiles per box' : `${f(boxes)} boxes of ${f(i.per_box)}`,
                area: `${f(area / FT2)} ft² (${f(area)} m²)`,
                per_ft2: `${f(FT2 / perTile)} ${noun} per ft²`,
                cost: i.price > 0 ? money(tiles * i.price) : `Enter a price per ${noun.replace(/s$/, '')}`,
            },
        };
    },

    flooring: (i, c, f) => {
        const rooms = roomRows(i, c);

        if (!rooms.length) {
            return { empty: 'Enter the length and width of at least one room.' };
        }

        const area = rooms.reduce((sum, [l, w]) => sum + l * w, 0);
        const needed = area * extra(i.waste);
        const boxes = i.box > 0 ? Math.ceil(needed / i.box - 1e-9) : null;

        return {
            value: boxes === null ? f(needed / FT2) : f(boxes),
            unit: boxes === null ? 'ft²' : 'boxes',
            label: 'Flooring needed',
            sub: `${f(area / FT2)} ft² of floor${i.waste > 0 ? ` plus ${f(i.waste)}% = ${f(needed / FT2)} ft²` : ''}`,
            rows: {
                area: `${f(area / FT2)} ft² (${f(area)} m²)`,
                with_waste: `${f(needed / FT2)} ft² (${f(needed)} m²)`,
                boxes: boxes === null ? 'Enter the coverage per box' : `${f(boxes)} boxes covering ${f((boxes * i.box) / FT2)} ft²`,
                cost: i.price > 0 ? money((boxes === null ? needed : boxes * i.box) / FT2 * i.price) : 'Enter a price per ft²',
            },
            lists: { rooms: rooms.map(([l, w], k) => ({ label: `Room ${k + 1}: ${f(l / FT)} × ${f(w / FT)} ft`, value: `${f((l * w) / FT2)} ft²` })) },
        };
    },

    /**
     * Carpet from a roll: each room is covered in strips across its width, laid along its length.
     */
    carpet: (i, c, f) => {
        const rooms = roomRows(i, c);

        if (!rooms.length || !(i.roll > 0)) {
            return { empty: 'Enter at least one room and the roll width.' };
        }

        const trim = i.trim > 0 ? i.trim : 0;
        let bought = 0;
        let net = 0;
        let seams = 0;
        const list = rooms.map(([a, b], k) => {
            // Lay strips along the longer side so fewer seams are needed.
            const [long, short] = a >= b ? [a, b] : [b, a];
            const strips = Math.ceil(short / i.roll - 1e-9);
            const piece = strips * (long + trim) * i.roll;
            bought += piece;
            net += a * b;
            seams += strips - 1;

            return { label: `Room ${k + 1}: ${strips} strip${strips > 1 ? 's' : ''} × ${f((long + trim) / FT)} ft`, value: `${f(piece / YD2)} yd²` };
        });

        return {
            value: f(bought / YD2),
            unit: 'yd²',
            label: 'Carpet to buy',
            sub: `${f(net / YD2)} yd² of floor; ${f(i.roll / FT)} ft roll${seams ? `, ${seams} seam${seams > 1 ? 's' : ''}` : ''}`,
            rows: {
                floor: `${f(net / FT2)} ft² (${f(net / YD2)} yd²)`,
                waste: `${f(((bought - net) / bought) * 100)}% offcut`,
                pad: `${f(net / YD2)} yd² of pad`,
                seams: `${seams}`,
                cost: i.price > 0 ? money((bought / YD2) * i.price) : 'Enter a price per yd²',
            },
            lists: { rooms: list },
        };
    },

    wallpaper: (i, c, f) => {
        const area = wallArea(i, c);

        if (!area.walls.length) {
            return { empty: 'Enter at least one wall.' };
        }

        if (!(i.roll_width > 0) || !(i.roll_length > 0)) {
            return { empty: 'Enter the roll width and length.' };
        }

        const repeat = i.repeat > 0 ? i.repeat : 0;
        const allowance = i.allowance > 0 ? i.allowance : 0;
        let strips = 0;
        let tallest = 0;

        area.walls.forEach(([length, height]) => {
            strips += Math.ceil(length / i.roll_width - 1e-9);
            tallest = Math.max(tallest, height);
        });

        const rawDrop = tallest + allowance;
        const drop = repeat ? Math.ceil(rawDrop / repeat - 1e-9) * repeat : rawDrop;
        const perRoll = Math.floor(i.roll_length / drop + 1e-9);

        if (perRoll < 1) {
            return { error: 'A strip is longer than a roll.' };
        }

        const saved = area.openings > 0 ? Math.floor(area.openings / (i.roll_width * drop)) : 0;
        const needed = Math.max(strips - saved, 0);
        const rolls = Math.ceil(needed / perRoll - 1e-9);

        return {
            value: f(rolls),
            unit: 'rolls',
            label: 'Wallpaper rolls',
            sub: `${needed} strips of ${f(drop / FT)} ft, ${perRoll} per roll`,
            rows: { strips: `${needed} strips (${strips} before openings)`, drop: `${f(drop / IN)} in per strip${repeat ? ` (to a ${f(repeat / IN)} in repeat)` : ''}`, area: `${f(area.net / FT2)} ft² of wall`, cost: i.price > 0 ? money(rolls * i.price) : 'Enter a price per roll' },
        };
    },

    siding: (i, c, f) => {
        const area = wallArea(i, c);
        const gf = factor(c, 'gables', i.gables_unit);
        const gables = i.gables !== undefined ? readRows(i.gables, [gf, gf]).filter(([b, h]) => b > 0 && h > 0) : [];
        const gableArea = gables.reduce((sum, [b, h]) => sum + (b * h) / 2, 0);
        const net = area.net + gableArea;

        if (net <= 0) {
            return { empty: 'Enter at least one wall or gable.' };
        }

        const withWaste = net * extra(i.waste);
        const squares = withWaste / (100 * FT2);
        const rows = { area: `${f(net / FT2)} ft² net (${f(withWaste / FT2)} ft² with waste)`, gables: `${f(gableArea / FT2)} ft² of gables`, cost: i.price > 0 ? money(squares * i.price) : 'Enter a price per square' };

        if (i.exposure > 0 && i.piece > 0) {
            rows.pieces = `${f(Math.ceil(withWaste / (i.exposure * i.piece) - 1e-9))} pieces of ${f(i.piece / FT)} ft at ${f(i.exposure / IN)} in exposure`;
        }

        if (i.box > 0) {
            rows.boxes = `${f(Math.ceil(withWaste / i.box - 1e-9))} boxes`;
        }

        if (i.corners >= 0 && i.corner_height > 0) {
            rows.trim = `${f(area.length / FT)} ft of starter strip, ${f((i.corners * i.corner_height) / FT)} ft of outside corner`;
        }

        return { value: f(squares), unit: 'squares', label: 'Siding', sub: `${f(withWaste / FT2)} ft² (1 square = 100 ft²)`, rows };
    },

    /**
     * Horizontal boards (shiplap, wainscot boards): rows = height ÷ exposure, boards per row = length ÷ board length.
     */
    boards: (i, c, f) => {
        const area = wallArea(i, c);

        if (!area.walls.length || !(i.exposure > 0) || !(i.board_length > 0)) {
            return { empty: 'Enter the walls, the board\'s face width and the board length.' };
        }

        const linear = (area.net / i.exposure) * extra(i.waste);
        const boards = Math.ceil(linear / i.board_length - 1e-9);

        return {
            value: f(boards),
            unit: 'boards',
            label: 'Boards needed',
            sub: `${f(area.net / FT2)} ft² ÷ ${f(i.exposure / IN)} in face = ${f(linear / FT)} linear ft${i.waste > 0 ? ` with ${f(i.waste)}%` : ''}`,
            rows: { linear: `${f(linear / FT)} ft (${f(linear)} m)`, area: `${f(area.net / FT2)} ft² (${f(area.net)} m²)`, cost: i.price > 0 ? money(boards * i.price) : 'Enter a price per board' },
        };
    },

    board_and_batten: (i, c, f) => {
        const area = wallArea(i, c);

        if (!area.walls.length || !(i.board_width > 0) || !(i.batten_width > 0)) {
            return { empty: 'Enter the walls and the board and batten widths.' };
        }

        const gap = i.gap > 0 ? i.gap : 0;
        let boards = 0;
        let battens = 0;
        let boardLength = 0;
        let battenLength = 0;

        area.walls.forEach(([length, height]) => {
            const count = Math.ceil(length / (i.board_width + gap) - 1e-9);
            boards += count;
            battens += Math.max(count - 1, 0);
            boardLength += count * height;
            battenLength += Math.max(count - 1, 0) * height;
        });

        if (gap * 2 > i.batten_width) {
            return { error: 'The gap is wider than the batten can cover.' };
        }

        const waste = extra(i.waste);

        return {
            value: f(Math.ceil(boards * waste - 1e-9)),
            unit: 'boards',
            label: 'Boards',
            sub: `${f(Math.ceil(battens * waste - 1e-9))} battens; each piece full wall height`,
            rows: { battens: `${f(Math.ceil(battens * waste - 1e-9))} battens`, board_ft: `${f((boardLength * waste) / FT)} linear ft of board`, batten_ft: `${f((battenLength * waste) / FT)} linear ft of batten`, area: `${f(area.gross / FT2)} ft² of wall` },
        };
    },

    wainscoting: (i, c, f) => {
        const lf = factor(c, 'walls', i.walls_unit);
        const lengths = readRows(i.walls, [lf]).map(([l]) => l).filter((l) => l > 0);

        if (!lengths.length || !(i.height > 0) || !(i.panel_width > 0) || !(i.panel_height > 0)) {
            return { empty: 'Enter the wall lengths, wainscot height and panel size.' };
        }

        if (i.height > i.panel_height) {
            return { error: 'The wainscot is taller than a panel.' };
        }

        const run = lengths.reduce((sum, l) => sum + l, 0) - (i.doors > 0 ? i.doors * (i.door_width > 0 ? i.door_width : 0) : 0);

        if (run <= 0) {
            return { error: 'The doors are wider than the walls.' };
        }

        const piecesPerPanel = Math.floor(i.panel_height / i.height + 1e-9);
        const strips = Math.ceil(run / i.panel_width - 1e-9);
        const panels = Math.ceil((strips / piecesPerPanel) * extra(i.waste) - 1e-9);

        return {
            value: f(panels),
            unit: 'panels',
            label: 'Panels',
            sub: `${strips} pieces ${f(i.panel_width / FT)} ft wide, ${piecesPerPanel} cut from each panel`,
            rows: { run: `${f(run / FT)} ft of wall`, area: `${f((run * i.height) / FT2)} ft²`, trim: `${f(run / FT)} ft each of chair rail and baseboard`, cost: i.price > 0 ? money(panels * i.price) : 'Enter a price per panel' },
        };
    },

    stucco: (i, c, f) => {
        const area = wallArea(i, c);

        if (!area.walls.length || !(i.thickness > 0)) {
            return { empty: 'Enter the walls and the total stucco thickness.' };
        }

        const volume = area.net * i.thickness * extra(i.waste);
        const bags = i.yield > 0 ? Math.ceil(volume / (i.yield / 1000) - 1e-9) : null;
        // Expanded metal lath sheets are 27 × 96 in (ASTM C847); lap 1 in at sides and ends.
        const lath = Math.ceil(area.net / (26 * IN * 95 * IN) - 1e-9);

        return {
            value: bags === null ? f(volume / FT3) : f(bags),
            unit: bags === null ? 'ft³' : 'bags',
            label: 'Stucco',
            sub: `${f(area.net / FT2)} ft² × ${f(i.thickness / IN)} in = ${f(volume / FT3)} ft³${i.waste > 0 ? ` with ${f(i.waste)}%` : ''}`,
            rows: { volume: `${f(volume / FT3)} ft³ (${f(volume * 1000)} L)`, lath: `${f(lath)} sheets of 27 × 96 in lath`, area: `${f(area.net / FT2)} ft² (${f(area.net)} m²)`, bags: bags === null ? 'Enter the bag yield' : `${f(bags)} bags at ${f(i.yield / FT3 / 1000)} ft³ each` },
        };
    },

    trim: (i, c, f) => {
        const rooms = roomRows(i, c);

        if (!rooms.length || !(i.piece > 0)) {
            return { empty: 'Enter at least one room and the trim piece length.' };
        }

        const perimeter = rooms.reduce((sum, [l, w]) => sum + 2 * (l + w), 0);
        const doors = (i.doors > 0 ? i.doors : 0) * (i.door_width > 0 ? i.door_width : 0);
        const run = perimeter - doors;

        if (run <= 0) {
            return { error: 'The doors are wider than the rooms.' };
        }

        const length = run * extra(i.waste);
        const pieces = Math.ceil(length / i.piece - 1e-9);

        return {
            value: f(pieces),
            unit: 'pieces',
            label: 'Trim pieces',
            sub: `${f(run / FT)} ft of wall${i.waste > 0 ? ` plus ${f(i.waste)}%` : ''} in ${f(i.piece / FT)} ft lengths`,
            rows: { linear: `${f(length / FT)} ft (${f(length)} m)`, perimeter: `${f(perimeter / FT)} ft of room perimeter`, corners: `${rooms.length * 4} inside corners (rectangular rooms)`, cost: i.price > 0 ? money(pieces * i.price) : 'Enter a price per piece' },
        };
    },

    plywood: (i, c, f) => {
        const rooms = roomRows(i, c, 'areas');

        if (!rooms.length) {
            return { empty: 'Enter at least one area.' };
        }

        const [sw, sl] = String(i.sheet).split('x').map((v) => Number(v) * FT);
        const area = rooms.reduce((sum, [l, w]) => sum + l * w, 0);
        const sheets = Math.ceil((area * extra(i.waste)) / (sw * sl) - 1e-9);

        return {
            value: f(sheets),
            unit: 'sheets',
            label: 'Sheets needed',
            sub: `${f(area / FT2)} ft² ÷ ${f((sw * sl) / FT2)} ft² per sheet${i.waste > 0 ? `, plus ${f(i.waste)}%` : ''}`,
            rows: { area: `${f(area / FT2)} ft² (${f(area)} m²)`, sheet: `${f(sw / FT)} × ${f(sl / FT)} ft`, cost: i.price > 0 ? money(sheets * i.price) : 'Enter a price per sheet' },
        };
    },

    sealant: (i, c, f) => {
        if (missing(i, 'width', 'depth', 'length', 'cartridge') || !(i.width > 0) || !(i.depth > 0) || !(i.length > 0) || !(i.cartridge > 0)) {
            return { empty: 'Enter the joint width, depth, length and cartridge size.' };
        }

        const shape = i.profile === 'triangle' ? 0.5 : 1;
        const volume = i.width * i.depth * shape * i.length * extra(i.waste);
        const cartridgeM3 = i.cartridge / 1000;
        const cartridges = Math.ceil(volume / cartridgeM3 - 1e-9);

        return {
            value: f(cartridges),
            unit: 'cartridges',
            label: 'Sealant needed',
            sub: `${f(volume * 1e6)} mL of sealant; one cartridge runs ${f(cartridgeM3 / (i.width * i.depth * shape) / FT)} ft`,
            rows: {
                volume: `${f(volume * 1e6)} mL (${f(volume * 1e6 / 29.5735295625)} fl oz)`,
                per_cartridge: `${f(cartridgeM3 / (i.width * i.depth * shape) / FT)} ft per cartridge`,
                depth: i.profile === 'triangle' ? 'Triangular fillet' : i.depth > i.width ? 'Deeper than wide: use backer rod for about half the width' : 'OK for a butt joint',
            },
        };
    },

    epoxy: (i, c, f) => {
        let volume;

        if (i.mode === 'coat') {
            const plan = shapeArea(i.shape, i);

            if (plan.empty || plan.error) {
                return plan;
            }

            if (!(i.thickness > 0)) {
                return { empty: 'Enter the coat thickness.' };
            }

            volume = plan.area * i.thickness;
        } else {
            if (!(i.mold_length > 0) || !(i.mold_width > 0) || !(i.mold_depth > 0)) {
                return { empty: 'Enter the mold length, width and depth.' };
            }

            volume = i.mold_length * i.mold_width * i.mold_depth;
        }

        const total = volume * extra(i.waste);
        const [a, b] = i.ratio === 'custom' ? [i.part_a, i.part_b] : i.ratio.split(':').map(Number);

        if (!(a > 0) || !(b > 0)) {
            return { empty: 'Enter the mix ratio.' };
        }

        const liters = total * 1000;
        const kg = i.density > 0 ? total * i.density : null;
        const share = (part) => part / (a + b);

        if (i.basis === 'weight' && kg === null) {
            return { empty: 'Enter the mixed density to split the parts by weight.' };
        }

        return {
            value: f(liters / 3.785411784),
            unit: 'gal',
            label: 'Epoxy needed',
            sub: `${f(liters)} L (${f(liters * 33.8140227)} fl oz), mixed ${a} : ${b} by ${i.basis === 'weight' ? 'weight' : 'volume'}`,
            rows: i.basis === 'weight' && kg !== null
                ? { a: `${f(kg * share(a))} kg of part A (${f((kg * share(a)) / 0.45359237)} lb)`, b: `${f(kg * share(b))} kg of part B (${f((kg * share(b)) / 0.45359237)} lb)`, total: `${f(kg)} kg (${f(kg / 0.45359237)} lb)`, liters: `${f(liters)} L` }
                : { a: `${f(liters * share(a))} L of part A (${f(liters * share(a) * 33.8140227)} fl oz)`, b: `${f(liters * share(b))} L of part B (${f(liters * share(b) * 33.8140227)} fl oz)`, total: kg !== null ? `${f(kg)} kg (${f(kg / 0.45359237)} lb)` : 'Enter a density for the weight', liters: `${f(liters)} L` },
        };
    },

    /**
     * Stain for decks and fences: area × coats ÷ label coverage.
     */
    stain: (i, c, f) => {
        let area = 0;
        const parts = [];

        if (i.deck_length > 0 && i.deck_width > 0) {
            area += i.deck_length * i.deck_width;
            parts.push(`deck ${f((i.deck_length * i.deck_width) / FT2)} ft²`);
        }

        if (i.rail_length > 0 && i.rail_height > 0) {
            area += i.rail_length * i.rail_height * 2;
            parts.push(`railings ${f((i.rail_length * i.rail_height * 2) / FT2)} ft² (both sides)`);
        }

        if (i.fence_length > 0 && i.fence_height > 0) {
            const sides = i.sides > 0 ? i.sides : 1;
            area += i.fence_length * i.fence_height * sides;
            parts.push(`fence ${f((i.fence_length * i.fence_height * sides) / FT2)} ft²`);
        }

        if (i.stairs > 0 && i.stair_width > 0) {
            area += i.stairs * i.stair_width * 18 * IN;
            parts.push(`${f(i.stairs)} steps`);
        }

        if (!(area > 0)) {
            return { empty: 'Enter the sizes to stain.' };
        }

        if (!(i.coverage > 0)) {
            return { empty: 'Enter the coverage from the stain label.' };
        }

        const coats = i.coats > 0 ? i.coats : 1;
        const liters = (((area / FT2) * coats) / i.coverage) * GAL * 1000;

        return {
            value: f(liters / (GAL * 1000)),
            unit: 'gal',
            label: 'Stain needed',
            sub: `${f(area / FT2)} ft² × ${f(coats)} coat${coats > 1 ? 's' : ''} at ${f(i.coverage)} ft² per gallon`,
            rows: { ...paintRows(liters, f), area: parts.join(', '), cost: i.price > 0 ? money(Math.ceil(liters / (GAL * 1000) - 1e-9) * i.price) : 'Enter a price per gallon' },
        };
    },

    stair_carpet: (i, c, f) => {
        if (missing(i, 'steps', 'tread', 'riser', 'width') || !(i.steps >= 1) || !(i.tread > 0) || !(i.riser > 0) || !(i.width > 0)) {
            return { empty: 'Enter the steps, tread, riser and width.' };
        }

        const steps = Math.round(i.steps);
        const nosing = i.nosing > 0 ? i.nosing : 0;
        const perStep = i.tread + i.riser + nosing;
        const runner = steps * perStep;
        const landing = i.landing_length > 0 && i.landing_width > 0 ? i.landing_length * i.landing_width : 0;
        const area = runner * i.width + landing;

        return {
            value: f(area / YD2),
            unit: 'yd²',
            label: 'Stair carpet',
            sub: `${steps} steps × ${f(perStep / IN)} in each, ${f(i.width / IN)} in wide${landing ? ', plus the landing' : ''}`,
            rows: { runner: `${f(runner / FT)} ft of runner (${f(runner)} m)`, ft2: `${f(area / FT2)} ft² (${f(area)} m²)`, per_step: `${f(perStep / IN)} in per step`, cost: i.price > 0 ? money((area / YD2) * i.price) : 'Enter a price per yd²' },
        };
    },
};

export default defineTools(handlers);
