<x-calc.page
    title="Mass Percent Calculator - SolveKit"
    description="Free mass percent calculator: percent by mass of a solute in a solution, with ppm and molality."
    lede="Work out the mass percent of a solution."
    about="Mass percent (% w/w) is the solute mass divided by the total solution mass, times 100. Enter the solvent mass or the whole solution mass."
    :calc="['engine' => 'chem-mix', 'tool' => 'mass_percent', 'fields' => ['solute', 'other', 'basis', 'formula'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the masses', 'text' => 'Solute and solvent, or solute and solution.'],
        ['name' => 'Add a formula', 'text' => 'Optional, for molality.'],
    ]"
    :faqs="[
        ['question' => 'How do I calculate mass percent?', 'answer' => 'Solute mass ÷ solution mass × 100.'],
        ['question' => 'Is mass percent the same as % w/v?', 'answer' => 'No: w/v uses solution volume, w/w uses solution mass.'],
        ['question' => 'What is 1% in ppm?', 'answer' => '10,000 ppm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="solute" label="Solute mass" value="5" min="0" suffix="g" />
        <x-calc.field name="other" label="Solvent or solution mass" value="95" min="0" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.segmented name="basis" legend="Second mass is" :options="['solvent' => 'Solvent', 'solution' => 'Solution']" selected="solvent" />
        <x-calc.field name="formula" label="Solute formula (optional)" value="NaCl" type="text" help="For molality" />
    </div>

    <x-calc.result label="Mass percent" />

    <x-calc.options :examples="[
        '5 g salt in 95 g water' => ['solute' => 5, 'other' => 95, 'basis' => 'solvent', 'formula' => 'NaCl'],
        '10 g sugar in 250 g solution' => ['solute' => 10, 'other' => 250, 'basis' => 'solution', 'formula' => 'C12H22O11'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ppm' => ['label' => 'In ppm'],
            'solvent' => ['label' => 'Solvent mass'],
            'molality' => ['label' => 'Molality'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>% w/w = m solute ÷ m solution × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
