<x-calc.page
    title="Buck Converter Calculator - SolveKit"
    description="Free buck converter calculator: duty cycle, inductor and capacitor for a step-down DC–DC converter."
    lede="Design a buck converter."
    about="A buck converter chops the input and filters it with an inductor and capacitor. In continuous mode D = V_out/V_in."
    :calc="['engine' => 'ph-elec', 'tool' => 'buck', 'fields' => ['Vin', 'Vout', 'Iout', 'fs', 'ripple', 'dv', 'eff'], 'unitFields' => ['Vin' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'Vout' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'Iout' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'fs' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'dv' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'frequency_hz', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What duty cycle drops 12 V to 5 V?', 'answer' => '46.3%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Vin" label="Input voltage" value="12" placeholder="Input voltage">
            <label for="calc-Vin-unit" class="sr-only">Input voltage unit</label>
            <select id="calc-Vin-unit" name="Vin-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Vout" label="Output voltage (magnitude)" value="5" placeholder="Output voltage (magnitude)">
            <label for="calc-Vout-unit" class="sr-only">Output voltage (magnitude) unit</label>
            <select id="calc-Vout-unit" name="Vout-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Iout" label="Output current" value="2" placeholder="Output current">
            <label for="calc-Iout-unit" class="sr-only">Output current unit</label>
            <select id="calc-Iout-unit" name="Iout-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="fs" label="Switching frequency" value="500" min="0" placeholder="Switching frequency">
            <label for="calc-fs-unit" class="sr-only">Switching frequency unit</label>
            <select id="calc-fs-unit" name="fs-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'khz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ripple" label="Inductor ripple (% of inductor current)" value="30" min="0" step="any" />
        <x-calc.field name="dv" label="Output voltage ripple" value="20" placeholder="Output voltage ripple">
            <label for="calc-dv-unit" class="sr-only">Output voltage ripple unit</label>
            <select id="calc-dv-unit" name="dv-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mv')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="eff" label="Efficiency (%)" value="90" min="0" step="any" />
    </div>

    <x-calc.result label="Duty cycle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['Vin' => 12, 'Vin-unit' => 'v', 'Vout' => 5, 'Vout-unit' => 'v', 'Iout' => 2, 'Iout-unit' => 'a', 'fs' => 500, 'fs-unit' => 'khz', 'ripple' => 30, 'dv' => 20, 'dv-unit' => 'mv', 'eff' => 90],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'D' => ['label' => 'Duty cycle'],
            'L' => ['label' => 'Minimum inductance'],
            'C' => ['label' => 'Minimum output capacitance'],
            'Ipk' => ['label' => 'Peak inductor current'],
            'IL' => ['label' => 'Average inductor current'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
