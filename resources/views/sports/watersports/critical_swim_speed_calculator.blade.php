<x-calc.page
    title="Critical Swim Speed Calculator - SolveKit"
    description="Free CSS calculator: critical swim speed and training paces from 400 m and 200 m times."
    lede="Find your critical swim speed."
    about="Critical swim speed is your threshold pace in the pool, found from a 400 m and a 200 m time trial."
    :calc="['engine' => 'sp-misc', 'tool' => 'css', 'fields' => ['t400', 't200'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What CSS do 7:00 and 3:20 give?', 'answer' => '1:50 /100 m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="t400" label="400 m time (m:ss)" value="7:00" type="text" inputmode="text" />
        <x-calc.field name="t200" label="200 m time (m:ss)" value="3:20" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Critical swim speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['t400' => '7:00', 't200' => '3:20'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'speed' => ['label' => 'Speed'],
            'paces' => ['label' => 'Training paces per 100 m'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
