import assert from 'node:assert/strict';
import { execSync } from 'node:child_process';
import test from 'node:test';
import { base64, caesar, fromBase64, fromMorse, hammingDecode, hammingEncode, md5, sha1, sha256, sha512, toMorse, utf8, vigenere } from '../tech/bits.js';
import { chordNotes, freq, keySignature, midi, noteText, parseNote } from '../tech/music.js';
import { ipv6Text, network, parseCidr, parseIPv4, parseIPv6, rangeToCidrs } from '../tech/net.js';
import { framesToTimecode, timecodeToFrames } from '../tools/tc-photo.js';
import { handlers as net } from '../tools/tc-net.js';
import { handlers as music } from '../tools/tc-music.js';

/** Reference values from Python 3 hashlib, base64 and ipaddress, RFC 4648 and SMPTE 12M. */
const load = (file) => JSON.parse(execSync(`php -r 'echo json_encode(require "config/${file}.php");'`).toString());
const data = { units: load('units'), technology: load('technology_data') };
const run = (handler, inputs) => handler(inputs, { data });
const FOX = utf8('The quick brown fox jumps over the lazy dog');

test('hashes match hashlib', () => {
    assert.equal(md5(FOX), '9e107d9d372bb6826bd81d3542a419d6');
    assert.equal(sha1(FOX), '2fd4e1c67a2d28fced849ee1bb76e7391b93eb12');
    assert.equal(sha256(FOX), 'd7a8fbb307d7809469ca9abcb0082e4f8d5651e46d3cdb762d02d0bf37c9e592');
    assert.equal(sha512(FOX), '07e547d9586f6a73f73fbac0435ed76951218fb7d0c8d788a309d785436bbb642e93a252a954f23912547d1e8a3b5ed6e1bfd7097821233fa0538f3db854fee6');
    assert.equal(md5(utf8('héllo €')), '6a1950b864488746748ba6312d3ce712');
    assert.equal(sha256(utf8('héllo €')), '9cb52b6d1cfc1eae34c63c2b0ff0d49ed8ef2c82482b3c455747594c83754098');
});

test('Base64 follows the RFC 4648 test vectors', () => {
    const vectors = { f: 'Zg==', fo: 'Zm8=', foo: 'Zm9v', foob: 'Zm9vYg==', fooba: 'Zm9vYmE=', foobar: 'Zm9vYmFy' };

    for (const [text, encoded] of Object.entries(vectors)) {
        assert.equal(base64(utf8(text)), encoded);
        assert.deepEqual(fromBase64(encoded).bytes, utf8(text));
    }
});

test('ciphers, Morse and Hamming codes', () => {
    assert.equal(vigenere('ATTACKATDAWN', 'LEMON'), 'LXFOPVEFRNHR');
    assert.equal(vigenere('LXFOPVEFRNHR', 'LEMON', true), 'ATTACKATDAWN');
    assert.equal(caesar('Veni, vidi, vici', 3), 'Yhql, ylgl, ylfl');
    assert.equal(fromMorse(toMorse('SOS 73')), 'SOS 73');
    assert.equal(hammingEncode('1011').word, '0110011');
    assert.deepEqual([hammingDecode('0110111').syndrome, hammingDecode('0110111').data], [5, '1011']);
});

test('IP addresses match Python ipaddress', () => {
    const net26 = network(parseCidr('192.168.10.77/26'));
    assert.equal(net26.net, parseIPv4('192.168.10.64'));
    assert.equal(net26.last, parseIPv4('192.168.10.127'));
    assert.equal(net26.mask, parseIPv4('255.255.255.192'));
    assert.equal(net26.usable, 62n);
    assert.deepEqual(rangeToCidrs(4, parseIPv4('10.0.0.5'), parseIPv4('10.0.0.20')).map((c) => c.prefix), [32, 31, 29, 30, 32]);
    assert.equal(ipv6Text(parseIPv6('2001:0db8:0000:0000:0000:ff00:0042:8329')), '2001:db8::ff00:42:8329');
    assert.match(run(net.ip_subnet, { ip: '192.168.10.77/26', split: 4 }).value, /192\.168\.10\.64\/26/);
});

test('drop-frame timecode', () => {
    assert.equal(framesToTimecode(107892, '29.97df'), '01:00:00;00');
    assert.equal(timecodeToFrames('01:00:00;00', '29.97df').frames, 107892);
    assert.equal(timecodeToFrames('00:01:00;02', '29.97df').frames, 1800);
});

test('music theory', () => {
    assert.equal(freq(midi(parseNote('A4'))), 440);
    assert.deepEqual(chordNotes(parseNote('C'), 'maj7').map((n) => noteText(n)), ['C', 'E', 'G', 'B']);
    assert.equal(keySignature(parseNote('Eb')).count, -3);

    // D'Addario: T = UW × (2 × L × f)² / 386.4 — NW046 tuned to E2 on a 25.5 in scale.
    const tension = run(music.string_tension, { scale: 0.6477, string: 'nw046', uw: 0.00038216, note: 'E2', a4: 440 });
    assert.match(tension.value, /17\.47/);
});
