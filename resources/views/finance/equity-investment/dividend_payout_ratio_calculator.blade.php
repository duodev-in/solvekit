<x-calc.page
    title="Dividend Payout Ratio Calculator - SolveKit"
    description="Free Dividend Payout Ratio Calculator: payout = dividends ÷ net income. The share of profit paid to shareholders as dividends."
    lede="Work out the payout ratio from dividends paid and net income."
    about="The share of profit paid to shareholders as dividends. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'dividend_payout_ratio', 'fields' => ['dividends', 'income']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Dividends paid, Net income.'],
        ['name' => 'Read the result', 'text' => 'The payout ratio appears as you type, with retention ratio below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the payout ratio?', 'answer' => 'Payout = dividends ÷ net income.'],
        ['question' => 'What is the payout ratio for dividends paid $2,000,000, net income $5,000,000?', 'answer' => '40%. Retention ratio: 60%.'],
        ['question' => 'And for dividends paid $1.20, net income $3?', 'answer' => '40%. Retention ratio: 60%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Above 100% means dividends exceed earnings, which cannot last.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dividends" label="Dividends paid" value="2000000" step="0.01" suffix="$" />
        <x-calc.field name="income" label="Net income" value="5000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Payout ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['dividends' => 2000000, 'income' => 5000000],
        'Example B' => ['dividends' => 1.2, 'income' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Retention ratio'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>payout = dividends ÷ net income</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
