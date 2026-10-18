<x-calc.page
    title="Engine Hours to Miles Converter - SolveKit"
    description="Free engine hours to miles converter: equivalent mileage of a vehicle, boat or machine from its engine hours and an average speed."
    lede="Turn engine hours into equivalent miles."
    about="Equivalent miles = engine hours × average speed. There is no single standard: fleets often use 25–35 mph for road vehicles, and much less for police cars, work trucks and machines that idle a lot. Use your vehicle's own average if its trip computer shows one."
    :calc="['engine' => 'ev-transport', 'tool' => 'engine_hours', 'fields' => ['hours', 'speed'], 'unitFields' => ['speed' => collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms'])->all()]]"
    :how-to="[
        ['name' => 'Enter the engine hours', 'text' => 'From the hour meter.'],
        ['name' => 'Choose an average speed', 'text' => 'Lower for vehicles that idle often.'],
    ]"
    :faqs="[
        ['question' => 'How many miles is 1,000 engine hours?', 'answer' => '30,000 miles at an average of 30 mph.'],
        ['question' => 'Why do police cars use engine hours?', 'answer' => 'They idle for long periods, adding wear the odometer misses.'],
        ['question' => 'Is 3,000 hours a lot for a boat engine?', 'answer' => 'For many gas outboards it is high; diesels often run much longer.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hours" label="Engine hours" value="3500" min="0" step="1" suffix="h" />
        <x-calc.field name="speed" label="Average speed" value="30" min="0" placeholder="Average speed">
            <label for="calc-speed-unit" class="sr-only">Average speed unit</label>
            <select id="calc-speed-unit" name="speed-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mph')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Equivalent miles" />

    <x-calc.options :examples="[
        '3,500 h at 30 mph' => ['hours' => 3500, 'speed' => 30, 'speed-unit' => 'mph'],
        'Idle-heavy truck' => ['hours' => 8000, 'speed' => 20, 'speed-unit' => 'mph'],
        'Metric, 40 km/h' => ['hours' => 1200, 'speed' => 40, 'speed-unit' => 'kmh'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'km' => ['label' => 'In km'],
            'note' => ['label' => 'Convention'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>miles = hours × average mph</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
