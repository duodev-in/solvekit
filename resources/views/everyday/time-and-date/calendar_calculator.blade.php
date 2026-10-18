<x-calc.page
    title="Calendar Calculator - SolveKit"
    description="Free calendar calculator: a month calendar for any year from 1 to 9999 with ISO week numbers, weekday counts and US federal holidays."
    lede="Show the calendar of any month, with week numbers."
    about="The calendar is the proleptic Gregorian calendar, extended backwards before 1582 when it was introduced. Week numbers follow ISO 8601: weeks start on Monday and week 1 is the week with the year's first Thursday. Dates marked * are US federal holidays (not moved to the observed day)."
    :calc="['engine' => 'ev-time', 'tool' => 'calendar', 'fields' => ['month', 'year', 'start']]"
    :how-to="[
        ['name' => 'Pick a month and year', 'text' => 'Any year from 1 to 9999.'],
        ['name' => 'Choose the first weekday', 'text' => 'Monday (ISO) or Sunday.'],
    ]"
    :faqs="[
        ['question' => 'What week number is it?', 'answer' => 'ISO weeks start on Monday; week 1 holds the first Thursday of the year.'],
        ['question' => 'How many weeks are in a year?', 'answer' => '52, or 53 ISO weeks in years such as 2026 and 2032.'],
        ['question' => 'Why are some weeks numbered from the year before?', 'answer' => 'Days in early January can belong to the last ISO week of the previous year.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="month" label="Month" :options="['1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December']" selected="10" />
        <x-calc.field name="year" label="Year" value="2026" min="1" max="9999" step="1" />
        <x-calc.segmented name="start" legend="Week starts" :options="['monday' => 'Monday', 'sunday' => 'Sunday']" selected="monday" />
    </div>

    <x-calc.result label="Calendar" />

    <x-calc.options :decimals="false" :examples="[
        'October 2026' => ['month' => '10', 'year' => 2026, 'start' => 'monday'],
        'February 2028, Sunday first' => ['month' => '2', 'year' => 2028, 'start' => 'sunday'],
        'July 1776' => ['month' => '7', 'year' => 1776, 'start' => 'sunday'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'weekdays' => ['label' => 'Weekdays'],
            'weeks' => ['label' => 'Week numbers'],
            'year' => ['label' => 'The year'],
            'quarter' => ['label' => 'Quarter'],
        ]" />
        <x-calc.grid heading="Month" name="month" />
        <x-calc.quick-ref heading="US federal holidays" name="holidays" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ISO week = week holding that week's Thursday, counted from the first Thursday</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
