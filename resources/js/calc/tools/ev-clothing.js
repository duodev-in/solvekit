import { money } from '../ecology/common.js';
import { defineTools } from '../engines/formula.js';
import { parseRows } from '../rows-editor.js';

/**
 * Clothing and sewing: size conversions and fabric, quilting and sewing layouts.
 * Unit fields arrive in meters (lengths) and grams (weights).
 */
const IN = 0.0254;
const YD = 0.9144;
const inch = (m, f) => `${f(Math.round((m / IN) * 100) / 100)} in`;
const both = (m, f) => `${f(Math.round((m / IN) * 100) / 100)} in (${f(Math.round(m * 1000) / 10)} cm)`;
const yards = (m, f) => `${f(Math.ceil((m / YD) * 8) / 8)} yd (${f(Math.ceil(m * 10) / 10)} m)`;
const half = (x) => Math.round(x * 2) / 2;
const eighths = (x) => {
    const whole = Math.floor(x + 1e-9);
    const n = Math.round((x - whole) * 8);

    if (n === 8) {
        return `${whole + 1}`;
    }

    return n ? `${whole ? `${whole} ` : ''}${['', '⅛', '¼', '⅜', '½', '⅝', '¾', '⅞'][n]}` : `${whole}`;
};

/**
 * US ring size from inside diameter: d (mm) = 11.63 + 0.8128 × size; UK/Australian letters from
 * circumference (BS 6820: A = 37.5 mm, +1.25 mm a letter); ISO 8653 size = circumference in mm; Swiss = ISO − 40.
 */
export function ringSizes(circumference) {
    const diameter = circumference / Math.PI;
    const us = (diameter - 11.63) / 0.8128;
    const ukIndex = (circumference - 37.5) / 1.25;
    const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const whole = Math.floor(Math.round(ukIndex * 2) / 2);
    const uk = whole < 0 ? 'below A' : whole >= 26 ? 'Z+' : `${letters[whole]}${Math.round(ukIndex * 2) % 2 ? '½' : ''}`;

    return { us: Math.round(us * 4) / 4, uk, iso: Math.round(circumference * 2) / 2, swiss: Math.round((circumference - 40) * 2) / 2, diameter };
}

/**
 * Shoe sizes from foot length (Brannock-style conventions): US men 3L − 22, US women 3L − 20.5, UK 3L − 23
 * (L in inches); EU (Paris points) 1.5 × (foot cm + 2); Mondopoint = foot length in mm.
 */
export function shoeSizes(foot) {
    const L = foot / IN;

    return {
        usMen: half(3 * L - 22),
        usWomen: half(3 * L - 20.5),
        uk: half(3 * L - 23),
        eu: half(1.5 * (foot * 100 + 2)),
        mondo: Math.round(foot * 1000 / 5) * 5,
        jp: half(foot * 100),
    };
}

/**
 * Foot length (m) that a size corresponds to in a system: the inverse of shoeSizes.
 */
export function footFromSize(size, system) {
    switch (system) {
        case 'us_men': return ((size + 22) / 3) * IN;
        case 'us_women': return ((size + 20.5) / 3) * IN;
        case 'uk': return ((size + 23) / 3) * IN;
        case 'eu': return (size / 1.5 - 2) / 100;
        case 'mondo': return size / 1000;
        default: return NaN;
    }
}

const US_CUPS = ['AA', 'A', 'B', 'C', 'D', 'DD', 'DDD/F', 'G', 'H', 'I', 'J', 'K'];
const UK_CUPS = ['AA', 'A', 'B', 'C', 'D', 'DD', 'E', 'F', 'FF', 'G', 'GG', 'H'];
const EU_CUPS = ['AA', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];

/**
 * Bra size: band = underbust rounded to the nearest even inch; cup = bust − band in whole inches (A = 1).
 * EU (EN 13402): band = underbust rounded to 5 cm; cup from bust − underbust in 2 cm steps from 12–14 cm = A.
 */
export function braSize(underbust, bust) {
    const under = underbust / IN;
    const over = bust / IN;
    const band = 2 * Math.round(under / 2);
    const cupIndex = Math.round(over - band);
    const euBand = 5 * Math.round((underbust * 100) / 5);
    const euIndex = Math.floor((bust * 100 - underbust * 100 - 10) / 2);

    return { band, cupIndex, euBand, euIndex };
}

/**
 * Packs rectangular pieces onto fabric of a width in rows (first-fit decreasing); returns the length used.
 */
