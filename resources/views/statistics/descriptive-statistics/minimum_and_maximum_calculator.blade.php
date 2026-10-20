<x-calc.page
    title="Minimum and Maximum Calculator - SolveKit"
    description="Free minimum and maximum calculator: the smallest and largest values of a data set, with positions and range."
    lede="Find the minimum and maximum."
    about="The minimum and maximum are the extremes of a data set; their difference is the range."
    :calc="['engine' => 'st-desc', 'tool' => 'minmax', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What are the extremes of the example?', 'answer' => '−3 and 27.'],
    ]"
>
    <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="14, -3, 27, 8, 27, 0.5, 11" rows="3" />

    <x-calc.result label="Minimum and maximum" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '14, -3, 27, 8, 27, 0.5, 11'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'min' => ['label' => 'Minimum'],
            'max' => ['label' => 'Maximum'],
            'range' => ['label' => 'Range'],
            'where' => ['label' => 'Positions (1 = first)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
