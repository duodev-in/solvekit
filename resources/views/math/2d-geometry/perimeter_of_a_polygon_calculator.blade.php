<x-calc.page
    title="Perimeter of a Polygon Calculator - SolveKit"
    description="Free perimeter of a polygon calculator: add any list of side lengths (fractions allowed) or compute the perimeter from the vertices."
    lede="Add up the sides of a polygon."
    about="The perimeter of any polygon is the sum of its sides. Type the side lengths separated by commas, or the vertices one per line as x, y to get the sides from the distance formula (and the area by the shoelace formula)."
    :calc="['engine' => 'mt-shape', 'tool' => 'polygon_perimeter', 'fields' => ['sides', 'unit']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the perimeter of a polygon with sides 3, 4.5, 6 and 2½?', 'answer' => '16 cm.'],
    ]"
>
    <x-calc.textarea name="sides" label="Side lengths, or vertices x, y one per line" value="3, 4.5, 6, 5/2" rows="4" />

    <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />

    <x-calc.result label="Perimeter" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sides' => '3, 4.5, 6, 5/2', 'unit' => 'cm'],
        'Vertices' => ['sides' => '0, 0
4, 0
4, 3
0, 5', 'unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'sides' => ['label' => 'Sides'],
            'count' => ['label' => 'Number of sides'],
            'area' => ['label' => 'Area'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = Σ sides</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
