<x-calc.page
    title="Shockley Diode Calculator - SolveKit"
    description="Free Shockley diode equation calculator: diode current from saturation current, ideality factor and temperature."
    lede="Solve the diode equation."
    about="A diode’s current grows exponentially with forward voltage: I = I_s(e^(V/nV_T) − 1). About 60–90 mV more voltage multiplies the current tenfold."
    :calc="['engine' => 'ph-elec', 'tool' => 'shockley', 'fields' => ['Is', 'n', 'T', 'V', 'out'], 'unitFields' => ['Is' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'speed', 'temperature', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What current flows at 0.6 V in the example?', 'answer' => '13.8707 mA.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Is" label="Saturation current" value="0.001" placeholder="Saturation current">
            <label for="calc-Is-unit" class="sr-only">Saturation current unit</label>
            <select id="calc-Is-unit" name="Is-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'na')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="n" label="Ideality factor" value="1" min="1" step="any" />
        <x-calc.field name="T" label="Temperature" value="25" placeholder="Temperature">
            <label for="calc-T-unit" class="sr-only">Temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="V" label="Forward voltage" value="0.6" placeholder="Forward voltage">
            <label for="calc-V-unit" class="sr-only">Forward voltage unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['a' => 'A', 'ma' => 'mA', 'ua' => 'µA', 'na' => 'nA', 'ka' => 'kA']" selected="ma" />
    </div>

    <x-calc.result label="Diode current" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ma', 'Is' => 0.001, 'Is-unit' => 'na', 'n' => 1, 'T' => 25, 'T-unit' => 'c', 'V' => 0.6, 'V-unit' => 'v'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Current–voltage curve" name="iv" />
        <x-calc.rows heading="Details" :rows="[
            'VT' => ['label' => 'Thermal voltage kT/q'],
            'rd' => ['label' => 'Small-signal resistance'],
            'decade' => ['label' => 'Voltage per decade of current'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
