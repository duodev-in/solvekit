<x-calc.page
    title="Albumin Creatinine Ratio Calculator - SolveKit"
    description="Free albumin-to-creatinine ratio calculator: urine ACR in mg/g and mg/mmol from urine albumin and creatinine, with the KDIGO albuminuria category."
    lede="Calculate the urine albumin-to-creatinine ratio."
    about="The urine albumin-to-creatinine ratio (ACR) on a spot sample estimates daily albumin loss. KDIGO categories: A1 under 30 mg/g (3 mg/mmol), A2 30–300 mg/g (3–30 mg/mmol), A3 over 300 mg/g. Together with eGFR it stages chronic kidney disease and predicts kidney and heart risk. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'acr', 'fields' => ['albumin', 'ucr', 'ucr_unit']]"
    :how-to="[
        ['name' => 'Enter urine albumin', 'text' => 'In mg/L.'],
        ['name' => 'Enter urine creatinine', 'text' => 'mg/dL or mmol/L.'],
    ]"
    :faqs="[
        ['question' => 'What is the ACR with albumin 45 mg/L and creatinine 100 mg/dL?', 'answer' => '45 mg/g (A2: moderately increased (30–300 mg/g)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="albumin" label="Urine albumin" value="45" min="0" step="any" suffix="mg/L" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ucr" label="Urine creatinine" value="100" min="0" step="any" />
        <x-calc.select name="ucr_unit" label="Urine creatinine unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L', 'µmol/L' => 'µmol/L']" selected="mg/dL" />
    </div>

    <x-calc.result label="Albumin-to-creatinine ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['albumin' => 45, 'ucr' => 100, 'ucr_unit' => 'mg/dL'],
        'mmol/L' => ['albumin' => 120, 'ucr' => 8, 'ucr_unit' => 'mmol/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mmol' => ['label' => 'In mg/mmol'],
            'stage' => ['label' => 'KDIGO category'],
            'confirm' => ['label' => 'Confirming'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ACR (mg/g) = albumin (mg/L) ÷ creatinine (mg/dL) × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
