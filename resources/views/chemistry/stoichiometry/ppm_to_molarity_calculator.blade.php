<x-calc.page
    title="PPM to Molarity Calculator - SolveKit"
    description="Free ppm to molarity calculator: convert parts per million by mass to mol/L and back for any solute."
    lede="Convert ppm to molarity and back."
    about="Here ppm means mass parts per million (mg per kg of solution). mg/L = ppm × solution density in g/mL, so for dilute water solutions at about 1 g/mL, 1 ppm ≈ 1 mg/L. Molarity = mg/L ÷ 1000 ÷ molar mass."
    :calc="['engine' => 'chem-stoich', 'tool' => 'ppm_molarity', 'fields' => ['direction', 'value', 'formula', 'weight', 'density'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick the direction', 'text' => 'ppm to mol/L or back.'],
        ['name' => 'Enter the solute', 'text' => 'Formula or molar mass.'],
        ['name' => 'Check the density', 'text' => '1 g/mL for dilute water solutions.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert ppm to molarity?', 'answer' => 'For dilute water solutions, molarity = ppm ÷ (1000 × molar mass).'],
        ['question' => 'What is 1000 ppm NaCl in molarity?', 'answer' => 'About 0.0171 M.'],
        ['question' => 'When does density matter?', 'answer' => 'For concentrated solutions or solvents other than water.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Convert" :options="['ppm' => 'ppm → mol/L', 'molar' => 'mol/L → ppm']" selected="ppm" />

    <x-calc.field name="value" label="Concentration" value="1000" min="0" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="formula" label="Solute formula" value="NaCl" type="text" help="e.g. H2SO4, Ca(OH)2, CuSO4·5H2O" />
        <x-calc.field name="weight" label="Or molar mass" value="" min="0" suffix="g/mol" placeholder="If no formula" />
    </div>

    <x-calc.field name="density" label="Solution density" value="1" min="0" suffix="g/mL" />

    <x-calc.result label="Converted concentration" />

    <x-calc.options :examples="[
        '1000 ppm NaCl' => ['direction' => 'ppm', 'value' => 1000, 'formula' => 'NaCl', 'density' => 1],
        '0.01 M CaCO₃' => ['direction' => 'molar', 'value' => 0.01, 'formula' => 'CaCO3', 'density' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mg' => ['label' => 'mg/L'],
            'micromolar' => ['label' => 'In µM'],
            'density' => ['label' => 'Density used'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mg/L = ppm × density (g/mL)</li>
            <li>M = mg/L ÷ 1000 ÷ M(solute)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
