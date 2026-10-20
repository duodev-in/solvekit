<x-calc.page
    title="Voltage Regulation Calculator - SolveKit"
    description="Free voltage regulation calculator: VR from no-load and full-load voltage, solved for any value."
    lede="Find voltage regulation."
    about="Voltage regulation measures how much a supply sags under load: (V_nl − V_fl)/V_fl."
    :calc="['engine' => 'ph-elec', 'tool' => 'voltage_regulation', 'fields' => ['solve', 'VR', 'Vnl', 'Vfl', 'out_Vnl', 'out_Vfl'], 'unitFields' => ['Vnl' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'Vfl' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['VR', 'energy', 'force', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is VR for 12.6 V falling to 12 V?', 'answer' => '0.05 (5%).'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['VR' => 'Voltage regulation (fraction)', 'Vnl' => 'No-load voltage', 'Vfl' => 'Full-load voltage']" selected="VR" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:Vnl,Vfl" hidden>
            <x-calc.field name="VR" label="Voltage regulation (fraction)" value="0.05" step="any" />
        </div>
        <div data-show-when="solve:VR,Vfl">
            <x-calc.field name="Vnl" label="No-load voltage" value="12.6" placeholder="No-load voltage">
                <label for="calc-Vnl-unit" class="sr-only">No-load voltage unit</label>
                <select id="calc-Vnl-unit" name="Vnl-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:VR,Vnl">
            <x-calc.field name="Vfl" label="Full-load voltage" value="12" placeholder="Full-load voltage">
                <label for="calc-Vfl-unit" class="sr-only">Full-load voltage unit</label>
                <select id="calc-Vfl-unit" name="Vfl-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Vnl" hidden>
            <x-calc.select name="out_Vnl" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="v" />
        </div>
        <div data-show-when="solve:Vfl" hidden>
            <x-calc.select name="out_Vfl" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="v" />
        </div>
    </div>

    <x-calc.result label="Voltage regulation (fraction)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'VR', 'VR' => 0.05, 'Vnl' => 12.6, 'Vnl-unit' => 'v', 'out_Vnl' => 'v', 'Vfl' => 12, 'Vfl-unit' => 'v', 'out_Vfl' => 'v'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'pct' => ['label' => 'As a percentage'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>VR = (V_nl − V_fl) ÷ V_fl</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
