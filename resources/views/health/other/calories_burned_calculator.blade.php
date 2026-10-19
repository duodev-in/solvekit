<x-calc.page
    title="Calories Burned Calculator - SolveKit"
    description="Free calories burned calculator: calories from walking, running, cycling, swimming, weights and 20 more activities by minutes and body weight, with WHO active minutes."
    lede="Count the calories your exercise burns."
    about="Calories = METs × body weight (kg) × hours, using MET values from the Compendium of Physical Activities (Ainsworth et al. 2011). Moderate activities are 3–6 METs and vigorous 6 or more; WHO recommends 150 moderate (or 75 vigorous) minutes a week. Individual results vary with fitness and efficiency. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'activity_rows', 'fields' => ['items', 'weight'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()], 'data' => ['mets' => config('health_data.mets')], 'period' => 'week']"
    :how-to="[
        ['name' => 'Add your activities', 'text' => ''],
        ['name' => 'Enter your weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many calories do 5 brisk 30-minute walks, 2 weight sessions and a bike ride burn at 75 kg?', 'answer' => '1,600 kcal a week.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Activities (activity, minutes, times a week)" :columns="['activity' => 'Activity', 'minutes' => 'Minutes', 'days' => 'Times a week']" :rows="[['Walking, 3.5 mph (5.6 km/h)', '30', '5'], ['Weight training, moderate', '45', '2'], ['Cycling, 12–13.9 mph (moderate)', '40', '1']]" add-label="Add activity" :text="['activity', 'minutes', 'days']" :lists="['activity' => collect(config('health_data.mets.activities'))->map(fn ($a) => $a[0])->values()->all()]" />

    <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
        <label for="calc-weight-unit" class="sr-only">Weight unit</label>
        <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Calories burned a week" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['items' => 'Walking, 3.5 mph (5.6 km/h)	30	5
Weight training, moderate	45	2
Cycling, 12–13.9 mph (moderate)	40	1', 'weight' => 75, 'weight-unit' => 'kg'],
        'Runner' => ['items' => 'Running, 6 mph (9.7 km/h)	40	3
Yoga (hatha)	30	2', 'weight' => 65, 'weight-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'who' => ['label' => 'WHO guideline'],
            'net' => ['label' => 'Above resting'],
            'source' => ['label' => 'Source'],
        ]" />
        <x-calc.grid heading="Activities" name="items" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kcal = METs × kg × h</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
