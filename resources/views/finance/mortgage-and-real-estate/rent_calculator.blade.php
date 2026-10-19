<x-calc.page
    title="Rent Calculator - SolveKit"
    description="Free Rent Calculator: rent = income × 30% ÷ 12. The 30% rule (from HUD affordability standards) caps housing costs at 30% of gross income."
    lede="Work out the affordable monthly rent from gross yearly income and share of income for rent."
    about="The 30% rule (from HUD affordability standards) caps housing costs at 30% of gross income. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'rent', 'fields' => ['income', 'share']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Gross yearly income, Share of income for rent.'],
        ['name' => 'Read the result', 'text' => 'The affordable monthly rent appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the affordable monthly rent?', 'answer' => 'Rent = income × 30% ÷ 12.'],
        ['question' => 'What is the affordable monthly rent for gross yearly income $60,000, share of income for rent 30%?', 'answer' => '$1,500.00.'],
        ['question' => 'And for gross yearly income $85,000, share of income for rent 25%?', 'answer' => '$1,770.83.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Households paying more are “cost-burdened” by HUD\'s definition.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="Gross yearly income" value="60000" step="0.01" suffix="$" />
        <x-calc.field name="share" label="Share of income for rent" value="30" step="any" suffix="%" />
    </div>

    <x-calc.result label="Affordable monthly rent" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['income' => 60000, 'share' => 30],
        'Example B' => ['income' => 85000, 'share' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rent = income × 30% ÷ 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
