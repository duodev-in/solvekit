<x-calc.page
    title="Shear Wave Velocity Calculator - SolveKit"
    description="Free shear wave velocity calculator: v_s = √(G/ρ) for metals, soils and rock."
    lede="Find the shear wave speed."
    about="Shear (S) waves travel at √(G/ρ). Geotechnical engineers classify soil stiffness by the average shear wave velocity in the top 30 m."
    :calc="['engine' => 'ph-mat', 'tool' => 'shear_wave', 'fields' => ['mode', 'mat', 'G', 'rho', 'out'], 'unitFields' => ['G' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['materials'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast are shear waves in structural steel?', 'answer' => '3,179.65 m/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Material" :options="['list' => 'Pick a material', 'custom' => 'Enter G and density']" selected="list" />
        <div data-show-when="mode:list">
            <x-calc.select name="mat" label="Material" :options="['a36' => 'Structural steel (A36)', 'steel_4140' => 'Alloy steel 4140 (quenched and tempered)', 'ss304' => 'Stainless steel 304 (annealed)', 'al6061' => 'Aluminium 6061-T6', 'al7075' => 'Aluminium 7075-T6', 'copper' => 'Copper (annealed)', 'brass' => 'Brass C360 (free-cutting)', 'ti64' => 'Titanium Ti-6Al-4V', 'cast_iron' => 'Grey cast iron (class 30)', 'concrete' => 'Concrete (30 MPa)', 'glass' => 'Soda-lime glass', 'nylon' => 'Nylon 6/6', 'pvc' => 'Rigid PVC', 'oak' => 'Oak (along the grain)']" selected="a36" />
        </div>
        <div data-show-when="mode:custom">
            <x-calc.field name="G" label="Shear modulus" value="0.1" min="0" placeholder="Shear modulus">
                <label for="calc-G-unit" class="sr-only">Shear modulus unit</label>
                <select id="calc-G-unit" name="G-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:custom">
            <x-calc.field name="rho" label="Density" value="1900" min="0" placeholder="Density">
                <label for="calc-rho-unit" class="sr-only">Density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
    </div>

    <x-calc.result label="Shear wave velocity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms', 'mode' => 'list', 'mat' => 'a36', 'G' => 0.1, 'G-unit' => 'gpa', 'rho' => 1900, 'rho-unit' => 'kgm3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'G' => ['label' => 'Shear modulus used'],
            'soil' => ['label' => 'Soil classes (Vs30)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
