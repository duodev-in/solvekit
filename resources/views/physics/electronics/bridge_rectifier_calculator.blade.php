<x-calc.page
    title="Bridge Rectifier Calculator - SolveKit"
    description="Free bridge rectifier calculator: DC output voltage, ripple and diode PIV with a smoothing capacitor."
    lede="Design a rectifier and smoothing capacitor."
    about="A bridge rectifier flips negative half-cycles; a capacitor holds the peaks. Ripple is roughly I/(2fC) for full-wave rectification."
    :calc="['engine' => 'ph-elec', 'tool' => 'bridge_rectifier', 'fields' => ['Vac', 'f', 'Vf', 'I', 'C', 'out'], 'unitFields' => ['Vac' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'Vf' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'C' => collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf'])->all()], 'data' => ['units' => collect(config('units'))->only(['capacitance', 'current', 'energy', 'force', 'frequency_hz', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does a 12 V transformer give with 4,700 µF at 1 A?', 'answer' => 'About 14.5067 V DC.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Vac" label="Transformer secondary (RMS)" value="12" placeholder="Transformer secondary (RMS)">
            <label for="calc-Vac-unit" class="sr-only">Transformer secondary (RMS) unit</label>
            <select id="calc-Vac-unit" name="Vac-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="f" label="Mains frequency" value="50" min="0" placeholder="Mains frequency">
            <label for="calc-f-unit" class="sr-only">Mains frequency unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Vf" label="Diode forward drop (each)" value="0.7" placeholder="Diode forward drop (each)">
            <label for="calc-Vf-unit" class="sr-only">Diode forward drop (each) unit</label>
            <select id="calc-Vf-unit" name="Vf-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="I" label="Load current" value="1" placeholder="Load current">
            <label for="calc-I-unit" class="sr-only">Load current unit</label>
            <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="C" label="Smoothing capacitor" value="4700" min="0" placeholder="Smoothing capacitor">
            <label for="calc-C-unit" class="sr-only">Smoothing capacitor unit</label>
            <select id="calc-C-unit" name="C-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'uf')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="v" />
    </div>

    <x-calc.result label="Average DC output" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'v', 'Vac' => 12, 'Vac-unit' => 'v', 'f' => 50, 'f-unit' => 'hz', 'Vf' => 0.7, 'Vf-unit' => 'v', 'I' => 1, 'I-unit' => 'a', 'C' => 4700, 'C-unit' => 'uf'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Output voltage (two cycles)" name="wave" />
        <x-calc.rows heading="Details" :rows="[
            'pk' => ['label' => 'Peak output'],
            'ripple' => ['label' => 'Ripple (peak to peak)'],
            'piv' => ['label' => 'Diode reverse voltage (PIV)'],
            'Cfor' => ['label' => 'Capacitor for 1 V ripple'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
