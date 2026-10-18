<x-calc.page
    title="Add Time Calculator - SolveKit"
    description="Free add time calculator: add days, hours, minutes and seconds to a date and time, with the resulting weekday."
    lede="Add a length of time to a date and time."
    about="The days, hours, minutes and seconds are turned into seconds and added to the start, rolling over midnight, month ends and leap days on the Gregorian calendar. It is clock arithmetic: if a daylight-saving change falls in between, a phone clock would show one hour more or less."
    :calc="['engine' => 'ev-time', 'tool' => 'add_time', 'fields' => ['start', 'days', 'hours', 'minutes', 'seconds']]"
    :how-to="[
        ['name' => 'Enter the start', 'text' => 'A date and a time of day.'],
        ['name' => 'Enter the time to add', 'text' => 'Any mix of days, hours, minutes and seconds; values can exceed 24 or 60.'],
    ]"
    :faqs="[
        ['question' => 'What is 36 hours after 9 AM Monday?', 'answer' => '9 PM Tuesday.'],
        ['question' => 'Can I enter 90 minutes?', 'answer' => 'Yes, it is read as 1 hour 30 minutes.'],
        ['question' => 'What about daylight saving?', 'answer' => 'The result is clock time; a daylight-saving change in between moves a real clock by an hour.'],
    ]"
>
    <x-calc.field name="start" label="Start date and time" value="{{ now()->format('Y-m-d\TH:i') }}" type="datetime-local" />

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="days" label="Days" value="0" min="0" step="1" />
        <x-calc.field name="hours" label="Hours" value="36" min="0" step="1" />
        <x-calc.field name="minutes" label="Minutes" value="30" min="0" step="1" />
        <x-calc.field name="seconds" label="Seconds" value="0" min="0" step="1" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Monday 9 AM, 36 hours' => ['start' => '2026-03-02T09:00', 'days' => 0, 'hours' => 36, 'minutes' => 0, 'seconds' => 0],
        '1,000 hours' => ['start' => '2026-01-01T00:00', 'days' => 0, 'hours' => 1000, 'minutes' => 0, 'seconds' => 0],
        '10 days 2 h 45 min' => ['start' => '2026-12-25T18:30', 'days' => 10, 'hours' => 2, 'minutes' => 45, 'seconds' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'clock24' => ['label' => '24-hour clock'],
            'weekday' => ['label' => 'Weekday'],
            'total' => ['label' => 'Time added'],
            'note' => ['label' => 'Daylight saving'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>end = start + (days × 86,400 + hours × 3,600 + minutes × 60 + seconds) s</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
