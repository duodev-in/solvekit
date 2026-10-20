<x-calc.page
    title="Decathlon Calculator - SolveKit"
    description="Free decathlon calculator: points per event and total from World Athletics scoring tables."
    lede="Score a decathlon."
    about="The decathlon’s ten events each convert to points with the World Athletics formula."
    :calc="['engine' => 'sp-misc', 'tool' => 'decathlon', 'fields' => ['100m', 'lj', 'sp', 'hj', '400m', '110mh', 'dt', 'pv', 'jt', '1500m'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all(), 'sports' => collect(config('sports_data'))->only(['combined_events'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does the example series score?', 'answer' => '8,239 points.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="100m" label="100 m (s)" value="10.90" type="text" inputmode="text" />
        <x-calc.field name="lj" label="Long jump (m)" value="7.40" type="text" inputmode="text" />
        <x-calc.field name="sp" label="Shot put (m)" value="14.50" type="text" inputmode="text" />
        <x-calc.field name="hj" label="High jump (m)" value="2.00" type="text" inputmode="text" />
        <x-calc.field name="400m" label="400 m (s)" value="49.00" type="text" inputmode="text" />
        <x-calc.field name="110mh" label="110 m hurdles (s)" value="14.40" type="text" inputmode="text" />
        <x-calc.field name="dt" label="Discus (m)" value="45.00" type="text" inputmode="text" />
        <x-calc.field name="pv" label="Pole vault (m)" value="4.80" type="text" inputmode="text" />
        <x-calc.field name="jt" label="Javelin (m)" value="60.00" type="text" inputmode="text" />
        <x-calc.field name="1500m" label="1500 m (m:ss.ss)" value="4:30.00" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Total points" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['100m' => '10.90', 'lj' => '7.40', 'sp' => '14.50', 'hj' => '2.00', '400m' => '49.00', '110mh' => '14.40', 'dt' => '45.00', 'pv' => '4.80', 'jt' => '60.00', '1500m' => '4:30.00'],
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
