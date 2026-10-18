import { GAL, KM, MILE, fuelPerLiter, greatCircle, litersPerMeter, money } from '../ecology/common.js';
import { civilSeconds, clock, durationText, fromCivilSeconds, longDate, parseDateTime } from '../everyday/dates.js';
import { defineTools } from '../engines/formula.js';

/**
 * Transportation: trips and fuel, engines and gearing, tires, boats and flying.
 * Unit fields arrive in base units: meters, m/s, grams, watts, N·m, pascals, liters.
 */
const HP = 745.6998715822702;
const PSI = 6894.757293168361;
const LB = 453.59237;
const INCH = 0.0254;
const KNOT = 1852 / 3600;
const P0 = 101325;
const hours = (seconds) => durationText(seconds, { units: ['day', 'h', 'min'] });

/**
 * Standard-atmosphere pressure in pascals at an altitude in meters (ISA troposphere).
 */
export const pressureAt = (altitude) => P0 * (1 - 2.25577e-5 * (altitude || 0)) ** 5.25588;

/**
 * Fuel price per liter from a price and its unit (per US gallon or per liter).
 */
const perLiter = (price, unit) => (unit === 'gal' ? price / GAL : unit === 'gal_uk' ? price / 4.54609 : price);

/**
 * Tire size code → { width mm, aspect %, rim in, diameter m }: metric (225/45R17, P225/45ZR17) or flotation (31x10.50R15).
 */
export function parseTire(code) {
    const text = String(code ?? '').toUpperCase().replace(/\s+/g, '');
    let match = /^(?:P|LT|T)?(\d{3})\/(\d{2,3})(?:Z?R|D|B|-)(\d{2}(?:\.\d)?)/.exec(text);

    if (match) {
        const [width, aspect, rim] = [Number(match[1]), Number(match[2]), Number(match[3])];

        return { width: width / 1000, aspect, rim: rim * INCH, sidewall: (width * aspect) / 100 / 1000, diameter: rim * INCH + (2 * width * aspect) / 100 / 1000, kind: 'metric' };
    }

    match = /^(\d{2}(?:\.\d+)?)X(\d{1,2}(?:\.\d+)?)(?:R|-|LT)?R?(\d{2}(?:\.\d)?)/.exec(text);

    if (match) {
        const [diameter, width, rim] = [Number(match[1]), Number(match[2]), Number(match[3])];

        return { width: width * INCH, aspect: Math.round((((diameter - rim) / 2) / width) * 100), rim: rim * INCH, sidewall: ((diameter - rim) / 2) * INCH, diameter: diameter * INCH, kind: 'flotation' };
    }

    return null;
}

/**
 * Piston distance from top dead center at a crank angle (degrees after TDC), from stroke and rod length.
 */
export function pistonPosition(angle, stroke, rod) {
    const r = stroke / 2;
    const t = (angle * Math.PI) / 180;

    return r * (1 - Math.cos(t)) + rod - Math.sqrt(rod * rod - (r * Math.sin(t)) ** 2);
}

function fuelTrip(i, c) {
    const lpm = litersPerMeter(i.economy, i.economy_unit);

    if (!(i.distance > 0) || !lpm) {
        return null;
    }

    const meters = i.distance * (i.round_trip ? 2 : 1);
    const liters = meters * lpm;
    const cost = i.price > 0 ? liters * perLiter(i.price, i.price_unit) : null;

    return { meters, liters, cost };
}

const distanceText = (meters, f) => `${f(meters / MILE)} mi (${f(meters / KM)} km)`;
const fuelText = (liters, f) => `${f(liters / GAL)} US gal (${f(liters)} L)`;

