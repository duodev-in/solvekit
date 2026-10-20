<x-calc.page
    title="Insertion Loss Calculator - SolveKit"
    description="Free insertion loss calculator: loss in dB from power or voltage with and without a device."
    lede="Find insertion loss."
    about="Insertion loss is how much signal a filter, cable or connector removes, in decibels."
    :calc="['engine' => 'ph-em', 'tool' => 'insertion_loss', 'fields' => ['kind', 'without', 'with'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the loss from 10 W to 8 W?', 'answer' => '0.9691 dB.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="kind" label="Measured" :options="['power' => 'Power', 'voltage' => 'Voltage (same impedance)', 'dbm' => 'Levels in dBm']" selected="power" />
        <x-calc.field name="without" label="Without the device" value="10" min="0" step="any" />
        <x-calc.field name="with" label="With the device" value="8" min="0" step="any" />
    </div>

    <x-calc.result label="Insertion loss" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['kind' => 'power', 'without' => 10, 'with' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pass' => ['label' => 'Power passed'],
            'lost' => ['label' => 'Power lost'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
