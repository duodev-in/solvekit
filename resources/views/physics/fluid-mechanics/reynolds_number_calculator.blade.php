<x-calc.page
    title="Reynolds Number Calculator - SolveKit"
    description="Free Reynolds number calculator: Re = ρvL/μ and whether pipe flow is laminar or turbulent."
    lede="Find the Reynolds number."
    about="The Reynolds number compares inertia with viscosity. In pipes flow is laminar below about 2,300 and turbulent above about 4,000."
    :calc="['engine' => 'ph-fluid', 'tool' => 'reynolds', 'fields' => ['v', 'L', 'fluid', 'rho', 'mu'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'mu' => collect(config('units.viscosity'))->only(['pas', 'mpas', 'cp', 'p', 'lbfts'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'speed', 'viscosity'])->all(), 'physics' => collect(config('physics_data'))->only(['fluids'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is Re for water at 1 m/s in 50 mm?', 'answer' => '49,810.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="v" label="Velocity" value="1" placeholder="Velocity">
            <label for="calc-v-unit" class="sr-only">Velocity unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="L" label="Characteristic length (pipe diameter)" value="50" placeholder="Characteristic length (pipe diameter)">
            <label for="calc-L-unit" class="sr-only">Characteristic length (pipe diameter) unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
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
    </div>

    <x-calc.result label="Reynolds number" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['v' => 1, 'v-unit' => 'ms', 'L' => 50, 'L-unit' => 'mm', 'fluid' => 'water', 'rho' => 1000, 'rho-unit' => 'kgm3', 'mu' => 1, 'mu-unit' => 'cp'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'regime' => ['label' => 'Pipe flow regime'],
            'nu' => ['label' => 'Kinematic viscosity used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
