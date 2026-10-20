<x-calc.page
    title="Volume of a Hexagonal Pyramid Calculator - SolveKit"
    description="Free volume of a hexagonal pyramid calculator: V = (√3/2)a²h."
    lede="Find a hexagonal pyramid's volume."
    about="The hexagonal base is six equilateral triangles, area (3√3/2)a², so V = (√3/2)a²h. With a = 4 and h = 9 that is 124.7."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'h', 'vol', 'slant', 'edge', 'faceAngle'], 'shape' => 'regularPyramid', 'want' => 'vol', 'n' => 6]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the volume of a hexagonal pyramid with base edge 4 and height 9?', 'answer' => '124.7076581 cm³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a_h' => 'Base edge a and height h', 'vol_a' => 'Volume V and base edge a', 'a_slant' => 'Base edge a and slant height (apothem of a face)', 'a_edge' => 'Base edge a and lateral edge', 'a_faceAngle' => 'Base edge a and angle between a face and the base']" selected="a_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_h,vol_a,a_slant,a_edge,a_faceAngle" hidden>
            <x-calc.field name="a" label="Base edge a" value="4" min="0" step="any" />
        </div>
        <div data-show-when="given:a_h" hidden>
            <x-calc.field name="h" label="Height h" value="9" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:vol_a" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="124.708" min="0" step="any" />
        </div>
        <div data-show-when="given:a_slant" hidden>
            <x-calc.field name="slant" label="Slant height (apothem of a face)" value="9.64365" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_edge" hidden>
            <x-calc.field name="edge" label="Lateral edge" value="9.84886" min="0" step="any" />
        </div>
        <div data-show-when="given:a_faceAngle" hidden>
            <x-calc.field name="faceAngle" label="Angle between a face and the base (°)" value="68.9483" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a_h', 'unit' => 'cm', 'a' => 4, 'h' => 9, 'vol' => 124.708, 'slant' => 9.64365, 'edge' => 9.84886, 'faceAngle' => 68.9483],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Base edge a'],
            'h' => ['label' => 'Height h'],
            'vol' => ['label' => 'Volume V'],
            'base' => ['label' => 'Base area'],
            'lat' => ['label' => 'Lateral surface area'],
            'surf' => ['label' => 'Total surface area'],
            'slant' => ['label' => 'Slant height (apothem of a face)'],
            'edge' => ['label' => 'Lateral edge'],
            'faceAngle' => ['label' => 'Angle between a face and the base'],
            'edgeAngle' => ['label' => 'Angle between an edge and the base'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = (√3/2)a²h</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
