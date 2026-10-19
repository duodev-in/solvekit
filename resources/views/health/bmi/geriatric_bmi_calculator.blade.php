<x-calc.page
    title="Geriatric BMI Calculator - SolveKit"
    description="Free geriatric BMI calculator: BMI for adults over 65 with the older-adult healthy range (about 23–30) and malnutrition cut-offs."
    lede="Interpret BMI for older adults."
    about="In older adults the lowest mortality is seen at a somewhat higher BMI, roughly 24–31 (Winter et al. 2014 meta-analysis), and low BMI matters more: ESPEN uses BMI below 20 (under 70) or below 22 (70 and over) as a sign of malnutrition. Unplanned weight loss is the key warning sign. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'bmi_older', 'fields' => ['height', 'weight', 'age'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter height, weight and age', 'text' => 'Use knee height to estimate height if standing is hard.'],
    ]"
    :faqs="[
        ['question' => 'What does BMI 22 mean for an 80-year-old?', 'answer' => 'Low-normal: watch for weight loss.'],
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

    <x-calc.field name="age" label="Age" value="75" min="0" step="1" suffix="years" />

    <x-calc.result label="BMI" />

    <x-calc.options :decimals="false" :examples="[
        '80 years' => ['height' => 165, 'height-unit' => 'cm', 'weight' => 60, 'weight-unit' => 'kg', 'age' => 80],
        '68 years' => ['height' => 170, 'height-unit' => 'cm', 'weight' => 82, 'weight-unit' => 'kg', 'age' => 68],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'category' => ['label' => 'Older-adult band'],
            'range' => ['label' => 'BMI 23–30 range'],
            'standard' => ['label' => 'Standard WHO category'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>BMI = kg ÷ m²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
