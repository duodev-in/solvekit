<x-calc.page
    title="Absolute Lymphocyte Count Calculator - SolveKit"
    description="Free absolute lymphocyte count calculator: ALC from the white cell count and lymphocyte percentage, with lymphopenia and lymphocytosis bands."
    lede="Calculate the absolute lymphocyte count."
    about="ALC = WBC × lymphocyte % ÷ 100. In adults, under 1,000/µL is lymphopenia (from infections such as HIV, steroids, chemotherapy, or malnutrition) and over 4,000/µL lymphocytosis (viral infections, chronic lymphocytic leukaemia). Children have higher normal values. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'alc', 'fields' => ['wbc', 'pct']]"
    :how-to="[
        ['name' => 'Enter the white count and lymphocyte %', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the ALC for WBC 7 and 30% lymphocytes?', 'answer' => '2,100/µL.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="wbc" label="White cell count" value="7" min="0" step="any" suffix="× 10⁹/L" />
        <x-calc.field name="pct" label="Lymphocytes" value="30" min="0" max="100" step="any" suffix="%" />
    </div>

    <x-calc.result label="Absolute lymphocyte count" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['wbc' => 7, 'pct' => 30],
        'Low' => ['wbc' => 3, 'pct' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'si' => ['label' => 'In × 10⁹/L'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ALC = WBC × lymph %</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
