<x-calc.page
    title="Mortgage Calculator with Taxes and Insurance - SolveKit"
    description="Free PITI mortgage calculator: principal, interest, property taxes and homeowners insurance, plus HOA dues and PMI, in one monthly payment."
    lede="See the full monthly cost of a mortgage."
    about="The principal and interest payment is the level payment that repays the loan over the term: L × r ÷ [1 − (1 + r)^−n] with r the monthly rate. The full monthly cost adds property tax, homeowners insurance, HOA dues and private mortgage insurance (PMI) when you put down less than 20%. PMI must end automatically when the balance is scheduled to reach 78% of the original value (Homeowners Protection Act). Property tax rates vary widely: from about 0.3% of value in Hawaii to over 2% in New Jersey and Illinois. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'mortgage', 'fields' => ['price', 'down', 'rate', 'years', 'tax', 'pmi', 'insurance', 'hoa']]"
    :how-to="[
        ['name' => 'Enter the home price and down payment', 'text' => 'The loan is the difference.'],
        ['name' => 'Enter rate, term and costs', 'text' => 'Taxes, insurance, HOA and PMI make up the full payment.'],
    ]"
    :faqs="[
        ['question' => 'What is the full payment on a $400,000 home with 20% down, 1.1% tax, $1,800 insurance and $150 HOA?', 'answer' => '$2,689.28.'],
        ['question' => 'And in a 2.2% property tax state?', 'answer' => '$2,905.95.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Home price" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="down" label="Down payment" value="20" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Interest rate" value="6.5" step="any" suffix="%" />
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tax" label="Property tax (% of value a year)" value="1.1" step="any" suffix="%" />
        <x-calc.field name="pmi" label="PMI rate (if under 20% down)" value="0.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="insurance" label="Home insurance a year" value="1800" step="0.01" suffix="$" />
        <x-calc.field name="hoa" label="HOA dues a month" value="150" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Typical' => ['price' => 400000, 'down' => 20, 'rate' => 6.5, 'years' => 30, 'tax' => 1.1, 'insurance' => 1800, 'hoa' => 150, 'pmi' => 0.5],
        'High-tax state' => ['price' => 400000, 'down' => 20, 'rate' => 6.5, 'years' => 30, 'tax' => 2.2, 'insurance' => 1800, 'hoa' => 0, 'pmi' => 0.5],
        'Low down payment' => ['price' => 400000, 'down' => 5, 'rate' => 6.5, 'years' => 30, 'tax' => 1.1, 'insurance' => 1800, 'hoa' => 0, 'pmi' => 0.8],
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
