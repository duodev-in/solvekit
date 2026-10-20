<x-calc.page
    title="Irregular Polygon Area Calculator - SolveKit"
    description="Free irregular polygon area calculator: the exact area of any simple polygon from its vertices by the shoelace formula."
    lede="Find the area of an irregular polygon."
    about="List the vertices in order around the shape. The shoelace formula A = ½|Σ(xᵢyᵢ₊₁ − xᵢ₊₁yᵢ)| gives the exact area, here 16 for the house-shaped pentagon (0, 0), (4, 0), (4, 3), (2, 5), (0, 3). Also known as shoelace formula calculator and polygon area from coordinates calculator."
    :calc="['engine' => 'mt-coord', 'tool' => 'poly_area', 'fields' => ['points']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of the pentagon (0, 0), (4, 0), (4, 3), (2, 5), (0, 3)?', 'answer' => '16.'],
    ]"
>
    <x-calc.textarea name="points" label="Vertices x, y in order (one per line)" value="0, 0
4, 0
4, 3
2, 5
0, 3" rows="6" />

    <x-calc.result label="Area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['points' => '0, 0
4, 0
4, 3
2, 5
0, 3'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'area' => ['label' => 'Area'],
            'perim' => ['label' => 'Perimeter'],
            'orientation' => ['label' => 'Order'],
            'terms' => ['label' => 'Shoelace terms'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = ½|Σ(xᵢyᵢ₊₁ − xᵢ₊₁yᵢ)|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
