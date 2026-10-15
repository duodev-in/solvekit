/**
 * PPM calculator. Modes:
 *   mass_volume: mg of solute in L of water-like solution → ppm ≈ mg/L
 *   mass_mass:   mg of solute in kg of solution → ppm = mg/kg (exact by definition)
 *   percent:     % → ppm (× 10,000)
 *   molarity:    mol/L × molar mass → mg/L ≈ ppm
 *   dilution:    C1 × V1 = C2 × V2
 */
export function ppmFrom(mode, inputs) {
    switch (mode) {
        case 'mass_volume': return inputs.solute / inputs.solution;
        case 'mass_mass': return inputs.solute / inputs.solution;
        case 'percent': return inputs.percent * 10000;
        case 'molarity': return inputs.molarity * inputs.molarMass * 1000;
        case 'dilution': return (inputs.c1 * inputs.v1) / inputs.v2;
        default: return Number.NaN;
    }
}

const FIELDS = {
    mass_volume: ['solute', 'solution'],
    mass_mass: ['solute', 'solution'],
    percent: ['percent'],
    molarity: ['molarity', 'molar-mass'],
    dilution: ['c1', 'v1', 'v2'],
};

export default function ppm(ctx) {
    ctx.onUpdate(() => {
        const mode = ctx.choice('mode');
        const values = Object.fromEntries(FIELDS[mode].map((name) => [name.replace(/-(\w)/, (_, letter) => letter.toUpperCase()), ctx.number(name)]));

        if (Object.values(values).some(Number.isNaN)) {
            ctx.clearResult('Fill in every field for this mode.');

            return;
        }

        if (Object.values(values).some((value) => value < 0) || (values.solution === 0) || (values.v2 === 0)) {
            ctx.showError('Values cannot be negative, and the solution or final volume must be greater than 0.');

            return;
        }

        const result = ppmFrom(mode, values);
        const molarMass = ctx.number('molar-mass');

        ctx.showResult({
            value: ctx.format(result),
            unit: 'ppm',
            sub: { mass_volume: 'mg/L, assuming a water-like solution (1 L ≈ 1 kg)', mass_mass: 'mg/kg, exact by mass', percent: '1% = 10,000 ppm', molarity: 'mg/L = mol/L × g/mol × 1,000', dilution: 'C₂ = C₁ × V₁ ÷ V₂' }[mode],
        });

        ctx.setRow('ppb', ctx.format(result * 1000));
        ctx.setRow('percent', ctx.format(result / 10000));
        ctx.setRow('mgl', ctx.format(result));
        ctx.setRow('gl', ctx.format(result / 1000));
        ctx.setRow('moll', molarMass > 0 ? ctx.format(result / 1000 / molarMass) : 'Enter a molar mass');
    });
}
