<x-calc.page
    title="FIB-4 Calculator - SolveKit"
    description="Free FIB-4 calculator: liver fibrosis index from age, AST, ALT and platelets, with the 1.3 and 2.67 cut-offs (2.0 for 65 and over)."
    lede="Calculate the FIB-4 fibrosis score."
    about="FIB-4 = age × AST ÷ (platelets (× 10⁹/L) × √ALT) (Sterling et al. 2006). AASLD (2023) uses it first in fatty liver disease: under 1.3 makes advanced fibrosis unlikely, over 2.67 likely, and values in between need elastography or the ELF test. Over 65 the lower cut-off is 2.0. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'fib4', 'fields' => ['age', 'platelets', 'ast', 'alt']]"
    :how-to="[
        ['name' => 'Enter age and platelets', 'text' => ''],
        ['name' => 'Enter AST and ALT', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is FIB-4 for a 55-year-old with AST 45, ALT 50 and platelets 180?', 'answer' => '1.94: 1.3–2.67: indeterminate; a second test (elastography or ELF) is advised.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="55" min="0" step="1" suffix="years" />
        <x-calc.field name="platelets" label="Platelets" value="180" min="0" step="any" suffix="× 10⁹/L" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ast" label="AST" value="45" min="0" step="any" suffix="U/L" />
        <x-calc.field name="alt" label="ALT" value="50" min="0" step="any" suffix="U/L" />
    </div>

    <x-calc.result label="FIB-4" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 55, 'platelets' => 180, 'ast' => 45, 'alt' => 50],
        'High' => ['age' => 62, 'platelets' => 110, 'ast' => 80, 'alt' => 55],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'cutoffs' => ['label' => 'Cut-offs'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FIB-4 = age × AST ÷ (PLT × √ALT)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
