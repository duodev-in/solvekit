<x-calc.page
    title="Oxygenation Index Calculator - SolveKit"
    description="Free oxygenation index calculator: OI from FiO₂, mean airway pressure and PaO₂, with the severity bands used in neonatal and paediatric care."
    lede="Calculate the oxygenation index."
    about="Oxygenation index = FiO₂ (%) × mean airway pressure (cmH₂O) ÷ PaO₂ (mmHg). Unlike the P/F ratio it accounts for ventilator pressure. In paediatric ARDS (PALICC) 4–8 is mild, 8–16 moderate and 16 or more severe; in neonates an OI of 40 or more is a common ECMO criterion. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'oi', 'fields' => ['fio2', 'map', 'pao2']]"
    :how-to="[
        ['name' => 'Enter FiO₂, mean airway pressure and PaO₂', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the OI at FiO₂ 60%, MAP 15 and PaO₂ 70?', 'answer' => '12.9: Moderate paediatric ARDS (8–16).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="fio2" label="FiO₂" value="60" min="0" max="100" step="any" suffix="%" />
        <x-calc.field name="map" label="Mean airway pressure" value="15" min="0" step="any" suffix="cmH₂O" />
        <x-calc.field name="pao2" label="PaO₂" value="70" min="0" step="1" suffix="mmHg" />
    </div>

    <x-calc.result label="Oxygenation index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fio2' => 60, 'map' => 15, 'pao2' => 70],
        'Severe' => ['fio2' => 100, 'map' => 20, 'pao2' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'neonatal' => ['label' => 'Neonates'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>OI = FiO₂ × MAP ÷ PaO₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
