<x-calc.page
    title="Pythagorean Theorem Calculator - SolveKit"
    description="Free Pythagorean theorem calculator: find any side of a right triangle with a² + b² = c²."
    lede="Use Pythagoras' theorem."
    about="In every right triangle the squares on the legs add up to the square on the hypotenuse: a² + b² = c². Give any two sides to find the third: legs 5 and 12 give hypotenuse 13; hypotenuse 13 and leg 5 give the other leg 12. Also known as Pythagoras triangle calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'b', 'c'], 'shape' => 'rightTriangle', 'want' => 'c']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the hypotenuse with legs 5 and 12?', 'answer' => '13 cm.'],
        ['question' => 'And the leg when c = 13 and a = 5?', 'answer' => '12 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a_b' => 'Leg a and leg b', 'a_c' => 'Leg a and hypotenuse c', 'b_c' => 'Leg b and hypotenuse c']" selected="a_b" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b,a_c" hidden>
            <x-calc.field name="a" label="Leg a" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b,b_c" hidden>
            <x-calc.field name="b" label="Leg b" value="12" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_c,b_c" hidden>
            <x-calc.field name="c" label="Hypotenuse c" value="13" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Hypotenuse c" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a_b', 'unit' => 'cm', 'a' => 5, 'b' => 12, 'c' => 13],
        'Leg' => ['given' => 'a_c', 'unit' => 'cm', 'a' => 5, 'b' => 12, 'c' => 13],
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
            <li>a² + b² = c²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
