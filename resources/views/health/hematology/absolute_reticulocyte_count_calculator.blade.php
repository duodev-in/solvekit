<x-calc.page
    title="Absolute Reticulocyte Count Calculator - SolveKit"
    description="Free absolute reticulocyte count calculator: ARC from the reticulocyte percentage and red cell count, to judge the marrow response to anaemia."
    lede="Calculate the absolute reticulocyte count."
    about="Absolute reticulocyte count = reticulocyte % × RBC (× 10¹²/L) × 10, giving × 10⁹/L. Normal is about 25–100 × 10⁹/L. In anaemia, over 100 shows the marrow is responding (bleeding or haemolysis), while a low count points to reduced production. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'arc', 'fields' => ['retic', 'rbc']]"
    :how-to="[
        ['name' => 'Enter retic % and RBC', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the ARC with 3% retics and RBC 3.5?', 'answer' => '105 × 10⁹/L: Over 100: the marrow is responding (bleeding or haemolysis).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="retic" label="Reticulocytes" value="3" min="0" max="50" step="any" suffix="%" />
        <x-calc.field name="rbc" label="Red cell count" value="3.5" min="0" step="any" suffix="× 10¹²/L" />
    </div>

    <x-calc.result label="Absolute reticulocyte count" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['retic' => 3, 'rbc' => 3.5],
        'Low' => ['retic' => 0.5, 'rbc' => 3.0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ARC = retic % × RBC × 10</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
