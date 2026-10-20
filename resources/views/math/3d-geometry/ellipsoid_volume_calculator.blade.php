<x-calc.page
    title="Ellipsoid Volume Calculator - SolveKit"
    description="Free ellipsoid volume calculator: V = (4/3)πabc, with the exact surface area."
    lede="Find the volume of an ellipsoid."
    about="An ellipsoid with semi-axes a, b and c has volume (4/3)πabc, a sphere stretched along each axis. Its surface area needs elliptic integrals, evaluated here by numerical integration (exact to about 12 digits). Also known as ellipsoid calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'b', 'c', 'vol'], 'shape' => 'ellipsoid', 'want' => 'vol']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the volume of an ellipsoid with semi-axes 3, 2 and 1?', 'answer' => '25.13274123 cm³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a_b_c' => 'Semi-axis a, semi-axis b and semi-axis c', 'vol_a_b' => 'Volume V, semi-axis a and semi-axis b']" selected="a_b_c" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b_c,vol_a_b" hidden>
            <x-calc.field name="a" label="Semi-axis a" value="3" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b_c,vol_a_b" hidden>
            <x-calc.field name="b" label="Semi-axis b" value="2" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b_c" hidden>
            <x-calc.field name="c" label="Semi-axis c" value="1" min="0" step="any" />
        </div>
        <div data-show-when="given:vol_a_b" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="25.1327" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a_b_c', 'unit' => 'cm', 'a' => 3, 'b' => 2, 'c' => 1, 'vol' => 25.1327],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Semi-axis a'],
            'b' => ['label' => 'Semi-axis b'],
            'c' => ['label' => 'Semi-axis c'],
            'vol' => ['label' => 'Volume V'],
            'surf' => ['label' => 'Surface area A'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = (4/3)πabc</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
