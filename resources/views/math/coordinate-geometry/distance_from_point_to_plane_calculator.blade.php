<x-calc.page
    title="Distance from Point to Plane Calculator - SolveKit"
    description="Free distance from a point to a plane calculator: |ax₀ + by₀ + cz₀ − d| ÷ √(a² + b² + c²), exactly, with the nearest point."
    lede="Find the distance to a plane."
    about="Project onto the unit normal: d = |ax₀ + by₀ + cz₀ − d| ÷ √(a² + b² + c²). From (1, 1, 4) to 2x − y + 2z = 6 the distance is |2 − 1 + 8 − 6| ÷ 3 = 1."
    :calc="['engine' => 'mt-coord', 'tool' => 'point_plane', 'fields' => ['eq', 'p']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'How far is (1, 1, 4) from 2x − y + 2z = 6?', 'answer' => '1.'],
    ]"
>
    <x-calc.field name="eq" label="Plane" value="2x - y + 2z = 6" type="text" inputmode="text" />

    <x-calc.field name="p" label="Point (x, y, z)" value="1, 1, 4" type="text" inputmode="text" />

    <x-calc.result label="Distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eq' => '2x - y + 2z = 6', 'p' => '1, 1, 4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'distance' => ['label' => 'Distance'],
            'foot' => ['label' => 'Nearest point'],
            'plane' => ['label' => 'Plane'],
            'side' => ['label' => 'Side'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>d = |n · P − d| ÷ |n|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
