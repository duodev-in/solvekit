<x-calc.page
    title="Cohen's Kappa Calculator - SolveKit"
    description="Free Cohen's kappa calculator: inter-rater agreement beyond chance from an agreement table."
    lede="Find Cohen's κ."
    about="Cohen's κ measures how much two raters agree beyond what chance alone would produce."
    :calc="['engine' => 'st-desc', 'tool' => 'kappa', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is κ for the example table?', 'answer' => '0.4.'],
    ]"
>
    <x-calc.textarea name="data" label="Agreement table: rater A’s categories in rows, rater B’s in columns" value="20, 5
10, 15" rows="3" />

    <x-calc.result label="Cohen’s κ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '20, 5
10, 15'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'po' => ['label' => 'Observed agreement pₒ'],
            'pe' => ['label' => 'Chance agreement pₑ'],
            'ci' => ['label' => '95% CI (approximate)'],
            'band' => ['label' => 'Strength (Landis & Koch)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
