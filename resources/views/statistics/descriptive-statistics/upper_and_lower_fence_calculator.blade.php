<x-calc.page
    title="Upper and Lower Fence Calculator - SolveKit"
    description="Free upper and lower fence calculator: Tukey fences from data or quartiles, with the outliers beyond them."
    lede="Find the outlier fences."
    about="Tukey’s fences sit 1.5 IQR below Q1 and above Q3; values beyond them are flagged as outliers. Also known as Lower Fence Calculator and Upper Fence Calculator."
    :calc="['engine' => 'st-desc', 'tool' => 'fences', 'fields' => ['mode', 'data', 'q1', 'q3', 'k', 'method'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What are the fences for the example?', 'answer' => '9.375 and 24.375.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="From" :options="['data' => 'Data', 'quartiles' => 'Q1 and Q3']" selected="data" />
        <div data-show-when="mode:data">
            <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="12, 14, 15, 15, 16, 17, 18, 19, 21, 45" rows="3" />
        </div>
        <div data-show-when="mode:quartiles">
            <x-calc.field name="q1" label="Q1" value="15" step="any" />
        </div>
        <div data-show-when="mode:quartiles">
            <x-calc.field name="q3" label="Q3" value="19" step="any" />
        </div>
        <x-calc.field name="k" label="Multiplier (1.5 = outliers, 3 = extreme)" value="1.5" min="0" step="any" />
        <div data-show-when="mode:data">
            <x-calc.select name="method" label="Quartile method" :options="['inc' => 'Inclusive (Excel .INC, R type 7)', 'exc' => 'Exclusive (Excel .EXC, Minitab, SPSS)', 'halves' => 'Median of halves (TI-84, textbooks)', 'tukey' => 'Tukey hinges', 'nearest' => 'Nearest rank']" selected="inc" />
        </div>
    </div>

    <x-calc.result label="Lower and upper fence" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'data', 'data' => '12, 14, 15, 15, 16, 17, 18, 19, 21, 45', 'q1' => 15, 'q3' => 19, 'k' => 1.5, 'method' => 'inc'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'lower' => ['label' => 'Lower fence'],
            'upper' => ['label' => 'Upper fence'],
            'iqr' => ['label' => 'IQR'],
            'outliers' => ['label' => 'Values outside'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
