<x-calc.page
    title="Quartile Calculator - SolveKit"
    description="Free quartile calculator: Q1, Q2 and Q3 by every common method side by side."
    lede="Find quartiles."
    about="Quartiles divide sorted data into four equal parts. Textbooks and software use different rules, so this page shows them all. Also known as First Quartile Calculator and Third Quartile Calculator."
    :calc="['engine' => 'st-desc', 'tool' => 'quartile', 'fields' => ['data', 'method'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What are the quartiles of the example?', 'answer' => '25.5, 40, 42.5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="6, 7, 15, 36, 39, 40, 41, 42, 43, 47, 49" rows="3" />
        <x-calc.select name="method" label="Quartile method" :options="['inc' => 'Inclusive (Excel .INC, R type 7)', 'exc' => 'Exclusive (Excel .EXC, Minitab, SPSS)', 'halves' => 'Median of halves (TI-84, textbooks)', 'tukey' => 'Tukey hinges', 'nearest' => 'Nearest rank']" selected="inc" />
    </div>

    <x-calc.result label="Quartiles Q1, Q2, Q3" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '6, 7, 15, 36, 39, 40, 41, 42, 43, 47, 49', 'method' => 'inc'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'q1' => ['label' => 'Q1 (25th percentile)'],
            'q2' => ['label' => 'Q2 (median)'],
            'q3' => ['label' => 'Q3 (75th percentile)'],
            'iqr' => ['label' => 'IQR'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="The same data by every method" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
