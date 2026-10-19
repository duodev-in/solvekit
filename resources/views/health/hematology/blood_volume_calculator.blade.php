<x-calc.page
    title="Blood Volume Calculator - SolveKit"
    description="Free blood volume calculator: total blood volume from height, weight and sex by the Nadler equation, with the Lemmens estimate for obesity."
    lede="Estimate your blood volume."
    about="Nadler, Hidalgo & Bloch (1962): men BV (L) = 0.3669 × height (m)³ + 0.03219 × weight (kg) + 0.6041; women 0.3561 × height³ + 0.03308 × weight + 0.1833. Adults have about 65–70 mL per kg; fat tissue holds little blood, so Lemmens et al. (2006) suggested 70 ÷ √(BMI ÷ 22) mL/kg in obesity. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'blood_volume', 'fields' => ['height', 'weight', 'sex'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter height, weight and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the blood volume of a 170 cm, 70 kg man?', 'answer' => '4.66 L (67 mL/kg).'],
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
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.result label="Blood volume" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 170, 'height-unit' => 'cm', 'weight' => 70, 'weight-unit' => 'kg', 'sex' => 'male'],
        'Woman' => ['height' => 160, 'height-unit' => 'cm', 'weight' => 85, 'weight-unit' => 'kg', 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lemmens' => ['label' => 'Lemmens'],
            'simple' => ['label' => 'mL/kg estimate'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Nadler equations</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
