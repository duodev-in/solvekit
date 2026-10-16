<x-calc.page
    title="Rate of Effusion Calculator - SolveKit"
    description="Free rate of effusion calculator: Graham's law rate ratio and RMS speeds of two gases from their formulas."
    lede="Compare how fast two gases effuse with Graham's law."
    about="Graham's law: lighter gases effuse faster, in proportion to the square root of the inverse molar mass, rate₁ ÷ rate₂ = √(M₂ ÷ M₁). Molar masses come from the formulas; RMS speeds use √(3RT ÷ M)."
    :calc="['engine' => 'chem-physical', 'tool' => 'effusion', 'fields' => ['gas1', 'gas2', 'temperature', 'rate2'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter two gases', 'text' => 'As formulas.'],
        ['name' => 'Add a rate', 'text' => 'To get the other gas\'s rate.'],
    ]"
    :faqs="[
        ['question' => 'How much faster does hydrogen effuse than oxygen?', 'answer' => 'About 3.98 times, since √(32 ÷ 2) ≈ 4.'],
        ['question' => 'What is effusion?', 'answer' => 'Gas escaping through a tiny hole into a vacuum.'],
        ['question' => 'How was this used for uranium?', 'answer' => 'UF₆ of U-235 effuses about 0.4% faster than U-238, used for enrichment.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="gas1" label="Gas 1" value="H2" type="text" help="e.g. H2SO4, Ca(OH)2, CuSO4·5H2O" />
        <x-calc.field name="gas2" label="Gas 2" value="O2" type="text" help="e.g. H2SO4, Ca(OH)2, CuSO4·5H2O" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="temperature" label="Temperature" value="25" suffix="°C" />
        <x-calc.field name="rate2" label="Rate of gas 2 (optional)" value="" min="0" placeholder="Optional" />
    </div>

    <x-calc.result label="Rate ratio" />

    <x-calc.options :examples="[
        'H₂ vs O₂' => ['gas1' => 'H2', 'gas2' => 'O2', 'temperature' => 25, 'rate2' => ''],
        'He vs N₂' => ['gas1' => 'He', 'gas2' => 'N2', 'temperature' => 25, 'rate2' => ''],
        'Uranium hexafluoride' => ['gas1' => 'UF6', 'gas2' => 'UF6', 'temperature' => 25, 'rate2' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'time' => ['label' => 'Time ratio'],
            'rms1' => ['label' => 'RMS speed, gas 1'],
            'rms2' => ['label' => 'RMS speed, gas 2'],
            'rate' => ['label' => 'Rate of gas 1'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rate₁ ÷ rate₂ = √(M₂ ÷ M₁)</li>
            <li>v rms = √(3RT ÷ M)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
