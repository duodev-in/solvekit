/**
 * Exact aqueous acid–base equilibrium.
 *
 * The pH is found from the full charge balance, including water's autoionization and every
 * dissociation step of polyprotic acids, by bisection on log[H⁺]. The balance increases
 * monotonically with [H⁺], so bisection always converges; 200 halvings reach machine precision.
 *
 * Components:
 *   { type: 'acid', concentration, pKa: [..], strongSteps }   HnA; strongSteps complete dissociations
 *   { type: 'base', concentration, pKaConjugate }              weak base B ⇌ BH⁺ (pKa of BH⁺)
 *   { type: 'cation', concentration, charge }                  spectator cations (Na⁺ from NaOH…)
 *   { type: 'anion', concentration, charge }                   spectator anions (Cl⁻…)
 */

/**
 * Fractions of an acid in each protonation state, from fully protonated (index 0) down.
 * Computed relative to the largest term to avoid overflow for very strong or very weak steps.
 */
export function fractions(h, pKas) {
    const logTerms = [0];
    let running = 0;

    for (let j = 0; j < pKas.length; j += 1) {
        running += -pKas[j] - Math.log10(h);
        logTerms.push(running);
    }

    const max = Math.max(...logTerms);
    const terms = logTerms.map((value) => 10 ** (value - max));
    const sum = terms.reduce((total, value) => total + value, 0);

    return terms.map((value) => value / sum);
}

function netCharge(h, components, pKw) {
    let charge = h - 10 ** -pKw / h;

    for (const item of components) {
        if (item.type === 'acid') {
            const alpha = fractions(h, item.pKa);
            const weakNegative = alpha.reduce((sum, fraction, j) => sum + j * fraction, 0);
            charge -= item.concentration * ((item.strongSteps ?? 0) + weakNegative);
        } else if (item.type === 'base') {
            const protonated = fractions(h, [item.pKaConjugate])[0];
            charge += item.concentration * protonated;
        } else if (item.type === 'cation') {
            charge += item.concentration * item.charge;
        } else if (item.type === 'anion') {
            charge -= item.concentration * item.charge;
        }
    }

    return charge;
}

/**
 * pH of a mixture of components at a given pKw (13.995 at 25 °C).
 */
export function solvePh(components, pKw = 13.995) {
    let low = -3;
    let high = 17;

    for (let step = 0; step < 200; step += 1) {
        const middle = (low + high) / 2;

        if (netCharge(10 ** -middle, components, pKw) > 0) {
            low = middle;
        } else {
            high = middle;
        }
    }

    return (low + high) / 2;
}

/**
 * Buffer capacity β = d(C_base)/dpH of a buffer pair, Van Slyke (1922):
 * β = ln 10 × (Kw/[H⁺] + [H⁺] + C Ka [H⁺] ÷ (Ka + [H⁺])²).
 */
export function bufferCapacity(ph, pKa, total, pKw = 13.995) {
    const h = 10 ** -ph;
    const ka = 10 ** -pKa;

    return Math.LN10 * (10 ** -pKw / h + h + (total * ka * h) / (ka + h) ** 2);
}

/**
 * Activity coefficient models at 25 °C. A = 0.5091 kg^½ mol^−½, B = 0.3283 Å⁻¹ (water, 25 °C).
 */
export const DEBYE_HUCKEL = { A: 0.5091, B: 0.3283 };

export function logActivityCoefficient(model, charge, ionicStrength, ionSizeAngstrom = 0) {
    const root = Math.sqrt(ionicStrength);
    const z2 = charge ** 2;

    if (model === 'limiting') {
        return -DEBYE_HUCKEL.A * z2 * root;
    }

    if (model === 'extended') {
        return (-DEBYE_HUCKEL.A * z2 * root) / (1 + DEBYE_HUCKEL.B * ionSizeAngstrom * root);
    }

    return -DEBYE_HUCKEL.A * z2 * (root / (1 + root) - 0.3 * ionicStrength);
}

export const MODEL_LIMIT = { limiting: 0.005, extended: 0.1, davies: 0.5 };
