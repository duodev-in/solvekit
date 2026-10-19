<x-calc.page
    title="Interest Rate Calculator - SolveKit"
    description="Free interest rate calculator: the annual rate of a loan from the amount borrowed, the monthly payment and the number of payments."
    lede="Find the interest rate of a loan from its payment."
    about="The rate is the r that makes the payments' present value equal the amount borrowed: amount = payment × [1 − (1 + r)^−n] ÷ r. There is no closed form, so it is solved numerically. The monthly rate × 12 is the APR; (1 + r)^12 − 1 is the effective rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'interest_rate', 'fields' => ['amount', 'payment', 'months']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, payment and number of payments.'],
        ['name' => 'Read the rate', 'text' => 'APR and effective rate.'],
    ]"
    :faqs="[
        ['question' => 'What rate is a $25,000 loan repaid at $500 a month for 60 months?', 'answer' => '7.42%.'],
        ['question' => 'And $10,000 at $350 a month for 36 months?', 'answer' => '15.68%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Amount borrowed" value="25000" step="0.01" suffix="$" />
        <x-calc.field name="payment" label="Monthly payment" value="500" step="0.01" suffix="$" />
        <x-calc.field name="months" label="Number of payments" value="60" min="0" step="1" suffix="months" />
    </div>

    <x-calc.result label="Annual interest rate (APR)" />

    <x-calc.options :decimals="false" :examples="[
        'Car loan' => ['amount' => 25000, 'payment' => 500, 'months' => 60],
        'Short loan' => ['amount' => 10000, 'payment' => 350, 'months' => 36],
        'Mortgage' => ['amount' => 300000, 'payment' => 1900, 'months' => 360],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'monthly' => ['label' => 'Monthly rate'],
            'effective' => ['label' => 'Effective annual rate'],
            'interest' => ['label' => 'Total interest'],
            'total' => ['label' => 'Total paid'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>amount = PMT × [1 − (1 + r)^−n] ÷ r, solved for r</li>
            <li>APR = 12r</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
