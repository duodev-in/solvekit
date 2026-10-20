<x-calc.page
    title="Line of Intersection of Two Planes Calculator - SolveKit"
    description="Free line of intersection of two planes calculator: the direction (n₁ × n₂), a point and the parametric equations."
    lede="Find where two planes meet."
    about="Two non-parallel planes meet in a line. Its direction is the cross product of the normals; a point comes from setting one coordinate to 0 and solving. x + y + z = 6 and x − y + 2z = 5 meet along x = 3t, y = 7/3 − t, z = 11/3 − 2t."
    :calc="['engine' => 'mt-coord', 'tool' => 'planes_line', 'fields' => ['eq1', 'eq2']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'Where do x + y + z = 6 and x − y + 2z = 5 meet?', 'answer' => 'x = 3t, y = 7/3 − t, z = 11/3 − 2t.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="eq1" label="Plane 1" value="x + y + z = 6" type="text" inputmode="text" />
        <x-calc.field name="eq2" label="Plane 2" value="x - y + 2z = 5" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Line of intersection" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eq1' => 'x + y + z = 6', 'eq2' => 'x - y + 2z = 5'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'direction' => ['label' => 'Direction'],
            'point' => ['label' => 'Point on the line'],
            'param' => ['label' => 'Parametric form'],
            'angle' => ['label' => 'Angle'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>d = n₁ × n₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
