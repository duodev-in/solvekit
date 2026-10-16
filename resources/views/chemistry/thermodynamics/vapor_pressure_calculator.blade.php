<x-calc.page
    title="Vapor Pressure Calculator - SolveKit"
    description="Free vapor pressure calculator: vapor pressure of water and 29 common liquids at any temperature from NIST Antoine data, or by Clausius-Clapeyron."
    lede="Find the vapor pressure of a liquid at any temperature."
    about="Water uses the IAPWS equations (liquid and ice); other liquids use NIST Chemistry WebBook Antoine parameters, only inside each set's measured temperature range. For other substances use Clausius–Clapeyron with one known point and the enthalpy of vaporization."
    :calc="['engine' => 'chem-thermo', 'tool' => 'vapor_pressure', 'fields' => ['mode', 'substance', 'temperature', 't1', 'p1', 'enthalpy', 't2'], 'unitFields' => ['temperature' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all(), 't1' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all(), 'p1' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all(), 't2' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all()], 'data' => ['antoine' => config('chemistry_data.antoine')]]"
    :how-to="[
        ['name' => 'Pick the liquid', 'text' => 'Or use Clausius–Clapeyron.'],
        ['name' => 'Enter the temperature', 'text' => 'Any unit.'],
    ]"
    :faqs="[
        ['question' => 'What is the vapor pressure of water at 25 °C?', 'answer' => '3.17 kPa (23.8 mmHg).'],
        ['question' => 'Why does vapor pressure rise with temperature?', 'answer' => 'More molecules have enough energy to escape the liquid.'],
        ['question' => 'Why is there a range?', 'answer' => 'Antoine parameters are fitted to measurements and only valid where measured.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Method" :options="['antoine' => 'From data', 'clausius' => 'Clausius–Clapeyron']" selected="antoine" />

    <div data-show-when="mode:antoine">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="substance" label="Liquid" :options="collect(config('chemistry_data.antoine'))->map(fn ($s) => $s['name'])->prepend('Water (IAPWS)', 'water')->all()" selected="ethanol" />
            <x-calc.field name="temperature" label="Temperature" value="25" placeholder="Temperature">
                <label for="calc-temperature-unit" class="sr-only">Temperature unit</label>
                <select id="calc-temperature-unit" name="temperature-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:clausius" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="t1" label="Known temperature" value="100" placeholder="Known temperature">
                <label for="calc-t1-unit" class="sr-only">Known temperature unit</label>
                <select id="calc-t1-unit" name="t1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="p1" label="Its vapor pressure" value="101.325" min="0" placeholder="Its vapor pressure">
                <label for="calc-p1-unit" class="sr-only">Its vapor pressure unit</label>
                <select id="calc-p1-unit" name="p1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:clausius" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="enthalpy" label="Enthalpy of vaporization" value="40.65" min="0" suffix="kJ/mol" />
            <x-calc.field name="t2" label="New temperature" value="80" placeholder="New temperature">
                <label for="calc-t2-unit" class="sr-only">New temperature unit</label>
                <select id="calc-t2-unit" name="t2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Vapor pressure" />

    <x-calc.options :examples="[
        'Ethanol at 25 °C' => ['mode' => 'antoine', 'substance' => 'ethanol', 'temperature' => 25, 'temperature-unit' => 'c'],
        'Acetone at 20 °C' => ['mode' => 'antoine', 'substance' => 'acetone', 'temperature' => 20, 'temperature-unit' => 'c'],
        'Water at 37 °C' => ['mode' => 'antoine', 'substance' => 'water', 'temperature' => 37, 'temperature-unit' => 'c'],
        'Clausius–Clapeyron' => ['mode' => 'clausius', 't1' => 100, 't1-unit' => 'c', 'p1' => 101.325, 'p1-unit' => 'kpa', 'enthalpy' => 40.65, 't2' => 80, 't2-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kpa' => ['label' => 'In kPa'],
            'mmhg' => ['label' => 'In mmHg'],
            'atm' => ['label' => 'In atm'],
            'psi' => ['label' => 'In psi'],
            'source' => ['label' => 'Data'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Antoine: log₁₀(P/bar) = A − B ÷ (T + C)</li>
            <li>Clausius–Clapeyron: ln(P₂/P₁) = −ΔHvap/R × (1/T₂ − 1/T₁)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
