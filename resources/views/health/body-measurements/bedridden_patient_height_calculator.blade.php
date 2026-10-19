<x-calc.page
    title="Bedridden Patient Height Calculator - SolveKit"
    description="Free bedridden patient height calculator: estimate height from knee height when a person cannot stand, with the Chumlea equations."
    lede="Estimate height from knee height."
    about="Knee height is measured with the knee and ankle bent at 90°, from the heel to the top of the knee. Chumlea, Roche & Steinbaugh (1985) give height = 64.19 − 0.04 × age + 2.02 × knee height for men and 84.88 − 0.24 × age + 1.83 × knee height for women (cm), developed in people aged 60–90. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'knee_height', 'fields' => ['knee', 'age', 'sex'], 'unitFields' => ['knee' => collect(config('units.length'))->only(['cm', 'in'])->all()]]"
    :how-to="[
        ['name' => 'Measure knee height', 'text' => 'Lying down, knee and ankle at 90°.'],
        ['name' => 'Enter age and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What height does a 52 cm knee height give for a 75-year-old man?', 'answer' => '166.2 cm (65.4 in).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="knee" label="Knee height" value="52" min="0" placeholder="Knee height">
            <label for="calc-knee-unit" class="sr-only">Knee height unit</label>
            <select id="calc-knee-unit" name="knee-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="age" label="Age" value="75" min="0" step="1" suffix="years" />
    </div>

    <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />

    <x-calc.result label="Estimated height" />

    <x-calc.options :decimals="false" :examples="[
        'Man 75' => ['knee' => 52, 'knee-unit' => 'cm', 'age' => 75, 'sex' => 'male'],
        'Woman 80' => ['knee' => 48, 'knee-unit' => 'cm', 'age' => 80, 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'error' => ['label' => 'Accuracy'],
            'population' => ['label' => 'Population'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>men: 64.19 − 0.04 A + 2.02 KH</li>
            <li>women: 84.88 − 0.24 A + 1.83 KH</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
