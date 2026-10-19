<x-calc.page
    title="Army Body Fat Calculator - SolveKit"
    description="Free Army body fat calculator: the 2023 one-site tape method (abdomen and weight) from AR 600-9, with the maximum body fat for your age and sex."
    lede="Check the Army body fat standard."
    about="Since 2023 the Army uses a one-site tape test (Army Directive 2023-11, AR 600-9): men body fat = −26.97 − 0.12 × weight (lb) + 1.99 × abdomen (in); women −9.15 − 0.015 × weight + 1.27 × abdomen, measured at the navel. Maximum body fat: men 20% (17–20), 22% (21–27), 24% (28–39), 26% (40+); women 30%, 32%, 34% and 36%. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'army_bodyfat', 'fields' => ['weight', 'abdomen', 'age', 'sex'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all(), 'abdomen' => collect(config('units.length'))->only(['cm', 'in'])->all()]]"
    :how-to="[
        ['name' => 'Measure the abdomen at the navel', 'text' => ''],
        ['name' => 'Enter weight, age and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Does a 25-year-old man at 185 lb with a 36 in abdomen meet the standard?', 'answer' => '22.5%: Exceeds the 22% maximum for men aged 25 (AR 600-9).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="weight" label="Weight" value="185" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="abdomen" label="Abdomen at the navel" value="36" min="0" placeholder="Abdomen at the navel">
            <label for="calc-abdomen-unit" class="sr-only">Abdomen at the navel unit</label>
            <select id="calc-abdomen-unit" name="abdomen-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="age" label="Age" value="25" min="0" step="1" suffix="years" />
    </div>

    <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />

    <x-calc.result label="Army body fat (one-site tape)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weight' => 185, 'weight-unit' => 'lb', 'abdomen' => 36, 'abdomen-unit' => 'in', 'age' => 25, 'sex' => 'male'],
        'Woman' => ['weight' => 145, 'weight-unit' => 'lb', 'abdomen' => 32, 'abdomen-unit' => 'in', 'age' => 30, 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'limit' => ['label' => 'Maximum allowed'],
            'formula' => ['label' => 'Formula'],
            'exempt' => ['label' => 'Exemption'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>men: −26.97 − 0.12 W + 1.99 A</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
