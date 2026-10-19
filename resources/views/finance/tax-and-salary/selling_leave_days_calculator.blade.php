<x-calc.page
    title="Selling Leave Days Calculator - SolveKit"
    description="Free leave encashment calculator: the payout for unused vacation days sold back to your employer, from salary and working days."
    lede="Work out the value of leave days you sell back."
    about="Daily rate = yearly salary ÷ working days a year (about 260 for 5 days a week). Payout = daily rate × days sold, taxed as wages (supplemental withholding of 22% federal in the US). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'leave_sale', 'fields' => ['salary', 'days', 'working', 'tax']]"
    :how-to="[
        ['name' => 'Enter salary', 'text' => ''],
        ['name' => 'Enter days to sell', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are 5 days worth on $65,000?', 'answer' => '$1,250.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="salary" label="Yearly salary" value="65000" step="0.01" suffix="$" />
        <x-calc.field name="days" label="Leave days to sell" value="5" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="working" label="Working days a year" value="260" min="1" step="1" />
        <x-calc.field name="tax" label="Tax rate on the payout" value="22" step="any" suffix="%" />
    </div>

    <x-calc.result label="Payout for the leave days" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['salary' => 65000, 'days' => 5, 'working' => 260, 'tax' => 22],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'daily' => ['label' => 'Daily rate'],
            'tax' => ['label' => 'After tax'],
            'hourly' => ['label' => 'Hourly rate'],
            'basis' => ['label' => 'Basis'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>payout = salary ÷ working days × days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
