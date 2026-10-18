<x-calc.page
    title="Miles to Hours Converter - SolveKit"
    description="Free miles to hours converter: travel time for a distance at a speed, in hours and minutes, with pace per mile."
    lede="Find how many hours a distance takes at a given speed."
    about="Time = distance ÷ speed: 150 miles at 60 mph is 2.5 hours (2 h 30 min). Pace per mile = 60 ÷ mph minutes."
    :calc="['engine' => 'ev-transport', 'tool' => 'miles_to_hours', 'fields' => ['distance', 'speed'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all(), 'speed' => collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms'])->all()]]"
    :how-to="[
        ['name' => 'Enter the distance', 'text' => 'In miles or km.'],
        ['name' => 'Enter the speed', 'text' => 'Average speed.'],
    ]"
    :faqs="[
        ['question' => 'How long is 150 miles at 60 mph?', 'answer' => '2 hours 30 minutes.'],
        ['question' => 'How long to walk a mile?', 'answer' => 'About 20 minutes at 3 mph.'],
        ['question' => 'How long is 100 km at 80 km/h?', 'answer' => '1 hour 15 minutes.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="distance" label="Distance" value="150" min="0" placeholder="Distance">
            <label for="calc-distance-unit" class="sr-only">Distance unit</label>
            <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="speed" label="Speed" value="60" min="0" placeholder="Speed">
            <label for="calc-speed-unit" class="sr-only">Speed unit</label>
            <select id="calc-speed-unit" name="speed-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mph')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Travel time" />

    <x-calc.options :examples="[
        '150 mi at 60 mph' => ['distance' => 150, 'distance-unit' => 'mi', 'speed' => 60, 'speed-unit' => 'mph'],
        'Walk 5 mi at 3 mph' => ['distance' => 5, 'distance-unit' => 'mi', 'speed' => 3, 'speed-unit' => 'mph'],
        '100 km at 80 km/h' => ['distance' => 100, 'distance-unit' => 'km', 'speed' => 80, 'speed-unit' => 'kmh'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hours' => ['label' => 'Hours'],
            'minutes' => ['label' => 'Minutes'],
            'pace' => ['label' => 'Pace'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hours = miles ÷ mph</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
