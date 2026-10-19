<x-calc.page
    title="Mortgage Rate Calculator - SolveKit"
    description="Free mortgage rate calculator: the interest rate implied by a loan amount, monthly payment and term."
    lede="Find the rate behind a mortgage payment."
    about="The rate solves L = PMT × [1 − (1 + r)^−n] ÷ r for r, numerically. Use the principal and interest part of the payment only. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan_rate', 'fields' => ['amount', 'payment', 'years']]"
    :how-to="[
        ['name' => 'Enter the loan and payment', 'text' => ''],
        ['name' => 'Read the rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What rate gives $1,900 a month on $300,000 over 30 years?', 'answer' => '6.519%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Loan amount" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="payment" label="Monthly payment (P&I)" value="1900" step="0.01" suffix="$" />
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Interest rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 300000, 'payment' => 1900, 'years' => 30],
        '15-year' => ['amount' => 300000, 'payment' => 2500, 'years' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'effective' => ['label' => 'Effective annual rate'],
            'interest' => ['label' => 'Total interest'],
            'total' => ['label' => 'Total paid'],
            'monthly' => ['label' => 'Monthly rate'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>L = PMT[1 − (1 + r)^−n] ÷ r, solved for r</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
