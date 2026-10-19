<x-calc.page
    title="Corrected Reticulocyte Count Calculator - SolveKit"
    description="Free corrected reticulocyte count calculator: reticulocytes corrected for anaemia and the reticulocyte production index (RPI)."
    lede="Correct the reticulocyte count."
    about="Corrected reticulocyte count = reticulocyte % × patient haematocrit ÷ 45. The reticulocyte production index divides by the maturation time (1 day at Hct 36% or more, 1.5 at 26–35%, 2 at 16–25%, 2.5 at 15% or less). An RPI of 2 or more suggests an adequate marrow response. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'crc', 'fields' => ['retic', 'hct']]"
    :how-to="[
        ['name' => 'Enter retic % and haematocrit', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the corrected count for 4% retics at Hct 25%?', 'answer' => '2.22% (Reticulocyte production index 1.11: inadequate response (under 2): reduced production).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="retic" label="Reticulocytes" value="4" min="0" max="50" step="any" suffix="%" />
        <x-calc.field name="hct" label="Haematocrit" value="25" min="0" max="100" step="any" suffix="%" />
    </div>

    <x-calc.result label="Corrected reticulocyte count" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['retic' => 4, 'hct' => 25],
        'Hypoproliferative' => ['retic' => 1.5, 'hct' => 28],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rpi' => ['label' => 'RPI'],
            'maturation' => ['label' => 'Maturation time'],
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CRC = retic × Hct ÷ 45</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
