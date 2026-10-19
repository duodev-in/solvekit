<x-calc.page
    title="ABSI Calculator - SolveKit"
    description="Free ABSI calculator: A Body Shape Index from waist, height and weight, which adds waist size to BMI as a marker of central fat."
    lede="Work out your A Body Shape Index."
    about="ABSI = waist ÷ (BMI^⅔ × height^½), with waist and height in metres (Krakauer & Krakauer 2012). It captures how much of your weight sits at the waist; in US NHANES data higher ABSI predicted higher mortality independently of BMI. Compare your own value over time; the published risk z-scores need age- and sex-specific tables. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'absi', 'fields' => ['height', 'weight', 'waist'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all(), 'waist' => collect(config('units.length'))->only(['cm', 'in'])->all()]]"
    :how-to="[
        ['name' => 'Measure your waist', 'text' => 'Midway between the lowest rib and the top of the hip bone.'],
        ['name' => 'Enter height and weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the ABSI for 175 cm, 80 kg and a 90 cm waist?', 'answer' => '0.0773.'],
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

    <x-calc.field name="waist" label="Waist circumference" value="90" min="0" placeholder="Waist circumference">
        <label for="calc-waist-unit" class="sr-only">Waist circumference unit</label>
        <select id="calc-waist-unit" name="waist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="A Body Shape Index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'waist' => 90, 'waist-unit' => 'cm'],
        'Larger waist' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'waist' => 105, 'waist-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'bmi' => ['label' => 'BMI'],
            'meaning' => ['label' => 'What it means'],
            'typical' => ['label' => 'Typical values'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ABSI = WC ÷ (BMI^⅔ × h^½)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
