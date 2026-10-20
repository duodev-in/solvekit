<x-calc.page
    title="Mean Median Mode Calculator - SolveKit"
    description="Free mean, median and mode calculator: all three averages, the range and the sorted data."
    lede="Find the mean, median and mode."
    about="The mean adds and divides, the median is the middle value and the mode is the most frequent value."
    :calc="['engine' => 'st-desc', 'tool' => 'mean_median_mode', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What are the mean, median and mode of the example?', 'answer' => '6.3, 6.5 and 8 (3 times).'],
    ]"
>
    <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="4, 8, 6, 5, 3, 8, 9, 5, 8, 7" rows="3" />

    <x-calc.result label="Mean" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '4, 8, 6, 5, 3, 8, 9, 5, 8, 7'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'median' => ['label' => 'Median'],
            'mode' => ['label' => 'Mode'],
            'range' => ['label' => 'Range'],
            'sorted' => ['label' => 'Sorted data'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
