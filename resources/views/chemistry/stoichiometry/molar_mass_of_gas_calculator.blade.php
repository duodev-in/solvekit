<x-calc.page
    title="Molar Mass of Gas Calculator - SolveKit"
    description="Free molar mass of gas calculator: molar mass from mass, volume, temperature and pressure, or from gas density, with likely gases."
    lede="Find a gas's molar mass from a measurement."
    about="From the ideal gas law, M = mRT ÷ PV, or M = ρRT ÷ P from density. The closest common gases are listed to help identify an unknown. Real gases deviate slightly from ideal behaviour, most at high pressure."
    :calc="['engine' => 'chem-stoich', 'tool' => 'gas_molar_mass', 'fields' => ['mode', 'mass', 'volume', 'density', 'temperature', 'pressure'], 'unitFields' => ['mass' => collect(config('units.mass'))->only(['g', 'mg', 'kg'])->all(), 'volume' => collect(config('units.volume'))->only(['ml', 'l'])->all(), 'temperature' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all(), 'pressure' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all()], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the measurement', 'text' => 'Mass and volume, or density.'],
        ['name' => 'Enter temperature and pressure', 'text' => 'Of the gas when measured.'],
    ]"
    :faqs="[
        ['question' => 'How do you find the molar mass of a gas?', 'answer' => 'M = mRT ÷ PV using the ideal gas law.'],
        ['question' => 'Which gas has a density of 1.43 g/L at STP?', 'answer' => 'Oxygen (32.0 g/mol).'],
        ['question' => 'Why use kelvin?', 'answer' => 'Gas laws need absolute temperature; the calculator converts for you.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['ideal' => 'Mass and volume', 'density' => 'Density']" selected="ideal" />

    <div data-show-when="mode:ideal">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="mass" label="Mass of gas" value="1.6" min="0" placeholder="Mass of gas">
                <label for="calc-mass-unit" class="sr-only">Mass of gas unit</label>
                <select id="calc-mass-unit" name="mass-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['g', 'mg', 'kg']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="volume" label="Volume" value="1" min="0" placeholder="Volume">
                <label for="calc-volume-unit" class="sr-only">Volume unit</label>
                <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['ml', 'l']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:density" hidden>
        <x-calc.field name="density" label="Gas density" value="1.43" min="0" suffix="g/L" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="temperature" label="Temperature" value="25" placeholder="Temperature">
            <label for="calc-temperature-unit" class="sr-only">Temperature unit</label>
            <select id="calc-temperature-unit" name="temperature-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="pressure" label="Pressure" value="101.325" min="0" placeholder="Pressure">
            <label for="calc-pressure-unit" class="sr-only">Pressure unit</label>
            <select id="calc-pressure-unit" name="pressure-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Molar mass" />

    <x-calc.options :examples="[
        '1.6 g in 1 L at 25 °C' => ['mode' => 'ideal', 'mass' => 1.6, 'mass-unit' => 'g', 'volume' => 1, 'volume-unit' => 'l', 'temperature' => 25, 'temperature-unit' => 'c', 'pressure' => 101.325, 'pressure-unit' => 'kpa'],
        '1.43 g/L at 0 °C' => ['mode' => 'density', 'density' => 1.43, 'temperature' => 0, 'temperature-unit' => 'c', 'pressure' => 1, 'pressure-unit' => 'atm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kelvin' => ['label' => 'Temperature'],
            'density_stp' => ['label' => 'Density at STP'],
        ]" />
        <x-calc.quick-ref heading="Closest common gases" name="matches" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>M = mRT ÷ PV</li>
            <li>M = ρRT ÷ P</li>
            <li>R = 8.314 462 618 J/(mol·K)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
