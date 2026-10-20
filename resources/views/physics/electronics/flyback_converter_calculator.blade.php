<x-calc.page
    title="Flyback Converter Calculator - SolveKit"
    description="Free flyback converter calculator: turns ratio, magnetising inductance and peak current."
    lede="Start a flyback design."
    about="A flyback stores energy in a coupled inductor while the switch is on and delivers it to the output when it turns off. It provides isolation with a single magnetic part."
    :calc="['engine' => 'ph-elec', 'tool' => 'flyback', 'fields' => ['Vin', 'Vout', 'Vf', 'P', 'fs', 'Dmax', 'eff'], 'unitFields' => ['Vin' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'Vout' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'Vf' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'fs' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'power', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What turns ratio suits 100 V in, 12 V out at 45% duty?', 'answer' => '6.545 : 1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Vin" label="Minimum input voltage" value="100" placeholder="Minimum input voltage">
            <label for="calc-Vin-unit" class="sr-only">Minimum input voltage unit</label>
            <select id="calc-Vin-unit" name="Vin-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Vout" label="Output voltage" value="12" placeholder="Output voltage">
            <label for="calc-Vout-unit" class="sr-only">Output voltage unit</label>
            <select id="calc-Vout-unit" name="Vout-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Vf" label="Output diode drop" value="0.5" placeholder="Output diode drop">
            <label for="calc-Vf-unit" class="sr-only">Output diode drop unit</label>
            <select id="calc-Vf-unit" name="Vf-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="P" label="Output power" value="24" min="0" placeholder="Output power">
            <label for="calc-P-unit" class="sr-only">Output power unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="fs" label="Switching frequency" value="100" min="0" placeholder="Switching frequency">
            <label for="calc-fs-unit" class="sr-only">Switching frequency unit</label>
            <select id="calc-fs-unit" name="fs-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'khz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Dmax" label="Maximum duty cycle (%)" value="45" min="0" step="any" />
        <x-calc.field name="eff" label="Efficiency (%)" value="85" min="0" step="any" />
    </div>

    <x-calc.result label="Turns ratio Np : Ns" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['Vin' => 100, 'Vin-unit' => 'v', 'Vout' => 12, 'Vout-unit' => 'v', 'Vf' => 0.5, 'Vf-unit' => 'v', 'P' => 24, 'P-unit' => 'w', 'fs' => 100, 'fs-unit' => 'khz', 'Dmax' => 45, 'eff' => 85],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'D' => ['label' => 'Duty cycle at minimum input'],
            'Lm' => ['label' => 'Magnetising inductance (boundary mode)'],
            'Ipk' => ['label' => 'Peak primary current'],
            'Vds' => ['label' => 'Switch voltage (before spike)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
