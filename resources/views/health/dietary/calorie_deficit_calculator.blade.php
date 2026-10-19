<x-calc.page
    title="Calorie Deficit Calculator - SolveKit"
    description="Free calorie deficit calculator: the daily calories and deficit to reach a goal weight by a chosen number of weeks, with a safety check."
    lede="Plan a calorie deficit for a goal weight."
    about="A deficit of about 7,700 kcal is a common estimate for 1 kg of fat (3,500 kcal per lb), so deficit a day = kg to lose × 7,700 ÷ days. Weight loss slows as the body adapts, so this is a starting estimate. A pace of 0.5–1 kg a week is generally advised. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'deficit', 'fields' => ['height', 'weight', 'age', 'sex', 'activity', 'goal_weight', 'weeks'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all(), 'goal_weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter your details', 'text' => ''],
        ['name' => 'Set the goal weight and weeks', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many calories to go from 80 to 72 kg in 16 weeks?', 'answer' => '2,122 kcal/day kcal a day (a deficit of 550 kcal).'],
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
        <x-calc.field name="goal_weight" label="Goal weight" value="64" min="0" placeholder="Goal weight">
            <label for="calc-goal_weight-unit" class="sr-only">Goal weight unit</label>
            <select id="calc-goal_weight-unit" name="goal_weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weeks" label="Weeks" value="16" min="0" step="1" />
    </div>

    <x-calc.result label="Calories a day" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'age' => 35, 'sex' => 'male', 'activity' => 'moderate', 'goal_weight' => 72, 'goal_weight-unit' => 'kg', 'weeks' => 16],
        'Fast' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'age' => 35, 'sex' => 'male', 'activity' => 'light', 'goal_weight' => 70, 'goal_weight-unit' => 'kg', 'weeks' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'deficit' => ['label' => 'Deficit a day'],
            'rate' => ['label' => 'Weekly loss'],
            'safe' => ['label' => 'Pace'],
            'weeksAt500' => ['label' => 'At 500 kcal a day'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>deficit = Δkg × 7,700 ÷ (weeks × 7)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
