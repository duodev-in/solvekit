<x-calc.page
    title="Labor Cost Calculator - SolveKit"
    description="Free labor cost calculator: fully loaded cost of an employee per productive hour, month and year including payroll taxes, benefits, overhead and paid time off."
    lede="Find the true cost of labor."
    about="Loaded cost = wages + employer payroll taxes (about 7.65% FICA plus unemployment taxes) + benefits + overhead. Divide by productive hours (paid hours minus paid time off) for the real cost per hour worked. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'labor_cost', 'fields' => ['wage', 'hours', 'taxes', 'benefits', 'overhead', 'paid_off']]"
    :how-to="[
        ['name' => 'Enter wage and hours', 'text' => ''],
        ['name' => 'Add taxes, benefits and overhead', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does a $25 an hour employee really cost per productive hour?', 'answer' => '$36.29.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="wage" label="Hourly wage" value="25" step="0.01" suffix="$" />
        <x-calc.field name="hours" label="Hours a week" value="40" min="0" step="any" />
        <x-calc.field name="taxes" label="Employer payroll taxes" value="9" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="benefits" label="Benefits a month" value="650" step="0.01" suffix="$" />
        <x-calc.field name="overhead" label="Overhead (equipment, space)" value="10" step="any" suffix="%" />
        <x-calc.field name="paid_off" label="Paid days off a year" value="20" min="0" step="any" />
    </div>

    <x-calc.result label="Fully loaded cost per productive hour" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['wage' => 25, 'hours' => 40, 'taxes' => 9, 'benefits' => 650, 'overhead' => 10, 'paid_off' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'yearly' => ['label' => 'Cost a year'],
            'monthly' => ['label' => 'Cost a month'],
            'burden' => ['label' => 'Burden on wages'],
            'wage' => ['label' => 'Wages a year'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost = wages × (1 + taxes + overhead) + benefits</li>
            <li>per hour = cost ÷ (hours − time off)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
