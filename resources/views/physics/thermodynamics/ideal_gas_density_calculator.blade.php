<x-calc.page
    title="Ideal Gas Density Calculator - SolveKit"
    description="Free gas density calculator: density of air, CO₂, methane and other gases from pressure and temperature."
    lede="Find gas density."
    about="An ideal gas has density ρ = PM/RT: heavier molecules, higher pressure and colder gas are denser."
    :calc="['engine' => 'ph-thermo', 'tool' => 'ideal_gas_density', 'fields' => ['gas', 'M', 'P', 'T', 'out'], 'unitFields' => ['P' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature'])->all(), 'physics' => collect(config('physics_data'))->only(['gases'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the density of air at 20 °C and 1 atm?', 'answer' => '1.2041 kg/m³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="gas" label="Gas" :options="['air' => 'Air', 'nitrogen' => 'Nitrogen', 'oxygen' => 'Oxygen', 'co2' => 'Carbon dioxide', 'methane' => 'Methane', 'propane' => 'Propane', 'hydrogen' => 'Hydrogen', 'helium' => 'Helium', 'argon' => 'Argon', 'steam' => 'Water vapour', 'ammonia' => 'Ammonia', 'custom' => 'Other (enter the value)']" selected="air" />
        <div data-show-when="gas:custom">
            <x-calc.field name="M" label="Molar mass (g/mol)" value="28.9647" min="0" step="any" />
        </div>
        <x-calc.field name="P" label="Pressure" value="101.325" min="0" placeholder="Pressure">
            <label for="calc-P-unit" class="sr-only">Pressure unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T" label="Temperature" value="20" placeholder="Temperature">
            <label for="calc-T-unit" class="sr-only">Temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['kgm3' => 'kg/m³', 'gcm3' => 'g/cm³', 'lbft3' => 'lb/ft³', 'lbin3' => 'lb/in³', 'lbgal' => 'lb/gal']" selected="kgm3" />
    </div>

    <x-calc.result label="Gas density" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kgm3', 'gas' => 'air', 'M' => 28.9647, 'P' => 101.325, 'P-unit' => 'kpa', 'T' => 20, 'T-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sg' => ['label' => 'Relative to air'],
            'molar' => ['label' => 'Molar volume'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
