<x-calc.page
    title="Voltage Divider Calculator - SolveKit"
    description="Free voltage divider calculator: output voltage or resistor values, solved for any quantity."
    lede="Solve a voltage divider."
    about="Two resistors in series split a voltage in proportion: V_out = V_in R₂/(R₁ + R₂). Loading the output changes it."
    :calc="['engine' => 'ph-elec', 'tool' => 'voltage_divider', 'fields' => ['solve', 'Vout', 'Vin', 'R1', 'R2', 'out_Vout', 'out_Vin', 'out_R1', 'out_R2'], 'unitFields' => ['Vout' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'Vin' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'R1' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'R2' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'resistance', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What does 1.7k over 3.3k give from 5 V?', 'answer' => '3.3 V.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['Vout' => 'Output voltage', 'Vin' => 'Input voltage', 'R1' => 'R1 (top)', 'R2' => 'R2 (bottom)']" selected="Vout" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:Vin,R1,R2" hidden>
            <x-calc.field name="Vout" label="Output voltage" value="3.3" placeholder="Output voltage">
                <label for="calc-Vout-unit" class="sr-only">Output voltage unit</label>
                <select id="calc-Vout-unit" name="Vout-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Vout,R1,R2">
            <x-calc.field name="Vin" label="Input voltage" value="5" placeholder="Input voltage">
                <label for="calc-Vin-unit" class="sr-only">Input voltage unit</label>
                <select id="calc-Vin-unit" name="Vin-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Vout,Vin,R2">
            <x-calc.field name="R1" label="R1 (top)" value="1.7" min="0" placeholder="R1 (top)">
                <label for="calc-R1-unit" class="sr-only">R1 (top) unit</label>
                <select id="calc-R1-unit" name="R1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Vout,Vin,R1">
            <x-calc.field name="R2" label="R2 (bottom)" value="3.3" min="0" placeholder="R2 (bottom)">
                <label for="calc-R2-unit" class="sr-only">R2 (bottom) unit</label>
                <select id="calc-R2-unit" name="R2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Vout">
            <x-calc.select name="out_Vout" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="v" />
        </div>
        <div data-show-when="solve:Vin" hidden>
            <x-calc.select name="out_Vin" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="v" />
        </div>
        <div data-show-when="solve:R1" hidden>
            <x-calc.select name="out_R1" label="Show the result in" :options="['ohm' => 'Ω', 'mohm' => 'mΩ', 'kohm' => 'kΩ', 'megohm' => 'MΩ', 'gohm' => 'GΩ']" selected="kohm" />
        </div>
        <div data-show-when="solve:R2" hidden>
            <x-calc.select name="out_R2" label="Show the result in" :options="['ohm' => 'Ω', 'mohm' => 'mΩ', 'kohm' => 'kΩ', 'megohm' => 'MΩ', 'gohm' => 'GΩ']" selected="kohm" />
        </div>
    </div>

    <x-calc.result label="Output voltage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'Vout', 'Vout' => 3.3, 'Vout-unit' => 'v', 'out_Vout' => 'v', 'Vin' => 5, 'Vin-unit' => 'v', 'out_Vin' => 'v', 'R1' => 1.7, 'R1-unit' => 'kohm', 'out_R1' => 'kohm', 'R2' => 3.3, 'R2-unit' => 'kohm', 'out_R2' => 'kohm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'I' => ['label' => 'Divider current'],
            'ratio' => ['label' => 'Ratio'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V_out = V_in R₂ ÷ (R₁ + R₂)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
