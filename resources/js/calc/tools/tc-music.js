import { defineTools } from '../engines/formula.js';
import { handlersFor } from '../physics/core.js';
import { N, SEL, TXT, LINE, num, pct } from '../statistics/common.js';
import { parseNumbers } from '../statistics/data.js';
import * as M from '../tech/music.js';

/**
 * Music and audio: notes, intervals, chords, scales, keys and transposition (12-TET with correct spelling),
 * tempo and delay times, fret positions, string tension (D'Addario unit weights), harmonic series, room modes,
 * loudspeaker boxes and ports (Thiele–Small estimates), audio file sizes.
 */

const SPEED_OF_SOUND = 343;
const NOTE = (label, value) => [label, 'text', null, value];
const NOTE_LIST = (label, value) => [label, 'textarea', null, value];

/** Reads a list of notes ("C E G" or "C, E, G"). */
function readNotes(text) {
    const tokens = String(text ?? '').trim().split(/[\s,–-]+/).filter(Boolean);
    const notes = tokens.map(M.parseNote);
    const bad = tokens.filter((_, i) => !notes[i]);

    return bad.length ? { problem: `Not notes: ${bad.slice(0, 5).join(', ')} (write C, F#, Bb, E♭4 …).` } : { notes };
}

/** A keyboard diagram (two octaves from C) with the given pitch classes highlighted. */
function keyboard(pcs, labels = {}) {
    const shapes = [];
    const tags = [];
    const whites = [0, 2, 4, 5, 7, 9, 11];
    const blacks = [1, 3, 6, 8, 10];

    for (let o = 0; o < 2; o += 1) {
        whites.forEach((p, i) => {
            const x = (o * 7 + i) * 2;
            shapes.push({ points: [[x, 0], [x + 2, 0], [x + 2, 8], [x, 8], [x, 0]], closed: pcs.has(p), muted: !pcs.has(p) });

            if (pcs.has(p) && o === 0) {
                tags.push({ x: x + 1, y: 1, text: labels[p] ?? '' });
            }
        });
        blacks.forEach((p) => {
            const xi = o * 14 + { 1: 1.35, 3: 3.35, 6: 7.35, 8: 9.35, 10: 11.35 }[p];
            shapes.push({ points: [[xi, 3.2], [xi + 1.3, 3.2], [xi + 1.3, 8], [xi, 8], [xi, 3.2]], closed: pcs.has(p), muted: false, dashed: !pcs.has(p) });

            if (pcs.has(p) && o === 0) {
                tags.push({ x: xi + 0.65, y: 4.2, text: labels[p] ?? '' });
            }
        });
    }

    return { kind: 'diagram', shapes, labels: tags };
}

const noteNames = (notes) => notes.map((n) => M.noteText(n)).join(' – ');

