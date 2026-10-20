<x-calc.page
    title="Pearson Correlation Calculator - SolveKit"
    description="Free Pearson correlation calculator: r with its p-value, confidence interval and a scatter plot."
    lede="Find Pearson’s r."
    about="Pearson’s r measures the strength of a straight-line relationship between two variables."
    :calc="['engine' => 'st-desc', 'tool' => 'pearson', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is r for the example?', 'answer' => '0.99926 (p = 1.01336 × 10⁻⁹).'],
    ]"
>
    <x-calc.textarea name="data" label="x, y pairs (one per line)" value="1, 2.1
2, 3.9
3, 6.2
4, 7.8
5, 9.9
6, 12.3
7, 13.8
8, 16.1" rows="8" />

    <x-calc.result label="Pearson r" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '1, 2.1
2, 3.9
3, 6.2
4, 7.8
5, 9.9
6, 12.3
7, 13.8
8, 16.1'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Scatter plot with least-squares line" name="scatter" />
        <x-calc.rows heading="Details" :rows="[
            'r2' => ['label' => 'r²'],
            't' => ['label' => 't (n − 2 df)'],
            'p' => ['label' => 'p-value (two-sided)'],
            'ci' => ['label' => '95% confidence interval'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
