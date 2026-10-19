<x-calc.page
    title="Residual Income Calculator - SolveKit"
    description="Free Residual Income Calculator: RI = net income − equity × cost of equity. Residual income is profit beyond what shareholders require on their capital."
    lede="Work out the residual income from net income, equity (book value) and cost of equity."
    about="Residual income is profit beyond what shareholders require on their capital. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'residual_income', 'fields' => ['income', 'equity', 'cost']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Net income, Equity (book value), Cost of equity.'],
        ['name' => 'Read the result', 'text' => 'The residual income appears as you type, with equity charge below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the residual income?', 'answer' => 'RI = net income − equity × cost of equity.'],
        ['question' => 'What is the residual income for net income $2,000,000, equity $15,000,000, cost of equity 10%?', 'answer' => '$500,000.00. Equity charge: $1,500,000.00.'],
        ['question' => 'And for net income $450,000, equity $5,000,000, cost of equity 11%?', 'answer' => '−$100,000.00. Equity charge: $550,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Positive residual income adds value; valuation models discount it.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="income" label="Net income" value="2000000" step="0.01" suffix="$" />
        <x-calc.field name="equity" label="Equity (book value)" value="15000000" step="0.01" suffix="$" />
        <x-calc.field name="cost" label="Cost of equity" value="10" step="any" suffix="%" />
    </div>

    <x-calc.result label="Residual income" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['income' => 2000000, 'equity' => 15000000, 'cost' => 10],
        'Example B' => ['income' => 450000, 'equity' => 5000000, 'cost' => 11],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Equity charge'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RI = net income − equity × cost of equity</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
