<x-calc.page
    title="Van der Waals Equation Calculator - SolveKit"
    description="Free van der Waals equation calculator: pressure, volume or temperature of a real gas with CRC a and b constants, compared with the ideal gas."
    lede="Work out real-gas pressure, volume or temperature with the van der Waals equation."
    about="The van der Waals equation (P + an²/V²)(V − nb) = nRT corrects the ideal gas law for attractions (a) and molecular volume (b). Constants for 106 gases are from the CRC Handbook. Volume is solved exactly from the cubic equation. The compressibility factor Z shows how far the gas is from ideal (Z = 1)."
    :calc="['engine' => 'chem-physical', 'tool' => 'van_der_waals', 'fields' => ['solve', 'gas', 'moles', 'a', 'b', 'pressure', 'volume', 'temperature'], 'unitFields' => ['pressure' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all(), 'temperature' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all()], 'data' => ['vdw' => config('chemistry_data.vdw')]]"
    :how-to="[
        ['name' => 'Pick the gas', 'text' => 'Or enter a and b.'],
        ['name' => 'Choose what to solve for', 'text' => 'P, V or T.'],
        ['name' => 'Enter the other values', 'text' => 'And compare with the ideal gas.'],
    ]"
    :faqs="[
        ['question' => 'What do a and b mean?', 'answer' => 'a measures attraction between molecules; b is the volume the molecules themselves take up.'],
        ['question' => 'When does it matter?', 'answer' => 'At high pressure or near condensation, where real gases deviate from ideal.'],
        ['question' => 'Is the van der Waals equation exact?', 'answer' => 'No, it is a model; it is better than the ideal gas law but not perfect near the critical point.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['p' => 'Pressure', 'v' => 'Volume', 't' => 'Temperature']" selected="p" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="gas" label="Gas" :options="collect(config('chemistry_data.vdw'))->map(fn ($g) => $g['name'])->put('custom', 'Custom a and b')->all()" selected="carbon_dioxide" />
        <x-calc.field name="moles" label="Moles" value="1" min="0" suffix="mol" />
    </div>

    <div data-show-when="gas:custom" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="a" label="a" value="3.64" min="0" suffix="L²·bar/mol²" />
            <x-calc.field name="b" label="b" value="0.04267" min="0" suffix="L/mol" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="solve:v,t" hidden>
            <x-calc.field name="pressure" label="Pressure" value="100" min="0" placeholder="Pressure">
                <label for="calc-pressure-unit" class="sr-only">Pressure unit</label>
                <select id="calc-pressure-unit" name="pressure-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:p,t">
            <x-calc.field name="volume" label="Volume" value="22.4" min="0" suffix="L" />
        </div>
        <div data-show-when="solve:p,v">
            <x-calc.field name="temperature" label="Temperature" value="0" placeholder="Temperature">
                <label for="calc-temperature-unit" class="sr-only">Temperature unit</label>
                <select id="calc-temperature-unit" name="temperature-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'CO₂ in 22.4 L at 0 °C' => ['solve' => 'p', 'gas' => 'carbon_dioxide', 'moles' => 1, 'volume' => 22.4, 'temperature' => 0, 'temperature-unit' => 'c'],
        'CO₂ compressed to 0.5 L' => ['solve' => 'p', 'gas' => 'carbon_dioxide', 'moles' => 1, 'volume' => 0.5, 'temperature' => 25, 'temperature-unit' => 'c'],
        'Volume of nitrogen at 50 bar' => ['solve' => 'v', 'gas' => 'nitrogen', 'moles' => 1, 'pressure' => 50, 'pressure-unit' => 'bar', 'temperature' => 25, 'temperature-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ideal' => ['label' => 'Ideal gas value'],
            'z' => ['label' => 'Compressibility Z'],
            'constants' => ['label' => 'Constants used'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(P + an²/V²)(V − nb) = nRT</li>
            <li>Z = PV ÷ nRT</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
