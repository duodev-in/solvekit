<x-calc.page
    title="Median Calculator - SolveKit"
    description="Free median calculator: the middle value of a data set, with the sorted data and its position."
    lede="Find the median."
    about="The median is the middle of the sorted data: half the values are below it and half above."
    :calc="['engine' => 'st-desc', 'tool' => 'median', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the median of 7, 1, 9, 4, 3, 8?', 'answer' => '5.5.'],
    ]"
>
    <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="7, 1, 9, 4, 3, 8" rows="3" />

    <x-calc.result label="Median" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '7, 1, 9, 4, 3, 8'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'n' => ['label' => 'Values'],
            'sorted' => ['label' => 'Sorted data'],
            'position' => ['label' => 'Position'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
