<x-calc.page
    title="Great Circle Calculator - SolveKit"
    description="Free great circle calculator: the shortest distance between two points on a sphere (such as the Earth), the initial bearing and the midpoint."
    lede="Find a great-circle distance."
    about="The shortest path between two points on a sphere follows a great circle. The central angle is found with Vincenty's form of the haversine formula, and the distance is that angle times the radius. London to New York is about 5,570 km on a sphere of radius 6,371 km."
    :calc="['engine' => 'mt-solid', 'tool' => 'great_circle', 'fields' => ['lat1', 'lon1', 'lat2', 'lon2', 'radius', 'unit']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How far is London from New York along a great circle?', 'answer' => '5,570.22218 km.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lat1" label="Point 1 latitude (°)" value="51.5074" step="any" />
        <x-calc.field name="lon1" label="Point 1 longitude (°)" value="-0.1278" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lat2" label="Point 2 latitude (°)" value="40.7128" step="any" />
        <x-calc.field name="lon2" label="Point 2 longitude (°)" value="-74.006" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="radius" label="Sphere radius" value="6371" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['km' => 'km', 'mi' => 'mi', 'm' => 'm', 'units' => 'No unit']" selected="km" />
    </div>

    <x-calc.result label="Great-circle distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lat1' => 51.5074, 'lon1' => -0.1278, 'lat2' => 40.7128, 'lon2' => -74.006, 'radius' => 6371, 'unit' => 'km'],
        'Miles' => ['lat1' => 34.0522, 'lon1' => -118.2437, 'lat2' => 35.6762, 'lon2' => 139.6503, 'radius' => 3958.8, 'unit' => 'mi'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Route (longitude and latitude)" name="route" />
        <x-calc.rows heading="Details" :rows="[
            'angle' => ['label' => 'Central angle'],
            'bearing' => ['label' => 'Initial bearing'],
            'back' => ['label' => 'Final bearing'],
            'midpoint' => ['label' => 'Midpoint'],
            'sphere' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>d = Rσ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
