<x-calc.page
    title="Debt-to-Capital Ratio Calculator - SolveKit"
    description="Free Debt-to-Capital Ratio Calculator: D/C = debt ÷ (debt + equity). Debt-to-capital is the share of the company's capital that is borrowed."
    lede="Work out the debt to capital from total debt and shareholders' equity."
    about="Debt-to-capital is the share of the company's capital that is borrowed. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'debt_to_capital_ratio', 'fields' => ['debt', 'equity']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total debt, Shareholders\' equity.'],
        ['name' => 'Read the result', 'text' => 'The debt to capital appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the debt to capital?', 'answer' => 'D/C = debt ÷ (debt + equity).'],
        ['question' => 'What is the debt to capital for total debt $300,000, shareholders\' equity $700,000?', 'answer' => '30%.'],
        ['question' => 'And for total debt $1,500,000, shareholders\' equity $500,000?', 'answer' => '75%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare with peers in the same industry.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="debt" label="Total debt" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="equity" label="Shareholders' equity" value="700000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Debt to capital" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['debt' => 300000, 'equity' => 700000],
        'Example B' => ['debt' => 1500000, 'equity' => 500000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>D/C = debt ÷ (debt + equity)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
