<x-calc.page
    title="FD Calculator — Fixed Deposit Calculator - SolveKit"
    description="Free FD calculator: maturity value of a bank fixed deposit with quarterly compounding (simple interest under 6 months), and the quarterly or monthly payout options."
    lede="Find the maturity of a fixed deposit."
    about="Indian banks compound FD interest quarterly: A = P(1 + r/4)^(4t); deposits under 6 months earn simple interest. Senior citizens usually get 0.25–0.5% more. Interest is taxable; TDS of 10% applies above ₹50,000 a year (₹1 lakh for seniors). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'fd', 'fields' => ['amount', 'rate', 'months', 'senior'], 'currency' => 'INR']"
    :how-to="[
        ['name' => 'Enter deposit, rate and tenure', 'text' => ''],
        ['name' => 'Add the senior citizen rate', 'text' => 'If it applies.'],
    ]"
    :faqs="[
        ['question' => 'What does ₹1 lakh in a 3-year FD at 7% give?', 'answer' => '₹1,23,144.'],
        ['question' => 'And a 5-month FD?', 'answer' => '₹1,02,500 (simple interest).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Deposit" value="100000" step="1" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="7" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="months" label="Tenure" value="36" min="0" step="1" suffix="months" />
        <x-calc.field name="senior" label="Senior citizen extra" value="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="Maturity value" />

    <x-calc.options :decimals="false" :examples="[
        '3 years' => ['amount' => 100000, 'rate' => 7, 'months' => 36, 'senior' => 0],
        'Senior 5 years' => ['amount' => 500000, 'rate' => 7, 'months' => 60, 'senior' => 0.5],
        '5 months' => ['amount' => 100000, 'rate' => 6, 'months' => 5, 'senior' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'interest' => ['label' => 'Interest'],
            'yield' => ['label' => 'Effective yield'],
            'quarterly' => ['label' => 'Quarterly payout option'],
            'monthly' => ['label' => 'Monthly payout option'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = P(1 + r/4)^(4t)</li>
            <li>under 6 months: A = P(1 + rt)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
