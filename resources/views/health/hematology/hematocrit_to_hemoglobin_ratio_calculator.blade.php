<x-calc.page
    title="Hematocrit to Hemoglobin Ratio Calculator - SolveKit"
    description="Free hematocrit to hemoglobin calculator: estimate one from the other with the rule of three (Hct ≈ 3 × Hb)."
    lede="Convert between haematocrit and haemoglobin."
    about="For normal-sized, normally filled red cells, haematocrit (%) is about three times the haemoglobin (g/dL), because the MCHC is about 33 g/dL. The rule breaks down when MCHC is abnormal, as in iron deficiency or spherocytosis, so use it as a quick check rather than a substitute for measurement. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'hct_hb', 'fields' => ['from', 'hb', 'hct']]"
    :how-to="[
        ['name' => 'Choose what you have', 'text' => ''],
        ['name' => 'Enter the value', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What haematocrit goes with Hb 14 g/dL?', 'answer' => '42%.'],
    ]"
>
    <x-calc.segmented name="from" legend="I have" :options="['hb' => 'Haemoglobin', 'hct' => 'Haematocrit']" selected="hb" />

    <div data-show-when="from:hb">
        <x-calc.field name="hb" label="Haemoglobin" value="14" min="0" step="any" suffix="g/dL" />
    </div>

    <div data-show-when="from:hct" hidden>
        <x-calc.field name="hct" label="Haematocrit" value="42" min="0" max="100" step="any" suffix="%" />
    </div>

    <x-calc.result label="Estimated haematocrit" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['from' => 'hb', 'hb' => 14, 'hct' => 42],
        'From Hct' => ['from' => 'hct', 'hb' => 14, 'hct' => 36],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rule' => ['label' => 'Rule'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Hct ≈ 3 × Hb</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
