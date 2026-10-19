<x-calc.page
    title="FEUrea Calculator — Acute Kidney Injury Cause Differentiation - SolveKit"
    description="Free FEUrea calculator: fractional excretion of urea from urine and plasma urea and creatinine, useful in acute kidney injury when diuretics have been given."
    lede="Calculate the fractional excretion of urea."
    about="FEUrea = (urine urea × plasma creatinine) ÷ (plasma urea × urine creatinine) × 100. Carvounis et al. (Kidney Int 2002) found 35% or less suggests a pre-renal cause even in people taking diuretics, when FENa is unreliable; over 50% suggests intrinsic injury. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'feurea', 'fields' => ['uurea', 'purea', 'ucr', 'pcr']]"
    :how-to="[
        ['name' => 'Enter urine and plasma urea', 'text' => 'Same unit for both.'],
        ['name' => 'Enter urine and plasma creatinine', 'text' => 'Same unit for both.'],
    ]"
    :faqs="[
        ['question' => 'What is the FEUrea with urine urea 300, plasma urea 40, urine Cr 120 and plasma Cr 2.5?', 'answer' => '15.6%: 35% or less: suggests a pre-renal cause.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="uurea" label="Urine urea" value="300" min="0" step="any" />
        <x-calc.field name="purea" label="Plasma urea" value="40" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ucr" label="Urine creatinine" value="120" min="0" step="any" />
        <x-calc.field name="pcr" label="Plasma creatinine" value="2.5" min="0" step="any" />
    </div>

    <x-calc.result label="Fractional excretion of urea" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['uurea' => 300, 'purea' => 40, 'ucr' => 120, 'pcr' => 2.5],
        'Intrinsic' => ['uurea' => 250, 'purea' => 60, 'ucr' => 20, 'pcr' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FEUrea = (UUrea × PCr) ÷ (PUrea × UCr) × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
