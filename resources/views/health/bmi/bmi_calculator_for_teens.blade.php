<x-calc.page
    title="BMI Calculator for Teens - SolveKit"
    description="Free BMI calculator for teens: BMI-for-age percentile for ages 13–19 from the CDC growth charts."
    lede="Check a teen's BMI percentile."
    about="For ages 2–19 BMI is compared with children of the same age and sex on the CDC 2000 growth charts: below the 5th percentile is underweight, 5th to below 85th healthy, 85th to below 95th overweight, and 95th or above obesity (severe obesity from 120% of the 95th percentile, CDC 2022). Percentiles come from the CDC LMS tables: z = ((BMI ÷ M)^L − 1) ÷ (L × S). At 20 the adult categories take over. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'bmi_child', 'fields' => ['height', 'weight', 'years', 'months', 'sex'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()], 'data' => ['growth' => config('health_data.growth')]]"
    :how-to="[
        ['name' => 'Enter height and weight', 'text' => ''],
        ['name' => 'Enter age and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What BMI percentile is a 15-year-old girl at 163 cm and 55 kg?', 'answer' => '59.9th percentile (BMI 20.7 kg/m² for a girl aged 15 y 0 m: Healthy weight).'],
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

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="years" label="Age (years)" value="15" min="0" step="1" />
        <x-calc.field name="months" label="and months" value="0" min="0" max="11" step="1" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="female" />
    </div>

    <x-calc.result label="BMI-for-age" />

    <x-calc.options :decimals="false" :examples="[
        'Girl 15' => ['height' => 163, 'height-unit' => 'cm', 'weight' => 55, 'weight-unit' => 'kg', 'years' => 15, 'months' => 0, 'sex' => 'female'],
        'Boy 17' => ['height' => 178, 'height-unit' => 'cm', 'weight' => 82, 'weight-unit' => 'kg', 'years' => 17, 'months' => 0, 'sex' => 'male'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'bmi' => ['label' => 'BMI'],
            'category' => ['label' => 'Category'],
            'z' => ['label' => 'Z-score'],
            'p85' => ['label' => '85th percentile BMI'],
            'p95' => ['label' => '95th percentile BMI'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>z from CDC LMS</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
