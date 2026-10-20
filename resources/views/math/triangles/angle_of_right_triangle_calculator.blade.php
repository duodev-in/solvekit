<x-calc.page
    title="Angle of Right Triangle Calculator - SolveKit"
    description="Free right triangle angle calculator: the acute angles from two sides with inverse trig."
    lede="Find the angles of a right triangle."
    about="Inverse trigonometry turns side ratios into angles: α = atan(a/b) = asin(a/c). A ramp rising 1 m over 12 m is at 4.76°. The two acute angles add up to 90°."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'b', 'c', 'alpha', 'area', 'perim'], 'shape' => 'rightTriangle', 'want' => 'alpha']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What angle does a ramp make that rises 1 over a run of 12?', 'answer' => '4.763641691 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a_b' => 'Leg a and leg b', 'a_c' => 'Leg a and hypotenuse c', 'b_c' => 'Leg b and hypotenuse c', 'a_alpha' => 'Leg a and angle α (opposite a)', 'b_alpha' => 'Leg b and angle α (opposite a)', 'c_alpha' => 'Hypotenuse c and angle α (opposite a)', 'a_area' => 'Leg a and area', 'c_area' => 'Hypotenuse c and area', 'area_perim' => 'Area and perimeter']" selected="a_b" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="m" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b,a_c,a_alpha,a_area" hidden>
            <x-calc.field name="a" label="Leg a" value="1" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b,b_c,b_alpha" hidden>
            <x-calc.field name="b" label="Leg b" value="12" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_c,b_c,c_alpha,c_area" hidden>
            <x-calc.field name="c" label="Hypotenuse c" value="12.0416" min="0" step="any" />
        </div>
        <div data-show-when="given:a_alpha,b_alpha,c_alpha" hidden>
            <x-calc.field name="alpha" label="Angle α (opposite a) (°)" value="4.76364" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_area,c_area,area_perim" hidden>
            <x-calc.field name="area" label="Area (unit²)" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:area_perim" hidden>
            <x-calc.field name="perim" label="Perimeter" value="25.0416" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Angle α (opposite a)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a_b', 'unit' => 'm', 'a' => 1, 'b' => 12, 'c' => 12.0416, 'alpha' => 4.76364, 'area' => 6, 'perim' => 25.0416],
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
            <li>α = atan(a ÷ b)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
