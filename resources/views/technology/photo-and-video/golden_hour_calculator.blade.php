<x-calc.page
    title="Golden Hour Calculator - SolveKit"
    description="Free golden hour calculator: morning and evening golden and blue hours for any place and date."
    lede="Find the golden hour."
    about="Golden hour is the soft, warm light when the sun is low; blue hour follows sunset and precedes sunrise."
    :calc="['engine' => 'tc-photo', 'tool' => 'golden_hour', 'fields' => ['lat', 'lon', 'date', 'tz'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'When is the evening golden hour in London on 21 June?', 'answer' => '20:27 – 21:50 (BST).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lat" label="Latitude (°, north positive)" value="51.5074" step="any" />
        <x-calc.field name="lon" label="Longitude (°, east positive)" value="-0.1278" step="any" />
        <x-calc.field name="date" label="Date" value="2026-06-21" type="date" />
        <x-calc.field name="tz" label="Time zone offset from UTC (hours, e.g. 1 for BST, 5.5 for IST)" value="1" step="any" />
    </div>

    <x-calc.result label="Evening golden hour" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lat' => 51.5074, 'lon' => -0.1278, 'date' => '2026-06-21', 'tz' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'morningGolden' => ['label' => 'Morning golden hour'],
            'morningBlue' => ['label' => 'Morning blue hour'],
            'eveningBlue' => ['label' => 'Evening blue hour'],
            'sunrise' => ['label' => 'Sunrise and sunset'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
