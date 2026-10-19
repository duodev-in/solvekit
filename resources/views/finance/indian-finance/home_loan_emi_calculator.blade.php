<x-calc.page
    title="Home Loan EMI Calculator - SolveKit"
    description="Free home loan EMI calculator: monthly EMI, total interest and schedule for a home loan in rupees."
    lede="Calculate your home loan EMI."
    about="Home loan EMI = P r (1 + r)^n ÷ [(1 + r)^n − 1]. Interest up to ₹2 lakh a year on a self-occupied home is deductible under Section 24(b) in the old tax regime. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years'], 'currency' => 'INR']"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'What is the EMI on ₹50 lakh at 8.4% for 25 years?', 'answer' => '₹39,924.97.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Loan amount" value="5000000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="8.4" step="any" suffix="%" />
        <x-calc.field name="years" label="Term" value="25" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        '₹50 lakh' => ['amount' => 5000000, 'rate' => 8.4, 'years' => 25],
        '₹30 lakh' => ['amount' => 3000000, 'rate' => 8.5, 'years' => 20],
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
