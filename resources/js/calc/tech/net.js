/**
 * Networking: IPv4 (RFC 791) and IPv6 (RFC 4291, text form RFC 5952) parsing and formatting, CIDR blocks
 * (RFC 4632), subnet splitting, address types (RFC 1918, RFC 6890 special-purpose registry), and data-rate maths.
 * Addresses are BigInt so IPv4 and IPv6 share the same code.
 */

/** Parses dotted IPv4 ("192.168.1.10"); returns a BigInt or null. */
export function parseIPv4(text) {
    const parts = String(text ?? '').trim().split('.');

    if (parts.length !== 4 || !parts.every((p) => /^\d{1,3}$/.test(p) && Number(p) <= 255)) {
        return null;
    }

    return parts.reduce((acc, p) => (acc << 8n) | BigInt(p), 0n);
}

export const ipv4Text = (n) => [24n, 16n, 8n, 0n].map((s) => ((n >> s) & 255n).toString()).join('.');

/** Parses IPv6 (with :: and an optional embedded IPv4 tail); returns a BigInt or null. */
export function parseIPv6(text) {
    let s = String(text ?? '').trim().replace(/^\[|\]$/g, '').split('%')[0];
    const v4 = s.match(/(\d+\.\d+\.\d+\.\d+)$/);

    if (v4) {
        const n = parseIPv4(v4[1]);

        if (n === null) {
            return null;
        }

        s = `${s.slice(0, -v4[1].length)}${(n >> 16n).toString(16)}:${(n & 0xffffn).toString(16)}`;
    }

    if ((s.match(/::/g) ?? []).length > 1) {
        return null;
    }

    const [head, tail] = s.includes('::') ? s.split('::') : [s, null];
    const h = head ? head.split(':') : [];
    const t = tail ? tail.split(':') : [];
    const missing = 8 - h.length - t.length;

    if ((tail === null && h.length !== 8) || (tail !== null && missing < 1)) {
        return null;
    }

    const groups = [...h, ...(tail !== null ? new Array(missing).fill('0') : []), ...t];

    if (groups.length !== 8 || !groups.every((g) => /^[0-9a-f]{1,4}$/i.test(g))) {
        return null;
    }

    return groups.reduce((acc, g) => (acc << 16n) | BigInt(`0x${g}`), 0n);
}

/** RFC 5952 canonical IPv6 text (lowercase, longest run of two or more zero groups as ::). */
export function ipv6Text(n) {
    if (n >> 32n === 0xffffn) {
        return `::ffff:${ipv4Text(n & 0xffffffffn)}`;
    }

    const groups = Array.from({ length: 8 }, (_, i) => Number((n >> BigInt(16 * (7 - i))) & 0xffffn));
    let best = [-1, 0];
    let run = [-1, 0];

    groups.forEach((g, i) => {
        if (g === 0) {
            run = run[0] < 0 ? [i, 1] : [run[0], run[1] + 1];

            if (run[1] > best[1]) {
                best = [...run];
            }
        } else {
            run = [-1, 0];
        }
    });

    const hex = groups.map((g) => g.toString(16));

    if (best[1] < 2) {
        return hex.join(':');
    }

    return `${hex.slice(0, best[0]).join(':')}::${hex.slice(best[0] + best[1]).join(':')}`;
}

export const ipv6Full = (n) => Array.from({ length: 8 }, (_, i) => ((n >> BigInt(16 * (7 - i))) & 0xffffn).toString(16).padStart(4, '0')).join(':');

/**
 * Reads an address in any form: dotted IPv4, IPv6, a decimal integer, 0x hex or 32-bit binary (dotted or not).
 * Returns { v: 4 | 6, n } or null.
 */
