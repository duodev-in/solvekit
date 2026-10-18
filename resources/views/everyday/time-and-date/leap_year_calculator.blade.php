<x-calc.page
    title="Leap Year Calculator - SolveKit"
    description="Free leap year calculator: whether a year is a leap year by the Gregorian rule, the previous and next leap years, and how many fall in a range."
    lede="Check whether a year is a leap year."
    about="In the Gregorian calendar a year is a leap year if it divides by 4, except century years, which must divide by 400. So 2000 was a leap year and 1900 and 2100 are not. This keeps the calendar year at 365.2425 days, close to the 365.2422-day tropical year."
    :calc="['engine' => 'ev-time', 'tool' => 'leap_year', 'fields' => ['year', 'from', 'to']]"
    :how-to="[
        ['name' => 'Enter a year', 'text' => 'And a range to count leap years.'],
    ]"
    :faqs="[
        ['question' => 'Is 2100 a leap year?', 'answer' => 'No: it divides by 100 but not by 400.'],
        ['question' => 'Was 2000 a leap year?', 'answer' => 'Yes, it divides by 400.'],
        ['question' => 'How many leap years from 2000 to 2100?', 'answer' => '25 (2000 counts, 2100 does not).'],
    ]"
>
    <x-calc.field name="year" label="Year" value="2028" min="1" step="1" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="from" label="Count leap years from (optional)" value="2000" min="1" step="1" />
        <x-calc.field name="to" label="To" value="2100" min="1" step="1" />
    </div>

    <x-calc.result label="Is it a leap year?" />

    <x-calc.options :decimals="false" :examples="[
        '2028' => ['year' => 2028, 'from' => 2000, 'to' => 2100],
        '2100' => ['year' => 2100, 'from' => 1901, 'to' => 2000],
        '1900' => ['year' => 1900, 'from' => 1800, 'to' => 1900],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'days' => ['label' => 'Days in the year'],
            'previous' => ['label' => 'Previous leap year'],
            'next' => ['label' => 'Next leap year'],
            'range' => ['label' => 'In the range'],
        ]" />
        <x-calc.quick-ref heading="Leap years from this year" name="upcoming" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>leap = (y mod 4 = 0 and y mod 100 ≠ 0) or y mod 400 = 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
