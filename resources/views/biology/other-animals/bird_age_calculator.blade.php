<x-calc.page
    title="Bird Age Calculator - SolveKit"
    description="Free bird age calculator: your bird's age in human years by species, from budgies to macaws, using typical lifespans."
    lede="Convert a pet bird's age into an approximate human age."
    about="Bird lifespans vary hugely, from about 6 years for a zebra finch to 50 or more for large parrots. The human-equivalent age here is the same share of an 80-year human life as your bird has lived of its typical lifespan, so treat it as a rough comparison."
    :calc="['engine' => 'animals', 'tool' => 'lifespan_age', 'fields' => ['species', 'age', 'age_unit'], 'data' => config('biology_data.bird_lifespans')]"
    :how-to="[
        ['name' => 'Pick the species', 'text' => 'Lifespan sets the scale.'],
        ['name' => 'Enter the age', 'text' => 'In years or months.'],
    ]"
    :faqs="[
        ['question' => 'How long do budgies live?', 'answer' => 'About 5 to 10 years, sometimes longer with good care.'],
        ['question' => 'Why do parrots live so long?', 'answer' => 'Large parrots have slow metabolisms for their size and can live 50 years or more.'],
        ['question' => 'Is this age exact?', 'answer' => 'No, it is an approximate comparison based on typical lifespans.'],
    ]"
>
    <x-calc.select name="species" label="Species" :options="collect(config('biology_data.bird_lifespans'))->map(fn ($item) => $item['name'])->all()" selected="budgerigar" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="3" min="0" />
        <x-calc.segmented name="age_unit" legend="In" :options="['years' => 'Years', 'months' => 'Months']" selected="years" />
    </div>

    <x-calc.result label="Human-equivalent age" />

    <x-calc.options :examples="[
        'Budgie, 3 years' => ['species' => 'budgerigar', 'age' => 3, 'age_unit' => 'years'],
        'African grey, 20 years' => ['species' => 'african_grey', 'age' => 20, 'age_unit' => 'years'],
        'Cockatiel, 6 months' => ['species' => 'cockatiel', 'age' => 6, 'age_unit' => 'months'],
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
