<x-calc.page
    title="Range Calculator - SolveKit"
    description="Free range calculator: maximum minus minimum of a data set."
    lede="Find the range."
    about="The range is the simplest measure of spread: the largest value minus the smallest."
    :calc="['engine' => 'st-desc', 'tool' => 'range', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the range of the example?', 'answer' => '34.'],
    ]"
>
    <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="23, 7, 41, 15, 9, 33" rows="3" />

    <x-calc.result label="Range" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '23, 7, 41, 15, 9, 33'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'min' => ['label' => 'Minimum'],
            'max' => ['label' => 'Maximum'],
            'iqr' => ['label' => 'IQR (for comparison)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
