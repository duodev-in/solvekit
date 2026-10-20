<x-calc.page
    title="Heart Rate Calculator - SolveKit"
    description="Free heart rate calculator: beats per minute from beats counted over a few seconds."
    lede="Find your heart rate."
    about="Count beats for 15 or 30 seconds and scale to a minute."
    :calc="['engine' => 'sp-fit', 'tool' => 'heart_rate', 'fields' => ['beats', 'sec', 'age'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 18 beats in 15 seconds?', 'answer' => '72 bpm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="beats" label="Beats counted" value="18" min="1" step="any" />
        <x-calc.select name="sec" label="Counted for" :options="['10' => '10 seconds', '15' => '15 seconds', '20' => '20 seconds', '30' => '30 seconds', '60' => '60 seconds']" selected="15" />
        <x-calc.field name="age" label="Age (for the resting range)" value="35" min="1" step="any" />
    </div>

    <x-calc.result label="Heart rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['beats' => 18, 'sec' => '15', 'age' => 35],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'range' => ['label' => 'Resting range for adults'],
            'note' => ['label' => 'Tip'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
