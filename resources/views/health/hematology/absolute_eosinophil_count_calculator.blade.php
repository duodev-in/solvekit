<x-calc.page
    title="Absolute Eosinophil Count Calculator - SolveKit"
    description="Free absolute eosinophil count calculator: AEC from the white cell count and eosinophil percentage, with eosinophilia grades."
    lede="Calculate the absolute eosinophil count."
    about="AEC = WBC × eosinophil % ÷ 100. Normal is under 500/µL; 500–1,500 is mild, 1,500–5,000 moderate and over 5,000 severe eosinophilia. Allergy, asthma, drug reactions and parasites are common causes; persistent counts over 1,500 need specialist review. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'aec', 'fields' => ['wbc', 'pct']]"
    :how-to="[
        ['name' => 'Enter the white count and eosinophil %', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the AEC for WBC 8 and 9% eosinophils?', 'answer' => '720/µL: Mild eosinophilia (500–1,499).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="wbc" label="White cell count" value="8" min="0" step="any" suffix="× 10⁹/L" />
        <x-calc.field name="pct" label="Eosinophils" value="9" min="0" max="100" step="any" suffix="%" />
    </div>

    <x-calc.result label="Absolute eosinophil count" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['wbc' => 8, 'pct' => 9],
        'Normal' => ['wbc' => 6, 'pct' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'si' => ['label' => 'In × 10⁹/L'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AEC = WBC × eos %</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
