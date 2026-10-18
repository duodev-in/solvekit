<x-calc.page
    title="Shannon Diversity Index Calculator - SolveKit"
    description="Free Shannon diversity index calculator: H′, evenness and effective number of species from species counts."
    lede="Work out the Shannon diversity index from counts of each species."
    about="The Shannon index H′ = −Σ pᵢ ln pᵢ rises with both the number of species and how evenly individuals are spread among them. Pielou's evenness J = H′ ÷ ln S runs from 0 to 1, and e^H′ is the effective number of equally common species."
    :calc="['engine' => 'ecology', 'tool' => 'shannon', 'fields' => ['counts']]"
    :how-to="[
        ['name' => 'Count each species', 'text' => 'Individuals of each species in the sample.'],
        ['name' => 'Enter the list', 'text' => 'Comma or space separated.'],
    ]"
    :faqs="[
        ['question' => 'What is a high Shannon index?', 'answer' => 'Typical values are 1.5 to 3.5; above 4 is rare.'],
        ['question' => 'Which logarithm is used?', 'answer' => 'Natural log (ln). Some studies use log₂ or log₁₀, which scale the value.'],
        ['question' => 'How is it different from Simpson\'s?', 'answer' => 'Shannon weighs rare species more; Simpson\'s is driven by the common ones.'],
    ]"
>
    <x-calc.textarea name="counts" label="Individuals per species" value="40, 25, 15, 10, 5, 5" help="One count per species, separated by commas or spaces" rows="3" />

    <x-calc.result label="Shannon index" />

    <x-calc.options :examples="[
        'Six species' => ['counts' => '40, 25, 15, 10, 5, 5'],
        'Perfectly even' => ['counts' => '20, 20, 20, 20, 20'],
        'One dominant' => ['counts' => '90, 5, 3, 2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'evenness' => ['label' => 'Evenness J'],
            'richness' => ['label' => 'Species richness S'],
            'effective' => ['label' => 'Effective species e^H′'],
            'total' => ['label' => 'Total individuals'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pᵢ = nᵢ ÷ N</li>
            <li>H′ = −Σ pᵢ ln pᵢ</li>
            <li>J = H′ ÷ ln S</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
