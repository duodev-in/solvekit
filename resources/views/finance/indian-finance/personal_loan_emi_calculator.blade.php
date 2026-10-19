<x-calc.page
    title="Personal Loan EMI Calculator - SolveKit"
    description="Free personal loan EMI calculator: EMI, interest and APR with a processing fee in rupees."
    lede="Calculate your personal loan EMI."
    about="Personal loans carry processing fees of about 1–3%, which raise the effective rate. EMI = P r (1 + r)^n ÷ [(1 + r)^n − 1]. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years', 'fee'], 'currency' => 'INR']"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'What is the EMI on ₹5 lakh at 12% for 3 years?', 'answer' => '₹16,607.15; APR with a 2% fee 13.41% with ₹10,000.00 of fees.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="12" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="3" min="0" step="any" suffix="years" />
        <x-calc.field name="fee" label="Processing fee (% of the loan)" value="2" step="any" suffix="%" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 500000, 'rate' => 12, 'years' => 3, 'fee' => 2],
        'Short' => ['amount' => 200000, 'rate' => 14, 'years' => 2, 'fee' => 1],
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
        </ul>
    </x-slot:formula>
</x-calc.page>
