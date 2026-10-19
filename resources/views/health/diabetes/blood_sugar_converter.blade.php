<x-calc.page
    title="Blood Sugar Converter - SolveKit"
    description="Free blood sugar converter: convert glucose between mg/dL and mmol/L, with the ADA fasting, 2-hour and random ranges."
    lede="Convert blood glucose units."
    about="Glucose is reported in mg/dL in the US and mmol/L in most other countries: 1 mmol/L = 18.016 mg/dL (molar mass 180.16 g/mol). ADA ranges: fasting under 100 mg/dL is normal, 100–125 prediabetes and 126 or more diabetes; after a 2-hour glucose test under 140, 140–199 and 200 or more. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'glucose', 'fields' => ['value', 'value_unit', 'context']]"
    :how-to="[
        ['name' => 'Enter the value and its unit', 'text' => ''],
        ['name' => 'Choose when it was measured', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 100 mg/dL in mmol/L?', 'answer' => '5.6 mmol/L.'],
        ['question' => 'What is 7 mmol/L fasting?', 'answer' => '126 mg/dL: Diabetes range (126 or more, confirm with a repeat test).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Glucose" value="100" min="0" step="any" />
        <x-calc.select name="value_unit" label="Glucose unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <x-calc.select name="context" label="Measured" :options="['fasting' => 'Fasting', 'ogtt' => '2 hours after a glucose drink (OGTT)', 'random' => 'Any time (random)']" selected="fasting" />

    <x-calc.result label="Blood glucose" />

    <x-calc.options :decimals="false" :examples="[
        '100 mg/dL' => ['value' => 100, 'value_unit' => 'mg/dL', 'context' => 'fasting'],
        '7 mmol/L' => ['value' => 7, 'value_unit' => 'mmol/L', 'context' => 'fasting'],
        'After meal' => ['value' => 165, 'value_unit' => 'mg/dL', 'context' => 'ogtt'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mgdl' => ['label' => 'mg/dL'],
            'mmol' => ['label' => 'mmol/L'],
            'ada' => ['label' => 'Ranges'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mmol/L = mg/dL ÷ 18.016</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