export const handlers = {
    boat_speed: (i, c, f) => {
        i = { ...i, constant: Number(i.constant) };

        if (!(i.power > 0) || !(i.weight > 0) || !(i.constant > 0)) {
            return { empty: 'Enter the horsepower, boat weight and hull type.' };
        }

        const lbPerHp = i.weight / LB / (i.power / HP);
        const knots = i.constant / Math.sqrt(lbPerHp);

        return {
            value: f(knots),
            unit: 'knots',
            label: 'Estimated top speed',
            sub: `Crouch's formula: ${f(i.constant)} ÷ √(${f(lbPerHp)} lb per hp)`,
            rows: { mph: `${f(knots * 1.150779)} mph`, kmh: `${f(knots * 1.852)} km/h`, ratio: `${f(lbPerHp)} lb per shaft horsepower`, note: 'Planing hulls only; propeller, trim and load change real speed' },
        };
    },

    boost_hp: (i, c, f) => {
        if (!(i.power > 0) || !(i.boost >= 0)) {
            return { empty: 'Enter the engine\'s sea-level horsepower and the boost pressure.' };
        }

        const atmosphere = pressureAt(i.altitude);
        const ratio = (atmosphere + i.boost) / atmosphere;
        const natural = (i.power * atmosphere) / P0;
        const boosted = natural * ratio;

        return {
            value: f(boosted / HP),
            unit: 'hp',
            label: 'Boosted horsepower (ideal)',
            sub: `${f(natural / HP)} hp × pressure ratio ${f(ratio)}`,
            rows: { kw: `${f(boosted / 1000)} kW`, gain: `${f((boosted - natural) / HP)} hp more than without boost`, ratio: `${f(ratio)} (${f(atmosphere / PSI)} psi air + ${f(i.boost / PSI)} psi boost)`, natural: `${f(natural / HP)} hp naturally aspirated at this altitude` },
        };
    },

    bsfc: (i, c, f) => {
        const flow = i.flow_unit === 'kg_h' ? i.flow : i.flow * (LB / 1000);

        if (!(flow > 0) || !(i.power > 0)) {
            return { empty: 'Enter the fuel flow and the power at that moment.' };
        }

        const gPerKwh = (flow * 1000) / (i.power / 1000);
        const lhv = c.data.fuel_lhv[i.fuel];
        const efficiency = 3.6 / ((gPerKwh / 1000) * lhv);

        return {
            value: f(gPerKwh / 608.277),
            unit: 'lb/hp·h',
            label: 'Brake specific fuel consumption',
            sub: `${f(gPerKwh)} g/kWh`,
            rows: { metric: `${f(gPerKwh)} g/kWh`, efficiency: `${f(efficiency * 100)}% brake thermal efficiency at ${lhv} MJ/kg`, typical: 'Gasoline engines often run 0.45–0.55 lb/hp·h, turbo diesels 0.33–0.40' },
        };
    },

    carpool: (i, c, f) => {
        const trip = fuelTrip(i, c);

        if (!trip || !(i.riders >= 1)) {
            return { empty: 'Enter the distance, riders and fuel economy.' };
        }

        const extras = (i.tolls > 0 ? i.tolls : 0) + (i.parking > 0 ? i.parking : 0);
        const fuel = trip.cost ?? 0;
        const total = fuel + extras;
        const fuelCo2 = fuelPerLiter(i.fuel, c);
        const co2Saved = fuelCo2 ? trip.liters * fuelCo2.kg * (i.riders - 1) : null;

        return {
            value: money(total / i.riders),
            label: 'Cost per person',
            sub: `${money(total)} shared by ${f(i.riders)} (${money(fuel)} fuel + ${money(extras)} tolls and parking)`,
            rows: {
                fuel: fuelText(trip.liters, f),
                saving: `${money(total - total / i.riders)} saved by each rider against driving alone`,
                co2: co2Saved === null ? '—' : `${f(co2Saved)} kg CO₂ saved if each rider would have driven a similar car`,
                distance: distanceText(trip.meters, f),
            },
        };
    },

    commute: (i, c, f) => {
        if (!(i.minutes > 0) || !(i.days > 0)) {
            return { empty: 'Enter the one-way travel time and days a week.' };
        }

        const weeks = i.weeks > 0 ? i.weeks : 48;
        const trips = i.days * weeks * 2;
        const seconds = trips * i.minutes * 60;
        const meters = i.distance > 0 ? trips * i.distance : null;
        const cost = i.cost_mode === 'per_trip' ? (i.fare > 0 ? trips * i.fare : null) : i.per_mile > 0 && meters ? (meters / MILE) * i.per_mile : null;

        return {
            value: f(seconds / 3600),
            unit: 'hours a year',
            label: 'Time spent commuting',
            sub: `${f(trips)} trips of ${f(i.minutes)} minutes (${f(i.days)} days a week, ${f(weeks)} weeks)`,
            rows: {
                days: `${f(seconds / 86400)} full days, or ${f(seconds / 3600 / 8)} eight-hour workdays`,
                cost: cost === null ? 'Enter a cost to see it' : `${money(cost)} a year (${money(cost / 12)} a month)`,
                distance: meters ? distanceText(meters, f) : 'Enter the distance to see it',
                week: `${hours((seconds / weeks))} a week`,
            },
        };
    },

    compression_ratio: (i, c, f) => {
        if (!(i.bore > 0) || !(i.stroke > 0) || !(i.chamber > 0)) {
            return { empty: 'Enter the bore, stroke and combustion chamber volume.' };
        }

        const area = (Math.PI * i.bore ** 2) / 4;
        const swept = area * i.stroke * 1e6;
        const gasketBore = i.gasket_bore > 0 ? i.gasket_bore : i.bore;
        const gasket = ((Math.PI * gasketBore ** 2) / 4) * (i.gasket > 0 ? i.gasket : 0) * 1e6;
        const deck = area * (Number.isFinite(i.deck) ? i.deck : 0) * 1e6;
        const piston = Number.isFinite(i.piston) ? i.piston : 0;
        const clearance = i.chamber + gasket + deck + piston;

        if (!(clearance > 0)) {
            return { error: 'The clearance volume must be positive: check the dome volume.' };
        }

        const ratio = (swept + clearance) / clearance;
        const cylinders = i.cylinders > 0 ? i.cylinders : 1;

        return {
            value: `${f(ratio)}:1`,
            label: 'Static compression ratio',
            sub: `(${f(swept)} + ${f(clearance)}) ÷ ${f(clearance)} cc`,
            rows: {
                swept: `${f(swept)} cc per cylinder`,
                clearance: `${f(clearance)} cc (chamber ${f(i.chamber)} + gasket ${f(gasket)} + deck ${f(deck)} + piston ${f(piston)})`,
                displacement: `${f((swept * cylinders) / 1000)} L (${f((swept * cylinders) / 16.387064)} in³) for ${f(cylinders)} cylinders`,
            },
        };
    },

    cr_psi: (i, c, f) => {
        if (!(i.ratio > 1)) {
            return { empty: 'Enter a compression ratio above 1.' };
        }

        let dynamic = i.ratio;

        if (i.ivc > 0 && i.stroke > 0 && i.rod > 0) {
            const effective = pistonPosition(180 + i.ivc, i.stroke, i.rod);
            dynamic = 1 + ((i.ratio - 1) * Math.min(i.stroke, effective)) / i.stroke;
        }

        const atmosphere = pressureAt(i.altitude);
        const n = i.n > 1 ? i.n : 1.2;
        const gauge = atmosphere * dynamic ** n - atmosphere;

        return {
            value: f(gauge / PSI),
            unit: 'psi',
            label: 'Estimated cranking pressure (gauge)',
            sub: `${f(atmosphere / PSI)} psi × ${f(dynamic)}^${f(n)} − ${f(atmosphere / PSI)} psi`,
            rows: {
                dynamic: i.ivc > 0 ? `${f(dynamic)}:1 dynamic ratio with the intake closing ${f(i.ivc)}° after BDC` : 'Static ratio used (enter cam timing for the dynamic ratio)',
                bar: `${f(gauge / 1e5)} bar`,
                adiabatic: `${f((atmosphere * dynamic ** 1.4 - atmosphere) / PSI)} psi if no heat were lost (n = 1.4)`,
                note: 'An estimate: valve timing, cranking speed and wear change real gauge readings',
            },
        };
    },

    crosswind: (i, c, f) => {
        const runway = i.runway_mode === 'number' ? i.runway * 10 : i.runway;

        if (!Number.isFinite(runway) || !Number.isFinite(i.direction) || !(i.speed >= 0)) {
            return { empty: 'Enter the runway, wind direction and wind speed.' };
        }

        const angle = (((i.direction - runway) % 360) + 540) % 360 - 180;
        const rad = (angle * Math.PI) / 180;
        const cross = i.speed * Math.sin(rad);
        const head = i.speed * Math.cos(rad);
        const gust = i.gust > 0 ? i.gust : null;

        return {
            value: f(Math.abs(cross) / KNOT),
            unit: 'knots',
            label: `Crosswind from the ${cross >= 0 ? 'right' : 'left'}`,
            sub: `Wind ${f(Math.abs(angle))}° off the runway heading of ${f((runway + 360) % 360)}°`,
            rows: {
                head: Math.abs(head / KNOT) < 0.05 ? 'None: the wind is straight across' : head > 0 ? `${f(head / KNOT)} kt headwind` : `${f(-head / KNOT)} kt tailwind`,
                gust: gust ? `${f(Math.abs(gust * Math.sin(rad)) / KNOT)} kt crosswind in gusts` : 'No gust entered',
                angle: `${f(Math.abs(angle))}°`,
                rule: `Quick check: ${Math.abs(angle) >= 60 ? 'all' : Math.abs(angle) >= 45 ? 'about ¾' : Math.abs(angle) >= 30 ? 'half' : Math.abs(angle) >= 15 ? 'a quarter' : 'almost none'} of the wind is crosswind`,
            },
        };
    },

    drive_time: (i, c, f) => {
        if (!(i.distance > 0) || !(i.speed > 0)) {
            return { empty: 'Enter the distance and average speed.' };
        }

        const driving = i.distance / i.speed;
        const every = i.break_every > 0 ? i.break_every * 3600 : null;
        const stops = every ? Math.max(0, Math.ceil(driving / every) - 1) : 0;
        const total = driving + stops * (i.break_minutes > 0 ? i.break_minutes * 60 : 0);
        const start = parseDateTime(i.depart);
        const arrive = start ? fromCivilSeconds(civilSeconds(start) + total) : null;

        return {
            value: hours(total),
            label: 'Total travel time',
            sub: `${hours(driving)} driving${stops ? ` + ${stops} breaks of ${f(i.break_minutes)} min` : ''}`,
            rows: {
                arrive: arrive ? `${longDate(arrive.date)}, ${clock(arrive.seconds).h12}` : 'Enter a departure time',
                driving: `${f(driving / 3600)} hours at ${f(i.speed / 0.44704)} mph (${f(i.speed * 3.6)} km/h)`,
                distance: distanceText(i.distance, f),
            },
        };
    },

    engine_hours: (i, c, f) => {
        if (!(i.hours > 0) || !(i.speed > 0)) {
            return { empty: 'Enter the engine hours and an average speed.' };
        }

        const meters = i.hours * 3600 * i.speed;

        return {
            value: f(meters / MILE),
            unit: 'miles',
            label: 'Equivalent miles',
            sub: `${f(i.hours)} h × ${f(i.speed / 0.44704)} mph average`,
            rows: { km: `${f(meters / KM)} km`, note: 'A convention: idling adds engine hours (and wear) without distance, so use a lower average speed for vehicles that idle a lot' },
        };
    },

    ev_charge: (i, c, f) => {
        i = { ...i, power: Number(i.power) };

        if (!(i.battery > 0) || !(i.power > 0) || !(i.target > i.start)) {
            return { empty: 'Enter the battery size, charger power and a target above the starting charge.' };
        }

        const efficiency = (i.efficiency > 0 ? i.efficiency : 90) / 100;
        const stored = (i.battery * (i.target - i.start)) / 100;
        const drawn = stored / efficiency;
        const seconds = (drawn / i.power) * 3600;

        return {
            value: hours(seconds),
            label: 'Charging time',
            sub: `${f(stored)} kWh into the battery ÷ (${f(i.power)} kW × ${f(efficiency * 100)}%)`,
            rows: {
                energy: `${f(drawn)} kWh from the grid`,
                cost: i.price > 0 ? money(drawn * i.price) : 'Enter an electricity price',
                taper: i.target > 80 && i.power > 22 ? 'DC fast charging slows above about 80%, so the last part takes longer' : 'Constant-rate estimate',
            },
        };
    },

    fuel_cost: (i, c, f) => {
        const trip = fuelTrip(i, c);

        if (!trip) {
            return { empty: 'Enter the distance and fuel economy.' };
        }

        return {
            value: trip.cost === null ? fuelText(trip.liters, f) : money(trip.cost),
            label: trip.cost === null ? 'Fuel needed' : 'Fuel cost',
            sub: `${distanceText(trip.meters, f)}${i.round_trip ? ' round trip' : ''}`,
            rows: {
                fuel: fuelText(trip.liters, f),
                mile: trip.cost === null ? 'Enter a fuel price' : `${money(trip.cost / (trip.meters / MILE))} per mile, ${money(trip.cost / (trip.meters / KM))} per km`,
                hundred: `${f((trip.liters / trip.meters) * 100000)} L/100 km`,
            },
        };
    },

    injector: (i, c, f) => {
        if (!(i.power > 0) || !(i.bsfc > 0) || !(i.cylinders > 0) || !(i.duty > 0)) {
            return { empty: 'Enter the power, BSFC, cylinders and duty cycle.' };
        }

        const lbPerHour = ((i.power / HP) * i.bsfc) / (i.cylinders * (i.duty / 100));
        const base = i.rated_pressure > 0 ? i.rated_pressure : 43.5 * PSI;
        const actual = i.pressure > 0 ? i.pressure : base;
        const rated = lbPerHour / Math.sqrt(actual / base);

        return {
            value: f(rated),
            unit: 'lb/h',
            label: 'Injector size needed (at the rated pressure)',
            sub: `${f(i.power / HP)} hp × ${f(i.bsfc)} ÷ (${f(i.cylinders)} × ${f(i.duty)}%)`,
            rows: {
                cc: `${f(rated * 10.5)} cc/min (lb/h × 10.5, the usual industry conversion)`,
                at: `${f(lbPerHour)} lb/h needed at ${f(actual / PSI)} psi`,
                pressure: `Flow scales with √(pressure): ${f(base / PSI)} → ${f(actual / PSI)} psi multiplies flow by ${f(Math.sqrt(actual / base))}`,
            },
        };
    },

    fuel_pump: (i, c, f) => {
        if (!(i.power > 0) || !(i.bsfc > 0)) {
            return { empty: 'Enter the power and BSFC.' };
        }

        const density = c.data.fuel_density[i.fuel];
        const margin = 1 + (i.margin > 0 ? i.margin : 0) / 100;
        const kgPerHour = ((i.power / HP) * i.bsfc * LB) / 1000;
        const litersPerHour = (kgPerHour / density) * margin;

        return {
            value: f(litersPerHour),
            unit: 'L/h',
            label: 'Pump flow needed',
            sub: `${f(i.power / HP)} hp × ${f(i.bsfc)} lb/hp·h ÷ ${density} kg/L, + ${f((margin - 1) * 100)}% margin`,
            rows: { gph: `${f(litersPerHour / GAL)} US gal/h`, lb: `${f((kgPerHour * 1000 * margin) / LB)} lb/h of fuel`, note: 'Check the pump\'s flow chart at your fuel pressure and voltage' },
        };
    },

    gas: (i, c, f) => {
        const trip = fuelTrip(i, c);

        if (!trip) {
            return { empty: 'Enter the distance and fuel economy.' };
        }

        const people = i.people > 0 ? i.people : 1;

        return {
            value: trip.cost === null ? fuelText(trip.liters, f) : money(trip.cost),
            label: trip.cost === null ? 'Gas needed' : 'Gas cost',
            sub: `${distanceText(trip.meters, f)}${i.round_trip ? ' round trip' : ' one way'}`,
            rows: {
                person: trip.cost === null ? 'Enter a gas price' : `${money(trip.cost / people)} each for ${f(people)}`,
                fuel: fuelText(trip.liters, f),
                tanks: i.tank > 0 ? `${f(trip.liters / i.tank)} tanks of ${fuelText(i.tank, f)}` : 'Enter the tank size',
            },
        };
    },

    gas_oil: (i, c, f) => {
        if (!(i.ratio > 0) || !(i.fuel > 0)) {
            return { empty: 'Enter the ratio and the amount of gas.' };
        }

        const oil = i.fuel / i.ratio;

        return {
            value: f(oil * 1000),
            unit: 'mL of oil',
            label: `Oil for ${f(i.ratio)}:1`,
            sub: `${fuelText(i.fuel, f)} ÷ ${f(i.ratio)}`,
            rows: { floz: `${f(oil / 0.0295735295625)} US fl oz`, mix: `${f((i.fuel + oil))} L of mix`, percent: `${f(100 / i.ratio)}% oil` },
            lists: { ratios: [16, 20, 25, 32, 40, 50].map((ratio) => ({ label: `${ratio}:1`, value: `${f((i.fuel / ratio) * 1000)} mL (${f(i.fuel / ratio / 0.0295735295625)} fl oz)`, highlight: ratio === i.ratio })) },
        };
    },

    gvwr: (i, c, f) => {
        if (!(i.gvwr > 0) || !(i.curb > 0)) {
            return { empty: 'Enter the GVWR and the curb weight.' };
        }

        const load = ['people', 'cargo', 'tongue'].reduce((sum, key) => sum + (i[key] > 0 ? i[key] : 0), 0);
        const capacity = i.gvwr - i.curb;
        const left = capacity - load;
        const lb = (g) => `${f(g / LB)} lb (${f(g / 1000)} kg)`;

        return {
            value: f(Math.abs(left) / LB),
            unit: 'lb',
            label: left >= 0 ? 'Payload left' : 'Over the GVWR by',
            sub: `${lb(capacity)} payload capacity − ${lb(load)} loaded`,
            rows: {
                kg: `${f(Math.abs(left) / 1000)} kg`,
                capacity: lb(capacity),
                gross: `${lb(i.curb + load)} gross weight of ${lb(i.gvwr)} allowed`,
                gcwr: i.gcwr > 0 && i.trailer > 0 ? (i.curb + load + i.trailer - (i.tongue > 0 ? i.tongue : 0) <= i.gcwr ? `Within the GCWR by ${lb(i.gcwr - (i.curb + load + i.trailer - (i.tongue > 0 ? i.tongue : 0)))}` : `Over the GCWR by ${lb(i.curb + load + i.trailer - (i.tongue > 0 ? i.tongue : 0) - i.gcwr)}`) : 'Enter the GCWR and trailer weight to check',
            },
        };
    },

    horsepower: (i, c, f) => {
        let watts;
        let detail;

        if (i.mode === 'torque') {
            if (!(i.torque > 0) || !(i.rpm > 0)) {
                return { empty: 'Enter the torque and the engine speed.' };
            }

            watts = i.torque * ((i.rpm * 2 * Math.PI) / 60);
            detail = `${f(i.torque / 1.3558179483314003)} lb-ft × ${f(i.rpm)} rpm ÷ 5,252`;
        } else {
            const lb = i.weight / LB;

            if (!(lb > 0)) {
                return { empty: 'Enter the vehicle weight with driver.' };
            }

            if (i.mode === 'et') {
                if (!(i.et > 0)) {
                    return { empty: 'Enter the ¼-mile elapsed time.' };
                }

                watts = lb * (5.825 / i.et) ** 3 * HP;
                detail = `${f(lb)} lb × (5.825 ÷ ${f(i.et)} s)³ (Hale, from elapsed time)`;
            } else {
                const mph = i.trap / 0.44704;

                if (!(mph > 0)) {
                    return { empty: 'Enter the ¼-mile trap speed.' };
                }

                watts = lb * (mph / 234) ** 3 * HP;
                detail = `${f(lb)} lb × (${f(mph)} mph ÷ 234)³ (Hale, from trap speed)`;
            }
        }

        return {
            value: f(watts / HP),
            unit: 'hp',
            label: i.mode === 'torque' ? 'Horsepower' : 'Estimated horsepower',
            sub: detail,
            rows: {
                kw: `${f(watts / 1000)} kW`,
                ps: `${f(watts / 735.49875)} PS (metric horsepower)`,
                torque: i.mode === 'torque' ? `${f(i.torque)} N·m` : 'Drag-strip formulas are estimates: traction and gearing change results',
            },
        };
    },

    idling: (i, c, f) => {
        const rate = i.rate_mode === 'own' ? i.rate : i.engine * c.data.idle;

        if (!(rate > 0) || !(i.minutes > 0)) {
            return { empty: 'Enter the engine size and minutes of idling a day.' };
        }

        const days = i.days > 0 ? i.days : 365;
        const liters = (rate * i.minutes * days) / 60;
        const fuel = fuelPerLiter(i.fuel, c);

        return {
            value: fuelText(liters, f),
            label: 'Fuel burned idling a year',
            sub: `${f(rate)} L/h × ${f(i.minutes)} min × ${f(days)} days`,
            rows: {
                cost: i.price > 0 ? `${money(liters * perLiter(i.price, i.price_unit))} a year` : 'Enter a fuel price',
                co2: fuel ? `${f(liters * fuel.kg)} kg CO₂ (${fuel.name})` : '—',
                ten: `${f((rate * 10 * 1000) / 60)} mL every 10 minutes`,
            },
        };
    },

    miles_per_year: (i, c, f) => {
        let perDay;
        let detail;

        if (i.mode === 'odometer') {
            const start = parseDateTime(i.start_date);
            const end = parseDateTime(i.end_date);

            if (!start || !end || !(i.end_miles > i.start_miles)) {
                return { empty: 'Enter two odometer readings and their dates.' };
            }

            const days = (civilSeconds(end) - civilSeconds(start)) / 86400;

            if (!(days > 0)) {
                return { error: 'The second reading must be after the first.' };
            }

            perDay = (i.end_miles - i.start_miles) / days;
            detail = `${f(i.end_miles - i.start_miles)} over ${f(days)} days`;
        } else {
            if (!(i.daily > 0) || !(i.days_week > 0)) {
                return { empty: 'Enter the distance a day and days a week.' };
            }

            perDay = (i.daily * i.days_week) / 7;
            detail = `${f(i.daily)} a day, ${f(i.days_week)} days a week`;
        }

        return {
            value: f(perDay * 365.25),
            unit: i.unit === 'km' ? 'km a year' : 'miles a year',
            label: 'Distance a year',
            sub: detail,
            rows: { month: `${f((perDay * 365.25) / 12)} a month`, week: `${f(perDay * 7)} a week`, day: `${f(perDay)} a day`, other: i.unit === 'km' ? `${f((perDay * 365.25) / 1.609344)} miles a year` : `${f(perDay * 365.25 * 1.609344)} km a year` },
        };
    },

    miles_to_dollars: (i, c, f) => {
        const row = c.data.irs_mileage.find(([key]) => key === i.rate);
        const cents = i.rate === 'custom' ? i.custom_rate : row?.[2];

        if (!(i.miles > 0) || !(cents > 0)) {
            return { empty: 'Enter the miles and a rate.' };
        }

        const trips = i.trips > 0 ? i.trips : 1;
        const total = (i.miles * trips * cents) / 100;

        return {
            value: money(total),
            label: 'Reimbursement',
            sub: `${f(i.miles * trips)} miles × ${f(cents)}¢${row ? ` (IRS: ${row[1]})` : ''}`,
            rows: { trip: `${money((i.miles * cents) / 100)} per trip`, km: `${f((cents / 100) / 1.609344 * 100)}¢ per km`, note: 'Use the rate in force when the trip was made' },
        };
    },

    miles_to_hours: (i, c, f) => {
        if (!(i.distance > 0) || !(i.speed > 0)) {
            return { empty: 'Enter the distance and speed.' };
        }

        const seconds = i.distance / i.speed;

        return {
            value: durationText(seconds, { units: ['day', 'h', 'min'] }),
            label: 'Travel time',
            sub: `${distanceText(i.distance, f)} at ${f(i.speed / 0.44704)} mph`,
            rows: { hours: `${f(seconds / 3600)} hours`, minutes: `${f(seconds / 60)} minutes`, pace: `${f(1609.344 / i.speed / 60)} min per mile` },
        };
    },

    mpg: (i, c, f) => {
        if (!(i.distance > 0) || !(i.fuel > 0)) {
            return { empty: 'Enter the distance driven and the fuel used.' };
        }

        const mpgUs = i.distance / MILE / (i.fuel / GAL);

        return {
            value: f(mpgUs),
            unit: 'mpg (US)',
            label: 'Fuel economy',
            sub: `${distanceText(i.distance, f)} on ${fuelText(i.fuel, f)}`,
            rows: {
                l100: `${f((i.fuel / i.distance) * 100000)} L/100 km`,
                kml: `${f(i.distance / 1000 / i.fuel)} km/L`,
                uk: `${f(i.distance / MILE / (i.fuel / 4.54609))} mpg (UK)`,
                cost: i.price > 0 ? `${money((i.fuel * perLiter(i.price, i.price_unit)) / (i.distance / MILE))} per mile` : 'Enter a fuel price',
            },
        };
    },

    nautical: (i, c, f) => {
        let meters;

        if (i.mode === 'coordinates') {
            const values = [i.lat1, i.lon1, i.lat2, i.lon2];

            if (!values.every(Number.isFinite) || Math.abs(i.lat1) > 90 || Math.abs(i.lat2) > 90) {
                return { empty: 'Enter two latitude and longitude pairs.' };
            }

            meters = greatCircle(i.lat1, i.lon1, i.lat2, i.lon2);
        } else {
            if (!(i.distance > 0)) {
                return { empty: 'Enter a distance.' };
            }

            meters = i.distance;
        }

        const time = i.knots > 0 ? (meters / 1852 / i.knots) * 3600 : null;

        return {
            value: f(meters / 1852),
            unit: 'nmi',
            label: i.mode === 'coordinates' ? 'Great-circle distance' : 'Nautical miles',
            sub: `${f(meters / KM)} km, ${f(meters / MILE)} statute miles`,
            rows: { time: time ? `${hours(time)} at ${f(i.knots)} knots` : 'Enter a speed in knots', degrees: `${f(meters / 1852 / 60)}° of arc (1 nmi = 1 minute of latitude)`, definition: '1 nautical mile = 1,852 m exactly' },
        };
    },

    pulse_per_mile: (i, c, f) => {
        const revs = i.tire_mode === 'diameter' ? (i.diameter > 0 ? MILE / (Math.PI * i.diameter) : NaN) : i.revs;

        if (!(revs > 0) || !(i.axle > 0) || !(i.pulses > 0)) {
            return { empty: 'Enter the tire size, axle ratio and pulses per revolution.' };
        }

        const ppm = revs * i.axle * i.pulses;

        return {
            value: f(Math.round(ppm)),
            unit: 'pulses per mile',
            label: 'Speed sensor setting',
            sub: `${f(revs)} tire revs/mile × ${f(i.axle)} axle × ${f(i.pulses)} pulses`,
            rows: { km: `${f(ppm / 1.609344)} pulses per km`, k: `${f(ppm / 1000)} K-factor (thousands of pulses per mile)`, driveshaft: `${f(revs * i.axle)} driveshaft revolutions per mile` },
        };
    },

    rpm: (i, c, f) => {
        if (!(i.speed > 0) || !(i.diameter > 0) || !(i.gear > 0) || !(i.axle > 0)) {
            return { empty: 'Enter the speed, tire diameter, gear and axle ratios.' };
        }

        const wheelRpm = (i.speed * 60) / (Math.PI * i.diameter);
        const rpm = wheelRpm * i.gear * i.axle;

        return {
            value: f(Math.round(rpm)),
            unit: 'rpm',
            label: 'Engine speed',
            sub: `${f(wheelRpm)} wheel rpm × ${f(i.gear)} × ${f(i.axle)}`,
            rows: { wheel: `${f(wheelRpm)} wheel rpm`, overall: `${f(i.gear * i.axle)}:1 overall ratio`, per1000: `${f((i.speed / 0.44704) * (1000 / rpm))} mph per 1,000 rpm` },
        };
    },

    speed: (i, c, f) => {
        const time = (Number.isFinite(i.h) ? i.h : 0) * 3600 + (Number.isFinite(i.m) ? i.m : 0) * 60 + (Number.isFinite(i.s) ? i.s : 0);
        let speed;
        let distance;
        let seconds;

        if (i.find === 'speed') {
            [distance, seconds] = [i.distance, time];
            speed = distance / seconds;
        } else if (i.find === 'distance') {
            [speed, seconds] = [i.speed, time];
            distance = speed * seconds;
        } else {
            [speed, distance] = [i.speed, i.distance];
            seconds = distance / speed;
        }

        if (!(speed > 0) || !(distance > 0) || !(seconds > 0) || !Number.isFinite(seconds)) {
            return { empty: 'Enter the two known values.' };
        }

        const values = {
            speed: { value: f(speed / 0.44704), unit: 'mph', label: 'Speed' },
            distance: { value: f(distance / MILE), unit: 'miles', label: 'Distance' },
            time: { value: durationText(seconds, { units: ['h', 'min', 's'] }), unit: '', label: 'Time' },
        }[i.find];

        return {
            ...values,
            sub: `${distanceText(distance, f)} in ${durationText(seconds, { units: ['h', 'min', 's'] })}`,
            rows: { kmh: `${f(speed * 3.6)} km/h`, ms: `${f(speed)} m/s`, knots: `${f(speed / KNOT)} knots`, pace: `${f(MILE / speed / 60)} min per mile (${f(KM / speed / 60)} min per km)` },
        };
    },

    speedo_gear: (i, c, f) => {
        if (!(i.revs > 0) || !(i.axle > 0) || !(i.drive > 0)) {
            return { empty: 'Enter tire revolutions per mile, axle ratio and drive gear teeth.' };
        }

        const exact = (i.revs * i.axle * i.drive) / 1001;
        const teeth = Math.round(exact);
        const error = (exact / teeth - 1) * 100;

        return {
            value: f(teeth),
            unit: 'teeth',
            label: 'Driven gear',
            sub: `${f(i.revs)} × ${f(i.axle)} × ${f(i.drive)} ÷ 1,001 = ${f(exact)}`,
            rows: { error: `Reads ${f(Math.abs(error))}% ${error >= 0 ? 'fast' : 'slow'} with ${teeth} teeth (at 60 mph shows ${f(60 * (1 + error / 100))})`, cable: 'Cable speedometers turn 1,001 times per indicated mile' },
        };
    },

    tesla: (i, c, f) => {
        const model = c.data.tesla.find(([key]) => key === i.model);

        if (!model || !(i.distance > 0) || !(i.price >= 0)) {
            return { empty: 'Choose a model and enter the distance and electricity price.' };
        }

        const kwh = (i.distance / MILE / 100) * model[2] * (1 + (i.loss > 0 ? i.loss : 0) / 100);
        const cost = kwh * i.price;
        const fullKwh = (model[3] / 100) * model[2];
        const gas = i.mpg > 0 && i.gas_price > 0 ? (i.distance / MILE / i.mpg) * i.gas_price : null;

        return {
            value: money(cost),
            label: `Cost to drive ${f(i.distance / MILE)} miles`,
            sub: `${f(kwh)} kWh at ${f(model[2])} kWh/100 mi (EPA)`,
            rows: {
                mile: `${money(cost / (i.distance / MILE))} per mile`,
                full: `${money(fullKwh * i.price)} for a full charge (about ${f(fullKwh)} kWh for ${model[3]} miles)`,
                gas: gas === null ? 'Enter a gas car\'s mpg and gas price' : `${money(gas)} in a ${f(i.mpg)} mpg gas car (${gas >= cost ? `${money(gas - cost)} more` : `${money(cost - gas)} less`} than charging)`,
            },
        };
    },

    ticket: (i, c, f) => {
        const passes = String(i.passes ?? '').split('\n').map((line) => line.trim().split(/\s+/).map(Number)).filter(([price, days]) => price > 0 && days > 0);

        if (!(i.fare > 0) || !(i.trips > 0) || !(i.weeks > 0)) {
            return { empty: 'Enter the single fare, trips a week and the number of weeks.' };
        }

        const days = i.weeks * 7;
        const options = [{ label: 'Single tickets', cost: i.fare * i.trips * i.weeks }];
        passes.forEach(([price, valid]) => {
            const count = Math.ceil(days / valid);
            options.push({ label: `${f(valid)}-day pass at ${money(price)} × ${count}`, cost: price * count, breakEven: Math.round((price / (i.fare * (valid / 7))) * 10) / 10 });
        });
        const best = options.reduce((a, b) => (b.cost < a.cost ? b : a));

        return {
            value: best.label.split(' ×')[0],
            label: 'Cheapest option',
            sub: `${money(best.cost)} for ${f(i.weeks)} weeks at ${f(i.trips)} trips a week`,
            rows: { saving: `${money(options[0].cost - best.cost)} less than single tickets`, per: `${money(best.cost / (i.trips * i.weeks))} per trip` },
            lists: { options: options.map((option) => ({ label: option.label, value: `${money(option.cost)}${option.breakEven ? ` · pays off above ${f(option.breakEven)} trips a week` : ''}`, highlight: option === best })) },
        };
    },

    tire_size: (i, c, f) => {
        const a = parseTire(i.tire);

        if (!a) {
            return { empty: 'Enter a tire size such as 225/45R17 or 31x10.50R15.' };
        }

        const b = i.compare ? parseTire(i.compare) : null;
        const inch = (m) => `${f(m / INCH)} in (${f(m * 1000)} mm)`;
        const revs = MILE / (Math.PI * a.diameter);
        const rows = {
            width: inch(a.width),
            sidewall: inch(a.sidewall),
            circumference: inch(Math.PI * a.diameter),
            revs: `${f(revs)} revs per mile (${f(KM / (Math.PI * a.diameter))} per km), unloaded`,
            compare: 'Enter a second size to compare',
        };

        if (b) {
            const change = (b.diameter / a.diameter - 1) * 100;
            rows.compare = `${inch(b.diameter)} tall: ${f(Math.abs(change))}% ${change >= 0 ? 'larger' : 'smaller'}; at an indicated 60 mph you would really go ${f(60 * (1 + change / 100))} mph`;
        }

        return {
            value: f(a.diameter / INCH),
            unit: 'in tall',
            label: `Diameter of ${String(i.tire).toUpperCase()}`,
            sub: `${f(a.diameter * 1000)} mm: ${a.kind === 'metric' ? `${f(a.rim / INCH)} in rim + 2 × ${f(a.sidewall * 1000)} mm sidewall` : 'flotation size in inches'}`,
            rows,
        };
    },

    traffic: (i, c, f) => {
        let density;

        if (i.mode === 'flow') {
            if (!(i.flow > 0) || !(i.speed > 0)) {
                return { empty: 'Enter the flow and the average speed.' };
            }

            density = i.flow / (i.speed * 3.6);
        } else {
            if (!(i.vehicles > 0) || !(i.length > 0)) {
                return { empty: 'Enter the vehicles counted and the road length.' };
            }

            density = i.vehicles / (i.length / KM);
        }

        const lanes = i.lanes > 0 ? i.lanes : 1;

        return {
            value: f(density),
            unit: 'vehicles/km',
            label: 'Traffic density',
            sub: `${f(density * 1.609344)} vehicles per mile${lanes > 1 ? `, ${f(density / lanes)} per km per lane` : ''}`,
            rows: {
                spacing: `${f((1000 / density) * lanes)} m between vehicles in a lane`,
                headway: i.mode === 'flow' ? `${f((3600 / i.flow) * lanes)} s between vehicles in a lane` : 'Enter flow and speed to see headway',
                los: 'Freeway level of service (HCM): A ≤ 7, B ≤ 11, C ≤ 16, D ≤ 22, E ≤ 28 passenger cars per km per lane',
            },
        };
    },

    turbo: (i, c, f) => {
        if (!(i.power > 0) || !(i.afr > 0) || !(i.bsfc > 0) || !(i.displacement > 0) || !(i.rpm > 0) || !(i.ve > 0)) {
            return { empty: 'Enter the power target, AFR, BSFC, displacement, RPM and VE.' };
        }

        const airflow = ((i.power / HP) * i.afr * i.bsfc) / 60;
        const tempR = (i.iat > -273 ? i.iat : 40) * 1.8 + 32 + 460;
        const cubicInches = i.displacement / 0.016387064;
        const mapPsi = (airflow * 639.6 * tempR) / ((i.ve / 100) * (i.rpm / 2) * cubicInches);
        const atmosphere = pressureAt(i.altitude) / PSI;
        const ratio = (mapPsi + (i.loss_after > 0 ? i.loss_after : 0)) / (atmosphere - (i.loss_before > 0 ? i.loss_before : 0));

        return {
            value: f(airflow),
            unit: 'lb/min',
            label: 'Airflow needed',
            sub: `Pressure ratio ${f(ratio)} at ${f(i.rpm)} rpm (Garrett method)`,
            rows: {
                ratio: f(ratio),
                map: `${f(mapPsi)} psia manifold pressure (${f(mapPsi - atmosphere)} psi boost)`,
                cfm: `${f(airflow / 0.0765)} cfm at sea-level air density (0.0765 lb/ft³)`,
                kg: `${f(airflow * 0.45359237 * 60)} kg/h`,
            },
        };
    },

    wheel_hp: (i, c, f) => {
        if (!(i.power > 0) || !(i.loss >= 0) || i.loss >= 100) {
            return { empty: 'Enter the horsepower and the drivetrain loss.' };
        }

        const keep = 1 - i.loss / 100;
        const result = i.direction === 'to_wheel' ? i.power * keep : i.power / keep;

        return {
            value: f(result / HP),
            unit: 'hp',
            label: i.direction === 'to_wheel' ? 'Wheel horsepower' : 'Crank horsepower',
            sub: `${f(i.power / HP)} hp ${i.direction === 'to_wheel' ? '×' : '÷'} ${f(keep)} (${f(i.loss)}% drivetrain loss)`,
            rows: { kw: `${f(result / 1000)} kW`, lost: `${f(Math.abs(result - i.power) / HP)} hp lost in the drivetrain`, note: 'Losses vary by car and dyno; measure on the same dyno to compare' },
        };
    },

    wheel_offset: (i, c, f) => {
        if (!(i.width > 0) || !Number.isFinite(i.offset)) {
            return { empty: 'Enter the wheel width and offset.' };
        }

        const back = i.width / 2 + i.offset;
        const front = i.width / 2 - i.offset;
        const rows = { front: `${f(front / INCH)} in (${f(front * 1000)} mm) from the hub face to the outer edge`, compare: 'Enter a second wheel to compare' };

        if (i.width2 > 0 && Number.isFinite(i.offset2)) {
            const back2 = i.width2 / 2 + i.offset2;
            const front2 = i.width2 / 2 - i.offset2;
            rows.compare = `Inner edge moves ${f(Math.abs(back2 - back) * 1000)} mm ${back2 >= back ? 'in' : 'out'}, outer edge ${f(Math.abs(front2 - front) * 1000)} mm ${front2 >= front ? 'out' : 'in'}`;
        }

        return {
            value: f(back / INCH),
            unit: 'in backspacing',
            label: 'Backspacing',
            sub: `${f(i.width / INCH)} in ÷ 2 + ${f(i.offset * 1000)} mm offset = ${f(back * 1000)} mm`,
            rows,
        };
    },

    winch: (i, c, f) => {
        if (!(i.weight > 0)) {
            return { empty: 'Enter the vehicle\'s gross weight.' };
        }

        const factor = i.factor > 0 ? i.factor : 1.5;
        const rating = i.weight * factor;

        return {
            value: f(Math.ceil(rating / LB / 500) * 500),
            unit: 'lb winch',
            label: 'Minimum winch rating',
            sub: `${f(i.weight / LB)} lb × ${f(factor)} = ${f(rating / LB)} lb, rounded up to the next 500 lb`,
            rows: { kg: `${f(rating / 1000)} kg`, block: `A snatch block nearly doubles the pull of a smaller winch: ${f(rating / LB / 2)} lb with one block`, note: 'Mud, slopes and the first wrap of rope all need more pull' },
        };
    },

    windsock: (i, c, f) => {
        if (!(i.segments >= 0) || i.segments > 5) {
            return { empty: 'Enter how many of the 5 segments are filled (0–5).' };
        }

        const knots = i.segments * 3;

        return {
            value: i.segments >= 5 ? '15 or more' : f(knots),
            unit: 'knots',
            label: 'Wind speed',
            sub: `${f(i.segments)} of 5 segments filled; each is about 3 knots`,
            rows: { mph: `${i.segments >= 5 ? '17+' : f(knots * 1.150779)} mph`, kmh: `${i.segments >= 5 ? '28+' : f(knots * 1.852)} km/h`, note: 'FAA windsocks fully extend at 15 knots (AC 150/5345-27); the sock points downwind' },
        };
    },
};

export default defineTools(handlers);
