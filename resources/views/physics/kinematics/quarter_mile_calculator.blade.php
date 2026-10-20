<x-calc.page
    title="Quarter Mile Calculator - SolveKit"
    description="Free quarter mile calculator: estimate ET and trap speed from vehicle weight and horsepower."
    lede="Estimate a car’s quarter-mile time."
    about="Drag racers use Hale’s formulas, fitted to many real runs, to estimate the elapsed time and trap speed from the weight-to-power ratio. Traction, gearing and launch change the real result, so treat it as an estimate."
    :calc="['engine' => 'ph-mech', 'tool' => 'quarter_mile', 'fields' => ['w', 'p', 'out'], 'unitFields' => ['w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'p' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'power', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How quick is a 3,500 lb car with 400 hp?', 'answer' => 'About 12.0032 s; Trap speed about 113.6 mph (Hale formulas, an estimate).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Vehicle weight (with driver)" value="3500" min="0" placeholder="Vehicle weight (with driver)">
            <label for="calc-w-unit" class="sr-only">Vehicle weight (with driver) unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="p" label="Engine power" value="400" min="0" placeholder="Engine power">
            <label for="calc-p-unit" class="sr-only">Engine power unit</label>
            <select id="calc-p-unit" name="p-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hp')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="s" />
    </div>

    <x-calc.result label="Quarter-mile elapsed time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 's', 'w' => 3500, 'w-unit' => 'lb', 'p' => 400, 'p-unit' => 'hp'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'trap' => ['label' => 'Trap speed'],
            'eighth' => ['label' => 'Eighth-mile time (≈ 0.6385 × ET)'],
            'ratio' => ['label' => 'Weight per horsepower'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
