<x-calc.page
    title="Dot Plot Calculator - SolveKit"
    description="Free dot plot maker: a stacked dot plot of your data with the mode and range."
    lede="Draw a dot plot."
    about="A dot plot places one dot per value above a number line, stacking repeated values, so clusters and gaps are easy to see."
    :calc="['engine' => 'st-dist', 'tool' => 'dot_plot', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the mode of the example data?', 'answer' => '5.'],
    ]"
>
    <x-calc.textarea name="data" label="Data" value="3, 4, 4, 5, 5, 5, 6, 6, 7, 8, 8, 10" rows="3" />

    <x-calc.result label="Mode" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '3, 4, 4, 5, 5, 5, 6, 6, 7, 8, 8, 10'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Dot plot" name="dots" />
        <x-calc.rows heading="Details" :rows="[
            'n' => ['label' => 'Values'],
            'range' => ['label' => 'Range'],
            'median' => ['label' => 'Median'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
