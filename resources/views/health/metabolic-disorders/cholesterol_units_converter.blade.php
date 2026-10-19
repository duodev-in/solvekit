<x-calc.page
    title="Cholesterol Units Converter - SolveKit"
    description="Free cholesterol units converter: convert cholesterol (total, LDL, HDL) and triglycerides between mg/dL and mmol/L."
    lede="Convert cholesterol units."
    about="Cholesterol: 1 mmol/L = 38.67 mg/dL (molar mass 386.65). Triglycerides: 1 mmol/L = 88.57 mg/dL (as triolein). The same factor applies to total, LDL and HDL cholesterol. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'chol_units', 'fields' => ['value', 'unit', 'analyte']]"
    :how-to="[
        ['name' => 'Enter the value and unit', 'text' => ''],
        ['name' => 'Choose cholesterol or triglycerides', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 200 mg/dL cholesterol in mmol/L?', 'answer' => '5.17 mmol/L.'],
        ['question' => 'And 1.7 mmol/L triglycerides in mg/dL?', 'answer' => '151 mg/dL.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="value" label="Value" value="200" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
        <x-calc.select name="analyte" label="Measure" :options="['cholesterol' => 'Cholesterol (total, LDL, HDL)', 'triglycerides' => 'Triglycerides']" selected="cholesterol" />
    </div>

    <x-calc.result label="Converted value" />

    <x-calc.options :decimals="false" :examples="[
        '200 mg/dL' => ['value' => 200, 'unit' => 'mg/dL', 'analyte' => 'cholesterol'],
        'Triglycerides' => ['value' => 1.7, 'unit' => 'mmol/L', 'analyte' => 'triglycerides'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'factor' => ['label' => 'Factor'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mg/dL = mmol/L × 38.67 (cholesterol)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
