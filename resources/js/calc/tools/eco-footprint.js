import { GAL, KM, MILE, THERM, KWH, fuelPerLiter, greatCircle, gridKg, gridLabel, litersPerMeter } from '../ecology/common.js';
import { defineTools, missing } from '../engines/formula.js';

/**
 * Eco footprint calculators. Masses arrive in grams, volumes in liters, lengths in meters, energy in joules.
 */
const kgText = (kg, f) => (Math.abs(kg) >= 1000 ? `${f(kg / 1000)} t CO₂e` : `${f(kg)} kg CO₂e`);
const EU_SHORT_HAUL = new Set(['DZ', 'EG', 'LY', 'MA', 'TN', 'TR', 'GL', 'GI', 'JE', 'GG', 'IM']);
let airportIndex = null;

/**
 * Looks an airport up by IATA code, or by the "XXX — name" text the airport list fills in.
 */
export function findAirport(text, airports) {
    const query = String(text ?? '').trim();

    if (!query || !airports) {
        return null;
    }

    const code = query.slice(0, 3).toUpperCase();
    const exact = airports.find((a) => a[0] === code && (query.length === 3 || /^[A-Za-z]{3}\b/.test(query)));

    if (exact) {
        return exact;
    }

    const lower = query.toLowerCase();

    return airports.find((a) => a[2].toLowerCase() === lower) ?? airports.find((a) => a[1].toLowerCase().includes(lower)) ?? null;
}

/**
 * DESNZ category for a flight: UK domestic; UK to Europe or North Africa short-haul; other UK flights long-haul;
 * flights not touching the UK use the international average.
 */
export function flightCategory(from, to) {
    const uk = (a) => a[3] === 'GB';

    if (uk(from) && uk(to)) {
        return 'domestic';
    }

    if (uk(from) || uk(to)) {
        const other = uk(from) ? to : from;
        const europe = other[6] === 'EU' && !['MD', 'UA'].includes(other[3]);

        return europe || EU_SHORT_HAUL.has(other[3]) ? 'short' : 'long';
    }

    return 'international';
}

