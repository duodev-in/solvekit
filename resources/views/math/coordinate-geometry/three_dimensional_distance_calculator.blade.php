<x-calc.page
    title="Three-Dimensional Distance Calculator - SolveKit"
    description="Free 3D distance calculator: d = √(Δx² + Δy² + Δz²) between two points in space, exactly."
    lede="Find a distance in 3D."
    about="In three dimensions add the third difference under the root: (1, 2, 3) to (4, 6, 15) is √(9 + 16 + 144) = 13. Also known as 3D distance calculator."
    :calc="['engine' => 'mt-coord', 'tool' => 'distance', 'fields' => ['x1', 'y1', 'z1', 'x2', 'y2', 'z2'], 'dim' => 3]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'How far is (1, 2, 3) from (4, 6, 15)?', 'answer' => '13.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="x1" label="x₁" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="y1" label="y₁" value="2" type="text" inputmode="decimal" />
        <x-calc.field name="z1" label="z₁" value="3" type="text" inputmode="decimal" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="x2" label="x₂" value="4" type="text" inputmode="decimal" />
        <x-calc.field name="y2" label="y₂" value="6" type="text" inputmode="decimal" />
        <x-calc.field name="z2" label="z₂" value="15" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x1' => '1', 'y1' => '2', 'z1' => '3', 'x2' => '4', 'y2' => '6', 'z2' => '15'],
    ]" />

    <x-slot:panel>
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
            <li>d = √(Δx² + Δy² + Δz²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
