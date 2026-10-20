<x-calc.page
    title="Earth Orbit Calculator - SolveKit"
    description="Free Earth orbit calculator: orbital speed and period for any altitude, or the altitude for a period."
    lede="Find speed and period of an Earth orbit."
    about="In a circular orbit gravity supplies exactly the centripetal force, so v = √(GM/r). The ISS at about 420 km circles the Earth every 93 minutes; a geostationary satellite at 35,786 km takes one sidereal day."
    :calc="['engine' => 'ph-astro', 'tool' => 'earth_orbit', 'fields' => ['mode', 'h', 'T', 'out'], 'unitFields' => ['h' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all(), 'T' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['astronomical', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast does the ISS move?', 'answer' => '7.65727 km/s, Period 92.9704 min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['h' => 'The altitude', 'T' => 'The period']" selected="h" />
        <div data-show-when="mode:h">
            <x-calc.field name="h" label="Altitude" value="420" min="0" placeholder="Altitude">
                <label for="calc-h-unit" class="sr-only">Altitude unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:T">
            <x-calc.field name="T" label="Period" value="92.7" placeholder="Period">
                <label for="calc-T-unit" class="sr-only">Period unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'min')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kms" />
    </div>

    <x-calc.result label="Orbital speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kms', 'mode' => 'h', 'h' => 420, 'h-unit' => 'km', 'T' => 92.7, 'T-unit' => 'min'],
        'Geostationary' => ['out' => 'kms', 'mode' => 'T', 'h' => 420, 'h-unit' => 'km', 'T' => 1436.07, 'T-unit' => 'min'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'T' => ['label' => 'Period'],
            'h' => ['label' => 'Altitude'],
            'orbits' => ['label' => 'Orbits per day'],
            'g' => ['label' => 'Gravity at that height'],
            'esc' => ['label' => 'Escape velocity there'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
