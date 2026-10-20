<x-calc.page
    title="Lateral Area Trapezoidal Prism Calculator - SolveKit"
    description="Free lateral area of a trapezoidal prism calculator: the four rectangular sides, (a + b + c + d) × L."
    lede="Find a trapezoidal prism's lateral area."
    about="The lateral area is the perimeter of the trapezoid times the length. For an isosceles cross-section the legs are √(h² + ((a − b)/2)²)."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'b', 'h', 'legL', 'legR', 'len'], 'shape' => 'trapPrism', 'want' => 'lat']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the lateral area of a prism with bases 6 and 3, height 2 and length 10?', 'answer' => '140 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a_b_h_len' => 'Bottom base a, top base b, trapezoid height h and prism length L', 'a_b_h_legL_legR_len' => 'Bottom base a, top base b, trapezoid height h, left leg, right leg and prism length L']" selected="a_b_h_len" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b_h_len,a_b_h_legL_legR_len" hidden>
            <x-calc.field name="a" label="Bottom base a" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b_h_len,a_b_h_legL_legR_len" hidden>
            <x-calc.field name="b" label="Top base b" value="3" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b_h_len,a_b_h_legL_legR_len" hidden>
            <x-calc.field name="h" label="Trapezoid height h" value="2" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b_h_legL_legR_len" hidden>
            <x-calc.field name="legL" label="Left leg" value="2.5" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b_h_legL_legR_len" hidden>
            <x-calc.field name="legR" label="Right leg" value="2.5" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b_h_len,a_b_h_legL_legR_len" hidden>
            <x-calc.field name="len" label="Prism length L" value="10" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Lateral area (4 rectangles)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a_b_h_len', 'unit' => 'cm', 'a' => 6, 'b' => 3, 'h' => 2, 'legL' => 2.5, 'legR' => 2.5, 'len' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Bottom base a'],
            'b' => ['label' => 'Top base b'],
            'h' => ['label' => 'Trapezoid height h'],
            'legL' => ['label' => 'Left leg'],
            'legR' => ['label' => 'Right leg'],
            'len' => ['label' => 'Prism length L'],
            'vol' => ['label' => 'Volume V'],
            'base' => ['label' => 'Trapezoid area'],
            'lat' => ['label' => 'Lateral area (4 rectangles)'],
            'surf' => ['label' => 'Total surface area'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = (a + b + c + d)L</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
