<x-calc.page
    title="AC Wattage Calculator - SolveKit"
    description="Free AC wattage calculator: real power from voltage, current and power factor, single or three phase."
    lede="Find real power in an AC circuit."
    about="In AC circuits only part of V × I does useful work: the real power is V I × power factor, with √3 for three-phase line values."
    :calc="['engine' => 'ph-em', 'tool' => 'ac_wattage', 'fields' => ['phase', 'V', 'I', 'pf', 'out'], 'unitFields' => ['V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'power', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What power does 230 V and 10 A at PF 0.9 deliver?', 'answer' => '2.07 kW.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="phase" label="Supply" :options="['single' => 'Single phase', 'three' => 'Three phase (line-to-line voltage)']" selected="single" />
        <x-calc.field name="V" label="Voltage" value="230" placeholder="Voltage">
            <label for="calc-V-unit" class="sr-only">Voltage unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="I" label="Current" value="10" placeholder="Current">
            <label for="calc-I-unit" class="sr-only">Current unit</label>
            <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="pf" label="Power factor" value="0.9" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="kw" />
    </div>

    <x-calc.result label="Real power" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kw', 'phase' => 'single', 'V' => 230, 'V-unit' => 'v', 'I' => 10, 'I-unit' => 'a', 'pf' => 0.9],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'S' => ['label' => 'Apparent power'],
            'Q' => ['label' => 'Reactive power'],
            'angle' => ['label' => 'Phase angle'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
