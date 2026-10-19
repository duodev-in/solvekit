<x-calc.page
    title="FHA Loan calculator - SolveKit"
    description="Free FHA loan calculator: monthly payment with the 1.75% upfront and annual mortgage insurance premiums (HUD 2023 rates), taxes and insurance."
    lede="Work out an FHA mortgage payment with MIP."
    about="FHA loans need 3.5% down with a 580+ credit score. The 1.75% upfront MIP is usually added to the loan. Annual MIP for loans over 15 years is 0.50% (LTV 95% or less) or 0.55%, or 0.70%/0.75% above $726,200 (HUD ML 2023-05). With 10% or more down it ends after 11 years; otherwise it lasts the life of the loan. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'fha', 'fields' => ['price', 'down', 'rate', 'years', 'tax', 'insurance'], 'data' => ['fha' => config('finance_data.fha')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter price and down payment', 'text' => 'At least 3.5%.'],
        ['name' => 'Enter rate, term, tax and insurance', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the FHA payment on a $350,000 home with 3.5% down at 6.25%?', 'answer' => '$2,716.61.'],
        ['question' => 'How much is the upfront MIP?', 'answer' => '$5,910.63 (1.75%, added to the loan).'],
        ['question' => 'When does MIP end with 10% down?', 'answer' => '0.5% a year: $131.25 a month, for 11 years.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Home price" value="350000" step="0.01" suffix="$" />
        <x-calc.field name="down" label="Down payment" value="3.5" step="any" suffix="%" />
        <x-calc.field name="rate" label="Interest rate" value="6.25" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="tax" label="Property tax (% a year)" value="1.1" step="any" suffix="%" />
        <x-calc.field name="insurance" label="Home insurance a year" value="1500" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        '3.5% down' => ['price' => 350000, 'down' => 3.5, 'rate' => 6.25, 'years' => 30, 'tax' => 1.1, 'insurance' => 1500],
        '10% down' => ['price' => 350000, 'down' => 10, 'rate' => 6.25, 'years' => 30, 'tax' => 1.1, 'insurance' => 1500],
        '15-year' => ['price' => 300000, 'down' => 5, 'rate' => 5.75, 'years' => 15, 'tax' => 1.1, 'insurance' => 1500],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'base' => ['label' => 'Base loan'],
            'upfront' => ['label' => 'Upfront MIP'],
            'loan' => ['label' => 'Loan with upfront MIP'],
            'mip' => ['label' => 'Annual MIP'],
            'taxes' => ['label' => 'Taxes and insurance'],
            'limit' => ['label' => 'FHA loan limits'],
        ]" />
        <x-calc.grid heading="Amortization by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>base loan = price × (1 − down)</li>
            <li>loan = base × 1.0175</li>
            <li>MIP = base × annual rate ÷ 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
