<x-calc.page
    title="PMI Calculator - SolveKit"
    description="Free PMI calculator: monthly private mortgage insurance and when it can be cancelled (80% LTV) or ends automatically (78%)."
    lede="Estimate PMI and when it goes away."
    about="Conventional loans with less than 20% down usually carry PMI of about 0.3–1.5% of the loan a year, depending on credit score and down payment; use your lender's quoted rate. You can ask to cancel at 80% of the original value, and it must end at 78% (Homeowners Protection Act). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'pmi', 'fields' => ['value', 'amount', 'rate', 'years', 'pmi', 'extra']]"
    :how-to="[
        ['name' => 'Enter the home value and loan', 'text' => ''],
        ['name' => 'Enter the PMI rate', 'text' => 'From your loan estimate.'],
    ]"
    :faqs="[
        ['question' => 'What is PMI on a $332,500 loan for a $350,000 home at 0.6%?', 'answer' => '$166.25 a month.'],
        ['question' => 'When does it end?', 'answer' => 'Month 135 (11 years 3 months): ends automatically at 78%.'],
        ['question' => 'And with $200 extra a month?', 'answer' => 'Month 93 (7 years 9 months): ends automatically at 78%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="value" label="Home value (purchase price)" value="350000" step="0.01" suffix="$" />
        <x-calc.field name="amount" label="Loan amount" value="332500" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="pmi" label="PMI rate a year" value="0.6" step="any" suffix="%" />
        <x-calc.field name="extra" label="Extra each month" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Monthly PMI" />

    <x-calc.options :decimals="false" :examples="[
        '5% down' => ['value' => 350000, 'amount' => 332500, 'rate' => 6.5, 'years' => 30, 'pmi' => 0.6, 'extra' => 0],
        'Extra $200' => ['value' => 350000, 'amount' => 332500, 'rate' => 6.5, 'years' => 30, 'pmi' => 0.6, 'extra' => 200],
        '10% down' => ['value' => 350000, 'amount' => 315000, 'rate' => 6.5, 'years' => 30, 'pmi' => 0.45, 'extra' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ltv' => ['label' => 'Loan-to-value'],
            'request' => ['label' => 'Request cancellation'],
            'auto' => ['label' => 'Ends automatically'],
            'total' => ['label' => 'Total PMI paid'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PMI = loan × rate ÷ 12</li>
            <li>cancel at 80%, ends at 78% of original value</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
