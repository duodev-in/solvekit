<x-calc.page
    title="Calories Burned Biking Calculator - SolveKit"
    description="Free cycling calorie calculator: calories from speed or power."
    lede="Find cycling calories."
    about="With a power meter, calories almost equal kilojoules of work, because the body is about 24% efficient. Without one, Compendium METs by speed are used."
    :calc="['engine' => 'sp-cycle', 'tool' => 'bike_calories', 'fields' => ['by', 'speed', 'P', 'w', 't'], 'unitFields' => ['P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'power', 'speed', 'time'])->all(), 'sports' => collect(config('sports_data'))->only(['mets'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does an hour at 12–13.9 mph burn for 70 kg?', 'answer' => 'About 588 kcal kcal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="I know" :options="['speed' => 'Average speed', 'power' => 'Average power (watts)']" selected="speed" />
        <div data-show-when="by:speed">
            <x-calc.select name="speed" label="Speed band" :options="['bike_10' => 'Cycling, leisure, under 10 mph', 'bike_12' => 'Cycling, 10–11.9 mph, light', 'bike_14' => 'Cycling, 12–13.9 mph, moderate', 'bike_16' => 'Cycling, 14–15.9 mph, vigorous', 'bike_20' => 'Cycling, 16–19 mph, racing', 'bike_fast' => 'Cycling, over 20 mph, racing']" selected="bike_14" />
        </div>
        <div data-show-when="by:power">
            <x-calc.field name="P" label="Average power" value="150" min="0" placeholder="Average power">
                <label for="calc-P-unit" class="sr-only">Average power unit</label>
                <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="w" label="Body weight" value="70" min="0" placeholder="Body weight">
            <label for="calc-w-unit" class="sr-only">Body weight unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="t" label="Ride time" value="60" placeholder="Ride time">
            <label for="calc-t-unit" class="sr-only">Ride time unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'min')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Calories burned" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['by' => 'speed', 'speed' => 'bike_14', 'P' => 150, 'P-unit' => 'w', 'w' => 70, 'w-unit' => 'kg', 't' => 60, 't-unit' => 'min'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'perHour' => ['label' => 'Per hour'],
            'method' => ['label' => 'Method'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
