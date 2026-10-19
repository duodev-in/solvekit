<x-calc.page
    title="VA Loan Calculator - SolveKit"
    description="Free VA loan calculator: monthly payment with the VA funding fee by first or subsequent use and down payment, with no PMI."
    lede="Work out a VA loan payment with the funding fee."
    about="VA loans need no down payment and no monthly mortgage insurance. The one-time funding fee is 2.15% for first use with under 5% down (3.3% for later use), 1.5% with 5% down and 1.25% with 10% down; 0.5% for an IRRRL refinance. Veterans receiving VA disability compensation are exempt. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'va', 'fields' => ['price', 'down', 'rate', 'years', 'use', 'purpose', 'tax', 'insurance', 'exempt'], 'data' => ['va' => config('finance_data.va')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter price and down payment', 'text' => 'Zero down is allowed.'],
        ['name' => 'Choose use and loan type', 'text' => 'For the funding fee.'],
    ]"
    :faqs="[
        ['question' => 'What is the funding fee on a $400,000 home with nothing down, first use?', 'answer' => '$8,600.00 (2.15%).'],
        ['question' => 'And the payment at 6%?', 'answer' => '$2,941.43.'],
        ['question' => 'What if I put 10% down?', 'answer' => 'Fee $4,500.00 (1.25%).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Home price" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="down" label="Down payment" value="0" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Interest rate" value="6" step="any" suffix="%" />
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="use" label="VA loan use" :options="['first' => 'First use', 'subsequent' => 'Subsequent use']" selected="first" />
        <x-calc.select name="purpose" label="Loan type" :options="['purchase' => 'Purchase', 'cashout' => 'Cash-out refinance', 'irrrl' => 'IRRRL (streamline refinance)']" selected="purchase" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tax" label="Property tax (% a year)" value="1.1" step="any" suffix="%" />
        <x-calc.field name="insurance" label="Home insurance a year" value="1500" step="0.01" suffix="$" />
    </div>

    <x-calc.checkbox name="exempt" label="Exempt from the funding fee (disability compensation)" :checked="false" />

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'First use' => ['price' => 400000, 'down' => 0, 'rate' => 6, 'years' => 30, 'use' => 'first', 'purpose' => 'purchase', 'tax' => 1.1, 'insurance' => 1500, 'exempt' => false],
        '10% down' => ['price' => 400000, 'down' => 10, 'rate' => 6, 'years' => 30, 'use' => 'first', 'purpose' => 'purchase', 'tax' => 1.1, 'insurance' => 1500, 'exempt' => false],
        'Subsequent use' => ['price' => 400000, 'down' => 0, 'rate' => 6, 'years' => 30, 'use' => 'subsequent', 'purpose' => 'purchase', 'tax' => 1.1, 'insurance' => 1500, 'exempt' => false],
        'Exempt' => ['price' => 400000, 'down' => 0, 'rate' => 6, 'years' => 30, 'use' => 'first', 'purpose' => 'purchase', 'tax' => 1.1, 'insurance' => 1500, 'exempt' => true],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'fee' => ['label' => 'Funding fee'],
            'loan' => ['label' => 'Loan with fee'],
            'interest' => ['label' => 'Total interest'],
            'taxes' => ['label' => 'Taxes and insurance'],
            'note' => ['label' => 'Fee schedule'],
        ]" />
        <x-calc.grid heading="Amortization by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>fee = base loan × rate (by use and down payment)</li>
            <li>loan = base + fee</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
