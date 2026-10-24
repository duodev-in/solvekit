<x-calc.page
    title="Azimuth Calculator - SolveKit"
    description="Free azimuth calculator: bearing from one point to another on the Earth, with distance."
    lede="Find the bearing between two places."
    about="The azimuth is the compass direction to set off along the shortest route."
    :calc="['engine' => 'ot-misc', 'tool' => 'azimuth', 'fields' => ['lat1', 'lon1', 'lat2', 'lon2'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What bearing from London to New York?', 'answer' => '288.369° (WNW).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lat1" label="From latitude" value="51.5074" type="text" inputmode="text" />
        <x-calc.field name="lon1" label="From longitude" value="-0.1278" type="text" inputmode="text" />
        <x-calc.field name="lat2" label="To latitude" value="40.7128" type="text" inputmode="text" />
        <x-calc.field name="lon2" label="To longitude" value="-74.0060" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Initial bearing (azimuth)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lat1' => '51.5074', 'lon1' => '-0.1278', 'lat2' => '40.7128', 'lon2' => '-74.0060'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'compass' => ['label' => 'Compass direction'],
            'final' => ['label' => 'Final bearing on arrival'],
            'distance' => ['label' => 'Distance (WGS-84)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
