<x-calc.page
    title="Arterial Blood pH Calculator - SolveKit"
    description="Free arterial blood pH calculator: pH from PaCO₂ and bicarbonate by the Henderson–Hasselbalch equation, with H⁺ concentration."
    lede="Calculate blood pH from PaCO₂ and HCO₃."
    about="The Henderson–Hasselbalch equation for blood: pH = 6.1 + log₁₀(HCO₃ ÷ (0.03 × PaCO₂)), where 6.1 is the pKa of carbonic acid and 0.03 the solubility of CO₂ (mmol/L per mmHg). Normal arterial pH is 7.35–7.45 (H⁺ 35–45 nmol/L). Comparing it with the measured pH checks a blood gas for internal consistency. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'arterial_ph', 'fields' => ['pco2', 'hco3']]"
    :how-to="[
        ['name' => 'Enter PaCO₂ and HCO₃', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the pH for PaCO₂ 40 and HCO₃ 24?', 'answer' => '7.40.'],
        ['question' => 'And PaCO₂ 60, HCO₃ 26?', 'answer' => '7.26.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pco2" label="PaCO₂" value="40" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="hco3" label="HCO₃" value="24" min="0" step="any" suffix="mmol/L" />
    </div>

    <x-calc.result label="Arterial pH" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pco2' => 40, 'hco3' => 24],
        'Acidaemia' => ['pco2' => 60, 'hco3' => 26],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hplus' => ['label' => 'H⁺'],
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pH = 6.1 + log(HCO₃ ÷ 0.03 PaCO₂)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
