<x-calc.page
    title="Relative Standard Deviation Calculator - SolveKit"
    description="Free relative standard deviation calculator: RSD (%RSD) of repeated measurements."
    lede="Find the relative standard deviation."
    about="The relative standard deviation expresses the SD as a percentage of the mean; laboratories use it to report precision."
    :calc="['engine' => 'st-desc', 'tool' => 'rsd', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the RSD of the example?', 'answer' => '0.643314%.'],
    ]"
>
    <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="98.2, 99.1, 97.8, 98.6, 99.4, 98.0" rows="3" />

    <x-calc.result label="Relative standard deviation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '98.2, 99.1, 97.8, 98.6, 99.4, 98.0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mean' => ['label' => 'Mean'],
            'sd' => ['label' => 'Standard deviation (sample)'],
            'pop' => ['label' => 'RSD with the population SD'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
