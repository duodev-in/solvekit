<x-calc.page
    title="BMI Calculator – Body Mass Index - SolveKit"
    description="Free BMI calculator: body mass index with the WHO category, your healthy weight range and BMI Prime, for adults or children (CDC percentiles)."
    lede="Calculate your body mass index."
    about="BMI = weight (kg) ÷ height (m)². The WHO adult categories are underweight below 18.5, healthy 18.5–24.9, overweight 25–29.9 and obesity 30 or more (classes I, II and III from 30, 35 and 40). For people of Asian descent WHO suggests action points from 23 and 27.5. BMI does not distinguish muscle from fat, so very muscular people can score high, and it is less useful in pregnancy. For children choose the child option to use CDC percentiles. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'bmi', 'fields' => ['mode', 'height', 'weight', 'cutoffs', 'years', 'months', 'sex'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()], 'data' => ['growth' => config('health_data.growth')]]"
    :how-to="[
        ['name' => 'Enter height and weight', 'text' => 'In metric or US units.'],
        ['name' => 'Choose adult or child', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the BMI of 175 cm and 80 kg?', 'answer' => '26.1 kg/m² (Overweight (WHO)).'],
        ['question' => 'What is the healthy weight range at 175 cm?', 'answer' => '56.7 kg (124.9 lb) – 76.3 kg (168.1 lb) (BMI 18.5–24.9).'],
        ['question' => 'What BMI percentile is a 10-year-old boy at 140 cm and 35 kg?', 'answer' => '70.6th percentile.'],
    ]"
>
    <x-calc.segmented name="mode" legend="For" :options="['adult' => 'Adult (20+)', 'child' => 'Child or teen (2–19)']" selected="adult" />

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

    <div data-show-when="mode:adult">
        <x-calc.select name="cutoffs" label="Cut-offs" :options="['who' => 'WHO standard', 'asian' => 'WHO, for Asian populations']" selected="who" />
    </div>

    <div data-show-when="mode:child" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="years" label="Age (years)" value="10" min="0" step="1" />
            <x-calc.field name="months" label="and months" value="0" min="0" max="11" step="1" />
            <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        </div>
    </div>

    <x-calc.result label="BMI" />

    <x-calc.options :decimals="false" :examples="[
        'Adult' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'mode' => 'adult', 'cutoffs' => 'who', 'years' => 10, 'months' => 0, 'sex' => 'male'],
        'Asian cut-offs' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 74, 'weight-unit' => 'kg', 'mode' => 'adult', 'cutoffs' => 'asian', 'years' => 10, 'months' => 0, 'sex' => 'male'],
        'US units' => ['height' => 5.75, 'height-unit' => 'ft', 'weight' => 200, 'weight-unit' => 'lb', 'mode' => 'adult', 'cutoffs' => 'who', 'years' => 10, 'months' => 0, 'sex' => 'male'],
        'Child' => ['height' => 140, 'height-unit' => 'cm', 'weight' => 35, 'weight-unit' => 'kg', 'mode' => 'child', 'cutoffs' => 'who', 'years' => 10, 'months' => 0, 'sex' => 'male'],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:adult">
            <x-calc.rows heading="Details" :rows="[
                'category' => ['label' => 'Category'],
                'range' => ['label' => 'Healthy weight range'],
                'change' => ['label' => 'To the healthy range'],
                'prime' => ['label' => 'BMI Prime'],
                'note' => ['label' => 'Note'],
            ]" />
        </div>
        <div data-show-when="mode:child" hidden>
            <x-calc.rows heading="Details" :rows="[
                'c_bmi' => ['label' => 'BMI'],
                'c_category' => ['label' => 'Category'],
                'c_z' => ['label' => 'Z-score'],
                'c_p85' => ['label' => '85th percentile BMI'],
                'c_p95' => ['label' => '95th percentile BMI'],
            ]" />
        </div>
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>BMI = kg ÷ m²</li>
            <li>child: percentile from CDC LMS</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
