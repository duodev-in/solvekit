<x-calc.page
    title="STP Calculator (Standard Temperature and Pressure) - SolveKit"
    description="Free STP calculator: gas volume at IUPAC STP, 0 °C and 1 atm, NTP or SATP from moles, mass or measured conditions."
    lede="Work out a gas volume at standard temperature and pressure."
    about="IUPAC STP is 0 °C and 100 kPa, where an ideal gas occupies 22.711 L/mol. The older definition at 1 atm gives 22.414 L/mol; NTP (20 °C, 1 atm) and SATP (25 °C, 100 kPa) are also shown. Real gases differ slightly from ideal behaviour."
    :calc="['engine' => 'chem-thermo', 'tool' => 'stp', 'fields' => ['mode', 'standard', 'amount', 'amount_unit', 'formula', 'volume', 'temperature', 'pressure'], 'unitFields' => ['temperature' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all(), 'pressure' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all()], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick the standard', 'text' => 'IUPAC STP unless told otherwise.'],
        ['name' => 'Enter the gas', 'text' => 'Moles, grams, or a measured volume.'],
    ]"
    :faqs="[
        ['question' => 'What is STP?', 'answer' => 'IUPAC: 273.15 K and 100 kPa (1 bar). Older texts use 1 atm.'],
        ['question' => 'What is the molar volume at STP?', 'answer' => '22.711 L/mol (IUPAC) or 22.414 L/mol at 1 atm.'],
        ['question' => 'Why do the definitions differ?', 'answer' => 'IUPAC changed from 1 atm to 1 bar in 1982.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['amount' => 'Amount of gas', 'convert' => 'Measured volume']" selected="amount" />

    <x-calc.select name="standard" label="Standard" :options="['iupac' => 'IUPAC STP (0 °C, 100 kPa)', 'atm' => '0 °C and 1 atm', 'ntp' => 'NTP (20 °C, 1 atm)', 'satp' => 'SATP (25 °C, 100 kPa)']" selected="iupac" />

    <div data-show-when="mode:amount">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="amount" label="Amount" value="1" min="0" />
            <x-calc.segmented name="amount_unit" legend="In" :options="['mol' => 'mol', 'g' => 'g']" selected="mol" />
            <x-calc.field name="formula" label="Gas formula" value="CO2" type="text" help="For grams" />
        </div>
    </div>

    <div data-show-when="mode:convert" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="volume" label="Volume" value="25" min="0" suffix="L" />
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
    </div>

    <x-calc.result label="Volume at STP" />

    <x-calc.options :examples="[
        '1 mol at IUPAC STP' => ['mode' => 'amount', 'standard' => 'iupac', 'amount' => 1, 'amount_unit' => 'mol', 'formula' => 'CO2'],
        '44 g CO₂ at 1 atm' => ['mode' => 'amount', 'standard' => 'atm', 'amount' => 44, 'amount_unit' => 'g', 'formula' => 'CO2'],
        '25 L at room conditions' => ['mode' => 'convert', 'standard' => 'iupac', 'volume' => 25, 'temperature' => 25, 'temperature-unit' => 'c', 'pressure' => 101.325, 'pressure-unit' => 'kpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'moles' => ['label' => 'Amount'],
            'molar' => ['label' => 'Molar volume'],
            'all' => ['label' => 'At each standard'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = nRT ÷ P</li>
            <li>Vm = 22.711 L/mol at 273.15 K, 100 kPa</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
