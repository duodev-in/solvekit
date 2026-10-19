<x-calc.page
    title="Osteoporosis Risk Calculator - SolveKit"
    description="Free osteoporosis risk calculator: the Osteoporosis Self-assessment Tool (OST) from weight and age, with when a bone density scan is advised."
    lede="Check your osteoporosis risk (OST)."
    about="The OST (Koh et al. 2001) = 0.2 × (weight in kg − age), dropping decimals. Lower scores mean higher risk: under 2 is a common threshold for recommending a DXA bone density scan in women and men, and the Asian OSTA groups are high (under −4), moderate (−4 to −1) and low (over −1). FRAX gives fracture risk but is licensed, so it is not reproduced here. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'ost', 'fields' => ['weight', 'age', 'sex'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter weight and age', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the OST for a 68-year-old woman weighing 58 kg?', 'answer' => '-2: Under 2: higher risk; a bone density (DXA) scan is often advised.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="weight" label="Weight" value="58" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="age" label="Age" value="68" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="female" />
    </div>

    <x-calc.result label="Osteoporosis Self-assessment Tool" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weight' => 58, 'weight-unit' => 'kg', 'age' => 68, 'sex' => 'female'],
        'Low risk' => ['weight' => 80, 'weight-unit' => 'kg', 'age' => 55, 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'osta' => ['label' => 'OSTA group'],
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Screening'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>OST = 0.2 × (kg − age)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
