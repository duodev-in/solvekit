<x-calc.page
    title="IIFYM Calculator (If It Fits Your Macros) - SolveKit"
    description="Free IIFYM calculator: daily calories and macros with protein set by body weight (1.6–2.2 g/kg), fat as a share of calories and carbs filling the rest."
    lede="Set your macros IIFYM-style."
    about="If It Fits Your Macros sets a calorie target (TDEE ± goal) and then protein by body weight (the International Society of Sports Nutrition suggests 1.4–2.0 g/kg, up to 2.2 g/kg when cutting), fat at 20–35% of calories, and carbohydrate from the remaining calories. Mifflin–St Jeor (1990) is the BMR equation most often recommended, because it came closest to measured values in the Academy of Nutrition and Dietetics review: men 10 × kg + 6.25 × cm − 5 × age + 5, women the same − 161. Total daily energy expenditure is BMR × an activity factor (1.2 sedentary to 1.9 very active). Equations are within about ± 10% for most people. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'iifym', 'fields' => ['height', 'weight', 'age', 'sex', 'activity', 'goal', 'protein_g', 'fat_pct'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter your details', 'text' => ''],
        ['name' => 'Set protein and fat', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are the macros for an 80 kg man losing 0.5 kg a week?', 'answer' => '144 g protein · 263 g carbs · 60 g fat.'],
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

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="protein_g" label="Protein" value="1.8" min="0.8" max="3" step="0.1" suffix="g/kg" />
        <x-calc.field name="fat_pct" label="Fat" value="25" min="15" max="50" step="1" suffix="%" />
    </div>

    <x-calc.result label="Your macros" />

    <x-calc.options :decimals="false" :examples="[
        'Cut' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'age' => 35, 'sex' => 'male', 'activity' => 'moderate', 'goal' => 'lose', 'protein_g' => 1.8, 'fat_pct' => 25],
        'Lean bulk' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'age' => 35, 'sex' => 'male', 'activity' => 'active', 'goal' => 'gain', 'protein_g' => 1.6, 'fat_pct' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'protein' => ['label' => 'Protein'],
            'carbs' => ['label' => 'Carbohydrate'],
            'fat' => ['label' => 'Fat'],
            'meals' => ['label' => 'Per meal'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>protein = kg × g/kg</li>
            <li>carbs = (kcal − 4P − 9F) ÷ 4</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
