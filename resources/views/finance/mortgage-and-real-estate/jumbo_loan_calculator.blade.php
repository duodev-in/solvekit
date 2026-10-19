<x-calc.page
    title="Jumbo Loan Calculator - SolveKit"
    description="Free jumbo loan calculator: payment on a mortgage above the 2026 conforming loan limit ($832,750 in most counties) and how far above the limit it is."
    lede="Check if your loan is jumbo and see the payment."
    about="Loans above the FHFA conforming limit cannot be bought by Fannie Mae or Freddie Mac, so lenders often ask for larger down payments, higher credit scores and reserves. The 2026 limit is $832,750 for one-unit homes in most counties and up to $1,249,125 in high-cost areas; enter your county's limit if different. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'jumbo', 'fields' => ['amount', 'rate', 'years'], 'data' => ['loanlimits' => config('finance_data.loanlimits')]]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'Is a $1,000,000 loan jumbo in 2026?', 'answer' => 'Jumbo: $167,250 above the $832,750 conforming limit.'],
        ['question' => 'What is its payment at 6.75%?', 'answer' => '$6,485.98.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Loan amount" value="1000000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6.75" step="any" suffix="%" />
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Jumbo' => ['amount' => 1000000, 'rate' => 6.75, 'years' => 30],
        'Just under' => ['amount' => 800000, 'rate' => 6.5, 'years' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'interest' => ['label' => 'Total interest'],
            'total' => ['label' => 'Total paid'],
            'jumbo' => ['label' => 'Conforming or jumbo'],
            'limits' => ['label' => '2026 limits'],
        ]" />
        <x-calc.grid heading="Amortization by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PMT = P × r ÷ [1 − (1 + r)^−n]</li>
            <li>r = annual rate ÷ 12, n = months</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
