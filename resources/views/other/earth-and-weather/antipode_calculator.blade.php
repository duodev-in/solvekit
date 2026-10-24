<x-calc.page
    title="Antipode Calculator - SolveKit"
    description="Free antipode calculator: the point on the opposite side of the Earth from any coordinates."
    lede="Find the antipode."
    about="The antipode is the point you would reach by going straight through the centre of the Earth."
    :calc="['engine' => 'ot-misc', 'tool' => 'antipode', 'fields' => ['lat', 'lon'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the antipode of New Delhi?', 'answer' => '−28.6139, −102.791 (in the Pacific).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lat" label="Latitude (e.g. 28.6139 or 28°36′50″N)" value="28.6139" type="text" inputmode="text" />
        <x-calc.field name="lon" label="Longitude (e.g. 77.2090 or 77°12′32″E)" value="77.2090" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Antipode" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lat' => '28.6139', 'lon' => '77.2090'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'dms' => ['label' => 'In degrees, minutes, seconds'],
            'distance' => ['label' => 'Distance through the Earth'],
            'around' => ['label' => 'Distance along the surface'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
