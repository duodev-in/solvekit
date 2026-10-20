<x-calc.page
    title="Football Calorie Calculator (World Cup Edition) - SolveKit"
    description="Free football calorie calculator: calories burned playing soccer."
    lede="Find football calories."
    about="Competitive football is about 10 METs; World Cup players cover 10–13 km a match."
    :calc="['engine' => 'sp-misc', 'tool' => 'football_calories', 'fields' => ['act', 'w', 't'], 'unitFields' => ['w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all(), 'sports' => collect(config('sports_data'))->only(['mets'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does a 90-minute match burn for 75 kg?', 'answer' => 'About 1,181 kcal kcal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="act" label="Level" :options="['soccer_casual' => 'Football (soccer), casual', 'soccer_comp' => 'Football (soccer), competitive']" selected="soccer_comp" />
        <x-calc.field name="w" label="Body weight" value="75" min="0" placeholder="Body weight">
            <label for="calc-w-unit" class="sr-only">Body weight unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="t" label="Minutes played" value="90" placeholder="Minutes played">
            <label for="calc-t-unit" class="sr-only">Minutes played unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'min')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Calories burned" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['act' => 'soccer_comp', 'w' => 75, 'w-unit' => 'kg', 't' => 90, 't-unit' => 'min'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'perHour' => ['label' => 'Per hour'],
            'distance' => ['label' => 'Distance a World Cup outfield player covers'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
