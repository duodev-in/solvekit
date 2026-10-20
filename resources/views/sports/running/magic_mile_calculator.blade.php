<x-calc.page
    title="Magic Mile Calculator - SolveKit"
    description="Free Magic Mile calculator: race paces from a one-mile time trial (Galloway)."
    lede="Set race paces from a Magic Mile."
    about="Jeff Galloway’s Magic Mile turns one hard mile into realistic race paces with fixed multipliers."
    :calc="['engine' => 'sp-run', 'tool' => 'magic_mile', 'fields' => ['mile'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What marathon pace does an 8:00 mile suggest?', 'answer' => '10:24 /mi (6:28 /km).'],
    ]"
>
    <x-calc.field name="mile" label="Magic mile time (m:ss)" value="8:00" type="text" inputmode="text" />

    <x-calc.result label="Marathon goal pace" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mile' => '8:00'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'k5' => ['label' => '5 km race pace'],
            'k10' => ['label' => '10 km race pace'],
            'half' => ['label' => 'Half marathon pace'],
            'mar' => ['label' => 'Marathon pace'],
            'long' => ['label' => 'Long-run pace (marathon pace + 2 min)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