export function parseAddress(text) {
    const s = String(text ?? '').trim();
    const v4 = parseIPv4(s);

    if (v4 !== null) {
        return { v: 4, n: v4 };
    }

    if (s.includes(':')) {
        const v6 = parseIPv6(s);

        return v6 === null ? null : { v: 6, n: v6 };
    }

    if (/^[01]{8}(\.?[01]{8}){3}$/.test(s)) {
        return { v: 4, n: BigInt(`0b${s.replace(/\./g, '')}`) };
    }

    if (/^0x[0-9a-f]{1,32}$/i.test(s)) {
        const n = BigInt(s);

        return { v: n < 2n ** 32n ? 4 : 6, n };
    }

    if (/^\d+$/.test(s)) {
        const n = BigInt(s);

        return n < 2n ** 32n ? { v: 4, n } : n < 2n ** 128n ? { v: 6, n } : null;
    }

    return null;
}

export const bitsOf = (v) => (v === 4 ? 32 : 128);
export const addrText = (v, n) => (v === 4 ? ipv4Text(n) : ipv6Text(n));

/** Mask BigInt for a prefix length. */
export const maskOf = (v, prefix) => (((1n << BigInt(prefix)) - 1n) << BigInt(bitsOf(v) - prefix));

/** Reads "a.b.c.d/nn", "a.b.c.d 255.255.255.0" or an IPv6 prefix. Returns { v, n, prefix } or { problem }. */
export function parseCidr(text, fallbackPrefix) {
    const s = String(text ?? '').trim();
    let [addr, pre] = s.split(/\s*\/\s*|\s+/);
    const a = parseAddress(addr);

    if (!a) {
        return { problem: 'Enter an IPv4 or IPv6 address, e.g. 192.168.1.10/24.' };
    }

    if (pre === undefined) {
        pre = fallbackPrefix;
    }

    let prefix;

    if (a.v === 4 && /^\d+\.\d+\.\d+\.\d+$/.test(String(pre))) {
        const m = parseIPv4(pre);
        const bits = m.toString(2).padStart(32, '0');

        if (!/^1*0*$/.test(bits)) {
            return { problem: 'That subnet mask is not contiguous (e.g. 255.255.255.0).' };
        }

        prefix = bits.indexOf('0') < 0 ? 32 : bits.indexOf('0');
    } else {
        prefix = Number(pre);
    }

    if (!Number.isInteger(prefix) || prefix < 0 || prefix > bitsOf(a.v)) {
        return { problem: `The prefix must be 0 to ${bitsOf(a.v)}.` };
    }

    return { ...a, prefix };
}

/** Network facts for an address and prefix. */
export function network({ v, n, prefix }) {
    const bits = bitsOf(v);
    const mask = maskOf(v, prefix);
    const all = (1n << BigInt(bits)) - 1n;
    const net = n & mask;
    const last = net | (all ^ mask);
    const size = 1n << BigInt(bits - prefix);
    const usable = v === 4 ? (prefix >= 31 ? size : size - 2n) : size;
    const first = v === 4 && prefix < 31 ? net + 1n : net;
    const lastHost = v === 4 && prefix < 31 ? last - 1n : last;

    return { v, prefix, net, last, size, usable, first, lastHost, mask, wildcard: all ^ mask };
}

/** Smallest list of CIDR blocks exactly covering an address range. */
export function rangeToCidrs(v, start, end) {
    const bits = bitsOf(v);
    const out = [];
    let cur = start;

    while (cur <= end) {
        let size = 0;

        while (size < bits && (cur & ((1n << BigInt(size + 1)) - 1n)) === 0n && cur + (1n << BigInt(size + 1)) - 1n <= end) {
            size += 1;
        }

        out.push({ net: cur, prefix: bits - size });
        cur += 1n << BigInt(size);

        if (out.length > 256) {
            break;
        }
    }

    return out;
}

