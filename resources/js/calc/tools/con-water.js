import { FT, FT3, GAL, IN, LB, capVolume, segmentArea, shapeArea } from '../construction/geometry.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Tanks, pools, ponds, pipes and flow. Lengths arrive in meters, volumes in liters, time in seconds.
 */
const WATER = 998.2; // kg/m³ at 20 °C
const gallons = (m3) => m3 / GAL;

function volumeRows(m3, f, flow) {
    const rows = {
        liters: `${f(m3 * 1000)} L`,
        ft3: `${f(m3 / FT3)} ft³ (${f(m3)} m³)`,
        weight: `${f((m3 * WATER) / LB)} lb of water (${f(m3 * WATER)} kg)`,
    };

    if (flow !== undefined) {
        rows.fill = flow > 0 ? `${f(m3 / flow / 3600)} h at ${f((flow / GAL) * 60)} gal/min` : 'Enter a fill rate';
    }

    return rows;
}

/**
 * Liquid volume (m³) in a tank at fill height h, and its full volume.
 */
export function tankVolume(type, d, length, height, h, coneHeight = 0) {
    const r = d / 2;

    switch (type) {
        case 'vertical':
            return { total: Math.PI * r * r * length, filled: Math.PI * r * r * Math.min(h, length), depth: length };
        case 'horizontal':
            return { total: Math.PI * r * r * length, filled: segmentArea(r, Math.min(h, d)) * length, depth: d };
        case 'rectangle':
            return { total: d * length * height, filled: d * length * Math.min(h, height), depth: height };
        case 'capsule_h': {
            const sphere = (4 / 3) * Math.PI * r ** 3;
            const hh = Math.min(h, d);

            return { total: Math.PI * r * r * length + sphere, filled: segmentArea(r, hh) * length + capVolume(r, hh), depth: d };
        }
        case 'capsule_v': {
            const total = Math.PI * r * r * length + (4 / 3) * Math.PI * r ** 3;
            let filled;

            if (h <= r) {
                filled = capVolume(r, h);
            } else if (h <= r + length) {
                filled = (2 / 3) * Math.PI * r ** 3 + Math.PI * r * r * (h - r);
            } else {
                filled = total - capVolume(r, Math.max(2 * r + length - h, 0));
            }

            return { total, filled, depth: length + d };
        }
        case 'cone': {
            const cone = (Math.PI * r * r * coneHeight) / 3;
            const total = cone + Math.PI * r * r * length;
            let filled;

            if (h <= coneHeight) {
                filled = (Math.PI * (r * (h / coneHeight)) ** 2 * h) / 3;
            } else {
                filled = cone + Math.PI * r * r * Math.min(h - coneHeight, length);
            }

            return { total, filled, depth: coneHeight + length };
        }
        case 'sphere': {
            return { total: (4 / 3) * Math.PI * r ** 3, filled: capVolume(r, Math.min(h, d)), depth: d };
        }
        default:
            return null;
    }
}

