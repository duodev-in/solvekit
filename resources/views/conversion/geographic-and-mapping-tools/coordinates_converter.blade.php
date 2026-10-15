<x-calc.page
    title="Coordinates Converter - SolveKit"
    description="Professional coordinates converter for GPS, mapping and surveying applications. Convert between decimal degrees, DMS, UTM and other coordinate systems."
    lede="Convert a position between decimal degrees, DMS, UTM, MGRS, Plus Codes, Maidenhead and Geohash."
    about="Paste a position in any supported format and it is shown in all of them. Everything uses the WGS84 datum, the same as GPS. UTM and MGRS use the exact transverse Mercator formulas, including the special zones over Norway and Svalbard, and cover 80°S to 84°N."
    :calc="['engine' => 'coordinates']"
    :how-to="[
        ['name' => 'Choose the input format', 'text' => 'Latitude/longitude (decimal or DMS), UTM, MGRS, Plus Code, Maidenhead or Geohash.'],
        ['name' => 'Paste or type the position', 'text' => 'Every other format updates as you type. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'Which datum does this use?', 'answer' => 'WGS84, the datum used by GPS and most web maps. Positions from older paper maps may use a different datum and differ by up to a few hundred meters.'],
        ['question' => 'What is the difference between UTM and MGRS?', 'answer' => 'They describe the same grid. MGRS replaces the large easting and northing numbers with 100 km square letters, e.g. 18T WL 85631 11326.'],
        ['question' => 'How precise is a Plus Code?', 'answer' => 'A 10-digit Plus Code identifies an area of about 14 × 14 meters.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-[minmax(0,1fr)_minmax(0,2fr)]">
        <x-calc.select name="format" label="Input format" :options="['latlon' => 'Latitude, longitude', 'utm' => 'UTM', 'mgrs' => 'MGRS', 'pluscode' => 'Plus Code', 'maidenhead' => 'Maidenhead', 'geohash' => 'Geohash']" selected="latlon" />
        <x-calc.field name="value" type="text" label="Position" value="40.748440, -73.985664" placeholder="e.g. 40.7484, -73.9857" spellcheck="false" autocapitalize="off" />
    </div>
    <p class="-mt-3 text-xs text-slate-500" data-ref="format-hint"></p>

    <x-calc.result label="Decimal degrees" />

    <x-calc.options :decimals="false" :examples="[
        'Empire State Building' => ['format' => 'latlon', 'value' => '40.748440, -73.985664'],
        'Eiffel Tower (DMS)' => ['format' => 'latlon', 'value' => '48°51′30.1″N 2°17′40.1″E'],
        'Sydney Opera House (UTM)' => ['format' => 'utm', 'value' => '56H 334901 6252289'],
        'Plus Code' => ['format' => 'pluscode', 'value' => '849VCWC8+R9'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="In every format" :rows="[
            'dd' => ['label' => 'Decimal degrees'],
            'dms' => ['label' => 'Degrees, minutes, seconds'],
            'dm' => ['label' => 'Degrees, decimal minutes'],
            'utm' => ['label' => 'UTM'],
            'mgrs' => ['label' => 'MGRS'],
            'pluscode' => ['label' => 'Plus Code'],
            'maidenhead' => ['label' => 'Maidenhead'],
            'geohash' => ['label' => 'Geohash'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DMS: degrees + minutes ÷ 60 + seconds ÷ 3,600</li>
            <li>UTM: transverse Mercator, k₀ = 0.9996, WGS84 ellipsoid</li>
            <li>Plus Code: base-20 digits of (lat + 90, lon + 180)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
