<x-calc.page
    title="Sales Tax Calculator - SolveKit"
    description="Free sales tax calculator: add sales tax to a price or remove it from a total at any rate."
    lede="Add or remove sales tax."
    about="Adding tax: total = price × (1 + rate). Removing tax from a tax-inclusive total: price = total ÷ (1 + rate); the tax is the difference. US rates combine state, county and city taxes. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'sales_tax', 'fields' => ['mode', 'amount', 'rate'], 'data' => ['sales' => config('finance_data.sales')]]"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Enter the rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is $100 plus 8.25% sales tax?', 'answer' => '$108.25.'],
        ['question' => 'What was the price before tax on $108.25?', 'answer' => '$100.00.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Calculate" :options="['add' => 'Add tax', 'remove' => 'Remove tax']" selected="add" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="100" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Sales tax rate" value="8.25" step="any" suffix="%" />
    </div>

    <x-calc.result label="Total with tax" />

    <x-calc.options :decimals="false" :examples="[
        'Add' => ['mode' => 'add', 'amount' => 100, 'rate' => 8.25],
        'Remove' => ['mode' => 'remove', 'amount' => 108.25, 'rate' => 8.25],
        'High rate' => ['mode' => 'add', 'amount' => 1500, 'rate' => 10.25],
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
            <li>total = price × (1 + r)</li>
            <li>price = total ÷ (1 + r)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
