import { defineTools } from '../engines/formula.js';
import { handlersFor } from '../physics/core.js';
import { N, SEL, TXT, LINE, num, pct } from '../statistics/common.js';
import * as Net from '../tech/net.js';

/**
 * Internet and network: IP addresses, CIDR and subnets, data transfer times, bandwidth, baud rate, streaming
 * bitrates and uptime. Data sizes arrive in bytes and rates in bit/s (config/units.php data and data_rate tables).
 */

const SIZE = (label, value, unit = 'gb') => [label, 'data', unit, value];
const RATE = (label, value, unit = 'mbps') => [label, 'data_rate', unit, value];
const TIME = (label, value, unit = 'ms') => [label, 'time', unit, value];

/** "1.5 GB (1.4 GiB)" text for a byte count. */
function sizeText(bytes) {
    const dec = [['TB', 1e12], ['GB', 1e9], ['MB', 1e6], ['kB', 1e3]].find(([, f]) => bytes >= f) ?? ['B', 1];
    const bin = [['TiB', 2 ** 40], ['GiB', 2 ** 30], ['MiB', 2 ** 20], ['KiB', 2 ** 10]].find(([, f]) => bytes >= f) ?? ['B', 1];

    return `${num(bytes / dec[1], 5)} ${dec[0]}${bin[0] !== 'B' ? ` (${num(bytes / bin[1], 5)} ${bin[0]})` : ''}`;
}

/** "25 Mbit/s" text for a rate in bit/s. */
function rateText(bps) {
    const u = [['Gbit/s', 1e9], ['Mbit/s', 1e6], ['kbit/s', 1e3]].find(([, f]) => bps >= f) ?? ['bit/s', 1];

    return `${num(bps / u[1], 5)} ${u[0]}`;
}

const SPEEDS = [[1e6, '1 Mbit/s'], [10e6, '10 Mbit/s'], [25e6, '25 Mbit/s'], [50e6, '50 Mbit/s'], [100e6, '100 Mbit/s'], [300e6, '300 Mbit/s'], [1e9, '1 Gbit/s'], [10e9, '10 Gbit/s']];

/** Shared transfer-time tool (download, upload, data transfer). */
function transferTool(kind) {
    return {
        type: 'calc',
        inputs: { size: SIZE(kind === 'upload' ? 'File size' : 'Data size', { upload: 2, download: 50, transfer: 500 }[kind]), speed: RATE(`${kind === 'upload' ? 'Upload' : kind === 'download' ? 'Download' : 'Connection'} speed`, { upload: 20, download: 100, transfer: 1 }[kind], kind === 'transfer' ? 'gbps' : 'mbps'), overhead: N('Protocol overhead and slowdown (%)', 10, 0) },
        family: ['data', 'data_rate'],
        label: `${kind === 'upload' ? 'Upload' : kind === 'download' ? 'Download' : 'Transfer'} time`,
        rows: { exact: 'Seconds', effective: 'Effective speed', bits: 'Data in bits' },
        grids: [['table', 'At other speeds']],
        run: (x) => {
            if (!(x.size > 0 && x.speed > 0) || !(x.overhead >= 0 && x.overhead < 100)) {
                return { error: 'Enter a size and a speed above zero, and an overhead below 100%.' };
            }

            const bits = x.size * 8;
            const eff = x.speed * (1 - x.overhead / 100);
            const t = bits / eff;

            return { value: Net.duration(t), sub: `${sizeText(x.size)} at ${rateText(x.speed)}`, rows: { exact: num(t, 6), effective: rateText(eff), bits: num(bits, 6) }, steps: ['Time = data in bits ÷ speed in bits per second', 'Storage uses bytes (1 byte = 8 bits); internet speeds use bits per second (Mbps)', `${num(bits, 6)} bit ÷ ${num(eff, 6)} bit/s = ${num(t, 6)} s (after ${num(x.overhead)}% overhead)`], grids: { table: { columns: ['Time'], rows: SPEEDS.map(([s, label]) => ({ header: label, cells: [Net.duration(bits / (s * (1 - x.overhead / 100)))] })) } } };
        },
    };
}

