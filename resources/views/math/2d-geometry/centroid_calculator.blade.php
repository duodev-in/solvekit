<x-calc.page
    title="Centroid Calculator - SolveKit"
    description="Free centroid calculator: the centroid (geometric centre) and area of any polygon from its vertices."
    lede="Find the centroid of a polygon."
    about="The centroid of a flat shape is its balance point. For a polygon with vertices in order, the shoelace formulas give the area A = ½Σ(xᵢyᵢ₊₁ − xᵢ₊₁yᵢ) and the centroid Cx = Σ(xᵢ + xᵢ₊₁)(xᵢyᵢ₊₁ − xᵢ₊₁yᵢ)/6A. For a triangle it is simply the average of the vertices."
    :calc="['engine' => 'mt-shape', 'tool' => 'center_mass', 'fields' => ['points'], 'mode' => 'centroid']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'Where is the centroid of the L-shape (0, 0), (6, 0), (6, 2), (2, 2), (2, 5), (0, 5)?', 'answer' => '(2.333333333, 1.833333333).'],
    ]"
>
    <x-calc.textarea name="points" label="Vertices x, y in order (one per line)" value="0, 0
6, 0
6, 2
2, 2
2, 5
0, 5" rows="6" />

    <x-calc.result label="Centroid" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['points' => '0, 0
6, 0
6, 2
2, 2
2, 5
0, 5'],
        'Triangle' => ['points' => '0, 0
4, 0
1, 3'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'area' => ['label' => 'Area'],
            'vertexMean' => ['label' => 'Average of the vertices'],
            'orientation' => ['label' => 'Vertex order'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Shoelace centroid</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
