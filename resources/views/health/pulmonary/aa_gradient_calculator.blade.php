<x-calc.page
    title="Aa Gradient Calculator - SolveKit"
    description="Free A–a gradient calculator: alveolar–arterial oxygen gradient from FiO₂, PaO₂ and PaCO₂ by the alveolar gas equation, with the expected value for age."
    lede="Calculate the A–a oxygen gradient."
    about="Alveolar gas equation: PAO₂ = FiO₂ × (Patm − 47) − PaCO₂ ÷ 0.8, in mmHg, with water vapour pressure 47 mmHg and respiratory quotient 0.8. A–a gradient = PAO₂ − PaO₂. On room air the expected gradient is about age ÷ 4 + 4; a raised gradient points to V/Q mismatch, shunt or diffusion problems. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'aa', 'fields' => ['fio2', 'pao2', 'paco2', 'patm', 'age']]"
    :how-to="[
        ['name' => 'Enter FiO₂ and the blood gas', 'text' => ''],
        ['name' => 'Enter age', 'text' => 'For the expected value.'],
    ]"
    :faqs="[
        ['question' => 'What is the A–a gradient on room air with PaO₂ 90 and PaCO₂ 40?', 'answer' => '10 mmHg (Normal for age (expected about 14 mmHg on room air)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="fio2" label="FiO₂" value="21" min="0" max="100" step="any" suffix="%" />
        <x-calc.field name="pao2" label="PaO₂" value="90" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="paco2" label="PaCO₂" value="40" min="0" step="1" suffix="mmHg" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="patm" label="Atmospheric pressure" value="760" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="age" label="Age" value="40" min="0" step="1" suffix="years" />
    </div>

    <x-calc.result label="A–a gradient" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fio2' => 21, 'pao2' => 90, 'paco2' => 40, 'patm' => 760, 'age' => 40],
        'Raised' => ['fio2' => 21, 'pao2' => 60, 'paco2' => 32, 'patm' => 760, 'age' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pao2' => ['label' => 'Alveolar PO₂'],
            'expected' => ['label' => 'Expected for age'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A–a = FiO₂ (Patm − 47) − PaCO₂ ÷ 0.8 − PaO₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
