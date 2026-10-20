<x-calc.page
    title="Heptathlon Calculator - SolveKit"
    description="Free heptathlon calculator: points for each event and the total from World Athletics scoring tables."
    lede="Score a heptathlon."
    about="Each heptathlon event converts to points with the World Athletics formula; the seven scores add up."
    :calc="['engine' => 'sp-misc', 'tool' => 'heptathlon', 'fields' => ['100mh', 'hj', 'sp', '200m', 'lj', 'jt', '800m'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all(), 'sports' => collect(config('sports_data'))->only(['combined_events'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does the example series score?', 'answer' => '6,426 points.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="100mh" label="100 m hurdles (s)" value="13.50" type="text" inputmode="text" />
        <x-calc.field name="hj" label="High jump (m)" value="1.80" type="text" inputmode="text" />
        <x-calc.field name="sp" label="Shot put (m)" value="14.00" type="text" inputmode="text" />
        <x-calc.field name="200m" label="200 m (s)" value="24.20" type="text" inputmode="text" />
        <x-calc.field name="lj" label="Long jump (m)" value="6.30" type="text" inputmode="text" />
        <x-calc.field name="jt" label="Javelin (m)" value="45.00" type="text" inputmode="text" />
        <x-calc.field name="800m" label="800 m (m:ss.ss)" value="2:12.00" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Total points" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['100mh' => '13.50', 'hj' => '1.80', 'sp' => '14.00', '200m' => '24.20', 'lj' => '6.30', 'jt' => '45.00', '800m' => '2:12.00'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'avg' => ['label' => 'Average per event'],
            'counted' => ['label' => 'Events entered'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Points per event" name="events" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
