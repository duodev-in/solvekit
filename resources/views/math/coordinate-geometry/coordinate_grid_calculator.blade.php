<x-calc.page
    title="Coordinate Grid Calculator - SolveKit"
    description="Free coordinate grid calculator: plot points, name their quadrants and find the area of the polygon they form."
    lede="Plot points on a grid."
    about="The coordinate plane is split by the axes into four quadrants: I (+, +), II (−, +), III (−, −) and IV (+, −). Points on an axis belong to no quadrant."
    :calc="['engine' => 'mt-coord', 'tool' => 'grid', 'fields' => ['points']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'Which quadrant is (−3, 4) in?', 'answer' => 'Quadrant II.'],
    ]"
>
    <x-calc.textarea name="points" label="Points x, y (one per line)" value="1, 2
-3, 4
-2, -2
3, -1" rows="5" />

    <x-calc.result label="Plotted points" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['points' => '1, 2
-3, 4
-2, -2
3, -1'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Grid" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'quadrants' => ['label' => 'Quadrants'],
            'box' => ['label' => 'Extent'],
            'area' => ['label' => 'Polygon area'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(x, y)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
