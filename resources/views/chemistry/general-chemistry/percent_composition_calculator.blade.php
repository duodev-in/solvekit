<x-calc.page
    title="Percent Composition Calculator - SolveKit"
    description="Free percent composition calculator: mass percent of each element in a chemical formula."
    lede="Find the mass percent of each element in a compound."
    about="Each element's mass percent is its total mass in one formula unit divided by the molar mass. The percentages always add up to 100%."
    :calc="['engine' => 'chem-general', 'tool' => 'percent_composition', 'fields' => ['formula'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Type the formula', 'text' => 'Brackets and hydrates are fine.'],
    ]"
    :faqs="[
        ['question' => 'How do you find percent composition?', 'answer' => 'Element mass in the formula ÷ molar mass × 100.'],
        ['question' => 'What is the percent of oxygen in water?', 'answer' => '88.81% by mass.'],
        ['question' => 'How is it used?', 'answer' => 'To check purity, or to work back to an empirical formula.'],
    ]"
>
    <x-calc.field name="formula" label="Chemical formula" value="H2SO4" type="text" help="e.g. H2SO4, Ca(OH)2, CuSO4·5H2O" />

    <x-calc.result label="Percent composition" />

    <x-calc.options :decimals="false" :examples="[
        'Sulfuric acid' => ['formula' => 'H2SO4'],
        'Water' => ['formula' => 'H2O'],
        'Ammonium nitrate' => ['formula' => 'NH4NO3'],
        'Glucose' => ['formula' => 'C6H12O6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Molar mass'],
            'hill' => ['label' => 'Hill formula'],
        ]" />
        <x-calc.quick-ref heading="By element" name="parts" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>% = count × atomic weight ÷ M × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
