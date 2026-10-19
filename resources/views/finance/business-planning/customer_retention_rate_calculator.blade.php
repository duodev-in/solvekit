<x-calc.page
    title="Customer Retention Rate Calculator - SolveKit"
    description="Free Customer Retention Rate Calculator: CRR = (E − N) ÷ S. Retention rate is the share of customers at the start of a period who are still customers at the end, ignoring new ones."
    lede="Work out the retention rate from customers at the end, new customers during the period and customers at the start."
    about="Retention rate is the share of customers at the start of a period who are still customers at the end, ignoring new ones. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'customer_retention_rate', 'fields' => ['end', 'new', 'start']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Customers at the end, New customers during the period, Customers at the start.'],
        ['name' => 'Read the result', 'text' => 'The retention rate appears as you type, with churn rate below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the retention rate?', 'answer' => 'CRR = (E − N) ÷ S.'],
        ['question' => 'What is the retention rate for customers at the end 950, new customers during the period 150, customers at the start 1,000?', 'answer' => '80%. Churn rate: 20%.'],
        ['question' => 'And for customers at the end 420, new customers during the period 60, customers at the start 400?', 'answer' => '90%. Churn rate: 10%.'],
        ['question' => 'What does the result tell me?', 'answer' => '1 − retention is the churn rate.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="end" label="Customers at the end" value="950" min="0" step="1" />
        <x-calc.field name="new" label="New customers during the period" value="150" min="0" step="1" />
        <x-calc.field name="start" label="Customers at the start" value="1000" min="0" step="1" />
    </div>

    <x-calc.result label="Retention rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['end' => 950, 'new' => 150, 'start' => 1000],
        'Example B' => ['end' => 420, 'new' => 60, 'start' => 400],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Churn rate'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CRR = (E − N) ÷ S</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
