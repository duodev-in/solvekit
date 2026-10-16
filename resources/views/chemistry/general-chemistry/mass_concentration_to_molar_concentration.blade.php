<x-calc.page
    title="Mass Concentration to Molar Concentration Conversion - SolveKit"
    description="Free converter between mass concentration (g/L) and molar concentration (mol/L) from a formula or molar mass."
    lede="Convert between g/L and mol/L."
    about="Molar concentration is mass concentration divided by molar mass: c = ρ ÷ M. Enter a formula to work out M from IUPAC atomic weights, or type the molar mass."
    :calc="['engine' => 'chem-general', 'tool' => 'mass_molar', 'fields' => ['direction', 'value', 'formula', 'weight'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick the direction', 'text' => 'g/L to mol/L or back.'],
        ['name' => 'Enter the formula', 'text' => 'Or a molar mass if you know it.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert g/L to mol/L?', 'answer' => 'Divide by the molar mass in g/mol.'],
        ['question' => 'What is 1 g/L of NaCl in molarity?', 'answer' => 'About 0.0171 mol/L (1 ÷ 58.44).'],
        ['question' => 'Is mg/L the same as ppm?', 'answer' => 'For dilute water solutions, approximately yes, since 1 L of water weighs about 1 kg.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Convert" :options="['mass' => 'g/L → mol/L', 'molar' => 'mol/L → g/L']" selected="mass" />

    <x-calc.field name="value" label="Concentration" value="58.44" min="0" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="formula" label="Formula" value="NaCl" type="text" help="e.g. H2SO4, Ca(OH)2, CuSO4·5H2O" />
        <x-calc.field name="weight" label="Or molar mass" value="" min="0" suffix="g/mol" placeholder="If no formula" />
    </div>

    <x-calc.result label="Converted concentration" />

    <x-calc.options :examples="[
        '58.44 g/L NaCl' => ['direction' => 'mass', 'value' => 58.44, 'formula' => 'NaCl'],
        '0.1 M glucose' => ['direction' => 'molar', 'value' => 0.1, 'formula' => 'C6H12O6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mg' => ['label' => 'Also'],
            'ppm' => ['label' => 'In smaller units'],
            'weight' => ['label' => 'Molar mass used'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>c (mol/L) = ρ (g/L) ÷ M (g/mol)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
