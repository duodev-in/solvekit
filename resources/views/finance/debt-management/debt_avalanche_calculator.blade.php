<x-calc.page
    title="Debt Avalanche Calculator - SolveKit"
    description="Free debt avalanche calculator: pay minimums on every debt and put extra money on the highest-rate debt first; see the payoff date and interest."
    lede="Plan a debt avalanche payoff."
    about="The avalanche method pays the highest-interest debt first. Mathematically it costs the least interest; the snowball method can feel more motivating. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'debt_plan', 'fields' => ['debts', 'budget', 'method']]"
    :how-to="[
        ['name' => 'List your debts', 'text' => 'Balance, APR and minimum payment.'],
        ['name' => 'Set your monthly budget', 'text' => 'At least the sum of the minimums.'],
    ]"
    :faqs="[
        ['question' => 'How long does it take to clear these four debts with $1,200 a month?', 'answer' => '2 years, with $3,084.73 of interest.'],
        ['question' => 'And with $1,700?', 'answer' => '1 year 5 months.'],
        ['question' => 'How does the other order compare?', 'answer' => 'Snowball: 2 years 1 month, $3,459.92 interest.'],
    ]"
>
    <x-calc.rows-editor name="debts" label="Debts" :columns="['name' => 'Debt', 'balance' => 'Balance', 'rate' => 'APR %', 'minimum' => 'Minimum']" :rows="[['Credit card', 6500, 24.99, 160], ['Car loan', 14000, 7.5, 380], ['Store card', 1200, 29.99, 40], ['Personal loan', 4000, 11.5, 130]]" :text="['name']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="budget" label="Monthly budget for debts" value="1200" step="0.01" suffix="$" />
        <x-calc.select name="method" label="Order" :options="['avalanche' => 'Avalanche (highest rate first)', 'snowball' => 'Snowball (smallest balance first)']" selected="avalanche" />
    </div>

    <x-calc.result label="Debt-free in" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['debts' => 'Credit card	6500	24.99	160
Car loan	14000	7.5	380
Store card	1200	29.99	40
Personal loan	4000	11.5	130', 'budget' => 1200, 'method' => 'avalanche'],
        'Bigger budget' => ['debts' => 'Credit card	6500	24.99	160
Car loan	14000	7.5	380
Store card	1200	29.99	40
Personal loan	4000	11.5	130', 'budget' => 1700, 'method' => 'avalanche'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Total debt'],
            'interest' => ['label' => 'Interest'],
            'minimums' => ['label' => 'Minimum payments only'],
            'other' => ['label' => 'Other method'],
            'rate' => ['label' => 'Average rate'],
        ]" />
        <x-calc.quick-ref heading="Payoff order" name="order" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pay all minimums; the rest goes to the target debt</li>
            <li>freed minimums roll to the next debt</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
