<x-calc.page
    title="Keto Calculator - SolveKit"
    description="Free keto calculator: daily calories and ketogenic macros with a net-carb limit, protein by body weight and fat filling the rest."
    lede="Plan keto macros."
    about="A ketogenic diet keeps net carbohydrate low (usually 20–50 g a day), protein moderate (about 1.0–1.5 g per kg) and the rest of the energy from fat. Mifflin–St Jeor (1990) is the BMR equation most often recommended, because it came closest to measured values in the Academy of Nutrition and Dietetics review: men 10 × kg + 6.25 × cm − 5 × age + 5, women the same − 161. Total daily energy expenditure is BMR × an activity factor (1.2 sedentary to 1.9 very active). Equations are within about ± 10% for most people. People taking medicine for diabetes or blood pressure should check with a doctor first. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'keto', 'fields' => ['height', 'weight', 'age', 'sex', 'activity', 'goal', 'carbs', 'protein_g'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter your details', 'text' => ''],
        ['name' => 'Set carbs and protein', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What keto macros suit an 80 kg man losing weight?', 'answer' => '1,870 kcal: 25 g net carbs, 96 g protein, 154 g fat.'],
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
        <x-calc.field name="carbs" label="Net carbs" value="25" min="5" max="60" step="1" suffix="g" />
        <x-calc.field name="protein_g" label="Protein" value="1.2" min="0.6" max="2.5" step="0.1" suffix="g/kg" />
    </div>

    <x-calc.result label="Keto macros" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'age' => 35, 'sex' => 'male', 'activity' => 'light', 'goal' => 'lose', 'carbs' => 25, 'protein_g' => 1.2],
        'Maintain' => ['height' => 165, 'height-unit' => 'cm', 'weight' => 62, 'weight-unit' => 'kg', 'age' => 40, 'sex' => 'female', 'activity' => 'moderate', 'goal' => 'keep', 'carbs' => 30, 'protein_g' => 1.3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'carbs' => ['label' => 'Net carbs'],
            'protein' => ['label' => 'Protein'],
            'fat' => ['label' => 'Fat'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>fat = (kcal − 4C − 4P) ÷ 9</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
