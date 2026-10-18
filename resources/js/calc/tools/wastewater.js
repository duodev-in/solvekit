import { defineTools, missing } from '../engines/formula.js';

/**
 * Activated-sludge operator calculations in US units (mg/L, million gallons, MGD), the "pounds
 * formula" convention: lb = mg/L × MG × 8.34.
 */
export const POUNDS_FACTOR = 8.34;

export function pounds(mgPerLiter, millionGallons) {
    return mgPerLiter * millionGallons * POUNDS_FACTOR;
}

const MG_M3 = 3785.411784;

export const handlers = {
    mlvss: (i, c, f) => {
        if (missing(i, 'mlss', 'volatile')) {
            return { empty: 'Enter the MLSS and the volatile fraction.' };
        }

        if (i.mlss < 0 || i.volatile <= 0 || i.volatile > 100) {
            return { error: 'MLSS cannot be negative and the volatile fraction must be 1 to 100%.' };
        }

        const mlvss = i.mlss * (i.volatile / 100);

        return {
            value: f(mlvss),
            unit: 'mg/L',
            label: 'MLVSS',
            sub: `${f(i.mlss)} mg/L MLSS × ${f(i.volatile)}% volatile`,
            rows: {
                lb: i.volume > 0 ? `${f(pounds(mlvss, i.volume))} lb under aeration` : 'Enter the aeration volume',
                kg: i.volume > 0 ? `${f((mlvss * i.volume * MG_M3) / 1000)} kg` : '—',
                mlss_lb: i.volume > 0 ? `${f(pounds(i.mlss, i.volume))} lb MLSS` : '—',
            },
        };
    },

    wastewater: (i, c, f) => {
        switch (i.mode) {
            case 'fm': {
                if (missing(i, 'bod', 'flow', 'mlvss', 'volume')) {
                    return { empty: 'Enter influent BOD, flow, MLVSS and aeration volume.' };
                }

                const food = pounds(i.bod, i.flow);
                const micro = pounds(i.mlvss, i.volume);

                if (micro <= 0) {
                    return { error: 'MLVSS and volume must be greater than 0.' };
                }

                return { value: f(food / micro), unit: '', label: 'F/M ratio', sub: 'Typical conventional activated sludge: 0.2 to 0.5', rows: { food: `${f(food)} lb BOD/day`, micro: `${f(micro)} lb MLVSS` } };
            }

            case 'srt': {
                if (missing(i, 'mlss', 'volume', 'was', 'was_flow', 'effluent', 'flow')) {
                    return { empty: 'Enter MLSS, volume, waste sludge and effluent values.' };
                }

                const inSystem = pounds(i.mlss, i.volume);
                const leaving = pounds(i.was, i.was_flow) + pounds(i.effluent, i.flow);

                if (leaving <= 0) {
                    return { error: 'Solids leaving the system must be greater than 0.' };
                }

                return { value: f(inSystem / leaving), unit: 'days', label: 'Sludge age (SRT)', sub: 'Solids in the system ÷ solids leaving per day', rows: { food: `${f(inSystem)} lb in system`, micro: `${f(leaving)} lb/day leaving` } };
            }

            case 'svi': {
                if (missing(i, 'settled', 'mlss')) {
                    return { empty: 'Enter the 30-minute settled volume and MLSS.' };
                }

                if (i.mlss <= 0) {
                    return { error: 'MLSS must be greater than 0.' };
                }

                const svi = (i.settled * 1000) / i.mlss;

                return { value: f(svi), unit: 'mL/g', label: 'Sludge volume index', sub: svi < 80 ? 'Below 80: dense, fast-settling sludge' : svi <= 150 ? '80 to 150: good settling' : 'Above 150: bulking sludge', rows: { food: `${f(i.settled)} mL/L settled in 30 min`, micro: `${f(i.mlss)} mg/L MLSS (${f(i.mlss / 1000)} g/L)` } };
            }

            case 'detention': {
                if (missing(i, 'volume', 'flow')) {
                    return { empty: 'Enter the tank volume and the flow.' };
                }

                if (i.flow <= 0) {
                    return { error: 'Flow must be greater than 0.' };
                }

                return { value: f((i.volume / i.flow) * 24), unit: 'hours', label: 'Detention time', sub: 'volume (MG) ÷ flow (MGD) × 24', rows: {} };
            }

            default: {
                if (missing(i, 'bod', 'flow')) {
                    return { empty: 'Enter BOD and flow.' };
                }

                return { value: f(pounds(i.bod, i.flow)), unit: 'lb/day', label: 'BOD loading', sub: 'mg/L × MGD × 8.34', rows: { food: `${f((i.bod * i.flow * MG_M3) / 1000)} kg/day`, micro: 'Not used for BOD loading' } };
            }
        }
    },
};

export default defineTools(handlers);
