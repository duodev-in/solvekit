<x-calc.page
    title="RFM Calculator (Relative Fat Mass) - SolveKit"
    description="Free RFM calculator: relative fat mass, an estimate of body fat percentage from height and waist circumference."
    lede="Estimate body fat from height and waist."
    about="Relative fat mass = 64 − 20 × height ÷ waist (+ 12 for women), from Woolcott & Bergman (2018), who validated it against DXA in NHANES. It estimates whole-body fat percentage more accurately than BMI; in the study 40% for women and 30% for men defined obesity. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'rfm', 'fields' => ['height', 'waist', 'sex'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'waist' => collect(config('units.length'))->only(['cm', 'in'])->all()]]"
    :how-to="[
        ['name' => 'Measure the waist at the navel', 'text' => ''],
        ['name' => 'Enter height and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the RFM for 175 cm and a 90 cm waist (man)?', 'answer' => '25.1%.'],
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
        <x-calc.field name="waist" label="Waist" value="90" min="0" placeholder="Waist">
            <label for="calc-waist-unit" class="sr-only">Waist unit</label>
            <select id="calc-waist-unit" name="waist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />

    <x-calc.result label="Relative fat mass" />

    <x-calc.options :decimals="false" :examples="[
        'Man' => ['height' => 175, 'height-unit' => 'cm', 'waist' => 90, 'waist-unit' => 'cm', 'sex' => 'male'],
        'Woman' => ['height' => 163, 'height-unit' => 'cm', 'waist' => 82, 'waist-unit' => 'cm', 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'cutoff' => ['label' => 'Obesity cut-off'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RFM = 64 − 20 h/WC (+12 women)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
