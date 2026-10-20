<x-calc.page
    title="Capacitor Calculator - SolveKit"
    description="Free capacitor calculator: solve Q = CV for charge, capacitance or voltage."
    lede="Solve Q = CV for charge, capacitance or voltage."
    about="A capacitor holds charge in proportion to the voltage across it: Q = CV."
    :calc="['engine' => 'ph-elec', 'tool' => 'capacitor', 'fields' => ['solve', 'Q', 'C', 'V', 'out_Q', 'out_C', 'out_V'], 'unitFields' => ['Q' => collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e'])->all(), 'C' => collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf'])->all(), 'V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['Q', 'capacitance', 'charge', 'energy', 'force', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What charge does 100 µF hold at 12 V?', 'answer' => '1,200 µC.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['Q' => 'Charge', 'C' => 'Capacitance', 'V' => 'Voltage']" selected="Q" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:C,V" hidden>
            <x-calc.field name="Q" label="Charge" value="1200" placeholder="Charge">
                <label for="calc-Q-unit" class="sr-only">Charge unit</label>
                <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'uc')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,V">
            <x-calc.field name="C" label="Capacitance" value="100" min="0" placeholder="Capacitance">
                <label for="calc-C-unit" class="sr-only">Capacitance unit</label>
                <select id="calc-C-unit" name="C-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'uf')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,C">
            <x-calc.field name="V" label="Voltage" value="12" placeholder="Voltage">
                <label for="calc-V-unit" class="sr-only">Voltage unit</label>
                <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q">
            <x-calc.select name="out_Q" label="Show the result in" :options="['c' => 'C', 'mc' => 'mC', 'uc' => 'µC', 'nc' => 'nC', 'ah' => 'Ah', 'mah' => 'mAh', 'e' => 'e']" selected="uc" />
        </div>
        <div data-show-when="solve:C" hidden>
            <x-calc.select name="out_C" label="Show the result in" :options="['f' => 'F', 'mf' => 'mF', 'uf' => 'µF', 'nf' => 'nF', 'pf' => 'pF']" selected="uf" />
        </div>
        <div data-show-when="solve:V" hidden>
            <x-calc.select name="out_V" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="v" />
        </div>
    </div>

    <x-calc.result label="Charge" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'Q', 'Q' => 1200, 'Q-unit' => 'uc', 'out_Q' => 'uc', 'C' => 100, 'C-unit' => 'uf', 'out_C' => 'uf', 'V' => 12, 'V-unit' => 'v', 'out_V' => 'v'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'E' => ['label' => 'Energy stored'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Q = C V</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
