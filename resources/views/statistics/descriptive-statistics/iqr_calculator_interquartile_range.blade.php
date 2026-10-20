<x-calc.page
    title="IQR Calculator — Interquartile Range - SolveKit"
    description="Free IQR calculator: the interquartile range Q3 − Q1 with quartiles, outlier fences and a choice of method."
    lede="Find the interquartile range."
    about="The interquartile range is the spread of the middle half of the data, Q3 − Q1. Outliers barely affect it."
    :calc="['engine' => 'st-desc', 'tool' => 'iqr', 'fields' => ['data', 'method'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the IQR of the example?', 'answer' => '7.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="3, 7, 8, 5, 12, 14, 21, 13, 18" rows="3" />
        <x-calc.select name="method" label="Quartile method" :options="['inc' => 'Inclusive (Excel .INC, R type 7)', 'exc' => 'Exclusive (Excel .EXC, Minitab, SPSS)', 'halves' => 'Median of halves (TI-84, textbooks)', 'tukey' => 'Tukey hinges', 'nearest' => 'Nearest rank']" selected="inc" />
    </div>

    <x-calc.result label="Interquartile range" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '3, 7, 8, 5, 12, 14, 21, 13, 18', 'method' => 'inc'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'q1' => ['label' => 'Q1'],
            'q3' => ['label' => 'Q3'],
            'fences' => ['label' => 'Outlier fences (1.5 × IQR)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
