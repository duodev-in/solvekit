<x-calc.page
    title="Venous Blood pH Calculator - SolveKit"
    description="Free venous blood gas calculator: estimated arterial pH, PaCO₂ and bicarbonate from a peripheral venous blood gas."
    lede="Estimate arterial values from a venous gas."
    about="A peripheral venous blood gas is easier to take than an arterial one. In the meta-analysis by Byrne et al. (Respirology 2014), venous pH was on average 0.033 lower than arterial and venous PCO₂ about 4.4 mmHg higher, but PCO₂ agreement was poor. A venous PCO₂ under 45 mmHg makes arterial hypercapnia unlikely. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'venous_ph', 'fields' => ['ph', 'pco2', 'hco3']]"
    :how-to="[
        ['name' => 'Enter the venous gas', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What arterial pH does a venous pH of 7.32 suggest?', 'answer' => 'About 7.35.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ph" label="Venous pH" value="7.32" min="0" step="0.01" />
        <x-calc.field name="pco2" label="Venous PCO₂" value="48" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="hco3" label="Venous HCO₃" value="24" min="0" step="any" suffix="mmol/L" />
    </div>

    <x-calc.result label="Estimated arterial pH" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ph' => 7.32, 'pco2' => 48, 'hco3' => 24],
        'Acidotic' => ['ph' => 7.2, 'pco2' => 40, 'hco3' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pco2' => ['label' => 'PaCO₂'],
            'hco3' => ['label' => 'HCO₃'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>arterial pH ≈ venous pH + 0.03</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
