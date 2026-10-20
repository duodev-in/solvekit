<x-calc.page
    title="Euler’s Formula for Polyhedron Calculator - SolveKit"
    description="Free Euler's polyhedron formula calculator: V − E + F = 2, find the missing count of vertices, edges or faces."
    lede="Use Euler's formula."
    about="For every convex polyhedron, vertices − edges + faces = 2: a cube has 8 − 12 + 6 = 2. Leave one count blank to find it. Solids with holes have V − E + F = 2 − 2g, where g is the number of holes."
    :calc="['engine' => 'mt-solid', 'tool' => 'euler', 'fields' => ['v', 'e', 'f']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'A polyhedron has 8 vertices and 12 edges. How many faces?', 'answer' => '6.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="v" label="Vertices V" value="8" type="text" inputmode="decimal" />
        <x-calc.field name="e" label="Edges E" value="12" type="text" inputmode="decimal" />
        <x-calc.field name="f" label="Faces F" value="" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Missing count" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['v' => '8', 'e' => '12', 'f' => ''],
        'Check' => ['v' => '20', 'e' => '30', 'f' => '12'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'check' => ['label' => 'Check'],
            'bounds' => ['label' => 'Realisable?'],
            'genus' => ['label' => 'Holes'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V − E + F = 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
