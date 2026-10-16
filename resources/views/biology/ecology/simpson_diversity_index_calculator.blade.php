<x-calc.page
    title="Simpson's Diversity Index Calculator - SolveKit"
    description="Free Simpson's diversity index calculator: D, 1 − D and 1/D from species counts."
    lede="Work out Simpson's diversity index from counts of each species."
    about="Simpson's D is the chance that two individuals drawn at random without replacement belong to the same species. 1 − D (Gini–Simpson) is the chance they differ, so it rises with diversity, and 1 ÷ D is the effective number of species."
    :calc="['engine' => 'ecology', 'tool' => 'simpson', 'fields' => ['counts']]"
    :how-to="[
        ['name' => 'Count each species', 'text' => 'Individuals of each species in the sample.'],
        ['name' => 'Enter the list', 'text' => 'Comma or space separated.'],
    ]"
    :faqs="[
        ['question' => 'Is a higher Simpson\'s index more diverse?', 'answer' => 'For 1 − D and 1 ÷ D yes; for D itself, lower is more diverse.'],
        ['question' => 'Why n(n − 1)?', 'answer' => 'It is sampling without replacement, which suits finite samples.'],
        ['question' => 'Which index should I report?', 'answer' => 'State which form you use; 1 − D is the most common.'],
    ]"
>
    <x-calc.textarea name="counts" label="Individuals per species" value="40, 25, 15, 10, 5, 5" help="One count per species, separated by commas or spaces" rows="3" />

    <x-calc.result label="Simpson's index" />

    <x-calc.options :examples="[
        'Six species' => ['counts' => '40, 25, 15, 10, 5, 5'],
        'Perfectly even' => ['counts' => '20, 20, 20, 20, 20'],
        'One dominant' => ['counts' => '90, 5, 3, 2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'd' => ['label' => 'Simpson\'s D'],
            'reciprocal' => ['label' => 'Reciprocal 1 ÷ D'],
            'richness' => ['label' => 'Species richness'],
            'total' => ['label' => 'Total individuals'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>D = Σ n(n − 1) ÷ N(N − 1)</li>
            <li>diversity = 1 − D</li>
            <li>effective species = 1 ÷ D</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
