<x-calc.page
    title="PF Ratio Calculator - SolveKit"
    description="Free P/F ratio calculator: PaO₂/FiO₂ ratio with the Berlin ARDS severity bands."
    lede="Calculate the PaO₂/FiO₂ ratio."
    about="The P/F ratio = PaO₂ (mmHg) ÷ FiO₂ (as a fraction). Healthy lungs on room air give about 400–500. The Berlin definition of ARDS (2012) grades it as mild (201–300), moderate (101–200) and severe (100 or less), with PEEP of at least 5 cmH₂O and bilateral opacities. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'pf', 'fields' => ['pao2', 'fio2']]"
    :how-to="[
        ['name' => 'Enter PaO₂', 'text' => ''],
        ['name' => 'Enter FiO₂ as a percentage', 'text' => 'Room air is 21%.'],
    ]"
    :faqs="[
        ['question' => 'What is the P/F ratio with PaO₂ 90 on 40% oxygen?', 'answer' => '225: Mild ARDS range (201–300).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pao2" label="PaO₂" value="90" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="fio2" label="FiO₂" value="40" min="0" max="100" step="any" suffix="%" />
    </div>

    <x-calc.result label="PaO₂/FiO₂ ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pao2' => 90, 'fio2' => 40],
        'Room air' => ['pao2' => 95, 'fio2' => 21],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'note' => ['label' => 'Berlin definition'],
            'sofa' => ['label' => 'SOFA respiration'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P/F = PaO₂ ÷ FiO₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
