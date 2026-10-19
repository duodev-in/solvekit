<x-calc.page
    title="BRI Calculator — Body Roundness Index - SolveKit"
    description="Free BRI calculator: Body Roundness Index from waist and height, with the mortality groups from US NHANES data."
    lede="Work out your Body Roundness Index."
    about="BRI models the body as an ellipse: BRI = 364.2 − 365.5 × √(1 − (waist ÷ 2π)² ÷ (½ height)²) (Thomas et al. 2013). In US adults followed for up to 19 years, the lowest mortality was at BRI 4.45–5.46, with higher risk below 3.41 and at 6.91 or more (Zhang et al. 2024). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'bri', 'fields' => ['waist', 'height'], 'unitFields' => ['waist' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the waist', 'text' => ''],
        ['name' => 'Enter height', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the BRI for a 90 cm waist and 175 cm height?', 'answer' => '3.63 (3.41–4.45).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="waist" label="Waist" value="90" min="0" placeholder="Waist">
            <label for="calc-waist-unit" class="sr-only">Waist unit</label>
            <select id="calc-waist-unit" name="waist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Height" value="170" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Body Roundness Index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['waist' => 90, 'waist-unit' => 'cm', 'height' => 175, 'height-unit' => 'cm'],
        'Larger waist' => ['waist' => 110, 'waist-unit' => 'cm', 'height' => 175, 'height-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'eccentricity' => ['label' => 'Eccentricity'],
            'study' => ['label' => 'Study'],
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>BRI = 364.2 − 365.5 √(1 − (WC/2π)² ÷ (h/2)²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
