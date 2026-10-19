<x-calc.page
    title="Prorated Salary Calculator - SolveKit"
    description="Free prorated salary calculator: pay for part of a month (starting or leaving mid-month) from a yearly salary and days worked."
    lede="Work out pay for a partial month."
    about="Prorated pay = monthly salary × days worked ÷ days in the period. Employers count calendar days or working days in the month; use whichever your employer uses. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'prorate', 'fields' => ['salary', 'worked', 'total']]"
    :how-to="[
        ['name' => 'Enter salary', 'text' => ''],
        ['name' => 'Enter days worked and days in the period', 'text' => 'Working days or calendar days.'],
    ]"
    :faqs="[
        ['question' => 'What is pay for 12 of 22 working days on $72,000?', 'answer' => '$3,272.73.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="salary" label="Yearly salary" value="72000" step="0.01" suffix="$" />
        <x-calc.field name="worked" label="Days worked" value="12" min="0" step="any" suffix="days" />
        <x-calc.field name="total" label="Days in the period" value="22" min="1" step="any" suffix="days" />
    </div>

    <x-calc.result label="Prorated pay" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['salary' => 72000, 'worked' => 12, 'total' => 22],
        'Calendar days' => ['salary' => 72000, 'worked' => 10, 'total' => 31],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'period' => ['label' => 'Full month'],
            'daily' => ['label' => 'Daily rate'],
            'share' => ['label' => 'Share of the month'],
            'yearly' => ['label' => 'Yearly salary'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pay = salary ÷ 12 × worked ÷ days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
