<x-calc.page
    title="Series Resistor Calculator - SolveKit"
    description="Free series resistor calculator: total resistance of resistors in series."
    lede="Add resistors in series."
    about="Resistors in series simply add: R = ΣRᵢ."
    :calc="['engine' => 'ph-elec', 'tool' => 'resistors_series', 'fields' => ['list', 'unit'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 100 + 220 + 4.7k?', 'answer' => '5.02 kΩ.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="list" label="Values (comma or line separated; suffixes such as 4.7k, 100n allowed)" value="100, 220, 4.7k" rows="3" />
        <x-calc.select name="unit" label="Plain numbers are in" :options="['ohm' => 'Ω', 'kohm' => 'kΩ', 'megohm' => 'MΩ']" selected="ohm" />
    </div>

    <x-calc.result label="Total resistance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '100, 220, 4.7k', 'unit' => 'ohm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'count' => ['label' => 'Number of components'],
            'range' => ['label' => 'Smallest and largest'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
