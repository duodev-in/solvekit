<x-calc.page
    title="SaaS Lifetime Value Calculator - SolveKit"
    description="Free SaaS Lifetime Value Calculator: LTV = ARPA × gross margin ÷ churn. Lifetime value is the gross profit a customer brings over the expected lifetime of 1 ÷ churn months."
    lede="Work out the customer lifetime value from average revenue per account a month, gross margin and monthly churn."
    about="Lifetime value is the gross profit a customer brings over the expected lifetime of 1 ÷ churn months. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'saas_lifetime_value', 'fields' => ['arpa', 'margin', 'churn']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Average revenue per account a month, Gross margin, Monthly churn.'],
        ['name' => 'Read the result', 'text' => 'The customer lifetime value appears as you type, with expected lifetime below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the customer lifetime value?', 'answer' => 'LTV = ARPA × gross margin ÷ churn.'],
        ['question' => 'What is the customer lifetime value for average revenue per account a month $120, gross margin 80%, monthly churn 2.5%?', 'answer' => '$3,840.00. Expected lifetime: 40 months.'],
        ['question' => 'And for average revenue per account a month $49, gross margin 75%, monthly churn 4%?', 'answer' => '$918.75. Expected lifetime: 25 months.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare with CAC: an LTV:CAC of 3 or more is a common target.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="arpa" label="Average revenue per account a month" value="120" step="0.01" suffix="$" />
        <x-calc.field name="margin" label="Gross margin" value="80" step="any" suffix="%" />
        <x-calc.field name="churn" label="Monthly churn" value="2.5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Customer lifetime value" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['arpa' => 120, 'margin' => 80, 'churn' => 2.5],
        'Example B' => ['arpa' => 49, 'margin' => 75, 'churn' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Expected lifetime'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>LTV = ARPA × gross margin ÷ churn</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
