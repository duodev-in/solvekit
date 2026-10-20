<x-calc.page
    title="Watts to Amps Calculator - SolveKit"
    description="Free watts to amps calculator: current from power and voltage for DC, single-phase and three-phase AC."
    lede="Convert watts to amps."
    about="Current is power divided by voltage, and also by power factor for AC and by √3 for three-phase line values."
    :calc="['engine' => 'ph-em', 'tool' => 'watts_amps', 'fields' => ['P', 'V', 'phase', 'pf', 'out'], 'unitFields' => ['P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'power', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many amps is 2,000 W at 230 V?', 'answer' => '8.69565 A.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="P" label="Power" value="2000" min="0" placeholder="Power">
            <label for="calc-P-unit" class="sr-only">Power unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="V" label="Voltage" value="230" placeholder="Voltage">
            <label for="calc-V-unit" class="sr-only">Voltage unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="phase" label="Supply" :options="['dc' => 'DC', 'single' => 'AC single phase', 'three' => 'AC three phase (line-to-line voltage)']" selected="single" />
        <x-calc.field name="pf" label="Power factor" value="1" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['a' => 'A', 'ma' => 'mA', 'ua' => 'µA', 'na' => 'nA', 'ka' => 'kA']" selected="a" />
    </div>

    <x-calc.result label="Current" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'a', 'P' => 2000, 'P-unit' => 'w', 'V' => 230, 'V-unit' => 'v', 'phase' => 'single', 'pf' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'va' => ['label' => 'Apparent power'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
