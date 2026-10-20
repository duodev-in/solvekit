<x-calc.page
    title="Sauna Calories Burned Calculator - SolveKit"
    description="Free sauna calories calculator: the small energy use of sitting in a sauna, and why weight lost is water."
    lede="Estimate sauna calories."
    about="A sauna raises heart rate, but energy use stays close to resting. The weight you lose is sweat and returns when you drink."
    :calc="['engine' => 'sp-fit', 'tool' => 'sauna', 'fields' => ['w', 't', 'MET'], 'unitFields' => ['w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many calories does a 15-minute sauna burn?', 'answer' => 'About 27.6 kcal kcal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Body weight" value="70" min="0" placeholder="Body weight">
            <label for="calc-w-unit" class="sr-only">Body weight unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="t" label="Time in the sauna" value="15" placeholder="Time in the sauna">
            <label for="calc-t-unit" class="sr-only">Time in the sauna unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'min')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="MET" label="MET value (resting is 1.0–1.3)" value="1.5" min="1" step="any" />
    </div>

    <x-calc.result label="Calories burned" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 70, 'w-unit' => 'kg', 't' => 15, 't-unit' => 'min', 'MET' => 1.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'extra' => ['label' => 'Above sitting quietly'],
            'water' => ['label' => 'About the weight you lose'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
