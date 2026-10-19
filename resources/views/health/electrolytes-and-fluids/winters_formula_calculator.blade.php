<x-calc.page
    title="Winters' Formula Calculator - SolveKit"
    description="Free Winters' formula calculator: the expected PaCO₂ in metabolic acidosis, and whether the measured PaCO₂ shows a second respiratory disorder."
    lede="Check respiratory compensation with Winters' formula."
    about="Winters' formula (Albert, Dell & Winters 1967) predicts the PaCO₂ when the lungs compensate for a metabolic acidosis: expected PaCO₂ = 1.5 × HCO₃ + 8 ± 2 mmHg. A higher measured PaCO₂ means a coexisting respiratory acidosis; a lower one a respiratory alkalosis. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'winters', 'fields' => ['hco3', 'pco2']]"
    :how-to="[
        ['name' => 'Enter bicarbonate', 'text' => ''],
        ['name' => 'Enter the measured PaCO₂', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What PaCO₂ is expected with HCO₃ 12?', 'answer' => '24–28 mmHg: Within the range: appropriate respiratory compensation at 26.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hco3" label="HCO₃" value="12" min="0" step="any" suffix="mmol/L" />
        <x-calc.field name="pco2" label="Measured PaCO₂" value="26" min="0" step="1" suffix="mmHg" />
    </div>

    <x-calc.result label="Expected PaCO₂" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['hco3' => 12, 'pco2' => 26],
        'Mixed' => ['hco3' => 12, 'pco2' => 35],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PaCO₂ = 1.5 × HCO₃ + 8 ± 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
