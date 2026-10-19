<x-calc.page
    title="Mentzer Index Calculator - SolveKit"
    description="Free Mentzer index calculator: MCV divided by RBC count, to suggest thalassaemia trait or iron deficiency in microcytic anaemia."
    lede="Calculate the Mentzer index."
    about="Mentzer (1973): index = MCV (fL) ÷ RBC (× 10¹²/L). In microcytic anaemia, under 13 suggests thalassaemia trait (many small cells) and over 13 iron deficiency (fewer cells). It is a quick screen; ferritin and haemoglobin electrophoresis confirm the cause. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'mentzer', 'fields' => ['mcv', 'rbc']]"
    :how-to="[
        ['name' => 'Enter MCV and RBC', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the Mentzer index for MCV 68 and RBC 5.8?', 'answer' => '11.7: Under 13: thalassaemia trait is more likely.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mcv" label="MCV" value="68" min="0" step="any" suffix="fL" />
        <x-calc.field name="rbc" label="Red cell count" value="5.8" min="0" step="any" suffix="× 10¹²/L" />
    </div>

    <x-calc.result label="Mentzer index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mcv' => 68, 'rbc' => 5.8],
        'Iron deficiency' => ['mcv' => 72, 'rbc' => 4.0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Mentzer = MCV ÷ RBC</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
