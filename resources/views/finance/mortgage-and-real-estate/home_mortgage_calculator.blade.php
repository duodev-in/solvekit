<x-calc.page
    title="Home Mortgage Calculator - SolveKit"
    description="Free home mortgage calculator: monthly payment, total interest and an amortization schedule for buying a home."
    lede="Estimate the monthly payment on a home loan."
    about="The principal and interest payment is the level payment that repays the loan over the term: L × r ÷ [1 − (1 + r)^−n] with r the monthly rate. The full monthly cost adds property tax, homeowners insurance, HOA dues and private mortgage insurance (PMI) when you put down less than 20%. PMI must end automatically when the balance is scheduled to reach 78% of the original value (Homeowners Protection Act). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'mortgage', 'fields' => ['price', 'down', 'rate', 'years', 'tax', 'insurance']]"
    :how-to="[
        ['name' => 'Enter the home price and down payment', 'text' => 'The loan is the difference.'],
        ['name' => 'Enter rate, term and costs', 'text' => 'Taxes, insurance, HOA and PMI make up the full payment.'],
    ]"
    :faqs="[
        ['question' => 'What does a $300,000 home cost a month with 10% down at 6.5%?', 'answer' => '$2,106.58 including tax and insurance.'],
        ['question' => 'And on a 15-year loan at 5.75% with 20% down?', 'answer' => '$2,392.98.'],
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
        <x-calc.field name="insurance" label="Home insurance a year" value="1500" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Starter home' => ['price' => 300000, 'down' => 10, 'rate' => 6.5, 'years' => 30, 'tax' => 1.1, 'insurance' => 1500],
        '15-year' => ['price' => 300000, 'down' => 20, 'rate' => 5.75, 'years' => 15, 'tax' => 1.1, 'insurance' => 1500],
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
