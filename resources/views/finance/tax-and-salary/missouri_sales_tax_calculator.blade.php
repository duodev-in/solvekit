<x-calc.page
    title="Missouri Sales Tax Calculator - SolveKit"
    description="Free Missouri sales tax calculator: 4.225% state rate plus local rates, added to or removed from a price."
    lede="Add or remove Missouri sales tax."
    about="Missouri's state sales tax is 4.225%. Cities, counties and special districts add local taxes averaging about 4.2%, so combined rates often exceed 8%. Food is taxed at a reduced 1.225% state rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'sales_tax', 'fields' => ['mode', 'amount', 'local'], 'data' => ['sales' => config('finance_data.sales')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true, 'state' => 'MO']"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Set the local rate', 'text' => 'Your county or city adds it to the state rate.'],
    ]"
    :faqs="[
        ['question' => 'What is $100 plus Missouri tax at 8.425%?', 'answer' => '$108.43.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Calculate" :options="['add' => 'Add tax', 'remove' => 'Remove tax']" selected="add" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="100" step="0.01" suffix="$" />
        <x-calc.field name="local" label="Local (county or city) rate" value="4.2" step="any" suffix="%" />
    </div>

    <x-calc.result label="Total with tax" />

    <x-calc.options :decimals="false" :examples="[
        'Add' => ['mode' => 'add', 'amount' => 100, 'local' => 4.2],
        'Remove' => ['mode' => 'remove', 'amount' => 107.5, 'local' => 4.2],
        'Big purchase' => ['mode' => 'add', 'amount' => 2500, 'local' => 4.2],
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
