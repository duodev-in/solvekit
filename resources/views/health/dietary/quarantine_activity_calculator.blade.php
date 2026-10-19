<x-calc.page
    title="Quarantine Activity Calculator - SolveKit"
    description="Free home activity calculator: calories burned and active minutes from home activities such as cleaning, gardening, yoga and walking, against the WHO 150-minute guideline."
    lede="Count the activity you do at home."
    about="Calories = MET × body weight (kg) × hours, with MET values from the Compendium of Physical Activities (for example house cleaning 3.5, gardening 3.8, brisk walking 4.3). WHO advises at least 150 minutes of moderate (3–6 MET) or 75 minutes of vigorous (6+ MET) activity a week. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'activity_rows', 'fields' => ['items', 'weight'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()], 'data' => ['mets' => config('health_data.mets')]]"
    :how-to="[
        ['name' => 'Add activities and minutes', 'text' => ''],
        ['name' => 'Enter your weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many calories do 30 min walking, 45 min cleaning and 20 min yoga burn at 70 kg?', 'answer' => '365 kcal.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Activities (activity, minutes, days)" :columns="['activity' => 'Activity', 'minutes' => 'Minutes', 'days' => 'Days']" :rows="[['Walking, 3.0 mph (4.8 km/h)', '30', '1'], ['House cleaning, moderate effort', '45', '1'], ['Yoga (hatha)', '20', '1']]" add-label="Add activity" :text="['activity', 'minutes', 'days']" :lists="['activity' => collect(config('health_data.mets.activities'))->map(fn ($a) => $a[0])->values()->all()]" />

    <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
        <label for="calc-weight-unit" class="sr-only">Weight unit</label>
        <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Calories burned" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['items' => 'Walking, 3.0 mph (4.8 km/h)	30	1
House cleaning, moderate effort	45	1
Yoga (hatha)	20	1', 'weight' => 70, 'weight-unit' => 'kg'],
        'Active week' => ['items' => 'Walking, 3.5 mph (5.6 km/h)	30	5
Gardening, general	60	2', 'weight' => 80, 'weight-unit' => 'kg'],
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
            <li>kcal = MET × kg × h</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
