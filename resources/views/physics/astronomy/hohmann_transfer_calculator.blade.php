<x-calc.page
    title="Hohmann Transfer Calculator - SolveKit"
    description="Free Hohmann transfer calculator: the two burns, total delta-v and transfer time between circular orbits."
    lede="Plan a Hohmann transfer."
    about="A Hohmann transfer moves between two circular orbits with two burns along a half ellipse that touches both. It is the most efficient two-burn transfer for most ratios of orbit size."
    :calc="['engine' => 'ph-astro', 'tool' => 'hohmann', 'fields' => ['body', 'r1', 'r2', 'out'], 'unitFields' => ['r1' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all(), 'r2' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all()], 'data' => ['units' => collect(config('units'))->only(['astronomical', 'energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['bodies'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does LEO to GEO cost?', 'answer' => '3.89261 km/s in total.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="body" label="Body" :options="['sun' => 'Sun', 'mercury' => 'Mercury', 'venus' => 'Venus', 'earth' => 'Earth', 'moon' => 'Moon', 'mars' => 'Mars', 'ceres' => 'Ceres', 'jupiter' => 'Jupiter', 'io' => 'Io', 'europa' => 'Europa', 'ganymede' => 'Ganymede', 'saturn' => 'Saturn', 'titan' => 'Titan', 'uranus' => 'Uranus', 'neptune' => 'Neptune', 'pluto' => 'Pluto']" selected="earth" />
        <x-calc.field name="r1" label="Starting orbit radius (from the centre)" value="6678" min="0" placeholder="Starting orbit radius (from the centre)">
            <label for="calc-r1-unit" class="sr-only">Starting orbit radius (from the centre) unit</label>
            <select id="calc-r1-unit" name="r1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="r2" label="Target orbit radius" value="42164" min="0" placeholder="Target orbit radius">
            <label for="calc-r2-unit" class="sr-only">Target orbit radius unit</label>
            <select id="calc-r2-unit" name="r2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kms" />
    </div>

    <x-calc.result label="Total delta-v" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kms', 'body' => 'earth', 'r1' => 6678, 'r1-unit' => 'km', 'r2' => 42164, 'r2-unit' => 'km'],
        'Earth to Mars' => ['out' => 'kms', 'body' => 'sun', 'r1' => 1, 'r1-unit' => 'au', 'r2' => 1.524, 'r2-unit' => 'au'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'dv1' => ['label' => 'First burn'],
            'dv2' => ['label' => 'Second burn'],
            't' => ['label' => 'Transfer time'],
            'at' => ['label' => 'Transfer orbit semi-major axis'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
