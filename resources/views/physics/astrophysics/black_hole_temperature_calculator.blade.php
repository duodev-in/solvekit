<x-calc.page
    title="Black Hole Temperature Calculator - SolveKit"
    description="Free black hole temperature calculator: Hawking temperature, luminosity and evaporation time from mass."
    lede="Find a black hole’s Hawking temperature."
    about="Quantum effects make black holes glow faintly at T = ħc³/(8πGMk). Stellar black holes are far colder than the cosmic background; only tiny ones evaporate quickly."
    :calc="['engine' => 'ph-astro', 'tool' => 'bh_temperature', 'fields' => ['M', 'out'], 'unitFields' => ['M' => collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun'])->all()], 'data' => ['units' => collect(config('units'))->only(['astro_mass', 'astronomical', 'energy', 'force', 'length', 'mass', 'power', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How hot is a one-solar-mass black hole?', 'answer' => '6.17026 × 10⁻⁸ K.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="M" label="Black hole mass" value="1" min="0" placeholder="Black hole mass">
            <label for="calc-M-unit" class="sr-only">Black hole mass unit</label>
            <select id="calc-M-unit" name="M-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'msun')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="k" />
    </div>

    <x-calc.result label="Hawking temperature" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'k', 'M' => 1, 'M-unit' => 'msun'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rs' => ['label' => 'Schwarzschild radius'],
            'P' => ['label' => 'Hawking luminosity'],
            'life' => ['label' => 'Evaporation time'],
            'cmb' => ['label' => 'Compared with the 2.725 K cosmic background'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
