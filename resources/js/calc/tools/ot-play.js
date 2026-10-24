import { defineTools } from '../engines/formula.js';
import { handlersFor } from '../physics/core.js';
import { N, SEL, TXT, LINE, num, pct, seeded } from '../statistics/common.js';
import { parseNumbers, sum } from '../statistics/data.js';

/**
 * Games and hobbies: video-game helpers (drops, K/D, Minecraft geometry, Pokémon GO candy, Rust decay), D&D 5e
 * rules (SRD and DMG tables in config/other_data.php), poker equity and EV, optimal stopping, and the vampire and
 * zombie population models.
 */

const RANKS = '23456789TJQKA';
const SUITS = 'cdhs';

/** Parses "As Kd", "10h 9h", "AhKh" into card numbers 0–51 (rank × 4 + suit). */
export function parseCards(text) {
    const s = String(text ?? '').replace(/10/g, 'T').replace(/[♠]/g, 's').replace(/[♥]/g, 'h').replace(/[♦]/g, 'd').replace(/[♣]/g, 'c').replace(/[\s,]+/g, '');

    if (s.length % 2) {
        return null;
    }

    const cards = [];

    for (let i = 0; i < s.length; i += 2) {
        const r = RANKS.indexOf(s[i].toUpperCase());
        const su = SUITS.indexOf(s[i + 1].toLowerCase());

        if (r < 0 || su < 0) {
            return null;
        }

        cards.push(r * 4 + su);
    }

    return cards;
}

const cardText = (c) => `${RANKS[Math.floor(c / 4)].replace('T', '10')}${'♣♦♥♠'[c % 4]}`;

/** Score of the best 5-card hand among 5–7 cards (higher is better): category × 13⁵ + tie-breakers. */
export function evaluate(cards) {
    const counts = new Array(13).fill(0);
    const suits = [[], [], [], []];

    for (const c of cards) {
        counts[Math.floor(c / 4)] += 1;
        suits[c % 4].push(Math.floor(c / 4));
    }

    const straightHigh = (ranksPresent) => {
        for (let hi = 12; hi >= 3; hi -= 1) {
            const need = hi === 3 ? [3, 2, 1, 0, 12] : [hi, hi - 1, hi - 2, hi - 3, hi - 4];

            if (need.every((r) => ranksPresent[r])) {
                return hi;
            }
        }

        return -1;
    };
    const score = (cat, ks) => ks.slice(0, 5).reduce((acc, k) => acc * 13 + k, cat) * 13 ** (5 - Math.min(5, ks.length));
    const flushSuit = suits.find((s) => s.length >= 5);

    if (flushSuit) {
        const present = new Array(13).fill(false);
        flushSuit.forEach((r) => {
            present[r] = true;
        });
        const sf = straightHigh(present);

        if (sf >= 0) {
            return score(8, [sf]);
        }
    }

    const byCount = (n) => counts.map((c, r) => [c, r]).filter(([c]) => c === n).map(([, r]) => r).sort((a, b) => b - a);
    const quads = byCount(4);

    if (quads.length) {
        const kick = counts.map((c, r) => [c, r]).filter(([c, r]) => c > 0 && r !== quads[0]).map(([, r]) => r).sort((a, b) => b - a)[0];

        return score(7, [quads[0], kick]);
    }

    const trips = byCount(3);
    const pairs = byCount(2);

    if (trips.length && (trips.length > 1 || pairs.length)) {
        const pair = [...trips.slice(1), ...pairs].sort((a, b) => b - a)[0];

        return score(6, [trips[0], pair]);
    }

    if (flushSuit) {
        return score(5, [...flushSuit].sort((a, b) => b - a));
    }

    const present = counts.map((c) => c > 0);
    const st = straightHigh(present);

    if (st >= 0) {
        return score(4, [st]);
    }

    const singles = byCount(1);

    if (trips.length) {
        return score(3, [trips[0], ...singles]);
    }

    if (pairs.length >= 2) {
        const rest = counts.map((c, r) => [c, r]).filter(([c, r]) => c > 0 && r !== pairs[0] && r !== pairs[1]).map(([, r]) => r).sort((a, b) => b - a);

        return score(2, [pairs[0], pairs[1], rest[0]]);
    }

    if (pairs.length) {
        return score(1, [pairs[0], ...singles]);
    }

    return score(0, singles);
}

export const HAND_NAMES = ['High card', 'One pair', 'Two pair', 'Three of a kind', 'Straight', 'Flush', 'Full house', 'Four of a kind', 'Straight flush'];
export const category = (s) => Math.floor(s / 13 ** 5);

