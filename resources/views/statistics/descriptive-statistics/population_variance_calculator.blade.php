<x-calc.page
    title="Population Variance Calculator - SolveKit"
    description="Free population variance calculator: σ² and σ of a whole population, with the squared deviations."
    lede="Find the population variance."
    about="Population variance is the average squared deviation from the mean, dividing by N rather than n − 1."
    :calc="['engine' => 'st-desc', 'tool' => 'pop_variance', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is σ² for 2, 4, 4, 4, 5, 5, 7, 9?', 'answer' => '4.'],
    ]"
>
    <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="2, 4, 4, 4, 5, 5, 7, 9" rows="3" />

    <x-calc.result label="Population variance σ²" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '2, 4, 4, 4, 5, 5, 7, 9'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sd' => ['label' => 'Population SD σ'],
            'mean' => ['label' => 'Mean μ'],
            'sample' => ['label' => 'Sample variance s² (for comparison)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Squared deviations" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
