<x-calc.page
    title="Calories Burned Rowing Calculator - SolveKit"
    description="Free rowing calorie calculator: calories from rowing-machine watts or effort."
    lede="Find rowing calories."
    about="Rowing machines report watts; Concept2 converts them to calories with a fixed formula. Without watts, Compendium METs by effort are used."
    :calc="['engine' => 'sp-fit', 'tool' => 'rowing_cal', 'fields' => ['by', 'P', 'act', 'w', 't'], 'unitFields' => ['P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'power', 'speed', 'time'])->all(), 'sports' => collect(config('sports_data'))->only(['mets'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does 30 minutes at 150 W burn?', 'answer' => 'About 408.1 kcal kcal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="I know" :options="['watts' => 'Average watts (from the monitor)', 'effort' => 'The effort']" selected="watts" />
        <div data-show-when="by:watts">
            <x-calc.field name="P" label="Average power" value="150" min="0" placeholder="Average power">
                <label for="calc-P-unit" class="sr-only">Average power unit</label>
                <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="by:effort">
            <x-calc.select name="act" label="Activity and effort" :options="['row_light' => 'Rowing machine, light effort', 'row_moderate' => 'Rowing machine, moderate effort', 'row_vigorous' => 'Rowing machine, vigorous effort']" selected="row_moderate" />
        </div>
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
        'Example' => ['by' => 'watts', 'P' => 150, 'P-unit' => 'w', 'act' => 'row_moderate', 'w' => 70, 'w-unit' => 'kg', 't' => 30, 't-unit' => 'min'],
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
