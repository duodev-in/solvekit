<x-calc.page
    title="Weight Percentile Calculator - SolveKit"
    description="Free weight percentile calculator: weight-for-age percentile for children from birth to 20 (WHO and CDC growth charts)."
    lede="Find a child's weight percentile."
    about="Percentiles compare a child with others of the same age and sex. Under 2 years the WHO Child Growth Standards (2006) are used, from 2 to 20 years the CDC 2000 growth charts, as CDC and the American Academy of Pediatrics recommend. The z-score comes from the published LMS parameters: z = ((X ÷ M)^L − 1) ÷ (L × S). One measurement matters less than the trend across visits. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'weight_percentile', 'fields' => ['years', 'months', 'sex', 'weight'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()], 'data' => ['growth' => config('health_data.growth')]]"
    :how-to="[
        ['name' => 'Enter age and sex', 'text' => ''],
        ['name' => 'Enter weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What weight percentile is an 8-year-old boy at 26 kg?', 'answer' => '54th percentile.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="years" label="Age (years)" value="8" min="0" step="1" />
        <x-calc.field name="months" label="and months" value="0" min="0" max="11" step="1" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.field name="weight" label="Weight" value="26" min="0" placeholder="Weight">
        <label for="calc-weight-unit" class="sr-only">Weight unit</label>
        <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Weight-for-age" />

    <x-calc.options :decimals="false" :examples="[
        'Boy 8' => ['years' => 8, 'months' => 0, 'sex' => 'male', 'weight' => 26, 'weight-unit' => 'kg'],
        'Girl 3' => ['years' => 3, 'months' => 0, 'sex' => 'female', 'weight' => 30, 'weight-unit' => 'lb'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'z' => ['label' => 'Z-score'],
            'p50' => ['label' => 'Median'],
            'range' => ['label' => '3rd–97th percentile'],
            'flag' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>z from WHO or CDC LMS</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
