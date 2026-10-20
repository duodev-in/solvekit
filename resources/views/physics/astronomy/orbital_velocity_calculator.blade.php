<x-calc.page
    title="Orbital Velocity Calculator - SolveKit"
    description="Free orbital velocity calculator: speed at any point of a circular or elliptical orbit from the vis-viva equation."
    lede="Find orbital speed with vis-viva."
    about="The vis-viva equation v² = GM(2/r − 1/a) gives the speed anywhere on an orbit. For a circle r = a and it reduces to √(GM/r)."
    :calc="['engine' => 'ph-astro', 'tool' => 'orbital_velocity', 'fields' => ['body', 'r', 'a', 'out'], 'unitFields' => ['r' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all(), 'a' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all()], 'data' => ['units' => collect(config('units'))->only(['astronomical', 'energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['bodies'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast is a 400 km circular orbit?', 'answer' => '7.66864 km/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="body" label="Body" :options="['sun' => 'Sun', 'mercury' => 'Mercury', 'venus' => 'Venus', 'earth' => 'Earth', 'moon' => 'Moon', 'mars' => 'Mars', 'ceres' => 'Ceres', 'jupiter' => 'Jupiter', 'io' => 'Io', 'europa' => 'Europa', 'ganymede' => 'Ganymede', 'saturn' => 'Saturn', 'titan' => 'Titan', 'uranus' => 'Uranus', 'neptune' => 'Neptune', 'pluto' => 'Pluto']" selected="earth" />
        <x-calc.field name="r" label="Current distance from the centre" value="6778" min="0" placeholder="Current distance from the centre">
            <label for="calc-r-unit" class="sr-only">Current distance from the centre unit</label>
            <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="a" label="Semi-major axis (equal to the distance for a circle)" value="6778" min="0" placeholder="Semi-major axis (equal to the distance for a circle)">
            <label for="calc-a-unit" class="sr-only">Semi-major axis (equal to the distance for a circle) unit</label>
            <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kms" />
    </div>

    <x-calc.result label="Orbital speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kms', 'body' => 'earth', 'r' => 6778, 'r-unit' => 'km', 'a' => 6778, 'a-unit' => 'km'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'circ' => ['label' => 'Circular speed at that distance'],
            'esc' => ['label' => 'Escape speed there'],
            'T' => ['label' => 'Period'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
