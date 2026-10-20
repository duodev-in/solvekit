<x-calc.page
    title="Surface Area of a Rectangular Pyramid Calculator - SolveKit"
    description="Free surface area of a rectangular pyramid calculator: base plus four triangular faces."
    lede="Find a rectangular pyramid's surface area."
    about="Total surface = lw + l × √(h² + (w/2)²) + w × √(h² + (l/2)²): the base and two pairs of congruent triangles."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'l', 'w', 'h', 'vol', 'slantL', 'edge'], 'shape' => 'pyramid', 'want' => 'surf']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the surface area of a pyramid with base 6 × 4 and height 5?', 'answer' => '79.63479642 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['l_w_h' => 'Base length l, base width w and height h', 'vol_l_w' => 'Volume V, base length l and base width w', 'edge_l_w' => 'Lateral edge, base length l and base width w', 'slantL_l_w' => 'Slant height on the length faces, base length l and base width w']" selected="l_w_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:l_w_h,vol_l_w,edge_l_w,slantL_l_w" hidden>
            <x-calc.field name="l" label="Base length l" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:l_w_h,vol_l_w,edge_l_w,slantL_l_w" hidden>
            <x-calc.field name="w" label="Base width w" value="4" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:l_w_h" hidden>
            <x-calc.field name="h" label="Height h" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:vol_l_w" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="40" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:slantL_l_w" hidden>
            <x-calc.field name="slantL" label="Slant height on the length faces" value="5.38516" min="0" step="any" />
        </div>
        <div data-show-when="given:edge_l_w" hidden>
            <x-calc.field name="edge" label="Lateral edge" value="6.16441" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Total surface area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'l_w_h', 'unit' => 'cm', 'l' => 6, 'w' => 4, 'h' => 5, 'vol' => 40, 'slantL' => 5.38516, 'edge' => 6.16441],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'l' => ['label' => 'Base length l'],
            'w' => ['label' => 'Base width w'],
            'h' => ['label' => 'Height h'],
            'vol' => ['label' => 'Volume V'],
            'base' => ['label' => 'Base area'],
            'lat' => ['label' => 'Lateral surface area'],
            'surf' => ['label' => 'Total surface area'],
            'slantL' => ['label' => 'Slant height on the length faces'],
            'slantW' => ['label' => 'Slant height on the width faces'],
            'edge' => ['label' => 'Lateral edge'],
            'faceAngle' => ['label' => 'Angle between a face and the base'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = lw + l sₗ + w sᵥ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
