<x-calc.page
    title="Burpee Calorie Calculator - SolveKit"
    description="Free burpee calorie calculator: calories burned by a number of burpees at your pace."
    lede="Find calories burned doing burpees."
    about="Burpees are vigorous calisthenics, about 8 METs in the Compendium of Physical Activities."
    :calc="['engine' => 'sp-fit', 'tool' => 'burpee', 'fields' => ['w', 'n', 'rate'], 'unitFields' => ['w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all(), 'sports' => collect(config('sports_data'))->only(['mets'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many calories do 100 burpees burn for 70 kg?', 'answer' => 'About 98 kcal kcal.'],
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
        <x-calc.field name="n" label="Burpees" value="100" min="1" step="any" />
        <x-calc.field name="rate" label="Burpees per minute" value="10" min="1" step="any" />
    </div>

    <x-calc.result label="Calories burned" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 70, 'w-unit' => 'kg', 'n' => 100, 'rate' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'per' => ['label' => 'Per burpee'],
            'time' => ['label' => 'Time taken'],
            'met' => ['label' => 'MET value used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
