<x-calc.page
    title="Age Calculator - SolveKit"
    description="Free age calculator: exact age in years, months and days from a date of birth, with total months, weeks, days and hours and the next birthday."
    lede="Work out your exact age, or anyone's age on any date."
    about="Age is counted on the calendar: whole years, then whole months, then the days left, so someone born on 15 May is a year older each 15 May. Someone born on 29 February gains a year on 28 February in common years here (legal rules vary by country). Total days are exact, including leap days."
    :calc="['engine' => 'ev-time', 'tool' => 'age', 'fields' => ['birth', 'on']]"
    :how-to="[
        ['name' => 'Enter the date of birth', 'text' => 'Day, month and year.'],
        ['name' => 'Choose the date', 'text' => 'Today by default, or any other date.'],
    ]"
    :faqs="[
        ['question' => 'How is age calculated?', 'answer' => 'Count whole years, then whole months, then the remaining days.'],
        ['question' => 'How old is someone born 15 May 1990 on 18 October 2026?', 'answer' => '36 years, 5 months and 3 days.'],
        ['question' => 'What about leap-day birthdays?', 'answer' => 'Here a 29 February birthday falls on 28 February in common years.'],
    ]"
>
    <x-calc.field name="birth" label="Date of birth" value="1990-05-15" type="date" />

    <x-calc.field name="on" label="Age on" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.result label="Age" />

    <x-calc.options :decimals="false" :examples="[
        'Born 15 May 1990' => ['birth' => '1990-05-15', 'on' => '2026-10-18'],
        'Leap-day birthday' => ['birth' => '2000-02-29', 'on' => '2026-03-01'],
        'Age on a past date' => ['birth' => '1969-07-20', 'on' => '2000-01-01'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'months' => ['label' => 'In months'],
            'weeks' => ['label' => 'In weeks'],
            'days' => ['label' => 'In days'],
            'hours' => ['label' => 'In hours'],
            'next' => ['label' => 'Next birthday'],
            'born' => ['label' => 'Born on'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>age = whole years, whole months, then days</li>
            <li>days = day number(on) − day number(birth)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
