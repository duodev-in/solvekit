<x-calc.page
    title="APRI Calculator - SolveKit"
    description="Free APRI calculator: AST-to-platelet ratio index for liver fibrosis and cirrhosis, from AST, its upper limit of normal and platelets."
    lede="Calculate the AST-to-platelet ratio index."
    about="APRI = (AST ÷ AST upper limit of normal) ÷ platelets (× 10⁹/L) × 100 (Wai et al. 2003). WHO hepatitis guidance uses over 2.0 to suggest cirrhosis and over 1.5 significant fibrosis; under 0.5 makes significant fibrosis unlikely. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'apri', 'fields' => ['ast', 'uln', 'platelets']]"
    :how-to="[
        ['name' => 'Enter AST and its upper limit', 'text' => ''],
        ['name' => 'Enter platelets', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is APRI for AST 80 (limit 40) with platelets 140?', 'answer' => '1.43: 0.5–1.5: indeterminate.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ast" label="AST" value="80" min="0" step="any" suffix="U/L" />
        <x-calc.field name="uln" label="AST upper limit" value="40" min="0" step="any" suffix="U/L" />
        <x-calc.field name="platelets" label="Platelets" value="140" min="0" step="any" suffix="× 10⁹/L" />
    </div>

    <x-calc.result label="APRI" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ast' => 80, 'uln' => 40, 'platelets' => 140],
        'Low' => ['ast' => 30, 'uln' => 40, 'platelets' => 250],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>APRI = (AST ÷ ULN) ÷ PLT × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
