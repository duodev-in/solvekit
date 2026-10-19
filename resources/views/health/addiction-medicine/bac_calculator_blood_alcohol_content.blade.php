<x-calc.page
    title="BAC Calculator (Blood Alcohol Content) - SolveKit"
    description="Free BAC calculator: estimated blood alcohol from your drinks, body size, sex and time since the first drink (Widmark with Watson body water)."
    lede="Estimate your blood alcohol content."
    about="Blood alcohol is estimated with the Widmark equation, using Watson total body water for your height, weight, age and sex, and an average elimination of 0.015% an hour. Real values vary with food, drinking speed and liver function. Never use an estimate to decide whether you can drive. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'bac', 'fields' => ['drinks', 'height', 'weight', 'age', 'sex', 'hours'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'List the drinks', 'text' => ''],
        ['name' => 'Enter your details and time', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the BAC after three 5% beers in 2 hours (80 kg man)?', 'answer' => '0.044%.'],
    ]"
>
    <x-calc.rows-editor name="drinks" label="Drinks (name, ml, % ABV, how many)" :columns="['name' => 'Drink', 'ml' => 'ml', 'abv' => '% ABV', 'count' => 'How many']" :rows="[['Beer, 12 oz can', '355', '5', '3']]" add-label="Add drink" :text="['name', 'ml', 'abv', 'count']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Height" value="170" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Age" value="30" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.field name="hours" label="Hours since first drink" value="2" min="0" step="any" suffix="h" />
    </div>

    <x-calc.result label="Estimated blood alcohol now" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['drinks' => 'Beer, 12 oz can	355	5	3', 'height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'age' => 30, 'sex' => 'male', 'hours' => 2],
        'Wine' => ['drinks' => 'Wine, glass	150	13	2', 'height' => 165, 'height-unit' => 'cm', 'weight' => 60, 'weight-unit' => 'kg', 'age' => 35, 'sex' => 'female', 'hours' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'grams' => ['label' => 'Alcohol'],
            'limit' => ['label' => 'Legal limits'],
            'zero' => ['label' => 'Back to zero'],
            'warning' => ['label' => 'Warning'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>BAC = 0.08 × grams ÷ TBW − 0.015 × h</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