export const handlers = {
    tank: (i, c, f) => {
        const type = i.tank;
        const needsLength = !['sphere'].includes(type);

        if (!(i.diameter > 0) || (needsLength && !(i.length > 0)) || (type === 'rectangle' && !(i.height > 0)) || (type === 'cone' && !(i.cone > 0))) {
            return { empty: 'Enter every size of the tank.' };
        }

        const full = tankVolume(type, i.diameter, i.length, i.height, Infinity, i.cone);
        const level = i.fill >= 0 && i.fill !== '' && !Number.isNaN(i.fill) ? Math.min(i.fill, full.depth) : full.depth;
        const now = tankVolume(type, i.diameter, i.length, i.height, level, i.cone);
        const chart = Array.from({ length: 11 }, (_, k) => {
            const h = (full.depth * k) / 10;
            const v = tankVolume(type, i.diameter, i.length, i.height, h, i.cone).filled;

            return { label: `${f(h / IN)} in (${k * 10}% of depth)`, value: `${f(gallons(v))} gal (${f((v / full.total) * 100)}%)`, highlight: Math.abs(h - level) < full.depth / 20 };
        });

        return {
            value: f(gallons(now.filled)),
            unit: 'gal',
            label: level < full.depth ? 'Liquid in the tank' : 'Tank capacity',
            sub: `${f((now.filled / full.total) * 100)}% of ${f(gallons(full.total))} gal capacity`,
            rows: { capacity: `${f(gallons(full.total))} gal (${f(full.total * 1000)} L)`, ...volumeRows(now.filled, f), empty: `${f(gallons(full.total - now.filled))} gal of space left` },
            lists: { chart },
        };
    },

    pool: (i, c, f) => {
        const plan = shapeArea(i.shape, i);

        if (plan.empty || plan.error) {
            return plan;
        }

        const area = plan.area;

        if (!(area > 0) || !(i.shallow > 0)) {
            return { empty: 'Enter the pool size and depths.' };
        }

        const deep = i.deep > 0 ? i.deep : i.shallow;
        const volume = area * ((i.shallow + deep) / 2);

        return {
            value: f(gallons(volume)),
            unit: 'gal',
            label: 'Pool volume',
            sub: `${f(area / 0.09290304)} ft² × ${f(((i.shallow + deep) / 2) / FT)} ft average depth`,
            rows: volumeRows(volume, f, i.flow > 0 ? (i.flow * GAL) / 60 : 0),
        };
    },

    round_pool: (i, c, f) => {
        if (missing(i, 'diameter', 'depth') || !(i.diameter > 0) || !(i.depth > 0)) {
            return { empty: 'Enter the diameter and water depth.' };
        }

        const volume = (Math.PI / 4) * i.diameter ** 2 * i.depth;

        return { value: f(gallons(volume)), unit: 'gal', label: 'Pool volume', sub: `π ÷ 4 × ${f(i.diameter / FT)}² ft × ${f(i.depth / IN)} in`, rows: volumeRows(volume, f, i.flow > 0 ? (i.flow * GAL) / 60 : 0) };
    },

    pond: (i, c, f) => {
        const plan = shapeArea(i.shape, i);

        if (plan.empty || plan.error) {
            return plan;
        }

        if (!(i.average > 0) || !(i.max_depth > 0)) {
            return { empty: 'Enter the average and deepest depth.' };
        }

        const volume = plan.area * i.average;
        const overlap = i.overlap > 0 ? i.overlap : 0;
        const [L, W] = i.shape === 'circle' ? [i.diameter, i.diameter] : [i.length, i.width];
        const linerL = L + 2 * i.max_depth + 2 * overlap;
        const linerW = W + 2 * i.max_depth + 2 * overlap;
        const pump = i.turnover > 0 ? gallons(volume) / i.turnover : null;

        return {
            value: f(gallons(volume)),
            unit: 'gal',
            label: 'Pond volume',
            sub: `${f(plan.area / 0.09290304)} ft² × ${f(i.average / FT)} ft average depth`,
            rows: {
                liner: `${f(linerL / FT)} × ${f(linerW / FT)} ft liner (${f(linerL)} × ${f(linerW)} m)`,
                pump: pump === null ? 'Enter a turnover time' : `${f(pump)} gal/h to turn it over every ${f(i.turnover)} h`,
                ...volumeRows(volume, f),
            },
        };
    },

    pipe_volume: (i, c, f) => {
        let id;

        if (i.mode === 'nps') {
            const size = c.data.pipe.sizes[i.nps];
            const wall = size?.wall[i.schedule];

            if (!wall) {
                return { error: `NPS ${i.nps} is not made in ${c.data.pipe.schedules[i.schedule]}.` };
            }

            id = (size.od - 2 * wall) * IN;
        } else {
            id = i.id;
        }

        if (!(id > 0) || !(i.length > 0)) {
            return { empty: 'Enter the inside diameter and length.' };
        }

        const perLength = (Math.PI / 4) * id ** 2;
        const volume = perLength * i.length;

        return {
            value: f(gallons(volume)),
            unit: 'gal',
            label: 'Pipe volume',
            sub: `${f(id / IN)} in inside diameter × ${f(i.length / FT)} ft`,
            rows: { per_foot: `${f(gallons(perLength * FT))} gal per ft (${f(perLength * 1000)} L/m)`, id: `${f(id / IN)} in (${f(id * 1000)} mm)`, ...volumeRows(volume, f) },
        };
    },

    gpm: (i, c, f) => {
        let flow;
        let sub;

        if (i.mode === 'bucket') {
            if (!(i.volume > 0) || !(i.time > 0)) {
                return { empty: 'Enter the volume collected and the time it took.' };
            }

            flow = i.volume / 1000 / i.time;
            sub = `${f(i.volume / 1000 / GAL)} gal in ${f(i.time)} s`;
        } else {
            if (!(i.id > 0) || !(i.velocity > 0)) {
                return { empty: 'Enter the pipe inside diameter and the water velocity.' };
            }

            flow = (Math.PI / 4) * i.id ** 2 * i.velocity;
            sub = `Q = A × v: ${f(i.id / IN)} in pipe at ${f(i.velocity / FT)} ft/s`;
        }

        const gpm = (flow / GAL) * 60;

        return {
            value: f(gpm),
            unit: 'gal/min',
            label: 'Flow rate',
            sub,
            rows: { lpm: `${f(flow * 60000)} L/min`, m3h: `${f(flow * 3600)} m³/h`, gph: `${f(gpm * 60)} gal/h`, cfs: `${f(flow / FT3)} ft³/s`, uk: `${f((flow * 60000) / 4.54609)} UK gal/min` },
        };
    },
};

export default defineTools(handlers);
