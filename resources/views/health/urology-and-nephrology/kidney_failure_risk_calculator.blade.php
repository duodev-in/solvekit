<x-calc.page
    title="Kidney Failure Risk Calculator - SolveKit"
    description="Free kidney failure risk calculator: the 4-variable Kidney Failure Risk Equation (KFRE) for 2- and 5-year risk of needing dialysis or a transplant, from age, sex, eGFR and urine ACR."
    lede="Estimate your risk of kidney failure (KFRE)."
    about="The Kidney Failure Risk Equation (Tangri et al., JAMA 2011, recalibrated in 2016 across 31 cohorts) predicts kidney failure for adults with CKD stage 3–5 (eGFR under 60). Non-North American baseline risks are lower than North American ones. NICE (2021) suggests referral to a kidney specialist at a 5-year risk over 5%. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'kfre', 'fields' => ['age', 'sex', 'egfr', 'acr', 'acr_unit', 'region']]"
    :how-to="[
        ['name' => 'Enter age, sex and eGFR', 'text' => ''],
        ['name' => 'Enter urine ACR', 'text' => ''],
        ['name' => 'Choose the calibration', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the 5-year risk for a 65-year-old man, eGFR 35, ACR 300 mg/g?', 'answer' => '11.3% (3.1% at 2 years (needing dialysis or a transplant)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Age" value="65" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.field name="egfr" label="eGFR" value="35" min="0" step="any" suffix="mL/min/1.73 m²" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="acr" label="Urine ACR" value="300" min="0" step="any" />
        <x-calc.select name="acr_unit" label="ACR unit" :options="['mg/g' => 'mg/g', 'mg/mmol' => 'mg/mmol']" selected="mg/g" />
        <x-calc.select name="region" label="Calibration" :options="['other' => 'Outside North America', 'na' => 'North America']" selected="other" />
    </div>

    <x-calc.result label="5-year kidney failure risk" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 65, 'sex' => 'male', 'egfr' => 35, 'acr' => 300, 'acr_unit' => 'mg/g', 'region' => 'other'],
        'Low risk' => ['age' => 72, 'sex' => 'female', 'egfr' => 52, 'acr' => 3, 'acr_unit' => 'mg/mmol', 'region' => 'na'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'two' => ['label' => '2-year risk'],
            'five' => ['label' => '5-year risk'],
            'use' => ['label' => 'Referral'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>risk = 1 − S₀^exp(Σβ(x − x̄))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
