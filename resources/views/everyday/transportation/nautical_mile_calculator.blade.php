<x-calc.page
    title="Nautical Mile Calculator - SolveKit"
    description="Free nautical mile calculator: convert to nautical miles, find the great-circle distance between two coordinates, and the sailing time at a speed in knots."
    lede="Work in nautical miles: convert, measure between coordinates and time a passage."
    about="A nautical mile is exactly 1,852 m, originally one minute of latitude, and a knot is one nautical mile an hour. The distance between two points is the great-circle distance on a sphere of mean Earth radius (6,371 km), accurate to about 0.5%."
    :calc="['engine' => 'ev-transport', 'tool' => 'nautical', 'fields' => ['mode', 'distance', 'lat1', 'lon1', 'lat2', 'lon2', 'knots'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose convert or two points', 'text' => 'Coordinates in decimal degrees.'],
        ['name' => 'Add a speed', 'text' => 'For the passage time.'],
    ]"
    :faqs="[
        ['question' => 'How many km is a nautical mile?', 'answer' => '1.852 km exactly.'],
        ['question' => 'How far is Portsmouth to Cherbourg?', 'answer' => 'About 72 nautical miles in a straight line.'],
        ['question' => 'How long at 6 knots?', 'answer' => 'About 12 hours for 72 nmi.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['convert' => 'Convert a distance', 'coordinates' => 'Between two points']" selected="convert" />

    <div data-show-when="mode:convert">
        <x-calc.field name="distance" label="Distance" value="100" min="0" placeholder="Distance">
            <label for="calc-distance-unit" class="sr-only">Distance unit</label>
            <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="mode:coordinates" hidden>
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
            <x-calc.field name="lat1" label="Latitude 1" value="50.8" min="-90" max="90" step="any" suffix="°" />
            <x-calc.field name="lon1" label="Longitude 1" value="-1.1" min="-180" max="180" step="any" suffix="°" />
            <x-calc.field name="lat2" label="Latitude 2" value="49.65" min="-90" max="90" step="any" suffix="°" />
            <x-calc.field name="lon2" label="Longitude 2" value="-1.62" min="-180" max="180" step="any" suffix="°" />
        </div>
    </div>

    <x-calc.field name="knots" label="Speed (optional)" value="6" min="0" step="0.1" suffix="knots" />

    <x-calc.result label="Nautical miles" />

    <x-calc.options :examples="[
        '100 km' => ['mode' => 'convert', 'distance' => 100, 'distance-unit' => 'km', 'lat1' => '', 'lon1' => '', 'lat2' => '', 'lon2' => '', 'knots' => 6],
        'Portsmouth → Cherbourg' => ['mode' => 'coordinates', 'distance' => '', 'distance-unit' => 'km', 'lat1' => 50.8, 'lon1' => -1.1, 'lat2' => 49.65, 'lon2' => -1.62, 'knots' => 6],
        '250 statute miles' => ['mode' => 'convert', 'distance' => 250, 'distance-unit' => 'mi', 'lat1' => '', 'lon1' => '', 'lat2' => '', 'lon2' => '', 'knots' => 18],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'time' => ['label' => 'Time'],
            'degrees' => ['label' => 'Arc'],
            'definition' => ['label' => 'Definition'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 nmi = 1,852 m</li>
            <li>great circle: haversine formula</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
