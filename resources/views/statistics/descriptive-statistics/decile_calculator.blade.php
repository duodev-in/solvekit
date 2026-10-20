<x-calc.page
    title="Decile Calculator - SolveKit"
    description="Free decile calculator: all nine deciles of a data set with a choice of method."
    lede="Find deciles."
    about="Deciles split sorted data into ten equal parts; the fifth decile is the median."
    :calc="['engine' => 'st-desc', 'tool' => 'decile', 'fields' => ['data', 'method'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What are D1 and D9 for the example?', 'answer' => '4.4 and 21.2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="2, 4, 5, 7, 8, 10, 11, 13, 14, 16, 17, 19, 20, 22, 25" rows="3" />
        <x-calc.select name="method" label="Method" :options="['inc' => 'Inclusive (Excel .INC, R type 7)', 'exc' => 'Exclusive (Excel .EXC, Minitab, SPSS)', 'nearest' => 'Nearest rank']" selected="inc" />
    </div>

    <x-calc.result label="Median (5th decile)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '2, 4, 5, 7, 8, 10, 11, 13, 14, 16, 17, 19, 20, 22, 25', 'method' => 'inc'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'd1' => ['label' => 'D1 (10%)'],
            'd9' => ['label' => 'D9 (90%)'],
            'range' => ['label' => 'D9 − D1'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="All nine deciles" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