export const TOOLS = {
    audio_size: {
        type: 'calc',
        inputs: { mode: SEL('Audio', { pcm: 'Uncompressed (WAV, AIFF)', compressed: 'Compressed (MP3, AAC, Opus …)' }, 'pcm'), rate: SEL('Sample rate', { 44100: '44.1 kHz (CD)', 48000: '48 kHz (video)', 88200: '88.2 kHz', 96000: '96 kHz', 192000: '192 kHz' }, '44100'), depth: SEL('Bit depth', { 16: '16-bit', 24: '24-bit', 32: '32-bit float' }, '16'), channels: SEL('Channels', { 1: 'Mono', 2: 'Stereo', 6: '5.1 surround', 8: '7.1 surround' }, '2'), kbps: N('Bitrate (kbit/s)', 320, 1), minutes: N('Duration (minutes)', 4, 0) },
        show: { rate: 'mode:pcm', depth: 'mode:pcm', channels: 'mode:pcm', kbps: 'mode:compressed' },
        when: { kbps: (x) => x.mode === 'compressed' },
        label: 'File size',
        rows: { bitrate: 'Bitrate', perMinute: 'Per minute', perGb: 'Minutes per GB' },
        run: (x) => {
            const bps = x.mode === 'pcm' ? Number(x.rate) * Number(x.depth) * Number(x.channels) : x.kbps * 1000;
            const bytes = (bps * x.minutes * 60) / 8;

            return { value: bytes >= 1e9 ? `${num(bytes / 1e9, 4)} GB` : `${num(bytes / 1e6, 4)} MB`, sub: `${num(x.minutes)} min`, rows: { bitrate: `${num(bps / 1000, 5)} kbit/s`, perMinute: `${num((bps * 60) / 8e6, 4)} MB`, perGb: num(8e9 / bps / 60, 4) }, steps: [x.mode === 'pcm' ? 'Bitrate = sample rate × bit depth × channels (CD audio: 1,411.2 kbit/s)' : 'Compressed size = bitrate × duration', 'Size = bitrate × seconds ÷ 8 (WAV headers add a few bytes)'] };
        },
    },
    bpm: {
        type: 'calc',
        inputs: { beats: N('Beats counted', 30, 1), seconds: N('In seconds', 15, 0) },
        label: 'Tempo',
        rows: { beatMs: 'One beat', marking: 'Tempo marking (approximate)', barMs: 'One 4/4 bar' },
        run: (x) => {
            const bpm = (x.beats * 60) / x.seconds;
            const marks = [[40, 'Grave / Largo'], [60, 'Larghetto'], [66, 'Adagio'], [76, 'Andante'], [108, 'Moderato'], [120, 'Allegro'], [156, 'Vivace'], [168, 'Presto'], [200, 'Prestissimo']];
            const mark = [...marks].reverse().find(([m]) => bpm >= m);

            return { value: `${num(bpm, 4)} BPM`, sub: `${num(x.beats)} beats in ${num(x.seconds)} s`, rows: { beatMs: `${num(60000 / bpm, 4)} ms`, marking: mark ? mark[1] : 'Slower than Grave', barMs: `${num(240000 / bpm, 5)} ms` }, steps: ['BPM = beats × 60 ÷ seconds', 'Count for 15–30 s for a steady estimate; tempo markings overlap and vary by era'] };
        },
    },
    chord: {
        type: 'calc',
        inputs: { root: NOTE('Root', 'C'), type: SEL('Chord', Object.fromEntries(Object.entries(M.CHORDS).map(([k, v]) => [k, v[0]])), 'maj7') },
        label: 'Notes',
        rows: { symbol: 'Symbol', intervals: 'Intervals', semitones: 'Semitones from the root' },
        plots: [['keys', 'On the keyboard']],
        run: (x) => {
            const r = M.parseNote(x.root);

            if (!r) {
                return { error: 'Enter a root note such as C, F#, Bb or E♭.' };
            }

            const notes = M.chordNotes(r, x.type);
            const ivs = M.CHORDS[x.type][2].map(M.parseInterval);
            const labels = Object.fromEntries(notes.map((n) => [M.pc(n), M.noteText(n)]));

            return { value: noteNames(notes), sub: `${M.chordSymbol(r, x.type)}: ${M.CHORDS[x.type][0]}`, rows: { symbol: M.chordSymbol(r, x.type), intervals: ivs.map((i) => i.name).join(', '), semitones: ivs.map((i) => i.semis).join(', ') }, steps: ['Each chord is a formula of intervals stacked on the root', 'Notes are spelled from the intervals (a major third above E is G♯, not A♭)'], plots: { keys: keyboard(new Set(notes.map(M.pc)), labels) } };
        },
    },
    chord_finder: {
        type: 'calc',
        inputs: { notes: NOTE_LIST('Notes (any order; the first is the bass)', 'E G C') },
        label: 'Chord',
        rows: { all: 'All names', inversion: 'Inversion', pcs: 'Pitch classes' },
        plots: [['keys', 'On the keyboard']],
        run: (x) => {
            const r = readNotes(x.notes);

            if (r.problem) {
                return { error: r.problem };
            }

            if (r.notes.length < 2) {
                return { empty: 'Enter at least two notes.' };
            }

            const found = M.findChords(r.notes);
            const bass = r.notes[0];

            if (!found.length) {
                return { value: 'No standard chord', sub: 'Try fewer notes or check the spelling', rows: { all: 'None found', inversion: '—', pcs: [...new Set(r.notes.map(M.pc))].map((p) => M.pcName(p)).join(' ') }, steps: ['Every chord formula is tried on every note as a root'], plots: { keys: keyboard(new Set(r.notes.map(M.pc))) } };
            }

            const ranked = [...found].sort((a, b) => Number(M.pc(b.root) === M.pc(bass)) - Number(M.pc(a.root) === M.pc(bass)) || M.CHORDS[a.type][2].length - M.CHORDS[b.type][2].length);
            const best = ranked[0];
            const slash = M.pc(best.root) === M.pc(bass) ? '' : `/${M.noteText(bass)}`;
            const tones = M.chordNotes(best.root, best.type).map(M.pc);
            const inv = ['Root position', 'First inversion', 'Second inversion', 'Third inversion'][tones.indexOf(M.pc(bass))] ?? 'Extended';

            return { value: `${M.chordSymbol(best.root, best.type)}${slash}`, sub: best.name, rows: { all: ranked.map((c) => M.chordSymbol(c.root, c.type) + (M.pc(c.root) === M.pc(bass) ? '' : `/${M.noteText(bass)}`)).join(', '), inversion: inv, pcs: [...new Set(r.notes.map(M.pc))].map((p) => M.pcName(p)).join(' ') }, steps: ['The notes are reduced to pitch classes and matched against every chord formula and root', 'When the bass is not the root the chord is written as a slash chord (C/E)'], plots: { keys: keyboard(new Set(r.notes.map(M.pc)), Object.fromEntries(r.notes.map((n) => [M.pc(n), M.noteText(n)]))) } };
        },
    },
    chord_inversion: {
        type: 'calc',
        inputs: { chord: LINE('Chord symbol', 'G7') },
        label: 'Inversions',
        rows: { notes: 'Root position notes' },
        grids: [['table', 'Every inversion']],
        run: (x) => {
            const c = M.parseChord(x.chord);

            if (!c) {
                return { error: 'Write a chord symbol such as C, Am, G7, Fmaj7 or Bdim.' };
            }

            const notes = M.chordNotes(c.root, c.type);
            const figures = notes.length === 3 ? ['5/3 (root)', '6/3 (6)', '6/4'] : ['7 (root)', '6/5', '4/3', '4/2 (2)'];
            const names = ['Root position', 'First inversion', 'Second inversion', 'Third inversion', 'Fourth inversion', 'Fifth inversion'];
            const rows = notes.map((_, k) => {
                const order = [...notes.slice(k), ...notes.slice(0, k)];

                return { header: names[k], cells: [noteNames(order), k ? `${M.chordSymbol(c.root, c.type)}/${M.noteText(order[0])}` : M.chordSymbol(c.root, c.type), figures[k] ?? '—'] };
            });

            return { value: `${notes.length} positions`, sub: M.chordSymbol(c.root, c.type), rows: { notes: noteNames(notes) }, steps: ['Each inversion moves the lowest note up an octave', 'Figured bass numbers give the intervals above the bass'], grids: { table: { columns: ['Notes (low to high)', 'Symbol', 'Figured bass'], rows } } };
        },
    },
    progression: {
        type: 'calc',
        inputs: { key: NOTE('Key', 'C'), mode: SEL('Mode', { major: 'Major', minor: 'Minor' }, 'major'), preset: SEL('Progression', { pop: 'I – V – vi – IV (pop)', doo: 'I – vi – IV – V (50s)', jazz: 'ii7 – V7 – Imaj7 (jazz)', canon: 'I – V – vi – iii – IV – I – IV – V (Pachelbel)', minor: 'i – VI – III – VII (minor pop)', andalusian: 'i – ♭VII – ♭VI – V (Andalusian)', custom: 'My own Roman numerals' }, 'pop'), custom: LINE('Roman numerals (e.g. I vi ii V7)', 'I vi ii V7') },
        show: { custom: 'preset:custom' },
        label: 'Chords',
        rows: { numerals: 'Roman numerals' },
        grids: [['table', 'Notes of each chord']],
        run: (x) => {
            const tonic = M.parseNote(x.key);

            if (!tonic) {
                return { error: 'Enter a key such as C, G, Bb or F#.' };
            }

            const presets = { pop: 'I V vi IV', doo: 'I vi IV V', jazz: 'ii7 V7 Imaj7', canon: 'I V vi iii IV I IV V', minor: 'i VI III VII', andalusian: 'i bVII bVI V' };
            const text = x.preset === 'custom' ? x.custom : presets[x.preset];
            const mode = x.preset === 'minor' || x.preset === 'andalusian' ? 'minor' : x.mode;
            const numerals = String(text).trim().split(/[\s,–-]+/).filter(Boolean);
            const chords = numerals.map((n) => M.romanChord(n, tonic, mode));
            const bad = numerals.filter((_, i) => !chords[i]);

            if (bad.length) {
                return { error: `Not Roman numerals: ${bad.join(', ')} (use I ii iii IV V vi vii°, with 7, maj7, ♭ or ♯).` };
            }

            const symbols = chords.map((c) => M.chordSymbol(c.root, c.type));

            return { value: symbols.join(' – '), sub: `in ${M.noteText(tonic)} ${mode}`, rows: { numerals: numerals.join(' – ') }, steps: ['Upper-case numerals are major chords, lower-case minor, ° diminished', 'In minor keys, an upper-case V uses the raised seventh (harmonic minor)', 'Altered numerals (♭VII) are relative to the major scale'], grids: { table: { columns: ['Chord', 'Notes'], rows: chords.map((c, i) => ({ header: numerals[i], cells: [symbols[i], noteNames(M.chordNotes(c.root, c.type))] })) } } };
        },
    },
    chord_transposer: {
        type: 'calc',
        inputs: { chart: TXT('Chord chart (lyrics lines are left alone)', 'G      D      Em     C\nAmazing grace how sweet the sound\nG  D/F#  Em  C  G'), by: SEL('Transpose by', { semis: 'Semitones', keys: 'From one key to another' }, 'semis'), semis: N('Semitones (up +, down −)', 2), from: NOTE('From key', 'G'), to: NOTE('To key', 'A'), spell: SEL('Spell with', { sharps: 'Sharps (♯)', flats: 'Flats (♭)' }, 'sharps') },
        show: { semis: 'by:semis', from: 'by:keys', to: 'by:keys' },
        when: { semis: (x) => x.by === 'semis' },
        label: 'Transposed chart',
        rows: { shift: 'Shift', capo: 'Or play the original shapes with a capo on fret' },
        run: (x) => {
            let shift = x.semis;

            if (x.by === 'keys') {
                const a = M.parseNote(x.from);
                const b = M.parseNote(x.to);

                if (!a || !b) {
                    return { error: 'Enter both keys as notes (G, A, Bb …).' };
                }

                shift = (((M.pc(b) - M.pc(a)) % 12) + 12) % 12;
            }

            if (!Number.isInteger(shift)) {
                return { error: 'Shift by a whole number of semitones.' };
            }

            const out = M.transposeChart(x.chart, shift, x.spell === 'flats');
            const up = ((shift % 12) + 12) % 12;

            return { value: out, sub: `${shift >= 0 ? '+' : ''}${shift} semitones`, rows: { shift: `${shift} semitones (${up ? `${up} up or ${12 - up} down` : 'same key'})`, capo: up ? `${up}` : 'No capo needed' }, steps: ['Every chord root and slash bass moves by the same number of semitones; the chord type is kept', 'Lines that are mostly words are treated as lyrics and left unchanged'] };
        },
    },
    delay_reverb: {
        type: 'calc',
        inputs: { bpm: N('Tempo (BPM)', 120, 1) },
        label: 'Quarter-note delay',
        rows: { predelay: 'Reverb pre-delay (1/64 – 1/32 note)', decay: 'Reverb decay that ends on the beat', lfo: 'Quarter-note LFO rate' },
        grids: [['table', 'Delay times by note value']],
        run: (x) => {
            const q = 60000 / x.bpm;
            const values = [['1/1 (whole)', 4], ['1/2', 2], ['1/4', 1], ['1/8', 0.5], ['1/16', 0.25], ['1/32', 0.125], ['1/64', 0.0625]];

            return { value: `${num(q, 5)} ms`, sub: `at ${num(x.bpm)} BPM`, rows: { predelay: `${num(q / 16, 4)} – ${num(q / 8, 4)} ms`, decay: `${num(q * 4, 5)} ms (one bar) or ${num(q * 2, 5)} ms (half bar)`, lfo: `${num(x.bpm / 60, 4)} Hz` }, steps: ['Quarter note = 60,000 ÷ BPM ms', 'Dotted = × 1.5; triplet = × 2/3', 'Pre-delay and decay settings are mixing conventions, not rules'], grids: { table: { columns: ['Straight', 'Dotted', 'Triplet', 'Hz'], rows: values.map(([name, k]) => ({ header: name, cells: [`${num(q * k, 5)} ms`, `${num(q * k * 1.5, 5)} ms`, `${num((q * k * 2) / 3, 5)} ms`, num(1000 / (q * k), 4)] })) } } };
        },
    },
    fret: {
        type: 'calc',
        inputs: { scale: ['Scale length', 'length', 'in', 25.5], frets: N('Number of frets', 22, 1) },
        label: '12th fret (half the scale)',
        rows: { first: 'First fret from the nut', last: 'Last fret from the nut' },
        grids: [['table', 'Fret positions']],
        run: (x) => {
            const L = x.scale;
            const d = (n) => L - L / 2 ** (n / 12);
            const fmt = (m) => `${num(m * 1000, 5)} mm (${num(m / 0.0254, 5)} in)`;

            if (!(Number.isInteger(x.frets) && x.frets >= 1 && x.frets <= 36)) {
                return { error: 'Use 1 to 36 frets.' };
            }

            return { value: fmt(d(12)), sub: `scale length ${fmt(L)}`, rows: { first: fmt(d(1)), last: fmt(d(x.frets)) }, steps: ['Distance from the nut to fret n = L − L ÷ 2^(n/12) (12-tone equal temperament)', 'Measure every fret from the nut, not from the previous fret, so errors do not add up', 'Saddle compensation (a few mm) is added at the bridge, not to the frets'], grids: { table: { columns: ['From the nut', 'From the previous fret'], rows: Array.from({ length: x.frets }, (_, k) => ({ header: `Fret ${k + 1}`, cells: [fmt(d(k + 1)), fmt(d(k + 1) - d(k))] })) } } };
        },
    },
    string_tension: {
        type: 'calc',
        inputs: { scale: ['Scale length', 'length', 'in', 25.5], string: SEL('String', 'data:strings', 'nw046'), uw: N('Unit weight (lb/in, for Other)', 0.00038216, 0), note: NOTE('Tuned to (note and octave)', 'E2'), a4: N('A4 tuning (Hz)', 440, 1) },
        show: { uw: 'string:custom' },
        when: { uw: (x) => x.string === 'custom' },
        data: ['strings'],
        label: 'Tension',
        rows: { newtons: 'In newtons', kg: 'In kilograms-force', freq: 'Frequency' },
        grids: [['set', 'Standard 10–46 set (EXL110) at this scale length']],
        run: (x, ctx) => {
            const table = ctx.c.data.technology?.strings ?? {};
            const uw = x.string === 'custom' ? x.uw : table[x.string]?.uw;
            const n = M.parseNote(x.note);

            if (!n || n.octave === null || !(uw > 0)) {
                return { error: 'Enter a note with its octave (E2, A2, D3 …) and a string.' };
            }

            const Lin = x.scale / 0.0254;
            const f = M.freq(M.midi(n), x.a4);
            const T = (w, hz) => (w * (2 * Lin * hz) ** 2) / 386.4;
            const t = T(uw, f);
            const set = [['pl010', 'E4'], ['pl013', 'B3'], ['pl017', 'G3'], ['nw026', 'D3'], ['nw036', 'A2'], ['nw046', 'E2']];

            return { value: `${num(t, 4)} lb`, sub: `${table[x.string]?.name ?? 'Custom string'} at ${M.noteText(n)}`, rows: { newtons: `${num(t * 4.44822, 4)} N`, kg: `${num(t * 0.453592, 4)} kgf`, freq: `${num(f, 5)} Hz` }, steps: ['T = UW × (2 L f)² ÷ 386.4 (lb, with L in inches) — D’Addario’s formula', 'Unit weights from D’Addario’s String Tension Specifications'], grids: { set: { columns: ['Note', 'Tension'], rows: set.map(([k, note]) => ({ header: table[k]?.name ?? k, cells: [note, `${num(T(table[k]?.uw ?? 0, M.freq(M.midi(M.parseNote(note)), x.a4)), 4)} lb`] })) } } };
        },
    },
    harmonic_series: {
        type: 'calc',
        inputs: { fundamental: NOTE('Fundamental (note or Hz)', 'A2'), count: N('Harmonics', 16, 1), a4: N('A4 tuning (Hz)', 440, 1) },
        label: 'Fundamental',
        rows: { nyquist: 'Highest harmonic shown' },
        grids: [['table', 'Harmonics']],
        run: (x) => {
            const n = M.parseNote(x.fundamental);
            const f1 = n && n.octave !== null ? M.freq(M.midi(n), x.a4) : Number(x.fundamental);

            if (!(f1 > 0) || !(Number.isInteger(x.count) && x.count >= 1 && x.count <= 64)) {
                return { error: 'Enter a note with an octave (A2) or a frequency in Hz, and 1–64 harmonics.' };
            }

            const rows = Array.from({ length: x.count }, (_, k) => {
                const f = f1 * (k + 1);
                const m = 69 + 12 * Math.log2(f / x.a4);
                const near = Math.round(m);

                return { header: `${k + 1}`, cells: [`${num(f, 6)} Hz`, M.midiName(near), `${(m - near) * 100 >= 0 ? '+' : ''}${num((m - near) * 100, 3)}¢`] };
            });

            return { value: `${num(f1, 6)} Hz`, sub: `${x.count} harmonics`, rows: { nyquist: `${num(f1 * x.count, 6)} Hz` }, steps: ['fₙ = n × f₁', 'The 7th, 11th and 13th harmonics fall well away from equal-tempered notes (shown in cents)'], grids: { table: { columns: ['Frequency', 'Nearest note', 'Deviation'], rows } } };
        },
    },
    key_signature: {
        type: 'calc',
        inputs: { by: SEL('From', { key: 'A key', count: 'A number of sharps or flats' }, 'key'), tonic: NOTE('Key (tonic)', 'E'), mode: SEL('Mode', { major: 'Major', minor: 'Minor' }, 'major'), count: N('Sharps (+) or flats (−)', 3) },
        show: { tonic: 'by:key', mode: 'by:key', count: 'by:count' },
        when: { count: (x) => x.by === 'count' },
        label: 'Key signature',
        rows: { accidentals: 'Accidentals in order', relative: 'Relative key', parallel: 'Parallel key', scale: 'Scale' },
        run: (x) => {
            let ks;
            let tonic;
            let mode = x.mode;

            if (x.by === 'count') {
                if (!(Number.isInteger(x.count) && Math.abs(x.count) <= 7)) {
                    return { error: 'Use −7 to 7.' };
                }

                tonic = M.keyFromCount(x.count);
                mode = 'major';
                ks = M.keySignature(tonic, 'major');
            } else {
                tonic = M.parseNote(x.tonic);

                if (!tonic) {
                    return { error: 'Enter a key such as E, F#, Bb.' };
                }

                ks = M.keySignature(tonic, x.mode);
            }

            if (!ks) {
                return { error: 'That key needs double sharps or flats; use its enharmonic equivalent (e.g. D♭ instead of C♯ for major).' };
            }

            const count = ks.count === 0 ? 'No sharps or flats' : `${Math.abs(ks.count)} ${ks.count > 0 ? 'sharp' : 'flat'}${Math.abs(ks.count) > 1 ? 's' : ''}`;

            return { value: count, sub: `${M.noteText(tonic)} ${mode}`, rows: { accidentals: ks.accidentals.join(' ') || '—', relative: mode === 'major' ? `${M.noteText(ks.relativeMinor)} minor` : `${M.noteText(ks.relativeMajor)} major`, parallel: `${M.noteText(tonic)} ${mode === 'major' ? 'minor' : 'major'}`, scale: noteNames(M.scaleNotes(tonic, mode === 'minor' ? 'minor' : 'major')) }, steps: ['Sharps are added in the order F C G D A E B, flats in B E A D G C F (circle of fifths)', 'A minor key shares the signature of the major key a minor third above'] };
        },
    },
    music_duration: {
        type: 'calc',
        inputs: { bars: N('Bars', 64, 0), beatsPerBar: N('Beats per bar (time signature top)', 4, 1), bpm: N('Tempo (BPM)', 120, 1), target: N('Target length (seconds, optional)', 180, 0) },
        optional: ['target'],
        label: 'Duration',
        rows: { beats: 'Beats', bar: 'One bar', barsFor: 'Bars for the target length' },
        run: (x) => {
            const sec = (x.bars * x.beatsPerBar * 60) / x.bpm;
            const m = Math.floor(sec / 60);

            return { value: `${m}:${String(Math.round(sec - m * 60)).padStart(2, '0')}`, sub: `${num(sec, 5)} s`, rows: { beats: num(x.bars * x.beatsPerBar), bar: `${num((x.beatsPerBar * 60) / x.bpm, 4)} s`, barsFor: x.target > 0 ? num((x.target * x.bpm) / (60 * x.beatsPerBar), 4) : 'Enter a target' }, steps: ['Duration = bars × beats per bar × 60 ÷ BPM', 'BPM counts the beat of the time signature (6/8 is often counted in dotted quarters)'] };
        },
    },
    interval: {
        type: 'calc',
        inputs: { a: NOTE('Lower note', 'C4'), b: NOTE('Upper note', 'G4') },
        label: 'Interval',
        rows: { semitones: 'Semitones', ratio: 'Equal-tempered ratio', just: 'Nearest simple ratio (just)', cents: 'Cents', inversion: 'Inversion' },
        run: (x) => {
            const a = M.parseNote(x.a);
            const b = M.parseNote(x.b);

            if (!a || !b) {
                return { error: 'Enter two notes, e.g. C4 and G4 (or C and G).' };
            }

            const iv = M.intervalBetween(a, b);

            if (!iv) {
                return { error: 'The second note must be above the first (add octave numbers), and the interval must be nameable.' };
            }

            const simpleSemis = ((iv.semis % 12) + 12) % 12;
            const just = { 0: '1:1', 1: '16:15', 2: '9:8', 3: '6:5', 4: '5:4', 5: '4:3', 6: '45:32', 7: '3:2', 8: '8:5', 9: '5:3', 10: '9:5', 11: '15:8' }[simpleSemis];
            const invSteps = (7 - (iv.steps % 7)) % 7;
            const inv = M.intervalBetween(b.octave !== null ? { ...b, octave: null } : b, { ...a, octave: null });

            return { value: iv.name, sub: `${M.noteText(a)} → ${M.noteText(b)}`, rows: { semitones: String(iv.semis), ratio: num(2 ** (iv.semis / 12), 6), just, cents: num(iv.semis * 100), inversion: inv ? inv.name : `${invSteps + 1}th` }, steps: ['Interval number counts letter names (C to G = 5 letters = a fifth); quality comes from the semitones', 'An interval and its inversion add up to 9 (a third inverts to a sixth)'] };
        },
    },
    scale: {
        type: 'calc',
        inputs: { root: NOTE('Root', 'A'), type: SEL('Scale', Object.fromEntries(Object.entries(M.SCALES).map(([k, v]) => [k, v[0]])), 'minor') },
        label: 'Notes',
        rows: { steps: 'Step pattern (W = whole, H = half)', chords: 'Triads on each degree', degrees: 'Intervals' },
        plots: [['keys', 'On the keyboard']],
        run: (x) => {
            const r = M.parseNote(x.root);

            if (!r) {
                return { error: 'Enter a root such as A, F#, Bb.' };
            }

            const notes = M.scaleNotes(r, x.type);
            const semis = M.SCALES[x.type][1].map((iv) => M.parseInterval(iv).semis);
            const steps = [...semis.slice(1), 12].map((s, i) => s - semis[i]).map((d) => ({ 1: 'H', 2: 'W', 3: 'W+H', 4: '2W' }[d] ?? d)).join('–');
            let chords = '—';

            if (notes.length === 7) {
                chords = notes.map((n, i) => {
                    const triad = [n, notes[(i + 2) % 7], notes[(i + 4) % 7]];
                    const found = M.findChords(triad).find((c) => M.pc(c.root) === M.pc(n));

                    return found ? M.chordSymbol(found.root, found.type) : '?';
                }).join(' ');
            }

            return { value: noteNames(notes), sub: `${M.noteText(r)} ${M.SCALES[x.type][0]}`, rows: { steps, chords, degrees: M.SCALES[x.type][1].map((iv) => M.parseInterval(iv).short).join(' ') }, steps: ['Each scale is a pattern of intervals from the root', 'Seven-note scales use every letter once, so the spelling is unambiguous'], plots: { keys: keyboard(new Set(notes.map(M.pc)), Object.fromEntries(notes.map((n) => [M.pc(n), M.noteText(n)]))) } };
        },
    },
    transposition: {
        type: 'calc',
        inputs: { notes: NOTE_LIST('Notes', 'C4 D4 E4 F4 G4'), instrument: SEL('Instrument', { bb: 'B♭ clarinet, trumpet, soprano sax (sounds a major 2nd lower)', bbTenor: 'B♭ tenor sax (sounds a major 9th lower)', eb: 'E♭ alto sax (sounds a major 6th lower)', ebBari: 'E♭ baritone sax (sounds an octave and a major 6th lower)', f: 'F horn, cor anglais (sounds a perfect 5th lower)', a: 'A clarinet (sounds a minor 3rd lower)', guitar: 'Guitar, bass (sound an octave lower)', semis: 'By a number of semitones' }, 'bb'), direction: SEL('Convert', { toWritten: 'Concert pitch → written for the instrument', toConcert: 'Written → concert pitch' }, 'toWritten'), semis: N('Semitones (up +)', 2) },
        show: { semis: 'instrument:semis' },
        when: { semis: (x) => x.instrument === 'semis' },
        label: 'Transposed notes',
        rows: { interval: 'Interval used' },
        run: (x) => {
            const r = readNotes(x.notes);

            if (r.problem) {
                return { error: r.problem };
            }

            const ivs = { bb: 'M2', bbTenor: 'M9', eb: 'M6', ebBari: 'M13', f: 'P5', a: 'm3', guitar: 'P8' };

            if (x.instrument === 'semis') {
                const shift = x.direction === 'toConcert' ? -x.semis : x.semis;
                const out = r.notes.map((n) => (n.octave !== null ? M.midiName(M.midi(n) + shift) : M.pcName(M.pc(n) + shift)));

                return { value: out.join(' '), sub: `${shift >= 0 ? '+' : ''}${shift} semitones`, rows: { interval: `${shift} semitones` }, steps: ['Each note moves by the same number of semitones (spelled with sharps)'] };
            }

            const iv = M.parseInterval(ivs[x.instrument]);
            const out = r.notes.map((n) => {
                if (x.direction === 'toWritten') {
                    return M.noteText(M.addInterval(n, iv));
                }

                const down = { steps: -iv.steps, semis: -iv.semis };

                return M.noteText(M.addInterval(n, down));
            });

            return { value: out.join(' '), sub: x.direction === 'toWritten' ? 'Written for the player' : 'Sounding (concert) pitch', rows: { interval: `${iv.name} ${x.direction === 'toWritten' ? 'up' : 'down'}` }, steps: ['A transposing instrument sounds lower (or higher) than written; write the part up by that interval', 'Spelling follows the interval (a major second above F is G, above B is C♯)'] };
        },
    },
    note_frequency: {
        type: 'calc',
        inputs: { by: SEL('From', { note: 'A note', freq: 'A frequency' }, 'note'), note: NOTE('Note with octave', 'A4'), freq: N('Frequency (Hz)', 445, 0), a4: N('A4 tuning (Hz)', 440, 1) },
        show: { note: 'by:note', freq: 'by:freq' },
        when: { freq: (x) => x.by === 'freq' },
        label: 'Result',
        rows: { midi: 'MIDI note number', cents: 'Cents from the nearest note', wavelength: 'Wavelength in air (20 °C)', period: 'Period' },
        run: (x) => {
            let f;
            let m;

            if (x.by === 'note') {
                const n = M.parseNote(x.note);

                if (!n || n.octave === null) {
                    return { error: 'Enter a note with its octave, e.g. A4, C#5, Eb3.' };
                }

                m = M.midi(n);
                f = M.freq(m, x.a4);
            } else {
                f = x.freq;
                m = 69 + 12 * Math.log2(f / x.a4);
            }

            const near = Math.round(m);

            return { value: x.by === 'note' ? `${num(f, 7)} Hz` : M.midiName(near), sub: x.by === 'note' ? `${x.note} with A4 = ${num(x.a4)} Hz` : `${num(f, 6)} Hz`, rows: { midi: x.by === 'note' ? String(m) : `${num(m, 5)} (nearest ${near})`, cents: `${(m - near) * 100 >= 0 ? '+' : ''}${num((m - near) * 100, 4)}¢`, wavelength: `${num(SPEED_OF_SOUND / f, 4)} m`, period: `${num(1000 / f, 5)} ms` }, steps: ['f = A4 × 2^((n − 69) ÷ 12), with n the MIDI number (A4 = 69, middle C = C4 = 60)', 'Cents = 1200 × log₂(f ÷ f_note)'] };
        },
    },
    port_length: {
        type: 'calc',
        inputs: { vb: N('Box volume (litres, net)', 50, 0), fb: N('Tuning frequency Fb (Hz)', 35, 0), shape: SEL('Port', { round: 'Round', slot: 'Slot (rectangular)' }, 'round'), d: N('Port inner diameter (cm)', 7.5, 0), sw: N('Slot width (cm)', 15, 0), sh: N('Slot height (cm)', 4, 0), np: N('Number of ports', 1, 1), k: SEL('Port ends', { 0.732: 'One end flanged (on the baffle)', 0.85: 'Both ends flanged', 0.614: 'Both ends free' }, '0.732') },
        show: { d: 'shape:round', sw: 'shape:slot', sh: 'shape:slot' },
        when: { d: (x) => x.shape === 'round', sw: (x) => x.shape === 'slot', sh: (x) => x.shape === 'slot' },
        label: 'Port length',
        rows: { area: 'Port area (total)', volume: 'Volume taken by the port(s)', equiv: 'Equivalent round diameter' },
        run: (x) => {
            const D = x.shape === 'round' ? x.d : Math.sqrt((4 * x.sw * x.sh) / Math.PI);
            const Lv = (23562.5 * D * D * x.np) / (x.fb * x.fb * x.vb) - Number(x.k) * D;

            if (!(Lv > 0)) {
                return { error: 'The port would be shorter than zero: use a smaller diameter or lower tuning.' };
            }

            const area = (Math.PI * D * D) / 4 * x.np;

            return { value: `${num(Lv, 4)} cm`, sub: `${num(x.np)} × ${x.shape === 'round' ? `${num(x.d)} cm round` : `${num(x.sw)} × ${num(x.sh)} cm slot`}, ${num(x.fb)} Hz`, rows: { area: `${num(area, 4)} cm²`, volume: `${num((area * Lv) / 1000, 4)} L (add it to the gross box volume)`, equiv: `${num(D, 4)} cm` }, steps: ['L = 23562.5 D² N ÷ (Fb² Vb) − k D (D and L in cm, Vb in litres)', 'k is the end correction: about 0.732 with one flanged end', 'Too small a port chuffs at high levels: aim for a large area within the box'] };
        },
    },
    semitone: {
        type: 'calc',
        inputs: { a: NOTE('First note (or Hz)', 'C4'), b: NOTE('Second note (or Hz)', 'F#4') },
        label: 'Semitones',
        rows: { cents: 'Cents', ratio: 'Frequency ratio', octaves: 'Octaves' },
        run: (x) => {
            const val = (t) => {
                const n = M.parseNote(t);

                return n && n.octave !== null ? M.freq(M.midi(n)) : n ? M.freq(M.midi({ ...n, octave: 4 })) : Number(t);
            };
            const [fa, fb] = [val(x.a), val(x.b)];

            if (!(fa > 0 && fb > 0)) {
                return { error: 'Enter two notes (C4, F#4) or two frequencies.' };
            }

            const s = 12 * Math.log2(fb / fa);

            return { value: num(s, 5), sub: `${x.a} → ${x.b}`, rows: { cents: num(s * 100, 5), ratio: num(fb / fa, 6), octaves: num(s / 12, 5) }, steps: ['Semitones = 12 log₂(f₂ ÷ f₁)', 'Notes without an octave are taken in octave 4'] };
        },
    },
    speaker_box: {
        type: 'calc',
        inputs: { fs: N('Driver resonance Fs (Hz)', 32, 0), qts: N('Total Q (Qts)', 0.38, 0), vas: N('Equivalent volume Vas (litres)', 85, 0), type: SEL('Box', { sealed: 'Sealed', ported: 'Ported (vented)' }, 'ported'), qtc: N('Target Qtc (sealed; 0.707 = flattest)', 0.707, 0) },
        show: { qtc: 'type:sealed' },
        label: 'Box volume',
        rows: { tuning: 'Tuning / resonance', f3: '−3 dB frequency', ebp: 'Efficiency bandwidth product (Fs ÷ Qes ≈ Fs ÷ Qts)', advice: 'Suits' },
        run: (x) => {
            const ebp = x.fs / x.qts;
            const advice = ebp > 90 ? 'Ported box' : ebp < 50 ? 'Sealed box' : 'Either';

            if (x.type === 'sealed') {
                if (!(x.qtc > x.qts)) {
                    return { error: 'Qtc must be above the driver’s Qts.' };
                }

                const vb = x.vas / ((x.qtc / x.qts) ** 2 - 1);
                const fc = (x.fs * x.qtc) / x.qts;
                const a = 1 / (x.qtc * x.qtc) - 2;
                const f3 = fc * Math.sqrt((a + Math.sqrt(a * a + 4)) / 2);

                return { value: `${num(vb, 4)} L`, sub: `Sealed, Qtc ${num(x.qtc)}`, rows: { tuning: `Fc = ${num(fc, 4)} Hz`, f3: `${num(f3, 4)} Hz`, ebp: num(ebp, 4), advice }, steps: ['Vb = Vas ÷ ((Qtc ÷ Qts)² − 1); Fc = Fs × Qtc ÷ Qts', 'F3 from the second-order high-pass response', 'Net internal volume: add the driver and bracing volume'] };
            }

            const vb = 15 * x.qts ** 2.87 * x.vas;
            const fb = 0.42 * x.fs * x.qts ** -0.9;
            const f3 = 0.26 * x.fs * x.qts ** -1.4;

            return { value: `${num(vb, 4)} L`, sub: 'Ported (Keele approximation)', rows: { tuning: `Fb = ${num(fb, 4)} Hz`, f3: `${num(f3, 4)} Hz`, ebp: num(ebp, 4), advice }, steps: ['D. B. Keele’s approximations: Vb = 15 Qts^2.87 Vas, Fb = 0.42 Fs Qts^−0.9, F3 = 0.26 Fs Qts^−1.4', 'A starting point; box-modelling software refines it', 'Then size the port with the Port Length Calculator'] };
        },
    },
    vocal_range: {
        type: 'calc',
        inputs: { low: NOTE('Lowest note you sing comfortably', 'A2'), high: NOTE('Highest note', 'A4') },
        label: 'Likely voice type',
        rows: { span: 'Range', middle: 'Middle of your range', types: 'Types that cover your range' },
        run: (x) => {
            const a = M.parseNote(x.low);
            const b = M.parseNote(x.high);

            if (!a || !b || a.octave === null || b.octave === null || M.midi(b) <= M.midi(a)) {
                return { error: 'Enter two notes with octaves, lowest first (e.g. A2 and A4).' };
            }

            const lo = M.midi(a);
            const hi = M.midi(b);
            const scored = M.VOICES.map(([name, vlo, vhi]) => [name, Math.max(0, Math.min(hi, vhi) - Math.max(lo, vlo)) - Math.abs((lo + hi) / 2 - (vlo + vhi) / 2) / 4, vlo, vhi]).sort((p, q) => q[1] - p[1]);

            return { value: scored[0][0], sub: `${M.noteText(a)} to ${M.noteText(b)}`, rows: { span: `${hi - lo} semitones (${num((hi - lo) / 12, 3)} octaves)`, middle: M.midiName(Math.round((lo + hi) / 2)), types: scored.filter(([, s]) => s > 6).map(([n, , vlo, vhi]) => `${n} (${M.midiName(vlo)}–${M.midiName(vhi)})`).join('; ') || scored[0][0] }, steps: ['Compared with typical choral ranges: bass E2–E4, baritone A2–A4, tenor C3–C5, alto F3–F5, mezzo A3–A5, soprano C4–C6', 'Voice type also depends on timbre and where your voice is most comfortable; a teacher can tell you more'] };
        },
    },
    cents: {
        type: 'calc',
        inputs: { by: SEL('From', { freqs: 'Two frequencies', ratio: 'A ratio', cents: 'Cents' }, 'freqs'), f1: N('First frequency (Hz)', 440, 0), f2: N('Second frequency (Hz)', 445, 0), ratio: LINE('Ratio', '3:2'), cents: N('Cents', 50) },
        show: { f1: 'by:freqs', f2: 'by:freqs', ratio: 'by:ratio', cents: 'by:cents' },
        when: { f1: (x) => x.by === 'freqs', f2: (x) => x.by === 'freqs', cents: (x) => x.by === 'cents' },
        label: 'Result',
        rows: { ratio: 'Frequency ratio', semitones: 'Semitones', nearest: 'Nearest equal-tempered interval' },
        run: (x) => {
            let r;

            if (x.by === 'freqs') {
                r = x.f2 / x.f1;
            } else if (x.by === 'ratio') {
                const m = String(x.ratio).match(/^\s*(\d+(?:\.\d+)?)\s*[:/]\s*(\d+(?:\.\d+)?)\s*$/);
                r = m ? Number(m[1]) / Number(m[2]) : Number(x.ratio);
            } else {
                r = 2 ** (x.cents / 1200);
            }

            if (!(r > 0)) {
                return { error: 'Enter positive frequencies or a ratio such as 3:2.' };
            }

            const c = 1200 * Math.log2(r);
            const near = Math.round(c / 100);

            return { value: x.by === 'cents' ? `ratio ${num(r, 7)}` : `${num(c, 5)} cents`, sub: x.by === 'freqs' ? `${num(x.f1)} → ${num(x.f2)} Hz` : '', rows: { ratio: num(r, 7), semitones: num(c / 100, 5), nearest: `${near} semitones ${c - near * 100 >= 0 ? '+' : ''}${num(c - near * 100, 4)}¢` }, steps: ['Cents = 1200 log₂(ratio); 100 cents = 1 equal-tempered semitone', 'A just fifth (3:2) is 701.96 cents, 1.96 cents wider than the tempered fifth'] };
        },
    },
    speaker_wiring: {
        type: 'calc',
        inputs: { count: N('Number of speakers', 4, 1), z: N('Impedance of each (Ω)', 8, 0), wiring: SEL('Wiring', { series: 'All in series', parallel: 'All in parallel', sp: 'Series-parallel (pairs in series, pairs in parallel)' }, 'sp'), amp: N('Lowest load the amplifier allows (Ω)', 4, 0), power: N('Amplifier power into that load (W)', 400, 0) },
        optional: ['amp', 'power'],
        label: 'Total impedance',
        rows: { safe: 'Safe for the amplifier?', share: 'Power per speaker (identical speakers)' },
        run: (x) => {
            const n = x.count;
            let z;

            if (x.wiring === 'series') {
                z = n * x.z;
            } else if (x.wiring === 'parallel') {
                z = x.z / n;
            } else {
                if (n % 2) {
                    return { error: 'Series-parallel here needs an even number of speakers (pairs).' };
                }

                z = (2 * x.z) / (n / 2);
            }

            const p = x.power > 0 && x.amp > 0 ? (x.power * x.amp) / z : NaN;

            return { value: `${num(z, 4)} Ω`, sub: `${n} × ${num(x.z)} Ω ${x.wiring === 'sp' ? 'series-parallel' : x.wiring}`, rows: { safe: x.amp > 0 ? (z >= x.amp ? 'Yes' : `No: below the ${num(x.amp)} Ω minimum`) : 'Enter the amplifier’s minimum', share: Number.isFinite(p) ? `about ${num(p / n, 4)} W (amplifier gives ≈ ${num(p, 4)} W into ${num(z, 4)} Ω, if it is a constant-voltage design)` : '—' }, steps: ['Series: impedances add; parallel: 1/Z = Σ 1/Zᵢ', 'Nominal impedance; the real load varies with frequency'] };
        },
    },
    room_modes: {
        type: 'calc',
        inputs: { l: ['Length', 'length', 'm', 5.5], w: ['Width', 'length', 'm', 4.2], h: ['Height', 'length', 'm', 2.7], max: N('Up to (Hz)', 200, 1) },
        label: 'Lowest axial mode',
        rows: { axial: 'First axial modes (L, W, H)', count: 'Modes below the limit', schroeder: 'Above this, modes blend (approximate Schroeder frequency for RT60 0.4 s)', ratio: 'Room ratio' },
        grids: [['table', 'Modes']],
        run: (x) => {
            const dims = [x.l, x.w, x.h];

            if (!dims.every((d) => d > 0)) {
                return { error: 'Enter all three dimensions.' };
            }

            const modes = [];

            for (let p = 0; p <= 20; p += 1) {
                for (let q = 0; q <= 20; q += 1) {
                    for (let r = 0; r <= 20; r += 1) {
                        if (p + q + r === 0) {
                            continue;
                        }

                        const f = (SPEED_OF_SOUND / 2) * Math.sqrt((p / x.l) ** 2 + (q / x.w) ** 2 + (r / x.h) ** 2);

                        if (f <= x.max) {
                            const zeros = [p, q, r].filter((v) => v === 0).length;
                            modes.push({ f, p, q, r, kind: zeros === 2 ? 'Axial' : zeros === 1 ? 'Tangential' : 'Oblique' });
                        }
                    }
                }
            }

            modes.sort((a, b) => a.f - b.f);
            const vol = x.l * x.w * x.h;
            const [s1, s2, s3] = [...dims].sort((a, b) => a - b);

            return { value: `${num(modes[0]?.f ?? NaN, 4)} Hz`, sub: `${num(x.l)} × ${num(x.w)} × ${num(x.h)} m`, rows: { axial: dims.map((d) => `${num(SPEED_OF_SOUND / (2 * d), 4)} Hz`).join(', '), count: num(modes.length), schroeder: `${num(2000 * Math.sqrt(0.4 / vol), 4)} Hz`, ratio: `1 : ${num(s2 / s1, 3)} : ${num(s3 / s1, 3)}` }, steps: ['f = (c/2) √((p/L)² + (q/W)² + (r/H)²), c = 343 m/s', 'Axial modes (one dimension) are the strongest; evenly spread modes avoid boomy notes', 'Rectangular rooms with rigid walls; real rooms are less regular'], grids: { table: { columns: ['Type', 'p, q, r'], rows: modes.slice(0, 150).map((m) => ({ header: `${num(m.f, 4)} Hz`, cells: [m.kind, `${m.p}, ${m.q}, ${m.r}`] })) } } };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
