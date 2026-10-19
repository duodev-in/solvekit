<x-calc.page
    title="mmol/L to mg/dL Calculator - SolveKit"
    description="Free mmol/L to mg/dL calculator: convert glucose, cholesterol, triglycerides, creatinine, urea, calcium, bilirubin, uric acid and more between SI and conventional units."
    lede="Convert lab results between mmol/L and mg/dL."
    about="SI units (mmol/L, µmol/L) count molecules; conventional US units (mg/dL) weigh them, so each analyte has its own factor from its molar mass: glucose 18.016, cholesterol 38.67, triglycerides 88.57, creatinine 88.42 (µmol/L per mg/dL), urea to BUN 2.801, calcium 4.008, bilirubin 17.1, uric acid 59.48. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'lab_convert', 'fields' => ['value', 'analyte', 'direction']]"
    :how-to="[
        ['name' => 'Enter the value', 'text' => ''],
        ['name' => 'Choose the test and direction', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 5.5 mmol/L glucose in mg/dL?', 'answer' => '99.09 mg/dL.'],
        ['question' => 'What is 90 µmol/L creatinine in mg/dL?', 'answer' => '1.02 mg/dL.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="value" label="Value" value="5.5" min="0" step="any" />
        <x-calc.select name="analyte" label="Test" :options="['glucose' => 'Glucose', 'cholesterol' => 'Cholesterol', 'triglycerides' => 'Triglycerides', 'creatinine' => 'Creatinine', 'bun' => 'Urea / BUN', 'calcium' => 'Calcium', 'magnesium' => 'Magnesium', 'bilirubin' => 'Bilirubin', 'uric' => 'Uric acid', 'hemoglobin' => 'Hemoglobin', 'albumin' => 'Albumin', 'iron' => 'Iron']" selected="glucose" />
        <x-calc.select name="direction" label="Convert" :options="['from_si' => 'SI (mmol/L, µmol/L, g/L) to conventional', 'to_si' => 'Conventional (mg/dL, g/dL) to SI']" selected="from_si" />
    </div>

    <x-calc.result label="Converted value" />

    <x-calc.options :decimals="false" :examples="[
        'Glucose' => ['value' => 5.5, 'analyte' => 'glucose', 'direction' => 'from_si'],
        'Creatinine' => ['value' => 90, 'analyte' => 'creatinine', 'direction' => 'from_si'],
        'Cholesterol' => ['value' => 200, 'analyte' => 'cholesterol', 'direction' => 'to_si'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'factor' => ['label' => 'Factor'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.grid heading="All units" name="all" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>conventional = SI × factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
