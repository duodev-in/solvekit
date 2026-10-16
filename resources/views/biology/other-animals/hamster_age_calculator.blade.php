<x-calc.page
    title="Hamster Age Calculator - SolveKit"
    description="Free hamster age calculator: hamster age in human years for Syrian, dwarf and Roborovski hamsters."
    lede="Convert your hamster's age into an approximate human age."
    about="Hamsters live about 2 to 3 years, so each month counts for a lot. The human-equivalent age is the same share of an 80-year human life as your hamster has lived of its species' typical lifespan."
    :calc="['engine' => 'animals', 'tool' => 'lifespan_age', 'fields' => ['species', 'age', 'age_unit'], 'data' => config('biology_data.hamster_lifespans')]"
    :how-to="[
        ['name' => 'Pick the species', 'text' => 'Syrian, dwarf or Roborovski.'],
        ['name' => 'Enter the age', 'text' => 'Months are easiest for hamsters.'],
    ]"
    :faqs="[
        ['question' => 'How long do hamsters live?', 'answer' => 'About 2 to 3 years; Roborovskis often live a little longer.'],
        ['question' => 'When is a hamster old?', 'answer' => 'From about 18 months for most species.'],
        ['question' => 'Is one hamster month like a human year?', 'answer' => 'Roughly 2.5 to 3 human years per month, depending on species.'],
    ]"
>
    <x-calc.select name="species" label="Species" :options="collect(config('biology_data.hamster_lifespans'))->map(fn ($item) => $item['name'])->all()" selected="syrian" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="12" min="0" />
        <x-calc.segmented name="age_unit" legend="In" :options="['months' => 'Months', 'years' => 'Years']" selected="months" />
    </div>

    <x-calc.result label="Human-equivalent age" />

    <x-calc.options :examples="[
        'Syrian, 1 year' => ['species' => 'syrian', 'age' => 12, 'age_unit' => 'months'],
        'Roborovski, 2 years' => ['species' => 'roborovski', 'age' => 24, 'age_unit' => 'months'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'stage' => ['label' => 'Life stage'],
            'share' => ['label' => 'Share of lifespan'],
            'lifespan' => ['label' => 'Typical lifespan'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>human age ≈ age ÷ lifespan × 80</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
