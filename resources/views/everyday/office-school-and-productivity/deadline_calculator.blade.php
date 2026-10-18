<x-calc.page
    title="Deadline Calculator - SolveKit"
    description="Free deadline calculator: the due date a number of working days after a start date, skipping weekends and holidays."
    lede="Find a deadline in working days."
    about="Counting starts the day after the start date: each weekday that is not a holiday counts as one working day, and the deadline is the day the count is reached. US federal holidays use their observed dates (5 U.S.C. 6103); add your own dates for other calendars."
    :calc="['engine' => 'ev-office', 'tool' => 'deadline', 'fields' => ['start', 'days', 'weekend', 'holidays', 'holiday_list']]"
    :how-to="[
        ['name' => 'Enter the start date', 'text' => 'Counting begins the next day.'],
        ['name' => 'Enter working days', 'text' => 'And the weekend and holidays.'],
    ]"
    :faqs="[
        ['question' => 'What is 10 working days from Friday 18 December 2026?', 'answer' => 'Tuesday, January 5, 2027, skipping weekends, Christmas Day and New Year\'s Day.'],
        ['question' => 'Is the start day counted?', 'answer' => 'No, the first working day is the next one.'],
        ['question' => 'What about non-US holidays?', 'answer' => 'Choose My own list and enter them.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Start date" value="{{ now()->toDateString() }}" type="date" />
        <x-calc.field name="days" label="Working days" value="10" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="weekend" label="Weekend" :options="['sat_sun' => 'Saturday and Sunday', 'fri_sat' => 'Friday and Saturday', 'sun' => 'Sunday only', 'none' => 'No weekend']" selected="sat_sun" />
        <x-calc.select name="holidays" label="Holidays" :options="['none' => 'None', 'us' => 'US federal holidays', 'custom' => 'My own list']" selected="us" />
    </div>

    <div data-show-when="holidays:custom" hidden>
        <x-calc.textarea name="holiday_list" label="Your holidays (one date per line, YYYY-MM-DD)" value="2026-12-24" rows="3" />
    </div>

    <x-calc.result label="Deadline" />

    <x-calc.options :decimals="false" :examples="[
        '10 days from 18 Dec 2026' => ['start' => '2026-12-18', 'days' => 10, 'weekend' => 'sat_sun', 'holidays' => 'us', 'holiday_list' => ''],
        '30 days, no holidays' => ['start' => '2026-10-19', 'days' => 30, 'weekend' => 'sat_sun', 'holidays' => 'none', 'holiday_list' => ''],
        'Fri–Sat weekend' => ['start' => '2026-03-01', 'days' => 15, 'weekend' => 'fri_sat', 'holidays' => 'custom', 'holiday_list' => '2026-03-20'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calendar' => ['label' => 'Calendar days'],
            'weekday' => ['label' => 'Weekday'],
            'skipped' => ['label' => 'Days skipped'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>deadline = start + n working days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
