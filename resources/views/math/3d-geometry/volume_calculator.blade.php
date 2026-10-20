<x-calc.page
    title="Volume Calculator - SolveKit"
    description="Free volume calculator for 13 solids: cube, box, sphere, hemisphere, cylinder, cone, pyramid, triangular prism, ellipsoid, torus and capsule, with litres and gallons."
    lede="Find the volume of a solid."
    about="Volume is the space a solid fills, in cubic units. Choose the solid and enter its measurements in one unit; the volume is shown in that unit cubed and converted to litres, US gallons, cubic feet and cubic yards."
    :calc="['engine' => 'mt-shape', 'tool' => 'hub', 'fields' => ['fig', 'unit', 'a', 'b', 'c', 'h', 'l', 'w', 'r', 'outer', 'len'], 'measure' => 'vol']"
    :how-to="[
        ['name' => 'Choose the shape', 'text' => 'The fields change to the measurements that shape needs.'],
        ['name' => 'Enter the measurements', 'text' => 'All in the same unit.'],
    ]"
    :faqs="[
        ['question' => 'What is the volume of a cylinder with radius 3 cm and height 10 cm?', 'answer' => '282.7433388 cm³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="fig" label="Shape" :options="['cube' => 'Cube (edge a)', 'cuboid' => 'Box (l × w × h)', 'sphere' => 'Sphere (radius r)', 'hemisphere' => 'Hemisphere (radius r)', 'cylinder' => 'Cylinder (radius r, height h)', 'cone' => 'Cone (radius r, height h)', 'pyramid' => 'Rectangular pyramid (l, w, height h)', 'triprism' => 'Triangular prism (base b, height h, length L)', 'ellipsoid' => 'Ellipsoid (semi-axes a, b, c)', 'torus' => 'Torus (R to the tube centre, tube radius r)', 'capsule' => 'Capsule (radius r, cylinder length a)']" selected="cylinder" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:cube,ellipsoid" hidden>
            <x-calc.field name="a" label="a" value="6" min="0" step="any" />
        </div>
        <div data-show-when="fig:triprism,ellipsoid" hidden>
            <x-calc.field name="b" label="b" value="4" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:ellipsoid" hidden>
            <x-calc.field name="c" label="c" value="5" min="0" step="any" />
        </div>
        <div data-show-when="fig:cuboid,cylinder,cone,pyramid,triprism" hidden>
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
        <div data-show-when="fig:triprism,capsule" hidden>
            <x-calc.field name="len" label="Length L (or a)" value="10" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fig' => 'cylinder', 'unit' => 'cm', 'r' => 3, 'h' => 10],
        'Sphere' => ['fig' => 'sphere', 'unit' => 'cm', 'r' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Formula'],
            'given' => ['label' => 'Values used'],
            'volumes' => ['label' => 'In other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = πr²h, V = (4/3)πr³, …</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
