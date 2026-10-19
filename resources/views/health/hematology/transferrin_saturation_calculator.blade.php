<x-calc.page
    title="Transferrin Saturation Calculator - SolveKit"
    description="Free transferrin saturation calculator: TSAT % from serum iron and total iron-binding capacity (TIBC)."
    lede="Calculate transferrin saturation."
    about="Transferrin saturation = serum iron ÷ TIBC × 100. Under 20% (with low ferritin) suggests iron deficiency; over 45% on a fasting sample is the usual screening point for iron overload such as hereditary haemochromatosis. Iron and TIBC must be in the same units (µg/dL or µmol/L). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'tsat', 'fields' => ['iron', 'tibc']]"
    :how-to="[
        ['name' => 'Enter serum iron and TIBC', 'text' => 'In the same unit.'],
    ]"
    :faqs="[
        ['question' => 'What is the TSAT with iron 60 and TIBC 400 µg/dL?', 'answer' => '15%: Under 20%: suggests iron deficiency (check ferritin).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="iron" label="Serum iron" value="60" min="0" step="any" />
        <x-calc.field name="tibc" label="TIBC" value="400" min="0" step="any" />
    </div>

    <x-calc.result label="Transferrin saturation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['iron' => 60, 'tibc' => 400],
        'Overload' => ['iron' => 40, 'tibc' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>TSAT = iron ÷ TIBC × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
