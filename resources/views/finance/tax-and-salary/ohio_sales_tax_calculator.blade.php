<x-calc.page
    title="Ohio Sales Tax Calculator - SolveKit"
    description="Free Ohio sales tax calculator: 5.75% state rate plus county and transit taxes."
    lede="Add or remove Ohio sales tax."
    about="Ohio's state sales tax is 5.75%. Counties and transit authorities add 0.75–2.25%, about 1.5% on average, for combined rates of about 6.5–8%. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'sales_tax', 'fields' => ['mode', 'amount', 'local'], 'data' => ['sales' => config('finance_data.sales')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true, 'state' => 'OH']"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Set the local rate', 'text' => 'Your county or city adds it to the state rate.'],
    ]"
    :faqs="[
        ['question' => 'What is $100 plus Ohio tax at 7.25%?', 'answer' => '$107.25.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Calculate" :options="['add' => 'Add tax', 'remove' => 'Remove tax']" selected="add" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="100" step="0.01" suffix="$" />
        <x-calc.field name="local" label="Local (county or city) rate" value="1.5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Total with tax" />

    <x-calc.options :decimals="false" :examples="[
        'Add' => ['mode' => 'add', 'amount' => 100, 'local' => 1.5],
        'Remove' => ['mode' => 'remove', 'amount' => 107.5, 'local' => 1.5],
        'Big purchase' => ['mode' => 'add', 'amount' => 2500, 'local' => 1.5],
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
