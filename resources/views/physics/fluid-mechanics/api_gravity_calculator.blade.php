<x-calc.page
    title="API Gravity Calculator - SolveKit"
    description="Free API gravity calculator: convert between API gravity, specific gravity and density of petroleum liquids."
    lede="Find API gravity."
    about="API gravity grades crude oils and fuels: 141.5/SG − 131.5 at 60 °F. Above 10° a liquid floats on water; light crudes are above 31°."
    :calc="['engine' => 'ph-fluid', 'tool' => 'api_gravity', 'fields' => ['mode', 'sg', 'rho', 'api'], 'unitFields' => ['rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the API gravity of SG 0.85?', 'answer' => '34.97°.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['sg' => 'Specific gravity (60 °F)', 'rho' => 'Density at 60 °F', 'api' => 'API gravity']" selected="sg" />
        <div data-show-when="mode:sg">
            <x-calc.field name="sg" label="Specific gravity" value="0.85" min="0" step="any" />
        </div>
        <div data-show-when="mode:rho">
            <x-calc.field name="rho" label="Density" value="850" min="0" placeholder="Density">
                <label for="calc-rho-unit" class="sr-only">Density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:api">
            <x-calc.field name="api" label="API gravity (°)" value="35" step="any" />
        </div>
    </div>

    <x-calc.result label="API gravity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'sg', 'sg' => 0.85, 'rho' => 850, 'rho-unit' => 'kgm3', 'api' => 35],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sg' => ['label' => 'Specific gravity'],
            'rho' => ['label' => 'Density'],
            'grade' => ['label' => 'Grade'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
