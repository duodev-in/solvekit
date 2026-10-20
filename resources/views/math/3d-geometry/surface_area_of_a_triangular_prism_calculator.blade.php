<x-calc.page
    title="Surface Area of a Triangular Prism Calculator - SolveKit"
    description="Free surface area of a triangular prism calculator: two triangles plus three rectangles."
    lede="Find a triangular prism's surface area."
    about="Surface = 2 × triangle area + (a + b + c) × L. A prism with a 3-4-5 base and length 10 has 2 × 6 + 12 × 10 = 132."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'b', 'c', 'len', 'baseH'], 'shape' => 'triPrism', 'want' => 'surf']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the surface area of a prism with a 3-4-5 base and length 10?', 'answer' => '132 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a_b_c_len' => 'Base side a, base side b, base side c and prism length L', 'a_baseH_len' => 'Base side a, base height onto a and prism length L']" selected="a_b_c_len" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b_c_len,a_baseH_len" hidden>
            <x-calc.field name="a" label="Base side a" value="3" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b_c_len" hidden>
            <x-calc.field name="b" label="Base side b" value="4" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b_c_len" hidden>
            <x-calc.field name="c" label="Base side c" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b_c_len,a_baseH_len" hidden>
            <x-calc.field name="len" label="Prism length L" value="10" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_baseH_len" hidden>
            <x-calc.field name="baseH" label="Base height onto a" value="4" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Total surface area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a_b_c_len', 'unit' => 'cm', 'a' => 3, 'b' => 4, 'c' => 5, 'len' => 10, 'baseH' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Base side a'],
            'b' => ['label' => 'Base side b'],
            'c' => ['label' => 'Base side c'],
            'len' => ['label' => 'Prism length L'],
            'vol' => ['label' => 'Volume V'],
            'base' => ['label' => 'Base triangle area'],
            'lat' => ['label' => 'Lateral area (3 rectangles)'],
            'surf' => ['label' => 'Total surface area'],
            'baseH' => ['label' => 'Base height onto a'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = 2T + (a + b + c)L</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
