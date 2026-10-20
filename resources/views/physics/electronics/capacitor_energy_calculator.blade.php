<x-calc.page
    title="Capacitor Energy Calculator - SolveKit"
    description="Free capacitor energy calculator: stored energy E = ½CV² solved for any value."
    lede="Stored energy E = ½CV² solved for any value."
    about="A charged capacitor stores ½CV². Doubling the voltage stores four times the energy."
    :calc="['engine' => 'ph-elec', 'tool' => 'capacitor_energy', 'fields' => ['solve', 'E', 'C', 'V', 'out_E', 'out_C', 'out_V'], 'unitFields' => ['E' => collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev'])->all(), 'C' => collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf'])->all(), 'V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['E', 'capacitance', 'energy', 'force', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'How much energy does a 0.1 F capacitor hold at 12 V?', 'answer' => '7.2 J.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['E' => 'Energy stored', 'C' => 'Capacitance', 'V' => 'Voltage']" selected="E" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:C,V" hidden>
            <x-calc.field name="E" label="Energy stored" value="7.2" placeholder="Energy stored">
                <label for="calc-E-unit" class="sr-only">Energy stored unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'j')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E,V">
            <x-calc.field name="C" label="Capacitance" value="100000" min="0" placeholder="Capacitance">
                <label for="calc-C-unit" class="sr-only">Capacitance unit</label>
                <select id="calc-C-unit" name="C-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'uf')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E,C">
            <x-calc.field name="V" label="Voltage" value="12" placeholder="Voltage">
                <label for="calc-V-unit" class="sr-only">Voltage unit</label>
                <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E">
            <x-calc.select name="out_E" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="j" />
        </div>
        <div data-show-when="solve:C" hidden>
            <x-calc.select name="out_C" label="Show the result in" :options="['f' => 'F', 'mf' => 'mF', 'uf' => 'µF', 'nf' => 'nF', 'pf' => 'pF']" selected="uf" />
        </div>
        <div data-show-when="solve:V" hidden>
            <x-calc.select name="out_V" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="v" />
        </div>
    </div>

    <x-calc.result label="Energy stored" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'E', 'E' => 7.2, 'E-unit' => 'j', 'out_E' => 'j', 'C' => 100000, 'C-unit' => 'uf', 'out_C' => 'uf', 'V' => 12, 'V-unit' => 'v', 'out_V' => 'v'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'Q' => ['label' => 'Charge'],
            'wh' => ['label' => 'In watt-hours'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E = ½ C V²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
