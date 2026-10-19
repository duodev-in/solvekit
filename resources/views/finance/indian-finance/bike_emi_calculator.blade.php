<x-calc.page
    title="Bike EMI Calculator - SolveKit"
    description="Free bike EMI calculator: EMI on a two-wheeler loan in rupees."
    lede="Calculate your two-wheeler loan EMI."
    about="Two-wheeler loans usually run 1–4 years. EMI = P r (1 + r)^n ÷ [(1 + r)^n − 1]. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years'], 'currency' => 'INR']"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'What is the EMI on ₹1 lakh at 11% for 3 years?', 'answer' => '₹3,273.87.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Loan amount" value="100000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="11" step="any" suffix="%" />
        <x-calc.field name="years" label="Term" value="3" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 100000, 'rate' => 11, 'years' => 3],
        'Superbike' => ['amount' => 400000, 'rate' => 10, 'years' => 4],
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
