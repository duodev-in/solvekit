import { defineTools } from '../engines/formula.js';
import { handlersFor } from '../physics/core.js';
import { N, SEL, TXT, LINE, num } from '../statistics/common.js';
import * as B from '../tech/bits.js';

/**
 * Text, codes and encodings: text ↔ binary/hex/ASCII, Base64, Morse, T9, ciphers, Unicode text styles, parity and
 * Hamming codes, hashes, chmod, colours and UUIDs. Nothing typed leaves the browser.
 */

const TEXT = (value, label = 'Text') => TXT(label, value);
const charGrid = (text, cols) => ({ columns: cols.map((c) => c[0]), rows: [...String(text)].slice(0, 200).map((ch) => ({ header: ch === ' ' ? '␠' : ch === '\n' ? '↵' : ch, cells: cols.map((c) => c[1](ch)) })) });
const cp = (ch) => `U+${ch.codePointAt(0).toString(16).toUpperCase().padStart(4, '0')}`;
const bytesOf = (ch) => B.utf8(ch);

/** A text-to-text tool: run(x) returns { text, sub?, rows?, steps?, grids? }. */
function textTool({ inputs, label = 'Result', rows = {}, grids, run, steps = [] }) {
    return {
        type: 'calc',
        inputs,
        label,
        rows,
        ...(grids ? { grids } : {}),
        run: (x) => {
            const out = run(x);

            if (out.error || out.empty) {
                return out;
            }

            return { value: out.text === '' ? '(empty)' : out.text, sub: out.sub ?? '', rows: out.rows ?? {}, steps: [...(out.steps ?? []), ...steps], ...(out.grids ? { grids: out.grids } : {}) };
        },
    };
}

const missingNote = (missing) => (missing.length ? `No Unicode form for: ${missing.slice(0, 20).join(' ')} (kept as typed)` : 'Every character converted');

