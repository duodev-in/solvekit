<x-calc.page
    title="Capacitor Code Calculator - SolveKit"
    description="Free capacitor code calculator: decode 3-digit EIA codes and RKM markings like 104, 4n7 and 2.2u."
    lede="Decode capacitor markings."
    about="Small capacitors are marked with three digits (two figures and a number of zeros, in pF) and a tolerance letter, or with RKM codes where the unit letter marks the decimal point."
    :calc="['engine' => 'ph-elec', 'tool' => 'capacitor_code', 'fields' => ['code', 'out'], 'data' => ['units' => collect(config('units'))->only(['capacitance', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 104K?', 'answer' => '100 nF, 100 nF, ±10%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="code" label="Marking (e.g. 104, 472J, 4n7, 2.2u)" value="104K" type="text" inputmode="text" />
        <x-calc.select name="out" label="Show the result in" :options="['f' => 'F', 'mf' => 'mF', 'uf' => 'µF', 'nf' => 'nF', 'pf' => 'pF']" selected="nf" />
    </div>

    <x-calc.result label="Capacitance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'nf', 'code' => '104K'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pf' => ['label' => 'In pF'],
            'uf' => ['label' => 'In µF'],
            'tol' => ['label' => 'Tolerance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
