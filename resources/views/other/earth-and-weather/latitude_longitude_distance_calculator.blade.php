<x-calc.page
    title="Latitude Longitude Distance Calculator - SolveKit"
    description="Free latitude and longitude distance calculator: distance between two coordinates on the WGS-84 ellipsoid, with bearing and midpoint."
    lede="Find the distance between coordinates."
    about="The shortest distance over the Earth follows a geodesic on the ellipsoid."
    :calc="['engine' => 'ot-misc', 'tool' => 'latlong_distance', 'fields' => ['lat1', 'lon1', 'lat2', 'lon2'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How far is Mumbai from New Delhi as the crow flies?', 'answer' => '1,144.526 km.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lat1" label="Point A latitude" value="19.0760" type="text" inputmode="text" />
        <x-calc.field name="lon1" label="Point A longitude" value="72.8777" type="text" inputmode="text" />
        <x-calc.field name="lat2" label="Point B latitude" value="28.6139" type="text" inputmode="text" />
        <x-calc.field name="lon2" label="Point B longitude" value="77.2090" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lat1' => '19.0760', 'lon1' => '72.8777', 'lat2' => '28.6139', 'lon2' => '77.2090'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'miles' => ['label' => 'In miles and nautical miles'],
            'haversine' => ['label' => 'Haversine (spherical) distance'],
            'bearing' => ['label' => 'Initial bearing'],
            'midpoint' => ['label' => 'Midpoint'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
