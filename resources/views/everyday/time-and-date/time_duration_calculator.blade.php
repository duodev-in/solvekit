<x-calc.page
    title="Time Duration Calculator - SolveKit"
    description="Free time duration calculator: the duration between two dates and times in days, hours and minutes, and in years, months and days."
    lede="Find how long it is between two dates and times."
    about="Duration = end − start on the clock, broken into days, hours and minutes, and also into calendar years, months and days plus the hours left. Both times are in the same time zone; use the Time Difference calculator when they are not."
    :calc="['engine' => 'ev-time', 'tool' => 'time_duration', 'fields' => ['start', 'end']]"
    :how-to="[
        ['name' => 'Enter the start', 'text' => 'Date and time.'],
        ['name' => 'Enter the end', 'text' => 'Date and time.'],
    ]"
    :faqs="[
        ['question' => 'How long from 8:30 AM 18 October to 6 PM 24 December?', 'answer' => '67 days 9 h 30 min.'],
        ['question' => 'Does it count leap days?', 'answer' => 'Yes.'],
        ['question' => 'Can the end be earlier?', 'answer' => 'Yes; the duration is shown with a note.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Start" value="2026-10-18T08:30" type="datetime-local" />
        <x-calc.field name="end" label="End" value="2026-12-24T18:00" type="datetime-local" />
    </div>

    <x-calc.result label="Duration" />

    <x-calc.options :examples="[
        'To Christmas Eve' => ['start' => '2026-10-18T08:30', 'end' => '2026-12-24T18:00'],
        'A work week' => ['start' => '2026-11-02T09:00', 'end' => '2026-11-06T17:30'],
        'Across a leap day' => ['start' => '2028-02-28T12:00', 'end' => '2028-03-01T12:00'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hours' => ['label' => 'Hours'],
            'minutes' => ['label' => 'Minutes'],
            'seconds' => ['label' => 'Seconds'],
            'weeks' => ['label' => 'Weeks'],
            'note' => ['label' => 'Daylight saving'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>duration = end − start</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
