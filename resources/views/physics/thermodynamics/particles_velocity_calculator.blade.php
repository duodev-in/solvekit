<x-calc.page
    title="Particles Velocity Calculator - SolveKit"
    description="Free gas particle velocity calculator: most probable, mean and RMS molecular speeds, with the Maxwell–Boltzmann curve."
    lede="Find molecular speeds."
    about="Gas molecules move with a spread of speeds described by the Maxwell–Boltzmann distribution. Lighter and hotter means faster."
    :calc="['engine' => 'ph-thermo', 'tool' => 'particle_speeds', 'fields' => ['gas', 'M', 'T', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all(), 'physics' => collect(config('physics_data'))->only(['gases'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast are nitrogen molecules at 25 °C?', 'answer' => 'RMS 515.243 m/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="gas" label="Gas" :options="['air' => 'Air', 'nitrogen' => 'Nitrogen', 'oxygen' => 'Oxygen', 'co2' => 'Carbon dioxide', 'methane' => 'Methane', 'propane' => 'Propane', 'hydrogen' => 'Hydrogen', 'helium' => 'Helium', 'argon' => 'Argon', 'steam' => 'Water vapour', 'ammonia' => 'Ammonia', 'custom' => 'Other (enter the value)']" selected="nitrogen" />
        <div data-show-when="gas:custom">
            <x-calc.field name="M" label="Molar mass (g/mol)" value="28" min="0" step="any" />
        </div>
        <x-calc.field name="T" label="Temperature" value="25" placeholder="Temperature">
            <label for="calc-T-unit" class="sr-only">Temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
    </div>

    <x-calc.result label="RMS speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms', 'gas' => 'nitrogen', 'M' => 28, 'T' => 25, 'T-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Maxwell–Boltzmann speed distribution" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'vp' => ['label' => 'Most probable speed'],
            'vm' => ['label' => 'Mean speed'],
            'ratio' => ['label' => 'Ratio v_p : v̄ : v_rms'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
