<x-calc.page
    title="Blended Rate Calculator - SolveKit"
    description="Free blended rate calculator: balance-weighted average interest rate of several loans."
    lede="Find the average rate across your loans."
    about="Blended rate = Σ(balance × rate) ÷ Σ balances. It is the single rate that would cost the same interest this year, useful for comparing with a consolidation or refinance offer. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'blended_rate', 'fields' => ['loans']]"
    :how-to="[
        ['name' => 'List balances and rates', 'text' => ''],
        ['name' => 'Read the blended rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the blended rate of $300,000 at 3.25%, $50,000 at 8.5% and $20,000 at 6.9%?', 'answer' => '4.157%.'],
    ]"
>
    <x-calc.rows-editor name="loans" label="Loans" :columns="['name' => 'Loan', 'balance' => 'Balance', 'rate' => 'Rate %']" :rows="[['First mortgage', 300000, 3.25], ['HELOC', 50000, 8.5], ['Car loan', 20000, 6.9]]" :text="['name']" />

    <x-calc.result label="Blended interest rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['loans' => 'First mortgage	300000	3.25
HELOC	50000	8.5
Car loan	20000	6.9'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'total' => ['label' => 'Total balance'],
            'yearly' => ['label' => 'Interest a year'],
            'highest' => ['label' => 'Highest rate'],
            'simple' => ['label' => 'Simple average'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>blended = Σ(B × r) ÷ Σ B</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
