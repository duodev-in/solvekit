<x-calc.page
    title="Adjusted Body Weight Calculator - SolveKit"
    description="Free adjusted body weight calculator: ideal body weight (Devine) and adjusted body weight for people above their ideal weight."
    lede="Find ideal and adjusted body weight."
    about="Adjusted body weight = ideal weight + 0.4 × (actual − ideal). It is used in nutrition and some clinical calculations for people well above their ideal weight, because fat tissue uses less energy than lean tissue. Ideal weight here is the Devine formula (50 kg for men or 45.5 kg for women + 2.3 kg per inch over 5 ft). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'adjusted_weight', 'fields' => ['height', 'weight', 'sex'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter height, weight and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the adjusted weight for a 175 cm man weighing 110 kg?', 'answer' => '86.3 kg (190.2 lb).'],
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

    <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />

    <x-calc.result label="Adjusted body weight" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 110, 'weight-unit' => 'kg', 'sex' => 'male'],
        'Woman 160 cm, 90 kg' => ['height' => 160, 'height-unit' => 'cm', 'weight' => 90, 'weight-unit' => 'kg', 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ibw' => ['label' => 'Ideal weight (Devine)'],
            'percent' => ['label' => 'Actual as % of ideal'],
            'use' => ['label' => 'Which weight'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AdjBW = IBW + 0.4 × (actual − IBW)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
