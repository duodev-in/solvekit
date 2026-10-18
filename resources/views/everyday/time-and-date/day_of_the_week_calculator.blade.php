<x-calc.page
    title="Day of the Week Calculator - SolveKit"
    description="Free day of the week calculator: the weekday of any date in the Gregorian or Julian calendar, with ISO week and Conway's Doomsday."
    lede="Find the day of the week for any date, past or future."
    about="The weekday follows from counting days on the calendar: 1 January 1970 was a Thursday. Choose the Julian calendar for dates before a country switched (October 1582 in Catholic Europe, September 1752 in Britain and its colonies); the result also shows the Gregorian date. Conway's Doomsday is the weekday shared by 4/4, 6/6, 8/8, 10/10 and 12/12 in a year."
    :calc="['engine' => 'ev-time', 'tool' => 'day_of_week', 'fields' => ['date', 'calendar']]"
    :how-to="[
        ['name' => 'Enter a date', 'text' => 'Any year.'],
        ['name' => 'Pick the calendar', 'text' => 'Julian for old-style historical dates.'],
    ]"
    :faqs="[
        ['question' => 'What day was the Moon landing?', 'answer' => 'Sunday, 20 July 1969.'],
        ['question' => 'What day was 4 July 1776?', 'answer' => 'A Thursday.'],
        ['question' => 'Why do historical dates differ?', 'answer' => 'Countries moved from the Julian to the Gregorian calendar at different times, skipping 10–13 days.'],
    ]"
>
    <x-calc.field name="date" label="Date" value="1969-07-20" type="date" />

    <x-calc.segmented name="calendar" legend="Calendar" :options="['gregorian' => 'Gregorian', 'julian' => 'Julian (old style)']" selected="gregorian" />

    <x-calc.result label="Day of the week" />

    <x-calc.options :decimals="false" :examples="[
        'Moon landing' => ['date' => '1969-07-20', 'calendar' => 'gregorian'],
        '4 July 1776' => ['date' => '1776-07-04', 'calendar' => 'gregorian'],
        'Shakespeare\'s death (Julian)' => ['date' => '1616-04-23', 'calendar' => 'julian'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'iso' => ['label' => 'ISO weekday'],
            'week' => ['label' => 'ISO week'],
            'doomsday' => ['label' => 'Doomsday'],
            'gregorian' => ['label' => 'Calendar'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weekday = (day number + 4) mod 7, with day 0 = 1 January 1970 (Thursday)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
