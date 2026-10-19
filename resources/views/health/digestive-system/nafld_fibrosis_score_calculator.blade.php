<x-calc.page
    title="NAFLD Fibrosis Score Calculator - SolveKit"
    description="Free NAFLD fibrosis score calculator: advanced fibrosis risk in fatty liver disease from age, BMI, diabetes, AST/ALT, platelets and albumin."
    lede="Calculate the NAFLD fibrosis score."
    about="Angulo et al. (2007): NFS = −1.675 + 0.037 × age + 0.094 × BMI + 1.13 × (impaired fasting glucose or diabetes) + 0.99 × AST/ALT − 0.013 × platelets − 0.66 × albumin (g/dL). Under −1.455 makes advanced fibrosis unlikely and over 0.676 likely; in between is indeterminate. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'nfs', 'fields' => ['age', 'height', 'weight', 'ast', 'alt', 'platelets', 'albumin', 'albumin_unit', 'diabetes'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter age, height and weight', 'text' => ''],
        ['name' => 'Enter the blood tests', 'text' => ''],
        ['name' => 'Tick diabetes', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the NFS for a 55-year-old, BMI 32.9, AST 40, ALT 50, platelets 200, albumin 4.2, no diabetes?', 'answer' => '-1.13: −1.455 to 0.676: indeterminate.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Age" value="55" min="0" step="1" suffix="years" />
        <x-calc.field name="height" label="Height" value="170" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weight" label="Weight" value="95" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ast" label="AST" value="40" min="0" step="any" suffix="U/L" />
        <x-calc.field name="alt" label="ALT" value="50" min="0" step="any" suffix="U/L" />
        <x-calc.field name="platelets" label="Platelets" value="200" min="0" step="any" suffix="× 10⁹/L" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="albumin" label="Albumin" value="4.2" min="0" step="any" />
        <x-calc.select name="albumin_unit" label="Albumin unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L']" selected="g/dL" />
    </div>

    <x-calc.checkbox name="diabetes" label="Impaired fasting glucose or diabetes" :checked="false" />

    <x-calc.result label="NAFLD fibrosis score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 55, 'height' => 170, 'height-unit' => 'cm', 'weight' => 95, 'weight-unit' => 'kg', 'ast' => 40, 'alt' => 50, 'platelets' => 200, 'albumin' => 4.2, 'albumin_unit' => 'g/dL', 'diabetes' => false],
        'High' => ['age' => 64, 'height' => 165, 'height-unit' => 'cm', 'weight' => 105, 'weight-unit' => 'kg', 'ast' => 70, 'alt' => 50, 'platelets' => 120, 'albumin' => 3.6, 'albumin_unit' => 'g/dL', 'diabetes' => true],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'bmi' => ['label' => 'BMI'],
            'formula' => ['label' => 'Formula'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NFS (Angulo 2007)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
