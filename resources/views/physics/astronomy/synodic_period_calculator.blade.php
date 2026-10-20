<x-calc.page
    title="Synodic Period Calculator - SolveKit"
    description="Free synodic period calculator: how often two planets line up again, from their orbital periods."
    lede="Find a synodic period."
    about="The synodic period is the time between successive alignments as seen from the Sun. For Earth and Mars it is about 780 days, which is why Mars launch windows open every 26 months."
    :calc="['engine' => 'ph-astro', 'tool' => 'synodic', 'fields' => ['p1', 'T1', 'p2', 'T2', 'out'], 'unitFields' => ['T1' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 'T2' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'time'])->all(), 'physics' => collect(config('physics_data'))->only(['bodies'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How often do Earth and Mars line up?', 'answer' => 'Every 779.934 d.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="p1" label="First body" :options="['mercury' => 'Mercury', 'venus' => 'Venus', 'earth' => 'Earth', 'mars' => 'Mars', 'jupiter' => 'Jupiter', 'saturn' => 'Saturn', 'uranus' => 'Uranus', 'neptune' => 'Neptune', 'custom' => 'Other (enter the period)']" selected="earth" />
        <div data-show-when="p1:custom">
            <x-calc.field name="T1" label="First period" value="365.256" placeholder="First period">
                <label for="calc-T1-unit" class="sr-only">First period unit</label>
                <select id="calc-T1-unit" name="T1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'day')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="p2" label="Second body" :options="['mercury' => 'Mercury', 'venus' => 'Venus', 'earth' => 'Earth', 'mars' => 'Mars', 'jupiter' => 'Jupiter', 'saturn' => 'Saturn', 'uranus' => 'Uranus', 'neptune' => 'Neptune', 'custom' => 'Other (enter the period)']" selected="mars" />
        <div data-show-when="p2:custom">
            <x-calc.field name="T2" label="Second period" value="686.98" placeholder="Second period">
                <label for="calc-T2-unit" class="sr-only">Second period unit</label>
                <select id="calc-T2-unit" name="T2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'day')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="day" />
    </div>

    <x-calc.result label="Synodic period" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'day', 'p1' => 'earth', 'T1' => 365.256, 'T1-unit' => 'day', 'p2' => 'mars', 'T2' => 686.98, 'T2-unit' => 'day'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'human' => ['label' => 'Readable'],
            'periods' => ['label' => 'Sidereal periods used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
