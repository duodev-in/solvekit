<x-calc.page
    title="LTV Calculator — Loan to Value - SolveKit"
    description="Free LTV Calculator — Loan to Value: LTV = loan ÷ appraised value. Lenders use LTV to set rates, PMI and approval."
    lede="Work out the loan-to-value from loan amount and appraised value."
    about="Lenders use LTV to set rates, PMI and approval. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'ltv', 'fields' => ['loan', 'value']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Loan amount, Appraised value.'],
        ['name' => 'Read the result', 'text' => 'The loan-to-value appears as you type, with equity below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the loan-to-value?', 'answer' => 'LTV = loan ÷ appraised value.'],
        ['question' => 'What is the loan-to-value for loan amount $320,000, appraised value $400,000?', 'answer' => '80%. Equity: $80,000.00.'],
        ['question' => 'And for loan amount $450,000, appraised value $500,000?', 'answer' => '90%. Equity: $50,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'At or below 80% usually avoids PMI on conventional loans.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="loan" label="Loan amount" value="320000" step="0.01" suffix="$" />
        <x-calc.field name="value" label="Appraised value" value="400000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Loan-to-value" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['loan' => 320000, 'value' => 400000],
        'Example B' => ['loan' => 450000, 'value' => 500000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Equity'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>LTV = loan ÷ appraised value</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
