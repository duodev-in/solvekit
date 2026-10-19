<x-calc.page
    title="Billable Hours Calculator - SolveKit"
    description="Free billable hours calculator: utilization rate, billed revenue and the hours needed to reach a target."
    lede="Work out your billable utilization."
    about="Utilization = billable hours ÷ total hours worked. Law firms and agencies often target 70–85%; revenue = billable hours × billing rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'billable', 'fields' => ['billable', 'total', 'rate', 'target']]"
    :how-to="[
        ['name' => 'Enter billable and total hours', 'text' => ''],
        ['name' => 'Add your rate and target', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the utilization of 32 billable hours out of 45?', 'answer' => '71.11%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="billable" label="Billable hours" value="32" min="0" step="any" />
        <x-calc.field name="total" label="Total hours worked" value="45" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Billing rate" value="150" step="0.01" suffix="$" />
        <x-calc.field name="target" label="Target utilization" value="80" step="any" suffix="%" />
    </div>

    <x-calc.result label="Billable utilization" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['billable' => 32, 'total' => 45, 'rate' => 150, 'target' => 80],
        'Lawyer' => ['billable' => 40, 'total' => 50, 'rate' => 350, 'target' => 85],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'revenue' => ['label' => 'Revenue'],
            'target' => ['label' => 'To reach target'],
            'yearly' => ['label' => 'Revenue a year at this pace'],
            'effective' => ['label' => 'Revenue per hour worked'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>utilization = billable ÷ total</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
