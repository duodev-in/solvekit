<x-calc.page
    title="Guinea Pig Years to Human Years Calculator - SolveKit"
    description="Free guinea pig age calculator: guinea pig years to human years and life stage."
    lede="Convert your guinea pig's age into an approximate human age."
    about="Guinea pigs live about 5 to 7 years. The human-equivalent age is the same share of an 80-year human life, so a 1-year-old is roughly a young teenager. Guinea pigs are usually considered senior from about 5 years."
    :calc="['engine' => 'animals', 'tool' => 'lifespan_age', 'fields' => ['age', 'age_unit'], 'data' => config('biology_data.guinea_pig_lifespan')]"
    :how-to="[
        ['name' => 'Enter the age', 'text' => 'In years or months.'],
        ['name' => 'Read the human age', 'text' => 'An approximate comparison.'],
    ]"
    :faqs="[
        ['question' => 'How long do guinea pigs live?', 'answer' => 'About 5 to 7 years, sometimes 8 or more.'],
        ['question' => 'When is a guinea pig a senior?', 'answer' => 'From about 5 years.'],
        ['question' => 'When are they fully grown?', 'answer' => 'At about 12 to 14 months.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="2" min="0" />
        <x-calc.segmented name="age_unit" legend="In" :options="['years' => 'Years', 'months' => 'Months']" selected="years" />
    </div>

    <x-calc.result label="Human-equivalent age" />

    <x-calc.options :examples="[
        '6 months' => ['age' => 6, 'age_unit' => 'months'],
        '2 years' => ['age' => 2, 'age_unit' => 'years'],
        '5 years' => ['age' => 5, 'age_unit' => 'years'],
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
            <li>human age ≈ age ÷ 6 years × 80</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
