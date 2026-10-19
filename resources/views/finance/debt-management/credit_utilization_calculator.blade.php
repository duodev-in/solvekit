<x-calc.page
    title="Credit Utilization Calculator - SolveKit"
    description="Free Credit Utilization Calculator: utilization = balances ÷ limits. Credit scores reward low utilization; under 30% is common advice and under 10% is better."
    lede="Work out the credit utilization from total card balances and total credit limits."
    about="Credit scores reward low utilization; under 30% is common advice and under 10% is better. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'credit_utilization', 'fields' => ['balances', 'limits']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total card balances, Total credit limits.'],
        ['name' => 'Read the result', 'text' => 'The credit utilization appears as you type, with balance for 30%, balance for 10% below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the credit utilization?', 'answer' => 'Utilization = balances ÷ limits.'],
        ['question' => 'What is the credit utilization for total card balances $2,500, total credit limits $10,000?', 'answer' => '25%. Balance for 30%: $3,000.00.'],
        ['question' => 'And for total card balances $4,800, total credit limits $6,000?', 'answer' => '80%. Balance for 30%: $1,800.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Per-card utilization also counts.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balances" label="Total card balances" value="2500" step="0.01" suffix="$" />
        <x-calc.field name="limits" label="Total credit limits" value="10000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Credit utilization" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['balances' => 2500, 'limits' => 10000],
        'Example B' => ['balances' => 4800, 'limits' => 6000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Balance for 30%'],
            'r2' => ['label' => 'Balance for 10%'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>utilization = balances ÷ limits</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
