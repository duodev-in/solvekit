<x-calc.page
    title="Sunrise Sunset Calculator - SolveKit"
    description="Free sunrise and sunset calculator: sunrise, sunset, solar noon, day length and twilight anywhere."
    lede="Find sunrise and sunset times."
    about="Sunrise and sunset are when the sun’s top edge touches the horizon, with the sun’s centre 0.833° below it after refraction. Times use the NOAA solar algorithm."
    :calc="['engine' => 'ph-quantum', 'tool' => 'sunrise_sunset', 'fields' => ['lat', 'lon', 'tz', 'date'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'When does the sun rise in New Delhi on 21 June?', 'answer' => 'At 05:24; Sunset 19:22, 13 h 58 min of daylight.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lat" label="Latitude (° north, negative for south)" value="28.6139" step="any" />
        <x-calc.field name="lon" label="Longitude (° east, negative for west)" value="77.209" step="any" />
        <x-calc.field name="tz" label="UTC offset of local time (hours)" value="5.5" step="any" />
        <x-calc.field name="date" label="Date" value="2026-06-21" type="date" />
    </div>

    <x-calc.result label="Sunrise" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lat' => 28.6139, 'lon' => 77.209, 'tz' => 5.5, 'date' => '2026-06-21'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'set' => ['label' => 'Sunset'],
            'noon' => ['label' => 'Solar noon'],
            'length' => ['label' => 'Day length'],
            'civil' => ['label' => 'Civil twilight (dawn – dusk)'],
            'noonAlt' => ['label' => 'Sun height at noon'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
