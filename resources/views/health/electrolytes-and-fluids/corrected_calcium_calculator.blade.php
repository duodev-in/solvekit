<x-calc.page
    title="Corrected Calcium Calculator - SolveKit"
    description="Free corrected calcium calculator: total calcium corrected for low albumin (Payne formula), in mg/dL or mmol/L."
    lede="Correct calcium for albumin."
    about="About 40% of calcium is bound to albumin, so low albumin makes total calcium look low. Payne et al. (1973): corrected calcium (mg/dL) = measured calcium + 0.8 × (4.0 − albumin g/dL); in SI units, Ca (mmol/L) + 0.02 × (40 − albumin g/L). The usual range is 8.5–10.5 mg/dL (2.12–2.62 mmol/L). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'corrected_ca', 'fields' => ['ca', 'ca_unit', 'albumin', 'albumin_unit']]"
    :how-to="[
        ['name' => 'Enter total calcium', 'text' => ''],
        ['name' => 'Enter albumin', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the corrected calcium for Ca 7.8 mg/dL and albumin 2.5 g/dL?', 'answer' => '9.0 mg/dL: Within the usual 8.5–10.5 mg/dL.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ca" label="Total calcium" value="7.8" min="0" step="any" />
        <x-calc.select name="ca_unit" label="Total calcium unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="albumin" label="Albumin" value="2.5" min="0" step="any" />
        <x-calc.select name="albumin_unit" label="Albumin unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L']" selected="g/dL" />
    </div>

    <x-calc.result label="Corrected calcium" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ca' => 7.8, 'ca_unit' => 'mg/dL', 'albumin' => 2.5, 'albumin_unit' => 'g/dL'],
        'SI' => ['ca' => 2.0, 'ca_unit' => 'mmol/L', 'albumin' => 28, 'albumin_unit' => 'g/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'si' => ['label' => 'In mmol/L'],
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Ca + 0.8 × (4 − albumin)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
