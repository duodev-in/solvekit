<x-calc.page
    title="Average Percentage Calculator - SolveKit"
    description="Free average percentage calculator: the simple average of several percentages, and the weighted average when you add the sample sizes."
    lede="Average several percentages correctly."
    about="Averaging percentages is only fair when every percentage covers the same number of cases. Otherwise use the weighted average Σ(pᵢ × nᵢ) ÷ Σnᵢ: 80% of 10 students and 60% of 30 students is 65% overall, not 70%."
    :calc="['engine' => 'mt-percent', 'tool' => 'average', 'fields' => ['items']]"
    :how-to="[
        ['name' => 'Enter one percentage per line', 'text' => 'Add a comma and the sample size for a weighted average.'],
    ]"
    :faqs="[
        ['question' => 'What is the average of 80% of 10 and 60% of 30?', 'answer' => '65% (Simple average 70% (ignores the sample sizes)).'],
    ]"
>
    <x-calc.textarea name="items" label="Percentages (one per line, optional sample size after a comma)" value="80, 10
60, 30" rows="5" />

    <x-calc.result label="Average percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['items' => '80, 10
60, 30'],
        'Simple' => ['items' => '72
85
90'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'simple' => ['label' => 'Simple average'],
            'weighted' => ['label' => 'Weighted average'],
            'count' => ['label' => 'Percentages'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weighted = Σ(p × n) ÷ Σn</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
