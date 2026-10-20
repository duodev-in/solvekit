<x-calc.page
    title="Speed of Sound in Solids Calculator - SolveKit"
    description="Free speed of sound in solids calculator: longitudinal, shear and rod wave speeds from elastic properties."
    lede="Find sound speeds in a solid."
    about="Solids carry compression (P) waves and shear (S) waves. Their speeds follow from Young’s modulus, density and Poisson’s ratio; ultrasonic testing uses them to find flaws and thickness."
    :calc="['engine' => 'ph-wave', 'tool' => 'solid_sound', 'fields' => ['mat', 'E', 'rho', 'nu', 'out'], 'unitFields' => ['E' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['solids'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast is sound in steel?', 'answer' => '5,778.16 m/s for compression waves.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mat" label="Material" :options="['steel' => 'Structural steel', 'stainless' => 'Stainless steel 304', 'aluminium' => 'Aluminium alloy 6061', 'copper' => 'Copper', 'brass' => 'Brass', 'titanium' => 'Titanium (Ti-6Al-4V)', 'lead' => 'Lead', 'glass' => 'Soda-lime glass', 'concrete' => 'Concrete', 'granite' => 'Granite', 'oak' => 'Oak (along the grain)', 'nylon' => 'Nylon 6/6', 'custom' => 'Other (enter the value)']" selected="steel" />
        <div data-show-when="mat:custom">
            <x-calc.field name="E" label="Young's modulus" value="200" min="0" placeholder="Young's modulus">
                <label for="calc-E-unit" class="sr-only">Young's modulus unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mat:custom">
            <x-calc.field name="rho" label="Density" value="7850" min="0" placeholder="Density">
                <label for="calc-rho-unit" class="sr-only">Density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mat:custom">
            <x-calc.field name="nu" label="Poisson's ratio" value="0.29" min="0" step="any" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
    </div>

    <x-calc.result label="Longitudinal (P-wave) speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms', 'mat' => 'steel', 'E' => 200, 'E-unit' => 'gpa', 'rho' => 7850, 'rho-unit' => 'kgm3', 'nu' => 0.29],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'shear' => ['label' => 'Shear (S-wave) speed'],
            'bar' => ['label' => 'Thin-rod speed √(E/ρ)'],
            'Z' => ['label' => 'Acoustic impedance'],
            'props' => ['label' => 'Properties used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
