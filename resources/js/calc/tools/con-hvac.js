import { BTU_H, FT, FT2, FT3, IN, readRows } from '../construction/geometry.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Heating and cooling loads, airflow and insulation. Temperatures arrive in °C, areas in m², volumes in liters.
 *
 * Steady-state envelope model: Q = Σ U A ΔT + 0.018 × V × ACH × ΔT (Btu/h, ft², ft³, °F), where
 * 0.018 Btu/(ft³·°F) is the heat capacity of air (0.075 lb/ft³ × 0.24 Btu/(lb·°F)).
 */
const AIR = 0.018;
const R_SI = 5.678263337; // R (ft²·°F·h/Btu) per RSI (m²·K/W)
const PERSON_SENSIBLE = 230;
const PERSON_LATENT = 200;
const WATT = 3.412141633;

/**
 * Envelope components from a rows editor of [area, R]; returns UA in Btu/(h·°F) per component.
 */
function components(i, c, name = 'parts') {
    const factor = c.rowUnits?.[name]?.[i[`${name}_unit`]]?.factor ?? FT2;
    const rFactor = i.r_units === 'si' ? R_SI : 1;

    return readRows(i[name], [factor, rFactor]).filter(([a, r]) => a > 0 && r > 0).map(([a, r]) => ({ area: a / FT2, r, ua: a / FT2 / r }));
}

function airVolumeFt3(i) {
    if (i.floor > 0 && i.ceiling > 0) {
        return (i.floor * i.ceiling) / FT3;
    }

    return null;
}

const btu = (value, f) => `${f(value)} Btu/h (${f(value / WATT)} W)`;

