<x-calc.page
    title="RF Unit Converter - SolveKit"
    description="Free RF unit converter: dBm, dBW, watts, milliwatts, volts and dBµV for any impedance."
    lede="Convert RF power units."
    about="Radio engineers measure power in decibels relative to 1 mW (dBm); voltage depends on the impedance."
    :calc="['engine' => 'tc-elec', 'tool' => 'rf_unit', 'fields' => ['value', 'unit', 'z'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many watts is 10 dBm?', 'answer' => '0.01 W.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Value" value="10" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['dbm' => 'dBm', 'dbw' => 'dBW', 'w' => 'W', 'mw' => 'mW', 'uw' => 'µW', 'dbuv' => 'dBµV (voltage)', 'v' => 'V (RMS)', 'mv' => 'mV (RMS)']" selected="dbm" />
        <x-calc.field name="z" label="Impedance (Ω)" value="50" min="0" step="any" />
    </div>

    <x-calc.result label="Power" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => 10, 'unit' => 'dbm', 'z' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'dbm' => ['label' => 'dBm'],
            'dbw' => ['label' => 'dBW'],
            'w' => ['label' => 'Watts'],
            'mw' => ['label' => 'Milliwatts'],
            'v' => ['label' => 'Voltage (RMS)'],
            'dbuv' => ['label' => 'dBµV'],
            'vpp' => ['label' => 'Peak-to-peak (sine)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
