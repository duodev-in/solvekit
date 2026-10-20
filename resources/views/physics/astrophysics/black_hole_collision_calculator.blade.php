<x-calc.page
    title="Black Hole Collision Calculator - SolveKit"
    description="Free black hole merger calculator: final mass, spin and gravitational-wave energy of two merging non-spinning black holes."
    lede="Estimate a black hole merger."
    about="When two black holes merge a few percent of their mass is radiated as gravitational waves. This estimate fits the exact small-mass limit and numerical relativity at equal masses, and reproduces GW150914 (36 + 29 M☉ → 62 M☉, 3 M☉ radiated)."
    :calc="['engine' => 'ph-astro', 'tool' => 'bh_collision', 'fields' => ['m1', 'm2', 'out'], 'unitFields' => ['m1' => collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun'])->all(), 'm2' => collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun'])->all()], 'data' => ['units' => collect(config('units'))->only(['astro_mass', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What happens when 36 and 29 M☉ black holes merge?', 'answer' => 'They form about 61.9145 M☉; 4.75% of the mass radiated as gravitational waves.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m1" label="First black hole mass" value="36" min="0" placeholder="First black hole mass">
            <label for="calc-m1-unit" class="sr-only">First black hole mass unit</label>
            <select id="calc-m1-unit" name="m1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'msun')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="m2" label="Second black hole mass" value="29" min="0" placeholder="Second black hole mass">
            <label for="calc-m2-unit" class="sr-only">Second black hole mass unit</label>
            <select id="calc-m2-unit" name="m2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'msun')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['kg' => 'kg', 't' => 't', 'mmoon' => 'M☾', 'mearth' => 'M⊕', 'mjup' => 'M♃', 'msun' => 'M☉']" selected="msun" />
    </div>

    <x-calc.result label="Final black hole mass" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'msun', 'm1' => 36, 'm1-unit' => 'msun', 'm2' => 29, 'm2-unit' => 'msun'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'E' => ['label' => 'Energy radiated as gravitational waves'],
            'Em' => ['label' => 'Radiated mass-energy'],
            'spin' => ['label' => 'Final spin (dimensionless)'],
            'eta' => ['label' => 'Symmetric mass ratio η'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
