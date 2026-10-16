<x-calc.page
    title="Dog Age Calculator - SolveKit"
    description="Free dog age calculator: your dog's age in human years by size, with the 2020 epigenetic clock formula and life stage."
    lede="Convert your dog's age into human years by size."
    about="The old rule of 7 human years per dog year is wrong: dogs age fast in the first two years, then more slowly, and big dogs age faster than small ones. The size chart gives about 15 human years for the first year and 24 for the second. The epigenetic formula 16 × ln(age) + 31 (Wang et al., 2020) came from DNA changes in Labradors."
    :calc="['engine' => 'pets', 'tool' => 'dog_age', 'fields' => ['size', 'age', 'age_unit']]"
    :how-to="[
        ['name' => 'Pick the size', 'text' => 'Adult weight sets the curve.'],
        ['name' => 'Enter the age', 'text' => 'In years or months.'],
    ]"
    :faqs="[
        ['question' => 'Is one dog year 7 human years?', 'answer' => 'No. The first year is about 15 human years, the second about 9 more, then 4 to 7 a year by size.'],
        ['question' => 'Why do big dogs age faster?', 'answer' => 'Large and giant breeds have shorter lifespans and reach old age sooner.'],
        ['question' => 'What is the epigenetic formula?', 'answer' => 'Human age ≈ 16 × ln(dog age) + 31, from DNA methylation in Labradors (Wang et al., 2020).'],
    ]"
>
    <x-calc.select name="size" label="Size" :options="['small' => 'Small (under 20 lb)', 'medium' => 'Medium (21–50 lb)', 'large' => 'Large (51–100 lb)', 'giant' => 'Giant (over 100 lb)']" selected="medium" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="5" min="0" />
        <x-calc.segmented name="age_unit" legend="In" :options="['years' => 'Years', 'months' => 'Months']" selected="years" />
    </div>

    <x-calc.result label="Human-equivalent age" />

    <x-calc.options :examples="[
        'Medium dog, 5 years' => ['size' => 'medium', 'age' => 5, 'age_unit' => 'years'],
        'Giant dog, 8 years' => ['size' => 'giant', 'age' => 8, 'age_unit' => 'years'],
        'Small puppy, 6 months' => ['size' => 'small', 'age' => 6, 'age_unit' => 'months'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'epigenetic' => ['label' => 'Epigenetic formula'],
            'stage' => ['label' => 'Life stage'],
            'lifespan' => ['label' => 'Typical lifespan'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>size chart: year 1 ≈ 15, year 2 ≈ 24, then 4 to 7 a year by size</li>
            <li>epigenetic: human age = 16 × ln(dog age) + 31</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
