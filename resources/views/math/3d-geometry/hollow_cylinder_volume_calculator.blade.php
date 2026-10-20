<x-calc.page
    title="Hollow Cylinder Volume Calculator - SolveKit"
    description="Free hollow cylinder calculator: the volume of material in a pipe or tube from the outer and inner radius (or wall thickness), with its surface area."
    lede="Find the volume of a hollow cylinder."
    about="A hollow cylinder (tube) is a big cylinder minus the hole: V = π(R² − r²)h. A pipe with outer radius 5 cm, inner 4 cm and length 100 cm contains 2,827 cm³ of material. Also known as pipe volume calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'outer', 'inner', 'h', 'wall'], 'shape' => 'hollowCylinder', 'want' => 'vol']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How much material is in a pipe with radii 5 and 4 cm, 100 cm long?', 'answer' => '2,827.433388 cm³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['outer_inner_h' => 'Outer radius R, inner radius r and height h', 'outer_wall_h' => 'Outer radius R, wall thickness and height h']" selected="outer_inner_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:outer_inner_h,outer_wall_h" hidden>
            <x-calc.field name="outer" label="Outer radius R" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:outer_inner_h" hidden>
            <x-calc.field name="inner" label="Inner radius r" value="4" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:outer_inner_h,outer_wall_h" hidden>
            <x-calc.field name="h" label="Height h" value="100" min="0" step="any" />
        </div>
        <div data-show-when="given:outer_wall_h" hidden>
            <x-calc.field name="wall" label="Wall thickness" value="1" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume of material" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'outer_inner_h', 'unit' => 'cm', 'outer' => 5, 'inner' => 4, 'h' => 100, 'wall' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'outer' => ['label' => 'Outer radius R'],
            'inner' => ['label' => 'Inner radius r'],
            'h' => ['label' => 'Height h'],
            'wall' => ['label' => 'Wall thickness'],
            'vol' => ['label' => 'Volume of material'],
            'hole' => ['label' => 'Volume of the hole'],
            'surf' => ['label' => 'Total surface area'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = π(R² − r²)h</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
