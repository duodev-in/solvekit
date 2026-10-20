<x-calc.page
    title="5 Number Summary Calculator - SolveKit"
    description="Free five-number summary calculator: minimum, Q1, median, Q3 and maximum with a box plot and a choice of quartile method."
    lede="Find the five-number summary."
    about="The five-number summary describes a data set by its minimum, lower quartile, median, upper quartile and maximum."
    :calc="['engine' => 'st-desc', 'tool' => 'five_number', 'fields' => ['data', 'method'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the five-number summary of the example?', 'answer' => '3, 7, 12, 14, 21.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="3, 7, 8, 5, 12, 14, 21, 13, 18" rows="3" />
        <x-calc.select name="method" label="Quartile method" :options="['inc' => 'Inclusive (Excel .INC, R type 7)', 'exc' => 'Exclusive (Excel .EXC, Minitab, SPSS)', 'halves' => 'Median of halves (TI-84, textbooks)', 'tukey' => 'Tukey hinges', 'nearest' => 'Nearest rank']" selected="inc" />
    </div>

    <x-calc.result label="Five-number summary" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '3, 7, 8, 5, 12, 14, 21, 13, 18', 'method' => 'inc'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Box plot" name="box" />
        <x-calc.rows heading="Details" :rows="[
            'min' => ['label' => 'Minimum'],
            'q1' => ['label' => 'First quartile Q1'],
            'med' => ['label' => 'Median'],
            'q3' => ['label' => 'Third quartile Q3'],
            'max' => ['label' => 'Maximum'],
            'iqr' => ['label' => 'IQR'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
