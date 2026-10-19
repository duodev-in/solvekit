<x-calc.page
    title="SaaS Metrics Calculator - SolveKit"
    description="Free SaaS metrics calculator: MRR, ARR, ARPA, churn, net revenue retention, LTV, CAC, CAC payback and LTV:CAC from one month of figures."
    lede="Work out the key SaaS metrics."
    about="Ending MRR = starting MRR + new + expansion − contraction − churned. ARR = MRR × 12; ARPA = MRR ÷ customers. LTV = ARPA × gross margin ÷ customer churn; CAC = sales and marketing spend ÷ new customers; payback = CAC ÷ (ARPA × margin). Healthy SaaS often targets LTV:CAC of 3 or more and NRR over 100%. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'saas', 'fields' => ['mrr', 'customers', 'new_mrr', 'expansion', 'contraction', 'churned_mrr', 'new_customers', 'lost', 'spend', 'margin']]"
    :how-to="[
        ['name' => 'Enter MRR movements', 'text' => ''],
        ['name' => 'Enter customers, spend and margin', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are the metrics for the example month?', 'answer' => 'MRR $107,500.00, NRR 99.5%, LTV:CAC 5.46×.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mrr" label="MRR at the start" value="100000" step="0.01" suffix="$" />
        <x-calc.field name="customers" label="Customers at the start" value="800" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="new_mrr" label="New MRR" value="8000" step="0.01" suffix="$" />
        <x-calc.field name="expansion" label="Expansion MRR" value="3000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="contraction" label="Contraction MRR" value="1000" step="0.01" suffix="$" />
        <x-calc.field name="churned_mrr" label="Churned MRR" value="2500" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="new_customers" label="New customers" value="60" min="0" step="1" />
        <x-calc.field name="lost" label="Customers lost" value="20" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="spend" label="Sales and marketing spend" value="45000" step="0.01" suffix="$" />
        <x-calc.field name="margin" label="Gross margin" value="80" step="any" suffix="%" />
    </div>

    <x-calc.result label="MRR at month end" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mrr' => 100000, 'customers' => 800, 'new_mrr' => 8000, 'expansion' => 3000, 'contraction' => 1000, 'churned_mrr' => 2500, 'new_customers' => 60, 'lost' => 20, 'spend' => 45000, 'margin' => 80],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'arr' => ['label' => 'ARR'],
            'arpa' => ['label' => 'ARPA'],
            'churn' => ['label' => 'Customer churn'],
            'nrr' => ['label' => 'Net revenue retention'],
            'ltv' => ['label' => 'LTV'],
            'cac' => ['label' => 'CAC and payback'],
            'ratio' => ['label' => 'LTV:CAC'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MRR₁ = MRR₀ + new + expansion − contraction − churn</li>
            <li>LTV = ARPA × margin ÷ churn</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
