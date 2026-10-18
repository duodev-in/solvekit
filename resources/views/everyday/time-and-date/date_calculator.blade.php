<x-calc.page
    title="Date Calculator - SolveKit"
    description="Free date calculator: add or subtract years, months, weeks and days to a date, with the weekday, day of the year and ISO week of the result."
    lede="Add or subtract years, months, weeks and days to find a date."
    about="Years and months are added first on the calendar, then weeks and days. If the month you land in is shorter (31 January + 1 month), the date moves back to that month's last day (28 or 29 February), as most date libraries do. Everything follows the Gregorian calendar, including leap years."
    :calc="['engine' => 'ev-time', 'tool' => 'date_calc', 'fields' => ['start', 'operation', 'years', 'months', 'weeks', 'days']]"
    :how-to="[
        ['name' => 'Enter a start date', 'text' => 'Today by default.'],
        ['name' => 'Add or subtract', 'text' => 'Any mix of years, months, weeks and days.'],
    ]"
    :faqs="[
        ['question' => 'What date is 90 days from 18 October 2026?', 'answer' => 'Saturday, January 16, 2027.'],
        ['question' => 'What is 31 January plus one month?', 'answer' => '28 February (29 in a leap year): the last day of the shorter month.'],
        ['question' => 'Are weekends counted?', 'answer' => 'Yes, these are calendar days; use the Business Days calculator to skip them.'],
    ]"
>
    <x-calc.field name="start" label="Start date" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.segmented name="operation" legend="Operation" :options="['add' => 'Add', 'subtract' => 'Subtract']" selected="add" />

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="years" label="Years" value="0" min="0" step="1" />
        <x-calc.field name="months" label="Months" value="0" min="0" step="1" />
        <x-calc.field name="weeks" label="Weeks" value="0" min="0" step="1" />
        <x-calc.field name="days" label="Days" value="90" min="0" step="1" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        '90 days from 18 Oct 2026' => ['start' => '2026-10-18', 'operation' => 'add', 'years' => 0, 'months' => 0, 'weeks' => 0, 'days' => 90],
        '31 Jan + 1 month' => ['start' => '2027-01-31', 'operation' => 'add', 'years' => 0, 'months' => 1, 'weeks' => 0, 'days' => 0],
        '18 years before' => ['start' => '2026-10-18', 'operation' => 'subtract', 'years' => 18, 'months' => 0, 'weeks' => 0, 'days' => 0],
        '40 weeks on' => ['start' => '2026-02-01', 'operation' => 'add', 'years' => 0, 'months' => 0, 'weeks' => 40, 'days' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'iso' => ['label' => 'ISO date'],
            'day' => ['label' => 'Day of the year'],
            'week' => ['label' => 'ISO week'],
            'apart' => ['label' => 'Days apart'],
            'clamp' => ['label' => 'Month ends'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>date = start ± (years × 12 + months) months, then ± (weeks × 7 + days) days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
