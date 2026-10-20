<x-calc.page
    title="Cube Edge and Diagonal Calculator - SolveKit"
    description="Free cube calculator: find the edge and space diagonal from the volume (or the volume from the diagonal)."
    lede="Find the edge of a cube from its volume."
    about="The edge is the cube root of the volume: a 1-litre (1,000 cm³) cube has 10 cm edges and a space diagonal of 17.32 cm. From the diagonal, a = d/√3."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'faceDiag', 'diag', 'vol', 'surf'], 'shape' => 'cube', 'want' => 'a']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What edge does a 1,000 cm³ cube have?', 'answer' => '10 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a' => 'Edge a', 'vol' => 'Volume V', 'surf' => 'Surface area A', 'diag' => 'Space diagonal', 'faceDiag' => 'Face diagonal']" selected="vol" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a" hidden>
            <x-calc.field name="a" label="Edge a" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:faceDiag" hidden>
            <x-calc.field name="faceDiag" label="Face diagonal" value="14.1421" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:diag" hidden>
            <x-calc.field name="diag" label="Space diagonal" value="17.3205" min="0" step="any" />
        </div>
        <div data-show-when="given:vol" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="1000" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:surf" hidden>
            <x-calc.field name="surf" label="Surface area A (unit²)" value="600" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Edge a" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'vol', 'unit' => 'cm', 'a' => 10, 'faceDiag' => 14.1421, 'diag' => 17.3205, 'vol' => 1000, 'surf' => 600],
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
            <li>a = ∛V</li>
            <li>d = a√3</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
