<x-calc.page
    title="Surface Gravity Calculator - SolveKit"
    description="Free surface gravity calculator: gravity on any planet, moon or star, or a custom body from mass and radius."
    lede="Find surface gravity."
    about="Surface gravity is GM/r². Mars has about 38% of Earth’s gravity, the Moon about 17%."
    :calc="['engine' => 'ph-astro', 'tool' => 'surface_gravity', 'fields' => ['body', 'M', 'R', 'out'], 'unitFields' => ['M' => collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun'])->all(), 'R' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'astro_mass', 'astronomical', 'energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['bodies'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the gravity on Mars?', 'answer' => '3.72787 m/s².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="body" label="Body" :options="['sun' => 'Sun', 'mercury' => 'Mercury', 'venus' => 'Venus', 'earth' => 'Earth', 'moon' => 'Moon', 'mars' => 'Mars', 'ceres' => 'Ceres', 'jupiter' => 'Jupiter', 'io' => 'Io', 'europa' => 'Europa', 'ganymede' => 'Ganymede', 'saturn' => 'Saturn', 'titan' => 'Titan', 'uranus' => 'Uranus', 'neptune' => 'Neptune', 'pluto' => 'Pluto', 'custom' => 'Other (enter the value)']" selected="mars" />
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
        <x-calc.select name="out" label="Show the result in" :options="['ms2' => 'm/s²', 'cms2' => 'cm/s²', 'fts2' => 'ft/s²', 'ins2' => 'in/s²', 'kmhs' => 'km/h/s', 'mphs' => 'mph/s', 'g0' => 'g']" selected="ms2" />
    </div>

    <x-calc.result label="Surface gravity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms2', 'body' => 'mars', 'M' => 1, 'M-unit' => 'mearth', 'R' => 6371, 'R-unit' => 'km'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'g' => ['label' => 'Compared with Earth'],
            'jump' => ['label' => 'A 50 cm jump on Earth becomes'],
            'esc' => ['label' => 'Escape velocity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
