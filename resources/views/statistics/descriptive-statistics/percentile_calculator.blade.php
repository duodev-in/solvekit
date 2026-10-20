<x-calc.page
    title="Percentile Calculator - SolveKit"
    description="Free percentile calculator: the value at any percentile of a data set, by the inclusive, exclusive or nearest-rank method."
    lede="Find a percentile."
    about="The p-th percentile is the value below which p% of the data fall. Methods differ slightly for small samples."
    :calc="['engine' => 'st-desc', 'tool' => 'percentile', 'fields' => ['data', 'p', 'method'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the 90th percentile of the example?', 'answer' => '81.5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="15, 20, 35, 40, 50, 55, 60, 70, 80, 95" rows="3" />
        <x-calc.field name="p" label="Percentile (0–100)" value="90" min="0" step="any" />
        <x-calc.select name="method" label="Method" :options="['inc' => 'Inclusive (Excel .INC, R type 7)', 'exc' => 'Exclusive (Excel .EXC, Minitab, SPSS)', 'nearest' => 'Nearest rank']" selected="inc" />
    </div>

    <x-calc.result label="Value at the percentile" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '15, 20, 35, 40, 50, 55, 60, 70, 80, 95', 'p' => 90, 'method' => 'inc'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'position' => ['label' => 'Position'],
            'others' => ['label' => 'Other methods'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
