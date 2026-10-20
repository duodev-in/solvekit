<x-calc.page
    title="Cube Calculator - SolveKit"
    description="Free cube calculator: volume, surface area, face and space diagonals from the edge, volume, area or a diagonal."
    lede="Solve a cube."
    about="A cube has 6 square faces, 12 edges and 8 vertices. With edge a: volume a³, surface 6a², face diagonal a√2 and space diagonal a√3. A 3 cm cube holds 27 cm³."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'faceDiag', 'diag', 'vol', 'surf'], 'shape' => 'cube', 'want' => 'vol']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the volume of a cube with edge 3?', 'answer' => '27 cm³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a' => 'Edge a', 'vol' => 'Volume V', 'surf' => 'Surface area A', 'diag' => 'Space diagonal', 'faceDiag' => 'Face diagonal']" selected="a" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a" hidden>
            <x-calc.field name="a" label="Edge a" value="3" min="0" step="any" />
        </div>
        <div data-show-when="given:faceDiag" hidden>
            <x-calc.field name="faceDiag" label="Face diagonal" value="4.24264" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:diag" hidden>
            <x-calc.field name="diag" label="Space diagonal" value="5.19615" min="0" step="any" />
        </div>
        <div data-show-when="given:vol" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="27" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:surf" hidden>
            <x-calc.field name="surf" label="Surface area A (unit²)" value="54" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a', 'unit' => 'cm', 'a' => 3, 'faceDiag' => 4.24264, 'diag' => 5.19615, 'vol' => 27, 'surf' => 54],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Edge a'],
            'faceDiag' => ['label' => 'Face diagonal'],
            'diag' => ['label' => 'Space diagonal'],
            'vol' => ['label' => 'Volume V'],
            'surf' => ['label' => 'Surface area A'],
            'lat' => ['label' => 'Lateral area (4 faces)'],
            'insr' => ['label' => 'Inscribed sphere radius'],
            'circr' => ['label' => 'Circumscribed sphere radius'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = a³</li>
            <li>A = 6a²</li>
            <li>d = a√3</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
