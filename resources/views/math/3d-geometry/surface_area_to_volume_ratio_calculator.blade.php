<x-calc.page
    title="Surface Area to Volume Ratio Calculator - SolveKit"
    description="Free surface area to volume ratio calculator: SA:V of cubes, boxes, spheres, cylinders, cones, pyramids, tori and capsules."
    lede="Find the SA:V ratio."
    about="The surface area to volume ratio drops as an object grows: a 1 cm cube has 6 per cm, a 2 cm cube 3 per cm. That is why cells stay small and why crushed ice melts faster than a block. The sphere has the lowest ratio for its volume. Also known as SA:V ratio calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'hub', 'fields' => ['fig', 'unit', 'a', 'h', 'l', 'w', 'r', 'outer', 'len'], 'measure' => 'ratio']"
    :how-to="[
        ['name' => 'Choose the shape', 'text' => 'The fields change to the measurements that shape needs.'],
        ['name' => 'Enter the measurements', 'text' => 'All in the same unit.'],
    ]"
    :faqs="[
        ['question' => 'What is the SA:V ratio of a sphere with radius 3?', 'answer' => '1 per cm per cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="fig" label="Shape" :options="['cube' => 'Cube (edge a)', 'cuboid' => 'Box (l × w × h)', 'sphere' => 'Sphere (radius r)', 'hemisphere' => 'Hemisphere (radius r)', 'cylinder' => 'Cylinder (radius r, height h)', 'cone' => 'Cone (radius r, height h)', 'pyramid' => 'Rectangular pyramid (l, w, height h)', 'torus' => 'Torus (R to the tube centre, tube radius r)', 'capsule' => 'Capsule (radius r, cylinder length a)']" selected="sphere" />
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

    <x-calc.result label="Surface area to volume ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fig' => 'sphere', 'unit' => 'cm', 'r' => 3],
        'Cube' => ['fig' => 'cube', 'unit' => 'cm', 'a' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'surf' => ['label' => 'Surface area'],
            'vol' => ['label' => 'Volume'],
            'formula' => ['label' => 'Formulas'],
            'scale' => ['label' => 'Scaling'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>SA ÷ V</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
