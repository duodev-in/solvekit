<x-calc.page
    title="Inductors in Parallel Calculator - SolveKit"
    description="Free inductors in parallel calculator: total inductance of uncoupled parallel inductors."
    lede="Add inductors in parallel."
    about="Uncoupled inductors in parallel combine like resistors in parallel: 1/L = Σ1/Lᵢ."
    :calc="['engine' => 'ph-elec', 'tool' => 'inductors_parallel', 'fields' => ['list', 'unit'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 10, 22 and 47 mH in parallel?', 'answer' => '5.9977 mH.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="list" label="Values (comma or line separated; suffixes such as 4.7k, 100n allowed)" value="10, 22, 47" rows="3" />
        <x-calc.select name="unit" label="Plain numbers are in" :options="['nh' => 'nH', 'uh' => 'µH', 'mh' => 'mH', 'h' => 'H']" selected="mh" />
    </div>

    <x-calc.result label="Total inductance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '10, 22, 47', 'unit' => 'mh'],
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
