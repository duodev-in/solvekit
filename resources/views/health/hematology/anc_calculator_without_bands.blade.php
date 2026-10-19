<x-calc.page
    title="ANC Calculator without Bands - SolveKit"
    description="Free ANC calculator without bands: absolute neutrophil count from the white cell count and the total neutrophil percentage, as most analysers report it."
    lede="Calculate ANC from total neutrophils."
    about="Most automated analysers report total neutrophils rather than separate segs and bands. ANC = WBC × neutrophil % ÷ 100, or simply the absolute neutrophil value on the report. Severe neutropenia (under 500/µL) needs urgent advice if there is a fever. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'anc', 'fields' => ['wbc', 'segs']]"
    :how-to="[
        ['name' => 'Enter the white count and neutrophil %', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the ANC for WBC 6 and 55% neutrophils?', 'answer' => '3,300/µL.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="wbc" label="White cell count" value="6" min="0" step="any" suffix="× 10⁹/L" />
        <x-calc.field name="segs" label="Neutrophils" value="55" min="0" max="100" step="any" suffix="%" />
    </div>

    <x-calc.result label="Absolute neutrophil count" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['wbc' => 6, 'segs' => 55],
        'Low' => ['wbc' => 2.5, 'segs' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'si' => ['label' => 'In × 10⁹/L'],
            'grade' => ['label' => 'Grade'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ANC = WBC × neutrophil %</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
