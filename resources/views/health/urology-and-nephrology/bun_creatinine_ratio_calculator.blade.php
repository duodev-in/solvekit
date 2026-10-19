<x-calc.page
    title="BUN Creatinine Ratio Calculator - SolveKit"
    description="Free BUN to creatinine ratio calculator: the BUN:creatinine ratio (and urea:creatinine in SI units) with what high and low values suggest."
    lede="Calculate the BUN-to-creatinine ratio."
    about="The BUN-to-creatinine ratio is normally about 10–20. Over 20 suggests reduced kidney blood flow (dehydration, heart failure, bleeding) or a high protein load; under 10 is seen with intrinsic kidney injury, liver disease or low protein intake. In SI units the urea (mmol/L) to creatinine (µmol/L) ratio × 1,000 is used, with over 100 suggesting a pre-renal cause. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'bun_cr', 'fields' => ['bun', 'bun_unit', 'cr', 'cr_unit']]"
    :how-to="[
        ['name' => 'Enter urea or BUN', 'text' => ''],
        ['name' => 'Enter creatinine', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the ratio for BUN 28 and creatinine 1.0?', 'answer' => '28: Over 20: suggests a pre-renal cause (dehydration, bleeding, heart failure) or high protein load.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bun" label="Urea (BUN)" value="28" min="0" step="any" />
        <x-calc.select name="bun_unit" label="Urea (BUN) unit" :options="['mg/dL BUN' => 'mg/dL BUN', 'mmol/L urea' => 'mmol/L urea']" selected="mg/dL BUN" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cr" label="Creatinine" value="1.0" min="0" step="any" />
        <x-calc.select name="cr_unit" label="Creatinine unit" :options="['mg/dL' => 'mg/dL', 'µmol/L' => 'µmol/L']" selected="mg/dL" />
    </div>

    <x-calc.result label="BUN-to-creatinine ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bun' => 28, 'bun_unit' => 'mg/dL BUN', 'cr' => 1.0, 'cr_unit' => 'mg/dL'],
        'SI' => ['bun' => 7, 'bun_unit' => 'mmol/L urea', 'cr' => 90, 'cr_unit' => 'µmol/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'si' => ['label' => 'SI ratio'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ratio = BUN ÷ creatinine</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
