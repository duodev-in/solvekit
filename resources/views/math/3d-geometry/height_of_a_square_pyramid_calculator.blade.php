<x-calc.page
    title="Height of a Square Pyramid Calculator - SolveKit"
    description="Free height of a square pyramid calculator: h from the volume, slant height or lateral edge."
    lede="Find a square pyramid's height."
    about="From the volume, h = 3V/a²; from the slant height, h = √(s² − (a/2)²); from the lateral edge, h = √(e² − a²/2)."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'h', 'vol', 'slant', 'edge', 'faceAngle'], 'shape' => 'regularPyramid', 'want' => 'h', 'n' => 4]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How tall is a square pyramid with base 6 and volume 48?', 'answer' => '4 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a_h' => 'Base edge a and height h', 'vol_a' => 'Volume V and base edge a', 'a_slant' => 'Base edge a and slant height (apothem of a face)', 'a_edge' => 'Base edge a and lateral edge', 'a_faceAngle' => 'Base edge a and angle between a face and the base']" selected="vol_a" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_h,vol_a,a_slant,a_edge,a_faceAngle" hidden>
            <x-calc.field name="a" label="Base edge a" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:a_h" hidden>
            <x-calc.field name="h" label="Height h" value="4" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:vol_a" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="48" min="0" step="any" />
        </div>
        <div data-show-when="given:a_slant" hidden>
            <x-calc.field name="slant" label="Slant height (apothem of a face)" value="5" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_edge" hidden>
            <x-calc.field name="edge" label="Lateral edge" value="5.83095" min="0" step="any" />
        </div>
        <div data-show-when="given:a_faceAngle" hidden>
            <x-calc.field name="faceAngle" label="Angle between a face and the base (°)" value="53.1301" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Height h" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'vol_a', 'unit' => 'cm', 'a' => 6, 'h' => 4, 'vol' => 48, 'slant' => 5, 'edge' => 5.83095, 'faceAngle' => 53.1301],
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
            <li>h = 3V ÷ a²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
