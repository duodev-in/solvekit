<x-calc.page
    title="RMR Calculator - Resting Metabolic Rate - SolveKit"
    description="Free RMR calculator: resting metabolic rate by Mifflin–St Jeor (an RMR equation), with daily calories for each activity level."
    lede="Estimate your resting metabolic rate."
    about="Resting metabolic rate is measured awake and at rest after a short rest period, so it runs slightly higher than strict basal rate; Mifflin–St Jeor was in fact fitted to resting measurements. Mifflin–St Jeor (1990) is the BMR equation most often recommended, because it came closest to measured values in the Academy of Nutrition and Dietetics review: men 10 × kg + 6.25 × cm − 5 × age + 5, women the same − 161. Total daily energy expenditure is BMR × an activity factor (1.2 sedentary to 1.9 very active). Equations are within about ± 10% for most people. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'bmr', 'fields' => ['height', 'weight', 'age', 'sex', 'formula', 'body_fat'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter height, weight, age and sex', 'text' => ''],
        ['name' => 'Choose the formula', 'text' => 'All are compared in the table.'],
    ]"
    :faqs="[
        ['question' => 'What is the RMR of a 35-year-old man, 175 cm and 80 kg?', 'answer' => '1,724 kcal/day kcal a day.'],
    ]"
>
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

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="35" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="formula" label="Formula" :options="['mifflin' => 'Mifflin–St Jeor', 'harris' => 'Harris–Benedict (revised)', 'harrisOriginal' => 'Harris–Benedict (original)', 'katch' => 'Katch–McArdle (needs body fat)']" selected="mifflin" />
        <x-calc.field name="body_fat" label="Body fat (for Katch–McArdle)" value="" min="1" max="70" step="any" suffix="%" placeholder="Optional" />
    </div>

    <x-calc.result label="Basal metabolic rate" />

    <x-calc.options :decimals="false" :examples="[
        'Man' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'age' => 35, 'sex' => 'male', 'formula' => 'mifflin', 'body_fat' => ''],
        'Older woman' => ['height' => 160, 'height-unit' => 'cm', 'weight' => 70, 'weight-unit' => 'kg', 'age' => 68, 'sex' => 'female', 'formula' => 'mifflin', 'body_fat' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'sedentary' => ['label' => 'Sedentary'],
            'light' => ['label' => 'Light'],
            'moderate' => ['label' => 'Moderate'],
            'active' => ['label' => 'Active'],
            'extra' => ['label' => 'Very active'],
        ]" />
        <x-calc.grid heading="Formulas" name="formulas" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Mifflin: 10 W + 6.25 H − 5 A + 5 (men) or − 161 (women)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
