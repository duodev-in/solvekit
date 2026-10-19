<x-calc.page
    title="Corrected Magnesium Calculator - SolveKit"
    description="Free corrected magnesium calculator: serum magnesium corrected for albumin (Kroll & Elin), in mmol/L and mg/dL."
    lede="Correct magnesium for albumin."
    about="About a quarter of serum magnesium is bound to albumin. Kroll & Elin (Clin Chem 1985): corrected Mg (mmol/L) = Mg + 0.005 × (40 − albumin g/L). The correction is small and less validated than for calcium; ionised magnesium is more accurate. Usual range 0.7–1.05 mmol/L (1.7–2.6 mg/dL). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'corrected_mg', 'fields' => ['mg', 'mg_unit', 'albumin', 'albumin_unit']]"
    :how-to="[
        ['name' => 'Enter magnesium', 'text' => ''],
        ['name' => 'Enter albumin', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is corrected magnesium for 0.65 mmol/L with albumin 25 g/L?', 'answer' => '0.72 mmol/L: Within the usual 0.7–1.05 mmol/L.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mg" label="Magnesium" value="0.65" min="0" step="any" />
        <x-calc.select name="mg_unit" label="Magnesium unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L', 'mEq/L' => 'mEq/L']" selected="mmol/L" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="albumin" label="Albumin" value="25" min="0" step="any" />
        <x-calc.select name="albumin_unit" label="Albumin unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L']" selected="g/L" />
    </div>

    <x-calc.result label="Corrected magnesium" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mg' => 0.65, 'mg_unit' => 'mmol/L', 'albumin' => 25, 'albumin_unit' => 'g/L'],
        'mg/dL' => ['mg' => 1.8, 'mg_unit' => 'mg/dL', 'albumin' => 3.5, 'albumin_unit' => 'g/dL'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mgdl' => ['label' => 'In mg/dL'],
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Mg + 0.005 × (40 − albumin g/L)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
