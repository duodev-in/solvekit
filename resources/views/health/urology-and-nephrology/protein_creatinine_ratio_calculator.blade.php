<x-calc.page
    title="Protein Creatinine Ratio Calculator - SolveKit"
    description="Free urine protein-to-creatinine ratio calculator: PCR in mg/mg, mg/g and mg/mmol from a spot urine, with the estimated daily protein loss."
    lede="Calculate the urine protein-to-creatinine ratio."
    about="A spot urine protein-to-creatinine ratio in mg/mg roughly equals grams of protein lost in 24 hours. KDIGO: under 150 mg/g (15 mg/mmol) is normal to mildly increased, 150–500 moderately increased and over 500 severely increased; about 3,000–3,500 mg/g or more is nephrotic range. Choose the units printed on your report. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'pcr', 'fields' => ['protein', 'protein_unit', 'ucr', 'ucr_unit']]"
    :how-to="[
        ['name' => 'Enter urine protein and its unit', 'text' => ''],
        ['name' => 'Enter urine creatinine and its unit', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the PCR for protein 30 mg/dL and creatinine 100 mg/dL?', 'answer' => '0.30 mg/mg (About 0.30 g of protein a day; moderately increased (150–500 mg/g)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="protein" label="Urine protein" value="30" min="0" step="any" />
        <x-calc.select name="protein_unit" label="Protein unit" :options="['mg/dL' => 'mg/dL', 'mg/L' => 'mg/L', 'g/L' => 'g/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ucr" label="Urine creatinine" value="100" min="0" step="any" />
        <x-calc.select name="ucr_unit" label="Urine creatinine unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L', 'µmol/L' => 'µmol/L']" selected="mg/dL" />
    </div>

    <x-calc.result label="Protein-to-creatinine ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['protein' => 30, 'protein_unit' => 'mg/dL', 'ucr' => 100, 'ucr_unit' => 'mg/dL'],
        'SI units' => ['protein' => 0.9, 'protein_unit' => 'g/L', 'ucr' => 6, 'ucr_unit' => 'mmol/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mgG' => ['label' => 'In mg/g'],
            'mmol' => ['label' => 'In mg/mmol'],
            'band' => ['label' => 'Category'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PCR = protein ÷ creatinine</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
