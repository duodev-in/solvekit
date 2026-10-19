<x-calc.page
    title="Debt to Equity Calculator - SolveKit"
    description="Free Debt to Equity Calculator: D/E = total liabilities ÷ equity. Debt to equity compares what a company owes with what its owners have put in."
    lede="Work out the debt to equity from total liabilities (or debt) and shareholders' equity."
    about="Debt to equity compares what a company owes with what its owners have put in. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'debt_to_equity', 'fields' => ['debt', 'equity']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total liabilities (or debt), Shareholders\' equity.'],
        ['name' => 'Read the result', 'text' => 'The debt to equity appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the debt to equity?', 'answer' => 'D/E = total liabilities ÷ equity.'],
        ['question' => 'What is the debt to equity for total liabilities $500,000, shareholders\' equity $400,000?', 'answer' => '1.25×.'],
        ['question' => 'And for total liabilities $120,000, shareholders\' equity $300,000?', 'answer' => '0.4×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Some analysts use only interest-bearing debt; say which you use.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="debt" label="Total liabilities (or debt)" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="equity" label="Shareholders' equity" value="400000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Debt to equity" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['debt' => 500000, 'equity' => 400000],
        'Example B' => ['debt' => 120000, 'equity' => 300000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>D/E = total liabilities ÷ equity</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
