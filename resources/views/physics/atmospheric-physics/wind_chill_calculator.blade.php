<x-calc.page
    title="Wind Chill Calculator - SolveKit"
    description="Free wind chill calculator: how cold it feels in wind, with frostbite risk."
    lede="Find the wind chill."
    about="Wind strips heat from exposed skin. The 2001 North American wind chill index gives the temperature that would feel the same in calm air."
    :calc="['engine' => 'ph-thermo', 'tool' => 'wind_chill', 'fields' => ['T', 'v', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does −10 °C with 30 km/h wind feel like?', 'answer' => '−19.5205 °C.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="T" label="Air temperature" value="-10" placeholder="Air temperature">
            <label for="calc-T-unit" class="sr-only">Air temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Wind speed (10 m height)" value="30" placeholder="Wind speed (10 m height)">
            <label for="calc-v-unit" class="sr-only">Wind speed (10 m height) unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
    </div>

    <x-calc.result label="Wind chill" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'c', 'T' => -10, 'T-unit' => 'c', 'v' => 30, 'v-unit' => 'kmh'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'frost' => ['label' => 'Frostbite risk'],
            'valid' => ['label' => 'Validity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
