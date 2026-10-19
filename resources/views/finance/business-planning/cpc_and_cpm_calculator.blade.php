<x-calc.page
    title="CPC and CPM Calculator - SolveKit"
    description="Free CPC and CPM calculator: cost per click, cost per thousand impressions and click-through rate, solving for cost, impressions or CPM."
    lede="Work out CPC, CPM and CTR."
    about="CPM = cost ÷ impressions × 1,000. CPC = cost ÷ clicks. CTR = clicks ÷ impressions. Given any two of cost, impressions and CPM, the third follows. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'cpm', 'fields' => ['solve', 'cost', 'impressions', 'cpm', 'clicks']]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => ''],
        ['name' => 'Enter the other values', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the CPM and CPC of $1,500 for 250,000 impressions and 1,800 clicks?', 'answer' => 'CPM $6.00, CPC $0.83.'],
        ['question' => 'What do 100,000 impressions cost at a $6 CPM?', 'answer' => '$600.00.'],
    ]"
>
    <x-calc.segmented name="solve" legend="Find" :options="['cpm' => 'CPM', 'cost' => 'Cost', 'impressions' => 'Impressions']" selected="cpm" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cost" label="Cost" value="1500" step="0.01" suffix="$" />
        <x-calc.field name="impressions" label="Impressions" value="250000" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cpm" label="CPM" value="6" step="0.01" suffix="$" />
        <x-calc.field name="clicks" label="Clicks (optional)" value="1800" min="0" step="1" />
    </div>

    <x-calc.result label="CPM" />

    <x-calc.options :decimals="false" :examples="[
        'CPM' => ['solve' => 'cpm', 'cost' => 1500, 'impressions' => 250000, 'cpm' => '', 'clicks' => 1800],
        'Cost' => ['solve' => 'cost', 'cost' => '', 'impressions' => 100000, 'cpm' => 6, 'clicks' => ''],
        'Impressions' => ['solve' => 'impressions', 'cost' => 2000, 'impressions' => '', 'cpm' => 8, 'clicks' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cpm' => ['label' => 'CPM'],
            'cpc' => ['label' => 'CPC'],
            'ctr' => ['label' => 'CTR'],
            'per' => ['label' => 'Cost per impression'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CPM = cost ÷ impressions × 1,000</li>
            <li>CPC = cost ÷ clicks</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
