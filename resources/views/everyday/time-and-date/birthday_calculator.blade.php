<x-calc.page
    title="Birthday Calculator - SolveKit"
    description="Free birthday calculator: the weekday you were born, days until your next birthday, and the weekday of your coming birthdays."
    lede="Find the day of the week you were born and count down to your next birthday."
    about="The weekday comes from the date's day number on the Gregorian calendar. Your next birthday is the next time your day and month come round; a 29 February birthday is shown on 28 February in common years."
    :calc="['engine' => 'ev-time', 'tool' => 'birthday', 'fields' => ['birth', 'on']]"
    :how-to="[
        ['name' => 'Enter your birth date', 'text' => 'See the weekday and the countdown.'],
    ]"
    :faqs="[
        ['question' => 'What day of the week was I born?', 'answer' => 'Enter your birth date; 24 August 1995 was a Thursday.'],
        ['question' => 'How many days until my birthday?', 'answer' => 'Shown as the countdown, counting from today.'],
        ['question' => 'Why does my birthday weekday move?', 'answer' => 'A common year is 52 weeks and 1 day, so it moves one weekday, or two after a leap day.'],
    ]"
>
    <x-calc.field name="birth" label="Date of birth" value="1995-08-24" type="date" />

    <x-calc.field name="on" label="Today" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.result label="You were born on a" />

    <x-calc.options :decimals="false" :examples="[
        '24 August 1995' => ['birth' => '1995-08-24', 'on' => '2026-10-18'],
        'New Year\'s Day 2000' => ['birth' => '2000-01-01', 'on' => '2026-10-18'],
        'Leap day 1996' => ['birth' => '1996-02-29', 'on' => '2026-10-18'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'next' => ['label' => 'Next birthday'],
            'left' => ['label' => 'Days to go'],
            'lived' => ['label' => 'Days lived'],
            'leap' => ['label' => 'Birthday each year'],
        ]" />
        <x-calc.quick-ref heading="Coming birthdays" name="upcoming" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weekday = (day number + 4) mod 7, Sunday = 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
