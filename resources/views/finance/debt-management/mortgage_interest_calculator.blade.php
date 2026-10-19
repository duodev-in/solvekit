<x-calc.page
    title="Mortgage Interest Calculator - SolveKit"
    description="Free mortgage interest calculator: interest paid in the first year and over the loan, and the value of the mortgage interest deduction if you itemize."
    lede="Find the interest on your mortgage and its tax deduction."
    about="Interest each year = the sum of balance × monthly rate. Itemizers can deduct interest on up to $750,000 of acquisition debt (made permanent in 2025); the saving is interest × your marginal tax rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'mortgage_interest', 'fields' => ['amount', 'rate', 'years', 'tax_rate']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'How much interest is paid in the first year on $400,000 at 6.5%?', 'answer' => '$25,868.36.'],
        ['question' => 'What is the deduction worth at 24%?', 'answer' => '$6,208.41 first-year tax saving if you itemize.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="tax_rate" label="Your tax rate" value="24" step="any" suffix="%" />
    </div>

    <x-calc.result label="Interest in the first year" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 400000, 'rate' => 6.5, 'years' => 30, 'tax_rate' => 24],
        'Large loan' => ['amount' => 1000000, 'rate' => 6.75, 'years' => 30, 'tax_rate' => 35],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Interest over the loan'],
            'deduction' => ['label' => 'Tax saving'],
            'share' => ['label' => 'Interest share of first-year payments'],
            'payment' => ['label' => 'Monthly payment'],
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
