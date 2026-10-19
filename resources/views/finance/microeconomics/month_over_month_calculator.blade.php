<x-calc.page
    title="Month-Over-Month Calculator - SolveKit"
    description="Free Month-Over-Month Calculator: MoM = (this month − last month) ÷ last month. Month-over-month growth compares consecutive months."
    lede="Work out the month-over-month change from last month and this month."
    about="Month-over-month growth compares consecutive months. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'month_over_month', 'fields' => ['last', 'this']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Last month, This month.'],
        ['name' => 'Read the result', 'text' => 'The month-over-month change appears as you type, with change, annualized (compounded) below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the month-over-month change?', 'answer' => 'MoM = (this month − last month) ÷ last month.'],
        ['question' => 'What is the month-over-month change for last month 42,000, this month 45,500?', 'answer' => '8.333%. Change: 3,500.'],
        ['question' => 'And for last month 1,300, this month 1,250?', 'answer' => '−3.846%. Change: −50.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compounded over 12 months, 2% a month is 26.8% a year.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="last" label="Last month" value="42000" step="any" />
        <x-calc.field name="this" label="This month" value="45500" step="any" />
    </div>

    <x-calc.result label="Month-over-month change" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['last' => 42000, 'this' => 45500],
        'Example B' => ['last' => 1300, 'this' => 1250],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Change'],
            'r2' => ['label' => 'Annualized (compounded)'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MoM = (this month − last month) ÷ last month</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
