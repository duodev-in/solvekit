<x-calc.page
    title="CPM Calculator - SolveKit"
    description="Free CPM calculator: cost per thousand impressions, campaign cost or impressions from the other two."
    lede="Calculate CPM, cost or impressions."
    about="CPM (cost per mille) = cost ÷ impressions × 1,000. Cost = CPM × impressions ÷ 1,000. Impressions = cost ÷ CPM × 1,000. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'cpm', 'fields' => ['solve', 'cost', 'impressions', 'cpm']]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => ''],
        ['name' => 'Enter the other two', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the CPM of $500 for 80,000 impressions?', 'answer' => '$6.25.'],
        ['question' => 'How many impressions does $1,000 buy at a $7.50 CPM?', 'answer' => '133,333.33.'],
    ]"
>
    <x-calc.segmented name="solve" legend="Find" :options="['cpm' => 'CPM', 'cost' => 'Cost', 'impressions' => 'Impressions']" selected="cpm" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="cost" label="Cost" value="500" step="0.01" suffix="$" />
        <x-calc.field name="impressions" label="Impressions" value="80000" min="0" step="1" />
        <x-calc.field name="cpm" label="CPM" value="7.5" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="CPM" />

    <x-calc.options :decimals="false" :examples="[
        'CPM' => ['solve' => 'cpm', 'cost' => 500, 'impressions' => 80000, 'cpm' => ''],
        'Impressions' => ['solve' => 'impressions', 'cost' => 1000, 'impressions' => '', 'cpm' => 7.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cpm' => ['label' => 'CPM'],
            'per' => ['label' => 'Cost per impression'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CPM = cost ÷ impressions × 1,000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
