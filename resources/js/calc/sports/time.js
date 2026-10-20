/**
 * Time and pace helpers for the Sports section.
 */

/** "1:23:45", "23:45", "45.5" (minutes) or "1:52.3" → seconds; NaN when unreadable. */
export function parseTime(text, plainUnit = 60) {
    const s = String(text ?? '').trim();

    if (!s) {
        return NaN;
    }

    if (!s.includes(':')) {
        const v = Number(s);

        return Number.isFinite(v) && v >= 0 ? v * plainUnit : NaN;
    }

    const parts = s.split(':').map(Number);

    if (parts.length > 3 || parts.some((p) => !Number.isFinite(p) || p < 0)) {
        return NaN;
    }

    return parts.reduce((total, p) => total * 60 + p, 0);
}

/** Seconds → "1:02:03", "2:03" or "2:03.4" (with `tenths`). */
export function fmtTime(sec, tenths = false) {
    if (!Number.isFinite(sec)) {
        return '—';
    }

    const sign = sec < 0 ? '−' : '';
    let t = Math.abs(sec);
    t = tenths ? Math.round(t * 10) / 10 : Math.round(t);
    const h = Math.floor(t / 3600);
    const m = Math.floor((t % 3600) / 60);
    const s = t - h * 3600 - m * 60;
    const ss = tenths ? s.toFixed(1).padStart(4, '0') : String(Math.round(s)).padStart(2, '0');

    return h > 0 ? `${sign}${h}:${String(m).padStart(2, '0')}:${ss}` : `${sign}${m}:${ss}`;
}

/** Pace in seconds per km → "5:00 /km" with the per-mile form. */
export const paceText = (secPerKm) => `${fmtTime(secPerKm)} /km (${fmtTime(secPerKm * 1.609344)} /mi)`;

export const KM_PER_MI = 1.609344;

/** Standard race distances in metres. */
export const RACES = { '1500': ['1500 m', 1500], mile: ['1 mile', 1609.344], '3k': ['3 km', 3000], '5k': ['5 km', 5000], '8k': ['8 km', 8000], '10k': ['10 km', 10000], '15k': ['15 km', 15000], '10mi': ['10 miles', 16093.44], half: ['Half marathon', 21097.5], marathon: ['Marathon', 42195] };

/** Jack Daniels & Jimmy Gilbert (Oxygen Power, 1979): oxygen cost of running at v m/min and the fraction of VO₂max sustainable for t minutes. */
export const vo2Cost = (v) => -4.6 + 0.182258 * v + 0.000104 * v * v;
export const sustainable = (tMin) => 0.8 + 0.1894393 * Math.exp(-0.012778 * tMin) + 0.2989558 * Math.exp(-0.1932605 * tMin);

/** VDOT from a race of `metres` in `seconds`. */
export function vdot(metres, seconds) {
    const t = seconds / 60;

    return vo2Cost(metres / t) / sustainable(t);
}

/** Running speed (m/min) that costs `vo2` ml/kg/min (inverse of the oxygen-cost curve). */
export function speedForVo2(vo2) {
    const a = 0.000104;
    const b = 0.182258;
    const c = -4.6 - vo2;

    return (-b + Math.sqrt(b * b - 4 * a * c)) / (2 * a);
}

/** Time (s) to race `metres` at a given VDOT, by bisection on the Daniels equations. */
export function raceTime(V, metres) {
    let lo = 60;
    let hi = 60 * 60 * 12;

    for (let k = 0; k < 100; k += 1) {
        const mid = (lo + hi) / 2;

        if (vdot(metres, mid) > V) {
            lo = mid;
        } else {
            hi = mid;
        }
    }

    return (lo + hi) / 2;
}
