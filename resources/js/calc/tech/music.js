/**
 * Music theory in 12-tone equal temperament with correct letter spelling: notes, intervals, chords, scales,
 * key signatures, transposition and note frequencies (A4 = 440 Hz unless changed).
 */

export const LETTERS = ['C', 'D', 'E', 'F', 'G', 'A', 'B'];
const LETTER_PC = [0, 2, 4, 5, 7, 9, 11];
const ACC_TEXT = { '-2': '𝄫', '-1': '♭', 0: '', 1: '♯', 2: '𝄪' };

/** Parses "C", "F#", "Bb", "E♭", "Gx", "Abb", optionally with an octave ("A4", "C#5"). */
export function parseNote(text) {
    const m = String(text ?? '').trim().replace(/♯/g, '#').replace(/♭/g, 'b').replace(/𝄪/g, 'x').replace(/𝄫/g, 'bb')
        .match(/^([A-Ga-g])(##|#|x|bb|b)?(-?\d+)?$/);

    if (!m) {
        return null;
    }

    const acc = { '##': 2, x: 2, '#': 1, bb: -2, b: -1 }[m[2]] ?? 0;

    return { L: LETTERS.indexOf(m[1].toUpperCase()), acc, octave: m[3] === undefined ? null : Number(m[3]) };
}

export const pc = (n) => (((LETTER_PC[n.L] + n.acc) % 12) + 12) % 12;
export const noteText = (n, ascii = false) => `${LETTERS[n.L]}${ascii ? { '-2': 'bb', '-1': 'b', 0: '', 1: '#', 2: 'x' }[n.acc] : ACC_TEXT[n.acc]}${n.octave === null || n.octave === undefined ? '' : n.octave}`;

/** MIDI number of a note with an octave (C4 = 60). B♯3 counts as C4. */
export const midi = (n) => 12 * (n.octave + 1) + LETTER_PC[n.L] + n.acc;
export const freq = (m, a4 = 440) => a4 * 2 ** ((m - 69) / 12);

const SHARP_NAMES = ['C', 'C♯', 'D', 'D♯', 'E', 'F', 'F♯', 'G', 'G♯', 'A', 'A♯', 'B'];
const FLAT_NAMES = ['C', 'D♭', 'D', 'E♭', 'E', 'F', 'G♭', 'G', 'A♭', 'A', 'B♭', 'B'];
export const pcName = (p, flats = false) => (flats ? FLAT_NAMES : SHARP_NAMES)[((p % 12) + 12) % 12];
export const midiName = (m, flats = false) => `${pcName(m, flats)}${Math.floor(m / 12) - 1}`;

/** Interval names: quality + number. Semitones for the perfect/major version of each simple number. */
const MAJOR_SEMIS = [0, 2, 4, 5, 7, 9, 11];
const PERFECT = [true, false, false, true, true, false, false];
const NUM_NAMES = ['unison', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'octave', 'ninth', 'tenth', 'eleventh', 'twelfth', 'thirteenth', 'fourteenth', 'double octave'];
const QUAL_NAMES = { P: 'perfect', M: 'major', m: 'minor', A: 'augmented', d: 'diminished', AA: 'doubly augmented', dd: 'doubly diminished' };

/** Parses "M3", "P5", "m7", "A4", "d5", "M9" into { steps, semis }. */
export function parseInterval(text) {
    const m = String(text ?? '').trim().match(/^(P|M|m|AA|A|dd|d)(\d{1,2})$/);

    if (!m) {
        return null;
    }

    const num = Number(m[2]);
    const steps = num - 1;
    const simple = steps % 7;
    const perfect = PERFECT[simple];
    const base = MAJOR_SEMIS[simple] + 12 * Math.floor(steps / 7);
    const q = m[1];
    const offset = perfect ? { P: 0, A: 1, AA: 2, d: -1, dd: -2 }[q] : { M: 0, m: -1, A: 1, AA: 2, d: -2, dd: -3 }[q];

    if (offset === undefined || num < 1) {
        return null;
    }

    return { steps, semis: base + offset, name: `${QUAL_NAMES[q]} ${NUM_NAMES[steps] ?? `${num}th`}`, short: `${q}${num}` };
}

/** Names the interval from n1 up to n2 (both spelled; octave numbers optional). */
export function intervalBetween(n1, n2) {
    let steps = n2.L - n1.L;
    let semis = pc(n2) - pc(n1);

    if (n1.octave !== null && n2.octave !== null && n1.octave !== undefined && n2.octave !== undefined) {
        steps += 7 * (n2.octave - n1.octave);
        semis = midi(n2) - midi(n1);
    } else {
        steps = ((steps % 7) + 7) % 7;
        semis = ((semis % 12) + 12) % 12;

        if (steps === 0 && semis > 6) {
            semis -= 12;
        }

        if (steps === 6 && semis < 3) {
            semis += 12;
        }
    }

    if (steps < 0) {
        return null;
    }

    const simple = steps % 7;
    const diff = semis - (MAJOR_SEMIS[simple] + 12 * Math.floor(steps / 7));
    const q = PERFECT[simple] ? { 0: 'P', 1: 'A', 2: 'AA', '-1': 'd', '-2': 'dd' }[diff] : { 0: 'M', '-1': 'm', 1: 'A', 2: 'AA', '-2': 'd', '-3': 'dd' }[diff];

    if (!q) {
        return null;
    }

    return { steps, semis, short: `${q}${steps + 1}`, name: `${QUAL_NAMES[q]} ${NUM_NAMES[steps] ?? `${steps + 1}th`}` };
}

/** Adds an interval to a spelled note (keeps the octave when the note has one). */
export function addInterval(n, iv) {
    const L = n.L + iv.steps;
    const newL = ((L % 7) + 7) % 7;
    const octaveShift = Math.floor(L / 7);
    const acc = LETTER_PC[n.L] + n.acc + iv.semis - (LETTER_PC[newL] + 12 * octaveShift);
    const octave = n.octave === null || n.octave === undefined ? null : n.octave + octaveShift;

    return { L: newL, acc, octave };
}

/** Chord formulas (intervals above the root) and their symbol suffixes. */
export const CHORDS = {
    maj: ['Major', '', ['P1', 'M3', 'P5']],
    min: ['Minor', 'm', ['P1', 'm3', 'P5']],
    dim: ['Diminished', 'dim', ['P1', 'm3', 'd5']],
    aug: ['Augmented', 'aug', ['P1', 'M3', 'A5']],
    sus2: ['Suspended 2nd', 'sus2', ['P1', 'M2', 'P5']],
    sus4: ['Suspended 4th', 'sus4', ['P1', 'P4', 'P5']],
    5: ['Power chord', '5', ['P1', 'P5']],
    6: ['Major 6th', '6', ['P1', 'M3', 'P5', 'M6']],
    m6: ['Minor 6th', 'm6', ['P1', 'm3', 'P5', 'M6']],
    7: ['Dominant 7th', '7', ['P1', 'M3', 'P5', 'm7']],
    maj7: ['Major 7th', 'maj7', ['P1', 'M3', 'P5', 'M7']],
    m7: ['Minor 7th', 'm7', ['P1', 'm3', 'P5', 'm7']],
    mmaj7: ['Minor-major 7th', 'm(maj7)', ['P1', 'm3', 'P5', 'M7']],
    m7b5: ['Half-diminished 7th', 'm7♭5', ['P1', 'm3', 'd5', 'm7']],
    dim7: ['Diminished 7th', 'dim7', ['P1', 'm3', 'd5', 'd7']],
    aug7: ['Augmented 7th', '7♯5', ['P1', 'M3', 'A5', 'm7']],
    '7sus4': ['Dominant 7th suspended 4th', '7sus4', ['P1', 'P4', 'P5', 'm7']],
    add9: ['Added 9th', 'add9', ['P1', 'M3', 'P5', 'M9']],
    madd9: ['Minor added 9th', 'm(add9)', ['P1', 'm3', 'P5', 'M9']],
    9: ['Dominant 9th', '9', ['P1', 'M3', 'P5', 'm7', 'M9']],
    maj9: ['Major 9th', 'maj9', ['P1', 'M3', 'P5', 'M7', 'M9']],
    m9: ['Minor 9th', 'm9', ['P1', 'm3', 'P5', 'm7', 'M9']],
    11: ['Dominant 11th', '11', ['P1', 'M3', 'P5', 'm7', 'M9', 'P11']],
    m11: ['Minor 11th', 'm11', ['P1', 'm3', 'P5', 'm7', 'M9', 'P11']],
    13: ['Dominant 13th', '13', ['P1', 'M3', 'P5', 'm7', 'M9', 'M13']],
    maj13: ['Major 13th', 'maj13', ['P1', 'M3', 'P5', 'M7', 'M9', 'M13']],
};

/** Chord-symbol suffixes accepted when reading a chord (longest first). */
const SUFFIX = [['m(maj7)', 'mmaj7'], ['mmaj7', 'mmaj7'], ['maj13', 'maj13'], ['maj9', 'maj9'], ['maj7', 'maj7'], ['M7', 'maj7'], ['Δ7', 'maj7'], ['Δ', 'maj7'], ['m7b5', 'm7b5'], ['m7♭5', 'm7b5'], ['ø7', 'm7b5'], ['ø', 'm7b5'], ['dim7', 'dim7'], ['°7', 'dim7'], ['7#5', 'aug7'], ['7♯5', 'aug7'], ['aug7', 'aug7'], ['+7', 'aug7'], ['7sus4', '7sus4'], ['m(add9)', 'madd9'], ['madd9', 'madd9'], ['add9', 'add9'], ['m11', 'm11'], ['m9', 'm9'], ['m7', 'm7'], ['m6', 'm6'], ['min', 'min'], ['sus2', 'sus2'], ['sus4', 'sus4'], ['sus', 'sus4'], ['dim', 'dim'], ['°', 'dim'], ['aug', 'aug'], ['+', 'aug'], ['13', '13'], ['11', '11'], ['9', '9'], ['7', '7'], ['6', '6'], ['5', '5'], ['maj', 'maj'], ['m', 'min'], ['-', 'min'], ['', 'maj']];

/** Reads a chord symbol such as "Cmaj7", "F#m7b5", "Bb/D". Returns { root, type, bass } or null. */
export function parseChord(text) {
    const s = String(text ?? '').trim().replace(/♯/g, '#');
    const m = s.match(/^([A-G](?:##|#|bb|b|♭)?)(.*?)(?:\/([A-G](?:#|b|♭)?))?$/);

    if (!m) {
        return null;
    }

    const root = parseNote(m[1].replace('♭', 'b'));
    const hit = SUFFIX.find(([suffix]) => suffix === m[2]);

    if (!root || !hit) {
        return null;
    }

    return { root, type: hit[1], bass: m[3] ? parseNote(m[3].replace('♭', 'b')) : null };
}

export function chordNotes(root, type) {
    return CHORDS[type][2].map((iv) => addInterval({ ...root, octave: null }, parseInterval(iv)));
}

export const chordSymbol = (root, type, bass) => `${noteText(root)}${CHORDS[type][1]}${bass ? `/${noteText(bass)}` : ''}`;

/** Names every chord whose notes are exactly the given pitch-class set (any root among them). */
export function findChords(notes) {
    const set = new Set(notes.map(pc));
    const out = [];

    for (const n of notes) {
        for (const [type, [name, , formula]] of Object.entries(CHORDS)) {
            const pcs = new Set(formula.map((iv) => (pc(n) + parseInterval(iv).semis) % 12));

            if (pcs.size === set.size && [...pcs].every((p) => set.has(p)) && !out.some((o) => pc(o.root) === pc(n) && o.type === type)) {
                out.push({ root: { ...n, octave: null }, type, name });
            }
        }
    }

    return out;
}

/** Scales and modes as interval lists. */
export const SCALES = {
    major: ['Major (Ionian)', ['P1', 'M2', 'M3', 'P4', 'P5', 'M6', 'M7']],
    minor: ['Natural minor (Aeolian)', ['P1', 'M2', 'm3', 'P4', 'P5', 'm6', 'm7']],
    harmonic: ['Harmonic minor', ['P1', 'M2', 'm3', 'P4', 'P5', 'm6', 'M7']],
    melodic: ['Melodic minor (ascending)', ['P1', 'M2', 'm3', 'P4', 'P5', 'M6', 'M7']],
    dorian: ['Dorian', ['P1', 'M2', 'm3', 'P4', 'P5', 'M6', 'm7']],
    phrygian: ['Phrygian', ['P1', 'm2', 'm3', 'P4', 'P5', 'm6', 'm7']],
    lydian: ['Lydian', ['P1', 'M2', 'M3', 'A4', 'P5', 'M6', 'M7']],
    mixolydian: ['Mixolydian', ['P1', 'M2', 'M3', 'P4', 'P5', 'M6', 'm7']],
    locrian: ['Locrian', ['P1', 'm2', 'm3', 'P4', 'd5', 'm6', 'm7']],
    pent_major: ['Major pentatonic', ['P1', 'M2', 'M3', 'P5', 'M6']],
    pent_minor: ['Minor pentatonic', ['P1', 'm3', 'P4', 'P5', 'm7']],
    blues: ['Blues', ['P1', 'm3', 'P4', 'd5', 'P5', 'm7']],
    whole: ['Whole tone', ['P1', 'M2', 'M3', 'A4', 'A5', 'A6']],
};

export const scaleNotes = (root, type) => SCALES[type][1].map((iv) => addInterval({ ...root, octave: null }, parseInterval(iv)));

/** Major keys by number of sharps (+) or flats (−); relative minors are a minor third below. */
const MAJOR_BY_FIFTHS = { '-7': 'Cb', '-6': 'Gb', '-5': 'Db', '-4': 'Ab', '-3': 'Eb', '-2': 'Bb', '-1': 'F', 0: 'C', 1: 'G', 2: 'D', 3: 'A', 4: 'E', 5: 'B', 6: 'F#', 7: 'C#' };
const SHARP_ORDER = ['F', 'C', 'G', 'D', 'A', 'E', 'B'];
const FLAT_ORDER = ['B', 'E', 'A', 'D', 'G', 'C', 'F'];

/** Key signature of a major or minor key: number of sharps (+) or flats (−) and the accidentals in order. */
export function keySignature(tonic, mode = 'major') {
    const major = mode === 'minor' ? addInterval({ ...tonic, octave: null }, parseInterval('m3')) : tonic;
    const name = noteText(major, true);
    const entry = Object.entries(MAJOR_BY_FIFTHS).find(([, k]) => k === name);

    if (!entry) {
        return null;
    }

    const count = Number(entry[0]);
    const accidentals = count > 0 ? SHARP_ORDER.slice(0, count).map((l) => `${l}♯`) : FLAT_ORDER.slice(0, -count).map((l) => `${l}♭`);

    return { count, accidentals, relativeMajor: parseNote(name), relativeMinor: addInterval(parseNote(name), parseInterval('M6')) };
}

export const keyFromCount = (count) => parseNote(MAJOR_BY_FIFTHS[count]);

/** Transposes a spelled note by semitones, spelled with sharps or flats. */
export function transposePc(p, semitones, flats) {
    return parseNote(pcName(p + semitones, flats).replace('♯', '#').replace('♭', 'b'));
}

/** Transposes every chord symbol in a chord chart (lines of text), leaving lyrics and other words alone. */
export function transposeChart(text, semitones, flats) {
    const isChord = (token) => {
        const c = token.replace(/[|()[\]]/g, '');

        return !c || /^[A-G](?:#|b|♯|♭)?/.test(c) && parseChord(c.replace('♯', '#')) !== null;
    };

    return String(text ?? '').split('\n').map((line) => (line.trim().split(/\s+/).filter((t) => isChord(t)).length * 2 < line.trim().split(/\s+/).length ? line : line.replace(/(^|[\s|(\[])([A-G](?:#|b|♯|♭)?)([^\s/|)\]]*)(?:\/([A-G](?:#|b|♯|♭)?))?(?=$|[\s|)\]])/g, (whole, pre, root, suffix, bass) => {
        const r = parseNote(root.replace('♯', '#').replace('♭', 'b'));

        if (!r || !SUFFIX.some(([s]) => s === suffix.replace('♯', '#'))) {
            return whole;
        }

        const nr = noteText(transposePc(pc(r), semitones, flats));
        const nb = bass ? `/${noteText(transposePc(pc(parseNote(bass.replace('♯', '#').replace('♭', 'b'))), semitones, flats))}` : '';

        return `${pre}${nr}${suffix}${nb}`;
    }))).join('\n');
}

/** Roman-numeral chords in a key: I ii iii IV V vi vii° (and 7th chords with a 7 suffix). */
export function romanChord(numeral, tonic, mode = 'major') {
    const m = String(numeral).trim().match(/^(b|♭|#|♯)?(VII|VI|V|IV|III|II|I|vii|vi|v|iv|iii|ii|i)(°|ø|\+)?(7|maj7)?$/);

    if (!m) {
        return null;
    }

    const degree = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII'].indexOf(m[2].toUpperCase());
    // Accidentals (♭VII, ♯IV) are relative to the major scale of the tonic, by convention.
    const scale = scaleNotes(tonic, mode === 'minor' && !m[1] ? 'minor' : 'major');
    let root = scale[degree];

    if (m[1]) {
        root = { ...root, acc: root.acc + (/b|♭/.test(m[1]) ? -1 : 1) };
    }

    const upper = m[2] === m[2].toUpperCase();
    const seventh = m[4];
    let type;

    if (m[3] === '°') {
        type = seventh ? 'dim7' : 'dim';
    } else if (m[3] === 'ø') {
        type = 'm7b5';
    } else if (m[3] === '+') {
        type = seventh ? 'aug7' : 'aug';
    } else if (seventh === 'maj7') {
        type = upper ? 'maj7' : 'mmaj7';
    } else if (seventh) {
        // Diatonic sevenths: major keys have Imaj7 and IVmaj7; natural minor has IIImaj7 and VImaj7; other major triads take a dominant 7th.
        const majorSeventh = mode === 'minor' ? degree === 2 || degree === 5 : degree === 0 || degree === 3;
        type = upper ? (majorSeventh && !m[1] ? 'maj7' : '7') : 'm7';
    } else {
        type = upper ? 'maj' : 'min';
    }

    return { root, type };
}

/** Voice types with typical choral/operatic ranges (MIDI numbers); ranges overlap and vary by singer. */
export const VOICES = [['Bass', 40, 64], ['Baritone', 45, 69], ['Tenor', 48, 72], ['Countertenor', 52, 76], ['Contralto (alto)', 53, 77], ['Mezzo-soprano', 57, 81], ['Soprano', 60, 84]];
