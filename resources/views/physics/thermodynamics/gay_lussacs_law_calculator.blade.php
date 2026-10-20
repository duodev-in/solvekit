<x-calc.page
    title="Gay-Lussac's Law Calculator - SolveKit"
    description="Free Gay-Lussac's law calculator: P₁/T₁ = P₂/T₂ at constant volume, solved for any value."
    lede="Solve P₁/T₁ = P₂/T₂."
    about="In a rigid container pressure is proportional to absolute temperature. That is why aerosol cans must not be heated."
    :calc="['engine' => 'ph-thermo', 'tool' => 'gay_lussac', 'fields' => ['solve', 'P1', 'T1', 'P2', 'T2', 'out_P1', 'out_T1', 'out_P2', 'out_T2'], 'unitFields' => ['P1' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'T1' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'P2' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'T2' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What pressure does 200 kPa at 20 °C reach at 50 °C?', 'answer' => '220.467 kPa.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['P1' => 'Pressure 1', 'T1' => 'Temperature 1', 'P2' => 'Pressure 2', 'T2' => 'Temperature 2']" selected="P2" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:T1,P2,T2">
            <x-calc.field name="P1" label="Pressure 1" value="200" min="0" placeholder="Pressure 1">
                <label for="calc-P1-unit" class="sr-only">Pressure 1 unit</label>
                <select id="calc-P1-unit" name="P1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1,P2,T2">
            <x-calc.field name="T1" label="Temperature 1" value="20" placeholder="Temperature 1">
                <label for="calc-T1-unit" class="sr-only">Temperature 1 unit</label>
                <select id="calc-T1-unit" name="T1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1,T1,T2" hidden>
            <x-calc.field name="P2" label="Pressure 2" value="220.47" min="0" placeholder="Pressure 2">
                <label for="calc-P2-unit" class="sr-only">Pressure 2 unit</label>
                <select id="calc-P2-unit" name="P2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1,T1,P2">
            <x-calc.field name="T2" label="Temperature 2" value="50" placeholder="Temperature 2">
                <label for="calc-T2-unit" class="sr-only">Temperature 2 unit</label>
                <select id="calc-T2-unit" name="T2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1" hidden>
            <x-calc.select name="out_P1" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="kpa" />
        </div>
        <div data-show-when="solve:T1" hidden>
            <x-calc.select name="out_T1" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
        </div>
        <div data-show-when="solve:P2">
            <x-calc.select name="out_P2" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="kpa" />
        </div>
        <div data-show-when="solve:T2" hidden>
            <x-calc.select name="out_T2" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
        </div>
    </div>

    <x-calc.result label="Pressure 2" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'P2', 'P1' => 200, 'P1-unit' => 'kpa', 'out_P1' => 'kpa', 'T1' => 20, 'T1-unit' => 'c', 'out_T1' => 'c', 'P2' => 220.47, 'P2-unit' => 'kpa', 'out_P2' => 'kpa', 'T2' => 50, 'T2-unit' => 'c', 'out_T2' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'change' => ['label' => 'Pressure change'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P₁ ÷ T₁ = P₂ ÷ T₂ (constant V, kelvin)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
