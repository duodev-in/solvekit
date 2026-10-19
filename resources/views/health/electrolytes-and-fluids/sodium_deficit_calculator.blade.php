<x-calc.page
    title="Sodium Deficit Calculator - SolveKit"
    description="Free sodium deficit calculator: the sodium deficit in hyponatraemia from current and target sodium, weight, age and sex."
    lede="Estimate the sodium deficit."
    about="Sodium deficit (mmol) = total body water × (target Na − current Na), with TBW = 0.6 × weight for men and children, 0.5 for women and older men, and 0.45 for older women. In chronic hyponatraemia, sodium should rise by no more than 8–10 mmol/L in 24 hours to avoid osmotic demyelination; this is a teaching estimate, not a treatment plan. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'na_deficit', 'fields' => ['na', 'target', 'weight', 'age', 'sex', 'group'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter current and target sodium', 'text' => ''],
        ['name' => 'Enter weight, age and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the deficit to raise Na from 120 to 128 in a 70 kg man?', 'answer' => '336 mmol.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="na" label="Current sodium" value="120" min="0" step="any" suffix="mmol/L" />
        <x-calc.field name="target" label="Target sodium" value="128" min="0" step="any" suffix="mmol/L" />
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
        <x-calc.field name="age" label="Age" value="60" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.select name="group" label="Patient" :options="['adult' => 'Adult', 'child' => 'Child']" selected="adult" />

    <x-calc.result label="Sodium deficit" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['na' => 120, 'target' => 128, 'weight' => 70, 'weight-unit' => 'kg', 'age' => 60, 'sex' => 'male', 'group' => 'adult'],
        'Woman' => ['na' => 118, 'target' => 124, 'weight' => 60, 'weight-unit' => 'kg', 'age' => 45, 'sex' => 'female', 'group' => 'adult'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tbw' => ['label' => 'Total body water'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>deficit = TBW × (target − Na)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
