<x-calc.page
    title="Wilks Calculator - SolveKit"
    description="Free Wilks calculator: Wilks score to compare powerlifters of different body weights."
    lede="Find your Wilks score."
    about="The Wilks coefficient scales a powerlifting total by body weight so lifters in different classes can be compared."
    :calc="['engine' => 'sp-misc', 'tool' => 'wilks', 'fields' => ['sex', 'bw', 'total'], 'unitFields' => ['bw' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'total' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all(), 'sports' => collect(config('sports_data'))->only(['strength'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What Wilks score is a 600 kg total at 90 kg?', 'answer' => '383.04.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="sex" label="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.field name="bw" label="Body weight" value="90" min="0" placeholder="Body weight">
            <label for="calc-bw-unit" class="sr-only">Body weight unit</label>
            <select id="calc-bw-unit" name="bw-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="total" label="Total lifted" value="600" min="0" placeholder="Total lifted">
            <label for="calc-total-unit" class="sr-only">Total lifted unit</label>
            <select id="calc-total-unit" name="total-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Wilks score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sex' => 'male', 'bw' => 90, 'bw-unit' => 'kg', 'total' => 600, 'total-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'coef' => ['label' => 'Wilks coefficient'],
            'dots' => ['label' => 'DOTS (for comparison)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
