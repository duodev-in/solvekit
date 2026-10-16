<x-calc.page
    title="Cat Age Calculator - SolveKit"
    description="Free cat age calculator: cat years to human years with the AAFP and AAHA feline life stages."
    lede="Convert your cat's age into human years and life stage."
    about="Cats mature quickly: a 1-year-old is about 15 in human years and a 2-year-old about 24, then each year adds about 4. Life stages follow the 2021 AAHA/AAFP guidelines: kitten to 1 year, young adult 1 to 6, mature adult 7 to 10 and senior from 11."
    :calc="['engine' => 'pets', 'tool' => 'cat_age', 'fields' => ['age', 'age_unit']]"
    :how-to="[
        ['name' => 'Enter the age', 'text' => 'In years, or months for kittens.'],
    ]"
    :faqs="[
        ['question' => 'How old is a 1-year-old cat in human years?', 'answer' => 'About 15.'],
        ['question' => 'When is a cat a senior?', 'answer' => 'From about 11 years.'],
        ['question' => 'How long do cats live?', 'answer' => 'Typically 12 to 18 years; indoor cats often live longer.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="4" min="0" />
        <x-calc.segmented name="age_unit" legend="In" :options="['years' => 'Years', 'months' => 'Months']" selected="years" />
    </div>

    <x-calc.result label="Human-equivalent age" />

    <x-calc.options :examples="[
        '6 months' => ['age' => 6, 'age_unit' => 'months'],
        '4 years' => ['age' => 4, 'age_unit' => 'years'],
        '15 years' => ['age' => 15, 'age_unit' => 'years'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'stage' => ['label' => 'Life stage'],
            'next' => ['label' => 'Next stage'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 year = 15, 2 years = 24, then + 4 a year</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
