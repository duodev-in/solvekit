<x-calc.page
    title="PVR Calculator - Pulmonary Vascular Resistance - SolveKit"
    description="Free PVR calculator: pulmonary vascular resistance in Wood units and dyn·s·cm⁻⁵ from mean pulmonary artery pressure, wedge pressure and cardiac output."
    lede="Calculate pulmonary vascular resistance."
    about="PVR = (mean PA pressure − pulmonary capillary wedge pressure) ÷ cardiac output, in Wood units; × 80 gives dyn·s·cm⁻⁵. The 2022 ESC/ERS guideline defines pulmonary hypertension as mean PA pressure over 20 mmHg, and pre-capillary PH as PVR over 2 Wood units with wedge 15 mmHg or less. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'pvr', 'fields' => ['mpap', 'pcwp', 'co']]"
    :how-to="[
        ['name' => 'Enter the right-heart catheter values', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the PVR with mPAP 30, PCWP 12 and CO 5?', 'answer' => '3.60 Wood units.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="mpap" label="Mean PA pressure" value="30" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="pcwp" label="Wedge pressure (PCWP)" value="12" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="co" label="Cardiac output" value="5" min="0" step="any" suffix="L/min" />
    </div>

    <x-calc.result label="Pulmonary vascular resistance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mpap' => 30, 'pcwp' => 12, 'co' => 5],
        'Normal' => ['mpap' => 16, 'pcwp' => 9, 'co' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tpg' => ['label' => 'Transpulmonary gradient'],
            'dynes' => ['label' => 'In dyn·s·cm⁻⁵'],
            'ph' => ['label' => 'Pulmonary hypertension'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PVR = (mPAP − PCWP) ÷ CO</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
