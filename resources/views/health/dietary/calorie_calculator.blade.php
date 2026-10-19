<x-calc.page
    title="Calorie Calculator - SolveKit"
    description="Free calorie calculator: calories a day to maintain, lose or gain weight from your height, weight, age, sex and activity (Mifflin–St Jeor)."
    lede="Find how many calories you need."
    about="Mifflin–St Jeor (1990) is the BMR equation most often recommended, because it came closest to measured values in the Academy of Nutrition and Dietetics review: men 10 × kg + 6.25 × cm − 5 × age + 5, women the same − 161. Total daily energy expenditure is BMR × an activity factor (1.2 sedentary to 1.9 very active). Equations are within about ± 10% for most people. Losing about 0.5 kg (1 lb) a week takes a deficit of roughly 500 kcal a day. Intakes under about 1,200 kcal (women) or 1,500 kcal (men) should be supervised (NIH). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'calories', 'fields' => ['height', 'weight', 'age', 'sex', 'activity', 'goal'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter your details', 'text' => ''],
        ['name' => 'Choose activity and goal', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many calories should a 35-year-old man (175 cm, 80 kg, moderately active) eat to lose 0.5 kg a week?', 'answer' => '2,172 kcal/day kcal a day.'],
        ['question' => 'And to maintain?', 'answer' => '2,672 kcal.'],
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
        <x-calc.select name="activity" label="Activity level" :options="['sedentary' => 'Sedentary (little or no exercise)', 'light' => 'Light (1–3 days a week)', 'moderate' => 'Moderate (3–5 days a week)', 'active' => 'Active (6–7 days a week)', 'extra' => 'Very active (physical job or twice a day)']" selected="moderate" />
        <x-calc.select name="goal" label="Goal" :options="['lose_fast' => 'Lose 1 kg (2 lb) a week', 'lose' => 'Lose 0.5 kg (1 lb) a week', 'lose_slow' => 'Lose 0.25 kg (½ lb) a week', 'keep' => 'Maintain', 'gain' => 'Gain 0.25 kg a week', 'gain_fast' => 'Gain 0.5 kg a week']" selected="lose" />
    </div>

    <x-calc.result label="Calories a day" />

    <x-calc.options :decimals="false" :examples="[
        'Lose' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'age' => 35, 'sex' => 'male', 'activity' => 'moderate', 'goal' => 'lose'],
        'Maintain woman' => ['height' => 165, 'height-unit' => 'cm', 'weight' => 62, 'weight-unit' => 'kg', 'age' => 50, 'sex' => 'female', 'activity' => 'light', 'goal' => 'keep'],
        'Gain' => ['height' => 180, 'height-unit' => 'cm', 'weight' => 68, 'weight-unit' => 'kg', 'age' => 25, 'sex' => 'male', 'activity' => 'active', 'goal' => 'gain'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'maintenance' => ['label' => 'Maintenance'],
            'change' => ['label' => 'Change'],
            'minimum' => ['label' => 'Minimum'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.grid heading="Every goal" name="goals" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>TDEE = BMR × activity</li>
            <li>target = TDEE + goal change</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
