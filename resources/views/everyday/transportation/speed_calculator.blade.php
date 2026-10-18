<x-calc.page
    title="Speed Calculator - SolveKit"
    description="Free speed calculator: find speed, distance or time from the other two, in mph, km/h, m/s and knots, with pace per mile and km."
    lede="Find speed, distance or time from the other two."
    about="Speed = distance ÷ time, distance = speed × time, time = distance ÷ speed. Results are shown in mph, km/h, m/s and knots, with running pace."
    :calc="['engine' => 'ev-transport', 'tool' => 'speed', 'fields' => ['find', 'distance', 'speed', 'h', 'm', 's'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all(), 'speed' => collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => 'Speed, distance or time.'],
        ['name' => 'Enter the other two', 'text' => 'In any units.'],
    ]"
    :faqs="[
        ['question' => 'What speed is a 3:45 marathon?', 'answer' => '6.99 mph (11.25 km/h), about 8:35 per mile.'],
        ['question' => 'How far in 2 hours at 60 mph?', 'answer' => '120 miles.'],
        ['question' => 'How do I convert mph to km/h?', 'answer' => 'Multiply by 1.609344.'],
    ]"
>
    <x-calc.segmented name="find" legend="Find" :options="['speed' => 'Speed', 'distance' => 'Distance', 'time' => 'Time']" selected="speed" />

    <div data-show-when="find:speed,time">
        <x-calc.field name="distance" label="Distance" value="26.2" min="0" placeholder="Distance">
            <label for="calc-distance-unit" class="sr-only">Distance unit</label>
            <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="find:distance,time" hidden>
        <x-calc.field name="speed" label="Speed" value="60" min="0" placeholder="Speed">
            <label for="calc-speed-unit" class="sr-only">Speed unit</label>
            <select id="calc-speed-unit" name="speed-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mph')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="find:speed,distance">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="h" label="Hours" value="3" min="0" step="1" />
            <x-calc.field name="m" label="Minutes" value="45" min="0" max="59" step="1" />
            <x-calc.field name="s" label="Seconds" value="0" min="0" max="59" step="1" />
        </div>
    </div>

    <x-calc.result label="Speed" />

    <x-calc.options :examples="[
        'Marathon in 3:45' => ['find' => 'speed', 'distance' => 26.2, 'distance-unit' => 'mi', 'speed' => '', 'speed-unit' => 'mph', 'h' => 3, 'm' => 45, 's' => 0],
        '2 h at 60 mph' => ['find' => 'distance', 'distance' => '', 'distance-unit' => 'mi', 'speed' => 60, 'speed-unit' => 'mph', 'h' => 2, 'm' => 0, 's' => 0],
        '400 km at 100 km/h' => ['find' => 'time', 'distance' => 400, 'distance-unit' => 'km', 'speed' => 100, 'speed-unit' => 'kmh', 'h' => '', 'm' => '', 's' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kmh' => ['label' => 'km/h'],
            'ms' => ['label' => 'm/s'],
            'knots' => ['label' => 'Knots'],
            'pace' => ['label' => 'Pace'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>v = d ÷ t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
