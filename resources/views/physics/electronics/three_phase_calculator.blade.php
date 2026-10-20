<x-calc.page
    title="Three Phase Calculator - SolveKit"
    description="Free three-phase calculator: kW, kVA, kVAR and phase values for star and delta loads."
    lede="Analyse a three-phase load."
    about="Three-phase power is √3 × line voltage × line current × power factor. Star and delta connections differ in their phase voltages and currents."
    :calc="['engine' => 'ph-elec', 'tool' => 'three_phase', 'fields' => ['VL', 'IL', 'pf', 'conn', 'out'], 'unitFields' => ['VL' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'IL' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'power', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What power does 400 V, 20 A at PF 0.85 deliver?', 'answer' => '11.7779 kW.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="VL" label="Line voltage" value="400" placeholder="Line voltage">
            <label for="calc-VL-unit" class="sr-only">Line voltage unit</label>
            <select id="calc-VL-unit" name="VL-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="IL" label="Line current" value="20" placeholder="Line current">
            <label for="calc-IL-unit" class="sr-only">Line current unit</label>
            <select id="calc-IL-unit" name="IL-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="pf" label="Power factor" value="0.85" min="0" step="any" />
        <x-calc.select name="conn" label="Load connection" :options="['star' => 'Star (wye)', 'delta' => 'Delta']" selected="star" />
        <x-calc.select name="out" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="kw" />
    </div>

    <x-calc.result label="Real power" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kw', 'VL' => 400, 'VL-unit' => 'v', 'IL' => 20, 'IL-unit' => 'a', 'pf' => 0.85, 'conn' => 'star'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'S' => ['label' => 'Apparent power'],
            'Q' => ['label' => 'Reactive power'],
            'Vp' => ['label' => 'Phase voltage'],
            'Ip' => ['label' => 'Phase current'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
