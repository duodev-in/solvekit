<x-calc.page
    title="Stokes' Law Calculator - SolveKit"
    description="Free Stokes' law calculator: settling velocity of small particles in a fluid."
    lede="Find settling velocity."
    about="Small particles settle at a steady speed where drag balances buoyant weight: v = 2(ρ_p − ρ_f)gr²/9μ. It holds while the particle Reynolds number stays below 1."
    :calc="['engine' => 'ph-fluid', 'tool' => 'stokes', 'fields' => ['r', 'rhop', 'fluid', 'rho', 'mu', 'out'], 'unitFields' => ['r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'rhop' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'mu' => collect(config('units.viscosity'))->only(['pas', 'mpas', 'cp', 'p', 'lbfts'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'speed', 'viscosity'])->all(), 'physics' => collect(config('physics_data'))->only(['fluids'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast does 25 µm sand settle in water?', 'answer' => '0.224532 cm/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="r" label="Particle radius" value="25" placeholder="Particle radius">
            <label for="calc-r-unit" class="sr-only">Particle radius unit</label>
            <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'um')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rhop" label="Particle density" value="2650" min="0" placeholder="Particle density">
            <label for="calc-rhop-unit" class="sr-only">Particle density unit</label>
            <select id="calc-rhop-unit" name="rhop-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="fluid" label="Fluid" :options="['water' => 'Water', 'seawater' => 'Sea water', 'air' => 'Air', 'ethanol' => 'Ethanol', 'glycerol' => 'Glycerol', 'engine_oil' => 'Engine oil (SAE 30)', 'olive_oil' => 'Olive oil', 'petrol' => 'Petrol (gasoline)', 'diesel' => 'Diesel', 'mercury' => 'Mercury', 'milk' => 'Milk', 'honey' => 'Honey', 'custom' => 'Other (enter the value)']" selected="water" />
        <div data-show-when="fluid:custom">
            <x-calc.field name="rho" label="Fluid density" value="1000" min="0" placeholder="Fluid density">
                <label for="calc-rho-unit" class="sr-only">Fluid density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="fluid:custom">
            <x-calc.field name="mu" label="Dynamic viscosity" value="1" min="0" placeholder="Dynamic viscosity">
                <label for="calc-mu-unit" class="sr-only">Dynamic viscosity unit</label>
                <select id="calc-mu-unit" name="mu-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.viscosity'))->only(['pas', 'mpas', 'cp', 'p', 'lbfts']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cp')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="cms" />
    </div>

    <x-calc.result label="Settling velocity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'cms', 'r' => 25, 'r-unit' => 'um', 'rhop' => 2650, 'rhop-unit' => 'kgm3', 'fluid' => 'water', 'rho' => 1000, 'rho-unit' => 'kgm3', 'mu' => 1, 'mu-unit' => 'cp'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'Re' => ['label' => 'Particle Reynolds number'],
            'valid' => ['label' => 'Stokes law valid?'],
            't1' => ['label' => 'Time to settle 1 m'],
            'F' => ['label' => 'Drag force at that speed'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
