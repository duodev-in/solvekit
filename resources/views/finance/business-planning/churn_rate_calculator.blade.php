<x-calc.page
    title="Churn Rate Calculator - SolveKit"
    description="Free churn rate calculator: customer churn, monthly and annual churn, average customer lifetime, revenue churn and net revenue retention."
    lede="Work out customer and revenue churn."
    about="Customer churn = customers lost ÷ customers at the start of the period. Monthly churn compounds to annual: 1 − (1 − m)^12. Revenue churn = lost MRR ÷ starting MRR; net revenue retention adds expansion and subtracts contraction. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'churn', 'fields' => ['start', 'lost', 'months', 'mrr', 'churned_mrr', 'contraction', 'expansion']]"
    :how-to="[
        ['name' => 'Enter customers and losses', 'text' => ''],
        ['name' => 'Add MRR figures', 'text' => 'For revenue churn.'],
    ]"
    :faqs="[
        ['question' => 'What is the churn with 30 of 1,000 customers lost in a month?', 'answer' => '3%, 30.62% a year.'],
        ['question' => 'What is net revenue retention?', 'answer' => '100.63%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Customers at the start" value="1000" min="0" step="1" />
        <x-calc.field name="lost" label="Customers lost" value="30" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="months" label="Period" value="1" min="0" step="1" suffix="months" />
        <x-calc.field name="mrr" label="MRR at the start (optional)" value="80000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="churned_mrr" label="MRR lost to churn" value="2400" step="0.01" suffix="$" />
        <x-calc.field name="contraction" label="MRR lost to downgrades" value="600" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="expansion" label="MRR gained from upgrades" value="3500" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Customer churn rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['start' => 1000, 'lost' => 30, 'months' => 1, 'mrr' => 80000, 'churned_mrr' => 2400, 'contraction' => 600, 'expansion' => 3500],
        'Quarter' => ['start' => 500, 'lost' => 40, 'months' => 3, 'mrr' => '', 'churned_mrr' => '', 'contraction' => '', 'expansion' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'monthly' => ['label' => 'Monthly churn'],
            'annual' => ['label' => 'Annual churn'],
            'lifetime' => ['label' => 'Average lifetime'],
            'revenue' => ['label' => 'Revenue churn'],
            'nrr' => ['label' => 'Net revenue retention'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>churn = lost ÷ start</li>
            <li>annual = 1 − (1 − monthly)^12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
