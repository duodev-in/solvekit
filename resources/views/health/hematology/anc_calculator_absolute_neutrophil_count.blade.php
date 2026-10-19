<x-calc.page
    title="ANC Calculator — Absolute Neutrophil Count - SolveKit"
    description="Free ANC calculator: absolute neutrophil count from the white cell count and the percentages of segmented and band neutrophils, with the neutropenia grade."
    lede="Calculate the absolute neutrophil count."
    about="ANC = WBC × (segmented neutrophils % + band neutrophils %) ÷ 100. Neutropenia: mild 1,000–1,500/µL, moderate 500–1,000 and severe under 500, when infection risk is high. Some healthy people of African or Middle Eastern ancestry have lower counts (Duffy-null associated neutrophil count) without extra risk. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'anc', 'fields' => ['wbc', 'segs', 'bands']]"
    :how-to="[
        ['name' => 'Enter the white count', 'text' => '× 10⁹/L is the same as × 10³/µL.'],
        ['name' => 'Enter segs and bands', 'text' => 'From the differential.'],
    ]"
    :faqs="[
        ['question' => 'What is the ANC for WBC 4.5 with 40% segs and 5% bands?', 'answer' => '2,025/µL (Normal (1,500/µL or more)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="wbc" label="White cell count" value="4.5" min="0" step="any" suffix="× 10⁹/L" />
        <x-calc.field name="segs" label="Segmented neutrophils" value="40" min="0" max="100" step="any" suffix="%" />
        <x-calc.field name="bands" label="Band neutrophils" value="5" min="0" max="100" step="any" suffix="%" />
    </div>

    <x-calc.result label="Absolute neutrophil count" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['wbc' => 4.5, 'segs' => 40, 'bands' => 5],
        'Severe' => ['wbc' => 1.2, 'segs' => 25, 'bands' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'si' => ['label' => 'In × 10⁹/L'],
            'grade' => ['label' => 'Grade'],
            'note' => ['label' => 'Note'],
            'formula' => ['label' => 'Working'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ANC = WBC × (segs + bands) %</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
