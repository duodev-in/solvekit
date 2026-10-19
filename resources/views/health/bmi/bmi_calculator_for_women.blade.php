<x-calc.page
    title="BMI Calculator for Women - SolveKit"
    description="Free BMI calculator for women: body mass index, WHO category and the healthy weight range for your height."
    lede="Calculate BMI for women."
    about="BMI = weight (kg) ÷ height (m)². The WHO adult categories are underweight below 18.5, healthy 18.5–24.9, overweight 25–29.9 and obesity 30 or more (classes I, II and III from 30, 35 and 40). For people of Asian descent WHO suggests action points from 23 and 27.5. BMI does not distinguish muscle from fat, so very muscular people can score high, and it is less useful in pregnancy. For women, a waist over 80 cm (31.5 in) signals increased risk and over 88 cm (35 in) high risk (WHO). In pregnancy use pre-pregnancy weight. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'bmi', 'fields' => ['height', 'weight', 'cutoffs'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()], 'sexNote' => 'Women: a waist over 80 cm (31.5 in) is increased risk, over 88 cm (35 in) high risk (WHO)']"
    :how-to="[
        ['name' => 'Enter height and weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the BMI of a 5 ft 4 in, 150 lb woman?', 'answer' => '25.7 kg/m² (Overweight (WHO)).'],
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

    <x-calc.select name="cutoffs" label="Cut-offs" :options="['who' => 'WHO standard', 'asian' => 'WHO, for Asian populations']" selected="who" />

    <x-calc.result label="BMI" />

    <x-calc.options :decimals="false" :examples="[
        '5 ft 4 in' => ['height' => 64, 'height-unit' => 'in', 'weight' => 150, 'weight-unit' => 'lb', 'mode' => 'adult', 'cutoffs' => 'who'],
        'Metric' => ['height' => 165, 'height-unit' => 'cm', 'weight' => 62, 'weight-unit' => 'kg', 'mode' => 'adult', 'cutoffs' => 'who'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'category' => ['label' => 'Category'],
            'range' => ['label' => 'Healthy weight range'],
            'change' => ['label' => 'To the healthy range'],
            'prime' => ['label' => 'BMI Prime'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>BMI = kg ÷ m²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
