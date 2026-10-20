<x-calc.page
    title="Thermal Diffusivity Calculator - SolveKit"
    description="Free thermal diffusivity calculator: α = k/ρc_p for common materials, with heat penetration depth."
    lede="Find thermal diffusivity."
    about="Thermal diffusivity is how fast temperature changes spread through a material."
    :calc="['engine' => 'ph-thermo', 'tool' => 'thermal_diffusivity', 'fields' => ['mat', 'k', 'rho', 'cp'], 'unitFields' => ['k' => collect(config('units.thermal_conductivity'))->only(['wmk', 'btuhftf', 'calscmc', 'mwmk'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'cp' => collect(config('units.specific_heat'))->only(['jkgk', 'kjkgk', 'jgk', 'calgc', 'btulbf'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'specific_heat', 'speed', 'thermal_conductivity'])->all(), 'physics' => collect(config('physics_data'))->only(['thermal'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the diffusivity of concrete?', 'answer' => '6.917 × 10⁻⁷ m²/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mat" label="Material" :options="['copper' => 'Copper', 'aluminium' => 'Aluminium', 'brass' => 'Brass', 'steel' => 'Carbon steel', 'stainless' => 'Stainless steel 304', 'glass' => 'Glass', 'granite' => 'Granite', 'concrete' => 'Concrete', 'brick' => 'Brick', 'gypsum' => 'Gypsum plasterboard', 'pine' => 'Softwood (pine)', 'plywood' => 'Plywood', 'pvc' => 'PVC', 'mineral_wool' => 'Mineral wool', 'eps' => 'Expanded polystyrene (EPS)', 'pir' => 'Polyisocyanurate (PIR) board', 'ice' => 'Ice (0 °C)', 'water' => 'Water', 'air' => 'Air (still)', 'custom' => 'Other (enter the value)']" selected="concrete" />
        <div data-show-when="mat:custom">
            <x-calc.field name="k" label="Thermal conductivity" value="1" min="0" placeholder="Thermal conductivity">
                <label for="calc-k-unit" class="sr-only">Thermal conductivity unit</label>
                <select id="calc-k-unit" name="k-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.thermal_conductivity'))->only(['wmk', 'btuhftf', 'calscmc', 'mwmk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'wmk')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mat:custom">
            <x-calc.field name="rho" label="Density" value="2000" min="0" placeholder="Density">
                <label for="calc-rho-unit" class="sr-only">Density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mat:custom">
            <x-calc.field name="cp" label="Specific heat" value="1000" min="0" placeholder="Specific heat">
                <label for="calc-cp-unit" class="sr-only">Specific heat unit</label>
                <select id="calc-cp-unit" name="cp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.specific_heat'))->only(['jkgk', 'kjkgk', 'jgk', 'calgc', 'btulbf']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'jkgk')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Thermal diffusivity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mat' => 'concrete', 'k' => 1, 'k-unit' => 'wmk', 'rho' => 2000, 'rho-unit' => 'kgm3', 'cp' => 1000, 'cp-unit' => 'jkgk'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mm' => ['label' => 'In mm²/s'],
            'depth' => ['label' => 'Heat penetration in 1 hour (≈ √(αt))'],
            'eff' => ['label' => 'Thermal effusivity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
