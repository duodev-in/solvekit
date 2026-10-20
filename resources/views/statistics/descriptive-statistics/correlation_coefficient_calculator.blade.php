<x-calc.page
    title="Correlation Coefficient Calculator - SolveKit"
    description="Free correlation coefficient calculator: Pearson r, Spearman ρ or Kendall τ with p-values and a scatter plot."
    lede="Find a correlation coefficient."
    about="A correlation coefficient measures how strongly two variables move together, from −1 to +1."
    :calc="['engine' => 'st-desc', 'tool' => 'correlation', 'fields' => ['data', 'type'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is Pearson’s r for the example?', 'answer' => '0.99926.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="x, y pairs (one per line)" value="1, 2.1
2, 3.9
3, 6.2
4, 7.8
5, 9.9
6, 12.3
7, 13.8
8, 16.1" rows="8" />
        <x-calc.select name="type" label="Coefficient" :options="['pearson' => 'Pearson r (linear)', 'spearman' => 'Spearman ρ (ranks)', 'kendall' => 'Kendall τ-b (ranks)']" selected="pearson" />
    </div>

    <x-calc.result label="Correlation coefficient" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '1, 2.1
2, 3.9
3, 6.2
4, 7.8
5, 9.9
6, 12.3
7, 13.8
8, 16.1', 'type' => 'pearson'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Scatter plot" name="scatter" />
        <x-calc.rows heading="Details" :rows="[
            'p' => ['label' => 'p-value (two-sided)'],
            'ci' => ['label' => '95% CI (Pearson)'],
            'r2' => ['label' => 'r²'],
            'strength' => ['label' => 'Strength'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
