<x-calc.page
    title="Relative Frequency Calculator - SolveKit"
    description="Free relative frequency calculator: counts, relative and cumulative relative frequencies for numbers or categories."
    lede="Find relative frequencies."
    about="Relative frequency is each value’s count divided by the total, so the shares add up to 1."
    :calc="['engine' => 'st-dist', 'tool' => 'rel_freq', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'Which colour is most frequent in the example?', 'answer' => 'red (40%).'],
    ]"
>
    <x-calc.textarea name="data" label="Data (numbers or words)" value="red, blue, red, green, blue, red, yellow, blue, red, green" rows="3" />

    <x-calc.result label="Categories" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => 'red, blue, red, green, blue, red, yellow, blue, red, green'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Relative frequency" name="bars" />
        <x-calc.rows heading="Details" :rows="[
            'n' => ['label' => 'Observations'],
            'top' => ['label' => 'Most frequent'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Frequency table" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
