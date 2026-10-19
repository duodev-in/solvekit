<x-calc.page
    title="Mortgage Calculator - SolveKit"
    description="Free mortgage calculator: monthly payment with principal and interest, property tax, insurance, HOA and PMI, an amortization schedule and the effect of extra payments."
    lede="Work out your monthly mortgage payment and see the full schedule."
    about="The principal and interest payment is the level payment that repays the loan over the term: L × r ÷ [1 − (1 + r)^−n] with r the monthly rate. The full monthly cost adds property tax, homeowners insurance, HOA dues and private mortgage insurance (PMI) when you put down less than 20%. PMI must end automatically when the balance is scheduled to reach 78% of the original value (Homeowners Protection Act). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'mortgage', 'fields' => ['price', 'down', 'rate', 'years', 'tax', 'pmi', 'insurance', 'hoa', 'extra']]"
    :how-to="[
        ['name' => 'Enter the home price and down payment', 'text' => 'The loan is the difference.'],
        ['name' => 'Enter rate, term and costs', 'text' => 'Taxes, insurance, HOA and PMI make up the full payment.'],
    ]"
    :faqs="[
        ['question' => 'What is the payment on a $400,000 home with 20% down at 6.5% for 30 years?', 'answer' => '$2,539.28 including tax and insurance; $2,022.62 of it is principal and interest.'],
        ['question' => 'How much interest is paid over 30 years?', 'answer' => '$408,142.36.'],
        ['question' => 'What does $200 a month extra do?', 'answer' => 'Pays it off in 23 years 5 months, saving $105,428.67 interest.'],
        ['question' => 'When does PMI end with 10% down?', 'answer' => '$150.00 until month 109 (78% LTV).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Home price" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="down" label="Down payment" value="20" step="any" suffix="%" />
        <x-calc.field name="rate" label="Interest rate" value="6.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="tax" label="Property tax (% of value a year)" value="1.1" step="any" suffix="%" />
        <x-calc.field name="pmi" label="PMI rate (if under 20% down)" value="0.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="insurance" label="Home insurance a year" value="1800" step="0.01" suffix="$" />
        <x-calc.field name="hoa" label="HOA dues a month" value="0" step="0.01" suffix="$" />
        <x-calc.field name="extra" label="Extra each month" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        '20% down' => ['price' => 400000, 'down' => 20, 'rate' => 6.5, 'years' => 30, 'tax' => 1.1, 'insurance' => 1800, 'hoa' => 0, 'pmi' => 0.5, 'extra' => 0],
        '10% down with PMI' => ['price' => 400000, 'down' => 10, 'rate' => 6.5, 'years' => 30, 'tax' => 1.1, 'insurance' => 1800, 'hoa' => 0, 'pmi' => 0.5, 'extra' => 0],
        'Extra $200' => ['price' => 400000, 'down' => 20, 'rate' => 6.5, 'years' => 30, 'tax' => 1.1, 'insurance' => 1800, 'hoa' => 0, 'pmi' => 0.5, 'extra' => 200],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'pi' => ['label' => 'Principal and interest'],
            'taxes' => ['label' => 'Property tax'],
            'insurance' => ['label' => 'Home insurance'],
            'hoa' => ['label' => 'HOA dues'],
            'pmi' => ['label' => 'PMI'],
            'ltv' => ['label' => 'Loan-to-value'],
            'interest' => ['label' => 'Total interest'],
            'payoff' => ['label' => 'Paid off in'],
        ]" />
        <x-calc.grid heading="Amortization by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P&I = L × r ÷ [1 − (1 + r)^−n]</li>
            <li>payment = P&I + tax ÷ 12 + insurance ÷ 12 + HOA + PMI</li>
            <li>PMI ends at 78% of the original value</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
