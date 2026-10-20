<x-calc.page
    title="Pyramid Angle Calculator - SolveKit"
    description="Free pyramid angle calculator: the angle between a face and the base, and between an edge and the base, for a regular pyramid."
    lede="Find a pyramid's angles."
    about="The face angle is atan(h ÷ r), with r the apothem of the base; the edge angle is atan(h ÷ R), with R the base circumradius. The Great Pyramid's faces rise at about 51.8°."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['n', 'given', 'unit', 'a', 'h', 'vol', 'slant', 'edge', 'faceAngle'], 'shape' => 'regularPyramid', 'want' => 'faceAngle']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'At what angle do the faces of a square pyramid with base 230.3 and height 146.6 rise?', 'answer' => '51.85140476 °.'],
    ]"
>
    <x-calc.field name="n" label="Sides of the base n" value="4" min="3" max="100" step="1" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a_h' => 'Base edge a and height h', 'vol_a' => 'Volume V and base edge a', 'a_slant' => 'Base edge a and slant height (apothem of a face)', 'a_edge' => 'Base edge a and lateral edge', 'a_faceAngle' => 'Base edge a and angle between a face and the base']" selected="a_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="m" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_h,vol_a,a_slant,a_edge,a_faceAngle" hidden>
            <x-calc.field name="a" label="Base edge a" value="230.3" min="0" step="any" />
        </div>
        <div data-show-when="given:a_h" hidden>
            <x-calc.field name="h" label="Height h" value="146.6" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:vol_a" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="2591790" min="0" step="any" />
        </div>
        <div data-show-when="given:a_slant" hidden>
            <x-calc.field name="slant" label="Slant height (apothem of a face)" value="186.416" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_edge" hidden>
            <x-calc.field name="edge" label="Lateral edge" value="219.113" min="0" step="any" />
        </div>
        <div data-show-when="given:a_faceAngle" hidden>
            <x-calc.field name="faceAngle" label="Angle between a face and the base (°)" value="51.8514" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Angle between a face and the base" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 4, 'given' => 'a_h', 'unit' => 'm', 'a' => 230.3, 'h' => 146.6, 'vol' => 2591790, 'slant' => 186.416, 'edge' => 219.113, 'faceAngle' => 51.8514],
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
            <li>θ = atan(h ÷ r)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
