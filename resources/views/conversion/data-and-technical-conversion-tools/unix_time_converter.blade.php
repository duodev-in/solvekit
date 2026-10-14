@php
    $zones = [
        'Common' => ['UTC' => 'UTC'],
        'Americas' => ['America/New_York' => 'New York', 'America/Chicago' => 'Chicago', 'America/Denver' => 'Denver', 'America/Los_Angeles' => 'Los Angeles', 'America/Anchorage' => 'Anchorage', 'Pacific/Honolulu' => 'Honolulu', 'America/Toronto' => 'Toronto', 'America/Mexico_City' => 'Mexico City', 'America/Sao_Paulo' => 'São Paulo'],
        'Europe and Africa' => ['Europe/London' => 'London', 'Europe/Paris' => 'Paris', 'Europe/Berlin' => 'Berlin', 'Europe/Madrid' => 'Madrid', 'Europe/Istanbul' => 'Istanbul', 'Europe/Moscow' => 'Moscow', 'Africa/Cairo' => 'Cairo', 'Africa/Lagos' => 'Lagos', 'Africa/Johannesburg' => 'Johannesburg'],
        'Asia and Pacific' => ['Asia/Dubai' => 'Dubai', 'Asia/Karachi' => 'Karachi', 'Asia/Kolkata' => 'India (Kolkata)', 'Asia/Dhaka' => 'Dhaka', 'Asia/Bangkok' => 'Bangkok', 'Asia/Singapore' => 'Singapore', 'Asia/Shanghai' => 'Shanghai', 'Asia/Tokyo' => 'Tokyo', 'Asia/Seoul' => 'Seoul', 'Australia/Perth' => 'Perth', 'Australia/Sydney' => 'Sydney', 'Pacific/Auckland' => 'Auckland'],
    ];
@endphp

<x-calc.page
    title="Unix Time Converter - SolveKit"
    description="Professional Unix timestamp converter for developers and system administrators. Convert between Unix timestamps and human-readable dates with timezone support and detailed analysis."
    lede="Convert Unix timestamps to dates in any time zone, or dates to timestamps."
    about="A Unix timestamp counts seconds since 1 January 1970 00:00:00 UTC, ignoring leap seconds. It is the same everywhere; the time zone only changes how the date is shown. Converting a date to a timestamp reads the date and time as local time in the zone you choose, including daylight-saving rules."
    :calc="['engine' => 'unix-time']"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Timestamp to date, or date to timestamp.'],
        ['name' => 'Pick the time zone', 'text' => 'Dates are shown, or read, as local time in this zone.'],
        ['name' => 'Enter the value', 'text' => 'Or press Use current time.'],
    ]"
    :faqs="[
        ['question' => 'What is a Unix timestamp?', 'answer' => 'The number of seconds since 1970-01-01 00:00:00 UTC. It is used by most operating systems, databases and APIs.'],
        ['question' => 'Seconds or milliseconds?', 'answer' => 'A 10-digit value is usually seconds; a 13-digit value is milliseconds, as used by JavaScript.'],
        ['question' => 'What is the year 2038 problem?', 'answer' => 'Signed 32-bit timestamps overflow on 19 January 2038 at 03:14:07 UTC. Systems using 64-bit time are not affected.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Direction" :options="['unix' => 'Timestamp → Date', 'date' => 'Date → Timestamp']" selected="unix" />

    <div data-show-when="mode:unix" class="grid grid-cols-1 gap-3 sm:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)]">
        <x-calc.field name="timestamp" label="Unix timestamp" value="1767225600" placeholder="e.g. 1767225600" />
        <x-calc.segmented name="precision" legend="Unit" :options="['s' => 'Seconds', 'ms' => 'Milliseconds']" selected="s" />
    </div>

    <div data-show-when="mode:date" hidden class="grid grid-cols-2 gap-3">
        <x-calc.field name="date" type="date" label="Date" value="2026-01-01" />
        <x-calc.field name="time" type="time" label="Time" value="00:00:00" step="1" />
    </div>

    <div class="flex flex-wrap items-end gap-3">
        <div class="min-w-0 flex-1">
            <x-calc.select name="zone" label="Time zone" :options="$zones" selected="UTC" />
        </div>
        <button type="button" data-calc-now class="h-12 rounded-lg border border-slate-300 px-4 text-sm font-medium text-slate-700 hover:border-primary-500 hover:text-primary-700 focus-visible:outline-2 focus-visible:outline-primary-600">Use current time</button>
    </div>

    <x-calc.result label="Date and time" />

    <x-calc.options :decimals="false" :examples="[
        'Unix epoch' => ['mode' => 'unix', 'timestamp' => 0, 'precision' => 's'],
        '1 billion seconds' => ['mode' => 'unix', 'timestamp' => 1000000000, 'precision' => 's'],
        'Y2038 overflow' => ['mode' => 'unix', 'timestamp' => 2147483647, 'precision' => 's'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Formats" :rows="[
            'seconds' => ['label' => 'Unix seconds'],
            'milliseconds' => ['label' => 'Unix milliseconds'],
            'iso' => ['label' => 'ISO 8601 (UTC)'],
            'rfc' => ['label' => 'RFC 7231 (UTC)'],
            'zoned' => ['label' => 'In selected zone'],
            'offset' => ['label' => 'UTC offset'],
            'weekday' => ['label' => 'Day of week'],
            'week' => ['label' => 'Week number'],
            'days' => ['label' => 'Days since epoch'],
            'relative' => ['label' => 'Relative to now'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>date = 1970-01-01T00:00:00Z + timestamp seconds</li>
            <li>milliseconds = seconds × 1,000</li>
            <li>JavaScript: new Date(seconds * 1000)</li>
            <li>Python: datetime.fromtimestamp(seconds, tz=UTC)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
