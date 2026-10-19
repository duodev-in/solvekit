<x-calc.page
    title="FENa Calculator (Fractional Excretion of Sodium) - SolveKit"
    description="Free FENa calculator: fractional excretion of sodium from urine and plasma sodium and creatinine, to help separate pre-renal from intrinsic acute kidney injury."
    lede="Calculate the fractional excretion of sodium."
    about="FENa = (urine Na × plasma creatinine) ÷ (plasma Na × urine creatinine) × 100. In oliguric acute kidney injury, under 1% suggests a pre-renal cause and over 2% acute tubular necrosis. Diuretics, chronic kidney disease and contrast injury can mislead it; FEUrea is used with diuretics. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'fena', 'fields' => ['una', 'pna', 'ucr', 'pcr', 'cr_unit']]"
    :how-to="[
        ['name' => 'Enter urine and plasma sodium', 'text' => ''],
        ['name' => 'Enter urine and plasma creatinine', 'text' => 'In the same unit.'],
    ]"
    :faqs="[
        ['question' => 'What is the FENa with urine Na 20, plasma Na 138, urine Cr 120 and plasma Cr 2.5?', 'answer' => '0.30%: Under 1%: suggests a pre-renal cause.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="una" label="Urine sodium" value="20" min="0" step="any" suffix="mmol/L" />
        <x-calc.field name="pna" label="Plasma sodium" value="138" min="0" step="any" suffix="mmol/L" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ucr" label="Urine creatinine" value="120" min="0" step="any" />
        <x-calc.field name="pcr" label="Plasma creatinine" value="2.5" min="0" step="any" />
    </div>

    <x-calc.select name="cr_unit" label="Creatinine unit (both)" :options="['mg/dL' => 'mg/dL', 'µmol/L' => 'µmol/L', 'mmol/L' => 'mmol/L']" selected="mg/dL" />

    <x-calc.result label="Fractional excretion of sodium" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['una' => 20, 'pna' => 138, 'ucr' => 120, 'pcr' => 2.5, 'cr_unit' => 'mg/dL'],
        'ATN' => ['una' => 60, 'pna' => 136, 'ucr' => 40, 'pcr' => 3.2, 'cr_unit' => 'mg/dL'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FENa = (UNa × PCr) ÷ (PNa × UCr) × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
