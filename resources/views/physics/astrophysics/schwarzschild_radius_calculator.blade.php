<x-calc.page
    title="Schwarzschild Radius Calculator - SolveKit"
    description="Free Schwarzschild radius calculator: event horizon size of a black hole of any mass."
    lede="Find the event horizon radius."
    about="Squeezed inside r_s = 2GM/c², a mass becomes a black hole. For the Sun that is under 3 km; for Earth about 9 mm."
    :calc="['engine' => 'ph-astro', 'tool' => 'schwarzschild', 'fields' => ['M', 'out'], 'unitFields' => ['M' => collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun'])->all()], 'data' => ['units' => collect(config('units'))->only(['astro_mass', 'astronomical', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the Sun’s Schwarzschild radius?', 'answer' => '2.95325 km.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="M" label="Mass" value="1" min="0" placeholder="Mass">
            <label for="calc-M-unit" class="sr-only">Mass unit</label>
            <select id="calc-M-unit" name="M-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'msun')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'au' => 'AU', 'ly' => 'ly', 'pc' => 'pc', 'mpc' => 'Mpc', 'mi' => 'mi']" selected="km" />
    </div>

    <x-calc.result label="Schwarzschild radius" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'km', 'M' => 1, 'M-unit' => 'msun'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'photon' => ['label' => 'Photon sphere (1.5 r_s)'],
            'isco' => ['label' => 'Innermost stable orbit (3 r_s)'],
            'rho' => ['label' => 'Mean density inside r_s'],
            'tidal' => ['label' => 'Tidal stretch at r_s (per metre)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
