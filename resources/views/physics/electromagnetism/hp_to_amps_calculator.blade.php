<x-calc.page
    title="hp to amps Calculator - SolveKit"
    description="Free hp to amps calculator: motor full-load current from horsepower, voltage, phase, efficiency and power factor."
    lede="Convert horsepower to amps."
    about="Input current is the output power divided by voltage, efficiency and power factor (and √3 for three phase). Nameplate or code tables should be used for wiring."
    :calc="['engine' => 'ph-em', 'tool' => 'hp_amps', 'fields' => ['hp', 'V', 'phase', 'eff', 'pf', 'out'], 'unitFields' => ['hp' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'power', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What current does a 10 hp, 460 V three-phase motor draw?', 'answer' => 'About 12.2344 A.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hp" label="Motor power" value="10" min="0" placeholder="Motor power">
            <label for="calc-hp-unit" class="sr-only">Motor power unit</label>
            <select id="calc-hp-unit" name="hp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hp')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="V" label="Voltage" value="460" placeholder="Voltage">
            <label for="calc-V-unit" class="sr-only">Voltage unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="phase" label="Supply" :options="['dc' => 'DC', 'single' => 'AC single phase', 'three' => 'AC three phase (line-to-line voltage)']" selected="three" />
        <x-calc.field name="eff" label="Efficiency (%)" value="90" min="0" step="any" />
        <x-calc.field name="pf" label="Power factor" value="0.85" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['a' => 'A', 'ma' => 'mA', 'ua' => 'µA', 'na' => 'nA', 'ka' => 'kA']" selected="a" />
    </div>

    <x-calc.result label="Full-load current" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'a', 'hp' => 10, 'hp-unit' => 'hp', 'V' => 460, 'V-unit' => 'v', 'phase' => 'three', 'eff' => 90, 'pf' => 0.85],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'input' => ['label' => 'Electrical input power'],
            'kva' => ['label' => 'Apparent power'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
