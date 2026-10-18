<x-calc.page
    title="Sidereal Time Calculator - SolveKit"
    description="Free sidereal time calculator: Greenwich and local mean and apparent sidereal time for any date, UTC time and longitude, from the IAU 2006 formula."
    lede="Work out local sidereal time for pointing a telescope."
    about="Sidereal time measures Earth's rotation against the stars. Greenwich mean sidereal time uses the IAU 2006 formula (Earth rotation angle plus precession); local time adds your longitude (east positive) at 1 hour per 15°. Apparent sidereal time adds the equation of the equinoxes from the main nutation terms (about ±1 s). Times are UTC, treated as UT1 (within 0.9 s)."
    :calc="['engine' => 'ev-time', 'tool' => 'sidereal', 'fields' => ['date', 'time', 'longitude']]"
    :how-to="[
        ['name' => 'Enter the date and UTC time', 'text' => 'Convert your clock time to UTC first.'],
        ['name' => 'Enter your longitude', 'text' => 'Negative west of Greenwich.'],
    ]"
    :faqs="[
        ['question' => 'What is sidereal time used for?', 'answer' => 'The local sidereal time equals the right ascension now crossing your meridian.'],
        ['question' => 'How much shorter is a sidereal day?', 'answer' => 'About 23 h 56 min 4 s of solar time.'],
        ['question' => 'What was GMST at 0h UT on 10 April 1987?', 'answer' => '13h 10m 46.37s (Meeus example 12.a).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="date" label="Date" value="{{ now()->toDateString() }}" type="date" />
        <x-calc.field name="time" label="Time (UTC)" value="22:00" type="time" step="1" />
    </div>

    <x-calc.field name="longitude" label="Longitude (east +, west −)" value="-71.06" min="-180" max="180" step="0.0001" suffix="°" />

    <x-calc.result label="Local mean sidereal time" />

    <x-calc.options :decimals="false" :examples="[
        'Meeus 12.a, Greenwich' => ['date' => '1987-04-10', 'time' => '00:00', 'longitude' => 0],
        'Boston, 22:00 UTC' => ['date' => '2026-10-18', 'time' => '22:00', 'longitude' => -71.06],
        'Mauna Kea' => ['date' => '2026-01-01', 'time' => '08:00', 'longitude' => -155.47],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'gmst' => ['label' => 'Greenwich mean sidereal time'],
            'gast' => ['label' => 'Greenwich apparent sidereal time'],
            'last' => ['label' => 'Local apparent sidereal time'],
            'degrees' => ['label' => 'In degrees'],
            'jd' => ['label' => 'Julian Date (UT)'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GMST = ERA + (0.014506″ + 4612.156534″ t + …)</li>
            <li>LST = GMST + longitude ÷ 15°</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
