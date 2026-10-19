<x-calc.page
    title="Lease Calculator - SolveKit"
    description="Free lease calculator: monthly payment for an equipment or vehicle lease from price, residual value, money factor or APR, and term."
    lede="Work out a lease payment."
    about="Lease payment = (cap cost − residual) ÷ months + (cap cost + residual) × money factor, plus tax. Enter an APR to convert it to a money factor (APR ÷ 2,400). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'car_lease', 'fields' => ['price', 'residual', 'down', 'rate_type', 'rate', 'months', 'tax']]"
    :how-to="[
        ['name' => 'Enter price and residual', 'text' => ''],
        ['name' => 'Enter the rate and term', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the payment on a $30,000 lease, 50% residual, 6% APR, 36 months?', 'answer' => '$529.17.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Price (cap cost)" value="30000" step="0.01" suffix="$" />
        <x-calc.field name="residual" label="Residual value (%)" value="50" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="down" label="Down payment" value="0" step="0.01" suffix="$" />
        <x-calc.select name="rate_type" label="Rate given as" :options="['apr' => 'APR', 'mf' => 'Money factor']" selected="apr" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="APR % or money factor" value="6" min="0" step="any" />
        <x-calc.field name="months" label="Term" value="36" min="0" step="1" suffix="months" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tax" label="Sales tax" value="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="Monthly lease payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['price' => 30000, 'residual' => 50, 'down' => 0, 'rate_type' => 'apr', 'rate' => 6, 'months' => 36, 'tax' => 0],
        'Equipment' => ['price' => 80000, 'residual' => 20, 'down' => 5000, 'rate_type' => 'apr', 'rate' => 8, 'months' => 48, 'tax' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cap' => ['label' => 'Cap cost'],
            'residual' => ['label' => 'Residual value'],
            'mf' => ['label' => 'Money factor'],
            'total' => ['label' => 'Total lease cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MF = APR ÷ 2,400</li>
            <li>payment = (cap − res) ÷ n + (cap + res) × MF</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
