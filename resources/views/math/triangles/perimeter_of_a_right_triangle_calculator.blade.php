<x-calc.page
    title="Perimeter of a Right Triangle Calculator - SolveKit"
    description="Free perimeter of a right triangle calculator: P = a + b + c with the missing side found by Pythagoras."
    lede="Find the perimeter of a right triangle."
    about="Add the three sides; if one is missing, Pythagoras supplies it. Legs 3 and 4 give hypotenuse 5 and perimeter 12."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'b', 'c', 'alpha', 'area', 'perim'], 'shape' => 'rightTriangle', 'want' => 'perim']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the perimeter of a right triangle with legs 3 and 4?', 'answer' => '12 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a_b' => 'Leg a and leg b', 'a_c' => 'Leg a and hypotenuse c', 'b_c' => 'Leg b and hypotenuse c', 'a_alpha' => 'Leg a and angle α (opposite a)', 'b_alpha' => 'Leg b and angle α (opposite a)', 'c_alpha' => 'Hypotenuse c and angle α (opposite a)', 'a_area' => 'Leg a and area', 'c_area' => 'Hypotenuse c and area', 'area_perim' => 'Area and perimeter']" selected="a_b" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b,a_c,a_alpha,a_area" hidden>
            <x-calc.field name="a" label="Leg a" value="3" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b,b_c,b_alpha" hidden>
            <x-calc.field name="b" label="Leg b" value="4" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_c,b_c,c_alpha,c_area" hidden>
            <x-calc.field name="c" label="Hypotenuse c" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:a_alpha,b_alpha,c_alpha" hidden>
            <x-calc.field name="alpha" label="Angle α (opposite a) (°)" value="36.8699" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_area,c_area,area_perim" hidden>
            <x-calc.field name="area" label="Area (unit²)" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:area_perim" hidden>
            <x-calc.field name="perim" label="Perimeter" value="12" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Perimeter" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a_b', 'unit' => 'cm', 'a' => 3, 'b' => 4, 'c' => 5, 'alpha' => 36.8699, 'area' => 6, 'perim' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Leg a'],
            'b' => ['label' => 'Leg b'],
            'c' => ['label' => 'Hypotenuse c'],
            'alpha' => ['label' => 'Angle α (opposite a)'],
            'beta' => ['label' => 'Angle β (opposite b)'],
            'area' => ['label' => 'Area'],
            'perim' => ['label' => 'Perimeter'],
            'h' => ['label' => 'Height to the hypotenuse'],
            'inr' => ['label' => 'Inradius'],
            'circr' => ['label' => 'Circumradius'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = a + b + √(a² + b²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
