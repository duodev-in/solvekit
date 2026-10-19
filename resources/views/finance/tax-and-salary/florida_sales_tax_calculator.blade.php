<x-calc.page
    title="Florida Sales Tax Calculator - SolveKit"
    description="Free Florida sales tax calculator: 6% state rate plus the county discretionary sales surtax."
    lede="Add or remove Florida sales tax."
    about="Florida's state sales tax is 6%. Counties add a discretionary sales surtax of 0.5–2% (about 1% on average), applied only to the first $5,000 of a single item. Groceries and medicine are exempt. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'sales_tax', 'fields' => ['mode', 'amount', 'local'], 'data' => ['sales' => config('finance_data.sales')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true, 'state' => 'FL']"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Set the local rate', 'text' => 'Your county or city adds it to the state rate.'],
    ]"
    :faqs="[
        ['question' => 'What is $100 plus Florida tax with a 1% county surtax?', 'answer' => '$107.00.'],
        ['question' => 'Does the surtax apply to the whole price of a car?', 'answer' => 'No: county surtax applies only to the first $5,000 of a single item.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Calculate" :options="['add' => 'Add tax', 'remove' => 'Remove tax']" selected="add" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="100" step="0.01" suffix="$" />
        <x-calc.field name="local" label="Local (county or city) rate" value="1" step="any" suffix="%" />
    </div>

    <x-calc.result label="Total with tax" />

    <x-calc.options :decimals="false" :examples="[
        'Add' => ['mode' => 'add', 'amount' => 100, 'local' => 1],
        'Remove' => ['mode' => 'remove', 'amount' => 107.5, 'local' => 1],
        'Big purchase' => ['mode' => 'add', 'amount' => 2500, 'local' => 1],
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
