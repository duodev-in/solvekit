<x-calc.page
    title="TTKG Calculator - Transtubular Potassium Gradient - SolveKit"
    description="Free TTKG calculator: transtubular potassium gradient from urine and plasma potassium and osmolality, with the interpretation for low or high potassium."
    lede="Calculate the transtubular potassium gradient."
    about="TTKG = (urine K ÷ plasma K) ÷ (urine osmolality ÷ plasma osmolality) (West 1986). It estimates potassium secretion in the collecting duct. With low potassium, under 3 suggests losses outside the kidney; with high potassium, under 7 suggests low aldosterone effect. It is only valid when urine osmolality exceeds plasma osmolality. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'ttkg', 'fields' => ['uk', 'pk', 'uosm', 'posm']]"
    :how-to="[
        ['name' => 'Enter urine and plasma potassium', 'text' => ''],
        ['name' => 'Enter urine and plasma osmolality', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the TTKG for urine K 40, plasma K 3.0, osmolality 600 and 290?', 'answer' => '6.4: With low potassium, over 3 suggests kidney potassium loss.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="uk" label="Urine potassium" value="40" min="0" step="any" suffix="mmol/L" />
        <x-calc.field name="pk" label="Plasma potassium" value="3.0" min="0" step="any" suffix="mmol/L" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="uosm" label="Urine osmolality" value="600" min="0" step="any" suffix="mOsm/kg" />
        <x-calc.field name="posm" label="Plasma osmolality" value="290" min="0" step="any" suffix="mOsm/kg" />
    </div>

    <x-calc.result label="Transtubular potassium gradient" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['uk' => 40, 'pk' => 3.0, 'uosm' => 600, 'posm' => 290],
        'High K' => ['uk' => 20, 'pk' => 6.0, 'uosm' => 450, 'posm' => 295],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'valid' => ['label' => 'Validity'],
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>TTKG = (UK ÷ PK) ÷ (Uosm ÷ Posm)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
