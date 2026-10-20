<x-calc.page
    title="Hubble Law Distance Calculator - SolveKit"
    description="Free Hubble law calculator: distance to a galaxy from redshift or recession velocity, with full ΛCDM cosmology."
    lede="Find distance from redshift."
    about="Distant galaxies recede at speeds proportional to their distance, v = H₀d. Beyond small redshifts the expansion history matters, so this integrates the flat ΛCDM model (Planck 2018 parameters by default)."
    :calc="['engine' => 'ph-astro', 'tool' => 'hubble_distance', 'fields' => ['mode', 'z', 'v', 'H0', 'Om', 'out'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['astronomical', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How far is a galaxy at z = 0.05?', 'answer' => '716,716,000 ly.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['z' => 'Redshift z', 'v' => 'Recession velocity']" selected="z" />
        <div data-show-when="mode:z">
            <x-calc.field name="z" label="Redshift z" value="0.05" min="0" step="any" />
        </div>
        <div data-show-when="mode:v">
            <x-calc.field name="v" label="Recession velocity" value="15000" placeholder="Recession velocity">
                <label for="calc-v-unit" class="sr-only">Recession velocity unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="H0" label="Hubble constant (km/s/Mpc)" value="67.4" min="0" step="any" />
        <x-calc.field name="Om" label="Matter density Ωm" value="0.315" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'au' => 'AU', 'ly' => 'ly', 'pc' => 'pc', 'mpc' => 'Mpc', 'mi' => 'mi']" selected="ly" />
    </div>

    <x-calc.result label="Comoving (proper, today) distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ly', 'mode' => 'z', 'z' => 0.05, 'v' => 15000, 'v-unit' => 'kms', 'H0' => 67.4, 'Om' => 0.315],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'simple' => ['label' => 'Simple Hubble law cz ÷ H₀'],
            'lum' => ['label' => 'Luminosity distance'],
            'mpc' => ['label' => 'In megaparsecs'],
            'lookback' => ['label' => 'Light travel time'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
