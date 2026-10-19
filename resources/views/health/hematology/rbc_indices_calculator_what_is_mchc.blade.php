<x-calc.page
    title="RBC Indices Calculator | What is MCHC? - SolveKit"
    description="Free RBC indices calculator: MCV, MCH and MCHC from haemoglobin, haematocrit and red cell count, with what each means."
    lede="Calculate MCV, MCH and MCHC."
    about="Wintrobe's red cell indices: MCV (fL) = Hct (%) × 10 ÷ RBC; MCH (pg) = Hb (g/dL) × 10 ÷ RBC; MCHC (g/dL) = Hb ÷ Hct × 100. MCHC is the average haemoglobin concentration in red cells: low (hypochromic) in iron deficiency and thalassaemia, high in hereditary spherocytosis. Usual ranges: MCV 80–100, MCH 27–33, MCHC 32–36. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'rbc_indices', 'fields' => ['hb', 'hb_unit', 'hct', 'rbc']]"
    :how-to="[
        ['name' => 'Enter haemoglobin', 'text' => ''],
        ['name' => 'Enter haematocrit and RBC', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are the indices for Hb 13.5, Hct 40% and RBC 4.6?', 'answer' => '33.8 g/dL (MCV 87 fL, MCH 29.3 pg).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hb" label="Haemoglobin" value="13.5" min="0" step="any" />
        <x-calc.select name="hb_unit" label="Haemoglobin unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L', 'mmol/L' => 'mmol/L']" selected="g/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hct" label="Haematocrit" value="40" min="0" max="100" step="any" suffix="%" />
        <x-calc.field name="rbc" label="Red cell count" value="4.6" min="0" step="any" suffix="× 10¹²/L" />
    </div>

    <x-calc.result label="MCHC" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['hb' => 13.5, 'hb_unit' => 'g/dL', 'hct' => 40, 'rbc' => 4.6],
        'Iron deficiency' => ['hb' => 9.5, 'hb_unit' => 'g/dL', 'hct' => 32, 'rbc' => 4.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mcv' => ['label' => 'MCV'],
            'mch' => ['label' => 'MCH'],
            'mchc' => ['label' => 'MCHC'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MCV = Hct × 10 ÷ RBC</li>
            <li>MCHC = Hb ÷ Hct × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
