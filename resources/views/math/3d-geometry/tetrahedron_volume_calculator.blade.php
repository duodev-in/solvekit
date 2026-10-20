<x-calc.page
    title="Tetrahedron Volume Calculator - SolveKit"
    description="Free regular tetrahedron calculator: volume a³ ÷ (6√2), surface area, height and radii from the edge."
    lede="Find the volume of a tetrahedron."
    about="A regular tetrahedron has four equilateral faces. With edge a its volume is a³/(6√2) and its height a√(2/3). An edge of 6 gives a volume of 25.46."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'vol', 'surf', 'h'], 'shape' => 'tetrahedron', 'want' => 'vol']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the volume of a regular tetrahedron with edge 6?', 'answer' => '25.45584412 cm³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a' => 'Edge a', 'vol' => 'Volume V', 'surf' => 'Surface area', 'h' => 'Height']" selected="a" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a" hidden>
            <x-calc.field name="a" label="Edge a" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:vol" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="25.4558" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:surf" hidden>
            <x-calc.field name="surf" label="Surface area (unit²)" value="62.3538" min="0" step="any" />
        </div>
        <div data-show-when="given:h" hidden>
            <x-calc.field name="h" label="Height" value="4.89898" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a', 'unit' => 'cm', 'a' => 6, 'vol' => 25.4558, 'surf' => 62.3538, 'h' => 4.89898],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Edge a'],
            'vol' => ['label' => 'Volume V'],
            'surf' => ['label' => 'Surface area'],
            'face' => ['label' => 'Face area'],
            'h' => ['label' => 'Height'],
            'insr' => ['label' => 'Inscribed sphere radius'],
            'circr' => ['label' => 'Circumscribed sphere radius'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = a³ ÷ (6√2)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
