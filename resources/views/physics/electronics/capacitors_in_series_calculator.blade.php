<x-calc.page
    title="Capacitors in Series Calculator - SolveKit"
    description="Free capacitors in series calculator: total capacitance of any number of series capacitors."
    lede="Add capacitors in series."
    about="In series, capacitances combine like resistors in parallel: 1/C = Σ1/Cᵢ. The total is smaller than the smallest."
    :calc="['engine' => 'ph-elec', 'tool' => 'caps_series', 'fields' => ['list', 'unit'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 10, 22 and 47 µF in series?', 'answer' => '5.9977 µF.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="list" label="Values (comma or line separated; suffixes such as 4.7k, 100n allowed)" value="10, 22, 47" rows="3" />
        <x-calc.select name="unit" label="Plain numbers are in" :options="['pf' => 'pF', 'nf' => 'nF', 'uf' => 'µF', 'mf' => 'mF', 'f' => 'F']" selected="uf" />
    </div>

    <x-calc.result label="Total capacitance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '10, 22, 47', 'unit' => 'uf'],
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
