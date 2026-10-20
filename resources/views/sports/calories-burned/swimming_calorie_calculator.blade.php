<x-calc.page
    title="Swimming Calorie Calculator - SolveKit"
    description="Free swimming calorie calculator: calories by stroke and effort."
    lede="Find swimming calories."
    about="Swimming energy depends on stroke and speed, from 4.8 METs for easy backstroke to 13.8 for butterfly."
    :calc="['engine' => 'sp-fit', 'tool' => 'swimming', 'fields' => ['act', 'w', 't'], 'unitFields' => ['w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all(), 'sports' => collect(config('sports_data'))->only(['mets'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What do 30 minutes of moderate freestyle burn?', 'answer' => 'About 213.2 kcal kcal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="act" label="Activity and effort" :options="['swim_free_light' => 'Swimming, freestyle, light or moderate effort', 'swim_free_fast' => 'Swimming, freestyle, fast and vigorous', 'swim_back' => 'Swimming, backstroke, general', 'swim_breast' => 'Swimming, breaststroke, general', 'swim_fly' => 'Swimming, butterfly, general', 'swim_leisure' => 'Swimming, leisurely, not laps']" selected="swim_free_light" />
        <x-calc.field name="w" label="Body weight" value="70" min="0" placeholder="Body weight">
            <label for="calc-w-unit" class="sr-only">Body weight unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="t" label="Duration" value="30" placeholder="Duration">
            <label for="calc-t-unit" class="sr-only">Duration unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'min')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Calories burned" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['act' => 'swim_free_light', 'w' => 70, 'w-unit' => 'kg', 't' => 30, 't-unit' => 'min'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'perMin' => ['label' => 'Per minute'],
            'perHour' => ['label' => 'Per hour'],
            'met' => ['label' => 'MET value used'],
            'fat' => ['label' => 'Equivalent body fat'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
