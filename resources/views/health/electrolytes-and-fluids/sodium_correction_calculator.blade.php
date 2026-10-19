<x-calc.page
    title="Sodium Correction Calculator - SolveKit"
    description="Free corrected sodium calculator: serum sodium corrected for high glucose by the Katz (1.6) and Hillier (2.4) factors."
    lede="Correct sodium for high glucose."
    about="High blood glucose pulls water out of cells and lowers measured sodium. Katz (1973): corrected Na = Na + 1.6 × (glucose − 100) ÷ 100 (mg/dL); Hillier et al. (1999) found 2.4 fits better, especially above 400 mg/dL. The corrected value shows where sodium will be once glucose is normal. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'na_glucose', 'fields' => ['na', 'glucose', 'glucose_unit']]"
    :how-to="[
        ['name' => 'Enter sodium', 'text' => ''],
        ['name' => 'Enter glucose', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the corrected sodium for Na 128 with glucose 600 mg/dL?', 'answer' => '140 mmol/L (Katz (1.6): 136 mmol/L).'],
    ]"
>
    <x-calc.field name="na" label="Measured sodium" value="128" min="0" step="any" suffix="mmol/L" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="glucose" label="Glucose" value="600" min="0" step="any" />
        <x-calc.select name="glucose_unit" label="Glucose unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <x-calc.result label="Corrected sodium" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['na' => 128, 'glucose' => 600, 'glucose_unit' => 'mg/dL'],
        'SI' => ['na' => 131, 'glucose' => 30, 'glucose_unit' => 'mmol/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'katz' => ['label' => 'Katz'],
            'hillier' => ['label' => 'Hillier'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Na + 2.4 × (glucose − 100) ÷ 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
