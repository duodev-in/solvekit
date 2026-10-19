<x-calc.page
    title="Lung Capacity Calculator - SolveKit"
    description="Free lung capacity calculator: predicted total lung capacity, vital capacity, FRC, residual volume, FVC and FEV₁ for your height, age and sex (ECCS/ERS 1993)."
    lede="Predict your lung volumes."
    about="The ECCS/ERS 1993 reference equations (Quanjer et al.) predict lung volumes for adults aged 18–70 from height and age: for example TLC = 7.99 × height (m) − 7.08 L in men and 6.60 × height − 5.79 L in women. Measured values within about 80–120% of predicted are usually normal; modern labs use the GLI equations. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'lung_volumes', 'fields' => ['height', 'age', 'sex'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter height, age and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the predicted TLC for a 40-year-old man, 175 cm?', 'answer' => '6.90 L.'],
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

    <x-calc.result label="Predicted total lung capacity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 175, 'height-unit' => 'cm', 'age' => 40, 'sex' => 'male'],
        'Woman' => ['height' => 162, 'height-unit' => 'cm', 'age' => 55, 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.grid heading="Predicted volumes" name="volumes" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>TLC = 7.99 H − 7.08 (men)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
