<x-calc.page
    title="Volume to Mass Calculator - SolveKit"
    description="Free volume to mass calculator: convert a volume of water, oil, fuel, metals, wood and more to mass."
    lede="Convert volume to mass."
    about="Mass is volume times density. Pick a substance or enter your own density."
    :calc="['engine' => 'ph-mat', 'tool' => 'volume_mass', 'fields' => ['sub', 'rho', 'V', 'out'], 'unitFields' => ['rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'V' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'speed', 'volume'])->all(), 'physics' => collect(config('physics_data'))->only(['densities'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much does 10 L of water weigh?', 'answer' => '9.982 kg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="sub" label="Material" :options="['water' => 'Water', 'seawater' => 'Sea water', 'ice' => 'Ice (0 °C)', 'petrol' => 'Petrol (gasoline)', 'diesel' => 'Diesel', 'ethanol' => 'Ethanol', 'olive_oil' => 'Olive oil', 'milk' => 'Milk', 'honey' => 'Honey', 'mercury' => 'Mercury', 'air' => 'Air (20 °C, 1 atm)', 'steel' => 'Steel', 'stainless' => 'Stainless steel', 'aluminium' => 'Aluminium', 'copper' => 'Copper', 'brass' => 'Brass', 'lead' => 'Lead', 'titanium' => 'Titanium', 'gold' => 'Gold', 'silver' => 'Silver', 'concrete' => 'Concrete', 'glass' => 'Glass', 'granite' => 'Granite', 'sand' => 'Dry sand (loose)', 'pine' => 'Pine wood', 'oak' => 'Oak wood', 'hdpe' => 'Polyethylene (HDPE)', 'pvc' => 'PVC', 'custom' => 'Other (enter the value)']" selected="water" />
        <div data-show-when="sub:custom">
            <x-calc.field name="rho" label="Density" value="1000" min="0" placeholder="Density">
                <label for="calc-rho-unit" class="sr-only">Density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="V" label="Volume" value="10" min="0" placeholder="Volume">
            <label for="calc-V-unit" class="sr-only">Volume unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
    </div>

    <x-calc.result label="Mass" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kg', 'sub' => 'water', 'rho' => 1000, 'rho-unit' => 'kgm3', 'V' => 10, 'V-unit' => 'l'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rho' => ['label' => 'Density used'],
            'weight' => ['label' => 'Weight'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
