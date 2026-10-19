<x-calc.page
    title="Sales Tax Calculator New Jersey - SolveKit"
    description="Free New Jersey sales tax calculator: 6.625% state rate, or half rate (3.3125%) at qualifying sellers in Urban Enterprise Zones."
    lede="Add or remove New Jersey sales tax."
    about="New Jersey charges 6.625% sales tax statewide with no local sales taxes. Qualified businesses in Urban Enterprise Zones may charge half the rate (3.3125%) on most sales. Clothing and most food are exempt. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'sales_tax', 'fields' => ['mode', 'amount', 'local', 'uez'], 'data' => ['sales' => config('finance_data.sales')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true, 'state' => 'NJ']"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Set the local rate', 'text' => 'Your county or city adds it to the state rate.'],
    ]"
    :faqs="[
        ['question' => 'What is $100 plus New Jersey sales tax?', 'answer' => '$106.62.'],
        ['question' => 'What is the Urban Enterprise Zone rate?', 'answer' => '3.3125%, half the state rate.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Calculate" :options="['add' => 'Add tax', 'remove' => 'Remove tax']" selected="add" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="100" step="0.01" suffix="$" />
        <x-calc.field name="local" label="Local (county or city) rate" value="0" step="any" suffix="%" />
    </div>

    <x-calc.checkbox name="uez" label="Seller in an Urban Enterprise Zone (half rate)" :checked="false" />

    <x-calc.result label="Total with tax" />

    <x-calc.options :decimals="false" :examples="[
        'Add' => ['mode' => 'add', 'amount' => 100, 'local' => 0, 'uez' => false],
        'Remove' => ['mode' => 'remove', 'amount' => 107.5, 'local' => 0, 'uez' => false],
        'Big purchase' => ['mode' => 'add', 'amount' => 2500, 'local' => 0, 'uez' => false],
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
