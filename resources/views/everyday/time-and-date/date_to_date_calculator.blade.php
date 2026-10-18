<x-calc.page
    title="Date to Date Calculator - SolveKit"
    description="Free date to date calculator: days between two dates, also in weeks, months, years, hours, minutes and seconds."
    lede="Find how long it is from one date to another."
    about="The number of days is the difference between the dates' day numbers, so leap days are counted. Tick include end date to count both the first and last day (useful for trips and rentals). Months and years are calendar months and years, with the days left over."
    :calc="['engine' => 'ev-time', 'tool' => 'date_to_date', 'fields' => ['start', 'end', 'include_end']]"
    :how-to="[
        ['name' => 'Enter both dates', 'text' => 'In any order.'],
        ['name' => 'Include the end date', 'text' => 'If both days should count.'],
    ]"
    :faqs="[
        ['question' => 'How many days from 1 January to 25 December 2026?', 'answer' => '358 days (359 counting both days).'],
        ['question' => 'Is the end date counted?', 'answer' => 'Not unless you tick it, as in most date calculators.'],
        ['question' => 'Are leap years counted?', 'answer' => 'Yes.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Start date" value="2026-01-01" type="date" />
        <x-calc.field name="end" label="End date" value="2026-12-25" type="date" />
    </div>

    <x-calc.checkbox name="include_end" label="Include the end date (+1 day)" :checked="false" />

    <x-calc.result label="Duration" />

    <x-calc.options :decimals="false" :examples="[
        'To Christmas 2026' => ['start' => '2026-01-01', 'end' => '2026-12-25', 'include_end' => false],
        'A trip, both days' => ['start' => '2026-07-10', 'end' => '2026-07-24', 'include_end' => true],
        'Across a leap year' => ['start' => '2027-06-01', 'end' => '2028-06-01', 'include_end' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'weeks' => ['label' => 'Weeks'],
            'months' => ['label' => 'Months'],
            'years' => ['label' => 'Years'],
            'hours' => ['label' => 'Hours'],
            'minutes' => ['label' => 'Minutes'],
            'seconds' => ['label' => 'Seconds'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>days = day number(end) − day number(start) (+1 to include the end)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
