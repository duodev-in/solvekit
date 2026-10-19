<x-calc.page
    title="Baby Percentile Calculator - SolveKit"
    description="Free baby percentile calculator: weight, length and head circumference percentiles for babies from birth to 24 months on the WHO growth charts."
    lede="Check your baby's growth percentiles."
    about="Percentiles compare a child with others of the same age and sex. Under 2 years the WHO Child Growth Standards (2006) are used, from 2 to 20 years the CDC 2000 growth charts, as CDC and the American Academy of Pediatrics recommend. The z-score comes from the published LMS parameters: z = ((X ÷ M)^L − 1) ÷ (L × S). One measurement matters less than the trend across visits. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'baby_percentile', 'fields' => ['years', 'months', 'sex', 'weight', 'height', 'head'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all(), 'height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'head' => collect(config('units.length'))->only(['cm', 'in'])->all()], 'data' => ['growth' => config('health_data.growth')]]"
    :how-to="[
        ['name' => 'Enter the baby\'s age and sex', 'text' => ''],
        ['name' => 'Enter any of weight, length and head', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What percentile is a 6-month-old boy at 7.9 kg?', 'answer' => 'Weight 48th percentile; Weight: 48th · Length: 50th · Head: 49th.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="years" label="Age (years)" value="0" min="0" max="2" step="1" />
        <x-calc.field name="months" label="and months" value="6" min="0" max="11" step="1" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="weight" label="Weight" value="7.9" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Height" value="67.6" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="head" label="Head circumference" value="43.3" min="0" placeholder="Head circumference">
            <label for="calc-head-unit" class="sr-only">Head circumference unit</label>
            <select id="calc-head-unit" name="head-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Weight-for-age" />

    <x-calc.options :decimals="false" :examples="[
        '6 months' => ['years' => 0, 'months' => 6, 'sex' => 'male', 'weight' => 7.9, 'weight-unit' => 'kg', 'height' => 67.6, 'height-unit' => 'cm', 'head' => 43.3, 'head-unit' => 'cm'],
        'Girl 12 months' => ['years' => 1, 'months' => 0, 'sex' => 'female', 'weight' => 20, 'weight-unit' => 'lb', 'height' => 29, 'height-unit' => 'in', 'head' => 17.5, 'head-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.grid heading="All measurements" name="all" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>z = ((X ÷ M)^L − 1) ÷ (L S)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
