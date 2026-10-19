<x-calc.page
    title="GFR Calculator - Estimated Glomerular Filtration Rate - SolveKit"
    description="Free eGFR calculator: estimated glomerular filtration rate from creatinine and/or cystatin C by the race-free CKD-EPI 2021 equations, with the KDIGO CKD stage."
    lede="Estimate your kidney function (eGFR)."
    about="KDIGO and the NKF–ASN task force recommend the race-free CKD-EPI 2021 creatinine equation: eGFR = 142 × min(Scr/κ, 1)^α × max(Scr/κ, 1)^−1.200 × 0.9938^age (× 1.012 for women), with κ 0.7/0.9 and α −0.241/−0.302. Adding cystatin C gives a more accurate estimate. Stages: G1 ≥ 90, G2 60–89, G3a 45–59, G3b 30–44, G4 15–29, G5 under 15. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'gfr', 'fields' => ['mode', 'cr', 'cr_unit', 'cys', 'age', 'sex']]"
    :how-to="[
        ['name' => 'Choose creatinine, cystatin C or both', 'text' => ''],
        ['name' => 'Enter the result and your age and sex', 'text' => 'Creatinine in mg/dL or µmol/L.'],
    ]"
    :faqs="[
        ['question' => 'What is the eGFR for creatinine 1.1 mg/dL in a 55-year-old man?', 'answer' => '79 mL/min/1.73 m² (G2: mildly decreased (60–89)).'],
        ['question' => 'And creatinine 120 µmol/L in a 70-year-old woman?', 'answer' => '42 mL/min/1.73 m².'],
    ]"
>
    <x-calc.segmented name="mode" legend="Using" :options="['creatinine' => 'Creatinine', 'cystatin' => 'Cystatin C', 'both' => 'Both']" selected="creatinine" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cr" label="Creatinine" value="1.1" min="0" step="any" />
        <x-calc.select name="cr_unit" label="Creatinine unit" :options="['mg/dL' => 'mg/dL', 'µmol/L' => 'µmol/L']" selected="mg/dL" />
    </div>

    <x-calc.field name="cys" label="Cystatin C" value="1.0" min="0" step="any" suffix="mg/L" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="55" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.result label="Estimated GFR" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'creatinine', 'cr' => 1.1, 'cr_unit' => 'mg/dL', 'cys' => 1.0, 'age' => 55, 'sex' => 'male'],
        'Older woman' => ['mode' => 'creatinine', 'cr' => 120, 'cr_unit' => 'µmol/L', 'cys' => 1.0, 'age' => 70, 'sex' => 'female'],
        'Both' => ['mode' => 'both', 'cr' => 1.1, 'cr_unit' => 'mg/dL', 'cys' => 1.2, 'age' => 55, 'sex' => 'male'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'stage' => ['label' => 'CKD stage'],
            'equation' => ['label' => 'Equation'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.grid heading="All equations" name="equations" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CKD-EPI 2021: 142 × min(Scr/κ,1)^α × max(Scr/κ,1)^−1.2 × 0.9938^age</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
