<x-calc.page
    title="Sun Angle Calculator - SolveKit"
    description="Free sun angle calculator: sun elevation and azimuth for any place, date and time, with shadow length."
    lede="Find where the sun is."
    about="The sun’s position follows from the date (declination and equation of time) and your location. This uses NOAA’s implementation of Meeus’s algorithm, accurate to about 0.01°."
    :calc="['engine' => 'ph-quantum', 'tool' => 'sun_angle', 'fields' => ['lat', 'lon', 'tz', 'date', 'time', 'out'], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How high is the sun over New Delhi at noon on 21 June?', 'answer' => '82.7008 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lat" label="Latitude (° north, negative for south)" value="28.6139" step="any" />
        <x-calc.field name="lon" label="Longitude (° east, negative for west)" value="77.209" step="any" />
        <x-calc.field name="tz" label="UTC offset of local time (hours)" value="5.5" step="any" />
        <x-calc.field name="date" label="Date" value="2026-06-21" type="date" />
        <x-calc.field name="time" label="Local time" value="12:00" type="time" />
        <x-calc.select name="out" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
    </div>

    <x-calc.result label="Sun elevation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'deg', 'lat' => 28.6139, 'lon' => 77.209, 'tz' => 5.5, 'date' => '2026-06-21', 'time' => '12:00'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'az' => ['label' => 'Azimuth (from north, clockwise)'],
            'zen' => ['label' => 'Zenith angle'],
            'shadow' => ['label' => 'Shadow of a 1 m stick'],
            'decl' => ['label' => 'Solar declination'],
            'eot' => ['label' => 'Equation of time'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
