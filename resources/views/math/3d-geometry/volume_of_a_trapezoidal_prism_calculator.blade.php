<x-calc.page
    title="Volume of a Trapezoidal Prism Calculator - SolveKit"
    description="Free trapezoidal prism volume calculator: V = (a + b)h ÷ 2 × L, for ditches, dams and troughs."
    lede="Find a trapezoidal prism's volume."
    about="A trapezoidal prism has a trapezoid cross-section: V = ((a + b)/2) × h × L. A ditch 2 m wide at the top, 1 m at the bottom, 0.8 m deep and 50 m long holds 60 m³."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'b', 'h', 'legL', 'legR', 'len'], 'shape' => 'trapPrism', 'want' => 'vol']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How much does a ditch 2 m wide at the top, 1 m at the bottom, 0.8 m deep and 50 m long hold?', 'answer' => '60 m³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a_b_h_len' => 'Bottom base a, top base b, trapezoid height h and prism length L', 'a_b_h_legL_legR_len' => 'Bottom base a, top base b, trapezoid height h, left leg, right leg and prism length L']" selected="a_b_h_len" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="m" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b_h_len,a_b_h_legL_legR_len" hidden>
            <x-calc.field name="a" label="Bottom base a" value="2" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b_h_len,a_b_h_legL_legR_len" hidden>
            <x-calc.field name="b" label="Top base b" value="1" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b_h_len,a_b_h_legL_legR_len" hidden>
            <x-calc.field name="h" label="Trapezoid height h" value="0.8" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b_h_legL_legR_len" hidden>
            <x-calc.field name="legL" label="Left leg" value="0.943398" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b_h_legL_legR_len" hidden>
            <x-calc.field name="legR" label="Right leg" value="0.943398" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b_h_len,a_b_h_legL_legR_len" hidden>
            <x-calc.field name="len" label="Prism length L" value="50" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a_b_h_len', 'unit' => 'm', 'a' => 2, 'b' => 1, 'h' => 0.8, 'legL' => 0.943398, 'legR' => 0.943398, 'len' => 50],
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
            <li>V = (a + b)h ÷ 2 × L</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
