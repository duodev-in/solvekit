<x-calc.page
    title="Day of the Year Calculator - SolveKit"
    description="Free day of the year calculator: the day number (1–366) of any date, days left in the year, and the date of any day number."
    lede="Find which day of the year a date is, or the date of a day number."
    about="The day of the year counts from 1 on 1 January to 365, or 366 in a leap year. Written with the year it is the ISO 8601 ordinal date (2026-291). Some industries call it the Julian date, which astronomers use for a different count."
    :calc="['engine' => 'ev-time', 'tool' => 'day_of_year', 'fields' => ['mode', 'date', 'year', 'day']]"
    :how-to="[
        ['name' => 'Pick what to find', 'text' => 'A day number or a date.'],
        ['name' => 'Enter the date or number', 'text' => 'With the year.'],
    ]"
    :faqs="[
        ['question' => 'What day of the year is 18 October 2026?', 'answer' => 'Day 291, with 74 days left.'],
        ['question' => 'What is day 256?', 'answer' => 'Programmers\' Day: 13 September in common years, 12 September in leap years.'],
        ['question' => 'Is this the Julian date?', 'answer' => 'Often called that in industry; astronomers\' Julian Day is a different count.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['date' => 'Day number of a date', 'number' => 'Date of a day number']" selected="date" />

    <div data-show-when="mode:date">
        <x-calc.field name="date" label="Date" value="{{ now()->toDateString() }}" type="date" />
    </div>

    <div data-show-when="mode:number" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="year" label="Year" value="2026" min="1" step="1" />
            <x-calc.field name="day" label="Day number" value="256" min="1" max="366" step="1" />
        </div>
    </div>

    <x-calc.result label="Day of the year" />

    <x-calc.options :decimals="false" :examples="[
        '18 October 2026' => ['mode' => 'date', 'date' => '2026-10-18'],
        'Day 256 of 2026' => ['mode' => 'number', 'year' => 2026, 'day' => 256],
        'Last day of 2028' => ['mode' => 'date', 'date' => '2028-12-31'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'left' => ['label' => 'Days left'],
            'percent' => ['label' => 'Year done'],
            'week' => ['label' => 'ISO week'],
            'ordinal' => ['label' => 'Ordinal date'],
            'quarter' => ['label' => 'Quarter'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>day = date − 1 January + 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