/** Win/tie/lose for the hero against known and random opponents, exact or by seeded simulation. */
export function equity(hero, known, randoms, board, { trials = 30000, seed = 1 } = {}) {
    const used = new Set([...hero, ...known.flat(), ...board]);
    const deck = Array.from({ length: 52 }, (_, i) => i).filter((c) => !used.has(c));
    const needBoard = 5 - board.length;
    let win = 0;
    let tie = 0;
    let total = 0;
    const play = (fullBoard, randomHands) => {
        const mine = evaluate([...hero, ...fullBoard]);
        const others = [...known, ...randomHands].map((h) => evaluate([...h, ...fullBoard]));
        const best = Math.max(...others);
        total += 1;

        if (mine > best) {
            win += 1;
        } else if (mine === best) {
            tie += 1 / (1 + others.filter((o) => o === best).length);
        }
    };

    if (randoms === 0 && needBoard <= 2) {
        // Exact enumeration of the remaining board cards.
        const n = deck.length;

        if (needBoard === 0) {
            play(board, []);
        } else if (needBoard === 1) {
            deck.forEach((c) => play([...board, c], []));
        } else {
            for (let i = 0; i < n; i += 1) {
                for (let j = i + 1; j < n; j += 1) {
                    play([...board, deck[i], deck[j]], []);
                }
            }
        }

        return { win: win / total, tie: tie / total, exact: true, total };
    }

    const r = seeded(seed);

    for (let t = 0; t < trials; t += 1) {
        const d = [...deck];
        const draw = () => d.splice(Math.floor(r() * d.length), 1)[0];
        const randomHands = Array.from({ length: randoms }, () => [draw(), draw()]);
        const fullBoard = [...board, ...Array.from({ length: needBoard }, draw)];
        play(fullBoard, randomHands);
    }

    return { win: win / total, tie: tie / total, exact: false, total };
}

/** Midpoint-style block circle/ellipse: which cells of a w × h grid are filled. */
export function blockEllipse(w, h, thickness, filled) {
    const rx = w / 2;
    const ry = h / 2;
    const inside = (x, y, ax, ay) => ((x + 0.5 - rx) / ax) ** 2 + ((y + 0.5 - ry) / ay) ** 2 <= 1;
    const cells = [];

    for (let y = 0; y < h; y += 1) {
        const row = [];

        for (let x = 0; x < w; x += 1) {
            const inOuter = inside(x, y, rx, ry);
            const inInner = rx - thickness > 0 && ry - thickness > 0 && inside(x, y, rx - thickness, ry - thickness);
            row.push(inOuter && (filled || !inInner));
        }

        cells.push(row);
    }

    return cells;
}

const DND_COINS = { cp: ['Copper', 1], sp: ['Silver', 10], ep: ['Electrum', 50], gp: ['Gold', 100], pp: ['Platinum', 1000] };
const HIT_DIE = { barbarian: 12, fighter: 10, paladin: 10, ranger: 10, bard: 8, cleric: 8, druid: 8, monk: 8, rogue: 8, warlock: 8, sorcerer: 6, wizard: 6 };
const POINT_COST = { 8: 0, 9: 1, 10: 2, 11: 3, 12: 4, 13: 5, 14: 7, 15: 9 };
const mod = (score) => Math.floor((score - 10) / 2);
const signed = (v) => (v >= 0 ? `+${v}` : `${v}`);

