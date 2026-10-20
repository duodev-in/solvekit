import { defineTools } from '../engines/formula.js';
import { airViscosity, dewPoint, humidityRatio, psychro, satPressure, standardAtmosphere, waterDensity, wetBulb } from '../physics/air.js';
import { bisect, D, handlersFor, K, num, pw } from '../physics/core.js';

/**
 * Atmospheric physics and thermodynamics.
 */
const R = K.R;
const g0 = K.g0;
const C = (T) => T - 273.15;
const fmtC = (T) => `${num(C(T), 4)} °C`;
const gas = (ctx, key) => ctx.c.data.physics.gases[key];
const thermal = (ctx, key) => ctx.c.data.physics.thermal[key];

/** Moist-air state inputs: dry bulb plus relative humidity, dew point or wet bulb, and pressure. */
const HUMID = {
    T: ['Air temperature', 'temperature', 'c', 25],
    by: ['Humidity given as', 'select', { rh: 'Relative humidity', dew: 'Dew point', wet: 'Wet-bulb temperature' }, 'rh'],
    rh: ['Relative humidity (%)', null, null, 50, 0],
    Td: ['Dew point', 'temperature', 'c', 13.9],
    Tw: ['Wet-bulb temperature', 'temperature', 'c', 17.9],
    p: ['Air pressure', 'pressure', 'kpa', 101.325],
};
const HUMID_SHOW = { rh: 'by:rh', Td: 'by:dew', Tw: 'by:wet' };
const HUMID_WHEN = { rh: (x) => x.by === 'rh', Td: (x) => x.by === 'dew', Tw: (x) => x.by === 'wet' };

/** Vapour pressure (Pa) from the moist-air inputs. */
function vapour(x) {
    if (x.by === 'rh') {
        return (x.rh / 100) * satPressure(x.T);
    }

    if (x.by === 'dew') {
        return satPressure(x.Td);
    }

    const tw = C(x.Tw);
    const t = C(x.T);
    const Ws = humidityRatio(satPressure(x.Tw), x.p);
    const W = tw >= 0 ? ((2501 - 2.326 * tw) * Ws - 1.006 * (t - tw)) / (2501 + 1.86 * t - 4.186 * tw) : ((2830 - 0.24 * tw) * Ws - 1.006 * (t - tw)) / (2830 + 1.86 * t - 2.1 * tw);

    return (W * x.p) / (0.621945 + W);
}

/** Moist-air state or an error outcome. */
function moist(x) {
    const pv = vapour(x);

    if (!(pv >= 0) || pv > satPressure(x.T) * 1.0001) {
        return { error: 'Those values are not possible: the humidity would exceed 100% (dew point and wet bulb cannot be above the air temperature).' };
    }

    return { s: psychro(x.T, pv, x.p) };
}

/** Gas law with two states: law out = in × (ratio) — e.g. Boyle, Charles, Gay-Lussac, Avogadro. */
function twoState({ vars, eq, solve, forms, def, rows, extra }) {
    return { type: 'law', vars, default: def, eq, forms, solve, rows, extra };
}

const LAYER_SAMPLE = '100, 0.72\n100, 0.035\n12.5, 0.17';

/** Wall layers "thickness mm, k W/mK" per line. */
function readLayers(text) {
    const rows = String(text ?? '').split(/\n|;/).map((l) => l.trim()).filter(Boolean).map((l) => l.split(/[,\s]+/).map(Number));

    return rows.length && rows.every((r) => r.length === 2 && r[0] > 0 && r[1] > 0) ? rows : null;
}

const GAS = (def = 'air') => ['Gas', 'select', 'data:gases', def];

