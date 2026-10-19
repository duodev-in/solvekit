<x-calc.page
    title="Vital Capacity Calculator - SolveKit"
    description="Free vital capacity calculator: predicted vital capacity from age, sex and height (Baldwin formula), and your measured value as a percentage."
    lede="Predict your vital capacity."
    about="Baldwin, Cournand & Richards (1948): predicted vital capacity (mL) = (27.63 − 0.112 × age) × height (cm) for men and (21.78 − 0.101 × age) × height for women. Under 80% of predicted suggests restriction, which a full lung function test confirms. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'vital_capacity', 'fields' => ['height', 'age', 'sex', 'measured'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter height, age and sex', 'text' => ''],
        ['name' => 'Add your measured VC', 'text' => 'Optional.'],
    ]"
    :faqs="[
        ['question' => 'What is the predicted VC for a 40-year-old man, 175 cm?', 'answer' => '4.05 L (Measured 4.20 L is 104% of predicted).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="height" label="Height" value="170" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="age" label="Age" value="40" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.field name="measured" label="Measured vital capacity (optional)" value="4.2" min="0" step="any" suffix="L" />

    <x-calc.result label="Predicted vital capacity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 175, 'height-unit' => 'cm', 'age' => 40, 'sex' => 'male', 'measured' => 4.2],
        'Woman' => ['height' => 160, 'height-unit' => 'cm', 'age' => 60, 'sex' => 'female', 'measured' => 2.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>VC = (27.63 − 0.112 A) × H</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