export const TOOLS = {
    impostor: {
        type: 'calc',
        inputs: { alive: N('Players still alive (including you)', 7, 2), impostors: N('Impostors left', 2, 1), cleared: N('Players you are sure are innocent (not you)', 1, 0), youCrew: SEL('You are', { crew: 'A crewmate', impostor: 'An impostor' }, 'crew') },
        label: 'Chance a suspect is an impostor',
        rows: { suspects: 'Suspects', randomVote: 'Chance a random ejection hits an impostor', allFound: 'Chance a random pick of the impostors gets all of them' },
        run: (x) => {
            const suspects = x.alive - 1 - x.cleared;

            if (x.youCrew === 'impostor') {
                return { value: '—', sub: 'You know who the impostors are', rows: { suspects: '—', randomVote: '—', allFound: '—' }, steps: ['Impostors see each other in Among Us'] };
            }

            if (!(suspects >= x.impostors && x.impostors >= 1)) {
                return { error: 'There must be at least as many suspects as impostors.' };
            }

            let all = 1;

            for (let k = 0; k < x.impostors; k += 1) {
                all *= (x.impostors - k) / (suspects - k);
            }

            return { value: pct(x.impostors / suspects, 4), sub: `${x.impostors} impostor${x.impostors > 1 ? 's' : ''} among ${suspects} suspects`, rows: { suspects: num(suspects), randomVote: pct(x.impostors / suspects, 4), allFound: pct(all, 4) }, steps: ['With no other evidence every suspect is equally likely: impostors ÷ suspects', 'Picking every impostor at random: C(I, I) ÷ C(S, I)'] };
        },
    },
    drop_chance: {
        type: 'calc',
        inputs: { rate: LINE('Drop rate (1/512, 0.5% or 0.002)', '1/512'), attempts: N('Attempts (kills, pulls, chests)', 500, 0) },
        label: 'Chance of at least one drop',
        rows: { expected: 'Expected attempts (average)', p50: 'Attempts for 50%', p90: 'Attempts for 90%', p99: 'Attempts for 99%', none: 'Chance of no drop' },
        run: (x) => {
            const t = String(x.rate ?? '').trim();
            const m = t.match(/^(\d+(?:\.\d+)?)\s*\/\s*(\d+(?:\.\d+)?)$/);
            const p = m ? Number(m[1]) / Number(m[2]) : t.endsWith('%') ? Number(t.slice(0, -1)) / 100 : Number(t);

            if (!(p > 0 && p <= 1)) {
                return { error: 'Write the rate as 1/512, 0.5% or 0.002.' };
            }

            const at = (q) => (p === 1 ? 1 : Math.ceil(Math.log(1 - q) / Math.log(1 - p) - 1e-9));
            const chance = 1 - (1 - p) ** x.attempts;

            return { value: pct(chance, 5), sub: `${num(x.attempts)} attempts at ${pct(p, 4)}`, rows: { expected: num(1 / p, 5), p50: num(at(0.5)), p90: num(at(0.9)), p99: num(at(0.99)), none: pct(1 - chance, 5) }, steps: ['P(at least one) = 1 − (1 − p)ⁿ', 'Attempts for a chance q: n = ln(1 − q) ÷ ln(1 − p)', 'Assumes each attempt is independent (no pity or bad-luck protection)'] };
        },
    },
    kd: {
        type: 'calc',
        inputs: { kills: N('Kills', 145, 0), deaths: N('Deaths', 92, 0), assists: N('Assists', 60, 0), target: N('Target K/D (optional)', 2, 0) },
        optional: ['target'],
        label: 'K/D ratio',
        rows: { kda: 'KDA ((K + A) ÷ D)', needed: 'Kills in a row (no deaths) to reach the target' },
        run: (x) => {
            const d = Math.max(1, x.deaths);
            const kd = x.kills / d;
            const need = x.target > 0 ? Math.max(0, Math.ceil(x.target * d - x.kills - 1e-9)) : NaN;

            return { value: num(kd, 4), sub: `${num(x.kills)} kills, ${num(x.deaths)} deaths`, rows: { kda: num((x.kills + x.assists) / d, 4), needed: Number.isFinite(need) ? num(need) : 'Enter a target' }, steps: ['K/D = kills ÷ deaths (0 deaths counts as 1)', 'Games define KDA differently; this uses (kills + assists) ÷ deaths'] };
        },
    },
    mc_circle: {
        type: 'calc',
        inputs: { width: N('Width (blocks)', 21, 1), height: N('Height (blocks; same as width for a circle)', 21, 1), style: SEL('Style', { hollow: 'Hollow (outline)', filled: 'Filled' }, 'hollow'), thick: N('Wall thickness (hollow)', 1, 1) },
        show: { thick: 'style:hollow' },
        label: 'Blocks',
        rows: { rows: 'Blocks per row (top half)', size: 'Size' },
        plots: [['grid', 'Block plan']],
        run: (x) => {
            if (!(Number.isInteger(x.width) && Number.isInteger(x.height) && x.width >= 1 && x.height >= 1 && x.width <= 151 && x.height <= 151)) {
                return { error: 'Use whole sizes from 1 to 151 blocks.' };
            }

            const cells = blockEllipse(x.width, x.height, x.thick, x.style === 'filled');
            const total = sum(cells.map((r) => r.filter(Boolean).length));
            const dots = [];
            cells.forEach((row, y) => row.forEach((on, cx) => {
                if (on) {
                    dots.push([cx, x.height - y]);
                }
            }));
            const perRow = cells.slice(0, Math.ceil(x.height / 2)).map((r) => r.filter(Boolean).length).join(', ');

            return { value: num(total), sub: `${x.width} × ${x.height} ${x.style}`, rows: { rows: perRow, size: `${x.width} × ${x.height}` }, steps: ['A block is placed when its centre lies inside the ellipse (x/rx)² + (y/ry)² ≤ 1', 'Hollow: inside the outer ellipse but not the inner one', 'Odd diameters have a single centre block; even ones a 2 × 2 centre'], plots: { grid: { kind: 'diagram', dots, shapes: [{ points: [[-0.5, 0.5], [x.width - 0.5, 0.5], [x.width - 0.5, x.height + 0.5], [-0.5, x.height + 0.5], [-0.5, 0.5]], muted: true }] } } };
        },
    },
    mc_portal: {
        type: 'calc',
        inputs: { x1: N('Throw 1: X', 0), z1: N('Throw 1: Z', 0), a1: N('Throw 1: facing angle (F3 yaw, °)', -33.7), x2: N('Throw 2: X', 600), z2: N('Throw 2: Z', -200), a2: N('Throw 2: facing angle (°)', -13.2) },
        label: 'Estimated stronghold',
        rows: { distance: 'Distance from throw 2', nether: 'Nether coordinates (÷ 8)', quality: 'Reliability' },
        run: (x) => {
            const dir = (a) => [-Math.sin((a * Math.PI) / 180), Math.cos((a * Math.PI) / 180)];
            const [dx1, dz1] = dir(x.a1);
            const [dx2, dz2] = dir(x.a2);
            const den = dx1 * dz2 - dz1 * dx2;

            if (Math.abs(den) < 1e-6) {
                return { error: 'The two throws point the same way; throw again from further to the side.' };
            }

            const t = ((x.x2 - x.x1) * dz2 - (x.z2 - x.z1) * dx2) / den;

            if (t < 0) {
                return { error: 'The lines cross behind throw 1: check the angles.' };
            }

            const [sx, sz] = [x.x1 + t * dx1, x.z1 + t * dz1];
            const angle = Math.abs((((x.a1 - x.a2) % 360) + 540) % 360 - 180);

            return { value: `X ${Math.round(sx)}, Z ${Math.round(sz)}`, sub: 'where the two eye-of-ender lines cross', rows: { distance: `${num(Math.hypot(sx - x.x2, sz - x.z2), 4)} blocks`, nether: `X ${Math.round(sx / 8)}, Z ${Math.round(sz / 8)}`, quality: angle < 10 ? 'Poor: the lines are nearly parallel; move further sideways' : angle < 25 ? 'Fair' : 'Good (lines cross at a wide angle)' }, steps: ['Minecraft yaw: 0° = south (+Z), 90° = west (−X), −90° = east (+X)', 'Each throw gives a line; the stronghold is near where they cross', 'Dig down near the spot and use another eye to finish the search'] };
        },
    },
    mc_stack: {
        type: 'calc',
        inputs: { items: N('Number of items', 3500, 0), stack: SEL('Stack size', { 64: '64 (most blocks)', 16: '16 (eggs, snowballs, signs…)', 1: '1 (tools, armour)' }, '64') },
        label: 'Stacks',
        rows: { leftover: 'Leftover items', shulkers: 'Shulker boxes (27 slots)', chests: 'Double chests (54 slots)' },
        run: (x) => {
            const s = Number(x.stack);
            const stacks = Math.floor(x.items / s);
            const left = x.items % s;
            const slots = stacks + (left ? 1 : 0);

            return { value: `${num(stacks)} stacks${left ? ` + ${left}` : ''}`, sub: `${num(x.items)} items`, rows: { leftover: num(left), shulkers: `${num(slots / 27, 3)} (${num(Math.ceil(slots / 27))} boxes)`, chests: `${num(slots / 54, 3)} (${num(Math.ceil(slots / 54))} chests)` }, steps: ['Stacks = items ÷ stack size', 'A shulker box or single chest holds 27 stacks; a double chest 54'] };
        },
    },
    nether_portal: {
        type: 'calc',
        inputs: { from: SEL('Coordinates are in', { overworld: 'The Overworld', nether: 'The Nether' }, 'overworld'), x: N('X', 1200), y: N('Y', 70), z: N('Z', -340) },
        label: 'Matching portal location',
        rows: { y: 'Y level', note: 'Linking' },
        run: (x) => {
            const f = x.from === 'overworld' ? 1 / 8 : 8;

            return { value: `X ${Math.floor(x.x * f)}, Z ${Math.floor(x.z * f)}`, sub: x.from === 'overworld' ? 'in the Nether' : 'in the Overworld', rows: { y: `${num(x.y)} (unchanged; Nether portals must be between Y 1 and 125)`, note: 'Portals link to the nearest portal within 16 blocks (Nether) or 128 blocks (Overworld) of the matching point' }, steps: ['One block in the Nether equals 8 in the Overworld (X and Z only)', 'Build the second portal at the matching coordinates so both link to each other'] };
        },
    },
    pogo_candy: {
        type: 'calc',
        inputs: { candy: N('Candy you have', 600, 0), count: N('Pokémon of that species', 40, 0), cost: SEL('Evolution cost', { 12: '12 (Caterpillar, Weedle, Pidgey, Wurmple …)', 25: '25', 50: '50', 100: '100', 200: '200', 400: '400 (Magikarp, Wailmer …)' }, '12'), lucky: SEL('Lucky Egg active', { no: 'No', yes: 'Yes (double XP)' }, 'yes') },
        label: 'Evolutions possible',
        rows: { transfers: 'Transfers needed first', leftover: 'Candy left after', xp: 'XP from evolutions', time: 'Time (about 25 s each)' },
        run: (x) => {
            const c = Number(x.cost);
            const E = Math.min(x.count, Math.floor((x.candy + x.count) / c));
            const transfers = Math.max(0, E * (c - 1) - x.candy);
            const left = x.candy + transfers + E - E * c;

            return { value: num(E), sub: `${num(x.candy)} candy, ${num(x.count)} Pokémon, ${c} candy each`, rows: { transfers: num(transfers), leftover: num(left), xp: num(E * 1000 * (x.lucky === 'yes' ? 2 : 1)), time: `${num((E * 25) / 60, 3)} min` }, steps: ['Each evolution costs the candy and returns 1; each transfer gives 1 candy', 'Evolutions = min(Pokémon, ⌊(candy + Pokémon) ÷ cost⌋)', 'Each evolution gives 1,000 XP since November 2020; a Lucky Egg doubles it (Niantic)'] };
        },
    },
    pyramid: {
        type: 'calc',
        inputs: { base: N('Base width (blocks)', 21, 1), step: N('Step in per layer (each side)', 1, 1), style: SEL('Build', { solid: 'Solid', hollow: 'Hollow (one-block shell)' }, 'solid') },
        label: 'Blocks needed',
        rows: { layers: 'Layers (height)', top: 'Top layer' },
        grids: [['table', 'Blocks per layer']],
        run: (x) => {
            const layers = [];

            for (let s = x.base; s >= 1; s -= 2 * x.step) {
                const solid = s * s;
                const inner = Math.max(0, s - 2) ** 2;
                layers.push({ s, n: x.style === 'solid' || s <= 2 ? solid : solid - inner });
            }

            return { value: num(sum(layers.map((l) => l.n))), sub: `${x.base} × ${x.base} base, ${x.style}`, rows: { layers: num(layers.length), top: `${layers[layers.length - 1].s} × ${layers[layers.length - 1].s}` }, steps: ['Each layer shrinks by the step on every side', 'Solid layer = s²; hollow layer = s² − (s − 2)² (the outer ring)'], grids: { table: { columns: ['Size', 'Blocks'], rows: layers.slice(0, 80).map((l, i) => ({ header: `Layer ${i + 1}`, cells: [`${l.s} × ${l.s}`, num(l.n)] })) } } };
        },
    },
    rust_decay: {
        type: 'calc',
        inputs: { material: SEL('Building tier', 'data:rust:fixed', 'stone'), health: N('Current health (%)', 100, 0) },
        data: ['rust'],
        label: 'Time until it decays',
        rows: { full: 'Full decay time for this tier', note: 'Rules' },
        run: (x, ctx) => {
            const m = ctx.c.data.other?.rust?.[x.material];

            if (!m) {
                return { error: 'Choose a material.' };
            }

            const hours = (m.hours * x.health) / 100;

            return { value: `${num(hours, 4)} h`, sub: `${m.name} at ${num(x.health)}% health`, rows: { full: `${m.hours} h`, note: 'Decay starts at once when the tool cupboard has none of that material (or no cupboard)' }, steps: ['Default decay times: twig 1 h, wood 3 h, stone 5 h, sheet metal 8 h, armored 12 h (Facepunch wiki; servers can change them)', 'Time left ≈ full decay time × current health share', 'Keep materials in the tool cupboard to pay upkeep and stop decay'] };
        },
    },
    fps_frametime: {
        type: 'calc',
        inputs: { fps: N('Frames per second', 144, 0) },
        label: 'Frame time',
        rows: { refresh: 'Matching monitor refresh' },
        grids: [['table', 'Common rates']],
        run: (x) => ({ value: `${num(1000 / x.fps, 5)} ms`, sub: `${num(x.fps)} fps`, rows: { refresh: `${num(x.fps)} Hz` }, steps: ['Frame time = 1000 ÷ fps (ms)', 'Going from 30 to 60 fps saves 16.7 ms per frame; 144 to 240 saves only 2.8 ms'], grids: { table: { columns: ['Frame time'], rows: [30, 60, 75, 120, 144, 165, 240, 360].map((f) => ({ header: `${f} fps`, cells: [`${num(1000 / f, 4)} ms`], highlight: f === x.fps })) } } }),
    },
    mc_chunk: {
        type: 'calc',
        inputs: { x: N('Block X', -1234), z: N('Block Z', 5678) },
        label: 'Chunk',
        rows: { inChunk: 'Position inside the chunk', corners: 'Chunk corners (X, Z)', region: 'Region file' },
        run: (x) => {
            const cx = Math.floor(x.x / 16);
            const cz = Math.floor(x.z / 16);

            return { value: `${cx}, ${cz}`, sub: `block ${x.x}, ${x.z}`, rows: { inChunk: `${((x.x % 16) + 16) % 16}, ${((x.z % 16) + 16) % 16}`, corners: `${cx * 16}, ${cz * 16} to ${cx * 16 + 15}, ${cz * 16 + 15}`, region: `r.${Math.floor(cx / 32)}.${Math.floor(cz / 32)}.mca` }, steps: ['Chunks are 16 × 16 blocks: chunk = ⌊coordinate ÷ 16⌋ (negative coordinates round down)', 'A region file holds 32 × 32 chunks (512 × 512 blocks)'] };
        },
    },
    dnd_money: {
        type: 'calc',
        inputs: { cp: N('Copper (cp)', 0, 0), sp: N('Silver (sp)', 35, 0), ep: N('Electrum (ep)', 2, 0), gp: N('Gold (gp)', 127, 0), pp: N('Platinum (pp)', 3, 0), players: N('Split between players', 4, 1) },
        label: 'Total in gold',
        rows: { cp: 'In copper', fewest: 'Fewest coins (no electrum)', share: 'Each player’s share' },
        run: (x) => {
            const total = sum(Object.entries(DND_COINS).map(([k, [, v]]) => x[k] * v));
            const fewest = (cp) => {
                let rest = cp;

                return ['pp', 'gp', 'sp', 'cp'].map((k) => {
                    const n = Math.floor(rest / DND_COINS[k][1]);
                    rest -= n * DND_COINS[k][1];

                    return n ? `${n} ${k}` : '';
                }).filter(Boolean).join(', ') || '0 cp';
            };
            const share = Math.floor(total / x.players);

            return { value: `${num(total / 100, 6)} gp`, sub: `${num(total)} cp in all`, rows: { cp: num(total), fewest: fewest(total), share: `${fewest(share)}${total % x.players ? ` (${total % x.players} cp left over)` : ''}` }, steps: ['5e SRD: 1 pp = 10 gp = 20 ep = 100 sp = 1,000 cp'] };
        },
    },
    dnd_encounter: {
        type: 'calc',
        inputs: { rules: SEL('Rules', { 2014: '2014 (DMG: thresholds and multipliers)', 2024: '2024 (XP budget)' }, '2014'), party: LINE('Character levels (one per character)', '5 5 5 4'), monsters: TXT('Monsters: challenge rating × count (one per line)', '3 × 1\n1/2 × 4') },
        data: ['dnd_2014', 'dnd_2024', 'dnd_multipliers', 'dnd_cr_xp'],
        label: 'Difficulty',
        rows: { xp: 'Monster XP', adjusted: 'Adjusted XP (2014)', budget: 'Party thresholds' },
        run: (x, ctx) => {
            const d = ctx.c.data.other ?? {};
            const levels = parseNumbers(x.party).values;

            if (!levels.length || levels.some((l) => !(Number.isInteger(l) && l >= 1 && l <= 20))) {
                return { error: 'Enter character levels from 1 to 20.' };
            }

            const monsters = [];

            for (const line of String(x.monsters ?? '').split(/\r?\n/).map((l) => l.trim()).filter(Boolean)) {
                const m = line.match(/^(?:cr\s*)?([\d/]+)\s*(?:[×x*]\s*(\d+))?$/i);
                const xp = m ? d.dnd_cr_xp?.[m[1]] : undefined;

                if (xp === undefined) {
                    return { error: `“${line}”: write a challenge rating and count, e.g. “1/2 × 4”.` };
                }

                monsters.push({ cr: m[1], count: Number(m[2] ?? 1), xp });
            }

            const count = sum(monsters.map((m) => m.count));
            const xp = sum(monsters.map((m) => m.xp * m.count));

            if (x.rules === '2024') {
                const b = [0, 1, 2].map((k) => sum(levels.map((l) => d.dnd_2024[l][k])));
                const diff = xp > b[2] ? 'Beyond high (very dangerous)' : xp > b[1] ? 'High' : xp > b[0] ? 'Moderate' : 'Low';

                return { value: diff, sub: `${num(xp)} XP of monsters`, rows: { xp: num(xp), adjusted: 'Not used in 2024 rules', budget: `Low ${num(b[0])} · Moderate ${num(b[1])} · High ${num(b[2])}` }, steps: ['2024 rules (SRD 5.2): add each character’s XP budget for the chosen difficulty', 'Compare with the total XP of the monsters (no multiplier)'] };
            }

            const ladder = d.dnd_multipliers;
            let idx = count === 1 ? 1 : count === 2 ? 2 : count <= 6 ? 3 : count <= 10 ? 4 : count <= 14 ? 5 : 6;

            if (levels.length < 3) {
                idx += 1;
            } else if (levels.length >= 6) {
                idx -= 1;
            }

            const mult = ladder[idx];
            const adj = xp * mult;
            const t = [0, 1, 2, 3].map((k) => sum(levels.map((l) => d.dnd_2014[l][k])));
            const diff = adj >= t[3] ? 'Deadly' : adj >= t[2] ? 'Hard' : adj >= t[1] ? 'Medium' : adj >= t[0] ? 'Easy' : 'Trivial';

            return { value: diff, sub: `${num(adj)} adjusted XP`, rows: { xp: num(xp), adjusted: `${num(adj)} (× ${mult} for ${count} monster${count > 1 ? 's' : ''}, party of ${levels.length})`, budget: `Easy ${num(t[0])} · Medium ${num(t[1])} · Hard ${num(t[2])} · Deadly ${num(t[3])}` }, steps: ['2014 DMG: sum each character’s thresholds; multiply the monsters’ XP by the multiplier for their number', 'Parties under 3 use the next higher multiplier, 6 or more the next lower', 'Award the unadjusted XP to the party'] };
        },
    },
    dnd_hp: {
        type: 'calc',
        inputs: { cls: SEL('Class', Object.fromEntries(Object.entries(HIT_DIE).map(([k, v]) => [k, `${k[0].toUpperCase()}${k.slice(1)} (d${v})`])), 'fighter'), level: N('Level', 5, 1), con: N('Constitution score', 14, 1), extra: SEL('Extra HP per level', { 0: 'None', 1: 'Hill dwarf (+1)', 2: 'Tough feat (+2)', 3: 'Both (+3)' }, '0') },
        label: 'Hit points (fixed average)',
        rows: { range: 'If rolled: minimum – maximum', perLevel: 'Gained each level after 1st', con: 'Constitution modifier' },
        run: (x) => {
            const die = HIT_DIE[x.cls];
            const c = mod(x.con);
            const e = Number(x.extra);

            if (!(Number.isInteger(x.level) && x.level >= 1 && x.level <= 20)) {
                return { error: 'Level is 1 to 20.' };
            }

            const first = die + c + e;
            const per = die / 2 + 1 + c + e;
            const avg = first + (x.level - 1) * per;
            const min = first + (x.level - 1) * Math.max(1, 1 + c + e);
            const max = first + (x.level - 1) * (die + c + e);

            return { value: num(Math.max(1, avg)), sub: `Level ${x.level} ${x.cls}, Con ${x.con} (${signed(c)})`, rows: { range: `${num(min)} – ${num(max)}`, perLevel: `${num(per)} (d${die} average ${die / 2 + 1}, ${signed(c)} Con${e ? `, +${e}` : ''})`, con: signed(c) }, steps: ['Level 1: the full hit die + Constitution modifier', 'Each later level: the die’s fixed value (half + 1) or a roll, + Constitution modifier (at least 1)', '5e System Reference Document'] };
        },
    },
    point_buy: {
        type: 'calc',
        inputs: { str: N('Strength', 15, 8), dex: N('Dexterity', 14, 8), con: N('Constitution', 13, 8), int: N('Intelligence', 12, 8), wis: N('Wisdom', 10, 8), cha: N('Charisma', 8, 8), bonus: LINE('Racial or background bonuses (e.g. +2 str +1 con)', '+2 str +1 con') },
        optional: ['bonus'],
        label: 'Points spent',
        rows: { left: 'Points left of 27', final: 'Final scores (modifiers)' },
        run: (x) => {
            const keys = ['str', 'dex', 'con', 'int', 'wis', 'cha'];

            if (keys.some((k) => !(x[k] in POINT_COST))) {
                return { error: 'Point-buy scores are 8 to 15 before bonuses.' };
            }

            const spent = sum(keys.map((k) => POINT_COST[x[k]]));
            const bonus = Object.fromEntries(keys.map((k) => [k, 0]));
            (String(x.bonus ?? '').toLowerCase().match(/[+-]\d+\s*[a-z]{3}/g) ?? []).forEach((t) => {
                const m = t.match(/([+-]\d+)\s*([a-z]{3})/);

                if (m[2] in bonus) {
                    bonus[m[2]] += Number(m[1]);
                }
            });

            return { value: `${spent} / 27`, sub: spent > 27 ? 'Over budget' : spent === 27 ? 'Budget used exactly' : `${27 - spent} points to spend`, rows: { left: num(27 - spent), final: keys.map((k) => `${k.toUpperCase()} ${x[k] + bonus[k]} (${signed(mod(x[k] + bonus[k]))})`).join(', ') }, steps: ['Costs: 8 = 0, 9 = 1, 10 = 2, 11 = 3, 12 = 4, 13 = 5, 14 = 7, 15 = 9 points (5e SRD), 27 points in all', 'Modifier = ⌊(score − 10) ÷ 2⌋'] };
        },
    },
    poker_ev: {
        type: 'calc',
        inputs: { pot: N('Pot before your call (including the bet)', 100, 0), call: N('Amount to call', 25, 0), equity: N('Your chance to win (%)', 30, 0) },
        label: 'EV of calling',
        rows: { potOdds: 'Pot odds', breakEven: 'Break-even equity', verdict: 'Decision' },
        run: (x) => {
            const p = x.equity / 100;
            const ev = p * x.pot - (1 - p) * x.call;
            const be = x.call / (x.pot + x.call);

            return { value: `${ev >= 0 ? '+' : ''}${num(ev, 5)}`, sub: 'chips per call, on average', rows: { potOdds: `${num(x.pot / x.call, 4)} : 1`, breakEven: pct(be, 4), verdict: ev > 0 ? 'Calling is profitable' : ev < 0 ? 'Folding is better' : 'Break-even' }, steps: ['EV = P(win) × pot − P(lose) × call', 'Calling breaks even when equity = call ÷ (pot + call)', 'Ignores future betting (implied odds)'] };
        },
    },
    poker_odds: {
        type: 'calc',
        inputs: { hero: LINE('Your cards (e.g. As Kd)', 'Ah Kh'), board: LINE('Board cards (0, 3, 4 or 5)', 'Qh 7h 2c'), known: TXT('Known opponent hands (one per line, optional)', 'Qs Qd'), randoms: N('Opponents with unknown cards', 0, 0), seed: N('Simulation seed', 1, 1) },
        optional: ['seed'],
        label: 'Chance to win',
        rows: { tie: 'Chance to tie (share of the pot)', lose: 'Chance to lose', current: 'Your hand now', method: 'Method' },
        run: (x) => {
            const hero = parseCards(x.hero);
            const board = parseCards(x.board || '');
            const known = String(x.known ?? '').split(/\r?\n/).map((l) => l.trim()).filter(Boolean).map(parseCards);

            if (!hero || hero.length !== 2) {
                return { error: 'Enter your two cards, e.g. As Kd (10 or T for ten; c d h s for suits).' };
            }

            if (!board || ![0, 3, 4, 5].includes(board.length) || known.some((h) => !h || h.length !== 2)) {
                return { error: 'The board has 0, 3, 4 or 5 cards; each known hand two cards.' };
            }

            const all = [...hero, ...board, ...known.flat()];

            if (new Set(all).size !== all.length) {
                return { error: 'A card appears twice.' };
            }

            if (!known.length && !(x.randoms >= 1)) {
                return { error: 'Add at least one opponent (known cards or a random hand).' };
            }

            if (known.length + x.randoms > 9) {
                return { error: 'Up to 9 opponents.' };
            }

            const r = equity(hero, known, x.randoms, board, { trials: 30000, seed: x.seed || 1 });
            const margin = r.exact ? 0 : 1.96 * Math.sqrt((r.win * (1 - r.win)) / r.total);
            const now = board.length >= 3 ? HAND_NAMES[category(evaluate([...hero, ...board]))] : 'Before the flop';

            return { value: pct(r.win, 4), sub: r.exact ? 'Exact' : `± ${pct(margin, 2)} (simulation)`, rows: { tie: pct(r.tie, 4), lose: pct(1 - r.win - r.tie, 4), current: now, method: r.exact ? `Exact: all ${num(r.total)} remaining boards` : `Seeded simulation of ${num(r.total)} deals (95% margin ± ${pct(margin, 2)})` }, steps: [`You: ${hero.map(cardText).join(' ')}; board: ${board.map(cardText).join(' ') || '—'}`, 'Every remaining board (and unknown hand) is dealt and the best five-card hands compared', 'Ties count as a share of the pot; equity is not the same as winning the hand at showdown every time'] };
        },
    },
    dating_theory: {
        type: 'calc',
        inputs: { n: N('Candidates you could meet', 20, 1) },
        label: 'Reject the first',
        rows: { chance: 'Chance of choosing the very best', then: 'Then choose', rule: 'Rule' },
        run: (x) => {
            const n = x.n;
            const pBest = (r) => (r === 0 ? 1 / n : (r / n) * sum(Array.from({ length: n - r }, (_, i) => 1 / (r + i))));
            let best = 0;

            for (let r = 1; r < n; r += 1) {
                if (pBest(r) > pBest(best)) {
                    best = r;
                }
            }

            return { value: `${best} candidate${best === 1 ? '' : 's'}`, sub: `of ${n} (≈ ${pct(best / n, 3)})`, rows: { chance: pct(pBest(best), 4), then: 'The first one better than everyone you have seen so far', rule: 'About 37% (n ÷ e), with a 37% chance of the best for large n' }, steps: ['Optimal stopping (the secretary problem): look at r candidates, then take the next one who beats them all', 'P(best) = (r/n) Σ 1/(i − 1) for i = r + 1 … n; maximised near r = n/e', 'A mathematical model, not relationship advice'] };
        },
    },
    vampire: {
        type: 'calc',
        inputs: { population: N('Starting human population', 8.1e9, 1), vampires: N('Starting vampires', 1, 1), bites: N('New vampires each vampire makes per month', 1, 0), births: N('Human births per month (% of population)', 0.1, 0) },
        label: 'Months until no humans are left',
        rows: { years: 'In years', curve: 'Vampires after 12 months' },
        plots: [['chart', 'Humans (blue) and vampires (dashed) over time']],
        run: (x) => {
            let H = x.population;
            let V = x.vampires;
            const hs = [[0, H]];
            const vs = [[0, V]];
            let months = 0;

            while (H >= 1 && months < 2400) {
                const bitten = Math.min(H, V * x.bites);
                H = H - bitten + H * (x.births / 100);
                V += bitten;
                months += 1;
                hs.push([months, Math.max(0, H)]);
                vs.push([months, V]);
            }

            if (months >= 2400) {
                return { value: 'Humans survive', sub: 'Births keep up with the vampires', rows: { years: '—', curve: num(vs[12]?.[1] ?? V, 4) }, steps: ['The population grows faster than it is bitten'], plots: { chart: { series: hs, extra: [vs], xLabel: 'Months', yLabel: 'People' } } };
            }

            return { value: `${months} months`, sub: `from ${num(x.vampires)} vampire${x.vampires > 1 ? 's' : ''}`, rows: { years: num(months / 12, 4), curve: num(vs[Math.min(12, vs.length - 1)][1], 4) }, steps: ['Each month every vampire turns a set number of humans, so vampires grow geometrically', 'Efthimiou & Gandhi (2007) used this argument to show vampires could not exist: one vampire in 1600 would end humanity within about two and a half years', 'A thought experiment, not a forecast'], plots: { chart: { series: hs, extra: [vs], xLabel: 'Months', yLabel: 'People' } } };
        },
    },
    zombie: {
        type: 'calc',
        inputs: { population: N('Starting humans', 1000000, 1), zombies: N('Starting zombies', 10, 1), beta: N('Bite rate β (per day)', 0.6, 0), alpha: N('Zombie kill rate α (per day)', 0.4, 0), zeta: N('Resurrection rate ζ (per day)', 0.05, 0), days: N('Days to simulate', 60, 1) },
        label: 'Outcome',
        rows: { day: 'Day humans fall below 1%', end: 'At the end: humans, zombies, removed' },
        plots: [['chart', 'Humans (blue), zombies (dashed)']],
        run: (x) => {
            const N0 = x.population + x.zombies;
            let [S, Z, R] = [x.population, x.zombies, 0];
            const dt = 0.05;
            const hs = [[0, S]];
            const zs = [[0, Z]];
            let fallDay = null;
            const f = ([s, z, r]) => {
                const meet = (s * z) / N0;

                return [-x.beta * meet, x.beta * meet + x.zeta * r - x.alpha * meet, x.alpha * meet - x.zeta * r];
            };

            for (let t = 0; t < x.days; t += dt) {
                const y = [S, Z, R];
                const k1 = f(y);
                const k2 = f(y.map((v, i) => v + (dt / 2) * k1[i]));
                const k3 = f(y.map((v, i) => v + (dt / 2) * k2[i]));
                const k4 = f(y.map((v, i) => v + dt * k3[i]));
                [S, Z, R] = y.map((v, i) => Math.max(0, v + (dt / 6) * (k1[i] + 2 * k2[i] + 2 * k3[i] + k4[i])));

                if (fallDay === null && S < x.population / 100) {
                    fallDay = t + dt;
                }

                if (Math.abs(((t + dt) % 1)) < dt / 2 || Math.abs(((t + dt) % 1) - 1) < dt / 2) {
                    hs.push([t + dt, S]);
                    zs.push([t + dt, Z]);
                }
            }

            return { value: fallDay !== null ? 'The zombies win' : Z < 1 ? 'Humanity wins' : 'Still undecided', sub: fallDay !== null ? `humans below 1% on day ${num(fallDay, 3)}` : `after ${x.days} days`, rows: { day: fallDay !== null ? num(fallDay, 3) : 'Not within the simulation', end: `${num(S, 4)}, ${num(Z, 4)}, ${num(R, 4)}` }, steps: ['SZR model of Munz, Hudea, Imad & Smith (2009): humans S are bitten (β), zombies Z are destroyed (α), the removed R can rise again (ζ)', 'Solved numerically (Runge–Kutta, 0.05-day steps) with encounters proportional to S × Z ÷ N', 'In their basic model, with any resurrection the zombies always win eventually'], plots: { chart: { series: hs, extra: [zs], xLabel: 'Days', yLabel: 'Population' } } };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
