<x-calc.page
    title="Monthly Income Hourly Calculator - SolveKit"
    description="Free Monthly Income Hourly Calculator: turn an hourly wage into monthly income, with hourly, daily, weekly, biweekly, semi-monthly, monthly and yearly figures."
    lede="Turn an hourly wage into monthly income."
    about="Pay converts through the yearly total: hourly × hours a week × weeks a year, daily × days a week × weeks, weekly × 52, biweekly × 26, semi-monthly × 24, monthly × 12. A full-time year is 40 × 52 = 2,080 hours. Unpaid time off lowers the weeks worked. These are gross figures before tax. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'pay', 'fields' => ['amount', 'period', 'hours', 'days', 'weeks'], 'target' => 'month']"
    :how-to="[
        ['name' => 'Enter your pay', 'text' => 'And how often it is paid.'],
        ['name' => 'Adjust hours and weeks', 'text' => 'For part-time work or unpaid leave.'],
    ]"
    :faqs="[
        ['question' => 'What is $28 an hour as monthly pay?', 'answer' => '$4,853.33 at 40 hours a week, 52 weeks.'],
        ['question' => 'How many working hours are in a year?', 'answer' => '2,080 at 40 hours a week for 52 weeks; 1,960 with two weeks unpaid.'],
        ['question' => 'Is this before tax?', 'answer' => 'Yes: these are gross figures. Use the Gross to Net Calculator for take-home pay.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Pay" value="28" step="0.01" suffix="$" />
        <x-calc.select name="period" label="Paid" :options="['hour' => 'Hourly', 'day' => 'Daily', 'week' => 'Weekly', 'biweek' => 'Biweekly', 'semimonth' => 'Semi-monthly', 'month' => 'Monthly', 'quarter' => 'Quarterly', 'year' => 'Yearly']" selected="hour" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hours" label="Hours a week" value="40" min="1" step="any" />
        <x-calc.field name="days" label="Days a week" value="5" min="1" max="7" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weeks" label="Weeks worked a year" value="52" min="1" max="52" step="any" />
    </div>

    <x-calc.result label="Monthly pay" />

    <x-calc.options :decimals="false" :examples="[
        'Default' => ['amount' => 28, 'period' => 'hour', 'hours' => 40, 'days' => 5, 'weeks' => 52],
        'Part-time' => ['amount' => 28, 'period' => 'hour', 'hours' => 25, 'days' => 5, 'weeks' => 52],
        'Two weeks unpaid' => ['amount' => 28, 'period' => 'hour', 'hours' => 40, 'days' => 5, 'weeks' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hour' => ['label' => 'Hourly pay'],
            'day' => ['label' => 'Daily pay'],
            'week' => ['label' => 'Weekly pay'],
            'biweek' => ['label' => 'Biweekly pay'],
            'semimonth' => ['label' => 'Semi-monthly pay'],
            'month' => ['label' => 'Monthly pay'],
            'quarter' => ['label' => 'Quarterly pay'],
            'year' => ['label' => 'Yearly pay'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>yearly = pay × periods a year</li>
            <li>hourly = yearly ÷ (hours × weeks)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
