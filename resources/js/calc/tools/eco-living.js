import { GAL, KM, MILE, fuelPerLiter, gridKg, gridLabel, litersPerMeter, money } from '../ecology/common.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Sustainable living: transport choices, books, water, plastics policy and event footprints.
 * Lengths arrive in meters, masses in grams, volumes in liters, temperatures in °C.
 */
const kgText = (kg, f) => (Math.abs(kg) >= 1000 ? `${f(kg / 1000)} t CO₂e` : `${f(kg)} kg CO₂e`);

export const handlers = {
    books: (i, c, f) => {
        const device = i.reader === 'custom' ? i.reader_kg : c.data.ereaders[i.reader]?.kg;

        if (!(device > 0) || !(i.book_g > 0) || !(i.books > 0)) {
            return { empty: 'Enter books per year, book weight and the e-reader footprint.' };
        }

        const perBook = (i.book_g / 1000) * (c.data.materials.paper / 1000);
        const breakEven = device / perBook;
        const years = i.years > 0 ? i.years : 1;

        return {
            value: f(Math.ceil(breakEven)),
            unit: 'books',
            label: 'Books before the e-reader is lower carbon',
            sub: `${f(device)} kg CO₂e for the e-reader ÷ ${f(perBook)} kg of paper per book (DESNZ paper factor, paper making only)`,
            rows: {
                years: `${f(breakEven / i.books)} years at ${f(i.books)} books a year`,
                paper: `${f(perBook * i.books)} kg CO₂e a year of paper books`,
                reader: `${f(device / years)} kg CO₂e a year over ${f(years)} years of e-reader use`,
                scope: 'Printing, shipping and shops add to the paper book; charging adds under 1% to the e-reader',
            },
        };
    },

    car_bike: (i, c, f) => {
        const fuel = fuelPerLiter(i.fuel, c);
        const lpm = litersPerMeter(i.economy, i.economy_unit);

        if (missing(i, 'distance', 'trips') || !(i.distance > 0) || !(i.trips > 0) || !lpm || !fuel) {
            return { empty: 'Enter the trip distance, trips per week and the car\'s fuel economy.' };
        }

        const weeks = i.weeks > 0 ? i.weeks : 52;
        const meters = i.distance * i.trips * weeks;
        const liters = meters * lpm;
        const kg = liters * fuel.kg;
        const met = c.data.cycling[i.pace]?.met;
        const speed = { leisure_lt10: 8, commute: 15, '10_12': 17.7, '12_14': 20.9, '14_16': 24.1, '16_19': 28.2, ebike_high: 20 }[i.pace];
        const hours = meters / KM / speed;
        const kcal = met && i.weight > 0 ? met * (i.weight / 1000) * hours : null;

        return {
            value: f(kg),
            unit: 'kg CO₂e saved a year',
            label: 'Cycling instead of driving',
            sub: `${f(meters / KM)} km (${f(meters / MILE)} mi) a year not driven; ${fuel.name}`,
            rows: {
                fuel: `${f(liters)} L (${f(liters / GAL)} US gal) of fuel saved`,
                money: i.price > 0 ? `${money((i.price_unit === 'gal' ? liters / GAL : liters) * i.price)} of fuel saved` : 'Enter a fuel price',
                calories: kcal === null ? 'Enter your weight' : `${f(kcal)} kcal burned (${f(met)} MET for ${f(hours)} hours)`,
                time: `${f(hours)} hours of riding at about ${f(speed)} km/h`,
            },
        };
    },

    butts: (i, c, f) => {
        const k = c.data.constants;
        const count = i.input === 'area' ? (i.area > 0 && i.density > 0 ? i.area * i.density : NaN) : i.count;

        if (!(count > 0)) {
            return { empty: 'Enter the number of butts collected.' };
        }

        return {
            value: f((count * k.butt_mg) / 1e6),
            unit: 'kg',
            label: 'Weight of the butts collected',
            sub: `${f(count)} butts × ${k.butt_mg} mg each (Slaughter et al. 2011)`,
            rows: {
                water: `${f(count)} L of water each could make lethal to half of test fish (LC50 about 1 butt per liter)`,
                count: `${f(count)} butts`,
                plastic: 'Filters are cellulose acetate, a plastic that breaks into microfibers',
            },
        };
    },

    drip: (i, c, f) => {
        if (missing(i, 'drips') || !(i.drips > 0) || !(i.drip_ml > 0)) {
            return { empty: 'Enter the drips per minute and the drip size.' };
        }

        const litersDay = (i.drips * 1440 * i.drip_ml) / 1000;
        const litersYear = litersDay * 365;

        return {
            value: f(litersYear / GAL),
            unit: 'US gal a year',
            label: 'Water lost',
            sub: `${f(i.drips)} drips a minute × ${f(i.drip_ml)} mL (USGS uses ¼ mL)`,
            rows: {
                liters: `${f(litersYear)} L a year (${f(litersYear / 1000)} m³)`,
                day: `${f(litersDay / GAL)} gal (${f(litersDay)} L) a day`,
                cost: i.price > 0 ? `${money((i.price_unit === 'kgal' ? litersYear / GAL / 1000 : litersYear / 1000) * i.price)} a year` : 'Enter a water price',
                co2: `${f((litersYear / 1000) * (c.data.materials.water_supply + c.data.materials.water_treatment))} kg CO₂e to supply and treat it (DESNZ)`,
            },
        };
    },

    plastic_policy: (i, c, f) => {
        const s = c.data.plastic_policy;
        const chosen = s[i.scenario];
        const base = s.baseline;
        const now = s.y2019;
        const change = (a, b) => `${a >= b ? '+' : ''}${f(((a - b) / b) * 100)}%`;

        return {
            value: f(chosen.leakage),
            unit: 'Mt a year leak into the environment',
            label: chosen.name,
            sub: i.scenario === 'y2019' ? 'Measured base year' : `${change(chosen.leakage, base.leakage)} against the baseline, ${change(chosen.leakage, now.leakage)} against 2019`,
            rows: {
                use: `${f(chosen.use)} Mt of plastic used (${change(chosen.use, now.use)} on 2019)`,
                waste: `${f(chosen.waste)} Mt of plastic waste`,
                mismanaged: `${f(chosen.mismanaged)} Mt mismanaged`,
                recycled: `${f(chosen.recycled_share)}% of plastics made from recycled material`,
            },
            lists: { scenarios: Object.values(s).map((x) => ({ label: x.name, value: `${f(x.leakage)} Mt leaked, ${f(x.waste)} Mt waste`, highlight: x === chosen })) },
        };
    },

    olympics: (i, c, f) => {
        const games = c.data.olympics[i.games];
        let trip = 0;
        const parts = [];

        if (i.flight_km > 0) {
            const cls = c.data.flights.international[i.cabin] ?? c.data.flights.international.average_passenger;
            const kg = (i.flight_km / KM) * cls.with_rf * (i.trip === 'return' ? 2 : 1);
            trip += kg;
            parts.push({ label: `Flights, ${f(i.flight_km / KM)} km ${i.trip === 'return' ? 'each way' : 'one way'}`, value: kgText(kg, f) });
        }

        if (i.nights > 0) {
            const hotel = c.data.hotels[i.hotel];
            const kg = i.nights * (hotel?.kg ?? 0);
            trip += kg;
            parts.push({ label: `${f(i.nights)} hotel nights (${hotel?.name ?? '—'})`, value: kgText(kg, f) });
        }

        return {
            value: f(games.mt),
            unit: 'Mt CO₂e',
            label: `${games.name} footprint`,
            sub: trip > 0 ? `Your trip: ${kgText(trip, f)}, ${f((trip / (games.mt * 1e9)) * 1e6)} millionths of the Games total` : 'Add a trip to compare your share',
            rows: {
                trip: trip > 0 ? kgText(trip, f) : 'Enter a flight or hotel nights',
                versus: `${f(((games.mt - c.data.olympics.paris_2024.mt) / c.data.olympics.paris_2024.mt) * 100)}% compared with Paris 2024`,
                scope: 'Reported by each organising committee; what is included differs between Games',
            },
            lists: { games: [...Object.values(c.data.olympics).map((g) => ({ label: g.name, value: `${f(g.mt)} Mt CO₂e`, highlight: g === games })), ...parts] },
        };
    },

    /**
     * Plug-in hybrid: each driving day uses the battery first (up to its range), then fuel.
     */
    phev: (i, c, f) => {
        const fuel = fuelPerLiter(i.fuel, c);
        const lpm = litersPerMeter(i.economy, i.economy_unit);
        const grid = gridKg(i, c);

        if (missing(i, 'daily', 'range', 'kwh_100') || !(i.daily > 0) || !(i.range >= 0) || !(i.kwh_100 > 0) || !lpm || !fuel || grid === null) {
            return { empty: 'Enter the daily distance, electric range, efficiency and fuel economy.' };
        }

        const days = i.days > 0 ? i.days : 365;
        const electric = Math.min(i.range, i.daily);
        const fuelMeters = i.daily - electric;
        const perMeterKwh = i.kwh_100 / (100 * (i.kwh_unit === 'mi' ? MILE : KM));
        const kwh = electric * perMeterKwh * days;
        const liters = fuelMeters * lpm * days;
        const cost = kwh * (i.power_price || 0) + (i.price_unit === 'gal' ? liters / GAL : liters) * (i.fuel_price || 0);
        const co2 = kwh * grid + liters * fuel.kg;
        const gasOnly = i.daily * days * lpm;
        const gasCost = (i.price_unit === 'gal' ? gasOnly / GAL : gasOnly) * (i.fuel_price || 0);

        return {
            value: f((electric / i.daily) * 100),
            unit: '% electric',
            label: 'Share of miles on electricity',
            sub: `${f(electric / MILE)} of ${f(i.daily / MILE)} miles a day on the battery`,
            rows: {
                cost: i.power_price > 0 || i.fuel_price > 0 ? `${money(cost)} a year (${money(gasCost)} on fuel only)` : 'Enter prices for the running cost',
                co2: `${kgText(co2, f)} a year (${kgText(gasOnly * fuel.kg, f)} on fuel only)`,
                energy: `${f(kwh)} kWh and ${f(liters)} L (${f(liters / GAL)} gal) of fuel a year`,
                grid: gridLabel(i, c),
            },
        };
    },

    tap_water: (i, c, f) => {
        if (missing(i, 'liters', 'bottle_l', 'bottle_price') || !(i.liters > 0) || !(i.bottle_l > 0)) {
            return { empty: 'Enter how much water you drink and the bottle size and price.' };
        }

        const yearly = i.liters * 365 * (i.people > 0 ? i.people : 1);
        const bottles = yearly / i.bottle_l;
        const bottled = bottles * i.bottle_price;
        const tap = (yearly / 1000) * (i.tap_price > 0 ? i.tap_price : 0);
        const plasticKg = (bottles * (i.bottle_g > 0 ? i.bottle_g : 0)) / 1000;

        return {
            value: money(bottled - tap),
            unit: '',
            label: 'Saved a year by drinking tap water',
            sub: `${f(bottles)} bottles (${money(bottled)}) against ${money(tap)} of tap water`,
            rows: {
                bottles: `${f(bottles)} bottles a year`,
                plastic: `${f(plasticKg)} kg of PET; ${f(plasticKg * (c.data.materials.pet / 1000))} kg CO₂e to make it (DESNZ)`,
                tap_co2: `${f((yearly / 1000) * c.data.materials.water_supply * 1000)} g CO₂e for the tap water supply (DESNZ)`,
                volume: `${f(yearly)} L a year`,
            },
        };
    },

    water_demand: (i, c, f) => {
        if (missing(i, 'population', 'per_person') || !(i.population > 0) || !(i.per_person > 0)) {
            return { empty: 'Enter the population and the use per person.' };
        }

        const perPersonL = i.per_unit === 'gal' ? i.per_person * GAL : i.per_person;
        const average = i.population * perPersonL;
        const maxDay = average * (i.max_day > 0 ? i.max_day : 1);
        const peakHour = (average / 24) * (i.peak_hour > 0 ? i.peak_hour : 1);

        return {
            value: f(average / GAL / 1e6),
            unit: 'million US gal a day',
            label: 'Average day demand',
            sub: `${f(i.population)} people × ${f(perPersonL / GAL)} gal (${f(perPersonL)} L) a day`,
            rows: {
                metric: `${f(average / 1000)} m³ a day (${f(average / 1000 / 86.4)} L/s)`,
                max_day: `${f(maxDay / GAL / 1e6)} MGD maximum day (× ${f(i.max_day || 1)})`,
                peak_hour: `${f((peakHour / GAL) / 60)} gal/min peak hour (× ${f(i.peak_hour || 1)})`,
                year: `${f((average * 365) / 1e6)} million liters a year`,
            },
        };
    },

    shower: (i, c, f) => {
        if (missing(i, 'minutes', 'flow', 'cold', 'hot', 'efficiency') || !(i.minutes > 0) || !(i.flow > 0) || !(i.hot > i.cold) || !(i.efficiency > 0)) {
            return { empty: 'Enter minutes, flow, temperatures and heater efficiency.' };
        }

        const flowLmin = i.flow_unit === 'gpm' ? i.flow * GAL : i.flow;
        const liters = flowLmin * i.minutes;
        const kwh = (liters * 0.998 * 4.186 * (i.hot - i.cold)) / 3600 / (i.efficiency / 100);
        const perYear = (i.per_week > 0 ? i.per_week : 7) * 52.1775 * (i.people > 0 ? i.people : 1);
        const grid = gridKg(i, c);
        const co2 = i.heater === 'gas' ? kwh * c.data.fuels.natural_gas_kwh : grid === null ? null : kwh * grid;
        const cost = i.energy_price > 0 ? kwh * i.energy_price + (i.water_price > 0 ? (liters / 1000) * i.water_price : 0) : null;
        const lowFlow = i.flow_unit === 'gpm' ? Math.min(i.flow, 2) * GAL : Math.min(i.flow, 7.6);

        return {
            value: f(liters),
            unit: 'L per shower',
            label: 'Water per shower',
            sub: `${f(liters / GAL)} US gal; ${f(kwh)} kWh to heat it`,
            rows: {
                energy: `${f(kwh)} kWh per shower, ${f(kwh * perYear)} kWh a year`,
                co2: co2 === null ? 'Choose a grid' : `${f(co2 * 1000)} g CO₂e per shower, ${kgText(co2 * perYear, f)} a year`,
                cost: cost === null ? 'Enter energy and water prices' : `${money(cost)} per shower, ${money(cost * perYear)} a year`,
                low_flow: lowFlow < flowLmin ? `A 2.0 gpm (7.6 L/min) head would save ${f((flowLmin - lowFlow) * i.minutes * perYear)} L a year` : 'Already at or below 2.0 gpm (WaterSense)',
            },
        };
    },

    ev_gas: (i, c, f) => {
        const fuel = fuelPerLiter(i.fuel, c);
        const lpm = litersPerMeter(i.economy, i.economy_unit);
        const grid = gridKg(i, c);

        if (missing(i, 'distance', 'kwh_100') || !(i.distance > 0) || !(i.kwh_100 > 0) || !lpm || !fuel || grid === null) {
            return { empty: 'Enter the yearly distance, the EV\'s efficiency and the gas car\'s fuel economy.' };
        }

        const kwh = i.distance * (i.kwh_100 / (100 * (i.kwh_unit === 'mi' ? MILE : KM)));
        const liters = i.distance * lpm;
        const evCo2 = kwh * grid;
        const gasCo2 = liters * fuel.kg;
        const evCost = kwh * (i.power_price || 0);
        const gasCost = (i.price_unit === 'gal' ? liters / GAL : liters) * (i.fuel_price || 0);

        return {
            value: f(gasCo2 - evCo2),
            unit: 'kg CO₂e saved a year',
            label: 'Driving electric instead of gas',
            sub: `EV ${kgText(evCo2, f)} on ${gridLabel(i, c)}; gas ${kgText(gasCo2, f)}`,
            rows: {
                ev: `${f(kwh)} kWh, ${kgText(evCo2, f)}, ${money(evCost)}`,
                gas: `${f(liters)} L (${f(liters / GAL)} gal), ${kgText(gasCo2, f)}, ${money(gasCost)}`,
                cost: i.power_price > 0 || i.fuel_price > 0 ? `${money(gasCost - evCost)} a year saved` : 'Enter prices for the running cost',
                per_mile: `${f((evCo2 * 1000) / (i.distance / MILE))} vs ${f((gasCo2 * 1000) / (i.distance / MILE))} g CO₂e per mile`,
                scope: 'Driving only; making the battery and car is not included',
            },
        };
    },
};

export default defineTools(handlers);
