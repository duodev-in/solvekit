<x-calc.page
    title="Midrange Calculator - SolveKit"
    description="Free midrange calculator: the value halfway between the minimum and maximum."
    lede="Find the midrange."
    about="The midrange is the average of the smallest and largest values."
    :calc="['engine' => 'st-desc', 'tool' => 'midrange', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the midrange of the example?', 'answer' => '11.'],
    ]"
>
    <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="12, 5, 19, 8, 3, 15" rows="3" />

    <x-calc.result label="Midrange" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '12, 5, 19, 8, 3, 15'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'min' => ['label' => 'Minimum'],
            'max' => ['label' => 'Maximum'],
            'mean' => ['label' => 'Mean for comparison'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
