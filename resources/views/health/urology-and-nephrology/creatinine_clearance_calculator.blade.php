<x-calc.page
    title="Creatinine Clearance Calculator - SolveKit"
    description="Free creatinine clearance calculator: Cockcroft–Gault CrCl with actual, ideal and adjusted body weight."
    lede="Calculate creatinine clearance (Cockcroft–Gault)."
    about="Cockcroft & Gault (1976): CrCl (mL/min) = (140 − age) × weight (kg) ÷ (72 × creatinine mg/dL), × 0.85 for women. Ideal body weight (Devine) is often used, actual weight if lower, and adjusted weight (IBW + 0.4 × excess) in obesity. Drug labels often quote Cockcroft–Gault, though eGFR is used to stage kidney disease. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'crcl', 'fields' => ['age', 'sex', 'cr', 'cr_unit', 'weight', 'height'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all(), 'height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter age, sex and creatinine', 'text' => ''],
        ['name' => 'Enter weight and height', 'text' => 'Height gives ideal and adjusted weight.'],
    ]"
    :faqs="[
        ['question' => 'What is the CrCl for a 65-year-old man, 85 kg, 170 cm, creatinine 1.2?', 'answer' => '64 mL/min (Using adjusted body weight (actual weight over 120% of ideal)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Age" value="65" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="cr" label="Creatinine" value="1.2" min="0" step="any" />
            <x-calc.select name="cr_unit" label="Creatinine unit" :options="['mg/dL' => 'mg/dL', 'µmol/L' => 'µmol/L']" selected="mg/dL" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Weight" value="85" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
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

    <x-calc.result label="Creatinine clearance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 65, 'sex' => 'male', 'cr' => 1.2, 'cr_unit' => 'mg/dL', 'weight' => 85, 'weight-unit' => 'kg', 'height' => 170, 'height-unit' => 'cm'],
        'Woman' => ['age' => 78, 'sex' => 'female', 'cr' => 90, 'cr_unit' => 'µmol/L', 'weight' => 58, 'weight-unit' => 'kg', 'height' => 160, 'height-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
            'source' => ['label' => 'Source'],
        ]" />
        <x-calc.grid heading="By weight" name="weights" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CrCl = (140 − age) × kg ÷ (72 × Cr)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
