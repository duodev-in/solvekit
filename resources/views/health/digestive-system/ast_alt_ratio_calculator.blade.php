<x-calc.page
    title="Ast Alt Ratio Calculator - SolveKit"
    description="Free AST/ALT ratio calculator: the De Ritis ratio and what high and low ratios suggest about liver disease."
    lede="Calculate the AST/ALT ratio."
    about="The De Ritis ratio = AST ÷ ALT. In most fatty liver disease and viral hepatitis ALT is higher (ratio under 1). A ratio over 2 is typical of alcohol-related liver disease, and a ratio over 1 can indicate cirrhosis of any cause. It is a pattern that supports, not makes, a diagnosis. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'ast_alt', 'fields' => ['ast', 'alt']]"
    :how-to="[
        ['name' => 'Enter AST and ALT', 'text' => 'From the same test.'],
    ]"
    :faqs="[
        ['question' => 'What does AST 90 and ALT 40 suggest?', 'answer' => '2.25: Over 2: typical of alcohol-related liver disease.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ast" label="AST" value="90" min="0" step="any" suffix="U/L" />
        <x-calc.field name="alt" label="ALT" value="40" min="0" step="any" suffix="U/L" />
    </div>

    <x-calc.result label="AST/ALT ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ast' => 90, 'alt' => 40],
        'Fatty liver' => ['ast' => 45, 'alt' => 70],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'note' => ['label' => 'Note'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ratio = AST ÷ ALT</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
