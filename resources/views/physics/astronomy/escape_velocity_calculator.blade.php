<x-calc.page
    title="Escape Velocity Calculator - SolveKit"
    description="Free escape velocity calculator: the speed needed to escape any planet, moon or star, or a custom body."
    lede="Find escape velocity."
    about="Escape velocity is the launch speed at which kinetic energy equals the gravitational binding energy: √(2GM/r). It is √2 times the circular orbit speed at the same distance."
    :calc="['engine' => 'ph-astro', 'tool' => 'escape_velocity', 'fields' => ['body', 'M', 'R', 'h', 'out'], 'unitFields' => ['M' => collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun'])->all(), 'R' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all(), 'h' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all()], 'data' => ['units' => collect(config('units'))->only(['astro_mass', 'astronomical', 'energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['bodies'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is Earth’s escape velocity?', 'answer' => '11.1861 km/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="body" label="Body" :options="['sun' => 'Sun', 'mercury' => 'Mercury', 'venus' => 'Venus', 'earth' => 'Earth', 'moon' => 'Moon', 'mars' => 'Mars', 'ceres' => 'Ceres', 'jupiter' => 'Jupiter', 'io' => 'Io', 'europa' => 'Europa', 'ganymede' => 'Ganymede', 'saturn' => 'Saturn', 'titan' => 'Titan', 'uranus' => 'Uranus', 'neptune' => 'Neptune', 'pluto' => 'Pluto', 'custom' => 'Other (enter the value)']" selected="earth" />
        <div data-show-when="body:custom">
            <x-calc.field name="M" label="Mass" value="1" min="0" placeholder="Mass">
                <label for="calc-M-unit" class="sr-only">Mass unit</label>
                <select id="calc-M-unit" name="M-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mearth')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="body:custom">
            <x-calc.field name="R" label="Radius" value="6371" min="0" placeholder="Radius">
                <label for="calc-R-unit" class="sr-only">Radius unit</label>
                <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="h" label="Starting height above the surface" value="0" min="0" placeholder="Starting height above the surface">
            <label for="calc-h-unit" class="sr-only">Starting height above the surface unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kms" />
    </div>

    <x-calc.result label="Escape velocity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kms', 'body' => 'earth', 'M' => 1, 'M-unit' => 'mearth', 'R' => 6371, 'R-unit' => 'km', 'h' => 0, 'h-unit' => 'km'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'orbit' => ['label' => 'Circular orbit speed there'],
            'g' => ['label' => 'Surface gravity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
