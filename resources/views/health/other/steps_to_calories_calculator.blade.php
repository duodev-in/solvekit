<x-calc.page
    title="Steps to Calories Calculator - SolveKit"
    description="Free steps to calories calculator: distance and calories burned from your step count, height, weight and walking pace."
    lede="Turn steps into distance and calories."
    about="Stride length is about 0.415 × height for men and 0.413 × height for women; distance = steps × stride. Calories use the Compendium walking METs for your pace (3.5 METs at 3 mph) × body weight × hours. 10,000 steps is roughly 7–8 km for an average adult. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'walking_calories', 'fields' => ['steps', 'pace', 'height', 'weight', 'sex'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()], 'mode' => 'steps']"
    :how-to="[
        ['name' => 'Enter your steps', 'text' => ''],
        ['name' => 'Enter height, weight and pace', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many calories are 10,000 steps at 3 mph for a 70 kg man (170 cm)?', 'answer' => '360 kcal (7.05 km (4.38 mi) in about 88 minutes at 4.8 km/h).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="steps" label="Steps" value="10000" min="0" step="100" />
        <x-calc.select name="pace" label="Pace" :options="['slow' => 'Slow (2 mph, 3.2 km/h)', 'moderate' => 'Moderate (3 mph, 4.8 km/h)', 'brisk' => 'Brisk (3.5 mph, 5.6 km/h)', 'fast' => 'Fast (4 mph, 6.4 km/h)']" selected="moderate" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
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
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.result label="Calories burned walking" />

    <x-calc.options :decimals="false" :examples="[
        '10,000 steps' => ['mode' => 'steps', 'steps' => 10000, 'pace' => 'moderate', 'height' => 170, 'height-unit' => 'cm', 'weight' => 70, 'weight-unit' => 'kg', 'sex' => 'male'],
        'Brisk 6,000' => ['mode' => 'steps', 'steps' => 6000, 'pace' => 'brisk', 'height' => 165, 'height-unit' => 'cm', 'weight' => 65, 'weight-unit' => 'kg', 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'distance' => ['label' => 'Distance'],
            'time' => ['label' => 'Time'],
            'steps' => ['label' => 'Steps'],
            'net' => ['label' => 'Above resting'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>distance = steps × 0.415 × height</li>
            <li>kcal = METs × kg × h</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
