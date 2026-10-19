<x-calc.page
    title="Free Water Deficit Calculator - SolveKit"
    description="Free water deficit calculator: the free water deficit in hypernatraemia from sodium, weight, age and sex (total body water method)."
    lede="Estimate the free water deficit."
    about="Free water deficit = total body water × (Na ÷ 140 − 1), with TBW as a fraction of weight: 0.6 for children and adult men, 0.5 for adult women and older men, and 0.45 for older women (Adrogué & Madias 2000). Ongoing losses add to it. Chronic hypernatraemia is usually corrected by no more than about 10 mmol/L a day; fluid plans are made by the treating team. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'free_water', 'fields' => ['na', 'weight', 'age', 'sex', 'group'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter sodium', 'text' => ''],
        ['name' => 'Enter weight, age and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the deficit for Na 155 in a 70 kg, 60-year-old man?', 'answer' => '4.5 L.'],
    ]"
>
    <x-calc.field name="na" label="Sodium" value="155" min="0" step="any" suffix="mmol/L" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="age" label="Age" value="60" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.select name="group" label="Patient" :options="['adult' => 'Adult', 'child' => 'Child']" selected="adult" />

    <x-calc.result label="Free water deficit" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['na' => 155, 'weight' => 70, 'weight-unit' => 'kg', 'age' => 60, 'sex' => 'male', 'group' => 'adult'],
        'Older woman' => ['na' => 160, 'weight' => 55, 'weight-unit' => 'kg', 'age' => 82, 'sex' => 'female', 'group' => 'adult'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tbw' => ['label' => 'Total body water'],
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>deficit = TBW × (Na ÷ 140 − 1)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
