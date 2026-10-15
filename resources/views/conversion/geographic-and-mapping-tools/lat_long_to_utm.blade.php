<x-calc.page
    title="Lat Long to UTM Converter - SolveKit"
    description="Professional latitude longitude to UTM converter for surveying and mapping. Convert between geographic and UTM coordinate systems with precision."
    lede="Convert latitude and longitude to UTM coordinates, or UTM back to latitude and longitude."
    about="UTM divides the world into 60 zones, each 6° of longitude wide, and projects each one with a transverse Mercator projection scaled by 0.9996. This converter uses the WGS84 ellipsoid and the full Krüger series, accurate to well under a millimeter, with the special zones over Norway and Svalbard."
    :calc="['engine' => 'lat-long-utm']"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Latitude/longitude to UTM, or UTM to latitude/longitude.'],
        ['name' => 'Enter the coordinates', 'text' => 'Decimal degrees with minus signs for south and west, or zone, hemisphere, easting and northing.'],
    ]"
    :faqs="[
        ['question' => 'What is a UTM zone?', 'answer' => 'A 6°-wide strip of longitude, numbered 1 to 60 eastwards from 180°W. The letter after the number is the 8° latitude band.'],
        ['question' => 'Why is the easting near 500,000?', 'answer' => 'The zone\'s central meridian is given an easting of 500,000 m so that values stay positive across the zone.'],
        ['question' => 'Which datum is used?', 'answer' => 'WGS84, as used by GPS. NAD83 agrees with it to about a meter; older datums such as NAD27 need a datum shift first.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Direction" :options="['to-utm' => 'Lat/Long → UTM', 'to-latlon' => 'UTM → Lat/Long']" selected="to-utm" />

    <div data-show-when="mode:to-utm" class="grid grid-cols-2 gap-3">
        <x-calc.field name="lat" label="Latitude" value="40.748440" min="-80" max="84" suffix="°" placeholder="e.g. 40.7484" />
        <x-calc.field name="lon" label="Longitude" value="-73.985664" min="-180" max="180" suffix="°" placeholder="e.g. -73.9857" />
    </div>

    <div data-show-when="mode:to-latlon" hidden class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="zone" label="Zone" value="18" min="1" max="60" step="1" placeholder="1 to 60" />
        <x-calc.segmented name="hemisphere" legend="Hemisphere" :options="['N' => 'North', 'S' => 'South']" selected="N" />
        <x-calc.field name="easting" label="Easting" value="585631" suffix="m" placeholder="m" />
        <x-calc.field name="northing" label="Northing" value="4511327" suffix="m" placeholder="m" />
    </div>

    <x-calc.result label="UTM (WGS84)" />

    <x-calc.options :decimals="false" :examples="[
        'Statue of Liberty' => ['mode' => 'to-utm', 'lat' => 40.689247, 'lon' => -74.044502],
        'Cape Town' => ['mode' => 'to-utm', 'lat' => -33.9249, 'lon' => 18.4241],
        'UTM 31U 448251 5411952' => ['mode' => 'to-latlon', 'zone' => 31, 'hemisphere' => 'N', 'easting' => 448251, 'northing' => 5411952],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'latlon' => ['label' => 'Latitude, longitude'],
            'dms' => ['label' => 'DMS'],
            'zone' => ['label' => 'Zone and band'],
            'easting' => ['label' => 'Easting'],
            'northing' => ['label' => 'Northing'],
            'meridian' => ['label' => 'Central meridian'],
            'mgrs' => ['label' => 'MGRS'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>zone = floor((longitude + 180) ÷ 6) + 1</li>
            <li>central meridian = zone × 6 − 183</li>
            <li>easting = 500,000 + k₀ × x · northing = k₀ × y (+10,000,000 south)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
