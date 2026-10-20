<x-calc.page
    title="Box Plot Calculator - SolveKit"
    description="Free box plot maker: box-and-whisker plots of one or more data sets, with quartiles, whiskers and outliers."
    lede="Draw a box plot."
    about="A box plot shows the median, quartiles and spread of data at a glance, with outliers drawn separately."
    :calc="['engine' => 'st-dist', 'tool' => 'box_plot', 'fields' => ['data', 'method'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the median of Class A?', 'answer' => '74.5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data sets: one per line, optionally named (“Group A: 3, 5, 7”)" value="Class A: 62, 67, 70, 71, 74, 75, 78, 80, 84, 99
Class B: 55, 60, 64, 68, 70, 72, 73, 79, 82, 88" rows="3" />
        <x-calc.select name="method" label="Quartile method" :options="['inc' => 'Inclusive (Excel .INC, R type 7)', 'exc' => 'Exclusive (Excel .EXC, Minitab, SPSS)', 'halves' => 'Median of halves (TI-84, textbooks)', 'tukey' => 'Tukey hinges', 'nearest' => 'Nearest rank']" selected="inc" />
    </div>

    <x-calc.result label="Median (first set)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => 'Class A: 62, 67, 70, 71, 74, 75, 78, 80, 84, 99
Class B: 55, 60, 64, 68, 70, 72, 73, 79, 82, 88', 'method' => 'inc'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Box plot" name="box" />
        <x-calc.rows heading="Details" :rows="[
            'five' => ['label' => 'Five-number summary (first set)'],
            'iqr' => ['label' => 'IQR'],
            'fences' => ['label' => 'Fences (1.5 × IQR)'],
            'outliers' => ['label' => 'Outliers'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Every data set" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
