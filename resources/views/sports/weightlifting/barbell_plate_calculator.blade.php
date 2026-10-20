<x-calc.page
    title="Barbell Plate Calculator - SolveKit"
    description="Free barbell plate calculator: which plates to load on each side for a target weight."
    lede="Load the bar."
    about="Subtract the bar, halve the rest, and fill each side with the largest plates first."
    :calc="['engine' => 'sp-misc', 'tool' => 'plates', 'fields' => ['target', 'bar', 'set', 'unit'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How do you load 102.5 kg on a 20 kg bar?', 'answer' => '25 + 15 + 1.25 on each side.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="target" label="Target weight" value="102.5" min="0" step="any" />
        <x-calc.field name="bar" label="Bar weight" value="20" min="0" step="any" />
        <x-calc.field name="set" label="Plates you have (each size, comma separated)" value="25, 20, 15, 10, 5, 2.5, 1.25" type="text" inputmode="text" />
        <x-calc.select name="unit" label="Weights in" :options="['kg' => 'kg', 'lb' => 'lb']" selected="kg" />
    </div>

    <x-calc.result label="Plates on each side" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['target' => 102.5, 'bar' => 20, 'set' => '25, 20, 15, 10, 5, 2.5, 1.25', 'unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'loaded' => ['label' => 'Weight loaded'],
            'off' => ['label' => 'Difference from the target'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
