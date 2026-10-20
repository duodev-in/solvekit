<x-calc.page
    title="Y+ Calculator - SolveKit"
    description="Free y+ calculator: first cell height for a CFD mesh from flow speed, length and target y+."
    lede="Find the first cell height for CFD."
    about="Wall-resolved turbulence models need the first mesh cell at y⁺ ≈ 1; wall functions want 30–300. The flat-plate skin friction estimate gives the height to start with."
    :calc="['engine' => 'ph-fluid', 'tool' => 'yplus', 'fields' => ['U', 'L', 'yp', 'fluid', 'rho', 'mu', 'out'], 'unitFields' => ['U' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'mu' => collect(config('units.viscosity'))->only(['pas', 'mpas', 'cp', 'p', 'lbfts'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'speed', 'viscosity'])->all(), 'physics' => collect(config('physics_data'))->only(['fluids'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What first cell height gives y⁺ = 1 for air at 20 m/s over 1 m?', 'answer' => '0.0178334 mm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="U" label="Free-stream velocity" value="20" placeholder="Free-stream velocity">
            <label for="calc-U-unit" class="sr-only">Free-stream velocity unit</label>
            <select id="calc-U-unit" name="U-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="L" label="Reference length" value="1" placeholder="Reference length">
            <label for="calc-L-unit" class="sr-only">Reference length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="yp" label="Target y+" value="1" min="0" step="any" />
        <x-calc.select name="fluid" label="Fluid" :options="['water' => 'Water', 'seawater' => 'Sea water', 'air' => 'Air', 'ethanol' => 'Ethanol', 'glycerol' => 'Glycerol', 'engine_oil' => 'Engine oil (SAE 30)', 'olive_oil' => 'Olive oil', 'petrol' => 'Petrol (gasoline)', 'diesel' => 'Diesel', 'mercury' => 'Mercury', 'milk' => 'Milk', 'honey' => 'Honey', 'custom' => 'Other (enter the value)']" selected="air" />
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
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
    </div>

    <x-calc.result label="First cell height" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mm', 'U' => 20, 'U-unit' => 'ms', 'L' => 1, 'L-unit' => 'm', 'yp' => 1, 'fluid' => 'air', 'rho' => 1000, 'rho-unit' => 'kgm3', 'mu' => 1, 'mu-unit' => 'cp'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'Re' => ['label' => 'Reynolds number'],
            'cf' => ['label' => 'Skin friction coefficient'],
            'ut' => ['label' => 'Friction velocity'],
            'tw' => ['label' => 'Wall shear stress'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
