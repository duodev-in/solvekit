<x-calc.page
    title="Time Difference Calculator - SolveKit"
    description="Free time difference calculator: the time between two date-times in different time zones, with daylight saving applied, in hours and minutes."
    lede="Find the time between two moments, even in different time zones."
    about="Each date and time is read as local time in its own zone and turned into one instant using your browser's time-zone database, so daylight-saving changes and half-hour zones are handled for those exact dates. The difference is then the true elapsed time, for example a flight's duration from its local departure and arrival times."
    :calc="['engine' => 'ev-time', 'tool' => 'time_difference', 'fields' => ['start', 'start_zone', 'end', 'end_zone'], 'data' => ['zones' => collect(config('everyday_data.zones'))->collapse()->all()]]"
    :how-to="[
        ['name' => 'Enter the start', 'text' => 'Its local date, time and zone.'],
        ['name' => 'Enter the end', 'text' => 'Its local date, time and zone.'],
    ]"
    :faqs="[
        ['question' => 'How long is a flight leaving New York 10:30 PM and landing in London 11:15 AM?', 'answer' => '7 h 45 min in December.'],
        ['question' => 'What is the time difference between New York and London?', 'answer' => 'Usually 5 hours; 4 for a few weeks in March and October/November when daylight saving dates differ.'],
        ['question' => 'Does it handle India\'s half hour?', 'answer' => 'Yes, UTC+05:30 and Nepal\'s +05:45.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Start" value="2026-12-18T22:30" type="datetime-local" />
        <x-calc.select name="start_zone" label="Start time zone" :options="config('everyday_data.zones')" selected="America/New_York" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="end" label="End" value="2026-12-19T11:15" type="datetime-local" />
        <x-calc.select name="end_zone" label="End time zone" :options="config('everyday_data.zones')" selected="Europe/London" />
    </div>

    <x-calc.result label="Time between" />

    <x-calc.options :examples="[
        'NYC → London flight' => ['start' => '2026-12-18T22:30', 'start_zone' => 'America/New_York', 'end' => '2026-12-19T11:15', 'end_zone' => 'Europe/London'],
        'Sydney → Los Angeles' => ['start' => '2026-07-10T21:40', 'start_zone' => 'Australia/Sydney', 'end' => '2026-07-10T18:20', 'end_zone' => 'America/Los_Angeles'],
        'Same zone, across DST' => ['start' => '2026-03-07T12:00', 'start_zone' => 'America/Chicago', 'end' => '2026-03-08T12:00', 'end_zone' => 'America/Chicago'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hm' => ['label' => 'Hours and minutes'],
            'minutes' => ['label' => 'Minutes'],
            'offsets' => ['label' => 'UTC offsets'],
            'there' => ['label' => 'Start in the end zone'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>elapsed = (end local − end offset) − (start local − start offset)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