/** Address type from the IANA special-purpose registries (RFC 6890 and updates). */
export function addressType(v, n) {
    const inNet = (text) => {
        const c = parseCidr(text);

        return (n & maskOf(c.v, c.prefix)) === (c.n & maskOf(c.v, c.prefix));
    };

    if (v === 4) {
        const table = [['127.0.0.0/8', 'Loopback'], ['10.0.0.0/8', 'Private (RFC 1918)'], ['172.16.0.0/12', 'Private (RFC 1918)'], ['192.168.0.0/16', 'Private (RFC 1918)'], ['100.64.0.0/10', 'Shared address space / carrier-grade NAT (RFC 6598)'], ['169.254.0.0/16', 'Link-local (RFC 3927)'], ['0.0.0.0/8', '“This network” (RFC 791)'], ['192.0.2.0/24', 'Documentation (TEST-NET-1)'], ['198.51.100.0/24', 'Documentation (TEST-NET-2)'], ['203.0.113.0/24', 'Documentation (TEST-NET-3)'], ['198.18.0.0/15', 'Benchmarking (RFC 2544)'], ['224.0.0.0/4', 'Multicast'], ['255.255.255.255/32', 'Limited broadcast'], ['240.0.0.0/4', 'Reserved (class E)']];
        const hit = table.find(([c]) => inNet(c));
        const first = Number(n >> 24n);
        const cls = first < 128 ? 'A' : first < 192 ? 'B' : first < 224 ? 'C' : first < 240 ? 'D (multicast)' : 'E (reserved)';

        return { type: hit ? hit[1] : 'Public (globally routable)', cls };
    }

    const table = [['::1/128', 'Loopback'], ['::/128', 'Unspecified'], ['::ffff:0:0/96', 'IPv4-mapped'], ['64:ff9b::/96', 'IPv4/IPv6 translation (NAT64)'], ['fe80::/10', 'Link-local'], ['fc00::/7', 'Unique local (private)'], ['ff00::/8', 'Multicast'], ['2001:db8::/32', 'Documentation'], ['2002::/16', '6to4'], ['2001::/32', 'Teredo'], ['2000::/3', 'Global unicast']];
    const hit = table.find(([c]) => inNet(c));

    return { type: hit ? hit[1] : 'Reserved', cls: '—' };
}

/** Bits and bytes: decimal (kB = 1000) or binary (KiB = 1024) units, in bits. */
export const DATA_UNITS = {
    b: ['bit', 1], kb: ['kilobit (kb)', 1e3], mb: ['megabit (Mb)', 1e6], gb: ['gigabit (Gb)', 1e9], tb: ['terabit (Tb)', 1e12],
    B: ['byte (B)', 8], kB: ['kilobyte (kB)', 8e3], MB: ['megabyte (MB)', 8e6], GB: ['gigabyte (GB)', 8e9], TB: ['terabyte (TB)', 8e12],
    KiB: ['kibibyte (KiB)', 8 * 1024], MiB: ['mebibyte (MiB)', 8 * 1024 ** 2], GiB: ['gibibyte (GiB)', 8 * 1024 ** 3], TiB: ['tebibyte (TiB)', 8 * 1024 ** 4],
};
export const RATE_UNITS = { bps: ['bit/s', 1], kbps: ['kbit/s', 1e3], mbps: ['Mbit/s (Mbps)', 1e6], gbps: ['Gbit/s (Gbps)', 1e9], Bps: ['byte/s', 8], kBps: ['kB/s', 8e3], MBps: ['MB/s', 8e6], GBps: ['GB/s', 8e9] };

/** Human time text: "2 h 03 min 05 s" or "0.42 s". */
export function duration(seconds) {
    if (!Number.isFinite(seconds)) {
        return '—';
    }

    if (seconds < 60) {
        return `${Number(seconds.toPrecision(4))} s`;
    }

    const d = Math.floor(seconds / 86400);
    const h = Math.floor((seconds % 86400) / 3600);
    const m = Math.floor((seconds % 3600) / 60);
    const s = Math.round(seconds % 60);

    return [d ? `${d} d` : '', h || d ? `${h} h` : '', `${String(m).padStart(d || h ? 2 : 1, '0')} min`, `${String(s).padStart(2, '0')} s`].filter(Boolean).join(' ');
}