export const TOOLS = {
    // Atmospheric physics ------------------------------------------------------------------------
    absolute_humidity: {
        type: 'calc',
        inputs: HUMID,
        show: HUMID_SHOW,
        when: HUMID_WHEN,
        label: 'Absolute humidity',
        rows: { rh: 'Relative humidity', dew: 'Dew point', W: 'Mixing ratio', pv: 'Vapour pressure' },
        run: (x) => {
            const m = moist(x);

            if (m.error) {
                return m;
            }

            const { s } = m;

            return { value: num(s.abs * 1000, 5), unit: 'g/m³', sub: `${num(s.rh * 100, 4)}% RH at ${fmtC(x.T)}`, rows: { rh: `${num(s.rh * 100, 4)}%`, dew: fmtC(s.dew), W: `${num(s.W * 1000, 4)} g/kg`, pv: `${num(s.pv)} Pa` }, steps: ['AH = e ÷ (R_v T), R_v = 461.5 J/(kg·K)', `e = ${num(s.pv)} Pa (Hyland–Wexler saturation pressure, ASHRAE)`, `AH = ${num(s.abs * 1000)} g/m³`] };
        },
    },
    air_density: {
        type: 'calc',
        inputs: { ...HUMID, rh: ['Relative humidity (%)', null, null, 0, 0] },
        show: HUMID_SHOW,
        when: HUMID_WHEN,
        out: 'density',
        outUnit: 'kgm3',
        label: 'Air density',
        rows: { dry: 'Dry air at the same pressure and temperature', std: 'Compared with the standard 1.225 kg/m³', Tv: 'Virtual temperature' },
        run: (x) => {
            const m = moist(x);

            if (m.error) {
                return m;
            }

            const { s } = m;

            return { value: s.rho, sub: `${num(s.rho / 1.225 * 100, 4)}% of sea-level standard`, rows: { dry: `${num(x.p / (287.058 * x.T))} kg/m³`, std: `${num((s.rho / 1.225) * 100, 4)}%`, Tv: fmtC(s.Tv) }, steps: ['ρ = (p − e) ÷ (R_d T) + e ÷ (R_v T)', `R_d = 287.058, R_v = 461.495 J/(kg·K), e = ${num(s.pv)} Pa`, `ρ = ${num(s.rho)} kg/m³ (humid air is lighter than dry air)`] };
        },
    },
    pressure_altitude: {
        type: 'calc',
        inputs: { z: ['Altitude', 'length', 'm', 1500] },
        out: 'pressure',
        outUnit: 'hpa',
        label: 'Standard air pressure',
        rows: { T: 'Standard temperature', rho: 'Air density', ratio: 'Share of sea-level pressure', boil: 'Boiling point of water' },
        run: (x) => {
            if (!(x.z >= -500 && x.z <= 86000)) {
                return { error: 'The standard atmosphere covers −500 m to 86 km.' };
            }

            const a = standardAtmosphere(x.z);
            const boil = bisect((T) => satPressure(T) - a.P, 273.15, 473.15);

            return { value: a.P, sub: `${num((a.P / 101325) * 100, 4)}% of sea level`, rows: { T: fmtC(a.T), rho: `${num(a.rho)} kg/m³`, ratio: `${num((a.P / 101325) * 100, 4)}%`, boil: fmtC(boil) }, steps: ['US Standard Atmosphere 1976 (geopotential layers)', `h = ${num(a.h)} m geopotential, T = ${num(a.T)} K`, `P = ${num(a.P)} Pa`] };
        },
    },
    cloud_base: {
        type: 'calc',
        inputs: { T: ['Surface temperature', 'temperature', 'c', 25], Td: ['Surface dew point', 'temperature', 'c', 15], elev: ['Station elevation', 'length', 'm', 0] },
        out: 'length',
        outUnit: 'm',
        label: 'Cloud base above the ground',
        rows: { msl: ['Above sea level', 'length'], ft: ['In feet', 'length'], Tbase: 'Temperature at the cloud base' },
        run: (x) => {
            const spread = x.T - x.Td;

            if (spread < 0) {
                return { error: 'The dew point cannot be above the temperature.' };
            }

            const h = 125 * spread;

            return { value: h, sub: `Spread ${num(spread)} °C × 125 m`, rows: { msl: [h + x.elev, 'length'], ft: [h, 'length'], Tbase: `${num(C(x.T) - 0.0098 * h, 3)} °C` }, steps: ['Lifted condensation level ≈ 125 m × (T − T_d) (Espy; Lawrence 2005)', `= 125 × ${num(spread)} = ${num(h)} m`, 'An estimate for convective (cumulus) cloud'] };
        },
    },
    density_altitude: {
        type: 'calc',
        inputs: { elev: ['Field elevation', 'length', 'ft', 5000], alt: ['Altimeter setting', 'pressure', 'inhg', 29.92], T: ['Outside air temperature', 'temperature', 'c', 30], Td: ['Dew point', 'temperature', 'c', 10] },
        out: 'length',
        outUnit: 'ft',
        label: 'Density altitude',
        rows: { pa: ['Pressure altitude', 'length'], station: ['Station pressure', 'pressure'], rho: 'Air density', perf: 'Performance' },
        run: (x) => {
            const hpa = x.alt / 100;
            const station = (hpa ** 0.190263 - 8.417286e-5 * x.elev) ** (1 / 0.190263) * 100;
            const pv = satPressure(x.Td);
            const rho = (station - pv) / (287.05 * x.T) + pv / (461.495 * x.T);
            const da = (44.3308 - 42.2665 * rho ** 0.234969) * 1000;
            const pa = 44330.8 * (1 - (station / 101325) ** 0.190263);

            return { value: da, sub: `${num(da / 0.3048, 5)} ft; air density ${num(rho)} kg/m³`, rows: { pa: [pa, 'length'], station: [station, 'pressure'], rho: `${num(rho)} kg/m³`, perf: da > x.elev + 1000 ? 'The aircraft performs as if much higher: longer take-off, weaker climb' : 'Close to the field elevation' }, steps: ['Station pressure from the altimeter setting and elevation (NWS)', 'Moist air density from pressure, temperature and dew point', 'DA = 44.3308 − 42.2665 ρ^0.234969 km (ISA troposphere)', `= ${num(da)} m`] };
        },
    },
    dew_point: {
        type: 'calc',
        inputs: { T: ['Air temperature', 'temperature', 'c', 25], rh: ['Relative humidity (%)', null, null, 60, 0] },
        out: 'temperature',
        outUnit: 'c',
        label: 'Dew point',
        rows: { magnus: 'Magnus formula (comparison)', spread: 'Temperature minus dew point', comfort: 'How it feels' },
        run: (x) => {
            if (!(x.rh > 0 && x.rh <= 100)) {
                return { error: 'Relative humidity must be between 0 and 100%.' };
            }

            const Td = dewPoint((x.rh / 100) * satPressure(x.T));
            const t = C(x.T);
            const g = Math.log(x.rh / 100) + (17.625 * t) / (243.04 + t);
            const magnus = (243.04 * g) / (17.625 - g);
            const td = C(Td);
            const comfort = td < 10 ? 'Dry' : td < 13 ? 'Comfortable' : td < 16 ? 'Pleasant' : td < 18 ? 'Slightly humid' : td < 21 ? 'Humid' : td < 24 ? 'Very humid' : 'Oppressive';

            return { value: Td, sub: Td < 273.15 ? 'Below freezing: frost point over ice' : comfort, rows: { magnus: `${num(magnus, 4)} °C`, spread: `${num(x.T - Td, 4)} °C`, comfort }, steps: ['e = RH × e_s(T), then solve e_s(T_d) = e', 'Saturation pressure: Hyland–Wexler (ASHRAE Fundamentals)', `T_d = ${num(td)} °C`] };
        },
    },
    heat_index: {
        type: 'calc',
        inputs: { T: ['Air temperature', 'temperature', 'c', 32], rh: ['Relative humidity (%)', null, null, 60, 0] },
        out: 'temperature',
        outUnit: 'c',
        label: 'Heat index (feels like)',
        rows: { level: 'Caution level', diff: 'Difference from the air temperature' },
        run: (x) => {
            const T = C(x.T) * 1.8 + 32;
            const RH = x.rh;
            let HI = 0.5 * (T + 61 + (T - 68) * 1.2 + RH * 0.094);

            if ((HI + T) / 2 >= 80) {
                HI = -42.379 + 2.04901523 * T + 10.14333127 * RH - 0.22475541 * T * RH - 0.00683783 * T * T - 0.05481717 * RH * RH + 0.00122874 * T * T * RH + 0.00085282 * T * RH * RH - 0.00000199 * T * T * RH * RH;

                if (RH < 13 && T >= 80 && T <= 112) {
                    HI -= ((13 - RH) / 4) * Math.sqrt((17 - Math.abs(T - 95)) / 17);
                } else if (RH > 85 && T >= 80 && T <= 87) {
                    HI += ((RH - 85) / 10) * ((87 - T) / 5);
                }
            }

            const hc = (HI - 32) / 1.8;
            const level = HI < 80 ? 'No heat stress expected' : HI < 91 ? 'Caution: fatigue with prolonged activity' : HI < 104 ? 'Extreme caution: heat cramps and exhaustion possible' : HI < 125 ? 'Danger: heat exhaustion likely' : 'Extreme danger: heat stroke likely';

            return { value: hc + 273.15, sub: `${num(HI, 4)} °F — ${level.split(':')[0]}`, rows: { level, diff: `${num(hc - C(x.T), 3)} °C` }, steps: ['NWS algorithm: Steadman simple formula, then the Rothfusz regression above 80 °F with the low- and high-humidity adjustments', `HI = ${num(HI)} °F = ${num(hc)} °C`, 'For shade and light wind; full sun can add up to 8 °C'] };
        },
    },
    air_kinematic_viscosity: {
        type: 'calc',
        inputs: { T: ['Air temperature', 'temperature', 'c', 20], p: ['Pressure', 'pressure', 'kpa', 101.325] },
        out: 'kinematic_viscosity',
        outUnit: 'm2s',
        label: 'Kinematic viscosity',
        rows: { mu: ['Dynamic viscosity', 'viscosity'], rho: 'Density (dry air)' },
        run: (x) => {
            const mu = airViscosity(x.T);
            const rho = x.p / (287.058 * x.T);

            return { value: mu / rho, sub: `μ = ${num(mu)} Pa·s`, rows: { mu: [mu, 'viscosity'], rho: `${num(rho)} kg/m³` }, steps: ['Sutherland: μ = μ₀ (T/T₀)^1.5 (T₀ + S)/(T + S), μ₀ = 1.716 × 10⁻⁵ Pa·s, T₀ = 273.15 K, S = 110.4 K', 'ν = μ ÷ ρ, ρ = p ÷ R_dT', `ν = ${num(mu / rho)} m²/s`] };
        },
    },
    lightning: {
        type: 'calc',
        inputs: { t: ['Seconds between flash and thunder', 'time', 's', 6], T: ['Air temperature', 'temperature', 'c', 20] },
        out: 'length',
        outUnit: 'km',
        label: 'Distance to the strike',
        rows: { c: 'Speed of sound used', rule: 'Rule of thumb', safety: 'Safety' },
        run: (x) => {
            const c = Math.sqrt((1.4 * R * x.T) / 0.0289647);
            const d = c * x.t;

            return { value: d, sub: `${num(d / 1609.344, 3)} miles`, rows: { c: `${num(c)} m/s`, rule: '3 seconds per km, 5 seconds per mile', safety: d < 10000 ? 'Within 10 km: you are in range of a strike, go indoors' : 'Still keep watch: storms move' }, steps: ['d = c t, c = √(γRT ÷ M)', `= ${num(c)} × ${num(x.t)} = ${num(d)} m`] };
        },
    },
    mixing_ratio: {
        type: 'calc',
        inputs: HUMID,
        show: HUMID_SHOW,
        when: HUMID_WHEN,
        label: 'Mixing ratio',
        rows: { q: 'Specific humidity', sat: 'Saturation mixing ratio', pv: 'Vapour pressure' },
        run: (x) => {
            const m = moist(x);

            if (m.error) {
                return m;
            }

            const { s } = m;
            const Ws = humidityRatio(s.ps, x.p);

            return { value: num(s.W * 1000, 5), unit: 'g/kg', sub: `${num(s.rh * 100, 4)}% RH`, rows: { q: `${num((s.W / (1 + s.W)) * 1000, 5)} g/kg`, sat: `${num(Ws * 1000, 5)} g/kg`, pv: `${num(s.pv)} Pa` }, steps: ['w = 0.621945 e ÷ (p − e)', `= ${num(s.W * 1000)} g of water per kg of dry air`] };
        },
    },
    psychrometric: {
        type: 'calc',
        inputs: HUMID,
        show: HUMID_SHOW,
        when: HUMID_WHEN,
        label: 'Enthalpy',
        rows: { rh: 'Relative humidity', dew: 'Dew point', wet: 'Wet-bulb temperature', W: 'Humidity ratio', v: 'Specific volume', rho: 'Density (moist air)', pv: 'Vapour pressure', ps: 'Saturation pressure' },
        run: (x) => {
            const m = moist(x);

            if (m.error) {
                return m;
            }

            const { s } = m;

            return { value: num(s.h, 5), unit: 'kJ/kg dry air', sub: `${num(s.rh * 100, 4)}% RH, W = ${num(s.W * 1000, 4)} g/kg`, rows: { rh: `${num(s.rh * 100, 4)}%`, dew: fmtC(s.dew), wet: fmtC(s.wet), W: `${num(s.W * 1000, 5)} g/kg`, v: `${num(s.v, 5)} m³/kg dry air`, rho: `${num(s.rho, 5)} kg/m³`, pv: `${num(s.pv)} Pa`, ps: `${num(s.ps)} Pa` }, steps: ['ASHRAE Fundamentals ch. 1 (Hyland–Wexler saturation pressure)', 'W = 0.621945 p_w ÷ (p − p_w)', 'h = 1.006t + W(2501 + 1.86t) kJ/kg', 'v = 0.287042 T (1 + 1.607858W) ÷ p'] };
        },
    },
    relative_humidity: {
        type: 'calc',
        inputs: { T: ['Air temperature', 'temperature', 'c', 25], by: ['Moisture given as', 'select', { dew: 'Dew point', wet: 'Wet-bulb temperature' }, 'dew'], Td: ['Dew point', 'temperature', 'c', 15], Tw: ['Wet-bulb temperature', 'temperature', 'c', 18], p: ['Air pressure', 'pressure', 'kpa', 101.325] },
        show: { Td: 'by:dew', Tw: 'by:wet' },
        when: { Td: (x) => x.by === 'dew', Tw: (x) => x.by === 'wet' },
        label: 'Relative humidity',
        rows: { dew: 'Dew point', wet: 'Wet bulb', abs: 'Absolute humidity' },
        run: (x) => {
            const m = moist(x);

            if (m.error) {
                return m;
            }

            const { s } = m;

            return { value: `${num(s.rh * 100, 4)}%`, sub: `e = ${num(s.pv)} Pa of e_s = ${num(s.ps)} Pa`, rows: { dew: fmtC(s.dew), wet: fmtC(s.wet), abs: `${num(s.abs * 1000, 4)} g/m³` }, steps: ['RH = e ÷ e_s(T)', `= ${num(s.pv)} ÷ ${num(s.ps)} = ${num(s.rh * 100)}%`] };
        },
    },
    scfm: {
        type: 'calc',
        inputs: { Q: ['Actual flow', 'flow', 'cfm', 100], P: ['Actual pressure (gauge)', 'pressure', 'psi', 100], Patm: ['Atmospheric pressure', 'pressure', 'psi', 14.696], T: ['Actual temperature', 'temperature', 'f', 80], std: ['Standard conditions', 'select', { cagi: '14.696 psia, 68 °F (CAGI/ISO 1217)', gas: '14.696 psia, 60 °F (gas industry)', normal: '101.325 kPa, 0 °C (normal, Nm³)' }, 'cagi'] },
        out: 'flow',
        outUnit: 'cfm',
        label: 'Standard flow',
        rows: { nm3h: ['In m³/h at those conditions', 'flow'], ratio: 'Correction factor' },
        run: (x) => {
            const [Ps, Ts] = { cagi: [101325, 293.15], gas: [101325, 288.706], normal: [101325, 273.15] }[x.std];
            const f = ((x.P + x.Patm) / Ps) * (Ts / x.T);

            return { value: x.Q * f, sub: `× ${num(f, 5)}`, rows: { nm3h: [x.Q * f, 'flow'], ratio: num(f, 5) }, steps: ['SCFM = ACFM × (P_actual ÷ P_std) × (T_std ÷ T_actual), absolute values', `= ${num(x.Q / 4.719474e-4)} × ${num(f)} = ${num((x.Q * f) / 4.719474e-4)} SCFM`, 'Humidity is ignored'] };
        },
    },
    temperature_altitude: {
        type: 'calc',
        inputs: { z: ['Altitude', 'length', 'm', 3000], T0: ['Ground temperature (optional)', 'temperature', 'c', 25], h0: ['Ground elevation', 'length', 'm', 0] },
        optional: ['T0'],
        out: 'temperature',
        outUnit: 'c',
        label: 'Temperature at that altitude',
        rows: { isa: 'Standard atmosphere temperature', lapse: 'Lapse rate used', note: 'Note' },
        run: (x) => {
            const isa = standardAtmosphere(x.z).T;
            const T = Number.isFinite(x.T0) && x.z <= 11000 ? x.T0 - 0.0065 * (x.z - x.h0) : isa;

            return { value: T, sub: Number.isFinite(x.T0) ? `From ${fmtC(x.T0)} at ${num(x.h0)} m` : 'Standard atmosphere', rows: { isa: fmtC(isa), lapse: '6.5 °C per km in the troposphere (US Std. Atmosphere 1976)', note: 'Real air varies: dry air cools about 9.8 °C/km when rising, humid air less' }, steps: ['T = T₀ − 0.0065 K/m × (z − z₀) up to 11 km', `= ${fmtC(T)}`] };
        },
    },
    true_airspeed: {
        type: 'calc',
        inputs: { cas: ['Calibrated (indicated) airspeed', 'speed', 'knot', 150], alt: ['Pressure altitude', 'length', 'ft', 10000], mode: ['Temperature', 'select', { isa: 'Standard (ISA)', oat: 'Outside air temperature' }, 'isa'], T: ['Outside air temperature', 'temperature', 'c', -5] },
        show: { T: 'mode:oat' },
        when: { T: (x) => x.mode === 'oat' },
        out: 'speed',
        outUnit: 'knot',
        label: 'True airspeed',
        rows: { mach: 'Mach number', eas: ['Equivalent airspeed', 'speed'], rule: 'Rule of thumb (+2% per 1,000 ft)' },
        run: (x) => {
            const a0 = 340.294;
            const P0 = 101325;
            const atm = standardAtmosphere(x.alt);
            const T = x.mode === 'oat' ? x.T : atm.T;
            const qc = P0 * ((1 + 0.2 * (x.cas / a0) ** 2) ** 3.5 - 1);
            const M = Math.sqrt(5 * ((qc / atm.P + 1) ** (2 / 7) - 1));
            const a = Math.sqrt(1.4 * 287.053 * T);
            const tas = M * a;

            return { value: tas, sub: `Mach ${num(M, 4)}`, rows: { mach: num(M, 4), eas: [tas * Math.sqrt(atm.P / (287.053 * T) / 1.225), 'speed'], rule: `${num(x.cas / 0.514444 * (1 + 0.02 * (x.alt / 0.3048 / 1000)), 4)} kn` }, steps: ['Impact pressure q_c = P₀[(1 + 0.2(CAS/a₀)²)^3.5 − 1]', 'M = √(5[(q_c/P + 1)^(2/7) − 1]), TAS = M √(γRT)', `TAS = ${num(tas / 0.514444)} kn`] };
        },
    },
    virtual_temperature: {
        type: 'calc',
        inputs: HUMID,
        show: HUMID_SHOW,
        when: HUMID_WHEN,
        out: 'temperature',
        outUnit: 'c',
        label: 'Virtual temperature',
        rows: { approx: 'Approximation T(1 + 0.61w)', diff: 'Warmer than the actual temperature by' },
        run: (x) => {
            const m = moist(x);

            if (m.error) {
                return m;
            }

            const { s } = m;

            return { value: s.Tv, sub: 'Dry air at this temperature has the same density as the moist air', rows: { approx: fmtC(x.T * (1 + 0.61 * s.W)), diff: `${num(s.Tv - x.T, 3)} K` }, steps: ['T_v = T (1 + w/ε) ÷ (1 + w), ε = 0.622', `w = ${num(s.W * 1000)} g/kg, T_v = ${fmtC(s.Tv)}`] };
        },
    },
    wet_bulb: {
        type: 'calc',
        inputs: { T: ['Air temperature', 'temperature', 'c', 30], rh: ['Relative humidity (%)', null, null, 50, 0], p: ['Air pressure', 'pressure', 'kpa', 101.325] },
        out: 'temperature',
        outUnit: 'c',
        label: 'Wet-bulb temperature',
        rows: { stull: 'Stull (2011) formula for comparison', depression: 'Wet-bulb depression', risk: 'Heat stress' },
        run: (x) => {
            const pv = (x.rh / 100) * satPressure(x.T);
            const Tw = wetBulb(x.T, humidityRatio(pv, x.p), x.p);
            const t = C(x.T);
            const r = x.rh;
            const stull = t * Math.atan(0.151977 * Math.sqrt(r + 8.313659)) + Math.atan(t + r) - Math.atan(r - 1.676331) + 0.00391838 * r ** 1.5 * Math.atan(0.023101 * r) - 4.686035;

            return { value: Tw, sub: `Depression ${num(x.T - Tw, 3)} °C`, rows: { stull: `${num(stull, 4)} °C (sea level)`, depression: `${num(x.T - Tw, 4)} °C`, risk: C(Tw) >= 35 ? 'At the human survivability limit' : C(Tw) >= 31 ? 'Dangerous even at rest' : C(Tw) >= 28 ? 'Very high for exertion' : 'Manageable with rest and water' }, steps: ['Psychrometric equation (ASHRAE) solved for t* by bisection', `T_w = ${fmtC(Tw)}`] };
        },
    },
    wind_chill: {
        type: 'calc',
        inputs: { T: ['Air temperature', 'temperature', 'c', -10], v: ['Wind speed (10 m height)', 'speed', 'kmh', 30] },
        out: 'temperature',
        outUnit: 'c',
        label: 'Wind chill',
        rows: { frost: 'Frostbite risk', valid: 'Validity' },
        run: (x) => {
            const t = C(x.T);
            const v = x.v * 3.6;
            const wc = 13.12 + 0.6215 * t - 11.37 * v ** 0.16 + 0.3965 * t * v ** 0.16;
            const ok = t <= 10 && v >= 4.8;
            const frost = wc > -27 ? 'Low' : wc > -40 ? 'Moderate: within 10–30 minutes' : wc > -48 ? 'High: within 5–10 minutes' : 'Very high: within 2–5 minutes';

            return { value: (ok ? wc : t) + 273.15, sub: ok ? `Feels like ${num(wc, 3)} °C` : 'Outside the formula’s range: no wind chill', rows: { frost, valid: ok ? 'Air ≤ 10 °C and wind ≥ 4.8 km/h' : 'Needs air at or below 10 °C and wind at least 4.8 km/h' }, steps: ['NWS / Environment Canada (2001): WC = 13.12 + 0.6215T − 11.37v^0.16 + 0.3965Tv^0.16', `= ${num(wc)} °C`] };
        },
    },

    // Thermodynamics -----------------------------------------------------------------------------
    avogadro: twoState({ vars: { V1: ['Volume 1', 'volume', 'l', 22.4], n1: ['Amount 1 (mol)', null, null, 1], V2: ['Volume 2', 'volume', 'l', 44.8], n2: ['Amount 2 (mol)', null, null, 2] }, def: 'V2', eq: 'V₁ ÷ n₁ = V₂ ÷ n₂', forms: { V2: 'V₂ = V₁n₂ ÷ n₁', V1: 'V₁ = V₂n₁ ÷ n₂', n2: 'n₂ = n₁V₂ ÷ V₁', n1: 'n₁ = n₂V₁ ÷ V₂' }, solve: { V2: (v) => (v.V1 * v.n2) / v.n1, V1: (v) => (v.V2 * v.n1) / v.n2, n2: (v) => (v.n1 * v.V2) / v.V1, n1: (v) => (v.n2 * v.V1) / v.V2 }, rows: { molar: 'Molar volume' }, extra: (v) => ({ molar: `${num((v.V1 / v.n1) * 1000)} L/mol (22.414 at 0 °C, 1 atm)` }) }),
    biot: pw({ vars: { Bi: ['Biot number', null, null, 0.05], h: ['Heat transfer coefficient', 'heat_transfer_coefficient', 'wm2k', 25], L: ['Characteristic length V/A', 'length', 'mm', 10], k: ['Solid conductivity', 'thermal_conductivity', 'wmk', 5] }, out: 'Bi', exp: { h: 1, L: 1, k: -1 }, eq: 'Bi = h L ÷ k', forms: { Bi: 'Bi = hL ÷ k', h: 'h = Bi k ÷ L', L: 'L = Bi k ÷ h', k: 'k = hL ÷ Bi' }, rows: { lumped: 'Lumped-capacitance model' }, extra: (v) => ({ lumped: v.Bi < 0.1 ? 'Valid (Bi < 0.1): the body heats almost uniformly' : 'Not valid: significant temperature gradients inside' }) }),
    boltzmann_factor: {
        type: 'calc',
        inputs: { dE: ['Energy difference', 'particle_energy', 'ev', 0.1], T: ['Temperature', 'temperature', 'k', 300], g1: ['Degeneracy of the lower state', null, null, 1, 0], g2: ['Degeneracy of the upper state', null, null, 1, 0] },
        label: 'Boltzmann factor e^(−ΔE/kT)',
        rows: { ratio: 'Population ratio upper ÷ lower', kT: 'Thermal energy kT', fraction: 'Share in the upper state (two levels)' },
        run: (x) => {
            const f = Math.exp(-x.dE / (K.k * x.T));
            const r = (x.g2 / x.g1) * f;

            return { value: num(f), sub: `kT = ${num((K.k * x.T) / K.e * 1000, 4)} meV`, rows: { ratio: num(r), kT: `${num((K.k * x.T) / K.e)} eV`, fraction: `${num((r / (1 + r)) * 100)}%` }, steps: ['f = e^(−ΔE/kT)', `ΔE/kT = ${num(x.dE / (K.k * x.T))}`, `N₂/N₁ = (g₂/g₁) f = ${num(r)}`] };
        },
    },
    boyle: twoState({ vars: { P1: ['Pressure 1', 'pressure', 'kpa', 100], V1: ['Volume 1', 'volume', 'l', 10], P2: ['Pressure 2', 'pressure', 'kpa', 200], V2: ['Volume 2', 'volume', 'l', 5] }, def: 'V2', eq: 'P₁V₁ = P₂V₂ (constant T and n)', forms: { V2: 'V₂ = P₁V₁ ÷ P₂', P2: 'P₂ = P₁V₁ ÷ V₂', V1: 'V₁ = P₂V₂ ÷ P₁', P1: 'P₁ = P₂V₂ ÷ V₁' }, solve: { V2: (v) => (v.P1 * v.V1) / v.P2, P2: (v) => (v.P1 * v.V1) / v.V2, V1: (v) => (v.P2 * v.V2) / v.P1, P1: (v) => (v.P2 * v.V2) / v.V1 }, rows: { ratio: 'Compression ratio V₁/V₂' }, extra: (v) => ({ ratio: num(v.V1 / v.V2) }) }),
    btu_tons: {
        type: 'calc',
        inputs: { P: ['Cooling or heating capacity', 'power', 'btuh', 24000] },
        out: 'power',
        outUnit: 'tr',
        label: 'Capacity',
        rows: { kw: ['In kilowatts', 'power'], btu: 'In BTU/h' },
        run: (x) => ({ value: x.P, sub: '1 ton of refrigeration = 12,000 BTU/h = 3.51685 kW', rows: { kw: [x.P, 'power'], btu: `${num(x.P / 0.29307107)} BTU/h` }, steps: ['1 TR = 12,000 BTU/h (melting a short ton of ice per day)', `= ${num(x.P / 3516.8528)} TR`] }),
    },
    calorimetry: {
        type: 'calc',
        inputs: { mode: ['Find', 'select', { tf: 'Final temperature', c: 'Unknown specific heat of body 1' }, 'tf'], m1: ['Body 1 mass', 'mass', 'g', 200], c1: ['Body 1 specific heat', 'specific_heat', 'jkgk', 385], T1: ['Body 1 temperature', 'temperature', 'c', 100], m2: ['Body 2 (water) mass', 'mass', 'g', 500], c2: ['Body 2 specific heat', 'specific_heat', 'jkgk', 4182], T2: ['Body 2 temperature', 'temperature', 'c', 20], Tf: ['Measured final temperature', 'temperature', 'c', 22.9] },
        show: { c1: 'mode:tf', Tf: 'mode:c' },
        when: { c1: (x) => x.mode === 'tf', Tf: (x) => x.mode === 'c' },
        out: 'temperature',
        outUnit: 'c',
        label: 'Final temperature',
        rows: { Q: 'Heat exchanged', c1: 'Specific heat of body 1' },
        run: (x) => {
            if (x.mode === 'c') {
                const c1 = (x.m2 * x.c2 * (x.Tf - x.T2)) / (x.m1 * (x.T1 - x.Tf));

                return { value: num(c1, 5), unit: 'J/(kg·K)', label: 'Specific heat of body 1', sub: c1 > 0 ? 'From the measured final temperature' : 'Check the temperatures', rows: { Q: `${num(x.m2 * x.c2 * (x.Tf - x.T2))} J`, c1: `${num(c1)} J/(kg·K)` }, steps: ['Heat lost = heat gained: m₁c₁(T₁ − T_f) = m₂c₂(T_f − T₂)', `c₁ = ${num(c1)} J/(kg·K)`] };
            }

            const Tf = (x.m1 * x.c1 * x.T1 + x.m2 * x.c2 * x.T2) / (x.m1 * x.c1 + x.m2 * x.c2);

            return { value: Tf, sub: 'No heat lost to the surroundings or container', rows: { Q: `${num(x.m1 * x.c1 * (x.T1 - Tf))} J`, c1: `${num(x.c1)} J/(kg·K)` }, steps: ['T_f = Σmc T ÷ Σmc', `= ${fmtC(Tf)}`, 'No phase changes assumed'] };
        },
    },
    carnot: {
        type: 'law',
        vars: { eta: ['Carnot efficiency (fraction)', null, null, 0.5], Th: ['Hot reservoir', 'temperature', 'c', 326.85], Tc: ['Cold reservoir', 'temperature', 'c', 26.85] },
        default: 'eta',
        eq: 'η = 1 − T_c ÷ T_h (kelvin)',
        forms: { eta: 'η = 1 − T_c/T_h', Th: 'T_h = T_c ÷ (1 − η)', Tc: 'T_c = T_h (1 − η)' },
        solve: { eta: (v) => 1 - v.Tc / v.Th, Th: (v) => v.Tc / (1 - v.eta), Tc: (v) => v.Th * (1 - v.eta) },
        rows: { pct: 'As a percentage', cop: 'Carnot COP as a heat pump' },
        extra: (v) => ({ pct: `${num(v.eta * 100, 4)}%`, cop: num(v.Th / (v.Th - v.Tc), 4) }),
    },
    charles: twoState({ vars: { V1: ['Volume 1', 'volume', 'l', 10], T1: ['Temperature 1', 'temperature', 'c', 20], V2: ['Volume 2', 'volume', 'l', 11.023], T2: ['Temperature 2', 'temperature', 'c', 50] }, def: 'V2', eq: 'V₁ ÷ T₁ = V₂ ÷ T₂ (constant P, kelvin)', forms: { V2: 'V₂ = V₁T₂ ÷ T₁', T2: 'T₂ = T₁V₂ ÷ V₁', V1: 'V₁ = V₂T₁ ÷ T₂', T1: 'T₁ = T₂V₁ ÷ V₂' }, solve: { V2: (v) => (v.V1 * v.T2) / v.T1, T2: (v) => (v.T1 * v.V2) / v.V1, V1: (v) => (v.V2 * v.T1) / v.T2, T1: (v) => (v.T2 * v.V1) / v.V2 }, rows: { change: 'Volume change' }, extra: (v) => ({ change: `${num((v.V2 / v.V1 - 1) * 100, 4)}%` }) }),
    cop: {
        type: 'calc',
        inputs: { kind: ['Machine', 'select', { hp: 'Heat pump (heating)', fridge: 'Refrigerator or air conditioner (cooling)' }, 'hp'], mode: ['I know', 'select', { qw: 'Heat moved and work input', temps: 'The two temperatures (ideal limit)' }, 'qw'], Q: ['Heat delivered or removed', 'power', 'kw', 10], W: ['Electrical input', 'power', 'kw', 3], Th: ['Hot side', 'temperature', 'c', 35], Tc: ['Cold side', 'temperature', 'c', 0] },
        show: { Q: 'mode:qw', W: 'mode:qw', Th: 'mode:temps', Tc: 'mode:temps' },
        when: { Q: (x) => x.mode === 'qw', W: (x) => x.mode === 'qw', Th: (x) => x.mode === 'temps', Tc: (x) => x.mode === 'temps' },
        label: 'Coefficient of performance',
        rows: { eer: 'EER (BTU/h per W)', note: 'Meaning' },
        run: (x) => {
            if (x.mode === 'temps' && !(x.Th > x.Tc)) {
                return { error: 'The hot side must be warmer than the cold side.' };
            }

            const cop = x.mode === 'qw' ? x.Q / x.W : x.kind === 'hp' ? x.Th / (x.Th - x.Tc) : x.Tc / (x.Th - x.Tc);

            return { value: num(cop, 4), sub: x.mode === 'temps' ? 'Carnot (ideal) limit; real machines reach 40–60% of it' : `${num(cop, 3)} units of heat per unit of electricity`, rows: { eer: num(cop * 3.412, 4), note: x.kind === 'hp' ? 'COP above 1 means more heat than electricity used' : 'Heat removed per unit of work' }, steps: [x.mode === 'qw' ? 'COP = Q ÷ W' : x.kind === 'hp' ? 'COP = T_h ÷ (T_h − T_c)' : 'COP = T_c ÷ (T_h − T_c)', `= ${num(cop)}`] };
        },
    },
    compressibility: {
        type: 'calc',
        inputs: { gas: GAS('methane'), P: ['Pressure', 'pressure', 'bar', 100], T: ['Temperature', 'temperature', 'c', 25] },
        data: ['gases'],
        label: 'Compressibility factor Z',
        rows: { Tr: 'Reduced temperature', Pr: 'Reduced pressure', rho: 'Density', ideal: 'Ideal-gas density' },
        run: (x, ctx) => {
            const gd = gas(ctx, x.gas);
            const Tc = gd.tc;
            const Pc = gd.pc * 1e6;
            const kappa = 0.37464 + 1.54226 * gd.omega - 0.26992 * gd.omega ** 2;
            const alpha = (1 + kappa * (1 - Math.sqrt(x.T / Tc))) ** 2;
            const a = (0.45724 * R * R * Tc * Tc * alpha) / Pc;
            const b = (0.0778 * R * Tc) / Pc;
            const A = (a * x.P) / (R * x.T) ** 2;
            const B = (b * x.P) / (R * x.T);
            const f = (Z) => Z ** 3 - (1 - B) * Z * Z + (A - 3 * B * B - 2 * B) * Z - (A * B - B * B - B ** 3);
            const Z = bisect(f, B + 1e-9, 10);
            const M = gd.molar / 1000;

            return { value: num(Z, 5), sub: Z < 1 ? 'Denser than an ideal gas (attraction dominates)' : 'Less dense than an ideal gas (repulsion dominates)', rows: { Tr: num(x.T / Tc, 4), Pr: num(x.P / Pc, 4), rho: `${num((x.P * M) / (Z * R * x.T))} kg/m³`, ideal: `${num((x.P * M) / (R * x.T))} kg/m³` }, steps: ['Peng–Robinson: Z³ − (1 − B)Z² + (A − 3B² − 2B)Z − (AB − B² − B³) = 0', `T_c = ${num(Tc)} K, P_c = ${num(gd.pc)} MPa, ω = ${num(gd.omega)}`, `A = ${num(A)}, B = ${num(B)}, Z = ${num(Z)} (vapour root)`] };
        },
    },
    curie: {
        type: 'calc',
        inputs: { Cc: ['Curie constant (K)', null, null, 0.5, 0], T: ['Temperature', 'temperature', 'k', 300], H: ['Applied field H (A/m)', null, null, 1e5, 0] },
        label: 'Magnetic susceptibility χ',
        rows: { M: 'Magnetisation M = χH', at: 'At twice the temperature' },
        run: (x) => {
            const chi = x.Cc / x.T;

            return { value: num(chi), sub: 'Paramagnet: χ falls as 1/T', rows: { M: `${num(chi * x.H)} A/m`, at: `χ = ${num(chi / 2)}` }, steps: ['Curie’s law: χ = C ÷ T, M = χH', `χ = ${num(x.Cc)} ÷ ${num(x.T)} = ${num(chi)}`, 'Valid well above any ordering temperature and for weak fields'] };
        },
    },
    ntu: {
        type: 'calc',
        inputs: { type: ['Exchanger', 'select', { counter: 'Counterflow', parallel: 'Parallel flow', shell: 'Shell and tube (1 shell pass)', cross: 'Crossflow, both fluids unmixed' }, 'counter'], UA: ['UA (W/K)', null, null, 2000, 0], Ch: ['Hot stream capacity ṁc_p (W/K)', null, null, 1000, 0], Cc: ['Cold stream capacity ṁc_p (W/K)', null, null, 1500, 0], Thi: ['Hot inlet', 'temperature', 'c', 90], Tci: ['Cold inlet', 'temperature', 'c', 20] },
        label: 'Effectiveness ε',
        rows: { Q: 'Heat transferred', Tho: 'Hot outlet', Tco: 'Cold outlet', NTU: 'NTU', Cr: 'Capacity ratio' },
        run: (x) => {
            const Cmin = Math.min(x.Ch, x.Cc);
            const Cr = Cmin / Math.max(x.Ch, x.Cc);
            const N = x.UA / Cmin;
            let e;

            if (Cr === 0) {
                e = 1 - Math.exp(-N);
            } else if (x.type === 'counter') {
                e = Math.abs(Cr - 1) < 1e-12 ? N / (1 + N) : (1 - Math.exp(-N * (1 - Cr))) / (1 - Cr * Math.exp(-N * (1 - Cr)));
            } else if (x.type === 'parallel') {
                e = (1 - Math.exp(-N * (1 + Cr))) / (1 + Cr);
            } else if (x.type === 'shell') {
                const s = Math.sqrt(1 + Cr * Cr);
                e = 2 / (1 + Cr + s * (1 + Math.exp(-N * s)) / (1 - Math.exp(-N * s)));
            } else {
                e = 1 - Math.exp((1 / Cr) * N ** 0.22 * (Math.exp(-Cr * N ** 0.78) - 1));
            }

            const Q = e * Cmin * (x.Thi - x.Tci);

            return { value: num(e, 4), sub: `Q = ${num(Q / 1000)} kW`, rows: { Q: `${num(Q)} W`, Tho: fmtC(x.Thi - Q / x.Ch), Tco: fmtC(x.Tci + Q / x.Cc), NTU: num(N, 4), Cr: num(Cr, 4) }, steps: ['NTU = UA ÷ C_min, C_r = C_min ÷ C_max', `ε from the ${x.type === 'cross' ? 'crossflow (Incropera approximation)' : x.type} relation = ${num(e)}`, 'Q = ε C_min (T_h,in − T_c,in)'] };
        },
    },
    efficiency: pw({ vars: { eta: ['Efficiency (fraction)', null, null, 0.85], out: ['Useful output', 'power', 'kw', 8.5], in: ['Input', 'power', 'kw', 10] }, out: 'eta', exp: { out: 1, in: -1 }, eq: 'η = output ÷ input', forms: { eta: 'η = out ÷ in', out: 'out = η × in', in: 'in = out ÷ η' }, rows: { pct: 'As a percentage', lost: 'Lost as heat' }, extra: (v) => ({ pct: `${num(v.eta * 100, 4)}%`, lost: `${num((v.in - v.out) / 1000)} kW` }) }),
    mobility: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { vd: 'Drift velocity and field', tau: 'Charge, mass and collision time' }, 'vd'], vd: ['Drift velocity', 'speed', 'ms', 0.14], E: ['Electric field', 'electric_field', 'vpm', 1000], q: ['Charge', 'charge', 'e', 1], m: ['Effective mass', 'particle_mass', 'me', 0.26], tau: ['Mean collision time', 'short_time', 'ps', 0.2] },
        show: { vd: 'mode:vd', E: 'mode:vd', q: 'mode:tau', m: 'mode:tau', tau: 'mode:tau' },
        when: { vd: (x) => x.mode === 'vd', E: (x) => x.mode === 'vd', q: (x) => x.mode === 'tau', m: (x) => x.mode === 'tau', tau: (x) => x.mode === 'tau' },
        label: 'Electrical mobility',
        rows: { cm: 'In cm²/(V·s)', typical: 'Typical values' },
        run: (x) => {
            const mu = x.mode === 'vd' ? x.vd / x.E : (Math.abs(x.q) * x.tau) / x.m;

            return { value: num(mu), unit: 'm²/(V·s)', sub: `${num(mu * 1e4)} cm²/(V·s)`, rows: { cm: `${num(mu * 1e4)} cm²/(V·s)`, typical: 'Electrons in silicon ≈ 1,400 cm²/(V·s), holes ≈ 450, copper ≈ 43' }, steps: [x.mode === 'vd' ? 'μ = v_d ÷ E' : 'μ = qτ ÷ m', `= ${num(mu)} m²/(V·s)`] };
        },
    },
    enthalpy: {
        type: 'calc',
        inputs: { mode: ['Find', 'select', { upv: 'H = U + PV', cp: 'ΔH = m c_p ΔT (constant pressure)' }, 'cp'], U: ['Internal energy', 'energy', 'kj', 100], P: ['Pressure', 'pressure', 'kpa', 101.325], V: ['Volume', 'volume', 'l', 50], m: ['Mass', 'mass', 'kg', 2], cp: ['Specific heat c_p', 'specific_heat', 'jkgk', 4182], dT: ['Temperature change', 'temperature_difference', 'k', 30] },
        show: { U: 'mode:upv', P: 'mode:upv', V: 'mode:upv', m: 'mode:cp', cp: 'mode:cp', dT: 'mode:cp' },
        when: { U: (x) => x.mode === 'upv', P: (x) => x.mode === 'upv', V: (x) => x.mode === 'upv', m: (x) => x.mode === 'cp', cp: (x) => x.mode === 'cp', dT: (x) => x.mode === 'cp' },
        out: 'energy',
        outUnit: 'kj',
        label: 'Enthalpy',
        rows: { pv: 'Flow work PV', kwh: 'In kWh' },
        run: (x) => {
            const H = x.mode === 'upv' ? x.U + x.P * x.V : x.m * x.cp * x.dT;

            return { value: H, sub: x.mode === 'upv' ? 'H = U + PV' : 'ΔH = m c_p ΔT', rows: { pv: x.mode === 'upv' ? `${num(x.P * x.V)} J` : 'Not used', kwh: `${num(H / 3.6e6)} kWh` }, steps: [x.mode === 'upv' ? `H = ${num(x.U)} + ${num(x.P)} × ${num(x.V)}` : `ΔH = ${num(x.m)} × ${num(x.cp)} × ${num(x.dT)}`, `= ${num(H)} J`] };
        },
    },
    evaporation: {
        type: 'calc',
        inputs: { A: ['Water surface area', 'area', 'm2', 50], Tw: ['Water temperature', 'temperature', 'c', 28], Ta: ['Air temperature', 'temperature', 'c', 25], rh: ['Relative humidity (%)', null, null, 50, 0], v: ['Air speed over the water', 'speed', 'ms', 0.1], use: ['Activity factor', 'select', { 0.5: 'Unoccupied pool (cover off)', 0.65: 'Residential pool', 0.8: 'Hotel or condominium pool', 1: 'Public or school pool', 1.5: 'Wave pool or water park' }, '0.5'] },
        label: 'Evaporation rate',
        rows: { day: 'Per day', depth: 'Water level drop per day', heat: 'Heat lost' },
        run: (x) => {
            const pw = satPressure(x.Tw) / 1000;
            const pa = ((x.rh / 100) * satPressure(x.Ta)) / 1000;
            const Y = 2501 - 2.361 * C(x.Tw);
            const w = (x.A / Y) * Math.max(0, pw - pa) * (0.089 + 0.0782 * x.v) * Number(x.use);

            return { value: num(w * 3600, 4), unit: 'kg/h', sub: `${num(w * 86400, 4)} kg (litres) per day`, rows: { day: `${num(w * 86400, 4)} L`, depth: `${num((w * 86400) / x.A, 3)} mm`, heat: `${num(w * Y, 4)} kW` }, steps: ['Carrier equation (ASHRAE HVAC Applications ch. 6): w = (A ÷ Y)(p_w − p_a)(0.089 + 0.0782V) × activity', `p_w = ${num(pw)} kPa, p_a = ${num(pa)} kPa`, 'An estimate for indoor pools and tanks'] };
        },
    },
    gay_lussac: twoState({ vars: { P1: ['Pressure 1', 'pressure', 'kpa', 200], T1: ['Temperature 1', 'temperature', 'c', 20], P2: ['Pressure 2', 'pressure', 'kpa', 220.47], T2: ['Temperature 2', 'temperature', 'c', 50] }, def: 'P2', eq: 'P₁ ÷ T₁ = P₂ ÷ T₂ (constant V, kelvin)', forms: { P2: 'P₂ = P₁T₂ ÷ T₁', T2: 'T₂ = T₁P₂ ÷ P₁', P1: 'P₁ = P₂T₁ ÷ T₂', T1: 'T₁ = T₂P₁ ÷ P₂' }, solve: { P2: (v) => (v.P1 * v.T2) / v.T1, T2: (v) => (v.T1 * v.P2) / v.P1, P1: (v) => (v.P2 * v.T1) / v.T2, T1: (v) => (v.T2 * v.P1) / v.P2 }, rows: { change: 'Pressure change' }, extra: (v) => ({ change: `${num((v.P2 / v.P1 - 1) * 100, 4)}%` }) }),
    heat_capacity: pw({ vars: { C: ['Heat capacity (J/K)', null, null, 418.2], Q: ['Heat supplied', 'energy', 'kj', 12.546], dT: ['Temperature rise', 'temperature_difference', 'k', 30] }, out: 'C', exp: { Q: 1, dT: -1 }, eq: 'C = Q ÷ ΔT', forms: { C: 'C = Q ÷ ΔT', Q: 'Q = C ΔT', dT: 'ΔT = Q ÷ C' }, rows: { water: 'Equivalent mass of water' }, extra: (v) => ({ water: `${num(v.C / 4182 * 1000)} g` }) }),
    heat_transfer: {
        type: 'calc',
        inputs: { mode: ['Mode', 'select', { cond: 'Conduction (Fourier)', conv: 'Convection (Newton)', rad: 'Radiation (Stefan–Boltzmann)' }, 'cond'], k: ['Thermal conductivity', 'thermal_conductivity', 'wmk', 0.04], L: ['Thickness', 'length', 'mm', 100], h: ['Heat transfer coefficient', 'heat_transfer_coefficient', 'wm2k', 10], eps: ['Emissivity', null, null, 0.9, 0], A: ['Area', 'area', 'm2', 10], T1: ['Hot side or surface temperature', 'temperature', 'c', 20], T2: ['Cold side or surroundings temperature', 'temperature', 'c', 0] },
        show: { k: 'mode:cond', L: 'mode:cond', h: 'mode:conv', eps: 'mode:rad' },
        when: { k: (x) => x.mode === 'cond', L: (x) => x.mode === 'cond', h: (x) => x.mode === 'conv', eps: (x) => x.mode === 'rad' },
        out: 'power',
        outUnit: 'w',
        label: 'Heat transfer rate',
        rows: { flux: 'Heat flux', day: 'Energy per day' },
        run: (x) => {
            const Q = x.mode === 'cond' ? (x.k * x.A * (x.T1 - x.T2)) / x.L : x.mode === 'conv' ? x.h * x.A * (x.T1 - x.T2) : x.eps * K.sigma * x.A * (x.T1 ** 4 - x.T2 ** 4);

            return { value: Q, sub: `${num(Q / x.A)} W/m²`, rows: { flux: `${num(Q / x.A)} W/m²`, day: `${num((Q * 86400) / 3.6e6)} kWh` }, steps: [{ cond: 'Q = kA(T₁ − T₂) ÷ L', conv: 'Q = hA(T₁ − T₂)', rad: 'Q = εσA(T₁⁴ − T₂⁴)' }[x.mode], `= ${num(Q)} W`] };
        },
    },
    u_value: {
        type: 'calc',
        inputs: { layers: ['Layers: thickness in mm, conductivity in W/(m·K) (one per line)', 'textarea', null, LAYER_SAMPLE], hi: ['Inside surface coefficient', 'heat_transfer_coefficient', 'wm2k', 7.69], ho: ['Outside surface coefficient', 'heat_transfer_coefficient', 'wm2k', 25], A: ['Area (optional)', 'area', 'm2', 10], dT: ['Temperature difference (optional)', 'temperature_difference', 'k', 20] },
        optional: ['A', 'dT'],
        out: 'heat_transfer_coefficient',
        outUnit: 'wm2k',
        label: 'Overall U-value',
        rows: { Rt: 'Total thermal resistance', Q: 'Heat loss', share: 'Resistance of each layer' },
        run: (x) => {
            const L = readLayers(x.layers);

            if (!L) {
                return { empty: 'Type each layer as thickness (mm), conductivity.' };
            }

            const rs = L.map(([t, k]) => t / 1000 / k);
            const Rt = 1 / x.hi + rs.reduce((a, b) => a + b, 0) + 1 / x.ho;
            const U = 1 / Rt;

            return { value: U, sub: `R = ${num(Rt, 4)} m²·K/W`, rows: { Rt: `${num(Rt, 4)} m²·K/W`, Q: Number.isFinite(x.A) && Number.isFinite(x.dT) ? `${num(U * x.A * x.dT)} W` : 'Enter an area and temperature difference', share: rs.map((r, k) => `#${k + 1}: ${num(r, 3)}`).join(', ') }, steps: ['1/U = 1/h_i + Σ(t/k) + 1/h_o', `R_si = ${num(1 / x.hi, 3)}, R_se = ${num(1 / x.ho, 3)} m²·K/W (ISO 6946 defaults 0.13 and 0.04)`, `U = ${num(U)} W/(m²·K)`] };
        },
    },
    ideal_gas_density: {
        type: 'calc',
        inputs: { gas: GAS('air'), M: ['Molar mass (g/mol)', null, null, 28.9647, 0], P: ['Pressure', 'pressure', 'kpa', 101.325], T: ['Temperature', 'temperature', 'c', 20] },
        show: { M: 'gas:custom' },
        when: { M: (x) => x.gas === 'custom' },
        data: ['gases'],
        out: 'density',
        outUnit: 'kgm3',
        label: 'Gas density',
        rows: { sg: 'Relative to air', molar: 'Molar volume' },
        run: (x, ctx) => {
            const M = (x.gas === 'custom' ? x.M : gas(ctx, x.gas).molar) / 1000;
            const rho = (x.P * M) / (R * x.T);

            return { value: rho, sub: `M = ${num(M * 1000)} g/mol`, rows: { sg: num(M / 0.0289647, 4), molar: `${num(((R * x.T) / x.P) * 1000)} L/mol` }, steps: ['ρ = PM ÷ RT', `= ${num(x.P)} × ${num(M)} ÷ (8.314462 × ${num(x.T)}) = ${num(rho)} kg/m³`] };
        },
    },
    isentropic: {
        type: 'calc',
        inputs: { by: ['I know', 'select', { M: 'Mach number', T: 'Temperature ratio T/T₀', p: 'Pressure ratio p/p₀', A: 'Area ratio A/A* (subsonic)', As: 'Area ratio A/A* (supersonic)' }, 'M'], val: ['Value', null, null, 2, 0], gamma: ['γ', null, null, 1.4, 1] },
        label: 'Mach number',
        rows: { T: 'T/T₀', p: 'p/p₀', rho: 'ρ/ρ₀', A: 'A/A*', mu: 'Mach angle' },
        run: (x) => {
            const g = x.gamma;
            const t = (M) => 1 / (1 + ((g - 1) / 2) * M * M);
            const area = (M) => (1 / M) * ((2 / (g + 1)) * (1 + ((g - 1) / 2) * M * M)) ** ((g + 1) / (2 * (g - 1)));
            let M;

            if (x.by === 'M') {
                M = x.val;
            } else if (x.by === 'T') {
                M = Math.sqrt((2 / (g - 1)) * (1 / x.val - 1));
            } else if (x.by === 'p') {
                M = Math.sqrt((2 / (g - 1)) * (x.val ** (-(g - 1) / g) - 1));
            } else {
                if (!(x.val >= 1)) {
                    return { error: 'A/A* is at least 1.' };
                }

                M = x.by === 'A' ? bisect((m) => area(m) - x.val, 1e-6, 1) : bisect((m) => area(m) - x.val, 1, 100);
            }

            if (!(M >= 0)) {
                return { error: 'That ratio has no solution (ratios must be between 0 and 1).' };
            }

            return { value: num(M, 5), sub: M < 1 ? 'Subsonic' : M > 1 ? 'Supersonic' : 'Sonic', rows: { T: num(t(M), 5), p: num(t(M) ** (g / (g - 1)), 5), rho: num(t(M) ** (1 / (g - 1)), 5), A: M > 0 ? num(area(M), 5) : '∞', mu: M >= 1 ? `${num(Math.asin(1 / M) / D, 4)}°` : 'Subsonic: none' }, steps: ['T₀/T = 1 + (γ−1)/2 M²', 'p₀/p = (T₀/T)^(γ/(γ−1)), ρ₀/ρ = (T₀/T)^(1/(γ−1))', 'A/A* = (1/M)[(2/(γ+1))(1 + (γ−1)/2 M²)]^((γ+1)/(2(γ−1)))'] };
        },
    },
    joule_heating: pw({ vars: { Q: ['Heat generated', 'energy', 'kj', 120], I: ['Current', 'current', 'a', 10], R: ['Resistance', 'resistance', 'ohm', 2], t: ['Time', 'time', 'min', 0.5] }, out: 'Q', exp: { I: 2, R: 1, t: 1 }, eq: 'Q = I² R t', forms: { Q: 'Q = I²Rt', I: 'I = √(Q ÷ Rt)', R: 'R = Q ÷ I²t', t: 't = Q ÷ I²R' }, rows: { P: 'Power' }, extra: (v) => ({ P: `${num(v.I ** 2 * v.R)} W` }) }),
    latent_heat: {
        type: 'calc',
        inputs: { sub: ['Substance', 'select', 'data:latent', 'water'], L: ['Latent heat (kJ/kg)', null, null, 334, 0], change: ['Change', 'select', { fusion: 'Melting or freezing (fusion)', vaporisation: 'Boiling or condensing (vaporisation)' }, 'vaporisation'], m: ['Mass', 'mass', 'kg', 1] },
        show: { L: 'sub:custom' },
        when: { L: (x) => x.sub === 'custom' },
        data: ['latent'],
        out: 'energy',
        outUnit: 'kj',
        label: 'Heat needed',
        rows: { L: 'Latent heat used', at: 'Transition temperature', kwh: 'In kWh' },
        run: (x, ctx) => {
            const d = x.sub === 'custom' ? null : ctx.c.data.physics.latent[x.sub];
            const L = d ? d[x.change] : x.L;

            if (!L) {
                return { error: 'No value is listed for that change.' };
            }

            const Q = x.m * L * 1000;

            return { value: Q, sub: `${num(L)} kJ/kg`, rows: { L: `${num(L)} kJ/kg`, at: d ? `${num(x.change === 'fusion' ? d.melt : d.boil)} °C at 1 atm` : 'Custom', kwh: `${num(Q / 3.6e6)} kWh` }, steps: ['Q = mL (no temperature change during the phase change)', `= ${num(x.m)} × ${num(L)} kJ/kg = ${num(Q / 1000)} kJ`] };
        },
    },
    lmtd: {
        type: 'calc',
        inputs: { flow: ['Arrangement', 'select', { counter: 'Counterflow', parallel: 'Parallel flow' }, 'counter'], Thi: ['Hot inlet', 'temperature', 'c', 90], Tho: ['Hot outlet', 'temperature', 'c', 50], Tci: ['Cold inlet', 'temperature', 'c', 20], Tco: ['Cold outlet', 'temperature', 'c', 40] },
        out: 'temperature_difference',
        outUnit: 'k',
        label: 'Log mean temperature difference',
        rows: { d1: 'ΔT₁', d2: 'ΔT₂', arith: 'Arithmetic mean (less accurate)' },
        run: (x) => {
            const [d1, d2] = x.flow === 'counter' ? [x.Thi - x.Tco, x.Tho - x.Tci] : [x.Thi - x.Tci, x.Tho - x.Tco];

            if (!(d1 > 0 && d2 > 0)) {
                return { error: 'The temperatures cross: check the inlet and outlet values.' };
            }

            const lm = Math.abs(d1 - d2) < 1e-9 ? d1 : (d1 - d2) / Math.log(d1 / d2);

            return { value: lm, sub: `ΔT₁ = ${num(d1)} K, ΔT₂ = ${num(d2)} K`, rows: { d1: `${num(d1)} K`, d2: `${num(d2)} K`, arith: `${num((d1 + d2) / 2)} K` }, steps: ['LMTD = (ΔT₁ − ΔT₂) ÷ ln(ΔT₁/ΔT₂)', `= ${num(lm)} K`, 'Q = U A LMTD'] };
        },
    },
    mean_free_path: {
        type: 'calc',
        inputs: { gas: GAS('air'), d: ['Molecular diameter', 'length', 'nm', 0.365], P: ['Pressure', 'pressure', 'pa', 101325], T: ['Temperature', 'temperature', 'c', 20] },
        show: { d: 'gas:custom' },
        when: { d: (x) => x.gas === 'custom' },
        data: ['gases'],
        out: 'length',
        outUnit: 'nm',
        label: 'Mean free path',
        rows: { n: 'Number density', coll: 'Collisions per second (one molecule)' },
        run: (x, ctx) => {
            const d = x.gas === 'custom' ? x.d : gas(ctx, x.gas).d * 1e-12;
            const M = x.gas === 'custom' ? 0.029 : gas(ctx, x.gas).molar / 1000;
            const lambda = (K.k * x.T) / (Math.SQRT2 * Math.PI * d * d * x.P);
            const vmean = Math.sqrt((8 * R * x.T) / (Math.PI * M));

            return { value: lambda, sub: `${num(x.P / (K.k * x.T))} molecules per m³`, rows: { n: `${num(x.P / (K.k * x.T))} m⁻³`, coll: `${num(vmean / lambda)} s⁻¹` }, steps: ['λ = kT ÷ (√2 π d² P)', `d = ${num(d * 1e12)} pm`, `λ = ${num(lambda * 1e9)} nm`] };
        },
    },
    mixed_air: {
        type: 'calc',
        inputs: { Q1: ['Stream 1 flow', 'flow', 'm3h', 1000], T1: ['Stream 1 temperature', 'temperature', 'c', 30], rh1: ['Stream 1 relative humidity (%)', null, null, 60, 0], Q2: ['Stream 2 flow', 'flow', 'm3h', 3000], T2: ['Stream 2 temperature', 'temperature', 'c', 22], rh2: ['Stream 2 relative humidity (%)', null, null, 50, 0], p: ['Air pressure', 'pressure', 'kpa', 101.325] },
        out: 'temperature',
        outUnit: 'c',
        label: 'Mixed air temperature',
        rows: { rh: 'Mixed relative humidity', W: 'Humidity ratio', h: 'Enthalpy', dew: 'Dew point' },
        run: (x) => {
            const s1 = psychro(x.T1, (x.rh1 / 100) * satPressure(x.T1), x.p);
            const s2 = psychro(x.T2, (x.rh2 / 100) * satPressure(x.T2), x.p);
            const m1 = x.Q1 / s1.v;
            const m2 = x.Q2 / s2.v;
            const W = (m1 * s1.W + m2 * s2.W) / (m1 + m2);
            const h = (m1 * s1.h + m2 * s2.h) / (m1 + m2);
            const t = (h - 2501 * W) / (1.006 + 1.86 * W);
            const T = t + 273.15;
            const pv = (W * x.p) / (0.621945 + W);

            return { value: T, sub: `W = ${num(W * 1000, 4)} g/kg`, rows: { rh: `${num((pv / satPressure(T)) * 100, 4)}%`, W: `${num(W * 1000, 4)} g/kg`, h: `${num(h, 4)} kJ/kg`, dew: fmtC(dewPoint(pv)) }, steps: ['Mass balance on dry air, water and enthalpy (adiabatic mixing)', `Dry-air flows ${num(m1)} and ${num(m2)} kg/s`, `h = ${num(h)} kJ/kg → t = ${num(t)} °C`] };
        },
    },
    mixed_air_temperature: {
        type: 'calc',
        inputs: { To: ['Outdoor air temperature', 'temperature', 'c', 5], Tr: ['Return air temperature', 'temperature', 'c', 22], x: ['Outdoor air share (%)', null, null, 30, 0] },
        out: 'temperature',
        outUnit: 'c',
        label: 'Mixed air temperature',
        rows: { f: 'In °F' },
        run: (v) => {
            const T = (v.x / 100) * v.To + (1 - v.x / 100) * v.Tr;

            return { value: T, sub: `${num(v.x)}% outdoor air`, rows: { f: `${num(C(T) * 1.8 + 32, 4)} °F` }, steps: ['T_m = x T_o + (1 − x) T_r (sensible mixing)', `= ${fmtC(T)}`] };
        },
    },
    newton_cooling: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { k: 'The cooling constant', two: 'A second reading (finds k)' }, 'two'], T0: ['Starting temperature', 'temperature', 'c', 90], Ta: ['Surroundings', 'temperature', 'c', 20], k: ['Cooling constant (per minute)', null, null, 0.05, 0], t1: ['Time of the second reading', 'time', 'min', 10], T1: ['Second reading', 'temperature', 'c', 60], t: ['Time to evaluate', 'time', 'min', 30] },
        show: { k: 'mode:k', t1: 'mode:two', T1: 'mode:two' },
        when: { k: (x) => x.mode === 'k', t1: (x) => x.mode === 'two', T1: (x) => x.mode === 'two' },
        out: 'temperature',
        outUnit: 'c',
        label: 'Temperature at that time',
        rows: { k: 'Cooling constant', half: 'Time to halve the difference', to40: 'Time to reach 40 °C' },
        plots: [['curve', 'Cooling curve']],
        run: (x) => {
            const k = x.mode === 'k' ? x.k / 60 : -Math.log((x.T1 - x.Ta) / (x.T0 - x.Ta)) / x.t1;

            if (!(k > 0)) {
                return { error: 'The readings must approach the surrounding temperature.' };
            }

            const at = (t) => x.Ta + (x.T0 - x.Ta) * Math.exp(-k * t);
            const span = Math.max(x.t, 5 / k);
            const to40 = (313.15 - x.Ta) / (x.T0 - x.Ta);

            return { value: at(x.t), sub: `k = ${num(k * 60)} per minute`, rows: { k: `${num(k * 60)} per minute`, half: `${num(Math.LN2 / k / 60)} min`, to40: to40 > 0 && to40 < 1 ? `${num(-Math.log(to40) / k / 60)} min` : 'Never (40 °C is outside the range)' }, steps: ['T(t) = T_a + (T₀ − T_a) e^(−kt)', x.mode === 'two' ? `k = −ln((T₁ − T_a)/(T₀ − T_a)) ÷ t₁ = ${num(k * 60)} /min` : '', `T(${num(x.t / 60)} min) = ${fmtC(at(x.t))}`].filter(Boolean), plots: { curve: { series: Array.from({ length: 101 }, (_, n) => [(span * n) / 100 / 60, C(at((span * n) / 100))]), axes: true, xLabel: 'Time (min)', yLabel: 'Temperature (°C)' } } };
        },
    },
    nusselt: pw({ vars: { Nu: ['Nusselt number', null, null, 50], h: ['Heat transfer coefficient', 'heat_transfer_coefficient', 'wm2k', 1000], L: ['Characteristic length', 'length', 'mm', 30], k: ['Fluid conductivity', 'thermal_conductivity', 'wmk', 0.6] }, out: 'Nu', exp: { h: 1, L: 1, k: -1 }, eq: 'Nu = h L ÷ k', forms: { Nu: 'Nu = hL ÷ k', h: 'h = Nu k ÷ L', L: 'L = Nu k ÷ h', k: 'k = hL ÷ Nu' }, rows: { meaning: 'Meaning' }, extra: () => ({ meaning: 'Convective heat transfer relative to pure conduction across the same layer' }) }),
    particle_speeds: {
        type: 'calc',
        inputs: { gas: GAS('nitrogen'), M: ['Molar mass (g/mol)', null, null, 28, 0], T: ['Temperature', 'temperature', 'c', 25] },
        show: { M: 'gas:custom' },
        when: { M: (x) => x.gas === 'custom' },
        data: ['gases'],
        out: 'speed',
        outUnit: 'ms',
        label: 'RMS speed',
        rows: { vp: 'Most probable speed', vm: 'Mean speed', ratio: 'Ratio v_p : v̄ : v_rms' },
        plots: [['dist', 'Maxwell–Boltzmann speed distribution']],
        run: (x, ctx) => {
            const M = (x.gas === 'custom' ? x.M : gas(ctx, x.gas).molar) / 1000;
            const vp = Math.sqrt((2 * R * x.T) / M);
            const vm = Math.sqrt((8 * R * x.T) / (Math.PI * M));
            const vr = Math.sqrt((3 * R * x.T) / M);
            const a = M / (2 * R * x.T);
            const series = Array.from({ length: 121 }, (_, k) => {
                const v = (3 * vp * k) / 120;

                return [v, 4 * Math.PI * (a / Math.PI) ** 1.5 * v * v * Math.exp(-a * v * v) * 1000];
            });

            return { value: vr, sub: `Most probable ${num(vp)} m/s, mean ${num(vm)} m/s`, rows: { vp: `${num(vp)} m/s`, vm: `${num(vm)} m/s`, ratio: '1 : 1.128 : 1.225' }, steps: ['v_p = √(2RT/M), v̄ = √(8RT/πM), v_rms = √(3RT/M)', `M = ${num(M * 1000)} g/mol, T = ${num(x.T)} K`], plots: { dist: { series, axes: true, xLabel: 'Speed (m/s)', yLabel: 'Probability per km/s' } } };
        },
    },
    rms_velocity: pw({ vars: { v: ['RMS speed', 'speed', 'ms', 515.24], T: ['Temperature', 'temperature', 'k', 298.15], M: ['Molar mass (g/mol)', null, null, 28] }, out: 'v', k: Math.sqrt(3 * R * 1000), exp: { T: 0.5, M: -0.5 }, eq: 'v_rms = √(3RT ÷ M)', forms: { v: 'v = √(3RT/M)', T: 'T = Mv² ÷ 3R', M: 'M = 3RT ÷ v²' }, rows: { ke: 'Mean kinetic energy per molecule' }, extra: (v) => ({ ke: `${num(1.5 * K.k * v.T)} J (${num((1.5 * K.k * v.T) / K.e * 1000)} meV)` }) }),
    sensible_heat: {
        type: 'calc',
        inputs: { Q: ['Air flow', 'flow', 'cfm', 1000], dT: ['Temperature difference', 'temperature_difference', 'f', 20] },
        out: 'power',
        outUnit: 'btuh',
        label: 'Sensible heat',
        rows: { kw: ['In kW', 'power'], rule: 'Imperial rule 1.08 × CFM × ΔT' },
        run: (x) => {
            const P = 1.204 * 1006 * x.Q * x.dT;

            return { value: P, sub: 'Standard air ρ = 1.204 kg/m³, c_p = 1.006 kJ/(kg·K)', rows: { kw: [P, 'power'], rule: `${num(1.08 * (x.Q / 4.719474e-4) * x.dT * 1.8)} BTU/h` }, steps: ['Q = ρ c_p V̇ ΔT', `= 1.204 × 1006 × ${num(x.Q)} × ${num(x.dT)} = ${num(P)} W`] };
        },
    },
    specific_gas_constant: {
        type: 'calc',
        inputs: { gas: GAS('air'), M: ['Molar mass (g/mol)', null, null, 28.9647, 0] },
        show: { M: 'gas:custom' },
        when: { M: (x) => x.gas === 'custom' },
        data: ['gases'],
        out: 'specific_heat',
        outUnit: 'jkgk',
        label: 'Specific gas constant',
        rows: { cp: 'c_p (from γ)', cv: 'c_v (from γ)' },
        run: (x, ctx) => {
            const gd = x.gas === 'custom' ? { molar: x.M, gamma: NaN } : gas(ctx, x.gas);
            const Rs = R / (gd.molar / 1000);

            return { value: Rs, sub: `R ÷ M = 8.314462 ÷ ${num(gd.molar / 1000)}`, rows: { cp: Number.isFinite(gd.gamma) ? `${num((gd.gamma * Rs) / (gd.gamma - 1))} J/(kg·K)` : 'Needs γ', cv: Number.isFinite(gd.gamma) ? `${num(Rs / (gd.gamma - 1))} J/(kg·K)` : 'Needs γ' }, steps: ['R_s = R ÷ M', `= ${num(Rs)} J/(kg·K)`] };
        },
    },
    thermal_conductivity: {
        type: 'calc',
        inputs: { mode: ['I know', 'select', { fourier: 'A heat-flow measurement', material: 'The material' }, 'fourier'], Q: ['Heat flow', 'power', 'w', 50], A: ['Area', 'area', 'm2', 1], L: ['Thickness', 'length', 'mm', 20], dT: ['Temperature difference', 'temperature_difference', 'k', 25], mat: ['Material', 'select', 'data:thermal:fixed', 'brick'] },
        show: { Q: 'mode:fourier', A: 'mode:fourier', L: 'mode:fourier', dT: 'mode:fourier', mat: 'mode:material' },
        when: { Q: (x) => x.mode === 'fourier', A: (x) => x.mode === 'fourier', L: (x) => x.mode === 'fourier', dT: (x) => x.mode === 'fourier' },
        data: ['thermal'],
        out: 'thermal_conductivity',
        outUnit: 'wmk',
        label: 'Thermal conductivity',
        rows: { R: 'Thermal resistance of 100 mm', class: 'Class' },
        run: (x, ctx) => {
            const k = x.mode === 'fourier' ? (x.Q * x.L) / (x.A * x.dT) : thermal(ctx, x.mat).k;

            return { value: k, sub: x.mode === 'fourier' ? 'Fourier: k = QL ÷ (A ΔT)' : `${thermal(ctx, x.mat).name} (typical)`, rows: { R: `${num(0.1 / k, 4)} m²·K/W`, class: k < 0.06 ? 'Insulator' : k < 2 ? 'Poor conductor' : 'Conductor' }, steps: ['k = QL ÷ (AΔT)', `= ${num(k)} W/(m·K)`] };
        },
    },
    thermal_diffusivity: {
        type: 'calc',
        inputs: { mat: ['Material', 'select', 'data:thermal', 'concrete'], k: ['Thermal conductivity', 'thermal_conductivity', 'wmk', 1], rho: ['Density', 'density', 'kgm3', 2000], cp: ['Specific heat', 'specific_heat', 'jkgk', 1000] },
        show: { k: 'mat:custom', rho: 'mat:custom', cp: 'mat:custom' },
        when: { k: (x) => x.mat === 'custom', rho: (x) => x.mat === 'custom', cp: (x) => x.mat === 'custom' },
        data: ['thermal'],
        label: 'Thermal diffusivity',
        rows: { mm: 'In mm²/s', depth: 'Heat penetration in 1 hour (≈ √(αt))', eff: 'Thermal effusivity' },
        run: (x, ctx) => {
            const m = x.mat === 'custom' ? { k: x.k, density: x.rho, cp: x.cp } : thermal(ctx, x.mat);
            const a = m.k / (m.density * m.cp);

            return { value: num(a), unit: 'm²/s', sub: `${num(a * 1e6)} mm²/s`, rows: { mm: `${num(a * 1e6)} mm²/s`, depth: `${num(Math.sqrt(a * 3600) * 1000)} mm`, eff: `${num(Math.sqrt(m.k * m.density * m.cp))} W·s^½/(m²·K)` }, steps: ['α = k ÷ (ρ c_p)', `= ${num(m.k)} ÷ (${num(m.density)} × ${num(m.cp)}) = ${num(a)} m²/s`] };
        },
    },
    thermal_efficiency: {
        type: 'calc',
        inputs: { W: ['Work output', 'power', 'kw', 35], Q: ['Heat input', 'power', 'kw', 100], Th: ['Hot temperature (optional)', 'temperature', 'c', 500], Tc: ['Cold temperature (optional)', 'temperature', 'c', 30] },
        optional: ['Th', 'Tc'],
        label: 'Thermal efficiency',
        rows: { rejected: 'Heat rejected', carnot: 'Carnot limit', share: 'Share of the Carnot limit reached' },
        run: (x) => {
            const eta = x.W / x.Q;
            const carnot = Number.isFinite(x.Th) && Number.isFinite(x.Tc) ? 1 - x.Tc / x.Th : NaN;

            return { value: `${num(eta * 100, 4)}%`, sub: `Rejects ${num((x.Q - x.W) / 1000)} kW`, rows: { rejected: `${num((x.Q - x.W) / 1000)} kW`, carnot: Number.isFinite(carnot) ? `${num(carnot * 100, 4)}%` : 'Enter both temperatures', share: Number.isFinite(carnot) ? `${num((eta / carnot) * 100, 4)}%${eta > carnot ? ' (impossible: exceeds Carnot)' : ''}` : 'Enter both temperatures' }, steps: ['η = W ÷ Q_in', `= ${num(eta)}`, 'No heat engine can beat 1 − T_c/T_h'] };
        },
    },
    thermal_energy: pw({ vars: { Q: ['Heat energy', 'energy', 'kj', 334.56], m: ['Mass', 'mass', 'kg', 1], c: ['Specific heat', 'specific_heat', 'jkgk', 4182], dT: ['Temperature change', 'temperature_difference', 'k', 80] }, out: 'Q', exp: { m: 1, c: 1, dT: 1 }, eq: 'Q = m c ΔT', forms: { Q: 'Q = mcΔT', m: 'm = Q ÷ cΔT', c: 'c = Q ÷ mΔT', dT: 'ΔT = Q ÷ mc' }, rows: { kwh: 'In kWh' }, extra: (v) => ({ kwh: `${num(v.Q / 3.6e6)} kWh` }) }),
    thermal_equilibrium: {
        type: 'calc',
        inputs: { bodies: ['Bodies: mass in kg, specific heat in J/(kg·K), temperature in °C (one per line)', 'textarea', null, '0.5, 4182, 20\n0.2, 900, 100\n0.1, 385, 60'] },
        out: 'temperature',
        outUnit: 'c',
        label: 'Equilibrium temperature',
        rows: { C: 'Total heat capacity', each: 'Heat gained (+) or lost (−) by each' },
        run: (x) => {
            const rows = String(x.bodies).split(/\n|;/).map((l) => l.trim()).filter(Boolean).map((l) => l.split(/[,\s]+/).map(Number));

            if (!rows.length || rows.some((r) => r.length !== 3 || !r.every(Number.isFinite) || r[0] <= 0 || r[1] <= 0)) {
                return { empty: 'Type each body as mass, specific heat, temperature.' };
            }

            const Ct = rows.reduce((s, [m, c]) => s + m * c, 0);
            const Tf = rows.reduce((s, [m, c, t]) => s + m * c * t, 0) / Ct;

            return { value: Tf + 273.15, sub: `${rows.length} bodies, no phase changes`, rows: { C: `${num(Ct)} J/K`, each: rows.map(([m, c, t], k) => `#${k + 1}: ${num(m * c * (Tf - t))} J`).join(', ') }, steps: ['Σ m c (T_f − T) = 0 → T_f = Σ mcT ÷ Σ mc', `= ${num(Tf)} °C`] };
        },
    },
    thermal_expansion: {
        type: 'calc',
        inputs: { mat: ['Material', 'select', 'data:thermal', 'steel'], alpha: ['Expansion coefficient (10⁻⁶/K)', null, null, 12], L: ['Length', 'length', 'm', 10], dT: ['Temperature change', 'temperature_difference', 'k', 40] },
        show: { alpha: 'mat:custom' },
        when: { alpha: (x) => x.mat === 'custom' },
        data: ['thermal'],
        out: 'length',
        outUnit: 'mm',
        label: 'Change in length',
        rows: { newL: ['New length', 'length'], area: 'Area change (2α)', vol: 'Volume change (3α)' },
        run: (x, ctx) => {
            const a = (x.mat === 'custom' ? x.alpha : thermal(ctx, x.mat).alpha) * 1e-6;

            if (!a) {
                return { error: 'No expansion coefficient is listed for this material.' };
            }

            const dL = a * x.L * x.dT;

            return { value: dL, sub: `α = ${num(a * 1e6)} × 10⁻⁶/K`, rows: { newL: [x.L + dL, 'length'], area: `${num(2 * a * x.dT * 100, 4)}%`, vol: `${num(3 * a * x.dT * 100, 4)}%` }, steps: ['ΔL = α L ΔT', `= ${num(a)} × ${num(x.L)} × ${num(x.dT)} = ${num(dL * 1000)} mm`] };
        },
    },
    thermal_resistance: {
        type: 'calc',
        inputs: { layers: ['Layers: thickness in mm, conductivity in W/(m·K) (one per line)', 'textarea', null, LAYER_SAMPLE], A: ['Area', 'area', 'm2', 10], dT: ['Temperature difference', 'temperature_difference', 'k', 20] },
        label: 'Thermal resistance',
        rows: { Rsq: 'Resistance per m² (R-value)', Rus: 'US R-value', Q: 'Heat flow', each: 'Each layer (m²·K/W)' },
        run: (x) => {
            const L = readLayers(x.layers);

            if (!L) {
                return { empty: 'Type each layer as thickness (mm), conductivity.' };
            }

            const rs = L.map(([t, k]) => t / 1000 / k);
            const Rsq = rs.reduce((a, b) => a + b, 0);

            return { value: num(Rsq / x.A), unit: 'K/W', sub: `R-value ${num(Rsq, 4)} m²·K/W`, rows: { Rsq: `${num(Rsq, 4)} m²·K/W`, Rus: `R-${num(Rsq * 5.678263, 3)} (ft²·°F·h/BTU)`, Q: `${num((x.dT * x.A) / Rsq)} W`, each: rs.map((r) => num(r, 3)).join(', ') }, steps: ['R = Σ t/k per m², R_total = R ÷ A', `= ${num(Rsq)} ÷ ${num(x.A)} = ${num(Rsq / x.A)} K/W`, 'Surface films not included (see the U-value calculator)'] };
        },
    },
    ton_kw: {
        type: 'calc',
        inputs: { P: ['Capacity', 'power', 'tr', 5] },
        out: 'power',
        outUnit: 'kw',
        label: 'Capacity',
        rows: { tr: ['In tons of refrigeration', 'power'], btu: 'In BTU/h' },
        run: (x) => ({ value: x.P, sub: '1 TR = 3.51685 kW', rows: { tr: [x.P, 'power'], btu: `${num(x.P / 0.29307107)} BTU/h` }, steps: ['1 ton of refrigeration = 12,000 BTU/h = 3.51685 kW', `= ${num(x.P / 1000)} kW`] }),
    },
    water_heating: {
        type: 'calc',
        inputs: { V: ['Water volume', 'volume', 'l', 150], T1: ['Starting temperature', 'temperature', 'c', 15], T2: ['Target temperature', 'temperature', 'c', 60], P: ['Heater power', 'power', 'kw', 3], eff: ['Efficiency (%)', null, null, 95, 0] },
        out: 'energy',
        outUnit: 'kwh',
        label: 'Energy needed',
        rows: { t: 'Heating time', mass: 'Water mass', boil: 'Note' },
        run: (x) => {
            const t1 = C(x.T1);
            const t2 = Math.min(C(x.T2), 100);
            const m = x.V * waterDensity(Math.max(0, t1));
            const Q = m * 4182 * (t2 - t1);
            const time = Q / (x.P * (x.eff / 100));

            return { value: Q, sub: `${num(time / 60)} min at ${num(x.P / 1000)} kW`, rows: { t: `${num(time / 3600, 4)} h (${num(time / 60)} min)`, mass: `${num(m)} kg`, boil: C(x.T2) > 100 ? 'Capped at 100 °C: boiling needs 2,256 kJ/kg more' : 'Heat losses during heating are ignored' }, steps: ['Q = m c ΔT, c = 4,182 J/(kg·K)', `= ${num(m)} × 4182 × ${num(t2 - t1)} = ${num(Q)} J`, `t = Q ÷ (P η) = ${num(time)} s`] };
        },
    },
    watts_heat: {
        type: 'calc',
        inputs: { P: ['Power', 'power', 'w', 1500] },
        out: 'power',
        outUnit: 'btuh',
        label: 'Heat output',
        rows: { kcal: 'In kcal/h', day: 'Energy per day' },
        run: (x) => ({ value: x.P, sub: 'Electric heaters turn all their power into heat', rows: { kcal: `${num(x.P * 0.859845)} kcal/h`, day: `${num((x.P * 24) / 1000)} kWh` }, steps: ['1 W = 3.41214 BTU/h = 0.86 kcal/h', `= ${num(x.P / 0.29307107)} BTU/h`] }),
    },
    adiabatic: {
        type: 'calc',
        inputs: { P1: ['Initial pressure', 'pressure', 'kpa', 100], V1: ['Initial volume', 'volume', 'l', 1], T1: ['Initial temperature', 'temperature', 'c', 20], gamma: ['γ (1.4 for air)', null, null, 1.4, 1], know: ['Final state given by', 'select', { V: 'Final volume', P: 'Final pressure' }, 'V'], V2: ['Final volume', 'volume', 'l', 0.1], P2: ['Final pressure', 'pressure', 'kpa', 2512] },
        show: { V2: 'know:V', P2: 'know:P' },
        when: { V2: (x) => x.know === 'V', P2: (x) => x.know === 'P' },
        out: 'temperature',
        outUnit: 'c',
        label: 'Final temperature',
        rows: { P2: ['Final pressure', 'pressure'], V2: ['Final volume', 'volume'], W: 'Work done on the gas' },
        run: (x) => {
            const g = x.gamma;
            const V2 = x.know === 'V' ? x.V2 : x.V1 * (x.P1 / x.P2) ** (1 / g);
            const P2 = x.know === 'P' ? x.P2 : x.P1 * (x.V1 / V2) ** g;
            const T2 = x.T1 * (P2 * V2) / (x.P1 * x.V1);
            const W = (P2 * V2 - x.P1 * x.V1) / (g - 1);

            return { value: T2, sub: `P₂ = ${num(P2 / 1000)} kPa, V₂ = ${num(V2 * 1000)} L`, rows: { P2: [P2, 'pressure'], V2: [V2, 'volume'], W: `${num(W)} J` }, steps: ['PV^γ = constant, TV^(γ−1) = constant (reversible, no heat exchange)', `T₂ = ${fmtC(T2)}`, 'W = (P₂V₂ − P₁V₁) ÷ (γ − 1)'] };
        },
    },
    heat_engine: {
        type: 'calc',
        inputs: { cycle: ['Cycle', 'select', { otto: 'Otto (petrol engine)', diesel: 'Diesel', brayton: 'Brayton (gas turbine)' }, 'otto'], r: ['Compression ratio', null, null, 10, 1], rc: ['Cut-off ratio (Diesel)', null, null, 2, 1], rp: ['Pressure ratio (Brayton)', null, null, 15, 1], gamma: ['γ', null, null, 1.4, 1] },
        show: { r: 'cycle:otto,diesel', rc: 'cycle:diesel', rp: 'cycle:brayton' },
        when: { r: (x) => x.cycle !== 'brayton', rc: (x) => x.cycle === 'diesel', rp: (x) => x.cycle === 'brayton' },
        label: 'Ideal thermal efficiency',
        rows: { note: 'Real engines', formula: 'Formula' },
        run: (x) => {
            const g = x.gamma;
            const eta = x.cycle === 'otto' ? 1 - x.r ** (1 - g) : x.cycle === 'diesel' ? 1 - (1 / x.r ** (g - 1)) * ((x.rc ** g - 1) / (g * (x.rc - 1))) : 1 - x.rp ** ((1 - g) / g);
            const formula = { otto: 'η = 1 − 1/r^(γ−1)', diesel: 'η = 1 − (1/r^(γ−1)) (r_c^γ − 1) ÷ (γ(r_c − 1))', brayton: 'η = 1 − 1/r_p^((γ−1)/γ)' }[x.cycle];

            return { value: `${num(eta * 100, 4)}%`, sub: 'Air-standard cycle, cold-air values', rows: { note: 'Friction, heat loss and real gas properties give much less: petrol cars about 30–38%, diesels 40–45%, combined-cycle plants about 60%', formula }, steps: [formula, `= ${num(eta)}`] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
