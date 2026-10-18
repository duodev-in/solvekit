<x-calc.page
    title="Moon Phase Calculator - SolveKit"
    description="Free moon phase calculator: the Moon's phase, illumination and age for any date from 1900 to 2100, with the next new, first quarter, full and last quarter moons in your time zone."
    lede="See the phase of the Moon on any date, and when the next full moon is."
    about="New moon, quarter and full moon times use Jean Meeus's Astronomical Algorithms (chapter 49), accurate to about a minute. Illumination uses the Moon's phase angle (chapter 48). The phase name follows the illuminated share: crescent under half, gibbous over half, and New, First Quarter, Full and Last Quarter near their moments."
    :calc="['engine' => 'ev-time', 'tool' => 'moon_phase', 'fields' => ['date', 'time', 'zone'], 'data' => ['zones' => collect(config('everyday_data.zones'))->collapse()->all()]]"
    :how-to="[
        ['name' => 'Pick the date and time', 'text' => 'And your time zone.'],
        ['name' => 'Read the phase', 'text' => 'And the next main phases.'],
    ]"
    :faqs="[
        ['question' => 'How long is a lunar cycle?', 'answer' => 'About 29.53 days from new moon to new moon.'],
        ['question' => 'When was the full moon of 23 April 2024?', 'answer' => '23:49 UTC (7:49 PM in New York).'],
        ['question' => 'Why do moon phases differ by a day between countries?', 'answer' => 'The phase happens at one instant, which is a different date in different time zones.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="date" label="Date" value="{{ now()->toDateString() }}" type="date" />
        <x-calc.field name="time" label="Time" value="21:00" type="time" />
        <x-calc.select name="zone" label="Time zone" :options="config('everyday_data.zones')" selected="America/New_York" />
    </div>

    <x-calc.result label="Moon phase" />

    <x-calc.options :decimals="false" :examples="[
        'Total solar eclipse, 8 Apr 2024' => ['date' => '2024-04-08', 'time' => '14:00', 'zone' => 'America/Chicago'],
        'Christmas Day 2026' => ['date' => '2026-12-25', 'time' => '20:00', 'zone' => 'Europe/London'],
        'Moon landing' => ['date' => '1969-07-20', 'time' => '20:17', 'zone' => 'UTC'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'age' => ['label' => 'Moon age'],
            'new' => ['label' => 'Next new moon'],
            'first' => ['label' => 'Next first quarter'],
            'full' => ['label' => 'Next full moon'],
            'last' => ['label' => 'Next last quarter'],
            'zone' => ['label' => 'Times shown in'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>k ≈ (year − 2000) × 12.3685; JDE of each phase from the Meeus series</li>
            <li>illumination = (1 + cos i) ÷ 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
