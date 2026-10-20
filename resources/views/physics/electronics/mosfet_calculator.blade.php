<x-calc.page
    title="MOSFET Calculator - SolveKit"
    description="Free MOSFET calculator: drain current and operating region from the square-law model."
    lede="Find MOSFET drain current."
    about="In the square-law model a MOSFET is off below threshold, acts as a resistor in the triode region and as a current source in saturation. Modern short-channel parts deviate, so check data sheets."
    :calc="['engine' => 'ph-elec', 'tool' => 'mosfet', 'fields' => ['type', 'Vgs', 'Vds', 'Vth', 'k', 'lambda', 'out'], 'unitFields' => ['Vgs' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'Vds' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'Vth' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is I_D at V_GS = 5 V, V_th = 2 V, k = 20 mA/V²?', 'answer' => '99 mA.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Type" :options="['n' => 'n-channel (enhancement)', 'p' => 'p-channel (enhancement), magnitudes']" selected="n" />
        <x-calc.field name="Vgs" label="Gate–source voltage" value="5" placeholder="Gate–source voltage">
            <label for="calc-Vgs-unit" class="sr-only">Gate–source voltage unit</label>
            <select id="calc-Vgs-unit" name="Vgs-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Vds" label="Drain–source voltage" value="10" placeholder="Drain–source voltage">
            <label for="calc-Vds-unit" class="sr-only">Drain–source voltage unit</label>
            <select id="calc-Vds-unit" name="Vds-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Vth" label="Threshold voltage" value="2" placeholder="Threshold voltage">
            <label for="calc-Vth-unit" class="sr-only">Threshold voltage unit</label>
            <select id="calc-Vth-unit" name="Vth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="k" label="Transconductance parameter k (mA/V²)" value="20" min="0" step="any" />
        <x-calc.field name="lambda" label="Channel-length modulation λ (1/V)" value="0.01" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['a' => 'A', 'ma' => 'mA', 'ua' => 'µA', 'na' => 'nA', 'ka' => 'kA']" selected="ma" />
    </div>

    <x-calc.result label="Drain current" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ma', 'type' => 'n', 'Vgs' => 5, 'Vgs-unit' => 'v', 'Vds' => 10, 'Vds-unit' => 'v', 'Vth' => 2, 'Vth-unit' => 'v', 'k' => 20, 'lambda' => 0.01],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'region' => ['label' => 'Region'],
            'gm' => ['label' => 'Transconductance g_m'],
            'rds' => ['label' => 'On-resistance (triode, small V_DS)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
