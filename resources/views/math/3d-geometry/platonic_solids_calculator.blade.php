<x-calc.page
    title="Platonic Solids Calculator - SolveKit"
    description="Free Platonic solids calculator: volume, surface area, circumradius, inradius and dihedral angle of the tetrahedron, cube, octahedron, dodecahedron and icosahedron."
    lede="Solve a Platonic solid."
    about="The five Platonic solids are the only convex polyhedra with identical regular faces and the same number meeting at every vertex. All their measures follow from the edge length a."
    :calc="['engine' => 'mt-solid', 'tool' => 'platonic', 'fields' => ['solid', 'a', 'unit']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the volume of a dodecahedron with edge 1?', 'answer' => '7.663118961 cm³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="solid" label="Solid" :options="['tetrahedron' => 'Tetrahedron (4 faces)', 'cube' => 'Cube (6)', 'octahedron' => 'Octahedron (8)', 'dodecahedron' => 'Dodecahedron (12)', 'icosahedron' => 'Icosahedron (20)']" selected="dodecahedron" />
        <x-calc.field name="a" label="Edge a" value="1" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <x-calc.result label="Volume" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solid' => 'dodecahedron', 'a' => 1, 'unit' => 'cm'],
        'Icosahedron' => ['solid' => 'icosahedron', 'a' => 2, 'unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'counts' => ['label' => 'Faces, edges, vertices'],
            'vol' => ['label' => 'Volume'],
            'surf' => ['label' => 'Surface area'],
            'circr' => ['label' => 'Circumradius'],
            'insr' => ['label' => 'Inradius'],
            'dihedral' => ['label' => 'Dihedral angle'],
            'volumes' => ['label' => 'Volume in other units'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = k a³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