export function packPieces(pieces, width, { rotate = true } = {}) {
    const items = [];
    pieces.forEach(({ name, length, w, count }) => {
        for (let k = 0; k < count; k += 1) {
            let [l, ww] = [length, w];

            if (rotate && ww > width && l <= width) {
                [l, ww] = [ww, l];
            }

            // Lay the long side along the fabric when it saves width.
            if (rotate && l < ww && l <= width) {
                [l, ww] = [ww, l];
            }

            items.push({ name, l, w: ww });
        }
    });

    if (items.some((item) => item.w > width + 1e-9)) {
        return null;
    }

    items.sort((a, b) => b.l - a.l);
    const rows = [];

    items.forEach((item) => {
        const row = rows.find((r) => r.used + item.w <= width + 1e-9 && item.l <= r.length + 1e-9);

        if (row) {
            row.used += item.w;
            row.items.push(item);
        } else {
            rows.push({ length: item.l, used: item.w, items: [item] });
        }
    });

    return { length: rows.reduce((sum, r) => sum + r.length, 0), rows };
}

export const handlers = {
    bag: (i, c, f) => {
        if (!(i.width > 0) || !(i.height > 0) || !(i.fabric > 0)) {
            return { empty: 'Enter the bag size and fabric width.' };
        }

        const s = i.seam >= 0 ? i.seam : 0.5 * IN;
        const depth = i.depth > 0 ? i.depth : 0;
        const hem = i.hem >= 0 ? i.hem : 1.5 * IN;
        const panelW = i.width + depth + 2 * s;
        const panelH = i.height + depth / 2 + s + hem;
        const handles = i.handle_length > 0 && i.handle_width > 0 ? { name: 'Handle', length: i.handle_length + 2 * s, w: 4 * i.handle_width, count: 2 } : null;
        const pieces = [{ name: 'Front and back', length: panelH, w: panelW, count: i.lining ? 4 : 2 }, ...(handles ? [handles] : [])];
        const layout = packPieces(pieces, i.fabric);

        if (!layout) {
            return { error: 'A piece is wider than the fabric.' };
        }

        return {
            value: yards(layout.length, f),
            label: 'Fabric needed',
            sub: `${i.lining ? 'Outer and lining' : 'Outer only'}, on ${inch(i.fabric, f)} wide fabric`,
            rows: {
                panel: `${i.lining ? 4 : 2} panels of ${both(panelW, f)} × ${both(panelH, f)} (includes ${inch(depth / 2, f)} for the boxed corners)`,
                handles: handles ? `2 strips of ${both(handles.length, f)} × ${both(handles.w, f)}, folded in four` : 'No handles',
                corners: depth > 0 ? `Cut ${inch(depth / 2, f)} squares from the bottom corners for a ${inch(depth, f)} deep base` : 'Flat bag',
            },
        };
    },

    belt: (i, c, f) => {
        if (!(i.waist > 0)) {
            return { empty: 'Enter your waist or pant size.' };
        }

        const size = i.basis === 'belt_worn' ? i.waist : i.waist + 2 * IN;
        // Belts are sold in even sizes.
        const even = 2 * Math.round(size / IN / 2);

        return {
            value: f(even),
            unit: 'belt size',
            label: 'Belt size',
            sub: i.basis === 'belt_worn' ? 'Your current belt, buckle fold to the hole you use' : `Pant waist ${inch(i.waist, f)} + 2 in`,
            rows: { cm: `${f(Math.round(even * 2.54))} cm (${f(Math.round((size / IN) * 10) / 10)} in exactly)`, letter: even <= 32 ? 'S (about 30–32)' : even <= 36 ? 'M (about 34–36)' : even <= 40 ? 'L (about 38–40)' : even <= 44 ? 'XL (about 42–44)' : 'XXL', note: 'Belt sizes are measured from the buckle fold to the middle hole' },
        };
    },

    bra: (i, c, f) => {
        if (!(i.underbust > 0) || !(i.bust > i.underbust)) {
            return { empty: 'Enter your underbust and a larger bust measurement.' };
        }

        const bust = i.leaning > i.bust ? (i.bust + i.leaning) / 2 : i.bust;
        const s = braSize(i.underbust, bust);
        // Traditional method: add 4 in to an even underbust (5 to an odd one); system conversion charts use these bands.
        const under = Math.round(i.underbust / IN);
        const oldBand = under + (under % 2 ? 5 : 4);
        const oldCup = Math.round(bust / IN - oldBand);

        if (s.cupIndex < 0 || s.cupIndex >= US_CUPS.length) {
            return { error: 'The difference is outside the usual cup range: check the measurements or get a fitting.' };
        }

        const euCup = EU_CUPS[Math.max(0, Math.min(EU_CUPS.length - 1, s.euIndex))];
        const cup = (list, index) => (index < 0 ? 'AA or smaller' : list[index] ?? 'beyond K');

        return {
            value: `${s.band}${US_CUPS[s.cupIndex]}`,
            label: 'US size (modern measuring)',
            sub: `Band ${s.band} = underbust ${f(Math.round((i.underbust / IN) * 10) / 10)} in to the nearest even inch; cup ${US_CUPS[s.cupIndex]} = ${s.cupIndex} in more at the bust`,
            rows: {
                uk: `${s.band}${UK_CUPS[s.cupIndex]} (UK, modern)`,
                old: `${oldBand}${cup(US_CUPS, oldCup)} (US/UK traditional +4 method, still used by many brand charts)`,
                eu: `${s.euBand}${euCup} (EN 13402: band = underbust in cm, cup from the difference)`,
                fr: `${s.euBand + 15}${euCup} (France and Belgium)`,
                au: `${oldBand - 22}${cup(UK_CUPS, oldCup)} (Australia, from the traditional band)`,
                sister: s.cupIndex > 0 ? `${s.band - 2}${US_CUPS[s.cupIndex + 1] ?? ''} and ${s.band + 2}${US_CUPS[s.cupIndex - 1]}` : `${s.band - 2}${US_CUPS[s.cupIndex + 1]}`,
            },
        };
    },

    circle_skirt: (i, c, f) => {
        const fraction = Number(i.fraction);

        if (!(i.waist > 0) || !(i.length > 0) || !(fraction > 0)) {
            return { empty: 'Enter the waist and skirt length.' };
        }

        const radius = i.waist / (2 * Math.PI * fraction);
        const R = radius + i.length + (i.hem > 0 ? i.hem : 0) + (i.seam > 0 ? i.seam : 0);
        const wedges = fraction * 4;
        const perRow = i.fabric > 0 ? Math.floor(i.fabric / R + 1e-9) : 0;

        if (i.fabric > 0 && perRow < 1) {
            return { error: 'Each quarter of the skirt is wider than the fabric: choose a shorter skirt or wider fabric.' };
        }

        const rows = perRow ? Math.ceil(wedges / perRow) : null;

        return {
            value: both(radius - (i.seam > 0 ? i.seam : 0), f),
            label: 'Waist radius to cut',
            sub: `Waist ${inch(i.waist, f)} ÷ (2π × ${fraction === 1 ? 'full' : fraction === 0.5 ? '½' : '¼'} circle)`,
            rows: {
                outer: `${both(R, f)} from the center to the hem cut line`,
                fabric: rows ? `${yards(rows * R, f)}: ${wedges} quarter-circle sections of ${inch(R, f)} square, ${perRow} across the fabric` : 'Enter the fabric width',
                hem: `${both(2 * Math.PI * fraction * (radius + i.length), f)} around the hem`,
            },
        };
    },

    cross_stitch: (i, c, f) => {
        const count = Number(i.count) / (i.over_two ? 2 : 1);

        if (!(i.stitches_w > 0) || !(i.stitches_h > 0) || !(count > 0)) {
            return { empty: 'Enter the design size in stitches and the fabric count.' };
        }

        const w = (i.stitches_w / count) * IN;
        const h = (i.stitches_h / count) * IN;
        const margin = i.margin >= 0 ? i.margin : 3 * IN;

        return {
            value: `${f(Math.round((w / IN) * 100) / 100)} × ${f(Math.round((h / IN) * 100) / 100)} in`,
            label: 'Finished design size',
            sub: `${f(i.stitches_w)} × ${f(i.stitches_h)} stitches on ${f(Number(i.count))}-count${i.over_two ? ' over two' : ''} (${f(count)} stitches per inch)`,
            rows: { cm: `${f(Math.round(w * 1000) / 10)} × ${f(Math.round(h * 1000) / 10)} cm`, cut: `Cut fabric ${both(w + 2 * margin, f)} × ${both(h + 2 * margin, f)} with ${inch(margin, f)} margins`, stitches: `${f(i.stitches_w * i.stitches_h)} stitches if fully filled` },
        };
    },

    curtain_panels: (i, c, f) => {
        if (!(i.width > 0) || !(i.panel > 0) || !(i.fullness > 0)) {
            return { empty: 'Enter the rod width, fullness and panel width.' };
        }

        const total = i.width * i.fullness;
        const panels = Math.ceil(total / i.panel - 1e-9);
        const cut = i.length > 0 ? i.length + (i.hems > 0 ? i.hems : 0) : null;

        return {
            value: f(panels),
            unit: panels === 1 ? 'panel' : 'panels',
            label: 'Panels needed',
            sub: `${both(i.width, f)} × ${f(i.fullness)} fullness = ${both(total, f)} of fabric width`,
            rows: { pairs: `${f(Math.ceil(panels / 2))} pairs (split evenly between the two sides)`, fabric: cut ? `${yards(cut * panels, f)} of fabric at one width per panel (cut length ${both(cut, f)})` : 'Enter the finished length for yardage', fullness: 'Fullness: 1.5× for flat panels, 2× standard, 2.5–3× for sheers' },
        };
    },

    curtain_size: (i, c, f) => {
        if (!(i.width > 0) || !(i.height > 0)) {
            return { empty: 'Enter the window width and height.' };
        }

        const rodWidth = i.width + 2 * (i.extension >= 0 ? i.extension : 6 * IN);
        const rodHeight = i.above >= 0 ? i.above : 4 * IN;
        const sill = i.sill_to_floor > 0 ? i.sill_to_floor : null;
        let length;

        switch (i.style) {
            case 'sill': length = rodHeight + i.height - 0.5 * IN; break;
            case 'apron': length = rodHeight + i.height + 4 * IN; break;
            case 'puddle': length = sill ? rodHeight + i.height + sill + 6 * IN : NaN; break;
            default: length = sill ? rodHeight + i.height + sill - 0.5 * IN : NaN;
        }

        if (!(length > 0)) {
            return { empty: 'Enter the sill-to-floor height for floor-length curtains.' };
        }

        return {
            value: both(length, f),
            label: 'Curtain length',
            sub: `From a rod ${inch(rodHeight, f)} above the window, ${{ sill: 'ending ½ in above the sill', apron: 'ending 4 in below the sill', puddle: 'with 6 in pooling on the floor', floor: 'ending ½ in above the floor' }[i.style]}`,
            rows: { rod: `Rod ${both(rodWidth, f)} wide`, width: `${both(rodWidth * (i.fullness > 0 ? i.fullness : 2), f)} total curtain width at ${f(i.fullness > 0 ? i.fullness : 2)}× fullness (${both((rodWidth * (i.fullness > 0 ? i.fullness : 2)) / 2, f)} per panel in a pair)`, note: 'Standard ready-made lengths: 63, 84, 95, 108 in' },
        };
    },

    fabric: (i, c, f) => {
        const rows = parseRows(i.pieces).map((cells, k) => ({ name: cells[0] || `Piece ${k + 1}`, length: Number(cells[1]), w: Number(cells[2]), count: Math.max(1, Math.round(Number(cells[3]) || 1)) })).filter((p) => p.length > 0 && p.w > 0);
        const scale = { in: IN, cm: 0.01 }[i.piece_unit] ?? IN;

        if (!rows.length || !(i.fabric > 0)) {
            return { empty: 'Add pieces with their length and width, and the fabric width.' };
        }

        const seam = i.add_seam > 0 ? 2 * i.add_seam : 0;
        const pieces = rows.map((p) => ({ ...p, length: p.length * scale + seam, w: p.w * scale + seam }));
        const layout = packPieces(pieces, i.fabric, { rotate: !i.nap });

        if (!layout) {
            return { error: 'A piece is wider than the fabric, even turned: use wider fabric or split the piece.' };
        }

        const shrink = 1 + (i.shrink > 0 ? i.shrink : 0) / 100;
        const length = layout.length * shrink;

        return {
            value: yards(length, f),
            label: 'Fabric needed',
            sub: `${pieces.reduce((s, p) => s + p.count, 0)} pieces on ${inch(i.fabric, f)} wide fabric${i.nap ? ', one direction (nap)' : ''}`,
            rows: { exact: `${both(length, f)} of fabric${shrink > 1 ? ` with ${f((shrink - 1) * 100)}% for shrinkage` : ''}`, rows: `${layout.rows.length} rows across the width`, note: 'A simple layout estimate: patterns with curves may nest tighter; buy a little extra' },
            lists: { layout: layout.rows.map((row, k) => ({ label: `Row ${k + 1}: ${inch(row.length, f)} long`, value: row.items.map((item) => item.name).join(', ') })) },
        };
    },

    glove: (i, c, f) => {
        if (!(i.hand > 0)) {
            return { empty: 'Enter your hand circumference.' };
        }

        const size = i.hand / IN;
        const en = Math.min(11, Math.max(6, Math.round(size)));
        const lengthForSize = { 6: 160, 7: 171, 8: 182, 9: 192, 10: 204, 11: 215 }[en];

        return {
            value: f(half(size)),
            unit: 'glove size',
            label: 'Glove size',
            sub: `Hand circumference ${both(i.hand, f)} around the knuckles`,
            rows: {
                en: `EN 420 size ${en} (about ${en} in, ${Math.round(en * 25.4)} mm around; hand length ${lengthForSize} mm)`,
                letter: size < 7 ? 'XS–S' : size < 8 ? 'S–M' : size < 9 ? 'M–L' : size < 10 ? 'L' : size < 11 ? 'XL' : 'XXL',
                length: i.length > 0 ? `Hand length ${both(i.length, f)}: if it is longer than the size\'s ${lengthForSize} mm, go up a size` : 'Measure from wrist crease to middle fingertip to check length',
            },
        };
    },

    hst: (i, c, f) => {
        if (!(i.finished > 0) || !(i.count > 0)) {
            return { empty: 'Enter the finished size and the number of HSTs.' };
        }

        const fin = i.finished / IN;
        const trim = i.trim ? 1 / 8 : 0;
        const method = i.method;
        const square = method === 'eight' ? 2 * (fin + 7 / 8) + 2 * trim : fin + 7 / 8 + trim;
        const perPair = method === 'eight' ? 8 : 2;
        const pairs = Math.ceil(i.count / perPair);
        const wof = (i.wof > 0 ? i.wof : 42 * IN) / IN;
        const perStrip = Math.floor(wof / square);

        return {
            value: `${eighths(square)} in`,
            label: 'Cut squares',
            sub: `${method === 'eight' ? '8-at-a-time: 2 × (finished + ⅞ in)' : '2-at-a-time: finished + ⅞ in'}${trim ? ', +⅛ in to trim' : ''}`,
            rows: {
                squares: `${pairs} squares of each fabric (${pairs * perPair} HSTs)`,
                strips: perStrip > 0 ? `${Math.ceil(pairs / perStrip)} strips ${eighths(square)} in wide of each fabric (${perStrip} squares per strip)` : 'Squares are wider than the fabric',
                unfinished: `Unfinished HST: ${eighths(fin + 0.5)} in`,
                metric: `${f(Math.round(square * 25.4 * 10) / 10)} mm squares`,
            },
        };
    },

    hat: (i, c, f) => {
        if (!(i.head > 0)) {
            return { empty: 'Enter your head circumference.' };
        }

        const inches = i.head / IN;
        const us = Math.round((inches / Math.PI) * 8) / 8;
        const cm = Math.round(i.head * 100);
        const letter = cm < 54 ? 'XS' : cm < 56 ? 'S' : cm < 58 ? 'M' : cm < 60 ? 'L' : cm < 62 ? 'XL' : 'XXL';

        return {
            value: eighths(us),
            unit: 'US hat size',
            label: 'Hat size',
            sub: `${both(i.head, f)} ÷ π, to the nearest ⅛`,
            rows: { uk: eighths(us - 1 / 8), eu: `${cm} (centimeters)`, letter: `${letter} (letter sizes vary by maker)` },
        };
    },

    hexagons: (i, c, f) => {
        if (!(i.width > 0) || !(i.height > 0) || !(i.side > 0)) {
            return { empty: 'Enter the quilt size and the hexagon side length.' };
        }

        const s = i.side;
        const columns = Math.ceil(i.width / (1.5 * s)) + 1;
        const rows = Math.ceil(i.height / (Math.sqrt(3) * s)) + 1;
        const total = columns * rows;
        const allowance = i.allowance >= 0 ? i.allowance : 0.375 * IN;
        const cutSquare = 2 * s + 2 * allowance;

        return {
            value: f(total),
            unit: 'hexagons',
            label: 'Hexagons to cover the quilt',
            sub: `${columns} columns × ${rows} rows, trimmed at the edges`,
            rows: { size: `Each hexagon: ${both(2 * s, f)} point to point, ${both(Math.sqrt(3) * s, f)} flat to flat`, fabric: `Cut each from a ${both(cutSquare, f)} square (with ${inch(allowance, f)} allowance): about ${yards((total * cutSquare * cutSquare) / (40 * IN), f)} of 40 in usable fabric`, area: `${f(Math.round(((3 * Math.sqrt(3)) / 2) * (s / IN) ** 2 * 100) / 100)} in² each` },
        };
    },

    jacket: (i, c, f) => {
        if (!(i.chest > 0)) {
            return { empty: 'Enter your chest measurement.' };
        }

        const chest = Math.round(i.chest / IN);
        const evenChest = 2 * Math.round(chest / 2);
        const height = i.height > 0 ? i.height / IN : null;
        const fit = height === null ? 'Enter your height' : height < 67 ? 'S (short), under 5′7″' : height <= 71 ? 'R (regular), 5′8″–5′11″' : height <= 75 ? 'L (long), 6′0″–6′3″' : 'XL (extra long), over 6′3″';

        return {
            value: `${evenChest}${height === null ? '' : height < 67 ? 'S' : height <= 71 ? 'R' : height <= 75 ? 'L' : 'XL'}`,
            label: 'Suit jacket size (US/UK)',
            sub: `Chest ${both(i.chest, f)}: suit size is the chest in inches, usually in even numbers`,
            rows: { eu: `${evenChest + 10} (EU, about half the chest in cm)`, length: fit, sleeve: i.sleeve > 0 ? `Sleeve ${both(i.sleeve, f)}: show about ¼–½ in of shirt cuff` : 'Measure the sleeve from shoulder seam to wrist' },
        };
    },

    jeans: (i, c, f) => {
        if (!(i.waist > 0) || !(i.inseam > 0)) {
            return { empty: 'Enter your waist and inseam.' };
        }

        const w = Math.round(i.waist / IN);
        const l = 2 * Math.round(i.inseam / IN / 2);

        return {
            value: `W${w} L${l}`,
            label: 'Jeans size',
            sub: `Waist ${both(i.waist, f)}, inseam ${both(i.inseam, f)}`,
            rows: { cm: `${Math.round(i.waist * 100)} / ${Math.round(i.inseam * 100)} cm`, note: 'Measure where you wear your jeans; many brands cut waists 1–2 in larger than labeled, so try on', inseam: 'Inseams are usually sold in even inches (30, 32, 34)' },
        };
    },

    lost_socks: (i, c, f) => {
        if (!(i.pairs > 0) || !(i.washes > 0) || !(i.chance >= 0)) {
            return { empty: 'Enter pairs washed, washes a week and the chance of losing a sock.' };
        }

        const socksYear = i.pairs * 2 * i.washes * 52.18;
        const lost = socksYear * (i.chance / 100);

        return {
            value: f(Math.round(lost * 10) / 10),
            unit: 'socks a year',
            label: 'Socks lost',
            sub: `${f(Math.round(socksYear))} sock washes a year × ${f(i.chance)}% chance each`,
            rows: { orphans: `About ${f(Math.round(lost * 10) / 10)} odd socks (each lost sock leaves one without a partner)`, cost: i.price > 0 ? `About ${money(lost * i.price)} a year at ${money(i.price)} a sock` : 'Enter a price per sock', months: lost > 0 ? `One sock about every ${f(Math.round((365.25 / lost) * 10) / 10)} days` : 'None' },
        };
    },

    pleated_skirt: (i, c, f) => {
        if (!(i.waist > 0) || !(i.pleat > 0) || !(i.depth > 0)) {
            return { empty: 'Enter the waist, pleat width and pleat depth.' };
        }

        const count = Math.round(i.waist / i.pleat);
        const per = i.type === 'box' ? i.pleat + 4 * i.depth : i.pleat + 2 * i.depth;
        const width = count * per + 2 * (i.seam > 0 ? i.seam : 0);

        return {
            value: both(width, f),
            label: 'Fabric width around the skirt',
            sub: `${count} ${i.type === 'box' ? 'box' : 'knife'} pleats × ${both(per, f)}`,
            rows: { ratio: `${f(Math.round((width / i.waist) * 100) / 100)}× the waist`, panels: i.fabric > 0 ? `${Math.ceil(width / (i.fabric - 2 * (i.seam > 0 ? i.seam : 0)))} fabric widths sewn together` : 'Enter the fabric width', note: i.type === 'box' ? 'Box pleat: visible width + 4 × depth' : 'Knife pleat: visible width + 2 × depth' },
        };
    },

    quilt: (i, c, f) => {
        const block = i.block + (i.sashing > 0 ? i.sashing : 0);

        if (!(i.width > 0) || !(i.length > 0) || !(i.block > 0)) {
            return { empty: 'Enter the quilt size and the block size.' };
        }

        const border = i.border > 0 ? i.border : 0;
        const across = Math.max(1, Math.round((i.width - 2 * border) / block));
        const down = Math.max(1, Math.round((i.length - 2 * border) / block));
        const sash = i.sashing > 0 ? i.sashing : 0;
        const actualW = across * i.block + (across + 1) * sash + 2 * border;
        const actualL = down * i.block + (down + 1) * sash + 2 * border;
        const backW = actualW + 8 * IN;
        const backL = actualL + 8 * IN;
        const usable = (i.fabric > 0 ? i.fabric : 42 * IN);
        const widths = Math.ceil(backW / usable);
        const widthsOther = Math.ceil(backL / usable);
        const backing = Math.min(widths * backL, widthsOther * backW);

        return {
            value: `${across} × ${down}`,
            unit: 'blocks',
            label: `${across * down} blocks`,
            sub: `Finished quilt ${inch(actualW, f)} × ${inch(actualL, f)}`,
            rows: { backing: `${yards(backing, f)} of backing (${Math.min(widths, widthsOther)} fabric ${Math.min(widths, widthsOther) === 1 ? 'width' : 'widths'}, 4 in extra all round)`, batting: `Batting ${inch(backW, f)} × ${inch(backL, f)}`, metric: `${f(Math.round(actualW * 100))} × ${f(Math.round(actualL * 100))} cm finished` },
        };
    },

    binding: (i, c, f) => {
        if (!(i.width > 0) || !(i.length > 0) || !(i.strip > 0)) {
            return { empty: 'Enter the quilt size and strip width.' };
        }

        const needed = 2 * (i.width + i.length) + 10 * IN;
        const usable = (i.fabric > 0 ? i.fabric : 42 * IN) - i.strip;
        const strips = Math.ceil(needed / usable);

        return {
            value: f(strips),
            unit: strips === 1 ? 'strip' : 'strips',
            label: `Strips of ${eighths(i.strip / IN)} in`,
            sub: `${both(needed, f)} of binding (perimeter + 10 in)`,
            rows: { fabric: `${yards(strips * i.strip, f)} of fabric`, joins: `${strips - 1} diagonal joins (each uses about one strip width)`, note: '2½ in strips make a ⅜ in double-fold binding' },
        };
    },

    ring: (i, c, f) => {
        let circumference;

        if (i.from === 'circumference') {
            circumference = i.value_mm;
        } else if (i.from === 'diameter') {
            circumference = i.value_mm * Math.PI;
        } else if (i.from === 'us') {
            circumference = (11.63 + 0.8128 * i.size) * Math.PI;
        } else if (i.from === 'iso') {
            circumference = i.size;
        } else if (i.from === 'uk') {
            const letter = String(i.letter ?? '').toUpperCase().trim();
            const match = /^([A-Z])(½|\.5|1\/2)?$/.exec(letter);
            circumference = match ? 37.5 + 1.25 * (letter.charCodeAt(0) - 65 + (match[2] ? 0.5 : 0)) : NaN;
        }

        if (!(circumference > 30) || circumference > 90) {
            return { empty: 'Enter a ring size or measurement.' };
        }

        const s = ringSizes(circumference);

        return {
            value: f(s.us),
            unit: 'US / Canada',
            label: 'Ring size',
            sub: `Inside circumference ${f(Math.round(circumference * 10) / 10)} mm, diameter ${f(Math.round(s.diameter * 100) / 100)} mm`,
            rows: { uk: `${s.uk} (UK, Ireland, Australia)`, iso: `${f(s.iso)} (ISO 8653: Europe, France, Germany)`, swiss: `${f(s.swiss)} (Switzerland, Italy, Spain)`, tip: 'Measure at the end of the day, when fingers are largest; wide bands need half a size up' },
        };
    },

    shoelace: (i, c, f) => {
        if (!(i.pairs >= 2) || !(i.width > 0) || !(i.spacing > 0)) {
            return { empty: 'Enter the eyelet pairs, the gap across and the spacing between rows.' };
        }

        const n = Math.round(i.pairs);
        const diagonal = Math.sqrt(i.width ** 2 + i.spacing ** 2);
        const ends = i.ends > 0 ? i.ends : 0.25;
        // Criss-cross lacing: one bar across the bottom, then two diagonals for each row above it.
        const laced = 2 * (n - 1) * diagonal + i.width;
        const total = laced + 2 * ends;
        const standard = [27, 36, 40, 45, 54, 63, 72].map((x) => x * IN);
        const pick = standard.find((s) => s >= total - 2 * IN);

        return {
            value: both(total, f),
            label: 'Lace length',
            sub: `Criss-cross lacing through ${n} pairs, plus ${inch(ends, f)} per end for the bow`,
            rows: { buy: pick ? `${f(Math.round(pick / IN))} in (${f(Math.round(pick * 100))} cm) standard lace` : 'Longer than standard laces', laced: `${both(laced, f)} through the eyelets`, note: 'Based on Ian Fieggen\'s shoelace geometry; measure across the eyelet columns with the shoe laced' },
        };
    },

    shoe: (i, c, f) => {
        const foot = i.from === 'length' ? i.foot : footFromSize(i.size, i.from);

        if (!(foot > 0.1) || foot > 0.4) {
            return { empty: 'Enter your foot length or a shoe size.' };
        }

        const s = shoeSizes(foot);

        return {
            value: f(s.usMen),
            unit: 'US men',
            label: 'Shoe size',
            sub: `Foot length ${both(foot, f)} (Mondopoint ${s.mondo} mm)`,
            rows: { women: `${f(s.usWomen)} (US women)`, uk: `${f(s.uk)} (UK adult)`, eu: `${f(s.eu)} (EU, Paris points)`, jp: `${f(s.jp)} (Japan, foot length in cm)`, note: 'Size systems are conventions; brands and lasts vary by about half a size, so try shoes on' },
        };
    },

    socks: (i, c, f) => {
        const foot = i.from === 'length' ? i.foot : footFromSize(i.size, i.from);

        if (!(foot > 0.08)) {
            return { empty: 'Enter your foot length or shoe size.' };
        }

        const sock = half(foot / IN);
        const shoe = shoeSizes(foot);

        return {
            value: f(sock),
            unit: 'sock size',
            label: 'Sock size',
            sub: `Foot length ${both(foot, f)}: sock size is the foot length in inches`,
            rows: { shoe: `US men ${f(shoe.usMen)}, US women ${f(shoe.usWomen)}, EU ${f(shoe.eu)}`, range: `Sold as ${f(sock - 0.5)}–${f(sock + 1.5)} on many packs`, note: 'Brand letter sizes (S, M, L) vary; check the pack\'s shoe-size range' },
        };
    },

    sunglasses: (i, c, f) => {
        const lens = i.lens > 0 ? i.lens : null;
        const bridge = i.bridge > 0 ? i.bridge : null;
        const frame = lens && bridge ? 2 * lens + bridge + (i.endpieces > 0 ? i.endpieces : 8) : null;

        if (!(i.face > 0) && !frame) {
            return { empty: 'Enter your face width or the numbers on a frame you own.' };
        }

        const faceMm = i.face > 0 ? i.face * 1000 : null;
        const size = (mm) => (mm < 130 ? 'Small (under 130 mm)' : mm <= 140 ? 'Medium (130–140 mm)' : 'Large (over 140 mm)');

        return {
            value: faceMm ? `${f(Math.round(faceMm - 5))}–${f(Math.round(faceMm + 5))} mm` : `${f(frame)} mm`,
            label: faceMm ? 'Frame width to look for' : 'Your frame\'s total width',
            sub: faceMm ? `Within about 5 mm of your ${f(Math.round(faceMm))} mm face width` : `2 × ${lens} mm lens + ${bridge} mm bridge + about ${f(i.endpieces > 0 ? i.endpieces : 8)} mm of end pieces`,
            rows: { size: size(faceMm ?? frame), frame: frame ? `${lens}-${bridge}-${i.temple > 0 ? i.temple : '…'} is about ${f(frame)} mm across${faceMm ? `: ${Math.abs(frame - faceMm) <= 5 ? 'a good fit' : frame > faceMm ? 'wider than your face' : 'narrower than your face'}` : ''}` : 'Enter a frame code (lens-bridge-temple) to compare', temple: 'Temple arms are usually 135–150 mm' },
        };
    },

    tablecloth: (i, c, f) => {
        const drop = i.drop >= 0 ? i.drop : 8 * IN;

        if (!(i.length > 0) || (i.shape !== 'round' && !(i.width > 0))) {
            return { empty: 'Enter the table size and drop.' };
        }

        const L = i.length + 2 * drop;
        const W = i.shape === 'round' ? L : i.width + 2 * drop;
        const standard = i.shape === 'round' ? [60, 70, 90, 108, 120, 132].map((d) => [d, d]) : [[52, 70], [60, 84], [60, 102], [60, 120], [70, 90], [70, 120], [90, 132], [90, 156]];
        const best = standard.map(([w, l]) => [w * IN, l * IN]).find(([w, l]) => l >= L - IN && w >= W - IN);

        return {
            value: i.shape === 'round' ? `${f(Math.round(L / IN))} in round` : `${f(Math.round(W / IN))} × ${f(Math.round(L / IN))} in`,
            label: 'Tablecloth size',
            sub: `Table + 2 × ${inch(drop, f)} drop`,
            rows: { metric: i.shape === 'round' ? `${f(Math.round(L * 100))} cm round` : `${f(Math.round(W * 100))} × ${f(Math.round(L * 100))} cm`, standard: best ? `Nearest standard size: ${i.shape === 'round' ? `${f(Math.round(best[1] / IN))} in round` : `${f(Math.round(best[0] / IN))} × ${f(Math.round(best[1] / IN))} in`}` : 'Larger than standard sizes', drops: 'Drops: 6–8 in casual, 10–15 in formal, about 29–30 in to the floor' },
        };
    },

    tie: (i, c, f) => {
        if (!(i.height > 0)) {
            return { empty: 'Enter your height.' };
        }

        const h = i.height / IN;
        const neck = i.neck > 0 ? i.neck / IN : 16;
        const knotExtra = { four: 0, half: 1, full: 2 }[i.knot] ?? 0;
        let length = h < 68 ? 57 : h < 74 ? 58 : h < 77 ? 61 : 63;
        length += neck >= 18 ? 2 : 0;
        length += knotExtra >= 2 && h >= 72 ? 1 : 0;

        return {
            value: `${f(length)} in`,
            label: 'Tie length',
            sub: `${f(Math.round(length * 2.54))} cm: the tip should just reach the belt buckle`,
            rows: { type: length <= 58 ? 'Regular length (57–58 in)' : length <= 61 ? 'Long (61 in)' : 'Extra long (63 in or more)', knot: { four: 'Four-in-hand uses the least length', half: 'Half Windsor uses about 1 in more', full: 'Full Windsor uses about 2 in more' }[i.knot] ?? '', note: 'A guide: tie lengths and knots vary' },
        };
    },

    weighted_blanket: (i, c, f) => {
        if (!(i.weight > 0)) {
            return { empty: 'Enter the body weight of the person using it.' };
        }

        const target = i.weight * ((i.percent > 0 ? i.percent : 10) / 100);
        const lb = target / 453.59237;
        const pockets = i.columns > 0 && i.rows > 0 ? i.columns * i.rows : null;

        return {
            value: f(Math.round(lb)),
            unit: 'lb blanket',
            label: 'Blanket weight',
            sub: `${f(i.percent > 0 ? i.percent : 10)}% of ${f(Math.round(i.weight / 453.59237))} lb body weight (${f(Math.round(target / 100) / 10)} kg)`,
            rows: { pocket: pockets ? `${f(Math.round(target / pockets))} g (${f(Math.round((target / pockets / 28.3495) * 10) / 10)} oz) of filler in each of ${pockets} pockets` : 'Enter the pocket grid', standard: `Nearest common weights: ${[5, 7, 10, 12, 15, 20, 25].filter((x) => Math.abs(x - lb) <= 3).join(', ') || 'custom'} lb`, note: 'A common guideline, not medical advice; not for infants or toddlers' },
        };
    },
};

export default defineTools(handlers);
