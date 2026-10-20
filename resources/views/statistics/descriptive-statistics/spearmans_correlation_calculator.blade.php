<x-calc.page
    title="Spearman's Correlation Calculator - SolveKit"
    description="Free Spearman's rank correlation calculator: ρ with ties handled, a p-value and the rank table."
    lede="Find Spearman's ρ."
    about="Spearman's ρ is the correlation of the ranks. It measures any monotonic relationship, not just straight lines."
    :calc="['engine' => 'st-desc', 'tool' => 'spearman', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is ρ for the example?', 'answer' => '0.927273.'],
    ]"
>
    <x-calc.textarea name="data" label="x, y pairs (one per line)" value="1, 2
2, 1
3, 4
4, 3
5, 6
6, 5
7, 8
8, 9
9, 7
10, 10" rows="10" />

    <x-calc.result label="Spearman ρ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '1, 2
2, 1
3, 4
4, 3
5, 6
6, 5
7, 8
8, 9
9, 7
10, 10'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'p' => ['label' => 'p-value (two-sided, t approximation)'],
            'n' => ['label' => 'Pairs'],
            'strength' => ['label' => 'Strength'],
            'ties' => ['label' => 'Ties'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Ranks" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
