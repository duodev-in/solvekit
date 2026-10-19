<x-calc.page
    title="Weight Gain Calculator - SolveKit"
    description="Free weight gain calculator: daily calories and protein to reach a goal weight by a chosen date."
    lede="Plan healthy weight gain."
    about="Gaining weight takes a calorie surplus above maintenance: about 7,700 kcal per kg is a common estimate. A slow gain of 0.25–0.5 kg a week with strength training and 1.6–2.2 g/kg protein favours muscle over fat. Mifflin–St Jeor (1990) is the BMR equation most often recommended, because it came closest to measured values in the Academy of Nutrition and Dietetics review: men 10 × kg + 6.25 × cm − 5 × age + 5, women the same − 161. Total daily energy expenditure is BMR × an activity factor (1.2 sedentary to 1.9 very active). Equations are within about ± 10% for most people. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'gain', 'fields' => ['height', 'weight', 'age', 'sex', 'activity', 'goal_weight', 'weeks'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all(), 'goal_weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter your details', 'text' => ''],
        ['name' => 'Set the goal and weeks', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many calories to go from 80 to 85 kg in 20 weeks?', 'answer' => '2,947 kcal/day kcal a day.'],
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

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="activity" label="Activity level" :options="['sedentary' => 'Sedentary (little or no exercise)', 'light' => 'Light (1–3 days a week)', 'moderate' => 'Moderate (3–5 days a week)', 'active' => 'Active (6–7 days a week)', 'extra' => 'Very active (physical job or twice a day)']" selected="moderate" />
        <x-calc.field name="goal_weight" label="Goal weight" value="85" min="0" placeholder="Goal weight">
            <label for="calc-goal_weight-unit" class="sr-only">Goal weight unit</label>
            <select id="calc-goal_weight-unit" name="goal_weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weeks" label="Weeks" value="20" min="0" step="1" />
    </div>

    <x-calc.result label="Calories to gain weight" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'age' => 35, 'sex' => 'male', 'activity' => 'moderate', 'goal_weight' => 85, 'goal_weight-unit' => 'kg', 'weeks' => 20],
        'Underweight' => ['height' => 170, 'height-unit' => 'cm', 'weight' => 52, 'weight-unit' => 'kg', 'age' => 22, 'sex' => 'female', 'activity' => 'light', 'goal_weight' => 57, 'goal_weight-unit' => 'kg', 'weeks' => 24],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'surplus' => ['label' => 'Surplus a day'],
            'rate' => ['label' => 'Weekly gain'],
            'protein' => ['label' => 'Protein'],
            'pace' => ['label' => 'Pace'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>surplus = Δkg × 7,700 ÷ days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
