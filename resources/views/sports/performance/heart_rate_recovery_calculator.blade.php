<x-calc.page
    title="Heart Rate Recovery Calculator - SolveKit"
    description="Free heart rate recovery calculator: the drop in heart rate one and two minutes after exercise."
    lede="Find heart-rate recovery."
    about="How fast heart rate falls after exercise reflects fitness. A one-minute drop of 12 beats or less was linked to higher risk in a large study."
    :calc="['engine' => 'sp-fit', 'tool' => 'hr_recovery', 'fields' => ['peak', 'one', 'two'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the recovery from 170 to 145?', 'answer' => '25 bpm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="peak" label="Heart rate at the end of exercise" value="170" min="1" step="any" />
        <x-calc.field name="one" label="After 1 minute" value="145" min="1" step="any" />
        <x-calc.field name="two" label="After 2 minutes (optional)" value="125" min="1" step="any" />
    </div>

    <x-calc.result label="One-minute heart-rate recovery" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['peak' => 170, 'one' => 145, 'two' => 125],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'two' => ['label' => 'Two-minute recovery'],
            'note' => ['label' => 'What it suggests'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
