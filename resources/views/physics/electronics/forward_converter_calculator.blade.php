<x-calc.page
    title="Forward Converter Calculator - SolveKit"
    description="Free forward converter calculator: duty cycle and output inductor of a single-switch forward converter."
    lede="Design a forward converter."
    about="A forward converter transfers energy through the transformer while the switch is on, like an isolated buck. The core must reset each cycle, which limits the duty cycle."
    :calc="['engine' => 'ph-elec', 'tool' => 'forward', 'fields' => ['Vin', 'Vout', 'n', 'Iout', 'fs', 'ripple'], 'unitFields' => ['Vin' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'Vout' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'Iout' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'fs' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'frequency_hz', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What duty cycle gives 5 V from 48 V with a 4:1 transformer?', 'answer' => '41.67%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Vin" label="Input voltage" value="48" placeholder="Input voltage">
            <label for="calc-Vin-unit" class="sr-only">Input voltage unit</label>
            <select id="calc-Vin-unit" name="Vin-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Vout" label="Output voltage" value="5" placeholder="Output voltage">
            <label for="calc-Vout-unit" class="sr-only">Output voltage unit</label>
            <select id="calc-Vout-unit" name="Vout-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="n" label="Turns ratio Np : Ns" value="4" min="0" step="any" />
        <x-calc.field name="Iout" label="Output current" value="5" placeholder="Output current">
            <label for="calc-Iout-unit" class="sr-only">Output current unit</label>
            <select id="calc-Iout-unit" name="Iout-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="fs" label="Switching frequency" value="200" min="0" placeholder="Switching frequency">
            <label for="calc-fs-unit" class="sr-only">Switching frequency unit</label>
            <select id="calc-fs-unit" name="fs-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'khz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ripple" label="Inductor ripple (%)" value="30" min="0" step="any" />
    </div>

    <x-calc.result label="Duty cycle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['Vin' => 48, 'Vin-unit' => 'v', 'Vout' => 5, 'Vout-unit' => 'v', 'n' => 4, 'Iout' => 5, 'Iout-unit' => 'a', 'fs' => 200, 'fs-unit' => 'khz', 'ripple' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'L' => ['label' => 'Output inductor'],
            'Vs' => ['label' => 'Secondary peak voltage'],
            'check' => ['label' => 'Reset check (1:1 reset winding)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
