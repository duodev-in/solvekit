<x-calc.page
    title="Universe Expansion Calculator - SolveKit"
    description="Free universe expansion calculator: age of the universe at any redshift, lookback time and distance in flat ΛCDM."
    lede="Explore cosmic expansion."
    about="Using the measured matter and dark-energy densities, the expansion history gives the age of the universe at any redshift. With Planck 2018 values the universe is 13.8 billion years old today."
    :calc="['engine' => 'ph-astro', 'tool' => 'universe_expansion', 'fields' => ['z', 'H0', 'Om'], 'data' => ['units' => collect(config('units'))->only(['astronomical', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How old was the universe at z = 1?', 'answer' => '5.841 billion years.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="z" label="Redshift z" value="1" min="0" step="any" />
        <x-calc.field name="H0" label="Hubble constant (km/s/Mpc)" value="67.4" min="0" step="any" />
        <x-calc.field name="Om" label="Matter density Ωm" value="0.315" min="0" step="any" />
    </div>

    <x-calc.result label="Age of the universe then" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['z' => 1, 'H0' => 67.4, 'Om' => 0.315],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Scale factor over time" name="scale" />
        <x-calc.rows heading="Details" :rows="[
            'now' => ['label' => 'Age today'],
            'lookback' => ['label' => 'Light travel time'],
            'dc' => ['label' => 'Distance today (comoving)'],
            'vrec' => ['label' => 'Recession speed today'],
            'Hz' => ['label' => 'Hubble rate then'],
            'a' => ['label' => 'Scale factor then'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