export const handlers = {
    heat_loss: (i, c, f) => {
        const parts = components(i, c);

        if (!parts.length) {
            return { empty: 'Enter at least one wall, window, roof or floor with its area and R-value.' };
        }

        if (missing(i, 'inside', 'outside') || i.inside <= i.outside) {
            return { empty: 'Enter an indoor temperature above the outdoor design temperature.' };
        }

        const dt = ((i.inside - i.outside) * 9) / 5;
        const volume = airVolumeFt3(i);
        const envelope = parts.reduce((sum, p) => sum + p.ua * dt, 0);
        const air = volume && i.ach > 0 ? AIR * volume * i.ach * dt : 0;
        const total = envelope + air;

        return {
            value: f(total),
            unit: 'Btu/h',
            label: 'Design heat loss',
            sub: `${f(dt)} °F difference; ${f(total / WATT / 1000)} kW`,
            rows: {
                envelope: btu(envelope, f),
                air: volume ? btu(air, f) : 'Enter the floor area and ceiling height',
                kw: `${f(total / WATT / 1000)} kW`,
                per_ft2: i.floor > 0 ? `${f(total / (i.floor / FT2))} Btu/h per ft² of floor` : '—',
            },
            lists: { parts: [...parts.map((p, k) => ({ label: `Part ${k + 1}: ${f(p.area)} ft² at R-${f(p.r)}`, value: btu(p.ua * dt, f) })), ...(air ? [{ label: `Air leakage, ${f(i.ach)} ACH`, value: btu(air, f) }] : [])] },
        };
    },

    /**
     * Cooling load: conduction + solar through glass + air leakage + people + equipment (a simplified heat-gain model).
     */
    cooling: (i, c, f) => {
        const parts = components(i, c);

        if (!parts.length && !(i.glass > 0)) {
            return { empty: 'Enter the envelope parts or the window area.' };
        }

        if (missing(i, 'inside', 'outside') || i.outside <= i.inside) {
            return { empty: 'Enter an outdoor design temperature above the indoor temperature.' };
        }

        const dt = ((i.outside - i.inside) * 9) / 5;
        const conduction = parts.reduce((sum, p) => sum + p.ua * dt, 0);
        const glassFt2 = i.glass > 0 ? i.glass / FT2 : 0;
        const glassConduction = glassFt2 && i.glass_u > 0 ? glassFt2 * i.glass_u * dt : 0;
        const solar = glassFt2 && i.shgc > 0 && i.sun > 0 ? glassFt2 * i.shgc * i.sun : 0;
        const volume = airVolumeFt3(i);
        const air = volume && i.ach > 0 ? AIR * volume * i.ach * dt : 0;
        const people = i.people > 0 ? i.people * PERSON_SENSIBLE : 0;
        const latent = i.people > 0 ? i.people * PERSON_LATENT : 0;
        const equipment = i.equipment > 0 ? i.equipment * WATT : 0;
        const sensible = conduction + glassConduction + solar + air + people + equipment;
        const total = sensible + latent;
        const lines = [['Walls, roof and floor', conduction], ['Window conduction', glassConduction], ['Sun through windows', solar], ['Air leakage (sensible)', air], ['People (sensible)', people], ['People (latent)', latent], ['Lights and appliances', equipment]];

        return {
            value: f(total),
            unit: 'Btu/h',
            label: 'Cooling load',
            sub: `${f(total / 12000)} tons; ${f(dt)} °F difference`,
            rows: {
                tons: `${f(total / 12000)} tons`,
                sensible: btu(sensible, f),
                latent: btu(latent, f),
                kw: `${f(total / WATT / 1000)} kW`,
            },
            lists: { parts: lines.filter(([, v]) => v > 0).map(([label, v]) => ({ label, value: btu(v, f) })) },
        };
    },

    /**
     * Air conditioner size from a cooling load; ACCA Manual S allows 95–115% of the total load (heat pumps up to 125%).
     */
    ac_tonnage: (i, c, f) => {
        let load = i.load;

        if (i.load_unit_kind === 'kw') {
            load = i.load * 1000 * WATT;
        }

        if (!(load > 0)) {
            return { empty: 'Enter the cooling load.' };
        }

        const tons = load / 12000;
        const high = i.equipment === 'heat_pump' ? 1.25 : 1.15;
        const sizes = [1.5, 2, 2.5, 3, 3.5, 4, 5];
        const fits = sizes.filter((t) => t * 12000 >= 0.95 * load && t * 12000 <= high * load);

        return {
            value: f(tons),
            unit: 'tons',
            label: 'Cooling capacity',
            sub: `${f(load)} Btu/h ÷ 12,000`,
            rows: {
                range: `${f(0.95 * tons)}–${f(high * tons)} tons (95–${f(high * 100)}% of the load)`,
                sizes: fits.length ? `${fits.map((t) => `${t} ton`).join(', ')} fit` : 'No standard size fits; check the load or use two systems',
                kw: `${f(load / WATT / 1000)} kW of cooling`,
                btu: `${f(load)} Btu/h`,
            },
        };
    },

    /**
     * Furnace or boiler: input = load ÷ efficiency; ACCA Manual S allows furnace output up to 140% of the load.
     */
    heating_size: (i, c, f) => {
        if (missing(i, 'load', 'efficiency') || !(i.load > 0) || !(i.efficiency > 0 && i.efficiency <= 100)) {
            return { empty: 'Enter the heat loss and the efficiency (AFUE).' };
        }

        const extra = i.dhw > 0 ? i.dhw : 0;
        const output = i.load + extra;
        const input = output / (i.efficiency / 100);
        const max = c.data?.max ?? 1.4;

        return {
            value: f(input),
            unit: 'Btu/h input',
            label: c.data?.label ?? 'Furnace input',
            sub: `${f(output)} Btu/h output ÷ ${f(i.efficiency)}% efficiency`,
            rows: {
                output: btu(output, f),
                range: `${f(output)}–${f(i.load * max + extra)} Btu/h output (100–${f(max * 100)}% of the load)`,
                kw: `${f(input / WATT / 1000)} kW input, ${f(output / WATT / 1000)} kW output`,
                therms: `${f(input / 100000)} therms per hour at full fire`,
            },
        };
    },

    ach: (i, c, f) => {
        const volume = i.floor > 0 && i.ceiling > 0 ? (i.floor * i.ceiling) / FT3 : null;

        if (!volume) {
            return { empty: 'Enter the floor area and ceiling height.' };
        }

        if (i.mode === 'cfm') {
            if (!(i.target > 0)) {
                return { empty: 'Enter the air changes per hour you want.' };
            }

            const cfm = (i.target * volume) / 60;

            return { value: f(cfm), unit: 'CFM', label: 'Airflow needed', sub: `${f(i.target)} ACH × ${f(volume)} ft³ ÷ 60`, rows: { m3h: `${f(cfm * 1.6990108)} m³/h`, ls: `${f(cfm * 0.47194745)} L/s`, volume: `${f(volume)} ft³ (${f(volume * 0.0283168466)} m³)`, minutes: `A full air change every ${f(60 / i.target)} min` } };
        }

        if (!(i.cfm > 0)) {
            return { empty: 'Enter the airflow in CFM.' };
        }

        const ach = (i.cfm * 60) / volume;

        return { value: f(ach), unit: 'ACH', label: 'Air changes per hour', sub: `${f(i.cfm)} CFM × 60 ÷ ${f(volume)} ft³`, rows: { m3h: `${f(i.cfm * 1.6990108)} m³/h`, ls: `${f(i.cfm * 0.47194745)} L/s`, volume: `${f(volume)} ft³ (${f(volume * 0.0283168466)} m³)`, minutes: `A full air change every ${f(60 / ach)} min` } };
    },

    cfm: (i, c, f) => {
        let cfm;
        let sub;

        if (i.mode === 'room') {
            const volume = i.floor > 0 && i.ceiling > 0 ? (i.floor * i.ceiling) / FT3 : null;

            if (!volume || !(i.ach > 0)) {
                return { empty: 'Enter the floor area, ceiling height and air changes per hour.' };
            }

            cfm = (volume * i.ach) / 60;
            sub = `${f(volume)} ft³ × ${f(i.ach)} ACH ÷ 60`;
        } else if (i.mode === 'duct') {
            const area = i.duct === 'round' ? (i.diameter > 0 ? (Math.PI / 4) * i.diameter ** 2 : 0) : i.duct_width > 0 && i.duct_height > 0 ? i.duct_width * i.duct_height : 0;

            if (!area || !(i.velocity > 0)) {
                return { empty: 'Enter the duct size and air velocity.' };
            }

            cfm = (area / FT2) * i.velocity;
            sub = `${f(area / FT2)} ft² × ${f(i.velocity)} ft/min`;
        } else {
            if (!(i.btu > 0) || !(i.rise > 0)) {
                return { empty: 'Enter the heating or cooling output and the air temperature change.' };
            }

            cfm = i.btu / (1.08 * i.rise);
            sub = `${f(i.btu)} Btu/h ÷ (1.08 × ${f(i.rise)} °F)`;
        }

        return {
            value: f(cfm),
            unit: 'CFM',
            label: 'Airflow',
            sub,
            rows: { m3h: `${f(cfm * 1.6990108)} m³/h`, ls: `${f(cfm * 0.47194745)} L/s`, m3s: `${f(cfm * 0.00047194745)} m³/s` },
        };
    },

    insulation: (i, c, f) => {
        if (missing(i, 'target') || !(i.target > 0)) {
            return { empty: 'Enter the R-value you want.' };
        }

        const existing = i.existing > 0 ? i.existing : 0;
        const needed = i.target - existing;

        if (needed <= 0) {
            return { error: 'The existing insulation already meets the target.' };
        }

        const material = i.material === 'custom' ? { name: 'your material', low: i.per_inch, high: i.per_inch } : c.data.insulation[i.material];

        if (!(material.low > 0)) {
            return { empty: 'Enter the R-value per inch of your material.' };
        }

        const thick = needed / material.low;
        const thin = needed / material.high;
        const area = i.area > 0 ? i.area / FT2 : null;

        return {
            value: thick === thin ? f(thick) : `${f(thin)}–${f(thick)}`,
            unit: 'in',
            label: 'Thickness to add',
            sub: `R-${f(needed)} of ${material.name.toLowerCase()} at R-${f(material.low)}${material.high !== material.low ? `–${f(material.high)}` : ''} per inch`,
            rows: {
                mm: thick === thin ? `${f(thick * 25.4)} mm` : `${f(thin * 25.4)}–${f(thick * 25.4)} mm`,
                needed: `R-${f(needed)} (RSI ${f(needed / R_SI)})`,
                volume: area ? `${f((area * thick) / 12)} ft³ at the thickest (${f(area)} ft²)` : 'Enter an area',
                u: `U = ${f(1 / i.target)} Btu/(h·ft²·°F) at R-${f(i.target)}`,
            },
        };
    },
};

export default defineTools(handlers);