export const handlers = {
    ai_water: (i, c, f) => {
        if (missing(i, 'prompts', 'wh', 'ml') || !(i.prompts >= 0) || !(i.wh >= 0) || !(i.ml >= 0)) {
            return { empty: 'Enter prompts per day and the energy and water per prompt.' };
        }

        const perYear = i.prompts * 365;
        const offsite = i.lkwh > 0 ? (i.wh / 1000) * i.lkwh * 1000 : 0; // mL per prompt
        const perPrompt = i.ml + offsite;
        const liters = (perPrompt * perYear) / 1000;
        const kwh = (i.wh * perYear) / 1000;
        const grid = gridKg(i, c);

        return {
            value: f(liters),
            unit: 'L per year',
            label: 'Water for your AI prompts',
            sub: `${f(perPrompt)} mL per prompt × ${f(perYear)} prompts${offsite ? ' (including water to make the electricity)' : ' (data-center water only)'}`,
            rows: {
                day: `${f((perPrompt * i.prompts))} mL per day`,
                energy: `${f(kwh)} kWh per year (${f(i.wh)} Wh per prompt)`,
                co2: grid === null ? 'Choose a grid' : `${f(kwh * grid * 1000)} g CO₂e per year (${gridLabel(i, c)})`,
                basis: `Google measured a median Gemini text prompt at ${c.data.dated.ai_prompt_wh} Wh and ${c.data.dated.ai_prompt_ml} mL (${c.data.dated.ai_date}); other models differ`,
            },
        };
    },

    bag: (i, c, f) => {
        const bag = c.data.bags[i.bag];

        if (!bag || !(i.uses >= 1)) {
            return { empty: 'Choose a bag and how many times you use it.' };
        }

        const scenario = Number(i.scenario) || 0;
        const needed = bag.uses[scenario];
        const perMonth = bag.gwp / i.uses;
        const hdpe = c.data.bags.hdpe.gwp;
        const material = ((bag.bags / i.uses) * bag.grams * 12) / 1000;

        return {
            value: f(needed),
            unit: needed === 1 ? 'use' : 'uses',
            label: 'Uses to beat a plastic carrier bag',
            sub: i.uses >= needed ? `Used ${f(i.uses)} times, it has a lower carbon footprint than single-use plastic bags` : `Used ${f(i.uses)} times it is still worse; reuse it at least ${f(needed)} times`,
            rows: {
                month: `${f(perMonth)} kg CO₂e for a month of shopping (plastic bags: ${f(hdpe)} kg)`,
                bags: `${f(bag.bags / i.uses)} bags per month (${f(bag.grams)} g each)`,
                material: `${f(material)} kg of bag material per year`,
                table: `Paper ${c.data.bags.paper.uses[scenario]}, LDPE ${c.data.bags.ldpe.uses[scenario]}, PP ${c.data.bags.pp.uses[scenario]}, cotton ${c.data.bags.cotton.uses[scenario]} uses`,
            },
        };
    },

    christmas_tree: (i, c, f) => {
        const t = c.data.trees;
        const real = t[i.disposal] ?? t.chipped;
        const artificialPerYear = i.years > 0 ? t.artificial / i.years : null;

        if (i.tree === 'artificial' && !artificialPerYear) {
            return { empty: 'Enter how many years you will keep the artificial tree.' };
        }

        const perYear = i.tree === 'artificial' ? artificialPerYear : real;

        return {
            value: f(perYear),
            unit: 'kg CO₂e a year',
            label: i.tree === 'artificial' ? 'Artificial tree' : 'Real tree',
            sub: i.tree === 'artificial' ? `${t.artificial} kg over ${f(i.years)} years` : `A 2 m tree, ${i.disposal === 'landfill' ? 'sent to landfill' : i.disposal === 'burned' ? 'burned' : 'chipped or replanted'}`,
            rows: {
                real: `${f(real)} kg CO₂e a year for a real tree (${i.disposal === 'landfill' ? 'landfill' : 'chipped or burned'})`,
                artificial: artificialPerYear ? `${f(artificialPerYear)} kg CO₂e a year over ${f(i.years)} years` : `${t.artificial} kg in total`,
                break_even: `${f(t.artificial / real)} years before an artificial tree beats this real tree`,
                landfill: `Landfilling a real tree: ${t.landfill} kg instead of ${t.chipped} kg`,
            },
        };
    },

    covid_waste: (i, c, f) => {
        if (missing(i, 'people', 'days') || !(i.people > 0) || !(i.days > 0)) {
            return { empty: 'Enter the people and the number of days.' };
        }

        const items = [['Masks', i.masks, i.mask_g], ['Gloves', i.gloves, i.glove_g], ['Wipes', i.wipes, i.wipe_g]].map(([name, perDay, grams]) => {
            const count = (perDay > 0 ? perDay : 0) * i.people * i.days;

            return { name, count, kg: (count * (grams > 0 ? grams : 0)) / 1000 };
        });
        const kg = items.reduce((s, x) => s + x.kg, 0);
        const count = items.reduce((s, x) => s + x.count, 0);

        return {
            value: f(kg),
            unit: 'kg',
            label: 'Waste thrown away',
            sub: `${f(count)} items from ${f(i.people)} people over ${f(i.days)} days`,
            rows: { items: `${f(count)} items`, per_person: `${f((kg * 1000) / i.people)} g per person`, per_day: `${f(kg / i.days)} kg per day` },
            lists: { items: items.map((x) => ({ label: `${x.name}: ${f(x.count)}`, value: `${f(x.kg)} kg` })) },
        };
    },

    /**
     * Bitcoin: network power = hashrate × miner efficiency (a lower bound if every miner were that model).
     */
    crypto: (i, c, f) => {
        const jth = i.miner === 'custom' ? i.jth : c.data.dated.miners[i.miner]?.jth;

        if (missing(i, 'hashrate', 'tx') || !(i.hashrate > 0) || !(jth > 0) || !(i.tx > 0)) {
            return { empty: 'Enter the hashrate, miner efficiency and transactions per day.' };
        }

        const watts = i.hashrate * 1e18 * (jth / 1e12) * (1 + (i.overhead > 0 ? i.overhead / 100 : 0));
        const kwhYear = (watts * 8760) / 1000;
        const perTx = kwhYear / (i.tx * 365);
        const grid = gridKg(i, c);
        const yours = i.yours > 0 ? i.yours * perTx : null;

        return {
            value: f(perTx),
            unit: 'kWh per transaction',
            label: 'Energy per Bitcoin transaction (allocated)',
            sub: `Network ${f(watts / 1e9)} GW, ${f(kwhYear / 1e9)} TWh a year, shared over ${f(i.tx)} transactions a day`,
            rows: {
                network: `${f(kwhYear / 1e9)} TWh a year (${f(watts / 1e9)} GW)`,
                co2: grid === null ? 'Choose a grid' : `${f(perTx * grid)} kg CO₂e per transaction (${gridLabel(i, c)})`,
                yours: yours === null ? 'Enter your transactions a year' : `${f(yours)} kWh${grid === null ? '' : `, ${kgText(yours * grid, f)}`} for your ${f(i.yours)} transactions`,
                note: 'Mining energy does not grow with transactions; this shares it out per transaction',
            },
        };
    },

    flight: (i, c, f) => {
        let distance;
        let category;
        let route = '';

        if (i.mode === 'distance') {
            if (!(i.distance > 0)) {
                return { empty: 'Enter the flight distance.' };
            }

            distance = i.distance;
            category = i.category;
        } else {
            airportIndex = c.airports ?? airportIndex;

            if (!airportIndex) {
                return { empty: 'Loading the airport list…' };
            }

            const from = findAirport(i.from, airportIndex);
            const to = findAirport(i.to, airportIndex);

            if (!from || !to) {
                return { error: `Airport not found: ${!from ? i.from : i.to}. Type an IATA code such as LHR or JFK.` };
            }

            if (from === to) {
                return { error: 'Choose two different airports.' };
            }

            distance = greatCircle(from[4], from[5], to[4], to[5]);
            category = flightCategory(from, to);
            route = `${from[0]} ${from[2]} → ${to[0]} ${to[2]}`;
        }

        const classes = c.data.flights[category];
        const cabin = classes[i.cabin] ? i.cabin : i.cabin === 'first' && classes.business ? 'business' : i.cabin === 'premium_economy' && classes.economy ? 'economy' : 'average_passenger';
        const factor = classes[cabin];
        const legs = (i.trip === 'return' ? 2 : 1) * (i.passengers > 0 ? i.passengers : 1);
        const km = distance / KM;
        const withRf = km * factor.with_rf * legs;
        const without = km * factor.without_rf * legs;
        const shown = i.rf === 'no' ? without : withRf;
        const names = { domestic: 'UK domestic', short: 'Short-haul to/from the UK', long: 'Long-haul to/from the UK', international: 'International (not via the UK)' };

        return {
            value: f(shown),
            unit: 'kg CO₂e',
            label: i.rf === 'no' ? 'Flight emissions (CO₂, CH₄, N₂O)' : 'Flight emissions including non-CO₂ effects',
            sub: `${route ? `${route}: ` : ''}${f(km)} km each way, ${names[category]}, ${cabin.replace('_', ' ')}`,
            rows: {
                distance: `${f(km)} km (${f(distance / MILE)} mi) great-circle`,
                with_rf: `${f(withRf)} kg CO₂e with radiative forcing`,
                without_rf: `${f(without)} kg CO₂e without`,
                factor: `${factor.with_rf} / ${factor.without_rf} kg per passenger-km (DESNZ 2025, ${names[category]})`,
                cabin: cabin === i.cabin ? `${i.trip === 'return' ? 'Return' : 'One way'}, ${f(legs / (i.trip === 'return' ? 2 : 1))} passenger(s)` : `No ${i.cabin.replace('_', ' ')} factor for this route; ${cabin.replace('_', ' ')} used`,
            },
        };
    },

    hand_drying: (i, c, f) => {
        const grid = gridKg(i, c);

        if (grid === null) {
            return { empty: 'Choose the grid.' };
        }

        const paperFactor = c.data.materials.paper / 1000; // kg CO2e per tonne of paper = g CO2e per g
        const methods = {
            hot_air: i.hot_w > 0 && i.hot_s > 0 ? ((i.hot_w * i.hot_s) / 3.6e6) * grid * 1000 : null,
            jet: i.jet_w > 0 && i.jet_s > 0 ? ((i.jet_w * i.jet_s) / 3.6e6) * grid * 1000 : null,
            paper: i.towels > 0 && i.towel_g > 0 ? (i.towels * i.towel_g) * paperFactor : null,
        };
        const chosen = methods[i.method];

        if (chosen === null || chosen === undefined) {
            return { empty: 'Enter the dryer power and time, or the towels and their weight.' };
        }

        const perYear = i.dries > 0 ? (chosen * i.dries * 365) / 1000 : null;
        const names = { hot_air: 'Hot-air dryer', jet: 'Jet dryer', paper: 'Paper towels' };

        return {
            value: f(chosen),
            unit: 'g CO₂e per dry',
            label: names[i.method],
            sub: i.method === 'paper' ? `${f(i.towels)} towels × ${f(i.towel_g)} g × ${f(c.data.materials.paper)} kg CO₂e per tonne of paper (DESNZ, making the paper)` : `Energy × ${gridLabel(i, c)}`,
            rows: { year: perYear === null ? 'Enter dries per day' : `${f(perYear)} kg CO₂e a year`, ...Object.fromEntries(Object.entries(methods).map(([k, v]) => [k, v === null ? 'Not entered' : `${f(v)} g CO₂e per dry`])) },
        };
    },

    /**
     * Kaya identity: CO2 = P × (GDP/P) × (E/GDP) × (CO2/E); log-mean decomposition of a change.
     */
    kaya: (i, c, f) => {
        if (missing(i, 'population', 'gdp', 'energy', 'carbon') || ![i.population, i.gdp, i.energy, i.carbon].every((v) => v > 0)) {
            return { empty: 'Enter all four factors.' };
        }

        const co2 = i.population * i.gdp * i.energy * i.carbon; // kg
        const changes = [['Population', i.d_population], ['GDP per person', i.d_gdp], ['Energy per GDP', i.d_energy], ['CO₂ per energy', i.d_carbon]].map(([n, d]) => [n, d > -100 ? d : 0]);
        const ratio = changes.reduce((p, [, d]) => p * (1 + (d || 0) / 100), 1);
        const logs = changes.map(([n, d]) => [n, Math.log(1 + (d || 0) / 100)]);
        const total = logs.reduce((s, [, l]) => s + l, 0);

        return {
            value: f(co2 / 1e9),
            unit: 'Mt CO₂',
            label: 'Emissions from the Kaya identity',
            sub: `${f(i.population)} people × $${f(i.gdp)} × ${f(i.energy)} kWh/$ × ${f(i.carbon)} kg CO₂/kWh`,
            rows: {
                per_person: `${f(co2 / i.population / 1000)} t CO₂ per person`,
                energy: `${f((i.population * i.gdp * i.energy) / 1e9)} TWh of energy`,
                change: ratio === 1 ? 'Enter % changes to see a new total' : `${f(co2 * ratio / 1e9)} Mt CO₂ (${f((ratio - 1) * 100)}%)`,
            },
            lists: { factors: logs.map(([n, l], k) => ({ label: `${n} ${changes[k][1] ? `${changes[k][1] > 0 ? '+' : ''}${f(changes[k][1])}%` : 'unchanged'}`, value: total !== 0 ? `${f((l / total) * 100)}% of the change` : '—' })).map((r) => (r.value === '—' ? { ...r, value: 'No change entered' } : r)) },
        };
    },

    meat: (i, c, f) => {
        const foods = ['beef_beef_herd', 'beef_dairy_herd', 'lamb_mutton', 'pig_meat', 'poultry_meat', 'fish_farmed', 'prawns_farmed', 'cheese', 'eggs', 'milk'];
        let ghg = 0;
        let land = 0;
        let water = 0;
        const list = [];

        foods.forEach((key) => {
            const kg = i[key] > 0 ? (i[key] / 1000) * 52.1775 : 0; // grams per week → kg per year

            if (kg > 0) {
                const food = c.data.food[key];
                ghg += kg * food.ghg;
                land += kg * food.land;
                water += kg * food.water;
                list.push({ label: `${food.name}: ${f(kg)} kg a year`, value: `${f(kg * food.ghg)} kg CO₂e` });
            }
        });

        if (!list.length) {
            return { empty: 'Enter how much of each food you eat per week.' };
        }

        return {
            value: f(ghg),
            unit: 'kg CO₂e a year',
            label: 'Footprint of these foods',
            sub: 'Global median footprints per kg (Poore & Nemecek 2018)',
            rows: { land: `${f(land)} m² of land`, water: `${f(water / 1000)} m³ of fresh water withdrawn`, per_week: `${f(ghg / 52.1775)} kg CO₂e a week` },
            lists: { foods: list },
        };
    },

    plastic: (i, c, f) => {
        const items = [['Drink bottles', i.bottles, i.bottle_g], ['Carrier bags', i.bags, i.bag_g], ['Takeaway cups', i.cups, i.cup_g], ['Food containers and trays', i.trays, i.tray_g], ['Straws and cutlery', i.straws, i.straw_g]];
        let grams = 0;
        const list = items.map(([name, count, g]) => {
            const yearly = (count > 0 ? count : 0) * 52.1775 * (g > 0 ? g : 0);
            grams += yearly;

            return { label: `${name}: ${f((count > 0 ? count : 0) * 52.1775)} a year`, value: `${f(yearly / 1000)} kg` };
        });
        grams += (i.other > 0 ? i.other : 0) * 52.1775;

        if (!(grams > 0)) {
            return { empty: 'Enter the items you use each week.' };
        }

        const region = c.data.plastic_per_person[i.region];
        const kg = grams / 1000;

        return {
            value: f(kg),
            unit: 'kg a year',
            label: 'Your plastic',
            sub: `${f((kg / region.kg) * 100)}% of the ${region.name} average plastic waste (${region.kg} kg per person, OECD)`,
            rows: { week: `${f(grams / 52.1775)} g a week`, co2: `${f(kg * (c.data.materials.plastic_average / 1000))} kg CO₂e to make it (DESNZ average plastics)`, average: `${region.kg} kg per person (${region.name})` },
            lists: { items: [...list, { label: 'Other packaging', value: `${f(((i.other > 0 ? i.other : 0) * 52.1775) / 1000)} kg` }] },
        };
    },

    reduce_plastic: (i, c, f) => {
        const swaps = [['Refillable bottle instead of bottled drinks', i.bottles, i.bottle_g, i.bottle_price], ['Own bag instead of carrier bags', i.bags, i.bag_g, i.bag_price], ['Own cup instead of takeaway cups', i.cups, i.cup_g, i.cup_price], ['Bar soap or refills instead of bottles', i.soap, i.soap_g, i.soap_price]];
        let grams = 0;
        let saved = 0;
        const list = swaps.map(([name, perWeek, g, price]) => {
            const n = (perWeek > 0 ? perWeek : 0) * 52.1775;
            grams += n * (g > 0 ? g : 0);
            saved += n * (price > 0 ? price : 0);

            return { label: `${name}: ${f(n)} items a year`, value: `${f((n * (g > 0 ? g : 0)) / 1000)} kg` };
        });

        if (!(grams > 0)) {
            return { empty: 'Enter how many items each swap replaces per week.' };
        }

        return {
            value: f(grams / 1000),
            unit: 'kg plastic avoided a year',
            label: 'Plastic you would avoid',
            sub: `${f((grams / 1000) * (c.data.materials.plastic_average / 1000))} kg CO₂e of plastic production avoided (DESNZ)`,
            rows: { money: saved > 0 ? `$${f(saved)} a year not spent on the single-use items` : 'Enter prices to see the money saved', items: `${f(swaps.reduce((s, [, n]) => s + (n > 0 ? n : 0), 0) * 52.1775)} items a year`, decade: `${f((grams / 1000) * 10)} kg over 10 years` },
            lists: { swaps: list },
        };
    },

    vegan: (i, c, f) => {
        const from = c.data.diets[i.diet];
        const vegan = c.data.diets.vegan;
        const people = i.people > 0 ? i.people : 1;
        const years = i.years > 0 ? i.years : 1;
        const days = 365.25 * people * years;
        const ghg = (from.ghg - vegan.ghg) * days;

        return {
            value: f(ghg),
            unit: 'kg CO₂e saved',
            label: 'Switching to a vegan diet',
            sub: `${from.name}: ${from.ghg} kg CO₂e a day → vegan ${vegan.ghg} kg (Scarborough et al. 2023)`,
            rows: {
                percent: `${f((1 - vegan.ghg / from.ghg) * 100)}% less greenhouse gas`,
                land: `${f((from.land - vegan.land) * days)} m² of land a ${years > 1 ? 'period' : 'year'} saved`,
                water: `${f(((from.water - vegan.water) * days) / 1000)} m³ of water saved`,
                daily: `${f(from.ghg - vegan.ghg)} kg CO₂e a day per person`,
            },
            lists: { diets: Object.values(c.data.diets).map((d) => ({ label: d.name, value: `${d.ghg} kg CO₂e a day`, highlight: d === from })) },
        };
    },

    home_energy: (i, c, f) => {
        const grid = gridKg(i, c);
        const fuels = c.data.fuels;
        const parts = [];

        if (i.electricity > 0) {
            if (grid === null) {
                return { empty: 'Choose the grid for your electricity.' };
            }

            parts.push(['Electricity', ((i.electricity * 12)) * grid, `${f(i.electricity * 12)} kWh × ${gridLabel(i, c)}`]);
        }

        if (i.gas > 0) {
            const kg = { therm: i.gas * fuels.epa_natural_gas_therm, m3: i.gas * fuels.natural_gas_m3, kwh: i.gas * fuels.natural_gas_kwh, ccf: i.gas * 100 * fuels.epa_natural_gas_scf }[i.gas_unit] * 12;
            parts.push(['Natural gas', kg, `${f(i.gas * 12)} ${i.gas_unit} a year`]);
        }

        if (i.oil > 0) {
            const kg = (i.oil_unit === 'gal' ? i.oil * fuels.epa_heating_oil_gal : i.oil * fuels.heating_oil_l);
            parts.push(['Heating oil', kg, `${f(i.oil)} ${i.oil_unit === 'gal' ? 'US gal' : 'L'} a year`]);
        }

        if (i.propane > 0) {
            const kg = (i.propane_unit === 'gal' ? i.propane * fuels.epa_propane_gal : i.propane * fuels.lpg_l);
            parts.push(['Propane or LPG', kg, `${f(i.propane)} ${i.propane_unit === 'gal' ? 'US gal' : 'L'} a year`]);
        }

        if (!parts.length) {
            return { empty: 'Enter your electricity or fuel use.' };
        }

        const total = parts.reduce((s, [, kg]) => s + kg, 0);
        const people = i.people > 0 ? i.people : 1;

        return {
            value: f(total / 1000),
            unit: 't CO₂e a year',
            label: 'Home energy footprint',
            sub: `${parts.length} energy source${parts.length > 1 ? 's' : ''}; electricity and gas entered per month`,
            rows: { per_person: `${f(total / 1000 / people)} t per person (${f(people)} people)`, month: `${f(total / 12)} kg CO₂e a month`, grid: grid === null ? 'No electricity entered' : gridLabel(i, c) },
            lists: { parts: parts.map(([name, kg, note]) => ({ label: `${name}: ${note}`, value: kgText(kg, f) })) },
        };
    },

    car: (i, c, f) => {
        const fuel = fuelPerLiter(i.fuel, c);
        let liters;

        if (i.mode === 'fuel') {
            liters = i.fuel_amount > 0 ? i.fuel_amount : null;
        } else {
            const lpm = litersPerMeter(i.economy, i.economy_unit);
            liters = lpm && i.distance > 0 ? lpm * i.distance : null;
        }

        if (!liters || !fuel) {
            return { empty: 'Enter the distance and fuel economy, or the fuel used.' };
        }

        const kg = liters * fuel.kg;
        const distanceM = i.mode === 'fuel' ? null : i.distance;

        return {
            value: f(kg),
            unit: 'kg CO₂e',
            label: 'Driving emissions',
            sub: `${f(liters)} L (${f(liters / GAL)} US gal) × ${f(fuel.kg)} kg per liter, ${fuel.name}`,
            rows: {
                fuel: `${f(liters)} L (${f(liters / GAL)} US gal)`,
                per_km: distanceM ? `${f((kg * 1000) / (distanceM / KM))} g per km (${f((kg * 1000) / (distanceM / MILE))} g per mile)` : 'Enter a distance for per-km figures',
                tonnes: `${f(kg / 1000)} t CO₂e`,
            },
        };
    },
};

const run = defineTools(handlers);

/**
 * The flight page loads the airport list (public/data/airports.json) once, fills the suggestion list and recalculates.
 */
export default function ecoFootprint(ctx, config) {
    run(ctx, config);

    if (config.tool !== 'flight') {
        return;
    }

    fetch(config.airportsUrl ?? '/data/airports.json')
        .then((response) => response.json())
        .then((data) => {
            config.airports = data.airports;
            const list = ctx.root.querySelector('#airport-list');

            if (list) {
                list.replaceChildren(...data.airports.map((a) => Object.assign(document.createElement('option'), { value: `${a[0]} — ${a[2] || a[1]} (${a[3]})` })));
            }

            ctx.update();
        })
        .catch(() => ctx.showError('The airport list could not load. Enter a distance instead.'));
}
