<x-calc.page
    title="Week Calculator - SolveKit"
    description="Free week calculator: weeks between two dates, the ISO week number of a date, and the dates of any ISO week."
    lede="Count weeks between dates, or find a week number."
    about="Weeks between = days ÷ 7. ISO 8601 week numbers start on Monday, and week 1 is the week with the year's first Thursday, so a year has 52 or 53 weeks and early January can belong to the previous year's last week. The US often counts weeks from the Sunday on or before 1 January instead; both are shown."
    :calc="['engine' => 'ev-time', 'tool' => 'week', 'fields' => ['mode', 'start', 'end', 'date', 'week_year', 'week_number']]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => 'Weeks between, a week number, or a week\'s dates.'],
        ['name' => 'Enter the dates', 'text' => 'Or year and week.'],
    ]"
    :faqs="[
        ['question' => 'What week number is 18 October 2026?', 'answer' => 'ISO week 42.'],
        ['question' => 'When does week 1 of 2026 start?', 'answer' => 'Monday 29 December 2025.'],
        ['question' => 'How many weeks are in a year?', 'answer' => '52, or 53 in long ISO years such as 2026.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['between' => 'Weeks between', 'number' => 'Week number', 'from_week' => 'Dates of a week']" selected="between" />

    <div data-show-when="mode:between">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="start" label="Start date" value="{{ now()->toDateString() }}" type="date" />
            <x-calc.field name="end" label="End date" value="2027-06-30" type="date" />
        </div>
    </div>

    <div data-show-when="mode:number" hidden>
        <x-calc.field name="date" label="Date" value="{{ now()->toDateString() }}" type="date" />
    </div>

    <div data-show-when="mode:from_week" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="week_year" label="Year" value="2026" min="1" step="1" />
            <x-calc.field name="week_number" label="Week" value="1" min="1" max="53" step="1" />
        </div>
    </div>

    <x-calc.result label="Weeks" />

    <x-calc.options :examples="[
        'Until 30 June 2027' => ['mode' => 'between', 'start' => '2026-10-18', 'end' => '2027-06-30'],
        'Week of 18 Oct 2026' => ['mode' => 'number', 'date' => '2026-10-18'],
        'Week 1 of 2026' => ['mode' => 'from_week', 'week_year' => 2026, 'week_number' => 1],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:between">
            <x-calc.rows heading="Details" :rows="[
                'days' => ['label' => 'Days'],
                'months' => ['label' => 'Months'],
                'range' => ['label' => 'ISO weeks'],
            ]" />
        </div>
        <div data-show-when="mode:number" hidden>
            <x-calc.rows heading="Details" :rows="[
                'range' => ['label' => 'Week runs'],
                'weeks' => ['label' => 'Weeks in the year'],
                'us' => ['label' => 'US-style week'],
            ]" />
        </div>
        <div data-show-when="mode:from_week" hidden>
            <x-calc.rows heading="Details" :rows="[
                'range' => ['label' => 'Dates'],
                'weeks' => ['label' => 'Weeks in the year'],
            ]" />
        </div>
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weeks = days ÷ 7</li>
            <li>ISO week 1 contains the first Thursday</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
