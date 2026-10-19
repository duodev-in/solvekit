<x-calc.page
    title="California Sales Tax Calculator - SolveKit"
    description="Free California sales tax calculator: 7.25% statewide rate plus your district tax, added to or removed from a price."
    lede="Add or remove California sales tax."
    about="California's statewide base rate is 7.25% (6% state plus 1.25% local). District taxes add up to about 3% more in many cities (CDTFA publishes the rate for each address); the population-weighted average total is about 9%. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'sales_tax', 'fields' => ['mode', 'amount', 'local'], 'data' => ['sales' => config('finance_data.sales')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true, 'state' => 'CA']"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Set the local rate', 'text' => 'Your county or city adds it to the state rate.'],
    ]"
    :faqs="[
        ['question' => 'What is $100 plus California sales tax at 9%?', 'answer' => '$109.00.'],
        ['question' => 'What is the statewide minimum?', 'answer' => '7.25%.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Calculate" :options="['add' => 'Add tax', 'remove' => 'Remove tax']" selected="add" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="100" step="0.01" suffix="$" />
        <x-calc.field name="local" label="Local (county or city) rate" value="1.75" step="any" suffix="%" />
    </div>

    <x-calc.result label="Total with tax" />

    <x-calc.options :decimals="false" :examples="[
        'Add' => ['mode' => 'add', 'amount' => 100, 'local' => 1.75],
        'Remove' => ['mode' => 'remove', 'amount' => 107.5, 'local' => 1.75],
        'Big purchase' => ['mode' => 'add', 'amount' => 2500, 'local' => 1.75],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tax' => ['label' => 'Sales tax'],
            'rate' => ['label' => 'Rate'],
            'net' => ['label' => 'Before tax'],
            'gross' => ['label' => 'With tax'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tax = amount × (state + local rate)</li>
            <li>remove: amount ÷ (1 + rate)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
