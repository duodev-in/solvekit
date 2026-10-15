<x-calc.page
    title="PPM Calculator - SolveKit"
    description="Professional PPM calculator for parts per million calculations. Convert concentrations, analyze solutions, and calculate dilutions for chemistry and water quality testing."
    lede="Work out parts per million from a mass ratio, a percentage, a molarity, or a dilution."
    about="Parts per million is a ratio: 1 ppm is 1 mg of solute per kg of solution. For water and dilute water solutions 1 L weighs about 1 kg, so ppm ≈ mg/L. For other solvents or strong solutions use the mass-by-mass mode, or the PPM to mg/L converter with the solution's density."
    :calc="['engine' => 'ppm']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Solute and solution amounts, a percentage, a molarity, or a dilution.'],
        ['name' => 'Fill in the values', 'text' => 'The concentration is shown in ppm, ppb, percent and mg/L.'],
    ]"
    :faqs="[
        ['question' => 'Is ppm the same as mg/L?', 'answer' => 'For water and dilute water solutions, yes, because a liter weighs about a kilogram. For other liquids, multiply ppm by the density in kg/L.'],
        ['question' => 'How many ppm is 1 percent?', 'answer' => '10,000 ppm.'],
        ['question' => 'How do I dilute a solution to a target ppm?', 'answer' => 'Use C₁ × V₁ = C₂ × V₂. Diluting 50 mL of 1,000 ppm to 500 mL gives 100 ppm.'],
    ]"
>
    <x-calc.segmented name="mode" legend="I know" :options="['mass_volume' => 'mg in L', 'mass_mass' => 'mg in kg', 'percent' => 'Percent', 'molarity' => 'Molarity', 'dilution' => 'Dilution']" selected="mass_volume" size="sm" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="mode:mass_volume,mass_mass"><x-calc.field name="solute" label="Solute" value="250" min="0" suffix="mg" placeholder="mg" /></div>
        <div data-show-when="mode:mass_volume,mass_mass"><x-calc.field name="solution" label="Solution" value="2" min="0" suffix="L or kg" placeholder="Amount" /></div>
        <div data-show-when="mode:percent" hidden><x-calc.field name="percent" label="Concentration" value="0.5" min="0" suffix="%" placeholder="%" /></div>
        <div data-show-when="mode:molarity" hidden><x-calc.field name="molarity" label="Molarity" value="0.01" min="0" suffix="mol/L" placeholder="mol/L" /></div>
        <div data-show-when="mode:molarity,mass_volume,mass_mass,percent,dilution"><x-calc.field name="molar-mass" label="Molar mass (optional)" value="58.44" min="0" suffix="g/mol" placeholder="g/mol" /></div>
        <div data-show-when="mode:dilution" hidden><x-calc.field name="c1" label="Starting ppm (C₁)" value="1000" min="0" suffix="ppm" /></div>
        <div data-show-when="mode:dilution" hidden><x-calc.field name="v1" label="Volume used (V₁)" value="50" min="0" suffix="mL" /></div>
        <div data-show-when="mode:dilution" hidden><x-calc.field name="v2" label="Final volume (V₂)" value="500" min="0" suffix="mL" /></div>
    </div>

    <x-calc.result label="Concentration" />

    <x-calc.options :examples="[
        'Pool chlorine 3 mg in 1 L' => ['mode' => 'mass_volume', 'solute' => 3, 'solution' => 1],
        'Saline 0.9%' => ['mode' => 'percent', 'percent' => 0.9],
        'Dilute 1:10' => ['mode' => 'dilution', 'c1' => 1000, 'v1' => 50, 'v2' => 500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same concentration in" :rows="[
            'ppb' => ['label' => 'Parts per billion', 'unit' => 'ppb'],
            'percent' => ['label' => 'Percent', 'unit' => '%'],
            'mgl' => ['label' => 'mg/L (water-like solution)', 'unit' => 'mg/L'],
            'gl' => ['label' => 'g/L (water-like solution)', 'unit' => 'g/L'],
            'moll' => ['label' => 'Molarity', 'unit' => 'mol/L'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ppm = mg solute ÷ kg solution</li>
            <li>1% = 10,000 ppm</li>
            <li>mg/L = mol/L × g/mol × 1,000</li>
            <li>C₂ = C₁ × V₁ ÷ V₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
