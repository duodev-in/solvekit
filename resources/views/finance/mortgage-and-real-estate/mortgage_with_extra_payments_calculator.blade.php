<x-calc.page
    title="Mortgage with Extra Payments Calculator - SolveKit"
    description="Free mortgage extra payment calculator: how monthly, yearly or one-off extra payments shorten the loan and cut interest."
    lede="See what extra payments save on a mortgage."
    about="Extra payments go straight to principal, so each later payment includes less interest. The table shows the schedule with your extra payments and the chart compares the balance with and without them. The principal and interest payment is the level payment that repays the loan over the term: L × r ÷ [1 − (1 + r)^−n] with r the monthly rate. The full monthly cost adds property tax, homeowners insurance, HOA dues and private mortgage insurance (PMI) when you put down less than 20%. PMI must end automatically when the balance is scheduled to reach 78% of the original value (Homeowners Protection Act). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'mortgage', 'fields' => ['price', 'down', 'rate', 'years', 'extra', 'extra_yearly', 'lump', 'lump_month']]"
    :how-to="[
        ['name' => 'Enter the home price and down payment', 'text' => 'The loan is the difference.'],
        ['name' => 'Enter rate, term and costs', 'text' => 'Taxes, insurance, HOA and PMI make up the full payment.'],
    ]"
    :faqs="[
        ['question' => 'How much does $200 a month extra save on a $320,000 loan at 6.5%?', 'answer' => 'Paid off in 23 years 5 months, saving $105,428.67 interest.'],
        ['question' => 'And $2,000 once a year?', 'answer' => '24 years 5 months, saving $88,832.25 interest.'],
        ['question' => 'And a $10,000 lump sum after 2 years?', 'answer' => '27 years 8 months, saving $47,011.90 interest.'],
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
        <x-calc.field name="extra" label="Extra each month" value="200" step="0.01" suffix="$" />
        <x-calc.field name="extra_yearly" label="Extra once a year" value="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lump" label="One-off extra payment" value="0" step="0.01" suffix="$" />
        <x-calc.field name="lump_month" label="In month" value="12" min="1" step="1" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        '$200 a month' => ['price' => 400000, 'down' => 20, 'rate' => 6.5, 'years' => 30, 'extra' => 200, 'extra_yearly' => 0, 'lump' => 0, 'lump_month' => 12],
        '$2,000 a year' => ['price' => 400000, 'down' => 20, 'rate' => 6.5, 'years' => 30, 'extra' => 0, 'extra_yearly' => 2000, 'lump' => 0, 'lump_month' => 12],
        '$10,000 once' => ['price' => 400000, 'down' => 20, 'rate' => 6.5, 'years' => 30, 'extra' => 0, 'extra_yearly' => 0, 'lump' => 10000, 'lump_month' => 24],
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
