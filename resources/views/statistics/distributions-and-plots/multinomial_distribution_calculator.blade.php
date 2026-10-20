<x-calc.page
    title="Multinomial Distribution Calculator - SolveKit"
    description="Free multinomial distribution calculator: the probability of an exact set of counts across several categories."
    lede="Find a multinomial probability."
    about="The multinomial distribution extends the binomial to more than two outcomes per trial."
    :calc="['engine' => 'st-dist', 'tool' => 'multinomial', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the probability of counts 3, 2, 1 in the example?', 'answer' => '0.135.'],
    ]"
>
    <x-calc.textarea name="data" label="Categories: probability, count (one per line)" value="0.5, 3
0.3, 2
0.2, 1" rows="3" />

    <x-calc.result label="P(exactly these counts)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '0.5, 3
0.3, 2
0.2, 1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'n' => ['label' => 'Total trials n'],
            'expected' => ['label' => 'Expected counts'],
            'ways' => ['label' => 'Arrangements n!/∏xᵢ!'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
