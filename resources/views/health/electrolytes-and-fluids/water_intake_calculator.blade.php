<x-calc.page
    title="Water Intake Calculator - SolveKit"
    description="Free water intake calculator: how much water to drink a day from the National Academies Adequate Intake, adjusted for exercise and hot weather."
    lede="Find how much water to drink."
    about="The National Academies set total water Adequate Intakes (from all drinks and food) of about 3.7 L a day for men and 2.7 L for women aged 19+, more in pregnancy and breastfeeding. About 80% usually comes from drinks. Add roughly 0.5–1 L per hour of exercise and more in hot weather; thirst and pale urine are good guides. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'water_intake', 'fields' => ['age', 'sex', 'state', 'weight', 'exercise', 'climate'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()], 'data' => ['dri' => config('health_data.dri')]]"
    :how-to="[
        ['name' => 'Enter age and sex', 'text' => ''],
        ['name' => 'Add exercise and climate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much water should a 35-year-old man drink?', 'answer' => '3.3 L a day from drinks.'],
        ['question' => 'And a breastfeeding woman?', 'answer' => '3.0 L.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Age" value="35" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.select name="state" label="Life stage" :options="['none' => 'Not pregnant or breastfeeding', 'pregnancy' => 'Pregnant', 'lactation' => 'Breastfeeding']" selected="none" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="exercise" label="Exercise" value="30" min="0" step="5" suffix="min/day" />
        <x-calc.select name="climate" label="Climate" :options="['temperate' => 'Temperate', 'hot' => 'Hot or humid']" selected="temperate" />
    </div>

    <x-calc.result label="Water from drinks a day" />

    <x-calc.options :decimals="false" :examples="[
        'Man' => ['age' => 35, 'sex' => 'male', 'state' => 'none', 'weight' => 80, 'weight-unit' => 'kg', 'exercise' => 30, 'climate' => 'temperate'],
        'Breastfeeding' => ['age' => 30, 'sex' => 'female', 'state' => 'lactation', 'weight' => 65, 'weight-unit' => 'kg', 'exercise' => 0, 'climate' => 'temperate'],
        'Hot day' => ['age' => 25, 'sex' => 'female', 'state' => 'none', 'weight' => 60, 'weight-unit' => 'kg', 'exercise' => 60, 'climate' => 'hot'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'total' => ['label' => 'Total water'],
            'exercise' => ['label' => 'Exercise'],
            'climate' => ['label' => 'Climate'],
            'perKg' => ['label' => 'Per kg'],
            'check' => ['label' => 'Check'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>drinks ≈ 0.8 × AI + exercise + climate</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
