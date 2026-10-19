<x-calc.page
    title="Consulting Fees Calculator - SolveKit"
    description="Free consulting rate calculator: hourly, day and project rates from your target income, overhead, taxes, profit margin and billable hours."
    lede="Set your consulting rate."
    about="Rate = (target income + overhead + self-employment and other taxes) ÷ (1 − profit margin) ÷ billable hours a year. Consultants rarely bill more than 60–75% of working hours. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'consulting', 'fields' => ['income', 'overhead', 'taxes', 'profit', 'hours', 'weeks', 'project_hours']]"
    :how-to="[
        ['name' => 'Enter income and costs', 'text' => ''],
        ['name' => 'Enter billable time', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What rate earns $120,000 with 25 billable hours a week, 46 weeks?', 'answer' => '$149.76 an hour; day rate $1,198.07.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="Target income" value="120000" step="0.01" suffix="$" />
        <x-calc.field name="overhead" label="Business overhead a year" value="18000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="taxes" label="Extra taxes (SE tax, etc.)" value="17000" step="0.01" suffix="$" />
        <x-calc.field name="profit" label="Profit margin" value="10" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hours" label="Billable hours a week" value="25" min="1" step="any" />
        <x-calc.field name="weeks" label="Working weeks a year" value="46" min="1" max="52" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="project_hours" label="Project hours (optional)" value="60" min="0" step="any" />
    </div>

    <x-calc.result label="Hourly rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['income' => 120000, 'overhead' => 18000, 'taxes' => 17000, 'profit' => 10, 'hours' => 25, 'weeks' => 46, 'project_hours' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'day' => ['label' => 'Day rate (8 hours)'],
            'week' => ['label' => 'Weekly'],
            'project' => ['label' => 'Project fee'],
            'revenue' => ['label' => 'Revenue needed'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rate = (income + overhead + taxes) ÷ (1 − margin) ÷ hours</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
