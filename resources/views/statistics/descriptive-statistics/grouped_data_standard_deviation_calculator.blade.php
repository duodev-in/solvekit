<x-calc.page
    title="Grouped Data Standard Deviation Calculator - SolveKit"
    description="Free grouped data standard deviation calculator: mean, variance and SD from a frequency table of classes."
    lede="Find the SD of grouped data."
    about="For grouped data each class is represented by its midpoint, weighted by its frequency."
    :calc="['engine' => 'st-desc', 'tool' => 'grouped_sd', 'fields' => ['data', 'kind'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the SD of the example table?', 'answer' => '11.515739.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Classes: lower − upper, frequency (or midpoint, frequency)" value="10-20, 5
20-30, 12
30-40, 18
40-50, 9
50-60, 6" rows="5" />
        <x-calc.select name="kind" label="Data are a" :options="['sample' => 'Sample (divide by n − 1)', 'population' => 'Population (divide by N)']" selected="sample" />
    </div>

    <x-calc.result label="Standard deviation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '10-20, 5
20-30, 12
30-40, 18
40-50, 9
50-60, 6', 'kind' => 'sample'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mean' => ['label' => 'Grouped mean'],
            'variance' => ['label' => 'Variance'],
            'n' => ['label' => 'Total frequency'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Working table" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
