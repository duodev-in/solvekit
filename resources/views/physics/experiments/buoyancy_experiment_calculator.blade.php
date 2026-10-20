<x-calc.page
    title="Buoyancy Experiment Calculator - SolveKit"
    description="Free buoyancy experiment calculator: object density and volume from spring-scale readings in air and water."
    lede="Find density by weighing in water."
    about="Weigh an object in air, then hanging in water. The difference is the weight of water it displaces, which gives its volume and density, just as Archimedes tested the crown."
    :calc="['engine' => 'ph-quantum', 'tool' => 'buoyancy_experiment', 'fields' => ['Wair', 'Wwater', 'rho', 'out'], 'unitFields' => ['Wair' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'Wwater' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What density gives 500 g in air and 315 g in water?', 'answer' => '2.69784 g/cm³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Wair" label="Scale reading in air" value="500" min="0" placeholder="Scale reading in air">
            <label for="calc-Wair-unit" class="sr-only">Scale reading in air unit</label>
            <select id="calc-Wair-unit" name="Wair-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Wwater" label="Scale reading in water" value="315" min="0" placeholder="Scale reading in water">
            <label for="calc-Wwater-unit" class="sr-only">Scale reading in water unit</label>
            <select id="calc-Wwater-unit" name="Wwater-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rho" label="Water density" value="998.2" min="0" placeholder="Water density">
            <label for="calc-rho-unit" class="sr-only">Water density unit</label>
            <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['kgm3' => 'kg/m³', 'gcm3' => 'g/cm³', 'lbft3' => 'lb/ft³', 'lbin3' => 'lb/in³', 'lbgal' => 'lb/gal']" selected="gcm3" />
    </div>

    <x-calc.result label="Object density" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'gcm3', 'Wair' => 500, 'Wair-unit' => 'g', 'Wwater' => 315, 'Wwater-unit' => 'g', 'rho' => 998.2, 'rho-unit' => 'kgm3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'V' => ['label' => 'Object volume'],
            'like' => ['label' => 'Close to'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
