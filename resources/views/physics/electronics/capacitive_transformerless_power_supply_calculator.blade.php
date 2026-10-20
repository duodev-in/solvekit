<x-calc.page
    title="Capacitive Transformerless Power Supply Calculator - SolveKit"
    description="Free capacitive dropper calculator: X2 capacitor value for a transformerless mains power supply."
    lede="Size a capacitive dropper."
    about="A series capacitor drops mains voltage through its reactance instead of a transformer. It is cheap but not isolated, so it is only safe inside closed products."
    :calc="['engine' => 'ph-elec', 'tool' => 'cap_dropper', 'fields' => ['Vac', 'f', 'Vout', 'I', 'out'], 'unitFields' => ['Vac' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'Vout' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all()], 'data' => ['units' => collect(config('units'))->only(['capacitance', 'current', 'energy', 'force', 'frequency_hz', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What capacitor gives 20 mA at 12 V from 230 V?', 'answer' => '0.292027 µF.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Vac" label="Mains voltage (RMS)" value="230" placeholder="Mains voltage (RMS)">
            <label for="calc-Vac-unit" class="sr-only">Mains voltage (RMS) unit</label>
            <select id="calc-Vac-unit" name="Vac-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="f" label="Frequency" value="50" min="0" placeholder="Frequency">
            <label for="calc-f-unit" class="sr-only">Frequency unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Vout" label="Output (Zener) voltage" value="12" placeholder="Output (Zener) voltage">
            <label for="calc-Vout-unit" class="sr-only">Output (Zener) voltage unit</label>
            <select id="calc-Vout-unit" name="Vout-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="I" label="Load current" value="20" placeholder="Load current">
            <label for="calc-I-unit" class="sr-only">Load current unit</label>
            <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ma')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['f' => 'F', 'mf' => 'mF', 'uf' => 'µF', 'nf' => 'nF', 'pf' => 'pF']" selected="uf" />
    </div>

    <x-calc.result label="Dropping capacitor" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'uf', 'Vac' => 230, 'Vac-unit' => 'v', 'f' => 50, 'f-unit' => 'hz', 'Vout' => 12, 'Vout-unit' => 'v', 'I' => 20, 'I-unit' => 'ma'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'X' => ['label' => 'Reactance'],
            'rating' => ['label' => 'Capacitor rating'],
            'bleed' => ['label' => 'Bleeder resistor'],
            'warn' => ['label' => 'Safety'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
