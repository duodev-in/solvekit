<x-calc.page
    title="Boiling Point Calculator - SolveKit"
    description="Free boiling point calculator: boiling point of water and 29 common liquids at any pressure from NIST Antoine data, or by Clausius-Clapeyron."
    lede="Find the boiling point of a liquid at any pressure."
    about="A liquid boils when its vapor pressure equals the surrounding pressure. Water uses the IAPWS saturation equation; other liquids use Antoine parameters from the NIST Chemistry WebBook, only inside each data set's measured temperature range. For a substance not listed, use Clausius–Clapeyron with one known boiling point and the enthalpy of vaporization."
    :calc="['engine' => 'chem-thermo', 'tool' => 'boiling_point', 'fields' => ['mode', 'substance', 'pressure', 't1', 'p1', 'enthalpy', 'p2'], 'unitFields' => ['pressure' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all(), 't1' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all(), 'p1' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all(), 'p2' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all()], 'data' => ['antoine' => config('chemistry_data.antoine')]]"
    :how-to="[
        ['name' => 'Pick the liquid', 'text' => 'Or use Clausius–Clapeyron for others.'],
        ['name' => 'Enter the pressure', 'text' => 'Any pressure unit.'],
    ]"
    :faqs="[
        ['question' => 'What is the boiling point of water at 1 atm?', 'answer' => '99.97 °C by the current IAPWS formulation.'],
        ['question' => 'Why does lower pressure lower the boiling point?', 'answer' => 'Less vapor pressure is needed to match the surroundings.'],
        ['question' => 'Why does it say no data?', 'answer' => 'NIST parameters are only valid in their measured range; the calculator does not extrapolate.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Method" :options="['antoine' => 'From data', 'clausius' => 'Clausius–Clapeyron']" selected="antoine" />

    <div data-show-when="mode:antoine">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="substance" label="Liquid" :options="collect(config('chemistry_data.antoine'))->map(fn ($s) => $s['name'])->prepend('Water (IAPWS)', 'water')->all()" selected="water" />
            <x-calc.field name="pressure" label="Pressure" value="101.325" min="0" placeholder="Pressure">
                <label for="calc-pressure-unit" class="sr-only">Pressure unit</label>
                <select id="calc-pressure-unit" name="pressure-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:clausius" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="t1" label="Known boiling point" value="100" placeholder="Known boiling point">
                <label for="calc-t1-unit" class="sr-only">Known boiling point unit</label>
                <select id="calc-t1-unit" name="t1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="p1" label="At pressure" value="101.325" min="0" placeholder="At pressure">
                <label for="calc-p1-unit" class="sr-only">At pressure unit</label>
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
            <x-calc.field name="p2" label="New pressure" value="70" min="0" placeholder="New pressure">
                <label for="calc-p2-unit" class="sr-only">New pressure unit</label>
                <select id="calc-p2-unit" name="p2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Boiling point" />

    <x-calc.options :examples="[
        'Water at 1 atm' => ['mode' => 'antoine', 'substance' => 'water', 'pressure' => 101.325, 'pressure-unit' => 'kpa'],
        'Ethanol at 1 atm' => ['mode' => 'antoine', 'substance' => 'ethanol', 'pressure' => 1, 'pressure-unit' => 'atm'],
        'Acetone at 50 kPa' => ['mode' => 'antoine', 'substance' => 'acetone', 'pressure' => 50, 'pressure-unit' => 'kpa'],
        'Clausius–Clapeyron' => ['mode' => 'clausius', 't1' => 100, 't1-unit' => 'c', 'p1' => 101.325, 'p1-unit' => 'kpa', 'enthalpy' => 40.65, 'p2' => 70, 'p2-unit' => 'kpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kelvin' => ['label' => 'In kelvin'],
            'fahrenheit' => ['label' => 'In Fahrenheit'],
            'source' => ['label' => 'Data'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Antoine: log₁₀(P/bar) = A − B ÷ (T + C)</li>
            <li>Clausius–Clapeyron: 1/T₂ = 1/T₁ − R ln(P₂/P₁) ÷ ΔHvap</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
