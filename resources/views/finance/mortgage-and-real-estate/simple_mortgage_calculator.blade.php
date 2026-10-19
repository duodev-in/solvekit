<x-calc.page
    title="Simple Mortgage Calculator - SolveKit"
    description="Free simple mortgage calculator: the monthly principal and interest payment from price, down payment, rate and term."
    lede="Quick mortgage payment estimate."
    about="Monthly principal and interest = L × r ÷ [1 − (1 + r)^−n], where L is the loan, r the monthly rate and n the number of payments. Add taxes and insurance with the full Mortgage Calculator. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'mortgage', 'fields' => ['price', 'down', 'rate', 'years']]"
    :how-to="[
        ['name' => 'Enter the home price and down payment', 'text' => 'The loan is the difference.'],
        ['name' => 'Enter rate, term and costs', 'text' => 'Taxes, insurance, HOA and PMI make up the full payment.'],
    ]"
    :faqs="[
        ['question' => 'What is the payment on a $400,000 home with 20% down at 6.5%?', 'answer' => '$2,022.62.'],
        ['question' => 'And on $250,000 with 10% down?', 'answer' => '$1,422.15.'],
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

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        '$400k home' => ['price' => 400000, 'down' => 20, 'rate' => 6.5, 'years' => 30],
        '$250k home' => ['price' => 250000, 'down' => 10, 'rate' => 6.5, 'years' => 30],
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
