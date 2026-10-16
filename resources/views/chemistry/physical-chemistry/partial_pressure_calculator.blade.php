<x-calc.page
    title="Partial Pressure Calculator - SolveKit"
    description="Free partial pressure calculator: Dalton's law partial pressures from mole fractions and total pressure, or from moles, volume and temperature."
    lede="Work out each gas's partial pressure in a mixture."
    about="Dalton's law: the total pressure is the sum of the partial pressures, and each gas contributes pᵢ = xᵢ P. Enter mole fractions with the total pressure, or moles with the volume and temperature (ideal gas)."
    :calc="['engine' => 'chem-physical', 'tool' => 'partial_pressure', 'fields' => ['mode', 'gases', 'total_pressure', 'volume', 'temperature'], 'unitFields' => ['total_pressure' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all(), 'volume' => collect(config('units.volume'))->only(['ml', 'l'])->all(), 'temperature' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all()]]"
    :how-to="[
        ['name' => 'Enter each gas', 'text' => 'Name and fraction or moles.'],
        ['name' => 'Enter the pressure', 'text' => 'Or volume and temperature.'],
    ]"
    :faqs="[
        ['question' => 'What is Dalton\'s law?', 'answer' => 'Each gas in a mixture exerts pressure as if it were alone.'],
        ['question' => 'What is the partial pressure of oxygen in air?', 'answer' => 'About 21.2 kPa at sea level.'],
        ['question' => 'Why does it matter for diving?', 'answer' => 'Oxygen and nitrogen partial pressures rise with depth and become toxic.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['fractions' => 'Mole fractions', 'moles' => 'Moles']" selected="fractions" />

    <x-calc.textarea name="gases" label="Gases and amounts" value="N2 0.78084
O2 0.20946
Ar 0.00934" help="One per line: gas and mole fraction (or moles)" rows="4" />

    <div data-show-when="mode:fractions">
        <x-calc.field name="total_pressure" label="Total pressure" value="101.325" min="0" placeholder="Total pressure">
            <label for="calc-total_pressure-unit" class="sr-only">Total pressure unit</label>
            <select id="calc-total_pressure-unit" name="total_pressure-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="mode:moles" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="volume" label="Volume" value="10" min="0" placeholder="Volume">
                <label for="calc-volume-unit" class="sr-only">Volume unit</label>
                <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['ml', 'l']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
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

    <x-calc.result label="Total pressure" />

    <x-calc.options :examples="[
        'Dry air at sea level' => ['mode' => 'fractions', 'gases' => 'N2 0.78084
O2 0.20946
Ar 0.00934', 'total_pressure' => 101.325, 'total_pressure-unit' => 'kpa'],
        'Diving at 30 m (4 atm)' => ['mode' => 'fractions', 'gases' => 'N2 0.79
O2 0.21', 'total_pressure' => 4, 'total_pressure-unit' => 'atm'],
        'Moles in a flask' => ['mode' => 'moles', 'gases' => 'H2 0.2
He 0.3', 'volume' => 10, 'volume-unit' => 'l', 'temperature' => 25, 'temperature-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'atm' => ['label' => 'In atm'],
            'moles' => ['label' => 'Total'],
        ]" />
        <x-calc.quick-ref heading="Each gas" name="gases" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pᵢ = xᵢ P total</li>
            <li>P total = Σ nᵢ RT ÷ V</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