export const TOOLS = {
    bandwidth: {
        type: 'calc',
        inputs: { mode: SEL('Estimate for', { website: 'A website', download: 'Downloads of a file' }, 'website'), views: N('Page views per month', 200000, 0), page: SIZE('Average page size', 3, 'mb'), downloads: N('Downloads per month', 5000, 0), file: SIZE('File size', 200, 'mb'), peak: N('Peak factor (busiest hour vs average)', 3, 1), redundancy: N('Safety margin (%)', 30, 0) },
        show: { views: 'mode:website', page: 'mode:website', downloads: 'mode:download', file: 'mode:download' },
        when: { views: (x) => x.mode === 'website', page: (x) => x.mode === 'website', downloads: (x) => x.mode === 'download', file: (x) => x.mode === 'download' },
        label: 'Bandwidth needed',
        rows: { monthly: 'Data per month', average: 'Average rate', perVisit: 'Data per page view or download' },
        run: (x) => {
            const bytes = x.mode === 'website' ? x.views * x.page : x.downloads * x.file;
            const avg = (bytes * 8) / (30 * 86400);
            const need = avg * x.peak * (1 + x.redundancy / 100);

            return { value: rateText(need), sub: 'At peak, with the safety margin', rows: { monthly: sizeText(bytes), average: rateText(avg), perVisit: sizeText(x.mode === 'website' ? x.page : x.file) }, steps: ['Monthly data = visits × size', `Average rate = ${sizeText(bytes)} × 8 ÷ (30 days × 86,400 s) = ${rateText(avg)}`, `× peak factor ${num(x.peak)} × (1 + ${num(x.redundancy)}%) = ${rateText(need)}`, 'Hosting plans often quote monthly transfer (the first row) instead of a rate'] };
        },
    },
    bdp: {
        type: 'calc',
        inputs: { bw: RATE('Bandwidth', 1, 'gbps'), rtt: TIME('Round-trip time (ping)', 80), window: SIZE('TCP window (optional)', 64, 'kib') },
        optional: ['window'],
        label: 'Bandwidth-delay product',
        rows: { bits: 'In bits', maxThroughput: 'Throughput with the given window', needed: 'Window needed for full speed' },
        run: (x) => {
            const bdpBits = x.bw * x.rtt;
            const bdp = bdpBits / 8;
            const thr = Number.isFinite(x.window) && x.window > 0 ? Math.min(x.bw, (x.window * 8) / x.rtt) : NaN;

            return { value: sizeText(bdp), sub: 'Data in flight to keep the link full', rows: { bits: num(bdpBits, 6), maxThroughput: Number.isFinite(thr) ? rateText(thr) : 'Enter a window', needed: `${sizeText(bdp)} (window scaling, RFC 7323, above 64 KiB)` }, steps: ['BDP = bandwidth × round-trip time', `= ${rateText(x.bw)} × ${num(x.rtt * 1000, 5)} ms = ${num(bdpBits, 6)} bits`, 'A sender can have at most one window of unacknowledged data, so throughput ≤ window ÷ RTT'] };
        },
    },
    baud: {
        type: 'calc',
        inputs: { mode: SEL('Find', { baud: 'Baud rate from bit rate', bits: 'Bit rate from baud rate' }, 'baud'), rate: RATE('Bit rate', 9600, 'bps'), baud: N('Baud rate (symbols per second)', 2400, 0), bps: SEL('Bits per symbol (modulation)', { 1: '1 (binary, FSK, BPSK, UART)', 2: '2 (QPSK, 4-level)', 3: '3 (8-PSK)', 4: '4 (16-QAM)', 6: '6 (64-QAM)', 8: '8 (256-QAM)', 10: '10 (1024-QAM)' }, '2') },
        show: { rate: 'mode:baud', baud: 'mode:bits' },
        when: { rate: (x) => x.mode === 'baud', baud: (x) => x.mode === 'bits' },
        label: 'Result',
        rows: { symbol: 'Symbol time', uart: 'UART 8N1 bytes per second', bitTime: 'Bit time' },
        run: (x) => {
            const k = Number(x.bps);
            const baud = x.mode === 'baud' ? x.rate / k : x.baud;
            const bits = baud * k;

            return { value: x.mode === 'baud' ? `${num(baud, 6)} Bd` : rateText(bits), sub: `${k} bit${k > 1 ? 's' : ''} per symbol`, rows: { symbol: `${num(1e6 / baud, 6)} µs`, uart: k === 1 ? num(bits / 10, 6) : 'For binary links', bitTime: `${num(1e6 / bits, 6)} µs` }, steps: ['Bit rate = baud × bits per symbol (log₂ of the number of symbol states)', 'For a serial UART with 8 data bits, no parity and 1 stop bit, each byte takes 10 bit times'] };
        },
    },
    data_transfer: transferTool('transfer'),
    download: transferTool('download'),
    upload: transferTool('upload'),
    ip_converter: {
        type: 'calc',
        inputs: { ip: LINE('IP address (IPv4 or IPv6, in any form)', '192.168.1.1') },
        label: 'IP address',
        rows: { decimal: 'Decimal', hex: 'Hexadecimal', binary: 'Binary', ipv6: 'As IPv6 (mapped)', expanded: 'Expanded (IPv6)', type: 'Type', cls: 'Class (IPv4)' },
        run: (x) => {
            const a = Net.parseAddress(x.ip);

            if (!a) {
                return { error: 'Enter an IPv4 address (192.168.1.1), an IPv6 address, a decimal number or 0x hex.' };
            }

            const bits = Net.bitsOf(a.v);
            const bin = a.n.toString(2).padStart(bits, '0');
            const t = Net.addressType(a.v, a.n);

            return { value: Net.addrText(a.v, a.n), sub: `IPv${a.v}`, rows: { decimal: a.n.toString(), hex: `0x${a.n.toString(16).toUpperCase().padStart(bits / 4, '0')}`, binary: a.v === 4 ? bin.match(/.{8}/g).join('.') : bin.match(/.{16}/g).join(':'), ipv6: a.v === 4 ? `::ffff:${Net.ipv4Text(a.n)}` : 'Already IPv6', expanded: a.v === 6 ? Net.ipv6Full(a.n) : 'For IPv6 addresses', type: t.type, cls: t.cls }, steps: ['An IPv4 address is one 32-bit number written as four bytes; IPv6 is 128 bits written as eight 16-bit hex groups', 'IPv6 text follows RFC 5952: lowercase, leading zeros dropped, the longest run of zero groups shortened to ::'] };
        },
    },
    ip_subnet: {
        type: 'calc',
        inputs: { ip: LINE('IP address with prefix or mask', '192.168.10.77/26'), split: N('Split into how many subnets (optional)', 4, 0) },
        optional: ['split'],
        label: 'Network',
        rows: { range: 'Usable host range', broadcast: 'Broadcast address', hosts: 'Usable hosts', mask: 'Subnet mask', wildcard: 'Wildcard mask', binary: 'Mask in binary', type: 'Address type' },
        grids: [['subnets', 'Subnets after splitting']],
        run: (x) => {
            const c = Net.parseCidr(x.ip, 24);

            if (c.problem) {
                return { error: c.problem };
            }

            const r = Net.network(c);
            const t = (n) => Net.addrText(c.v, n);
            const rows = [];

            if (Number.isInteger(x.split) && x.split > 1) {
                const extra = Math.ceil(Math.log2(x.split));
                const p = c.prefix + extra;

                if (p <= Net.bitsOf(c.v)) {
                    for (let k = 0n; k < 2n ** BigInt(extra) && k < 256n; k += 1n) {
                        const sub = Net.network({ v: c.v, n: r.net + k * (1n << BigInt(Net.bitsOf(c.v) - p)), prefix: p });
                        rows.push({ header: `${t(sub.net)}/${p}`, cells: [`${t(sub.first)} – ${t(sub.lastHost)}`, sub.usable.toLocaleString('en-US')] });
                    }
                }
            }

            return { value: `${t(r.net)}/${c.prefix}`, sub: `${r.size.toLocaleString('en-US')} addresses`, rows: { range: `${t(r.first)} – ${t(r.lastHost)}`, broadcast: c.v === 4 ? t(r.last) : 'IPv6 has no broadcast (last address shown in the range)', hosts: r.usable.toLocaleString('en-US'), mask: c.v === 4 ? Net.ipv4Text(r.mask) : `/${c.prefix}`, wildcard: c.v === 4 ? Net.ipv4Text(r.wildcard) : '—', binary: c.v === 4 ? r.mask.toString(2).padStart(32, '0').match(/.{8}/g).join('.') : '—', type: Net.addressType(c.v, c.n).type }, steps: ['Network = address AND mask; broadcast = network OR wildcard', c.v === 4 ? 'Usable hosts = 2^(32 − prefix) − 2 (network and broadcast are reserved; /31 and /32 are special, RFC 3021)' : 'IPv6 subnets are normally /64', ...(rows.length ? [`Splitting into ${rows.length} subnets borrows ${Math.log2(rows.length)} bits: /${c.prefix + Math.log2(rows.length)}`] : [])], grids: { subnets: { columns: ['Hosts', 'Usable'], rows } } };
        },
    },
    cidr: {
        type: 'calc',
        inputs: { mode: SEL('Calculate', { block: 'A CIDR block', range: 'CIDR blocks covering a range' }, 'block'), cidr: LINE('CIDR (address/prefix)', '10.20.0.0/14'), start: LINE('First address', '192.168.1.10'), end: LINE('Last address', '192.168.1.100') },
        show: { cidr: 'mode:block', start: 'mode:range', end: 'mode:range' },
        label: 'Result',
        rows: { first: 'First address', last: 'Last address', count: 'Addresses', mask: 'Netmask', note: 'Note' },
        grids: [['blocks', 'CIDR blocks']],
        run: (x) => {
            if (x.mode === 'range') {
                const a = Net.parseAddress(x.start);
                const b = Net.parseAddress(x.end);

                if (!a || !b || a.v !== b.v || a.n > b.n) {
                    return { error: 'Enter two addresses of the same family, the first not after the last.' };
                }

                const blocks = Net.rangeToCidrs(a.v, a.n, b.n);

                return { value: blocks.length === 1 ? `${Net.addrText(a.v, blocks[0].net)}/${blocks[0].prefix}` : `${blocks.length} blocks`, sub: 'The fewest CIDR blocks that cover exactly this range', rows: { first: Net.addrText(a.v, a.n), last: Net.addrText(a.v, b.n), count: (b.n - a.n + 1n).toLocaleString('en-US'), mask: '—', note: 'A range rarely fits one block; aggregate routes need aligned boundaries' }, steps: ['Take the largest block that starts at the current address and stays inside the range, then repeat (RFC 4632)'], grids: { blocks: { columns: ['Addresses'], rows: blocks.map((c) => ({ header: `${Net.addrText(a.v, c.net)}/${c.prefix}`, cells: [(1n << BigInt(Net.bitsOf(a.v) - c.prefix)).toLocaleString('en-US')] })) } } };
            }

            const c = Net.parseCidr(x.cidr, 32);

            if (c.problem) {
                return { error: c.problem };
            }

            const r = Net.network(c);
            const aligned = r.net === c.n;

            return { value: `${Net.addrText(c.v, r.net)}/${c.prefix}`, sub: aligned ? 'Valid CIDR block' : `The address is inside the block starting at ${Net.addrText(c.v, r.net)}`, rows: { first: Net.addrText(c.v, r.net), last: Net.addrText(c.v, r.last), count: r.size.toLocaleString('en-US'), mask: c.v === 4 ? Net.ipv4Text(r.mask) : `/${c.prefix}`, note: c.v === 4 ? `${c.prefix <= 8 ? 'Very large (class-A sized)' : c.prefix <= 16 ? 'Large' : c.prefix <= 24 ? 'Medium' : 'Small'} block` : 'IPv6 sites usually get a /48 and LANs a /64' }, steps: ['A /n block holds 2^(bits − n) addresses and starts at a multiple of its size'], grids: { blocks: { columns: ['Addresses'], rows: [{ header: `${Net.addrText(c.v, r.net)}/${c.prefix}`, cells: [r.size.toLocaleString('en-US')] }] } } };
        },
    },
    streaming_bitrate: {
        type: 'calc',
        inputs: { res: SEL('Resolution', 'data:youtube:fixed', '1080'), fps: SEL('Frame rate', { std: '24–30 fps', high: '48–60 fps' }, 'std'), use: SEL('For', { upload: 'Uploading a video (SDR)', live: 'Live streaming (H.264)' }, 'live'), audio: RATE('Audio bitrate', 160, 'kbps') },
        data: ['youtube'],
        label: 'Recommended video bitrate',
        rows: { total: 'Video + audio', upload: 'Upload speed to have', perHour: 'Data per hour' },
        run: (x, ctx) => {
            const row = ctx.c.data.technology?.youtube?.[x.res];

            if (!row) {
                return { error: 'Choose a resolution.' };
            }

            const mbps = x.use === 'live' ? (x.fps === 'high' ? row.live60 : row.live30) : x.fps === 'high' ? row.high : row.std;
            const total = mbps * 1e6 + x.audio;

            return { value: `${num(mbps, 4)} Mbit/s`, sub: `${row.name}, ${x.fps === 'high' ? '48–60' : '24–30'} fps, ${x.use === 'live' ? 'live' : 'upload'}`, rows: { total: rateText(total), upload: rateText(total * 1.5), perHour: sizeText((total * 3600) / 8) }, steps: [x.use === 'live' ? 'YouTube Live recommended maximum for H.264 (AV1/HEVC need less)' : 'YouTube recommended upload bitrate for SDR video', 'Have about 1.5× the stream bitrate in upload speed so the stream does not stall', 'Source: YouTube Help (read October 2026); other platforms publish their own limits'] };
        },
    },
    uptime: {
        type: 'calc',
        inputs: { uptime: N('Uptime (%)', 99.9, 0) },
        label: 'Downtime allowed per year',
        rows: { day: 'Per day', week: 'Per week', month: 'Per month (30.44 days)', quarter: 'Per quarter', nines: 'Nines' },
        grids: [['table', 'The nines']],
        run: (x) => {
            if (!(x.uptime >= 0 && x.uptime <= 100)) {
                return { error: 'Uptime is a percentage from 0 to 100.' };
            }

            const down = 1 - x.uptime / 100;
            const t = (s) => Net.duration(s * down);

            return { value: t(365.2425 * 86400), sub: `at ${num(x.uptime)}% uptime`, rows: { day: t(86400), week: t(604800), month: t(2629746), quarter: t(7889238), nines: down > 0 ? num(-Math.log10(down), 3) : '∞' }, steps: ['Downtime = (1 − uptime) × period', 'A year here is 365.2425 days'], grids: { table: { columns: ['Per year', 'Per month', 'Per day'], rows: [[90, 'one nine'], [99, 'two nines'], [99.9, 'three nines'], [99.95, ''], [99.99, 'four nines'], [99.999, 'five nines']].map(([u, label]) => ({ header: `${u}%${label ? ` (${label})` : ''}`, cells: [Net.duration(365.2425 * 86400 * (1 - u / 100)), Net.duration(2629746 * (1 - u / 100)), Net.duration(86400 * (1 - u / 100))], highlight: u === x.uptime })) } } };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
