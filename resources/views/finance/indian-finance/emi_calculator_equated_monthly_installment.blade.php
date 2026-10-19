<x-calc.page
    title="EMI Calculator – Equated Monthly Installment - SolveKit"
    description="Free EMI calculator: equated monthly instalment, total interest and amortization schedule for home, car and personal loans in rupees."
    lede="Calculate your EMI and total interest."
    about="EMI = P × r × (1 + r)^n ÷ [(1 + r)^n − 1], with r the monthly rate (annual ÷ 12) and n the months. Indian banks compute EMIs on reducing balance; part-prepayments reduce the tenure or the EMI. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years', 'extra'], 'currency' => 'INR']"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Add extra payments', 'text' => 'Optional: see how much sooner it is paid off.'],
    ]"
    :faqs="[
        ['question' => 'What is the EMI on ₹25 lakh at 8.5% for 20 years?', 'answer' => '₹21,695.58, total interest ₹27,06,939.40.'],
        ['question' => 'And ₹8 lakh at 9% for 5 years?', 'answer' => '₹16,606.68.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="2500000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="8.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="20" min="0" step="any" suffix="years" />
        <x-calc.field name="extra" label="Extra each month (part-prepayment)" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Home loan' => ['amount' => 2500000, 'rate' => 8.5, 'years' => 20, 'extra' => 0],
        'Car loan' => ['amount' => 800000, 'rate' => 9, 'years' => 5, 'extra' => 0],
        'Personal loan' => ['amount' => 300000, 'rate' => 12, 'years' => 3, 'extra' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'interest' => ['label' => 'Total interest'],
            'total' => ['label' => 'Total paid'],
            'payoff' => ['label' => 'Paid off in'],
            'saved' => ['label' => 'Interest saved'],
            'apr' => ['label' => 'APR'],
            'share' => ['label' => 'Interest as a share of the loan'],
        ]" />
        <x-calc.grid heading="Amortization by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EMI = P r (1 + r)^n ÷ [(1 + r)^n − 1]</li>
            <li>r = annual rate ÷ 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
