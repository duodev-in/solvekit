<x-calc.page
    title="6 Minute Walk Test Calculator - SolveKit"
    description="Free 6-minute walk test calculator: your distance as a percentage of the predicted distance for age, sex, height and weight (Enright & Sherrill), with the lower limit of normal."
    lede="Compare your 6-minute walk with predicted."
    about="Enright & Sherrill (1998) reference equations for healthy adults aged 40–80: men 7.57 × height (cm) − 5.02 × age − 1.76 × weight (kg) − 309 m; women 2.11 × height − 2.29 × weight − 5.78 × age + 667 m. The lower limit of normal is 153 m (men) or 139 m (women) below predicted. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'six_minute', 'fields' => ['distance', 'age', 'sex', 'height', 'weight'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Walk for 6 minutes', 'text' => 'On a flat 30 m course, as the ATS guideline describes.'],
        ['name' => 'Enter the distance and your details', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What percentage of predicted is 450 m for a 60-year-old man, 175 cm, 80 kg?', 'answer' => '78% (Predicted 574 m; lower limit of normal 421 m).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="distance" label="Distance walked" value="450" min="0" step="1" suffix="m" />
        <x-calc.field name="age" label="Age" value="60" min="0" step="1" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
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

    <x-calc.result label="Of predicted 6MWT distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['distance' => 450, 'age' => 60, 'sex' => 'male', 'height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg'],
        'Woman' => ['distance' => 380, 'age' => 70, 'sex' => 'female', 'height' => 160, 'height-unit' => 'cm', 'weight' => 65, 'weight-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'predicted' => ['label' => 'Predicted'],
            'lln' => ['label' => 'Lower limit of normal'],
            'result' => ['label' => 'Result'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>men: 7.57 H − 5.02 A − 1.76 W − 309</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
