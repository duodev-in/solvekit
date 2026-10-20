<x-calc.page
    title="Prandtl Number Calculator - SolveKit"
    description="Free Prandtl number calculator: Pr = c_pμ/k for common fluids or your own values."
    lede="Find the Prandtl number."
    about="The Prandtl number compares how fast momentum and heat diffuse. Air is about 0.7, water about 7, oils in the hundreds."
    :calc="['engine' => 'ph-fluid', 'tool' => 'prandtl', 'fields' => ['fluid', 'mu', 'cp', 'k'], 'unitFields' => ['mu' => collect(config('units.viscosity'))->only(['pas', 'mpas', 'cp', 'p', 'lbfts'])->all(), 'cp' => collect(config('units.specific_heat'))->only(['jkgk', 'kjkgk', 'jgk', 'calgc', 'btulbf'])->all(), 'k' => collect(config('units.thermal_conductivity'))->only(['wmk', 'btuhftf', 'calscmc', 'mwmk'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'specific_heat', 'speed', 'thermal_conductivity', 'viscosity'])->all(), 'physics' => collect(config('physics_data'))->only(['fluids'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is Pr of water?', 'answer' => '7.007.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="fluid" label="Fluid" :options="['water' => 'Water', 'seawater' => 'Sea water', 'air' => 'Air', 'ethanol' => 'Ethanol', 'glycerol' => 'Glycerol', 'engine_oil' => 'Engine oil (SAE 30)', 'olive_oil' => 'Olive oil', 'petrol' => 'Petrol (gasoline)', 'diesel' => 'Diesel', 'mercury' => 'Mercury', 'milk' => 'Milk', 'honey' => 'Honey', 'custom' => 'Other (enter the value)']" selected="water" />
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
        <div data-show-when="fluid:custom">
            <x-calc.field name="cp" label="Specific heat" value="4182" min="0" placeholder="Specific heat">
                <label for="calc-cp-unit" class="sr-only">Specific heat unit</label>
                <select id="calc-cp-unit" name="cp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.specific_heat'))->only(['jkgk', 'kjkgk', 'jgk', 'calgc', 'btulbf']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'jkgk')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="fluid:custom">
            <x-calc.field name="k" label="Thermal conductivity" value="0.6" min="0" placeholder="Thermal conductivity">
                <label for="calc-k-unit" class="sr-only">Thermal conductivity unit</label>
                <select id="calc-k-unit" name="k-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.thermal_conductivity'))->only(['wmk', 'btuhftf', 'calscmc', 'mwmk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'wmk')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Prandtl number" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fluid' => 'water', 'mu' => 1, 'mu-unit' => 'cp', 'cp' => 4182, 'cp-unit' => 'jkgk', 'k' => 0.6, 'k-unit' => 'wmk'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'meaning' => ['label' => 'Meaning'],
            'props' => ['label' => 'Properties used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
