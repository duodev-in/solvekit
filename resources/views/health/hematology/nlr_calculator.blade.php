<x-calc.page
    title="NLR Calculator - SolveKit"
    description="Free NLR calculator: neutrophil-to-lymphocyte ratio from absolute counts or percentages, with the usual adult range."
    lede="Calculate the neutrophil-to-lymphocyte ratio."
    about="NLR = absolute neutrophils ÷ absolute lymphocytes (or neutrophil % ÷ lymphocyte %). It rises with physiological stress, infection and inflammation. In healthy adults it is about 0.78–3.53 (Forget et al. 2017); it has no single diagnostic cut-off and is read alongside the whole picture. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'nlr', 'fields' => ['mode', 'neut', 'lymph', 'npct', 'lpct']]"
    :how-to="[
        ['name' => 'Choose counts or percentages', 'text' => ''],
        ['name' => 'Enter both values', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the NLR for 5.2 and 1.6?', 'answer' => '3.25: Within the usual adult range (0.78–3.53).'],
    ]"
>
    <x-calc.segmented name="mode" legend="Enter" :options="['abs' => 'Absolute counts', 'pct' => 'Percentages']" selected="abs" />

    <div data-show-when="mode:abs">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="neut" label="Neutrophils" value="5.2" min="0" step="any" suffix="× 10⁹/L" />
            <x-calc.field name="lymph" label="Lymphocytes" value="1.6" min="0" step="any" suffix="× 10⁹/L" />
        </div>
    </div>

    <div data-show-when="mode:pct" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="npct" label="Neutrophils" value="65" min="0" max="100" step="any" suffix="%" />
            <x-calc.field name="lpct" label="Lymphocytes" value="25" min="0" max="100" step="any" suffix="%" />
        </div>
    </div>

    <x-calc.result label="Neutrophil-to-lymphocyte ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'abs', 'neut' => 5.2, 'lymph' => 1.6, 'npct' => 65, 'lpct' => 25],
        'Stress' => ['mode' => 'pct', 'neut' => 5.2, 'lymph' => 1.6, 'npct' => 85, 'lpct' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'range' => ['label' => 'Reference range'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NLR = neutrophils ÷ lymphocytes</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
