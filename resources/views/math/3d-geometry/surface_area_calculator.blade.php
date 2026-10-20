<x-calc.page
    title="Surface Area Calculator - SolveKit"
    description="Free surface area calculator for cubes, boxes, spheres, hemispheres, cylinders, cones, pyramids, tori and capsules."
    lede="Find the surface area of a solid."
    about="Surface area is the total area of all the faces or the curved surface, as if the solid were unfolded flat. It tells you how much paint or wrapping a shape needs."
    :calc="['engine' => 'mt-shape', 'tool' => 'hub', 'fields' => ['fig', 'unit', 'a', 'h', 'l', 'w', 'r', 'outer', 'len'], 'measure' => 'surf']"
    :how-to="[
        ['name' => 'Choose the shape', 'text' => 'The fields change to the measurements that shape needs.'],
        ['name' => 'Enter the measurements', 'text' => 'All in the same unit.'],
    ]"
    :faqs="[
        ['question' => 'What is the surface area of a cylinder with radius 3 and height 10?', 'answer' => '245.044227 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="fig" label="Shape" :options="['cube' => 'Cube (edge a)', 'cuboid' => 'Box (l × w × h)', 'sphere' => 'Sphere (radius r)', 'hemisphere' => 'Hemisphere (radius r)', 'cylinder' => 'Cylinder (radius r, height h)', 'cone' => 'Cone (radius r, height h)', 'pyramid' => 'Rectangular pyramid (l, w, height h)', 'torus' => 'Torus (R to the tube centre, tube radius r)', 'capsule' => 'Capsule (radius r, cylinder length a)']" selected="cylinder" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:cube" hidden>
            <x-calc.field name="a" label="a" value="6" min="0" step="any" />
        </div>
        <div data-show-when="fig:cuboid,cylinder,cone,pyramid" hidden>
            <x-calc.field name="h" label="Height h" value="5" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:cuboid,pyramid" hidden>
            <x-calc.field name="l" label="Length l" value="8" min="0" step="any" />
        </div>
        <div data-show-when="fig:cuboid,pyramid" hidden>
            <x-calc.field name="w" label="Width w" value="5" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:sphere,hemisphere,cylinder,cone,torus,capsule" hidden>
            <x-calc.field name="r" label="Radius r" value="3" min="0" step="any" />
        </div>
        <div data-show-when="fig:torus" hidden>
            <x-calc.field name="outer" label="Radius R" value="6" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:capsule" hidden>
            <x-calc.field name="len" label="Length L (or a)" value="10" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Surface area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fig' => 'cylinder', 'unit' => 'cm', 'r' => 3, 'h' => 10],
        'Box' => ['fig' => 'cuboid', 'unit' => 'cm', 'l' => 8, 'w' => 5, 'h' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Formula'],
            'given' => ['label' => 'Values used'],
            'areas' => ['label' => 'In other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = 2πr(r + h), A = 4πr², …</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
