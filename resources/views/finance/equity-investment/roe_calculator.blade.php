<x-calc.page
    title="Return on Equity Calculator - SolveKit"
    description="Free Return on Equity Calculator: ROE = net income ÷ average equity. Return on equity is the profit earned on shareholders' money."
    lede="Work out the ROE from net income and average shareholders' equity."
    about="Return on equity is the profit earned on shareholders' money. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'roe', 'fields' => ['income', 'equity']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Net income, Average shareholders\' equity.'],
        ['name' => 'Read the result', 'text' => 'The ROE appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the ROE?', 'answer' => 'ROE = net income ÷ average equity.'],
        ['question' => 'What is the ROE for net income $1,500,000, average shareholders\' equity $10,000,000?', 'answer' => '15%.'],
        ['question' => 'And for net income $320,000, average shareholders\' equity $2,100,000?', 'answer' => '15.24%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'High ROE from high debt is riskier; see DuPont analysis.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="Net income" value="1500000" step="0.01" suffix="$" />
        <x-calc.field name="equity" label="Average shareholders' equity" value="10000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="ROE" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['income' => 1500000, 'equity' => 10000000],
        'Example B' => ['income' => 320000, 'equity' => 2100000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ROE = net income ÷ average equity</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
