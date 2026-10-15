@php
    $zoneGroups = [
        'Common' => ['UTC' => 'UTC'],
        'Americas' => ['America/New_York' => 'New York', 'America/Chicago' => 'Chicago', 'America/Denver' => 'Denver', 'America/Los_Angeles' => 'Los Angeles', 'America/Toronto' => 'Toronto', 'America/Mexico_City' => 'Mexico City', 'America/Sao_Paulo' => 'São Paulo'],
        'Europe and Africa' => ['Europe/London' => 'London', 'Europe/Paris' => 'Paris', 'Europe/Berlin' => 'Berlin', 'Europe/Moscow' => 'Moscow', 'Africa/Cairo' => 'Cairo', 'Africa/Lagos' => 'Lagos', 'Africa/Johannesburg' => 'Johannesburg'],
        'Asia and Pacific' => ['Asia/Dubai' => 'Dubai', 'Asia/Kolkata' => 'India', 'Asia/Singapore' => 'Singapore', 'Asia/Shanghai' => 'Shanghai', 'Asia/Tokyo' => 'Tokyo', 'Australia/Sydney' => 'Sydney', 'Pacific/Auckland' => 'Auckland'],
    ];
    $zoneNames = collect($zoneGroups)->collapse()->all();
    $defaultTargets = ['America/New_York', 'Europe/London', 'Asia/Kolkata', 'Asia/Tokyo', 'Australia/Sydney'];
@endphp

<x-calc.page
    title="Time Zones Converter - SolveKit"
    description="Professional time zone converter for global time calculations. Convert time between different time zones worldwide with DST support and real-time updates."
    lede="See what a time in one city is in other time zones, with daylight saving applied."
    about="The date and time you enter are read as local time in the source zone, turned into one moment in UTC, and shown as local time in each zone you tick. Offsets come from your browser's time-zone database, so daylight-saving changes and half-hour zones such as India are handled for that exact date."
    :calc="['engine' => 'time-zones', 'zoneNames' => $zoneNames]"
    :how-to="[
        ['name' => 'Enter the date and time', 'text' => 'Or press Use current time.'],
        ['name' => 'Pick the source zone', 'text' => 'The zone where that time applies.'],
        ['name' => 'Tick the zones to compare', 'text' => 'Each one shows its local time and the difference in hours.'],
    ]"
    :faqs="[
        ['question' => 'Does this handle daylight saving time?', 'answer' => 'Yes. Offsets are looked up for the date you enter, so summer and winter times are correct.'],
        ['question' => 'Why is India 5½ hours ahead of UTC?', 'answer' => 'India uses a single zone at UTC+05:30. A few zones, such as Nepal (UTC+05:45), are offset by quarter hours.'],
        ['question' => 'What is the best time for a meeting across zones?', 'answer' => 'Look for a time that falls between 9:00 and 17:00 in every ticked zone; with far-apart cities that may not exist.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3">
        <x-calc.field name="date" type="date" label="Date" value="2026-07-01" />
        <x-calc.field name="time" type="time" label="Time" value="09:00" />
    </div>

    <div class="flex flex-wrap items-end gap-3">
        <div class="min-w-0 flex-1">
            <x-calc.select name="zone" label="Source time zone" :options="$zoneGroups" selected="America/New_York" />
        </div>
        <button type="button" data-calc-now class="h-12 rounded-lg border border-slate-300 px-4 text-sm font-medium text-slate-700 hover:border-primary-500 hover:text-primary-700 focus-visible:outline-2 focus-visible:outline-primary-600">Use current time</button>
    </div>

    <fieldset class="min-w-0">
        <legend class="mb-1.5 text-[13px] font-semibold text-slate-700">Compare with</legend>
        <div class="grid grid-cols-2 gap-x-3 gap-y-1 sm:grid-cols-4">
            @foreach($zoneNames as $zone => $name)
                <label class="flex min-w-0 items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" name="calc-targets" value="{{ $zone }}" @checked(in_array($zone, $defaultTargets, true)) class="size-4 rounded border-slate-300 text-primary-600 focus-visible:outline-2 focus-visible:outline-primary-600">
                    <span class="truncate">{{ $name }}</span>
                </label>
            @endforeach
        </div>
    </fieldset>

    <x-calc.result label="New York" />

    <x-calc.options :decimals="false" />

    <x-slot:panel>
        <x-calc.quick-ref heading="In other zones" name="zones" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>UTC = local time − source offset</li>
            <li>target time = UTC + target offset</li>
            <li>offsets include daylight saving for the date</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
