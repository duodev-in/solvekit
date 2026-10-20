<x-calc.page
    title="Distance Formula Calculator - SolveKit"
    description="Free distance formula calculator: the exact distance between two points, d = √((x₂ − x₁)² + (y₂ − y₁)²), as a simplified root."
    lede="Find the distance between two points."
    about="The distance formula is Pythagoras on the coordinate grid: the horizontal and vertical differences are the legs, the distance the hypotenuse. (1, 2) to (4, 6) is √(3² + 4²) = 5; (1, 1) to (3, 4) is √13. Also known as 2D distance calculator, coordinate distance calculator, distance between two points calculator and length of a line segment calculator."
    :calc="['engine' => 'mt-coord', 'tool' => 'distance', 'fields' => ['x1', 'y1', 'x2', 'y2']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'How far is (1, 2) from (4, 6)?', 'answer' => '5.'],
        ['question' => 'And (1, 1) from (3, 4)?', 'answer' => '√13 ≈ √13 ≈ 3.60555127546.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="x1" label="x₁" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="y1" label="y₁" value="2" type="text" inputmode="decimal" />
        <x-calc.field name="x2" label="x₂" value="4" type="text" inputmode="decimal" />
        <x-calc.field name="y2" label="y₂" value="6" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x1' => '1', 'y1' => '2', 'x2' => '4', 'y2' => '6'],
        'Root' => ['x1' => '1', 'y1' => '1', 'x2' => '3', 'y2' => '4'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'euclid' => ['label' => 'Euclidean distance'],
            'manhattan' => ['label' => 'Manhattan distance'],
            'chebyshev' => ['label' => 'Chebyshev distance'],
            'squared' => ['label' => 'Distance squared'],
            'diffs' => ['label' => 'Differences'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>d = √((x₂ − x₁)² + (y₂ − y₁)²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
