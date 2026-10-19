<x-calc.page
    title="Cost of Doing Business Calculator - SolveKit"
    description="Free cost of doing business calculator: monthly and yearly operating cost, cost per billable hour and the revenue needed for a target margin."
    lede="Find what it costs to run your business."
    about="Cost of doing business = overhead + payroll + direct costs + other expenses. Divided by billable hours it gives the minimum hourly charge to break even; revenue for a margin m = cost ÷ (1 − m). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'cost_business', 'fields' => ['overhead', 'payroll', 'direct', 'other', 'hours', 'margin']]"
    :how-to="[
        ['name' => 'Enter monthly costs', 'text' => ''],
        ['name' => 'Enter billable hours and margin', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the cost per billable hour of the example?', 'answer' => '$95.83.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="overhead" label="Overhead (rent, insurance, software) a month" value="8000" step="0.01" suffix="$" />
        <x-calc.field name="payroll" label="Payroll a month" value="30000" step="0.01" suffix="$" />
        <x-calc.field name="direct" label="Direct costs a month" value="6000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="other" label="Other a month" value="2000" step="0.01" suffix="$" />
        <x-calc.field name="hours" label="Billable hours a month" value="480" min="0" step="any" />
        <x-calc.field name="margin" label="Target margin" value="20" step="any" suffix="%" />
    </div>

    <x-calc.result label="Cost of doing business a month" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['overhead' => 8000, 'payroll' => 30000, 'direct' => 6000, 'other' => 2000, 'hours' => 480, 'margin' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hour' => ['label' => 'Per billable hour'],
            'day' => ['label' => 'Per working day'],
            'share' => ['label' => 'Biggest shares'],
            'revenue' => ['label' => 'Revenue needed'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost = overhead + payroll + direct + other</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
