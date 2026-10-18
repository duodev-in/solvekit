<x-calc.page
    title="Drive Time Calculator - SolveKit"
    description="Free drive time calculator: driving time for a distance at an average speed, with rest breaks, and your arrival time."
    lede="Work out how long a drive takes and when you will arrive."
    about="Driving time = distance ÷ average speed. Use a realistic average (lower than the speed limit) to allow for traffic and towns. Breaks are added each time the set driving time passes; road-safety groups suggest a 15-minute break every 2 hours."
    :calc="['engine' => 'ev-transport', 'tool' => 'drive_time', 'fields' => ['distance', 'speed', 'break_every', 'break_minutes', 'depart'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all(), 'speed' => collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms'])->all()]]"
    :how-to="[
        ['name' => 'Enter the distance and speed', 'text' => 'A realistic average.'],
        ['name' => 'Add breaks and a departure time', 'text' => 'To see when you will arrive.'],
    ]"
    :faqs="[
        ['question' => 'How long does it take to drive 420 miles?', 'answer' => '7 hours at 60 mph, 7 h 45 min with three 15-minute breaks.'],
        ['question' => 'How often should I take a break?', 'answer' => 'About every 2 hours on long drives.'],
        ['question' => 'What average speed should I use?', 'answer' => 'Highway trips often average 55–65 mph including slowdowns.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="distance" label="Distance" value="420" min="0" placeholder="Distance">
            <label for="calc-distance-unit" class="sr-only">Distance unit</label>
            <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="speed" label="Average speed" value="60" min="0" placeholder="Average speed">
            <label for="calc-speed-unit" class="sr-only">Average speed unit</label>
            <select id="calc-speed-unit" name="speed-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mph')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="break_every" label="Break every" value="2" min="0" step="0.5" suffix="hours" />
        <x-calc.field name="break_minutes" label="Break length" value="15" min="0" step="5" suffix="min" />
    </div>

    <x-calc.field name="depart" label="Departure (optional)" value="2026-12-23T07:00" type="datetime-local" />

    <x-calc.result label="Total travel time" />

    <x-calc.options :examples="[
        '420 mi at 60 mph' => ['distance' => 420, 'distance-unit' => 'mi', 'speed' => 60, 'speed-unit' => 'mph', 'break_every' => 2, 'break_minutes' => 15, 'depart' => '2026-12-23T07:00'],
        '650 km at 95 km/h' => ['distance' => 650, 'distance-unit' => 'km', 'speed' => 95, 'speed-unit' => 'kmh', 'break_every' => 2, 'break_minutes' => 20, 'depart' => '2026-08-01T06:30'],
        'Short trip, no breaks' => ['distance' => 85, 'distance-unit' => 'mi', 'speed' => 50, 'speed-unit' => 'mph', 'break_every' => 0, 'break_minutes' => 0, 'depart' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'arrive' => ['label' => 'Arrival'],
            'driving' => ['label' => 'Driving time'],
            'distance' => ['label' => 'Distance'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>time = distance ÷ speed + breaks</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
