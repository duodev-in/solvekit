<x-calc.page
    title="Maintenance Calorie Calculator - SolveKit"
    description="Free maintenance calorie calculator: the calories a day that keep your weight stable, from BMR and activity level."
    lede="Find your maintenance calories."
    about="Mifflin–St Jeor (1990) is the BMR equation most often recommended, because it came closest to measured values in the Academy of Nutrition and Dietetics review: men 10 × kg + 6.25 × cm − 5 × age + 5, women the same − 161. Total daily energy expenditure is BMR × an activity factor (1.2 sedentary to 1.9 very active). Equations are within about ± 10% for most people. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'tdee', 'fields' => ['height', 'weight', 'age', 'sex', 'activity'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter your details and activity', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are maintenance calories for a moderately active 35-year-old man (175 cm, 80 kg)?', 'answer' => '2,672 kcal/day kcal a day.'],
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

    <x-calc.select name="activity" label="Activity level" :options="['sedentary' => 'Sedentary (little or no exercise)', 'light' => 'Light (1–3 days a week)', 'moderate' => 'Moderate (3–5 days a week)', 'active' => 'Active (6–7 days a week)', 'extra' => 'Very active (physical job or twice a day)']" selected="moderate" />

    <x-calc.result label="Maintenance calories" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'age' => 35, 'sex' => 'male', 'activity' => 'moderate'],
        'Desk job woman' => ['height' => 165, 'height-unit' => 'cm', 'weight' => 62, 'weight-unit' => 'kg', 'age' => 45, 'sex' => 'female', 'activity' => 'sedentary'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'bmr' => ['label' => 'BMR'],
            'lose' => ['label' => 'To lose'],
            'gain' => ['label' => 'To gain'],
            'minimum' => ['label' => 'Minimum'],
        ]" />
        <x-calc.grid heading="Activity levels" name="levels" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>maintenance = BMR × activity</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