export const TOOLS = {
    ascii: textTool({
        inputs: { mode: SEL('Convert', { toCodes: 'Text → codes', toText: 'Codes → text' }, 'toCodes'), text: TEXT('Hello!'), codes: TXT('Codes (decimal, or 0x hex / 0b binary)', '72 101 108 108 111 33'), base: SEL('Show codes in', { 10: 'Decimal', 16: 'Hexadecimal', 2: 'Binary', 8: 'Octal' }, '10') },
        show: { text: 'mode:toCodes', codes: 'mode:toText', base: 'mode:toCodes' },
        label: 'Converted',
        rows: { count: 'Characters', ascii: 'Pure ASCII?' },
        grids: [['table', 'Character table']],
        steps: ['ASCII covers codes 0–127; characters beyond it are shown with their Unicode code point (UTF-8 uses several bytes for them)'],
        run: (x) => {
            if (x.mode === 'toText') {
                const tokens = String(x.codes ?? '').trim().split(/[\s,;]+/).filter(Boolean);
                const codes = tokens.map((t) => (/^0x[0-9a-f]+$/i.test(t) ? parseInt(t, 16) : /^0b[01]+$/i.test(t) ? parseInt(t.slice(2), 2) : /^\d+$/.test(t) ? Number(t) : NaN));
                const bad = tokens.filter((_, i) => !(codes[i] >= 0 && codes[i] <= 0x10ffff));

                if (bad.length) {
                    return { error: `Not valid codes: ${bad.slice(0, 5).join(', ')}.` };
                }

                const text = String.fromCodePoint(...codes);

                return { text, rows: { count: num(codes.length), ascii: codes.every((c) => c < 128) ? 'Yes' : 'No (some codes are above 127)' }, grids: { table: charGrid(text, [['Decimal', (c) => String(c.codePointAt(0))], ['Hex', (c) => c.codePointAt(0).toString(16).toUpperCase()]]) } };
            }

            const chars = [...String(x.text ?? '')];

            if (!chars.length) {
                return { empty: 'Type some text.' };
            }

            const base = Number(x.base);
            const text = chars.map((c) => c.codePointAt(0).toString(base).toUpperCase().padStart(base === 2 ? 8 : 1, '0')).join(' ');

            return { text, rows: { count: num(chars.length), ascii: chars.every((c) => c.codePointAt(0) < 128) ? 'Yes' : 'No: some characters are outside ASCII' }, grids: { table: charGrid(x.text, [['Decimal', (c) => String(c.codePointAt(0))], ['Hex', (c) => c.codePointAt(0).toString(16).toUpperCase()], ['Binary', (c) => c.codePointAt(0).toString(2).padStart(8, '0')], ['Code point', cp]]) } };
        },
    }),
    binary_text: textTool({
        inputs: { bits: TXT('Binary (groups of 8 bits)', '01001000 01101001 00100001') },
        label: 'Text',
        rows: { bytes: 'Bytes', encoding: 'Encoding' },
        steps: ['Each group of 8 bits is one byte; the bytes are read as UTF-8 (identical to ASCII for codes below 128)'],
        run: (x) => {
            const p = B.parseBytes(x.bits, 2);

            if (p.problem) {
                return { error: p.problem };
            }

            if (!p.bytes.length) {
                return { empty: 'Enter binary bytes.' };
            }

            const text = B.fromUtf8(p.bytes);

            return text === null ? { error: 'These bytes are not valid UTF-8 text.' } : { text, rows: { bytes: num(p.bytes.length), encoding: 'UTF-8' } };
        },
    }),
    text_binary: textTool({
        inputs: { text: TEXT('Hi!'), sep: SEL('Separate bytes with', { space: 'Spaces', none: 'Nothing' }, 'space') },
        label: 'Binary',
        rows: { bytes: 'Bytes (UTF-8)', bits: 'Bits' },
        grids: [['table', 'Per character']],
        run: (x) => {
            const bytes = B.utf8(x.text);

            if (!bytes.length) {
                return { empty: 'Type some text.' };
            }

            const text = B.byteText(bytes, 2);

            return { text: x.sep === 'none' ? text.replace(/ /g, '') : text, rows: { bytes: num(bytes.length), bits: num(bytes.length * 8) }, steps: ['Text → UTF-8 bytes → 8 binary digits per byte'], grids: { table: charGrid(x.text, [['UTF-8 bytes', (c) => B.byteText(bytesOf(c), 2)]]) } };
        },
    }),
    hex_text: textTool({
        inputs: { hex: TXT('Hex bytes', '48 65 6C 6C 6F 20 E2 9C 93') },
        label: 'Text',
        rows: { bytes: 'Bytes' },
        steps: ['Two hex digits per byte, read as UTF-8'],
        run: (x) => {
            const p = B.parseBytes(x.hex, 16);

            if (p.problem) {
                return { error: p.problem };
            }

            if (!p.bytes.length) {
                return { empty: 'Enter hex bytes.' };
            }

            const text = B.fromUtf8(p.bytes);

            return text === null ? { error: 'These bytes are not valid UTF-8 text.' } : { text, rows: { bytes: num(p.bytes.length) } };
        },
    }),
    text_hex: textTool({
        inputs: { text: TEXT('Hello ✓'), style: SEL('Format', { space: 'Spaced (48 65 6C)', plain: 'Plain (48656C)', prefix: '0x prefix (0x48, 0x65)', escape: 'Escaped (\\x48\\x65)' }, 'space') },
        label: 'Hexadecimal',
        rows: { bytes: 'Bytes (UTF-8)' },
        grids: [['table', 'Per character']],
        run: (x) => {
            const bytes = B.utf8(x.text);

            if (!bytes.length) {
                return { empty: 'Type some text.' };
            }

            const hex = bytes.map((b) => b.toString(16).toUpperCase().padStart(2, '0'));
            const text = { space: hex.join(' '), plain: hex.join(''), prefix: hex.map((h) => `0x${h}`).join(', '), escape: hex.map((h) => `\\x${h}`).join('') }[x.style];

            return { text, rows: { bytes: num(bytes.length) }, steps: ['Text → UTF-8 bytes → two hex digits per byte'], grids: { table: charGrid(x.text, [['UTF-8 hex', (c) => B.byteText(bytesOf(c), 16)], ['Code point', cp]]) } };
        },
    }),
    letters_numbers: textTool({
        inputs: { text: TEXT('Hello World'), scheme: SEL('Scheme', { a1: 'A = 1 … Z = 26', a0: 'A = 0 … Z = 25', ascii: 'ASCII codes' }, 'a1'), sep: SEL('Separator', { space: 'Space', dash: 'Dash', comma: 'Comma' }, 'space') },
        label: 'Numbers',
        rows: { sum: 'Sum of the letter numbers' },
        run: (x) => {
            const words = String(x.text ?? '').trim().split(/\s+/).filter(Boolean);

            if (!words.length) {
                return { empty: 'Type some text.' };
            }

            const sep = { space: ' ', dash: '-', comma: ', ' }[x.sep];
            let total = 0;
            const text = words.map((w) => [...w].map((c) => {
                if (x.scheme === 'ascii') {
                    total += c.codePointAt(0);

                    return c.codePointAt(0);
                }

                const i = c.toUpperCase().charCodeAt(0) - 64;

                if (i >= 1 && i <= 26) {
                    total += i - (x.scheme === 'a0' ? 1 : 0);

                    return i - (x.scheme === 'a0' ? 1 : 0);
                }

                return c;
            }).join(sep)).join(' / ');

            return { text, rows: { sum: num(total) }, steps: ['Words are separated by “/”; characters that are not letters are kept as they are'] };
        },
    }),
    numbers_letters: textTool({
        inputs: { nums: TXT('Numbers (words separated by /)', '8 5 12 12 15 / 23 15 18 12 4'), scheme: SEL('Scheme', { a1: '1 = A … 26 = Z', a0: '0 = A … 25 = Z', ascii: 'ASCII codes' }, 'a1'), caseOut: SEL('Letters', { upper: 'UPPERCASE', lower: 'lowercase' }, 'upper') },
        label: 'Letters',
        rows: { count: 'Letters' },
        run: (x) => {
            const words = String(x.nums ?? '').trim().split(/\s*\/\s*/).filter(Boolean);
            let count = 0;
            const bad = [];
            const text = words.map((w) => w.split(/[\s,.-]+/).filter(Boolean).map((t) => {
                const n = Number(t);

                if (!Number.isInteger(n)) {
                    bad.push(t);

                    return '?';
                }

                if (x.scheme === 'ascii') {
                    count += 1;

                    return n >= 0 && n <= 0x10ffff ? String.fromCodePoint(n) : '?';
                }

                const i = n + (x.scheme === 'a0' ? 1 : 0);

                if (i < 1 || i > 26) {
                    bad.push(t);

                    return '?';
                }

                count += 1;
                const c = String.fromCharCode(64 + i);

                return x.caseOut === 'lower' ? c.toLowerCase() : c;
            }).join('')).join(' ');

            if (!words.length) {
                return { empty: 'Enter numbers.' };
            }

            return { text, sub: bad.length ? `Not letters in this scheme: ${bad.slice(0, 6).join(', ')} (shown as ?)` : '', rows: { count: num(count) } };
        },
    }),
    base64: textTool({
        inputs: { mode: SEL('Mode', { encode: 'Encode text → Base64', decode: 'Decode Base64 → text' }, 'encode'), text: TEXT('Hello, Base64! ✓'), b64: TXT('Base64', 'SGVsbG8sIEJhc2U2NCEg4pyT'), url: SEL('Alphabet', { std: 'Standard (+ / and = padding)', url: 'URL-safe (- _ without padding)' }, 'std') },
        show: { text: 'mode:encode', b64: 'mode:decode', url: 'mode:encode' },
        label: 'Result',
        rows: { bytes: 'Bytes', chars: 'Characters out', overhead: 'Size change' },
        steps: ['Every 3 bytes become 4 characters from a 64-letter alphabet (RFC 4648); = pads the last group'],
        run: (x) => {
            if (x.mode === 'decode') {
                const p = B.fromBase64(x.b64);

                if (p.problem) {
                    return { error: p.problem };
                }

                const text = B.fromUtf8(p.bytes);

                return text === null ? { text: B.byteText(p.bytes, 16), sub: 'The data is not UTF-8 text, so it is shown as hex bytes', rows: { bytes: num(p.bytes.length), chars: num(p.bytes.length * 2), overhead: '—' } } : { text, rows: { bytes: num(p.bytes.length), chars: num([...text].length), overhead: `${num(String(x.b64).replace(/\s/g, '').length)} → ${num(p.bytes.length)} bytes` } };
            }

            const bytes = B.utf8(x.text);
            const text = B.base64(bytes, x.url === 'url');

            return { text, rows: { bytes: num(bytes.length), chars: num(text.length), overhead: bytes.length ? `+${num(((text.length - bytes.length) / bytes.length) * 100, 3)}%` : '—' } };
        },
    }),
    morse: textTool({
        inputs: { mode: SEL('Translate', { toMorse: 'Text → Morse', toText: 'Morse → text' }, 'toMorse'), text: TEXT('SOS Help'), code: TXT('Morse (letters separated by spaces, words by /)', '... --- ... / .... . .-.. .--.'), wpm: N('Speed (words per minute)', 20, 1) },
        show: { text: 'mode:toMorse', code: 'mode:toText', wpm: 'mode:toMorse' },
        label: 'Translation',
        rows: { units: 'Length in dot units', time: 'Time to send', unknown: 'Unknown characters' },
        steps: ['International Morse Code, ITU-R M.1677-1: dot = 1 unit, dash = 3, gaps 1 (inside a letter), 3 (between letters), 7 (between words)', 'At w words per minute a unit lasts 1.2/w seconds (PARIS standard)'],
        run: (x) => {
            if (x.mode === 'toText') {
                const text = B.fromMorse(x.code);

                return { text, rows: { units: num(B.morseUnits(String(x.code).trim().replace(/\s*\/\s*/g, ' / '))), time: '—', unknown: text.includes('?') ? 'Some codes are not in the ITU table (shown as ?)' : 'None' } };
            }

            const code = B.toMorse(x.text);
            const units = B.morseUnits(code);

            return { text: code, rows: { units: num(units), time: `${num((units * 1.2) / x.wpm, 4)} s at ${num(x.wpm)} WPM`, unknown: code.includes('?') ? 'Some characters have no Morse code (shown as ?)' : 'None' } };
        },
    }),
    t9: textTool({
        inputs: { mode: SEL('Convert', { toText: 'Key presses → text', toKeys: 'Text → key presses' }, 'toText'), keys: TXT('Key presses (multi-tap groups separated by spaces, 0 = space)', '44 33 555 555 666 0 9 666 777 555 3'), text: TEXT('Hello world') },
        show: { keys: 'mode:toText', text: 'mode:toKeys' },
        label: 'Result',
        rows: { presses: 'Key presses' },
        steps: ['Phone keypad letters (ITU E.161): 2 ABC, 3 DEF, 4 GHI, 5 JKL, 6 MNO, 7 PQRS, 8 TUV, 9 WXYZ', 'Multi-tap: press a key once for its first letter, twice for the second … (predictive T9 needs a dictionary and is not used)'],
        run: (x) => {
            if (x.mode === 'toKeys') {
                const keys = B.toT9(String(x.text).replace(/ /g, ' ').replace(/\s/g, ' '));

                return { text: keys, rows: { presses: num(keys.replace(/\s/g, '').length) } };
            }

            const text = B.fromT9(x.keys);

            return { text, rows: { presses: num(String(x.keys).replace(/\s/g, '').length) } };
        },
    }),
    caesar: textTool({
        inputs: { text: TEXT('Veni, vidi, vici'), shift: N('Shift (key)', 3), mode: SEL('Mode', { encode: 'Encrypt (shift forward)', decode: 'Decrypt (shift back)', brute: 'Try every shift' }, 'encode') },
        label: 'Result',
        rows: { key: 'Shift used', rot13: 'ROT13' },
        grids: [['all', 'Every possible shift']],
        run: (x) => {
            if (!Number.isInteger(x.shift)) {
                return { error: 'The shift must be a whole number.' };
            }

            const s = x.mode === 'decode' ? -x.shift : x.shift;
            const text = x.mode === 'brute' ? B.caesar(x.text, -x.shift) : B.caesar(x.text, s);

            return { text, rows: { key: `${((s % 26) + 26) % 26}`, rot13: B.caesar(x.text, 13) }, steps: ['Each letter moves the same number of places along the alphabet, wrapping Z → A', 'With only 25 keys it is broken by trying them all'], grids: { all: { columns: ['Text'], rows: Array.from({ length: 25 }, (_, k) => ({ header: `Shift ${k + 1}`, cells: [B.caesar(String(x.text).slice(0, 80), -(k + 1))] })) } } };
        },
    }),
    vigenere: textTool({
        inputs: { text: TEXT('ATTACK AT DAWN'), key: LINE('Key', 'LEMON'), mode: SEL('Mode', { encrypt: 'Encrypt', decrypt: 'Decrypt' }, 'encrypt') },
        label: 'Result',
        rows: { key: 'Key letters (shifts)', letters: 'Letters changed' },
        grids: [['table', 'Letter by letter (first 60)']],
        run: (x) => {
            const out = B.vigenere(x.text, x.key, x.mode === 'decrypt');

            if (out === null) {
                return { error: 'The key needs at least one letter.' };
            }

            const key = String(x.key).toUpperCase().replace(/[^A-Z]/g, '');
            const pairs = [];
            let k = 0;
            [...String(x.text)].forEach((c, i) => {
                if (/[a-z]/i.test(c) && pairs.length < 60) {
                    pairs.push({ header: c, cells: [key[k % key.length], String(key.charCodeAt(k % key.length) - 65), out[i]] });
                    k += 1;
                }
            });

            return { text: out, rows: { key: [...key].map((c) => `${c}=${c.charCodeAt(0) - 65}`).join(' '), letters: num(pairs.length) }, steps: ['Each letter is shifted by the matching key letter (A = 0 … Z = 25); the key repeats', 'Spaces and punctuation are kept and do not use up key letters'], grids: { table: { columns: ['Key', 'Shift', 'Out'], rows: pairs } } };
        },
    }),
    gothic: textTool({
        inputs: { text: TEXT('Gothic Letters'), style: SEL('Style', { fraktur: 'Fraktur 𝔊𝔬𝔱𝔥𝔦𝔠', bold: 'Bold Fraktur 𝕲𝖔𝖙𝖍𝖎𝖈' }, 'fraktur') },
        label: 'Gothic text',
        rows: { other: 'The other style', note: 'Note' },
        run: (x) => ({ text: B.fraktur(x.text, x.style === 'bold'), rows: { other: B.fraktur(x.text, x.style !== 'bold'), note: 'Letters A–Z and a–z change; digits and accented letters stay as typed' }, steps: ['Unicode Mathematical Fraktur letters (U+1D504 onward; C, H, I, R and Z use ℭ ℌ ℑ ℜ ℨ)', 'They are characters, not a font, so they paste anywhere; screen readers may read them oddly'] }),
    }),
    mirror: textTool({
        inputs: { text: TEXT('Mirror text (b, d, p, q)') },
        label: 'Mirrored text',
        rows: { reversed: 'Just reversed' },
        run: (x) => ({ text: B.mirror(x.text), rows: { reversed: [...String(x.text)].reverse().join('') }, steps: ['The order of characters is reversed and letters with a mirror look-alike are swapped (b ↔ d, p ↔ q, ( ↔ ), e → ɘ, R → Я …)', 'Many letters have no mirrored Unicode form and stay as they are'] }),
    }),
    small_caps: textTool({
        inputs: { text: TEXT('Small Caps Text') },
        label: 'Small caps',
        rows: { note: 'Not converted' },
        run: (x) => {
            const r = B.smallCaps(x.text);

            return { text: r.text, rows: { note: missingNote(r.missing) }, steps: ['Letters become Unicode small capitals (ᴀ ʙ ᴄ …); q and x have no small-capital form'] };
        },
    }),
    small_text: textTool({
        inputs: { text: TEXT('small text'), style: SEL('Style', { sup: 'Superscript-style ˢᵐᵃˡˡ', sub: 'Subscript-style ₛₘₐₗₗ', caps: 'Small caps ꜱᴍᴀʟʟ' }, 'sup') },
        label: 'Small text',
        rows: { note: 'Not converted' },
        run: (x) => {
            const r = x.style === 'sub' ? B.subscript(String(x.text).toLowerCase()) : x.style === 'caps' ? B.smallCaps(x.text) : B.smallText(x.text);

            return { text: r.text, rows: { note: missingNote(r.missing) }, steps: ['Unicode has small letter forms for most, but not all, letters (no superscript q; few subscript letters)'] };
        },
    }),
    strike: textTool({
        inputs: { text: TEXT('crossed out'), style: SEL('Style', { '̶': 'Long stroke s̶t̶r̶i̶k̶e̶', '̵': 'Short stroke s̵t̵r̵i̵k̵e̵', '̸': 'Slash s̸t̸r̸i̸k̸e̸', '̲': 'Underline u̲n̲d̲e̲r̲' }, '̶') },
        label: 'Strikethrough text',
        rows: { note: 'How it works' },
        run: (x) => ({ text: B.strike(x.text, x.style), rows: { note: `A combining character (U+${x.style.codePointAt(0).toString(16).toUpperCase().padStart(4, '0')}) after every letter` }, steps: ['Combining overlay characters draw the line through the letter before them'] }),
    }),
    subscript: textTool({
        inputs: { text: TEXT('H2O + CO2 → H2CO3') },
        label: 'Subscript text',
        rows: { note: 'Not converted' },
        run: (x) => {
            const r = B.subscript(x.text);

            return { text: r.text, rows: { note: missingNote(r.missing) }, steps: ['Digits, + − = ( ) and some lowercase letters have Unicode subscripts; capital letters do not and are kept (H₂O)'] };
        },
    }),
    superscript: textTool({
        inputs: { text: TEXT('x2 + y3 = z(n+1)') },
        label: 'Superscript text',
        rows: { note: 'Not converted' },
        run: (x) => {
            const r = B.superscript(x.text);

            return { text: r.text, rows: { note: missingNote(r.missing) }, steps: ['Digits, + − = ( ), most lowercase and many capital letters have Unicode superscripts (no q, C, F, Q, S, X, Y, Z)'] };
        },
    }),
    hamming_code: textTool({
        inputs: { mode: SEL('Mode', { encode: 'Encode data bits', decode: 'Check a received code word' }, 'encode'), data: LINE('Data bits', '1011'), word: LINE('Received code word', '0110111'), parity: SEL('Parity', { even: 'Even', odd: 'Odd' }, 'even'), secded: SEL('Extra overall parity bit (SECDED)', { no: 'No', yes: 'Yes' }, 'no') },
        show: { data: 'mode:encode', word: 'mode:decode' },
        label: 'Result',
        rows: { info: 'Detail', parityBits: 'Parity bits' },
        run: (x) => {
            const opts = { odd: x.parity === 'odd', secded: x.secded === 'yes' };

            if (x.mode === 'decode') {
                const w = String(x.word ?? '').replace(/\s/g, '');

                if (!/^[01]{3,}$/.test(w)) {
                    return { error: 'Enter the code word as 0s and 1s.' };
                }

                const d = B.hammingDecode(w, opts);

                return { text: d.verdict, sub: `Data bits: ${d.data}`, rows: { info: `Syndrome ${d.syndrome} (binary ${d.syndrome.toString(2)}); corrected word ${d.fixed}`, parityBits: 'Positions 1, 2, 4, 8, …' }, steps: ['Recompute each parity bit; the failing checks add up to the position of a single wrong bit (the syndrome)', 'With the extra overall parity bit, two errors are detected but not corrected'] };
            }

            const data = String(x.data ?? '').replace(/\s/g, '');

            if (!/^[01]{1,64}$/.test(data)) {
                return { error: 'Enter 1 to 64 data bits (0s and 1s).' };
            }

            const e = B.hammingEncode(data, opts);

            return { text: e.word, sub: `Hamming (${e.word.length}, ${data.length}) code`, rows: { info: `${e.r} parity bits at positions ${e.parity.map(([p]) => p).join(', ')}${opts.secded ? ' plus an overall parity bit at the end' : ''}`, parityBits: e.parity.map(([p, v]) => `p${p} = ${v}`).join(', ') }, steps: ['Parity bit at position 2ᵏ covers every position whose binary number has that bit set', `Data bits fill the other positions in order: ${data}`, 'Any single-bit error can then be located and corrected (Hamming 1950)'] };
        },
    }),
    hamming_distance: textTool({
        inputs: { a: LINE('First string', '1011101'), b: LINE('Second string', '1001001') },
        label: 'Hamming distance',
        rows: { positions: 'Positions that differ', length: 'Length' },
        run: (x) => {
            const d = B.hammingDistance(String(x.a ?? ''), String(x.b ?? ''));

            if (!d) {
                return { error: 'The two strings must have the same length.' };
            }

            return { text: String(d.distance), sub: `${d.distance} of ${[...String(x.a)].length} positions differ`, rows: { positions: d.positions.length ? d.positions.join(', ') : 'None', length: num([...String(x.a)].length) }, steps: ['Hamming distance = number of positions where the symbols differ (equal-length strings only)'] };
        },
    }),
    parity: textTool({
        inputs: { data: LINE('Data bits', '1011001'), type: SEL('Parity', { even: 'Even', odd: 'Odd' }, 'even') },
        label: 'Parity bit',
        rows: { ones: 'Number of 1s', word: 'Data with parity bit', other: 'The other parity' },
        run: (x) => {
            const d = String(x.data ?? '').replace(/\s/g, '');

            if (!/^[01]+$/.test(d)) {
                return { error: 'Enter the data as 0s and 1s.' };
            }

            const p = B.parityBit(d, x.type === 'odd');

            return { text: String(p.bit), sub: `${x.type === 'odd' ? 'Odd' : 'Even'} parity: the total number of 1s becomes ${x.type === 'odd' ? 'odd' : 'even'}`, rows: { ones: num(p.ones), word: `${d}${p.bit}`, other: `${x.type === 'odd' ? 'Even' : 'Odd'} parity bit = ${1 - p.bit}` }, steps: ['Count the 1s; even parity adds 1 when the count is odd, odd parity adds 1 when it is even', 'Detects any single flipped bit, but not two'] };
        },
    }),
    hash_identifier: textTool({
        inputs: { hash: LINE('Hash', '5d41402abc4b2a76b9719d911017c592') },
        label: 'Possible hash types',
        rows: { kind: 'Format', note: 'Note' },
        run: (x) => {
            const r = B.identifyHash(x.hash);

            if (!String(x.hash ?? '').trim()) {
                return { empty: 'Paste a hash.' };
            }

            return { text: r.types.length ? r.types.join(', ') : 'Unknown', sub: r.types.length > 1 ? 'Several algorithms produce this length; the first is the most common' : '', rows: { kind: r.kind, note: 'Identification is by length, characters and markers only; a hash cannot be reversed to its input' }, steps: ['Hex hashes are told apart by length (MD5 32, SHA-1 40, SHA-256 64, SHA-512 128 hex digits)', 'Password-hash formats carry markers such as $2b$ (bcrypt) or $6$ (SHA-512-crypt)'] };
        },
    }),
    hash_gen: textTool({
        inputs: { text: TEXT('hello'), algo: SEL('Show as the main result', { sha256: 'SHA-256', sha1: 'SHA-1', sha512: 'SHA-512', md5: 'MD5' }, 'sha256') },
        label: 'Hash',
        rows: { md5: 'MD5', sha1: 'SHA-1', sha256: 'SHA-256', sha512: 'SHA-512', bytes: 'Input bytes (UTF-8)' },
        run: (x) => {
            const bytes = B.utf8(x.text);
            const all = { md5: B.md5(bytes), sha1: B.sha1(bytes), sha256: B.sha256(bytes), sha512: B.sha512(bytes) };

            return { text: all[x.algo], rows: { ...all, bytes: num(bytes.length) }, steps: ['Hashed in your browser: nothing is sent anywhere', 'MD5 (RFC 1321) and SHA-1 are broken for security; use SHA-256 or SHA-512 (FIPS 180-4)', 'For passwords use a slow hash such as bcrypt or Argon2, not these'] };
        },
    }),
    chmod: textTool({
        inputs: { mode: LINE('Permissions (755, 0644, 4755 or rwxr-xr-x)', '755') },
        label: 'chmod',
        rows: { octal: 'Octal', symbolic: 'Symbolic', command: 'Command', owner: 'Owner', group: 'Group', others: 'Others', special: 'Special bits' },
        run: (x) => {
            const m = B.parseMode(x.mode);

            if (!m) {
                return { error: 'Enter 3 or 4 octal digits (e.g. 755) or 9 symbols (e.g. rwxr-xr-x).' };
            }

            const t = B.modeText(m);
            const say = (p) => [p & 4 ? 'read' : '', p & 2 ? 'write' : '', p & 1 ? 'execute' : ''].filter(Boolean).join(', ') || 'no access';

            return { text: `${t.octal} (${t.symbolic})`, rows: { octal: t.octal, symbolic: t.symbolic, command: `chmod ${t.octal} file`, owner: say(m.perms[0]), group: say(m.perms[1]), others: say(m.perms[2]), special: [m.special & 4 ? 'setuid' : '', m.special & 2 ? 'setgid' : '', m.special & 1 ? 'sticky' : ''].filter(Boolean).join(', ') || 'None' }, steps: ['Each digit adds read 4 + write 2 + execute 1, for owner, group and others', 'An optional leading digit sets setuid 4, setgid 2, sticky 1'] };
        },
    }),
    color: textTool({
        inputs: { color: LINE('Colour (#3366cc, rgb(51, 102, 204) or hsl(220, 60%, 50%))', '#3366cc') },
        label: 'HEX',
        rows: { rgb: 'RGB', hsl: 'HSL', hsv: 'HSV / HSB', cmyk: 'CMYK', white: 'Contrast with white', black: 'Contrast with black' },
        run: (x) => {
            const c = B.parseColor(x.color);

            if (!c) {
                return { error: 'Enter a colour as #rgb, #rrggbb, rgb(r, g, b) or hsl(h, s%, l%).' };
            }

            const m = B.colorModels(c);
            const r = (v) => Math.round(v);
            const cw = B.contrast(c, { r: 255, g: 255, b: 255 });
            const cb = B.contrast(c, { r: 0, g: 0, b: 0 });

            return { text: m.hex, rows: { rgb: `rgb(${m.rgb.join(', ')})`, hsl: `hsl(${r(m.hsl[0])}, ${r(m.hsl[1])}%, ${r(m.hsl[2])}%)`, hsv: `hsv(${r(m.hsv[0])}, ${r(m.hsv[1])}%, ${r(m.hsv[2])}%)`, cmyk: `cmyk(${m.cmyk.map(r).join('%, ')}%)`, white: `${num(cw, 3)}:1 ${cw >= 4.5 ? '(passes WCAG AA for text)' : '(fails AA for text)'}`, black: `${num(cb, 3)}:1 ${cb >= 4.5 ? '(passes WCAG AA for text)' : '(fails AA for text)'}` }, steps: ['HSL and HSV from the RGB maximum, minimum and spread (CSS Color Module)', 'CMYK here is the simple device-independent conversion; print shops use colour profiles'] };
        },
    }),
    uuid: textTool({
        inputs: { count: N('How many', 5, 1), version: SEL('Version', { v4: 'Version 4 (random)', v7: 'Version 7 (time-ordered)' }, 'v4'), caseOut: SEL('Letters', { lower: 'lowercase', upper: 'UPPERCASE' }, 'lower') },
        label: 'UUIDs',
        rows: { version: 'Version', bits: 'Random bits each' },
        run: (x) => {
            if (!(Number.isInteger(x.count) && x.count >= 1 && x.count <= 500)) {
                return { error: 'Generate 1 to 500 UUIDs.' };
            }

            const now = Date.now();
            const list = Array.from({ length: x.count }, (_, i) => (x.version === 'v7' ? B.uuid7(now + i) : B.uuid4()));
            const text = list.join('\n');

            return { text: x.caseOut === 'upper' ? text.toUpperCase() : text, sub: 'Change any value to generate new ones', rows: { version: x.version === 'v7' ? 'v7: 48-bit Unix time in ms, then random bits (sorts by creation time)' : 'v4: random', bits: x.version === 'v7' ? '74' : '122' }, steps: ['RFC 9562 layout with the browser’s cryptographic random source', 'With 122 random bits, a duplicate is vanishingly unlikely'] };
        },
    }),
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
