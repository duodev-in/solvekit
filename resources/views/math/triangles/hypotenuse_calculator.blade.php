<x-calc.page
    title="Hypotenuse Calculator - SolveKit"
    description="Free hypotenuse calculator: c = √(a² + b²) from the legs, or from a leg and an angle."
    lede="Find the hypotenuse."
    about="The hypotenuse is the side opposite the right angle and the longest side. By Pythagoras c = √(a² + b²): legs 6 and 8 give 10. From a leg and its opposite angle, c = a ÷ sin α."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'b', 'c', 'alpha', 'area', 'perim'], 'shape' => 'rightTriangle', 'want' => 'c']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the hypotenuse with legs 6 and 8?', 'answer' => '10 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a_b' => 'Leg a and leg b', 'a_c' => 'Leg a and hypotenuse c', 'b_c' => 'Leg b and hypotenuse c', 'a_alpha' => 'Leg a and angle α (opposite a)', 'b_alpha' => 'Leg b and angle α (opposite a)', 'c_alpha' => 'Hypotenuse c and angle α (opposite a)', 'a_area' => 'Leg a and area', 'c_area' => 'Hypotenuse c and area', 'area_perim' => 'Area and perimeter']" selected="a_b" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b,a_c,a_alpha,a_area" hidden>
            <x-calc.field name="a" label="Leg a" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b,b_c,b_alpha" hidden>
            <x-calc.field name="b" label="Leg b" value="8" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_c,b_c,c_alpha,c_area" hidden>
            <x-calc.field name="c" label="Hypotenuse c" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:a_alpha,b_alpha,c_alpha" hidden>
            <x-calc.field name="alpha" label="Angle α (opposite a) (°)" value="36.8699" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_area,c_area,area_perim" hidden>
            <x-calc.field name="area" label="Area (unit²)" value="24" min="0" step="any" />
        </div>
        <div data-show-when="given:area_perim" hidden>
            <x-calc.field name="perim" label="Perimeter" value="24" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Hypotenuse c" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a_b', 'unit' => 'cm', 'a' => 6, 'b' => 8, 'c' => 10, 'alpha' => 36.8699, 'area' => 24, 'perim' => 24],
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
            <li>c = √(a² + b²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
