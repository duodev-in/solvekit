<x-calc.page
    title="Online Marketing Conversion Calculator - SolveKit"
    description="Free marketing funnel calculator: clicks, leads, sales, revenue, cost per acquisition and ROAS from impressions and conversion rates at each stage."
    lede="Model your marketing funnel."
    about="Each stage converts a share of the one before: clicks = impressions × CTR, leads = clicks × lead rate, sales = leads × close rate, revenue = sales × average order value. CPA = ad spend ÷ sales; ROAS = revenue ÷ spend. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'funnel', 'fields' => ['impressions', 'ctr', 'lead_rate', 'close_rate', 'value', 'spend']]"
    :how-to="[
        ['name' => 'Enter traffic and rates', 'text' => ''],
        ['name' => 'Enter order value and spend', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does a funnel of 500,000 impressions bring in?', 'answer' => '$12,960.00 from 72 sales; ROAS 2.16×.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="impressions" label="Impressions" value="500000" min="0" step="1" />
        <x-calc.field name="ctr" label="Click-through rate" value="1.5" step="any" suffix="%" />
        <x-calc.field name="lead_rate" label="Visitor to lead" value="8" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="close_rate" label="Lead to sale" value="12" step="any" suffix="%" />
        <x-calc.field name="value" label="Average order value" value="180" step="0.01" suffix="$" />
        <x-calc.field name="spend" label="Ad spend" value="6000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Revenue" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['impressions' => 500000, 'ctr' => 1.5, 'lead_rate' => 8, 'close_rate' => 12, 'value' => 180, 'spend' => 6000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'clicks' => ['label' => 'Clicks'],
            'leads' => ['label' => 'Leads'],
            'sales' => ['label' => 'Sales'],
            'cpa' => ['label' => 'Cost per sale'],
            'roas' => ['label' => 'ROAS'],
        ]" />
        <x-calc.quick-ref heading="Funnel" name="stages" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sales = impressions × CTR × lead rate × close rate</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
