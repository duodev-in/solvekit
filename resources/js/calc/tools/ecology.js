import { defineTools, missing } from '../engines/formula.js';
import { physicsPractice } from '../physics/practice.js';

/**
 * Ecology calculators: diversity indexes, population growth and mark–recapture.
 */
export function counts(text) {
    return String(text ?? '').split(/[\s,;]+/).filter(Boolean).map(Number);
}

export function shannon(values) {
    const total = values.reduce((sum, value) => sum + value, 0);

    return -values.filter((value) => value > 0).reduce((sum, value) => sum + (value / total) * Math.log(value / total), 0);
}

export function simpson(values) {
    const total = values.reduce((sum, value) => sum + value, 0);

    return values.reduce((sum, value) => sum + value * (value - 1), 0) / (total * (total - 1));
}

export function logistic(start, rate, capacity, time) {
    return capacity / (1 + ((capacity - start) / start) * Math.exp(-rate * time));
}

function readCounts(text) {
    const values = counts(text);

    if (!values.length) {
        return { empty: 'Enter the number of individuals of each species.' };
    }

    if (values.some((value) => Number.isNaN(value) || value < 0 || !Number.isInteger(value))) {
        return { error: 'Use whole numbers of 0 or more, separated by commas or spaces.' };
    }

    if (values.filter((value) => value > 0).length < 1) {
        return { error: 'At least one species must have individuals.' };
    }

    return { values: values.filter((value) => value > 0) };
}

export const handlers = {
    shannon: (i, c, f) => {
        const read = readCounts(i.counts);

        if (!read.values) {
            return read;
        }

        const h = shannon(read.values);
        const richness = read.values.length;
        const total = read.values.reduce((sum, value) => sum + value, 0);

        return {
            value: f(h),
            unit: 'H′',
            label: 'Shannon diversity index',
            sub: `${richness} species, ${f(total)} individuals`,
            rows: { evenness: richness > 1 ? f(h / Math.log(richness)) : '—', richness: String(richness), effective: f(Math.exp(h)), total: f(total) },
        };
    },

    simpson: (i, c, f) => {
        if (c.practice && i.mode === 'practice') {
            return physicsPractice(c.practice, i);
        }

        const read = readCounts(i.counts);

        if (!read.values) {
            return read;
        }

        const total = read.values.reduce((sum, value) => sum + value, 0);

        if (total < 2) {
            return { error: 'Enter at least two individuals in total.' };
        }

        const d = simpson(read.values);

        return {
            value: f(1 - d),
            unit: '1 − D',
            label: 'Simpson\'s diversity index',
            sub: 'Chance that two individuals picked at random are different species',
            rows: { d: f(d), reciprocal: d > 0 ? f(1 / d) : '∞', richness: String(read.values.length), total: f(total) },
        };
    },

    population_growth: (i, c, f) => {
        if (missing(i, 'start', 'rate', 'time')) {
            return { empty: 'Enter the starting population, growth rate and time.' };
        }

        if (i.start <= 0 || i.time < 0) {
            return { error: 'Starting population must be greater than 0 and time not negative.' };
        }

        const isLogistic = i.model === 'logistic';

        if (isLogistic && !(i.capacity > 0)) {
            return { empty: 'Enter the carrying capacity K.' };
        }

        const at = (t) => (isLogistic ? logistic(i.start, i.rate, i.capacity, t) : i.start * Math.exp(i.rate * t));
        const steps = [0, 0.25, 0.5, 0.75, 1].map((share) => share * i.time);

        return {
            value: f(at(i.time)),
            unit: 'individuals',
            label: `Population after ${f(i.time)} time units`,
            sub: isLogistic ? `Logistic growth towards K = ${f(i.capacity)}` : 'Exponential growth N = N₀eʳᵗ',
            rows: { doubling: i.rate > 0 ? f(Math.LN2 / i.rate) : '—', change: `${f(at(i.time) - i.start)}` },
            lists: { 'quick-ref': steps.map((t) => ({ label: `t = ${f(t)}`, value: f(at(t)) })) },
        };
    },

    mark_recapture: (i, c, f) => {
        if (missing(i, 'marked', 'caught', 'recaptured')) {
            return { empty: 'Enter marked, caught and recaptured counts.' };
        }

        if (i.marked <= 0 || i.caught <= 0 || i.recaptured < 0 || i.recaptured > Math.min(i.marked, i.caught)) {
            return { error: 'Recaptured cannot exceed the marked or caught numbers.' };
        }

        const chapman = ((i.marked + 1) * (i.caught + 1)) / (i.recaptured + 1) - 1;
        const variance = ((i.marked + 1) * (i.caught + 1) * (i.marked - i.recaptured) * (i.caught - i.recaptured)) / ((i.recaptured + 1) ** 2 * (i.recaptured + 2));
        const margin = 1.96 * Math.sqrt(variance);

        return {
            value: f(Math.round(chapman)),
            unit: 'individuals',
            label: 'Population estimate (Chapman)',
            sub: i.recaptured < 7 ? 'Fewer than 7 recaptures: the estimate is uncertain' : `95% interval about ${f(Math.round(Math.max(chapman - margin, i.marked + i.caught - i.recaptured)))} to ${f(Math.round(chapman + margin))}`,
            rows: { lincoln: i.recaptured > 0 ? f(Math.round((i.marked * i.caught) / i.recaptured)) : 'Needs at least one recapture', interval: `± ${f(Math.round(margin))}` },
        };
    },
};

export default defineTools(handlers);
