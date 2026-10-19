<x-calc.page
    title="INR Calculator - SolveKit"
    description="Free INR calculator: international normalised ratio from the prothrombin time, the lab's mean normal PT and the reagent's ISI."
    lede="Calculate the INR from PT."
    about="INR = (patient PT ÷ mean normal PT)^ISI, where the ISI (international sensitivity index) describes the thromboplastin reagent. Without anticoagulants INR is about 0.8–1.2; the usual warfarin target is 2.0–3.0 (2.5–3.5 for some mechanical heart valves), set by the prescriber. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'inr', 'fields' => ['pt', 'mnpt', 'isi']]"
    :how-to="[
        ['name' => 'Enter PT and the lab values', 'text' => 'The ISI and mean normal PT come from the lab.'],
    ]"
    :faqs="[
        ['question' => 'What is the INR for PT 24 s, mean normal 12 s and ISI 1.1?', 'answer' => '2.1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="pt" label="Prothrombin time" value="24" min="0" step="any" suffix="s" />
        <x-calc.field name="mnpt" label="Mean normal PT" value="12" min="0" step="any" suffix="s" />
        <x-calc.field name="isi" label="ISI" value="1.1" min="0" step="0.01" />
    </div>

    <x-calc.result label="INR" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pt' => 24, 'mnpt' => 12, 'isi' => 1.1],
        'Normal' => ['pt' => 12.5, 'mnpt' => 12, 'isi' => 1.0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'ratio' => ['label' => 'PT ratio'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>INR = (PT ÷ MNPT)^ISI</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
