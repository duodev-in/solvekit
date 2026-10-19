<x-calc.page
    title="Harris-Benedict Calculator (Basal Metabolic Rate) - SolveKit"
    description="Free Harris–Benedict calculator: BMR by the revised Harris–Benedict equation and your daily calorie needs, with a guided mode that works out your activity level from three questions."
    lede="Calculate BMR with Harris–Benedict."
    about="Revised Harris–Benedict (Roza & Shizgal 1984): men 88.362 + 13.397 × kg + 4.799 × cm − 5.677 × age; women 447.593 + 9.247 × kg + 3.098 × cm − 4.330 × age. Daily needs = BMR × activity factor. The guided mode asks about your job, exercise days and intensity and picks the factor for you. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'harris', 'fields' => ['mode', 'height', 'weight', 'age', 'sex', 'formula', 'activity', 'job', 'days', 'intensity'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter your details', 'text' => ''],
        ['name' => 'Pick the activity level, or answer the questions', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the Harris–Benedict BMR of a 35-year-old man, 175 cm, 80 kg?', 'answer' => '1,801 kcal/day kcal; daily needs 2,792 kcal (× 1.55, moderate (exercise 3–5 days a week)).'],
        ['question' => 'What does the guided mode give for a desk job with exercise 3–5 days a week?', 'answer' => '2,477 kcal (× 1.375, light (exercise 1–3 days a week)).'],
    ]"
>
    <x-calc.segmented name="mode" legend="Activity" :options="['quick' => 'I know my activity level', 'guided' => 'Guide me (3 questions)']" selected="quick" />

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

    <x-calc.select name="formula" label="Equation" :options="['harris' => 'Revised (1984)', 'harrisOriginal' => 'Original (1919)']" selected="harris" />

    <div data-show-when="mode:quick">
        <x-calc.select name="activity" label="Activity level" :options="['sedentary' => 'Sedentary (little or no exercise)', 'light' => 'Light (1–3 days a week)', 'moderate' => 'Moderate (3–5 days a week)', 'active' => 'Active (6–7 days a week)', 'extra' => 'Very active (physical job or twice a day)']" selected="moderate" />
    </div>

    <div data-show-when="mode:guided" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.select name="job" label="Your work" :options="['desk' => 'Mostly sitting', 'standing' => 'On your feet', 'manual' => 'Physical labour']" selected="desk" />
            <x-calc.select name="days" label="Exercise days a week" :options="['none' => 'None', 'few' => '1–2', 'most' => '3–5', 'daily' => '6–7']" selected="few" />
            <x-calc.select name="intensity" label="Usual intensity" :options="['easy' => 'Easy', 'moderate' => 'Moderate', 'hard' => 'Hard']" selected="moderate" />
        </div>
    </div>

    <x-calc.result label="Basal metabolic rate" />

    <x-calc.options :decimals="false" :examples="[
        'Quick' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'age' => 35, 'sex' => 'male', 'mode' => 'quick', 'formula' => 'harris', 'activity' => 'moderate', 'job' => 'desk', 'days' => 'few', 'intensity' => 'moderate'],
        'Guided' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'age' => 35, 'sex' => 'male', 'mode' => 'guided', 'formula' => 'harris', 'activity' => 'moderate', 'job' => 'desk', 'days' => 'most', 'intensity' => 'moderate'],
        'Woman' => ['height' => 165, 'height-unit' => 'cm', 'weight' => 62, 'weight-unit' => 'kg', 'age' => 50, 'sex' => 'female', 'mode' => 'quick', 'formula' => 'harris', 'activity' => 'light', 'job' => 'desk', 'days' => 'few', 'intensity' => 'moderate'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tdee' => ['label' => 'Daily needs'],
            'activity' => ['label' => 'Activity level'],
            'lose' => ['label' => 'To lose weight'],
            'mifflin' => ['label' => 'Mifflin–St Jeor'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>men: 88.362 + 13.397 W + 4.799 H − 5.677 A</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
