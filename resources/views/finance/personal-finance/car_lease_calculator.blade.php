<x-calc.page
    title="Car Lease Calculator - SolveKit"
    description="Free car lease calculator: monthly lease payment from the capitalized cost, residual value, money factor and sales tax."
    lede="Work out a car lease payment."
    about="Lease payment = depreciation + rent charge (+ tax). Depreciation = (adjusted cap cost − residual) ÷ months. Rent charge = (adjusted cap cost + residual) × money factor. Money factor × 2,400 ≈ APR. Most states tax the monthly payment. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'car_lease', 'fields' => ['price', 'msrp', 'residual', 'down', 'trade', 'fees', 'rate', 'months', 'tax']]"
    :how-to="[
        ['name' => 'Enter price, MSRP and residual', 'text' => 'From the lease quote.'],
        ['name' => 'Enter money factor, term and tax', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the payment on a $38,000 car with a 58% residual and 0.0025 money factor for 36 months?', 'answer' => '$571.04.'],
        ['question' => 'What APR is a 0.0025 money factor?', 'answer' => 'About 6%: 0.0025 (≈ 6% APR).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Negotiated price (cap cost)" value="38000" step="0.01" suffix="$" />
        <x-calc.field name="msrp" label="MSRP (for the residual)" value="40000" step="0.01" suffix="$" />
        <x-calc.field name="residual" label="Residual value (% of MSRP)" value="58" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="down" label="Down payment (cap reduction)" value="2000" step="0.01" suffix="$" />
        <x-calc.field name="trade" label="Trade-in" value="0" step="0.01" suffix="$" />
        <x-calc.field name="fees" label="Fees added (acquisition)" value="995" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rate" label="Money factor" value="0.0025" min="0" step="any" />
        <x-calc.field name="months" label="Term" value="36" min="0" step="1" suffix="months" />
        <x-calc.field name="tax" label="Sales tax" value="7" step="any" suffix="%" />
    </div>

    <x-calc.result label="Monthly lease payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['price' => 38000, 'msrp' => 40000, 'residual' => 58, 'down' => 2000, 'trade' => 0, 'fees' => 995, 'rate' => 0.0025, 'months' => 36, 'tax' => 7],
        'Low money factor' => ['price' => 38000, 'msrp' => 40000, 'residual' => 60, 'down' => 0, 'trade' => 0, 'fees' => 995, 'rate' => 0.0012, 'months' => 36, 'tax' => 7],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cap' => ['label' => 'Adjusted cap cost'],
            'residual' => ['label' => 'Residual value'],
            'mf' => ['label' => 'Money factor'],
            'total' => ['label' => 'Total lease cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>depreciation = (cap − residual) ÷ n</li>
            <li>rent = (cap + residual) × MF</li>
            <li>payment = (dep + rent) × (1 + tax)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
