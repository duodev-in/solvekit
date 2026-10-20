<x-calc.page
    title="Kinematic Viscosity of Air Calculator - SolveKit"
    description="Free air viscosity calculator: dynamic and kinematic viscosity of air at any temperature and pressure."
    lede="Find the viscosity of air."
    about="Unlike liquids, gases get more viscous as they warm. Sutherland’s law captures this for air."
    :calc="['engine' => 'ph-thermo', 'tool' => 'air_kinematic_viscosity', 'fields' => ['T', 'p', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'p' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'kinematic_viscosity', 'length', 'mass', 'pressure', 'speed', 'temperature', 'viscosity'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the kinematic viscosity of air at 20 °C?', 'answer' => '0.0000150598 m²/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="T" label="Air temperature" value="20" placeholder="Air temperature">
            <label for="calc-T-unit" class="sr-only">Air temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="p" label="Pressure" value="101.325" min="0" placeholder="Pressure">
            <label for="calc-p-unit" class="sr-only">Pressure unit</label>
            <select id="calc-p-unit" name="p-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m2s' => 'm²/s', 'mm2s' => 'mm²/s', 'cst' => 'cSt', 'st' => 'St', 'ft2s' => 'ft²/s']" selected="m2s" />
    </div>

    <x-calc.result label="Kinematic viscosity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm2s', 'T' => 20, 'T-unit' => 'c', 'p' => 101.325, 'p-unit' => 'kpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mu' => ['label' => 'Dynamic viscosity'],
            'rho' => ['label' => 'Density (dry air)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
