<x-calc.page
    title="Orthocenter Calculator - SolveKit"
    description="Free orthocenter calculator: where the three altitudes of a triangle meet, from the vertex coordinates."
    lede="Find the orthocentre of a triangle."
    about="An altitude runs from a vertex perpendicular to the opposite side. The three altitudes meet at the orthocentre H, which is inside acute triangles, at the right-angle vertex of right triangles and outside obtuse ones. H = A + B + C − 2O, where O is the circumcentre."
    :calc="['engine' => 'mt-tri', 'tool' => 'triangle', 'fields' => ['x1', 'y1', 'x2', 'y2', 'x3', 'y3', 'unit'], 'given' => 'coords', 'want' => 'orthocenter']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'Where is the orthocentre of A(0, 0), B(4, 0), C(1, 3)?', 'answer' => '(1, 1).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x1" label="A: x₁" value="0" step="any" />
        <x-calc.field name="y1" label="A: y₁" value="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x2" label="B: x₂" value="4" step="any" />
        <x-calc.field name="y2" label="B: y₂" value="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x3" label="C: x₃" value="1" step="any" />
        <x-calc.field name="y3" label="C: y₃" value="3" step="any" />
    </div>

    <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="units" />

    <x-calc.result label="Orthocentre" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x1' => 0, 'y1' => 0, 'x2' => 4, 'y2' => 0, 'x3' => 1, 'y3' => 3, 'unit' => 'units'],
        'Obtuse' => ['x1' => 0, 'y1' => 0, 'x2' => 6, 'y2' => 0, 'x3' => 1, 'y3' => 1, 'unit' => 'units'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'centres' => ['label' => 'All centres'],
            'type' => ['label' => 'Type'],
            'sides' => ['label' => 'Sides'],
            'angles' => ['label' => 'Angles'],
            'area' => ['label' => 'Area'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>H = A + B + C − 2O</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
